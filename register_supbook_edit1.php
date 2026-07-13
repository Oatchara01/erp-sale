<?php
$isDraftRequest = isset($_POST["is_draft"]) && $_POST["is_draft"] === "1";
if (!$isDraftRequest) {
	include("head.php");
}

include("dbconnect.php");
include("error_page.php");

date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] == "submit") {

	$ref_id = mysqli_real_escape_string($conn, $_POST["ref_id"]);
	$date_jong = mysqli_real_escape_string($conn, $_POST["date_jong"]);
	$company = mysqli_real_escape_string($conn, $_POST["company"]);
	$sale_code = mysqli_real_escape_string($conn, $_POST["sale_code"]);
	$customer_id = mysqli_real_escape_string($conn, $_POST["bill_id"]);
	$customer = mysqli_real_escape_string($conn, $_POST["customer"]);
	$drescription = mysqli_real_escape_string($conn, $_POST["drescription"]);
	$date_receive = mysqli_real_escape_string($conn, $_POST["date_receive"]);
	$ref_receive =  substr($date_receive, 0, 7);
	$address_send = mysqli_real_escape_string($conn, $_POST["address_send"]);
	$send_stock = mysqli_real_escape_string($conn, $_POST["send_stock"] ?? '');
	$contact_ckk = mysqli_real_escape_string($conn, $_POST["contact_ckk"] ?? '');
	$type_jong = mysqli_real_escape_string($conn, $_POST["type_jong"]);
	$status_doc = $isDraftRequest ? "Draft" : "Approve";
	$name =  $_SESSION['name'];
	$surname =	$_SESSION['surname'];
	$add_by = "$name $surname";
	$add_date = date('Y-m-d H:i:s');

	$iv_no = '';
	$ivNoQuery = mysqli_query($conn, "SELECT iv_no FROM hos__jongproduct WHERE ref_id = '" . $ref_id . "' LIMIT 1");
	if ($ivNoQuery && ($ivNoRow = mysqli_fetch_assoc($ivNoQuery))) {
		$iv_no = $ivNoRow['iv_no'];
	}


	$save = "UPDATE  hos__jongproduct SET date_jong = '" . $date_jong . "',customer_id = '" . $customer_id . "',customer = '" . $customer . "',drescription = '" . $drescription . "',date_receive = '" . $date_receive . "',address_send = '" . $address_send . "',sale_code = '" . $sale_code . "',ref_receive='" . $ref_receive . "',type_jong='" . $type_jong . "',contact_ckk='" . $contact_ckk . "'";
	if (!$isDraftRequest) {
		$save .= ", status_doc = 'Approve'";
	}
	$save .= "  where ref_id = '" . $ref_id . "'";

	$qsave = mysqli_query($conn, $save);



	$save1 = "insert into hos__jongproduct_rt
(ref_id,date_jong,company,customer,drescription,date_receive,address_send,sale_code,add_date,add_by,customer_id,iv_no,ref_receive,type_jong,remark_edit)
values
('" . $ref_id . "','" . $date_jong . "','" . $company . "','" . $customer . "','" . $drescription . "','" . $date_receive . "','" . $address_send . "','" . $sale_code . "','" . $add_date . "','" . $add_by . "','" . $customer_id . "','" . $iv_no . "','" . $ref_receive . "','" . $type_jong . "','')";

	$qsave1 = mysqli_query($conn, $save1);



	// รายการสินค้าแบบไดนามิก: id[] ว่าง = แถวใหม่ที่เพิ่มระหว่างแก้ไข, id[] ที่มีค่า = แถวเดิมให้ UPDATE
	// แถวเดิมในฐานข้อมูลที่ไม่ถูกส่งกลับมา (ถูกลบออกจากหน้าจอ) จะถูก DELETE ทิ้ง
	$idList = isset($_POST['id']) && is_array($_POST['id']) ? $_POST['id'] : array();
	$productIdList = isset($_POST['product_id']) && is_array($_POST['product_id']) ? $_POST['product_id'] : array();
	$countList = isset($_POST['count']) && is_array($_POST['count']) ? $_POST['count'] : array();
	$saleRemarkkList = isset($_POST['sale_remarkk']) && is_array($_POST['sale_remarkk']) ? $_POST['sale_remarkk'] : array();

	$keptIds = array();

	for ($i = 0; $i < count($productIdList); $i++) {

		$row_id = isset($idList[$i]) ? trim($idList[$i]) : '';
		$row_product_id = trim($productIdList[$i]);
		$row_count = isset($countList[$i]) ? trim($countList[$i]) : '';
		$row_remark = isset($saleRemarkkList[$i]) ? $saleRemarkkList[$i] : '';

		if ($row_product_id === '') {
			continue;
		}

		$row_product_id_esc = mysqli_real_escape_string($conn, $row_product_id);
		$row_count_esc = mysqli_real_escape_string($conn, $row_count);
		$row_remark_esc = mysqli_real_escape_string($conn, $row_remark);

		if ($row_id !== '' && ctype_digit($row_id)) {
			$strSQL1 = "UPDATE hos__subjongpro SET product_id = '" . $row_product_id_esc . "', product_code = '" . $row_product_id_esc . "', count = '" . $row_count_esc . "', sale_remark = '" . $row_remark_esc . "' WHERE id = '" . $row_id . "' AND ref_idd = '" . $ref_id . "'";
			mysqli_query($conn, $strSQL1);
			$keptIds[] = $row_id;
		} else {
			$strSQL1 = "INSERT INTO hos__subjongpro
(ref_idd,product_id,product_code,count,sale_remark)
VALUES ('" . $ref_id . "','" . $row_product_id_esc . "','" . $row_product_id_esc . "','" . $row_count_esc . "','" . $row_remark_esc . "')";
			mysqli_query($conn, $strSQL1);
			$newId = mysqli_insert_id($conn);
			if ($newId) {
				$keptIds[] = (string)$newId;
			}
		}

		$strSQLs1 = "insert into hos__subjongpro_ref
(ref_idd,product_id,product_code,count,sale_remark,add_date,add_by)
values ('" . $ref_id . "','" . $row_product_id_esc . "','" . $row_product_id_esc . "','" . $row_count_esc . "','" . $row_remark_esc . "','" . $add_date . "','" . $add_by . "')";
		mysqli_query($conn, $strSQLs1);
	}

	$strSQLExisting = "SELECT id FROM hos__subjongpro WHERE ref_idd = '" . $ref_id . "'";
	$objQueryExisting = mysqli_query($conn, $strSQLExisting);
	if ($objQueryExisting) {
		while ($existingRow = mysqli_fetch_assoc($objQueryExisting)) {
			if (!in_array((string)$existingRow['id'], $keptIds, true)) {
				mysqli_query($conn, "DELETE FROM hos__subjongpro WHERE id = '" . (int)$existingRow['id'] . "'");
			}
		}
	}

	if ($send_stock == '1' && !$isDraftRequest) {

		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
		date_default_timezone_set("Asia/Bangkok");
		$sToken = "uHRdo0cuoAeo2QdHm9xNLesbZidwSPRxjhGgm3W9HuE";
		$sMessage = "หมายเลขอ้างอิง $ref_id มีการแก้ไขใบจองค่ะ ";
		$chOne = curl_init();
		curl_setopt($chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
		curl_setopt($chOne, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($chOne, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($chOne, CURLOPT_POST, 1);
		curl_setopt($chOne, CURLOPT_POSTFIELDS, "message=" . $sMessage);
		$headers = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer ' . $sToken . '',);
		curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($chOne, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($chOne);
		if (curl_error($chOne)) {
			echo 'error:' . curl_error($chOne);
		} else {
			$result_ = json_decode($result, true);
			echo "status : " . $result_['status'];
			echo "message : " . $result_['message'];
		}
		curl_close($chOne);
	}




	if ($qsave) {
		if ($isDraftRequest) {
			echo json_encode(array('success' => true, 'ref_id' => $ref_id));
			exit();
		}
		echo "<script language=\"JavaScript\">";
		echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_supbook.php?ref_id=$ref_id&saved=1';";
		echo "</script>";
	} else {
		if ($isDraftRequest) {
			echo json_encode(array('success' => false, 'message' => 'Cannot save draft'));
			exit();
		}
		echo "Cannot";
	}
}
