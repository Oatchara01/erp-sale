<?php
// ยอดใบสั่งขายที่ออกจากเอกสารเช่า (IV = ค่าเช่า/ค่าจัดส่ง, AI = เงินประกัน) และการซิงก์ SO ตามใบเช่า
// ใช้ร่วมกันระหว่าง register_suphos.php (prefill ตอนออก SO จาก ?from_rental=...) และ
// register_suprental_edit1.php (ซิงก์ SO ที่ออกไปแล้วทุกครั้งที่บันทึกใบเช่า) เพื่อให้สูตรยอดมีที่เดียว

if (!function_exists('rental_so_query')) {
	function rental_so_query($conn, $sql)
	{
		$result = mysqli_query($conn, $sql);
		if ($result === false) {
			throw new mysqli_sql_exception('rental_so_sync: ' . mysqli_error($conn));
		}
		return $result;
	}
}

if (!function_exists('rental_so_expected_lines')) {
	/**
	 * ยอดของแถวรหัสหลักใน SO ที่ควรเป็นตามใบเช่าปัจจุบัน
	 * IV: 5112 = ค่าเช่า SUM(hos__subrental.amount), 3200 = ค่าจัดส่ง (delivery_cost แถวแรก — ห้าม SUM
	 *     เพราะค่านี้ถูกเก็บซ้ำทุกแถวสินค้าในใบเช่า ไม่ใช่ค่าต่อแถว)
	 * AI: 5111 = hos__rental.deposit_amount (NULL = เอกสารเก่า ใช้ SUM(amount) x 2)
	 *
	 * @return array<string,float> product_id => ยอด
	 */
	function rental_so_expected_lines($conn, $rentalRefId, $type)
	{
		$safeRefId = mysqli_real_escape_string($conn, (string)$rentalRefId);

		$feeSumRow = mysqli_fetch_assoc(rental_so_query($conn, "SELECT SUM(COALESCE(amount, 0)) AS fee_sum FROM hos__subrental WHERE ref_idd = '" . $safeRefId . "'"));
		$feeSum = $feeSumRow ? (float)$feeSumRow["fee_sum"] : 0;

		if ($type === "AI") {
			$depositRow = mysqli_fetch_assoc(rental_so_query($conn, "SELECT deposit_amount FROM hos__rental WHERE ref_id = '" . $safeRefId . "' LIMIT 1"));
			if ($depositRow && $depositRow["deposit_amount"] !== null) {
				return array('5111' => (float)$depositRow["deposit_amount"]);
			}
			return array('5111' => $feeSum * 2);
		}

		if ($type === "IV") {
			$deliveryRow = mysqli_fetch_assoc(rental_so_query($conn, "SELECT delivery_cost FROM hos__subrental WHERE ref_idd = '" . $safeRefId . "' ORDER BY id_sub ASC LIMIT 1"));
			return array(
				'5112' => $feeSum,
				'3200' => $deliveryRow ? (float)$deliveryRow["delivery_cost"] : 0,
			);
		}

		return array();
	}
}

