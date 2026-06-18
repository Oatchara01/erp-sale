<?php

define('FPDF_FONTPATH','font/');
 
require('fpdf.php');

$ref_id=$_GET["ref_id"];



include"dbconnect.php";

$strSQL = "SELECT * FROM hos__change  WHERE ref_id = '".$ref_id."' ";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);

$strSQL1 = "SELECT * FROM (hos__subchange LEFT JOIN tb_product ON hos__subchange.product_ID=tb_product.product_id) WHERE ref_idd = '".$ref_id."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

$strSQL15 = "SELECT SUM(amount) AS amount_1 FROM hos__subchange WHERE ref_idd = '".$ref_id."' and count_sale !='0' ";
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResult15= mysqli_fetch_array($objQuery15);

$strSQL16 = "SELECT SUM(amount) AS amount_1 FROM hos__subchange WHERE ref_idd = '".$ref_id."' and count_stock !='0' ";
$objQuery16 = mysqli_query($conn,$strSQL16);
$objResult16 = mysqli_fetch_array($objQuery16);

$summary_stock=$objResult16['amount_1'];
$summary_sale=$objResult15['amount_1'];

$summary_1 = $summary_sale-$summary_stock;

$summary= number_format( $summary_1,2)."";



date_default_timezone_set("Asia/Bangkok");
function DateThai($strDate)
	{
		$strYear = date("Y",strtotime($strDate))+543;
		$strMonth= date("n",strtotime($strDate));
		$strDay= date("j",strtotime($strDate));
		$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		$strMonthThai=$strMonthCut[$strMonth];
	    $strYear1 =substr( $strYear , 2 , 2 );
		return "$strDay $strMonthThai $strYear1";
	}


$ref_id_br=$objResult["ref_id"];
$date_br = DateThai($objResult["iv_date"]);
$customer =$objResult["customer"];
$address =$objResult["address"];
$delivery_tel =$objResult["delivery_tel"];
$delivery_address =$objResult["delivery_address"];

$objective =$objResult["objective"];

$sale = $objResult["add_by"];
$sale_code = $objResult["sale_code"];
$approve = $objResult["approve"];
$sale_name = "$sale / $sale_code";
$sale_comment = $objResult["sale_comment"];



$month = date('m');
$day = date('d');
$year = date('Y');

$today1 = $year . '-' . $month . '-' . $day;



$today  = DateThai($today1);


$pdf=new FPDF( 'P' , 'cm' , 'A6' );
$pdf->AddFont('angsa','','angsa.php');
$pdf->AddFont('angsana','B','angsab.php');
$pdf->AddFont('times','','times.php');

 
$pdf->AddPage();

$pdf->SetFont('angsa','',16);

$pdf->setXY( 3.6,3.6);
$pdf->MultiCell( 9  , 0.6 , iconv( 'UTF-8//IGNORE','cp874//IGNORE' , "$customer"),0 ,'L' );

$pdf->setXY(14.1,3.7);
$pdf->MultiCell( 9  , 0.6 , iconv( 'UTF-8','cp874' , "$date_br"),0 ,'L' );


$pdf->setXY(3.4,4.6);
$pdf->MultiCell(8.0, 0.6 , iconv( 'UTF-8//IGNORE','cp874//IGNORE' , "$address"),0 ,'L' );

$pdf->setXY(14.1,5.2);
$pdf->MultiCell(6.5, 0.6 , iconv( 'UTF-8//IGNORE','cp874//IGNORE' , "$delivery_address"),0 ,'L' );


$pdf->setXY( 3.4,6.2);
$pdf->MultiCell(7.0, 0.6 , iconv( 'UTF-8','cp874' , "$delivery_tel"),0 ,'L' );

$pdf->setX(17.0);
$pdf->MultiCell( 9.0,2.0, iconv( 'UTF-8','cp874' , ""),0 ,'L' );



$i=1;
while($objResult1 = mysqli_fetch_array($objQuery1))
{

$sum_amount1  =$objResult1["amount"];

if($objResult1["count_sale"]=='0.00'){
$sum_amount =number_format( -$sum_amount1,2)."";;	
}else{
$sum_amount = number_format( $sum_amount1,2)."";
}
$price_per_unit_1  =$objResult1["price"];
$price_per_unit= number_format( $price_per_unit_1,2)."";

$product_code1  =$objResult1["access_code"];
$product_code = substr($product_code1,0,8);	
$product_name1  =$objResult1["access_name"];
$product_name = substr($product_name1,0,45);

if($objResult1["count_sale"]=='0.00'){
$sale_countF  = $objResult1["count_stock"];
$sale_count = "-$sale_countF";
}else{
$sale_count  = $objResult1["count_sale"];
}

$unit_name  =$objResult1["unit_name"];
$sale_remark = $objResult1["sale_remark"];


$pdf->setX(1.5);
$pdf->MultiCell( 9.0,0, iconv( 'UTF-8','cp874' , "$i"),0 ,'L' );


$pdf->setX(2.3);
$pdf->MultiCell( 9.0,0, iconv( 'UTF-8','cp874' , "$product_code"),0 ,'L' );
$pdf->SetFont('angsa','',14);
$pdf->setX(4.7);
$pdf->Cell(10,0.0, iconv( 'UTF-8','cp874' , "$product_name"),0 ,'L' );
$pdf->SetFont('angsa','',16);
$pdf->setX(14.3);
$pdf->MultiCell(1.9,0, iconv( 'UTF-8','cp874' , "$sale_count $unit_name"),0 ,'R' );

$pdf->setX(16.4);
$pdf->MultiCell(2.0,0, iconv( 'UTF-8','cp874' , "$price_per_unit"),0 ,'R' );


$pdf->setX(18.6);
$pdf->MultiCell(2.0,0, iconv( 'UTF-8','cp874' , "$sum_amount"),0 ,'R' );

$pdf->setX(18.3);
$pdf->MultiCell( 9.0,0.3, iconv( 'UTF-8','cp874' , ""),0 ,'L' );

$pdf->setX(4.7);
$pdf->MultiCell(13,0.5, iconv( 'UTF-8','cp874' , "$sale_remark"),0 ,'L' );
	
	$pdf->setX(18.3);
$pdf->MultiCell( 9.0,0.5, iconv( 'UTF-8','cp874' , ""),0 ,'L' );

$i++;


}

$pdf->setXY(18.6,18.6);
$pdf->MultiCell(2.0,0, iconv( 'UTF-8','cp874' , "$summary"),0 ,'R' );



$pdf->setXY(8.8,20.0);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "$today"),0 ,'L' );

$pdf->setXY(4.1,20.8);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "$sale_name"),0 ,'L' );

$pdf->setXY(8.8,24.8);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "$today"),0 ,'L' );

$pdf->setXY(4.1,25.3);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "ชลชินี มิตรสันติสุข"),0 ,'L' );



if ($objective=='1'){

$pdf->setXY(14.0,19.4);
$pdf->MultiCell(7.0,0.6, iconv( 'UTF-8','cp874' , "แลกเปลี่ยนสินค้า $objective_des4"),0 ,'L' );


}





/* $pdf->setXY(12.3,24.2);
$pdf->MultiCell(8.0,0.6, iconv( 'UTF-8','cp874' , "$sale_comment"),0 ,'L' );*/





$pdf->Output();
?>


