<?php

/**
 * ชั้นบันทึกข้อมูลของใบคืนสินค้า (hos__receive / hos__subreceive) แบบรวมฟอร์มเดียว
 *
 * ใช้ร่วมกันโดย
 *   - register_receive.php   (สร้าง / แก้ไขฉบับร่าง / ดูใบที่ส่งให้ Stock แล้ว)
 *   - register_receive1.php  (rc_action = draft / submit / cancel)
 *   - ajax_receive_history.php (ประวัติการคืนของเอกสารต้นทางหนึ่งใบ)
 *
 * เอกสารต้นทาง 8 ประเภทอ่านผ่านตารางแปลง rc_source_config():
 *   br = ใบยืม | consig = ใบยืมฝากขาย | breq = ใบยืม BREQ | breg = ใบขอเบิกอะไหล่ | smp = SMP
 *   rental = ใบสั่งเช่า | change = ใบแลกเปลี่ยนสินค้า (ฝั่งแลกเข้า) | spr = SPR (อะไหล่ที่เบิกจากคลัง)
 * ใบคืนใหม่เก็บ source_type + source_ref (sql/receive_source.sql) และยังเขียน iv_no ตามเดิม
 * เพื่อให้รายงาน/สูตรเก่าที่จับคู่ด้วย iv_no ทำงานต่อได้
 *
 * prepared statement + transaction ทั้งหมด — ยืม helper กลางจาก includes/po_repo.php
 * (po_stmt_exec, named lock, po_column_exists, tb_document_status_log)
 */

require_once __DIR__ . '/po_repo.php';

if (!defined('RC_SEND_DRAFT')) {
	define('RC_SEND_DRAFT', 0);
	define('RC_SEND_SUBMITTED', 1);
	define('RC_UPLOAD_DIR', 'up_return/');
	define('RC_UPLOAD_MAX_BYTES', 1100000);
	define('RC_LOCK_NAME', 'receive_save');
	define('RC_EPSILON', 0.0001);
}

if (!class_exists('RcValidationException')) {
	/**
	 * ข้อผิดพลาดที่ "แสดงให้ผู้ใช้เห็นได้" — กรอกไม่ครบ คืนเกินยอดค้าง หรือเอกสารเปลี่ยนสถานะไปแล้ว
	 * RuntimeException อื่นในไฟล์นี้พก error ของ MySQL มา ห้ามส่งกลับหน้าเว็บตรง ๆ
	 */
	class RcValidationException extends RuntimeException
	{
	}
}

if (!function_exists('rc_has_source_columns')) {
	/** ฐานที่ยังไม่ได้รัน sql/receive_source.sql — หน้า form ต้องหยุดก่อนบันทึก */
	function rc_has_source_columns($conn)
	{
		return po_column_exists($conn, 'hos__receive', 'source_type')
			&& po_column_exists($conn, 'hos__receive', 'source_ref')
			&& po_column_exists($conn, 'hos__receive', 'time_range');
	}
}

if (!function_exists('rc_source_config')) {
	/**
	 * ตารางแปลงเอกสารต้นทาง — ชื่อตาราง/คอลัมน์ทั้งหมดมาจากที่นี่เท่านั้น (ไม่รับจากผู้ใช้) จึงต่อเข้า SQL ตรง ๆ ได้
	 * คอลัมน์ที่เป็น null = ต้นทางนั้นไม่มีข้อมูลนี้
	 *   deduct = true  : ยอดค้าง = จำนวนยืม − (SO + SPR + SMP + so__main + ใบคืน)   (ใบยืม 3 ประเภท)
	 *   deduct = false : ยอดค้าง = จำนวนในเอกสาร − ใบคืน
	 *   demo   = true  : ตั้ง tb_product.demo_ckk = 1 ให้สินค้ามี S/N ที่คืน (ตามฟอร์มเดิมของ BR / ฝากขาย / BREQ)
	 * คีย์ทางเลือก (ไม่ใส่ = ไม่ใช้):
	 *   qty_extra      : คอลัมน์ที่บวกเข้าจำนวนของแถว (ของแถมใบเช่า)
	 *   item_where     : เงื่อนไขกรองแถวรายการ (alias i) — ค่าคงที่ในตารางนี้เท่านั้น
	 *   company_map    : ค่าบริษัทของต้นทาง => type_company ของใบคืน (ไม่ใส่ = 1 คือ AWL ที่เหลือ NBM)
	 *   approve_values : ค่าที่ถือว่าอนุมัติแล้ว (ไม่ใส่ = 'Approve')
	 *   require_doc_no : true = ต้องมีเลขที่เอกสารก่อนจึงคืนได้
	 * clear_col = null : ไม่เขียนสถานะกลับไปที่รายการของต้นทาง ยอดค้างคำนวณจากใบคืนอย่างเดียว
	 */
	function rc_source_config($type = null)
	{
		static $config = null;
		if ($config === null) {
			$config = array(
				'br' => array(
					'label' => 'ใบยืม', 'head' => 'hos__br', 'key' => 'ref_id_br', 'doc_no' => 'iv_no',
					'approve_col' => 'status_doc', 'company_col' => 'company',
					'customer' => 'customer', 'customer_id' => 'customer_id', 'address' => 'address', 'tel' => null,
					'sale_code' => 'sale_code', 'sale_name' => 'add_by', 'order_id' => null,
					'item' => 'hos__subbr', 'item_key' => 'ref_idd_br', 'item_id' => 'id', 'product' => 'product_id',
					'qty' => 'count', 'sn' => 'sn', 'lot' => 'lot', 'remark' => 'sale_remark', 'price' => 'price',
					'clear_col' => 'clear_ckk', 'close_col' => 'close_br', 'return_col' => null,
					'deduct' => true, 'demo' => true,
				),
				'consig' => array(
					'label' => 'ใบยืมฝากขาย', 'head' => 'hos__consig', 'key' => 'ref_id', 'doc_no' => 'iv_no',
					'approve_col' => 'status_doc', 'company_col' => 'company',
					'customer' => 'customer', 'customer_id' => 'customer_id', 'address' => 'address', 'tel' => null,
					'sale_code' => 'sale_code', 'sale_name' => 'add_by', 'order_id' => null,
					'item' => 'hos__subconsig', 'item_key' => 'ref_idd', 'item_id' => 'id', 'product' => 'product_id',
					'qty' => 'count', 'sn' => 'sn', 'lot' => 'lot_no', 'remark' => 'sale_remark', 'price' => 'price',
					'clear_col' => 'clear_ckk', 'close_col' => 'close_br', 'return_col' => null,
					'deduct' => true, 'demo' => true,
				),
				'breq' => array(
					'label' => 'ใบยืม BREQ', 'head' => 'in__br', 'key' => 'ref_id_br', 'doc_no' => 'iv_no',
					'approve_col' => 'status_doc', 'company_col' => 'company',
					'customer' => 'customer', 'customer_id' => 'customer_id', 'address' => 'address', 'tel' => null,
					'sale_code' => 'sale_code', 'sale_name' => 'add_by', 'order_id' => 'po_no',
					'item' => 'in__subbr', 'item_key' => 'ref_idd_br', 'item_id' => 'id', 'product' => 'product_id',
					'qty' => 'count', 'sn' => 'sn', 'lot' => 'lot', 'remark' => 'sale_remark', 'price' => 'price',
					'clear_col' => 'clear_ckk', 'close_col' => 'close_br', 'return_col' => 'return_product',
					'deduct' => true, 'demo' => true,
				),
				'breg' => array(
					'label' => 'ใบขอเบิกอะไหล่จากสินค้าขาย', 'head' => 'hos__breg', 'key' => 'ref_id', 'doc_no' => 'iv_no',
					'approve_col' => 'status_doc', 'company_col' => 'type_doc',
					'customer' => 'customer_name', 'customer_id' => null, 'address' => null, 'tel' => null,
					'sale_code' => 'sale_code', 'sale_name' => 'add_by', 'order_id' => null,
					'item' => 'hos__subbreg1', 'item_key' => 'ref_id1', 'item_id' => 'id_sub1', 'product' => 'product_id1',
					'qty' => 'count1', 'sn' => 'sn_number1', 'lot' => null, 'remark' => 'remark_eng1', 'price' => null,
					'clear_col' => 'clear_ckk', 'close_col' => null, 'return_col' => null,
					'deduct' => false, 'demo' => false,
				),
				'smp' => array(
					'label' => 'ใบเบิกสินค้าเพื่อสนับสนุนการขาย', 'head' => 'hos__smp', 'key' => 'ref_idsmp', 'doc_no' => 'smp_no',
					'approve_col' => 'status_sup', 'company_col' => 'type_company',
					'customer' => 'customer_name', 'customer_id' => null, 'address' => 'address_name', 'tel' => 'customer_tel',
					'sale_code' => 'sale_code', 'sale_name' => 'sale_name', 'order_id' => 'order_id',
					'item' => 'hos__subsmp', 'item_key' => 'reff_idsmp', 'item_id' => 'subsmp_id', 'product' => 'product_id',
					'qty' => 'sale_count', 'sn' => 'sn', 'lot' => 'lot_no', 'remark' => 'sale_remark', 'price' => 'unit_price',
					'clear_col' => 'clear_ckk', 'close_col' => null, 'return_col' => null,
					'deduct' => false, 'demo' => false,
				),
				// จำนวนที่คืนได้ = จำนวนเช่า + ของแถม; ไม่แตะการปิดการเช่า (hos__rental_runiv) และ ref_rt
				'rental' => array(
					'label' => 'ใบสั่งเช่า', 'head' => 'hos__rental', 'key' => 'ref_id', 'doc_no' => 'iv_no',
					'approve_col' => 'status_doc', 'company_col' => 'type_doc',
					'customer' => 'rental_name', 'customer_id' => 'rental_id', 'address' => 'rental_address', 'tel' => 'rental_tel',
					'sale_code' => 'sale_code', 'sale_name' => 'add_by', 'order_id' => null,
					'item' => 'hos__subrental', 'item_key' => 'ref_idd', 'item_id' => 'id_sub', 'product' => 'product_id',
					'qty' => 'count', 'sn' => 'sn_number', 'lot' => null, 'remark' => 'remark_sale', 'price' => 'price',
					'clear_col' => null, 'close_col' => null, 'return_col' => null,
					'deduct' => false, 'demo' => false,
					'qty_extra' => 'free_count', 'company_map' => array('3' => '3', '4' => '4'),
					'approve_values' => array('Approve', 'อนุมัติแล้ว'), 'require_doc_no' => true,
				),
				// คืนเฉพาะฝั่งแลกเข้า (count_stock) ตามจำนวน — S/N ของแถวไม่รู้ว่าเป็นของฝั่งไหนจึงไม่ใช้
				'change' => array(
					'label' => 'ใบแลกเปลี่ยนสินค้า', 'head' => 'hos__change', 'key' => 'ref_id', 'doc_no' => 'iv_no',
					'approve_col' => 'status_doc', 'company_col' => 'company',
					'customer' => 'customer', 'customer_id' => 'customer_id', 'address' => 'address', 'tel' => null,
					'sale_code' => 'sale_code', 'sale_name' => 'add_by', 'order_id' => null,
					'item' => 'hos__subchange', 'item_key' => 'ref_idd', 'item_id' => 'id', 'product' => 'product_id',
					'qty' => 'count_stock', 'sn' => null, 'lot' => null, 'remark' => 'sale_remark', 'price' => 'price',
					'clear_col' => null, 'close_col' => null, 'return_col' => null,
					'deduct' => false, 'demo' => false,
					'require_doc_no' => true,
				),
				// คืนอะไหล่ที่เบิกจากคลังแต่ไม่ได้ใช้ — แถวที่ตัดจากใบยืม (clear_br = 1) คืนผ่านใบยืมต้นทาง
				'spr' => array(
					'label' => 'ใบเบิกอะไหล่ (SPR)', 'head' => 'hos__spr', 'key' => 'ref_id', 'doc_no' => 'spr_no',
					'approve_col' => 'status_doc', 'company_col' => 'type_company',
					'customer' => 'customer', 'customer_id' => null, 'address' => 'address', 'tel' => null,
					'sale_code' => 'sale_code', 'sale_name' => 'add_by', 'order_id' => null,
					'item' => 'hos__subspr', 'item_key' => 'ref_idd', 'item_id' => 'id', 'product' => 'product_id',
					'qty' => 'sale_count', 'sn' => 'sn', 'lot' => null, 'remark' => 'sale_remark', 'price' => 'unit_price',
					'clear_col' => null, 'close_col' => null, 'return_col' => null,
					'deduct' => false, 'demo' => false,
					'item_where' => 'i.clear_br <> 1', 'require_doc_no' => true,
				),
			);
		}
		if ($type === null) {
			return $config;
		}
		return isset($config[$type]) ? $config[$type] : null;
	}
}

