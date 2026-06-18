<?php

include ("head.php");
date_default_timezone_set("Asia/Bangkok");

include("dbconnect.php");
if ($_GET["submit"] = "submit") {
$ref_id = $_GET["ref_id"];
	
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";
$add_date = date('Y-m-d H:i:s');

$save1="insert into tb_stedit (ref_id,add_by,add_date) values ('".$ref_id."','".$add_by."','".$add_date."')";
$qsave1=mysqli_query($conn,$save1);	
	

$sql = "SELECT ref_idst   FROM so__main where ref_id ='".$ref_id."' ";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
	
$sql1 = "SELECT ref_id   FROM st__main where ref_idsale ='".$ref_id."' ";
$qry1 = mysqli_query($new,$sql1) or die(mysqli_error());
while($rs1 = mysqli_fetch_assoc($qry1))
{
$strSQL2 = "DELETE FROM st__main ";
$strSQL2 .="WHERE ref_id = '".$rs1["ref_id"]."' ";
$objQuery2 = mysqli_query($new,$strSQL2);

$strSQL3 = "DELETE FROM st__sbmain ";
$strSQL3 .="WHERE ref_idd = '".$rs1["ref_id"]."' ";
$objQuery3 = mysqli_query($new,$strSQL3);
	
$strSQL4 = "DELETE FROM st__lotnodes ";
$strSQL4 .="WHERE ref_idst = '".$rs1["ref_id"]."' ";
$objQuery4 = mysqli_query($new,$strSQL4);
	
	

}

$strSQL1 = "Update so__main SET cancel_ckk = '1' where ref_id = '".$ref_id."'";
$objQuery1 = mysqli_query($conn,$strSQL1);
	
	
$strSQL1 = "SELECT sn_number,clear_br,clear_ivno FROM  so__submain WHERE ref_idd = '".$ref_id."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
while($objResult1 = mysqli_fetch_array($objQuery1))
{

if($objResult1["sn_number"] !=''){


$sn_number =  $objResult1["sn_number"];
$str_arr = explode("\n",$sn_number);
foreach ($str_arr as $test =>$value){
$product_sn = $str_arr[$test];
$product_sn1 =  trim($product_sn);
	
if($product_sn1 !=''){
	
$strSQL = "Update   product__instock set buy_status = '0'   Where product_sn  = '".$product_sn1."' ";
$objQuery = mysqli_query($new,$strSQL);	
	
$sql1_up="update tb_products_in_stock set buy_status='0' where product_sn='".$product_sn1."' ";
$objQuery5 = mysqli_query($servicenb,$sql1_up)or die(mysqli_error());		

$sql1_up="update tb_products_in_stock set buy_status='0' where product_sn='".$product_sn1."' ";
$objQuery5 = mysqli_query($service,$sql1_up)or die(mysqli_error());		
	
$strSQLd = "DELETE FROM tb_installation_data  WHERE product_sn='".$product_sn1."'";
$objQueryd = mysqli_query($service,$strSQLd);
	
$strSQLe = "DELETE FROM tb_installation_data  WHERE product_sn='".$product_sn1."'";
$objQuerye = mysqli_query($servicenb,$strSQLe);	
	

}	
}
}
}	

	
if($objResult1["clear_ivno"] !='' and $objResult1["clear_br"]=='1'){	 }else{

$strSQL = "Update   so__submain set  count_same = '0',code_same='',ckk ='0',sn_number='',stock_remark='',store_name ='',ckk_st ='0' Where  ref_idd ='".$ref_id."' ";
$objQuery = mysqli_query($conn,$strSQL);
	
}
	


if($objQuery1&&$objQuery){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_cancel_ecom.php';";
echo "</script>";
  } else {
   echo "Cannot";
  }

	
}
?>