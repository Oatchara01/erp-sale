<?php 
include('head1.php'); 
include "dbconnect_cs.php";
?>
<link rel="stylesheet" href="css/w32.css">
<style>
  .style15{font-size:16px;color:#000}
  .style30{font-size:13px}
  .groupcell{
    font-weight:bold; text-align:center; background:#f3f6ff; border:2px solid #99b3ff;
  }
</style>

<?php
date_default_timezone_set("Asia/Bangkok");

$start_date   = isset($_GET["start_date"]) ? $_GET["start_date"] : "";
$end_date     = isset($_GET["end_date"])   ? $_GET["end_date"]   : "";
$type_customer= isset($_GET["type_customer"]) ? $_GET["type_customer"] : "";
$type_cs      = isset($_GET["type_cs"]) ? $_GET["type_cs"] : "";

/** แปลงวันที่จาก YYYY-MM-DD หรือ DD/MM/YYYY (รองรับปี พ.ศ.) -> Y-m-d (ค.ศ.) */
function normalize_to_gregorian_ymd($date_str){
  if(!$date_str) return "";
  $date_str = trim($date_str);
  if(preg_match('/^(\d{4})-(\d{1,2})-(\d{1,2})$/',$date_str,$m)){
    $y=(int)$m[1]; $mo=(int)$m[2]; $d=(int)$m[3]; if($y>2400)$y-=543;
    return sprintf('%04d-%02d-%02d',$y,$mo,$d);
  }
  if(preg_match('/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/',$date_str,$m)){
    $d=(int)$m[1]; $mo=(int)$m[2]; $y=(int)$m[3]; if($y>2400)$y-=543;
    return sprintf('%04d-%02d-%02d',$y,$mo,$d);
  }
  return "";
}

// === ใช้ “แบบใหม่ 3 ข้อ/ส่วน (สูงสุด 5 คะแนนต่อข้อ)” ตั้งแต่ 1/10/2568 เป็นต้นไป ===
$cutover_greg   = '2025-10-01'; // = 1/10/2568
$start_greg     = normalize_to_gregorian_ymd($start_date);
$use_new_survey = ($start_greg !== "" && strtotime($start_greg) >= strtotime($cutover_greg));

/** หัวเดือน/ปีไทย */
$_month_name = ["01"=>"มกราคม","02"=>"กุมภาพันธ์","03"=>"มีนาคม","04"=>"เมษายน","05"=>"พฤษภาคม","06"=>"มิถุนายน","07"=>"กรกฎาคม","08"=>"สิงหาคม","09"=>"กันยายน","10"=>"ตุลาคม","11"=>"พฤศจิกายน","12"=>"ธันวาคม"];
$thai=""; $year="";
if($start_greg!==""){
  $mm = substr($start_greg,5,2); $yy = (int)substr($start_greg,0,4);
  $thai = $_month_name[$mm] ?? ""; $year = $yy+543;
}

/** ===================== ฟังก์ชันที่ขาด (สำคัญ) ===================== */
/** แถวกรอบครอบ 1 กลุ่ม (ใช้ในแต่ละส่วนเวลาเลือก type_cs) */
function render_group_row_single($before_cols, $group_cols, $label, $after_cols=0){
  echo "<tr>";
  if($before_cols>0) echo '<td colspan="'.$before_cols.'"></td>';
  echo '<td class="groupcell" colspan="'.$group_cols.'">'.$label.'</td>';
  if($after_cols>0) echo '<td colspan="'.$after_cols.'"></td>';
  echo "</tr>";
}

/** คำนวณค่าเฉลี่ยเต็ม 5 และเปอร์เซ็นต์ (ใช้ในแต่ละส่วนเวลาเลือก type_cs) */
function calc_avg_and_percent_5($scores){
  $count = max(count($scores),1);
  $sum = array_sum($scores);
  $avg = $sum / $count;                 // 1–5
  $percent = ($sum * 100) / (5 * $count);
  return [number_format($avg,2), number_format($percent,2)];
}

/** แถวกรอบครอบหลายกลุ่ม (ใช้ในตารางรวม ไม่บังคับ type_cs) */
function render_group_row_multi($before_cols, $groups /* [[colspan,label],...] */){
  echo "<tr>";
  if($before_cols>0) echo '<td colspan="'.$before_cols.'"></td>';
  foreach($groups as $g){
    echo '<td class="groupcell" colspan="'.$g[0].'">'.$g[1].'</td>';
  }
  echo "</tr>";
}
?>
<body>
<div class="w3-container w3-padding-large">
  <center>
    <span class="style15">รายงานสรุปความพึงพอใจลูกค้าหลังการขาย</span><br>
    <?php if($thai && $year){ ?>
      <span class="style15">สรุปผลความพึงพอใจลูกค้าหลังการขาย <?php echo $thai;?> ประจำปี <?php echo $year;?></span>
    <?php } ?>
  </center>
  <br>

<?php	
/* ======================= ส่วนที่ 1: พนักงานขาย ======================= */
if($type_cs=='1'){
?>
  <center><span class="style15">ความพึงพอใจต่อพนักงานขาย</span></center><br>
  <table border="1" width="100%" class="w3-table">
    <thead>
      <?php
        $show_sale4 = ($type_customer!='type_customer'); // ใช้ข้อที่ 4 ในแบบเดิมเท่านั้น
        $qcols = $use_new_survey ? 3 : ($show_sale4 ? 4 : 3);
        render_group_row_single(4, $qcols, 'ความพึงพอใจต่อพนักงานขาย', 4);
      ?>
      <tr>
        <td class="style30" align="center">ลำดับ</td>
        <td class="style30" align="center">เลขที่เอกสาร</td>
        <td class="style30">รายชื่อลูกค้า</td>
        <td class="style30" align="center">เขตการขาย</td>

        <?php if($use_new_survey){ ?>
          <!-- แบบใหม่: 3 ข้อ -->
          <td class="style30" align="center">พนักงานพูดจาสุภาพ มีมารยาท และแต่งกายเหมาะสม</td>
          <td class="style30" align="center">มีความรู้ความเข้าใจเกี่ยวกับสินค้า สามารถให้คำแนะนำและตอบข้อซักถามได้ชัดเจน</td>
          <td class="style30" align="center">แสดงความจริงใจ เอาใจใส่/ติดตามผล และให้ความช่วยเหลือหลังการขาย</td>
          <td class="style30" align="center">รวม (คะแนนเต็ม 5 คะแนน)</td>
        <?php } else { ?>
          <!-- แบบเดิม -->
          <td class="style30" align="center">พนักงานขายกิริยามารยาทเรียบร้อย พูดจาสุภาพ อัธยาศัยดี วางตัวเหมาะสม</td>
          <td class="style30" align="center">พนักงานขายมีความรู้ความชำนาญในตัวสินค้า สามารถแนะนำ ตอบข้อซักถามได้ชัดเจน</td> 
          <td class="style30" align="center">พนักงานขายบริการด้วยความรวดเร็ว/เอาใจใส่ และมีความเต็มใจให้บริการ</td>
          <?php if($show_sale4){ ?>
            <td class="style30" align="center">การติดต่อพนักงานขายในช่องทางต่างๆ รวดเร็ว และมีประสิทธิภาพ</td>
          <?php } ?>
          <td class="style30" align="center">รวม (คะแนนเต็ม 10 คะแนน)</td>
        <?php } ?>

        <td class="style30" align="center">%</td>
        <td class="style30" align="center">ตั้งแต่ 80% ขึ้นไป = P (F = ไม่ผ่าน)</td>
        <td class="style30">ข้อเสนอแนะ</td>
      </tr>
    </thead>
    <?php
      $strSQL = "SELECT * FROM tb_research WHERE sale_neat!='0' AND sale_code!='SM1'";
      if($start_date!="") $strSQL .= ' AND iv_date >= "'.$start_date.'"';
      if($end_date  !="") $strSQL .= ' AND iv_date <= "'.$end_date.'"';
      if($type_customer!='') $strSQL .= ' AND type_customer="'.$type_customer.'"';
      $q = mysqli_query($com1,$strSQL) or die ("Error Query [".$strSQL."]");
      $n=1;
      while($r=mysqli_fetch_array($q)){
        $iv=$r["iv_number"]; $cus=$r["customer_name"]; $zone=$r["sale_code"];
        $sale_neat=(float)$r["sale_neat"]; $sale_data=(float)$r["sale_data"]; $sale_3=(float)$r["sale_3"]; $sale_4v=(float)$r["sale_4"];
        $suggest=$r["suggest"];

        if($use_new_survey){
          list($sum_sale,$sale_persent) = calc_avg_and_percent_5([$sale_neat,$sale_data,$sale_3]); // 3 ข้อ
        }else{
          if($show_sale4){
            $sum_sale = ($sale_neat+$sale_data+$sale_3+$sale_4v)/4;
            $sum_sale1= $sale_neat+$sale_data+$sale_3+$sale_4v;
            $sale_persent = ($sum_sale1*100)/40;
          }else{
            $sum_sale = number_format(($sale_neat+$sale_data+$sale_3)/3,2);
            $sum_sale1= $sale_neat+$sale_data+$sale_3;
            $sale_persent = number_format(($sum_sale1*100)/30,2);
          }
        }
        $pass = ((float)$sale_persent >= 80) ? "P":"F";
        echo "<tr>
          <td class='style30' align='center'>".$n++."</td>
          <td class='style30' align='center'>".$iv."</td>
          <td class='style30'>".$cus."</td>
          <td class='style30' align='center'>".$zone."</td>
          <td class='style30' align='center'>".$sale_neat."</td>
          <td class='style30' align='center'>".$sale_data."</td>
          <td class='style30' align='center'>".$sale_3."</td>";
        if(!$use_new_survey && $show_sale4){
          echo "<td class='style30' align='center'>".$sale_4v."</td>";
        }
        echo "
          <td class='style30' align='center'>".$sum_sale."</td>
          <td class='style30' align='center'>".$sale_persent." %</td>
          <td class='style30' align='center'>".$pass."</td>
          <td class='style30'>".$suggest."</td>
        </tr>";
      }
    ?>
  </table>
  <br>
<?php } ?>

<?php
/* ======================= ส่วนที่ 2: สินค้า/ผลิตภัณฑ์ ======================= */
if($type_cs=='2'){
?>
  <center><span class="style15">ความพึงพอใจต่อสินค้า/ผลิตภัณฑ์</span></center><br>
  <table border="1" width="100%" class="w3-table">
    <thead>
      <?php
        $qcols = $use_new_survey ? 3 : 4;
        render_group_row_single(4, $qcols, 'ความพึงพอใจต่อสินค้า/ผลิตภัณฑ์', 4);
      ?>
      <tr>
        <td class="style30" align="center">ลำดับ</td>
        <td class="style30" align="center">เลขที่เอกสาร</td>
        <td class="style30">รายชื่อลูกค้า</td>
        <td class="style30" align="center">เขตการขาย</td>

        <?php if($use_new_survey){ ?>
          <!-- แบบใหม่: 3 ข้อ -->
          <td class="style30" align="center">สินค้าตรงตามข้อมูลที่ได้รับ/อธิบาย และสามารถใช้งานได้จริง</td>
          <td class="style30" align="center">คุณภาพสินค้าตรงตามที่คาดหวัง</td>
          <td class="style30" align="center">ความพึงพอใจในสินค้าโดยรวมที่มีต่อผลิตภัณฑ์ที่ได้รับ</td>
          <td class="style30" align="center">รวม (คะแนนเต็ม 5 คะแนน)</td>
        <?php } else { ?>
          <!-- แบบเดิม: 4 ข้อ -->
          <td class="style30" align="center">สินค้ามีคุณภาพ และสามารถใช้งานได้อย่างมีประสิทธิภาพ</td>
          <td class="style30" align="center">สินค้าตรงกับความต้องการของลูกค้า</td> 
          <td class="style30" align="center">ความพึงพอใจในสินค้า</td>
          <td class="style30" align="center">มีแนวโน้มที่จะแนะนำให้เพื่อน หรือคนรู้จักมาใช้บริการของ ALLWELL มากน้อยเพียงใด</td>
          <td class="style30" align="center">รวม (คะแนนเต็ม 10 คะแนน)</td>
        <?php } ?>

        <td class="style30" align="center">%</td>
        <td class="style30" align="center">ตั้งแต่ 80% ขึ้นไป = P (F = ไม่ผ่าน)</td>
        <td class="style30">ข้อเสนอแนะ</td>
      </tr>
    </thead>
    <?php
      $strSQL = "SELECT * FROM tb_research WHERE product_good!='0' AND sale_code!='SM1'";
      if($start_date!="") $strSQL .= ' AND iv_date >= "'.$start_date.'"';
      if($end_date  !="") $strSQL .= ' AND iv_date <= "'.$end_date.'"';
      if($type_customer!='') $strSQL .= ' AND type_customer="'.$type_customer.'"';
      $q = mysqli_query($com1,$strSQL) or die ("Error Query [".$strSQL."]");
      $n=1;
      while($r=mysqli_fetch_array($q)){
        $iv=$r["iv_number"]; $cus=$r["customer_name"]; $zone=$r["sale_code"];
        $g=(float)$r["product_good"]; $l=(float)$r["product_link"]; $c=(float)$r["product_corect"]; $p3=(float)$r["product_3"];
        $sug=$r["suggest_1"];

        if($use_new_survey){
          list($sum_pro,$pro_persent) = calc_avg_and_percent_5([$g,$l,$c]); // 3 ข้อ
        }else{
          $sum_pro  = ($g+$l+$c+$p3)/4;
          $sum_pro1 =  $g+$l+$c+$p3;
          $pro_persent = ($sum_pro1*100)/40;
        }
        $pass = ((float)$pro_persent >= 80) ? "P":"F";
        echo "<tr>
          <td class='style30' align='center'>".$n++."</td>
          <td class='style30' align='center'>".$iv."</td>
          <td class='style30'>".$cus."</td>
          <td class='style30' align='center'>".$zone."</td>
          <td class='style30' align='center'>".$g."</td>
          <td class='style30' align='center'>".$l."</td>
          <td class='style30' align='center'>".$c."</td>";
        if(!$use_new_survey){
          echo "<td class='style30' align='center'>".$p3."</td>";
        }
        echo "
          <td class='style30' align='center'>".$sum_pro."</td>
          <td class='style30' align='center'>".$pro_persent." %</td>
          <td class='style30' align='center'>".$pass."</td>
          <td class='style30'>".$sug."</td>
        </tr>";
      }
    ?>
  </table>
  <br>
<?php } ?>

<?php
/* ======================= ส่วนที่ 3: ติดตั้ง/สาธิต ======================= */
if($type_cs=='3'){
?>
  <center><span class="style15">ความพึงพอใจต่อพนักงานผู้ติดตั้ง/สาธิต</span></center><br>
  <table border="1" width="100%" class="w3-table">
    <thead>
      <?php
        $qcols = $use_new_survey ? 3 : 5;
        render_group_row_single(4, $qcols, 'ความพึงพอใจต่อพนักงานผู้ติดตั้ง/สาธิต', 4);
      ?>
      <tr>
        <td class="style30" align="center">ลำดับ</td>
        <td class="style30" align="center">เลขที่เอกสาร</td>
        <td class="style30">รายชื่อลูกค้า</td>
        <td class="style30" align="center">เขตการขาย</td>

        <?php if($use_new_survey){ ?>
          <!-- แบบใหม่: 3 ข้อ -->
          <td class="style30" align="center">พนักงานจัดส่งสุภาพ แต่งกายเหมาะสม และปฏิบัติตามมาตรการความปลอดภัย</td>
          <td class="style30" align="center">อธิบาย/สาธิตวิธีใช้งานชัดเจน ครบถ้วน และตอบข้อซักถามได้</td>
          <td class="style30" align="center">ดูแลความสะอาด ความเรียบร้อยของสินค้า/พื้นที่ และการติดตั้ง</td>
          <td class="style30" align="center">รวม (คะแนนเต็ม 5 คะแนน)</td>
        <?php } else { ?>
          <!-- แบบเดิม: 5 ข้อ -->
          <td class="style30" align="center">พนักงานจัดส่งมีกิริยามารยาทเรียบร้อย พูดจาสุภาพ อัธยาศัยดี วางตัวเหมาะสม</td>
          <td class="style30" align="center">พนักงานจัดส่งมีความรู้ความชำนาญในสินค้า สามารถอธิบาย สาธิตวิธีการใช้งาน และตอบข้อซักถามได้ชัดเจน</td> 
          <td class="style30" align="center">พนักงานจัดส่งดูแลสินค้า รวมถึงกระบวนการขนย้ายสินค้าเข้าติดตั้ง ณ สถานที่ใช้งานเป็นอย่างดี</td> 
          <td class="style30" align="center">พนักงานจัดส่งสินค้าโทรประสานงานก่อนส่งสินค้าจริง และส่งมอบสินค้าตามเวลาที่ได้นัดหมายไว้</td> 
          <td class="style30" align="center">มาตรฐานการขนส่งของพนักงานจัดส่ง เมื่อเทียบกับบริษัทอื่นๆ</td> 
          <td class="style30" align="center">รวม (คะแนนเต็ม 5 คะแนน)</td>
        <?php } ?>

        <td class="style30" align="center">%</td>
        <td class="style30" align="center">ตั้งแต่ 80% ขึ้นไป = P (F = ไม่ผ่าน)</td>
        <td class="style30">ข้อเสนอแนะ</td>
      </tr>
    </thead>
    <?php
      $strSQL = "SELECT * FROM tb_research WHERE cs_neat!='0' AND sale_code!='SM1'";
      if($start_date!="") $strSQL .= ' AND iv_date >= "'.$start_date.'"';
      if($end_date  !="") $strSQL .= ' AND iv_date <= "'.$end_date.'"';
      if($type_customer!='') $strSQL .= ' AND type_customer="'.$type_customer.'"';
      $q = mysqli_query($com1,$strSQL) or die ("Error Query [".$strSQL."]");
      $n=1;
      while($r=mysqli_fetch_array($q)){
        $iv=$r["iv_number"]; $cus=$r["customer_name"]; $zone=$r["sale_code"];
        $a=(float)$r["cs_neat"]; $b=(float)$r["cs_explain"]; $c=(float)$r["cs_3"]; $d=(float)$r["cs_4"]; $e=(float)$r["cs_5"];
        $sug=$r["suggest_2"];

        if($use_new_survey){
          list($sum_cs,$cs_persent) = calc_avg_and_percent_5([$a,$b,$c]); // 3 ข้อ
        }else{
          $sum_cs  = ($a+$b+$c+$d+$e)/5;
          $sum_cs1 =  $a+$b+$c+$d+$e;
          $cs_persent = ($sum_cs1*100)/50;
        }
        $pass = ((float)$cs_persent >= 80) ? "P":"F";
        echo "<tr>
          <td class='style30' align='center'>".$n++."</td>
          <td class='style30' align='center'>".$iv."</td>
          <td class='style30'>".$cus."</td>
          <td class='style30' align='center'>".$zone."</td>
          <td class='style30' align='center'>".$a."</td>
          <td class='style30' align='center'>".$b."</td>
          <td class='style30' align='center'>".$c."</td>";
        if(!$use_new_survey){
          echo "<td class='style30' align='center'>".$d."</td>
                <td class='style30' align='center'>".$e."</td>";
        }
        echo "
          <td class='style30' align='center'>".$sum_cs."</td>
          <td class='style30' align='center'>".$cs_persent." %</td>
          <td class='style30' align='center'>".$pass."</td>
          <td class='style30'>".$sug."</td>
        </tr>";
      }
    ?>
  </table>
<?php } ?>

<?php if($type_cs==''){ ?>	
<!-- ======================= ตารางเดียว ครอบคลุมทุกส่วน ======================= -->
<table border="1" width="100%" class="w3-table">
  <thead>
    <?php
      if($use_new_survey){
        $sales_cols = 4; $prod_cols = 4; $inst_cols = 4;
      }else{
        $sales_cols = 5; $prod_cols = 5; $inst_cols = 6;
      }
      render_group_row_multi(
        4,
        [
          [$sales_cols, 'ความพึงพอใจต่อพนักงานขาย'],
          [$prod_cols , 'ความพึงพอใจต่อสินค้า/ผลิตภัณฑ์'],
          [$inst_cols , 'ความพึงพอใจต่อพนักงานผู้ติดตั้ง/สาธิต'],
        ]
      );
    ?>
    <tr>
      <td align="center" class="style30">ลำดับ</td>
      <td align="center" class="style30">เลขที่เอกสาร</td>
      <td class="style30">รายชื่อลูกค้า</td>
      <td align="center" class="style30">เขตการขาย</td>

      <?php if($use_new_survey){ ?>
        <!-- ใหม่ 3 ข้อ/ส่วน -->
        <td align="center" class="style30">พนักงานพูดจาสุภาพ มีมารยาท และแต่งกายเหมาะสม</td>
        <td align="center" class="style30">มีความรู้ความเข้าใจเกี่ยวกับสินค้า สามารถให้คำแนะนำและตอบข้อซักถามได้ชัดเจน</td>
        <td align="center" class="style30">แสดงความจริงใจ เอาใจใส่/ติดตามผล และให้ความช่วยเหลือหลังการขาย</td>
        <td align="center" class="style30">ข้อเสนอแนะ (พนักงานขาย)</td>

        <td align="center" class="style30">สินค้าตรงตามข้อมูลที่ได้รับ/อธิบาย และสามารถใช้งานได้จริง</td>
        <td align="center" class="style30">คุณภาพสินค้าตรงตามที่คาดหวัง</td>
        <td align="center" class="style30">ความพึงพอใจในสินค้าโดยรวมที่มีต่อผลิตภัณฑ์ที่ได้รับ</td>
        <td align="center" class="style30">ข้อเสนอแนะ (สินค้า/ผลิตภัณฑ์)</td>

        <td align="center" class="style30">พนักงานจัดส่งสุภาพ แต่งกายเหมาะสม และปฏิบัติตามมาตรการความปลอดภัย</td>
        <td align="center" class="style30">อธิบาย/สาธิตวิธีใช้งานชัดเจน ครบถ้วน และตอบข้อซักถามได้</td>
        <td align="center" class="style30">ดูแลความสะอาด ความเรียบร้อยของสินค้า/พื้นที่ และการติดตั้ง</td>
        <td align="center" class="style30">ข้อเสนอแนะ (พนักงานผู้ติดตั้ง/สาธิต)</td>
      <?php } else { ?>
        <!-- เดิม -->
        <td align="center" class="style30">พนักงานขายกิริยามารยาทเรียบร้อย พูดจาสุภาพ อัธยาศัยดี วางตัวเหมาะสม</td>
        <td align="center" class="style30">พนักงานขายมีความรู้ความชำนาญในตัวสินค้า สามารถแนะนำ ตอบข้อซักถามได้ชัดเจน</td> 
        <td align="center" class="style30">พนักงานขายบริการด้วยความรวดเร็ว/เอาใจใส่ และมีความเต็มใจให้บริการ</td>
        <td align="center" class="style30">การติดต่อพนักงานขายในช่องทางต่างๆ รวดเร็ว และมีประสิทธิภาพ</td>
        <td align="center" class="style30">ข้อเสนอแนะ (พนักงานขาย)</td> 

        <td align="center" class="style30">สินค้ามีคุณภาพ และสามารถใช้งานได้อย่างมีประสิทธิภาพ</td>
        <td align="center" class="style30">สินค้าตรงกับความต้องการของลูกค้า</td> 
        <td align="center" class="style30">ความพึงพอใจในสินค้า</td>
        <td align="center" class="style30">มีแนวโน้มที่จะแนะนำให้เพื่อน หรือคนรู้จักมาใช้บริการของ ALLWELL มากน้อยเพียงใด</td>
        <td align="center" class="style30">ข้อเสนอแนะ (สินค้า/ผลิตภัณฑ์)</td> 

        <td align="center" class="style30">พนักงานจัดส่งมีกิริยามารยาทเรียบร้อย พูดจาสุภาพ อัธยาศัยดี วางตัวเหมาะสม</td>
        <td align="center" class="style30">พนักงานจัดส่งมีความรู้ความชำนาญในสินค้า สามารถอธิบาย สาธิตวิธีการใช้งาน และตอบข้อซักถามได้ชัดเจน</td> 
        <td align="center" class="style30">พนักงานจัดส่งดูแลสินค้า รวมถึงกระบวนการขนย้ายสินค้าเข้าติดตั้ง ณ สถานที่ใช้งานเป็นอย่างดี</td> 
        <td align="center" class="style30">พนักงานจัดส่งสินค้าโทรประสานงานก่อนส่งสินค้าจริง และส่งมอบสินค้าตามเวลาที่ได้นัดหมายไว้</td> 
        <td align="center" class="style30">มาตรฐานการขนส่งของพนักงานจัดส่ง เมื่อเทียบกับบริษัทอื่นๆ</td> 
        <td align="center" class="style30">ข้อเสนอแนะ (พนักงานผู้ติดตั้ง/สาธิต)</td> 
      <?php } ?>
    </tr>
  </thead>

  <tbody>
    <?php
      $strSQL = "SELECT * FROM tb_research WHERE sale_code!='SM1'";
      if($start_date!="") $strSQL .= ' AND iv_date >= "'.$start_date.'"';
      if($end_date  !="") $strSQL .= ' AND iv_date <= "'.$end_date.'"';
      if($type_customer!='') $strSQL .= ' AND type_customer="'.$type_customer.'"';

      $objQuery = mysqli_query($com1,$strSQL) or die ("Error Query [".$strSQL."]");
      $n=1;
      while($row = mysqli_fetch_array($objQuery)){
        echo "<tr>";
        echo "<td class='style30' align='center'>".$n++."</td>";
        echo "<td class='style30' align='center'>".$row["iv_number"]."</td>";
        echo "<td class='style30'>".$row["customer_name"]."</td>";
        echo "<td class='style30' align='center'>".$row["sale_code"]."</td>";

        if($use_new_survey){
          echo "<td class='style30' align='center'>".$row["sale_neat"]."</td>";
          echo "<td class='style30' align='center'>".$row["sale_data"]."</td>";
          echo "<td class='style30' align='center'>".$row["sale_3"]."</td>";
          echo "<td class='style30'>".$row["suggest"]."</td>";
          echo "<td class='style30' align='center'>".$row["product_good"]."</td>";
          echo "<td class='style30' align='center'>".$row["product_link"]."</td>";
          echo "<td class='style30' align='center'>".$row["product_corect"]."</td>";
          echo "<td class='style30'>".$row["suggest_1"]."</td>";
          echo "<td class='style30' align='center'>".$row["cs_neat"]."</td>";
          echo "<td class='style30' align='center'>".$row["cs_explain"]."</td>";
          echo "<td class='style30' align='center'>".$row["cs_3"]."</td>";
          echo "<td class='style30'>".$row["suggest_2"]."</td>";
        } else {
          echo "<td class='style30' align='center'>".$row["sale_neat"]."</td>";
          echo "<td class='style30' align='center'>".$row["sale_data"]."</td>";
          echo "<td class='style30' align='center'>".$row["sale_3"]."</td>";
          echo "<td class='style30' align='center'>".$row["sale_4"]."</td>";
          echo "<td class='style30'>".$row["suggest"]."</td>";
          echo "<td class='style30' align='center'>".$row["product_good"]."</td>";
          echo "<td class='style30' align='center'>".$row["product_link"]."</td>";
          echo "<td class='style30' align='center'>".$row["product_corect"]."</td>";
          echo "<td class='style30' align='center'>".$row["product_3"]."</td>";
          echo "<td class='style30'>".$row["suggest_1"]."</td>";
          echo "<td class='style30' align='center'>".$row["cs_neat"]."</td>";
          echo "<td class='style30' align='center'>".$row["cs_explain"]."</td>";
          echo "<td class='style30' align='center'>".$row["cs_3"]."</td>";
          echo "<td class='style30' align='center'>".$row["cs_4"]."</td>";
          echo "<td class='style30' align='center'>".$row["cs_5"]."</td>";
          echo "<td class='style30'>".$row["suggest_2"]."</td>";
        }

        echo "</tr>";
      }
    ?>
  </tbody>
</table>
<?php } ?>	
<!-- ======================= จบตารางเดียว ======================= -->

</div>
</body>
</html>
