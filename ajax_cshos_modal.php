<?php
header('Content-Type: application/json; charset=utf-8');
session_start();

if (empty($_SESSION['UserID'])) {
    http_response_code(401);
    echo json_encode(array(
        'success' => false,
        'message' => 'กรุณาเข้าสู่ระบบใหม่'
    ), JSON_UNESCAPED_UNICODE);
    exit;
}

require_once 'dbconnect.php';
require_once 'dbconnect_acc.php';

function cshos_modal_error($message, $statusCode = 400)
{
    http_response_code($statusCode);
    echo json_encode(array(
        'success' => false,
        'message' => $message
    ), JSON_UNESCAPED_UNICODE);
    exit;
}

// Map tb_track notes for debt records
function cshos_track_map(mysqli $code, array $refIdOffList)
{
    $trackMap = array();
    if (empty($refIdOffList)) {
        return $trackMap;
    }

    $placeholders = implode(',', array_fill(0, count($refIdOffList), '?'));
    $types = str_repeat('s', count($refIdOffList));
    $sql = "
        SELECT ref_id_off, add_date, des_track, add_by
        FROM tb_track
        WHERE ref_id_off IN ($placeholders)
        ORDER BY add_date DESC, id_track DESC
    ";

    $stmt = mysqli_prepare($code, $sql);
    if (!$stmt) {
        cshos_modal_error('ไม่สามารถเตรียมข้อมูลประวัติการติดตามได้', 500);
    }

    mysqli_stmt_bind_param($stmt, $types, ...$refIdOffList);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $refIdOff = (string)$row['ref_id_off'];
            if (!isset($trackMap[$refIdOff])) {
                $trackMap[$refIdOff] = array();
            }

            $trackMap[$refIdOff][] = array(
                'add_date' => (string)$row['add_date'],
                'des_track' => (string)$row['des_track'],
                'add_by' => (string)$row['add_by']
            );
        }
    }

    mysqli_stmt_close($stmt);

    foreach ($refIdOffList as $refIdOff) {
        $refIdOff = (string)$refIdOff;
        if (!isset($trackMap[$refIdOff])) {
            $trackMap[$refIdOff] = array();
        }
    }

    return $trackMap;
}

$billId = trim($_GET['bill_id'] ?? '');
if ($billId === '') {
    cshos_modal_error('ไม่พบรหัสลูกค้า');
}

// 1. Fetch Customer Credit Info
$customerSql = 'SELECT credit_ckk, credit_thb FROM tb_customer WHERE customer_id = ? LIMIT 1';
$customerStmt = mysqli_prepare($conn, $customerSql);
if (!$customerStmt) {
    cshos_modal_error('ไม่สามารถเตรียมข้อมูลลูกค้าได้', 500);
}

mysqli_stmt_bind_param($customerStmt, 's', $billId);
mysqli_stmt_execute($customerStmt);
$customerResult = mysqli_stmt_get_result($customerStmt);
$customerRow = $customerResult ? mysqli_fetch_assoc($customerResult) : null;
mysqli_stmt_close($customerStmt);

if (!$customerRow) {
    cshos_modal_error('ไม่พบข้อมูลลูกค้า');
}

$creditCkk = trim((string)($customerRow['credit_ckk'] ?? ''));
$creditAmount = (float)($customerRow['credit_thb'] ?? 0);
$creditDay = '';

if ($creditCkk !== '') {
    $bankSql = 'SELECT day FROM tb_bank WHERE id = ? LIMIT 1';
    $bankStmt = mysqli_prepare($code, $bankSql);
    if ($bankStmt) {
        mysqli_stmt_bind_param($bankStmt, 's', $creditCkk);
        mysqli_stmt_execute($bankStmt);
        $bankResult = mysqli_stmt_get_result($bankStmt);
        $bankRow = $bankResult ? mysqli_fetch_assoc($bankResult) : null;
        $creditDay = trim((string)($bankRow['day'] ?? ''));
        mysqli_stmt_close($bankStmt);
    }
}

// 2. Fetch Consignment Borrow Documents (CSHOS) from hos__consig
// Outstanding = lines not yet cleared to a billing document (clear_br <> 1)
$cshosLoans = array();
$totalCshosAmount = 0.0;
$totalCshosSold = 0.0;
$totalCshosOutstanding = 0.0;

