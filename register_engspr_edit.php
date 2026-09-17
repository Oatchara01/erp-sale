<?php
/**
 * หน้าแก้ไข SPR เดิม — รวมเข้ากับหน้าสร้างที่ register_engspr.php แล้ว (UI/behavior
 * ชุดเดียวกันทั้งสร้างและแก้ไข ตามข้อกำหนดข้อ 2 ของ handoff) ไฟล์นี้คงไว้เป็น redirect
 * เพื่อไม่ให้ลิงก์/บุ๊กมาร์กเก่า (status_spr.php, status_spr_no.php ฯลฯ) ที่ชี้มาที่นี่พัง
 */
$sprRefId = isset($_GET['ref_id']) ? trim((string)$_GET['ref_id']) : '';
$sprQuery = 'ref_id=' . urlencode($sprRefId);
if (isset($_GET['saved'])) {
	$sprQuery .= '&saved=' . urlencode((string)$_GET['saved']);
}
header('Location: register_engspr.php?' . $sprQuery);
exit();
