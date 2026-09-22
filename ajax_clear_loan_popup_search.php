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

function clearLoanFormatRawDate($value)
{
    $value = trim((string)$value);
    if ($value === '' || $value === '0000-00-00' || $value === '0000-00-00 00:00:00') {
        return '';
    }

    $timestamp = strtotime($value);
    return $timestamp === false ? '' : date('Y-m-d', $timestamp);
}

function clearLoanNormalizeText($value)
{
    return trim((string)$value);
}

function clearLoanEscape($conn, $value)
{
    return mysqli_real_escape_string($conn, clearLoanNormalizeText($value));
}

function clearLoanClampLimit($limit)
{
    $limit = (int)$limit;
    if ($limit <= 0) {
        $limit = 50;
    }
    if ($limit > 50) {
        $limit = 50;
    }
    return $limit;
}

function clearLoanNormalizeCompany($company)
{
    return ((string)$company === '4') ? '4' : '3';
}

function clearLoanCompanyFilter($company)
{
    $company = clearLoanNormalizeCompany($company);
    return $company === '4' ? "h.company IN ('2','4')" : "h.company IN ('1','3')";
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
        if (preg_match('/^(S\d{2}|EN\d+|SOL\d+|MM\d+|PM|MK)$/', $saleCode)) {
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

function clearLoanBuildReserveItems($conn, $referenceNo, $documentNo)
{
    $detailSql = "SELECT
            d.product_id,
            d.`count` AS qty,
            p.sol_name,
            p.access_code,
            p.war_hc,
            p.unit_hc,
            p.remark_hc
        FROM hos__subjongpro d
        LEFT JOIN tb_product p ON d.product_ID = p.product_id
        WHERE d.ref_idd = '" . clearLoanEscape($conn, $referenceNo) . "'";
    $detailQuery = mysqli_query($conn, $detailSql);
    $items = array();
    $itemIndex = 1;

    if ($detailQuery) {
        while ($detail = mysqli_fetch_assoc($detailQuery)) {
            $items[] = array(
                'item_key' => 'reserve-' . $documentNo . '-' . $itemIndex,
                'product_id' => clearLoanNormalizeText($detail['product_id']),
                'product_name' => clearLoanNormalizeText($detail['sol_name']),
                'product_code' => clearLoanNormalizeText($detail['access_code']),
                'quantity' => (string)$detail['qty'],
                'warranty' => clearLoanNormalizeText($detail['war_hc']),
                'warranty_unit' => clearLoanNormalizeText($detail['unit_hc']),
                'warranty_remark' => clearLoanNormalizeText($detail['remark_hc']),
                'sn' => ''
            );
            $itemIndex++;
        }
    }

    return $items;
}

function clearLoanBuildLoanItems($conn, $referenceNo, $documentNo)
{
    $detailSql = "SELECT
            d.product_id,
            d.`count` AS qty,
            d.sn,
            p.sol_name,
            p.access_code
        FROM hos__subbr d
        LEFT JOIN tb_product p ON d.product_id = p.product_ID
        WHERE d.ref_idd_br = '" . clearLoanEscape($conn, $referenceNo) . "'
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
                        'item_key' => 'loan-' . $documentNo . '-' . $itemIndex,
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
                'item_key' => 'loan-' . $documentNo . '-' . $itemIndex,
                'product_id' => clearLoanNormalizeText($detail['product_id']),
                'product_name' => clearLoanNormalizeText($detail['sol_name']),
                'product_code' => clearLoanNormalizeText($detail['access_code']),
                'quantity' => (string)$detail['qty'],
                'sn' => ''
            );
            $itemIndex++;
        }
    }

    return $items;
}

function clearLoanBuildLoanDocumentEntry($row)
{
    $internalId = (int)$row['id'];

    return array(
        'doc_type' => 'loan',
        'internal_id' => $internalId,
        'document_key' => 'loan:' . $internalId,
        'company' => clearLoanNormalizeText($row['company']),
        'customer_id' => clearLoanNormalizeText($row['customer_id']),
        'sale_code' => clearLoanNormalizeText($row['sale_code']),
        'reference_no' => clearLoanNormalizeText($row['ref_id_br']),
        'registered_date' => clearLoanFormatDate($row['date_br']),
        'registered_date_raw' => clearLoanFormatRawDate($row['date_br']),
        'document_no' => clearLoanNormalizeText($row['iv_no']),
        'document_no_display' => clearLoanNormalizeText($row['ref_id_br']),
        'required_date' => clearLoanFormatDate($row['iv_date']),
        'required_date_raw' => clearLoanFormatRawDate($row['iv_date']),
        'customer_name' => clearLoanNormalizeText($row['customer']),
        'sale_zone' => clearLoanNormalizeText($row['sale_code']),
        'status' => clearLoanNormalizeText($row['status_doc']),
        'has_items' => true,
        'items_loaded' => false,
        'items' => array()
    );
}


