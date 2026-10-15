-- index สำหรับหน้ารายการใบสั่งเช่า status_suprental.php — user ที่จำกัดสิทธิ์ด้วย sale_code เรียง id DESC
--
-- รันซ้ำได้ — ข้ามถ้ามี index ที่ขึ้นต้นด้วย sale_code อยู่แล้วไม่ว่าชื่ออะไร
-- เพิ่ม index อย่างเดียว ไม่แก้ข้อมูลและไม่ผูกกับ deploy โค้ด

SET @s = (SELECT IF(COUNT(*) = 0, 'ALTER TABLE hos__rental ADD INDEX idx_sale_code_id (sale_code, id)', 'SELECT 1')
          FROM information_schema.statistics
          WHERE table_schema = DATABASE() AND table_name = 'hos__rental' AND column_name = 'sale_code' AND seq_in_index = 1);
PREPARE st FROM @s; EXECUTE st; DEALLOCATE PREPARE st;
