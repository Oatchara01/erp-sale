<?php include('head.php'); ?>
<body>
<?php
include "dbconnect.php";      // so__main / hos__so -> $conn
include "dbconnect_cs.php";   // tb_research        -> $com1
date_default_timezone_set("Asia/Bangkok");

/* =========================
  Utils
========================= */
function h($v){ return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }

function okScore($v){
  if ($v === null) return 0;
  if ($v === '') return 0;
  if (!is_numeric($v)) return 0;
  return (float)$v;
}
function sec1_ok($r){
  return okScore($r['sale_neat'] ?? 0) >= 1
      && okScore($r['sale_data'] ?? 0) >= 1
      && okScore($r['sale_3']    ?? 0) >= 1;
}
function sec2_ok($r){
  return okScore($r['product_good'] ?? 0) >= 1
      && okScore($r['product_link'] ?? 0) >= 1;
}
function sec3_ok($r){
  return okScore($r['cs_neat']    ?? 0) >= 1
      && okScore($r['cs_explain'] ?? 0) >= 1
      && okScore($r['cs_3']       ?? 0) >= 1;
}
function sec4_ok($r){
  return okScore($r['cus_1'] ?? 0) >= 1;
}
function all_ok($r){
  if (empty($r)) return false; // ไม่มี record tb_research = ค้างทำ
  return sec1_ok($r) && sec2_ok($r) && sec3_ok($r) && sec4_ok($r);
}

$badge = function($ok){
  return $ok ? "<img src='img/success.gif' width='15' height='15' border='0' />"
             : "<img src='img/false.png' width='15' height='15' border='0' />";
};

/* =========================
  GET Params
========================= */
$Keyword    = isset($_GET['Keyword']) ? trim($_GET['Keyword']) : '';
$start_date = isset($_GET['start_date']) ? trim($_GET['start_date']) : '';
$end_date   = isset($_GET['end_date']) ? trim($_GET['end_date']) : '';
// NOTE: sale_code ใช้เป็น "ตัวเลือกแหล่ง/เขต" (HC/HOS) ไม่ใช่ sale_code ใน DB
$sale_code  = isset($_GET['sale_code']) ? trim($_GET['sale_code']) : ''; // ''|HC|HOS
$status_f   = isset($_GET['status_f']) ? trim($_GET['status_f']) : '';   // ''|done|pending

// ✅ ถ้าไม่เลือกเขต (รวมทั้ง 2 ส่วน) ต้องกรอกวันที่อย่างน้อย 1 ช่องก่อน
/*if($sale_code === ''){
  $hasFilter = (($start_date !== '') || ($end_date !== ''));
} else {
  $hasFilter = (
    $Keyword !== '' ||
    $start_date !== '' ||
    $end_date !== '' ||
    $status_f !== '' ||
    $sale_code !== ''
  );
}*/
	
if($sale_code === ''){
  $hasFilter = (
    $Keyword !== '' ||
    $start_date !== '' ||
    $end_date !== ''
  );
} else {
  $hasFilter = (
    $Keyword !== '' ||
    $start_date !== '' ||
    $end_date !== '' ||
    $status_f !== '' ||
    $sale_code !== ''
  );
}	

$Per_Page = 20;
$Page = isset($_GET['Page']) ? (int)$_GET['Page'] : 1;
if($Page <= 0) $Page = 1;
$offset_need = ($Page - 1) * $Per_Page;

/* =========================
  tb_research MAP (red_id => row)
========================= */
function fetchResearchMap($com1, $refIds){
  $map = [];
  if(empty($refIds)) return $map;

  $refIds = array_values(array_unique(array_filter($refIds)));
  if(empty($refIds)) return $map;

  $escaped = array_map(function($x) use ($com1){
    return "'" . mysqli_real_escape_string($com1, $x) . "'";
  }, $refIds);

  $in = implode(",", $escaped);

  $sql = "SELECT red_id, sale_neat, sale_data, sale_3, product_good, product_link, cs_neat, cs_explain, cs_3, cus_1, delivery_id
          FROM tb_research
          WHERE red_id IN ($in)";
  $q = mysqli_query($com1, $sql) or die("Error Query [".$sql."]");
  while($r = mysqli_fetch_assoc($q)){
    $map[$r['red_id']] = $r;
  }
  return $map;
}

