<link rel="stylesheet" href="css/w32.css">
<style type="text/css">
.style15 { font-size: 18px; color: #000000; }
.style16 { font-size: 16px; color: #FF0000; }
.style17 { font-size: 14px; color: #3333FF; }
.style32 { font-size: 11px; }
.style33 { font-size: 12px; }
.style34 { color: #FF0000; }
.style35 { font-size: 12px; color: #f2f2f2; }
.style37 { color: #FF0000; font-size: 14px; }
.style38 { color: #f2f2f2; }
.style30 { font-size: 12px; color: #000000; }
.style40 { font-size: 13px; color: #006600; }
</style>

<?php
include "dbconnect.php";
include "dbconnect_sale.php";

function DateThai($strDate)
{
    if (empty($strDate) || $strDate == '0000-00-00') {
        return '-';
    }

    $strYear = date("Y", strtotime($strDate)) + 543;
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));

    $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    $strMonthThai = $strMonthCut[$strMonth];

    return "$strDay $strMonthThai $strYear";
}

function getMonthThaiName($month)
{
    $_month_name = array(
        "01" => "มกราคม",
        "02" => "กุมภาพันธ์",
        "03" => "มีนาคม",
        "04" => "เมษายน",
        "05" => "พฤษภาคม",
        "06" => "มิถุนายน",
        "07" => "กรกฎาคม",
        "08" => "สิงหาคม",
        "09" => "กันยายน",
        "10" => "ตุลาคม",
        "11" => "พฤศจิกายน",
        "12" => "ธันวาคม"
    );

    return isset($_month_name[$month]) ? $_month_name[$month] : "";
}

function num0($val)
{
    return (float)$val;
}

$h_start_codecus = isset($_GET["h_start_codecus"]) ? trim($_GET["h_start_codecus"]) : "";
$start_date      = isset($_GET["start_date"]) ? trim($_GET["start_date"]) : "";
$h_mode_name     = isset($_GET["h_mode_name"]) ? trim($_GET["h_mode_name"]) : "";
$end_date        = isset($_GET["end_date"]) ? trim($_GET["end_date"]) : "";
$h_start_codepro = isset($_GET["h_start_codepro"]) ? trim($_GET["h_start_codepro"]) : "";
$sale_code       = isset($_GET["sale_code"]) ? trim($_GET["sale_code"]) : "";
$str_arr         = isset($_GET["company"]) ? trim($_GET["company"]) : "";

$company  = ($str_arr != "") ? substr($str_arr, 0, 1) : "";
$company1 = ($str_arr != "") ? substr($str_arr, -1) : "";

$thai = "";
$year = "";

if (!empty($start_date) && strpos($start_date, '-') !== false) {
    $date_arr = explode('-', $start_date);
    $mm = isset($date_arr[1]) ? $date_arr[1] : "";
    $yy = isset($date_arr[0]) ? $date_arr[0] : "";
    $thai = getMonthThaiName($mm);
    $year = !empty($yy) ? ($yy + 543) : "";
}

if ($company == '3') {
    $company_name = "บริษัท ออลล์เวล ไลฟ์ จำกัด";
} elseif ($company == '4') {
    $company_name = "บริษัท โนเบิล เมด จำกัด";
} else {
    $company_name = "";
}
?>

<div class="w3-container w3-padding-large">
    <center>
        <span class="style15">รายงานประวัติการขาย แยกตามสินค้า</span><br>
        <span class="style15"><?php echo $thai; ?>&nbsp;&nbsp;<?php echo $year; ?></span><br>
        <span class="style15"><?php echo $company_name; ?></span><br>
        <span class="style15">เขตการขาย <?php echo htmlspecialchars($sale_code); ?></span>
    </center>

<?php
$strSQL = "SELECT DISTINCT product_id
           FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id = hos__subso.ref_idd)
           WHERE status_doc = 'Approve' ";

if ($start_date != "") {
    $strSQL .= ' AND iv_date >= "' . mysqli_real_escape_string($conn, $start_date) . '"';
}
if ($end_date != "") {
    $strSQL .= ' AND iv_date <= "' . mysqli_real_escape_string($conn, $end_date) . '"';
}
if ($company != "") {
    $strSQL .= ' AND type_doc = "' . mysqli_real_escape_string($conn, $company) . '"';
}
if ($sale_code != "") {
    $strSQL .= ' AND sale_code = "' . mysqli_real_escape_string($conn, $sale_code) . '"';
}
if ($h_start_codecus != "") {
    $strSQL .= ' AND bill_id = "' . mysqli_real_escape_string($conn, $h_start_codecus) . '"';
}
if ($h_start_codepro != "") {
    $strSQL .= ' AND product_id = "' . mysqli_real_escape_string($conn, $h_start_codepro) . '"';
}
if ($h_mode_name != '') {
    $strSQL .= ' AND mode_cus = "' . mysqli_real_escape_string($conn, $h_mode_name) . '"';
}

$objQuery = mysqli_query($conn, $strSQL) or die("Error Query [".$strSQL."]");

if (mysqli_num_rows($objQuery) == 0) {
    echo '<div style="color:red; font-size:16px; text-align:center; margin-top:20px;">ไม่พบข้อมูล</div>';
    echo '</div>';
    exit;
}

// ใช้รวมยอดท้ายรายงานแทน $objResult25 ที่ไม่มีอยู่จริง
$objResult25 = array(
    "count"  => 0,
    "amount" => 0
);

while ($objResult = mysqli_fetch_array($objQuery)) {

    $product_id = $objResult["product_id"];

    $strSQL1 = "SELECT sol_name, unit_name
                FROM tb_product
                WHERE product_ID = '" . mysqli_real_escape_string($conn, $product_id) . "'";
    $objQuery1 = mysqli_query($conn, $strSQL1) or die("Error Query [".$strSQL1."]");
    $objResult1 = mysqli_fetch_array($objQuery1);

    $sol_name  = isset($objResult1["sol_name"]) ? $objResult1["sol_name"] : '-';
    $unit_name = isset($objResult1["unit_name"]) ? $objResult1["unit_name"] : '';

    echo '</p></p>';
    ?>
    <table border="1" width="100%" class="w3-table">
        <tr>
            <td width="10%" align="center" class="style30">วันที่</td>
            <td width="10%" align="center" class="style30">เลขที่เอกสาร</td>
            <td width="10%" align="center" class="style30">ชื่อลูกค้า</td>
            <td width="10%" align="center" class="style30">จำนวน</td>
            <td width="10%" align="center" class="style30">ราคาต่อหน่วย</td>
            <td width="10%" align="center" class="style30">ส่วนลด</td>
            <td width="10%" align="center" class="style30">รวมเงิน</td>
            <td width="10%" align="center" class="style30">ส่วนลดรวม</td>
            <td width="10%" align="center" class="style30">ยอดขายก่อน Vat</td>
            <td width="10%" align="center" class="style30">ยอดขายรวม Vat</td>
        </tr>

        <tr>
            <td width="10%" align="left" class="style30"><b><font color="blue"><?php echo $sol_name; ?></font></b></td>
            <td width="10%" align="center" class="style30"></td>
            <td width="10%" align="center" class="style30"></td>
            <td width="10%" align="center" class="style30"></td>
            <td width="10%" align="center" class="style30"></td>
            <td width="10%" align="center" class="style30"></td>
            <td width="10%" align="center" class="style30"></td>
            <td width="10%" align="center" class="style30"></td>
            <td width="10%" align="center" class="style30"></td>
            <td width="10%" align="center" class="style30"></td>
        </tr>

    <?php
    $strSQL2 = "SELECT DISTINCT bill_id
                FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id = hos__subso.ref_idd)
                WHERE status_doc = 'Approve' ";

    if ($start_date != "") {
        $strSQL2 .= ' AND iv_date >= "' . mysqli_real_escape_string($conn, $start_date) . '"';
    }
    if ($end_date != "") {
        $strSQL2 .= ' AND iv_date <= "' . mysqli_real_escape_string($conn, $end_date) . '"';
    }
    if ($company != "") {
        $strSQL2 .= ' AND type_doc = "' . mysqli_real_escape_string($conn, $company) . '"';
    }
    if ($sale_code != "") {
        $strSQL2 .= ' AND sale_code = "' . mysqli_real_escape_string($conn, $sale_code) . '"';
    }
    if ($h_start_codecus != "") {
        $strSQL2 .= ' AND bill_id = "' . mysqli_real_escape_string($conn, $h_start_codecus) . '"';
    }
    if ($h_mode_name != '') {
        $strSQL2 .= ' AND mode_cus = "' . mysqli_real_escape_string($conn, $h_mode_name) . '"';
    }
    if ($h_start_codepro != "") {
        $strSQL2 .= ' AND product_id = "' . mysqli_real_escape_string($conn, $h_start_codepro) . '"';
    } else {
        $strSQL2 .= ' AND product_id = "' . mysqli_real_escape_string($conn, $product_id) . '"';
    }

    $objQuery2 = mysqli_query($conn, $strSQL2) or die("Error Query [".$strSQL2."]");

    while ($objResult2 = mysqli_fetch_array($objQuery2)) {

        $bill_id = $objResult2["bill_id"];

        $strSQL4 = "SELECT bill_name, iv_date, iv_no, sale_code, count, price, amount, discount, ref_id, sale_remark
                    FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id = hos__subso.ref_idd)
                    WHERE status_doc = 'Approve' ";

        if ($start_date != "") {
            $strSQL4 .= ' AND iv_date >= "' . mysqli_real_escape_string($conn, $start_date) . '"';
        }
        if ($end_date != "") {
            $strSQL4 .= ' AND iv_date <= "' . mysqli_real_escape_string($conn, $end_date) . '"';
        }
        if ($company != "") {
            $strSQL4 .= ' AND type_doc = "' . mysqli_real_escape_string($conn, $company) . '"';
        }
        if ($sale_code != "") {
            $strSQL4 .= ' AND sale_code = "' . mysqli_real_escape_string($conn, $sale_code) . '"';
        }

        if ($h_start_codecus != "") {
            $strSQL4 .= ' AND bill_id = "' . mysqli_real_escape_string($conn, $h_start_codecus) . '"';
        } else {
            $strSQL4 .= ' AND bill_id = "' . mysqli_real_escape_string($conn, $bill_id) . '"';
        }

        if ($h_mode_name != '') {
            $strSQL4 .= ' AND mode_cus = "' . mysqli_real_escape_string($conn, $h_mode_name) . '"';
        }

        if ($h_start_codepro != "") {
            $strSQL4 .= ' AND product_id = "' . mysqli_real_escape_string($conn, $h_start_codepro) . '"';
        } else {
            $strSQL4 .= ' AND product_id = "' . mysqli_real_escape_string($conn, $product_id) . '"';
        }

        $objQuery4 = mysqli_query($conn, $strSQL4) or die("Error Query [".$strSQL4."]");

        while ($objResult4 = mysqli_fetch_array($objQuery4)) {
            ?>
            <tr>
                <td align="center" class="style30"><?php echo DateThai($objResult4["iv_date"]); ?></td>
                <td align="center" class="style30"><?php echo $objResult4["iv_no"]; ?></td>
                <td align="center" class="style30"><?php echo $objResult4["bill_name"]; ?></td>
                <td class="style30"><div align="right"><?php echo num0($objResult4["count"]); ?> <?php echo $unit_name; ?></div></td>
                <td class="style30"><div align="right"><?php echo number_format(num0($objResult4["price"]), 2); ?></div></td>
                <td class="style30"><div align="right"><?php echo number_format(num0($objResult4["discount"]), 2); ?></div></td>
                <td class="style30"><div align="right"><?php echo number_format(num0($objResult4["price"]) * num0($objResult4["count"]), 2); ?></div></td>
                <td align="right" class="style30"><?php echo number_format(num0($objResult4["discount"]) * num0($objResult4["count"]), 2); ?></td>
                <td class="style30"><div align="right"><?php echo number_format(num0($objResult4["amount"]) / 1.07, 2); ?></div></td>
                <td align="right" class="style30"><?php echo number_format(num0($objResult4["amount"]), 2); ?></td>
            </tr>
            <?php
        }
    }

    $strSQL5 = "SELECT 
                    COALESCE(SUM(count),0) AS count,
                    COALESCE(SUM(price),0) AS price,
                    COALESCE(SUM(amount),0) AS amount,
                    COALESCE(SUM(discount),0) AS discount
                FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id = hos__subso.ref_idd)
                WHERE status_doc = 'Approve' ";

    if ($start_date != "") {
        $strSQL5 .= ' AND iv_date >= "' . mysqli_real_escape_string($conn, $start_date) . '"';
    }
    if ($end_date != "") {
        $strSQL5 .= ' AND iv_date <= "' . mysqli_real_escape_string($conn, $end_date) . '"';
    }
    if ($company != "") {
        $strSQL5 .= ' AND type_doc = "' . mysqli_real_escape_string($conn, $company) . '"';
    }
    if ($sale_code != "") {
        $strSQL5 .= ' AND sale_code = "' . mysqli_real_escape_string($conn, $sale_code) . '"';
    }
    if ($h_start_codecus != "") {
        $strSQL5 .= ' AND bill_id = "' . mysqli_real_escape_string($conn, $h_start_codecus) . '"';
    }
    if ($h_mode_name != '') {
        $strSQL5 .= ' AND mode_cus = "' . mysqli_real_escape_string($conn, $h_mode_name) . '"';
    }
    if ($h_start_codepro != "") {
        $strSQL5 .= ' AND product_id = "' . mysqli_real_escape_string($conn, $h_start_codepro) . '"';
    } else {
        $strSQL5 .= ' AND product_id = "' . mysqli_real_escape_string($conn, $product_id) . '"';
    }

    $objQuery5 = mysqli_query($conn, $strSQL5) or die("Error Query [".$strSQL5."]");
    $objResult5 = mysqli_fetch_array($objQuery5);
    ?>

        <tr>
            <td align="center" class="style40"><font color="red">รวมใบกำกับภาษี</font></td>
            <td align="center" class="style40"></td>
            <td align="center" class="style40"></td>
            <td class="style40"><div align="right"><font color="red"><?php echo num0($objResult5["count"]); ?> <?php echo $unit_name; ?></font></div></td>
            <td class="style40"><div align="right"></div></td>
            <td class="style40"><div align="right"></div></td>
            <td class="style40"></td>
            <td align="right" class="style40"></td>
            <td class="style40"><div align="right"><font color="red"><?php echo number_format(num0($objResult5["amount"]) / 1.07, 2); ?></font></div></td>
            <td align="right" class="style40"><div align="right"><font color="red"><?php echo number_format(num0($objResult5["amount"]), 2); ?></font></div></td>
        </tr>

    <?php
    $strSQL6 = "SELECT 
                    COALESCE(SUM(count),0) AS count,
                    COALESCE(SUM(price),0) AS price,
                    COALESCE(SUM(amount),0) AS amount,
                    COALESCE(SUM(discount),0) AS discount
                FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id = hos__subso.ref_idd)
                WHERE status_doc = 'Approve' ";

    if ($start_date != "") {
        $strSQL6 .= ' AND iv_date >= "' . mysqli_real_escape_string($conn, $start_date) . '"';
    }
    if ($end_date != "") {
        $strSQL6 .= ' AND iv_date <= "' . mysqli_real_escape_string($conn, $end_date) . '"';
    }
    if ($company != "") {
        $strSQL6 .= ' AND type_doc = "' . mysqli_real_escape_string($conn, $company) . '"';
    }
    if ($sale_code != "") {
        $strSQL6 .= ' AND sale_code = "' . mysqli_real_escape_string($conn, $sale_code) . '"';
    }
    if ($h_start_codecus != "") {
        $strSQL6 .= ' AND bill_id = "' . mysqli_real_escape_string($conn, $h_start_codecus) . '"';
    }
    if ($h_start_codepro != "") {
        $strSQL6 .= ' AND product_id = "' . mysqli_real_escape_string($conn, $h_start_codepro) . '"';
    } else {
        $strSQL6 .= ' AND product_id = "' . mysqli_real_escape_string($conn, $product_id) . '"';
    }
    if ($h_mode_name != '') {
        $strSQL6 .= ' AND mode_cus = "' . mysqli_real_escape_string($conn, $h_mode_name) . '"';
    }

    $objQuery6 = mysqli_query($conn, $strSQL6) or die("Error Query [".$strSQL6."]");
    $objResult6 = mysqli_fetch_array($objQuery6);
    ?>

        <tr>
            <td align="left" class="style40"><font color="blue"><b><?php echo "รวม ".$sol_name; ?></b></font></td>
            <td align="center" class="style40"></td>
            <td align="center" class="style40"></td>
            <td class="style40"><div align="right"><font color="blue"><?php echo num0($objResult6["count"])." ".$unit_name; ?></font></div></td>
            <td class="style40"><div align="right"></div></td>
            <td class="style40"><div align="right"></div></td>
            <td class="style40"></td>
            <td align="center" class="style40"></td>
            <td class="style40"><div align="right"><font color="blue"><?php echo number_format(num0($objResult6["amount"]) / 1.07, 2); ?></font></div></td>
            <td class="style40"><div align="right"><font color="blue"><?php echo number_format(num0($objResult6["amount"]), 2); ?></font></div></td>
        </tr>

    <?php
    $date_credit = (!empty($start_date)) ? substr($start_date, 0, 7) : "";

    $strSQL14 = "SELECT date_credit, credit_no, sale_code, count, unit_price, sum_amount, discount_unit,
                        ref_credit, product_id, iv_no_ref, customer_name
                 FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit = tb_subcredit.ref_creditt)
                 WHERE status_doc = 'Approve' ";

    if ($date_credit != "") {
        $strSQL14 .= ' AND date_credit LIKE "%' . mysqli_real_escape_string($conn, $date_credit) . '%"';
    }
    if ($company != "") {
        $strSQL14 .= ' AND company_type = "' . mysqli_real_escape_string($conn, $company) . '"';
    }
    if ($sale_code != "") {
        $strSQL14 .= ' AND sale_code = "' . mysqli_real_escape_string($conn, $sale_code) . '"';
    }
    if ($h_start_codecus != "") {
        $strSQL14 .= ' AND bill_id = "' . mysqli_real_escape_string($conn, $h_start_codecus) . '"';
    }
    if ($h_start_codepro != "") {
        $strSQL14 .= ' AND product_id = "' . mysqli_real_escape_string($conn, $h_start_codepro) . '"';
    } else {
        $strSQL14 .= ' AND product_id = "' . mysqli_real_escape_string($conn, $product_id) . '"';
    }
    if ($h_mode_name != '') {
        $strSQL14 .= ' AND mode_cus = "' . mysqli_real_escape_string($conn, $h_mode_name) . '"';
    }

    $objQuery14 = mysqli_query($conn, $strSQL14) or die("Error Query [".$strSQL14."]");
    $rowcount = mysqli_num_rows($objQuery14);

    if ($rowcount > 0) {
        ?>
        <tr>
            <td width="10%" align="center" class="style30">วันที่</td>
            <td width="10%" align="center" class="style30">เลขที่เอกสาร</td>
            <td width="10%" align="center" class="style30">ชื่อลูกค้า</td>
            <td width="10%" align="center" class="style30">จำนวน</td>
            <td width="10%" align="center" class="style30">ราคาต่อหน่วย</td>
            <td width="10%" align="center" class="style30">ส่วนลด</td>
            <td width="10%" align="center" class="style30">รวมเงิน</td>
            <td width="10%" align="center" class="style30">ส่วนลดรวม</td>
            <td width="10%" align="center" class="style30">ยอดขายก่อน Vat</td>
            <td width="10%" align="center" class="style30">ยอดขายรวม Vat</td>
        </tr>
        <?php

        while ($objResult14 = mysqli_fetch_array($objQuery14)) {

            $strSQL13 = "SELECT sol_name, unit_name
                         FROM tb_product
                         WHERE product_ID = '" . mysqli_real_escape_string($conn, $objResult14["product_id"]) . "'";
            $objQuery13 = mysqli_query($conn, $strSQL13) or die("Error Query [".$strSQL13."]");
            $objResult13 = mysqli_fetch_array($objQuery13);

            $unit_name_credit = isset($objResult13["unit_name"]) ? $objResult13["unit_name"] : '';
            ?>
            <tr>
                <td align="center" class="style30"><?php echo DateThai($objResult14["date_credit"]); ?></td>
                <td align="center" class="style30"><?php echo $objResult14["credit_no"]; ?></td>
                <td align="center" class="style30"><?php echo $objResult14["customer_name"]; ?></td>
                <td class="style30"><div align="right"><?php echo num0($objResult14["count"]); ?> <?php echo $unit_name_credit; ?></div></td>
                <td class="style30"><div align="right"><?php echo number_format(num0($objResult14["unit_price"]), 2); ?></div></td>
                <td class="style30"><div align="right"><?php echo number_format(num0($objResult14["discount_unit"]), 2); ?></div></td>
                <td class="style30"><div align="right"><?php echo number_format(num0($objResult14["unit_price"]) * num0($objResult14["count"]), 2); ?></div></td>
                <td align="right" class="style30"><?php echo number_format(num0($objResult14["discount_unit"]) * num0($objResult14["count"]), 2); ?></td>
                <td class="style30"><div align="right"><?php echo number_format(num0($objResult14["sum_amount"]) / 1.07, 2); ?></div></td>
                <td align="right" class="style30"><?php echo number_format(num0($objResult14["sum_amount"]), 2); ?></td>
            </tr>
            <?php
        }

        $strSQL16 = "SELECT 
                        COALESCE(SUM(count),0) AS count,
                        COALESCE(SUM(unit_price),0) AS price,
                        COALESCE(SUM(sum_amount),0) AS amount,
                        COALESCE(SUM(discount_unit),0) AS discount
                     FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit = tb_subcredit.ref_creditt)
                     WHERE status_doc = 'Approve' ";

        if ($date_credit != "") {
            $strSQL16 .= ' AND date_credit LIKE "%' . mysqli_real_escape_string($conn, $date_credit) . '%"';
        }
        if ($company != "") {
            $strSQL16 .= ' AND company_type = "' . mysqli_real_escape_string($conn, $company) . '"';
        }
        if ($sale_code != "") {
            $strSQL16 .= ' AND sale_code = "' . mysqli_real_escape_string($conn, $sale_code) . '"';
        }
        if ($h_start_codecus != "") {
            $strSQL16 .= ' AND bill_id = "' . mysqli_real_escape_string($conn, $h_start_codecus) . '"';
        }
        if ($h_start_codepro != "") {
            $strSQL16 .= ' AND product_id = "' . mysqli_real_escape_string($conn, $h_start_codepro) . '"';
        } else {
            $strSQL16 .= ' AND product_id = "' . mysqli_real_escape_string($conn, $product_id) . '"';
        }
        if ($h_mode_name != '') {
            $strSQL16 .= ' AND mode_cus = "' . mysqli_real_escape_string($conn, $h_mode_name) . '"';
        }

        $objQuery16 = mysqli_query($conn, $strSQL16) or die("Error Query [".$strSQL16."]");
        $objResult16 = mysqli_fetch_array($objQuery16);
        ?>

        <tr>
            <td align="left" class="style40"><font color="red"><b><?php echo "รวมใบลดหนี้ทั้งหมด ".$sol_name; ?></b></font></td>
            <td align="center" class="style40"></td>
            <td align="center" class="style40"></td>
            <td class="style40"><div align="right"><font color="red"><?php echo num0($objResult16["count"])." ".$unit_name; ?></font></div></td>
            <td class="style40"><div align="right"></div></td>
            <td class="style40"><div align="right"></div></td>
            <td class="style40"></td>
            <td align="center" class="style40"></td>
            <td class="style40"><div align="right"><font color="red"><?php echo number_format(num0($objResult16["amount"]) / 1.07, 2); ?></font></div></td>
            <td class="style40"><div align="right"><font color="red"><?php echo number_format(num0($objResult16["amount"]), 2); ?></font></div></td>
        </tr>

        <tr>
            <td align="left" class="style40"><font color="blue"><b><?php echo "รวมทั้งหมด ".$sol_name; ?></b></font></td>
            <td align="center" class="style40"></td>
            <td align="center" class="style40"></td>
            <td class="style40"><div align="right"><font color="blue"><?php echo (num0($objResult6["count"]) - num0($objResult16["count"]))." ".$unit_name; ?></font></div></td>
            <td class="style40"><div align="right"></div></td>
            <td class="style40"><div align="right"></div></td>
            <td class="style40"></td>
            <td align="center" class="style40"></td>
            <td class="style40"><div align="right"><font color="blue"><?php echo number_format((num0($objResult6["amount"]) - num0($objResult16["amount"])) / 1.07, 2); ?></font></div></td>
            <td class="style40"><div align="right"><font color="blue"><?php echo number_format(num0($objResult6["amount"]) - num0($objResult16["amount"]), 2); ?></font></div></td>
        </tr>

        <?php
    } else {
        $objResult16 = array("count" => 0, "amount" => 0);
    }

    echo "</table></p></p></p></p>";
}

