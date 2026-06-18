
<?php
define('FPDF_FONTPATH','font/');
require('fpdf.php');
$deposit_code=$_GET["deposit_code"];
include "dbconnect.php";

$strSQL = "SELECT tb_deposit.* ,tb_payment.* FROM (tb_deposit LEFT JOIN tb_payment ON tb_deposit.payment =tb_payment.payment_ID) WHERE deposit_code = '".$deposit_code."' ";
$objQuery = mysqli_query($conn,$strSQL)or die ("Error Query [".$strSQL."]");;
$objResult = mysqli_fetch_array($objQuery);

$strSQL1 = "SELECT * FROM tb_transaction WHERE deposit_id = '".$deposit_code."' ";
$objQuery1 = mysqli_query($conn,$strSQL1)or die ("Error Query [".$strSQL1."]");;
$objResult1 = mysqli_fetch_array($objQuery1);
//echo $strSQL;

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
$bill_name =$objResult["bill_name"];
$deposit_code =$objResult["deposit_code"];
$bill_address =$objResult["bill_address"];
//$bill_date =$objResult["bill_date"];
$date = explode('-' , $objResult["bill_date"] );
$bill_date = $date[2].'-'.$date[1].'-'.$date[0];


$bill_tel =$objResult["bill_tel"];
$customer_contact =$objResult["customer_contact"];
$tax_id =$objResult["tax_id"];

//$delivery_date =$objResult["delivery_date"];
$date1 = explode('-' , $objResult["delivery_date"] );
$delivery_date = $date1[2].'-'.$date1[1].'-'.$date1[0];


$bank_name =$objResult["bank_name"];
$check_no =$objResult["check_no"];
$delivery_time =$objResult["delivery_time"];
$department =$objResult["department"];
$delivery_name =$objResult["delivery_name"];
$delivery_tel =$objResult["delivery_tel"];
$delivery_address =$objResult["delivery_address"];
$product_name1 =$objResult["product_name1"];
$product_name2 =$objResult["product_name2"];
$product_name3 =$objResult["product_name3"];
$product_name4 =$objResult["product_name4"];
$product_name5 =$objResult["product_name5"];
$product_name6 =$objResult["product_name6"];
$product_name7 =$objResult["product_name7"];
$product_name8 =$objResult["product_name8"];
$product_name9 =$objResult["product_name9"];
$product_name10 =$objResult["product_name10"];
$unit1 =$objResult["unit_price1"];
$unit2 =$objResult["unit_price2"];
$unit3 =$objResult["unit_price3"];
$unit4 =$objResult["unit_price4"];
$unit5 =$objResult["unit_price5"];
$unit6 =$objResult["unit_price6"];
$unit7 =$objResult["unit_price7"];
$unit8 =$objResult["unit_price8"];
$unit9 =$objResult["unit_price9"];
$unit10 =$objResult["unit_price10"];
$iv_no = $objResult["iv_no"];
$payment_name =$objResult["payment_name"];
$sum_unit =$objResult["sum_unit_price"];

$unit_price1 = number_format( $unit1,2)."";

if($product_name2 !=''){
$unit_price2 = number_format( $unit2,2)."";
}else{
$unit_price2 = '';	
}
if($product_name3 !=''){
$unit_price3 = number_format( $unit3,2)."";
}else{
$unit_price3 = '';
}	
if($product_name4 !=''){
$unit_price4 = number_format( $unit4,2)."";
}else{
$unit_price4 = '';	
}	
if($product_name5 !=''){
$unit_price5 = number_format( $unit5,2)."";
}else{
$unit_price5 = '';		
}
if($product_name6 !=''){
$unit_price6 = number_format( $unit6,2)."";
}else{
$unit_price6 = '';		
}
if($product_name7 !=''){
$unit_price7 = number_format( $unit7,2)."";
}else{
$unit_price7 = '';	
}
if($product_name8 !=''){
$unit_price8 = number_format( $unit8,2)."";
}else{
$unit_price8 = '';	
}
if($product_name9 !=''){
$unit_price9 = number_format( $unit9,2)."";
}else{
$unit_price9='';	
}
	
if($product_name10 !=''){	
$unit_price10 = number_format( $unit10,2)."";
}else{
$unit_price10='';	
}
$sum_unit_price = number_format( $sum_unit,2)."";


$payment =$objResult["payment"];
$check_no =$objResult["check_no"];
$branch_name =$objResult["branch_name"];
//$payment_date =$objResult["payment_date"];
$date2 = explode('-' , $objResult["payment_date"] );
$payment_date = $date2[2].'-'.$date2[1].'-'.$date2[0];



$employee_name =$objResult["employee_name"];


$runway  =$objResult1["runway"];
$road  =$objResult1["road"];
$soy  =$objResult1["soy"];
$soy_long  =$objResult1["soy_long"];
$soy_big  =$objResult1["soy_big"];
$car_load  =$objResult1["car_load"];
$car_park  =$objResult1["car_park"];
$car_road  =$objResult1["car_road"];
$no_car_road  =$objResult1["no_car_road"];
$car_home  =$objResult1["car_home"];
$door_long  =$objResult1["door_long"];
$slope  =$objResult1["slope"];
$bundai  =$objResult1["bundai"];
$unit_bundai  =$objResult1["unit_bundai"];
$door_big  =$objResult1["door_big"];
$door_longer  =$objResult1["door_longer"];
$type_door  =$objResult1["type_door"];
$home_type  =$objResult1["home_type"];
$install  =$objResult1["install"];
$bundai_install  =$objResult1["bundai_install"];
$bundai_big  =$objResult1["bundai_big"];
$lip  =$objResult1["lip"];
$lip_big  =$objResult1["lip_big"];
$lip_long  =$objResult1["lip_long"];
$lip_weight  =$objResult1["lip_weight"];
$want_employee  =$objResult1["want_employee"];
$employee_unit  =$objResult1["employee_unit"];
$ferniger_address  =$objResult1["ferniger_address"];
$ferniger_name  =$objResult1["ferniger_name"];
$want_ex  =$objResult1["want_ex"];
$want_credit  =$objResult1["want_credit"];
$want_prem  =$objResult1["want_prem"];
$hieght_ltd = $objResult1["hieght_ltd"];
$room_bigger  =$objResult1["room_bigger"];
$room_longer  =$objResult1["room_longer"];
$bundai_hug  =$objResult1["bundai_hug"];
$bank  =$objResult1["bank"];

