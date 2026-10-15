-- ปรับ hos__change.send_cs / job_no ของข้อมูลเก่าให้ตรงกับความหมายใหม่ (หลัง deploy โค้ดชุด chg_cs_send) — ฐานขาย ($conn)
--   send_cs = 0 ยังไม่ส่งเข้าระบบ CS, 2 = ส่งแล้ว — ค่า 1 ไม่ใช้แล้ว
--   เลขที่ลงงานเก็บใน job_no ออกโดยระบบตอนบันทึกเท่านั้น (เลิกใช้ไอคอน Run เลขที่ลงงาน)
--
-- ข้อมูลเปลี่ยนถาวร (UPDATE ย้อนกลับด้วย down ไม่ได้) — backup hos__change ก่อนรัน และดู Dry-run ก่อน
-- ขั้น 1 และ 3 ต้องอ่านใบงานในฐาน CS ข้ามฐานจากฐานขาย: หาชื่อฐาน CS จาก information_schema
-- (production = allwell_cs_test, local = allwell_cs) ถ้าไม่พบทั้งสองชื่อจะข้ามขั้น 1 และ 3
-- ขั้น 2 อยู่ในฐานขายอย่างเดียว ทำเสมอ

SET @cs_db = (SELECT schema_name FROM information_schema.schemata
              WHERE schema_name IN ('allwell_cs_test', 'allwell_cs')
              ORDER BY schema_name = 'allwell_cs_test' DESC LIMIT 1);

-- 1) ใบที่มีใบงานของตัวเองอยู่ในระบบ CS แล้ว (running = job_no และ ref_id ตรงกัน) แต่ send_cs ไม่ใช่ 2 -> ตั้งเป็น 2
--    (ค่า 2 ที่หน้า Admin เดิมตั้งไว้ เคยถูกหน้าใบแลกเปลี่ยนใหม่เขียนทับเป็น 1/0 ทุกครั้งที่บันทึก)
SET @s = IF(@cs_db IS NULL, 'SELECT 1',
  CONCAT('UPDATE hos__change h JOIN `', @cs_db, '`.tb_register_data r ON r.running = h.job_no AND r.ref_id = h.ref_id ',
         'SET h.send_cs = 2 WHERE h.send_cs <> 2 AND h.job_no <> '''' AND h.ref_id <> '''''));
PREPARE st FROM @s; EXECUTE st; DEALLOCATE PREPARE st;

-- 2) send_cs = 1 ที่เหลือ: ติ๊ก toggle ไว้แต่ไม่เคยมีใบงานในระบบ CS -> กลับเป็นยังไม่ส่ง
UPDATE hos__change SET send_cs = 0 WHERE send_cs = 1;

-- 3) เลขที่ลงงาน 8 หลัก (ตั้งแต่ 6907xxxx) ที่ไม่มีใบงานของใบนั้นในระบบ CS และ send_cs ไม่ใช่ 2 (มาจากไอคอน Run เดิม) -> ล้างออก
SET @s = IF(@cs_db IS NULL, 'SELECT 1',
  CONCAT('UPDATE hos__change h LEFT JOIN `', @cs_db, '`.tb_register_data r ON r.running = h.job_no AND r.ref_id = h.ref_id ',
         'SET h.job_no = '''' WHERE h.send_cs <> 2 AND h.job_no REGEXP ''^[0-9]{8}$'' AND LEFT(h.job_no, 4) >= ''6907'' AND r.ID IS NULL'));
PREPARE st FROM @s; EXECUTE st; DEALLOCATE PREPARE st;
