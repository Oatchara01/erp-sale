
<?php
$ref_id = $_GET['ref_id'];
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment; filename=$ref_id.doc");


function Convert($amount_number)
{
$amount_number = number_format($amount_number, 2, ".","");
$pt = strpos($amount_number , ".");
$number = $fraction = "";
if ($pt === false)
$number = $amount_number;
else
{
$number = substr($amount_number, 0, $pt);
$fraction = substr($amount_number, $pt + 1);
}
$ret = "";
$baht = ReadNumber ($number);
if ($baht != "")

$ret .= $baht . "บาท";
$satang = ReadNumber($fraction);
if ($satang != "")
$ret .=  $satang . "สตางค์";
else
$ret .= "ถ้วน";
return $ret;
}
function ReadNumber($number)
{
$position_call = array("แสน", "หมื่น", "พัน", "ร้อย", "สิบ", "");
$number_call = array("", "หนึ่ง", "สอง", "สาม", "สี่", "ห้า", "หก", "เจ็ด", "แปด", "เก้า");
$number = $number + 0;
$ret = "";
if ($number == 0) return $ret;
if ($number > 1000000)
{
$ret .= ReadNumber(intval($number / 1000000)) . "ล้าน";
$number = intval(fmod($number, 1000000));
}

$divider = 100000;
$pos = 0;
while($number > 0)
{
$d = intval($number / $divider);
$ret .= (($divider == 10) && ($d == 2)) ? "ยี่" :
((($divider == 10) && ($d == 1)) ? "" :
((($divider == 1) && ($d == 1) && ($ret != "")) ? "เอ็ด" : $number_call[$d]));
$ret .= ($d ? $position_call[$pos] : "");
$number = $number % $divider;
$divider = $divider / 10;
$pos++;
}
return $ret;
}


?>



<style>
		body {
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
        font: 12pt "Angsana New";
    }
	table {
	  border-collapse: collapse;
	  font-size:14pt;
	}
	.tablel {
	  border-collapse: collapse;
	  font-size:10pt;
	}
	.tablepr {
	  border-collapse: collapse;
	  font-size:12pt;
	}
	.tablep, .tr, .td {
	  border: 1px solid black;
	}
    * {
        box-sizing: border-box;
        -moz-box-sizing: border-box;
    }
    .page {
        width: 210mm;
        max-height: 297mm;
        padding-left: 10mm;
		padding-right: 10mm;
		padding-top: 5mm;
		padding-bottom: 0mm;
        margin: 0mm auto;
        /*border: 0px #D3D3D3 solid;
        border-radius: 0px;*/
        background: white;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0);
    }
    
    @page {
        size: A4;
        margin: 0;
    }
	@page Section1 {size:841.7pt 595.45pt; margin:1.0in 1.25in 1.0in 1.25in;mso-header-margin:.5in;mso-footer-margin:.5in;mso-paper-source:0;}
	div.Section1 {page:Section1;}
	@page Section2 {size:595.45pt 841.7pt;mso-page-orientation:landscape;margin:0.4in 0.4in 0.4in 0.4in;mso-header-margin:.4in;mso-footer-margin:.4in;mso-paper-source:0;}
	div.Section2 {page:Section2;}

	@media screen {
	  div.divFooter {
		display: none;
	  }
    @media print {
        html, body {
            width: 210mm;
            height: 297mm;
			margin: 0;
			 div.divFooter {
				position: fixed;
				bottom: 0;
			 }
        }
    }
	h1,h2,h3,h4,h5,h6 {
		font: 14pt "Angsana New";
	}
</style>
<?php error_reporting(~E_NOTICE);
date_default_timezone_set("Asia/Bangkok");
function Datethai($strDate) {
    $strYear = date("Y", strtotime($strDate)) + 543;
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));

    $thaiMonths = array(
        1 => 'มกราคม', 2 => 'กุมภาพันธ์', 3 => 'มีนาคม',
        4 => 'เมษายน', 5 => 'พฤษภาคม', 6 => 'มิถุนายน',
        7 => 'กรกฎาคม', 8 => 'สิงหาคม', 9 => 'กันยายน',
        10 => 'ตุลาคม', 11 => 'พฤศจิกายน', 12 => 'ธันวาคม'
    );

    $strMonthThai = $thaiMonths[$strMonth];
    return "$strDay $strMonthThai $strYear";
}


