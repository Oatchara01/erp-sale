<?php

define('FPDF_FONTPATH','font/');
 
require('fpdf1.php');

$ref_id_br=$_GET["ref_id_br"];
$product_id=$_GET["product_code"];
$doc_no=$_GET["doc_no"];
$year_no=$_GET["year_no"];
$iv_nocheck ="$doc_no/$year_no" ;





include"dbconnect.php";

$strSQL = "SELECT * FROM hos__change  WHERE ref_id = '".$ref_id_br."' ";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT * FROM  tb_product  WHERE product_ID = '".$product_id."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);

$strSQL2 = "SELECT * FROM  tb_product_leaflet  WHERE product_id = '".$product_id."' ";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);


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





//$newDate = date("d-m-Y", strtotime($start_date));
$ref_id_br=$objResult["ref_id"];
$date_br = DateThai($objResult["date_change"]);
$customer =$objResult["customer"];
$address =$objResult["address"];
$iv_no =$objResult["iv_no"];
$type_doc =$objResult["company"];

$unit_name = $objResult1["unit_name"];

$product_name = $objResult2["product_name"];
$ingredient1 = $objResult2["ingredient1"];
$ingredient2 = $objResult2["ingredient2"];
$ingredient3 = $objResult2["ingredient3"];
$ingredient4 = $objResult2["ingredient4"];
$ingredient5 = $objResult2["ingredient5"];
$ingredient6 = $objResult2["ingredient6"];
$ingredient7 = $objResult2["ingredient7"];
$ingredient8 = $objResult2["ingredient8"];
$ingredient9 = $objResult2["ingredient9"];
$ingredient10 = $objResult2["ingredient10"];
$ingredient11 = $objResult2["ingredient11"];
$ingredient12 = $objResult2["ingredient12"];
$ingredient13 = $objResult2["ingredient13"];
$ingredient14 = $objResult2["ingredient14"];
$ingredient15 = $objResult2["ingredient15"];
$ingredient16 = $objResult2["ingredient16"];
$ingredient17 = $objResult2["ingredient17"];
$ingredient18 = $objResult2["ingredient18"];
$ingredient19 = $objResult2["ingredient19"];
$ingredient20 = $objResult2["ingredient20"];
$ingredient21 = $objResult2["ingredient21"];
$ingredient22 = $objResult2["ingredient22"];
$ingredient23 = $objResult2["ingredient23"];
$ingredient24 = $objResult2["ingredient24"];
$ingredient25 = $objResult2["ingredient25"];
$ingredient26 = $objResult2["ingredient26"];
$ingredient27 = $objResult2["ingredient27"];
$ingredient28 = $objResult2["ingredient28"];
$ingredient29 = $objResult2["ingredient29"];



$pdf=new FPDF( 'P' , 'cm' , 'A6' );
$pdf->AddFont('angsa','','angsa.php');
$pdf->AddFont('angsana','B','angsab.php');
$pdf->AddFont('times','','times.php');

 
$pdf->AddPage();

if($type_doc =='1'){
$pdf->SetFont('angsana','B',16);

$pdf->setXY(2.0,1.0);
$pdf->MultiCell( 9  , 0.6 , iconv( 'UTF-8','cp874' , "บริษัท ออลล์เวล ไลฟ์ จำกัด"),0 ,'L' );

$pdf->SetFont('angsa','',13);
$pdf->setXY(2.0,1.6);
$pdf->MultiCell( 9  , 0.4 , iconv( 'UTF-8','cp874' , "73,75 ซอยจรัญสนิทวงศ์ 89/2 แขวงบางอ้อ"),0 ,'L' );

$pdf->setXY(2.0,2.0);
$pdf->MultiCell( 9  , 0.4 , iconv( 'UTF-8','cp874' , "เขตบางพลัด กรุงเทพมหานคร 10700"),0 ,'L' );

$pdf->setXY(2.0,2.4);
$pdf->MultiCell( 9  , 0.4 , iconv( 'UTF-8','cp874' , "โทร : 0-2424-3555 (อัตโนมัติ)"),0 ,'L' );

$pdf->setXY(2.0,2.8);
$pdf->MultiCell( 9  , 0.4 , iconv( 'UTF-8','cp874' , "แฟ็กซ์ : 0-2424-3322"),0 ,'L' );

$pdf->Image("img/allwell_logo.png",10.0,1.0,5.0,1.5);

$pdf->SetFont('angsana','B',20);

$pdf->setXY(10.2,2.5);
$pdf->MultiCell(9.0,1.6, iconv( 'UTF-8','cp874' , "ใบรายการตรวจทานสินค้า"),0 ,'L' );

$pdf->SetFont('angsa','',18);

$pdf->setXY(10.8,3.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "(Product Check list)"),0 ,'L' );



$pdf->SetFont('angsana','B',16);

$pdf->setXY(13.6,1.0);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "ALLWELL LIFE CO., LTD."),0 ,'R' );

$pdf->SetFont('angsa','',13);

$pdf->setXY(13.6,1.6);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "73,75 Soi Charansanitwong 89/2,"),0 ,'R' );

$pdf->setXY(13.6,2.0);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Bang-Or, Bang-Plad,Bankok 10700"),0 ,'R' );

$pdf->setXY(13.6,2.4);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "TEL : 0-2424-3555 (Auto)"),0 ,'R' );

$pdf->setXY(13.6,2.8);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "FAX : 0-2424-3322"),0 ,'R' );

}

if($type_doc =='2'){
$pdf->SetFont('angsana','B',16);

$pdf->setXY(2.0,1.0);
$pdf->MultiCell( 9  , 0.6 , iconv( 'UTF-8','cp874' , "บริษัท โนเบิล เมด จำกัด"),0 ,'L' );

$pdf->SetFont('angsa','',13);
$pdf->setXY(2.0,1.6);
$pdf->MultiCell( 9  , 0.4 , iconv( 'UTF-8','cp874' , "73 ซอยจรัญสนิทวงศ์ 89/2 แขวงบางอ้อ"),0 ,'L' );

$pdf->setXY(2.0,2.0);
$pdf->MultiCell( 9  , 0.4 , iconv( 'UTF-8','cp874' , "เขตบางพลัด กรุงเทพมหานคร 10700"),0 ,'L' );

$pdf->setXY(2.0,2.4);
$pdf->MultiCell( 9  , 0.4 , iconv( 'UTF-8','cp874' , "โทร : 0-2880-5566 (อัตโนมัติ)"),0 ,'L' );

$pdf->setXY(2.0,2.8);
$pdf->MultiCell( 9  , 0.4 , iconv( 'UTF-8','cp874' , "แฟ็กซ์ : 0-2880-5533"),0 ,'L' );

$pdf->Image("img/nbm_select.png",10.5,1.0,4.0,2.0);

$pdf->SetFont('angsana','B',20);

$pdf->setXY(10.2,2.5);
$pdf->MultiCell(9.0,1.6, iconv( 'UTF-8','cp874' , "ใบรายการตรวจทานสินค้า"),0 ,'L' );

$pdf->SetFont('angsa','',18);

$pdf->setXY(10.8,3.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "(Product Check list)"),0 ,'L' );



