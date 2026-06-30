<?php
$isDraftRequest = isset($_POST["is_draft"]) && $_POST["is_draft"] === "1";
if (!$isDraftRequest) {
	include("head.php");
}

include("dbconnect.php");
include("error_page.php");

date_default_timezone_set("Asia/Bangkok");

if ($isDraftRequest) {
	header('Content-Type: application/json; charset=utf-8');
}

// hos__so เป็นตาราง legacy ที่มีคอลัมน์ NOT NULL จำนวนมากโดยไม่มี default
// ให้ connection ของหน้านี้ใช้พฤติกรรมเดิมของระบบ เมื่อไม่ได้ระบุคอลัมน์เหล่านั้นใน INSERT
mysqli_query($conn, "SET SESSION sql_mode = REPLACE(REPLACE(@@SESSION.sql_mode, 'STRICT_TRANS_TABLES', ''), 'STRICT_ALL_TABLES', '')");

function applyDeliveryTimeRangeToPost()
{
	$timeRange = $_POST["time_range"] ?? "";
	$timeRangeMap = array(
		"morning" => array("08:00", "12:00"),
		"afternoon" => array("13:00", "17:00"),
		"allday" => array("08:00", "17:00")
	);

	if (isset($timeRangeMap[$timeRange])) {
		$_POST["start_time"] = $timeRangeMap[$timeRange][0];
		$_POST["end_time"] = $timeRangeMap[$timeRange][1];
	}
}

function getDeptCommentItemsFromPost()
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

function sanitizeAdminNumericInput($value)
{
	$value = preg_replace('/\D+/', '', trim((string)($value ?? '')));
	return $value !== '' ? $value : '';
}

function saveDeptCommentItems($conn, $commentSoId, $refId, $items)
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

function hosSubsoColumnExists($conn, $columnName)
{
	static $columnCache = array();
	if (array_key_exists($columnName, $columnCache)) {
		return $columnCache[$columnName];
	}

	$safeColumnName = mysqli_real_escape_string($conn, $columnName);
	$sql = "SHOW COLUMNS FROM hos__subso LIKE '" . $safeColumnName . "'";
	$query = mysqli_query($conn, $sql);
	$columnCache[$columnName] = ($query && mysqli_num_rows($query) > 0);
	return $columnCache[$columnName];
}

if (isset($_POST["submit"]) && $_POST["submit"] === "submit") {

	$defaultPostFields = array(
		'type_doc',
		'bill_name',
		'bill_address',
		'bill_tel',
		'full_bill',
		'bill_id',
		'date_so',
		'suggest',
		'payment',
		'payment_method',
		'que_ckk',
		'sale_comment',
		'po_no',
		'delivery_contract',
		'book_clear',
		'book_no',
		'brn_clear',
		'brn_no',
		'brnp_clear',
		'brnp_no',
		'sn_ckk',
		'sn_no',
		'address_send',
		'with_pr',
		'type_type',
		'type_detail',
		'delivery_type',
		'start_date',
		'start_time',
		'end_time',
		'address_name',
		'customer_name',
		'customer_tel',
		'payment_des',
		'between_date',
		'have_order',
		'cm_no',
		'mode_name',
		'plan_ckk',
		'date_tranfer',
		'tax_id',
		'pre_name',
		'sale_code',
		'pr_no',
		'email',
		'comment_cs',
		'comment_en',
		'comment_st',
		'comment_ad',
		'technician_required',
		'dept_comment_items',
		'head_1',
		'ref_1',
		'ref_2',
		'ref_3',
		'ref_4',
		'ref_5',
		'ref_6',
		'ref_7',
		'ref_8',
		'ref_9',
		'ref_10',
		'ref_11',
		'ref_12',
		'ref_13',
		'ref_des',
		'ic_ckk',
		'et_ckk',
		'fix_datetime',
		'no_money',
		'call_customer',
		'credit_card',
		'unit_credit',
		'want_bus',
		'call_back',
		'cash',
		'unit_cash',
		'check_paper',
		'unit_check',
		'bill',
		'unit_bill',
		'tran',
		'unit_tran',
		'dep',
		'department_name',
		'customer_typename',
		'address_1',
		'customer_contact',
		'mk_research',
		'on_time',
		'amphur_name',
		'province_name',
		'product_sn',
		'employee_name',
		'h_employee_name',
		'employee_tel',
		'add_by',
		'description',
		'have_map',
		'department_show',
		'dept',
		'status',
		'status_comment',
		'runway',
		'road',
		'soy',
		'car_load',
		'no_car_road',
		'car_road',
		'car_home',
		'slope',
		'bundai',
		'bundai_install',
		'lip',
		'want_employee',
		'want_ex',
		'want_credit',
		'want_prem',
		'head_bad',
		'height_ltd',
		'up',
		'no_up',
		'more',
		'type_bundai',
		'soy_long',
		'soy_big',
		'car_park',
		'door_long',
		'unit_bundai',
		'door_bigger',
		'door_longer',
		'type_door',
		'home_type',
		'install',
		'bundai_big',
		'lip_big',
		'lip_long',
		'lip_weight',
		'employee_unit',
		'ferniger_name',
		'ferniger_address',
		'number',
		'room_bigger',
		'room_longer',
		'bundai_hug',
		'bank',
		'description_ja',
		'bill_extra_contact_name_2',
		'bill_extra_contact_tel_2',
		'bill_extra_contact_province_2',
		'bill_extra_shipping_address_2'
	);

	for ($i = 1; $i <= 30; $i++) {
		$defaultPostFields[] = 'product_id' . $i;
		$defaultPostFields[] = 'sale_count' . $i;
		$defaultPostFields[] = 'product_price' . $i;
		$defaultPostFields[] = 'sale_remarkk' . $i;
		$defaultPostFields[] = 'sum_amount' . $i;
		$defaultPostFields[] = 'discount_unit' . $i;
		$defaultPostFields[] = 'warranty' . $i;
		$defaultPostFields[] = 'cal' . $i;
		$defaultPostFields[] = 'pm' . $i;
		$defaultPostFields[] = 'pm_year' . $i;
		$defaultPostFields[] = 'display_name' . $i;
	}

	for ($i = 1; $i <= 30; $i++) {
		$defaultPostFields[] = 'product_name' . $i;
		$defaultPostFields[] = 'unit_name' . $i;
		$defaultPostFields[] = 'product_code' . $i;
		$defaultPostFields[] = 'product_codet' . $i;
		$defaultPostFields[] = 'product_c' . $i;
		$defaultPostFields[] = 'clear_br' . $i;
		$defaultPostFields[] = 'clear_ivno' . $i;
		$defaultPostFields[] = 'jong_ckk' . $i;
		$defaultPostFields[] = 'jong_no' . $i;
	}

	for ($i = 1; $i <= 9; $i++) {
		$defaultPostFields[] = 'customer_name' . $i;
		$defaultPostFields[] = 'customer_tel' . $i;
		$defaultPostFields[] = 'province_name' . $i;
		$defaultPostFields[] = 'address_name' . $i;
	}

	foreach ($defaultPostFields as $fieldName) {
		if (!isset($_POST[$fieldName])) {
			$_POST[$fieldName] = '';
		}
	}

	applyDeliveryTimeRangeToPost();

	$type_doc = $_POST["type_doc"];
	$bill_name = $_POST["bill_name"];
	$bill_address = $_POST["bill_address"];
	$bill_tel = $_POST["bill_tel"];
	$full_bill = isset($_POST['full_bill']) ? 1 : 0;
	// bill_id ใน flow นี้ใช้เป็น customer_id หลักของลูกค้าที่ถูกเลือกจาก popup
	// และยังเป็น key ที่ flow อื่นของระบบใช้ต่อจริง เช่น การดึงภาระหนี้/ประวัติลูกค้า
	$bill_id = $_POST["bill_id"];

	// บันทึกที่อยู่ใหม่เข้าฐานข้อมูลของลูกค้ากรณีที่ปุ่ม "เพิ่มลงฐานลูกค้า" ถูกเลือกไว้
	$save_to_customer_db = isset($_POST['save_to_customer_db']) && $_POST['save_to_customer_db'] === '1';
	if ($save_to_customer_db && !empty($bill_id)) {
		$esc_customer_id = mysqli_real_escape_string($conn, $bill_id);
		$esc_shipping_name = mysqli_real_escape_string($conn, $_POST['customer_name'] ?? '');
		$esc_shipping_tel = mysqli_real_escape_string($conn, $_POST['customer_tel'] ?? '');
		$esc_shipping_province = mysqli_real_escape_string($conn, $_POST['province_name'] ?? '');
		$esc_shipping_address = mysqli_real_escape_string($conn, $_POST['address_name'] ?? '');
		$esc_install_location = mysqli_real_escape_string($conn, $_POST['address_send'] ?? '');
		$now = date('Y-m-d H:i:s');

		// ตรวจสอบคอลัมน์ที่มีอยู่จริงในตาราง tb_customer_shipping_address ป้องกันกรณีคอลัมน์ไม่มีใน schema
		$col_check = mysqli_query($conn, "SHOW COLUMNS FROM tb_customer_shipping_address");
		$existing_cols = array();
		if ($col_check) {
			while ($col_row = mysqli_fetch_assoc($col_check)) {
				$existing_cols[] = strtolower($col_row['Field']);
			}
		}

		$insert_fields = array(
			'customer_id' => "'$esc_customer_id'",
			'shipping_preface_name' => "''",
			'shipping_name' => "'$esc_shipping_name'",
			'shipping_address' => "'$esc_shipping_address'",
			'shipping_ampher' => "''",
			'shipping_province' => "'$esc_shipping_province'",
			'shipping_postcode' => "''",
			'shipping_tel' => "'$esc_shipping_tel'",
			'created_at' => "'$now'",
			'updated_at' => "'$now'"
		);

		if (in_array('install_location', $existing_cols)) {
			$insert_fields['install_location'] = "'$esc_install_location'";
		}
		if (in_array('location_link', $existing_cols)) {
			$insert_fields['location_link'] = "''";
		}

		$insert_cols_str = implode(', ', array_keys($insert_fields));
		$insert_vals_str = implode(', ', array_values($insert_fields));

		$sql_insert_ship = "INSERT INTO tb_customer_shipping_address ($insert_cols_str) VALUES ($insert_vals_str)";
		if (mysqli_query($conn, $sql_insert_ship)) {
			$_POST["shipping_id"] = mysqli_insert_id($conn);
		}
	}

	// billing_id ตั้งใจใช้เก็บ reference ไปยัง record ใน tb_customer_billing_address
	// เพื่อบอกว่าเอกสารนี้อ้างถึงข้อมูลออกบิลชุดใดโดยตรง
	// แต่ปัจจุบันพักการใช้งานไว้ก่อน จึงยังไม่รับค่าจาก POST มาใช้จริง
	// Temporarily hide billing_id usage in this flow without removing the field from the schema.
	// $billing_id = isset($_POST["billing_id"]) && $_POST["billing_id"] !== '' ? $_POST["billing_id"] : 0;
	$billing_id = 0;
	// shipping_id เป็น reference ไปยัง record ในตารางที่อยู่จัดส่ง
	// ปัจจุบันยังคงรับค่าตามปกติ เพราะใช้ระบุว่าฟอร์มนี้เลือกที่อยู่จัดส่งรายการใด
	$shipping_id = isset($_POST["shipping_id"]) && $_POST["shipping_id"] !== '' ? $_POST["shipping_id"] : 0;
	$date_so = $_POST["date_so"];
	$suggest = $_POST["suggest"];
	$payment = $_POST["payment"];
	$payment2 = trim($_POST["payment2"] ?? $payment);
	$payment_method = (int)($_POST["payment_method"] ?? 0);
	$que_ckk = isset($_POST['que_ckk']) ? 1 : 0;
	$sale_comment = $_POST["sale_comment"];
	$po_no = $_POST["po_no"];
	$delivery_contract = $_POST["delivery_contract"];
	$book_clear = isset($_POST['book_clear']) ? 1 : 0;
	$book_no = $_POST["book_no"];
	$brn_clear = isset($_POST['brn_clear']) ? 1 : 0;
	$brn_no = $_POST["brn_no"];
	$brnp_clear = isset($_POST['brnp_clear']) ? 1 : 0;
	$brnp_no = $_POST["brnp_no"];
	$sn_ckk = isset($_POST['sn_ckk']) ? 1 : 0;
	$sn_no = $_POST["sn_no"];
	$install_place = $_POST["address_send"];
	$with_pr = isset($_POST['with_pr']) ? 1 : 0;
	$type_type = $_POST["type_type"];
	$type_detail = $_POST["type_detail"];
	$delivery_type = $_POST["delivery_type"];
	$delivery_date = $_POST["start_date"];
	$start_time = $_POST["start_time"];
	$end_time = $_POST["end_time"];
	$delivery_time = "$start_time $end_time";
	$delivery_address = $_POST["address_name"];
	$delivery_contact = $_POST["customer_name"];
	$delivery_tel = $_POST["customer_tel"];
	$payment_des  = $_POST["payment_des"];
	$date_send_key  = $_POST["between_date"];
	$have_order = isset($_POST['have_order']) ? 1 : 0;
	$cm_no = $_POST["cm_no"];
	$mode_cus = $_POST["mode_name"];
	$plan_ckk = isset($_POST['plan_ckk']) ? 1 : 0;

	$date_tranfer = $_POST["date_tranfer"];
	$tax_id = $_POST["tax_id"];
	$pre_name = $_POST["pre_name"];
	$admin_box_count = sanitizeAdminNumericInput($_POST["admin_box_count"] ?? '');
	$admin_box_count_value = $admin_box_count !== '' ? $admin_box_count : '0';
	$admin_edit_count = sanitizeAdminNumericInput($_POST["admin_edit_count"] ?? '');
	$job_no = trim($_POST["admin_work_no"] ?? '');
	$job_no2 = trim($_POST["job_no2"] ?? '0');
	$sr_no = trim($_POST["admin_sr_no"] ?? '0');
	$dep_no = trim($_POST["dep_no"] ?? '0');
	$order_no = trim($_POST["admin_deposit_no"] ?? '0');
	$iv_date = trim($_POST["admin_doc_date"] ?? '');
	if (preg_match('/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/', $iv_date, $matches)) {
		$year = (int)$matches[3];
		if ($year > 2400) {
			$year -= 543;
		}
		$iv_date = sprintf('%04d-%02d-%02d', $year, (int)$matches[2], (int)$matches[1]);
	}
	$iv_time = $iv_date !== '' ? date('H:i:s') : '00:00:00';
	$sale_date = date('Y-m-d');
	$sale =  $_SESSION['name'];
	$sale_code = $_POST['sale_code'];
	//$sup_code = $_SESSION['code'];
	$name =  $_SESSION['name'];
	$admin = $_SESSION['name'];
	$admin_code = $_SESSION['code'] ?? '';
	$admin_date = date('Y-m-d H:i:s');
	$approve_time = date("H:i:s");
	$pr_no  = $_POST["pr_no"];
	$add_date = date('Y-m-d H:i:s');
	$surname =	$_SESSION['surname'];
	$add_by = "$name $surname";
	$em_id =  $_SESSION['emid'];
	$email = $_POST["email"];
	$code =  $_SESSION['code'];

	if ($code == 'ADM') {
		$adm_ckk = '1';
	} else {
		$adm_ckk = '0';
	}


	$comment_cs = $_POST["comment_cs"];
	$comment_en = $_POST["comment_en"];
	$comment_st = $_POST["comment_st"];
	$comment_ad = $_POST["comment_ad"];
	$technician_required = isset($_POST["technician_required"]) && $_POST["technician_required"] === "1" ? 1 : 0;
	$deptCommentItems = getDeptCommentItemsFromPost();


	if ($name == 'ธัญนุช' or $name == 'ปวัน​รัตน์​') {
		$sup_code = 'MK';
		$approve  = $name;
	} else {
		if ($sale_code == 'S23' or $sale_code == 'S24' or $sale_code == 'S17' or $sale_code == 'S11' or $sale_code == 'S12' or $sale_code == 'S13' or $sale_code == 'S14') {
			$sup_code = 'SS2';
			$approve  = 'นรินทิพย์';
		} else if ($sale_code == 'S15' or $sale_code == 'S22' or $sale_code == 'S21' or $sale_code == 'S51' or $sale_code == 'S16') {

			$sup_code = 'SS1';
			$approve  = 'พรรณิภา';
		} else if ($sale_code == 'SM1' or $sale_code == 'MM2') {

			$sup_code = 'SM1';
			$approve  = 'ลักษณาวรรณ';
		} else if ($sale_code == 'S32' or $sale_code == 'S31' or $sale_code == 'MM1') {
			$sup_code = 'SS3';
			$approve  = 'มาลินี';
		} else if ($sale_code == 'EN') {
			$sup_code = 'SUP_EN';
			$approve  = 'ศิรวิทย์';
		} else if ($sale_code == 'CM') {
			$sup_code = 'CM';
			$approve  = 'ชลชินี';
		}
	}

	$head_1 = $_POST["head_1"];
	$ref_1 = $_POST["ref_1"];
	$ref_2 = $_POST["ref_2"];
	$ref_3 = $_POST["ref_3"];
	$ref_4 = $_POST["ref_4"];
	$ref_5 = $_POST["ref_5"];
	$ref_6 = $_POST["ref_6"];
	$ref_7 = $_POST["ref_7"];
	$ref_8 = $_POST["ref_8"];
	$ref_9 = $_POST["ref_9"];
	$ref_10 = $_POST["ref_10"];
	$ref_11 = $_POST["ref_11"];
	$ref_12 = $_POST["ref_12"];
	$ref_13 = $_POST["ref_13"];
	$ref_des = $_POST["ref_des"];

	$ic_ckk = isset($_POST['ic_ckk']) ? 1 : 0;
	$et_ckk = isset($_POST['et_ckk']) ? 1 : 0;
	$repeat_cus = isset($_POST['repeat_cus']) ? 1 : 0;
	$time_range = $_POST["time_range"] ?? '';
	$status_comment_val = $_POST["status_comment"] ?? '';

	if (!$isDraftRequest && $po_no != '') {
		$strSQL23 = "SELECT * FROM hos__po WHERE po_no = '" . $po_no . "'";
		$objQuery23 = mysqli_query($conn, $strSQL23);
		$num = mysqli_num_rows($objQuery23);

		if ($num > 0) {
			echo "<script language=\"JavaScript\">";
			echo "alert('PO เลขที่ $po_no มีการบันทึกข้อมูลไปแล้วค่ะ');window.location='register_suphos.php';";
			echo "</script>";
			exit();
		}
	}



	//echo $_FILES['upload1']['name'];
	//exit();

	if ($_FILES['slip1']['size'] == 0) {
		$slip1 = "";
	} else if ($_FILES['slip1']['size'] > 1100000) {
		echo "<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
		exit();
	} else if ($_FILES['slip1']['size'] != 0) {
		$temp1 = explode(".", $_FILES["slip1"]["name"]);
		$slip1 = "slip1" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp1);
		move_uploaded_file($_FILES["slip1"]["tmp_name"], "upload/" . $slip1);
	}



	if ($_FILES['slip2']['size'] == 0) {
		$slip2 = "";
	} else if ($_FILES['slip2']['size'] > 1100000) {
		echo "<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
		exit();
	} else if ($_FILES['slip2']['size'] != 0) {
		$temp2 = explode(".", $_FILES["slip2"]["name"]);
		$slip2 = "slip2" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp2);
		move_uploaded_file($_FILES["slip2"]["tmp_name"], "upload/" . $slip2);
	}


	if ($_FILES['slip3']['size'] == 0) {
		$slip3 = "";
	} else if ($_FILES['slip3']['size'] > 1100000) {
		echo "<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
		exit();
	} else if ($_FILES['slip3']['size'] != 0) {
		$temp3 = explode(".", $_FILES["slip3"]["name"]);
		$slip3 = "slip3" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp3);
		move_uploaded_file($_FILES["slip3"]["tmp_name"], "upload/" . $slip3);
	}


	if ($_FILES['slip4']['size'] == 0) {
		$slip4 = "";
	} else if ($_FILES['slip4']['size'] > 1100000) {
		echo "<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
		exit();
	} else if ($_FILES['slip4']['size'] != 0) {
		$temp4 = explode(".", $_FILES["slip4"]["name"]);
		$slip4 = "slip4" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp4);
		move_uploaded_file($_FILES["slip4"]["tmp_name"], "upload/" . $slip4);
	}



	if ($_FILES['slip5']['size'] == 0) {
		$slip5 = "";
	} else if ($_FILES['slip5']['size'] > 1100000) {
		echo "<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
		exit();
	} else if ($_FILES['slip5']['size'] != 0) {
		$temp5 = explode(".", $_FILES["slip5"]["name"]);
		$slip5 = "slip5" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp5);
		move_uploaded_file($_FILES["slip5"]["tmp_name"], "upload/" . $slip5);
	}

	$yearMonth = substr(date("Y") + 543, -2) . date("m");
	$sql = "SELECT MAX(ref_id) AS MAXID FROM hos__so";
	$qry = mysqli_query($conn, $sql) or die(mysqli_error());
	$rs = mysqli_fetch_assoc($qry);
	$maxId = substr($rs['MAXID'], -4);
	$maxId3 = substr($rs['MAXID'], -8);

	$maxId1 = substr($maxId3, 0, -4);
	$so = "SO";

	if ($maxId1 == $yearMonth) {
		$maxId1 = ($maxId + 1);
		$maxId2 = substr("00000" . $maxId1, -4);
		$nextId = $yearMonth . $maxId2;
	} else {
		$maxId1 = "0001";
		$nextId = $yearMonth . $maxId1;
	}

	$so = "SO";
	$ref_id = "$so$nextId";

	if (!$isDraftRequest && $ic_ckk == '1') {
		$iv_no = "IC";
	} else if (!$isDraftRequest) {
		$iv_no = "IV";
	} else {
		$iv_no = "";
	}

	$statusDoc = $isDraftRequest ? "Draft" : "Request";
	$sendSup = $isDraftRequest ? "0" : "1";
	$approveValue = $isDraftRequest ? "" : $approve;
	$approveCodeValue = $isDraftRequest ? "" : $sup_code;
	$approveDateValue = $isDraftRequest ? "" : $sale_date;
	$approveTimeValue = $isDraftRequest ? "" : $approve_time;
	$ivDateValue = $isDraftRequest ? "" : $iv_date;
	$ivTimeValue = $isDraftRequest ? "" : $iv_time;



	$save = "insert into hos__so
	(ref_id,type_doc,bill_name,bill_address,bill_tel,full_bill,date_so,suggest,payment,payment_method,sale_comment,po_no,delivery_contract,book_clear,book_no,brn_clear,brn_no,brnp_clear,brnp_no,sn_ckk,sn_no,install_place,with_pr,type_type,type_detail,delivery_type,delivery_date,delivery_time,delivery_address,delivery_contact,delivery_tel,sale_date,sale,sale_code,pr_no,add_date,add_by,status_doc,approve,approve_code,approve_date,payment_des,slip1,slip2,slip3,slip4,slip5,date_send_key,have_order,send_sup,iv_no,iv_date,iv_time,job_no,job_no2,sr_no,dep_no,order_no,payment2,tax_id,approve_time,bill_id,admin,admin_code,admin_date,cm_no,pre_name,que_ckk,mode_cus,plan_ckk,email,adm_ckk,ic_ckk,et_ckk,repeat_cus)
	values
	('" . $ref_id . "','" . $type_doc . "','" . $bill_name . "','" . $bill_address . "','" . $bill_tel . "','" . $full_bill . "','" . $date_so . "','" . $suggest . "','" . $payment . "','" . $payment_method . "','" . $sale_comment . "','" . $po_no . "','" . $delivery_contract . "','" . $book_clear . "','" . $book_no . "','" . $brn_clear . "','" . $brn_no . "','" . $brnp_clear . "','" . $brnp_no . "','" . $sn_ckk . "','" . $sn_no . "','" . $install_place . "','" . $with_pr . "','" . $type_type . "','" . $type_detail . "','" . $delivery_type . "','" . $delivery_date . "','" . $delivery_time . "','" . $delivery_address . "','" . $delivery_contact . "','" . $delivery_tel . "','" . $sale_date . "','" . $sale . "','" . $sale_code . "','" . $pr_no . "','" . $add_date . "','" . $add_by . "','" . $statusDoc . "','" . $approveValue . "','" . $approveCodeValue . "','" . $approveDateValue . "','" . $payment_des . "','" . $slip1 . "','" . $slip2 . "','" . $slip3 . "','" . $slip4 . "','" . $slip5 . "','" . $date_send_key . "','" . $have_order . "','" . $sendSup . "','" . $iv_no . "','" . $ivDateValue . "','" . $ivTimeValue . "','" . $job_no . "','" . $job_no2 . "','" . $sr_no . "','" . $dep_no . "','" . $order_no . "','" . $payment2 . "','" . $tax_id . "','" . $approveTimeValue . "','" . $bill_id . "','" . $admin . "','" . $admin_code . "','" . $admin_date . "','" . $cm_no . "','" . $pre_name . "','" . $que_ckk . "','" . $mode_cus . "','" . $plan_ckk . "','" . $email . "','" . $adm_ckk . "','" . $ic_ckk . "','" . $et_ckk . "','" . $repeat_cus . "')";

	$qsave = mysqli_query($conn, $save);

	function updateHosSoColumnIfExists($conn, $ref_id, $column, $value)
	{
		if ($value === null || $value === '') {
			return;
		}

		$safeColumn = mysqli_real_escape_string($conn, $column);
		$columnCheck = mysqli_query($conn, "SHOW COLUMNS FROM hos__so LIKE '" . $safeColumn . "'");
		if (!$columnCheck || mysqli_num_rows($columnCheck) == 0) {
			return;
		}

		$safeValue = mysqli_real_escape_string($conn, $value);
		$safeRefId = mysqli_real_escape_string($conn, $ref_id);
		mysqli_query($conn, "UPDATE hos__so SET " . $safeColumn . " = '" . $safeValue . "' WHERE ref_id = '" . $safeRefId . "'");
	}

	function normalizeOptionalDateValue($value)
	{
		$value = trim($value);
		if (preg_match('/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/', $value, $matches)) {
			$year = (int)$matches[3];
			if ($year > 2400) {
				$year -= 543;
			}
			return sprintf('%04d-%02d-%02d', $year, (int)$matches[2], (int)$matches[1]);
		}
		return $value;
	}

	$optionalHosSoFieldMap = array(
		'admin_doc_no' => 'iv_no',
		'admin_work_no' => 'job_no',
		'admin_sr_no' => 'sr_no',
		'admin_deposit_no' => 'order_no',
		'admin_doc_date' => 'iv_date',
		'admin_edit_count' => 'new_bill',
		'admin_old_doc_date' => 'date_oldbill',
		'admin_edit_reason' => 'desnew_bill',
		'admin_cancel_reason' => 'remark_cancel',
		'shipping_date' => 'date_ker',
		'shipping_ref1' => 'order_refer_code',
		'shipping_ref2' => 'order_refer_code1',
		'shipping_cost' => 'ker_bath',
		'transport_company' => 'transport_company'
	);

	foreach ($optionalHosSoFieldMap as $postField => $columnName) {
		if (isset($_POST[$postField])) {
			$optionalValue = $_POST[$postField];
			if ($postField === 'admin_edit_count') {
				$optionalValue = $admin_edit_count;
			}
			if ($postField === 'admin_doc_date' || $postField === 'admin_old_doc_date') {
				$optionalValue = normalizeOptionalDateValue($optionalValue);
			}
			updateHosSoColumnIfExists($conn, $ref_id, $columnName, $optionalValue);
		}
	}


	$save56 = "insert into tb_other_bill
