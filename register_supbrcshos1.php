<?php
// เปิด output buffering ตั้งแต่ก่อน include head.php (ซึ่งส่ง HTML ออกทันที)
// เพื่อให้เรียก header('Location: ...') ได้จริงตอนบันทึกสำเร็จ (true POST-Redirect-GET)
// กัน "Confirm Form Resubmission" เมื่อผู้ใช้กด reload ค้างอยู่ที่หน้า response ของ POST
ob_start();
// Draft (เรียกผ่าน register_supbrcshos_draft1.php) เป็น AJAX ที่รอ JSON กลับ ไม่ใช่หน้า HTML เต็ม
// จึงข้าม head.php (ซึ่งพ่วง session_start() มาแล้วจาก router) และตอบ Content-Type เป็น json แทน
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
// เดิมเขียน $_POST["submit"] = "submit" (assignment) ทำให้เงื่อนไขเป็นจริงเสมอ
// เปิดไฟล์นี้ตรง ๆ ก็รันโค้ดบันทึกได้ จึงเปลี่ยนเป็นการเปรียบเทียบจริง
if (isset($_POST["submit"]) && $_POST["submit"] === "submit") {

// ===== Helper อ่านค่า $_POST =====
// ฟอร์ม register_supbrcshos.php ไม่ได้มีทุกฟิลด์ที่โค้ดเดิมอ้างถึง (objective, dep, tran, have_map ฯลฯ)
// และเดิมไม่มีการ escape เลย ทำให้ชื่อลูกค้า/หมายเหตุที่มีเครื่องหมาย ' ทำ INSERT พัง
// helper ชุดนี้แก้ทั้งสองเรื่องพร้อมกัน
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
	// คอลัมน์ DATE ในตารางเป็น NOT NULL ทั้งหมด ถ้าส่งค่าว่างไปจะได้ '0000-00-00' อยู่ดี
	// เขียนให้ชัดเจนตรงนี้แทนการพึ่ง sql_mode=''
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
	// พอร์ตจาก updateTbTransactionColumnIfExists() (register_supbrhos1.php:452-467) ทำให้ใช้ได้ทุกตาราง
	// ใช้กับคอลัมน์ที่ Google Sheet ระบุไว้แต่ยังไม่มีจริงใน schema (job_no1, cm_no, install_room)
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
	// พอร์ตจาก getBrDeptCommentItemsFromPost() (register_supbrhos1.php:353-378)
	function cs_dept_comment_items_from_post()
	{
		$itemsJson = $_POST["dept_comment_items"] ?? "[]";
		$decodedItems = json_decode($itemsJson, true);
		if (!is_array($decodedItems)) {
			return array();
		}

		$items = array();
		$allowedDepartments = array(1, 2, 3, 4, 5);
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
	// พอร์ตจาก saveBrDeptCommentItems() (register_supbrhos1.php:380-393)
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

// Backend validation กันกรณีปิด JS หรือยิง POST ตรงเข้ามาโดยไม่ผ่านฟอร์ม (เดิมพึ่ง JS validation ใน fncSubmit() ฝั่งเดียว)
// mirror รายการฟิลด์บังคับเดียวกับ fncSubmit() ใน register_supbrcshos.php
// ข้ามการตรวจนี้เมื่อเป็น Draft เพราะ "Save Draft" ตั้งใจให้บันทึกข้อมูลไม่ครบได้
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
// ฟอร์มไม่มีช่อง date_br (วันที่เปิดเอกสาร) แล้ว — เดิมทำให้ hos__consig.date_save เป็น 0000-00-00 ทุกใบ
$date_br = date('Y-m-d');
$customer = cs_post($conn, "customer");
$customer_id = cs_post($conn, "customer_id");
$address = cs_post($conn, "address");
$sale_comment = cs_post($conn, "sale_comment");
$objective = cs_post($conn, "objective");
$objective_des = cs_post($conn, "objective_des");
// ปุ่ม "ยกเลิกเอกสาร" (แท็บ Admin) ส่ง hidden cancel_doc มา — ยกเลิกมีลำดับเหนือ Draft
// mirror register_suphos1.php:664-665
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
$date_send_key  = cs_post($conn, "between_date");
//$ckk_war = $_POST["ckk_war"];
// แท็บ Admin: เลขที่เอกสาร/วันที่ออกเอกสาร/หมายเหตุการยกเลิก (เดิม iv_no ถูก hardcode เป็น "")
$iv_no = cs_post($conn, "admin_doc_no");
// เลข BRSC ไม่ได้ถูกจองตอนกดปุ่ม "Run เอกสาร" แล้ว (ajax_run_doc_no.php นับจาก hos__consig.iv_no
// โดยตรง ไม่มีตารางตัวนับ) ถ้าสองคนกด Run พร้อมกันจะได้เลขเดียวกัน จึงกันเลขซ้ำที่จุดบันทึกแทน
// นับทุกสถานะรวมเอกสารที่ยกเลิก เพราะเลขที่ออกไปแล้วถือว่าถูกใช้ไปแล้ว
if ($iv_no !== '') {
	$csDupQuery = mysqli_query($conn, "SELECT ref_id FROM hos__consig WHERE iv_no = '" . $iv_no . "' LIMIT 1");
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
// แท็บค่าจัดส่ง
$date_ker = cs_post_date($conn, "shipping_date");
$order_refer_code = cs_post($conn, "shipping_ref1");
$order_refer_code1 = cs_post($conn, "shipping_ref2");
$ker_bath = cs_post_amount($conn, "shipping_cost");
// แท็บที่อยู่การคืน
$returns = cs_post($conn, "returns", "0");
$returns_date = cs_post_date($conn, "returns_date");
$returns_time = cs_post($conn, "returns_time");
$return_date_bet = cs_post($conn, "return_date_bet");
$returns_name = cs_post($conn, "returns_name");
$returns_contact = cs_post($conn, "returns_contact");
$returns_address = cs_post($conn, "returns_address");
$sale_date= date('Y-m-d');
$sale =  mysqli_real_escape_string($conn, (string)($_SESSION['name'] ?? ''));
$sale_code = cs_post($conn, "sale_code");
$name =  $_SESSION['name'];
$em_id =  mysqli_real_escape_string($conn, (string)($_SESSION['emid'] ?? ''));
//echo $sale_code;
//exit();

$add_date = date('Y-m-d H:i:s');
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";
// $add_by ถูกเขียนทับด้วย $_POST['add_by'] ตอนบันทึก tb_register_data (hidden ชื่อซ้ำในฟอร์ม)
// เก็บค่าจาก session ไว้ต่างหากสำหรับตารางที่บันทึกก่อนหน้านั้น
$add_by_session = mysqli_real_escape_string($conn, $add_by);

// เอกสาร Draft ต้องยังไม่ถูกส่งให้หัวหน้า — เดิม INSERT ฮาร์ดโค้ด send_sup='1' ทุกกรณี ทำให้
// ปุ่ม Submit บนหน้าฟอร์ม (ซ่อนเมื่อ send_sup='1') หายไปตั้งแต่กด Save Draft ครั้งแรก
// mirror register_suphos_edit1.php:485-495
$send_sup_val = ($isDraftRequest && !$isCancelDoc) ? "0" : "1";
$send_supname_val = ($send_sup_val === "1") ? $add_by_session : "";
$send_supdate_val = ($send_sup_val === "1") ? $add_date : "";

$yearMonth = substr(date("Y")+543, -2).date("m");
$sql = "SELECT MAX(ref_id) AS MAXID FROM hos__consig ";
$qry = mysqli_query($conn,$sql);
$rs = mysqli_fetch_assoc($qry);

$maxId = substr($rs['MAXID'], -5);
$maxId3 = substr($rs['MAXID'],-9);

$maxId1 = substr($maxId3,0,-5);

if($maxId1 == $yearMonth)
{
$maxId1 = ($maxId + 1);
$maxId2 = substr("00000".$maxId1, -5);
$nextId = $yearMonth.$maxId2;
}
else
{
$maxId1 = "00001";
$nextId = $yearMonth.$maxId1;

}


$so = "BS";
$ref_id ="$so$nextId";


if ($_FILES['slip1']['size'] == 0) {
$slip1 = "";
}else if ($_FILES['slip1']['size'] > 1100000) {
if (ob_get_level() > 0) {
	ob_end_clean();
}
echo"<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
exit();
}   else if ($_FILES['slip1']['size'] != 0) {
$temp1 = explode(".", $_FILES["slip1"]["name"]);
$slip1 = "slip1" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp1);
move_uploaded_file($_FILES["slip1"]["tmp_name"], "brsc/" . $slip1);
}



if ($_FILES['slip2']['size'] == 0) {
$slip2 = "";
}else if ($_FILES['slip2']['size'] > 1100000) {
if (ob_get_level() > 0) {
	ob_end_clean();
}
echo"<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
exit();
}   else if ($_FILES['slip2']['size'] != 0) {
$temp2 = explode(".", $_FILES["slip2"]["name"]);
$slip2 = "slip2" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp2);
move_uploaded_file($_FILES["slip2"]["tmp_name"], "brsc/" . $slip2);
}


if ($_FILES['slip3']['size'] == 0) {
$slip3 = "";
}else if ($_FILES['slip3']['size'] > 1100000) {
if (ob_get_level() > 0) {
	ob_end_clean();
}
echo"<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
exit();
}   else if ($_FILES['slip3']['size'] != 0) {
$temp3 = explode(".", $_FILES["slip3"]["name"]);
$slip3 = "slip3" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp3);
move_uploaded_file($_FILES["slip3"]["tmp_name"], "brsc/" . $slip3);
}