$pdf->SetFont('angsana','B',16);

$pdf->setXY(13.6,1.0);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "NOBLE MED CO.,LTD"),0 ,'R' );

$pdf->SetFont('angsa','',13);

$pdf->setXY(13.6,1.6);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "73 Soi Charansanitwong 89/2,"),0 ,'R' );

$pdf->setXY(13.6,2.0);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Bang-Or, Bang-Plad,Bankok 10700"),0 ,'R' );

$pdf->setXY(13.6,2.4);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "TEL : 0-2880-5566 (Auto)"),0 ,'R' );

$pdf->setXY(13.6,2.8);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "FAX : 0-2880-5533"),0 ,'R' );

}


$pdf->setXY(2.0,4.6);
$pdf->Cell(10.5,0.7, "",1,1,"c" );

$pdf->setXY(12.5,4.6);
$pdf->Cell(5.0,0.7, "",1,1,"c" );

$pdf->setXY(17.5,4.6);
$pdf->Cell(5.0,0.7, "",1,1,"c" );

$pdf->setXY(2.0,5.3);
$pdf->Cell(15.5,0.7, "",1,1,"c" );

$pdf->setXY(17.5,5.3);
$pdf->Cell(5.0,0.7, "",1,1,"c" );



$pdf->setXY(2.0,6.0);
$pdf->Cell(10.5,0.7, "",1,1,"c" );

$pdf->setXY(12.5,6.0);
$pdf->Cell(5.0,0.7, "",1,1,"c" );

$pdf->setXY(17.5,6.0);
$pdf->Cell(2.5,0.7, "",1,1,"c" );

$pdf->setXY(20.0,6.0);
$pdf->Cell(2.5,0.7, "",1,1,"c" );


$pdf->setXY(2.0,6.7);
$pdf->Cell(10.5,0.7, "",1,1,"c" );

$pdf->setXY(12.5,6.7);
$pdf->Cell(5.0,0.7, "",1,1,"c" );

$pdf->setXY(17.5,6.7);
$pdf->Cell(2.5,0.7, "",1,1,"c" );

$pdf->setXY(20.0,6.7);
$pdf->Cell(2.5,0.7, "",1,1,"c" );

$pdf->setXY(2.0,7.4);
$pdf->Cell(10.5,0.7, "",1,1,"c" );

$pdf->setXY(12.5,7.4);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(13.7,7.4);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(14.9,7.4);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(16.1,7.4);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(17.3,7.4);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(18.5,7.4);
$pdf->Cell(4.0,0.7, "",1,1,"c" );



$pdf->SetFont('angsa','',15); 


$pdf->setXY(2.05,6.7);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "$product_name"),0 ,'L' );

$pdf->setXY(18.7,6.7);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "1"),0 ,'L' );

$pdf->setXY(20.8,6.7);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "$unit_name"),0 ,'L' );


$pdf->SetFont('angsa','',13); 

$pdf->setXY(6.6,7.25);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "รายการตรวจเช็ค"),0 ,'L' );

$pdf->setXY(6.95,7.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Checklist"),0 ,'L' );

$pdf->setXY(12.75,7.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Stock"),0 ,'L' );

$pdf->setXY(13.8,7.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Service"),0 ,'L' );

$pdf->setXY(15.0,7.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Service"),0 ,'L' );

$pdf->setXY(16.12,7.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Engineer"),0 ,'L' );

$pdf->setXY(17.5,7.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Stock"),0 ,'L' );

$pdf->setXY(19.9,7.25);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "หมายเหตุ"),0 ,'L' );

$pdf->setXY(19.95,7.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Remarks"),0 ,'L' );


$pdf->setXY(7.05,5.85);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "รายการ"),0 ,'L' );

$pdf->setXY(6.9,6.1);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Description"),0 ,'L' );


$pdf->setXY(14.0,5.85);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "หมายเลขเครื่อง"),0 ,'L' );

$pdf->setXY(14.25,6.1);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Serial No."),0 ,'L' );

$pdf->setXY(18.4,5.85);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "จำนวน"),0 ,'L' );

$pdf->setXY(18.65,6.1);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Qty"),0 ,'L' );

$pdf->setXY(20.8,5.85);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "หน่วย"),0 ,'L' );

$pdf->setXY(20.9,6.1);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Unit"),0 ,'L' );


$pdf->SetFont('angsa','',14); 

$pdf->setXY(2.05,4.7);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "ชื่อลูกค้า"),0 ,'L' );

$pdf->setXY(2.05,5.4);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "ที่อยู่"),0 ,'L' );

$pdf->SetFont('angsa','',15); 

$pdf->setXY(3.2,5.4);
$pdf->MultiCell(14.0,0.6, iconv( 'UTF-8','cp874' , "$address"),0 ,'L' );



$pdf->SetFont('angsana','B',14);


$pdf->setXY(3.2,4.7);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "$customer"),0 ,'L' );

$pdf->SetFont('angsa','',14); 

$pdf->setXY(12.55,4.7);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "วันที่"),0 ,'L' );


$pdf->setXY(14.2,4.7);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "$date_br"),0 ,'L' );

$pdf->setXY(17.55,4.7);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "เลขที่"),0 ,'L' );

$pdf->setXY(19.5,4.7);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "$iv_nocheck"),0 ,'L' );


$pdf->setXY(17.55,5.4);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "อ้่างอิงเอกสารเลขที่"),0 ,'L' );

$pdf->setXY(20.25,5.4);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "$iv_no"),0 ,'L' );



$pdf->setXY(2.0,8.1);
$pdf->Cell(10.5,9.2, "",1,1,"c" );

$pdf->setXY(12.5,8.1);
$pdf->Cell(1.2,9.2, "",1,1,"c" );

$pdf->setXY(13.7,8.1);
$pdf->Cell(1.2,9.2, "",1,1,"c" );

$pdf->setXY(14.9,8.1);
$pdf->Cell(1.2,9.2, "",1,1,"c" );

$pdf->setXY(16.1,8.1);
$pdf->Cell(1.2,9.2, "",1,1,"c" );

$pdf->setXY(17.3,8.1);
$pdf->Cell(1.2,9.2, "",1,1,"c" );

$pdf->setXY(18.5,8.1);
$pdf->Cell(4.0,9.2, "",1,1,"c" );

$pdf->setXY(2.05,8.2);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8','cp874' , "$ingredient1"),0 ,'L' );

