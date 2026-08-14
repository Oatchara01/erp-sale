-- ใบยืมฝากขาย (register_supbrcshos.php / register_supbrcshos1.php)
-- คอลัมน์ที่ Google Sheet ชีต "ใบยืมฝากขาย" ระบุไว้ แต่ยังไม่มีจริงใน schema `allwell_sol_test`
--
-- *** รันกับ allwell_sol_test แล้วเมื่อ 2026-08-13 ***
-- เก็บสคริปต์นี้ไว้สำหรับ deploy ฐานข้อมูลอื่น (production / ฐานสำรอง) ที่ยังไม่มีคอลัมน์ชุดนี้
--
-- register_supbrcshos1.php ตรวจสอบคอลัมน์ก่อนเขียนอยู่แล้ว (cs_update_column_if_exists / cs_column_exists)
-- สำหรับ job_no1 / cm_no / install_room จึงปลอดภัยทั้งก่อนและหลังรัน
-- ส่วน pm_year / admin_remark อยู่ใน INSERT ของ hos__subconsig ตรง ๆ (ไม่ได้ guard)
-- ฐานข้อมูลที่ยังไม่รันสคริปต์นี้จะบันทึกรายการสินค้าไม่ได้

-- แท็บ Admin: "เลขที่ลงงาน" (แยกจาก job_no ที่เป็น "เลขที่ลงงานส่ง")
ALTER TABLE hos__consig    ADD COLUMN job_no1      VARCHAR(100) NOT NULL DEFAULT '';

-- แท็บที่อยู่การคืน: "เลขที่ลงงาน" ของรอบรับคืน
ALTER TABLE hos__consig    ADD COLUMN cm_no        VARCHAR(100) NOT NULL DEFAULT '';

-- รายการสินค้า: ช่อง PM(ปี) ในโมดัลแก้ไขรายการ (ฟอร์มส่ง pm_year{i} มาอยู่แล้ว)
ALTER TABLE hos__subconsig ADD COLUMN pm_year      VARCHAR(50)  NOT NULL DEFAULT '';

-- รายการสินค้า: "ชื่อที่แสดงในใบส่งสินค้า" — ฟอร์มส่งมาในชื่อ print_name{i}
ALTER TABLE hos__subconsig ADD COLUMN admin_remark TEXT;

-- แท็บรายละเอียดที่อยู่: "ห้องที่ติดตั้ง" (ตอนนี้เก็บชั่วคราวไว้ที่ tb_transaction.home_type)
ALTER TABLE tb_transaction ADD COLUMN install_room VARCHAR(50)  NOT NULL DEFAULT '';
