-- ชุดคำสั่งแบบไม่ใช้ stored procedure ของ sql/fix_uca1400_collation.sql
-- ใช้เมื่อโปรแกรมที่รัน SQL ไม่รองรับ DELIMITER (CREATE PROCEDURE ขึ้น #1064 near '' at line 3)
--
-- รายชื่อตารางมาจากเซิร์ฟเวอร์จริง (MariaDB 11.8.6) ที่ตรวจเมื่อ 2026-10-05: 52 ตาราง 938 คอลัมน์
-- ครอบคลุมเฉพาะตารางที่มีคอลัมน์ utf8mb3_uca1400_ai_ci ณ วันนั้น — ห้ามรันกับฐานข้อมูลอื่น
--
-- ก่อนรัน
--   1) backup ฐานข้อมูล และรันนอกเวลาใช้งาน (ALTER TABLE สร้างตารางใหม่และ lock ตารางระหว่างแปลง)
--   2) ตรวจว่าตารางในรายการไม่มี collation อื่นปน (เช่น utf8mb4_*) — คำสั่งตรวจต้องได้ผลว่าง:
--        SELECT c.TABLE_NAME, GROUP_CONCAT(DISTINCT c.COLLATION_NAME) AS other_collations
--        FROM information_schema.COLUMNS c
--        WHERE c.TABLE_SCHEMA = DATABASE()
--          AND c.COLLATION_NAME NOT IN ('utf8mb3_uca1400_ai_ci', 'utf8mb3_general_ci')
--          AND c.TABLE_NAME IN (SELECT TABLE_NAME FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND COLLATION_NAME LIKE '%uca1400%')
--        GROUP BY c.TABLE_NAME;
--      ตารางที่ขึ้นในผลตรวจให้ลบบรรทัด ALTER ของตารางนั้นออกก่อนรัน แล้วแก้รายคอลัมน์เอง
--
-- รันซ้ำได้ — ตารางที่แปลงแล้วจะถูก rebuild ซ้ำโดยผลลัพธ์เหมือนเดิม

ALTER TABLE `hos__breg` CONVERT TO CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
ALTER TABLE `hos__change` CONVERT TO CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
ALTER TABLE `hos__consig` CONVERT TO CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
ALTER TABLE `hos__proreceive` CONVERT TO CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
ALTER TABLE `hos__receive` CONVERT TO CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
ALTER TABLE `hos__rental` CONVERT TO CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
ALTER TABLE `hos__rental_contact` CONVERT TO CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
ALTER TABLE `hos__rental_runiv` CONVERT TO CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
ALTER TABLE `hos__smp` CONVERT TO CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
ALTER TABLE `hos__so` CONVERT TO CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
ALTER TABLE `hos__spr` CONVERT TO CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
ALTER TABLE `hos__subbreg1` CONVERT TO CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
ALTER TABLE `hos__subbreg2` CONVERT TO CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
ALTER TABLE `hos__subchange` CONVERT TO CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
ALTER TABLE `hos__subconsig` CONVERT TO CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
ALTER TABLE `hos__subproreceive` CONVERT TO CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
ALTER TABLE `hos__subreceive` CONVERT TO CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
ALTER TABLE `hos__subrental` CONVERT TO CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
ALTER TABLE `hos__subsmp` CONVERT TO CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
ALTER TABLE `hos__subspr` CONVERT TO CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
ALTER TABLE `in__br` CONVERT TO CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
ALTER TABLE `in__subbr` CONVERT TO CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
ALTER TABLE `st__lotno` CONVERT TO CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
ALTER TABLE `tb_closedoc` CONVERT TO CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
ALTER TABLE `tb_comment_so` CONVERT TO CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
ALTER TABLE `tb_credit_note` CONVERT TO CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
ALTER TABLE `tb_customer` CONVERT TO CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
ALTER TABLE `tb_delivery_bill` CONVERT TO CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
ALTER TABLE `tb_delivery_print` CONVERT TO CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
ALTER TABLE `tb_docbreng` CONVERT TO CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
ALTER TABLE `tb_document` CONVERT TO CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
ALTER TABLE `tb_document_status_log` CONVERT TO CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
ALTER TABLE `tb_doc_rental` CONVERT TO CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
ALTER TABLE `tb_iv_awl` CONVERT TO CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
ALTER TABLE `tb_mode_customer` CONVERT TO CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
ALTER TABLE `tb_objective` CONVERT TO CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
ALTER TABLE `tb_other_bill` CONVERT TO CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
ALTER TABLE `tb_probom_online` CONVERT TO CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
ALTER TABLE `tb_product_bomhos` CONVERT TO CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
ALTER TABLE `tb_product_checklis` CONVERT TO CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
ALTER TABLE `tb_product_checkref` CONVERT TO CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
ALTER TABLE `tb_product_leaflet` CONVERT TO CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
ALTER TABLE `tb_product_rental` CONVERT TO CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
ALTER TABLE `tb_product_rentalref` CONVERT TO CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
ALTER TABLE `tb_promisno` CONVERT TO CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
ALTER TABLE `tb_province` CONVERT TO CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
ALTER TABLE `tb_salechannel` CONVERT TO CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
ALTER TABLE `tb_subcredit` CONVERT TO CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
ALTER TABLE `tb_sumall` CONVERT TO CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
ALTER TABLE `tb_target` CONVERT TO CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
ALTER TABLE `tb_transaction` CONVERT TO CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
ALTER TABLE `user_sale_permission` CONVERT TO CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;

-- ตรวจหลังแปลง: ควรเหลือ 0
SELECT COUNT(*) AS uca1400_columns_left
FROM information_schema.COLUMNS
WHERE TABLE_SCHEMA = DATABASE() AND COLLATION_NAME LIKE '%uca1400%';
