-- ใบสั่งเช่า (hos__rental) — เงินประกันที่ผู้ใช้กดแก้ได้บน summary bar ของ product_rentalawl.php
-- ใช้โดย register_suprental1.php / register_suprental_edit1.php (บันทึก) และ
-- register_suphos.php?from_rental=...&type=AI (ราคาสินค้าเงินประกัน 5111)
--
-- เป็น statement เดียวเพื่อให้รันได้ทุก client (รวม Ctrl+Enter ใน DBeaver)
-- ถ้ารันซ้ำจะได้ error 1060 "Duplicate column name 'deposit_amount'" = มีคอลัมน์อยู่แล้ว ข้ามได้เลย
--
-- deposit_amount
--   NULL  = เอกสารเก่าที่ยังไม่เคยบันทึกเงินประกัน — ใบ AI คำนวณ SUM(hos__subrental.amount) x 2 แบบเดิม
--   ค่าอื่น = เงินประกันตามที่หน้า register_suprental.php โพสต์มา (auto x2 หรือค่าที่ผู้ใช้แก้เอง)

ALTER TABLE hos__rental
  ADD COLUMN deposit_amount DECIMAL(20,2) NULL DEFAULT NULL AFTER ker_bath;
