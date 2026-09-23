<?php

/**
 * Preview helper สำหรับ report_loanhosptl1_breq.php (ใบพิมพ์ BREQ)
 *
 * ให้ใบพิมพ์ render จากค่าที่ POST มาจากฟอร์ม register_breng_brgq.php ได้ทันทีก่อนบันทึกจริง
 * คืนค่าเป็น array แบบเดียวกับที่ $objResult / $objResult3 / $objResult11 (mysqli_fetch_array
 * แบบ associative) และแถวของ $objResult1 ในลูปตารางสินค้าคืนกลับมาให้ — ตัวรายงานเองไม่ต้องรู้
 * ว่าที่มาเป็น DB หรือ POST เพียงสลับตัวแปรต้นทางในจุดแตกกิ่งเดียว (ดู report_loanhosptl1_breq.php)
 *
 * โหมด Preview ต้องไม่ INSERT/UPDATE/DELETE อะไรทั้งสิ้น
 */

function breq_report_is_preview_request()
{
	return ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST'
		&& isset($_POST['_report_preview'])
		&& $_POST['_report_preview'] === '1';
}

function breq_report_preview_value($key, $default = '')
{
	if (!isset($_POST[$key]) || is_array($_POST[$key])) {
		return $default;
	}
	return trim((string)$_POST[$key]);
}

/**
 * รายละเอียดสินค้า (รหัส express_code / ชื่อหน่วย) ที่ฟอร์มไม่ได้ส่งมาด้วย (ตัดทิ้งตามแผน BREQ
 * §5 — unit_name[] ไม่เคยถูกเก็บ) — อ่านจาก tb_product เหมือนโหมดปกติที่ LEFT JOIN มา
 */
function breq_report_preview_product($conn, $productId)
{
	static $cache = array();
	$productId = trim((string)$productId);
	if ($productId === '') {
		return array();
	}
	if (isset($cache[$productId])) {
		return $cache[$productId];
	}

	$row = array();
	$stmt = mysqli_prepare($conn, "SELECT sol_name, express_code, unit_name FROM tb_product WHERE product_ID = ? LIMIT 1");
	if ($stmt) {
		mysqli_stmt_bind_param($stmt, 's', $productId);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		$fetched = $result ? mysqli_fetch_assoc($result) : null;
		if ($fetched) {
			$row = $fetched;
		}
		mysqli_stmt_close($stmt);
	}

	$cache[$productId] = $row;
	return $row;
}

/**
 * แถวรายการสินค้า — คีย์ตั้งชื่อให้ตรงกับที่ $objResult1 ในลูปตารางของโหมดปกติใช้
 * (amount = ราคาต่อหน่วย, price = ยอดรวมต่อแถว ตามชื่อคอลัมน์จริงของ in__subbr)
 */
function breq_report_preview_items($conn)
{
	$productIds = isset($_POST['product_id']) && is_array($_POST['product_id']) ? $_POST['product_id'] : array();

	$read = function ($field, $index) {
		if (!isset($_POST[$field]) || !is_array($_POST[$field]) || !isset($_POST[$field][$index])) {
			return '';
		}
		return trim((string)$_POST[$field][$index]);
	};

	$rows = array();
	foreach ($productIds as $index => $rawId) {
		$productId = trim((string)$rawId);
		if ($productId === '') {
			continue;
		}

		$product = breq_report_preview_product($conn, $productId);
		$productName = $read('product_name', $index);
		if ($productName === '') {
			$productName = (string)($product['sol_name'] ?? '');
		}

		$rows[] = array(
			'express_code' => (string)($product['express_code'] ?? ''),
			'sol_name'     => $productName,
			'count'        => $read('sale_count', $index),
			'unit_name'    => (string)($product['unit_name'] ?? ''),
			'amount'       => $read('product_price', $index),
			'price'        => $read('sum_amount', $index),
			'sale_remark'  => $read('sale_remarkk', $index),
		);
	}

	return $rows;
}

/**
 * หัวเอกสาร — คีย์รวมทุกคีย์ที่ report_loanhosptl1_breq.php อ่านจาก $objResult (in__br)
 * $objResult3 (tb_register_data) และ $objResult11 (tb_other_bill) ไว้ใน array เดียว
 * เพราะทั้งสามตารางไม่มีชื่อคอลัมน์ชนกัน — ใบใหม่ยังไม่ผ่าน Admin/อนุมัติ ฟิลด์ lifecycle
 * (dep_no/job_no/approve/approve_date) จึงว่างเสมอตามความจริงของเอกสารที่ยังไม่ถึงขั้นตอนนั้น
 */