function clearLoanFetchReserveDocuments($conn, $keyword, $lastId, $limit, $company)
{
    $filters = array(
        "h.close_jong = '0'",
        "h.cancel_ckk = '0'",
        "h.status_doc = 'Approve'",
        clearLoanCompanyFilter($company),
        clearLoanReserveSaleFilter($conn)
    );

    if ($lastId > 0) {
        $filters[] = 'h.id_jong < ' . (int)$lastId;
    }

    if ($keyword !== '') {
        $keywordLike = '%' . clearLoanEscape($conn, $keyword) . '%';
        $filters[] = "(
            h.ref_id LIKE '{$keywordLike}'
            OR h.iv_no LIKE '{$keywordLike}'
            OR h.customer LIKE '{$keywordLike}'
            OR h.customer_id LIKE '{$keywordLike}'
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

    $queryLimit = $limit + 1;
    $sql = "SELECT
            h.ref_id,
            h.date_jong,
            h.iv_no,
            h.date_receive,
            h.customer,
            h.customer_id,
            h.company,
            h.sale_code,
            h.status_doc,
            h.id_jong,
            EXISTS (
                SELECT 1
                FROM hos__subjongpro d
                WHERE d.ref_idd = h.ref_id
            ) AS has_items
        FROM hos__jongproduct h
        WHERE " . implode(' AND ', $filters) . "
        ORDER BY h.id_jong DESC
        LIMIT " . (int)$queryLimit;

    $query = mysqli_query($conn, $sql);
    if (!$query) {
        clearLoanJsonResponse(array(
            'success' => false,
            'message' => 'ไม่สามารถโหลดข้อมูลใบจองได้'
        ), 500);
    }

    $rows = array();
    while ($row = mysqli_fetch_assoc($query)) {
        $rows[] = $row;
    }

    $hasMore = count($rows) > $limit;
    if ($hasMore) {
        array_pop($rows);
    }

    $documents = array();
    $nextLastId = null;

    foreach ($rows as $row) {
        $internalId = (int)$row['id_jong'];
        $nextLastId = $internalId;
        $documents[] = array(
            'doc_type' => 'reserve',
            'internal_id' => $internalId,
            'document_key' => 'reserve:' . $internalId,
            'company' => clearLoanNormalizeText($row['company']),
            'customer_id' => clearLoanNormalizeText($row['customer_id']),
            'sale_code' => clearLoanNormalizeText($row['sale_code']),
            'reference_no' => clearLoanNormalizeText($row['ref_id']),
            'registered_date' => clearLoanFormatDate($row['date_jong']),
            'registered_date_raw' => clearLoanFormatRawDate($row['date_jong']),
            'document_no' => clearLoanNormalizeText($row['iv_no']),
            'required_date' => clearLoanFormatDate($row['date_receive']),
            'required_date_raw' => clearLoanFormatRawDate($row['date_receive']),
            'customer_name' => clearLoanNormalizeText($row['customer']),
            'sale_zone' => clearLoanNormalizeText($row['sale_code']),
            'status' => clearLoanNormalizeText($row['status_doc']),
            'has_items' => (string)$row['has_items'] === '1',
            'items_loaded' => false,
            'items' => array()
        );
    }

    return array(
        'documents' => $documents,
        'pagination' => array(
            'limit' => $limit,
            'has_more' => $hasMore,
            'next_last_id' => $hasMore ? $nextLastId : null,
            'returned' => count($documents)
        )
    );
}

function clearLoanFetchLoanDocuments($conn, $keyword, $lastId, $limit, $company)
{
    $filters = array(
        "h.close_br = '0'",
        "h.status_doc = 'Approve'",
        clearLoanCompanyFilter($company),
        clearLoanLoanSaleFilter(),
        "EXISTS (
            SELECT 1
            FROM hos__subbr d
            WHERE d.ref_idd_br = h.ref_id_br
            AND d.clear_ckk = '0'
            AND d.ckk_st = '1'
        )"
    );

    if ($lastId > 0) {
        $filters[] = 'h.id < ' . (int)$lastId;
    }

    if ($keyword !== '') {
        $keywordLike = '%' . clearLoanEscape($conn, $keyword) . '%';
        $filters[] = "(
            h.ref_id_br LIKE '{$keywordLike}'
            OR h.iv_no LIKE '{$keywordLike}'
            OR h.customer LIKE '{$keywordLike}'
            OR h.customer_id LIKE '{$keywordLike}'
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

    $queryLimit = $limit + 1;
    $sql = "SELECT
            h.ref_id_br,
            h.date_br,
            h.iv_no,
            h.iv_date,
            h.customer,
            h.customer_id,
            h.company,
            h.sale_code,
            h.status_doc,
            h.id,
            1 AS has_items
        FROM hos__br h
        WHERE " . implode(' AND ', $filters) . "
        ORDER BY h.id DESC
        LIMIT " . (int)$queryLimit;

    $query = mysqli_query($conn, $sql);
    if (!$query) {
        clearLoanJsonResponse(array(
            'success' => false,
            'message' => 'ไม่สามารถโหลดข้อมูลใบยืมได้'
        ), 500);
    }

    $rows = array();
    while ($row = mysqli_fetch_assoc($query)) {
        $rows[] = $row;
    }

    $hasMore = count($rows) > $limit;
    if ($hasMore) {
        array_pop($rows);
    }

    $documents = array();
    $nextLastId = null;

    foreach ($rows as $row) {
        $internalId = (int)$row['id'];
        $nextLastId = $internalId;
        $documents[] = clearLoanBuildLoanDocumentEntry($row);
    }

    return array(
        'documents' => $documents,
        'pagination' => array(
            'limit' => $limit,
            'has_more' => $hasMore,
            'next_last_id' => $hasMore ? $nextLastId : null,
            'returned' => count($documents)
        )
    );
}

function clearLoanFetchReserveDocumentItems($conn, $documentId, $company)
{
    $documentId = (int)$documentId;
    if ($documentId <= 0) {
        clearLoanJsonResponse(array(
            'success' => false,
            'message' => 'ไม่พบเอกสารที่ต้องการ'
        ), 400);
    }

    $filters = array(
        "h.close_jong = '0'",
        "h.cancel_ckk = '0'",
        "h.status_doc = 'Approve'",
        clearLoanCompanyFilter($company),
        clearLoanReserveSaleFilter($conn),
        "h.id_jong = {$documentId}"
    );

    $sql = "SELECT h.ref_id, h.iv_no
        FROM hos__jongproduct h
        WHERE " . implode(' AND ', $filters) . "
        LIMIT 1";
    $query = mysqli_query($conn, $sql);
    $row = $query ? mysqli_fetch_assoc($query) : null;

    if (!$row) {
        clearLoanJsonResponse(array(
            'success' => false,
            'message' => 'ไม่พบเอกสารใบจองที่ต้องการ'
        ), 404);
    }

    return clearLoanBuildReserveItems($conn, $row['ref_id'], $row['iv_no']);
}

function clearLoanFetchLoanDocumentItems($conn, $documentId, $company)
{
    $documentId = (int)$documentId;
    if ($documentId <= 0) {
        clearLoanJsonResponse(array(
            'success' => false,
            'message' => 'ไม่พบเอกสารที่ต้องการ'
        ), 400);
    }

    $filters = array(
        "h.close_br = '0'",
        "h.status_doc = 'Approve'",
        clearLoanCompanyFilter($company),
        clearLoanLoanSaleFilter(),
        "EXISTS (
            SELECT 1
            FROM hos__subbr d
            WHERE d.ref_idd_br = h.ref_id_br
            AND d.clear_ckk = '0'
            AND d.ckk_st = '1'
        )",
        "h.id = {$documentId}"
    );

    $sql = "SELECT h.ref_id_br, h.iv_no
        FROM hos__br h
        WHERE " . implode(' AND ', $filters) . "
        LIMIT 1";
    $query = mysqli_query($conn, $sql);
    $row = $query ? mysqli_fetch_assoc($query) : null;

    if (!$row) {
        clearLoanJsonResponse(array(
            'success' => false,
            'message' => 'ไม่พบเอกสารใบยืมที่ต้องการ'
        ), 404);
    }

    return clearLoanBuildLoanItems($conn, $row['ref_id_br'], $row['iv_no']);
}

