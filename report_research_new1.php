<?php 
include('head1.php'); 
include "dbconnect_cs.php";

function DateThai($strDate){
    $strYear  = date("Y",strtotime($strDate))+543;
    $strMonth = date("n",strtotime($strDate));
    $strDay   = date("j",strtotime($strDate));
    $strMonthCut = array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
    $strMonthThai=$strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear";
}

date_default_timezone_set("Asia/Bangkok");

/* ---------- รับพารามิเตอร์ ---------- */
$start_date    = isset($_GET["start_date"])? $_GET["start_date"] : "";
$end_date      = isset($_GET["end_date"])? $_GET["end_date"] : "";
$type_customer = isset($_GET["type_customer"])? $_GET["type_customer"] : ""; // A/B/...
$type_cs       = isset($_GET["type_cs"])? $_GET["type_cs"] : "";             // 1,2,3

/* ---------- ค่าตัดรูปแบบใหม่ ---------- */
define('NEW_FORM_START', '2025-10-01'); // = 1/10/2568

/* ---------- เลือกใช้ฟอร์มเก่าหรือใหม่ ---------- 
   - ถ้า end_date ถูกระบุ: ใช้ end_date เปรียบเทียบ
   - ถ้าไม่ระบุ end_date: ใช้ start_date เปรียบเทียบ
*/
$cmpDate = $end_date ? $end_date : $start_date;
$useNewForm = ($cmpDate !== "" && strtotime($cmpDate) >= strtotime(NEW_FORM_START));

/* ---------- เตรียมชื่อเดือน/ปีแสดงหัวรายงาน ---------- */
$_month_name = array("01"=>"มกราคม","02"=>"กุมภาพันธ์","03"=>"มีนาคม","04"=>"เมษายน","05"=>"พฤษภาคม","06"=>"มิถุนายน",
"07"=>"กรกฎาคม","08"=>"สิงหาคม","09"=>"กันยายน","10"=>"ตุลาคม","11"=>"พฤศจิกายน","12"=>"ธันวาคม");

$thai=""; $year="";
if ($start_date !== ""){
    $date_arr = explode('-',$start_date);
    if (count($date_arr)>=2){
        $thai = isset($_month_name[$date_arr[1]]) ? $_month_name[$date_arr[1]] : "";
        $year = ($date_arr[0] + 543);
    }
}

/* ---------- ฟังก์ชันช่วยสำหรับฟอร์มใหม่ (เต็ม 5) ---------- */
function percent_from_avg5($avg){ return ($avg * 100) / 5; }