$pdf->setXY(12.9,8.3);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(14.09,8.3);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(15.3,8.3);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(16.5,8.3);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(17.7,8.3);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(2.0,8.8);
$pdf->Cell(16.5,0,'','T',0,'C',0);


$pdf->setXY(2.05,8.9);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8','cp874' , "$ingredient2"),0 ,'L' );

$pdf->setXY(12.9,9.0);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(14.09,9.0);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(15.3,9.0);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(16.5,9.0);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(17.7,9.0);
$pdf->Cell(0.35,0.35, "",1,1,"c" );


$pdf->setXY(2.0,9.5);
$pdf->Cell(16.5,0,'','T',0,'C',0);


$pdf->setXY(2.05,9.5);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8','cp874' , "$ingredient3"),0 ,'L' );

$pdf->setXY(12.9,9.7);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(14.09,9.7);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(15.3,9.7);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(16.5,9.7);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(17.7,9.7);
$pdf->Cell(0.35,0.35, "",1,1,"c" );


$pdf->setXY(2.0,10.1);
$pdf->Cell(16.5,0,'','T',0,'C',0);





$pdf->setXY(2.05,10.1);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8','cp874' , "$ingredient4"),0 ,'L' );

$pdf->setXY(12.9,10.3);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(14.09,10.3);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(15.3,10.3);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(16.5,10.3);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(17.7,10.3);
$pdf->Cell(0.35,0.35, "",1,1,"c" );


$pdf->setXY(2.0,10.7);
$pdf->Cell(16.5,0,'','T',0,'C',0);



$pdf->setXY(2.05,10.7);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8','cp874' , "$ingredient5"),0 ,'L' );

$pdf->setXY(12.9,10.85);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(14.09,10.85);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(15.3,10.85);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(16.5,10.85);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(17.7,10.85);
$pdf->Cell(0.35,0.35, "",1,1,"c" );


$pdf->setXY(2.0,11.3);
$pdf->Cell(16.5,0,'','T',0,'C',0);



$pdf->setXY(2.05,11.3);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8','cp874' , "$ingredient6"),0 ,'L' );

$pdf->setXY(12.9,11.45);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(14.09,11.45);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(15.3,11.45);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(16.5,11.45);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(17.7,11.45);
$pdf->Cell(0.35,0.35, "",1,1,"c" );


$pdf->setXY(2.0,11.9);
$pdf->Cell(16.5,0,'','T',0,'C',0);


$pdf->setXY(2.05,11.9);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8','cp874' , "$ingredient7"),0 ,'L' );

$pdf->setXY(12.9,12.05);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(14.09,12.05);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(15.3,12.05);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(16.5,12.05);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(17.7,12.05);
$pdf->Cell(0.35,0.35, "",1,1,"c" );


$pdf->setXY(2.0,12.5);
$pdf->Cell(16.5,0,'','T',0,'C',0);


$pdf->setXY(2.05,12.5);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8','cp874' , "$ingredient8"),0 ,'L' );

$pdf->setXY(12.9,12.65);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(14.09,12.65);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(15.3,12.65);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(16.5,12.65);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(17.7,12.65);
$pdf->Cell(0.35,0.35, "",1,1,"c" );


$pdf->setXY(2.0,13.1);
$pdf->Cell(16.5,0,'','T',0,'C',0);



$pdf->setXY(2.05,13.1);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8','cp874' , "$ingredient9"),0 ,'L' );

$pdf->setXY(12.9,13.25);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(14.09,13.25);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(15.3,13.25);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(16.5,13.25);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(17.7,13.25);
$pdf->Cell(0.35,0.35, "",1,1,"c" );


$pdf->setXY(2.0,13.7);
$pdf->Cell(16.5,0,'','T',0,'C',0);



$pdf->setXY(2.05,13.7);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8','cp874' , "$ingredient10"),0 ,'L' );

$pdf->setXY(12.9,13.85);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(14.09,13.85);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(15.3,13.85);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(16.5,13.85);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(17.7,13.85);
$pdf->Cell(0.35,0.35, "",1,1,"c" );


$pdf->setXY(2.0,14.3);
$pdf->Cell(16.5,0,'','T',0,'C',0);


$pdf->setXY(2.05,14.3);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8','cp874' , "$ingredient11"),0 ,'L' );

$pdf->setXY(12.9,14.45);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(14.09,14.45);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(15.3,14.45);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(16.5,14.45);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(17.7,14.45);
$pdf->Cell(0.35,0.35, "",1,1,"c" );


$pdf->setXY(2.0,14.9);
$pdf->Cell(16.5,0,'','T',0,'C',0);



$pdf->setXY(2.05,14.9);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8','cp874' , "$ingredient12"),0 ,'L' );

$pdf->setXY(12.9,15.05);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(14.09,15.05);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(15.3,15.05);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(16.5,15.05);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(17.7,15.05);
$pdf->Cell(0.35,0.35, "",1,1,"c" );


$pdf->setXY(2.0,15.5);
$pdf->Cell(16.5,0,'','T',0,'C',0);



$pdf->setXY(2.05,15.5);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8','cp874' , "$ingredient13"),0 ,'L' );

$pdf->setXY(12.9,15.65);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(14.09,15.65);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(15.3,15.65);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(16.5,15.65);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(17.7,15.65);
$pdf->Cell(0.35,0.35, "",1,1,"c" );


$pdf->setXY(2.0,16.1);
$pdf->Cell(16.5,0,'','T',0,'C',0);




$pdf->setXY(2.05,16.1);
$pdf->Cell(15,0.6, iconv( 'UTF-8','cp874' , "$ingredient14"),0 ,'L' );

$pdf->setXY(12.9,16.25);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(14.09,16.25);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(15.3,16.25);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(16.5,16.25);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(17.7,16.25);
$pdf->Cell(0.35,0.35, "",1,1,"c" );


$pdf->setXY(2.0,16.7);
$pdf->Cell(16.5,0,'','T',0,'C',0);


$pdf->setXY(2.05,16.7);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8','cp874' , "$ingredient15"),0 ,'L' ); 

$pdf->setXY(12.9,16.85);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(14.09,16.85);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(15.3,16.85);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(16.5,16.85);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(17.7,16.85);
$pdf->Cell(0.35,0.35, "",1,1,"c" );











$pdf->setXY(2.0,17.3);
$pdf->Cell(10.5,0.7, "",1,1,"c" );

$pdf->setXY(12.5,17.3);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(13.7,17.3);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(14.9,17.3);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(16.1,17.3);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(17.3,17.3);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(18.5,17.3);
$pdf->Cell(4.0,0.7, "",1,1,"c" );


$pdf->setXY(7.0,17.4);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "ผู้ดำเนินการ"),0 ,'L' );


$pdf->setXY(2.0,18.1);
$pdf->Cell(1.5,0.7, "",1,1,"c" );

$pdf->SetFont('angsana','B',12);