$strSQL15 = "SELECT 
                COALESCE(SUM(count),0) AS count,
                COALESCE(SUM(price),0) AS price,
                COALESCE(SUM(amount),0) AS amount,
                COALESCE(SUM(discount),0) AS discount
             FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id = hos__subso.ref_idd)
             WHERE status_doc = 'Approve' ";

if ($start_date != "") {
    $strSQL15 .= ' AND iv_date >= "' . mysqli_real_escape_string($conn, $start_date) . '"';
}
if ($end_date != "") {
    $strSQL15 .= ' AND iv_date <= "' . mysqli_real_escape_string($conn, $end_date) . '"';
}
if ($company != "") {
    $strSQL15 .= ' AND type_doc = "' . mysqli_real_escape_string($conn, $company) . '"';
}
if ($sale_code != "") {
    $strSQL15 .= ' AND sale_code = "' . mysqli_real_escape_string($conn, $sale_code) . '"';
}
if ($h_start_codecus != "") {
    $strSQL15 .= ' AND bill_id = "' . mysqli_real_escape_string($conn, $h_start_codecus) . '"';
}
if ($h_start_codepro != "") {
    $strSQL15 .= ' AND product_id = "' . mysqli_real_escape_string($conn, $h_start_codepro) . '"';
}
if ($h_mode_name != '') {
    $strSQL15 .= ' AND mode_cus = "' . mysqli_real_escape_string($conn, $h_mode_name) . '"';
}

