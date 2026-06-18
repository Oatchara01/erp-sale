<?php

define('FPDF_FONTPATH','font/');
require('fpdf1.php');
//require('ean13.php');
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


$start_date=$_GET["start_date"];
$end_date=$_GET["end_date"];
$company=$_GET["company"];
$doc_no="IE";
//print_vat
$pdf=new FPDF( 'P' , 'cm' , 'A4' );

include"dbconnect.php";

if($company =='3'){
	
$strSQL9 = "SELECT ref_id  FROM so__main  where bill_vat='1' and cancel_ckk ='0' and select_type_doc = '".$company."' and doc_no LIKE '%".$doc_no."%'";

if($start_date !=""){ 
    $strSQL9 .= ' AND doc_release_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL9 .= ' AND doc_release_date <= "'.$end_date.'"'; 
}
	
$strSQL9 .=" order  by doc_no DESC ";
$objQuery9 = mysqli_query($conn,$strSQL9) or die(mysqli_error());
	
while($objResult9 = mysqli_fetch_array($objQuery9))
{

$ref_id = $objResult9["ref_id"];
	
//echo	$ref_id;
	

$strSQL = "SELECT * FROM so__main  WHERE ref_id = '".$ref_id."' ";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);



$strSQL15 = "SELECT SUM(sum_amount) AS amount_1 FROM so__submain WHERE ref_idd = '".$ref_id."' ";
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResult15= mysqli_fetch_array($objQuery15);

$summary_1=$objResult15['amount_1'];
$summary= number_format( $summary_1,2)."";
$sum_vat1 =($summary_1/1.07);
$sum_vat= number_format( $sum_vat1,2)."";
$vat1 = ($sum_vat1 * 0.07);
$vat= number_format( $vat1,2)."";
$number_thai = Convert($summary_1);




$billing_name = $objResult["billing_name"];
$billing_address = $objResult["billing_address"];
//$doc_release_date = Datethai($objResult["doc_release_date"]);

$date = explode('-' , $objResult["doc_release_date"] );
$year = $date[0]+543;
$year1 = substr($year, 2 ,2);
$doc_release_date = $date[2].'/'.$date[1].'/'.$year1;

$employee_name = $objResult["employee_name"];
$order_id = $objResult["order_id"];
$doc_no = $objResult["doc_no"];
$tax_id = $objResult["tax_id"];
$send_supadm = $objResult["send_supadm"];
$send_sup = $objResult["send_sup"];
$send_cm = $objResult["send_cm"];
 $pre_name = $objResult["pre_name"];
	
$pdf->AddPage();
$pdf->AddFont('angsa','','angsa.php');
$pdf->AddFont('angsana','B','angsab.php');
$pdf->AddFont('times','','times.php');


$pdf->SetFont('angsa','',14);

$pdf->Image("img/Allwell1.png",0.9,0.5,2.3,3.0);
//$pdf->Image("img/ptl_select.png",0.5,0.5,3.0,2.3);	


$pdf->SetFont('angsana','B',20);

$pdf->setXY(4.5,0.5);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "บริษัท ออลล์เวล ไลฟ์ จำกัด"),0 ,'L' );

$pdf->setXY(4.5,1.1);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "ALLWELL LIFE CO., LTD."),0 ,'L' );

$pdf->setXY(4.5,1.7);
$pdf->Cell(7.0,0,'','T',0,'C',0);

$pdf->SetFont('angsana','B',18);

$pdf->setXY(12.8,0.5);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "ใบส่งสินค้า / ใบกำกับภาษี / ใบเสร็จรับเงิน"),0 ,'L' );
$pdf->SetFont('angsana','B',15);
$pdf->setXY(12.2,1.1);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "DELIVERY ORDER / TAX INVOICE / RECEIPT"),0 ,'L' );

$pdf->SetFont('angsa','',13);

$pdf->setXY(4.5,1.7);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "73, 75 ซอยจรัญสนิทวงศ์ 89/2 ถนนจรัญสนิทวงศ์ แขวงบางอ้อ"),0 ,'L' );

$pdf->setXY(4.5,2.1);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "เขตบางพลัด กรุงเทพมหานคร 10700"),0 ,'L' );


$pdf->setXY(4.5,2.5);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "เลขประจำตัวผู้เสียภาษี    0105541072483 (สำนักงานใหญ่)"),0 ,'L' );


$pdf->setXY(4.5,2.9);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "โทร. 0-2424-3555 (อัตโนมัติ) แฟ็กซ์. 0-2424-3322"),0 ,'L' );

$pdf->setXY(4.5,3.3);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "E-mail : online@allwelllifegroup.com"),0 ,'L' );

$pdf->setXY(4.5,3.7);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "www.allwellhealthcare.com"),0 ,'L' );




$pdf->setXY( 15.8,2.1);
$pdf->Cell(2.2,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',16);

$pdf->setXY(16.2,2.25);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "ต้นฉบับ"),0 ,'L' );

$pdf->setXY(16.0,2.7);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "ORIGINAL"),0 ,'L' );

$pdf->setXY(15.6,3.3);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "เอกสารออกเป็นชุด"),0 ,'L' );



$pdf->SetFont('angsa','',15);

$pdf->setXY(0.9,4.5);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "ลูกค้า"),0 ,'L' );

$pdf->setXY(0.9,5.0);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "$pre_name$billing_name"),0 ,'L' );

$pdf->setXY(0.9,5.5);
$pdf->MultiCell(9.0,0.5, iconv( 'UTF-8','cp874' , "$billing_address"),0 ,'L' );

$pdf->setXY(0.9,7.0);
$pdf->MultiCell(9.0,0.5, iconv( 'UTF-8','cp874' , "เลขประจำตัวผู้เสียภาษี"),0 ,'L' );

$pdf->setXY(4.5,7.0);
$pdf->MultiCell(9.0, 0.5 , iconv( 'UTF-8','cp874' , "$tax_id"),0 ,'L' );


$pdf->setXY(12.2,5.0);
$pdf->MultiCell(9.0, 0.5 , iconv( 'UTF-8','cp874' , "เลขที่"),0 ,'L' );

$pdf->setXY(14.5,5.0);
$pdf->MultiCell(9.0,0.5, iconv( 'UTF-8','cp874' , "$doc_no"),0 ,'L' );


$pdf->setXY(12.2,5.5);
$pdf->MultiCell(9.0, 0.5 , iconv( 'UTF-8','cp874' , "วันที่"),0 ,'L' );

$pdf->setXY(14.5,5.5);
$pdf->MultiCell(9.0,0.5, iconv( 'UTF-8','cp874' , "$doc_release_date"),0 ,'L' );


$pdf->setXY(12.2,6.0);
$pdf->MultiCell(9.0, 0.5 , iconv( 'UTF-8','cp874' , "ครบกำหนด"),0 ,'L' );

$pdf->setXY(14.5,6.0);
$pdf->MultiCell(9.0,0.5, iconv( 'UTF-8','cp874' , "$doc_release_date"),0 ,'L' );


$pdf->setXY(12.2,6.5);
$pdf->MultiCell(9.0, 0.5 , iconv( 'UTF-8','cp874' , "พนักงานขาย"),0 ,'L' );

$pdf->setXY(14.5,6.5);
$pdf->MultiCell(9.0,0.5, iconv( 'UTF-8','cp874' , "$employee_name"),0 ,'L' );


$pdf->setXY(12.2,7.0);
$pdf->MultiCell(9.0, 0.5 , iconv( 'UTF-8','cp874' , "ใบสั่งซื้อเลขที่"),0 ,'L' );

$pdf->setXY(14.5,7.0);
$pdf->MultiCell(9.0,0.5, iconv( 'UTF-8','cp874' , "$order_id"),0 ,'L' );

$pdf->setXY(0.6,7.75);
$pdf->Cell(19.8,0,'','T',0,'C',0);

