


<?php
include("dbconnect.php");
include("head.php");
date_default_timezone_set("Asia/Bangkok");
if ($_GET["submit"] = "submit") {

$id_doc = $_GET["id_doc"];
$description = $_GET["description"];


$save="Update tb_doc_nbm Set description = '".$description."' where id_doc = '".$id_doc."'";
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