<?php
include "dbconnect.php";
include "head.php";

$ref_id = $_GET['ref_id'];
$customer_name = $_GET['customer_name'];
$add_date = date('Y-m-d H:i:s');
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = $_GET['add_by'];
$company = $_GET['company'];
$sup_name = "$name $surname";
 
$iv_date = date('Y-m-d');
$date = explode('-' , $iv_date );
$year = $date[0]+543;
$mont = $date[1];
$year1 = substr($year, 2 ,2);

if($_GET["iv_no"]!=''){
	
$doc_no = $_GET["iv_no"];		
	
}else{

if($company =='1'){

$sql = "SELECT MAX(run_iv) AS MAXID FROM tb_docbreng where head_no='BREG' and  month_no ='".$mont."' and year_no = '".$year1."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);

$maxId = $rs["MAXID"];	

$so = "BREG";

$maxId1 = ($maxId + 1);
$maxId2 = substr("000".$maxId1, -3);
$nextId = $maxId2;


$doc_no = $so.$year1.$mont.$nextId;	

$save5="insert into tb_docbreng (head_no,doc_no,year_no,month_no,run_iv,ref_id) values ('BREG','".$doc_no."','".$year1."','".$mont."','".$nextId."','".$ref_id."')";
$qsave5=mysqli_query($conn,$save5);
		
	}else if($company =='2'){

$sql = "SELECT MAX(run_iv) AS MAXID FROM tb_docbreng where head_no='BREGN' and  month_no ='".$mont."' and year_no = '".$year1."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);

$maxId = $rs["MAXID"];	

$so = "BREGN";

$maxId1 = ($maxId + 1);
$maxId2 = substr("000".$maxId1, -3);
$nextId = $maxId2;


$doc_no = $so.$year1.$mont.$nextId;	

$save5="insert into tb_docbreng (head_no,doc_no,year_no,month_no,run_iv,ref_id) values ('BREGN','".$doc_no."','".$year1."','".$mont."','".$nextId."','".$ref_id."')";
$qsave5=mysqli_query($conn,$save5);


	}
}


$save="Update  hos__breg set status_doc='Approve',dm_name='".$sup_name."',dm_date='".$add_date."',send_stock='1',iv_no='".$doc_no."',iv_date='".$add_date."'  where ref_id = '".$ref_id."' ";
$qsave=mysqli_query($conn,$save);
 


 
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('อนุมัติเอกสาร และส่งข้อมูลให้สต็อกเรียบร้อยแล้วค่ะ');window.location='status_dmbreg_app.php';";
echo "</script>";
  } else {
   echo "Cannot";
  }
  ?>