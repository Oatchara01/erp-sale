-- ผูกใบคืนสินค้า (hos__receive) กับเอกสารต้นทาง + ช่วงเวลา — ใช้โดย register_receive.php / includes/receive_repo.php
--
-- รันซ้ำได้ (idempotent) — ทุกคำสั่งเช็ค information_schema ก่อนแก้ตาราง
-- ต้องรันบน production (phpMyAdmin) ก่อน deploy โค้ด
--
-- source_type  ประเภทเอกสารต้นทาง: br, consig, breq, breg, smp, rental, change, spr   ('' = ใบคืนเก่าจากฟอร์มเดิม)
-- source_ref   เลขอ้างอิงของเอกสารต้นทาง (key ของตารางหัว: hos__br.ref_id_br, hos__consig.ref_id,
--              in__br.ref_id_br, hos__breg.ref_id, hos__smp.ref_idsmp, hos__rental.ref_id, hos__change.ref_id, hos__spr.ref_id)
-- time_range   ''/morning/afternoon/allday/specific — ค่าชุดเดียวกับ sql/delivery_time_range.sql
-- type_company บริษัทของใบคืน: 3 = AWL, 4 = NBM — เพิ่มเฉพาะฐานที่ยังไม่มีคอลัมน์นี้
--              (Submit แล้วขึ้น Unknown column 'type_company' in 'INSERT INTO'); ใบคืนที่มีอยู่ก่อนได้ค่า 0 ไม่เติมย้อนหลัง
-- date_receive วันที่ฝากคืน — เพิ่มเฉพาะฐานที่ยังไม่มีคอลัมน์นี้; ใบคืนที่มีอยู่ก่อนได้ค่า NULL ไม่เติมย้อนหลัง
-- receive_ckk  วิธีคืนสินค้า: 1 = คืนด้วยตัวเอง, 2 = ฝากคืน — เพิ่มเฉพาะฐานที่ยังไม่มีคอลัมน์นี้; ใบคืนที่มีอยู่ก่อนได้ค่า 0
-- receive_name ชื่อบุคคลที่ฝากคืน (ว่างเมื่อคืนด้วยตัวเอง) — เพิ่มเฉพาะฐานที่ยังไม่มีคอลัมน์นี้
-- receive_between ช่วงวันที่ของฟอร์มเดิม (ฟอร์มใหม่เขียนค่าว่าง) — เพิ่มเฉพาะฐานที่ยังไม่มีคอลัมน์นี้
-- time_between เวลาในการจัดส่ง (ฟอร์มใหม่เขียน HH:MM) — เพิ่มเฉพาะฐานที่ยังไม่มีคอลัมน์นี้
-- customer_tel เบอร์โทรลูกค้า (คัดลอกจากเอกสารต้นทาง) — เพิ่มเฉพาะฐานที่ยังไม่มีคอลัมน์นี้
-- customer_address ที่อยู่ในใบคืน — เพิ่มเฉพาะฐานที่ยังไม่มีคอลัมน์นี้ (TEXT ใส่ DEFAULT ไม่ได้ในบางเวอร์ชัน จึงเป็น NULL ได้)
-- remark_st    คำอธิบายเพิ่มเติมถึง Stock — เพิ่มเฉพาะฐานที่ยังไม่มีคอลัมน์นี้ (TEXT เป็น NULL ได้ ด้วยเหตุผลเดียวกัน)
-- sale_name    ชื่อผู้ขาย/ผู้ทำเอกสารต้นทาง (คัดลอกจากเอกสารต้นทาง) — เพิ่มเฉพาะฐานที่ยังไม่มีคอลัมน์นี้
-- order_id     หมายเลขคำสั่งซื้อ (ไม่บังคับกรอก) — เพิ่มเฉพาะฐานที่ยังไม่มีคอลัมน์นี้
-- add_by       ชื่อผู้สร้างใบคืน — เพิ่มเฉพาะฐานที่ยังไม่มีคอลัมน์นี้
-- add_date     วันเวลาที่สร้างใบคืน — เพิ่มเฉพาะฐานที่ยังไม่มีคอลัมน์นี้; ใบคืนที่มีอยู่ก่อนได้ค่า NULL
-- send_stock   สถานะใบคืน: 0 = Draft, 1 = ส่งให้ Stock แล้ว — เพิ่มเฉพาะฐานที่ยังไม่มีคอลัมน์นี้; ใบคืนที่มีอยู่ก่อนได้ค่า 0 (Draft)
-- allwell_ckk  1 = ใบคืนของ SMP, 0 = อื่น ๆ — เพิ่มเฉพาะฐานที่ยังไม่มีคอลัมน์นี้
-- img_re1..3   ชื่อไฟล์แนบในโฟลเดอร์ up_return/ — เพิ่มเฉพาะฐานที่ยังไม่มีคอลัมน์นี้
--
-- มี DEFAULT ให้ตัวบันทึกเก่า (rister_clearbrpn_st1.php ฯลฯ) ที่ไม่รู้จักคอลัมน์เหล่านี้ยัง INSERT ได้
-- ไม่เติมค่าให้ใบคืนเก่า และ iv_no ยังถูกเขียนตามเดิมเพื่อให้รายงาน/สูตรเก่าที่จับคู่ด้วย iv_no ทำงานต่อ