$description_tran=$objResult1["description"];
$type_bundai =$objResult1["type_bundai"];
$head_bad=$objResult1["head_bad"];
$up=$objResult1["up"];
$no_up=$objResult1["no_up"];
$height_ltd=$objResult1["height_ltd"];


$pdf=new FPDF( 'P' , 'cm' , 'A4' );
$pdf->AddFont('angsa','','angsa.php');
$pdf->AddFont('angsana','B','angsab.php');
 
$pdf->AddPage();
$pdf->SetFont('angsana','B',18);

$pdf->setXY( 1.0,0.7);
$pdf->Cell( 19.2,1.0, "",1,1,"c" );


$pdf->setXY( 8.0, 1.0  );
$pdf->MultiCell( 9  , 0.6 , iconv( 'UTF-8','cp874' , "ใบรับเงินมัดจำ (Deposit Receipt)"),0 ,'L' );

$pdf->SetFont('angsa','',15);


$pdf->setXY( 1.0,1.7);
$pdf->Cell( 19.2,2.8,"",1,1,"c" );


$pdf->setXY( 1.4,1.8);
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "ชื่อลูกค้าที่ออกบิล  :" ),0,'L' );

$pdf->setXY(4.5,1.8);
$pdf->MultiCell(12.0, 0.6 , iconv( 'UTF-8','cp874' , "$bill_name" ),0,'L' );

$pdf->setXY( 4.5,2.3);
$pdf->Cell(12.0,0,'','T',0,'c',0);



$pdf->setXY( 1.4,2.3);
$pdf->MultiCell(12, 0.6 , iconv( 'UTF-8','cp874' , "ที่อยู่  :" ),0,'L' );

$pdf->setXY(4.5,2.3);
$pdf->MultiCell(12, 0.5 , iconv( 'UTF-8','cp874' , "$bill_address" ),0,'L' );
$pdf->setXY( 4.5,2.8);
$pdf->Cell(12.0,0,'','T',0,'c',0);
$pdf->setXY( 4.5,3.3);
$pdf->Cell(12.0,0,'','T',0,'c',0);

$pdf->setXY( 1.4,3.3);
$pdf->MultiCell(12, 0.6 , iconv( 'UTF-8','cp874' , "เบอร์โทร  :" ),0,'L' );

$pdf->setXY(4.5,3.3);
$pdf->MultiCell(8.0, 0.6 , iconv( 'UTF-8','cp874' , "$bill_tel" ),0,'L' );

$pdf->setXY( 4.5,3.8);
$pdf->Cell(3.8,0,'','T',0,'c',0);


$pdf->setXY(8.5,3.3);
$pdf->MultiCell(12, 0.6 , iconv( 'UTF-8','cp874' , "ชื่อผู้ติดต่อ  :" ),0,'L' );

$pdf->setXY(10.5,3.3);
$pdf->MultiCell(12, 0.6 , iconv( 'UTF-8','cp874' , "$customer_contact" ),0,'L' );

$pdf->setXY( 10.5,3.8);
$pdf->Cell(6.0,0,'','T',0,'c',0);


$pdf->setXY( 1.4,3.8);
$pdf->MultiCell(12, 0.6 , iconv( 'UTF-8','cp874' , "เลขประจำตัวผู้เสียภาษี :" ),0,'L' );

$pdf->setXY(5.0,3.8);
$pdf->MultiCell(12, 0.6 , iconv( 'UTF-8','cp874' , "$tax_id" ),0,'L' );

$pdf->setXY(5.0,4.3);
$pdf->Cell(11.5,0,'','T',0,'c',0);

$pdf->setXY(16.7,1.7);
$pdf->Cell(3.5,2.8,"",1,1,"c" );

$pdf->setXY(16.8,1.8);
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "เลขที่ :" ),0,'L' );

$pdf->setXY(17.8,1.8);
$pdf->MultiCell(12.0, 0.6 , iconv( 'UTF-8','cp874' , "$iv_no" ),0,'L' );

$pdf->setXY(17.8,2.4);
$pdf->Cell(2.2,0,'','T',0,'c',0);


$pdf->setXY(16.8,2.4);
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "วันที่ :" ),0,'L' );

$pdf->setXY(17.8,2.4);
$pdf->MultiCell(12.0, 0.6 , iconv( 'UTF-8','cp874' , "$bill_date" ),0,'L' );

$pdf->setXY(17.8,3.0);
$pdf->Cell(2.2,0,'','T',0,'c',0);


$pdf->setXY( 1.0,4.5);
$pdf->Cell( 19.2,2.2,"",1,1,"c" );

$pdf->setXY(16.7,4.5);
$pdf->Cell(3.5,2.2,"",1,1,"c" );

$pdf->setXY(16.8,4.5);
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "วันที่ :" ),0,'L' );

$pdf->setXY(17.8,4.5);
$pdf->MultiCell(12.0, 0.6 , iconv( 'UTF-8','cp874' , "$delivery_date" ),0,'L' );

$pdf->setXY(17.8,5.0);
$pdf->Cell(2.2,0,'','T',0,'c',0);

$pdf->setXY(16.8,5.0);
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "เวลา :" ),0,'L' );

$pdf->setXY(17.8,5.0);
$pdf->MultiCell(12.0, 0.6 , iconv( 'UTF-8','cp874' , "$delivery_time" ),0,'L' );

$pdf->setXY(17.8,5.5);
$pdf->Cell(2.2,0,'','T',0,'c',0);

$pdf->setXY(16.8,5.5);
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "แผนก :" ),0,'L' );

