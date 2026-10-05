-- แปลงตารางที่คอลัมน์ข้อความเป็น utf8mb3_uca1400_ai_ci กลับเป็น utf8mb3_general_ci ให้ตรงกับตารางที่เหลือ
--
-- อาการ: MariaDB 11.5+ ใช้ uca1400_ai_ci เป็นค่าเริ่มต้นเมื่อระบุ CHARSET=utf8 โดยไม่ระบุ COLLATE
--   ตารางที่ถูกสร้าง/import บนเซิร์ฟเวอร์แบบนั้นจึง join กับตารางเดิม (general_ci) ด้วยคอลัมน์ข้อความไม่ได้
--   #1267 - Illegal mix of collations (utf8mb3_uca1400_ai_ci,IMPLICIT) and (utf8mb3_general_ci,IMPLICIT)
--   เช่น hos__so.ref_id = hos__subso.ref_idd ใน includes/jong_repo.php และรายงานที่ join hos__so กับ hos__subso
--
-- วิธีใช้ (เลือกฐานข้อมูลของระบบก่อน เช่น allwell_sol_test — ห้ามรันขณะเลือก information_schema)
--   1) รันทั้งไฟล์โดยไม่แก้อะไร = ดูรายการเฉย ๆ ไม่แก้ตาราง (result = WILL CONVERT / SKIPPED)
--   2) backup ฐานข้อมูล แล้วแก้บรรทัด SET @uca_fix_execute ด้านล่างเป็น 1 และรันทั้งไฟล์อีกครั้ง
--      ควรทำนอกเวลาใช้งาน เพราะ ALTER TABLE สร้างตารางใหม่และ lock ตารางระหว่างแปลง
--
-- รันซ้ำได้ (idempotent) — ตารางที่แปลงแล้วจะไม่ถูกเลือกอีก
--
-- ขอบเขต
--   - แปลงเฉพาะตารางที่คอลัมน์ข้อความทุกตัว (และค่า default ของตาราง) เป็น utf8mb3_uca1400_ai_ci หรือ utf8mb3_general_ci
--   - ตารางที่มี collation อื่นปนอยู่ (เช่น utf8mb4_*) จะถูกข้าม (SKIPPED) เพราะ CONVERT TO จะเปลี่ยน charset ของคอลัมน์
--     เหล่านั้นไปด้วย ต้องตรวจและแก้รายคอลัมน์เอง
--   - ตารางที่แปลงไม่ผ่าน (เช่น unique key ซ้ำหลังเปลี่ยน collation) จะขึ้น FAILED พร้อมข้อความ และตารางนั้นไม่ถูกแก้
--   - ไม่แก้ค่า default ของฐานข้อมูลและของเซิร์ฟเวอร์ — CREATE TABLE ใหม่ต้องระบุ COLLATE=utf8mb3_general_ci เอง

SET @uca_fix_execute := 0;	-- 0 = แสดงรายการเฉย ๆ, 1 = แปลงจริง

DROP PROCEDURE IF EXISTS zz_fix_uca1400_collation;

DELIMITER $$

CREATE PROCEDURE zz_fix_uca1400_collation(IN p_execute TINYINT)
BEGIN
	DECLARE v_id INT DEFAULT 0;
	DECLARE v_max INT DEFAULT 0;
	DECLARE v_table VARCHAR(64);
	DECLARE v_other VARCHAR(255);
	DECLARE v_result TEXT;

	DROP TEMPORARY TABLE IF EXISTS tmp_uca1400_fix;
	CREATE TEMPORARY TABLE tmp_uca1400_fix (
		id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
		tbl VARCHAR(64) NOT NULL,
		uca1400_cols INT NOT NULL,
		other_collations VARCHAR(255) NULL,
		result TEXT NULL
	);

	-- วนด้วย id (ตัวเลข) เพื่อไม่ต้องเทียบข้อความข้าม collation ภายในสคริปต์นี้เอง
	INSERT INTO tmp_uca1400_fix (tbl, uca1400_cols, other_collations)
	SELECT t.TABLE_NAME,
		COALESCE(SUM(c.COLLATION_NAME LIKE '%uca1400%'), 0),
		NULLIF(CONCAT_WS(',',
			IF(t.TABLE_COLLATION IN ('utf8mb3_uca1400_ai_ci', 'utf8mb3_general_ci'), NULL, CONCAT('table default ', t.TABLE_COLLATION)),
			GROUP_CONCAT(DISTINCT IF(c.COLLATION_NAME IN ('utf8mb3_uca1400_ai_ci', 'utf8mb3_general_ci'), NULL, c.COLLATION_NAME))
		), '')
	FROM information_schema.TABLES t
	LEFT JOIN information_schema.COLUMNS c
		ON c.TABLE_SCHEMA = t.TABLE_SCHEMA AND c.TABLE_NAME = t.TABLE_NAME AND c.COLLATION_NAME IS NOT NULL
	WHERE t.TABLE_SCHEMA = DATABASE() AND t.TABLE_TYPE = 'BASE TABLE'
	GROUP BY t.TABLE_NAME, t.TABLE_COLLATION
	HAVING COALESCE(SUM(c.COLLATION_NAME LIKE '%uca1400%'), 0) > 0 OR t.TABLE_COLLATION LIKE '%uca1400%'
	ORDER BY t.TABLE_NAME;

	SELECT COALESCE(MAX(id), 0) INTO v_max FROM tmp_uca1400_fix;

	WHILE v_id < v_max DO
		SET v_id = v_id + 1;
		SELECT tbl, other_collations INTO v_table, v_other FROM tmp_uca1400_fix WHERE id = v_id;

		IF v_other IS NOT NULL THEN
			SET v_result = 'SKIPPED (other collations - review manually)';
		ELSEIF p_execute <> 1 THEN
			SET v_result = 'WILL CONVERT';
		ELSE
			SET v_result = 'CONVERTED';
			SET @uca_fix_sql = CONCAT('ALTER TABLE `', REPLACE(v_table, '`', '``'), '` CONVERT TO CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci');
			BEGIN
				DECLARE EXIT HANDLER FOR SQLEXCEPTION
				BEGIN
					GET DIAGNOSTICS CONDITION 1 v_result = MESSAGE_TEXT;
					SET v_result = CONCAT('FAILED: ', v_result);
				END;
				PREPARE uca_fix_stmt FROM @uca_fix_sql;
				EXECUTE uca_fix_stmt;
				DEALLOCATE PREPARE uca_fix_stmt;
			END;
		END IF;

		UPDATE tmp_uca1400_fix SET result = v_result WHERE id = v_id;
	END WHILE;

	SELECT DATABASE() AS db, tbl, uca1400_cols, other_collations, result FROM tmp_uca1400_fix ORDER BY id;
	DROP TEMPORARY TABLE tmp_uca1400_fix;
END$$

DELIMITER ;

CALL zz_fix_uca1400_collation(@uca_fix_execute);

DROP PROCEDURE IF EXISTS zz_fix_uca1400_collation;

-- ตรวจหลังแปลง: ควรเหลือ 0 (ยกเว้นคอลัมน์ของตารางที่ขึ้น SKIPPED / FAILED)
SELECT COUNT(*) AS uca1400_columns_left
FROM information_schema.COLUMNS
WHERE TABLE_SCHEMA = DATABASE() AND COLLATION_NAME LIKE '%uca1400%';