SET @rs_has := (
	SELECT COUNT(*) FROM information_schema.COLUMNS
	WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'hos__receive' AND COLUMN_NAME = 'source_type'
);
SET @rs_sql := IF(@rs_has = 0,
	'ALTER TABLE hos__receive ADD COLUMN source_type VARCHAR(20) NOT NULL DEFAULT ''''',
	'SELECT ''hos__receive.source_type already exists''');
PREPARE rs_stmt FROM @rs_sql;
EXECUTE rs_stmt;
DEALLOCATE PREPARE rs_stmt;

SET @rs_has := (
	SELECT COUNT(*) FROM information_schema.COLUMNS
	WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'hos__receive' AND COLUMN_NAME = 'source_ref'
);
SET @rs_sql := IF(@rs_has = 0,
	'ALTER TABLE hos__receive ADD COLUMN source_ref VARCHAR(100) NOT NULL DEFAULT ''''',
	'SELECT ''hos__receive.source_ref already exists''');
PREPARE rs_stmt FROM @rs_sql;
EXECUTE rs_stmt;
DEALLOCATE PREPARE rs_stmt;

SET @rs_has := (
	SELECT COUNT(*) FROM information_schema.COLUMNS
	WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'hos__receive' AND COLUMN_NAME = 'time_range'
);
SET @rs_sql := IF(@rs_has = 0,
	'ALTER TABLE hos__receive ADD COLUMN time_range VARCHAR(20) NOT NULL DEFAULT ''''',
	'SELECT ''hos__receive.time_range already exists''');
PREPARE rs_stmt FROM @rs_sql;
EXECUTE rs_stmt;
DEALLOCATE PREPARE rs_stmt;

SET @rs_has := (
	SELECT COUNT(*) FROM information_schema.COLUMNS
	WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'hos__receive' AND COLUMN_NAME = 'type_company'
);
SET @rs_sql := IF(@rs_has = 0,
	'ALTER TABLE hos__receive ADD COLUMN type_company INT NOT NULL DEFAULT 0 AFTER ref_id',
	'SELECT ''hos__receive.type_company already exists''');
PREPARE rs_stmt FROM @rs_sql;
EXECUTE rs_stmt;
DEALLOCATE PREPARE rs_stmt;

SET @rs_has := (
	SELECT COUNT(*) FROM information_schema.COLUMNS
	WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'hos__receive' AND COLUMN_NAME = 'date_receive'
);
SET @rs_sql := IF(@rs_has = 0,
	'ALTER TABLE hos__receive ADD COLUMN date_receive DATE NULL DEFAULT NULL AFTER type_company',
	'SELECT ''hos__receive.date_receive already exists''');
PREPARE rs_stmt FROM @rs_sql;
EXECUTE rs_stmt;
DEALLOCATE PREPARE rs_stmt;

SET @rs_has := (
	SELECT COUNT(*) FROM information_schema.COLUMNS
	WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'hos__receive' AND COLUMN_NAME = 'receive_ckk'
);
SET @rs_sql := IF(@rs_has = 0,
	'ALTER TABLE hos__receive ADD COLUMN receive_ckk INT NOT NULL DEFAULT 0 AFTER date_receive',
	'SELECT ''hos__receive.receive_ckk already exists''');
PREPARE rs_stmt FROM @rs_sql;
EXECUTE rs_stmt;
DEALLOCATE PREPARE rs_stmt;