$pdf->setXY(17.8,5.5);
$pdf->MultiCell(12.0, 0.6 , iconv( 'UTF-8','cp874' , "$department" ),0,'L' );

$pdf->setXY(17.8,6.0);
$pdf->Cell(2.2,0,'','T',0,'c',0);

$pdf->SetFont('angsa','',14);

 
$pdf->setXY( 1.4,4.5);
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "ชื่อลูกค้าที่ออกบิล  :" ),0,'L' );

$pdf->setXY(4.5,4.5);
$pdf->MultiCell(12.0, 0.6 , iconv( 'UTF-8','cp874' , "$delivery_name" ),0,'L' );

$pdf->setXY( 4.5,5.0);
$pdf->Cell(12.0,0,'','T',0,'c',0);

$pdf->setXY( 1.4,5.0);
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "เบอร์โทร  :" ),0,'L' );

$pdf->setXY(4.5,5.0);
$pdf->MultiCell(12.0, 0.6 , iconv( 'UTF-8','cp874' , "$delivery_tel" ),0,'L' );

$pdf->setXY( 4.5,5.5);
$pdf->Cell(12.0,0,'','T',0,'c',0);

$pdf->setXY( 1.4,5.5);
$pdf->MultiCell(12, 0.6 , iconv( 'UTF-8','cp874' , "ที่อยู่จัดส่ง :" ),0,'L' );

$pdf->setXY(4.5,5.5);
$pdf->MultiCell(12, 0.5 , iconv( 'UTF-8','cp874' , "$delivery_address" ),0,'L' );
$pdf->setXY( 4.5,6.0);
$pdf->Cell(12.0,0,'','T',0,'c',0);
$pdf->setXY( 4.5,6.5);
$pdf->Cell(12.0,0,'','T',0,'c',0);

$pdf->setXY( 1.0,6.7);
$pdf->Cell( 19.2,0.5, "",1,1,"c" );

$pdf->setXY(16.7,6.7);
$pdf->Cell(3.5,0.5,"",1,1,"c" );

$pdf->SetFont('angsa','',13.5);

$pdf->setXY(8.0,6.7);
$pdf->MultiCell(12, 0.6 , iconv( 'UTF-8','cp874' , "รายการสินค้า" ),0,'L' );

$pdf->setXY(17.5,6.7);
$pdf->MultiCell(12, 0.6 , iconv( 'UTF-8','cp874' , "จำนวนเงิน" ),0,'L' );

$pdf->setXY( 1.0,7.2);
$pdf->Cell( 19.2,5.15, "",1,1,"c" );

$pdf->setXY(16.7,7.2);
$pdf->Cell(3.5,5.15,"",1,1,"c" );

$pdf->setXY( 1.4,7.2);
$pdf->MultiCell(12, 0.6 , iconv( 'UTF-8','cp874' , "1." ),0,'L' );

$pdf->setXY(1.8,7.2);
$pdf->MultiCell(12, 0.6 , iconv( 'UTF-8','cp874' , "$product_name1" ),0,'L' );

$pdf->setXY(1.8,7.7);
$pdf->Cell(14.6,0,'','T',0,'c',0);

$pdf->setXY( 1.4,7.7);
$pdf->MultiCell(12, 0.6 , iconv( 'UTF-8','cp874' , "2." ),0,'L' );

$pdf->setXY(1.8,7.7);
$pdf->MultiCell(12, 0.6 , iconv( 'UTF-8','cp874' , "$product_name2" ),0,'L' );

$pdf->setXY(1.8,8.2);
$pdf->Cell(14.6,0,'','T',0,'c',0);


$pdf->setXY( 1.4,8.2);
$pdf->MultiCell(12, 0.6 , iconv( 'UTF-8','cp874' , "3." ),0,'L' );

$pdf->setXY(1.8,8.2);
$pdf->MultiCell(12, 0.6 , iconv( 'UTF-8','cp874' , "$product_name3" ),0,'L' );

$pdf->setXY(1.8,8.7);
$pdf->Cell(14.6,0,'','T',0,'c',0);


$pdf->setXY( 1.4,8.7);
$pdf->MultiCell(12, 0.6 , iconv( 'UTF-8','cp874' , "4." ),0,'L' );

$pdf->setXY(1.8,8.7);
$pdf->MultiCell(12, 0.6 , iconv( 'UTF-8','cp874' , "$product_name4" ),0,'L' );

$pdf->setXY(1.8,9.2);
$pdf->Cell(14.6,0,'','T',0,'c',0);


$pdf->setXY( 1.4,9.2);
$pdf->MultiCell(12, 0.6 , iconv( 'UTF-8','cp874' , "5." ),0,'L' );

$pdf->setXY(1.8,9.2);
$pdf->MultiCell(12, 0.6 , iconv( 'UTF-8','cp874' , "$product_name5" ),0,'L' );

$pdf->setXY(1.8,9.7);
$pdf->Cell(14.6,0,'','T',0,'c',0);

$pdf->setXY( 1.4,9.7);
$pdf->MultiCell(12, 0.6 , iconv( 'UTF-8','cp874' , "6." ),0,'L' );

$pdf->setXY(1.8,9.7);
$pdf->MultiCell(12, 0.6 , iconv( 'UTF-8','cp874' , "$product_name6" ),0,'L' );

$pdf->setXY(1.8,10.2);
$pdf->Cell(14.6,0,'','T',0,'c',0);

$pdf->setXY( 1.4,10.2);
$pdf->MultiCell(12, 0.6 , iconv( 'UTF-8','cp874' , "7." ),0,'L' );

$pdf->setXY(1.8,10.2);
$pdf->MultiCell(12, 0.6 , iconv( 'UTF-8','cp874' , "$product_name7" ),0,'L' );

$pdf->setXY(1.8,10.7);
$pdf->Cell(14.6,0,'','T',0,'c',0);

$pdf->setXY( 1.4,10.7);
$pdf->MultiCell(12, 0.6 , iconv( 'UTF-8','cp874' , "8." ),0,'L' );

