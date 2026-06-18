

<?php
include("dbconnect.php");

date_default_timezone_set("Asia/Bangkok");

$ref_id=$_POST["ref_id"];
$score_ckk=$_POST["score_ckk"];
$comment_ckk2=$_POST["comment_ckk2"];

$save="UPDATE  st__signature SET score_ckk='".$score_ckk."',comment_ckk='".$comment_ckk2."',reserch_ckk='1'    where ref_id = '".$ref_id."'";
$qsave=mysqli_query($new,$save);

echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_reserch_receive.php';";
echo "</script>";

?>