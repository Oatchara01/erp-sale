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
$company = $_GET["company"];

function generatePDF($data)
{
    $pdf = new FPDF('P', 'cm', 'A4');

    // ... (your existing PDF generation code for a single file)

    return $pdf;
}


$outputDir = sys_get_temp_dir() . '/download_files_' . time();
mkdir($outputDir);

include"dbconnect.php";
 //
$strSQL = "SELECT * FROM tb_credit_note  WHERE company_type ='".$company."' and date_credit >='".$start_date."' and date_credit <='".$end_date."' and credit_no !='' and status_doc='Approve' and new_bill!='0' and iv_no_ref LIKE '%ET%'";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$j=1;
while($objResult = mysqli_fetch_array($objQuery))
{	
$ref_id = $objResult["ref_credit"];
$doc_no1 = $objResult["credit_no"];
$new_bill =  $objResult["new_bill"];
$pp = "_0";
$ii_vo = $doc_no1.$pp.$new_bill;	
$desnew_bill  =$objResult["desnew_bill"];	
	
$dateod = explode('-' , $objResult["date_oldbill"] );
$yearod = $dateod[0]+543;
$year1od = substr($yearod, 2 ,2);
$doc_release_dateod = $dateod[2].'/'.$dateod[1].'/'.$year1od;
	

$doc = explode('/' ,$objResult["credit_no"]);	
	
	
$pdf = generatePDF($objResult);


$strSQL9 = "SELECT iv_no_ref FROM tb_credit_note  WHERE ref_credit = '".$ref_id."' and sale_code LIKE '%SOL%'";
$objQuery9 = mysqli_query($conn,$strSQL9) or die(mysqli_error());
$objResult9 = mysqli_fetch_array($objQuery9);

if($objResult9["iv_no_ref"]==''){

$strSQL1 = "SELECT * FROM hos__so  WHERE iv_no = '".$objResult["iv_no_ref"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die(mysqli_error());
$objResult1 = mysqli_fetch_array($objQuery1);
	
	
$billing_name = $objResult1["bill_name"];
$billing_address = $objResult1["bill_address"];
//$doc_release_date = Datethai($objResult["doc_release_date"]);

$date = explode('-' , $objResult1["iv_date"] );
$year = $date[0]+543;
$year1 = substr($year, 2 ,2);
$doc_release_date = $date[2].'/'.$date[1].'/'.$year1;



$employee_name = $objResult1["sale_code"];
$order_id = $objResult1["po_no"];
$doc_no = $objResult1["iv_no"];
$tax_id = $objResult1["tax_id"];
$preface_name  ="";


	
$strSQL15 = "SELECT SUM(amount) AS amount_1 FROM hos__subso WHERE ref_idd = '".$objResult1["ref_id"]."' ";
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResult15= mysqli_fetch_array($objQuery15);

$summaryod_1=$objResult15['amount_1'];
$summaryod= number_format($summaryod_1,2)."";
$sum_vatod1 =($summaryod_1/1.07);
$sum_vatod= number_format( $sum_vatod1,2)."";
$vatod1 = ($sum_vatod1 * 0.07);
$vatod= number_format( $vatod1,2)."";		
	

}else{

$strSQL1 = "SELECT * FROM so__main  WHERE doc_no = '".$objResult["iv_no_ref"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die(mysqli_error());
$objResult1 = mysqli_fetch_array($objQuery1);	
	
$billing_name = $objResult1["billing_name"];
$billing_address = $objResult1["billing_address"];
//$doc_release_date = Datethai($objResult["doc_release_date"]);
if($objResult1["ckkdate_vat"]=='1'){
$doc_release_date = "";	
	
}else{
$date = explode('-' , $objResult1["doc_release_date"] );
$year = $date[0]+543;
$year1 = substr($year, 2 ,2);
$doc_release_date = $date[2].'/'.$date[1].'/'.$year1;
}

$employee_name = $objResult1["employee_name"];
$order_id = $objResult1["order_id"];
$doc_no = $objResult1["doc_no"];
$tax_id = $objResult1["tax_id"];
$send_supadm = $objResult1["send_supadm"];
$send_sup = $objResult1["send_sup"];
$send_cm = $objResult1["send_cm"];
$status_vat = $objResult1["status_vat"];
$preface_name  =$objResult1["pre_name"];
	
	
$strSQL15 = "SELECT SUM(sum_amount) AS amount_1 FROM so__submain WHERE ref_idd = '".$objResult1["ref_id"]."' ";
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResult15= mysqli_fetch_array($objQuery15);

$summaryod_1=$objResult15['amount_1'];
$summaryod= number_format($summaryod_1,2)."";
$sum_vatod1 =($summaryod_1/1.07);
$sum_vatod= number_format( $sum_vatod1,2)."";
$vatod1 = ($sum_vatod1 * 0.07);
$vatod= number_format( $vatod1,2)."";	
	
	
	
}



$strSQL16 = "SELECT SUM(sum_amount) AS amount_1 FROM tb_subcredit WHERE ref_creditt = '".$ref_id."' ";
$objQuery16 = mysqli_query($conn,$strSQL16);
$objResult16= mysqli_fetch_array($objQuery16);

$summary_1=$objResult16['amount_1'];
$summary= number_format($summary_1,2)."";
$sum_vat1 =($summary_1/1.07);
$sum_vat= number_format( $sum_vat1,2)."";
$vat1 = ($sum_vat1 * 0.07);
$vat= number_format( $vat1,2)."";

$number_thai = Convert($summary_1);



$company_type = $objResult["company_type"];
$credit_no = $objResult["credit_no"];

$date_c = explode('-' , $objResult["date_credit"] );
$yearc = $date[0]+543;
$year_c1 = substr($yearc, 2 ,2);
$date_credit = $date_c[2].'/'.$date_c[1].'/'.$year_c1;
$return_des = $objResult["remark_et"];

/////////////////////////

$pdf->AddPage();
$pdf->AddFont('angsa','','angsa.php');
$pdf->AddFont('angsana','B','angsab.php');
$pdf->AddFont('times','','times.php');


$pdf->SetFont('angsa','',14);

if($company_type=='3'){

$pdf->Image("img/allwell_2307.png",0.9,0.5,2.3,3.0);

$pdf->SetFont('angsana','B',20);

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

}else if($company_type=='4'){
	
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

$pdf->setXY(14.8,0.5);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "ใบรับคืนสินค้า/ใบลดหนี้"),0 ,'L' );
$pdf->SetFont('angsana','B',15);
$pdf->setXY(13.3,1.1);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "SALE RETURN / CREDIT MEMORANDUM"),0 ,'L' );





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
$pdf->MultiCell(9.0, 0.5 , iconv( 'UTF-8','cp874' , "เลขที่ใบลดหนี้"),0 ,'L' );

