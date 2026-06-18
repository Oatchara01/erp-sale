<?php
date_default_timezone_set("Asia/Bangkok");

include "dbconnect.php";
include "dbconnect_sale.php";


function h($str)
{
    return htmlspecialchars((string)$str, ENT_QUOTES, 'UTF-8');
}

function DateThai($strDate)
{
    if (empty($strDate)) return '';
    $strYear = date("Y", strtotime($strDate)) + 543;
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));
    $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    $strMonthThai = $strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear";
}

function getCompanyName($company)
{
    if ($company == '3') {
        return "บริษัท ออลล์เวล ไลฟ์ จำกัด";
    } elseif ($company == '4') {
        return "บริษัท โนเบิล เมด จำกัด";
    }
    return "";
}

function getMonthThaiYear($start_date)
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

    if (empty($start_date)) {
        return ["", ""];
    }

    $date_arr = explode('-', $start_date);
    $yy = $date_arr[0] ?? '';
    $mm = $date_arr[1] ?? '';
    $thaiMonth = $_month_name[$mm] ?? '';
    $thaiYear = ($yy !== '') ? ((int)$yy + 543) : '';

    return [$thaiMonth, $thaiYear];
}

function fetchOne($conn, $sql)
{
    $query = mysqli_query($conn, $sql) or die("Error Query [" . $sql . "]");
    return mysqli_fetch_assoc($query);
}

