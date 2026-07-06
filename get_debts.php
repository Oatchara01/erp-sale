<?php
// get_debts.php
header('Content-Type: application/json; charset=utf-8');
require_once 'dbconnect_acc.php';

function Datethainv($strDate)
{
    if (!$strDate) {
        return '';
    }

    $ts = strtotime($strDate);
    if ($ts === false) {
        return '';
    }

    $strYear = (int)date('Y', $ts) + 543;
    $strMonth = (int)date('n', $ts);
    $strDay = (int)date('j', $ts);
    $strMonthCut = array('', 'ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.');
    $strMonthThai = $strMonthCut[$strMonth] ?? '';

    return "$strDay $strMonthThai $strYear";
}

$action = isset($_GET['action']) ? trim($_GET['action']) : '';
if ($action === 'track') {
    $refIdOff = isset($_GET['ref_id_off']) ? trim($_GET['ref_id_off']) : '';
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
        echo json_encode(array('html' => '<em>ดึงรายการติดตามไม่สำเร็จ: ' . htmlspecialchars(mysqli_error($code), ENT_QUOTES, 'UTF-8') . '</em>'), JSON_UNESCAPED_UNICODE);
        exit;
    }

    mysqli_stmt_bind_param($stmtTrack, 's', $refIdOff);
    mysqli_stmt_execute($stmtTrack);
    $resTrack = mysqli_stmt_get_result($stmtTrack);

    ob_start();
    ?>
    <div style="max-height:60vh; overflow:auto; width:100%; margin-left:auto; border:0; text-align:right;">
      <table border="1" cellpadding="6" cellspacing="0" style="border-collapse:collapse; width:100%; margin-left:auto;">
        <thead style="background:#f2f2f2;">
          <tr>
            <th style="text-align:center; white-space:nowrap; background-color:#FFCCFF;">วันที่ติดตาม</th>
            <th style="text-align:left; background-color:#FFCCFF;">รายละเอียด</th>
            <th style="text-align:center; white-space:nowrap; background-color:#FFCCFF;">ผู้ติดตาม</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!$resTrack || mysqli_num_rows($resTrack) === 0): ?>
            <tr><td colspan="3" style="text-align:center;">ไม่มีรายการติดตาม</td></tr>
          <?php else: ?>
            <?php while ($track = mysqli_fetch_assoc($resTrack)): ?>
              <tr>
                <td style="text-align:center;"><?= htmlspecialchars(Datethainv($track['add_date']), ENT_QUOTES, 'UTF-8') ?></td>
                <td style="text-align:left;"><?= nl2br(htmlspecialchars((string)$track['des_track'], ENT_QUOTES, 'UTF-8')) ?></td>
                <td style="text-align:center;"><?= htmlspecialchars((string)$track['add_by'], ENT_QUOTES, 'UTF-8') ?></td>
              </tr>
            <?php endwhile; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
    <?php
    $body = ob_get_clean();
    mysqli_stmt_close($stmtTrack);

    echo json_encode(array('html' => $body), JSON_UNESCAPED_UNICODE);
    exit;
}

$cusId = isset($_GET['cus_id']) ? trim($_GET['cus_id']) : '';
if ($cusId === '') {
    echo json_encode(array('html' => '<em>ไม่พบรหัสลูกค้า</em>', 'total_outstanding' => 0), JSON_UNESCAPED_UNICODE);
    exit;
}

$today = date('Y-m-d');
$sql = "
    SELECT
        r.IV_number,
        r.date_inv,
        CAST(r.unit_cash AS DECIMAL(18,2)) AS unit_cash,
        r.id_off,
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
      AND r.bill_id = ?
    GROUP BY r.IV_number, r.date_inv, r.unit_cash, r.id_off, rc.paid_amount, tt.track_count
    HAVING balance_amount > 0
    ORDER BY r.date_inv ASC, r.IV_number ASC
";

$stmt = mysqli_prepare($code, $sql);
if (!$stmt) {
    echo json_encode(array('html' => '<em>Query เตรียมไม่สำเร็จ: ' . htmlspecialchars(mysqli_error($code), ENT_QUOTES, 'UTF-8') . '</em>', 'total_outstanding' => 0), JSON_UNESCAPED_UNICODE);
    exit;
}

