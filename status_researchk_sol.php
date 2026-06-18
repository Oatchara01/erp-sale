<?php include('head.php'); ?>
<body>

<?php
include "dbconnect.php";      // DB ก้อนที่มี so__main  -> $conn
include "dbconnect_cs.php";   // DB ก้อนที่มี tb_research -> $com1
date_default_timezone_set("Asia/Bangkok");

/* =========================
  Utils
========================= */
function h($v){ return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }

function sec1_ok($r){
  return (int)($r['sale_neat'] ?? 0) >= 1 && (int)($r['sale_data'] ?? 0) >= 1 && (int)($r['sale_3'] ?? 0) >= 1;
}
function sec2_ok($r){
  return (int)($r['product_good'] ?? 0) >= 1 && (int)($r['product_link'] ?? 0) >= 1;
}
function sec3_ok($r){
  return (int)($r['cs_neat'] ?? 0) >= 1 && (int)($r['cs_explain'] ?? 0) >= 1 && (int)($r['cs_3'] ?? 0) >= 1;
}
function sec4_ok($r){
  return (int)($r['cus_1'] ?? 0) >= 1;
}
function all_ok($r){
  return sec1_ok($r) && sec2_ok($r) && sec3_ok($r) && sec4_ok($r);
}

$badge = function($ok){
  return $ok ? "<span class='w3-tag w3-green'>ครบ</span>" : "<span class='w3-tag w3-red'>ค้าง</span>";
};

/* =========================
  GET Params
========================= */
$Keyword    = isset($_GET['Keyword']) ? trim($_GET['Keyword']) : '';
$start_date = isset($_GET['start_date']) ? trim($_GET['start_date']) : '';
$end_date   = isset($_GET['end_date']) ? trim($_GET['end_date']) : '';
$sale_code  = isset($_GET['sale_code']) ? trim($_GET['sale_code']) : '';

$Per_Page = 20;
$Page = isset($_GET['Page']) ? (int)$_GET['Page'] : 1;
if($Page <= 0) $Page = 1;
$offset_need = ($Page - 1) * $Per_Page;

/* =========================
  Build WHERE for so__main (DB $conn)
========================= */
$where = [];
$where[] = "reseach_kk = '1'";
$where[] = "doc_release_date >= '2026-01-01'";	
$sols = ['SOL1','SOL2','SOL3','SOL4','SOL5','SOL99'];
$sols_sql = implode(",", array_map(fn($x)=>"'".mysqli_real_escape_string($conn,$x)."'", $sols));
$where[] = "employee_name IN ($sols_sql)";	

