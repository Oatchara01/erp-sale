<?php

/**
 * ยอดคงเหลือและการปิด/เปิดใบจอง (hos__jongproduct / hos__subjongpro) ที่ถูกดึงไปออกใบสั่งขาย
 *
 * ใช้ร่วมกันโดย
 *   - register_suphos1.php / register_suphos_edit1.php (ตรวจยอดก่อนบันทึก + ปรับสถานะใบจองหลังบันทึก)
 *   - status_price_save.php                            (คืนยอดเมื่อยกเลิกใบสั่งขาย)
 *   - ajax_clear_loan_popup_search.php                 (แสดงยอดคงเหลือใน popup เคลียร์จอง/ยืม)
 *
 * กติกา
 *   - แถว hos__subso ที่ jong_ckk='1' และ jong_no = เลขที่ใบจอง "กินยอดจอง" เมื่อใบสั่งขายของแถวนั้น
 *     ไม่ได้อยู่ในสถานะ Draft / Rejected / ยกเลิก (Request, Returned, Approve กินยอดทั้งหมด)
 *   - so__submain นับเฉพาะ status_sol='Approve' ตาม logic เดิม
 *   - ใบจองปิดเมื่อรายการสินค้าทุกตัวถูกใช้ครบ และเปิดคืนเมื่อใบสั่งขาย "คืนยอด"
 *     (ไม่อนุมัติ / ยกเลิก / ลบแถว / ลดจำนวน) โดยไม่แยกว่าใบจองถูกปิดอัตโนมัติหรือปิดด้วยมือ
 */

if (!defined('JONG_AUTO_CLOSE_REMARK')) {
	define('JONG_AUTO_CLOSE_REMARK', 'เปิดใบสั่งขายเลขที่อ้างอิง');
	define('JONG_QTY_EPSILON', 0.00001);
}

if (!function_exists('jong_non_holding_so_statuses')) {
	/** สถานะใบสั่งขายที่ไม่กินยอดจอง */
	function jong_non_holding_so_statuses()
	{
		return array('Draft', 'Rejected', 'ยกเลิก');
	}
}

if (!function_exists('jong_qty')) {
	function jong_qty($value)
	{
		return (float)str_replace(',', '', trim((string)$value));
	}
}

if (!function_exists('jong_format_qty')) {
	function jong_format_qty($value)
	{
		$text = number_format((float)$value, 2, '.', '');
		return rtrim(rtrim($text, '0'), '.');
	}
}

if (!function_exists('jong_find_by_iv_no')) {
	function jong_find_by_iv_no($conn, $ivNo)
	{
		$ivNo = trim((string)$ivNo);
		if ($ivNo === '') {
			return null;
		}

		$query = mysqli_query($conn, "SELECT ref_id, iv_no, close_jong, cancel_ckk, status_doc, remark FROM hos__jongproduct WHERE iv_no = '" . mysqli_real_escape_string($conn, $ivNo) . "' LIMIT 1");
		$row = $query ? mysqli_fetch_assoc($query) : null;

		return $row ? $row : null;
	}
}

if (!function_exists('jong_reserved_map')) {
	/** @return array<string,float> product_id => จำนวนที่จอง */
	function jong_reserved_map($conn, $jongRefId)
	{
		$map = array();
		$query = mysqli_query($conn, "SELECT product_id, SUM(`count`) AS qty FROM hos__subjongpro WHERE ref_idd = '" . mysqli_real_escape_string($conn, (string)$jongRefId) . "' GROUP BY product_id");
		if ($query) {
			while ($row = mysqli_fetch_assoc($query)) {
				$map[(string)$row['product_id']] = (float)$row['qty'];
			}
		}

		return $map;
	}
}

