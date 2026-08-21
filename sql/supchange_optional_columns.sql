-- ใบแลกเปลี่ยนสินค้า / Change Order (register_supchange.php / register_supchange1.php)
-- คอลัมน์ที่ Google Sheet ชีต "ใบแลกเปลี่ยนสินค้า" ระบุว่า "เพิ่มใหม่" และยังไม่มีจริงใน schema `allwell_sol_test`
--
-- register_supchange1.php เขียนคอลัมน์ชุดนี้ผ่าน cs_update_column_if_exists() ทั้งหมด
-- จึงปลอดภัยทั้งก่อนและหลังรันสคริปต์ (ก่อนรัน = ข้ามเงียบ ๆ, หลังรัน = เริ่มบันทึกเองโดยไม่ต้องแก้โค้ด)
--
-- คอลัมน์อื่นที่ชีตระบุมีอยู่แล้วครบ จึงไม่ต้อง ALTER:
--   hos__change    : iv_no, iv_date, job_no, send_cs, date_ker,
--                    order_refer_code, order_refer_code1, ker_bath, slip1..slip5
--   hos__subchange : product_id, product_code, count_stock, count_sale, price, amount, sn, sale_remark
--   tb_register_data : transport_company, location_link
-- และ tb_transaction ไม่มีคอลัมน์ addr_note (ชีตระบุคลาดเคลื่อน) — ลง tb_transaction.description
-- ตาม convention เดียวกับ register_supbrhos1.php / register_supbrcshos1.php

-- แท็บข้อมูลเอกสาร: toggle "งานด่วน"
ALTER TABLE hos__change ADD COLUMN que_ckk INT NOT NULL DEFAULT 0;

-- แท็บ Admin: ปุ่ม "ยกเลิกเอกสาร" (คู่กับ status_doc = 'ยกเลิก' ที่เขียนอยู่แล้ว)
ALTER TABLE hos__change ADD COLUMN is_cancel INT NOT NULL DEFAULT 0;

-- แท็บ Admin: "หมายเหตุการยกเลิก"
ALTER TABLE hos__change ADD COLUMN remark_cancel VARCHAR(400) NOT NULL DEFAULT '';