if (!function_exists('rc_source_pages')) {
	/**
	 * หน้าที่เกี่ยวกับเอกสารต้นทางแต่ละประเภท: list = หน้ารายการที่ปุ่ม "คืนสินค้า" อยู่ (ปุ่มย้อนกลับ), view = หน้าเอกสารต้นทาง, param = ชื่อ query ของ key
	 * @return array{list:string,view:string,param:string}|null
	 */
	function rc_source_pages($type)
	{
		static $pages = array(
			'br'     => array('list' => 'status_supbrhos.php', 'view' => 'register_supbrhos.php', 'param' => 'ref_id_br'),
			'consig' => array('list' => 'status_adminbrsc.php', 'view' => 'register_supbrcshos.php', 'param' => 'ref_id'),
			'breq'   => array('list' => 'status_brhos_breq.php', 'view' => 'register_breng_brgq.php', 'param' => 'ref_id_br'),
			'breg'   => array('list' => 'status_engbreg.php', 'view' => 'register_bregawl.php', 'param' => 'ref_id'),
			'smp'    => array('list' => 'status_samplesup.php', 'view' => 'register_supsmp.php', 'param' => 'ref_idsmp'),
			'rental' => array('list' => 'status_suprental.php', 'view' => 'register_suprental.php', 'param' => 'ref_id'),
			'change' => array('list' => 'status_adminchange.php', 'view' => 'register_supchange.php', 'param' => 'ref_id'),
			'spr'    => array('list' => 'status_spr.php', 'view' => 'register_engspr.php', 'param' => 'ref_id'),
		);
		return isset($pages[$type]) ? $pages[$type] : null;
	}
}

if (!function_exists('rc_new_url')) {
	/** ปุ่ม "คืนสินค้า" ในหน้ารายการ → ฟอร์มใบคืนใบใหม่ของเอกสารต้นทางนั้น */
	function rc_new_url($type, $ref)
	{
		return 'register_receive.php?source_type=' . rawurlencode((string)$type) . '&source_ref=' . rawurlencode((string)$ref);
	}
}

if (!function_exists('rc_source_view_url')) {
	function rc_source_view_url($type, $ref)
	{
		$pages = rc_source_pages($type);
		return $pages === null ? '' : $pages['view'] . '?' . $pages['param'] . '=' . rawurlencode((string)$ref);
	}
}

if (!function_exists('rc_actor_name')) {
	function rc_actor_name(array $session)
	{
		return trim((string)($session['name'] ?? '') . ' ' . (string)($session['surname'] ?? ''));
	}
}

if (!function_exists('rc_fetch_all')) {
	function rc_fetch_all($conn, $sql, $types, array $params)
	{
		$stmt = mysqli_prepare($conn, $sql);
		if (!$stmt) {
			throw new RuntimeException(mysqli_error($conn));
		}
		if ($types !== '') {
			mysqli_stmt_bind_param($stmt, $types, ...$params);
		}
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		$rows = array();
		while ($result && ($row = mysqli_fetch_assoc($result))) {
			$rows[] = $row;
		}
		mysqli_stmt_close($stmt);
		return $rows;
	}
}

if (!function_exists('rc_trim_number')) {
	/** 2.00 → "2", 2.50 → "2.5" */
	function rc_trim_number($value)
	{
		$text = number_format((float)$value, 2, '.', '');
		$text = rtrim(rtrim($text, '0'), '.');
		return $text === '' ? '0' : $text;
	}
}

if (!function_exists('rc_valid_iso_date')) {
	function rc_valid_iso_date($value)
	{
		if (!preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', (string)$value, $m)) {
			return false;
		}
		return (int)$m[1] > 0 && checkdate((int)$m[2], (int)$m[3], (int)$m[1]);
	}
}

if (!function_exists('rc_parse_serials')) {
	/** S/N ของรายการต้นทางเป็นข้อความหลายบรรทัด → รายการ S/N ไม่ซ้ำ เรียงตามที่กรอก */
	function rc_parse_serials($text)
	{
		$serials = array();
		foreach (preg_split('/\r\n|\r|\n/', (string)$text) as $part) {
			$part = trim($part);
			if ($part !== '' && !in_array($part, $serials, true)) {
				$serials[] = $part;
			}
		}
		return $serials;
	}
}

if (!function_exists('rc_company_options')) {
	/** mapping ของ hos__receive.type_company: 3 = AWL, 4 = NBM */
	function rc_company_options()
	{
		return array('3' => 'AWL', '4' => 'NBM');
	}
}

if (!function_exists('rc_company_from_source')) {
	/** ค่า 1 ในเอกสารต้นทางคือ AWL ที่เหลือคือ NBM */
	function rc_company_from_source($value)
	{
		return ((string)$value === '1') ? '3' : '4';
	}
}

if (!function_exists('rc_time_range_options')) {
	/** ค่าชุดเดียวกับ sql/delivery_time_range.sql */
	function rc_time_range_options()
	{
		return array('morning' => 'ช่วงเช้า', 'afternoon' => 'ช่วงบ่าย', 'allday' => 'ทั้งวัน', 'specific' => 'กำหนดเวลา');
	}
}

