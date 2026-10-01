-- ช่วงเวลาจัดส่ง (dropdown "เลือกช่วงเวลา" ในแท็บข้อมูลการจัดส่ง) — เก็บที่ตารางหัวเอกสารของแต่ละฟอร์ม
-- ใช้โดย register_suphos.php (hos__so), register_supbrhos.php (hos__br), register_supbrcshos.php (hos__consig),
-- register_supchange.php (hos__change), register_suprental.php (hos__rental), register_supsmp.php (hos__smp)
--
-- รันซ้ำได้ (idempotent) — ทุกคำสั่งเช็ค information_schema ก่อนแก้ตาราง
--
-- time_range
--   ''          = ยังไม่ได้เลือก — DEFAULT ของคอลัมน์ ทำให้เอกสารเดิมและตัวบันทึกเดิมที่ไม่รู้จักคอลัมน์นี้ยังทำงานได้
--   'morning'   = ช่วงเช้า
--   'afternoon' = ช่วงบ่าย
--   'allday'    = ทั้งวัน
--   'specific'  = กำหนดเวลา
--   เป็นค่าอิสระ ไม่ผูกกับ delivery_time / start_time / end_time
--   ไม่เก็บที่ tb_register_data เพราะหน้า admin edit เดิมลบแล้วเขียนแถวใหม่โดยไม่มีคอลัมน์นี้

SET @tr_has := (
	SELECT COUNT(*) FROM information_schema.COLUMNS
	WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'hos__so' AND COLUMN_NAME = 'time_range'
);
SET @tr_sql := IF(@tr_has = 0,
	'ALTER TABLE hos__so ADD COLUMN time_range VARCHAR(20) NOT NULL DEFAULT ''''',
	'SELECT ''hos__so.time_range already exists''');
PREPARE tr_stmt FROM @tr_sql;
EXECUTE tr_stmt;
DEALLOCATE PREPARE tr_stmt;

SET @tr_has := (
	SELECT COUNT(*) FROM information_schema.COLUMNS
	WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'hos__br' AND COLUMN_NAME = 'time_range'
);
SET @tr_sql := IF(@tr_has = 0,
	'ALTER TABLE hos__br ADD COLUMN time_range VARCHAR(20) NOT NULL DEFAULT ''''',
	'SELECT ''hos__br.time_range already exists''');
PREPARE tr_stmt FROM @tr_sql;
EXECUTE tr_stmt;
DEALLOCATE PREPARE tr_stmt;

SET @tr_has := (
	SELECT COUNT(*) FROM information_schema.COLUMNS
	WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'hos__consig' AND COLUMN_NAME = 'time_range'
);
SET @tr_sql := IF(@tr_has = 0,
	'ALTER TABLE hos__consig ADD COLUMN time_range VARCHAR(20) NOT NULL DEFAULT ''''',
	'SELECT ''hos__consig.time_range already exists''');
PREPARE tr_stmt FROM @tr_sql;
EXECUTE tr_stmt;
DEALLOCATE PREPARE tr_stmt;

SET @tr_has := (
	SELECT COUNT(*) FROM information_schema.COLUMNS
	WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'hos__change' AND COLUMN_NAME = 'time_range'
);
SET @tr_sql := IF(@tr_has = 0,
	'ALTER TABLE hos__change ADD COLUMN time_range VARCHAR(20) NOT NULL DEFAULT ''''',
	'SELECT ''hos__change.time_range already exists''');
PREPARE tr_stmt FROM @tr_sql;
EXECUTE tr_stmt;
DEALLOCATE PREPARE tr_stmt;

SET @tr_has := (
	SELECT COUNT(*) FROM information_schema.COLUMNS
	WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'hos__rental' AND COLUMN_NAME = 'time_range'
);
SET @tr_sql := IF(@tr_has = 0,
	'ALTER TABLE hos__rental ADD COLUMN time_range VARCHAR(20) NOT NULL DEFAULT ''''',
	'SELECT ''hos__rental.time_range already exists''');
PREPARE tr_stmt FROM @tr_sql;
EXECUTE tr_stmt;
DEALLOCATE PREPARE tr_stmt;

SET @tr_has := (
	SELECT COUNT(*) FROM information_schema.COLUMNS
	WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'hos__smp' AND COLUMN_NAME = 'time_range'
);
SET @tr_sql := IF(@tr_has = 0,
	'ALTER TABLE hos__smp ADD COLUMN time_range VARCHAR(20) NOT NULL DEFAULT ''''',
	'SELECT ''hos__smp.time_range already exists''');
PREPARE tr_stmt FROM @tr_sql;
EXECUTE tr_stmt;
DEALLOCATE PREPARE tr_stmt;