$pdf->setXY(12.2,5.6);
$pdf->MultiCell(9.0, 0.5 , iconv( 'UTF-8','cp874' , "วันที่"),0 ,'L' );

$pdf->setXY(12.2,6.1);
$pdf->MultiCell(9.0, 0.5 , iconv( 'UTF-8','cp874' , "อ้างอิงใบกำกับภาษี"),0 ,'L' );

$pdf->setXY(12.2,6.6);
$pdf->MultiCell(9.0, 0.5 , iconv( 'UTF-8','cp874' , "พนักงานขาย"),0 ,'L' );

$pdf->setXY(15.5,5.0);
$pdf->MultiCell(9.0,0.5, iconv( 'UTF-8','cp874' , "$ii_vo"),0 ,'L' );


$pdf->setXY(15.5,5.6);
$pdf->MultiCell(9.0,0.5, iconv( 'UTF-8','cp874' , "$date_credit"),0 ,'L' );

$pdf->setXY(15.5,6.1);
$pdf->MultiCell(9.0,0.5, iconv( 'UTF-8','cp874' , "$doc_no $doc_release_date"),0 ,'L' );

$pdf->setXY(15.5,6.6);
$pdf->MultiCell(9.0,0.5, iconv( 'UTF-8','cp874' , "$employee_name"),0 ,'L' );

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











$strSQL11 = "SELECT sum_amount,unit_price,access_name,count,unit_name,access_code,discount_unit FROM (tb_subcredit LEFT JOIN tb_product ON tb_subcredit.product_ID=tb_product.product_id) WHERE ref_creditt = '".$ref_id."' ";
$objQuery11 = mysqli_query($conn,$strSQL11) or die ("Error Query [".$strSQL11."]");
$Num_Rows11 = mysqli_num_rows($objQuery11);



