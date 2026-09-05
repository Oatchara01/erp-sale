
<?php
if (session_status() === PHP_SESSION_NONE) {
	session_start();
}
include("dbconnect.php");
mysqli_query($conn, "SET SESSION sql_mode = REPLACE(REPLACE(@@SESSION.sql_mode, 'STRICT_TRANS_TABLES', ''), 'STRICT_ALL_TABLES', '')");

if (!function_exists('tableExists')) {
	function tableExists($conn, $tableName)
	{
		static $tables = null;
		if ($tables === null) {
			$tables = array();
			$res = mysqli_query($conn, "SHOW TABLES");
			if ($res) {
				while ($row = mysqli_fetch_array($res)) {
					$tables[strtolower($row[0])] = true;
				}
			}
		}
		return isset($tables[strtolower($tableName)]);
	}
}
include("error_page.php");

$redirect_to = isset($_POST["redirect_to"]) ? $_POST["redirect_to"] : "register_suphos_edit.php";

date_default_timezone_set("Asia/Bangkok");

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

function buildHosSubsoUpdateQuery($conn, $id_new, $ref_id, $sale_count_new, $product_price_new, $sum_amount_new, $sale_remarkk_new, $warranty_new, $pm_new, $pm_year_new, $cal_new, $product_id_new, $discount_unit_new, $have_order, $clear_br_new, $clear_ivno_new, $sn_new, $jong_ckk_new, $jong_no_new, $admin_remark_new, $sort_order_new = null)
{
	$setParts = array(
		"ref_idd='$ref_id'",
		"count='$sale_count_new'",
		"countref='$sale_count_new'",
		"price='$product_price_new'",
		"price_ref='$product_price_new'",
		"amount='$sum_amount_new'",
		"sale_remark='$sale_remarkk_new'",
		"warranty='$warranty_new'",
		"pm='$pm_new'",
		"cal='$cal_new'",
		"product_id='$product_id_new'",
		"product_code ='$product_id_new'",
		"discount ='$discount_unit_new'",
		"ckk_order='" . $have_order . "'",
		"clear_br ='" . $clear_br_new . "'",
		"clear_ivno='" . $clear_ivno_new . "'",
		"sn='" . $sn_new . "'",
		"jong_ckk='" . $jong_ckk_new . "'",
		"jong_no='" . $jong_no_new . "'"
	);

	if (hosSubsoColumnExists($conn, 'pm_year')) {
		$setParts[] = "pm_year='$pm_year_new'";
	}
	if (hosSubsoColumnExists($conn, 'admin_remark')) {
		$setParts[] = "admin_remark='" . $admin_remark_new . "'";
	}
	// $sort_order_new is only known when the row's current slot (1-30) after drag&drop
	// was resolved from subso_db_id{N}; leave the column untouched otherwise (legacy id[] submits)
	if ($sort_order_new !== null && hosSubsoColumnExists($conn, 'sort_order')) {
		$setParts[] = "sort_order='" . (int)$sort_order_new . "'";
	}

	return "Update hos__subso set " . implode(',', $setParts) . " Where id= '$id_new' ";
}

function applyHosSubsoInsertExtras($conn, $newRowId, $snValue, $pmYearValue, $adminRemarkValue)
{
	$newRowId = (int)$newRowId;
	if ($newRowId <= 0) {
		return;
	}

	$setParts = array(
		"sn = '" . mysqli_real_escape_string($conn, $snValue) . "'"
	);
	if (hosSubsoColumnExists($conn, 'pm_year')) {
		$setParts[] = "pm_year = '" . mysqli_real_escape_string($conn, $pmYearValue) . "'";
	}
	if (hosSubsoColumnExists($conn, 'admin_remark')) {
		$setParts[] = "admin_remark = '" . mysqli_real_escape_string($conn, $adminRemarkValue) . "'";
	}

	mysqli_query($conn, "UPDATE hos__subso SET " . implode(', ', $setParts) . " WHERE id = " . $newRowId);
}

if ($_POST["submit"] = "submit") {

	applyDeliveryTimeRangeToPost();

	$ref_id = trim($_POST["ref_id"]);
	$type_doc = $_POST["type_doc"];
	$bill_name = $_POST["bill_name"];
	$bill_address = $_POST["bill_address"];
	$bill_tel = $_POST["bill_tel"];
	$full_bill = isset($_POST["full_bill"]) && $_POST["full_bill"] !== '' ? $_POST["full_bill"] : '0';
	$bill_id  = $_POST["bill_id"];

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
	$date_so = $_POST["date_so"] ?? '';
	$suggest = $_POST["suggest"] ?? '';
	$payment = $_POST["payment"] ?? '';
	$payment_method = (int)($_POST["payment_method"] ?? 0);
	$sale_comment = $_POST["sale_comment"] ?? '';
	$po_no = $_POST["po_no"] ?? '';
	$que_ckk = isset($_POST["que_ckk"]) && $_POST["que_ckk"] !== '' ? $_POST["que_ckk"] : '0';
	$delivery_contract = $_POST["delivery_contract"] ?? '';
	$book_clear = isset($_POST["book_clear"]) && $_POST["book_clear"] !== '' ? $_POST["book_clear"] : '0';
	$book_no = $_POST["book_no"] ?? '';
	$brn_clear = isset($_POST["brn_clear"]) && $_POST["brn_clear"] !== '' ? $_POST["brn_clear"] : '0';
	$brn_no = $_POST["brn_no"] ?? '';
	$brnp_clear = isset($_POST["brnp_clear"]) && $_POST["brnp_clear"] !== '' ? $_POST["brnp_clear"] : '0';
	$brnp_no = $_POST["brnp_no"] ?? '';
	$sn_ckk = isset($_POST["sn_ckk"]) && $_POST["sn_ckk"] !== '' ? $_POST["sn_ckk"] : '0';
	$sn_no = $_POST["sn_no"] ?? '';
	$mode_cus = $_POST["mode_name"] ?? '';
	$install_place = $_POST["address_send"] ?? '';
	$with_pr = isset($_POST["with_pr"]) && $_POST["with_pr"] !== '' ? $_POST["with_pr"] : '0';
	$type_type = $_POST["type_type"] ?? '';
	$type_detail = $_POST["type_detail"] ?? '';
	$delivery_type = $_POST["delivery_type"] ?? '';
	$delivery_date = $_POST["start_date"] ?? '';
	$start_time = $_POST["start_time"] ?? '';
	$end_time = $_POST["end_time"] ?? '';
	$delivery_time = "$start_time $end_time";
	$delivery_address = $_POST["address_name"] ?? '';
	$delivery_contact = $_POST["customer_name"] ?? '';
	$delivery_tel = $_POST["customer_tel"] ?? '';
	$payment_des  = $_POST["payment_des"] ?? '';
	$date_send_key  = $_POST["between_date"] ?? '';
	$have_order = isset($_POST["have_order"]) && $_POST["have_order"] !== '' ? $_POST["have_order"] : '0';
	$tax_id = $_POST["tax_id"] ?? '';
	$cm_no = $_POST["cm_no"] ?? '';
	$sale_date = date('Y-m-d');
	$sale =  $_SESSION['name'] ?? '';
	$sale_code = $_POST['sale_code'] ?? '';
	$admin = $_SESSION['name'] ?? '';
	$admin_code = $_SESSION['code'] ?? '';
	$admin_date = date('Y-m-d H:i:s');
	$pre_name = $_POST['pre_name'] ?? '';
	$sup_code = $_SESSION['code'] ?? '';
	$name =  $_SESSION['name'] ?? '';
	$date_tranfer = $_POST["date_tranfer"] ?? '';
	$pr_no  = $_POST["pr_no"] ?? '';
	$add_date = date('Y-m-d H:i:s');
	$surname =	$_SESSION['surname'] ?? '';
	$add_by = "$name $surname";
	$plan_ckk = isset($_POST["plan_ckk"]) && $_POST["plan_ckk"] !== '' ? $_POST["plan_ckk"] : '0';
	$email = $_POST["email"] ?? '';
	$admin_box_count = sanitizeAdminNumericInput($_POST["admin_box_count"] ?? '');
	$admin_box_count_value = $admin_box_count !== '' ? $admin_box_count : '0';
	$admin_edit_count = sanitizeAdminNumericInput($_POST["admin_edit_count"] ?? '');

	$head_1 = $_POST["head_1"] ?? '';
	$ref_1 = $_POST["ref_1"] ?? '';
	$ref_2 = $_POST["ref_2"] ?? '';
	$ref_3 = $_POST["ref_3"] ?? '';
	$ref_4 = $_POST["ref_4"] ?? '';
	$ref_5 = $_POST["ref_5"] ?? '';
	$ref_6 = $_POST["ref_6"] ?? '';
	$ref_7 = $_POST["ref_7"] ?? '';
	$ref_8 = $_POST["ref_8"] ?? '';
	$ref_9 = $_POST["ref_9"] ?? '';
	$ref_10 = $_POST["ref_10"] ?? '';
	$ref_11 = $_POST["ref_11"] ?? '';
	$ref_12 = $_POST["ref_12"] ?? '';
	$ref_13 = $_POST["ref_13"] ?? '';
	$ref_des = $_POST["ref_des"] ?? '';


	$comment_cs = $_POST["comment_cs"] ?? '';
	$comment_en = $_POST["comment_en"] ?? '';
	$comment_st = $_POST["comment_st"] ?? '';
	$comment_ad = $_POST["comment_ad"] ?? '';
	$technician_required = isset($_POST["technician_required"]) && $_POST["technician_required"] === "1" ? 1 : 0;
	$deptCommentItems = getDeptCommentItemsFromPost();

	$ic_ckk = isset($_POST["ic_ckk"]) && $_POST["ic_ckk"] !== '' ? $_POST["ic_ckk"] : '0';
	$et_ckk = isset($_POST["et_ckk"]) && $_POST["et_ckk"] !== '' ? $_POST["et_ckk"] : '0';
	$repeat_cus = isset($_POST["repeat_cus"]) && $_POST["repeat_cus"] !== '' ? $_POST["repeat_cus"] : '0';
	$time_range = $_POST["time_range"] ?? '';
	$status_comment = $_POST["status_comment"] ?? '';

	/*if($po_no!=''){	
$strSQL23 = "SELECT * FROM hos__so WHERE po_no = '".$po_no."'";
$objQuery23 = mysqli_query($conn,$strSQL23);
$num = mysqli_num_rows($objQuery23);

if($num > 0){	
echo "<script language=\"JavaScript\">";
echo "alert('PO เลขที่ $po_no มีการบันทึกข้อมูลไปแล้วค่ะ');window.location='register_suphos_edit.php?ref_id=$ref_id';";
echo "</script>";
exit();
	
}	
}*/



	if ($_FILES['slip1']['size'] > 1100000) {
		echo "<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
		exit();
	} else if ($_FILES['slip1']['name'] != '') {
		$temp1 = explode(".", $_FILES["slip1"]["name"]);
		$slip1 = "slip1" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp1);
		move_uploaded_file($_FILES["slip1"]["tmp_name"], "upload/" . $slip1);
	} else {
		$slip1 = $_POST["slip1"];
	}

	if ($_FILES['slip2']['size'] > 1100000) {
		echo "<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
		exit();
	} else if ($_FILES['slip2']['name'] != '') {
		$temp2 = explode(".", $_FILES["slip2"]["name"]);
		$slip2 = "slip2" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp2);
		move_uploaded_file($_FILES["slip2"]["tmp_name"], "upload/" . $slip2);
	} else {
		$slip2 = $_POST["slip2"];
	}

	if ($_FILES['slip3']['size'] > 1100000) {
		echo "<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
		exit();
	} else if ($_FILES['slip3']['name'] != '') {
		$temp3 = explode(".", $_FILES["slip3"]["name"]);
		$slip3 = "slip3" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp3);
		move_uploaded_file($_FILES["slip3"]["tmp_name"], "upload/" . $slip3);
	} else {
		$slip3 = $_POST["slip3"];
	}

	if ($_FILES['slip4']['size'] > 1100000) {
		echo "<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
		exit();
	} else if ($_FILES['slip4']['name'] != '') {
		$temp4 = explode(".", $_FILES["slip4"]["name"]);
		$slip4 = "slip4" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp4);
		move_uploaded_file($_FILES["slip4"]["tmp_name"], "upload/" . $slip4);
	} else {
		$slip4 = $_POST["slip4"];
	}

	if ($_FILES['slip5']['size'] > 1100000) {
		echo "<script>alert('กรุณแนบไฟล์ที่มีขนาด น้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
		exit();
	} else if ($_FILES['slip5']['name'] != '') {
		$temp5 = explode(".", $_FILES["slip5"]["name"]);
		$slip5 = "slip5" . "_" . $ref_id . "_" . round(microtime(true)) . '.' . end($temp5);
		move_uploaded_file($_FILES["slip5"]["tmp_name"], "upload/" . $slip5);
	} else {
		$slip5 = $_POST["slip5"];
	}


	// Flat format to array format mapping layer for register_suphos.php edit compatibility
	if (!isset($_POST["id"]) || !is_array($_POST["id"])) {
		$mapped_id = array();
		$mapped_sale_count = array();
		$mapped_product_price = array();
		$mapped_sum_amount = array();
		$mapped_sale_remarkk = array();
		$mapped_warranty = array();
		$mapped_pm = array();
		$mapped_cal = array();
		$mapped_product_id = array();
		$mapped_discount_unit = array();
		$mapped_clear_br = array();
		$mapped_sn = array();
		$mapped_clear_ivno = array();
		$mapped_jong_ckk = array();
		$mapped_jong_no = array();
		$mapped_pm_year = array();
		$mapped_admin_remark = array();
		$mapped_sort_order = array();
		$deleted_subso_ids = array();
		$deleted_product_codes = array();

		for ($i = 1; $i <= 30; $i++) {
			if (isset($_POST["subso_db_id$i"]) && $_POST["subso_db_id$i"] !== '') {
				$db_id = $_POST["subso_db_id$i"];
				$mapped_id[$db_id] = $db_id;
				$mapped_sale_count[$db_id] = $_POST["sale_count$i"] ?? '';
				$mapped_product_price[$db_id] = $_POST["product_price$i"] ?? '';
				$mapped_sum_amount[$db_id] = $_POST["sum_amount$i"] ?? '';
				$mapped_sale_remarkk[$db_id] = $_POST["sale_remarkk$i"] ?? '';
				$mapped_warranty[$db_id] = $_POST["warranty$i"] ?? '';
				$mapped_pm[$db_id] = $_POST["pm$i"] ?? '';
				$mapped_cal[$db_id] = $_POST["cal$i"] ?? '';
				$mapped_product_id[$db_id] = $_POST["product_id$i"] ?? '';
				$mapped_discount_unit[$db_id] = $_POST["discount_unit$i"] ?? '';
				$mapped_clear_br[$db_id] = $_POST["clear_br$i"] ?? '';
				$mapped_sn[$db_id] = $_POST["product_sn$i"] ?? $_POST["sn$i"] ?? '';
				$mapped_clear_ivno[$db_id] = $_POST["clear_ivno$i"] ?? '';
				$mapped_jong_ckk[$db_id] = $_POST["jong_ckk$i"] ?? '';
				$mapped_jong_no[$db_id] = $_POST["jong_no$i"] ?? '';
				$mapped_pm_year[$db_id] = $_POST["pm_year$i"] ?? '';
				$mapped_admin_remark[$db_id] = $_POST["display_name$i"] ?? '';
				// slot index $i = position on screen after drag&drop (shiftRows swaps values into fixed slots)
				$mapped_sort_order[$db_id] = $i;
			}

			if (isset($_POST["deleted_subso_db_id$i"]) && $_POST["deleted_subso_db_id$i"] !== '') {
				$deleted_id = $_POST["deleted_subso_db_id$i"];
				$deleted_subso_ids[$deleted_id] = $deleted_id;
				$deleted_product_codes[$deleted_id] = $_POST["deleted_product_code$i"] ?? '';
			}
		}

		$_POST["id"] = $mapped_id;
		$_POST["sale_count"] = $mapped_sale_count;
		$_POST["product_price"] = $mapped_product_price;
		$_POST["sum_amount"] = $mapped_sum_amount;
		$_POST["sale_remarkk"] = $mapped_sale_remarkk;
		$_POST["warranty"] = $mapped_warranty;
		$_POST["pm"] = $mapped_pm;
		$_POST["cal"] = $mapped_cal;
		$_POST["product_id"] = $mapped_product_id;
		$_POST["discount_unit"] = $mapped_discount_unit;
		$_POST["clear_br"] = $mapped_clear_br;
		$_POST["sn"] = $mapped_sn;
		$_POST["clear_ivno"] = $mapped_clear_ivno;
		$_POST["jong_ckk"] = $mapped_jong_ckk;
		$_POST["jong_no"] = $mapped_jong_no;
		$_POST["pm_year"] = $mapped_pm_year;
		$_POST["admin_remark"] = $mapped_admin_remark;
		$_POST["sort_order_map"] = $mapped_sort_order;
		$_POST["deleted_subso_ids"] = $deleted_subso_ids;
		$_POST["deleted_product_codes"] = $deleted_product_codes;
	}

	$id = $_POST["id"];
	$sale_count = $_POST["sale_count"];
	$product_price = $_POST["product_price"];
	$sum_amount = $_POST["sum_amount"];
	$sale_remarkk = $_POST["sale_remarkk"];
	$warranty = $_POST["warranty"];
	$pm = $_POST["pm"];
	$cal = $_POST["cal"];
	$product_id = $_POST["product_id"];
	$discount_unit = $_POST["discount_unit"];
	$clear_br = $_POST["clear_br"];
	$sn = $_POST["sn"];
	$clear_ivno = $_POST["clear_ivno"];
	$jong_ckk = $_POST["jong_ckk"];
	$jong_no = $_POST["jong_no"];
	$pm_year = $_POST["pm_year"] ?? array();
	$admin_remark = $_POST["admin_remark"] ?? array();
	$sort_order_map = $_POST["sort_order_map"] ?? array();
	$deleted_subso_ids = $_POST["deleted_subso_ids"] ?? array();
	$deleted_product_codes = $_POST["deleted_product_codes"] ?? array();



	// ไฟล์นี้เป็น handler ร่วมของทั้งปุ่ม Submit และปุ่ม Update/Save Draft (ผ่าน register_suphos_draft1.php
	// ซึ่งเซ็ต is_draft='1' ไว้เสมอ) ถ้าเซ็ต send_sup/status_doc ทุกครั้ง เอกสาร Draft จะถูกส่งให้ Sup
	// ทันทีที่กด Save Draft และเอกสาร Returned จะเด้งกลับเป็น Request ทันทีที่กด Update
	$isDraftRequest = (($_POST['is_draft'] ?? '') === '1');
	$cancelDocPost = $_POST["cancel_doc"] ?? null;

	if ($cancelDocPost === '1') {
		$statusFields = "send_sup='1',status_doc='ยกเลิก',";
	} elseif ($isDraftRequest) {
		$statusFields = "";
	} else {
		$statusFields = "send_sup='1',send_supname='" . $add_by . "',send_supdate='" . $add_date
			. "',send_admin='0',status_doc='Request',";
	}

	$save = "Update  hos__so set