$action = isset($_GET['action']) ? strtolower(trim((string)$_GET['action'])) : 'list';
$type = isset($_GET['type']) ? strtolower(trim((string)$_GET['type'])) : 'reserve';
$keyword = isset($_GET['keyword']) ? trim((string)$_GET['keyword']) : '';
$company = clearLoanNormalizeCompany(isset($_GET['company']) ? $_GET['company'] : '3');
$limit = clearLoanClampLimit(isset($_GET['limit']) ? $_GET['limit'] : 50);
$lastId = isset($_GET['last_id']) ? (int)$_GET['last_id'] : 0;
$documentId = isset($_GET['document_id']) ? (int)$_GET['document_id'] : 0;

if ($type !== 'reserve' && $type !== 'loan') {
    clearLoanJsonResponse(array(
        'success' => false,
        'message' => 'ประเภทเอกสารไม่ถูกต้อง'
    ), 400);
}

if ($action === 'items') {
    $items = $type === 'loan'
        ? clearLoanFetchLoanDocumentItems($conn, $documentId, $company)
        : clearLoanFetchReserveDocumentItems($conn, $documentId, $company);

    clearLoanJsonResponse(array(
        'success' => true,
        'items' => $items
    ));
}

$result = $type === 'loan'
    ? clearLoanFetchLoanDocuments($conn, $keyword, $lastId, $limit, $company)
    : clearLoanFetchReserveDocuments($conn, $keyword, $lastId, $limit, $company);

clearLoanJsonResponse(array(
    'success' => true,
    'documents' => $result['documents'],
    'pagination' => $result['pagination']
));
