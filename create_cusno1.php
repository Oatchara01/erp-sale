<?php
include "dbconnect.php";

$type_doc = $_GET["type_doc"];
$ref_id1 = $_GET["ref_id"];

$strSQL = "SELECT bill_id,iv_date FROM hos__so WHERE ref_id = '".$_GET["ref_id"]."' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$bill_id = $objResult["bill_id"];
$iv_date = $objResult["iv_date"];
$yy = substr($iv_date,0,4);
$mm1 = substr($iv_date,0,7);
$mm = substr($mm1,-2);



if($type_doc =='3'){
	
$yearMonth = substr($yy+543, -2).$mm;
$sql = "SELECT MAX(customer_code) AS MAXID FROM tb_customer  where customer_code LIKE '%$yearMonth%'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
$maxId = substr($rs['MAXID'], -4);
$maxId3 = substr($rs['MAXID'],-8);

$maxId1 = substr($maxId3,0,-4);

if($maxId1 == $yearMonth)
{
$maxId1 = ($maxId + 1);
$maxId2 = substr("00000".$maxId1, -4);
$nextId = $yearMonth.$maxId2;
}
else 
{
$maxId1 = "0001"; 
$nextId = $yearMonth.$maxId1;

}

$so = "PC";
$ref_id ="$so$nextId";	
	


$save="UPDATE  tb_customer SET customer_code='".$ref_id."' where customer_id ='".$bill_id."'";
$qsave=mysqli_query($conn,$save);


		
	}else if($type_doc =='4'){
		
$yearMonth = substr($yy+543, -2).$mm;
$sql = "SELECT MAX(customer_coden) AS MAXID FROM tb_customer  where customer_coden LIKE '%$yearMonth%'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
$maxId = substr($rs['MAXID'], -4);
$maxId3 = substr($rs['MAXID'],-8);

$maxId1 = substr($maxId3,0,-4);

if($maxId1 == $yearMonth)
{
$maxId1 = ($maxId + 1);
$maxId2 = substr("00000".$maxId1, -4);
$nextId = $yearMonth.$maxId2;
}
else 
{
$maxId1 = "0001"; 
$nextId = $yearMonth.$maxId1;

}

$so = "NC";
$ref_id ="$so$nextId";
	

$save="UPDATE  tb_customer SET customer_coden = '".$ref_id."' where customer_id ='".$bill_id."'";
$qsave=mysqli_query($conn,$save);

}


 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_adminhos_edit.php?ref_id=$ref_id1';";
echo "</script>";
  } else {
   echo "Cannot";
  }


?>