// เอกสารใบยืมฝากขาย: จำนวน/มูลค่าที่ "ยืมจริง" มาจาก hos__subconsig (ผูกกับ hos__consig ด้วย ref_idd = c.ref_id)
// ส่วนที่ "เคลียร์แล้ว" (ขายออกไปแล้ว) เช็คจาก hos__subso โดย match กันด้วย iv_no (clear_ivno) + product_id
// ไม่ใช่ ref_id — เพราะ hos__subso.ref_idd อ้างถึงเอกสารใบสั่งขาย (hos__so) คนละตัวกับ hos__consig
// (รูปแบบเดียวกับ rister_clearbrsc_st.php และ ajax_get_clear_br_details.php)
$cshosSql = "SELECT ref_id, iv_no, date_save, add_date, status_doc FROM hos__consig WHERE (customer_id = ? OR customer = ?) ORDER BY ref_id DESC";

$cshosStmt = mysqli_prepare($conn, $cshosSql);
if ($cshosStmt) {
    mysqli_stmt_bind_param($cshosStmt, 'ss', $billId, $billId);
    if (mysqli_stmt_execute($cshosStmt)) {
        $cshosResult = mysqli_stmt_get_result($cshosStmt);
        if ($cshosResult) {
            while ($row = mysqli_fetch_assoc($cshosResult)) {
                $docDate = trim((string)($row['date_save'] ?? ''));
                if ($docDate === '' || $docDate === '0000-00-00') {
                    $docDate = trim((string)($row['add_date'] ?? ''));
                }

                $consigRefId = (string)$row['ref_id'];
                $ivNo = trim((string)($row['iv_no'] ?? ''));
                $ivNoEsc = mysqli_real_escape_string($conn, $ivNo);
                $consigRefIdEsc = mysqli_real_escape_string($conn, $consigRefId);

                $totalAmount = 0.0;
                $soldAmount = 0.0;
                $outstandingAmount = 0.0;
                $outstandingQty = 0.0;
                $productNames = array();

                $itemsSql = "SELECT hos__subconsig.product_id, hos__subconsig.count, hos__subconsig.amount, hos__subconsig.clear_ckk, tb_product.sol_name
                             FROM hos__subconsig
                             LEFT JOIN tb_product ON hos__subconsig.product_id = tb_product.product_ID
                             WHERE hos__subconsig.ref_idd = '{$consigRefIdEsc}'";
                $itemsResult = mysqli_query($conn, $itemsSql);
                if ($itemsResult) {
                    while ($item = mysqli_fetch_assoc($itemsResult)) {
                        $borrowQty = isset($item['count']) ? (float)$item['count'] : 0.0;
                        $itemAmount = isset($item['amount']) ? (float)$item['amount'] : 0.0;
                        $productId = isset($item['product_id']) ? (string)$item['product_id'] : '';
                        $productName = trim((string)($item['sol_name'] ?? ''));

                        $totalAmount += $itemAmount;
                        if ($productName !== '' && !in_array($productName, $productNames, true)) {
                            $productNames[] = $productName;
                        }

                        $clearedQty = 0.0;
                        if (isset($item['clear_ckk']) && $item['clear_ckk'] == '1') {
                            $clearedQty = $borrowQty;
                        } elseif ($productId !== '' && $ivNoEsc !== '') {
                            $prodIdEsc = mysqli_real_escape_string($conn, $productId);
                            $clearQ = mysqli_query($conn, "SELECT SUM(count) AS cnt FROM hos__subso WHERE clear_br = '1' AND product_id = '{$prodIdEsc}' AND clear_ivno = '{$ivNoEsc}' AND status_so = 'Approve'");
                            if ($clearQ && $clearRow = mysqli_fetch_assoc($clearQ)) {
                                $clearedQty = (float)$clearRow['cnt'];
                            }
                        }

                        if ($clearedQty > $borrowQty) $clearedQty = $borrowQty;
                        $remainingQty = $borrowQty - $clearedQty;
                        if ($remainingQty < 0) $remainingQty = 0;

                        $itemOutstandingAmount = ($borrowQty > 0) ? ($itemAmount * ($remainingQty / $borrowQty)) : 0.0;

                        $outstandingQty += $remainingQty;
                        $outstandingAmount += $itemOutstandingAmount;
                        $soldAmount += ($itemAmount - $itemOutstandingAmount);
                    }
                }

                $totalCshosAmount += $totalAmount;
                $totalCshosSold += $soldAmount;
                $totalCshosOutstanding += $outstandingAmount;

                $cshosLoans[] = array(
                    'ref_id' => $consigRefId,
                    'iv_no' => $ivNo,
                    'date' => $docDate,
                    'status_doc' => (string)($row['status_doc'] ?? ''),
                    'total_amount' => $totalAmount,
                    'sold_amount' => $soldAmount,
                    'outstanding_amount' => $outstandingAmount,
                    'outstanding_qty' => $outstandingQty,
                    'product_names' => $productNames
                );
            }
        }
    }
    mysqli_stmt_close($cshosStmt);
}