$objQuery15 = mysqli_query($conn, $strSQL15) or die("Error Query [".$strSQL15."]");
$objResult15 = mysqli_fetch_array($objQuery15);

$date_credit = (!empty($start_date)) ? substr($start_date, 0, 7) : "";

$strSQL26 = "SELECT 
                COALESCE(SUM(count),0) AS count,
                COALESCE(SUM(unit_price),0) AS price,
                COALESCE(SUM(sum_amount),0) AS amount,
                COALESCE(SUM(discount_unit),0) AS discount
             FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit = tb_subcredit.ref_creditt)
             WHERE status_doc = 'Approve' ";

if ($date_credit != "") {
    $strSQL26 .= ' AND date_credit LIKE "%' . mysqli_real_escape_string($conn, $date_credit) . '%"';
}
if ($company != "") {
    $strSQL26 .= ' AND company_type = "' . mysqli_real_escape_string($conn, $company) . '"';
}
if ($sale_code != "") {
    $strSQL26 .= ' AND sale_code = "' . mysqli_real_escape_string($conn, $sale_code) . '"';
}
if ($h_start_codecus != "") {
    $strSQL26 .= ' AND bill_id = "' . mysqli_real_escape_string($conn, $h_start_codecus) . '"';
}
if ($h_start_codepro != "") {
    $strSQL26 .= ' AND product_id = "' . mysqli_real_escape_string($conn, $h_start_codepro) . '"';
}
if ($h_mode_name != '') {
    $strSQL26 .= ' AND mode_cus = "' . mysqli_real_escape_string($conn, $h_mode_name) . '"';
}

