<?php

define('FPDF_FONTPATH','font/');
 
require('fpdf1.php');

$ref_id_br=$_GET["ref_id_br"];
$product_id=$_GET["product_code"];
$doc_no=$_GET["doc_no"];
$year_no=$_GET["year_no"];
$iv_nocheck ="$doc_no/$year_no" ;

include"dbconnect.php";

$id_ccos = substr($ref_id_br,0,2);	
	
if($id_ccos=='BR'){
	
$strSQL = "SELECT * FROM hos__br  WHERE ref_id_br = '".$ref_id_br."' ";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);
	
}else if($id_ccos=='CH'){
	
$strSQL = "SELECT * FROM hos__change  WHERE ref_id = '".$ref_id_br."' ";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);
	
}else{

$strSQL = "SELECT * FROM so__main  WHERE ref_id = '".$ref_id_br."' ";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);
	
}



$strSQL1 = "SELECT * FROM  tb_product  WHERE product_ID = '".$product_id."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);

$strSQL2 = "SELECT * FROM  tb_product_leaflet  WHERE product_id = '".$product_id."' ";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);

$strSQL3 = "SELECT * FROM  tb_product_checklist  WHERE ref_id = '".$ref_id_br."' and doc_no ='".$doc_no."' and year_no ='".$year_no."'";
$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);

$sql1 = "SELECT *   FROM tb_product_checklis where ref_pcc = '".$objResult3["ref_pc"]."' and type_emp ='ST' and go_back ='1'";
$qry1 = mysqli_query($conn,$sql1) or die(mysqli_error());
$rs1 = mysqli_fetch_assoc($qry1);

$sql2 = "SELECT *   FROM tb_product_checklis where ref_pcc = '".$objResult3["ref_pc"]."' and type_emp ='EN' and go_back ='1'";
$qry2 = mysqli_query($conn,$sql2) or die(mysqli_error());
$rs2 = mysqli_fetch_assoc($qry2);

$sql3 = "SELECT *   FROM tb_product_checklis where ref_pcc = '".$objResult3["ref_pc"]."' and type_emp ='CS' and go_back ='1'";
$qry3 = mysqli_query($conn,$sql3) or die(mysqli_error());
$rs3 = mysqli_fetch_assoc($qry3);

$sql4 = "SELECT *   FROM tb_product_checklis where ref_pcc = '".$objResult3["ref_pc"]."' and type_emp ='CS' and go_back ='2'";
$qry4 = mysqli_query($conn,$sql4) or die(mysqli_error());
$rs4 = mysqli_fetch_assoc($qry4);

$sql5 = "SELECT *   FROM tb_product_checklis where ref_pcc = '".$objResult3["ref_pc"]."' and type_emp ='EN' and go_back ='2'";
$qry5 = mysqli_query($conn,$sql5) or die(mysqli_error());
$rs5 = mysqli_fetch_assoc($qry5);

$sql6 = "SELECT *   FROM tb_product_checklis where ref_pcc = '".$objResult3["ref_pc"]."' and type_emp ='ST' and go_back ='2'";
$qry6 = mysqli_query($conn,$sql6) or die(mysqli_error());
$rs6 = mysqli_fetch_assoc($qry6);






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

if($id_ccos=='BR'){

$ref_id_br =$objResult["ref_id_br"];
$date_br = DateThai($objResult["date_br"]);
$customer =$objResult["customer"];
$address =$objResult["address"];
$iv_no =$objResult["iv_no"];
$type_doc =$objResult["company"];
	
}else if($id_ccos=='CH'){
	
$ref_id_br = $objResult["ref_id"];
$date_br = DateThai($objResult["date_change"]);
$customer =$objResult["customer"];
$address =$objResult["address"];
$iv_no =$objResult["iv_no"];
$type_doc =$objResult["company"];
	
	
}else{

$ref_id_br = $objResult["ref_id"];	
$date_br = DateThai($objResult["register_date"]);	
$customer =$objResult["billing_name"];
$address1 =$objResult["address1"];
$address2 =$objResult["address2"];
$address ="$address1 $address2";
$iv_no =$objResult["doc_no"];
$type_doc =$objResult["select_type_doc"];	
	
}




$unit_name = $objResult1["unit_name"];

$product_name = $objResult1["sol_name"];
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
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(19.7,7.4);
$pdf->Cell(2.8,0.7, "",1,1,"c" );



$pdf->SetFont('angsa','',15); 


$pdf->setXY(2.05,6.7);
$pdf->MultiCell(13.0,0.6, iconv( 'UTF-8','cp874' , "$product_name"),0 ,'L' );

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

