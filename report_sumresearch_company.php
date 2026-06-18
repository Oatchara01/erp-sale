<?php 
include('head1.php'); 
include "dbconnect_cs.php";
include "dbconnect.php";



function DateThai($strDate)
	{
		$strYear = date("Y",strtotime($strDate))+543;
		$strMonth= date("n",strtotime($strDate));
		$strDay= date("j",strtotime($strDate));
		$strHour= date("H",strtotime($strDate));
		$strMinute= date("i",strtotime($strDate));
		$strSeconds= date("s",strtotime($strDate));
		$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		$strMonthThai=$strMonthCut[$strMonth];
		return "$strDay $strMonthThai $strYear";
	}
?>
<link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/w32.css">
<style>
body, table, td, th {
    font-family: 'Prompt', sans-serif;
}

.style15{
    font-size:16px;
    color:#000;
}

.style30{
    font-size:13px;
}
</style>

<?php
date_default_timezone_set("Asia/Bangkok");

$start_date   = isset($_GET["start_date"]) ? $_GET["start_date"] : "";
$end_date     = isset($_GET["end_date"])   ? $_GET["end_date"]   : "";
$type_customer= isset($_GET["type_customer"]) ? $_GET["type_customer"] : "";
$type_cs      = isset($_GET["type_cs"]) ? $_GET["type_cs"] : "";

if($type_customer=='1'){
$type_cus ="Hospital";
$sale_ss = "sale_code IN ('S11','S12','S13','S14','S15','S16','S17','S21','S22','S24')";	
}else if($type_customer=='2'){
$type_cus ="Homecare";	
$sale_ss = "employee_name IN ('SOL1','SOL2','SOL3','SOL4','SOL5','SOL6','SOL7','SOL8')";		
}else if($type_customer=='3'){
$type_cus ="ศูนย์ผู้สูงอายุ,คลินิก";	
$sale_ss = "sale_code IN ('S33')";		
}


?>
<body>
<div class="w3-container w3-padding-large">
  <center>
    <span class="style15">รายงานสรุปความพึงพอใจลูกค้าหลังการขาย (ตามวันที่ส่งสินค้า)</span><br>
  
      <span class="style15"> วันที่ส่งสินค้า <?php echo DateThai($start_date); ?> ถึง  <?php echo DateThai($end_date); ?></span><br>
      <span class="style15"> กลุ่มลูกค้า :  <?php echo $type_cus; ?></span><br>
  </center>
  <br>