SET @rs_has := (
	SELECT COUNT(*) FROM information_schema.COLUMNS
	WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'hos__receive' AND COLUMN_NAME = 'receive_name'
);
SET @rs_sql := IF(@rs_has = 0,
	'ALTER TABLE hos__receive ADD COLUMN receive_name VARCHAR(100) NOT NULL DEFAULT '''' AFTER receive_ckk',
	'SELECT ''hos__receive.receive_name already exists''');
PREPARE rs_stmt FROM @rs_sql;
EXECUTE rs_stmt;
DEALLOCATE PREPARE rs_stmt;

SET @rs_has := (
	SELECT COUNT(*) FROM information_schema.COLUMNS
	WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'hos__receive' AND COLUMN_NAME = 'receive_between'
);
SET @rs_sql := IF(@rs_has = 0,
	'ALTER TABLE hos__receive ADD COLUMN receive_between VARCHAR(100) NOT NULL DEFAULT '''' AFTER receive_name',
	'SELECT ''hos__receive.receive_between already exists''');
PREPARE rs_stmt FROM @rs_sql;
EXECUTE rs_stmt;
DEALLOCATE PREPARE rs_stmt;

SET @rs_has := (
	SELECT COUNT(*) FROM information_schema.COLUMNS
	WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'hos__receive' AND COLUMN_NAME = 'time_between'
);
SET @rs_sql := IF(@rs_has = 0,
	'ALTER TABLE hos__receive ADD COLUMN time_between VARCHAR(100) NOT NULL DEFAULT '''' AFTER receive_between',
	'SELECT ''hos__receive.time_between already exists''');
PREPARE rs_stmt FROM @rs_sql;
EXECUTE rs_stmt;
DEALLOCATE PREPARE rs_stmt;

SET @rs_has := (
	SELECT COUNT(*) FROM information_schema.COLUMNS
	WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'hos__receive' AND COLUMN_NAME = 'customer_tel'
);
SET @rs_sql := IF(@rs_has = 0,
	'ALTER TABLE hos__receive ADD COLUMN customer_tel VARCHAR(100) NOT NULL DEFAULT ''''',
	'SELECT ''hos__receive.customer_tel already exists''');
PREPARE rs_stmt FROM @rs_sql;
EXECUTE rs_stmt;
DEALLOCATE PREPARE rs_stmt;

SET @rs_has := (
	SELECT COUNT(*) FROM information_schema.COLUMNS
	WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'hos__receive' AND COLUMN_NAME = 'customer_address'
);
SET @rs_sql := IF(@rs_has = 0,
	'ALTER TABLE hos__receive ADD COLUMN customer_address TEXT NULL',
	'SELECT ''hos__receive.customer_address already exists''');
PREPARE rs_stmt FROM @rs_sql;
EXECUTE rs_stmt;
DEALLOCATE PREPARE rs_stmt;

SET @rs_has := (
	SELECT COUNT(*) FROM information_schema.COLUMNS
	WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'hos__receive' AND COLUMN_NAME = 'remark_st'
);
SET @rs_sql := IF(@rs_has = 0,
	'ALTER TABLE hos__receive ADD COLUMN remark_st TEXT NULL',
	'SELECT ''hos__receive.remark_st already exists''');
PREPARE rs_stmt FROM @rs_sql;
EXECUTE rs_stmt;
DEALLOCATE PREPARE rs_stmt;

SET @rs_has := (
	SELECT COUNT(*) FROM information_schema.COLUMNS
	WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'hos__receive' AND COLUMN_NAME = 'sale_name'
);
SET @rs_sql := IF(@rs_has = 0,
	'ALTER TABLE hos__receive ADD COLUMN sale_name VARCHAR(100) NOT NULL DEFAULT ''''',
	'SELECT ''hos__receive.sale_name already exists''');
PREPARE rs_stmt FROM @rs_sql;
EXECUTE rs_stmt;
DEALLOCATE PREPARE rs_stmt;

SET @rs_has := (
	SELECT COUNT(*) FROM information_schema.COLUMNS
	WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'hos__receive' AND COLUMN_NAME = 'order_id'
);
SET @rs_sql := IF(@rs_has = 0,
	'ALTER TABLE hos__receive ADD COLUMN order_id VARCHAR(100) NOT NULL DEFAULT ''''',
	'SELECT ''hos__receive.order_id already exists''');
PREPARE rs_stmt FROM @rs_sql;
EXECUTE rs_stmt;
DEALLOCATE PREPARE rs_stmt;

