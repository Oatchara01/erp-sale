<?php
header('Content-Type: text/html; charset=UTF-8');
require_once 'dbconnect.php';      // ต้องนิยาม $code
require_once 'dbconnect_acc.php';  // ใช้ $code เช่นกัน

function h($s){ return htmlspecialchars($s ?? '', ENT_QUOTES, 'UTF-8'); }

/* ==========================
    1) AJAX โหลดข้อมูลติดตาม
   ========================== */
if (isset($_GET['action']) && $_GET['action'] === 'track') {
    header('Content-Type: application/json; charset=UTF-8');

    $refIdOff = trim($_GET['ref_id_off'] ?? '');
    if ($refIdOff === '') {
        echo json_encode(['html' => '<em>ไม่พบรหัสเอกสาร</em>'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $sqlT = "SELECT add_date, des_track, add_by 
             FROM tb_track 
             WHERE ref_id_off = ?
             ORDER BY add_date DESC";
    $st = mysqli_prepare($code, $sqlT);

    if (!$st) {
        echo json_encode(['html'=>'<em>ดึงข้อมูลไม่สำเร็จ: '.mysqli_error($code).'</em>'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    mysqli_stmt_bind_param($st, 's', $refIdOff);
    mysqli_stmt_execute($st);
    $rs = mysqli_stmt_get_result($st);

    ob_start(); ?>
    <table border="1" cellpadding="6" cellspacing="0" style="width:100%; border-collapse:collapse;">
        <thead>
            <tr>
                <th style="text-align:center;background:#FFCCFF;width:20%;">วันที่ติดตาม</th>
                <th style="background:#FFCCFF;">รายละเอียด</th>
                <th style="text-align:center;background:#FFCCFF;width:15%;">ผู้ติดตาม</th>
            </tr>
        </thead>
        <tbody>
        <?php if (mysqli_num_rows($rs) == 0): ?>
            <tr><td colspan="3" style="text-align:center;">ไม่มีรายการติดตาม</td></tr>
        <?php else: ?>
            <?php while($t = mysqli_fetch_assoc($rs)): ?>
            <tr>
                <td style="text-align:center;"><?= h(thaiDMY($t['add_date'])) ?></td>
                <td><?= nl2br(h($t['des_track'])) ?></td>
                <td style="text-align:center;"><?= h($t['add_by']) ?></td>
            </tr>
            <?php endwhile; ?>
        <?php endif; ?>
        </tbody>
    </table>
    <?php
    $html = ob_get_clean();
    echo json_encode(['html'=>$html], JSON_UNESCAPED_UNICODE);
    exit;
}


/* ==========================
    2) Query วงเงิน
   ========================== */
$billId = $_GET['bill_id'] ?? '';
$today = date('Y-m-d');

$sqlw = "SELECT credit_thb FROM tb_customer WHERE customer_id = ?";
$stw  = mysqli_prepare($conn, $sqlw);
mysqli_stmt_bind_param($stw, 's', $billId);
mysqli_stmt_execute($stw);
$rwc = mysqli_stmt_get_result($stw);
$rsw = $rwc ? mysqli_fetch_assoc($rwc) : ['credit_thb'=>0];
mysqli_stmt_close($stw);


/* ==========================
    3) Query รายการบิล
   ========================== */
$rows = [];
$sql = "
    SELECT id_off, customer_name, IV_number, unit_cash, bill_id, date_inv
    FROM tb_register_data
    WHERE  IV_number NOT LIKE '%R%'
      AND IV_number NOT LIKE '%ธ%'
      AND unit_cash <> '0.00'
      AND (ref_sub = '' OR ref_sub IS NULL)
	  AND (
  date_bank IS NULL
  OR date_bank = '0000-00-00'
  OR date_bank > '$today'
)
";

$params = [];
$types = '';

if ($billId !== '') {
    $sql .= " AND bill_id = ?";
    $params[] = $billId;
    $types .= 's';
}

$sql .= " ORDER BY date_inv ASC";
//echo $sql;
$stmt = mysqli_prepare($code, $sql);
if (!$stmt) die("Prepare failed: ".mysqli_error($code));

if ($params) mysqli_stmt_bind_param($stmt, $types, ...$params);

mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);

while ($r = mysqli_fetch_assoc($res)) $rows[] = $r;

mysqli_stmt_close($stmt);


/* ==========================
    4) ฟังก์ชันหายอดจ่ายแล้ว
   ========================== */
function findPaidAmount(mysqli $conn, $idOff){
    $sql = "SELECT COALESCE(SUM(amount),0) AS amount 
            FROM tb_receipt_cash 
            WHERE ref_id_off = ?";
    $st = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($st, 's', $idOff);
    mysqli_stmt_execute($st);
    $rs = mysqli_stmt_get_result($st);
    $paid = ($rs && ($r = mysqli_fetch_assoc($rs))) ? (float)$r['amount'] : 0;
    mysqli_stmt_close($st);
    return $paid;
}


/* ==========================
    5) สรุปยอดคงค้าง
   ========================== */
$items = [];
$sumRemain = 0;

foreach ($rows as $r) {
    $paid = findPaidAmount($code, $r['id_off']);
    $remain = max(((float)$r['unit_cash']) - $paid, 0);

    $r['_remain'] = $remain;
    $items[] = $r;
    $sumRemain += $remain;
}


/* ==========================
    6) helper วันที่ไทย
   ========================== */
function thaiDMY($dateStr){
    if (!$dateStr) return '-';
    $t = strtotime($dateStr);
    if (!$t) return '-';
    return date('d-m-', $t) . (date('Y', $t) + 543);
}

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
</style>
</head>

<body>

<div style="padding:16px;">

<?php
$credit = (float)$rsw['credit_thb'];
$balance = $credit - $sumRemain;
$color = $balance > 0 ? '#00AA00' : '#CC0000';
?>

<div>
วงเงิน <span style="background:#FF6699;color:#fff;padding:3px 10px;border-radius:12px;">
    <?= number_format($credit,2) ?>
</span>
&nbsp; คงเหลือ:
<span style="background:<?= $color ?>;color:#fff;padding:3px 10px;border-radius:12px;">
    <?= number_format($balance,2) ?>
</span>
</div>


<table class="list">
<thead>
<tr>
    <th style="text-align:center;">วันที่ออกเอกสาร</th>
    <th style="text-align:center;">เลขที่เอกสาร</th>
    <th style="text-align:center;">ชื่อลูกค้า</th>
    <th style="text-align:center;">ยอดคงค้าง</th>
    <th style="text-align:center;">การติดตาม</th>
</tr>
</thead>

<tbody>

<?php foreach($items as $r): ?>
<tr>
    <td class="text-align:center;"><?= thaiDMY($r['date_inv']) ?></td>
    <td class="text-align:center;"><?= h($r['IV_number']) ?></td>
    <td><?= h($r['customer_name']) ?></td>
    <td class="text-right"><?= number_format($r['_remain'],2) ?></td>

    <td class="text-center">
        <button class="btn-track" data-id="<?= $r['id_off'] ?>" onclick="toggleTrackRow(this)">
            <span class="caret">▶</span>
        </button>
    </td>
</tr>

<tr id="track-<?= $r['id_off'] ?>" style="display:none;" data-loaded="0">
    <td colspan="5">
        <div class="track-body" style="padding:8px;">กำลังโหลด...</div>
    </td>
</tr>

<?php endforeach; ?>

<tr>
    <td></td><td></td>
    <td><strong>รวมยอดคงค้าง</strong></td>
    <td class="text-right"><strong><?= number_format($sumRemain,2) ?></strong></td>
    <td></td>
</tr>

</tbody>
</table>

</div>

<script>
function toggleTrackRow(btn){
    let id = btn.getAttribute('data-id');
    let row = document.getElementById('track-'+id);
    let caret = btn.querySelector('.caret');

    if(row.style.display === 'table-row'){
        row.style.display = 'none';
        caret.textContent = '▶';
        return;
    }

    row.style.display = 'table-row';
    caret.textContent = '▼';

    if(row.getAttribute('data-loaded') !== '1'){
        let body = row.querySelector('.track-body');
        body.innerHTML = 'กำลังโหลด...';
        fetch('?action=track&ref_id_off=' + id)
            .then(r => r.json())
            .then(data => {
                body.innerHTML = data.html;
                row.setAttribute('data-loaded','1');
            })
            .catch(()=> body.innerHTML='<em>โหลดข้อมูลไม่สำเร็จ</em>');
    }
}
</script>

</body>
</html>
