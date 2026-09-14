<?php
include "dbconnect.php";
require_once __DIR__ . '/includes/breg_repo.php';

$ref_id = $_GET['ref_id'];

/* AWL (type_doc=1) ย้าย workflow ทั้งหมดไปหน้า register_bregawl.php แล้ว — endpoint GET เดิม
   ต้องไม่ mutate state ของ AWL อีกต่อไป กันลิงก์เก่า/บุ๊กมาร์กยิงซ้ำข้าม workflow ใหม่
   ต้องเช็คก่อน include head.php เพราะ head.php เริ่มพ่น HTML ทันที (header() จะใช้ไม่ได้) */
breg_redirect_if_awl_get_endpoint($conn, $ref_id);

include "head.php";

$add_date = date('Y-m-d H:i:s');
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$sup_name = "$name $surname";


$save="Update  hos__breg set status_doc='Rejected',dm_name='".$sup_name."',dm_date='".$add_date."'  where ref_id = '".$ref_id."' ";
$qsave=mysqli_query($conn,$save);
 
 
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('ทำการ Rejected เอกสาร เรียบร้อยแล้วค่ะ');window.location='status_dmbreg_app.php';";
echo "</script>";
  } else {
   echo "Cannot";
  }
  ?>