$pdf->setXY(1.8,10.7);
$pdf->MultiCell(12, 0.6 , iconv( 'UTF-8','cp874' , "$product_name8" ),0,'L' );

$pdf->setXY(1.8,11.2);
$pdf->Cell(14.6,0,'','T',0,'c',0);

$pdf->setXY( 1.4,11.2);
$pdf->MultiCell(12, 0.6 , iconv( 'UTF-8','cp874' , "9." ),0,'L' );

$pdf->setXY(1.8,11.2);
$pdf->MultiCell(12, 0.6 , iconv( 'UTF-8','cp874' , "$product_name9" ),0,'L' );

$pdf->setXY(1.8,11.7);
$pdf->Cell(14.6,0,'','T',0,'c',0);

$pdf->setXY( 1.4,11.7);
$pdf->MultiCell(12, 0.6 , iconv( 'UTF-8','cp874' , "10." ),0,'L' );

$pdf->setXY(1.8,11.7);
$pdf->MultiCell(12, 0.6 , iconv( 'UTF-8','cp874' , "$product_name10" ),0,'L' );

$pdf->setXY(1.8,12.2);
$pdf->Cell(14.6,0,'','T',0,'c',0);



$pdf->setXY(17.3,7.2);
$pdf->MultiCell(12, 0.6 , iconv( 'UTF-8','cp874' , "$unit_price1" ),0,'L' );

$pdf->setXY(16.8,7.7);
$pdf->Cell(3.2,0,'','T',0,'c',0);

$pdf->setXY(17.3,7.7);
$pdf->MultiCell(12, 0.6 , iconv( 'UTF-8','cp874' , "$unit_price2" ),0,'L' );

$pdf->setXY(16.8,8.2);
$pdf->Cell(3.2,0,'','T',0,'c',0);

$pdf->setXY(17.3,8.2);
$pdf->MultiCell(12, 0.6 , iconv( 'UTF-8','cp874' , "$unit_price3" ),0,'L' );

$pdf->setXY(16.8,8.7);
$pdf->Cell(3.2,0,'','T',0,'c',0);

$pdf->setXY(17.3,8.7);
$pdf->MultiCell(12, 0.6 , iconv( 'UTF-8','cp874' , "$unit_price4" ),0,'L' );

$pdf->setXY(16.8,9.2);
$pdf->Cell(3.2,0,'','T',0,'c',0);

$pdf->setXY(17.3,9.2);
$pdf->MultiCell(12, 0.6 , iconv( 'UTF-8','cp874' , "$unit_price5" ),0,'L' );

$pdf->setXY(16.8,9.7);
$pdf->Cell(3.2,0,'','T',0,'c',0);

$pdf->setXY(17.3,9.7);
$pdf->MultiCell(12, 0.6 , iconv( 'UTF-8','cp874' , "$unit_price6" ),0,'L' );

$pdf->setXY(16.8,10.2);
$pdf->Cell(3.2,0,'','T',0,'c',0);

$pdf->setXY(17.3,10.2);
$pdf->MultiCell(12, 0.6 , iconv( 'UTF-8','cp874' , "$unit_price7" ),0,'L' );

$pdf->setXY(16.8,10.7);
$pdf->Cell(3.2,0,'','T',0,'c',0);

$pdf->setXY(17.3,10.7);
$pdf->MultiCell(12, 0.6 , iconv( 'UTF-8','cp874' , "$unit_price8" ),0,'L' );

$pdf->setXY(16.8,11.2);
$pdf->Cell(3.2,0,'','T',0,'c',0);

$pdf->setXY(17.3,11.2);
$pdf->MultiCell(12, 0.6 , iconv( 'UTF-8','cp874' , "$unit_price9" ),0,'L' );

$pdf->setXY(16.8,11.7);
$pdf->Cell(3.2,0,'','T',0,'c',0);

$pdf->setXY(17.3,11.7);
$pdf->MultiCell(12, 0.6 , iconv( 'UTF-8','cp874' , "$unit_price10" ),0,'L' );

$pdf->setXY(16.8,12.2);
$pdf->Cell(3.2,0,'','T',0,'c',0);


$pdf->SetFont('angsa','',14);

$pdf->setXY( 1.0,13.95);
$pdf->Cell( 13.6,1.15, "",1,1,"c" );

$pdf->setXY( 1.4,14.2);
$pdf->MultiCell(12, 0.6 , iconv( 'UTF-8','cp874' , "ผู้รับเงิน (ตัวบรรจง)" ),0,'L' );

$pdf->setXY( 4.5,15);
$pdf->Cell(6.0,0,'','T',0,'c',0);



$pdf->setXY(1.0,12.35);
$pdf->Cell(13.6,1.6,"",1,1,"c" );

$pdf->setXY(16.7,12.35);
$pdf->Cell(3.5,2.75,"",1,1,"c" );

$pdf->setXY(14.6,12.35);
$pdf->Cell(2.1,2.75,"",1,1,"c" );

$pdf->setXY(14.9,13.5);
$pdf->MultiCell(12, 0.6 , iconv( 'UTF-8','cp874' , "รวมเงิน" ),0,'L' );

$pdf->setXY(17.2,13.5);
$pdf->MultiCell(12, 0.6 , iconv( 'UTF-8','cp874' , "$sum_unit_price" ),0,'L' );

$pdf->setXY(19.4,13.5);
$pdf->MultiCell(12, 0.6 , iconv( 'UTF-8','cp874' , "บาท" ),0,'L' );

$pdf->setXY( 1.4,12.3);
$pdf->MultiCell(12, 0.6 , iconv( 'UTF-8','cp874' , "รายการรับชำระ :" ),0,'L' );

$pdf->setXY(4.5,12.3);
$pdf->MultiCell(12, 0.6 , iconv( 'UTF-8','cp874' , "$payment_name" ),0,'L' );
$pdf->setXY( 4.5,12.8);
$pdf->Cell(10.0,0,'','T',0,'c',0);


