-- @connection: acc
-- index สำหรับ query ที่ค้นด้วยเลขอ้างอิงตอนเปิดใบสั่งเช่า (register_suprental.php?ref_id=...) — ฐานบัญชี ($code)
--
-- คอลัมน์นี้ไม่มี index ทำให้ query สแกนทั้งตาราง (224 ms ต่อครั้งบนข้อมูล local เหลือราว 1 ms หลังเพิ่ม)
-- รันซ้ำได้ — ข้ามถ้ามี index ขึ้นต้นด้วยคอลัมน์นั้นอยู่แล้ว ไม่ว่าชื่ออะไร
-- เพิ่ม index อย่างเดียว ไม่แก้ข้อมูลและไม่ผูกกับ deploy โค้ด

-- ฐานนี้ไม่ได้ปิด strict mode และตารางมี default วันที่แบบ 0000-00-00 ที่ทำให้ ALTER พัง (Invalid default value)
-- ปิดเฉพาะ session นี้ แล้วคืนค่าเดิมท้ายไฟล์
SET @ri_mode = @@SESSION.sql_mode;
SET SESSION sql_mode = '';

-- register_suprental.php:2271, 2356, 2396 — สถานะรับชำระล่าสุด (WHERE ref_id ... ORDER BY id_off DESC LIMIT 1)
SET @s = (SELECT IF(COUNT(*) = 0, 'ALTER TABLE tb_register_data ADD INDEX idx_ref_id (ref_id, id_off)', 'SELECT 1')
          FROM information_schema.statistics
          WHERE table_schema = DATABASE() AND table_name = 'tb_register_data' AND column_name = 'ref_id' AND seq_in_index = 1);
PREPARE st FROM @s; EXECUTE st; DEALLOCATE PREPARE st;

SET SESSION sql_mode = @ri_mode;
