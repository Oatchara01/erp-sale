<?php include ("head.php"); ?>

<?php
include("dbconnect.php");
include ("error_page.php"); 

date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {


 $ref_id_br       = $_POST["ref_id_br"] ?? '';
    $date_reseach   = $_POST["date_reseach"] ?? [];
    $product_iddemo = $_POST["product_iddemo"] ?? [];

    $ckk_1 = $_POST["ckk_1"] ?? [];
    $ckk_2 = $_POST["ckk_2"] ?? [];
    $ckk_3 = $_POST["ckk_3"] ?? [];
    $ckk_4 = $_POST["ckk_4"] ?? [];
    $ckk_5 = $_POST["ckk_5"] ?? [];

    $cs_1 = $_POST["cs_1"] ?? [];
    $cs_2 = $_POST["cs_2"] ?? [];
    $cs_3 = $_POST["cs_3"] ?? [];
    $cs_4 = $_POST["cs_4"] ?? [];
    $cs_5 = $_POST["cs_5"] ?? [];
    $cs_6 = $_POST["cs_6"] ?? [];

    $cs_des  = $_POST["cs_des"] ?? [];
    $iv_no   = $_POST["iv_no"] ?? [];
    $ckk_des = $_POST["ckk_des"] ?? [];
    $allwell = $_POST["allwell"] ?? [];

    $id        = $_POST["id"] ?? [];
    $sale_code = $_POST["sale_code"] ?? '';
    $iv_date   = $_POST["iv_date"] ?? '';

    $add_date = date('Y-m-d H:i:s');

    $name    = $_SESSION['name'] ?? '';
    $surname = $_SESSION['surname'] ?? '';
    $add_by  = trim($name . " " . $surname);

    $qsave = true;

    foreach ($id as $key => $value) {

        $date_reseach_new   = $date_reseach[$key] ?? '';
        $product_iddemo_new = $product_iddemo[$key] ?? '';

        $ckk_1_new = $ckk_1[$key] ?? 10;
        $ckk_2_new = $ckk_2[$key] ?? 10;
        $ckk_3_new = $ckk_3[$key] ?? 10;
        $ckk_4_new = $ckk_4[$key] ?? 10;
        $ckk_5_new = $ckk_5[$key] ?? 10;

        $ckk_des_new = $ckk_des[$key] ?? '';
        $allwell_new = $allwell[$key] ?? '';

        $cs_1_new = $cs_1[$key] ?? 10;
        $cs_2_new = $cs_2[$key] ?? 10;
        $cs_3_new = $cs_3[$key] ?? 10;
        $cs_4_new = $cs_4[$key] ?? 10;
        $cs_5_new = $cs_5[$key] ?? 10;
        $cs_6_new = $cs_6[$key] ?? 10;

        $cs_des_new = $cs_des[$key] ?? '';
        $iv_no_new  = $iv_no[$key] ?? '';

        $ref_id_br_sql       = mysqli_real_escape_string($conn, $ref_id_br);
        $date_reseach_sql    = mysqli_real_escape_string($conn, $date_reseach_new);
        $product_iddemo_sql  = mysqli_real_escape_string($conn, $product_iddemo_new);
        $ckk_des_sql         = mysqli_real_escape_string($conn, $ckk_des_new);
        $allwell_sql         = mysqli_real_escape_string($conn, $allwell_new);
        $cs_des_sql          = mysqli_real_escape_string($conn, $cs_des_new);
        $add_by_sql          = mysqli_real_escape_string($conn, $add_by);
        $sale_code_sql       = mysqli_real_escape_string($conn, $sale_code);
        $iv_date_sql         = mysqli_real_escape_string($conn, $iv_date);

        $save = "
            INSERT INTO tb_research_demo
            (
                ref_id,
                date_reseach,
                product_iddemo,
                ckk_1,
                ckk_2,
                ckk_3,
                ckk_4,
                ckk_5,
                ckk_des,
                add_date,
                add_by,
                allwell_ckk,
                cs_1,
                cs_2,
                cs_3,
                cs_4,
                cs_5,
                cs_des,
                cs_6,
                sale_code,
                iv_date
            )
            VALUES
            (
                '$ref_id_br_sql',
                '$date_reseach_sql',
                '$product_iddemo_sql',
                '$ckk_1_new',
                '$ckk_2_new',
                '$ckk_3_new',
                '$ckk_4_new',
                '$ckk_5_new',
                '$ckk_des_sql',
                '$add_date',
                '$add_by_sql',
                '$allwell_sql',
                '$cs_1_new',
                '$cs_2_new',
                '$cs_3_new',
                '$cs_4_new',
                '$cs_5_new',
                '$cs_des_sql',
                '$cs_6_new',
                '$sale_code_sql',
                '$iv_date_sql'
            )
        ";

        $qsave = mysqli_query($conn, $save);

        if (!$qsave) {
            echo "Error Insert: " . mysqli_error($conn);
            exit();
        }

        $product_iddemo_sql2 = mysqli_real_escape_string($conn, $product_iddemo_new);

        $strSQL1 = "SELECT sol_name FROM tb_product WHERE product_ID = '$product_iddemo_sql2'";
        $objQuery1 = mysqli_query($conn, $strSQL1);

        $sol_name = '';

        if ($objQuery1 && mysqli_num_rows($objQuery1) > 0) {
            $objResult1 = mysqli_fetch_array($objQuery1);
            $sol_name = $objResult1["sol_name"] ?? '';
        }

        $sToken = "ใส่_LINE_NOTIFY_TOKEN_ของคุณตรงนี้";

        $sMessage = "มีการทำแบบสอบถามสินค้าสาธิต
เลขที่อ้างอิง : $ref_id_br
เลขที่เอกสาร : $iv_no_new
สินค้า : $sol_name
ผู้ทำแบบประเมิน : $add_by
เวลาทำแบบประเมิน : $add_date
รบกวนทำการตรวจสอบข้อมูล
ตามลิงค์ด้านล่างได้เลยค่ะ
https://stock.allwellcenter.com/report_endemobypro.php";

        $chOne = curl_init();

        curl_setopt($chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
        curl_setopt($chOne, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($chOne, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($chOne, CURLOPT_POST, 1);
        curl_setopt($chOne, CURLOPT_POSTFIELDS, http_build_query([
            "message" => $sMessage
        ]));

        $headers = [
            "Content-type: application/x-www-form-urlencoded",
            "Authorization: Bearer " . $sToken
        ];

        curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($chOne, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($chOne);

        if (curl_error($chOne)) {
            echo "LINE Notify Error: " . curl_error($chOne);
        }

        curl_close($chOne);
    }

    $ref_id_br_update = mysqli_real_escape_string($conn, $ref_id_br);

    $save1 = "UPDATE so__main SET research_demo = '2' WHERE ref_id = '$ref_id_br_update'";
    mysqli_query($conn, $save1);

    $save9 = "UPDATE hos__br SET research_demo = '2' WHERE ref_id_br = '$ref_id_br_update'";
    mysqli_query($conn, $save9);

    if ($qsave) {

        if ($_SESSION["type_login"] == 'Sup_Sale') {

            echo "<script>";
            echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_supdemo.php';";
            echo "</script>";

        } else if ($_SESSION["type_login"] == 'AllWell') {

            echo "<script>";
            echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_soldemo.php';";
            echo "</script>";

        } else {

            echo "<script>";
            echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_saledemo.php';";
            echo "</script>";

        }

    } else {
        echo "Cannot Save";
    }

} else {
    echo "<script>";
    echo "alert('ไม่พบข้อมูลที่ส่งมา');window.history.back();";
    echo "</script>";
}

?>