bill_name ='" . $bill_name . "',bill_tel ='" . $bill_tel . "',bill_address  ='" . $bill_address . "',full_bill ='" . $full_bill . "',date_so ='" . $date_so . "',suggest ='" . $suggest . "',payment ='" . $payment . "',payment_method ='" . $payment_method . "',sale_comment ='" . $sale_comment . "',po_no ='" . $po_no . "',delivery_contract ='" . $delivery_contract . "',book_clear ='" . $book_clear . "',book_no ='" . $book_no . "',brn_clear ='" . $brn_clear . "',brn_no ='" . $brn_no . "',brnp_clear ='" . $brnp_clear . "',brnp_no ='" . $brnp_no . "',sn_ckk ='" . $sn_ckk . "',sn_no ='" . $sn_no . "',install_place ='" . $install_place . "',with_pr ='" . $with_pr . "',type_type ='" . $type_type . "',type_detail ='" . $type_detail . "',delivery_type ='" . $delivery_type . "',delivery_date ='" . $delivery_date . "',delivery_time ='" . $delivery_time . "',delivery_address ='" . $delivery_address . "',delivery_contact ='" . $delivery_contact . "',delivery_tel ='" . $delivery_tel . "',pr_no ='" . $pr_no . "',add_by ='" . $add_by . "',payment_des ='" . $payment_des . "',slip1 = '" . $slip1 . "',slip2 = '" . $slip2 . "',slip3 = '" . $slip3 . "',slip4 = '" . $slip4 . "',slip5 = '" . $slip5 . "',date_send_key='" . $date_send_key . "',have_order='" . $have_order . "',bill_id = '" . $bill_id . "',date_tranfer = '" . $date_tranfer . "',cm_no='" . $cm_no . "'," . $statusFields . "pre_name='" . $pre_name . "',que_ckk='" . $que_ckk . "',mode_cus ='" . $mode_cus . "',plan_ckk='" . $plan_ckk . "',email='" . $email . "',sale_code='" . $sale_code . "',tax_id='" . $tax_id . "',ic_ckk='" . $ic_ckk . "',et_ckk='" . $et_ckk . "',repeat_cus='" . $repeat_cus . "',admin='" . $admin . "',admin_code='" . $admin_code . "',admin_date='" . $admin_date . "'  where ref_id='" . $ref_id . "'";

	$qsave = mysqli_query($conn, $save);

	if (!function_exists('updateHosSoColumnIfExists')) {
		function updateHosSoColumnIfExists($conn, $ref_id, $column, $value)
		{
			if ($column !== 'remark_cancel' && ($value === null || $value === '')) {
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
	}

	if (!function_exists('normalizeOptionalDateValue')) {
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
		'transport_company' => 'transport_company',
		'sale_channel' => 'sale_channel'
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

	updateHosSoColumnIfExists($conn, $ref_id, 'send_cs', (($_POST['send_cs'] ?? '') === '1') ? '1' : '0');

	// Upsert tb_other_bill: ถ้ายังไม่มีเรคคอร์ดให้ INSERT, ถ้ามีแล้วให้ UPDATE
	$checkOtherBill = mysqli_query($conn, "SELECT id FROM tb_other_bill WHERE ref_id = '" . $ref_id . "' LIMIT 1");
	if ($checkOtherBill && mysqli_num_rows($checkOtherBill) > 0) {
		$save56 = "Update tb_other_bill SET
head_1='" . $head_1 . "',ref_1='" . $ref_1 . "',ref_2='" . $ref_2 . "',ref_3='" . $ref_3 . "',ref_4='" . $ref_4 . "',ref_5='" . $ref_5 . "',ref_6='" . $ref_6 . "',ref_7='" . $ref_7 . "',ref_8='" . $ref_8 . "',ref_9='" . $ref_9 . "',ref_10='" . $ref_10 . "',ref_11='" . $ref_11 . "',ref_des='" . $ref_des . "',ref_12='" . $ref_12 . "',ref_13='" . $ref_13 . "'	 where  ref_id ='" . $ref_id . "'";
	} else {
		$save56 = "INSERT INTO tb_other_bill (ref_id,head_1,ref_1,ref_2,ref_3,ref_4,ref_5,ref_6,ref_7,ref_8,ref_9,ref_10,ref_11,ref_des,ref_12,ref_13) VALUES ('" . $ref_id . "','" . $head_1 . "','" . $ref_1 . "','" . $ref_2 . "','" . $ref_3 . "','" . $ref_4 . "','" . $ref_5 . "','" . $ref_6 . "','" . $ref_7 . "','" . $ref_8 . "','" . $ref_9 . "','" . $ref_10 . "','" . $ref_11 . "','" . $ref_des . "','" . $ref_12 . "','" . $ref_13 . "')";
	}
	$qsave56 = mysqli_query($conn, $save56);

	// Upsert tb_comment_so
	$checkCommentSo = mysqli_query($conn, "SELECT id FROM tb_comment_so WHERE ref_id = '" . $ref_id . "' ORDER BY id DESC LIMIT 1");
	$commentSoId = 0;
	if ($checkCommentSo && mysqli_num_rows($checkCommentSo) > 0) {
		$commentSoRow = mysqli_fetch_assoc($checkCommentSo);
		$commentSoId = (int)$commentSoRow["id"];
		$save57 = "Update tb_comment_so  SET comment_cs='" . $comment_cs . "',comment_en='" . $comment_en . "',comment_st='" . $comment_st . "',comment_ad='" . $comment_ad . "',technician_required='" . $technician_required . "'	where  ref_id ='" . $ref_id . "'";
	} else {
		$save57 = "INSERT INTO tb_comment_so (ref_id,comment_cs,comment_en,comment_st,comment_ad,technician_required) VALUES ('" . $ref_id . "','" . $comment_cs . "','" . $comment_en . "','" . $comment_st . "','" . $comment_ad . "','" . $technician_required . "')";
	}
	$qsave57 = mysqli_query($conn, $save57);
	if ($qsave57) {
		if ($commentSoId === 0) {
			$commentSoId = mysqli_insert_id($conn);
		}
		saveDeptCommentItems($conn, $commentSoId, $ref_id, $deptCommentItems);
	}


	/*if($book_clear=='1'){
		
$save="Update  hos__jongproduct set  close_jong = '1'    where  iv_no LIKE '%".$book_no."%'";
$qsave=mysqli_query($conn,$save);
			
	}*/

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


	if ($po_no != '') {
		$sql1 = "SELECT ref_id FROM hos__po where po_no ='" . $po_no . "'";
		$qry1 = mysqli_query($conn, $sql1) or die(mysqli_error());
		$rs1 = mysqli_fetch_assoc($qry1);

		if ($rs1["ref_id"] != "") {

			$save = "Update  hos__po set  open_so='1',open_sodate='" . $add_date . "',ref_so = '" . $ref_id . "',name_open='" . $add_by . "'    where  ref_id = '" . $rs1["ref_id"] . "'";
			$qsave = mysqli_query($conn, $save);
		}
	}


	$strSQL21 = "SELECT * FROM hos__subso WHERE ref_idd = '" . $ref_id . "' ";
	$objQuery21 = mysqli_query($conn, $strSQL21) or die("Error Query [" . $strSQL21 . "]");
	$Num_Rows21 = mysqli_num_rows($objQuery21);

	if ($Num_Rows21 > 0) {

		if (!function_exists('deleteHosSubsoRowAndBomChildren')) {
			function deleteHosSubsoRowAndBomChildren($conn, $refId, $subsoId, $fallbackProductCode = '')
			{
				$subsoIdEscaped = mysqli_real_escape_string($conn, $subsoId);
				$refIdEscaped = mysqli_real_escape_string($conn, $refId);
				$productCode = $fallbackProductCode;

				// รหัสที่ใช้ลบลูก BOM (code_bomsame) ต้องเป็น access_code จาก tb_product
				// ห้าม fallback ไปที่ hos__subso.product_code เพราะคอลัมน์นั้นเก็บ product_id ซ้ำ ไม่ใช่รหัสสินค้า
				$sqlCurrent = "SELECT hos__subso.code_bom, tb_product.access_code FROM hos__subso LEFT JOIN tb_product ON hos__subso.product_id = tb_product.product_ID WHERE hos__subso.id = '" . $subsoIdEscaped . "' LIMIT 1";
				$qryCurrent = mysqli_query($conn, $sqlCurrent);
				if ($qryCurrent) {
					$currentRow = mysqli_fetch_assoc($qryCurrent);
					if (!empty($currentRow['code_bom'])) {
						$productCode = $currentRow['code_bom'];
					} elseif (!empty($currentRow['access_code'])) {
						$productCode = $currentRow['access_code'];
					}
				}

				$deleteSql = "DELETE FROM hos__subso WHERE id = '" . $subsoIdEscaped . "'";
				mysqli_query($conn, $deleteSql);

				if ($productCode !== '') {
					$productCodeEscaped = mysqli_real_escape_string($conn, $productCode);
					$deleteBomSql = "DELETE FROM hos__subso WHERE ref_idd = '" . $refIdEscaped . "' AND bom_ckk = '1' AND code_bomsame = '" . $productCodeEscaped . "'";
					mysqli_query($conn, $deleteBomSql);
				}
			}
		}

		if (is_array($deleted_subso_ids)) {
			foreach ($deleted_subso_ids as $deletedId) {
				if ($deletedId === '') {
					continue;
				}

				$fallbackProductCode = '';
				if (isset($deleted_product_codes[$deletedId])) {
					$fallbackProductCode = $deleted_product_codes[$deletedId];
				}

				deleteHosSubsoRowAndBomChildren($conn, $ref_id, $deletedId, $fallbackProductCode);
			}
		}

		// Reconciliation safety net: catch rows dropped from the form without a delete signal
		// (defense in depth — the primary fix is keeping subso_db_id populated and row_deleted
		// set correctly on the client side; this guards future regressions of the same kind).
		// Gated on subso_db_id1 being present so legacy id[]-based submit paths
		// (register_suphos_edit.php, register_veiwsup.php) are never affected.
		if (isset($_POST['subso_db_id1'])) {
			$activeIds = array_map('strval', array_keys($id));
			$deletedIdsForReconcile = is_array($deleted_subso_ids) ? array_map('strval', $deleted_subso_ids) : array();
			$keepIds = array_unique(array_merge($activeIds, $deletedIdsForReconcile));

			$existingIdsResult = mysqli_query($conn, "SELECT hos__subso.id, hos__subso.code_bom, tb_product.access_code FROM hos__subso LEFT JOIN tb_product ON hos__subso.product_id = tb_product.product_ID WHERE hos__subso.ref_idd = '" . mysqli_real_escape_string($conn, $ref_id) . "' AND COALESCE(hos__subso.bom_ckk,'0') <> '1'");
			if ($existingIdsResult) {
				while ($existingRow = mysqli_fetch_assoc($existingIdsResult)) {
					if (!in_array((string)$existingRow['id'], $keepIds, true)) {
						$fallbackCode = !empty($existingRow['code_bom']) ? $existingRow['code_bom'] : ($existingRow['access_code'] ?? '');
						deleteHosSubsoRowAndBomChildren($conn, $ref_id, $existingRow['id'], $fallbackCode);
					}
				}
			}
		}

		foreach ($id as $key => $value) {
			$id_new = $id[$key];
			$sale_count_new = $sale_count[$key];
			$product_price1 = $product_price[$key];
			$product_price_new = str_replace(',', '', $product_price1);
			$sale_remarkk_new = $sale_remarkk[$key];
			$warranty_new = $warranty[$key];
			$pm_new = $pm[$key];
			$sn_new = $sn[$key];
			$cal_new = $cal[$key];
			// hos__subso.product_id เป็นคอลัมน์ int ถ้าค่าที่ POST มาไม่ใช่ตัวเลข (เช่น access_code
			// หลุดมาจาก mapping ผิดฝั่ง endpoint) MySQL จะ cast เป็น 0 แบบเงียบ ๆ (sql_mode='')
			$product_id_new = (isset($product_id[$key]) && ctype_digit((string)$product_id[$key])) ? $product_id[$key] : '0';
			$discount_unit1 = $discount_unit[$key];
			$discount_unit_new = str_replace(',', '', $discount_unit1);
			$clear_br_new = $clear_br[$key];
			$clear_ivno_new = $clear_ivno[$key];
			$sum_amount_new = ($product_price_new - $discount_unit_new) * $sale_count_new;
			$jong_ckk_new = $jong_ckk[$key];
			$jong_no_new = $jong_no[$key];
			$pm_year_new = $pm_year[$key] ?? '';
			$admin_remark_new = $admin_remark[$key] ?? '';
			$sort_order_new = isset($sort_order_map[$key]) ? $sort_order_map[$key] : null;

			if ($clear_ivno_new != '' && $clear_br_new == '1') {

				$sql1 = "SELECT ref_id_br   FROM   hos__br   where  iv_no = '" . $clear_ivno_new . "' and status_doc = 'Approve'";
				$qry1 = mysqli_query($conn, $sql1) or die(mysqli_error($conn));
				$rs1 = mysqli_fetch_assoc($qry1);
				$ref_id_br = (is_array($rs1) && isset($rs1['ref_id_br'])) ? $rs1['ref_id_br'] : '';


				$sql2 = "SELECT sum(count) as sale_count   FROM   hos__subbr   where  ref_idd_br = '" . $ref_id_br . "' and product_id = '" . $product_id_new . "'";

				$qry2 = mysqli_query($conn, $sql2) or die(mysqli_error($conn));
				$rs2 = mysqli_fetch_array($qry2);

				$sqlsc1 = "SELECT ref_id   FROM   hos__consig   where  iv_no = '" . $clear_ivno_new . "' and status_doc = 'Approve'";
				$qrysc1 = mysqli_query($conn, $sqlsc1) or die(mysqli_error($conn));
				$rssc1 = mysqli_fetch_assoc($qrysc1);
				$ref_id_consig = (is_array($rssc1) && isset($rssc1['ref_id'])) ? $rssc1['ref_id'] : '';


				$sqlsc2 = "SELECT sum(count) as sale_count   FROM   hos__subconsig   where  ref_idd = '" . $ref_id_consig . "' and product_id = '" . $product_id_new . "'";
				$qrysc2 = mysqli_query($conn, $sqlsc2) or die(mysqli_error($conn));
				$rssc2 = mysqli_fetch_array($qrysc2);


				$sql3 = "SELECT sum(sale_count) as count3   FROM  hos__subspr  where  product_id = '" . $product_id_new . "' and clear_br = '1' and clear_ivno ='" . $clear_ivno_new . "' and status_spr='Approve'";

				$qry3 = mysqli_query($conn, $sql3) or die(mysqli_error($conn));
				$rs3 = mysqli_fetch_array($qry3);

				$sql13 = "SELECT sum(count) as count3   FROM hos__subso where  product_id = '" . $product_id_new . "' and clear_br = '1' and clear_ivno ='" . $clear_ivno_new . "' and status_so='Approve' and id <> '" . $id_new . "'";
				$qry13 = mysqli_query($conn, $sql13) or die(mysqli_error($conn));
				$rs13 = mysqli_fetch_array($qry13);

				$sql41 = "SELECT ref_id   FROM  hos__receive  where iv_no = '" . $clear_ivno_new . "' ";
				$qry41 = mysqli_query($conn, $sql41) or die(mysqli_error($conn));
				$rs41 = mysqli_fetch_array($qry41);
				$ref_id_rec = (is_array($rs41) && isset($rs41['ref_id'])) ? $rs41['ref_id'] : '';

				$sql4 = "SELECT sum(count) as count4   FROM  hos__subreceive  where ref_idd = '" . $ref_id_rec . "' and product_id = '" . $product_id_new . "'";
				$qry4 = mysqli_query($conn, $sql4) or die(mysqli_error($conn));
				$rs4 = mysqli_fetch_array($qry4);

				$sql12 = "SELECT sum(sale_count) as count3   FROM hos__subsmp where  product_id = '" . $product_id_new . "' and clear_br = '1' and br_no ='" . $clear_ivno_new . "' and status_smp ='Approve'";
				$qry12 = mysqli_query($conn, $sql12) or die(mysqli_error($conn));
				$rs12 = mysqli_fetch_array($qry12);

				$count3 = (is_array($rs3) && isset($rs3["count3"])) ? (float)$rs3["count3"] : 0;
				$count13 = (is_array($rs13) && isset($rs13["count3"])) ? (float)$rs13["count3"] : 0;
				$count4 = (is_array($rs4) && isset($rs4["count4"])) ? (float)$rs4["count4"] : 0;
				$count5 = (is_array($rs12) && isset($rs12["count3"])) ? (float)$rs12["count3"] : 0;
				$sale_count_br = (is_array($rs2) && isset($rs2['sale_count'])) ? (float)$rs2['sale_count'] : 0;
				$sale_count_consig = (is_array($rssc2) && isset($rssc2['sale_count'])) ? (float)$rssc2['sale_count'] : 0;

				$count2 = (($sale_count_br + $sale_count_consig) - ($count3 + $count4 + $count5 + $count13)) - $sale_count_new;

				if ($count2 == '0' && $ref_id_br !== '') {

					$save6 = "Update  hos__subbr set  clear_ckk = '1'    where ref_idd_br = '" . $ref_id_br . "' and product_id = '" . $product_id_new . "'";
					$qsave6 = mysqli_query($conn, $save6);
				}


				if ($sn_new != '') {

					$sql3 = "SELECT sum(sale_count) as count3   FROM  hos__subspr  where  product_id = '" . $product_id_new . "' and sn='" . $sn_new . "' and clear_br = '1' and clear_ivno ='" . $clear_ivno_new . "' and status_spr='Approve'";

					$qry3 = mysqli_query($conn, $sql3) or die(mysqli_error($conn));
					$rs3 = mysqli_fetch_array($qry3);

					$sql13 = "SELECT sum(count) as count3   FROM hos__subso where  product_id = '" . $product_id_new . "' and sn='" . $sn_new . "' and clear_br = '1' and clear_ivno ='" . $clear_ivno_new . "' and status_so='Approve' and id <> '" . $id_new . "'";
					$qry13 = mysqli_query($conn, $sql13) or die(mysqli_error($conn));
					$rs13 = mysqli_fetch_array($qry13);

					$sql41 = "SELECT ref_id   FROM  hos__receive  where iv_no = '" . $clear_ivno_new . "' ";
					$qry41 = mysqli_query($conn, $sql41) or die(mysqli_error($conn));
					$rs41 = mysqli_fetch_array($qry41);
					$ref_id_rec_sn = (is_array($rs41) && isset($rs41['ref_id'])) ? $rs41['ref_id'] : '';

					$sql4 = "SELECT sum(count) as count4   FROM  hos__subreceive  where ref_idd = '" . $ref_id_rec_sn . "' and sn='" . $sn_new . "' and product_id = '" . $product_id_new . "'";
					$qry4 = mysqli_query($conn, $sql4) or die(mysqli_error($conn));
					$rs4 = mysqli_fetch_array($qry4);

					$sql12 = "SELECT sum(sale_count) as count3   FROM hos__subsmp where  product_id = '" . $product_id_new . "' and sn='" . $sn_new . "' and clear_br = '1' and br_no ='" . $clear_ivno_new . "' and status_smp ='Approve'";
					$qry12 = mysqli_query($conn, $sql12) or die(mysqli_error());
					$rs12 = mysqli_fetch_array($qry12);

					$count3 =  $rs3["count3"];
					$count13 =  $rs13["count3"];
					$count4 =  $rs4["count4"];
					$count5 =  $rs12["count3"];

					$count_sn =  number_format($count3 + $count4 + $count5 + $count13, 0) . "";


					if ($count_sn != '0') {

						echo "<script language=\"JavaScript\">";
						echo "alert('หมายเลขเครื่อง : $sn_new มีการเคลียร์ยืมไปแล้วค่ะ');window.location='" . $redirect_to . "?ref_id=$ref_id';";
						echo "</script>";
						exit();
					}
				}



				if ($count2 < 0) {

					echo "<script language=\"JavaScript\">";
					echo "alert('สินค้าในใบยืมนี้มีไม่พอในการเคลียร์ยืมครั้งนี้ค่ะ');window.location='" . $redirect_to . "?ref_id=$ref_id';";
					echo "</script>";
					exit();
				} else {


					$strSQL = buildHosSubsoUpdateQuery($conn, $id_new, $ref_id, $sale_count_new, $product_price_new, $sum_amount_new, $sale_remarkk_new, $warranty_new, $pm_new, $pm_year_new, $cal_new, $product_id_new, $discount_unit_new, $have_order, $clear_br_new, $clear_ivno_new, $sn_new, $jong_ckk_new, $jong_no_new, $admin_remark_new, $sort_order_new);
					$objQuery = mysqli_query($conn, $strSQL);
				}
			} else if ($jong_no_new != '') {
				$strSQL = "SELECT * FROM hos__jongproduct WHERE iv_no = '" . $jong_no_new . "' ";
				$objQuery = mysqli_query($conn, $strSQL) or die("Error Query [" . $strSQL . "]");
				$objResult = mysqli_fetch_array($objQuery);
				$ref_id_jong = (is_array($objResult) && isset($objResult["ref_id"])) ? $objResult["ref_id"] : '';
				$iv_no_jong = (is_array($objResult) && isset($objResult["iv_no"])) ? $objResult["iv_no"] : '';

				$strSQL1 = "SELECT * FROM hos__subjongpro WHERE ref_idd = '" . $ref_id_jong . "' and product_id ='" . $product_id_new . "'";
				$objQuery1 = mysqli_query($conn, $strSQL1) or die("Error Query [" . $strSQL1 . "]");
				$objResult1 = mysqli_fetch_array($objQuery1);
				$product_id_subjong = (is_array($objResult1) && isset($objResult1['product_id'])) ? $objResult1['product_id'] : '';
				$count_subjong = (is_array($objResult1) && isset($objResult1["count"])) ? (float)$objResult1["count"] : 0;

				$sql3 = "SELECT sum(sale_count) as count3 FROM so__submain where product_id = '" . $product_id_subjong . "' and jong_ckk = '1' and jong_no ='" . $iv_no_jong . "' and status_sol ='Approve'";
				$qry3 = mysqli_query($conn, $sql3) or die(mysqli_error($conn));
				$rs3 = mysqli_fetch_assoc($qry3);

				$sql13 = "SELECT sum(count) as count3 FROM hos__subso where product_id = '" . $product_id_subjong . "' and jong_ckk = '1' and jong_no ='" . $iv_no_jong . "' and status_so ='Approve'";
				$qry13 = mysqli_query($conn, $sql13) or die(mysqli_error($conn));
				$rs13 = mysqli_fetch_assoc($qry13);

				$count3 = (is_array($rs3) && isset($rs3["count3"])) ? (float)$rs3["count3"] : 0;
				$count13 = (is_array($rs13) && isset($rs13["count3"])) ? (float)$rs13["count3"] : 0;

				$count2 = $count_subjong - ($count3 + $count13);

				if ($count2 == '0') {

					$strSQL1 = "Update hos__subjongpro set close_ckk ='1' where ref_idd = '" . $ref_id_jong . "' and product_id ='" . $product_id_new . "'";
					$objQuery1 = mysqli_query($conn, $strSQL1);
				}
				if ($count2 < 0) {

					echo "<script language=\"JavaScript\">";
					echo "alert('สินค้าในใบจองนี้มีไม่พอในการเคลียร์จองครั้งนี้ค่ะ');window.location='" . $redirect_to . "?ref_id=$ref_id';";
					echo "</script>";
					exit();
				} else {


					$strSQL = buildHosSubsoUpdateQuery($conn, $id_new, $ref_id, $sale_count_new, $product_price_new, $sum_amount_new, $sale_remarkk_new, $warranty_new, $pm_new, $pm_year_new, $cal_new, $product_id_new, $discount_unit_new, $have_order, $clear_br_new, $clear_ivno_new, $sn_new, $jong_ckk_new, $jong_no_new, $admin_remark_new, $sort_order_new);
					$objQuery = mysqli_query($conn, $strSQL);
				}
			} else {

				$strSQL = buildHosSubsoUpdateQuery($conn, $id_new, $ref_id, $sale_count_new, $product_price_new, $sum_amount_new, $sale_remarkk_new, $warranty_new, $pm_new, $pm_year_new, $cal_new, $product_id_new, $discount_unit_new, $have_order, $clear_br_new, $clear_ivno_new, $sn_new, $jong_ckk_new, $jong_no_new, $admin_remark_new, $sort_order_new);

				$objQuery = mysqli_query($conn, $strSQL);
			}
		}
	}






	// hos__subso.product_id เป็นคอลัมน์ int ถ้าค่าที่ POST มาไม่ใช่ตัวเลข (เช่น access_code หลุดมาจาก
	// mapping ผิดฝั่ง endpoint) MySQL จะ cast เป็น 0 แบบเงียบ ๆ (sql_mode='') ทำให้แถวใหม่ที่ insert จากที่นี่หลุด join
	for ($i = 1; $i <= 30; $i++) {
		$productIdField = 'product_id' . $i;
		if (isset($_POST[$productIdField]) && $_POST[$productIdField] !== '' && !ctype_digit((string)$_POST[$productIdField])) {
			$_POST[$productIdField] = '0';
		}
	}

	// เพิ่มใหม่: อ่าน field ของแถว 1-5 (เดิมไฟล์นี้อ่านเฉพาะแถว 6-30 ทำให้เพิ่มสินค้าในแถว 1-5 ไม่ถูกบันทึก)
	$clear_br1 = $_POST["clear_br1"] ?? '';
	$clear_br2 = $_POST["clear_br2"] ?? '';
	$clear_br3 = $_POST["clear_br3"] ?? '';
	$clear_br4 = $_POST["clear_br4"] ?? '';
	$clear_br5 = $_POST["clear_br5"] ?? '';

	$clear_ivno1 = $_POST["clear_ivno1"] ?? '';
	$clear_ivno2 = $_POST["clear_ivno2"] ?? '';
	$clear_ivno3 = $_POST["clear_ivno3"] ?? '';
	$clear_ivno4 = $_POST["clear_ivno4"] ?? '';
	$clear_ivno5 = $_POST["clear_ivno5"] ?? '';

	$jong_no1 = $_POST["jong_no1"] ?? '';
	$jong_no2 = $_POST["jong_no2"] ?? '';
	$jong_no3 = $_POST["jong_no3"] ?? '';
	$jong_no4 = $_POST["jong_no4"] ?? '';
	$jong_no5 = $_POST["jong_no5"] ?? '';

	$jong_ckk1 = $_POST["jong_ckk1"] ?? '';
	$jong_ckk2 = $_POST["jong_ckk2"] ?? '';
	$jong_ckk3 = $_POST["jong_ckk3"] ?? '';
	$jong_ckk4 = $_POST["jong_ckk4"] ?? '';
	$jong_ckk5 = $_POST["jong_ckk5"] ?? '';

	$product_name1 = $_POST["product_name1"] ?? '';
	$unit_name1 = $_POST["unit_name1"] ?? '';
	$product_id1 = $_POST["product_id1"] ?? '';
	$sale_count1 = $_POST["sale_count1"] ?? '';
	$product_price1 = $_POST["product_price1"] ?? '';
	$sale_remarkk1 = $_POST["sale_remarkk1"] ?? '';
	$sum_amountt1 = $_POST["sum_amount1"] ?? '';
	$sum_amount1 = str_replace(',', '', $sum_amountt1);
	$discount_unit1 = $_POST["discount_unit1"] ?? '';
	$warranty1 = $_POST["warranty1"] ?? '';
	$cal1 = $_POST["cal1"] ?? '';
	$pm1 = $_POST["pm1"] ?? '';
	if (($_POST["product_code1"] ?? '') != '') {
		$product_code1 = $_POST["product_code1"];
	} else if (($_POST["product_codet1"] ?? '') != '') {
		$product_code1 = $_POST["product_codet1"];
	} else {
		$product_code1 = $_POST["product_c1"] ?? '';
	}

	$product_name2 = $_POST["product_name2"] ?? '';
	$unit_name2 = $_POST["unit_name2"] ?? '';
	$product_id2 = $_POST["product_id2"] ?? '';
	$sale_count2 = $_POST["sale_count2"] ?? '';
	$product_price2 = $_POST["product_price2"] ?? '';
	$sale_remarkk2 = $_POST["sale_remarkk2"] ?? '';
	$sum_amountt2 = $_POST["sum_amount2"] ?? '';
	$sum_amount2 = str_replace(',', '', $sum_amountt2);
	$discount_unit2 = $_POST["discount_unit2"] ?? '';
	$warranty2 = $_POST["warranty2"] ?? '';
	$cal2 = $_POST["cal2"] ?? '';
	$pm2 = $_POST["pm2"] ?? '';
	if (($_POST["product_code2"] ?? '') != '') {
		$product_code2 = $_POST["product_code2"];
	} else if (($_POST["product_codet2"] ?? '') != '') {
		$product_code2 = $_POST["product_codet2"];
	} else {
		$product_code2 = $_POST["product_c2"] ?? '';
	}

	$product_name3 = $_POST["product_name3"] ?? '';
	$unit_name3 = $_POST["unit_name3"] ?? '';
	$product_id3 = $_POST["product_id3"] ?? '';
	$sale_count3 = $_POST["sale_count3"] ?? '';
	$product_price3 = $_POST["product_price3"] ?? '';
	$sale_remarkk3 = $_POST["sale_remarkk3"] ?? '';
	$sum_amountt3 = $_POST["sum_amount3"] ?? '';
	$sum_amount3 = str_replace(',', '', $sum_amountt3);
	$discount_unit3 = $_POST["discount_unit3"] ?? '';
	$warranty3 = $_POST["warranty3"] ?? '';
	$cal3 = $_POST["cal3"] ?? '';
	$pm3 = $_POST["pm3"] ?? '';
	if (($_POST["product_code3"] ?? '') != '') {
		$product_code3 = $_POST["product_code3"];
	} else if (($_POST["product_codet3"] ?? '') != '') {
		$product_code3 = $_POST["product_codet3"];
	} else {
		$product_code3 = $_POST["product_c3"] ?? '';
	}

	$product_name4 = $_POST["product_name4"] ?? '';
	$unit_name4 = $_POST["unit_name4"] ?? '';
	$product_id4 = $_POST["product_id4"] ?? '';
	$sale_count4 = $_POST["sale_count4"] ?? '';
	$product_price4 = $_POST["product_price4"] ?? '';
	$sale_remarkk4 = $_POST["sale_remarkk4"] ?? '';
	$sum_amountt4 = $_POST["sum_amount4"] ?? '';
	$sum_amount4 = str_replace(',', '', $sum_amountt4);
	$discount_unit4 = $_POST["discount_unit4"] ?? '';
	$warranty4 = $_POST["warranty4"] ?? '';
	$cal4 = $_POST["cal4"] ?? '';
	$pm4 = $_POST["pm4"] ?? '';
	if (($_POST["product_code4"] ?? '') != '') {
		$product_code4 = $_POST["product_code4"];
	} else if (($_POST["product_codet4"] ?? '') != '') {
		$product_code4 = $_POST["product_codet4"];
	} else {
		$product_code4 = $_POST["product_c4"] ?? '';
	}

	$product_name5 = $_POST["product_name5"] ?? '';
	$unit_name5 = $_POST["unit_name5"] ?? '';
	$product_id5 = $_POST["product_id5"] ?? '';
	$sale_count5 = $_POST["sale_count5"] ?? '';
	$product_price5 = $_POST["product_price5"] ?? '';
	$sale_remarkk5 = $_POST["sale_remarkk5"] ?? '';
	$sum_amountt5 = $_POST["sum_amount5"] ?? '';
	$sum_amount5 = str_replace(',', '', $sum_amountt5);
	$discount_unit5 = $_POST["discount_unit5"] ?? '';
	$warranty5 = $_POST["warranty5"] ?? '';
	$cal5 = $_POST["cal5"] ?? '';
	$pm5 = $_POST["pm5"] ?? '';
	if (($_POST["product_code5"] ?? '') != '') {
		$product_code5 = $_POST["product_code5"];
	} else if (($_POST["product_codet5"] ?? '') != '') {
		$product_code5 = $_POST["product_codet5"];
	} else {
		$product_code5 = $_POST["product_c5"] ?? '';
	}

	$clear_br6 = $_POST["clear_br6"] ?? '';
	$clear_br7 = $_POST["clear_br7"] ?? '';
	$clear_br8 = $_POST["clear_br8"] ?? '';
	$clear_br9 = $_POST["clear_br9"] ?? '';
	$clear_br10 = $_POST["clear_br10"] ?? '';
	$clear_br11 = $_POST["clear_br11"] ?? '';
	$clear_br12 = $_POST["clear_br12"] ?? '';
	$clear_br13 = $_POST["clear_br13"] ?? '';
	$clear_br14 = $_POST["clear_br14"] ?? '';
	$clear_br15 = $_POST["clear_br15"] ?? '';

	$clear_ivno6 = $_POST["clear_ivno6"] ?? '';
	$clear_ivno7 = $_POST["clear_ivno7"] ?? '';
	$clear_ivno8 = $_POST["clear_ivno8"] ?? '';
	$clear_ivno9 = $_POST["clear_ivno9"] ?? '';
	$clear_ivno10 = $_POST["clear_ivno10"] ?? '';
	$clear_ivno11 = $_POST["clear_ivno11"] ?? '';
	$clear_ivno12 = $_POST["clear_ivno12"] ?? '';
	$clear_ivno13 = $_POST["clear_ivno13"] ?? '';
	$clear_ivno14 = $_POST["clear_ivno14"] ?? '';
	$clear_ivno15 = $_POST["clear_ivno15"] ?? '';

	$jong_no6 = $_POST["jong_no6"] ?? '';
	$jong_no7 = $_POST["jong_no7"] ?? '';
	$jong_no8 = $_POST["jong_no8"] ?? '';
	$jong_no9 = $_POST["jong_no9"] ?? '';
	$jong_no10 = $_POST["jong_no10"] ?? '';
	$jong_no11 = $_POST["jong_no11"] ?? '';
	$jong_no12 = $_POST["jong_no12"] ?? '';
	$jong_no13 = $_POST["jong_no13"] ?? '';
	$jong_no14 = $_POST["jong_no14"] ?? '';
	$jong_no15 = $_POST["jong_no15"] ?? '';

	$jong_ckk6 = $_POST["jong_ckk6"] ?? '';
	$jong_ckk7 = $_POST["jong_ckk7"] ?? '';
	$jong_ckk8 = $_POST["jong_ckk8"] ?? '';
	$jong_ckk9 = $_POST["jong_ckk9"] ?? '';
	$jong_ckk10 = $_POST["jong_ckk10"] ?? '';
	$jong_ckk11 = $_POST["jong_ckk11"] ?? '';
	$jong_ckk12 = $_POST["jong_ckk12"] ?? '';
	$jong_ckk13 = $_POST["jong_ckk13"] ?? '';
	$jong_ckk14 = $_POST["jong_ckk14"] ?? '';
	$jong_ckk15 = $_POST["jong_ckk15"] ?? '';
	for ($clearLoanIndex = 16; $clearLoanIndex <= 30; $clearLoanIndex++) {
		${'clear_br' . $clearLoanIndex} = $_POST['clear_br' . $clearLoanIndex] ?? '';
		${'clear_ivno' . $clearLoanIndex} = $_POST['clear_ivno' . $clearLoanIndex] ?? '';
		${'jong_ckk' . $clearLoanIndex} = $_POST['jong_ckk' . $clearLoanIndex] ?? '';
		${'jong_no' . $clearLoanIndex} = $_POST['jong_no' . $clearLoanIndex] ?? '';
	}

	$sn6 = $_POST["sn6"] ?? '';
	$sn7 = $_POST["sn7"] ?? '';
	$sn8 = $_POST["sn8"] ?? '';
	$sn9 = $_POST["sn9"] ?? '';
	$sn10 = $_POST["sn10"] ?? '';
	$sn11 = $_POST["sn11"] ?? '';
	$sn12 = $_POST["sn12"] ?? '';
	$sn13 = $_POST["sn13"] ?? '';
	$sn14 = $_POST["sn14"] ?? '';
	$sn15 = $_POST["sn15"] ?? '';

	$product_name6 = $_POST["product_name6"] ?? '';
	$unit_name6 = $_POST["unit_name6"] ?? '';
	$product_id6 = $_POST["product_id6"] ?? '';
	$sale_count6 = $_POST["sale_count6"] ?? '';
	$product_price6 = $_POST["product_price6"] ?? '';
	$sale_remarkk6 = $_POST["sale_remarkk6"] ?? $_POST["sale_remark6"] ?? '';
	$sum_amountt6 = $_POST["sum_amount6"] ?? '';
	$sum_amount6 = str_replace(',', '', $sum_amountt6);
	$discount_unit6 = $_POST["discount_unit6"] ?? '';
	$warranty6  = $_POST["warranty6"] ?? '';
	$cal6 = $_POST["cal6"] ?? '';
	$pm6 = $_POST["pm6"] ?? '';
	if (($_POST["product_code6"] ?? '') != '') {
		$product_code6 = $_POST["product_code6"];
	} else if (($_POST["product_codet6"] ?? '') != '') {
		$product_code6 = $_POST["product_codet6"];
	} else {
		$product_code6 = $_POST["product_c6"] ?? '';
	}

	$product_name7 = $_POST["product_name7"] ?? '';
	$unit_name7 = $_POST["unit_name7"] ?? '';
	$product_id7 = $_POST["product_id7"] ?? '';
	$sale_count7 = $_POST["sale_count7"] ?? '';
	$product_price7 = $_POST["product_price7"] ?? '';
	$sale_remarkk7 = $_POST["sale_remarkk7"] ?? $_POST["sale_remark7"] ?? '';
	$sum_amountt7 = $_POST["sum_amount7"] ?? '';
	$sum_amount7 = str_replace(',', '', $sum_amountt7);
	$discount_unit7 = $_POST["discount_unit7"] ?? '';
	$warranty7  = $_POST["warranty7"] ?? '';
	$cal7 = $_POST["cal7"] ?? '';
	$pm7 = $_POST["pm7"] ?? '';
	if (($_POST["product_code7"] ?? '') != '') {
		$product_code7 = $_POST["product_code7"];
	} else if (($_POST["product_codet7"] ?? '') != '') {
		$product_code7 = $_POST["product_codet7"];
	} else {
		$product_code7 = $_POST["product_c7"] ?? '';
	}

	$product_name8 = $_POST["product_name8"] ?? '';
	$unit_name8 = $_POST["unit_name8"] ?? '';
	$product_id8 = $_POST["product_id8"] ?? '';
	$sale_count8 = $_POST["sale_count8"] ?? '';
	$product_price8 = $_POST["product_price8"] ?? '';
	$sale_remarkk8 = $_POST["sale_remarkk8"] ?? $_POST["sale_remark8"] ?? '';
	$sum_amountt8 = $_POST["sum_amount8"] ?? '';
	$sum_amount8 = str_replace(',', '', $sum_amountt8);
	$discount_unit8 = $_POST["discount_unit8"] ?? '';
	$warranty8  = $_POST["warranty8"] ?? '';
	$cal8 = $_POST["cal8"] ?? '';
	$pm8 = $_POST["pm8"] ?? '';
	if (($_POST["product_code8"] ?? '') != '') {
		$product_code8 = $_POST["product_code8"];
	} else if (($_POST["product_codet8"] ?? '') != '') {
		$product_code8 = $_POST["product_codet8"];
	} else {
		$product_code8 = $_POST["product_c8"] ?? '';
	}

	$product_name9 = $_POST["product_name9"] ?? '';
	$unit_name9 = $_POST["unit_name9"] ?? '';
	$product_id9 = $_POST["product_id9"] ?? '';
	$sale_count9 = $_POST["sale_count9"] ?? '';
	$product_price9 = $_POST["product_price9"] ?? '';
	$sale_remarkk9 = $_POST["sale_remarkk9"] ?? $_POST["sale_remark9"] ?? '';
	$sum_amountt9 = $_POST["sum_amount9"] ?? '';
	$sum_amount9 = str_replace(',', '', $sum_amountt9);
	$discount_unit9 = $_POST["discount_unit9"] ?? '';
	$warranty9  = $_POST["warranty9"] ?? '';
	$cal9 = $_POST["cal9"] ?? '';
	$pm9 = $_POST["pm9"] ?? '';
	if (($_POST["product_code9"] ?? '') != '') {
		$product_code9 = $_POST["product_code9"];
	} else if (($_POST["product_codet9"] ?? '') != '') {
		$product_code9 = $_POST["product_codet9"];
	} else {
		$product_code9 = $_POST["product_c9"] ?? '';
	}

	$product_name10 = $_POST["product_name10"] ?? '';
	$unit_name10 = $_POST["unit_name10"] ?? '';
	$product_id10 = $_POST["product_id10"] ?? '';
	$sale_count10 = $_POST["sale_count10"] ?? '';
	$product_price10 = $_POST["product_price10"] ?? '';
	$sale_remarkk10 = $_POST["sale_remarkk10"] ?? $_POST["sale_remark10"] ?? '';
	$sum_amountt10 = $_POST["sum_amount10"] ?? '';
	$sum_amount10 = str_replace(',', '', $sum_amountt10);
	$discount_unit10 = $_POST["discount_unit10"] ?? '';
	$warranty10  = $_POST["warranty10"] ?? '';
	$cal10 = $_POST["cal10"] ?? '';
	$pm10 = $_POST["pm10"] ?? '';
	if (($_POST["product_code10"] ?? '') != '') {
		$product_code10 = $_POST["product_code10"];
	} else if (($_POST["product_codet10"] ?? '') != '') {
		$product_code10 = $_POST["product_codet10"];
	} else {
		$product_code10 = $_POST["product_c10"] ?? '';
	}

	$product_name11 = $_POST["product_name11"] ?? '';
	$unit_name11 = $_POST["unit_name11"] ?? '';
	$product_id11 = $_POST["product_id11"] ?? '';
	$sale_count11 = $_POST["sale_count11"] ?? '';
	$product_price11 = $_POST["product_price11"] ?? '';
	$sale_remarkk11 = $_POST["sale_remarkk11"] ?? $_POST["sale_remark11"] ?? '';
	$sum_amountt11 = $_POST["sum_amount11"] ?? '';
	$sum_amount11 = str_replace(',', '', $sum_amountt11);
	$discount_unit11 = $_POST["discount_unit11"] ?? '';
	$warranty11  = $_POST["warranty11"] ?? '';
	$cal11 = $_POST["cal11"] ?? '';
	$pm11 = $_POST["pm11"] ?? '';
	if (($_POST["product_code11"] ?? '') != '') {
		$product_code11 = $_POST["product_code11"];
	} else if (($_POST["product_codet11"] ?? '') != '') {
		$product_code11 = $_POST["product_codet11"];
	} else {
		$product_code11 = $_POST["product_c11"] ?? '';
	}

	$product_name12 = $_POST["product_name12"] ?? '';
	$unit_name12 = $_POST["unit_name12"] ?? '';
	$product_id12 = $_POST["product_id12"] ?? '';
	$sale_count12 = $_POST["sale_count12"] ?? '';
	$product_price12 = $_POST["product_price12"] ?? '';
	$sale_remarkk12 = $_POST["sale_remarkk12"] ?? $_POST["sale_remark12"] ?? '';
	$sum_amountt12 = $_POST["sum_amount12"] ?? '';
	$sum_amount12 = str_replace(',', '', $sum_amountt12);
	$discount_unit12 = $_POST["discount_unit12"] ?? '';
	$warranty12  = $_POST["warranty12"] ?? '';
	$cal12 = $_POST["cal12"] ?? '';
	$pm12 = $_POST["pm12"] ?? '';
	if (($_POST["product_code12"] ?? '') != '') {
		$product_code12 = $_POST["product_code12"];
	} else if (($_POST["product_codet12"] ?? '') != '') {
		$product_code12 = $_POST["product_codet12"];
	} else {
		$product_code12 = $_POST["product_c12"] ?? '';
	}

	$product_name13 = $_POST["product_name13"] ?? '';
	$unit_name13 = $_POST["unit_name13"] ?? '';
	$product_id13 = $_POST["product_id13"] ?? '';
	$sale_count13 = $_POST["sale_count13"] ?? '';
	$product_price13 = $_POST["product_price13"] ?? '';
	$sale_remarkk13 = $_POST["sale_remarkk13"] ?? $_POST["sale_remark13"] ?? '';
	$sum_amountt13 = $_POST["sum_amount13"] ?? '';
	$sum_amount13 = str_replace(',', '', $sum_amountt13);
	$discount_unit13 = $_POST["discount_unit13"] ?? '';
	$warranty13  = $_POST["warranty13"] ?? '';
	$cal13 = $_POST["cal13"] ?? '';
	$pm13 = $_POST["pm13"] ?? '';
	if (($_POST["product_code13"] ?? '') != '') {
		$product_code13 = $_POST["product_code13"];
	} else if (($_POST["product_codet13"] ?? '') != '') {
		$product_code13 = $_POST["product_codet13"];
	} else {
		$product_code13 = $_POST["product_c13"] ?? '';
	}

	$product_name14 = $_POST["product_name14"] ?? '';
	$unit_name14 = $_POST["unit_name14"] ?? '';
	$product_id14 = $_POST["product_id14"] ?? '';
	$sale_count14 = $_POST["sale_count14"] ?? '';
	$product_price14 = $_POST["product_price14"] ?? '';
	$sale_remarkk14 = $_POST["sale_remarkk14"] ?? $_POST["sale_remark14"] ?? '';
	$sum_amountt14 = $_POST["sum_amount14"] ?? '';
	$sum_amount14 = str_replace(',', '', $sum_amountt14);
	$discount_unit14 = $_POST["discount_unit14"] ?? '';
	$warranty14  = $_POST["warranty14"] ?? '';
	$cal14 = $_POST["cal14"] ?? '';
	$pm14 = $_POST["pm14"] ?? '';
	if (($_POST["product_code14"] ?? '') != '') {
		$product_code14 = $_POST["product_code14"];
	} else if (($_POST["product_codet14"] ?? '') != '') {
		$product_code14 = $_POST["product_codet14"];
	} else {
		$product_code14 = $_POST["product_c14"] ?? '';
	}

	$product_name15 = $_POST["product_name15"] ?? '';
	$unit_name15 = $_POST["unit_name15"] ?? '';
	$product_id15 = $_POST["product_id15"] ?? '';
	$sale_count15 = $_POST["sale_count15"] ?? '';
	$product_price15 = $_POST["product_price15"] ?? '';
	$sale_remarkk15 = $_POST["sale_remarkk15"] ?? $_POST["sale_remark15"] ?? '';
	$sum_amountt15 = $_POST["sum_amount15"] ?? '';
	$sum_amount15 = str_replace(',', '', $sum_amountt15);
	$discount_unit15 = $_POST["discount_unit15"] ?? '';
	$warranty15  = $_POST["warranty15"] ?? '';
	$cal15 = $_POST["cal15"] ?? '';
	$pm15 = $_POST["pm15"] ?? '';
	if (($_POST["product_code15"] ?? '') != '') {
		$product_code15 = $_POST["product_code15"];
	} else if (($_POST["product_codet15"] ?? '') != '') {
		$product_code15 = $_POST["product_codet15"];
	} else {
		$product_code15 = $_POST["product_c15"] ?? '';
	}

	$product_name16 = $_POST["product_name16"] ?? '';
	$unit_name16 = $_POST["unit_name16"] ?? '';
	$product_id16 = $_POST["product_id16"] ?? '';
	$sale_count16 = $_POST["sale_count16"] ?? '';
	$product_price16 = $_POST["product_price16"] ?? '';
	$sale_remarkk16 = $_POST["sale_remarkk16"] ?? $_POST["sale_remark16"] ?? '';
	$sum_amountt16 = $_POST["sum_amount16"] ?? '';
	$sum_amount16 = str_replace(',', '', $sum_amountt16);
	$discount_unit16 = $_POST["discount_unit16"] ?? '';
	$warranty16  = $_POST["warranty16"] ?? '';
	$cal16 = $_POST["cal16"] ?? '';
	$pm16 = $_POST["pm16"] ?? '';

	$product_name17 = $_POST["product_name17"] ?? '';
	$unit_name17 = $_POST["unit_name17"] ?? '';
	$product_id17 = $_POST["product_id17"] ?? '';
	$sale_count17 = $_POST["sale_count17"] ?? '';
	$product_price17 = $_POST["product_price17"] ?? '';
	$sale_remarkk17 = $_POST["sale_remarkk17"] ?? $_POST["sale_remark17"] ?? '';
	$sum_amountt17 = $_POST["sum_amount17"] ?? '';
	$sum_amount17 = str_replace(',', '', $sum_amountt17);
	$discount_unit17 = $_POST["discount_unit17"] ?? '';
	$warranty17  = $_POST["warranty17"] ?? '';
	$cal17 = $_POST["cal17"] ?? '';
	$pm17 = $_POST["pm17"] ?? '';

	$product_name18 = $_POST["product_name18"] ?? '';
	$unit_name18 = $_POST["unit_name18"] ?? '';
	$product_id18 = $_POST["product_id18"] ?? '';
	$sale_count18 = $_POST["sale_count18"] ?? '';
	$product_price18 = $_POST["product_price18"] ?? '';
	$sale_remarkk18 = $_POST["sale_remarkk18"] ?? $_POST["sale_remark18"] ?? '';
	$sum_amountt18 = $_POST["sum_amount18"] ?? '';
	$sum_amount18 = str_replace(',', '', $sum_amountt18);
	$discount_unit18 = $_POST["discount_unit18"] ?? '';
	$warranty18  = $_POST["warranty18"] ?? '';
	$cal18 = $_POST["cal18"] ?? '';
	$pm18 = $_POST["pm18"] ?? '';

	$product_name19 = $_POST["product_name19"] ?? '';
	$unit_name19 = $_POST["unit_name19"] ?? '';
	$product_id19 = $_POST["product_id19"] ?? '';
	$sale_count19 = $_POST["sale_count19"] ?? '';
	$product_price19 = $_POST["product_price19"] ?? '';
	$sale_remarkk19 = $_POST["sale_remarkk19"] ?? $_POST["sale_remark19"] ?? '';
	$sum_amountt19 = $_POST["sum_amount19"] ?? '';
	$sum_amount19 = str_replace(',', '', $sum_amountt19);
	$discount_unit19 = $_POST["discount_unit19"] ?? '';
	$warranty19  = $_POST["warranty19"] ?? '';
	$cal19 = $_POST["cal19"] ?? '';
	$pm19 = $_POST["pm19"] ?? '';

	$product_name20 = $_POST["product_name20"] ?? '';
	$unit_name20 = $_POST["unit_name20"] ?? '';
	$product_id20 = $_POST["product_id20"] ?? '';
	$sale_count20 = $_POST["sale_count20"] ?? '';
	$product_price20 = $_POST["product_price20"] ?? '';
	$sale_remarkk20 = $_POST["sale_remarkk20"] ?? $_POST["sale_remark20"] ?? '';
	$sum_amountt20 = $_POST["sum_amount20"] ?? '';
	$sum_amount20 = str_replace(',', '', $sum_amountt20);
	$discount_unit20 = $_POST["discount_unit20"] ?? '';
	$warranty20  = $_POST["warranty20"] ?? '';
	$cal20 = $_POST["cal20"] ?? '';
	$pm20 = $_POST["pm20"] ?? '';

	$product_name21 = $_POST["product_name21"] ?? '';
	$unit_name21 = $_POST["unit_name21"] ?? '';
	$product_id21 = $_POST["product_id21"] ?? '';
	$sale_count21 = $_POST["sale_count21"] ?? '';
	$product_price21 = $_POST["product_price21"] ?? '';
	$sale_remarkk21 = $_POST["sale_remarkk21"] ?? $_POST["sale_remark21"] ?? '';
	$sum_amountt21 = $_POST["sum_amount21"] ?? '';
	$sum_amount21 = str_replace(',', '', $sum_amountt21);
	$discount_unit21 = $_POST["discount_unit21"] ?? '';
	$warranty21  = $_POST["warranty21"] ?? '';
	$cal21 = $_POST["cal21"] ?? '';
	$pm21 = $_POST["pm21"] ?? '';

	$product_name22 = $_POST["product_name22"] ?? '';
	$unit_name22 = $_POST["unit_name22"] ?? '';
	$product_id22 = $_POST["product_id22"] ?? '';
	$sale_count22 = $_POST["sale_count22"] ?? '';
	$product_price22 = $_POST["product_price22"] ?? '';
	$sale_remarkk22 = $_POST["sale_remarkk22"] ?? $_POST["sale_remark22"] ?? '';
	$sum_amountt22 = $_POST["sum_amount22"] ?? '';
	$sum_amount22 = str_replace(',', '', $sum_amountt22);
	$discount_unit22 = $_POST["discount_unit22"] ?? '';
	$warranty22  = $_POST["warranty22"] ?? '';
	$cal22 = $_POST["cal22"] ?? '';
	$pm22 = $_POST["pm22"] ?? '';

	$product_name23 = $_POST["product_name23"] ?? '';
	$unit_name23 = $_POST["unit_name23"] ?? '';
	$product_id23 = $_POST["product_id23"] ?? '';
	$sale_count23 = $_POST["sale_count23"] ?? '';
	$product_price23 = $_POST["product_price23"] ?? '';
	$sale_remarkk23 = $_POST["sale_remarkk23"] ?? $_POST["sale_remark23"] ?? '';
	$sum_amountt23 = $_POST["sum_amount23"] ?? '';
	$sum_amount23 = str_replace(',', '', $sum_amountt23);
	$discount_unit23 = $_POST["discount_unit23"] ?? '';
	$warranty23  = $_POST["warranty23"] ?? '';
	$cal23 = $_POST["cal23"] ?? '';
	$pm23 = $_POST["pm23"] ?? '';

	$product_name24 = $_POST["product_name24"] ?? '';
	$unit_name24 = $_POST["unit_name24"] ?? '';
	$product_id24 = $_POST["product_id24"] ?? '';
	$sale_count24 = $_POST["sale_count24"] ?? '';
	$product_price24 = $_POST["product_price24"] ?? '';
	$sale_remarkk24 = $_POST["sale_remarkk24"] ?? $_POST["sale_remark24"] ?? '';
	$sum_amountt24 = $_POST["sum_amount24"] ?? '';
	$sum_amount24 = str_replace(',', '', $sum_amountt24);
	$discount_unit24 = $_POST["discount_unit24"] ?? '';
	$warranty24  = $_POST["warranty24"] ?? '';
	$cal24 = $_POST["cal24"] ?? '';
	$pm24 = $_POST["pm24"] ?? '';

	$product_name25 = $_POST["product_name25"] ?? '';
	$unit_name25 = $_POST["unit_name25"] ?? '';
	$product_id25 = $_POST["product_id25"] ?? '';
	$sale_count25 = $_POST["sale_count25"] ?? '';
	$product_price25 = $_POST["product_price25"] ?? '';
	$sale_remarkk25 = $_POST["sale_remarkk25"] ?? $_POST["sale_remark25"] ?? '';
	$sum_amountt25 = $_POST["sum_amount25"] ?? '';
	$sum_amount25 = str_replace(',', '', $sum_amountt25);
	$discount_unit25 = $_POST["discount_unit25"] ?? '';
	$warranty25  = $_POST["warranty25"] ?? '';
	$cal25 = $_POST["cal25"] ?? '';
	$pm25 = $_POST["pm25"] ?? '';

	$product_name26 = $_POST["product_name26"] ?? '';
	$unit_name26 = $_POST["unit_name26"] ?? '';
	$product_id26 = $_POST["product_id26"] ?? '';
	$sale_count26 = $_POST["sale_count26"] ?? '';
	$product_price26 = $_POST["product_price26"] ?? '';
	$sale_remarkk26 = $_POST["sale_remarkk26"] ?? $_POST["sale_remark26"] ?? '';
	$sum_amountt26 = $_POST["sum_amount26"] ?? '';
	$sum_amount26 = str_replace(',', '', $sum_amountt26);
	$discount_unit26 = $_POST["discount_unit26"] ?? '';
	$warranty26  = $_POST["warranty26"] ?? '';
	$cal26 = $_POST["cal26"] ?? '';
	$pm26 = $_POST["pm26"] ?? '';

	$product_name27 = $_POST["product_name27"] ?? '';
	$unit_name27 = $_POST["unit_name27"] ?? '';
	$product_id27 = $_POST["product_id27"] ?? '';
	$sale_count27 = $_POST["sale_count27"] ?? '';
	$product_price27 = $_POST["product_price27"] ?? '';
	$sale_remarkk27 = $_POST["sale_remarkk27"] ?? $_POST["sale_remark27"] ?? '';
	$sum_amountt27 = $_POST["sum_amount27"] ?? '';
	$sum_amount27 = str_replace(',', '', $sum_amountt27);
	$discount_unit27 = $_POST["discount_unit27"] ?? '';
	$warranty27  = $_POST["warranty27"] ?? '';
	$cal27 = $_POST["cal27"] ?? '';
	$pm27 = $_POST["pm27"] ?? '';

	$product_name28 = $_POST["product_name28"] ?? '';
	$unit_name28 = $_POST["unit_name28"] ?? '';
	$product_id28 = $_POST["product_id28"] ?? '';
	$sale_count28 = $_POST["sale_count28"] ?? '';
	$product_price28 = $_POST["product_price28"] ?? '';
	$sale_remarkk28 = $_POST["sale_remarkk28"] ?? $_POST["sale_remark28"] ?? '';
	$sum_amountt28 = $_POST["sum_amount28"] ?? '';
	$sum_amount28 = str_replace(',', '', $sum_amountt28);
	$discount_unit28 = $_POST["discount_unit28"] ?? '';
	$warranty28  = $_POST["warranty28"] ?? '';
	$cal28 = $_POST["cal28"] ?? '';
	$pm28 = $_POST["pm28"] ?? '';

	$product_name29 = $_POST["product_name29"] ?? '';
	$unit_name29 = $_POST["unit_name29"] ?? '';
	$product_id29 = $_POST["product_id29"] ?? '';
	$sale_count29 = $_POST["sale_count29"] ?? '';
	$product_price29 = $_POST["product_price29"] ?? '';
	$sale_remarkk29 = $_POST["sale_remarkk29"] ?? $_POST["sale_remark29"] ?? '';
	$sum_amountt29 = $_POST["sum_amount29"] ?? '';
	$sum_amount29 = str_replace(',', '', $sum_amountt29);
	$discount_unit29 = $_POST["discount_unit29"] ?? '';
	$warranty29  = $_POST["warranty29"] ?? '';
	$cal29 = $_POST["cal29"] ?? '';
	$pm29 = $_POST["pm29"] ?? '';

	$product_name30 = $_POST["product_name30"] ?? '';
	$unit_name30 = $_POST["unit_name30"] ?? '';
	$product_id30 = $_POST["product_id30"] ?? '';
	$sale_count30 = $_POST["sale_count30"] ?? '';
	$product_price30 = $_POST["product_price30"] ?? '';
	$sale_remarkk30 = $_POST["sale_remarkk30"] ?? $_POST["sale_remark30"] ?? '';
	$sum_amountt30 = $_POST["sum_amount30"] ?? '';
	$sum_amount30 = str_replace(',', '', $sum_amountt30);
	$discount_unit30 = $_POST["discount_unit30"] ?? '';
	$warranty30  = $_POST["warranty30"] ?? '';
	$cal30 = $_POST["cal30"] ?? '';
	$pm30 = $_POST["pm30"] ?? '';





	// เพิ่มใหม่: บันทึกแถว 1-5 (guard ด้วย subso_db_id กันไม่ให้แถวเดิมที่ผ่าน UPDATE ไปแล้วถูก insert ซ้ำ)
	if ($product_id1 != '' && ($_POST["subso_db_id1"] ?? '') === '') {

		$strSQL31 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '" . $product_code1 . "' ";
		$objQuery31 = mysqli_query($conn, $strSQL31) or die("Error Query [" . $strSQL31 . "]");
		$Num_Rows31 = mysqli_num_rows($objQuery31);
		if ($Num_Rows31 > 0) {

			$objResult31 = mysqli_fetch_array($objQuery31);

			$product_idb1 = $objResult31["product_id1"] ?? '';
			$product_idb2 = $objResult31["product_id2"] ?? '';
			$product_idb3 = $objResult31["product_id3"] ?? '';
			$product_idb4 = $objResult31["product_id4"] ?? '';
			$product_idb5 = $objResult31["product_id5"] ?? '';
			$product_idb6 = $objResult31["product_id6"] ?? '';
			$product_idb7 = $objResult31["product_id7"] ?? '';
			$product_idb8 = $objResult31["product_id8"] ?? '';
			$product_idb9 = $objResult31["product_id9"] ?? '';
			$product_idb10 = $objResult31["product_id10"] ?? '';

			$unit1 = (float)($sale_count1 ?? 0) * (float)($objResult31["unit1"] ?? 0);
			$unit2 = (float)($sale_count1 ?? 0) * (float)($objResult31["unit2"] ?? 0);
			$unit3 = (float)($sale_count1 ?? 0) * (float)($objResult31["unit3"] ?? 0);
			$unit4 = (float)($sale_count1 ?? 0) * (float)($objResult31["unit4"] ?? 0);
			$unit5 = (float)($sale_count1 ?? 0) * (float)($objResult31["unit5"] ?? 0);
			$unit6 = (float)($sale_count1 ?? 0) * (float)($objResult31["unit6"] ?? 0);
			$unit7 = (float)($sale_count1 ?? 0) * (float)($objResult31["unit7"] ?? 0);
			$unit8 = (float)($sale_count1 ?? 0) * (float)($objResult31["unit8"] ?? 0);
			$unit9 = (float)($sale_count1 ?? 0) * (float)($objResult31["unit9"] ?? 0);
			$unit10 = (float)($sale_count1 ?? 0) * (float)($objResult31["unit10"] ?? 0);

			if ($product_idb1 != '') {
				$strSQL104 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,code_bom,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit1 . "','" . $unit1 . "','" . $product_price1 . "','" . $product_price1 . "','" . $sum_amount1 . "','" . $sale_remarkk1 . "','" . $discount_unit1 . "','" . $warranty1 . "','" . $cal1 . "','" . $pm1 . "','" . $product_idb1 . "','" . $product_idb1 . "','" . $product_code1 . "','1','" . $product_code1 . "','" . $have_order . "','" . $clear_br1 . "','" . $clear_ivno1 . "','" . $jong_no1 . "','" . $jong_ckk1 . "','1')";
				$objQuery104 = mysqli_query($conn, $strSQL104);
			}
			if ($product_idb2 != '') {
				$strSQL100 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit2 . "','" . $unit2 . "','0.00','0.00','0.00','" . $sale_remarkk1 . "','0.00','0','0','0','" . $product_idb2 . "','" . $product_idb2 . "','1','" . $product_code1 . "','" . $have_order . "','" . $clear_br1 . "','" . $clear_ivno1 . "','" . $jong_no1 . "','" . $jong_ckk1 . "','1')";
				$objQuery100 = mysqli_query($conn, $strSQL100);
			}
			if ($product_idb3 != '') {
				$strSQL101 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit3 . "','" . $unit3 . "','0.00','0.00','0.00','" . $sale_remarkk1 . "','0.00','0','0','0','" . $product_idb3 . "','" . $product_idb3 . "','1','" . $product_code1 . "','" . $have_order . "','" . $clear_br1 . "','" . $clear_ivno1 . "','" . $jong_no1 . "','" . $jong_ckk1 . "','1')";
				$objQuery101 = mysqli_query($conn, $strSQL101);
			}
			if ($product_idb4 != '') {
				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit4 . "','" . $unit4 . "','0.00','0.00','0.00','" . $sale_remarkk1 . "','0.00','0','0','0','" . $product_idb4 . "','" . $product_idb4 . "','1','" . $product_code1 . "','" . $have_order . "','" . $clear_br1 . "','" . $clear_ivno1 . "','" . $jong_no1 . "','" . $jong_ckk1 . "','1')";
				$objQuery102 = mysqli_query($conn, $strSQL102);
			}
			if ($product_idb5 != '') {
				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit5 . "','" . $unit5 . "','0.00','0.00','0.00','" . $sale_remarkk1 . "','0.00','0','0','0','" . $product_idb5 . "','" . $product_idb5 . "','1','" . $product_code1 . "','" . $have_order . "','" . $clear_br1 . "','" . $clear_ivno1 . "','" . $jong_no1 . "','" . $jong_ckk1 . "','1')";
				$objQuery102 = mysqli_query($conn, $strSQL102);
			}
			if ($product_idb6 != '') {
				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit6 . "','" . $unit6 . "','0.00','0.00','0.00','" . $sale_remarkk1 . "','0.00','0','0','0','" . $product_idb6 . "','" . $product_idb6 . "','1','" . $product_code1 . "','" . $have_order . "','" . $clear_br1 . "','" . $clear_ivno1 . "','" . $jong_no1 . "','" . $jong_ckk1 . "','1')";
				$objQuery102 = mysqli_query($conn, $strSQL102);
			}
			if ($product_idb7 != '') {
				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit7 . "','" . $unit7 . "','0.00','0.00','0.00','" . $sale_remarkk1 . "','0.00','0','0','0','" . $product_idb7 . "','" . $product_idb7 . "','1','" . $product_code1 . "','" . $have_order . "','" . $clear_br1 . "','" . $clear_ivno1 . "','" . $jong_no1 . "','" . $jong_ckk1 . "','1')";
				$objQuery102 = mysqli_query($conn, $strSQL102);
			}
			if ($product_idb8 != '') {
				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit8 . "','" . $unit8 . "','0.00','0.00','0.00','" . $sale_remarkk1 . "','0.00','0','0','0','" . $product_idb8 . "','" . $product_idb8 . "','1','" . $product_code1 . "','" . $have_order . "','" . $clear_br1 . "','" . $clear_ivno1 . "','" . $jong_no1 . "','" . $jong_ckk1 . "','1')";
				$objQuery102 = mysqli_query($conn, $strSQL102);
			}
			if ($product_idb9 != '') {
				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit9 . "','" . $unit9 . "','0.00','0.00','0.00','" . $sale_remarkk1 . "','0.00','0','0','0','" . $product_idb9 . "','" . $product_idb9 . "','1','" . $product_code1 . "','" . $have_order . "','" . $clear_br1 . "','" . $clear_ivno1 . "','" . $jong_no1 . "','" . $jong_ckk1 . "','1')";
				$objQuery102 = mysqli_query($conn, $strSQL102);
			}
			if ($product_idb10 != '') {
				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit10 . "','" . $unit10 . "','0.00','0.00','0.00','" . $sale_remarkk1 . "','0.00','0','0','0','" . $product_idb10 . "','" . $product_idb10 . "','1','" . $product_code1 . "','" . $have_order . "','" . $clear_br1 . "','" . $clear_ivno1 . "','" . $jong_no1 . "','" . $jong_ckk1 . "','1')";
				$objQuery102 = mysqli_query($conn, $strSQL102);
			}
		} else {
			$strSQL1 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $sale_count1 . "','" . $sale_count1 . "','" . $product_price1 . "','" . $product_price1 . "','" . $sum_amount1 . "','" . $sale_remarkk1 . "','" . $discount_unit1 . "','" . $warranty1 . "','" . $cal1 . "','" . $pm1 . "','" . $product_id1 . "','" . $product_id1 . "','" . $have_order . "','" . $clear_br1 . "','" . $clear_ivno1 . "','" . $jong_no1 . "','" . $jong_ckk1 . "','1')";
			$objQuery1 = mysqli_query($conn, $strSQL1);
			if ($objQuery1) {
				applyHosSubsoInsertExtras($conn, mysqli_insert_id($conn), $_POST["product_sn1"] ?? ($_POST["sn1"] ?? ''), $_POST["pm_year1"] ?? '', $_POST["display_name1"] ?? '');
			}
		}
	}


	if ($product_id2 != '' && ($_POST["subso_db_id2"] ?? '') === '') {

		$strSQL31 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '" . $product_code2 . "' ";
		$objQuery31 = mysqli_query($conn, $strSQL31) or die("Error Query [" . $strSQL31 . "]");
		$Num_Rows31 = mysqli_num_rows($objQuery31);
		if ($Num_Rows31 > 0) {

			$objResult31 = mysqli_fetch_array($objQuery31);

			$product_idb1 = $objResult31["product_id1"] ?? '';
			$product_idb2 = $objResult31["product_id2"] ?? '';
			$product_idb3 = $objResult31["product_id3"] ?? '';
			$product_idb4 = $objResult31["product_id4"] ?? '';
			$product_idb5 = $objResult31["product_id5"] ?? '';
			$product_idb6 = $objResult31["product_id6"] ?? '';
			$product_idb7 = $objResult31["product_id7"] ?? '';
			$product_idb8 = $objResult31["product_id8"] ?? '';
			$product_idb9 = $objResult31["product_id9"] ?? '';
			$product_idb10 = $objResult31["product_id10"] ?? '';

			$unit1 = (float)($sale_count2 ?? 0) * (float)($objResult31["unit1"] ?? 0);
			$unit2 = (float)($sale_count2 ?? 0) * (float)($objResult31["unit2"] ?? 0);
			$unit3 = (float)($sale_count2 ?? 0) * (float)($objResult31["unit3"] ?? 0);
			$unit4 = (float)($sale_count2 ?? 0) * (float)($objResult31["unit4"] ?? 0);
			$unit5 = (float)($sale_count2 ?? 0) * (float)($objResult31["unit5"] ?? 0);
			$unit6 = (float)($sale_count2 ?? 0) * (float)($objResult31["unit6"] ?? 0);
			$unit7 = (float)($sale_count2 ?? 0) * (float)($objResult31["unit7"] ?? 0);
			$unit8 = (float)($sale_count2 ?? 0) * (float)($objResult31["unit8"] ?? 0);
			$unit9 = (float)($sale_count2 ?? 0) * (float)($objResult31["unit9"] ?? 0);
			$unit10 = (float)($sale_count2 ?? 0) * (float)($objResult31["unit10"] ?? 0);

			if ($product_idb1 != '') {
				$strSQL104 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,code_bom,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit1 . "','" . $unit1 . "','" . $product_price2 . "','" . $product_price2 . "','" . $sum_amount2 . "','" . $sale_remarkk2 . "','" . $discount_unit2 . "','" . $warranty2 . "','" . $cal2 . "','" . $pm2 . "','" . $product_idb1 . "','" . $product_idb1 . "','" . $product_code2 . "','1','" . $product_code2 . "','" . $have_order . "','" . $clear_br2 . "','" . $clear_ivno2 . "','" . $jong_no2 . "','" . $jong_ckk2 . "','2')";
				$objQuery104 = mysqli_query($conn, $strSQL104);
			}
			if ($product_idb2 != '') {
				$strSQL100 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit2 . "','" . $unit2 . "','0.00','0.00','0.00','" . $sale_remarkk2 . "','0.00','0','0','0','" . $product_idb2 . "','" . $product_idb2 . "','1','" . $product_code2 . "','" . $have_order . "','" . $clear_br2 . "','" . $clear_ivno2 . "','" . $jong_no2 . "','" . $jong_ckk2 . "','2')";
				$objQuery100 = mysqli_query($conn, $strSQL100);
			}
			if ($product_idb3 != '') {
				$strSQL101 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit3 . "','" . $unit3 . "','0.00','0.00','0.00','" . $sale_remarkk2 . "','0.00','0','0','0','" . $product_idb3 . "','" . $product_idb3 . "','1','" . $product_code2 . "','" . $have_order . "','" . $clear_br2 . "','" . $clear_ivno2 . "','" . $jong_no2 . "','" . $jong_ckk2 . "','2')";
				$objQuery101 = mysqli_query($conn, $strSQL101);
			}
			if ($product_idb4 != '') {
				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit4 . "','" . $unit4 . "','0.00','0.00','0.00','" . $sale_remarkk2 . "','0.00','0','0','0','" . $product_idb4 . "','" . $product_idb4 . "','1','" . $product_code2 . "','" . $have_order . "','" . $clear_br2 . "','" . $clear_ivno2 . "','" . $jong_no2 . "','" . $jong_ckk2 . "','2')";
				$objQuery102 = mysqli_query($conn, $strSQL102);
			}
			if ($product_idb5 != '') {
				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit5 . "','" . $unit5 . "','0.00','0.00','0.00','" . $sale_remarkk2 . "','0.00','0','0','0','" . $product_idb5 . "','" . $product_idb5 . "','1','" . $product_code2 . "','" . $have_order . "','" . $clear_br2 . "','" . $clear_ivno2 . "','" . $jong_no2 . "','" . $jong_ckk2 . "','2')";
				$objQuery102 = mysqli_query($conn, $strSQL102);
			}
			if ($product_idb6 != '') {
				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit6 . "','" . $unit6 . "','0.00','0.00','0.00','" . $sale_remarkk2 . "','0.00','0','0','0','" . $product_idb6 . "','" . $product_idb6 . "','1','" . $product_code2 . "','" . $have_order . "','" . $clear_br2 . "','" . $clear_ivno2 . "','" . $jong_no2 . "','" . $jong_ckk2 . "','2')";
				$objQuery102 = mysqli_query($conn, $strSQL102);
			}
			if ($product_idb7 != '') {
				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit7 . "','" . $unit7 . "','0.00','0.00','0.00','" . $sale_remarkk2 . "','0.00','0','0','0','" . $product_idb7 . "','" . $product_idb7 . "','1','" . $product_code2 . "','" . $have_order . "','" . $clear_br2 . "','" . $clear_ivno2 . "','" . $jong_no2 . "','" . $jong_ckk2 . "','2')";
				$objQuery102 = mysqli_query($conn, $strSQL102);
			}
			if ($product_idb8 != '') {
				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit8 . "','" . $unit8 . "','0.00','0.00','0.00','" . $sale_remarkk2 . "','0.00','0','0','0','" . $product_idb8 . "','" . $product_idb8 . "','1','" . $product_code2 . "','" . $have_order . "','" . $clear_br2 . "','" . $clear_ivno2 . "','" . $jong_no2 . "','" . $jong_ckk2 . "','2')";
				$objQuery102 = mysqli_query($conn, $strSQL102);
			}
			if ($product_idb9 != '') {
				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit9 . "','" . $unit9 . "','0.00','0.00','0.00','" . $sale_remarkk2 . "','0.00','0','0','0','" . $product_idb9 . "','" . $product_idb9 . "','1','" . $product_code2 . "','" . $have_order . "','" . $clear_br2 . "','" . $clear_ivno2 . "','" . $jong_no2 . "','" . $jong_ckk2 . "','2')";
				$objQuery102 = mysqli_query($conn, $strSQL102);
			}
			if ($product_idb10 != '') {
				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit10 . "','" . $unit10 . "','0.00','0.00','0.00','" . $sale_remarkk2 . "','0.00','0','0','0','" . $product_idb10 . "','" . $product_idb10 . "','1','" . $product_code2 . "','" . $have_order . "','" . $clear_br2 . "','" . $clear_ivno2 . "','" . $jong_no2 . "','" . $jong_ckk2 . "','2')";
				$objQuery102 = mysqli_query($conn, $strSQL102);
			}
		} else {
			$strSQL2 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $sale_count2 . "','" . $sale_count2 . "','" . $product_price2 . "','" . $product_price2 . "','" . $sum_amount2 . "','" . $sale_remarkk2 . "','" . $discount_unit2 . "','" . $warranty2 . "','" . $cal2 . "','" . $pm2 . "','" . $product_id2 . "','" . $product_id2 . "','" . $have_order . "','" . $clear_br2 . "','" . $clear_ivno2 . "','" . $jong_no2 . "','" . $jong_ckk2 . "','2')";
			$objQuery2 = mysqli_query($conn, $strSQL2);
			if ($objQuery2) {
				applyHosSubsoInsertExtras($conn, mysqli_insert_id($conn), $_POST["product_sn2"] ?? ($_POST["sn2"] ?? ''), $_POST["pm_year2"] ?? '', $_POST["display_name2"] ?? '');
			}
		}
	}


	if ($product_id3 != '' && ($_POST["subso_db_id3"] ?? '') === '') {

		$strSQL31 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '" . $product_code3 . "' ";
		$objQuery31 = mysqli_query($conn, $strSQL31) or die("Error Query [" . $strSQL31 . "]");
		$Num_Rows31 = mysqli_num_rows($objQuery31);
		if ($Num_Rows31 > 0) {

			$objResult31 = mysqli_fetch_array($objQuery31);

			$product_idb1 = $objResult31["product_id1"] ?? '';
			$product_idb2 = $objResult31["product_id2"] ?? '';
			$product_idb3 = $objResult31["product_id3"] ?? '';
			$product_idb4 = $objResult31["product_id4"] ?? '';
			$product_idb5 = $objResult31["product_id5"] ?? '';
			$product_idb6 = $objResult31["product_id6"] ?? '';
			$product_idb7 = $objResult31["product_id7"] ?? '';
			$product_idb8 = $objResult31["product_id8"] ?? '';
			$product_idb9 = $objResult31["product_id9"] ?? '';
			$product_idb10 = $objResult31["product_id10"] ?? '';

			$unit1 = (float)($sale_count3 ?? 0) * (float)($objResult31["unit1"] ?? 0);
			$unit2 = (float)($sale_count3 ?? 0) * (float)($objResult31["unit2"] ?? 0);
			$unit3 = (float)($sale_count3 ?? 0) * (float)($objResult31["unit3"] ?? 0);
			$unit4 = (float)($sale_count3 ?? 0) * (float)($objResult31["unit4"] ?? 0);
			$unit5 = (float)($sale_count3 ?? 0) * (float)($objResult31["unit5"] ?? 0);
			$unit6 = (float)($sale_count3 ?? 0) * (float)($objResult31["unit6"] ?? 0);
			$unit7 = (float)($sale_count3 ?? 0) * (float)($objResult31["unit7"] ?? 0);
			$unit8 = (float)($sale_count3 ?? 0) * (float)($objResult31["unit8"] ?? 0);
			$unit9 = (float)($sale_count3 ?? 0) * (float)($objResult31["unit9"] ?? 0);
			$unit10 = (float)($sale_count3 ?? 0) * (float)($objResult31["unit10"] ?? 0);

			if ($product_idb1 != '') {
				$strSQL104 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,code_bom,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit1 . "','" . $unit1 . "','" . $product_price3 . "','" . $product_price3 . "','" . $sum_amount3 . "','" . $sale_remarkk3 . "','" . $discount_unit3 . "','" . $warranty3 . "','" . $cal3 . "','" . $pm3 . "','" . $product_idb1 . "','" . $product_idb1 . "','" . $product_code3 . "','1','" . $product_code3 . "','" . $have_order . "','" . $clear_br3 . "','" . $clear_ivno3 . "','" . $jong_no3 . "','" . $jong_ckk3 . "','3')";
				$objQuery104 = mysqli_query($conn, $strSQL104);
			}
			if ($product_idb2 != '') {
				$strSQL100 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit2 . "','" . $unit2 . "','0.00','0.00','0.00','" . $sale_remarkk3 . "','0.00','0','0','0','" . $product_idb2 . "','" . $product_idb2 . "','1','" . $product_code3 . "','" . $have_order . "','" . $clear_br3 . "','" . $clear_ivno3 . "','" . $jong_no3 . "','" . $jong_ckk3 . "','3')";
				$objQuery100 = mysqli_query($conn, $strSQL100);
			}
			if ($product_idb3 != '') {
				$strSQL101 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit3 . "','" . $unit3 . "','0.00','0.00','0.00','" . $sale_remarkk3 . "','0.00','0','0','0','" . $product_idb3 . "','" . $product_idb3 . "','1','" . $product_code3 . "','" . $have_order . "','" . $clear_br3 . "','" . $clear_ivno3 . "','" . $jong_no3 . "','" . $jong_ckk3 . "','3')";
				$objQuery101 = mysqli_query($conn, $strSQL101);
			}
			if ($product_idb4 != '') {
				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit4 . "','" . $unit4 . "','0.00','0.00','0.00','" . $sale_remarkk3 . "','0.00','0','0','0','" . $product_idb4 . "','" . $product_idb4 . "','1','" . $product_code3 . "','" . $have_order . "','" . $clear_br3 . "','" . $clear_ivno3 . "','" . $jong_no3 . "','" . $jong_ckk3 . "','3')";
				$objQuery102 = mysqli_query($conn, $strSQL102);
			}
			if ($product_idb5 != '') {
				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit5 . "','" . $unit5 . "','0.00','0.00','0.00','" . $sale_remarkk3 . "','0.00','0','0','0','" . $product_idb5 . "','" . $product_idb5 . "','1','" . $product_code3 . "','" . $have_order . "','" . $clear_br3 . "','" . $clear_ivno3 . "','" . $jong_no3 . "','" . $jong_ckk3 . "','3')";
				$objQuery102 = mysqli_query($conn, $strSQL102);
			}
			if ($product_idb6 != '') {
				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit6 . "','" . $unit6 . "','0.00','0.00','0.00','" . $sale_remarkk3 . "','0.00','0','0','0','" . $product_idb6 . "','" . $product_idb6 . "','1','" . $product_code3 . "','" . $have_order . "','" . $clear_br3 . "','" . $clear_ivno3 . "','" . $jong_no3 . "','" . $jong_ckk3 . "','3')";
				$objQuery102 = mysqli_query($conn, $strSQL102);
			}
			if ($product_idb7 != '') {
				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit7 . "','" . $unit7 . "','0.00','0.00','0.00','" . $sale_remarkk3 . "','0.00','0','0','0','" . $product_idb7 . "','" . $product_idb7 . "','1','" . $product_code3 . "','" . $have_order . "','" . $clear_br3 . "','" . $clear_ivno3 . "','" . $jong_no3 . "','" . $jong_ckk3 . "','3')";
				$objQuery102 = mysqli_query($conn, $strSQL102);
			}
			if ($product_idb8 != '') {
				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit8 . "','" . $unit8 . "','0.00','0.00','0.00','" . $sale_remarkk3 . "','0.00','0','0','0','" . $product_idb8 . "','" . $product_idb8 . "','1','" . $product_code3 . "','" . $have_order . "','" . $clear_br3 . "','" . $clear_ivno3 . "','" . $jong_no3 . "','" . $jong_ckk3 . "','3')";
				$objQuery102 = mysqli_query($conn, $strSQL102);
			}
			if ($product_idb9 != '') {
				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit9 . "','" . $unit9 . "','0.00','0.00','0.00','" . $sale_remarkk3 . "','0.00','0','0','0','" . $product_idb9 . "','" . $product_idb9 . "','1','" . $product_code3 . "','" . $have_order . "','" . $clear_br3 . "','" . $clear_ivno3 . "','" . $jong_no3 . "','" . $jong_ckk3 . "','3')";
				$objQuery102 = mysqli_query($conn, $strSQL102);
			}
			if ($product_idb10 != '') {
				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit10 . "','" . $unit10 . "','0.00','0.00','0.00','" . $sale_remarkk3 . "','0.00','0','0','0','" . $product_idb10 . "','" . $product_idb10 . "','1','" . $product_code3 . "','" . $have_order . "','" . $clear_br3 . "','" . $clear_ivno3 . "','" . $jong_no3 . "','" . $jong_ckk3 . "','3')";
				$objQuery102 = mysqli_query($conn, $strSQL102);
			}
		} else {
			$strSQL3 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $sale_count3 . "','" . $sale_count3 . "','" . $product_price3 . "','" . $product_price3 . "','" . $sum_amount3 . "','" . $sale_remarkk3 . "','" . $discount_unit3 . "','" . $warranty3 . "','" . $cal3 . "','" . $pm3 . "','" . $product_id3 . "','" . $product_id3 . "','" . $have_order . "','" . $clear_br3 . "','" . $clear_ivno3 . "','" . $jong_no3 . "','" . $jong_ckk3 . "','3')";
			$objQuery3 = mysqli_query($conn, $strSQL3);
			if ($objQuery3) {
				applyHosSubsoInsertExtras($conn, mysqli_insert_id($conn), $_POST["product_sn3"] ?? ($_POST["sn3"] ?? ''), $_POST["pm_year3"] ?? '', $_POST["display_name3"] ?? '');
			}
		}
	}


	if ($product_id4 != '' && ($_POST["subso_db_id4"] ?? '') === '') {

		$strSQL31 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '" . $product_code4 . "' ";
		$objQuery31 = mysqli_query($conn, $strSQL31) or die("Error Query [" . $strSQL31 . "]");
		$Num_Rows31 = mysqli_num_rows($objQuery31);
		if ($Num_Rows31 > 0) {

			$objResult31 = mysqli_fetch_array($objQuery31);

			$product_idb1 = $objResult31["product_id1"] ?? '';
			$product_idb2 = $objResult31["product_id2"] ?? '';
			$product_idb3 = $objResult31["product_id3"] ?? '';
			$product_idb4 = $objResult31["product_id4"] ?? '';
			$product_idb5 = $objResult31["product_id5"] ?? '';
			$product_idb6 = $objResult31["product_id6"] ?? '';
			$product_idb7 = $objResult31["product_id7"] ?? '';
			$product_idb8 = $objResult31["product_id8"] ?? '';
			$product_idb9 = $objResult31["product_id9"] ?? '';
			$product_idb10 = $objResult31["product_id10"] ?? '';

			$unit1 = (float)($sale_count4 ?? 0) * (float)($objResult31["unit1"] ?? 0);
			$unit2 = (float)($sale_count4 ?? 0) * (float)($objResult31["unit2"] ?? 0);
			$unit3 = (float)($sale_count4 ?? 0) * (float)($objResult31["unit3"] ?? 0);
			$unit4 = (float)($sale_count4 ?? 0) * (float)($objResult31["unit4"] ?? 0);
			$unit5 = (float)($sale_count4 ?? 0) * (float)($objResult31["unit5"] ?? 0);
			$unit6 = (float)($sale_count4 ?? 0) * (float)($objResult31["unit6"] ?? 0);
			$unit7 = (float)($sale_count4 ?? 0) * (float)($objResult31["unit7"] ?? 0);
			$unit8 = (float)($sale_count4 ?? 0) * (float)($objResult31["unit8"] ?? 0);
			$unit9 = (float)($sale_count4 ?? 0) * (float)($objResult31["unit9"] ?? 0);
			$unit10 = (float)($sale_count4 ?? 0) * (float)($objResult31["unit10"] ?? 0);

			if ($product_idb1 != '') {
				$strSQL104 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,code_bom,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit1 . "','" . $unit1 . "','" . $product_price4 . "','" . $product_price4 . "','" . $sum_amount4 . "','" . $sale_remarkk4 . "','" . $discount_unit4 . "','" . $warranty4 . "','" . $cal4 . "','" . $pm4 . "','" . $product_idb1 . "','" . $product_idb1 . "','" . $product_code4 . "','1','" . $product_code4 . "','" . $have_order . "','" . $clear_br4 . "','" . $clear_ivno4 . "','" . $jong_no4 . "','" . $jong_ckk4 . "','4')";
				$objQuery104 = mysqli_query($conn, $strSQL104);
			}
			if ($product_idb2 != '') {
				$strSQL100 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit2 . "','" . $unit2 . "','0.00','0.00','0.00','" . $sale_remarkk4 . "','0.00','0','0','0','" . $product_idb2 . "','" . $product_idb2 . "','1','" . $product_code4 . "','" . $have_order . "','" . $clear_br4 . "','" . $clear_ivno4 . "','" . $jong_no4 . "','" . $jong_ckk4 . "','4')";
				$objQuery100 = mysqli_query($conn, $strSQL100);
			}
			if ($product_idb3 != '') {
				$strSQL101 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit3 . "','" . $unit3 . "','0.00','0.00','0.00','" . $sale_remarkk4 . "','0.00','0','0','0','" . $product_idb3 . "','" . $product_idb3 . "','1','" . $product_code4 . "','" . $have_order . "','" . $clear_br4 . "','" . $clear_ivno4 . "','" . $jong_no4 . "','" . $jong_ckk4 . "','4')";
				$objQuery101 = mysqli_query($conn, $strSQL101);
			}
			if ($product_idb4 != '') {
				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit4 . "','" . $unit4 . "','0.00','0.00','0.00','" . $sale_remarkk4 . "','0.00','0','0','0','" . $product_idb4 . "','" . $product_idb4 . "','1','" . $product_code4 . "','" . $have_order . "','" . $clear_br4 . "','" . $clear_ivno4 . "','" . $jong_no4 . "','" . $jong_ckk4 . "','4')";
				$objQuery102 = mysqli_query($conn, $strSQL102);
			}
			if ($product_idb5 != '') {
				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit5 . "','" . $unit5 . "','0.00','0.00','0.00','" . $sale_remarkk4 . "','0.00','0','0','0','" . $product_idb5 . "','" . $product_idb5 . "','1','" . $product_code4 . "','" . $have_order . "','" . $clear_br4 . "','" . $clear_ivno4 . "','" . $jong_no4 . "','" . $jong_ckk4 . "','4')";
				$objQuery102 = mysqli_query($conn, $strSQL102);
			}
			if ($product_idb6 != '') {
				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit6 . "','" . $unit6 . "','0.00','0.00','0.00','" . $sale_remarkk4 . "','0.00','0','0','0','" . $product_idb6 . "','" . $product_idb6 . "','1','" . $product_code4 . "','" . $have_order . "','" . $clear_br4 . "','" . $clear_ivno4 . "','" . $jong_no4 . "','" . $jong_ckk4 . "','4')";
				$objQuery102 = mysqli_query($conn, $strSQL102);
			}
			if ($product_idb7 != '') {
				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit7 . "','" . $unit7 . "','0.00','0.00','0.00','" . $sale_remarkk4 . "','0.00','0','0','0','" . $product_idb7 . "','" . $product_idb7 . "','1','" . $product_code4 . "','" . $have_order . "','" . $clear_br4 . "','" . $clear_ivno4 . "','" . $jong_no4 . "','" . $jong_ckk4 . "','4')";
				$objQuery102 = mysqli_query($conn, $strSQL102);
			}
			if ($product_idb8 != '') {
				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit8 . "','" . $unit8 . "','0.00','0.00','0.00','" . $sale_remarkk4 . "','0.00','0','0','0','" . $product_idb8 . "','" . $product_idb8 . "','1','" . $product_code4 . "','" . $have_order . "','" . $clear_br4 . "','" . $clear_ivno4 . "','" . $jong_no4 . "','" . $jong_ckk4 . "','4')";
				$objQuery102 = mysqli_query($conn, $strSQL102);
			}
			if ($product_idb9 != '') {
				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit9 . "','" . $unit9 . "','0.00','0.00','0.00','" . $sale_remarkk4 . "','0.00','0','0','0','" . $product_idb9 . "','" . $product_idb9 . "','1','" . $product_code4 . "','" . $have_order . "','" . $clear_br4 . "','" . $clear_ivno4 . "','" . $jong_no4 . "','" . $jong_ckk4 . "','4')";
				$objQuery102 = mysqli_query($conn, $strSQL102);
			}
			if ($product_idb10 != '') {
				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit10 . "','" . $unit10 . "','0.00','0.00','0.00','" . $sale_remarkk4 . "','0.00','0','0','0','" . $product_idb10 . "','" . $product_idb10 . "','1','" . $product_code4 . "','" . $have_order . "','" . $clear_br4 . "','" . $clear_ivno4 . "','" . $jong_no4 . "','" . $jong_ckk4 . "','4')";
				$objQuery102 = mysqli_query($conn, $strSQL102);
			}
		} else {
			$strSQL4 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $sale_count4 . "','" . $sale_count4 . "','" . $product_price4 . "','" . $product_price4 . "','" . $sum_amount4 . "','" . $sale_remarkk4 . "','" . $discount_unit4 . "','" . $warranty4 . "','" . $cal4 . "','" . $pm4 . "','" . $product_id4 . "','" . $product_id4 . "','" . $have_order . "','" . $clear_br4 . "','" . $clear_ivno4 . "','" . $jong_no4 . "','" . $jong_ckk4 . "','4')";
			$objQuery4 = mysqli_query($conn, $strSQL4);
			if ($objQuery4) {
				applyHosSubsoInsertExtras($conn, mysqli_insert_id($conn), $_POST["product_sn4"] ?? ($_POST["sn4"] ?? ''), $_POST["pm_year4"] ?? '', $_POST["display_name4"] ?? '');
			}
		}
	}


	if ($product_id5 != '' && ($_POST["subso_db_id5"] ?? '') === '') {

		$strSQL31 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '" . $product_code5 . "' ";
		$objQuery31 = mysqli_query($conn, $strSQL31) or die("Error Query [" . $strSQL31 . "]");
		$Num_Rows31 = mysqli_num_rows($objQuery31);
		if ($Num_Rows31 > 0) {

			$objResult31 = mysqli_fetch_array($objQuery31);

			$product_idb1 = $objResult31["product_id1"] ?? '';
			$product_idb2 = $objResult31["product_id2"] ?? '';
			$product_idb3 = $objResult31["product_id3"] ?? '';
			$product_idb4 = $objResult31["product_id4"] ?? '';
			$product_idb5 = $objResult31["product_id5"] ?? '';
			$product_idb6 = $objResult31["product_id6"] ?? '';
			$product_idb7 = $objResult31["product_id7"] ?? '';
			$product_idb8 = $objResult31["product_id8"] ?? '';
			$product_idb9 = $objResult31["product_id9"] ?? '';
			$product_idb10 = $objResult31["product_id10"] ?? '';

			$unit1 = (float)($sale_count5 ?? 0) * (float)($objResult31["unit1"] ?? 0);
			$unit2 = (float)($sale_count5 ?? 0) * (float)($objResult31["unit2"] ?? 0);
			$unit3 = (float)($sale_count5 ?? 0) * (float)($objResult31["unit3"] ?? 0);
			$unit4 = (float)($sale_count5 ?? 0) * (float)($objResult31["unit4"] ?? 0);
			$unit5 = (float)($sale_count5 ?? 0) * (float)($objResult31["unit5"] ?? 0);
			$unit6 = (float)($sale_count5 ?? 0) * (float)($objResult31["unit6"] ?? 0);
			$unit7 = (float)($sale_count5 ?? 0) * (float)($objResult31["unit7"] ?? 0);
			$unit8 = (float)($sale_count5 ?? 0) * (float)($objResult31["unit8"] ?? 0);
			$unit9 = (float)($sale_count5 ?? 0) * (float)($objResult31["unit9"] ?? 0);
			$unit10 = (float)($sale_count5 ?? 0) * (float)($objResult31["unit10"] ?? 0);

			if ($product_idb1 != '') {
				$strSQL104 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,code_bom,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit1 . "','" . $unit1 . "','" . $product_price5 . "','" . $product_price5 . "','" . $sum_amount5 . "','" . $sale_remarkk5 . "','" . $discount_unit5 . "','" . $warranty5 . "','" . $cal5 . "','" . $pm5 . "','" . $product_idb1 . "','" . $product_idb1 . "','" . $product_code5 . "','1','" . $product_code5 . "','" . $have_order . "','" . $clear_br5 . "','" . $clear_ivno5 . "','" . $jong_no5 . "','" . $jong_ckk5 . "','5')";
				$objQuery104 = mysqli_query($conn, $strSQL104);
			}
			if ($product_idb2 != '') {
				$strSQL100 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit2 . "','" . $unit2 . "','0.00','0.00','0.00','" . $sale_remarkk5 . "','0.00','0','0','0','" . $product_idb2 . "','" . $product_idb2 . "','1','" . $product_code5 . "','" . $have_order . "','" . $clear_br5 . "','" . $clear_ivno5 . "','" . $jong_no5 . "','" . $jong_ckk5 . "','5')";
				$objQuery100 = mysqli_query($conn, $strSQL100);
			}
			if ($product_idb3 != '') {
				$strSQL101 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit3 . "','" . $unit3 . "','0.00','0.00','0.00','" . $sale_remarkk5 . "','0.00','0','0','0','" . $product_idb3 . "','" . $product_idb3 . "','1','" . $product_code5 . "','" . $have_order . "','" . $clear_br5 . "','" . $clear_ivno5 . "','" . $jong_no5 . "','" . $jong_ckk5 . "','5')";
				$objQuery101 = mysqli_query($conn, $strSQL101);
			}
			if ($product_idb4 != '') {
				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit4 . "','" . $unit4 . "','0.00','0.00','0.00','" . $sale_remarkk5 . "','0.00','0','0','0','" . $product_idb4 . "','" . $product_idb4 . "','1','" . $product_code5 . "','" . $have_order . "','" . $clear_br5 . "','" . $clear_ivno5 . "','" . $jong_no5 . "','" . $jong_ckk5 . "','5')";
				$objQuery102 = mysqli_query($conn, $strSQL102);
			}
			if ($product_idb5 != '') {
				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit5 . "','" . $unit5 . "','0.00','0.00','0.00','" . $sale_remarkk5 . "','0.00','0','0','0','" . $product_idb5 . "','" . $product_idb5 . "','1','" . $product_code5 . "','" . $have_order . "','" . $clear_br5 . "','" . $clear_ivno5 . "','" . $jong_no5 . "','" . $jong_ckk5 . "','5')";
				$objQuery102 = mysqli_query($conn, $strSQL102);
			}
			if ($product_idb6 != '') {
				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit6 . "','" . $unit6 . "','0.00','0.00','0.00','" . $sale_remarkk5 . "','0.00','0','0','0','" . $product_idb6 . "','" . $product_idb6 . "','1','" . $product_code5 . "','" . $have_order . "','" . $clear_br5 . "','" . $clear_ivno5 . "','" . $jong_no5 . "','" . $jong_ckk5 . "','5')";
				$objQuery102 = mysqli_query($conn, $strSQL102);
			}
			if ($product_idb7 != '') {
				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit7 . "','" . $unit7 . "','0.00','0.00','0.00','" . $sale_remarkk5 . "','0.00','0','0','0','" . $product_idb7 . "','" . $product_idb7 . "','1','" . $product_code5 . "','" . $have_order . "','" . $clear_br5 . "','" . $clear_ivno5 . "','" . $jong_no5 . "','" . $jong_ckk5 . "','5')";
				$objQuery102 = mysqli_query($conn, $strSQL102);
			}
			if ($product_idb8 != '') {
				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit8 . "','" . $unit8 . "','0.00','0.00','0.00','" . $sale_remarkk5 . "','0.00','0','0','0','" . $product_idb8 . "','" . $product_idb8 . "','1','" . $product_code5 . "','" . $have_order . "','" . $clear_br5 . "','" . $clear_ivno5 . "','" . $jong_no5 . "','" . $jong_ckk5 . "','5')";
				$objQuery102 = mysqli_query($conn, $strSQL102);
			}
			if ($product_idb9 != '') {
				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit9 . "','" . $unit9 . "','0.00','0.00','0.00','" . $sale_remarkk5 . "','0.00','0','0','0','" . $product_idb9 . "','" . $product_idb9 . "','1','" . $product_code5 . "','" . $have_order . "','" . $clear_br5 . "','" . $clear_ivno5 . "','" . $jong_no5 . "','" . $jong_ckk5 . "','5')";
				$objQuery102 = mysqli_query($conn, $strSQL102);
			}
			if ($product_idb10 != '') {
				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit10 . "','" . $unit10 . "','0.00','0.00','0.00','" . $sale_remarkk5 . "','0.00','0','0','0','" . $product_idb10 . "','" . $product_idb10 . "','1','" . $product_code5 . "','" . $have_order . "','" . $clear_br5 . "','" . $clear_ivno5 . "','" . $jong_no5 . "','" . $jong_ckk5 . "','5')";
				$objQuery102 = mysqli_query($conn, $strSQL102);
			}
		} else {
			$strSQL5 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $sale_count5 . "','" . $sale_count5 . "','" . $product_price5 . "','" . $product_price5 . "','" . $sum_amount5 . "','" . $sale_remarkk5 . "','" . $discount_unit5 . "','" . $warranty5 . "','" . $cal5 . "','" . $pm5 . "','" . $product_id5 . "','" . $product_id5 . "','" . $have_order . "','" . $clear_br5 . "','" . $clear_ivno5 . "','" . $jong_no5 . "','" . $jong_ckk5 . "','5')";
			$objQuery5 = mysqli_query($conn, $strSQL5);
			if ($objQuery5) {
				applyHosSubsoInsertExtras($conn, mysqli_insert_id($conn), $_POST["product_sn5"] ?? ($_POST["sn5"] ?? ''), $_POST["pm_year5"] ?? '', $_POST["display_name5"] ?? '');
			}
		}
	}


	if ($product_id6 != '' && ($_POST["subso_db_id6"] ?? '') === '') {

		$strSQL31 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '" . $product_code6 . "' ";
		$objQuery31 = mysqli_query($conn, $strSQL31) or die("Error Query [" . $strSQL31 . "]");
		$Num_Rows31 = mysqli_num_rows($objQuery31);
		if ($Num_Rows31 > 0) {

			$objResult31 = mysqli_fetch_array($objQuery31);

			$product_idb1 = $objResult31["product_id1"] ?? '';
			$product_idb2 = $objResult31["product_id2"] ?? '';
			$product_idb3 = $objResult31["product_id3"] ?? '';
			$product_idb4 = $objResult31["product_id4"] ?? '';
			$product_idb5 = $objResult31["product_id5"] ?? '';
			$product_idb6 = $objResult31["product_id6"] ?? '';
			$product_idb7 = $objResult31["product_id7"] ?? '';
			$product_idb8 = $objResult31["product_id8"] ?? '';
			$product_idb9 = $objResult31["product_id9"] ?? '';
			$product_idb10 = $objResult31["product_id10"] ?? '';

			$unit1 = (float)($sale_count6 ?? 0) * (float)($objResult31["unit1"] ?? 0);
			$unit2 = (float)($sale_count6 ?? 0) * (float)($objResult31["unit2"] ?? 0);
			$unit3 = (float)($sale_count6 ?? 0) * (float)($objResult31["unit3"] ?? 0);
			$unit4 = (float)($sale_count6 ?? 0) * (float)($objResult31["unit4"] ?? 0);
			$unit5 = (float)($sale_count6 ?? 0) * (float)($objResult31["unit5"] ?? 0);
			$unit6 = (float)($sale_count6 ?? 0) * (float)($objResult31["unit6"] ?? 0);
			$unit7 = (float)($sale_count6 ?? 0) * (float)($objResult31["unit7"] ?? 0);
			$unit8 = (float)($sale_count6 ?? 0) * (float)($objResult31["unit8"] ?? 0);
			$unit9 = (float)($sale_count6 ?? 0) * (float)($objResult31["unit9"] ?? 0);
			$unit10 = (float)($sale_count6 ?? 0) * (float)($objResult31["unit10"] ?? 0);

			if ($product_idb1 != '') {

				$strSQL104 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,code_bom,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit1 . "','" . $unit1 . "','" . $product_price6 . "','" . $product_price6 . "','" . $sum_amount6 . "','" . $sale_remarkk6 . "','" . $discount_unit6 . "','" . $warranty6 . "','" . $cal6 . "','" . $pm6 . "','" . $product_idb1 . "','" . $product_idb1 . "','" . $product_code6 . "','1','" . $product_code6 . "','" . $have_order . "','" . $clear_br6 . "','" . $clear_ivno6 . "','" . $jong_no6 . "','" . $jong_ckk6 . "','6')";

				$objQuery104 = mysqli_query($conn, $strSQL104);
			}

			if ($product_idb2 != '') {

				$strSQL100 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit2 . "','" . $unit2 . "','0.00','0.00','0.00','" . $sale_remarkk6 . "','0.00','0','0','0','" . $product_idb2 . "','" . $product_idb2 . "','1','" . $product_code6 . "','" . $have_order . "','" . $clear_br6 . "','" . $clear_ivno6 . "','" . $jong_no6 . "','" . $jong_ckk6 . "','6')";
				$objQuery100 = mysqli_query($conn, $strSQL100);
			}

			if ($product_idb3 != '') {

				$strSQL101 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit3 . "','" . $unit3 . "','0.00','0.00','0.00','" . $sale_remarkk6 . "','0.00','0','0','0','" . $product_idb3 . "','" . $product_idb3 . "','1','" . $product_code6 . "','" . $have_order . "','" . $clear_br6 . "','" . $clear_ivno6 . "','" . $jong_no6 . "','" . $jong_ckk6 . "','6')";

				$objQuery101 = mysqli_query($conn, $strSQL101);
			}

			if ($product_idb4 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit4 . "','" . $unit4 . "','0.00','0.00','0.00','" . $sale_remarkk6 . "','0.00','0','0','0','" . $product_idb4 . "','" . $product_idb4 . "','1','" . $product_code6 . "','" . $have_order . "','" . $clear_br6 . "','" . $clear_ivno6 . "','" . $jong_no6 . "','" . $jong_ckk6 . "','6')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb5 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit5 . "','" . $unit5 . "','0.00','0.00','0.00','" . $sale_remarkk6 . "','0.00','0','0','0','" . $product_idb5 . "','" . $product_idb5 . "','1','" . $product_code6 . "','" . $have_order . "','" . $clear_br6 . "','" . $clear_ivno6 . "','" . $jong_no6 . "','" . $jong_ckk6 . "','6')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb6 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit6 . "','" . $unit6 . "','0.00','0.00','0.00','" . $sale_remarkk6 . "','0.00','0','0','0','" . $product_idb6 . "','" . $product_idb6 . "','1','" . $product_code6 . "','" . $have_order . "','" . $clear_br6 . "','" . $clear_ivno6 . "','" . $jong_no6 . "','" . $jong_ckk6 . "','6')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb7 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit7 . "','" . $unit7 . "','0.00','0.00','0.00','" . $sale_remarkk6 . "','0.00','0','0','0','" . $product_idb7 . "','" . $product_idb7 . "','1','" . $product_code6 . "','" . $have_order . "','" . $clear_br6 . "','" . $clear_ivno6 . "','" . $jong_no6 . "','" . $jong_ckk6 . "','6')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb8 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit8 . "','" . $unit8 . "','0.00','0.00','0.00','" . $sale_remarkk6 . "','0.00','0','0','0','" . $product_idb8 . "','" . $product_idb8 . "','1','" . $product_code6 . "','" . $have_order . "','" . $clear_br6 . "','" . $clear_ivno6 . "','" . $jong_no6 . "','" . $jong_ckk6 . "','6')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb9 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit9 . "','" . $unit9 . "','0.00','0.00','0.00','" . $sale_remarkk6 . "','0.00','0','0','0','" . $product_idb9 . "','" . $product_idb9 . "','1','" . $product_code6 . "','" . $have_order . "','" . $clear_br6 . "','" . $clear_ivno6 . "','" . $jong_no6 . "','" . $jong_ckk6 . "','6')";
				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb10 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit10 . "','" . $unit10 . "','0.00','0.00','0.00','" . $sale_remarkk6 . "','0.00','0','0','0','" . $product_idb10 . "','" . $product_idb10 . "','1','" . $product_code6 . "','" . $have_order . "','" . $clear_br6 . "','" . $clear_ivno6 . "','" . $jong_no6 . "','" . $jong_ckk6 . "','6')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}
		} else {

			$strSQL6 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $sale_count6 . "','" . $sale_count6 . "','" . $product_price6 . "','" . $product_price6 . "','" . $sum_amount6 . "','" . $sale_remarkk6 . "','" . $discount_unit6 . "','" . $warranty6 . "','" . $cal6 . "','" . $pm6 . "','" . $product_id6 . "','" . $product_id6 . "','" . $have_order . "','" . $clear_br6 . "','" . $clear_ivno6 . "','" . $jong_no6 . "','" . $jong_ckk6 . "','6')";

			$objQuery6 = mysqli_query($conn, $strSQL6);
			if ($objQuery6) {
				applyHosSubsoInsertExtras($conn, mysqli_insert_id($conn), $_POST["product_sn6"] ?? ($_POST["sn6"] ?? ''), $_POST["pm_year6"] ?? '', $_POST["display_name6"] ?? '');
			}
		}
	}


	if ($product_id7 != '' && ($_POST["subso_db_id7"] ?? '') === '') {

		$strSQL31 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '" . $product_code7 . "' ";
		$objQuery31 = mysqli_query($conn, $strSQL31) or die("Error Query [" . $strSQL31 . "]");
		$Num_Rows31 = mysqli_num_rows($objQuery31);
		if ($Num_Rows31 > 0) {

			$objResult31 = mysqli_fetch_array($objQuery31);

			$product_idb1 = $objResult31["product_id1"] ?? '';
			$product_idb2 = $objResult31["product_id2"] ?? '';
			$product_idb3 = $objResult31["product_id3"] ?? '';
			$product_idb4 = $objResult31["product_id4"] ?? '';
			$product_idb5 = $objResult31["product_id5"] ?? '';
			$product_idb6 = $objResult31["product_id6"] ?? '';
			$product_idb7 = $objResult31["product_id7"] ?? '';
			$product_idb8 = $objResult31["product_id8"] ?? '';
			$product_idb9 = $objResult31["product_id9"] ?? '';
			$product_idb10 = $objResult31["product_id10"] ?? '';

			$unit1 = (float)($sale_count7 ?? 0) * (float)($objResult31["unit1"] ?? 0);
			$unit2 = (float)($sale_count7 ?? 0) * (float)($objResult31["unit2"] ?? 0);
			$unit3 = (float)($sale_count7 ?? 0) * (float)($objResult31["unit3"] ?? 0);
			$unit4 = (float)($sale_count7 ?? 0) * (float)($objResult31["unit4"] ?? 0);
			$unit5 = (float)($sale_count7 ?? 0) * (float)($objResult31["unit5"] ?? 0);
			$unit6 = (float)($sale_count7 ?? 0) * (float)($objResult31["unit6"] ?? 0);
			$unit7 = (float)($sale_count7 ?? 0) * (float)($objResult31["unit7"] ?? 0);
			$unit8 = (float)($sale_count7 ?? 0) * (float)($objResult31["unit8"] ?? 0);
			$unit9 = (float)($sale_count7 ?? 0) * (float)($objResult31["unit9"] ?? 0);
			$unit10 = (float)($sale_count7 ?? 0) * (float)($objResult31["unit10"] ?? 0);

			if ($product_idb1 != '') {

				$strSQL104 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,code_bom,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit1 . "','" . $unit1 . "','" . $product_price7 . "','" . $product_price7 . "','" . $sum_amount7 . "','" . $sale_remarkk7 . "','" . $discount_unit7 . "','" . $warranty7 . "','" . $cal7 . "','" . $pm7 . "','" . $product_idb1 . "','" . $product_idb1 . "','" . $product_code7 . "','1','" . $product_code7 . "','" . $have_order . "','" . $clear_br7 . "','" . $clear_ivno7 . "','" . $jong_no7 . "','" . $jong_ckk7 . "','7')";

				$objQuery104 = mysqli_query($conn, $strSQL104);
			}

			if ($product_idb2 != '') {

				$strSQL100 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit2 . "','" . $unit2 . "','0.00','0.00','0.00','" . $sale_remarkk7 . "','0.00','0','0','0','" . $product_idb2 . "','" . $product_idb2 . "','1','" . $product_code7 . "','" . $have_order . "','" . $clear_br7 . "','" . $clear_ivno7 . "','" . $jong_no7 . "','" . $jong_ckk7 . "','7')";
				$objQuery100 = mysqli_query($conn, $strSQL100);
			}

			if ($product_idb3 != '') {

				$strSQL101 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit3 . "','" . $unit3 . "','0.00','0.00','0.00','" . $sale_remarkk7 . "','0.00','0','0','0','" . $product_idb3 . "','" . $product_idb3 . "','1','" . $product_code7 . "','" . $have_order . "','" . $clear_br7 . "','" . $clear_ivno7 . "','" . $jong_no7 . "','" . $jong_ckk7 . "','7')";

				$objQuery101 = mysqli_query($conn, $strSQL101);
			}

			if ($product_idb4 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit4 . "','" . $unit4 . "','0.00','0.00','0.00','" . $sale_remarkk7 . "','0.00','0','0','0','" . $product_idb4 . "','" . $product_idb4 . "','1','" . $product_code7 . "','" . $have_order . "','" . $clear_br7 . "','" . $clear_ivno7 . "','" . $jong_no7 . "','" . $jong_ckk7 . "','7')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb5 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit5 . "','" . $unit5 . "','0.00','0.00','0.00','" . $sale_remarkk7 . "','0.00','0','0','0','" . $product_idb5 . "','" . $product_idb5 . "','1','" . $product_code7 . "','" . $have_order . "','" . $clear_br7 . "','" . $clear_ivno7 . "','" . $jong_no7 . "','" . $jong_ckk7 . "','7')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb6 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit6 . "','" . $unit6 . "','0.00','0.00','0.00','" . $sale_remarkk7 . "','0.00','0','0','0','" . $product_idb6 . "','" . $product_idb6 . "','1','" . $product_code7 . "','" . $have_order . "','" . $clear_br7 . "','" . $clear_ivno7 . "','" . $jong_no7 . "','" . $jong_ckk7 . "','7')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb7 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit7 . "','" . $unit7 . "','0.00','0.00','0.00','" . $sale_remarkk7 . "','0.00','0','0','0','" . $product_idb7 . "','" . $product_idb7 . "','1','" . $product_code7 . "','" . $have_order . "','" . $clear_br7 . "','" . $clear_ivno7 . "','" . $jong_no7 . "','" . $jong_ckk7 . "','7')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb8 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit8 . "','" . $unit8 . "','0.00','0.00','0.00','" . $sale_remarkk7 . "','0.00','0','0','0','" . $product_idb8 . "','" . $product_idb8 . "','1','" . $product_code7 . "','" . $have_order . "','" . $clear_br7 . "','" . $clear_ivno7 . "','" . $jong_no7 . "','" . $jong_ckk7 . "','7')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb9 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit9 . "','" . $unit9 . "','0.00','0.00','0.00','" . $sale_remarkk7 . "','0.00','0','0','0','" . $product_idb9 . "','" . $product_idb9 . "','1','" . $product_code7 . "','" . $have_order . "','" . $clear_br7 . "','" . $clear_ivno7 . "','" . $jong_no7 . "','" . $jong_ckk7 . "','7')";
				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb10 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit10 . "','" . $unit10 . "','0.00','0.00','0.00','" . $sale_remarkk7 . "','0.00','0','0','0','" . $product_idb10 . "','" . $product_idb10 . "','1','" . $product_code7 . "','" . $have_order . "','" . $clear_br7 . "','" . $clear_ivno7 . "','" . $jong_no7 . "','" . $jong_ckk7 . "','7')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}
		} else {

			$strSQL7 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $sale_count7 . "','" . $sale_count7 . "','" . $product_price7 . "','" . $product_price7 . "','" . $sum_amount7 . "','" . $sale_remarkk7 . "','" . $discount_unit7 . "','" . $warranty7 . "','" . $cal7 . "','" . $pm7 . "','" . $product_id7 . "','" . $product_id7 . "','" . $have_order . "','" . $clear_br7 . "','" . $clear_ivno7 . "','" . $jong_no7 . "','" . $jong_ckk7 . "','7')";

			$objQuery7 = mysqli_query($conn, $strSQL7);
			if ($objQuery7) {
				applyHosSubsoInsertExtras($conn, mysqli_insert_id($conn), $_POST["product_sn7"] ?? ($_POST["sn7"] ?? ''), $_POST["pm_year7"] ?? '', $_POST["display_name7"] ?? '');
			}
		}
	}


	if ($product_id8 != '' && ($_POST["subso_db_id8"] ?? '') === '') {

		$strSQL31 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '" . $product_code8 . "' ";
		$objQuery31 = mysqli_query($conn, $strSQL31) or die("Error Query [" . $strSQL31 . "]");
		$Num_Rows31 = mysqli_num_rows($objQuery31);
		if ($Num_Rows31 > 0) {

			$objResult31 = mysqli_fetch_array($objQuery31);

			$product_idb1 = $objResult31["product_id1"] ?? '';
			$product_idb2 = $objResult31["product_id2"] ?? '';
			$product_idb3 = $objResult31["product_id3"] ?? '';
			$product_idb4 = $objResult31["product_id4"] ?? '';
			$product_idb5 = $objResult31["product_id5"] ?? '';
			$product_idb6 = $objResult31["product_id6"] ?? '';
			$product_idb7 = $objResult31["product_id7"] ?? '';
			$product_idb8 = $objResult31["product_id8"] ?? '';
			$product_idb9 = $objResult31["product_id9"] ?? '';
			$product_idb10 = $objResult31["product_id10"] ?? '';

			$unit1 = (float)($sale_count8 ?? 0) * (float)($objResult31["unit1"] ?? 0);
			$unit2 = (float)($sale_count8 ?? 0) * (float)($objResult31["unit2"] ?? 0);
			$unit3 = (float)($sale_count8 ?? 0) * (float)($objResult31["unit3"] ?? 0);
			$unit4 = (float)($sale_count8 ?? 0) * (float)($objResult31["unit4"] ?? 0);
			$unit5 = (float)($sale_count8 ?? 0) * (float)($objResult31["unit5"] ?? 0);
			$unit6 = (float)($sale_count8 ?? 0) * (float)($objResult31["unit6"] ?? 0);
			$unit7 = (float)($sale_count8 ?? 0) * (float)($objResult31["unit7"] ?? 0);
			$unit8 = (float)($sale_count8 ?? 0) * (float)($objResult31["unit8"] ?? 0);
			$unit9 = (float)($sale_count8 ?? 0) * (float)($objResult31["unit9"] ?? 0);
			$unit10 = (float)($sale_count8 ?? 0) * (float)($objResult31["unit10"] ?? 0);

			if ($product_idb1 != '') {

				$strSQL104 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,code_bom,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit1 . "','" . $unit1 . "','" . $product_price8 . "','" . $product_price8 . "','" . $sum_amount8 . "','" . $sale_remarkk8 . "','" . $discount_unit8 . "','" . $warranty8 . "','" . $cal8 . "','" . $pm8 . "','" . $product_idb1 . "','" . $product_idb1 . "','" . $product_code8 . "','1','" . $product_code8 . "','" . $have_order . "','" . $clear_br8 . "','" . $clear_ivno8 . "','" . $jong_no8 . "','" . $jong_ckk8 . "','8')";

				$objQuery104 = mysqli_query($conn, $strSQL104);
			}

			if ($product_idb2 != '') {

				$strSQL100 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit2 . "','" . $unit2 . "','0.00','0.00','0.00','" . $sale_remarkk8 . "','0.00','0','0','0','" . $product_idb2 . "','" . $product_idb2 . "','1','" . $product_code8 . "','" . $have_order . "','" . $clear_br8 . "','" . $clear_ivno8 . "','" . $jong_no8 . "','" . $jong_ckk8 . "','8')";
				$objQuery100 = mysqli_query($conn, $strSQL100);
			}

			if ($product_idb3 != '') {

				$strSQL101 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit3 . "','" . $unit3 . "','0.00','0.00','0.00','" . $sale_remarkk8 . "','0.00','0','0','0','" . $product_idb3 . "','" . $product_idb3 . "','1','" . $product_code8 . "','" . $have_order . "','" . $clear_br8 . "','" . $clear_ivno8 . "','" . $jong_no8 . "','" . $jong_ckk8 . "','8')";

				$objQuery101 = mysqli_query($conn, $strSQL101);
			}

			if ($product_idb4 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit4 . "','" . $unit4 . "','0.00','0.00','0.00','" . $sale_remarkk8 . "','0.00','0','0','0','" . $product_idb4 . "','" . $product_idb4 . "','1','" . $product_code8 . "','" . $have_order . "','" . $clear_br8 . "','" . $clear_ivno8 . "','" . $jong_no8 . "','" . $jong_ckk8 . "','8')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb5 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit5 . "','" . $unit5 . "','0.00','0.00','0.00','" . $sale_remarkk8 . "','0.00','0','0','0','" . $product_idb5 . "','" . $product_idb5 . "','1','" . $product_code8 . "','" . $have_order . "','" . $clear_br8 . "','" . $clear_ivno8 . "','" . $jong_no8 . "','" . $jong_ckk8 . "','8')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb6 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit6 . "','" . $unit6 . "','0.00','0.00','0.00','" . $sale_remarkk8 . "','0.00','0','0','0','" . $product_idb6 . "','" . $product_idb6 . "','1','" . $product_code8 . "','" . $have_order . "','" . $clear_br8 . "','" . $clear_ivno8 . "','" . $jong_no8 . "','" . $jong_ckk8 . "','8')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb7 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit7 . "','" . $unit7 . "','0.00','0.00','0.00','" . $sale_remarkk8 . "','0.00','0','0','0','" . $product_idb7 . "','" . $product_idb7 . "','1','" . $product_code8 . "','" . $have_order . "','" . $clear_br8 . "','" . $clear_ivno8 . "','" . $jong_no8 . "','" . $jong_ckk8 . "','8')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb8 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit8 . "','" . $unit8 . "','0.00','0.00','0.00','" . $sale_remarkk8 . "','0.00','0','0','0','" . $product_idb8 . "','" . $product_idb8 . "','1','" . $product_code8 . "','" . $have_order . "','" . $clear_br8 . "','" . $clear_ivno8 . "','" . $jong_no8 . "','" . $jong_ckk8 . "','8')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb9 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit9 . "','" . $unit9 . "','0.00','0.00','0.00','" . $sale_remarkk8 . "','0.00','0','0','0','" . $product_idb9 . "','" . $product_idb9 . "','1','" . $product_code8 . "','" . $have_order . "','" . $clear_br8 . "','" . $clear_ivno8 . "','" . $jong_no8 . "','" . $jong_ckk8 . "','8')";
				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb10 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit10 . "','" . $unit10 . "','0.00','0.00','0.00','" . $sale_remarkk8 . "','0.00','0','0','0','" . $product_idb10 . "','" . $product_idb10 . "','1','" . $product_code8 . "','" . $have_order . "','" . $clear_br8 . "','" . $clear_ivno8 . "','" . $jong_no8 . "','" . $jong_ckk8 . "','8')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}
		} else {


			$strSQL8 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $sale_count8 . "','" . $sale_count8 . "','" . $product_price8 . "','" . $product_price8 . "','" . $sum_amount8 . "','" . $sale_remarkk8 . "','" . $discount_unit8 . "','" . $warranty8 . "','" . $cal8 . "','" . $pm8 . "','" . $product_id8 . "','" . $product_id8 . "','" . $have_order . "','" . $clear_br8 . "','" . $clear_ivno8 . "','" . $jong_no8 . "','" . $jong_ckk8 . "','8')";

			$objQuery8 = mysqli_query($conn, $strSQL8);
			if ($objQuery8) {
				applyHosSubsoInsertExtras($conn, mysqli_insert_id($conn), $_POST["product_sn8"] ?? ($_POST["sn8"] ?? ''), $_POST["pm_year8"] ?? '', $_POST["display_name8"] ?? '');
			}
		}
	}


	if ($product_id9 != '' && ($_POST["subso_db_id9"] ?? '') === '') {

		$strSQL31 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '" . $product_code9 . "' ";
		$objQuery31 = mysqli_query($conn, $strSQL31) or die("Error Query [" . $strSQL31 . "]");
		$Num_Rows31 = mysqli_num_rows($objQuery31);
		if ($Num_Rows31 > 0) {

			$objResult31 = mysqli_fetch_array($objQuery31);

			$product_idb1 = $objResult31["product_id1"] ?? '';
			$product_idb2 = $objResult31["product_id2"] ?? '';
			$product_idb3 = $objResult31["product_id3"] ?? '';
			$product_idb4 = $objResult31["product_id4"] ?? '';
			$product_idb5 = $objResult31["product_id5"] ?? '';
			$product_idb6 = $objResult31["product_id6"] ?? '';
			$product_idb7 = $objResult31["product_id7"] ?? '';
			$product_idb8 = $objResult31["product_id8"] ?? '';
			$product_idb9 = $objResult31["product_id9"] ?? '';
			$product_idb10 = $objResult31["product_id10"] ?? '';

			$unit1 = (float)($sale_count9 ?? 0) * (float)($objResult31["unit1"] ?? 0);
			$unit2 = (float)($sale_count9 ?? 0) * (float)($objResult31["unit2"] ?? 0);
			$unit3 = (float)($sale_count9 ?? 0) * (float)($objResult31["unit3"] ?? 0);
			$unit4 = (float)($sale_count9 ?? 0) * (float)($objResult31["unit4"] ?? 0);
			$unit5 = (float)($sale_count9 ?? 0) * (float)($objResult31["unit5"] ?? 0);
			$unit6 = (float)($sale_count9 ?? 0) * (float)($objResult31["unit6"] ?? 0);
			$unit7 = (float)($sale_count9 ?? 0) * (float)($objResult31["unit7"] ?? 0);
			$unit8 = (float)($sale_count9 ?? 0) * (float)($objResult31["unit8"] ?? 0);
			$unit9 = (float)($sale_count9 ?? 0) * (float)($objResult31["unit9"] ?? 0);
			$unit10 = (float)($sale_count9 ?? 0) * (float)($objResult31["unit10"] ?? 0);

			if ($product_idb1 != '') {

				$strSQL104 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,code_bom,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit1 . "','" . $unit1 . "','" . $product_price9 . "','" . $product_price9 . "','" . $sum_amount9 . "','" . $sale_remarkk9 . "','" . $discount_unit9 . "','" . $warranty9 . "','" . $cal9 . "','" . $pm9 . "','" . $product_idb1 . "','" . $product_idb1 . "','" . $product_code9 . "','1','" . $product_code9 . "','" . $have_order . "','" . $clear_br9 . "','" . $clear_ivno9 . "','" . $jong_no9 . "','" . $jong_ckk9 . "','9')";

				$objQuery104 = mysqli_query($conn, $strSQL104);
			}

			if ($product_idb2 != '') {

				$strSQL100 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit2 . "','" . $unit2 . "','0.00','0.00','0.00','" . $sale_remarkk9 . "','0.00','0','0','0','" . $product_idb2 . "','" . $product_idb2 . "','1','" . $product_code9 . "','" . $have_order . "','" . $clear_br9 . "','" . $clear_ivno9 . "','" . $jong_no9 . "','" . $jong_ckk9 . "','9')";
				$objQuery100 = mysqli_query($conn, $strSQL100);
			}

			if ($product_idb3 != '') {

				$strSQL101 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit3 . "','" . $unit3 . "','0.00','0.00','0.00','" . $sale_remarkk9 . "','0.00','0','0','0','" . $product_idb3 . "','" . $product_idb3 . "','1','" . $product_code9 . "','" . $have_order . "','" . $clear_br9 . "','" . $clear_ivno9 . "','" . $jong_no9 . "','" . $jong_ckk9 . "','9')";

				$objQuery101 = mysqli_query($conn, $strSQL101);
			}

			if ($product_idb4 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit4 . "','" . $unit4 . "','0.00','0.00','0.00','" . $sale_remarkk9 . "','0.00','0','0','0','" . $product_idb4 . "','" . $product_idb4 . "','1','" . $product_code9 . "','" . $have_order . "','" . $clear_br9 . "','" . $clear_ivno9 . "','" . $jong_no9 . "','" . $jong_ckk9 . "','9')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb5 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit5 . "','" . $unit5 . "','0.00','0.00','0.00','" . $sale_remarkk9 . "','0.00','0','0','0','" . $product_idb5 . "','" . $product_idb5 . "','1','" . $product_code9 . "','" . $have_order . "','" . $clear_br9 . "','" . $clear_ivno9 . "','" . $jong_no9 . "','" . $jong_ckk9 . "','9')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb6 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit6 . "','" . $unit6 . "','0.00','0.00','0.00','" . $sale_remarkk9 . "','0.00','0','0','0','" . $product_idb6 . "','" . $product_idb6 . "','1','" . $product_code9 . "','" . $have_order . "','" . $clear_br9 . "','" . $clear_ivno9 . "','" . $jong_no9 . "','" . $jong_ckk9 . "','9')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb7 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit7 . "','" . $unit7 . "','0.00','0.00','0.00','" . $sale_remarkk9 . "','0.00','0','0','0','" . $product_idb7 . "','" . $product_idb7 . "','1','" . $product_code9 . "','" . $have_order . "','" . $clear_br9 . "','" . $clear_ivno9 . "','" . $jong_no9 . "','" . $jong_ckk9 . "','9')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb8 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit8 . "','" . $unit8 . "','0.00','0.00','0.00','" . $sale_remarkk9 . "','0.00','0','0','0','" . $product_idb8 . "','" . $product_idb8 . "','1','" . $product_code9 . "','" . $have_order . "','" . $clear_br9 . "','" . $clear_ivno9 . "','" . $jong_no9 . "','" . $jong_ckk9 . "','9')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb9 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit9 . "','" . $unit9 . "','0.00','0.00','0.00','" . $sale_remarkk9 . "','0.00','0','0','0','" . $product_idb9 . "','" . $product_idb9 . "','1','" . $product_code9 . "','" . $have_order . "','" . $clear_br9 . "','" . $clear_ivno9 . "','" . $jong_no9 . "','" . $jong_ckk9 . "','9')";
				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb10 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit10 . "','" . $unit10 . "','0.00','0.00','0.00','" . $sale_remarkk9 . "','0.00','0','0','0','" . $product_idb10 . "','" . $product_idb10 . "','1','" . $product_code10 . "','" . $have_order . "','" . $clear_br9 . "','" . $clear_ivno9 . "','" . $jong_no9 . "','" . $jong_ckk9 . "','9')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}
		} else {


			$strSQL9 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $sale_count9 . "','" . $sale_count9 . "','" . $product_price9 . "','" . $product_price9 . "','" . $sum_amount9 . "','" . $sale_remarkk9 . "','" . $discount_unit9 . "','" . $warranty9 . "','" . $cal9 . "','" . $pm9 . "','" . $product_id9 . "','" . $product_id9 . "','" . $have_order . "','" . $clear_br9 . "','" . $clear_ivno9 . "','" . $jong_no9 . "','" . $jong_ckk9 . "','9')";

			$objQuery9 = mysqli_query($conn, $strSQL9);
			if ($objQuery9) {
				applyHosSubsoInsertExtras($conn, mysqli_insert_id($conn), $_POST["product_sn9"] ?? ($_POST["sn9"] ?? ''), $_POST["pm_year9"] ?? '', $_POST["display_name9"] ?? '');
			}
		}
	}


	if ($product_id10 != '' && ($_POST["subso_db_id10"] ?? '') === '') {

		$strSQL31 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '" . $product_code10 . "' ";
		$objQuery31 = mysqli_query($conn, $strSQL31) or die("Error Query [" . $strSQL31 . "]");
		$Num_Rows31 = mysqli_num_rows($objQuery31);
		if ($Num_Rows31 > 0) {

			$objResult31 = mysqli_fetch_array($objQuery31);

			$product_idb1 = $objResult31["product_id1"] ?? '';
			$product_idb2 = $objResult31["product_id2"] ?? '';
			$product_idb3 = $objResult31["product_id3"] ?? '';
			$product_idb4 = $objResult31["product_id4"] ?? '';
			$product_idb5 = $objResult31["product_id5"] ?? '';
			$product_idb6 = $objResult31["product_id6"] ?? '';
			$product_idb7 = $objResult31["product_id7"] ?? '';
			$product_idb8 = $objResult31["product_id8"] ?? '';
			$product_idb9 = $objResult31["product_id9"] ?? '';
			$product_idb10 = $objResult31["product_id10"] ?? '';

			$unit1 = (float)($sale_count10 ?? 0) * (float)($objResult31["unit1"] ?? 0);
			$unit2 = (float)($sale_count10 ?? 0) * (float)($objResult31["unit2"] ?? 0);
			$unit3 = (float)($sale_count10 ?? 0) * (float)($objResult31["unit3"] ?? 0);
			$unit4 = (float)($sale_count10 ?? 0) * (float)($objResult31["unit4"] ?? 0);
			$unit5 = (float)($sale_count10 ?? 0) * (float)($objResult31["unit5"] ?? 0);
			$unit6 = (float)($sale_count10 ?? 0) * (float)($objResult31["unit6"] ?? 0);
			$unit7 = (float)($sale_count10 ?? 0) * (float)($objResult31["unit7"] ?? 0);
			$unit8 = (float)($sale_count10 ?? 0) * (float)($objResult31["unit8"] ?? 0);
			$unit9 = (float)($sale_count10 ?? 0) * (float)($objResult31["unit9"] ?? 0);
			$unit10 = (float)($sale_count10 ?? 0) * (float)($objResult31["unit10"] ?? 0);

			if ($product_idb1 != '') {

				$strSQL104 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,code_bom,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit1 . "','" . $unit1 . "','" . $product_price10 . "','" . $product_price10 . "','" . $sum_amount10 . "','" . $sale_remarkk10 . "','" . $discount_unit10 . "','" . $warranty10 . "','" . $cal10 . "','" . $pm10 . "','" . $product_idb1 . "','" . $product_idb1 . "','" . $product_code10 . "','1','" . $product_code10 . "','" . $have_order . "','" . $clear_br10 . "','" . $clear_ivno10 . "','" . $jong_no10 . "','" . $jong_ckk10 . "','10')";

				$objQuery104 = mysqli_query($conn, $strSQL104);
			}

			if ($product_idb2 != '') {

				$strSQL100 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit2 . "','" . $unit2 . "','0.00','0.00','0.00','" . $sale_remarkk10 . "','0.00','0','0','0','" . $product_idb2 . "','" . $product_idb2 . "','1','" . $product_code10 . "','" . $have_order . "','" . $clear_br10 . "','" . $clear_ivno10 . "','" . $jong_no10 . "','" . $jong_ckk10 . "','10')";
				$objQuery100 = mysqli_query($conn, $strSQL100);
			}

			if ($product_idb3 != '') {

				$strSQL101 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit3 . "','" . $unit3 . "','0.00','0.00','0.00','" . $sale_remarkk10 . "','0.00','0','0','0','" . $product_idb3 . "','" . $product_idb3 . "','1','" . $product_code10 . "','" . $have_order . "','" . $clear_br10 . "','" . $clear_ivno10 . "','" . $jong_no10 . "','" . $jong_ckk10 . "','10')";

				$objQuery101 = mysqli_query($conn, $strSQL101);
			}

			if ($product_idb4 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit4 . "','" . $unit4 . "','0.00','0.00','0.00','" . $sale_remarkk10 . "','0.00','0','0','0','" . $product_idb4 . "','" . $product_idb4 . "','1','" . $product_code10 . "','" . $have_order . "','" . $clear_br10 . "','" . $clear_ivno10 . "','" . $jong_no10 . "','" . $jong_ckk10 . "','10')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb5 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit5 . "','" . $unit5 . "','0.00','0.00','0.00','" . $sale_remarkk10 . "','0.00','0','0','0','" . $product_idb5 . "','" . $product_idb5 . "','1','" . $product_code10 . "','" . $have_order . "','" . $clear_br10 . "','" . $clear_ivno10 . "','" . $jong_no10 . "','" . $jong_ckk10 . "','10')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb6 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit6 . "','" . $unit6 . "','0.00','0.00','0.00','" . $sale_remarkk10 . "','0.00','0','0','0','" . $product_idb6 . "','" . $product_idb6 . "','1','" . $product_code10 . "','" . $have_order . "','" . $clear_br10 . "','" . $clear_ivno10 . "','" . $jong_no10 . "','" . $jong_ckk10 . "','10')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb7 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit7 . "','" . $unit7 . "','0.00','0.00','0.00','" . $sale_remarkk10 . "','0.00','0','0','0','" . $product_idb7 . "','" . $product_idb7 . "','1','" . $product_code10 . "','" . $have_order . "','" . $clear_br10 . "','" . $clear_ivno10 . "','" . $jong_no10 . "','" . $jong_ckk10 . "','10')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb8 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit8 . "','" . $unit8 . "','0.00','0.00','0.00','" . $sale_remarkk10 . "','0.00','0','0','0','" . $product_idb8 . "','" . $product_idb8 . "','1','" . $product_code10 . "','" . $have_order . "','" . $clear_br10 . "','" . $clear_ivno10 . "','" . $jong_no10 . "','" . $jong_ckk10 . "','10')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb9 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit9 . "','" . $unit9 . "','0.00','0.00','0.00','" . $sale_remarkk10 . "','0.00','0','0','0','" . $product_idb9 . "','" . $product_idb9 . "','1','" . $product_code10 . "','" . $have_order . "','" . $clear_br10 . "','" . $clear_ivno10 . "','" . $jong_no10 . "','" . $jong_ckk10 . "','10')";
				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb10 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit10 . "','" . $unit10 . "','0.00','0.00','0.00','" . $sale_remarkk10 . "','0.00','0','0','0','" . $product_idb10 . "','" . $product_idb10 . "','1','" . $product_code10 . "','" . $have_order . "','" . $clear_br10 . "','" . $clear_ivno10 . "','" . $jong_no10 . "','" . $jong_ckk10 . "','10')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}
		} else {


			$strSQL10 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $sale_count10 . "','" . $sale_count10 . "','" . $product_price10 . "','" . $product_price10 . "','" . $sum_amount10 . "','" . $sale_remarkk10 . "','" . $discount_unit10 . "','" . $warranty10 . "','" . $cal10 . "','" . $pm10 . "','" . $product_id10 . "','" . $product_id10 . "','" . $have_order . "','" . $clear_br10 . "','" . $clear_ivno10 . "','" . $jong_no10 . "','" . $jong_ckk10 . "','10')";

			$objQuery10 = mysqli_query($conn, $strSQL10);
			if ($objQuery10) {
				applyHosSubsoInsertExtras($conn, mysqli_insert_id($conn), $_POST["product_sn10"] ?? ($_POST["sn10"] ?? ''), $_POST["pm_year10"] ?? '', $_POST["display_name10"] ?? '');
			}
		}
	}


	////////////

	if ($product_id11 != '' && ($_POST["subso_db_id11"] ?? '') === '') {

		$strSQL31 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '" . $product_code11 . "' ";
		$objQuery31 = mysqli_query($conn, $strSQL31) or die("Error Query [" . $strSQL31 . "]");
		$Num_Rows31 = mysqli_num_rows($objQuery31);
		if ($Num_Rows31 > 0) {

			$objResult31 = mysqli_fetch_array($objQuery31);

			$product_idb1 = $objResult31["product_id1"] ?? '';
			$product_idb2 = $objResult31["product_id2"] ?? '';
			$product_idb3 = $objResult31["product_id3"] ?? '';
			$product_idb4 = $objResult31["product_id4"] ?? '';
			$product_idb5 = $objResult31["product_id5"] ?? '';
			$product_idb6 = $objResult31["product_id6"] ?? '';
			$product_idb7 = $objResult31["product_id7"] ?? '';
			$product_idb8 = $objResult31["product_id8"] ?? '';
			$product_idb9 = $objResult31["product_id9"] ?? '';
			$product_idb10 = $objResult31["product_id10"] ?? '';

			$unit1 = (float)($sale_count11 ?? 0) * (float)($objResult31["unit1"] ?? 0);
			$unit2 = (float)($sale_count11 ?? 0) * (float)($objResult31["unit2"] ?? 0);
			$unit3 = (float)($sale_count11 ?? 0) * (float)($objResult31["unit3"] ?? 0);
			$unit4 = (float)($sale_count11 ?? 0) * (float)($objResult31["unit4"] ?? 0);
			$unit5 = (float)($sale_count11 ?? 0) * (float)($objResult31["unit5"] ?? 0);
			$unit6 = (float)($sale_count11 ?? 0) * (float)($objResult31["unit6"] ?? 0);
			$unit7 = (float)($sale_count11 ?? 0) * (float)($objResult31["unit7"] ?? 0);
			$unit8 = (float)($sale_count11 ?? 0) * (float)($objResult31["unit8"] ?? 0);
			$unit9 = (float)($sale_count11 ?? 0) * (float)($objResult31["unit9"] ?? 0);
			$unit10 = (float)($sale_count11 ?? 0) * (float)($objResult31["unit10"] ?? 0);

			if ($product_idb1 != '') {

				$strSQL104 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,code_bom,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit1 . "','" . $unit1 . "','" . $product_price11 . "','" . $product_price11 . "','" . $sum_amount11 . "','" . $sale_remarkk11 . "','" . $discount_unit11 . "','" . $warranty11 . "','" . $cal11 . "','" . $pm11 . "','" . $product_idb1 . "','" . $product_idb1 . "','" . $product_code11 . "','1','" . $product_code11 . "','" . $have_order . "','" . $clear_br11 . "','" . $clear_ivno11 . "','" . $jong_no11 . "','" . $jong_ckk11 . "','11')";

				$objQuery104 = mysqli_query($conn, $strSQL104);
			}

			if ($product_idb2 != '') {

				$strSQL100 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit2 . "','" . $unit2 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb2 . "','" . $product_idb2 . "','1','" . $product_code11 . "','" . $have_order . "','" . $clear_br11 . "','" . $clear_ivno11 . "','" . $jong_no11 . "','" . $jong_ckk11 . "','11')";
				$objQuery100 = mysqli_query($conn, $strSQL100);
			}

			if ($product_idb3 != '') {

				$strSQL101 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit3 . "','" . $unit3 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb3 . "','" . $product_idb3 . "','1','" . $product_code11 . "','" . $have_order . "','" . $clear_br11 . "','" . $clear_ivno11 . "','" . $jong_no11 . "','" . $jong_ckk11 . "','11')";

				$objQuery101 = mysqli_query($conn, $strSQL101);
			}

			if ($product_idb4 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit4 . "','" . $unit4 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb4 . "','" . $product_idb4 . "','1','" . $product_code11 . "','" . $have_order . "','" . $clear_br11 . "','" . $clear_ivno11 . "','" . $jong_no11 . "','" . $jong_ckk11 . "','11')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb5 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit5 . "','" . $unit5 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb5 . "','" . $product_idb5 . "','1','" . $product_code11 . "','" . $have_order . "','" . $clear_br11 . "','" . $clear_ivno11 . "','" . $jong_no11 . "','" . $jong_ckk11 . "','11')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb6 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit6 . "','" . $unit6 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb6 . "','" . $product_idb6 . "','1','" . $product_code11 . "','" . $have_order . "','" . $clear_br11 . "','" . $clear_ivno11 . "','" . $jong_no11 . "','" . $jong_ckk11 . "','11')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb7 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit7 . "','" . $unit7 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb7 . "','" . $product_idb7 . "','1','" . $product_code11 . "','" . $have_order . "','" . $clear_br11 . "','" . $clear_ivno11 . "','" . $jong_no11 . "','" . $jong_ckk11 . "','11')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb8 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit8 . "','" . $unit8 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb8 . "','" . $product_idb8 . "','1','" . $product_code11 . "','" . $have_order . "','" . $clear_br11 . "','" . $clear_ivno11 . "','" . $jong_no11 . "','" . $jong_ckk11 . "','11')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb9 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit9 . "','" . $unit9 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb9 . "','" . $product_idb9 . "','1','" . $product_code11 . "','" . $have_order . "','" . $clear_br11 . "','" . $clear_ivno11 . "','" . $jong_no11 . "','" . $jong_ckk11 . "','11')";
				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb10 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit10 . "','" . $unit10 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb10 . "','" . $product_idb10 . "','1','" . $product_code11 . "','" . $have_order . "','" . $clear_br11 . "','" . $clear_ivno11 . "','" . $jong_no11 . "','" . $jong_ckk11 . "','11')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}
		} else {

			$strSQL11 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $sale_count11 . "','" . $sale_count11 . "','" . $product_price11 . "','" . $product_price11 . "','" . $sum_amount11 . "','" . $sale_remarkk11 . "','" . $discount_unit11 . "','" . $warranty11 . "','" . $cal11 . "','" . $pm11 . "','" . $product_id11 . "','" . $product_id11 . "','" . $have_order . "','" . $clear_br11 . "','" . $clear_ivno11 . "','" . $jong_no11 . "','" . $jong_ckk11 . "','11')";

			$objQuery11 = mysqli_query($conn, $strSQL11);
			if ($objQuery11) {
				applyHosSubsoInsertExtras($conn, mysqli_insert_id($conn), $_POST["product_sn11"] ?? ($_POST["sn11"] ?? ''), $_POST["pm_year11"] ?? '', $_POST["display_name11"] ?? '');
			}
		}
	}

	if ($product_id12 != '' && ($_POST["subso_db_id12"] ?? '') === '') {

		$strSQL31 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '" . $product_code12 . "' ";
		$objQuery31 = mysqli_query($conn, $strSQL31) or die("Error Query [" . $strSQL31 . "]");
		$Num_Rows31 = mysqli_num_rows($objQuery31);
		if ($Num_Rows31 > 0) {

			$objResult31 = mysqli_fetch_array($objQuery31);

			$product_idb1 = $objResult31["product_id1"] ?? '';
			$product_idb2 = $objResult31["product_id2"] ?? '';
			$product_idb3 = $objResult31["product_id3"] ?? '';
			$product_idb4 = $objResult31["product_id4"] ?? '';
			$product_idb5 = $objResult31["product_id5"] ?? '';
			$product_idb6 = $objResult31["product_id6"] ?? '';
			$product_idb7 = $objResult31["product_id7"] ?? '';
			$product_idb8 = $objResult31["product_id8"] ?? '';
			$product_idb9 = $objResult31["product_id9"] ?? '';
			$product_idb10 = $objResult31["product_id10"] ?? '';

			$unit1 = (float)($sale_count12 ?? 0) * (float)($objResult31["unit1"] ?? 0);
			$unit2 = (float)($sale_count12 ?? 0) * (float)($objResult31["unit2"] ?? 0);
			$unit3 = (float)($sale_count12 ?? 0) * (float)($objResult31["unit3"] ?? 0);
			$unit4 = (float)($sale_count12 ?? 0) * (float)($objResult31["unit4"] ?? 0);
			$unit5 = (float)($sale_count12 ?? 0) * (float)($objResult31["unit5"] ?? 0);
			$unit6 = (float)($sale_count12 ?? 0) * (float)($objResult31["unit6"] ?? 0);
			$unit7 = (float)($sale_count12 ?? 0) * (float)($objResult31["unit7"] ?? 0);
			$unit8 = (float)($sale_count12 ?? 0) * (float)($objResult31["unit8"] ?? 0);
			$unit9 = (float)($sale_count12 ?? 0) * (float)($objResult31["unit9"] ?? 0);
			$unit10 = (float)($sale_count12 ?? 0) * (float)($objResult31["unit10"] ?? 0);

			if ($product_idb1 != '') {

				$strSQL104 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,code_bom,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit1 . "','" . $unit1 . "','" . $product_price12 . "','" . $product_price12 . "','" . $sum_amount12 . "','" . $sale_remarkk12 . "','" . $discount_unit12 . "','" . $warranty12 . "','" . $cal12 . "','" . $pm12 . "','" . $product_idb1 . "','" . $product_idb1 . "','" . $product_code12 . "','1','" . $product_code12 . "','" . $have_order . "','" . $clear_br12 . "','" . $clear_ivno12 . "','" . $jong_no12 . "','" . $jong_ckk12 . "','12')";

				$objQuery104 = mysqli_query($conn, $strSQL104);
			}

			if ($product_idb2 != '') {

				$strSQL100 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit2 . "','" . $unit2 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb2 . "','" . $product_idb2 . "','1','" . $product_code12 . "','" . $have_order . "','" . $clear_br12 . "','" . $clear_ivno12 . "','" . $jong_no12 . "','" . $jong_ckk12 . "','12')";
				$objQuery100 = mysqli_query($conn, $strSQL100);
			}

			if ($product_idb3 != '') {

				$strSQL101 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit3 . "','" . $unit3 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb3 . "','" . $product_idb3 . "','1','" . $product_code12 . "','" . $have_order . "','" . $clear_br12 . "','" . $clear_ivno12 . "','" . $jong_no12 . "','" . $jong_ckk12 . "','12')";

				$objQuery101 = mysqli_query($conn, $strSQL101);
			}

			if ($product_idb4 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit4 . "','" . $unit4 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb4 . "','" . $product_idb4 . "','1','" . $product_code12 . "','" . $have_order . "','" . $clear_br12 . "','" . $clear_ivno12 . "','" . $jong_no12 . "','" . $jong_ckk12 . "','12')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb5 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit5 . "','" . $unit5 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb5 . "','" . $product_idb5 . "','1','" . $product_code12 . "','" . $have_order . "','" . $clear_br12 . "','" . $clear_ivno12 . "','" . $jong_no12 . "','" . $jong_ckk12 . "','12')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb6 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit6 . "','" . $unit6 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb6 . "','" . $product_idb6 . "','1','" . $product_code12 . "','" . $have_order . "','" . $clear_br12 . "','" . $clear_ivno12 . "','" . $jong_no12 . "','" . $jong_ckk12 . "','12')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb7 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit7 . "','" . $unit7 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb7 . "','" . $product_idb7 . "','1','" . $product_code12 . "','" . $have_order . "','" . $clear_br12 . "','" . $clear_ivno12 . "','" . $jong_no12 . "','" . $jong_ckk12 . "','12')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb8 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit8 . "','" . $unit8 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb8 . "','" . $product_idb8 . "','1','" . $product_code12 . "','" . $have_order . "','" . $clear_br12 . "','" . $clear_ivno12 . "','" . $jong_no12 . "','" . $jong_ckk12 . "','12')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb9 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit9 . "','" . $unit9 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb9 . "','" . $product_idb9 . "','1','" . $product_code12 . "','" . $have_order . "','" . $clear_br12 . "','" . $clear_ivno12 . "','" . $jong_no12 . "','" . $jong_ckk12 . "','12')";
				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb10 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit10 . "','" . $unit10 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb10 . "','" . $product_idb10 . "','1','" . $product_code12 . "','" . $have_order . "','" . $clear_br12 . "','" . $clear_ivno12 . "','" . $jong_no12 . "','" . $jong_ckk12 . "','12')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}
		} else {

			$strSQL12 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $sale_count12 . "','" . $sale_count12 . "','" . $product_price12 . "','" . $product_price12 . "','" . $sum_amount12 . "','" . $sale_remarkk12 . "','" . $discount_unit12 . "','" . $warranty12 . "','" . $cal12 . "','" . $pm12 . "','" . $product_id12 . "','" . $product_id12 . "','" . $have_order . "','" . $clear_br12 . "','" . $clear_ivno12 . "','" . $jong_no12 . "','" . $jong_ckk12 . "','12')";

			$objQuery12 = mysqli_query($conn, $strSQL12);
			if ($objQuery12) {
				applyHosSubsoInsertExtras($conn, mysqli_insert_id($conn), $_POST["product_sn12"] ?? ($_POST["sn12"] ?? ''), $_POST["pm_year12"] ?? '', $_POST["display_name12"] ?? '');
			}
		}
	}

	if ($product_id13 != '' && ($_POST["subso_db_id13"] ?? '') === '') {

		$strSQL31 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '" . $product_code13 . "' ";
		$objQuery31 = mysqli_query($conn, $strSQL31) or die("Error Query [" . $strSQL31 . "]");
		$Num_Rows31 = mysqli_num_rows($objQuery31);
		if ($Num_Rows31 > 0) {

			$objResult31 = mysqli_fetch_array($objQuery31);

			$product_idb1 = $objResult31["product_id1"] ?? '';
			$product_idb2 = $objResult31["product_id2"] ?? '';
			$product_idb3 = $objResult31["product_id3"] ?? '';
			$product_idb4 = $objResult31["product_id4"] ?? '';
			$product_idb5 = $objResult31["product_id5"] ?? '';
			$product_idb6 = $objResult31["product_id6"] ?? '';
			$product_idb7 = $objResult31["product_id7"] ?? '';
			$product_idb8 = $objResult31["product_id8"] ?? '';
			$product_idb9 = $objResult31["product_id9"] ?? '';
			$product_idb10 = $objResult31["product_id10"] ?? '';

			$unit1 = (float)($sale_count13 ?? 0) * (float)($objResult31["unit1"] ?? 0);
			$unit2 = (float)($sale_count13 ?? 0) * (float)($objResult31["unit2"] ?? 0);
			$unit3 = (float)($sale_count13 ?? 0) * (float)($objResult31["unit3"] ?? 0);
			$unit4 = (float)($sale_count13 ?? 0) * (float)($objResult31["unit4"] ?? 0);
			$unit5 = (float)($sale_count13 ?? 0) * (float)($objResult31["unit5"] ?? 0);
			$unit6 = (float)($sale_count13 ?? 0) * (float)($objResult31["unit6"] ?? 0);
			$unit7 = (float)($sale_count13 ?? 0) * (float)($objResult31["unit7"] ?? 0);
			$unit8 = (float)($sale_count13 ?? 0) * (float)($objResult31["unit8"] ?? 0);
			$unit9 = (float)($sale_count13 ?? 0) * (float)($objResult31["unit9"] ?? 0);
			$unit10 = (float)($sale_count13 ?? 0) * (float)($objResult31["unit10"] ?? 0);

			if ($product_idb1 != '') {

				$strSQL104 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,code_bom,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit1 . "','" . $unit1 . "','" . $product_price13 . "','" . $product_price13 . "','" . $sum_amount13 . "','" . $sale_remarkk13 . "','" . $discount_unit13 . "','" . $warranty13 . "','" . $cal13 . "','" . $pm13 . "','" . $product_idb1 . "','" . $product_idb1 . "','" . $product_code13 . "','1','" . $product_code13 . "','" . $have_order . "','" . $clear_br13 . "','" . $clear_ivno13 . "','" . $jong_no13 . "','" . $jong_ckk13 . "','13')";

				$objQuery104 = mysqli_query($conn, $strSQL104);
			}

			if ($product_idb2 != '') {

				$strSQL100 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit2 . "','" . $unit2 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb2 . "','" . $product_idb2 . "','1','" . $product_code13 . "','" . $have_order . "','" . $clear_br13 . "','" . $clear_ivno13 . "','" . $jong_no13 . "','" . $jong_ckk13 . "','13')";
				$objQuery100 = mysqli_query($conn, $strSQL100);
			}

			if ($product_idb3 != '') {

				$strSQL101 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit3 . "','" . $unit3 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb3 . "','" . $product_idb3 . "','1','" . $product_code13 . "','" . $have_order . "','" . $clear_br13 . "','" . $clear_ivno13 . "','" . $jong_no13 . "','" . $jong_ckk13 . "','13')";

				$objQuery101 = mysqli_query($conn, $strSQL101);
			}

			if ($product_idb4 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit4 . "','" . $unit4 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb4 . "','" . $product_idb4 . "','1','" . $product_code13 . "','" . $have_order . "','" . $clear_br13 . "','" . $clear_ivno13 . "','" . $jong_no13 . "','" . $jong_ckk13 . "','13')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb5 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit5 . "','" . $unit5 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb5 . "','" . $product_idb5 . "','1','" . $product_code13 . "','" . $have_order . "','" . $clear_br13 . "','" . $clear_ivno13 . "','" . $jong_no13 . "','" . $jong_ckk13 . "','13')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb6 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit6 . "','" . $unit6 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb6 . "','" . $product_idb6 . "','1','" . $product_code13 . "','" . $have_order . "','" . $clear_br13 . "','" . $clear_ivno13 . "','" . $jong_no13 . "','" . $jong_ckk13 . "','13')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb7 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit7 . "','" . $unit7 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb7 . "','" . $product_idb7 . "','1','" . $product_code13 . "','" . $have_order . "','" . $clear_br13 . "','" . $clear_ivno13 . "','" . $jong_no13 . "','" . $jong_ckk13 . "','13')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb8 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit8 . "','" . $unit8 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb8 . "','" . $product_idb8 . "','1','" . $product_code13 . "','" . $have_order . "','" . $clear_br13 . "','" . $clear_ivno13 . "','" . $jong_no13 . "','" . $jong_ckk13 . "','13')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb9 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit9 . "','" . $unit9 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb9 . "','" . $product_idb9 . "','1','" . $product_code13 . "','" . $have_order . "','" . $clear_br13 . "','" . $clear_ivno13 . "','" . $jong_no13 . "','" . $jong_ckk13 . "','13')";
				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb10 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit10 . "','" . $unit10 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb10 . "','" . $product_idb10 . "','1','" . $product_code13 . "','" . $have_order . "','" . $clear_br13 . "','" . $clear_ivno13 . "','" . $jong_no13 . "','" . $jong_ckk13 . "','13')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}
		} else {

			$strSQL13 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $sale_count13 . "','" . $sale_count13 . "','" . $product_price13 . "','" . $product_price13 . "','" . $sum_amount13 . "','" . $sale_remarkk13 . "','" . $discount_unit13 . "','" . $warranty13 . "','" . $cal13 . "','" . $pm13 . "','" . $product_id13 . "','" . $product_id13 . "','" . $have_order . "','" . $clear_br13 . "','" . $clear_ivno13 . "','" . $jong_no13 . "','" . $jong_ckk13 . "','13')";

			$objQuery13 = mysqli_query($conn, $strSQL13);
			if ($objQuery13) {
				applyHosSubsoInsertExtras($conn, mysqli_insert_id($conn), $_POST["product_sn13"] ?? ($_POST["sn13"] ?? ''), $_POST["pm_year13"] ?? '', $_POST["display_name13"] ?? '');
			}
		}
	}

	if ($product_id14 != '' && ($_POST["subso_db_id14"] ?? '') === '') {

		$strSQL31 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '" . $product_code14 . "' ";
		$objQuery31 = mysqli_query($conn, $strSQL31) or die("Error Query [" . $strSQL31 . "]");
		$Num_Rows31 = mysqli_num_rows($objQuery31);
		if ($Num_Rows31 > 0) {

			$objResult31 = mysqli_fetch_array($objQuery31);

			$product_idb1 = $objResult31["product_id1"] ?? '';
			$product_idb2 = $objResult31["product_id2"] ?? '';
			$product_idb3 = $objResult31["product_id3"] ?? '';
			$product_idb4 = $objResult31["product_id4"] ?? '';
			$product_idb5 = $objResult31["product_id5"] ?? '';
			$product_idb6 = $objResult31["product_id6"] ?? '';
			$product_idb7 = $objResult31["product_id7"] ?? '';
			$product_idb8 = $objResult31["product_id8"] ?? '';
			$product_idb9 = $objResult31["product_id9"] ?? '';
			$product_idb10 = $objResult31["product_id10"] ?? '';

			$unit1 = (float)($sale_count14 ?? 0) * (float)($objResult31["unit1"] ?? 0);
			$unit2 = (float)($sale_count14 ?? 0) * (float)($objResult31["unit2"] ?? 0);
			$unit3 = (float)($sale_count14 ?? 0) * (float)($objResult31["unit3"] ?? 0);
			$unit4 = (float)($sale_count14 ?? 0) * (float)($objResult31["unit4"] ?? 0);
			$unit5 = (float)($sale_count14 ?? 0) * (float)($objResult31["unit5"] ?? 0);
			$unit6 = (float)($sale_count14 ?? 0) * (float)($objResult31["unit6"] ?? 0);
			$unit7 = (float)($sale_count14 ?? 0) * (float)($objResult31["unit7"] ?? 0);
			$unit8 = (float)($sale_count14 ?? 0) * (float)($objResult31["unit8"] ?? 0);
			$unit9 = (float)($sale_count14 ?? 0) * (float)($objResult31["unit9"] ?? 0);
			$unit10 = (float)($sale_count14 ?? 0) * (float)($objResult31["unit10"] ?? 0);

			if ($product_idb1 != '') {

				$strSQL104 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,code_bom,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit1 . "','" . $unit1 . "','" . $product_price14 . "','" . $product_price14 . "','" . $sum_amount14 . "','" . $sale_remarkk14 . "','" . $discount_unit14 . "','" . $warranty14 . "','" . $cal14 . "','" . $pm14 . "','" . $product_idb1 . "','" . $product_idb1 . "','" . $product_code14 . "','1','" . $product_code14 . "','" . $have_order . "','" . $clear_br14 . "','" . $clear_ivno14 . "','" . $jong_no14 . "','" . $jong_ckk14 . "','14')";

				$objQuery104 = mysqli_query($conn, $strSQL104);
			}

			if ($product_idb2 != '') {

				$strSQL100 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit2 . "','" . $unit2 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb2 . "','" . $product_idb2 . "','1','" . $product_code14 . "','" . $have_order . "','" . $clear_br14 . "','" . $clear_ivno14 . "','" . $jong_no14 . "','" . $jong_ckk14 . "','14')";
				$objQuery100 = mysqli_query($conn, $strSQL100);
			}

			if ($product_idb3 != '') {

				$strSQL101 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit3 . "','" . $unit3 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb3 . "','" . $product_idb3 . "','1','" . $product_code14 . "','" . $have_order . "','" . $clear_br14 . "','" . $clear_ivno14 . "','" . $jong_no14 . "','" . $jong_ckk14 . "','14')";

				$objQuery101 = mysqli_query($conn, $strSQL101);
			}

			if ($product_idb4 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit4 . "','" . $unit4 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb4 . "','" . $product_idb4 . "','1','" . $product_code14 . "','" . $have_order . "','" . $clear_br14 . "','" . $clear_ivno14 . "','" . $jong_no14 . "','" . $jong_ckk14 . "','14')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb5 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit5 . "','" . $unit5 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb5 . "','" . $product_idb5 . "','1','" . $product_code14 . "','" . $have_order . "','" . $clear_br14 . "','" . $clear_ivno14 . "','" . $jong_no14 . "','" . $jong_ckk14 . "','14')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb6 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit6 . "','" . $unit6 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb6 . "','" . $product_idb6 . "','1','" . $product_code14 . "','" . $have_order . "','" . $clear_br14 . "','" . $clear_ivno14 . "','" . $jong_no14 . "','" . $jong_ckk14 . "','14')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb7 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit7 . "','" . $unit7 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb7 . "','" . $product_idb7 . "','1','" . $product_code14 . "','" . $have_order . "','" . $clear_br14 . "','" . $clear_ivno14 . "','" . $jong_no14 . "','" . $jong_ckk14 . "','14')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb8 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit8 . "','" . $unit8 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb8 . "','" . $product_idb8 . "','1','" . $product_code14 . "','" . $have_order . "','" . $clear_br14 . "','" . $clear_ivno14 . "','" . $jong_no14 . "','" . $jong_ckk14 . "','14')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb9 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit9 . "','" . $unit9 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb9 . "','" . $product_idb9 . "','1','" . $product_code14 . "','" . $have_order . "','" . $clear_br14 . "','" . $clear_ivno14 . "','" . $jong_no14 . "','" . $jong_ckk14 . "','14')";
				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb10 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit10 . "','" . $unit10 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb10 . "','" . $product_idb10 . "','1','" . $product_code14 . "','" . $have_order . "','" . $clear_br14 . "','" . $clear_ivno14 . "','" . $jong_no14 . "','" . $jong_ckk14 . "','14')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}
		} else {


			$strSQL14 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $sale_count14 . "','" . $sale_count14 . "','" . $product_price14 . "','" . $product_price14 . "','" . $sum_amount14 . "','" . $sale_remarkk14 . "','" . $discount_unit14 . "','" . $warranty14 . "','" . $cal14 . "','" . $pm14 . "','" . $product_id14 . "','" . $product_id14 . "','" . $have_order . "','" . $clear_br14 . "','" . $clear_ivno14 . "','" . $jong_no14 . "','" . $jong_ckk14 . "','14')";
			$objQuery14 = mysqli_query($conn, $strSQL14);
			if ($objQuery14) {
				applyHosSubsoInsertExtras($conn, mysqli_insert_id($conn), $_POST["product_sn14"] ?? ($_POST["sn14"] ?? ''), $_POST["pm_year14"] ?? '', $_POST["display_name14"] ?? '');
			}
		}
	}

	if ($product_id15 != '' && ($_POST["subso_db_id15"] ?? '') === '') {

		$strSQL31 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '" . $product_code15 . "' ";
		$objQuery31 = mysqli_query($conn, $strSQL31) or die("Error Query [" . $strSQL31 . "]");
		$Num_Rows31 = mysqli_num_rows($objQuery31);
		if ($Num_Rows31 > 0) {

			$objResult31 = mysqli_fetch_array($objQuery31);

			$product_idb1 = $objResult31["product_id1"] ?? '';
			$product_idb2 = $objResult31["product_id2"] ?? '';
			$product_idb3 = $objResult31["product_id3"] ?? '';
			$product_idb4 = $objResult31["product_id4"] ?? '';
			$product_idb5 = $objResult31["product_id5"] ?? '';
			$product_idb6 = $objResult31["product_id6"] ?? '';
			$product_idb7 = $objResult31["product_id7"] ?? '';
			$product_idb8 = $objResult31["product_id8"] ?? '';
			$product_idb9 = $objResult31["product_id9"] ?? '';
			$product_idb10 = $objResult31["product_id10"] ?? '';

			$unit1 = (float)($sale_count15 ?? 0) * (float)($objResult31["unit1"] ?? 0);
			$unit2 = (float)($sale_count15 ?? 0) * (float)($objResult31["unit2"] ?? 0);
			$unit3 = (float)($sale_count15 ?? 0) * (float)($objResult31["unit3"] ?? 0);
			$unit4 = (float)($sale_count15 ?? 0) * (float)($objResult31["unit4"] ?? 0);
			$unit5 = (float)($sale_count15 ?? 0) * (float)($objResult31["unit5"] ?? 0);
			$unit6 = (float)($sale_count15 ?? 0) * (float)($objResult31["unit6"] ?? 0);
			$unit7 = (float)($sale_count15 ?? 0) * (float)($objResult31["unit7"] ?? 0);
			$unit8 = (float)($sale_count15 ?? 0) * (float)($objResult31["unit8"] ?? 0);
			$unit9 = (float)($sale_count15 ?? 0) * (float)($objResult31["unit9"] ?? 0);
			$unit10 = (float)($sale_count15 ?? 0) * (float)($objResult31["unit10"] ?? 0);

			if ($product_idb1 != '') {

				$strSQL104 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,code_bom,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit1 . "','" . $unit1 . "','" . $product_price15 . "','" . $product_price15 . "','" . $sum_amount15 . "','" . $sale_remarkk15 . "','" . $discount_unit15 . "','" . $warranty15 . "','" . $cal15 . "','" . $pm15 . "','" . $product_idb1 . "','" . $product_idb1 . "','" . $product_code15 . "','1','" . $product_code15 . "','" . $have_order . "','" . $clear_br15 . "','" . $clear_ivno15 . "','" . $jong_no15 . "','" . $jong_ckk15 . "','15')";

				$objQuery104 = mysqli_query($conn, $strSQL104);
			}

			if ($product_idb2 != '') {

				$strSQL100 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit2 . "','" . $unit2 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb2 . "','" . $product_idb2 . "','1','" . $product_code15 . "','" . $have_order . "','" . $clear_br15 . "','" . $clear_ivno15 . "','" . $jong_no15 . "','" . $jong_ckk15 . "','15')";
				$objQuery100 = mysqli_query($conn, $strSQL100);
			}

			if ($product_idb3 != '') {

				$strSQL101 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit3 . "','" . $unit3 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb3 . "','" . $product_idb3 . "','1','" . $product_code15 . "','" . $have_order . "','" . $clear_br15 . "','" . $clear_ivno15 . "','" . $jong_no15 . "','" . $jong_ckk15 . "','15')";

				$objQuery101 = mysqli_query($conn, $strSQL101);
			}

			if ($product_idb4 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit4 . "','" . $unit4 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb4 . "','" . $product_idb4 . "','1','" . $product_code15 . "','" . $have_order . "','" . $clear_br15 . "','" . $clear_ivno15 . "','" . $jong_no15 . "','" . $jong_ckk15 . "','15')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb5 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit5 . "','" . $unit5 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb5 . "','" . $product_idb5 . "','1','" . $product_code15 . "','" . $have_order . "','" . $clear_br15 . "','" . $clear_ivno15 . "','" . $jong_no15 . "','" . $jong_ckk15 . "','15')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb6 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit6 . "','" . $unit6 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb6 . "','" . $product_idb6 . "','1','" . $product_code15 . "','" . $have_order . "','" . $clear_br15 . "','" . $clear_ivno15 . "','" . $jong_no15 . "','" . $jong_ckk15 . "','15')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb7 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit7 . "','" . $unit7 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb7 . "','" . $product_idb7 . "','1','" . $product_code15 . "','" . $have_order . "','" . $clear_br15 . "','" . $clear_ivno15 . "','" . $jong_no15 . "','" . $jong_ckk15 . "','15')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb8 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit8 . "','" . $unit8 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb8 . "','" . $product_idb8 . "','1','" . $product_code15 . "','" . $have_order . "','" . $clear_br15 . "','" . $clear_ivno15 . "','" . $jong_no15 . "','" . $jong_ckk15 . "','15')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb9 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit9 . "','" . $unit9 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb9 . "','" . $product_idb9 . "','1','" . $product_code15 . "','" . $have_order . "','" . $clear_br15 . "','" . $clear_ivno15 . "','" . $jong_no15 . "','" . $jong_ckk15 . "','15')";
				$objQuery102 = mysqli_query($conn, $strSQL102);
			}

			if ($product_idb10 != '') {

				$strSQL102 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,bom_ckk,code_bomsame,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $unit10 . "','" . $unit10 . "','0.00','0.00','0.00','','0.00','0','0','0','" . $product_idb10 . "','" . $product_idb10 . "','1','" . $product_code15 . "','" . $have_order . "','" . $clear_br15 . "','" . $clear_ivno15 . "','" . $jong_no15 . "','" . $jong_ckk15 . "','15')";

				$objQuery102 = mysqli_query($conn, $strSQL102);
			}
		} else {



			$strSQL15 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $sale_count15 . "','" . $sale_count15 . "','" . $product_price15 . "','" . $product_price15 . "','" . $sum_amount15 . "','" . $sale_remarkk15 . "','" . $discount_unit15 . "','" . $warranty15 . "','" . $cal15 . "','" . $pm15 . "','" . $product_id15 . "','" . $product_id15 . "','" . $have_order . "','" . $clear_br15 . "','" . $clear_ivno15 . "','" . $jong_no15 . "','" . $jong_ckk15 . "','15')";

			$objQuery15 = mysqli_query($conn, $strSQL15);
			if ($objQuery15) {
				applyHosSubsoInsertExtras($conn, mysqli_insert_id($conn), $_POST["product_sn15"] ?? ($_POST["sn15"] ?? ''), $_POST["pm_year15"] ?? '', $_POST["display_name15"] ?? '');
			}
		}
	}




	if ($product_id16 !== '' && ($_POST["subso_db_id16"] ?? '') === '') {

		$strSQL16 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $sale_count16 . "','" . $sale_count16 . "','" . $product_price16 . "','" . $product_price16 . "','" . $sum_amount16 . "','" . $sale_remarkk16 . "','" . $discount_unit16 . "','" . $warranty16 . "','" . $cal16 . "','" . $pm16 . "','" . $product_id16 . "','" . $product_id16 . "','" . $have_order . "','" . $clear_br16 . "','" . $clear_ivno16 . "','" . $jong_no16 . "','" . $jong_ckk16 . "','16')";
		//echo $strSQL1;
		//exit();

		$objQuery16 = mysqli_query($conn, $strSQL16);
		if ($objQuery16) {
			applyHosSubsoInsertExtras($conn, mysqli_insert_id($conn), $_POST["product_sn16"] ?? ($_POST["sn16"] ?? ''), $_POST["pm_year16"] ?? '', $_POST["display_name16"] ?? '');
		}
	}


	if ($product_id17 !== '' && ($_POST["subso_db_id17"] ?? '') === '') {

		$strSQL17 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $sale_count17 . "','" . $sale_count17 . "','" . $product_price17 . "','" . $product_price17 . "','" . $sum_amount17 . "','" . $sale_remarkk17 . "','" . $discount_unit17 . "','" . $warranty17 . "','" . $cal17 . "','" . $pm17 . "','" . $product_id17 . "','" . $product_id17 . "','" . $have_order . "','" . $clear_br17 . "','" . $clear_ivno17 . "','" . $jong_no17 . "','" . $jong_ckk17 . "','17')";
		//echo $strSQL2;
		//exit();

		$objQuery17 = mysqli_query($conn, $strSQL17);
		if ($objQuery17) {
			applyHosSubsoInsertExtras($conn, mysqli_insert_id($conn), $_POST["product_sn17"] ?? ($_POST["sn17"] ?? ''), $_POST["pm_year17"] ?? '', $_POST["display_name17"] ?? '');
		}
	}


	if ($product_id18 !== '' && ($_POST["subso_db_id18"] ?? '') === '') {

		$strSQL18 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $sale_count18 . "','" . $sale_count18 . "','" . $product_price18 . "','" . $product_price18 . "','" . $sum_amount18 . "','" . $sale_remarkk18 . "','" . $discount_unit18 . "','" . $warranty18 . "','" . $cal18 . "','" . $pm18 . "','" . $product_id18 . "','" . $product_id18 . "','" . $have_order . "','" . $clear_br18 . "','" . $clear_ivno18 . "','" . $jong_no18 . "','" . $jong_ckk18 . "','18')";
		//echo $strSQL3;
		//exit();

		$objQuery18 = mysqli_query($conn, $strSQL18);
		if ($objQuery18) {
			applyHosSubsoInsertExtras($conn, mysqli_insert_id($conn), $_POST["product_sn18"] ?? ($_POST["sn18"] ?? ''), $_POST["pm_year18"] ?? '', $_POST["display_name18"] ?? '');
		}
	}


	if ($product_id19 !== '' && ($_POST["subso_db_id19"] ?? '') === '') {

		$strSQL19 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $sale_count19 . "','" . $sale_count19 . "','" . $product_price19 . "','" . $product_price19 . "','" . $sum_amount19 . "','" . $sale_remarkk19 . "','" . $discount_unit19 . "','" . $warranty19 . "','" . $cal19 . "','" . $pm19 . "','" . $product_id19 . "','" . $product_id19 . "','" . $have_order . "','" . $clear_br19 . "','" . $clear_ivno19 . "','" . $jong_no19 . "','" . $jong_ckk19 . "','19')";
		//echo $strSQL1;
		//exit();

		$objQuery19 = mysqli_query($conn, $strSQL19);
		if ($objQuery19) {
			applyHosSubsoInsertExtras($conn, mysqli_insert_id($conn), $_POST["product_sn19"] ?? ($_POST["sn19"] ?? ''), $_POST["pm_year19"] ?? '', $_POST["display_name19"] ?? '');
		}
	}


	if ($product_id20 !== '' && ($_POST["subso_db_id20"] ?? '') === '') {

		$strSQL20 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $sale_count20 . "','" . $sale_count20 . "','" . $product_price20 . "','" . $product_price20 . "','" . $sum_amount20 . "','" . $sale_remarkk20 . "','" . $discount_unit20 . "','" . $warranty20 . "','" . $cal20 . "','" . $pm20 . "','" . $product_id20 . "','" . $product_id20 . "','" . $have_order . "','" . $clear_br20 . "','" . $clear_ivno20 . "','" . $jong_no20 . "','" . $jong_ckk20 . "','20')";
		//echo $strSQL1;
		//exit();

		$objQuery20 = mysqli_query($conn, $strSQL20);
		if ($objQuery20) {
			applyHosSubsoInsertExtras($conn, mysqli_insert_id($conn), $_POST["product_sn20"] ?? ($_POST["sn20"] ?? ''), $_POST["pm_year20"] ?? '', $_POST["display_name20"] ?? '');
		}
	}


	if ($product_id21 !== '' && ($_POST["subso_db_id21"] ?? '') === '') {

		$strSQL21 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $sale_count21 . "','" . $sale_count21 . "','" . $product_price21 . "','" . $product_price21 . "','" . $sum_amount21 . "','" . $sale_remarkk21 . "','" . $discount_unit21 . "','" . $warranty21 . "','" . $cal21 . "','" . $pm21 . "','" . $product_id21 . "','" . $product_id21 . "','" . $have_order . "','" . $clear_br21 . "','" . $clear_ivno21 . "','" . $jong_no21 . "','" . $jong_ckk21 . "','21')";
		//echo $strSQL1;
		//exit();

		$objQuery21 = mysqli_query($conn, $strSQL21);
		if ($objQuery21) {
			applyHosSubsoInsertExtras($conn, mysqli_insert_id($conn), $_POST["product_sn21"] ?? ($_POST["sn21"] ?? ''), $_POST["pm_year21"] ?? '', $_POST["display_name21"] ?? '');
		}
	}


	if ($product_id22 !== '' && ($_POST["subso_db_id22"] ?? '') === '') {

		$strSQL22 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $sale_count22 . "','" . $sale_count22 . "','" . $product_price22 . "','" . $product_price22 . "','" . $sum_amount22 . "','" . $sale_remarkk22 . "','" . $discount_unit22 . "','" . $warranty22 . "','" . $cal22 . "','" . $pm22 . "','" . $product_id22 . "','" . $product_id22 . "','" . $have_order . "','" . $clear_br22 . "','" . $clear_ivno22 . "','" . $jong_no22 . "','" . $jong_ckk22 . "','22')";
		//echo $strSQL1;
		//exit();

		$objQuery22 = mysqli_query($conn, $strSQL22);
		if ($objQuery22) {
			applyHosSubsoInsertExtras($conn, mysqli_insert_id($conn), $_POST["product_sn22"] ?? ($_POST["sn22"] ?? ''), $_POST["pm_year22"] ?? '', $_POST["display_name22"] ?? '');
		}
	}


	if ($product_id23 !== '' && ($_POST["subso_db_id23"] ?? '') === '') {

		$strSQL23 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $sale_count23 . "','" . $sale_count23 . "','" . $product_price23 . "','" . $product_price23 . "','" . $sum_amount23 . "','" . $sale_remarkk23 . "','" . $discount_unit23 . "','" . $warranty23 . "','" . $cal23 . "','" . $pm23 . "','" . $product_id23 . "','" . $product_id23 . "','" . $have_order . "','" . $clear_br23 . "','" . $clear_ivno23 . "','" . $jong_no23 . "','" . $jong_ckk23 . "','23')";
		//echo $strSQL1;
		//exit();

		$objQuery23 = mysqli_query($conn, $strSQL23);
		if ($objQuery23) {
			applyHosSubsoInsertExtras($conn, mysqli_insert_id($conn), $_POST["product_sn23"] ?? ($_POST["sn23"] ?? ''), $_POST["pm_year23"] ?? '', $_POST["display_name23"] ?? '');
		}
	}


	if ($product_id24 !== '' && ($_POST["subso_db_id24"] ?? '') === '') {

		$strSQL24 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $sale_count24 . "','" . $sale_count24 . "','" . $product_price24 . "','" . $product_price24 . "','" . $sum_amount24 . "','" . $sale_remarkk24 . "','" . $discount_unit24 . "','" . $warranty24 . "','" . $cal24 . "','" . $pm24 . "','" . $product_id24 . "','" . $product_id24 . "','" . $have_order . "','" . $clear_br24 . "','" . $clear_ivno24 . "','" . $jong_no24 . "','" . $jong_ckk24 . "','24')";
		//echo $strSQL1;
		//exit();

		$objQuery24 = mysqli_query($conn, $strSQL24);
		if ($objQuery24) {
			applyHosSubsoInsertExtras($conn, mysqli_insert_id($conn), $_POST["product_sn24"] ?? ($_POST["sn24"] ?? ''), $_POST["pm_year24"] ?? '', $_POST["display_name24"] ?? '');
		}
	}


	if ($product_id25 !== '' && ($_POST["subso_db_id25"] ?? '') === '') {

		$strSQL25 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $sale_count25 . "','" . $sale_count25 . "','" . $product_price25 . "','" . $product_price25 . "','" . $sum_amount25 . "','" . $sale_remarkk25 . "','" . $discount_unit25 . "','" . $warranty25 . "','" . $cal25 . "','" . $pm25 . "','" . $product_id25 . "','" . $product_id25 . "','" . $have_order . "','" . $clear_br25 . "','" . $clear_ivno25 . "','" . $jong_no25 . "','" . $jong_ckk25 . "','25')";
		//echo $strSQL1;
		//exit();

		$objQuery25 = mysqli_query($conn, $strSQL25);
		if ($objQuery25) {
			applyHosSubsoInsertExtras($conn, mysqli_insert_id($conn), $_POST["product_sn25"] ?? ($_POST["sn25"] ?? ''), $_POST["pm_year25"] ?? '', $_POST["display_name25"] ?? '');
		}
	}


	////////////

	if ($product_id26 !== '' && ($_POST["subso_db_id26"] ?? '') === '') {

		$strSQL26 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $sale_count26 . "','" . $sale_count26 . "','" . $product_price26 . "','" . $product_price26 . "','" . $sum_amount26 . "','" . $sale_remarkk26 . "','" . $discount_unit26 . "','" . $warranty26 . "','" . $cal26 . "','" . $pm26 . "','" . $product_id26 . "','" . $product_id26 . "','" . $have_order . "','" . $clear_br26 . "','" . $clear_ivno26 . "','" . $jong_no26 . "','" . $jong_ckk26 . "','26')";
		//echo $strSQL1;
		//exit();

		$objQuery26 = mysqli_query($conn, $strSQL26);
		if ($objQuery26) {
			applyHosSubsoInsertExtras($conn, mysqli_insert_id($conn), $_POST["product_sn26"] ?? ($_POST["sn26"] ?? ''), $_POST["pm_year26"] ?? '', $_POST["display_name26"] ?? '');
		}
	}

	if ($product_id27 !== '' && ($_POST["subso_db_id27"] ?? '') === '') {

		$strSQL27 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $sale_count27 . "','" . $sale_count27 . "','" . $product_price27 . "','" . $product_price27 . "','" . $sum_amount27 . "','" . $sale_remarkk27 . "','" . $discount_unit27 . "','" . $warranty27 . "','" . $cal27 . "','" . $pm27 . "','" . $product_id27 . "','" . $product_id27 . "','" . $have_order . "','" . $clear_br27 . "','" . $clear_ivno27 . "','" . $jong_no27 . "','" . $jong_ckk27 . "','27')";
		//echo $strSQL1;
		//exit();

		$objQuery27 = mysqli_query($conn, $strSQL27);
		if ($objQuery27) {
			applyHosSubsoInsertExtras($conn, mysqli_insert_id($conn), $_POST["product_sn27"] ?? ($_POST["sn27"] ?? ''), $_POST["pm_year27"] ?? '', $_POST["display_name27"] ?? '');
		}
	}

	if ($product_id28 !== '' && ($_POST["subso_db_id28"] ?? '') === '') {

		$strSQL28 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $sale_count28 . "','" . $sale_count28 . "','" . $product_price28 . "','" . $product_price28 . "','" . $sum_amount28 . "','" . $sale_remarkk28 . "','" . $discount_unit28 . "','" . $warranty28 . "','" . $cal28 . "','" . $pm28 . "','" . $product_id28 . "','" . $product_id28 . "','" . $have_order . "','" . $clear_br28 . "','" . $clear_ivno28 . "','" . $jong_no28 . "','" . $jong_ckk28 . "','28')";
		//echo $strSQL1;
		//exit();

		$objQuery28 = mysqli_query($conn, $strSQL28);
		if ($objQuery28) {
			applyHosSubsoInsertExtras($conn, mysqli_insert_id($conn), $_POST["product_sn28"] ?? ($_POST["sn28"] ?? ''), $_POST["pm_year28"] ?? '', $_POST["display_name28"] ?? '');
		}
	}

	if ($product_id29 !== '' && ($_POST["subso_db_id29"] ?? '') === '') {

		$strSQL29 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $sale_count29 . "','" . $sale_count29 . "','" . $product_price29 . "','" . $product_price29 . "','" . $sum_amount29 . "','" . $sale_remarkk29 . "','" . $discount_unit29 . "','" . $warranty29 . "','" . $cal29 . "','" . $pm29 . "','" . $product_id29 . "','" . $product_id29 . "','" . $have_order . "','" . $clear_br29 . "','" . $clear_ivno29 . "','" . $jong_no29 . "','" . $jong_ckk29 . "','29')";
		//echo $strSQL1;
		//exit();

		$objQuery29 = mysqli_query($conn, $strSQL29);
		if ($objQuery29) {
			applyHosSubsoInsertExtras($conn, mysqli_insert_id($conn), $_POST["product_sn29"] ?? ($_POST["sn29"] ?? ''), $_POST["pm_year29"] ?? '', $_POST["display_name29"] ?? '');
		}
	}

	if ($product_id30 !== '' && ($_POST["subso_db_id30"] ?? '') === '') {

		$strSQL30 = "insert into hos__subso
(ref_idd,count,countref,price,price_ref,amount,sale_remark,discount,warranty,cal,pm,product_id,product_code,ckk_order,clear_br,clear_ivno,jong_no,jong_ckk,sort_order)
values ('" . $ref_id . "','" . $sale_count30 . "','" . $sale_count30 . "','" . $product_price30 . "','" . $product_price30 . "','" . $sum_amount30 . "','" . $sale_remarkk30 . "','" . $discount_unit30 . "','" . $warranty30 . "','" . $cal30 . "','" . $pm30 . "','" . $product_id30 . "','" . $product_id30 . "','" . $have_order . "','" . $clear_br30 . "','" . $clear_ivno30 . "','" . $jong_no30 . "','" . $jong_ckk30 . "','30')";
		//echo $strSQL1;
		//exit();

		$objQuery30 = mysqli_query($conn, $strSQL30);
		if ($objQuery30) {
			applyHosSubsoInsertExtras($conn, mysqli_insert_id($conn), $_POST["product_sn30"] ?? ($_POST["sn30"] ?? ''), $_POST["pm_year30"] ?? '', $_POST["display_name30"] ?? '');
		}
	}



	$start_date = $_POST["start_date"] ?? '0000-00-00';

	$between_date = $_POST["between_date"] ?? '';
	$start_time = $_POST["start_time"] ?? '';
	$end_time = $_POST["end_time"] ?? '';
	$status = $_POST["status"] ?? '';

	if (($_POST["start_date"] ?? '') != '') {
		$start_date = $_POST["start_date"];
	} else {
		$start_date = '0000-00-00';
	}

	if (($_POST['fix_datetime'] ?? '') != '') {
		$fix_date = $_POST['fix_datetime'];
	} else {
		$fix_date = '0';
	}

	if (($_POST['no_money'] ?? '') != '') {
		$no_price = $_POST['no_money'];
	} else {
		$no_price = '0';
	}
	if (($_POST['call_customer'] ?? '') != '') {
		$call_customer = $_POST['call_customer'];
	} else {
		$call_customer = '0';
	}
	if (($_POST['credit_card'] ?? '') != '') {
		$credit = $_POST['credit_card'];
	} else {
		$credit = '0';
	}
	if (($_POST['call_back'] ?? '') != '') {
		$call_employee = $_POST['call_back'];
	} else {
		$call_employee = '0';
	}

	if (($_POST['cash'] ?? '') != '') {
		$chash = $_POST['cash'];
	} else {
		$chash = '0';
	}
	if (($_POST['check_paper'] ?? '') != '') {
		$check_peper = $_POST['check_paper'];
	} else {
		$check_peper = '0';
	}
	if (($_POST['bill'] ?? '') != '') {
		$bill = $_POST['bill'];
	} else {
		$bill = '0';
	}
	if (($_POST['want_bus'] ?? '') != '') {
		$want_bus = $_POST['want_bus'];
	} else {
		$want_bus = '0';
	}
	if (($_POST['tran'] ?? '') != '') {
		$tran = $_POST["tran"];
	} else {
		$tran = '0';
	}
	if (($_POST['more'] ?? '') != '') {
		$check_detail = $_POST["more"];
	} else {
		$check_detail = '0';
	}

	if (($_POST['dep'] ?? '') != '') {
		$dep = $_POST["dep"];
	} else {
		$dep = '0';
	}


	$department = $_POST["department_name"] ?? '';
	$type_customer = $_POST["customer_typename"] ?? '';
	$type_company = $_POST["company_name"] ?? '';
	$customer_name = $_POST["customer_name"] ?? '';
	$customer_tel = $_POST["customer_tel"] ?? '';
	$address_name = $_POST["address_name"] ?? '';
	$address_send = $_POST["address_send"] ?? '';
	$customer_contact = $_POST["customer_contact"] ?? '';
	$address_1 = $_POST["address_1"] ?? '';
	$on_time = $_POST["on_time"] ?? '';
	$amphur_name = $_POST["amphur_name"] ?? '';
	$province_name = $_POST["province_name"] ?? '';
	$product = $_POST["product"] ?? '';
	$product_name = "$product $product_name6 $sale_count6 $unit_name6 $product_name7 $sale_count7 $unit_name7 $product_name8 $sale_count8 $unit_name8 $product_name9 $sale_count9 $unit_name9 $product_name10 $sale_count10 $unit_name10";
	$product_sn = $_POST["product_sn"] ?? '';
	$unit_credit = $_POST["unit_credit"] ?? '';
	$price = $_POST["unit_cash"] ?? '';
	$employee_name = $_POST["employee_name"] ?? '';
	$employee_tel = $_POST["employee_tel"] ?? '';
	$add_by = $_POST["add_by"] ?? '';
	$description = $_POST["status_comment"] ?? '';
	$havemap = $_POST['have_map'] ?? '';
	$unit_check = $_POST["unit_check"] ?? '';
	$unit_bill = $_POST["unit_bill"] ?? '';
	$unit_tran = $_POST["unit_tran"] ?? '';
	$department_show = $_POST["department_show"] ?? '';
	$unit_check1 = str_replace(',', '', (string)$unit_check);
	$unit_bill1 = str_replace(',', '', (string)$unit_bill);
	$dept = $_POST["dept"] ?? '';
	$status_comment = $_POST["status_comment"] ?? '';
	$mk_research = $_POST["mk_research"] ?? '';


	if (($_POST['runway'] ?? '') != '') {
		$runway = $_POST["runway"];
	} else {
		$runway = '0';
	}

	if (($_POST['road'] ?? '') != '') {
		$road = $_POST["road"];
	} else {
		$road = '0';
	}

	if (($_POST['soy'] ?? '') != '') {
		$soy = $_POST["soy"];
	} else {
		$soy = '0';
	}

	if (($_POST['car_load'] ?? '') != '') {
		$car_load = $_POST["car_load"];
	} else {
		$car_load = '0';
	}

	if (($_POST['no_car_road'] ?? '') != '') {
		$no_car_road = $_POST["no_car_road"];
	} else {
		$no_car_road = '0';
	}

	if (($_POST['car_road'] ?? '') != '') {
		$car_road = $_POST["car_road"];
	} else {
		$car_road = '0';
	}
	if (($_POST['car_home'] ?? '') != '') {
		$car_home = $_POST["car_home"];
	} else {
		$car_home = '0';
	}

	if (($_POST['slope'] ?? '') != '') {
		$slope = $_POST["slope"];
	} else {
		$slope = '0';
	}


	if (($_POST['bundai'] ?? '') != '') {
		$bundai = $_POST["bundai"];
	} else {
		$bundai = '0';
	}

	if (($_POST['bundai_install'] ?? '') != '') {
		$bundai_install = $_POST["bundai_install"];
	} else {
		$bundai_install = '0';
	}

	if (($_POST['lip'] ?? '') != '') {
		$lip = $_POST["lip"];
	} else {
		$lip = '0';
	}


	if (($_POST['want_employee'] ?? '') != '') {
		$want_employee = $_POST["want_employee"];
	} else {
		$want_employee = '0';
	}

	if (($_POST['want_ex'] ?? '') != '') {
		$want_ex = $_POST["want_ex"];
	} else {
		$want_ex = '0';
	}


	if (($_POST['want_credit'] ?? '') != '') {
		$want_credit = $_POST["want_credit"];
	} else {
		$want_credit = '0';
	}
	if (($_POST['want_prem'] ?? '') != '') {
		$want_prem = $_POST["want_prem"];
	} else {
		$want_prem = '0';
	}

	if (($_POST['head_bad'] ?? '') != '') {
		$head_bad = $_POST["head_bad"];
	} else {
		$head_bad = '0';
	}


	if (($_POST['height_ltd'] ?? '') != '') {
		$height_ltd = $_POST["height_ltd"];
	} else {
		$height_ltd = '0';
	}
	if (($_POST['up'] ?? '') != '') {
		$up = $_POST["up"];
	} else {
		$up = '0';
	}
	if (($_POST['no_up'] ?? '') != '') {
		$no_up = $_POST["no_up"];
	} else {
		$no_up = '0';
	}

	if (($_POST['more'] ?? '') != '') {
		$check_detail = $_POST["more"];
	} else {
		$check_detail = '0';
	}



	$type_bundai = $_POST["type_bundai"] ?? '';



	$soy_long = $_POST["soy_long"] ?? '';
	$soy_big = $_POST["soy_big"] ?? '';
	$car_park = $_POST["car_park"] ?? '';
	$door_long = $_POST["door_long"] ?? '';
	$unit_bundai = $_POST["unit_bundai"] ?? '';
	$door_big = $_POST["door_bigger"] ?? '';
	$door_longer = $_POST["door_longer"] ?? '';
	$type_door = $_POST["type_door"] ?? '';
	$home_type = $_POST["home_type"] ?? '';
	$install_room = $_POST["install_room"] ?? $home_type;
	$install = $_POST["install"] ?? '';
	$bundai_big = $_POST["bundai_big"] ?? '';
	$lip_big = $_POST["lip_big"] ?? '';
	$lip_long = $_POST["lip_long"] ?? '';
	$lip_weight = $_POST["lip_weight"] ?? '';
	$employee_unit = $_POST["employee_unit"] ?? '';
	$ferniger_name = $_POST["ferniger_name"] ?? '';
	$ferniger_address = $_POST["ferniger_address"] ?? '';
	$number = $_POST["number"] ?? '';
	$status_comment = $_POST["status_comment"] ?? '';

	$dept = $_POST["dept"] ?? '';
	$room_bigger = $_POST["room_bigger"] ?? '';
	$room_longer = $_POST["room_longer"] ?? '';
	$bundai_hug = $_POST["bundai_hug"] ?? '';
	$bank = $_POST["bank"] ?? '';

	$department_show = $_POST["department_show"] ?? '';
	$description_ja = $_POST["description_ja"] ?? '';





	$strSQL66 =  "Update tb_register_data set start_date = '" . $start_date . "',between_date ='" . $between_date . "',start_time ='" . $start_time . "',end_time ='" . $end_time . "',status ='" . $status . "',fix_date ='" . $fix_date . "',no_price ='" . $no_price . "',call_customer ='" . $call_customer . "',credit ='" . $credit . "',call_employee ='" . $call_employee . "',cash ='" . $chash . "',check_peper ='" . $check_peper . "',bill = '" . $bill . "',department ='" . $department . "',type_customer ='" . $type_customer . "',type_company = '" . $type_company . "',customer_name ='" . $customer_name . "',customer_tel ='" . $customer_tel . "',address_name ='" . $address_name . "',address_send ='" . $address_send . "',want_bus ='" . $want_bus . "',product_name ='" . $product_name . "',product_sn ='" . $product_sn . "',unit_credit ='" . $unit_credit . "',price ='" . $price . "',employee_name ='" . $employee_name . "',employee_tel ='" . $employee_tel . "',add_by ='" . $add_by . "',description ='" . $description . "',have_map = '" . $havemap . "',add_date ='$add_date',unit_bill ='" . $unit_bill . "',unit_check ='" . $unit_check . "',unit_tran ='" . $unit_tran . "',tran ='" . $tran . "',check_detail ='" . $check_detail . "',dep ='" . $dep . "',dept ='" . $dept . "',department_show ='" . $department_show . "',customer_contact = '" . $customer_contact . "' ,on_time='" . $on_time . "',address_1 ='" . $address_1 . "',mk_research='" . $mk_research . "',province_name='" . $province_name . "',count_box='" . $admin_box_count_value . "'  where ref_id = '" . $ref_id . "'";

	$objQuery66 = mysqli_query($conn, $strSQL66) or die(mysqli_error());

	$shippingColumnCheck = mysqli_query($conn, "SHOW COLUMNS FROM tb_register_data LIKE 'shipping_id'");
	if ($shippingColumnCheck && mysqli_num_rows($shippingColumnCheck) > 0) {
		$shipping_id_val = isset($_POST["shipping_id"]) && $_POST["shipping_id"] !== '' ? (int)$_POST["shipping_id"] : 0;
		mysqli_query($conn, "UPDATE tb_register_data SET shipping_id = '" . $shipping_id_val . "' WHERE ref_id = '" . mysqli_real_escape_string($conn, $ref_id) . "'");
	}


	$strSQL33 =  "Update tb_transaction set runway='" . $runway . "',road='" . $road . "',soy='" . $soy . "',soy_long='" . $soy_long . "',soy_big='" . $soy_big . "',car_load='" . $car_load . "',car_park='" . $car_park . "',car_road='" . $car_road . "',no_car_road='" . $no_car_road . "',car_home='" . $car_home . "',door_long='" . $door_long . "',slope='" . $slope . "',bundai='" . $bundai . "',unit_bundai='" . $unit_bundai . "',door_big='" . $door_big . "',door_longer='" . $door_longer . "',type_door='" . $type_door . "',home_type='" . $home_type . "',install='" . $install . "',bundai_install='" . $bundai_install . "',bundai_big='" . $bundai_big . "',lip='" . $lip . "',lip_big='" . $lip_big . "',lip_long='" . $lip_long . "',lip_weight='" . $lip_weight . "',want_employee='" . $want_employee . "',employee_unit='" . $employee_unit . "',ferniger_name='" . $ferniger_name . "',ferniger_address='" . $ferniger_address . "',want_ex='" . $want_ex . "',want_credit='" . $want_credit . "',want_prem='" . $want_prem . "',add_date='$add_date',add_by='" . $add_by . "',room_bigger='" . $room_bigger . "',room_longer='" . $room_longer . "',bundai_hug='" . $bundai_hug . "',bank='" . $bank . "',description='" . $description_ja . "',type_bundai='" . $type_bundai . "',head_bad='" . $head_bad . "',height_ltd='" . $height_ltd . "',up='" . $up . "',no_up='" . $no_up . "'   where ref_id = '" . $ref_id . "' ";

	$objQuery33 = mysqli_query($conn, $strSQL33) or die(mysqli_error());

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
	$province_name1 = isset($_POST["province_name1"]) ? $_POST["province_name1"] : '';
	$address_name1 = $_POST["address_name1"];

	$customer_name2 = $_POST["customer_name2"];
	$customer_tel2 = $_POST["customer_tel2"];
	$province_name2 = isset($_POST["province_name2"]) ? $_POST["province_name2"] : '';
	$address_name2 = $_POST["address_name2"];

	$customer_name3 = $_POST["customer_name3"];
	$customer_tel3 = $_POST["customer_tel3"];
	$province_name3 = isset($_POST["province_name3"]) ? $_POST["province_name3"] : '';
	$address_name3 = $_POST["address_name3"];

	$customer_name4 = $_POST["customer_name4"];
	$customer_tel4 = $_POST["customer_tel4"];
	$province_name4 = isset($_POST["province_name4"]) ? $_POST["province_name4"] : '';
	$address_name4 = $_POST["address_name4"];

	$customer_name5 = $_POST["customer_name5"];
	$customer_tel5 = $_POST["customer_tel5"];
	$province_name5 = isset($_POST["province_name5"]) ? $_POST["province_name5"] : '';
	$address_name5 = $_POST["address_name5"];

	$customer_name6 = $_POST["customer_name6"];
	$customer_tel6 = $_POST["customer_tel6"];
	$province_name6 = isset($_POST["province_name6"]) ? $_POST["province_name6"] : '';
	$address_name6 = $_POST["address_name6"];

	$customer_name7 = $_POST["customer_name7"];
	$customer_tel7 = $_POST["customer_tel7"];
	$province_name7 = isset($_POST["province_name7"]) ? $_POST["province_name7"] : '';
	$address_name7 = $_POST["address_name7"];

	$customer_name8 = $_POST["customer_name8"];
	$customer_tel8 = $_POST["customer_tel8"];
	$province_name8 = isset($_POST["province_name8"]) ? $_POST["province_name8"] : '';
	$address_name8 = $_POST["address_name8"];

	$customer_name9 = $_POST["customer_name9"];
	$customer_tel9 = $_POST["customer_tel9"];
	$province_name9 = isset($_POST["province_name9"]) ? $_POST["province_name9"] : '';
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

	$strSQL22 = "SELECT * FROM tb_delivery_print WHERE ref_id = '" . $ref_id . "' ";
	$objQuery22 = mysqli_query($conn, $strSQL22) or die("Error Query [" . $strSQL22 . "]");
	$Num_Rows22 = mysqli_num_rows($objQuery22);

	if ($Num_Rows22 > 0) {

		$deliveryPrintSetParts = array();
		foreach ($deliveryPrintRows as $deliveryIndex => $deliveryPrintRow) {
			$deliveryPrintSetParts[] = "customer_name" . $deliveryIndex . "='" . mysqli_real_escape_string($conn, $deliveryPrintRow['name']) . "'";
			$deliveryPrintSetParts[] = "customer_tel" . $deliveryIndex . "='" . mysqli_real_escape_string($conn, $deliveryPrintRow['tel']) . "'";
			if (tbDeliveryPrintColumnExists($conn, 'province_name' . $deliveryIndex)) {
				$deliveryPrintSetParts[] = "province_name" . $deliveryIndex . "='" . mysqli_real_escape_string($conn, $deliveryPrintRow['province']) . "'";
			}
			$deliveryPrintSetParts[] = "address_name" . $deliveryIndex . "='" . mysqli_real_escape_string($conn, $deliveryPrintRow['address']) . "'";
		}

		$strSQL15 =  "UPDATE tb_delivery_print SET " . implode(',', $deliveryPrintSetParts) . " where ref_id ='" . $ref_id . "'";

		$objQuery15 = mysqli_query($conn, $strSQL15) or die(mysqli_error());
	} else {

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

			$objQuery15 = mysqli_query($conn, $strSQL15) or die(mysqli_error());
		}
	}


	mysqli_query($conn, "DELETE FROM tb_shipping_address WHERE ref_id = '" . mysqli_real_escape_string($conn, $ref_id) . "'");

	for ($shippingIndex = 1; $shippingIndex <= 9; $shippingIndex++) {
		$shippingContactName = trim((string)$_POST['customer_name' . $shippingIndex]);
		$shippingTelephone = trim((string)$_POST['customer_tel' . $shippingIndex]);
		$shippingProvince = trim((string)(isset($_POST['province_name' . $shippingIndex]) ? $_POST['province_name' . $shippingIndex] : ''));
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

	$deliveryBillContactName = trim((string)(isset($_POST['bill_extra_contact_name_2']) ? $_POST['bill_extra_contact_name_2'] : ''));
	$deliveryBillTelephone = trim((string)(isset($_POST['bill_extra_contact_tel_2']) ? $_POST['bill_extra_contact_tel_2'] : ''));
	$deliveryBillProvince = trim((string)(isset($_POST['bill_extra_contact_province_2']) ? $_POST['bill_extra_contact_province_2'] : ''));
	$deliveryBillAddress = trim((string)(isset($_POST['bill_extra_shipping_address_2']) ? $_POST['bill_extra_shipping_address_2'] : ''));

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

	// ปุ่มอนุมัติ/ส่งกลับ/ไม่อนุมัติ ของ Sup (register_suphos.php) — ทำงานหลังบันทึกข้อมูลฟอร์มปกติเสร็จแล้ว
	$soApproveAction = $_POST['approve_action'] ?? '';
	if ($soApproveAction !== '' && $qsave) {
		$approve_name = trim(($_SESSION['name'] ?? '') . ' ' . ($_SESSION['surname'] ?? ''));
		$approve_code = $_SESSION['code'] ?? '';
		$approve_date_val = date('Y-m-d');
		$approve_time_val = date('H:i:s');

		if ($soApproveAction === 'return') {
			mysqli_query($conn, "UPDATE hos__so SET status_doc='Returned', send_sup='0' WHERE ref_id='" . mysqli_real_escape_string($conn, $ref_id) . "'");
		} elseif ($soApproveAction === 'reject') {
			mysqli_query($conn, "UPDATE hos__so SET status_doc='Rejected', approve='" . mysqli_real_escape_string($conn, $approve_name) . "', approve_code='" . mysqli_real_escape_string($conn, $approve_code) . "', approve_date='" . $approve_date_val . "' WHERE ref_id='" . mysqli_real_escape_string($conn, $ref_id) . "'");
		} elseif ($soApproveAction === 'approve') {
			// เช็คเคลียร์ยืม/เคลียร์จองต่อแถวสินค้า (พอร์ตจาก salehos_approve.php)
			// อ่านจาก hos__subso ตรง ๆ (ไม่ใช้ $id ที่มาจากฟอร์ม) เพราะ ณ จุดนี้แถวใหม่ที่เพิ่งเพิ่มระหว่างแก้ไข
			// (เช่น import จากใบยืมแล้วกดอนุมัติทันทีโดยไม่ผ่านการบันทึกก่อน) ถูก insert ไปแล้วก่อนหน้านี้ในไฟล์
			// แต่ subso_db_id ของแถวนั้นจะว่างในฟอร์ม ทำให้ไม่ถูกแม็พเข้า $id เลย
			$approveRowsResult = mysqli_query($conn, "SELECT id, product_id, clear_br, clear_ivno, sn, count AS sale_count, jong_no FROM hos__subso WHERE ref_idd = '" . mysqli_real_escape_string($conn, $ref_id) . "' AND COALESCE(bom_ckk,'0') <> '1'");
			while ($approveRow = mysqli_fetch_assoc($approveRowsResult)) {
				$id_new = $approveRow['id'];
				$product_id_new = $approveRow['product_id'];
				$sn_new = trim($approveRow['sn'] ?? '');
				$clear_ivno_new = trim($approveRow['clear_ivno'] ?? '');
				$sale_count_new = $approveRow['sale_count'] ?? 0;
				$jong_no_new = trim($approveRow['jong_no'] ?? '');

				if (substr($clear_ivno_new, 0, 4) === 'BREG') {
					// เอกสารใบยืม BREG ไม่ต้องเช็คเคลียร์ยืม (ตามพฤติกรรมเดิม)
				} elseif ($clear_ivno_new !== '') {
					$rssc1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT ref_id FROM hos__consig WHERE iv_no = '" . mysqli_real_escape_string($conn, $clear_ivno_new) . "' AND status_doc = 'Approve'"));
					$rssc2 = mysqli_fetch_array(mysqli_query($conn, "SELECT SUM(count) AS sale_count FROM hos__subconsig WHERE ref_idd = '" . ($rssc1['ref_id'] ?? '') . "' AND product_id = '" . mysqli_real_escape_string($conn, $product_id_new) . "'"));

					$rse1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT ref_id FROM hos__breg WHERE iv_no = '" . mysqli_real_escape_string($conn, $clear_ivno_new) . "' AND status_doc = 'Approve'"));
					$rse2 = mysqli_fetch_array(mysqli_query($conn, "SELECT SUM(count1) AS sale_count FROM hos__subbreg1 WHERE ref_id1 = '" . ($rse1['ref_id'] ?? '') . "' AND product_id1 = '" . mysqli_real_escape_string($conn, $product_id_new) . "'"));

					$rs1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT ref_id_br FROM hos__br WHERE iv_no = '" . mysqli_real_escape_string($conn, $clear_ivno_new) . "' AND status_doc = 'Approve'"));
					$rs2 = mysqli_fetch_array(mysqli_query($conn, "SELECT SUM(count) AS sale_count FROM hos__subbr WHERE ref_idd_br = '" . ($rs1['ref_id_br'] ?? '') . "' AND product_id = '" . mysqli_real_escape_string($conn, $product_id_new) . "'"));

					$rs21 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT ref_id FROM so__main WHERE doc_no = '" . mysqli_real_escape_string($conn, $clear_ivno_new) . "' AND cancel_ckk='0'"));
					$rs22 = mysqli_fetch_array(mysqli_query($conn, "SELECT SUM(sale_count) AS sale_count FROM so__submain WHERE ref_idd = '" . ($rs21['ref_id'] ?? '') . "' AND product_id = '" . mysqli_real_escape_string($conn, $product_id_new) . "'"));

					$rs3 = mysqli_fetch_array(mysqli_query($conn, "SELECT SUM(sale_count) AS count3 FROM hos__subspr WHERE product_id = '" . mysqli_real_escape_string($conn, $product_id_new) . "' AND clear_br = '1' AND clear_ivno = '" . mysqli_real_escape_string($conn, $clear_ivno_new) . "' AND status_spr = 'Approve'"));
					$rs13 = mysqli_fetch_array(mysqli_query($conn, "SELECT SUM(count) AS count3 FROM hos__subso WHERE product_id = '" . mysqli_real_escape_string($conn, $product_id_new) . "' AND clear_br = '1' AND clear_ivno = '" . mysqli_real_escape_string($conn, $clear_ivno_new) . "' AND status_so = 'Approve'"));
					$rs41 = mysqli_fetch_array(mysqli_query($conn, "SELECT ref_id FROM hos__receive WHERE iv_no = '" . mysqli_real_escape_string($conn, $clear_ivno_new) . "'"));
					$rs4 = mysqli_fetch_array(mysqli_query($conn, "SELECT SUM(count) AS count4 FROM hos__subreceive WHERE ref_idd = '" . ($rs41['ref_id'] ?? '') . "' AND product_id = '" . mysqli_real_escape_string($conn, $product_id_new) . "'"));
					$rs12 = mysqli_fetch_array(mysqli_query($conn, "SELECT SUM(sale_count) AS count3 FROM hos__subsmp WHERE product_id = '" . mysqli_real_escape_string($conn, $product_id_new) . "' AND clear_br = '1' AND br_no = '" . mysqli_real_escape_string($conn, $clear_ivno_new) . "' AND status_smp = 'Approve'"));

					$count3 = $rs3['count3'] ?? 0;
					$count13 = $rs13['count3'] ?? 0;
					$count4 = $rs4['count4'] ?? 0;
					$count5 = $rs12['count3'] ?? 0;
					$count2 = (($rs2['sale_count'] ?? 0) + ($rs22['sale_count'] ?? 0) + ($rse2['sale_count'] ?? 0) + ($rssc2['sale_count'] ?? 0)) - ($count3 + $count4 + $count5 + $count13 + $sale_count_new);

					if ($sn_new !== '') {
						$rsSn3 = mysqli_fetch_array(mysqli_query($conn, "SELECT SUM(sale_count) AS count3 FROM hos__subspr WHERE product_id = '" . mysqli_real_escape_string($conn, $product_id_new) . "' AND sn = '" . mysqli_real_escape_string($conn, $sn_new) . "' AND clear_br = '1' AND clear_ivno = '" . mysqli_real_escape_string($conn, $clear_ivno_new) . "' AND status_spr = 'Approve'"));
						$rsSn13 = mysqli_fetch_array(mysqli_query($conn, "SELECT SUM(count) AS count3 FROM hos__subso WHERE product_id = '" . mysqli_real_escape_string($conn, $product_id_new) . "' AND sn = '" . mysqli_real_escape_string($conn, $sn_new) . "' AND clear_br = '1' AND clear_ivno = '" . mysqli_real_escape_string($conn, $clear_ivno_new) . "' AND status_so = 'Approve' AND id <> '" . mysqli_real_escape_string($conn, $id_new) . "'"));
						$rsSn41 = mysqli_fetch_array(mysqli_query($conn, "SELECT ref_id FROM hos__receive WHERE iv_no = '" . mysqli_real_escape_string($conn, $clear_ivno_new) . "'"));
						$rsSn4 = mysqli_fetch_array(mysqli_query($conn, "SELECT SUM(count) AS count4 FROM hos__subreceive WHERE ref_idd = '" . ($rsSn41['ref_id'] ?? '') . "' AND sn = '" . mysqli_real_escape_string($conn, $sn_new) . "' AND product_id = '" . mysqli_real_escape_string($conn, $product_id_new) . "'"));
						$rsSn12 = mysqli_fetch_array(mysqli_query($conn, "SELECT SUM(sale_count) AS count3 FROM hos__subsmp WHERE product_id = '" . mysqli_real_escape_string($conn, $product_id_new) . "' AND sn = '" . mysqli_real_escape_string($conn, $sn_new) . "' AND clear_br = '1' AND br_no = '" . mysqli_real_escape_string($conn, $clear_ivno_new) . "' AND status_smp = 'Approve'"));

						$countSn = number_format(($rsSn3['count3'] ?? 0) + ($rsSn4['count4'] ?? 0) + ($rsSn12['count3'] ?? 0) + ($rsSn13['count3'] ?? 0), 0) . "";

						if ($countSn !== '0') {
							echo "<script language=\"JavaScript\">";
							echo "alert('หมายเลขเครื่อง : $sn_new มีการเคลียร์ยืมไปแล้วค่ะ');window.location='" . $redirect_to . "?ref_id=$ref_id';";
							echo "</script>";
							exit();
						}
					}

					if ($count2 < 0) {
						echo "<script language=\"JavaScript\">";
						echo "alert('สินค้าในใบยืมนี้มีไม่พอในการเคลียร์ยืมครั้งนี้ค่ะ');window.location='" . $redirect_to . "?ref_id=$ref_id';";
						echo "</script>";
						exit();
					}

					if ($count2 <= 0) {
						mysqli_query($conn, "UPDATE hos__subbr SET clear_ckk='1' WHERE ref_idd_br='" . ($rs1['ref_id_br'] ?? '') . "' AND product_id='" . mysqli_real_escape_string($conn, $product_id_new) . "'");
						mysqli_query($conn, "UPDATE hos__subconsig SET clear_ckk='1' WHERE ref_idd='" . ($rssc1['ref_id'] ?? '') . "' AND product_id='" . mysqli_real_escape_string($conn, $product_id_new) . "'");
					}
				}

				if ($jong_no_new !== '') {
					$objResultj = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hos__jongproduct WHERE iv_no = '" . mysqli_real_escape_string($conn, $jong_no_new) . "'"));
					$objResultj1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hos__subjongpro WHERE ref_idd = '" . ($objResultj['ref_id'] ?? '') . "' AND product_id = '" . mysqli_real_escape_string($conn, $product_id_new) . "'"));

					$rsj3 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(sale_count) AS count3 FROM so__submain WHERE product_id = '" . ($objResultj1['product_id'] ?? '') . "' AND jong_ckk='1' AND jong_no='" . ($objResultj['iv_no'] ?? '') . "' AND status_sol='Approve'"));
					$rsj13 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(count) AS count3 FROM hos__subso WHERE product_id = '" . ($objResultj1['product_id'] ?? '') . "' AND jong_ckk='1' AND jong_no='" . ($objResultj['iv_no'] ?? '') . "' AND status_so='Approve'"));

					$countj2 = ($objResultj1['count'] ?? 0) - (($rsj3['count3'] ?? 0) + ($rsj13['count3'] ?? 0));

					if ($countj2 < 0) {
						echo "<script language=\"JavaScript\">";
						echo "alert('สินค้าในใบจองนี้มีไม่พอในการเคลียร์จองครั้งนี้ค่ะ');window.location='" . $redirect_to . "?ref_id=$ref_id';";
						echo "</script>";
						exit();
					}

					if ((float)$countj2 == 0.0) {
						mysqli_query($conn, "UPDATE hos__subjongpro SET close_ckk='1' WHERE ref_idd='" . ($objResultj['ref_id'] ?? '') . "' AND product_id='" . mysqli_real_escape_string($conn, $product_id_new) . "'");
					}
				}
			}

			// คำนวณ send_cm ตามประเภทเอกสาร (IC) / ยอดรวม+วิธีชำระเป็นเครดิต ≤2000 (พอร์ตจาก salehos_approve.php)
			$rsPaymentApprove = mysqli_fetch_assoc(mysqli_query($conn, "SELECT payment FROM hos__so WHERE ref_id='" . mysqli_real_escape_string($conn, $ref_id) . "'"));
			$paymentApprove = $rsPaymentApprove['payment'] ?? '';
			$rsAmountApprove = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(amount) AS amount FROM hos__subso WHERE ref_idd='" . mysqli_real_escape_string($conn, $ref_id) . "'"));
			$amountApprove = $rsAmountApprove['amount'] ?? 0;

			if ($ic_ckk === '1') {
				mysqli_query($conn, "UPDATE hos__so SET send_cm='2', approve='" . mysqli_real_escape_string($conn, $approve_name) . "', approve_code='" . mysqli_real_escape_string($conn, $approve_code) . "', approve_date='" . $approve_date_val . "', approve_time='" . $approve_time_val . "' WHERE ref_id='" . mysqli_real_escape_string($conn, $ref_id) . "'");
			} elseif ((float)$amountApprove <= 2000 && in_array($paymentApprove, ['36', '38', '39', '40', '41', '42'], true)) {
				mysqli_query($conn, "UPDATE hos__so SET send_cm='1', approve='" . mysqli_real_escape_string($conn, $approve_name) . "', approve_code='" . mysqli_real_escape_string($conn, $approve_code) . "', approve_date='" . $approve_date_val . "', approve_time='" . $approve_time_val . "' WHERE ref_id='" . mysqli_real_escape_string($conn, $ref_id) . "'");
			} else {
				mysqli_query($conn, "UPDATE hos__so SET status_doc='Approve', approve='" . mysqli_real_escape_string($conn, $approve_name) . "', approve_code='" . mysqli_real_escape_string($conn, $approve_code) . "', approve_date='" . $approve_date_val . "', send_admin='1', approve_time='" . $approve_time_val . "' WHERE ref_id='" . mysqli_real_escape_string($conn, $ref_id) . "'");
				mysqli_query($conn, "UPDATE hos__subso SET status_so='Approve' WHERE ref_idd='" . mysqli_real_escape_string($conn, $ref_id) . "'");
			}
		}
	}

	if ($qsave && tableExists($conn, 'tb_document_status_log')) {
		$soSafeLogRefId = mysqli_real_escape_string($conn, $ref_id);
		$soLogUserId = mysqli_real_escape_string($conn, $_SESSION['UserID'] ?? '');
		$soLogUserName = mysqli_real_escape_string($conn, trim(($_SESSION['name'] ?? '') . ' ' . ($_SESSION['surname'] ?? '')));
		$soApproveReason = trim((string)($_POST['so_approve_reason'] ?? ''));
		$soApproveStatusMap = array(
			'return' => 'Returned',
			'reject' => 'Rejected'
		);

		if (isset($soApproveStatusMap[$soApproveAction]) && $soApproveReason !== '') {
			mysqli_query($conn, "INSERT INTO tb_document_status_log (ref_id, status_doc, reason, user_id, user_name)
				VALUES ('" . $soSafeLogRefId . "', '" . $soApproveStatusMap[$soApproveAction] . "', '"
				. mysqli_real_escape_string($conn, $soApproveReason) . "', '"
				. $soLogUserId . "', '"
				. $soLogUserName . "')");
		}

		$soCancelReason = trim((string)($_POST['admin_cancel_reason'] ?? ''));
		if ($soCancelReason === '') {
			$soCancelReason = $soApproveReason;
		}
		if ($cancelDocPost === '1' && $soCancelReason !== '') {
			mysqli_query($conn, "INSERT INTO tb_document_status_log (ref_id, status_doc, reason, user_id, user_name)
				VALUES ('" . $soSafeLogRefId . "', 'Cancelled', '"
				. mysqli_real_escape_string($conn, $soCancelReason) . "', '"
				. $soLogUserId . "', '"
				. $soLogUserName . "')");
		}
	}
	if ($qsave) {
		if (($_POST['is_draft'] ?? '') === '1') {
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode(array('success' => true, 'ref_id' => $ref_id));
			exit();
		}

		echo "<script language=\"JavaScript\">";
		$redirect_url = $redirect_to . "?ref_id=" . urlencode($ref_id);
		if (strpos($redirect_to, "register_suphos.php") !== false) {
			$redirect_url .= "&saved=1";
		}
		echo "window.location='" . $redirect_url . "';";
		echo "</script>";
	} else {
		if (($_POST['is_draft'] ?? '') === '1') {
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode(array('success' => false, 'message' => 'Cannot save draft'));
			exit();
		}

		echo "Cannot";
	}
}