$pdf->setXY(2.05,18.1);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "ส่งสินค้า"),0 ,'L' );

$pdf->SetFont('angsa','',12); 

$pdf->setXY(3.9,18.1);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "ได้รับสินค้าข้างต้นในสภาพเรียบร้อยสมบูรณ์"),0 ,'L' );

$pdf->setXY(3.9,18.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Received the above mentioned good order and condition"),0 ,'L' );

$pdf->setXY(2.05,19.2);
$pdf->Cell(9.0,0.6, iconv( 'UTF-8','cp874' , "ผู้รับ...........................................................................วันที่.........................................................."),0 ,'L' );

$pdf->setXY(2.05,19.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Received by"),0 ,'L' );

$pdf->setXY(7.9,19.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Date"),0 ,'L' );

$pdf->setXY(12.55,19.2);
$pdf->Cell(9.0,0.6, iconv( 'UTF-8','cp874' , "ผู้ส่ง...........................................................................วันที่..................................................."),0 ,'L' );

$pdf->setXY(12.55,19.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Delivery by"),0 ,'L' );

$pdf->setXY(18.25,19.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Date"),0 ,'L' );





$pdf->setXY(2.0,18.1);
$pdf->Cell(10.5,2.0, "",1,1,"c" );

$pdf->setXY(12.5,18.1);
$pdf->Cell(10.0,2.0, "",1,1,"c" );

$pdf->setXY(2.0,20.1);
$pdf->Cell(10.5,2.0, "",1,1,"c" );

$pdf->setXY(12.5,20.1);
$pdf->Cell(10.0,2.0, "",1,1,"c" );

$pdf->setXY(2.0,20.1);
$pdf->Cell(1.5,0.7, "",1,1,"c" );

$pdf->SetFont('angsana','B',12);

$pdf->setXY(2.05,20.1);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "รับคืนสินค้า"),0 ,'L' );

$pdf->SetFont('angsa','',12); 
$pdf->setXY(3.9,20.1);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "กรณีสินค้าไม่สมบูรณ์"),0 ,'L' );

$pdf->setXY(3.9,20.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "........................................................................................................................."),0 ,'L' );


$pdf->setXY(2.05,21.2);
$pdf->Cell(9.0,0.6, iconv( 'UTF-8','cp874' , "ผู้ส่งคืน...........................................................................วันที่......................................................"),0 ,'L' );

$pdf->setXY(2.05,21.6);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Returned by"),0 ,'L' );

$pdf->setXY(8.0,21.6);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Date"),0 ,'L' );




$pdf->setXY(12.55,20.1);
$pdf->Cell(9.0,0.6, iconv( 'UTF-8','cp874' , "ผู้ส่งคืน......................................................................วันที่..................................................."),0 ,'L' );

$pdf->setXY(12.55,20.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Returned by"),0 ,'L' );

$pdf->setXY(18.25,20.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Date"),0 ,'L' );



$pdf->setXY(12.55,21.2);
$pdf->Cell(9.0,0.6, iconv( 'UTF-8','cp874' , "ผู้รับสินค้า..................................................................วันที่.................................................."),0 ,'L' );

$pdf->setXY(12.55,21.6);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Received by"),0 ,'L' );

$pdf->setXY(18.25,21.6);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Date"),0 ,'L' );





$pdf->setXY(2.0,22.1);
$pdf->Cell(10.5,2.0, "",1,1,"c" );

$pdf->setXY(12.5,22.1);
$pdf->Cell(10.0,2.0, "",1,1,"c" );

$pdf->setXY(2.5,22.1);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "ได้รับสินค้าในสภาพเรียบร้อยสมบูรณ์"),0 ,'L' );

$pdf->setXY(2.05,23.2);
$pdf->Cell(9.0,0.6, iconv( 'UTF-8','cp874' , "แผนกบริการลูกค้า........................................................วันที่......................................................"),0 ,'L' );

$pdf->setXY(2.05,23.6);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Checked by"),0 ,'L' );

$pdf->setXY(8.0,23.6);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Date"),0 ,'L' );


$pdf->setXY(12.55,22.1);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "สินค้า"),0 ,'L' );

$pdf->setXY(15.5,22.6);
$pdf->Cell(0.2,0.2, "",1,1,"c" );

$pdf->setXY(15.9,22.4);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "สมบูรณ์"),0 ,'L' );

$pdf->setXY(18.25,22.6);
$pdf->Cell(0.2,0.2, "",1,1,"c" );

$pdf->setXY(18.59,22.4);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "ไม่สมบูรณ์"),0 ,'L' );



$pdf->setXY(12.55,23.2);
$pdf->Cell(9.0,0.6, iconv( 'UTF-8','cp874' , "คลังสินค้า..................................................................วันที่.................................................."),0 ,'L' );

$pdf->setXY(12.55,23.6);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Stock"),0 ,'L' );

$pdf->setXY(18.25,23.6);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Date"),0 ,'L' );





$pdf->setXY(2.0,24.1);
$pdf->Cell(1.9,0.7, "",1,1,"c" );

$pdf->setXY(3.9,24.1);
$pdf->Cell(8.6,0.7, "",1,1,"c" );

$pdf->setXY(12.5,24.1);
$pdf->Cell(10.0,0.7, "",1,1,"c" );



$pdf->SetFont('angsana','B',12);

$pdf->setXY(2.05,24.1);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "สำหรับบริษัทฯ"),0 ,'L' );

$pdf->setXY(4.2,24.1);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "ส่งสินค้า"),0 ,'L' );

$pdf->setXY(12.55,24.1);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "รับคืนสินค้า"),0 ,'L' );



$pdf->SetFont('angsa','',12); 

$pdf->setXY(2.0,24.8);
$pdf->Cell(5.25,3.2, "",1,1,"c" );

$pdf->setXY(7.25,24.8);
$pdf->Cell(5.25,3.2, "",1,1,"c" );

$pdf->setXY(12.5,24.8);
$pdf->Cell(5.0,3.2, "",1,1,"c" );
$pdf->setXY(17.5,24.8);
$pdf->Cell(5.0,3.2, "",1,1,"c" );




$pdf->setXY(2.05,24.9);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "1......................................................................"),0 ,'L' );

$pdf->setXY(2.05,25.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "2......................................................................"),0 ,'L' );

$pdf->setXY(2.05,26.1);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "3......................................................................"),0 ,'L' );

$pdf->setXY(2.05,26.7);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "4......................................................................"),0 ,'L' );

$pdf->setXY(2.05,27.3);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "5......................................................................"),0 ,'L' );





$pdf->setXY(7.25,24.9);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "1......................................................................"),0 ,'L' );

$pdf->setXY(7.25,25.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "2......................................................................"),0 ,'L' );

$pdf->setXY(7.25,26.1);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "3......................................................................"),0 ,'L' );

