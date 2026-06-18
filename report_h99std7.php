
<?php
//header("Content-Type: image/png");


//header("Content-Disposition: attachment; filename=สรุปงานแผนกบริการลูกค้า.png");


define('FPDF_FONTPATH','font/');
 
require('fpdf.php');

$ref_id=$_GET["ref_id"];

include"dbconnect.php";

$strSQL = "SELECT * FROM tb_delivery_print  WHERE ref_id = '".$ref_id."' ";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);


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

$ref_id=$objResult["ref_id"];
$delivery_name =$objResult["customer_name7"];
$tel =$objResult["customer_tel7"];
$address1 =$objResult["address_name7"];




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


