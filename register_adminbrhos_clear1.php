
<?php
include("dbconnect.php");
include ("error_page.php"); 
include("head.php");

date_default_timezone_set("Asia/Bangkok");
if ($_GET["submit"] = "submit") {

$ref_id_br = trim($_GET["ref_id_br"]);


$save="Update  hos__br set close_br ='1'  where ref_id_br='".$ref_id_br."'";



$qsave=mysqli_query($conn,$save);
	



	
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_clearbr_adm.php';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}


