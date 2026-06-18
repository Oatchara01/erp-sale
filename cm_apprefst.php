<?php
include "dbconnect.php";
include ('head.php');


  $ref_id = $_GET['ref_id'];
  $sale_code = $_GET['sale_code'];
  $name =  $_SESSION['name_show'];
  $surname = $_SESSION['surname_show'];
  $add_by = "$name $surname";
  $add_date = date('Y-m-d H:i:s');
  $approve_date = date('Y-m-d');
  $approve_time = date('H:i:s');


 $save="Update  st__main_new set status_doc='Approve',cm_name='".$add_by."',cm_date='".$add_date."',app_date='".$approve_date."'  where ref_id = '".$ref_id."' ";
 $qsave=mysqli_query($new,$save);


$strSQL = "SELECT *  FROM st__main_new WHERE ref_id = '".$ref_id."' ";
$objQuery = mysqli_query($new,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);

$edit_remark = $objResult["edit_remark"];
$iv_no  = $objResult["iv_no"];

$strSQL1 = "SELECT * FROM st__sbmain_new WHERE ref_idd = '".$ref_id."'";
$objQuery1 = mysqli_query($new,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
while($objResult1 = mysqli_fetch_array($objQuery1))
{

$strSQL99 = "SELECT *  FROM st__sbmain WHERE id_submain = '".$objResult1["ref_idsub"]."' ";
//echo $strSQL99;	
$objQuery99 = mysqli_query($new,$strSQL99) or die(mysqli_error());
$objResult99 = mysqli_fetch_array($objQuery99);	
	
if($objResult99["id_submain"]!=''){	
	

$strSQL12 = "Update st__sbmain set ref_idd = '".$objResult1["ref_idd_no"]."',product_id = '".$objResult1["product_id"]."',product_code = '".$objResult1["product_code"]."',type_doc = '".$objResult1["type_doc"]."',store_name = '".$objResult1["store_name"]."',count_send = '".$objResult1["count_send"]."',count_receive = '".$objResult1["count_receive"]."',sn_number = '".$objResult1["sn_number"]."',sale_remark = '".$objResult1["sale_remark"]."',stock_remark = '".$objResult1["stock_remark"]."',clear_ivno='".$objResult1["clear_ivno"]."',date_sum='".$objResult1["date_sum"]."',lot_no='".$objResult1["lot_no"]."'  where id_submain = '".$objResult1["ref_idsub"]."'";
  
$objQuery12 = mysqli_query($new,$strSQL12);

}else{
	
$strSQL12 = "INSERT INTO st__sbmain (ref_idd,product_id,product_code,type_doc,store_name,count_send,count_receive,sn_number,sale_remark,stock_remark,clear_ivno,date_sum,lot_no) values ('".$objResult1["ref_idd_no"]."','".$objResult1["product_id"]."','".$objResult1["product_code"]."','".$objResult1["type_doc"]."','".$objResult1["store_name"]."','".$objResult1["count_send"]."','".$objResult1["count_receive"]."','".$objResult1["sn_number"]."','".$objResult1["sale_remark"]."','".$objResult1["clear_ivno"]."','".$objResult1["date_sum"]."','".$objResult1["stock_remark"]."','".$objResult1["lot_no"]."')";
$objQuery12 = mysqli_query($new,$strSQL12);	
	
	
	
}

}




 

 if($qsave){
	 
echo "<script language=\"JavaScript\">";
echo "alert('ส่งข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_apprefst.php';";
echo "</script>";	 
	 
 }else{
   echo "Cannot";
  }
	

	
?>
