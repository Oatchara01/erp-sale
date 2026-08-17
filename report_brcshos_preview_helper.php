<?php

/*
 * Preview helper สำหรับ report_brcshos.php
 * ให้ report render จากค่าที่ POST มาจากฟอร์ม register_supbrcshos.php ได้โดยตรง
 * (เอกสารที่ยังไม่บันทึก) โครงเดียวกับ report_loanhos_preview_helper.php
 */

function brcshos_is_preview_request()
{
	return ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST'
		&& isset($_POST['_report_preview'])
		&& $_POST['_report_preview'] === '1';
}

function brcshos_preview_value($key, $default = '')
{
	if (!isset($_POST[$key]) || is_array($_POST[$key])) {
		return $default;
	}

	return trim((string)$_POST[$key]);
}

function brcshos_preview_number($key)
{
	$value = str_replace(',', '', brcshos_preview_value($key, '0'));
	return is_numeric($value) ? (float)$value : 0.0;
}

function brcshos_preview_checkbox($key)
{
	return isset($_POST[$key]) && $_POST[$key] !== '' && $_POST[$key] !== '0' ? '1' : '0';
}

function brcshos_preview_lookup_row($connection, $sql)
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

function brcshos_build_preview_context($conn)
{
	// hos__consig — เฉพาะคอลัมน์ที่ report_brcshos.php อ่าน
	// ค่าที่แมพตาม INSERT จริงใน register_supbrcshos1.php:188-254
	$consigDefaults = array(
		'ref_id'           => '',
		'company'          => '',
		'customer'         => '',
		'address'          => '',
		'dep_no'           => '',
		'deposit_no'       => '',
		'job_no'           => '',
		'job_id'           => '',
		'iv_no'            => '',
		'date_save'        => date('Y-m-d'),
		'objective'        => '',
		'objective_des'    => '',
		'delivery_name'    => '',
		'delivery_address' => '',
		'delivery_contact' => '',
		'delivery_tel'     => '',
		'delivery_type'    => '',
		'delivery_date'    => '0000-00-00',
		'delivery_time'    => '',
		'date_send_key'    => '',
		'time_delivery'    => '',
		'packing_remark'   => '',
		'province_id'      => '',
		'zip_code'         => '',
		'maps'             => '',
		'sale_comment'     => '',
		'sale'             => '',
		'sale_code'        => '',
		'sale_date'        => date('Y-m-d'),
		'approve'          => '',
		'approve_date'     => '0000-00-00',
	);

	$consig = array_merge($consigDefaults, $_POST);

	$consig['ref_id']   = brcshos_preview_value('ref_id');
	$consig['company']  = brcshos_preview_value('company');
	$consig['customer'] = brcshos_preview_value('customer');
	$consig['address']  = brcshos_preview_value('address');

	$consig['delivery_name']    = brcshos_preview_value('address_name');
	$consig['delivery_address'] = brcshos_preview_value('address_send');
	$consig['delivery_contact'] = brcshos_preview_value('customer_name');
	$consig['delivery_tel']     = brcshos_preview_value('customer_tel');
	$consig['delivery_type']    = brcshos_preview_value('delivery_type');

	// delivery_date: start_date -> date_send_key -> between_date, ตัวแรกที่ไม่ว่างชนะ
	$startDate = brcshos_preview_value('start_date');
	if ($startDate === '') {
		$startDate = brcshos_preview_value('date_send_key');
	}
	if ($startDate === '') {
		$startDate = brcshos_preview_value('between_date');
	}
	$consig['delivery_date'] = $startDate !== '' ? $startDate : '0000-00-00';
	$consig['date_send_key'] = brcshos_preview_value('between_date');
	$consig['delivery_time'] = trim(brcshos_preview_value('start_time') . ' ' . brcshos_preview_value('end_time'));
	$consig['time_delivery'] = '';

	$consig['date_save']    = date('Y-m-d');
	$consig['iv_no']        = brcshos_preview_value('admin_doc_no');
	$consig['job_no']       = brcshos_preview_value('admin_work_no');
	$consig['job_id']       = $consig['job_no'];
	$consig['sale_comment'] = brcshos_preview_value('sale_comment');

	// sale มาจาก $_SESSION['name'] ตอนบันทึก — report ไม่ได้ start session
	// จึงใช้ hidden employee_name ที่ฟอร์มใส่ค่าเดียวกันไว้ (register_supbrcshos.php:1319)
	$consig['sale']      = brcshos_preview_value('employee_name');
	$consig['sale_code'] = brcshos_preview_value('sale_code');
	$consig['sale_date'] = date('Y-m-d');

	// ไม่มี input ในฟอร์มนี้ / เป็นค่าที่ถูกกำหนดหลังบันทึก
	$consig['objective']      = '';
	$consig['objective_des']  = '';
	$consig['dep_no']         = '';
	$consig['deposit_no']     = '';
	$consig['packing_remark'] = '';
	$consig['province_id']    = '';
	$consig['zip_code']       = '';
	$consig['maps']           = '';
	$consig['approve']        = '';
	$consig['approve_date']   = '0000-00-00';

	// tb_register_data
	$registerDefaults = array(
		'customer_name' => '',
		'address_name'  => '',
		'address_1'     => '',
		'address_send'  => '',
		'province_id'   => '',
		'zip_code'      => '',
		'maps'          => '',
		'map'           => '',
		'want_bus'      => '0',
		'call_customer' => '0',
		'fix_date'      => '',
	);
	$register = array_merge($registerDefaults, $_POST);

	$register['customer_name'] = brcshos_preview_value('customer_name');
	$register['address_name']  = brcshos_preview_value('address_name');
	$register['address_send']  = brcshos_preview_value('address_send');

	// address_1 ว่างเมื่อไหร่ handler จะใช้ address_name แทน (register_supbrcshos1.php:759)
	$address1 = brcshos_preview_value('address_1');
	$register['address_1'] = $address1 !== '' ? $address1 : $register['address_name'];

	$register['call_customer'] = brcshos_preview_checkbox('call_customer');
	$register['want_bus']      = '0';
	$register['fix_date']      = '';
	$register['province_id']   = '';
	$register['zip_code']      = '';
	$register['maps']          = '';
	$register['map']           = '';

	// tb_other_bill — ฟอร์มใบยืมฝากขายเขียนแค่ ref_12 ส่วน ref_1..ref_11 ที่ report อ่านไม่เคยถูกเขียน
	$otherBill = array();
	for ($i = 1; $i <= 11; $i++) {
		$otherBill['ref_' . $i] = '0';
	}
	$otherBill['ref_des']   = '';
	$otherBill['ref_11des'] = '';

	// รายการสินค้า 10 แถว (detail_brschos_so.php)
	$products = array();
	$summary = 0.0;
	for ($i = 1; $i <= 10; $i++) {
		$productId = brcshos_preview_value('product_id' . $i);
		if ($productId === '') {
			continue; // กติกาเดียวกับตอนบันทึก (register_supbrcshos1.php:442-444)
		}

		// รหัส/ชื่อ/หน่วย ที่ report แสดง มาจาก tb_product ไม่ใช่ hos__subconsig
		// (รหัสสินค้าในฟอร์มเป็น <span> จึงไม่ถูก POST มา)
		$productRow = brcshos_preview_lookup_row(
			$conn,
			"SELECT access_code, sol_name, unit_name FROM tb_product WHERE product_id = '" . mysqli_real_escape_string($conn, $productId) . "' "
		);

		$productName = $productRow['sol_name'] ?? '';
		if ($productName === '') {
			$productName = brcshos_preview_value('product_name' . $i);
		}
		$unitName = $productRow['unit_name'] ?? '';
		if ($unitName === '') {
			$unitName = brcshos_preview_value('unit_name' . $i);
		}

		$count    = brcshos_preview_number('sale_count' . $i);
		$price    = brcshos_preview_number('product_price' . $i);
		$discount = brcshos_preview_number('discount_unit' . $i);

		$amountRaw = brcshos_preview_value('sum_amount' . $i);
		// สูตรเดียวกับ jAutoCalc ใน detail_brschos_so.php:631
		$amount = $amountRaw === '' ? (($count * $price) - ($discount * $count)) : brcshos_preview_number('sum_amount' . $i);
		$summary += $amount;

		$products[] = array(
			'product_id'  => $productId,
			'access_code' => $productRow['access_code'] ?? '',
			'sol_name'    => $productName,
			'count'       => $count,
			'unit_name'   => $unitName,
			'price'       => $price,
			'amount'      => $amount,
			'sale_remark' => brcshos_preview_value('sale_remarkk' . $i),
		);
	}

	return array(
		'consig'     => $consig,
		'register'   => $register,
		'other_bill' => $otherBill,
		'products'   => $products,
		'summary'    => $summary,
	);
}
