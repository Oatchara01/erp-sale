
<?php
//header("Content-Type: image/png");


//header("Content-Disposition: attachment; filename=สรุปงานแผนกบริการลูกค้า.png");


define('FPDF_FONTPATH', __DIR__ . '/font/');
 
require('fpdf.php');

$ref_id = isset($_GET["ref_id"]) ? trim((string)$_GET["ref_id"]) : "";

include"dbconnect.php";

$ref_id_escaped = mysqli_real_escape_string($conn, $ref_id);

$strSQL = "SELECT * FROM tb_register_data WHERE ref_id = '".$ref_id_escaped."' ";
$objQuery = mysqli_query($conn, $strSQL);
$objResult = ($objQuery && mysqli_num_rows($objQuery) > 0) ? mysqli_fetch_array($objQuery) : null;

$ttt = substr($ref_id, 0, 2);

if ($ttt == 'BR') {
	$strSQL15 = "SELECT SUM(amount) AS amount_1 FROM hos__subbr WHERE ref_idd_br = '".$ref_id_escaped."' ";
} else if ($ttt == 'BS') {
	$strSQL15 = "SELECT SUM(amount) AS amount_1 FROM hos__subconsig WHERE ref_idd = '".$ref_id_escaped."' ";
} else {
	$strSQL15 = "SELECT SUM(amount) AS amount_1 FROM hos__subso WHERE ref_idd = '".$ref_id_escaped."' ";
}
$objQuery15 = mysqli_query($conn, $strSQL15);
$objResult15 = ($objQuery15 && mysqli_num_rows($objQuery15) > 0) ? mysqli_fetch_array($objQuery15) : null;

$summary_1 = (float)($objResult15['amount_1'] ?? 0);
$summary = number_format($summary_1, 2) . "";

$company = '';
if ($ttt == 'SM') {
	$strSQL16 = "SELECT type_company FROM hos__smp WHERE ref_idsmp = '".$ref_id_escaped."' ";
	$objQuery16 = mysqli_query($conn, $strSQL16);
	if ($objQuery16 && mysqli_num_rows($objQuery16) > 0) {
		$objResult16 = mysqli_fetch_array($objQuery16);
		$company = (string)($objResult16["type_company"] ?? '');
	}
} else if ($ttt == 'SO') {
	$strSQL16 = "SELECT type_doc FROM hos__so WHERE ref_id = '".$ref_id_escaped."' ";
	$objQuery16 = mysqli_query($conn, $strSQL16);
	if ($objQuery16 && mysqli_num_rows($objQuery16) > 0) {
		$objResult16 = mysqli_fetch_array($objQuery16);
		$company = (string)($objResult16["type_doc"] ?? '');
	}
} else if ($ttt == 'BR') {
	$strSQL16 = "SELECT company FROM hos__br WHERE ref_id_br = '".$ref_id_escaped."' ";
	$objQuery16 = mysqli_query($conn, $strSQL16);
	if ($objQuery16 && mysqli_num_rows($objQuery16) > 0) {
		$objResult16 = mysqli_fetch_array($objQuery16);
		$company = (string)($objResult16["company"] ?? '');
	}
} else if ($ttt == 'BS') {
	$strSQL16 = "SELECT company FROM hos__consig WHERE ref_id = '".$ref_id_escaped."' ";
	$objQuery16 = mysqli_query($conn, $strSQL16);
	if ($objQuery16 && mysqli_num_rows($objQuery16) > 0) {
		$objResult16 = mysqli_fetch_array($objQuery16);
		$company = (string)($objResult16["company"] ?? '');
	}
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

//$newDate = date("d-m-Y", strtotime($start_date));
$ref_id = (string)($objResult["ref_id"] ?? $ref_id);
$delivery_name = (string)($objResult["customer_name"] ?? '');
$tel = (string)($objResult["customer_tel"] ?? '');
$address1 = (string)($objResult["address_name"] ?? '');




$pdf=new FPDF( 'P' , 'cm' , 'A4' );
$pdf->AddFont('angsa','','angsa.php');
$pdf->AddFont('angsana','B','angsab.php');


 

$pdf->AddPage();

$pdf->SetFont('angsa','',32);
$pdf->setXY(12.0,3.5);
$pdf->MultiCell( 9  , 0.6 , iconv( 'UTF-8','cp874' , "$ref_id #"),0 ,'L' );

$pdf->setXY( 1.0,3.0);
$pdf->Cell(17.0,10.0, "",1,1,"c" );



$pdf->SetFont('angsana','B',35);
$pdf->setXY(4.5,2.1);
$pdf->MultiCell( 9  , 0.6 , iconv( 'UTF-8','cp874' , "ชื่อที่อยู่ผู้รับ / Address"),0 ,'L' );

$pdf->SetFont('angsana','B',35);

$pdf->setXY(1.8,5.0);
$pdf->MultiCell( 15.0,1.0, iconv( 'UTF-8','cp874' , "$delivery_name"),0 ,'L' );

$pdf->SetFont('angsana','B',35);

$pdf->setXY(1.8,6.5);
$pdf->MultiCell( 15 , 0.6 , iconv( 'UTF-8','cp874' , "โทร : $tel"),0 ,'L' );



$pdf->setXY(1.8,7.4);
$pdf->MultiCell(15.0,1.3, iconv( 'UTF-8','cp874' , "$address1"),0 ,'L' );

$pdf->SetFont('angsa','',26);
 if($company=='1' or $company=='3'){ 
$pdf->setXY(1.8,15.8);
$pdf->MultiCell(20, 0.8, iconv( 'UTF-8','cp874' , "ผู้ส่ง : บริษัท ออลล์เวล ไลฟ์ จำกัด (02-424-3555)"),0 ,'L' );
	 
$pdf->setXY(1.8,17.0);
$pdf->MultiCell(18, 1.0, iconv( 'UTF-8','cp874' , "ที่อยู่ : 73,75 ซอยจรัญสนิทวงศ์ 89/2 แขวงบางอ้อ เขตบางพลัด กรุงเทพ ฯ 10700"),0 ,'L' );	
	 

 }else if($company=='2' or $company=='4'){ 
$pdf->setXY(1.8,15.8);
$pdf->MultiCell(20, 0.8, iconv( 'UTF-8','cp874' , "ผู้ส่ง : บริษัท โนเบิล เมด จำกัด (02-880-5566)"),0 ,'L' );

$pdf->setXY(1.8,17.0);
$pdf->MultiCell(18, 1.0, iconv( 'UTF-8','cp874' , "ที่อยู่ : 73 ซอยจรัญสนิทวงศ์ 89/2 แขวงบางอ้อ เขตบางพลัด กรุงเทพ ฯ 10700"),0 ,'L' );	
	 
	 
 } 


$pdf->Output();
?>


