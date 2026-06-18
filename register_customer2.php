<?php include('head3.php');
?>
 <title>Allwell Healthcare</title>
 <br>
<style type="text/css">
<!--
.style15 {
	font-size: 18px; color: #000000; 
}
	.style16 {
	font-size: 16px; color: #000000; 
}
.style30 {font-size: 12; }
.style32 {font-size: 11px}
.style33 {font-size: 12px; }
.style34 {color: #FF0000}
.style35 {font-size: 12px; color: #f2f2f2; }
.style37 {color: #FF0000; font-size: 14px; }
.style38 {color: #f2f2f2}
.style39 {font-size: 14px}
.style40 {font-size: 16px; color: #3300FF; }
	
-->
</style>

	
	
<?php

include"dbconnect.php";

$customer_no = $_GET["customer_no"];

$strSQL22 = "SELECT first_name,last_name,status_cus,customer_no FROM tb_customer WHERE customer_no = '".$customer_no."' ";
//echo $strSQL22;
$objQuery22 = mysqli_query($conn,$strSQL22) or die ("Error Query [".$strSQL22."]");
$objResult22 = mysqli_fetch_array($objQuery22);

$first_name = $objResult22["first_name"];
$last_name = $objResult22["last_name"];

?>

<fieldset></p></p></p>

<center>
<img src="img/allwell_2307.png" align="center"  width="100" height="120" border="0" /></br></p></p></p>
		
<span class="style15">ยินดีต้อนรับคุณ </span> <span class="style15"><b><?php echo $first_name;?>   <?php echo $last_name; ?></b></span></p> 
<span class="style40">(Welcome) </span></p> 
<span class="style15">รหัสสมาชิก </span> <span class="style15"><b><?php echo $customer_no;?> </b></span> </p>
<span class="style40">(Member Number) </span></p> 
<span class="style15">เข้าสู่ครอบครัว ALLWELL MEMBER ค่ะ :] </span></p>
<span class="style40">(To ALLWELL MEMBER FAMILY) </span></p> 
	
<a href="" class="w3-button w3-grey w3-center"><span class="style15"><b>คุณได้ทำการสมัครสมาชิกเสร็จสิ้นเเล้ว</b></span></button></a></p>
<span class="style40">(Your Application Has Been Applied) </span></p> 
<span class="style16"><b>กรุณาบันทึกภาพหน้าจอนี้ (Capture) ส่งให้พนักงานขายใน LINE OA "@allwell"</b></span> </p>
<span class="style40">(Please capture this page and send to sale representative via Line OA “@allwell”) </span></p> 
<?php /*และรับคูปองส่วนลด 100 บาทพิเศษ สำหรับสมาชิกใหม่ค่ะ*/ ?>
<span class="style16">เพื่อยืนยันการสมัครสมาชิก</span></p>
<span class="style40">(To Be Confirmed The Member Application) </span></p> 
</center></p>
<center>	
<a href="https://lin.ee/alnRcxb"><img src="img/line_add.jpg" align="center"  width="400" height="100" border="0" /></a></p>
<span class="style40">(Please Send Picture To Confirm The Application Here) </span></p>

<hr color="#000000"  width="100%" size="1.0" align="right"></p>

<?php /*" ปุ่ม Add Friend " ( เชื่อมไปที่ LINE OA เดี๋ยวส่งภาพปุ่มให้ ) https://lin.ee/alnRcxb*/ ?>
</center>	
</p>
<span class="style16"><b>สิทธิพิเศษสำหรับสมาชิก ALLWELL</b></span></p>
<span class="style40"><b>(Privilege For ALLWELL Membership) </b></span></p>
<span class="style16">- ส่วนลด 5% เมื่อซื้อสินค้าที่หน้าร้าน หรือ LINE OA ( ยอดซื้อต่อบิลสูงสุด 10,000 บาท )</span></p>
<span class="style40">- 5% Discount when purchase product at showroom or LINE OA (Maximum purchasing amount per receipt is 10,000 baht)</span></p>
<span class="style16">- คูปองส่วนลดประจำเดือนพิเศษที่มีให้กับสมาชิกเท่านั้น ( ส่งให้ลูกค้าทาง LINE OA เพราะฉะนั้นอย่าลืมเพิ่มเราเป็นเพื่อนด้วยนะคะ )</span></p>
<span class="style40">- Special monthly discount coupon for membership only (Send to customer via LINE OA. Please do not forget to add our LINE as friend) </span></p>
<span class="style16">- ส่วนลด 30% ในเดือนเกิด ( ยอดซื้อต่อบิลสูงสุดไม่เกิน 10,000 บาท และสามารถใช้ได้ในบิลที่ 2 เป็นต้นไป)</span></p>
<span class="style40">- 30% Discount in birthday month (Maximum purchasing amount per receipt is not more than 10,000 baht and can be used with the second receipt onwards)</span></p>

	

</p>
</fieldset>


<?php
/*
if($objResult22["status_cus"]=='0'){
 //นำเข้าไฟล์ฟังก์ชั่น
include("mark.inc1.php");

$SourceFile = 'Artboard.jpg'; //รูปที่ต้องการใส่วอเตอร์มาร์ค
}else{
include("mark.inc.php");
$SourceFile = 'Artboard1.jpg'; //รูปที่ต้องการใส่วอเตอร์มาร์ค	
}
$DestinationFile = 'Allwell Healthcare.jpg'; //ไฟล์รูปภาพที่จะจัดเก็บ

$WaterMarkText = $first_name;
$WaterMarkText1 = $last_name;
$WaterMarkText2 = $customer_no;

watermarkImage ($SourceFile, $WaterMarkText,$WaterMarkText1, $WaterMarkText2, $DestinationFile);



print "<img src='$DestinationFile' border='0'><br>";*/


 

?>

