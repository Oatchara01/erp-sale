<?php include("head.php"); ?>

<?php
include("dbconnect.php");
include("error_page.php");

date_default_timezone_set("Asia/Bangkok");
if ($_SERVER['REQUEST_METHOD'] === 'POST' || isset($_POST["submit"])) {

	$date_credit = $_POST["date_credit"] ?? '';
	$customer_name = $_POST["customer_name"] ?? '';
	$customer_tel = $_POST["customer_tel"] ?? '';
	$address_name = $_POST["address_name"] ?? '';
	$return_reason = trim($_POST["return_reason"] ?? '');
	$return_des_input = trim($_POST["return_des"] ?? '');
	$return_des_parts = array_filter([$return_reason, $return_des_input]);
	$return_des = implode(' - ', $return_des_parts);
	$send_return_name = $_POST["send_return_name"] ?? '';
	$date_send_return = $_POST["date_send_return"] ?? '';
	$receive_name = $_POST["receive_name"] ?? '';
	$date_receive = $_POST["date_receive"] ?? '';
	$sale_name = $_POST["sale_name"] ?? '';
	$sale_date = $_POST["sale_date"] ?? '';
	$credit_ckk = $_POST["credit_ckk"] ?? '';
	$credit_no = $_POST["credit_no"] ?? '';
	$type_return_ckk = $_POST["type_return_ckk"] ?? '';
	$type_return_no = $_POST["type_return_no"] ?? '';
	$dis_credit = $_POST["dis_credit"] ?? '';
	$mode_cus = $_POST["mode_cus"] ?? '';
	$name =  $_SESSION['name'] ?? '';
	$surname =  $_SESSION['surname'] ?? '';
	$add_by = trim("$name $surname");
	$add_date = date('Y-m-d H:i:s');
	$company_type = $_POST["company_type"] ?? '';
	$ttype_doc = $_POST["ttype_doc"] ?? '';
	$iv_no_ref = $_POST["iv_no_ref"] ?? '';
	$id = $_POST["id"] ?? array();
	$count = $_POST["count"] ?? array();
	$unit_price = $_POST["unit_price"] ?? array();
	$sum_amount = $_POST["sum_amount"] ?? array();
	$discount_unit = $_POST["discount_unit"] ?? array();
	$product_id = $_POST["product_id"] ?? array();
	$sale_code = $_POST["sale_code"] ?? '';
	$send_sup = '1';
	$status_doc = 'Request';
	$send_admin = '0';
	$account_no =  $_POST["account_no"] ?? '';
	$account_name =  $_POST["account_name"] ?? '';
	$bank_name =  $_POST["bank_name"] ?? '';
	$type_return = $_POST["type_return"] ?? '';
	$ref_id = $_POST["ref_id"] ?? ($_POST["ref_order_id"] ?? '');
	$ref_order_id = $_POST["ref_order_id"] ?? $ref_id;
	$opener = $_POST["opener"] ?? '';
	$remark_et = $_POST["remark_et"] ?? ($_POST["etax_edit_note"] ?? '');
	$new_bill = $_POST["new_bill"] ?? ($_POST["etax_count"] ?? '0');
	if (trim((string)$new_bill) === '') {
		$new_bill = '0';
	}
	$date_oldbill = $_POST["date_oldbill"] ?? ($_POST["etax_orig_date"] ?? '');

	// แนบไฟล์ Book Bank (เก็บไฟล์ไว้ในโฟลเดอร์ credit_no/ และบันทึกเฉพาะชื่อไฟล์ลง DB)
	$book_bank = '';
	if (!empty($_FILES['book_bank']['name'])) {
		move_uploaded_file($_FILES['book_bank']['tmp_name'], "credit_no/" . iconv("UTF-8", "TIS-620", $_FILES['book_bank']['name']));
		$book_bank = $_FILES['book_bank']['name'];
	}

	$yearMonth = substr(date("Y") + 543, -2) . date("m");
	$sql1 = "SELECT MAX(ref_credit) AS MAXID FROM tb_credit_note";
	$qry1 = mysqli_query($conn, $sql1) or die(mysqli_error());
	$rs1 = mysqli_fetch_assoc($qry1);
	$maxId = substr($rs1['MAXID'], -4);
	$maxId3 = substr($rs1['MAXID'], -8);

	$maxId1 = substr($maxId3, 0, -4);

	if ($maxId1 == $yearMonth) {
		$maxId1 = ($maxId + 1);
		$maxId2 = substr("00000" . $maxId1, -4);
		$nextId = $yearMonth . $maxId2;
	} else {
		$maxId1 = "0001";
		$nextId = $yearMonth . $maxId1;
	}

	$so = "SR";

	$ref_credit = "$so$nextId";

	$qsave = false;

	if (!empty($product_id)) {


		$save = "insert into tb_credit_note
(ref_credit,ref_id,date_credit,customer_name,customer_tel,address_name,return_des,send_return_name,date_send_return,receive_name,date_receive,sale_name,sale_date,credit_ckk,credit_no,type_return_ckk,type_return_no,dis_credit,add_by,add_date,company_type,ttype_doc,iv_no_ref,sale_code,send_sup,send_admin,status_doc,type_return,bank_name,account_name,account_no,book_bank,mode_cus,remark_et,new_bill,date_oldbill,ref_order_id)
values
('" . $ref_credit . "','" . $ref_id . "','" . $date_credit . "','" . $customer_name . "','" . $customer_tel . "','" . $address_name . "','" . $return_des . "','" . $send_return_name . "','" . $date_send_return . "','" . $receive_name . "','" . $date_receive . "','" . $sale_name . "','" . $sale_date . "','" . $credit_ckk . "','" . $credit_no . "','" . $type_return_ckk . "','" . $type_return_no . "','" . $dis_credit . "','" . $add_by . "','" . $add_date . "','" . $company_type . "','" . $ttype_doc . "','" . $iv_no_ref . "','" . $sale_code . "','" . $send_sup . "','" . $send_admin . "','" . $status_doc . "','" . $type_return . "','" . $bank_name . "','" . $account_name . "','" . $account_no . "','" . $book_bank . "','" . $mode_cus . "','" . $remark_et . "','" . $new_bill . "','" . $date_oldbill . "','" . $ref_order_id . "')";


		$qsave = mysqli_query($conn, $save);

		if ($qsave && $ref_id !== '') {
			$refPrefix = substr($ref_id, 0, 2);
			$srUpdateTable = ($refPrefix === 'SO') ? 'hos__so' : 'so__main';
			$escRefId = mysqli_real_escape_string($conn, $ref_id);
			$escRefCredit = mysqli_real_escape_string($conn, $ref_credit);
			mysqli_query($conn, "UPDATE $srUpdateTable SET sr_no = '$escRefCredit' WHERE ref_id = '$escRefId'");
		}

		if (is_array($id)) {
			foreach ($id as $key => $value) {
				$id_new = $id[$key] ?? '';
				$count_new = $count[$key] ?? 0;
				$product_price1 = $unit_price[$key] ?? 0;
				$unit_price_new = str_replace(',', '', $product_price1);
				$product_id_new = $product_id[$key] ?? '';
				$discount_unit1 = $discount_unit[$key] ?? 0;
				$discount_unit_new = str_replace(',', '', $discount_unit1);
				$sum_amount_new = ((float)$unit_price_new - (float)$discount_unit_new) * (float)$count_new;
				$sum_discount = (float)$discount_unit_new * (float)$count_new;

				if ($product_id_new != "") {

					$strSQL = "insert into tb_subcredit
	(ref_creditt,count,unit_price,sum_amount,discount_unit,product_id,sum_discount)
	values ('" . $ref_credit . "','" . $count_new . "','" . $unit_price_new . "','" . $sum_amount_new . "','" . $discount_unit_new . "','" . $product_id_new . "','" . $sum_discount . "')";

					$objQuery = mysqli_query($conn, $strSQL);
				}
			}
		}
	}



	if ($qsave) {
		if ($opener === 'suphos') {
			echo "<script language=\"JavaScript\">";
			echo "if (window.opener && typeof window.opener.handleCreditNoteCreated === 'function') {";
			echo "  window.opener.handleCreditNoteCreated(" . json_encode($ref_credit) . ");";
			echo "  window.close();";
			echo "} else {";
			echo "  alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');";
			echo "  window.location='register_credinot_edit.php?ref_credit=$ref_credit';";
			echo "}";
			echo "</script>";
		} else {
			echo "<script language=\"JavaScript\">";
			echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_credinot_edit.php?ref_credit=$ref_credit';";
			echo "</script>";
		}
	} else {
		echo "Cannot ไม่สามารถบันทึกข้อมูลได้ เนื่องจากไม่มีรายการใบสั่งลดหนี้แล้วค่ะ";
	}
}