$pdf->setXY(7.25,26.7);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "4......................................................................"),0 ,'L' );

$pdf->setXY(7.25,27.3);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "5......................................................................"),0 ,'L' );



$pdf->setXY(12.55,24.9);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "1...................................................................."),0 ,'L' );

$pdf->setXY(12.55,25.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "2...................................................................."),0 ,'L' );

$pdf->setXY(12.55,26.1);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "3...................................................................."),0 ,'L' );

$pdf->setXY(12.55,26.7);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "4...................................................................."),0 ,'L' );

$pdf->setXY(12.55,27.3);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "5...................................................................."),0 ,'L' );



$pdf->setXY(17.55,24.9);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "1...................................................................."),0 ,'L' );

$pdf->setXY(17.55,25.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "2...................................................................."),0 ,'L' );

$pdf->setXY(17.55,26.1);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "3...................................................................."),0 ,'L' );

$pdf->setXY(17.55,26.7);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "4...................................................................."),0 ,'L' );

$pdf->setXY(17.55,27.3);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "5...................................................................."),0 ,'L' );





$pdf->SetFont('angsa','',11); 

$pdf->setXY(2.05,28.0);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "อนุมัติวันที่ 12 พ.ค.2558"),0 ,'L' );

$pdf->setXY(13.6,28.0);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "FM-OF-01:Rev.2"),0 ,'R' );






if($ingredient16 !=''){



$pdf->AddPage();


if($type_doc =='1'){
$pdf->SetFont('angsana','B',16);

$pdf->setXY(2.0,1.0);
$pdf->MultiCell( 9  , 0.6 , iconv( 'UTF-8','cp874' , "บริษัท ฟาร์ ทริลเลียน จำกัด"),0 ,'L' );

$pdf->SetFont('angsa','',13);
$pdf->setXY(2.0,1.6);
$pdf->MultiCell( 9  , 0.4 , iconv( 'UTF-8','cp874' , "73,75 ซอยจรัญสนิทวงศ์ 89/2 แขวงบางอ้อ"),0 ,'L' );

$pdf->setXY(2.0,2.0);
$pdf->MultiCell( 9  , 0.4 , iconv( 'UTF-8','cp874' , "เขตบางพลัด กรุงเทพมหานคร 10700"),0 ,'L' );

$pdf->setXY(2.0,2.4);
$pdf->MultiCell( 9  , 0.4 , iconv( 'UTF-8','cp874' , "โทร : 0-2424-3555 (อัตโนมัติ)"),0 ,'L' );

$pdf->setXY(2.0,2.8);
$pdf->MultiCell( 9  , 0.4 , iconv( 'UTF-8','cp874' , "แฟ็กซ์ : 0-2424-3322"),0 ,'L' );

$pdf->Image("img/ptl_70.png",10.5,1.0,4.0,2.0);

$pdf->SetFont('angsana','B',20);

$pdf->setXY(10.2,2.5);
$pdf->MultiCell(9.0,1.6, iconv( 'UTF-8','cp874' , "ใบรายการตรวจทานสินค้า"),0 ,'L' );

$pdf->SetFont('angsa','',18);

$pdf->setXY(10.8,3.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "(Product Check list)"),0 ,'L' );



$pdf->SetFont('angsana','B',16);

$pdf->setXY(13.6,1.0);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "PHAR TRILLION CO.,LTD"),0 ,'R' );

$pdf->SetFont('angsa','',13);

$pdf->setXY(13.6,1.6);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "73,75 Soi Charansanitwong 89/2,"),0 ,'R' );

$pdf->setXY(13.6,2.0);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Bang-Or, Bang-Plad,Bankok 10700"),0 ,'R' );

$pdf->setXY(13.6,2.4);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "TEL : 0-2424-3555 (Auto)"),0 ,'R' );

$pdf->setXY(13.6,2.8);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "FAX : 0-2424-3322"),0 ,'R' );

}

if($type_doc =='2'){
$pdf->SetFont('angsana','B',16);

$pdf->setXY(2.0,1.0);
$pdf->MultiCell( 9  , 0.6 , iconv( 'UTF-8','cp874' , "บริษัท โนเบิล เมด จำกัด"),0 ,'L' );

$pdf->SetFont('angsa','',13);
$pdf->setXY(2.0,1.6);
$pdf->MultiCell( 9  , 0.4 , iconv( 'UTF-8','cp874' , "73 ซอยจรัญสนิทวงศ์ 89/2 แขวงบางอ้อ"),0 ,'L' );

$pdf->setXY(2.0,2.0);
$pdf->MultiCell( 9  , 0.4 , iconv( 'UTF-8','cp874' , "เขตบางพลัด กรุงเทพมหานคร 10700"),0 ,'L' );

$pdf->setXY(2.0,2.4);
$pdf->MultiCell( 9  , 0.4 , iconv( 'UTF-8','cp874' , "โทร : 0-2880-5566 (อัตโนมัติ)"),0 ,'L' );

$pdf->setXY(2.0,2.8);
$pdf->MultiCell( 9  , 0.4 , iconv( 'UTF-8','cp874' , "แฟ็กซ์ : 0-2880-5533"),0 ,'L' );

$pdf->Image("img/nbm_select.png",10.5,1.0,4.0,2.0);

$pdf->SetFont('angsana','B',20);

$pdf->setXY(10.2,2.5);
$pdf->MultiCell(9.0,1.6, iconv( 'UTF-8','cp874' , "ใบรายการตรวจทานสินค้า"),0 ,'L' );

$pdf->SetFont('angsa','',18);

$pdf->setXY(10.8,3.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "(Product Check list)"),0 ,'L' );



$pdf->SetFont('angsana','B',16);

$pdf->setXY(13.6,1.0);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "NOBLE MED CO.,LTD"),0 ,'R' );

$pdf->SetFont('angsa','',13);

$pdf->setXY(13.6,1.6);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "73 Soi Charansanitwong 89/2,"),0 ,'R' );

$pdf->setXY(13.6,2.0);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Bang-Or, Bang-Plad,Bankok 10700"),0 ,'R' );

$pdf->setXY(13.6,2.4);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "TEL : 0-2880-5566 (Auto)"),0 ,'R' );

$pdf->setXY(13.6,2.8);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "FAX : 0-2880-5533"),0 ,'R' );

}


$pdf->setXY(2.0,4.6);
$pdf->Cell(10.5,0.7, "",1,1,"c" );

$pdf->setXY(12.5,4.6);
$pdf->Cell(5.0,0.7, "",1,1,"c" );

$pdf->setXY(17.5,4.6);
$pdf->Cell(5.0,0.7, "",1,1,"c" );

$pdf->setXY(2.0,5.3);
$pdf->Cell(15.5,0.7, "",1,1,"c" );