/* =========================
  tb_delivery MAP (delivery_id => delivery_name)
  ✅ กัน N+1 query ตอนแสดงตาราง
========================= */
function fetchDeliveryMap($conn, $deliveryIds){
  $map = [];
  if(empty($deliveryIds)) return $map;

  $deliveryIds = array_values(array_unique(array_filter($deliveryIds)));
  if(empty($deliveryIds)) return $map;

  $escaped = array_map(function($x) use ($conn){
    return "'" . mysqli_real_escape_string($conn, $x) . "'";
  }, $deliveryIds);

  $in = implode(",", $escaped);

  $sql = "SELECT delivery_id, delivery_name FROM tb_delivery WHERE delivery_id IN ($in)";
  $q = mysqli_query($conn, $sql) or die("Error Query [".$sql."]");
  while($r = mysqli_fetch_assoc($q)){
    $map[$r['delivery_id']] = $r['delivery_name'];
  }
  return $map;
}

/* =========================
  WHERE builder per source
========================= */
function buildWhereHC($conn, $Keyword, $start_date, $end_date){
  $where = [];
  $where[] = "reseach_kk = '1'";

  // เงื่อนไข SOL (เดิม)
  $sols = ['SOL1','SOL2','SOL3','SOL4','SOL5','SOL6','SOL7','SOL8','SOL99'];
  $sols_sql = implode(",", array_map(fn($x)=>"'".mysqli_real_escape_string($conn,$x)."'", $sols));
  $where[] = "employee_name IN ($sols_sql)";

  if ($start_date !== '') {
    $sd = mysqli_real_escape_string($conn, $start_date);
    $where[] = "doc_release_date >= '{$sd}'";
  }
  if ($end_date !== '') {
    $ed = mysqli_real_escape_string($conn, $end_date);
    $where[] = "doc_release_date <= '{$ed}'";
  }
  if ($Keyword !== '') {
    $kw = mysqli_real_escape_string($conn, $Keyword);
    $where[] = "(
      delivery_contact LIKE '%{$kw}%'
      OR customer_name LIKE '%{$kw}%'
      OR billing_name  LIKE '%{$kw}%'
      OR tel           LIKE '%{$kw}%'
      OR doc_no        LIKE '%{$kw}%'
      OR ref_id        LIKE '%{$kw}%'
    )";
  }
  return "WHERE " . implode(" AND ", $where);
}

// ✅ HOS: เพิ่ม rule พิเศษ
// - ใน hos__so มี sale_code='S33' ซึ่งเป็น Home Care
// - ถ้าเลือก HC -> เอาเฉพาะ sale_code='S33' (จาก hos__so)
// - ถ้าเลือก HOS -> เอาเฉพาะ sale_code<>'S33' (จาก hos__so)
// - ถ้าไม่เลือก -> เอาทั้งหมด (จาก hos__so)
function buildWhereHOS($conn, $Keyword, $start_date, $end_date, $selector){ // $selector = ''|HC|HOS
  $where = [];
  $where[] = "reseach_kk = '1'";
  $where[] = "sale_code NOT IN ('S31','S32','MM1')";

  if ($start_date !== '') {
    $sd = mysqli_real_escape_string($conn, $start_date);
    $where[] = "iv_date >= '{$sd}'";
  }
  if ($end_date !== '') {
    $ed = mysqli_real_escape_string($conn, $end_date);
    $where[] = "iv_date <= '{$ed}'";
  }
  if ($Keyword !== '') {
    $kw = mysqli_real_escape_string($conn, $Keyword);
    $where[] = "(
      ref_id   LIKE '%{$kw}%'
      OR iv_no LIKE '%{$kw}%'
      OR bill_name LIKE '%{$kw}%'
      OR job_no LIKE '%{$kw}%'
    )";
  }

  // ✅ ตัวกรองพิเศษ S33
  if($selector === 'HC'){
    $where[] = "sale_code = 'S33'";
  } else if($selector === 'HOS'){
    $where[] = "sale_code <> 'S33'";
  }

  return "WHERE " . implode(" AND ", $where);
}

