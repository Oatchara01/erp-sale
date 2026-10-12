-- ปรับค่า hos__rental.send_cs / job_no ของข้อมูลเก่าให้ตรงกับความหมายใหม่ (รันครั้งเดียว หลัง deploy โค้ดชุด rental_cs_send)
--   send_cs = 0 ยังไม่ส่งเข้าระบบ CS, 2 = ส่งแล้ว — ค่า 1 ไม่ใช้แล้ว
--
-- ฐาน CS ในไฟล์นี้เขียนเป็น allwell_cs_test (ฐานที่ dbconnect_cs.php ของ production ชี้ไป)
-- ถ้ารันที่เครื่องอื่นให้แก้ชื่อฐานให้ตรงก่อน (เครื่อง dev ใช้ allwell_cs)
--
-- รันทีละข้อ และดูผลของ SELECT ก่อนรัน UPDATE ที่อยู่ถัดลงมาทุกครั้ง
-- ข้อ 3 ต่างจาก SO: โค้ดเดิมของใบเช่าตั้ง send_cs = 2 ทั้งที่เขียนใบงานผิดฐาน (ฐานขาย) CS จึงไม่เคยเห็นใบงาน


-- ---------------------------------------------------------------------------
-- 1) ใบที่มีใบงานของตัวเองอยู่ในระบบ CS แล้ว แต่ send_cs ไม่ใช่ 2
-- ---------------------------------------------------------------------------
SELECT h.ref_id, h.job_no, h.send_cs
FROM hos__rental h
JOIN allwell_cs_test.tb_register_data r ON r.running = h.job_no AND r.ref_id = h.ref_id
WHERE h.send_cs <> 2 AND h.job_no <> '' AND h.ref_id <> '';

UPDATE hos__rental h
JOIN allwell_cs_test.tb_register_data r ON r.running = h.job_no AND r.ref_id = h.ref_id
SET h.send_cs = 2
WHERE h.send_cs <> 2 AND h.job_no <> '' AND h.ref_id <> '';


-- ---------------------------------------------------------------------------
-- 2) ใบที่ send_cs = 1 ที่เหลือ: ติ๊ก toggle ไว้แต่ไม่เคยมีใบงานในระบบ CS → กลับเป็นยังไม่ส่ง
-- ---------------------------------------------------------------------------
SELECT ref_id, job_no, status_doc, add_date FROM hos__rental WHERE send_cs = 1;

UPDATE hos__rental SET send_cs = 0 WHERE send_cs = 1;


-- ---------------------------------------------------------------------------
-- 3) ใบที่ send_cs = 2 แต่ไม่มีใบงานของตัวเองในระบบ CS (โค้ดเดิมเขียนใบงานลงฐานขาย)
--    ปลดเป็นยังไม่ส่ง และล้างเลขที่ลงงาน เพื่อให้ Admin ติ๊ก toggle ส่งใหม่ได้
--    ดูผล SELECT ให้ดีก่อน: ใบที่ CS ลงงานเองด้วยมือโดยไม่ได้ผูก ref_id ก็จะอยู่ในรายการนี้
--    (ใบที่ปิดเช่าแล้วก็ถูกปลดด้วย ถ้าไม่ต้องการให้เติม AND h.status_doc NOT IN (...) ตามต้องการ)
-- ---------------------------------------------------------------------------
SELECT h.ref_id, h.job_no, h.send_cs, h.status_doc
FROM hos__rental h
LEFT JOIN allwell_cs_test.tb_register_data r ON r.running = h.job_no AND r.ref_id = h.ref_id
WHERE h.send_cs = 2 AND r.ID IS NULL;

UPDATE hos__rental h
LEFT JOIN allwell_cs_test.tb_register_data r ON r.running = h.job_no AND r.ref_id = h.ref_id
SET h.send_cs = 0, h.job_no = ''
WHERE h.send_cs = 2 AND r.ID IS NULL;


-- ---------------------------------------------------------------------------
-- 4) เลขที่ลงงาน 8 หลักที่ไอคอน Run เดิมออกให้ (ตั้งแต่ ก.ค. 2569 = 6907xxxx) ที่ไม่มีใบงานของใบเช่านั้นในระบบ CS
--    นับจากตัวนับผิดฐาน อาจตรงกับใบงานของเอกสารอื่น ล้างออก
-- ---------------------------------------------------------------------------
SELECT h.ref_id, h.job_no, h.send_cs, h.status_doc
FROM hos__rental h
LEFT JOIN allwell_cs_test.tb_register_data r ON r.running = h.job_no AND r.ref_id = h.ref_id
WHERE h.send_cs <> 2
  AND h.job_no REGEXP '^[0-9]{8}$' AND LEFT(h.job_no, 4) >= '6907'
  AND r.ID IS NULL;

UPDATE hos__rental h
LEFT JOIN allwell_cs_test.tb_register_data r ON r.running = h.job_no AND r.ref_id = h.ref_id
SET h.job_no = ''
WHERE h.send_cs <> 2
  AND h.job_no REGEXP '^[0-9]{8}$' AND LEFT(h.job_no, 4) >= '6907'
  AND r.ID IS NULL;
