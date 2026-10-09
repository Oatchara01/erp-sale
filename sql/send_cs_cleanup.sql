-- ปรับค่า hos__so.send_cs / job_no ของข้อมูลเก่าให้ตรงกับความหมายใหม่ (รันครั้งเดียว หลัง deploy โค้ดชุด so_cs_send)
--   send_cs = 0 ยังไม่ส่งเข้าระบบ CS, 2 = ส่งแล้ว — ค่า 1 ไม่ใช้แล้ว
--
-- ฐาน CS ในไฟล์นี้เขียนเป็น allwell_cs_test (ฐานที่ dbconnect_cs.php ของ production ชี้ไป)
-- ถ้ารันที่เครื่องอื่นให้แก้ชื่อฐานให้ตรงก่อน (เครื่อง dev ใช้ allwell_cs)
--
-- รันทีละข้อ และดูผลของ SELECT ก่อนรัน UPDATE ที่อยู่ถัดลงมาทุกครั้ง


-- ---------------------------------------------------------------------------
-- 1) ใบที่มีใบงานของตัวเองอยู่ในระบบ CS แล้ว แต่ send_cs ไม่ใช่ 2
--    (ค่า 2 เคยถูกหน้า SO ใหม่เขียนทับเป็น 1/0 ทุกครั้งที่บันทึก)
-- ---------------------------------------------------------------------------
SELECT s.ref_id, s.job_no, s.send_cs
FROM hos__so s
JOIN allwell_cs_test.tb_register_data r ON r.running = s.job_no AND r.ref_id = s.ref_id
WHERE s.send_cs <> 2 AND s.job_no <> '' AND s.ref_id <> '';

UPDATE hos__so s
JOIN allwell_cs_test.tb_register_data r ON r.running = s.job_no AND r.ref_id = s.ref_id
SET s.send_cs = 2
WHERE s.send_cs <> 2 AND s.job_no <> '' AND s.ref_id <> '';


-- ---------------------------------------------------------------------------
-- 2) ใบที่ send_cs = 1 ที่เหลือ: ติ๊ก toggle ไว้แต่ไม่เคยมีใบงานในระบบ CS → กลับเป็นยังไม่ส่ง
-- ---------------------------------------------------------------------------
SELECT ref_id, job_no, status_doc, add_date FROM hos__so WHERE send_cs = 1;

UPDATE hos__so SET send_cs = 0 WHERE send_cs = 1;


-- ---------------------------------------------------------------------------
-- 3) เลขที่ลงงานที่ไอคอน Run เดิมของหน้า SO ออกให้ (ตั้งแต่ ก.ค. 2569 = 6907xxxx เป็นต้นมา)
--    เลขชุดนี้นับจากตัวนับผิดฐาน จึงไม่มีใบงานของ SO ใบนั้นในระบบ CS และอาจตรงกับใบงานของเอกสารอื่น
--    ล้างออกเพื่อไม่ให้หน้าจอแสดงเลขที่ไม่ใช่ของตัวเอง — ถ้าไม่ล้าง โค้ดใหม่ก็จะออกเลขใหม่ทับให้ตอนส่งอยู่ดี
-- ---------------------------------------------------------------------------
SELECT s.ref_id, s.job_no, s.send_cs, s.status_doc
FROM hos__so s
LEFT JOIN allwell_cs_test.tb_register_data r ON r.running = s.job_no AND r.ref_id = s.ref_id
WHERE s.send_cs <> 2
  AND s.job_no REGEXP '^[0-9]{8}$' AND LEFT(s.job_no, 4) >= '6907'
  AND r.ID IS NULL;

UPDATE hos__so s
LEFT JOIN allwell_cs_test.tb_register_data r ON r.running = s.job_no AND r.ref_id = s.ref_id
SET s.job_no = ''
WHERE s.send_cs <> 2
  AND s.job_no REGEXP '^[0-9]{8}$' AND LEFT(s.job_no, 4) >= '6907'
  AND r.ID IS NULL;
