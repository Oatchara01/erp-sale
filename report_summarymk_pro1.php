<link rel="stylesheet" href="css/w32.css">
<style type="text/css">
<!--

.style15 {
	font-size: 18px; color: #000000;
}
.style16 {font-size: 18px; color: #FF0000;}
.style32 {font-size: 11px}
.style33 {font-size: 12px; }
.style34 {color: #FF0000}
.style35 {font-size: 12px; color: #f2f2f2; }
.style37 {color: #FF0000; font-size: 14px; }
.style38 {color: #f2f2f2 }
.style39 {font-size: 14px; color: #000000;}
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



include"dbconnect.php";
include"dbconnect_sale.php";



$start_date = $_GET["start_date"];
$end_date = $_GET["end_date"];
$sale_code = $_GET["sale_code"];
$doc_no = 'BRNP';


$date_arr = explode('-' , $start_date );
$mm = $date_arr[1];
$yy = $date_arr[0];
$_month_name = array("01"=>"มกราคม",  "02"=>"กุมภาพันธ์",  "03"=>"มีนาคม", "04"=>"เมษายน",  "05"=>"พฤษภาคม",  "06"=>"มิถุนายน","07"=>"กรกฎาคม",  "08"=>"สิงหาคม",  "09"=>"กันยายน",
"10"=>"ตุลาคม", "11"=>"พฤศจิกายน",  "12"=>"ธันวาคม");

$thai= $_month_name[$mm];
$year =$yy+543;

?>
<body>



<span class="style15">ประวัติการขาย / แยกตามสินค้า     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo Datethai($start_date); ?>&nbsp;ถึง&nbsp;<?php echo Datethai($end_date); ?></span>
<hr color="black"  width="100%" size="0.1" align="right">
</p>
<span class="style16"><?php echo $sale_code ; ?></span></p>
<?php 
if($_GET["sale_code"]!=''){

$product_h = $_GET["h_product_code"];

$strSQL22 = "SELECT access_code,access_name,unit_name,express_code FROM tb_product WHERE product_ID = '".$product_h."' ";
//echo $strSQL22;

$objQuery22 = mysqli_query($conn,$strSQL22) or die ("Error Query [".$strSQL22."]");
$objResult22 = mysqli_fetch_array($objQuery22);

$access_code1 = $objResult22["access_code"];
$access_name1 = $objResult22["access_name"];
$unit_name1 = $objResult22["unit_name"];
$express_code1 = $objResult22["express_code"];

?>

<span class="style16"><?php echo $access_code1 ; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php  echo $access_name1 ;  ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php  echo $unit_name1 ;  ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php  echo $express_code1 ;  ?></span>

	<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="10%" align="center" class="style30">วันที่</td>
<td width="20%" align="center" class="style30">เลขที่เอกสาร</td>
<td width="25%" align="center" class="style30">ชื่อลุกค้า</td> 
<td width="5%" align="center" class="style30">จำนวน</td> 
<td width="10%" align="center" class="style30">ราคาต่อหน่วย</td> 
<td width="10%" align="center" class="style30">ส่วนลดต่อชิ้น</td> 
<td width="10%" align="center" class="style30">ราคารวม</td> 
	</tr>

</p>

<?php 



$strSQL1 = "SELECT doc_release_date,product_id,doc_no,customer_name,billing_name,delivery_name,sale_count,price_per_unit,sum_amount,discount_unit FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE product_id = '".$product_h."' and cancel_ckk ='0'";

if($start_date !=""){ 
    $strSQL1 .= ' AND doc_release_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL1 .= ' AND doc_release_date <= "'.$end_date.'"'; 
}
if($sale_code !=""){ 
    $strSQL1 .= ' AND employee_name = "'.$sale_code.'"'; 
}

$strSQL1 .= ' AND doc_no NOT LIKE "%'.$doc_no.'%"'; 

$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

while($objResult1 = mysqli_fetch_array($objQuery1))
{

?>

 <tr>
<td width="10%" align="center" class="style30"><?php echo datethai($objResult1["doc_release_date"]);  ?></td>
<td width="20%" align="center" class="style30"><?php echo $objResult1["doc_no"];  ?></td>
<td width="25%" align="left" class="style30"><?php echo $objResult1["customer_name"];  ?></td> 
<td width="5%" align="center" class="style30"><?php echo $objResult1["sale_count"];  ?></td> 
<td width="10%" align="right" class="style30"><?php echo number_format( $objResult1["price_per_unit"],2)."";  ?></td> 
<td width="10%" align="right" class="style30"><?php echo number_format( $objResult1["discount_unit"],2).""; ?></td> 
<td width="10%" align="right" class="style30"><?php echo number_format( $objResult1["sum_amount"],2).""; ?></td> 


	</tr>


	<?php
}


?>
</table>

<?php
	
$strSQL3 = "SELECT SUM(sum_amount)  as total,SUM(sale_count)  as sale_count,SUM(price_per_unit)  as price_per_unit,SUM(discount_unit)  as discount_unit  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE product_id = '".$product_h."' and cancel_ckk = '0'";

if($start_date !=""){ 
    $strSQL3 .= ' AND doc_release_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL3 .= ' AND doc_release_date <= "'.$end_date.'"'; 
}
if($sale_code !=""){ 
    $strSQL3 .= ' AND employee_name = "'.$sale_code.'"'; 
}
	
$strSQL3 .= ' AND doc_no NOT LIKE "%'.$doc_no.'%"'; 

$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);
	
$total=$objResult3['total'];
$discount_unit=$objResult3['discount_unit'];
$price_per_unit=$objResult3['price_per_unit'];
$sale_count=$objResult3['sale_count'];
	

$sum_count= number_format( $sale_count,2)."";	
	
$sum_price= number_format( $price_per_unit,2)."";
	
$sum_discount= number_format( $discount_unit,2)."";
	
$summary= number_format( $total,2)."";
	
	?>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="55%" align="left" class="style16">รวมยอดขายของ Sale :&nbsp; <?php echo $sale_code ; ?></td>
<td width="5%" align="right" class="style16"><?php echo $sum_count; ?></td> 
<td width="10%" align="right" class="style16"><?php echo $sum_price; ?></td> 
<td width="10%" align="right" class="style16"><?php echo $sum_discount; ?></td> 
<td width="10%" align="right" class="style16"><?php echo $summary; ?></td> 


	</tr>
</table>






<?php
}else{

$start_date = $_GET["start_date"];
$end_date = $_GET["end_date"];
$doc_no = 'BRNP';

$product_ID = $_GET["h_product_code"];

$strSQL22 = "SELECT access_code,access_name,unit_name,express_code FROM tb_product WHERE product_ID = '".$product_ID."' ";
//echo $strSQL22;

$objQuery22 = mysqli_query($conn,$strSQL22) or die ("Error Query [".$strSQL22."]");
$objResult22 = mysqli_fetch_array($objQuery22);

$access_code1 = $objResult22["access_code"];
$access_name1 = $objResult22["access_name"];
$unit_name1 = $objResult22["unit_name"];
$express_code1 = $objResult22["express_code"];



?>
<span class="style16"><?php echo $access_code1 ; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php  echo $access_name1 ;  ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php  echo $unit_name1 ;  ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php  echo $express_code1 ;  ?></span>





<?php



$strSQL16 ="SELECT * FROM tb_team_allwell ";

$objQuery16 =mysqli_query($com,$strSQL16);

while($objResult16 = mysqli_fetch_array($objQuery16))
{
	$employee_name = $objResult16["sale_code"];

$strSQL1 = "SELECT doc_release_date,product_id,doc_no,customer_name,billing_name,delivery_name,sale_count,price_per_unit,sum_amount,discount_unit FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE product_id = '".$product_ID."' and employee_name = '".$employee_name."' and cancel_ckk = '0'";

if($start_date !=""){ 
    $strSQL1 .= ' AND doc_release_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL1 .= ' AND doc_release_date <= "'.$end_date.'"'; 
}
	
$strSQL1 .= ' AND doc_no NOT LIKE "%'.$doc_no.'%"'; 

//echo $strSQL1;
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
if($Num_Rows1 == '0'){
}else{
?>
</p>
<span class="style16"><?php echo $employee_name ; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php  echo $employee_name ;  ?></span>

	</p>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="10%" align="center" class="style30">วันที่</td>
<td width="20%" align="center" class="style30">เลขที่เอกสาร</td>
<td width="25%" align="center" class="style30">ชื่อลุกค้า</td> 
<td width="5%" align="center" class="style30">จำนวน</td> 
<td width="10%" align="center" class="style30">ราคาต่อหน่วย</td> 
<td width="10%" align="center" class="style30">ส่วนลดต่อชิ้น</td> 
<td width="10%" align="center" class="style30">ราคารวม</td> 

	</tr>

<?php 
while($objResult1 = mysqli_fetch_array($objQuery1))
{


?>
 <tr>
<td width="10%" align="center" class="style30"><?php echo datethai($objResult1["doc_release_date"]);  ?></td>
<td width="20%" align="center" class="style30"><?php echo $objResult1["doc_no"];  ?></td>
<td width="25%" align="left" class="style30"><?php echo $objResult1["customer_name"];  ?></td> 
<td width="5%" align="center" class="style30"><?php echo $objResult1["sale_count"];  ?></td> 
<td width="10%" align="right" class="style30"><?php echo number_format( $objResult1["price_per_unit"],2)."";  ?></td> 
<td width="10%" align="right" class="style30"><?php echo number_format( $objResult1["discount_unit"],2)."";  ?></td> 
<td width="10%" align="right" class="style30"><?php echo number_format( $objResult1["sum_amount"],2)."";  ?></td> 

	</tr>

<?php
	
}


	?>
</table>	

<?php
	  $strSQL5 = "SELECT SUM(sum_amount)  as total,SUM(sale_count)  as sale_count,SUM(price_per_unit)  as price_per_unit,SUM(discount_unit)  as discount_unit  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE product_id = '".$product_ID."' and employee_name = '".$employee_name."' and cancel_ckk = '0'";

if($start_date !=""){ 
    $strSQL5 .= ' AND doc_release_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL5 .= ' AND doc_release_date <= "'.$end_date.'"'; 
}

$strSQL5 .= ' AND doc_no NOT LIKE "%'.$doc_no.'%"'; 

$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$objResult5 = mysqli_fetch_array($objQuery5);



$sale_count1=$objResult5['sale_count'];
$sale_count= number_format( $sale_count1,2)."";	
	  
$price_per_unit1=$objResult5['price_per_unit'];	
$price_per_unit= number_format( $price_per_unit1,2)."";
	
$discount_unit1=$objResult5['discount_unit'];
$discount_unit= number_format( $discount_unit1,2)."";
	
$total12=$objResult5['total'];
$total2= number_format( $total12,2)."";
	
	?>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="55%" align="left" class="style16">รวมยอดขายของ Sale :&nbsp; <?php echo $employee_name ; ?></td>
<td width="5%" align="right" class="style16"><?php echo $sale_count; ?></td> 
<td width="10%" align="right" class="style16"><?php echo $price_per_unit; ?></td> 
<td width="10%" align="right" class="style16"><?php echo $discount_unit; ?></td> 
<td width="10%" align="right" class="style16"><?php echo $total2; ?></td> 


	</tr>
</table>

	<?php
}
}
	?>

<?php
	
$strSQL3 = "SELECT SUM(sum_amount)  as total,SUM(sale_count)  as sale_count,SUM(price_per_unit)  as price_per_unit,SUM(discount_unit)  as discount_unit  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE product_id = '".$product_ID."' and cancel_ckk = '0'";

if($start_date !=""){ 
    $strSQL3 .= ' AND doc_release_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL3 .= ' AND doc_release_date <= "'.$end_date.'"'; 
}

$strSQL3 .= ' AND doc_no NOT LIKE "%'.$doc_no.'%"'; 

$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);
	
$total=$objResult3['total'];
$discount_unit=$objResult3['discount_unit'];
$price_per_unit=$objResult3['price_per_unit'];
$sale_count=$objResult3['sale_count'];
	


$sum_count= number_format( $sale_count,2)."";	
	
$sum_price= number_format( $price_per_unit,2)."";
	
$sum_discount= number_format( $discount_unit,2)."";
	
$summary= number_format( $total,2)."";
	
	?>

<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="55%" align="left" class="style16">รวมยอดขายทั้งหมด</td>
<td width="5%" align="right" class="style16"><?php echo $sum_count; ?></td> 
<td width="10%" align="right" class="style16"><?php echo $sum_price; ?></td> 
<td width="10%" align="right" class="style16"><?php echo $sum_discount; ?></td> 
<td width="10%" align="right" class="style16"><?php echo $summary; ?></td> 


	</tr>
</table>




<?php
}

?>

</p></p></p>



</body>
</html>