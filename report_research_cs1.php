<?php include "test.php"; ?>
<?php include "error_page.php"; ?>
<?php 

include "dbconnect_cs.php";
include "dbconnect.php";

?>
<link rel="stylesheet" href="css/w32.css">
<style type="text/css">
<!--

.style15 {
	font-size: 18px; color: #000000;
}
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


function DateThai($strDate)
	{
		$strYear = date("Y",strtotime($strDate))+543;
		$strMonth= date("n",strtotime($strDate));
		$strDay= date("j",strtotime($strDate));
		$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		$strMonthThai=$strMonthCut[$strMonth];
		return "$strDay $strMonthThai $strYear";
	}

date_default_timezone_set("Asia/Bangkok");

$start_date=$_POST["start_date"];	
			
$date_arr = explode('-' , $start_date );
$mm = $date_arr[1];
$yy = $date_arr[0];
$_month_name = array("01"=>"มกราคม",  "02"=>"กุมภาพันธ์",  "03"=>"มีนาคม", "04"=>"เมษายน",  "05"=>"พฤษภาคม",  "06"=>"มิถุนายน","07"=>"กรกฎาคม",  "08"=>"สิงหาคม",  "09"=>"กันยายน",
"10"=>"ตุลาคม", "11"=>"พฤศจิกายน",  "12"=>"ธันวาคม");

$thai= $_month_name[$mm];
$year =$yy+543;

$start_date=$_POST["start_date"];	
$end_date=$_POST["end_date"];


?>
<body>

</p>
</p>

<div class="w3-container w3-padding-large">

<center>
<b><span class="style15">แบบประเมินความพึงพอใจของการจัดส่งและการประกอบติดตั้ง</span></p>
<span class="style15">เดือน  <?php echo $thai; ?> ประจำปี  <?php echo $year; ?></span></p>
</center></p>


<table border= "1" width="100%" class='w3-table'>
<thead>	
<tr>
<td width="2%" align="center" class="style30">ลำดับ</td>
<td width="5%"  align="center" class="style30">วันที่ออกบิล</td>
<td width="5%"  align="center" class="style30">วันที่จัดส่ง</td>
<td width="5%"  align="center" class="style30">เลขที่เอกสาร</td>
<td  width="10%" align="center" class="style30">ชื่อลูกค้า</td>
<td  width="10%" align="center" class="style30">สถานที่ส่ง</td>
<td width="2%" align="center" class="style30">1</td>
<td width="2%" align="center" class="style30">2</td>
<td width="2%" align="center" class="style30">3</td>
<td width="2%" align="center" class="style30">4</td>
<td width="2%" align="center" class="style30">5</td>
	<td width="2%" align="center" class="style30">รวม</td>
<td  width="10%" align="center" class="style30">หมายเหตุ</td>

</tr>
</thead>	
	<?php
	
	

