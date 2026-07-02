<?php
session_start();

header('Content-Type: application/json; charset=utf-8');

if (empty($_SESSION['UserID'])) {
    http_response_code(401);
    echo json_encode(array(
        'success' => false,
        'message' => 'กรุณาเข้าสู่ระบบ'
    ), JSON_UNESCAPED_UNICODE);
    exit;
}

include 'dbconnect.php';

function clearLoanJsonResponse($payload, $statusCode = 200)
{
    http_response_code($statusCode);
    echo json_encode($payload, JSON_UNESCAPED_UNICODE);
    exit;
}

function clearLoanFormatDate($value)
{
    $value = trim((string)$value);
    if ($value === '' || $value === '0000-00-00' || $value === '0000-00-00 00:00:00') {
        return '-';
    }

    $timestamp = strtotime($value);
    if ($timestamp === false) {
        return $value;
    }

    return date('d/m/y', $timestamp);
}

function clearLoanNormalizeText($value)
{
    return trim((string)$value);
}

function clearLoanEscape($conn, $value)
{
    return mysqli_real_escape_string($conn, clearLoanNormalizeText($value));
}

function clearLoanSplitSnLines($sn)
{
    $sn = str_replace("\r", "\n", (string)$sn);
    $parts = array_filter(array_map('trim', explode("\n", $sn)), 'strlen');
    return array_values($parts);
}

function clearLoanReserveSaleFilter($conn)
{
    $saleCode = isset($_SESSION['code']) ? trim((string)$_SESSION['code']) : '';
    $userType = isset($_SESSION['user_type']) ? trim((string)$_SESSION['user_type']) : '';

    if ($userType === 'Engineer') {
        return "h.sale_code LIKE '%EN%'";
    }

    if ($saleCode === 'SS1') {
        return "h.sale_code IN ('S15','S16','S21','S22','S14')";
    }

    if ($saleCode === 'SS2') {
        return "h.sale_code IN ('S11','S12','S17','S24','S13')";
    }

    if ($saleCode === 'SS3') {
        return "h.sale_code IN ('S31','S32','S33','MM1','SOL1','SOL2','SOL3','SOL4','SOL5','SOL6','SOL7','SOL8','SOL99')";
    }

    if ($saleCode === 'SS5') {
        return "h.sale_code IN ('S31','S32')";
    }

    if ($saleCode === 'SUP_MK') {
        return "h.sale_code IN ('SOL91','SOL92','SOL93','SOL94','MK')";
    }

    if ($saleCode === 'SM1') {
        return "h.sale_code IN ('S31','S32','S33','MM1','MM2','SOL1','SOL2','SOL3','SOL4','SOL5','SOL6','SOL7','SOL8','SOL0','SOL99')";
    }

    if ($saleCode === 'SUP_EN') {
        return "h.sale_code LIKE '%EN%'";
    }

    if ($saleCode !== '') {
        if (preg_match('/^(S\d{2}|EN\d+|SOL\d+|MM\d+|PM|MK)$/' , $saleCode)) {
            return "h.sale_code = '" . clearLoanEscape($conn, $saleCode) . "'";
        }

        return '1=1';
    }

    return '1=1';
}

function clearLoanLoanSaleFilter()
{
    $employeeCode = isset($_SESSION['code']) ? trim((string)$_SESSION['code']) : '';

    if ($employeeCode === 'SS1') {
        return "h.sale_code IN ('S15','S16','S21','S22','S14')";
    }

    if ($employeeCode === 'SS2') {
        return "h.sale_code IN ('S11','S12','S17','S24','S13')";
    }

    if ($employeeCode === 'SS3') {
        return "h.sale_code IN ('S31','S32','S33','MM1','SOL1','SOL2','SOL3','SOL4','SOL5','SOL6','SOL7','SOL8','SOL99')";
    }

    if ($employeeCode === 'SS5') {
        return "h.sale_code IN ('S31','S32')";
    }

    if ($employeeCode === 'SUP_EN') {
        return "h.sale_code LIKE '%EN%'";
    }

    return '1=1';
}

