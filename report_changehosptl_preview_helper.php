<?php

/*
 * Preview helper สำหรับ report_changehosptl.php
 * ให้ report render จากค่าที่ POST มาจากฟอร์ม register_supchange.php ได้โดยตรง
 * (เอกสารที่ยังไม่บันทึก) โครงเดียวกับ report_changhos_preview_helper.php /
 * report_brcshos_preview_helper.php
 */

function changehosptl_is_preview_request()
{
	return ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST'
		&& isset($_POST['_report_preview'])
		&& $_POST['_report_preview'] === '1';
}

function changehosptl_preview_value($key, $default = '')
{
	if (!isset($_POST[$key]) || is_array($_POST[$key])) {
		return $default;
	}

	return trim((string)$_POST[$key]);
}

function changehosptl_preview_number($key)
{
	$value = str_replace(',', '', changehosptl_preview_value($key, '0'));
	return is_numeric($value) ? (float)$value : 0.0;
}

function changehosptl_preview_checkbox($key)
{
	return isset($_POST[$key]) && $_POST[$key] !== '' && $_POST[$key] !== '0' ? '1' : '0';
}

function changehosptl_preview_lookup_row($connection, $sql)
{
	if (!$connection) {
		return array();
	}

	$query = mysqli_query($connection, $sql);
	if (!$query) {
		return array();
	}

	$row = mysqli_fetch_assoc($query);
	return $row ? $row : array();
}

