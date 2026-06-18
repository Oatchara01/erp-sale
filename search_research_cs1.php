<?php include "test.php"; ?>
<?php include "error_page.php"; ?>
<?php 
include "dbconnect_cs.php";
include "dbconnect.php";
?>
<link rel="stylesheet" href="css/w32.css">
<style type="text/css">
<!--
.style15 {font-size: 18px; color: #000000;}
.style16 {font-size: 15px; color: #FF0000;}
.style17 {font-size: 18px; color: #3333FF;}
.style32 {font-size: 11px}
.style33 {font-size: 12px; }
.style34 {color: #FF0000}
.style35 {font-size: 12px; color: #f2f2f2; }
.style37 {color: #CC0066; font-size: 14px; }
.style38 {font-size: 14px; color: #FF0000;}
.style39 {font-size: 14px; color: #339900;}
.style40 {font-size: 14px; color: #3333CC; }
-->
</style>

<?php
function DateThai($strDate){
    $strYear = date("Y",strtotime($strDate))+543;
    $strMonth= date("n",strtotime($strDate));
    $strDay= date("j",strtotime($strDate));
    $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
    $strMonthThai=$strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear";
}

date_default_timezone_set("Asia/Bangkok");

// ---------- รับช่วงวันที่ ----------
$start_date = isset($_POST["start_date"]) ? $_POST["start_date"] : "";
$end_date   = isset($_POST["end_date"])   ? $_POST["end_date"]   : "";

// ---------- ตั้งค่าวันที่อ้างอิงไทย ----------
if($start_date != ""){
    $date_arr = explode('-' , $start_date );
    $mm = $date_arr[1];
    $yy = $date_arr[0];
    $_month_name = array(
        "01"=>"มกราคม","02"=>"กุมภาพันธ์","03"=>"มีนาคม","04"=>"เมษายน",
        "05"=>"พฤษภาคม","06"=>"มิถุนายน","07"=>"กรกฎาคม","08"=>"สิงหาคม",
        "09"=>"กันยายน","10"=>"ตุลาคม","11"=>"พฤศจิกายน","12"=>"ธันวาคม"
    );
    $thai = $_month_name[$mm];
    $year = $yy + 543;
} else {
    $thai = ""; $year = "";
}

// ---------- เงื่อนไขรูปแบบฟอร์มใหม่ ตั้งแต่ 1/10/2568 (ค.ศ. 2025-10-01) ----------
$cutover_date = '2025-10-01';
$isNewForm = false;
if ($start_date !== "" && $start_date >= $cutover_date) {
    $isNewForm = true;
}
?>

<body>
<div class="w3-container w3-padding-large">
<center>
    <b><span class="style15">แบบประเมินความพึงพอใจของการจัดส่งและการประกอบติดตั้ง</span></b><br/>
    <?php if($thai!=""){ ?>
        <span class="style15">เดือน  <?php echo $thai; ?> ประจำปี  <?php echo $year; ?></span>
    <?php } ?>
</center>
<br/>

<table border="1" width="100%" class='w3-table'>
<thead>	
<tr>
<td width="2%"  align="center" class="style30">ลำดับ</td>
<td width="5%"  align="center" class="style30">วันที่ออกบิล</td>
<td width="5%"  align="center" class="style30">วันที่จัดส่ง</td>
<td width="5%"  align="center" class="style30">เลขที่เอกสาร</td>
<td width="10%" align="center" class="style30">ชื่อลูกค้า</td>
<td width="10%" align="center" class="style30">สถานที่ส่ง</td>
<td width="2%"  align="center" class="style30">1</td>
<td width="2%"  align="center" class="style30">2</td>
<td width="2%"  align="center" class="style30">3</td>
<td width="2%"  align="center" class="style30">4</td>
<td width="2%"  align="center" class="style30">5</td>
<td width="2%"  align="center" class="style30"><?php echo $isNewForm ? "รวม (เต็ม 5)" : "รวม (%)"; ?></td>
<td width="10%" align="center" class="style30">หมายเหตุ</td>
</tr>
</thead>
<tbody>
<?php
// ------------------ ชุดที่ 1: hos__so ------------------
$strSQL = "SELECT iv_no,sale_code,bill_name,close_reseach,job_no,ref_id,iv_date  
           FROM hos__so 
           WHERE reseach_kk ='1' AND status_doc ='Approve'";
if($start_date !=""){ $strSQL .= ' AND iv_date >= "'.$start_date.'"'; }
if($end_date !=""){   $strSQL .= ' AND iv_date <= "'.$end_date.'"'; }

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$n=1;
while($objResult = mysqli_fetch_array($objQuery)){
    $strSQL11 = "SELECT running_id,cs_neat,cs_explain,cs_3,cs_4,cs_5,suggest_2
                 FROM tb_research 
                 WHERE running_id ='".$objResult["job_no"]."'";
    $objQuery11 = mysqli_query($com1,$strSQL11) or die ("Error Query [".$strSQL11."]");
    $objResult11 = mysqli_fetch_array($objQuery11);

    $strSQL10 = "SELECT running,employee_send,start_date,address_name  
                 FROM tb_register_data 
                 WHERE running ='".$objResult["job_no"]."' ";
    $objQuery10 = mysqli_query($com1,$strSQL10) or die ("Error Query [".$strSQL10."]");
    $objResult10 = mysqli_fetch_array($objQuery10);

    $cs_neat    = (float)$objResult11["cs_neat"];
    $cs_explain = (float)$objResult11["cs_explain"];
    $cs_3       = (float)$objResult11["cs_3"];
    $cs_4       = (float)$objResult11["cs_4"];
    $cs_5       = (float)$objResult11["cs_5"];

    $sum_cs1 = $cs_neat + $cs_explain + $cs_3 + $cs_4 + $cs_5;

    // ---- คำนวณรวมตามโหมด ----
    if($isNewForm){
        // คะแนนเต็ม 5 → เฉลี่ย 5 ข้อ แล้วคุมเพดาน 5
        $sum_cs = $sum_cs1 / 5.0;
        if($sum_cs > 5){ $sum_cs = 5; }
        $sum_cs_display = number_format($sum_cs,2);
    }else{
        // แบบเดิม: แปลงเป็น % จากเต็ม 25
        $sum_cs = ($sum_cs1 * 100) / 25.0;
        $sum_cs_display = number_format($sum_cs,2);
    }

    // ตัด SM1 ออกตามเงื่อนไขเดิม
    if($objResult["sale_code"] == 'SM1'){ continue; }
?>
<tr>
<td align="center" class="style30"><?php echo $n; ?></td>
<td align="center" class="style30"><?php echo DateThai($objResult["iv_date"]); ?></td>
<td align="center" class="style30"><?php echo ($objResult10["start_date"]!='')? DateThai($objResult10["start_date"]) : '-'; ?></td>
<td align="center" class="style30"><?php echo $objResult["iv_no"]; ?></td>
<td align="left"   class="style30"><?php echo $objResult["bill_name"]; ?></td>
<td align="left"   class="style30"><?php echo $objResult10["address_name"]; ?></td>
<td align="center" class="style30"><?php echo $cs_neat; ?></td>
<td align="center" class="style30"><?php echo $cs_explain; ?></td>
<td align="center" class="style30"><?php echo $cs_3; ?></td>
<td align="center" class="style30"><?php echo $cs_4; ?></td>
<td align="center" class="style30"><?php echo $cs_5; ?></td>
<td align="center" class="style30"><?php echo $sum_cs_display; ?></td>
<td align="left"   class="style30"><?php echo $objResult11["suggest_2"]; ?></td>
</tr>
<?php 
    $n++;
} // end while hos__so

// ------------------ ชุดที่ 2: so__* (เตียง) ------------------
$strSQL = "SELECT doc_no,employee_name,billing_name,job_id,ref_id,doc_release_date  
           FROM ((so__submain 
           LEFT JOIN so__main ON so__submain.ref_idd=so__main.ref_id)
           LEFT JOIN tb_product ON so__submain.product_code=tb_product.product_ID) 
           WHERE unit_name='เตียง' AND cancel_ckk='0' AND sale_channel='4' 
                 AND job_id <> '' AND doc_no NOT LIKE '%B%' AND approve_complete='Approve'";
if($start_date !=""){ $strSQL .= ' AND doc_release_date >= "'.$start_date.'"'; }
if($end_date !=""){   $strSQL .= ' AND doc_release_date <= "'.$end_date.'"'; }

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$m = $n;
while($objResult = mysqli_fetch_array($objQuery)){
    $strSQL12 = "SELECT running_id,cs_neat,cs_explain,cs_3,cs_4,cs_5,suggest_2  
                 FROM tb_research 
                 WHERE running_id ='".$objResult["job_id"]."' AND cs_neat !='0'";
    $objQuery12 = mysqli_query($com1,$strSQL12) or die ("Error Query [".$strSQL12."]");
    $objResult12 = mysqli_fetch_array($objQuery12);

    $strSQL9 = "SELECT running,employee_send,start_date,address_name  
                FROM tb_register_data 
                WHERE running ='".$objResult["job_id"]."' ";
    $objQuery9 = mysqli_query($com1,$strSQL9) or die ("Error Query [".$strSQL9."]");
    $objResult9 = mysqli_fetch_array($objQuery9);

    $cs_neat    = (float)$objResult12["cs_neat"];
    $cs_explain = (float)$objResult12["cs_explain"];
    $cs_3       = (float)$objResult12["cs_3"];
    $cs_4       = (float)$objResult12["cs_4"];
    $cs_5       = (float)$objResult12["cs_5"];

    $sum_cs1 = $cs_neat + $cs_explain + $cs_3 + $cs_4 + $cs_5;

    if($isNewForm){
        $sum_cs = $sum_cs1 / 5.0;
        if($sum_cs > 5){ $sum_cs = 5; }
        $sum_cs_display = number_format($sum_cs,2);
    }else{
        $sum_cs = ($sum_cs1 * 100) / 25.0;
        $sum_cs_display = number_format($sum_cs,2);
    }
?>
<tr>
<td align="center" class="style30"><?php echo $m; ?></td>
<td align="center" class="style30"><?php echo DateThai($objResult["doc_release_date"]); ?></td>
<td align="center" class="style30"><?php echo ($objResult9["start_date"]!='')? DateThai($objResult9["start_date"]) : '-'; ?></td>
<td align="center" class="style30"><?php echo $objResult["doc_no"]; ?></td>
<td align="left"   class="style30"><?php echo $objResult["billing_name"]; ?></td>
<td align="left"   class="style30"><?php echo $objResult9["address_name"]; ?></td>
<td align="center" class="style30"><?php echo $cs_neat; ?></td>
<td align="center" class="style30"><?php echo $cs_explain; ?></td>
<td align="center" class="style30"><?php echo $cs_3; ?></td>
<td align="center" class="style30"><?php echo $cs_4; ?></td>
<td align="center" class="style30"><?php echo $cs_5; ?></td>
<td align="center" class="style30"><?php echo $sum_cs_display; ?></td>
<td align="left"   class="style30"><?php echo $objResult12["suggest_2"]; ?></td>
</tr>
<?php 
    $m++;
} // end while so__
?>
</tbody>
</table>

<?php
// --------- ส่วนสรุปจำนวนงาน (ยังคงวิธีคำนวณเดิม) ----------
$strSQL1 = "SELECT iv_no FROM hos__so WHERE reseach_kk='1' AND status_doc='Approve'";
if($start_date !=""){ $strSQL1 .= ' AND iv_date >= "'.$start_date.'"'; }
if($end_date !=""){   $strSQL1 .= ' AND iv_date <= "'.$end_date.'"'; }
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

$strSQL31 = "SELECT iv_no FROM hos__so WHERE reseach_kk='1' AND status_doc='Approve' AND with_cs='1'";
if($start_date !=""){ $strSQL31 .= ' AND iv_date >= "'.$start_date.'"'; }
if($end_date !=""){   $strSQL31 .= ' AND iv_date <= "'.$end_date.'"'; }
$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);

$strSQL2 = "SELECT doc_no  
            FROM ((so__submain LEFT JOIN so__main ON so__submain.ref_idd=so__main.ref_id)
            LEFT JOIN tb_product ON so__submain.product_code=tb_product.product_ID) 
            WHERE unit_name='เตียง' AND cancel_ckk='0' AND sale_channel='4' 
                  AND job_id <> '' AND doc_no NOT LIKE '%B%' AND approve_complete='Approve'";
if($start_date !=""){ $strSQL2 .= ' AND doc_release_date >= "'.$start_date.'"'; }
if($end_date !=""){   $strSQL2 .= ' AND doc_release_date <= "'.$end_date.'"'; }
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$Num_Rows2 = mysqli_num_rows($objQuery2);

$strSQL32 = "SELECT doc_no FROM so__main WHERE approve_complete='Approve' AND with_cs='1'";
if($start_date !=""){ $strSQL32 .= ' AND doc_release_date >= "'.$start_date.'"'; }
if($end_date !=""){   $strSQL32 .= ' AND doc_release_date <= "'.$end_date.'"'; }
$objQuery32 = mysqli_query($conn,$strSQL32) or die ("Error Query [".$strSQL32."]");
$Num_Rows32 = mysqli_num_rows($objQuery32);

$strSQL4 = "SELECT iv_no FROM hos__so WHERE reseach_kk='1' AND status_doc='Approve' AND sale_code='SM1'";
if($start_date !=""){ $strSQL4 .= ' AND iv_date >= "'.$start_date.'"'; }
if($end_date !=""){   $strSQL4 .= ' AND iv_date <= "'.$end_date.'"'; }
$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
$Num_Rows4 = mysqli_num_rows($objQuery4);

$sale = ($Num_Rows1 + $Num_Rows2) - $Num_Rows4;
$cs   = $Num_Rows31 + $Num_Rows32;
$sum  = $sale - $cs;

$per_sale = ($sale > 0) ? (($cs/$sale)*100)  : 0;
$per_cs   = ($sale > 0) ? (($sum/$sale)*100) : 0;
?>

<br><br>
<table width="100%" class='w3-table'>
<tr>
  <td width="35%" align="right" class="style30">สรุปงานทั้งหมด </td>
  <td width="10%" align="center" class="style30"><?php echo $sale; ?></td>
  <td width="35%" align="left" class="style30">งาน </td>
  <td width="20%" align="left" class="style30"></td>
</tr>
<tr>
  <td width="35%" align="right" class="style30">สํารวจได้ </td>
  <td width="10%" align="center" class="style30"><?php echo $cs; ?></td>
  <td width="35%" align="left" class="style30">งาน </td>
  <td width="20%" align="left" class="style30"></td>
</tr>
<tr>
  <td width="35%" align="right" class="style30">สํารวจไม่ได้ </td>
  <td width="10%" align="center" class="style30"><?php echo $sum; ?></td>
  <td width="35%" align="left" class="style30">งาน </td>
  <td width="20%" align="left" class="style30"></td>
</tr>
<tr>
  <td width="35%" align="right" class="style30">คิดเป็น </td>
  <td width="10%" align="center" class="style30"><?php echo number_format($per_sale,2); ?></td>
  <td width="35%" align="left" class="style30">% </td>
  <td width="20%" align="left" class="style30"></td>
</tr>
</table>
<br><br>

<table width="100%" class='w3-table'>
<?php if($isNewForm){ ?>
  <!-- หัวข้อใหม่ ตามภาพแนบ -->
  <tr><td width="5%" align="right" class="style30"> </td><td width="90%" align="left" class="style30">1. พนักงานจัดส่งสุภาพ แต่งกายเหมาะสม และปฏิบัติตามมาตรการความปลอดภัย</td></tr>
  <tr><td width="5%" align="right" class="style30"> </td><td width="90%" align="left" class="style30">2. จัดส่งตรงเวลา พร้อมบริการติดตั้ง/สาธิตการใช้งานสินค้า</td></tr>
  <tr><td width="5%" align="right" class="style30"> </td><td width="90%" align="left" class="style30">3. ประสานงานก่อนส่ง และดูแลเอาใจใส่การส่งมอบเรียบร้อย</td></tr>
<?php } else { ?>
  <!-- หัวข้อเดิม -->
  <tr><td width="5%" align="right" class="style30"> </td><td width="90%" align="left" class="style30">1. ส่งสินค้าตามเวลานัดหมาย </td></tr>
  <tr><td width="5%" align="right" class="style30"> </td><td width="90%" align="left" class="style30">2. มีการโทรประสานงานก่อนการจัดส่งจริง </td></tr>
  <tr><td width="5%" align="right" class="style30"> </td><td width="90%" align="left" class="style30">3. พนักงานแต่งกายเรียบร้อย และเหมาะสม </td></tr>
  <tr><td width="5%" align="right" class="style30"> </td><td width="90%" align="left" class="style30">4. กิริยามารยาทสุภาพ เรียบร้อย</td></tr>
  <tr><td width="5%" align="right" class="style30"> </td><td width="90%" align="left" class="style30">5. พนักงานติดตั้ง/สาธิต อธิบายวิธีการใช้งานผลิตภัณฑ์ได้ดี มีความเต็มใจในการให้บริการ</td></tr>
<?php } ?>
</table>

<br><br>
</div>
</body>
</html>
