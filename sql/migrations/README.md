# sql/migrations

รันด้วย `php migrate.php status|up|down|dry-run` หรือเปิด `migrate.php` ในเบราว์เซอร์ (ต้อง login ด้วย user/password ที่ hardcode ต้นไฟล์ `migrate.php`; CLI ไม่ต้อง login — ตรวจชื่อฐานก่อนกดทุกครั้ง)

## กติกา
- ไฟล์คู่ `YYYYMMDDHHMM_ชื่อ.up.sql` + `YYYYMMDDHHMM_ชื่อ.down.sql` — ต้องมี down ทุกไฟล์
- `up` ต้องรันซ้ำได้: เช็ค `information_schema` ก่อน ALTER/CREATE (MySQL ทำ DDL ใน transaction ไม่ได้ ถ้าพังกลางคัน statement ก่อนหน้าไม่ถูกยกเลิก)
- ห้ามใช้ `DELIMITER`/stored program; แยกคำสั่งด้วย `;`
- UPDATE/DELETE ย้อนกลับด้วย down ไม่ได้ — เขียนคอมเมนต์เตือนและ backup ก่อนรัน
- ไม่ครอบคลุมฐาน CS (`$com1`); ไฟล์เก่า `sql/*.sql` ยังรันมือผ่าน phpMyAdmin ตามเดิม
- Rollback ถอยทีละ 1 ไฟล์ (ล่าสุดตามชื่อ)

## ตัวอย่างเพิ่มคอลัมน์ (up)
```sql
SET @s = (SELECT IF(COUNT(*) = 0, 'ALTER TABLE hos__so ADD COLUMN foo TINYINT NOT NULL DEFAULT 0', 'SELECT 1')
          FROM information_schema.columns
          WHERE table_schema = DATABASE() AND table_name = 'hos__so' AND column_name = 'foo');
PREPARE st FROM @s; EXECUTE st; DEALLOCATE PREPARE st;
```