function changehosptl_build_preview_context($conn)
{
	// hos__change — เฉพาะคอลัมน์ที่ report_changehosptl.php อ่าน (บรรทัด 132-174)
	// ค่าที่แมพตาม POST -> DB จริงใน register_supchange1.php:171-234
	$startDate = changehosptl_preview_value('start_date');
	$ivDate = changehosptl_preview_value('admin_doc_date');

	$change = array(
		'ref_id'           => changehosptl_preview_value('ref_id'),
		'dep_no'           => '', // ไม่มีคอลัมน์/ input นี้สำหรับเอกสารประเภทนี้
		'job_no'           => changehosptl_preview_value('admin_work_no'),
		'iv_no'            => changehosptl_preview_value('admin_doc_no'),
		'customer'         => changehosptl_preview_value('customer'),
		'address'          => changehosptl_preview_value('address'),
		'delivery_name'    => changehosptl_preview_value('address_name'),
		'delivery_address' => changehosptl_preview_value('address_send'),
		'delivery_contact' => changehosptl_preview_value('customer_name'),
		'delivery_tel'     => changehosptl_preview_value('customer_tel'),
		'iv_date'          => $ivDate !== '' ? $ivDate : date('Y-m-d'),
		// ฟอร์มนี้ไม่มี input สำหรับ objective/objective_des/sale_code เลย (cs_post ได้ค่าว่างเสมอ
		// ตอนบันทึกจริงด้วย) จึงคงเป็นค่าว่างในพรีวิวเช่นกัน ไม่ใช่บั๊ก
		'objective'        => changehosptl_preview_value('objective'),
		'objective_des'    => changehosptl_preview_value('objective_des'),
		'add_by'           => changehosptl_preview_value('add_by'),
		'sn_ckk'           => changehosptl_preview_checkbox('sn_ckk'),
		'sn'               => changehosptl_preview_value('sn'),
		'delivery_type'    => changehosptl_preview_value('delivery_type'),
		'sale_comment'     => changehosptl_preview_value('sale_comment'),
		// delivery_date/date_send_key: fallback เดียวกับ report_changehosptl.php:152-156
		// (ใช้ delivery_date ถ้าไม่ใช่ '0000-00-00' ไม่งั้น fallback ไป date_send_key)
		'delivery_date'    => $startDate !== '' ? $startDate : '0000-00-00',
		'date_send_key'    => changehosptl_preview_value('between_date'),
		'delivery_time'    => trim(changehosptl_preview_value('start_time') . ' ' . changehosptl_preview_value('end_time')),
		// แท็บที่อยู่การคืน — ฟอร์มนี้ mirror ไว้เป็น hidden ค่าว่างเสมอ (register_supchange.php:1387-1393)
		'returns'          => changehosptl_preview_value('returns'),
		'returns_date'     => changehosptl_preview_value('returns_date'),
		'return_date_bet'  => changehosptl_preview_value('return_date_bet'),
		'returns_time'     => changehosptl_preview_value('returns_time'),
		'returns_name'     => changehosptl_preview_value('returns_name'),
		'returns_address'  => changehosptl_preview_value('returns_address'),
		'returns_contact'  => changehosptl_preview_value('returns_contact'),
		'sale_code'        => changehosptl_preview_value('sale_code'),
		'sale_date'        => date('Y-m-d'),
		'approve'          => '',
		'approve_date'     => '0000-00-00',
	);

	// tb_register_data — เฉพาะคอลัมน์ที่ report_changehosptl.php อ่านผ่าน $objResult3
	// (ตาม POST -> DB mapping ใน register_supchange1.php:495-534,558)
	$addressName = changehosptl_preview_value('address_name');
	$address1 = changehosptl_preview_value('address_1');

	$register = array(
		'want_bus'      => changehosptl_preview_checkbox('want_bus'),
		'call_customer' => changehosptl_preview_checkbox('call_customer'),
		'fix_date'      => changehosptl_preview_checkbox('fix_datetime'),
		'address_name'  => $addressName,
		'address_1'     => $address1 !== '' ? $address1 : $addressName,
		'address_send'  => changehosptl_preview_value('address_send'),
	);

	// รายการสินค้า 6 แถว (partials/product_table_change.php) — คีย์ตั้งชื่อให้ตรงกับคอลัมน์
	// hos__subchange/tb_product ที่ report_changehosptl.php อ่านตรงๆ ในลูป (บรรทัด 287-316)
	// เพื่อให้ใช้ foreach ($rows as $objResult1) ตัวเดียวกับ branch DB ได้โดยไม่ต้องแก้ loop body
	$products = array();
	$summaryStock = 0.0;
	$summarySale = 0.0;

	for ($i = 1; $i <= 6; $i++) {
		$productId = changehosptl_preview_value('product_id' . $i);
		if ($productId === '') {
			continue; // กติกาเดียวกับตอนบันทึก (register_supchange1.php:375-377)
		}

		// รหัส/ชื่อสินค้าที่ report แสดง มาจาก tb_product (express_code/sol_name เหมือนที่
		// report_changehosptl.php:293-294 อ่านจากผลลัพธ์ join จริง) ไม่ใช่ hos__subchange
		$productRow = changehosptl_preview_lookup_row(
			$conn,
			"SELECT express_code, sol_name, unit_name FROM tb_product WHERE product_id = '" . mysqli_real_escape_string($conn, $productId) . "' "
		);

		$unitName = $productRow['unit_name'] ?? '';
		if ($unitName === '') {
			$unitName = changehosptl_preview_value('unit_name' . $i);
		}

		$countStock = changehosptl_preview_number('count_stock' . $i);
		$countSale = changehosptl_preview_number('count_sale' . $i);
		$price = changehosptl_preview_number('product_price' . $i);

		$amountRaw = changehosptl_preview_value('sum_amount' . $i);
		// สูตรเดียวกับ jAutoCalc ใน partials/product_table_change.php
		$amount = $amountRaw !== '' ? changehosptl_preview_number('sum_amount' . $i) : (($countStock + $countSale) * $price);

		$countStockStr = number_format($countStock, 2, '.', '');
		$countSaleStr = number_format($countSale, 2, '.', '');

		if ($countStockStr !== '0.00') {
			$summaryStock += $amount;
		}
		if ($countSaleStr !== '0.00') {
			$summarySale += $amount;
		}

		$products[] = array(
			'amount'      => $amount,
			'price'       => $price,
			'express_code' => $productRow['express_code'] ?? '',
			'sol_name'    => $productRow['sol_name'] ?? '',
			'count_sale'  => $countSaleStr,
			'count_stock' => $countStockStr,
			'unit_name'   => $unitName,
			'sale_remark' => changehosptl_preview_value('sale_remarkk' . $i),
			'sn'          => changehosptl_preview_value('sn' . $i),
		);
	}

	return array(
		'change'        => $change,
		'register'      => $register,
		'products'      => $products,
		'summary_stock' => $summaryStock,
		'summary_sale'  => $summarySale,
	);
}