if (!function_exists('jong_used_map')) {
	/**
	 * @param array  $productIds   สินค้าในใบจอง — ต้องระบุเสมอ เพราะ so__submain (หลักล้านแถว) ไม่มี index ที่ jong_no
	 *                             ถ้าไม่กรอง product_id จะกลายเป็น scan ทั้งตาราง
	 * @param string $excludeSoRef ใบสั่งขายที่ไม่ต้องนับ (ใช้ตอนตรวจยอดของใบที่กำลังบันทึกเอง)
	 * @return array<string,float> product_id => จำนวนที่ถูกใช้ไปแล้ว
	 */
	function jong_used_map($conn, $ivNo, array $productIds, $excludeSoRef = '')
	{
		$map = array();
		$ivNo = trim((string)$ivNo);
		if ($ivNo === '' || empty($productIds)) {
			return $map;
		}

		$safeIvNo = mysqli_real_escape_string($conn, $ivNo);
		$productList = array();
		foreach ($productIds as $productId) {
			$productList[] = "'" . mysqli_real_escape_string($conn, (string)$productId) . "'";
		}
		$productList = implode(',', $productList);
		$statuses = array();
		foreach (jong_non_holding_so_statuses() as $status) {
			$statuses[] = "'" . mysqli_real_escape_string($conn, $status) . "'";
		}

		$sql = "SELECT s.product_id, SUM(s.`count`) AS qty
			FROM hos__subso s
			INNER JOIN hos__so h ON h.ref_id = s.ref_idd
			WHERE s.jong_ckk = '1' AND s.jong_no = '" . $safeIvNo . "'
			AND s.product_id IN (" . $productList . ")
			AND h.status_doc NOT IN (" . implode(',', $statuses) . ")";
		if ((string)$excludeSoRef !== '') {
			$sql .= " AND s.ref_idd <> '" . mysqli_real_escape_string($conn, (string)$excludeSoRef) . "'";
		}
		$sql .= " GROUP BY s.product_id";

		$query = mysqli_query($conn, $sql);
		if ($query) {
			while ($row = mysqli_fetch_assoc($query)) {
				$map[(string)$row['product_id']] = (float)$row['qty'];
			}
		}

		$query = mysqli_query($conn, "SELECT product_id, SUM(sale_count) AS qty FROM so__submain WHERE product_id IN (" . $productList . ") AND jong_ckk = '1' AND jong_no = '" . $safeIvNo . "' AND status_sol = 'Approve' GROUP BY product_id");
		if ($query) {
			while ($row = mysqli_fetch_assoc($query)) {
				$productId = (string)$row['product_id'];
				$map[$productId] = ($map[$productId] ?? 0) + (float)$row['qty'];
			}
		}

		return $map;
	}
}

if (!function_exists('jong_remaining_map')) {
	/**
	 * @param array $jong แถวใบจองที่มี ref_id และ iv_no
	 * @return array<string,float> product_id => ยอดคงเหลือ (ติดลบได้ถ้าข้อมูลเดิมถูกใช้เกิน)
	 */
	function jong_remaining_map($conn, array $jong, $excludeSoRef = '')
	{
		$remaining = array();
		$reservedMap = jong_reserved_map($conn, $jong['ref_id'] ?? '');
		$used = jong_used_map($conn, $jong['iv_no'] ?? '', array_keys($reservedMap), $excludeSoRef);
		foreach ($reservedMap as $productId => $reserved) {
			$remaining[$productId] = $reserved - ($used[$productId] ?? 0);
		}

		return $remaining;
	}
}

if (!function_exists('jong_post_demand')) {
	/**
	 * ยอดที่ฟอร์มใบสั่งขายกำลังจะดึงจากใบจอง อ่านจาก POST ก่อนบันทึกจริง
	 *
	 * @return array<string,array<string,float>> เลขที่ใบจอง => product_id => จำนวน
	 */
	function jong_post_demand(array $post)
	{
		$demand = array();
		$add = function ($jongCkk, $ivNo, $productId, $qty) use (&$demand) {
			$ivNo = trim((string)$ivNo);
			$productId = trim((string)$productId);
			if ((string)$jongCkk !== '1' || $ivNo === '' || $productId === '') {
				return;
			}
			$demand[$ivNo][$productId] = ($demand[$ivNo][$productId] ?? 0) + jong_qty($qty);
		};

		// ฟอร์มรุ่นเก่าส่งแถวเดิมมาเป็น id[] ส่วนช่อง product_id1..30 คือแถวใหม่
		// ฟอร์ม register_suphos.php ส่งทุกแถวเป็นช่อง 1..30 จึงไม่มี id[] ณ จุดนี้
		if (isset($post['id']) && is_array($post['id'])) {
			$deletedIds = (isset($post['deleted_subso_ids']) && is_array($post['deleted_subso_ids'])) ? array_map('strval', $post['deleted_subso_ids']) : array();
			foreach ($post['id'] as $key => $value) {
				if (in_array((string)$value, $deletedIds, true)) {
					continue;
				}
				$add($post['jong_ckk'][$key] ?? '', $post['jong_no'][$key] ?? '', $post['product_id'][$key] ?? '', $post['sale_count'][$key] ?? '');
			}
		}

		for ($i = 1; $i <= 30; $i++) {
			if ((string)($post['row_deleted' . $i] ?? '') === '1') {
				continue;
			}
			$add($post['jong_ckk' . $i] ?? '', $post['jong_no' . $i] ?? '', $post['product_id' . $i] ?? '', $post['sale_count' . $i] ?? '');
		}

		return $demand;
	}
}

