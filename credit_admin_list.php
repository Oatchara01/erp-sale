<?php
header('Content-Type: text/html; charset=UTF-8');
require_once 'dbconnect.php';
require_once 'dbconnect_acc.php';

function h($s)
{
    return htmlspecialchars($s ?? '', ENT_QUOTES, 'UTF-8');
}

function thaiDMY($dateStr)
{
    if (!$dateStr) {
        return '-';
    }

    $t = strtotime($dateStr);
    if (!$t) {
        return '-';
    }

    return date('d-m-', $t) . (date('Y', $t) + 543);
}

if (isset($_GET['action']) && $_GET['action'] === 'track') {
    header('Content-Type: application/json; charset=UTF-8');

    $refIdOff = trim($_GET['ref_id_off'] ?? '');
    if ($refIdOff === '') {
        echo json_encode(array('html' => '<em>ไม่พบรหัสเอกสาร</em>'), JSON_UNESCAPED_UNICODE);
        exit;
    }

    $sqlTrack = "
        SELECT add_date, des_track, add_by
        FROM tb_track
        WHERE ref_id_off = ?
        ORDER BY add_date DESC, id_track DESC
    ";
    $stmtTrack = mysqli_prepare($code, $sqlTrack);
    if (!$stmtTrack) {
        echo json_encode(array('html' => '<em>ดึงข้อมูลไม่สำเร็จ: ' . htmlspecialchars(mysqli_error($code), ENT_QUOTES, 'UTF-8') . '</em>'), JSON_UNESCAPED_UNICODE);
        exit;
    }

    mysqli_stmt_bind_param($stmtTrack, 's', $refIdOff);
    mysqli_stmt_execute($stmtTrack);
    $resTrack = mysqli_stmt_get_result($stmtTrack);

    ob_start();
    ?>
    <table border="1" cellpadding="6" cellspacing="0" style="width:100%; border-collapse:collapse;">
        <thead>
            <tr>
                <th style="text-align:center;background:#FFCCFF;width:20%;">วันที่ติดตาม</th>
                <th style="background:#FFCCFF;">รายละเอียด</th>
                <th style="text-align:center;background:#FFCCFF;width:15%;">ผู้ติดตาม</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!$resTrack || mysqli_num_rows($resTrack) === 0): ?>
            <tr><td colspan="3" style="text-align:center;">ไม่มีรายการติดตาม</td></tr>
        <?php else: ?>
            <?php while ($track = mysqli_fetch_assoc($resTrack)): ?>
            <tr>
                <td style="text-align:center;"><?= h(thaiDMY($track['add_date'])) ?></td>
                <td><?= nl2br(h($track['des_track'])) ?></td>
                <td style="text-align:center;"><?= h($track['add_by']) ?></td>
            </tr>
            <?php endwhile; ?>
        <?php endif; ?>
        </tbody>
    </table>
    <?php
    $html = ob_get_clean();
    mysqli_stmt_close($stmtTrack);

    echo json_encode(array('html' => $html), JSON_UNESCAPED_UNICODE);
    exit;
}

$billId = trim($_GET['bill_id'] ?? '');
$today = date('Y-m-d');

$sqlCredit = 'SELECT credit_thb FROM tb_customer WHERE customer_id = ?';
$stmtCredit = mysqli_prepare($conn, $sqlCredit);
mysqli_stmt_bind_param($stmtCredit, 's', $billId);
mysqli_stmt_execute($stmtCredit);
$resCredit = mysqli_stmt_get_result($stmtCredit);
$creditRow = $resCredit ? mysqli_fetch_assoc($resCredit) : array('credit_thb' => 0);
mysqli_stmt_close($stmtCredit);

$sql = "
    SELECT
        r.id_off,
        r.customer_name,
        r.IV_number,
        r.bill_id,
        r.date_inv,
        CAST(r.unit_cash AS DECIMAL(18,2)) AS unit_cash,
        COALESCE(rc.paid_amount, 0) AS paid_amount,
        (CAST(r.unit_cash AS DECIMAL(18,2)) - COALESCE(rc.paid_amount, 0)) AS balance_amount,
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
      AND (
          NULLIF(TRIM(CAST(r.date_bank AS CHAR)), '') IS NULL
          OR TRIM(CAST(r.date_bank AS CHAR)) = '0000-00-00'
          OR TRIM(CAST(r.date_bank AS CHAR)) > ?
      )
      AND r.unit_cash <> '0.00'
      AND (r.ref_sub = '' OR r.ref_sub IS NULL)
      AND r.ref_id NOT LIKE '%BL%'
";

$params = array($today);
$types = 's';
if ($billId !== '') {
    $sql .= ' AND r.bill_id = ?';
    $params[] = $billId;
    $types .= 's';
}