if ($_FILES['slip4']['size'] == 0) {
$slip4 = "";
}else if ($_FILES['slip4']['size'] > 1100000) {
if (ob_get_level() > 0) {
	ob_end_clean();
}
echo"<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
exit();
}   else if ($_FILES['slip4']['size'] != 0) {
$temp4 = explode(".", $_FILES["slip4"]["name"]);
$slip4 = "slip4" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp4);
move_uploaded_file($_FILES["slip4"]["tmp_name"], "brsc/" . $slip4);
}



if ($_FILES['slip5']['size'] == 0) {
$slip5 = "";
}else if ($_FILES['slip5']['size'] > 1100000) {
if (ob_get_level() > 0) {
	ob_end_clean();
}
echo"<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
exit();
}   else if ($_FILES['slip5']['size'] != 0) {
$temp5 = explode(".", $_FILES["slip5"]["name"]);
$slip5 = "slip5" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp5);
move_uploaded_file($_FILES["slip5"]["tmp_name"], "brsc/" . $slip5);
}

if($_SESSION['name']=='บรรจบพร' or $_SESSION['name']=='สุภัสสร' or $_SESSION['name']=='พิมลพร' or $_SESSION['name']=='ขนิษฐา' or $_SESSION['name']=='พิมพ์ชนก'){
$adm_ckk = '1';
}else{
$adm_ckk = '0';
}