<?php	
if($type_cs=='1'){
?>
  <center><span class="style15">ความพึงพอใจต่อพนักงานขาย</span></center><br>
  <table border="1" width="100%" class="w3-table">
    <thead>
       <tr>
        <td class="style30" align="center">ลำดับ</td>
		  <td class="style30" align="center">วันที่ส่งสินค้า</td>
		   <td class="style30" align="center">วันที่ทำแบบสอบถาม</td> 
        <td class="style30" align="center">เลขที่เอกสาร</td>
        <td class="style30">รายชื่อลูกค้า</td>
        <td class="style30" align="center">เขตการขาย</td>
          <td class="style30" align="center">พนักงานพูดจาสุภาพ มีมารยาท และแต่งกายเหมาะสม</td>
          <td class="style30" align="center">มีความรู้ความเข้าใจเกี่ยวกับสินค้า สามารถให้คำแนะนำได้ชัดเจน</td>
          <td class="style30" align="center">แสดงความใส่ใจ ติดตามผล และให้ความช่วยเหลือหลังการขาย</td>
          <td class="style30" align="center">รวม (คะแนนเต็ม 5 คะแนน)</td>
          <td class="style30" align="center">%</td>
        <td class="style30" align="center">ตั้งแต่ 80% ขึ้นไป = P (F = ไม่ผ่าน)</td>
        <td class="style30">ข้อเสนอแนะ</td>
      </tr>
    </thead>
    <?php
	
     if($type_customer=='1' or $type_customer=='3'){	
	

$strSQL = "SELECT * FROM hos__so WHERE reseach_kk='1' and status_doc ='Approve' and $sale_ss";
if($start_date!="") $strSQL .= ' AND delivery_date >= "'.$start_date.'"';
if($end_date  !="") $strSQL .= ' AND delivery_date <= "'.$end_date.'"';

$q = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$n = 1;

/* ตัวแปรรวม */
$total_sum_sale = 0;
$total_percent = 0;
$total_eval_count = 0;

$total_customer = 0;          // จำนวนลูกค้าทั้งหมด
$total_customer_done = 0;     // จำนวนลูกค้าที่มีผลประเมินเป็นตัวเลข
$total_customer_pass80 = 0;   // จำนวนลูกค้าที่ได้ >= 80%

while($r = mysqli_fetch_array($q)){

    $strSQL1 = "SELECT * FROM tb_research WHERE red_id = '".$r["ref_id"]."' ";
    $objQuery1 = mysqli_query($com1,$strSQL1) or die(mysqli_error($com1));
    $objResult1 = mysqli_fetch_array($objQuery1);

    if ((empty($objResult1['date_sale']) || $objResult1['date_sale'] == '0000-00-00') && ($objResult1['sale_neat'] == '0' || $objResult1['sale_neat'] == '')) {
        $date_sale = "-";
    } elseif ($objResult1['sale_neat'] != '0' && !empty($objResult1['date_research']) && $objResult1['date_research'] != '0000-00-00') {
        $date_sale = Datethai($objResult1['date_research']);
    } elseif (!empty($objResult1['date_sale']) && $objResult1['date_sale'] != '0000-00-00') {
        $date_sale = Datethai($objResult1['date_sale']);
    } else {
        $date_sale = "-";
    }

    $delivery_date = Datethai($r['delivery_date']);
    $sale_neat = $objResult1["sale_neat"];
    $sale_data = $objResult1["sale_data"];
    $sale_3 = $objResult1["sale_3"];
    $suggest = $objResult1["suggest"];

    $total_customer++;

    // เช็กว่าทั้ง 3 ช่องเป็นตัวเลขหรือไม่
    $is_complete_eval =
        is_numeric($sale_neat) && $sale_neat !== '' &&
        is_numeric($sale_data) && $sale_data !== '' &&
        is_numeric($sale_3) && $sale_3 !== '';

    if($is_complete_eval){
        $sum_sale1 = $sale_neat + $sale_data + $sale_3;
        $sum_sale = number_format($sum_sale1 / 3, 2);
        $sale_percent_value = ($sum_sale1 * 100) / 15;
        $sale_persent = number_format($sale_percent_value, 2) . " %";
        $pass = ($sale_percent_value >= 80) ? "P" : "F";

        // สะสมค่ารวม
        $total_sum_sale += ($sum_sale1 / 3);
        $total_percent += $sale_percent_value;
        $total_eval_count++;

        $total_customer_done++;   // ลูกค้าที่ทำแบบประเมินแล้ว

        if($sale_percent_value >= 80){
            $total_customer_pass80++;
        }

    } else {
        $sum_sale = "-";
        $sale_persent = "-";
        $pass = "-";
    }

    $sale_neat_show = (empty($sale_neat) || $sale_neat == 0) ? "<span style='color:red;'>รอทำแบบประเมิน</span>" : $sale_neat;
    $sale_data_show = (empty($sale_data) || $sale_data == 0) ? "<span style='color:red;'>รอทำแบบประเมิน</span>" : $sale_data;
    $sale_3_show    = (empty($sale_3) || $sale_3 == 0) ? "<span style='color:red;'>รอทำแบบประเมิน</span>" : $sale_3;

    echo "<tr>
        <td class='style30' align='center'>".$n++."</td>
        <td class='style30' align='center'>".$delivery_date."</td>
        <td class='style30' align='center'>".$date_sale."</td>
        <td class='style30' align='center'>".$r['iv_no']."</td>
        <td class='style30'>".$r['bill_name']."</td>
        <td class='style30' align='center'>".$r['sale_code']."</td>
        <td class='style30' align='center'>".$sale_neat_show."</td>
        <td class='style30' align='center'>".$sale_data_show."</td>
        <td class='style30' align='center'>".$sale_3_show."</td>
        <td class='style30' align='center'>".$sum_sale."</td>
        <td class='style30' align='center'>".$sale_persent."</td>
        <td class='style30' align='center'>".$pass."</td>
        <td class='style30'>".$suggest."</td>
    </tr>";
}

/* คำนวณค่าเฉลี่ยรวม */
$avg_sum_sale = ($total_eval_count > 0) ? number_format($total_sum_sale / $total_eval_count, 2) : "-";
$avg_percent  = ($total_eval_count > 0) ? number_format($total_percent / $total_eval_count, 2)." %" : "-";

/* จำนวนลูกค้าที่ทำแบบประเมิน
   = จำนวนทั้งหมด - จำนวนที่ไม่เป็นตัวเลข */
$total_customer_not_done = $total_customer - $total_customer_done;

/* เปอร์เซ็นต์ผู้ที่ทำแบบประเมิน */
$percent_done = ($total_customer > 0)
    ? number_format(($total_customer_done * 100) / $total_customer, 2)." %"
    : "-";

/* แถวรวมค่าการประเมิน และเปอร์เซ็นต์ */
echo "<tr style='background:#eaf7ea;font-weight:bold;'>
    <td class='style30' colspan='9' align='right'>รวมค่าเฉลี่ยการประเมิน</td>
    <td class='style30' align='center'>".$avg_sum_sale."</td>
    <td class='style30' align='center'>".$avg_percent."</td>
    <td class='style30' align='center'>-</td>
    <td class='style30' align='center'>-</td>
</tr>";

echo "<tr style='background:#fdeaea;font-weight:bold;'>
    <td class='style30' colspan='9' align='right'>จำนวนลูกค้าที่ทำแบบประเมิน</td>
    <td class='style30' align='center' colspan='2'>".$total_customer_done." / ".$total_customer." ราย</td>
    <td class='style30' align='center' colspan='2'>".$percent_done."</td>
</tr>";

	 }else if($type_customer=='2'){
 
$strSQL = "SELECT * FROM so__main WHERE reseach_kk='1' and cancel_ckk='0' and approve_complete ='Approve' and $sale_ss";
if($start_date!="") $strSQL .= ' AND delivery_date >= "'.$start_date.'"';
if($end_date  !="") $strSQL .= ' AND delivery_date <= "'.$end_date.'"';

$q = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$n = 1;

/* ตัวแปรรวม */
$total_sum_sale = 0;
$total_percent = 0;
$total_eval_count = 0;

$total_customer = 0;          // จำนวนลูกค้าทั้งหมด
$total_customer_done = 0;     // จำนวนลูกค้าที่ทำแบบประเมินจริง
$total_customer_pass80 = 0;   // จำนวนลูกค้าที่ได้ >= 80%

while($r = mysqli_fetch_array($q)){

    $strSQL1 = "SELECT * FROM tb_research WHERE red_id = '".$r["ref_id"]."' ";
    $objQuery1 = mysqli_query($com1,$strSQL1) or die(mysqli_error($com1));
    $objResult1 = mysqli_fetch_array($objQuery1);

    if ((empty($objResult1['date_sale']) || $objResult1['date_sale'] == '0000-00-00') && ($objResult1['sale_neat'] == '0' || $objResult1['sale_neat'] == '')) {
        $date_sale = "-";
    } elseif ($objResult1['sale_neat'] != '0' && !empty($objResult1['date_research']) && $objResult1['date_research'] != '0000-00-00') {
        $date_sale = Datethai($objResult1['add_date1']);
    } elseif (!empty($objResult1['date_sale']) && $objResult1['date_sale'] != '0000-00-00') {
        $date_sale = Datethai($objResult1['date_sale']);
    } else {
        $date_sale = "-";
    }

    $delivery_date = Datethai($r['delivery_date']);
    $sale_neat = trim($objResult1["sale_neat"]);
    $sale_data = trim($objResult1["sale_data"]);
    $sale_3    = trim($objResult1["sale_3"]);
    $suggest   = $objResult1["suggest"];

    $total_customer++;

    // ต้องเป็นตัวเลข และต้องมากกว่า 0 ทุกช่อง จึงถือว่าทำแบบประเมินแล้ว
    $is_complete_eval =
        is_numeric($sale_neat) && $sale_neat > 0 &&
        is_numeric($sale_data) && $sale_data > 0 &&
        is_numeric($sale_3) && $sale_3 > 0;

    if($is_complete_eval){
        $sum_sale1 = $sale_neat + $sale_data + $sale_3;
        $sum_sale = number_format($sum_sale1 / 3, 2);
        $sale_percent_value = ($sum_sale1 * 100) / 15;
        $sale_persent = number_format($sale_percent_value, 2) . " %";
        $pass = ($sale_percent_value >= 80) ? "P" : "F";

        $total_sum_sale += ($sum_sale1 / 3);
        $total_percent += $sale_percent_value;
        $total_eval_count++;
        $total_customer_done++;

        if($sale_percent_value >= 80){
            $total_customer_pass80++;
        }

    } else {
        $sum_sale = "-";
        $sale_persent = "-";
        $pass = "-";
    }

    $sale_neat_show = (empty($sale_neat) || $sale_neat == 0) ? "<span style='color:red;'>รอทำแบบประเมิน</span>" : $sale_neat;
    $sale_data_show = (empty($sale_data) || $sale_data == 0) ? "<span style='color:red;'>รอทำแบบประเมิน</span>" : $sale_data;
    $sale_3_show    = (empty($sale_3) || $sale_3 == 0) ? "<span style='color:red;'>รอทำแบบประเมิน</span>" : $sale_3;

    echo "<tr>
        <td class='style30' align='center'>".$n++."</td>
        <td class='style30' align='center'>".$delivery_date."</td>
        <td class='style30' align='center'>".$date_sale."</td>
        <td class='style30' align='center'>".$r['doc_no']."</td>
        <td class='style30'>".$r['billing_name']."</td>
        <td class='style30' align='center'>".$r['employee_name']."</td>
        <td class='style30' align='center'>".$sale_neat_show."</td>
        <td class='style30' align='center'>".$sale_data_show."</td>
        <td class='style30' align='center'>".$sale_3_show."</td>
        <td class='style30' align='center'>".$sum_sale."</td>
        <td class='style30' align='center'>".$sale_persent."</td>
        <td class='style30' align='center'>".$pass."</td>
        <td class='style30'>".$suggest."</td>
    </tr>";
}

/* คำนวณค่าเฉลี่ยรวม */
$avg_sum_sale = ($total_eval_count > 0) ? number_format($total_sum_sale / $total_eval_count, 2) : "-";
$avg_percent  = ($total_eval_count > 0) ? number_format($total_percent / $total_eval_count, 2)." %" : "-";

/* เปอร์เซ็นต์ผู้ที่ทำแบบประเมิน */
$percent_done = ($total_customer > 0)
    ? number_format(($total_customer_done * 100) / $total_customer, 2)." %"
    : "-";

/* แถวรวมค่าการประเมิน และเปอร์เซ็นต์ */
echo "<tr style='background:#eaf7ea;font-weight:bold;'>
    <td class='style30' colspan='9' align='right'>รวมค่าเฉลี่ยการประเมิน</td>
    <td class='style30' align='center'>".$avg_sum_sale."</td>
    <td class='style30' align='center'>".$avg_percent."</td>
    <td class='style30' align='center'>-</td>
    <td class='style30' align='center'>-</td>
</tr>";

echo "<tr style='background:#fdeaea;font-weight:bold;'>
    <td class='style30' colspan='9' align='right'>จำนวนลูกค้าที่ทำแบบประเมิน</td>
    <td class='style30' align='center' colspan='2'>".$total_customer_done." / ".$total_customer." ราย</td>
    <td class='style30' align='center' colspan='2'>".$percent_done."</td>
</tr>";
		 
	} ?>
	  
  </table>
  <br>
<?php } ?>


	
<?php
// Product
if($type_cs=='2'){
?>
  <center><span class="style15">ความพึงพอใจต่อสินค้า / ผลิตภัณฑ์</span></center><br>
  <table border="1" width="100%" class="w3-table">
    <thead>
      <tr>
        <td class="style30" align="center">ลำดับ</td>
        <td class="style30" align="center">วันที่ส่งสินค้า</td>
        <td class="style30" align="center">วันที่ทำแบบสอบถาม</td>
        <td class="style30" align="center">เลขที่เอกสาร</td>
        <td class="style30">รายชื่อลูกค้า</td>
        <td class="style30" align="center">เขตการขาย</td>
        <td class="style30" align="center">สินค้าตรงตามข้อมูลที่ได้รับก่อนซื้อ และสามารถใช้งานอย่างมีประสิทธิภาพหรือไม่</td>
        <td class="style30" align="center">ความพึงพอใจโดยรวมที่มีต่อผลิตภัณฑ์สินค้าที่ได้รับ</td>
        <td class="style30" align="center">รวม (คะแนนเต็ม 5 คะแนน)</td>
        <td class="style30" align="center">%</td>
        <td class="style30" align="center">ตั้งแต่ 80% ขึ้นไป = P (F = ไม่ผ่าน)</td>
        <td class="style30">ข้อเสนอแนะ</td>
      </tr>
    </thead>
    <?php

    if($type_customer=='1' or $type_customer=='3'){

      $strSQL = "SELECT * FROM hos__so WHERE reseach_kk='1' and status_doc ='Approve' and $sale_ss";
if($start_date!="") $strSQL .= ' AND delivery_date >= "'.$start_date.'"';
if($end_date  !="") $strSQL .= ' AND delivery_date <= "'.$end_date.'"';
$strSQL .= " ORDER BY delivery_date ASC";

$q = mysqli_query($conn,$strSQL) or die("Error Query [".$strSQL."]");
$n = 1;

$total_sum_sale = 0;
$total_percent = 0;
$total_eval_count = 0;

$total_customer = 0;       // ลูกค้าทั้งหมด
$total_customer_done = 0;  // ทำแบบประเมินแล้ว
$total_customer_not_done = 0; // ยังไม่ทำ
$total_customer_pass80 = 0;

while($r = mysqli_fetch_array($q)){

    $strSQL1 = "SELECT * FROM tb_research WHERE red_id = '".$r["ref_id"]."' ";
    $objQuery1 = mysqli_query($com1,$strSQL1) or die(mysqli_error($com1));
    $objResult1 = mysqli_fetch_array($objQuery1);
	
	
/*$save19="UPDATE tb_research SET product_good ='5' where red_id = '".$r["ref_id"]."' and product_good='1' ";
$qsave19=mysqli_query($com1,$save19);
		  
$save19="UPDATE tb_research SET product_link ='5' where red_id = '".$r["ref_id"]."' and product_link='1' ";
$qsave19=mysqli_query($com1,$save19);*/


    if (empty($objResult1['product_date']) || $objResult1['product_date'] == '0000-00-00') {
        $date_sale = "-";
    } else {
        $date_sale = DateThai($objResult1['product_date']);
    }

    $delivery_date = DateThai($r['delivery_date']);
    $product_good = trim($objResult1["product_good"]);
    $product_link = trim($objResult1["product_link"]);
    $suggest_1 = $objResult1["suggest_1"];

    $total_customer++;

    // ถือว่าทำแบบประเมินแล้ว ก็ต่อเมื่อทั้ง 2 ช่องเป็นตัวเลขและมากกว่า 0
    $is_complete_eval =
        is_numeric($product_good) && $product_good > 0 &&
        is_numeric($product_link) && $product_link > 0;

    if($is_complete_eval){
        $sum_sale1 = $product_good + $product_link;
        $sum_sale = number_format($sum_sale1 / 2, 2);
        $sale_percent_value = ($sum_sale1 * 100) / 10;
        $sale_persent = number_format($sale_percent_value, 2) . " %";
        $pass = ($sale_percent_value >= 80) ? "P" : "F";

        $total_sum_sale += ($sum_sale1 / 2);
        $total_percent += $sale_percent_value;
        $total_eval_count++;
        $total_customer_done++;

        if($sale_percent_value >= 80){
            $total_customer_pass80++;
        }
    } else {
        $sum_sale = "-";
        $sale_persent = "-";
        $pass = "-";
        $total_customer_not_done++;
    }

    $product_good_show = (empty($product_good) || $product_good == 0)
        ? "<span style='color:red;'>รอทำแบบประเมิน</span>"
        : $product_good;

    $product_link_show = (empty($product_link) || $product_link == 0)
        ? "<span style='color:red;'>รอทำแบบประเมิน</span>"
        : $product_link;

    echo "<tr>
      <td class='style30' align='center'>".$n++."</td>
      <td class='style30' align='center'>".$delivery_date."</td>
      <td class='style30' align='center'>".$date_sale."</td>
      <td class='style30' align='center'>".$r['iv_no']."</td>
      <td class='style30'>".$r['bill_name']."</td>
      <td class='style30' align='center'>".$r['sale_code']."</td>
      <td class='style30' align='center'>".$product_good_show."</td>
      <td class='style30' align='center'>".$product_link_show."</td>
      <td class='style30' align='center'>".$sum_sale."</td>
      <td class='style30' align='center'>".$sale_persent."</td>
      <td class='style30' align='center'>".$pass."</td>
      <td class='style30'>".$suggest_1."</td>
    </tr>";
}

$avg_sum_sale = ($total_eval_count > 0) ? number_format($total_sum_sale / $total_eval_count, 2) : "-";
$avg_percent  = ($total_eval_count > 0) ? number_format($total_percent / $total_eval_count, 2)." %" : "-";

// เปอร์เซ็นต์ผู้ที่ทำแบบประเมินจากทั้งหมด
$percent_done = ($total_customer > 0)
    ? number_format(($total_customer_done * 100) / $total_customer, 2)." %"
    : "-";

// เปอร์เซ็นต์ผู้ที่ยังไม่ทำจากทั้งหมด
$percent_not_done = ($total_customer > 0)
    ? number_format(($total_customer_not_done * 100) / $total_customer, 2)." %"
    : "-";

echo "<tr style='background:#eaf7ea;font-weight:bold;'>
    <td class='style30' colspan='8' align='right'>รวมค่าเฉลี่ยการประเมิน</td>
    <td class='style30' align='center'>".$avg_sum_sale."</td>
    <td class='style30' align='center'>".$avg_percent."</td>
    <td class='style30' align='center'>-</td>
    <td class='style30' align='center'>-</td>
</tr>";

echo "<tr style='background:#fff7e6;font-weight:bold;'>
    <td class='style30' colspan='8' align='right'>จำนวนลูกค้าที่ทำแบบประเมิน</td>
    <td class='style30' align='center' colspan='2'>".$total_customer_done." / ".$total_customer." ราย</td>
    <td class='style30' align='center' colspan='2'>".$percent_done."</td>
</tr>";



    } else if($type_customer=='2'){

      $strSQL = "SELECT * FROM so__main WHERE reseach_kk='1' and cancel_ckk='0' and approve_complete ='Approve' and $sale_ss";
      if($start_date!="") $strSQL .= ' AND delivery_date >= "'.$start_date.'"';
      if($end_date  !="") $strSQL .= ' AND delivery_date <= "'.$end_date.'"';

      $q = mysqli_query($conn,$strSQL) or die("Error Query [".$strSQL."]");
      $n = 1;

      $total_sum_sale = 0;
      $total_percent = 0;
      $total_eval_count = 0;

      $total_customer = 0;
      $total_customer_done = 0;
      $total_customer_pass80 = 0;

      while($r = mysqli_fetch_array($q)){

        $strSQL1 = "SELECT * FROM tb_research WHERE red_id = '".$r["ref_id"]."' ";
        $objQuery1 = mysqli_query($com1,$strSQL1) or die(mysqli_error($com1));
        $objResult1 = mysqli_fetch_array($objQuery1);
		  
/*$save19="UPDATE tb_research SET product_good ='5' where red_id = '".$r["ref_id"]."' and product_good='10' ";
$qsave19=mysqli_query($com1,$save19);
		  
$save19="UPDATE tb_research SET product_link ='5' where red_id = '".$r["ref_id"]."' and product_link='10' ";
$qsave19=mysqli_query($com1,$save19);
		  
$save19="UPDATE tb_research SET product_good ='5' where red_id = '".$r["ref_id"]."' and product_good='1' ";
$qsave19=mysqli_query($com1,$save19);
		  
$save19="UPDATE tb_research SET product_link ='5' where red_id = '".$r["ref_id"]."' and product_link='1' ";
$qsave19=mysqli_query($com1,$save19);

$save19="UPDATE tb_research SET product_date ='".$objResult1['add_date1']."' where red_id = '".$r["ref_id"]."' ";
            $qsave19=mysqli_query($com1,$save19);
*/
		  
		  
        if (empty($objResult1['product_date']) || $objResult1['product_date'] == '0000-00-00') {
          $date_sale =  "-";
			
						
        } else {
          $date_sale = DateThai($objResult1['product_date']);
        }

        $delivery_date = DateThai($r['delivery_date']);
        $product_good = $objResult1["product_good"];
        $product_link = $objResult1["product_link"];
        $suggest_1 = $objResult1["suggest_1"];

        $total_customer++;

        $is_complete_eval =
          is_numeric($product_good) && $product_good !== '' &&
          is_numeric($product_link) && $product_link !== '';

        if($is_complete_eval){
          $sum_sale1 = $product_good + $product_link;
          $sum_sale = number_format($sum_sale1 / 2, 2);
          $sale_percent_value = ($sum_sale1 * 100) / 10;
          $sale_persent = number_format($sale_percent_value, 2) . " %";
          $pass = ($sale_percent_value >= 80) ? "P" : "F";

          $total_sum_sale += ($sum_sale1 / 2);
          $total_percent += $sale_percent_value;
          $total_eval_count++;
          $total_customer_done++;

          if($sale_percent_value >= 80){
            $total_customer_pass80++;
          }
        } else {
          $sum_sale = "-";
          $sale_persent = "-";
          $pass = "-";
        }

        $product_good_show = (empty($product_good) || $product_good == 0)
          ? "<span style='color:red;'>รอทำแบบประเมิน</span>"
          : $product_good;

        $product_link_show = (empty($product_link) || $product_link == 0)
          ? "<span style='color:red;'>รอทำแบบประเมิน</span>"
          : $product_link;

        echo "<tr>
          <td class='style30' align='center'>".$n++."</td>
          <td class='style30' align='center'>".$delivery_date."</td>
          <td class='style30' align='center'>".$date_sale."</td>
          <td class='style30' align='center'>".$r['doc_no']."</td>
          <td class='style30'>".$r['billing_name']."</td>
          <td class='style30' align='center'>".$r['employee_name']."</td>
          <td class='style30' align='center'>".$product_good_show."</td>
          <td class='style30' align='center'>".$product_link_show."</td>
          <td class='style30' align='center'>".$sum_sale."</td>
          <td class='style30' align='center'>".$sale_persent."</td>
          <td class='style30' align='center'>".$pass."</td>
          <td class='style30'>".$suggest_1."</td>
        </tr>";
      }

      $avg_sum_sale = ($total_eval_count > 0) ? number_format($total_sum_sale / $total_eval_count, 2) : "-";
$avg_percent  = ($total_eval_count > 0) ? number_format($total_percent / $total_eval_count, 2)." %" : "-";

// เปอร์เซ็นต์ผู้ที่ทำแบบประเมินจากทั้งหมด
$percent_done = ($total_customer > 0)
    ? number_format(($total_customer_done * 100) / $total_customer, 2)." %"
    : "-";

// เปอร์เซ็นต์ผู้ที่ยังไม่ทำจากทั้งหมด
$percent_not_done = ($total_customer > 0)
    ? number_format(($total_customer_not_done * 100) / $total_customer, 2)." %"
    : "-";

echo "<tr style='background:#eaf7ea;font-weight:bold;'>
    <td class='style30' colspan='8' align='right'>รวมค่าเฉลี่ยการประเมิน</td>
    <td class='style30' align='center'>".$avg_sum_sale."</td>
    <td class='style30' align='center'>".$avg_percent."</td>
    <td class='style30' align='center'>-</td>
    <td class='style30' align='center'>-</td>
</tr>";

echo "<tr style='background:#fff7e6;font-weight:bold;'>
    <td class='style30' colspan='8' align='right'>จำนวนลูกค้าที่ทำแบบประเมิน</td>
    <td class='style30' align='center' colspan='2'>".$total_customer_done." / ".$total_customer." ราย</td>
    <td class='style30' align='center' colspan='2'>".$percent_done."</td>
</tr>";

    }
    ?>
  </table>
  <br>
<?php } ?>
	
	
	
	
	
	
	