if (!function_exists('jong_find_shortages')) {
	/**
	 * @param array $demand ผลจาก jong_post_demand()
	 * @return array<int,array{iv_no:string,product_id:string,requested:float,remaining:float}>
	 */
	function jong_find_shortages($conn, array $demand, $excludeSoRef = '')
	{
		$shortages = array();
		foreach ($demand as $ivNo => $products) {
			$jong = jong_find_by_iv_no($conn, $ivNo);
			// ใบจองที่หาไม่เจอหรือถูกยกเลิกไม่มียอดให้เทียบ — ไม่บล็อก เพื่อไม่ให้เอกสารเดิมที่ผูกไว้บันทึกไม่ได้
			if ($jong === null || (string)$jong['cancel_ckk'] === '1') {
				continue;
			}

			$remaining = jong_remaining_map($conn, $jong, $excludeSoRef);
			foreach ($products as $productId => $requested) {
				// สินค้าที่ไม่อยู่ในใบจองใบนี้ไม่ถือว่าดึงยอดจอง
				if (!array_key_exists((string)$productId, $remaining)) {
					continue;
				}
				$left = max(0, $remaining[(string)$productId]);
				if ($requested > $left + JONG_QTY_EPSILON) {
					$shortages[] = array(
						'iv_no' => (string)$ivNo,
						'product_id' => (string)$productId,
						'requested' => (float)$requested,
						'remaining' => (float)$left
					);
				}
			}
		}

		return $shortages;
	}
}

if (!function_exists('jong_shortage_message')) {
	function jong_shortage_message($conn, array $shortages)
	{
		$lines = array('จำนวนสินค้าเกินยอดคงเหลือของใบจอง');
		foreach ($shortages as $shortage) {
			$label = $shortage['product_id'];
			$query = mysqli_query($conn, "SELECT access_code, sol_name FROM tb_product WHERE product_ID = '" . mysqli_real_escape_string($conn, $shortage['product_id']) . "' LIMIT 1");
			$product = $query ? mysqli_fetch_assoc($query) : null;
			if ($product) {
				$label = trim(trim((string)$product['access_code']) . ' ' . trim((string)$product['sol_name']));
				if ($label === '') {
					$label = $shortage['product_id'];
				}
			}
			$lines[] = '- ใบจอง ' . $shortage['iv_no'] . ' : ' . $label
				. ' ต้องการ ' . jong_format_qty($shortage['requested'])
				. ' คงเหลือ ' . jong_format_qty($shortage['remaining']);
		}

		return implode("\n", $lines);
	}
}

if (!function_exists('jong_so_holdings')) {
	/**
	 * ยอดจองที่ใบสั่งขายใบนี้ถืออยู่ ณ ตอนนี้ (ว่างถ้าใบสั่งขายอยู่ในสถานะที่ไม่กินยอด)
	 *
	 * @return array<string,array<string,float>> เลขที่ใบจอง => product_id => จำนวน
	 */
	function jong_so_holdings($conn, $soRef)
	{
		$holdings = array();
		$safeSoRef = mysqli_real_escape_string($conn, (string)$soRef);
		if ($safeSoRef === '') {
			return $holdings;
		}

		$query = mysqli_query($conn, "SELECT status_doc FROM hos__so WHERE ref_id = '" . $safeSoRef . "' LIMIT 1");
		$so = $query ? mysqli_fetch_assoc($query) : null;
		if (!$so || in_array((string)$so['status_doc'], jong_non_holding_so_statuses(), true)) {
			return $holdings;
		}

		$query = mysqli_query($conn, "SELECT jong_no, product_id, SUM(`count`) AS qty FROM hos__subso WHERE ref_idd = '" . $safeSoRef . "' AND jong_ckk = '1' AND jong_no <> '' GROUP BY jong_no, product_id");
		if ($query) {
			while ($row = mysqli_fetch_assoc($query)) {
				$holdings[(string)$row['jong_no']][(string)$row['product_id']] = (float)$row['qty'];
			}
		}

		return $holdings;
	}
}

