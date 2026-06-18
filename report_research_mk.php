<?php 
include('head1.php'); 

include "dbconnect.php";
include "dbconnect_cs.php";
session_start();
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

date_default_timezone_set("Asia/Bangkok");

$start_date=$_GET["start_date"];	
			
$date_arr = explode('-' , $start_date );
$mm = $date_arr[1];
$yy = $date_arr[0];
$_month_name = array("01"=>"มกราคม",  "02"=>"กุมภาพันธ์",  "03"=>"มีนาคม", "04"=>"เมษายน",  "05"=>"พฤษภาคม",  "06"=>"มิถุนายน","07"=>"กรกฎาคม",  "08"=>"สิงหาคม",  "09"=>"กันยายน",
"10"=>"ตุลาคม", "11"=>"พฤศจิกายน",  "12"=>"ธันวาคม");

$thai= $_month_name[$mm];
$year =$yy+543;

$start_date=$_GET["start_date"];	
$end_date=$_GET["end_date"];

?>
<body>

</p>
</p>
<?php if ($_SESSION['type_login']=='AllWell' and $_SESSION['position']=='Online') { ?>
<div class="w3-container w3-padding-large">
<center>
<b><span class="style15">รายงานสรุปรายการที่ต้องทำแบบสอบถามความพึงพอใจลูกค้าหลังการขาย</span></p>
<span class="style15">เดือน  <?php echo $thai; ?> ประจำปี  <?php echo $year; ?></span></p>
<b><span class="style15">เขตการขายออนไลน์</span></p></b>
</center></p>

<table border= "1" width="100%" class='w3-table'>
<thead>	
<tr>
<td width="2%" align="center" class="style30">ลำดับ</td>
<td width="5%"  align="center" class="style30">เลขที่เอกสาร</td>
<td  width="10%" align="center" class="style30">รายชื่อลูกค้า</td>
<td width="5%" align="center" class="style30">เขตการขาย</td> 
<td width="2%" align="center" class="style30">ทำแบบสอบถามแล้ว</td> 
</tr>
</thead>	
	<?php
	
	

$strSQL = "SELECT DISTINCT doc_no,employee_name,billing_name,job_id,ref_id  FROM ((so__submain LEFT JOIN so__main ON so__submain.ref_idd=so__main.ref_id)LEFT JOIN tb_product ON so__submain.product_code=tb_product.product_ID) where (unit_name ='เตียง' or group1 LIKE '%ที่นอนโฟม%') and cancel_ckk='0' and sale_channel ='4' and job_id !='' and doc_no not like '%B%' and approve_complete ='Approve'";
if($start_date !=""){ 
 $strSQL .= ' AND doc_release_date >= "'.$start_date.'"'; 
}
if($end_date !=""){ 
  $strSQL .= ' AND doc_release_date <= "'.$end_date.'"'; 
}

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
$n=1;
while($objResult = mysqli_fetch_array($objQuery))
{

?>
<tr>
<td  align="center" class="style30"><?php echo $n; ?></td>
<td  align="center" class="style30"><a href="register_allwell_edit.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank"><span class="style30"><?php echo  $objResult["doc_no"]; ?></span></a></td>
<td  align="left" class="style30"><?php echo $objResult["billing_name"]; ?></td>
<td  align="center" class="style30"><?php echo $objResult["employee_name"]; ?></td>
<td  align="center" class="style30"><?php 
 $strSQL2 = "SELECT running_id,product_good,cs_neat,sale_neat  FROM tb_research where red_id ='".$objResult["ref_id"]."' and product_good !='0'";
$objQuery2 = mysqli_query($com1,$strSQL2) or die ("Error Query [".$strSQL2."]");
$Num_Rows2 = mysqli_num_rows($objQuery2);
$objResult2 = mysqli_fetch_array($objQuery2);

 if($objResult2["sale_neat"] > 0){ ?><input type="checkbox"  checked="checked" > 1 <br><?php } 
 if($objResult2["product_good"] > 0){ ?><input type="checkbox"  checked="checked" > 2 <br><?php } 
 if($objResult2["cs_neat"] > 0){ ?><input type="checkbox"  checked="checked" > 3 <br><?php } 
	?>
	
	
	</td>
</tr>

<?php 
$n++;
} 
	
	?>	
	
</table>

<?php

$strSQL1 = "SELECT doc_no,employee_name,billing_name,job_id,ref_id  FROM ((so__submain LEFT JOIN so__main ON so__submain.ref_idd=so__main.ref_id)LEFT JOIN tb_product ON so__submain.product_code=tb_product.product_ID) where (unit_name ='เตียง' or group1 LIKE '%ที่นอนโฟม%') and cancel_ckk='0' and sale_channel ='4' and job_id !='' and doc_no not like '%B%' and approve_complete ='Approve'";
if($start_date !=""){ 
 $strSQL1 .= ' AND doc_release_date >= "'.$start_date.'"'; 
}
if($end_date !=""){ 
  $strSQL1 .= ' AND doc_release_date <= "'.$end_date.'"'; 
}

$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

?>

<table border= "1" width="100%" class='w3-table'>


<tr>
<td width="100%" align="center" class="style30">รวมทั้งหมด <?php echo $n-1; ?> รายการ</td>
</tr>
</table>

</div>




<?php }else{ ?>
<div class="w3-container w3-padding-large">

<center>
<b><span class="style15">รายงานสรุปรายการที่ต้องทำแบบสอบถามความพึงพอใจลูกค้าหลังการขาย</span></p>
<span class="style15">เดือน  <?php echo $thai; ?> ประจำปี  <?php echo $year; ?></span></p>
<span class="style15">เขตการขายโรงพยาบาล</span></p></b>
</center></p>




<table border= "1" width="100%" class='w3-table'>
<thead>	
<tr>
<td width="2%" align="center" class="style30">ลำดับ</td>
<td width="5%"  align="center" class="style30">เลขที่เอกสาร</td>
<td  width="10%" align="center" class="style30">รายชื่อลูกค้า</td>
<td width="5%" align="center" class="style30">เขตการขาย</td> 
<?php /*<td width="2%" align="center" class="style30">ทำแบบสอบถามแล้ว</td> */ ?>
</tr>
</thead>	
	<?php
	
	

$strSQL = "SELECT iv_no,sale_code,bill_name,close_reseach  FROM hos__so where reseach_kk ='1' and status_doc ='Approve'";
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
if($objResult["sale_code"] =='S31' or $objResult["sale_code"] =='S32' or $objResult["sale_code"] =='MM1'  or $objResult["sale_code"] =='SM1'){
	
}else{
?>
<tr>
<td  align="center" class="style30"><?php echo $n; ?></td>
<td  align="center" class="style30"><?php echo $objResult["iv_no"]; ?></td>
<td  align="left" class="style30"><?php echo $objResult["bill_name"]; ?></td>
<td  align="center" class="style30"><?php echo $objResult["sale_code"]; ?></td>
<?php /*<td  align="center" class="style30"><?php  if($objResult["close_reseach"]=='1'){ ?><input type="checkbox"  checked="checked" > <?php } ?></td>*/ ?>
</tr>

<?php 
$n++;
} 
}
	?>
