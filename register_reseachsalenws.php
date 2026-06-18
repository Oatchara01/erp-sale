<?php include "test.php"; ?>

<?php 
include "dbconnect.php"; 
include "dbconnect_cs.php";
date_default_timezone_set("Asia/Bangkok");
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
.style30 { font-size:12; }
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
</style>
</head>

<body>
<center>
  <h2><span class="style15">แบบสอบถามความพึงพอใจลูกค้า</span></h2>
  <h2><span class="style15">(Customer's Satisfaction Questionnaire)</span></h2>
</center>

<form action="register_reseachsale1.php" name="frmAdd" method="post" onSubmit="JavaScript:return fncSubmit();">
<?php
$month = date('m'); $day = date('d'); $year = date('Y');
$today = $year . '-' . $month . '-' . $day;

$strSQL  = "SELECT * FROM tb_research WHERE running_id = '".$_GET["running"]."' ";
$objQuery = mysqli_query($com1,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);

$strSQL1  = "SELECT * FROM hos__so WHERE ref_id = '".$_GET["ref_id"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die(mysqli_error());
$objResult1 = mysqli_fetch_array($objQuery1);

$strSQL2  = "SELECT * FROM tb_register_data WHERE ref_id = '".$_GET["ref_id"]."' ";
$objQuery2 = mysqli_query($conn,$strSQL2) or die(mysqli_error());
$objResult2 = mysqli_fetch_array($objQuery2);
?>

<div class="w3-container w3-padding-large">

  <!-- เกรดลูกค้า -->
  <div class="form-row grid">
    <label>ลูกค้าเกรด :</label>
    <div>
      <?php if($objResult1["sale_code"]=='S31' || $objResult1["sale_code"]=='MM1'){ ?>
        <label><input type="radio" name="grade" value="B" checked> B</label>
      <?php } else { ?>
        <label><input type="radio" name="grade" value="A" checked> A</label>
      <?php } ?>
    </div>
  </div>

  <!-- วันที่ -->
  <div class="form-row grid">
    <label>วันที่ :</label>
    <input type="date" name="date_sale" class="w3-input" value="<?php echo $today; ?>" readonly>
    <input type="hidden" name="iv_date" class="w3-input" value="<?php echo $objResult1["iv_date"]; ?>" readonly>
  </div>

  <!-- ชื่อลูกค้า -->
  <div class="form-row grid">
    <label>ชื่อลูกค้า :</label>
    <input name="customer_name" type="text" id="customer_name" value="<?php echo $objResult1["bill_name"]; ?>" class="w3-input"/>
    <input name="running_id" type="hidden" id="running_id" value="<?=$objResult1["job_no"]?>" class="w3-input" readonly/>
  </div>

  <!-- โทรศัพท์ -->
  <div class="form-row grid">
    <label>โทรศัพท์ :</label>
    <input name="customer_tel" type="text" id="customer_tel" value="<?php echo $objResult2["customer_tel"];?>" class="w3-input" />
  </div>

  <input name="ref_id" type="hidden" id="ref_id" value="<?php echo $objResult1["ref_id"];?>" class="w3-input"  />

  <!-- เลขที่ IV -->
  <div class="form-row grid">
    <label>เลขที่ IV :</label>
    <input name="iv_number" type="text" id="iv_number" value="<?php echo $objResult1["iv_no"];?>" class="w3-input"/>
    <input name="employee_code" type="hidden" id="employee_code" value="<?php echo $objResult["employee_code"];?>" class="w3-input"/>
    <input name="sale_code" type="hidden" id="sale_code" value="<?php echo $objResult1["sale_code"];?>" class="w3-input"/>
  </div>

  <!-- สินค้า -->
  <div class="form-row grid">
    <label>สินค้า :</label>
    <textarea name="product_name" id="product_name" rows="2" class="w3-input"><?php echo $objResult2["product_name"];?></textarea>
  </div>

  <!-- ชื่อพนักงานส่ง -->
  <div class="form-row grid">
    <label>ชื่อพนักงานส่ง :</label>
    <input name="team_send" type="text" id="team_send" value="<?php echo $objResult["team_send"];?>" class="w3-input" />
  </div>

  <p>
    โปรดใส่เครื่องหมาย <input type="radio" value="" checked="checked" /> ลงในช่องที่ท่านเห็นด้วย
    <br>
    (คะแนนการประเมิน มากที่สุด = 5, น้อยที่สุด = 1)
  </p>

  <!-- ===== ความพึงพอใจต่อพนักงานขาย ===== -->
  <u>ความพึงพอใจต่อพนักงานขาย</u>
  <div class="table-responsive">
    <table border="1" class="w3-table" width="100%">
      <tr>
        <td width="5%"  bgcolor="#CFCFCF"><div align="center">ลำดับ</div></td>
        <td width="40%" bgcolor="#CFCFCF"><div align="center">รายละเอียด</div></td>
        <td width="5%"  bgcolor="#CFCFCF"><div align="center">5</div></td>
        <td width="5%"  bgcolor="#CFCFCF"><div align="center">4</div></td>
        <td width="5%"  bgcolor="#CFCFCF"><div align="center">3</div></td>
        <td width="5%"  bgcolor="#CFCFCF"><div align="center">2</div></td>
        <td width="5%"  bgcolor="#CFCFCF"><div align="center">1</div></td>
      </tr>

      <tr>
        <td align="center"><span class="style39">1</span></td>
        <td ><div align="left"><span class="style39">พนักงานพูดจาสุภาพ อัธยาศัยดี แต่งกายสุภาพ วางตัวเหมาะสม</span></div></td>
        <td align="center"><input type="radio" name="sale_neat" value="5" required></td>
        <td align="center"><input type="radio" name="sale_neat" value="4" required></td>
        <td align="center"><input type="radio" name="sale_neat" value="3" required></td>
        <td align="center"><input type="radio" name="sale_neat" value="2" required></td>
        <td align="center"><input type="radio" name="sale_neat" value="1" required></td>
      </tr>

      <tr>
        <td align="center"><span class="style39">2</span></td>
        <td><div align="left"><span class="style39">พนักงานมีความรู้ความชำนาญในตัวสินค้า สามารถแนะนำ ตอบข้อซักถามได้ชัดเจน</span></div></td>
        <td align="center"><input type="radio" name="sale_data" value="5" required></td>
        <td align="center"><input type="radio" name="sale_data" value="4" required></td>
        <td align="center"><input type="radio" name="sale_data" value="3" required></td>
        <td align="center"><input type="radio" name="sale_data" value="2" required></td>
        <td align="center"><input type="radio" name="sale_data" value="1" required></td>
      </tr>

      <tr>
        <td align="center"><span class="style39">3</span></td>
        <td><div align="left"><span class="style39">พนักงานให้บริการด้วยความรวดเร็ว/เอาใจใส่ และเต็มใจให้บริการ</span></div></td>
        <td align="center"><input type="radio" name="sale_3" value="5" required></td>
        <td align="center"><input type="radio" name="sale_3" value="4" required></td>
        <td align="center"><input type="radio" name="sale_3" value="3" required></td>
        <td align="center"><input type="radio" name="sale_3" value="2" required></td>
        <td align="center"><input type="radio" name="sale_3" value="1" required></td>
      </tr>
    </table>
  </div>

  <fieldset><legend><b></b></legend>
    <label>ข้อเสนอแนะอื่นๆ :</label>
    <textarea name="suggest" class="button4" id="suggest" rows="3"></textarea>
  </fieldset>

  <!-- ===== ความพึงพอใจต่อสินค้า/ผลิตภัณฑ์ ===== -->
  <u>ความพึงพอใจต่อสินค้า/ผลิตภัณฑ์</u>
  <div class="table-responsive">
    <table border="1" class="w3-table" width="100%">
      <tr>
        <td width="5%"  bgcolor="#CFCFCF"><div align="center">ลำดับ</div></td>
        <td width="40%" bgcolor="#CFCFCF"><div align="center">รายละเอียด</div></td>
        <td width="5%"  bgcolor="#CFCFCF"><div align="center">5</div></td>
        <td width="5%"  bgcolor="#CFCFCF"><div align="center">4</div></td>
        <td width="5%"  bgcolor="#CFCFCF"><div align="center">3</div></td>
        <td width="5%"  bgcolor="#CFCFCF"><div align="center">2</div></td>
        <td width="5%"  bgcolor="#CFCFCF"><div align="center">1</div></td>
      </tr>

      <tr>
        <td align="center"><span class="style39">1</span></td>
        <td><div align="left"><span class="style39">สินค้าจริงตรงกับข้อมูลที่บริษัทให้ก่อนสั่งซื้อ และสามารถใช้งานได้อย่างมีประสิทธิภาพ</span></div></td>
        <td align="center"><input type="radio" name="product_good" value="5" required></td>
        <td align="center"><input type="radio" name="product_good" value="4" required></td>
        <td align="center"><input type="radio" name="product_good" value="3" required></td>
        <td align="center"><input type="radio" name="product_good" value="2" required></td>
        <td align="center"><input type="radio" name="product_good" value="1" required></td>
      </tr>

      <tr>
        <td align="center"><span class="style39">2</span></td>
        <td><div align="left"><span class="style39">ระดับคุณภาพสินค้าเมื่อเทียบกับบริษัทอื่นๆ</span></div></td>
        <td align="center"><input type="radio" name="product_link" value="5" required></td>
        <td align="center"><input type="radio" name="product_link" value="4" required></td>
        <td align="center"><input type="radio" name="product_link" value="3" required></td>
        <td align="center"><input type="radio" name="product_link" value="2" required></td>
        <td align="center"><input type="radio" name="product_link" value="1" required></td>
      </tr>

      <tr>
        <td align="center"><span class="style39">3</span></td>
        <td><div align="left"><span class="style39">ความพึงพอใจในสินค้าโดยรวม</span></div></td>
        <td align="center"><input type="radio" name="product_corect" value="5" required></td>
        <td align="center"><input type="radio" name="product_corect" value="4" required></td>
        <td align="center"><input type="radio" name="product_corect" value="3" required></td>
        <td align="center"><input type="radio" name="product_corect" value="2" required></td>
        <td align="center"><input type="radio" name="product_corect" value="1" required></td>
      </tr>
    </table>
  </div>

  <fieldset><legend><b></b></legend>
    <label>ข้อเสนอแนะอื่นๆ :</label>
    <textarea name="suggest_1" class="button4" id="suggest_1" rows="3"></textarea>
  </fieldset>

  <fieldset><legend><b></b></legend>
    <label><input type="checkbox" name="no_research" id="no_research" value="1" />
      <span style="color:red">ไม่ต้องทำแบบสอบถาม</span>
    </label>
  </fieldset>

  <p align="center">
    <input type="submit" name="button" id="button" value="Submit" class="button button3" />
  </p>

</div>
</form>

<div id="cr_bar"><?php include "foot.php"; ?></div>
</body>
</html>
