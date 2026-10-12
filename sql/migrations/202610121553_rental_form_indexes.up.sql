-- index สำหรับ query ที่ค้นด้วยเลขอ้างอิงตอนเปิดใบสั่งเช่า (register_suprental.php?ref_id=...)
--
-- คอลัมน์เหล่านี้ไม่มี index ทำให้ทุก query สแกนทั้งตาราง (12–63 ms ต่อครั้งบนข้อมูล local เหลือราว 1 ms หลังเพิ่ม)
-- รันซ้ำได้ — ข้ามตารางที่มี index ขึ้นต้นด้วยคอลัมน์นั้นอยู่แล้ว ไม่ว่าชื่ออะไร
-- เพิ่ม index อย่างเดียว ไม่แก้ข้อมูลและไม่ผูกกับ deploy โค้ด
-- ฐานบัญชีและฐาน CS อยู่ใน migration ถัดไป: rental_form_indexes_acc / rental_form_indexes_cs

-- register_suprental.php:659 — ข้อมูลลงทะเบียนของเอกสาร
SET @s = (SELECT IF(COUNT(*) = 0, 'ALTER TABLE tb_register_data ADD INDEX idx_ref_id (ref_id)', 'SELECT 1')
          FROM information_schema.statistics
          WHERE table_schema = DATABASE() AND table_name = 'tb_register_data' AND column_name = 'ref_id' AND seq_in_index = 1);
PREPARE st FROM @s; EXECUTE st; DEALLOCATE PREPARE st;

-- register_suprental.php:664 — ข้อมูลการชำระเงินของเอกสาร
SET @s = (SELECT IF(COUNT(*) = 0, 'ALTER TABLE tb_transaction ADD INDEX idx_ref_id (ref_id)', 'SELECT 1')
          FROM information_schema.statistics
          WHERE table_schema = DATABASE() AND table_name = 'tb_transaction' AND column_name = 'ref_id' AND seq_in_index = 1);
PREPARE st FROM @s; EXECUTE st; DEALLOCATE PREPARE st;

-- register_suprental.php:2258, 2339, 2379 — ยอดรวมของ SO เงินประกัน/งวดชำระ
SET @s = (SELECT IF(COUNT(*) = 0, 'ALTER TABLE hos__subso ADD INDEX idx_ref_idd (ref_idd)', 'SELECT 1')
          FROM information_schema.statistics
          WHERE table_schema = DATABASE() AND table_name = 'hos__subso' AND column_name = 'ref_idd' AND seq_in_index = 1);
PREPARE st FROM @s; EXECUTE st; DEALLOCATE PREPARE st;

-- register_suprental.php:2523 — ใบคืนสินค้าของใบเช่า
SET @s = (SELECT IF(COUNT(*) = 0, 'ALTER TABLE hos__receive ADD INDEX idx_ref_id (ref_id)', 'SELECT 1')
          FROM information_schema.statistics
          WHERE table_schema = DATABASE() AND table_name = 'hos__receive' AND column_name = 'ref_id' AND seq_in_index = 1);
PREPARE st FROM @s; EXECUTE st; DEALLOCATE PREPARE st;

-- register_suprental.php:639 — หัวใบสั่งเช่า
SET @s = (SELECT IF(COUNT(*) = 0, 'ALTER TABLE hos__rental ADD INDEX idx_ref_id (ref_id)', 'SELECT 1')
          FROM information_schema.statistics
          WHERE table_schema = DATABASE() AND table_name = 'hos__rental' AND column_name = 'ref_id' AND seq_in_index = 1);
PREPARE st FROM @s; EXECUTE st; DEALLOCATE PREPARE st;

-- register_suprental.php:681, status_suprental.php:725 — รายการสินค้าของใบเช่า
SET @s = (SELECT IF(COUNT(*) = 0, 'ALTER TABLE hos__subrental ADD INDEX idx_ref_idd (ref_idd)', 'SELECT 1')
          FROM information_schema.statistics
          WHERE table_schema = DATABASE() AND table_name = 'hos__subrental' AND column_name = 'ref_idd' AND seq_in_index = 1);
PREPARE st FROM @s; EXECUTE st; DEALLOCATE PREPARE st;

-- register_suprental.php:2327, status_suprental.php:576 — งวดต่อสัญญา/สถานะปิดการเช่า
SET @s = (SELECT IF(COUNT(*) = 0, 'ALTER TABLE hos__rental_runiv ADD INDEX idx_ref_idren (ref_idren)', 'SELECT 1')
          FROM information_schema.statistics
          WHERE table_schema = DATABASE() AND table_name = 'hos__rental_runiv' AND column_name = 'ref_idren' AND seq_in_index = 1);
PREPARE st FROM @s; EXECUTE st; DEALLOCATE PREPARE st;