</table>

<?php

$strSQL1 = "SELECT iv_no,sale_code,bill_name  FROM hos__so where reseach_kk ='1' and status_doc ='Approve'";
if($start_date !=""){ 
 $strSQL1 .= ' AND iv_date >= "'.$start_date.'"'; 
}
if($end_date !=""){ 
  $strSQL1 .= ' AND iv_date <= "'.$end_date.'"'; 
}

$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

$strSQL2 = "SELECT iv_no,sale_code,bill_name,close_reseach  FROM hos__so where reseach_kk ='1' and status_doc ='Approve' and sale_code='MM1'";
if($start_date !=""){ 
 $strSQL2 .= ' AND iv_date >= "'.$start_date.'"'; 
}
if($end_date !=""){ 
  $strSQL2 .= ' AND iv_date <= "'.$end_date.'"'; 
}

$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$Num_Rows2 = mysqli_num_rows($objQuery2);


$strSQL3 = "SELECT iv_no,sale_code,bill_name,close_reseach  FROM hos__so where reseach_kk ='1' and status_doc ='Approve' and sale_code='S31'";
if($start_date !=""){ 
 $strSQL3 .= ' AND iv_date >= "'.$start_date.'"'; 
}
if($end_date !=""){ 
  $strSQL3 .= ' AND iv_date <= "'.$end_date.'"'; 
}

$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$Num_Rows3 = mysqli_num_rows($objQuery3);

$strSQL4 = "SELECT iv_no,sale_code,bill_name,close_reseach  FROM hos__so where reseach_kk ='1' and status_doc ='Approve' and sale_code='SM1'";
if($start_date !=""){ 
 $strSQL4 .= ' AND iv_date >= "'.$start_date.'"'; 
}
if($end_date !=""){ 
  $strSQL4 .= ' AND iv_date <= "'.$end_date.'"'; 
}

$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
$Num_Rows4 = mysqli_num_rows($objQuery4);

?>

<table border= "1" width="100%" class='w3-table'>


<tr>
<td width="100%" align="center" class="style30">รวมทั้งหมด <?php echo $n-1; ?> รายการ</td>
</tr>
</table>

