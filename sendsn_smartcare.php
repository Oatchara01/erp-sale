<?php
mb_internal_encoding('UTF-8');
header('Content-Type: text/html; charset=utf-8');

// ================== DB (ใช้ของคุณ) ==================
include "dbconnect.php";
include("head.php");
if (!isset($conn) || !($conn instanceof mysqli)) {
  die("ไม่พบ \$conn จาก dbconnect.php");
}

date_default_timezone_set('Asia/Bangkok');


// ================== CONFIG ฝั่งเซิร์ฟเวอร์ ==================
$base = 'https://backend.allwellsmartcare.com';

// JWT เก็บฝั่งเซิร์ฟเวอร์ (ผู้ใช้หน้าเว็บไม่เห็น/ไม่ต้องกรอก)
$JWT = getenv('ALLWELL_JWT') ?: 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6MTIsInVzZXJuYW1lIjoiYWxsd2VsbGFwaSIsImhvc3BpdGFsSWQiOm51bGwsInJvbGUiOiJhZG1pbiIsImlhdCI6MTc1NTUxMjk1MX0.kTDRt3LM4xZ8od2cIzj7oh62-OztK0-i4TRpQCkIDOQ';
// ค่าคงที่อื่น ๆ
$DEVICE_TYPE = 'GlucoAll-Pro';
$PATIENT_ID  = null; // ต้องการส่ง null ตามสเปค

// รับ ref_id จาก URL
$REF_ID = trim($_GET['ref_id'] ?? ''); // ตัวอย่าง SO68060105

// ================== Helpers ==================
function h($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

function apiRequest(string $method, string $endpoint, string $token, array $data = null) {
  $url = rtrim($GLOBALS['base'], '/') . $endpoint;
  $ch  = curl_init($url);
  $headers = ['Authorization: Bearer '.$token, 'Accept: application/json'];
  if ($data !== null) { $headers[]='Content-Type: application/json';
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data, JSON_UNESCAPED_UNICODE)); }
  curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER=>true, CURLOPT_CUSTOMREQUEST=>$method, CURLOPT_HTTPHEADER=>$headers,
    CURLOPT_TIMEOUT=>30, CURLOPT_CONNECTTIMEOUT=>10, CURLOPT_SSL_VERIFYPEER=>true, CURLOPT_SSL_VERIFYHOST=>2
  ]);
  $raw=curl_exec($ch); $errno=curl_errno($ch); $error=curl_error($ch);
  $status=curl_getinfo($ch, CURLINFO_HTTP_CODE); curl_close($ch);
  if ($errno) throw new Exception("cURL error: $error");
  $json=json_decode($raw,true);
  if ($status<200||$status>=300){
    $msg=is_array($json)?json_encode($json,JSON_UNESCAPED_UNICODE):$raw;
    if($status===401) throw new Exception("HTTP 401 Unauthorized: JWT ไม่ถูกต้อง/หมดอายุ\nรายละเอียด: ".$msg);
    throw new Exception("HTTP $status: $msg");
  }
  return $json ?? $raw;
}

/** ดึง SN จาก DB ด้วย ref_id ตามเงื่อนไขที่ให้ไว้ */
// แยก SN จากสตริงเดียวให้เป็นรายตัว: รองรับ ช่องว่าง, คอมมา, ; , | , / , เว้นบรรทัด
function normalizeSnTokens(string $raw): array {
    // อัปเปอร์เคส + ตัดอักขระที่ไม่ใช่ A-Z/0-9 (ถ้าต้องการเก็บขีด/จุด ให้เอาบรรทัด preg_replace ออก)
    $raw = strtoupper($raw);
    // split ตามตัวคั่นที่พบบ่อย
    $parts = preg_split('/[,\s;|\/]+/u', $raw, -1, PREG_SPLIT_NO_EMPTY);
    // กรองให้เหลือแต่ A-Z0-9 ล้วน ๆ และตัดช่องว่างหัวท้าย
    $parts = array_map(function($t){
        $t = trim($t);
        $t = preg_replace('/[^A-Z0-9]/', '', $t);
        return $t;
    }, $parts);
    // ลบค่าว่าง/ซ้ำ
    $parts = array_values(array_unique(array_filter($parts, fn($t) => $t !== '')));
    return $parts;
}

