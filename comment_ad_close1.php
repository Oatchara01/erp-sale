
<?php
include("dbconnect.php");
include("dbconnect_acc.php");	
include("dbconnect_cs.php");
include("head.php");

date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$ref_id = trim($_POST["ref_id"]);
$complete_adckk = $_POST["complete_adckk"];	
$cls_desad = $_POST["cls_desad"];	
$add_date = date('Y-m-d H:i:s');	
$surname =	$_SESSION['surname'];
$name =	$_SESSION['name'];
$add_by = "$name $surname";
	
	
$save="Update tb_comment_so  SET complete_adckk='2',name_ad='".$add_by."',date_ad='".$add_date."',cls_desad='".$cls_desad."' where  ref_id ='".$ref_id."'";
$qsave=mysqli_query($conn,$save);	
	

	
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_admkangcom.php';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}


