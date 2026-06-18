	<style>
		*{
			font-size: 14px;
		}
	</style>
<?php
date_default_timezone_set("Asia/Bangkok");

$start_date = $_GET["start_date"];
$end_date = $_GET["end_date"];

?>
<body>
	
<link rel="stylesheet" href="css/w32.css">
<?php
include "dbconnect.php";
date_default_timezone_set("Asia/Bangkok");
function DateThai($strDate)
	{
		$strYear = date("Y",strtotime($strDate))+543;
		$strMonth= date("n",strtotime($strDate));
		$strDay= date("j",strtotime($strDate));
		$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		$strMonthThai=$strMonthCut[$strMonth];
		return "$strDay $strMonthThai $strYear";
	}

$start_date = $_GET["start_date"];
$end_date = $_GET["end_date"];
?>
<body>
<?php 
	
$date_arr = explode('-' , $start_date );
$mm = $date_arr[1];
$yy = $date_arr[0];
$_month_name = array("01"=>"มกราคม",  "02"=>"กุมภาพันธ์",  "03"=>"มีนาคม", "04"=>"เมษายน",  "05"=>"พฤษภาคม",  "06"=>"มิถุนายน","07"=>"กรกฎาคม",  "08"=>"สิงหาคม",  "09"=>"กันยายน",
"10"=>"ตุลาคม", "11"=>"พฤศจิกายน",  "12"=>"ธันวาคม");

$thai= $_month_name[$mm];
$year =$yy+543;
?>
<center>
<span class="style15"><h3>รายละเอียดการจัดส่งสินค้า</h3></span>
	<h4>จากวันที่ : <?php echo $start_date ?>
	ถึงวันที่ : <?php echo $end_date ?></center></h4><br>
<table border= "1" width="100%" class='w3-table'>
<tr>
<th align='center' width="10%" align="center" class="style30">วันที่ลงงาน</th>
<th align='center' width="10%" align="center" class="style30">เลขที่การลงงาน</th>
<th align='center' width="30%" align="center" class="style30">เอกสาร</th>
<th align='center' width="50%" align="center" class="style30">ข้อมูลรายละเอียดสินค้า</th>
</tr>
	
<?php
	include"dbconnect_cs.php";
	$strSQL5 = " SELECT * FROM `tb_register_data` WHERE `address_name` LIKE '%kerry%' and `department`='วิศวกรรม' ";
	
if($start_date !=""){ 
    $strSQL5 .= ' AND start_date >= "'.$start_date.'"'; 
}
if($end_date !=""){ 
    $strSQL5 .= ' AND start_date <= "'.$end_date.'"'; 
}
$objQuery5 = mysqli_query($com1,$strSQL5) or die ("Error Query [".$strSQL5."]");
	while($objResult5 = mysqli_fetch_array($objQuery5)) { ?>
	
<tr>
	<td align='center'><?php echo DateThai($objResult5['start_date']); ?></td>
	<td align='center'><?php echo $objResult5['running']; ?></td>
	<td align='center'><?php echo $objResult5['product_sn']; ?></td>
	<td><?php echo $objResult5['product_name']; ?></td>
	
</tr>
	<?php } ?>
	
</table>	
</body>
</html>