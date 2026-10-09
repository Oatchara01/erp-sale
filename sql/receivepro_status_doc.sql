-- ใบส่งสินค้า / ใบรับสินค้า (hos__proreceive, hos__subproreceive)
-- ใช้โดย register_receivepro.php / register_receivepro1.php ผ่าน includes/receivepro_repo.php
--
-- รันซ้ำได้ (idempotent) — ทุกคำสั่งเช็ค information_schema ก่อนแก้ตาราง
--
-- hos__proreceive.status_doc
--   'Draft'     = บันทึกร่าง ยังแก้ได้ทุกช่อง ยังพิมพ์/ส่งรับจ่าย/ยกเลิกไม่ได้
--   'Submitted' = เอกสารจริง — DEFAULT ของคอลัมน์ ทำให้
--                 1) แถวเดิมทั้งหมด backfill เป็น Submitted อัตโนมัติ
--                 2) ตัวบันทึกที่ไม่รู้จักคอลัมน์นี้ (register_receivepro_so1.php) ยังได้เอกสารจริงเหมือนเดิม
-- hos__proreceive.remark_cancel = เหตุผลการยกเลิก (cancel_ckk = 1) ประวัติเต็มอยู่ที่ tb_document_status_log
-- hos__subproreceive.sort_no    = ลำดับแถวสินค้าที่ผู้ใช้ลากเรียง — แถวเดิมเป็น 0 ทั้งหมด จึงเรียงตาม id ต่อเหมือนเดิม

SET @rp_has_status_doc := (
	SELECT COUNT(*) FROM information_schema.COLUMNS
	WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'hos__proreceive' AND COLUMN_NAME = 'status_doc'
);
SET @rp_sql := IF(@rp_has_status_doc = 0,
	'ALTER TABLE hos__proreceive ADD COLUMN status_doc VARCHAR(20) NOT NULL DEFAULT ''Submitted'' AFTER rp_no',
	'SELECT ''status_doc already exists''');
PREPARE rp_stmt FROM @rp_sql;
EXECUTE rp_stmt;
DEALLOCATE PREPARE rp_stmt;

SET @rp_has_remark_cancel := (
	SELECT COUNT(*) FROM information_schema.COLUMNS
	WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'hos__proreceive' AND COLUMN_NAME = 'remark_cancel'
);
SET @rp_sql := IF(@rp_has_remark_cancel = 0,
	'ALTER TABLE hos__proreceive ADD COLUMN remark_cancel TEXT NULL AFTER cancel_ckk',
	'SELECT ''remark_cancel already exists''');
PREPARE rp_stmt FROM @rp_sql;
EXECUTE rp_stmt;
DEALLOCATE PREPARE rp_stmt;

SET @rp_has_sort_no := (
	SELECT COUNT(*) FROM information_schema.COLUMNS
	WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'hos__subproreceive' AND COLUMN_NAME = 'sort_no'
);
SET @rp_sql := IF(@rp_has_sort_no = 0,
	'ALTER TABLE hos__subproreceive ADD COLUMN sort_no INT NOT NULL DEFAULT 0 AFTER ref_rpno',
	'SELECT ''sort_no already exists''');
PREPARE rp_stmt FROM @rp_sql;
EXECUTE rp_stmt;
DEALLOCATE PREPARE rp_stmt;