(ref_id,head_1,ref_1,ref_2,ref_3,ref_4,ref_5,ref_6,ref_7,ref_8,ref_9,ref_10,ref_11,ref_des,ref_12,ref_13)
values
('" . $ref_id . "','" . $head_1 . "','" . $ref_1 . "','" . $ref_2 . "','" . $ref_3 . "','" . $ref_4 . "','" . $ref_5 . "','" . $ref_6 . "','" . $ref_7 . "','" . $ref_8 . "','" . $ref_9 . "','" . $ref_10 . "','" . $ref_11 . "','" . $ref_des . "','" . $ref_12 . "','" . $ref_13 . "')";
	$qsave56 = mysqli_query($conn, $save56);


	$save57 = "insert into tb_comment_so (ref_id,comment_cs,comment_en,comment_st,comment_ad,technician_required) values ('" . $ref_id . "','" . $comment_cs . "','" . $comment_en . "','" . $comment_st . "','" . $comment_ad . "','" . $technician_required . "')";
	$qsave57 = mysqli_query($conn, $save57);
	if ($qsave57) {
		saveDeptCommentItems($conn, mysqli_insert_id($conn), $ref_id, $deptCommentItems);
	}



	if ($book_no != '') {

		$strSQL = "SELECT ref_id FROM hos__jongproduct WHERE iv_no = '" . $book_no . "' ";
		$objQuery = mysqli_query($conn, $strSQL) or die(mysqli_error());
		$objResult = mysqli_fetch_array($objQuery);

		$remark_jong = "เปิดใบสั่งขายเลขที่อ้างอิง $ref_id";

		$save2 = "UPDATE  hos__jongproduct SET close_jong='1',remark='" . $remark_jong . "'  where ref_id = '" . $objResult["ref_id"] . "'";
		$qsave2 = mysqli_query($conn, $save2);

		$save3 = "UPDATE hos__subjongpro SET close_ckk='1'  where ref_idd = '" . $objResult["ref_id"] . "'";
		$qsave3 = mysqli_query($conn, $save3);
	}


	/*if($book_clear=='1'){
		
$save="Update  hos__jongproduct set  close_jong = '1'    where  iv_no LIKE '%".$book_no."%'";
$qsave=mysqli_query($conn,$save);
			
	}	*/
	if ($po_no != '') {
		$sql1 = "SELECT ref_id FROM hos__po where po_no ='" . $po_no . "'";
		$qry1 = mysqli_query($conn, $sql1) or die(mysqli_error());
		$rs1 = mysqli_fetch_assoc($qry1);

		if ($rs1["ref_id"] != "") {

			$save = "Update  hos__po set  open_so='1',open_sodate='" . $add_date . "',ref_so = '" . $ref_id . "',name_open='" . $add_by . "'    where  ref_id = '" . $rs1["ref_id"] . "'";
			$qsave = mysqli_query($conn, $save);
		}
	}



	$product_id1 = $_POST["product_id1"];
	$product_name1 = $_POST["product_name1"];
	$unit_name1 = $_POST["unit_name1"];
	$sale_count1 = $_POST["sale_count1"];
	$product_price1 = $_POST["product_price1"];
	$sale_remarkk1 = $_POST["sale_remarkk1"];
	$sum_amountt = $_POST["sum_amount1"];
	$sum_amount1 = str_replace(',', '', $sum_amountt);
	$discount_unit1 = $_POST["discount_unit1"];
	$warranty1  = $_POST["warranty1"];
	$cal1 = $_POST["cal1"];
	$pm1 = $_POST["pm1"];

	$clear_br1 = $_POST["clear_br1"];
	$clear_br2 = $_POST["clear_br2"];
	$clear_br3 = $_POST["clear_br3"];
	$clear_br4 = $_POST["clear_br4"];
	$clear_br5 = $_POST["clear_br5"];
	$clear_br6 = $_POST["clear_br6"];
	$clear_br7 = $_POST["clear_br7"];
	$clear_br8 = $_POST["clear_br8"];
	$clear_br9 = $_POST["clear_br9"];
	$clear_br10 = $_POST["clear_br10"];
	$clear_br11 = $_POST["clear_br11"];
	$clear_br12 = $_POST["clear_br12"];
	$clear_br13 = $_POST["clear_br13"];
	$clear_br14 = $_POST["clear_br14"];
	$clear_br15 = $_POST["clear_br15"];


	$clear_ivno1 = $_POST["clear_ivno1"];
	$clear_ivno2 = $_POST["clear_ivno2"];
	$clear_ivno3 = $_POST["clear_ivno3"];
	$clear_ivno4 = $_POST["clear_ivno4"];
	$clear_ivno5 = $_POST["clear_ivno5"];
	$clear_ivno6 = $_POST["clear_ivno6"];
	$clear_ivno7 = $_POST["clear_ivno7"];
	$clear_ivno8 = $_POST["clear_ivno8"];
	$clear_ivno9 = $_POST["clear_ivno9"];
	$clear_ivno10 = $_POST["clear_ivno10"];
	$clear_ivno11 = $_POST["clear_ivno11"];
	$clear_ivno12 = $_POST["clear_ivno12"];
	$clear_ivno13 = $_POST["clear_ivno13"];
	$clear_ivno14 = $_POST["clear_ivno14"];
	$clear_ivno15 = $_POST["clear_ivno15"];



	$jong_ckk1 = $_POST["jong_ckk1"];
	$jong_ckk2 = $_POST["jong_ckk2"];
	$jong_ckk3 = $_POST["jong_ckk3"];
	$jong_ckk4 = $_POST["jong_ckk4"];
	$jong_ckk5 = $_POST["jong_ckk5"];
	$jong_ckk6 = $_POST["jong_ckk6"];
	$jong_ckk7 = $_POST["jong_ckk7"];
	$jong_ckk8 = $_POST["jong_ckk8"];
	$jong_ckk9 = $_POST["jong_ckk9"];
	$jong_ckk10 = $_POST["jong_ckk10"];
	$jong_ckk11 = $_POST["jong_ckk11"];
	$jong_ckk12 = $_POST["jong_ckk12"];
	$jong_ckk13 = $_POST["jong_ckk13"];
	$jong_ckk14 = $_POST["jong_ckk14"];
	$jong_ckk15 = $_POST["jong_ckk15"];

	$jong_no1 = $_POST["jong_no1"];
	$jong_no2 = $_POST["jong_no2"];
	$jong_no3 = $_POST["jong_no3"];
	$jong_no4 = $_POST["jong_no4"];
	$jong_no5 = $_POST["jong_no5"];
	$jong_no6 = $_POST["jong_no6"];
	$jong_no7 = $_POST["jong_no7"];
	$jong_no8 = $_POST["jong_no8"];
	$jong_no9 = $_POST["jong_no9"];
	$jong_no10 = $_POST["jong_no10"];
	$jong_no11 = $_POST["jong_no11"];
	$jong_no12 = $_POST["jong_no12"];
	$jong_no13 = $_POST["jong_no13"];
	$jong_no14 = $_POST["jong_no14"];
	$jong_no15 = $_POST["jong_no15"];



	if ($_POST["product_code1"] != '') {
		$product_code1 = $_POST["product_code1"];
	} else if ($_POST["product_codet1"] != '') {
		$product_code1 = $_POST["product_codet1"];
	} else {
		$product_code1 = $_POST["product_c1"];
	}



	$product_name2 = $_POST["product_name2"];
	$unit_name2 = $_POST["unit_name2"];
	$product_id2 = $_POST["product_id2"];
	$sale_count2 = $_POST["sale_count2"];
	$product_price2 = $_POST["product_price2"];
	$sale_remarkk2 = $_POST["sale_remarkk2"];
	$sum_amountt2 = $_POST["sum_amount2"];
	$sum_amount2 = str_replace(',', '', $sum_amountt2);
	$discount_unit2 = $_POST["discount_unit2"];
	$warranty2  = $_POST["warranty2"];
	$cal2 = $_POST["cal2"];
	$pm2 = $_POST["pm2"];

	if ($_POST["product_code2"] != '') {
		$product_code2 = $_POST["product_code2"];
	} else if ($_POST["product_codet2"] != '') {
		$product_code2 = $_POST["product_codet2"];
	} else {
		$product_code2 = $_POST["product_c2"];
	}



	$product_name3 = $_POST["product_name3"];
	$unit_name3 = $_POST["unit_name3"];
	$product_id3 = $_POST["product_id3"];
	$sale_count3 = $_POST["sale_count3"];
	$product_price3 = $_POST["product_price3"];
	$sale_remarkk3 = $_POST["sale_remarkk3"];
	$sum_amountt3 = $_POST["sum_amount3"];
	$sum_amount3 = str_replace(',', '', $sum_amountt3);
	$discount_unit3 = $_POST["discount_unit3"];
	$warranty3  = $_POST["warranty3"];
	$cal3 = $_POST["cal3"];
	$pm3 = $_POST["pm3"];

	if ($_POST["product_code3"] != '') {
		$product_code3 = $_POST["product_code3"];
	} else if ($_POST["product_codet3"] != '') {
		$product_code3 = $_POST["product_codet3"];
	} else {
		$product_code3 = $_POST["product_c3"];
	}


	$product_name4 = $_POST["product_name4"];
	$unit_name4 = $_POST["unit_name4"];
	$product_id4 = $_POST["product_id4"];
	$sale_count4 = $_POST["sale_count4"];
	$product_price4 = $_POST["product_price4"];
	$sale_remarkk4 = $_POST["sale_remarkk4"];
	$sum_amountt4 = $_POST["sum_amount4"];
	$sum_amount4 = str_replace(',', '', $sum_amountt4);
	$discount_unit4 = $_POST["discount_unit4"];
	$warranty4  = $_POST["warranty4"];
	$cal4 = $_POST["cal4"];
	$pm4 = $_POST["pm4"];

	if ($_POST["product_code4"] != '') {
		$product_code4 = $_POST["product_code4"];
	} else if ($_POST["product_codet4"] != '') {
		$product_code4 = $_POST["product_codet4"];
	} else {
		$product_code4 = $_POST["product_c4"];
	}


	$product_name5 = $_POST["product_name5"];
	$unit_name5 = $_POST["unit_name5"];
	$product_id5 = $_POST["product_id5"];
	$sale_count5 = $_POST["sale_count5"];
	$product_price5 = $_POST["product_price5"];
	$sale_remarkk5 = $_POST["sale_remarkk5"];
	$sum_amountt5 = $_POST["sum_amount5"];
	$sum_amount5 = str_replace(',', '', $sum_amountt5);
	$discount_unit5 = $_POST["discount_unit5"];
	$warranty5  = $_POST["warranty5"];
	$cal5 = $_POST["cal5"];
	$pm5 = $_POST["pm5"];

	if ($_POST["product_code5"] != '') {
		$product_code5 = $_POST["product_code5"];
	} else if ($_POST["product_codet5"] != '') {
		$product_code5 = $_POST["product_codet5"];
	} else {
		$product_code5 = $_POST["product_c5"];
	}


	$product_name6 = $_POST["product_name6"];
	$unit_name6 = $_POST["unit_name6"];
	$product_id6 = $_POST["product_id6"];
	$sale_count6 = $_POST["sale_count6"];
	$product_price6 = $_POST["product_price6"];
	$sale_remarkk6 = $_POST["sale_remarkk6"];
	$sum_amountt6 = $_POST["sum_amount6"];
	$sum_amount6 = str_replace(',', '', $sum_amountt6);
	$discount_unit6 = $_POST["discount_unit6"];
	$warranty6  = $_POST["warranty6"];
	$cal6 = $_POST["cal6"];
	$pm6 = $_POST["pm6"];

	if ($_POST["product_code6"] != '') {
		$product_code6 = $_POST["product_code6"];
	} else if ($_POST["product_codet6"] != '') {
		$product_code6 = $_POST["product_codet6"];
	} else {
		$product_code6 = $_POST["product_c6"];
	}


	$product_name7 = $_POST["product_name7"];
	$unit_name7 = $_POST["unit_name7"];
	$product_id7 = $_POST["product_id7"];
	$sale_count7 = $_POST["sale_count7"];
	$product_price7 = $_POST["product_price7"];
	$sale_remarkk7 = $_POST["sale_remarkk7"];
	$sum_amountt7 = $_POST["sum_amount7"];
	$sum_amount7 = str_replace(',', '', $sum_amountt7);
	$discount_unit7 = $_POST["discount_unit7"];
	$warranty7  = $_POST["warranty7"];
	$cal7 = $_POST["cal7"];
	$pm7 = $_POST["pm7"];

	if ($_POST["product_code7"] != '') {
		$product_code7 = $_POST["product_code7"];
	} else if ($_POST["product_codet7"] != '') {
		$product_code7 = $_POST["product_codet7"];
	} else {
		$product_code7 = $_POST["product_c7"];
	}

	$product_id8 = $_POST["product_id8"];
	$sale_count8 = $_POST["sale_count8"];
	$product_price8 = $_POST["product_price8"];
	$sale_remarkk8 = $_POST["sale_remarkk8"];
	$sum_amountt8 = $_POST["sum_amount8"];
	$sum_amount8 = str_replace(',', '', $sum_amountt8);
	$discount_unit8 = $_POST["discount_unit8"];
	$warranty8  = $_POST["warranty8"];
	$cal8 = $_POST["cal8"];
	$pm8 = $_POST["pm8"];
	if ($_POST["product_code8"] != '') {
		$product_code8 = $_POST["product_code8"];
	} else if ($_POST["product_codet8"] != '') {
		$product_code8 = $_POST["product_codet8"];
	} else {
		$product_code8 = $_POST["product_c8"];
	}


	$product_id9 = $_POST["product_id9"];
	$sale_count9 = $_POST["sale_count9"];
	$product_price9 = $_POST["product_price9"];
	$sale_remarkk9 = $_POST["sale_remarkk9"];
	$sum_amountt9 = $_POST["sum_amount9"];
	$sum_amount9 = str_replace(',', '', $sum_amountt9);
	$discount_unit9 = $_POST["discount_unit9"];
	$warranty9  = $_POST["warranty9"];
	$cal9 = $_POST["cal9"];
	$pm9 = $_POST["pm9"];
	if ($_POST["product_code9"] != '') {
		$product_code9 = $_POST["product_code9"];
	} else if ($_POST["product_codet9"] != '') {
		$product_code9 = $_POST["product_codet9"];
	} else {
		$product_code9 = $_POST["product_c9"];
	}

	$product_id10 = $_POST["product_id10"];
	$sale_count10 = $_POST["sale_count10"];
	$product_price10 = $_POST["product_price10"];
	$sale_remarkk10 = $_POST["sale_remarkk10"];
	$sum_amountt10 = $_POST["sum_amount10"];
	$sum_amount10 = str_replace(',', '', $sum_amountt10);
	$discount_unit10 = $_POST["discount_unit10"];
	$warranty10  = $_POST["warranty10"];
	$cal10 = $_POST["cal10"];
	$pm10 = $_POST["pm10"];

	if ($_POST["product_code10"] != '') {
		$product_code10 = $_POST["product_code10"];
	} else if ($_POST["product_codet10"] != '') {
		$product_code10 = $_POST["product_codet10"];
	} else {
		$product_code10 = $_POST["product_c10"];
	}


	$product_id11 = $_POST["product_id11"];
	$sale_count11 = $_POST["sale_count11"];
	$product_price11 = $_POST["product_price11"];
	$sale_remarkk11 = $_POST["sale_remarkk11"];
	$sum_amountt11 = $_POST["sum_amount11"];
	$sum_amount11 = str_replace(',', '', $sum_amountt11);
	$discount_unit11 = $_POST["discount_unit11"];
	$warranty11  = $_POST["warranty11"];
	$cal11 = $_POST["cal11"];
	$pm11 = $_POST["pm11"];

	if ($_POST["product_code11"] != '') {
		$product_code11 = $_POST["product_code11"];
	} else if ($_POST["product_codet11"] != '') {
		$product_code11 = $_POST["product_codet11"];
	} else {
		$product_code11 = $_POST["product_c11"];
	}

	$product_id12 = $_POST["product_id12"];
	$sale_count12 = $_POST["sale_count12"];
	$product_price12 = $_POST["product_price12"];
	$sale_remarkk12 = $_POST["sale_remarkk12"];
	$sum_amountt12 = $_POST["sum_amount12"];
	$sum_amount12 = str_replace(',', '', $sum_amountt12);
	$discount_unit12 = $_POST["discount_unit12"];
	$warranty12  = $_POST["warranty12"];
	$cal12 = $_POST["cal12"];
	$pm12 = $_POST["pm12"];

	if ($_POST["product_code12"] != '') {
		$product_code12 = $_POST["product_code12"];
	} else if ($_POST["product_codet12"] != '') {
		$product_code12 = $_POST["product_codet12"];
	} else {
		$product_code12 = $_POST["product_c12"];
	}

	$product_id13 = $_POST["product_id13"];
	$sale_count13 = $_POST["sale_count13"];
	$product_price13 = $_POST["product_price13"];
	$sale_remarkk13 = $_POST["sale_remarkk13"];
	$sum_amountt13 = $_POST["sum_amount13"];
	$sum_amount13 = str_replace(',', '', $sum_amountt13);
	$discount_unit13 = $_POST["discount_unit13"];
	$warranty13  = $_POST["warranty13"];
	$cal13 = $_POST["cal13"];
	$pm13 = $_POST["pm13"];

	if ($_POST["product_code13"] != '') {
		$product_code13 = $_POST["product_code13"];
	} else if ($_POST["product_codet13"] != '') {
		$product_code13 = $_POST["product_codet13"];
	} else {
		$product_code13 = $_POST["product_c13"];
	}


	$product_id14 = $_POST["product_id14"];
	$sale_count14 = $_POST["sale_count14"];
	$product_price14 = $_POST["product_price14"];
	$sale_remarkk14 = $_POST["sale_remarkk14"];
	$sum_amountt14 = $_POST["sum_amount14"];
	$sum_amount14 = str_replace(',', '', $sum_amountt14);
	$discount_unit14 = $_POST["discount_unit14"];
	$warranty14  = $_POST["warranty14"];
	$cal14 = $_POST["cal14"];
	$pm14 = $_POST["pm14"];

	if ($_POST["product_code14"] != '') {
		$product_code14 = $_POST["product_code14"];
	} else if ($_POST["product_codet14"] != '') {
		$product_code14 = $_POST["product_codet14"];
	} else {
		$product_code14 = $_POST["product_c14"];
	}


	$product_id15 = $_POST["product_id15"];
	$sale_count15 = $_POST["sale_count15"];
	$product_price15 = $_POST["product_price15"];
	$sale_remarkk15 = $_POST["sale_remarkk15"];
	$sum_amountt15 = $_POST["sum_amount15"];
	$sum_amount15 = str_replace(',', '', $sum_amountt15);
	$discount_unit15 = $_POST["discount_unit15"];
	$warranty15  = $_POST["warranty15"];
	$cal15 = $_POST["cal15"];
	$pm15 = $_POST["pm15"];

	if ($_POST["product_code15"] != '') {
		$product_code15 = $_POST["product_code15"];
	} else if ($_POST["product_codet15"] != '') {
		$product_code15 = $_POST["product_codet15"];
	} else {
		$product_code15 = $_POST["product_c15"];
	}


	$product_id16 = $_POST["product_id16"];
	$sale_count16 = $_POST["sale_count16"];
	$product_price16 = $_POST["product_price16"];
	$sale_remarkk16 = $_POST["sale_remarkk16"];
	$sum_amountt16 = $_POST["sum_amount16"];
	$sum_amount16 = str_replace(',', '', $sum_amountt16);
	$discount_unit16 = $_POST["discount_unit16"];
	$warranty16  = $_POST["warranty16"];
	$cal16 = $_POST["cal16"];
	$pm16 = $_POST["pm16"];




	$product_id17 = $_POST["product_id17"];
	$sale_count17 = $_POST["sale_count17"];
	$product_price17 = $_POST["product_price17"];
	$sale_remarkk17 = $_POST["sale_remarkk17"];
	$sum_amountt17 = $_POST["sum_amount17"];
	$sum_amount17 = str_replace(',', '', $sum_amountt17);
	$discount_unit17 = $_POST["discount_unit17"];
	$warranty17  = $_POST["warranty17"];
	$cal17 = $_POST["cal17"];
	$pm17 = $_POST["pm17"];


	$product_id18 = $_POST["product_id18"];
	$sale_count18 = $_POST["sale_count18"];
	$product_price18 = $_POST["product_price18"];
	$sale_remarkk18 = $_POST["sale_remarkk18"];
	$sum_amountt18 = $_POST["sum_amount18"];
	$sum_amount18 = str_replace(',', '', $sum_amountt18);
	$discount_unit18 = $_POST["discount_unit18"];
	$warranty18  = $_POST["warranty18"];
	$cal18 = $_POST["cal18"];
	$pm18 = $_POST["pm18"];


	$product_id19 = $_POST["product_id19"];
	$sale_count19 = $_POST["sale_count19"];
	$product_price19 = $_POST["product_price19"];
	$sale_remarkk19 = $_POST["sale_remarkk19"];
	$sum_amountt19 = $_POST["sum_amount19"];
	$sum_amount19 = str_replace(',', '', $sum_amountt19);
	$discount_unit19 = $_POST["discount_unit19"];
	$warranty19  = $_POST["warranty19"];
	$cal19 = $_POST["cal19"];
	$pm19 = $_POST["pm19"];




	$product_id20 = $_POST["product_id20"];
	$sale_count20 = $_POST["sale_count20"];
	$product_price20 = $_POST["product_price20"];
	$sale_remarkk20 = $_POST["sale_remarkk20"];
	$sum_amountt20 = $_POST["sum_amount20"];
	$sum_amount20 = str_replace(',', '', $sum_amountt20);
	$discount_unit20 = $_POST["discount_unit20"];
	$warranty20  = $_POST["warranty20"];
	$cal20 = $_POST["cal20"];
	$pm20 = $_POST["pm20"];


	$product_id21 = $_POST["product_id21"];
	$sale_count21 = $_POST["sale_count21"];
	$product_price21 = $_POST["product_price21"];
	$sale_remarkk21 = $_POST["sale_remarkk21"];
	$sum_amountt21 = $_POST["sum_amount21"];
	$sum_amount21 = str_replace(',', '', $sum_amountt21);
	$discount_unit21 = $_POST["discount_unit21"];
	$warranty21  = $_POST["warranty21"];
	$cal21 = $_POST["cal21"];
	$pm21 = $_POST["pm21"];


	$product_id22 = $_POST["product_id22"];
	$sale_count22 = $_POST["sale_count22"];
	$product_price22 = $_POST["product_price22"];
	$sale_remarkk22 = $_POST["sale_remarkk22"];
	$sum_amountt22 = $_POST["sum_amount22"];
	$sum_amount22 = str_replace(',', '', $sum_amountt22);
	$discount_unit22 = $_POST["discount_unit22"];
	$warranty22  = $_POST["warranty22"];
	$cal22 = $_POST["cal22"];
	$pm22 = $_POST["pm22"];


	$product_id23 = $_POST["product_id23"];
	$sale_count23 = $_POST["sale_count23"];
	$product_price23 = $_POST["product_price23"];
	$sale_remarkk23 = $_POST["sale_remarkk23"];
	$sum_amountt23 = $_POST["sum_amount23"];
	$sum_amount23 = str_replace(',', '', $sum_amountt23);
	$discount_unit23 = $_POST["discount_unit23"];
	$warranty23  = $_POST["warranty23"];
	$cal23 = $_POST["cal23"];
	$pm23 = $_POST["pm23"];



	$product_id24 = $_POST["product_id24"];
	$sale_count24 = $_POST["sale_count24"];
	$product_price24 = $_POST["product_price24"];
	$sale_remarkk24 = $_POST["sale_remarkk24"];
	$sum_amountt24 = $_POST["sum_amount24"];
	$sum_amount24 = str_replace(',', '', $sum_amountt24);
	$discount_unit24 = $_POST["discount_unit24"];
	$warranty24  = $_POST["warranty24"];
	$cal24 = $_POST["cal24"];
	$pm24 = $_POST["pm24"];


	$product_id25 = $_POST["product_id25"];
	$sale_count25 = $_POST["sale_count25"];
	$product_price25 = $_POST["product_price25"];
	$sale_remarkk25 = $_POST["sale_remarkk25"];
	$sum_amountt25 = $_POST["sum_amount25"];
	$sum_amount25 = str_replace(',', '', $sum_amountt25);
	$discount_unit25 = $_POST["discount_unit25"];
	$warranty25  = $_POST["warranty25"];
	$cal25 = $_POST["cal25"];
	$pm25 = $_POST["pm25"];



	$product_id26 = $_POST["product_id26"];
	$sale_count26 = $_POST["sale_count26"];
	$product_price26 = $_POST["product_price26"];
	$sale_remarkk26 = $_POST["sale_remarkk26"];
	$sum_amountt26 = $_POST["sum_amount26"];
	$sum_amount26 = str_replace(',', '', $sum_amountt26);
	$discount_unit26 = $_POST["discount_unit26"];
	$warranty26  = $_POST["warranty26"];
	$cal26 = $_POST["cal26"];
	$pm26 = $_POST["pm26"];


	$product_id27 = $_POST["product_id27"];
	$sale_count27 = $_POST["sale_count27"];
	$product_price27 = $_POST["product_price27"];
	$sale_remarkk27 = $_POST["sale_remarkk27"];
	$sum_amountt27 = $_POST["sum_amount27"];
	$sum_amount27 = str_replace(',', '', $sum_amountt27);
	$discount_unit27 = $_POST["discount_unit27"];
	$warranty27  = $_POST["warranty27"];
	$cal27 = $_POST["cal27"];
	$pm27 = $_POST["pm27"];


	$product_id28 = $_POST["product_id28"];
	$sale_count28 = $_POST["sale_count28"];
	$product_price28 = $_POST["product_price28"];
	$sale_remarkk28 = $_POST["sale_remarkk28"];
	$sum_amountt28 = $_POST["sum_amount28"];
	$sum_amount28 = str_replace(',', '', $sum_amountt28);
	$discount_unit28 = $_POST["discount_unit28"];
	$warranty28  = $_POST["warranty28"];
	$cal28 = $_POST["cal28"];
	$pm28 = $_POST["pm28"];


	$product_id29 = $_POST["product_id29"];
	$sale_count29 = $_POST["sale_count29"];
	$product_price29 = $_POST["product_price29"];
	$sale_remarkk29 = $_POST["sale_remarkk29"];
	$sum_amountt29 = $_POST["sum_amount29"];
	$sum_amount29 = str_replace(',', '', $sum_amountt29);
	$discount_unit29 = $_POST["discount_unit29"];
	$warranty29  = $_POST["warranty29"];
	$cal29 = $_POST["cal29"];
	$pm29 = $_POST["pm29"];


	$product_id30 = $_POST["product_id30"];
	$sale_count30 = $_POST["sale_count30"];
	$product_price30 = $_POST["product_price30"];
	$sale_remarkk30 = $_POST["sale_remarkk30"];
	$sum_amountt30 = $_POST["sum_amount30"];
	$sum_amount30 = str_replace(',', '', $sum_amountt30);
	$discount_unit30 = $_POST["discount_unit30"];
	$warranty30  = $_POST["warranty30"];
	$cal30 = $_POST["cal30"];
	$pm30 = $_POST["pm30"];




	//แถวที่ 1


	if ($product_id1 != '') {

		$strSQL31 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '" . $product_code1 . "' ";
		$objQuery31 = mysqli_query($conn, $strSQL31) or die("Error Query [" . $strSQL31 . "]");
		$Num_Rows31 = mysqli_num_rows($objQuery31);
		$objResult31 = mysqli_fetch_array($objQuery31);

		$product_idb1 = $objResult31["product_id1"];
		$product_idb2 = $objResult31["product_id2"];
		$product_idb3 = $objResult31["product_id3"];
		$product_idb4 = $objResult31["product_id4"];
		$product_idb5 = $objResult31["product_id5"];
		$product_idb6 = $objResult31["product_id6"];
		$product_idb7 = $objResult31["product_id7"];
		$product_idb8 = $objResult31["product_id8"];
		$product_idb9 = $objResult31["product_id9"];
		$product_idb10 = $objResult31["product_id10"];


		$unit1 = $sale_count1 * $objResult31["unit1"];
		$unit2 = $sale_count1 * $objResult31["unit2"];
		$unit3 = $sale_count1 * $objResult31["unit3"];
		$unit4 = $sale_count1 * $objResult31["unit4"];
		$unit5 = $sale_count1 * $objResult31["unit5"];
		$unit6 = $sale_count1 * $objResult31["unit6"];
		$unit7 = $sale_count1 * $objResult31["unit7"];
		$unit8 = $sale_count1 * $objResult31["unit8"];
		$unit9 = $sale_count1 * $objResult31["unit9"];
		$unit10 = $sale_count1 * $objResult31["unit10"];

		if ($Num_Rows31 > 0) {

			if ($product_idb1 != '') {

				$strSQL104 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,code_bom,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit1 . "','" . $unit1 . "','" . $product_price1 . "','" . $product_price1 . "','" . $sum_amount1 . "','" . $sale_remarkk1 . "','" . $discount_unit1 . "','" . $warranty1 . "','" . $cal1 . "','" . $pm1 . "','" . $product_idb1 . "','" . $product_idb1 . "','" . $product_code1 . "','1','" . $product_code1 . "','" . $have_order . "','" . $clear_br1 . "','" . $clear_ivno1 . "','" . $jong_no1 . "','" . $jong_ckk1 . "')";

				$objQuery104 = mysqli_query($conn, $strSQL104);
			}

			if ($product_idb2 != '') {

				$strSQL100 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit2 . "','" . $unit2 . "','0.00','0.00','0.00','" . $sale_remarkk1 . "','0.00','0','0','0','" . $product_idb2 . "','" . $product_idb2 . "','1','" . $product_code1 . "','" . $have_order . "','" . $clear_br1 . "','" . $clear_ivno1 . "','" . $jong_no1 . "','" . $jong_ckk1 . "')";
				$objQuery100 = mysqli_query($conn, $strSQL100);
			}

			if ($product_idb3 != '') {

				$strSQL101 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit3 . "','" . $unit3 . "','0.00','0.00','0.00','" . $sale_remarkk1 . "','0.00','0','0','0','" . $product_idb3 . "','" . $product_idb3 . "','1','" . $product_code1 . "','" . $have_order . "','" . $clear_br1 . "','" . $clear_ivno1 . "','" . $jong_no1 . "','" . $jong_ckk1 . "')";

				$objQuery101 = mysqli_query($conn, $strSQL101);
			}

			if ($product_idb4 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit4 . "','" . $unit4 . "','0.00','0.00','0.00','" . $sale_remarkk1 . "','0.00','0','0','0','" . $product_idb4 . "','" . $product_idb4 . "','1','" . $product_code1 . "','" . $have_order . "','" . $clear_br1 . "','" . $clear_ivno1 . "','" . $jong_no1 . "','" . $jong_ckk1 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb5 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit5 . "','" . $unit5 . "','0.00','0.00','0.00','" . $sale_remarkk1 . "','0.00','0','0','0','" . $product_idb5 . "','" . $product_idb5 . "','1','" . $product_code1 . "','" . $have_order . "','" . $clear_br1 . "','" . $clear_ivno1 . "','" . $jong_no1 . "','" . $jong_ckk1 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb6 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit6 . "','" . $unit6 . "','0.00','0.00','0.00','" . $sale_remarkk1 . "','0.00','0','0','0','" . $product_idb6 . "','" . $product_idb6 . "','1','" . $product_code1 . "','" . $have_order . "','" . $clear_br1 . "','" . $clear_ivno1 . "','" . $jong_no1 . "','" . $jong_ckk1 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb7 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit7 . "','" . $unit7 . "','0.00','0.00','0.00','" . $sale_remarkk1 . "','0.00','0','0','0','" . $product_idb7 . "','" . $product_idb7 . "','1','" . $product_code1 . "','" . $have_order . "','" . $clear_br1 . "','" . $clear_ivno1 . "','" . $jong_no1 . "','" . $jong_ckk1 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb8 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit8 . "','" . $unit8 . "','0.00','0.00','0.00','" . $sale_remarkk1 . "','0.00','0','0','0','" . $product_idb8 . "','" . $product_idb8 . "','1','" . $product_code1 . "','" . $have_order . "','" . $clear_br1 . "','" . $clear_ivno1 . "','" . $jong_no1 . "','" . $jong_ckk1 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb9 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit9 . "','" . $unit9 . "','0.00','0.00','0.00','" . $sale_remarkk1 . "','0.00','0','0','0','" . $product_idb9 . "','" . $product_idb9 . "','1','" . $product_code1 . "','" . $have_order . "','" . $clear_br1 . "','" . $clear_ivno1 . "','" . $jong_no1 . "','" . $jong_ckk1 . "')";
				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb10 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit10 . "','" . $unit10 . "','0.00','0.00','0.00','" . $sale_remarkk1 . "','0.00','0','0','0','" . $product_idb10 . "','" . $product_idb10 . "','1','" . $product_code1 . "','" . $have_order . "','" . $clear_br1 . "','" . $clear_ivno1 . "','" . $jong_no1 . "','" . $jong_ckk1 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}
		} else {

			$strSQL1 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $sale_count1 . "','" . $sale_count1 . "','" . $product_price1 . "','" . $product_price1 . "','" . $sum_amount1 . "','" . $sale_remarkk1 . "','" . $discount_unit1 . "','" . $warranty1 . "','" . $cal1 . "','" . $pm1 . "','" . $product_id1 . "','" . $product_id1 . "','" . $have_order . "','" . $clear_br1 . "','" . $clear_ivno1 . "','" . $jong_no1 . "','" . $jong_ckk1 . "')";

			$objQuery1 = mysqli_query($conn, $strSQL1);
		}
	}





	//แถวที่ 2

	if ($product_id2 != '') {

		$strSQL31 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '" . $product_code2 . "' ";
		$objQuery31 = mysqli_query($conn, $strSQL31) or die("Error Query [" . $strSQL31 . "]");
		$Num_Rows31 = mysqli_num_rows($objQuery31);
		$objResult31 = mysqli_fetch_array($objQuery31);

		$product_idb1 = $objResult31["product_id1"];
		$product_idb2 = $objResult31["product_id2"];
		$product_idb3 = $objResult31["product_id3"];
		$product_idb4 = $objResult31["product_id4"];
		$product_idb5 = $objResult31["product_id5"];
		$product_idb6 = $objResult31["product_id6"];
		$product_idb7 = $objResult31["product_id7"];
		$product_idb8 = $objResult31["product_id8"];
		$product_idb9 = $objResult31["product_id9"];
		$product_idb10 = $objResult31["product_id10"];


		$unit1 = $sale_count2 * $objResult31["unit1"];
		$unit2 = $sale_count2 * $objResult31["unit2"];
		$unit3 = $sale_count2 * $objResult31["unit3"];
		$unit4 = $sale_count2 * $objResult31["unit4"];
		$unit5 = $sale_count2 * $objResult31["unit5"];
		$unit6 = $sale_count2 * $objResult31["unit6"];
		$unit7 = $sale_count2 * $objResult31["unit7"];
		$unit8 = $sale_count2 * $objResult31["unit8"];
		$unit9 = $sale_count2 * $objResult31["unit9"];
		$unit10 = $sale_count2 * $objResult31["unit10"];

		if ($Num_Rows31 > 0) {

			if ($product_idb1 != '') {

				$strSQL104 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,code_bom,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit1 . "','" . $unit1 . "','" . $product_price2 . "','" . $product_price2 . "','" . $sum_amount2 . "','" . $sale_remarkk2 . "','" . $discount_unit2 . "','" . $warranty2 . "','" . $cal2 . "','" . $pm2 . "','" . $product_idb1 . "','" . $product_idb1 . "','" . $product_code2 . "','1','" . $product_code2 . "','" . $have_order . "','" . $clear_br2 . "','" . $clear_ivno2 . "','" . $jong_no2 . "','" . $jong_ckk2 . "')";

				$objQuery104 = mysqli_query($conn, $strSQL104);
			}

			if ($product_idb2 != '') {

				$strSQL100 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit2 . "','" . $unit2 . "','0.00','0.00','0.00','" . $sale_remarkk2 . "','0.00','0','0','0','" . $product_idb2 . "','" . $product_idb2 . "','1','" . $product_code2 . "','" . $have_order . "','" . $clear_br2 . "','" . $clear_ivno2 . "','" . $jong_no2 . "','" . $jong_ckk2 . "')";
				$objQuery100 = mysqli_query($conn, $strSQL100);
			}

			if ($product_idb3 != '') {

				$strSQL101 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit3 . "','" . $unit3 . "','0.00','0.00','0.00','" . $sale_remarkk2 . "','0.00','0','0','0','" . $product_idb3 . "','" . $product_idb3 . "','1','" . $product_code2 . "','" . $have_order . "','" . $clear_br2 . "','" . $clear_ivno2 . "','" . $jong_no2 . "','" . $jong_ckk2 . "')";

				$objQuery101 = mysqli_query($conn, $strSQL101);
			}

			if ($product_idb4 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit4 . "','" . $unit4 . "','0.00','0.00','0.00','" . $sale_remarkk2 . "','0.00','0','0','0','" . $product_idb4 . "','" . $product_idb4 . "','1','" . $product_code2 . "','" . $have_order . "','" . $clear_br2 . "','" . $clear_ivno2 . "','" . $jong_no2 . "','" . $jong_ckk2 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb5 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit5 . "','" . $unit5 . "','0.00','0.00','0.00','" . $sale_remarkk2 . "','0.00','0','0','0','" . $product_idb5 . "','" . $product_idb5 . "','1','" . $product_code2 . "','" . $have_order . "','" . $clear_br2 . "','" . $clear_ivno2 . "','" . $jong_no2 . "','" . $jong_ckk2 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb6 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit6 . "','" . $unit6 . "','0.00','0.00','0.00','" . $sale_remarkk2 . "','0.00','0','0','0','" . $product_idb6 . "','" . $product_idb6 . "','1','" . $product_code2 . "','" . $have_order . "','" . $clear_br2 . "','" . $clear_ivno2 . "','" . $jong_no2 . "','" . $jong_ckk2 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb7 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit7 . "','" . $unit7 . "','0.00','0.00','0.00','" . $sale_remarkk2 . "','0.00','0','0','0','" . $product_idb7 . "','" . $product_idb7 . "','1','" . $product_code2 . "','" . $have_order . "','" . $clear_br2 . "','" . $clear_ivno2 . "','" . $jong_no2 . "','" . $jong_ckk2 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb8 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit8 . "','" . $unit8 . "','0.00','0.00','0.00','" . $sale_remarkk2 . "','0.00','0','0','0','" . $product_idb8 . "','" . $product_idb8 . "','1','" . $product_code2 . "','" . $have_order . "','" . $clear_br2 . "','" . $clear_ivno2 . "','" . $jong_no2 . "','" . $jong_ckk2 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb9 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit9 . "','" . $unit9 . "','0.00','0.00','0.00','" . $sale_remarkk2 . "','0.00','0','0','0','" . $product_idb9 . "','" . $product_idb9 . "','1','" . $product_code2 . "','" . $have_order . "','" . $clear_br2 . "','" . $clear_ivno2 . "','" . $jong_no2 . "','" . $jong_ckk2 . "')";
				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb10 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit10 . "','" . $unit10 . "','0.00','0.00','0.00','" . $sale_remarkk2 . "','0.00','0','0','0','" . $product_idb10 . "','" . $product_idb10 . "','1','" . $product_code2 . "','" . $have_order . "','" . $clear_br2 . "','" . $clear_ivno2 . "','" . $jong_no2 . "','" . $jong_ckk2 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}
		} else {

			$strSQL2 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $sale_count2 . "','" . $sale_count2 . "','" . $product_price2 . "','" . $product_price2 . "','" . $sum_amount2 . "','" . $sale_remarkk2 . "','" . $discount_unit2 . "','" . $warranty2 . "','" . $cal2 . "','" . $pm2 . "','" . $product_id2 . "','" . $product_id2 . "','" . $have_order . "','" . $clear_br2 . "','" . $clear_ivno2 . "','" . $jong_no2 . "','" . $jong_ckk2 . "')";

			$objQuery2 = mysqli_query($conn, $strSQL2);
		}
	}







	//แถวที่ 3

	if ($product_id3 != '') {

		$strSQL31 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '" . $product_code3 . "' ";
		$objQuery31 = mysqli_query($conn, $strSQL31) or die("Error Query [" . $strSQL31 . "]");
		$Num_Rows31 = mysqli_num_rows($objQuery31);
		$objResult31 = mysqli_fetch_array($objQuery31);

		$product_idb1 = $objResult31["product_id1"];
		$product_idb2 = $objResult31["product_id2"];
		$product_idb3 = $objResult31["product_id3"];
		$product_idb4 = $objResult31["product_id4"];
		$product_idb5 = $objResult31["product_id5"];
		$product_idb6 = $objResult31["product_id6"];
		$product_idb7 = $objResult31["product_id7"];
		$product_idb8 = $objResult31["product_id8"];
		$product_idb9 = $objResult31["product_id9"];
		$product_idb10 = $objResult31["product_id10"];


		$unit1 = $sale_count3 * $objResult31["unit1"];
		$unit2 = $sale_count3 * $objResult31["unit2"];
		$unit3 = $sale_count3 * $objResult31["unit3"];
		$unit4 = $sale_count3 * $objResult31["unit4"];
		$unit5 = $sale_count3 * $objResult31["unit5"];
		$unit6 = $sale_count3 * $objResult31["unit6"];
		$unit7 = $sale_count3 * $objResult31["unit7"];
		$unit8 = $sale_count3 * $objResult31["unit8"];
		$unit9 = $sale_count3 * $objResult31["unit9"];
		$unit10 = $sale_count3 * $objResult31["unit10"];

		if ($Num_Rows31 > 0) {

			if ($product_idb1 != '') {

				$strSQL104 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,code_bom,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit1 . "','" . $unit1 . "','" . $product_price3 . "','" . $product_price3 . "','" . $sum_amount3 . "','" . $sale_remarkk3 . "','" . $discount_unit3 . "','" . $warranty3 . "','" . $cal3 . "','" . $pm3 . "','" . $product_idb1 . "','" . $product_idb1 . "','" . $product_code3 . "','1','" . $product_code3 . "','" . $have_order . "','" . $clear_br3 . "','" . $clear_ivno3 . "','" . $jong_no3 . "','" . $jong_ckk3 . "')";

				$objQuery104 = mysqli_query($conn, $strSQL104);
			}

			if ($product_idb2 != '') {

				$strSQL100 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit2 . "','" . $unit2 . "','0.00','0.00','0.00','" . $sale_remarkk3 . "','0.00','0','0','0','" . $product_idb2 . "','" . $product_idb2 . "','1','" . $product_code3 . "','" . $have_order . "','" . $clear_br3 . "','" . $clear_ivno3 . "','" . $jong_no3 . "','" . $jong_ckk3 . "')";
				$objQuery100 = mysqli_query($conn, $strSQL100);
			}

			if ($product_idb3 != '') {

				$strSQL101 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit3 . "','" . $unit3 . "','0.00','0.00','0.00','" . $sale_remarkk3 . "','0.00','0','0','0','" . $product_idb3 . "','" . $product_idb3 . "','1','" . $product_code3 . "','" . $have_order . "','" . $clear_br3 . "','" . $clear_ivno3 . "','" . $jong_no3 . "','" . $jong_ckk3 . "')";

				$objQuery101 = mysqli_query($conn, $strSQL101);
			}

			if ($product_idb4 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit4 . "','" . $unit4 . "','0.00','0.00','0.00','" . $sale_remarkk3 . "','0.00','0','0','0','" . $product_idb4 . "','" . $product_idb4 . "','1','" . $product_code3 . "','" . $have_order . "','" . $clear_br3 . "','" . $clear_ivno3 . "','" . $jong_no3 . "','" . $jong_ckk3 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb5 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit5 . "','" . $unit5 . "','0.00','0.00','0.00','" . $sale_remarkk3 . "','0.00','0','0','0','" . $product_idb5 . "','" . $product_idb5 . "','1','" . $product_code3 . "','" . $have_order . "','" . $clear_br3 . "','" . $clear_ivno3 . "','" . $jong_no3 . "','" . $jong_ckk3 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb6 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit6 . "','" . $unit6 . "','0.00','0.00','0.00','" . $sale_remarkk3 . "','0.00','0','0','0','" . $product_idb6 . "','" . $product_idb6 . "','1','" . $product_code3 . "','" . $have_order . "','" . $clear_br3 . "','" . $clear_ivno3 . "','" . $jong_no3 . "','" . $jong_ckk3 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb7 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit7 . "','" . $unit7 . "','0.00','0.00','0.00','" . $sale_remarkk3 . "','0.00','0','0','0','" . $product_idb7 . "','" . $product_idb7 . "','1','" . $product_code3 . "','" . $have_order . "','" . $clear_br3 . "','" . $clear_ivno3 . "','" . $jong_no3 . "','" . $jong_ckk3 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb8 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit8 . "','" . $unit8 . "','0.00','0.00','0.00','" . $sale_remarkk3 . "','0.00','0','0','0','" . $product_idb8 . "','" . $product_idb8 . "','1','" . $product_code3 . "','" . $have_order . "','" . $clear_br3 . "','" . $clear_ivno3 . "','" . $jong_no3 . "','" . $jong_ckk3 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb9 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit9 . "','" . $unit9 . "','0.00','0.00','0.00','" . $sale_remarkk3 . "','0.00','0','0','0','" . $product_idb9 . "','" . $product_idb9 . "','1','" . $product_code3 . "','" . $have_order . "','" . $clear_br3 . "','" . $clear_ivno3 . "','" . $jong_no3 . "','" . $jong_ckk3 . "')";
				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb10 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br)
values ('" . $ref_id . "','" . $unit10 . "','" . $unit10 . "','0.00','0.00','0.00','" . $sale_remarkk3 . "','0.00','0','0','0','" . $product_idb10 . "','" . $product_idb10 . "','1','" . $product_code3 . "','" . $have_order . "','" . $clear_br3 . "','" . $clear_ivno3 . "','" . $jong_no3 . "','" . $jong_ckk3 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}
		} else {


			$strSQL3 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $sale_count3 . "','" . $sale_count3 . "','" . $product_price3 . "','" . $product_price3 . "','" . $sum_amount3 . "','" . $sale_remarkk3 . "','" . $discount_unit3 . "','" . $warranty3 . "','" . $cal3 . "','" . $pm3 . "','" . $product_id3 . "','" . $product_id3 . "','" . $have_order . "','" . $clear_br3 . "','" . $clear_ivno3 . "','" . $jong_no3 . "','" . $jong_ckk3 . "')";

			$objQuery3 = mysqli_query($conn, $strSQL3);
		}
	}


	if ($product_id4 != '') {

		$strSQL31 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '" . $product_code4 . "' ";
		$objQuery31 = mysqli_query($conn, $strSQL31) or die("Error Query [" . $strSQL31 . "]");
		$Num_Rows31 = mysqli_num_rows($objQuery31);
		$objResult31 = mysqli_fetch_array($objQuery31);

		$product_idb1 = $objResult31["product_id1"];
		$product_idb2 = $objResult31["product_id2"];
		$product_idb3 = $objResult31["product_id3"];
		$product_idb4 = $objResult31["product_id4"];
		$product_idb5 = $objResult31["product_id5"];
		$product_idb6 = $objResult31["product_id6"];
		$product_idb7 = $objResult31["product_id7"];
		$product_idb8 = $objResult31["product_id8"];
		$product_idb9 = $objResult31["product_id9"];
		$product_idb10 = $objResult31["product_id10"];


		$unit1 = $sale_count4 * $objResult31["unit1"];
		$unit2 = $sale_count4 * $objResult31["unit2"];
		$unit3 = $sale_count4 * $objResult31["unit3"];
		$unit4 = $sale_count4 * $objResult31["unit4"];
		$unit5 = $sale_count4 * $objResult31["unit5"];
		$unit6 = $sale_count4 * $objResult31["unit6"];
		$unit7 = $sale_count4 * $objResult31["unit7"];
		$unit8 = $sale_count4 * $objResult31["unit8"];
		$unit9 = $sale_count4 * $objResult31["unit9"];
		$unit10 = $sale_count4 * $objResult31["unit10"];

		if ($Num_Rows31 > 0) {

			if ($product_idb1 != '') {

				$strSQL104 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,code_bom,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit1 . "','" . $unit1 . "','" . $product_price4 . "','" . $product_price4 . "','" . $sum_amount4 . "','" . $sale_remarkk4 . "','" . $discount_unit4 . "','" . $warranty4 . "','" . $cal4 . "','" . $pm4 . "','" . $product_idb1 . "','" . $product_idb1 . "','" . $product_code4 . "','1','" . $product_code4 . "','" . $have_order . "','" . $clear_br4 . "','" . $clear_ivno4 . "','" . $jong_no4 . "','" . $jong_ckk4 . "')";

				$objQuery104 = mysqli_query($conn, $strSQL104);
			}

			if ($product_idb2 != '') {

				$strSQL100 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit2 . "','" . $unit2 . "','0.00','0.00','0.00','" . $sale_remarkk4 . "','0.00','0','0','0','" . $product_idb2 . "','" . $product_idb2 . "','1','" . $product_code4 . "','" . $have_order . "','" . $clear_br4 . "','" . $clear_ivno4 . "','" . $jong_no4 . "','" . $jong_ckk4 . "')";
				$objQuery100 = mysqli_query($conn, $strSQL100);
			}

			if ($product_idb3 != '') {

				$strSQL101 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit3 . "','" . $unit3 . "','0.00','0.00','0.00','" . $sale_remarkk4 . "','0.00','0','0','0','" . $product_idb3 . "','" . $product_idb3 . "','1','" . $product_code4 . "','" . $have_order . "','" . $clear_br4 . "','" . $clear_ivno4 . "','" . $jong_no4 . "','" . $jong_ckk4 . "')";

				$objQuery101 = mysqli_query($conn, $strSQL101);
			}

			if ($product_idb4 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit4 . "','" . $unit4 . "','0.00','0.00','0.00','" . $sale_remarkk4 . "','0.00','0','0','0','" . $product_idb4 . "','" . $product_idb4 . "','1','" . $product_code4 . "','" . $have_order . "','" . $clear_br4 . "','" . $clear_ivno4 . "','" . $jong_no4 . "','" . $jong_ckk4 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb5 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit5 . "','" . $unit5 . "','0.00','0.00','0.00','" . $sale_remarkk4 . "','0.00','0','0','0','" . $product_idb5 . "','" . $product_idb5 . "','1','" . $product_code4 . "','" . $have_order . "','" . $clear_br4 . "','" . $clear_ivno4 . "','" . $jong_no4 . "','" . $jong_ckk4 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb6 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit6 . "','" . $unit6 . "','0.00','0.00','0.00','" . $sale_remarkk4 . "','0.00','0','0','0','" . $product_idb6 . "','" . $product_idb6 . "','1','" . $product_code4 . "','" . $have_order . "','" . $clear_br4 . "','" . $clear_ivno4 . "','" . $jong_no4 . "','" . $jong_ckk4 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb7 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit7 . "','" . $unit7 . "','0.00','0.00','0.00','" . $sale_remarkk4 . "','0.00','0','0','0','" . $product_idb7 . "','" . $product_idb7 . "','1','" . $product_code4 . "','" . $have_order . "','" . $clear_br4 . "','" . $clear_ivno4 . "','" . $jong_no4 . "','" . $jong_ckk4 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb8 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit8 . "','" . $unit8 . "','0.00','0.00','0.00','" . $sale_remarkk4 . "','0.00','0','0','0','" . $product_idb8 . "','" . $product_idb8 . "','1','" . $product_code4 . "','" . $have_order . "','" . $clear_br4 . "','" . $clear_ivno4 . "','" . $jong_no4 . "','" . $jong_ckk4 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb9 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit9 . "','" . $unit9 . "','0.00','0.00','0.00','" . $sale_remarkk4 . "','0.00','0','0','0','" . $product_idb9 . "','" . $product_idb9 . "','1','" . $product_code4 . "','" . $have_order . "','" . $clear_br4 . "','" . $clear_ivno4 . "','" . $jong_no4 . "','" . $jong_ckk4 . "')";
				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb10 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit10 . "','" . $unit10 . "','0.00','0.00','0.00','" . $sale_remarkk4 . "','0.00','0','0','0','" . $product_idb10 . "','" . $product_idb10 . "','1','" . $product_code4 . "','" . $have_order . "','" . $clear_br4 . "','" . $clear_ivno4 . "','" . $jong_no4 . "','" . $jong_ckk4 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}
		} else {

			$strSQL4 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $sale_count4 . "','" . $sale_count4 . "','" . $product_price4 . "','" . $product_price4 . "','" . $sum_amount4 . "','" . $sale_remarkk4 . "','" . $discount_unit4 . "','" . $warranty4 . "','" . $cal4 . "','" . $pm4 . "','" . $product_id4 . "','" . $product_id4 . "','" . $have_order . "','" . $clear_br4 . "','" . $clear_ivno4 . "','" . $jong_no4 . "','" . $jong_ckk4 . "')";

			$objQuery4 = mysqli_query($conn, $strSQL4);
		}
	}


	if ($product_id5 != '') {

		$strSQL31 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '" . $product_code5 . "' ";
		$objQuery31 = mysqli_query($conn, $strSQL31) or die("Error Query [" . $strSQL31 . "]");
		$Num_Rows31 = mysqli_num_rows($objQuery31);
		$objResult31 = mysqli_fetch_array($objQuery31);

		$product_idb1 = $objResult31["product_id1"];
		$product_idb2 = $objResult31["product_id2"];
		$product_idb3 = $objResult31["product_id3"];
		$product_idb4 = $objResult31["product_id4"];
		$product_idb5 = $objResult31["product_id5"];
		$product_idb6 = $objResult31["product_id6"];
		$product_idb7 = $objResult31["product_id7"];
		$product_idb8 = $objResult31["product_id8"];
		$product_idb9 = $objResult31["product_id9"];
		$product_idb10 = $objResult31["product_id10"];


		$unit1 = $sale_count5 * $objResult31["unit1"];
		$unit2 = $sale_count5 * $objResult31["unit2"];
		$unit3 = $sale_count5 * $objResult31["unit3"];
		$unit4 = $sale_count5 * $objResult31["unit4"];
		$unit5 = $sale_count5 * $objResult31["unit5"];
		$unit6 = $sale_count5 * $objResult31["unit6"];
		$unit7 = $sale_count5 * $objResult31["unit7"];
		$unit8 = $sale_count5 * $objResult31["unit8"];
		$unit9 = $sale_count5 * $objResult31["unit9"];
		$unit10 = $sale_count5 * $objResult31["unit10"];

		if ($Num_Rows31 > 0) {

			if ($product_idb1 != '') {

				$strSQL104 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,code_bom,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit1 . "','" . $unit1 . "','" . $product_price5 . "','" . $product_price5 . "','" . $sum_amount5 . "','" . $sale_remarkk5 . "','" . $discount_unit5 . "','" . $warranty5 . "','" . $cal5 . "','" . $pm5 . "','" . $product_idb1 . "','" . $product_idb1 . "','" . $product_code5 . "','1','" . $product_code5 . "','" . $have_order . "','" . $clear_br5 . "','" . $clear_ivno5 . "','" . $jong_no5 . "','" . $jong_ckk5 . "')";

				$objQuery104 = mysqli_query($conn, $strSQL104);
			}

			if ($product_idb2 != '') {

				$strSQL100 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit2 . "','" . $unit2 . "','0.00','0.00','0.00','" . $sale_remarkk5 . "','0.00','0','0','0','" . $product_idb2 . "','" . $product_idb2 . "','1','" . $product_code5 . "','" . $have_order . "','" . $clear_br5 . "','" . $clear_ivno5 . "','" . $jong_no5 . "','" . $jong_ckk5 . "')";
				$objQuery100 = mysqli_query($conn, $strSQL100);
			}

			if ($product_idb3 != '') {

				$strSQL101 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit3 . "','" . $unit3 . "','0.00','0.00','0.00','" . $sale_remarkk5 . "','0.00','0','0','0','" . $product_idb3 . "','" . $product_idb3 . "','1','" . $product_code5 . "','" . $have_order . "','" . $clear_br5 . "','" . $clear_ivno5 . "','" . $jong_no5 . "','" . $jong_ckk5 . "')";

				$objQuery101 = mysqli_query($conn, $strSQL101);
			}

			if ($product_idb4 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit4 . "','" . $unit4 . "','0.00','0.00','0.00','" . $sale_remarkk5 . "','0.00','0','0','0','" . $product_idb4 . "','" . $product_idb4 . "','1','" . $product_code5 . "','" . $have_order . "','" . $clear_br5 . "','" . $clear_ivno5 . "','" . $jong_no5 . "','" . $jong_ckk5 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb5 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit5 . "','" . $unit5 . "','0.00','0.00','0.00','" . $sale_remarkk5 . "','0.00','0','0','0','" . $product_idb5 . "','" . $product_idb5 . "','1','" . $product_code5 . "','" . $have_order . "','" . $clear_br5 . "','" . $clear_ivno5 . "','" . $jong_no5 . "','" . $jong_ckk5 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb6 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit6 . "','" . $unit6 . "','0.00','0.00','0.00','" . $sale_remarkk5 . "','0.00','0','0','0','" . $product_idb6 . "','" . $product_idb6 . "','1','" . $product_code5 . "','" . $have_order . "','" . $clear_br5 . "','" . $clear_ivno5 . "','" . $jong_no5 . "','" . $jong_ckk5 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb7 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit7 . "','" . $unit7 . "','0.00','0.00','0.00','" . $sale_remarkk5 . "','0.00','0','0','0','" . $product_idb7 . "','" . $product_idb7 . "','1','" . $product_code5 . "','" . $have_order . "','" . $clear_br5 . "','" . $clear_ivno5 . "','" . $jong_no5 . "','" . $jong_ckk5 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb8 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit8 . "','" . $unit8 . "','0.00','0.00','0.00','" . $sale_remarkk5 . "','0.00','0','0','0','" . $product_idb8 . "','" . $product_idb8 . "','1','" . $product_code5 . "','" . $have_order . "','" . $clear_br5 . "','" . $clear_ivno5 . "','" . $jong_no5 . "','" . $jong_ckk5 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb9 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit9 . "','" . $unit9 . "','0.00','0.00','0.00','" . $sale_remarkk5 . "','0.00','0','0','0','" . $product_idb9 . "','" . $product_idb9 . "','1','" . $product_code5 . "','" . $have_order . "','" . $clear_br5 . "','" . $clear_ivno5 . "','" . $jong_no5 . "','" . $jong_ckk5 . "')";
				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb10 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit10 . "','" . $unit10 . "','0.00','0.00','0.00','" . $sale_remarkk5 . "','0.00','0','0','0','" . $product_idb10 . "','" . $product_idb10 . "','1','" . $product_code5 . "','" . $have_order . "','" . $clear_br5 . "','" . $clear_ivno5 . "','" . $jong_no5 . "','" . $jong_ckk5 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}
		} else {



			$strSQL5 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $sale_count5 . "','" . $sale_count5 . "','" . $product_price5 . "','" . $product_price5 . "','" . $sum_amount5 . "','" . $sale_remarkk5 . "','" . $discount_unit5 . "','" . $warranty5 . "','" . $cal5 . "','" . $pm5 . "','" . $product_id5 . "','" . $product_id5 . "','" . $have_order . "','" . $clear_br5 . "','" . $clear_ivno5 . "','" . $jong_no5 . "','" . $jong_ckk5 . "')";

			$objQuery5 = mysqli_query($conn, $strSQL5);
		}
	}

	if ($product_id6 != '') {

		$strSQL31 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '" . $product_code6 . "' ";
		$objQuery31 = mysqli_query($conn, $strSQL31) or die("Error Query [" . $strSQL31 . "]");
		$Num_Rows31 = mysqli_num_rows($objQuery31);
		$objResult31 = mysqli_fetch_array($objQuery31);

		$product_idb1 = $objResult31["product_id1"];
		$product_idb2 = $objResult31["product_id2"];
		$product_idb3 = $objResult31["product_id3"];
		$product_idb4 = $objResult31["product_id4"];
		$product_idb5 = $objResult31["product_id5"];
		$product_idb6 = $objResult31["product_id6"];
		$product_idb7 = $objResult31["product_id7"];
		$product_idb8 = $objResult31["product_id8"];
		$product_idb9 = $objResult31["product_id9"];
		$product_idb10 = $objResult31["product_id10"];


		$unit1 = $sale_count6 * $objResult31["unit1"];
		$unit2 = $sale_count6 * $objResult31["unit2"];
		$unit3 = $sale_count6 * $objResult31["unit3"];
		$unit4 = $sale_count6 * $objResult31["unit4"];
		$unit5 = $sale_count6 * $objResult31["unit5"];
		$unit6 = $sale_count6 * $objResult31["unit6"];
		$unit7 = $sale_count6 * $objResult31["unit7"];
		$unit8 = $sale_count6 * $objResult31["unit8"];
		$unit9 = $sale_count6 * $objResult31["unit9"];
		$unit10 = $sale_count6 * $objResult31["unit10"];

		if ($Num_Rows31 > 0) {

			if ($product_idb1 != '') {

				$strSQL104 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,code_bom,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit1 . "','" . $unit1 . "','" . $product_price6 . "','" . $product_price6 . "','" . $sum_amount6 . "','" . $sale_remarkk6 . "','" . $discount_unit6 . "','" . $warranty6 . "','" . $cal6 . "','" . $pm6 . "','" . $product_idb1 . "','" . $product_idb1 . "','" . $product_code6 . "','1','" . $product_code6 . "','" . $have_order . "','" . $clear_br6 . "','" . $clear_ivno6 . "','" . $jong_no6 . "','" . $jong_ckk6 . "')";

				$objQuery104 = mysqli_query($conn, $strSQL104);
			}

			if ($product_idb2 != '') {

				$strSQL100 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit2 . "','" . $unit2 . "','0.00','0.00','0.00','" . $sale_remarkk6 . "','0.00','0','0','0','" . $product_idb2 . "','" . $product_idb2 . "','1','" . $product_code6 . "','" . $have_order . "','" . $clear_br6 . "','" . $clear_ivno6 . "','" . $jong_no6 . "','" . $jong_ckk6 . "')";
				$objQuery100 = mysqli_query($conn, $strSQL100);
			}

			if ($product_idb3 != '') {

				$strSQL101 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit3 . "','" . $unit3 . "','0.00','0.00','0.00','" . $sale_remarkk6 . "','0.00','0','0','0','" . $product_idb3 . "','" . $product_idb3 . "','1','" . $product_code6 . "','" . $have_order . "','" . $clear_br6 . "','" . $clear_ivno6 . "','" . $jong_no6 . "','" . $jong_ckk6 . "')";

				$objQuery101 = mysqli_query($conn, $strSQL101);
			}

			if ($product_idb4 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit4 . "','" . $unit4 . "','0.00','0.00','0.00','" . $sale_remarkk6 . "','0.00','0','0','0','" . $product_idb4 . "','" . $product_idb4 . "','1','" . $product_code6 . "','" . $have_order . "','" . $clear_br6 . "','" . $clear_ivno6 . "','" . $jong_no6 . "','" . $jong_ckk6 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb5 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit5 . "','" . $unit5 . "','0.00','0.00','0.00','" . $sale_remarkk6 . "','0.00','0','0','0','" . $product_idb5 . "','" . $product_idb5 . "','1','" . $product_code6 . "','" . $have_order . "','" . $clear_br6 . "','" . $clear_ivno6 . "','" . $jong_no6 . "','" . $jong_ckk6 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb6 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit6 . "','" . $unit6 . "','0.00','0.00','0.00','" . $sale_remarkk6 . "','0.00','0','0','0','" . $product_idb6 . "','" . $product_idb6 . "','1','" . $product_code6 . "','" . $have_order . "','" . $clear_br6 . "','" . $clear_ivno6 . "','" . $jong_no6 . "','" . $jong_ckk6 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb7 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit7 . "','" . $unit7 . "','0.00','0.00','0.00','" . $sale_remarkk6 . "','0.00','0','0','0','" . $product_idb7 . "','" . $product_idb7 . "','1','" . $product_code6 . "','" . $have_order . "','" . $clear_br6 . "','" . $clear_ivno6 . "','" . $jong_no6 . "','" . $jong_ckk6 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb8 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit8 . "','" . $unit8 . "','0.00','0.00','0.00','" . $sale_remarkk6 . "','0.00','0','0','0','" . $product_idb8 . "','" . $product_idb8 . "','1','" . $product_code6 . "','" . $have_order . "','" . $clear_br6 . "','" . $clear_ivno6 . "','" . $jong_no6 . "','" . $jong_ckk6 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb9 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit9 . "','" . $unit9 . "','0.00','0.00','0.00','" . $sale_remarkk6 . "','0.00','0','0','0','" . $product_idb9 . "','" . $product_idb9 . "','1','" . $product_code6 . "','" . $have_order . "','" . $clear_br6 . "','" . $clear_ivno6 . "','" . $jong_no6 . "','" . $jong_ckk6 . "')";
				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb10 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit10 . "','" . $unit10 . "','0.00','0.00','0.00','" . $sale_remarkk6 . "','0.00','0','0','0','" . $product_idb10 . "','" . $product_idb10 . "','1','" . $product_code6 . "','" . $have_order . "','" . $clear_br6 . "','" . $clear_ivno6 . "','" . $jong_no6 . "','" . $jong_ckk6 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}
		} else {

			$strSQL6 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $sale_count6 . "','" . $sale_count6 . "','" . $product_price6 . "','" . $product_price6 . "','" . $sum_amount6 . "','" . $sale_remarkk6 . "','" . $discount_unit6 . "','" . $warranty6 . "','" . $cal6 . "','" . $pm6 . "','" . $product_id6 . "','" . $product_id6 . "','" . $have_order . "','" . $clear_br6 . "','" . $clear_ivno6 . "','" . $jong_no6 . "','" . $jong_ckk6 . "')";

			$objQuery6 = mysqli_query($conn, $strSQL6);
		}
	}


	if ($product_id7 != '') {

		$strSQL31 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '" . $product_code7 . "' ";
		$objQuery31 = mysqli_query($conn, $strSQL31) or die("Error Query [" . $strSQL31 . "]");
		$Num_Rows31 = mysqli_num_rows($objQuery31);
		$objResult31 = mysqli_fetch_array($objQuery31);

		$product_idb1 = $objResult31["product_id1"];
		$product_idb2 = $objResult31["product_id2"];
		$product_idb3 = $objResult31["product_id3"];
		$product_idb4 = $objResult31["product_id4"];
		$product_idb5 = $objResult31["product_id5"];
		$product_idb6 = $objResult31["product_id6"];
		$product_idb7 = $objResult31["product_id7"];
		$product_idb8 = $objResult31["product_id8"];
		$product_idb9 = $objResult31["product_id9"];
		$product_idb10 = $objResult31["product_id10"];


		$unit1 = $sale_count7 * $objResult31["unit1"];
		$unit2 = $sale_count7 * $objResult31["unit2"];
		$unit3 = $sale_count7 * $objResult31["unit3"];
		$unit4 = $sale_count7 * $objResult31["unit4"];
		$unit5 = $sale_count7 * $objResult31["unit5"];
		$unit6 = $sale_count7 * $objResult31["unit6"];
		$unit7 = $sale_count7 * $objResult31["unit7"];
		$unit8 = $sale_count7 * $objResult31["unit8"];
		$unit9 = $sale_count7 * $objResult31["unit9"];
		$unit10 = $sale_count7 * $objResult31["unit10"];

		if ($Num_Rows31 > 0) {

			if ($product_idb1 != '') {

				$strSQL104 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,code_bom,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit1 . "','" . $unit1 . "','" . $product_price7 . "','" . $product_price7 . "','" . $sum_amount7 . "','" . $sale_remarkk7 . "','" . $discount_unit7 . "','" . $warranty7 . "','" . $cal7 . "','" . $pm7 . "','" . $product_idb1 . "','" . $product_idb1 . "','" . $product_code7 . "','1','" . $product_code7 . "','" . $have_order . "','" . $clear_br7 . "','" . $clear_ivno7 . "','" . $jong_no7 . "','" . $jong_ckk7 . "')";

				$objQuery104 = mysqli_query($conn, $strSQL104);
			}

			if ($product_idb2 != '') {

				$strSQL100 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit2 . "','" . $unit2 . "','0.00','0.00','0.00','" . $sale_remarkk7 . "','0.00','0','0','0','" . $product_idb2 . "','" . $product_idb2 . "','1','" . $product_code7 . "','" . $have_order . "','" . $clear_br7 . "','" . $clear_ivno7 . "','" . $jong_no7 . "','" . $jong_ckk7 . "')";
				$objQuery100 = mysqli_query($conn, $strSQL100);
			}

			if ($product_idb3 != '') {

				$strSQL101 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit3 . "','" . $unit3 . "','0.00','0.00','0.00','" . $sale_remarkk7 . "','0.00','0','0','0','" . $product_idb3 . "','" . $product_idb3 . "','1','" . $product_code7 . "','" . $have_order . "','" . $clear_br7 . "','" . $clear_ivno7 . "','" . $jong_no7 . "','" . $jong_ckk7 . "')";

				$objQuery101 = mysqli_query($conn, $strSQL101);
			}

			if ($product_idb4 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit4 . "','" . $unit4 . "','0.00','0.00','0.00','" . $sale_remarkk7 . "','0.00','0','0','0','" . $product_idb4 . "','" . $product_idb4 . "','1','" . $product_code7 . "','" . $have_order . "','" . $clear_br7 . "','" . $clear_ivno7 . "','" . $jong_no7 . "','" . $jong_ckk7 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb5 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit5 . "','" . $unit5 . "','0.00','0.00','0.00','" . $sale_remarkk7 . "','0.00','0','0','0','" . $product_idb5 . "','" . $product_idb5 . "','1','" . $product_code7 . "','" . $have_order . "','" . $clear_br7 . "','" . $clear_ivno7 . "','" . $jong_no7 . "','" . $jong_ckk7 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb6 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit6 . "','" . $unit6 . "','0.00','0.00','0.00','" . $sale_remarkk7 . "','0.00','0','0','0','" . $product_idb6 . "','" . $product_idb6 . "','1','" . $product_code7 . "','" . $have_order . "','" . $clear_br7 . "','" . $clear_ivno7 . "','" . $jong_no7 . "','" . $jong_ckk7 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb7 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit7 . "','" . $unit7 . "','0.00','0.00','0.00','" . $sale_remarkk7 . "','0.00','0','0','0','" . $product_idb7 . "','" . $product_idb7 . "','1','" . $product_code7 . "','" . $have_order . "','" . $clear_br7 . "','" . $clear_ivno7 . "','" . $jong_no7 . "','" . $jong_ckk7 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb8 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit8 . "','" . $unit8 . "','0.00','0.00','0.00','" . $sale_remarkk7 . "','0.00','0','0','0','" . $product_idb8 . "','" . $product_idb8 . "','1','" . $product_code7 . "','" . $have_order . "','" . $clear_br7 . "','" . $clear_ivno7 . "','" . $jong_no7 . "','" . $jong_ckk7 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb9 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit9 . "','" . $unit9 . "','0.00','0.00','0.00','" . $sale_remarkk7 . "','0.00','0','0','0','" . $product_idb9 . "','" . $product_idb9 . "','1','" . $product_code7 . "','" . $have_order . "','" . $clear_br7 . "','" . $clear_ivno7 . "','" . $jong_no7 . "','" . $jong_ckk7 . "')";
				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb10 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit10 . "','" . $unit10 . "','0.00','0.00','0.00','" . $sale_remarkk7 . "','0.00','0','0','0','" . $product_idb10 . "','" . $product_idb10 . "','1','" . $product_code7 . "','" . $have_order . "','" . $clear_br7 . "','" . $clear_ivno7 . "','" . $jong_no7 . "','" . $jong_ckk7 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}
		} else {

			$strSQL7 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $sale_count7 . "','" . $sale_count7 . "','" . $product_price7 . "','" . $product_price7 . "','" . $sum_amount7 . "','" . $sale_remarkk7 . "','" . $discount_unit7 . "','" . $warranty7 . "','" . $cal7 . "','" . $pm7 . "','" . $product_id7 . "','" . $product_id7 . "','" . $have_order . "','" . $clear_br7 . "','" . $clear_ivno7 . "','" . $jong_no7 . "','" . $jong_ckk7 . "')";

			$objQuery7 = mysqli_query($conn, $strSQL7);
		}
	}


	if ($product_id8 != '') {

		$strSQL31 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '" . $product_code8 . "' ";
		$objQuery31 = mysqli_query($conn, $strSQL31) or die("Error Query [" . $strSQL31 . "]");
		$Num_Rows31 = mysqli_num_rows($objQuery31);
		$objResult31 = mysqli_fetch_array($objQuery31);

		$product_idb1 = $objResult31["product_id1"];
		$product_idb2 = $objResult31["product_id2"];
		$product_idb3 = $objResult31["product_id3"];
		$product_idb4 = $objResult31["product_id4"];
		$product_idb5 = $objResult31["product_id5"];
		$product_idb6 = $objResult31["product_id6"];
		$product_idb7 = $objResult31["product_id7"];
		$product_idb8 = $objResult31["product_id8"];
		$product_idb9 = $objResult31["product_id9"];
		$product_idb10 = $objResult31["product_id10"];


		$unit1 = $sale_count8 * $objResult31["unit1"];
		$unit2 = $sale_count8 * $objResult31["unit2"];
		$unit3 = $sale_count8 * $objResult31["unit3"];
		$unit4 = $sale_count8 * $objResult31["unit4"];
		$unit5 = $sale_count8 * $objResult31["unit5"];
		$unit6 = $sale_count8 * $objResult31["unit6"];
		$unit7 = $sale_count8 * $objResult31["unit7"];
		$unit8 = $sale_count8 * $objResult31["unit8"];
		$unit9 = $sale_count8 * $objResult31["unit9"];
		$unit10 = $sale_count8 * $objResult31["unit10"];

		if ($Num_Rows31 > 0) {

			if ($product_idb1 != '') {

				$strSQL104 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,code_bom,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit1 . "','" . $unit1 . "','" . $product_price8 . "','" . $product_price8 . "','" . $sum_amount8 . "','" . $sale_remarkk8 . "','" . $discount_unit8 . "','" . $warranty8 . "','" . $cal8 . "','" . $pm8 . "','" . $product_idb1 . "','" . $product_idb1 . "','" . $product_code8 . "','1','" . $product_code8 . "','" . $have_order . "','" . $clear_br8 . "','" . $clear_ivno8 . "','" . $jong_no8 . "','" . $jong_ckk8 . "')";

				$objQuery104 = mysqli_query($conn, $strSQL104);
			}

			if ($product_idb2 != '') {

				$strSQL100 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit2 . "','" . $unit2 . "','0.00','0.00','0.00','" . $sale_remarkk8 . "','0.00','0','0','0','" . $product_idb2 . "','" . $product_idb2 . "','1','" . $product_code8 . "','" . $have_order . "','" . $clear_br8 . "','" . $clear_ivno8 . "','" . $jong_no8 . "','" . $jong_ckk8 . "')";
				$objQuery100 = mysqli_query($conn, $strSQL100);
			}

			if ($product_idb3 != '') {

				$strSQL101 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit3 . "','" . $unit3 . "','0.00','0.00','0.00','" . $sale_remarkk8 . "','0.00','0','0','0','" . $product_idb3 . "','" . $product_idb3 . "','1','" . $product_code8 . "','" . $have_order . "','" . $clear_br8 . "','" . $clear_ivno8 . "','" . $jong_no8 . "','" . $jong_ckk8 . "')";

				$objQuery101 = mysqli_query($conn, $strSQL101);
			}

			if ($product_idb4 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit4 . "','" . $unit4 . "','0.00','0.00','0.00','" . $sale_remarkk8 . "','0.00','0','0','0','" . $product_idb4 . "','" . $product_idb4 . "','1','" . $product_code8 . "','" . $have_order . "','" . $clear_br8 . "','" . $clear_ivno8 . "','" . $jong_no8 . "','" . $jong_ckk8 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb5 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit5 . "','" . $unit5 . "','0.00','0.00','0.00','" . $sale_remarkk8 . "','0.00','0','0','0','" . $product_idb5 . "','" . $product_idb5 . "','1','" . $product_code8 . "','" . $have_order . "','" . $clear_br8 . "','" . $clear_ivno8 . "','" . $jong_no8 . "','" . $jong_ckk8 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb6 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit6 . "','" . $unit6 . "','0.00','0.00','0.00','" . $sale_remarkk8 . "','0.00','0','0','0','" . $product_idb6 . "','" . $product_idb6 . "','1','" . $product_code8 . "','" . $have_order . "','" . $clear_br8 . "','" . $clear_ivno8 . "','" . $jong_no8 . "','" . $jong_ckk8 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb7 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit7 . "','" . $unit7 . "','0.00','0.00','0.00','" . $sale_remarkk8 . "','0.00','0','0','0','" . $product_idb7 . "','" . $product_idb7 . "','1','" . $product_code8 . "','" . $have_order . "','" . $clear_br8 . "','" . $clear_ivno8 . "','" . $jong_no8 . "','" . $jong_ckk8 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb8 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit8 . "','" . $unit8 . "','0.00','0.00','0.00','" . $sale_remarkk8 . "','0.00','0','0','0','" . $product_idb8 . "','" . $product_idb8 . "','1','" . $product_code8 . "','" . $have_order . "','" . $clear_br8 . "','" . $clear_ivno8 . "','" . $jong_no8 . "','" . $jong_ckk8 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb9 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit9 . "','" . $unit9 . "','0.00','0.00','0.00','" . $sale_remarkk8 . "','0.00','0','0','0','" . $product_idb9 . "','" . $product_idb9 . "','1','" . $product_code8 . "','" . $have_order . "','" . $clear_br8 . "','" . $clear_ivno8 . "','" . $jong_no8 . "','" . $jong_ckk8 . "')";
				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb10 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit10 . "','" . $unit10 . "','0.00','0.00','0.00','" . $sale_remarkk8 . "','0.00','0','0','0','" . $product_idb10 . "','" . $product_idb10 . "','1','" . $product_code8 . "','" . $have_order . "','" . $clear_br8 . "','" . $clear_ivno8 . "','" . $jong_no8 . "','" . $jong_ckk8 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}
		} else {


			$strSQL8 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $sale_count8 . "','" . $sale_count8 . "','" . $product_price8 . "','" . $product_price8 . "','" . $sum_amount8 . "','" . $sale_remarkk8 . "','" . $discount_unit8 . "','" . $warranty8 . "','" . $cal8 . "','" . $pm8 . "','" . $product_id8 . "','" . $product_id8 . "','" . $have_order . "','" . $clear_br8 . "','" . $clear_ivno8 . "','" . $jong_no8 . "','" . $jong_ckk8 . "')";

			$objQuery8 = mysqli_query($conn, $strSQL8);
		}
	}


	if ($product_id9 != '') {

		$strSQL31 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '" . $product_code9 . "' ";
		$objQuery31 = mysqli_query($conn, $strSQL31) or die("Error Query [" . $strSQL31 . "]");
		$Num_Rows31 = mysqli_num_rows($objQuery31);
		$objResult31 = mysqli_fetch_array($objQuery31);

		$product_idb1 = $objResult31["product_id1"];
		$product_idb2 = $objResult31["product_id2"];
		$product_idb3 = $objResult31["product_id3"];
		$product_idb4 = $objResult31["product_id4"];
		$product_idb5 = $objResult31["product_id5"];
		$product_idb6 = $objResult31["product_id6"];
		$product_idb7 = $objResult31["product_id7"];
		$product_idb8 = $objResult31["product_id8"];
		$product_idb9 = $objResult31["product_id9"];
		$product_idb10 = $objResult31["product_id10"];


		$unit1 = $sale_count9 * $objResult31["unit1"];
		$unit2 = $sale_count9 * $objResult31["unit2"];
		$unit3 = $sale_count9 * $objResult31["unit3"];
		$unit4 = $sale_count9 * $objResult31["unit4"];
		$unit5 = $sale_count9 * $objResult31["unit5"];
		$unit6 = $sale_count9 * $objResult31["unit6"];
		$unit7 = $sale_count9 * $objResult31["unit7"];
		$unit8 = $sale_count9 * $objResult31["unit8"];
		$unit9 = $sale_count9 * $objResult31["unit9"];
		$unit10 = $sale_count9 * $objResult31["unit10"];

		if ($Num_Rows31 > 0) {

			if ($product_idb1 != '') {

				$strSQL104 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,code_bom,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit1 . "','" . $unit1 . "','" . $product_price9 . "','" . $product_price9 . "','" . $sum_amount9 . "','" . $sale_remarkk9 . "','" . $discount_unit9 . "','" . $warranty9 . "','" . $cal9 . "','" . $pm9 . "','" . $product_idb1 . "','" . $product_idb1 . "','" . $product_code9 . "','1','" . $product_code9 . "','" . $have_order . "','" . $clear_br9 . "','" . $clear_ivno9 . "','" . $jong_no9 . "','" . $jong_ckk9 . "')";

				$objQuery104 = mysqli_query($conn, $strSQL104);
			}

			if ($product_idb2 != '') {

				$strSQL100 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit2 . "','" . $unit2 . "','0.00','0.00','0.00','" . $sale_remarkk9 . "','0.00','0','0','0','" . $product_idb2 . "','" . $product_idb2 . "','1','" . $product_code9 . "','" . $have_order . "','" . $clear_br9 . "','" . $clear_ivno9 . "','" . $jong_no9 . "','" . $jong_ckk9 . "')";
				$objQuery100 = mysqli_query($conn, $strSQL100);
			}

			if ($product_idb3 != '') {

				$strSQL101 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit3 . "','" . $unit3 . "','0.00','0.00','0.00','" . $sale_remarkk9 . "','0.00','0','0','0','" . $product_idb3 . "','" . $product_idb3 . "','1','" . $product_code9 . "','" . $have_order . "','" . $clear_br9 . "','" . $clear_ivno9 . "','" . $jong_no9 . "','" . $jong_ckk9 . "')";

				$objQuery101 = mysqli_query($conn, $strSQL101);
			}

			if ($product_idb4 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit4 . "','" . $unit4 . "','0.00','0.00','0.00','" . $sale_remarkk9 . "','0.00','0','0','0','" . $product_idb4 . "','" . $product_idb4 . "','1','" . $product_code9 . "','" . $have_order . "','" . $clear_br9 . "','" . $clear_ivno9 . "','" . $jong_no9 . "','" . $jong_ckk9 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb5 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit5 . "','" . $unit5 . "','0.00','0.00','0.00','" . $sale_remarkk9 . "','0.00','0','0','0','" . $product_idb5 . "','" . $product_idb5 . "','1','" . $product_code9 . "','" . $have_order . "','" . $clear_br9 . "','" . $clear_ivno9 . "','" . $jong_no9 . "','" . $jong_ckk9 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb6 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit6 . "','" . $unit6 . "','0.00','0.00','0.00','" . $sale_remarkk9 . "','0.00','0','0','0','" . $product_idb6 . "','" . $product_idb6 . "','1','" . $product_code9 . "','" . $have_order . "','" . $clear_br9 . "','" . $clear_ivno9 . "','" . $jong_no9 . "','" . $jong_ckk9 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb7 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit7 . "','" . $unit7 . "','0.00','0.00','0.00','" . $sale_remarkk9 . "','0.00','0','0','0','" . $product_idb7 . "','" . $product_idb7 . "','1','" . $product_code9 . "','" . $have_order . "','" . $clear_br9 . "','" . $clear_ivno9 . "','" . $jong_no9 . "','" . $jong_ckk9 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb8 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit8 . "','" . $unit8 . "','0.00','0.00','0.00','" . $sale_remarkk9 . "','0.00','0','0','0','" . $product_idb8 . "','" . $product_idb8 . "','1','" . $product_code9 . "','" . $have_order . "','" . $clear_br9 . "','" . $clear_ivno9 . "','" . $jong_no9 . "','" . $jong_ckk9 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb9 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit9 . "','" . $unit9 . "','0.00','0.00','0.00','" . $sale_remarkk9 . "','0.00','0','0','0','" . $product_idb9 . "','" . $product_idb9 . "','1','" . $product_code9 . "','" . $have_order . "','" . $clear_br9 . "','" . $clear_ivno9 . "','" . $jong_no9 . "','" . $jong_ckk9 . "')";
				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb10 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit10 . "','" . $unit10 . "','0.00','0.00','0.00','" . $sale_remarkk9 . "','0.00','0','0','0','" . $product_idb10 . "','" . $product_idb10 . "','1','" . $product_code10 . "','" . $have_order . "','" . $clear_br9 . "','" . $clear_ivno9 . "','" . $jong_no9 . "','" . $jong_ckk9 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}
		} else {


			$strSQL9 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $sale_count9 . "','" . $sale_count9 . "','" . $product_price9 . "','" . $product_price9 . "','" . $sum_amount9 . "','" . $sale_remarkk9 . "','" . $discount_unit9 . "','" . $warranty9 . "','" . $cal9 . "','" . $pm9 . "','" . $product_id9 . "','" . $product_id9 . "','" . $have_order . "','" . $clear_br9 . "','" . $clear_ivno9 . "','" . $jong_no9 . "','" . $jong_ckk9 . "')";

			$objQuery9 = mysqli_query($conn, $strSQL9);
		}
	}


	if ($product_id10 != '') {

		$strSQL31 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '" . $product_code10 . "' ";
		$objQuery31 = mysqli_query($conn, $strSQL31) or die("Error Query [" . $strSQL31 . "]");
		$Num_Rows31 = mysqli_num_rows($objQuery31);
		$objResult31 = mysqli_fetch_array($objQuery31);

		$product_idb1 = $objResult31["product_id1"];
		$product_idb2 = $objResult31["product_id2"];
		$product_idb3 = $objResult31["product_id3"];
		$product_idb4 = $objResult31["product_id4"];
		$product_idb5 = $objResult31["product_id5"];
		$product_idb6 = $objResult31["product_id6"];
		$product_idb7 = $objResult31["product_id7"];
		$product_idb8 = $objResult31["product_id8"];
		$product_idb9 = $objResult31["product_id9"];
		$product_idb10 = $objResult31["product_id10"];


		$unit1 = $sale_count10 * $objResult31["unit1"];
		$unit2 = $sale_count10 * $objResult31["unit2"];
		$unit3 = $sale_count10 * $objResult31["unit3"];
		$unit4 = $sale_count10 * $objResult31["unit4"];
		$unit5 = $sale_count10 * $objResult31["unit5"];
		$unit6 = $sale_count10 * $objResult31["unit6"];
		$unit7 = $sale_count10 * $objResult31["unit7"];
		$unit8 = $sale_count10 * $objResult31["unit8"];
		$unit9 = $sale_count10 * $objResult31["unit9"];
		$unit10 = $sale_count10 * $objResult31["unit10"];

		if ($Num_Rows31 > 0) {

			if ($product_idb1 != '') {

				$strSQL104 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,code_bom,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit1 . "','" . $unit1 . "','" . $product_price10 . "','" . $product_price10 . "','" . $sum_amount10 . "','" . $sale_remarkk10 . "','" . $discount_unit10 . "','" . $warranty10 . "','" . $cal10 . "','" . $pm10 . "','" . $product_idb1 . "','" . $product_idb1 . "','" . $product_code10 . "','1','" . $product_code10 . "','" . $have_order . "','" . $clear_br10 . "','" . $clear_ivno10 . "','" . $jong_no10 . "','" . $jong_ckk10 . "')";

				$objQuery104 = mysqli_query($conn, $strSQL104);
			}

			if ($product_idb2 != '') {

				$strSQL100 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit2 . "','" . $unit2 . "','0.00','0.00','0.00','" . $sale_remarkk10 . "','0.00','0','0','0','" . $product_idb2 . "','" . $product_idb2 . "','1','" . $product_code10 . "','" . $have_order . "','" . $clear_br10 . "','" . $clear_ivno10 . "','" . $jong_no10 . "','" . $jong_ckk10 . "')";
				$objQuery100 = mysqli_query($conn, $strSQL100);
			}

			if ($product_idb3 != '') {

				$strSQL101 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit3 . "','" . $unit3 . "','0.00','0.00','0.00','" . $sale_remarkk10 . "','0.00','0','0','0','" . $product_idb3 . "','" . $product_idb3 . "','1','" . $product_code10 . "','" . $have_order . "','" . $clear_br10 . "','" . $clear_ivno10 . "','" . $jong_no10 . "','" . $jong_ckk10 . "')";

				$objQuery101 = mysqli_query($conn, $strSQL101);
			}

			if ($product_idb4 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit4 . "','" . $unit4 . "','0.00','0.00','0.00','" . $sale_remarkk10 . "','0.00','0','0','0','" . $product_idb4 . "','" . $product_idb4 . "','1','" . $product_code10 . "','" . $have_order . "','" . $clear_br10 . "','" . $clear_ivno10 . "','" . $jong_no10 . "','" . $jong_ckk10 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb5 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit5 . "','" . $unit5 . "','0.00','0.00','0.00','" . $sale_remarkk10 . "','0.00','0','0','0','" . $product_idb5 . "','" . $product_idb5 . "','1','" . $product_code10 . "','" . $have_order . "','" . $clear_br10 . "','" . $clear_ivno10 . "','" . $jong_no10 . "','" . $jong_ckk10 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb6 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit6 . "','" . $unit6 . "','0.00','0.00','0.00','" . $sale_remarkk10 . "','0.00','0','0','0','" . $product_idb6 . "','" . $product_idb6 . "','1','" . $product_code10 . "','" . $have_order . "','" . $clear_br10 . "','" . $clear_ivno10 . "','" . $jong_no10 . "','" . $jong_ckk10 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb7 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit7 . "','" . $unit7 . "','0.00','0.00','0.00','" . $sale_remarkk10 . "','0.00','0','0','0','" . $product_idb7 . "','" . $product_idb7 . "','1','" . $product_code10 . "','" . $have_order . "','" . $clear_br10 . "','" . $clear_ivno10 . "','" . $jong_no10 . "','" . $jong_ckk10 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb8 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit8 . "','" . $unit8 . "','0.00','0.00','0.00','" . $sale_remarkk10 . "','0.00','0','0','0','" . $product_idb8 . "','" . $product_idb8 . "','1','" . $product_code10 . "','" . $have_order . "','" . $clear_br10 . "','" . $clear_ivno10 . "','" . $jong_no10 . "','" . $jong_ckk10 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb9 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit9 . "','" . $unit9 . "','0.00','0.00','0.00','" . $sale_remarkk10 . "','0.00','0','0','0','" . $product_idb9 . "','" . $product_idb9 . "','1','" . $product_code10 . "','" . $have_order . "','" . $clear_br10 . "','" . $clear_ivno10 . "','" . $jong_no10 . "','" . $jong_ckk10 . "')";
				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb10 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit10 . "','" . $unit10 . "','0.00','0.00','0.00','" . $sale_remarkk10 . "','0.00','0','0','0','" . $product_idb10 . "','" . $product_idb10 . "','1','" . $product_code10 . "','" . $have_order . "','" . $clear_br10 . "','" . $clear_ivno10 . "','" . $jong_no10 . "','" . $jong_ckk10 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}
		} else {


			$strSQL10 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $sale_count10 . "','" . $sale_count10 . "','" . $product_price10 . "','" . $product_price10 . "','" . $sum_amount10 . "','" . $sale_remarkk10 . "','" . $discount_unit10 . "','" . $warranty10 . "','" . $cal10 . "','" . $pm10 . "','" . $product_id10 . "','" . $product_id10 . "','" . $have_order . "','" . $clear_br10 . "','" . $clear_ivno10 . "','" . $jong_no10 . "','" . $jong_ckk10 . "')";

			$objQuery10 = mysqli_query($conn, $strSQL10);
		}
	}


	////////////

	if ($product_id11 != '') {

		$strSQL31 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '" . $product_code11 . "' ";
		$objQuery31 = mysqli_query($conn, $strSQL31) or die("Error Query [" . $strSQL31 . "]");
		$Num_Rows31 = mysqli_num_rows($objQuery31);
		$objResult31 = mysqli_fetch_array($objQuery31);

		$product_idb1 = $objResult31["product_id1"];
		$product_idb2 = $objResult31["product_id2"];
		$product_idb3 = $objResult31["product_id3"];
		$product_idb4 = $objResult31["product_id4"];
		$product_idb5 = $objResult31["product_id5"];
		$product_idb6 = $objResult31["product_id6"];
		$product_idb7 = $objResult31["product_id7"];
		$product_idb8 = $objResult31["product_id8"];
		$product_idb9 = $objResult31["product_id9"];
		$product_idb10 = $objResult31["product_id10"];


		$unit1 = $sale_count11 * $objResult31["unit1"];
		$unit2 = $sale_count11 * $objResult31["unit2"];
		$unit3 = $sale_count11 * $objResult31["unit3"];
		$unit4 = $sale_count11 * $objResult31["unit4"];
		$unit5 = $sale_count11 * $objResult31["unit5"];
		$unit6 = $sale_count11 * $objResult31["unit6"];
		$unit7 = $sale_count11 * $objResult31["unit7"];
		$unit8 = $sale_count11 * $objResult31["unit8"];
		$unit9 = $sale_count11 * $objResult31["unit9"];
		$unit10 = $sale_count11 * $objResult31["unit10"];

		if ($Num_Rows31 > 0) {

			if ($product_idb1 != '') {

				$strSQL104 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,code_bom,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit1 . "','" . $unit1 . "','" . $product_price11 . "','" . $product_price11 . "','" . $sum_amount11 . "','" . $sale_remarkk11 . "','" . $discount_unit11 . "','" . $warranty11 . "','" . $cal11 . "','" . $pm11 . "','" . $product_idb1 . "','" . $product_idb1 . "','" . $product_code11 . "','1','" . $product_code11 . "','" . $have_order . "','" . $clear_br11 . "','" . $clear_ivno11 . "','" . $jong_no11 . "','" . $jong_ckk11 . "')";

				$objQuery104 = mysqli_query($conn, $strSQL104);
			}

			if ($product_idb2 != '') {

				$strSQL100 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit2 . "','" . $unit2 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb2 . "','" . $product_idb2 . "','1','" . $product_code11 . "','" . $have_order . "','" . $clear_br11 . "','" . $clear_ivno11 . "','" . $jong_no11 . "','" . $jong_ckk11 . "')";
				$objQuery100 = mysqli_query($conn, $strSQL100);
			}

			if ($product_idb3 != '') {

				$strSQL101 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit3 . "','" . $unit3 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb3 . "','" . $product_idb3 . "','1','" . $product_code11 . "','" . $have_order . "','" . $clear_br11 . "','" . $clear_ivno11 . "','" . $jong_no11 . "','" . $jong_ckk11 . "')";

				$objQuery101 = mysqli_query($conn, $strSQL101);
			}

			if ($product_idb4 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit4 . "','" . $unit4 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb4 . "','" . $product_idb4 . "','1','" . $product_code11 . "','" . $have_order . "','" . $clear_br11 . "','" . $clear_ivno11 . "','" . $jong_no11 . "','" . $jong_ckk11 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb5 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit5 . "','" . $unit5 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb5 . "','" . $product_idb5 . "','1','" . $product_code11 . "','" . $have_order . "','" . $clear_br11 . "','" . $clear_ivno11 . "','" . $jong_no11 . "','" . $jong_ckk11 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb6 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit6 . "','" . $unit6 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb6 . "','" . $product_idb6 . "','1','" . $product_code11 . "','" . $have_order . "','" . $clear_br11 . "','" . $clear_ivno11 . "','" . $jong_no11 . "','" . $jong_ckk11 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb7 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit7 . "','" . $unit7 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb7 . "','" . $product_idb7 . "','1','" . $product_code11 . "','" . $have_order . "','" . $clear_br11 . "','" . $clear_ivno11 . "','" . $jong_no11 . "','" . $jong_ckk11 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb8 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit8 . "','" . $unit8 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb8 . "','" . $product_idb8 . "','1','" . $product_code11 . "','" . $have_order . "','" . $clear_br11 . "','" . $clear_ivno11 . "','" . $jong_no11 . "','" . $jong_ckk11 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb9 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit9 . "','" . $unit9 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb9 . "','" . $product_idb9 . "','1','" . $product_code11 . "','" . $have_order . "','" . $clear_br11 . "','" . $clear_ivno11 . "','" . $jong_no11 . "','" . $jong_ckk11 . "')";
				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb10 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit10 . "','" . $unit10 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb10 . "','" . $product_idb10 . "','1','" . $product_code11 . "','" . $have_order . "','" . $clear_br11 . "','" . $clear_ivno11 . "','" . $jong_no11 . "','" . $jong_ckk11 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}
		} else {

			$strSQL11 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $sale_count11 . "','" . $sale_count11 . "','" . $product_price11 . "','" . $product_price11 . "','" . $sum_amount11 . "','" . $sale_remarkk11 . "','" . $discount_unit11 . "','" . $warranty11 . "','" . $cal11 . "','" . $pm11 . "','" . $product_id11 . "','" . $product_id11 . "','" . $have_order . "','" . $clear_br11 . "','" . $clear_ivno11 . "','" . $jong_no11 . "','" . $jong_ckk11 . "')";

			$objQuery11 = mysqli_query($conn, $strSQL11);
		}
	}

	if ($product_id12 != '') {

		$strSQL31 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '" . $product_code12 . "' ";
		$objQuery31 = mysqli_query($conn, $strSQL31) or die("Error Query [" . $strSQL31 . "]");
		$Num_Rows31 = mysqli_num_rows($objQuery31);
		$objResult31 = mysqli_fetch_array($objQuery31);

		$product_idb1 = $objResult31["product_id1"];
		$product_idb2 = $objResult31["product_id2"];
		$product_idb3 = $objResult31["product_id3"];
		$product_idb4 = $objResult31["product_id4"];
		$product_idb5 = $objResult31["product_id5"];
		$product_idb6 = $objResult31["product_id6"];
		$product_idb7 = $objResult31["product_id7"];
		$product_idb8 = $objResult31["product_id8"];
		$product_idb9 = $objResult31["product_id9"];
		$product_idb10 = $objResult31["product_id10"];


		$unit1 = $sale_count12 * $objResult31["unit1"];
		$unit2 = $sale_count12 * $objResult31["unit2"];
		$unit3 = $sale_count12 * $objResult31["unit3"];
		$unit4 = $sale_count12 * $objResult31["unit4"];
		$unit5 = $sale_count12 * $objResult31["unit5"];
		$unit6 = $sale_count12 * $objResult31["unit6"];
		$unit7 = $sale_count12 * $objResult31["unit7"];
		$unit8 = $sale_count12 * $objResult31["unit8"];
		$unit9 = $sale_count12 * $objResult31["unit9"];
		$unit10 = $sale_count12 * $objResult31["unit10"];

		if ($Num_Rows31 > 0) {

			if ($product_idb1 != '') {

				$strSQL104 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,code_bom,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit1 . "','" . $unit1 . "','" . $product_price12 . "','" . $product_price12 . "','" . $sum_amount12 . "','" . $sale_remarkk12 . "','" . $discount_unit12 . "','" . $warranty12 . "','" . $cal12 . "','" . $pm12 . "','" . $product_idb1 . "','" . $product_idb1 . "','" . $product_code12 . "','1','" . $product_code12 . "','" . $have_order . "','" . $clear_br12 . "','" . $clear_ivno12 . "','" . $jong_no12 . "','" . $jong_ckk12 . "')";

				$objQuery104 = mysqli_query($conn, $strSQL104);
			}

			if ($product_idb2 != '') {

				$strSQL100 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit2 . "','" . $unit2 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb2 . "','" . $product_idb2 . "','1','" . $product_code12 . "','" . $have_order . "','" . $clear_br12 . "','" . $clear_ivno12 . "','" . $jong_no12 . "','" . $jong_ckk12 . "')";
				$objQuery100 = mysqli_query($conn, $strSQL100);
			}

			if ($product_idb3 != '') {

				$strSQL101 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit3 . "','" . $unit3 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb3 . "','" . $product_idb3 . "','1','" . $product_code12 . "','" . $have_order . "','" . $clear_br12 . "','" . $clear_ivno12 . "','" . $jong_no12 . "','" . $jong_ckk12 . "')";

				$objQuery101 = mysqli_query($conn, $strSQL101);
			}

			if ($product_idb4 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit4 . "','" . $unit4 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb4 . "','" . $product_idb4 . "','1','" . $product_code12 . "','" . $have_order . "','" . $clear_br12 . "','" . $clear_ivno12 . "','" . $jong_no12 . "','" . $jong_ckk12 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb5 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit5 . "','" . $unit5 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb5 . "','" . $product_idb5 . "','1','" . $product_code12 . "','" . $have_order . "','" . $clear_br12 . "','" . $clear_ivno12 . "','" . $jong_no12 . "','" . $jong_ckk12 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb6 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit6 . "','" . $unit6 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb6 . "','" . $product_idb6 . "','1','" . $product_code12 . "','" . $have_order . "','" . $clear_br12 . "','" . $clear_ivno12 . "','" . $jong_no12 . "','" . $jong_ckk12 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb7 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit7 . "','" . $unit7 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb7 . "','" . $product_idb7 . "','1','" . $product_code12 . "','" . $have_order . "','" . $clear_br12 . "','" . $clear_ivno12 . "','" . $jong_no12 . "','" . $jong_ckk12 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb8 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit8 . "','" . $unit8 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb8 . "','" . $product_idb8 . "','1','" . $product_code12 . "','" . $have_order . "','" . $clear_br12 . "','" . $clear_ivno12 . "','" . $jong_no12 . "','" . $jong_ckk12 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb9 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit9 . "','" . $unit9 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb9 . "','" . $product_idb9 . "','1','" . $product_code12 . "','" . $have_order . "','" . $clear_br12 . "','" . $clear_ivno12 . "','" . $jong_no12 . "','" . $jong_ckk12 . "')";
				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb10 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit10 . "','" . $unit10 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb10 . "','" . $product_idb10 . "','1','" . $product_code12 . "','" . $have_order . "','" . $clear_br12 . "','" . $clear_ivno12 . "','" . $jong_no12 . "','" . $jong_ckk12 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}
		} else {

			$strSQL12 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $sale_count12 . "','" . $sale_count12 . "','" . $product_price12 . "','" . $product_price12 . "','" . $sum_amount12 . "','" . $sale_remarkk12 . "','" . $discount_unit12 . "','" . $warranty12 . "','" . $cal12 . "','" . $pm12 . "','" . $product_id12 . "','" . $product_id12 . "','" . $have_order . "','" . $clear_br12 . "','" . $clear_ivno12 . "','" . $jong_no12 . "','" . $jong_ckk12 . "')";

			$objQuery12 = mysqli_query($conn, $strSQL12);
		}
	}

	if ($product_id13 != '') {

		$strSQL31 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '" . $product_code13 . "' ";
		$objQuery31 = mysqli_query($conn, $strSQL31) or die("Error Query [" . $strSQL31 . "]");
		$Num_Rows31 = mysqli_num_rows($objQuery31);
		$objResult31 = mysqli_fetch_array($objQuery31);

		$product_idb1 = $objResult31["product_id1"];
		$product_idb2 = $objResult31["product_id2"];
		$product_idb3 = $objResult31["product_id3"];
		$product_idb4 = $objResult31["product_id4"];
		$product_idb5 = $objResult31["product_id5"];
		$product_idb6 = $objResult31["product_id6"];
		$product_idb7 = $objResult31["product_id7"];
		$product_idb8 = $objResult31["product_id8"];
		$product_idb9 = $objResult31["product_id9"];
		$product_idb10 = $objResult31["product_id10"];


		$unit1 = $sale_count13 * $objResult31["unit1"];
		$unit2 = $sale_count13 * $objResult31["unit2"];
		$unit3 = $sale_count13 * $objResult31["unit3"];
		$unit4 = $sale_count13 * $objResult31["unit4"];
		$unit5 = $sale_count13 * $objResult31["unit5"];
		$unit6 = $sale_count13 * $objResult31["unit6"];
		$unit7 = $sale_count13 * $objResult31["unit7"];
		$unit8 = $sale_count13 * $objResult31["unit8"];
		$unit9 = $sale_count13 * $objResult31["unit9"];
		$unit10 = $sale_count13 * $objResult31["unit10"];

		if ($Num_Rows31 > 0) {

			if ($product_idb1 != '') {

				$strSQL104 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,code_bom,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit1 . "','" . $unit1 . "','" . $product_price13 . "','" . $product_price13 . "','" . $sum_amount13 . "','" . $sale_remarkk13 . "','" . $discount_unit13 . "','" . $warranty13 . "','" . $cal13 . "','" . $pm13 . "','" . $product_idb1 . "','" . $product_idb1 . "','" . $product_code13 . "','1','" . $product_code13 . "','" . $have_order . "','" . $clear_br13 . "','" . $clear_ivno13 . "','" . $jong_no13 . "','" . $jong_ckk13 . "')";

				$objQuery104 = mysqli_query($conn, $strSQL104);
			}

			if ($product_idb2 != '') {

				$strSQL100 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit2 . "','" . $unit2 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb2 . "','" . $product_idb2 . "','1','" . $product_code13 . "','" . $have_order . "','" . $clear_br13 . "','" . $clear_ivno13 . "','" . $jong_no13 . "','" . $jong_ckk13 . "')";
				$objQuery100 = mysqli_query($conn, $strSQL100);
			}

			if ($product_idb3 != '') {

				$strSQL101 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit3 . "','" . $unit3 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb3 . "','" . $product_idb3 . "','1','" . $product_code13 . "','" . $have_order . "','" . $clear_br13 . "','" . $clear_ivno13 . "','" . $jong_no13 . "','" . $jong_ckk13 . "')";

				$objQuery101 = mysqli_query($conn, $strSQL101);
			}

			if ($product_idb4 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit4 . "','" . $unit4 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb4 . "','" . $product_idb4 . "','1','" . $product_code13 . "','" . $have_order . "','" . $clear_br13 . "','" . $clear_ivno13 . "','" . $jong_no13 . "','" . $jong_ckk13 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb5 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit5 . "','" . $unit5 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb5 . "','" . $product_idb5 . "','1','" . $product_code13 . "','" . $have_order . "','" . $clear_br13 . "','" . $clear_ivno13 . "','" . $jong_no13 . "','" . $jong_ckk13 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb6 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit6 . "','" . $unit6 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb6 . "','" . $product_idb6 . "','1','" . $product_code13 . "','" . $have_order . "','" . $clear_br13 . "','" . $clear_ivno13 . "','" . $jong_no13 . "','" . $jong_ckk13 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb7 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit7 . "','" . $unit7 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb7 . "','" . $product_idb7 . "','1','" . $product_code13 . "','" . $have_order . "','" . $clear_br13 . "','" . $clear_ivno13 . "','" . $jong_no13 . "','" . $jong_ckk13 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb8 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit8 . "','" . $unit8 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb8 . "','" . $product_idb8 . "','1','" . $product_code13 . "','" . $have_order . "','" . $clear_br13 . "','" . $clear_ivno13 . "','" . $jong_no13 . "','" . $jong_ckk13 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb9 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit9 . "','" . $unit9 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb9 . "','" . $product_idb9 . "','1','" . $product_code13 . "','" . $have_order . "','" . $clear_br13 . "','" . $clear_ivno13 . "','" . $jong_no13 . "','" . $jong_ckk13 . "')";
				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb10 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit10 . "','" . $unit10 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb10 . "','" . $product_idb10 . "','1','" . $product_code13 . "','" . $have_order . "','" . $clear_br13 . "','" . $clear_ivno13 . "','" . $jong_no13 . "','" . $jong_ckk13 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}
		} else {

			$strSQL13 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $sale_count13 . "','" . $sale_count13 . "','" . $product_price13 . "','" . $product_price13 . "','" . $sum_amount13 . "','" . $sale_remarkk13 . "','" . $discount_unit13 . "','" . $warranty13 . "','" . $cal13 . "','" . $pm13 . "','" . $product_id13 . "','" . $product_id13 . "','" . $have_order . "','" . $clear_br13 . "','" . $clear_ivno13 . "','" . $jong_no13 . "','" . $jong_ckk13 . "')";

			$objQuery13 = mysqli_query($conn, $strSQL13);
		}
	}

	if ($product_id14 != '') {

		$strSQL31 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '" . $product_code14 . "' ";
		$objQuery31 = mysqli_query($conn, $strSQL31) or die("Error Query [" . $strSQL31 . "]");
		$Num_Rows31 = mysqli_num_rows($objQuery31);
		$objResult31 = mysqli_fetch_array($objQuery31);

		$product_idb1 = $objResult31["product_id1"];
		$product_idb2 = $objResult31["product_id2"];
		$product_idb3 = $objResult31["product_id3"];
		$product_idb4 = $objResult31["product_id4"];
		$product_idb5 = $objResult31["product_id5"];
		$product_idb6 = $objResult31["product_id6"];
		$product_idb7 = $objResult31["product_id7"];
		$product_idb8 = $objResult31["product_id8"];
		$product_idb9 = $objResult31["product_id9"];
		$product_idb10 = $objResult31["product_id10"];


		$unit1 = $sale_count14 * $objResult31["unit1"];
		$unit2 = $sale_count14 * $objResult31["unit2"];
		$unit3 = $sale_count14 * $objResult31["unit3"];
		$unit4 = $sale_count14 * $objResult31["unit4"];
		$unit5 = $sale_count14 * $objResult31["unit5"];
		$unit6 = $sale_count14 * $objResult31["unit6"];
		$unit7 = $sale_count14 * $objResult31["unit7"];
		$unit8 = $sale_count14 * $objResult31["unit8"];
		$unit9 = $sale_count14 * $objResult31["unit9"];
		$unit10 = $sale_count14 * $objResult31["unit10"];

		if ($Num_Rows31 > 0) {

			if ($product_idb1 != '') {

				$strSQL104 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,code_bom,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit1 . "','" . $unit1 . "','" . $product_price14 . "','" . $product_price14 . "','" . $sum_amount14 . "','" . $sale_remarkk14 . "','" . $discount_unit14 . "','" . $warranty14 . "','" . $cal14 . "','" . $pm14 . "','" . $product_idb1 . "','" . $product_idb1 . "','" . $product_code14 . "','1','" . $product_code14 . "','" . $have_order . "','" . $clear_br14 . "','" . $clear_ivno14 . "','" . $jong_no14 . "','" . $jong_ckk14 . "')";

				$objQuery104 = mysqli_query($conn, $strSQL104);
			}

			if ($product_idb2 != '') {

				$strSQL100 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit2 . "','" . $unit2 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb2 . "','" . $product_idb2 . "','1','" . $product_code14 . "','" . $have_order . "','" . $clear_br14 . "','" . $clear_ivno14 . "','" . $jong_no14 . "','" . $jong_ckk14 . "')";
				$objQuery100 = mysqli_query($conn, $strSQL100);
			}

			if ($product_idb3 != '') {

				$strSQL101 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit3 . "','" . $unit3 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb3 . "','" . $product_idb3 . "','1','" . $product_code14 . "','" . $have_order . "','" . $clear_br14 . "','" . $clear_ivno14 . "','" . $jong_no14 . "','" . $jong_ckk14 . "')";

				$objQuery101 = mysqli_query($conn, $strSQL101);
			}

			if ($product_idb4 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit4 . "','" . $unit4 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb4 . "','" . $product_idb4 . "','1','" . $product_code14 . "','" . $have_order . "','" . $clear_br14 . "','" . $clear_ivno14 . "','" . $jong_no14 . "','" . $jong_ckk14 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb5 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit5 . "','" . $unit5 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb5 . "','" . $product_idb5 . "','1','" . $product_code14 . "','" . $have_order . "','" . $clear_br14 . "','" . $clear_ivno14 . "','" . $jong_no14 . "','" . $jong_ckk14 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb6 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit6 . "','" . $unit6 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb6 . "','" . $product_idb6 . "','1','" . $product_code14 . "','" . $have_order . "','" . $clear_br14 . "','" . $clear_ivno14 . "','" . $jong_no14 . "','" . $jong_ckk14 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb7 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit7 . "','" . $unit7 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb7 . "','" . $product_idb7 . "','1','" . $product_code14 . "','" . $have_order . "','" . $clear_br14 . "','" . $clear_ivno14 . "','" . $jong_no14 . "','" . $jong_ckk14 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb8 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit8 . "','" . $unit8 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb8 . "','" . $product_idb8 . "','1','" . $product_code14 . "','" . $have_order . "','" . $clear_br14 . "','" . $clear_ivno14 . "','" . $jong_no14 . "','" . $jong_ckk14 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb9 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit9 . "','" . $unit9 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb9 . "','" . $product_idb9 . "','1','" . $product_code14 . "','" . $have_order . "','" . $clear_br14 . "','" . $clear_ivno14 . "','" . $jong_no14 . "','" . $jong_ckk14 . "')";
				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb10 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit10 . "','" . $unit10 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb10 . "','" . $product_idb10 . "','1','" . $product_code14 . "','" . $have_order . "','" . $clear_br14 . "','" . $clear_ivno14 . "','" . $jong_no14 . "','" . $jong_ckk14 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}
		} else {


			$strSQL14 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $sale_count14 . "','" . $sale_count14 . "','" . $product_price14 . "','" . $product_price14 . "','" . $sum_amount14 . "','" . $sale_remarkk14 . "','" . $discount_unit14 . "','" . $warranty14 . "','" . $cal14 . "','" . $pm14 . "','" . $product_id14 . "','" . $product_id14 . "','" . $have_order . "','" . $clear_br14 . "','" . $clear_ivno14 . "','" . $jong_no14 . "','" . $jong_ckk14 . "')";
			$objQuery14 = mysqli_query($conn, $strSQL14);
		}
	}

	if ($product_id15 != '') {

		$strSQL31 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '" . $product_code15 . "' ";
		$objQuery31 = mysqli_query($conn, $strSQL31) or die("Error Query [" . $strSQL31 . "]");
		$Num_Rows31 = mysqli_num_rows($objQuery31);
		$objResult31 = mysqli_fetch_array($objQuery31);

		$product_idb1 = $objResult31["product_id1"];
		$product_idb2 = $objResult31["product_id2"];
		$product_idb3 = $objResult31["product_id3"];
		$product_idb4 = $objResult31["product_id4"];
		$product_idb5 = $objResult31["product_id5"];
		$product_idb6 = $objResult31["product_id6"];
		$product_idb7 = $objResult31["product_id7"];
		$product_idb8 = $objResult31["product_id8"];
		$product_idb9 = $objResult31["product_id9"];
		$product_idb10 = $objResult31["product_id10"];


		$unit1 = $sale_count15 * $objResult31["unit1"];
		$unit2 = $sale_count15 * $objResult31["unit2"];
		$unit3 = $sale_count15 * $objResult31["unit3"];
		$unit4 = $sale_count15 * $objResult31["unit4"];
		$unit5 = $sale_count15 * $objResult31["unit5"];
		$unit6 = $sale_count15 * $objResult31["unit6"];
		$unit7 = $sale_count15 * $objResult31["unit7"];
		$unit8 = $sale_count15 * $objResult31["unit8"];
		$unit9 = $sale_count15 * $objResult31["unit9"];
		$unit10 = $sale_count15 * $objResult31["unit10"];

		if ($Num_Rows31 > 0) {

			if ($product_idb1 != '') {

				$strSQL104 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,code_bom,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit1 . "','" . $unit1 . "','" . $product_price15 . "','" . $product_price15 . "','" . $sum_amount15 . "','" . $sale_remarkk15 . "','" . $discount_unit15 . "','" . $warranty15 . "','" . $cal15 . "','" . $pm15 . "','" . $product_idb1 . "','" . $product_idb1 . "','" . $product_code15 . "','1','" . $product_code15 . "','" . $have_order . "','" . $clear_br15 . "','" . $clear_ivno15 . "','" . $jong_no15 . "','" . $jong_ckk15 . "')";

				$objQuery104 = mysqli_query($conn, $strSQL104);
			}

			if ($product_idb2 != '') {

				$strSQL100 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit2 . "','" . $unit2 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb2 . "','" . $product_idb2 . "','1','" . $product_code15 . "','" . $have_order . "','" . $clear_br15 . "','" . $clear_ivno15 . "','" . $jong_no15 . "','" . $jong_ckk15 . "')";
				$objQuery100 = mysqli_query($conn, $strSQL100);
			}

			if ($product_idb3 != '') {

				$strSQL101 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit3 . "','" . $unit3 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb3 . "','" . $product_idb3 . "','1','" . $product_code15 . "','" . $have_order . "','" . $clear_br15 . "','" . $clear_ivno15 . "','" . $jong_no15 . "','" . $jong_ckk15 . "')";

				$objQuery101 = mysqli_query($conn, $strSQL101);
			}

			if ($product_idb4 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit4 . "','" . $unit4 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb4 . "','" . $product_idb4 . "','1','" . $product_code15 . "','" . $have_order . "','" . $clear_br15 . "','" . $clear_ivno15 . "','" . $jong_no15 . "','" . $jong_ckk15 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb5 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit5 . "','" . $unit5 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb5 . "','" . $product_idb5 . "','1','" . $product_code15 . "','" . $have_order . "','" . $clear_br15 . "','" . $clear_ivno15 . "','" . $jong_no15 . "','" . $jong_ckk15 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb6 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit6 . "','" . $unit6 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb6 . "','" . $product_idb6 . "','1','" . $product_code15 . "','" . $have_order . "','" . $clear_br15 . "','" . $clear_ivno15 . "','" . $jong_no15 . "','" . $jong_ckk15 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb7 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit7 . "','" . $unit7 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb7 . "','" . $product_idb7 . "','1','" . $product_code15 . "','" . $have_order . "','" . $clear_br15 . "','" . $clear_ivno15 . "','" . $jong_no15 . "','" . $jong_ckk15 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb8 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit8 . "','" . $unit8 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb8 . "','" . $product_idb8 . "','1','" . $product_code15 . "','" . $have_order . "','" . $clear_br15 . "','" . $clear_ivno15 . "','" . $jong_no15 . "','" . $jong_ckk15 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb9 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit9 . "','" . $unit9 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb9 . "','" . $product_idb9 . "','1','" . $product_code15 . "','" . $have_order . "','" . $clear_br15 . "','" . $clear_ivno15 . "','" . $jong_no15 . "','" . $jong_ckk15 . "')";
				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb10 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $unit10 . "','" . $unit10 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb10 . "','" . $product_idb10 . "','1','" . $product_code15 . "','" . $have_order . "','" . $clear_br15 . "','" . $clear_ivno15 . "','" . $jong_no15 . "','" . $jong_ckk15 . "')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}
		} else {



			$strSQL15 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk)
values ('" . $ref_id . "','" . $sale_count15 . "','" . $sale_count15 . "','" . $product_price15 . "','" . $product_price15 . "','" . $sum_amount15 . "','" . $sale_remarkk15 . "','" . $discount_unit15 . "','" . $warranty15 . "','" . $cal15 . "','" . $pm15 . "','" . $product_id15 . "','" . $product_id15 . "','" . $have_order . "','" . $clear_br15 . "','" . $clear_ivno15 . "','" . $jong_no15 . "','" . $jong_ckk15 . "')";

			$objQuery15 = mysqli_query($conn, $strSQL15);
		}
	}






	if ($product_id16 !== '') {

		$strSQL16 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('" . $ref_id . "','" . $sale_count16 . "','" . $sale_count16 . "','" . $product_price16 . "','" . $product_price16 . "','" . $sum_amount16 . "','" . $sale_remarkk16 . "','" . $discount_unit16 . "','" . $warranty16 . "','" . $cal16 . "','" . $pm16 . "','" . $product_id16 . "','" . $product_id16 . "')";
		//echo $strSQL1;
		//exit();

		$objQuery16 = mysqli_query($conn, $strSQL16);
	}


	if ($product_id17 !== '') {

		$strSQL17 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('" . $ref_id . "','" . $sale_count17 . "','" . $sale_count17 . "','" . $product_price17 . "','" . $product_price17 . "','" . $sum_amount17 . "','" . $sale_remarkk17 . "','" . $discount_unit17 . "','" . $warranty17 . "','" . $cal17 . "','" . $pm17 . "','" . $product_id17 . "','" . $product_id17 . "')";
		//echo $strSQL2;
		//exit();

		$objQuery17 = mysqli_query($conn, $strSQL17);
	}


	if ($product_id18 !== '') {

		$strSQL18 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('" . $ref_id . "','" . $sale_count18 . "','" . $sale_count18 . "','" . $product_price18 . "','" . $product_price18 . "','" . $sum_amount18 . "','" . $sale_remarkk18 . "','" . $discount_unit18 . "','" . $warranty18 . "','" . $cal18 . "','" . $pm18 . "','" . $product_id18 . "','" . $product_id18 . "')";
		//echo $strSQL3;
		//exit();

		$objQuery18 = mysqli_query($conn, $strSQL18);
	}


	if ($product_id19 !== '') {

		$strSQL19 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('" . $ref_id . "','" . $sale_count19 . "','" . $sale_count19 . "','" . $product_price19 . "','" . $product_price19 . "','" . $sum_amount19 . "','" . $sale_remarkk19 . "','" . $discount_unit19 . "','" . $warranty19 . "','" . $cal19 . "','" . $pm19 . "','" . $product_id19 . "','" . $product_id19 . "')";
		//echo $strSQL1;
		//exit();

		$objQuery19 = mysqli_query($conn, $strSQL19);
	}


	if ($product_id20 !== '') {

		$strSQL20 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('" . $ref_id . "','" . $sale_count20 . "','" . $sale_count20 . "','" . $product_price20 . "','" . $product_price20 . "','" . $sum_amount20 . "','" . $sale_remarkk20 . "','" . $discount_unit20 . "','" . $warranty20 . "','" . $cal20 . "','" . $pm20 . "','" . $product_id20 . "','" . $product_id20 . "')";
		//echo $strSQL1;
		//exit();

		$objQuery20 = mysqli_query($conn, $strSQL20);
	}


	if ($product_id21 !== '') {

		$strSQL21 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('" . $ref_id . "','" . $sale_count21 . "','" . $sale_count21 . "','" . $product_price21 . "','" . $product_price21 . "','" . $sum_amount21 . "','" . $sale_remarkk21 . "','" . $discount_unit21 . "','" . $warranty21 . "','" . $cal21 . "','" . $pm21 . "','" . $product_id21 . "','" . $product_id21 . "')";
		//echo $strSQL1;
		//exit();

		$objQuery21 = mysqli_query($conn, $strSQL21);
	}


	if ($product_id22 !== '') {

		$strSQL22 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('" . $ref_id . "','" . $sale_count22 . "','" . $sale_count22 . "','" . $product_price22 . "','" . $product_price22 . "','" . $sum_amount22 . "','" . $sale_remarkk22 . "','" . $discount_unit22 . "','" . $warranty22 . "','" . $cal22 . "','" . $pm22 . "','" . $product_id22 . "','" . $product_id22 . "')";
		//echo $strSQL1;
		//exit();

		$objQuery22 = mysqli_query($conn, $strSQL22);
	}


	if ($product_id23 !== '') {

		$strSQL23 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('" . $ref_id . "','" . $sale_count23 . "','" . $sale_count23 . "','" . $product_price23 . "','" . $product_price23 . "','" . $sum_amount23 . "','" . $sale_remarkk23 . "','" . $discount_unit23 . "','" . $warranty23 . "','" . $cal23 . "','" . $pm23 . "','" . $product_id23 . "','" . $product_id23 . "')";
		//echo $strSQL1;
		//exit();

		$objQuery23 = mysqli_query($conn, $strSQL23);
	}


	if ($product_id24 !== '') {

		$strSQL24 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('" . $ref_id . "','" . $sale_count24 . "','" . $sale_count24 . "','" . $product_price24 . "','" . $product_price24 . "','" . $sum_amount24 . "','" . $sale_remarkk24 . "','" . $discount_unit24 . "','" . $warranty24 . "','" . $cal24 . "','" . $pm24 . "','" . $product_id24 . "','" . $product_id24 . "')";
		//echo $strSQL1;
		//exit();

		$objQuery24 = mysqli_query($conn, $strSQL24);
	}


	if ($product_id25 !== '') {

		$strSQL25 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('" . $ref_id . "','" . $sale_count25 . "','" . $sale_count25 . "','" . $product_price25 . "','" . $product_price25 . "','" . $sum_amount25 . "','" . $sale_remarkk25 . "','" . $discount_unit25 . "','" . $warranty25 . "','" . $cal25 . "','" . $pm25 . "','" . $product_id25 . "','" . $product_id25 . "')";
		//echo $strSQL1;
		//exit();

		$objQuery25 = mysqli_query($conn, $strSQL25);
	}


	////////////

	if ($product_id26 !== '') {

		$strSQL26 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('" . $ref_id . "','" . $sale_count26 . "','" . $sale_count26 . "','" . $product_price26 . "','" . $product_price26 . "','" . $sum_amount26 . "','" . $sale_remarkk26 . "','" . $discount_unit26 . "','" . $warranty26 . "','" . $cal26 . "','" . $pm26 . "','" . $product_id26 . "','" . $product_id26 . "')";
		//echo $strSQL1;
		//exit();

		$objQuery26 = mysqli_query($conn, $strSQL26);
	}

	if ($product_id27 !== '') {

		$strSQL27 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('" . $ref_id . "','" . $sale_count27 . "','" . $sale_count27 . "','" . $product_price27 . "','" . $product_price27 . "','" . $sum_amount27 . "','" . $sale_remarkk27 . "','" . $discount_unit27 . "','" . $warranty27 . "','" . $cal27 . "','" . $pm27 . "','" . $product_id27 . "','" . $product_id27 . "')";
		//echo $strSQL1;
		//exit();

		$objQuery27 = mysqli_query($conn, $strSQL27);
	}

	if ($product_id28 !== '') {

		$strSQL28 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('" . $ref_id . "','" . $sale_count28 . "','" . $sale_count28 . "','" . $product_price28 . "','" . $product_price28 . "','" . $sum_amount28 . "','" . $sale_remarkk28 . "','" . $discount_unit28 . "','" . $warranty28 . "','" . $cal28 . "','" . $pm28 . "','" . $product_id28 . "','" . $product_id28 . "')";
		//echo $strSQL1;
		//exit();

		$objQuery28 = mysqli_query($conn, $strSQL28);
	}

	if ($product_id29 !== '') {

		$strSQL29 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('" . $ref_id . "','" . $sale_count29 . "','" . $sale_count29 . "','" . $product_price29 . "','" . $product_price29 . "','" . $sum_amount29 . "','" . $sale_remarkk29 . "','" . $discount_unit29 . "','" . $warranty29 . "','" . $cal29 . "','" . $pm29 . "','" . $product_id29 . "','" . $product_id29 . "')";
		//echo $strSQL1;
		//exit();

		$objQuery29 = mysqli_query($conn, $strSQL29);
	}

	if ($product_id30 !== '') {

		$strSQL30 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code)
values ('" . $ref_id . "','" . $sale_count30 . "','" . $sale_count30 . "','" . $product_price30 . "','" . $product_price30 . "','" . $sum_amount30 . "','" . $sale_remarkk30 . "','" . $discount_unit30 . "','" . $warranty30 . "','" . $cal30 . "','" . $pm30 . "','" . $product_id30 . "','" . $product_id30 . "')";
		//echo $strSQL1;
		//exit();

		$objQuery30 = mysqli_query($conn, $strSQL30);
	}

	$productExtraRows = array();
	for ($productExtraIndex = 1; $productExtraIndex <= 30; $productExtraIndex++) {
		$productExtraId = trim((string)($_POST['product_id' . $productExtraIndex] ?? ''));
		if ($productExtraId === '') {
			continue;
		}

		$productExtraRows[] = array(
			'pm_year' => trim((string)($_POST['pm_year' . $productExtraIndex] ?? '')),
			'admin_remark' => trim((string)($_POST['display_name' . $productExtraIndex] ?? ''))
		);
	}

	if (count($productExtraRows) > 0) {
		$safeRefIdForProductExtras = mysqli_real_escape_string($conn, $ref_id);
		$productExtraQuery = mysqli_query($conn, "SELECT id FROM hos__subso WHERE ref_idd = '" . $safeRefIdForProductExtras . "' AND COALESCE(bom_ckk, '0') <> '1' ORDER BY id ASC");
		$productExtraIndex = 0;
		$canUpdatePmYear = hosSubsoColumnExists($conn, 'pm_year');
		$canUpdateAdminRemark = hosSubsoColumnExists($conn, 'admin_remark');

		if ($productExtraQuery && ($canUpdatePmYear || $canUpdateAdminRemark)) {
			while ($productExtraRow = mysqli_fetch_assoc($productExtraQuery)) {
				if (!isset($productExtraRows[$productExtraIndex])) {
					break;
				}

				$safeSubsoId = (int)$productExtraRow['id'];
				$updateParts = array();
				if ($canUpdatePmYear) {
					$safePmYear = mysqli_real_escape_string($conn, $productExtraRows[$productExtraIndex]['pm_year']);
					$updateParts[] = "pm_year = '" . $safePmYear . "'";
				}
				if ($canUpdateAdminRemark) {
					$safeAdminRemark = mysqli_real_escape_string($conn, $productExtraRows[$productExtraIndex]['admin_remark']);
					$updateParts[] = "admin_remark = '" . $safeAdminRemark . "'";
				}
				if (!empty($updateParts)) {
					mysqli_query($conn, "UPDATE hos__subso SET " . implode(', ', $updateParts) . " WHERE id = " . $safeSubsoId);
				}
				$productExtraIndex++;
			}
		}
	}


	$strSQL29 = "SELECT SUM(amount) AS unit_cash FROM hos__subso WHERE ref_idd = '" . $ref_id . "' ";
	$objQuery29 = mysqli_query($conn, $strSQL29) or die("Error Query [" . $strSQL29 . "]");
	$rs = mysqli_fetch_assoc($objQuery29);

	$amount = $rs["unit_cash"];



	$start_date = $_POST["start_date"];

	$between_date = $_POST["between_date"];
	$start_time = $_POST["start_time"];
	$end_time = $_POST["end_time"];
	$status = $_POST["status"];

	if ($_POST["start_date"] != '') {
		$start_date = $_POST["start_date"];
	} else {
		$start_date = '0000-00-00';
	}

	if ($_POST['fix_datetime'] != '') {
		$fix_date = $_POST['fix_datetime'];
	} else {
		$fix_date = '0';
	}

	if ($_POST['no_money'] != '') {
		$no_price = $_POST['no_money'];
	} else {
		$no_price = '0';
	}
	if ($_POST['call_customer'] != '') {
		$call_customer = $_POST['call_customer'];
	} else {
		$call_customer = '0';
	}
	if ($_POST['credit_card'] != '') {
		$credit = $_POST['credit_card'];
		$unit_credit = $amount;
	} else {
		$credit = '0';
		$unit_credit = $_POST["unit_credit"];
	}

	if ($_POST['want_bus'] != '') {
		$want_bus = $_POST['want_bus'];
	} else {
		$want_bus = '0';
	}
	if ($_POST['call_back'] != '') {
		$call_employee = $_POST['call_back'];
	} else {
		$call_employee = '0';
	}

	if ($_POST['cash'] != '') {
		$chash = $_POST['cash'];
		$price = $amount;
	} else {
		$chash = '0';
		$price = $_POST["unit_cash"];
	}

	if ($_POST['check_paper'] != '') {
		$check_peper = $_POST['check_paper'];
		$unit_check1 = $amount;
	} else {
		$check_peper = '0';
		$unit_check1 = $_POST["unit_check"];
	}

	if ($_POST['bill'] != '') {
		$bill = $_POST['bill'];
		$unit_bill1 = $amount;
	} else {
		$bill = '0';
		$unit_bill1 = $_POST["unit_bill"];
	}

	if ($_POST['tran'] != '') {
		$tran = $_POST["tran"];
		$unit_tran = $amount;
	} else {
		$tran = '0';
		$unit_tran = $_POST["unit_tran"];
	}

	$unit_bill = isset($unit_bill1) ? $unit_bill1 : '';
	$unit_check = isset($unit_check1) ? $unit_check1 : '';





	if ($_POST['dep'] != '') {
		$dep = $_POST["dep"];
	} else {
		$dep = '0';
	}


	$department = $_POST["department_name"];
	$type_customer = $_POST["customer_typename"];

	if ($type_doc == '3') {
		$type_company = 'ออลล์เวล ไลฟ์ บจก.';
	} else if ($type_doc == '4') {
		$type_company = 'โนเบิล เมด บจก.';
	}

	$customer_name = $_POST["customer_name"];
	$customer_tel = $_POST["customer_tel"];
	$address_name = $_POST["address_name"];
	$address_1 = $_POST["address_1"];
	$address_send = $_POST["address_send"];
	$customer_contact = $_POST["customer_contact"];
	$mk_research = $_POST["mk_research"];
	$on_time = $_POST["on_time"];
	$amphur_name = $_POST["amphur_name"];
	$province_name = $_POST["province_name"];
	$product_sn = $_POST["product_sn"];

	if ($brnp_no != '') {
		$product_name = "เคลียร์ยืม เลขที่ $brnp_no $product_name1 $sale_remarkk1 $sale_count1 $unit_name1 $product_name2 $sale_remarkk2 $sale_count2 $unit_name2 $product_name3 $sale_remarkk3 $sale_count3 $unit_name3 $product_name4 $sale_remarkk4 $sale_count4 $unit_name4  $product_name5 $sale_remarkk5 $sale_count5 $unit_name5  $product_name6 $sale_remarkk6 $sale_count6 $unit_name6 $product_name7 $sale_remarkk7 $sale_count7 $unit_name7 $address_name";
	} else {
		$product_name = "ส่ง $product_name1 $sale_remarkk1 $sale_count1 $unit_name1 $product_name2 $sale_remarkk2 $sale_count2 $unit_name2 $product_name3 $sale_remarkk3 $sale_count3 $unit_name3 $product_name4 $sale_remarkk4 $sale_count4 $unit_name4  $product_name5 $sale_remarkk5 $sale_count5 $unit_name5  $product_name6 $sale_remarkk6 $sale_count6 $unit_name6 $product_name7 $sale_remarkk7 $sale_count7 $unit_name7 $address_name";
	}

	$employee_name = $_POST["employee_name"];
	$h_employee_name = $_POST["h_employee_name"];
	$employee_tel = $_POST["employee_tel"];
	$add_by = $_POST["add_by"];
	$description = $_POST["status_comment"];
	$havemap = $_POST['have_map'];
	$department_show = $_POST["department_show"];

	$dept = $_POST["dept"];
	$status_comment = $_POST["status_comment"];

	if ($_POST['runway'] != '') {
		$runway = $_POST["runway"];
	} else {
		$runway = '0';
	}

	if ($_POST['road'] != '') {
		$road = $_POST["road"];
	} else {
		$road = '0';
	}

	if ($_POST['soy'] != '') {
		$soy = $_POST["soy"];
	} else {
		$soy = '0';
	}

	if ($_POST['car_load'] != '') {
		$car_load = $_POST["car_load"];
	} else {
		$car_load = '0';
	}

	if ($_POST['no_car_road'] != '') {
		$no_car_road = $_POST["no_car_road"];
	} else {
		$no_car_road = '0';
	}

	if ($_POST['car_road'] != '') {
		$car_road = $_POST["car_road"];
	} else {
		$car_road = '0';
	}
	if ($_POST['car_home'] != '') {
		$car_home = $_POST["car_home"];
	} else {
		$car_home = '0';
	}

	if ($_POST['slope'] != '') {
		$slope = $_POST["slope"];
	} else {
		$slope = '0';
	}


	if ($_POST['bundai'] != '') {
		$bundai = $_POST["bundai"];
	} else {
		$bundai = '0';
	}

	if ($_POST['bundai_install'] != '') {
		$bundai_install = $_POST["bundai_install"];
	} else {
		$bundai_install = '0';
	}

	if ($_POST['lip'] != '') {
		$lip = $_POST["lip"];
	} else {
		$lip = '0';
	}


	if ($_POST['want_employee'] != '') {
		$want_employee = $_POST["want_employee"];
	} else {
		$want_employee = '0';
	}

	if ($_POST['want_ex'] != '') {
		$want_ex = $_POST["want_ex"];
	} else {
		$want_ex = '0';
	}


	if ($_POST['want_credit'] != '') {
		$want_credit = $_POST["want_credit"];
	} else {
		$want_credit = '0';
	}
	if ($_POST['want_prem'] != '') {
		$want_prem = $_POST["want_prem"];
	} else {
		$want_prem = '0';
	}

	if ($_POST['head_bad'] != '') {
		$head_bad = $_POST["head_bad"];
	} else {
		$head_bad = '0';
	}


	if ($_POST['height_ltd'] != '') {
		$height_ltd = $_POST["height_ltd"];
	} else {
		$height_ltd = '0';
	}
	if ($_POST['up'] != '') {
		$up = $_POST["up"];
	} else {
		$up = '0';
	}
	if ($_POST['no_up'] != '') {
		$no_up = $_POST["no_up"];
	} else {
		$no_up = '0';
	}


	if ($_POST['more'] != '') {
		$check_detail = $_POST["more"];
	} else {
		$check_detail = '0';
	}

	$type_bundai = $_POST["type_bundai"];



	$soy_long = $_POST["soy_long"];
	$soy_big = $_POST["soy_big"];
	$car_park = $_POST["car_park"];
	$door_long = $_POST["door_long"];
	$unit_bundai = $_POST["unit_bundai"];
	$door_big = $_POST["door_bigger"];
	$door_longer = $_POST["door_longer"];
	$type_door = $_POST["type_door"];
	$home_type = $_POST["home_type"];
	$install_room = $_POST["install_room"] ?? $home_type;
	$install = $_POST["install"];
	$bundai_big = $_POST["bundai_big"];
	$lip_big = $_POST["lip_big"];
	$lip_long = $_POST["lip_long"];
	$lip_weight = $_POST["lip_weight"];
	$employee_unit = $_POST["employee_unit"];
	$ferniger_name = $_POST["ferniger_name"];
	$ferniger_address = $_POST["ferniger_address"];
	$number = $_POST["number"];
	$status_comment = $_POST["status_comment"];

	$dept = $_POST["dept"];
	$room_bigger = $_POST["room_bigger"];
	$room_longer = $_POST["room_longer"];
	$bundai_hug = $_POST["bundai_hug"];
	$bank = $_POST["bank"];

	$department_show = $_POST["department_show"];
	$description_ja = $_POST["description_ja"];


	$registerDataColumns = array(
		'ref_id',
		'start_date',
		'between_date',
		'start_time',
		'end_time',
		'status',
		'fix_date',
		'no_price',
		'call_customer',
		'credit',
		'call_employee',
		'cash',
		'check_peper',
		'bill',
		'department',
		'type_customer',
		'type_company',
		'customer_name',
		'customer_tel',
		'address_name',
		'address_send',
		'want_bus',
		'product_name',
		'product_sn',
		'unit_credit',
		'price',
		'employee_name',
		'employee_tel',
		'add_by',
		'description',
		'have_map',
		'add_date',
		'unit_bill',
		'unit_check',
		'unit_tran',
		'tran',
		'check_detail',
		'dep',
		'dept',
		'department_show',
		'customer_contact',
		'on_time',
		'address_1',
		'add_code',
		'mk_research',
		'province_name',
		'count_box'
	);

	$registerDataValues = array(
		$ref_id,
		$start_date,
		$between_date,
		$start_time,
		$end_time,
		$status,
		$fix_date,
		$no_price,
		$call_customer,
		$credit,
		$call_employee,
		$chash,
		$check_peper,
		$bill,
		$department,
		$type_customer,
		$type_company,
		$customer_name,
		$customer_tel,
		$address_name,
		$address_send,
		$want_bus,
		$product_name,
		$product_sn,
		$unit_credit,
		$price,
		$employee_name,
		$employee_tel,
		$add_by,
		$description,
		$havemap,
		$add_date,
		$unit_bill,
		$unit_check,
		$unit_tran,
		$tran,
		$check_detail,
		$dep,
		$dept,
		$department_show,
		$customer_contact,
		$on_time,
		$address_1,
		$h_employee_name,
		$mk_research,
		$province_name,
		$admin_box_count_value
	);

	$shippingColumnCheck = mysqli_query($conn, "SHOW COLUMNS FROM tb_register_data LIKE 'shipping_id'");
	if ($shippingColumnCheck && mysqli_num_rows($shippingColumnCheck) > 0) {
		$registerDataColumns[] = 'shipping_id';
		$registerDataValues[] = $shipping_id;
	}

	$escapedRegisterDataValues = array();
	foreach ($registerDataValues as $registerDataValue) {
		$escapedRegisterDataValues[] = mysqli_real_escape_string($conn, (string)($registerDataValue ?? ''));
	}

	$strSQL66 = "insert into tb_register_data (" . implode(",", $registerDataColumns) . ") values ('" . implode("','", $escapedRegisterDataValues) . "')";

	$objQuery66 = mysqli_query($conn, $strSQL66) or die(mysqli_error($conn));

	$strSQL99 =  "insert into tb_transaction (ref_id,runway,road,soy,soy_long,soy_big,car_load,car_park,car_road,no_car_road,car_home,door_long,slope,bundai,unit_bundai,door_big,door_longer,type_door,home_type,install,bundai_install,bundai_big,lip,lip_big,lip_long,lip_weight,want_employee,employee_unit,ferniger_name,ferniger_address,want_ex,want_credit,want_prem,add_date,add_by,room_bigger,room_longer,bundai_hug,bank,description,type_bundai,head_bad,height_ltd,up,no_up) 

