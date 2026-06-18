
<?php
include"dbconnect.php";
include('head.php'); 

$ref_id = $_GET["ref_id"];
$product_id = $_GET["product_id"]; 
$add_date = date('Y-m-d H:i:s');
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";

$strDate = date('Y-m-d');

$strYear = date("Y",strtotime($strDate))+543;
$strYear1 =substr( $strYear , 2 , 2 );


$sql1 = "select doc_no from tb_product_checklist order by checklist_id desc limit 1";
$query1 = mysqli_query($conn,$sql1);
$fetch1 = mysqli_fetch_array($query1,MYSQLI_ASSOC); 

$doc_no = $fetch1["doc_no"]+1;


$yearMonth = substr(date("Y")+543, -2).date("m");
$sql = "SELECT MAX(ref_pc) AS MAXID FROM tb_product_checklist";
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
$ref_pc ="$so$nextId";


$save="insert into tb_product_checklist
(ref_pc,doc_no,year_no,ref_id,product_id,add_date,add_by)
values
('".$ref_pc."','".$doc_no."','".$strYear1."','".$ref_id."','".$product_id."','".$add_date."','".$add_by."')";
$qsave=mysqli_query($conn,$save);



$save1="insert into tb_product_checklis (ref_pcc,type_emp,go_back) values ('".$ref_pc."','ST','1')";
$qsave1=mysqli_query($conn,$save1);

$save2="insert into tb_product_checklis (ref_pcc,type_emp,go_back) values ('".$ref_pc."','EN','1')";
$qsave2=mysqli_query($conn,$save2);

$save3="insert into tb_product_checklis (ref_pcc,type_emp,go_back) values ('".$ref_pc."','CS','1')";
$qsave3=mysqli_query($conn,$save3);

$save4="insert into tb_product_checklis (ref_pcc,type_emp,go_back) values ('".$ref_pc."','CS','2')";
$qsave4=mysqli_query($conn,$save4);

$save5="insert into tb_product_checklis (ref_pcc,type_emp,go_back) values ('".$ref_pc."','EN','2')";
$qsave5=mysqli_query($conn,$save5);

$save6="insert into tb_product_checklis (ref_pcc,type_emp,go_back) values ('".$ref_pc."','ST','2')";
$qsave6=mysqli_query($conn,$save6);





 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_adminchange_edit.php?ref_id=$ref_id';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	
?>