
<?php
//header("Content-Type: image/png");


//header("Content-Disposition: attachment; filename=สรุปงานแผนกบริการลูกค้า.png");


define('FPDF_FONTPATH','font/');
 
require('fpdf.php');

$ref_id=$_GET["ref_id"];

include"dbconnect.php";

$strSQL = "SELECT * FROM tb_register_data  WHERE ref_id = '".$ref_id."' ";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);

$strSQL15 = "SELECT SUM(amount) AS amount_1 FROM hos__subso WHERE ref_idd = '".$ref_id."' ";
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResult15= mysqli_fetch_array($objQuery15);

$summary_1=$objResult15['amount_1'];
$summary= number_format( $summary_1,2)."";



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
$delivery_name =$objResult["customer_name"];
$customer_tel =$objResult["customer_tel"];
$address1 =$objResult["address_name"];



$pdf=new FPDF( 'L' , 'cm' , 'A4' );
$pdf->AddFont('angsa','','angsa.php');
$pdf->AddFont('angsana','B','angsab.php');


 

$pdf->AddPage();

$pdf->SetFont('angsa','',24);
$pdf->setXY(25.5,1.0);
$pdf->MultiCell( 9  ,1.0, iconv( 'UTF-8','cp874' , "$ref_id #"),0 ,'L' );



$pdf->setXY(2.5,2.0);
$pdf->MultiCell(12.0,1.1, iconv( 'UTF-8','cp874' , "บริษัท ออลล์เวล ไลฟ์ จำกัด"),0 ,'L' );

$pdf->setXY(2.5,3.0);
$pdf->MultiCell(12.0,1.1, iconv( 'UTF-8','cp874' , "73,75 ซอยจรัญสนิทวงศ์ 89/2"),0 ,'L' );

$pdf->setXY(2.5,4.0);
$pdf->MultiCell(12.0,1.0, iconv( 'UTF-8','cp874' , "แขวงบางอ้อ เขตบางพลัด กรุงเทพ ฯ 10700"),0 ,'L' );

$pdf->setXY(2.5,5.0);
$pdf->MultiCell(12.0,1.0, iconv( 'UTF-8','cp874' , "โทร : 0-2424-3555"),0 ,'L' );

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