/* =========================
  Base SQL (unified columns via alias)
========================= */
function baseSqlHC($conn, $Keyword, $start_date, $end_date){
  $where = buildWhereHC($conn, $Keyword, $start_date, $end_date);
  return "
    SELECT
      'Home Care' AS src,
      ref_id,
      register_date,
      doc_no,
      doc_release_date,
      billing_name,
      delivery_contact,
      job_id,
      approve_complete,
      cancel_ckk,
      bill_id,
      employee_name,
      add_by,
      main_id AS sort_id
    FROM so__main
    {$where}
  ";
}

function baseSqlHOS($conn, $Keyword, $start_date, $end_date, $selector){
  $where = buildWhereHOS($conn, $Keyword, $start_date, $end_date, $selector);
  return "
    SELECT
      CASE WHEN sale_code='S33' THEN 'Home Care' ELSE 'Hospital' END AS src,
      ref_id,
      iv_date AS register_date,
      iv_no   AS doc_no,
      iv_date AS doc_release_date,
      bill_name AS billing_name,
      bill_name AS delivery_contact,
      job_no  AS job_id,
      status_doc AS approve_complete,
      '0' AS cancel_ckk,
      bill_id,
      sale_code AS employee_name,   /* แสดงเขต/โค้ดขายของ hos */
      add_by,
      id AS sort_id
    FROM hos__so
    {$where}
  ";
}

function baseSqlUnion($conn, $Keyword, $start_date, $end_date, $selector){ // selector = ''|HC|HOS
  // ✅ mapping:
  // - HC  = so__main (เดิม) + hos__so เฉพาะ sale_code='S33'
  // - HOS = hos__so เฉพาะ sale_code<>'S33'
  // - ''  = so__main + hos__so ทั้งหมด (ต้องมีวัน)
  $hc  = baseSqlHC($conn, $Keyword, $start_date, $end_date);
  $hos = baseSqlHOS($conn, $Keyword, $start_date, $end_date, $selector);

  if($selector === 'HC'){
    return "({$hc}) UNION ALL ({$hos})";
  }
  if($selector === 'HOS'){
    return $hos;
  }
  return "({$hc}) UNION ALL ({$hos})";
}

/* =========================
  Defaults
========================= */
$total_all = 0;
$total_done = 0;
$total_pending = 0;

$Num_Rows = 0;
$Num_Pages = 1;
$Prev_Page = 0;
$Next_Page = 0;
$rows_page = [];
$deliveryMap = []; // ✅ ไว้ map delivery_name ตอนแสดงผล

