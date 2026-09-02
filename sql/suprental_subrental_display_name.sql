-- hos__subrental: เพิ่มคอลัมน์เก็บ "ชื่อที่แสดงในใบส่งสินค้า" ต่อรายการสินค้า
-- ฟอร์ม register_suprental.php / product_rentalawl.php มีช่องนี้อยู่แล้ว (display_name{i}, แก้ผ่าน modal rt_modal_display_name)
-- แต่ยังไม่เคยถูกบันทึกลงฐานข้อมูล — เพิ่มคอลัมน์ต่อท้าย free_count ตามลำดับคอลัมน์ปัจจุบันของ INSERT statement
ALTER TABLE hos__subrental
  ADD COLUMN display_name VARCHAR(255) NOT NULL DEFAULT '' AFTER free_count;