function fetchAll($conn, $sql)
{
    $result = mysqli_query($conn, $sql) or die("Error Query [" . $sql . "]");
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function formatMoney($num)
{
    return number_format((float)$num, 2);
}

function exVat($amount)
{
    return (float)$amount / 1.07;
}

function getSaleName($com, $sale_code)
{
    $sql = "SELECT sale_name FROM tb_team_adm WHERE sale_code='" . mysqli_real_escape_string($com, $sale_code) . "'";
    $row = fetchOne($com, $sql);
    return $row['sale_name'] ?? '';
}

function getSaleChannelName($conn, $saleChannelId)
{
    $sql = "SELECT salechannel_nameshort FROM tb_salechannel WHERE salechannel_ID='" . mysqli_real_escape_string($conn, $saleChannelId) . "'";
    $row = fetchOne($conn, $sql);
    return $row['salechannel_nameshort'] ?? '';
}

function getProductInfo($conn, $productId)
{
    $sql = "SELECT sol_name, unit_name FROM tb_product WHERE product_ID='" . mysqli_real_escape_string($conn, $productId) . "'";
    $row = fetchOne($conn, $sql);
    return [
        'sol_name' => $row['sol_name'] ?? '',
        'unit_name' => $row['unit_name'] ?? ''
    ];
}

function renderSalesHeader($title, $subTitle = '')
{
    echo '<div class="section-title">' . h($title) . '</div>';
    if ($subTitle !== '') {
        echo '<div class="section-subtitle">' . h($subTitle) . '</div>';
    }
}

function renderTableHeaderSales()
{
    echo '
    <table class="report-table">
        <thead>
            <tr>
                <th width="10%">เลขที่อ้างอิง</th>
                <th width="10%">วันเดือนปี</th>
                <th width="10%">เลขที่</th>
                <th width="10%">ช่องทางการขาย</th>
                <th width="20%">ชื่อลูกค้า</th>
                <th width="20%">ชื่อสินค้า</th>
                <th width="10%">จำนวน</th>
                <th width="10%">ยอดลูกหนี้</th>
                <th width="10%">รายได้จากขาย</th>
            </tr>
        </thead>
        <tbody>
    ';
}

function renderTableHeaderCredit()
{
    echo '
    <table class="report-table">
        <thead>
            <tr>
                <th width="10%">เลขที่อ้างอิง</th>
                <th width="10%">วันเดือนปี</th>
                <th width="10%">เลขที่</th>
                <th width="25%">ชื่อลูกค้า</th>
                <th width="25%">ชื่อสินค้า</th>
                <th width="10%">จำนวน</th>
                <th width="10%">ยอดลูกหนี้</th>
                <th width="10%">รายได้จากขาย</th>
            </tr>
        </thead>
        <tbody>
    ';
}

function closeTable()
{
    echo '</tbody></table>';
}

function renderSummaryRow($label, $amount, $exVatAmount, $class = 'summary-red')
{
    echo '
    <table class="summary-table">
        <tr class="' . h($class) . '">
            <td width="90%" class="left-cell">' . h($label) . '</td>
            <td width="10%" class="right-cell">' . formatMoney($amount) . '</td>
            <td width="10%" class="right-cell">' . formatMoney($exVatAmount) . '</td>
        </tr>
    </table>
    ';
}

$start_date = $_GET["start_date"] ?? '';
$end_date   = $_GET["end_date"] ?? '';
$sale_code  = $_GET["sale_code"] ?? '';
$str_arr    = $_GET["company"] ?? '';

$company  = substr($str_arr, 0, 1);
$company1 = substr($str_arr, -1);

$company_name = getCompanyName($company);
list($thaiMonth, $thaiYear) = getMonthThaiYear($start_date);
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <title>Monthly Sales Record</title>
    <link rel="stylesheet" href="css/w32.css">
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
            font-family: 'Prompt', sans-serif;
        }

        body {
            margin: 20px;
            background: #f8fafc;
            color: #1f2937;
            font-size: 14px;
            line-height: 1.6;
        }

        .report-wrapper {
            max-width: 1400px;
            margin: 0 auto;
            background: #ffffff;
            padding: 24px;
            border-radius: 14px;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.06);
        }

        .page-title {
            text-align: center;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 4px;
            color: #111827;
        }

        .page-subtitle {
            text-align: center;
            font-size: 20px;
            font-weight: 500;
            margin-bottom: 4px;
            color: #374151;
        }

        .page-company {
            text-align: center;
            font-size: 18px;
            font-weight: 500;
            margin-bottom: 24px;
            color: #1d4ed8;
        }

        .section-title {
            text-align: center;
            font-size: 20px;
            font-weight: 600;
            margin-top: 26px;
            margin-bottom: 4px;
            color: #dc2626;
        }

        .section-subtitle {
            text-align: center;
            font-size: 15px;
            font-weight: 500;
            margin-bottom: 14px;
            color: #6b7280;
        }

        .report-table,
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
            background: #fff;
        }

        .report-table th {
            background: #b49ad3;
            color: #111827;
            font-size: 13px;
            font-weight: 600;
            padding: 10px 8px;
            border: 1px solid #cbd5e1;
            text-align: center;
        }

        .report-table td {
            border: 1px solid #dbeafe;
            padding: 8px 10px;
            font-size: 13px;
            color: #111827;
            vertical-align: middle;
        }

        .report-table tbody tr:nth-child(even) {
            background: #f9fbff;
        }

        .left {
            text-align: left;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .doc-link {
            color: #2563eb;
            text-decoration: none;
            font-weight: 500;
        }

        .doc-link:hover {
            text-decoration: underline;
        }

        .summary-table td {
            border: 1px solid #cbd5e1;
            padding: 10px 12px;
            font-size: 14px;
            font-weight: 600;
        }

        .summary-red td {
            background: #fff1f2;
            color: #b91c1c;
        }

        .summary-blue td {
            background: #eff6ff;
            color: #1d4ed8;
        }

        .left-cell {
            text-align: left;
        }

        .right-cell {
            text-align: right;
        }

        .divider {
            height: 1px;
            background: #e5e7eb;
            margin: 24px 0;
        }
    </style>
</head>
<body>
<div class="report-wrapper">

    <div class="page-title">Monthly Sales Record</div>
    <div class="page-subtitle"><?php echo h($thaiMonth . ' ' . $thaiYear); ?></div>
    <div class="page-company"><?php echo h($company_name); ?></div>

<?php
if ($sale_code != '') {

    $sale_name = getSaleName($com, $sale_code);
    renderSalesHeader($sale_name . ' : ' . $sale_code);

    // ===== รวมยอดขาย (doc_no) =====
    $strSQL5 = "SELECT SUM(sum_amount) AS total 
                FROM (so__main LEFT JOIN so__submain ON so__main.ref_id = so__submain.ref_idd)
                WHERE doc_no != '' AND cancel_ckk = '0'";

    if ($start_date != "") $strSQL5 .= ' AND doc_release_date >= "' . $start_date . '"';
    if ($end_date != "")   $strSQL5 .= ' AND doc_release_date <= "' . $end_date . '"';
    if ($company != "")    $strSQL5 .= ' AND select_type_doc = "' . $company . '"';
    if ($sale_code != "")  $strSQL5 .= ' AND employee_name = "' . $sale_code . '"';

    $objResult5 = fetchOne($conn, $strSQL5);
    $totalDoc = (float)($objResult5['total'] ?? 0);

    // ===== รวมยอดขาย (iv_no) =====
    $strSQL15 = "SELECT SUM(sum_amount) AS total1
                 FROM (so__main LEFT JOIN so__submain ON so__main.ref_id = so__submain.ref_idd)
                 WHERE iv_no != '' AND cancel_ckk = '0'";

    if ($start_date != "") $strSQL15 .= ' AND iv_date >= "' . $start_date . '"';
    if ($end_date != "")   $strSQL15 .= ' AND iv_date <= "' . $end_date . '"';
    if ($company1 != "")   $strSQL15 .= ' AND select_type_doc = "' . $company1 . '"';
    if ($sale_code != "")  $strSQL15 .= ' AND employee_name = "' . $sale_code . '"';

    $objResult15 = fetchOne($conn, $strSQL15);
    $totalIv = (float)($objResult15['total1'] ?? 0);

    $totalSales = $totalDoc + $totalIv;
    $totalSalesExVat = exVat($totalSales);

    renderTableHeaderSales();

    // ===== รายการ doc_no =====
    $strSQL11 = "SELECT doc_no, doc_release_date, customer_name, ref_id, sale_channel
                 FROM so__main
                 WHERE doc_no != '' AND cancel_ckk = '0'";

    if ($start_date != "") $strSQL11 .= ' AND doc_release_date >= "' . $start_date . '"';
    if ($end_date != "")   $strSQL11 .= ' AND doc_release_date <= "' . $end_date . '"';
    if ($company != "")    $strSQL11 .= ' AND select_type_doc = "' . $company . '"';
    if ($sale_code != "")  $strSQL11 .= ' AND employee_name = "' . $sale_code . '"';
    $strSQL11 .= " ORDER BY doc_no ASC";

    $salesDocs = fetchAll($conn, $strSQL11);

    foreach ($salesDocs as $doc) {
        $strSQL12 = "SELECT product_id, sale_count, sum_amount
                     FROM so__submain
                     WHERE ref_idd = '" . $doc["ref_id"] . "'";
        $subs = fetchAll($conn, $strSQL12);

        foreach ($subs as $sub) {
            $product = getProductInfo($conn, $sub["product_id"]);
            $saleChannelName = getSaleChannelName($conn, $doc["sale_channel"]);

            $summary = (float)$sub['sum_amount'];
            $noVat = exVat($summary);

            echo '<tr>
                <td class="center">' . h($doc["ref_id"]) . '</td>
                <td class="center">' . h(DateThai($doc["doc_release_date"])) . '</td>
                <td class="center"><a class="doc-link" href="register_admin_edit.php?ref_id=' . h($doc["ref_id"]) . '" target="_blank">' . h($doc["doc_no"]) . '</a></td>
                <td class="left">' . h($saleChannelName) . '</td>
                <td class="left">' . h($doc["customer_name"]) . '</td>
                <td class="left">' . h($product["sol_name"]) . '</td>
                <td class="right">' . h($sub["sale_count"]) . ' ' . h($product["unit_name"]) . '</td>
                <td class="right">' . formatMoney($summary) . '</td>
                <td class="right">' . formatMoney($noVat) . '</td>
            </tr>';
        }
    }

    // ===== รายการ iv_no =====
    $strSQL21 = "SELECT iv_no, iv_date, customer_name, ref_id, doc_no, sale_channel
                 FROM so__main
                 WHERE iv_no != '' AND cancel_ckk = '0'";

    if ($start_date != "") $strSQL21 .= ' AND iv_date >= "' . $start_date . '"';
    if ($end_date != "")   $strSQL21 .= ' AND iv_date <= "' . $end_date . '"';
    if ($company1 != "")   $strSQL21 .= ' AND select_type_doc = "' . $company1 . '"';
    if ($sale_code != "")  $strSQL21 .= ' AND employee_name = "' . $sale_code . '"';
    $strSQL21 .= " ORDER BY iv_no ASC";

    $salesIv = fetchAll($conn, $strSQL21);

    foreach ($salesIv as $iv) {
        $strSQL22 = "SELECT product_id, sale_count, sum_amount
                     FROM so__submain
                     WHERE ref_idd = '" . $iv["ref_id"] . "'";
        $subs = fetchAll($conn, $strSQL22);

        foreach ($subs as $sub) {
            $product = getProductInfo($conn, $sub["product_id"]);
            $saleChannelName = getSaleChannelName($conn, $iv["sale_channel"]);

            $summary = (float)$sub['sum_amount'];
            $noVat = exVat($summary);

            echo '<tr>
                <td class="center">' . h($iv["ref_id"]) . '</td>
                <td class="center">' . h(DateThai($iv["iv_date"])) . '</td>
                <td class="center"><a class="doc-link" href="register_admin_edit.php?ref_id=' . h($iv["ref_id"]) . '" target="_blank">' . h($iv["iv_no"]) . '</a></td>
                <td class="left">' . h($saleChannelName) . '</td>
                <td class="left">' . h($iv["customer_name"]) . '</td>
                <td class="left">' . h($product["sol_name"]) . '</td>
                <td class="right">' . h($sub["sale_count"]) . ' ' . h($product["unit_name"]) . '</td>
                <td class="right">' . formatMoney($summary) . '</td>
                <td class="right">' . formatMoney($noVat) . '</td>
            </tr>';
        }
    }

    closeTable();

    renderSummaryRow("รวมยอดขายของ Sale : " . $sale_code, $totalSales, $totalSalesExVat, 'summary-red');

    // ===== ตารางเครดิตโน้ต =====
    renderTableHeaderCredit();

    $strSQL211 = "SELECT credit_no, date_credit, customer_name, ref_credit
                  FROM tb_credit_note
                  WHERE credit_no != '' AND status_doc = 'Approve'";

    if ($start_date != "") $strSQL211 .= ' AND date_credit >= "' . $start_date . '"';
    if ($end_date != "")   $strSQL211 .= ' AND date_credit <= "' . $end_date . '"';
    if ($company != "")    $strSQL211 .= ' AND company_type = "' . $company . '"';
    if ($sale_code != "")  $strSQL211 .= ' AND sale_code = "' . $sale_code . '"';
    $strSQL211 .= " ORDER BY credit_no ASC";

    $credits = fetchAll($conn, $strSQL211);

    foreach ($credits as $credit) {
        $strSQL222 = "SELECT product_id, count, sum_amount
                      FROM tb_subcredit
                      WHERE ref_creditt = '" . $credit["ref_credit"] . "'";
        $subCredits = fetchAll($conn, $strSQL222);

        foreach ($subCredits as $subCredit) {
            $product = getProductInfo($conn, $subCredit["product_id"]);

            $summary = (float)$subCredit['sum_amount'];
            $noVat = exVat($summary);

            echo '<tr>
                <td class="center">' . h($credit["ref_credit"]) . '</td>
                <td class="center">' . h(DateThai($credit["date_credit"])) . '</td>
                <td class="center">' . h($credit["credit_no"]) . '</td>
                <td class="left">' . h($credit["customer_name"]) . '</td>
                <td class="left">' . h($product["sol_name"]) . '</td>
                <td class="right">' . h($subCredit["count"]) . ' ' . h($product["unit_name"]) . '</td>
                <td class="right">' . formatMoney($summary) . '</td>
                <td class="right">' . formatMoney($noVat) . '</td>
            </tr>';
        }
    }

    closeTable();

    $strSQL151 = "SELECT SUM(sum_amount) AS total15
                  FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit = tb_subcredit.ref_creditt)
                  WHERE credit_no != '' AND status_doc = 'Approve'";

    if ($start_date != "") $strSQL151 .= ' AND date_credit >= "' . $start_date . '"';
    if ($end_date != "")   $strSQL151 .= ' AND date_credit <= "' . $end_date . '"';
    if ($company != "")    $strSQL151 .= ' AND company_type = "' . $company . '"';
    if ($sale_code != "")  $strSQL151 .= ' AND sale_code = "' . $sale_code . '"';

    $objResult151 = fetchOne($conn, $strSQL151);
    $totalCredit = (float)($objResult151['total15'] ?? 0);
    $totalCreditExVat = exVat($totalCredit);

    renderSummaryRow("รวมยอดลดหนี้ของ Sale : " . $sale_code, $totalCredit, $totalCreditExVat, 'summary-red');

    $netTotal = $totalSales - $totalCredit;
    $netTotalExVat = $totalSalesExVat - $totalCreditExVat;

    renderSummaryRow("ยอดสุทธิของ Sale : " . $sale_code, $netTotal, $netTotalExVat, 'summary-blue');

} else {

    $strSQL = "SELECT * FROM tb_team_adm WHERE ckk = '1'";
    $salesTeam = fetchAll($com, $strSQL);

    foreach ($salesTeam as $saleRow) {

        $sale_code1 = $saleRow["sale_code"];
        $sale_name  = $saleRow["sale_name"];

        renderSalesHeader($sale_name . ' : ' . $sale_code1);

        // ===== รวมยอด doc =====
        $strSQL8 = "SELECT SUM(sum_amount) AS total8
                    FROM (so__main LEFT JOIN so__submain ON so__main.ref_id = so__submain.ref_idd)
                    WHERE doc_no != '' AND employee_name = '" . $sale_code1 . "' AND cancel_ckk = '0'";

        if ($start_date != "") $strSQL8 .= ' AND doc_release_date >= "' . $start_date . '"';
        if ($end_date != "")   $strSQL8 .= ' AND doc_release_date <= "' . $end_date . '"';
        if ($company != "")    $strSQL8 .= ' AND select_type_doc = "' . $company . '"';

        $objResult8 = fetchOne($conn, $strSQL8);
        $total8 = (float)($objResult8['total8'] ?? 0);

        // ===== รวมยอด iv =====
        $strSQL9 = "SELECT SUM(sum_amount) AS total9
                    FROM (so__main LEFT JOIN so__submain ON so__main.ref_id = so__submain.ref_idd)
                    WHERE iv_no != '' AND employee_name = '" . $sale_code1 . "' AND cancel_ckk = '0'";

        if ($start_date != "") $strSQL9 .= ' AND iv_date >= "' . $start_date . '"';
        if ($end_date != "")   $strSQL9 .= ' AND iv_date <= "' . $end_date . '"';
        if ($company1 != "")   $strSQL9 .= ' AND select_type_doc = "' . $company1 . '"';

        $objResult9 = fetchOne($conn, $strSQL9);
        $total9 = (float)($objResult9['total9'] ?? 0);

        $totalSales = $total8 + $total9;
        $totalSalesExVat = exVat($totalSales);

        renderTableHeaderSales();

        // ===== รายการ doc_no =====
        $strSQL10 = "SELECT doc_no, doc_release_date, customer_name, ref_id, tel, sale_channel
                     FROM so__main
                     WHERE doc_no != '' AND employee_name = '" . $sale_code1 . "' AND cancel_ckk = '0'";

        if ($start_date != "") $strSQL10 .= ' AND doc_release_date >= "' . $start_date . '"';
        if ($end_date != "")   $strSQL10 .= ' AND doc_release_date <= "' . $end_date . '"';
        if ($company != "")    $strSQL10 .= ' AND select_type_doc = "' . $company . '"';
        $strSQL10 .= " ORDER BY doc_no ASC";

        $docs = fetchAll($conn, $strSQL10);

        foreach ($docs as $doc) {
            $strSQL7 = "SELECT product_id, sale_count, sum_amount
                        FROM so__submain
                        WHERE ref_idd = '" . $doc["ref_id"] . "'";
            $subs = fetchAll($conn, $strSQL7);

            foreach ($subs as $sub) {
                $product = getProductInfo($conn, $sub["product_id"]);
                $saleChannelName = getSaleChannelName($conn, $doc["sale_channel"]);

                $summary = (float)$sub['sum_amount'];
                $noVat = exVat($summary);

                echo '<tr>
                    <td class="center">' . h($doc["ref_id"]) . '</td>
                    <td class="center">' . h(DateThai($doc["doc_release_date"])) . '</td>
                    <td class="center"><a class="doc-link" href="register_admin_edit.php?ref_id=' . h($doc["ref_id"]) . '" target="_blank">' . h($doc["doc_no"]) . '</a></td>
                    <td class="left">' . h($saleChannelName) . '</td>
                    <td class="left">' . h($doc["customer_name"]) . '</td>
                    <td class="left">' . h($product["sol_name"]) . '</td>
                    <td class="right">' . h($sub["sale_count"]) . ' ' . h($product["unit_name"]) . '</td>
                    <td class="right">' . formatMoney($summary) . '</td>
                    <td class="right">' . formatMoney($noVat) . '</td>
                </tr>';
            }
        }

        // ===== รายการ iv_no =====
        $strSQL26 = "SELECT iv_no, iv_date, customer_name, ref_id, tel, sale_channel
                     FROM so__main
                     WHERE iv_no != '' AND employee_name = '" . $sale_code1 . "' AND cancel_ckk = '0'";

        if ($start_date != "") $strSQL26 .= ' AND iv_date >= "' . $start_date . '"';
        if ($end_date != "")   $strSQL26 .= ' AND iv_date <= "' . $end_date . '"';
        if ($company1 != "")   $strSQL26 .= ' AND select_type_doc = "' . $company1 . '"';
        if ($sale_code != "")  $strSQL26 .= ' AND employee_name = "' . $sale_code . '"';
        $strSQL26 .= " ORDER BY iv_no ASC";

        $ivs = fetchAll($conn, $strSQL26);

        foreach ($ivs as $iv) {
            $strSQL27 = "SELECT product_id, sale_count, sum_amount
                         FROM so__submain
                         WHERE ref_idd = '" . $iv["ref_id"] . "'";
            $subs = fetchAll($conn, $strSQL27);

            foreach ($subs as $sub) {
                $product = getProductInfo($conn, $sub["product_id"]);
                $saleChannelName = getSaleChannelName($conn, $iv["sale_channel"]);

                $summary = (float)$sub['sum_amount'];
                $noVat = exVat($summary);

                echo '<tr>
                    <td class="center">' . h($iv["ref_id"]) . '</td>
                    <td class="center">' . h(DateThai($iv["iv_date"])) . '</td>
                    <td class="center"><a class="doc-link" href="register_admin_edit.php?ref_id=' . h($iv["ref_id"]) . '" target="_blank">' . h($iv["iv_no"]) . '</a></td>
                    <td class="left">' . h($saleChannelName) . '</td>
                    <td class="left">' . h($iv["customer_name"]) . '</td>
                    <td class="left">' . h($product["sol_name"]) . '</td>
                    <td class="right">' . h($sub["sale_count"]) . ' ' . h($product["unit_name"]) . '</td>
                    <td class="right">' . formatMoney($summary) . '</td>
                    <td class="right">' . formatMoney($noVat) . '</td>
                </tr>';
            }
        }

        closeTable();

        renderSummaryRow("รวมยอดขายของ Sale : " . $sale_name, $totalSales, $totalSalesExVat, 'summary-red');

        // ===== เครดิตโน้ต =====
        renderTableHeaderCredit();

        $strSQL211 = "SELECT credit_no, date_credit, customer_name, ref_credit
                      FROM tb_credit_note
                      WHERE credit_no != '' AND status_doc = 'Approve' AND sale_code = '" . $sale_code1 . "'";

        if ($start_date != "") $strSQL211 .= ' AND date_credit >= "' . $start_date . '"';
        if ($end_date != "")   $strSQL211 .= ' AND date_credit <= "' . $end_date . '"';
        if ($company != "")    $strSQL211 .= ' AND company_type = "' . $company . '"';
        $strSQL211 .= " ORDER BY credit_no ASC";

        $credits = fetchAll($conn, $strSQL211);

        foreach ($credits as $credit) {
            $strSQL222 = "SELECT product_id, count, sum_amount
                          FROM tb_subcredit
                          WHERE ref_creditt = '" . $credit["ref_credit"] . "'";
            $subCredits = fetchAll($conn, $strSQL222);

            foreach ($subCredits as $subCredit) {
                $product = getProductInfo($conn, $subCredit["product_id"]);

                $summary = (float)$subCredit['sum_amount'];
                $noVat = exVat($summary);

                echo '<tr>
                    <td class="center">' . h($credit["ref_credit"]) . '</td>
                    <td class="center">' . h(DateThai($credit["date_credit"])) . '</td>
                    <td class="center">' . h($credit["credit_no"]) . '</td>
                    <td class="left">' . h($credit["customer_name"]) . '</td>
                    <td class="left">' . h($product["sol_name"]) . '</td>
                    <td class="right">' . h($subCredit["count"]) . ' ' . h($product["unit_name"]) . '</td>
                    <td class="right">' . formatMoney($summary) . '</td>
                    <td class="right">' . formatMoney($noVat) . '</td>
                </tr>';
            }
        }

        closeTable();

        $strSQL151 = "SELECT SUM(sum_amount) AS total15
                      FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit = tb_subcredit.ref_creditt)
                      WHERE credit_no != '' AND status_doc = 'Approve' AND sale_code = '" . $sale_code1 . "'";

        if ($start_date != "") $strSQL151 .= ' AND date_credit >= "' . $start_date . '"';
        if ($end_date != "")   $strSQL151 .= ' AND date_credit <= "' . $end_date . '"';
        if ($company != "")    $strSQL151 .= ' AND company_type = "' . $company . '"';

        $objResult151 = fetchOne($conn, $strSQL151);
        $totalCredit = (float)($objResult151['total15'] ?? 0);
        $totalCreditExVat = exVat($totalCredit);

        renderSummaryRow("รวมยอดลดหนี้ของ Sale : " . $sale_name, $totalCredit, $totalCreditExVat, 'summary-red');

        $netTotal = $totalSales - $totalCredit;
        $netTotalExVat = $totalSalesExVat - $totalCreditExVat;

        renderSummaryRow("ยอดสุทธิของ Sale : " . $sale_name, $netTotal, $netTotalExVat, 'summary-blue');

        echo '<div class="divider"></div>';
    }

    // ===== รวมทั้งหมด =====
    $strSQL50 = "SELECT SUM(sum_amount) AS total50
                 FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit = tb_subcredit.ref_creditt)
                 WHERE credit_no != '' AND status_doc = 'Approve' AND sale_code LIKE '%SOL%'";

    if ($start_date != "") $strSQL50 .= ' AND date_credit >= "' . $start_date . '"';
    if ($end_date != "")   $strSQL50 .= ' AND date_credit <= "' . $end_date . '"';
    if ($company != "")    $strSQL50 .= ' AND company_type = "' . $company . '"';

    $objResult50 = fetchOne($conn, $strSQL50);
    $credit50 = (float)($objResult50['total50'] ?? 0);

    $strSQL55 = "SELECT SUM(sum_amount) AS sum_amount
                 FROM (so__main LEFT JOIN so__submain ON so__main.ref_id = so__submain.ref_idd)
                 WHERE cancel_ckk = '0' AND doc_no != ''";

    if ($start_date != "") $strSQL55 .= ' AND doc_release_date >= "' . $start_date . '"';
    if ($end_date != "")   $strSQL55 .= ' AND doc_release_date <= "' . $end_date . '"';
    if ($company != "")    $strSQL55 .= ' AND select_type_doc = "' . $company . '"';

    $objResult55 = fetchOne($conn, $strSQL55);
    $sol_1 = (float)($objResult55['sum_amount'] ?? 0);

    $strSQL56 = "SELECT SUM(sum_amount) AS total22
                 FROM (so__main LEFT JOIN so__submain ON so__main.ref_id = so__submain.ref_idd)
                 WHERE iv_no != '' AND cancel_ckk = '0'";

    if ($start_date != "") $strSQL56 .= ' AND iv_date >= "' . $start_date . '"';
    if ($end_date != "")   $strSQL56 .= ' AND iv_date <= "' . $end_date . '"';
    if ($company1 != "")   $strSQL56 .= ' AND select_type_doc = "' . $company1 . '"';

    $objResult56 = fetchOne($conn, $strSQL56);
    $sol_2 = (float)($objResult56['total22'] ?? 0);

    $totalOnline = $sol_1 + $sol_2;
    $summaryAll = $totalOnline - $credit50;

    $summaryAllExVat = exVat($totalOnline) - exVat($credit50);

    renderSummaryRow("ยอดรวมทั้งหมด", $summaryAll, $summaryAllExVat, 'summary-red');
}
?>

</div>
</body>
</html>