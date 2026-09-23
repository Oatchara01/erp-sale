-- ใบยืมตรวจเช็คสินค้า (BREQ) — popup "รายการสินค้าเพิ่มเติม" ต้องเก็บ "ชื่อที่แสดงในใบส่งสินค้า"
-- ต่อแถว แต่ in__subbr ยังไม่มีคอลัมน์นี้ (in__sbmain มีอยู่แล้วเป็นต้นทาง ใช้ชื่อคอลัมน์เดียวกัน
-- เพื่อความสม่ำเสมอ) — ดูแผน register_breng_brgq.php §7.1
--
-- ไม่ได้ถูกรันจาก Claude — พี่/DBA ต้องรันเองบนฐาน allwell_sol_test
ALTER TABLE `in__subbr`
  ADD COLUMN `product_nameother` VARCHAR(300) NULL AFTER `product_code`;