$sql .= "
    GROUP BY r.id_off, r.customer_name, r.IV_number, r.bill_id, r.date_inv, r.unit_cash, rc.paid_amount, tt.track_count
    HAVING balance_amount > 0
    ORDER BY r.date_inv ASC, r.IV_number ASC
";

$stmt = mysqli_prepare($code, $sql);
if (!$stmt) {
    die('Prepare failed: ' . mysqli_error($code));
}

mysqli_stmt_bind_param($stmt, $types, ...$params);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);

$items = array();
$sumRemain = 0.0;
while ($row = mysqli_fetch_assoc($res)) {
    $remain = (float)$row['balance_amount'];
    if ($remain <= 0) {
        continue;
    }

    $row['_remain'] = $remain;
    $items[] = $row;
    $sumRemain += $remain;
}

mysqli_stmt_close($stmt);

$credit = (float)($creditRow['credit_thb'] ?? 0);
$balance = $credit - $sumRemain;
$color = $balance > 0 ? '#00AA00' : '#CC0000';
?>
<!doctype html>
<html lang="th">
<head>
<meta charset="utf-8">
<link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
body{ font-family:'Prompt', sans-serif; }
table.list{ width:100%; border-collapse:collapse; margin-top:10px; }
table.list th,table.list td{ border:1px solid #000; padding:8px; font-size:14px; }
.btn-track{ padding:2px 8px; background:#fff; border:1px solid #ccc; border-radius:4px; cursor:pointer; }
.btn-track:hover{ background:#f3f3f3; }
.text-center{ text-align:center; }
.text-right{ text-align:right; }
</style>
</head>
<body>
<div style="padding:16px;">
<div>
วงเงิน <span style="background:#FF6699;color:#fff;padding:3px 10px;border-radius:12px;">
    <?= number_format($credit, 2) ?>
</span>
&nbsp; คงเหลือ:
<span style="background:<?= $color ?>;color:#fff;padding:3px 10px;border-radius:12px;">
    <?= number_format($balance, 2) ?>
</span>
</div>

<table class="list">
<thead>
<tr>
    <th class="text-center">วันที่ออกเอกสาร</th>
    <th class="text-center">เลขที่เอกสาร</th>
    <th class="text-center">ชื่อลูกค้า</th>
    <th class="text-center">ยอดคงค้าง</th>
    <th class="text-center">การติดตาม</th>
</tr>
</thead>
<tbody>
<?php foreach ($items as $row): ?>
<tr>
    <td class="text-center"><?= thaiDMY($row['date_inv']) ?></td>
    <td class="text-center"><?= h($row['IV_number']) ?></td>
    <td><?= h($row['customer_name']) ?></td>
    <td class="text-right"><?= number_format($row['_remain'], 2) ?></td>
    <td class="text-center">
        <button class="btn-track" data-id="<?= h($row['id_off']) ?>" onclick="toggleTrackRow(this)">
            <span class="caret">▶</span>
        </button>
    </td>
</tr>
<tr id="track-<?= h($row['id_off']) ?>" style="display:none;" data-loaded="0">
    <td colspan="5">
        <div class="track-body" style="padding:8px;">กำลังโหลด...</div>
    </td>
</tr>
<?php endforeach; ?>
<?php if (empty($items)): ?>
<tr>
    <td colspan="5" class="text-center">ไม่พบยอดคงค้าง</td>
</tr>
<?php endif; ?>
<tr>
    <td></td>
    <td></td>
    <td><strong>รวมยอดคงค้าง</strong></td>
    <td class="text-right"><strong><?= number_format($sumRemain, 2) ?></strong></td>
    <td></td>
</tr>
</tbody>
</table>
</div>

<script>
function toggleTrackRow(btn){
    var id = btn.getAttribute('data-id');
    var row = document.getElementById('track-' + id);
    var caret = btn.querySelector('.caret');

    if (row.style.display === 'table-row') {
        row.style.display = 'none';
        caret.textContent = '▶';
        return;
    }

    row.style.display = 'table-row';
    caret.textContent = '▼';

    if (row.getAttribute('data-loaded') !== '1') {
        var body = row.querySelector('.track-body');
        body.innerHTML = 'กำลังโหลด...';
        fetch('?action=track&ref_id_off=' + encodeURIComponent(id))
            .then(function(r){ return r.json(); })
            .then(function(data){
                body.innerHTML = data.html;
                row.setAttribute('data-loaded', '1');
            })
            .catch(function(){
                body.innerHTML = '<em>โหลดข้อมูลไม่สำเร็จ</em>';
            });
    }
}
</script>
</body>
</html>