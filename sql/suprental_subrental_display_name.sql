-- hos__subrental: เพิ่มคอลัมน์ delivery_cost / free_count
-- คอมมิต 8e52b0e (2026-08-31) แก้ INSERT/UPDATE ใน register_adminrental_edit1.php ให้เขียน
-- delivery_cost (ค่าจัดส่งต่อรายการ จาก product_rentalawl.php: rt_header_delivery) และ
-- free_count (จำนวนของแถม ต่อรายการ) ลง hos__subrental แต่ไม่เคยมี ALTER TABLE คู่กันมาก่อน
-- ฐานข้อมูลที่ยังไม่รันสคริปต์นี้จะบันทึกรายการเช่าไม่ได้
ALTER TABLE hos__subrental
  ADD COLUMN delivery_cost DECIMAL(20,2) NOT NULL DEFAULT 0.00 AFTER remark_sale,
  ADD COLUMN free_count INT NOT NULL DEFAULT 0 AFTER delivery_cost;

-- hos__subrental: เพิ่มคอลัมน์เก็บ "ชื่อที่แสดงในใบส่งสินค้า" ต่อรายการสินค้า
-- ฟอร์ม register_suprental.php / product_rentalawl.php มีช่องนี้อยู่แล้ว (display_name{i}, แก้ผ่าน modal rt_modal_display_name)
-- แต่ยังไม่เคยถูกบันทึกลงฐานข้อมูล — เพิ่มคอลัมน์ต่อท้าย free_count ตามลำดับคอลัมน์ปัจจุบันของ INSERT statement
ALTER TABLE hos__subrental
  ADD COLUMN display_name VARCHAR(255) NOT NULL DEFAULT '' AFTER free_count;
