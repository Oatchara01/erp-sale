<?php include ("head.php"); ?>


<?php
include("dbconnect.php");
include ("error_page.php"); 

date_default_timezone_set("Asia/Bangkok");
if ($_GET["submit"] = "submit") {

$mont = $_GET["mont"];
$year= date("Y");
$close_date = "$year-$mont";




$save7="SELECT * FROM tb_closedoc where close_mount = '".$close_date."'";
$qsave7=mysqli_query($conn,$save7);
$Num_Rows = mysqli_num_rows($qsave7);

if($Num_Rows > 0){	

echo "<script language=\"JavaScript\">";
echo "alert('ท่านได้ปิดเอกสารในเดือนนี้เรียบร้อยแล้วค่ะ');window.location='close_opendoc.php';";
echo "</script>";

}else{	
	
$save="insert into tb_closedoc (close_mount) values ('".$close_date."')";
$qsave=mysqli_query($conn,$save);

	
$save1 = "UPDATE so__main SET close_mount = '1' where doc_release_date LIKE '%".$close_date."%'";
$qsave1 = mysqli_query($conn,$save1);

$save2 = "UPDATE hos__br SET close_mount = '1' where iv_date LIKE '%".$close_date."%'";
$qsave2 = mysqli_query($conn,$save2);
	
$save3 = "UPDATE hos__so SET close_mount = '1' where iv_date LIKE '%".$close_date."%' and have_order='1' and have_product = '2'";
$qsave3 = mysqli_query($conn,$save3);
	
$save31 = "UPDATE hos__so SET close_mount = '1' where iv_date LIKE '%".$close_date."%' and have_order='0' ";
$qsave31 = mysqli_query($conn,$save31);

$save4 = "UPDATE hos__smp SET close_mount = '1' where smp_date LIKE '%".$close_date."%'";
$qsave4 = mysqli_query($conn,$save4);
	
$save5 = "UPDATE hos__receive SET close_mount = '1' where date_receive  LIKE '%".$close_date."%'";
$qsave5 = mysqli_query($conn,$save5);


$save6 = "UPDATE tb_credit_note SET close_mount = '1' where date_credit  LIKE '%".$close_date."%'";
$qsave6 = mysqli_query($conn,$save6);

}


	
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='close_opendoc.php';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}