</p></p>
<center>
<b><span class="style15">เขตการขายออนไลน์</span></p></b>
</center></p>

<table border= "1" width="100%" class='w3-table'>
<thead>	
<tr>
<td width="2%" align="center" class="style30">ลำดับ</td>
<td width="5%"  align="center" class="style30">เลขที่เอกสาร</td>
<td  width="10%" align="center" class="style30">รายชื่อลูกค้า</td>
<td width="5%" align="center" class="style30">เขตการขาย</td> 
<?php /*<td width="2%" align="center" class="style30">ทำแบบสอบถามแล้ว</td> */ ?>
</tr>
</thead>	
	<?php
	
	

$strSQL = "SELECT DISTINCT doc_no,employee_name,billing_name,job_id  FROM ((so__submain LEFT JOIN so__main ON so__submain.ref_idd=so__main.ref_id)LEFT JOIN tb_product ON so__submain.product_code=tb_product.product_ID) where (unit_name ='เตียง' or group1 LIKE '%ที่นอนโฟม%') and cancel_ckk='0' and sale_channel ='4' and job_id	 !='' and doc_no not like '%B%' and approve_complete ='Approve'";
if($start_date !=""){ 
 $strSQL .= ' AND doc_release_date >= "'.$start_date.'"'; 
}
if($end_date !=""){ 
  $strSQL .= ' AND doc_release_date <= "'.$end_date.'"'; 
}

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
$n=1;
while($objResult = mysqli_fetch_array($objQuery))
{

?>
<tr>
<td  align="center" class="style30"><?php echo $n; ?></td>
<td  align="center" class="style30"><?php echo $objResult["doc_no"]; ?></td>
<td  align="left" class="style30"><?php echo $objResult["billing_name"]; ?></td>
<td  align="center" class="style30"><?php echo $objResult["employee_name"]; ?></td>
<?php /*<td  align="center" class="style30"><?php 
 $strSQL2 = "SELECT running_id  FROM tb_research where running_id ='".$objResult["job_id"]."' and product_good !='0'";
$objQuery2 = mysqli_query($com1,$strSQL2) or die ("Error Query [".$strSQL2."]");
$Num_Rows2 = mysqli_num_rows($objQuery2);
$objResult2 = mysqli_fetch_array($objQuery2);

 if($Num_Rows2 > 0){ ?><input type="checkbox"  checked="checked" > <?php } ?></td>*/ ?>
</tr>

<?php 
$n++;
} 
	
	
$strSQL = "SELECT iv_no,sale_code,bill_name,close_reseach  FROM hos__so where reseach_kk ='1' and status_doc ='Approve'";
if($start_date !=""){ 
 $strSQL .= ' AND iv_date >= "'.$start_date.'"'; 
}
if($end_date !=""){ 
  $strSQL .= ' AND iv_date <= "'.$end_date.'"'; 
}

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
$m=$n;
while($objResult = mysqli_fetch_array($objQuery))
{
if($objResult["sale_code"] =='S32' or $objResult["sale_code"] =='S31' or $objResult["sale_code"] =='MM1'){

?>
<tr>
<td  align="center" class="style30"><?php echo $m; ?></td>
<td  align="center" class="style30"><?php echo $objResult["iv_no"]; ?></td>
<td  align="left" class="style30"><?php echo $objResult["bill_name"]; ?></td>
<td  align="center" class="style30"><?php echo $objResult["sale_code"]; ?></td>
<?php /*<td  align="center" class="style30"><?php  if($objResult["close_reseach"]=='1'){ ?><input type="checkbox"  checked="checked" > <?php } ?></td>*/ ?>
</tr>

<?php 
$m++;
} 
}
	?>	
	
</table>

<?php

$strSQL1 = "SELECT DISTINCT doc_no,employee_name,billing_name,job_id  FROM ((so__submain LEFT JOIN so__main ON so__submain.ref_idd=so__main.ref_id)LEFT JOIN tb_product ON so__submain.product_code=tb_product.product_ID) where (unit_name ='เตียง' or group1 LIKE '%ที่นอนโฟม%') and cancel_ckk='0' and sale_channel ='4' and job_id	 !='' and doc_no not like '%B%' and approve_complete ='Approve'";
if($start_date !=""){ 
 $strSQL1 .= ' AND doc_release_date >= "'.$start_date.'"'; 
}
if($end_date !=""){ 
  $strSQL1 .= ' AND doc_release_date <= "'.$end_date.'"'; 
}

$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

?>

<table border= "1" width="100%" class='w3-table'>


<tr>
<td width="100%" align="center" class="style30">รวมทั้งหมด <?php echo $m-1; ?> รายการ</td>
</tr>
</table>

</div>

<?php } ?>
</body>
</html>