if (!function_exists('rc_load_source')) {
	/**
	 * หัวเอกสารต้นทางแบบ normalize — คืน null เมื่อไม่พบเอกสาร
	 * approved = เอกสารอนุมัติแล้ว (เงื่อนไขเปิดฟอร์มคืนสินค้า)
	 */
	function rc_load_source($conn, $type, $ref)
	{
		$cfg = rc_source_config($type);
		$ref = trim((string)$ref);
		if ($cfg === null || $ref === '') {
			return null;
		}
		$rows = rc_fetch_all($conn, "SELECT * FROM `{$cfg['head']}` WHERE `{$cfg['key']}` = ? LIMIT 1", 's', array($ref));
		if (count($rows) === 0) {
			return null;
		}
		$head = $rows[0];
		$col = function ($name) use ($head) {
			return ($name !== null && isset($head[$name])) ? trim((string)$head[$name]) : '';
		};

		$tel = $col($cfg['tel']);
		$customerId = $col($cfg['customer_id']);
		if ($tel === '' && $customerId !== '' && (int)$customerId > 0) {
			$customerRows = rc_fetch_all($conn, "SELECT cus_tel FROM tb_customer WHERE customer_id = ? LIMIT 1", 'i', array((int)$customerId));
			$tel = count($customerRows) ? trim((string)$customerRows[0]['cus_tel']) : '';
		}

		$docNo = $col($cfg['doc_no']);
		$company = $col($cfg['company_col']);
		$companyMap = $cfg['company_map'] ?? null;

		return array(
			'type'          => $type,
			'ref'           => $ref,
			'label'         => $cfg['label'],
			'doc_no'        => $docNo,
			'approved'      => in_array($col($cfg['approve_col']), $cfg['approve_values'] ?? array('Approve'), true),
			'needs_doc_no'  => !empty($cfg['require_doc_no']) && $docNo === '',
			'type_company'  => ($companyMap !== null && isset($companyMap[$company])) ? $companyMap[$company] : rc_company_from_source($company),
			'customer_id'   => $customerId,
			'customer_name' => $col($cfg['customer']),
			'customer_tel'  => $tel,
			'address'       => $col($cfg['address']),
			'sale_code'     => $col($cfg['sale_code']),
			'sale_name'     => $col($cfg['sale_name']),
			'order_id'      => $col($cfg['order_id']),
			'close'         => ($cfg['close_col'] !== null) ? $col($cfg['close_col']) : '',
			'head'          => $head,
		);
	}
}

if (!function_exists('rc_customer_card')) {
	/**
	 * รหัสสมาชิก/ประเภท/สถานะ/วงเงินเครดิตสำหรับการ์ดข้อมูลลูกค้า (อ่านอย่างเดียว) — ที่มาเดียวกับ register_credinot.php
	 * คืน null เมื่อต้นทางไม่มีรหัสลูกค้า (ใบขอเบิกอะไหล่, SMP)
	 */
	function rc_customer_card($conn, array $source)
	{
		if ((int)$source['customer_id'] <= 0) {
			return null;
		}
		$rows = rc_fetch_all($conn, "SELECT customer_no, type_customer, credit_thb, status_cus, vip_ckk FROM tb_customer WHERE customer_id = ? LIMIT 1", 'i', array((int)$source['customer_id']));
		if (count($rows) === 0) {
			return null;
		}
		$row = $rows[0];
		$statusNames = array('0' => 'Gold Customer', '1' => 'Platinum Customer', '2' => 'Diamond Customer');
		$typeName = '';
		if (trim((string)$row['type_customer']) !== '') {
			$typeRows = rc_fetch_all($conn, "SELECT type_name FROM tb_typecustomer WHERE type_id = ? LIMIT 1", 's', array((string)$row['type_customer']));
			$typeName = count($typeRows) ? (string)$typeRows[0]['type_name'] : '';
		}
		return array(
			'customer_no' => (string)$row['customer_no'],
			'type_name'   => $typeName,
			'status_name' => $statusNames[trim((string)$row['status_cus'])] ?? '-',
			'is_vip'      => trim((string)$row['vip_ckk']) === '1',
			'credit'      => (is_numeric($row['credit_thb']) && (float)$row['credit_thb'] > 0) ? number_format((float)$row['credit_thb'], 2) : '0.00',
		);
	}
}

if (!function_exists('rc_load_source_items')) {
	function rc_load_source_items($conn, array $source)
	{
		$cfg = rc_source_config($source['type']);
		$optional = function ($col, $alias, $empty) {
			return ($col !== null) ? "i.`{$col}` AS {$alias}" : "{$empty} AS {$alias}";
		};
		$qty = "i.`{$cfg['qty']}`" . (!empty($cfg['qty_extra']) ? " + i.`{$cfg['qty_extra']}`" : '');
		$where = !empty($cfg['item_where']) ? " AND ({$cfg['item_where']})" : '';
		$sql = "SELECT i.`{$cfg['item_id']}` AS item_id, i.`{$cfg['product']}` AS product_id, ({$qty}) AS qty, "
			. $optional($cfg['sn'], 'sn', "''") . ', '
			. $optional($cfg['lot'], 'lot', "''") . ', '
			. $optional($cfg['remark'], 'remark', "''") . ', '
			. $optional($cfg['price'], 'price', '0') . ', '
			. $optional($cfg['clear_col'], 'clear_ckk', '0') . ', '
			. $optional($cfg['return_col'], 'return_product', '0') . ", "
			. "p.access_code, p.sol_name, p.unit_name
			FROM `{$cfg['item']}` i
			LEFT JOIN tb_product p ON p.product_ID = i.`{$cfg['product']}`
			WHERE i.`{$cfg['item_key']}` = ?{$where}
			ORDER BY i.`{$cfg['item_id']}` ASC";
		return rc_fetch_all($conn, $sql, 's', array($source['ref']));
	}
}

if (!function_exists('rc_others_cleared')) {
	/**
	 * ยอดที่ถูกเคลียร์ด้วยเอกสารอื่น (ไม่รวมใบคืน) ของใบยืม — เงื่อนไขชุดเดียวกับ ajax_get_clear_br_details.php
	 * @return array{qty:array<string,float>,sn:array<string,array<string,bool>>}  คีย์แรกคือ product_id
	 */
	function rc_others_cleared($conn, $docNo)
	{
		$out = array('qty' => array(), 'sn' => array());
		if ($docNo === '') {
			return $out;
		}
		$sources = array(
			array('hos__subso', 'count', 'sn', "clear_br = '1' AND clear_ivno = ? AND status_so = 'Approve'", ''),
			array('hos__subspr', 'sale_count', 'sn', "clear_br = '1' AND clear_ivno = ? AND status_spr = 'Approve'", ''),
			array('hos__subsmp', 'sale_count', 'sn', "clear_br = '1' AND br_no = ? AND status_smp = 'Approve'", ''),
			array(
				'so__submain', 'sale_count', 'sn_number',
				"clear_br = '1' AND status_sol = 'Approve' AND clear_ivno1 = ?
				 AND ref_idd IN (SELECT ref_id FROM so__main WHERE approve_complete = 'Approve' AND cancel_ckk = '0')",
				'',
			),
		);
		foreach ($sources as $source) {
			list($table, $qtyCol, $snCol, $where) = $source;
			foreach (rc_fetch_all($conn, "SELECT product_id AS pid, SUM(`{$qtyCol}`) AS q FROM `{$table}` WHERE {$where} GROUP BY product_id", 's', array($docNo)) as $row) {
				$pid = (string)(int)$row['pid'];
				$out['qty'][$pid] = ($out['qty'][$pid] ?? 0) + (float)$row['q'];
			}
			foreach (rc_fetch_all($conn, "SELECT product_id AS pid, `{$snCol}` AS sn FROM `{$table}` WHERE {$where} AND `{$snCol}` <> ''", 's', array($docNo)) as $row) {
				$pid = (string)(int)$row['pid'];
				foreach (rc_parse_serials($row['sn']) as $serial) {
					$out['sn'][$pid][$serial] = true;
				}
			}
		}
		return $out;
	}
}

if (!function_exists('rc_returned')) {
	/**
	 * ยอดที่คืนแล้วของเอกสารต้นทางหนึ่งใบ — นับใบคืนเก่า (source_type ว่าง จับคู่ด้วย iv_no) และใบใหม่ (จับคู่ด้วยคอลัมน์ต้นทาง)
	 * $excludeRef = ref_id ของใบที่กำลังแก้ (ไม่นับตัวเอง)
	 * @return array{qty:array<string,float>,sn:array<string,array<string,bool>>}
	 */
	function rc_returned($conn, array $source, $excludeRef = '')
	{
		$match = "((r.source_type = ? AND r.source_ref = ?)";
		$types = 'ss';
		$params = array($source['type'], $source['ref']);
		if ($source['doc_no'] !== '') {
			$match .= " OR (r.source_type = '' AND r.iv_no = ?)";
			$types .= 's';
			$params[] = $source['doc_no'];
		}
		$match .= ") AND r.ref_id <> ?";
		$types .= 's';
		$params[] = (string)$excludeRef;

		$out = array('qty' => array(), 'sn' => array());
		$from = "FROM hos__receive r JOIN hos__subreceive s ON s.ref_idd = r.ref_id WHERE {$match}";
		foreach (rc_fetch_all($conn, "SELECT s.product_id AS pid, SUM(s.`count`) AS q {$from} GROUP BY s.product_id", $types, $params) as $row) {
			$out['qty'][(string)(int)$row['pid']] = (float)$row['q'];
		}
		foreach (rc_fetch_all($conn, "SELECT s.product_id AS pid, s.sn AS sn {$from} AND s.sn <> ''", $types, $params) as $row) {
			foreach (rc_parse_serials($row['sn']) as $serial) {
				$out['sn'][(string)(int)$row['pid']][$serial] = true;
			}
		}
		return $out;
	}
}