$pdf->setXY(17.5,5.3);
$pdf->Cell(5.0,0.7, "",1,1,"c" );



$pdf->setXY(2.0,6.0);
$pdf->Cell(10.5,0.7, "",1,1,"c" );

$pdf->setXY(12.5,6.0);
$pdf->Cell(5.0,0.7, "",1,1,"c" );

$pdf->setXY(17.5,6.0);
$pdf->Cell(2.5,0.7, "",1,1,"c" );

$pdf->setXY(20.0,6.0);
$pdf->Cell(2.5,0.7, "",1,1,"c" );


$pdf->setXY(2.0,6.7);
$pdf->Cell(10.5,0.7, "",1,1,"c" );

$pdf->setXY(12.5,6.7);
$pdf->Cell(5.0,0.7, "",1,1,"c" );

$pdf->setXY(17.5,6.7);
$pdf->Cell(2.5,0.7, "",1,1,"c" );

$pdf->setXY(20.0,6.7);
$pdf->Cell(2.5,0.7, "",1,1,"c" );

$pdf->setXY(2.0,7.4);
$pdf->Cell(10.5,0.7, "",1,1,"c" );

$pdf->setXY(12.5,7.4);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(13.7,7.4);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(14.9,7.4);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(16.1,7.4);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(17.3,7.4);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(18.5,7.4);
$pdf->Cell(4.0,0.7, "",1,1,"c" );



$pdf->SetFont('angsa','',15); 


$pdf->setXY(2.05,6.7);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "$product_name"),0 ,'L' );

$pdf->setXY(18.7,6.7);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "1"),0 ,'L' );

$pdf->setXY(20.8,6.7);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "$unit_name"),0 ,'L' );


$pdf->SetFont('angsa','',13); 

$pdf->setXY(6.6,7.25);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "รายการตรวจเช็ค"),0 ,'L' );

$pdf->setXY(6.95,7.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Checklist"),0 ,'L' );

$pdf->setXY(12.75,7.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Stock"),0 ,'L' );

$pdf->setXY(13.8,7.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Service"),0 ,'L' );

$pdf->setXY(15.0,7.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Service"),0 ,'L' );

$pdf->setXY(16.12,7.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Engineer"),0 ,'L' );

$pdf->setXY(17.5,7.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Stock"),0 ,'L' );

$pdf->setXY(19.9,7.25);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "หมายเหตุ"),0 ,'L' );

$pdf->setXY(19.95,7.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Remarks"),0 ,'L' );


$pdf->setXY(7.05,5.85);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "รายการ"),0 ,'L' );

$pdf->setXY(6.9,6.1);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Description"),0 ,'L' );


$pdf->setXY(14.0,5.85);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "หมายเลขเครื่อง"),0 ,'L' );

$pdf->setXY(14.25,6.1);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Serial No."),0 ,'L' );

$pdf->setXY(18.4,5.85);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "จำนวน"),0 ,'L' );

$pdf->setXY(18.65,6.1);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Qty"),0 ,'L' );

$pdf->setXY(20.8,5.85);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "หน่วย"),0 ,'L' );

$pdf->setXY(20.9,6.1);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Unit"),0 ,'L' );


$pdf->SetFont('angsa','',14); 

$pdf->setXY(2.05,4.7);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "ชื่อลูกค้า"),0 ,'L' );

$pdf->setXY(2.05,5.4);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "ที่อยู่"),0 ,'L' );

$pdf->SetFont('angsa','',15); 

$pdf->setXY(3.2,5.4);
$pdf->MultiCell(14.0,0.6, iconv( 'UTF-8','cp874' , "$address"),0 ,'L' );



$pdf->SetFont('angsana','B',14);


$pdf->setXY(3.2,4.7);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "$customer"),0 ,'L' );

$pdf->SetFont('angsa','',14); 

$pdf->setXY(12.55,4.7);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "วันที่"),0 ,'L' );


$pdf->setXY(14.2,4.7);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "$date_br"),0 ,'L' );

$pdf->setXY(17.55,4.7);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "เลขที่"),0 ,'L' );

$pdf->setXY(19.5,4.7);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "$iv_nocheck"),0 ,'L' );


$pdf->setXY(17.55,5.4);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "อ้่างอิงเอกสารเลขที่"),0 ,'L' );

$pdf->setXY(20.25,5.4);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "$iv_no"),0 ,'L' );



$pdf->setXY(2.0,8.1);
$pdf->Cell(10.5,9.2, "",1,1,"c" );

$pdf->setXY(12.5,8.1);
$pdf->Cell(1.2,9.2, "",1,1,"c" );

$pdf->setXY(13.7,8.1);
$pdf->Cell(1.2,9.2, "",1,1,"c" );

$pdf->setXY(14.9,8.1);
$pdf->Cell(1.2,9.2, "",1,1,"c" );

$pdf->setXY(16.1,8.1);
$pdf->Cell(1.2,9.2, "",1,1,"c" );

$pdf->setXY(17.3,8.1);
$pdf->Cell(1.2,9.2, "",1,1,"c" );

$pdf->setXY(18.5,8.1);
$pdf->Cell(4.0,9.2, "",1,1,"c" );

$pdf->setXY(2.05,8.2);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8','cp874' , "$ingredient16"),0 ,'L' );

$pdf->setXY(12.9,8.3);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(14.09,8.3);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(15.3,8.3);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(16.5,8.3);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(17.7,8.3);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(2.0,8.8);
$pdf->Cell(16.5,0,'','T',0,'C',0);


$pdf->setXY(2.05,8.9);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8','cp874' , "$ingredient17"),0 ,'L' );

$pdf->setXY(12.9,9.0);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(14.09,9.0);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(15.3,9.0);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(16.5,9.0);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(17.7,9.0);
$pdf->Cell(0.35,0.35, "",1,1,"c" );


$pdf->setXY(2.0,9.5);
$pdf->Cell(16.5,0,'','T',0,'C',0);


$pdf->setXY(2.05,9.5);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8','cp874' , "$ingredient18"),0 ,'L' );

$pdf->setXY(12.9,9.7);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(14.09,9.7);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(15.3,9.7);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(16.5,9.7);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(17.7,9.7);
$pdf->Cell(0.35,0.35, "",1,1,"c" );


$pdf->setXY(2.0,10.1);
$pdf->Cell(16.5,0,'','T',0,'C',0);





$pdf->setXY(2.05,10.1);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8','cp874' , "$ingredient19"),0 ,'L' );

$pdf->setXY(12.9,10.3);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(14.09,10.3);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(15.3,10.3);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(16.5,10.3);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(17.7,10.3);
$pdf->Cell(0.35,0.35, "",1,1,"c" );


$pdf->setXY(2.0,10.7);
$pdf->Cell(16.5,0,'','T',0,'C',0);



