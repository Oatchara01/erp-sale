<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<?php
include "test.php";
include "dbconnect.php";
include "dbconnect_cs.php";
date_default_timezone_set("Asia/Bangkok");

/* =========================
   SAFE INPUT: ref_id
========================= */
$ref_id = $_GET['ref_id'] ?? '';
$ref_id = trim($ref_id);
if (!preg_match('/^[A-Za-z0-9_-]+$/', $ref_id)) {
  die('Invalid ref_id');
}
$ref = substr($ref_id, 0, 2);

/* =========================
   HELPERS
========================= */
function h($v){
  return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="css/w3.css" rel="stylesheet" type="text/css" />
<title>แบบสอบถามความพึงพอใจของลูกค้า</title>
<link href="css/form_style.css" rel="stylesheet" type="text/css" />

<style>
/* ปุ่มเดิม */
.button { background-color:#339900; border:none; color:#fff; padding:12px 18px; text-align:center; text-decoration:none; display:inline-block; font-size:17px; margin:4px 2px; cursor:pointer; border-radius:10px; }
.button1 {border-radius: 2px;}
.button2 {border-radius: 4px;}
.button3 {border-radius: 8px;}
.button4 {border-radius: 12px;}
.button5 {border-radius: 50%;}

/* เดิม */
.style15 { font-size:18px; color:#000; }
.style30 { font-size:12px; }
.style32 { font-size:11px; }
.style33 { font-size:12px; }
.style34 { color:#FF0000; }
.style35 { font-size:14px; color:#FF0000; }
.style37 { color:#FF0000; font-size:14px; }
.style38 { color:#f2f2f2; }
.style39 { font-size:14px; color:#000000; }
.style40 { font-size:16px; color:#FF0000; }

/* ===== ปรับให้เหมาะกับ iPad ===== */
body { font-size:16px; line-height:1.5; }
.w3-container.w3-padding-large { max-width:980px; margin:0 auto; }

/* ช่องกรอกแตะง่าย กว้างเต็มบรรทัด */
input.button4[type="text"],
input.button4[type="date"],
textarea.button4 {
  width:100%;
  max-width:780px;
  box-sizing:border-box;
  padding:10px 12px;
  font-size:16px;
}

/* ตารางเลื่อนได้แนวนอนบนจอแคบ */
.table-responsive { width:100%; overflow-x:auto; -webkit-overflow-scrolling:touch; }
.w3-table td, .w3-table th { padding:10px; vertical-align:middle; font-size:16px; }
.w3-table tr:first-child td div { font-weight:600; }

/* ขยายขนาดปุ่ม radio ให้แตะง่าย */
input[type="radio"] { transform:scale(1.25); margin:6px; }

/* จัด label+input เป็น 2 คอลัมน์เมื่อหน้าจอกว้างพอ */
.form-row { margin:10px 0; }
@media (min-width:768px){
  .form-row.grid {
    display:grid;
    grid-template-columns:220px 1fr;
    align-items:center;
    gap:10px 16px;
    max-width:980px;
  }
  .form-row.grid > label { margin:6px 0; }
}

/* ปรับขนาดฟอนต์เล็กน้อยบนจอแคบ */
@media (max-width:767.98px){
  .w3-table td, .w3-table th { font-size:15px; }
  h2 span.style15 { font-size:17px; }
}
	
/* ===============================
   GLOBAL FONT: Prompt
=============================== */
html, body {
  font-family: 'Prompt', sans-serif !important;
  font-size: 14px !important;
  line-height: 1.5;
}

/* บังคับให้ทุกอย่างใช้ Prompt + ขนาดเท่ากัน */
.w3-container, .w3-container *,
.w3-table, .w3-table *,
input, textarea, select, button, label, legend, p, u, span {
  font-family: 'Prompt', sans-serif !important;
  font-size: 16px !important;
}

/* หัวข้อ */
h2, h2 span.style15 {
  font-family: 'Prompt', sans-serif !important;
  font-size: 18px !important;
  font-weight: 600;
}

/* กัน style39 เดิม 14px */
.style39 {
  font-size: 16px !important;
}
	
</style>
</head>

<body>
<center>
  <h2><span class="style15">แบบสอบถามความพึงพอใจลูกค้า</span></h2>
  <h2><span class="style15">(Customer's Satisfaction Questionnaire)</span></h2>
</center>

<form action="research_010369_save.php" name="frmAdd" method="post">
<?php
/* =========================
   LOAD tb_research (com1)
========================= */
$strSQL  = "SELECT * FROM tb_research WHERE red_id = '".$ref_id."' ";
$objQuery = mysqli_query($com1,$strSQL) or die(mysqli_error($com1));
$objResult = mysqli_fetch_assoc($objQuery) ?: [];

/* =========================
   LOAD SALE DATA (conn)
========================= */
$sale_code = '';
$iv_date   = '';
$job_id    = '';
$iv_no     = '';
$bill_name = '';
$bill_tel  = '';
$grade     = 'B';
$product_name = '';

if($ref==='SO'){
  $sql = "SELECT sale_code,iv_date,job_no,iv_no,bill_name,bill_tel
          FROM hos__so
          WHERE ref_id = '".$ref_id."'";
  $qry = mysqli_query($conn,$sql) or die(mysqli_error($conn));
  $rs  = mysqli_fetch_assoc($qry) ?: [];

  $sale_code = $rs["sale_code"] ?? '';
  $iv_date   = $rs["iv_date"] ?? '';
  $job_id    = $rs["job_no"] ?? '';
  $iv_no     = $rs["iv_no"] ?? '';
  $bill_name = $rs["bill_name"] ?? '';
  $bill_tel  = $rs["bill_tel"] ?? '';

  $grade = ($sale_code==='S33') ? 'B' : 'A';

  $strSQL1 = "SELECT sol_name,count,unit_name
              FROM (hos__subso LEFT JOIN tb_product ON hos__subso.product_ID=tb_product.product_id)
              WHERE ref_idd = '".$ref_id."' AND product_type != 'อื่นๆ'";

  $objQuery1 = mysqli_query($conn,$strSQL1) or die(mysqli_error($conn));
  while($row = mysqli_fetch_assoc($objQuery1)){
    $sol_name  = $row["sol_name"] ?? '';
    $count     = $row["count"] ?? '';
    $unit_name = $row["unit_name"] ?? '';
    $product_name .= trim("$sol_name $count $unit_name") . "\n";
  }
  $product_name = trim($product_name);

} else {

  $sql = "SELECT employee_name,doc_release_date,job_id,doc_no,tel,customer_name
          FROM so__main
          WHERE ref_id = '".$ref_id."'";
  $qry = mysqli_query($conn,$sql) or die(mysqli_error($conn));
  $rs  = mysqli_fetch_assoc($qry) ?: [];

  $iv_date   = $rs["doc_release_date"] ?? '';
  $sale_code = $rs["employee_name"] ?? '';
  $grade     = "B";
  $job_id    = $rs["job_id"] ?? '';
  $iv_no     = $rs["doc_no"] ?? '';
  $bill_name = $rs["customer_name"] ?? '';
  $bill_tel  = $rs["tel"] ?? '';

  $strSQL1 = "SELECT sol_name,sale_count,unit_name
              FROM (so__submain LEFT JOIN tb_product ON so__submain.product_ID=tb_product.product_id)
              WHERE ref_idd = '".$ref_id."' AND product_type != 'อื่นๆ'";

  $objQuery1 = mysqli_query($conn,$strSQL1) or die(mysqli_error($conn));
  while($row = mysqli_fetch_assoc($objQuery1)){
    $sol_name  = $row["sol_name"] ?? '';
    $count     = $row["sale_count"] ?? '';
    $unit_name = $row["unit_name"] ?? '';
    $product_name .= trim("$sol_name $count $unit_name") . "\n";
  }
  $product_name = trim($product_name);
}

/* =========================
   FALLBACKS / DATES (fix logic)
========================= */
$customer_name = (!empty($objResult["customer_name"])) ? $objResult["customer_name"] : $bill_name;
$customer_tel  = (!empty($objResult["customer_tel"]))  ? $objResult["customer_tel"]  : $bill_tel;

$date_research = (!empty($objResult["date_research"]) && $objResult["date_research"] !== '0000-00-00')
  ? $objResult["date_research"]
  : date('Y-m-d');

$date_sale = (!empty($objResult["date_sale"]) && $objResult["date_sale"] !== '0000-00-00')
  ? $objResult["date_sale"]
  : date('Y-m-d');

/* =========================
   OPTIONAL: tb_register_data (com1)
========================= */
$objResult2 = [];
if(!empty($job_id)){
  $strSQL2  = "SELECT * FROM tb_register_data WHERE running = '".$job_id."' ";
  $objQuery2 = mysqli_query($com1,$strSQL2) or die(mysqli_error($com1));
  $objResult2 = mysqli_fetch_assoc($objQuery2) ?: [];
}
?>

<div class="w3-container w3-padding-large">

  <!-- วันที่ -->
  <div class="form-row grid">
    <label>วันที่ :</label>
    <input type="date" name="date_sale" class="w3-input" value="<?=h($date_sale)?>" readonly>
    <input type="hidden" name="iv_date" class="w3-input" value="<?=h($iv_date)?>" readonly>
    <input type="hidden" name="date_research" class="w3-input" value="<?=h($date_research)?>" readonly>
  </div>

  <!-- ชื่อลูกค้า -->
  <div class="form-row grid">
    <label>ชื่อลูกค้า :</label>
    <input name="customer_name" type="text" id="customer_name" value="<?=h($customer_name)?>" class="w3-input"/>
    <input name="running_id" type="hidden" id="running_id" value="<?=h($job_id)?>" class="w3-input" readonly/>
    <input type="hidden" name="grade" value="<?=h($grade)?>">
  </div>

  <!-- โทรศัพท์ -->
  <div class="form-row grid">
    <label>โทรศัพท์ :</label>
    <input name="customer_tel" type="text" id="customer_tel" value="<?=h($customer_tel)?>" class="w3-input" />
  </div>

  <input name="ref_id" type="hidden" id="ref_id" value="<?=h($ref_id)?>" class="w3-input" />

  <!-- เลขที่ IV -->
  <div class="form-row grid">
    <label>เลขที่ IV :</label>
    <input name="iv_number" type="text" id="iv_number" value="<?=h($iv_no)?>" class="w3-input"/>
    <input name="sale_code" type="hidden" id="sale_code" value="<?=h($sale_code)?>" class="w3-input"/>
  </div>

  <!-- สินค้า -->
  <div class="form-row grid">
    <label>สินค้า :</label>
    <textarea name="product_name" id="product_name" rows="2" class="w3-input"><?=h($product_name)?></textarea>
  </div>

  <!-- ชื่อพนักงานส่ง -->
  <div class="form-row grid">
    <label>ชื่อพนักงานส่ง :</label>
    <input name="team_send" type="text" id="team_send" value="<?=h($objResult["team_send"] ?? '')?>" class="w3-input" />
  </div>

  <p>
    โปรดใส่เครื่องหมาย <input type="radio" value="" checked="checked" /> ลงในช่องที่ท่านเห็นด้วย
    <br>
    (คะแนนการประเมิน มากที่สุด = 5, น้อยที่สุด = 1)
  </p>

  <!-- ===== ส่วนที่ 1 ความพึงพอใจต่อพนักงานขาย ===== -->
  <?php if(($objResult["sale_neat"] ?? '')=='0' || ($objResult["sale_neat"] ?? '')==''){ ?>
    <u>ส่วนที่ 1 ความพึงพอใจต่อพนักงานขาย</u>
    <div class="table-responsive">
      <table border="1" class="w3-table" width="100%">
        <tr>
          <td width="5%"  bgcolor="#CFCFCF"><div align="center">ลำดับ</div></td>
          <td width="40%" bgcolor="#CFCFCF"><div align="center">รายละเอียด</div></td>
          <td width="5%"  bgcolor="#CFCFCF"><div align="center">1</div></td>
          <td width="5%"  bgcolor="#CFCFCF"><div align="center">2</div></td>
          <td width="5%"  bgcolor="#CFCFCF"><div align="center">3</div></td>
          <td width="5%"  bgcolor="#CFCFCF"><div align="center">4</div></td>
          <td width="5%"  bgcolor="#CFCFCF"><div align="center">5</div></td>
        </tr>

        <tr>
          <td align="center"><span class="style39">1</span></td>
          <td><div align="left"><span class="style39">พนักงานพูดจาสุภาพ มีมารยาท และแต่งกายเหมาะสม</span></div></td>
          <td align="center"><input type="radio" name="sale_neat" value="1" required></td>
          <td align="center"><input type="radio" name="sale_neat" value="2" required></td>
          <td align="center"><input type="radio" name="sale_neat" value="3" required></td>
          <td align="center"><input type="radio" name="sale_neat" value="4" required></td>
          <td align="center"><input type="radio" name="sale_neat" value="5" required></td>
        </tr>

        <tr>
          <td align="center"><span class="style39">2</span></td>
          <td><div align="left"><span class="style39">มีความรู้ความเข้าใจเกี่ยวกับสินค้า สามารถให้คำแนะนำได้ชัดเจน</span></div></td>
          <td align="center"><input type="radio" name="sale_data" value="1" required></td>
          <td align="center"><input type="radio" name="sale_data" value="2" required></td>
          <td align="center"><input type="radio" name="sale_data" value="3" required></td>
          <td align="center"><input type="radio" name="sale_data" value="4" required></td>
          <td align="center"><input type="radio" name="sale_data" value="5" required></td>
        </tr>

        <tr>
          <td align="center"><span class="style39">3</span></td>
          <td><div align="left"><span class="style39">แสดงความใส่ใจ ติดตามผล และให้ความช่วยเหลือหลังการขาย</span></div></td>
          <td align="center"><input type="radio" name="sale_3" value="1" required></td>
          <td align="center"><input type="radio" name="sale_3" value="2" required></td>
          <td align="center"><input type="radio" name="sale_3" value="3" required></td>
          <td align="center"><input type="radio" name="sale_3" value="4" required></td>
          <td align="center"><input type="radio" name="sale_3" value="5" required></td>
        </tr>
      </table>
    </div>

    <fieldset><legend><b></b></legend>
      <label>ข้อเสนอแนะอื่นๆ :</label>
      <textarea name="suggest" class="w3-input" id="suggest" rows="3"></textarea>
    </fieldset>
  <?php } ?>
	
<br>

  <!-- ===== ส่วนที่ 2 ความพึงพอใจต่อสินค้า/ผลิตภัณฑ์ ===== -->
  <?php if(($objResult["product_good"] ?? '')=='0' || ($objResult["product_good"] ?? '')==''){ ?>
    <u>ส่วนที่ 2 ความพึงพอใจต่อสินค้า / ผลิตภัณฑ์</u>
    <div class="table-responsive">
      <table border="1" class="w3-table" width="100%">
        <tr>
          <td width="5%"  bgcolor="#CFCFCF"><div align="center">ลำดับ</div></td>
          <td width="40%" bgcolor="#CFCFCF"><div align="center">รายละเอียด</div></td>
          <td width="5%"  bgcolor="#CFCFCF"><div align="center">1</div></td>
          <td width="5%"  bgcolor="#CFCFCF"><div align="center">2</div></td>
          <td width="5%"  bgcolor="#CFCFCF"><div align="center">3</div></td>
          <td width="5%"  bgcolor="#CFCFCF"><div align="center">4</div></td>
          <td width="5%"  bgcolor="#CFCFCF"><div align="center">5</div></td>
        </tr>

        <tr>
          <td align="center"><span class="style39">1</span></td>
          <td><div align="left"><span class="style39">สินค้าตรงตามข้อมูลที่ได้รับก่อนซื้อ และสามารถใช้งานอย่างมีประสิทธิภาพหรือไม่</span></div></td>
          <td align="center"><input type="radio" name="product_good" value="1" required></td>
          <td align="center"><input type="radio" name="product_good" value="2" required></td>
          <td align="center"><input type="radio" name="product_good" value="3" required></td>
          <td align="center"><input type="radio" name="product_good" value="4" required></td>
          <td align="center"><input type="radio" name="product_good" value="5" required></td>
        </tr>

        <tr>
          <td align="center"><span class="style39">2</span></td>
          <td><div align="left"><span class="style39">ความพึงพอใจโดยรวมที่มีต่อผลิตภัณฑ์สินค้าที่ได้รับ</span></div></td>
          <td align="center"><input type="radio" name="product_link" value="1" required></td>
          <td align="center"><input type="radio" name="product_link" value="2" required></td>
          <td align="center"><input type="radio" name="product_link" value="3" required></td>
          <td align="center"><input type="radio" name="product_link" value="4" required></td>
          <td align="center"><input type="radio" name="product_link" value="5" required></td>
        </tr>
      </table>
    </div>

    <fieldset><legend><b></b></legend>
      <label>ข้อเสนอแนะอื่นๆ :</label>
      <textarea name="suggest_1" class="w3-input" id="suggest_1" rows="3"></textarea>
    </fieldset>
  <?php } ?>
	
<br>

  <!-- ===== ส่วนที่ 3 การบริการจัดส่ง ===== -->
<?php if(($objResult["cs_neat"] ?? '')=='0' || ($objResult["cs_neat"] ?? '')==''){ ?>
  <u>ส่วนที่ 3 การสอบถามความพึงพอใจของลูกค้าที่มีต่อการบริการจัดส่ง</u>

  <div class="table-responsive">
    <table border="1" class="w3-table" width="100%">
      <tr>
        <td width="5%"  bgcolor="#CFCFCF"><div align="center">ลำดับ</div></td>
        <td width="40%" bgcolor="#CFCFCF"><div align="center">รายละเอียด</div></td>
        <td width="5%"  bgcolor="#CFCFCF"><div align="center">1</div></td>
        <td width="5%"  bgcolor="#CFCFCF"><div align="center">2</div></td>
        <td width="5%"  bgcolor="#CFCFCF"><div align="center">3</div></td>
        <td width="5%"  bgcolor="#CFCFCF"><div align="center">4</div></td>
        <td width="5%"  bgcolor="#CFCFCF"><div align="center">5</div></td>
      </tr>

      <tr>
        <td align="center"><span class="style39">1</span></td>
        <td><div align="left"><span class="style39">พนักงานจัดส่งมีความสุภาพ แต่งกายเหมาะสม และปฏิบัติตามมาตรการความปลอดภัย</span></div></td>
        <?php for($i=1;$i<=5;$i++): ?>
          <td align="center"><input type="radio" name="cs_neat" value="<?=$i?>" <?=($i==1?'required':'')?>></td>
        <?php endfor; ?>
      </tr>

      <tr>
        <td align="center"><span class="style39">2</span></td>
        <td><div align="left"><span class="style39">การจัดส่งตรงเวลา พร้อมบริการติดตั้ง/สาธิตการใช้งานสินค้า</span></div></td>
        <?php for($i=1;$i<=5;$i++): ?>
          <td align="center"><input type="radio" name="cs_explain" value="<?=$i?>" <?=($i==1?'required':'')?>></td>
        <?php endfor; ?>
      </tr>

      <tr>
        <td align="center"><span class="style39">3</span></td>
        <td><div align="left"><span class="style39">มีการประสานงานก่อนส่ง และดูแลจนถึงการส่งมอบเรียบร้อย</span></div></td>
        <?php for($i=1;$i<=5;$i++): ?>
          <td align="center"><input type="radio" name="cs_3" value="<?=$i?>" <?=($i==1?'required':'')?>></td>
        <?php endfor; ?>
      </tr>
    </table>
  </div>

  <fieldset class="block"> <label>ข้อเสนอแนะอื่นๆ :</label><br>
    <textarea name="suggest_2" id="suggest_2" rows="3" class="w3-input"></textarea><br>
  </fieldset>
<?php } ?>
	
<br>
  <!-- ===== ส่วนที่ 4 NPS ===== -->
<?php if(($objResult["cus_1"] ?? '')=='0' || ($objResult["cus_1"] ?? '')==''){ ?>
  <u>ส่วนที่ 4 การสอบถามความภักดีของลูกค้า (NPS)</u>

  <div class="table-responsive">
    <table border="1" class="w3-table" width="100%">
      <tr>
        <td width="5%"  bgcolor="#CFCFCF"><div align="center">ลำดับ</div></td>
        <td width="40%" bgcolor="#CFCFCF"><div align="center">รายละเอียด</div></td>
        <td width="5%"  bgcolor="#CFCFCF"><div align="center">1</div></td>
        <td width="5%"  bgcolor="#CFCFCF"><div align="center">2</div></td>
        <td width="5%"  bgcolor="#CFCFCF"><div align="center">3</div></td>
        <td width="5%"  bgcolor="#CFCFCF"><div align="center">4</div></td>
        <td width="5%"  bgcolor="#CFCFCF"><div align="center">5</div></td>
      </tr>

      <tr>
        <td align="center"><span class="style39">1</span></td>
        <td><div align="left"><span class="style39">คุณลูกค้ามีความตั้งใจที่จะแนะนำบริษัทให้ผู้อื่น มากน้อยเพียงใด</span></div></td>
        <?php for($i=1;$i<=5;$i++): ?>
          <td align="center"><input type="radio" name="cus_1" value="<?=$i?>" <?=($i==1?'required':'')?>></td>
        <?php endfor; ?>
      </tr>
    </table>
  </div>

  <fieldset class="block"> <label>ข้อเสนอแนะอื่นๆ :</label><br>
    <textarea name="suggest_cus" id="suggest_cus" rows="3" class="w3-input"></textarea><br>
  </fieldset>
<?php } ?>

  <p align="center">
    <input type="submit" name="button" id="button" value="Submit" class="button button3" />
  </p>

</div>
</form>

<div id="cr_bar"><?php include "foot.php"; ?></div>
</body>
</html>