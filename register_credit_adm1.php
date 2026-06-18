<?php include ("head.php"); ?>

<?php
include("dbconnect.php");
include ("error_page.php"); 

date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {


$ref_credit = trim($_POST["ref_credit"]);
$status_doc =  $_POST["status_doc"];
$des_doc =  $_POST["des_doc"];
$date_credit = $_POST["date_credit"];	
$new_bill = $_POST["new_bill"];	
$date_oldbill = $_POST["date_oldbill"];	
$desnew_bill = $_POST["desnew_bill"];	
$date_tran = $_POST["date_tran"];
$credit_ckk = $_POST["credit_ckk"];	
$send_receipt = $_POST["send_receipt"];	
$surname =	$_SESSION['surname'];
$name =	$_SESSION['name'];
$add_by = "$name $surname";
$add_date = date('Y-m-d H:i:s');	
	
$save="Update tb_credit_note set date_credit='".$date_credit."',new_bill='".$new_bill."',date_oldbill='".$date_oldbill."',desnew_bill='".$desnew_bill."',date_tran='".$date_tran."'  where ref_credit = '".$ref_credit."'";
$qsave=mysqli_query($conn,$save);	

if($status_doc !=''){
$save1="Update tb_credit_note set status_doc='".$status_doc."',des_doc='".$des_doc."'  where ref_credit = '".$ref_credit."'";
$qsave1=mysqli_query($conn,$save1);
}

	
	
$strSQL219 = "SELECT * FROM tb_credit_note WHERE ref_credit = '".$ref_credit."' ";
$objQuery219 = mysqli_query($conn,$strSQL219) or die ("Error Query [".$strSQL219."]");
$rs1 = mysqli_fetch_assoc($objQuery219);

$date_inv = $rs1["date_credit"];	
$iv_no = $rs1["credit_no"];	
$com = $rs1["company_type"];
$bill_name = $rs1["customer_name"];	
$bill_id = $rs1["bill_id"];	
$iv_no_ref = $rs1["iv_no_ref"];	
$ref_id = $rs1["ref_id"];	
$ref_order_id = $rs1["ref_order_id"];	
$sale_code = $rs1["sale_code"];	

if($send_receipt=='2'){
		
$strSQL29 = "SELECT SUM(sum_amount) AS unit_cash FROM tb_subcredit WHERE ref_creditt = '".$ref_credit."' ";
$objQuery29 = mysqli_query($conn,$strSQL29) or die ("Error Query [".$strSQL29."]");
$rs = mysqli_fetch_assoc($objQuery29);

$unit_cash = $rs["unit_cash"];

	

$strSQL293="Update  tb_credit_not SET credit_no='".$iv_no."',date_cdnote='".$date_inv."',type_doc='".$com."',customer_name='".$bill_name."',bill_id='".$bill_id."',ref_idsale='".$ref_id."',ref_ivsale='".$iv_no_ref."',sale_channel='".$sale_channel."',ref_order_id='".$ref_order_id."',sale_code='".$sale_code."',amount='".$unit_cash."' where ref_id = '".$ref_credit."' and summary_all !='สมบูรณ์'";
$objQuery293 = mysqli_query($code,$strSQL293);	
			

}else if($credit_ckk=='1'){
		
$strSQL29 = "SELECT SUM(sum_amount) AS unit_cash FROM tb_subcredit WHERE ref_creditt = '".$ref_credit."' ";
$objQuery29 = mysqli_query($conn,$strSQL29) or die ("Error Query [".$strSQL29."]");
$rs = mysqli_fetch_assoc($objQuery29);

$unit_cash = $rs["unit_cash"];


$strSQL292="insert into tb_credit_not (ref_id,credit_no,date_cdnote,type_doc,customer_name,add_by,add_date,bill_id,ref_idsale,ref_ivsale,sale_channel,ref_order_id,sale_code,amount) values ('".$ref_credit."','".$iv_no."','".$date_inv."','".$com."','".$bill_name."','".$add_by."','".$add_date."','".$bill_id."','".$ref_id."','".$iv_no_ref."','".$sale_channel."','".$ref_order_id."','".$sale_code."','".$unit_cash."')";
$objQuery292 = mysqli_query($code,$strSQL292);	
			

$strSQL262="Update  tb_credit_note set send_receipt ='2'  where ref_credit = '".$ref_credit."'";
$objQuery262 = mysqli_query($conn,$strSQL262);		

	}
	



	
	
	
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_credit_adm.php?ref_credit=$ref_credit';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}