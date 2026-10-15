-- แขวง/ตำบล ของการ์ดที่อยู่ออกบิล/จัดส่ง และที่อยู่ผู้เช่า ในหน้า customer_add.php (dropdown จาก db__sub_districts เก็บ name_th)
-- ที่อยู่ลูกค้าใช้ tb_customer.cus_addtum เดิม ที่อยู่ผู้เช่าเพิ่ม rental_addtum ตั้งชื่อตามแบบเดียวกัน
--
-- รันซ้ำได้ — ข้ามคอลัมน์ที่มีอยู่แล้ว
-- ต้องรันก่อน deploy add_customer1.php / edit_customer1.php ที่ INSERT คอลัมน์นี้

SET @s = (SELECT IF(COUNT(*) = 0, 'ALTER TABLE tb_customer_billing_address ADD COLUMN billing_tumbon VARCHAR(255) DEFAULT NULL AFTER billing_ampher', 'SELECT 1')
          FROM information_schema.columns
          WHERE table_schema = DATABASE() AND table_name = 'tb_customer_billing_address' AND column_name = 'billing_tumbon');
PREPARE st FROM @s; EXECUTE st; DEALLOCATE PREPARE st;

SET @s = (SELECT IF(COUNT(*) = 0, 'ALTER TABLE tb_customer_shipping_address ADD COLUMN shipping_tumbon VARCHAR(255) DEFAULT NULL AFTER shipping_ampher', 'SELECT 1')
          FROM information_schema.columns
          WHERE table_schema = DATABASE() AND table_name = 'tb_customer_shipping_address' AND column_name = 'shipping_tumbon');
PREPARE st FROM @s; EXECUTE st; DEALLOCATE PREPARE st;

SET @s = (SELECT IF(COUNT(*) = 0, 'ALTER TABLE tb_customer ADD COLUMN rental_addtum VARCHAR(200) DEFAULT NULL AFTER rental_ampher', 'SELECT 1')
          FROM information_schema.columns
          WHERE table_schema = DATABASE() AND table_name = 'tb_customer' AND column_name = 'rental_addtum');
PREPARE st FROM @s; EXECUTE st; DEALLOCATE PREPARE st;