$pdf->setXY(0.7,7.9);
$pdf->MultiCell( 90, 0.5 , iconv( 'UTF-8','cp874' , "#"),0 ,'L' );

$pdf->setXY(1.5,7.9);
$pdf->MultiCell( 9.0, 0.5 , iconv( 'UTF-8','cp874' , "รหัสสินค้า"),0 ,'L' );

$pdf->setXY(7.5,7.9);
$pdf->MultiCell( 9.0, 0.5 , iconv( 'UTF-8','cp874' , "รายละเอียด"),0 ,'L' );

$pdf->setXY(12.5,7.9);
$pdf->MultiCell( 9.0, 0.5 , iconv( 'UTF-8','cp874' , "จำนวน"),0 ,'L' );


$pdf->setXY(14.0,7.9);
$pdf->MultiCell( 9.0, 0.5 , iconv( 'UTF-8','cp874' , "ราคาต่อหน่วย"),0 ,'L' );


$pdf->setXY(16.7,7.9);
$pdf->MultiCell( 9.0, 0.5 , iconv( 'UTF-8','cp874' , "ส่วนลด"),0 ,'L' );


$pdf->setXY(19.0,7.9);
$pdf->MultiCell( 9.0, 0.5 , iconv( 'UTF-8','cp874' , "ยอดรวม"),0 ,'L' );

$pdf->setXY(0.6,8.5);
$pdf->Cell(19.8,0,'','T',0,'C',0);











$strSQL1 = "SELECT sum_amount,price_per_unit,access_name,sale_count,unit_name,access_code,discount_unit FROM (so__submain LEFT JOIN tb_product ON so__submain.product_ID=tb_product.product_id) WHERE ref_idd = '".$ref_id."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);



$i=1;
while($objResult1 = mysqli_fetch_array($objQuery1))
{

$sum_amount1  =$objResult1["sum_amount"];
$sum_amount= number_format( $sum_amount1,2)."";

$price_per_unit_1  =$objResult1["price_per_unit"];
$price_per_unit= number_format( $price_per_unit_1,2)."";
$discount_unit_1  =$objResult1["discount_unit"];
$discount_unit= number_format( $discount_unit_1,2)."";


$product_code1  =$objResult1["access_code"];
$product_code = substr($product_code1,0,10);
$product_name1  =$objResult1["access_name"];
$product_name = substr($product_name1,0,40);
$sale_count  =$objResult1["sale_count"];
$unit_name  =$objResult1["unit_name"];


$pdf->SetFont('angsa','',14);

$pdf->setX(18);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , ""),0 ,'R' );


$pdf->setX(0.5);
$pdf->MultiCell(0.5,0, iconv( 'UTF-8','cp874' , "$i"),0 ,'C' );


$pdf->setX(1.0);
$pdf->MultiCell(9.0,0, iconv( 'UTF-8','cp874' , "$product_code"),0 ,'L' );

//$pdf->Code128(26,0,$product_code,25,8);



$pdf->setX(4.0);
$pdf->MultiCell(9.0,0, iconv( 'UTF-8','cp874' , "$product_name"),0 ,'L' );

$pdf->setX(11.6);
$pdf->MultiCell(2.0,0, iconv( 'UTF-8','cp874' , "$sale_count $unit_name"),0 ,'R' );


$pdf->setX(13.75);
$pdf->MultiCell(2.2,0, iconv( 'UTF-8','cp874' , "$price_per_unit"),0 ,'R' );

$pdf->setX(16.3);
$pdf->MultiCell(1.5,0, iconv( 'UTF-8','cp874' , "$discount_unit"),0 ,'R' );



$pdf->setX(17.65);
$pdf->MultiCell( 2.5,0, iconv( 'UTF-8','cp874' , "$sum_amount"),0 ,'R' );

$pdf->setX(17.5);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , ""),0 ,'R' );


$pdf->setX(0.6);
$pdf->Cell(19.8,0,'','T',0,'C',0);


$i++;


}


$pdf->setX(17.5);
$pdf->MultiCell(9.0,1.5, iconv( 'UTF-8','cp874' , ""),0 ,'R' );
$pdf->SetFont('angsa','',16);

$pdf->setX(13.0);
$pdf->MultiCell( 3.0,0, iconv( 'UTF-8','cp874' , "รวมเงิน"),0 ,'R' );


$pdf->setX(17.0);
$pdf->MultiCell(2.5,0, iconv( 'UTF-8','cp874' , "$sum_vat"),0 ,'R' );

$pdf->setX(17.8);
$pdf->MultiCell(2.5,0, iconv( 'UTF-8','cp874' , "บาท"),0 ,'R' );

$pdf->setX(17.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , ""),0 ,'R' );

$pdf->setX(13.0);
$pdf->MultiCell( 3.0,0, iconv( 'UTF-8','cp874' , "ภาษีมูลค่าเพิ่ม"),0 ,'R' );


$pdf->setX(17.0);
$pdf->MultiCell(2.5,0, iconv( 'UTF-8','cp874' , "$vat"),0 ,'R' );

$pdf->setX(17.8);
$pdf->MultiCell(2.5,0, iconv( 'UTF-8','cp874' , "บาท"),0 ,'R' );

$pdf->setX(17.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , ""),0 ,'R' );

$pdf->setX(13.0);
$pdf->MultiCell( 3.0,0, iconv( 'UTF-8','cp874' , "ยอดเงินสุทธิ"),0 ,'R' );


$pdf->setX(17.0);
$pdf->MultiCell(2.5,0, iconv( 'UTF-8','cp874' , "$summary"),0 ,'R' );

$pdf->setX(17.8);
$pdf->MultiCell(2.5,0, iconv( 'UTF-8','cp874' , "บาท"),0 ,'R' );

$pdf->setX(1.5);
$pdf->MultiCell( 9.0,0, iconv( 'UTF-8','cp874' , "($number_thai)."),0 ,'L' );







$pdf->SetFont('angsa','',16);

$pdf->setXY(0.6,23.4);
$pdf->MultiCell(11,1.0, iconv( 'UTF-8','cp874' , "การชำระเงินจะสมบูรณ์ เมื่อบริษัทได้รับเงินเรียบร้อยแล้ว"),0 ,'L' );
$pdf->SetFont('angsa','',14);

$pdf->setXY(0.6,25.0);
$pdf->MultiCell(11,1.0, iconv( 'UTF-8','cp874' , "ได้รับสินค้าตามรายการข้างบนนี้ ในสภาพเรียบร้อย และถูกต้องแล้ว"),0 ,'L' );

$pdf->setXY(0.6,26.0);
$pdf->MultiCell(11,1.0, iconv( 'UTF-8','cp874' , "รับของโดย"),0 ,'L' );

$pdf->setXY(5.7,26.0);
$pdf->MultiCell(11,1.0, iconv( 'UTF-8','cp874' , "วันที่"),0 ,'L' );



$pdf->setXY(0.6,26.3);
$pdf->MultiCell(11,1.0, iconv( 'UTF-8','cp874' , "Received By......................................... Date......../........./........"),0 ,'L' );



$pdf->SetFont('angsa','',14);


$pdf->setXY(8.6,26.0);
$pdf->MultiCell(11,1.0, iconv( 'UTF-8','cp874' , "ออกเอกสารโดย"),0 ,'L' );

$pdf->setXY(8.6,26.3);
$pdf->MultiCell(11,1.0, iconv( 'UTF-8','cp874' , "Prepared By.................................."),0 ,'L' );

$pdf->Image("img/chompoo.png",11.0,26.2,1.5,0.8);
//$pdf->Image("img/hem.jpg",11.0,26.0,1.5,0.8);


$pdf->SetFont('angsa','',14);

