<?php

/**
 * Batch loader for ajax_breq_po_items.php.
 * Expects $keyword, $company and $limit from the endpoint and always exits with JSON.
 */

$dbOutputLevel = ob_get_level();
ob_start();

require_once __DIR__ . '/breq_repo.php';

try {
    include dirname(__DIR__) . '/dbconnect.php';
    ob_end_clean();

    if (!isset($conn) || !($conn instanceof mysqli)) {
        throw new RuntimeException('Main database connection is unavailable.');
    }
    if (!isset($new) || !($new instanceof mysqli)) {
        throw new RuntimeException('Stock database connection is unavailable.');
    }
    $stockConn = $new;

    foreach (array('in__main', 'in__sbmain') as $requiredTable) {
        $tableName = mysqli_real_escape_string($stockConn, $requiredTable);
        $tableCheck = breq_po_items_query(
            $stockConn,
            "SELECT 1 FROM information_schema.tables WHERE table_schema = DATABASE() AND table_name = '" . $tableName . "' LIMIT 1"
        );
        if (mysqli_num_rows($tableCheck) === 0) {
            throw new RuntimeException('Missing stock table: ' . $requiredTable);
        }
    }

    list($poConn, $poTable) = breq_po_main_source($conn);
    $companySql = "SELECT DISTINCT po_no FROM " . $poTable . " WHERE company = '" .
        mysqli_real_escape_string($poConn, $company) . "' AND po_no <> ''";
    $companyResult = breq_po_items_query($poConn, $companySql);
    $allowedPoNumbers = array();
    while ($companyRow = mysqli_fetch_assoc($companyResult)) {
        $allowedPoNumbers[] = (string)$companyRow['po_no'];
    }
    if (count($allowedPoNumbers) === 0) {
        breq_po_items_success(array());
    }

    $matchingProductIds = array();
    if ($keyword !== '') {
        $productNameSql = "SELECT product_ID FROM tb_product WHERE sol_name LIKE '%" .
            mysqli_real_escape_string($conn, $keyword) . "%'";
        $productNameResult = breq_po_items_query($conn, $productNameSql);
        while ($productNameRow = mysqli_fetch_assoc($productNameResult)) {
            $matchingProductIds[] = (string)$productNameRow['product_ID'];
        }
    }

    $stockWhere = array(
        "im.iv_no LIKE '%IO%'",
        "sm.ckk_check = '0'",
        'im.po_no IN (' . breq_po_items_sql_list($stockConn, $allowedPoNumbers) . ')',
    );
    if ($keyword !== '') {
        $keywordEscaped = mysqli_real_escape_string($stockConn, $keyword);
        $keywordWhere = array(
            "im.po_no LIKE '%" . $keywordEscaped . "%'",
            "sm.lot_no LIKE '%" . $keywordEscaped . "%'",
        );
        if (count($matchingProductIds) > 0) {
            $keywordWhere[] = 'sm.product_id IN (' . breq_po_items_sql_list($stockConn, $matchingProductIds) . ')';
        }
        $stockWhere[] = '(' . implode(' OR ', $keywordWhere) . ')';
    }

    // Do not filter close_br. Historical rows were closed even when stock remained.
    $stockSql = "SELECT im.ref_id AS main_ref_id, im.po_no, im.stock_date,
                        sm.product_id, sm.product_codesame, sm.sale_count, sm.lot_no,
                        sm.product_price, sm.product_nameother
                 FROM in__main im
                 INNER JOIN in__sbmain sm ON sm.ref_idd = im.ref_id
                 WHERE " . implode(' AND ', $stockWhere) . "
                 ORDER BY im.po_no DESC
                 LIMIT " . $limit;
    $stockResult = breq_po_items_query($stockConn, $stockSql);
    $stockRows = array();
    $productIds = array();
    $poNumbers = array();
    while ($row = mysqli_fetch_assoc($stockResult)) {
        $stockRows[] = $row;
        $productIds[] = (string)$row['product_id'];
        $poNumbers[] = (string)$row['po_no'];
    }
    if (count($stockRows) === 0) {
        breq_po_items_success(array());
    }

    $productSql = "SELECT product_ID, sol_name, access_code, war_hc, unit_name
                   FROM tb_product
                   WHERE product_ID IN (" . breq_po_items_sql_list($conn, $productIds) . ')';
    $productResult = breq_po_items_query($conn, $productSql);
    $productMap = array();
    while ($productRow = mysqli_fetch_assoc($productResult)) {
        $productMap[(string)$productRow['product_ID']] = $productRow;
    }

    $borrowedSql = "SELECT s.po_no, s.product_id, SUM(s.count) AS sum_count
                    FROM in__subbr s
                    INNER JOIN in__br b ON b.ref_id_br = s.ref_idd_br
                    WHERE b.status_doc <> 'Rejected'
                      AND s.po_no IN (" . breq_po_items_sql_list($conn, $poNumbers) . ")
                      AND s.product_id IN (" . breq_po_items_sql_list($conn, $productIds) . ")
                    GROUP BY s.po_no, s.product_id";
    $borrowedResult = breq_po_items_query($conn, $borrowedSql);
    $borrowedMap = array();
    while ($borrowedRow = mysqli_fetch_assoc($borrowedResult)) {
        $borrowedKey = (string)$borrowedRow['po_no'] . '|' . (string)$borrowedRow['product_id'];
        $borrowedMap[$borrowedKey] = (float)$borrowedRow['sum_count'];
    }

    $keywordLower = mb_strtolower($keyword, 'UTF-8');
    $items = array();
    foreach ($stockRows as $row) {
        $poNo = (string)$row['po_no'];
        $productId = (string)$row['product_id'];
        $product = isset($productMap[$productId])
            ? $productMap[$productId]
            : array('sol_name' => '', 'access_code' => '', 'war_hc' => '', 'unit_name' => '');
        $productName = (string)($product['sol_name'] ?? '');
        $lotNo = (string)($row['lot_no'] ?? '');

        if ($keyword !== '') {
            $haystack = mb_strtolower($poNo . ' ' . $productName . ' ' . $lotNo, 'UTF-8');
            if (mb_strpos($haystack, $keywordLower) === false) {
                continue;
            }
        }

        $borrowedKey = $poNo . '|' . $productId;
        $sumBorrowed = isset($borrowedMap[$borrowedKey]) ? $borrowedMap[$borrowedKey] : 0;
        $saleCount = (float)$row['sale_count'];

        $items[] = array(
            'po_no'              => $poNo,
            'product_name'       => $productName,
            'sale_count'         => $saleCount,
            'remaining'          => $saleCount - $sumBorrowed,
            'stock_date'         => (string)($row['stock_date'] ?? ''),
            'lot_no'             => $lotNo,
            'product_id'         => $productId,
            'product_codesame'   => (string)($row['product_codesame'] ?? ''),
            'access_code'        => (string)($product['access_code'] ?? ''),
            'product_price'      => (float)$row['product_price'],
            'war_hc'             => (string)($product['war_hc'] ?? ''),
            'unit_name'          => (string)($product['unit_name'] ?? ''),
            'product_nameother'  => (string)($row['product_nameother'] ?? ''),
            'ref_id'             => (string)$row['main_ref_id'],
        );
    }

    breq_po_items_success($items);
} catch (Throwable $error) {
    while (ob_get_level() > $dbOutputLevel) {
        ob_end_clean();
    }
    error_log('[BREQ_PO_ITEMS] ' . $error->getMessage());
    breq_po_items_fail('ไม่สามารถค้นหารายการ PO ได้ กรุณาลองใหม่อีกครั้ง', 500);
}
