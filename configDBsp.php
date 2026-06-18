<?php

function OpenCon()
{
    $servername = "localhost"; // ถ้าใช้ Docker ให้แทนที่ด้วย 'db'
    $username = "allwell_itadmin";
    $password = "Pass@2020";
    $dbname = "allwell_sol";

    // สร้างการเชื่อมต่อฐานข้อมูล
    $conn = new mysqli($servername, $username, $password, $dbname);

    // ตรวจสอบว่าการเชื่อมต่อสำเร็จหรือไม่
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // กำหนดให้ฐานข้อมูลอ่านเขียนเป็น utf8
    $conn->set_charset("utf8");

    return $conn;
}

function CloseCon($conn)
{
    if ($conn) {
        $conn->close();
    }
}

?>