$pdf->setXY(12.7,24.4);
$pdf->MultiCell(11,1.0, iconv( 'UTF-8','cp874' , "ในนาม"),0 ,'L' );
$pdf->setXY(12.7,24.8);
$pdf->MultiCell(11,1.0, iconv( 'UTF-8','cp874' , "For"),0 ,'L' );

$pdf->setXY(13.3,26.3);
$pdf->MultiCell(11,1.0, iconv( 'UTF-8','cp874' , ".................................................."),0 ,'L' );



$pdf->SetFont('angsana','B',14);

$pdf->setXY(13.7,24.4);
$pdf->MultiCell(11,1.0, iconv( 'UTF-8','cp874' , "บริษัท ออลล์เวล ไลฟ์ จำกัด"),0 ,'L' );

$pdf->setXY(13.7,24.8);
$pdf->MultiCell(11,1.0, iconv( 'UTF-8','cp874' , "ALLWELL LIFE CO., LTD"),0 ,'L' );


$pdf->setXY(14.3,27.0);
$pdf->MultiCell(11,1.0, iconv( 'UTF-8','cp874' , "ผู้มีอำนาจลงนาม"),0 ,'L' );

$pdf->setXY(13.9,27.4);
$pdf->MultiCell(11,1.0, iconv( 'UTF-8','cp874' , "Authorized Signature"),0 ,'L' );


$pdf->Image("img/ptl_square.png",13.5,25.6,4.0,2.0);

if($send_cm =='1'){
	
}else if($send_sup =='1'){
$pdf->Image("img/piya_ptl.png",14.0,25.6,3.0,1.5);
}else if($send_supadm =='1'){
//$pdf->Image("img/bow_ptl.png",15.0,25.9,2.0,1.0);
//$pdf->Image("img/piya_ptl.png",14.0,25.6,3.0,1.5);
$pdf->Image("img/yipun.png",14.3,25.3,3.0,1.5);
}


$pdf->setXY(18.5,26.9);
$pdf->Cell(2.0,0.8, "",1,1,"c" );

$pdf->SetFont('angsana','B',16);

$pdf->setXY(19.0,26.8);
$pdf->MultiCell(5.0,1.0, iconv( 'UTF-8','cp874' , "บริษัท"),0 ,'L' );


$pdf->SetFont('angsa','',12);
$pdf->setXY(0.5,27.0);
$pdf->MultiCell(5.0,1.0, iconv( 'UTF-8','cp874' , "ผิด ตก ยกเว้น E.&O.E"),0 ,'L' );

$pdf->setXY(0.5,27.4);
$pdf->MultiCell(5.0,1.0, iconv( 'UTF-8','cp874' , "อนุมัติวันที่ 25 พ.ค. 2563"),0 ,'L' );

$pdf->setXY(18.0,27.4);
$pdf->MultiCell(2.5,1.0, iconv( 'UTF-8','cp874' , "FM-SA-40:REV.0"),0 ,'R' );
	
	
$pdf->SetTextColor(0,0,255);
$pdf->setXY(0.6,27.95);
$pdf->MultiCell(15,1.0, iconv( 'UTF-8','cp874' , "** บริษัทฯ ขอสงวนสิทธิ์ที่จะแก้ไขหรือเปลี่ยนแปลงข้อมูลใบกำกับภาษีไม่เกินวันที่ 10 ของเดือนถัดไป **"),0 ,'L' );
	
$pdf->SetTextColor(0,0,0);	
	
}
	
	

	
}else if($company =='4'){ 
	
$strSQL9 = "SELECT ref_id  FROM so__main  where bill_vat='1' and cancel_ckk ='0' and select_type_doc = '".$company."' and doc_no LIKE '%".$doc_no."%'";

if($start_date !=""){ 
    $strSQL9 .= ' AND doc_release_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL9 .= ' AND doc_release_date <= "'.$end_date.'"'; 
}


$strSQL9 .=" order  by doc_no DESC ";
$objQuery9 = mysqli_query($conn,$strSQL9) or die(mysqli_error());
while($objResult9 = mysqli_fetch_array($objQuery9))
{

$ref_id = $objResult9["ref_id"];
	
//echo	$ref_id;
	

$strSQL = "SELECT * FROM so__main  WHERE ref_id = '".$ref_id."' ";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);



$strSQL = "SELECT * FROM so__main  WHERE ref_id = '".$ref_id."' ";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);

$strSQL15 = "SELECT SUM(sum_amount) AS amount_1 FROM so__submain WHERE ref_idd = '".$ref_id."' ";
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResult15= mysqli_fetch_array($objQuery15);

$summary_1=$objResult15['amount_1'];
$summary= number_format( $summary_1,2)."";
$sum_vat1 =($summary_1/1.07);
$sum_vat= number_format( $sum_vat1,2)."";
$vat1 = ($sum_vat1 * 0.07);
$vat= number_format( $vat1,2)."";
$number_thai = Convert($summary_1);




$billing_name = $objResult["billing_name"];
$billing_address = $objResult["billing_address"];
//$doc_release_date = Datethai($objResult["doc_release_date"]);

$date = explode('-' , $objResult["doc_release_date"] );
$year = $date[0]+543;
$year1 = substr($year, 2 ,2);
$doc_release_date = $date[2].'/'.$date[1].'/'.$year1;

$employee_name = $objResult["employee_name"];
$order_id = $objResult["order_id"];
$doc_no = $objResult["doc_no"];
$tax_id = $objResult["tax_id"];
$send_supadm = $objResult["send_supadm"];
$send_sup = $objResult["send_sup"];
$send_cm = $objResult["send_cm"];
$pre_name  = $objResult["pre_name"];
	
$pdf->AddPage();
$pdf->AddFont('angsa','','angsa.php');
$pdf->AddFont('angsana','B','angsab.php');
$pdf->AddFont('times','','times.php');


$pdf->SetFont('angsa','',14);

$pdf->Image("img/nbm_select.png",0.5,0.5,3.5,1.5);


$pdf->SetFont('angsana','B',20);

$pdf->setXY(4.5,0.5);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "บริษัท โนเบิล เมด จำกัด"),0 ,'L' );

$pdf->setXY(4.5,1.1);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "NOBLE MED CO., LTD."),0 ,'L' );

$pdf->setXY(4.5,1.7);
$pdf->Cell(7.0,0,'','T',0,'C',0);

$pdf->SetFont('angsana','B',18);

$pdf->setXY(12.8,0.5);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "ใบส่งสินค้า / ใบกำกับภาษี / ใบเสร็จรับเงิน"),0 ,'L' );
$pdf->SetFont('angsana','B',15);
$pdf->setXY(12.2,1.1);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "DELIVERY ORDER / TAX INVOICE / RECEIPT"),0 ,'L' );

$pdf->SetFont('angsa','',13);

$pdf->setXY(4.5,1.7);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "73 ซอยจรัญสนิทวงศ์ 89/2 แขวงบางอ้อ เขตบางพลัด "),0 ,'L' );

$pdf->setXY(4.5,2.1);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "กรุงเทพมหานคร 10700"),0 ,'L' );


$pdf->setXY(4.5,2.5);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "เลขประจำตัวผู้เสียภาษี    0105552125923 (สำนักงานใหญ่)"),0 ,'L' );


$pdf->setXY(4.5,2.9);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "โทร. 0-2880-5566 แฟ็กซ์. 0-2880-5533"),0 ,'L' );





$pdf->setXY( 15.8,2.1);
$pdf->Cell(2.2,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',16);

$pdf->setXY(16.2,2.25);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "ต้นฉบับ"),0 ,'L' );

$pdf->setXY(16.0,2.7);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "ORIGINAL"),0 ,'L' );

$pdf->setXY(15.6,3.3);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "เอกสารออกเป็นชุด"),0 ,'L' );



$pdf->SetFont('angsa','',15);