function refKind(string $ref): ?string {
    $ref = strtoupper(trim($ref));
    if (strpos($ref, 'SO') === 0) return 'SO';
    if (strpos($ref, 'BR') === 0) return 'BR';
    if (strpos($ref, 'RS') === 0) return 'RS';   // ✅ เพิ่ม RS
    return null;
}

/** ดึง SN ตาม ref_id → แยกเป็นรายตัว (ไม่ซ้ำ) รองรับ SO/BR/RS */
function getSNsByRefId(mysqli $conn, string $refId): array {
    $kind = refKind($refId) ?? 'SO'; // fallback

    if ($kind === 'BR') {
        $sql = "SELECT DISTINCT TRIM(hs.sn) AS sn
                FROM hos__subbr hs
                LEFT JOIN tb_product p ON hs.product_ID = p.product_id
                WHERE hs.ref_idd_br = ?
                  AND p.group1  = '501205.1 เครื่องวัดน้ำตาล - GLUCOALL'
                  AND p.sol_name LIKE '%GLUCOALL-PRO%'
                  AND hs.sn IS NOT NULL AND hs.sn <> ''";
    } elseif ($kind === 'RS') {
        $sql = "SELECT DISTINCT TRIM(hs.sn) AS sn
                FROM hos__subsmp hs
                LEFT JOIN tb_product p ON hs.product_ID = p.product_id
                WHERE hs.reff_idsmp = ?
                  AND p.group1  = '501205.1 เครื่องวัดน้ำตาล - GLUCOALL'
                  AND p.sol_name LIKE '%GLUCOALL-PRO%'
                  AND hs.sn IS NOT NULL AND hs.sn <> ''";
    } else { // SO
        $sql = "SELECT DISTINCT TRIM(hs.sn) AS sn
                FROM hos__subso hs
                LEFT JOIN tb_product p ON hs.product_ID = p.product_id
                WHERE hs.ref_idd = ?
                  AND p.group1  = '501205.1 เครื่องวัดน้ำตาล - GLUCOALL'
                  AND p.sol_name LIKE '%GLUCOALL-PRO%'
                  AND hs.sn IS NOT NULL AND hs.sn <> ''";
    }

    $stmt = $conn->prepare($sql);
    if (!$stmt) throw new Exception('SQL prepare error: '.$conn->error);
    $stmt->bind_param('s', $refId);
    $stmt->execute();
    $res = $stmt->get_result();

    $set = [];
    while ($row = $res->fetch_assoc()) {
        $raw = (string)($row['sn'] ?? '');
        foreach (normalizeSnTokens($raw) as $sn) {
            $set[$sn] = true;
        }
    }
    $stmt->close();

    return array_keys($set);
}

// --- เตรียม SN สำหรับแสดงใต้เลขที่อ้างอิง ---
$snPreview = [];
$snPreviewErr = null;
if ($REF_ID !== '') {
    try {
        $snPreview = getSNsByRefId($conn, $REF_ID);
    } catch (Exception $e) {
        $snPreviewErr = $e->getMessage();
    }
}



// ================== Actions ==================
$flash = null;