values('" . $ref_id . "','" . $runway . "','" . $road . "','" . $soy . "','" . $soy_long . "','" . $soy_big . "','" . $car_load . "','" . $car_park . "','" . $car_road . "','" . $no_car_road . "','" . $car_home . "','" . $door_long . "','" . $slope . "','" . $bundai . "','" . $unit_bundai . "','" . $door_big . "','" . $door_longer . "','" . $type_door . "','" . $home_type . "','" . $install . "','" . $bundai_install . "','" . $bundai_big . "','" . $lip . "','" . $lip_big . "','" . $lip_long . "','" . $lip_weight . "','" . $want_employee . "','" . $employee_unit . "','" . $ferniger_name . "','" . $ferniger_address . "','" . $want_ex . "','" . $want_credit . "','" . $want_prem . "','$add_date','" . $add_by . "','" . $room_bigger . "','" . $room_longer . "','" . $bundai_hug . "','" . $bank . "','" . $description_ja . "','" . $type_bundai . "','" . $head_bad . "','" . $height_ltd . "','" . $up . "','" . $no_up . "')";

	$objQuery99 = mysqli_query($conn, $strSQL99) or die(mysqli_error());

	if (!function_exists('updateTbTransactionColumnIfExists')) {
		function updateTbTransactionColumnIfExists($conn, $ref_id, $column, $value)
		{
			$safeColumn = mysqli_real_escape_string($conn, $column);
			$columnCheck = mysqli_query($conn, "SHOW COLUMNS FROM tb_transaction LIKE '" . $safeColumn . "'");
			if (!$columnCheck || mysqli_num_rows($columnCheck) == 0) {
				return;
			}

			$safeValue = mysqli_real_escape_string($conn, $value);
			$safeRefId = mysqli_real_escape_string($conn, $ref_id);
			mysqli_query($conn, "UPDATE tb_transaction SET " . $safeColumn . " = '" . $safeValue . "' WHERE ref_id = '" . $safeRefId . "'");
		}
	}

	if (!function_exists('tbDeliveryPrintColumnExists')) {
		function tbDeliveryPrintColumnExists($conn, $columnName)
		{
			static $columnCache = array();
			if (array_key_exists($columnName, $columnCache)) {
				return $columnCache[$columnName];
			}

			$safeColumnName = mysqli_real_escape_string($conn, $columnName);
			$query = mysqli_query($conn, "SHOW COLUMNS FROM tb_delivery_print LIKE '" . $safeColumnName . "'");
			$columnCache[$columnName] = ($query && mysqli_num_rows($query) > 0);
			return $columnCache[$columnName];
		}
	}

	updateTbTransactionColumnIfExists($conn, $ref_id, 'install_room', $install_room);

	$customer_name1 = $_POST["customer_name1"];
	$customer_tel1 = $_POST["customer_tel1"];
	$province_name1 = $_POST["province_name1"];
	$address_name1 = $_POST["address_name1"];

	$customer_name2 = $_POST["customer_name2"];
	$customer_tel2 = $_POST["customer_tel2"];
	$province_name2 = $_POST["province_name2"];
	$address_name2 = $_POST["address_name2"];

	$customer_name3 = $_POST["customer_name3"];
	$customer_tel3 = $_POST["customer_tel3"];
	$province_name3 = $_POST["province_name3"];
	$address_name3 = $_POST["address_name3"];

	$customer_name4 = $_POST["customer_name4"];
	$customer_tel4 = $_POST["customer_tel4"];
	$province_name4 = $_POST["province_name4"];
	$address_name4 = $_POST["address_name4"];

	$customer_name5 = $_POST["customer_name5"];
	$customer_tel5 = $_POST["customer_tel5"];
	$province_name5 = $_POST["province_name5"];
	$address_name5 = $_POST["address_name5"];

	$customer_name6 = $_POST["customer_name6"];
	$customer_tel6 = $_POST["customer_tel6"];
	$province_name6 = $_POST["province_name6"];
	$address_name6 = $_POST["address_name6"];

	$customer_name7 = $_POST["customer_name7"];
	$customer_tel7 = $_POST["customer_tel7"];
	$province_name7 = $_POST["province_name7"];
	$address_name7 = $_POST["address_name7"];

	$customer_name8 = $_POST["customer_name8"];
	$customer_tel8 = $_POST["customer_tel8"];
	$province_name8 = $_POST["province_name8"];
	$address_name8 = $_POST["address_name8"];

	$customer_name9 = $_POST["customer_name9"];
	$customer_tel9 = $_POST["customer_tel9"];
	$province_name9 = $_POST["province_name9"];
	$address_name9 = $_POST["address_name9"];

	$deliveryPrintRows = array(
		1 => array('name' => $customer_name1, 'tel' => $customer_tel1, 'province' => $province_name1, 'address' => $address_name1),
		2 => array('name' => $customer_name2, 'tel' => $customer_tel2, 'province' => $province_name2, 'address' => $address_name2),
		3 => array('name' => $customer_name3, 'tel' => $customer_tel3, 'province' => $province_name3, 'address' => $address_name3),
		4 => array('name' => $customer_name4, 'tel' => $customer_tel4, 'province' => $province_name4, 'address' => $address_name4),
		5 => array('name' => $customer_name5, 'tel' => $customer_tel5, 'province' => $province_name5, 'address' => $address_name5),
		6 => array('name' => $customer_name6, 'tel' => $customer_tel6, 'province' => $province_name6, 'address' => $address_name6),
		7 => array('name' => $customer_name7, 'tel' => $customer_tel7, 'province' => $province_name7, 'address' => $address_name7),
		8 => array('name' => $customer_name8, 'tel' => $customer_tel8, 'province' => $province_name8, 'address' => $address_name8),
		9 => array('name' => $customer_name9, 'tel' => $customer_tel9, 'province' => $province_name9, 'address' => $address_name9)
	);

	$hasDeliveryPrintData = false;
	foreach ($deliveryPrintRows as $deliveryPrintRow) {
		if (
			trim((string)$deliveryPrintRow['name']) !== '' ||
			trim((string)$deliveryPrintRow['tel']) !== '' ||
			trim((string)$deliveryPrintRow['province']) !== '' ||
			trim((string)$deliveryPrintRow['address']) !== ''
		) {
			$hasDeliveryPrintData = true;
			break;
		}
	}

	if ($hasDeliveryPrintData) {
		$deliveryPrintColumns = array('ref_id');
		$deliveryPrintValues = array("'" . mysqli_real_escape_string($conn, $ref_id) . "'");

		foreach ($deliveryPrintRows as $deliveryIndex => $deliveryPrintRow) {
			$deliveryPrintColumns[] = 'customer_name' . $deliveryIndex;
			$deliveryPrintValues[] = "'" . mysqli_real_escape_string($conn, $deliveryPrintRow['name']) . "'";
			$deliveryPrintColumns[] = 'customer_tel' . $deliveryIndex;
			$deliveryPrintValues[] = "'" . mysqli_real_escape_string($conn, $deliveryPrintRow['tel']) . "'";
			if (tbDeliveryPrintColumnExists($conn, 'province_name' . $deliveryIndex)) {
				$deliveryPrintColumns[] = 'province_name' . $deliveryIndex;
				$deliveryPrintValues[] = "'" . mysqli_real_escape_string($conn, $deliveryPrintRow['province']) . "'";
			}
			$deliveryPrintColumns[] = 'address_name' . $deliveryIndex;
			$deliveryPrintValues[] = "'" . mysqli_real_escape_string($conn, $deliveryPrintRow['address']) . "'";
		}

		$strSQL15 = "insert into tb_delivery_print (" . implode(',', $deliveryPrintColumns) . ") values(" . implode(',', $deliveryPrintValues) . ")";
		$objQuery15 = mysqli_query($conn, $strSQL15) or die(mysqli_error($conn));
	}

	mysqli_query($conn, "DELETE FROM tb_shipping_address WHERE ref_id = '" . mysqli_real_escape_string($conn, $ref_id) . "'");

	for ($shippingIndex = 1; $shippingIndex <= 9; $shippingIndex++) {
		$shippingContactName = trim((string)$_POST['customer_name' . $shippingIndex]);
		$shippingTelephone = trim((string)$_POST['customer_tel' . $shippingIndex]);
		$shippingProvince = trim((string)$_POST['province_name' . $shippingIndex]);
		$shippingAddress = trim((string)$_POST['address_name' . $shippingIndex]);

		if ($shippingContactName === '' && $shippingTelephone === '' && $shippingProvince === '' && $shippingAddress === '') {
			continue;
		}

		$strShippingInsert = "INSERT INTO tb_shipping_address (ref_id, contact_name, telephone, province, address) VALUES ('" .
			mysqli_real_escape_string($conn, $ref_id) . "','" .
			mysqli_real_escape_string($conn, $shippingContactName) . "','" .
			mysqli_real_escape_string($conn, $shippingTelephone) . "','" .
			mysqli_real_escape_string($conn, $shippingProvince) . "','" .
			mysqli_real_escape_string($conn, $shippingAddress) . "')";

		mysqli_query($conn, $strShippingInsert) or die(mysqli_error($conn));
	}

	$deliveryBillContactName = trim((string)$_POST['bill_extra_contact_name_2']);
	$deliveryBillTelephone = trim((string)$_POST['bill_extra_contact_tel_2']);
	$deliveryBillProvince = trim((string)$_POST['bill_extra_contact_province_2']);
	$deliveryBillAddress = trim((string)$_POST['bill_extra_shipping_address_2']);

	mysqli_query($conn, "DELETE FROM tb_delivery_bill WHERE ref_id = '" . mysqli_real_escape_string($conn, $ref_id) . "'");

	if ($deliveryBillContactName !== '' || $deliveryBillTelephone !== '' || $deliveryBillProvince !== '' || $deliveryBillAddress !== '') {
		$strDeliveryBillInsert = "INSERT INTO tb_delivery_bill (ref_id, customer_nameb, customer_telb, province, address_nameb) VALUES ('" .
			mysqli_real_escape_string($conn, $ref_id) . "','" .
			mysqli_real_escape_string($conn, $deliveryBillContactName) . "','" .
			mysqli_real_escape_string($conn, $deliveryBillTelephone) . "','" .
			mysqli_real_escape_string($conn, $deliveryBillProvince) . "','" .
			mysqli_real_escape_string($conn, $deliveryBillAddress) . "')";

		mysqli_query($conn, $strDeliveryBillInsert) or die(mysqli_error($conn));
	}

	$savedProductsSnapshot = array();
	for ($i = 1; $i <= 30; $i++) {
		$productIdValue = trim((string)$_POST['product_id' . $i]);
		$productCodeValue = trim((string)$_POST['product_codet' . $i]);
		$productNameValue = trim((string)$_POST['product_name' . $i]);

		if ($productIdValue === '' && $productCodeValue === '' && $productNameValue === '') {
			continue;
		}

		$savedProductsSnapshot[] = array(
			'product_id' => $productIdValue,
			'product_code' => $productCodeValue,
			'product_name' => $productNameValue,
			'unit_name' => trim((string)$_POST['unit_name' . $i]),
			'sale_count' => trim((string)$_POST['sale_count' . $i]),
			'product_price' => trim((string)$_POST['product_price' . $i]),
			'discount_unit' => trim((string)$_POST['discount_unit' . $i]),
			'sum_amount' => trim((string)$_POST['sum_amount' . $i]),
			'warranty' => trim((string)$_POST['warranty' . $i]),
			'cal' => trim((string)$_POST['cal' . $i]),
			'pm' => trim((string)$_POST['pm' . $i]),
			'pm_year' => trim((string)$_POST['pm_year' . $i]),
			'sale_remarkk' => trim((string)$_POST['sale_remarkk' . $i]),
			'clear_br' => trim((string)$_POST['clear_br' . $i]),
			'clear_ivno' => trim((string)$_POST['clear_ivno' . $i]),
			'jong_ckk' => trim((string)$_POST['jong_ckk' . $i]),
			'jong_no' => trim((string)$_POST['jong_no' . $i]),
			'display_name' => trim((string)$_POST['display_name' . $i])
		);
	}

	$_SESSION['register_suphos_saved_form'][$ref_id] = array(
		'products' => $savedProductsSnapshot
	);






	if ($qsave) {
		if ($isDraftRequest) {
			echo json_encode(array(
				'success' => true,
				'ref_id' => $ref_id,
				'message' => 'Draft saved'
			));
			exit();
		}

		echo "<script language=\"JavaScript\">";
		echo "window.location='register_suphos.php?ref_id=$ref_id&saved=1';";
		echo "</script>";
	} else {
		if ($isDraftRequest) {
			echo json_encode(array(
				'success' => false,
				'message' => 'Unable to save draft'
			));
			exit();
		}
		echo "Cannot";
	}
}