if (!function_exists('rc_compute')) {
	/**
	 * ยอดค้างของเอกสารต้นทาง → รายการที่คืนได้ (lines) และสถานะรายแถวของต้นทาง (rows)
	 *
	 * แถวที่มี S/N ตัดรายเครื่อง (เครื่องที่เคลียร์/คืนแล้วไม่แสดง) ส่วนแถวไม่มี S/N ตัดตามจำนวนรวมของสินค้านั้น
	 * โดยหักยอดเคลียร์ทีละแถวเรียงตามลำดับ — ใช้ยอดรวมต่อสินค้าเหมือนสูตรเดิม ไม่ใช่ตรวจทีละแถวแบบไม่สะสม
	 * $excludeRef = ใบคืนที่กำลังแก้ ไม่นับเป็นยอดคืน
	 *
	 * @return array{lines:array<int,array>,rows:array<int,array>,outstanding:array<string,float>}
	 */
	function rc_compute($conn, array $source, $excludeRef = '')
	{
		$cfg = rc_source_config($source['type']);
		$items = rc_load_source_items($conn, $source);
		$others = $cfg['deduct'] ? rc_others_cleared($conn, $source['doc_no']) : array('qty' => array(), 'sn' => array());
		$returned = rc_returned($conn, $source, $excludeRef);

		$pool = array();    // ยอดที่เคลียร์แล้วของสินค้า (ทุกแหล่ง) ที่ยังไม่ได้หักออกจากแถวไม่มี S/N
		$retPool = array(); // เฉพาะยอดคืน — ไว้ตั้ง in__subbr.return_product
		$lines = array();
		$rows = array();
		$outstanding = array();

		foreach ($items as $item) {
			$pid = (string)(int)$item['product_id'];
			$qty = (float)$item['qty'];
			$serials = rc_parse_serials($item['sn']);

			$base = array(
				'item_id'     => (int)$item['item_id'],
				'product_id'  => $pid,
				'access_code' => (string)($item['access_code'] ?? ''),
				'sol_name'    => (string)($item['sol_name'] ?? ''),
				'unit_name'   => (string)($item['unit_name'] ?? ''),
				'lot'         => (string)$item['lot'],
				'remark'      => (string)$item['remark'],
				'price'       => (float)$item['price'],
			);

			if (count($serials) > 0) {
				$out = 0;
				$ret = 0;
				foreach ($serials as $index => $serial) {
					$isReturned = isset($returned['sn'][$pid][$serial]);
					if ($isReturned) {
						$ret++;
					}
					if ($isReturned || isset($others['sn'][$pid][$serial])) {
						continue;
					}
					$out++;
					$lines[] = $base + array('key' => $item['item_id'] . ':' . $index, 'sn' => $serial, 'has_sn' => true, 'qty_max' => 1);
				}
			} else {
				if (!isset($pool[$pid])) {
					$pool[$pid] = ($others['qty'][$pid] ?? 0) + ($returned['qty'][$pid] ?? 0);
					$retPool[$pid] = $returned['qty'][$pid] ?? 0;
				}
				$take = min($qty, $pool[$pid]);
				$pool[$pid] -= $take;
				$out = $qty - $take;
				$ret = min($qty, $retPool[$pid]);
				$retPool[$pid] -= $ret;
				$whole = floor($out + RC_EPSILON);
				if ($whole >= 1) {
					$lines[] = $base + array('key' => (string)$item['item_id'], 'sn' => '', 'has_sn' => false, 'qty_max' => $whole);
				}
			}

			$rows[(int)$item['item_id']] = array(
				'product_id' => $pid,
				'clear'      => (int)$item['clear_ckk'],
				'out'        => $out,
				'returned'   => $ret,
				'return_now' => (float)$item['return_product'],
			);
		}

		foreach ($lines as $line) {
			$outstanding[$line['product_id']] = ($outstanding[$line['product_id']] ?? 0) + $line['qty_max'];
		}
		return array('lines' => $lines, 'rows' => $rows, 'outstanding' => $outstanding);
	}
}

if (!function_exists('rc_lines_by_key')) {
	function rc_lines_by_key(array $lines)
	{
		$map = array();
		foreach ($lines as $line) {
			$map[$line['key']] = $line;
		}
		return $map;
	}
}

if (!function_exists('rc_load_receipt')) {
	function rc_load_receipt($conn, $ref, $forUpdate = false)
	{
		$rows = rc_fetch_all($conn, "SELECT * FROM hos__receive WHERE ref_id = ? ORDER BY id_auto DESC LIMIT 1" . ($forUpdate ? " FOR UPDATE" : ""), 's', array((string)$ref));
		return count($rows) ? $rows[0] : null;
	}
}

if (!function_exists('rc_load_receipt_lines')) {
	function rc_load_receipt_lines($conn, $ref)
	{
		return rc_fetch_all($conn, "SELECT id, product_id, `count` AS qty, sn, stock_remark FROM hos__subreceive WHERE ref_idd = ? ORDER BY id ASC", 's', array((string)$ref));
	}
}

if (!function_exists('rc_is_submitted')) {
	function rc_is_submitted(array $receipt)
	{
		return (int)($receipt['send_stock'] ?? 0) === RC_SEND_SUBMITTED;
	}
}

if (!function_exists('rc_is_unified')) {
	/** ใบคืนที่สร้างจากฟอร์มใหม่ (มีต้นทาง) — ใบเก่าเปิดด้วยหน้าแก้ไขเดิม */
	function rc_is_unified(array $receipt)
	{
		return trim((string)($receipt['source_type'] ?? '')) !== '';
	}
}

if (!function_exists('rc_status_info')) {
	/** @return array{key:string,label:string,color:string} */
	function rc_status_info(array $receipt)
	{
		if (rc_is_submitted($receipt)) {
			return array('key' => 'submitted', 'label' => 'ส่งให้ Stock แล้ว', 'color' => '#2E7D32');
		}
		return array('key' => 'draft', 'label' => 'Draft', 'color' => '#FFA500');
	}
}

if (!function_exists('rc_selection_for_receipt')) {
	/**
	 * ใบคืนที่บันทึกไว้ → ค่าติ๊กในฟอร์ม (key => array(qty, remark))
	 * แถวมี S/N จับคู่ด้วยสินค้า + S/N ส่วนแถวไม่มี S/N แบ่งจำนวนของสินค้านั้นลงแถวตามลำดับ ไม่เกินยอดค้างของแถว
	 * $lines ต้องคำนวณโดยไม่นับใบที่กำลังแก้
	 */
	function rc_selection_for_receipt(array $lines, array $receiptLines)
	{
		$selection = array();
		$plain = array();
		foreach ($receiptLines as $row) {
			if (trim((string)$row['sn']) === '') {
				$pid = (string)(int)$row['product_id'];
				$plain[$pid]['qty'] = ($plain[$pid]['qty'] ?? 0) + (float)$row['qty'];
				$plain[$pid]['remark'] = (string)$row['stock_remark'];
			}
		}
		// ลำดับของ $selection = ลำดับแถวที่บันทึก (id) — หน้าฟอร์มใช้เรียงรายการตามที่ผู้ใช้ลากไว้
		$plainDone = array();
		foreach ($receiptLines as $row) {
			$pid = (string)(int)$row['product_id'];
			$serial = trim((string)$row['sn']);
			if ($serial !== '') {
				foreach ($lines as $line) {
					if ($line['has_sn'] && $line['product_id'] === $pid && $line['sn'] === $serial) {
						$selection[$line['key']] = array('qty' => 1, 'remark' => (string)$row['stock_remark']);
						break;
					}
				}
			} elseif (!isset($plainDone[$pid])) {
				$plainDone[$pid] = true;
				foreach ($lines as $line) {
					if ($line['has_sn'] || $line['product_id'] !== $pid || $plain[$pid]['qty'] < 1) {
						continue;
					}
					$take = min($line['qty_max'], $plain[$pid]['qty']);
					$plain[$pid]['qty'] -= $take;
					$selection[$line['key']] = array('qty' => $take, 'remark' => $plain[$pid]['remark']);
				}
			}
		}
		return $selection;
	}
}

