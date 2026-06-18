<!doctype html>
<html lang="th">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ตรวจสอบการรับประกันสินค้าออนไลน์ Allwell</title>
  <link rel="stylesheet" href="css/w3.css">
  <link rel="stylesheet" href="css/tab.css">
  <style>
    :root { --aw-primary: #652076; }
    .aw-header { color: var(--aw-primary); }
    .aw-cta { background-color: var(--aw-primary); border: 1px solid #00000020; color: #fff; padding: 10px 18px; font-size: 16px; border-radius: 10px; cursor: pointer; }
    .aw-cta:disabled { opacity: .6; cursor: not-allowed; }
    .w3-input { border: 1px solid #9B9B9B; border-radius: 8px; }
    .help { font-size: 12px; color: #666; margin-top: 4px; }
    #serial_num { text-transform: uppercase; }
	  .aw-panel-lg { font-size: 18px; line-height: 1.6; }
@media (min-width: 768px) {
  .aw-panel-lg { font-size: 14px; }
}

  </style>

<?php
  date_default_timezone_set("Asia/Bangkok");
  // dbconnect.php ต้องกำหนด 3 คอนเน็กชัน: $service, $servicenb (ใช้ tb_products_in_stock,tb_installation_data) และ $conn (ใช้ tb_product)
  include('dbconnect.php');

  // ---------------- Helper ----------------
	
// แปลงรูปแบบวันที่เป็น dd/mm/YYYY (ถ้าไม่มีค่าวันที่ คืน "-")
function fmt_date($dateStr, $with_time = false) {
  if (empty($dateStr) || $dateStr === '0000-00-00' || $dateStr === '0000-00-00 00:00:00') return '-';
  try {
    $dt = new DateTime($dateStr); // timezone ถูก set แล้วที่ Asia/Bangkok
    $d = (int)$dt->format('d');
    $m = (int)$dt->format('m');
    $y = (int)$dt->format('Y') + 543; // แปลงเป็น พ.ศ.

    $out = sprintf('%02d/%02d/%04d', $d, $m, $y);
    if ($with_time) $out .= ' ' . $dt->format('H:i');
    return $out;
  } catch (Exception $e) {
    return '-';
  }
}

	function is_zero_date($s) {
  return empty($s) || $s === '0000-00-00' || $s === '0000-00-00 00:00:00';
}

// แปลง warranty_phase เป็นจำนวน "ปี" รองรับรูปแบบ 2year, 2 years, 2yr, 2 ปี, 2
function parse_warranty_years($raw) {
  if ($raw === null) return null;
  $s = mb_strtolower(trim((string)$raw), 'UTF-8');

  // กรณีพิเศษ "ตลอดอายุการใช้งาน"
  if ($s === '99' || strpos($s, 'lifetime') !== false || strpos($s, 'ตลอด') !== false) {
    return 99; // ใช้ 99 เป็นสัญญะ "ตลอดอายุการใช้งาน"
  }

  // ดึงตัวเลขตัวแรก (รองรับทศนิยม แม้ปกติไม่น่ามี)
  if (preg_match('/([0-9]+(?:\.[0-9]+)?)/', $s, $m)) {
    $years = (float)$m[1];
    return $years > 0 ? $years : 0;
  }
  return null;
}

// คำนวณวันสิ้นสุดประกันจากวันติดตั้ง + (ปี)
function compute_end_date_by_years($install_date, $years) {
  if (is_zero_date($install_date) || empty($install_date) || $years === null) return null;
  try {
    $monthsTotal = (int)round(((float)$years) * 12); // เผื่อกรณีมีทศนิยม จะปัดเป็นจำนวนเดือน
    if ($monthsTotal <= 0) return null;
    $dt = new DateTime($install_date);
    $dt->add(new DateInterval('P' . $monthsTotal . 'M'));
    return $dt->format('Y-m-d');
  } catch (Exception $e) {
    return null;
  }
}


// อัปเดต out_insurance_date เฉพาะแถวที่ตรงกับ serial + เบอร์ (normalized)
// หมายเหตุ: ใช้คอนเน็กชันของฐานที่ "พบข้อมูลติดตั้ง" ($service หรือ $servicenb)
function update_out_date($conn, $serial, $telDigits, $newDate) {
  $sql = "UPDATE tb_installation_data
          SET out_insurance_date = ?
          WHERE product_sn = ?
            AND (
              REPLACE(REPLACE(REPLACE(REPLACE(install_cus_tel,'-',''),' ',''),'(',''),')','') = ?
              OR install_cus_tel = ?
            )
          LIMIT 1";
  if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, "ssss", $newDate, $serial, $telDigits, $telDigits);
    mysqli_stmt_execute($stmt);
    $rows = mysqli_stmt_affected_rows($stmt);
    mysqli_stmt_close($stmt);
    return $rows > 0;
  }
  return false;
}	
	
	
  function mask_name($s) {
    $s = trim((string)$s);
    if ($s === '') return '';
    if (function_exists('mb_strlen')) {
      $len = mb_strlen($s, 'UTF-8');
      if ($len <= 2) return $s;
      $first = mb_substr($s, 0, 1, 'UTF-8');
      $last  = mb_substr($s, -1, 1, 'UTF-8');
    } else {
      $len = strlen($s);
      if ($len <= 2) return $s;
      $first = substr($s, 0, 1);
      $last  = substr($s, -1);
    }
    return $first . str_repeat('*', $len - 2) . $last;
  }

  // ค้นข้อมูลติดตั้งจาก tb_installation_data (ใช้ $service / $servicenb)
  function find_install_row($conn, $serial, $telDigits) {
  $sql = "SELECT product_sn, install_cus_name, install_cus_tel, install_date, out_insurance_date, warranty_phase
          FROM tb_installation_data
          WHERE product_sn = ?
            AND (
              REPLACE(REPLACE(REPLACE(REPLACE(install_cus_tel,'-',''),' ',''),'(',''),')','') = ?
              OR install_cus_tel = ?
            )
          LIMIT 1";
  if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, "sss", $serial, $telDigits, $telDigits);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $row = $res ? mysqli_fetch_assoc($res) : null;
    mysqli_stmt_close($stmt);
    return $row;
  }
  return null;
}

  // มี Serial ในข้อมูลติดตั้งหรือไม่ (ใช้ $service / $servicenb)
  function exists_install_by_sn($conn, $serial) {
    $sql = "SELECT 1 FROM tb_installation_data WHERE product_sn = ? LIMIT 1";
    if ($stmt = mysqli_prepare($conn, $sql)) {
      mysqli_stmt_bind_param($stmt, "s", $serial);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_store_result($stmt);
      $num = mysqli_stmt_num_rows($stmt);
      mysqli_stmt_close($stmt);
      return $num > 0;
    }
    return false;
  }

  // ดึง product_id จาก tb_products_in_stock (ใช้ $service / $servicenb)
  function find_product_id($conn, $serial) {
    $sql = "SELECT product_id FROM tb_products_in_stock WHERE product_sn = ? LIMIT 1";
    if ($stmt = mysqli_prepare($conn, $sql)) {
      mysqli_stmt_bind_param($stmt, "s", $serial);
      mysqli_stmt_execute($stmt);
      $res = mysqli_stmt_get_result($stmt);
      $row = $res ? mysqli_fetch_assoc($res) : null;
      mysqli_stmt_close($stmt);
      return $row ? $row['product_id'] : null;
    }
    return null;
  }

  // ดึงชื่อสินค้า sol_name จาก tb_product (ใช้ $conn)
  function find_product_name($connProd, $product_id) {
    $sql = "SELECT sol_name FROM tb_product WHERE product_id = ? LIMIT 1";
    if ($stmt = mysqli_prepare($connProd, $sql)) {
      // ถ้า product_id เป็น int ล้วน เปลี่ยน "s" เป็น "i"
      mysqli_stmt_bind_param($stmt, "s", $product_id);
      mysqli_stmt_execute($stmt);
      $res = mysqli_stmt_get_result($stmt);
      $row = $res ? mysqli_fetch_assoc($res) : null;
      mysqli_stmt_close($stmt);
      return $row ? $row['sol_name'] : null;
    }
    return null;
  }
