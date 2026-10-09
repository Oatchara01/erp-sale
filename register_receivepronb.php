<?php
// หน้าสร้างใบรับสินค้า NBM เดิม — รวมกับ AWL ที่ register_receivepro.php แล้ว (เลือกบริษัทจาก dropdown)
// คงไฟล์นี้ไว้เป็น redirect ให้ลิงก์/บุ๊กมาร์กเก่ายังใช้ได้ : company=2 = NBM
header('Location: register_receivepro.php?company=2');
exit();
