<?php

function salehos_is_preview_request()
{
	return ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST'
		&& isset($_POST['_report_preview'])
		&& $_POST['_report_preview'] === '1';
}

function salehos_preview_value($key, $default = '')
{
	if (!isset($_POST[$key]) || is_array($_POST[$key])) {
		return $default;
	}

	return trim((string)$_POST[$key]);
}

function salehos_preview_number($key)
{
	$value = str_replace(',', '', salehos_preview_value($key, '0'));
	return is_numeric($value) ? (float)$value : 0.0;
}

function salehos_preview_checkbox($key)
{
	return isset($_POST[$key]) && $_POST[$key] !== '' && $_POST[$key] !== '0' ? '1' : '0';
}

function salehos_preview_date($value)
{
	$value = trim((string)$value);
	if (preg_match('/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/', $value, $matches)) {
		$year = (int)$matches[3];
		if ($year > 2400) {
			$year -= 543;
		}
		return sprintf('%04d-%02d-%02d', $year, (int)$matches[2], (int)$matches[1]);
	}

	return $value;
}

function salehos_preview_lookup_row($connection, $sql)
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

function salehos_build_preview_context($conn, $accountConnection)
{
	$soDefaults = array(
		'id' => '',
		'ref_id' => '',
		'type_doc' => '',
		'suggest' => '',
		'date_so' => date('Y-m-d'),
		'job_no' => '',
		'dep_no' => '',
		'cm_no' => '',
		'bill_id' => '',
		'bill_name' => '',
		'bill_address' => '',
		'bill_tel' => '',
		'credit_name' => '',
		'payment' => '',
		'pre_name' => '',
		'delivery_contact' => '',
		'delivery_tel' => '',
		'tax_id' => '',
		'po_no' => '',
		'delivery_contract' => '',
		'book_clear' => '0',
		'book_no' => '',
		'brn_clear' => '0',
		'brn_no' => '',
		'brnp_clear' => '0',
		'brnp_no' => '',
		'with_pr' => '0',
		'pr_no' => '',
		'full_bill' => '0',
		'type_type' => '',
		'type_detail' => '',
		'iv_date' => '0000-00-00',
		'delivery_date' => '0000-00-00',
		'delivery_time' => '',
		'sale_comment' => '',
		'sale_date' => date('Y-m-d'),
		'approve' => '',
		'approve_date' => '0000-00-00',
		'sale' => '',
		'iv_no' => '',
		'sale_code' => '',
		'delivery_type' => '',
		'payment_des' => '',
		'install_place' => '',
		'order_no' => '',
		'time_delivery' => '',
		'packing_remark' => '',
		'delivery_name' => ''
	);

	for ($i = 0; $i <= 9; $i++) {
		$soDefaults['product_free' . ($i === 0 ? '' : $i)] = '';
	}

	$so = array_merge($soDefaults, $_POST);
	$so['ref_id'] = salehos_preview_value('ref_id');
	$so['type_doc'] = salehos_preview_value('type_doc');
	$so['full_bill'] = salehos_preview_checkbox('full_bill');
	$so['book_clear'] = salehos_preview_checkbox('book_clear');
	$so['brn_clear'] = salehos_preview_checkbox('brn_clear');
	$so['brnp_clear'] = salehos_preview_checkbox('brnp_clear');
	$so['with_pr'] = salehos_preview_checkbox('with_pr');
	$deliveryDate = salehos_preview_value('start_date');
	$so['delivery_date'] = $deliveryDate !== '' ? $deliveryDate : '0000-00-00';
	$so['delivery_time'] = trim(salehos_preview_value('start_time') . ' ' . salehos_preview_value('end_time'));
	$so['delivery_contact'] = salehos_preview_value('customer_name');
	$so['delivery_tel'] = salehos_preview_value('customer_tel');
	$so['install_place'] = salehos_preview_value('address_send');
	$so['job_no'] = salehos_preview_value('admin_work_no');
	$so['sr_no'] = salehos_preview_value('admin_sr_no');
	$so['order_no'] = salehos_preview_value('admin_deposit_no');
	$invoiceDate = salehos_preview_date(salehos_preview_value('admin_doc_date'));
	$so['iv_date'] = $invoiceDate !== '' ? $invoiceDate : '0000-00-00';
	$so['iv_no'] = salehos_preview_checkbox('ic_ckk') === '1' ? 'IC' : 'IV';
	$so['sale'] = salehos_preview_value('_preview_sale');

	$registerDefaults = array(
		'address_name' => '',
		'address_1' => '',
		'want_bus' => '0',
		'call_customer' => '0',
		'fix_date' => '',
		'between_date' => ''
	);
	$register = array_merge($registerDefaults, $_POST);
	$register['want_bus'] = salehos_preview_checkbox('want_bus');
	$register['call_customer'] = salehos_preview_checkbox('call_customer');

	$otherBill = array();
	for ($i = 1; $i <= 13; $i++) {
		$otherBill['ref_' . $i] = salehos_preview_checkbox('ref_' . $i);
	}
	$otherBill['ref_des'] = salehos_preview_value('ref_des');

	$comments = array(
		'comment_cs' => salehos_preview_value('comment_cs'),
		'comment_st' => salehos_preview_value('comment_st'),
		'comment_en' => salehos_preview_value('comment_en'),
		'comment_ad' => salehos_preview_value('comment_ad')
	);

	$customer = array('customer_code' => '', 'customer_coden' => '');
	$billId = salehos_preview_value('bill_id');
	if ($billId !== '' && $conn) {
		$safeBillId = mysqli_real_escape_string($conn, $billId);
		$customer = array_merge($customer, salehos_preview_lookup_row(
			$conn,
			"SELECT customer_code, customer_coden FROM tb_customer WHERE customer_id = '" . $safeBillId . "' LIMIT 1"
		));
	}

	$payment = array('pay_in' => '');
	$paymentId = salehos_preview_value('payment');
	if ($paymentId !== '' && $accountConnection) {
		$safePaymentId = mysqli_real_escape_string($accountConnection, $paymentId);
		$payment = array_merge($payment, salehos_preview_lookup_row(
			$accountConnection,
			"SELECT pay_in FROM tb_bank WHERE id = '" . $safePaymentId . "' LIMIT 1"
		));
	}

	$products = array();
	$summary = 0.0;
	for ($i = 1; $i <= 30; $i++) {
		if (salehos_preview_value('row_deleted' . $i, '0') === '1') {
			continue;
		}

		$productId = salehos_preview_value('product_id' . $i);
		$productCode = salehos_preview_value('product_codet' . $i);
		if ($productCode === '') {
			$productCode = salehos_preview_value('h_product_codet' . $i);
		}
		$productName = salehos_preview_value('product_name' . $i);
		if ($productName === '') {
			$productName = salehos_preview_value('display_name' . $i);
		}

		if ($productId === '' && $productCode === '' && $productName === '') {
			continue;
		}

		$count = salehos_preview_number('sale_count' . $i);
		$price = salehos_preview_number('product_price' . $i);
		$discount = salehos_preview_number('discount_unit' . $i);
		$amountRaw = salehos_preview_value('sum_amount' . $i);
		$amount = $amountRaw === '' ? (($price - $discount) * $count) : salehos_preview_number('sum_amount' . $i);
		$summary += $amount;

		$products[] = array(
			'product_id' => $productId,
			'express_code' => $productCode,
			'sol_name' => $productName,
			'count' => $count,
			'unit_name' => salehos_preview_value('unit_name' . $i),
			'price' => $price,
			'discount' => $discount,
			'amount' => $amount,
			'sale_remark' => salehos_preview_value('sale_remarkk' . $i),
			'warranty' => salehos_preview_value('warranty' . $i),
			'cal' => salehos_preview_value('cal' . $i),
			'pm' => salehos_preview_value('pm' . $i),
			'clear_br' => salehos_preview_value('clear_br' . $i, '0'),
			'clear_ivno' => salehos_preview_value('clear_ivno' . $i),
			'jong_ckk' => salehos_preview_value('jong_ckk' . $i, '0'),
			'jong_no' => salehos_preview_value('jong_no' . $i),
			'lot_no' => salehos_preview_value('lot_no' . $i)
		);
	}

	return array(
		'so' => $so,
		'register' => $register,
		'other_bill' => $otherBill,
		'comments' => $comments,
		'customer' => $customer,
		'payment' => $payment,
		'products' => $products,
		'summary' => $summary
	);
}

function salehos_render_report_error($message)
{
	echo '<div style="max-width:720px;margin:48px auto;padding:24px;border:1px solid #e1d9e8;border-radius:10px;font-family:Tahoma,sans-serif;color:#3b3340;background:#fff;">';
	echo '<h2 style="margin:0 0 12px;font-size:22px;">ไม่สามารถเปิดรายงานได้</h2>';
	echo '<p style="margin:0;line-height:1.6;">' . htmlspecialchars($message, ENT_QUOTES, 'UTF-8') . '</p>';
	echo '</div>';
	exit();
}
