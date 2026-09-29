-- ช่องทางการขาย (tb_salechannel) — ธงลบแบบ soft delete
--
-- รันซ้ำได้ (idempotent) — เช็ค information_schema ก่อนแก้ตาราง
--
-- delete_ckk
--   0 = ยังไม่ถูกลบ (DEFAULT — แถวเดิมทั้งหมด backfill เป็น 0 อัตโนมัติ)
--   1 = ถูกลบแล้ว ไม่ต้องแสดงในรายการ/dropdown แต่ยังเก็บแถวไว้
--       เพราะเอกสารเก่า (so__main, hos__so ฯลฯ) ยังอ้าง salechannel_ID อยู่
--   ใช้ชื่อเดียวกับ delete_ckk ของ hos__subso_ref / hos__subbr_ref ฯลฯ

SET @sc_has_delete_ckk := (
	SELECT COUNT(*) FROM information_schema.COLUMNS
	WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'tb_salechannel' AND COLUMN_NAME = 'delete_ckk'
);
SET @sc_sql := IF(@sc_has_delete_ckk = 0,
	'ALTER TABLE tb_salechannel ADD COLUMN delete_ckk TINYINT(1) NOT NULL DEFAULT 0 AFTER ckk',
	'SELECT ''delete_ckk already exists''');
PREPARE sc_stmt FROM @sc_sql;
EXECUTE sc_stmt;
DEALLOCATE PREPARE sc_stmt;
