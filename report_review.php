<link rel="stylesheet" href="css/w32.css">
<style type="text/css">
<!--

.style15 {
	font-size: 18px; color: #000000;
}
.style16 {font-size: 14px; color: #FF0000;}
.style17 {font-size: 14px; color: #3333FF;}
.style32 {font-size: 11px}
.style33 {font-size: 12px; }
.style34 {color: #FF0000}
.style35 {font-size: 12px; color: #f2f2f2; }
.style37 {color: #FF0000; font-size: 14px; }
.style38 {color: #f2f2f2 }
.style30 {font-size: 14px; color: #000000;}
.style40 {font-size: 15px; color: #000000; }
-->

.button {
    background-color: #339900;
    border: none;
    color: white;
    padding: 14px 16px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
}

.button1 {border-radius: 2px; background-color:#FF9999;  padding: 0.1px 0.1px; margin: 0.5px 0.5px;}
.button2 {border-radius: 2px; background-color:#CCFF66;  padding: 0.1px 0.1px; margin: 0.5px 0.5px;}
.button3 {border-radius: 2px; background-color:#FF3333;  padding: 0.1px 0.1px; margin: 0.5px 0.5px;}
.button4 {border-radius: 12px;}
.button5 {border-radius: 50%;}



</style>



<?php


include "src/BarcodeGenerator.php";
include "src/BarcodeGeneratorHTML.php";
include "src/BarcodeGeneratorPNG.php";


function barcode($code){
    
    $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
    $border = 0.5;//กำหนดความหน้าของเส้น Barcode
    $height = 15;//กำหนดความสูงของ Barcode
 
    return $generator->getBarcode($code , $generator::TYPE_CODE_128,$border,$height);
 
}
 

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

include"dbconnect.php";



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
<div class="w3-container w3-padding-large">
<center>
<span class="style15">รายการใบตรวจทาน</span></p>

<span class="style15"><?php echo $thai; ?>&nbsp;&nbsp;<?php echo $year; ?></span><br>


</center>
</p>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="10%" align="center" class="style30">วันที่</td>
<td width="10%" align="center" class="style30">เลขที่ BRNP</td>
<td width="15%" align="center" class="style30">ชื่อลูกค้า</td>
<td width="20%" align="center" class="style30">ชื่อสินค้า</td>
<td width="10%" align="center" class="style30">ผู้ออกใบตรวจทาน</td>
<td width="8%" align="center" class="style30">ผู้รับใบตรวจทานกลับ</td> 
	</tr>
<?php

$strSQL ="SELECT * FROM tb_product_checklist WHERE 1 ";
if($start_date !=""){ 
    $strSQL .= ' AND date_create >= "'.$start_date.'"'; 
}
if($end_date !=""){ 
    $strSQL .= ' AND date_create <= "'.$end_date.'"'; 
}
$objQuery =mysqli_query($conn,$strSQL);
while($objResult=mysqli_fetch_array($objQuery)){


$doc_no1 = substr($objResult["ref_id"],0,2);

if($doc_no1=='BR'){

$strSQL2 ="SELECT iv_no,customer FROM hos__br WHERE ref_id_br = '".$objResult['ref_id']."' ";
$objQuery2 =mysqli_query($conn,$strSQL2);
$objResult2=mysqli_fetch_array($objQuery2);

$iv_no = $objResult2["iv_no"];
$bill_name = $objResult2["customer"];

}else{

$strSQL2 ="SELECT doc_no,customer_name FROM so__main WHERE ref_id = '".$objResult['ref_id']."' ";
$objQuery2 =mysqli_query($conn,$strSQL2);
$objResult2=mysqli_fetch_array($objQuery2);
$iv_no = $objResult2["doc_no"];
$bill_name = $objResult2["customer_name"];

}
	
	
$strSQL1 ="SELECT sol_name FROM tb_product WHERE product_ID = '".$objResult['product_id']."' ";
$objQuery1 =mysqli_query($conn,$strSQL1);
$objResult1=mysqli_fetch_array($objQuery1);


?>
<tr>
<td  class="style30"><?php echo Datethai($objResult["date_create"]); ?></td>
<td  class="style30"><?php echo $iv_no; ?></td>
<td  class="style30"><?php echo $bill_name; ?></td>
<td class="style30"><?php echo $objResult1["sol_name"]; ?></td>
<td class="style30"><?php echo $objResult["add_by"]; ?></td>
<td class="style30"><?php echo $objResult["stock_name"]; ?></td> 


	</tr>
<?php
}
?>



<?php 
$strSQL3 ="SELECT add_by FROM tb_product_checklist WHERE  add_by !=''";
if($start_date !=""){ 
    $strSQL3 .= ' AND date_create >= "'.$start_date.'"'; 
}
if($end_date !=""){ 
    $strSQL3 .= ' AND date_create <= "'.$end_date.'"'; 
}
	
$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$Num_Rows3 = mysqli_num_rows($objQuery3);



$strSQL4 ="SELECT * FROM tb_product_checklist WHERE  stock_name !=''";
if($start_date !=""){ 
    $strSQL4 .= ' AND date_create >= "'.$start_date.'"'; 
}
if($end_date !=""){ 
    $strSQL4 .= ' AND date_create <= "'.$end_date.'"'; 
}
$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
$Num_Rows4 = mysqli_num_rows($objQuery4);

?>


<tr>
<td  class="style30"></td>
<td  class="style30"></td>
<td  class="style30"></td>
<td class="style30">ยอดรวม</td>
<td class="style30"><div align="right" ><?php echo $Num_Rows3; ?> รายการ</div></td>
<td class="style30"><div align="right" ><?php echo $Num_Rows4; ?> รายการ</div></td> 

	</tr>
</table>
</div>
</body>
</html>