$pdf->setXY( 1.4,12.8);
$pdf->MultiCell(12, 0.6 , iconv( 'UTF-8','cp874' , "ธนาคาร  :" ),0,'L' );

$pdf->setXY(4.5,12.8);
$pdf->MultiCell(8.0, 0.6 , iconv( 'UTF-8','cp874' , "$bank_name" ),0,'L' );

$pdf->setXY( 4.5,13.3);
$pdf->Cell(3.8,0,'','T',0,'c',0);


$pdf->setXY(8.5,12.8);
$pdf->MultiCell(12, 0.6 , iconv( 'UTF-8','cp874' , "เลขที่ /Chq#  :" ),0,'L' );

$pdf->setXY(11.0,12.8);
$pdf->MultiCell(12, 0.6 , iconv( 'UTF-8','cp874' , "$check_no" ),0,'L' );

$pdf->setXY(11.0,13.3);
$pdf->Cell(3.5,0,'','T',0,'c',0);

$pdf->setXY( 1.4,13.3);
$pdf->MultiCell(12, 0.6 , iconv( 'UTF-8','cp874' , "สาขา  :" ),0,'L' );

$pdf->setXY(4.5,13.3);
$pdf->MultiCell(8.0, 0.6 , iconv( 'UTF-8','cp874' , "$branch_name" ),0,'L' );

$pdf->setXY( 4.5,13.8);
$pdf->Cell(3.8,0,'','T',0,'c',0);


$pdf->setXY(8.5,13.3);
$pdf->MultiCell(12, 0.6 , iconv( 'UTF-8','cp874' , "ลงวันที่ /Date :" ),0,'L' );

$pdf->setXY(11.0,13.3);
$pdf->MultiCell(12, 0.6 , iconv( 'UTF-8','cp874' , "$payment_date" ),0,'L' );

$pdf->setXY(11.0,13.8);
$pdf->Cell(3.5,0,'','T',0,'c',0);




$pdf->SetFont('angsa','',14);

$pdf->setXY( 1.4,27.0);
$pdf->MultiCell(12, 0.6 , iconv( 'UTF-8','cp874' , "อนุมัติวันที่ 26 มิ.ย. 2560" ),0,'L' );

$pdf->setXY(17.5,27.0);
$pdf->MultiCell(12, 0.6 , iconv( 'UTF-8','cp874' , "FM-AC-10 : Rev.0" ),0,'L' );


$pdf->SetFont('angsa','',15);


$pdf->setXY(1.0,15.1);
$pdf->Cell(19.2,12.0, "",1,1,"c" );


$pdf->setXY( 1.4,15.2);
$pdf->MultiCell(12, 0.6 , iconv( 'UTF-8','cp874' , "รายละเอียดการจัดส่ง" ),0,'L' );


if($runway=="0")
{

$pdf->setXY(1.7,16.0);
$pdf->MultiCell( 0.35  , 0.35 , iconv( 'UTF-8','cp874' , "" ),1,'L' );
$pdf->setXY( 2.1,15.8);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "ติดถนนรันเวย์" ),0,'L' );

}

else if($runway=="1")
{
$pdf->Image("img/cor.jpeg",1.4,15.8,0.90,0.60);

$pdf->setXY(2.1,15.8);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "ติดถนนรันเวย์" ),0,'L' );

}

if($road=="0")
{

$pdf->setXY(7.5,16.0);
$pdf->MultiCell( 0.35  , 0.35 , iconv( 'UTF-8','cp874' , "" ),1,'L' );
//หมายเหตุ
$pdf->setXY(8.0,15.8);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "ติดถนนวิ่งสวนกัน" ),0,'L' );

}

else if($road=="1")
{

$pdf->Image("img/cor.jpeg",7.3,15.8,0.90,0.60);

$pdf->setXY(8.0,15.8);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "ติดถนนวิ่งสวนกัน" ),0,'L' );

}

if($soy=="0")
{

$pdf->setXY(1.7,16.6);
$pdf->MultiCell( 0.35  , 0.35 , iconv( 'UTF-8','cp874' , "" ),1,'L' );
//หมายเหตุ
$pdf->setXY(2.1,16.4);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "เข้าซอย" ),0,'L' );

}

else if($soy=="1")
{

$pdf->Image("img/cor.jpeg",1.4,16.4,0.90,0.60);

$pdf->setXY( 2.1,16.4);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "เข้าซอย" ),0,'L' );

}

$pdf->setXY( 8.0,16.4);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "ทางเข้า กว้าง :" ),0,'L' );


$pdf->setXY(10.3,16.4);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "$soy_long" ),0,'L' );

$pdf->setXY(12.0,16.4);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "เมตร" ),0,'L' );
$pdf->setXY(10.3,17.0);
$pdf->Cell(1.7,0, "",1,1,"c" );

if($hieght_ltd=="1")
{


	$pdf->Image("img/cor.jpeg",13.5,16.4,0.90,0.60);
//หมายเหตุ
$pdf->setXY(14.3,16.4);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "มีตัวจำกัดความสูง" ),0,'L' );

}

else 
{

$pdf->setXY(13.7,16.6);
$pdf->MultiCell( 0.35  , 0.35 , iconv( 'UTF-8','cp874' , "" ),1,'L' );

$pdf->setXY( 14.3,16.4);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "มีตัวจำกัดความสูง" ),0,'L' );

}

if($car_load=="0")
{

$pdf->setXY(1.7,17.2);
$pdf->MultiCell( 0.35  , 0.35 , iconv( 'UTF-8','cp874' , "" ),1,'L' );
//หมายเหตุ
$pdf->setXY( 2.1,17.0);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "รถยนต์เข้าได้" ),0,'L' );

}

else if($car_load=="1")
{

$pdf->Image("img/cor.jpeg",1.4,17.0,0.90,0.60);

$pdf->setXY( 2.1,17.0);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "รถยนต์เข้าได้" ),0,'L' );

}