/* =========================
  Run Query only when hasFilter
========================= */
if($hasFilter){

  $baseSql = baseSqlUnion($conn, $Keyword, $start_date, $end_date, $sale_code);

  // A) summary
  $sqlRefAll = "SELECT ref_id FROM ({$baseSql}) t";
  $qRefAll = mysqli_query($conn, $sqlRefAll) or die("Error Query [".$sqlRefAll."]");

  $chunkSize = 500;
  $buffer = [];

  while($row = mysqli_fetch_assoc($qRefAll)){
    $buffer[] = $row['ref_id'];
    if(count($buffer) >= $chunkSize){
      $map = fetchResearchMap($com1, $buffer);
      foreach($buffer as $rid){
        $total_all++;
        $r = $map[$rid] ?? [];
        if(all_ok($r)) $total_done++; else $total_pending++;
      }
      $buffer = [];
    }
  }
  if(count($buffer) > 0){
    $map = fetchResearchMap($com1, $buffer);
    foreach($buffer as $rid){
      $total_all++;
      $r = $map[$rid] ?? [];
      if(all_ok($r)) $total_done++; else $total_pending++;
    }
  }

  // B) rows count by status filter
  if($status_f === 'done') $Num_Rows = $total_done;
  else if($status_f === 'pending') $Num_Rows = $total_pending;
  else $Num_Rows = $total_all;

  $Num_Pages = ($Num_Rows <= $Per_Page) ? 1 : (int)ceil($Num_Rows / $Per_Page);
  $Prev_Page = $Page - 1;
  $Next_Page = $Page + 1;

  // C) fetch rows for page
  $skipped = 0;
  $scan_offset = 0;
  $batch = 200;

  while(count($rows_page) < $Per_Page){
    $sqlBatch = "SELECT * FROM ({$baseSql}) t ORDER BY doc_release_date DESC, sort_id DESC LIMIT {$scan_offset}, {$batch}";
    $qBatch = mysqli_query($conn, $sqlBatch) or die("Error Query [".$sqlBatch."]");

    $batchRows = [];
    while($rr = mysqli_fetch_assoc($qBatch)){
      $batchRows[] = $rr;
    }
    if(count($batchRows) === 0) break;

    $refIds = array_map(fn($x) => $x['ref_id'], $batchRows);
    $researchMap = fetchResearchMap($com1, $refIds);

    foreach($batchRows as $s){
      $rid = $s['ref_id'];
      $r = $researchMap[$rid] ?? [];
      $isDone = all_ok($r);

      if($status_f === 'done' && !$isDone) continue;
      if($status_f === 'pending' && $isDone) continue;

      $s['_sec1'] = sec1_ok($r) ? 1 : 0;
      $s['_sec2'] = sec2_ok($r) ? 1 : 0;
      $s['_sec3'] = sec3_ok($r) ? 1 : 0;
      $s['_sec4'] = sec4_ok($r) ? 1 : 0;
      $s['_isDone'] = $isDone ? 1 : 0;

      // ✅ FIX: แนบ delivery_id มาด้วย (กันใช้ $r ผิด scope ตอนแสดงผล)
      $s['_delivery_id'] = $r['delivery_id'] ?? '';

      if($skipped < $offset_need){
        $skipped++;
        continue;
      }

      $rows_page[] = $s;
      if(count($rows_page) >= $Per_Page) break;
    }

    $scan_offset += $batch;
    if($scan_offset > 500000) break;
  }

  // ✅ ดึงชื่อขนส่งทีเดียวสำหรับเฉพาะแถวที่จะแสดง (เร็วกว่า query ทีละแถว)
  $deliveryIds = [];
  foreach($rows_page as $rp){
    if(!empty($rp['_delivery_id'])) $deliveryIds[] = $rp['_delivery_id'];
  }
  $deliveryMap = fetchDeliveryMap($conn, $deliveryIds);

  // ✅ แนบชื่อขนส่งเข้าไปใน rows_page
  foreach($rows_page as $k => $rp){
    $did = $rp['_delivery_id'] ?? '';
    $rows_page[$k]['_delivery_name'] = ($did !== '' && isset($deliveryMap[$did])) ? $deliveryMap[$did] : '';
  }
}
?>

<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
  <div class="w3-white">
    <div class="w3-container w3-padding-large">
      <div class="w3-panel w3-light-grey"><h3>Status แบบสอบถามทั้งหมด</h3></div>

      <div class="w3-bar w3-quarter">
        วันที่ :
        <input name="start_date" class="w3-input" style="width:90%;" type="date" id="start_date" value="<?=h($start_date)?>">
      </div>
      <div class="w3-bar w3-quarter">
        ถึง :
        <input name="end_date" class="w3-input" style="width:90%;" type="date" id="end_date" value="<?=h($end_date)?>">
      </div>

      <div class="w3-bar w3-quarter">
        เขตการขาย
        <select name="sale_code" id="sale_code" style="width:280px" class="w3-input">
          <option value="" <?=($sale_code===''?'selected':'')?> >**Please Select**</option>
          <option value="HC" <?=($sale_code==='HC'?'selected':'')?> >Home Care</option>
          <option value="HOS" <?=($sale_code==='HOS'?'selected':'')?> >Hospital</option>
        </select>
        <div style="font-size:12px;color:#555;margin-top:4px;"></div>
      </div>

      <div class="w3-bar w3-quarter">
        ค้นหา :
        <input name="Keyword" class="w3-input" style="width:90%;" type="text" id="Keyword" value="<?=h($Keyword)?>">
      </div>

      <div class="w3-bar w3-quarter">
        สถานะ :
        <select name="status_f" class="w3-input" style="width:90%;">
          <option value="" <?=($status_f===''?'selected':'')?> >ทั้งหมด</option>
          <option value="done" <?=($status_f==='done'?'selected':'')?> >ทำครบแล้ว</option>
          <option value="pending" <?=($status_f==='pending'?'selected':'')?> >ค้างทำ</option>
        </select>
      </div>

      <div class="w3-bar w3-quarter w3-padding-xsmall">
        <input type="submit" class="w3-button w3-teal" value="Search">
      </div>
    </div>

