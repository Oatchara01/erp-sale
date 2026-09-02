-- ใบสั่งเช่า / Rental Order (register_suprental.php / register_suprental1.php)
-- คอลัมน์ที่ Google Sheet ชีต "ใบสั่งเช่า" ระบุว่ามีอยู่ใน hos__rental แต่ตรวจสอบ schema จริงแล้วไม่มี
--
-- หมายเหตุการตั้งชื่อ: ชีตเดิมแนะนำให้ "หมายเหตุการยกเลิก" ใช้ column status_doc และ
-- "ยกเลิกเอกสาร (hidden flag)" ใช้ column remark_cancel — แต่ status_doc เป็น column สถานะ
-- workflow ที่ใช้ร่วมกับหน้าจออื่นอยู่แล้ว (send_sup/send_admin/ฯลฯ) จึงเลี่ยงไม่แตะ status_doc
-- และแยกเป็นคอลัมน์ใหม่ 2 ตัวแทน: remark_cancel (ข้อความเหตุผลยกเลิก) และ cancel_flag (toggle 0/1)
--
-- คอลัมน์อื่นที่ชีตระบุมีอยู่แล้วครบ จึงไม่ต้อง ALTER: type_product, des_productunit

ALTER TABLE hos__rental
  ADD COLUMN have_order TINYINT(1) NOT NULL DEFAULT 0 AFTER type_product,
  ADD COLUMN sr_no VARCHAR(50) NOT NULL DEFAULT '' AFTER iv_date,
  ADD COLUMN order_no VARCHAR(50) NOT NULL DEFAULT '' AFTER sr_no,
  ADD COLUMN new_bill INT NOT NULL DEFAULT 0 AFTER order_no,
  ADD COLUMN date_oldbill DATE NULL DEFAULT NULL AFTER new_bill,
  ADD COLUMN desnew_bill VARCHAR(255) NOT NULL DEFAULT '' AFTER date_oldbill,
  ADD COLUMN remark_cancel TEXT NULL AFTER desnew_bill,
  ADD COLUMN cancel_flag TINYINT(1) NOT NULL DEFAULT 0 AFTER remark_cancel;

-- แท็บ "ค่าจัดส่ง" (shipping_date/shipping_ref1/shipping_ref2/shipping_cost)
-- ใช้ชื่อ column เดียวกับ sibling table hos__change ที่มีฟิลด์เทียบเท่าอยู่แล้ว เพื่อความสอดคล้องกันทั้งระบบ
-- date_ker เป็น NULL ได้ (ต่างจาก hos__change.date_ker ที่ตั้ง NOT NULL แต่ไม่มี default ใช้งานได้จริงภายใต้ strict mode ปัจจุบัน)
ALTER TABLE hos__rental
  ADD COLUMN date_ker DATE NULL DEFAULT NULL AFTER cancel_flag,
  ADD COLUMN order_refer_code VARCHAR(100) NOT NULL DEFAULT '' AFTER date_ker,
  ADD COLUMN order_refer_code1 VARCHAR(100) NOT NULL DEFAULT '' AFTER order_refer_code,
  ADD COLUMN ker_bath DECIMAL(20,2) NOT NULL DEFAULT 0.00 AFTER order_refer_code1;

-- แท็บ "ข้อมูลผู้เช่า" ส่วนที่อยู่แยกละเอียด (rental_addr_detail/province/district/zipcode/referrer/repeat_cus)
ALTER TABLE hos__rental
  ADD COLUMN rental_addr_detail TEXT NULL AFTER rental_address,
  ADD COLUMN rental_province VARCHAR(150) NOT NULL DEFAULT '' AFTER rental_addr_detail,
  ADD COLUMN rental_district VARCHAR(150) NOT NULL DEFAULT '' AFTER rental_province,
  ADD COLUMN rental_zipcode VARCHAR(10) NOT NULL DEFAULT '' AFTER rental_district,
  ADD COLUMN rental_referrer VARCHAR(300) NOT NULL DEFAULT '' AFTER rental_zipcode,
  ADD COLUMN rental_repeat_cus TINYINT(1) NOT NULL DEFAULT 0 AFTER rental_referrer;