$strSQL = "SELECT iv_no,sale_code,bill_name,close_reseach,job_no,ref_id,iv_date  FROM hos__so where reseach_kk ='1' and status_doc ='Approve' and sale_code !='SM1' and sale_code !='MM1' and sale_code !='S31'";
if($start_date !=""){ 
 $strSQL .= ' AND iv_date >= "'.$start_date.'"'; 
}
if($end_date !=""){ 
  $strSQL .= ' AND iv_date <= "'.$end_date.'"'; 
}

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
$n=1;
while($objResult = mysqli_fetch_array($objQuery))
{
	
$strSQL11 = "SELECT running_id,cs_neat,cs_explain,cs_3,cs_4,cs_5,suggest_2  FROM tb_research where running_id ='".$objResult["job_no"]."'";
$objQuery11 = mysqli_query($com1,$strSQL11) or die ("Error Query [".$strSQL11."]");
$Num_Rows11 = mysqli_num_rows($objQuery11);
$objResult11 = mysqli_fetch_array($objQuery11);	
	
$strSQL10 = "SELECT running,employee_send,start_date,address_name  FROM tb_register_data where running ='".$objResult["job_no"]."' ";
$objQuery10 = mysqli_query($com1,$strSQL10) or die ("Error Query [".$strSQL10."]");
$Num_Rows10 = mysqli_num_rows($objQuery10);
$objResult10 = mysqli_fetch_array($objQuery10);		
	
$cs_neat =	$objResult11["cs_neat"];
$cs_explain =	$objResult11["cs_explain"];
$cs_3 =	$objResult11["cs_3"];
$cs_4 =	$objResult11["cs_4"];
$cs_5 =	$objResult11["cs_5"];
	
$sum_cs1 = $cs_neat+$cs_explain+$cs_3+$cs_4+$cs_5;
	$sum_cs = ($sum_cs1*100)/50;
	
	if($objResult["sale_code"] =='SM1'){
	
}else{


?>
<tr>
<td  align="center" class="style30"><?php echo $n; ?></td>
<td  align="center" class="style30"><?php  echo Datethai($objResult["iv_date"]); ?></td>
<td  align="center" class="style30"><?php if($objResult10["start_date"]!=''){  echo Datethai($objResult10["start_date"]); }else{ echo '-'; } ?></td>
<td  align="center" class="style30"><?php echo $objResult["iv_no"]; ?></td>
<td  align="left" class="style30"><?php echo $objResult["bill_name"]; ?></td>
<td  align="left" class="style30"><?php echo $objResult10["address_name"]; ?></td>
<td  align="center" class="style30"><?php echo $objResult11["cs_neat"]; ?></td>
<td  align="center" class="style30"><?php echo $objResult11["cs_explain"]; ?></td>
<td  align="center" class="style30"><?php echo $objResult11["cs_3"]; ?></td>
<td  align="center" class="style30"><?php echo $objResult11["cs_4"]; ?></td>
<td  align="center" class="style30"><?php echo $objResult11["cs_5"]; ?></td>
<td  align="center" class="style30"><?php echo $sum_cs; ?></td>
<td  align="left" class="style30"><?php echo $objResult11["suggest_2"]; ?></td>

</tr>

<?php 
$n++;
} 
}
	?>
	
	
		<?php
	
$strSQL = "SELECT doc_no,employee_name,billing_name,job_id,ref_id,doc_release_date  FROM ((so__submain LEFT JOIN so__main ON so__submain.ref_idd=so__main.ref_id)LEFT JOIN tb_product ON so__submain.product_code=tb_product.product_ID) where unit_name ='เตียง' and cancel_ckk='0' and sale_channel ='4' and job_id !='' and doc_no not like '%B%' and approve_complete ='Approve'";
if($start_date !=""){ 
 $strSQL .= ' AND doc_release_date >= "'.$start_date.'"'; 
}
if($end_date !=""){ 
  $strSQL .= ' AND doc_release_date <= "'.$end_date.'"'; 
}

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
$m = $n;
while($objResult = mysqli_fetch_array($objQuery))
{

$strSQL12 = "SELECT running_id,cs_neat,cs_explain,cs_3,cs_4,cs_5,suggest_2  FROM tb_research where running_id ='".$objResult["job_id"]."' and cs_neat !='0'";
$objQuery12 = mysqli_query($com1,$strSQL12) or die ("Error Query [".$strSQL12."]");
$Num_Rows12 = mysqli_num_rows($objQuery12);
$objResult12 = mysqli_fetch_array($objQuery12);	
	
	//echo $Num_Rows12;
	
$strSQL9 = "SELECT running,employee_send,start_date,address_name  FROM tb_register_data where running ='".$objResult["job_id"]."' ";
$objQuery9 = mysqli_query($com1,$strSQL9) or die ("Error Query [".$strSQL9."]");
$Num_Rows9 = mysqli_num_rows($objQuery9);
$objResult9 = mysqli_fetch_array($objQuery9);	
	
$cs_neat =	$objResult12["cs_neat"];
$cs_explain =	$objResult12["cs_explain"];
$cs_3 =	$objResult12["cs_3"];
$cs_4 =	$objResult12["cs_4"];
$cs_5 =	$objResult12["cs_5"];
	
$sum_cs1 = $cs_neat+$cs_explain+$cs_3+$cs_4+$cs_5;
	$sum_cs = ($sum_cs1*100)/50;
 
?>
<tr>
<td  align="center" class="style30"><?php echo $m; ?></td>
<td  align="center" class="style30"><?php  echo Datethai($objResult["doc_release_date"]); ?></td>
<td  align="center" class="style30"><?php if($objResult9["start_date"]!=''){  echo Datethai($objResult9["start_date"]); }else{ echo '-'; } ?></td>

<td  align="center" class="style30"><?php echo $objResult["doc_no"]; ?></td>
<td  align="left" class="style30"><?php echo $objResult["billing_name"]; ?></td>
<td  align="left" class="style30"><?php echo $objResult9["address_name"]; ?></td>
<td  align="center" class="style30"><?php echo $objResult12["cs_neat"]; ?></td>
<td  align="center" class="style30"><?php echo $objResult12["cs_explain"]; ?></td>
<td  align="center" class="style30"><?php echo $objResult12["cs_3"]; ?></td>
<td  align="center" class="style30"><?php echo $objResult12["cs_4"]; ?></td>
<td  align="center" class="style30"><?php echo $objResult12["cs_5"]; ?></td>
<td  align="center" class="style30"><?php echo $sum_cs; ?></td>
<td  align="left" class="style30"><?php echo $objResult12["suggest_2"]; ?></td>
</tr>

<?php 
$m++;
} 
	?>