$pdf->setXY(0.9,4.5);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "ลูกค้า"),0 ,'L' );

$pdf->setXY(0.9,5.0);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "$pre_name$billing_name"),0 ,'L' );

$pdf->setXY(0.9,5.5);
$pdf->MultiCell(9.0,0.5, iconv( 'UTF-8','cp874' , "$billing_address"),0 ,'L' );

$pdf->setXY(0.9,7.0);
$pdf->MultiCell(9.0,0.5, iconv( 'UTF-8','cp874' , "เลขประจำตัวผู้เสียภาษี"),0 ,'L' );

$pdf->setXY(4.5,7.0);
$pdf->MultiCell(9.0, 0.5 , iconv( 'UTF-8','cp874' , "$tax_id"),0 ,'L' );


$pdf->setXY(12.2,5.0);
$pdf->MultiCell(9.0, 0.5 , iconv( 'UTF-8','cp874' , "เลขที่"),0 ,'L' );

$pdf->setXY(14.5,5.0);
$pdf->MultiCell(9.0,0.5, iconv( 'UTF-8','cp874' , "$doc_no"),0 ,'L' );


$pdf->setXY(12.2,5.5);
$pdf->MultiCell(9.0, 0.5 , iconv( 'UTF-8','cp874' , "วันที่"),0 ,'L' );

$pdf->setXY(14.5,5.5);
$pdf->MultiCell(9.0,0.5, iconv( 'UTF-8','cp874' , "$doc_release_date"),0 ,'L' );


$pdf->setXY(12.2,6.0);
$pdf->MultiCell(9.0, 0.5 , iconv( 'UTF-8','cp874' , "ครบกำหนด"),0 ,'L' );

$pdf->setXY(14.5,6.0);
$pdf->MultiCell(9.0,0.5, iconv( 'UTF-8','cp874' , "$doc_release_date"),0 ,'L' );


$pdf->setXY(12.2,6.5);
$pdf->MultiCell(9.0, 0.5 , iconv( 'UTF-8','cp874' , "พนักงานขาย"),0 ,'L' );

$pdf->setXY(14.5,6.5);
$pdf->MultiCell(9.0,0.5, iconv( 'UTF-8','cp874' , "$employee_name"),0 ,'L' );


$pdf->setXY(12.2,7.0);
$pdf->MultiCell(9.0, 0.5 , iconv( 'UTF-8','cp874' , "ใบสั่งซื้อเลขที่"),0 ,'L' );

$pdf->setXY(14.5,7.0);
$pdf->MultiCell(9.0,0.5, iconv( 'UTF-8','cp874' , "$order_id"),0 ,'L' );

$pdf->setXY(0.6,7.75);
$pdf->Cell(19.8,0,'','T',0,'C',0);

$pdf->setXY(0.7,7.9);
$pdf->MultiCell( 90, 0.5 , iconv( 'UTF-8','cp874' , "#"),0 ,'L' );

$pdf->setXY(1.5,7.9);
$pdf->MultiCell( 9.0, 0.5 , iconv( 'UTF-8','cp874' , "รหัสสินค้า"),0 ,'L' );

$pdf->setXY(7.5,7.9);
$pdf->MultiCell( 9.0, 0.5 , iconv( 'UTF-8','cp874' , "รายละเอียด"),0 ,'L' );

$pdf->setXY(12.5,7.9);
$pdf->MultiCell( 9.0, 0.5 , iconv( 'UTF-8','cp874' , "จำนวน"),0 ,'L' );


$pdf->setXY(14.0,7.9);
$pdf->MultiCell( 9.0, 0.5 , iconv( 'UTF-8','cp874' , "ราคาต่อหน่วย"),0 ,'L' );


$pdf->setXY(16.7,7.9);
$pdf->MultiCell( 9.0, 0.5 , iconv( 'UTF-8','cp874' , "ส่วนลด"),0 ,'L' );


$pdf->setXY(19.0,7.9);
$pdf->MultiCell( 9.0, 0.5 , iconv( 'UTF-8','cp874' , "ยอดรวม"),0 ,'L' );

$pdf->setXY(0.6,8.5);
$pdf->Cell(19.8,0,'','T',0,'C',0);


$strSQL1 = "SELECT sum_amount,price_per_unit,access_name,sale_count,unit_name,access_code,discount_unit,sale_remark FROM (so__submain LEFT JOIN tb_product ON so__submain.product_ID=tb_product.product_id) WHERE ref_idd = '".$ref_id."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);



$i=1;
while($objResult1 = mysqli_fetch_array($objQuery1))
{

$sum_amount1  =$objResult1["sum_amount"];
$sum_amount= number_format( $sum_amount1,2)."";

$price_per_unit_1  =$objResult1["price_per_unit"];
$price_per_unit= number_format( $price_per_unit_1,2)."";
$discount_unit_1  =$objResult1["discount_unit"];
$discount_unit= number_format( $discount_unit_1,2)."";


$product_code1  =$objResult1["access_code"];
$product_code = substr($product_code1,0,10);
$product_name1  =$objResult1["access_name"];
$product_name = substr($product_name1,0,40);
$sale_count  =$objResult1["sale_count"];
$unit_name  =$objResult1["unit_name"];
$sale_remark =$objResult1["sale_remark"];

$pdf->SetFont('angsa','',14);

$pdf->setX(18);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , ""),0 ,'R' );


$pdf->setX(0.5);
$pdf->MultiCell(0.5,0, iconv( 'UTF-8','cp874' , "$i"),0 ,'C' );


$pdf->setX(1.0);
$pdf->MultiCell(9.0,0, iconv( 'UTF-8','cp874' , "$product_code"),0 ,'L' );

//$pdf->Code128(26,0,$product_code,25,8);



$pdf->setX(4.0);
$pdf->MultiCell(9.0,0, iconv( 'UTF-8','cp874' , "$product_name"),0 ,'L' );
	


$pdf->setX(11.6);
$pdf->MultiCell(2.0,0, iconv( 'UTF-8','cp874' , "$sale_count $unit_name"),0 ,'R' );


$pdf->setX(13.75);
$pdf->MultiCell(2.2,0, iconv( 'UTF-8','cp874' , "$price_per_unit"),0 ,'R' );

$pdf->setX(16.3);
$pdf->MultiCell(1.5,0, iconv( 'UTF-8','cp874' , "$discount_unit"),0 ,'R' );



$pdf->setX(17.65);
$pdf->MultiCell( 2.5,0, iconv( 'UTF-8','cp874' , "$sum_amount"),0 ,'R' );

$pdf->setX(17.5);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , ""),0 ,'R' );


$pdf->setX(0.6);
$pdf->Cell(19.8,0,'','T',0,'C',0);


$i++;


}


$pdf->setX(17.5);
$pdf->MultiCell(9.0,1.5, iconv( 'UTF-8','cp874' , ""),0 ,'R' );
$pdf->SetFont('angsa','',16);

$pdf->setX(13.0);
$pdf->MultiCell( 3.0,0, iconv( 'UTF-8','cp874' , "รวมเงิน"),0 ,'R' );


$pdf->setX(17.0);
$pdf->MultiCell(2.5,0, iconv( 'UTF-8','cp874' , "$sum_vat"),0 ,'R' );

$pdf->setX(17.8);
$pdf->MultiCell(2.5,0, iconv( 'UTF-8','cp874' , "บาท"),0 ,'R' );

$pdf->setX(17.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , ""),0 ,'R' );

$pdf->setX(13.0);
$pdf->MultiCell( 3.0,0, iconv( 'UTF-8','cp874' , "ภาษีมูลค่าเพิ่ม"),0 ,'R' );


$pdf->setX(17.0);
$pdf->MultiCell(2.5,0, iconv( 'UTF-8','cp874' , "$vat"),0 ,'R' );

