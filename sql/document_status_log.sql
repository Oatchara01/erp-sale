-- ตาราง log เหตุผลของการเปลี่ยนสถานะเอกสาร (ส่งกลับ / ไม่อนุมัติ / ยกเลิก ฯลฯ)
-- ใช้กับ register_suprental.php / register_suprental_edit1.php (hos__rental) เป็นจุดแรก
-- เก็บได้หลายรอบต่อเอกสาร (append-only) ผูกกับเอกสารผ่าน ref_id เท่านั้น (ไม่มี doc_type
-- เพราะ ref_id ของแต่ละประเภทเอกสารมี prefix เฉพาะตัวอยู่แล้วจึงไม่ชนกัน)

CREATE TABLE tb_document_status_log (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    ref_id      VARCHAR(100) NOT NULL,      -- อ้างอิง hos__rental.ref_id
    status_doc  VARCHAR(50)  NOT NULL,      -- สถานะ/การกระทำที่บันทึก เช่น 'ส่งกลับ','Rejected','Cancelled'
    reason      TEXT         NOT NULL,      -- เหตุผลที่กรอกใน modal
    user_id     VARCHAR(50)  NULL,          -- $_SESSION['UserID']
    user_name   VARCHAR(255) NULL,          -- snapshot ชื่อ-สกุลผู้ทำรายการ ณ ขณะนั้น
    created_at  DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_ref (ref_id),
    INDEX idx_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
