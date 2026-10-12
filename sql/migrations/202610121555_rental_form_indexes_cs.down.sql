-- @connection: cs
-- ถอย index ของ rental_form_indexes_cs — ลบเฉพาะ index ชื่อที่ up สร้าง (ไม่แตะข้อมูล)
-- ถ้าฐานมี index ชื่อเดียวกันนี้อยู่ก่อนรัน up (up จึงข้ามไป) down จะลบตัวนั้นด้วย

-- ฐานนี้ไม่ได้ปิด strict mode และตารางมี default วันที่แบบ 0000-00-00 ที่ทำให้ ALTER พัง (Invalid default value)
-- ปิดเฉพาะ session นี้ แล้วคืนค่าเดิมท้ายไฟล์
SET @ri_mode = @@SESSION.sql_mode;
SET SESSION sql_mode = '';

SET @s = (SELECT IF(COUNT(*) > 0, 'ALTER TABLE tb_register_data DROP INDEX idx_running', 'SELECT 1')
          FROM information_schema.statistics
          WHERE table_schema = DATABASE() AND table_name = 'tb_register_data' AND index_name = 'idx_running');
PREPARE st FROM @s; EXECUTE st; DEALLOCATE PREPARE st;

SET SESSION sql_mode = @ri_mode;