mysqli_stmt_bind_param($stmt, 'ss', $today, $cusId);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);

$totalOutstanding = 0.0;
$rows = array();
if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $balance = (float)$row['balance_amount'];
        if ($balance <= 0) {
            continue;
        }

        $rows[] = array(
            'IV_number' => (string)$row['IV_number'],
            'date_inv' => (string)$row['date_inv'],
            'unit_cash' => (float)$row['unit_cash'],
            'paid_amount' => (float)$row['paid_amount'],
            'balance_amount' => $balance,
            'id_off' => (string)$row['id_off'],
            'track_count' => (int)$row['track_count'],
        );
        $totalOutstanding += $balance;
    }
} else {
    echo json_encode(array('html' => '<em>ดึงผลลัพธ์ไม่สำเร็จ: ' . htmlspecialchars(mysqli_error($code), ENT_QUOTES, 'UTF-8') . '</em>', 'total_outstanding' => 0), JSON_UNESCAPED_UNICODE);
    exit;
}

mysqli_stmt_close($stmt);

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
      <?php foreach ($rows as $row): ?>
        <tr>
          <td style="text-align:center;"><?= htmlspecialchars(Datethainv($row['date_inv']), ENT_QUOTES, 'UTF-8') ?></td>
          <td style="text-align:center;"><?= htmlspecialchars($row['IV_number'], ENT_QUOTES, 'UTF-8') ?></td>
          <td style="text-align:right;"><?= number_format((float)$row['balance_amount'], 2) ?></td>
          <td style="text-align:center;">
            <?php if ((int)$row['track_count'] > 0): ?>
              <button type="button"
                      class="btn-track"
                      data-id="<?= htmlspecialchars($row['id_off'], ENT_QUOTES, 'UTF-8') ?>"
                      title="คลิกเพื่อกาง/พับ รายการติดตาม (<?= (int)$row['track_count'] ?>)"
                      onclick="(function(btn){
                        var id = btn.getAttribute('data-id');
                        var rowEl = document.getElementById('track-' + id);
                        if(!rowEl) return;
                        var caret = btn.querySelector('.caret');
                        var opened = rowEl.style.display === 'table-row';
                        if(opened){
                          rowEl.style.display = 'none';
                          if(caret) caret.textContent='▶';
                          return;
                        }
                        rowEl.style.display = 'table-row';
                        if(caret) caret.textContent='▼';
                        if(rowEl.getAttribute('data-loaded') !== '1'){
                          var body = rowEl.querySelector('.track-body');
                          if(body){ body.innerHTML = 'กำลังโหลด...'; }
                          fetch('get_debts.php?action=track&ref_id_off=' + encodeURIComponent(id), {cache:'no-store'})
                            .then(function(r){return r.json();})
                            .then(function(data){
                              if(body){ body.innerHTML = (data && data.html) ? data.html : '<em>ไม่พบข้อมูล</em>'; }
                              rowEl.setAttribute('data-loaded','1');
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
        <?php if ((int)$row['track_count'] > 0): ?>
          <tr id="track-<?= htmlspecialchars($row['id_off'], ENT_QUOTES, 'UTF-8') ?>" class="track-row" data-loaded="0">
            <td class="track-cell" colspan="4"><div class="track-body"> </div></td>
          </tr>
        <?php endif; ?>
      <?php endforeach; ?>
    <?php endif; ?>
  </tbody>
  <?php if (!empty($rows)) : ?>
    <tfoot>
      <tr>
        <th colspan="2" style="text-align:right;">ยอดคงค้างรวม</th>
        <th style="text-align:right;"><?= number_format($totalOutstanding, 2) ?></th>
        <th></th>
      </tr>
    </tfoot>
  <?php endif; ?>
</table>
<?php
$tableHtml = ob_get_clean();

echo json_encode(array(
    'html' => $tableHtml,
    'total_outstanding' => $totalOutstanding
), JSON_UNESCAPED_UNICODE);