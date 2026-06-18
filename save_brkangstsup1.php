<?php


include("dbconnect.php");
include ("error_page.php"); 
include("head.php");



date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

	
	

$id = $_POST["id"];
$have_ckk = $_POST["have_ckk"];
$des_sale = $_POST["des_sale"];
$ref_id = $_POST["ref_id"];


$month =	date("m");
$yearto = date("Y")+543;
$yearsave = date("Y");
$today_save = "$yearsave-$month";


foreach($id as $key =>$value)
	{
		$id_new=$id[$key];
		$have_ckk_new=$have_ckk[$key];
		$des_sale_new=$des_sale[$key];
		

$strSQL = "UPDATE st__checkbr SET have_ckk='".$have_ckk_new."',des_sale='".$des_sale_new."'  where id ='".$id_new."'";
$objQuery = mysqli_query($conn,$strSQL);	

}


 if($objQuery){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='report_brkangbysupshow.php?ref_id=$ref_id';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}