$i=1;
while($objResult11 = mysqli_fetch_array($objQuery11))
{

$sum_amount1  =$objResult11["sum_amount"];
$sum_amount= number_format( $sum_amount1,2)."";

$price_per_unit_1  =$objResult11["unit_price"];
$price_per_unit= number_format( $price_per_unit_1,2)."";
$discount_unit_1  =$objResult11["discount_unit"];
$discount_unit= number_format( $discount_unit_1,2)."";


$product_code1  =$objResult11["access_code"];
$product_code = substr($product_code1,0,12);
$product_name1  =$objResult11["access_name"];
$product_name = substr($product_name1,0,40);
$sale_count  =$objResult11["count"];
$unit_name  =$objResult11["unit_name"];


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
$pdf->SetFont('angsa','',15);

$pdf->setX(0.7);
$pdf->MultiCell( 9.0,0, iconv( 'UTF-8','cp874' , "สาเหตุที่ลดหนี้"),0 ,'L' );

$pdf->setX(17.5);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , ""),0 ,'R' );

$pdf->setX(0.7);
$pdf->MultiCell(10.0,0.6, iconv( 'UTF-8','cp874' , "$return_des"),0 ,'L' );

$pdf->setX(13.0);
$pdf->MultiCell( 3.0,0, iconv( 'UTF-8','cp874' , "รวม"),0 ,'R' );

$pdf->setX(17.0);
$pdf->MultiCell(2.5,0, iconv( 'UTF-8','cp874' , "$summary"),0 ,'R' );

$pdf->setX(17.8);
$pdf->MultiCell(2.5,0, iconv( 'UTF-8','cp874' , "บาท"),0 ,'R' );

$pdf->setX(17.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , ""),0 ,'R' );

$pdf->setX(13.0);
$pdf->MultiCell( 3.0,0, iconv( 'UTF-8','cp874' , "หักส่วนลด"),0 ,'R' );


$pdf->setX(17.0);
$pdf->MultiCell(2.5,0, iconv( 'UTF-8','cp874' , "0.00"),0 ,'R' );

$pdf->setX(17.8);
$pdf->MultiCell(2.5,0, iconv( 'UTF-8','cp874' , "บาท"),0 ,'R' );

$pdf->setX(17.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , ""),0 ,'R' );


$pdf->setX(11.0);
$pdf->MultiCell(5.0,0, iconv( 'UTF-8','cp874' , "จำนวนเงินหลังหักส่วนลด"),0 ,'R' );

$pdf->setX(17.0);
$pdf->MultiCell(2.5,0, iconv( 'UTF-8','cp874' , "$summary"),0 ,'R' );

$pdf->setX(17.8);
$pdf->MultiCell(2.5,0, iconv( 'UTF-8','cp874' , "บาท"),0 ,'R' );

$pdf->setX(17.5);
$pdf->MultiCell(9.0,0.3, iconv( 'UTF-8','cp874' , ""),0 ,'R' );

$pdf->setX(17.3);
$pdf->Cell(3.0,0,'','T',0,'C',0);

$pdf->setX(17.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , ""),0 ,'R' );




$pdf->setX(7.0);
$pdf->MultiCell(9.0,0, iconv( 'UTF-8','cp874' , "มูลค่าของสินค้าหรือบริการตามใบกำกับภาษีเดิม"),0 ,'R' );


$pdf->setX(17.0);
$pdf->MultiCell(2.5,0, iconv( 'UTF-8','cp874' , "$sum_vatod"),0 ,'R' );

$pdf->setX(17.8);
$pdf->MultiCell(2.5,0, iconv( 'UTF-8','cp874' , "บาท"),0 ,'R' );

$pdf->setX(17.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , ""),0 ,'R' );

$pdf->setX(7.0);
$pdf->MultiCell(9.0,0, iconv( 'UTF-8','cp874' , "มูลค่าของสินค้าหรือบริการที่ถูกต้อง"),0 ,'R' );


$ee = number_format(($sum_vatod1-$sum_vat1),2)."";
$aaa = number_format($sum_vatod1-($sum_vatod1-$sum_vat1),2)."";

$pdf->setX(17.0);
$pdf->MultiCell(2.5,0, iconv( 'UTF-8','cp874' , "$ee"),0 ,'R' );

$pdf->setX(17.8);
$pdf->MultiCell(2.5,0, iconv( 'UTF-8','cp874' , "บาท"),0 ,'R' );

