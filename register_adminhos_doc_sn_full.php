<?php
include 'dbconnect.php';

function DateThai($strDate)
{
    if (empty($strDate) || $strDate == '0000-00-00') {
        return "";
    }

    $strYear = date("Y", strtotime($strDate)) + 543;
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));
    $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    $strMonthThai = $strMonthCut[$strMonth];

    if ($strYear != '2513') {
        return "$strDay $strMonthThai $strYear";
    } else {
        return "";
    }
}

function getWarrantyPeriod($warranty_phase)
{
    switch ($warranty_phase) {
        case 12:
        case "1year":
		case "1 ปี":	
            return "1 ปี";
			
        case 15:
        case "1year.+3month":
            return "1 ปี 3 เดือน";
        case 6:
        case "6month":
            return "6 เดือน";
        case 18:
        case "1year.+6month":
            return "1 ปี 6 เดือน";
        case 20:
        case "1year.+8month":
            return "1 ปี 8 เดือน";
        case 24:
        case "2year":
		case "2 ปี":	
		case "2":	
            return "2 ปี";
        case 36:
        case "3year":
            return "3 ปี";
        case "4year":
            return "4 ปี";
        case 60:
        case "5year":
            return "5 ปี";
        case 99:
        case "LT":
            return "ตลอดอายุการใช้งาน";
        case 0:
            return "ไม่ระบุ";
        default:
            return "ไม่ระบุ";
    }
}

$ref_id = isset($_GET["ref_id"]) ? trim($_GET["ref_id"]) : '';
$ref_id_br = $ref_id;
$status = strtoupper(substr($ref_id, 0, 2));

if ($ref_id == '') {
    die('ไม่พบ ref_id');
}

/* =========================
   หัวเอกสารหลัก
========================= */
if ($status == 'SO') {
    $sql = "SELECT * FROM hos__so WHERE ref_id = '".$ref_id."'";
    $qry = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $rs = mysqli_fetch_assoc($qry);
    $bill_name = isset($rs["bill_name"]) ? $rs["bill_name"] : '';
    $delivery_date = isset($rs["delivery_date"]) ? $rs["delivery_date"] : '';
    $iv_no = isset($rs["iv_no"]) ? $rs["iv_no"] : '';
    $po_no_main = isset($rs["po_no"]) ? $rs["po_no"] : '';
} else {
    $sql = "SELECT * FROM hos__br WHERE ref_id_br = '".$ref_id."'";
    $qry = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $rs = mysqli_fetch_assoc($qry);
    $bill_name = isset($rs["customer"]) ? $rs["customer"] : '';
    $delivery_date = isset($rs["delivery_date"]) ? $rs["delivery_date"] : '';
    $iv_no = isset($rs["iv_no"]) ? $rs["iv_no"] : '';
    $po_no_main = isset($rs["po_no"]) ? $rs["po_no"] : '';
}

$sql1 = "SELECT * FROM tb_register_data WHERE ref_id = '".$ref_id."'";
$query1 = mysqli_query($conn, $sql1);
$fetch1 = mysqli_fetch_array($query1, MYSQLI_ASSOC);

$address_name = isset($fetch1["address_name"]) ? $fetch1["address_name"] : '';
$address_send = isset($fetch1["address_send"]) ? $fetch1["address_send"] : '';

/* =========================
   รายการสินค้า
========================= */
if ($status == 'SO') {
    $strSQL1_sn = "
        SELECT hos__subso.*, tb_product.product_id, tb_product.sol_name, tb_product.brand_id, tb_product.model_id, tb_product.unit_name
        FROM hos__subso
        LEFT JOIN tb_product ON hos__subso.product_ID = tb_product.product_id
        WHERE hos__subso.ref_idd = '".$ref_id."'
          AND hos__subso.sn != ''
          AND tb_product.unit_name = 'เตียง'
    ";
} else {
    $strSQL1_sn = "
        SELECT hos__subbr.*, tb_product.product_id, tb_product.sol_name, tb_product.brand_id, tb_product.model_id, tb_product.unit_name
        FROM hos__subbr
        LEFT JOIN tb_product ON hos__subbr.product_ID = tb_product.product_id
        WHERE hos__subbr.ref_idd_br = '".$ref_id."'
          AND hos__subbr.sn != ''
          AND tb_product.unit_name = 'เตียง'
    ";
}

