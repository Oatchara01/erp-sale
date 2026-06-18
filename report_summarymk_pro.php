<?php
include "src/BarcodeGenerator.php";
include "src/BarcodeGeneratorHTML.php";
include "src/BarcodeGeneratorPNG.php";
include "dbconnect.php";
include "dbconnect_sale.php";

date_default_timezone_set('Asia/Bangkok');

function dateThai($date)
{
    if (empty($date) || $date === '0000-00-00') {
        return '-';
    }

    $year = date('Y', strtotime($date)) + 543;
    $month = date('n', strtotime($date));
    $day = date('j', strtotime($date));
    $monthNames = [
        '', 'ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.',
        'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'
    ];

    return $day . ' ' . $monthNames[$month] . ' ' . $year;
}

function getParam($key, $default = '')
{
    return isset($_GET[$key]) ? trim($_GET[$key]) : $default;
}

function esc($value)
{
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function safeNumber($value, $decimals = 2)
{
    return number_format((float)$value, $decimals);
}

function amountExVat($amount, $vat = 1.07)
{
    return (float)$amount / $vat;
}

function fetchOne($conn, $sql)
{
    $query = mysqli_query($conn, $sql) or die('Error Query [' . $sql . ']');
    return mysqli_fetch_assoc($query) ?: [];
}

function fetchAll($conn, $sql)
{
    $query = mysqli_query($conn, $sql) or die('Error Query [' . $sql . ']');
    $rows = [];

    while ($row = mysqli_fetch_assoc($query)) {
        $rows[] = $row;
    }

    return $rows;
}

function buildDateFilter($fieldName, $startDate, $endDate)
{
    $sql = '';

    if ($startDate !== '') {
        $sql .= " AND {$fieldName} >= '" . $startDate . "'";
    }

    if ($endDate !== '') {
        $sql .= " AND {$fieldName} <= '" . $endDate . "'";
    }

    return $sql;
}

function getProductInfo($conn, $productId)
{
    $sql = "
        SELECT
            access_code,
            COALESCE(sol_name, access_name) AS product_name,
            unit_name,
            express_code
        FROM tb_product
        WHERE product_ID = '{$productId}'
        LIMIT 1
    ";

    return fetchOne($conn, $sql);
}

function getSalesZones($conn, $productId, $startDate, $endDate)
{
    $zones = [];

    $hospitalSql = "
        SELECT DISTINCT sale_code AS zone_code
        FROM hos__so
        LEFT JOIN hos__subso ON hos__so.ref_id = hos__subso.ref_idd
        WHERE product_id = '{$productId}'
          AND status_doc = 'Approve'
          AND sale_code IS NOT NULL
          AND sale_code != ''
		  AND iv_date != '0000-00-00'
    ";
    $hospitalSql .= buildDateFilter('iv_date', $startDate, $endDate);

    foreach (fetchAll($conn, $hospitalSql) as $row) {
        $zoneCode = trim($row['zone_code']);
        if ($zoneCode !== '') {
            $zones[$zoneCode] = $zoneCode;
        }
    }

    $normalSql = "
        SELECT DISTINCT employee_name AS zone_code
        FROM so__main
        LEFT JOIN so__submain ON so__main.ref_id = so__submain.ref_idd
        WHERE product_id = '{$productId}'
          AND cancel_ckk = '0'
          AND employee_name IS NOT NULL
          AND employee_name != ''
          AND doc_no NOT LIKE '%BRNP%'
    ";
    $normalSql .= buildDateFilter('doc_release_date', $startDate, $endDate);

    foreach (fetchAll($conn, $normalSql) as $row) {
        $zoneCode = trim($row['zone_code']);
        if ($zoneCode !== '') {
            $zones[$zoneCode] = $zoneCode;
        }
    }

    $creditSql = "
        SELECT DISTINCT sale_code AS zone_code
        FROM tb_credit_note
        LEFT JOIN tb_subcredit ON tb_subcredit.ref_creditt = tb_credit_note.ref_credit
        WHERE product_id = '{$productId}'
          AND credit_no != ''
          AND status_doc = 'Approve'
          AND sale_code IS NOT NULL
          AND sale_code != ''
    ";
    $creditSql .= buildDateFilter('date_credit', $startDate, $endDate);

    foreach (fetchAll($conn, $creditSql) as $row) {
        $zoneCode = trim($row['zone_code']);
        if ($zoneCode !== '') {
            $zones[$zoneCode] = $zoneCode;
        }
    }

    ksort($zones);
    return array_values($zones);
}

function getHospitalSales($conn, $productId, $startDate, $endDate, $saleCode = '')
{
    $sql = "
        SELECT
            hos__so.ref_id,
            iv_date,
            iv_no,
            bill_name,
            count,
            price,
            amount,
            discount,
            sale_code
        FROM hos__so
        LEFT JOIN hos__subso ON hos__so.ref_id = hos__subso.ref_idd
        WHERE product_id = '{$productId}'
          AND status_doc = 'Approve'
		  AND iv_date != '0000-00-00'
    ";

    $sql .= buildDateFilter('iv_date', $startDate, $endDate);

    if ($saleCode !== '') {
        $sql .= " AND sale_code = '{$saleCode}'";
    }

    $sql .= ' ORDER BY iv_date ASC, iv_no ASC';

    return fetchAll($conn, $sql);
}

function getNormalSales($conn, $productId, $startDate, $endDate, $saleCode = '', $excludeDocPrefix = 'BRNP')
{
    $sql = "
        SELECT
            so__main.ref_id,
            doc_release_date,
            doc_no,
            customer_name,
            sale_count,
            price_per_unit,
            discount_unit,
            sum_amount,
            employee_name
        FROM so__main
        LEFT JOIN so__submain ON so__main.ref_id = so__submain.ref_idd
        WHERE product_id = '{$productId}'
          AND cancel_ckk = '0'
    ";

    $sql .= buildDateFilter('doc_release_date', $startDate, $endDate);

    if ($saleCode !== '') {
        $sql .= " AND employee_name = '{$saleCode}'";
    }

    if ($excludeDocPrefix !== '') {
        $sql .= " AND doc_no NOT LIKE '%{$excludeDocPrefix}%'";
    }

    $sql .= ' ORDER BY doc_release_date ASC, doc_no ASC';

    return fetchAll($conn, $sql);
}

function getCreditNotes($conn, $productId, $startDate, $endDate, $saleCode = '')
{
    $sql = "
        SELECT
            tb_credit_note.ref_credit,
            credit_no,
            date_credit,
            customer_name,
            tb_subcredit.product_id,
            tb_subcredit.count,
            tb_subcredit.unit_price,
            tb_subcredit.discount_unit,
            tb_subcredit.sum_amount,
            sale_code
        FROM tb_credit_note
        LEFT JOIN tb_subcredit ON tb_subcredit.ref_creditt = tb_credit_note.ref_credit
        WHERE credit_no != ''
          AND status_doc = 'Approve'
    ";

    $sql .= buildDateFilter('date_credit', $startDate, $endDate);

    if ($productId !== '') {
        $sql .= " AND product_id = '{$productId}'";
    }

    if ($saleCode !== '') {
        $sql .= " AND sale_code = '{$saleCode}'";
    }

    $sql .= ' ORDER BY date_credit ASC, credit_no ASC';

    return fetchAll($conn, $sql);
}

function summarizeSales($hospitalRows, $normalRows, $creditRows)
{
    $summary = [
        'qty' => 0,
        'price' => 0,
        'discount' => 0,
        'amount' => 0,
        'credit' => 0,
        'net' => 0,
    ];

    foreach ($hospitalRows as $row) {
        $summary['qty'] += (float)$row['count'];
        $summary['price'] += (float)$row['price'];
        $summary['discount'] += (float)$row['discount'];
        $summary['amount'] += (float)$row['amount'];
    }

    foreach ($normalRows as $row) {
        $summary['qty'] += (float)$row['sale_count'];
        $summary['price'] += (float)$row['price_per_unit'];
        $summary['discount'] += (float)$row['discount_unit'];
        $summary['amount'] += (float)$row['sum_amount'];
    }

    foreach ($creditRows as $row) {
        $summary['credit'] += (float)$row['sum_amount'];
    }

    $summary['net'] = $summary['amount'] - $summary['credit'];

    return $summary;
}

function emptySummary()
{
    return [
        'qty' => 0,
        'price' => 0,
        'discount' => 0,
        'amount' => 0,
        'credit' => 0,
        'net' => 0,
    ];
}

function mergeSummary($base, $addition)
{
    $base['qty'] += (float)($addition['qty'] ?? 0);
    $base['price'] += (float)($addition['price'] ?? 0);
    $base['discount'] += (float)($addition['discount'] ?? 0);
    $base['amount'] += (float)($addition['amount'] ?? 0);
    $base['credit'] += (float)($addition['credit'] ?? 0);
    $base['net'] = $base['amount'] - $base['credit'];

    return $base;
}

function renderProductHeader($product)
{
    echo '<div class="product-header">';
    echo '<span>' . esc($product['access_code'] ?? '-') . '</span>';
    echo '<span>' . esc($product['product_name'] ?? '-') . '</span>';
    echo '<span>' . esc($product['unit_name'] ?? '-') . '</span>';
    echo '<span>' . esc($product['express_code'] ?? '-') . '</span>';
    echo '</div>';
}

function renderSalesTable($hospitalRows, $normalRows)
{
    ?>
    <table class="report-table sales-table">
        <colgroup>
            <col><col><col><col><col><col><col><col><col>
        </colgroup>
        <thead>
        <tr>
            <th>เลขที่อ้างอิง</th>
            <th>วันที่</th>
            <th>เลขที่เอกสาร</th>
            <th>ชื่อลูกค้า</th>
            <th>จำนวน</th>
            <th>ราคาต่อหน่วย</th>
            <th>ส่วนลด/ชิ้น</th>
            <th>ยอดลูกหนี้</th>
            <th>รายได้ก่อน VAT</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($hospitalRows as $row): ?>
            <tr>
                <td class="center"><?= esc($row['ref_id']) ?></td>
                <td class="center"><?= dateThai($row['iv_date']) ?></td>
                <td class="center"><?= esc($row['iv_no']) ?></td>
                <td><?= esc($row['bill_name']) ?></td>
                <td class="center"><?= safeNumber($row['count'], 0) ?></td>
                <td class="right"><?= safeNumber($row['price']) ?></td>
                <td class="right"><?= safeNumber($row['discount']) ?></td>
                <td class="right"><?= safeNumber($row['amount']) ?></td>
                <td class="right"><?= safeNumber(amountExVat($row['amount'])) ?></td>
            </tr>
        <?php endforeach; ?>

        <?php foreach ($normalRows as $row): ?>
            <tr>
                <td class="center"><?= esc($row['ref_id']) ?></td>
                <td class="center"><?= dateThai($row['doc_release_date']) ?></td>
                <td class="center"><?= esc($row['doc_no']) ?></td>
                <td><?= esc($row['customer_name']) ?></td>
                <td class="center"><?= safeNumber($row['sale_count'], 0) ?></td>
                <td class="right"><?= safeNumber($row['price_per_unit']) ?></td>
                <td class="right"><?= safeNumber($row['discount_unit']) ?></td>
                <td class="right"><?= safeNumber($row['sum_amount']) ?></td>
                <td class="right"><?= safeNumber(amountExVat($row['sum_amount'])) ?></td>
            </tr>
        <?php endforeach; ?>

        <?php if (empty($hospitalRows) && empty($normalRows)): ?>
            <tr>
                <td colspan="9" class="empty">ไม่พบข้อมูลยอดขาย</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
    <?php
}

function renderCreditTable($creditRows, $conn)
{
    ?>
    <table class="report-table credit-table">
        <colgroup>
            <col><col><col><col><col><col><col><col><col>
        </colgroup>
        <thead>
        <tr>
            <th>เลขที่อ้างอิง</th>
            <th>วันที่</th>
            <th>เลขที่ใบลดหนี้</th>
            <th>ชื่อลูกค้า</th>
            <th>จำนวน</th>
			<th>ราคาต่อหน่วย</th>
			<th>ส่วนลด/ชิ้น</th>
            <th>ยอดลดหนี้</th>
            <th>ยอดลดหนี้ก่อน VAT</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($creditRows as $row): ?>
            <?php $product = getProductInfo($conn, $row['product_id']); ?>
            <tr>
                <td class="center"><?= esc($row['ref_credit']) ?></td>
                <td class="center"><?= dateThai($row['date_credit']) ?></td>
                <td class="center"><?= esc($row['credit_no']) ?></td>
                <td><?= esc($row['customer_name']) ?></td>
                
                <td class="right"><?= safeNumber($row['count'], 0) . ' ' . esc($product['unit_name'] ?? '') ?></td>
				<td class="right"><?= safeNumber($row['unit_price']) ?></td>
				<td><?= safeNumber($row['discount_unit']) ?></td>
                <td class="right"><?= safeNumber($row['sum_amount']) ?></td>
                <td class="right"><?= safeNumber(amountExVat($row['sum_amount'])) ?></td>
            </tr>
        <?php endforeach; ?>

        <?php if (empty($creditRows)): ?>
            <tr>
                <td colspan="9" class="empty">ไม่พบข้อมูลใบลดหนี้</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
    <?php
}

function renderSummaryTable($title, $summary, $className = 'summary-red')
{
    ?>
    <table class="report-table sales-table <?= $className ?>">
        <colgroup>
            <col><col><col><col><col><col><col><col><col>
        </colgroup>
        <tr>
            <td colspan="4" class="summary-title-cell"><?= esc($title) ?></td>
            <td class="center"><?= safeNumber($summary['qty'], 0) ?></td>
            <td class="right"><?= safeNumber($summary['price']) ?></td>
            <td class="right"><?= safeNumber($summary['discount']) ?></td>
            <td class="right"><?= safeNumber($summary['amount']) ?></td>
            <td class="right"><?= safeNumber(amountExVat($summary['amount'])) ?></td>
        </tr>
    </table>
    <?php
}

function renderCreditSummary($title, $creditAmount)
{
    ?>
    <table class="report-table credit-table summary-red">
        <colgroup>
            <col><col><col><col><col><col><col><col><col>
        </colgroup>
        <tr>
            <td colspan="7" class="summary-title-cell"><?= esc($title) ?></td>
            <td class="right"><?= safeNumber($creditAmount) ?></td>
            <td class="right"><?= safeNumber(amountExVat($creditAmount)) ?></td>
        </tr>
    </table>
    <?php
}

function renderNetSummary($title, $netAmount)
{
    ?>
    <table class="report-table credit-table summary-blue">
        <colgroup>
            <col><col><col><col><col><col><col><col><col>
        </colgroup>
        <tr>
            <td colspan="7" class="summary-title-cell"><?= esc($title) ?></td>
            <td class="right"><?= safeNumber($netAmount) ?></td>
            <td class="right"><?= safeNumber(amountExVat($netAmount)) ?></td>
        </tr>
    </table>
    <?php
}

function renderZoneSection($conn, $productId, $startDate, $endDate, $zoneCode)
{
    $hospitalRows = getHospitalSales($conn, $productId, $startDate, $endDate, $zoneCode);
    $normalRows = getNormalSales($conn, $productId, $startDate, $endDate, $zoneCode);
    $creditRows = getCreditNotes($conn, $productId, $startDate, $endDate, $zoneCode);

    if (empty($hospitalRows) && empty($normalRows) && empty($creditRows)) {
        return emptySummary();
    }

    $summary = summarizeSales($hospitalRows, $normalRows, $creditRows);
    ?>
    <section class="zone-section">
        <div class="zone-title">เขตการขาย: <?= esc($zoneCode) ?></div>

        <?php renderSalesTable($hospitalRows, $normalRows); ?>
        <?php renderSummaryTable('รวมยอดขายของเขต ' . $zoneCode, $summary); ?>

        <?php renderCreditTable($creditRows, $conn); ?>
        <?php renderCreditSummary('รวมยอดลดหนี้ของเขต ' . $zoneCode, $summary['credit']); ?>
        <?php renderNetSummary('ยอดขายสุทธิของเขต ' . $zoneCode, $summary['net']); ?>
    </section>
    <?php

    return $summary;
}

$startDate = getParam('start_date');
$endDate = getParam('end_date');
$saleCode = getParam('sale_code');
$productId = getParam('h_product_code');

$product = getProductInfo($conn, $productId);
$allHospitalRows = getHospitalSales($conn, $productId, $startDate, $endDate, $saleCode);
$allNormalRows = getNormalSales($conn, $productId, $startDate, $endDate, $saleCode);
$allCreditRows = getCreditNotes($conn, $productId, $startDate, $endDate, $saleCode);
$allSummary = summarizeSales($allHospitalRows, $allNormalRows, $allCreditRows);

$zoneList = [];
$zoneGrandSummary = emptySummary();
if ($saleCode !== '') {
    $zoneList[] = $saleCode;
} else {
    $zoneList = getSalesZones($conn, $productId, $startDate, $endDate);
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <title>ประวัติการขายแยกตามสินค้าและเขตการขาย</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 24px;
            font-family: 'Prompt', sans-serif;
            font-size: 14px;
            color: #1f2937;
            background: #ffffff;
            line-height: 1.45;
        }

        .page-title {
            font-size: 24px;
            font-weight: 600;
            color: #b91c1c;
            margin-bottom: 4px;
        }

        .page-subtitle {
            font-size: 14px;
            color: #4b5563;
            margin-bottom: 16px;
        }

        .divider {
            border: 0;
            border-top: 2px solid #e5e7eb;
            margin: 12px 0 20px;
        }

        .product-header {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            padding: 12px 16px;
            margin-bottom: 16px;
            background: #f8fafc;
            border: 1px solid #dbeafe;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 500;
            color: #1d4ed8;
        }

        .filter-badge {
            display: inline-block;
            margin-bottom: 14px;
            padding: 8px 12px;
            border-radius: 999px;
            background: #fee2e2;
            color: #b91c1c;
            font-weight: 500;
        }

        .zone-section {
            margin-top: 28px;
            padding-top: 8px;
            page-break-inside: avoid;
        }

        .zone-title {
            margin-bottom: 10px;
            padding: 10px 14px;
            font-size: 18px;
            font-weight: 600;
            color: #ffffff;
            background: #2563eb;
            border-radius: 8px;
        }

.report-table {
    width: 100%;
    border-collapse: collapse;
    table-layout: fixed;
    margin-bottom: 12px;
}

.report-table th,
.report-table td {
    border: 1px solid #d1d5db;
    padding: 8px 10px;
    vertical-align: middle;
}

.report-table thead th {
    background: #eff6ff;
    color: #1e3a8a;
    font-weight: 600;
    text-align: center;
}

.credit-table thead th {
    background: #fff1f2;
    color: #9f1239;
}

.summary-red td {
    font-weight: 600;
    color: #b91c1c;
    background: #fef2f2;
}

.summary-blue td {
    font-weight: 600;
    color: #1d4ed8;
    background: #eff6ff;
}

.summary-title-cell {
    font-weight: 600;
    text-align: left;
}

.sales-table colgroup col:nth-child(1),
.credit-table colgroup col:nth-child(1) { width: 10%; }

.sales-table colgroup col:nth-child(2),
.credit-table colgroup col:nth-child(2) { width: 10%; }

.sales-table colgroup col:nth-child(3),
.credit-table colgroup col:nth-child(3) { width: 11%; }

.sales-table colgroup col:nth-child(4),
.credit-table colgroup col:nth-child(4) { width: 25%; }

.sales-table colgroup col:nth-child(5),
.credit-table colgroup col:nth-child(5) { width: 6%; }

.sales-table colgroup col:nth-child(6),
.credit-table colgroup col:nth-child(6) { width: 10%; }

.sales-table colgroup col:nth-child(7),
.credit-table colgroup col:nth-child(7) { width: 9%; }

.sales-table colgroup col:nth-child(8),
.credit-table colgroup col:nth-child(8) { width: 10%; }

.sales-table colgroup col:nth-child(9),
.credit-table colgroup col:nth-child(9) { width: 9%; }

.center {
    text-align: center;
}

.right {
    text-align: right;
}

.empty {
    text-align: center;
    color: #6b7280;
    padding: 16px;
}

.summary-title-cell {
    font-weight: 600;
    text-align: left;
}

        .summary-red td {
            color: #b91c1c;
            background: #fef2f2;
        }

        .summary-blue td {
            color: #1d4ed8;
            background: #eff6ff;
        }

        .summary-title {
            width: 55%;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .empty {
            text-align: center;
            color: #6b7280;
            padding: 16px;
        }

        @media print {
            body {
                padding: 0;
            }

            .zone-section {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>
    <div class="page-title">ประวัติการขายแยกตามสินค้า และแยกตามเขตการขาย</div>
    <div class="page-subtitle">ช่วงวันที่ <?= dateThai($startDate) ?> ถึง <?= dateThai($endDate) ?></div>
    <hr class="divider">

    <?php if ($saleCode !== ''): ?>
        <div class="filter-badge">กรองเฉพาะเขตการขาย: <?= esc($saleCode) ?></div>
    <?php endif; ?>

    <?php renderProductHeader($product); ?>

    <?php if ($saleCode !== ''): ?>
        <?php renderSalesTable($allHospitalRows, $allNormalRows); ?>
        <?php renderSummaryTable('รวมยอดขายของเขต ' . $saleCode, $allSummary); ?>

        <?php renderCreditTable($allCreditRows, $conn); ?>
        <?php renderCreditSummary('รวมยอดลดหนี้ของเขต ' . $saleCode, $allSummary['credit']); ?>
        <?php renderNetSummary('ยอดขายสุทธิของเขต ' . $saleCode, $allSummary['net']); ?>
    <?php else: ?>
        <?php foreach ($zoneList as $zoneCode): ?>
            <?php $zoneGrandSummary = mergeSummary($zoneGrandSummary, renderZoneSection($conn, $productId, $startDate, $endDate, $zoneCode)); ?>
        <?php endforeach; ?>

        <section class="zone-section">
            <div class="zone-title" style="background:#b91c1c;">สรุปรวมทุกเขตการขาย</div>
            <?php renderSummaryTable('รวมยอดขายทั้งหมด', $zoneGrandSummary); ?>
            <?php renderCreditSummary('รวมยอดลดหนี้ทั้งหมด', $zoneGrandSummary['credit']); ?>
            <?php renderNetSummary('ยอดขายสุทธิทั้งหมด', $zoneGrandSummary['net']); ?>
        </section>

        <?php if (abs($allSummary['amount'] - $zoneGrandSummary['amount']) > 0.01 || abs($allSummary['credit'] - $zoneGrandSummary['credit']) > 0.01): ?>
            <section class="zone-section">
                <div class="zone-title" style="background:#d97706;">ตรวจสอบความต่างของยอด</div>
                <table class="summary-table">
                    <tr>
                        <td class="summary-title">ยอดขายจาก query รวมทั้งหมด</td>
                        <td class="right"><?= safeNumber($allSummary['amount']) ?></td>
                        <td class="right"><?= safeNumber(amountExVat($allSummary['amount'])) ?></td>
                    </tr>
                    <tr>
                        <td class="summary-title">ยอดขายจากการรวมรายเขต</td>
                        <td class="right"><?= safeNumber($zoneGrandSummary['amount']) ?></td>
                        <td class="right"><?= safeNumber(amountExVat($zoneGrandSummary['amount'])) ?></td>
                    </tr>
                    <tr>
                        <td class="summary-title">ส่วนต่างยอดขาย</td>
                        <td class="right"><?= safeNumber($allSummary['amount'] - $zoneGrandSummary['amount']) ?></td>
                        <td class="right"><?= safeNumber(amountExVat($allSummary['amount'] - $zoneGrandSummary['amount'])) ?></td>
                    </tr>
                    <tr>
                        <td class="summary-title">ส่วนต่างใบลดหนี้</td>
                        <td class="right"><?= safeNumber($allSummary['credit'] - $zoneGrandSummary['credit']) ?></td>
                        <td class="right"><?= safeNumber(amountExVat($allSummary['credit'] - $zoneGrandSummary['credit'])) ?></td>
                    </tr>
                </table>
            </section>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>
