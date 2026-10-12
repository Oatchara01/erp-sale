# sql/migrations

รันด้วย `php migrate.php status|up|down|dry-run` หรือเปิด `migrate.php` ในเบราว์เซอร์ (ต้อง login ด้วย user/password ที่ hardcode ต้นไฟล์ `migrate.php`; CLI ไม่ต้อง login — ตรวจชื่อฐานก่อนกดทุกครั้ง)

## กติกา
- ไฟล์คู่ `YYYYMMDDHHMM_ชื่อ.up.sql` + `YYYYMMDDHHMM_ชื่อ.down.sql` — ต้องมี down ทุกไฟล์
- `up` ต้องรันซ้ำได้: เช็ค `information_schema` ก่อน ALTER/CREATE (MySQL ทำ DDL ใน transaction ไม่ได้ ถ้าพังกลางคัน statement ก่อนหน้าไม่ถูกยกเลิก)
- ห้ามใช้ `DELIMITER`/stored program; แยกคำสั่งด้วย `;`
- UPDATE/DELETE ย้อนกลับด้วย down ไม่ได้ — เขียนคอมเมนต์เตือนและ backup ก่อนรัน
- ปกติรันบนฐานขาย (`$conn`); ไฟล์ที่ต้องรันบนฐานอื่นให้ใส่บรรทัด `-- @connection: acc` (ฐานบัญชี `$code`) หรือ `-- @connection: cs` (ฐาน CS `$com1`) ทั้งใน up และ down — หนึ่งไฟล์รันได้ฐานเดียว ใช้ connection จาก `dbconnect_acc.php` / `dbconnect_cs.php` ของเครื่องนั้น และ Dry-run แสดงชื่อฐานที่จะรัน
- ฐานบัญชี/ฐาน CS ไม่ได้ปิด strict mode เหมือนฐานขาย — ถ้า ALTER ตารางที่มี default วันที่ `0000-00-00` ให้ `SET SESSION sql_mode = ''` ต้นไฟล์แล้วคืนค่าท้ายไฟล์
- ไฟล์เก่า `sql/*.sql` ยังรันมือผ่าน phpMyAdmin ตามเดิม
- Rollback ถอยทีละ 1 ไฟล์ (ล่าสุดตามชื่อ)

## ตัวอย่างเพิ่มคอลัมน์ (up)
```sql
SET @s = (SELECT IF(COUNT(*) = 0, 'ALTER TABLE hos__so ADD COLUMN foo TINYINT NOT NULL DEFAULT 0', 'SELECT 1')
          FROM information_schema.columns
          WHERE table_schema = DATABASE() AND table_name = 'hos__so' AND column_name = 'foo');
PREPARE st FROM @s; EXECUTE st; DEALLOCATE PREPARE st;
```