if (!function_exists('rental_so_sync')) {
	/**
	 * ซิงก์แถวรหัสหลักของ SO ที่ผูกกับใบเช่า (hos__rental.ref_iv / ref_ai) ให้ตรงกับยอดในใบเช่า
	 * - ข้าม SO ระบบเก่า (so__main — เลขไม่ขึ้นต้น SO) และ SO ที่ยกเลิกแล้วแบบเงียบๆ
	 * - ไม่ซิงก์ถ้าออกใบกำกับแล้ว (iv_no มีเลขที่ ไม่ใช่แค่ prefix IV/IC) หรือบันทึกรับเงินแล้ว (invoice_receipt.tb_register_data.summary_cash)
	 *   แต่รายงานเป็น skipped ให้ผู้ใช้ไปแก้ SO เอง
	 * - แตะเฉพาะแถว 5112/3200 (IV) หรือ 5111 (AI) ที่มีอยู่แถวเดียว แถวที่ผู้ใช้ลบทิ้งไปแล้วไม่เพิ่มกลับ
	 * - รายงานเฉพาะ SO ที่ยอดต่างจากใบเช่าจริง
	 * ต้องเรียกภายใน transaction ของการบันทึกใบเช่า — query พังจะ throw mysqli_sql_exception ให้ rollback ทั้งก้อน
	 *
	 * @param mysqli      $conn     allwell_sol_test (hos__rental, hos__subrental, hos__so, hos__subso)
	 * @param mysqli|null $accConn  invoice_receipt (tb_register_data.summary_cash)
	 * @return array{updated: string[], skipped: array<int, array{so: string, reason: string}>}
	 */
	function rental_so_sync($conn, $accConn, $rentalRefId)
	{
		$outcome = array('updated' => array(), 'skipped' => array());
		$safeRentalRefId = mysqli_real_escape_string($conn, (string)$rentalRefId);

		$rentalRow = mysqli_fetch_assoc(rental_so_query($conn, "SELECT ref_iv, ref_ai FROM hos__rental WHERE ref_id = '" . $safeRentalRefId . "' LIMIT 1"));
		if (!$rentalRow) {
			return $outcome;
		}

		$targets = array(
			'IV' => str_replace(' ', '', (string)($rentalRow["ref_iv"] ?? '')),
			'AI' => str_replace(' ', '', (string)($rentalRow["ref_ai"] ?? '')),
		);

		foreach ($targets as $type => $soRefId) {
			if ($soRefId === '' || substr($soRefId, 0, 2) !== 'SO') {
				continue;
			}
			$safeSoRefId = mysqli_real_escape_string($conn, $soRefId);

			$soRow = mysqli_fetch_assoc(rental_so_query($conn, "SELECT status_doc, iv_no FROM hos__so WHERE ref_id = '" . $safeSoRefId . "' LIMIT 1"));
			if (!$soRow || trim((string)$soRow["status_doc"]) === 'ยกเลิก') {
				continue;
			}

			$expectedLines = rental_so_expected_lines($conn, $rentalRefId, $type);
			$productIdList = "'" . implode("','", array_keys($expectedLines)) . "'";
			$lineQuery = rental_so_query($conn, "SELECT id, product_id, count, price, price_ref, discount, amount FROM hos__subso WHERE ref_idd = '" . $safeSoRefId . "' AND product_id IN (" . $productIdList . ") AND COALESCE(bom_ckk, '0') <> '1' ORDER BY sort_order, id");

			$linesByProduct = array();
			while ($lineRow = mysqli_fetch_assoc($lineQuery)) {
				$linesByProduct[(string)$lineRow["product_id"]][] = $lineRow;
			}

			$pendingUpdates = array();
			$ambiguousCodes = array();
			foreach ($expectedLines as $productId => $expectedAmount) {
				$rows = $linesByProduct[(string)$productId] ?? array();
				if (count($rows) === 0) {
					continue;
				}

				$expected = round((float)$expectedAmount, 2);
				$row = $rows[0];
				$isInSync = round((float)$row["amount"], 2) === $expected
					&& round((float)$row["price"], 2) === $expected
					&& round((float)$row["price_ref"], 2) === $expected
					&& round((float)$row["count"], 2) === 1.0
					&& round((float)$row["discount"], 2) === 0.0;

				if (count($rows) > 1) {
					// รหัสเดียวกันหลายแถว ไม่รู้ว่าควรแก้แถวไหน รายงานเฉพาะตอนยอดรวมไม่ตรง
					$rowsTotal = 0;
					foreach ($rows as $dupRow) {
						$rowsTotal += (float)$dupRow["amount"];
					}
					if (round($rowsTotal, 2) !== $expected) {
						$ambiguousCodes[] = (string)$productId;
					}
					continue;
				}

				if (!$isInSync) {
					$pendingUpdates[(int)$row["id"]] = $expected;
				}
			}

			if ($ambiguousCodes) {
				$outcome['skipped'][] = array('so' => $soRefId, 'reason' => 'มีรายการรหัส ' . implode(', ', $ambiguousCodes) . ' ซ้ำหลายแถว');
			}
			if (!$pendingUpdates) {
				continue;
			}

			// iv_no เก็บแค่ prefix 'IV'/'IC' ตั้งแต่สร้าง SO เลขที่ใบกำกับจริงมีตัวเลขต่อท้าย (เช่น IV69090008)
			if (preg_match('/\d/', (string)$soRow["iv_no"])) {
				$outcome['skipped'][] = array('so' => $soRefId, 'reason' => 'ออกใบกำกับแล้ว (' . trim((string)$soRow["iv_no"]) . ')');
				continue;
			}

			if ($accConn instanceof mysqli) {
				$paymentRow = mysqli_fetch_assoc(rental_so_query($accConn, "SELECT summary_cash FROM tb_register_data WHERE ref_id = '" . mysqli_real_escape_string($accConn, $soRefId) . "' ORDER BY id_off DESC LIMIT 1"));
				$paymentStatus = $paymentRow ? trim((string)$paymentRow["summary_cash"]) : '';
				if ($paymentStatus !== '') {
					$outcome['skipped'][] = array('so' => $soRefId, 'reason' => 'บันทึกรับเงินแล้ว (' . $paymentStatus . ')');
					continue;
				}
			}

			foreach ($pendingUpdates as $subsoId => $amount) {
				$amountSql = number_format($amount, 2, '.', '');
				rental_so_query($conn, "UPDATE hos__subso SET count = 1, countref = 1, price = '" . $amountSql . "', price_ref = '" . $amountSql . "', discount = 0, amount = '" . $amountSql . "' WHERE id = " . (int)$subsoId);
			}
			$outcome['updated'][] = $soRefId;
		}

		return $outcome;
	}
}
