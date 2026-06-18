<?php
include("head.php");
include "dbconnect.php";


$ref_id_br = $_GET['ref_id_br'];
$sale_code = $_GET['sale_code'];
$company = $_GET["company"];
$iv_no = $_GET["iv_no"];
$type_breng = $_GET["type_breng"];
$approve_time = date("H:i:s");
$iv_time = date("H:i:s"); 
$approve_date = date("Y-m-d");
$iv_date = date("Y-m-d");
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";
$admin =  $_SESSION['name'];
$admin_code =  $_SESSION['code'];
$admin_date= date('Y-m-d H:i:s');

$date = explode('-' , $iv_date );
$year = $date[0]+543;
$mont = $date[1];
$year1 = substr($year, 2 ,2);

if($iv_no!=''){

$doc_no = $_GET["iv_no"];	
	
}else{

if($type_breng=='1'){
	if($company =='1'){

$sql = "SELECT MAX(run_iv) AS MAXID FROM tb_docbreng where head_no='BRES' and  month_no ='".$mont."' and year_no = '".$year1."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);

$maxId = $rs["MAXID"];	

$so = "BRES";

$maxId1 = ($maxId + 1);
$maxId2 = substr("000".$maxId1, -3);
$nextId = $maxId2;


$doc_no = $so.$year1.$mont.$nextId;	

$save5="insert into tb_docbreng (head_no,doc_no,year_no,month_no,run_iv,ref_id) values ('BRES','".$doc_no."','".$year1."','".$mont."','".$nextId."','".$ref_id_br."')";
$qsave5=mysqli_query($conn,$save5);
		
	}else if($company =='2'){

$sql = "SELECT MAX(run_iv) AS MAXID FROM tb_docbreng where head_no='BRESN' and  month_no ='".$mont."' and year_no = '".$year1."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);

$maxId = $rs["MAXID"];	

$so = "BRESN";

$maxId1 = ($maxId + 1);
$maxId2 = substr("000".$maxId1, -3);
$nextId = $maxId2;


$doc_no = $so.$year1.$mont.$nextId;	

$save5="insert into tb_docbreng (head_no,doc_no,year_no,month_no,run_iv,ref_id) values ('BRESN','".$doc_no."','".$year1."','".$mont."','".$nextId."','".$ref_id_br."')";
$qsave5=mysqli_query($conn,$save5);


	}
}else if($type_breng=='2'){


if($company =='1'){

$sql = "SELECT MAX(run_iv) AS MAXID FROM tb_docbreng where head_no='BREQ' and  month_no ='".$mont."' and year_no = '".$year1."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);

$maxId = $rs["MAXID"];	

$so = "BREQ";

$maxId1 = ($maxId + 1);
$maxId2 = substr("000".$maxId1, -3);
$nextId = $maxId2;


$doc_no = $so.$year1.$mont.$nextId;	

$save5="insert into tb_docbreng (head_no,doc_no,year_no,month_no,run_iv,ref_id) values ('BREQ','".$doc_no."','".$year1."','".$mont."','".$nextId."','".$ref_id_br."')";
$qsave5=mysqli_query($conn,$save5);



}else if($company =='2'){


$sql = "SELECT MAX(run_iv) AS MAXID FROM tb_docbreng where head_no='BREQN' and  month_no ='".$mont."' and year_no = '".$year1."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);

$maxId = $rs["MAXID"];	

$so = "BREQN";

$maxId1 = ($maxId + 1);
$maxId2 = substr("000".$maxId1, -3);
$nextId = $maxId2;


$doc_no = $so.$year1.$mont.$nextId;	

$save5="insert into tb_docbreng (head_no,doc_no,year_no,month_no,run_iv,ref_id) values ('BREQN','".$doc_no."','".$year1."','".$mont."','".$nextId."','".$ref_id_br."')";
$qsave5=mysqli_query($conn,$save5);


	}
}
}

 $save="Update  hos__br set send_admin ='1',approve_time='".$approve_time."',approve_date='".$approve_date."',status_doc='Approve', admin = '".$admin."',admin_code = '".$admin_code."',admin_date = '".$admin_date."',iv_no='".$doc_no."',iv_date='".$iv_date."',iv_time='".$iv_time."'  where ref_id_br = '".$ref_id_br."' ";

$qsave=mysqli_query($conn,$save);
 
 
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_supbreng_edit.php?ref_id_br=$ref_id_br';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	
	

	
?>
