<?php
include "dbconnect.php";
require_once __DIR__ . '/includes/breg_repo.php';

$ref_id = $_GET['ref_id'];

/* AWL (type_doc=1) ย้าย workflow ทั้งหมดไปหน้า register_bregawl.php แล้ว — endpoint GET เดิม
   ต้องไม่ mutate state ของ AWL อีกต่อไป กันลิงก์เก่า/บุ๊กมาร์กยิงซ้ำข้าม workflow ใหม่
   ต้องเช็คก่อน include head.php เพราะ head.php เริ่มพ่น HTML ทันที (header() จะใช้ไม่ได้) */
breg_redirect_if_awl_get_endpoint($conn, $ref_id);

include "head.php";

$name =  $_SESSION['name'];
$add_date = date('Y-m-d H:i:s');
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";

/* เอกสารที่ยังเป็นร่าง (Draft) ส่งอนุมัติไม่ได้ — ต้อง Submit ที่หน้าฟอร์มก่อน
   ตรวจที่ endpoint ไม่ใช่แค่ซ่อนปุ่ม เพราะลิงก์นี้ยิงตรงด้วย GET ได้ */
$ckk_draft = mysqli_query($conn, "SELECT status_doc FROM hos__breg WHERE ref_id = '".mysqli_real_escape_string($conn,$ref_id)."' LIMIT 1");
$rs_draft = $ckk_draft ? mysqli_fetch_assoc($ckk_draft) : null;
if (!$rs_draft || $rs_draft['status_doc'] === 'Draft') {
	echo "<script language=\"JavaScript\">";
	echo "alert('เอกสารนี้ยังเป็นร่าง (Draft) กรุณากด Submit ที่หน้าฟอร์มก่อนจึงจะส่งอนุมัติได้');window.location='status_engbreg.php';";
	echo "</script>";
	exit();
}

$save="Update  hos__breg set send_sup ='1',status_doc='Request',send_supname='".$add_by."',send_supdate='".$add_date."'  where ref_id = '".$ref_id."' and status_doc <> 'Draft' ";
$qsave=mysqli_query($conn,$save);
 
 
 if($qsave){
   echo "<script language=\"JavaScript\">";
echo "alert('ส่งข้อมูลให้ Sup เรียบร้อยแล้วค่ะ');window.location='register_breg_edit.php?ref_id=$ref_id';";
echo "</script>";
  } else {
   echo "Cannot";
  }
  ?>