
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

$ref_id = (string)($objResult["ref_id"] ?? $ref_id);
$delivery_name = (string)($objResult["customer_name9"] ?? '');
$tel = (string)($objResult["customer_tel9"] ?? '');
$address1 = (string)($objResult["address_name9"] ?? '');




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




$pdf->Output();
?>