if ($start_date !== '') {
  $sd = mysqli_real_escape_string($conn, $start_date);
  $where[] = "register_date >= '{$sd}'";
}
if ($end_date !== '') {
  $ed = mysqli_real_escape_string($conn, $end_date);
  $where[] = "register_date <= '{$ed}'";
}
if ($sale_code !== '') {
  $sc = mysqli_real_escape_string($conn, $sale_code);
  $where[] = "employee_name = '{$sc}'";
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
$where_sql = "WHERE " . implode(" AND ", $where);

/* =========================
  Helper: ดึง tb_research เป็น MAP (red_id => row) จาก $com1
========================= */
function fetchResearchMap($com1, $refIds){
  $map = [];
  if(empty($refIds)) return $map;

  // unique + safe
  $refIds = array_values(array_unique(array_filter($refIds)));
  if(empty($refIds)) return $map;

  $escaped = array_map(function($x) use ($com1){
    return "'" . mysqli_real_escape_string($com1, $x) . "'";
  }, $refIds);

  $in = implode(",", $escaped);

  $sql = "SELECT red_id, sale_neat, sale_data, sale_3, product_good, product_link, cs_neat, cs_explain, cs_3, cus_1
          FROM tb_research
          WHERE red_id IN ($in)";
  $q = mysqli_query($com1, $sql) or die("Error Query [".$sql."]");
  while($r = mysqli_fetch_assoc($q)){
    $map[$r['red_id']] = $r;
  }
  return $map;
}

/* =========================
  1) หา "pending ทั้งหมด" เพื่อใช้ทำ pagination
  - ดึง ref_id ทั้งหมดจาก so__main ตาม filter
  - ดึง tb_research แบบ IN(...) เป็นชุดๆ
  - pending = (ไม่มี record) หรือ (ยังไม่ครบ)
========================= */
$sqlRefAll = "SELECT ref_id FROM so__main {$where_sql}";
$qRefAll = mysqli_query($conn, $sqlRefAll) or die("Error Query [".$sqlRefAll."]");

$pending_total = 0;
$chunkSize = 500;
$buffer = [];

while($row = mysqli_fetch_assoc($qRefAll)){
  $buffer[] = $row['ref_id'];
  if(count($buffer) >= $chunkSize){
    $map = fetchResearchMap($com1, $buffer);
    foreach($buffer as $rid){
      $r = $map[$rid] ?? [];      // ไม่มี record = pending
      if(!all_ok($r)) $pending_total++;
    }
    $buffer = [];
  }
}
if(count($buffer) > 0){
  $map = fetchResearchMap($com1, $buffer);
  foreach($buffer as $rid){
    $r = $map[$rid] ?? [];
    if(!all_ok($r)) $pending_total++;
  }
}

$Num_Rows = $pending_total;
$Num_Pages = ($Num_Rows <= $Per_Page) ? 1 : (int)ceil($Num_Rows / $Per_Page);
$Prev_Page = $Page - 1;
$Next_Page = $Page + 1;

/* =========================
  2) ดึงข้อมูลหน้า Page เฉพาะ "ค้าง" (สำคัญ)
  - ทำให้ "ถ้าทำครบแล้ว ไม่ต้องแสดงแถว"
========================= */
$rows_page = [];
$skipped_pending = 0;
$scan_offset = 0;
$batch = 200; // ดึง so__main ทีละ 200 แถวไปกรอง

while(count($rows_page) < $Per_Page){
  $sqlBatch = "SELECT * FROM so__main {$where_sql} ORDER BY main_id DESC LIMIT {$scan_offset}, {$batch}";
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

    // ✅ เงื่อนไขตามที่ขอ: ทำครบแล้วไม่ต้องแสดงแถว
    if(all_ok($r)) continue;

    // ทำ badge รายหมวด
    $s['_sec1'] = sec1_ok($r) ? 1 : 0;
    $s['_sec2'] = sec2_ok($r) ? 1 : 0;
    $s['_sec3'] = sec3_ok($r) ? 1 : 0;
    $s['_sec4'] = sec4_ok($r) ? 1 : 0;

    // paginate บนเฉพาะ pending
    if($skipped_pending < $offset_need){
      $skipped_pending++;
      continue;
    }

    $rows_page[] = $s;
    if(count($rows_page) >= $Per_Page) break;
  }

  $scan_offset += $batch;
  if($scan_offset > 500000) break; // กันหลุด loop แบบสุดโต่ง
}
?>

<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
  <div class="w3-white">
    <div class="w3-container w3-padding-large">
      <div class="w3-panel w3-light-grey"><h3>Status ค้างทำแบบสอบถาม</h3></div>

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
          <option value="">**Please Select**</option>
          <?php
          $strSQL5 = "SELECT * FROM tb_team_ss3 WHERE sale_code LIKE '%SOL%' ORDER BY sale_code ASC";
          $objQuery5 = mysqli_query($com,$strSQL5);
          while($objResuut5 = mysqli_fetch_array($objQuery5)){
            $val = $objResuut5["sale_code"];
            $txt = $objResuut5["sale_code"]." - ".$objResuut5["sale_name"];
            $selected = ($sale_code === $val) ? 'selected' : '';
            echo "<option value=\"".h($val)."\" {$selected}>".h($txt)."</option>";
          }
          ?>
        </select>
      </div>

      <div class="w3-bar w3-quarter">
        ค้นหา :
        <input name="Keyword" class="w3-input" style="width:90%;" type="text" id="Keyword" value="<?=h($Keyword)?>">
      </div>

      <div class="w3-bar w3-quarter w3-padding-xsmall">
        <input type="submit" class="w3-button w3-teal" value="Search">
      </div>
    </div>