if (!function_exists('jong_sync_reservation')) {
	/**
	 * ปรับ close_ckk ของรายการสินค้าและ close_jong ของใบจองให้ตรงกับยอดคงเหลือ
	 *
	 * @param array $releasedProductIds สินค้าที่ใบสั่งขายเพิ่งคืนยอด — เฉพาะรายการเหล่านี้ที่ถูกเปิดคืน
	 */
	function jong_sync_reservation($conn, $ivNo, $soRef, array $releasedProductIds = array())
	{
		$jong = jong_find_by_iv_no($conn, $ivNo);
		if ($jong === null || (string)$jong['cancel_ckk'] === '1') {
			return;
		}

		$safeJongRef = mysqli_real_escape_string($conn, (string)$jong['ref_id']);
		$releasedProductIds = array_map('strval', $releasedProductIds);
		$remaining = jong_remaining_map($conn, $jong);
		if (empty($remaining)) {
			return;
		}

		foreach ($remaining as $productId => $left) {
			$safeProductId = mysqli_real_escape_string($conn, (string)$productId);
			if ($left <= JONG_QTY_EPSILON) {
				mysqli_query($conn, "UPDATE hos__subjongpro SET close_ckk = '1' WHERE ref_idd = '" . $safeJongRef . "' AND product_id = '" . $safeProductId . "'");
			} elseif (in_array((string)$productId, $releasedProductIds, true)) {
				mysqli_query($conn, "UPDATE hos__subjongpro SET close_ckk = '0' WHERE ref_idd = '" . $safeJongRef . "' AND product_id = '" . $safeProductId . "'");
			}
		}

		$query = mysqli_query($conn, "SELECT COUNT(*) AS open_lines FROM hos__subjongpro WHERE ref_idd = '" . $safeJongRef . "' AND COALESCE(close_ckk, '0') <> '1'");
		$row = $query ? mysqli_fetch_assoc($query) : null;
		$openLines = $row ? (int)$row['open_lines'] : 0;

		if ($openLines === 0) {
			if ((string)$jong['close_jong'] !== '1') {
				$remark = JONG_AUTO_CLOSE_REMARK . ' ' . $soRef;
				mysqli_query($conn, "UPDATE hos__jongproduct SET close_jong = '1', remark = '" . mysqli_real_escape_string($conn, $remark) . "' WHERE ref_id = '" . $safeJongRef . "'");
			}
			return;
		}

		// เปิดคืนเฉพาะตอนที่มีการคืนยอดจริง และเฉพาะใบจองที่อนุมัติแล้ว (ใบที่ถูกไม่อนุมัติก็มี close_jong='1')
		if (!empty($releasedProductIds) && (string)$jong['close_jong'] === '1' && (string)$jong['status_doc'] === 'Approve') {
			$remarkSql = (strpos((string)$jong['remark'], JONG_AUTO_CLOSE_REMARK) === 0) ? ", remark = ''" : '';
			mysqli_query($conn, "UPDATE hos__jongproduct SET close_jong = '0'" . $remarkSql . " WHERE ref_id = '" . $safeJongRef . "'");
		}
	}
}

if (!function_exists('jong_apply_so_change')) {
	/**
	 * เรียกหลังบันทึกใบสั่งขายเสร็จ เทียบยอดที่ถือก่อน/หลังบันทึกแล้วปรับสถานะใบจองที่เกี่ยวข้อง
	 *
	 * @param array $before ผลจาก jong_so_holdings() ก่อนบันทึก (array ว่างสำหรับใบสั่งขายที่เพิ่งสร้าง)
	 */
	function jong_apply_so_change($conn, $soRef, array $before)
	{
		$after = jong_so_holdings($conn, $soRef);
		$ivNos = array_unique(array_merge(array_keys($before), array_keys($after)));

		foreach ($ivNos as $ivNo) {
			$released = array();
			foreach (($before[$ivNo] ?? array()) as $productId => $qty) {
				if (($after[$ivNo][$productId] ?? 0) < $qty - JONG_QTY_EPSILON) {
					$released[] = (string)$productId;
				}
			}
			jong_sync_reservation($conn, (string)$ivNo, $soRef, $released);
		}
	}
}
