-- ใบเบิกเครื่องและอะไหล่ (SPR) — คอลัมน์/ดัชนีที่หน้าฟอร์มใหม่ต้องใช้
-- (register_engspr.php / register_engspr1.php โหมด v2 / register_engspr_draft1.php)
--
-- includes/spr_repo.php เขียน sort_order ผ่าน spr_column_exists() ทั้งหมด จึงปลอดภัย
-- ทั้งก่อนและหลังรันสคริปต์นี้:
--   ก่อนรัน  = ข้ามคอลัมน์ sort_order เงียบ ๆ ลำดับรายการกลับไปเรียงตาม id เหมือนเดิม
--   หลังรัน  = เริ่มเก็บ/อ่านลำดับที่ผู้ใช้ลากจัดเรียงไว้เองโดยไม่ต้องแก้โค้ดอีก
--
-- คอลัมน์หัวเอกสารใหม่ (per_return_no / damage_detail / warehouse_action / warehouse_note)
-- ก็ผ่าน spr_column_exists() เช่นกัน — ฐานที่ยังไม่รันสคริปต์นี้จะแค่ไม่บันทึก/ไม่แสดง
-- ช่องเหล่านี้ แต่หน้าฟอร์ม/รายงานอื่นยังใช้งานได้ปกติ

-- ลำดับรายการในเอกสาร (ผู้ใช้ลากจัดเรียงได้ในฟอร์มใหม่)
ALTER TABLE hos__subspr ADD COLUMN sort_order INT NOT NULL DEFAULT 0;

-- จำนวนปีรับประกันของแต่ละรายการสินค้าใน SPR
ALTER TABLE hos__subspr ADD COLUMN warranty_year DECIMAL(5,2) NOT NULL DEFAULT 0;

-- ดัชนีสำหรับโหลด/พิมพ์รายการตามลำดับ
ALTER TABLE hos__subspr ADD KEY idx_subspr_ref_sort (ref_idd, sort_order);

-- PER ช่องที่สอง (Figma มี 2 ช่อง, schema เดิมมี per_no ช่องเดียว)
ALTER TABLE hos__spr ADD COLUMN per_return_no VARCHAR(100) NOT NULL DEFAULT '';

-- รายละเอียดการชำรุด แยกจาก pro_des เดิม (ซึ่งเก็บ "อาการเสีย" ของเครื่อง ไม่ใช่รายละเอียด
-- อะไหล่คืนตามตัวเลือก pro_ckk='2'/'3')
ALTER TABLE hos__spr ADD COLUMN damage_detail TEXT NULL;

-- หมายเหตุทั่วไปของเอกสาร SPR
ALTER TABLE hos__spr ADD COLUMN note TEXT NULL;

-- ส่วน "สำหรับคลังสินค้า" ใน Figma — ยังไม่มีคอลัมน์รองรับใน schema เดิม
ALTER TABLE hos__spr ADD COLUMN warehouse_action VARCHAR(50) NOT NULL DEFAULT '';
ALTER TABLE hos__spr ADD COLUMN warehouse_note TEXT NULL;

-- กันเลข SPR ชนกันเมื่อมีคนกดบันทึกพร้อมกัน (spr_reserve_ref_id() พึ่ง unique key ตัวนี้
-- เป็นด่านสุดท้าย: ถ้า INSERT ชนก็วนหาเลขถัดไปใหม่แทนที่จะเขียนทับเอกสารของคนอื่น)
--
-- หมายเหตุก่อนรันบนฐานจริง: ถ้ามี ref_id ซ้ำค้างอยู่ ALTER นี้จะ error
-- ให้ตรวจก่อนด้วย
--   SELECT ref_id, COUNT(*) c FROM hos__spr GROUP BY ref_id HAVING c > 1;
-- แล้วแก้ข้อมูลซ้ำให้เรียบร้อยก่อน จึงค่อยรันบรรทัดล่างนี้
ALTER TABLE hos__spr ADD UNIQUE KEY uk_spr_ref_id (ref_id);
