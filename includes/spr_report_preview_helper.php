<?php

/**
 * Preview helper สำหรับ report_spr.php (PDF ใบเบิกเครื่องและอะไหล่)
 *
 * ให้ใบพิมพ์ render จากค่าที่ POST มาจากฟอร์ม register_engspr.php ได้ทันที โดยไม่ต้อง
 * บันทึกลงฐานก่อน — โครงเดียวกับ report_breg_preview_helper.php (ดู includes/spr_repo.php
 * สำหรับที่มาของ field ต่าง ๆ)
 *
 * โหมด Preview ต้องไม่ INSERT/UPDATE/DELETE อะไรทั้งสิ้น
 */

function spr_report_is_preview_request()
{
	return ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST'
		&& isset($_POST['_report_preview'])
		&& $_POST['_report_preview'] === '1';
}

function spr_report_preview_value($key, $default = '')
{
	if (!isset($_POST[$key]) || is_array($_POST[$key])) {
		return $default;
	}
	return trim((string)$_POST[$key]);
}

/**
 * รายละเอียดสินค้าที่ใบพิมพ์ต้องใช้ (ชื่อที่แสดงในใบพิมพ์ + หน่วย) อ่านจาก tb_product
 * เหมือนโหมดปกติที่ JOIN มา — access_name คือคอลัมน์ที่ report_spr.php ใช้แสดงผลจริง
 * (ไม่ใช่ sol_name ที่ฟอร์มกรอกใช้แสดงผล)
 */
function spr_report_preview_product($conn, $productId)
{
	static $cache = array();
	$productId = (int)$productId;
	if ($productId <= 0) {
		return array();
	}
	if (isset($cache[$productId])) {
		return $cache[$productId];
	}

	$sql = "SELECT access_name, unit_name FROM tb_product WHERE product_ID = '"
		. mysqli_real_escape_string($conn, (string)$productId) . "' LIMIT 1";
	$query = @mysqli_query($conn, $sql);
	$row = $query ? mysqli_fetch_assoc($query) : null;
	$cache[$productId] = $row ? $row : array();
	return $cache[$productId];
}

/**
 * รายการสินค้าจาก POST (items[n][...] — ดู spr_collect_items_from_post()) แปลงเป็น
 * รูปเดียวกับที่โหมดปกติ (JOIN DB) ให้ report_spr.php ใช้ key เดียวกันได้ทั้งสองโหมด
 */
function spr_report_preview_items($conn)
{
	require_once __DIR__ . '/spr_repo.php';
	$rows = spr_collect_items_from_post();

	$out = array();
	foreach ($rows as $row) {
		$product = spr_report_preview_product($conn, $row['product_id']);
		$out[] = array(
			'access_name' => $product['access_name'] ?? '',
			'unit_name'   => $product['unit_name'] ?? '',
			'sale_count'  => $row['sale_count'],
			'unit_price'  => $row['unit_price'],
			'sum_amount'  => $row['sum_amount'],
			'sale_remark' => $row['sale_remark'],
		);
	}
	return $out;
}

/**
 * หัวเอกสารจาก POST — คีย์ตรงกับคอลัมน์ hos__spr ที่ report_spr.php อ่าน ช่องที่ยังไม่มี
 * ค่าตอนพรีวิว (ผู้อนุมัติ/คลังสินค้า/ลายเซ็น) คงเป็นค่าว่างตามความจริงของเอกสารที่ยัง
 * ไม่ผ่านขั้นตอนนั้น ไม่ใช่บั๊ก
 */
function spr_report_build_preview_context($conn)
{
	require_once __DIR__ . '/spr_repo.php';
	$header = spr_header_from_post($_SESSION ?? array());

	$savedRefId = spr_report_preview_value('ref_id');
	$original = null;
	if ($savedRefId !== '') {
		$original = spr_load_document($conn, $savedRefId);
		if ($original === null) {
			throw new SprValidationException('ไม่พบเอกสารที่ต้องการแสดงตัวอย่าง');
		}
	}

	// ใบใหม่ยังไม่มีเลขจริง — ใช้เลขคาดการณ์ที่หน้าฟอร์มแสดงอยู่เพื่อให้พรีวิวอ่านรู้เรื่อง
	$refId = $savedRefId !== '' ? $savedRefId : spr_report_preview_value('ref_id_preview');
	$sprNo = $original !== null ? (string)$original['spr_no'] : (((int)$header['type_company'] === 2) ? 'SPRNB' : 'SPR') . ' (ยังไม่บันทึก)';

	// เอกสารเดิมเป็น baseline ของข้อมูล lifecycle ที่เซิร์ฟเวอร์ควบคุม (ผู้อนุมัติ/วันที่อนุมัติ/
	// คลังสินค้า ฯลฯ) — ฟอร์มสด overlay ได้แค่ฟิลด์ที่แก้ไขได้เอง ใบใหม่ใช้ค่าว่างเหมือนเดิม
	$lifecycleDefaults = array(
		'sup_name' => '', 'sup_date' => '0000-00-00 00:00:00',
		'send_cm' => '0', 'cm_name' => '', 'cm_date' => '0000-00-00 00:00:00', 'comment_cm' => '',
		'stock_print' => '0', 'stock_date' => '0000-00-00', 'stock_name' => '',
	);
	$lifecycle = $lifecycleDefaults;
	if ($original !== null) {
		foreach ($lifecycleDefaults as $field => $default) {
			$lifecycle[$field] = $original[$field] ?? $default;
		}
	}

	$row = array_merge($lifecycle, array(
		'ref_id'       => $refId,
		'spr_no'       => $sprNo,
		'spr_date'     => $header['spr_date'],
		'customer'     => $header['customer'],
		'address'      => $header['address'],
		'type_company' => (string)$header['type_company'],
		'wo_no'        => $header['wo_no'],
		'equipment'    => $header['equipment'],
		'sn_num'       => $header['sn_num'],
		'sn_ckk'       => $header['sn_ckk'],
		'engineer'     => $header['engineer'],
		'per_no'       => $header['per_no'],
		'clear_brn'    => $header['clear_brn'],
		'brn_no'       => $header['brn_no'],
		'clear_brnp'   => $header['clear_brnp'],
		'brnp_no'      => $header['brnp_no'],
		'clear_epe'    => $header['clear_epe'],
		'epe_no'       => $header['epe_no'],
		'pro_ckk'      => $header['pro_ckk'],
		'pro_des'      => $header['pro_des'],
		'engineer_date' => $header['engineer_date'],
		'date_receive' => $header['date_receive'],
		'date_imstall' => $header['date_imstall'],
		'date_exp'     => $header['date_exp'],
		'status_doc'   => $original !== null ? (string)$original['status_doc'] : 'Draft',
	));

	return array(
		'header' => $row,
		'items'  => spr_report_preview_items($conn),
	);
}
