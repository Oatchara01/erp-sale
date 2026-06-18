<?php
include "dbconnect.php";
 include('head.php'); 
date_default_timezone_set("Asia/Bangkok");

  $ref_idsmp = $_GET['ref_idsmp'];
  $type_company = $_GET['type_company'];
  $sup_date = date('Y-m-d');
  $sup_name = $_SESSION['name'];
  $name = $_SESSION['name'];
  $surname = $_SESSION['surname'];



if($type_company =='1'){
	
$yearMonth = substr(date("Y")+543, -2).date("m");
$sql = "SELECT MAX(doc_no) AS MAXID FROM tb_docsmp_ptl";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
$maxId = substr($rs['MAXID'], -4);
$maxId3 = substr($rs['MAXID'],-8);

$maxId1 = substr($maxId3,0,-4);
$so = "SMP";
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

$doc_no = "$so$nextId";

$save5="insert into tb_docsmp_ptl (doc_no) values ('".$doc_no."')";
$qsave5=mysqli_query($conn,$save5);
		
	}else if($type_company =='2'){
		

$yearMonth = substr(date("Y")+543, -2).date("m");
$sql = "SELECT MAX(doc_no) AS MAXID FROM tb_docsmp_nbm";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
$maxId = substr($rs['MAXID'], -4);
$maxId3 = substr($rs['MAXID'],-8);

$maxId1 = substr($maxId3,0,-4);
$so = "SMPNB";

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


$doc_no = "$so$nextId";		
		
$save5="insert into tb_docsmp_nbm (doc_no,year_no,run_id) values ('".$doc_no."','".$year1."','".$maxId1."')";
$qsave5=mysqli_query($conn,$save5);
		
	}


$doc_date = date('Y-m-d H:i:s');
$admin_name = "$name $surname";	



$save="Update  hos__smp set status_sup ='Approve',send_stock = '1',send_sup = '1' ,send_admin = '1' ,sup_name='".$sup_name."',sup_date='".$sup_date."',smp_no='".$doc_no."',doc_date='".$doc_date."',admin_name ='".$admin_name."'  where ref_idsmp = '".$ref_idsmp."' ";
$qsave=mysqli_query($conn,$save);
	
$save17="Update  hos__subsmp set status_smp ='Approve'  where reff_idsmp = '".$ref_idsmp."' ";
$qsave17=mysqli_query($conn,$save17);	
	
	
	


 
if($qsave) {
	
 echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_chang426_edit.php?ref_idsmp=$ref_idsmp';";
echo "</script>";

  }else{
   echo "Cannot";
  }
	

	
?>
