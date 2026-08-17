<?php
// Handler แก้ไขเอกสาร "ใบยืมฝากขาย" (hos__consig) — คู่กับ register_supbrcshos1.php (INSERT)
// เขียนทับไฟล์เดิม (423 บรรทัด, w3.css, อัพเดตแค่ ~21 คอลัมน์) เพราะ register_supbrcshos_draft1.php
// hardcode ชื่อไฟล์นี้ไว้ใน include อยู่แล้ว — ดู plan "เพิ่ม view/edit mode ให้ register_supbrcshos.php"
//
// โครงสร้างมิเรอร์ register_supbrcshos1.php เป็นหลัก (ทันสมัยกว่า register_supbrhos_edit1.php ที่เป็น
// reference เดิม) ต่างจากไฟล์นั้น 3 จุดหลัก: (1) ref_id มาจาก POST ไม่ใช่ generate ใหม่ (2) hos__consig
// เป็น UPDATE ไม่แตะ sale/sale_code/sale_date/add_by/add_date เพื่อรักษาประวัติผู้สร้างเดิม
// (send_sup*/status_doc ถูกตั้งเฉพาะตอน Submit หรือยกเลิกเอกสาร — ดูบล็อกก่อน UPDATE hos__consig)
// (3) hos__subconsig / tb_register_data ต้อง DELETE ก่อน INSERT (ตารางลูกอื่นเป็น DELETE+INSERT อยู่แล้ว
// เหมือนกับ handler สร้างเอกสาร จึงก็อปมาแทบไม่ต้องแก้)
ob_start();
$isDraftRequest = isset($_POST["is_draft"]) && $_POST["is_draft"] === "1";
if (!$isDraftRequest) {
	include("head.php");
} else {
	header('Content-Type: application/json; charset=utf-8');
}
?>


<?php
include("dbconnect.php");
include ("error_page.php");