if (!function_exists('rc_expiry_for_lines')) {
	/**
	 * วันหมดอายุของแถว S/N จากฐาน Stock ($new = allwell_stock_test) — อ่านอย่างเดียว ทำเป็นชุดเดียวต่อหน้า
	 * ลำดับแหล่ง (เอาค่าแรกที่พบ):
	 *   1) product__instock.qr_expiry   จากการยิง QR ระดับ S/N (PK = product_sn)
	 *   2) st__lotnodes (S/N → lot_no) → st__lotno.date_expir
	 *   3) st__lotno.date_expir จับคู่ (product_id, lot_no) ของแถวต้นทางตรง ๆ — เงื่อนไขเดียวกับ report_salehosnbm1.php
	 * ทั้งสามแหล่งอาจไม่ตรงกัน และข้อมูล QR เริ่มปี 2025 — ไม่พบ/ฐาน Stock ใช้ไม่ได้ = ว่าง ไม่ทำให้หน้าล้ม
	 * @param array $lines  แถวจาก rc_compute() เฉพาะที่ has_sn
	 * @return array<string,string>  key (line key) => 'YYYY-MM' | 'YYYY-MM-DD'
	 */
	function rc_expiry_for_lines($stockConn, array $lines)
	{
		$result = array();
		$snLines = array_values(array_filter($lines, function ($line) {
			return !empty($line['has_sn']) && $line['sn'] !== '';
		}));
		if (!($stockConn instanceof mysqli) || count($snLines) === 0) {
			return $result;
		}
		$validDate = function ($value) {
			$value = trim((string)$value);
			return preg_match('/^\d{4}-\d{2}(-\d{2})?$/', $value) && substr($value, 0, 4) !== '0000' && substr($value, 5, 2) !== '00' && substr($value, 0, 10) !== '0000-00-00' ? $value : '';
		};
		try {
			$serials = array_values(array_unique(array_map(function ($line) { return $line['sn']; }, $snLines)));
			$productIds = array_values(array_unique(array_map(function ($line) { return (int)$line['product_id']; }, $snLines)));

			// 1) QR ระดับ S/N
			$qr = array();
			foreach (array_chunk($serials, 500) as $chunk) {
				$rows = rc_fetch_all($stockConn, "SELECT product_sn, qr_expiry FROM product__instock WHERE qr_expiry <> '' AND product_sn IN (" . implode(',', array_fill(0, count($chunk), '?')) . ")", str_repeat('s', count($chunk)), $chunk);
				foreach ($rows as $row) {
					$qr[trim((string)$row['product_sn'])] = $validDate($row['qr_expiry']);
				}
			}

			// วันหมดอายุระดับล็อตของสินค้าเหล่านี้ (key = product_id|lot_no) — ใช้ทั้งข้อ 2 และ 3, ซ้ำให้ใช้แถวแรก (id น้อยสุด)
			$lotDates = array();
			$rows = rc_fetch_all($stockConn, "SELECT product_id, lot_no, date_expir FROM st__lotno WHERE date_expir >= '1900-01-01' AND product_id IN (" . implode(',', array_fill(0, count($productIds), '?')) . ") ORDER BY id ASC", str_repeat('i', count($productIds)), $productIds);
			foreach ($rows as $row) {
				$lotKey = (int)$row['product_id'] . '|' . trim((string)$row['lot_no']);
				if (!isset($lotDates[$lotKey])) {
					$lotDates[$lotKey] = $validDate($row['date_expir']);
				}
			}

			// 2) S/N → ล็อต (เฉพาะ S/N ที่ QR ไม่มี และไม่เกิน 200 เครื่อง — st__lotnodes ไม่มี index ที่ sn_num)
			$serialLot = array();
			$missing = array_values(array_filter($serials, function ($serial) use ($qr) {
				return empty($qr[$serial]);
			}));
			if (count($missing) > 0 && count($missing) <= 200) {
				$likes = implode(' OR ', array_fill(0, count($missing), 'sn_num LIKE ?'));
				$params = array_merge($productIds, array_map(function ($serial) {
					return '%' . addcslashes($serial, '%_\\') . '%';
				}, $missing));
				$rows = rc_fetch_all($stockConn, "SELECT product_id, lot_no, sn_num FROM st__lotnodes WHERE sn_num <> '' AND product_id IN (" . implode(',', array_fill(0, count($productIds), '?')) . ") AND ({$likes}) ORDER BY id ASC", str_repeat('i', count($productIds)) . str_repeat('s', count($missing)), $params);
				$wanted = array_flip($missing);
				foreach ($rows as $row) {
					// sn_num บางแถวมี "\n" แบบตัวอักษรต่อท้าย หรือหลาย S/N ในแถวเดียว — แยกด้วยบรรทัดใหม่จริง, \n ตัวอักษร, จุลภาค, ช่องว่าง
					foreach (preg_split('/\\\\n|\r\n|\r|\n|[,;\s]+/', (string)$row['sn_num']) as $token) {
						$token = trim($token);
						if ($token !== '' && isset($wanted[$token]) && !isset($serialLot[(int)$row['product_id'] . '|' . $token])) {
							$serialLot[(int)$row['product_id'] . '|' . $token] = trim((string)$row['lot_no']);
						}
					}
				}
			}

			foreach ($snLines as $line) {
				$date = $qr[$line['sn']] ?? '';
				if ($date === '' && isset($serialLot[(int)$line['product_id'] . '|' . $line['sn']])) {
					$date = $lotDates[(int)$line['product_id'] . '|' . $serialLot[(int)$line['product_id'] . '|' . $line['sn']]] ?? '';
				}
				if ($date === '' && trim((string)$line['lot']) !== '') {
					$date = $lotDates[(int)$line['product_id'] . '|' . trim((string)$line['lot'])] ?? '';
				}
				if ($date !== '') {
					$result[$line['key']] = $date;
				}
			}
		} catch (Throwable $e) {
			error_log('[rc_expiry_for_lines] ' . $e->getMessage());
			return array();
		}
		return $result;
	}
}

if (!function_exists('rc_format_expiry')) {
	/** 'YYYY-MM-DD' → DD/MM/YY (พ.ศ. 2 หลัก, เช่น 2030-07-02 → 02/07/73) | 'YYYY-MM' → MM/YY | ว่าง/ผิดรูปแบบ → '' */
	function rc_format_expiry($value)
	{
		if (!preg_match('/^(\d{4})-(\d{2})(?:-(\d{2}))?$/', trim((string)$value), $m)) {
			return '';
		}
		$year = substr((string)((int)$m[1] + 543), -2);
		return isset($m[3]) ? $m[3] . '/' . $m[2] . '/' . $year : $m[2] . '/' . $year;
	}
}

if (!function_exists('rc_post_value')) {
	function rc_post_value(array $post, $key, $default = '')
	{
		if (!isset($post[$key]) || is_array($post[$key])) {
			return $default;
		}
		return trim((string)$post[$key]);
	}
}

if (!function_exists('rc_limit_text')) {
	function rc_limit_text($value, $max, $label)
	{
		if (mb_strlen($value, 'UTF-8') > $max) {
			throw new RcValidationException($label . ' ยาวเกิน ' . $max . ' ตัวอักษร');
		}
		return $value;
	}
}

if (!function_exists('rc_header_from_post')) {
	/**
	 * หัวใบคืนจากฟอร์ม — บริษัท/เลขที่เอกสาร/ชื่อลูกค้า/เบอร์โทรล็อกตามต้นทาง ไม่รับจากผู้ใช้
	 * Save Draft และ Submit ตรวจเท่ากัน (Q24)
	 */
	function rc_header_from_post(array $post, array $source)
	{
		$receiveCkk = rc_post_value($post, 'receive_ckk');
		if ($receiveCkk !== '1' && $receiveCkk !== '2') {
			throw new RcValidationException('กรุณาเลือกวิธีคืนสินค้า');
		}

		// ไม่บังคับกรอก (ตามภาพไม่มีดอกจัน) — เลือกคืนด้วยตัวเองแล้วไม่เก็บชื่อ
		$receiveName = $receiveCkk === '2' ? rc_limit_text(rc_post_value($post, 'receive_name'), 100, 'ชื่อบุคคลที่ฝากคืน') : '';

		$dateReceive = rc_post_value($post, 'date_receive');
		if (!rc_valid_iso_date($dateReceive)) {
			throw new RcValidationException('กรุณาเลือกวันที่ฝากคืน');
		}

		$address = rc_limit_text(rc_post_value($post, 'customer_address'), 1000, 'ที่อยู่');
		if ($address === '') {
			throw new RcValidationException('กรุณากรอกที่อยู่');
		}

		$timeBetween = rc_post_value($post, 'time_between');
		if ($timeBetween === '') {
			throw new RcValidationException('กรุณากรอกเวลาในการจัดส่ง');
		}
		// ช่องเลือกเวลา (type="time") ส่ง HH:MM — เวลาเริ่มจัดส่ง
		if (!preg_match('/^([01]\d|2[0-3]):[0-5]\d$/', $timeBetween)) {
			throw new RcValidationException('เวลาในการจัดส่งไม่ถูกต้อง');
		}

		$timeRange = rc_post_value($post, 'time_range');
		if ($timeRange !== '' && !array_key_exists($timeRange, rc_time_range_options())) {
			$timeRange = '';
		}

		return array(
			// บริษัทเลือกได้ AWL (3) / NBM (4) — ค่าที่ไม่รู้จักใช้บริษัทของเอกสารต้นทาง
			'type_company'     => array_key_exists(rc_post_value($post, 'type_company'), rc_company_options()) ? rc_post_value($post, 'type_company') : $source['type_company'],
			'receive_ckk'      => $receiveCkk,
			'receive_name'     => $receiveName,
			'date_receive'     => $dateReceive,
			'time_range'       => $timeRange,
			'time_between'     => $timeBetween,
			'customer_name'    => $source['customer_name'],
			'customer_tel'     => $source['customer_tel'],
			'customer_address' => $address,
			'sale_code'        => rc_limit_text(rc_post_value($post, 'sale_code', $source['sale_code']), 50, 'แผนก/เขตการขาย'),
			'sale_name'        => $source['sale_name'],
			'order_id'         => rc_limit_text(rc_post_value($post, 'order_id'), 100, 'หมายเลขคำสั่งซื้อ'),
			'remark_st'        => rc_limit_text(rc_post_value($post, 'remark_st'), 2000, 'คำอธิบายเพิ่มเติม'),
		);
	}
}