?>
<link rel="stylesheet" href="css/w32.css">
<style type="text/css">
.style15 {font-size:16px;color:#000}
.style30 {font-size:13px}
</style>

<body>
<div class="w3-container w3-padding-large">
<center>
  <span class="style15">รายงานสรุปความพึงพอใจลูกค้าหลังการขาย</span><br>
  <span class="style15">สรุปผลความพึงพอใจลูกค้าหลังการขาย <?php echo $thai;?> ประจำปี <?php echo $year;?></span>
</center>
<br>

<?php
/* =======================================================================
   ส่วนที่ 1: ความพึงพอใจต่อพนักงานขาย
   ======================================================================= */
if ($type_cs == '1') {

    if ($useNewForm) {
        /* ======================= ฟอร์มใหม่ (ตั้งแต่ 1/10/2568) ======================= */
        // บังคับตัดข้อมูลเฉพาะ >= NEW_FORM_START เพื่อไม่ปนฟอร์มเก่า
        $sql = "SELECT * FROM tb_research WHERE sale_neat != '0' 
                AND iv_date >= '".NEW_FORM_START."' ";
        if ($start_date != "") $sql .= ' AND iv_date >= "'.$start_date.'"';
        if ($end_date   != "") $sql .= ' AND iv_date <= "'.$end_date.'"';
        if ($type_customer != "") $sql .= ' AND grade = "'.$type_customer.'"';
        $sql .= " AND sale_code NOT IN ('SM1','MM1','S31','S32') ";

        $qry = mysqli_query($com1,$sql) or die("Error Query [".$sql."]");
        ?>
        <center><span class="style15">ความพึงพอใจต่อพนักงานขาย</span></center><br>
        <table border="1" width="100%" class="w3-table">
        <thead>
          <tr>
            <td align="center" class="style30">ลำดับ</td>
            <td align="center" class="style30">วันที่ทำแบบสอบถาม</td>
            <td align="center" class="style30">เลขที่เอกสาร</td>
            <td align="center" class="style30">รายชื่อลูกค้า</td>
            <td align="center" class="style30">เขตการขาย</td> 
            <td align="center" class="style30">พนักงานพูดจาสุภาพ มีมารยาท และแต่งกายเหมาะสม</td>
            <td align="center" class="style30">มีความรู้ความเข้าใจเกี่ยวกับสินค้า ให้คำแนะนำได้ชัดเจน</td>
            <td align="center" class="style30">แสดงความจริงใจ ใส่ใจ ติดตามผล และให้ความช่วยเหลือหลังการขาย</td>
            <td align="center" class="style30">รวม (คะแนนเต็ม 5 คะแนน)</td>
            <td align="center" class="style30">%</td>
            <td align="center" class="style30">สถานะ</td>
            <td align="center" class="style30">ข้อเสนอแนะ</td>
          </tr>
        </thead>
        <?php
        $n=1; $rows=0;
        $sum_neat=0; $sum_data=0; $sum_3=0;
        while($rs = mysqli_fetch_array($qry)){
            $date_research = DateThai($rs["date_research"]);
            $iv_number     = $rs["iv_number"];
            $customer_name = $rs["customer_name"];
            $sale_code     = $rs["sale_code"];

            $sale_neat = (float)$rs["sale_neat"];
            $sale_data = (float)$rs["sale_data"];
            $sale_3    = (float)$rs["sale_3"];

            $avg     = ($sale_neat+$sale_data+$sale_3)/3;
            $percent = percent_from_avg5($avg);
            $pass    = ($percent>=80) ? "P" : "F";

            $sum_neat += $sale_neat; $sum_data += $sale_data; $sum_3 += $sale_3; $rows++;

            echo "<tr>
              <td align='center' class='style30'>{$n}</td>
              <td align='left'   class='style30'>{$date_research}</td>
              <td align='center' class='style30'>{$iv_number}</td>
              <td align='left'   class='style30'>{$customer_name}</td>
              <td align='center' class='style30'>{$sale_code}</td>
              <td align='center' class='style30'>{$sale_neat}</td>
              <td align='center' class='style30'>{$sale_data}</td>
              <td align='center' class='style30'>{$sale_3}</td>
              <td align='center' class='style30'>".number_format($avg,2)."</td>
              <td align='center' class='style30'>".number_format($percent,2)." %</td>
              <td align='center' class='style30'>{$pass}</td>
              <td align='left'   class='style30'>".$rs["suggest"]."</td>
            </tr>";
            $n++;
        }
        $avg_neat  = $rows? $sum_neat/$rows : 0;
        $avg_data  = $rows? $sum_data/$rows : 0;
        $avg_3     = $rows? $sum_3/$rows    : 0;
        $avg_total = ($avg_neat+$avg_data+$avg_3)/3;
        $percent_all = percent_from_avg5($avg_total);
        $pass_all    = ($percent_all>=80) ? "P":"F";

        echo "<tr bgcolor='yellow'>
          <td class='style30'></td><td class='style30'></td><td class='style30'></td><td class='style30'></td>
          <td class='style30' align='center'>ค่าเฉลี่ย</td>
          <td class='style30' align='center'>".number_format($avg_neat,2)."</td>
          <td class='style30' align='center'>".number_format($avg_data,2)."</td>
          <td class='style30' align='center'>".number_format($avg_3,2)."</td>
          <td class='style30' align='center'>".number_format($avg_total,2)."</td>
          <td class='style30' align='center'>".number_format($percent_all,2)." %</td>
          <td class='style30' align='center'>{$pass_all}</td>
          <td class='style30'></td>
        </tr></table>";
    } else {
        /* ======================= ฟอร์มเก่า (ก่อน 1/10/2568) ======================= */
        // ========== ใช้โค้ดเดิมของพี่ ==========
        if($type_customer=='A'){
            echo '<center><span class="style15">ความพึงพอใจต่อพนักงานขาย</span></center><br>';
            echo "<table border='1' width='100%' class='w3-table'>
            <thead><tr>
            <td align='center' class='style30'>ลำดับ</td>
            <td align='center' class='style30'>วันที่ทำแบบสอบถาม</td>
            <td align='center' class='style30'>เลขที่เอกสาร</td>
            <td align='center' class='style30'>รายชื่อลูกค้า</td>
            <td align='center' class='style30'>เขตการขาย</td> 
            <td align='center' class='style30'>พนักงานพูดจาสุภาพ อัธยาศัยดี แต่งกายสุภาพ วางตัวเหมาะสม</td>
            <td align='center' class='style30'>พนักงานมีความรู้ความชำนาญในตัวสินค้า สามารถแนะนำ ตอบข้อซักถามได้ชัดเจน</td> 
            <td align='center' class='style30'>พนักงานให้บริการด้วยความรวดเร็ว/เอาใจใส่ และเต็มใจให้บริการ</td>
            <td align='center' class='style30'>พนักงานสนใจไปเยี่ยมเยียน สอบถามความต้องการลูกค้าทั้งก่อนและหลังการขาย</td>
            <td align='center' class='style30'>การติดต่อพนักงานขายในช่องทางต่างๆ รวดเร็ว และมีประสิทธิภาพ</td>
            <td align='center' class='style30'>รวม (คะแนนเต็ม 10 คะแนน)</td>
            <td align='center' class='style30'>%</td>
            <td align='center' class='style30'>ตั้งแต่ 50 คะแนนขึ้นไป = P (F = ไม่ผ่าน)</td>
            <td align='center' class='style30'>ข้อเสนอแนะ</td>
            </tr></thead>";

            $strSQL = "SELECT *  FROM  tb_research where sale_neat !='0' and sale_code !='SM1' and sale_code !='MM1' and sale_code !='S31' and sale_code !='S32'";
            if($start_date !=""){ $strSQL .= ' AND iv_date >= "'.$start_date.'"'; }
            if($end_date !=""){ $strSQL .= ' AND iv_date <= "'.$end_date.'"'; }
            if($type_customer !=''){ $strSQL .= ' AND  grade = "'.$type_customer.'"'; }
            $objQuery = mysqli_query($com1,$strSQL) or die ("Error Query [".$strSQL."]");

            $n=1; $s=0;	
            $sum_sale_neat=0; $sum_sale_data=0; $sum_sale_3=0; $sum_sale_4=0; $sum_sale_5=0;

            while($objResult = mysqli_fetch_array($objQuery)){
                $iv_number =  $objResult["iv_number"];
                $customer_name = $objResult["customer_name"];
                $sale_neat = $objResult["sale_neat"];
                $sale_data = $objResult["sale_data"];
                $sale_3 = $objResult["sale_3"];
                $sale_4 = $objResult["sale_4"];
                $sale_5 = $objResult["sale_5"];
                $sale_code = $objResult["sale_code"];
                $date_research = DateThai($objResult["date_research"]);
                $sum_sale = ($sale_neat+$sale_data+$sale_3+$sale_4+$sale_5)/5;
                $sum_sale1 = $sale_neat+$sale_data+$sale_3+$sale_4+$sale_5;
                $sale_persent = ($sum_sale1*100)/50;
                $sale_pass = ($sale_persent >= 80)? "P":"F";
                $sum_sale_neat += $sale_neat; $sum_sale_data += $sale_data; $sum_sale_3 += $sale_3; $sum_sale_4 += $sale_4; $sum_sale_5 += $sale_5;
                $suggest = $objResult["suggest"];

                echo "<tr>
                <td align='center' class='style30'>{$n}</td>
                <td align='left' class='style30'>{$date_research}</td>
                <td align='center' class='style30'>{$iv_number}</td>
                <td align='left' class='style30'>{$customer_name}</td>
                <td align='center' class='style30'>{$sale_code}</td>
                <td align='center' class='style30'>{$sale_neat}</td>
                <td align='center' class='style30'>{$sale_data}</td>
                <td align='center' class='style30'>{$sale_3}</td>
                <td align='center' class='style30'>{$sale_4}</td>
                <td align='center' class='style30'>{$sale_5}</td>
                <td align='center' class='style30'>{$sum_sale}</td>
                <td align='center' class='style30'>".$sale_persent." %</td>
                <td align='center' class='style30'>{$sale_pass}</td>
                <td align='left' class='style30'>{$suggest}</td>
                </tr>";
                $n++; $s++;
                // หมายเหตุ: โค้ดเดิมมี $sum_xxx++ เพิ่มอีกครั้ง หนู **ไม่ใส่** เพื่อไม่ให้เพี้ยน แต่ตรรกะคงเดิม
            } 
            // สรุป (คงวิธีคำนวณเดิม)
            $sum_sale_s = ((($sum_sale_neat)+($sum_sale_data)+($sum_sale_3)+($sum_sale_4)+($sum_sale_5))/$s)/5;
            $sum_sale_s1 = (($sum_sale_neat)+($sum_sale_data)+($sum_sale_3)+($sum_sale_4)+($sum_sale_5))/$s;
            $sale_persent_s = ($sum_sale_s1*100)/50;
            $sale_pass_s = ($sale_persent_s >= 80) ? "P":"F";

            echo "<tr bgcolor='yellow'>
            <td class='style30'></td><td class='style30'></td><td class='style30'></td><td class='style30'></td>
            <td align='center' class='style30'>ค่าเฉลี่ย</td>
            <td align='center' class='style30'>".number_format(($sum_sale_neat)/$s,2)."</td>
            <td align='center' class='style30'>".number_format(($sum_sale_data)/$s,2)."</td>
            <td align='center' class='style30'>".number_format(($sum_sale_3)/$s,2)."</td>
            <td align='center' class='style30'>".number_format(($sum_sale_4)/$s,2)."</td>
            <td align='center' class='style30'>".number_format(($sum_sale_5)/$s,2)."</td>
            <td align='center' class='style30'>".number_format($sum_sale_s,2)."</td>
            <td align='center' class='style30'>".number_format($sale_persent_s,2)." %</td>
            <td align='center' class='style30'>{$sale_pass_s}</td>
            <td class='style30'></td></tr></table>";
        } else {
            // โค้ดเดิม (ฟอร์มเก่า) กรณี type_customer != 'A'
            echo '<center><span class="style15">ความพึงพอใจต่อพนักงานขาย</span></center><br>';
            echo "<table border='1' width='100%' class='w3-table'><thead><tr>
            <td align='center' class='style30'>ลำดับ</td>
            <td align='center' class='style30'>วันที่ทำแบบสอบถาม</td>
            <td align='center' class='style30'>เลขที่เอกสาร</td>
            <td align='center' class='style30'>รายชื่อลูกค้า</td>
            <td align='center' class='style30'>เขตการขาย</td> 
            <td align='center' class='style30'>พนักงานขายสามารถตอบคำถาม ให้ข้อมูลสินค้าได้ชัดเจน </td>
            <td align='center' class='style30'>พนักงานขายพูดจาสุภาพ อัธยาศัยดี วางตัวเหมาะสม</td> 
            <td align='center' class='style30'>ความพึงพอใจต่อบริการที่ได้รับจาก ออลล์เวลในครั้งนี้</td>
            <td align='center' class='style30'>รวม (คะแนนเต็ม 10 คะแนน)</td>
            <td align='center' class='style30'>%</td>
            <td align='center' class='style30'>ตั้งแต่ 300 คะแนนขึ้นไป = P (F = ไม่ผ่าน)</td>
            <td align='center' class='style30'>ข้อเสนอแนะ</td></tr></thead>";

            $strSQL = "SELECT *  FROM  tb_research where sale_neat !='0' and sale_code !='SM1'  and sale_code !='MM1' and sale_code !='S31' and sale_code !='S32'";
            if($start_date !=""){ $strSQL .= ' AND iv_date >= "'.$start_date.'"'; }
            if($end_date !=""){ $strSQL .= ' AND iv_date <= "'.$end_date.'"'; }
            if($type_customer !=''){ $strSQL .= ' AND  grade = "'.$type_customer.'"'; }
            $objQuery = mysqli_query($com1,$strSQL) or die ("Error Query [".$strSQL."]");

            $n=1; $s=0;	
            $sum_sale_neat=0; $sum_sale_data=0; $sum_sale_3=0;

            while($objResult = mysqli_fetch_array($objQuery)){
                $date_research = DateThai($objResult["date_research"]);
                $iv_number =  $objResult["iv_number"];
                $customer_name = $objResult["customer_name"];
                $sale_neat = $objResult["sale_neat"];
                $sale_data = $objResult["sale_data"];
                $sale_3 = $objResult["sale_3"];
                $sale_code = $objResult["sale_code"];
                $sum_sale = ($sale_neat+$sale_data+$sale_3)/3;
                $sum_sale1 = $sale_neat+$sale_data+$sale_3;
                $sale_persent = ($sum_sale1*100)/30;
                $sale_pass = ($sale_persent >= 80) ? "P":"F";
                $sum_sale_neat += $sale_neat; $sum_sale_data += $sale_data; $sum_sale_3 += $sale_3;
                $suggest = $objResult["suggest"];

                echo "<tr>
                <td align='center' class='style30'>{$n}</td>
                <td align='left' class='style30'>{$date_research}</td>
                <td align='center' class='style30'>{$iv_number}</td>
                <td align='left' class='style30'>{$customer_name}</td>
                <td align='center' class='style30'>{$sale_code}</td> 
                <td align='center' class='style30'>{$sale_neat}</td>
                <td align='center' class='style30'>{$sale_data}</td> 
                <td align='center' class='style30'>{$sale_3}</td>
                <td align='center' class='style30'>{$sum_sale}</td>
                <td align='center' class='style30'>".$sale_persent." %</td>
                <td align='center' class='style30'>{$sale_pass}</td>
                <td align='left' class='style30'>{$suggest}</td></tr>";
                $n++; $s++;
            }
            $sum_sale_s = ((($sum_sale_neat)+($sum_sale_data)+($sum_sale_3))/$n)/3;
            $sum_sale_s1 = (($sum_sale_neat)+($sum_sale_data)+($sum_sale_3))/$n;
            $sale_persent_s = ($sum_sale_s1*100)/30;
            $sale_pass_s = ($sale_persent_s >= 80) ? "P":"F";

            echo "<tr bgcolor='yellow'>
            <td class='style30'></td><td class='style30'></td><td class='style30'></td><td class='style30'></td>
            <td align='center' class='style30'>ค่าเฉลี่ย</td> 
            <td align='center' class='style30'>".number_format(($sum_sale_neat)/$s,2)."</td>
            <td align='center' class='style30'>".number_format(($sum_sale_data)/$s,2)."</td> 
            <td align='center' class='style30'>".number_format(($sum_sale_3)/$s,2)."</td> 
            <td align='center' class='style30'>".number_format($sum_sale_s,2)."</td>
            <td align='center' class='style30'>".number_format($sale_persent_s,2)." %</td>
            <td align='center' class='style30'>{$sale_pass_s}</td>
            <td class='style30'></td></tr></table>";
        }
    }

/* =======================================================================
   ส่วนที่ 2: ความพึงพอใจต่อสินค้า/ผลิตภัณฑ์
   ======================================================================= */
} else if ($type_cs == '2') {

    if ($useNewForm) {
        // ===== ฟอร์มใหม่ =====
        $sql = "SELECT * FROM tb_research WHERE product_good != '0' AND iv_date >= '".NEW_FORM_START."'";
        if ($start_date != "") $sql .= ' AND iv_date >= "'.$start_date.'"';
        if ($end_date   != "") $sql .= ' AND iv_date <= "'.$end_date.'"';
        if ($type_customer != "") $sql .= ' AND grade = "'.$type_customer.'"';
        $sql .= " AND sale_code NOT IN ('SM1','MM1','S31','S32') ";
        $qry = mysqli_query($com1,$sql) or die("Error Query [".$sql."]");

        echo '<center><span class="style15">ความพึงพอใจต่อสินค้า/ผลิตภัณฑ์</span></center><br>';
        echo "<table border='1' width='100%' class='w3-table'><thead><tr>
        <td align='center' class='style30'>ลำดับ</td>
        <td align='center' class='style30'>วันที่ทำแบบสอบถาม</td>
        <td align='center' class='style30'>เลขที่เอกสาร</td>
        <td align='center' class='style30'>รายชื่อลูกค้า</td>
        <td align='center' class='style30'>เขตการขาย</td> 
        <td align='center' class='style30'>สินค้าจริงตรงกับข้อมูลที่บริษัทให้ก่อนสั่งซื้อ และสามารถใช้งานได้อย่างมีประสิทธิภาพ</td>
        <td align='center' class='style30'>คุณภาพสินค้าตรงตามที่คาดหวัง</td> 
        <td align='center' class='style30'>ความพึงพอใจในสินค้าโดยรวม</td>
        <td align='center' class='style30'>รวม (คะแนนเต็ม 5 คะแนน)</td>
        <td align='center' class='style30'>%</td>
        <td align='center' class='style30'>สถานะ</td>
        <td align='center' class='style30'>ข้อเสนอแนะ</td></tr></thead>";

        $n=1; $rows=0;
        $sum_good=0; $sum_link=0; $sum_corect=0;

        while($rs = mysqli_fetch_array($qry)){
            $date_research = DateThai($rs["date_research"]);
            $iv_number     = $rs["iv_number"];
            $customer_name = $rs["customer_name"];
            $sale_code     = $rs["sale_code"];
            $product_good   = (float)$rs["product_good"];
            $product_link   = (float)$rs["product_link"];
            $product_corect = (float)$rs["product_corect"];

            $avg     = ($product_good+$product_link+$product_corect)/3;
            $percent = percent_from_avg5($avg);
            $pass    = ($percent>=80) ? "P":"F";

            $sum_good += $product_good; $sum_link += $product_link; $sum_corect += $product_corect; $rows++;

            echo "<tr>
            <td align='center' class='style30'>{$n}</td>
            <td align='left' class='style30'>{$date_research}</td>
            <td align='center' class='style30'>{$iv_number}</td>
            <td align='left' class='style30'>{$customer_name}</td>
            <td align='center' class='style30'>{$sale_code}</td>
            <td align='center' class='style30'>{$product_good}</td>
            <td align='center' class='style30'>{$product_link}</td>
            <td align='center' class='style30'>{$product_corect}</td>
            <td align='center' class='style30'>".number_format($avg,2)."</td>
            <td align='center' class='style30'>".number_format($percent,2)." %</td>
            <td align='center' class='style30'>{$pass}</td>
            <td align='left' class='style30'>".$rs["suggest_1"]."</td></tr>";
            $n++;
        }
        $avg_good   = $rows? $sum_good/$rows : 0;
        $avg_link   = $rows? $sum_link/$rows : 0;
        $avg_corect = $rows? $sum_corect/$rows : 0;
        $avg_total  = ($avg_good+$avg_link+$avg_corect)/3;
        $percent_all = percent_from_avg5($avg_total);
        $pass_all    = ($percent_all>=80) ? "P":"F";

        echo "<tr bgcolor='yellow'>
        <td class='style30'></td><td class='style30'></td><td class='style30'></td><td class='style30'></td>
        <td align='center' class='style30'>ค่าเฉลี่ย</td>
        <td align='center' class='style30'>".number_format($avg_good,2)."</td>
        <td align='center' class='style30'>".number_format($avg_link,2)."</td>
        <td align='center' class='style30'>".number_format($avg_corect,2)."</td>
        <td align='center' class='style30'>".number_format($avg_total,2)."</td>
        <td align='center' class='style30'>".number_format($percent_all,2)." %</td>
        <td align='center' class='style30'>{$pass_all}</td>
        <td class='style30'></td></tr></table>";

    } else {
        // ===== ฟอร์มเก่า (ใช้โค้ดเดิม) =====
        if($type_customer=='A'){
            echo '<center><span class="style15">ความพึงพอใจต่อสินค้า/ผลิตภัณฑ์</span></center><br>';
            echo "<table border='1' width='100%' class='w3-table'><thead><tr>
            <td align='center' class='style30'>ลำดับ</td>
            <td align='center' class='style30'>วันที่ทำแบบสอบถาม</td>
            <td align='center' class='style30'>เลขที่เอกสาร</td>
            <td align='center' class='style30'>รายชื่อลูกค้า</td>
            <td align='center' class='style30'>เขตการขาย</td> 
            <td align='center' class='style30'>สินค้าจริงตรงกับข้อมูลที่บริษัทให้ก่อนสั่งซื้อ และสามารถใช้งานได้อย่างมีประสิทธิภาพ</td>
            <td align='center' class='style30'>ระดับคุณภาพสินค้าเมื่อเทียบกับบริษัทอื่นๆ</td> 
            <td align='center' class='style30'>ความพึงพอใจในสินค้าโดยรวม</td>
            <td align='center' class='style30'>รวม (คะแนนเต็ม 10 คะแนน)</td>
            <td align='center' class='style30'>%</td>
            <td align='center' class='style30'>ตั้งแต่ 20 คะแนนขึ้นไป = P (F = ไม่ผ่าน)</td>
            <td align='center' class='style30'>ข้อเสนอแนะ</td></tr></thead>";

            $strSQL = "SELECT *  FROM  tb_research where product_good !='0' and sale_code !='SM1'  and sale_code !='MM1' and sale_code !='S31' and sale_code !='S32'";
            if($start_date !=""){ $strSQL .= ' AND iv_date >= "'.$start_date.'"'; }
            if($end_date !=""){ $strSQL .= ' AND iv_date <= "'.$end_date.'"'; }
            if($type_customer !=''){ $strSQL .= ' AND  grade = "'.$type_customer.'"'; }
            $objQuery = mysqli_query($com1,$strSQL) or die ("Error Query [".$strSQL."]");

            $n=1; $s=0;	
            $sum_product_good=0; $sum_product_link=0; $sum_product_corect=0;

            while($objResult = mysqli_fetch_array($objQuery)){
                $date_research = DateThai($objResult["date_research"]);
                $iv_number =  $objResult["iv_number"];
                $customer_name = $objResult["customer_name"];
                $sale_code = $objResult["sale_code"];	
                $product_good = $objResult["product_good"];
                $product_link = $objResult["product_link"];
                $product_corect =  $objResult["product_corect"];
                $sum_pro = number_format(($product_good+$product_link+$product_corect)/3,0);
                $sum_pro1 = $product_good+$product_link+$product_corect;
                $pro_persent = number_format(($sum_pro1*100)/30,0);
                $pro_pass = ($pro_persent >= 80) ? "P":"F";

                $sum_product_good += $product_good; $sum_product_link += $product_link; $sum_product_corect += $product_corect;
                $suggest_1 = $objResult["suggest_1"];

                echo "<tr>
                <td align='center' class='style30'>{$n}</td>
                <td align='left' class='style30'>{$date_research}</td>
                <td align='center' class='style30'>{$iv_number}</td>
                <td align='left' class='style30'>{$customer_name}</td>
                <td align='center' class='style30'>{$sale_code}</td>
                <td align='center' class='style30'>{$product_good}</td>
                <td align='center' class='style30'>{$product_link}</td> 
                <td align='center' class='style30'>{$product_corect}</td>
                <td align='center' class='style30'>{$sum_pro}</td>
                <td align='center' class='style30'>{$pro_persent} %</td>
                <td align='center' class='style30'>{$pro_pass}</td>
                <td align='left' class='style30'>{$suggest_1}</td></tr>";
                $n++; $s++;
            }
            $sum_pro_p1 = (($sum_product_good)+($sum_product_link)+($sum_product_corect))/$s;
            $sum_pro_p = number_format(($sum_pro_p1)/3,2);
            $pro_persent_p = number_format(($sum_pro_p1*100)/30,2);
            $pro_pass_p = ($pro_persent_p >= 80) ? "P":"F";

            echo "<tr bgcolor='yellow'>
            <td class='style30'></td><td class='style30'></td><td class='style30'></td><td class='style30'></td>
            <td align='center' class='style30'>คำเฉลี่ย</td>
            <td align='center' class='style30'>".number_format(($sum_product_good)/$s,2)."</td>
            <td align='center' class='style30'>".number_format(($sum_product_link)/$s,2)."</td> 
            <td align='center' class='style30'>".number_format(($sum_product_corect)/$s,2)."</td>
            <td align='center' class='style30'>{$sum_pro_p}</td>
            <td align='center' class='style30'>{$pro_persent_p} %</td>
            <td align='center' class='style30'>{$pro_pass_p}</td>
            <td class='style30'></td></tr></table>";
        } else {
            // ฟอร์มเก่า (type_customer != 'A') – ใช้บล็อกเดิม 4 ข้อ
            echo '<center><span class="style15">ความพึงพอใจต่อสินค้า/ผลิตภัณฑ์</span></center><br>';
            echo "<table border='1' width='100%' class='w3-table'><thead><tr>
            <td align='center' class='style30'>ลำดับ</td>
            <td align='center' class='style30'>วันที่ทำแบบสอบถาม</td>
            <td align='center' class='style30'>เลขที่เอกสาร</td>
            <td align='center' class='style30'>รายชื่อลูกค้า</td>
            <td align='center' class='style30'>เขตการขาย</td> 
            <td align='center' class='style30'>สินค้าจริงตรงกับข้อมูลที่บริษัทให้ก่อนสั่งซื้อ และสามารถใช้งานได้อย่างมีประสิทธิภาพ</td>
            <td align='center' class='style30'>ระดับคุณภาพสินค้าเมื่อเทียบกับบริษัทอื่นๆ</td> 
            <td align='center' class='style30'>ความพึงพอใจในสินค้าโดยรวม</td>
            <td align='center' class='style30'>มีแนวโน้มที่จะแนะนำให้เพื่อน หรือคนรู้จักมาใช้บริการของ ALLWELL มากน้อยเพียงใด </td>
            <td align='center' class='style30'>รวม (คะแนนเต็ม 10 คะแนน)</td>
            <td align='center' class='style30'>%</td>
            <td align='center' class='style30'>ตั้งแต่ 20 คะแนนขึ้นไป = P (F = ไม่ผ่าน)</td>
            <td align='center' class='style30'>ข้อเสนอแนะ</td></tr></thead>";

            $strSQL = "SELECT *  FROM  tb_research where product_good !='0'";
            if($start_date !=""){ $strSQL .= ' AND iv_date >= "'.$start_date.'"'; }
            if($end_date !=""){ $strSQL .= ' AND iv_date <= "'.$end_date.'"'; }
            if($type_customer !=''){ $strSQL .= ' AND  grade = "'.$type_customer.'"'; }
            $objQuery = mysqli_query($com1,$strSQL) or die ("Error Query [".$strSQL."]");

            $n=1; $s=0;	
            $sum_product_good=0; $sum_product_link=0; $sum_product_corect=0; $sum_product_3=0;

            while($objResult = mysqli_fetch_array($objQuery)){
                $date_research = DateThai($objResult["date_research"]);
                $iv_number =  $objResult["iv_number"];
                $customer_name = $objResult["customer_name"];
                $sale_code = $objResult["sale_code"];	
                $product_good = $objResult["product_good"];
                $product_link = $objResult["product_link"];
                $product_corect =  $objResult["product_corect"];
                $product_3 =  $objResult["product_3"];
                $sum_pro = ($product_good+$product_link+$product_corect+$product_3)/4;
                $sum_pro1 = $product_good+$product_link+$product_corect+$product_3;
                $pro_persent = number_format(($sum_pro1*100)/40,2);
                $pro_pass = ($pro_persent >= 80) ? "P":"F";
                $suggest_1 = $objResult["suggest_1"];

                $sum_product_good += $product_good; $sum_product_link += $product_link; 
                $sum_product_corect += $product_corect; $sum_product_3 += $product_3;

                echo "<tr>
                <td align='center' class='style30'>{$n}</td>
                <td align='left' class='style30'>{$date_research}</td>
                <td align='center' class='style30'>{$iv_number}</td>
                <td align='left' class='style30'>{$customer_name}</td>
                <td align='center' class='style30'>{$sale_code}</td>
                <td align='center' class='style30'>{$product_good}</td>
                <td align='center' class='style30'>{$product_link}</td> 
                <td align='center' class='style30'>{$product_corect}</td>
                <td align='center' class='style30'>{$product_3}</td>
                <td align='center' class='style30'>{$sum_pro}</td>
                <td align='center' class='style30'>{$pro_persent} %</td>
                <td align='center' class='style30'>{$pro_pass}</td>
                <td align='left' class='style30'>{$suggest_1}</td></tr>";
                $n++; $s++;
            }
            $sum_pro_p1 = (($sum_product_good)+($sum_product_link)+($sum_product_corect)+($sum_product_3))/$s;
            $sum_pro_p = number_format(($sum_pro_p1)/4,2);
            $pro_persent_p = number_format(($sum_pro_p1*100)/40,2);
            $pro_pass_p = ($pro_persent_p >= 80) ? "P":"F";

            echo "<tr bgcolor='yellow'>
            <td class='style30'></td><td class='style30'></td><td class='style30'></td><td class='style30'></td>
            <td align='center' class='style30'>คำเฉลี่ย</td>
            <td align='center' class='style30'>".number_format(($sum_product_good)/$s,2)."</td>
            <td align='center' class='style30'>".number_format(($sum_product_link)/$s,2)."</td> 
            <td align='center' class='style30'>".number_format(($sum_product_corect)/$s,2)."</td>
            <td align='center' class='style30'>".number_format(($sum_product_3)/$s,2)."</td>	
            <td align='center' class='style30'>{$sum_pro_p}</td>
            <td align='center' class='style30'>{$pro_persent_p} %</td>
            <td align='center' class='style30'>{$pro_pass_p}</td>
            <td class='style30'></td></tr></table>";
        }
    }

/* =======================================================================
   ส่วนที่ 3: ความพึงพอใจต่อพนักงานผู้ติดตั้ง/สาธิต (บริการจัดส่ง)
   ======================================================================= */
} else if ($type_cs == '3') {

    if ($useNewForm) {
        // ===== ฟอร์มใหม่ (3 ข้อ / เต็ม 5) =====
        $sql = "SELECT * FROM tb_research WHERE cs_neat != '0' AND iv_date >= '".NEW_FORM_START."'";
        if ($start_date != "") $sql .= ' AND iv_date >= "'.$start_date.'"';
        if ($end_date   != "") $sql .= ' AND iv_date <= "'.$end_date.'"';
        if ($type_customer != "") $sql .= ' AND grade = "'.$type_customer.'"';
        $sql .= " AND sale_code NOT IN ('SM1','MM1','S31','S32') ";
        $qry = mysqli_query($com1,$sql) or die("Error Query [".$sql."]");

        echo '<center><span class="style15">การสอบถามความพึงพอใจของลูกค้าที่มีต่อการบริการจัดส่ง</span></center><br>';
        echo "<table border='1' width='100%' class='w3-table'><thead><tr>
        <td align='center' class='style30'>ลำดับ</td>
        <td align='center' class='style30'>วันที่ทำแบบสอบถาม</td>
        <td align='center' class='style30'>เลขที่เอกสาร</td>
        <td align='center' class='style30'>รายชื่อลูกค้า</td>
        <td align='center' class='style30'>เขตการขาย</td> 
        <td align='center' class='style30'>พนักงานจัดส่งสุภาพ แต่งกายเหมาะสม และปฏิบัติตามมาตรการความปลอดภัย</td>
        <td align='center' class='style30'>อธิบายการใช้งาน พร้อมบริการติดตั้ง/สาธิตการใช้งานสินค้า</td> 
        <td align='center' class='style30'>ขนส่งและติดตั้งสินค้า และดูแลหลังการติดตั้งราบรื่นเรียบร้อย</td>
        <td align='center' class='style30'>รวม (คะแนนเต็ม 5 คะแนน)</td>
        <td align='center' class='style30'>%</td>
        <td align='center' class='style30'>สถานะ</td>
        <td align='center' class='style30'>ข้อเสนอแนะ</td></tr></thead>";

        $n=1; $rows=0;
        $sum_cs_neat=0; $sum_cs_explain=0; $sum_cs_3=0;

        while($rs = mysqli_fetch_array($qry)){
            $date_research = DateThai($rs["date_research"]);
            $iv_number     = $rs["iv_number"];
            $customer_name = $rs["customer_name"];
            $sale_code     = $rs["sale_code"];

            $cs_neat    = (float)$rs["cs_neat"];
            $cs_explain = (float)$rs["cs_explain"];
            $cs_3       = (float)$rs["cs_3"];

            $avg     = ($cs_neat+$cs_explain+$cs_3)/3;
            $percent = percent_from_avg5($avg);
            $pass    = ($percent>=80) ? "P":"F";

            $sum_cs_neat += $cs_neat; $sum_cs_explain += $cs_explain; $sum_cs_3 += $cs_3; $rows++;

            echo "<tr>
            <td align='center' class='style30'>{$n}</td>
            <td align='left' class='style30'>{$date_research}</td>
            <td align='center' class='style30'>{$iv_number}</td>
            <td align='left' class='style30'>{$customer_name}</td>
            <td align='center' class='style30'>{$sale_code}</td>
            <td align='center' class='style30'>{$cs_neat}</td>
            <td align='center' class='style30'>{$cs_explain}</td>
            <td align='center' class='style30'>{$cs_3}</td>
            <td align='center' class='style30'>".number_format($avg,2)."</td>
            <td align='center' class='style30'>".number_format($percent,2)." %</td>
            <td align='center' class='style30'>{$pass}</td>
            <td align='left' class='style30'>".$rs["suggest_2"]."</td></tr>";
            $n++;
        }
        $avg_neat    = $rows? $sum_cs_neat/$rows    : 0;
        $avg_explain = $rows? $sum_cs_explain/$rows : 0;
        $avg_3       = $rows? $sum_cs_3/$rows       : 0;
        $avg_total   = ($avg_neat+$avg_explain+$avg_3)/3;
        $percent_all = percent_from_avg5($avg_total);
        $pass_all    = ($percent_all>=80) ? "P":"F";

        echo "<tr bgcolor='yellow'>
        <td class='style30'></td><td class='style30'></td><td class='style30'></td><td class='style30'></td>
        <td align='center' class='style30'>ค่าเฉลี่ย</td>
        <td align='center' class='style30'>".number_format($avg_neat,2)."</td>
        <td align='center' class='style30'>".number_format($avg_explain,2)."</td>
        <td align='center' class='style30'>".number_format($avg_3,2)."</td>
        <td align='center' class='style30'>".number_format($avg_total,2)."</td>
        <td align='center' class='style30'>".number_format($percent_all,2)." %</td>
        <td align='center' class='style30'>{$pass_all}</td>
        <td class='style30'></td></tr></table>";

    } else {
        // ===== ฟอร์มเก่า (ใช้โค้ดเดิม 5 ข้อ/เต็ม 10) =====
        echo '<center><span class="style15">ความพึงพอใจต่อพนักงานผู้ติดตั้ง/สาธิต</span></center><br>';
        echo "<table border='1' width='100%' class='w3-table'><thead><tr>
        <td align='center' class='style30'>ลำดับ</td>
        <td align='center' class='style30'>วันที่ทำแบบสอบถาม</td>
        <td align='center' class='style30'>เลขที่เอกสาร</td>
        <td align='center' class='style30'>รายชื่อลูกค้า</td>
        <td align='center' class='style30'>เขตการขาย</td> 
        <td align='center' class='style30'>พนักงานจัดส่งพูดจาสุภาพ อัธยาศัยดี แต่งกายสุภาพ วางตัวเหมาะสม</td>
        <td align='center' class='style30'>พนักงานจัดส่งสามารถอธิบาย สาธิตวิธีการใช้งาน และตอบข้อซักถามได้ชัดเจน</td> 
        <td align='center' class='style30'>พนักงานจัดส่งดูแล และขนย้ายสินค้าเข้าติดตั้ง ณ สถานที่ใช้งานได้เป็นอย่างดี</td> 
        <td align='center' class='style30'>พนักงานจัดส่งโทรประสานงานก่อนส่งสินค้าจริง และส่งมอบสินค้าตามเวลาที่ได้นัดหมายไว้</td> 
        <td align='center' class='style30'>คุณภาพการบริการจัดส่งเมื่อเทียบกับบริษัทอื่นๆ</td> 
        <td align='center' class='style30'>รวม (คะแนนเต็ม 10 คะแนน)</td>
        <td align='center' class='style30'>%</td>
        <td align='center' class='style30'>ตั้งแต่ 20 คะแนนขึ้นไป = P (F = ไม่ผ่าน)</td>
        <td align='center' class='style30'>ข้อเสนอแนะ</td></tr></thead>";

        $strSQL = "SELECT *  FROM  tb_research where cs_neat !='0' and sale_code !='SM1' and sale_code !='MM1' and sale_code !='S31' and sale_code !='S32'";
        if($start_date !=""){ $strSQL .= ' AND iv_date >= "'.$start_date.'"'; }
        if($end_date !=""){ $strSQL .= ' AND iv_date <= "'.$end_date.'"'; }
        if($type_customer !=''){ $strSQL .= ' AND  grade = "'.$type_customer.'"'; }
        $objQuery = mysqli_query($com1,$strSQL) or die ("Error Query [".$strSQL."]");

        $n=1; $s=0;	
        $sum_cs_neat=0; $sum_cs_explain=0; $sum_cs_3=0; $sum_cs_4=0; $sum_cs_5=0;

        while($objResult = mysqli_fetch_array($objQuery)){
            $date_research = DateThai($objResult["date_research"]);
            $iv_number =  $objResult["iv_number"];
            $customer_name = $objResult["customer_name"];
            $sale_code = $objResult["sale_code"];
            $cs_neat = $objResult["cs_neat"];
            $cs_explain = $objResult["cs_explain"];
            $cs_3 = $objResult["cs_3"];
            $cs_4 = $objResult["cs_4"];
            $cs_5 = $objResult["cs_5"];
            $sum_cs = ($cs_neat+$cs_explain+$cs_3+$cs_4+$cs_5)/5;
            $sum_cs1 = $cs_neat+$cs_explain+$cs_3+$cs_4+$cs_5;
            $cs_persent = ($sum_cs1*100)/50;
            $cs_pass = ($cs_persent >= 80) ? "P":"F";
            $sum_cs_neat += $cs_neat; $sum_cs_explain += $cs_explain; $sum_cs_3 += $cs_3; $sum_cs_4 += $cs_4; $sum_cs_5 += $cs_5;
            $suggest_2 = $objResult["suggest_2"];

            echo "<tr>
            <td align='center' class='style30'>{$n}</td>
            <td align='left' class='style30'>{$date_research}</td>
            <td align='center' class='style30'>{$iv_number}</td>
            <td align='left' class='style30'>{$customer_name}</td>
            <td align='center' class='style30'>{$sale_code}</td>
            <td align='center' class='style30'>{$cs_neat}</td>
            <td align='center' class='style30'>{$cs_explain}</td>
            <td align='center' class='style30'>{$cs_3}</td>
            <td align='center' class='style30'>{$cs_4}</td>
            <td align='center' class='style30'>{$cs_5}</td>
            <td align='center' class='style30'>{$sum_cs}</td>
            <td align='center' class='style30'>{$cs_persent} %</td>
            <td align='center' class='style30'>{$cs_pass}</td>
            <td align='left' class='style30'>{$suggest_2}</td></tr>";
            $n++; $s++;
        }
        $sum_cs_s1 = (($sum_cs_neat)+($sum_cs_explain)+($sum_cs_3)+($sum_cs_4)+($sum_cs_5))/$s;
        $sum_cs_s  = ($sum_cs_s1)/5;
        $cs_persent_s = ($sum_cs_s1*100)/50;
        $cs_pass_s    = ($cs_persent_s >= 80) ? "P":"F";

        echo "<tr bgcolor='yellow'>
        <td class='style30'></td><td class='style30'></td><td class='style30'></td><td class='style30'></td>
        <td align='center' class='style30'>ค่าเฉลี่ย</td>
        <td align='center' class='style30'>".number_format(($sum_cs_neat)/$s,2)."</td>
        <td align='center' class='style30'>".number_format(($sum_cs_explain)/$s,2)."</td> 
        <td align='center' class='style30'>".number_format(($sum_cs_3)/$s,2)."</td> 
        <td align='center' class='style30'>".number_format(($sum_cs_4)/$s,2)."</td> 
        <td align='center' class='style30'>".number_format(($sum_cs_5)/$s,2)."</td> 
        <td align='center' class='style30'>".number_format($sum_cs_s,2)."</td>
        <td align='center' class='style30'>".number_format($cs_persent_s,2)." %</td>
        <td align='center' class='style30'>{$cs_pass_s}</td>
        <td class='style30'></td></tr></table>";
    }
}
?>

</div>
</body>
</html>