<div class="w3-container">
  <div class="w3-panel w3-pale-yellow">
    <?php if(!$hasFilter){ ?>
      <b>
        <?php if($sale_code===''){ ?>
          ยังไม่มีเงื่อนไขค้นหา
        <?php } else { ?>
          กรุณากรอกเงื่อนไขอย่างน้อย 1 ช่อง (วันที่/ค้นหา/สถานะ) แล้วกด Search
        <?php } ?>
      </b>
    <?php } else { ?>
      <b>สรุปการทำแบบสอบถาม:</b>
      ทั้งหมด <b><?= (int)$total_all ?></b> |
      ทำครบแล้ว <b style="color:green;"><?= (int)$total_done ?></b> |
      ค้างทำ <b style="color:#c00;"><?= (int)$total_pending ?></b>
    <?php } ?>
  </div>

  <table border="1" width="100%" class="w3-table">
    <thead class="w3-gray">
      <th width="8%">ฝ่าย</th>
      <th width="10%">เลขที่อ้างอิง</th>
      <th width="10%">วันที่ออกเอกสาร</th>
      <th width="12%">เลขที่เอกสาร</th>
      <th width="20%">ชื่อลูกค้า</th>
      <th width="10%">เลขลงงาน CS</th>
      <th width="18%">รายการสินค้า</th>
      <th width="10%">เขตการขาย</th>
      <th width="20%">การทำแบบสอบถาม</th>
      <th width="10%">ขนส่งนอก</th>
    </thead>

    <tbody>
    <?php
    if(!$hasFilter){
      echo "<tr><td colspan='15' class='w3-center'>ยังไม่มีเงื่อนไขค้นหา</td></tr>";
    } else if(empty($rows_page)){
      echo "<tr><td colspan='15' class='w3-center'>ไม่พบรายการ</td></tr>";
    } else {
      foreach($rows_page as $objResult){

        $s1 = (int)($objResult['_sec1'] ?? 0);
        $s2 = (int)($objResult['_sec2'] ?? 0);
        $s3 = (int)($objResult['_sec3'] ?? 0);
        $s4 = (int)($objResult['_sec4'] ?? 0);
        $isDone = (int)($objResult['_isDone'] ?? 0);

        // รายการสินค้า: แยกตารางตาม src
        $isFromHos = ($objResult['employee_name'] !== '' && $objResult['doc_no'] !== '' && $objResult['job_id'] !== '' && $objResult['src'] !== 'Home Care')
                     || ($objResult['src'] === 'Hospital')
                     || ($objResult['src'] === 'Home Care' && preg_match('/^S33$/', $objResult['employee_name']));

        if($isFromHos){
          $subTable  = "hos__subso";
          $refField  = "ref_idd";     // <-- แก้ได้
          $prodField = "product_ID";  // <-- แก้ได้
        } else {
          $subTable  = "so__submain";
          $refField  = "ref_idd";
          $prodField = "product_ID";
        }

        $strSQL1 = "
          SELECT sol_name
          FROM ({$subTable} LEFT JOIN tb_product ON {$subTable}.{$prodField} = tb_product.product_id)
          WHERE {$refField} = '".mysqli_real_escape_string($conn, $objResult["ref_id"])."'
        ";
        $objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");

        // ✅ FIX: ใช้ชื่อขนส่งที่ map มาตั้งแต่ก่อน loop (ไม่ใช้ $r)
        $deliveryName = $objResult['_delivery_name'] ?? '';
    ?>
      <tr>
        <td><?=h($objResult["src"])?></td>
        <td><?=h($objResult["ref_id"])?></td>
        <td><?php echo DateThai($objResult["register_date"]); ?></td>

        <td>
          <a href="https://cs.allwellcenter.com/report_research1369.php?ref_id=<?=urlencode($objResult["ref_id"])?>" target="_blank">
            <?=h($objResult["doc_no"])?></a>
        </td>

        <td><?=h($objResult["billing_name"])?></td>

        <td>
          <a href="https://cs.allwellcenter.com/7112018_new.php?running=<?=urlencode($objResult["job_id"])?>" target="_blank">
            <?=h($objResult["job_id"])?></a>
        </td>

        <td>
          <div align="left">
            <?php
            while($objResult1 = mysqli_fetch_array($objQuery1)){
              echo h($objResult1["sol_name"])."<br />";
            }
            ?>
          </div>
        </td>

        <td><?=h($objResult["employee_name"])?></td>

        <td>
          <div style="display:flex; flex-direction:column; gap:6px; align-items:flex-start;">
            <div style="font-weight:bold; <?= $isDone ? 'color:green;' : 'color:#c00;' ?>">
              <?= $isDone ? 'ทำครบแล้ว' : 'ค้างทำ' ?>
            </div>

            <div>ส่วนที่ 1: <?=$badge($s1)?></div>
            <div>ส่วนที่ 2: <?=$badge($s2)?></div>
            <div>ส่วนที่ 3: <?=$badge($s3)?></div>
            <div>ส่วนที่ 4: <?=$badge($s4)?></div>
          </div>
        </td>

        <td>
          <?=h($deliveryName)?>
          <a href="javascript:void(0);" onclick="openTrackModal('<?=h($objResult['ref_id'])?>')">
            <img src="img/create.png" width="23" height="23" border="0" />
          </a>
        </td>

      </tr>
    <?php
      }
    }
    ?>
    </tbody>
  </table>

  <?php if($hasFilter){ ?>
  <div class="w3-panel">
    <strong>พบทั้งหมด</strong> <?= (int)$Num_Rows; ?>
    <strong>รายการ : จำนวน</strong> <?= (int)$Num_Pages; ?>
    <strong>หน้า :</strong>
    <?php
    $qs = "Keyword=".urlencode($Keyword)
        ."&start_date=".$start_date
        ."&end_date=".$end_date
        ."&sale_code=".$sale_code
        ."&status_f=".$status_f;

    if($Prev_Page > 0){
      echo " <a href='$_SERVER[SCRIPT_NAME]?Page=$Prev_Page&$qs'><span class='style40'><< Back</span></a> ";
    }

    for($i=1; $i<=$Num_Pages; $i++){
      if($i != $Page){
        echo "[ <a href='$_SERVER[SCRIPT_NAME]?Page=$i&$qs'><span class='style40'>$i</span></a> ]";
      } else {
        echo "<b> $i </b>";
      }
    }

    if($Page < $Num_Pages){
      echo " <a href ='$_SERVER[SCRIPT_NAME]?Page=$Next_Page&$qs'><span class='style40'>Next>></span></a> ";
    }
    ?>
    <br>
  </div>
  <?php } ?>