include"dbconnect.php";

$ref_id = $_GET['ref_id'];
$strSQL = "SELECT * from hos__rental  WHERE ref_id = '".$ref_id."' ";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);

$promis_date = Datethai($objResult["promis_date"]);

$count_m = $objResult["count_m"];
$unit_m = $objResult["unit_m"];
$mmm = "$count_m $unit_m";

$promis_date1 = Datethai(date("Y-m-d", strtotime($mmm, strtotime($objResult["promis_date"]))));
$head_product = $objResult["head_product"];
$des_productunit = $objResult["des_productunit"];
$des_product = $objResult["des_product"];

$strSQL1 = "SELECT SUM(amount) AS amount from hos__subrental  WHERE ref_idd = '".$ref_id."' and product_id ='5111'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die(mysqli_error());
$objResult1 = mysqli_fetch_array($objQuery1);

$amount = number_format($objResult1["amount"],0)."";

$strSQL2 = "SELECT SUM(amount) AS amount from hos__subrental  WHERE ref_idd = '".$ref_id."' and product_id ='5112'";
$objQuery2 = mysqli_query($conn,$strSQL2) or die(mysqli_error());
$objResult2 = mysqli_fetch_array($objQuery2);

$price = number_format($objResult2["amount"],0)."";
?>
<div class="Section2 page">
<body>

<table style="width:100%;">
	<tr>
		<td style="width:100%;text-align:center;"><b>สัญญาเช่า</b><br>
			<b><?php echo $head_product; ?></b>
		</td>
	</tr>
</table>
<table style="width:100%;">
	<tr>
		<td style="width:70%;text-align:left;"></td>
		<td style="width:30%;text-align:left;">ทำที่ บริษัท ออลล์เวล ไลฟ์ จำกัด</td>
	</tr>
	<tr>
		<td style="width:70%;text-align:left;"></td>
		<td style="width:30%;text-align:left;">วันที่ <?php echo $promis_date; ?></td>
	</tr>
	<tr>
		<td style="width:70%;text-align:left;"></td>
		<td style="width:30%;text-align:left;">เลขที่สัญญา <?php echo $objResult["promis_no"]; ?></td>
	</tr>
</table>
	<br>
<table style="width:100%;">
	<tr>
		<td style="width:100%;text-align:left;">
สัญญานี้ทำขึ้นระหว่าง บริษัท ออลล์เวล ไลฟ์ จำกัด อยู่บ้านเลขที่ 73, 75 ซอยจรัญสนิทวงศ์ 89/2 ถนนจรัญสนิทวงศ์
แขวงบางอ้อ เขตบางพลัด จังหวัดกรุงเทพมหานคร 10700 โดยนายสมบัติ โรจนสถาพรกิจ กรรมการผู้มีอำนาจ ซึ่งต่อไป 
ในสัญญานี้จะเรียกว่า "ผู้ให้เช่า" ฝ่ายหนึ่งกับ คุณ<?php echo $objResult["bill_name"]; ?> อยู่บ้านเลขที่ <?php echo $objResult["bill_address"]; ?> ซึ่งต่อไปนี้ในสัญญานี้ จะเรียกว่า "ผู้เช่า" อีกฝ่ายหนึ่ง ทั้งสองฝ่ายได้ตกลงทำสัญญากัน มีข้อความต่อไปนี้

		</td>
	</tr>
	
</table>	
		<br>
<table style="width:100%;">
	
	<tr>
		<td style="width:100%;text-align:left;"><b>ข้อ 1 ทรัพย์ที่เช่า</b></td>
	</tr>
	<tr>
		<td style="width:100%;text-align:left;">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ผู้ให้เช่าตกลงให้เช่าและผู้เช่าตกลงเช่า <?php echo $des_productunit; ?> รายละเอียดปรากฏตามแบบรูปและคุณสมบัติแนบท้ายสัญญานี้ ซึ่งถือเป็นส่วนหนึ่งของสัญญานี้


		</td>
	</tr>
	
