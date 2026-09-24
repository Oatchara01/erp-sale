-- ใบ PO (hos__po) — สถานะเอกสารสำหรับ Draft / Submitted และด่านกันเลขซ้ำ
-- ใช้โดย register_poawl.php / register_posave1.php ผ่าน includes/po_repo.php
--
-- รันซ้ำได้ (idempotent) — ทุกคำสั่งเช็ค information_schema ก่อนแก้ตาราง
--
-- status_doc
--   'Draft'     = บันทึกร่าง ยังไม่ส่ง Sale (send_sale = 0 เสมอ) ห้ามไหลเข้า Sale/SO
--   'Submitted' = ใบ PO จริง — DEFAULT ของคอลัมน์ ทำให้
--                 1) แถวเดิมทั้งหมด backfill เป็น Submitted อัตโนมัติ
--                 2) ตัวบันทึกเดิมที่ไม่รู้จักคอลัมน์นี้ (register_poadmin_edit1.php ฯลฯ) ยังได้ค่าเดิม
--   ไม่ใช้ send_sale แทนสถานะ Draft เพราะมีใบเดิมที่ send_sale = 0 แต่เป็นใบจริง (รอกดส่ง Sale)

SET @po_has_status_doc := (
	SELECT COUNT(*) FROM information_schema.COLUMNS
	WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'hos__po' AND COLUMN_NAME = 'status_doc'
);
SET @po_sql := IF(@po_has_status_doc = 0,
	'ALTER TABLE hos__po ADD COLUMN status_doc VARCHAR(20) NOT NULL DEFAULT ''Submitted'' AFTER ref_id',
	'SELECT ''status_doc already exists''');
PREPARE po_stmt FROM @po_sql;
EXECUTE po_stmt;
DEALLOCATE PREPARE po_stmt;

-- กันเลข PO ชนกันเมื่อมีคนกดบันทึกพร้อมกัน (po_reserve_ref_id() พึ่ง unique key ตัวนี้
-- เป็นด่านสุดท้าย: ถ้า INSERT ชนก็วนหาเลขถัดไป แทนที่จะเกิดเอกสารเลขเดียวกันสองใบ)
--
-- ถ้ามี ref_id ซ้ำค้างอยู่ ALTER นี้จะ error — ตรวจก่อนด้วย
--   SELECT ref_id, COUNT(*) c FROM hos__po GROUP BY ref_id HAVING c > 1;
SET @po_has_uk := (
	SELECT COUNT(*) FROM information_schema.STATISTICS
	WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'hos__po' AND INDEX_NAME = 'uk_po_ref_id'
);
SET @po_sql := IF(@po_has_uk = 0,
	'ALTER TABLE hos__po ADD UNIQUE KEY uk_po_ref_id (ref_id)',
	'SELECT ''uk_po_ref_id already exists''');
PREPARE po_stmt FROM @po_sql;
EXECUTE po_stmt;
DEALLOCATE PREPARE po_stmt;

-- หน้า status/รายการกรองตามสถานะ
SET @po_has_status_idx := (
	SELECT COUNT(*) FROM information_schema.STATISTICS
	WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'hos__po' AND INDEX_NAME = 'idx_po_status_doc'
);
SET @po_sql := IF(@po_has_status_idx = 0,
	'ALTER TABLE hos__po ADD KEY idx_po_status_doc (status_doc)',
	'SELECT ''idx_po_status_doc already exists''');
PREPARE po_stmt FROM @po_sql;
EXECUTE po_stmt;
DEALLOCATE PREPARE po_stmt;

-- รายการสินค้าถูกอ่าน/ลบ-เขียนใหม่ตาม ref_idd ทุกครั้งที่บันทึก — เดิมไม่มี index เลย
SET @po_has_sub_idx := (
	SELECT COUNT(*) FROM information_schema.STATISTICS
	WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'hos__subpo' AND INDEX_NAME = 'idx_subpo_ref_idd'
);
SET @po_sql := IF(@po_has_sub_idx = 0,
	'ALTER TABLE hos__subpo ADD KEY idx_subpo_ref_idd (ref_idd)',
	'SELECT ''idx_subpo_ref_idd already exists''');
PREPARE po_stmt FROM @po_sql;
EXECUTE po_stmt;
DEALLOCATE PREPARE po_stmt;
