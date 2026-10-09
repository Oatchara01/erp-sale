<?php
// หน้าแก้ไขใบรับสินค้าเดิม — ย้ายไปรวมกับหน้าสร้างที่ register_receivepro.php แล้ว
// คงไฟล์นี้ไว้เป็น redirect ให้ลิงก์/บุ๊กมาร์กเก่ายังเปิดเอกสารได้
$rpNo = isset($_GET['rp_no']) && !is_array($_GET['rp_no']) ? trim((string)$_GET['rp_no']) : '';
header('Location: ' . ($rpNo !== '' ? 'register_receivepro.php?rp_no=' . rawurlencode($rpNo) : 'status_receivepro_adm.php'));
exit();