function clearLoanFetchReserveDocuments($conn, $keyword)
{
    $filters = array(
        "h.close_jong = '0'",
        "h.cancel_ckk = '0'",
        "h.status_doc = 'Approve'",
        clearLoanReserveSaleFilter($conn)
    );

    if ($keyword !== '') {
        $keywordLike = '%' . clearLoanEscape($conn, $keyword) . '%';
        $filters[] = "(
            h.ref_id LIKE '{$keywordLike}'
            OR h.iv_no LIKE '{$keywordLike}'
            OR h.customer LIKE '{$keywordLike}'
            OR EXISTS (
                SELECT 1
                FROM hos__subjongpro d
                LEFT JOIN tb_product p ON d.product_ID = p.product_id
                WHERE d.ref_idd = h.ref_id
                AND (
                    d.product_id LIKE '{$keywordLike}'
                    OR p.sol_name LIKE '{$keywordLike}'
                    OR p.access_code LIKE '{$keywordLike}'
                )
            )
        )";
    }

    $sql = "SELECT
            h.ref_id,
            h.date_jong,
            h.iv_no,
            h.date_receive,
            h.customer,
            h.sale_code,
            h.status_doc,
            h.id_jong
        FROM hos__jongproduct h
        WHERE " . implode(' AND ', $filters) . "
        ORDER BY h.id_jong DESC
        LIMIT 50";

    $query = mysqli_query($conn, $sql);
    if (!$query) {
        clearLoanJsonResponse(array(
            'success' => false,
            'message' => 'ไม่สามารถดึงข้อมูลใบจองได้'
        ), 500);
    }

    $documents = array();
    while ($row = mysqli_fetch_assoc($query)) {
        $detailSql = "SELECT
                d.product_id,
                d.`count` AS qty,
                p.sol_name,
                p.access_code
            FROM hos__subjongpro d
            LEFT JOIN tb_product p ON d.product_ID = p.product_id
            WHERE d.ref_idd = '" . clearLoanEscape($conn, $row['ref_id']) . "'";
        $detailQuery = mysqli_query($conn, $detailSql);
        $items = array();
        $itemIndex = 1;

        if ($detailQuery) {
            while ($detail = mysqli_fetch_assoc($detailQuery)) {
                $items[] = array(
                    'item_key' => 'reserve-' . $row['iv_no'] . '-' . $itemIndex,
                    'product_id' => clearLoanNormalizeText($detail['product_id']),
                    'product_name' => clearLoanNormalizeText($detail['sol_name']),
                    'product_code' => clearLoanNormalizeText($detail['access_code']),
                    'quantity' => (string)$detail['qty'],
                    'sn' => ''
                );
                $itemIndex++;
            }
        }

        $documents[] = array(
            'doc_type' => 'reserve',
            'reference_no' => clearLoanNormalizeText($row['ref_id']),
            'registered_date' => clearLoanFormatDate($row['date_jong']),
            'document_no' => clearLoanNormalizeText($row['iv_no']),
            'required_date' => clearLoanFormatDate($row['date_receive']),
            'customer_name' => clearLoanNormalizeText($row['customer']),
            'sale_zone' => clearLoanNormalizeText($row['sale_code']),
            'status' => clearLoanNormalizeText($row['status_doc']),
            'items' => $items
        );
    }

    return $documents;
}

