-- ใบสั่งเช่า (register_suprental1.php / register_suprental_edit1.php)
-- คอลัมน์ tb_transaction.install_room ที่ INSERT ใช้ตรง ๆ (ไม่ guard) แต่ยังไม่มีจริงในบาง schema
--
-- เก็บสคริปต์นี้ไว้สำหรับ deploy ฐานข้อมูลอื่น (production / ฐานสำรอง) ที่ยังไม่มีคอลัมน์นี้
-- ฐานข้อมูลที่ยังไม่รันสคริปต์นี้จะบันทึกใบสั่งเช่าไม่ได้ (Unknown column 'install_room' in 'INSERT INTO')
--
-- หมายเหตุ: คอลัมน์เดียวกันนี้ถูก ALTER ไว้แล้วใน sql/brcshos_optional_columns.sql
-- (รันกับ allwell_sol_test เมื่อ 2026-08-13) — อย่ารันสคริปต์นี้ซ้ำกับฐานที่รันไฟล์นั้นไปแล้ว

ALTER TABLE tb_transaction ADD COLUMN install_room VARCHAR(50) NOT NULL DEFAULT '';