</table>

<?php

$strSQL1 = "SELECT iv_no  FROM hos__so where reseach_kk ='1' and status_doc ='Approve'  and sale_code='SM1'  and sale_code='MM1'  and sale_code='S31'";
if($start_date !=""){ 
 $strSQL1 .= ' AND iv_date >= "'.$start_date.'"'; 
}
if($end_date !=""){ 
  $strSQL1 .= ' AND iv_date <= "'.$end_date.'"'; 
}

$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);


/*$strSQL31 = "SELECT iv_no  FROM hos__so where reseach_kk ='1' and status_doc ='Approve' and with_cs='1'  and sale_code='SM1'  and sale_code='MM1'  and sale_code='S31'";
if($start_date !=""){ 
 $strSQL31 .= ' AND iv_date >= "'.$start_date.'"'; 
}
if($end_date !=""){ 
  $strSQL31 .= ' AND iv_date <= "'.$end_date.'"'; 
}
$objQuery31 = mysqli_query($conn,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);*/



$strSQL2 = "SELECT doc_no  FROM ((so__submain LEFT JOIN so__main ON so__submain.ref_idd=so__main.ref_id)LEFT JOIN tb_product ON so__submain.product_code=tb_product.product_ID) where unit_name ='เตียง' and cancel_ckk='0' and sale_channel ='4' and job_id	 !='' and doc_no not like '%B%' and approve_complete ='Approve'";
if($start_date !=""){ 
 $strSQL2 .= ' AND doc_release_date >= "'.$start_date.'"'; 
}
if($end_date !=""){ 
  $strSQL2 .= ' AND doc_release_date <= "'.$end_date.'"'; 
}
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$Num_Rows2 = mysqli_num_rows($objQuery2);


$strSQL32 = "SELECT doc_no  FROM so__main  where  approve_complete ='Approve' and with_cs='1'";
if($start_date !=""){ 
 $strSQL32 .= ' AND doc_release_date >= "'.$start_date.'"'; 
}
if($end_date !=""){ 
  $strSQL32 .= ' AND doc_release_date <= "'.$end_date.'"'; 
}
$objQuery32 = mysqli_query($conn,$strSQL32) or die ("Error Query [".$strSQL32."]");
$Num_Rows32 = mysqli_num_rows($objQuery32);