$pdf->setX(17.8);
$pdf->MultiCell(2.5,0, iconv( 'UTF-8','cp874' , "บาท"),0 ,'R' );

$pdf->setX(17.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , ""),0 ,'R' );

$pdf->setX(13.0);
$pdf->MultiCell( 3.0,0, iconv( 'UTF-8','cp874' , "ยอดเงินสุทธิ"),0 ,'R' );


$pdf->setX(17.0);
$pdf->MultiCell(2.5,0, iconv( 'UTF-8','cp874' , "$summary"),0 ,'R' );

$pdf->setX(17.8);
$pdf->MultiCell(2.5,0, iconv( 'UTF-8','cp874' , "บาท"),0 ,'R' );

$pdf->setX(1.5);
$pdf->MultiCell( 9.0,0, iconv( 'UTF-8','cp874' , "($number_thai)."),0 ,'L' );







$pdf->SetFont('angsa','',16);

$pdf->setXY(0.6,23.4);
$pdf->MultiCell(11,1.0, iconv( 'UTF-8','cp874' , "การชำระเงินจะสมบูรณ์ เมื่อบริษัทได้รับเงินเรียบร้อยแล้ว"),0 ,'L' );
$pdf->SetFont('angsa','',14);

$pdf->setXY(0.6,25.0);
$pdf->MultiCell(11,1.0, iconv( 'UTF-8','cp874' , "ได้รับสินค้าตามรายการข้างบนนี้ ในสภาพเรียบร้อย และถูกต้องแล้ว"),0 ,'L' );

$pdf->setXY(0.6,26.0);
$pdf->MultiCell(11,1.0, iconv( 'UTF-8','cp874' , "รับของโดย"),0 ,'L' );

$pdf->setXY(5.7,26.0);
$pdf->MultiCell(11,1.0, iconv( 'UTF-8','cp874' , "วันที่"),0 ,'L' );



$pdf->setXY(0.6,26.3);
$pdf->MultiCell(11,1.0, iconv( 'UTF-8','cp874' , "Received By......................................... Date......../........./........"),0 ,'L' );



$pdf->SetFont('angsa','',14);


$pdf->setXY(8.6,26.0);
$pdf->MultiCell(11,1.0, iconv( 'UTF-8','cp874' , "ออกเอกสารโดย"),0 ,'L' );

$pdf->setXY(8.6,26.3);
$pdf->MultiCell(11,1.0, iconv( 'UTF-8','cp874' , "Prepared By.................................."),0 ,'L' );

$pdf->Image("img/chompoo.png",11.0,26.2,1.5,0.8);
//$pdf->Image("img/hem.jpg",11.0,26.0,1.5,0.8);


$pdf->SetFont('angsa','',14);

$pdf->setXY(12.7,24.4);
$pdf->MultiCell(11,1.0, iconv( 'UTF-8','cp874' , "ในนาม"),0 ,'L' );
$pdf->setXY(12.7,24.8);
$pdf->MultiCell(11,1.0, iconv( 'UTF-8','cp874' , "For"),0 ,'L' );

$pdf->setXY(13.3,26.3);
$pdf->MultiCell(11,1.0, iconv( 'UTF-8','cp874' , ".................................................."),0 ,'L' );



$pdf->SetFont('angsana','B',14);

$pdf->setXY(13.7,24.4);
$pdf->MultiCell(11,1.0, iconv( 'UTF-8','cp874' , "บริษัท โนเบิล เมดจำกัด"),0 ,'L' );

$pdf->setXY(13.7,24.8);
$pdf->MultiCell(11,1.0, iconv( 'UTF-8','cp874' , "NOBLE MED CO., LTD"),0 ,'L' );


$pdf->setXY(14.3,27.0);
$pdf->MultiCell(11,1.0, iconv( 'UTF-8','cp874' , "ผู้มีอำนาจลงนาม"),0 ,'L' );

$pdf->setXY(13.9,27.4);
$pdf->MultiCell(11,1.0, iconv( 'UTF-8','cp874' , "Authorized Signature"),0 ,'L' );


$pdf->Image("img/nbm_oval.png",13.5,25.6,4.0,2.0);

if($send_cm =='1'){
	
}else if($send_sup =='1'){
$pdf->Image("img/piya_nbm.png",14.0,25.6,3.0,1.5);
}else if($send_supadm =='1'){
//$pdf->Image("img/bow_nbm.png",15.0,25.9,2.0,1.0);
//$pdf->Image("img/piya_ptl.png",14.0,25.6,3.0,1.5);
$pdf->Image("img/yipun.png",13.8,25.2,3.0,1.5);
}


$pdf->setXY(18.5,26.9);
$pdf->Cell(2.0,0.8, "",1,1,"c" );

$pdf->SetFont('angsana','B',16);
$pdf->setXY(19.0,26.8);
$pdf->MultiCell(5.0,1.0, iconv( 'UTF-8','cp874' , "บริษัท"),0 ,'L' );	


$pdf->SetFont('angsa','',12);
$pdf->setXY(0.5,27.0);
$pdf->MultiCell(5.0,1.0, iconv( 'UTF-8','cp874' , "ผิด ตก ยกเว้น E.&O.E"),0 ,'L' );

$pdf->setXY(0.5,27.4);
$pdf->MultiCell(5.0,1.0, iconv( 'UTF-8','cp874' , "อนุมัติวันที่ 25 พ.ค. 2563"),0 ,'L' );

$pdf->setXY(18.0,27.4);
$pdf->MultiCell(2.5,1.0, iconv( 'UTF-8','cp874' , "FM-SA-40:REV.0"),0 ,'R' );
	
$pdf->SetTextColor(0,0,255);
$pdf->setXY(0.6,27.95);
$pdf->MultiCell(15,1.0, iconv( 'UTF-8','cp874' , "** บริษัทฯ ขอสงวนสิทธิ์ที่จะแก้ไขหรือเปลี่ยนแปลงข้อมูลใบกำกับภาษีไม่เกินวันที่ 10 ของเดือนถัดไป **"),0 ,'L' );
$pdf->SetTextColor(0,0,0);	

}
	
}

$strSQL9 = "SELECT ref_id  FROM hos__so  where status_doc='Approve' and type_doc = '".$company."' and iv_no LIKE '%IE%'";

if($start_date !=""){ 
    $strSQL9 .= ' AND iv_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL9 .= ' AND iv_date <= "'.$end_date.'"'; 
}

$strSQL9 .=" order  by iv_no DESC ";
$objQuery9 = mysqli_query($conn,$strSQL9) or die(mysqli_error());
	
while($objResult9 = mysqli_fetch_array($objQuery9))
{

$ref_id = $objResult9["ref_id"];

	
$strSQL = "SELECT * FROM hos__so  WHERE  ref_id ='".$ref_id."'";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);	

$ref_id = $objResult["ref_id"];
$new_bill =  $objResult["new_bill"];
$desnew_bill =  $objResult["desnew_bill"];

if($new_bill=='0'){
$doc_no = $objResult["iv_no"];
}else{
$doc_no1 = $objResult["iv_no"];
$pp = "_0";
$doc_no = $doc_no1.$pp.$new_bill;	
	
}

$dateod = explode('-' , $objResult["date_oldbill"] );
$yearod = $dateod[0]+543;
$year1od = substr($yearod, 2 ,2);
$doc_release_dateod = $dateod[2].'/'.$dateod[1].'/'.$year1od;


$strSQL15 = "SELECT SUM(amount) AS amount_1 FROM hos__subso WHERE ref_idd = '".$ref_id."' ";
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResult15= mysqli_fetch_array($objQuery15);

$summary_1=$objResult15['amount_1'];
$summary= number_format( $summary_1,2)."";
$sum_vat1 =($summary_1/1.07);
$sum_vat= number_format( $sum_vat1,2)."";
$vat1 = ($sum_vat1 * 0.07);
$vat= number_format( $vat1,2)."";
$number_thai = Convert($summary_1);