if ($_SERVER['REQUEST_METHOD']==='POST' && ($_POST['action'] ?? '') === 'send_sn') {
  try {
    if ($JWT === '') throw new Exception('ไม่ได้ตั้ง JWT ฝั่งเซิร์ฟเวอร์');
    $hid = (int)($_POST['hospitalId'] ?? 0);
    $ref = trim($_POST['ref_id'] ?? '');
    if ($hid <= 0) throw new Exception('ไม่พบ hospitalId');
    if ($ref === '') throw new Exception('ต้องกำหนด ref_id ใน URL หรือในโค้ด');

    // ดึง SN จากฐานข้อมูล
    $snArr = getSNsByRefId($conn, $ref);
    if (!$snArr) throw new Exception('ไม่พบ SN ตาม ref_id: '.$ref);

    // ส่งเข้า API
    $payload = [
      "snDevice"   => array_values($snArr),
      "patientId"  => $GLOBALS['PATIENT_ID'],   // null
      "hospitalId" => $hid,
      "deviceType" => $GLOBALS['DEVICE_TYPE'],  // "GlucoAll-Pro"
    ];
    $resp = apiRequest('POST', '/api/v1/devices', $GLOBALS['JWT'], $payload);

    // ===== อัปเดตสถานะใน DB ให้ถูกตารางตาม prefix ของ ref_id =====
    $kind = refKind($ref) ?? 'SO';
if ($kind === 'BR') {
  $stmtUp = $conn->prepare("UPDATE hos__subbr SET sm_care='1' WHERE ref_idd_br = ?");
} elseif ($kind === 'RS') {
  $stmtUp = $conn->prepare("UPDATE hos__subsmp SET sm_care='1' WHERE reff_idsmp = ?");  // ✅ เพิ่ม RS
} else {
  $stmtUp = $conn->prepare("UPDATE hos__subso SET sm_care='1' WHERE ref_idd = ?");
}

    if (!$stmtUp) {
      throw new Exception('SQL prepare error (update sm_care): '.$conn->error);
    }
    $stmtUp->bind_param('s', $ref);
    $stmtUp->execute();
    $stmtUp->close();

    // ===== Redirect ไปหน้า status_glucosemkhos.php =====
    // ส่งพารามิเตอร์ประกอบไปด้วย (ตามต้องการ)
    $target = 'status_glucosemkhos.php'
            . '?ref_id='     . rawurlencode($ref)
            . '&hospitalId=' . urlencode((string)$hid)
            . '&sent='       . urlencode((string)count($snArr));

    if (!headers_sent()) {
      header("Location: $target");
      exit;
    } else {
      echo "<script>window.location.href='".htmlspecialchars($target, ENT_QUOTES)."';</script>";
      exit;
    }

  } catch (Exception $e) {
    // กรณีผิดพลาด แสดงผลบนหน้านี้เหมือนเดิม
    $flash = [
      'type'   => 'error',
      'text'   => 'ส่ง SN ไม่สำเร็จ',
      'detail' => $e->getMessage(),
    ];
  }
}