/*$strSQL4 = "SELECT iv_no,sale_code,bill_name,close_reseach  FROM hos__so where reseach_kk ='1' and status_doc ='Approve' and sale_code='SM1'  and sale_code='MM1'  and sale_code='S31'";
if($start_date !=""){ 
 $strSQL4 .= ' AND iv_date >= "'.$start_date.'"'; 
}
if($end_date !=""){ 
  $strSQL4 .= ' AND iv_date <= "'.$end_date.'"'; 
}

$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
$Num_Rows4 = mysqli_num_rows($objQuery4);*/


$sale = ($Num_Rows1+$Num_Rows2);
$cs = $Num_Rows32;
$sum = $sale-$cs;

$per_sale = ($cs/$sale)*100;
$per_cs = ($sum/$sale)*100;



/*<table border= "1" width="100%" class='w3-table'>


<tr>
<td width="100%" align="center" class="style30">รวมทั้งหมด <?php echo ($Num_Rows1+$Num_Rows2)-$Num_Rows4; ?> รายการ</td>
</tr>
</table>*/
?>
<br><br>
<table  width="100%" class='w3-table'>

<tr>
<td width="35%"  align="right" class="style30">สรุปงานทั้งหมด </td>
<td width="10%"  align="center" class="style30"><?php echo ($Num_Rows1+$Num_Rows2); ?></td>
<td width="35%"  align="left" class="style30">งาน </td>
<td width="20%"  align="left" class="style30"> </td>

</tr>
	
	<tr>
		
		<td width="35%"  align="right" class="style30">สํารวจได้ </td>
<td width="10%"  align="center" class="style30"><?php echo ($Num_Rows31); ?></td>
<td width="35%"  align="left" class="style30">งาน </td>
<td width="20%"  align="left" class="style30"> </td>

	</tr>
	
	<tr>
<td width="35%"  align="right" class="style30">สํารวจไม่ได้ </td>
<td width="10%"  align="center" class="style30"><?php echo $sum; ?></td>
<td width="35%"  align="left" class="style30">งาน </td>
<td width="20%"  align="left" class="style30"> </td>

</tr>
	
	<tr>
<td width="35%"  align="right" class="style30">คิดเป็น </td>
<td width="10%"  align="center" class="style30"><?php echo number_format($per_sale,2)."";   ?></td>
<td width="35%"  align="left" class="style30">% </td>
<td width="20%"  align="left" class="style30"> </td>

</tr>
	
</table>
<br><br>


<table  width="100%" class='w3-table'>

<tr><td width="5%"  align="right" class="style30"> </td><td width="90%"  align="left" class="style30">1. พนักงานจัดส่งพูดจาสุภาพ อัธยาศัยดี แต่งกายสุภาพ วางตัวเหมาะสม </td></tr>
<tr><td width="5%"  align="right" class="style30"> </td><td width="90%"  align="left" class="style30">2. พนักงานจัดส่งสามารถอธิบาย สาธิตวิธีการใช้งาน และตอบข้อซักถามได้ชัดเจน </td></tr>
<tr><td width="5%"  align="right" class="style30"> </td><td width="90%"  align="left" class="style30">3. พนักงานจัดส่งดูแล และขนย้ายสินค้าเข้าติดตั้ง ณ สถานที่ใช้งานได้เป็นอย่างดี </td></tr>
<tr><td width="5%"  align="right" class="style30"> </td><td width="90%"  align="left" class="style30">4. พนักงานจัดส่งโทรประสานงานก่อนส่งสินค้าจริง และส่งมอบสินค้าตามเวลาที่ได้นัดหมายไว้  </td></tr>
<tr><td width="5%"  align="right" class="style30"> </td><td width="90%"  align="left" class="style30">5. คุณภาพการบริการจัดส่งเมื่อเทียบกับบริษัทอื่นๆ</td></tr>
	
</table>
<br><br>

</div>
</body>
</html>