?>
</head>
<body>

<form method="POST" name="frmMain" enctype="multipart/form-data">
  <div class="w3-container" style="max-width:900px;margin:auto">
    <div class="w3-center" style="margin-top:32px">
      <img src="img/allwell_logo.png" width="240" height="70" alt="Allwell Logo">
      <h2 class="aw-header" style="margin:16px 0 0"><b>ตรวจสอบการรับประกันสินค้าออนไลน์ Allwell</b></h2>
    </div>

    <div class="w3-container w3-purple" style="margin-top:24px">
      <h5 class="w3-text-white" style="margin:8px 0">กรอกข้อมูล</h5>
    </div>

    <div class="w3-row-padding" style="margin-top:16px">
      <div class="w3-half w3-margin-bottom">
        <label for="serial_num"><b>Serial number</b> <span class="w3-text-red">*</span></label>
        <input name="serial_num" id="serial_num" class="w3-input" type="text" inputmode="latin" autocomplete="off"
               required placeholder="เช่น AWB1234567"
               pattern="[A-Za-z0-9\-_/]{4,30}" title="กรอกเป็นตัวอักษร/ตัวเลข 4–30 ตัว (รองรับ - _ /)">
        <div class="help">ระบบจะแปลงเป็นตัวพิมพ์ใหญ่ให้อัตโนมัติ</div>
      </div>

      <div class="w3-half w3-margin-bottom">
        <label for="tel_cus"><b>เบอร์ติดต่อ</b> <span class="w3-text-red">*</span></label>
        <input name="tel_cus" id="tel_cus" class="w3-input" type="tel" inputmode="tel" autocomplete="tel"
               required placeholder="เช่น 0812345678"
               pattern="0\d{8,9}" maxlength="10" title="กรอกเบอร์มือถือไทย 10 หลัก เริ่มต้นด้วย 0">
        <div class="help">กรอกเบอร์มือถือ 10 หลัก (เริ่มด้วย 0)</div>
      </div>
    </div>

    <div class="w3-center" style="margin:8px 0 24px">
      <button type="submit" name="Submit" class="aw-cta">ตรวจสอบการรับประกัน</button>
    </div>

    <div class="w3-container w3-purple" style="margin-top:24px">
      <h6 class="w3-text-white" style="margin:8px 0">รายละเอียดการรับประกัน</h6>
    </div>

