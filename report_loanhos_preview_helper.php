<?php

function loanhos_is_preview_request()
{
	return ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST'
		&& isset($_POST['_report_preview'])
		&& $_POST['_report_preview'] === '1';
}

function loanhos_preview_value($key, $default = '')
{
	if (!isset($_POST[$key]) || is_array($_POST[$key])) {
		return $default;
	}

	return trim((string)$_POST[$key]);
}

function loanhos_preview_number($key)
{
	$value = str_replace(',', '', loanhos_preview_value($key, '0'));
	return is_numeric($value) ? (float)$value : 0.0;
}

function loanhos_preview_checkbox($key)
{
	return isset($_POST[$key]) && $_POST[$key] !== '' && $_POST[$key] !== '0' ? '1' : '0';
}

function loanhos_preview_date($value)
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

function loanhos_preview_lookup_row($connection, $sql)
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

function loanhos_build_preview_context($conn)
{
	$brDefaults = array(
		'ref_id_br'        => '',
		'dep_no'           => '',
		'job_no'           => '',
		'iv_no'            => '',
		'company'          => '',
		'customer'         => '',
		'address'          => '',
		'delivery_name'    => '',
		'delivery_address' => '',
		'delivery_contact' => '',
		'delivery_tel'     => '',
		'date_br'          => date('Y-m-d'),
		'objective'        => '',
		'objective_des1'   => '',
		'objective_des2'   => '',
		'objective_des4'   => '',
		'objective_des5'   => '',
		'sn_ckk'           => '0',
		'sn'               => '',
		'delivery_type'    => '',
		'sale_comment'     => '',
		'date_send_key'    => '',
		'delivery_date'    => '0000-00-00',
		'delivery_time'    => '',
		'returns'          => '0',
		'returns_date'     => '0000-00-00',
		'return_date_bet'  => '',
		'returns_time'     => '',
		'returns_name'     => '',
		'returns_address'  => '',
		'returns_contact'  => '',
		'sale_code'        => '',
		'sale_date'        => date('Y-m-d'),
		'approve'          => '',
		'approve_date'     => '0000-00-00',
	);

	$br = array_merge($brDefaults, $_POST);
	$br['ref_id_br'] = loanhos_preview_value('ref_id_br');

	// delivery_date: start_date -> date_send_key -> between_date, first non-empty wins
	$startDate = loanhos_preview_value('start_date');
	if ($startDate === '') {
		$startDate = loanhos_preview_value('date_send_key');
	}
	if ($startDate === '') {
		$startDate = loanhos_preview_value('between_date');
	}
	$br['delivery_date'] = $startDate !== '' ? $startDate : '0000-00-00';
	$br['date_send_key'] = loanhos_preview_value('date_send_key');

	$br['delivery_time']    = trim(loanhos_preview_value('start_time') . ' ' . loanhos_preview_value('end_time'));
	$br['delivery_contact'] = loanhos_preview_value('customer_name');
	$br['delivery_tel']     = loanhos_preview_value('customer_tel');
	$br['delivery_name']    = loanhos_preview_value('address_name');
	$br['delivery_address'] = loanhos_preview_value('address_send');

	$br['returns']          = loanhos_preview_checkbox('returns');
	$realReturnsDate        = loanhos_preview_value('returns_date');
	$br['returns_date']     = $realReturnsDate !== '' ? $realReturnsDate : '0000-00-00';
	$br['return_date_bet']  = loanhos_preview_value('return_date_bet');
	$br['returns_time']     = loanhos_preview_value('returns_time');
	$br['returns_name']     = loanhos_preview_value('returns_name');
	$br['returns_address']  = loanhos_preview_value('returns_address');
	$br['returns_contact']  = loanhos_preview_value('returns_contact');

	$br['sale_code'] = loanhos_preview_value('sale_code');

	// No form equivalent -- save-time / post-save assigned fields, always default in preview
	$br['sale_date']     = date('Y-m-d');
	$br['approve']       = '';
	$br['approve_date']  = '0000-00-00';
	$br['iv_no']         = '';
	$br['sn_ckk']        = '0';
	$br['sn']            = '';
	$br['sale_comment']  = '';
	$br['dep_no']        = '';
	$br['job_no']        = '';

	$registerDefaults = array(
		'address_name'  => '',
		'address_1'     => '',
		'address_send'  => '',
		'want_bus'      => '0',
		'call_customer' => '0',
		'fix_date'      => '',
	);
	$register = array_merge($registerDefaults, $_POST);
	$register['call_customer'] = loanhos_preview_checkbox('call_customer');
	$register['want_bus']      = '0';
	$register['fix_date']      = '';

	$otherBill = array();
	for ($i = 1; $i <= 9; $i++) {
		$otherBill['ref_' . $i] = loanhos_preview_checkbox('ref_' . $i);
	}
	$otherBill['ref_10']    = loanhos_preview_checkbox('ref_10');
	$otherBill['ref_des']   = loanhos_preview_value('ref_des');
	$otherBill['ref_11']    = loanhos_preview_checkbox('ref_11');
	$otherBill['ref_11des'] = '';

	$products = array();
	$summary = 0.0;
	for ($i = 1; $i <= 30; $i++) {
		$productId   = loanhos_preview_value('product_id' . $i);
		$productCode = loanhos_preview_value('product_code' . $i);
		if ($productCode === '') {
			$productCode = loanhos_preview_value('product_codet' . $i);
		}
		if ($productCode === '') {
			$productCode = loanhos_preview_value('product_c' . $i);
		}
		$productName = loanhos_preview_value('product_name' . $i);
		if ($productName === '') {
			$productName = loanhos_preview_value('display_name' . $i);
		}

		if ($productId === '' && $productCode === '' && $productName === '') {
			continue;
		}

		$count = loanhos_preview_number('sale_count' . $i);
		$price = loanhos_preview_number('product_price' . $i);
		$amountRaw = loanhos_preview_value('sum_amount' . $i);
		$amount = $amountRaw === '' ? ($price * $count) : loanhos_preview_number('sum_amount' . $i);
		$summary += $amount;

		$products[] = array(
			'product_id'   => $productId,
			'express_code' => $productCode,
			'sol_name'     => $productName,
			'count'        => $count,
			'unit_name'    => loanhos_preview_value('unit_name' . $i),
			'price'        => $price,
			'amount'       => $amount,
			'sale_remark'  => loanhos_preview_value('sale_remarkk' . $i),
		);
	}

	return array(
		'br'         => $br,
		'register'   => $register,
		'other_bill' => $otherBill,
		'products'   => $products,
		'summary'    => $summary,
	);
}

function loanhos_render_report_error($message)
{
	echo '<div style="max-width:720px;margin:48px auto;padding:24px;border:1px solid #e1d9e8;border-radius:10px;font-family:Tahoma,sans-serif;color:#3b3340;background:#fff;">';
	echo '<h2 style="margin:0 0 12px;font-size:22px;">ไม่สามารถเปิดรายงานได้</h2>';
	echo '<p style="margin:0;line-height:1.6;">' . htmlspecialchars($message, ENT_QUOTES, 'UTF-8') . '</p>';
	echo '</div>';
	exit();
}
