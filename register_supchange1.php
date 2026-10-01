<?php
// เปิด output buffering ตั้งแต่ก่อน include head.php (ซึ่งส่ง HTML ออกทันที)
// เพื่อให้เรียก header('Location: ...') ได้จริงตอนบันทึกสำเร็จ (true POST-Redirect-GET)
// กัน "Confirm Form Resubmission" เมื่อผู้ใช้กด reload ค้างอยู่ที่หน้า response ของ POST
ob_start();
// Draft (เรียกผ่าน register_supchange_draft1.php) เป็น AJAX ที่รอ JSON กลับ ไม่ใช่หน้า HTML เต็ม
// จึงข้าม head.php (ซึ่งพ่วง session_start() มาแล้วจาก router) และตอบ Content-Type เป็น json แทน
// มิเรอร์ register_supbrcshos1.php:6-13
$isDraftRequest = isset($_POST["is_draft"]) && $_POST["is_draft"] === "1";
if (!$isDraftRequest) {
	include("head.php");
} else {
	header('Content-Type: application/json; charset=utf-8');
}
?>

<?php
include("dbconnect.php");
include("error_page.php");

date_default_timezone_set("Asia/Bangkok");
// เดิมเขียน $_POST["submit"] = "submit" (assignment) ทำให้เงื่อนไขเป็นจริงเสมอ
// เปิดไฟล์นี้ตรง ๆ ก็รันโค้ดบันทึกได้ จึงเปลี่ยนเป็นการเปรียบเทียบจริง
if (isset($_POST["submit"]) && $_POST["submit"] === "submit") {

// ===== Helper อ่านค่า $_POST =====
// พอร์ตชุดเดียวกับ register_supbrcshos1.php:30-97 (มี function_exists guard ทุกตัว จึงปลอดภัยเมื่อ
// ไฟล์อื่นถูก include มาก่อน) แก้สองปัญหาของโค้ดเดิมพร้อมกัน: ฟอร์มไม่ได้ส่งทุกฟิลด์ที่โค้ดอ้างถึง
// (undefined array key) และเดิมไม่ escape เลย ทำให้ชื่อลูกค้า/หมายเหตุที่มี ' ทำ INSERT พัง
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
	// คอลัมน์ DATE ใน hos__change / tb_register_data เป็น NOT NULL ทั้งหมด ถ้าส่งค่าว่างไปจะได้
	// '0000-00-00' อยู่ดี เขียนให้ชัดเจนตรงนี้แทนการพึ่ง sql_mode=''
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
	// ใช้กับคอลัมน์ที่ Google Sheet ระบุว่า "เพิ่มใหม่" แต่ยังไม่มีจริงใน schema
	// (hos__change.que_ckk / is_cancel / remark_cancel, tb_transaction.install_room)
	// ดู sql/supchange_optional_columns.sql
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

if (!function_exists('chg_abort_with_alert')) {
	// $isDraftRequest มาจาก scope ไฟล์ (ประกาศไว้ก่อน include นี้เสมอ ทั้งจาก request ตรงและจาก
	// register_supchange_draft1.php/register_supchange_edit1.php ที่ set $_POST['is_draft'] ก่อน include)
	function chg_abort_with_alert($message, $isDraftRequest = false)
	{
		if (ob_get_level() > 0) {
			ob_end_clean();
		}
		if ($isDraftRequest) {
			echo json_encode(array('success' => false, 'message' => $message));
			exit();
		}
		$safeMessage = str_replace(array("\\", "'", "\r", "\n"), array("\\\\", "\\'", " ", " "), $message);
		echo "<script>alert('" . $safeMessage . "');history.back();</script>";
		exit();
	}
}

// partials/product_table_change.php เรนเดอร์ 6 แถวคงที่ (product_table_change.php:474-476)
$chgProductRowCount = 6;

// ===== Backend validation =====
// กันกรณีปิด JS หรือยิง POST ตรงเข้ามาโดยไม่ผ่านฟอร์ม (เดิมพึ่ง fncSubmit() ฝั่ง JS อย่างเดียว)
// mirror รายการฟิลด์บังคับเดียวกับ fncSubmit() ใน register_supchange.php — ข้ามเมื่อเป็น Draft
// เพราะ "Save Draft" ตั้งใจให้บันทึกข้อมูลไม่ครบได้ (มิเรอร์ register_supbrcshos1.php:148)
if (!$isDraftRequest) {
	$chgRequiredFieldLabels = array(
		'start_time' => 'กรุณาใส่เวลาส่ง',
		'customer_name' => 'กรุณาใส่ชื่อลูกค้า',
		'customer_tel' => 'กรุณาใส่เบอร์โทรลูกค้า',
		'address_name' => 'กรุณาใส่ที่อยู่ในการส่งสินค้า',
		'address_send' => 'กรุณาใส่สถานที่ติดตั้งเครื่อง',
		'province_name' => 'กรุณาเลือกจังหวัดที่ต้องการจัดส่ง',
	);

	$chgValidationErrors = array();
	foreach ($chgRequiredFieldLabels as $chgRequiredField => $chgRequiredMessage) {
		if (trim((string)($_POST[$chgRequiredField] ?? '')) === '') {
			$chgValidationErrors[] = $chgRequiredMessage;
		}
	}

	$chgHasProductPost = false;
	for ($chgValidatePi = 1; $chgValidatePi <= $chgProductRowCount; $chgValidatePi++) {
		if (trim((string)($_POST['product_id' . $chgValidatePi] ?? '')) !== '') {
			$chgHasProductPost = true;
			break;
		}
	}
	if (!$chgHasProductPost) {
		$chgValidationErrors[] = 'กรุณาเลือกสินค้าอย่างน้อย 1 รายการ';
	}

	// การแลกเปลี่ยนสินค้า: จำนวนแลกเข้า/แลกออกต่างกันได้ แต่มูลค่ารวมสองฝั่งต้องเท่ากัน
	$chgValueIn = 0.0;
	$chgValueOut = 0.0;
	for ($chgValidatePi = 1; $chgValidatePi <= $chgProductRowCount; $chgValidatePi++) {
		$chgValidatePrice = (float) cs_post_raw("product_price" . $chgValidatePi);
		$chgValueIn += (float) cs_post_raw("count_stock" . $chgValidatePi) * $chgValidatePrice;
		$chgValueOut += (float) cs_post_raw("count_sale" . $chgValidatePi) * $chgValidatePrice;
	}
	if (abs($chgValueIn - $chgValueOut) > 0.01) {
		$chgValidationErrors[] = 'มูลค่าสินค้าแลกเข้า (' . number_format($chgValueIn, 2) . ') ต้องเท่ากับมูลค่าแลกออก (' . number_format($chgValueOut, 2) . ')';
	}

	if (!empty($chgValidationErrors)) {
		chg_abort_with_alert("กรุณากรอกข้อมูลให้ครบถ้วน\n\n" . implode("\n", $chgValidationErrors));
	}
}


// ===== $_POST -> ตัวแปร (hos__change) =====
$company = cs_post($conn, "company");
// ฟอร์มไม่มีช่อง date_change (ถูกคอมเมนต์ไว้) — เดิมทำให้ hos__change.date_change เป็น 0000-00-00 ทุกใบ
$date_change = cs_post_raw("date_change") !== '' ? cs_post_date($conn, "date_change") : date('Y-m-d');
$customer = cs_post($conn, "customer");
$customer_id = cs_post($conn, "customer_id");
$address = cs_post($conn, "address");
// Google Sheet ชีต "ใบแลกเปลี่ยนสินค้า" ระบุ "หมายเหตุ" -> hos__change.sn แต่ยืนยันแล้วว่าคงพฤติกรรมเดิม
// (sale_comment -> hos__change.sale_comment + tb_register_data.description) เพื่อไม่ให้รายงานเดิมพัง
$sale_comment = cs_post($conn, "sale_comment");
$sn_ckk = cs_post($conn, "sn_ckk", "0");
$sn = cs_post($conn, "sn");
$objective = cs_post($conn, "objective");
$objective_des = cs_post($conn, "objective_des");

// ปุ่ม "ยกเลิกเอกสาร" (แท็บ Admin) ส่ง hidden cancel_doc มา — ยกเลิกมีลำดับเหนือ Draft
// มิเรอร์ register_supbrcshos1.php:197-200
$isCancelDoc = (cs_post_raw("cancel_doc") === "1");
$status_doc = $isCancelDoc ? "ยกเลิก" : ($isDraftRequest ? "Draft" : "Request");

// แท็บที่อยู่การคืน — ฟอร์มนี้ mirror ไว้เป็น hidden ค่าว่าง (register_supchange.php:945-951)
$returns = cs_post($conn, "returns", "0");
$returns_date = cs_post_date($conn, "returns_date");
$returns_time = cs_post($conn, "returns_time");
$returns_name = cs_post($conn, "returns_name");
$returns_address = cs_post($conn, "returns_address");
$returns_contact = cs_post($conn, "returns_contact");
$return_date_bet = cs_post($conn, "return_date_bet");

// ข้อมูลการจัดส่ง
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

// แท็บ Admin
$iv_no = cs_post($conn, "admin_doc_no");
$iv_date = cs_post_date($conn, "admin_doc_date");
$send_cs = cs_post_flag("send_cs");

// แท็บค่าจัดส่ง
$date_ker = cs_post_date($conn, "shipping_date");
$order_refer_code = cs_post($conn, "shipping_ref1");
$order_refer_code1 = cs_post($conn, "shipping_ref2");
$ker_bath = cs_post_amount($conn, "shipping_cost");

$sale_date = date('Y-m-d');
$sale = mysqli_real_escape_string($conn, (string)($_SESSION['name'] ?? ''));
$sale_code = cs_post($conn, "sale_code");
$name = $_SESSION['name'] ?? '';
$surname = $_SESSION['surname'] ?? '';
$em_id = mysqli_real_escape_string($conn, (string)($_SESSION['emid'] ?? ''));
$code = mysqli_real_escape_string($conn, (string)($_SESSION['code'] ?? ''));

$add_date = date('Y-m-d H:i:s');
// $add_by ถูกเขียนทับด้วย $_POST['add_by'] ตอนบันทึก tb_register_data (hidden ในฟอร์ม)
// เก็บค่าจาก session ไว้ต่างหากสำหรับตารางที่บันทึกก่อนหน้านั้น
$add_by_session = mysqli_real_escape_string($conn, "$name $surname");

$adm_ckk = ($code === 'ADM') ? '1' : '0';

// เอกสาร Draft ต้องยังไม่ถูกส่งให้หัวหน้า — เดิม INSERT ฮาร์ดโค้ด send_sup='1' ทุกกรณี ทำให้
// ปุ่ม Submit บนหน้าฟอร์ม (ซ่อนเมื่อ send_sup='1') หายไปตั้งแต่กด Save Draft ครั้งแรก
// มิเรอร์ register_supbrcshos1.php:267-272
$send_sup_val = ($isDraftRequest && !$isCancelDoc) ? "0" : "1";
$send_supname_val = ($send_sup_val === "1") ? $add_by_session : "";
$send_supdate_val = ($send_sup_val === "1") ? $add_date : "";


// ===== เลขที่เอกสาร (CH + ปีเดือน พ.ศ. + running 3 หลัก) =====
// คงตรรกะเดิมทั้งหมด — ต่างจาก BS ของ register_supbrcshos1.php ที่ running 5 หลัก
$yearMonth = substr(date("Y") + 543, -2) . date("m");
$sql1 = "SELECT MAX(ref_id) AS MAXID FROM hos__change ";
$qry1 = mysqli_query($conn, $sql1);
$rs1 = mysqli_fetch_assoc($qry1);

$maxId = substr((string)$rs1['MAXID'], -3);
$maxId3 = substr((string)$rs1['MAXID'], -7);
$maxId1 = substr($maxId3, 0, -3);

if ($maxId1 == $yearMonth) {
	$maxId1 = ($maxId + 1);
	$maxId2 = substr("000" . $maxId1, -3);
	$nextId = $yearMonth . $maxId2;
} else {
	$maxId1 = "001";
	$nextId = $yearMonth . $maxId1;
}

$so = "CH";
$ref_id = "$so$nextId";
$ref_id_escaped = mysqli_real_escape_string($conn, $ref_id);

// ===== กันเลขที่เอกสาร (iv_no) ซ้ำ — เลขไม่ได้ถูกจองตอนกดปุ่ม "Run เอกสาร" (ajax_run_doc_no.php
// นับจาก hos__change.iv_no โดยตรง ไม่มีตารางตัวนับ) ถ้าสองคนกด Run พร้อมกันจะได้เลขเดียวกัน
// จึงกันเลขซ้ำที่จุดบันทึกแทน — มิเรอร์ register_supbrcshos1.php:214-234
if ($iv_no !== '') {
	$chgDupQuery = mysqli_query($conn, "SELECT ref_id FROM hos__change WHERE iv_no = '" . $iv_no . "' LIMIT 1");
	$chgDupRow = $chgDupQuery ? mysqli_fetch_assoc($chgDupQuery) : null;
	if ($chgDupRow) {
		$chgDupMessage = 'เลขที่เอกสาร ' . cs_post_raw("admin_doc_no") . ' ถูกใช้กับเอกสาร ' . $chgDupRow['ref_id']
			. ' แล้ว กรุณากดปุ่ม Run เอกสารใหม่อีกครั้ง';
		chg_abort_with_alert($chgDupMessage, $isDraftRequest);
	}
}


// ===== แนบไฟล์ (slip1..slip5) =====
// เดิมเรียก move_uploaded_file() ดิบ ๆ ไปที่ "upload/" โดยไม่เคยเซ็ต $slipN ทำให้คอลัมน์ slip1-5
// เป็นค่าว่างเสมอ (และโฟลเดอร์ upload/ ก็ไม่มีอยู่จริง) — พอร์ตรูปแบบเดียวกับ register_supbrcshos1.php:302-376
// ปลายทางคง "upload/" ไว้ เพราะหน้าดู/แก้ไขของเอกสาร CH ลิงก์ไปที่ upload/<slip> (register_suptran_edit.php:468)
$chgUploadDir = __DIR__ . '/upload';
if (!is_dir($chgUploadDir)) {
	@mkdir($chgUploadDir, 0777, true);
}

$chgSlips = array();
for ($chgSlipIndex = 1; $chgSlipIndex <= 5; $chgSlipIndex++) {
	$chgSlipField = 'slip' . $chgSlipIndex;
	$chgSlips[$chgSlipIndex] = '';

	if (!isset($_FILES[$chgSlipField]) || (int)$_FILES[$chgSlipField]['size'] === 0) {
		continue;
	}
	if ($_FILES[$chgSlipField]['size'] > 1100000) {
		chg_abort_with_alert('กรุณาแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB', $isDraftRequest);
	}

	$chgSlipNameParts = explode(".", $_FILES[$chgSlipField]["name"]);
	$chgSlipFileName = $chgSlipField . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($chgSlipNameParts);
	if (move_uploaded_file($_FILES[$chgSlipField]["tmp_name"], $chgUploadDir . '/' . $chgSlipFileName)) {
		$chgSlips[$chgSlipIndex] = $chgSlipFileName;
	}
}
$slip1 = mysqli_real_escape_string($conn, $chgSlips[1]);
$slip2 = mysqli_real_escape_string($conn, $chgSlips[2]);
$slip3 = mysqli_real_escape_string($conn, $chgSlips[3]);
$slip4 = mysqli_real_escape_string($conn, $chgSlips[4]);
$slip5 = mysqli_real_escape_string($conn, $chgSlips[5]);


// ครอบทุกตารางที่บันทึกในเอกสารนี้ด้วย transaction เดียว เพื่อไม่ให้ข้อมูลค้างครึ่งเมื่อมีตัวใดตัวหนึ่งพัง
// PHP 8.1+ ตั้ง mysqli.report_mode เป็น ERROR|STRICT เป็น default ทำให้ query ที่ล้มเหลว throw
// mysqli_sql_exception แทนการคืน false เฉย ๆ catch ด้านล่างจึงครอบทุก query ในไฟล์นี้ได้จริง
$saveOk = true;
$saveFailures = array();
mysqli_begin_transaction($conn);

try {

// ===== ตารางหลัก (hos__change) =====
// คอลัมน์จาก sql/supchange_optional_columns.sql — เขียนพร้อมแถวใน INSERT เดียว (atomic)
// แต่ยังข้ามเงียบ ๆ ถ้า DB ปลายทางยังไม่ได้รัน ALTER (cs_column_exists มีแคชในตัว
// จึงยิง SHOW COLUMNS แค่คอลัมน์ละครั้ง) — pattern เดียวกับ register_supbrcshos1.php:765
$chgOptionalColumns = array(
	// แท็บข้อมูลเอกสาร: toggle "งานด่วน"
	'que_ckk' => cs_post_flag('que_ckk'),
	// แท็บ Admin: ปุ่ม "ยกเลิกเอกสาร" + หมายเหตุการยกเลิก
	'is_cancel' => $isCancelDoc ? '1' : '0',
	'remark_cancel' => cs_post($conn, 'admin_cancel_reason'),
);

$chgOptionalCols = '';
$chgOptionalVals = '';
foreach ($chgOptionalColumns as $chgOptionalName => $chgOptionalValue) {
	if (!cs_column_exists($conn, 'hos__change', $chgOptionalName)) {
		continue;
	}
	$chgOptionalCols .= ',' . $chgOptionalName;
	$chgOptionalVals .= ",'" . $chgOptionalValue . "'";
}

$save = "insert into hos__change
(company,ref_id,date_change,customer,customer_id,address,sale_comment,sn_ckk,sn,objective,objective_des,returns,returns_date,returns_time,returns_name,returns_address,returns_contact,status_doc,delivery_name,delivery_type,delivery_date,delivery_time,delivery_address,delivery_contact,delivery_tel,date_send_key,sale_date,sale,sale_code,add_date,add_by,return_date_bet,slip1,slip2,slip3,slip4,slip5,send_sup,send_supname,send_supdate,approve,approve_date,approve_code,adm_ckk,iv_no,iv_date,send_cs,date_ker,order_refer_code,order_refer_code1,ker_bath" . $chgOptionalCols . ")
values
('" . $company . "','" . $ref_id . "','" . $date_change . "','" . $customer . "','" . $customer_id . "','" . $address . "','" . $sale_comment . "','" . $sn_ckk . "','" . $sn . "','" . $objective . "','" . $objective_des . "','" . $returns . "','" . $returns_date . "','" . $returns_time . "','" . $returns_name . "','" . $returns_address . "','" . $returns_contact . "','" . $status_doc . "','" . $delivery_name . "','" . $delivery_type . "','" . $delivery_date . "','" . $delivery_time . "','" . $delivery_address . "','" . $delivery_contact . "','" . $delivery_tel . "','" . $date_send_key . "','" . $sale_date . "','" . $sale . "','" . $sale_code . "','" . $add_date . "','" . $add_by_session . "','" . $return_date_bet . "','" . $slip1 . "','" . $slip2 . "','" . $slip3 . "','" . $slip4 . "','" . $slip5 . "','" . $send_sup_val . "','" . $send_supname_val . "','" . $send_supdate_val . "','" . $sale . "','" . $sale_date . "','" . $code . "','" . $adm_ckk . "','" . $iv_no . "','" . $iv_date . "','" . $send_cs . "','" . $date_ker . "','" . $order_refer_code . "','" . $order_refer_code1 . "','" . $ker_bath . "'" . $chgOptionalVals . ")";

$qsave = mysqli_query($conn, $save);
if (!$qsave) {
	$saveOk = false;
	$saveFailures[] = 'hos__change: ' . mysqli_error($conn);
}

// job_no ไม่ได้อยู่ใน INSERT list ด้านบน จึงยังเขียนด้วย UPDATE แบบมีเงื่อนไขตามเดิม
// (que_ckk / is_cancel / remark_cancel ย้ายไปอยู่ใน INSERT แล้ว)
cs_update_column_if_exists($conn, 'hos__change', 'ref_id', $ref_id, 'job_no', cs_post_raw('admin_work_no'));

// ช่วงเวลาจัดส่ง (sql/delivery_time_range.sql): เขียนเฉพาะค่าที่รู้จัก หน้าที่ไม่ส่งฟิลด์นี้มาจึงไม่ล้างค่าเดิม
if (in_array(cs_post_raw('time_range'), array('morning', 'afternoon', 'allday', 'specific'), true)) {
	cs_update_column_if_exists($conn, 'hos__change', 'ref_id', $ref_id, 'time_range', cs_post_raw('time_range'));
}


// ===== รายการสินค้า (hos__subchange) =====
// เดิมเป็น 6 บล็อก if ที่ copy-paste กันมา และไม่เคยบันทึก sn{i} ที่ฟอร์มส่งมา
$productNames = array();
$productUnits = array();
$productCounts = array();
$productRemarks = array();

for ($i = 1; $i <= $chgProductRowCount; $i++) {
	$product_id = cs_post($conn, "product_id" . $i);
	$count_stock = cs_post($conn, "count_stock" . $i);
	$count_sale = cs_post($conn, "count_sale" . $i);
	$product_price = cs_post($conn, "product_price" . $i);
	$sum_amount = cs_post_amount($conn, "sum_amount" . $i, '');
	$item_sn = cs_post($conn, "sn" . $i);
	$sale_remarkk = cs_post($conn, "sale_remarkk" . $i);

	// เก็บไว้ประกอบสตริงสรุป tb_register_data.product_name ด้านล่าง (escape ทีเดียวตอนท้าย)
	$productNames[$i] = cs_post_raw("product_name" . $i);
	$productUnits[$i] = cs_post_raw("unit_name" . $i);
	$productCounts[$i] = cs_post_raw("count_sale" . $i);
	$productRemarks[$i] = cs_post_raw("sale_remarkk" . $i);

	if ($product_id === '') {
		continue;
	}

	// product_id ถูกใช้ซ้ำเป็น product_code ตาม Google Sheet (convention เดียวกับ register_salechange1.php:257-259)
	$strSQLItem = "insert into hos__subchange
(ref_idd,product_id,product_code,count_stock,count_sale,price,amount,sn,sale_remark)
values ('" . $ref_id . "','" . $product_id . "','" . $product_id . "','" . $count_stock . "','" . $count_sale . "','" . $product_price . "','" . $sum_amount . "','" . $item_sn . "','" . $sale_remarkk . "')";

	mysqli_query($conn, $strSQLItem);
}


// ===== ส่งสินค้าด้วยใบรับสินค้า (tb_other_bill.ref_12) =====
// ฟอร์มนี้มี toggle ชื่อ no_money ตัวเดียว (ลง tb_register_data.no_price ด้วย) คอลัมน์ ref_1..ref_11 จึงเว้นว่าง
$ref_12 = cs_post_flag("no_money");
mysqli_query($conn, "DELETE FROM tb_other_bill WHERE ref_id = '" . $ref_id_escaped . "'");
mysqli_query($conn, "insert into tb_other_bill (ref_id,ref_12) values ('" . $ref_id . "','" . $ref_12 . "')");


// ===== รายละเอียดที่อยู่ (tb_transaction) =====
// ชื่อฟิลด์ friendly ของฟอร์มต้องแปลงเป็นคอลัมน์จริงเอง (พอร์ตจาก register_supbrcshos1.php:479-521)
$chg_park_front = cs_post($conn, "park_front");
$chg_car_home = ($chg_park_front === '1') ? '1' : '0';
$chg_car_road = ($chg_park_front === '0') ? '1' : '0';
$chg_car_park = cs_post($conn, "park_location");
$chg_height_ltd = cs_post_flag("is_high_roof");

$chg_entrance_type = cs_post($conn, "entrance_type");
$chg_slope = ($chg_entrance_type === '1') ? '1' : '0';
$chg_bundai = ($chg_entrance_type === '2') ? '1' : '0';
$chg_unit_bundai = cs_post($conn, "stair_count");
$chg_install = cs_post($conn, "install_floor");

$chg_room_type = cs_post($conn, "room_type");
$chg_room_bigger = cs_post($conn, "door_width");
$chg_room_longer = cs_post($conn, "door_height");

$chg_stair_width = cs_post_raw("stair_width");
$chg_stair_height = cs_post_raw("stair_height");
$chg_bundai_big = ($chg_stair_width !== '' || $chg_stair_height !== '') ? mysqli_real_escape_string($conn, $chg_stair_width . ' x ' . $chg_stair_height) : '';

$chg_elev_door_width = cs_post_raw("elev_door_width");
$chg_elev_door_height = cs_post_raw("elev_door_height");
$chg_lip_big = ($chg_elev_door_width !== '' || $chg_elev_door_height !== '') ? mysqli_real_escape_string($conn, $chg_elev_door_width . ' x ' . $chg_elev_door_height) : '';

$chg_elev_width = cs_post_raw("elev_width");
$chg_elev_height = cs_post_raw("elev_height");
$chg_elev_depth = cs_post_raw("elev_depth");
$chg_lip_long = ($chg_elev_width !== '' || $chg_elev_height !== '' || $chg_elev_depth !== '') ? mysqli_real_escape_string($conn, $chg_elev_width . ' x ' . $chg_elev_height . ' x ' . $chg_elev_depth) : '';

$chg_lip_weight = cs_post($conn, "elev_capacity");

$chg_want_employee = cs_post_flag("move_furn");
$chg_employee_unit = cs_post($conn, "move_furn_count");
$chg_ferniger_name = cs_post($conn, "move_furn_detail");
// tb_transaction ไม่มีคอลัมน์ addr_note (Google Sheet ระบุคลาดเคลื่อน) — ลง description ตาม convention เดิม
$chg_addr_note = cs_post($conn, "addr_note");

mysqli_query($conn, "DELETE FROM tb_transaction WHERE ref_id = '" . $ref_id_escaped . "'");
$strSQLTransaction = "insert into tb_transaction (ref_id,car_park,car_road,car_home,slope,bundai,unit_bundai,home_type,install,bundai_big,lip_big,lip_long,lip_weight,want_employee,employee_unit,ferniger_name,room_bigger,room_longer,description,height_ltd,add_date,add_by)
values('" . $ref_id . "','" . $chg_car_park . "','" . $chg_car_road . "','" . $chg_car_home . "','" . $chg_slope . "','" . $chg_bundai . "','" . $chg_unit_bundai . "','" . $chg_room_type . "','" . $chg_install . "','" . $chg_bundai_big . "','" . $chg_lip_big . "','" . $chg_lip_long . "','" . $chg_lip_weight . "','" . $chg_want_employee . "','" . $chg_employee_unit . "','" . $chg_ferniger_name . "','" . $chg_room_bigger . "','" . $chg_room_longer . "','" . $chg_addr_note . "','" . $chg_height_ltd . "','" . $add_date . "','" . $add_by_session . "')";
mysqli_query($conn, $strSQLTransaction);

cs_update_column_if_exists($conn, 'tb_transaction', 'ref_id', $ref_id, 'install_room', cs_post_raw('room_type'));


// ===== ที่อยู่เพิ่มเติม (tb_shipping_address) — สูงสุด 9 แถว =====
mysqli_query($conn, "DELETE FROM tb_shipping_address WHERE ref_id = '" . $ref_id_escaped . "'");

for ($chgShippingIndex = 1; $chgShippingIndex <= 9; $chgShippingIndex++) {
	$chgShippingContactName = cs_post_raw('extra_contact_name_' . $chgShippingIndex);
	$chgShippingTelephone = cs_post_raw('extra_contact_tel_' . $chgShippingIndex);
	$chgShippingProvince = cs_post_raw('extra_contact_province_' . $chgShippingIndex);
	$chgShippingAddress = cs_post_raw('extra_shipping_address_' . $chgShippingIndex);

	if ($chgShippingContactName === '' && $chgShippingTelephone === '' && $chgShippingProvince === '' && $chgShippingAddress === '') {
		continue;
	}

	mysqli_query($conn, "INSERT INTO tb_shipping_address (ref_id, contact_name, telephone, province, address) VALUES ('" .
		$ref_id_escaped . "','" .
		mysqli_real_escape_string($conn, $chgShippingContactName) . "','" .
		mysqli_real_escape_string($conn, $chgShippingTelephone) . "','" .
		mysqli_real_escape_string($conn, $chgShippingProvince) . "','" .
		mysqli_real_escape_string($conn, $chgShippingAddress) . "')");
}


// ===== ที่อยู่ส่งบิล (tb_delivery_bill) =====
// Google Sheet สลับ province <-> address_nameb — ยึดตาม register_supbrcshos1.php:586-602 ซึ่งตรงกับความหมายจริง
$chgDeliveryBillContactName = cs_post_raw('bill_extra_contact_name_2');
$chgDeliveryBillTelephone = cs_post_raw('bill_extra_contact_tel_2');
$chgDeliveryBillProvince = cs_post_raw('bill_extra_contact_province_2');
$chgDeliveryBillAddress = cs_post_raw('bill_extra_shipping_address_2');

mysqli_query($conn, "DELETE FROM tb_delivery_bill WHERE ref_id = '" . $ref_id_escaped . "'");

if ($chgDeliveryBillContactName !== '' || $chgDeliveryBillTelephone !== '' || $chgDeliveryBillProvince !== '' || $chgDeliveryBillAddress !== '') {
	mysqli_query($conn, "INSERT INTO tb_delivery_bill (ref_id, customer_nameb, customer_telb, province, address_nameb) VALUES ('" .
		$ref_id_escaped . "','" .
		mysqli_real_escape_string($conn, $chgDeliveryBillContactName) . "','" .
		mysqli_real_escape_string($conn, $chgDeliveryBillTelephone) . "','" .
		mysqli_real_escape_string($conn, $chgDeliveryBillProvince) . "','" .
		mysqli_real_escape_string($conn, $chgDeliveryBillAddress) . "')");
}


// ===== ข้อมูลการจัดส่ง (tb_register_data) =====
$start_date = cs_post_date($conn, "start_date");
$between_date = cs_post($conn, "between_date");
$status = cs_post($conn, "status");

// ฟิลด์ต่อไปนี้ไม่มี input ในฟอร์มปัจจุบัน — คง fallback เดิมไว้ แต่กัน undefined array key
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

// เดิมเทียบกับ '3'/'4' ซึ่งไม่ตรงกับ <select name="company"> ของฟอร์ม (1=AWL, 2=NBM) ทำให้ได้ค่าว่างเสมอ
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
$province_name = cs_post($conn, "province_name");
$transport_company = cs_post($conn, "transport_company");
$location_link = cs_post($conn, "location_link");

// สตริงสรุปรายการสินค้า (Google Sheet: tb_register_data.product_name)
$productSummaryParts = array('ส่ง');
for ($i = 1; $i <= $chgProductRowCount; $i++) {
	$productSummaryParts[] = $productNames[$i] . ' ' . $productRemarks[$i] . ' ' . $productCounts[$i] . ' ' . $productUnits[$i];
}
$productSummaryParts[] = cs_post_raw("address_name");
$product_name = mysqli_real_escape_string($conn, trim(preg_replace('/\s+/u', ' ', implode(' ', $productSummaryParts))));

$product_sn = cs_post($conn, "product_sn");
$unit_credit = cs_post($conn, "unit_credit");
$price = cs_post($conn, "unit_cash");
$employee_name = cs_post($conn, "employee_name");
$employee_tel = cs_post($conn, "employee_tel");
$add_by = cs_post($conn, "add_by");
$description = cs_post($conn, "sale_comment");
$havemap = cs_post($conn, 'have_map');
$unit_check = cs_post($conn, "unit_check");
$unit_bill = cs_post($conn, "unit_bill");
$unit_tran = cs_post($conn, "unit_tran");
$department_show = cs_post($conn, "department_show");
$dept = cs_post($conn, "dept");
$status_comment = cs_post($conn, "status_comment");
$address_1 = cs_post_raw("address_1") !== '' ? cs_post($conn, "address_1") : $address_name;

// เลขที่ลงงาน (admin_work_no): ถ้ากด "Run เลขที่ลงงาน" มาก่อน ajax_run_job_no.php ได้ INSERT แถวจองไว้ใน
// tb_register_data แล้ว (ref_id ตรงกับเอกสารนี้, running=เลขที่ลงงาน) ต้อง DELETE แถวจองนั้นทิ้งก่อน แล้ว
// INSERT แถวข้อมูลจริงพร้อมคอลัมน์ running กันมีสองแถวซ้ำ/เลขที่ลงงานหาย
$running = cs_post($conn, "admin_work_no");
mysqli_query($conn, "DELETE FROM tb_register_data WHERE ref_id = '" . $ref_id_escaped . "'");

$strSQL66 = "insert into tb_register_data (ref_id,start_date,between_date,start_time,end_time,status,fix_date,no_price,call_customer,credit,call_employee,cash,check_peper,bill,department,type_customer,type_company,customer_name,customer_tel,address_name,address_send,want_bus,product_name,product_sn,unit_credit,price,employee_name,employee_tel,add_by,description,have_map,add_date,unit_bill,unit_check,unit_tran,tran,check_detail,dep,dept,department_show,customer_contact,status_comment,on_time,address_1,add_code,province_name,transport_company,location_link,running)
values('" . $ref_id . "','" . $start_date . "','" . $between_date . "','" . $start_time . "','" . $end_time . "','" . $status . "','" . $fix_date . "','" . $no_price . "','" . $call_customer . "','" . $credit . "','" . $call_employee . "','" . $chash . "','" . $check_peper . "','" . $bill . "','" . $department . "','" . $type_customer . "','" . $type_company . "','" . $customer_name . "','" . $customer_tel . "','" . $address_name . "','" . $address_send . "','" . $want_bus . "','" . $product_name . "','" . $product_sn . "','" . $unit_credit . "','" . $price . "','" . $employee_name . "','" . $employee_tel . "','" . $add_by . "','" . $description . "','" . $havemap . "','" . $add_date . "','" . $unit_bill . "','" . $unit_check . "','" . $unit_tran . "','" . $tran . "','" . $check_detail . "','" . $dep . "','" . $dept . "','" . $department_show . "','" . $customer_contact . "','" . $status_comment . "','" . $on_time . "','" . $address_1 . "','" . $em_id . "','" . $province_name . "','" . $transport_company . "','" . $location_link . "','" . $running . "')";

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

	// true PRG: ล้าง buffer (ที่มี HTML จาก head.php ค้างอยู่) แล้วส่ง redirect จริงระดับ HTTP
	// แทน JS-redirect เดิม เพื่อไม่ให้ browser ถือว่าหน้านี้เป็น "response ของ POST"
	// กลับมาที่ตัวเอง (register_supchange.php) ในโหมด view/edit เพื่อให้ Save Draft/Update
	// กลับมาทำงานต่อกับเอกสารเดิมได้ (แทนปลายทางเดิม register_suptran_edit.php ซึ่งไม่รองรับ
	// การกลับมาแก้ไข) — มิเรอร์ pattern ของ register_supbrcshos1.php
	if (ob_get_level() > 0) {
		ob_end_clean();
	}
	header('Location: register_supchange.php?ref_id=' . rawurlencode($ref_id) . '&saved=1');
	exit();
} else {
	mysqli_rollback($conn);

	// แสดงสาเหตุจริงแทนคำว่า "Cannot" ลอย ๆ เพื่อให้ตามปัญหาได้
	$failureRefId = isset($ref_id) ? $ref_id : '-';
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
	chg_abort_with_alert("บันทึกข้อมูลไม่สำเร็จ (เอกสาร $failureRefId)\n\n" . implode("\n", $saveFailures));
}

}
