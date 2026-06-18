
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

$ttt = substr($ref_id,0,2);

if($ttt=='SM'){

$strSQL16 = "SELECT type_company FROM hos__smp WHERE ref_idsmp = '".$ref_id."' ";
$objQuery16 = mysqli_query($conn,$strSQL16);
$objResult16= mysqli_fetch_array($objQuery16);	

$company = $objResult16["type_company"];	
	
}else if($ttt=='SO'){
$strSQL16 = "SELECT type_doc FROM hos__so WHERE ref_id = '".$ref_id."' ";
$objQuery16 = mysqli_query($conn,$strSQL16);
$objResult16= mysqli_fetch_array($objQuery16);	

$company = $objResult16["type_doc"];	
	
}else if($ttt=='BR'){
	
$strSQL16 = "SELECT company FROM hos__br WHERE ref_id_br = '".$ref_id."' ";
$objQuery16 = mysqli_query($conn,$strSQL16);
$objResult16= mysqli_fetch_array($objQuery16);	

$company = $objResult16["company"];
	
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
$ref_id=$objResult["ref_id"];
$delivery_name =$objResult["customer_name"];
$tel =$objResult["customer_tel"];
$address1 =$objResult["address_name"];




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


