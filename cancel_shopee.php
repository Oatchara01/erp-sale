<?php

date_default_timezone_set('Asia/Bangkok');

// (ไม่บังคับ) ส่วนหัวเว็บของคุณ
// include "head.php";

// ===== includes ที่ต้องใช้ =====
include "head.php";
include "databaseshopee.php";   // getRefreshTokenFromDB, updateShopToken, getTokenFromDB
include "shopeeAPI.php";        // getAccessTokenShopLevel, getAllCancelledOrders, getShippingDocumentResult
include "dbconnect.php";        // $conn (mysqli ERP DB)


$running = 12;
$refreshToken = getRefreshTokenFromDB($running);
if ($refreshToken) {
    $ret = getAccessTokenShopLevel($partnerId, $partnerKey, $shopId, $refreshToken);
    if ($ret) updateShopToken($ret, $running);
} else {
    die("<p style='color:#dc2626'>Error: ไม่พบ Refresh Token สำหรับ running ID: {$running}</p>");
}
$accessToken = base64_decode(getTokenFromDB($running));

// 2) ดึงออเดอร์ยกเลิกทุกหน้า (7 วันล่าสุด)
$result = getAllCancelledOrders($accessToken, [
    'time_range_field' => 'update_time',
    'time_from'        => strtotime('-7 days'),
    'time_to'          => time(),
    'page_size'        => 50,
    'max_pages'        => 50,
    'sleep_ms'         => 150,
]);

$apiErrors = $result['errors'] ?? [];
$orders    = $result['orders'] ?? [];
if (empty($orders)) {
    echo "<h3>ออเดอร์ยกเลิกจาก Shopee (7 วันล่าสุด)</h3>";
    echo "<p>ไม่พบออเดอร์ยกเลิกในช่วงวันที่ " . date('Y-m-d', strtotime('-7 days')) . " ถึง " . date('Y-m-d') . "</p>";
    exit;
}

// 3) รวบรวม order_sn
$orderSNs = array_values(array_unique(array_map(fn($o) => $o['order_sn'], $orders)));
if (empty($orderSNs)) {
    echo "<p>ไม่พบ order_sn</p>";
    exit;
}

// 4) เรียกใช้ “ฟังก์ชัน” ตามที่ต้องการ
$detailMap      = getOrderItems($accessToken, $orderSNs);         // เวลาสั่งซื้อ/ยกเลิก + สถานะ
$shippingDocMap = getShippingDocStatuses($accessToken, $orderSNs); // สถานะการปริ้นใบปะหน้า

// 5) ดึงสถานะจาก ERP เฉพาะออเดอร์ที่มีใน ERP
$erpMap = []; // order_sn => ['ref_id','cancel_ckk','create_order','approve_complete','erp_status','picking_status']
$placeholders = implode(',', array_fill(0, count($orderSNs), '?'));
$sql = "
    SELECT order_id, ref_id, cancel_ckk, create_order, approve_complete, ref_idst
    FROM so__main
    WHERE order_id IN ($placeholders)
";
if ($stmt = $conn->prepare($sql)) {
    $types = str_repeat('s', count($orderSNs));
    $stmt->bind_param($types, ...$orderSNs);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($row = $res->fetch_assoc()) {
        $sn = $row['order_id'];
        $cancel_ckk = (int)($row['cancel_ckk'] ?? 0);
        $erp_status = ($cancel_ckk === 1) ? 'ยกเลิก' : ($row['approve_complete'] ?? 'Open');

        // ตีความ “การจัดสินค้า” จาก ref_idst (ปรับตาม logic จริงของ ERP ได้)
        $picking_status = !empty($row['ref_idst']) ? 'จัดสินค้าแล้ว' : 'ยังไม่จัด';

        $erpMap[$sn] = [
            'ref_id'           => $row['ref_id'] ?? '',
            'cancel_ckk'       => $cancel_ckk,
            'create_order'     => $row['create_order'] ?? '',
            'approve_complete' => $row['approve_complete'] ?? '',
            'erp_status'       => $erp_status,
            'picking_status'   => $picking_status,
        ];
    }
    $stmt->close();
} else {
    die("<p style='color:#dc2626'>ERP query prepare fail: ".htmlspecialchars($conn->error)."</p>");
}

// ===== helpers =====
function fmtDT($ts){ return $ts ? date('Y-m-d H:i:s', (int)$ts) : '-'; }

