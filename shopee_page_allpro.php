<?php
$secret_key = "010554107248319112541";

// ตรวจสอบว่าได้รับ key ที่ถูกต้องหรือไม่
if (!isset($_GET['key']) || $_GET['key'] !== $secret_key) {
    http_response_code(403);

    // ส่งอีเมลแจ้งเตือนเมื่อมีการเข้าถึงโดยไม่ได้รับอนุญาต
    $to = "prmline@allwelllifegroup.com";
    $subject = "⚠️ Cron Job Failed: Unauthorized Access";
    $message = "Someone tried to access cron_page.php GET ORDER SHOPEE with an incorrect key on " . date("Y-m-d H:i:s");
    $headers = "From: no-reply@yourwebsite.com\r\n" . 
               "MIME-Version: 1.0\r\n" . 
               "Content-Type: text/plain; charset=UTF-8\r\n";

    // ใช้ @ ป้องกัน Error ถ้า mail() ไม่ทำงาน
    @mail($to, $subject, $message, $headers);

    die("Unauthorized access!");
}

// บันทึก Log การทำงานลงไฟล์ "cron_log.txt"
$log_file = "cron_log.txt";
$log_message = date("Y-m-d H:i:s") . " - Cron Job executed successfully!\n";

// ใช้ @ ป้องกัน Error ถ้า file_put_contents ไม่ทำงาน
@file_put_contents($log_file, $log_message, FILE_APPEND);

// ส่งอีเมลแจ้งเตือนเมื่อ Cron Job ทำงานสำเร็จ
$to = "prmline@allwelllifegroup.com";
$subject = "✅ Cron Job Executed Successfully";
$message = "Cron Job  GET ORDER SHOPEE ran successfully on " . date("Y-m-d H:i:s");
$headers = "From: no-reply@yourwebsite.com\r\n" . 
           "MIME-Version: 1.0\r\n" . 
           "Content-Type: text/plain; charset=UTF-8\r\n";

// ใช้ @ ป้องกัน Error ถ้า mail() ไม่ทำงาน
@mail($to, $subject, $message, $headers);

// รวมไฟล์ PHP อื่น (ตรวจสอบก่อนว่ามีไฟล์จริงหรือไม่)
$file_to_include = "getOrdershopee_allpro.php";
if (file_exists($file_to_include)) {
    include $file_to_include;
} else {
    file_put_contents($log_file, date("Y-m-d H:i:s") . " - Error: File not found: $file_to_include\n", FILE_APPEND);
}

echo "Cron Job executed successfully!";
?>




?>