$pdf->setXY(2.05,10.7);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8','cp874' , "$ingredient20"),0 ,'L' );

$pdf->setXY(12.9,10.85);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(14.09,10.85);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(15.3,10.85);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(16.5,10.85);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(17.7,10.85);
$pdf->Cell(0.35,0.35, "",1,1,"c" );


$pdf->setXY(2.0,11.3);
$pdf->Cell(16.5,0,'','T',0,'C',0);



$pdf->setXY(2.05,11.3);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8','cp874' , "$ingredient21"),0 ,'L' );

$pdf->setXY(12.9,11.45);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(14.09,11.45);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(15.3,11.45);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(16.5,11.45);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(17.7,11.45);
$pdf->Cell(0.35,0.35, "",1,1,"c" );


$pdf->setXY(2.0,11.9);
$pdf->Cell(16.5,0,'','T',0,'C',0);


$pdf->setXY(2.05,11.9);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8','cp874' , "$ingredient22"),0 ,'L' );

$pdf->setXY(12.9,12.05);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(14.09,12.05);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(15.3,12.05);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(16.5,12.05);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(17.7,12.05);
$pdf->Cell(0.35,0.35, "",1,1,"c" );


$pdf->setXY(2.0,12.5);
$pdf->Cell(16.5,0,'','T',0,'C',0);


$pdf->setXY(2.05,12.5);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8','cp874' , "$ingredient23"),0 ,'L' );

$pdf->setXY(12.9,12.65);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(14.09,12.65);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(15.3,12.65);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(16.5,12.65);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(17.7,12.65);
$pdf->Cell(0.35,0.35, "",1,1,"c" );


$pdf->setXY(2.0,13.1);
$pdf->Cell(16.5,0,'','T',0,'C',0);



$pdf->setXY(2.05,13.1);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8','cp874' , "$ingredient24"),0 ,'L' );

$pdf->setXY(12.9,13.25);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(14.09,13.25);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(15.3,13.25);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(16.5,13.25);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(17.7,13.25);
$pdf->Cell(0.35,0.35, "",1,1,"c" );


$pdf->setXY(2.0,13.7);
$pdf->Cell(16.5,0,'','T',0,'C',0);



$pdf->setXY(2.05,13.7);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8','cp874' , "$ingredient25"),0 ,'L' );

$pdf->setXY(12.9,13.85);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(14.09,13.85);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(15.3,13.85);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(16.5,13.85);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(17.7,13.85);
$pdf->Cell(0.35,0.35, "",1,1,"c" );


$pdf->setXY(2.0,14.3);
$pdf->Cell(16.5,0,'','T',0,'C',0);


$pdf->setXY(2.05,14.3);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8','cp874' , "$ingredient26"),0 ,'L' );

$pdf->setXY(12.9,14.45);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(14.09,14.45);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(15.3,14.45);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(16.5,14.45);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(17.7,14.45);
$pdf->Cell(0.35,0.35, "",1,1,"c" );


$pdf->setXY(2.0,14.9);
$pdf->Cell(16.5,0,'','T',0,'C',0);



$pdf->setXY(2.05,14.9);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8','cp874' , "$ingredient27"),0 ,'L' );

$pdf->setXY(12.9,15.05);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(14.09,15.05);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(15.3,15.05);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(16.5,15.05);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(17.7,15.05);
$pdf->Cell(0.35,0.35, "",1,1,"c" );


$pdf->setXY(2.0,15.5);
$pdf->Cell(16.5,0,'','T',0,'C',0);



$pdf->setXY(2.05,15.5);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8','cp874' , "$ingredient28"),0 ,'L' );

$pdf->setXY(12.9,15.65);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(14.09,15.65);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(15.3,15.65);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(16.5,15.65);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(17.7,15.65);
$pdf->Cell(0.35,0.35, "",1,1,"c" );


$pdf->setXY(2.0,16.1);
$pdf->Cell(16.5,0,'','T',0,'C',0);




$pdf->setXY(2.05,16.1);
$pdf->MultiCell(10.5,0.6, iconv( 'UTF-8','cp874' , "$ingredient29"),0 ,'L' );

$pdf->setXY(12.9,16.25);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(14.09,16.25);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(15.3,16.25);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(16.5,16.25);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(17.7,16.25);
$pdf->Cell(0.35,0.35, "",1,1,"c" );


/*$pdf->setXY(2.0,16.7);
$pdf->Cell(16.5,0,'','T',0,'C',0);*/


$pdf->setXY(2.05,16.7);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8','cp874' , ""),0 ,'L' ); 

/*$pdf->setXY(12.9,16.85);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(14.09,16.85);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(15.3,16.85);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(16.5,16.85);
$pdf->Cell(0.35,0.35, "",1,1,"c" );

$pdf->setXY(17.7,16.85);
$pdf->Cell(0.35,0.35, "",1,1,"c" );*/











$pdf->setXY(2.0,17.3);
$pdf->Cell(10.5,0.7, "",1,1,"c" );

$pdf->setXY(12.5,17.3);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(13.7,17.3);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(14.9,17.3);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(16.1,17.3);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(17.3,17.3);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(18.5,17.3);
$pdf->Cell(4.0,0.7, "",1,1,"c" );


$pdf->setXY(7.0,17.4);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "ผู้ดำเนินการ"),0 ,'L' );


$pdf->setXY(2.0,18.1);
$pdf->Cell(1.5,0.7, "",1,1,"c" );

$pdf->SetFont('angsana','B',12);

$pdf->setXY(2.05,18.1);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "ส่งสินค้า"),0 ,'L' );

$pdf->SetFont('angsa','',12); 

$pdf->setXY(3.9,18.1);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "ได้รับสินค้าข้างต้นในสภาพเรียบร้อยสมบูรณ์"),0 ,'L' );

$pdf->setXY(3.9,18.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Received the above mentioned good order and condition"),0 ,'L' );

$pdf->setXY(2.05,19.2);
$pdf->Cell(9.0,0.6, iconv( 'UTF-8','cp874' , "ผู้รับ...........................................................................วันที่.........................................................."),0 ,'L' );

$pdf->setXY(2.05,19.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Received by"),0 ,'L' );

$pdf->setXY(7.9,19.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Date"),0 ,'L' );

$pdf->setXY(12.55,19.2);
$pdf->Cell(9.0,0.6, iconv( 'UTF-8','cp874' , "ผู้ส่ง...........................................................................วันที่..................................................."),0 ,'L' );

$pdf->setXY(12.55,19.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Delivery by"),0 ,'L' );

$pdf->setXY(18.25,19.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Date"),0 ,'L' );





$pdf->setXY(2.0,18.1);
$pdf->Cell(10.5,2.0, "",1,1,"c" );

$pdf->setXY(12.5,18.1);
$pdf->Cell(10.0,2.0, "",1,1,"c" );

$pdf->setXY(2.0,20.1);
$pdf->Cell(10.5,2.0, "",1,1,"c" );

$pdf->setXY(12.5,20.1);
$pdf->Cell(10.0,2.0, "",1,1,"c" );

$pdf->setXY(2.0,20.1);
$pdf->Cell(1.5,0.7, "",1,1,"c" );

$pdf->SetFont('angsana','B',12);

$pdf->setXY(2.05,20.1);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "รับคืนสินค้า"),0 ,'L' );

$pdf->SetFont('angsa','',12); 
$pdf->setXY(3.9,20.1);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "กรณีสินค้าไม่สมบูรณ์"),0 ,'L' );

$pdf->setXY(3.9,20.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "........................................................................................................................."),0 ,'L' );