// ===== HTML =====
?>
<!doctype html>
<html lang="th">
<head>
<meta charset="utf-8">
<title>ออเดอร์ยกเลิกจาก Shopee</title>
<style>
table{border-collapse:collapse;width:100%;font-family:system-ui, Tahoma, Arial}
th,td{border:1px solid #ddd;padding:8px}
th{background:#f3f4f6;text-align:left}
tr:nth-child(even){background:#fafafa}
.badge{display:inline-block;padding:2px 8px;border-radius:12px;font-size:12px;border:1px solid #ddd}
.badge-ok{border-color:#16a34a}
.badge-warn{border-color:#f59e0b}
.badge-err{border-color:#dc2626}
.badge-info{border-color:#3b82f6}
small.muted{color:#6b7280}
.wrap{max-width:1280px;margin:20px auto;padding:0 16px}
h3{margin:0 0 10px}
.meta{color:#6b7280;font-size:13px;margin-bottom:12px}
</style>
</head>
<body>
<div class="wrap">
  <h3>ออเดอร์ยกเลิกจาก Shopee (7 วันล่าสุด)</h3>
  <div class="meta">
    วันที่ค้นหา: <?= htmlspecialchars(date('Y-m-d', strtotime('-7 days'))) ?> – <?= htmlspecialchars(date('Y-m-d')) ?> |
    ทั้งหมด (ที่อยู่ใน ERP): 
    <?php 
      $countInERP = 0; foreach ($orderSNs as $sn) if (isset($erpMap[$sn])) $countInERP++;
      echo number_format($countInERP);
    ?> ออเดอร์
  </div>

  <?php if (!empty($apiErrors)): ?>
    <div class="error"><strong>API Errors</strong><pre><?php echo htmlspecialchars(print_r($apiErrors, true)); ?></pre></div>
  <?php endif; ?>

  <table>
    <thead>
      <tr>
        <th>หมายเลขคำสั่งซื้อ</th>
        <th>เวลาสั่งซื้อ</th>
        <th>เวลายกเลิก</th>
        <th>สถานะการปริ้นเอกสาร</th>
        <th>สถานะออเดอร์ ERP</th>
        <th>การจัดสินค้า</th>
      </tr>
    </thead>
    <tbody>
    <?php
      $printed = false;
      foreach ($orderSNs as $sn):
        if (!isset($erpMap[$sn])) continue; // แสดงเฉพาะที่มีใน ERP

        // เวลา: ใช้จาก get_order_detail (detailMap) เป็นหลัก
        $create_time = $detailMap[$sn]['create_time'] ?? null;
        $update_time = $detailMap[$sn]['update_time'] ?? null;

        // ถ้าต้องการ “เวลาสั่งซื้อจาก ERP” ให้อยู่เหนือ Shopee
        $create_order_erp = $erpMap[$sn]['create_order'] ?? '';

        // สถานะใบปะหน้า
        $doc       = $shippingDocMap[$sn] ?? null;
        $docStatus = $doc['status'] ?? 'N/A';
        $docUrl    = $doc['url'] ?? null;
        $docFail   = $doc['fail_reason'] ?? null;
        $badgeClass = 'badge-info';
        if (in_array($docStatus, ['READY','COMPLETED'], true)) $badgeClass = 'badge-ok';
        elseif ($docStatus === 'PROCESSING')                   $badgeClass = 'badge-warn';
        elseif ($docStatus === 'FAILED')                       $badgeClass = 'badge-err';

        // ERP
        $erpStatus = $erpMap[$sn]['erp_status'] ?? 'Open';
        $ref_id    = $erpMap[$sn]['ref_id'] ?? '';
        $picking   = $erpMap[$sn]['picking_status'] ?? 'N/A';
    ?>
      <tr>
        <td><?= htmlspecialchars($sn) ?></td>
        <td><?= $create_order_erp !== '' ? htmlspecialchars($create_order_erp) : fmtDT($create_time) ?></td>
        <td><?= fmtDT($update_time) ?></td>
        <td>
          <span class="badge <?= $badgeClass ?>"><?= htmlspecialchars($docStatus) ?></span>
          <?php if (!empty($docUrl)): ?>
            | <a href="<?= htmlspecialchars($docUrl) ?>" target="_blank" rel="noopener">ดาวน์โหลด</a>
          <?php endif; ?>
          <?php if (!empty($docFail)): ?>
            <div style="color:#dc2626;font-size:12px">เหตุผล: <?= htmlspecialchars($docFail) ?></div>
          <?php endif; ?>
        </td>
        <td>
          <?= htmlspecialchars($erpStatus) ?>
          <?php if ($ref_id !== ''): ?>
            <small class="muted">(Ref: <?= htmlspecialchars($ref_id) ?>)</small>
          <?php endif; ?>
        </td>
        <td><?= htmlspecialchars($picking) ?></td>
      </tr>
    <?php
        $printed = true;
      endforeach;

      if (!$printed) {
        echo '<tr><td colspan="6" style="text-align:center">ไม่มีออเดอร์ที่อยู่ใน ERP ตามเงื่อนไข</td></tr>';
      }
    ?>
    </tbody>
  </table>
</div>
</body>
</html>