<div class="w3-container">
  <div class="w3-panel w3-pale-yellow">
    <b>ค้างทำแบบสอบถามทั้งหมด:</b> <?= (int)$Num_Rows ?> รายการ
  </div>

  <table border="1" width="100%" class="w3-table">
    <thead class="w3-gray">
      <th width="5%">เลขที่อ้างอิง</th>
      <th width="10%">วันที่ลงทะเบียน</th>
      <th width="10%">เลขที่เอกสาร</th>
      <th width="10%">วันที่ออกเอกสาร</th>
	  <th width="10%">วันที่ส่งสินค้า</th>	
      <th width="23%">รายการสินค้า</th>
      <th width="22%">ชื่อลูกค้า</th>
      <th width="22%">เลขพัสดุ</th>
      <th width="15%">เลขลงงาน CS</th>
      <th width="10%">สถานะ</th>
      <th width="10%">สถานะลูกค้า</th>
      <th width="5%">VIP</th>
      <th width="5%">เขตการขาย</th>
      <th width="12%">ทำแบบสอบถาม</th>
    </thead>

    <tbody>
    <?php
    if(empty($rows_page)){
      echo "<tr><td colspan='15' class='w3-center'>ไม่พบรายการค้างทำแบบสอบถาม</td></tr>";
    } else {
      foreach($rows_page as $objResult){

        $sql = "SELECT status_cus,customer_no,vip_ckk FROM tb_customer WHERE customer_id = '".$objResult["bill_id"]."'";
        $qry = mysqli_query($conn,$sql) or die(mysqli_error($conn));
        $rs  = mysqli_fetch_assoc($qry) ?: [];

        $s1 = (int)$objResult['_sec1'];
        $s2 = (int)$objResult['_sec2'];
        $s3 = (int)$objResult['_sec3'];
        $s4 = (int)$objResult['_sec4'];
    ?>
      <tr>
        <td><?=h($objResult["ref_id"])?></td>
        <td><?php echo DateThai($objResult["register_date"]); ?></td>
        <td><?=h($objResult["doc_no"])?></td>
        <td>
          <?php
          if ($objResult["doc_release_date"]=="0000-00-00" || $objResult["doc_release_date"]=="") echo "-";
          else echo DateThai($objResult["doc_release_date"]);
          ?>
        </td>
<td><?php echo DateThai($objResult["delivery_date"]); ?></td>
        <td>
          <div align="left">
          <?php
          $strSQL1 = "SELECT sol_name
                      FROM (so__submain LEFT JOIN tb_product ON so__submain.product_ID=tb_product.product_id)
                      WHERE ref_idd = '".$objResult["ref_id"]."' ";
          $objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
          while($objResult1 = mysqli_fetch_array($objQuery1)){
            echo h($objResult1["sol_name"])."<br />";
          }
          ?>
          </div>
        </td>

        <td>
          <div align="left">
            ชื่อออกบิล : <?=h($objResult["billing_name"])?><br>
            ชื่อผู้รับสินค้า : <?=h($objResult["delivery_contact"])?>
          </div>
        </td>

       

        <td><div align="left"><?=h($objResult["order_refer_code"])?><br><?=h($objResult["order_refer_code1"])?></div></td>
        <td><div align="left"><?=h($objResult["job_id"])?></div></td>

        <?php if($objResult["approve_complete"]=='Rejected'){ ?>
          <td bgcolor="#FF3030"><?=h($objResult["approve_complete"])?></td>
        <?php } else if($objResult["cancel_ckk"]=='1'){ ?>
          <td bgcolor="#FF3030">ยกเลิก</td>
        <?php } else if($objResult["approve_complete"]=='Approve'){ ?>
          <td bgcolor="#00FF00"><?=h($objResult["approve_complete"])?></td>
        <?php } else { ?>
          <td><?=h($objResult["approve_complete"])?></td>
        <?php } ?>

        <?php if(($rs["customer_no"] ?? '') != ''){ ?>
          <?php if(($rs["status_cus"] ?? '')=='0'){ ?>
            <td bgcolor="#FFFF00" style="font-size:12px;">รหัสสมาชิก : <?=h($rs["customer_no"])?> <br>Gold Customer</td>
          <?php } else if(($rs["status_cus"] ?? '')=='1'){ ?>
            <td bgcolor="#CCFF99" style="font-size:12px;">รหัสสมาชิก : <?=h($rs["customer_no"])?> <br>Platinum Customer</td>
          <?php } else if(($rs["status_cus"] ?? '')=='2'){ ?>
            <td bgcolor="#00FF00" style="font-size:12px;">รหัสสมาชิก : <?=h($rs["customer_no"])?> <br>Daimond Customer</td>
          <?php } else { ?>
            <td></td>
          <?php } ?>
        <?php } else { ?>
          <td></td>
        <?php } ?>

        <?php if(($rs["vip_ckk"] ?? '')=='1'){ ?>
          <td bgcolor="#00FF00">VIP</td>
        <?php } else { ?>
          <td></td>
        <?php } ?>

        <td><div align="left"><?=h($objResult["employee_name"])?>-<?=h($objResult["add_by"])?></div></td>

        <td>
          <div style="display:flex; gap:6px; flex-wrap:wrap;">
           <?php /* 1:<?=$badge($s1)?> 2:<?=$badge($s2)?> 3:<?=$badge($s3)?> 4:<?=$badge($s4)?>*/ ?>
          </div>
          <div style="margin-top:6px;">
            <a href="research_010369.php?ref_id=<?=urlencode($objResult["ref_id"])?>">
              <img src="img/create.png" width="23" height="23" border="0" />
            </a>
          </div>
        </td>
      </tr>
    <?php
      }
    }
    ?>
    </tbody>
  </table>
  </div>

  <div class="w3-panel">
    <strong>พบทั้งหมด</strong> <?= (int)$Num_Rows; ?>
    <strong>รายการ : จำนวน</strong> <?= (int)$Num_Pages; ?>
    <strong>หน้า :</strong>

    <?php
    if($Prev_Page > 0){
      echo " <a href='$_SERVER[SCRIPT_NAME]?Page=$Prev_Page&Keyword=".urlencode($Keyword)."&start_date=$start_date&end_date=$end_date&sale_code=$sale_code'><span class='style40'><< Back</span></a> ";
    }

    for($i=1; $i<=$Num_Pages; $i++){
      if($i != $Page){
        echo "[ <a href='$_SERVER[SCRIPT_NAME]?Page=$i&Keyword=".urlencode($Keyword)."&start_date=$start_date&end_date=$end_date&sale_code=$sale_code'><span class='style40'>$i</span></a> ]";
      } else {
        echo "<b> $i </b>";
      }
    }

    if($Page < $Num_Pages){
      echo " <a href ='$_SERVER[SCRIPT_NAME]?Page=$Next_Page&Keyword=".urlencode($Keyword)."&start_date=$start_date&end_date=$end_date&sale_code=$sale_code'><span class='style40'>Next>></span></a> ";
    }
    ?>
    <br>
  </div>
</div>
</form>
<div id="cr_bar"><?php include "foot.php"; ?></div>
</body>
</html>