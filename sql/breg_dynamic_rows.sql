-- ใบขอเบิกอะไหล่จากสินค้าขาย (BREG) — คอลัมน์/ดัชนีที่หน้าฟอร์มใหม่ต้องใช้
-- (register_bregawl.php / register_bregawl_draft1.php / register_breg1.php โหมด v2)
--
-- includes/breg_repo.php เขียน sort_order ผ่าน breg_column_exists() ทั้งหมด
-- จึงปลอดภัยทั้งก่อนและหลังรันสคริปต์นี้:
--   ก่อนรัน  = ข้ามคอลัมน์ sort_order เงียบ ๆ ลำดับรายการกลับไปเรียงตาม id_sub เหมือนเดิม
--   หลังรัน  = เริ่มเก็บ/อ่านลำดับที่ผู้ใช้ลากจัดเรียงไว้เองโดยไม่ต้องแก้โค้ดอีก

-- ลำดับรายการในเอกสาร (ผู้ใช้ลากจัดเรียงได้ในฟอร์มใหม่)
ALTER TABLE hos__subbreg1 ADD COLUMN sort_order INT NOT NULL DEFAULT 0;
ALTER TABLE hos__subbreg2 ADD COLUMN sort_order INT NOT NULL DEFAULT 0;

-- ดัชนีสำหรับโหลด/พิมพ์รายการตามลำดับ
ALTER TABLE hos__subbreg1 ADD KEY idx_subbreg1_ref_sort (ref_id1, sort_order);
ALTER TABLE hos__subbreg2 ADD KEY idx_subbreg2_ref_sort (ref_id2, sort_order);

-- กันเลข RG ชนกันเมื่อมีคนกดบันทึกพร้อมกัน (breg_reserve_ref_id() พึ่ง unique key ตัวนี้
-- เป็นด่านสุดท้าย: ถ้า INSERT ชนก็วนหาเลขถัดไปใหม่แทนที่จะเขียนทับเอกสารของคนอื่น)
--
-- หมายเหตุก่อนรันบนฐานจริง: ถ้ามี ref_id ซ้ำค้างอยู่ ALTER นี้จะ error
-- ให้ตรวจก่อนด้วย
--   SELECT ref_id, COUNT(*) c FROM hos__breg GROUP BY ref_id HAVING c > 1;
-- แล้วแก้ข้อมูลซ้ำให้เรียบร้อยก่อน จึงค่อยรันบรรทัดล่างนี้
ALTER TABLE hos__breg ADD UNIQUE KEY uk_breg_ref_id (ref_id);
