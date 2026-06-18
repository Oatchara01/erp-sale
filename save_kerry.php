<?php include ("head.php"); ?>


<?php
include("dbconnect.php");
include ("error_page.php"); 

date_default_timezone_set("Asia/Bangkok");
if ($_GET["submit"] = "submit") {



$start_date = $_GET["start_date"];
$ref_id = $_GET["ref_id"];
$str_arr = $_GET["str_arr"];
$id = $_GET["id"];
$test = substr($ref_id,0,2);

if($id!=''){
$save = "Update tb_deloth set cb_send='1'  where  id ='".$id."'";
$qsave=mysqli_query($conn,$save);	
}else{	

if($test=='SO' or $test=='BR' or $test=='SM'){
$save = "Update tb_register_data set cb_send='1'  where  ref_id ='".$ref_id."'";
$qsave=mysqli_query($conn,$save);
	
}else {
	
$save = "Update so__main set cb_send='1'  where  ref_id ='".$ref_id."'";
$qsave=mysqli_query($conn,$save);
}
}
	
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='report_kerrysol.php?start_date=$start_date&company=$str_arr';";
echo "</script>";
  } else {
   echo "Cannot";
  }
}
	


?>