-- ถอน billing_tumbon / shipping_tumbon / tb_customer.rental_addtum (ข้อมูลตำบลของการ์ดออกบิล/จัดส่ง/ผู้เช่าจะหาย)

SET @s = (SELECT IF(COUNT(*) > 0, 'ALTER TABLE tb_customer DROP COLUMN rental_addtum', 'SELECT 1')
          FROM information_schema.columns
          WHERE table_schema = DATABASE() AND table_name = 'tb_customer' AND column_name = 'rental_addtum');
PREPARE st FROM @s; EXECUTE st; DEALLOCATE PREPARE st;

SET @s = (SELECT IF(COUNT(*) > 0, 'ALTER TABLE tb_customer_billing_address DROP COLUMN billing_tumbon', 'SELECT 1')
          FROM information_schema.columns
          WHERE table_schema = DATABASE() AND table_name = 'tb_customer_billing_address' AND column_name = 'billing_tumbon');
PREPARE st FROM @s; EXECUTE st; DEALLOCATE PREPARE st;

SET @s = (SELECT IF(COUNT(*) > 0, 'ALTER TABLE tb_customer_shipping_address DROP COLUMN shipping_tumbon', 'SELECT 1')
          FROM information_schema.columns
          WHERE table_schema = DATABASE() AND table_name = 'tb_customer_shipping_address' AND column_name = 'shipping_tumbon');
PREPARE st FROM @s; EXECUTE st; DEALLOCATE PREPARE st;