function breq_report_build_preview_context($conn)
{
	$items = breq_report_preview_items($conn);

	$amountSum = 0;
	foreach ($items as $item) {
		$amountSum += (float)$item['amount'];
	}

	$refId = breq_report_preview_value('ref_id_br');
	if ($refId === '') {
		$refId = breq_report_preview_value('ref_id_preview');
	}

	$startTime = breq_report_preview_value('start_time');
	$endTime = breq_report_preview_value('end_time');

	$header = array(
		'ref_id_br'        => $refId,
		'dep_no'           => '',
		'job_no'           => '',
		'iv_no'            => breq_report_preview_value('admin_doc_no'),
		'company'          => breq_report_preview_value('company'),
		'customer'         => breq_report_preview_value('customer'),
		'address'          => breq_report_preview_value('address'),
		'delivery_name'    => breq_report_preview_value('address_name'),
		'delivery_address' => breq_report_preview_value('address_send'),
		'delivery_contact' => breq_report_preview_value('customer_name'),
		'delivery_tel'     => breq_report_preview_value('customer_tel'),
		'date_br'          => breq_report_preview_value('date_br'),
		'objective'        => breq_report_preview_value('objective'),
		'objective_des1'   => breq_report_preview_value('objective_des1'),
		'objective_des2'   => breq_report_preview_value('objective_des2'),
		'objective_des4'   => breq_report_preview_value('objective_des4'),
		'objective_des5'   => breq_report_preview_value('objective_des5'),
		'sn_ckk'           => breq_report_preview_value('sn_ckk'),
		'sn'               => breq_report_preview_value('sn'),
		'delivery_type'    => breq_report_preview_value('delivery_type'),
		'sale_comment'     => breq_report_preview_value('sale_comment'),
		'date_send_key'    => breq_report_preview_value('between_date'),
		'delivery_date'    => breq_report_preview_value('start_date'),
		'delivery_time'    => trim($startTime . ' ' . $endTime),
		'returns'          => breq_report_preview_value('returns'),
		'returns_date'     => breq_report_preview_value('returns_date'),
		'return_date_bet'  => breq_report_preview_value('return_date_bet'),
		'returns_time'     => breq_report_preview_value('returns_time'),
		'returns_name'     => breq_report_preview_value('returns_name'),
		'returns_address'  => breq_report_preview_value('returns_address'),
		'returns_contact'  => breq_report_preview_value('returns_contact'),
		'sale_code'        => isset($_SESSION['code']) ? (string)$_SESSION['code'] : '',
		'sale_date'        => date('Y-m-d'),
		'approve'          => '',
		'approve_date'     => '',
		// tb_register_data
		'want_bus'         => breq_report_preview_value('want_bus'),
		'call_customer'    => breq_report_preview_value('call_customer'),
		'fix_date'         => breq_report_preview_value('fix_datetime'),
		'address_name'     => breq_report_preview_value('address_name'),
		'address_1'        => breq_report_preview_value('address_1'),
		'address_send'     => breq_report_preview_value('address_send'),
		// tb_other_bill
		'ref_1'  => breq_report_preview_value('ref_1'),
		'ref_2'  => breq_report_preview_value('ref_2'),
		'ref_3'  => breq_report_preview_value('ref_3'),
		'ref_4'  => breq_report_preview_value('ref_4'),
		'ref_5'  => breq_report_preview_value('ref_5'),
		'ref_6'  => breq_report_preview_value('ref_6'),
		'ref_7'  => breq_report_preview_value('ref_7'),
		'ref_8'  => breq_report_preview_value('ref_8'),
		'ref_9'  => breq_report_preview_value('ref_9'),
		'ref_10' => breq_report_preview_value('ref_10'),
		'ref_11' => breq_report_preview_value('ref_11'),
		'ref_11des' => '',
		'ref_des'   => breq_report_preview_value('ref_des'),
	);

	return array(
		'header'    => $header,
		'items'     => $items,
		'amount_1'  => $amountSum,
	);
}
