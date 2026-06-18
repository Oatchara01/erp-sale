


<?php
include("dbconnect.php");
include("head.php");
date_default_timezone_set("Asia/Bangkok");
if ($_GET["submit"] = "submit") {

$date_iv = $_GET["date_iv"];
$description = $_GET["description"];
//echo $date_iv;

$date = explode('-' , $_GET["date_iv"] );
$year = $date[0]+543;
$mont = $date[1];
$year1 = substr($year, 2 ,2);

$sql = "SELECT MAX(run_no) AS MAXID FROM tb_et_nbm where mount_no ='".$mont."' and year_no = '".$year1."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);

$maxId = $rs["MAXID"];

$so = "ET";
$so1 = "/";

$maxId1 = ($maxId + 1);
$maxId2 = substr("0000".$maxId1, -4);
$nextId = $maxId2;


$doc_no = $so.$year1.$so1.$mont.$nextId;
//echo $doc_no;
	//exit();
	


$save="insert into tb_et_nbm (doc_no,year_no,mount_no,run_no,description) values ('".$doc_no."','".$year1."','".$mont."','".$nextId."','".$description."')";
$qsave=mysqli_query($conn,$save);




 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='add_docno.php'";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}
?>