<?php
// จัดส่ง
if($type_cs=='3' or $type_cs=='4'){
?>
  <center><span class="style15">การสอบถามความพึงพอใจของลูกค้าที่มีต่อการบริการจัดส่ง <?php if($type_cs=='4'){ echo "(ขนส่งนอก)"; } ?></span></center><br>
  <table border="1" width="100%" class="w3-table">
    <thead>
      <tr>
        <td class="style30" align="center">ลำดับ</td>
        <td class="style30" align="center">วันที่ส่งสินค้า</td>
        <td class="style30" align="center">วันที่ทำแบบสอบถาม</td>
        <td class="style30" align="center">เลขที่เอกสาร</td>
        <td class="style30">รายชื่อลูกค้า</td>
        <td class="style30" align="center">เขตการขาย</td>
        <td class="style30" align="center">พนักงานจัดส่งมีความสุภาพ แต่งกายเหมาะสม และปฏิบัติตามมาตรการความปลอดภัย</td>
        <td class="style30" align="center">การจัดส่งตรงเวลา พร้อมบริการติดตั้ง/สาธิตการใช้งานสินค้า</td>
        <td class="style30" align="center">มีการประสานงานก่อนส่ง และดูแลจนถึงการส่งมอบเรียบร้อย</td>
        <td class="style30" align="center">รวม (คะแนนเต็ม 5 คะแนน)</td>
        <td class="style30" align="center">%</td>
        <td class="style30" align="center">ตั้งแต่ 80% ขึ้นไป = P (F = ไม่ผ่าน)</td>
        <td class="style30">ข้อเสนอแนะ</td>
      </tr>
    </thead>
    <tbody>
<?php
	
if($type_cs=='3'){	
$out_ckk ="and out_ckk='0'";	
}else if($type_cs=='4'){
$out_ckk ="and out_ckk='1'";		
}

if($type_customer=='1' or $type_customer=='3'){

    $strSQL = "SELECT * FROM hos__so WHERE reseach_kk='1' and status_doc='Approve' and $sale_ss";
    if($start_date!="") $strSQL .= ' AND delivery_date >= "'.$start_date.'"';
    if($end_date!="")  $strSQL .= ' AND delivery_date <= "'.$end_date.'"';
    $strSQL .= " ORDER BY delivery_date ASC";

    $q = mysqli_query($conn, $strSQL) or die("Error Query [".$strSQL."]");
    $n = 1;

    $total_sum_sale = 0;
    $total_percent = 0;
    $total_eval_count = 0;

    $total_customer = 0;
    $total_customer_done = 0;
    $total_customer_not_done = 0;
    $total_customer_pass80 = 0;

    while($r = mysqli_fetch_array($q)){

        $strSQL1 = "SELECT * FROM tb_research WHERE red_id = '".$r["ref_id"]."' $out_ckk";
        $objQuery1 = mysqli_query($com1, $strSQL1) or die(mysqli_error($com1));
        $Num_Rows1 = mysqli_num_rows($objQuery1);
        $objResult1 = mysqli_fetch_array($objQuery1);

        if($Num_Rows1 > 0){


            $delivery_date = (!empty($r['delivery_date']) && $r['delivery_date'] != '0000-00-00')
                ? DateThai($r['delivery_date'])
                : "-";

            $cs_neat = trim($objResult1["cs_neat"]);
            $cs_explain = trim($objResult1["cs_explain"]);
            $cs_3 = trim($objResult1["cs_3"]);
            $suggest_2 = $objResult1["suggest_2"];

            $total_customer++;

            $is_complete_eval =
                is_numeric($cs_neat) && $cs_neat > 0 &&
                is_numeric($cs_explain) && $cs_explain > 0 &&
                is_numeric($cs_3) && $cs_3 > 0;

            if($is_complete_eval){
                // 3 หัวข้อ ๆ ละ 5 คะแนน = เต็ม 15
                $sum_sale1 = $cs_neat + $cs_explain + $cs_3;
                $sum_sale = number_format($sum_sale1 / 3, 2); // ค่าเฉลี่ยจาก 3 ข้อ เต็ม 5
                $sale_percent_value = ($sum_sale1 * 100) / 15;
                $sale_persent = number_format($sale_percent_value, 2) . " %";
                $pass = ($sale_percent_value >= 80) ? "P" : "F";

                $total_sum_sale += ($sum_sale1 / 3);
                $total_percent += $sale_percent_value;
                $total_eval_count++;
                $total_customer_done++;

                if($sale_percent_value >= 80){
                    $total_customer_pass80++;
                }
            } else {
                $sum_sale = "-";
                $sale_persent = "-";
                $pass = "-";
                $total_customer_not_done++;
            }

						if (
    $is_complete_eval &&
    !empty($objResult1['date_research']) &&
    $objResult1['date_research'] != '0000-00-00' &&
    $objResult1['date_research'] != '0000-00-00 00:00:00'
) {
    $date_sale = DateThai(date('Y-m-d', strtotime($objResult1['date_research'])));
} else {
    $date_sale = "-";
}
	
			
			
            $cs_neat_show = (empty($cs_neat) || $cs_neat == 0)
                ? "<span style='color:red;'>รอทำแบบประเมิน</span>"
                : $cs_neat;

            $cs_explain_show = (empty($cs_explain) || $cs_explain == 0)
                ? "<span style='color:red;'>รอทำแบบประเมิน</span>"
                : $cs_explain;

            $cs_3_show = (empty($cs_3) || $cs_3 == 0)
                ? "<span style='color:red;'>รอทำแบบประเมิน</span>"
                : $cs_3;

            echo "<tr>
                <td class='style30' align='center'>".$n++."</td>
                <td class='style30' align='center'>".$delivery_date."</td>
                <td class='style30' align='center'>".$date_sale."</td>
                <td class='style30' align='center'>".$r['iv_no']."</td>
                <td class='style30'>".$r['bill_name']."</td>
                <td class='style30' align='center'>".$r['sale_code']."</td>
                <td class='style30' align='center'>".$cs_neat_show."</td>
                <td class='style30' align='center'>".$cs_explain_show."</td>
                <td class='style30' align='center'>".$cs_3_show."</td>
                <td class='style30' align='center'>".$sum_sale."</td>
                <td class='style30' align='center'>".$sale_persent."</td>
                <td class='style30' align='center'>".$pass."</td>
                <td class='style30'>".$suggest_2."</td>
            </tr>";
        }
    }

    $avg_sum_sale = ($total_eval_count > 0) ? number_format($total_sum_sale / $total_eval_count, 2) : "-";
    $avg_percent  = ($total_eval_count > 0) ? number_format($total_percent / $total_eval_count, 2)." %" : "-";

    $percent_done = ($total_customer > 0)
        ? number_format(($total_customer_done * 100) / $total_customer, 2)." %"
        : "-";

    $percent_not_done = ($total_customer > 0)
        ? number_format(($total_customer_not_done * 100) / $total_customer, 2)." %"
        : "-";

    echo "<tr style='background:#eaf7ea;font-weight:bold;'>
        <td class='style30' colspan='9' align='right'>รวมค่าเฉลี่ยการประเมิน</td>
        <td class='style30' align='center'>".$avg_sum_sale."</td>
        <td class='style30' align='center'>".$avg_percent."</td>
        <td class='style30' align='center'>-</td>
        <td class='style30' align='center'>-</td>
    </tr>";

    echo "<tr style='background:#fff7e6;font-weight:bold;'>
        <td class='style30' colspan='9' align='right'>จำนวนลูกค้าที่ทำแบบประเมิน</td>
        <td class='style30' align='center' colspan='2'>".$total_customer_done." / ".$total_customer." ราย</td>
        <td class='style30' align='center' colspan='2'>".$percent_done."</td>
    </tr>";

   
} else if($type_customer=='2'){

    $strSQL = "SELECT * FROM so__main WHERE reseach_kk='1' and cancel_ckk='0' and approve_complete='Approve' and $sale_ss";
    if($start_date!="") $strSQL .= ' AND delivery_date >= "'.$start_date.'"';
    if($end_date!="")  $strSQL .= ' AND delivery_date <= "'.$end_date.'"';
    $strSQL .= " ORDER BY delivery_date ASC";

    $q = mysqli_query($conn, $strSQL) or die("Error Query [".$strSQL."]");
    $n = 1;

    $total_sum_sale = 0;
    $total_percent = 0;
    $total_eval_count = 0;

    $total_customer = 0;
    $total_customer_done = 0;
    $total_customer_not_done = 0;
    $total_customer_pass80 = 0;

    while($r = mysqli_fetch_array($q)){

        $strSQL1 = "SELECT * FROM tb_research WHERE red_id = '".$r["ref_id"]."'  $out_ckk ";
        $objQuery1 = mysqli_query($com1, $strSQL1) or die(mysqli_error($com1));
        $Num_Rows1 = mysqli_num_rows($objQuery1);
        $objResult1 = mysqli_fetch_array($objQuery1);

        if($Num_Rows1 > 0){




            $delivery_date = (!empty($r['delivery_date']) && $r['delivery_date'] != '0000-00-00')
                ? DateThai($r['delivery_date'])
                : "-";

            $cs_neat = trim($objResult1["cs_neat"]);
            $cs_explain = trim($objResult1["cs_explain"]);
            $cs_3 = trim($objResult1["cs_3"]);
            $suggest_2 = $objResult1["suggest_2"];

            $total_customer++;

            $is_complete_eval =
                is_numeric($cs_neat) && $cs_neat > 0 &&
                is_numeric($cs_explain) && $cs_explain > 0 &&
                is_numeric($cs_3) && $cs_3 > 0;

            if($is_complete_eval){
                $sum_sale1 = $cs_neat + $cs_explain + $cs_3;
                $sum_sale = number_format($sum_sale1 / 3, 2);
                $sale_percent_value = ($sum_sale1 * 100) / 15;
                $sale_persent = number_format($sale_percent_value, 2) . " %";
                $pass = ($sale_percent_value >= 80) ? "P" : "F";

                $total_sum_sale += ($sum_sale1 / 3);
                $total_percent += $sale_percent_value;
                $total_eval_count++;
                $total_customer_done++;

                if($sale_percent_value >= 80){
                    $total_customer_pass80++;
                }
            } else {
                $sum_sale = "-";
                $sale_persent = "-";
                $pass = "-";
                $total_customer_not_done++;
            }

			
			if (
    $is_complete_eval &&
    !empty($objResult1['date_research']) &&
    $objResult1['date_research'] != '0000-00-00' &&
    $objResult1['date_research'] != '0000-00-00 00:00:00'
) {
    $date_sale = DateThai(date('Y-m-d', strtotime($objResult1['date_research'])));
} else {
    $date_sale = "-";
}
			
			
            $cs_neat_show = (empty($cs_neat) || $cs_neat == 0)
                ? "<span style='color:red;'>รอทำแบบประเมิน</span>"
                : $cs_neat;

            $cs_explain_show = (empty($cs_explain) || $cs_explain == 0)
                ? "<span style='color:red;'>รอทำแบบประเมิน</span>"
                : $cs_explain;

            $cs_3_show = (empty($cs_3) || $cs_3 == 0)
                ? "<span style='color:red;'>รอทำแบบประเมิน</span>"
                : $cs_3;

            echo "<tr>
                <td class='style30' align='center'>".$n++."</td>
                <td class='style30' align='center'>".$delivery_date."</td>
                <td class='style30' align='center'>".$date_sale."</td>
                <td class='style30' align='center'>".$r['doc_no']."</td>
                <td class='style30'>".$r['billing_name']."</td>
                <td class='style30' align='center'>".$r['employee_name']."</td>
                <td class='style30' align='center'>".$cs_neat_show."</td>
                <td class='style30' align='center'>".$cs_explain_show."</td>
                <td class='style30' align='center'>".$cs_3_show."</td>
                <td class='style30' align='center'>".$sum_sale."</td>
                <td class='style30' align='center'>".$sale_persent."</td>
                <td class='style30' align='center'>".$pass."</td>
                <td class='style30'>".$suggest_2."</td>
            </tr>";
        }
    }

    $avg_sum_sale = ($total_eval_count > 0) ? number_format($total_sum_sale / $total_eval_count, 2) : "-";
    $avg_percent  = ($total_eval_count > 0) ? number_format($total_percent / $total_eval_count, 2)." %" : "-";

    $percent_done = ($total_customer > 0)
        ? number_format(($total_customer_done * 100) / $total_customer, 2)." %"
        : "-";

    $percent_not_done = ($total_customer > 0)
        ? number_format(($total_customer_not_done * 100) / $total_customer, 2)." %"
        : "-";

    echo "<tr style='background:#eaf7ea;font-weight:bold;'>
        <td class='style30' colspan='9' align='right'>รวมค่าเฉลี่ยการประเมิน</td>
        <td class='style30' align='center'>".$avg_sum_sale."</td>
        <td class='style30' align='center'>".$avg_percent."</td>
        <td class='style30' align='center'>-</td>
        <td class='style30' align='center'>-</td>
    </tr>";

    echo "<tr style='background:#fff7e6;font-weight:bold;'>
        <td class='style30' colspan='9' align='right'>จำนวนลูกค้าที่ทำแบบประเมิน</td>
        <td class='style30' align='center' colspan='2'>".$total_customer_done." / ".$total_customer." ราย</td>
        <td class='style30' align='center' colspan='2'>".$percent_done."</td>
    </tr>";

  
}
?>
    </tbody>
  </table>
  <br>
<?php } ?>
		
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
<?php
// Product
if($type_cs=='5'){
?>
  <center><span class="style15"> การสอบถามความภักดีของลูกค้า (NPS)</span></center><br>
  <table border="1" width="100%" class="w3-table">
    <thead>
      <tr>
        <td class="style30" align="center">ลำดับ</td>
        <td class="style30" align="center">วันที่ส่งสินค้า</td>
        <td class="style30" align="center">วันที่ทำแบบสอบถาม</td>
        <td class="style30" align="center">เลขที่เอกสาร</td>
        <td class="style30">รายชื่อลูกค้า</td>
        <td class="style30" align="center">เขตการขาย</td>
        <td class="style30" align="center">คุณลูกค้ามีความตั้งใจที่จะแนะนำบริษัทให้ผู้อื่น มากน้อยเพียงใด</td>
        <td class="style30" align="center">รวม (คะแนนเต็ม 5 คะแนน)</td>
        <td class="style30" align="center">%</td>
        <td class="style30" align="center">ตั้งแต่ 80% ขึ้นไป = P (F = ไม่ผ่าน)</td>
        <td class="style30">ข้อเสนอแนะ</td>
      </tr>
    </thead>
    <?php

if($type_customer=='1' or $type_customer=='3'){

    $strSQL = "SELECT * FROM hos__so WHERE reseach_kk='1' and status_doc ='Approve' and $sale_ss";
    if($start_date!="") $strSQL .= ' AND delivery_date >= "'.$start_date.'"';
    if($end_date  !="") $strSQL .= ' AND delivery_date <= "'.$end_date.'"';
    $strSQL .= " ORDER BY delivery_date ASC";

    $q = mysqli_query($conn,$strSQL) or die("Error Query [".$strSQL."]");
    $n = 1;

    $total_sum_sale = 0;
    $total_percent = 0;
    $total_eval_count = 0;

    $total_customer = 0;
    $total_customer_done = 0;
    $total_customer_not_done = 0;
    $total_customer_pass80 = 0;

    while($r = mysqli_fetch_array($q)){

        $strSQL1 = "SELECT * FROM tb_research WHERE red_id = '".$r["ref_id"]."' ";
        $objQuery1 = mysqli_query($com1,$strSQL1) or die(mysqli_error($com1));
        $objResult1 = mysqli_fetch_array($objQuery1);
		
		//$save19="UPDATE tb_research SET cus_1 ='5' where red_id = '".$r["ref_id"]."' and cus_1='1' ";
        //$qsave19=mysqli_query($com1,$save19);


        if (empty($objResult1['cust_date']) || $objResult1['cust_date'] == '0000-00-00') {
            $date_sale = "-";
        } else {
            $date_sale = DateThai($objResult1['cust_date']);
        }

        $delivery_date = DateThai($r['delivery_date']);
        $cus_1 = trim($objResult1["cus_1"]);
        $suggest_cus = $objResult1["suggest_cus"];

        $total_customer++;

        // ถือว่าทำแบบประเมินแล้ว เมื่อ cus_1 เป็นตัวเลขและมากกว่า 0
        $is_complete_eval = is_numeric($cus_1) && $cus_1 > 0;

        if($is_complete_eval){
            $sum_sale1 = $cus_1;
            $sum_sale = number_format($sum_sale1, 2);
            $sale_percent_value = ($sum_sale1 * 100) / 5;
            $sale_persent = number_format($sale_percent_value, 2) . " %";
            $pass = ($sale_percent_value >= 80) ? "P" : "F";

            $total_sum_sale += $sum_sale1;
            $total_percent += $sale_percent_value;
            $total_eval_count++;
            $total_customer_done++;

            if($sale_percent_value >= 80){
                $total_customer_pass80++;
            }
        } else {
            $sum_sale = "-";
            $sale_persent = "-";
            $pass = "-";
            $total_customer_not_done++;
        }

        $cus_1_show = (empty($cus_1) || $cus_1 == 0)
            ? "<span style='color:red;'>รอทำแบบประเมิน</span>"
            : $cus_1;

        echo "<tr>
          <td class='style30' align='center'>".$n++."</td>
          <td class='style30' align='center'>".$delivery_date."</td>
          <td class='style30' align='center'>".$date_sale."</td>
          <td class='style30' align='center'>".$r['iv_no']."</td>
          <td class='style30'>".$r['bill_name']."</td>
          <td class='style30' align='center'>".$r['sale_code']."</td>
          <td class='style30' align='center'>".$cus_1_show."</td>
          <td class='style30' align='center'>".$sum_sale."</td>
          <td class='style30' align='center'>".$sale_persent."</td>
          <td class='style30' align='center'>".$pass."</td>
          <td class='style30'>".$suggest_cus."</td>
        </tr>";
    }

    $avg_sum_sale = ($total_eval_count > 0) ? number_format($total_sum_sale / $total_eval_count, 2) : "-";
    $avg_percent  = ($total_eval_count > 0) ? number_format($total_percent / $total_eval_count, 2)." %" : "-";

    $percent_done = ($total_customer > 0)
        ? number_format(($total_customer_done * 100) / $total_customer, 2)." %"
        : "-";

    $percent_not_done = ($total_customer > 0)
        ? number_format(($total_customer_not_done * 100) / $total_customer, 2)." %"
        : "-";

    echo "<tr style='background:#eaf7ea;font-weight:bold;'>
        <td class='style30' colspan='7' align='right'>รวมค่าเฉลี่ยการประเมิน</td>
        <td class='style30' align='center'>".$avg_sum_sale."</td>
        <td class='style30' align='center'>".$avg_percent."</td>
        <td class='style30' align='center'>-</td>
        <td class='style30' align='center'>-</td>
    </tr>";

    echo "<tr style='background:#fff7e6;font-weight:bold;'>
        <td class='style30' colspan='7' align='right'>จำนวนลูกค้าที่ทำแบบประเมิน</td>
        <td class='style30' align='center' colspan='2'>".$total_customer_done." / ".$total_customer." ราย</td>
        <td class='style30' align='center' colspan='2'>".$percent_done."</td>
    </tr>";


} else if($type_customer=='2'){

    $strSQL = "SELECT * FROM so__main WHERE reseach_kk='1' and cancel_ckk='0' and approve_complete ='Approve' and $sale_ss";
    if($start_date!="") $strSQL .= ' AND delivery_date >= "'.$start_date.'"';
    if($end_date  !="") $strSQL .= ' AND delivery_date <= "'.$end_date.'"';
    $strSQL .= " ORDER BY delivery_date ASC";

    $q = mysqli_query($conn,$strSQL) or die("Error Query [".$strSQL."]");
    $n = 1;

    $total_sum_sale = 0;
    $total_percent = 0;
    $total_eval_count = 0;

    $total_customer = 0;
    $total_customer_done = 0;
    $total_customer_not_done = 0;
    $total_customer_pass80 = 0;

    while($r = mysqli_fetch_array($q)){

        $strSQL1 = "SELECT * FROM tb_research WHERE red_id = '".$r["ref_id"]."' ";
        $objQuery1 = mysqli_query($com1,$strSQL1) or die(mysqli_error($com1));
        $objResult1 = mysqli_fetch_array($objQuery1);
		
		//$save19="UPDATE tb_research SET cus_1 ='5' where red_id = '".$r["ref_id"]."' and cus_1='1' ";
        //$qsave19=mysqli_query($com1,$save19);

        if (empty($objResult1['cust_date']) || $objResult1['cust_date'] == '0000-00-00') {
            $date_sale = "-";
        } else {
            $date_sale = DateThai($objResult1['cust_date']);
        }

        $delivery_date = DateThai($r['delivery_date']);
        $cus_1 = trim($objResult1["cus_1"]);
        $suggest_cus = $objResult1["suggest_cus"];

        $total_customer++;

        $is_complete_eval = is_numeric($cus_1) && $cus_1 > 0;

        if($is_complete_eval){
            $sum_sale1 = $cus_1;
            $sum_sale = number_format($sum_sale1, 2);
            $sale_percent_value = ($sum_sale1 * 100) / 5;
            $sale_persent = number_format($sale_percent_value, 2) . " %";
            $pass = ($sale_percent_value >= 80) ? "P" : "F";

            $total_sum_sale += $sum_sale1;
            $total_percent += $sale_percent_value;
            $total_eval_count++;
            $total_customer_done++;

            if($sale_percent_value >= 80){
                $total_customer_pass80++;
            }
        } else {
            $sum_sale = "-";
            $sale_persent = "-";
            $pass = "-";
            $total_customer_not_done++;
        }

        $cus_1_show = (empty($cus_1) || $cus_1 == 0)
            ? "<span style='color:red;'>รอทำแบบประเมิน</span>"
            : $cus_1;

        echo "<tr>
          <td class='style30' align='center'>".$n++."</td>
          <td class='style30' align='center'>".$delivery_date."</td>
          <td class='style30' align='center'>".$date_sale."</td>
          <td class='style30' align='center'>".$r['doc_no']."</td>
          <td class='style30'>".$r['billing_name']."</td>
          <td class='style30' align='center'>".$r['employee_name']."</td>
          <td class='style30' align='center'>".$cus_1_show."</td>
          <td class='style30' align='center'>".$sum_sale."</td>
          <td class='style30' align='center'>".$sale_persent."</td>
          <td class='style30' align='center'>".$pass."</td>
          <td class='style30'>".$suggest_cus."</td>
        </tr>";
    }

    $avg_sum_sale = ($total_eval_count > 0) ? number_format($total_sum_sale / $total_eval_count, 2) : "-";
    $avg_percent  = ($total_eval_count > 0) ? number_format($total_percent / $total_eval_count, 2)." %" : "-";

    $percent_done = ($total_customer > 0)
        ? number_format(($total_customer_done * 100) / $total_customer, 2)." %"
        : "-";

    $percent_not_done = ($total_customer > 0)
        ? number_format(($total_customer_not_done * 100) / $total_customer, 2)." %"
        : "-";

    echo "<tr style='background:#eaf7ea;font-weight:bold;'>
        <td class='style30' colspan='7' align='right'>รวมค่าเฉลี่ยการประเมิน</td>
        <td class='style30' align='center'>".$avg_sum_sale."</td>
        <td class='style30' align='center'>".$avg_percent."</td>
        <td class='style30' align='center'>-</td>
        <td class='style30' align='center'>-</td>
    </tr>";

    echo "<tr style='background:#fff7e6;font-weight:bold;'>
        <td class='style30' colspan='7' align='right'>จำนวนลูกค้าที่ทำแบบประเมิน</td>
        <td class='style30' align='center' colspan='2'>".$total_customer_done." / ".$total_customer." ราย</td>
        <td class='style30' align='center' colspan='2'>".$percent_done."</td>
    </tr>";

 
}
?>
  </table>
  <br>
<?php } ?>	
</div>
</body>
</html>
