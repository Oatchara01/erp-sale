<?php

/**
 * Preview helper สำหรับ from_breg.php (แบบฟอร์มใบขอเบิกอะไหล่จากสินค้าขาย)
 *
 * ให้ใบพิมพ์ render จากค่าที่ POST มาจากฟอร์ม register_bregawl.php ได้ทันที
 * โดยไม่ต้องบันทึกลงฐานก่อน — โครงเดียวกับ report_changehosptl_preview_helper.php
 * และ report_salehos_preview_helper.php
 *
 * โหมด Preview ต้องไม่ INSERT/UPDATE/DELETE อะไรทั้งสิ้น
 */

function breg_report_is_preview_request()
{
	return ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST'
		&& isset($_POST['_report_preview'])
		&& $_POST['_report_preview'] === '1';
}

/**
 * ORDER BY ของรายการในใบพิมพ์ — ใช้ลำดับที่ผู้ใช้จัดไว้ (sort_order) เมื่อฐานได้รัน
 * sql/breg_dynamic_rows.sql แล้ว ไม่งั้นกลับไปเรียงตาม id เหมือนเดิม
 */
function breg_report_items_order($conn, $table, $idColumn)
{
	static $cache = array();
	$key = spl_object_id($conn) . '|' . $table;
	if (!array_key_exists($key, $cache)) {
		$safeTable = str_replace('`', '', $table);
		// mysqli โยน exception ตั้งแต่ PHP 8.1 — ถือว่า "ไม่มีคอลัมน์" แทนที่จะพังทั้งใบพิมพ์
		try {
			$query = @mysqli_query($conn, "SHOW COLUMNS FROM `" . $safeTable . "` LIKE 'sort_order'");
			$cache[$key] = ($query && mysqli_num_rows($query) > 0);
		} catch (Throwable $e) {
			$cache[$key] = false;
		}
	}

	return $cache[$key]
		? "sub.sort_order ASC, sub." . $idColumn . " ASC"
		: "sub." . $idColumn . " ASC";
}

function breg_report_preview_value($key, $default = '')
{
	if (!isset($_POST[$key]) || is_array($_POST[$key])) {
		return $default;
	}
	return trim((string)$_POST[$key]);
}

/**
 * รายละเอียดสินค้าที่ใบพิมพ์ต้องใช้ (ชื่อไทย + หน่วย) อ่านจาก tb_product เหมือน
 * โหมดปกติที่ JOIN มา — ฟอร์มส่ง product_name/unit_name มาด้วย ใช้เป็น fallback
 */
function breg_report_preview_product($conn, $productId)
{
	static $cache = array();
	$productId = (int)$productId;
	if ($productId <= 0) {
		return array();
	}
	if (isset($cache[$productId])) {
		return $cache[$productId];
	}

	$sql = "SELECT sol_name, unit_name, access_code FROM tb_product WHERE product_ID = '"
		. mysqli_real_escape_string($conn, (string)$productId) . "' LIMIT 1";
	$query = @mysqli_query($conn, $sql);
	$row = $query ? mysqli_fetch_assoc($query) : null;
	$cache[$productId] = $row ? $row : array();
	return $cache[$productId];
}

/**
 * รายการหนึ่งกลุ่มจาก POST (g1 = รายการอะไหล่ที่ต้องการเบิก, g2 = เบิกอะไหล่จากสินค้า)
 * คีย์ที่คืนตั้งชื่อให้ตรงกับคอลัมน์ที่ from_breg.php อ่านในโหมดปกติ
 * เพื่อให้ loop body ของใบพิมพ์ใช้ตัวเดียวกันได้ทั้งสองโหมด
 */
function breg_report_preview_items($conn, $prefix)
{
	$ids = isset($_POST[$prefix . '_product_id']) && is_array($_POST[$prefix . '_product_id'])
		? $_POST[$prefix . '_product_id']
		: array();

	$read = function ($field, $index) use ($prefix) {
		$key = $prefix . '_' . $field;
		if (!isset($_POST[$key]) || !is_array($_POST[$key]) || !isset($_POST[$key][$index])) {
			return '';
		}
		return trim((string)$_POST[$key][$index]);
	};

	$rows = array();
	foreach ($ids as $index => $rawId) {
		$productId = (int)trim((string)$rawId);
		if ($productId <= 0) {
			continue; // กติกาเดียวกับตอนบันทึกจริง (breg_collect_items_from_post)
		}

		$product = breg_report_preview_product($conn, $productId);
		$solName = ($product['sol_name'] ?? '') !== '' ? $product['sol_name'] : $read('product_name', $index);
		$unitName = ($product['unit_name'] ?? '') !== '' ? $product['unit_name'] : $read('unit_name', $index);

		$rows[] = array(
			'sol_name'   => $solName,
			'unit_name'  => $unitName,
			'count'      => $read('count', $index),
			'sn_number'  => $read('sn', $index),
			'remark_eng' => $read('remark', $index),
			'type_probd' => $read('type_probd', $index),
		);
	}

	return $rows;
}