SET @rs_has := (
	SELECT COUNT(*) FROM information_schema.COLUMNS
	WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'hos__receive' AND COLUMN_NAME = 'add_by'
);
SET @rs_sql := IF(@rs_has = 0,
	'ALTER TABLE hos__receive ADD COLUMN add_by VARCHAR(100) NOT NULL DEFAULT ''''',
	'SELECT ''hos__receive.add_by already exists''');
PREPARE rs_stmt FROM @rs_sql;
EXECUTE rs_stmt;
DEALLOCATE PREPARE rs_stmt;

SET @rs_has := (
	SELECT COUNT(*) FROM information_schema.COLUMNS
	WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'hos__receive' AND COLUMN_NAME = 'add_date'
);
SET @rs_sql := IF(@rs_has = 0,
	'ALTER TABLE hos__receive ADD COLUMN add_date DATETIME NULL DEFAULT NULL',
	'SELECT ''hos__receive.add_date already exists''');
PREPARE rs_stmt FROM @rs_sql;
EXECUTE rs_stmt;
DEALLOCATE PREPARE rs_stmt;

SET @rs_has := (
	SELECT COUNT(*) FROM information_schema.COLUMNS
	WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'hos__receive' AND COLUMN_NAME = 'send_stock'
);
SET @rs_sql := IF(@rs_has = 0,
	'ALTER TABLE hos__receive ADD COLUMN send_stock INT NOT NULL DEFAULT 0',
	'SELECT ''hos__receive.send_stock already exists''');
PREPARE rs_stmt FROM @rs_sql;
EXECUTE rs_stmt;
DEALLOCATE PREPARE rs_stmt;

SET @rs_has := (
	SELECT COUNT(*) FROM information_schema.COLUMNS
	WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'hos__receive' AND COLUMN_NAME = 'allwell_ckk'
);
SET @rs_sql := IF(@rs_has = 0,
	'ALTER TABLE hos__receive ADD COLUMN allwell_ckk INT NOT NULL DEFAULT 0',
	'SELECT ''hos__receive.allwell_ckk already exists''');
PREPARE rs_stmt FROM @rs_sql;
EXECUTE rs_stmt;
DEALLOCATE PREPARE rs_stmt;

SET @rs_has := (
	SELECT COUNT(*) FROM information_schema.COLUMNS
	WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'hos__receive' AND COLUMN_NAME = 'img_re1'
);
SET @rs_sql := IF(@rs_has = 0,
	'ALTER TABLE hos__receive ADD COLUMN img_re1 VARCHAR(100) NOT NULL DEFAULT ''''',
	'SELECT ''hos__receive.img_re1 already exists''');
PREPARE rs_stmt FROM @rs_sql;
EXECUTE rs_stmt;
DEALLOCATE PREPARE rs_stmt;

SET @rs_has := (
	SELECT COUNT(*) FROM information_schema.COLUMNS
	WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'hos__receive' AND COLUMN_NAME = 'img_re2'
);
SET @rs_sql := IF(@rs_has = 0,
	'ALTER TABLE hos__receive ADD COLUMN img_re2 VARCHAR(100) NOT NULL DEFAULT ''''',
	'SELECT ''hos__receive.img_re2 already exists''');
PREPARE rs_stmt FROM @rs_sql;
EXECUTE rs_stmt;
DEALLOCATE PREPARE rs_stmt;

SET @rs_has := (
	SELECT COUNT(*) FROM information_schema.COLUMNS
	WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'hos__receive' AND COLUMN_NAME = 'img_re3'
);
SET @rs_sql := IF(@rs_has = 0,
	'ALTER TABLE hos__receive ADD COLUMN img_re3 VARCHAR(100) NOT NULL DEFAULT ''''',
	'SELECT ''hos__receive.img_re3 already exists''');
PREPARE rs_stmt FROM @rs_sql;
EXECUTE rs_stmt;
DEALLOCATE PREPARE rs_stmt;

-- ค้นใบคืนของเอกสารต้นทางหนึ่งใบ (ประวัติการคืน + สูตรยอดค้าง)
SET @rs_has := (
	SELECT COUNT(*) FROM information_schema.STATISTICS
	WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'hos__receive' AND INDEX_NAME = 'idx_receive_source'
);
SET @rs_sql := IF(@rs_has = 0,
	'ALTER TABLE hos__receive ADD INDEX idx_receive_source (source_type, source_ref)',
	'SELECT ''idx_receive_source already exists''');
PREPARE rs_stmt FROM @rs_sql;
EXECUTE rs_stmt;
DEALLOCATE PREPARE rs_stmt;
