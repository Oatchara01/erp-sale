<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("dbconnect.php");
include("head.php");
date_default_timezone_set("Asia/Bangkok");

if (!$conn) {
    die("Database connection failed");
}

if ($_POST["submit"] = "submit") {

    $customer_id   = mysqli_real_escape_string($conn, $_POST["customer_id"] ?? '');
    $customer_name = mysqli_real_escape_string($conn, $_POST["customer_name"] ?? '');
    $remark_edit   = mysqli_real_escape_string($conn, $_POST["remark_edit"] ?? '');

    $add_date = date('Y-m-d H:i:s');
    $name     = $_SESSION["name"] ?? '';
    $surname  = $_SESSION["surname"] ?? '';
    $add_by   = trim($name . " " . $surname);

    $credit_ckk = mysqli_real_escape_string($conn, $_POST["credit_ckk"] ?? '');
    $credit_thb = str_replace(',', '', $_POST["credit_thb"] ?? '');

    // รับชื่อรูปเดิมจาก hidden field
    $img_up1 = $_POST["img_up_1"] ?? '';
    $img_up2 = $_POST["img_up_2"] ?? '';
    $img_up3 = $_POST["img_up_3"] ?? '';

    // สร้างโฟลเดอร์ถ้ายังไม่มี
    $upload_dir = "up_cuscredit/";
    if (!is_dir($upload_dir)) {
        if (!mkdir($upload_dir, 0777, true)) {
            die("ไม่สามารถสร้างโฟลเดอร์อัปโหลดได้");
        }
    }

    // =========================
    // Upload img_up1
    // =========================
    if (isset($_FILES['img_up1']) && $_FILES['img_up1']['size'] > 0) {
        if ($_FILES['img_up1']['size'] > 1100000) {
            echo "<script>alert('กรุณาแนบไฟล์ที่มีขนาดน้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
            exit();
        } else {
            $temp1 = explode(".", $_FILES["img_up1"]["name"]);
            $ext1  = strtolower(end($temp1));
            $img_up1 = "img_up1_" . $customer_id . "_" . round(microtime(true)) . "." . $ext1;

            if (!move_uploaded_file($_FILES["img_up1"]["tmp_name"], $upload_dir . $img_up1)) {
                die("อัปโหลดไฟล์ img_up1 ไม่สำเร็จ");
            }
        }
    }

    // =========================
    // Upload img_up2
    // =========================
    if (isset($_FILES['img_up2']) && $_FILES['img_up2']['size'] > 0) {
        if ($_FILES['img_up2']['size'] > 1100000) {
            echo "<script>alert('กรุณาแนบไฟล์ที่มีขนาดน้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
            exit();
        } else {
            $temp2 = explode(".", $_FILES["img_up2"]["name"]);
            $ext2  = strtolower(end($temp2));
            $img_up2 = "img_up2_" . $customer_id . "_" . round(microtime(true)) . "." . $ext2;

            if (!move_uploaded_file($_FILES["img_up2"]["tmp_name"], $upload_dir . $img_up2)) {
                die("อัปโหลดไฟล์ img_up2 ไม่สำเร็จ");
            }
        }
    }

    // =========================
    // Upload img_up3
    // =========================
    if (isset($_FILES['img_up3']) && $_FILES['img_up3']['size'] > 0) {
        if ($_FILES['img_up3']['size'] > 1100000) {
            echo "<script>alert('กรุณาแนบไฟล์ที่มีขนาดน้อยกว่าหรือเท่ากับ 1 MB');history.back();</script>";
            exit();
        } else {
            $temp3 = explode(".", $_FILES["img_up3"]["name"]);
            $ext3  = strtolower(end($temp3));
            $img_up3 = "img_up3_" . $customer_id . "_" . round(microtime(true)) . "." . $ext3;

            if (!move_uploaded_file($_FILES["img_up3"]["tmp_name"], $upload_dir . $img_up3)) {
                die("อัปโหลดไฟล์ img_up3 ไม่สำเร็จ");
            }
        }
    }

    // =========================
    // บันทึกลง tb_customer_credit
    // =========================
    $save = "INSERT INTO tb_customer_credit
        (
            customer_id,
            credit_ckk,
            credit_thb,
            customer_name,
            add_by,
            add_date,
            status_credit,
            img_up1,
            img_up2,
            img_up3,
            remark_edit
        )
        VALUES
        (
            '".$customer_id."',
            '".$credit_ckk."',
            '".$credit_thb."',
            '".$customer_name."',
            '".$add_by."',
            '".$add_date."',
            'Request',
            '".$img_up1."',
            '".$img_up2."',
            '".$img_up3."',
            '".$remark_edit."'
        )";

    $qsave = mysqli_query($conn, $save);
    if (!$qsave) {
        die("INSERT tb_customer_credit ERROR : " . mysqli_error($conn));
    }

    // =========================
    // เช็คข้อมูลใน tb_cuscredit_upfile
    // =========================
    $strSQL1 = "SELECT * FROM tb_cuscredit_upfile WHERE cus_id = '".$customer_id."'";
    $objQuery1 = mysqli_query($conn, $strSQL1);

    if (!$objQuery1) {
        die("SELECT tb_cuscredit_upfile ERROR : " . mysqli_error($conn));
    }

    $objResult1 = mysqli_fetch_array($objQuery1);

    if ($objResult1 && $objResult1["cus_id"] != '') {

        // UPDATE ถ้ามีข้อมูลอยู่แล้ว
        $save1 = "UPDATE tb_cuscredit_upfile SET
                    img_up1 = '".$img_up1."',
                    img_up2 = '".$img_up2."',
                    img_up3 = '".$img_up3."'
                  WHERE cus_id = '".$customer_id."'";

        $qsave1 = mysqli_query($conn, $save1);

        if (!$qsave1) {
            die("UPDATE tb_cuscredit_upfile ERROR : " . mysqli_error($conn));
        }

    } else {

        // INSERT ถ้ายังไม่มีข้อมูล
        $save1 = "INSERT INTO tb_cuscredit_upfile
                    (
                        cus_id,
                        add_by,
                        add_date,
                        img_up1,
                        img_up2,
                        img_up3
                    )
                  VALUES
                    (
                        '".$customer_id."',
                        '".$add_by."',
                        '".$add_date."',
                        '".$img_up1."',
                        '".$img_up2."',
                        '".$img_up3."'
                    )";

        $qsave1 = mysqli_query($conn, $save1);

        if (!$qsave1) {
            die("INSERT tb_cuscredit_upfile ERROR : " . mysqli_error($conn));
        }
    }

    echo "<script>
        alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');
        window.location='report_credit_thb.php';
    </script>";
    exit();
}
?>