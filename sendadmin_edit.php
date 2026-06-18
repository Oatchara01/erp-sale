<?php
include "dbconnect.php";
include "dbconnect_acc.php";
 include('head.php'); 


  $ref_id = $_GET['ref_id'];
$add_date = date('Y-m-d H:i:s');
$approve_name= $_SESSION['name'];
 if($_GET['bill_vat']=='1'){
 $status_vat = "Approve";	 
 }else{
$status_vat = "";		 
 }

 $strSQL25="Update  so__main set approve_complete='Approve',approve_date = '".$add_date."',approve_name='".$approve_name."',status_vat='".$status_vat."',send_supadm ='1'  where ref_id='".$ref_id."'";
$objQuery25 = mysqli_query($conn,$strSQL25);

$strSQL28="Update  so__submain set status_sol='Approve'  where ref_idd='".$ref_id."'";
$objQuery28 = mysqli_query($conn,$strSQL28);


$strSQL = "SELECT *  FROM so__main  WHERE ref_id = '".$ref_id."' ";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);

$doc_no = $objResult["doc_no"];
$account_approve = $objResult["account_approve"];
$doc_noo = substr($doc_no,0,4);
	
	if($doc_noo=="IV24"){
		$com ="บิลเงินสด";
	}else if ($objResult["select_type_doc"]=='3'){
		$com ="ออลล์เวล ไลฟ์ บจก.";
	}else if ($objResult["select_type_doc"]=='4'){
	$com="โนเบิล เมด บจก.";	
	}
	
	$cash = $objResult["payment"];
	if($cash=='36' or $cash=='38' or $cash=='39' or $cash=='40' or $cash=='40' or $cash=='42'){
	$credit = '1';	
	}else{
	$credit = '0';		
	}
	
	$doc_no1 = substr($doc_no,0,2);
	
		

	if($account_approve=='1'){
		
$strSQL15 = "SELECT SUM(sum_amount) AS amount_1 FROM so__submain WHERE ref_idd = '".$ref_id."' ";
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResult15= mysqli_fetch_array($objQuery15);
$amount_1 = $objResult15["amount_1"];
		
		

$billing_name = $objResult["billing_name"];
$transfer_date = $objResult["transfer_date"];

if($objResult["delivery_date"]!='0000-00-00'){		
$delivery_date = $objResult["delivery_date"];
}else{
$delivery_date = $objResult["register_date"];	
}	
		
$bill_id = $objResult["bill_id"];		
		
		
	$strSQL29="insert into   tb_register_data ( IV_number,date_inv,company,customer_name,date_tranfer,unit_cash,
cash,employee_name,ref_id,bill_id,credit) values ('".$doc_no."','".$delivery_date."','".$com."','".$billing_name."','".$transfer_date."','".$amount_1."','".$cash."','".$approve_name."','".$ref_id."','".$bill_id."','".$credit."')";

$objQuery29 = mysqli_query($code,$strSQL29);	
	
		
		}
	
 
 
 if($objQuery25){
   echo "<script language=\"JavaScript\">";
echo "alert('ส่งข้อมูลให้ Admin เรียบร้อยแล้วค่ะ');window.location='register_allwell_edit.php?ref_id=$ref_id';";
echo "</script>";
  } else {
   echo "Cannot";
  }
  ?>