$pdf->setXY(2.05,21.2);
$pdf->Cell(9.0,0.6, iconv( 'UTF-8','cp874' , "ผู้ส่งคืน...........................................................................วันที่......................................................"),0 ,'L' );

$pdf->setXY(2.05,21.6);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Returned by"),0 ,'L' );

$pdf->setXY(8.0,21.6);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Date"),0 ,'L' );




$pdf->setXY(12.55,20.1);
$pdf->Cell(9.0,0.6, iconv( 'UTF-8','cp874' , "ผู้ส่งคืน......................................................................วันที่..................................................."),0 ,'L' );

$pdf->setXY(12.55,20.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Returned by"),0 ,'L' );

$pdf->setXY(18.25,20.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Date"),0 ,'L' );



$pdf->setXY(12.55,21.2);
$pdf->Cell(9.0,0.6, iconv( 'UTF-8','cp874' , "ผู้รับสินค้า..................................................................วันที่.................................................."),0 ,'L' );

$pdf->setXY(12.55,21.6);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Received by"),0 ,'L' );

$pdf->setXY(18.25,21.6);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Date"),0 ,'L' );





$pdf->setXY(2.0,22.1);
$pdf->Cell(10.5,2.0, "",1,1,"c" );

$pdf->setXY(12.5,22.1);
$pdf->Cell(10.0,2.0, "",1,1,"c" );

$pdf->setXY(2.5,22.1);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "ได้รับสินค้าในสภาพเรียบร้อยสมบูรณ์"),0 ,'L' );

$pdf->setXY(2.05,23.2);
$pdf->Cell(9.0,0.6, iconv( 'UTF-8','cp874' , "แผนกบริการลูกค้า........................................................วันที่......................................................"),0 ,'L' );

$pdf->setXY(2.05,23.6);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Checked by"),0 ,'L' );

$pdf->setXY(8.0,23.6);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Date"),0 ,'L' );


$pdf->setXY(12.55,22.1);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "สินค้า"),0 ,'L' );

$pdf->setXY(15.5,22.6);
$pdf->Cell(0.2,0.2, "",1,1,"c" );

$pdf->setXY(15.9,22.4);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "สมบูรณ์"),0 ,'L' );

$pdf->setXY(18.25,22.6);
$pdf->Cell(0.2,0.2, "",1,1,"c" );

$pdf->setXY(18.59,22.4);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "ไม่สมบูรณ์"),0 ,'L' );



$pdf->setXY(12.55,23.2);
$pdf->Cell(9.0,0.6, iconv( 'UTF-8','cp874' , "คลังสินค้า..................................................................วันที่.................................................."),0 ,'L' );

$pdf->setXY(12.55,23.6);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Stock"),0 ,'L' );

$pdf->setXY(18.25,23.6);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Date"),0 ,'L' );





$pdf->setXY(2.0,24.1);
$pdf->Cell(1.9,0.7, "",1,1,"c" );

$pdf->setXY(3.9,24.1);
$pdf->Cell(8.6,0.7, "",1,1,"c" );

$pdf->setXY(12.5,24.1);
$pdf->Cell(10.0,0.7, "",1,1,"c" );



$pdf->SetFont('angsana','B',12);

$pdf->setXY(2.05,24.1);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "สำหรับบริษัทฯ"),0 ,'L' );

$pdf->setXY(4.2,24.1);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "ส่งสินค้า"),0 ,'L' );

$pdf->setXY(12.55,24.1);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "รับคืนสินค้า"),0 ,'L' );



$pdf->SetFont('angsa','',12); 

$pdf->setXY(2.0,24.8);
$pdf->Cell(5.25,3.2, "",1,1,"c" );

$pdf->setXY(7.25,24.8);
$pdf->Cell(5.25,3.2, "",1,1,"c" );

$pdf->setXY(12.5,24.8);
$pdf->Cell(5.0,3.2, "",1,1,"c" );
$pdf->setXY(17.5,24.8);
$pdf->Cell(5.0,3.2, "",1,1,"c" );




$pdf->setXY(2.05,24.9);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "1......................................................................"),0 ,'L' );

$pdf->setXY(2.05,25.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "2......................................................................"),0 ,'L' );

$pdf->setXY(2.05,26.1);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "3......................................................................"),0 ,'L' );

$pdf->setXY(2.05,26.7);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "4......................................................................"),0 ,'L' );

$pdf->setXY(2.05,27.3);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "5......................................................................"),0 ,'L' );





$pdf->setXY(7.25,24.9);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "1......................................................................"),0 ,'L' );

$pdf->setXY(7.25,25.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "2......................................................................"),0 ,'L' );

$pdf->setXY(7.25,26.1);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "3......................................................................"),0 ,'L' );

$pdf->setXY(7.25,26.7);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "4......................................................................"),0 ,'L' );

$pdf->setXY(7.25,27.3);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "5......................................................................"),0 ,'L' );



$pdf->setXY(12.55,24.9);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "1...................................................................."),0 ,'L' );

$pdf->setXY(12.55,25.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "2...................................................................."),0 ,'L' );

$pdf->setXY(12.55,26.1);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "3...................................................................."),0 ,'L' );

$pdf->setXY(12.55,26.7);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "4...................................................................."),0 ,'L' );

$pdf->setXY(12.55,27.3);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "5...................................................................."),0 ,'L' );



$pdf->setXY(17.55,24.9);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "1...................................................................."),0 ,'L' );

$pdf->setXY(17.55,25.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "2...................................................................."),0 ,'L' );

$pdf->setXY(17.55,26.1);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "3...................................................................."),0 ,'L' );

$pdf->setXY(17.55,26.7);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "4...................................................................."),0 ,'L' );

$pdf->setXY(17.55,27.3);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "5...................................................................."),0 ,'L' );





$pdf->SetFont('angsa','',11); 

$pdf->setXY(2.05,28.0);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "อนุมัติวันที่ 12 พ.ค.2558"),0 ,'L' );

$pdf->setXY(13.6,28.0);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "FM-OF-01:Rev.2"),0 ,'R' );







}





$pdf->Output();
?>


