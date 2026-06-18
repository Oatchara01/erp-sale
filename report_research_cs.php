<?php include "test.php"; ?>
<?php include "error_page.php"; ?>
<?php 
include "dbconnect_cs.php";   // $com1  (CS DB: tb_research, tb_register_data)
include "dbconnect.php";      // $conn  (Sales DB: hos__so, so__*, tb_product)
?>

<link rel="stylesheet" href="css/w32.css">
<style>
  .style15 {font-size:18px;color:#000}
  .style30 {font-size:13px}
</style>

<?php
// =============== Helper ===============
function DateThai($strDate){
  if(!$strDate || $strDate=='0000-00-00') return '-';
  $y = date("Y",strtotime($strDate))+543;
  $m = (int)date("n",strtotime($strDate));
  $d = date("j",strtotime($strDate));
  $th = ["","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค."];
  return "$d {$th[$m]} $y";
}
function hasResearchNonZero($connCS,$running_id){
  if(!$running_id) return false;
  $rid = mysqli_real_escape_string($connCS,$running_id);
  $sql = "SELECT cs_neat,cs_explain,cs_3,cs_4,cs_5 FROM tb_research WHERE running_id='$rid' LIMIT 1";
  $q = mysqli_query($connCS,$sql);
  if(!$q) return false;
  $r = mysqli_fetch_assoc($q);
  if(!$r) return false;
  // มีคะแนนข้อใดข้อหนึ่ง > 0 ถือว่า “สำรวจได้”
  return ((float)$r['cs_neat']>0) || ((float)$r['cs_explain']>0) || ((float)$r['cs_3']>0)
      || ((float)$r['cs_4']>0) || ((float)$r['cs_5']>0);
}
// คืน [sum_raw, display, unit] ตาม “เวอร์ชันฟอร์ม” (ใหม่=3ข้อ เฉลี่ยเต็ม5, เก่า=5ข้อ เปอร์เซ็นต์เต็ม50)
function calcDisplay($scores, $isNewForm){
  $a = (float)($scores['cs_neat']??0);
  $b = (float)($scores['cs_explain']??0);
  $c = (float)($scores['cs_3']??0);
  $d = (float)($scores['cs_4']??0);
  $e = (float)($scores['cs_5']??0);

  if($isNewForm){
    // ฟอร์มใหม่: ใช้ 3 ข้อ (1–5) → ค่าเฉลี่ยเต็ม 5
    $sum = $a + $b + $c;
    $avg5 = $sum / 3.0;
    if($avg5 < 0) $avg5 = 0;
    if($avg5 > 5) $avg5 = 5;
    return [$sum, number_format($avg5,2), '']; // ไม่มี %
  }else{
    // ฟอร์มเก่า: 5 ข้อ (0–10) → เปอร์เซ็นต์จากเต็ม 50
    $sum = $a + $b + $c + $d + $e;
    $pct = ($sum / 50.0) * 100.0;     // <-- แก้จาก 25 เป็น 50 เพื่อไม่ให้ได้ 200%
    if($pct < 0) $pct = 0;
    if($pct > 100) $pct = 100;
    return [$sum, number_format($pct,2), '%'];
  }
}

date_default_timezone_set("Asia/Bangkok");

// ======= รับช่วงวันที่จากฟอร์ม =======
$start_date = isset($_POST["start_date"]) ? trim($_POST["start_date"]) : "";
$end_date   = isset($_POST["end_date"])   ? trim($_POST["end_date"])   : "";

// ======= แสดงเดือน/ปีแบบไทย (หัวรายงาน) =======
$thai=""; $year="";
if($start_date!=""){
  [$yy,$mm] = explode('-', $start_date);
  $map = ["01"=>"มกราคม","02"=>"กุมภาพันธ์","03"=>"มีนาคม","04"=>"เมษายน","05"=>"พฤษภาคม","06"=>"มิถุนายน","07"=>"กรกฎาคม","08"=>"สิงหาคม","09"=>"กันยายน","10"=>"ตุลาคม","11"=>"พฤศจิกายน","12"=>"ธันวาคม"];
  $thai = $map[$mm] ?? "";
  $year = ((int)$yy) + 543;
}

// ===== วันตัดฟอร์มใหม่ + ธงฟอร์มทั้งรายงาน (ยึดตาม $start_date ตามที่ต้องการ) =====
$CUTOFF = '2025-10-01';
$isNewForm = ($start_date !== '' && $start_date >= $CUTOFF);
?>

<body>
<div class="w3-container w3-padding-large">

<center>
  <b class="style15">แบบประเมินความพึงพอใจของการจัดส่งและการประกอบติดตั้ง</b><br>
  <?php if($thai){ ?><span class="style15">เดือน <?php echo $thai; ?> ประจำปี <?php echo $year; ?></span><?php } ?>
</center>
<br>

<table border="1" width="100%" class="w3-table">
<thead>
<tr>
  <td align="center" class="style30">ลำดับ</td>
  <td align="center" class="style30">วันที่ออกบิล</td>
  <td align="center" class="style30">วันที่จัดส่ง</td>
  <td align="center" class="style30">เลขที่เอกสาร</td>
  <td align="center" class="style30">ชื่อลูกค้า</td>
  <td align="center" class="style30">สถานที่ส่ง</td>
  <?php if($isNewForm){ ?>
    <td align="center" class="style30">1</td>
    <td align="center" class="style30">2</td>
    <td align="center" class="style30">3</td>
  <?php } else { ?>
    <td align="center" class="style30">1</td>
    <td align="center" class="style30">2</td>
    <td align="center" class="style30">3</td>
    <td align="center" class="style30">4</td>
    <td align="center" class="style30">5</td>
  <?php } ?>
  <td align="center" class="style30">รวม</td>
  <td align="center" class="style30">หมายเหตุ</td>
</tr>
</thead>

<tbody>
<?php
// ตัวแปรสะสมผลรวมรายหัวข้อ และตัวนับจำนวนแถวที่แสดงจริง
$sumQ = [1=>0,2=>0,3=>0,4=>0,5=>0];
$dispRows = 0;

// ------------------ ชุดที่ 1: hos__so ------------------
$sqlHos = "SELECT iv_no,sale_code,bill_name,job_no,iv_date  
           FROM hos__so 
           WHERE reseach_kk='1' AND status_doc='Approve'";
if($start_date!=""){ $sqlHos .= " AND iv_date >= '".mysqli_real_escape_string($conn,$start_date)."'"; }
if($end_date  !=""){ $sqlHos .= " AND iv_date <= '".mysqli_real_escape_string($conn,$end_date)."'"; }
$qHos = mysqli_query($conn,$sqlHos) or die("Error Query [$sqlHos]");
$no = 1;

while($h = mysqli_fetch_assoc($qHos)){
  if($h['sale_code']==='SM1') continue;

  $rid = mysqli_real_escape_string($com1,$h['job_no']);
  $qR = mysqli_query($com1,"SELECT cs_neat,cs_explain,cs_3,cs_4,cs_5,suggest_2 FROM tb_research WHERE running_id='$rid' LIMIT 1") or die("Error Query [tb_research]");
  $rR = mysqli_fetch_assoc($qR) ?: [];
  $qG = mysqli_query($com1,"SELECT start_date,address_name FROM tb_register_data WHERE running='$rid' LIMIT 1") or die("Error Query [tb_register_data]");
  $rG = mysqli_fetch_assoc($qG) ?: [];

  // ใช้ธงฟอร์ม "ทั้งรายงาน"
  [$sumRaw, $sumDisp, $unit] = calcDisplay($rR, $isNewForm);

  // เก็บผลรวมรายหัวข้อ
  $q1 = (float)($rR['cs_neat']??0);
  $q2 = (float)($rR['cs_explain']??0);
  $q3 = (float)($rR['cs_3']??0);
  $q4 = (float)($rR['cs_4']??0);
  $q5 = (float)($rR['cs_5']??0);

  $sumQ[1] += $q1;
  $sumQ[2] += $q2;
  $sumQ[3] += $q3;
  if(!$isNewForm){ $sumQ[4] += $q4; $sumQ[5] += $q5; }
  $dispRows++;

  ?>
  <tr>
    <td align="center" class="style30"><?php echo $no; ?></td>
    <td align="center" class="style30"><?php echo DateThai($h['iv_date']); ?></td>
    <td align="center" class="style30"><?php echo DateThai($rG['start_date'] ?? ''); ?></td>
    <td align="center" class="style30"><?php echo htmlspecialchars($h['iv_no']); ?></td>
    <td class="style30"><?php echo htmlspecialchars($h['bill_name']); ?></td>
    <td class="style30"><?php echo htmlspecialchars($rG['address_name'] ?? ''); ?></td>

    <?php if($isNewForm){ ?>
      <td align="center" class="style30"><?php echo $q1; ?></td>
      <td align="center" class="style30"><?php echo $q2; ?></td>
      <td align="center" class="style30"><?php echo $q3; ?></td>
    <?php } else { ?>
      <td align="center" class="style30"><?php echo $q1; ?></td>
      <td align="center" class="style30"><?php echo $q2; ?></td>
      <td align="center" class="style30"><?php echo $q3; ?></td>
      <td align="center" class="style30"><?php echo $q4; ?></td>
      <td align="center" class="style30"><?php echo $q5; ?></td>
    <?php } ?>

    <td align="center" class="style30"><?php echo $sumDisp.$unit; ?></td>
    <td class="style30"><?php echo htmlspecialchars($rR['suggest_2'] ?? ''); ?></td>
  </tr>
  <?php
  $no++;
}

// ------------------ ชุดที่ 2: so__* (เตียง/แผ่น) ------------------
$sqlSo = "SELECT so__main.doc_no, so__main.billing_name, so__main.job_id, so__main.doc_release_date,
                 tb_register_data.start_date, tb_register_data.address_name
          FROM ((so__submain
          LEFT JOIN so__main ON so__submain.ref_idd=so__main.ref_id)
          LEFT JOIN tb_product ON so__submain.product_code=tb_product.product_ID)
          LEFT JOIN tb_register_data ON tb_register_data.running = so__main.job_id
          WHERE (unit_name='เตียง' OR unit_name='แผ่น') AND cancel_ckk='0' AND sale_channel='4' 
                AND so__main.job_id<>'' AND so__main.doc_no NOT LIKE '%B%' 
                AND approve_complete='Approve'";
if($start_date!=""){ $sqlSo .= " AND so__main.doc_release_date >= '".mysqli_real_escape_string($conn,$start_date)."'"; }
if($end_date  !=""){ $sqlSo .= " AND so__main.doc_release_date <= '".mysqli_real_escape_string($conn,$end_date)."'"; }
$qSo = mysqli_query($conn,$sqlSo) or die("Error Query [$sqlSo]");

while($s = mysqli_fetch_assoc($qSo)){
  $rid = mysqli_real_escape_string($com1,$s['job_id']);
  $qR = mysqli_query($com1,"SELECT cs_neat,cs_explain,cs_3,cs_4,cs_5,suggest_2 FROM tb_research WHERE running_id='$rid' LIMIT 1") or die("Error Query [tb_research SO]");
  $rR = mysqli_fetch_assoc($qR) ?: [];

  [$sumRaw, $sumDisp, $unit] = calcDisplay($rR, $isNewForm);

  $q1 = (float)($rR['cs_neat']??0);
  $q2 = (float)($rR['cs_explain']??0);
  $q3 = (float)($rR['cs_3']??0);
  $q4 = (float)($rR['cs_4']??0);
  $q5 = (float)($rR['cs_5']??0);

  $sumQ[1] += $q1;
  $sumQ[2] += $q2;
  $sumQ[3] += $q3;
  if(!$isNewForm){ $sumQ[4] += $q4; $sumQ[5] += $q5; }
  $dispRows++;
  ?>
  <tr>
    <td align="center" class="style30"><?php echo $no; ?></td>
    <td align="center" class="style30"><?php echo DateThai($s['doc_release_date']); ?></td>
    <td align="center" class="style30"><?php echo DateThai($s['start_date'] ?? ''); ?></td>
    <td align="center" class="style30"><?php echo htmlspecialchars($s['doc_no']); ?></td>
    <td class="style30"><?php echo htmlspecialchars($s['billing_name']); ?></td>
    <td class="style30"><?php echo htmlspecialchars($s['address_name'] ?? ''); ?></td>

    <?php if($isNewForm){ ?>
      <td align="center" class="style30"><?php echo $q1; ?></td>
      <td align="center" class="style30"><?php echo $q2; ?></td>
      <td align="center" class="style30"><?php echo $q3; ?></td>
    <?php } else { ?>
      <td align="center" class="style30"><?php echo $q1; ?></td>
      <td align="center" class="style30"><?php echo $q2; ?></td>
      <td align="center" class="style30"><?php echo $q3; ?></td>
      <td align="center" class="style30"><?php echo $q4; ?></td>
      <td align="center" class="style30"><?php echo $q5; ?></td>
    <?php } ?>

    <td align="center" class="style30"><?php echo $sumDisp.$unit; ?></td>
    <td class="style30"><?php echo htmlspecialchars($rR['suggest_2'] ?? ''); ?></td>
  </tr>
  <?php
  $no++;
}
?>
</tbody>

<?php
// แถวสรุปผลรวม/เฉลี่ยรายหัวข้อ
$avgQ = [1=>0,2=>0,3=>0,4=>0,5=>0];
if($dispRows>0){
  $avgQ[1] = $sumQ[1]/$dispRows;
  $avgQ[2] = $sumQ[2]/$dispRows;
  $avgQ[3] = $sumQ[3]/$dispRows;
  if(!$isNewForm){
    $avgQ[4] = $sumQ[4]/$dispRows;
    $avgQ[5] = $sumQ[5]/$dispRows;
  }
}
?>
<tfoot>
<tr style="background:#f7f7f7">
  <td colspan="6" align="right" class="style30"><b>รวมตามหัวข้อ</b></td>
  <?php if($isNewForm){ ?>
    <td align="center" class="style30"><b><?php echo number_format($sumQ[1],2); ?></b></td>
    <td align="center" class="style30"><b><?php echo number_format($sumQ[2],2); ?></b></td>
    <td align="center" class="style30"><b><?php echo number_format($sumQ[3],2); ?></b></td>
  <?php } else { ?>
    <td align="center" class="style30"><b><?php echo number_format($sumQ[1],2); ?></b></td>
    <td align="center" class="style30"><b><?php echo number_format($sumQ[2],2); ?></b></td>
    <td align="center" class="style30"><b><?php echo number_format($sumQ[3],2); ?></b></td>
    <td align="center" class="style30"><b><?php echo number_format($sumQ[4],2); ?></b></td>
    <td align="center" class="style30"><b><?php echo number_format($sumQ[5],2); ?></b></td>
  <?php } ?>
  <td colspan="2"></td>
</tr>
<tr style="background:#f7f7f7">
  <td colspan="6" align="right" class="style30">
    <b>เฉลี่ยต่อหัวข้อ</b>
  </td>
  <?php if($isNewForm){ ?>
    <td align="center" class="style30"><b><?php echo number_format($avgQ[1],2); ?></b></td>
    <td align="center" class="style30"><b><?php echo number_format($avgQ[2],2); ?></b></td>
    <td align="center" class="style30"><b><?php echo number_format($avgQ[3],2); ?></b></td>
  <?php } else { ?>
    <td align="center" class="style30"><b><?php echo number_format($avgQ[1],2); ?></b></td>
    <td align="center" class="style30"><b><?php echo number_format($avgQ[2],2); ?></b></td>
    <td align="center" class="style30"><b><?php echo number_format($avgQ[3],2); ?></b></td>
    <td align="center" class="style30"><b><?php echo number_format($avgQ[4],2); ?></b></td>
    <td align="center" class="style30"><b><?php echo number_format($avgQ[5],2); ?></b></td>
  <?php } ?>
  <td colspan="2"></td>
</tr>
</tfoot>
</table>

<?php
// ===================== สรุปงาน (ไม่ cross-DB JOIN) =====================

// 1) hos__so (ตัด SM1)
$allHosJobs = [];
$q = "SELECT job_no FROM hos__so WHERE reseach_kk='1' AND status_doc='Approve' AND sale_code<>'SM1'";
if($start_date!=""){ $q .= " AND iv_date >= '".mysqli_real_escape_string($conn,$start_date)."'"; }
if($end_date  !=""){ $q .= " AND iv_date <= '".mysqli_real_escape_string($conn,$end_date)."'"; }
$res = mysqli_query($conn,$q) or die("Error Query [$q]");
while($r = mysqli_fetch_assoc($res)){ $allHosJobs[] = $r['job_no']; }

// 2) so__* (เตียง/แผ่น)
$allSoJobs = [];
$q = "SELECT DISTINCT so__main.job_id
      FROM ((so__submain
      LEFT JOIN so__main ON so__submain.ref_idd=so__main.ref_id)
      LEFT JOIN tb_product ON so__submain.product_code=tb_product.product_ID)
      WHERE (unit_name='เตียง' OR unit_name='แผ่น') AND cancel_ckk='0' AND sale_channel='4'
        AND so__main.job_id<>'' AND so__main.doc_no NOT LIKE '%B%'
        AND approve_complete='Approve'";
if($start_date!=""){ $q .= " AND so__main.doc_release_date >= '".mysqli_real_escape_string($conn,$start_date)."'"; }
if($end_date  !=""){ $q .= " AND so__main.doc_release_date <= '".mysqli_real_escape_string($conn,$end_date)."'"; }
$res = mysqli_query($conn,$q) or die("Error Query [$q]");
while($r = mysqli_fetch_assoc($res)){ $allSoJobs[] = $r['job_id']; }

// 3) ตรวจว่ามีแบบประเมิน (tb_research) หรือไม่
$sale = count($allHosJobs) + count($allSoJobs);
$cs = 0;
foreach($allHosJobs as $jid){ if(hasResearchNonZero($com1,$jid)) $cs++; }
foreach($allSoJobs as $jid){ if(hasResearchNonZero($com1,$jid)) $cs++; }
$notcs = max(0, $sale-$cs);
$per = $sale ? ($cs/$sale)*100.0 : 0;
?>

<br><br>
<table width="100%" class="w3-table">
  <tr><td width="35%" align="right" class="style30">สรุปงานทั้งหมด</td>
      <td width="10%" align="center" class="style30"><?php echo $sale; ?></td>
      <td width="35%" class="style30">งาน</td><td width="20%"></td></tr>
  <tr><td align="right" class="style30">สำรวจได้</td>
      <td align="center" class="style30"><?php echo $cs; ?></td>
      <td class="style30">งาน</td><td></td></tr>
  <tr><td align="right" class="style30">สำรวจไม่ได้</td>
      <td align="center" class="style30"><?php echo $notcs; ?></td>
      <td class="style30">งาน</td><td></td></tr>
  <tr><td align="right" class="style30">คิดเป็น</td>
      <td align="center" class="style30"><?php echo number_format($per,2); ?></td>
      <td class="style30">%</td><td></td></tr>
</table>

<br><br>

<!-- บล็อกหัวข้ออธิบายตามฟอร์ม (ตาม $start_date ทั้งก้อน) -->
<table width="100%" class="w3-table">
<?php if($isNewForm){ ?>
  <tr><td width="5%" align="right" class="style30"></td>
      <td width="90%" class="style30">1. พนักงานจัดส่งสุภาพ แต่งกายเหมาะสม และปฏิบัติตามมาตรการความปลอดภัย</td></tr>
  <tr><td align="right" class="style30"></td>
      <td class="style30">2. จัดส่งตรงเวลา พร้อมบริการติดตั้ง/สาธิตการใช้งานสินค้า</td></tr>
  <tr><td align="right" class="style30"></td>
      <td class="style30">3. ประสานงานก่อนส่ง และดูแลเอาใจใส่การส่งมอบเรียบร้อย</td></tr>
<?php } else { ?>
  <tr><td width="5%" align="right" class="style30"></td>
      <td width="90%" class="style30">1. ส่งสินค้าตามเวลานัดหมาย</td></tr>
  <tr><td align="right" class="style30"></td>
      <td class="style30">2. มีการโทรประสานงานก่อนการจัดส่งจริง</td></tr>
  <tr><td align="right" class="style30"></td>
      <td class="style30">3. พนักงานแต่งกายเรียบร้อย และเหมาะสม</td></tr>
  <tr><td align="right" class="style30"></td>
      <td class="style30">4. กิริยามารยาทสุภาพ เรียบร้อย</td></tr>
  <tr><td align="right" class="style30"></td>
      <td class="style30">5. พนักงานติดตั้ง/สาธิต อธิบายวิธีการใช้งานผลิตภัณฑ์ได้ดี มีความเต็มใจในการให้บริการ</td></tr>
<?php } ?>
</table>

<br><br>
</div>
</body>
</html>
