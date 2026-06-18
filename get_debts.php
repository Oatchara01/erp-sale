<?php
// get_debts.php
header('Content-Type: application/json; charset=utf-8');
require_once 'dbconnect_acc.php'; // ต้องประกาศตัวแปร $code = mysqli_connect(...)

/** แปลงวันที่ คศ -> พศ (ไทย) **/
function Datethainv($strDate) {
    if (!$strDate) return '';
    $ts = strtotime($strDate);
    if ($ts === false) return '';
    $strYear  = (int)date("Y", $ts) + 543;
    $strMonth = (int)date("n", $ts);
    $strDay   = (int)date("j", $ts);
    $strMonthCut = ["", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.",
                    "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."];
    $strMonthThai = $strMonthCut[$strMonth] ?? '';
    return "$strDay $strMonthThai $strYear";
}

/* ==========================================================
   โหมดโหลด "รายการติดตาม" สำหรับแถวที่กางลง (AJAX)
   GET: ?action=track&ref_id_off=xxxx
   ========================================================== */
$action = isset($_GET['action']) ? trim($_GET['action']) : '';
if ($action === 'track') {
    $refIdOff = isset($_GET['ref_id_off']) ? trim($_GET['ref_id_off']) : '';
    if ($refIdOff === '') {
        echo json_encode(['html' => '<em>ไม่พบรหัสเอกสาร</em>'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $sqlT = "
        SELECT add_date, des_track, add_by
        FROM tb_track
        WHERE ref_id_off = ?
        ORDER BY add_date DESC
    ";
    $stmtT = mysqli_prepare($code, $sqlT);
    if (!$stmtT) {
        echo json_encode(['html' => '<em>ดึงรายการติดตามไม่สำเร็จ: '.htmlspecialchars(mysqli_error($code)).'</em>'], JSON_UNESCAPED_UNICODE);
        exit;
    }
    mysqli_stmt_bind_param($stmtT, "s", $refIdOff);
    mysqli_stmt_execute($stmtT);
    $resT = mysqli_stmt_get_result($stmtT);

    ob_start();
    ?>
    <div style="max-height:60vh; overflow:auto; width:100%; margin-left:auto; border:0; text-align:right;">
  <table border="1" cellpadding="6" cellspacing="0" style="border-collapse:collapse; width:100%; margin-left:auto;">
  <thead style="background:#f2f2f2;">
    <tr>
      <th style="text-align:center; white-space:nowrap; background-color:#FFCCFF;">
        วันที่ติดตาม
      </th>
      <th style="text-align:left; background-color:#FFCCFF;">
        รายละเอียด
      </th>
      <th style="text-align:center; white-space:nowrap; background-color:#FFCCFF;">
        ผู้ติดตาม
      </th>
    </tr>
  </thead>


    <tbody>
      <?php if (!$resT || mysqli_num_rows($resT) === 0): ?>
        <tr><td colspan="3" style="text-align:center;">ไม่มีรายการติดตาม</td></tr>
      <?php else: ?>
        <?php while ($t = mysqli_fetch_assoc($resT)): ?>
          <tr>
            <td style="text-align:center;">
              <?= htmlspecialchars(Datethainv($t['add_date'])) ?>
            </td>
            <td style="text-align:left;">
              <?= nl2br(htmlspecialchars((string)$t['des_track'])) ?>
            </td>
            <td style="text-align:center;">
              <?= htmlspecialchars((string)$t['add_by']) ?>
            </td>
          </tr>
        <?php endwhile; ?>
      <?php endif; ?>
    </tbody>
  </table>
</div>

    <?php
    $body = ob_get_clean();
    echo json_encode(['html' => $body], JSON_UNESCAPED_UNICODE);
    exit;
}

/* ==========================================================
   โหมดหลัก: โหลดบิลคงค้างของลูกค้า
   GET: ?cus_id=XXXX
   ========================================================== */
$cusId = isset($_GET['cus_id']) ? trim($_GET['cus_id']) : '';
if ($cusId === '') {
  echo json_encode(['html' => '<em>ไม่พบรหัสลูกค้า</em>', 'total_outstanding' => 0], JSON_UNESCAPED_UNICODE);
  exit;
}

/*
  ดึงบิลที่ยังมีคงค้าง พร้อมนับจำนวนการติดตาม (track_count)
r.summary_cash != 'สมบูรณ์'
    AND */

$today = date('Y-m-d');


$sql = "
  SELECT
    r.IV_number,
    r.date_inv,
    r.unit_cash,
    r.id_off,
    COALESCE(SUM(rc.amount), 0) AS paid_amount,
    (CAST(r.unit_cash AS DECIMAL(18,2)) - COALESCE(SUM(rc.amount), 0)) AS balance_amount,
    (SELECT COUNT(*) FROM tb_track t WHERE t.ref_id_off = r.id_off) AS track_count
  FROM tb_register_data AS r
  LEFT JOIN tb_receipt_cash AS rc
    ON rc.ref_id_off = r.id_off
  WHERE r.IV_number NOT LIKE '%R%'
    AND r.IV_number NOT LIKE '%ธ%'
	AND (
  r.date_bank IS NULL
  OR r.date_bank = '0000-00-00'
  OR r.date_bank > '$today'
)
    AND r.unit_cash != '0.00'
    AND r.ref_sub = ''
	AND r.ref_id NOT LIKE '%BL%'
    AND r.bill_id = ?
  GROUP BY r.IV_number, r.date_inv, r.unit_cash, r.id_off
  HAVING balance_amount > 0
  ORDER BY r.date_inv ASC, r.IV_number ASC
";

//echo $sql;

$stmt = mysqli_prepare($code, $sql);
if (!$stmt) {
  echo json_encode(['html' => '<em>Query เตรียมไม่สำเร็จ: '.htmlspecialchars(mysqli_error($code)).'</em>', 'total_outstanding' => 0], JSON_UNESCAPED_UNICODE);
  exit;
}
mysqli_stmt_bind_param($stmt, "s", $cusId);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);

$total_outstanding = 0.0;
$rows = [];
if ($res) {
  while ($r = mysqli_fetch_assoc($res)) {
    $unit_cash = (float)$r['unit_cash'];
    $paid      = (float)$r['paid_amount'];
    $balance   = (float)$r['balance_amount'];
    if ($balance <= 0) continue;

    $total_outstanding += $balance;

    $rows[] = [
      'IV_number'      => $r['IV_number'],
      'date_inv'       => $r['date_inv'],
      'unit_cash'      => $unit_cash,
      'paid_amount'    => $paid,
      'balance_amount' => $balance,
      'id_off'         => $r['id_off'],
      'track_count'    => (int)$r['track_count'],
    ];
  }
} else {
  echo json_encode(['html' => '<em>ดึงผลลัพธ์ไม่สำเร็จ: '.htmlspecialchars(mysqli_error($code)).'</em>', 'total_outstanding' => 0], JSON_UNESCAPED_UNICODE);
  exit;
}

/* ============== สร้าง HTML ตาราง + แถวกางลง (ไม่มี <script> ภายนอก) ============== */
ob_start();
?>
<style>
  .btn-track { cursor:pointer; }
  .caret { display:inline-block; width:1.2em; text-align:center; }
  .track-row { display:none; background:#fafafa; }
  .track-cell { padding:10px 12px; }
</style>

<table border="1" cellpadding="6" cellspacing="0" style="border-collapse:collapse; width:100%;">
  <thead style="background:#f2f2f2;">
    <tr>
      <th style="text-align:center;">วันที่ออกบิล</th>
      <th style="text-align:center;">เลขที่เอกสาร</th>
      <th style="text-align:right;">ยอดคงค้าง</th>
      <th style="text-align:center;">การติดตามลูกหนี้</th>
    </tr>
  </thead>
  <tbody>
    <?php if (empty($rows)) : ?>
      <tr><td colspan="4" style="text-align:center;">ไม่พบยอดคงค้าง</td></tr>
    <?php else: ?>
      <?php foreach ($rows as $r): ?>
        <tr>
          <td style="text-align:center;"><?= htmlspecialchars(Datethainv($r['date_inv'])) ?></td>
          <td style="text-align:center;"><?= htmlspecialchars($r['IV_number']) ?></td>
          <td style="text-align:right;"><?= number_format((float)$r['balance_amount'], 2) ?></td>
          <td style="text-align:center;">
            <?php if ((int)$r['track_count'] > 0): ?>
              <button type="button"
                      class="btn-track"
                      data-id="<?= htmlspecialchars($r['id_off']) ?>"
                      title="คลิกเพื่อกาง/พับ รายการติดตาม (<?= (int)$r['track_count'] ?>)"
                      onclick="(function(btn){
                        var id   = btn.getAttribute('data-id');
                        var row  = document.getElementById('track-'+id);
                        if(!row) return;
                        var caret = btn.querySelector('.caret');
                        var opened = row.style.display === 'table-row';
                        if(opened){
                          row.style.display = 'none';
                          if(caret) caret.textContent='▶';
                          return;
                        }
                        // เปิด
                        row.style.display = 'table-row';
                        if(caret) caret.textContent='▼';
                        // โหลดครั้งแรกเท่านั้น
                        if(row.getAttribute('data-loaded') !== '1'){
                          var body = row.querySelector('.track-body');
                          if(body){ body.innerHTML = 'กำลังโหลด...'; }
                          fetch('get_debts.php?action=track&ref_id_off=' + encodeURIComponent(id), {cache:'no-store'})
                            .then(function(r){return r.json();})
                            .then(function(data){
                              if(body){ body.innerHTML = (data && data.html) ? data.html : '<em>ไม่พบข้อมูล</em>'; }
                              row.setAttribute('data-loaded','1');
                            })
                            .catch(function(){
                              if(body){ body.innerHTML = '<em>โหลดข้อมูลไม่สำเร็จ</em>'; }
                            });
                        }
                      })(this)">
                <span class="caret">▶</span>
                
              </button>
            <?php else: ?>
              <span style="opacity:.6;">-</span>
            <?php endif; ?>
          </td>
        </tr>
        <?php if ((int)$r['track_count'] > 0): ?>
          <tr id="track-<?= htmlspecialchars($r['id_off']) ?>" class="track-row" data-loaded="0">
            <td class="track-cell" colspan="4">
              <div class="track-body"> </div>
            </td>
          </tr>
        <?php endif; ?>
      <?php endforeach; ?>
    <?php endif; ?>
  </tbody>
  <?php if (!empty($rows)) : ?>
  <tfoot>
    <tr>
      <th colspan="2" style="text-align:right;">ยอดคงค้างรวม</th>
      <th style="text-align:right;"><?= number_format($total_outstanding, 2) ?></th>
      <th></th>
    </tr>
  </tfoot>
  <?php endif; ?>
</table>
<?php
$tableHtml = ob_get_clean();

echo json_encode([
  'html' => $tableHtml,
  'total_outstanding' => $total_outstanding
], JSON_UNESCAPED_UNICODE);