if($no_car_road=="0")
{

$pdf->setXY(7.5,17.2);
$pdf->MultiCell( 0.35  , 0.35 , iconv( 'UTF-8','cp874' , "" ),1,'L' );
//หมายเหตุ
$pdf->setXY(8.0,17.0);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "รถยนต์เข้าไม่ได้" ),0,'L' );

}

else if($no_car_road=="1")
{

$pdf->Image("img/cor.jpeg",7.3,17.0,0.90,0.60);

$pdf->setXY(8.0,17.0);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "รถยนต์เข้าไม่ได้" ),0,'L' );

}


$pdf->setXY(13.5,17.0);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "สามารถจอดได้ที่ :" ),0,'L' );

$pdf->setXY(16.5,17.0);
$pdf->MultiCell( 8, 0.6 , iconv( 'UTF-8','cp874' , "$car_park" ),0,'L' );

$pdf->setXY(16.5,17.6);
$pdf->Cell(0,8,'','T',0,'C',0);

if($car_road=="0")
{

$pdf->setXY(1.7,17.8);
$pdf->MultiCell( 0.35  , 0.35 , iconv( 'UTF-8','cp874' , "" ),1,'L' );
//หมายเหตุ
$pdf->setXY( 2.1,17.6);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "จอดรถข้างถนน" ),0,'L' );

}

else if($car_road=="1")
{

$pdf->Image("img/cor.jpeg",1.4,17.6,0.90,0.60);

$pdf->setXY(2.1,17.6);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "จอดรถข้างถนน" ),0,'L' );

}

if($car_home=="0")
{

$pdf->setXY( 7.5,17.8);
$pdf->MultiCell( 0.35 ,0.35 , iconv( 'UTF-8','cp874' , "" ),1,'L' );
//หมายเหตุ
$pdf->setXY( 8.0,17.6);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "จอดรถหน้าบ้านได้" ),0,'L' );

}

else if($car_home=="1")
{

$pdf->Image("img/cor.jpeg",7.3,17.6,0.90,0.60);

$pdf->setXY(8.0,17.6);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "จอดรถหน้าบ้านได้" ),0,'L' );

}

$pdf->setXY(13.5,17.6);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "ประตูหน้าบ้านสูง :" ),0,'L' );

$pdf->setXY(16.7,17.6);
$pdf->MultiCell( 8, 0.6 , iconv( 'UTF-8','cp874' , "$door_long" ),0,'L' );


$pdf->setXY(19.0,17.6);
$pdf->MultiCell( 8, 0.6 , iconv( 'UTF-8','cp874' , "เมตร" ),0,'L' );


$pdf->setXY(16.5,18.2);
$pdf->Cell(2.3,0,'','T',0,'C',0);




if($slope=="0")
{

$pdf->setXY( 1.7,18.4);
$pdf->MultiCell( 0.35  , 0.35 , iconv( 'UTF-8','cp874' , "" ),1,'L' );
//หมายเหตุ
$pdf->setXY( 2.1,18.2);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "มีทางราบก่อนประตูบ้าน" ),0,'L' );

}

else if($slope=="1")
{

$pdf->Image("img/cor.jpeg",1.4,18.2,0.90,0.60);

$pdf->setXY( 2.1,18.2);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "มีทางราบก่อนประตูบ้าน" ),0,'L' );

}

if($bundai=="0")
{

$pdf->setXY( 7.5,18.4);
$pdf->MultiCell( 0.35  , 0.35 , iconv( 'UTF-8','cp874' , "" ),1,'L' );
//หมายเหตุ
$pdf->setXY(8.0,18.2);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "มีบันไดก่อนประตูบ้าน" ),0,'L' );

}

else if($bundai=="1")
{

$pdf->Image("img/cor.jpeg",7.3,18.2,0.90,0.60);

$pdf->setXY(8.0,18.2);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "มีบันไดก่อนประตูบ้าน" ),0,'L' );

}

$pdf->setXY( 13.5,18.2);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "จำนวน :" ),0,'L' );


$pdf->setXY( 16.5,18.2);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "$unit_bundai" ),0,'L' );
$pdf->setXY( 19.0,18.2);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "ขั้น" ),0,'L' );

$pdf->setXY(16.5,18.8);
$pdf->Cell(2.3,0,'','T',0,'C',0);

$pdf->setXY( 1.4,18.8);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "ประตูบ้านกว้าง :" ),0,'L' );


$pdf->setXY( 4.5,18.8);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "$door_big " ),0,'L' );
$pdf->setXY( 5.8,18.8);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "เมตร" ),0,'L' );

$pdf->setXY(4.1,19.4);
$pdf->Cell(1.8,0,'','T',0,'C',0);

$pdf->setXY( 7.5,18.8);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "สูง :" ),0,'L' );


$pdf->setXY(9.0,18.8);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "$door_longer " ),0,'L' );
$pdf->setXY( 12.0,18.8);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "เมตร" ),0,'L' );

$pdf->setXY(8.5,19.4);
$pdf->Cell(3.2,0,'','T',0,'C',0);

$pdf->setXY(13.5,18.8);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "ประตูบ้านเป็นแบบ :" ),0,'L' );


$pdf->setXY(16.7,18.8);
$pdf->MultiCell( 4.7, 0.6 , iconv( 'UTF-8','cp874' , "$type_door " ),0,'L' );


$pdf->setXY(16.7,19.4);
$pdf->Cell(3.2,0,'','T',0,'C',0);

$pdf->setXY( 1.4,19.4);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "ติดตั้งที่ชั้น :" ),0,'L' );



$pdf->setXY(3.5,19.4);
$pdf->MultiCell( 4.0, 0.6 , iconv( 'UTF-8','cp874' , "$install" ),0,'L' );

$pdf->setXY(3.4,20.0);
$pdf->Cell(3.2,0,'','T',0,'C',0);

$pdf->setXY(7.5,19.4);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "พื้นบ้านเป็นแบบ :" ),0,'L' );


$pdf->setXY(10.3,19.4);
$pdf->MultiCell( 12.6, 0.6 , iconv( 'UTF-8','cp874' , "$home_type " ),0,'L' );