// 3. Fetch Outstanding Debts from tb_register_data
$today = date('Y-m-d');
$debtSql = "
    SELECT
        r.id_off,
        r.ref_id,
        r.IV_number,
        r.date_inv,
        CAST(r.unit_cash AS DECIMAL(18,2)) AS amount_due,
        COALESCE(rc.paid_amount, 0) AS paid_amount,
        GREATEST(
            CAST(r.unit_cash AS DECIMAL(18,2)) - COALESCE(rc.paid_amount, 0),
            0
        ) AS outstanding_amount,
        COALESCE(tt.track_count, 0) AS track_count,
        GROUP_CONCAT(DISTINCT NULLIF(TRIM(p.sol_name), '') ORDER BY p.sol_name SEPARATOR ' | ') AS product_names
    FROM tb_register_data AS r
    LEFT JOIN (
        SELECT ref_id_off, SUM(amount) AS paid_amount
        FROM tb_receipt_cash
        GROUP BY ref_id_off
    ) AS rc
        ON rc.ref_id_off = r.id_off
    LEFT JOIN (
        SELECT ref_id_off, COUNT(*) AS track_count
        FROM tb_track
        GROUP BY ref_id_off
    ) AS tt
        ON tt.ref_id_off = r.id_off
    LEFT JOIN allwell_sol_test.hos__subso AS hs
        ON hs.ref_idd = r.ref_id
    LEFT JOIN allwell_sol_test.tb_product AS p
        ON p.product_ID = hs.product_id
    WHERE r.IV_number NOT LIKE '%ธ%'
      AND r.IV_number NOT LIKE '%R%'
      AND (
          NULLIF(TRIM(CAST(r.date_bank AS CHAR)), '') IS NULL
          OR TRIM(CAST(r.date_bank AS CHAR)) = '0000-00-00'
          OR TRIM(CAST(r.date_bank AS CHAR)) > ?
      )
      AND r.unit_cash <> '0.00'
      AND (r.ref_sub = '' OR r.ref_sub IS NULL)
      AND r.ref_id NOT LIKE '%BL%'
      AND r.bill_id = ?
    GROUP BY r.id_off, r.ref_id, r.IV_number, r.date_inv, r.unit_cash, rc.paid_amount, tt.track_count
    HAVING outstanding_amount > 0
    ORDER BY r.date_inv ASC, r.IV_number ASC
";

$debts = array();
$refIdOffList = array();
$totalOutstanding = 0.0;

try {
    $debtStmt = mysqli_prepare($code, $debtSql);
    if ($debtStmt) {
        mysqli_stmt_bind_param($debtStmt, 'ss', $today, $billId);
        if (mysqli_stmt_execute($debtStmt)) {
            $debtResult = mysqli_stmt_get_result($debtStmt);
            if ($debtResult) {
                while ($row = mysqli_fetch_assoc($debtResult)) {
                    $amountDue = (float)$row['amount_due'];
                    $paidAmount = (float)$row['paid_amount'];
                    $outstandingAmount = (float)$row['outstanding_amount'];
                    if ($outstandingAmount <= 0) {
                        continue;
                    }

                    $refIdOff = (string)$row['id_off'];
                    $productNames = trim((string)($row['product_names'] ?? ''));

                    $debts[] = array(
                        'id_off' => $refIdOff,
                        'ref_id_off' => $refIdOff,
                        'ref_id' => (string)$row['ref_id'],
                        'IV_number' => (string)$row['IV_number'],
                        'date_inv' => (string)$row['date_inv'],
                        'amount_due' => $amountDue,
                        'paid_amount' => $paidAmount,
                        'outstanding_amount' => $outstandingAmount,
                        'track_count' => (int)$row['track_count'],
                        'product_names' => $productNames
                    );

                    $refIdOffList[] = $refIdOff;
                    $totalOutstanding += $outstandingAmount;
                }
            }
        }
        mysqli_stmt_close($debtStmt);
    }
} catch (Throwable $e) {
    // Continue even if debts query encounters error
}

$tracks = cshos_track_map($code, $refIdOffList);
$remainingCredit = $creditAmount - $totalOutstanding;

echo json_encode(array(
    'success' => true,
    'summary' => array(
        'credit_day' => $creditDay,
        'credit_amount' => $creditAmount,
        'total_cshos_amount' => $totalCshosAmount,
        'total_cshos_sold' => $totalCshosSold,
        'total_cshos_outstanding' => $totalCshosOutstanding,
        'total_outstanding' => $totalOutstanding,
        'remaining_credit' => $remainingCredit
    ),
    'cshos_loans' => $cshosLoans,
    'debts' => $debts,
    'tracks' => $tracks
), JSON_UNESCAPED_UNICODE);
