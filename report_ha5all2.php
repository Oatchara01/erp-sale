
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

$strSQL1 = "SELECT type_doc FROM hos__so  WHERE ref_id = '".$ref_id."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die(mysqli_error());
$objResult1 = mysqli_fetch_array($objQuery1);


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



$type_doc=$objResult1["type_doc"];
$ref_id=$objResult["ref_id"];
$delivery_name =$objResult["customer_name2"];
$tel =$objResult["customer_tel2"];
$address1 =$objResult["address_name2"];



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


