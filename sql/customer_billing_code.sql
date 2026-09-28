-- รหัสลูกค้า AWL / NBM แยกรายที่อยู่ออกบิล (tb_customer_billing_address.billing_code / billing_coden)
-- ใช้โดย customer_add.php / add_customer1.php / edit_customer1.php ผ่าน customer_code_lib.php
--
-- รันซ้ำได้ (idempotent) — เช็ค information_schema ก่อนแก้ตาราง
-- (customer_code_lib.php ก็เพิ่มคอลัมน์เหล่านี้ให้เองถ้ายังไม่มี ไฟล์นี้ไว้รันล่วงหน้าบน production)
--
-- billing_code
--   ชุดเลขเดียวกับ tb_customer.customer_code: PC + ปี พ.ศ. 2 หลัก + เดือน 2 หลัก + เลขรัน 4 หลัก
--   บิล 1 (billing_index = 1) เท่ากับ tb_customer.customer_code เสมอ, บิล 2+ มีรหัสของตัวเอง
--   NULL = ยังไม่ได้รันรหัส (แถวเดิมทั้งหมด)
--
-- billing_coden
--   ชุดเลขเดียวกับ tb_customer.customer_coden: NC + ปี พ.ศ. 2 หลัก + เดือน 2 หลัก + เลขรัน 4 หลัก
--   บิล 1 (billing_index = 1) เท่ากับ tb_customer.customer_coden เสมอ, บิล 2+ มีรหัสของตัวเอง

SET @cb_has_billing_code := (
	SELECT COUNT(*) FROM information_schema.COLUMNS
	WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'tb_customer_billing_address' AND COLUMN_NAME = 'billing_code'
);
SET @cb_sql := IF(@cb_has_billing_code = 0,
	'ALTER TABLE tb_customer_billing_address ADD COLUMN billing_code VARCHAR(100) DEFAULT NULL AFTER billing_index, ADD KEY idx_customer_billing_code (billing_code)',
	'SELECT ''billing_code already exists''');
PREPARE cb_stmt FROM @cb_sql;
EXECUTE cb_stmt;
DEALLOCATE PREPARE cb_stmt;

-- บิล 1 ของลูกค้าเดิมให้ตรงกับ tb_customer.customer_code
UPDATE tb_customer_billing_address b
JOIN tb_customer c ON c.customer_id = b.customer_id
SET b.billing_code = TRIM(c.customer_code)
WHERE b.billing_index = 1
	AND (b.billing_code IS NULL OR b.billing_code = '')
	AND TRIM(IFNULL(c.customer_code, '')) <> '';

SET @cb_has_billing_coden := (
	SELECT COUNT(*) FROM information_schema.COLUMNS
	WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'tb_customer_billing_address' AND COLUMN_NAME = 'billing_coden'
);
SET @cb_sql := IF(@cb_has_billing_coden = 0,
	'ALTER TABLE tb_customer_billing_address ADD COLUMN billing_coden VARCHAR(100) DEFAULT NULL AFTER billing_code, ADD KEY idx_customer_billing_coden (billing_coden)',
	'SELECT ''billing_coden already exists''');
PREPARE cb_stmt FROM @cb_sql;
EXECUTE cb_stmt;
DEALLOCATE PREPARE cb_stmt;

-- บิล 1 ของลูกค้าเดิมให้ตรงกับ tb_customer.customer_coden
UPDATE tb_customer_billing_address b
JOIN tb_customer c ON c.customer_id = b.customer_id
SET b.billing_coden = TRIM(c.customer_coden)
WHERE b.billing_index = 1
	AND (b.billing_coden IS NULL OR b.billing_coden = '')
	AND TRIM(IFNULL(c.customer_coden, '')) <> '';