<?php
 // ---------------- Main ----------------
$serial_num = isset($_POST['serial_num']) ? strtoupper(trim($_POST['serial_num'])) : '';
$tel_raw    = isset($_POST['tel_cus']) ? $_POST['tel_cus'] : '';
$tel_digits = preg_replace('/\D/', '', $tel_raw);

if ($serial_num !== '' && $tel_digits !== '') {

  // 1) หา installation + จำว่ามาจากคอนเน็กชันไหน ($installConn)
  $installConn = null;
  $rowInstall  = find_install_row($service, $serial_num, $tel_digits);
  if ($rowInstall) {
    $installConn = $service;
  } else {
    $rowInstall = find_install_row($servicenb, $serial_num, $tel_digits);
    if ($rowInstall) $installConn = $servicenb;
  }

  if (!$rowInstall) {
    echo '<div class="w3-panel w3-red aw-panel-lg">ไม่พบข้อมูลที่ตรงกับ Serial Number และเบอร์โทรนี้</div>';
  } else {
    // 2) ดึงข้อมูลสินค้า: product_id จาก stock (2 ฐาน) + sol_name จาก $conn
    $product_id = find_product_id($service, $serial_num);
    if (!$product_id) $product_id = find_product_id($servicenb, $serial_num);

    $product_name = null;
    if (!empty($product_id)) {
      $product_name = find_product_name($conn, $product_id);
    }

// วัน/phase ที่ใช้คำนวณ
$install_raw = $rowInstall['install_date']       ?? null;
$end_raw     = $rowInstall['out_insurance_date'] ?? null;
$phase_raw   = $rowInstall['warranty_phase']     ?? null;

// ถ้าใช้ parse_warranty_years() อยู่แล้ว
$years = function_exists('parse_warranty_years') ? parse_warranty_years($phase_raw) : null;

// แปลงวันที่แสดงผล (พ.ศ.)
$install_fmt = fmt_date($install_raw);
$end_fmt     = fmt_date($end_raw);

$status_line = '<span class="w3-text-amber"><b>สถานะ:</b> ไม่มีข้อมูลวันสิ้นสุดประกัน</span>';

/* ----------------- เงื่อนไขตลอดอายุการใช้งาน ----------------- */
// คงตลอดอายุการใช้งานถ้า phase = 99 (ไม่สน out_insurance_date)
if ((string)$phase_raw === '99year' || (string)$phase_raw === '99' || $years === 99) {
  $status_line = '<span class="w3-text-green"><b>สถานะ:</b> รับประกันตลอดอายุการใช้งาน</span>';
  $end_fmt     = 'ตลอดอายุการใช้งาน';

  // หากต้อง "บังคับเคลียร์วันที่ใน DB" ให้เป็นศูนย์วันที่จริงๆ ให้เปิดบรรทัดด้านล่าง (ทางเลือก)
  // if (!empty($installConn)) { update_out_date($installConn, $serial_num, $tel_digits, '0000-00-00'); }
}
/* ----------------- เงื่อนไขคำนวณ/แสดงผลตามปกติ ----------------- */
else if (is_zero_date($end_raw) && $years !== null && $years > 0) {
  // ไม่มี out_insurance_date แต่มี phase (หน่วยปี รองรับ "2year" หรือ "2")
  $computed_end = compute_end_date_by_years($install_raw, $years);
  if ($computed_end) {
    if (!empty($installConn)) {
      update_out_date($installConn, $serial_num, $tel_digits, $computed_end);
    }
    $end_raw = $computed_end;
    $end_fmt = fmt_date($end_raw);

    $today = new DateTime('today');
    $end   = new DateTime($end_raw);
    if ($end >= $today) {
      $daysLeft   = $today->diff($end)->days;
      $status_line = '<span class="w3-text-green"><b>สถานะ:</b> ยังอยู่ในประกัน (เหลือ ' . number_format($daysLeft) . ' วัน)</span>';
    } else {
      $daysOver   = $end->diff($today)->days;
      $status_line = '<span class="w3-text-red"><b>สถานะ:</b> หมดประกันแล้ว (เกินมา ' . number_format($daysOver) . ' วัน)</span>';
    }
  } else {
    $status_line = '<span class="w3-text-amber"><b>สถานะ:</b> ไม่พบวันติดตั้ง จึงไม่สามารถคำนวณวันสิ้นสุดได้</span>';
    $end_fmt     = '-';
  }
}
else if (!is_zero_date($end_raw)) {
  try {
    $today = new DateTime('today');
    $end   = new DateTime($end_raw);
    if ($end >= $today) {
      $daysLeft   = $today->diff($end)->days;
      $status_line = '<span class="w3-text-green"><b>สถานะ:</b> ยังอยู่ในประกัน (เหลือ ' . number_format($daysLeft) . ' วัน)</span>';
    } else {
      $daysOver   = $end->diff($today)->days;
      $status_line = '<span class="w3-text-red"><b>สถานะ:</b> หมดประกันแล้ว (เกินมา ' . number_format($daysOver) . ' วัน)</span>';
    }
  } catch (Exception $e) {
    $status_line = '<span class="w3-text-amber"><b>สถานะ:</b> ไม่สามารถอ่านวันสิ้นสุดประกันได้</span>';
  }
} else {
  $status_line = '<span class="w3-text-amber"><b>สถานะ:</b> ไม่มีข้อมูลวันสิ้นสุดประกัน</span>';
  $end_fmt     = '-';
}

    // 4) แสดงผล
    echo '<div class="w3-panel aw-panel-lg">';

    echo '<b>Serial number : </b>'
       . htmlspecialchars($rowInstall['product_sn'], ENT_QUOTES, 'UTF-8')
       . '<br>';

    if (!empty($product_name)) {
      echo '<b>สินค้า : </b>'
         . htmlspecialchars($product_name, ENT_QUOTES, 'UTF-8')
         . '<br><br>';
    }

    echo '<b>ชื่อลูกค้า : </b>'
       . htmlspecialchars(mask_name($rowInstall['install_cus_name']), ENT_QUOTES, 'UTF-8')
       . '<br>';

    echo '<b>เริ่มประกัน: </b>'
       . htmlspecialchars($install_fmt, ENT_QUOTES, 'UTF-8')
       . '<br>';

    echo '<b>สิ้นสุดประกัน: </b>'
       . htmlspecialchars($end_fmt, ENT_QUOTES, 'UTF-8')
       . '<br>';

    //echo $status_line;

    echo '</div>';
  }
}
	  ?>

    <?php //include('foot.php'); ?>
  </div>
</form>

<script>
  const form = document.forms['frmMain'];
  form.addEventListener('submit', function() {
    const btn = form.querySelector('button[type="submit"]');
    if (btn) { btn.disabled = true; btn.textContent = 'กำลังตรวจสอบ...'; }
  });
</script>

</body>
</html>