function clearLoanFetchLoanDocuments($conn, $keyword)
{
    $filters = array(
        "h.close_br = '0'",
        "h.status_doc = 'Approve'",
        "h.company = '1'",
        clearLoanLoanSaleFilter(),
        "EXISTS (
            SELECT 1
            FROM hos__subbr d
            WHERE d.ref_idd_br = h.ref_id_br
            AND d.clear_ckk = '0'
            AND d.ckk_st = '1'
        )"
    );

    if ($keyword !== '') {
        $keywordLike = '%' . clearLoanEscape($conn, $keyword) . '%';
        $filters[] = "(
            h.ref_id_br LIKE '{$keywordLike}'
            OR h.iv_no LIKE '{$keywordLike}'
            OR h.customer LIKE '{$keywordLike}'
            OR EXISTS (
                SELECT 1
                FROM hos__subbr d
                LEFT JOIN tb_product p ON d.product_id = p.product_ID
                WHERE d.ref_idd_br = h.ref_id_br
                AND d.clear_ckk = '0'
                AND d.ckk_st = '1'
                AND (
                    d.product_id LIKE '{$keywordLike}'
                    OR p.sol_name LIKE '{$keywordLike}'
                    OR p.access_code LIKE '{$keywordLike}'
                )
            )
        )";
    }

    $sql = "SELECT
            h.ref_id_br,
            h.date_br,
            h.iv_no,
            h.iv_date,
            h.customer,
            h.sale_code,
            h.status_doc,
            h.id
        FROM hos__br h
        WHERE " . implode(' AND ', $filters) . "
        ORDER BY h.id DESC
        LIMIT 50";

    $query = mysqli_query($conn, $sql);
    if (!$query) {
        clearLoanJsonResponse(array(
            'success' => false,
            'message' => 'ไม่สามารถดึงข้อมูลใบยืมได้'
        ), 500);
    }

    $documents = array();
    while ($row = mysqli_fetch_assoc($query)) {
        $detailSql = "SELECT
                d.product_id,
                d.`count` AS qty,
                d.sn,
                p.sol_name,
                p.access_code
            FROM hos__subbr d
            LEFT JOIN tb_product p ON d.product_id = p.product_ID
            WHERE d.ref_idd_br = '" . clearLoanEscape($conn, $row['ref_id_br']) . "'
            AND d.clear_ckk = '0'
            AND d.ckk_st = '1'";
        $detailQuery = mysqli_query($conn, $detailSql);
        $items = array();
        $itemIndex = 1;

        if ($detailQuery) {
            while ($detail = mysqli_fetch_assoc($detailQuery)) {
                $snList = clearLoanSplitSnLines($detail['sn']);
                if (!empty($snList)) {
                    foreach ($snList as $snValue) {
                        $items[] = array(
                            'item_key' => 'loan-' . $row['iv_no'] . '-' . $itemIndex,
                            'product_id' => clearLoanNormalizeText($detail['product_id']),
                            'product_name' => clearLoanNormalizeText($detail['sol_name']),
                            'product_code' => clearLoanNormalizeText($detail['access_code']),
                            'quantity' => '1',
                            'sn' => $snValue
                        );
                        $itemIndex++;
                    }
                    continue;
                }

                $items[] = array(
                    'item_key' => 'loan-' . $row['iv_no'] . '-' . $itemIndex,
                    'product_id' => clearLoanNormalizeText($detail['product_id']),
                    'product_name' => clearLoanNormalizeText($detail['sol_name']),
                    'product_code' => clearLoanNormalizeText($detail['access_code']),
                    'quantity' => (string)$detail['qty'],
                    'sn' => ''
                );
                $itemIndex++;
            }
        }

        $documents[] = array(
            'doc_type' => 'loan',
            'reference_no' => clearLoanNormalizeText($row['ref_id_br']),
            'registered_date' => clearLoanFormatDate($row['date_br']),
            'document_no' => clearLoanNormalizeText($row['iv_no']),
            'required_date' => clearLoanFormatDate($row['iv_date']),
            'customer_name' => clearLoanNormalizeText($row['customer']),
            'sale_zone' => clearLoanNormalizeText($row['sale_code']),
            'status' => clearLoanNormalizeText($row['status_doc']),
            'items' => $items
        );
    }

    return $documents;
}

$type = isset($_GET['type']) ? strtolower(trim((string)$_GET['type'])) : 'reserve';
$keyword = isset($_GET['keyword']) ? trim((string)$_GET['keyword']) : '';

if ($type !== 'reserve' && $type !== 'loan') {
    clearLoanJsonResponse(array(
        'success' => false,
        'message' => 'ประเภทเอกสารไม่ถูกต้อง'
    ), 400);
}

$documents = $type === 'loan'
    ? clearLoanFetchLoanDocuments($conn, $keyword)
    : clearLoanFetchReserveDocuments($conn, $keyword);

clearLoanJsonResponse(array(
    'success' => true,
    'documents' => $documents
));