$billing_name = $objResult["bill_name"];
$billing_address = $objResult["bill_address"];
$preface_name = "";

$date = explode('-' , $objResult["iv_date"] );
$year = $date[0]+543;
$year1 = substr($year, 2 ,2);
$doc_release_date = $date[2].'/'.$date[1].'/'.$year1;

$employee_name = $objResult["sale_code"];
$order_id = $objResult["po_no"];
//$doc_no = $objResult["iv_no"];
$tax_id = $objResult["tax_id"];
$select_type_doc  =$objResult["type_doc"];



//$pdf=new FPDF( 'P' , 'cm' , 'A4' );



/////////////////////////

$pdf->AddPage();
$pdf->AddFont('angsa','','angsa.php');
$pdf->AddFont('angsana','B','angsab.php');
$pdf->AddFont('times','','times.php');


$pdf->SetFont('angsa','',14);



$pdf->SetFont('angsana','B',20);

if($select_type_doc=='3'){
	
$pdf->Image("img/allwell_2307.png",0.9,0.5,2.3,3.0);
	
$pdf->setXY(4.5,0.5);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "บริษัท ออลล์เวล ไลฟ์ จำกัด"),0 ,'L' );

$pdf->setXY(4.5,1.1);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "ALLWELL LIFE CO., LTD."),0 ,'L' );

$pdf->setXY(4.5,1.7);
$pdf->Cell(7.0,0,'','T',0,'C',0);
	
	
$pdf->SetFont('angsa','',13);

$pdf->setXY(4.5,1.7);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "73, 75 ซอยจรัญสนิทวงศ์ 89/2 ถนนจรัญสนิทวงศ์ แขวงบางอ้อ"),0 ,'L' );

$pdf->setXY(4.5,2.1);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "เขตบางพลัด กรุงเทพมหานคร 10700"),0 ,'L' );


$pdf->setXY(4.5,2.5);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "เลขประจำตัวผู้เสียภาษี    0105541072483 (สำนักงานใหญ่)"),0 ,'L' );


$pdf->setXY(4.5,2.9);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "โทร. 0-2424-3555 (อัตโนมัติ) แฟ็กซ์. 0-2424-3322"),0 ,'L' );

$pdf->setXY(4.5,3.3);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "E-mail : Sales@AllwellLifeGroup.com"),0 ,'L' );

$pdf->setXY(4.5,3.7);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "www.allwellhealthcare.com"),0 ,'L' );

}else if($select_type_doc=='4'){
	
$pdf->Image("img/nbm_select.png",0.5,0.5,3.5,1.5);

$pdf->SetFont('angsana','B',20);

$pdf->setXY(4.5,0.5);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "บริษัท โนเบิล เมด จำกัด"),0 ,'L' );

$pdf->setXY(4.5,1.1);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "NOBLE MED CO., LTD."),0 ,'L' );

$pdf->setXY(4.5,1.7);
$pdf->Cell(7.0,0,'','T',0,'C',0);

$pdf->SetFont('angsa','',13);

$pdf->setXY(4.5,1.7);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "73 ซอยจรัญสนิทวงศ์ 89/2 แขวงบางอ้อ เขตบางพลัด "),0 ,'L' );

$pdf->setXY(4.5,2.1);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "กรุงเทพมหานคร 10700"),0 ,'L' );


$pdf->setXY(4.5,2.5);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "เลขประจำตัวผู้เสียภาษี    0105552125923 (สำนักงานใหญ่)"),0 ,'L' );


$pdf->setXY(4.5,2.9);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "โทร. 0-2880-5566 แฟ็กซ์. 0-2880-5533"),0 ,'L' );

	
	
	
}	
	
	
	
	
	
	

$pdf->SetFont('angsana','B',18);

$pdf->setXY(12.8,0.5);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "ใบส่งสินค้า / ใบกำกับภาษี / ใบเสร็จรับเงิน"),0 ,'L' );
$pdf->SetFont('angsana','B',15);
$pdf->setXY(12.2,1.1);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "DELIVERY ORDER / TAX INVOICE / RECEIPT"),0 ,'L' );





/*$pdf->setXY( 15.8,2.1);
$pdf->Cell(2.2,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',16);

$pdf->setXY(16.2,2.25);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "ต้นฉบับ"),0 ,'L' );

$pdf->setXY(16.0,2.7);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "ORIGINAL"),0 ,'L' );

$pdf->setXY(15.6,3.3);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "เอกสารออกเป็นชุด"),0 ,'L' );*/



$pdf->SetFont('angsa','',15);

$pdf->setXY(0.9,4.5);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "ลูกค้า"),0 ,'L' );

$pdf->setXY(0.9,5.0);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8//IGNORE','cp874//IGNORE' , "$preface_name$billing_name"),0 ,'L' );

$pdf->setXY(0.9,5.5);
$pdf->MultiCell(9.0,0.5, iconv( 'UTF-8//IGNORE','cp874//IGNORE' , "$billing_address"),0 ,'L' );

$pdf->setXY(0.9,7.0);
$pdf->MultiCell(9.0,0.5, iconv( 'UTF-8','cp874' , "เลขประจำตัวผู้เสียภาษี"),0 ,'L' );

$pdf->setXY(4.5,7.0);
$pdf->MultiCell(9.0, 0.5 , iconv( 'UTF-8','cp874' , "$tax_id"),0 ,'L' );


$pdf->setXY(12.2,5.0);
$pdf->MultiCell(9.0, 0.5 , iconv( 'UTF-8','cp874' , "เลขที่"),0 ,'L' );

$pdf->setXY(15.5,5.0);
$pdf->MultiCell(9.0,0.5, iconv( 'UTF-8','cp874' , "$doc_no"),0 ,'L' );


$pdf->setXY(12.2,5.5);
$pdf->MultiCell(9.0, 0.5 , iconv( 'UTF-8','cp874' , "วันที่"),0 ,'L' );

$pdf->setXY(15.5,5.5);
$pdf->MultiCell(9.0,0.5, iconv( 'UTF-8','cp874' , "$doc_release_date"),0 ,'L' );


$pdf->setXY(12.2,6.0);
$pdf->MultiCell(9.0, 0.5 , iconv( 'UTF-8','cp874' , "ครบกำหนดชำระเงิน"),0 ,'L' );

$pdf->setXY(15.5,6.0);
$pdf->MultiCell(9.0,0.5, iconv( 'UTF-8','cp874' , "$doc_release_date"),0 ,'L' );


$pdf->setXY(12.2,6.5);
$pdf->MultiCell(9.0, 0.5 , iconv( 'UTF-8','cp874' , "พนักงานขาย"),0 ,'L' );

$pdf->setXY(15.5,6.5);
$pdf->MultiCell(9.0,0.5, iconv( 'UTF-8','cp874' , "$employee_name"),0 ,'L' );


$pdf->setXY(12.2,7.0);
$pdf->MultiCell(9.0, 0.5 , iconv( 'UTF-8','cp874' , "ใบสั่งซื้อเลขที่"),0 ,'L' );

$pdf->setXY(15.5,7.0);
$pdf->MultiCell(9.0,0.5, iconv( 'UTF-8','cp874' , "$order_id"),0 ,'L' );

$pdf->setXY(0.6,7.75);
$pdf->Cell(19.8,0,'','T',0,'C',0);

$pdf->setXY(0.7,7.9);
$pdf->MultiCell( 90, 0.5 , iconv( 'UTF-8','cp874' , "#"),0 ,'L' );

$pdf->setXY(1.5,7.9);
$pdf->MultiCell( 9.0, 0.5 , iconv( 'UTF-8','cp874' , "รหัสสินค้า"),0 ,'L' );

