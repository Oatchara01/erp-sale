<?php

/*
 * Preview helper สำหรับ report_changhos.php
 * ให้ report render จากค่าที่ POST มาจากฟอร์ม register_supchange.php ได้โดยตรง
 * (เอกสารที่ยังไม่บันทึก) โครงเดียวกับ report_brcshos_preview_helper.php
 */

function changhos_is_preview_request()
{
	return ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST'
		&& isset($_POST['_report_preview'])
		&& $_POST['_report_preview'] === '1';
}

function changhos_preview_value($key, $default = '')
{
	if (!isset($_POST[$key]) || is_array($_POST[$key])) {
		return $default;
	}

	return trim((string)$_POST[$key]);
}

function changhos_preview_number($key)
{
	$value = str_replace(',', '', changhos_preview_value($key, '0'));
	return is_numeric($value) ? (float)$value : 0.0;
}

function changhos_preview_lookup_row($connection, $sql)
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

function changhos_build_preview_context($conn)
{
	// hos__change — เฉพาะคอลัมน์ที่ report_changhos.php อ่าน (บรรทัด 51-64)
	// ฟอร์มนี้ไม่มี input สำหรับ objective/sale_code เลย (cs_post ได้ค่าว่างเสมอตอนบันทึกจริง
	// ใน register_supchange1.php ด้วย) จึงคงเป็นค่าว่างในพรีวิวเช่นกัน ไม่ใช่บั๊ก
	$ivDate = changhos_preview_value('admin_doc_date');

	$change = array(
		'ref_id'            => changhos_preview_value('ref_id'),
		'iv_date'           => $ivDate !== '' ? $ivDate : date('Y-m-d'),
		'customer'          => changhos_preview_value('customer'),
		'address'           => changhos_preview_value('address'),
		'delivery_tel'      => changhos_preview_value('customer_tel'),
		'delivery_address'  => changhos_preview_value('address_send'),
		'objective'         => changhos_preview_value('objective'),
		'add_by'            => changhos_preview_value('add_by'),
		'sale_code'         => changhos_preview_value('sale_code'),
		'sale_comment'      => changhos_preview_value('sale_comment'),
		// ไม่มี input ในฟอร์มนี้ / เป็นค่าที่ถูกกำหนดหลังบันทึก แต่ report_changhos.php:79 ยังอ่านคีย์นี้
		// อยู่ (แม้ไม่ได้เอาไปใช้ต่อ) - ต้องมีไว้กัน PHP warning ที่ทำให้ FPDF ส่ง PDF ไม่ได้
		'approve'           => '',
	);

	// รายการสินค้า 6 แถว (partials/product_table_change.php) — คีย์ตั้งชื่อให้ตรงกับคอลัมน์
	// hos__subchange/tb_product ที่ report_changhos.php อ่านตรงๆ ในลูป (บรรทัด 111-173)
	// เพื่อให้ใช้ foreach ($rows as $objResult1) ตัวเดียวกับ branch DB ได้โดยไม่ต้องแก้ loop body
	$products = array();
	$summaryStock = 0.0;
	$summarySale = 0.0;

	for ($i = 1; $i <= 6; $i++) {
		$productId = changhos_preview_value('product_id' . $i);
		if ($productId === '') {
			continue; // กติกาเดียวกับตอนบันทึก (register_supchange1.php:375-377)
		}

		$productRow = changhos_preview_lookup_row(
			$conn,
			"SELECT access_code, access_name, unit_name FROM tb_product WHERE product_id = '" . mysqli_real_escape_string($conn, $productId) . "' "
		);

		$unitName = $productRow['unit_name'] ?? '';
		if ($unitName === '') {
			$unitName = changhos_preview_value('unit_name' . $i);
		}

		$countStock = changhos_preview_number('count_stock' . $i);
		$countSale = changhos_preview_number('count_sale' . $i);
		$price = changhos_preview_number('product_price' . $i);

		$amountRaw = changhos_preview_value('sum_amount' . $i);
		// สูตรเดียวกับ jAutoCalc ใน partials/product_table_change.php
		$amount = $amountRaw !== '' ? changhos_preview_number('sum_amount' . $i) : (($countStock + $countSale) * $price);

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
			'count_sale'  => $countSaleStr,
			'price'       => $price,
			'access_code' => $productRow['access_code'] ?? '',
			'access_name' => $productRow['access_name'] ?? '',
			'count_stock' => $countStockStr,
			'unit_name'   => $unitName,
			'sale_remark' => changhos_preview_value('sale_remarkk' . $i),
		);
	}

	return array(
		'change'        => $change,
		'products'      => $products,
		'summary_stock' => $summaryStock,
		'summary_sale'  => $summarySale,
	);
}