</table>	
	
	
	<br>
<table style="width:100%;">
<tr><td style="width:100%;text-align:left;"><b>ข้อ 2 อัตราค่าเช่า</b></td></tr>
<tr><td style="width:100%;text-align:left;">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ผู้เช่าตกลงชำระค่าเช่า <?php echo $des_product; ?> ตามข้อ 1 เป็นรายเดือนๆ ละ <?php echo $price; ?> บาท 
(<?php echo Convert($objResult2["amount"]); ?>) รวมภาษีมูลค่าเพิ่มแล้ว ให้แก่ผู้ให้เช่า โดยจะชำระล่วงหน้าทุกวันที่ 14 ของทุกเดือน</td></tr>
</table>	

	<br>
<table style="width:100%;">
<tr><td style="width:100%;text-align:left;"><b>ข้อ 3 ระยะเวลาการเช่า</b></td></tr> <?php //อย่างน้อย สองเดือนติดต่อกัน ?>
<tr><td style="width:100%;text-align:left;">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ผู้เช่าต้องเช่า <?php echo $des_product; ?> ตามข้อ 1 นับตั้งแต่วันที่ <?php echo $promis_date; ?> ถึงวันที่ <?php echo $promis_date1; ?> หลังจากนั้น หากผู้เช่าประสงค์จะเช่า <?php echo $des_product; ?> ดังกล่าวต่อไปอีก ผู้เช่ามีสิทธิเช่าต่อ ครั้งละเดือน และเมื่อไม่ประสงค์เช่าต่อ แล้วให้แจ้งผู้ให้เช่าทราบล่วงหน้า 14 วัน
</td></tr>
</table>
	
<br>
<table style="width:100%;">
<tr><td style="width:100%;text-align:left;"><b>ข้อ 4 เงินประกัน </b></td></tr>
<tr><td style="width:100%;text-align:left;">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ผู้เช่าตกลงมอบเงินประกันจำนวน <?php echo $amount; ?> บาท (<?php echo Convert($objResult1["amount"]); ?>) ให้แก่ผู้ให้เช่า เงินประกันนี้ผู้ให้เช่าจะคืนให้แก่ผู้เช่าโดยไม่มีดอกเบี้ยเมื่อสัญญาเช่าสิ้นสุดลง โดยมิใช่ความผิดของผู้เช่า และผู้เช่าไม่มีหนี้สินค้างชำระใดๆ 
ต่อผู้ให้เช่า

</td></tr>
<tr><td style="width:100%;text-align:left;">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ในกรณีที่ผู้เช่ามีหนี้สินค้างชำระแก่ผู้ให้เช่า ผู้ให้เช่ามีสิทธิหักจากเงินประกันได้ และหากยังมีเงินเหลืออยู่ ผู้ให้เช่า
จึงจะคืนให้แก่ผู้เช่า แต่หากหักหนี้สินดังกล่าว จากเงินประกันแล้วยังไม่เพียงพอต่อเงินที่ผู้เช่าค้างชำระ ผู้ให้เช่ามีสิทธิเรียกร้องจากผู้เช่าจนครบจำนวนที่ค้างชำระ
 
ต่อผู้ให้เช่า

</td></tr>	
</table>	
	
	
	<br>
<?php
  $moving_fee = '';
  if($objResult["type_product"] == '1') {
      $moving_fee = 'ตามระยะทางเริ่มต้นที่ 1,200 บาท (หนึ่งพันสองร้อยบาทถ้วน) ต่อหนึ่งครั้ง';
	  $moving_fee1 = "เตียง และอุปกรณ์";
	  
  } else if($objResult["type_product"] == '2') {
      $moving_fee = 'ตามระยะทางเริ่มต้นที่ 800 บาท (แปดร้อยบาทถ้วน) ต่อหนึ่งครั้ง';
	  $moving_fee1 = "$head_product";
  } else {
      $moving_fee = 'ตามระยะทางเริ่มต้นที่ 500 บาท (ห้าร้อยบาทถ้วน) ต่อหนึ่งครั้ง';
	  $moving_fee1 = "$head_product";
  }
?>	
	
