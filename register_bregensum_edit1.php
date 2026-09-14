<?php include ("head.php"); ?>


<?php
include("dbconnect.php");
include ("error_page.php"); 

date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$ref_id =  $_POST["ref_id"];
$pro_come = ($_POST["pro_come"] ?? '') === '1' ? '1' : '0';
$pro_comedate = trim((string)($_POST["pro_comedate"] ?? ''));
$brdoc_eng = ($_POST["brdoc_eng"] ?? '') === '1' ? '1' : '0';
$name_eng = trim((string)($_POST["name_eng"] ?? ''));
$date_brdoc = trim((string)($_POST["date_brdoc"] ?? ''));

/* เดิมบรรทัดนี้เขียน name_eng ทับด้วยชื่อผู้ล็อกอิน และ date_brdoc ทับด้วยเวลาปัจจุบัน
   ทำให้ค่าที่ผู้ใช้เลือกในฟอร์ม (ช่างประกอบ / วันที่ประกอบ) หายทุกครั้งที่บันทึก
   ตอนนี้เก็บค่าที่เลือกจริง — คอลัมน์เป็น NOT NULL ไม่รับ NULL จึงใช้ค่าศูนย์แทนค่าว่าง */
$pro_comedate_sql = ($pro_comedate === '') ? '0000-00-00' : $pro_comedate;
$date_brdoc_sql = ($date_brdoc === '') ? '0000-00-00 00:00:00' : ($date_brdoc . ' 00:00:00');

$save = "UPDATE hos__breg SET
			brdoc_eng = '".mysqli_real_escape_string($conn,$brdoc_eng)."',
			name_eng = '".mysqli_real_escape_string($conn,$name_eng)."',
			date_brdoc = '".mysqli_real_escape_string($conn,$date_brdoc_sql)."',
			pro_come = '".mysqli_real_escape_string($conn,$pro_come)."',
			pro_comedate = '".mysqli_real_escape_string($conn,$pro_comedate_sql)."'
		WHERE ref_id = '".mysqli_real_escape_string($conn,$ref_id)."'";
$qsave=mysqli_query($conn,$save);

	
if($save){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_engbregkang.php';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	}


