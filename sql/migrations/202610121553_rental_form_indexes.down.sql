-- ถอย index ของ rental_form_indexes — ลบเฉพาะ index ชื่อที่ up สร้าง (ไม่แตะข้อมูล)
-- ถ้าฐานมี index ชื่อเดียวกันนี้อยู่ก่อนรัน up (up จึงข้ามไป) down จะลบตัวนั้นด้วย

SET @s = (SELECT IF(COUNT(*) > 0, 'ALTER TABLE tb_register_data DROP INDEX idx_ref_id', 'SELECT 1')
          FROM information_schema.statistics
          WHERE table_schema = DATABASE() AND table_name = 'tb_register_data' AND index_name = 'idx_ref_id');
PREPARE st FROM @s; EXECUTE st; DEALLOCATE PREPARE st;

SET @s = (SELECT IF(COUNT(*) > 0, 'ALTER TABLE tb_transaction DROP INDEX idx_ref_id', 'SELECT 1')
          FROM information_schema.statistics
          WHERE table_schema = DATABASE() AND table_name = 'tb_transaction' AND index_name = 'idx_ref_id');
PREPARE st FROM @s; EXECUTE st; DEALLOCATE PREPARE st;

SET @s = (SELECT IF(COUNT(*) > 0, 'ALTER TABLE hos__subso DROP INDEX idx_ref_idd', 'SELECT 1')
          FROM information_schema.statistics
          WHERE table_schema = DATABASE() AND table_name = 'hos__subso' AND index_name = 'idx_ref_idd');
PREPARE st FROM @s; EXECUTE st; DEALLOCATE PREPARE st;

SET @s = (SELECT IF(COUNT(*) > 0, 'ALTER TABLE hos__receive DROP INDEX idx_ref_id', 'SELECT 1')
          FROM information_schema.statistics
          WHERE table_schema = DATABASE() AND table_name = 'hos__receive' AND index_name = 'idx_ref_id');
PREPARE st FROM @s; EXECUTE st; DEALLOCATE PREPARE st;

SET @s = (SELECT IF(COUNT(*) > 0, 'ALTER TABLE hos__rental DROP INDEX idx_ref_id', 'SELECT 1')
          FROM information_schema.statistics
          WHERE table_schema = DATABASE() AND table_name = 'hos__rental' AND index_name = 'idx_ref_id');
PREPARE st FROM @s; EXECUTE st; DEALLOCATE PREPARE st;

SET @s = (SELECT IF(COUNT(*) > 0, 'ALTER TABLE hos__subrental DROP INDEX idx_ref_idd', 'SELECT 1')
          FROM information_schema.statistics
          WHERE table_schema = DATABASE() AND table_name = 'hos__subrental' AND index_name = 'idx_ref_idd');
PREPARE st FROM @s; EXECUTE st; DEALLOCATE PREPARE st;

SET @s = (SELECT IF(COUNT(*) > 0, 'ALTER TABLE hos__rental_runiv DROP INDEX idx_ref_idren', 'SELECT 1')
          FROM information_schema.statistics
          WHERE table_schema = DATABASE() AND table_name = 'hos__rental_runiv' AND index_name = 'idx_ref_idren');
PREPARE st FROM @s; EXECUTE st; DEALLOCATE PREPARE st;