// ครอบทุกตารางที่บันทึกในเอกสารนี้ด้วย transaction เดียว เพื่อไม่ให้ข้อมูลค้างครึ่งเมื่อมีตัวใดตัวหนึ่งพัง
// ทุกตารางที่ query ด้านล่างเป็น InnoDB แล้ว (ตรวจแล้ว) — PHP 8.1+ ตั้ง mysqli.report_mode เป็น
// ERROR|STRICT เป็นค่า default ทำให้ query ที่ล้มเหลว throw mysqli_sql_exception แทนการคืน false
// เฉย ๆ ดังนั้น catch ด้านล่างครอบทุก query ในไฟล์นี้ได้จริง (ทดสอบแล้วในเครื่องนี้)
$saveOk = true;
$saveFailures = array();
mysqli_begin_transaction($conn);

try {


$save="insert into hos__consig
(company,ref_id,date_save,customer,customer_id,address,sale_comment,objective,objective_des,status_doc,delivery_name,delivery_type,delivery_date,delivery_time,delivery_address,delivery_contact,delivery_tel,date_send_key,sale_date,sale,sale_code,add_date,add_by,slip1,slip2,slip3,slip4,slip5,iv_no,iv_date,remark_cancel,que_ckk,send_cs,date_ker,order_refer_code,order_refer_code1,ker_bath,returns,returns_date,returns_time,return_date_bet,returns_name,returns_contact,returns_address,send_sup,send_supname,send_supdate)
values
('".$company."','".$ref_id."','".$date_br."','".$customer."','".$customer_id."','".$address."','".$sale_comment."','".$objective."','".$objective_des."','".$status_doc."','".$delivery_name."','".$delivery_type."','".$delivery_date."','".$delivery_time."','".$delivery_address."','".$delivery_contact."','".$delivery_tel."','".$date_send_key."','".$sale_date."','".$sale."','".$sale_code."','".$add_date."','".$add_by_session."','".$slip1."','".$slip2."','".$slip3."','".$slip4."','".$slip5."','".$iv_no."','".$iv_date."','".$remark_cancel."','".$que_ckk."','".$send_cs."','".$date_ker."','".$order_refer_code."','".$order_refer_code1."','".$ker_bath."','".$returns."','".$returns_date."','".$returns_time."','".$return_date_bet."','".$returns_name."','".$returns_contact."','".$returns_address."','".$send_sup_val."','".$send_supname_val."','".$send_supdate_val."')";


$qsave=mysqli_query($conn,$save);
if (!$qsave) {
	$saveOk = false;
	$saveFailures[] = 'hos__consig: ' . mysqli_error($conn);
}

// คอลัมน์ที่ Google Sheet ระบุไว้แต่ยังไม่มีใน schema ปัจจุบัน — เขียนแบบมีเงื่อนไข
// ถ้ารัน ALTER TABLE เพิ่มคอลัมน์ทีหลัง โค้ดนี้จะเริ่มบันทึกให้เองโดยไม่ต้องแก้ซ้ำ
cs_update_column_if_exists($conn, 'hos__consig', 'ref_id', $ref_id, 'job_no1', cs_post_raw('admin_work_no'));
cs_update_column_if_exists($conn, 'hos__consig', 'ref_id', $ref_id, 'cm_no', cs_post_raw('cm_no'));

// ช่วงเวลาจัดส่ง (sql/delivery_time_range.sql): เขียนเฉพาะค่าที่รู้จัก หน้าที่ไม่ส่งฟิลด์นี้มาจึงไม่ล้างค่าเดิม
if (in_array(cs_post_raw('time_range'), array('morning', 'afternoon', 'allday', 'specific'), true)) {
	cs_update_column_if_exists($conn, 'hos__consig', 'ref_id', $ref_id, 'time_range', cs_post_raw('time_range'));
}


// ===== รายการสินค้า (hos__subconsig) =====
// เดิมเป็น 10 บล็อกที่ copy-paste กันมา ทำให้แถว 8-10 ไม่เคยถูกอ่าน product_name/unit_name
// ยุบเป็น loop เดียว เงื่อนไข skip เดิม (product_id{i} ว่าง = ข้าม) คงไว้ตามเดิม
$productNames = array();
$productUnits = array();
$productCounts = array();
$productRemarks = array();

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
	// "ชื่อที่แสดงในใบส่งสินค้า" — ฟอร์มส่งมาในชื่อ print_name{i} ลงคอลัมน์ admin_remark ตาม Google Sheet
	$admin_remark = cs_post($conn, "print_name" . $i);

	// เก็บไว้ประกอบสตริงสรุป tb_register_data.product_name ด้านล่าง (ไม่ escape เพราะจะ escape ทีเดียวตอนท้าย)
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
// พอร์ตจาก register_supbrhos1.php:395-408 — ฟอร์มส่ง comment_* / dept_comment_items / technician_required
// มาอยู่แล้วผ่าน partials/doc_tabs_card.php + js/doc-tabs-dept-comment.js แต่เดิมถูกทิ้งทั้งหมด
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
// ฟอร์มนี้มีเฉพาะ toggle ref_12 คอลัมน์ ref_1..ref_11 จึงเว้นว่างไว้
$ref_12 = cs_post_flag("ref_12");
mysqli_query($conn, "DELETE FROM tb_other_bill WHERE ref_id = '" . mysqli_real_escape_string($conn, $ref_id) . "'");
mysqli_query($conn, "insert into tb_other_bill (ref_id,ref_12) values ('" . $ref_id . "','" . $ref_12 . "')");


// ===== รายละเอียดที่อยู่ (tb_transaction) =====
// พอร์ตจาก register_supbrhos1.php:410-467 — ชื่อฟิลด์ friendly ของฟอร์มต้องแปลงเป็นคอลัมน์จริงเอง
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
// tb_transaction ไม่มีคอลัมน์ addr_note — ลง description ตาม convention ของ register_supbrhos1.php:448
$cs_addr_note = cs_post($conn, "addr_note");

mysqli_query($conn, "DELETE FROM tb_transaction WHERE ref_id = '" . mysqli_real_escape_string($conn, $ref_id) . "'");
$strSQLTransaction = "insert into tb_transaction (ref_id,car_park,car_road,car_home,slope,bundai,unit_bundai,home_type,install,bundai_big,lip_big,lip_long,lip_weight,want_employee,employee_unit,ferniger_name,room_bigger,room_longer,description,height_ltd,add_date,add_by)
values('" . $ref_id . "','" . $cs_car_park . "','" . $cs_car_road . "','" . $cs_car_home . "','" . $cs_slope . "','" . $cs_bundai . "','" . $cs_unit_bundai . "','" . $cs_room_type . "','" . $cs_install . "','" . $cs_bundai_big . "','" . $cs_lip_big . "','" . $cs_lip_long . "','" . $cs_lip_weight . "','" . $cs_want_employee . "','" . $cs_employee_unit . "','" . $cs_ferniger_name . "','" . $cs_room_bigger . "','" . $cs_room_longer . "','" . $cs_addr_note . "','" . $cs_height_ltd . "','" . $add_date . "','" . $add_by_session . "')";
mysqli_query($conn, $strSQLTransaction);

cs_update_column_if_exists($conn, 'tb_transaction', 'ref_id', $ref_id, 'install_room', cs_post_raw('room_type'));


// ===== ที่อยู่เพิ่มเติม (tb_shipping_address) — สูงสุด 9 แถว =====
// พอร์ตจาก register_supbrhos1.php:469-490
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
// พอร์ตจาก register_supbrhos1.php:492-546 (คอลัมน์ province_name{i} ยังไม่มีใน schema จึงเช็คก่อนเขียน)
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
// พอร์ตจาก register_supbrhos1.php:548-565
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

if($company=='1'){
 $type_company='ออลล์เวล ไลฟ์ บจก.';
	}else if($company=='2'){
	$type_company='โนเบิล เมด บจก.';
	}else{
	$type_company='';
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
// พอร์ตจาก register_supbrhos1.php:2194-2275
$save_to_customer_db = isset($_POST['save_to_customer_db']) && $_POST['save_to_customer_db'] === '1';
if ($save_to_customer_db && !empty($customer_id)) {
	$esc_customer_id = $customer_id;
	$esc_shipping_name = $customer_name;
	$esc_shipping_tel = $customer_tel;
	$esc_shipping_province = $province_name;
	$esc_install_location = $address_send;
	$esc_location_link = $location_link;

	// #address_name เก็บที่อยู่แบบรวมก้อน (address+ampher+province+postcode) ถ้าใส่ shipping_address ตรง ๆ
	// พร้อมเซ็ต shipping_province ด้วย จะเกิดจังหวัดซ้ำสะสมทุกครั้งที่บันทึกซ้ำ
	// จึงใช้ส่วนประกอบดิบจาก hidden field เมื่อมี ถ้าไม่มีค่อย fallback ไปใช้ address_name ทั้งก้อน
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

	// กันสร้างที่อยู่ซ้ำเมื่อกดบันทึกหลายครั้งด้วยข้อมูลชุดเดิม (ตารางไม่มี unique constraint)
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
		// shipping_index เป็นลำดับที่อยู่ของลูกค้าแต่ละราย (คอลัมน์ NOT NULL DEFAULT 1)
		// ถ้าไม่เซ็ตเองทุกแถวจะได้ 1 หมด ทำให้ลำดับใช้งานไม่ได้
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

// สตริงสรุปรายการสินค้า — เดิมประกอบจากแถว 1-7 เท่านั้น (แถว 8-10 ไม่เคยถูกอ่าน)
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
 // hidden add_by มีชื่อซ้ำ 2 จุดในฟอร์ม — ค่าที่ $_POST อ่านได้คือตัวหลังสุดใน DOM (แท็บรายละเอียดที่อยู่)
 $add_by = cs_post($conn, "add_by");
 $description = cs_post($conn, "sale_comment");
 $havemap = cs_post($conn, 'have_map');
$unit_check = cs_post($conn, "unit_check");
$unit_bill = cs_post($conn, "unit_bill");
$unit_tran = cs_post($conn, "unit_tran");
$department_show = cs_post($conn, "department_show");
$unit_check1 = str_replace(',', '', $unit_check);
$unit_bill1 = str_replace(',', '', $unit_bill);
$dept = cs_post($conn, "dept");
$status_comment = cs_post($conn, "status_comment");
$address_1 = cs_post_raw("address_1") !== '' ? cs_post($conn, "address_1") : $address_name;

$registerDataColumns = "ref_id,start_date,between_date,start_time,end_time,status,fix_date,no_price,call_customer,credit,call_employee,cash,check_peper,bill,department,type_customer,type_company,customer_name,customer_tel,address_name,address_send,want_bus,product_name,product_sn,unit_credit,price,employee_name,employee_tel,add_by,description,have_map,add_date,unit_bill,unit_check,unit_tran,tran,check_detail,dep,dept,department_show,customer_contact,status_comment,on_time,address_1,add_code,province_name,transport_company,location_link";
$registerDataValues = "'".$ref_id."','".$start_date."','".$between_date."','".$start_time."','".$end_time."','".$status."','".$fix_date."','".$no_price."','".$call_customer."','".$credit."','".$call_employee."','".$chash."','".$check_peper."','".$bill."','".$department."','".$type_customer."','".$type_company."','".$customer_name."','".$customer_tel."','".$address_name."','".$address_send."','".$want_bus."','".$product_name."','".$product_sn."','".$unit_credit."','".$price."','".$employee_name."','".$employee_tel."','".$add_by."','".$description."','".$havemap."','".$add_date."','".$unit_bill."','".$unit_check."','".$unit_tran."','".$tran."','".$check_detail."','".$dep."','".$dept."','".$department_show."','".$customer_contact."','".$status_comment."','".$on_time."','".$address_1."','".$em_id."','".$province_name."','".$transport_company."','".$location_link."'";

// shipping_id เพิ่มแบบมีเงื่อนไข ตาม pattern เดียวกับ register_supbrhos1.php:2311-2316
if (cs_column_exists($conn, 'tb_register_data', 'shipping_id')) {
	$registerDataColumns .= ",shipping_id";
	$registerDataValues .= ",'" . $shipping_id . "'";
}

$strSQL66 = "insert into tb_register_data ($registerDataColumns) values($registerDataValues)";

//echo $strSQL66;

$objQuery66 = mysqli_query($conn,$strSQL66);
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
	// แทน JS-redirect เดิม เพื่อไม่ให้ browser ถือว่าหน้านี้เป็น "response ของ POST" ที่ reload แล้วเสี่ยงถามซ้ำ
	// ข้อความ "บันทึกสำเร็จ" แสดงที่ปลายทาง (register_supbrcshos.php เอง — ไฟล์เดียวกับฟอร์ม create
	// รองรับ view/edit mode แล้ว ไม่ใช่หน้า register_supbrcshos_edit.php รุ่นเก่าอีกต่อไป) ผ่าน query param saved=1
	if (ob_get_level() > 0) {
		ob_end_clean();
	}
	header('Location: register_supbrcshos.php?ref_id=' . rawurlencode($ref_id) . '&saved=1');
	exit();
} else {
	mysqli_rollback($conn);

	// แสดงสาเหตุจริงแทนคำว่า "Cannot" ลอย ๆ เพื่อให้ตามปัญหาได้
	// exception อาจเกิดก่อนที่ $ref_id จะถูกสร้าง จึงต้อง guard ไว้
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