$objQuery1_sn = mysqli_query($conn, $strSQL1_sn) or die("Error Query [" . $strSQL1_sn . "]");

$pm_rows = array();
$pm_header_warranty_text = '';
?>
<!doctype html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <title>รายงานการตรวจสอบสินค้าที่สถานที่ของลูกค้า</title>

    <link rel="stylesheet" href="css/normalize.min.css">
    <link rel="stylesheet" href="css/paper.css">
    <link rel="stylesheet" href="css/w3.css">

    <style>
        #tableDtel > table,
        #tableDtel th,
        #tableDtel td {
            border: 1px solid #202020;
            border-collapse: collapse;
            font-weight: bold;
        }

        #tableDtel table {
            width: 100%;
            border-collapse: collapse;
            table-layout: auto;
        }

        #tableDtel th,
        #tableDtel td {
            padding: 4px;
            font-size: 12px;
            white-space: nowrap;
        }

        .Page {
            font: 14pt "Angsana New";
        }

        .page-break {
            page-break-after: always;
            break-after: page;
        }

        .avoid-break {
            page-break-inside: avoid;
            break-inside: avoid;
        }

        @media print {
            .Page {
                display: block !important;
                min-height: auto !important;
                height: auto !important;
            }

            .divFooter {
                margin-top: 20px !important;
            }
        }
    </style>