$pdf->setX(17.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , ""),0 ,'R' );



$pdf->setX(7.0);
$pdf->MultiCell(9.0,0, iconv( 'UTF-8','cp874' , "ผลต่าง"),0 ,'R' );

$pdf->setX(17.0);
$pdf->MultiCell(2.5,0, iconv( 'UTF-8','cp874' , "$aaa"),0 ,'R' );

$pdf->setX(17.8);
$pdf->MultiCell(2.5,0, iconv( 'UTF-8','cp874' , "บาท"),0 ,'R' );

$pdf->setX(17.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , ""),0 ,'R' );



$pdf->setX(12.0);
$pdf->MultiCell(4.0,0, iconv( 'UTF-8','cp874' , "จำนวนภาษีมูลค่าเพิ่ม"),0 ,'R' );


$pdf->setX(17.0);
$pdf->MultiCell(2.5,0, iconv( 'UTF-8','cp874' , "$vat"),0 ,'R' );

$pdf->setX(17.8);
$pdf->MultiCell(2.5,0, iconv( 'UTF-8','cp874' , "บาท"),0 ,'R' );

$pdf->setX(17.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , ""),0 ,'R' );

$pdf->setX(11.0);
$pdf->MultiCell(5.0,0, iconv( 'UTF-8','cp874' , "จำนวนเงินรวมทั้งสินค้า"),0 ,'R' );


$pdf->setX(17.0);
$pdf->MultiCell(2.5,0, iconv( 'UTF-8','cp874' , "$summary"),0 ,'R' );

$pdf->setX(17.8);
$pdf->MultiCell(2.5,0, iconv( 'UTF-8','cp874' , "บาท"),0 ,'R' );





$pdf->setX(1.5);
$pdf->MultiCell( 9.0,0, iconv( 'UTF-8','cp874' , "($number_thai)."),0 ,'L' );

$pdf->SetFont('angsa','',14);

$pdf->setXY(0.6,25.2);
$pdf->MultiCell(11,1.0, iconv( 'UTF-8','cp874' , "เป็นการยกเลิก และออกใบลดหนี้ฉบับใหม่ทดแทนฉบับเดิมเลขที่"),0 ,'L' );


$pdf->setXY(0.6,25.8);
$pdf->MultiCell(11,1.0, iconv( 'UTF-8','cp874' , "$doc_no1 ลงวันที่ $doc_release_dateod เนื่องจาก $desnew_bill"),0 ,'L' );


$pdf->SetFont('angsa','',14);
$pdf->setXY(0.6,26.0);
$pdf->MultiCell(20,0.6, iconv( 'UTF-8','cp874' , "เอกสารนี้ได้จัดทำและส่งข้อมูลให้แก่กรมสรรพากรด้วยวิธีการทางอิเล็กทรอนิกส์แล้ว"),0 ,'L' );

$pdf->setXY(0.6,26.6);
$pdf->MultiCell(20,0.6, iconv( 'UTF-8','cp874' , "โปรดตรวจสอบความถูกต้องของรายการในเอกสารฉบับนี้ ภายใน 15 วัน มิฉะนั้นบริษัทฯ จะถือว่าเอกสารฉบับนี้ถูกต้องและสมบูรณ์"),0 ,'L' );
	

// Save the PDF to the output directory
	if($company=='3'){
    $pdfFileName = $outputDir . "/" . $ii_vo . ".pdf";
	}else if($company=='4'){
	$pdfFileName = $outputDir . "/" . $doc[0] . "_" . $doc[1] . $pp . $new_bill . ".pdf";	
	}
    $pdf->Output($pdfFileName, 'F');	

$j++;	
}	

$zipFileName = sys_get_temp_dir() . '/download_files_' . time() . '.zip';
$zip = new ZipArchive();
$zip->open($zipFileName, ZipArchive::CREATE);

$files = glob($outputDir . '/*.pdf');
foreach ($files as $file) {
    $zip->addFile($file, basename($file));
}

$zip->close();

// Send the zip file for download
header('Content-Type: application/zip');
header('Content-Disposition: attachment; filename="Etax_CreditNote.zip"');
header('Pragma: no-cache');
header('Expires: 0');
readfile($zipFileName);

// Remove the temporary directory and files
array_map('unlink', glob($outputDir . '/*.pdf'));
rmdir($outputDir);
unlink($zipFileName);	
?>