<table style="width:100%;">
<tr><td style="width:100%;text-align:left;"><b>ข้อ 5 ค่าบริการจัดส่ง</b></td></tr>
<tr><td style="width:100%;text-align:left;">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ผู้ให้เช่ามีหน้าที่บริการจัดส่ง <?php echo $des_product; ?> ไปติดตั้ง ณ สถานที่ซึ่งผู้เช่ากำหนดและรับ <?php echo $des_product; ?> คืนเมื่อเลิกสัญญา ระหว่างการเช่า หากผู้เช่าประสงค์จะเคลื่อนย้าย<?php echo $moving_fee1; ?> ดังกล่าวข้างต้นไปสถานที่อื่นๆ ผู้เช่าชำระค่าบริการ <?php echo $moving_fee; ?> รวมภาษีมูลค่าเพิ่ม ให้แก่ผู้ให้เช่า

</td></tr>
</table>	

<br>	
<table style="width:100%;">
<tr><td style="width:100%;text-align:left;"><b>ข้อ 6 การเช่าช่วง</b></td></tr>
<tr><td style="width:100%;text-align:left;">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ผู้เช่าจะต้องใช้ <?php echo $des_product; ?> เพื่อกิจการและวัตถุประสงค์ของผู้เช่าโดยเฉพาะเท่านั้น ผู้เช่าจะนำ <?php echo $des_product; ?> ดังกล่าวไปให้บุคคลอื่นเช่าช่วงหรือใช้ร่วมกับผู้เช่ามิได้


</td></tr>
</table>		
	
<br>	
<table style="width:100%;">
<tr><td style="width:100%;text-align:left;"><b>ข้อ 7 การระวังรักษา</b></td></tr>
<tr><td style="width:100%;text-align:left;">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ผู้เช่าจะต้องใช้ <?php echo $des_product; ?> ด้วยความระมัดระวังเยี่ยงวิญญูชนจะใช้ทรัพย์ของตน

</td></tr>
<tr><td style="width:100%;text-align:left;">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ในกรณีที่ <?php echo $des_product; ?> ที่เช่าเกิดสูญหาย ถูกทำลายไปเนื่องจากความผิดของผู้เช่า หรือเพราะผู้เช่าใช้ความระมัดระวังไม่เพียงพอ ผู้เช่าจะต้องรับผิดชดใช้ค่าเสียหาย แก่ผู้ให้เช่า
</td></tr>
</table>		
	
<br>	
<table style="width:100%;">
<tr><td style="width:100%;text-align:left;"><b>ข้อ 8 การซ่อมบำรุง</b></td></tr>
<tr><td style="width:100%;text-align:left;">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ในกรณีสินค้าเสียขัดข้องจากการใช้งานปกติผู้เช่าจะต้องแจ้งให้ผู้ให้เช่าทราบผู้ให้เช่าจะส่งพนักงานมาซ่อมหรือมาเปลี่ยน<?php echo $des_product; ?> แล้วแต่กรณี ในเวลาทำการ วันจันทร์-วันศุกร์ เวลา 8.00 น.-17.00 น.
</td></tr>
</table>		
	
<br>	
<table style="width:100%;">
<tr><td style="width:100%;text-align:left;"><b>ข้อ 9 การจำกัดความรับผิด</b></td></tr>
<tr><td style="width:100%;text-align:left;">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ผู้ให้เช่าไม่ต้องรับผิดใดๆ ในกรณีที่ <?php echo $des_product; ?> เสียหาย ขัดข้อง ไม่สามารถใช้งานได้บางส่วน หรือทั้งหมด และผู้เช่าจะไม่เรียกร้องค่าเสียหายใดๆ จากผู้ให้เช่า
</td></tr>
</table>		

<br>	
<table style="width:100%;">
<tr><td style="width:100%;text-align:left;"><b>ข้อ 10 การตรวจตรา</b></td></tr>
<tr><td style="width:100%;text-align:left;">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ผู้เช่าจะต้องอำนวยความสะดวกให้ผู้ให้เช่า หรือตัวแทนของผู้ให้เช่าเข้าตรวจตรา <?php echo $des_product; ?> ที่เช่าได้ตลอดเวลา