date_default_timezone_set("Asia/Bangkok");
if (isset($_POST["submit"]) && $_POST["submit"] === "submit") {

// ===== Helper อ่านค่า $_POST — เหมือน register_supbrcshos1.php ทุกประการ =====
// ไฟล์นี้ไม่เคย include คู่กับ register_supbrcshos1.php ในคำขอเดียวกัน (router เลือก include แค่ไฟล์เดียว)
// จึงประกาศซ้ำโดย guard function_exists() แทนการแยกไฟล์ helper กลาง (ลดความเสี่ยงของงานนี้)
if (!function_exists('cs_post_raw')) {
	function cs_post_raw($key, $default = '')
	{
		return trim((string)($_POST[$key] ?? $default));
	}
}
if (!function_exists('cs_post')) {
	function cs_post($conn, $key, $default = '')
	{
		return mysqli_real_escape_string($conn, cs_post_raw($key, $default));
	}
}
if (!function_exists('cs_post_date')) {
	function cs_post_date($conn, $key)
	{
		$value = cs_post_raw($key);
		return $value === '' ? '0000-00-00' : mysqli_real_escape_string($conn, $value);
	}
}
if (!function_exists('cs_post_amount')) {
	function cs_post_amount($conn, $key, $default = '0.00')
	{
		$value = str_replace(',', '', cs_post_raw($key));
		return $value === '' ? $default : mysqli_real_escape_string($conn, $value);
	}
}
if (!function_exists('cs_post_flag')) {
	function cs_post_flag($key)
	{
		return cs_post_raw($key) === '1' ? '1' : '0';
	}
}
if (!function_exists('cs_update_column_if_exists')) {
	function cs_update_column_if_exists($conn, $table, $refColumn, $refValue, $column, $value)
	{
		$safeTable = mysqli_real_escape_string($conn, $table);
		$safeColumn = mysqli_real_escape_string($conn, $column);
		$columnCheck = mysqli_query($conn, "SHOW COLUMNS FROM " . $safeTable . " LIKE '" . $safeColumn . "'");
		if (!$columnCheck || mysqli_num_rows($columnCheck) == 0) {
			return;
		}

		$safeRefColumn = mysqli_real_escape_string($conn, $refColumn);
		$safeValue = mysqli_real_escape_string($conn, $value);
		$safeRefValue = mysqli_real_escape_string($conn, $refValue);
		mysqli_query($conn, "UPDATE " . $safeTable . " SET " . $safeColumn . " = '" . $safeValue . "' WHERE " . $safeRefColumn . " = '" . $safeRefValue . "'");
	}
}
if (!function_exists('cs_column_exists')) {
	function cs_column_exists($conn, $table, $columnName)
	{
		static $columnCache = array();
		$cacheKey = $table . '.' . $columnName;
		if (array_key_exists($cacheKey, $columnCache)) {
			return $columnCache[$cacheKey];
		}

		$safeTable = mysqli_real_escape_string($conn, $table);
		$safeColumnName = mysqli_real_escape_string($conn, $columnName);
		$query = mysqli_query($conn, "SHOW COLUMNS FROM " . $safeTable . " LIKE '" . $safeColumnName . "'");
		$columnCache[$cacheKey] = ($query && mysqli_num_rows($query) > 0);
		return $columnCache[$cacheKey];
	}
}
if (!function_exists('cs_dept_comment_items_from_post')) {
	function cs_dept_comment_items_from_post()
	{
		$itemsJson = $_POST["dept_comment_items"] ?? "[]";
		$decodedItems = json_decode($itemsJson, true);
		if (!is_array($decodedItems)) {
			return array();
		}

		$items = array();
		$allowedDepartments = array(1, 2, 3, 4);
		foreach ($decodedItems as $index => $item) {
			$departmentId = isset($item["department_id"]) ? (int)$item["department_id"] : 0;
			$message = isset($item["message"]) ? trim($item["message"]) : "";
			if (!in_array($departmentId, $allowedDepartments, true) || $message === "") {
				continue;
			}

			$items[] = array(
				"department_id" => $departmentId,
				"message" => $message,
				"sort_order" => isset($item["sort_order"]) ? (int)$item["sort_order"] : ($index + 1)
			);
		}

		return $items;
	}
}
if (!function_exists('cs_save_dept_comment_items')) {
	function cs_save_dept_comment_items($conn, $commentSoId, $refId, $items)
	{
		$commentSoId = (int)$commentSoId;
		$refIdEscaped = mysqli_real_escape_string($conn, $refId);
		mysqli_query($conn, "DELETE FROM tb_comment_so_item WHERE comment_so_id = " . $commentSoId . " OR ref_id = '" . $refIdEscaped . "'");

		foreach ($items as $item) {
			$departmentId = (int)$item["department_id"];
			$message = mysqli_real_escape_string($conn, $item["message"]);
			$sortOrder = (int)$item["sort_order"];
			$sql = "INSERT INTO tb_comment_so_item (comment_so_id, ref_id, department_id, message, sort_order) VALUES (" . $commentSoId . ", '" . $refIdEscaped . "', " . $departmentId . ", '" . $message . "', " . $sortOrder . ")";
			mysqli_query($conn, $sql);
		}
	}
}

// ===== ref_id ของเอกสารที่จะแก้ไข — ต้องมีอยู่จริงแล้ว (เป็น UPDATE ไม่ generate ใหม่) =====
$ref_id = cs_post($conn, "ref_id");
if ($ref_id === '') {
	if (ob_get_level() > 0) {
		ob_end_clean();
	}
	if ($isDraftRequest) {
		echo json_encode(array('success' => false, 'message' => 'ไม่พบเลขที่อ้างอิงเอกสาร'));
	} else {
		echo "<script>alert('ไม่พบเลขที่อ้างอิงเอกสาร');history.back();</script>";
	}
	exit();
}

$existingDocQuery = mysqli_query($conn, "SELECT ref_id FROM hos__consig WHERE ref_id = '" . $ref_id . "' LIMIT 1");
if (!$existingDocQuery || mysqli_num_rows($existingDocQuery) === 0) {
	if (ob_get_level() > 0) {
		ob_end_clean();
	}
	if ($isDraftRequest) {
		echo json_encode(array('success' => false, 'message' => 'ไม่พบเอกสาร ' . $ref_id . ' ในระบบ'));
	} else {
		echo "<script>alert('ไม่พบเอกสาร $ref_id ในระบบ');history.back();</script>";
	}
	exit();
}

// Backend validation — ชุดเดียวกับ register_supbrcshos1.php (ข้ามเมื่อเป็น Draft)
if (!$isDraftRequest) {
	$csRequiredFieldLabels = array(
		'start_time' => 'กรุณาใส่เวลาส่ง',
		'customer_name' => 'กรุณาใส่ชื่อลูกค้า',
		'customer_tel' => 'กรุณาใส่เบอร์โทรลูกค้า',
		'address_name' => 'กรุณาใส่ที่อยู่ในการส่งสินค้า',
		'address_send' => 'กรุณาใส่สถานที่ติดตั้งเครื่อง',
		'province_name' => 'กรุณาเลือกจังหวัดที่ต้องการจัดส่ง',
	);

	$csValidationErrors = array();
	foreach ($csRequiredFieldLabels as $csRequiredField => $csRequiredMessage) {
		if (trim((string)($_POST[$csRequiredField] ?? '')) === '') {
			$csValidationErrors[] = $csRequiredMessage;
		}
	}

	$csHasProductPost = false;
	for ($csValidatePi = 1; $csValidatePi <= 10; $csValidatePi++) {
		if (trim((string)($_POST['product_id' . $csValidatePi] ?? '')) !== '') {
			$csHasProductPost = true;
			break;
		}
	}
	if (!$csHasProductPost) {
		$csValidationErrors[] = 'กรุณาเลือกสินค้าอย่างน้อย 1 รายการ';
	}

	if (!empty($csValidationErrors)) {
		if (ob_get_level() > 0) {
			ob_end_clean();
		}
		$csValidationText = implode("\\n", array_map(function ($msg) {
			return str_replace(array("\\", "'", "\r", "\n"), array("\\\\", "\\'", " ", " "), $msg);
		}, $csValidationErrors));
		echo "<script>alert('กรุณากรอกข้อมูลให้ครบถ้วน\\n\\n$csValidationText');history.back();</script>";
		exit();
	}
}

$company = cs_post($conn, "company");
$customer = cs_post($conn, "customer");
$customer_id = cs_post($conn, "customer_id");
$address = cs_post($conn, "address");
$sale_comment = cs_post($conn, "sale_comment");
$objective = cs_post($conn, "objective");
$objective_des = cs_post($conn, "objective_des");
// ปุ่ม "ยกเลิกเอกสาร" มีลำดับเหนือ Draft — เหมือน register_supbrcshos1.php:197-200
$isCancelDoc = (isset($_POST["cancel_doc"]) && (string)$_POST["cancel_doc"] === "1");
$status_doc = $isCancelDoc ? "ยกเลิก" : ($isDraftRequest ? "Draft" : "Request");
$delivery_name = cs_post($conn, "address_name");
$delivery_type = cs_post($conn, "delivery_type");
$delivery_date = cs_post_date($conn, "start_date");
$start_time = cs_post($conn, "start_time");
$end_time = cs_post($conn, "end_time");
$delivery_time = "$start_time $end_time";
$delivery_address = cs_post($conn, "address_send");
$delivery_contact = cs_post($conn, "customer_name");
$delivery_tel = cs_post($conn, "customer_tel");
$date_send_key = cs_post($conn, "between_date");
$iv_no = cs_post($conn, "admin_doc_no");
// กันเลขซ้ำชุดเดียวกับ register_supbrcshos1.php — เลขไม่ได้ถูกจองตอนกดปุ่ม "Run เอกสาร" แล้ว
// ต่างกันตรงที่ต้องยกเว้นเอกสารตัวเอง ไม่งั้นการกด Update ทุกครั้งจะฟ้องเลขซ้ำกับตัวเอง
if ($iv_no !== '') {
	$csDupQuery = mysqli_query($conn, "SELECT ref_id FROM hos__consig WHERE iv_no = '" . $iv_no . "' AND ref_id <> '" . $ref_id . "' LIMIT 1");
	$csDupRow = $csDupQuery ? mysqli_fetch_assoc($csDupQuery) : null;
	if ($csDupRow) {
		if (ob_get_level() > 0) {
			ob_end_clean();
		}
		$csDupMessage = 'เลขที่เอกสาร ' . cs_post_raw("admin_doc_no") . ' ถูกใช้กับเอกสาร ' . $csDupRow['ref_id']
			. ' แล้ว กรุณากดปุ่ม Run เอกสารใหม่อีกครั้ง';
		if ($isDraftRequest) {
			echo json_encode(array('success' => false, 'message' => $csDupMessage));
		} else {
			$csDupAlert = str_replace(array("\\", "'", "\r", "\n"), array("\\\\", "\\'", " ", " "), $csDupMessage);
			echo "<script>alert('$csDupAlert');history.back();</script>";
		}
		exit();
	}
}
$iv_date = cs_post_date($conn, "admin_doc_date");
$remark_cancel = cs_post($conn, "admin_cancel_reason");
$que_ckk = cs_post($conn, "que_ckk", "0");
$send_cs = cs_post_flag("send_cs");
$date_ker = cs_post_date($conn, "shipping_date");
$order_refer_code = cs_post($conn, "shipping_ref1");
$order_refer_code1 = cs_post($conn, "shipping_ref2");
$ker_bath = cs_post_amount($conn, "shipping_cost");
$returns = cs_post($conn, "returns", "0");
$returns_date = cs_post_date($conn, "returns_date");
$returns_time = cs_post($conn, "returns_time");
$return_date_bet = cs_post($conn, "return_date_bet");
$returns_name = cs_post($conn, "returns_name");
$returns_contact = cs_post($conn, "returns_contact");
$returns_address = cs_post($conn, "returns_address");

$add_date = date('Y-m-d H:i:s');
$name = $_SESSION['name'];
$surname = $_SESSION['surname'];
$add_by = "$name $surname";
$add_by_session = mysqli_real_escape_string($conn, $add_by);
$em_id = mysqli_real_escape_string($conn, (string)($_SESSION['emid'] ?? ''));

// ===== ไฟล์แนบ (slip1-5) — edit mode: ไม่มีไฟล์ใหม่ = คงชื่อเดิม (ค่าจาก hidden input ที่ฟอร์มเติมไว้) =====
// null = ไม่แตะคอลัมน์นี้เลยตอน UPDATE, ต่างจาก '' ที่หมายถึง "ลบไฟล์เดิมทิ้ง"
$slip1 = $slip2 = $slip3 = $slip4 = $slip5 = null;
for ($csSlipIndex = 1; $csSlipIndex <= 5; $csSlipIndex++) {
	$csSlipKey = 'slip' . $csSlipIndex;
	if (!empty($_FILES[$csSlipKey]['name']) && $_FILES[$csSlipKey]['size'] > 0) {
		if ($_FILES[$csSlipKey]['size'] > 1100000) {
			if (ob_get_level() > 0) {
				ob_end_clean();
			}
			echo "<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
			exit();
		}
		$csSlipTemp = explode(".", $_FILES[$csSlipKey]["name"]);
		$csSlipName = $csSlipKey . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($csSlipTemp);
		move_uploaded_file($_FILES[$csSlipKey]["tmp_name"], "brsc/" . $csSlipName);
		${$csSlipKey} = mysqli_real_escape_string($conn, $csSlipName);
	} elseif (isset($_POST[$csSlipKey])) {
		${$csSlipKey} = cs_post($conn, $csSlipKey);
	}
}

$saveOk = true;
$saveFailures = array();
mysqli_begin_transaction($conn);

try {

// ===== hos__consig (UPDATE) =====
// ไม่แตะ date_save/sale_date/sale/sale_code/add_date/add_by เพื่อรักษาประวัติผู้สร้างเดิมไว้
// — เหมือนแนวทาง register_supbrhos_edit1.php:236-238
// ส่วน status_doc/send_sup* ถูกปรับตามชนิดของคำขอ (Submit / Save Draft / ยกเลิกเอกสาร) ในบล็อกด้านล่าง
$csConsigUpdateColumns = array(
	'company' => $company,
	'customer' => $customer,
	'customer_id' => $customer_id,
	'address' => $address,
	'sale_comment' => $sale_comment,
	'objective' => $objective,
	'objective_des' => $objective_des,
	'status_doc' => $status_doc,
	'delivery_name' => $delivery_name,
	'delivery_type' => $delivery_type,
	'delivery_date' => $delivery_date,
	'delivery_time' => $delivery_time,
	'delivery_address' => $delivery_address,
	'delivery_contact' => $delivery_contact,
	'delivery_tel' => $delivery_tel,
	'date_send_key' => $date_send_key,
	'iv_no' => $iv_no,
	'iv_date' => $iv_date,
	'remark_cancel' => $remark_cancel,
	'que_ckk' => $que_ckk,
	'send_cs' => $send_cs,
	'date_ker' => $date_ker,
	'order_refer_code' => $order_refer_code,
	'order_refer_code1' => $order_refer_code1,
	'ker_bath' => $ker_bath,
	'returns' => $returns,
	'returns_date' => $returns_date,
	'returns_time' => $returns_time,
	'return_date_bet' => $return_date_bet,
	'returns_name' => $returns_name,
	'returns_contact' => $returns_contact,
	'returns_address' => $returns_address,
);

// สถานะการส่งให้หัวหน้า — ตั้งเฉพาะตอน Submit/ยกเลิกเอกสารเท่านั้น ถ้าเซ็ตทุกครั้งเอกสาร Draft
// จะถูกส่งให้หัวหน้าทันทีที่กด Save Draft และเอกสาร Returned จะเด้งกลับเป็น Request ทันทีที่กด Update
// mirror register_suphos_edit1.php:485-495
if ($isDraftRequest && !$isCancelDoc) {
	// Save Draft/Update ต้องไม่แตะสถานะเอกสารเลย ไม่งั้นเอกสารที่ส่งไปแล้ว (Request/Returned)
	// จะถูกดึงกลับเป็น Draft เพียงเพราะผู้ใช้กดปุ่ม Update
	unset($csConsigUpdateColumns['status_doc']);
} elseif ($isCancelDoc) {
	$csConsigUpdateColumns['send_sup'] = '1';
} else {
	$csConsigUpdateColumns['send_sup'] = '1';
	$csConsigUpdateColumns['send_supname'] = $add_by_session;
	$csConsigUpdateColumns['send_supdate'] = $add_date;
	$csConsigUpdateColumns['send_admin'] = '0';
}

foreach (array('slip1' => $slip1, 'slip2' => $slip2, 'slip3' => $slip3, 'slip4' => $slip4, 'slip5' => $slip5) as $csSlipCol => $csSlipVal) {
	if ($csSlipVal !== null) {
		$csConsigUpdateColumns[$csSlipCol] = $csSlipVal;
	}
}

$csConsigUpdateParts = array();
foreach ($csConsigUpdateColumns as $csCol => $csVal) {
	$csConsigUpdateParts[] = "`" . $csCol . "` = '" . $csVal . "'";
}

$save = "update hos__consig set " . implode(", ", $csConsigUpdateParts) . " where ref_id = '" . $ref_id . "'";
$qsave = mysqli_query($conn, $save);
if (!$qsave) {
	$saveOk = false;
	$saveFailures[] = 'hos__consig: ' . mysqli_error($conn);
}

cs_update_column_if_exists($conn, 'hos__consig', 'ref_id', $ref_id, 'job_no1', cs_post_raw('admin_work_no'));
cs_update_column_if_exists($conn, 'hos__consig', 'ref_id', $ref_id, 'cm_no', cs_post_raw('cm_no'));


// ===== รายการสินค้า (hos__subconsig) — DELETE ทั้งหมดแล้ว re-INSERT จากฟอร์ม =====
$productNames = array();
$productUnits = array();
$productCounts = array();
$productRemarks = array();

mysqli_query($conn, "DELETE FROM hos__subconsig WHERE ref_idd = '" . $ref_id . "'");

for ($i = 1; $i <= 10; $i++) {
	$product_id = cs_post($conn, "product_id" . $i);
	$sale_count = cs_post($conn, "sale_count" . $i);
	$product_price = cs_post($conn, "product_price" . $i);
	$discount_unit = cs_post($conn, "discount_unit" . $i);
	$sum_amount = cs_post_amount($conn, "sum_amount" . $i, '');
	$warranty = cs_post($conn, "warranty" . $i);
	$cal = cs_post($conn, "cal" . $i);
	$pm = cs_post($conn, "pm" . $i);
	$pm_year = cs_post($conn, "pm_year" . $i);
	$sn = cs_post($conn, "sn" . $i);
	$sale_remarkk = cs_post($conn, "sale_remarkk" . $i);
	$admin_remark = cs_post($conn, "print_name" . $i);

	$productNames[$i] = cs_post_raw("product_name" . $i);
	$productUnits[$i] = cs_post_raw("unit_name" . $i);
	$productCounts[$i] = cs_post_raw("sale_count" . $i);
	$productRemarks[$i] = cs_post_raw("sale_remarkk" . $i);

	if ($product_id === '') {
		continue;
	}

	$strSQLItem = "insert into hos__subconsig
(ref_idd,product_id,product_code,count,price,discount,amount,warranty,cal,pm,pm_year,sn,sale_remark,admin_remark,add_by,add_date)
values ('" . $ref_id . "','" . $product_id . "','" . $product_id . "','" . $sale_count . "','" . $product_price . "','" . $discount_unit . "','" . $sum_amount . "','" . $warranty . "','" . $cal . "','" . $pm . "','" . $pm_year . "','" . $sn . "','" . $sale_remarkk . "','" . $admin_remark . "','" . $add_by_session . "','" . $add_date . "')";

	mysqli_query($conn, $strSQLItem);
}


// ===== ข้อความแจ้งแผนก (tb_comment_so + tb_comment_so_item) =====
$comment_cs = cs_post($conn, "comment_cs");
$comment_en = cs_post($conn, "comment_en");
$comment_st = cs_post($conn, "comment_st");
$comment_ad = cs_post($conn, "comment_ad");
$technician_required = cs_post_flag("technician_required");

mysqli_query($conn, "DELETE FROM tb_comment_so WHERE ref_id = '" . mysqli_real_escape_string($conn, $ref_id) . "'");
$saveComment = "insert into tb_comment_so (ref_id,comment_cs,comment_en,comment_st,comment_ad,technician_required) values ('" . $ref_id . "','" . $comment_cs . "','" . $comment_en . "','" . $comment_st . "','" . $comment_ad . "','" . $technician_required . "')";
if (mysqli_query($conn, $saveComment)) {
	cs_save_dept_comment_items($conn, mysqli_insert_id($conn), $ref_id, cs_dept_comment_items_from_post());
}


// ===== ส่งสินค้าด้วยใบรับสินค้า (tb_other_bill.ref_12) =====
$ref_12 = cs_post_flag("ref_12");
mysqli_query($conn, "DELETE FROM tb_other_bill WHERE ref_id = '" . mysqli_real_escape_string($conn, $ref_id) . "'");
mysqli_query($conn, "insert into tb_other_bill (ref_id,ref_12) values ('" . $ref_id . "','" . $ref_12 . "')");


// ===== รายละเอียดที่อยู่ (tb_transaction) =====
$cs_park_front = cs_post($conn, "park_front");
$cs_car_home = ($cs_park_front === '1') ? '1' : '0';
$cs_car_road = ($cs_park_front === '0') ? '1' : '0';
$cs_car_park = cs_post($conn, "park_location");
$cs_height_ltd = cs_post_flag("is_high_roof");

$cs_entrance_type = cs_post($conn, "entrance_type");
$cs_slope = ($cs_entrance_type === '1') ? '1' : '0';
$cs_bundai = ($cs_entrance_type === '2') ? '1' : '0';
$cs_unit_bundai = cs_post($conn, "stair_count");
$cs_install = cs_post($conn, "install_floor");

$cs_room_type = cs_post($conn, "room_type");
$cs_room_bigger = cs_post($conn, "door_width");
$cs_room_longer = cs_post($conn, "door_height");

$cs_stair_width = cs_post_raw("stair_width");
$cs_stair_height = cs_post_raw("stair_height");
$cs_bundai_big = ($cs_stair_width !== '' || $cs_stair_height !== '') ? mysqli_real_escape_string($conn, $cs_stair_width . ' x ' . $cs_stair_height) : '';

$cs_elev_door_width = cs_post_raw("elev_door_width");
$cs_elev_door_height = cs_post_raw("elev_door_height");
$cs_lip_big = ($cs_elev_door_width !== '' || $cs_elev_door_height !== '') ? mysqli_real_escape_string($conn, $cs_elev_door_width . ' x ' . $cs_elev_door_height) : '';

$cs_elev_width = cs_post_raw("elev_width");
$cs_elev_height = cs_post_raw("elev_height");
$cs_elev_depth = cs_post_raw("elev_depth");
$cs_lip_long = ($cs_elev_width !== '' || $cs_elev_height !== '' || $cs_elev_depth !== '') ? mysqli_real_escape_string($conn, $cs_elev_width . ' x ' . $cs_elev_height . ' x ' . $cs_elev_depth) : '';

$cs_lip_weight = cs_post($conn, "elev_capacity");

$cs_want_employee = cs_post_flag("move_furn");
$cs_employee_unit = cs_post($conn, "move_furn_count");
$cs_ferniger_name = cs_post($conn, "move_furn_detail");
$cs_addr_note = cs_post($conn, "addr_note");

mysqli_query($conn, "DELETE FROM tb_transaction WHERE ref_id = '" . mysqli_real_escape_string($conn, $ref_id) . "'");
$strSQLTransaction = "insert into tb_transaction (ref_id,car_park,car_road,car_home,slope,bundai,unit_bundai,home_type,install,bundai_big,lip_big,lip_long,lip_weight,want_employee,employee_unit,ferniger_name,room_bigger,room_longer,description,height_ltd,add_date,add_by)
values('" . $ref_id . "','" . $cs_car_park . "','" . $cs_car_road . "','" . $cs_car_home . "','" . $cs_slope . "','" . $cs_bundai . "','" . $cs_unit_bundai . "','" . $cs_room_type . "','" . $cs_install . "','" . $cs_bundai_big . "','" . $cs_lip_big . "','" . $cs_lip_long . "','" . $cs_lip_weight . "','" . $cs_want_employee . "','" . $cs_employee_unit . "','" . $cs_ferniger_name . "','" . $cs_room_bigger . "','" . $cs_room_longer . "','" . $cs_addr_note . "','" . $cs_height_ltd . "','" . $add_date . "','" . $add_by_session . "')";
mysqli_query($conn, $strSQLTransaction);

cs_update_column_if_exists($conn, 'tb_transaction', 'ref_id', $ref_id, 'install_room', cs_post_raw('room_type'));


// ===== ที่อยู่เพิ่มเติม (tb_shipping_address) — สูงสุด 9 แถว =====
mysqli_query($conn, "DELETE FROM tb_shipping_address WHERE ref_id = '" . mysqli_real_escape_string($conn, $ref_id) . "'");

for ($csShippingIndex = 1; $csShippingIndex <= 9; $csShippingIndex++) {
	$csShippingContactName = cs_post_raw('extra_contact_name_' . $csShippingIndex);
	$csShippingTelephone = cs_post_raw('extra_contact_tel_' . $csShippingIndex);
	$csShippingProvince = cs_post_raw('extra_contact_province_' . $csShippingIndex);
	$csShippingAddress = cs_post_raw('extra_shipping_address_' . $csShippingIndex);

	if ($csShippingContactName === '' && $csShippingTelephone === '' && $csShippingProvince === '' && $csShippingAddress === '') {
		continue;
	}

	$strCsShippingInsert = "INSERT INTO tb_shipping_address (ref_id, contact_name, telephone, province, address) VALUES ('" .
		mysqli_real_escape_string($conn, $ref_id) . "','" .
		mysqli_real_escape_string($conn, $csShippingContactName) . "','" .
		mysqli_real_escape_string($conn, $csShippingTelephone) . "','" .
		mysqli_real_escape_string($conn, $csShippingProvince) . "','" .
		mysqli_real_escape_string($conn, $csShippingAddress) . "')";

	mysqli_query($conn, $strCsShippingInsert);
}


// ===== คัดลอกที่อยู่เพิ่มเติมเข้า tb_delivery_print เพื่อให้ปุ่ม "พิมพ์ใบปะ" มีข้อมูลพิมพ์ =====
mysqli_query($conn, "DELETE FROM tb_delivery_print WHERE ref_id = '" . mysqli_real_escape_string($conn, $ref_id) . "'");

$csDeliveryPrintHasData = false;
for ($csPrintIndex = 1; $csPrintIndex <= 9; $csPrintIndex++) {
	if (cs_post_raw('extra_contact_name_' . $csPrintIndex) !== ''
		|| cs_post_raw('extra_contact_tel_' . $csPrintIndex) !== ''
		|| cs_post_raw('extra_contact_province_' . $csPrintIndex) !== ''
		|| cs_post_raw('extra_shipping_address_' . $csPrintIndex) !== '') {
		$csDeliveryPrintHasData = true;
	}
}

if ($csDeliveryPrintHasData) {
	$csDeliveryPrintColumns = array('ref_id');
	$csDeliveryPrintValues = array("'" . mysqli_real_escape_string($conn, $ref_id) . "'");

	for ($csPrintIndex = 1; $csPrintIndex <= 9; $csPrintIndex++) {
		$csDeliveryPrintColumns[] = 'customer_name' . $csPrintIndex;
		$csDeliveryPrintValues[] = "'" . cs_post($conn, 'extra_contact_name_' . $csPrintIndex) . "'";
		$csDeliveryPrintColumns[] = 'customer_tel' . $csPrintIndex;
		$csDeliveryPrintValues[] = "'" . cs_post($conn, 'extra_contact_tel_' . $csPrintIndex) . "'";
		if (cs_column_exists($conn, 'tb_delivery_print', 'province_name' . $csPrintIndex)) {
			$csDeliveryPrintColumns[] = 'province_name' . $csPrintIndex;
			$csDeliveryPrintValues[] = "'" . cs_post($conn, 'extra_contact_province_' . $csPrintIndex) . "'";
		}
		$csDeliveryPrintColumns[] = 'address_name' . $csPrintIndex;
		$csDeliveryPrintValues[] = "'" . cs_post($conn, 'extra_shipping_address_' . $csPrintIndex) . "'";
	}

	mysqli_query($conn, "insert into tb_delivery_print (" . implode(',', $csDeliveryPrintColumns) . ") values(" . implode(',', $csDeliveryPrintValues) . ")");
}


// ===== ที่อยู่ส่งบิล (tb_delivery_bill) =====
$csDeliveryBillContactName = cs_post_raw('bill_extra_contact_name_2');
$csDeliveryBillTelephone = cs_post_raw('bill_extra_contact_tel_2');
$csDeliveryBillProvince = cs_post_raw('bill_extra_contact_province_2');
$csDeliveryBillAddress = cs_post_raw('bill_extra_shipping_address_2');

mysqli_query($conn, "DELETE FROM tb_delivery_bill WHERE ref_id = '" . mysqli_real_escape_string($conn, $ref_id) . "'");

if ($csDeliveryBillContactName !== '' || $csDeliveryBillTelephone !== '' || $csDeliveryBillProvince !== '' || $csDeliveryBillAddress !== '') {
	$strCsDeliveryBillInsert = "INSERT INTO tb_delivery_bill (ref_id, customer_nameb, customer_telb, province, address_nameb) VALUES ('" .
		mysqli_real_escape_string($conn, $ref_id) . "','" .
		mysqli_real_escape_string($conn, $csDeliveryBillContactName) . "','" .
		mysqli_real_escape_string($conn, $csDeliveryBillTelephone) . "','" .
		mysqli_real_escape_string($conn, $csDeliveryBillProvince) . "','" .
		mysqli_real_escape_string($conn, $csDeliveryBillAddress) . "')";

	mysqli_query($conn, $strCsDeliveryBillInsert);
}


$start_date = cs_post_date($conn, "start_date");
$between_date = cs_post($conn, "between_date");
$status = cs_post($conn, "status");

$fix_date = cs_post_raw('fix_datetime') !== '' ? cs_post($conn, 'fix_datetime') : '0';
$no_price = cs_post_raw('no_money') !== '' ? cs_post($conn, 'no_money') : '0';
$call_customer = cs_post_raw('call_customer') !== '' ? cs_post($conn, 'call_customer') : '0';
$credit = cs_post_raw('credit_card') !== '' ? cs_post($conn, 'credit_card') : '0';
$call_employee = cs_post_raw('call_back') !== '' ? cs_post($conn, 'call_back') : '0';
$chash = cs_post_raw('cash') !== '' ? cs_post($conn, 'cash') : '0';
$check_peper = cs_post_raw('check_paper') !== '' ? cs_post($conn, 'check_paper') : '0';
$bill = cs_post_raw('bill') !== '' ? cs_post($conn, 'bill') : '0';
$want_bus = cs_post_raw('want_bus') !== '' ? cs_post($conn, 'want_bus') : '0';
$tran = cs_post_raw('tran') !== '' ? cs_post($conn, 'tran') : '0';
$check_detail = cs_post_raw('more') !== '' ? cs_post($conn, 'more') : '0';
$dep = cs_post_raw('dep') !== '' ? cs_post($conn, 'dep') : '0';

$department = cs_post($conn, "department_name");
$type_customer = cs_post($conn, "customer_typename");

if ($company == '1') {
	$type_company = 'ออลล์เวล ไลฟ์ บจก.';
} else if ($company == '2') {
	$type_company = 'โนเบิล เมด บจก.';
} else {
	$type_company = '';
}

$customer_name = cs_post($conn, "customer_name");
$customer_tel = cs_post($conn, "customer_tel");
$address_name = cs_post($conn, "address_name");
$address_send = cs_post($conn, "address_send");
$customer_contact = cs_post($conn, "customer_contact");

$on_time = cs_post($conn, "on_time");
$amphur_name = cs_post($conn, "amphur_name");
$province_name = cs_post($conn, "province_name");
$transport_company = cs_post($conn, "transport_company");
$location_link = cs_post($conn, "location_link");


// ===== เพิ่มที่อยู่ลงฐานข้อมูลลูกค้า (tb_customer_shipping_address) เมื่อกดปุ่ม "เพิ่มลงฐานลูกค้า" =====
$save_to_customer_db = isset($_POST['save_to_customer_db']) && $_POST['save_to_customer_db'] === '1';
if ($save_to_customer_db && !empty($customer_id)) {
	$esc_customer_id = $customer_id;
	$esc_shipping_name = $customer_name;
	$esc_shipping_tel = $customer_tel;
	$esc_shipping_province = $province_name;
	$esc_install_location = $address_send;
	$esc_location_link = $location_link;

	$rawAddress = cs_post_raw('shipping_address_raw');
	$hasRawAddress = ($rawAddress !== '');
	$esc_shipping_address = $hasRawAddress ? mysqli_real_escape_string($conn, $rawAddress) : $address_name;
	$esc_shipping_ampher = $hasRawAddress ? cs_post($conn, 'shipping_ampher') : '';
	$esc_shipping_postcode = $hasRawAddress ? cs_post($conn, 'shipping_postcode') : '';
	$now = date('Y-m-d H:i:s');

	$col_check = mysqli_query($conn, "SHOW COLUMNS FROM tb_customer_shipping_address");
	$existing_cols = array();
	if ($col_check) {
		while ($col_row = mysqli_fetch_assoc($col_check)) {
			$existing_cols[] = strtolower($col_row['Field']);
		}
	}

	$sql_dup_check = "SELECT id FROM tb_customer_shipping_address
		WHERE customer_id = '$esc_customer_id'
			AND shipping_name = '$esc_shipping_name'
			AND shipping_address = '$esc_shipping_address'
			AND shipping_tel = '$esc_shipping_tel'
		LIMIT 1";
	$dup_result = mysqli_query($conn, $sql_dup_check);
	$dup_row = $dup_result ? mysqli_fetch_assoc($dup_result) : null;

	if ($dup_row) {
		$_POST["shipping_id"] = $dup_row['id'];
	} else {
		$next_index = 1;
		$idx_result = mysqli_query($conn, "SELECT COALESCE(MAX(shipping_index), 0) + 1 AS next_index
			FROM tb_customer_shipping_address WHERE customer_id = '$esc_customer_id'");
		if ($idx_result && ($idx_row = mysqli_fetch_assoc($idx_result))) {
			$next_index = (int)$idx_row['next_index'];
		}

		$insert_fields = array(
			'customer_id' => "'$esc_customer_id'",
			'shipping_index' => "'$next_index'",
			'shipping_preface_name' => "''",
			'shipping_name' => "'$esc_shipping_name'",
			'shipping_address' => "'$esc_shipping_address'",
			'shipping_ampher' => "'$esc_shipping_ampher'",
			'shipping_province' => "'$esc_shipping_province'",
			'shipping_postcode' => "'$esc_shipping_postcode'",
			'shipping_tel' => "'$esc_shipping_tel'",
			'created_at' => "'$now'",
			'updated_at' => "'$now'"
		);

		if (in_array('install_location', $existing_cols)) {
			$insert_fields['install_location'] = "'$esc_install_location'";
		}
		if (in_array('location_link', $existing_cols)) {
			$insert_fields['location_link'] = "'$esc_location_link'";
		}

		$insert_cols_str = implode(', ', array_keys($insert_fields));
		$insert_vals_str = implode(', ', array_values($insert_fields));

		if (mysqli_query($conn, "INSERT INTO tb_customer_shipping_address ($insert_cols_str) VALUES ($insert_vals_str)")) {
			$_POST["shipping_id"] = mysqli_insert_id($conn);
		}
	}
}
$shipping_id = cs_post_raw("shipping_id") !== '' ? cs_post($conn, "shipping_id") : '0';

// สตริงสรุปรายการสินค้า
$productSummaryParts = array('ส่ง');
for ($i = 1; $i <= 10; $i++) {
	$productSummaryParts[] = $productNames[$i] . ' ' . $productRemarks[$i] . ' ' . $productCounts[$i] . ' ' . $productUnits[$i];
}
$productSummaryParts[] = cs_post_raw("address_name");
$product_name = mysqli_real_escape_string($conn, trim(preg_replace('/\s+/u', ' ', implode(' ', $productSummaryParts))));

$product_sn = cs_post($conn, "product_sn");
$unit_credit = cs_post($conn, "unit_credit");
$price = cs_post($conn, "unit_cash");
$employee_name = cs_post($conn, "employee_name");
$employee_tel = cs_post($conn, "employee_tel");
$add_by_register = cs_post($conn, "add_by");
$description = cs_post($conn, "sale_comment");
$havemap = cs_post($conn, 'have_map');
$unit_check = cs_post($conn, "unit_check");
$unit_bill = cs_post($conn, "unit_bill");
$unit_tran = cs_post($conn, "unit_tran");
$department_show = cs_post($conn, "department_show");
$dept = cs_post($conn, "dept");
$status_comment = cs_post($conn, "status_comment");
$address_1 = cs_post_raw("address_1") !== '' ? cs_post($conn, "address_1") : $address_name;

// ===== tb_register_data — ต่างจาก create handler: ต้อง DELETE ก่อนเพราะเป็นแถวเดิมที่มีอยู่แล้ว =====
mysqli_query($conn, "DELETE FROM tb_register_data WHERE ref_id = '" . mysqli_real_escape_string($conn, $ref_id) . "'");

$registerDataColumns = "ref_id,start_date,between_date,start_time,end_time,status,fix_date,no_price,call_customer,credit,call_employee,cash,check_peper,bill,department,type_customer,type_company,customer_name,customer_tel,address_name,address_send,want_bus,product_name,product_sn,unit_credit,price,employee_name,employee_tel,add_by,description,have_map,add_date,unit_bill,unit_check,unit_tran,tran,check_detail,dep,dept,department_show,customer_contact,status_comment,on_time,address_1,add_code,province_name,transport_company,location_link";
$registerDataValues = "'" . $ref_id . "','" . $start_date . "','" . $between_date . "','" . $start_time . "','" . $end_time . "','" . $status . "','" . $fix_date . "','" . $no_price . "','" . $call_customer . "','" . $credit . "','" . $call_employee . "','" . $chash . "','" . $check_peper . "','" . $bill . "','" . $department . "','" . $type_customer . "','" . $type_company . "','" . $customer_name . "','" . $customer_tel . "','" . $address_name . "','" . $address_send . "','" . $want_bus . "','" . $product_name . "','" . $product_sn . "','" . $unit_credit . "','" . $price . "','" . $employee_name . "','" . $employee_tel . "','" . $add_by_register . "','" . $description . "','" . $havemap . "','" . $add_date . "','" . $unit_bill . "','" . $unit_check . "','" . $unit_tran . "','" . $tran . "','" . $check_detail . "','" . $dep . "','" . $dept . "','" . $department_show . "','" . $customer_contact . "','" . $status_comment . "','" . $on_time . "','" . $address_1 . "','" . $em_id . "','" . $province_name . "','" . $transport_company . "','" . $location_link . "'";

if (cs_column_exists($conn, 'tb_register_data', 'shipping_id')) {
	$registerDataColumns .= ",shipping_id";
	$registerDataValues .= ",'" . $shipping_id . "'";
}

$strSQL66 = "insert into tb_register_data ($registerDataColumns) values($registerDataValues)";

$objQuery66 = mysqli_query($conn, $strSQL66);
if (!$objQuery66) {
	$saveOk = false;
	$saveFailures[] = 'tb_register_data: ' . mysqli_error($conn);
}

} catch (mysqli_sql_exception $e) {
	$saveOk = false;
	$saveFailures[] = $e->getMessage();
}


if ($saveOk) {
	mysqli_commit($conn);

	// ===== ปุ่มอนุมัติ/ส่งกลับ/ไม่อนุมัติ บนแถบล่างของ register_supbrcshos.php =====
	// ทำงานหลังบันทึกฟอร์มปกติเสร็จแล้ว (การบันทึกด้านบนเพิ่งตั้ง status_doc='Request' ไป
	// บล็อกนี้จึงเขียนทับเป็นสถานะสุดท้าย) — โครงเดียวกับ register_suphos_edit1.php:4029-4111
	// ตรรกะ 2 ชั้นเดิมของ BRCS พอร์ตจาก approve_brcshos.php:21-30, approve_brcshos_cm.php:15,
	// rejected_brcshos.php:15 และ rejected_brcshos_cm.php:15
	$csApproveAction = $_POST['approve_action'] ?? '';
	if ($csApproveAction !== '') {
		$csApproveName = mysqli_real_escape_string($conn, trim(($_SESSION['name'] ?? '') . ' ' . ($_SESSION['surname'] ?? '')));
		$csApproveCode = (string)($_SESSION['code'] ?? ''); // ส่งดิบ — cs_update_column_if_exists escape ให้เอง
		$csApproveDate = date('Y-m-d');
		$csApproveTime = date('H:i:s');
		$csApproveStamp = date('Y-m-d H:i:s');
		$csSafeRefId = mysqli_real_escape_string($conn, $ref_id);
		// ผู้อนุมัติชั้น CM ยึดชื่อผู้ใช้ตามหน้าเดิม register_brcshos_approve.php:138
		$csIsCmApprover = in_array(($_SESSION['name'] ?? ''), array('ชลชินี', 'สมบัติ'), true);
		$csIsExaminer = (($_SESSION['code'] ?? '') === 'SS5');

		if ($csApproveAction === 'return') {
			// ส่งกลับให้ Sale แก้ไข — send_sup='0' ทำให้ปุ่ม Submit บนฟอร์มกลับมาใช้ได้อีกครั้ง
			mysqli_query($conn, "UPDATE hos__consig SET status_doc='Returned', send_sup='0' WHERE ref_id='" . $csSafeRefId . "'");
		} elseif ($csApproveAction === 'reject') {
			if ($csIsCmApprover) {
				mysqli_query($conn, "UPDATE hos__consig SET status_doc='Rejected', cm_name='" . $csApproveName . "', cm_date='" . $csApproveStamp . "' WHERE ref_id='" . $csSafeRefId . "'");
			} else {
				mysqli_query($conn, "UPDATE hos__consig SET status_doc='Rejected', approve='" . $csApproveName . "', approve_date='" . $csApproveDate . "', approve_time='" . $csApproveTime . "' WHERE ref_id='" . $csSafeRefId . "'");
			}
		} elseif ($csApproveAction === 'approve') {
			if ($csIsCmApprover) {
				// ชั้นสุดท้าย: CM อนุมัติ เอกสารจบ
				mysqli_query($conn, "UPDATE hos__consig SET send_admin='1', status_doc='Approve', cm_name='" . $csApproveName . "', cm_date='" . $csApproveStamp . "' WHERE ref_id='" . $csSafeRefId . "'");
			} elseif ($csIsExaminer) {
				// ชั้นผู้ตรวจ (SS5): แค่ยืนยันว่าตรวจแล้ว ส่งต่อให้หัวหน้า
				mysqli_query($conn, "UPDATE hos__consig SET send_sup='1', status_doc='Request', examine_name='" . $csApproveName . "', examine_date='" . $csApproveDate . "' WHERE ref_id='" . $csSafeRefId . "'");
			} else {
				// ชั้นหัวหน้า: อนุมัติแล้วส่งต่อให้ CM
				mysqli_query($conn, "UPDATE hos__consig SET send_cm='1', status_doc='Request', approve='" . $csApproveName . "', approve_date='" . $csApproveDate . "', approve_time='" . $csApproveTime . "' WHERE ref_id='" . $csSafeRefId . "'");
			}
			cs_update_column_if_exists($conn, 'hos__consig', 'ref_id', $ref_id, 'approve_code', $csApproveCode);
		}
	}

	if ($isDraftRequest) {
		if (ob_get_level() > 0) {
			ob_end_clean();
		}
		echo json_encode(array(
			'success' => true,
			'ref_id' => $ref_id,
			'message' => 'บันทึกร่างเรียบร้อยแล้ว'
		));
		exit();
	}

	// true PRG: กลับไปหน้าเดิม (register_supbrcshos.php) ในโหมดแสดงเอกสารที่เพิ่งบันทึก
	if (ob_get_level() > 0) {
		ob_end_clean();
	}
	header('Location: register_supbrcshos.php?ref_id=' . rawurlencode($ref_id) . '&saved=1');
	exit();
} else {
	mysqli_rollback($conn);

	$failureRefId = isset($ref_id) ? $ref_id : '-';
	$failureText = implode("\\n", array_map(function ($msg) {
		return str_replace(array("\\", "'", "\r", "\n"), array("\\\\", "\\'", " ", " "), $msg);
	}, $saveFailures));

	if ($isDraftRequest) {
		if (ob_get_level() > 0) {
			ob_end_clean();
		}
		echo json_encode(array(
			'success' => false,
			'message' => 'Unable to save draft (เอกสาร ' . $failureRefId . '): ' . implode(' / ', $saveFailures)
		));
		exit();
	}

	if (ob_get_level() > 0) {
		ob_end_clean();
	}
	echo "<script language=\"JavaScript\">";
	echo "alert('บันทึกข้อมูลไม่สำเร็จ (เอกสาร $failureRefId)\\n\\n$failureText');";
	echo "</script>";
}
	}
