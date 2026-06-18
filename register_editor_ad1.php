<?php include ("head.php"); ?>


<?php
include("dbconnect.php");
include ("error_page.php"); 

date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$ref_id = $_POST["ref_id"];
$date_receive = $_POST["date_receive"];
$delivery_no = $_POST["delivery_no"];
$editor = $_POST["editor"];
$tracking = $_POST["tracking"];
$id = $_POST["id_run"];
$count = $_POST["count"];
	
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";
$em_no =  $_SESSION['emid'];
$add_date = date('Y-m-d H:i:s');




$save="UPDATE  no__complete SET date_receive='".$date_receive."',delivery_no='".$delivery_no."',editor='".$editor."',tracking='".$tracking."',editor_name='".$add_by."',date_editor ='".$add_date."' where ref_id='".$ref_id."'";


$qsave=mysqli_query($conn,$save);
	
	
foreach($id as $key =>$value)
	{
		$id_new=$id[$key];
		$count_new=$count[$key];
	
	
$strSQL = "Update no__subcomplete Set  count '".$count_new."' where id_submain  = '".$id_new."'";
$objQuery = mysqli_query($conn,$strSQL);


}
	

	
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='register_editor_ad.php?ref_id=$ref_id';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}


