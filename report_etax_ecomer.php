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
//  LIMIT 25 OFFSET 25
$strSQL ="SELECT ref_id,doc_no,doc_release_date,select_type_doc,billing_name,billing_address,ckkdate_vat,employee_name,order_id,tax_id,pre_name,sale_channel FROM so__main WHERE select_type_doc ='".$company."' and doc_release_date >='".$start_date."' and doc_release_date <='".$end_date."' and doc_no LIKE '%ET%' and cancel_ckk ='0' and approve_complete='Approve' and new_bill='0' and ckk_h='1' ";
$objQuery =mysqli_query($conn,$strSQL);
$j=1;
while($objResult = mysqli_fetch_array($objQuery))
{	
$ref_id = $objResult["ref_id"];
$doc_no = $objResult["doc_no"];

$doc = explode('/' ,$objResult["doc_no"]);	
	
	
$pdf = generatePDF($objResult);

    
	
	
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
if($objResult["ckkdate_vat"]=='1'){
$doc_release_date = "";	
	
}else{
$date = explode('-' , $objResult["doc_release_date"] );
$year = $date[0]+543;
$year1 = substr($year, 2 ,2);
$doc_release_date = $date[2].'/'.$date[1].'/'.$year1;
}
	
$sale_channel = $objResult["sale_channel"];		
if($sale_channel=='31'){	
$dd_sum = date("Y-m-d", strtotime($objResult["doc_release_date"] . " +10 days"));

$date_1 = explode('-' , $dd_sum );	
$year_1 = $date_1[0]+543;
$year11 = substr($year_1, 2 ,2);
$date_credit = $date_1[2].'/'.$date_1[1].'/'.$year11;
	
}else{
$date_credit = $doc_release_date;	
}	
	

$employee_name = $objResult["employee_name"];
$order_id = $objResult["order_id"];
$doc_no = $objResult["doc_no"];
$tax_id = $objResult["tax_id"];
$preface_name  =$objResult["pre_name"];
$select_type_doc  =$objResult["select_type_doc"];






 




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

$pdf->setXY(14.8,0.5);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "ใบกำกับภาษี / ใบเสร็จรับเงิน"),0 ,'L' );
$pdf->SetFont('angsana','B',15);
$pdf->setXY(15.2,1.1);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "TAX INVOICE / RECEIPT"),0 ,'L' );





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
$pdf->MultiCell(9.0, 0.5 , iconv( 'UTF-8//IGNORE','cp874//IGNORE' , "$tax_id"),0 ,'L' );


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
$pdf->MultiCell(9.0,0.5, iconv( 'UTF-8','cp874' , "$date_credit"),0 ,'L' );


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
$product_code = substr($product_code1,0,12);
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
$pdf->MultiCell(9.0,0, iconv( 'UTF-8//IGNORE','cp874//IGNORE' , "$product_code"),0 ,'L' );

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







$pdf->SetFont('angsa','',16);
$pdf->setXY(0.6,25.0);
$pdf->MultiCell(11,1.0, iconv( 'UTF-8','cp874' , "การชำระเงินจะสมบูรณ์ เมื่อบริษัทได้รับเงินเรียบร้อยแล้ว"),0 ,'L' );

$pdf->SetFont('angsa','',14);
$pdf->setXY(0.6,26.0);
$pdf->MultiCell(20,0.6, iconv( 'UTF-8','cp874' , "เอกสารนี้ได้จัดทำและส่งข้อมูลให้แก่กรมสรรพากรด้วยวิธีการทางอิเล็กทรอนิกส์แล้ว"),0 ,'L' );

$pdf->setXY(0.6,26.6);
$pdf->MultiCell(20,0.6, iconv( 'UTF-8','cp874' , "โปรดตรวจสอบความถูกต้องของรายการในเอกสารฉบับนี้ ภายใน 15 วัน มิฉะนั้นบริษัทฯ จะถือว่าเอกสารฉบับนี้ถูกต้องและสมบูรณ์"),0 ,'L' );
	
/*$pdf->SetFont('angsa','',12);
$pdf->SetTextColor(0,0,255);
$pdf->setXY(0.6,27.95);
$pdf->MultiCell(15,1.0, iconv( 'UTF-8','cp874' , "** บริษัทฯ ขอสงวนสิทธิ์ที่จะแก้ไขหรือเปลี่ยนแปลงข้อมูลใบกำกับภาษีไม่เกินวันที่ 10 ของเดือนถัดไป **"),0 ,'L' );*/

$pdf->SetTextColor(0,0,0);

// Save the PDF to the output directory
	
	//if($company=='3'){
	$pdfFileName = $outputDir . "/" . $doc_no . ".pdf";	

    /*}else if($company=='4'){
	$pdfFileName = $outputDir . "/" . $doc[0] . "_" . $doc[1] . ".pdf";	
	}*/
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
header('Content-Disposition: attachment; filename="Etax_Invoice_Home.zip"');
header('Pragma: no-cache');
header('Expires: 0');
readfile($zipFileName);

// Remove the temporary directory and files
array_map('unlink', glob($outputDir . '/*.pdf'));
rmdir($outputDir);
unlink($zipFileName);	
	
	
?>

