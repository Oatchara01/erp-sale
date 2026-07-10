<?php include("head.php"); ?>


<?php
include("dbconnect.php");
include("error_page.php");

date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

	$date_jong = $_POST["date_jong"];
	$company = $_POST["company"];
	$customer_id = $_POST["bill_id"];
	$customer = $_POST["customer"];
	$drescription = $_POST["drescription"];
	$date_receive = $_POST["date_receive"];
	$ref_receive =  substr($date_receive, 0, 7);
	$address_send = $_POST["address_send"];
	$type_jong = $_POST["type_jong"];
	$isDraftRequest = isset($_POST["is_draft"]) && $_POST["is_draft"] === "1";
	$send_sup = $isDraftRequest ? '0' : '1';
	$date_approve = date('Y-m-d');
	$status_doc = $isDraftRequest ? "Draft" : "Approve";
	$sale_code = $_POST["sale_code"];
	$name =  $_SESSION['name'];
	$surname =	$_SESSION['surname'];
	$add_by = "$name $surname";
	$add_date = date('Y-m-d H:i:s');

	$yearMonth = substr(date("Y") + 543, -2) . date("m");
	$sql = "SELECT MAX(iv_no) AS MAXID FROM hos__jongproduct";
	$qry = mysqli_query($conn, $sql) or die(mysqli_error());
	$rs = mysqli_fetch_assoc($qry);
	$maxId = substr($rs['MAXID'], -3);
	$maxId3 = substr($rs['MAXID'], -7);

	$maxId1 = substr($maxId3, 0, -3);
	$so1 = "JG";

	if ($maxId1 == $yearMonth) {
		$maxId1 = ($maxId + 1);
		$maxId2 = substr("000" . $maxId1, -3);
		$nextId1 = $yearMonth . $maxId2;
	} else {
		$maxId1 = "001";
		$nextId1 = $yearMonth . $maxId1;
	}

	$iv_no = "$so1$nextId1";


	$yearMonth = substr(date("Y") + 543, -2) . date("m");
	$sql = "SELECT MAX(ref_id) AS MAXID FROM hos__jongproduct";
	$qry = mysqli_query($conn, $sql) or die(mysqli_error());
	$rs = mysqli_fetch_assoc($qry);
	$maxId = substr($rs['MAXID'], -4);
	$maxId3 = substr($rs['MAXID'], -8);

	$maxId1 = substr($maxId3, 0, -4);
	$so = "PD";

	if ($maxId1 == $yearMonth) {
		$maxId1 = ($maxId + 1);
		$maxId2 = substr("00000" . $maxId1, -4);
		$nextId = $yearMonth . $maxId2;
	} else {
		$maxId1 = "0001";
		$nextId = $yearMonth . $maxId1;
	}




	$ref_id = "$so$nextId";


	$save = "insert into hos__jongproduct
(ref_id,date_jong,company,customer,drescription,date_receive,address_send,status_doc,sale_code,sale_name,add_date,add_by,date_approve,send_sup,approve_name,customer_id,iv_no,ref_receive,type_jong)
values
('" . $ref_id . "','" . $date_jong . "','" . $company . "','" . $customer . "','" . $drescription . "','" . $date_receive . "','" . $address_send . "','" . $status_doc . "','" . $sale_code . "','" . $add_by . "','" . $add_date . "','" . $add_by . "','" . $date_approve . "','" . $send_sup . "','" . $add_by . "','" . $customer_id . "','" . $iv_no . "','" . $ref_receive . "','" . $type_jong . "')";

	$qsave = mysqli_query($conn, $save);





	$save1 = "insert into hos__jongproduct_rt