if (!function_exists('rc_choose_lines')) {
	/**
	 * รายการที่ติ๊กจากฟอร์ม (pick[key] / qty[key] / remark[key]) ตรวจกับยอดค้างที่คำนวณใหม่ฝั่งเซิร์ฟเวอร์
	 * ไม่เชื่อสินค้า/S/N จากหน้าเว็บ — ใช้เฉพาะ key แล้วดึงข้อมูลจริงจาก $lines
	 * ห้ามคืนเกินยอดค้างทั้งรายแถวและรวมทั้งสินค้า (รวมยอดทุกแถวของสินค้าเดียวกันในใบนี้ก่อนเทียบ)
	 * @return array<int,array>  แถวพร้อม insert: line + qty + remark
	 */
	function rc_choose_lines(array $post, array $lines, array $outstanding)
	{
		$pick = (isset($post['pick']) && is_array($post['pick'])) ? $post['pick'] : array();
		$qtys = (isset($post['qty']) && is_array($post['qty'])) ? $post['qty'] : array();
		$remarks = (isset($post['remark']) && is_array($post['remark'])) ? $post['remark'] : array();
		$byKey = rc_lines_by_key($lines);

		$chosen = array();
		$sumByProduct = array();
		// เรียงตามลำดับที่หน้าจอส่งมา (ผู้ใช้ลากเรียงได้) — insert ตามลำดับนี้ id ของ hos__subreceive จึงเก็บลำดับไว้
		foreach (array_keys($pick) as $postedKey) {
			$key = (string)$postedKey;
			if (!isset($byKey[$key])) {
				continue; // key ที่ไม่มีแล้วตรวจด้านล่าง
			}
			$line = $byKey[$key];
			if ((string)$pick[$postedKey] !== '1') {
				continue;
			}
			$label = trim($line['access_code'] . ' ' . $line['sol_name']) . ($line['sn'] !== '' ? ' (S/N ' . $line['sn'] . ')' : '');
			if ($line['has_sn']) {
				$qty = 1;
			} else {
				$raw = isset($qtys[$key]) && !is_array($qtys[$key]) ? trim(str_replace(',', '', (string)$qtys[$key])) : '';
				if (!preg_match('/^\d+$/', $raw) || (int)$raw < 1) {
					throw new RcValidationException($label . ': จำนวนต้องเป็นจำนวนเต็มมากกว่า 0');
				}
				$qty = (int)$raw;
			}
			if ($qty > $line['qty_max'] + RC_EPSILON) {
				throw new RcValidationException($label . ': คืนเกินยอดค้าง (ค้าง ' . rc_trim_number($line['qty_max']) . ')');
			}
			$sumByProduct[$line['product_id']] = ($sumByProduct[$line['product_id']] ?? 0) + $qty;
			$remark = isset($remarks[$key]) && !is_array($remarks[$key]) ? trim((string)$remarks[$key]) : '';
			$chosen[] = array('line' => $line, 'qty' => $qty, 'remark' => rc_limit_text($remark, 500, $label . ': หมายเหตุ'));
		}
		foreach (array_keys($pick) as $postedKey) {
			if (!isset($byKey[$postedKey])) {
				throw new RcValidationException('มีรายการที่ไม่มียอดค้างแล้ว (อาจมีผู้ใช้อื่นคืนไปก่อน) กรุณาโหลดหน้าใหม่');
			}
		}
		foreach ($sumByProduct as $productId => $sum) {
			if ($sum > ($outstanding[$productId] ?? 0) + RC_EPSILON) {
				throw new RcValidationException('คืนเกินยอดค้างของสินค้ารหัส ' . $productId . ' กรุณาโหลดหน้าใหม่');
			}
		}
		if (count($chosen) === 0) {
			throw new RcValidationException('กรุณาเลือกรายการที่จะคืนอย่างน้อย 1 รายการ');
		}
		return $chosen;
	}
}

if (!function_exists('rc_next_ref_id')) {
	/** ลำดับเลขเดิมของใบคืน (ฟอร์มเก่าออกเลขจากลำดับเดียวกัน) — ต้องเรียกภายใต้ named lock */
	function rc_next_ref_id($conn)
	{
		$rows = rc_fetch_all($conn, "SELECT MAX(CAST(ref_id AS UNSIGNED)) AS max_ref FROM hos__receive", '', array());
		return (string)((int)($rows[0]['max_ref'] ?? 0) + 1);
	}
}

if (!function_exists('rc_peek_next_ref_id')) {
	/** เลขถัดไป "โดยประมาณ" สำหรับหัวฟอร์ม — จองจริงตอน Save Draft / Submit ครั้งแรกเท่านั้น */
	function rc_peek_next_ref_id($conn)
	{
		return rc_next_ref_id($conn);
	}
}

if (!function_exists('rc_receive_fill_columns')) {
	/**
	 * คอลัมน์ NOT NULL ที่ไม่มี default ของ hos__receive ที่ตัวบันทึกไม่ได้กำหนดค่า — ใส่ '' / 0 ให้ครบ
	 * คอลัมน์วันที่/เวลาข้ามไป (ปล่อยให้เป็นค่าเริ่มต้นของ MySQL เหมือนตัวบันทึกเดิม)
	 */
	function rc_receive_fill_columns($conn)
	{
		static $fill = null;
		if ($fill === null) {
			$fill = array();
			foreach (rc_fetch_all($conn, "SHOW COLUMNS FROM hos__receive", '', array()) as $column) {
				if ($column['Null'] !== 'NO' || $column['Default'] !== null || stripos((string)$column['Extra'], 'auto_increment') !== false) {
					continue;
				}
				$type = strtolower((string)$column['Type']);
				if (preg_match('/^(date|datetime|timestamp|time|year)/', $type)) {
					continue;
				}
				$fill[$column['Field']] = preg_match('/^(tinyint|smallint|mediumint|int|bigint|decimal|float|double)/', $type) ? '0' : '';
			}
		}
		return $fill;
	}
}

if (!function_exists('rc_upload_extensions')) {
	function rc_upload_extensions()
	{
		return array('jpg', 'jpeg', 'png', 'gif', 'webp', 'pdf', 'doc', 'docx', 'xls', 'xlsx');
	}
}

