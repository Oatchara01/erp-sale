
<?php
//header("Content-Type: image/png");


//header("Content-Disposition: attachment; filename=สรุปงานแผนกบริการลูกค้า.png");


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
	$strSQL1 = "SELECT company AS type_doc FROM hos__br WHERE ref_id_br = '".$ref_id_escaped."' ";
} else if ($ttt == 'BS') {
	$strSQL1 = "SELECT company AS type_doc FROM hos__consig WHERE ref_id = '".$ref_id_escaped."' ";
} else {
	$strSQL1 = "SELECT type_doc FROM hos__so WHERE ref_id = '".$ref_id_escaped."' ";
}
$objQuery1 = mysqli_query($conn, $strSQL1);
$objResult1 = ($objQuery1 && mysqli_num_rows($objQuery1) > 0) ? mysqli_fetch_array($objQuery1) : null;

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

$type_doc = (string)($objResult1["type_doc"] ?? '');
$ref_id = (string)($objResult["ref_id"] ?? $ref_id);
$delivery_name = (string)($objResult["customer_name9"] ?? '');
$customer_tel = (string)($objResult["customer_tel9"] ?? '');
$address1 = (string)($objResult["address_name9"] ?? '');



$pdf=new FPDF( 'L' , 'cm' , 'A4' );
$pdf->AddFont('angsa','','angsa.php');
$pdf->AddFont('angsana','B','angsab.php');


 

$pdf->AddPage();

$pdf->SetFont('angsa','',24);
$pdf->setXY(25.5,1.0);
$pdf->MultiCell( 9  ,1.0, iconv( 'UTF-8','cp874' , "$ref_id #"),0 ,'L' );


if($type_doc=='3'){

$pdf->setXY(2.5,2.0);
$pdf->MultiCell(12.0,1.1, iconv( 'UTF-8','cp874' , "บริษัท ออลล์เวล ไลฟ์ จำกัด"),0 ,'L' );

$pdf->setXY(2.5,3.0);
$pdf->MultiCell(12.0,1.1, iconv( 'UTF-8','cp874' , "73,75 ซอยจรัญสนิทวงศ์ 89/2"),0 ,'L' );

$pdf->setXY(2.5,4.0);
$pdf->MultiCell(12.0,1.0, iconv( 'UTF-8','cp874' , "แขวงบางอ้อ เขตบางพลัด กรุงเทพ ฯ 10700"),0 ,'L' );

$pdf->setXY(2.5,5.0);
$pdf->MultiCell(12.0,1.0, iconv( 'UTF-8','cp874' , "โทร : 0-2424-3555"),0 ,'L' );


}else if($type_doc=='4'){

$pdf->setXY(2.5,2.0);
$pdf->MultiCell(11.0,1.1, iconv( 'UTF-8','cp874' , "บริษัท โนเบิล เมด จำกัด"),0 ,'L' );

$pdf->setXY(2.5,3.0);
$pdf->MultiCell(11.0,1.1, iconv( 'UTF-8','cp874' , "73 ซอยจรัญสนิทวงศ์ 89/2"),0 ,'L' );

$pdf->setXY(2.5,4.0);
$pdf->MultiCell(11.0,1.0, iconv( 'UTF-8','cp874' , "แขวงบางอ้อ เขตบางพลัด กรุงเทพ ฯ 10700"),0 ,'L' );

$pdf->setXY(2.5,5.0);
$pdf->MultiCell(15.0,1.0, iconv( 'UTF-8','cp874' , "โทร : 0-2880-5566"),0 ,'L' );


}


$pdf->SetFont('angsana','B',30);

$pdf->setXY(13.0,8.0);
$pdf->MultiCell(12.0,1.5, iconv( 'UTF-8','cp874' , "$delivery_name"),0 ,'L' );
$pdf->SetFont('angsa','',30);

$pdf->setXY(13.0,9.0);
$pdf->MultiCell(12.0,1.5, iconv( 'UTF-8','cp874' , "โทร :"),0 ,'L' );


$pdf->setXY(15.0,9.0);
$pdf->MultiCell(12.0,1.5, iconv( 'UTF-8','cp874' , "$customer_tel"),0 ,'L' );

$pdf->setXY(13.0,10.0);
$pdf->MultiCell(16,1.5, iconv( 'UTF-8','cp874' , "$address1"),0 ,'L' );





$pdf->Output();
?>