(ref_id,date_jong,company,customer,drescription,date_receive,address_send,sale_code,add_date,add_by,customer_id,iv_no,ref_receive,type_jong)
values
('" . $ref_id . "','" . $date_jong . "','" . $company . "','" . $customer . "','" . $drescription . "','" . $date_receive . "','" . $address_send . "','" . $sale_code . "','" . $add_date . "','" . $add_by . "','" . $customer_id . "','" . $iv_no . "','" . $ref_receive . "','" . $type_jong . "')";

	$qsave1 = mysqli_query($conn, $save1);


	// รายการสินค้าแบบไดนามิก: product_id[]/product_code[]/sale_count[]/sale_remark[] มาจากตารางสินค้าแบบเพิ่ม/ลบ/ลากจัดเรียงได้ไม่จำกัดแถวในหน้า register_supbook.php
	$productIdList = isset($_POST['product_id']) && is_array($_POST['product_id']) ? $_POST['product_id'] : array();
	$productCodeList = isset($_POST['product_code']) && is_array($_POST['product_code']) ? $_POST['product_code'] : array();
	$saleCountList = isset($_POST['sale_count']) && is_array($_POST['sale_count']) ? $_POST['sale_count'] : array();
	$saleRemarkList = isset($_POST['sale_remark']) && is_array($_POST['sale_remark']) ? $_POST['sale_remark'] : array();

	for ($i = 0; $i < count($productIdList); $i++) {

		$row_product_id = trim($productIdList[$i]);
		$row_product_code = isset($productCodeList[$i]) ? trim($productCodeList[$i]) : '';
		$row_sale_count = isset($saleCountList[$i]) ? trim($saleCountList[$i]) : '';
		$row_sale_remark = isset($saleRemarkList[$i]) ? $saleRemarkList[$i] : '';

		if ($row_product_id === '') {
			continue;
		}

		$row_product_code_esc = mysqli_real_escape_string($conn, $row_product_code);
		$row_product_id_esc = mysqli_real_escape_string($conn, $row_product_id);
		$row_sale_count_esc = mysqli_real_escape_string($conn, $row_sale_count);
		$row_sale_remark_esc = mysqli_real_escape_string($conn, $row_sale_remark);

		$strSQL31 = "SELECT * FROM tb_product_bomhos WHERE bom_code = '" . $row_product_code_esc . "' ";
		$objQuery31 = mysqli_query($conn, $strSQL31) or die("Error Query [" . $strSQL31 . "]");
		$Num_Rows31 = mysqli_num_rows($objQuery31);
		$objResult31 = mysqli_fetch_array($objQuery31);

		if ($Num_Rows31 > 0) {

			for ($bomSlot = 1; $bomSlot <= 10; $bomSlot++) {
				$id_product = $objResult31["product_id" . $bomSlot];
				if ($id_product == '') {
					continue;
				}
				$unit_qty = $row_sale_count * $objResult31["unit" . $bomSlot];
				$id_product_esc = mysqli_real_escape_string($conn, $id_product);
				$unit_qty_esc = mysqli_real_escape_string($conn, $unit_qty);

				$strSQL1 = "insert into hos__subjongpro
			(ref_idd,product_id,product_code,count,sale_remark)
			values ('" . $ref_id . "','" . $id_product_esc . "','" . $id_product_esc . "','" . $unit_qty_esc . "','" . $row_sale_remark_esc . "')";
				mysqli_query($conn, $strSQL1);
			}
		} else {

			$strSQL1 = "insert into hos__subjongpro
		(ref_idd,product_id,product_code,count,sale_remark)
		values ('" . $ref_id . "','" . $row_product_id_esc . "','" . $row_product_id_esc . "','" . $row_sale_count_esc . "','" . $row_sale_remark_esc . "')";
			mysqli_query($conn, $strSQL1);

			$strSQLs1 = "insert into hos__subjongpro_ref
		(ref_idd,product_id,product_code,count,sale_remark,add_date,add_by)
		values ('" . $ref_id . "','" . $row_product_id_esc . "','" . $row_product_id_esc . "','" . $row_sale_count_esc . "','" . $row_sale_remark_esc . "','" . $add_date . "','" . $add_by . "')";
			mysqli_query($conn, $strSQLs1);
		}
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
