
<?php
//header("Content-Type: image/png");


//header("Content-Disposition: attachment; filename=สรุปงานแผนกบริการลูกค้า.png");


define('FPDF_FONTPATH', __DIR__ . '/font/');
 
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
$delivery_name = (string)($objResult["customer_name1"] ?? '');
$tel = (string)($objResult["customer_tel1"] ?? '');
$address1 = (string)($objResult["address_name1"] ?? '');



$pdf=new FPDF( 'P' , 'cm' , 'A5' );
$pdf->AddFont('angsa','','angsa.php');
$pdf->AddFont('angsana','B','angsab.php');


 

$pdf->AddPage();

$pdf->SetFont('angsa','',18);
$pdf->setXY(11.0,1.0);
$pdf->MultiCell( 9  , 0.6 , iconv( 'UTF-8','cp874' , "$ref_id #"),0 ,'L' );

if($type_doc=='3'){

$pdf->setXY(1.5,2.0);
$pdf->MultiCell( 9  , 0.6 , iconv( 'UTF-8','cp874' , "บริษัท ออลล์เวล ไลฟ์ จำกัด"),0 ,'L' );

$pdf->setXY(1.5,2.6);
$pdf->MultiCell( 9  , 0.6 , iconv( 'UTF-8','cp874' , "73,75 ซอยจรัญสนิทวงศ์ 89/2"),0 ,'L' );

$pdf->setXY(1.5,3.2);
$pdf->MultiCell( 9  , 0.6 , iconv( 'UTF-8','cp874' , "แขวงบางอ้อ เขตบางพลัด กรุงเทพ ฯ 10700"),0 ,'L' );

$pdf->setXY(1.5,3.8);
$pdf->MultiCell( 9  , 0.6 , iconv( 'UTF-8','cp874' , "โทร : 0-2424-3555"),0 ,'L' );

}else if($type_doc=='4'){

$pdf->setXY(1.5,2.0);
$pdf->MultiCell( 9  , 0.6 , iconv( 'UTF-8','cp874' , "บริษัท โนเบิล เมด จำกัด"),0 ,'L' );

$pdf->setXY(1.5,2.6);
$pdf->MultiCell( 9  , 0.6 , iconv( 'UTF-8','cp874' , "73 ซอยจรัญสนิทวงศ์ 89/2"),0 ,'L' );

$pdf->setXY(1.5,3.2);
$pdf->MultiCell( 9  , 0.6 , iconv( 'UTF-8','cp874' , "แขวงบางอ้อ เขตบางพลัด กรุงเทพ ฯ 10700"),0 ,'L' );

$pdf->setXY(1.5,3.8);
$pdf->MultiCell( 9  , 0.6 , iconv( 'UTF-8','cp874' , "โทร : 0-2880-5566"),0 ,'L' );

}

$pdf->SetFont('angsana','B',20);

$pdf->setXY(7.0,5.6);
$pdf->MultiCell( 9  , 0.6 , iconv( 'UTF-8','cp874' , "$delivery_name"),0 ,'L' );
$pdf->SetFont('angsa','',20);

$pdf->setXY(7.0,6.2);
$pdf->MultiCell( 9  , 0.6 , iconv( 'UTF-8','cp874' , "โทร :"),0 ,'L' );


$pdf->setXY(8.4,6.2);
$pdf->MultiCell( 9  , 0.6 , iconv( 'UTF-8','cp874' , "$tel"),0 ,'L' );

$pdf->setXY(7.0,6.8);
$pdf->MultiCell(8.0, 0.6 , iconv( 'UTF-8','cp874' , "$address1"),0 ,'L' );




$pdf->setXY(11.0,10.9);
$pdf->MultiCell( 9  , 0.6 , iconv( 'UTF-8','cp874' , "$ref_id #"),0 ,'L' );

$pdf->SetFont('angsa','',18);

if($type_doc=='3'){

$pdf->setXY(1.5,11.4);
$pdf->MultiCell( 9  , 0.6 , iconv( 'UTF-8','cp874' , "บริษัท ออลล์เวล ไลฟ์ จำกัด"),0 ,'L' );

$pdf->setXY(1.5,12.0);
$pdf->MultiCell( 9  , 0.6 , iconv( 'UTF-8','cp874' , "73,75 ซอยจรัญสนิทวงศ์ 89/2"),0 ,'L' );

$pdf->setXY(1.5,12.6);
$pdf->MultiCell( 9  , 0.6 , iconv( 'UTF-8','cp874' , "แขวงบางอ้อ เขตบางพลัด กรุงเทพ ฯ 10700"),0 ,'L' );

$pdf->setXY(1.5,13.2);
$pdf->MultiCell( 9  , 0.6 , iconv( 'UTF-8','cp874' , "โทร : 0-2424-3555"),0 ,'L' );

}else if($type_doc=='4'){

$pdf->setXY(1.5,11.4);
$pdf->MultiCell( 9  , 0.6 , iconv( 'UTF-8','cp874' , "บริษัท โนเบิล เมด จำกัด"),0 ,'L' );

$pdf->setXY(1.5,12.0);
$pdf->MultiCell( 9  , 0.6 , iconv( 'UTF-8','cp874' , "73 ซอยจรัญสนิทวงศ์ 89/2"),0 ,'L' );

$pdf->setXY(1.5,12.6);
$pdf->MultiCell( 9  , 0.6 , iconv( 'UTF-8','cp874' , "แขวงบางอ้อ เขตบางพลัด กรุงเทพ ฯ 10700"),0 ,'L' );

$pdf->setXY(1.5,13.2);
$pdf->MultiCell( 9  , 0.6 , iconv( 'UTF-8','cp874' , "โทร : 0-2880-5566"),0 ,'L' );

}


$pdf->SetFont('angsana','B',20);

$pdf->setXY(7.0,14.8);
$pdf->MultiCell( 9  , 0.6 , iconv( 'UTF-8','cp874' , "$delivery_name"),0 ,'L' );
$pdf->SetFont('angsa','',20);

$pdf->setXY(7.0,15.4);
$pdf->MultiCell( 9  , 0.6 , iconv( 'UTF-8','cp874' , "โทร :"),0 ,'L' );


$pdf->setXY(8.4,15.4);
$pdf->MultiCell( 9  , 0.6 , iconv( 'UTF-8','cp874' , "$tel"),0 ,'L' );

$pdf->setXY(7.0,16.0);
$pdf->MultiCell(8.0, 0.6 , iconv( 'UTF-8','cp874' , "$address1"),0 ,'L' );


$pdf->Output();
?>


