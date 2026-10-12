-- ปรับค่า hos__consig.send_cs / job_no ของข้อมูลเก่าให้ตรงกับความหมายใหม่ (รันครั้งเดียว หลัง deploy โค้ดชุด brcs_cs_send)
--   send_cs = 0 ยังไม่ส่งเข้าระบบ CS, 2 = ส่งแล้ว — ค่า 1 ไม่ใช้แล้ว
--   เลขที่ลงงานเก็บใน job_no (คอลัมน์เดิมของตาราง) ไม่ใช่ job_no1 ที่หน้า Redesign เคยเขียน
--
-- ฐาน CS ในไฟล์นี้เขียนเป็น allwell_cs_test (ฐานที่ dbconnect_cs.php ของ production ชี้ไป)
-- ถ้ารันที่เครื่องอื่นให้แก้ชื่อฐานให้ตรงก่อน (เครื่อง dev ใช้ allwell_cs)
--
-- รันทีละข้อ และดูผลของ SELECT ก่อนรัน UPDATE ที่อยู่ถัดลงมาทุกครั้ง


-- ---------------------------------------------------------------------------
-- 1) ใบที่มีใบงานของตัวเองอยู่ในระบบ CS แล้ว แต่ send_cs ไม่ใช่ 2
--    (ค่า 2 เคยถูกหน้า BRCS ใหม่เขียนทับเป็น 1/0 ทุกครั้งที่บันทึก)
-- ---------------------------------------------------------------------------
SELECT h.ref_id, h.job_no, h.send_cs
FROM hos__consig h
JOIN allwell_cs_test.tb_register_data r ON r.running = h.job_no AND r.ref_id = h.ref_id
WHERE h.send_cs <> 2 AND h.job_no <> '' AND h.ref_id <> '';

UPDATE hos__consig h
JOIN allwell_cs_test.tb_register_data r ON r.running = h.job_no AND r.ref_id = h.ref_id
SET h.send_cs = 2
WHERE h.send_cs <> 2 AND h.job_no <> '' AND h.ref_id <> '';


-- ---------------------------------------------------------------------------
-- 2) ใบที่ send_cs = 1 ที่เหลือ: ติ๊ก toggle ไว้แต่ไม่เคยมีใบงานในระบบ CS → กลับเป็นยังไม่ส่ง
-- ---------------------------------------------------------------------------
SELECT ref_id, job_no, status_doc, add_date FROM hos__consig WHERE send_cs = 1;

UPDATE hos__consig SET send_cs = 0 WHERE send_cs = 1;


-- ---------------------------------------------------------------------------
-- 3) เลขที่ลงงาน 8 หลักที่ไม่มีใบงานของใบนั้นในระบบ CS และ send_cs ไม่ใช่ 2 (มาจากไอคอน Run เดิม ตั้งแต่ 6907xxxx)
--    ล้างออกเพื่อไม่ให้หน้าจอแสดงเลขที่ไม่ใช่ของตัวเอง
-- ---------------------------------------------------------------------------
SELECT h.ref_id, h.job_no, h.send_cs, h.status_doc
FROM hos__consig h
LEFT JOIN allwell_cs_test.tb_register_data r ON r.running = h.job_no AND r.ref_id = h.ref_id
WHERE h.send_cs <> 2
  AND h.job_no REGEXP '^[0-9]{8}$' AND LEFT(h.job_no, 4) >= '6907'
  AND r.ID IS NULL;

UPDATE hos__consig h
LEFT JOIN allwell_cs_test.tb_register_data r ON r.running = h.job_no AND r.ref_id = h.ref_id
SET h.job_no = ''
WHERE h.send_cs <> 2
  AND h.job_no REGEXP '^[0-9]{8}$' AND LEFT(h.job_no, 4) >= '6907'
  AND r.ID IS NULL;


-- ---------------------------------------------------------------------------
-- 4) (รันเฉพาะเมื่อ production มีคอลัมน์ job_no1 จาก sql/brcshos_optional_columns.sql)
--    job_no1 ที่หน้า Redesign เคยเขียนจากช่อง "เลขที่ลงงาน" ที่พิมพ์เอง ไม่มีใบงานในระบบ CS → ล้าง
--    ถ้า SHOW COLUMNS FROM hos__consig LIKE 'job_no1' ไม่พบแถว ให้ข้ามข้อนี้ทั้งข้อ
-- ---------------------------------------------------------------------------
SELECT h.ref_id, h.job_no, h.job_no1, h.send_cs
FROM hos__consig h
LEFT JOIN allwell_cs_test.tb_register_data r ON r.running = h.job_no1 AND r.ref_id = h.ref_id
WHERE h.job_no1 <> '' AND r.ID IS NULL;

UPDATE hos__consig h
LEFT JOIN allwell_cs_test.tb_register_data r ON r.running = h.job_no1 AND r.ref_id = h.ref_id
SET h.job_no1 = ''
WHERE h.job_no1 <> '' AND r.ID IS NULL;