$objQuery26 = mysqli_query($conn, $strSQL26) or die("Error Query [".$strSQL26."]");
$objResult26 = mysqli_fetch_array($objQuery26);
?>

    <table border="1" width="100%" class="w3-table">
        <tr>
            <td width="10%" align="center" class="style16">ยอดรวม</td>
            <td width="10%" align="center" class="style30"></td>
            <td width="10%" align="center" class="style30"></td>
            <td width="10%" align="right" class="style16">
                <?php echo num0($objResult16["count"]) + num0($objResult15["count"]) + num0($objResult25["count"]); ?>
            </td>
            <td width="10%" align="center" class="style30"></td>
            <td width="10%" align="center" class="style30"></td>
            <td width="10%" align="center" class="style30"></td>
            <td width="10%" align="center" class="style30"></td>
            <td width="10%" align="right" class="style16">
                <?php echo number_format((num0($objResult16["amount"]) + num0($objResult15["amount"]) + num0($objResult25["amount"])) / 1.07, 2); ?>
            </td>
            <td width="10%" align="right" class="style16">
                <?php echo number_format(num0($objResult16["amount"]) + num0($objResult15["amount"]) + num0($objResult25["amount"]), 2); ?>
            </td>
        </tr>

        <tr>
            <td width="10%" align="center" class="style16">ยอดรวมใบลดหนี้ทั้งหมด</td>
            <td width="10%" align="center" class="style30"></td>
            <td width="10%" align="center" class="style30"></td>
            <td width="10%" align="right" class="style16"><?php echo num0($objResult26["count"]); ?></td>
            <td width="10%" align="center" class="style30"></td>
            <td width="10%" align="center" class="style30"></td>
            <td width="10%" align="center" class="style30"></td>
            <td width="10%" align="center" class="style30"></td>
            <td width="10%" align="right" class="style16"><?php echo number_format(num0($objResult26["amount"]) / 1.07, 2); ?></td>
            <td width="10%" align="right" class="style16"><?php echo number_format(num0($objResult26["amount"]), 2); ?></td>
        </tr>

        <tr>
            <td width="10%" align="center" class="style16">ยอดรวมสุทธิ</td>
            <td width="10%" align="center" class="style30"></td>
            <td width="10%" align="center" class="style30"></td>
            <td width="10%" align="right" class="style16">
                <?php echo (num0($objResult16["count"]) + num0($objResult15["count"]) + num0($objResult25["count"])) - num0($objResult26["count"]); ?>
            </td>
            <td width="10%" align="center" class="style30"></td>
            <td width="10%" align="center" class="style30"></td>
            <td width="10%" align="center" class="style30"></td>
            <td width="10%" align="center" class="style30"></td>
            <td width="10%" align="right" class="style16">
                <?php echo number_format(((num0($objResult16["amount"]) + num0($objResult15["amount"]) + num0($objResult25["amount"])) - num0($objResult26["amount"])) / 1.07, 2); ?>
            </td>
            <td width="10%" align="right" class="style16">
                <?php echo number_format((num0($objResult16["amount"]) + num0($objResult15["amount"]) + num0($objResult25["amount"])) - num0($objResult26["amount"]), 2); ?>
            </td>
        </tr>
    </table>
</div>