$pdf->setXY(7.5,7.9);
$pdf->MultiCell( 9.0, 0.5 , iconv( 'UTF-8','cp874' , "รายละเอียด"),0 ,'L' );

$pdf->setXY(12.5,7.9);
$pdf->MultiCell( 9.0, 0.5 , iconv( 'UTF-8','cp874' , "จำนวน"),0 ,'L' );


$pdf->setXY(14.0,7.9);
$pdf->MultiCell( 9.0, 0.5 , iconv( 'UTF-8','cp874' , "ราคาต่อหน่วย"),0 ,'L' );


$pdf->setXY(16.7,7.9);
$pdf->MultiCell( 9.0, 0.5 , iconv( 'UTF-8','cp874' , "ส่วนลด"),0 ,'L' );


$pdf->setXY(19.0,7.9);
$pdf->MultiCell( 9.0, 0.5 , iconv( 'UTF-8','cp874' , "ยอดรวม"),0 ,'L' );

$pdf->setXY(0.6,8.5);
$pdf->Cell(19.8,0,'','T',0,'C',0);











$strSQL1 = "SELECT amount,price,access_name,count,unit_name,access_code,discount FROM (hos__subso LEFT JOIN tb_product ON hos__subso.product_ID=tb_product.product_id) WHERE ref_idd = '".$ref_id."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);



$i=1;
while($objResult1 = mysqli_fetch_array($objQuery1))
{

$sum_amount1  =$objResult1["amount"];
$sum_amount= number_format( $sum_amount1,2)."";

$price_per_unit_1  =$objResult1["price"];
$price_per_unit= number_format( $price_per_unit_1,2)."";
$discount_unit_1  =$objResult1["discount"];
$discount_unit= number_format( $discount_unit_1,2)."";


$product_code1  =$objResult1["access_code"];
$product_code = substr($product_code1,0,12);
$product_name1  =$objResult1["access_name"];
$product_name = substr($product_name1,0,40);
$sale_count  =$objResult1["count"];
$unit_name  =$objResult1["unit_name"];


$pdf->SetFont('angsa','',14);

$pdf->setX(18);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , ""),0 ,'R' );


$pdf->setX(0.5);
$pdf->MultiCell(0.5,0, iconv( 'UTF-8','cp874' , "$i"),0 ,'C' );


$pdf->setX(1.0);
$pdf->MultiCell(9.0,0, iconv( 'UTF-8','cp874' , "$product_code"),0 ,'L' );

//$pdf->Code128(26,0,$product_code,25,8);



$pdf->setX(4.0);
$pdf->MultiCell(9.0,0, iconv( 'UTF-8//IGNORE','cp874//IGNORE' , "$product_name"),0 ,'L' );

$pdf->setX(11.6);
$pdf->MultiCell(2.0,0, iconv( 'UTF-8','cp874' , "$sale_count $unit_name"),0 ,'R' );


$pdf->setX(13.75);
$pdf->MultiCell(2.2,0, iconv( 'UTF-8','cp874' , "$price_per_unit"),0 ,'R' );

$pdf->setX(16.3);
$pdf->MultiCell(1.5,0, iconv( 'UTF-8','cp874' , "$discount_unit"),0 ,'R' );



$pdf->setX(17.65);
$pdf->MultiCell( 2.5,0, iconv( 'UTF-8','cp874' , "$sum_amount"),0 ,'R' );

$pdf->setX(17.5);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , ""),0 ,'R' );


$pdf->setX(0.6);
$pdf->Cell(19.8,0,'','T',0,'C',0);


$i++;


}


$pdf->setX(17.5);
$pdf->MultiCell(9.0,1.5, iconv( 'UTF-8','cp874' , ""),0 ,'R' );
$pdf->SetFont('angsa','',16);

$pdf->setX(13.0);
$pdf->MultiCell( 3.0,0, iconv( 'UTF-8','cp874' , "รวมเงิน"),0 ,'R' );


$pdf->setX(17.0);
$pdf->MultiCell(2.5,0, iconv( 'UTF-8','cp874' , "$sum_vat"),0 ,'R' );

$pdf->setX(17.8);
$pdf->MultiCell(2.5,0, iconv( 'UTF-8','cp874' , "บาท"),0 ,'R' );

$pdf->setX(17.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , ""),0 ,'R' );

$pdf->setX(13.0);
$pdf->MultiCell( 3.0,0, iconv( 'UTF-8','cp874' , "ภาษีมูลค่าเพิ่ม"),0 ,'R' );


$pdf->setX(17.0);
$pdf->MultiCell(2.5,0, iconv( 'UTF-8','cp874' , "$vat"),0 ,'R' );

$pdf->setX(17.8);
$pdf->MultiCell(2.5,0, iconv( 'UTF-8','cp874' , "บาท"),0 ,'R' );

$pdf->setX(17.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , ""),0 ,'R' );

$pdf->setX(13.0);
$pdf->MultiCell( 3.0,0, iconv( 'UTF-8','cp874' , "ยอดเงินสุทธิ"),0 ,'R' );


$pdf->setX(17.0);
$pdf->MultiCell(2.5,0, iconv( 'UTF-8','cp874' , "$summary"),0 ,'R' );

$pdf->setX(17.8);
$pdf->MultiCell(2.5,0, iconv( 'UTF-8','cp874' , "บาท"),0 ,'R' );

$pdf->setX(1.5);
$pdf->MultiCell( 9.0,0, iconv( 'UTF-8','cp874' , "($number_thai)."),0 ,'L' );




