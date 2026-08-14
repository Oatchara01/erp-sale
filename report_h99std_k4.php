
<?php
//header("Content-Type: image/png");


//header("Content-Disposition: attachment; filename=à¸ªà¸£à¸¸à¸›à¸‡à¸²à¸™à¹à¸œà¸™à¸à¸šà¸£à¸´à¸à¸²à¸£à¸¥à¸¹à¸à¸„à¹‰à¸².png");


define('FPDF_FONTPATH','font/');
 
require('fpdf.php');

$ref_id = isset($_GET["ref_id"]) ? trim((string)$_GET["ref_id"]) : "";

include"dbconnect.php";

$ref_id_escaped = mysqli_real_escape_string($conn, $ref_id);

$strSQL = "SELECT * FROM tb_delivery_print WHERE ref_id = '".$ref_id_escaped."' ";
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

date_default_timezone_set("Asia/Bangkok");
if (!function_exists('pdf_text')) {
	function pdf_text($text)
	{
		$converted = @iconv('UTF-8', 'cp874//IGNORE', (string)$text);
		return ($converted === false) ? '' : $converted;
	}
}

if (!function_exists('DateThai')) {
	function DateThai($strDate)
	{
		$strYear = date("Y",strtotime($strDate))+543;
		$strMonth= date("n",strtotime($strDate));
		$strDay= date("j",strtotime($strDate));
		$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		$strMonthThai=$strMonthCut[$strMonth];
		return "$strDay $strMonthThai $strYear";
	}
}

$ref_id = (string)($objResult["ref_id"] ?? $ref_id);
$delivery_name = (string)($objResult["customer_name4"] ?? '');
$tel = (string)($objResult["customer_tel4"] ?? '');
$address1 = (string)($objResult["address_name4"] ?? '');




$pdf=new FPDF( 'P' , 'cm' , 'A4' );
$pdf->AddFont('angsa','','angsa.php');
$pdf->AddFont('angsana','B','angsab.php');


 

$pdf->AddPage();











$pdf->SetFont('angsa','',32);
$pdf->setXY(13.0,3.5);
$pdf->MultiCell( 9  , 0.6 , pdf_text("$ref_id #"),0 ,'L' );

$pdf->setXY( 1.0,3.0);
$pdf->Cell(17.0,11.0, "",1,1,"c" );



$pdf->SetFont('angsana','B',35);
$pdf->setXY(4.5,2.1);
$pdf->MultiCell( 9  , 0.6 , pdf_text('ชื่อที่อยู่ผู้รับ / Address'),0 ,'L' );

$pdf->SetFont('angsana','B',35);

$pdf->setXY(1.8,5.0);
$pdf->MultiCell(15,1.0, pdf_text($delivery_name),0 ,'L' );
$pdf->SetFont('angsana','B',35);

$pdf->setXY(1.8,6.3);
$pdf->MultiCell(15, 0.6 , pdf_text('โทร : ' . $tel),0 ,'L' );


$pdf->setXY(1.8,7.3);
$pdf->MultiCell(15.0,1.3, pdf_text($address1),0 ,'L' );



$pdf->SetFont('angsana','B',28);

$pdf->setXY(1.8,13.0);
$pdf->MultiCell(15.0, 0.6 , pdf_text('**เก็บเงินปลายทาง** COD ยอดเงิน ' . $summary . ' บาท'),0 ,'L' );



$pdf->Output();
?>