</div>
</form>

<div id="cr_bar"><?php include "foot.php"; ?></div>

<style>
  /* Pastel Purple Theme */
  .pp-header{
    background:#b79ad8; /* pastel purple */
    color:#fff;
  }
  .pp-btn{
    background:#a98ad2;
    color:#fff;
  }
  .pp-btn:hover{ background:#9a78c9; }
  .pp-chip{
    background:#f3ecfb;
    border:1px solid #e4d6f5;
    border-radius:10px;
    padding:10px 12px;
  }
  .pp-label{ font-weight:600; color:#4b2a6a; }
  .pp-help{ color:#6b4c86; font-size:12px; }
</style>

<!-- TRACK MODAL -->
<div id="trackModal" class="w3-modal">
  <div class="w3-modal-content w3-animate-top" style="max-width:520px; border-radius:16px; overflow:hidden;">
    <header class="w3-container pp-header">
      <span onclick="closeTrackModal()" class="w3-button w3-display-topright" style="color:#fff;">&times;</span>
      <h4 style="margin:12px 0;">บันทึกข้อมูลขนส่ง</h4>
    </header>

    <div class="w3-container w3-padding" style="background:#faf7ff;">
      <form method="POST" action="research_tract_save.php" id="trackForm">
        <input type="hidden" name="ref_id" id="track_ref_id" value="">

        <div class="pp-chip" style="margin-bottom:12px;">
          <label class="pp-label" style="display:flex; align-items:center; gap:10px; margin:0;">
            <input class="w3-check" type="checkbox" name="out_ckk" id="out_ckk" value="1"
                   onchange="toggleCarrierDropdown(this.checked)">
            ขนส่งนอก
          </label>
          <div class="pp-help" style="margin-top:6px;"></div>
        </div>

        <div class="pp-chip">
          <label class="pp-label">ชื่อขนส่งนอก</label>
          <select class="w3-select" name="delivery_id" id="delivery_id" disabled>
            <option value="" selected>-- เลือกขนส่งนอก --</option>
            <?php
              $strSQL5 = "SELECT * FROM tb_delivery WHERE close_ckk='0' ORDER BY delivery_name ASC";
              $objQuery5 = mysqli_query($conn, $strSQL5);
              if(!$objQuery5){
                echo "<option value=''>DB Error</option>";
              }else{
                while($objResuut5 = mysqli_fetch_assoc($objQuery5)){
                  $val = $objResuut5['delivery_id'];
                  $txt = $objResuut5['delivery_name']." ".$objResuut5['drop_place'];
                  echo "<option value='".h($val)."'>".h($txt)."</option>";
                }
              }
            ?>
          </select>

          <div id="trackLoading" class="pp-help" style="margin-top:6px; display:none;">
            กำลังโหลดข้อมูล...
          </div>
        </div>

        <div class="w3-right" style="margin:14px 0 6px; display:flex; gap:8px;">
          <button type="button" class="w3-button w3-light-grey" style="border-radius:10px;" onclick="closeTrackModal()">ยกเลิก</button>
          <button type="submit" class="w3-button pp-btn" style="border-radius:10px;">บันทึก</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function openTrackModal(refId){
  document.getElementById('track_ref_id').value = refId;

  const cb = document.getElementById('out_ckk');
  const dd = document.getElementById('delivery_id');
  const loading = document.getElementById('trackLoading');

  // reset ก่อน
  cb.checked = false;
  dd.value = '';
  dd.disabled = true;
  dd.required = false;

  document.getElementById('trackModal').style.display = 'block';

  // โหลดค่าเดิมจาก DB
  loading.style.display = 'block';

  fetch('research_tract_get.php?ref_id=' + encodeURIComponent(refId))
    .then(r => r.json())
    .then(data => {
      // data = {ok:1,out_ckk:0/1,delivery_id:""}
      loading.style.display = 'none';

      if(!data || data.ok != 1) return;

      const isOut = String(data.out_ckk) === '1';
      cb.checked = isOut;
      toggleCarrierDropdown(isOut);

      if(data.delivery_id){
        dd.value = String(data.delivery_id);
      }
    })
    .catch(() => {
      loading.style.display = 'none';
    });
}

function closeTrackModal(){
  document.getElementById('trackModal').style.display = 'none';
}

function toggleCarrierDropdown(checked){
  const dd = document.getElementById('delivery_id');
  dd.disabled = !checked;
  dd.required = checked;
  if(!checked) dd.value = '';
}
</script>

</body>
</html>