/**
 * หัวเอกสารจาก POST — คีย์ตรงกับคอลัมน์ hos__breg ที่ from_breg.php อ่าน
 * ช่องที่ยังไม่มีค่าตอนพรีวิว (เลขที่เอกสาร/ผู้อนุมัติ/คลังสินค้า) คงเป็นค่าว่าง
 * ตามความจริงของเอกสารที่ยังไม่ผ่านขั้นตอนนั้น ไม่ใช่บั๊ก
 */
function breg_report_build_preview_context($conn)
{
	require_once __DIR__ . '/includes/breg_repo.php';
	$metadata = breg_header_from_post($_SESSION ?? array());
	$savedRefId = breg_report_preview_value('ref_id');
	$original = null;
	if ($savedRefId !== '') {
		$original = breg_load_document($conn, $savedRefId);
		if ($original === null) {
			throw new BregValidationException('ไม่พบเอกสารที่ต้องการแสดงตัวอย่าง');
		}
		foreach (array('register_date', 'add_by', 'add_date') as $field) {
			$metadata[$field] = $original[$field];
		}
	}
	// ใบใหม่ยังไม่มีเลขจริง — ใช้เลขคาดการณ์ที่หน้าฟอร์มแสดงอยู่เพื่อให้พรีวิวอ่านรู้เรื่อง
	$refId = breg_report_preview_value('ref_id');
	if ($refId === '') {
		$refId = breg_report_preview_value('ref_id_preview');
	}

	$proComeDate = breg_report_preview_value('pro_comedate');
	$dateBrdoc = breg_report_preview_value('date_brdoc');

	// เอกสารเดิม (ref_id มีค่า) เป็น baseline ของข้อมูล lifecycle ที่เซิร์ฟเวอร์ควบคุม
	// (เลขที่ใบส่งของ/ผู้อนุมัติ/วันที่อนุมัติ/คลังสินค้า ฯลฯ) — ฟอร์มสด overlay ได้แค่ฟิลด์ที่แก้ไขได้เอง
	// ใบใหม่ที่ยังไม่มี $original ใช้ค่าว่างเหมือนเดิม
	$lifecycleDefaults = array(
		'iv_no'        => '',
		'iv_date'      => '0000-00-00 00:00:00',
		'sup_name'     => '',
		'sup_date'     => '0000-00-00 00:00:00',
		'dm_name'      => '',
		'dm_date'      => '0000-00-00 00:00:00',
		'receive_pro'  => '',
		'receive_date' => '0000-00-00 00:00:00',
		'st_name'      => '',
		'st_date'      => '0000-00-00 00:00:00',
		'send_erpst'   => '0',
		'print_brdoc'  => '0',
		'type_brdoc'   => '0',
	);
	$lifecycle = $lifecycleDefaults;
	if ($original !== null) {
		foreach ($lifecycleDefaults as $field => $default) {
			$lifecycle[$field] = $original[$field] ?? $default;
		}
	}

	$header = array_merge($lifecycle, array(
		'ref_id'        => $refId,
		'type_doc'      => $metadata['type_doc'],
		'register_date' => $metadata['register_date'],
		'add_by'        => $metadata['add_by'],
		'add_date'      => $metadata['add_date'],
		'description'   => breg_report_preview_value('description'),
		'customer_name' => breg_report_preview_value('customer_name'),
		'per_no'        => breg_report_preview_value('per_no'),
		'cm_no'         => breg_report_preview_value('cm_no'),
		'pro_come'      => (breg_report_preview_value('pro_come') === '1') ? '1' : '0',
		'pro_comedate'  => $proComeDate !== '' ? $proComeDate : '0000-00-00',
		'brdoc_eng'     => (breg_report_preview_value('brdoc_eng') === '1') ? '1' : '0',
		'name_eng'      => breg_report_preview_value('name_eng'),
		'date_brdoc'    => $dateBrdoc !== '' ? ($dateBrdoc . ' 00:00:00') : '0000-00-00 00:00:00',
	));

	return array(
		'header' => $header,
		'items1' => breg_report_preview_items($conn, 'g1'),
		'items2' => breg_report_preview_items($conn, 'g2'),
	);
}
