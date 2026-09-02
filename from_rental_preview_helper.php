<?php

/*
 * Preview helper สำหรับ from_rental.php
 * ให้ report render จากค่าที่ POST มาจากฟอร์ม register_suprental.php ได้โดยตรง
 * (เอกสารที่ยังไม่บันทึก) โครงเดียวกับ report_changehosptl_preview_helper.php
 */

function rental_is_preview_request()
{
	return ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST'
		&& isset($_POST['_report_preview'])
		&& $_POST['_report_preview'] === '1';
}

function rental_preview_value($key, $default = '')
{
	if (!isset($_POST[$key]) || is_array($_POST[$key])) {
		return $default;
	}

	return trim((string)$_POST[$key]);
}

function rental_preview_number($key)
{
	$value = str_replace(',', '', rental_preview_value($key, '0'));
	return is_numeric($value) ? (float)$value : 0.0;
}

function rental_preview_checkbox($key)
{
	return isset($_POST[$key]) && $_POST[$key] !== '' && $_POST[$key] !== '0' ? '1' : '0';
}

function rental_preview_lookup_row($connection, $sql)
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

function rental_build_preview_context($conn)
{
	// hos__rental — เฉพาะคอลัมน์ที่ from_rental.php อ่าน (บรรทัด 152-198)
	// ค่าที่แมพตาม POST -> DB จริงใน register_suprental1.php / register_suprental_edit1.php
	$countM = rental_preview_value('count_m');
	$startPromis = rental_preview_value('start_promis');
	$endPromis = '';
	if ($startPromis !== '' && $countM !== '') {
		$endPromis = date('Y-m-d', strtotime($countM . ' month', strtotime($startPromis)));
	}

	$addBy = '';
	if (isset($_SESSION['name']) || isset($_SESSION['surname'])) {
		$addBy = trim(($_SESSION['name'] ?? '') . ' ' . ($_SESSION['surname'] ?? ''));
	}

	// customer_name/customer_tel/address_send: ผู้ติดต่อจัดส่ง/สถานที่ติดตั้ง จากแท็บที่อยู่จัดส่ง
	// ใช้แทน connect_name/connect_tel/install_address ที่ไม่มี input แยกในฟอร์มใหม่
	// (mapping เดียวกับที่แก้ไว้ใน register_suprental1.php / register_suprental_edit1.php)
	$rentalName = rental_preview_value('rental_name');
	$rentalTel = rental_preview_value('rental_tel');
	$rentalAddress = rental_preview_value('rental_address');

	$rental = array(
		'ref_id'           => rental_preview_value('ref_id'),
		'iv_no'            => rental_preview_value('rt_admin_doc_no'),
		'type_doc'         => rental_preview_value('type_doc', '3'),
		'register_date'    => rental_preview_value('register_date'),
		'iv_date'          => rental_preview_value('rt_admin_doc_date'),
		'rental_id'        => rental_preview_value('rental_id'),
		'rental_name'      => $rentalName,
		'rental_address'   => $rentalAddress,
		'rental_tel'       => $rentalTel,
		'connect_name'     => rental_preview_value('customer_name'),
		'connect_tel'      => rental_preview_value('customer_tel'),
		'install_date'     => '',
		'start_promis'     => $startPromis,
		'end_promis'       => $endPromis,
		'count_m'          => $countM,
		'unit_m'           => 'month',
		// promis_no: ช่องแสดงผลในฟอร์มเป็น disabled จึงไม่ถูกส่งมากับ POST เอง — มิเรอร์ไว้ที่ hidden
		// input name="promis_no" แยกต่างหาก (register_suprental.php) ให้อ่านตรงนี้แทน
		'promis_no'        => rental_preview_value('promis_no'),
		// promis_date: ไม่มี input แยก แต่ตอนบันทึกจริงคือ start_promis ตรงๆ (register_suprental1.php:564)
		'promis_date'      => $startPromis,
		'des_sale'         => rental_preview_value('des_sale'),
		'install_address'  => rental_preview_value('address_send'),
		// ไม่มีช่อง "ชื่อออกบิล" แยกในฟอร์มใหม่ ใช้ข้อมูลผู้เช่าแทน
		'bill_name'        => $rentalName,
		'bill_address'     => $rentalAddress,
		'bill_tel'         => $rentalTel,
		// ฟอร์มใหม่ไม่มี input สำหรับ tax_no/patient_name/emergency_name/emergency_tel เลย
		// (ตอนบันทึกจริงก็ได้ค่าว่างเสมอเช่นกัน ไม่ใช่บั๊ก)
		'tax_no'           => '',
		'payment'          => rental_preview_value('payment'),
		'patient_name'     => '',
		'emergency_name'   => '',
		'emergency_tel'    => '',
		'add_by'           => $addBy,
		'sale_code'        => rental_preview_value('sale_code'),
		'sup_name'         => '',
		'sup_date'         => '0000-00-00 00:00:00',
		'send_admin'       => '',
		'send_sup'         => '',
		'bill_vat'         => rental_preview_checkbox('bill_vat'),
	);

	// รายการสินค้าสูงสุด 10 แถว (RT_ROW_COUNT ใน product_rentalawl.php) — คีย์ตั้งชื่อให้ตรงกับ
	// คอลัมน์ hos__subrental/tb_product ที่ from_rental.php อ่านตรงๆ ในลูป (บรรทัด 366-392)
	// เพื่อให้ใช้ foreach ($rows as $objResult1) ตัวเดียวกับ branch DB ได้โดยไม่ต้องแก้ loop body
	$products = array();
	$summary = 0.0;

	for ($i = 1; $i <= 10; $i++) {
		$productId = rental_preview_value('product_id' . $i);
		if ($productId === '') {
			continue; // กติกาเดียวกับตอนบันทึก (register_suprental1.php: if($product_id1 != ''))
		}

		$productRow = rental_preview_lookup_row(
			$conn,
			"SELECT access_code, sol_name, unit_name FROM tb_product WHERE product_id = '" . mysqli_real_escape_string($conn, $productId) . "' "
		);

		$unitName = rental_preview_value('unit_name' . $i);
		if ($unitName === '') {
			$unitName = $productRow['unit_name'] ?? '';
		}

		$count = rental_preview_number('sale_count' . $i);
		$price = rental_preview_number('product_price' . $i);

		$amountRaw = rental_preview_value('sum_amount' . $i);
		$amount = $amountRaw !== '' ? rental_preview_number('sum_amount' . $i) : ($count * $price);
		$summary += $amount;

		$displayName = rental_preview_value('display_name' . $i);

		$products[] = array(
			'access_code'  => $productRow['access_code'] ?? '',
			'sol_name'     => $displayName !== '' ? $displayName : ($productRow['sol_name'] ?? ''),
			'count'        => $count,
			'unit_name'    => $unitName,
			'price'        => $price,
			'amount'       => $amount,
			'sale_remark'  => rental_preview_value('sale_remarkk' . $i),
		);
	}

	return array(
		'rental'   => $rental,
		'products' => $products,
		'summary'  => $summary,
	);
}