if (!function_exists('rc_plan_uploads')) {
	/**
	 * ตรวจไฟล์แนบ img_re1..3 และ del_img[n] ก่อนเริ่ม transaction
	 * @return array<int,array{action:string,tmp?:string,ext?:string}>  slot 1..3 => keep | remove | new
	 */
	function rc_plan_uploads(array $files, array $post)
	{
		$plan = array();
		$delete = (isset($post['del_img']) && is_array($post['del_img'])) ? $post['del_img'] : array();
		for ($slot = 1; $slot <= 3; $slot++) {
			$file = $files['img_re' . $slot] ?? null;
			$plan[$slot] = array('action' => (isset($delete[$slot]) && (string)$delete[$slot] === '1') ? 'remove' : 'keep');
			if (!is_array($file) || (int)($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
				continue;
			}
			if ((int)$file['error'] !== UPLOAD_ERR_OK) {
				throw new RcValidationException('แนบไฟล์ที่ ' . $slot . ' ไม่สำเร็จ กรุณาลองใหม่');
			}
			if ((int)$file['size'] > RC_UPLOAD_MAX_BYTES) {
				throw new RcValidationException('กรุณาแนบไฟล์ที่มีขนาดน้อยกว่าหรือเท่ากับ 1 MB (ไฟล์ที่ ' . $slot . ')');
			}
			$ext = strtolower(pathinfo((string)$file['name'], PATHINFO_EXTENSION));
			if (!in_array($ext, rc_upload_extensions(), true)) {
				throw new RcValidationException('ไฟล์ที่ ' . $slot . ' ชนิดไม่รองรับ (รองรับ ' . implode(', ', rc_upload_extensions()) . ')');
			}
			$plan[$slot] = array('action' => 'new', 'tmp' => (string)$file['tmp_name'], 'ext' => $ext);
		}
		return $plan;
	}
}

if (!function_exists('rc_apply_uploads')) {
	/**
	 * ย้ายไฟล์ใหม่เข้า up_return/ ภายใน transaction (รู้เลขใบแล้ว)
	 * @param array $current  ชื่อไฟล์เดิม slot => name ('' = ไม่มี)
	 * @param array $moved    (ref) ไฟล์ที่ย้ายแล้ว ไว้ลบทิ้งเมื่อ rollback
	 * @param array $replaced (ref) ไฟล์เดิมที่ถูกแทน/ลบ ไว้ลบทิ้งหลัง commit
	 * @return array<int,string>  slot => ชื่อไฟล์ที่จะเก็บ
	 */
	function rc_apply_uploads(array $plan, array $current, $refId, array &$moved, array &$replaced)
	{
		$result = array();
		foreach ($plan as $slot => $step) {
			$name = (string)($current[$slot] ?? '');
			if ($step['action'] === 'remove' || $step['action'] === 'new') {
				if ($name !== '') {
					$replaced[] = $name;
				}
				$name = '';
			}
			if ($step['action'] === 'new') {
				$newName = 'img_re' . $slot . '_' . $refId . '_' . round(microtime(true)) . '.' . $step['ext'];
				if (!move_uploaded_file($step['tmp'], RC_UPLOAD_DIR . $newName)) {
					throw new RcValidationException('บันทึกไฟล์แนบที่ ' . $slot . ' ไม่สำเร็จ');
				}
				$moved[] = $newName;
				$name = $newName;
			}
			$result[$slot] = $name;
		}
		return $result;
	}
}

if (!function_exists('rc_delete_files')) {
	function rc_delete_files(array $names)
	{
		foreach ($names as $name) {
			$name = basename((string)$name);
			if ($name !== '' && is_file(RC_UPLOAD_DIR . $name)) {
				@unlink(RC_UPLOAD_DIR . $name);
			}
		}
	}
}

if (!function_exists('rc_insert_lines')) {
	function rc_insert_lines($conn, $refId, array $chosen)
	{
		foreach ($chosen as $row) {
			$line = $row['line'];
			// product_code เก็บ product_ID ซ้ำกับ product_id ตามตัวบันทึกเดิม
			po_stmt_exec(
				$conn,
				"INSERT INTO hos__subreceive (ref_idd, `count`, stock_remark, product_id, product_code, sn) VALUES (?, ?, ?, ?, ?, ?)",
				'sisiis',
				array($refId, $row['qty'], $row['remark'], (int)$line['product_id'], (int)$line['product_id'], $line['sn'])
			);
		}
	}
}

if (!function_exists('rc_sync_source')) {
	/**
	 * หลังเขียนใบคืน: ตั้ง/ถอน clear_ckk รายแถวของสินค้าที่ใบนี้แตะ, ปรับ return_product (BREQ), ปิด/เปิดหัวเอกสาร
	 * ใช้ยอดค้างที่คำนวณใหม่ (นับใบคืนทุกใบรวมใบนี้) — แตะเฉพาะสินค้าที่อยู่ในใบ เพื่อไม่ไปเปิดรายการที่ถูกปิดด้วยวิธีอื่น
	 * @param string[] $touchedProducts product_id ที่อยู่ในใบคืน (ทั้งก่อนและหลังแก้)
	 */
	function rc_sync_source($conn, array $source, array $touchedProducts)
	{
		$cfg = rc_source_config($source['type']);
		if ($cfg['clear_col'] === null) {
			return; // ใบสั่งเช่า / ใบแลกเปลี่ยน / SPR ไม่มีสถานะรายแถวให้เขียนกลับ
		}
		$state = rc_compute($conn, $source, '');
		$touched = array_flip(array_map('strval', $touchedProducts));
		$reopened = false;
		$allCleared = true;

		foreach ($state['rows'] as $itemId => $row) {
			$clear = $row['clear'];
			if (isset($touched[$row['product_id']])) {
				$newClear = ($row['out'] <= RC_EPSILON) ? 1 : 0;
				if ($newClear !== $clear) {
					po_stmt_exec($conn, "UPDATE `{$cfg['item']}` SET `{$cfg['clear_col']}` = ? WHERE `{$cfg['item_id']}` = ?", 'ii', array($newClear, $itemId));
					if ($clear === 1 && $newClear === 0) {
						$reopened = true;
					}
					$clear = $newClear;
				}
				if ($cfg['return_col'] !== null && abs($row['returned'] - $row['return_now']) > RC_EPSILON) {
					po_stmt_exec($conn, "UPDATE `{$cfg['item']}` SET `{$cfg['return_col']}` = ? WHERE `{$cfg['item_id']}` = ?", 'di', array($row['returned'], $itemId));
				}
			}
			if ($clear !== 1) {
				$allCleared = false;
			}
		}

		if ($cfg['close_col'] !== null) {
			$closed = ((string)$source['close'] === '1');
			if ($allCleared && count($state['rows']) > 0 && !$closed) {
				po_stmt_exec($conn, "UPDATE `{$cfg['head']}` SET `{$cfg['close_col']}` = 1 WHERE `{$cfg['key']}` = ?", 's', array($source['ref']));
			} elseif ($reopened && $closed) {
				po_stmt_exec($conn, "UPDATE `{$cfg['head']}` SET `{$cfg['close_col']}` = 0 WHERE `{$cfg['key']}` = ?", 's', array($source['ref']));
			}
		}
	}
}

if (!function_exists('rc_mark_demo_products')) {
	/** ตั้งสินค้าสาธิตให้สินค้ามี S/N ที่คืน — เฉพาะ BR / ฝากขาย / BREQ ตามที่ฟอร์มเดิมทำ */
	function rc_mark_demo_products($conn, array $source, array $productIds)
	{
		$cfg = rc_source_config($source['type']);
		if (!$cfg['demo'] || count($productIds) === 0) {
			return;
		}
		$ids = array_values(array_unique(array_map('intval', $productIds)));
		$placeholders = implode(',', array_fill(0, count($ids), '?'));
		po_stmt_exec($conn, "UPDATE tb_product SET demo_ckk = 1 WHERE have_sn = '1' AND product_ID IN ($placeholders)", str_repeat('i', count($ids)), $ids);
	}
}

if (!function_exists('rc_persist')) {
	/**
	 * บันทึกจาก register_receive.php
	 *   draft  = Save Draft  → send_stock = 0 (แก้ไข/ยกเลิกได้)
	 *   submit = Submit      → send_stock = 1 (ส่งให้ Stock และล็อก)
	 * ตรวจเท่ากันทั้งสองแบบ การตรวจและการเขียนอยู่ใน transaction เดียว ใต้ named lock ตัวเดียว (ออกเลข ref_id + กันคืนซ้อน)
	 *
	 * @param array $post   ต้องมี source_type + source_ref (ใบใหม่) หรือ receive_ref (แก้ฉบับร่าง)
	 * @return array{receive_ref:string,created:bool,send_stock:int}
	 */
	function rc_persist($conn, $mode, array $post, array $files, array $session)
	{
		if ($mode !== 'draft' && $mode !== 'submit') {
			throw new RcValidationException('ไม่รู้จักคำสั่งบันทึก');
		}
		if (!rc_has_source_columns($conn)) {
			throw new RcValidationException('ฐานข้อมูลยังไม่รองรับใบคืนแบบรวม กรุณาแจ้งผู้ดูแลระบบให้รัน sql/receive_source.sql');
		}
		po_relax_sql_mode($conn);

		$receiveRef = rc_post_value($post, 'receive_ref');
		$uploads = rc_plan_uploads($files, $post);
		$sendStock = ($mode === 'submit') ? RC_SEND_SUBMITTED : RC_SEND_DRAFT;

		if (!po_acquire_named_lock($conn, RC_LOCK_NAME, 10)) {
			throw new RcValidationException('ระบบกำลังบันทึกใบคืนของผู้ใช้อื่นอยู่ กรุณากดบันทึกอีกครั้ง');
		}
		$moved = array();
		$replaced = array();
		mysqli_begin_transaction($conn);
		try {
			$receipt = null;
			if ($receiveRef !== '') {
				$receipt = rc_load_receipt($conn, $receiveRef, true);
				if ($receipt === null) {
					throw new RcValidationException('ไม่พบใบคืนเลขที่ ' . $receiveRef);
				}
				if (!rc_is_unified($receipt)) {
					throw new RcValidationException('ใบคืนเลขที่ ' . $receiveRef . ' เป็นใบเก่า แก้ไขที่หน้านี้ไม่ได้');
				}
				if (rc_is_submitted($receipt)) {
					throw new RcValidationException('ใบคืนเลขที่ ' . $receiveRef . ' ส่งให้ Stock แล้ว จึงแก้ไขไม่ได้ กรุณาโหลดหน้าใหม่');
				}
				$sourceType = $receipt['source_type'];
				$sourceRef = $receipt['source_ref'];
			} else {
				$sourceType = rc_post_value($post, 'source_type');
				$sourceRef = rc_post_value($post, 'source_ref');
			}

			$source = rc_load_source($conn, $sourceType, $sourceRef);
			if ($source === null) {
				throw new RcValidationException('ไม่พบเอกสารต้นทาง');
			}
			if (!$source['approved']) {
				throw new RcValidationException('เอกสารต้นทางยังไม่อนุมัติ จึงคืนสินค้าไม่ได้');
			}
			if ($source['needs_doc_no']) {
				throw new RcValidationException('เอกสารต้นทางยังไม่มีเลขที่เอกสาร จึงคืนสินค้าไม่ได้');
			}

			$header = rc_header_from_post($post, $source);
			$state = rc_compute($conn, $source, $receiveRef);
			$chosen = rc_choose_lines($post, $state['lines'], $state['outstanding']);

			$touched = array();
			foreach ($chosen as $row) {
				$touched[] = $row['line']['product_id'];
			}

			if ($receipt === null) {
				$receiveRef = rc_next_ref_id($conn);
				$names = rc_apply_uploads($uploads, array(), $receiveRef, $moved, $replaced);
				$values = array_merge(rc_receive_fill_columns($conn), array(
					'ref_id'           => $receiveRef,
					'type_company'     => $header['type_company'],
					'date_receive'     => $header['date_receive'],
					'receive_ckk'      => $header['receive_ckk'],
					'receive_name'     => $header['receive_name'],
					'receive_between'  => '',
					'time_between'     => $header['time_between'],
					'time_range'       => $header['time_range'],
					'customer_name'    => $header['customer_name'],
					'customer_tel'     => $header['customer_tel'],
					'customer_address' => $header['customer_address'],
					'iv_no'            => $source['doc_no'],
					'remark_st'        => $header['remark_st'],
					'sale_code'        => $header['sale_code'],
					'sale_name'        => $header['sale_name'],
					'order_id'         => $header['order_id'],
					'add_by'           => rc_actor_name($session),
					'add_date'         => date('Y-m-d H:i:s'),
					'send_stock'       => (string)$sendStock,
					'allwell_ckk'      => ($source['type'] === 'smp') ? '1' : '0',
					'source_type'      => $source['type'],
					'source_ref'       => $source['ref'],
					'img_re1'          => $names[1],
					'img_re2'          => $names[2],
					'img_re3'          => $names[3],
				));
				$columns = array_keys($values);
				po_stmt_exec(
					$conn,
					"INSERT INTO hos__receive (`" . implode('`, `', $columns) . "`) VALUES (" . implode(', ', array_fill(0, count($columns), '?')) . ")",
					str_repeat('s', count($columns)),
					array_values($values)
				);
				$created = true;
			} else {
				$names = rc_apply_uploads($uploads, array(1 => $receipt['img_re1'], 2 => $receipt['img_re2'], 3 => $receipt['img_re3']), $receiveRef, $moved, $replaced);
				po_stmt_exec(
					$conn,
					"UPDATE hos__receive
					 SET type_company = ?, date_receive = ?, receive_ckk = ?, receive_name = ?, time_between = ?, time_range = ?, customer_address = ?,
						 remark_st = ?, sale_code = ?, order_id = ?, send_stock = ?, img_re1 = ?, img_re2 = ?, img_re3 = ?
					 WHERE id_auto = ?",
					'ssssssssssssssi',
					array(
						$header['type_company'], $header['date_receive'], $header['receive_ckk'], $header['receive_name'], $header['time_between'], $header['time_range'],
						$header['customer_address'], $header['remark_st'], $header['sale_code'], $header['order_id'], (string)$sendStock,
						$names[1], $names[2], $names[3], (int)$receipt['id_auto'],
					)
				);
				foreach (rc_load_receipt_lines($conn, $receiveRef) as $old) {
					$touched[] = (string)(int)$old['product_id'];
				}
				po_stmt_exec($conn, "DELETE FROM hos__subreceive WHERE ref_idd = ?", 's', array($receiveRef));
				$created = false;
			}

			rc_insert_lines($conn, $receiveRef, $chosen);
			$demoProducts = array();
			foreach ($chosen as $row) {
				$demoProducts[] = $row['line']['product_id'];
			}
			rc_mark_demo_products($conn, $source, $demoProducts);
			rc_sync_source($conn, $source, $touched);
			mysqli_commit($conn);
		} catch (Throwable $e) {
			mysqli_rollback($conn);
			rc_delete_files($moved);
			po_release_named_lock($conn, RC_LOCK_NAME);
			throw $e;
		}
		po_release_named_lock($conn, RC_LOCK_NAME);
		rc_delete_files($replaced);
		return array('receive_ref' => $receiveRef, 'created' => $created, 'send_stock' => $sendStock);
	}
}

if (!function_exists('rc_cancel')) {
	/**
	 * ยกเลิกฉบับร่าง: ลบแถวใบคืนและรายการออกจริง คืนยอดค้างกลับต้นทาง แล้วบันทึกผู้ยกเลิกและเวลาใน tb_document_status_log
	 * ใช้ได้เฉพาะใบใหม่ที่ยังเป็นฉบับร่าง
	 */
	function rc_cancel($conn, $receiveRef, array $session)
	{
		$receiveRef = trim((string)$receiveRef);
		if ($receiveRef === '') {
			throw new RcValidationException('ไม่พบเลขที่ใบคืน');
		}
		if (!po_acquire_named_lock($conn, RC_LOCK_NAME, 10)) {
			throw new RcValidationException('ระบบกำลังบันทึกใบคืนของผู้ใช้อื่นอยู่ กรุณากดยกเลิกอีกครั้ง');
		}
		$files = array();
		mysqli_begin_transaction($conn);
		try {
			$receipt = rc_load_receipt($conn, $receiveRef, true);
			if ($receipt === null) {
				throw new RcValidationException('ไม่พบใบคืนเลขที่ ' . $receiveRef . ' (อาจถูกยกเลิกไปแล้ว)');
			}
			if (!rc_is_unified($receipt)) {
				throw new RcValidationException('ใบคืนเลขที่ ' . $receiveRef . ' เป็นใบเก่า ยกเลิกที่หน้านี้ไม่ได้');
			}
			if (rc_is_submitted($receipt)) {
				throw new RcValidationException('ใบคืนเลขที่ ' . $receiveRef . ' ส่งให้ Stock แล้ว จึงยกเลิกไม่ได้');
			}
			$source = rc_load_source($conn, $receipt['source_type'], $receipt['source_ref']);
			$touched = array();
			foreach (rc_load_receipt_lines($conn, $receiveRef) as $line) {
				$touched[] = (string)(int)$line['product_id'];
			}
			po_stmt_exec($conn, "DELETE FROM hos__subreceive WHERE ref_idd = ?", 's', array($receiveRef));
			po_stmt_exec($conn, "DELETE FROM hos__receive WHERE id_auto = ?", 'i', array((int)$receipt['id_auto']));
			if ($source !== null) {
				rc_sync_source($conn, $source, $touched);
			}
			po_insert_status_log($conn, $receiveRef, 'Cancelled', 'ยกเลิกใบคืนสินค้าฉบับร่าง (' . $receipt['source_type'] . ' ' . $receipt['source_ref'] . ')', $session);
			mysqli_commit($conn);
			$files = array($receipt['img_re1'], $receipt['img_re2'], $receipt['img_re3']);
		} catch (Throwable $e) {
			mysqli_rollback($conn);
			po_release_named_lock($conn, RC_LOCK_NAME);
			throw $e;
		}
		po_release_named_lock($conn, RC_LOCK_NAME);
		rc_delete_files($files);
	}
}

if (!function_exists('rc_history')) {
	/**
	 * ประวัติการคืนของเอกสารต้นทางหนึ่งใบ ใหม่สุดก่อน — รวมใบเก่า (จับคู่ด้วย iv_no) และใบใหม่
	 * @return array<int,array>
	 */
	function rc_history($conn, array $source)
	{
		$match = "(r.source_type = ? AND r.source_ref = ?)";
		$types = 'ss';
		$params = array($source['type'], $source['ref']);
		if ($source['doc_no'] !== '') {
			$match .= " OR (r.source_type = '' AND r.iv_no = ?)";
			$types .= 's';
			$params[] = $source['doc_no'];
		}
		$rows = rc_fetch_all(
			$conn,
			"SELECT r.id_auto, r.ref_id, r.date_receive, r.add_by, r.add_date, r.send_stock, r.source_type,
				(SELECT COALESCE(SUM(s.`count`), 0) FROM hos__subreceive s WHERE s.ref_idd = r.ref_id) AS total_qty
			 FROM hos__receive r WHERE {$match} ORDER BY r.id_auto DESC",
			$types,
			$params
		);
		$history = array();
		foreach ($rows as $row) {
			$unified = rc_is_unified($row);
			$status = rc_status_info($row);
			$history[] = array(
				'ref_id'       => (string)$row['ref_id'],
				'date_receive' => (string)$row['date_receive'],
				'add_by'       => (string)$row['add_by'],
				'add_date'     => (string)$row['add_date'],
				'total_qty'    => rc_trim_number($row['total_qty']),
				'status_label' => $status['label'],
				'status_color' => $status['color'],
				'is_legacy'    => !$unified,
				'url'          => $unified
					? 'register_receive.php?receive_ref=' . rawurlencode((string)$row['ref_id'])
					: 'rister_clearbrpn_stedit.php?ref_id=' . rawurlencode((string)$row['ref_id']),
			);
		}
		return $history;
	}
}
