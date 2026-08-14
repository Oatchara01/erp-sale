<?php
// หน้าเก่า (w3.css) ถูกแทนที่ด้วย register_supbrcshos.php ซึ่งรองรับ view/edit mode ในตัวแล้ว
// (ดู plan "เพิ่ม view/edit mode ให้ register_supbrcshos.php") — เก็บไฟล์นี้ไว้เป็น redirect stub
// กันลิงก์/bookmark เก่าที่ยังค้างอยู่เจอหน้าเปล่าหรือ error แทนที่จะพาไปหน้าใหม่
$refId = $_GET['ref_id'] ?? '';
header('Location: register_supbrcshos.php?ref_id=' . rawurlencode($refId));
exit();
