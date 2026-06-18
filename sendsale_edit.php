<?php include ("head.php"); ?>
<?php
include "dbconnect.php";

$name = $_SESSION["name"];

  $ref_id = $_GET['ref_id'];
   $save="Update  qou__main set send_sup ='0',status_doc=''  where ref_id = '".$ref_id."' ";

$qsave=mysqli_query($conn,$save);
 	
		


 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_appqou.php';";
echo "</script>";
  } else {
   echo "Cannot";
  }

?>