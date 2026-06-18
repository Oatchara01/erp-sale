<?php
$ref_id = $_GET['ref_id'];
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment; filename=$ref_id.doc");

// Base64 encode image function
function base64_encode_image($filename, $filetype) {
    if ($filename) {
        $imgbinary = fread(fopen($filename, "r"), filesize($filename));
        return 'data:' . $filetype . ';base64,' . base64_encode($imgbinary);
    }
}

$imageData = base64_encode_image('img/nb_logo.jpg', 'image/jpeg');

function Convert($amount_number) {
    $amount_number = number_format($amount_number, 2, ".", "");
    $pt = strpos($amount_number, ".");
    $number = $fraction = "";
    if ($pt === false) {
        $number = $amount_number;
    } else {
        $number = substr($amount_number, 0, $pt);
        $fraction = substr($amount_number, $pt + 1);
    }
    $ret = "";
    $baht = ReadNumber($number);
    if ($baht != "") {
        $ret .= $baht . "บาท";
    }
    $satang = ReadNumber($fraction);
    if ($satang != "") {
        $ret .= $satang . "สตางค์";
    } else {
        $ret .= "ถ้วน";
    }
    return $ret;
}

function ReadNumber($number) {
    $position_call = array("แสน", "หมื่น", "พัน", "ร้อย", "สิบ", "");
    $number_call = array("", "หนึ่ง", "สอง", "สาม", "สี่", "ห้า", "หก", "เจ็ด", "แปด", "เก้า");
    $number = $number + 0;
    $ret = "";
    if ($number == 0) return $ret;
    if ($number > 1000000) {
        $ret .= ReadNumber(intval($number / 1000000)) . "ล้าน";
        $number = intval(fmod($number, 1000000));
    }

    $divider = 100000;
    $pos = 0;
    while ($number > 0) {
        $d = intval($number / $divider);
        $ret .= (($divider == 10) && ($d == 2)) ? "ยี่" :
            ((($divider == 10) && ($d == 1)) ? "" :
                ((($divider == 1) && ($d == 1) && ($ret != "")) ? "เอ็ด" : $number_call[$d]));
        $ret .= ($d ? $position_call[$pos] : "");
        $number = $number % $divider;
        $divider = $divider / 10;
        $pos++;
    }
    return $ret;
}

function DateThai($strDate) {
    $strYear = date("Y", strtotime($strDate)) + 543;
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));
    $strMonthCut = Array("", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พ.ย.", "ธ.ค.");
    $strMonthThai = $strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear";
}

include "dbconnect.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <style>
        body {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            font: 12pt "Angsana New";
        }
        table {
            border-collapse: collapse;
            font-size: 14pt;
        }
        .tablel {
            border-collapse: collapse;
            font-size: 10pt;
        }
        .tablepr {
            border-collapse: collapse;
            font-size: 12pt;
        }
        .tablep, .tr, .td {
            border: 1px solid black;
        }
        * {
            box-sizing: border-box;
            -moz-box-sizing: border-box;
        }
        .page {
            width: 210mm;
            max-height: 297mm;
            padding-left: 10mm;
            padding-right: 10mm;
            padding-top: 5mm;
            padding-bottom: 0mm;
            margin: 0mm auto;
            background: white;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0);
        }
        @page {
            size: A4;
            margin: 0;
        }
        @page Section1 {size:841.7pt 595.45pt; margin:1.0in 1.25in 1.0in 1.25in; mso-header-margin:.5in; mso-footer-margin:.5in; mso-paper-source:0;}
        div.Section1 {page:Section1;}
        @page Section2 {size:595.45pt 841.7pt; mso-page-orientation:landscape; margin:0.4in 0.4in 0.4in 0.4in; mso-header-margin:.4in; mso-footer-margin:.4in; mso-paper-source:0;}
        div.Section2 {page:Section2;}
        @media screen {
            div.divFooter {
                display: none;
            }
        }
        @media print {
            html, body {
                width: 210mm;
                height: 297mm;
                margin: 0;
                div.divFooter {
                    position: fixed;
                    bottom: 0;
                }
            }
        }
        h1, h2, h3, h4, h5, h6 {
            font: 14pt "Angsana New";
        }
    </style>
</head>
<body>
    <div class="page">
        <table style="width:100%;">
            <tr>
                <td valign="top" style="width:60%;text-align:center;">
                    <font size="5">ใบสั่งพิมพ์ใบเบิกจ่ายสินค้า</font><br>
                    <font size="4">(Request for issuing stock movement order)</font>
                </td>
                <td valign="top" style="width:20%;">
                    <img src="<?php echo $imageData; ?>" width="80" height="30" align="right">
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