</head>
<body class="A4">
<?php
while ($objResult1_sn = mysqli_fetch_array($objQuery1_sn)) {

    if (empty($objResult1_sn["sn"])) {
        continue;
    }

    $sn_list = preg_split("/\r\n|\n|\r/", $objResult1_sn["sn"]);

    foreach ($sn_list as $sn_value) {

        $product_sn = trim($sn_value);
        if (strlen($product_sn) <= 2) {
            continue;
        }

        $product_id = $objResult1_sn["product_id"];
        $current_pm = isset($objResult1_sn["pm"]) ? (int)$objResult1_sn["pm"] : 1;
        $current_warranty = isset($objResult1_sn["warranty"]) ? (int)$objResult1_sn["warranty"] : 1;

        if ($current_pm <= 0) $current_pm = 1;
        if ($current_warranty <= 0) $current_warranty = 1;

        /* =========================
           เอกสารตรวจเช็ค
        ========================= */
        $s_item0 = "SELECT * FROM document_checking 
                    WHERE product_id = '".$product_id."' 
                      AND ckk = '2' 
                      AND type_doc = '1' 
                    ORDER BY id DESC";
        $q_item0 = mysqli_query($service, $s_item0);
        $n_item0 = mysqli_num_rows($q_item0);
        $v_item0 = mysqli_fetch_array($q_item0);

        if ($n_item0 < 1) {
            echo '<a style="text-decoration: none;" href="add_proa.php"><h1><center style="color:#ff8080; margin-top:200px;">ไม่พบใบตรวจเช็คสินค้าเข้าต่างประเทศของท่าน <br>(Checking Details of Imported Product)</center></h1></a>';
            continue;
        }

        /* =========================
           main by SN
        ========================= */
        $s_main_a = "SELECT * FROM tb_checking_en_main WHERE sn_number = '".$product_sn."' ORDER BY id DESC LIMIT 1";
        $q_main_a = mysqli_query($service, $s_main_a);
        $v_main_a = mysqli_fetch_array($q_main_a);

        if (!$v_main_a) {
            continue;
        }

        $id_fk = $v_main_a['id_fk'];

        $strSQL16 = "SELECT service_order_no, product_sn 
                     FROM tb_service_order  
                     WHERE product_sn = '".$v_main_a['sn_number']."' 
                     ORDER BY id DESC LIMIT 1";
        $objQuery16 = mysqli_query($service, $strSQL16);
        $objResult16 = mysqli_fetch_array($objQuery16);
        $service_order_no = isset($objResult16['service_order_no']) ? $objResult16['service_order_no'] : '';

        $s_frequency = "SELECT service_order_no, Frequency 
                        FROM tb_product_checking_report_new_main 
                        WHERE service_order_no = '".$service_order_no."' 
                        ORDER BY id DESC LIMIT 1";
        $q_frequency = mysqli_query($service, $s_frequency);
        $v_frequency = mysqli_fetch_array($q_frequency);
        $frequency_value = isset($v_frequency['Frequency']) ? $v_frequency['Frequency'] : '';

        $s_product = "SELECT sol_name, brand_id, model_id 
                      FROM tb_product 
                      WHERE product_ID = '".$product_id."'";
        $q_product = mysqli_query($stock, $s_product);
        $v_product = mysqli_fetch_array($q_product);

        $s_item1 = "SELECT * FROM document_checking1 WHERE id_fk = '".$id_fk."'";
        $q_item1 = mysqli_query($service, $s_item1);
        $v_item1 = mysqli_fetch_array($q_item1);

        $s_item2 = "SELECT * FROM document_checking2 WHERE id_fk = '".$id_fk."'";
        $q_item2 = mysqli_query($service, $s_item2);
        $v_item2 = mysqli_fetch_array($q_item2);

        $s_item3 = "SELECT * FROM document_checking3 WHERE id_fk = '".$id_fk."'";
        $q_item3 = mysqli_query($service, $s_item3);
        $v_item3 = mysqli_fetch_array($q_item3);

        $s_item4 = "SELECT * FROM document_checking4 
                    WHERE id_fk = '".$id_fk."' 
                      AND type_doc = '1'";
        $q_item4 = mysqli_query($service, $s_item4);
        $v_item4 = mysqli_fetch_array($q_item4);

        $s_main = "SELECT * FROM tb_checking_en_main WHERE id = '".$v_main_a['id']."'";
        $q_main = mysqli_query($service, $s_main);
        $v_main = mysqli_fetch_array($q_main);

        $s_img = "SELECT * FROM tb_checking_images 
                  WHERE po_no = '".$v_main['po_no']."' 
                    AND sn_number = '".$v_main['sn_number']."'";
        $q_img = mysqli_query($service, $s_img);
        $v_img = mysqli_fetch_array($q_img);

        $s_check1 = "SELECT * FROM tb_service_check 
                     WHERE product_sn = '".$v_main['sn_number']."' 
                       AND service_check_terms = '1'";
        $q_check1 = mysqli_query($service, $s_check1);
        $v_check1 = mysqli_fetch_array($q_check1);

        $s_check2 = "SELECT * FROM tb_service_check 
                     WHERE product_sn = '".$v_main['sn_number']."' 
                       AND service_check_terms = '2'";
        $q_check2 = mysqli_query($service, $s_check2);
        $v_check2 = mysqli_fetch_array($q_check2);

        $s_warranty = "SELECT * FROM tb_installation_data 
                       WHERE product_sn = '".$v_main['sn_number']."' 
                       ORDER BY id DESC LIMIT 1";
        $q_warranty = mysqli_query($service, $s_warranty);
        $v_warranty = mysqli_fetch_array($q_warranty);

        $install_date = '';
        $warranty_phase = 0;
        if ($v_warranty) {
            $install_date = isset($v_warranty['install_date']) ? $v_warranty['install_date'] : '';
            $warranty_phase = $current_warranty;
        }

        /* =========================
           ตาราง PM
        ========================= */
        $warranty_year = $current_warranty;
        $pm_per_year = $current_pm;
        $total_pm = $warranty_year * $pm_per_year;

        if (!empty($install_date) && $install_date != '0000-00-00') {
            $start_date = $install_date;
        } else {
            $start_date = $delivery_date;
        }

        $interval_month = floor(12 / $pm_per_year);
        if ($interval_month <= 0) $interval_month = 12;

        $pm_dates = array();
   for ($i = 1; $i <= $total_pm; $i++) {
    $pm_date = date(
        'Y-m-d',
        strtotime($start_date . ' +' . ($i * $interval_month) . ' months')
    );

    $pm_dates[] = $pm_date;
}

        $pm_rows[] = array(
            'model_id'       => isset($v_item0['model_id']) ? $v_item0['model_id'] : '',
            'sn_number'      => $v_main['sn_number'],
            'pm_per_year'    => $pm_per_year,
            'total_pm'       => $total_pm,
            'pm_dates'       => $pm_dates,
            'warranty_phase' => $warranty_phase
        );

        $current_warranty = isset($objResult1_sn["warranty"]) ? trim($objResult1_sn["warranty"]) : 1;

if ($current_warranty == '2 ปี' || $current_warranty == '2year') {
    $current_warranty = 2;
}

if ($pm_header_warranty_text == '') {
    $pm_header_warranty_text = getWarrantyPeriod($current_warranty);
}
?>
    <section class="Page A4 sheet padding-10mm page-break">
        <header>
            <div class="w3-half" style="text-align: left; font-size: 15px;">
                <?php echo isset($v_item1['company_thai']) ? $v_item1['company_thai'] : ''; ?><br>
            </div>
            <div class="w3-half" style="text-align: right; font-size: 15px;">
                <?php echo isset($v_item1['company_eng']) ? $v_item1['company_eng'] : ''; ?><br>
            </div>
            <div class="w3-bar w3-border"></div>
            <div class="w3-half" style="text-align: left; font-size: 15px;">
                73,75 ซอยจรัญสนิทวงศ์ 89/2 ถนนจรัญสนิทวงศ์ แขวงบางอ้อ<br>
                เขตบางพลัด กรุงเทพฯ 10700<br>
                โทร : 0-2424-3555 แฟ็กซ์ : 0-2424-3322 <br>
                E-mail : service@allwelllifegroup.com
            </div>
            <div class="w3-half" style="text-align: right; font-size: 15px;">
                73,75 Charansanitwong Rd., Bang-Or,<br>
                Bang-Plad, Bangkok 10700<br>
                Tel : 0-2424-3555 Fax : 0-2424-3322<br>
                E-mail : service@allwelllifegroup.com
            </div>
        </header>

        <center><div style="font-size: 18px;"><b>รายงานการตรวจสอบสินค้าที่สถานที่ของลูกค้า</b></div></center>
        <center><div style="font-size: 18px;"><b>(Product-Checking Report at Customer' Location)</b></div></center><br>

        <table style="width: 100%; border-collapse: collapse;">
            <tr style="font-size: 15px;">
                <td style="border: 1px solid black;">Hospital/Customer: <?php echo $bill_name; ?></td>
                <td style="border: 1px solid black;">Department/Room: <?php echo $address_name; ?></td>
                <td style="border: 1px solid black;">Date: <?php echo DateThai($delivery_date); ?></td>
            </tr>
            <tr style="font-size: 15px;">
                <td style="border: 1px solid black;">Equipment Name : <?php echo isset($v_item0['model_id']) ? $v_item0['model_id'] : ''; ?></td>
                <td style="border: 1px solid black;">S/N : <?php echo $v_main['sn_number']; ?></td>
                <td style="border: 1px solid black;">W/O,IV : <?php echo $iv_no; ?></td>
            </tr>
            <tr style="font-size: 15px;">
                <td style="border: 1px solid black; vertical-align: top;">Frequency</td>
                <td style="border: 1px solid black; border-left: hidden; padding:8px 0px;">
                    <font style="font-size:15px; padding:0px 6px; border: 1px solid #202020;">
                        <?php echo ($frequency_value == '3') ? '&#10003;' : '&nbsp;&nbsp;&nbsp;&nbsp;'; ?>
                    </font> 3 Months
                    <br><br>
                    <font style="font-size:15px; padding:0px 6px; border: 1px solid #202020;">
                        <?php echo ($frequency_value == '6') ? '&#10003;' : '&nbsp;&nbsp;&nbsp;&nbsp;'; ?>
                    </font> 6 Months
                </td>
                <td style="border: 1px solid black; border-left: hidden; padding:8px 0px;">
                    <font style="font-size:15px; padding:0px 6px; border: 1px solid #202020;">
                        <?php echo ($frequency_value == '4') ? '&#10003;' : '&nbsp;&nbsp;&nbsp;&nbsp;'; ?>
                    </font> 4 Months
                    <br><br>
                    <font style="font-size:15px; padding:0px 6px; border: 1px solid #202020;">
                        <?php echo ($frequency_value == '12') ? '&#10003;' : '&nbsp;&nbsp;&nbsp;&nbsp;'; ?>
                    </font> 1 Year
                </td>
            </tr>
        </table>

        <div style="display: grid; place-items: center; padding:20px 0px 0px 0px;">
            <div style="width: 150px; display: flex; justify-content: space-between;">
                Inspected <span style="width: 30px; text-align:center; font-size:15px; padding:0px 6px; border: 1px solid #202020;">&#10003;</span>
            </div>
            <div style="width: 150px; display: flex; justify-content: space-between;">
                Damaged <span style="width: 30px; text-align:center; font-size:15px; padding:0px 6px; border: 1px solid #202020;">D</span>
            </div>
            <div style="width: 150px; display: flex; justify-content: space-between;">
                Not Applicable <span style="width: 30px; text-align:center; font-size:15px; padding:0px 6px; border: 1px solid #202020;">N/A</span>
            </div>
        </div>

        <br>
        Visual cheok and rectify

        <table style="width: 100%;">
            <tr>
                <td style="width: 50%; vertical-align:top; padding:0px;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="width: 85%;"><b>1.Mechanical Inspection / Operation</b></td>
                            <td style="width: 15%; text-align: center;">ผ่าน</td>
                        </tr>
                        <?php
                        $numrows_03 = 1;
                        $s_key = "SELECT c2_1.item_id, c2_1.ckk_subtopic, c2_1.subtopic, c2.item_name, c2.images_main
                                  FROM document_checking2_1 c2_1
                                  LEFT JOIN document_checking2 c2 ON c2_1.item_id = c2.id
                                  WHERE c2.item_id = 3 AND c2_1.id_fk = '".$id_fk."'";
                        $q_key = mysqli_query($service, $s_key);
                        $n_key = mysqli_num_rows($q_key);
                        ?>
                        <input type="hidden" name="n_key3" id="n_key3" value="<?php echo $n_key; ?>">
                        <?php while ($v_key = mysqli_fetch_array($q_key)) {
                            $s_ck1 = "SELECT ckk_list1, ckk_list2, ckk_list3, t_list1, item_id
                                      FROM tb_checking_en
                                      WHERE item_id = '".$v_key['item_id']."'
                                        AND po_no = '".$v_main['po_no']."'
                                        AND sn_number = '".$v_main['sn_number']."'";
                            $q_ck1 = mysqli_query($service, $s_ck1);
                            $v_ck1 = mysqli_fetch_array($q_ck1);
                        ?>
                            <tr style="text-align: left;">
                                <td style="width: 85%;">
                                    <?php if (!empty($v_key['images_main'])) { ?>
                                        <a style="text-decoration: none;" href="up_img/<?php echo $v_key['images_main']; ?>" target="_blank"><?php echo $v_key['item_name']; ?></a>
                                    <?php } else {
                                        echo $v_key['item_name'];
                                    } ?>
                                    <input type="hidden" name="key_id3" id="key_id3" value="<?php echo $numrows_03; ?>">
                                </td>
                                <td style="width: 15%; border: 1px solid black; text-align: center;">
                                    <?php
                                    if (($v_key['item_id'] == @$v_ck1['item_id']) && @$v_ck1['ckk_list1'] == 2) {
                                        echo '&#10003;';
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php $numrows_03++; } ?>
                    </table>
                </td>

                <td style="width: 50%; vertical-align: top;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="width: 70%;"><b>2.Safety Testing</b></td>
                            <td style="width: 15%; text-align: center;">ค่าที่วัดได้</td>
                            <td style="width: 15%; text-align: center;">ผ่าน</td>
                        </tr>
                        <?php
                        $numrows_04 = 1;
                        $s_key = "SELECT c2_1.item_id, c2_1.ckk_subtopic, c2_1.subtopic, c2.item_name, c2.images_main
                                  FROM document_checking2_1 c2_1
                                  LEFT JOIN document_checking2 c2 ON c2_1.item_id = c2.id
                                  WHERE c2.item_id = 4 AND c2_1.id_fk = '".$id_fk."'";
                        $q_key = mysqli_query($service, $s_key);
                        $n_key = mysqli_num_rows($q_key);
                        ?>
                        <input type="hidden" name="n_key4" id="n_key4" value="<?php echo $n_key; ?>">
                        <?php while ($v_key = mysqli_fetch_array($q_key)) {
                            $s_ck1 = "SELECT ckk_list1, ckk_list2, ckk_list3, t_list1, item_id
                                      FROM tb_checking_en
                                      WHERE item_id = '".$v_key['item_id']."'
                                        AND po_no = '".$v_main['po_no']."'
                                        AND sn_number = '".$v_main['sn_number']."'";
                            $q_ck1 = mysqli_query($service, $s_ck1);
                            $v_ck1 = mysqli_fetch_array($q_ck1);
                        ?>
                            <tr style="text-align: left;">
                                <td style="width: 70%;">
                                    <?php if (!empty($v_key['images_main'])) { ?>
                                        <a style="text-decoration: none;" href="up_img/<?php echo $v_key['images_main']; ?>" target="_blank"><?php echo $v_key['item_name']; ?></a>
                                    <?php } else {
                                        echo $v_key['item_name'];
                                    } ?>
                                    <input type="hidden" name="key_id4" id="key_id4" value="<?php echo $numrows_04; ?>">
                                </td>
                                <td style="width: 15%; border: 1px solid black; text-align:center;">
                                    <?php
                                    if (($v_key['item_id'] == @$v_ck1['item_id']) && @$v_ck1['t_list1'] != '') {
                                        echo $v_ck1['t_list1'];
                                    }
                                    ?>
                                </td>
                                <td style="width: 15%; border: 1px solid black; text-align:center;">
                                    <?php
                                    if (($v_key['item_id'] == @$v_ck1['item_id']) && @$v_ck1['ckk_list1'] == 2) {
                                        echo '&#10003;';
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php $numrows_04++; } ?>
                    </table>
                </td>
            </tr>
        </table>

        <br><br>
        <div style="font-size: 18px; text-align: left;"><b>รายละเอียดเพิ่มเติม :</b></div>
        <br><div class="w3-bar w3-border w3-black"></div>
        <br><div class="w3-bar w3-border w3-black"></div>
        <br><div class="w3-bar w3-border w3-black"></div>

        <br><br>

        <table style="width:720px" border="0" class="avoid-break">
            <tr>
                <td style="width:50%; text-align:center;">
                    <u>
                        <?php echo isset($v_main_a['add_name1']) ? $v_main_a['add_name1'] : ''; ?>
                        / <?php echo DateThai($delivery_date); ?>
                    </u>
                </td>
                <td style="width:50%; text-align:center;">
                    <u>
                        <?php echo isset($v_main_a['add_name2']) ? $v_main_a['add_name2'] : ''; ?>
                        / <?php echo DateThai($delivery_date); ?>
                    </u>
                </td>
            </tr>
            <tr>
                <td style="width:50%; text-align:center;">Performed by</td>
                <td style="width:50%; text-align:center;">Approved by</td>
            </tr>
        </table>

        <div class="divFooter avoid-break">
            <div class="w3-bar w3-border"></div>
            <table style="width:720px" border="0">
                <tr>
                    <td style="width:50%; text-align:left;">อนุมัติวันที่ 31 ก.ค. 2568</td>
                    <td style="width:50%; text-align:right;">FM-EN-04.01:Rev.0</td>
                </tr>
            </table>
        </div>
    </section>
<?php
    }
}
?>

<?php
$max_total_pm = 0;
foreach ($pm_rows as $r) {
    if ($r['total_pm'] > $max_total_pm) {
        $max_total_pm = $r['total_pm'];
    }
}
if ($max_total_pm <= 0) $max_total_pm = 1;
?>

<section class="Page A4 landscape padding-10mm" style="background-color:#FFFFFF; padding:40px; margin:2%;">
    <div>
        <center><b>แผนการบำรุงรักษาเครื่องมือแพทย์ <br> MAINTENANCE SCHEDULE</b></center>

        <div style="display:flex; justify-content:space-between; font-weight:bold; margin-top:10px;">
            <div>
                <span>ชื่อลูกค้า <?php echo $bill_name; ?></span>
                <span style="margin-left: 50px;">PO <?php echo $po_no_main; ?></span>
            </div>
            <div>
                รับประกัน <?php echo ($pm_header_warranty_text != '' ? $pm_header_warranty_text : 'ไม่ระบุ'); ?>
            </div>
        </div>

        <div id="tableDtel" style="margin-top:10px;">
            <table>
                <tr>
                    <th rowspan="2">สินค้า</th>
                    <th rowspan="2">หมายเลขเครื่อง</th>
                    <th rowspan="2">ความถี่/ปี</th>
                    <th colspan="<?php echo $max_total_pm * 2; ?>">รอบ PM ทั้งหมด</th>
                </tr>
                <tr>
                    <?php for ($i = 1; $i <= $max_total_pm; $i++) { ?>
                        <th>ครั้งที่ <?php echo $i; ?></th>
                        <th>เซ็น</th>
                    <?php } ?>
                </tr>

                <?php foreach ($pm_rows as $row_pm) { ?>
                    <tr>
                        <td style="text-align:center;"><?php echo $row_pm['model_id']; ?></td>
                        <td style="text-align:center;"><?php echo $row_pm['sn_number']; ?></td>
                        <td style="text-align:center;"><?php echo $row_pm['pm_per_year']; ?></td>

                        <?php
                        for ($i = 1; $i <= $max_total_pm; $i++) {
                            if (isset($row_pm['pm_dates'][$i - 1])) {
                                echo '<td style="text-align:center;">' . DateThai($row_pm['pm_dates'][$i - 1]) . '</td>';
                                echo '<td>&nbsp;</td>';
                            } else {
                                echo '<td>&nbsp;</td><td>&nbsp;</td>';
                            }
                        }
                        ?>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>

    <div style="margin-top:20px; padding-left:10%;">
        <p>การบำรุงรักษาโดยเจ้าหน้าที่ของบริษัท ตามความเหมาะสมของแผนงาน</p>
        <p>กำหนดเข้าบำรุงรักษาตามรอบของแต่ละเครื่อง</p>

        <p style="font-weight:bold;">หมายเหตุ</p>
        <hr style="border:1px solid #202020;">
        <hr style="border:1px solid #202020;">
        <hr style="border:1px solid #202020;">

        <p style="font-weight:bold;">
            จัดจำหน่ายและบริการหลังการขายโดย บริษัท ออลล์เวล ไลฟ์ จำกัด 02-424-3555
        </p>
    </div>
</section>

</body>
</html>