</td></tr>
</table>		
	
<br>	
<table style="width:100%;">
<tr><td style="width:100%;text-align:left;"><b>ข้อ 11 ค่าปรับ</b></td></tr>
<tr><td style="width:100%;text-align:left;">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;เมื่อสัญญาเช่าสิ้นสุดลงไม่ว่ากรณีใดๆ ผู้เช่าจะต้องส่งมอบ <?php echo $des_product; ?> ให้แก่ผู้ให้เช่าทันทีในวันสิ้นสุดสัญญา ถ้าผู้เช่าไม่ส่งมอบ <?php echo $des_product; ?> ในวันดังกล่าว ผู้เช่าต้องเสียค่าปรับวันละ <?php if($objResult["type_product"]=='1'){ ?> 1,000 บาท (หนึ่งพันบาทถ้วน) <?php }else{ ?> 400 บาท (สี่ร้อยบาทถ้วน)<?php } ?> รวมภาษีมูลค่าเพิ่มแล้วต่อสินค้า 1 ชิ้น ให้แก่ผู้ให้เช่าจนกว่าผู้เช่าจะ
ส่งมอบ <?php echo $des_product; ?> คืนให้แก่ผู้ให้เช่า

</td></tr>
</table>	
	
<br>
<table style="width:100%;">
<tr><td style="width:100%;text-align:left;"><b>ข้อ 12 กรณีผิดสัญญา</b></td></tr>
<tr><td style="width:100%;text-align:left;">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ในกรณีที่ผู้เช่าผิดสัญญาเช่าไม่ว่าข้อหนึ่งข้อใด หรือหลายข้อรวมกัน ผู้ให้เช่ามีสิทธิที่จะบอกกล่าวให้ผู้เช่าปฏิบัติให้ถูกต้องตามสัญญา หรือเรียกค่าเสียหาย หรือเลิกสัญญา โดยมิต้องบอกกล่าวก่อน หรือจะใช้สิทธิดังกล่าวรวมกันก็ได้
</td></tr>
	</table>
	
<br>
<table style="width:100%;">	
<tr><td style="width:100%;text-align:left;">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;สัญญานี้ทำขึ้นเป็นสองฉบับ มีข้อความถูกต้องตรงกัน คู่สัญญาได้อ่าน และเข้าใจ ข้อความดีแล้วเห็นว่าสัญญาถูกต้องจึงลงลายมือชื่อไว้เป็นสำคัญต่อหน้าพยาน
</td></tr>
</table>		
	
	<br><br>
<table style="width:100%;">	
<tr>
	<td style="width:40%;text-align:left;"></td>
	<td style="width:50%;text-align:right;">ลงชื่อ ...................................................................................... ผู้เช่า</td></tr>
<tr>
	<td style="width:40%;text-align:left;"></td>
	<td style="width:50%;text-align:center;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $objResult["rental_name"]; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</td></tr>
</table>
	
	
<br><br>
<table style="width:100%;">	
<tr>
	<td style="width:40%;text-align:left;"></td>
	<td style="width:50%;text-align:right;">ลงชื่อ ................................................................................. ผู้ให้เช่า</td></tr>
<tr>
	<td style="width:40%;text-align:left;"></td>
	<td style="width:50%;text-align:center;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo "นายสมบัติ  โรจนสถาพรกิจ"; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</td></tr>
</table>	
	
	
<br><br>
<table style="width:100%;">	
<tr>
	<td style="width:40%;text-align:left;"></td>
	<td style="width:50%;text-align:right;">ลงชื่อ ................................................................................... พยาน</td></tr>
<tr>
	<td style="width:40%;text-align:left;"></td>
	<td style="width:50%;text-align:center;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</td></tr>
</table>	
	
	
<br><br>
<table style="width:100%;">	
<tr>
	<td style="width:40%;text-align:left;"></td>
	<td style="width:50%;text-align:right;">ลงชื่อ ................................................................................... พยาน</td></tr>
<tr>
	<td style="width:40%;text-align:left;"></td>
	<td style="width:50%;text-align:center;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</td></tr>
</table>		
	
</body>
</div>
</html>