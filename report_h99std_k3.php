
<?php
//header("Content-Type: image/png");


//header("Content-Disposition: attachment; filename=à¸ªà¸£à¸¸à¸›à¸‡à¸²à¸™à¹à¸œà¸™à¸à¸šà¸£à¸´à¸à¸²à¸£à¸¥à¸¹à¸à¸„à¹‰à¸².png");


define('FPDF_FONTPATH','font/');
 
require('fpdf.php');

$ref_id=$_GET["ref_id"];

include"dbconnect.php";

$strSQL = "SELECT * FROM tb_delivery_print  WHERE ref_id = '".$ref_id."' ";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);


$ttt = substr($ref_id,0,2);

if($ttt=='BR'){
	$strSQL15 = "SELECT SUM(amount) AS amount_1 FROM hos__subbr WHERE ref_idd_br = '".$ref_id."' ";
}else{
	$strSQL15 = "SELECT SUM(amount) AS amount_1 FROM hos__subso WHERE ref_idd = '".$ref_id."' ";
}
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResult15= mysqli_fetch_array($objQuery15);

$summary_1=$objResult15['amount_1'];
$summary= number_format( $summary_1,2)."";



date_default_timezone_set("Asia/Bangkok");
function pdf_text($text)
{
	$converted = @iconv('UTF-8', 'cp874//IGNORE', (string)$text);
	return ($converted === false) ? '' : $converted;
}

function DateThai($strDate)
	{
		$strYear = date("Y",strtotime($strDate))+543;
		$strMonth= date("n",strtotime($strDate));
		$strDay= date("j",strtotime($strDate));
		$strMonthCut = Array("","à¸¡.à¸„.","à¸.à¸ž.","à¸¡à¸µ.à¸„.","à¹€à¸¡.à¸¢.","à¸ž.à¸„.","à¸¡à¸´.à¸¢.","à¸.à¸„.","à¸ª.à¸„.","à¸.à¸¢.","à¸•.à¸„.","à¸ž.à¸¢.","à¸˜.à¸„.");
		$strMonthThai=$strMonthCut[$strMonth];
		return "$strDay $strMonthThai $strYear";
	}




$ref_id=$objResult["ref_id"];
$delivery_name =$objResult["customer_name3"];
$tel =$objResult["customer_tel3"];
$address1 =$objResult["address_name3"];




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