$pdf->setXY(13.7,7.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Engineer"),0 ,'L' );

$pdf->setXY(15.0,7.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Service"),0 ,'L' );

$pdf->setXY(16.15,7.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Service"),0 ,'L' );

$pdf->setXY(17.3,7.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Engineer"),0 ,'L' );

$pdf->setXY(18.7,7.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Stock"),0 ,'L' );

$pdf->setXY(20.35,7.25);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "หมายเหตุ"),0 ,'L' );

$pdf->setXY(20.40,7.5);
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

$pdf->setXY(12.55,7.45);
$pdf->Cell(3.50,10.48, "",1,1,"c" );

$pdf->setXY(16.14,7.45);
$pdf->Cell(3.50,10.48, "",1,1,"c" );

$pdf->setXY(12.5,8.1);
$pdf->Cell(1.2,9.2, "",1,1,"c" );

$pdf->setXY(13.7,8.1);
$pdf->Cell(1.2,9.2, "",1,1,"c" );

$pdf->setXY(14.9,8.1);
$pdf->Cell(1.2,9.2, "",1,1,"c" );

$pdf->setXY(16.1,8.1);
$pdf->Cell(1.2,9.2, "",1,1,"c" );

$pdf->setXY(18.5,8.1);
$pdf->Cell(1.2,9.2, "",1,1,"c" );

$pdf->setXY(19.7,8.1);
$pdf->Cell(2.8,9.2, "",1,1,"c" );

$pdf->setXY(2.05,8.2);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8','cp874' , "$ingredient1"),0 ,'L' );

if($rs1["check1"]=='1'){
$pdf->Image("img/chk32.png",12.9,8.3,0.4,0.4);	
}else if($rs1["check1"]=='2'){
$pdf->Image("img/unc33.png",12.9,8.3,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",12.9,8.3,0.4,0.4);	
}


if($rs2["check1"]=='1'){
$pdf->Image("img/chk32.png",14.09,8.3,0.4,0.4);	
}else if($rs2["check1"]=='2'){
$pdf->Image("img/unc33.png",14.09,8.3,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",14.09,8.3,0.4,0.4);	
}


if($rs3["check1"]=='1'){
$pdf->Image("img/chk32.png",15.3,8.3,0.4,0.4);	
}else if($rs3["check1"]=='2'){
$pdf->Image("img/unc33.png",15.3,8.3,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",15.3,8.3,0.4,0.4);	
}



if($rs4["check1"]=='1'){
$pdf->Image("img/chk32.png",16.5,8.3,0.4,0.4);	
}else if($rs4["check1"]=='2'){
$pdf->Image("img/unc33.png",16.5,8.3,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",16.5,8.3,0.4,0.4);	
}


if($rs5["check1"]=='1'){
$pdf->Image("img/chk32.png",17.7,8.3,0.4,0.4);	
}else if($rs5["check1"]=='2'){
$pdf->Image("img/unc33.png",17.7,8.3,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",17.7,8.3,0.4,0.4);	
}

if($rs6["check1"]=='1'){
$pdf->Image("img/chk32.png",18.9,8.3,0.4,0.4);	
}else if($rs6["check1"]=='2'){
$pdf->Image("img/unc33.png",18.9,8.3,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",18.9,8.3,0.4,0.4);	
}

$pdf->setXY(2.0,8.8);
$pdf->Cell(17.7,0,'','T',0,'C',0);


$pdf->setXY(2.05,8.9);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8','cp874' , "$ingredient2"),0 ,'L' );

if($rs1["check2"]=='1'){
$pdf->Image("img/chk32.png",12.9,9.0,0.4,0.4);	
}else if($rs1["check2"]=='2'){
$pdf->Image("img/unc33.png",12.9,9.0,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",12.9,9.0,0.4,0.4);	
}


if($rs2["check2"]=='1'){
$pdf->Image("img/chk32.png",14.09,9.0,0.4,0.4);	
}else if($rs2["check2"]=='2'){
$pdf->Image("img/unc33.png",14.09,9.0,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",14.09,9.0,0.4,0.4);	
}


if($rs3["check2"]=='1'){
$pdf->Image("img/chk32.png",15.3,9.0,0.4,0.4);	
}else if($rs3["check2"]=='2'){
$pdf->Image("img/unc33.png",15.3,9.0,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",15.3,9.0,0.4,0.4);	
}



if($rs4["check2"]=='1'){
$pdf->Image("img/chk32.png",16.5,9.0,0.4,0.4);	
}else if($rs4["check2"]=='2'){
$pdf->Image("img/unc33.png",16.5,9.0,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",16.5,9.0,0.4,0.4);	
}


if($rs5["check2"]=='1'){
$pdf->Image("img/chk32.png",17.7,9.0,0.4,0.4);	
}else if($rs5["check2"]=='2'){
$pdf->Image("img/unc33.png",17.7,9.0,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",17.7,9.0,0.4,0.4);	
}

if($rs6["check2"]=='1'){
$pdf->Image("img/chk32.png",18.9,9.0,0.4,0.4);	
}else if($rs6["check2"]=='2'){
$pdf->Image("img/unc33.png",18.9,9.0,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",18.9,9.0,0.4,0.4);	
}

$pdf->setXY(2.0,9.5);
$pdf->Cell(17.7,0,'','T',0,'C',0);


$pdf->setXY(2.05,9.5);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8','cp874' , "$ingredient3"),0 ,'L' );

if($rs1["check3"]=='1'){
$pdf->Image("img/chk32.png",12.9,9.6,0.4,0.4);	
}else if($rs1["check3"]=='2'){
$pdf->Image("img/unc33.png",12.9,9.6,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",12.9,9.6,0.4,0.4);	
}


if($rs2["check3"]=='1'){
$pdf->Image("img/chk32.png",14.09,9.6,0.4,0.4);	
}else if($rs2["check3"]=='2'){
$pdf->Image("img/unc33.png",14.09,9.6,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",14.09,9.6,0.4,0.4);	
}


if($rs3["check3"]=='1'){
$pdf->Image("img/chk32.png",15.3,9.6,0.4,0.4);	
}else if($rs3["check3"]=='2'){
$pdf->Image("img/unc33.png",15.3,9.6,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",15.3,9.6,0.4,0.4);	
}



if($rs4["check3"]=='1'){
$pdf->Image("img/chk32.png",16.5,9.6,0.4,0.4);	
}else if($rs4["check3"]=='2'){
$pdf->Image("img/unc33.png",16.5,9.6,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",16.5,9.6,0.4,0.4);	
}


if($rs5["check3"]=='1'){
$pdf->Image("img/chk32.png",17.7,9.6,0.4,0.4);	
}else if($rs5["check3"]=='2'){
$pdf->Image("img/unc33.png",17.7,9.6,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",17.7,9.6,0.4,0.4);	
}

if($rs6["check3"]=='1'){
$pdf->Image("img/chk32.png",18.9,9.6,0.4,0.4);	
}else if($rs6["check3"]=='2'){
$pdf->Image("img/unc33.png",18.9,9.6,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",18.9,9.6,0.4,0.4);	
}

$pdf->setXY(2.0,10.1);
$pdf->Cell(17.7,0,'','T',0,'C',0);





$pdf->setXY(2.05,10.1);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8','cp874' , "$ingredient4"),0 ,'L' );

if($rs1["check4"]=='1'){
$pdf->Image("img/chk32.png",12.9,10.2,0.4,0.4);	
}else if($rs1["check4"]=='2'){
$pdf->Image("img/unc33.png",12.9,10.2,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",12.9,10.2,0.4,0.4);	
}


if($rs2["check4"]=='1'){
$pdf->Image("img/chk32.png",14.09,10.2,0.4,0.4);	
}else if($rs2["check4"]=='2'){
$pdf->Image("img/unc33.png",14.09,10.2,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",14.09,10.2,0.4,0.4);	
}


if($rs3["check4"]=='1'){
$pdf->Image("img/chk32.png",15.3,10.2,0.4,0.4);	
}else if($rs3["check4"]=='2'){
$pdf->Image("img/unc33.png",15.3,10.2,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",15.3,10.2,0.4,0.4);	
}



if($rs4["check4"]=='1'){
$pdf->Image("img/chk32.png",16.5,10.2,0.4,0.4);	
}else if($rs4["check4"]=='2'){
$pdf->Image("img/unc33.png",16.5,10.2,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",16.5,10.2,0.4,0.4);	
}


if($rs5["check4"]=='1'){
$pdf->Image("img/chk32.png",17.7,10.2,0.4,0.4);	
}else if($rs5["check4"]=='2'){
$pdf->Image("img/unc33.png",17.7,10.2,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",17.7,10.2,0.4,0.4);	
}

if($rs6["check4"]=='1'){
$pdf->Image("img/chk32.png",18.9,10.2,0.4,0.4);	
}else if($rs6["check4"]=='2'){
$pdf->Image("img/unc33.png",18.9,10.2,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",18.9,10.2,0.4,0.4);	
}

$pdf->setXY(2.0,10.7);
$pdf->Cell(17.7,0,'','T',0,'C',0);



$pdf->setXY(2.05,10.7);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8','cp874' , "$ingredient5"),0 ,'L' );

if($rs1["check5"]=='1'){
$pdf->Image("img/chk32.png",12.9,10.85,0.4,0.4);	
}else if($rs1["check5"]=='2'){
$pdf->Image("img/unc33.png",12.9,10.85,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",12.9,10.85,0.4,0.4);	
}


if($rs2["check5"]=='1'){
$pdf->Image("img/chk32.png",14.09,10.85,0.4,0.4);	
}else if($rs2["check5"]=='2'){
$pdf->Image("img/unc33.png",14.09,10.85,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",14.09,10.85,0.4,0.4);	
}


if($rs3["check5"]=='1'){
$pdf->Image("img/chk32.png",15.3,10.85,0.4,0.4);	
}else if($rs3["check5"]=='2'){
$pdf->Image("img/unc33.png",15.3,10.85,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",15.3,10.85,0.4,0.4);	
}



if($rs4["check5"]=='1'){
$pdf->Image("img/chk32.png",16.5,10.85,0.4,0.4);	
}else if($rs4["check5"]=='2'){
$pdf->Image("img/unc33.png",16.5,10.85,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",16.5,10.85,0.4,0.4);	
}


if($rs5["check5"]=='1'){
$pdf->Image("img/chk32.png",17.7,10.85,0.4,0.4);	
}else if($rs5["check5"]=='2'){
$pdf->Image("img/unc33.png",17.7,10.85,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",17.7,10.85,0.4,0.4);	
}

if($rs6["check5"]=='1'){
$pdf->Image("img/chk32.png",18.9,10.85,0.4,0.4);	
}else if($rs6["check5"]=='2'){
$pdf->Image("img/unc33.png",18.9,10.85,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",18.9,10.85,0.4,0.4);	
}

$pdf->setXY(2.0,11.3);
$pdf->Cell(17.7,0,'','T',0,'C',0);



$pdf->setXY(2.05,11.3);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8','cp874' , "$ingredient6"),0 ,'L' );

if($rs1["check6"]=='1'){
$pdf->Image("img/chk32.png",12.9,11.45,0.4,0.4);	
}else if($rs1["check6"]=='2'){
$pdf->Image("img/unc33.png",12.9,11.45,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",12.9,11.45,0.4,0.4);	
}


if($rs2["check6"]=='1'){
$pdf->Image("img/chk32.png",14.09,11.45,0.4,0.4);	
}else if($rs2["check6"]=='2'){
$pdf->Image("img/unc33.png",14.09,11.45,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",14.09,11.45,0.4,0.4);	
}


if($rs3["check6"]=='1'){
$pdf->Image("img/chk32.png",15.3,11.45,0.4,0.4);	
}else if($rs3["check6"]=='2'){
$pdf->Image("img/unc33.png",15.3,11.45,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",15.3,11.45,0.4,0.4);	
}



if($rs4["check6"]=='1'){
$pdf->Image("img/chk32.png",16.5,11.45,0.4,0.4);	
}else if($rs4["check6"]=='2'){
$pdf->Image("img/unc33.png",16.5,11.45,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",16.5,11.45,0.4,0.4);	
}


if($rs5["check6"]=='1'){
$pdf->Image("img/chk32.png",17.7,11.45,0.4,0.4);	
}else if($rs5["check6"]=='2'){
$pdf->Image("img/unc33.png",17.7,11.45,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",17.7,11.45,0.4,0.4);	
}

if($rs6["check6"]=='1'){
$pdf->Image("img/chk32.png",18.9,11.45,0.4,0.4);	
}else if($rs6["check6"]=='2'){
$pdf->Image("img/unc33.png",18.9,11.45,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",18.9,11.45,0.4,0.4);	
}


$pdf->setXY(2.0,11.9);
$pdf->Cell(17.7,0,'','T',0,'C',0);


$pdf->setXY(2.05,11.9);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8','cp874' , "$ingredient7"),0 ,'L' );

if($rs1["check7"]=='1'){
$pdf->Image("img/chk32.png",12.9,12.0,0.4,0.4);	
}else if($rs1["check7"]=='2'){
$pdf->Image("img/unc33.png",12.9,12.0,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",12.9,12.0,0.4,0.4);	
}


if($rs2["check7"]=='1'){
$pdf->Image("img/chk32.png",14.09,12.0,0.4,0.4);	
}else if($rs2["check7"]=='2'){
$pdf->Image("img/unc33.png",14.09,12.0,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",14.09,12.0,0.4,0.4);	
}


if($rs3["check7"]=='1'){
$pdf->Image("img/chk32.png",15.3,12.0,0.4,0.4);	
}else if($rs3["check7"]=='2'){
$pdf->Image("img/unc33.png",15.3,12.0,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",15.3,12.0,0.4,0.4);	
}



if($rs4["check7"]=='1'){
$pdf->Image("img/chk32.png",16.5,12.0,0.4,0.4);	
}else if($rs4["check7"]=='2'){
$pdf->Image("img/unc33.png",16.5,12.0,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",16.5,12.0,0.4,0.4);	
}


if($rs5["check7"]=='1'){
$pdf->Image("img/chk32.png",17.7,12.0,0.4,0.4);	
}else if($rs5["check7"]=='2'){
$pdf->Image("img/unc33.png",17.7,12.0,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",17.7,12.0,0.4,0.4);	
}

if($rs6["check7"]=='1'){
$pdf->Image("img/chk32.png",18.9,12.0,0.4,0.4);	
}else if($rs6["check7"]=='2'){
$pdf->Image("img/unc33.png",18.9,12.0,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",18.9,12.05,0.4,0.4);	
}


$pdf->setXY(2.0,12.5);
$pdf->Cell(17.7,0,'','T',0,'C',0);


$pdf->setXY(2.05,12.5);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8','cp874' , "$ingredient8"),0 ,'L' );

if($rs1["check8"]=='1'){
$pdf->Image("img/chk32.png",12.9,12.6,0.4,0.4);	
}else if($rs1["check8"]=='2'){
$pdf->Image("img/unc33.png",12.9,12.6,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",12.9,12.6,0.4,0.4);	
}


if($rs2["check8"]=='1'){
$pdf->Image("img/chk32.png",14.09,12.6,0.4,0.4);	
}else if($rs2["check8"]=='2'){
$pdf->Image("img/unc33.png",14.09,12.6,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",14.09,12.6,0.4,0.4);	
}


if($rs3["check8"]=='1'){
$pdf->Image("img/chk32.png",15.3,12.6,0.4,0.4);	
}else if($rs3["check8"]=='2'){
$pdf->Image("img/unc33.png",15.3,12.6,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",15.3,12.6,0.4,0.4);	
}



if($rs4["check8"]=='1'){
$pdf->Image("img/chk32.png",16.5,12.6,0.4,0.4);	
}else if($rs4["check8"]=='2'){
$pdf->Image("img/unc33.png",16.5,12.6,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",16.5,12.6,0.4,0.4);	
}


if($rs5["check8"]=='1'){
$pdf->Image("img/chk32.png",17.7,12.6,0.4,0.4);	
}else if($rs5["check8"]=='2'){
$pdf->Image("img/unc33.png",17.7,12.6,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",17.7,12.6,0.4,0.4);	
}

if($rs6["check8"]=='1'){
$pdf->Image("img/chk32.png",18.9,12.6,0.4,0.4);	
}else if($rs6["check8"]=='2'){
$pdf->Image("img/unc33.png",18.9,12.6,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",18.9,12.6,0.4,0.4);	
}

$pdf->setXY(2.0,13.1);
$pdf->Cell(17.7,0,'','T',0,'C',0);



$pdf->setXY(2.05,13.1);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8','cp874' , "$ingredient9"),0 ,'L' );

if($rs1["check9"]=='1'){
$pdf->Image("img/chk32.png",12.9,13.2,0.4,0.4);	
}else if($rs1["check9"]=='2'){
$pdf->Image("img/unc33.png",12.9,13.2,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",12.9,13.2,0.4,0.4);	
}


if($rs2["check9"]=='1'){
$pdf->Image("img/chk32.png",14.09,13.2,0.4,0.4);	
}else if($rs2["check9"]=='2'){
$pdf->Image("img/unc33.png",14.09,13.2,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",14.09,13.2,0.4,0.4);	
}


if($rs3["check9"]=='1'){
$pdf->Image("img/chk32.png",15.3,13.2,0.4,0.4);	
}else if($rs3["check9"]=='2'){
$pdf->Image("img/unc33.png",15.3,13.2,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",15.3,13.2,0.4,0.4);	
}



if($rs4["check9"]=='1'){
$pdf->Image("img/chk32.png",16.5,13.2,0.4,0.4);	
}else if($rs4["check9"]=='2'){
$pdf->Image("img/unc33.png",16.5,13.2,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",16.5,13.2,0.4,0.4);	
}


if($rs5["check9"]=='1'){
$pdf->Image("img/chk32.png",17.7,13.2,0.4,0.4);	
}else if($rs5["check9"]=='2'){
$pdf->Image("img/unc33.png",17.7,13.2,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",17.7,13.2,0.4,0.4);	
}

if($rs6["check9"]=='1'){
$pdf->Image("img/chk32.png",18.9,13.2,0.4,0.4);	
}else if($rs6["check9"]=='2'){
$pdf->Image("img/unc33.png",18.9,13.2,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",18.9,13.2,0.4,0.4);	
}

$pdf->setXY(2.0,13.7);
$pdf->Cell(17.7,0,'','T',0,'C',0);



$pdf->setXY(2.05,13.7);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8','cp874' , "$ingredient10"),0 ,'L' );

if($rs1["check10"]=='1'){
$pdf->Image("img/chk32.png",12.9,13.8,0.4,0.4);	
}else if($rs1["check10"]=='2'){
$pdf->Image("img/unc33.png",12.9,13.8,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",12.9,13.8,0.4,0.4);	
}


if($rs2["check10"]=='1'){
$pdf->Image("img/chk32.png",14.09,13.8,0.4,0.4);	
}else if($rs2["check10"]=='2'){
$pdf->Image("img/unc33.png",14.09,13.8,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",14.09,13.8,0.4,0.4);	
}


if($rs3["check10"]=='1'){
$pdf->Image("img/chk32.png",15.3,13.8,0.4,0.4);	
}else if($rs3["check10"]=='2'){
$pdf->Image("img/unc33.png",15.3,13.8,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",15.3,13.8,0.4,0.4);	
}



if($rs4["check10"]=='1'){
$pdf->Image("img/chk32.png",16.5,13.8,0.4,0.4);	
}else if($rs4["check10"]=='2'){
$pdf->Image("img/unc33.png",16.5,13.8,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",16.5,13.8,0.4,0.4);	
}


if($rs5["check10"]=='1'){
$pdf->Image("img/chk32.png",17.7,13.8,0.4,0.4);	
}else if($rs5["check10"]=='2'){
$pdf->Image("img/unc33.png",17.7,13.8,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",17.7,13.8,0.4,0.4);	
}

if($rs6["check10"]=='1'){
$pdf->Image("img/chk32.png",18.9,13.8,0.4,0.4);	
}else if($rs6["check10"]=='2'){
$pdf->Image("img/unc33.png",18.9,13.8,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",18.9,13.8,0.4,0.4);	
}

$pdf->setXY(2.0,14.3);
$pdf->Cell(17.7,0,'','T',0,'C',0);


$pdf->setXY(2.05,14.3);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8','cp874' , "$ingredient11"),0 ,'L' );

if($rs1["check11"]=='1'){
$pdf->Image("img/chk32.png",12.9,14.4,0.4,0.4);	
}else if($rs1["check11"]=='2'){
$pdf->Image("img/unc33.png",12.9,14.4,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",12.9,14.4,0.4,0.4);	
}


if($rs2["check11"]=='1'){
$pdf->Image("img/chk32.png",14.09,14.4,0.4,0.4);	
}else if($rs2["check11"]=='2'){
$pdf->Image("img/unc33.png",14.09,14.4,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",14.09,14.4,0.4,0.4);	
}


if($rs3["check11"]=='1'){
$pdf->Image("img/chk32.png",15.3,14.4,0.4,0.4);	
}else if($rs3["check11"]=='2'){
$pdf->Image("img/unc33.png",15.3,14.4,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",15.3,14.4,0.4,0.4);	
}



if($rs4["check11"]=='1'){
$pdf->Image("img/chk32.png",16.5,14.4,0.4,0.4);	
}else if($rs4["check11"]=='2'){
$pdf->Image("img/unc33.png",16.5,14.4,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",16.5,14.4,0.4,0.4);	
}


if($rs5["check11"]=='1'){
$pdf->Image("img/chk32.png",17.7,14.4,0.4,0.4);	
}else if($rs5["check11"]=='2'){
$pdf->Image("img/unc33.png",17.7,14.4,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",17.7,14.4,0.4,0.4);	
}

if($rs6["check11"]=='1'){
$pdf->Image("img/chk32.png",18.9,14.4,0.4,0.4);	
}else if($rs6["check11"]=='2'){
$pdf->Image("img/unc33.png",18.9,14.4,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",18.9,14.4,0.4,0.4);	
}

$pdf->setXY(2.0,14.9);
$pdf->Cell(17.7,0,'','T',0,'C',0);



$pdf->setXY(2.05,14.9);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8','cp874' , "$ingredient12"),0 ,'L' );

if($rs1["check12"]=='1'){
$pdf->Image("img/chk32.png",12.9,15.0,0.4,0.4);	
}else if($rs1["check12"]=='2'){
$pdf->Image("img/unc33.png",12.9,15.0,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",12.9,15.0,0.4,0.4);	
}


if($rs2["check12"]=='1'){
$pdf->Image("img/chk32.png",14.09,15.0,0.4,0.4);	
}else if($rs2["check12"]=='2'){
$pdf->Image("img/unc33.png",14.09,15.0,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",14.09,15.0,0.4,0.4);	
}


if($rs3["check12"]=='1'){
$pdf->Image("img/chk32.png",15.3,15.0,0.4,0.4);	
}else if($rs3["check12"]=='2'){
$pdf->Image("img/unc33.png",15.3,15.0,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",15.3,15.0,0.4,0.4);	
}



if($rs4["check12"]=='1'){
$pdf->Image("img/chk32.png",16.5,15.0,0.4,0.4);	
}else if($rs4["check12"]=='2'){
$pdf->Image("img/unc33.png",16.5,15.0,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",16.5,15.0,0.4,0.4);	
}


if($rs5["check12"]=='1'){
$pdf->Image("img/chk32.png",17.7,15.0,0.4,0.4);	
}else if($rs5["check12"]=='2'){
$pdf->Image("img/unc33.png",17.7,15.0,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",17.7,15.0,0.4,0.4);	
}

if($rs6["check12"]=='1'){
$pdf->Image("img/chk32.png",18.9,15.0,0.4,0.4);	
}else if($rs6["check12"]=='2'){
$pdf->Image("img/unc33.png",18.9,15.0,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",18.9,15.0,0.4,0.4);	
}


$pdf->setXY(2.0,15.5);
$pdf->Cell(17.7,0,'','T',0,'C',0);



$pdf->setXY(2.05,15.5);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8','cp874' , "$ingredient13"),0 ,'L' );

if($rs1["check13"]=='1'){
$pdf->Image("img/chk32.png",12.9,15.6,0.4,0.4);	
}else if($rs1["check13"]=='2'){
$pdf->Image("img/unc33.png",12.9,15.6,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",12.9,15.6,0.4,0.4);	
}


if($rs2["check13"]=='1'){
$pdf->Image("img/chk32.png",14.09,15.6,0.4,0.4);	
}else if($rs2["check13"]=='2'){
$pdf->Image("img/unc33.png",14.09,15.6,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",14.09,15.6,0.4,0.4);	
}


if($rs3["check13"]=='1'){
$pdf->Image("img/chk32.png",15.3,15.6,0.4,0.4);	
}else if($rs3["check13"]=='2'){
$pdf->Image("img/unc33.png",15.3,15.6,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",15.3,15.6,0.4,0.4);	
}



if($rs4["check13"]=='1'){
$pdf->Image("img/chk32.png",16.5,15.6,0.4,0.4);	
}else if($rs4["check13"]=='2'){
$pdf->Image("img/unc33.png",16.5,15.6,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",16.5,15.6,0.4,0.4);	
}


if($rs5["check13"]=='1'){
$pdf->Image("img/chk32.png",17.7,15.6,0.4,0.4);	
}else if($rs5["check13"]=='2'){
$pdf->Image("img/unc33.png",17.7,15.6,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",17.7,15.6,0.4,0.4);	
}

if($rs6["check13"]=='1'){
$pdf->Image("img/chk32.png",18.9,15.6,0.4,0.4);	
}else if($rs6["check13"]=='2'){
$pdf->Image("img/unc33.png",18.9,15.6,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",18.9,15.6,0.4,0.4);	
}


$pdf->setXY(2.0,16.1);
$pdf->Cell(17.7,0,'','T',0,'C',0);




$pdf->setXY(2.05,16.1);
$pdf->Cell(15,0.6, iconv( 'UTF-8','cp874' , "$ingredient14"),0 ,'L' );

if($rs1["check14"]=='1'){
$pdf->Image("img/chk32.png",12.9,16.2,0.4,0.4);	
}else if($rs1["check14"]=='2'){
$pdf->Image("img/unc33.png",12.9,16.2,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",12.9,16.2,0.4,0.4);	
}


if($rs2["check14"]=='1'){
$pdf->Image("img/chk32.png",14.09,16.2,0.4,0.4);	
}else if($rs2["check14"]=='2'){
$pdf->Image("img/unc33.png",14.09,16.2,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",14.09,16.2,0.4,0.4);	
}


if($rs3["check14"]=='1'){
$pdf->Image("img/chk32.png",15.3,16.2,0.4,0.4);	
}else if($rs3["check14"]=='2'){
$pdf->Image("img/unc33.png",15.3,16.2,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",15.3,16.2,0.4,0.4);	
}



if($rs4["check14"]=='1'){
$pdf->Image("img/chk32.png",16.5,16.2,0.4,0.4);	
}else if($rs4["check14"]=='2'){
$pdf->Image("img/unc33.png",16.5,16.2,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",16.5,16.2,0.4,0.4);	
}


if($rs5["check14"]=='1'){
$pdf->Image("img/chk32.png",17.7,16.2,0.4,0.4);	
}else if($rs5["check14"]=='2'){
$pdf->Image("img/unc33.png",17.7,16.2,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",17.7,16.2,0.4,0.4);	
}

if($rs6["check14"]=='1'){
$pdf->Image("img/chk32.png",18.9,16.2,0.4,0.4);	
}else if($rs6["check14"]=='2'){
$pdf->Image("img/unc33.png",18.9,16.2,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",18.9,16.2,0.4,0.4);	
}


$pdf->setXY(2.0,16.7);
$pdf->Cell(17.7,0,'','T',0,'C',0);


$pdf->setXY(2.05,16.7);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8','cp874' , "$ingredient15"),0 ,'L' ); 

if($rs1["check15"]=='1'){
$pdf->Image("img/chk32.png",12.9,16.8,0.4,0.4);	
}else if($rs1["check15"]=='2'){
$pdf->Image("img/unc33.png",12.9,16.8,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",12.9,16.8,0.4,0.4);	
}


if($rs2["check15"]=='1'){
$pdf->Image("img/chk32.png",14.09,16.8,0.4,0.4);	
}else if($rs2["check15"]=='2'){
$pdf->Image("img/unc33.png",14.09,16.8,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",14.09,16.8,0.4,0.4);	
}


if($rs3["check15"]=='1'){
$pdf->Image("img/chk32.png",15.3,16.8,0.4,0.4);	
}else if($rs3["check15"]=='2'){
$pdf->Image("img/unc33.png",15.3,16.8,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",15.3,16.8,0.4,0.4);	
}



if($rs4["check15"]=='1'){
$pdf->Image("img/chk32.png",16.5,16.8,0.4,0.4);	
}else if($rs4["check15"]=='2'){
$pdf->Image("img/unc33.png",16.5,16.8,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",16.5,16.8,0.4,0.4);	
}


if($rs5["check15"]=='1'){
$pdf->Image("img/chk32.png",17.7,16.8,0.4,0.4);	
}else if($rs5["check15"]=='2'){
$pdf->Image("img/unc33.png",17.7,16.8,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",17.7,16.8,0.4,0.4);	
}

if($rs6["check15"]=='1'){
$pdf->Image("img/chk32.png",18.9,16.8,0.4,0.4);	
}else if($rs6["check15"]=='2'){
$pdf->Image("img/unc33.png",18.9,16.8,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",18.9,16.8,0.4,0.4);	
}



$pdf->SetFont('angsa','',12); 
$pdf->setXY(2.0,17.3);
$pdf->Cell(10.5,0.7, "",1,1,"c" );

$pdf->setXY(12.5,17.3);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(12.5,17.3);
$pdf->Cell(1.2,0.6, iconv( 'UTF-8','cp874' , $rs1["name_s"]),0,0,'C' );

$pdf->setXY(13.7,17.3);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(13.7,17.3);
$pdf->Cell(1.2,0.6, iconv( 'UTF-8','cp874' , $rs2["name_s"]),0,0,'C' );

$pdf->setXY(14.9,17.3);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(14.9,17.3);
$pdf->Cell(1.2,0.6, iconv( 'UTF-8','cp874' , $rs3["name_s"]),0,0,'C' );


$pdf->setXY(16.1,17.3);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(16.1,17.3);
$pdf->Cell(1.2,0.6, iconv( 'UTF-8','cp874' , $rs4["name_s"]),0,0,'C' );

$pdf->setXY(17.3,17.3);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(17.3,17.3);
$pdf->Cell(1.2,0.6, iconv( 'UTF-8','cp874' , $rs5["name_s"]),0,0,'C' );

$pdf->setXY(18.5,17.3);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(18.5,17.3);
$pdf->Cell(1.2,0.6, iconv( 'UTF-8','cp874' , $rs6["name_s"]),0,0,'C' );

$pdf->setXY(19.7,17.3);
$pdf->Cell(2.8,0.7, "",1,1,"c" );


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

$cus_receive=$objResult3["cus_receive"];
$receive_date = Datethai($objResult3["receive_date"]);

if($objResult3["cus_receive"]!=''){
$pdf->Image("$cus_receive",4.5,19.1,1.5,0.5,'png');	

$pdf->setXY(9.0,19.1);
$pdf->Cell(9.0,0.6, iconv( 'UTF-8','cp874' ,$receive_date),0 ,'L' );
	
$pdf->setXY(2.05,19.2);
$pdf->Cell(9.0,0.6, iconv( 'UTF-8','cp874' , "ผู้รับ...........................................................................วันที่.........................................................."),0 ,'L' );	
}else{
$pdf->setXY(2.05,19.2);
$pdf->Cell(9.0,0.6, iconv( 'UTF-8','cp874' , "ผู้รับ...........................................................................วันที่.........................................................."),0 ,'L' );
}


$pdf->setXY(2.05,19.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Received by"),0 ,'L' );

$pdf->setXY(7.9,19.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Date"),0 ,'L' );

$emp_send = $objResult3["emp_send"];
$emp_date = Datethai($objResult3["emp_date"]);

if($emp_send !=''){
	
$pdf->Image("$emp_send",14.5,19.1,1.5,0.5,'png');	

$pdf->setXY(19.5,19.1);
$pdf->Cell(9.0,0.6, iconv( 'UTF-8','cp874' ,$emp_date),0 ,'L' );

$pdf->setXY(12.55,19.2);
$pdf->Cell(9.0,0.6, iconv( 'UTF-8','cp874' , "ผู้ส่ง...........................................................................วันที่..................................................."),0 ,'L' );
}else{

$pdf->setXY(12.55,19.2);
$pdf->Cell(9.0,0.6, iconv( 'UTF-8','cp874' , "ผู้ส่ง...........................................................................วันที่..................................................."),0 ,'L' );

}
$pdf->setXY(12.55,19.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Delivery by"),0 ,'L' );

$pdf->setXY(18.25,19.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Date"),0 ,'L' );





$pdf->setXY(2.0,18.1);
$pdf->Cell(10.5,2.0, "",1,1,"c" );

$pdf->setXY(12.5,18.1);
$pdf->Cell(10.0,2.0, "",1,1,"c" );

$pdf->setXY(2.0,20.1);
$pdf->Cell(10.5,4.0,"",1,1,"c" );

/*$pdf->setXY(12.5,20.1);
$pdf->Cell(10.0,2.0, "",1,1,"c" );*/

$pdf->setXY(2.0,20.1);
$pdf->Cell(1.5,0.6, "",1,1,"c" );

$pdf->SetFont('angsana','B',12);

$pdf->setXY(2.05,20.1);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "รับคืนสินค้า"),0 ,'L' );

$pdf->SetFont('angsa','',12); 

if($objResult3["cs_ckk"]=='1'){
$pdf->Image("img/chk32.png",4.2,20.2,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",4.2,20.2,0.4,0.4);	
}

$pdf->setXY(4.9,20.1);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "สินค้าสมบูรณ์"),0 ,'L' );

if($objResult3["cs_ckk"]=='2'){
$pdf->Image("img/chk32.png",7.2,20.2,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",7.2,20.2,0.4,0.4);	
}

$pdf->setXY(7.9,20.1);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "สินค้าไม่สมบูรณ์"),0 ,'L' );

$pdf->setXY(2.1,20.7);
$pdf->Cell(12.0,0.5, iconv( 'UTF-8','cp874' , "..................................................................................................................................................."),0 ,'L' );

$pdf->setXY(2.1,21.2);
$pdf->Cell(12.0,0.5, iconv( 'UTF-8','cp874' , "..................................................................................................................................................."),0 ,'L' );

$pdf->setXY(2.1,21.8);
$pdf->Cell(12.0,0.5, iconv( 'UTF-8','cp874' , "..................................................................................................................................................."),0 ,'L' );

$pdf->setXY(2.1,20.65);
$pdf->MultiCell(11.0,0.5, iconv( 'UTF-8','cp874' ,$objResult3["des_receive"]),0 ,'L' );


$cus_send = $objResult3["cus_send"];
$cus_datesend = Datethai($objResult3["cus_datesend"]);

if($cus_send !=''){
	
$pdf->Image("$cus_send",4.3,22.3,1.5,0.5,'png');	

$pdf->setXY(10.0,22.3);
$pdf->Cell(9.0,0.6, iconv( 'UTF-8','cp874' ,$cus_datesend),0 ,'L' );

$pdf->setXY(2.05,22.4);
$pdf->Cell(9.0,0.6, iconv( 'UTF-8','cp874' , "ผู้ส่งคืน...........................................................................วันที่......................................................"),0 ,'L' );	

}else{

$pdf->setXY(3.9,22.4);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "........................................................................................................................."),0 ,'L' );


$pdf->setXY(2.05,22.4);
$pdf->Cell(9.0,0.6, iconv( 'UTF-8','cp874' , "ผู้ส่งคืน...........................................................................วันที่......................................................"),0 ,'L' );
	
}

$pdf->setXY(2.05,22.7);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Returned by"),0 ,'L' );

$pdf->setXY(8.2,22.7);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Date"),0 ,'L' );

	


$emp_receive = $objResult3["emp_receive"];
$emp_redate = Datethai($objResult3["emp_redate"]);

if($emp_receive !=''){
	
$pdf->Image("$emp_receive",4.5,23.1,1.5,0.5,'png');	

$pdf->setXY(10.0,23.1);
$pdf->Cell(9.0,0.6, iconv( 'UTF-8','cp874' ,$emp_redate),0 ,'L' );


$pdf->setXY(2.05,23.2);
$pdf->Cell(9.0,0.6, iconv( 'UTF-8','cp874' , "แผนกบริการลูกค้า........................................................วันที่......................................................"),0 ,'L' );

}else{
	
$pdf->setXY(2.05,23.2);
$pdf->Cell(9.0,0.6, iconv( 'UTF-8','cp874' , "แผนกบริการลูกค้า........................................................วันที่......................................................"),0 ,'L' );
	
}


$pdf->setXY(2.05,23.6);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Checked by"),0 ,'L' );

$pdf->setXY(8.0,23.6);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Date"),0 ,'L' );




/*$pdf->setXY(12.55,20.1);
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

*/



/*/$pdf->setXY(2.0,22.1);
$pdf->Cell(10.5,2.0, "",1,1,"c" );*/

$pdf->setXY(12.5,20.1);
$pdf->Cell(10.0,4.0, "",1,1,"c" );

$pdf->setXY(12.5,20.1);
$pdf->Cell(1.5,0.6, "",1,1,"c" );

$pdf->SetFont('angsana','B',12);

$pdf->setXY(12.55,20.1);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "สินค้า"),0 ,'L' );


$pdf->SetFont('angsa','',12); 

if($objResult3["stock_ckk"]=='1'){
$pdf->Image("img/chk32.png",14.6,20.2,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",14.6,20.2,0.4,0.4);	
}

$pdf->setXY(15.4,20.1);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "สมบูรณ์"),0 ,'L' );

if($objResult3["stock_ckk"]=='2'){
$pdf->Image("img/chk32.png",17.2,20.2,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",17.2,20.2,0.4,0.4);	
}

$pdf->setXY(17.9,20.1);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "ไม่สมบูรณ์"),0 ,'L' );


$pdf->setXY(7.9,20.1);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "สินค้าไม่สมบูรณ์"),0 ,'L' );

$pdf->setXY(12.55,20.7);
$pdf->Cell(12.0,0.5, iconv( 'UTF-8','cp874' , "............................................................................................................................................."),0 ,'L' );

$pdf->setXY(12.55,21.2);
$pdf->Cell(12.0,0.5, iconv( 'UTF-8','cp874' , "............................................................................................................................................."),0 ,'L' );

$pdf->setXY(12.55,21.8);
$pdf->Cell(12.0,0.5, iconv( 'UTF-8','cp874' , "............................................................................................................................................."),0 ,'L' );

$pdf->setXY(12.55,20.65);
$pdf->MultiCell(10.0,0.5, iconv( 'UTF-8','cp874' ,$objResult3["stock_des"]),0 ,'L' );

$stock_name = $objResult3["stock_name"];
$stock_date = Datethai($objResult3["stock_date"]);

if($emp_receive !=''){
	
$pdf->setXY(14.5,23.1);
$pdf->Cell(9.0,0.6, iconv( 'UTF-8','cp874' ,$stock_name),0 ,'L' );	

$pdf->setXY(19.5,23.1);
$pdf->Cell(9.0,0.6, iconv( 'UTF-8','cp874' ,$stock_date),0 ,'L' );
}


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
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(19.7,7.4);
$pdf->Cell(2.8,0.7, "",1,1,"c" );



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

$pdf->setXY(13.7,7.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Engineer"),0 ,'L' );

$pdf->setXY(15.0,7.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Service"),0 ,'L' );

$pdf->setXY(16.15,7.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Service"),0 ,'L' );

$pdf->setXY(17.3,7.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Engineer"),0 ,'L' );

$pdf->setXY(18.7,7.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Stock"),0 ,'L' );

$pdf->setXY(20.35,7.25);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "หมายเหตุ"),0 ,'L' );

$pdf->setXY(20.40,7.5);
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


$pdf->setXY(12.55,7.45);
$pdf->Cell(3.50,10.48, "",1,1,"c" );

$pdf->setXY(16.14,7.45);
$pdf->Cell(3.50,10.48, "",1,1,"c" );
	
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
$pdf->Cell(1.2,9.2, "",1,1,"c" );

$pdf->setXY(19.7,8.1);
$pdf->Cell(2.8,9.2, "",1,1,"c" );

$pdf->setXY(2.05,8.2);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8','cp874' , "$ingredient16"),0 ,'L' );

if($rs1["check16"]=='1'){
$pdf->Image("img/chk32.png",12.9,8.3,0.4,0.4);	
}else if($rs1["check16"]=='2'){
$pdf->Image("img/unc33.png",12.9,8.3,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",12.9,8.3,0.4,0.4);	
}


if($rs2["check16"]=='1'){
$pdf->Image("img/chk32.png",14.09,8.3,0.4,0.4);	
}else if($rs2["check16"]=='2'){
$pdf->Image("img/unc33.png",14.09,8.3,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",14.09,8.3,0.4,0.4);	
}


if($rs3["check16"]=='1'){
$pdf->Image("img/chk32.png",15.3,8.3,0.4,0.4);	
}else if($rs3["check16"]=='2'){
$pdf->Image("img/unc33.png",15.3,8.3,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",15.3,8.3,0.4,0.4);	
}



if($rs4["check16"]=='1'){
$pdf->Image("img/chk32.png",16.5,8.3,0.4,0.4);	
}else if($rs4["check16"]=='2'){
$pdf->Image("img/unc33.png",16.5,8.3,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",16.5,8.3,0.4,0.4);	
}


if($rs5["check16"]=='1'){
$pdf->Image("img/chk32.png",17.7,8.3,0.4,0.4);	
}else if($rs5["check16"]=='2'){
$pdf->Image("img/unc33.png",17.7,8.3,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",17.7,8.3,0.4,0.4);	
}

if($rs6["check16"]=='1'){
$pdf->Image("img/chk32.png",18.9,8.3,0.4,0.4);	
}else if($rs6["check16"]=='2'){
$pdf->Image("img/unc33.png",18.9,8.3,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",18.9,8.3,0.4,0.4);	
}
	
$pdf->setXY(2.0,8.8);
$pdf->Cell(17.7,0,'','T',0,'C',0);


$pdf->setXY(2.05,8.9);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8','cp874' , "$ingredient17"),0 ,'L' );

if($rs1["check17"]=='1'){
$pdf->Image("img/chk32.png",12.9,9.0,0.4,0.4);	
}else if($rs1["check17"]=='2'){
$pdf->Image("img/unc33.png",12.9,9.0,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",12.9,9.0,0.4,0.4);	
}


if($rs2["check17"]=='1'){
$pdf->Image("img/chk32.png",14.09,9.0,0.4,0.4);	
}else if($rs2["check17"]=='2'){
$pdf->Image("img/unc33.png",14.09,9.0,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",14.09,9.0,0.4,0.4);	
}


if($rs3["check17"]=='1'){
$pdf->Image("img/chk32.png",15.3,9.0,0.4,0.4);	
}else if($rs3["check17"]=='2'){
$pdf->Image("img/unc33.png",15.3,9.0,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",15.3,9.0,0.4,0.4);	
}



if($rs4["check17"]=='1'){
$pdf->Image("img/chk32.png",16.5,9.0,0.4,0.4);	
}else if($rs4["check17"]=='2'){
$pdf->Image("img/unc33.png",16.5,9.0,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",16.5,9.0,0.4,0.4);	
}


if($rs5["check17"]=='1'){
$pdf->Image("img/chk32.png",17.7,9.0,0.4,0.4);	
}else if($rs5["check17"]=='2'){
$pdf->Image("img/unc33.png",17.7,9.0,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",17.7,9.0,0.4,0.4);	
}

if($rs6["check17"]=='1'){
$pdf->Image("img/chk32.png",18.9,9.0,0.4,0.4);	
}else if($rs6["check17"]=='2'){
$pdf->Image("img/unc33.png",18.9,9.0,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",18.9,9.0,0.4,0.4);	
}

$pdf->setXY(2.0,9.5);
$pdf->Cell(17.7,0,'','T',0,'C',0);


$pdf->setXY(2.05,9.5);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8','cp874' , "$ingredient18"),0 ,'L' );

if($rs1["check18"]=='1'){
$pdf->Image("img/chk32.png",12.9,9.6,0.4,0.4);	
}else if($rs1["check18"]=='2'){
$pdf->Image("img/unc33.png",12.9,9.6,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",12.9,9.6,0.4,0.4);	
}


if($rs2["check18"]=='1'){
$pdf->Image("img/chk32.png",14.09,9.6,0.4,0.4);	
}else if($rs2["check18"]=='2'){
$pdf->Image("img/unc33.png",14.09,9.6,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",14.09,9.6,0.4,0.4);	
}


if($rs3["check18"]=='1'){
$pdf->Image("img/chk32.png",15.3,9.6,0.4,0.4);	
}else if($rs3["check18"]=='2'){
$pdf->Image("img/unc33.png",15.3,9.6,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",15.3,9.6,0.4,0.4);	
}



if($rs4["check18"]=='1'){
$pdf->Image("img/chk32.png",16.5,9.6,0.4,0.4);	
}else if($rs4["check18"]=='2'){
$pdf->Image("img/unc33.png",16.5,9.6,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",16.5,9.6,0.4,0.4);	
}


if($rs5["check18"]=='1'){
$pdf->Image("img/chk32.png",17.7,9.6,0.4,0.4);	
}else if($rs5["check18"]=='2'){
$pdf->Image("img/unc33.png",17.7,9.6,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",17.7,9.6,0.4,0.4);	
}

if($rs6["check18"]=='1'){
$pdf->Image("img/chk32.png",18.9,9.6,0.4,0.4);	
}else if($rs6["check18"]=='2'){
$pdf->Image("img/unc33.png",18.9,9.6,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",18.9,9.6,0.4,0.4);	
}
	
$pdf->setXY(2.0,10.1);
$pdf->Cell(17.7,0,'','T',0,'C',0);





$pdf->setXY(2.05,10.1);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8','cp874' , "$ingredient19"),0 ,'L' );

if($rs1["check19"]=='1'){
$pdf->Image("img/chk32.png",12.9,10.2,0.4,0.4);	
}else if($rs1["check19"]=='2'){
$pdf->Image("img/unc33.png",12.9,10.2,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",12.9,10.2,0.4,0.4);	
}


if($rs2["check19"]=='1'){
$pdf->Image("img/chk32.png",14.09,10.2,0.4,0.4);	
}else if($rs2["check19"]=='2'){
$pdf->Image("img/unc33.png",14.09,10.2,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",14.09,10.2,0.4,0.4);	
}


if($rs3["check19"]=='1'){
$pdf->Image("img/chk32.png",15.3,10.2,0.4,0.4);	
}else if($rs3["check19"]=='2'){
$pdf->Image("img/unc33.png",15.3,10.2,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",15.3,10.2,0.4,0.4);	
}



if($rs4["check19"]=='1'){
$pdf->Image("img/chk32.png",16.5,10.2,0.4,0.4);	
}else if($rs4["check19"]=='2'){
$pdf->Image("img/unc33.png",16.5,10.2,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",16.5,10.2,0.4,0.4);	
}


if($rs5["check19"]=='1'){
$pdf->Image("img/chk32.png",17.7,10.2,0.4,0.4);	
}else if($rs5["check19"]=='2'){
$pdf->Image("img/unc33.png",17.7,10.2,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",17.7,10.2,0.4,0.4);	
}

if($rs6["check19"]=='1'){
$pdf->Image("img/chk32.png",18.9,10.2,0.4,0.4);	
}else if($rs6["check19"]=='2'){
$pdf->Image("img/unc33.png",18.9,10.2,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",18.9,10.2,0.4,0.4);	
}
	
$pdf->setXY(2.0,10.7);
$pdf->Cell(17.7,0,'','T',0,'C',0);



$pdf->setXY(2.05,10.7);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8','cp874' , "$ingredient20"),0 ,'L' );

if($rs1["check20"]=='1'){
$pdf->Image("img/chk32.png",12.9,10.8,0.4,0.4);	
}else if($rs1["check20"]=='2'){
$pdf->Image("img/unc33.png",12.9,10.8,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",12.9,10.8,0.4,0.4);	
}


if($rs2["check20"]=='1'){
$pdf->Image("img/chk32.png",14.09,10.8,0.4,0.4);	
}else if($rs2["check20"]=='2'){
$pdf->Image("img/unc33.png",14.09,10.8,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",14.09,10.8,0.4,0.4);	
}


if($rs3["check20"]=='1'){
$pdf->Image("img/chk32.png",15.3,10.8,0.4,0.4);	
}else if($rs3["check20"]=='2'){
$pdf->Image("img/unc33.png",15.3,10.8,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",15.3,10.8,0.4,0.4);	
}



if($rs4["check20"]=='1'){
$pdf->Image("img/chk32.png",16.5,10.8,0.4,0.4);	
}else if($rs4["check20"]=='2'){
$pdf->Image("img/unc33.png",16.5,10.8,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",16.5,10.8,0.4,0.4);	
}


if($rs5["check20"]=='1'){
$pdf->Image("img/chk32.png",17.7,10.8,0.4,0.4);	
}else if($rs5["check20"]=='2'){
$pdf->Image("img/unc33.png",17.7,10.8,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",17.7,10.8,0.4,0.4);	
}

if($rs6["check20"]=='1'){
$pdf->Image("img/chk32.png",18.9,10.8,0.4,0.4);	
}else if($rs6["check20"]=='2'){
$pdf->Image("img/unc33.png",18.9,10.8,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",18.9,10.8,0.4,0.4);	
}

$pdf->setXY(2.0,11.3);
$pdf->Cell(17.7,0,'','T',0,'C',0);



$pdf->setXY(2.05,11.3);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8','cp874' , "$ingredient21"),0 ,'L' );


if($rs1["check21"]=='1'){
$pdf->Image("img/chk32.png",12.9,11.4,0.4,0.4);	
}else if($rs1["check21"]=='2'){
$pdf->Image("img/unc33.png",12.9,11.4,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",12.9,11.4,0.4,0.4);	
}


if($rs2["check21"]=='1'){
$pdf->Image("img/chk32.png",14.09,11.4,0.4,0.4);	
}else if($rs2["check21"]=='2'){
$pdf->Image("img/unc33.png",14.09,11.4,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",14.09,11.4,0.4,0.4);	
}


if($rs3["check21"]=='1'){
$pdf->Image("img/chk32.png",15.3,11.4,0.4,0.4);	
}else if($rs3["check21"]=='2'){
$pdf->Image("img/unc33.png",15.3,11.4,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",15.3,11.4,0.4,0.4);	
}



if($rs4["check21"]=='1'){
$pdf->Image("img/chk32.png",16.5,11.4,0.4,0.4);	
}else if($rs4["check21"]=='2'){
$pdf->Image("img/unc33.png",16.5,11.4,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",16.5,11.4,0.4,0.4);	
}


if($rs5["check21"]=='1'){
$pdf->Image("img/chk32.png",17.7,11.4,0.4,0.4);	
}else if($rs5["check21"]=='2'){
$pdf->Image("img/unc33.png",17.7,11.4,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",17.7,11.4,0.4,0.4);	
}

if($rs6["check21"]=='1'){
$pdf->Image("img/chk32.png",18.9,11.4,0.4,0.4);	
}else if($rs6["check21"]=='2'){
$pdf->Image("img/unc33.png",18.9,11.4,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",18.9,11.4,0.4,0.4);	
}
	
$pdf->setXY(2.0,11.9);
$pdf->Cell(17.7,0,'','T',0,'C',0);


$pdf->setXY(2.05,11.9);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8','cp874' , "$ingredient22"),0 ,'L' );


if($rs1["check22"]=='1'){
$pdf->Image("img/chk32.png",12.9,12.0,0.4,0.4);	
}else if($rs1["check22"]=='2'){
$pdf->Image("img/unc33.png",12.9,12.0,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",12.9,12.0,0.4,0.4);	
}


if($rs2["check22"]=='1'){
$pdf->Image("img/chk32.png",14.09,12.0,0.4,0.4);	
}else if($rs2["check22"]=='2'){
$pdf->Image("img/unc33.png",14.09,12.0,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",14.09,12.0,0.4,0.4);	
}


if($rs3["check22"]=='1'){
$pdf->Image("img/chk32.png",15.3,12.0,0.4,0.4);	
}else if($rs3["check22"]=='2'){
$pdf->Image("img/unc33.png",15.3,12.0,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",15.3,12.0,0.4,0.4);	
}



if($rs4["check22"]=='1'){
$pdf->Image("img/chk32.png",16.5,12.0,0.4,0.4);	
}else if($rs4["check22"]=='2'){
$pdf->Image("img/unc33.png",16.5,12.0,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",16.5,12.0,0.4,0.4);	
}


if($rs5["check22"]=='1'){
$pdf->Image("img/chk32.png",17.7,12.0,0.4,0.4);	
}else if($rs5["check22"]=='2'){
$pdf->Image("img/unc33.png",17.7,12.0,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",17.7,12.0,0.4,0.4);	
}

if($rs6["check22"]=='1'){
$pdf->Image("img/chk32.png",18.9,12.0,0.4,0.4);	
}else if($rs6["check22"]=='2'){
$pdf->Image("img/unc33.png",18.9,12.0,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",18.9,12.0,0.4,0.4);	
}
	
$pdf->setXY(2.0,12.5);
$pdf->Cell(17.7,0,'','T',0,'C',0);


$pdf->setXY(2.05,12.5);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8','cp874' , "$ingredient23"),0 ,'L' );

if($rs1["check23"]=='1'){
$pdf->Image("img/chk32.png",12.9,12.6,0.4,0.4);	
}else if($rs1["check23"]=='2'){
$pdf->Image("img/unc33.png",12.9,12.6,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",12.9,12.6,0.4,0.4);	
}


if($rs2["check23"]=='1'){
$pdf->Image("img/chk32.png",14.09,12.6,0.4,0.4);	
}else if($rs2["check23"]=='2'){
$pdf->Image("img/unc33.png",14.09,12.6,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",14.09,12.6,0.4,0.4);	
}


if($rs3["check23"]=='1'){
$pdf->Image("img/chk32.png",15.3,12.6,0.4,0.4);	
}else if($rs3["check23"]=='2'){
$pdf->Image("img/unc33.png",15.3,12.6,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",15.3,12.6,0.4,0.4);	
}



if($rs4["check23"]=='1'){
$pdf->Image("img/chk32.png",16.5,12.6,0.4,0.4);	
}else if($rs4["check23"]=='2'){
$pdf->Image("img/unc33.png",16.5,12.6,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",16.5,12.6,0.4,0.4);	
}


if($rs5["check23"]=='1'){
$pdf->Image("img/chk32.png",17.7,12.6,0.4,0.4);	
}else if($rs5["check23"]=='2'){
$pdf->Image("img/unc33.png",17.7,12.6,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",17.7,12.6,0.4,0.4);	
}

if($rs6["check23"]=='1'){
$pdf->Image("img/chk32.png",18.9,12.6,0.4,0.4);	
}else if($rs6["check23"]=='2'){
$pdf->Image("img/unc33.png",18.9,12.6,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",18.9,12.6,0.4,0.4);	
}
	
$pdf->setXY(2.0,13.1);
$pdf->Cell(17.7,0,'','T',0,'C',0);



$pdf->setXY(2.05,13.1);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8','cp874' , "$ingredient24"),0 ,'L' );

if($rs1["check24"]=='1'){
$pdf->Image("img/chk32.png",12.9,13.2,0.4,0.4);	
}else if($rs1["check24"]=='2'){
$pdf->Image("img/unc33.png",12.9,13.2,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",12.9,13.2,0.4,0.4);	
}


if($rs2["check24"]=='1'){
$pdf->Image("img/chk32.png",14.09,13.2,0.4,0.4);	
}else if($rs2["check24"]=='2'){
$pdf->Image("img/unc33.png",14.09,13.2,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",14.09,13.2,0.4,0.4);	
}


if($rs3["check24"]=='1'){
$pdf->Image("img/chk32.png",15.3,13.2,0.4,0.4);	
}else if($rs3["check24"]=='2'){
$pdf->Image("img/unc33.png",15.3,13.2,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",15.3,13.2,0.4,0.4);	
}



if($rs4["check24"]=='1'){
$pdf->Image("img/chk32.png",16.5,13.2,0.4,0.4);	
}else if($rs4["check24"]=='2'){
$pdf->Image("img/unc33.png",16.5,13.2,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",16.5,13.2,0.4,0.4);	
}


if($rs5["check24"]=='1'){
$pdf->Image("img/chk32.png",17.7,13.2,0.4,0.4);	
}else if($rs5["check24"]=='2'){
$pdf->Image("img/unc33.png",17.7,13.2,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",17.7,13.2,0.4,0.4);	
}

if($rs6["check24"]=='1'){
$pdf->Image("img/chk32.png",18.9,13.2,0.4,0.4);	
}else if($rs6["check24"]=='2'){
$pdf->Image("img/unc33.png",18.9,13.2,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",18.9,13.2,0.4,0.4);	
}
	
$pdf->setXY(2.0,13.7);
$pdf->Cell(17.7,0,'','T',0,'C',0);



$pdf->setXY(2.05,13.7);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8','cp874' , "$ingredient25"),0 ,'L' );

if($rs1["check25"]=='1'){
$pdf->Image("img/chk32.png",12.9,13.8,0.4,0.4);	
}else if($rs1["check25"]=='2'){
$pdf->Image("img/unc33.png",12.9,13.8,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",12.9,13.8,0.4,0.4);	
}


if($rs2["check25"]=='1'){
$pdf->Image("img/chk32.png",14.09,13.8,0.4,0.4);	
}else if($rs2["check25"]=='2'){
$pdf->Image("img/unc33.png",14.09,13.8,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",14.09,13.8,0.4,0.4);	
}


if($rs3["check25"]=='1'){
$pdf->Image("img/chk32.png",15.3,13.8,0.4,0.4);	
}else if($rs3["check25"]=='2'){
$pdf->Image("img/unc33.png",15.3,13.8,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",15.3,13.8,0.4,0.4);	
}



if($rs4["check25"]=='1'){
$pdf->Image("img/chk32.png",16.5,13.8,0.4,0.4);	
}else if($rs4["check25"]=='2'){
$pdf->Image("img/unc33.png",16.5,13.8,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",16.5,13.8,0.4,0.4);	
}


if($rs5["check25"]=='1'){
$pdf->Image("img/chk32.png",17.7,13.8,0.4,0.4);	
}else if($rs5["check25"]=='2'){
$pdf->Image("img/unc33.png",17.7,13.8,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",17.7,13.8,0.4,0.4);	
}

if($rs6["check25"]=='1'){
$pdf->Image("img/chk32.png",18.9,13.8,0.4,0.4);	
}else if($rs6["check25"]=='2'){
$pdf->Image("img/unc33.png",18.9,13.8,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",18.9,13.8,0.4,0.4);	
}

	
$pdf->setXY(2.0,14.3);
$pdf->Cell(17.7,0,'','T',0,'C',0);


$pdf->setXY(2.05,14.3);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8','cp874' , "$ingredient26"),0 ,'L' );

if($rs1["check26"]=='1'){
$pdf->Image("img/chk32.png",12.9,14.4,0.4,0.4);	
}else if($rs1["check26"]=='2'){
$pdf->Image("img/unc33.png",12.9,14.4,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",12.9,14.4,0.4,0.4);	
}


if($rs2["check26"]=='1'){
$pdf->Image("img/chk32.png",14.09,14.4,0.4,0.4);	
}else if($rs2["check26"]=='2'){
$pdf->Image("img/unc33.png",14.09,14.4,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",14.09,14.4,0.4,0.4);	
}


if($rs3["check26"]=='1'){
$pdf->Image("img/chk32.png",15.3,14.4,0.4,0.4);	
}else if($rs3["check26"]=='2'){
$pdf->Image("img/unc33.png",15.3,14.4,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",15.3,14.4,0.4,0.4);	
}



if($rs4["check26"]=='1'){
$pdf->Image("img/chk32.png",16.5,14.4,0.4,0.4);	
}else if($rs4["check26"]=='2'){
$pdf->Image("img/unc33.png",16.5,14.4,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",16.5,14.4,0.4,0.4);	
}


if($rs5["check26"]=='1'){
$pdf->Image("img/chk32.png",17.7,14.4,0.4,0.4);	
}else if($rs5["check26"]=='2'){
$pdf->Image("img/unc33.png",17.7,14.4,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",17.7,14.4,0.4,0.4);	
}

if($rs6["check26"]=='1'){
$pdf->Image("img/chk32.png",18.9,14.4,0.4,0.4);	
}else if($rs6["check26"]=='2'){
$pdf->Image("img/unc33.png",18.9,14.4,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",18.9,14.4,0.4,0.4);	
}

	
$pdf->setXY(2.0,14.9);
$pdf->Cell(17.7,0,'','T',0,'C',0);



$pdf->setXY(2.05,14.9);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8','cp874' , "$ingredient27"),0 ,'L' );

if($rs1["check27"]=='1'){
$pdf->Image("img/chk32.png",12.9,15.0,0.4,0.4);	
}else if($rs1["check27"]=='2'){
$pdf->Image("img/unc33.png",12.9,15.0,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",12.9,15.0,0.4,0.4);	
}


if($rs2["check27"]=='1'){
$pdf->Image("img/chk32.png",14.09,15.0,0.4,0.4);	
}else if($rs2["check27"]=='2'){
$pdf->Image("img/unc33.png",14.09,15.0,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",14.09,15.0,0.4,0.4);	
}


if($rs3["check27"]=='1'){
$pdf->Image("img/chk32.png",15.3,15.0,0.4,0.4);	
}else if($rs3["check27"]=='2'){
$pdf->Image("img/unc33.png",15.3,15.0,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",15.3,15.0,0.4,0.4);	
}



if($rs4["check27"]=='1'){
$pdf->Image("img/chk32.png",16.5,15.0,0.4,0.4);	
}else if($rs4["check27"]=='2'){
$pdf->Image("img/unc33.png",16.5,15.0,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",16.5,15.0,0.4,0.4);	
}


if($rs5["check27"]=='1'){
$pdf->Image("img/chk32.png",17.7,15.0,0.4,0.4);	
}else if($rs5["check27"]=='2'){
$pdf->Image("img/unc33.png",17.7,15.0,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",17.7,15.0,0.4,0.4);	
}

if($rs6["check27"]=='1'){
$pdf->Image("img/chk32.png",18.9,15.0,0.4,0.4);	
}else if($rs6["check27"]=='2'){
$pdf->Image("img/unc33.png",18.9,15.0,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",18.9,15.0,0.4,0.4);	
}

	
$pdf->setXY(2.0,15.5);
$pdf->Cell(17.7,0,'','T',0,'C',0);



$pdf->setXY(2.05,15.5);
$pdf->Cell(10.5,0.6, iconv( 'UTF-8','cp874' , "$ingredient28"),0 ,'L' );

if($rs1["check28"]=='1'){
$pdf->Image("img/chk32.png",12.9,15.6,0.4,0.4);	
}else if($rs1["check28"]=='2'){
$pdf->Image("img/unc33.png",12.9,15.6,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",12.9,15.6,0.4,0.4);	
}


if($rs2["check28"]=='1'){
$pdf->Image("img/chk32.png",14.09,15.6,0.4,0.4);	
}else if($rs2["check28"]=='2'){
$pdf->Image("img/unc33.png",14.09,15.6,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",14.09,15.6,0.4,0.4);	
}


if($rs3["check28"]=='1'){
$pdf->Image("img/chk32.png",15.3,15.6,0.4,0.4);	
}else if($rs3["check28"]=='2'){
$pdf->Image("img/unc33.png",15.3,15.6,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",15.3,15.6,0.4,0.4);	
}



if($rs4["check28"]=='1'){
$pdf->Image("img/chk32.png",16.5,15.6,0.4,0.4);	
}else if($rs4["check28"]=='2'){
$pdf->Image("img/unc33.png",16.5,15.6,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",16.5,15.6,0.4,0.4);	
}


if($rs5["check28"]=='1'){
$pdf->Image("img/chk32.png",17.7,15.6,0.4,0.4);	
}else if($rs5["check28"]=='2'){
$pdf->Image("img/unc33.png",17.7,15.6,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",17.7,15.6,0.4,0.4);	
}

if($rs6["check28"]=='1'){
$pdf->Image("img/chk32.png",18.9,15.6,0.4,0.4);	
}else if($rs6["check28"]=='2'){
$pdf->Image("img/unc33.png",18.9,15.6,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",18.9,15.6,0.4,0.4);	
}

	
$pdf->setXY(2.0,16.1);
$pdf->Cell(17.7,0,'','T',0,'C',0);




$pdf->setXY(2.05,16.1);
$pdf->MultiCell(10.5,0.6, iconv( 'UTF-8','cp874' , "$ingredient29"),0 ,'L' );

if($rs1["check29"]=='1'){
$pdf->Image("img/chk32.png",12.9,16.2,0.4,0.4);	
}else if($rs1["check29"]=='2'){
$pdf->Image("img/unc33.png",12.9,16.2,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",12.9,16.2,0.4,0.4);	
}


if($rs2["check29"]=='1'){
$pdf->Image("img/chk32.png",14.09,16.2,0.4,0.4);	
}else if($rs2["check29"]=='2'){
$pdf->Image("img/unc33.png",14.09,16.2,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",14.09,16.2,0.4,0.4);	
}


if($rs3["check29"]=='1'){
$pdf->Image("img/chk32.png",15.3,16.2,0.4,0.4);	
}else if($rs3["check29"]=='2'){
$pdf->Image("img/unc33.png",15.3,16.2,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",15.3,16.2,0.4,0.4);	
}



if($rs4["check29"]=='1'){
$pdf->Image("img/chk32.png",16.5,16.2,0.4,0.4);	
}else if($rs4["check29"]=='2'){
$pdf->Image("img/unc33.png",16.5,16.2,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",16.5,16.2,0.4,0.4);	
}


if($rs5["check29"]=='1'){
$pdf->Image("img/chk32.png",17.7,16.2,0.4,0.4);	
}else if($rs5["check29"]=='2'){
$pdf->Image("img/unc33.png",17.7,16.2,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",17.7,16.2,0.4,0.4);	
}

if($rs6["check29"]=='1'){
$pdf->Image("img/chk32.png",18.9,16.2,0.4,0.4);	
}else if($rs6["check29"]=='2'){
$pdf->Image("img/unc33.png",18.9,16.2,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",18.9,16.2,0.4,0.4);	
}
	
$pdf->SetFont('angsa','',12); 
$pdf->setXY(2.0,17.3);
$pdf->Cell(10.5,0.7, "",1,1,"c" );

$pdf->setXY(12.5,17.3);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(12.5,17.3);
$pdf->Cell(1.2,0.6, iconv( 'UTF-8','cp874' , $rs1["name_s"]),0,0,'C' );

$pdf->setXY(13.7,17.3);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(13.7,17.3);
$pdf->Cell(1.2,0.6, iconv( 'UTF-8','cp874' , $rs2["name_s"]),0,0,'C' );

$pdf->setXY(14.9,17.3);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(14.9,17.3);
$pdf->Cell(1.2,0.6, iconv( 'UTF-8','cp874' , $rs3["name_s"]),0,0,'C' );


$pdf->setXY(16.1,17.3);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(16.1,17.3);
$pdf->Cell(1.2,0.6, iconv( 'UTF-8','cp874' , $rs4["name_s"]),0,0,'C' );

$pdf->setXY(17.3,17.3);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(17.3,17.3);
$pdf->Cell(1.2,0.6, iconv( 'UTF-8','cp874' , $rs5["name_s"]),0,0,'C' );

$pdf->setXY(18.5,17.3);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(18.5,17.3);
$pdf->Cell(1.2,0.6, iconv( 'UTF-8','cp874' , $rs6["name_s"]),0,0,'C' );

$pdf->setXY(19.7,17.3);
$pdf->Cell(2.8,0.7, "",1,1,"c" );


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

$cus_receive=$objResult3["cus_receive"];
$receive_date = Datethai($objResult3["receive_date"]);

if($objResult3["cus_receive"]!=''){
$pdf->Image("$cus_receive",4.5,19.1,1.5,0.5,'png');	

$pdf->setXY(9.0,19.1);
$pdf->Cell(9.0,0.6, iconv( 'UTF-8','cp874' ,$receive_date),0 ,'L' );
	
$pdf->setXY(2.05,19.2);
$pdf->Cell(9.0,0.6, iconv( 'UTF-8','cp874' , "ผู้รับ...........................................................................วันที่.........................................................."),0 ,'L' );	
}else{
$pdf->setXY(2.05,19.2);
$pdf->Cell(9.0,0.6, iconv( 'UTF-8','cp874' , "ผู้รับ...........................................................................วันที่.........................................................."),0 ,'L' );
}


$pdf->setXY(2.05,19.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Received by"),0 ,'L' );

$pdf->setXY(7.9,19.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Date"),0 ,'L' );

$emp_send = $objResult3["emp_send"];
$emp_date = Datethai($objResult3["emp_date"]);

if($emp_send !=''){
	
$pdf->Image("$emp_send",14.5,19.1,1.5,0.5,'png');	

$pdf->setXY(19.5,19.1);
$pdf->Cell(9.0,0.6, iconv( 'UTF-8','cp874' ,$emp_date),0 ,'L' );

$pdf->setXY(12.55,19.2);
$pdf->Cell(9.0,0.6, iconv( 'UTF-8','cp874' , "ผู้ส่ง...........................................................................วันที่..................................................."),0 ,'L' );
}else{

$pdf->setXY(12.55,19.2);
$pdf->Cell(9.0,0.6, iconv( 'UTF-8','cp874' , "ผู้ส่ง...........................................................................วันที่..................................................."),0 ,'L' );

}
$pdf->setXY(12.55,19.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Delivery by"),0 ,'L' );

$pdf->setXY(18.25,19.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Date"),0 ,'L' );





$pdf->setXY(2.0,18.1);
$pdf->Cell(10.5,2.0, "",1,1,"c" );

$pdf->setXY(12.5,18.1);
$pdf->Cell(10.0,2.0, "",1,1,"c" );

$pdf->setXY(2.0,20.1);
$pdf->Cell(10.5,4.0,"",1,1,"c" );

/*$pdf->setXY(12.5,20.1);
$pdf->Cell(10.0,2.0, "",1,1,"c" );*/

$pdf->setXY(2.0,20.1);
$pdf->Cell(1.5,0.6, "",1,1,"c" );

$pdf->SetFont('angsana','B',12);

$pdf->setXY(2.05,20.1);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "รับคืนสินค้า"),0 ,'L' );

$pdf->SetFont('angsa','',12); 

if($objResult3["cs_ckk"]=='1'){
$pdf->Image("img/chk32.png",4.2,20.2,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",4.2,20.2,0.4,0.4);	
}

$pdf->setXY(4.9,20.1);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "สินค้าสมบูรณ์"),0 ,'L' );

if($objResult3["cs_ckk"]=='2'){
$pdf->Image("img/chk32.png",7.2,20.2,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",7.2,20.2,0.4,0.4);	
}

$pdf->setXY(7.9,20.1);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "สินค้าไม่สมบูรณ์"),0 ,'L' );

$pdf->setXY(2.1,20.7);
$pdf->Cell(12.0,0.5, iconv( 'UTF-8','cp874' , "..................................................................................................................................................."),0 ,'L' );

$pdf->setXY(2.1,21.2);
$pdf->Cell(12.0,0.5, iconv( 'UTF-8','cp874' , "..................................................................................................................................................."),0 ,'L' );

$pdf->setXY(2.1,21.8);
$pdf->Cell(12.0,0.5, iconv( 'UTF-8','cp874' , "..................................................................................................................................................."),0 ,'L' );

$pdf->setXY(2.1,20.65);
$pdf->MultiCell(11.0,0.5, iconv( 'UTF-8','cp874' ,$objResult3["des_receive"]),0 ,'L' );


$cus_send = $objResult3["cus_send"];
$cus_datesend = Datethai($objResult3["cus_datesend"]);

if($cus_send !=''){
	
$pdf->Image("$cus_send",4.3,22.3,1.5,0.5,'png');	

$pdf->setXY(10.0,22.3);
$pdf->Cell(9.0,0.6, iconv( 'UTF-8','cp874' ,$cus_datesend),0 ,'L' );

$pdf->setXY(2.05,22.4);
$pdf->Cell(9.0,0.6, iconv( 'UTF-8','cp874' , "ผู้ส่งคืน...........................................................................วันที่......................................................"),0 ,'L' );	

}else{

$pdf->setXY(3.9,22.4);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "........................................................................................................................."),0 ,'L' );


$pdf->setXY(2.05,22.4);
$pdf->Cell(9.0,0.6, iconv( 'UTF-8','cp874' , "ผู้ส่งคืน...........................................................................วันที่......................................................"),0 ,'L' );
	
}

$pdf->setXY(2.05,22.7);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Returned by"),0 ,'L' );

$pdf->setXY(8.2,22.7);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Date"),0 ,'L' );

	


$emp_receive = $objResult3["emp_receive"];
$emp_redate = Datethai($objResult3["emp_redate"]);

if($emp_receive !=''){
	
$pdf->Image("$emp_receive",4.5,23.1,1.5,0.5,'png');	

$pdf->setXY(10.0,23.1);
$pdf->Cell(9.0,0.6, iconv( 'UTF-8','cp874' ,$emp_redate),0 ,'L' );


$pdf->setXY(2.05,23.2);
$pdf->Cell(9.0,0.6, iconv( 'UTF-8','cp874' , "แผนกบริการลูกค้า........................................................วันที่......................................................"),0 ,'L' );

}else{
	
$pdf->setXY(2.05,23.2);
$pdf->Cell(9.0,0.6, iconv( 'UTF-8','cp874' , "แผนกบริการลูกค้า........................................................วันที่......................................................"),0 ,'L' );
	
}


$pdf->setXY(2.05,23.6);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Checked by"),0 ,'L' );

$pdf->setXY(8.0,23.6);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Date"),0 ,'L' );




/*$pdf->setXY(12.55,20.1);
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

*/



/*/$pdf->setXY(2.0,22.1);
$pdf->Cell(10.5,2.0, "",1,1,"c" );*/

$pdf->setXY(12.5,20.1);
$pdf->Cell(10.0,4.0, "",1,1,"c" );

$pdf->setXY(12.5,20.1);
$pdf->Cell(1.5,0.6, "",1,1,"c" );

$pdf->SetFont('angsana','B',12);

$pdf->setXY(12.55,20.1);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "สินค้า"),0 ,'L' );


$pdf->SetFont('angsa','',12); 

if($objResult3["stock_ckk"]=='1'){
$pdf->Image("img/chk32.png",14.6,20.2,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",14.6,20.2,0.4,0.4);	
}

$pdf->setXY(15.4,20.1);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "สมบูรณ์"),0 ,'L' );

if($objResult3["stock_ckk"]=='2'){
$pdf->Image("img/chk32.png",17.2,20.2,0.4,0.4);	
}else{
$pdf->Image("img/unc32.png",17.2,20.2,0.4,0.4);	
}

$pdf->setXY(17.9,20.1);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "ไม่สมบูรณ์"),0 ,'L' );


$pdf->setXY(7.9,20.1);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "สินค้าไม่สมบูรณ์"),0 ,'L' );

$pdf->setXY(12.55,20.7);
$pdf->Cell(12.0,0.5, iconv( 'UTF-8','cp874' , "............................................................................................................................................."),0 ,'L' );

$pdf->setXY(12.55,21.2);
$pdf->Cell(12.0,0.5, iconv( 'UTF-8','cp874' , "............................................................................................................................................."),0 ,'L' );

$pdf->setXY(12.55,21.8);
$pdf->Cell(12.0,0.5, iconv( 'UTF-8','cp874' , "............................................................................................................................................."),0 ,'L' );

$pdf->setXY(12.55,20.65);
$pdf->MultiCell(10.0,0.5, iconv( 'UTF-8','cp874' ,$objResult3["stock_des"]),0 ,'L' );

$stock_name = $objResult3["stock_name"];
$stock_date = Datethai($objResult3["stock_date"]);

if($emp_receive !=''){
	
$pdf->setXY(14.5,23.1);
$pdf->Cell(9.0,0.6, iconv( 'UTF-8','cp874' ,$stock_name),0 ,'L' );	

$pdf->setXY(19.5,23.1);
$pdf->Cell(9.0,0.6, iconv( 'UTF-8','cp874' ,$stock_date),0 ,'L' );
}


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


