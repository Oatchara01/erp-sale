<?php
include "dbconnect.php";
include "head.php";


  $ref_id = $_GET['ref_id'];
  $rental_name = $_GET["rental_name"];
  $type_doc = $_GET["type_doc"];
  $iv_no = $_GET["iv_no"];
  $sale_code = $_SESSION['code'];
  $name =  $_SESSION['name'];
  $surname =	$_SESSION['surname'];
  $add_by = "$name $surname";
  $add_date = date('Y-m-d H:i:s');
  $doc_date = date('Y-m-d');


$date = explode('-' , $doc_date );
$year = $date[0]+543;
$mont = $date[1];
$year1 = substr($year, 2 ,2);


if($iv_no !=''){
$doc_no = $_GET["iv_no"];

}else{

if($type_doc =='3'){

$sql = "SELECT MAX(run_iv) AS MAXID FROM tb_doc_rental where head_no='JN' and  month_no ='".$mont."' and year_no = '".$year1."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);

$maxId = $rs["MAXID"];	

$so = "JN";

$maxId1 = ($maxId + 1);
$maxId2 = substr("000".$maxId1, -3);
$nextId = $maxId2;


$doc_no = $so.$year1.$mont.$nextId;	

$save5="insert into tb_doc_rental (head_no,doc_no,year_no,month_no,run_iv,ref_id,doc_date) values ('JN','".$doc_no."','".$year1."','".$mont."','".$nextId."','".$ref_id_br."','".$doc_date."')";
$qsave5=mysqli_query($conn,$save5);
		
	}else if($type_doc =='4'){

$sql = "SELECT MAX(run_iv) AS MAXID FROM tb_doc_rental where head_no='JN/' and  month_no ='".$mont."' and year_no = '".$year1."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);

$maxId = $rs["MAXID"];	

$so = "JN/";

$maxId1 = ($maxId + 1);
$maxId2 = substr("000".$maxId1, -3);
$nextId = $maxId2;


$doc_no = $so.$year1.$mont.$nextId;	

$save5="insert into tb_doc_rental (head_no,doc_no,year_no,month_no,run_iv,ref_id,doc_date) values ('JN/','".$doc_no."','".$year1."','".$mont."','".$nextId."','".$ref_id_br."','".$doc_date."')";
$qsave5=mysqli_query($conn,$save5);


	}

}


 $save="Update  hos__rental set send_admin ='1',status_doc='Approve',iv_no='".$doc_no."',iv_date='".$doc_date."',send_stock='1',send_sup='1',sup_name='".$add_by."',sup_date='".$add_date."'  where ref_id = '".$ref_id."' ";
 $qsave=mysqli_query($conn,$save);




if($qsave){
 echo "<script language=\"JavaScript\">";
echo "alert('ส่งข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_suprental_edit.php?ref_id=$ref_id';";
echo "</script>";

  }else{
   echo "Cannot";
  }
  
	

	
?>
