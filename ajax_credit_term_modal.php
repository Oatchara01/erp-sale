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

function credit_term_json_error($message, $statusCode = 400)
{
    http_response_code($statusCode);
    echo json_encode(array(
        'success' => false,
        'message' => $message
    ), JSON_UNESCAPED_UNICODE);
    exit;
}

function credit_term_track_map(mysqli $code, array $refIdOffList)
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
        credit_term_json_error('ไม่สามารถเตรียมข้อมูลประวัติการติดตามได้', 500);
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

function credit_term_product_name_map(mysqli $conn, array $refIdList)
{
    $productNameMap = array();
    $refIdList = array_values(array_unique(array_filter(array_map('strval', $refIdList), function ($refId) {
        return trim($refId) !== '';
    })));

    if (empty($refIdList)) {
        return $productNameMap;
    }

    foreach ($refIdList as $refId) {
        $productNameMap[$refId] = '';
    }

    $placeholders = implode(',', array_fill(0, count($refIdList), '?'));
    $types = str_repeat('s', count($refIdList));
    $sql = "
        SELECT
            hs.ref_idd,
            GROUP_CONCAT(DISTINCT NULLIF(TRIM(p.sol_name), '') ORDER BY p.sol_name SEPARATOR ' | ') AS product_names
        FROM hos__subso AS hs
        LEFT JOIN tb_product AS p
            ON p.product_ID = hs.product_id
        WHERE hs.ref_idd IN ($placeholders)
        GROUP BY hs.ref_idd
    ";

    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        credit_term_json_error('ไม่สามารถเตรียมข้อมูลสินค้าได้', 500);
    }

    mysqli_stmt_bind_param($stmt, $types, ...$refIdList);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $refId = (string)$row['ref_idd'];
            $productNameMap[$refId] = trim((string)($row['product_names'] ?? ''));
        }
    }

    mysqli_stmt_close($stmt);

    return $productNameMap;
}

$billId = trim($_GET['bill_id'] ?? '');
if ($billId === '') {
    credit_term_json_error('ไม่พบรหัสลูกค้า');
}

try {

    $customerSql = 'SELECT credit_ckk, credit_thb FROM tb_customer WHERE customer_id = ? LIMIT 1';
    $customerStmt = mysqli_prepare($conn, $customerSql);
    if (!$customerStmt) {
        credit_term_json_error('ไม่สามารถเตรียมข้อมูลลูกค้าได้', 500);
    }

    mysqli_stmt_bind_param($customerStmt, 's', $billId);
    mysqli_stmt_execute($customerStmt);
    $customerResult = mysqli_stmt_get_result($customerStmt);
    $customerRow = $customerResult ? mysqli_fetch_assoc($customerResult) : null;
    mysqli_stmt_close($customerStmt);

    if (!$customerRow) {
        credit_term_json_error('ไม่พบข้อมูลลูกค้า');
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
        COALESCE(tt.track_count, 0) AS track_count
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

    WHERE r.IV_number NOT LIKE '%ธ%'
      AND r.IV_number NOT LIKE '%R%'
	  AND r.IV_number NOT LIKE 'IC%'
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

    $debtStmt = mysqli_prepare($code, $debtSql);
    if (!$debtStmt) {
        credit_term_json_error('ไม่สามารถเตรียมข้อมูลหนี้คงค้างได้', 500);
    }

    mysqli_stmt_bind_param($debtStmt, 'ss', $today, $billId);
    if (!mysqli_stmt_execute($debtStmt)) {
        credit_term_json_error('ดึงข้อมูลหนี้คงค้างไม่สำเร็จ: ' . mysqli_stmt_error($debtStmt), 500);
    }
    $debtResult = mysqli_stmt_get_result($debtStmt);

    $debts = array();
    $refIdOffList = array();
    $refIdList = array();
    $totalOutstanding = 0.0;

    if ($debtResult) {
        while ($row = mysqli_fetch_assoc($debtResult)) {
            $amountDue = (float)$row['amount_due'];
            $paidAmount = (float)$row['paid_amount'];
            $outstandingAmount = (float)$row['outstanding_amount'];
            if ($outstandingAmount <= 0) {
                continue;
            }

            $refIdOff = (string)$row['id_off'];
            $refId = (string)$row['ref_id'];

            $debts[] = array(
                'id_off' => $refIdOff,
                'ref_id_off' => $refIdOff,
                'ref_id' => $refId,
                'IV_number' => (string)$row['IV_number'],
                'date_inv' => (string)$row['date_inv'],
                'amount_due' => $amountDue,
                'paid_amount' => $paidAmount,
                'outstanding_amount' => $outstandingAmount,
                // Legacy keys keep older cached clients compatible during deployment.
                'unit_cash' => $amountDue,
                'balance_amount' => $outstandingAmount,
                'track_count' => (int)$row['track_count'],
                'product_names' => ''
            );

            $refIdOffList[] = $refIdOff;
            $refIdList[] = $refId;
            $totalOutstanding += $outstandingAmount;
        }
    }

    mysqli_stmt_close($debtStmt);

    $productNameMap = credit_term_product_name_map($conn, $refIdList);
    foreach ($debts as &$debt) {
        $refId = (string)$debt['ref_id'];
        $debt['product_names'] = $productNameMap[$refId] ?? '';
    }
    unset($debt);

    $tracks = credit_term_track_map($code, $refIdOffList);
    $remainingCredit = $creditAmount - $totalOutstanding;
    $selectedRefIdOff = count($debts) > 0 ? (string)$debts[0]['id_off'] : '';

    echo json_encode(array(
        'success' => true,
        'summary' => array(
            'credit_day' => $creditDay,
            'credit_amount' => $creditAmount,
            'total_outstanding' => $totalOutstanding,
            'remaining_credit' => $remainingCredit
        ),
        'debts' => $debts,
        'tracks' => $tracks,
        'selected_ref_id_off' => $selectedRefIdOff
    ), JSON_UNESCAPED_UNICODE);
} catch (Throwable $e) {
    credit_term_json_error('เกิดข้อผิดพลาดในการตรวจสอบวงเงินเครดิต: ' . $e->getMessage(), 500);
}