$pdf->setXY(10.3,20.0);
$pdf->Cell(9.5,0,'','T',0,'C',0);



$pdf->setXY( 1.4,20.0);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "ประตูห้องกว้าง :" ),0,'L' );


$pdf->setXY( 4.5,20.0);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "$room_bigger " ),0,'L' );
$pdf->setXY( 5.8,20.0);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "เมตร" ),0,'L' );

$pdf->setXY(4.1,20.6);
$pdf->Cell(1.8,0,'','T',0,'C',0);


$pdf->setXY( 7.5,20.0);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "สูง :" ),0,'L' );

$pdf->setXY(9.0,20.0);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "$room_longer " ),0,'L' );

$pdf->setXY( 12.0,20.0);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "เมตร" ),0,'L' );

$pdf->setXY(8.5,20.6);
$pdf->Cell(3.2,0,'','T',0,'C',0);


$pdf->setXY( 13.5,20.0);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "ชนิดบันได :" ),0,'L' );



$pdf->setXY( 15.5,20.0);
$pdf->MultiCell( 4, 0.6 , iconv( 'UTF-8','cp874' , "$type_bundai" ),0,'L' );	

$pdf->setXY( 15.5,20.6);
$pdf->Cell(4.5,0,'','T',0,'C',0);


if($bundai_install=="0")
{

$pdf->setXY(1.7,20.6);
$pdf->MultiCell( 0.35  , 0.35 , iconv( 'UTF-8','cp874' , "" ),1,'L' );
//หมายเหตุ
$pdf->setXY( 2.1,20.6);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "บันได" ),0,'L' );

}

else if($bundai_install=="1")
{

$pdf->Image("img/cor.jpeg",1.4,20.6,0.90,0.60);

$pdf->setXY( 2.1,20.6);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "บันได" ),0,'L' );

}

$pdf->setXY( 3.2,20.6);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "กว้าง :" ),0,'L' );


$pdf->setXY( 4.5,20.6);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "$bundai_big" ),0,'L' );

$pdf->setXY(5.8,20.6);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "เมตร" ),0,'L' );

$pdf->setXY(4.3,21.2);
$pdf->Cell(1.4,0,'','T',0,'C',0);



$pdf->setXY( 7.5,20.6);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "สูง :" ),0,'L' );

$pdf->setXY(9.0,20.6);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "" ),0,'L' );

$pdf->setXY( 12.0,20.6);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "เมตร" ),0,'L' );

$pdf->setXY(8.5,21.2);
$pdf->Cell(3.2,0,'','T',0,'C',0);





$pdf->setXY( 13.5,20.6);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "หักมุมบันได :" ),0,'L' );


$pdf->setXY( 16.0,20.6);
$pdf->MultiCell( 4, 0.6 , iconv( 'UTF-8','cp874' , "$bundai_hug" ),0,'L' );

$pdf->setXY( 16.0,21.2);
$pdf->Cell(4,0,'','T',0,'C',0);

if($lip=="0")
{

$pdf->setXY(1.7,21.4);
$pdf->MultiCell( 0.35  , 0.35 , iconv( 'UTF-8','cp874' , "" ),1,'L' );
//หมายเหตุ
$pdf->setXY(2.1,21.2);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "ลิฟท์" ),0,'L' );

}

else if($lip=="1")
{

$pdf->Image("img/cor.jpeg",1.4,21.2,0.90,0.60);

$pdf->setXY(2.1,2.2);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "ลิฟท์" ),0,'L' );

}


$pdf->setXY( 3.2,21.2);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "กว้าง :" ),0,'L' );


$pdf->setXY( 4.5,21.2);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "$lip_big" ),0,'L' );

$pdf->setXY(5.8,21.2);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "เมตร" ),0,'L' );

$pdf->setXY(4.3,21.8);
$pdf->Cell(1.4,0,'','T',0,'C',0);

$pdf->setXY(7.5,21.2);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "สูง :" ),0,'L' );


$pdf->setXY( 9.5,21.2);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "$lip_long" ),0,'L' );

$pdf->setXY( 12.0,21.2);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "เมตร" ),0,'L' );

$pdf->setXY(8.5,21.8);
$pdf->Cell(3.2,0,'','T',0,'C',0);

$pdf->setXY( 13.5,21.2);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "รับน้ำหนักได้ :" ),0,'L' );


$pdf->setXY( 16.0,21.2);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "$lip_weight" ),0,'L' );

$pdf->setXY( 18.5,21.2);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "กิโลกรัม" ),0,'L' );

$pdf->setXY(16.0,21.8);
$pdf->Cell(2.4,0,'','T',0,'C',0);


if($want_employee=="0")
{

$pdf->setXY(1.7,22.0);
$pdf->MultiCell( 0.35  , 0.35 , iconv( 'UTF-8','cp874' , "" ),1,'L' );
//หมายเหตุ
$pdf->setXY(2.1,21.8);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "ต้องการเจ้าหน้าที่ย้ายเฟอร์นิเจอร์" ),0,'L' );

}

else if($want_employee=="1")
{

$pdf->Image("img/cor.jpeg",1.4,21.8,0.90,0.60);

$pdf->setXY(2.1,21.8);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "ต้องการเจ้าหน้าที่ย้ายเฟอร์นิเจอร์" ),0,'L' );

}

$pdf->setXY( 7.5,21.8);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "จำนวน :" ),0,'L' );


$pdf->setXY( 10,21.8);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "$employee_unit" ),0,'L' );

$pdf->setXY( 12.0,21.8);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "คน" ),0,'L' );

$pdf->setXY(9.0,22.4);
$pdf->Cell(2.7,0,'','T',0,'C',0);

if($head_bad=="0")
{

$pdf->setXY( 13.7,22.0);
$pdf->MultiCell( 0.35  , 0.35 , iconv( 'UTF-8','cp874' , "" ),1,'L' );
//หมายเหตุ
$pdf->setXY( 14.5,21.8);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "ต้องถอดหัวเตียง-ท้ายเตียง" ),0,'L' );

}