// โหลดรายการโรงพยาบาลจาก API
$hospitals = [];
$loadErr = null;
try {
  $h = apiRequest('GET','/api/v1/hospitals',$JWT);
  $hospitals = (is_array($h) && isset($h['data']) && is_array($h['data'])) ? $h['data'] : (is_array($h)?$h:[]);
} catch (Exception $e) {
  $loadErr = $e->getMessage();
}
?>
<!doctype html>
<html lang="th">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>ตารางลูกค้า/โรงพยาบาล → ส่ง SN ได้ทันที</title>
<style>
 body{font-family:ui-sans-serif,system-ui,-apple-system,"Segoe UI",Roboto,"Noto Sans Thai",sans-serif;margin:24px}
 .card{border:1px solid #ddd;border-radius:10px;padding:14px;margin-bottom:16px;background:#fff}
 table{width:100%;border-collapse:collapse} th,td{border:1px solid #cfcfcf;padding:8px 10px;font-size:14px}
 th{background:#ddd;font-weight:600} .status{font-weight:700;text-align:center}
 .status.approve{background:#00ff00;color:#111}
 .flash{padding:10px;border-radius:8px;margin-bottom:12px;white-space:pre-wrap}
 .flash.success{background:#ecfdf5;border:1px solid #10b981;color:#065f46}
 .flash.error{background:#fef2f2;border:1px solid #ef4444;color:#7f1d1d}
 .toolbar{display:flex;gap:12px;align-items:center;justify-content:space-between;margin-bottom:8px}
 input[type=text]{padding:8px 10px;border:1px solid #d1d5db;border-radius:8px;min-width:260px}
 .btn{display:inline-block;padding:6px 12px;border-radius:8px;border:1px solid #ccc;background:#f7f7f7;cursor:pointer}
 .btn.primary{background:#2f6dfc;color:#fff;border-color:#2f6dfc}
 .icon-btn{font-size:18px;line-height:1;background:#e8ffe8;border:1px solid #9ae69a;color:#0a6c0a;padding:4px 10px;border-radius:8px}
 .muted{color:#6b7280;font-size:13px}
.sn-head{margin-top:6px;font-weight:600}
.sn-list{display:flex;flex-wrap:wrap;gap:6px;margin-top:6px}
.sn-chip{border:1px solid #d1d5db;border-radius:8px;padding:4px 8px;
         font-family:ui-monospace,SFMono-Regular,Menlo,monospace;font-size:12px;background:#fafafa}
	
</style>
</head>
<body>

<?php if ($flash): ?>
  <div class="flash <?= $flash['type']==='success'?'success':'error' ?>">
    <strong><?= h($flash['text']) ?></strong>
    <?php if (!empty($flash['detail'])): ?><div style="margin-top:6px"><code><?= h($flash['detail']) ?></code></div><?php endif; ?>
  </div>
<?php endif; ?>

<div class="card">
  <div class="toolbar">
<?php
$iv_no = null;
$bill_name = null;

if ($REF_ID !== '') {
    $kind = refKind($REF_ID) ?? 'SO';

    if ($kind === 'BR') {
        // BR → hos__br ใช้ ref_id_br, bill_name มาจาก customer
        $stmt = $conn->prepare("SELECT iv_no, customer FROM hos__br WHERE ref_id_br = ?");
        if (!$stmt) { die("SQL prepare error: ".$conn->error); }
        $stmt->bind_param('s', $REF_ID);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($row = $res->fetch_assoc()) {
            $iv_no     = $row['iv_no'] ?? null;
            $bill_name = $row['customer'] ?? null;
        }
        $stmt->close();
	}else if ($kind === 'RS') {
        // BR → hos__br ใช้ ref_id_br, bill_name มาจาก customer
        $stmt = $conn->prepare("SELECT smp_no, customer_name FROM hos__smp WHERE ref_idsmp = ?");
        if (!$stmt) { die("SQL prepare error: ".$conn->error); }
        $stmt->bind_param('s', $REF_ID);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($row = $res->fetch_assoc()) {
            $iv_no     = $row['smp_no'] ?? null;
            $bill_name = $row['customer_name'] ?? null;
        }
        $stmt->close();
    } else {
        // SO → hos__so ใช้ ref_id, bill_name มาจาก bill_name
        $stmt = $conn->prepare("SELECT iv_no, bill_name FROM hos__so WHERE ref_id = ?");
        if (!$stmt) { die("SQL prepare error: ".$conn->error); }
        $stmt->bind_param('s', $REF_ID);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($row = $res->fetch_assoc()) {
            $iv_no     = $row['iv_no'] ?? null;
            $bill_name = $row['bill_name'] ?? null;
        }
        $stmt->close();
    }
}
	
?>

    <div>
	  <div class="muted">สินค้า : <strong><?= h($DEVICE_TYPE) ?></strong></div>
     <div class="muted">
  เลขที่อ้างอิง : <strong><?= h($REF_ID ?: 'ยังไม่กำหนด (เพิ่ม ?ref_id=... ใน URL)') ?></strong>
  | เลขที่เอกสาร : <strong><?= h($iv_no ?: 'ยังไม่ได้ใส่เลขที่เอกสาร') ?></strong>
  | ชื่อออกบิล : <strong><?= h($bill_name ?: '-') ?></strong>
</div>
		
	<?php if ($REF_ID === ''): ?>
    <div class="muted">ยังไม่ระบุ ref_id จึงยังไม่แสดง SN (ใส่ ?ref_id=... ใน URL)</div>
  <?php elseif ($snPreviewErr): ?>
    <div class="flash error"><strong>โหลด SN ไม่สำเร็จ:</strong> <?= h($snPreviewErr) ?></div>
  <?php elseif (!$snPreview): ?>
    <div class="muted">ไม่พบ SN ในฐานข้อมูลสำหรับ ref_id นี้</div>
  <?php else: ?>
    <div class="sn-head">SN ทั้งหมด (<?= count($snPreview) ?> รายการ)</div>
    <div class="sn-list">
      <?php foreach ($snPreview as $sn): ?>
        <span class="sn-chip"><?= h($sn) ?></span>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>	
      
    </div>
    <div>
      <input type="text" id="filter" placeholder="ค้นหา: ชื่อลูกค้า/โรงพยาบาล">
    </div>
  </div>

  <table id="hospTable">
    <thead>
      <tr>
		<th>ID ลูกค้า</th>  
        <th>ชื่อลูกค้า</th>
        <th style="width:110px;text-align:center">ส่งข้อมูล SN</th>
      </tr>
    </thead>
    <tbody>
      <?php
      if ($loadErr) {
        echo '<tr><td colspan="4" class="flash error">โหลดรายชื่อไม่สำเร็จ: '.h($loadErr).'</td></tr>';
      } elseif (!$hospitals) {
        echo '<tr><td colspan="4" class="muted">ไม่มีข้อมูลโรงพยาบาลจาก API</td></tr>';
      } else {
        foreach ($hospitals as $it) {
          if (!is_array($it)) continue;
          $id   = $it['id'] ?? $it['hospitalId'] ?? null;
          $name = $it['name'] ?? $it['hospitalName'] ?? $it['title'] ?? '';
          if (!$id || !$name) continue;

          $region = $it['region'] ?? $it['salesRegion'] ?? $it['zone'] ?? $it['area'] ?? '';
          $status = $it['status'] ?? $it['approvalStatus'] ?? '';
          $statusCls = (mb_strtolower($status)==='approve') ? 'approve' : '';
          echo '<tr>';
		  echo '<td class="hid">'.h($id).'</td>';	
          echo '<td class="hname">'.h($name).'</td>';
          echo '<td style="text-align:center">';
          echo '  <form method="post" class="send-form" style="display:inline">';
          echo '    <input type="hidden" name="action" value="send_sn">';
          echo '    <input type="hidden" name="hospitalId" value="'.h((string)$id).'">';
          echo '    <input type="hidden" name="ref_id" value="'.h($REF_ID).'">'; // ใช้ ref_id จาก URL
          echo '    <button type="submit" class="icon-btn" title="ส่ง SN ให้โรงพยาบาลนี้" '.($REF_ID===''?'disabled':'').'>✔</button>';
          echo '  </form>';
          echo '</td>';
          echo '</tr>';
        }
      }
      ?>
    </tbody>
  </table>
 </div>

<script>
// ค้นหาชื่อลูกค้า/โรงพยาบาลในตาราง
const q = document.getElementById('filter');
if (q) {
  q.addEventListener('input', () => {
    const s = q.value.trim().toLowerCase();
    document.querySelectorAll('#hospTable tbody tr').forEach(tr => {
      const name = (tr.querySelector('.hname')?.textContent || '').toLowerCase();
      tr.style.display = name.includes(s) ? '' : 'none';
    });
  });
}
</script>
</body>
</html>