if($select_type_doc=='3'){

$pdf->SetFont('angsa','',16);

$pdf->setXY(0.6,23.4);
$pdf->MultiCell(11,1.0, iconv( 'UTF-8','cp874' , "การชำระเงินจะสมบูรณ์ เมื่อบริษัทได้รับเงินเรียบร้อยแล้ว"),0 ,'L' );
$pdf->SetFont('angsa','',14);

$pdf->setXY(0.6,25.0);
$pdf->MultiCell(11,1.0, iconv( 'UTF-8','cp874' , "ได้รับสินค้าตามรายการข้างบนนี้ ในสภาพเรียบร้อย และถูกต้องแล้ว"),0 ,'L' );

$pdf->setXY(0.6,26.0);
$pdf->MultiCell(11,1.0, iconv( 'UTF-8','cp874' , "รับของโดย"),0 ,'L' );

$pdf->setXY(5.7,26.0);
$pdf->MultiCell(11,1.0, iconv( 'UTF-8','cp874' , "วันที่"),0 ,'L' );



$pdf->setXY(0.6,26.3);
$pdf->MultiCell(11,1.0, iconv( 'UTF-8','cp874' , "Received By......................................... Date......../........./........"),0 ,'L' );



$pdf->SetFont('angsa','',14);


$pdf->setXY(8.6,26.0);
$pdf->MultiCell(11,1.0, iconv( 'UTF-8','cp874' , "ออกเอกสารโดย"),0 ,'L' );

$pdf->setXY(8.6,26.3);
$pdf->MultiCell(11,1.0, iconv( 'UTF-8','cp874' , "Prepared By.................................."),0 ,'L' );

$pdf->Image("img/yipun.png",10.5,25.6,2.5,1.6);
//$pdf->Image("img/hem.jpg",11.0,26.0,2.0,0.9);


$pdf->SetFont('angsa','',14);

$pdf->setXY(12.7,24.4);
$pdf->MultiCell(11,1.0, iconv( 'UTF-8','cp874' , "ในนาม"),0 ,'L' );
$pdf->setXY(12.7,24.8);
$pdf->MultiCell(11,1.0, iconv( 'UTF-8','cp874' , "For"),0 ,'L' );

$pdf->setXY(13.3,26.3);
$pdf->MultiCell(11,1.0, iconv( 'UTF-8','cp874' , ".................................................."),0 ,'L' );



$pdf->SetFont('angsana','B',14);

$pdf->setXY(13.7,24.4);
$pdf->MultiCell(11,1.0, iconv( 'UTF-8','cp874' , "บริษัท ออลล์เวล ไลฟ์ จำกัด"),0 ,'L' );

$pdf->setXY(13.7,24.8);
$pdf->MultiCell(11,1.0, iconv( 'UTF-8','cp874' , "ALLWELL LIFE CO., LTD"),0 ,'L' );


$pdf->setXY(14.3,27.0);
$pdf->MultiCell(11,1.0, iconv( 'UTF-8','cp874' , "ผู้มีอำนาจลงนาม"),0 ,'L' );

$pdf->setXY(13.9,27.4);
$pdf->MultiCell(11,1.0, iconv( 'UTF-8','cp874' , "Authorized Signature"),0 ,'L' );

$pdf->Image("img/ptl_square.png",13.5,25.6,4.2,2.0);


$pdf->Image("img/piya_ptl.png",14.0,25.6,3.0,1.5);

$pdf->setXY(18.5,26.9);
$pdf->Cell(2.0,0.8, "",1,1,"c" );

$pdf->SetFont('angsana','B',16);
if($code=='ACC'){
$pdf->setXY(19.0,26.8);
$pdf->MultiCell(5.0,1.0, iconv( 'UTF-8','cp874' , "บริษัท"),0 ,'L' );
}else{
$pdf->setXY(19.0,26.8);
$pdf->MultiCell(5.0,1.0, iconv( 'UTF-8','cp874' , "ลูกค้า"),0 ,'L' );
}


$pdf->SetFont('angsa','',12);
$pdf->setXY(0.5,27.0);
$pdf->MultiCell(5.0,1.0, iconv( 'UTF-8','cp874' , "ผิด ตก ยกเว้น E.&O.E"),0 ,'L' );

$pdf->setXY(0.5,27.4);
$pdf->MultiCell(5.0,1.0, iconv( 'UTF-8','cp874' , "อนุมัติวันที่ 25 พ.ค. 2563"),0 ,'L' );

$pdf->setXY(18.0,27.4);
$pdf->MultiCell(2.5,1.0, iconv( 'UTF-8','cp874' , "FM-SA-40:REV.0"),0 ,'R' );
	
$pdf->SetTextColor(0,0,255);
$pdf->setXY(0.6,27.95);
$pdf->MultiCell(15,1.0, iconv( 'UTF-8','cp874' , "** บริษัทฯ ขอสงวนสิทธิ์ที่จะแก้ไขหรือเปลี่ยนแปลงข้อมูลใบกำกับภาษีไม่เกินวันที่ 10 ของเดือนถัดไป **"),0 ,'L' );
$pdf->SetTextColor(0,0,0);	
}



if($select_type_doc=='4'){


$pdf->SetFont('angsa','',16);

$pdf->setXY(0.6,23.4);
$pdf->MultiCell(11,1.0, iconv( 'UTF-8','cp874' , "การชำระเงินจะสมบูรณ์ เมื่อบริษัทได้รับเงินเรียบร้อยแล้ว"),0 ,'L' );
$pdf->SetFont('angsa','',14);

$pdf->setXY(0.6,25.0);
$pdf->MultiCell(11,1.0, iconv( 'UTF-8','cp874' , "ได้รับสินค้าตามรายการข้างบนนี้ ในสภาพเรียบร้อย และถูกต้องแล้ว"),0 ,'L' );

$pdf->setXY(0.6,26.0);
$pdf->MultiCell(11,1.0, iconv( 'UTF-8','cp874' , "รับของโดย"),0 ,'L' );

$pdf->setXY(5.7,26.0);
$pdf->MultiCell(11,1.0, iconv( 'UTF-8','cp874' , "วันที่"),0 ,'L' );



$pdf->setXY(0.6,26.3);
$pdf->MultiCell(11,1.0, iconv( 'UTF-8','cp874' , "Received By......................................... Date......../........./........"),0 ,'L' );



$pdf->SetFont('angsa','',14);


$pdf->setXY(8.6,26.0);
$pdf->MultiCell(11,1.0, iconv( 'UTF-8','cp874' , "ออกเอกสารโดย"),0 ,'L' );

$pdf->setXY(8.6,26.3);
$pdf->MultiCell(11,1.0, iconv( 'UTF-8','cp874' , "Prepared By.................................."),0 ,'L' );

$pdf->Image("img/yipun.png",10.5,25.6,2.5,1.6);



$pdf->SetFont('angsa','',14);

$pdf->setXY(12.7,24.4);
$pdf->MultiCell(11,1.0, iconv( 'UTF-8','cp874' , "ในนาม"),0 ,'L' );
$pdf->setXY(12.7,24.8);
$pdf->MultiCell(11,1.0, iconv( 'UTF-8','cp874' , "For"),0 ,'L' );

$pdf->setXY(13.3,26.3);
$pdf->MultiCell(11,1.0, iconv( 'UTF-8','cp874' , ".................................................."),0 ,'L' );



$pdf->SetFont('angsana','B',14);

$pdf->setXY(13.7,24.4);
$pdf->MultiCell(11,1.0, iconv( 'UTF-8','cp874' , "บริษัท โนเบิล เมดจำกัด"),0 ,'L' );

$pdf->setXY(13.7,24.8);
$pdf->MultiCell(11,1.0, iconv( 'UTF-8','cp874' , "NOBLE MED CO., LTD"),0 ,'L' );


$pdf->setXY(14.3,27.0);
$pdf->MultiCell(11,1.0, iconv( 'UTF-8','cp874' , "ผู้มีอำนาจลงนาม"),0 ,'L' );

$pdf->setXY(13.9,27.4);
$pdf->MultiCell(11,1.0, iconv( 'UTF-8','cp874' , "Authorized Signature"),0 ,'L' );


$pdf->Image("img/nbm_oval.png",13.5,25.6,4.0,2.0);


$pdf->Image("img/piya_nbm.png",14.0,25.6,3.0,1.5);

$pdf->setXY(18.5,26.9);
$pdf->Cell(2.0,0.8, "",1,1,"c" );

$pdf->SetFont('angsana','B',16);
if($code == 'ACC'){
$pdf->setXY(19.0,26.8);
$pdf->MultiCell(5.0,1.0, iconv( 'UTF-8','cp874' , "บริษัท"),0 ,'L' );	
}else{
$pdf->setXY(19.0,26.8);
$pdf->MultiCell(5.0,1.0, iconv( 'UTF-8','cp874' , "ลูกค้า"),0 ,'L' );
}


$pdf->SetFont('angsa','',12);
$pdf->setXY(0.5,27.0);
$pdf->MultiCell(5.0,1.0, iconv( 'UTF-8','cp874' , "ผิด ตก ยกเว้น E.&O.E"),0 ,'L' );

$pdf->setXY(0.5,27.4);
$pdf->MultiCell(5.0,1.0, iconv( 'UTF-8','cp874' , "อนุมัติวันที่ 25 พ.ค. 2563"),0 ,'L' );

$pdf->setXY(18.0,27.4);
$pdf->MultiCell(2.5,1.0, iconv( 'UTF-8','cp874' , "FM-SA-40:REV.0"),0 ,'R' );	
	

$pdf->SetTextColor(0,0,255);
$pdf->setXY(0.6,27.95);
$pdf->MultiCell(15,1.0, iconv( 'UTF-8','cp874' , "** บริษัทฯ ขอสงวนสิทธิ์ที่จะแก้ไขหรือเปลี่ยนแปลงข้อมูลใบกำกับภาษีไม่เกินวันที่ 10 ของเดือนถัดไป **"),0 ,'L' );
$pdf->SetTextColor(0,0,0);	
	
}		


}

$pdf->Output();
?>