else if($head_bad=="1")
{

$pdf->Image("img/cor.jpeg",13.5,21.8,0.90,0.60);

$pdf->setXY(14.5,21.8);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "ต้องถอดหัวเตียง-ท้ายเตียง" ),0,'L' );

}


if($up=="1")
{
$pdf->Image("img/cor.jpeg",1.4,22.4,0.90,0.60);

//หมายเหตุ
$pdf->setXY( 2.1,22.4);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "ขึ้นลิฟท์ได้" ),0,'L' );

}

else 
{

$pdf->setXY(1.7,22.6);
$pdf->MultiCell( 0.35  , 0.35 , iconv( 'UTF-8','cp874' , "" ),1,'L' );

$pdf->setXY(2.1,22.4);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "ขึ้นลิฟท์ได้" ),0,'L' );

}
	

	if($no_up=="1")
{
$pdf->Image("img/cor.jpeg",7.5,22.4,0.90,0.60);

//หมายเหตุ
$pdf->setXY(8.1,22.4);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "ขึ้นลิฟท์ไม่ได้" ),0,'L' );

}

else 
{

$pdf->setXY(7.7,22.6);
$pdf->MultiCell( 0.35  , 0.35 , iconv( 'UTF-8','cp874' , "" ),1,'L' );

$pdf->setXY(8.1,22.4);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "ขึ้นลิฟท์ไม่ได้" ),0,'L' );

}

$pdf->setXY(1.4,23.0);
$pdf->MultiCell( 10, 0.7 , iconv( 'UTF-8','cp874' , "ย้ายเฟอร์นิเจอร์ :" ),0,'L' );

$pdf->setXY( 4.1,23.0);
$pdf->MultiCell(7.0, 0.7 , iconv( 'UTF-8','cp874' , "$ferniger_name " ),0,'L' );

$pdf->setXY( 4.1,23.6);
$pdf->Cell(6,0,'','T',0,'C',0);

$pdf->setXY( 4.1,24.2);
$pdf->Cell(6,0,'','T',0,'C',0);

$pdf->setXY( 12,23.0);
$pdf->MultiCell( 6, 0.7 , iconv( 'UTF-8','cp874' , "ย้ายไปที่  :" ),0,'L' );

$pdf->setXY(14,23.0);
$pdf->MultiCell( 6, 0.7 , iconv( 'UTF-8','cp874' , "$ferniger_address " ),0,'L' );


$pdf->setXY(14.0,23.6);
$pdf->Cell(6,0,'','T',0,'C',0);

$pdf->setXY(14.0,24.2);
$pdf->Cell(6,0,'','T',0,'C',0);

if($want_ex=="0")
{

$pdf->setXY(1.7,24.4);
$pdf->MultiCell( 0.35  , 0.35 , iconv( 'UTF-8','cp874' , "" ),1,'L' );
//หมายเหต
$pdf->setXY( 2.1,24.2);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "ต้องเตรียมอุปกรณ์ไปถอดประกอบ" ),0,'L' );

}

else if($want_ex=="1")
{

$pdf->Image("img/cor.jpeg",1.4,24.2,0.90,0.60);

$pdf->setXY( 2.1,24.2);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "ต้องเตรียมอุปกรณ์ไปถอดประกอบ" ),0,'L' );

}

if($want_prem=="0")
{

$pdf->setXY(7.7,24.4);
$pdf->MultiCell( 0.35  , 0.35 , iconv( 'UTF-8','cp874' , "" ),1,'L' );
//หมายเหตุ
$pdf->setXY(8.3,24.2);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "ต้องการให้เตรียมพรีมยืดไปซิวเก็บเตียงหรือที่นอนเก่า" ),0,'L' );

}

else if($want_prem=="1")
{

$pdf->Image("img/cor.jpeg",7.5,24.2,0.90,0.60);

$pdf->setXY(8.3,24.2);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "ต้องการให้เตรียมพรีมยืดไปซิวเก็บเตียงหรือที่นอนเก่า" ),0,'L' );

}


if($want_credit=="0")
{

$pdf->setXY(1.7,25.0);
$pdf->MultiCell( 0.35  , 0.35 , iconv( 'UTF-8','cp874' , "" ),1,'L' );
//หมายเหตุ
$pdf->setXY(2.1,24.8);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "ต้องเตรียมเครื่องรูดบัตร" ),0,'L' );

}

else if($want_credit=="1")
{

$pdf->Image("img/cor.jpeg",1.4,24.8,0.90,0.60);

$pdf->setXY(2.1,24.8);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "ต้องเตรียมเครื่องรูดบัตร" ),0,'L' );

}

$pdf->setXY( 7.5,24.8);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "ของธนาคาร :" ),0,'L' );

$pdf->setXY( 9.7,24.8);
$pdf->MultiCell( 10.5, 0.6 , iconv( 'UTF-8','cp874' , "$bank" ),0,'L' );

$pdf->setXY( 9.7,25.4);
$pdf->Cell(10.0,0,'','T',0,'C',0);


$pdf->setXY( 1.4,25.4);
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "เพิ่มเติม  :" ),0,'L' );

$pdf->setXY( 3.0,25.4);
$pdf->MultiCell(16.5, 0.6 , iconv( 'UTF-8','cp874' , "$description_tran" ),0,'L' );

$pdf->setXY( 3.0,26.0);
$pdf->Cell(16.7,0,'','T',0,'C',0);

$pdf->setXY( 3.0,26.6);
$pdf->Cell(16.7,0,'','T',0,'C',0);

if($employee_name!=="")
{

$pdf->AddPage();
$pdf->SetFont('angsana','B',18);


$pdf->setXY( 10.0, 1.0  );
$pdf->MultiCell( 9  , 0.6 , iconv( 'UTF-8','cp874' , "แผนที่"),0 ,'L' );



$pdf->Image("$employee_name",1.5,3.0,18.0,10.0,'png');	
}





$pdf->Output();
?>


