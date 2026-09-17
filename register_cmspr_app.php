<?php
/**
 * หน้าอนุมัติ SPR ของผู้บริหาร (ด่าน CM) — รวมเข้ากับหน้าฟอร์มที่ register_engspr.php แล้ว
 * แถบอนุมัติในหน้านั้นแสดงเมื่อเอกสารอยู่ด่าน CM และผู้ใช้มีสิทธิ์ (ดู spr_stage_roles())
 *
 * ไฟล์นี้คงไว้เป็น redirect เพื่อไม่ให้ลิงก์เดิมจาก status_appspr_cm.php และบุ๊กมาร์กเก่าพัง
 * และเพื่อไม่ให้เหลือเส้นทางเขียนสถานะสองทางที่ไม่ตรงกัน
 */
$sprRefId = isset($_GET['ref_id']) ? trim((string)$_GET['ref_id']) : '';
header('Location: register_engspr.php?ref_id=' . urlencode($sprRefId));
exit();
