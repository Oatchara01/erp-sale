<?php

define('FPDF_FONTPATH','font/');
require('fpdf1.php');
session_start();

//require('ean13.php');
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





$start_date=$_GET["start_date"];
$end_date=$_GET["end_date"];

if($_GET["company"]=='3'){
$company = "ออลล์เวล ไลฟ์ บจก.";
}else if($_GET["company"]=='4'){
$company = "โนเบิล เมด บจก.";
}

$start_date_th = Datethai($start_date);

include"dbconnect.php";


$pdf=new FPDF( 'L' , 'cm' , 'A4' );
 


//$pdf->AddPage();
$pdf->AddFont('angsa','','angsa.php');
$pdf->AddFont('angsana','B','angsab.php');
$pdf->AddFont('times','','times.php');


$pdf->SetFont('angsa','',14);

$pdf->setXY(0.3,0.3);
$pdf->Cell(29.0,20.3, "",1,1,"c" );

$pdf->Image("img/inter_express.png",0.3,0.35,2.5,1.0);

$pdf->setXY(0.3,0.35);
$pdf->Cell(25.0,2.2, "",1,1,"c" );

//$pdf->SetFont('angsana','B',20);

$pdf->setXY(0.3,0.4);
$pdf->MultiCell(25, 0.6 , iconv( 'UTF-8','cp874' , "ใบรายงานการส่งสินค้า Delivery Manifest"),0 ,'C' );

$pdf->setXY(0.3,0.9);
$pdf->MultiCell(25, 0.6 , iconv( 'UTF-8','cp874' , "สำหรับบริการสินค้าทั่วไป (Ambient) บริการขนส่งกล่องโฟม (INTER FOAM) บริการขนส่งผัก-ผลไม้ (FRUIT DELIVERY) "),0 ,'C' );

$pdf->SetFont('angsa','',11);

$pdf->setXY(0.3,1.5);
$pdf->MultiCell(25, 0.6 , iconv( 'UTF-8','cp874' , "หน้าแรก แผ่นที่ 1 /……"),0 ,'L' );

$pdf->setXY(0.3,2.0);
$pdf->MultiCell(25, 0.6 , iconv( 'UTF-8','cp874' , "วันที่ …$start_date_th....."),0 ,'L' );


$pdf->SetFont('angsa','',12);

if($_GET["company"]=='3'){
$pdf->setXY(0.3,1.5);
$pdf->MultiCell(25, 0.5 , iconv( 'UTF-8','cp874' , "ผู้ส่งสินค้า/บริษัท…....................บริษัท ออลล์เวล ไลฟ์ จำกัด.........................….รหัสลูกค้า……...................…...................…....................….........."),0 ,'C' );

$pdf->setXY(0.3,2.0);
$pdf->MultiCell(25, 0.5 , iconv( 'UTF-8','cp874' , "ที่อยู่ผู้ส่ง...................73,75 ซ.จรัญสนิทวงศ์89/2 แขวงบางอ้อ เขตบางพลัด กรุงเทพมหานคร 10700....................เบอร์ผู้ส่งสินค้า ........02-424-3555....................."),0 ,'C' );

}
if($_GET["company"]=='4'){
	
$pdf->setXY(0.3,1.5);
$pdf->MultiCell(25, 0.5 , iconv( 'UTF-8','cp874' , "ผู้ส่งสินค้า/บริษัท…....................บริษัท โนเบิล เมด จำกัด........................….รหัสลูกค้า……...................…...................…....................….........."),0 ,'C' );

$pdf->setXY(0.3,2.0);
$pdf->MultiCell(25, 0.5 , iconv( 'UTF-8','cp874' , "ที่อยู่ผู้ส่ง....................73 ซ.จรัญสนิทวงศ์89/2 แขวงบางอ้อ เขตบางพลัด กรุงเทพมหานคร 10700........................เบอร์ผู้ส่งสินค้า ........02-880-5566.........................."),0 ,'C' );
	
}
	
$pdf->setXY(25.3,0.35);
$pdf->Cell(4.0,2.2, "",1,1,"c" );	

$pdf->SetFont('angsa','',14);
	
$pdf->setXY(25.3,0.8);
$pdf->MultiCell(4.0, 0.5 , iconv( 'UTF-8','cp874' , "สำหรับติดสติ๊กเกอร์"),0 ,'C' );

$pdf->setXY(25.3,1.5);
$pdf->MultiCell(4.0, 0.5 , iconv( 'UTF-8','cp874' , "M/F Number"),0 ,'C' );

$pdf->SetFont('angsa','',10);

$pdf->setXY(0.3,2.55);
$pdf->Cell(0.8,0.9, "",1,1,"c" );	

$pdf->setXY(0.3,2.55);
$pdf->MultiCell(0.8,0.9, iconv( 'UTF-8','cp874' , "ลำดับ"),0 ,'C' );

$pdf->setXY(1.1,2.55);
$pdf->Cell(1.5,0.9, "",1,1,"c" );

$pdf->setXY(1.1,2.55);
$pdf->MultiCell(1.5,0.9, iconv( 'UTF-8','cp874' , "เลขที่บิล"),0 ,'C' );

$pdf->setXY(2.6,2.55);
$pdf->Cell(2.5,0.9, "",1,1,"c" );

$pdf->setXY(2.6,2.55);
$pdf->MultiCell(2.5,0.9, iconv( 'UTF-8','cp874' , "ชื่อผู้รับสินค้า"),0 ,'C' );


$pdf->setXY(5.1,2.55);
$pdf->Cell(6.0,0.9, "",1,1,"c" );

$pdf->setXY(5.1,2.6);
$pdf->MultiCell(6.0,0.45, iconv( 'UTF-8','cp874' , "ที่อยู่ผู้รับสินค้า"),0 ,'C' );
$pdf->setXY(5.1,3.05);
$pdf->MultiCell(6.0,0.4, iconv( 'UTF-8','cp874' , "(ระบุบ้านเลขที่ หมู่ที่ หมู่บ้าน ถนน ตำบล/แขวง)"),0 ,'C' );


$pdf->setXY(11.1,2.55);
$pdf->Cell(1.5,0.9, "",1,1,"c" );

$pdf->setXY(11.1,2.55);
$pdf->MultiCell(1.5,0.9, iconv( 'UTF-8','cp874' , "อำเภอ/เขต"),0 ,'C' );

$pdf->setXY(12.6,2.55);
$pdf->Cell(1.5,0.9, "",1,1,"c" );

$pdf->setXY(12.6,2.55);
$pdf->MultiCell(1.5,0.9, iconv( 'UTF-8','cp874' , "จังหวัด"),0 ,'C' );


$pdf->setXY(14.1,2.55);
$pdf->Cell(2.0,0.9, "",1,1,"c" );

$pdf->setXY(14.1,2.55);
$pdf->MultiCell(2.0,0.9, iconv( 'UTF-8','cp874' , "เบอร์ผู้รับสินค้า"),0 ,'C' );

$pdf->setXY(16.1,2.55);
$pdf->Cell(1.5,0.9, "",1,1,"c" );

$pdf->setXY(16.1,2.55);
$pdf->MultiCell(1.5,0.9, iconv( 'UTF-8','cp874' , "ประเภทสินค้า"),0 ,'C' );


$pdf->setXY(17.6,2.55);
$pdf->Cell(2.0,0.9, "",1,1,"c" );

$pdf->setXY(17.6,2.55);
$pdf->MultiCell(2.0,0.9, iconv( 'UTF-8','cp874' , "ประเภทบริการ"),0 ,'C' );

$pdf->setXY(19.6,2.55);
$pdf->Cell(2.0,0.9, "",1,1,"c" );

$pdf->setXY(19.6,2.55);
$pdf->MultiCell(2.0,0.9, iconv( 'UTF-8','cp874' , "ประเภทอุณหภูมิ"),0 ,'C' );

$pdf->setXY(21.6,2.55);
$pdf->Cell(2.0,0.9, "",1,1,"c" );

$pdf->setXY(21.6,2.55);
$pdf->MultiCell(2.0,0.9, iconv( 'UTF-8','cp874' , "บริการจัดส่ง (SLA)"),0 ,'C' );

$pdf->setXY(23.6,2.55);
$pdf->Cell(1.2,0.9, "",1,1,"c" );

$pdf->setXY(23.6,2.55);
$pdf->MultiCell(1.2,0.45, iconv( 'UTF-8','cp874' , "ระบุขนาด"),0 ,'C' );

$pdf->setXY(23.6,2.95);
$pdf->MultiCell(1.2,0.4, iconv( 'UTF-8','cp874' , "กล่อง"),0 ,'C' );


$pdf->setXY(24.8,2.55);
$pdf->Cell(1.2,0.9, "",1,1,"c" );

$pdf->setXY(24.8,2.55);
$pdf->MultiCell(1.2,0.45, iconv( 'UTF-8','cp874' , "น้ำหนัก/"),0 ,'C' );

$pdf->setXY(24.8,2.95);
$pdf->MultiCell(1.2,0.4, iconv( 'UTF-8','cp874' , "กล่อง"),0 ,'C' );

$pdf->setXY(26.0,2.55);
$pdf->Cell(1.2,0.9, "",1,1,"c" );

$pdf->setXY(26.0,2.55);
$pdf->MultiCell(1.2,0.45, iconv( 'UTF-8','cp874' , "จำนวน"),0 ,'C' );

$pdf->setXY(26.0,2.95);
$pdf->MultiCell(1.2,0.4, iconv( 'UTF-8','cp874' , "กล่อง"),0 ,'C' );


$pdf->setXY(27.2,2.55);
$pdf->Cell(2.1,0.9, "",1,1,"c" );

$pdf->setXY(27.2,2.55);
$pdf->MultiCell(2.1,0.9, iconv( 'UTF-8','cp874' , "หมายเหตุ"),0 ,'C' );



$strSQL = "SELECT ref_id,customer_name,address_name,customer_tel FROM tb_register_data  WHERE start_date >= '".$start_date."' and start_date <= '".$end_date."' and type_company='".$company."' and bus_inter='1' LIMIT 5";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$Num_Rows = mysqli_num_rows($objQuery);
$j=1;
while($objResult = mysqli_fetch_array($objQuery))
{	
	
$ref_id = substr($objResult["ref_id"],0,2);	
	
if($ref_id=='SO'){	
$strSQL15 = "SELECT iv_no FROM hos__so WHERE ref_id = '".$objResult["ref_id"]."' ";
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResult15= mysqli_fetch_array($objQuery15);
	
$iv_no =$objResult15["iv_no"];	
$customer_name = $objResult["customer_name"];
$address_name = $objResult["address_name"];	
$customer_tel = $objResult["customer_tel"];	
	
}else if($ref_id=='BR'){
	
$strSQL15 = "SELECT iv_no FROM hos__br WHERE ref_id_br = '".$objResult["ref_id"]."' ";
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResult15= mysqli_fetch_array($objQuery15);
	
$iv_no =$objResult15["iv_no"];	
$customer_name = $objResult["customer_name"];
$address_name = $objResult["address_name"];	
$customer_tel = $objResult["customer_tel"];	
}else if($ref_id=='CH'){
	
$strSQL15 = "SELECT iv_no FROM hos__change WHERE ref_id = '".$objResult["ref_id"]."' ";
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResult15= mysqli_fetch_array($objQuery15);
	
$iv_no =$objResult15["iv_no"];	
$customer_name = $objResult["customer_name"];
$address_name = $objResult["address_name"];	
$customer_tel = $objResult["customer_tel"];	

}else if($ref_id=='BS'){
	
$strSQL15 = "SELECT iv_no FROM hos__consig WHERE ref_id = '".$objResult["ref_id"]."' ";
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResult15= mysqli_fetch_array($objQuery15);
	
$iv_no =$objResult15["iv_no"];	
$customer_name = $objResult["customer_name"];
$address_name = $objResult["address_name"];	
$customer_tel = $objResult["customer_tel"];	

}else if($ref_id=='RS'){
	
$strSQL15 = "SELECT smp_no FROM hos__smp WHERE 2505104 = '".$objResult["ref_id"]."' ";
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResult15= mysqli_fetch_array($objQuery15);
	
$iv_no =$objResult15["smp_no"];	
$customer_name = $objResult["customer_name"];
$address_name = $objResult["address_name"];	
$customer_tel = $objResult["customer_tel"];		
	
}else{
	
$strSQL15 = "SELECT doc_no,customer_name,address1,address2,province,postcode,tel FROM so__main WHERE ref_id = '".$objResult["ref_id"]."' ";
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResult15= mysqli_fetch_array($objQuery15);
	
$iv_no =$objResult15["doc_no"];	
$customer_name = $objResult15["customer_name"];
$address1 = $objResult15["address1"];	
$address2 = $objResult15["address2"];	
$province = $objResult15["province"];	
$postcode = $objResult15["postcode"];		
$address_name = "$address1 $address2 $province $postcode";	
$customer_tel = $objResult15["tel"];	
	
}
	
$pdf->setX(0.3);
$pdf->Cell(0.8,1.2, iconv('UTF-8','cp874', "$j"),1,0,'C');
$pdf->Cell(1.5,1.2, iconv('UTF-8','cp874', "$iv_no"),1,0,'C');
$pdf->Cell(2.5,1.2, '',1,0,'L');	
//$pdf->Cell(2.5,1.2, iconv('UTF-8','cp874', "$customer_name"),1,0,'L');
$customer_nameY = $pdf->GetY();
$customer_nameX = $pdf->GetX();
$pdf->SetXY($customer_nameX - 2.5, $customer_nameY);	
$pdf->MultiCell(2.5,0.4, iconv('UTF-8//IGNORE','cp874//IGNORE', "$customer_name"),0,'L');	
$pdf->SetXY($customer_nameX, $customer_nameY);	
	
$pdf->Cell(6.0,1.2, '',1,0,'L');
$addressY = $pdf->GetY();
$addressX = $pdf->GetX();
$pdf->SetXY($addressX - 6.0, $addressY);
$pdf->MultiCell(6.0,0.4, iconv('UTF-8//IGNORE','cp874//IGNORE', "$address_name"),0,'L');
$pdf->SetXY($addressX, $addressY);
$pdf->Cell(1.5,1.2, iconv('UTF-8','cp874', ""),1,0,'C');
$pdf->Cell(1.5,1.2, iconv('UTF-8','cp874', ""),1,0,'C');	
$pdf->Cell(2.0,1.2, iconv('UTF-8','cp874', "$customer_tel"),1,1,'L');
	

$j++;


}

	
	
	
	
	
	
	











//แถว 1
$pdf->setXY(0.3,3.45);
$pdf->Cell(0.8,1.2, "",1,1,"c" );	

$pdf->setXY(1.1,3.45);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->setXY(2.6,3.45);
$pdf->Cell(2.5,1.2, "",1,1,"c" );


$pdf->setXY(5.1,3.45);
$pdf->Cell(6.0,1.2, "",1,1,"c" );

$pdf->setXY(11.1,3.45);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(12.6,3.45);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(14.1,3.45);
$pdf->Cell(2.0,1.2, "",1,1,"c" );


$pdf->setXY(16.1,3.45);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',9);
$pdf->setXY(16.1,3.45);
$pdf->MultiCell(1.5,1.2, iconv( 'UTF-8','cp874' , "เครื่องมือแพทย์"),0 ,'C' );


$pdf->setXY(17.6,3.45);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',7);
//1
$pdf->setXY(17.7,3.65);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,3.55);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการสินค้าทั่วไป"),0 ,'L' );

$pdf->setXY(17.7,3.95);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,3.85);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งกล่องโฟม"),0 ,'L' );

$pdf->setXY(17.7,4.25);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,4.2);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งผัก-ผลไม้"),0 ,'L' );






$pdf->setXY(19.6,3.45);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//2
$pdf->setXY(19.7,3.65);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,3.55);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ไม่ควบคุมอุณหภูมิ"),0 ,'L' );

$pdf->setXY(19.7,3.95);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,3.85);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Chilled 2-8 C"),0 ,'L' );

$pdf->setXY(19.7,4.25);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,4.2);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Frozen -15 C"),0 ,'L' );





$pdf->setXY(21.6,3.45);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//3
$pdf->setXY(21.7,3.65);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,3.55);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ด่วน 1 วัน"),0 ,'L' );

$pdf->setXY(21.7,3.95);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,3.85);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ธรรมดา 2-3 วัน"),0 ,'L' );

/*$pdf->setXY(21.7,4.25);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,4.2);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ภายในวัน"),0 ,'L' );*/



$pdf->setXY(23.6,3.45);
$pdf->Cell(1.2,1.2, "",1,1,"c" );

$pdf->setXY(24.8,3.45);
$pdf->Cell(1.2,1.2, "",1,1,"c" );



$pdf->setXY(26.0,3.45);
$pdf->Cell(1.2,1.2, "",1,1,"c" );


$pdf->setXY(27.2,3.45);
$pdf->Cell(2.1,1.2, "",1,1,"c" );





//แถว 2
$pdf->setXY(0.3,4.65);
$pdf->Cell(0.8,1.2, "",1,1,"c" );	

$pdf->setXY(1.1,4.65);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->setXY(2.6,4.65);
$pdf->Cell(2.5,1.2, "",1,1,"c" );


$pdf->setXY(5.1,4.65);
$pdf->Cell(6.0,1.2, "",1,1,"c" );

$pdf->setXY(11.1,4.65);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(12.6,4.65);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(14.1,4.65);
$pdf->Cell(2.0,1.2, "",1,1,"c" );


$pdf->setXY(16.1,4.65);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',9);
$pdf->setXY(16.1,4.65);
$pdf->MultiCell(1.5,1.2, iconv( 'UTF-8','cp874' , "เครื่องมือแพทย์"),0 ,'C' );


$pdf->setXY(17.6,4.65);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',7);
//1
$pdf->setXY(17.7,4.85);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,4.75);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการสินค้าทั่วไป"),0 ,'L' );

$pdf->setXY(17.7,5.15);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,5.05);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งกล่องโฟม"),0 ,'L' );

$pdf->setXY(17.7,5.45);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,5.4);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งผัก-ผลไม้"),0 ,'L' );






$pdf->setXY(19.6,4.65);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//2
$pdf->setXY(19.7,4.85);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,4.75);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ไม่ควบคุมอุณหภูมิ"),0 ,'L' );

$pdf->setXY(19.7,5.15);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,5.05);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Chilled 2-8 C"),0 ,'L' );

$pdf->setXY(19.7,5.45);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,5.4);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Frozen -15 C"),0 ,'L' );





$pdf->setXY(21.6,4.65);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//3
$pdf->setXY(21.7,4.85);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,4.75);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ด่วน 1 วัน"),0 ,'L' );

$pdf->setXY(21.7,5.15);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,5.05);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ธรรมดา 2-3 วัน"),0 ,'L' );

/*$pdf->setXY(21.7,5.45);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,5.4);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ภายในวัน"),0 ,'L' );*/



$pdf->setXY(23.6,4.65);
$pdf->Cell(1.2,1.2, "",1,1,"c" );

$pdf->setXY(24.8,4.65);
$pdf->Cell(1.2,1.2, "",1,1,"c" );



$pdf->setXY(26.0,4.65);
$pdf->Cell(1.2,1.2, "",1,1,"c" );


$pdf->setXY(27.2,4.65);
$pdf->Cell(2.1,1.2, "",1,1,"c" );





//แถว 3
$pdf->setXY(0.3,5.85);
$pdf->Cell(0.8,1.2, "",1,1,"c" );	

$pdf->setXY(1.1,5.85);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->setXY(2.6,5.85);
$pdf->Cell(2.5,1.2, "",1,1,"c" );


$pdf->setXY(5.1,5.85);
$pdf->Cell(6.0,1.2, "",1,1,"c" );

$pdf->setXY(11.1,5.85);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(12.6,5.85);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(14.1,5.85);
$pdf->Cell(2.0,1.2, "",1,1,"c" );


$pdf->setXY(16.1,5.85);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',9);
$pdf->setXY(16.1,5.85);
$pdf->MultiCell(1.5,1.2, iconv( 'UTF-8','cp874' , "เครื่องมือแพทย์"),0 ,'C' );


$pdf->setXY(17.6,5.85);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',7);
//1
$pdf->setXY(17.7,6.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,5.95);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการสินค้าทั่วไป"),0 ,'L' );

$pdf->setXY(17.7,6.35);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,6.25);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งกล่องโฟม"),0 ,'L' );

$pdf->setXY(17.7,6.65);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,6.6);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งผัก-ผลไม้"),0 ,'L' );






$pdf->setXY(19.6,5.85);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//2
$pdf->setXY(19.7,6.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,5.95);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ไม่ควบคุมอุณหภูมิ"),0 ,'L' );

$pdf->setXY(19.7,6.35);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,6.25);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Chilled 2-8 C"),0 ,'L' );

$pdf->setXY(19.7,6.65);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,6.6);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Frozen -15 C"),0 ,'L' );





$pdf->setXY(21.6,5.85);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//3
$pdf->setXY(21.7,6.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,5.95);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ด่วน 1 วัน"),0 ,'L' );

$pdf->setXY(21.7,6.35);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,6.25);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ธรรมดา 2-3 วัน"),0 ,'L' );

/*$pdf->setXY(21.7,6.65);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,6.6);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ภายในวัน"),0 ,'L' );*/



$pdf->setXY(23.6,5.85);
$pdf->Cell(1.2,1.2, "",1,1,"c" );

$pdf->setXY(24.8,5.85);
$pdf->Cell(1.2,1.2, "",1,1,"c" );



$pdf->setXY(26.0,5.85);
$pdf->Cell(1.2,1.2, "",1,1,"c" );


$pdf->setXY(27.2,5.85);
$pdf->Cell(2.1,1.2, "",1,1,"c" );



//แถว 4
$pdf->setXY(0.3,7.05);
$pdf->Cell(0.8,1.2, "",1,1,"c" );	

$pdf->setXY(1.1,7.05);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->setXY(2.6,7.05);
$pdf->Cell(2.5,1.2, "",1,1,"c" );


$pdf->setXY(5.1,7.05);
$pdf->Cell(6.0,1.2, "",1,1,"c" );

$pdf->setXY(11.1,7.05);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(12.6,7.05);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(14.1,7.05);
$pdf->Cell(2.0,1.2, "",1,1,"c" );


$pdf->setXY(16.1,7.05);
$pdf->Cell(1.5,1.2, "",1,1,"c" );
$pdf->SetFont('angsa','',9);
$pdf->setXY(16.1,7.05);
$pdf->MultiCell(1.5,1.2, iconv( 'UTF-8','cp874' , "เครื่องมือแพทย์"),0 ,'C' );



$pdf->setXY(17.6,7.05);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',7);
//1
$pdf->setXY(17.7,7.25);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,7.15);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการสินค้าทั่วไป"),0 ,'L' );

$pdf->setXY(17.7,7.55);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,7.45);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งกล่องโฟม"),0 ,'L' );

$pdf->setXY(17.7,7.85);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,7.8);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งผัก-ผลไม้"),0 ,'L' );






$pdf->setXY(19.6,7.05);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//2
$pdf->setXY(19.7,7.25);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,7.15);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ไม่ควบคุมอุณหภูมิ"),0 ,'L' );

$pdf->setXY(19.7,7.55);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,7.45);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Chilled 2-8 C"),0 ,'L' );

$pdf->setXY(19.7,7.85);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,7.8);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Frozen -15 C"),0 ,'L' );





$pdf->setXY(21.6,7.05);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//3
$pdf->setXY(21.7,7.25);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,7.15);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ด่วน 1 วัน"),0 ,'L' );

$pdf->setXY(21.7,7.55);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,7.45);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ธรรมดา 2-3 วัน"),0 ,'L' );

/*$pdf->setXY(21.7,7.85);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,7.8);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ภายในวัน"),0 ,'L' );*/



$pdf->setXY(23.6,7.05);
$pdf->Cell(1.2,1.2, "",1,1,"c" );

$pdf->setXY(24.8,7.05);
$pdf->Cell(1.2,1.2, "",1,1,"c" );



$pdf->setXY(26.0,7.05);
$pdf->Cell(1.2,1.2, "",1,1,"c" );


$pdf->setXY(27.2,7.05);
$pdf->Cell(2.1,1.2, "",1,1,"c" );



//แถว 5
$pdf->setXY(0.3,8.25);
$pdf->Cell(0.8,1.2, "",1,1,"c" );	

$pdf->setXY(1.1,8.25);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->setXY(2.6,8.25);
$pdf->Cell(2.5,1.2, "",1,1,"c" );


$pdf->setXY(5.1,8.25);
$pdf->Cell(6.0,1.2, "",1,1,"c" );

$pdf->setXY(11.1,8.25);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(12.6,8.25);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(14.1,8.25);
$pdf->Cell(2.0,1.2, "",1,1,"c" );


$pdf->setXY(16.1,8.25);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',9);
$pdf->setXY(16.1,8.25);
$pdf->MultiCell(1.5,1.2, iconv( 'UTF-8','cp874' , "เครื่องมือแพทย์"),0 ,'C' );


$pdf->setXY(17.6,8.25);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',7);
//1
$pdf->setXY(17.7,8.45);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,8.35);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการสินค้าทั่วไป"),0 ,'L' );

$pdf->setXY(17.7,8.75);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,8.65);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งกล่องโฟม"),0 ,'L' );

$pdf->setXY(17.7,9.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,9.0);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งผัก-ผลไม้"),0 ,'L' );






$pdf->setXY(19.6,8.25);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//2
$pdf->setXY(19.7,8.45);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,8.35);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ไม่ควบคุมอุณหภูมิ"),0 ,'L' );

$pdf->setXY(19.7,8.75);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,8.65);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Chilled 2-8 C"),0 ,'L' );

$pdf->setXY(19.7,9.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,9.0);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Frozen -15 C"),0 ,'L' );





$pdf->setXY(21.6,8.25);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//3
$pdf->setXY(21.7,8.45);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,8.35);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ด่วน 1 วัน"),0 ,'L' );

$pdf->setXY(21.7,8.75);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,8.65);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ธรรมดา 2-3 วัน"),0 ,'L' );

/*$pdf->setXY(21.7,9.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,9.0);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ภายในวัน"),0 ,'L' );*/



$pdf->setXY(23.6,8.25);
$pdf->Cell(1.2,1.2, "",1,1,"c" );

$pdf->setXY(24.8,8.25);
$pdf->Cell(1.2,1.2, "",1,1,"c" );



$pdf->setXY(26.0,8.25);
$pdf->Cell(1.2,1.2, "",1,1,"c" );


$pdf->setXY(27.2,8.25);
$pdf->Cell(2.1,1.2, "",1,1,"c" );


$pdf->setXY(27.2,8.25);
$pdf->Cell(2.1,1.2, "",1,1,"c" );



$pdf->SetFillColor(204,204,204);

$pdf->Cell(23.25,0.4,iconv('UTF-8','cp874','รวม'),1,0,"R",true);
$pdf->Cell(1.2,0.4,iconv('UTF-8','cp874',''),1,0,"R",true);
$pdf->Cell(1.2,0.4,iconv('UTF-8','cp874',''),1,0,"R",true);
$pdf->Cell(1.2,0.4,iconv('UTF-8','cp874',''),1,0,"R",true);
$pdf->Cell(2.1,0.4,iconv('UTF-8','cp874',''),1,0,"R",true);


$pdf->SetFont('angsa','',9);


$pdf->setXY(8.3,9.90);
$pdf->MultiCell(21,0.4, iconv( 'UTF-8','cp874' , "สำหรับเจ้าหน้าที่ บริษัท อินเตอร์ เอ็กซ์เพรส โลจิสติกส์ จำกัด"),0 ,'C' );



$pdf->setXY(0.3,9.85);
$pdf->Cell(8.0,2.0, "",1,1,"c" );

$pdf->setXY(0.3,9.85);
$pdf->MultiCell(8.0,0.4, iconv( 'UTF-8','cp874' , "เลือกรายการสำหรับสินค้าประเภทยาและเวชภัณฑ์"),0 ,'C' );

$pdf->setXY(0.55,10.4);
$pdf->Cell(0.20,0.20, "",1,1,"c" );

$pdf->setXY(0.9,10.3);
$pdf->MultiCell(8.0,0.4, iconv( 'UTF-8','cp874' , "ยาเย็นในกล่องโฟมเก็บได้ในอุณหภูมิห้อง"),0 ,'L' );

$pdf->setXY(0.55,10.8);
$pdf->Cell(0.20,0.20, "",1,1,"c" );

$pdf->setXY(0.9,10.7);
$pdf->MultiCell(8.0,0.4, iconv( 'UTF-8','cp874' , "ยาเย็นในกล่องโฟมเก็บในอุณหภูมิ 15-25 C"),0 ,'L' );

$pdf->setXY(0.55,11.2);
$pdf->Cell(0.20,0.20, "",1,1,"c" );

$pdf->setXY(0.9,11.1);
$pdf->MultiCell(8.0,0.4, iconv( 'UTF-8','cp874' , "ยาเย็นในกล่องกระดาษเก็บได้ในอุณหภูมิห้อง"),0 ,'L' );

$pdf->setXY(0.55,11.6);
$pdf->Cell(0.20,0.20, "",1,1,"c" );

$pdf->setXY(0.9,11.5);
$pdf->MultiCell(8.0,0.4, iconv( 'UTF-8','cp874' , "ยาเย็นในกล่องกระดาษเก็บในอุณหภูมิ 15-25 C"),0 ,'L' );




$pdf->setXY(8.3,10.25);
$pdf->Cell(5.0,1.6, "",1,1,"c" );

$pdf->setXY(8.3,10.50);
$pdf->MultiCell(8.0,0.4, iconv( 'UTF-8','cp874' , "ผู้รับสินค้า ..................................................................."),0 ,'L' );

$pdf->setXY(8.3,10.90);
$pdf->MultiCell(8.0,0.4, iconv( 'UTF-8','cp874' , "ทะเบียนรถ ................................................................."),0 ,'L' );

$pdf->setXY(8.3,11.30);
$pdf->MultiCell(8.0,0.4, iconv( 'UTF-8','cp874' , "วันที่รับสินค้า ................... / .................... / .................."),0 ,'L' );


$pdf->setXY(13.3,10.25);
$pdf->Cell(5.0,1.6, "",1,1,"c" );

$pdf->setXY(13.3,10.90);
$pdf->MultiCell(8.0,0.4, iconv( 'UTF-8','cp874' , "ผู้ตรวจสอบ ...................................................................."),0 ,'L' );

$pdf->setXY(13.3,11.30);
$pdf->MultiCell(8.0,0.4, iconv( 'UTF-8','cp874' , "วันที่รับสินค้า ................... / .................... / .................."),0 ,'L' );


$pdf->setXY(18.3,10.25);
$pdf->Cell(4.0,1.6, "",1,1,"c" );

$pdf->setXY(18.3,10.40);
$pdf->MultiCell(4.0,0.4, iconv( 'UTF-8','cp874' , "วิธีการชำระเงิน"),0 ,'C' );

$pdf->setXY(18.6,11.0);
$pdf->Cell(0.20,0.20, "",1,1,"c" );

$pdf->setXY(18.9,10.9);
$pdf->MultiCell(4.0,0.4, iconv( 'UTF-8','cp874' , "เครดิต"),0 ,'L' );


$pdf->setXY(20.6,11.0);
$pdf->Cell(0.20,0.20, "",1,1,"c" );

$pdf->setXY(20.9,10.9);
$pdf->MultiCell(4.0,0.4, iconv( 'UTF-8','cp874' , "เงินสด"),0 ,'L' );


$pdf->setXY(22.3,10.25);
$pdf->Cell(5.0,1.6, "",1,1,"c" );

$pdf->setXY(22.3,10.25);
$pdf->Cell(2.5,0.4, "",1,1,"c" );

$pdf->setXY(22.40,10.35);
$pdf->Cell(0.20,0.20, "",1,1,"c" );

$pdf->setXY(22.7,10.30);
$pdf->MultiCell(4.0,0.4, iconv( 'UTF-8','cp874' , "ไม่เก็บค่าเข้ารับสินค้า"),0 ,'L' );



$pdf->setXY(24.8,10.25);
$pdf->Cell(2.5,0.4, "",1,1,"c" );

$pdf->setXY(24.90,10.35);
$pdf->Cell(0.20,0.20, "",1,1,"c" );

$pdf->setXY(25.2,10.30);
$pdf->MultiCell(4.0,0.4, iconv( 'UTF-8','cp874' , "เก็บค่าเข้ารับสินค้า"),0 ,'L' );



$pdf->setXY(22.3,10.65);
$pdf->Cell(5.0,0.4, "",1,1,"c" );

$pdf->setXY(22.3,10.65);
$pdf->MultiCell(5.0,0.4, iconv( 'UTF-8','cp874' , "(จำนวนสินค้าแช่เย็น)        กล่อง x        บาท =            บาท"),0 ,'L' );


$pdf->setXY(22.3,11.05);
$pdf->Cell(5.0,0.4, "",1,1,"c" );

$pdf->setXY(22.3,11.05);
$pdf->MultiCell(5.0,0.4, iconv( 'UTF-8','cp874' , "(จำนวนสินค้าทั่วไป)        กล่อง x        บาท =             บาท"),0 ,'L' );

$pdf->setXY(22.3,11.45); 
$pdf->MultiCell(5.0,0.4, iconv( 'UTF-8','cp874' , "รวมทั้งหมด                      =                         บาท"),0 ,'L' );


$pdf->setXY(27.3,10.25);
$pdf->Cell(2.0,1.6, "",1,1,"c" );

$pdf->setXY(27.3,10.25);
$pdf->Cell(2.0,0.4, "",1,1,"c" );

$pdf->setXY(27.3,10.25);
$pdf->MultiCell(2.0,0.4, iconv( 'UTF-8','cp874' , "วันที่รับสินค้า"),0 ,'C' );


$pdf->setXY(0.3,11.85);
$pdf->Cell(29,1.6, "",1,1,"c" );

$pdf->setXY(1.0,11.9);
$pdf->MultiCell(29,0.4, iconv( 'UTF-8','cp874' , "หมายเหตุ"),0 ,'L' );


$pdf->setXY(1.0,12.3);
$pdf->MultiCell(14,0.4, iconv( 'UTF-8','cp874' , "1. ประเภทสินค้าหากเป็นยาเย็นระบุ (ยาเย็น) / ยาธรรมดาระบุ (ยา)"),0 ,'L' );

$pdf->setXY(1.0,12.7);
$pdf->MultiCell(14,0.4, iconv( 'UTF-8','cp874' , "2.  ช่องประเภทสินค้า ระบุสินค้าที่บรรจุในกล่อง(เนื้อแช่แข็ง, ปลาแช่แข็ง, เนยแช่แข็ง, ผลไม้หรือสินค้าประเภทอื่น ๆ ฯลฯ)"),0 ,'L' );

$pdf->setXY(1.0,13.1);
$pdf->MultiCell(14,0.4, iconv( 'UTF-8','cp874' , "3. สินค้าประเภทผัก-ผลไม้ หากใช้บริการขนส่งผัก-ผลไม้ จะต้องเป็นลูกหรือเป็นผลเปลือกแข็งเท่านั้น"),0 ,'L' );


$pdf->setXY(15.0,12.3);
$pdf->MultiCell(14,0.4, iconv( 'UTF-8','cp874' , "4.  ช่องระบุขนาดกล่อง ระบุขนาดกล่องดังนี้ S1, S2,  A1, A2, B1, B2 / บริการขนส่งผัก-ผลไม้ ไม่ต้องระบุขนาดกล่อง แต่ต้องระบุน้ำหนัก (กิโลกรัม) ต่อกล่อง"),0 ,'L' );

$pdf->setXY(15.0,12.7);
$pdf->MultiCell(14,0.4, iconv( 'UTF-8','cp874' , "5. กรณีที่ผู้รับปลายทางไม่มีเบอร์โทรติดต่อให้ใช้เบอร์โทรติดต่อของผู้ส่งสินค้าแทน"),0 ,'L' );

$pdf->setXY(15.0,13.1);
$pdf->MultiCell(14,0.4, iconv( 'UTF-8','cp874' , "6. หากไม่ทราบวิธีคิดขนาดกล่อง ระบุน้ำหนักต่อกล่องในช่องน้ำหนักและปริมาตร กว้าง X ยาว X สูง (เซนติเมตร) ในช่องหมายเหตุ"),0 ,'L' );


$pdf->Cell(28.9,0.4,iconv('UTF-8','cp874','คำรับรองของผู้ส่งสินค้า : ข้าพเจ้าขอรับรองว่า'),0,0,"C",true);


$pdf->SetFont('angsa','',7);
$pdf->setXY(0.35,14.2);
$pdf->MultiCell(29,0.4, iconv( 'UTF-8','cp874' , "ชื่อ-นามสกุล ผู้ส่ง  ........................................................................ ที่อยู่ ................................................................................................................................................................................... เบอร์ผู้ส่งสินค้า  ....................................................................  หมายเลขบัตรประชาชน   ...................................................... ได้นำสินค้าจำนวนทั้งสิ้น .................  กล่อง/ชิ้น ตามรายการในใบรายงานการส่งสินค้าจำนวน ................  ใบ ประจำวันที่ ................ "),0 ,'L' );

$pdf->setXY(0.35,14.6);
$pdf->MultiCell(29,0.4, iconv( 'UTF-8','cp874' , "เพื่อนำส่งให้ลูกค้าปลายทางของข้าพเจ้า ตามรายการในใบรายงานการส่งสินค้าทั้งหมด ที่นำมาฝากส่งไม่ได้เป็นสินค้าผิดกฎหมาย ได้รับทราบข้อตกลงและยอมรับเงื่อนไขการคุ้มครองสินค้า ที่ทางบริษัทฯ ระบุไว้ที่ https://iel.co.th/terms-and-conditions รวมถึงผู้ส่งได้ให้ข้อมูลกับผู้รับปลายทางได้อ่านข้อความอย่างเข้าใจ และตกลงปฏิบัติตามข้อกำหนดเงื่อนไขต่าง ๆ ณ จุดบริการแล้ว บริษัทฯ ขอสงวนสิทธิ์ที่จะไม่รับผิดชอบต่อพัสดุดังต่อไปนี้"),0 ,'L' );

$pdf->setXY(0.60,15);
$pdf->MultiCell(29,0.3, iconv( 'UTF-8','cp874' , "1."),0 ,'L' );

$pdf->setXY(1.0,15);
$pdf->MultiCell(29,0.3, iconv( 'UTF-8','cp874' , "สินค้าที่นำฝากส่งเป็นสินค้าผิดกฎหมาย"),0 ,'L' );

$pdf->setXY(1.0,15.3);
$pdf->MultiCell(29,0.3, iconv( 'UTF-8','cp874' , "1.1 ประเภทยาเสพติด/สารตั้งต้นทุกชนิด ที่ผิดกฎหมายปัจจุบัน  1.2 สินค้าเป็นสิ่งมีชีวิต ของเหลวทุกชนิด วัตถุไวไฟ และวัตถุอันตรายต่าง ๆ 1.3 สินค้าที่ส่งได้ แต่ต้องมีใบอนุญาต หรือใบกำกับภาษี (1.3.1 สินค้าประเภทยาแก้ไอ ส่งได้ในนามนิติบุคคลเท่านั้น 1.3.2 สินค้าประเภทสุรา  1.3.3 สินค้าประเภทบุหรี่,ยาสูบ)"),0 ,'L' );

$pdf->setXY(0.60,15.6);
$pdf->MultiCell(29,0.3, iconv( 'UTF-8','cp874' , "2."),0 ,'L' );

$pdf->setXY(1.0,15.6);
$pdf->MultiCell(29,0.3, iconv( 'UTF-8','cp874' , "สินค้าที่นำฝากส่งเป็นสารเคมีรุนแรงที่ใช้การขนส่งควบคุมโดยเฉพาะ (หากความเสียหายที่เกิดขึ้น สามารถพิสูจน์ได้ว่ามาจากตัวสินค้าที่ผู้ส่งนำมาฝากส่ง ผู้ส่งสินค้าหรือบริษัทผู้ฝากส่งต้องร่วมรับผิดชอบค่าเสียหายกับผลกระทบที่เกิดขึ้น)"),0 ,'L' );

$pdf->setXY(0.60,15.9);
$pdf->MultiCell(29,0.3, iconv( 'UTF-8','cp874' , "3."),0 ,'L' );

$pdf->setXY(1.0,15.9);
$pdf->MultiCell(29,0.3, iconv( 'UTF-8','cp874' , "สินค้าที่ส่งได้แต่ไม่ได้รับการคุ้มครองความเสียหาย"),0 ,'L' );

$pdf->setXY(1.0,16.2);
$pdf->MultiCell(29,0.3, iconv( 'UTF-8','cp874' , "3.1 อาหารมีอายุน้อยกว่า 5 วัน รวมถึงสินค้าประเภทผัก,ผลไม้เปลือกบาง 3.2 สินค้าที่มีกลิ่นและไม่ได้ห่อหุ้มปิดมิดชิด ไม่ซีลถุงสุญญากาศ ไม่บรรจุในกล่องเก็บกลิ่นมาตรฐาน 3.3 กรณีผู้ส่งใช้บริการขนส่งกล่องโฟม ผู้ส่งใช้วัสดุทำความเย็นไม่เพียงพอไม่เหมาะสม 3.4 กรณีผู้ส่งใช้บริการที่ไม่เหมาะสมกับตัวสินค้า หรือบรรจุภัณฑ์ที่ไม่เหมาะสมกับตัวสินค้า 
3.5 สินค้าที่บรรจุลงสภาพกล่องไม่สมบูรณ์ทั้งภายในและภายนอกไม่เหมาะสมกับการจัดส่งสินค้า รวมถึงบรรจุภัณฑ์ที่เป็นขวดแก้ว"),0 ,'L' );


$pdf->setXY(0.60,16.8);
$pdf->MultiCell(29,0.3, iconv( 'UTF-8','cp874' , "4."),0 ,'L' );

$pdf->setXY(1.0,16.8);
$pdf->MultiCell(29,0.3, iconv( 'UTF-8','cp874' , "กรณีสินค้าเกิดความเสียหาย ผู้ส่งต้องทำการแจ้งกลับบริษัทฯ ภายใน 1 วัน แต่หากผู้รับปลายทางลงลายมือชื่อรับสินค้าแล้วการคุ้มครองความเสียหายและสูญหายถือว่าสิ้นสุดทันที กรณีสินค้าไม่ถึงผู้รับโปรดทวงถามภายใน 7 วัน นับจากวันที่ส่งสินค้า  รวมถึงผู้ส่งระบุเบอร์โทรศัพท์ผิด ที่อยู่ไม่ถูกต้องไม่ชัดเจน ทำให้การจัดส่งครั้งแรกไม่สำเร็จ  เกิดเหตุความเสียหายทั้งทางตรงและทางอ้อมของสินค้า
ที่เกิดจากเหตุสุดวิสัยจากการขนส่ง ไม่อยู่ในเงื่อนไขการคุ้มครองทุกกรณี"),0 ,'L' );

$pdf->setXY(0.60,17.4);
$pdf->MultiCell(29,0.3, iconv( 'UTF-8','cp874' , "5."),0 ,'L' );

$pdf->setXY(1.0,17.4);
$pdf->MultiCell(29,0.3, iconv( 'UTF-8','cp874' , "ผู้ส่งสินค้าได้รับทราบเงื่อนไขและตกลงยอมรับต่อเงื่อนไขการคุ้มครองสินค้าที่บริษัทฯกำหนด โดยในกรณีที่สินค้าเกิดความเสียหายหรือสูญหาย บริษัทฯ จะรับผิดชอบตามมูลค่าจริง แต่ไม่เกิน 3,000 บาท (สามพันบาทถ้วน) ต่อกล่อง และชดเชยเฉพาะค่าสินค้าไม่รวมค่าบริการ ค่าขนส่ง และค่าเสียโอกาสทุกกรณี"),0 ,'L' );

$pdf->setXY(1.0,17.7);
$pdf->MultiCell(29,0.3, iconv( 'UTF-8','cp874' , "5.1 สำหรับสินค้าทั่วไปหรือยาเวชภัณฑ์  กรณีสินค้ามีมูลค่าสูงมากกว่าการคุ้มครองมาตรฐาน หากต้องการซื้อความคุ้มครองสินค้า กรุณาแจ้งเจ้าหน้าที่ ทางบริษัทฯคิดค่าประกัน 1.25% จากมูลค่าที่ผู้ส่งสินค้าแจ้ง แต่ไม่เกิน 50,000 บาท (ห้าหมื่นบาทถ้วน) ต่อใบนำส่ง"),0 ,'L' );

$pdf->setXY(1.0,18.0);
$pdf->MultiCell(29,0.3, iconv( 'UTF-8','cp874' , "5.2 สินค้าประเภทเครื่องใช้ไฟฟ้ามือหนึ่ง ที่มีกระจกเป็นส่วนประกอบ ไม่สามารถซื้อความคุ้มครองเพิ่มเติมได้"),0 ,'L' );

$pdf->setXY(1.0,18.3);
$pdf->MultiCell(29,0.3, iconv( 'UTF-8','cp874' , "5.3 สินค้าประเภทอาหาร ของกิน ของสด ผักและผลไม้ สินค้าที่เสี่ยงต่อความเสียหาย ไม่สามารถซื้อความคุ้มครองเพิ่มเติมได้และหากผู้ส่งประสงค์ให้ฝ่ายเคลมพิจารณาเคลมสินค้า ขอสงวนสิทธิ์ในการคืนซาก"),0 ,'L' );


$pdf->setXY(0.60,18.6);
$pdf->MultiCell(29,0.3, iconv( 'UTF-8','cp874' , "6."),0 ,'L' );

$pdf->setXY(1.0,18.6);
$pdf->MultiCell(29,0.3, iconv( 'UTF-8','cp874' , "กรุณากรอก ชื่อ ที่อยู่ เบอร์โทร ผู้ส่งและผู้รับ ให้ถูกต้องครบถ้วน มิฉะนั้นทางบริษัทฯ สงวนสิทธิ์ในการให้บริการ"),0 ,'L' );


$pdf->setXY(0.60,18.9);
$pdf->MultiCell(29,0.3, iconv( 'UTF-8','cp874' , "7."),0 ,'L' );

$pdf->setXY(1.0,18.9);
$pdf->MultiCell(29,0.3, iconv( 'UTF-8','cp874' , "ข้าพเจ้าได้ยืนยันตัวตน โดยสำแดงสำเนาบัตรประจำตัวประชาชนกับเจ้าหน้าที่บริษัทฯ และรับรองว่าสินค้าที่นำส่งเป็นสิ่งของในกรรมสิทธิ์ของข้าพเจ้า และข้าพเจ้าได้บรรจุลงในภาชนะที่มิดชิดเพื่อนำส่งให้กับผู้รับปลายทาง โดยสินค้า/สิ่งของดังกล่าว บริษัท อินเตอร์ เอ็กซ์เพรส โลจิสติกส์ จำกัด  มิได้มีส่วนรู้เห็นหรือเกี่ยวข้องด้วยประการใด ๆ ทั้งสิ้น "),0 ,'L' );




$pdf->SetFont('angsa','',12);

$pdf->setXY(0.35,20.0);
$pdf->MultiCell(29,0, iconv( 'UTF-8','cp874' , "ลงชื่อ  ..........................................................................................  ผู้ส่งสินค้า วันที่ ............... / ................ / ..............."),0 ,'C' );


$pdf->Image("img/qrcode_inter.png",27.7,18.5,1.5,1.5);

$pdf->SetFont('angsa','',7);
$pdf->setXY(26.5,20.2);
$pdf->MultiCell(29,0, iconv( 'UTF-8','cp874' , "FM-RC-01, แก้ไขครั้งที่ 10.01-02-2026"),0 ,'L' );



//หน้าที่ 2

$strSQL = "SELECT ref_id,customer_name,address_name,customer_tel FROM tb_register_data  WHERE start_date >= '".$start_date."' and start_date <= '".$end_date."' and type_company='".$company."' and bus_inter='1' LIMIT 10 OFFSET 5";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$Num_Rows = mysqli_num_rows($objQuery);

if($Num_Rows > 0){
//$pdf->AddPage();

$pdf->SetFont('angsa','',14);

$pdf->setXY(0.3,0.3);
$pdf->Cell(29.0,20.3, "",1,1,"c" );

$pdf->Image("img/inter_express.png",0.3,0.35,2.5,1.0);

$pdf->setXY(0.3,0.35);
$pdf->Cell(25.0,2.2, "",1,1,"c" );

//$pdf->SetFont('angsana','B',20);

$pdf->setXY(0.3,0.4);
$pdf->MultiCell(25, 0.6 , iconv( 'UTF-8','cp874' , "ใบรายงานการส่งสินค้า Delivery Manifest"),0 ,'C' );

$pdf->setXY(0.3,0.9);
$pdf->MultiCell(25, 0.6 , iconv( 'UTF-8','cp874' , "สำหรับบริการสินค้าทั่วไป (Ambient) บริการขนส่งกล่องโฟม (INTER FOAM) บริการขนส่งผัก-ผลไม้ (FRUIT DELIVERY) "),0 ,'C' );

$pdf->SetFont('angsa','',11);

$pdf->setXY(0.3,1.5);
$pdf->MultiCell(25, 0.6 , iconv( 'UTF-8','cp874' , "หน้าแรก แผ่นที่ 1 /……"),0 ,'L' );

$pdf->setXY(0.3,2.0);
$pdf->MultiCell(25, 0.6 , iconv( 'UTF-8','cp874' , "วันที่ …$start_date_th....."),0 ,'L' );


$pdf->SetFont('angsa','',12);

if($_GET["company"]=='3'){
$pdf->setXY(0.3,1.5);
$pdf->MultiCell(25, 0.5 , iconv( 'UTF-8','cp874' , "ผู้ส่งสินค้า/บริษัท…....................บริษัท ออลล์เวล ไลฟ์ จำกัด.........................….รหัสลูกค้า……...................…...................…....................….........."),0 ,'C' );

$pdf->setXY(0.3,2.0);
$pdf->MultiCell(25, 0.5 , iconv( 'UTF-8','cp874' , "ที่อยู่ผู้ส่ง...................73,75 ซ.จรัญสนิทวงศ์89/2 แขวงบางอ้อ เขตบางพลัด กรุงเทพมหานคร 10700....................เบอร์ผู้ส่งสินค้า ........02-424-3555....................."),0 ,'C' );

}
if($_GET["company"]=='4'){
	
$pdf->setXY(0.3,1.5);
$pdf->MultiCell(25, 0.5 , iconv( 'UTF-8','cp874' , "ผู้ส่งสินค้า/บริษัท…....................บริษัท โนเบิล เมด จำกัด........................….รหัสลูกค้า……...................…...................…....................….........."),0 ,'C' );

$pdf->setXY(0.3,2.0);
$pdf->MultiCell(25, 0.5 , iconv( 'UTF-8','cp874' , "ที่อยู่ผู้ส่ง....................73 ซ.จรัญสนิทวงศ์89/2 แขวงบางอ้อ เขตบางพลัด กรุงเทพมหานคร 10700........................เบอร์ผู้ส่งสินค้า ........02-880-5566.........................."),0 ,'C' );
	
}
	
$pdf->setXY(25.3,0.35);
$pdf->Cell(4.0,2.2, "",1,1,"c" );	

$pdf->SetFont('angsa','',14);
	
$pdf->setXY(25.3,0.8);
$pdf->MultiCell(4.0, 0.5 , iconv( 'UTF-8','cp874' , "สำหรับติดสติ๊กเกอร์"),0 ,'C' );

$pdf->setXY(25.3,1.5);
$pdf->MultiCell(4.0, 0.5 , iconv( 'UTF-8','cp874' , "M/F Number"),0 ,'C' );

$pdf->SetFont('angsa','',10);

$pdf->setXY(0.3,2.55);
$pdf->Cell(0.8,0.9, "",1,1,"c" );	

$pdf->setXY(0.3,2.55);
$pdf->MultiCell(0.8,0.9, iconv( 'UTF-8','cp874' , "ลำดับ"),0 ,'C' );

$pdf->setXY(1.1,2.55);
$pdf->Cell(1.5,0.9, "",1,1,"c" );

$pdf->setXY(1.1,2.55);
$pdf->MultiCell(1.5,0.9, iconv( 'UTF-8','cp874' , "เลขที่บิล"),0 ,'C' );

$pdf->setXY(2.6,2.55);
$pdf->Cell(2.5,0.9, "",1,1,"c" );

$pdf->setXY(2.6,2.55);
$pdf->MultiCell(2.5,0.9, iconv( 'UTF-8','cp874' , "ชื่อผู้รับสินค้า"),0 ,'C' );


$pdf->setXY(5.1,2.55);
$pdf->Cell(6.0,0.9, "",1,1,"c" );

$pdf->setXY(5.1,2.6);
$pdf->MultiCell(6.0,0.45, iconv( 'UTF-8','cp874' , "ที่อยู่ผู้รับสินค้า"),0 ,'C' );
$pdf->setXY(5.1,3.05);
$pdf->MultiCell(6.0,0.4, iconv( 'UTF-8','cp874' , "(ระบุบ้านเลขที่ หมู่ที่ หมู่บ้าน ถนน ตำบล/แขวง)"),0 ,'C' );


$pdf->setXY(11.1,2.55);
$pdf->Cell(1.5,0.9, "",1,1,"c" );

$pdf->setXY(11.1,2.55);
$pdf->MultiCell(1.5,0.9, iconv( 'UTF-8','cp874' , "อำเภอ/เขต"),0 ,'C' );

$pdf->setXY(12.6,2.55);
$pdf->Cell(1.5,0.9, "",1,1,"c" );

$pdf->setXY(12.6,2.55);
$pdf->MultiCell(1.5,0.9, iconv( 'UTF-8','cp874' , "จังหวัด"),0 ,'C' );


$pdf->setXY(14.1,2.55);
$pdf->Cell(2.0,0.9, "",1,1,"c" );

$pdf->setXY(14.1,2.55);
$pdf->MultiCell(2.0,0.9, iconv( 'UTF-8','cp874' , "เบอร์ผู้รับสินค้า"),0 ,'C' );

$pdf->setXY(16.1,2.55);
$pdf->Cell(1.5,0.9, "",1,1,"c" );

$pdf->setXY(16.1,2.55);
$pdf->MultiCell(1.5,0.9, iconv( 'UTF-8','cp874' , "ประเภทสินค้า"),0 ,'C' );


$pdf->setXY(17.6,2.55);
$pdf->Cell(2.0,0.9, "",1,1,"c" );

$pdf->setXY(17.6,2.55);
$pdf->MultiCell(2.0,0.9, iconv( 'UTF-8','cp874' , "ประเภทบริการ"),0 ,'C' );

$pdf->setXY(19.6,2.55);
$pdf->Cell(2.0,0.9, "",1,1,"c" );

$pdf->setXY(19.6,2.55);
$pdf->MultiCell(2.0,0.9, iconv( 'UTF-8','cp874' , "ประเภทอุณหภูมิ"),0 ,'C' );

$pdf->setXY(21.6,2.55);
$pdf->Cell(2.0,0.9, "",1,1,"c" );

$pdf->setXY(21.6,2.55);
$pdf->MultiCell(2.0,0.9, iconv( 'UTF-8','cp874' , "บริการจัดส่ง (SLA)"),0 ,'C' );

$pdf->setXY(23.6,2.55);
$pdf->Cell(1.2,0.9, "",1,1,"c" );

$pdf->setXY(23.6,2.55);
$pdf->MultiCell(1.2,0.45, iconv( 'UTF-8','cp874' , "ระบุขนาด"),0 ,'C' );

$pdf->setXY(23.6,2.95);
$pdf->MultiCell(1.2,0.4, iconv( 'UTF-8','cp874' , "กล่อง"),0 ,'C' );


$pdf->setXY(24.8,2.55);
$pdf->Cell(1.2,0.9, "",1,1,"c" );

$pdf->setXY(24.8,2.55);
$pdf->MultiCell(1.2,0.45, iconv( 'UTF-8','cp874' , "น้ำหนัก/"),0 ,'C' );

$pdf->setXY(24.8,2.95);
$pdf->MultiCell(1.2,0.4, iconv( 'UTF-8','cp874' , "กล่อง"),0 ,'C' );

$pdf->setXY(26.0,2.55);
$pdf->Cell(1.2,0.9, "",1,1,"c" );

$pdf->setXY(26.0,2.55);
$pdf->MultiCell(1.2,0.45, iconv( 'UTF-8','cp874' , "จำนวน"),0 ,'C' );

$pdf->setXY(26.0,2.95);
$pdf->MultiCell(1.2,0.4, iconv( 'UTF-8','cp874' , "กล่อง"),0 ,'C' );


$pdf->setXY(27.2,2.55);
$pdf->Cell(2.1,0.9, "",1,1,"c" );

$pdf->setXY(27.2,2.55);
$pdf->MultiCell(2.1,0.9, iconv( 'UTF-8','cp874' , "หมายเหตุ"),0 ,'C' );
	
	
$j=6;
while($objResult = mysqli_fetch_array($objQuery))
{	
	
$ref_id = substr($objResult["ref_id"],0,2);	
	
if($ref_id=='SO'){	
$strSQL15 = "SELECT iv_no FROM hos__so WHERE ref_id = '".$objResult["ref_id"]."' ";
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResult15= mysqli_fetch_array($objQuery15);
	
$iv_no =$objResult15["iv_no"];	
$customer_name = $objResult["customer_name"];
$address_name = $objResult["address_name"];	
$customer_tel = $objResult["customer_tel"];	
	
}else if($ref_id=='BR'){
	
$strSQL15 = "SELECT iv_no FROM hos__br WHERE ref_id_br = '".$objResult["ref_id"]."' ";
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResult15= mysqli_fetch_array($objQuery15);
	
$iv_no =$objResult15["iv_no"];	
$customer_name = $objResult["customer_name"];
$address_name = $objResult["address_name"];	
$customer_tel = $objResult["customer_tel"];	

}else if($ref_id=='CH'){
	
$strSQL15 = "SELECT iv_no FROM hos__change WHERE ref_id = '".$objResult["ref_id"]."' ";
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResult15= mysqli_fetch_array($objQuery15);
	
$iv_no =$objResult15["iv_no"];	
$customer_name = $objResult["customer_name"];
$address_name = $objResult["address_name"];	
$customer_tel = $objResult["customer_tel"];	

}else if($ref_id=='BS'){
	
$strSQL15 = "SELECT iv_no FROM hos__consig WHERE ref_id = '".$objResult["ref_id"]."' ";
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResult15= mysqli_fetch_array($objQuery15);
	
$iv_no =$objResult15["iv_no"];	
$customer_name = $objResult["customer_name"];
$address_name = $objResult["address_name"];	
$customer_tel = $objResult["customer_tel"];	
		
}else{
	
$strSQL15 = "SELECT doc_no,customer_name,address1,address2,province,postcode,tel FROM so__main WHERE ref_id = '".$objResult["ref_id"]."' ";
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResult15= mysqli_fetch_array($objQuery15);
	
$iv_no =$objResult15["doc_no"];	
$customer_name = $objResult15["customer_name"];
$address1 = $objResult15["address1"];	
$address2 = $objResult15["address2"];	
$province = $objResult15["province"];	
$postcode = $objResult15["postcode"];		
$address_name = "$address1 $address2 $province $postcode";	
$customer_tel = $objResult15["tel"];	
	
}
	
$pdf->setX(0.3);
$pdf->Cell(0.8,1.2, iconv('UTF-8','cp874', "$j"),1,0,'C');
$pdf->Cell(1.5,1.2, iconv('UTF-8','cp874', "$iv_no"),1,0,'C');
$pdf->Cell(2.5,1.2, iconv('UTF-8','cp874', "$customer_name"),1,0,'L');
$pdf->Cell(6.0,1.2, '',1,0,'L');
$addressY = $pdf->GetY();
$addressX = $pdf->GetX();
$pdf->SetXY($addressX - 6.0, $addressY);
$pdf->MultiCell(6.0,0.4, iconv('UTF-8//IGNORE','cp874//IGNORE', "$address_name"),0,'L');
$pdf->SetXY($addressX, $addressY);
$pdf->Cell(1.5,1.2, iconv('UTF-8','cp874', ""),1,0,'C');
$pdf->Cell(1.5,1.2, iconv('UTF-8','cp874', ""),1,0,'C');	
$pdf->Cell(2.0,1.2, iconv('UTF-8','cp874', "$customer_tel"),1,1,'L');
	

$j++;


}
	
//แถว 1
$pdf->setXY(0.3,3.45);
$pdf->Cell(0.8,1.2, "",1,1,"c" );	

$pdf->setXY(1.1,3.45);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->setXY(2.6,3.45);
$pdf->Cell(2.5,1.2, "",1,1,"c" );


$pdf->setXY(5.1,3.45);
$pdf->Cell(6.0,1.2, "",1,1,"c" );

$pdf->setXY(11.1,3.45);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(12.6,3.45);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(14.1,3.45);
$pdf->Cell(2.0,1.2, "",1,1,"c" );


$pdf->setXY(16.1,3.45);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',9);
$pdf->setXY(16.1,3.45);
$pdf->MultiCell(1.5,1.2, iconv( 'UTF-8','cp874' , "เครื่องมือแพทย์"),0 ,'C' );


$pdf->setXY(17.6,3.45);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',7);
//1
$pdf->setXY(17.7,3.65);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,3.55);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการสินค้าทั่วไป"),0 ,'L' );

$pdf->setXY(17.7,3.95);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,3.85);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งกล่องโฟม"),0 ,'L' );

$pdf->setXY(17.7,4.25);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,4.2);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งผัก-ผลไม้"),0 ,'L' );






$pdf->setXY(19.6,3.45);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//2
$pdf->setXY(19.7,3.65);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,3.55);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ไม่ควบคุมอุณหภูมิ"),0 ,'L' );

$pdf->setXY(19.7,3.95);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,3.85);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Chilled 2-8 C"),0 ,'L' );

$pdf->setXY(19.7,4.25);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,4.2);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Frozen -15 C"),0 ,'L' );





$pdf->setXY(21.6,3.45);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//3
$pdf->setXY(21.7,3.65);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,3.55);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ด่วน 1 วัน"),0 ,'L' );

$pdf->setXY(21.7,3.95);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,3.85);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ธรรมดา 2-3 วัน"),0 ,'L' );

/*$pdf->setXY(21.7,4.25);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,4.2);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ภายในวัน"),0 ,'L' );*/



$pdf->setXY(23.6,3.45);
$pdf->Cell(1.2,1.2, "",1,1,"c" );

$pdf->setXY(24.8,3.45);
$pdf->Cell(1.2,1.2, "",1,1,"c" );



$pdf->setXY(26.0,3.45);
$pdf->Cell(1.2,1.2, "",1,1,"c" );


$pdf->setXY(27.2,3.45);
$pdf->Cell(2.1,1.2, "",1,1,"c" );





//แถว 2
$pdf->setXY(0.3,4.65);
$pdf->Cell(0.8,1.2, "",1,1,"c" );	

$pdf->setXY(1.1,4.65);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->setXY(2.6,4.65);
$pdf->Cell(2.5,1.2, "",1,1,"c" );


$pdf->setXY(5.1,4.65);
$pdf->Cell(6.0,1.2, "",1,1,"c" );

$pdf->setXY(11.1,4.65);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(12.6,4.65);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(14.1,4.65);
$pdf->Cell(2.0,1.2, "",1,1,"c" );


$pdf->setXY(16.1,4.65);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',9);
$pdf->setXY(16.1,4.65);
$pdf->MultiCell(1.5,1.2, iconv( 'UTF-8','cp874' , "เครื่องมือแพทย์"),0 ,'C' );


$pdf->setXY(17.6,4.65);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',7);
//1
$pdf->setXY(17.7,4.85);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,4.75);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการสินค้าทั่วไป"),0 ,'L' );

$pdf->setXY(17.7,5.15);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,5.05);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งกล่องโฟม"),0 ,'L' );

$pdf->setXY(17.7,5.45);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,5.4);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งผัก-ผลไม้"),0 ,'L' );






$pdf->setXY(19.6,4.65);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//2
$pdf->setXY(19.7,4.85);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,4.75);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ไม่ควบคุมอุณหภูมิ"),0 ,'L' );

$pdf->setXY(19.7,5.15);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,5.05);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Chilled 2-8 C"),0 ,'L' );

$pdf->setXY(19.7,5.45);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,5.4);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Frozen -15 C"),0 ,'L' );





$pdf->setXY(21.6,4.65);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//3
$pdf->setXY(21.7,4.85);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,4.75);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ด่วน 1 วัน"),0 ,'L' );

$pdf->setXY(21.7,5.15);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,5.05);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ธรรมดา 2-3 วัน"),0 ,'L' );

/*$pdf->setXY(21.7,5.45);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,5.4);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ภายในวัน"),0 ,'L' );*/



$pdf->setXY(23.6,4.65);
$pdf->Cell(1.2,1.2, "",1,1,"c" );

$pdf->setXY(24.8,4.65);
$pdf->Cell(1.2,1.2, "",1,1,"c" );



$pdf->setXY(26.0,4.65);
$pdf->Cell(1.2,1.2, "",1,1,"c" );


$pdf->setXY(27.2,4.65);
$pdf->Cell(2.1,1.2, "",1,1,"c" );





//แถว 3
$pdf->setXY(0.3,5.85);
$pdf->Cell(0.8,1.2, "",1,1,"c" );	

$pdf->setXY(1.1,5.85);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->setXY(2.6,5.85);
$pdf->Cell(2.5,1.2, "",1,1,"c" );


$pdf->setXY(5.1,5.85);
$pdf->Cell(6.0,1.2, "",1,1,"c" );

$pdf->setXY(11.1,5.85);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(12.6,5.85);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(14.1,5.85);
$pdf->Cell(2.0,1.2, "",1,1,"c" );


$pdf->setXY(16.1,5.85);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',9);
$pdf->setXY(16.1,5.85);
$pdf->MultiCell(1.5,1.2, iconv( 'UTF-8','cp874' , "เครื่องมือแพทย์"),0 ,'C' );


$pdf->setXY(17.6,5.85);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',7);
//1
$pdf->setXY(17.7,6.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,5.95);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการสินค้าทั่วไป"),0 ,'L' );

$pdf->setXY(17.7,6.35);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,6.25);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งกล่องโฟม"),0 ,'L' );

$pdf->setXY(17.7,6.65);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,6.6);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งผัก-ผลไม้"),0 ,'L' );






$pdf->setXY(19.6,5.85);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//2
$pdf->setXY(19.7,6.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,5.95);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ไม่ควบคุมอุณหภูมิ"),0 ,'L' );

$pdf->setXY(19.7,6.35);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,6.25);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Chilled 2-8 C"),0 ,'L' );

$pdf->setXY(19.7,6.65);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,6.6);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Frozen -15 C"),0 ,'L' );





$pdf->setXY(21.6,5.85);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//3
$pdf->setXY(21.7,6.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,5.95);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ด่วน 1 วัน"),0 ,'L' );

$pdf->setXY(21.7,6.35);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,6.25);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ธรรมดา 2-3 วัน"),0 ,'L' );

/*$pdf->setXY(21.7,6.65);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,6.6);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ภายในวัน"),0 ,'L' );*/



$pdf->setXY(23.6,5.85);
$pdf->Cell(1.2,1.2, "",1,1,"c" );

$pdf->setXY(24.8,5.85);
$pdf->Cell(1.2,1.2, "",1,1,"c" );



$pdf->setXY(26.0,5.85);
$pdf->Cell(1.2,1.2, "",1,1,"c" );


$pdf->setXY(27.2,5.85);
$pdf->Cell(2.1,1.2, "",1,1,"c" );



//แถว 4
$pdf->setXY(0.3,7.05);
$pdf->Cell(0.8,1.2, "",1,1,"c" );	

$pdf->setXY(1.1,7.05);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->setXY(2.6,7.05);
$pdf->Cell(2.5,1.2, "",1,1,"c" );


$pdf->setXY(5.1,7.05);
$pdf->Cell(6.0,1.2, "",1,1,"c" );

$pdf->setXY(11.1,7.05);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(12.6,7.05);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(14.1,7.05);
$pdf->Cell(2.0,1.2, "",1,1,"c" );


$pdf->setXY(16.1,7.05);
$pdf->Cell(1.5,1.2, "",1,1,"c" );
$pdf->SetFont('angsa','',9);
$pdf->setXY(16.1,7.05);
$pdf->MultiCell(1.5,1.2, iconv( 'UTF-8','cp874' , "เครื่องมือแพทย์"),0 ,'C' );



$pdf->setXY(17.6,7.05);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',7);
//1
$pdf->setXY(17.7,7.25);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,7.15);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการสินค้าทั่วไป"),0 ,'L' );

$pdf->setXY(17.7,7.55);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,7.45);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งกล่องโฟม"),0 ,'L' );

$pdf->setXY(17.7,7.85);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,7.8);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งผัก-ผลไม้"),0 ,'L' );






$pdf->setXY(19.6,7.05);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//2
$pdf->setXY(19.7,7.25);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,7.15);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ไม่ควบคุมอุณหภูมิ"),0 ,'L' );

$pdf->setXY(19.7,7.55);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,7.45);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Chilled 2-8 C"),0 ,'L' );

$pdf->setXY(19.7,7.85);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,7.8);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Frozen -15 C"),0 ,'L' );





$pdf->setXY(21.6,7.05);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//3
$pdf->setXY(21.7,7.25);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,7.15);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ด่วน 1 วัน"),0 ,'L' );

$pdf->setXY(21.7,7.55);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,7.45);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ธรรมดา 2-3 วัน"),0 ,'L' );

/*$pdf->setXY(21.7,7.85);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,7.8);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ภายในวัน"),0 ,'L' );*/



$pdf->setXY(23.6,7.05);
$pdf->Cell(1.2,1.2, "",1,1,"c" );

$pdf->setXY(24.8,7.05);
$pdf->Cell(1.2,1.2, "",1,1,"c" );



$pdf->setXY(26.0,7.05);
$pdf->Cell(1.2,1.2, "",1,1,"c" );


$pdf->setXY(27.2,7.05);
$pdf->Cell(2.1,1.2, "",1,1,"c" );



//แถว 5
$pdf->setXY(0.3,8.25);
$pdf->Cell(0.8,1.2, "",1,1,"c" );	

$pdf->setXY(1.1,8.25);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->setXY(2.6,8.25);
$pdf->Cell(2.5,1.2, "",1,1,"c" );


$pdf->setXY(5.1,8.25);
$pdf->Cell(6.0,1.2, "",1,1,"c" );

$pdf->setXY(11.1,8.25);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(12.6,8.25);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(14.1,8.25);
$pdf->Cell(2.0,1.2, "",1,1,"c" );


$pdf->setXY(16.1,8.25);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',9);
$pdf->setXY(16.1,8.25);
$pdf->MultiCell(1.5,1.2, iconv( 'UTF-8','cp874' , "เครื่องมือแพทย์"),0 ,'C' );


$pdf->setXY(17.6,8.25);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',7);
//1
$pdf->setXY(17.7,8.45);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,8.35);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการสินค้าทั่วไป"),0 ,'L' );

$pdf->setXY(17.7,8.75);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,8.65);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งกล่องโฟม"),0 ,'L' );

$pdf->setXY(17.7,9.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,9.0);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งผัก-ผลไม้"),0 ,'L' );






$pdf->setXY(19.6,8.25);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//2
$pdf->setXY(19.7,8.45);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,8.35);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ไม่ควบคุมอุณหภูมิ"),0 ,'L' );

$pdf->setXY(19.7,8.75);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,8.65);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Chilled 2-8 C"),0 ,'L' );

$pdf->setXY(19.7,9.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,9.0);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Frozen -15 C"),0 ,'L' );





$pdf->setXY(21.6,8.25);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//3
$pdf->setXY(21.7,8.45);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,8.35);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ด่วน 1 วัน"),0 ,'L' );

$pdf->setXY(21.7,8.75);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,8.65);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ธรรมดา 2-3 วัน"),0 ,'L' );

/*$pdf->setXY(21.7,9.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,9.0);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ภายในวัน"),0 ,'L' );*/



$pdf->setXY(23.6,8.25);
$pdf->Cell(1.2,1.2, "",1,1,"c" );

$pdf->setXY(24.8,8.25);
$pdf->Cell(1.2,1.2, "",1,1,"c" );



$pdf->setXY(26.0,8.25);
$pdf->Cell(1.2,1.2, "",1,1,"c" );


$pdf->setXY(27.2,8.25);
$pdf->Cell(2.1,1.2, "",1,1,"c" );


$pdf->setXY(27.2,8.25);
$pdf->Cell(2.1,1.2, "",1,1,"c" );
	
	
//แถว 6
$pdf->setXY(0.3,9.45);
$pdf->Cell(0.8,1.2, "",1,1,"c" );	

$pdf->setXY(1.1,9.45);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->setXY(2.6,9.45);
$pdf->Cell(2.5,1.2, "",1,1,"c" );


$pdf->setXY(5.1,9.45);
$pdf->Cell(6.0,1.2, "",1,1,"c" );

$pdf->setXY(11.1,9.45);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(12.6,9.45);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(14.1,9.45);
$pdf->Cell(2.0,1.2, "",1,1,"c" );


$pdf->setXY(16.1,9.45);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',9);
$pdf->setXY(16.1,9.45);
$pdf->MultiCell(1.5,1.2, iconv( 'UTF-8','cp874' , "เครื่องมือแพทย์"),0 ,'C' );


$pdf->setXY(17.6,9.45);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',7);
//1
$pdf->setXY(17.7,9.65);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,9.55);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการสินค้าทั่วไป"),0 ,'L' );

$pdf->setXY(17.7,9.95);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,9.85);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งกล่องโฟม"),0 ,'L' );

$pdf->setXY(17.7,10.25);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,10.15);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งผัก-ผลไม้"),0 ,'L' );






$pdf->setXY(19.6,9.45);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//2
$pdf->setXY(19.7,9.65);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,9.55);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ไม่ควบคุมอุณหภูมิ"),0 ,'L' );

$pdf->setXY(19.7,9.95);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,9.85);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Chilled 2-8 C"),0 ,'L' );

$pdf->setXY(19.7,10.25);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,10.15);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Frozen -15 C"),0 ,'L' );





$pdf->setXY(21.6,9.45);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//3
$pdf->setXY(21.7,9.65);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,9.55);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ด่วน 1 วัน"),0 ,'L' );

$pdf->setXY(21.7,9.95);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,9.85);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ธรรมดา 2-3 วัน"),0 ,'L' );

/*$pdf->setXY(21.7,10.25);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,10.15);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ภายในวัน"),0 ,'L' );*/



$pdf->setXY(23.6,9.45);
$pdf->Cell(1.2,1.2, "",1,1,"c" );

$pdf->setXY(24.8,9.45);
$pdf->Cell(1.2,1.2, "",1,1,"c" );



$pdf->setXY(26.0,9.45);
$pdf->Cell(1.2,1.2, "",1,1,"c" );


$pdf->setXY(27.2,9.45);
$pdf->Cell(2.1,1.2, "",1,1,"c" );


$pdf->setXY(27.2,9.45);
$pdf->Cell(2.1,1.2, "",1,1,"c" );
	
//แถว 7
$pdf->setXY(0.3,10.65);
$pdf->Cell(0.8,1.2, "",1,1,"c" );	

$pdf->setXY(1.1,10.65);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->setXY(2.6,10.65);
$pdf->Cell(2.5,1.2, "",1,1,"c" );


$pdf->setXY(5.1,10.65);
$pdf->Cell(6.0,1.2, "",1,1,"c" );

$pdf->setXY(11.1,10.65);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(12.6,10.65);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(14.1,10.65);
$pdf->Cell(2.0,1.2, "",1,1,"c" );


$pdf->setXY(16.1,10.65);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',9);
$pdf->setXY(16.1,10.65);
$pdf->MultiCell(1.5,1.2, iconv( 'UTF-8','cp874' , "เครื่องมือแพทย์"),0 ,'C' );


$pdf->setXY(17.6,10.65);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',7);
//1
$pdf->setXY(17.7,10.85);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,10.75);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการสินค้าทั่วไป"),0 ,'L' );

$pdf->setXY(17.7,11.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,10.95);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งกล่องโฟม"),0 ,'L' );

$pdf->setXY(17.7,11.35);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,11.25);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งผัก-ผลไม้"),0 ,'L' );






$pdf->setXY(19.6,10.65);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//2
$pdf->setXY(19.7,10.85);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,10.75);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ไม่ควบคุมอุณหภูมิ"),0 ,'L' );

$pdf->setXY(19.7,11.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,10.95);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Chilled 2-8 C"),0 ,'L' );

$pdf->setXY(19.7,11.35);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,11.25);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Frozen -15 C"),0 ,'L' );





$pdf->setXY(21.6,10.65);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//3
$pdf->setXY(21.7,10.85);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,10.75);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ด่วน 1 วัน"),0 ,'L' );

$pdf->setXY(21.7,11.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,10.95);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ธรรมดา 2-3 วัน"),0 ,'L' );

/*$pdf->setXY(21.7,11.35);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,11.25);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ภายในวัน"),0 ,'L' );*/



$pdf->setXY(23.6,10.65);
$pdf->Cell(1.2,1.2, "",1,1,"c" );

$pdf->setXY(24.8,10.65);
$pdf->Cell(1.2,1.2, "",1,1,"c" );



$pdf->setXY(26.0,10.65);
$pdf->Cell(1.2,1.2, "",1,1,"c" );


$pdf->setXY(27.2,10.65);
$pdf->Cell(2.1,1.2, "",1,1,"c" );


$pdf->setXY(27.2,10.65);
$pdf->Cell(2.1,1.2, "",1,1,"c" );
	
	
//แถว 8
$pdf->setXY(0.3,11.85);
$pdf->Cell(0.8,1.2, "",1,1,"c" );	

$pdf->setXY(1.1,11.85);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->setXY(2.6,11.85);
$pdf->Cell(2.5,1.2, "",1,1,"c" );


$pdf->setXY(5.1,11.85);
$pdf->Cell(6.0,1.2, "",1,1,"c" );

$pdf->setXY(11.1,11.85);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(12.6,11.85);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(14.1,11.85);
$pdf->Cell(2.0,1.2, "",1,1,"c" );


$pdf->setXY(16.1,11.85);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',9);
$pdf->setXY(16.1,11.85);
$pdf->MultiCell(1.5,1.2, iconv( 'UTF-8','cp874' , "เครื่องมือแพทย์"),0 ,'C' );


$pdf->setXY(17.6,11.85);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',7);
//1
$pdf->setXY(17.7,12.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,11.95);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการสินค้าทั่วไป"),0 ,'L' );

$pdf->setXY(17.7,12.35);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,12.25);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งกล่องโฟม"),0 ,'L' );

$pdf->setXY(17.7,12.65);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,12.55);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งผัก-ผลไม้"),0 ,'L' );






$pdf->setXY(19.6,11.85);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//2
$pdf->setXY(19.7,12.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,11.95);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ไม่ควบคุมอุณหภูมิ"),0 ,'L' );

$pdf->setXY(19.7,12.35);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,12.25);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Chilled 2-8 C"),0 ,'L' );

$pdf->setXY(19.7,12.65);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,12.55);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Frozen -15 C"),0 ,'L' );





$pdf->setXY(21.6,11.85);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//3
$pdf->setXY(21.7,12.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,11.95);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ด่วน 1 วัน"),0 ,'L' );

$pdf->setXY(21.7,12.35);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,12.25);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ธรรมดา 2-3 วัน"),0 ,'L' );

/*$pdf->setXY(21.7,12.65);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,12.55);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ภายในวัน"),0 ,'L' );*/



$pdf->setXY(23.6,11.85);
$pdf->Cell(1.2,1.2, "",1,1,"c" );

$pdf->setXY(24.8,11.85);
$pdf->Cell(1.2,1.2, "",1,1,"c" );



$pdf->setXY(26.0,11.85);
$pdf->Cell(1.2,1.2, "",1,1,"c" );


$pdf->setXY(27.2,11.85);
$pdf->Cell(2.1,1.2, "",1,1,"c" );


$pdf->setXY(27.2,11.85);
$pdf->Cell(2.1,1.2, "",1,1,"c" );
	
	
//แถว 8
$pdf->setXY(0.3,13.05);
$pdf->Cell(0.8,1.2, "",1,1,"c" );	

$pdf->setXY(1.1,13.05);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->setXY(2.6,13.05);
$pdf->Cell(2.5,1.2, "",1,1,"c" );


$pdf->setXY(5.1,13.05);
$pdf->Cell(6.0,1.2, "",1,1,"c" );

$pdf->setXY(11.1,13.05);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(12.6,13.05);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(14.1,13.05);
$pdf->Cell(2.0,1.2, "",1,1,"c" );


$pdf->setXY(16.1,13.05);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',9);
$pdf->setXY(16.1,13.05);
$pdf->MultiCell(1.5,1.2, iconv( 'UTF-8','cp874' , "เครื่องมือแพทย์"),0 ,'C' );


$pdf->setXY(17.6,13.05);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',7);
//1
$pdf->setXY(17.7,13.25);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,13.15);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการสินค้าทั่วไป"),0 ,'L' );

$pdf->setXY(17.7,13.55);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,13.45);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งกล่องโฟม"),0 ,'L' );

$pdf->setXY(17.7,13.85);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,13.75);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งผัก-ผลไม้"),0 ,'L' );






$pdf->setXY(19.6,13.05);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//2
$pdf->setXY(19.7,13.25);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,13.15);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ไม่ควบคุมอุณหภูมิ"),0 ,'L' );

$pdf->setXY(19.7,13.55);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,13.45);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Chilled 2-8 C"),0 ,'L' );

$pdf->setXY(19.7,13.85);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,13.75);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Frozen -15 C"),0 ,'L' );





$pdf->setXY(21.6,13.05);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//3
$pdf->setXY(21.7,13.25);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,13.15);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ด่วน 1 วัน"),0 ,'L' );

$pdf->setXY(21.7,13.55);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,13.45);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ธรรมดา 2-3 วัน"),0 ,'L' );

/*$pdf->setXY(21.7,13.85);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,13.75);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ภายในวัน"),0 ,'L' );*/



$pdf->setXY(23.6,13.05);
$pdf->Cell(1.2,1.2, "",1,1,"c" );

$pdf->setXY(24.8,13.05);
$pdf->Cell(1.2,1.2, "",1,1,"c" );



$pdf->setXY(26.0,13.05);
$pdf->Cell(1.2,1.2, "",1,1,"c" );


$pdf->setXY(27.2,13.05);
$pdf->Cell(2.1,1.2, "",1,1,"c" );


$pdf->setXY(27.2,13.05);
$pdf->Cell(2.1,1.2, "",1,1,"c" );
	
	
//แถว 8
$pdf->setXY(0.3,14.25);
$pdf->Cell(0.8,1.2, "",1,1,"c" );	

$pdf->setXY(1.1,14.25);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->setXY(2.6,14.25);
$pdf->Cell(2.5,1.2, "",1,1,"c" );


$pdf->setXY(5.1,14.25);
$pdf->Cell(6.0,1.2, "",1,1,"c" );

$pdf->setXY(11.1,14.25);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(12.6,14.25);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(14.1,14.25);
$pdf->Cell(2.0,1.2, "",1,1,"c" );


$pdf->setXY(16.1,14.25);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',9);
$pdf->setXY(16.1,14.25);
$pdf->MultiCell(1.5,1.2, iconv( 'UTF-8','cp874' , "เครื่องมือแพทย์"),0 ,'C' );


$pdf->setXY(17.6,14.25);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',7);
//1
$pdf->setXY(17.7,14.45);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,14.35);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการสินค้าทั่วไป"),0 ,'L' );

$pdf->setXY(17.7,14.75);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,14.65);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งกล่องโฟม"),0 ,'L' );

$pdf->setXY(17.7,15.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,14.95);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งผัก-ผลไม้"),0 ,'L' );






$pdf->setXY(19.6,14.25);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//2
$pdf->setXY(19.7,14.45);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,14.35);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ไม่ควบคุมอุณหภูมิ"),0 ,'L' );

$pdf->setXY(19.7,14.75);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,14.65);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Chilled 2-8 C"),0 ,'L' );

$pdf->setXY(19.7,15.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,14.95);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Frozen -15 C"),0 ,'L' );





$pdf->setXY(21.6,14.25);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//3
$pdf->setXY(21.7,14.45);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,14.35);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ด่วน 1 วัน"),0 ,'L' );

$pdf->setXY(21.7,14.75);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,14.65);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ธรรมดา 2-3 วัน"),0 ,'L' );

/*$pdf->setXY(21.7,15.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,14.95);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ภายในวัน"),0 ,'L' );*/



$pdf->setXY(23.6,14.25);
$pdf->Cell(1.2,1.2, "",1,1,"c" );

$pdf->setXY(24.8,14.25);
$pdf->Cell(1.2,1.2, "",1,1,"c" );



$pdf->setXY(26.0,14.25);
$pdf->Cell(1.2,1.2, "",1,1,"c" );


$pdf->setXY(27.2,14.25);
$pdf->Cell(2.1,1.2, "",1,1,"c" );


$pdf->setXY(27.2,14.25);
$pdf->Cell(2.1,1.2, "",1,1,"c" );
	

	
	
	
$pdf->SetFillColor(204,204,204);

$pdf->Cell(23.25,0.4,iconv('UTF-8','cp874','รวม'),1,0,"R",true);
$pdf->Cell(1.2,0.4,iconv('UTF-8','cp874',''),1,0,"R",true);
$pdf->Cell(1.2,0.4,iconv('UTF-8','cp874',''),1,0,"R",true);
$pdf->Cell(1.2,0.4,iconv('UTF-8','cp874',''),1,0,"R",true);
$pdf->Cell(2.1,0.4,iconv('UTF-8','cp874',''),1,0,"R",true);
		
//$pdf->setXY(0.3,11.85);
//$pdf->Cell(29,1.6, "",1,1,"c" );

$pdf->setXY(1.0,15.8);
$pdf->MultiCell(29,0.4, iconv( 'UTF-8','cp874' , "หมายเหตุ"),0 ,'L' );


$pdf->setXY(1.0,16.2);
$pdf->MultiCell(14,0.4, iconv( 'UTF-8','cp874' , "1. ประเภทสินค้าหากเป็นยาเย็นระบุ (ยาเย็น) / ยาธรรมดาระบุ (ยา)"),0 ,'L' );

$pdf->setXY(1.0,16.6);
$pdf->MultiCell(14,0.4, iconv( 'UTF-8','cp874' , "2.  ช่องประเภทสินค้า ระบุสินค้าที่บรรจุในกล่อง(เนื้อแช่แข็ง, ปลาแช่แข็ง, เนยแช่แข็ง, ผลไม้หรือสินค้าประเภทอื่น ๆ ฯลฯ)"),0 ,'L' );

$pdf->setXY(1.0,17.0);
$pdf->MultiCell(14,0.4, iconv( 'UTF-8','cp874' , "3. สินค้าประเภทผัก-ผลไม้ หากใช้บริการขนส่งผัก-ผลไม้ จะต้องเป็นลูกหรือเป็นผลเปลือกแข็งเท่านั้น"),0 ,'L' );


$pdf->setXY(15.0,16.2);
$pdf->MultiCell(14,0.4, iconv( 'UTF-8','cp874' , "4.  ช่องระบุขนาดกล่อง ระบุขนาดกล่องดังนี้ S1, S2,  A1, A2, B1, B2 / บริการขนส่งผัก-ผลไม้ ไม่ต้องระบุขนาดกล่อง แต่ต้องระบุน้ำหนัก (กิโลกรัม) ต่อกล่อง"),0 ,'L' );

$pdf->setXY(15.0,16.6);
$pdf->MultiCell(14,0.4, iconv( 'UTF-8','cp874' , "5. กรณีที่ผู้รับปลายทางไม่มีเบอร์โทรติดต่อให้ใช้เบอร์โทรติดต่อของผู้ส่งสินค้าแทน"),0 ,'L' );

$pdf->setXY(15.0,17.0);
$pdf->MultiCell(14,0.4, iconv( 'UTF-8','cp874' , "6. หากไม่ทราบวิธีคิดขนาดกล่อง ระบุน้ำหนักต่อกล่องในช่องน้ำหนักและปริมาตร กว้าง X ยาว X สูง (เซนติเมตร) ในช่องหมายเหตุ"),0 ,'L' );
	
$pdf->Cell(28.9,0.4,iconv('UTF-8','cp874',''),0,0,"C",true);
	
	
$pdf->SetFont('angsa','',8);	
$pdf->setXY(11,18.0);
$pdf->Cell(8,2.2, "",1,1,"c" );	
	
$pdf->setXY(11,18.1);
$pdf->MultiCell(8,0.3, iconv( 'UTF-8','cp874' , "ใบรายงานการส่งสินค้าหน้านี้เป็นใบรายงานการส่งสินค้าหน้าถัดมาที่ผู้ส่งสินค้า"),0 ,'C' );
	
$pdf->setXY(11,18.4);
$pdf->MultiCell(8,0.3, iconv( 'UTF-8','cp874' , "จะแนบไปกับใบรายงานการส่งสินค้าหน้าแรกด้วยทุกครั้ง(ถ้ามีการส่งหลายปลายทาง)และครอบคลุม"),0 ,'C' );
	
$pdf->setXY(11,18.7);
$pdf->MultiCell(8,0.3, iconv( 'UTF-8','cp874' , "คำรับรองของผู้ส่งสินค้าเช่นเดียวกันกับหน้าแรกทุกประการ"),0 ,'C' );

$pdf->setXY(11,19.0);
$pdf->MultiCell(8,0.3, iconv( 'UTF-8','cp874' , "(ลงชื่อผู้ส่งสินค้าทุกใบรายงานการส่งสินค้าหน้าถัดมา)"),0 ,'C' );
	
	
$pdf->setXY(11,19.8);
$pdf->MultiCell(8,0.3, iconv( 'UTF-8','cp874' , "ลงชื่อ  .................................................................  ผู้ส่งสินค้า วันที่ ............... / ................ / ..............."),0 ,'C' );
	
	
$pdf->Image("img/qrcode_inter.png",27.7,18.5,1.5,1.5);

$pdf->SetFont('angsa','',7);
$pdf->setXY(26.5,20.2);
$pdf->MultiCell(29,0, iconv( 'UTF-8','cp874' , "FM-RC-01, แก้ไขครั้งที่ 10.01-02-2026"),0 ,'L' );
	
	
}	



//หน้าที่ 3

$strSQL = "SELECT ref_id,customer_name,address_name,customer_tel FROM tb_register_data  WHERE start_date >= '".$start_date."' and start_date <= '".$end_date."' and type_company='".$company."' and bus_inter='1' LIMIT 10 OFFSET 15";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$Num_Rows = mysqli_num_rows($objQuery);

if($Num_Rows > 0){
//$pdf->AddPage();

$pdf->SetFont('angsa','',14);

$pdf->setXY(0.3,0.3);
$pdf->Cell(29.0,20.3, "",1,1,"c" );

$pdf->Image("img/inter_express.png",0.3,0.35,2.5,1.0);

$pdf->setXY(0.3,0.35);
$pdf->Cell(25.0,2.2, "",1,1,"c" );

//$pdf->SetFont('angsana','B',20);

$pdf->setXY(0.3,0.4);
$pdf->MultiCell(25, 0.6 , iconv( 'UTF-8','cp874' , "ใบรายงานการส่งสินค้า Delivery Manifest"),0 ,'C' );

$pdf->setXY(0.3,0.9);
$pdf->MultiCell(25, 0.6 , iconv( 'UTF-8','cp874' , "สำหรับบริการสินค้าทั่วไป (Ambient) บริการขนส่งกล่องโฟม (INTER FOAM) บริการขนส่งผัก-ผลไม้ (FRUIT DELIVERY) "),0 ,'C' );

$pdf->SetFont('angsa','',11);

$pdf->setXY(0.3,1.5);
$pdf->MultiCell(25, 0.6 , iconv( 'UTF-8','cp874' , "หน้าแรก แผ่นที่ 1 /……"),0 ,'L' );

$pdf->setXY(0.3,2.0);
$pdf->MultiCell(25, 0.6 , iconv( 'UTF-8','cp874' , "วันที่ …$start_date_th....."),0 ,'L' );


$pdf->SetFont('angsa','',12);

if($_GET["company"]=='3'){
$pdf->setXY(0.3,1.5);
$pdf->MultiCell(25, 0.5 , iconv( 'UTF-8','cp874' , "ผู้ส่งสินค้า/บริษัท…....................บริษัท ออลล์เวล ไลฟ์ จำกัด.........................….รหัสลูกค้า……...................…...................…....................….........."),0 ,'C' );

$pdf->setXY(0.3,2.0);
$pdf->MultiCell(25, 0.5 , iconv( 'UTF-8','cp874' , "ที่อยู่ผู้ส่ง...................73,75 ซ.จรัญสนิทวงศ์89/2 แขวงบางอ้อ เขตบางพลัด กรุงเทพมหานคร 10700....................เบอร์ผู้ส่งสินค้า ........02-424-3555....................."),0 ,'C' );

}
if($_GET["company"]=='4'){
	
$pdf->setXY(0.3,1.5);
$pdf->MultiCell(25, 0.5 , iconv( 'UTF-8','cp874' , "ผู้ส่งสินค้า/บริษัท…....................บริษัท โนเบิล เมด จำกัด........................….รหัสลูกค้า……...................…...................…....................….........."),0 ,'C' );

$pdf->setXY(0.3,2.0);
$pdf->MultiCell(25, 0.5 , iconv( 'UTF-8','cp874' , "ที่อยู่ผู้ส่ง....................73 ซ.จรัญสนิทวงศ์89/2 แขวงบางอ้อ เขตบางพลัด กรุงเทพมหานคร 10700........................เบอร์ผู้ส่งสินค้า ........02-880-5566.........................."),0 ,'C' );
	
}
	
$pdf->setXY(25.3,0.35);
$pdf->Cell(4.0,2.2, "",1,1,"c" );	

$pdf->SetFont('angsa','',14);
	
$pdf->setXY(25.3,0.8);
$pdf->MultiCell(4.0, 0.5 , iconv( 'UTF-8','cp874' , "สำหรับติดสติ๊กเกอร์"),0 ,'C' );

$pdf->setXY(25.3,1.5);
$pdf->MultiCell(4.0, 0.5 , iconv( 'UTF-8','cp874' , "M/F Number"),0 ,'C' );

$pdf->SetFont('angsa','',10);

$pdf->setXY(0.3,2.55);
$pdf->Cell(0.8,0.9, "",1,1,"c" );	

$pdf->setXY(0.3,2.55);
$pdf->MultiCell(0.8,0.9, iconv( 'UTF-8','cp874' , "ลำดับ"),0 ,'C' );

$pdf->setXY(1.1,2.55);
$pdf->Cell(1.5,0.9, "",1,1,"c" );

$pdf->setXY(1.1,2.55);
$pdf->MultiCell(1.5,0.9, iconv( 'UTF-8','cp874' , "เลขที่บิล"),0 ,'C' );

$pdf->setXY(2.6,2.55);
$pdf->Cell(2.5,0.9, "",1,1,"c" );

$pdf->setXY(2.6,2.55);
$pdf->MultiCell(2.5,0.9, iconv( 'UTF-8','cp874' , "ชื่อผู้รับสินค้า"),0 ,'C' );


$pdf->setXY(5.1,2.55);
$pdf->Cell(6.0,0.9, "",1,1,"c" );

$pdf->setXY(5.1,2.6);
$pdf->MultiCell(6.0,0.45, iconv( 'UTF-8','cp874' , "ที่อยู่ผู้รับสินค้า"),0 ,'C' );
$pdf->setXY(5.1,3.05);
$pdf->MultiCell(6.0,0.4, iconv( 'UTF-8','cp874' , "(ระบุบ้านเลขที่ หมู่ที่ หมู่บ้าน ถนน ตำบล/แขวง)"),0 ,'C' );


$pdf->setXY(11.1,2.55);
$pdf->Cell(1.5,0.9, "",1,1,"c" );

$pdf->setXY(11.1,2.55);
$pdf->MultiCell(1.5,0.9, iconv( 'UTF-8','cp874' , "อำเภอ/เขต"),0 ,'C' );

$pdf->setXY(12.6,2.55);
$pdf->Cell(1.5,0.9, "",1,1,"c" );

$pdf->setXY(12.6,2.55);
$pdf->MultiCell(1.5,0.9, iconv( 'UTF-8','cp874' , "จังหวัด"),0 ,'C' );


$pdf->setXY(14.1,2.55);
$pdf->Cell(2.0,0.9, "",1,1,"c" );

$pdf->setXY(14.1,2.55);
$pdf->MultiCell(2.0,0.9, iconv( 'UTF-8','cp874' , "เบอร์ผู้รับสินค้า"),0 ,'C' );

$pdf->setXY(16.1,2.55);
$pdf->Cell(1.5,0.9, "",1,1,"c" );

$pdf->setXY(16.1,2.55);
$pdf->MultiCell(1.5,0.9, iconv( 'UTF-8','cp874' , "ประเภทสินค้า"),0 ,'C' );


$pdf->setXY(17.6,2.55);
$pdf->Cell(2.0,0.9, "",1,1,"c" );

$pdf->setXY(17.6,2.55);
$pdf->MultiCell(2.0,0.9, iconv( 'UTF-8','cp874' , "ประเภทบริการ"),0 ,'C' );

$pdf->setXY(19.6,2.55);
$pdf->Cell(2.0,0.9, "",1,1,"c" );

$pdf->setXY(19.6,2.55);
$pdf->MultiCell(2.0,0.9, iconv( 'UTF-8','cp874' , "ประเภทอุณหภูมิ"),0 ,'C' );

$pdf->setXY(21.6,2.55);
$pdf->Cell(2.0,0.9, "",1,1,"c" );

$pdf->setXY(21.6,2.55);
$pdf->MultiCell(2.0,0.9, iconv( 'UTF-8','cp874' , "บริการจัดส่ง (SLA)"),0 ,'C' );

$pdf->setXY(23.6,2.55);
$pdf->Cell(1.2,0.9, "",1,1,"c" );

$pdf->setXY(23.6,2.55);
$pdf->MultiCell(1.2,0.45, iconv( 'UTF-8','cp874' , "ระบุขนาด"),0 ,'C' );

$pdf->setXY(23.6,2.95);
$pdf->MultiCell(1.2,0.4, iconv( 'UTF-8','cp874' , "กล่อง"),0 ,'C' );


$pdf->setXY(24.8,2.55);
$pdf->Cell(1.2,0.9, "",1,1,"c" );

$pdf->setXY(24.8,2.55);
$pdf->MultiCell(1.2,0.45, iconv( 'UTF-8','cp874' , "น้ำหนัก/"),0 ,'C' );

$pdf->setXY(24.8,2.95);
$pdf->MultiCell(1.2,0.4, iconv( 'UTF-8','cp874' , "กล่อง"),0 ,'C' );

$pdf->setXY(26.0,2.55);
$pdf->Cell(1.2,0.9, "",1,1,"c" );

$pdf->setXY(26.0,2.55);
$pdf->MultiCell(1.2,0.45, iconv( 'UTF-8','cp874' , "จำนวน"),0 ,'C' );

$pdf->setXY(26.0,2.95);
$pdf->MultiCell(1.2,0.4, iconv( 'UTF-8','cp874' , "กล่อง"),0 ,'C' );


$pdf->setXY(27.2,2.55);
$pdf->Cell(2.1,0.9, "",1,1,"c" );

$pdf->setXY(27.2,2.55);
$pdf->MultiCell(2.1,0.9, iconv( 'UTF-8','cp874' , "หมายเหตุ"),0 ,'C' );
	
	
$j=16;
while($objResult = mysqli_fetch_array($objQuery))
{	
	
$ref_id = substr($objResult["ref_id"],0,2);	
	
if($ref_id=='SO'){	
$strSQL15 = "SELECT iv_no FROM hos__so WHERE ref_id = '".$objResult["ref_id"]."' ";
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResult15= mysqli_fetch_array($objQuery15);
	
$iv_no =$objResult15["iv_no"];	
$customer_name = $objResult["customer_name"];
$address_name = $objResult["address_name"];	
$customer_tel = $objResult["customer_tel"];	
	
}else if($ref_id=='BR'){
	
$strSQL15 = "SELECT iv_no FROM hos__br WHERE ref_id_br = '".$objResult["ref_id"]."' ";
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResult15= mysqli_fetch_array($objQuery15);
	
$iv_no =$objResult15["iv_no"];	
$customer_name = $objResult["customer_name"];
$address_name = $objResult["address_name"];	
$customer_tel = $objResult["customer_tel"];	

}else if($ref_id=='CH'){
	
$strSQL15 = "SELECT iv_no FROM hos__change WHERE ref_id = '".$objResult["ref_id"]."' ";
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResult15= mysqli_fetch_array($objQuery15);
	
$iv_no =$objResult15["iv_no"];	
$customer_name = $objResult["customer_name"];
$address_name = $objResult["address_name"];	
$customer_tel = $objResult["customer_tel"];	

}else if($ref_id=='BS'){
	
$strSQL15 = "SELECT iv_no FROM hos__consig WHERE ref_id = '".$objResult["ref_id"]."' ";
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResult15= mysqli_fetch_array($objQuery15);
	
$iv_no =$objResult15["iv_no"];	
$customer_name = $objResult["customer_name"];
$address_name = $objResult["address_name"];	
$customer_tel = $objResult["customer_tel"];	
		
}else{
	
$strSQL15 = "SELECT doc_no,customer_name,address1,address2,province,postcode,tel FROM so__main WHERE ref_id = '".$objResult["ref_id"]."' ";
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResult15= mysqli_fetch_array($objQuery15);
	
$iv_no =$objResult15["doc_no"];	
$customer_name = $objResult15["customer_name"];
$address1 = $objResult15["address1"];	
$address2 = $objResult15["address2"];	
$province = $objResult15["province"];	
$postcode = $objResult15["postcode"];		
$address_name = "$address1 $address2 $province $postcode";	
$customer_tel = $objResult15["tel"];	
	
}
	
$pdf->setX(0.3);
$pdf->Cell(0.8,1.2, iconv('UTF-8','cp874', "$j"),1,0,'C');
$pdf->Cell(1.5,1.2, iconv('UTF-8','cp874', "$iv_no"),1,0,'C');
$pdf->Cell(2.5,1.2, iconv('UTF-8','cp874', "$customer_name"),1,0,'L');
$pdf->Cell(6.0,1.2, '',1,0,'L');
$addressY = $pdf->GetY();
$addressX = $pdf->GetX();
$pdf->SetXY($addressX - 6.0, $addressY);
$pdf->MultiCell(6.0,0.4, iconv('UTF-8//IGNORE','cp874//IGNORE', "$address_name"),0,'L');
$pdf->SetXY($addressX, $addressY);
$pdf->Cell(1.5,1.2, iconv('UTF-8','cp874', ""),1,0,'C');
$pdf->Cell(1.5,1.2, iconv('UTF-8','cp874', ""),1,0,'C');	
$pdf->Cell(2.0,1.2, iconv('UTF-8','cp874', "$customer_tel"),1,1,'L');
	

$j++;


}
	
//แถว 1
$pdf->setXY(0.3,3.45);
$pdf->Cell(0.8,1.2, "",1,1,"c" );	

$pdf->setXY(1.1,3.45);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->setXY(2.6,3.45);
$pdf->Cell(2.5,1.2, "",1,1,"c" );


$pdf->setXY(5.1,3.45);
$pdf->Cell(6.0,1.2, "",1,1,"c" );

$pdf->setXY(11.1,3.45);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(12.6,3.45);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(14.1,3.45);
$pdf->Cell(2.0,1.2, "",1,1,"c" );


$pdf->setXY(16.1,3.45);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',9);
$pdf->setXY(16.1,3.45);
$pdf->MultiCell(1.5,1.2, iconv( 'UTF-8','cp874' , "เครื่องมือแพทย์"),0 ,'C' );


$pdf->setXY(17.6,3.45);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',7);
//1
$pdf->setXY(17.7,3.65);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,3.55);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการสินค้าทั่วไป"),0 ,'L' );

$pdf->setXY(17.7,3.95);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,3.85);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งกล่องโฟม"),0 ,'L' );

$pdf->setXY(17.7,4.25);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,4.2);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งผัก-ผลไม้"),0 ,'L' );






$pdf->setXY(19.6,3.45);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//2
$pdf->setXY(19.7,3.65);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,3.55);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ไม่ควบคุมอุณหภูมิ"),0 ,'L' );

$pdf->setXY(19.7,3.95);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,3.85);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Chilled 2-8 C"),0 ,'L' );

$pdf->setXY(19.7,4.25);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,4.2);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Frozen -15 C"),0 ,'L' );





$pdf->setXY(21.6,3.45);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//3
$pdf->setXY(21.7,3.65);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,3.55);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ด่วน 1 วัน"),0 ,'L' );

$pdf->setXY(21.7,3.95);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,3.85);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ธรรมดา 2-3 วัน"),0 ,'L' );

/*$pdf->setXY(21.7,4.25);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,4.2);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ภายในวัน"),0 ,'L' );*/



$pdf->setXY(23.6,3.45);
$pdf->Cell(1.2,1.2, "",1,1,"c" );

$pdf->setXY(24.8,3.45);
$pdf->Cell(1.2,1.2, "",1,1,"c" );



$pdf->setXY(26.0,3.45);
$pdf->Cell(1.2,1.2, "",1,1,"c" );


$pdf->setXY(27.2,3.45);
$pdf->Cell(2.1,1.2, "",1,1,"c" );





//แถว 2
$pdf->setXY(0.3,4.65);
$pdf->Cell(0.8,1.2, "",1,1,"c" );	

$pdf->setXY(1.1,4.65);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->setXY(2.6,4.65);
$pdf->Cell(2.5,1.2, "",1,1,"c" );


$pdf->setXY(5.1,4.65);
$pdf->Cell(6.0,1.2, "",1,1,"c" );

$pdf->setXY(11.1,4.65);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(12.6,4.65);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(14.1,4.65);
$pdf->Cell(2.0,1.2, "",1,1,"c" );


$pdf->setXY(16.1,4.65);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',9);
$pdf->setXY(16.1,4.65);
$pdf->MultiCell(1.5,1.2, iconv( 'UTF-8','cp874' , "เครื่องมือแพทย์"),0 ,'C' );


$pdf->setXY(17.6,4.65);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',7);
//1
$pdf->setXY(17.7,4.85);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,4.75);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการสินค้าทั่วไป"),0 ,'L' );

$pdf->setXY(17.7,5.15);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,5.05);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งกล่องโฟม"),0 ,'L' );

$pdf->setXY(17.7,5.45);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,5.4);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งผัก-ผลไม้"),0 ,'L' );






$pdf->setXY(19.6,4.65);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//2
$pdf->setXY(19.7,4.85);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,4.75);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ไม่ควบคุมอุณหภูมิ"),0 ,'L' );

$pdf->setXY(19.7,5.15);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,5.05);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Chilled 2-8 C"),0 ,'L' );

$pdf->setXY(19.7,5.45);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,5.4);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Frozen -15 C"),0 ,'L' );





$pdf->setXY(21.6,4.65);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//3
$pdf->setXY(21.7,4.85);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,4.75);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ด่วน 1 วัน"),0 ,'L' );

$pdf->setXY(21.7,5.15);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,5.05);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ธรรมดา 2-3 วัน"),0 ,'L' );

/*$pdf->setXY(21.7,5.45);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,5.4);*/



$pdf->setXY(23.6,4.65);
$pdf->Cell(1.2,1.2, "",1,1,"c" );

$pdf->setXY(24.8,4.65);
$pdf->Cell(1.2,1.2, "",1,1,"c" );



$pdf->setXY(26.0,4.65);
$pdf->Cell(1.2,1.2, "",1,1,"c" );


$pdf->setXY(27.2,4.65);
$pdf->Cell(2.1,1.2, "",1,1,"c" );





//แถว 3
$pdf->setXY(0.3,5.85);
$pdf->Cell(0.8,1.2, "",1,1,"c" );	

$pdf->setXY(1.1,5.85);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->setXY(2.6,5.85);
$pdf->Cell(2.5,1.2, "",1,1,"c" );


$pdf->setXY(5.1,5.85);
$pdf->Cell(6.0,1.2, "",1,1,"c" );

$pdf->setXY(11.1,5.85);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(12.6,5.85);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(14.1,5.85);
$pdf->Cell(2.0,1.2, "",1,1,"c" );


$pdf->setXY(16.1,5.85);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',9);
$pdf->setXY(16.1,5.85);
$pdf->MultiCell(1.5,1.2, iconv( 'UTF-8','cp874' , "เครื่องมือแพทย์"),0 ,'C' );


$pdf->setXY(17.6,5.85);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',7);
//1
$pdf->setXY(17.7,6.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,5.95);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการสินค้าทั่วไป"),0 ,'L' );

$pdf->setXY(17.7,6.35);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,6.25);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งกล่องโฟม"),0 ,'L' );

$pdf->setXY(17.7,6.65);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,6.6);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งผัก-ผลไม้"),0 ,'L' );






$pdf->setXY(19.6,5.85);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//2
$pdf->setXY(19.7,6.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,5.95);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ไม่ควบคุมอุณหภูมิ"),0 ,'L' );

$pdf->setXY(19.7,6.35);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,6.25);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Chilled 2-8 C"),0 ,'L' );

$pdf->setXY(19.7,6.65);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,6.6);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Frozen -15 C"),0 ,'L' );





$pdf->setXY(21.6,5.85);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//3
$pdf->setXY(21.7,6.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,5.95);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ด่วน 1 วัน"),0 ,'L' );

$pdf->setXY(21.7,6.35);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,6.25);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ธรรมดา 2-3 วัน"),0 ,'L' );

/*$pdf->setXY(21.7,6.65);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,6.6);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ภายในวัน"),0 ,'L' );*/



$pdf->setXY(23.6,5.85);
$pdf->Cell(1.2,1.2, "",1,1,"c" );

$pdf->setXY(24.8,5.85);
$pdf->Cell(1.2,1.2, "",1,1,"c" );



$pdf->setXY(26.0,5.85);
$pdf->Cell(1.2,1.2, "",1,1,"c" );


$pdf->setXY(27.2,5.85);
$pdf->Cell(2.1,1.2, "",1,1,"c" );



//แถว 4
$pdf->setXY(0.3,7.05);
$pdf->Cell(0.8,1.2, "",1,1,"c" );	

$pdf->setXY(1.1,7.05);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->setXY(2.6,7.05);
$pdf->Cell(2.5,1.2, "",1,1,"c" );


$pdf->setXY(5.1,7.05);
$pdf->Cell(6.0,1.2, "",1,1,"c" );

$pdf->setXY(11.1,7.05);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(12.6,7.05);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(14.1,7.05);
$pdf->Cell(2.0,1.2, "",1,1,"c" );


$pdf->setXY(16.1,7.05);
$pdf->Cell(1.5,1.2, "",1,1,"c" );
$pdf->SetFont('angsa','',9);
$pdf->setXY(16.1,7.05);
$pdf->MultiCell(1.5,1.2, iconv( 'UTF-8','cp874' , "เครื่องมือแพทย์"),0 ,'C' );



$pdf->setXY(17.6,7.05);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',7);
//1
$pdf->setXY(17.7,7.25);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,7.15);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการสินค้าทั่วไป"),0 ,'L' );

$pdf->setXY(17.7,7.55);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,7.45);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งกล่องโฟม"),0 ,'L' );

$pdf->setXY(17.7,7.85);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,7.8);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งผัก-ผลไม้"),0 ,'L' );






$pdf->setXY(19.6,7.05);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//2
$pdf->setXY(19.7,7.25);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,7.15);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ไม่ควบคุมอุณหภูมิ"),0 ,'L' );

$pdf->setXY(19.7,7.55);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,7.45);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Chilled 2-8 C"),0 ,'L' );

$pdf->setXY(19.7,7.85);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,7.8);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Frozen -15 C"),0 ,'L' );





$pdf->setXY(21.6,7.05);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//3
$pdf->setXY(21.7,7.25);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,7.15);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ด่วน 1 วัน"),0 ,'L' );

$pdf->setXY(21.7,7.55);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,7.45);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ธรรมดา 2-3 วัน"),0 ,'L' );

/*$pdf->setXY(21.7,7.85);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,7.8);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ภายในวัน"),0 ,'L' );*/



$pdf->setXY(23.6,7.05);
$pdf->Cell(1.2,1.2, "",1,1,"c" );

$pdf->setXY(24.8,7.05);
$pdf->Cell(1.2,1.2, "",1,1,"c" );



$pdf->setXY(26.0,7.05);
$pdf->Cell(1.2,1.2, "",1,1,"c" );


$pdf->setXY(27.2,7.05);
$pdf->Cell(2.1,1.2, "",1,1,"c" );



//แถว 5
$pdf->setXY(0.3,8.25);
$pdf->Cell(0.8,1.2, "",1,1,"c" );	

$pdf->setXY(1.1,8.25);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->setXY(2.6,8.25);
$pdf->Cell(2.5,1.2, "",1,1,"c" );


$pdf->setXY(5.1,8.25);
$pdf->Cell(6.0,1.2, "",1,1,"c" );

$pdf->setXY(11.1,8.25);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(12.6,8.25);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(14.1,8.25);
$pdf->Cell(2.0,1.2, "",1,1,"c" );


$pdf->setXY(16.1,8.25);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',9);
$pdf->setXY(16.1,8.25);
$pdf->MultiCell(1.5,1.2, iconv( 'UTF-8','cp874' , "เครื่องมือแพทย์"),0 ,'C' );


$pdf->setXY(17.6,8.25);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',7);
//1
$pdf->setXY(17.7,8.45);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,8.35);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการสินค้าทั่วไป"),0 ,'L' );

$pdf->setXY(17.7,8.75);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,8.65);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งกล่องโฟม"),0 ,'L' );

$pdf->setXY(17.7,9.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,9.0);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งผัก-ผลไม้"),0 ,'L' );






$pdf->setXY(19.6,8.25);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//2
$pdf->setXY(19.7,8.45);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,8.35);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ไม่ควบคุมอุณหภูมิ"),0 ,'L' );

$pdf->setXY(19.7,8.75);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,8.65);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Chilled 2-8 C"),0 ,'L' );

$pdf->setXY(19.7,9.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,9.0);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Frozen -15 C"),0 ,'L' );





$pdf->setXY(21.6,8.25);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//3
$pdf->setXY(21.7,8.45);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,8.35);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ด่วน 1 วัน"),0 ,'L' );

$pdf->setXY(21.7,8.75);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,8.65);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ธรรมดา 2-3 วัน"),0 ,'L' );

/*$pdf->setXY(21.7,9.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,9.0);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ภายในวัน"),0 ,'L' );*/



$pdf->setXY(23.6,8.25);
$pdf->Cell(1.2,1.2, "",1,1,"c" );

$pdf->setXY(24.8,8.25);
$pdf->Cell(1.2,1.2, "",1,1,"c" );



$pdf->setXY(26.0,8.25);
$pdf->Cell(1.2,1.2, "",1,1,"c" );


$pdf->setXY(27.2,8.25);
$pdf->Cell(2.1,1.2, "",1,1,"c" );


$pdf->setXY(27.2,8.25);
$pdf->Cell(2.1,1.2, "",1,1,"c" );
	
	
//แถว 6
$pdf->setXY(0.3,9.45);
$pdf->Cell(0.8,1.2, "",1,1,"c" );	

$pdf->setXY(1.1,9.45);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->setXY(2.6,9.45);
$pdf->Cell(2.5,1.2, "",1,1,"c" );


$pdf->setXY(5.1,9.45);
$pdf->Cell(6.0,1.2, "",1,1,"c" );

$pdf->setXY(11.1,9.45);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(12.6,9.45);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(14.1,9.45);
$pdf->Cell(2.0,1.2, "",1,1,"c" );


$pdf->setXY(16.1,9.45);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',9);
$pdf->setXY(16.1,9.45);
$pdf->MultiCell(1.5,1.2, iconv( 'UTF-8','cp874' , "เครื่องมือแพทย์"),0 ,'C' );


$pdf->setXY(17.6,9.45);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',7);
//1
$pdf->setXY(17.7,9.65);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,9.55);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการสินค้าทั่วไป"),0 ,'L' );

$pdf->setXY(17.7,9.95);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,9.85);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งกล่องโฟม"),0 ,'L' );

$pdf->setXY(17.7,10.25);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,10.15);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งผัก-ผลไม้"),0 ,'L' );






$pdf->setXY(19.6,9.45);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//2
$pdf->setXY(19.7,9.65);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,9.55);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ไม่ควบคุมอุณหภูมิ"),0 ,'L' );

$pdf->setXY(19.7,9.95);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,9.85);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Chilled 2-8 C"),0 ,'L' );

$pdf->setXY(19.7,10.25);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,10.15);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Frozen -15 C"),0 ,'L' );





$pdf->setXY(21.6,9.45);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//3
$pdf->setXY(21.7,9.65);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,9.55);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ด่วน 1 วัน"),0 ,'L' );

$pdf->setXY(21.7,9.95);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,9.85);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ธรรมดา 2-3 วัน"),0 ,'L' );

/*$pdf->setXY(21.7,10.25);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,10.15);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ภายในวัน"),0 ,'L' );*/



$pdf->setXY(23.6,9.45);
$pdf->Cell(1.2,1.2, "",1,1,"c" );

$pdf->setXY(24.8,9.45);
$pdf->Cell(1.2,1.2, "",1,1,"c" );



$pdf->setXY(26.0,9.45);
$pdf->Cell(1.2,1.2, "",1,1,"c" );


$pdf->setXY(27.2,9.45);
$pdf->Cell(2.1,1.2, "",1,1,"c" );


$pdf->setXY(27.2,9.45);
$pdf->Cell(2.1,1.2, "",1,1,"c" );
	
//แถว 7
$pdf->setXY(0.3,10.65);
$pdf->Cell(0.8,1.2, "",1,1,"c" );	

$pdf->setXY(1.1,10.65);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->setXY(2.6,10.65);
$pdf->Cell(2.5,1.2, "",1,1,"c" );


$pdf->setXY(5.1,10.65);
$pdf->Cell(6.0,1.2, "",1,1,"c" );

$pdf->setXY(11.1,10.65);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(12.6,10.65);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(14.1,10.65);
$pdf->Cell(2.0,1.2, "",1,1,"c" );


$pdf->setXY(16.1,10.65);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',9);
$pdf->setXY(16.1,10.65);
$pdf->MultiCell(1.5,1.2, iconv( 'UTF-8','cp874' , "เครื่องมือแพทย์"),0 ,'C' );


$pdf->setXY(17.6,10.65);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',7);
//1
$pdf->setXY(17.7,10.85);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,10.75);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการสินค้าทั่วไป"),0 ,'L' );

$pdf->setXY(17.7,11.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,10.95);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งกล่องโฟม"),0 ,'L' );

$pdf->setXY(17.7,11.35);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,11.25);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งผัก-ผลไม้"),0 ,'L' );






$pdf->setXY(19.6,10.65);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//2
$pdf->setXY(19.7,10.85);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,10.75);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ไม่ควบคุมอุณหภูมิ"),0 ,'L' );

$pdf->setXY(19.7,11.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,10.95);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Chilled 2-8 C"),0 ,'L' );

$pdf->setXY(19.7,11.35);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,11.25);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Frozen -15 C"),0 ,'L' );





$pdf->setXY(21.6,10.65);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//3
$pdf->setXY(21.7,10.85);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,10.75);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ด่วน 1 วัน"),0 ,'L' );

$pdf->setXY(21.7,11.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,10.95);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ธรรมดา 2-3 วัน"),0 ,'L' );

/*$pdf->setXY(21.7,11.35);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,11.25);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ภายในวัน"),0 ,'L' );*/



$pdf->setXY(23.6,10.65);
$pdf->Cell(1.2,1.2, "",1,1,"c" );

$pdf->setXY(24.8,10.65);
$pdf->Cell(1.2,1.2, "",1,1,"c" );



$pdf->setXY(26.0,10.65);
$pdf->Cell(1.2,1.2, "",1,1,"c" );


$pdf->setXY(27.2,10.65);
$pdf->Cell(2.1,1.2, "",1,1,"c" );


$pdf->setXY(27.2,10.65);
$pdf->Cell(2.1,1.2, "",1,1,"c" );
	
	
//แถว 8
$pdf->setXY(0.3,11.85);
$pdf->Cell(0.8,1.2, "",1,1,"c" );	

$pdf->setXY(1.1,11.85);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->setXY(2.6,11.85);
$pdf->Cell(2.5,1.2, "",1,1,"c" );


$pdf->setXY(5.1,11.85);
$pdf->Cell(6.0,1.2, "",1,1,"c" );

$pdf->setXY(11.1,11.85);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(12.6,11.85);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(14.1,11.85);
$pdf->Cell(2.0,1.2, "",1,1,"c" );


$pdf->setXY(16.1,11.85);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',9);
$pdf->setXY(16.1,11.85);
$pdf->MultiCell(1.5,1.2, iconv( 'UTF-8','cp874' , "เครื่องมือแพทย์"),0 ,'C' );


$pdf->setXY(17.6,11.85);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',7);
//1
$pdf->setXY(17.7,12.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,11.95);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการสินค้าทั่วไป"),0 ,'L' );

$pdf->setXY(17.7,12.35);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,12.25);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งกล่องโฟม"),0 ,'L' );

$pdf->setXY(17.7,12.65);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,12.55);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งผัก-ผลไม้"),0 ,'L' );






$pdf->setXY(19.6,11.85);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//2
$pdf->setXY(19.7,12.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,11.95);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ไม่ควบคุมอุณหภูมิ"),0 ,'L' );

$pdf->setXY(19.7,12.35);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,12.25);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Chilled 2-8 C"),0 ,'L' );

$pdf->setXY(19.7,12.65);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,12.55);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Frozen -15 C"),0 ,'L' );





$pdf->setXY(21.6,11.85);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//3
$pdf->setXY(21.7,12.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,11.95);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ด่วน 1 วัน"),0 ,'L' );

$pdf->setXY(21.7,12.35);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,12.25);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ธรรมดา 2-3 วัน"),0 ,'L' );

/*$pdf->setXY(21.7,12.65);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,12.55);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ภายในวัน"),0 ,'L' );*/



$pdf->setXY(23.6,11.85);
$pdf->Cell(1.2,1.2, "",1,1,"c" );

$pdf->setXY(24.8,11.85);
$pdf->Cell(1.2,1.2, "",1,1,"c" );



$pdf->setXY(26.0,11.85);
$pdf->Cell(1.2,1.2, "",1,1,"c" );


$pdf->setXY(27.2,11.85);
$pdf->Cell(2.1,1.2, "",1,1,"c" );


$pdf->setXY(27.2,11.85);
$pdf->Cell(2.1,1.2, "",1,1,"c" );
	
	
//แถว 8
$pdf->setXY(0.3,13.05);
$pdf->Cell(0.8,1.2, "",1,1,"c" );	

$pdf->setXY(1.1,13.05);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->setXY(2.6,13.05);
$pdf->Cell(2.5,1.2, "",1,1,"c" );


$pdf->setXY(5.1,13.05);
$pdf->Cell(6.0,1.2, "",1,1,"c" );

$pdf->setXY(11.1,13.05);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(12.6,13.05);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(14.1,13.05);
$pdf->Cell(2.0,1.2, "",1,1,"c" );


$pdf->setXY(16.1,13.05);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',9);
$pdf->setXY(16.1,13.05);
$pdf->MultiCell(1.5,1.2, iconv( 'UTF-8','cp874' , "เครื่องมือแพทย์"),0 ,'C' );


$pdf->setXY(17.6,13.05);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',7);
//1
$pdf->setXY(17.7,13.25);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,13.15);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการสินค้าทั่วไป"),0 ,'L' );

$pdf->setXY(17.7,13.55);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,13.45);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งกล่องโฟม"),0 ,'L' );

$pdf->setXY(17.7,13.85);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,13.75);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งผัก-ผลไม้"),0 ,'L' );






$pdf->setXY(19.6,13.05);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//2
$pdf->setXY(19.7,13.25);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,13.15);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ไม่ควบคุมอุณหภูมิ"),0 ,'L' );

$pdf->setXY(19.7,13.55);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,13.45);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Chilled 2-8 C"),0 ,'L' );

$pdf->setXY(19.7,13.85);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,13.75);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Frozen -15 C"),0 ,'L' );





$pdf->setXY(21.6,13.05);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//3
$pdf->setXY(21.7,13.25);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,13.15);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ด่วน 1 วัน"),0 ,'L' );

$pdf->setXY(21.7,13.55);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,13.45);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ธรรมดา 2-3 วัน"),0 ,'L' );

/*$pdf->setXY(21.7,13.85);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,13.75);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ภายในวัน"),0 ,'L' );*/



$pdf->setXY(23.6,13.05);
$pdf->Cell(1.2,1.2, "",1,1,"c" );

$pdf->setXY(24.8,13.05);
$pdf->Cell(1.2,1.2, "",1,1,"c" );



$pdf->setXY(26.0,13.05);
$pdf->Cell(1.2,1.2, "",1,1,"c" );


$pdf->setXY(27.2,13.05);
$pdf->Cell(2.1,1.2, "",1,1,"c" );


$pdf->setXY(27.2,13.05);
$pdf->Cell(2.1,1.2, "",1,1,"c" );
	
	
//แถว 8
$pdf->setXY(0.3,14.25);
$pdf->Cell(0.8,1.2, "",1,1,"c" );	

$pdf->setXY(1.1,14.25);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->setXY(2.6,14.25);
$pdf->Cell(2.5,1.2, "",1,1,"c" );


$pdf->setXY(5.1,14.25);
$pdf->Cell(6.0,1.2, "",1,1,"c" );

$pdf->setXY(11.1,14.25);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(12.6,14.25);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(14.1,14.25);
$pdf->Cell(2.0,1.2, "",1,1,"c" );


$pdf->setXY(16.1,14.25);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',9);
$pdf->setXY(16.1,14.25);
$pdf->MultiCell(1.5,1.2, iconv( 'UTF-8','cp874' , "เครื่องมือแพทย์"),0 ,'C' );


$pdf->setXY(17.6,14.25);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',7);
//1
$pdf->setXY(17.7,14.45);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,14.35);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการสินค้าทั่วไป"),0 ,'L' );

$pdf->setXY(17.7,14.75);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,14.65);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งกล่องโฟม"),0 ,'L' );

$pdf->setXY(17.7,15.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,14.95);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งผัก-ผลไม้"),0 ,'L' );






$pdf->setXY(19.6,14.25);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//2
$pdf->setXY(19.7,14.45);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,14.35);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ไม่ควบคุมอุณหภูมิ"),0 ,'L' );

$pdf->setXY(19.7,14.75);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,14.65);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Chilled 2-8 C"),0 ,'L' );

$pdf->setXY(19.7,15.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,14.95);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Frozen -15 C"),0 ,'L' );





$pdf->setXY(21.6,14.25);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//3
$pdf->setXY(21.7,14.45);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,14.35);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ด่วน 1 วัน"),0 ,'L' );

$pdf->setXY(21.7,14.75);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,14.65);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ธรรมดา 2-3 วัน"),0 ,'L' );

/*$pdf->setXY(21.7,15.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,14.95);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ภายในวัน"),0 ,'L' );*/



$pdf->setXY(23.6,14.25);
$pdf->Cell(1.2,1.2, "",1,1,"c" );

$pdf->setXY(24.8,14.25);
$pdf->Cell(1.2,1.2, "",1,1,"c" );



$pdf->setXY(26.0,14.25);
$pdf->Cell(1.2,1.2, "",1,1,"c" );


$pdf->setXY(27.2,14.25);
$pdf->Cell(2.1,1.2, "",1,1,"c" );


$pdf->setXY(27.2,14.25);
$pdf->Cell(2.1,1.2, "",1,1,"c" );
	

	
	
	
$pdf->SetFillColor(204,204,204);

$pdf->Cell(23.25,0.4,iconv('UTF-8','cp874','รวม'),1,0,"R",true);
$pdf->Cell(1.2,0.4,iconv('UTF-8','cp874',''),1,0,"R",true);
$pdf->Cell(1.2,0.4,iconv('UTF-8','cp874',''),1,0,"R",true);
$pdf->Cell(1.2,0.4,iconv('UTF-8','cp874',''),1,0,"R",true);
$pdf->Cell(2.1,0.4,iconv('UTF-8','cp874',''),1,0,"R",true);
		
//$pdf->setXY(0.3,11.85);
//$pdf->Cell(29,1.6, "",1,1,"c" );

$pdf->setXY(1.0,15.8);
$pdf->MultiCell(29,0.4, iconv( 'UTF-8','cp874' , "หมายเหตุ"),0 ,'L' );


$pdf->setXY(1.0,16.2);
$pdf->MultiCell(14,0.4, iconv( 'UTF-8','cp874' , "1. ประเภทสินค้าหากเป็นยาเย็นระบุ (ยาเย็น) / ยาธรรมดาระบุ (ยา)"),0 ,'L' );

$pdf->setXY(1.0,16.6);
$pdf->MultiCell(14,0.4, iconv( 'UTF-8','cp874' , "2.  ช่องประเภทสินค้า ระบุสินค้าที่บรรจุในกล่อง(เนื้อแช่แข็ง, ปลาแช่แข็ง, เนยแช่แข็ง, ผลไม้หรือสินค้าประเภทอื่น ๆ ฯลฯ)"),0 ,'L' );

$pdf->setXY(1.0,17.0);
$pdf->MultiCell(14,0.4, iconv( 'UTF-8','cp874' , "3. สินค้าประเภทผัก-ผลไม้ หากใช้บริการขนส่งผัก-ผลไม้ จะต้องเป็นลูกหรือเป็นผลเปลือกแข็งเท่านั้น"),0 ,'L' );


$pdf->setXY(15.0,16.2);
$pdf->MultiCell(14,0.4, iconv( 'UTF-8','cp874' , "4.  ช่องระบุขนาดกล่อง ระบุขนาดกล่องดังนี้ S1, S2,  A1, A2, B1, B2 / บริการขนส่งผัก-ผลไม้ ไม่ต้องระบุขนาดกล่อง แต่ต้องระบุน้ำหนัก (กิโลกรัม) ต่อกล่อง"),0 ,'L' );

$pdf->setXY(15.0,16.6);
$pdf->MultiCell(14,0.4, iconv( 'UTF-8','cp874' , "5. กรณีที่ผู้รับปลายทางไม่มีเบอร์โทรติดต่อให้ใช้เบอร์โทรติดต่อของผู้ส่งสินค้าแทน"),0 ,'L' );

$pdf->setXY(15.0,17.0);
$pdf->MultiCell(14,0.4, iconv( 'UTF-8','cp874' , "6. หากไม่ทราบวิธีคิดขนาดกล่อง ระบุน้ำหนักต่อกล่องในช่องน้ำหนักและปริมาตร กว้าง X ยาว X สูง (เซนติเมตร) ในช่องหมายเหตุ"),0 ,'L' );
	
$pdf->Cell(28.9,0.4,iconv('UTF-8','cp874',''),0,0,"C",true);
	
	
$pdf->SetFont('angsa','',8);	
$pdf->setXY(11,18.0);
$pdf->Cell(8,2.2, "",1,1,"c" );	
	
$pdf->setXY(11,18.1);
$pdf->MultiCell(8,0.3, iconv( 'UTF-8','cp874' , "ใบรายงานการส่งสินค้าหน้านี้เป็นใบรายงานการส่งสินค้าหน้าถัดมาที่ผู้ส่งสินค้า"),0 ,'C' );
	
$pdf->setXY(11,18.4);
$pdf->MultiCell(8,0.3, iconv( 'UTF-8','cp874' , "จะแนบไปกับใบรายงานการส่งสินค้าหน้าแรกด้วยทุกครั้ง(ถ้ามีการส่งหลายปลายทาง)และครอบคลุม"),0 ,'C' );
	
$pdf->setXY(11,18.7);
$pdf->MultiCell(8,0.3, iconv( 'UTF-8','cp874' , "คำรับรองของผู้ส่งสินค้าเช่นเดียวกันกับหน้าแรกทุกประการ"),0 ,'C' );

$pdf->setXY(11,19.0);
$pdf->MultiCell(8,0.3, iconv( 'UTF-8','cp874' , "(ลงชื่อผู้ส่งสินค้าทุกใบรายงานการส่งสินค้าหน้าถัดมา)"),0 ,'C' );
	
	
$pdf->setXY(11,19.8);
$pdf->MultiCell(8,0.3, iconv( 'UTF-8','cp874' , "ลงชื่อ  .................................................................  ผู้ส่งสินค้า วันที่ ............... / ................ / ..............."),0 ,'C' );
	
	
$pdf->Image("img/qrcode_inter.png",27.7,18.5,1.5,1.5);

$pdf->SetFont('angsa','',7);
$pdf->setXY(26.5,20.2);
$pdf->MultiCell(29,0, iconv( 'UTF-8','cp874' , "FM-RC-01, แก้ไขครั้งที่ 10.01-02-2026"),0 ,'L' );
	
	
}	


//หน้าที่ 4

$strSQL = "SELECT ref_id,customer_name,address_name,customer_tel FROM tb_register_data  WHERE start_date >= '".$start_date."' and start_date <= '".$end_date."' and type_company='".$company."' and bus_inter='1' LIMIT 10 OFFSET 25";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$Num_Rows = mysqli_num_rows($objQuery);

if($Num_Rows > 0){
//$pdf->AddPage();

$pdf->SetFont('angsa','',14);

$pdf->setXY(0.3,0.3);
$pdf->Cell(29.0,20.3, "",1,1,"c" );

$pdf->Image("img/inter_express.png",0.3,0.35,2.5,1.0);

$pdf->setXY(0.3,0.35);
$pdf->Cell(25.0,2.2, "",1,1,"c" );

//$pdf->SetFont('angsana','B',20);

$pdf->setXY(0.3,0.4);
$pdf->MultiCell(25, 0.6 , iconv( 'UTF-8','cp874' , "ใบรายงานการส่งสินค้า Delivery Manifest"),0 ,'C' );

$pdf->setXY(0.3,0.9);
$pdf->MultiCell(25, 0.6 , iconv( 'UTF-8','cp874' , "สำหรับบริการสินค้าทั่วไป (Ambient) บริการขนส่งกล่องโฟม (INTER FOAM) บริการขนส่งผัก-ผลไม้ (FRUIT DELIVERY) "),0 ,'C' );

$pdf->SetFont('angsa','',11);

$pdf->setXY(0.3,1.5);
$pdf->MultiCell(25, 0.6 , iconv( 'UTF-8','cp874' , "หน้าแรก แผ่นที่ 1 /……"),0 ,'L' );

$pdf->setXY(0.3,2.0);
$pdf->MultiCell(25, 0.6 , iconv( 'UTF-8','cp874' , "วันที่ …$start_date_th....."),0 ,'L' );


$pdf->SetFont('angsa','',12);

if($_GET["company"]=='3'){
$pdf->setXY(0.3,1.5);
$pdf->MultiCell(25, 0.5 , iconv( 'UTF-8','cp874' , "ผู้ส่งสินค้า/บริษัท…....................บริษัท ออลล์เวล ไลฟ์ จำกัด.........................….รหัสลูกค้า……...................…...................…....................….........."),0 ,'C' );

$pdf->setXY(0.3,2.0);
$pdf->MultiCell(25, 0.5 , iconv( 'UTF-8','cp874' , "ที่อยู่ผู้ส่ง...................73,75 ซ.จรัญสนิทวงศ์89/2 แขวงบางอ้อ เขตบางพลัด กรุงเทพมหานคร 10700....................เบอร์ผู้ส่งสินค้า ........02-424-3555....................."),0 ,'C' );

}
if($_GET["company"]=='4'){
	
$pdf->setXY(0.3,1.5);
$pdf->MultiCell(25, 0.5 , iconv( 'UTF-8','cp874' , "ผู้ส่งสินค้า/บริษัท…....................บริษัท โนเบิล เมด จำกัด........................….รหัสลูกค้า……...................…...................…....................….........."),0 ,'C' );

$pdf->setXY(0.3,2.0);
$pdf->MultiCell(25, 0.5 , iconv( 'UTF-8','cp874' , "ที่อยู่ผู้ส่ง....................73 ซ.จรัญสนิทวงศ์89/2 แขวงบางอ้อ เขตบางพลัด กรุงเทพมหานคร 10700........................เบอร์ผู้ส่งสินค้า ........02-880-5566.........................."),0 ,'C' );
	
}
	
$pdf->setXY(25.3,0.35);
$pdf->Cell(4.0,2.2, "",1,1,"c" );	

$pdf->SetFont('angsa','',14);
	
$pdf->setXY(25.3,0.8);
$pdf->MultiCell(4.0, 0.5 , iconv( 'UTF-8','cp874' , "สำหรับติดสติ๊กเกอร์"),0 ,'C' );

$pdf->setXY(25.3,1.5);
$pdf->MultiCell(4.0, 0.5 , iconv( 'UTF-8','cp874' , "M/F Number"),0 ,'C' );

$pdf->SetFont('angsa','',10);

$pdf->setXY(0.3,2.55);
$pdf->Cell(0.8,0.9, "",1,1,"c" );	

$pdf->setXY(0.3,2.55);
$pdf->MultiCell(0.8,0.9, iconv( 'UTF-8','cp874' , "ลำดับ"),0 ,'C' );

$pdf->setXY(1.1,2.55);
$pdf->Cell(1.5,0.9, "",1,1,"c" );

$pdf->setXY(1.1,2.55);
$pdf->MultiCell(1.5,0.9, iconv( 'UTF-8','cp874' , "เลขที่บิล"),0 ,'C' );

$pdf->setXY(2.6,2.55);
$pdf->Cell(2.5,0.9, "",1,1,"c" );

$pdf->setXY(2.6,2.55);
$pdf->MultiCell(2.5,0.9, iconv( 'UTF-8','cp874' , "ชื่อผู้รับสินค้า"),0 ,'C' );


$pdf->setXY(5.1,2.55);
$pdf->Cell(6.0,0.9, "",1,1,"c" );

$pdf->setXY(5.1,2.6);
$pdf->MultiCell(6.0,0.45, iconv( 'UTF-8','cp874' , "ที่อยู่ผู้รับสินค้า"),0 ,'C' );
$pdf->setXY(5.1,3.05);
$pdf->MultiCell(6.0,0.4, iconv( 'UTF-8','cp874' , "(ระบุบ้านเลขที่ หมู่ที่ หมู่บ้าน ถนน ตำบล/แขวง)"),0 ,'C' );


$pdf->setXY(11.1,2.55);
$pdf->Cell(1.5,0.9, "",1,1,"c" );

$pdf->setXY(11.1,2.55);
$pdf->MultiCell(1.5,0.9, iconv( 'UTF-8','cp874' , "อำเภอ/เขต"),0 ,'C' );

$pdf->setXY(12.6,2.55);
$pdf->Cell(1.5,0.9, "",1,1,"c" );

$pdf->setXY(12.6,2.55);
$pdf->MultiCell(1.5,0.9, iconv( 'UTF-8','cp874' , "จังหวัด"),0 ,'C' );


$pdf->setXY(14.1,2.55);
$pdf->Cell(2.0,0.9, "",1,1,"c" );

$pdf->setXY(14.1,2.55);
$pdf->MultiCell(2.0,0.9, iconv( 'UTF-8','cp874' , "เบอร์ผู้รับสินค้า"),0 ,'C' );

$pdf->setXY(16.1,2.55);
$pdf->Cell(1.5,0.9, "",1,1,"c" );

$pdf->setXY(16.1,2.55);
$pdf->MultiCell(1.5,0.9, iconv( 'UTF-8','cp874' , "ประเภทสินค้า"),0 ,'C' );


$pdf->setXY(17.6,2.55);
$pdf->Cell(2.0,0.9, "",1,1,"c" );

$pdf->setXY(17.6,2.55);
$pdf->MultiCell(2.0,0.9, iconv( 'UTF-8','cp874' , "ประเภทบริการ"),0 ,'C' );

$pdf->setXY(19.6,2.55);
$pdf->Cell(2.0,0.9, "",1,1,"c" );

$pdf->setXY(19.6,2.55);
$pdf->MultiCell(2.0,0.9, iconv( 'UTF-8','cp874' , "ประเภทอุณหภูมิ"),0 ,'C' );

$pdf->setXY(21.6,2.55);
$pdf->Cell(2.0,0.9, "",1,1,"c" );

$pdf->setXY(21.6,2.55);
$pdf->MultiCell(2.0,0.9, iconv( 'UTF-8','cp874' , "บริการจัดส่ง (SLA)"),0 ,'C' );

$pdf->setXY(23.6,2.55);
$pdf->Cell(1.2,0.9, "",1,1,"c" );

$pdf->setXY(23.6,2.55);
$pdf->MultiCell(1.2,0.45, iconv( 'UTF-8','cp874' , "ระบุขนาด"),0 ,'C' );

$pdf->setXY(23.6,2.95);
$pdf->MultiCell(1.2,0.4, iconv( 'UTF-8','cp874' , "กล่อง"),0 ,'C' );


$pdf->setXY(24.8,2.55);
$pdf->Cell(1.2,0.9, "",1,1,"c" );

$pdf->setXY(24.8,2.55);
$pdf->MultiCell(1.2,0.45, iconv( 'UTF-8','cp874' , "น้ำหนัก/"),0 ,'C' );

$pdf->setXY(24.8,2.95);
$pdf->MultiCell(1.2,0.4, iconv( 'UTF-8','cp874' , "กล่อง"),0 ,'C' );

$pdf->setXY(26.0,2.55);
$pdf->Cell(1.2,0.9, "",1,1,"c" );

$pdf->setXY(26.0,2.55);
$pdf->MultiCell(1.2,0.45, iconv( 'UTF-8','cp874' , "จำนวน"),0 ,'C' );

$pdf->setXY(26.0,2.95);
$pdf->MultiCell(1.2,0.4, iconv( 'UTF-8','cp874' , "กล่อง"),0 ,'C' );


$pdf->setXY(27.2,2.55);
$pdf->Cell(2.1,0.9, "",1,1,"c" );

$pdf->setXY(27.2,2.55);
$pdf->MultiCell(2.1,0.9, iconv( 'UTF-8','cp874' , "หมายเหตุ"),0 ,'C' );
	
	
$j=26;
while($objResult = mysqli_fetch_array($objQuery))
{	
	
$ref_id = substr($objResult["ref_id"],0,2);	
$customer_name = $objResult["customer_name"];
$address_name = $objResult["address_name"];	
$customer_tel = $objResult["customer_tel"];	
	
if($ref_id=='SO'){	
$strSQL15 = "SELECT iv_no FROM hos__so WHERE ref_id = '".$objResult["ref_id"]."' ";
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResult15= mysqli_fetch_array($objQuery15);
	
$iv_no =$objResult15["iv_no"];	
	
}else if($ref_id=='BR'){
	
$strSQL15 = "SELECT iv_no FROM hos__br WHERE ref_id_br = '".$objResult["ref_id"]."' ";
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResult15= mysqli_fetch_array($objQuery15);
	
$iv_no =$objResult15["iv_no"];	

}else if($ref_id=='CH'){
	
$strSQL15 = "SELECT iv_no FROM hos__change WHERE ref_id = '".$objResult["ref_id"]."' ";
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResult15= mysqli_fetch_array($objQuery15);
	
$iv_no =$objResult15["iv_no"];	
$customer_name = $objResult["customer_name"];
$address_name = $objResult["address_name"];	
$customer_tel = $objResult["customer_tel"];	

}else if($ref_id=='BS'){
	
$strSQL15 = "SELECT iv_no FROM hos__consig WHERE ref_id = '".$objResult["ref_id"]."' ";
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResult15= mysqli_fetch_array($objQuery15);
	
$iv_no =$objResult15["iv_no"];	
$customer_name = $objResult["customer_name"];
$address_name = $objResult["address_name"];	
$customer_tel = $objResult["customer_tel"];	
	
	
}else{
	
$strSQL15 = "SELECT doc_no,customer_name,address1,address2,province,postcode,tel FROM so__main WHERE ref_id = '".$objResult["ref_id"]."' ";
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResult15= mysqli_fetch_array($objQuery15);
	
$iv_no =$objResult15["doc_no"];	
$customer_name = $objResult15["customer_name"];
$address1 = $objResult15["address1"];	
$address2 = $objResult15["address2"];	
$province = $objResult15["province"];	
$postcode = $objResult15["postcode"];		
$address_name = "$address1 $address2 $province $postcode";	
$customer_tel = $objResult15["tel"];	
	
		
}
	
$pdf->setX(0.3);
$pdf->Cell(0.8,1.2, iconv('UTF-8','cp874', "$j"),1,0,'C');
$pdf->Cell(1.5,1.2, iconv('UTF-8','cp874', "$iv_no"),1,0,'C');
$pdf->Cell(2.5,1.2, iconv('UTF-8','cp874', "$customer_name"),1,0,'L');
$pdf->Cell(6.0,1.2, '',1,0,'L');
$addressY = $pdf->GetY();
$addressX = $pdf->GetX();
$pdf->SetXY($addressX - 6.0, $addressY);
$pdf->MultiCell(6.0,0.4, iconv('UTF-8//IGNORE','cp874//IGNORE', "$address_name"),0,'L');
$pdf->SetXY($addressX, $addressY);
$pdf->Cell(1.5,1.2, iconv('UTF-8','cp874', ""),1,0,'C');
$pdf->Cell(1.5,1.2, iconv('UTF-8','cp874', ""),1,0,'C');	
$pdf->Cell(2.0,1.2, iconv('UTF-8','cp874', "$customer_tel"),1,1,'L');
	

$j++;


}
	
//แถว 1
$pdf->setXY(0.3,3.45);
$pdf->Cell(0.8,1.2, "",1,1,"c" );	

$pdf->setXY(1.1,3.45);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->setXY(2.6,3.45);
$pdf->Cell(2.5,1.2, "",1,1,"c" );


$pdf->setXY(5.1,3.45);
$pdf->Cell(6.0,1.2, "",1,1,"c" );

$pdf->setXY(11.1,3.45);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(12.6,3.45);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(14.1,3.45);
$pdf->Cell(2.0,1.2, "",1,1,"c" );


$pdf->setXY(16.1,3.45);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',9);
$pdf->setXY(16.1,3.45);
$pdf->MultiCell(1.5,1.2, iconv( 'UTF-8','cp874' , "เครื่องมือแพทย์"),0 ,'C' );


$pdf->setXY(17.6,3.45);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',7);
//1
$pdf->setXY(17.7,3.65);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,3.55);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการสินค้าทั่วไป"),0 ,'L' );

$pdf->setXY(17.7,3.95);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,3.85);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งกล่องโฟม"),0 ,'L' );

$pdf->setXY(17.7,4.25);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,4.2);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งผัก-ผลไม้"),0 ,'L' );






$pdf->setXY(19.6,3.45);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//2
$pdf->setXY(19.7,3.65);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,3.55);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ไม่ควบคุมอุณหภูมิ"),0 ,'L' );

$pdf->setXY(19.7,3.95);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,3.85);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Chilled 2-8 C"),0 ,'L' );

$pdf->setXY(19.7,4.25);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,4.2);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Frozen -15 C"),0 ,'L' );





$pdf->setXY(21.6,3.45);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//3
$pdf->setXY(21.7,3.65);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,3.55);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ด่วน 1 วัน"),0 ,'L' );

$pdf->setXY(21.7,3.95);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,3.85);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ธรรมดา 2-3 วัน"),0 ,'L' );

/*$pdf->setXY(21.7,4.25);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,4.2);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ภายในวัน"),0 ,'L' );*/



$pdf->setXY(23.6,3.45);
$pdf->Cell(1.2,1.2, "",1,1,"c" );

$pdf->setXY(24.8,3.45);
$pdf->Cell(1.2,1.2, "",1,1,"c" );



$pdf->setXY(26.0,3.45);
$pdf->Cell(1.2,1.2, "",1,1,"c" );


$pdf->setXY(27.2,3.45);
$pdf->Cell(2.1,1.2, "",1,1,"c" );





//แถว 2
$pdf->setXY(0.3,4.65);
$pdf->Cell(0.8,1.2, "",1,1,"c" );	

$pdf->setXY(1.1,4.65);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->setXY(2.6,4.65);
$pdf->Cell(2.5,1.2, "",1,1,"c" );


$pdf->setXY(5.1,4.65);
$pdf->Cell(6.0,1.2, "",1,1,"c" );

$pdf->setXY(11.1,4.65);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(12.6,4.65);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(14.1,4.65);
$pdf->Cell(2.0,1.2, "",1,1,"c" );


$pdf->setXY(16.1,4.65);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',9);
$pdf->setXY(16.1,4.65);
$pdf->MultiCell(1.5,1.2, iconv( 'UTF-8','cp874' , "เครื่องมือแพทย์"),0 ,'C' );


$pdf->setXY(17.6,4.65);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',7);
//1
$pdf->setXY(17.7,4.85);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,4.75);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการสินค้าทั่วไป"),0 ,'L' );

$pdf->setXY(17.7,5.15);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,5.05);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งกล่องโฟม"),0 ,'L' );

$pdf->setXY(17.7,5.45);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,5.4);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งผัก-ผลไม้"),0 ,'L' );






$pdf->setXY(19.6,4.65);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//2
$pdf->setXY(19.7,4.85);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,4.75);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ไม่ควบคุมอุณหภูมิ"),0 ,'L' );

$pdf->setXY(19.7,5.15);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,5.05);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Chilled 2-8 C"),0 ,'L' );

$pdf->setXY(19.7,5.45);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,5.4);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Frozen -15 C"),0 ,'L' );





$pdf->setXY(21.6,4.65);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//3
$pdf->setXY(21.7,4.85);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,4.75);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ด่วน 1 วัน"),0 ,'L' );

$pdf->setXY(21.7,5.15);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,5.05);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ธรรมดา 2-3 วัน"),0 ,'L' );

/*$pdf->setXY(21.7,5.45);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,5.4);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ภายในวัน"),0 ,'L' );*/



$pdf->setXY(23.6,4.65);
$pdf->Cell(1.2,1.2, "",1,1,"c" );

$pdf->setXY(24.8,4.65);
$pdf->Cell(1.2,1.2, "",1,1,"c" );



$pdf->setXY(26.0,4.65);
$pdf->Cell(1.2,1.2, "",1,1,"c" );


$pdf->setXY(27.2,4.65);
$pdf->Cell(2.1,1.2, "",1,1,"c" );





//แถว 3
$pdf->setXY(0.3,5.85);
$pdf->Cell(0.8,1.2, "",1,1,"c" );	

$pdf->setXY(1.1,5.85);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->setXY(2.6,5.85);
$pdf->Cell(2.5,1.2, "",1,1,"c" );


$pdf->setXY(5.1,5.85);
$pdf->Cell(6.0,1.2, "",1,1,"c" );

$pdf->setXY(11.1,5.85);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(12.6,5.85);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(14.1,5.85);
$pdf->Cell(2.0,1.2, "",1,1,"c" );


$pdf->setXY(16.1,5.85);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',9);
$pdf->setXY(16.1,5.85);
$pdf->MultiCell(1.5,1.2, iconv( 'UTF-8','cp874' , "เครื่องมือแพทย์"),0 ,'C' );


$pdf->setXY(17.6,5.85);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',7);
//1
$pdf->setXY(17.7,6.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,5.95);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการสินค้าทั่วไป"),0 ,'L' );

$pdf->setXY(17.7,6.35);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,6.25);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งกล่องโฟม"),0 ,'L' );

$pdf->setXY(17.7,6.65);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,6.6);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งผัก-ผลไม้"),0 ,'L' );






$pdf->setXY(19.6,5.85);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//2
$pdf->setXY(19.7,6.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,5.95);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ไม่ควบคุมอุณหภูมิ"),0 ,'L' );

$pdf->setXY(19.7,6.35);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,6.25);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Chilled 2-8 C"),0 ,'L' );

$pdf->setXY(19.7,6.65);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,6.6);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Frozen -15 C"),0 ,'L' );





$pdf->setXY(21.6,5.85);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//3
$pdf->setXY(21.7,6.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,5.95);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ด่วน 1 วัน"),0 ,'L' );

$pdf->setXY(21.7,6.35);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,6.25);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ธรรมดา 2-3 วัน"),0 ,'L' );

/*$pdf->setXY(21.7,6.65);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,6.6);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ภายในวัน"),0 ,'L' );*/



$pdf->setXY(23.6,5.85);
$pdf->Cell(1.2,1.2, "",1,1,"c" );

$pdf->setXY(24.8,5.85);
$pdf->Cell(1.2,1.2, "",1,1,"c" );



$pdf->setXY(26.0,5.85);
$pdf->Cell(1.2,1.2, "",1,1,"c" );


$pdf->setXY(27.2,5.85);
$pdf->Cell(2.1,1.2, "",1,1,"c" );



//แถว 4
$pdf->setXY(0.3,7.05);
$pdf->Cell(0.8,1.2, "",1,1,"c" );	

$pdf->setXY(1.1,7.05);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->setXY(2.6,7.05);
$pdf->Cell(2.5,1.2, "",1,1,"c" );


$pdf->setXY(5.1,7.05);
$pdf->Cell(6.0,1.2, "",1,1,"c" );

$pdf->setXY(11.1,7.05);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(12.6,7.05);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(14.1,7.05);
$pdf->Cell(2.0,1.2, "",1,1,"c" );


$pdf->setXY(16.1,7.05);
$pdf->Cell(1.5,1.2, "",1,1,"c" );
$pdf->SetFont('angsa','',9);
$pdf->setXY(16.1,7.05);
$pdf->MultiCell(1.5,1.2, iconv( 'UTF-8','cp874' , "เครื่องมือแพทย์"),0 ,'C' );



$pdf->setXY(17.6,7.05);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',7);
//1
$pdf->setXY(17.7,7.25);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,7.15);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการสินค้าทั่วไป"),0 ,'L' );

$pdf->setXY(17.7,7.55);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,7.45);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งกล่องโฟม"),0 ,'L' );

$pdf->setXY(17.7,7.85);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,7.8);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งผัก-ผลไม้"),0 ,'L' );






$pdf->setXY(19.6,7.05);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//2
$pdf->setXY(19.7,7.25);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,7.15);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ไม่ควบคุมอุณหภูมิ"),0 ,'L' );

$pdf->setXY(19.7,7.55);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,7.45);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Chilled 2-8 C"),0 ,'L' );

$pdf->setXY(19.7,7.85);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,7.8);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Frozen -15 C"),0 ,'L' );





$pdf->setXY(21.6,7.05);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//3
$pdf->setXY(21.7,7.25);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,7.15);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ด่วน 1 วัน"),0 ,'L' );

$pdf->setXY(21.7,7.55);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,7.45);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ธรรมดา 2-3 วัน"),0 ,'L' );

/*$pdf->setXY(21.7,7.85);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,7.8);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ภายในวัน"),0 ,'L' );*/



$pdf->setXY(23.6,7.05);
$pdf->Cell(1.2,1.2, "",1,1,"c" );

$pdf->setXY(24.8,7.05);
$pdf->Cell(1.2,1.2, "",1,1,"c" );



$pdf->setXY(26.0,7.05);
$pdf->Cell(1.2,1.2, "",1,1,"c" );


$pdf->setXY(27.2,7.05);
$pdf->Cell(2.1,1.2, "",1,1,"c" );



//แถว 5
$pdf->setXY(0.3,8.25);
$pdf->Cell(0.8,1.2, "",1,1,"c" );	

$pdf->setXY(1.1,8.25);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->setXY(2.6,8.25);
$pdf->Cell(2.5,1.2, "",1,1,"c" );


$pdf->setXY(5.1,8.25);
$pdf->Cell(6.0,1.2, "",1,1,"c" );

$pdf->setXY(11.1,8.25);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(12.6,8.25);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(14.1,8.25);
$pdf->Cell(2.0,1.2, "",1,1,"c" );


$pdf->setXY(16.1,8.25);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',9);
$pdf->setXY(16.1,8.25);
$pdf->MultiCell(1.5,1.2, iconv( 'UTF-8','cp874' , "เครื่องมือแพทย์"),0 ,'C' );


$pdf->setXY(17.6,8.25);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',7);
//1
$pdf->setXY(17.7,8.45);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,8.35);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการสินค้าทั่วไป"),0 ,'L' );

$pdf->setXY(17.7,8.75);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,8.65);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งกล่องโฟม"),0 ,'L' );

$pdf->setXY(17.7,9.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,9.0);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งผัก-ผลไม้"),0 ,'L' );






$pdf->setXY(19.6,8.25);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//2
$pdf->setXY(19.7,8.45);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,8.35);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ไม่ควบคุมอุณหภูมิ"),0 ,'L' );

$pdf->setXY(19.7,8.75);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,8.65);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Chilled 2-8 C"),0 ,'L' );

$pdf->setXY(19.7,9.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,9.0);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Frozen -15 C"),0 ,'L' );





$pdf->setXY(21.6,8.25);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//3
$pdf->setXY(21.7,8.45);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,8.35);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ด่วน 1 วัน"),0 ,'L' );

$pdf->setXY(21.7,8.75);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,8.65);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ธรรมดา 2-3 วัน"),0 ,'L' );

/*$pdf->setXY(21.7,9.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,9.0);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ภายในวัน"),0 ,'L' );*/



$pdf->setXY(23.6,8.25);
$pdf->Cell(1.2,1.2, "",1,1,"c" );

$pdf->setXY(24.8,8.25);
$pdf->Cell(1.2,1.2, "",1,1,"c" );



$pdf->setXY(26.0,8.25);
$pdf->Cell(1.2,1.2, "",1,1,"c" );


$pdf->setXY(27.2,8.25);
$pdf->Cell(2.1,1.2, "",1,1,"c" );


$pdf->setXY(27.2,8.25);
$pdf->Cell(2.1,1.2, "",1,1,"c" );
	
	
//แถว 6
$pdf->setXY(0.3,9.45);
$pdf->Cell(0.8,1.2, "",1,1,"c" );	

$pdf->setXY(1.1,9.45);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->setXY(2.6,9.45);
$pdf->Cell(2.5,1.2, "",1,1,"c" );


$pdf->setXY(5.1,9.45);
$pdf->Cell(6.0,1.2, "",1,1,"c" );

$pdf->setXY(11.1,9.45);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(12.6,9.45);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(14.1,9.45);
$pdf->Cell(2.0,1.2, "",1,1,"c" );


$pdf->setXY(16.1,9.45);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',9);
$pdf->setXY(16.1,9.45);
$pdf->MultiCell(1.5,1.2, iconv( 'UTF-8','cp874' , "เครื่องมือแพทย์"),0 ,'C' );


$pdf->setXY(17.6,9.45);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',7);
//1
$pdf->setXY(17.7,9.65);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,9.55);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการสินค้าทั่วไป"),0 ,'L' );

$pdf->setXY(17.7,9.95);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,9.85);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งกล่องโฟม"),0 ,'L' );

$pdf->setXY(17.7,10.25);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,10.15);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งผัก-ผลไม้"),0 ,'L' );






$pdf->setXY(19.6,9.45);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//2
$pdf->setXY(19.7,9.65);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,9.55);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ไม่ควบคุมอุณหภูมิ"),0 ,'L' );

$pdf->setXY(19.7,9.95);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,9.85);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Chilled 2-8 C"),0 ,'L' );

$pdf->setXY(19.7,10.25);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,10.15);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Frozen -15 C"),0 ,'L' );





$pdf->setXY(21.6,9.45);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//3
$pdf->setXY(21.7,9.65);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,9.55);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ด่วน 1 วัน"),0 ,'L' );

$pdf->setXY(21.7,9.95);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,9.85);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ธรรมดา 2-3 วัน"),0 ,'L' );

/*$pdf->setXY(21.7,10.25);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,10.15);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ภายในวัน"),0 ,'L' );*/



$pdf->setXY(23.6,9.45);
$pdf->Cell(1.2,1.2, "",1,1,"c" );

$pdf->setXY(24.8,9.45);
$pdf->Cell(1.2,1.2, "",1,1,"c" );



$pdf->setXY(26.0,9.45);
$pdf->Cell(1.2,1.2, "",1,1,"c" );


$pdf->setXY(27.2,9.45);
$pdf->Cell(2.1,1.2, "",1,1,"c" );


$pdf->setXY(27.2,9.45);
$pdf->Cell(2.1,1.2, "",1,1,"c" );
	
//แถว 7
$pdf->setXY(0.3,10.65);
$pdf->Cell(0.8,1.2, "",1,1,"c" );	

$pdf->setXY(1.1,10.65);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->setXY(2.6,10.65);
$pdf->Cell(2.5,1.2, "",1,1,"c" );


$pdf->setXY(5.1,10.65);
$pdf->Cell(6.0,1.2, "",1,1,"c" );

$pdf->setXY(11.1,10.65);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(12.6,10.65);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(14.1,10.65);
$pdf->Cell(2.0,1.2, "",1,1,"c" );


$pdf->setXY(16.1,10.65);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',9);
$pdf->setXY(16.1,10.65);
$pdf->MultiCell(1.5,1.2, iconv( 'UTF-8','cp874' , "เครื่องมือแพทย์"),0 ,'C' );


$pdf->setXY(17.6,10.65);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',7);
//1
$pdf->setXY(17.7,10.85);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,10.75);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการสินค้าทั่วไป"),0 ,'L' );

$pdf->setXY(17.7,11.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,10.95);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งกล่องโฟม"),0 ,'L' );

$pdf->setXY(17.7,11.35);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,11.25);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งผัก-ผลไม้"),0 ,'L' );






$pdf->setXY(19.6,10.65);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//2
$pdf->setXY(19.7,10.85);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,10.75);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ไม่ควบคุมอุณหภูมิ"),0 ,'L' );

$pdf->setXY(19.7,11.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,10.95);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Chilled 2-8 C"),0 ,'L' );

$pdf->setXY(19.7,11.35);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,11.25);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Frozen -15 C"),0 ,'L' );





$pdf->setXY(21.6,10.65);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//3
$pdf->setXY(21.7,10.85);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,10.75);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ด่วน 1 วัน"),0 ,'L' );

$pdf->setXY(21.7,11.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,10.95);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ธรรมดา 2-3 วัน"),0 ,'L' );

/*$pdf->setXY(21.7,11.35);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,11.25);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ภายในวัน"),0 ,'L' );*/



$pdf->setXY(23.6,10.65);
$pdf->Cell(1.2,1.2, "",1,1,"c" );

$pdf->setXY(24.8,10.65);
$pdf->Cell(1.2,1.2, "",1,1,"c" );



$pdf->setXY(26.0,10.65);
$pdf->Cell(1.2,1.2, "",1,1,"c" );


$pdf->setXY(27.2,10.65);
$pdf->Cell(2.1,1.2, "",1,1,"c" );


$pdf->setXY(27.2,10.65);
$pdf->Cell(2.1,1.2, "",1,1,"c" );
	
	
//แถว 8
$pdf->setXY(0.3,11.85);
$pdf->Cell(0.8,1.2, "",1,1,"c" );	

$pdf->setXY(1.1,11.85);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->setXY(2.6,11.85);
$pdf->Cell(2.5,1.2, "",1,1,"c" );


$pdf->setXY(5.1,11.85);
$pdf->Cell(6.0,1.2, "",1,1,"c" );

$pdf->setXY(11.1,11.85);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(12.6,11.85);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(14.1,11.85);
$pdf->Cell(2.0,1.2, "",1,1,"c" );


$pdf->setXY(16.1,11.85);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',9);
$pdf->setXY(16.1,11.85);
$pdf->MultiCell(1.5,1.2, iconv( 'UTF-8','cp874' , "เครื่องมือแพทย์"),0 ,'C' );


$pdf->setXY(17.6,11.85);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',7);
//1
$pdf->setXY(17.7,12.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,11.95);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการสินค้าทั่วไป"),0 ,'L' );

$pdf->setXY(17.7,12.35);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,12.25);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งกล่องโฟม"),0 ,'L' );

$pdf->setXY(17.7,12.65);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,12.55);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งผัก-ผลไม้"),0 ,'L' );






$pdf->setXY(19.6,11.85);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//2
$pdf->setXY(19.7,12.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,11.95);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ไม่ควบคุมอุณหภูมิ"),0 ,'L' );

$pdf->setXY(19.7,12.35);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,12.25);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Chilled 2-8 C"),0 ,'L' );

$pdf->setXY(19.7,12.65);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,12.55);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Frozen -15 C"),0 ,'L' );





$pdf->setXY(21.6,11.85);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//3
$pdf->setXY(21.7,12.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,11.95);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ด่วน 1 วัน"),0 ,'L' );

$pdf->setXY(21.7,12.35);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,12.25);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ธรรมดา 2-3 วัน"),0 ,'L' );

/*$pdf->setXY(21.7,12.65);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,12.55);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ภายในวัน"),0 ,'L' );*/



$pdf->setXY(23.6,11.85);
$pdf->Cell(1.2,1.2, "",1,1,"c" );

$pdf->setXY(24.8,11.85);
$pdf->Cell(1.2,1.2, "",1,1,"c" );



$pdf->setXY(26.0,11.85);
$pdf->Cell(1.2,1.2, "",1,1,"c" );


$pdf->setXY(27.2,11.85);
$pdf->Cell(2.1,1.2, "",1,1,"c" );


$pdf->setXY(27.2,11.85);
$pdf->Cell(2.1,1.2, "",1,1,"c" );
	
	
//แถว 8
$pdf->setXY(0.3,13.05);
$pdf->Cell(0.8,1.2, "",1,1,"c" );	

$pdf->setXY(1.1,13.05);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->setXY(2.6,13.05);
$pdf->Cell(2.5,1.2, "",1,1,"c" );


$pdf->setXY(5.1,13.05);
$pdf->Cell(6.0,1.2, "",1,1,"c" );

$pdf->setXY(11.1,13.05);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(12.6,13.05);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(14.1,13.05);
$pdf->Cell(2.0,1.2, "",1,1,"c" );


$pdf->setXY(16.1,13.05);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',9);
$pdf->setXY(16.1,13.05);
$pdf->MultiCell(1.5,1.2, iconv( 'UTF-8','cp874' , "เครื่องมือแพทย์"),0 ,'C' );


$pdf->setXY(17.6,13.05);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',7);
//1
$pdf->setXY(17.7,13.25);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,13.15);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการสินค้าทั่วไป"),0 ,'L' );

$pdf->setXY(17.7,13.55);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,13.45);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งกล่องโฟม"),0 ,'L' );

$pdf->setXY(17.7,13.85);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,13.75);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งผัก-ผลไม้"),0 ,'L' );






$pdf->setXY(19.6,13.05);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//2
$pdf->setXY(19.7,13.25);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,13.15);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ไม่ควบคุมอุณหภูมิ"),0 ,'L' );

$pdf->setXY(19.7,13.55);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,13.45);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Chilled 2-8 C"),0 ,'L' );

$pdf->setXY(19.7,13.85);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,13.75);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Frozen -15 C"),0 ,'L' );





$pdf->setXY(21.6,13.05);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//3
$pdf->setXY(21.7,13.25);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,13.15);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ด่วน 1 วัน"),0 ,'L' );

$pdf->setXY(21.7,13.55);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,13.45);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ธรรมดา 2-3 วัน"),0 ,'L' );

/*$pdf->setXY(21.7,13.85);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,13.75);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ภายในวัน"),0 ,'L' );*/



$pdf->setXY(23.6,13.05);
$pdf->Cell(1.2,1.2, "",1,1,"c" );

$pdf->setXY(24.8,13.05);
$pdf->Cell(1.2,1.2, "",1,1,"c" );



$pdf->setXY(26.0,13.05);
$pdf->Cell(1.2,1.2, "",1,1,"c" );


$pdf->setXY(27.2,13.05);
$pdf->Cell(2.1,1.2, "",1,1,"c" );


$pdf->setXY(27.2,13.05);
$pdf->Cell(2.1,1.2, "",1,1,"c" );
	
	
//แถว 8
$pdf->setXY(0.3,14.25);
$pdf->Cell(0.8,1.2, "",1,1,"c" );	

$pdf->setXY(1.1,14.25);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->setXY(2.6,14.25);
$pdf->Cell(2.5,1.2, "",1,1,"c" );


$pdf->setXY(5.1,14.25);
$pdf->Cell(6.0,1.2, "",1,1,"c" );

$pdf->setXY(11.1,14.25);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(12.6,14.25);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(14.1,14.25);
$pdf->Cell(2.0,1.2, "",1,1,"c" );


$pdf->setXY(16.1,14.25);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',9);
$pdf->setXY(16.1,14.25);
$pdf->MultiCell(1.5,1.2, iconv( 'UTF-8','cp874' , "เครื่องมือแพทย์"),0 ,'C' );


$pdf->setXY(17.6,14.25);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',7);
//1
$pdf->setXY(17.7,14.45);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,14.35);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการสินค้าทั่วไป"),0 ,'L' );

$pdf->setXY(17.7,14.75);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,14.65);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งกล่องโฟม"),0 ,'L' );

$pdf->setXY(17.7,15.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,14.95);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งผัก-ผลไม้"),0 ,'L' );






$pdf->setXY(19.6,14.25);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//2
$pdf->setXY(19.7,14.45);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,14.35);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ไม่ควบคุมอุณหภูมิ"),0 ,'L' );

$pdf->setXY(19.7,14.75);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,14.65);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Chilled 2-8 C"),0 ,'L' );

$pdf->setXY(19.7,15.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,14.95);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Frozen -15 C"),0 ,'L' );





$pdf->setXY(21.6,14.25);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//3
$pdf->setXY(21.7,14.45);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,14.35);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ด่วน 1 วัน"),0 ,'L' );

$pdf->setXY(21.7,14.75);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,14.65);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ธรรมดา 2-3 วัน"),0 ,'L' );

/*$pdf->setXY(21.7,15.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,14.95);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ภายในวัน"),0 ,'L' );
*/


$pdf->setXY(23.6,14.25);
$pdf->Cell(1.2,1.2, "",1,1,"c" );

$pdf->setXY(24.8,14.25);
$pdf->Cell(1.2,1.2, "",1,1,"c" );



$pdf->setXY(26.0,14.25);
$pdf->Cell(1.2,1.2, "",1,1,"c" );


$pdf->setXY(27.2,14.25);
$pdf->Cell(2.1,1.2, "",1,1,"c" );


$pdf->setXY(27.2,14.25);
$pdf->Cell(2.1,1.2, "",1,1,"c" );
	

	
	
	
$pdf->SetFillColor(204,204,204);

$pdf->Cell(23.25,0.4,iconv('UTF-8','cp874','รวม'),1,0,"R",true);
$pdf->Cell(1.2,0.4,iconv('UTF-8','cp874',''),1,0,"R",true);
$pdf->Cell(1.2,0.4,iconv('UTF-8','cp874',''),1,0,"R",true);
$pdf->Cell(1.2,0.4,iconv('UTF-8','cp874',''),1,0,"R",true);
$pdf->Cell(2.1,0.4,iconv('UTF-8','cp874',''),1,0,"R",true);
		
//$pdf->setXY(0.3,11.85);
//$pdf->Cell(29,1.6, "",1,1,"c" );

$pdf->setXY(1.0,15.8);
$pdf->MultiCell(29,0.4, iconv( 'UTF-8','cp874' , "หมายเหตุ"),0 ,'L' );


$pdf->setXY(1.0,16.2);
$pdf->MultiCell(14,0.4, iconv( 'UTF-8','cp874' , "1. ประเภทสินค้าหากเป็นยาเย็นระบุ (ยาเย็น) / ยาธรรมดาระบุ (ยา)"),0 ,'L' );

$pdf->setXY(1.0,16.6);
$pdf->MultiCell(14,0.4, iconv( 'UTF-8','cp874' , "2.  ช่องประเภทสินค้า ระบุสินค้าที่บรรจุในกล่อง(เนื้อแช่แข็ง, ปลาแช่แข็ง, เนยแช่แข็ง, ผลไม้หรือสินค้าประเภทอื่น ๆ ฯลฯ)"),0 ,'L' );

$pdf->setXY(1.0,17.0);
$pdf->MultiCell(14,0.4, iconv( 'UTF-8','cp874' , "3. สินค้าประเภทผัก-ผลไม้ หากใช้บริการขนส่งผัก-ผลไม้ จะต้องเป็นลูกหรือเป็นผลเปลือกแข็งเท่านั้น"),0 ,'L' );


$pdf->setXY(15.0,16.2);
$pdf->MultiCell(14,0.4, iconv( 'UTF-8','cp874' , "4.  ช่องระบุขนาดกล่อง ระบุขนาดกล่องดังนี้ S1, S2,  A1, A2, B1, B2 / บริการขนส่งผัก-ผลไม้ ไม่ต้องระบุขนาดกล่อง แต่ต้องระบุน้ำหนัก (กิโลกรัม) ต่อกล่อง"),0 ,'L' );

$pdf->setXY(15.0,16.6);
$pdf->MultiCell(14,0.4, iconv( 'UTF-8','cp874' , "5. กรณีที่ผู้รับปลายทางไม่มีเบอร์โทรติดต่อให้ใช้เบอร์โทรติดต่อของผู้ส่งสินค้าแทน"),0 ,'L' );

$pdf->setXY(15.0,17.0);
$pdf->MultiCell(14,0.4, iconv( 'UTF-8','cp874' , "6. หากไม่ทราบวิธีคิดขนาดกล่อง ระบุน้ำหนักต่อกล่องในช่องน้ำหนักและปริมาตร กว้าง X ยาว X สูง (เซนติเมตร) ในช่องหมายเหตุ"),0 ,'L' );
	
$pdf->Cell(28.9,0.4,iconv('UTF-8','cp874',''),0,0,"C",true);
	
	
$pdf->SetFont('angsa','',8);	
$pdf->setXY(11,18.0);
$pdf->Cell(8,2.2, "",1,1,"c" );	
	
$pdf->setXY(11,18.1);
$pdf->MultiCell(8,0.3, iconv( 'UTF-8','cp874' , "ใบรายงานการส่งสินค้าหน้านี้เป็นใบรายงานการส่งสินค้าหน้าถัดมาที่ผู้ส่งสินค้า"),0 ,'C' );
	
$pdf->setXY(11,18.4);
$pdf->MultiCell(8,0.3, iconv( 'UTF-8','cp874' , "จะแนบไปกับใบรายงานการส่งสินค้าหน้าแรกด้วยทุกครั้ง(ถ้ามีการส่งหลายปลายทาง)และครอบคลุม"),0 ,'C' );
	
$pdf->setXY(11,18.7);
$pdf->MultiCell(8,0.3, iconv( 'UTF-8','cp874' , "คำรับรองของผู้ส่งสินค้าเช่นเดียวกันกับหน้าแรกทุกประการ"),0 ,'C' );

$pdf->setXY(11,19.0);
$pdf->MultiCell(8,0.3, iconv( 'UTF-8','cp874' , "(ลงชื่อผู้ส่งสินค้าทุกใบรายงานการส่งสินค้าหน้าถัดมา)"),0 ,'C' );
	
	
$pdf->setXY(11,19.8);
$pdf->MultiCell(8,0.3, iconv( 'UTF-8','cp874' , "ลงชื่อ  .................................................................  ผู้ส่งสินค้า วันที่ ............... / ................ / ..............."),0 ,'C' );
	
	
$pdf->Image("img/qrcode_inter.png",27.7,18.5,1.5,1.5);

$pdf->SetFont('angsa','',7);
$pdf->setXY(26.5,20.2);
$pdf->MultiCell(29,0, iconv( 'UTF-8','cp874' , "FM-RC-01, แก้ไขครั้งที่ 10.01-02-2026"),0 ,'L' );
	
	
}	



//หน้าที่ 5

$strSQL = "SELECT ref_id,customer_name,address_name,customer_tel FROM tb_register_data  WHERE start_date >= '".$start_date."' and start_date <= '".$end_date."' and type_company='".$company."' and bus_inter='1' LIMIT 10 OFFSET 35";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$Num_Rows = mysqli_num_rows($objQuery);

if($Num_Rows > 0){
//$pdf->AddPage();

$pdf->SetFont('angsa','',14);

$pdf->setXY(0.3,0.3);
$pdf->Cell(29.0,20.3, "",1,1,"c" );

$pdf->Image("img/inter_express.png",0.3,0.35,2.5,1.0);

$pdf->setXY(0.3,0.35);
$pdf->Cell(25.0,2.2, "",1,1,"c" );

//$pdf->SetFont('angsana','B',20);

$pdf->setXY(0.3,0.4);
$pdf->MultiCell(25, 0.6 , iconv( 'UTF-8','cp874' , "ใบรายงานการส่งสินค้า Delivery Manifest"),0 ,'C' );

$pdf->setXY(0.3,0.9);
$pdf->MultiCell(25, 0.6 , iconv( 'UTF-8','cp874' , "สำหรับบริการสินค้าทั่วไป (Ambient) บริการขนส่งกล่องโฟม (INTER FOAM) บริการขนส่งผัก-ผลไม้ (FRUIT DELIVERY) "),0 ,'C' );

$pdf->SetFont('angsa','',11);

$pdf->setXY(0.3,1.5);
$pdf->MultiCell(25, 0.6 , iconv( 'UTF-8','cp874' , "หน้าแรก แผ่นที่ 1 /……"),0 ,'L' );

$pdf->setXY(0.3,2.0);
$pdf->MultiCell(25, 0.6 , iconv( 'UTF-8','cp874' , "วันที่ …$start_date_th....."),0 ,'L' );


$pdf->SetFont('angsa','',12);

if($_GET["company"]=='3'){
$pdf->setXY(0.3,1.5);
$pdf->MultiCell(25, 0.5 , iconv( 'UTF-8','cp874' , "ผู้ส่งสินค้า/บริษัท…....................บริษัท ออลล์เวล ไลฟ์ จำกัด.........................….รหัสลูกค้า……...................…...................…....................….........."),0 ,'C' );

$pdf->setXY(0.3,2.0);
$pdf->MultiCell(25, 0.5 , iconv( 'UTF-8','cp874' , "ที่อยู่ผู้ส่ง...................73,75 ซ.จรัญสนิทวงศ์89/2 แขวงบางอ้อ เขตบางพลัด กรุงเทพมหานคร 10700....................เบอร์ผู้ส่งสินค้า ........02-424-3555....................."),0 ,'C' );

}
if($_GET["company"]=='4'){
	
$pdf->setXY(0.3,1.5);
$pdf->MultiCell(25, 0.5 , iconv( 'UTF-8','cp874' , "ผู้ส่งสินค้า/บริษัท…....................บริษัท โนเบิล เมด จำกัด........................….รหัสลูกค้า……...................…...................…....................….........."),0 ,'C' );

$pdf->setXY(0.3,2.0);
$pdf->MultiCell(25, 0.5 , iconv( 'UTF-8','cp874' , "ที่อยู่ผู้ส่ง....................73 ซ.จรัญสนิทวงศ์89/2 แขวงบางอ้อ เขตบางพลัด กรุงเทพมหานคร 10700........................เบอร์ผู้ส่งสินค้า ........02-880-5566.........................."),0 ,'C' );
	
}
	
$pdf->setXY(25.3,0.35);
$pdf->Cell(4.0,2.2, "",1,1,"c" );	

$pdf->SetFont('angsa','',14);
	
$pdf->setXY(25.3,0.8);
$pdf->MultiCell(4.0, 0.5 , iconv( 'UTF-8','cp874' , "สำหรับติดสติ๊กเกอร์"),0 ,'C' );

$pdf->setXY(25.3,1.5);
$pdf->MultiCell(4.0, 0.5 , iconv( 'UTF-8','cp874' , "M/F Number"),0 ,'C' );

$pdf->SetFont('angsa','',10);

$pdf->setXY(0.3,2.55);
$pdf->Cell(0.8,0.9, "",1,1,"c" );	

$pdf->setXY(0.3,2.55);
$pdf->MultiCell(0.8,0.9, iconv( 'UTF-8','cp874' , "ลำดับ"),0 ,'C' );

$pdf->setXY(1.1,2.55);
$pdf->Cell(1.5,0.9, "",1,1,"c" );

$pdf->setXY(1.1,2.55);
$pdf->MultiCell(1.5,0.9, iconv( 'UTF-8','cp874' , "เลขที่บิล"),0 ,'C' );

$pdf->setXY(2.6,2.55);
$pdf->Cell(2.5,0.9, "",1,1,"c" );

$pdf->setXY(2.6,2.55);
$pdf->MultiCell(2.5,0.9, iconv( 'UTF-8','cp874' , "ชื่อผู้รับสินค้า"),0 ,'C' );


$pdf->setXY(5.1,2.55);
$pdf->Cell(6.0,0.9, "",1,1,"c" );

$pdf->setXY(5.1,2.6);
$pdf->MultiCell(6.0,0.45, iconv( 'UTF-8','cp874' , "ที่อยู่ผู้รับสินค้า"),0 ,'C' );
$pdf->setXY(5.1,3.05);
$pdf->MultiCell(6.0,0.4, iconv( 'UTF-8','cp874' , "(ระบุบ้านเลขที่ หมู่ที่ หมู่บ้าน ถนน ตำบล/แขวง)"),0 ,'C' );


$pdf->setXY(11.1,2.55);
$pdf->Cell(1.5,0.9, "",1,1,"c" );

$pdf->setXY(11.1,2.55);
$pdf->MultiCell(1.5,0.9, iconv( 'UTF-8','cp874' , "อำเภอ/เขต"),0 ,'C' );

$pdf->setXY(12.6,2.55);
$pdf->Cell(1.5,0.9, "",1,1,"c" );

$pdf->setXY(12.6,2.55);
$pdf->MultiCell(1.5,0.9, iconv( 'UTF-8','cp874' , "จังหวัด"),0 ,'C' );


$pdf->setXY(14.1,2.55);
$pdf->Cell(2.0,0.9, "",1,1,"c" );

$pdf->setXY(14.1,2.55);
$pdf->MultiCell(2.0,0.9, iconv( 'UTF-8','cp874' , "เบอร์ผู้รับสินค้า"),0 ,'C' );

$pdf->setXY(16.1,2.55);
$pdf->Cell(1.5,0.9, "",1,1,"c" );

$pdf->setXY(16.1,2.55);
$pdf->MultiCell(1.5,0.9, iconv( 'UTF-8','cp874' , "ประเภทสินค้า"),0 ,'C' );


$pdf->setXY(17.6,2.55);
$pdf->Cell(2.0,0.9, "",1,1,"c" );

$pdf->setXY(17.6,2.55);
$pdf->MultiCell(2.0,0.9, iconv( 'UTF-8','cp874' , "ประเภทบริการ"),0 ,'C' );

$pdf->setXY(19.6,2.55);
$pdf->Cell(2.0,0.9, "",1,1,"c" );

$pdf->setXY(19.6,2.55);
$pdf->MultiCell(2.0,0.9, iconv( 'UTF-8','cp874' , "ประเภทอุณหภูมิ"),0 ,'C' );

$pdf->setXY(21.6,2.55);
$pdf->Cell(2.0,0.9, "",1,1,"c" );

$pdf->setXY(21.6,2.55);
$pdf->MultiCell(2.0,0.9, iconv( 'UTF-8','cp874' , "บริการจัดส่ง (SLA)"),0 ,'C' );

$pdf->setXY(23.6,2.55);
$pdf->Cell(1.2,0.9, "",1,1,"c" );

$pdf->setXY(23.6,2.55);
$pdf->MultiCell(1.2,0.45, iconv( 'UTF-8','cp874' , "ระบุขนาด"),0 ,'C' );

$pdf->setXY(23.6,2.95);
$pdf->MultiCell(1.2,0.4, iconv( 'UTF-8','cp874' , "กล่อง"),0 ,'C' );


$pdf->setXY(24.8,2.55);
$pdf->Cell(1.2,0.9, "",1,1,"c" );

$pdf->setXY(24.8,2.55);
$pdf->MultiCell(1.2,0.45, iconv( 'UTF-8','cp874' , "น้ำหนัก/"),0 ,'C' );

$pdf->setXY(24.8,2.95);
$pdf->MultiCell(1.2,0.4, iconv( 'UTF-8','cp874' , "กล่อง"),0 ,'C' );

$pdf->setXY(26.0,2.55);
$pdf->Cell(1.2,0.9, "",1,1,"c" );

$pdf->setXY(26.0,2.55);
$pdf->MultiCell(1.2,0.45, iconv( 'UTF-8','cp874' , "จำนวน"),0 ,'C' );

$pdf->setXY(26.0,2.95);
$pdf->MultiCell(1.2,0.4, iconv( 'UTF-8','cp874' , "กล่อง"),0 ,'C' );


$pdf->setXY(27.2,2.55);
$pdf->Cell(2.1,0.9, "",1,1,"c" );

$pdf->setXY(27.2,2.55);
$pdf->MultiCell(2.1,0.9, iconv( 'UTF-8','cp874' , "หมายเหตุ"),0 ,'C' );
	
	
$j=36;
while($objResult = mysqli_fetch_array($objQuery))
{	
	
$ref_id = substr($objResult["ref_id"],0,2);	
	
if($ref_id=='SO'){	
$strSQL15 = "SELECT iv_no FROM hos__so WHERE ref_id = '".$objResult["ref_id"]."' ";
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResult15= mysqli_fetch_array($objQuery15);
	
$iv_no =$objResult15["iv_no"];	
$customer_name = $objResult["customer_name"];
$address_name = $objResult["address_name"];	
$customer_tel = $objResult["customer_tel"];	
	
}else if($ref_id=='BR'){
	
$strSQL15 = "SELECT iv_no FROM hos__br WHERE ref_id_br = '".$objResult["ref_id"]."' ";
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResult15= mysqli_fetch_array($objQuery15);
	
$iv_no =$objResult15["iv_no"];	
$customer_name = $objResult["customer_name"];
$address_name = $objResult["address_name"];	
$customer_tel = $objResult["customer_tel"];	
	
}else if($ref_id=='CH'){
	
$strSQL15 = "SELECT iv_no FROM hos__change WHERE ref_id = '".$objResult["ref_id"]."' ";
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResult15= mysqli_fetch_array($objQuery15);
	
$iv_no =$objResult15["iv_no"];	
$customer_name = $objResult["customer_name"];
$address_name = $objResult["address_name"];	
$customer_tel = $objResult["customer_tel"];	

}else if($ref_id=='BS'){
	
$strSQL15 = "SELECT iv_no FROM hos__consig WHERE ref_id = '".$objResult["ref_id"]."' ";
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResult15= mysqli_fetch_array($objQuery15);
	
$iv_no =$objResult15["iv_no"];	
$customer_name = $objResult["customer_name"];
$address_name = $objResult["address_name"];	
$customer_tel = $objResult["customer_tel"];	
	
	
}else{
	
$strSQL15 = "SELECT doc_no,customer_name,address1,address2,province,postcode,tel FROM so__main WHERE ref_id = '".$objResult["ref_id"]."' ";
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResult15= mysqli_fetch_array($objQuery15);
	
$iv_no =$objResult15["doc_no"];	
$customer_name = $objResult15["customer_name"];
$address1 = $objResult15["address1"];	
$address2 = $objResult15["address2"];	
$province = $objResult15["province"];	
$postcode = $objResult15["postcode"];		
$address_name = "$address1 $address2 $province $postcode";	
$customer_tel = $objResult15["tel"];	
	
}
	
$pdf->setX(0.3);
$pdf->Cell(0.8,1.2, iconv('UTF-8','cp874', "$j"),1,0,'C');
$pdf->Cell(1.5,1.2, iconv('UTF-8','cp874', "$iv_no"),1,0,'C');
$pdf->Cell(2.5,1.2, iconv('UTF-8','cp874', "$customer_name"),1,0,'L');
$pdf->Cell(6.0,1.2, '',1,0,'L');
$addressY = $pdf->GetY();
$addressX = $pdf->GetX();
$pdf->SetXY($addressX - 6.0, $addressY);
$pdf->MultiCell(6.0,0.4, iconv('UTF-8//IGNORE','cp874//IGNORE', "$address_name"),0,'L');
$pdf->SetXY($addressX, $addressY);
$pdf->Cell(1.5,1.2, iconv('UTF-8','cp874', ""),1,0,'C');
$pdf->Cell(1.5,1.2, iconv('UTF-8','cp874', ""),1,0,'C');	
$pdf->Cell(2.0,1.2, iconv('UTF-8','cp874', "$customer_tel"),1,1,'L');
	

$j++;


}
	
//แถว 1
$pdf->setXY(0.3,3.45);
$pdf->Cell(0.8,1.2, "",1,1,"c" );	

$pdf->setXY(1.1,3.45);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->setXY(2.6,3.45);
$pdf->Cell(2.5,1.2, "",1,1,"c" );


$pdf->setXY(5.1,3.45);
$pdf->Cell(6.0,1.2, "",1,1,"c" );

$pdf->setXY(11.1,3.45);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(12.6,3.45);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(14.1,3.45);
$pdf->Cell(2.0,1.2, "",1,1,"c" );


$pdf->setXY(16.1,3.45);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',9);
$pdf->setXY(16.1,3.45);
$pdf->MultiCell(1.5,1.2, iconv( 'UTF-8','cp874' , "เครื่องมือแพทย์"),0 ,'C' );


$pdf->setXY(17.6,3.45);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',7);
//1
$pdf->setXY(17.7,3.65);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,3.55);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการสินค้าทั่วไป"),0 ,'L' );

$pdf->setXY(17.7,3.95);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,3.85);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งกล่องโฟม"),0 ,'L' );

$pdf->setXY(17.7,4.25);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,4.2);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งผัก-ผลไม้"),0 ,'L' );






$pdf->setXY(19.6,3.45);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//2
$pdf->setXY(19.7,3.65);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,3.55);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ไม่ควบคุมอุณหภูมิ"),0 ,'L' );

$pdf->setXY(19.7,3.95);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,3.85);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Chilled 2-8 C"),0 ,'L' );

$pdf->setXY(19.7,4.25);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,4.2);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Frozen -15 C"),0 ,'L' );





$pdf->setXY(21.6,3.45);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//3
$pdf->setXY(21.7,3.65);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,3.55);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ด่วน 1 วัน"),0 ,'L' );

$pdf->setXY(21.7,3.95);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,3.85);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ธรรมดา 2-3 วัน"),0 ,'L' );

/*$pdf->setXY(21.7,4.25);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,4.2);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ภายในวัน"),0 ,'L' );
*/


$pdf->setXY(23.6,3.45);
$pdf->Cell(1.2,1.2, "",1,1,"c" );

$pdf->setXY(24.8,3.45);
$pdf->Cell(1.2,1.2, "",1,1,"c" );



$pdf->setXY(26.0,3.45);
$pdf->Cell(1.2,1.2, "",1,1,"c" );


$pdf->setXY(27.2,3.45);
$pdf->Cell(2.1,1.2, "",1,1,"c" );





//แถว 2
$pdf->setXY(0.3,4.65);
$pdf->Cell(0.8,1.2, "",1,1,"c" );	

$pdf->setXY(1.1,4.65);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->setXY(2.6,4.65);
$pdf->Cell(2.5,1.2, "",1,1,"c" );


$pdf->setXY(5.1,4.65);
$pdf->Cell(6.0,1.2, "",1,1,"c" );

$pdf->setXY(11.1,4.65);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(12.6,4.65);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(14.1,4.65);
$pdf->Cell(2.0,1.2, "",1,1,"c" );


$pdf->setXY(16.1,4.65);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',9);
$pdf->setXY(16.1,4.65);
$pdf->MultiCell(1.5,1.2, iconv( 'UTF-8','cp874' , "เครื่องมือแพทย์"),0 ,'C' );


$pdf->setXY(17.6,4.65);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',7);
//1
$pdf->setXY(17.7,4.85);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,4.75);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการสินค้าทั่วไป"),0 ,'L' );

$pdf->setXY(17.7,5.15);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,5.05);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งกล่องโฟม"),0 ,'L' );

$pdf->setXY(17.7,5.45);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,5.4);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งผัก-ผลไม้"),0 ,'L' );






$pdf->setXY(19.6,4.65);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//2
$pdf->setXY(19.7,4.85);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,4.75);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ไม่ควบคุมอุณหภูมิ"),0 ,'L' );

$pdf->setXY(19.7,5.15);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,5.05);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Chilled 2-8 C"),0 ,'L' );

$pdf->setXY(19.7,5.45);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,5.4);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Frozen -15 C"),0 ,'L' );





$pdf->setXY(21.6,4.65);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//3
$pdf->setXY(21.7,4.85);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,4.75);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ด่วน 1 วัน"),0 ,'L' );

$pdf->setXY(21.7,5.15);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,5.05);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ธรรมดา 2-3 วัน"),0 ,'L' );

/*$pdf->setXY(21.7,5.45);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,5.4);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ภายในวัน"),0 ,'L' );*/



$pdf->setXY(23.6,4.65);
$pdf->Cell(1.2,1.2, "",1,1,"c" );

$pdf->setXY(24.8,4.65);
$pdf->Cell(1.2,1.2, "",1,1,"c" );



$pdf->setXY(26.0,4.65);
$pdf->Cell(1.2,1.2, "",1,1,"c" );


$pdf->setXY(27.2,4.65);
$pdf->Cell(2.1,1.2, "",1,1,"c" );





//แถว 3
$pdf->setXY(0.3,5.85);
$pdf->Cell(0.8,1.2, "",1,1,"c" );	

$pdf->setXY(1.1,5.85);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->setXY(2.6,5.85);
$pdf->Cell(2.5,1.2, "",1,1,"c" );


$pdf->setXY(5.1,5.85);
$pdf->Cell(6.0,1.2, "",1,1,"c" );

$pdf->setXY(11.1,5.85);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(12.6,5.85);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(14.1,5.85);
$pdf->Cell(2.0,1.2, "",1,1,"c" );


$pdf->setXY(16.1,5.85);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',9);
$pdf->setXY(16.1,5.85);
$pdf->MultiCell(1.5,1.2, iconv( 'UTF-8','cp874' , "เครื่องมือแพทย์"),0 ,'C' );


$pdf->setXY(17.6,5.85);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',7);
//1
$pdf->setXY(17.7,6.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,5.95);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการสินค้าทั่วไป"),0 ,'L' );

$pdf->setXY(17.7,6.35);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,6.25);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งกล่องโฟม"),0 ,'L' );

$pdf->setXY(17.7,6.65);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,6.6);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งผัก-ผลไม้"),0 ,'L' );






$pdf->setXY(19.6,5.85);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//2
$pdf->setXY(19.7,6.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,5.95);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ไม่ควบคุมอุณหภูมิ"),0 ,'L' );

$pdf->setXY(19.7,6.35);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,6.25);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Chilled 2-8 C"),0 ,'L' );

$pdf->setXY(19.7,6.65);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,6.6);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Frozen -15 C"),0 ,'L' );





$pdf->setXY(21.6,5.85);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//3
$pdf->setXY(21.7,6.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,5.95);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ด่วน 1 วัน"),0 ,'L' );

$pdf->setXY(21.7,6.35);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,6.25);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ธรรมดา 2-3 วัน"),0 ,'L' );

/*$pdf->setXY(21.7,6.65);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,6.6);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ภายในวัน"),0 ,'L' );*/



$pdf->setXY(23.6,5.85);
$pdf->Cell(1.2,1.2, "",1,1,"c" );

$pdf->setXY(24.8,5.85);
$pdf->Cell(1.2,1.2, "",1,1,"c" );



$pdf->setXY(26.0,5.85);
$pdf->Cell(1.2,1.2, "",1,1,"c" );


$pdf->setXY(27.2,5.85);
$pdf->Cell(2.1,1.2, "",1,1,"c" );



//แถว 4
$pdf->setXY(0.3,7.05);
$pdf->Cell(0.8,1.2, "",1,1,"c" );	

$pdf->setXY(1.1,7.05);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->setXY(2.6,7.05);
$pdf->Cell(2.5,1.2, "",1,1,"c" );


$pdf->setXY(5.1,7.05);
$pdf->Cell(6.0,1.2, "",1,1,"c" );

$pdf->setXY(11.1,7.05);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(12.6,7.05);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(14.1,7.05);
$pdf->Cell(2.0,1.2, "",1,1,"c" );


$pdf->setXY(16.1,7.05);
$pdf->Cell(1.5,1.2, "",1,1,"c" );
$pdf->SetFont('angsa','',9);
$pdf->setXY(16.1,7.05);
$pdf->MultiCell(1.5,1.2, iconv( 'UTF-8','cp874' , "เครื่องมือแพทย์"),0 ,'C' );



$pdf->setXY(17.6,7.05);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',7);
//1
$pdf->setXY(17.7,7.25);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,7.15);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการสินค้าทั่วไป"),0 ,'L' );

$pdf->setXY(17.7,7.55);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,7.45);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งกล่องโฟม"),0 ,'L' );

$pdf->setXY(17.7,7.85);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,7.8);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งผัก-ผลไม้"),0 ,'L' );






$pdf->setXY(19.6,7.05);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//2
$pdf->setXY(19.7,7.25);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,7.15);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ไม่ควบคุมอุณหภูมิ"),0 ,'L' );

$pdf->setXY(19.7,7.55);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,7.45);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Chilled 2-8 C"),0 ,'L' );

$pdf->setXY(19.7,7.85);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,7.8);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Frozen -15 C"),0 ,'L' );





$pdf->setXY(21.6,7.05);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//3
$pdf->setXY(21.7,7.25);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,7.15);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ด่วน 1 วัน"),0 ,'L' );

$pdf->setXY(21.7,7.55);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,7.45);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ธรรมดา 2-3 วัน"),0 ,'L' );

/*$pdf->setXY(21.7,7.85);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,7.8);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ภายในวัน"),0 ,'L' );*/



$pdf->setXY(23.6,7.05);
$pdf->Cell(1.2,1.2, "",1,1,"c" );

$pdf->setXY(24.8,7.05);
$pdf->Cell(1.2,1.2, "",1,1,"c" );



$pdf->setXY(26.0,7.05);
$pdf->Cell(1.2,1.2, "",1,1,"c" );


$pdf->setXY(27.2,7.05);
$pdf->Cell(2.1,1.2, "",1,1,"c" );



//แถว 5
$pdf->setXY(0.3,8.25);
$pdf->Cell(0.8,1.2, "",1,1,"c" );	

$pdf->setXY(1.1,8.25);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->setXY(2.6,8.25);
$pdf->Cell(2.5,1.2, "",1,1,"c" );


$pdf->setXY(5.1,8.25);
$pdf->Cell(6.0,1.2, "",1,1,"c" );

$pdf->setXY(11.1,8.25);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(12.6,8.25);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(14.1,8.25);
$pdf->Cell(2.0,1.2, "",1,1,"c" );


$pdf->setXY(16.1,8.25);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',9);
$pdf->setXY(16.1,8.25);
$pdf->MultiCell(1.5,1.2, iconv( 'UTF-8','cp874' , "เครื่องมือแพทย์"),0 ,'C' );


$pdf->setXY(17.6,8.25);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',7);
//1
$pdf->setXY(17.7,8.45);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,8.35);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการสินค้าทั่วไป"),0 ,'L' );

$pdf->setXY(17.7,8.75);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,8.65);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งกล่องโฟม"),0 ,'L' );

$pdf->setXY(17.7,9.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,9.0);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งผัก-ผลไม้"),0 ,'L' );






$pdf->setXY(19.6,8.25);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//2
$pdf->setXY(19.7,8.45);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,8.35);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ไม่ควบคุมอุณหภูมิ"),0 ,'L' );

$pdf->setXY(19.7,8.75);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,8.65);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Chilled 2-8 C"),0 ,'L' );

$pdf->setXY(19.7,9.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,9.0);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Frozen -15 C"),0 ,'L' );





$pdf->setXY(21.6,8.25);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//3
$pdf->setXY(21.7,8.45);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,8.35);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ด่วน 1 วัน"),0 ,'L' );

$pdf->setXY(21.7,8.75);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,8.65);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ธรรมดา 2-3 วัน"),0 ,'L' );

/*$pdf->setXY(21.7,9.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,9.0);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ภายในวัน"),0 ,'L' );*/



$pdf->setXY(23.6,8.25);
$pdf->Cell(1.2,1.2, "",1,1,"c" );

$pdf->setXY(24.8,8.25);
$pdf->Cell(1.2,1.2, "",1,1,"c" );



$pdf->setXY(26.0,8.25);
$pdf->Cell(1.2,1.2, "",1,1,"c" );


$pdf->setXY(27.2,8.25);
$pdf->Cell(2.1,1.2, "",1,1,"c" );


$pdf->setXY(27.2,8.25);
$pdf->Cell(2.1,1.2, "",1,1,"c" );
	
	
//แถว 6
$pdf->setXY(0.3,9.45);
$pdf->Cell(0.8,1.2, "",1,1,"c" );	

$pdf->setXY(1.1,9.45);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->setXY(2.6,9.45);
$pdf->Cell(2.5,1.2, "",1,1,"c" );


$pdf->setXY(5.1,9.45);
$pdf->Cell(6.0,1.2, "",1,1,"c" );

$pdf->setXY(11.1,9.45);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(12.6,9.45);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(14.1,9.45);
$pdf->Cell(2.0,1.2, "",1,1,"c" );


$pdf->setXY(16.1,9.45);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',9);
$pdf->setXY(16.1,9.45);
$pdf->MultiCell(1.5,1.2, iconv( 'UTF-8','cp874' , "เครื่องมือแพทย์"),0 ,'C' );


$pdf->setXY(17.6,9.45);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',7);
//1
$pdf->setXY(17.7,9.65);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,9.55);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการสินค้าทั่วไป"),0 ,'L' );

$pdf->setXY(17.7,9.95);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,9.85);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งกล่องโฟม"),0 ,'L' );

$pdf->setXY(17.7,10.25);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,10.15);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งผัก-ผลไม้"),0 ,'L' );






$pdf->setXY(19.6,9.45);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//2
$pdf->setXY(19.7,9.65);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,9.55);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ไม่ควบคุมอุณหภูมิ"),0 ,'L' );

$pdf->setXY(19.7,9.95);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,9.85);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Chilled 2-8 C"),0 ,'L' );

$pdf->setXY(19.7,10.25);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,10.15);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Frozen -15 C"),0 ,'L' );





$pdf->setXY(21.6,9.45);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//3
$pdf->setXY(21.7,9.65);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,9.55);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ด่วน 1 วัน"),0 ,'L' );

$pdf->setXY(21.7,9.95);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,9.85);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ธรรมดา 2-3 วัน"),0 ,'L' );

/*$pdf->setXY(21.7,10.25);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

pdf->setXY(22.0,10.15);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ภายในวัน"),0 ,'L' );*/



$pdf->setXY(23.6,9.45);
$pdf->Cell(1.2,1.2, "",1,1,"c" );

$pdf->setXY(24.8,9.45);
$pdf->Cell(1.2,1.2, "",1,1,"c" );



$pdf->setXY(26.0,9.45);
$pdf->Cell(1.2,1.2, "",1,1,"c" );


$pdf->setXY(27.2,9.45);
$pdf->Cell(2.1,1.2, "",1,1,"c" );


$pdf->setXY(27.2,9.45);
$pdf->Cell(2.1,1.2, "",1,1,"c" );
	
//แถว 7
$pdf->setXY(0.3,10.65);
$pdf->Cell(0.8,1.2, "",1,1,"c" );	

$pdf->setXY(1.1,10.65);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->setXY(2.6,10.65);
$pdf->Cell(2.5,1.2, "",1,1,"c" );


$pdf->setXY(5.1,10.65);
$pdf->Cell(6.0,1.2, "",1,1,"c" );

$pdf->setXY(11.1,10.65);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(12.6,10.65);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(14.1,10.65);
$pdf->Cell(2.0,1.2, "",1,1,"c" );


$pdf->setXY(16.1,10.65);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',9);
$pdf->setXY(16.1,10.65);
$pdf->MultiCell(1.5,1.2, iconv( 'UTF-8','cp874' , "เครื่องมือแพทย์"),0 ,'C' );


$pdf->setXY(17.6,10.65);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',7);
//1
$pdf->setXY(17.7,10.85);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,10.75);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการสินค้าทั่วไป"),0 ,'L' );

$pdf->setXY(17.7,11.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,10.95);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งกล่องโฟม"),0 ,'L' );

$pdf->setXY(17.7,11.35);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,11.25);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งผัก-ผลไม้"),0 ,'L' );






$pdf->setXY(19.6,10.65);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//2
$pdf->setXY(19.7,10.85);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,10.75);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ไม่ควบคุมอุณหภูมิ"),0 ,'L' );

$pdf->setXY(19.7,11.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,10.95);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Chilled 2-8 C"),0 ,'L' );

$pdf->setXY(19.7,11.35);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,11.25);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Frozen -15 C"),0 ,'L' );





$pdf->setXY(21.6,10.65);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//3
$pdf->setXY(21.7,10.85);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,10.75);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ด่วน 1 วัน"),0 ,'L' );

$pdf->setXY(21.7,11.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,10.95);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ธรรมดา 2-3 วัน"),0 ,'L' );

/*$pdf->setXY(21.7,11.35);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,11.25);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ภายในวัน"),0 ,'L' );*/



$pdf->setXY(23.6,10.65);
$pdf->Cell(1.2,1.2, "",1,1,"c" );

$pdf->setXY(24.8,10.65);
$pdf->Cell(1.2,1.2, "",1,1,"c" );



$pdf->setXY(26.0,10.65);
$pdf->Cell(1.2,1.2, "",1,1,"c" );


$pdf->setXY(27.2,10.65);
$pdf->Cell(2.1,1.2, "",1,1,"c" );


$pdf->setXY(27.2,10.65);
$pdf->Cell(2.1,1.2, "",1,1,"c" );
	
	
//แถว 8
$pdf->setXY(0.3,11.85);
$pdf->Cell(0.8,1.2, "",1,1,"c" );	

$pdf->setXY(1.1,11.85);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->setXY(2.6,11.85);
$pdf->Cell(2.5,1.2, "",1,1,"c" );


$pdf->setXY(5.1,11.85);
$pdf->Cell(6.0,1.2, "",1,1,"c" );

$pdf->setXY(11.1,11.85);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(12.6,11.85);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(14.1,11.85);
$pdf->Cell(2.0,1.2, "",1,1,"c" );


$pdf->setXY(16.1,11.85);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',9);
$pdf->setXY(16.1,11.85);
$pdf->MultiCell(1.5,1.2, iconv( 'UTF-8','cp874' , "เครื่องมือแพทย์"),0 ,'C' );


$pdf->setXY(17.6,11.85);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',7);
//1
$pdf->setXY(17.7,12.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,11.95);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการสินค้าทั่วไป"),0 ,'L' );

$pdf->setXY(17.7,12.35);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,12.25);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งกล่องโฟม"),0 ,'L' );

$pdf->setXY(17.7,12.65);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,12.55);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งผัก-ผลไม้"),0 ,'L' );






$pdf->setXY(19.6,11.85);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//2
$pdf->setXY(19.7,12.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,11.95);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ไม่ควบคุมอุณหภูมิ"),0 ,'L' );

$pdf->setXY(19.7,12.35);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,12.25);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Chilled 2-8 C"),0 ,'L' );

$pdf->setXY(19.7,12.65);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,12.55);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Frozen -15 C"),0 ,'L' );





$pdf->setXY(21.6,11.85);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//3
$pdf->setXY(21.7,12.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,11.95);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ด่วน 1 วัน"),0 ,'L' );

$pdf->setXY(21.7,12.35);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,12.25);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ธรรมดา 2-3 วัน"),0 ,'L' );

/*$pdf->setXY(21.7,12.65);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,12.55);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ภายในวัน"),0 ,'L' );*/



$pdf->setXY(23.6,11.85);
$pdf->Cell(1.2,1.2, "",1,1,"c" );

$pdf->setXY(24.8,11.85);
$pdf->Cell(1.2,1.2, "",1,1,"c" );



$pdf->setXY(26.0,11.85);
$pdf->Cell(1.2,1.2, "",1,1,"c" );


$pdf->setXY(27.2,11.85);
$pdf->Cell(2.1,1.2, "",1,1,"c" );


$pdf->setXY(27.2,11.85);
$pdf->Cell(2.1,1.2, "",1,1,"c" );
	
	
//แถว 8
$pdf->setXY(0.3,13.05);
$pdf->Cell(0.8,1.2, "",1,1,"c" );	

$pdf->setXY(1.1,13.05);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->setXY(2.6,13.05);
$pdf->Cell(2.5,1.2, "",1,1,"c" );


$pdf->setXY(5.1,13.05);
$pdf->Cell(6.0,1.2, "",1,1,"c" );

$pdf->setXY(11.1,13.05);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(12.6,13.05);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(14.1,13.05);
$pdf->Cell(2.0,1.2, "",1,1,"c" );


$pdf->setXY(16.1,13.05);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',9);
$pdf->setXY(16.1,13.05);
$pdf->MultiCell(1.5,1.2, iconv( 'UTF-8','cp874' , "เครื่องมือแพทย์"),0 ,'C' );


$pdf->setXY(17.6,13.05);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',7);
//1
$pdf->setXY(17.7,13.25);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,13.15);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการสินค้าทั่วไป"),0 ,'L' );

$pdf->setXY(17.7,13.55);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,13.45);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งกล่องโฟม"),0 ,'L' );

$pdf->setXY(17.7,13.85);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,13.75);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งผัก-ผลไม้"),0 ,'L' );






$pdf->setXY(19.6,13.05);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//2
$pdf->setXY(19.7,13.25);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,13.15);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ไม่ควบคุมอุณหภูมิ"),0 ,'L' );

$pdf->setXY(19.7,13.55);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,13.45);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Chilled 2-8 C"),0 ,'L' );

$pdf->setXY(19.7,13.85);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,13.75);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Frozen -15 C"),0 ,'L' );





$pdf->setXY(21.6,13.05);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//3
$pdf->setXY(21.7,13.25);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,13.15);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ด่วน 1 วัน"),0 ,'L' );

$pdf->setXY(21.7,13.55);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,13.45);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ธรรมดา 2-3 วัน"),0 ,'L' );

/*$pdf->setXY(21.7,13.85);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,13.75);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ภายในวัน"),0 ,'L' );*/



$pdf->setXY(23.6,13.05);
$pdf->Cell(1.2,1.2, "",1,1,"c" );

$pdf->setXY(24.8,13.05);
$pdf->Cell(1.2,1.2, "",1,1,"c" );



$pdf->setXY(26.0,13.05);
$pdf->Cell(1.2,1.2, "",1,1,"c" );


$pdf->setXY(27.2,13.05);
$pdf->Cell(2.1,1.2, "",1,1,"c" );


$pdf->setXY(27.2,13.05);
$pdf->Cell(2.1,1.2, "",1,1,"c" );
	
	
//แถว 8
$pdf->setXY(0.3,14.25);
$pdf->Cell(0.8,1.2, "",1,1,"c" );	

$pdf->setXY(1.1,14.25);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->setXY(2.6,14.25);
$pdf->Cell(2.5,1.2, "",1,1,"c" );


$pdf->setXY(5.1,14.25);
$pdf->Cell(6.0,1.2, "",1,1,"c" );

$pdf->setXY(11.1,14.25);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(12.6,14.25);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(14.1,14.25);
$pdf->Cell(2.0,1.2, "",1,1,"c" );


$pdf->setXY(16.1,14.25);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',9);
$pdf->setXY(16.1,14.25);
$pdf->MultiCell(1.5,1.2, iconv( 'UTF-8','cp874' , "เครื่องมือแพทย์"),0 ,'C' );


$pdf->setXY(17.6,14.25);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',7);
//1
$pdf->setXY(17.7,14.45);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,14.35);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการสินค้าทั่วไป"),0 ,'L' );

$pdf->setXY(17.7,14.75);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,14.65);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งกล่องโฟม"),0 ,'L' );

$pdf->setXY(17.7,15.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,14.95);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งผัก-ผลไม้"),0 ,'L' );






$pdf->setXY(19.6,14.25);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//2
$pdf->setXY(19.7,14.45);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,14.35);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ไม่ควบคุมอุณหภูมิ"),0 ,'L' );

$pdf->setXY(19.7,14.75);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,14.65);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Chilled 2-8 C"),0 ,'L' );

$pdf->setXY(19.7,15.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,14.95);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Frozen -15 C"),0 ,'L' );





$pdf->setXY(21.6,14.25);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//3
$pdf->setXY(21.7,14.45);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,14.35);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ด่วน 1 วัน"),0 ,'L' );

$pdf->setXY(21.7,14.75);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,14.65);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ธรรมดา 2-3 วัน"),0 ,'L' );

/*$pdf->setXY(21.7,15.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,14.95);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ภายในวัน"),0 ,'L' );*/



$pdf->setXY(23.6,14.25);
$pdf->Cell(1.2,1.2, "",1,1,"c" );

$pdf->setXY(24.8,14.25);
$pdf->Cell(1.2,1.2, "",1,1,"c" );



$pdf->setXY(26.0,14.25);
$pdf->Cell(1.2,1.2, "",1,1,"c" );


$pdf->setXY(27.2,14.25);
$pdf->Cell(2.1,1.2, "",1,1,"c" );


$pdf->setXY(27.2,14.25);
$pdf->Cell(2.1,1.2, "",1,1,"c" );
	

	
	
	
$pdf->SetFillColor(204,204,204);

$pdf->Cell(23.25,0.4,iconv('UTF-8','cp874','รวม'),1,0,"R",true);
$pdf->Cell(1.2,0.4,iconv('UTF-8','cp874',''),1,0,"R",true);
$pdf->Cell(1.2,0.4,iconv('UTF-8','cp874',''),1,0,"R",true);
$pdf->Cell(1.2,0.4,iconv('UTF-8','cp874',''),1,0,"R",true);
$pdf->Cell(2.1,0.4,iconv('UTF-8','cp874',''),1,0,"R",true);
		
//$pdf->setXY(0.3,11.85);
//$pdf->Cell(29,1.6, "",1,1,"c" );

$pdf->setXY(1.0,15.8);
$pdf->MultiCell(29,0.4, iconv( 'UTF-8','cp874' , "หมายเหตุ"),0 ,'L' );


$pdf->setXY(1.0,16.2);
$pdf->MultiCell(14,0.4, iconv( 'UTF-8','cp874' , "1. ประเภทสินค้าหากเป็นยาเย็นระบุ (ยาเย็น) / ยาธรรมดาระบุ (ยา)"),0 ,'L' );

$pdf->setXY(1.0,16.6);
$pdf->MultiCell(14,0.4, iconv( 'UTF-8','cp874' , "2.  ช่องประเภทสินค้า ระบุสินค้าที่บรรจุในกล่อง(เนื้อแช่แข็ง, ปลาแช่แข็ง, เนยแช่แข็ง, ผลไม้หรือสินค้าประเภทอื่น ๆ ฯลฯ)"),0 ,'L' );

$pdf->setXY(1.0,17.0);
$pdf->MultiCell(14,0.4, iconv( 'UTF-8','cp874' , "3. สินค้าประเภทผัก-ผลไม้ หากใช้บริการขนส่งผัก-ผลไม้ จะต้องเป็นลูกหรือเป็นผลเปลือกแข็งเท่านั้น"),0 ,'L' );


$pdf->setXY(15.0,16.2);
$pdf->MultiCell(14,0.4, iconv( 'UTF-8','cp874' , "4.  ช่องระบุขนาดกล่อง ระบุขนาดกล่องดังนี้ S1, S2,  A1, A2, B1, B2 / บริการขนส่งผัก-ผลไม้ ไม่ต้องระบุขนาดกล่อง แต่ต้องระบุน้ำหนัก (กิโลกรัม) ต่อกล่อง"),0 ,'L' );

$pdf->setXY(15.0,16.6);
$pdf->MultiCell(14,0.4, iconv( 'UTF-8','cp874' , "5. กรณีที่ผู้รับปลายทางไม่มีเบอร์โทรติดต่อให้ใช้เบอร์โทรติดต่อของผู้ส่งสินค้าแทน"),0 ,'L' );

$pdf->setXY(15.0,17.0);
$pdf->MultiCell(14,0.4, iconv( 'UTF-8','cp874' , "6. หากไม่ทราบวิธีคิดขนาดกล่อง ระบุน้ำหนักต่อกล่องในช่องน้ำหนักและปริมาตร กว้าง X ยาว X สูง (เซนติเมตร) ในช่องหมายเหตุ"),0 ,'L' );
	
$pdf->Cell(28.9,0.4,iconv('UTF-8','cp874',''),0,0,"C",true);
	
	
$pdf->SetFont('angsa','',8);	
$pdf->setXY(11,18.0);
$pdf->Cell(8,2.2, "",1,1,"c" );	
	
$pdf->setXY(11,18.1);
$pdf->MultiCell(8,0.3, iconv( 'UTF-8','cp874' , "ใบรายงานการส่งสินค้าหน้านี้เป็นใบรายงานการส่งสินค้าหน้าถัดมาที่ผู้ส่งสินค้า"),0 ,'C' );
	
$pdf->setXY(11,18.4);
$pdf->MultiCell(8,0.3, iconv( 'UTF-8','cp874' , "จะแนบไปกับใบรายงานการส่งสินค้าหน้าแรกด้วยทุกครั้ง(ถ้ามีการส่งหลายปลายทาง)และครอบคลุม"),0 ,'C' );
	
$pdf->setXY(11,18.7);
$pdf->MultiCell(8,0.3, iconv( 'UTF-8','cp874' , "คำรับรองของผู้ส่งสินค้าเช่นเดียวกันกับหน้าแรกทุกประการ"),0 ,'C' );

$pdf->setXY(11,19.0);
$pdf->MultiCell(8,0.3, iconv( 'UTF-8','cp874' , "(ลงชื่อผู้ส่งสินค้าทุกใบรายงานการส่งสินค้าหน้าถัดมา)"),0 ,'C' );
	
	
$pdf->setXY(11,19.8);
$pdf->MultiCell(8,0.3, iconv( 'UTF-8','cp874' , "ลงชื่อ  .................................................................  ผู้ส่งสินค้า วันที่ ............... / ................ / ..............."),0 ,'C' );
	
	
$pdf->Image("img/qrcode_inter.png",27.7,18.5,1.5,1.5);

$pdf->SetFont('angsa','',7);
$pdf->setXY(26.5,20.2);
$pdf->MultiCell(29,0, iconv( 'UTF-8','cp874' , "FM-RC-01, แก้ไขครั้งที่ 10.01-02-2026"),0 ,'L' );
	
	
}	


//หน้าที่ 6

$strSQL = "SELECT ref_id,customer_name,address_name,customer_tel FROM tb_register_data  WHERE start_date >= '".$start_date."' and start_date <= '".$end_date."' and type_company='".$company."' and bus_inter='1' LIMIT 10 OFFSET 45";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$Num_Rows = mysqli_num_rows($objQuery);

if($Num_Rows > 0){
//$pdf->AddPage();

$pdf->SetFont('angsa','',14);

$pdf->setXY(0.3,0.3);
$pdf->Cell(29.0,20.3, "",1,1,"c" );

$pdf->Image("img/inter_express.png",0.3,0.35,2.5,1.0);

$pdf->setXY(0.3,0.35);
$pdf->Cell(25.0,2.2, "",1,1,"c" );

//$pdf->SetFont('angsana','B',20);

$pdf->setXY(0.3,0.4);
$pdf->MultiCell(25, 0.6 , iconv( 'UTF-8','cp874' , "ใบรายงานการส่งสินค้า Delivery Manifest"),0 ,'C' );

$pdf->setXY(0.3,0.9);
$pdf->MultiCell(25, 0.6 , iconv( 'UTF-8','cp874' , "สำหรับบริการสินค้าทั่วไป (Ambient) บริการขนส่งกล่องโฟม (INTER FOAM) บริการขนส่งผัก-ผลไม้ (FRUIT DELIVERY) "),0 ,'C' );

$pdf->SetFont('angsa','',11);

$pdf->setXY(0.3,1.5);
$pdf->MultiCell(25, 0.6 , iconv( 'UTF-8','cp874' , "หน้าแรก แผ่นที่ 1 /……"),0 ,'L' );

$pdf->setXY(0.3,2.0);
$pdf->MultiCell(25, 0.6 , iconv( 'UTF-8','cp874' , "วันที่ …$start_date_th....."),0 ,'L' );


$pdf->SetFont('angsa','',12);

if($_GET["company"]=='3'){
$pdf->setXY(0.3,1.5);
$pdf->MultiCell(25, 0.5 , iconv( 'UTF-8','cp874' , "ผู้ส่งสินค้า/บริษัท…....................บริษัท ออลล์เวล ไลฟ์ จำกัด.........................….รหัสลูกค้า……...................…...................…....................….........."),0 ,'C' );

$pdf->setXY(0.3,2.0);
$pdf->MultiCell(25, 0.5 , iconv( 'UTF-8','cp874' , "ที่อยู่ผู้ส่ง...................73,75 ซ.จรัญสนิทวงศ์89/2 แขวงบางอ้อ เขตบางพลัด กรุงเทพมหานคร 10700....................เบอร์ผู้ส่งสินค้า ........02-424-3555....................."),0 ,'C' );

}
if($_GET["company"]=='4'){
	
$pdf->setXY(0.3,1.5);
$pdf->MultiCell(25, 0.5 , iconv( 'UTF-8','cp874' , "ผู้ส่งสินค้า/บริษัท…....................บริษัท โนเบิล เมด จำกัด........................….รหัสลูกค้า……...................…...................…....................….........."),0 ,'C' );

$pdf->setXY(0.3,2.0);
$pdf->MultiCell(25, 0.5 , iconv( 'UTF-8','cp874' , "ที่อยู่ผู้ส่ง....................73 ซ.จรัญสนิทวงศ์89/2 แขวงบางอ้อ เขตบางพลัด กรุงเทพมหานคร 10700........................เบอร์ผู้ส่งสินค้า ........02-880-5566.........................."),0 ,'C' );
	
}
	
$pdf->setXY(25.3,0.35);
$pdf->Cell(4.0,2.2, "",1,1,"c" );	

$pdf->SetFont('angsa','',14);
	
$pdf->setXY(25.3,0.8);
$pdf->MultiCell(4.0, 0.5 , iconv( 'UTF-8','cp874' , "สำหรับติดสติ๊กเกอร์"),0 ,'C' );

$pdf->setXY(25.3,1.5);
$pdf->MultiCell(4.0, 0.5 , iconv( 'UTF-8','cp874' , "M/F Number"),0 ,'C' );

$pdf->SetFont('angsa','',10);

$pdf->setXY(0.3,2.55);
$pdf->Cell(0.8,0.9, "",1,1,"c" );	

$pdf->setXY(0.3,2.55);
$pdf->MultiCell(0.8,0.9, iconv( 'UTF-8','cp874' , "ลำดับ"),0 ,'C' );

$pdf->setXY(1.1,2.55);
$pdf->Cell(1.5,0.9, "",1,1,"c" );

$pdf->setXY(1.1,2.55);
$pdf->MultiCell(1.5,0.9, iconv( 'UTF-8','cp874' , "เลขที่บิล"),0 ,'C' );

$pdf->setXY(2.6,2.55);
$pdf->Cell(2.5,0.9, "",1,1,"c" );

$pdf->setXY(2.6,2.55);
$pdf->MultiCell(2.5,0.9, iconv( 'UTF-8','cp874' , "ชื่อผู้รับสินค้า"),0 ,'C' );


$pdf->setXY(5.1,2.55);
$pdf->Cell(6.0,0.9, "",1,1,"c" );

$pdf->setXY(5.1,2.6);
$pdf->MultiCell(6.0,0.45, iconv( 'UTF-8','cp874' , "ที่อยู่ผู้รับสินค้า"),0 ,'C' );
$pdf->setXY(5.1,3.05);
$pdf->MultiCell(6.0,0.4, iconv( 'UTF-8','cp874' , "(ระบุบ้านเลขที่ หมู่ที่ หมู่บ้าน ถนน ตำบล/แขวง)"),0 ,'C' );


$pdf->setXY(11.1,2.55);
$pdf->Cell(1.5,0.9, "",1,1,"c" );

$pdf->setXY(11.1,2.55);
$pdf->MultiCell(1.5,0.9, iconv( 'UTF-8','cp874' , "อำเภอ/เขต"),0 ,'C' );

$pdf->setXY(12.6,2.55);
$pdf->Cell(1.5,0.9, "",1,1,"c" );

$pdf->setXY(12.6,2.55);
$pdf->MultiCell(1.5,0.9, iconv( 'UTF-8','cp874' , "จังหวัด"),0 ,'C' );


$pdf->setXY(14.1,2.55);
$pdf->Cell(2.0,0.9, "",1,1,"c" );

$pdf->setXY(14.1,2.55);
$pdf->MultiCell(2.0,0.9, iconv( 'UTF-8','cp874' , "เบอร์ผู้รับสินค้า"),0 ,'C' );

$pdf->setXY(16.1,2.55);
$pdf->Cell(1.5,0.9, "",1,1,"c" );

$pdf->setXY(16.1,2.55);
$pdf->MultiCell(1.5,0.9, iconv( 'UTF-8','cp874' , "ประเภทสินค้า"),0 ,'C' );


$pdf->setXY(17.6,2.55);
$pdf->Cell(2.0,0.9, "",1,1,"c" );

$pdf->setXY(17.6,2.55);
$pdf->MultiCell(2.0,0.9, iconv( 'UTF-8','cp874' , "ประเภทบริการ"),0 ,'C' );

$pdf->setXY(19.6,2.55);
$pdf->Cell(2.0,0.9, "",1,1,"c" );

$pdf->setXY(19.6,2.55);
$pdf->MultiCell(2.0,0.9, iconv( 'UTF-8','cp874' , "ประเภทอุณหภูมิ"),0 ,'C' );

$pdf->setXY(21.6,2.55);
$pdf->Cell(2.0,0.9, "",1,1,"c" );

$pdf->setXY(21.6,2.55);
$pdf->MultiCell(2.0,0.9, iconv( 'UTF-8','cp874' , "บริการจัดส่ง (SLA)"),0 ,'C' );

$pdf->setXY(23.6,2.55);
$pdf->Cell(1.2,0.9, "",1,1,"c" );

$pdf->setXY(23.6,2.55);
$pdf->MultiCell(1.2,0.45, iconv( 'UTF-8','cp874' , "ระบุขนาด"),0 ,'C' );

$pdf->setXY(23.6,2.95);
$pdf->MultiCell(1.2,0.4, iconv( 'UTF-8','cp874' , "กล่อง"),0 ,'C' );


$pdf->setXY(24.8,2.55);
$pdf->Cell(1.2,0.9, "",1,1,"c" );

$pdf->setXY(24.8,2.55);
$pdf->MultiCell(1.2,0.45, iconv( 'UTF-8','cp874' , "น้ำหนัก/"),0 ,'C' );

$pdf->setXY(24.8,2.95);
$pdf->MultiCell(1.2,0.4, iconv( 'UTF-8','cp874' , "กล่อง"),0 ,'C' );

$pdf->setXY(26.0,2.55);
$pdf->Cell(1.2,0.9, "",1,1,"c" );

$pdf->setXY(26.0,2.55);
$pdf->MultiCell(1.2,0.45, iconv( 'UTF-8','cp874' , "จำนวน"),0 ,'C' );

$pdf->setXY(26.0,2.95);
$pdf->MultiCell(1.2,0.4, iconv( 'UTF-8','cp874' , "กล่อง"),0 ,'C' );


$pdf->setXY(27.2,2.55);
$pdf->Cell(2.1,0.9, "",1,1,"c" );

$pdf->setXY(27.2,2.55);
$pdf->MultiCell(2.1,0.9, iconv( 'UTF-8','cp874' , "หมายเหตุ"),0 ,'C' );
	
	
$j=46;
while($objResult = mysqli_fetch_array($objQuery))
{	
	
$ref_id = substr($objResult["ref_id"],0,2);	
	
if($ref_id=='SO'){	
$strSQL15 = "SELECT iv_no FROM hos__so WHERE ref_id = '".$objResult["ref_id"]."' ";
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResult15= mysqli_fetch_array($objQuery15);
	
$iv_no =$objResult15["iv_no"];	
$customer_name = $objResult["customer_name"];
$address_name = $objResult["address_name"];	
$customer_tel = $objResult["customer_tel"];	
	
}else if($ref_id=='BR'){
	
$strSQL15 = "SELECT iv_no FROM hos__br WHERE ref_id_br = '".$objResult["ref_id"]."' ";
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResult15= mysqli_fetch_array($objQuery15);
	
$iv_no =$objResult15["iv_no"];	
$customer_name = $objResult["customer_name"];
$address_name = $objResult["address_name"];	
$customer_tel = $objResult["customer_tel"];	

}else if($ref_id=='CH'){
	
$strSQL15 = "SELECT iv_no FROM hos__change WHERE ref_id = '".$objResult["ref_id"]."' ";
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResult15= mysqli_fetch_array($objQuery15);
	
$iv_no =$objResult15["iv_no"];	
$customer_name = $objResult["customer_name"];
$address_name = $objResult["address_name"];	
$customer_tel = $objResult["customer_tel"];	

}else if($ref_id=='BS'){
	
$strSQL15 = "SELECT iv_no FROM hos__consig WHERE ref_id = '".$objResult["ref_id"]."' ";
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResult15= mysqli_fetch_array($objQuery15);
	
$iv_no =$objResult15["iv_no"];	
$customer_name = $objResult["customer_name"];
$address_name = $objResult["address_name"];	
$customer_tel = $objResult["customer_tel"];	
		
}else{
	
$strSQL15 = "SELECT doc_no,customer_name,address1,address2,province,postcode,tel FROM so__main WHERE ref_id = '".$objResult["ref_id"]."' ";
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResult15= mysqli_fetch_array($objQuery15);
	
$iv_no =$objResult15["doc_no"];	
$customer_name = $objResult15["customer_name"];
$address1 = $objResult15["address1"];	
$address2 = $objResult15["address2"];	
$province = $objResult15["province"];	
$postcode = $objResult15["postcode"];		
$address_name = "$address1 $address2 $province $postcode";	
$customer_tel = $objResult15["tel"];	
	
}
	
$pdf->setX(0.3);
$pdf->Cell(0.8,1.2, iconv('UTF-8','cp874', "$j"),1,0,'C');
$pdf->Cell(1.5,1.2, iconv('UTF-8','cp874', "$iv_no"),1,0,'C');
$pdf->Cell(2.5,1.2, iconv('UTF-8','cp874', "$customer_name"),1,0,'L');
$pdf->Cell(6.0,1.2, '',1,0,'L');
$addressY = $pdf->GetY();
$addressX = $pdf->GetX();
$pdf->SetXY($addressX - 6.0, $addressY);
$pdf->MultiCell(6.0,0.4, iconv('UTF-8//IGNORE','cp874//IGNORE', "$address_name"),0,'L');
$pdf->SetXY($addressX, $addressY);
$pdf->Cell(1.5,1.2, iconv('UTF-8','cp874', ""),1,0,'C');
$pdf->Cell(1.5,1.2, iconv('UTF-8','cp874', ""),1,0,'C');	
$pdf->Cell(2.0,1.2, iconv('UTF-8','cp874', "$customer_tel"),1,1,'L');
	

$j++;


}
	
//แถว 1
$pdf->setXY(0.3,3.45);
$pdf->Cell(0.8,1.2, "",1,1,"c" );	

$pdf->setXY(1.1,3.45);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->setXY(2.6,3.45);
$pdf->Cell(2.5,1.2, "",1,1,"c" );


$pdf->setXY(5.1,3.45);
$pdf->Cell(6.0,1.2, "",1,1,"c" );

$pdf->setXY(11.1,3.45);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(12.6,3.45);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(14.1,3.45);
$pdf->Cell(2.0,1.2, "",1,1,"c" );


$pdf->setXY(16.1,3.45);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',9);
$pdf->setXY(16.1,3.45);
$pdf->MultiCell(1.5,1.2, iconv( 'UTF-8','cp874' , "เครื่องมือแพทย์"),0 ,'C' );


$pdf->setXY(17.6,3.45);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',7);
//1
$pdf->setXY(17.7,3.65);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,3.55);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการสินค้าทั่วไป"),0 ,'L' );

$pdf->setXY(17.7,3.95);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,3.85);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งกล่องโฟม"),0 ,'L' );

$pdf->setXY(17.7,4.25);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,4.2);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งผัก-ผลไม้"),0 ,'L' );






$pdf->setXY(19.6,3.45);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//2
$pdf->setXY(19.7,3.65);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,3.55);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ไม่ควบคุมอุณหภูมิ"),0 ,'L' );

$pdf->setXY(19.7,3.95);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,3.85);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Chilled 2-8 C"),0 ,'L' );

$pdf->setXY(19.7,4.25);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,4.2);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Frozen -15 C"),0 ,'L' );





$pdf->setXY(21.6,3.45);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//3
$pdf->setXY(21.7,3.65);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,3.55);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ด่วน 1 วัน"),0 ,'L' );

$pdf->setXY(21.7,3.95);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,3.85);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ธรรมดา 2-3 วัน"),0 ,'L' );

/*$pdf->setXY(21.7,4.25);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,4.2);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ภายในวัน"),0 ,'L' );*/



$pdf->setXY(23.6,3.45);
$pdf->Cell(1.2,1.2, "",1,1,"c" );

$pdf->setXY(24.8,3.45);
$pdf->Cell(1.2,1.2, "",1,1,"c" );



$pdf->setXY(26.0,3.45);
$pdf->Cell(1.2,1.2, "",1,1,"c" );


$pdf->setXY(27.2,3.45);
$pdf->Cell(2.1,1.2, "",1,1,"c" );





//แถว 2
$pdf->setXY(0.3,4.65);
$pdf->Cell(0.8,1.2, "",1,1,"c" );	

$pdf->setXY(1.1,4.65);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->setXY(2.6,4.65);
$pdf->Cell(2.5,1.2, "",1,1,"c" );


$pdf->setXY(5.1,4.65);
$pdf->Cell(6.0,1.2, "",1,1,"c" );

$pdf->setXY(11.1,4.65);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(12.6,4.65);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(14.1,4.65);
$pdf->Cell(2.0,1.2, "",1,1,"c" );


$pdf->setXY(16.1,4.65);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',9);
$pdf->setXY(16.1,4.65);
$pdf->MultiCell(1.5,1.2, iconv( 'UTF-8','cp874' , "เครื่องมือแพทย์"),0 ,'C' );


$pdf->setXY(17.6,4.65);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',7);
//1
$pdf->setXY(17.7,4.85);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,4.75);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการสินค้าทั่วไป"),0 ,'L' );

$pdf->setXY(17.7,5.15);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,5.05);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งกล่องโฟม"),0 ,'L' );

$pdf->setXY(17.7,5.45);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,5.4);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งผัก-ผลไม้"),0 ,'L' );






$pdf->setXY(19.6,4.65);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//2
$pdf->setXY(19.7,4.85);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,4.75);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ไม่ควบคุมอุณหภูมิ"),0 ,'L' );

$pdf->setXY(19.7,5.15);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,5.05);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Chilled 2-8 C"),0 ,'L' );

$pdf->setXY(19.7,5.45);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,5.4);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Frozen -15 C"),0 ,'L' );





$pdf->setXY(21.6,4.65);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//3
$pdf->setXY(21.7,4.85);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,4.75);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ด่วน 1 วัน"),0 ,'L' );

$pdf->setXY(21.7,5.15);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,5.05);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ธรรมดา 2-3 วัน"),0 ,'L' );

/*$pdf->setXY(21.7,5.45);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,5.4);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ภายในวัน"),0 ,'L' );*/



$pdf->setXY(23.6,4.65);
$pdf->Cell(1.2,1.2, "",1,1,"c" );

$pdf->setXY(24.8,4.65);
$pdf->Cell(1.2,1.2, "",1,1,"c" );



$pdf->setXY(26.0,4.65);
$pdf->Cell(1.2,1.2, "",1,1,"c" );


$pdf->setXY(27.2,4.65);
$pdf->Cell(2.1,1.2, "",1,1,"c" );





//แถว 3
$pdf->setXY(0.3,5.85);
$pdf->Cell(0.8,1.2, "",1,1,"c" );	

$pdf->setXY(1.1,5.85);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->setXY(2.6,5.85);
$pdf->Cell(2.5,1.2, "",1,1,"c" );


$pdf->setXY(5.1,5.85);
$pdf->Cell(6.0,1.2, "",1,1,"c" );

$pdf->setXY(11.1,5.85);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(12.6,5.85);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(14.1,5.85);
$pdf->Cell(2.0,1.2, "",1,1,"c" );


$pdf->setXY(16.1,5.85);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',9);
$pdf->setXY(16.1,5.85);
$pdf->MultiCell(1.5,1.2, iconv( 'UTF-8','cp874' , "เครื่องมือแพทย์"),0 ,'C' );


$pdf->setXY(17.6,5.85);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',7);
//1
$pdf->setXY(17.7,6.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,5.95);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการสินค้าทั่วไป"),0 ,'L' );

$pdf->setXY(17.7,6.35);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,6.25);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งกล่องโฟม"),0 ,'L' );

$pdf->setXY(17.7,6.65);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,6.6);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งผัก-ผลไม้"),0 ,'L' );






$pdf->setXY(19.6,5.85);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//2
$pdf->setXY(19.7,6.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,5.95);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ไม่ควบคุมอุณหภูมิ"),0 ,'L' );

$pdf->setXY(19.7,6.35);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,6.25);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Chilled 2-8 C"),0 ,'L' );

$pdf->setXY(19.7,6.65);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,6.6);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Frozen -15 C"),0 ,'L' );





$pdf->setXY(21.6,5.85);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//3
$pdf->setXY(21.7,6.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,5.95);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ด่วน 1 วัน"),0 ,'L' );

$pdf->setXY(21.7,6.35);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,6.25);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ธรรมดา 2-3 วัน"),0 ,'L' );

/*$pdf->setXY(21.7,6.65);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,6.6);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ภายในวัน"),0 ,'L' );*/



$pdf->setXY(23.6,5.85);
$pdf->Cell(1.2,1.2, "",1,1,"c" );

$pdf->setXY(24.8,5.85);
$pdf->Cell(1.2,1.2, "",1,1,"c" );



$pdf->setXY(26.0,5.85);
$pdf->Cell(1.2,1.2, "",1,1,"c" );


$pdf->setXY(27.2,5.85);
$pdf->Cell(2.1,1.2, "",1,1,"c" );



//แถว 4
$pdf->setXY(0.3,7.05);
$pdf->Cell(0.8,1.2, "",1,1,"c" );	

$pdf->setXY(1.1,7.05);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->setXY(2.6,7.05);
$pdf->Cell(2.5,1.2, "",1,1,"c" );


$pdf->setXY(5.1,7.05);
$pdf->Cell(6.0,1.2, "",1,1,"c" );

$pdf->setXY(11.1,7.05);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(12.6,7.05);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(14.1,7.05);
$pdf->Cell(2.0,1.2, "",1,1,"c" );


$pdf->setXY(16.1,7.05);
$pdf->Cell(1.5,1.2, "",1,1,"c" );
$pdf->SetFont('angsa','',9);
$pdf->setXY(16.1,7.05);
$pdf->MultiCell(1.5,1.2, iconv( 'UTF-8','cp874' , "เครื่องมือแพทย์"),0 ,'C' );



$pdf->setXY(17.6,7.05);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',7);
//1
$pdf->setXY(17.7,7.25);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,7.15);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการสินค้าทั่วไป"),0 ,'L' );

$pdf->setXY(17.7,7.55);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,7.45);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งกล่องโฟม"),0 ,'L' );

$pdf->setXY(17.7,7.85);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,7.8);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งผัก-ผลไม้"),0 ,'L' );






$pdf->setXY(19.6,7.05);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//2
$pdf->setXY(19.7,7.25);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,7.15);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ไม่ควบคุมอุณหภูมิ"),0 ,'L' );

$pdf->setXY(19.7,7.55);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,7.45);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Chilled 2-8 C"),0 ,'L' );

$pdf->setXY(19.7,7.85);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,7.8);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Frozen -15 C"),0 ,'L' );





$pdf->setXY(21.6,7.05);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//3
$pdf->setXY(21.7,7.25);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,7.15);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ด่วน 1 วัน"),0 ,'L' );

$pdf->setXY(21.7,7.55);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,7.45);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ธรรมดา 2-3 วัน"),0 ,'L' );

/*$pdf->setXY(21.7,7.85);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,7.8);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ภายในวัน"),0 ,'L' );*/



$pdf->setXY(23.6,7.05);
$pdf->Cell(1.2,1.2, "",1,1,"c" );

$pdf->setXY(24.8,7.05);
$pdf->Cell(1.2,1.2, "",1,1,"c" );



$pdf->setXY(26.0,7.05);
$pdf->Cell(1.2,1.2, "",1,1,"c" );


$pdf->setXY(27.2,7.05);
$pdf->Cell(2.1,1.2, "",1,1,"c" );



//แถว 5
$pdf->setXY(0.3,8.25);
$pdf->Cell(0.8,1.2, "",1,1,"c" );	

$pdf->setXY(1.1,8.25);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->setXY(2.6,8.25);
$pdf->Cell(2.5,1.2, "",1,1,"c" );


$pdf->setXY(5.1,8.25);
$pdf->Cell(6.0,1.2, "",1,1,"c" );

$pdf->setXY(11.1,8.25);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(12.6,8.25);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(14.1,8.25);
$pdf->Cell(2.0,1.2, "",1,1,"c" );


$pdf->setXY(16.1,8.25);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',9);
$pdf->setXY(16.1,8.25);
$pdf->MultiCell(1.5,1.2, iconv( 'UTF-8','cp874' , "เครื่องมือแพทย์"),0 ,'C' );


$pdf->setXY(17.6,8.25);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',7);
//1
$pdf->setXY(17.7,8.45);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,8.35);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการสินค้าทั่วไป"),0 ,'L' );

$pdf->setXY(17.7,8.75);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,8.65);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งกล่องโฟม"),0 ,'L' );

$pdf->setXY(17.7,9.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,9.0);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งผัก-ผลไม้"),0 ,'L' );






$pdf->setXY(19.6,8.25);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//2
$pdf->setXY(19.7,8.45);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,8.35);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ไม่ควบคุมอุณหภูมิ"),0 ,'L' );

$pdf->setXY(19.7,8.75);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,8.65);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Chilled 2-8 C"),0 ,'L' );

$pdf->setXY(19.7,9.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,9.0);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Frozen -15 C"),0 ,'L' );





$pdf->setXY(21.6,8.25);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//3
$pdf->setXY(21.7,8.45);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,8.35);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ด่วน 1 วัน"),0 ,'L' );

$pdf->setXY(21.7,8.75);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,8.65);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ธรรมดา 2-3 วัน"),0 ,'L' );

/*$pdf->setXY(21.7,9.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,9.0);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ภายในวัน"),0 ,'L' );*/



$pdf->setXY(23.6,8.25);
$pdf->Cell(1.2,1.2, "",1,1,"c" );

$pdf->setXY(24.8,8.25);
$pdf->Cell(1.2,1.2, "",1,1,"c" );



$pdf->setXY(26.0,8.25);
$pdf->Cell(1.2,1.2, "",1,1,"c" );


$pdf->setXY(27.2,8.25);
$pdf->Cell(2.1,1.2, "",1,1,"c" );


$pdf->setXY(27.2,8.25);
$pdf->Cell(2.1,1.2, "",1,1,"c" );
	
	
//แถว 6
$pdf->setXY(0.3,9.45);
$pdf->Cell(0.8,1.2, "",1,1,"c" );	

$pdf->setXY(1.1,9.45);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->setXY(2.6,9.45);
$pdf->Cell(2.5,1.2, "",1,1,"c" );


$pdf->setXY(5.1,9.45);
$pdf->Cell(6.0,1.2, "",1,1,"c" );

$pdf->setXY(11.1,9.45);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(12.6,9.45);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(14.1,9.45);
$pdf->Cell(2.0,1.2, "",1,1,"c" );


$pdf->setXY(16.1,9.45);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',9);
$pdf->setXY(16.1,9.45);
$pdf->MultiCell(1.5,1.2, iconv( 'UTF-8','cp874' , "เครื่องมือแพทย์"),0 ,'C' );


$pdf->setXY(17.6,9.45);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',7);
//1
$pdf->setXY(17.7,9.65);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,9.55);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการสินค้าทั่วไป"),0 ,'L' );

$pdf->setXY(17.7,9.95);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,9.85);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งกล่องโฟม"),0 ,'L' );

$pdf->setXY(17.7,10.25);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,10.15);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งผัก-ผลไม้"),0 ,'L' );






$pdf->setXY(19.6,9.45);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//2
$pdf->setXY(19.7,9.65);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,9.55);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ไม่ควบคุมอุณหภูมิ"),0 ,'L' );

$pdf->setXY(19.7,9.95);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,9.85);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Chilled 2-8 C"),0 ,'L' );

$pdf->setXY(19.7,10.25);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,10.15);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Frozen -15 C"),0 ,'L' );





$pdf->setXY(21.6,9.45);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//3
$pdf->setXY(21.7,9.65);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,9.55);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ด่วน 1 วัน"),0 ,'L' );

$pdf->setXY(21.7,9.95);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,9.85);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ธรรมดา 2-3 วัน"),0 ,'L' );

/*$pdf->setXY(21.7,10.25);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,10.15);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ภายในวัน"),0 ,'L' );*/



$pdf->setXY(23.6,9.45);
$pdf->Cell(1.2,1.2, "",1,1,"c" );

$pdf->setXY(24.8,9.45);
$pdf->Cell(1.2,1.2, "",1,1,"c" );



$pdf->setXY(26.0,9.45);
$pdf->Cell(1.2,1.2, "",1,1,"c" );


$pdf->setXY(27.2,9.45);
$pdf->Cell(2.1,1.2, "",1,1,"c" );


$pdf->setXY(27.2,9.45);
$pdf->Cell(2.1,1.2, "",1,1,"c" );
	
//แถว 7
$pdf->setXY(0.3,10.65);
$pdf->Cell(0.8,1.2, "",1,1,"c" );	

$pdf->setXY(1.1,10.65);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->setXY(2.6,10.65);
$pdf->Cell(2.5,1.2, "",1,1,"c" );


$pdf->setXY(5.1,10.65);
$pdf->Cell(6.0,1.2, "",1,1,"c" );

$pdf->setXY(11.1,10.65);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(12.6,10.65);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(14.1,10.65);
$pdf->Cell(2.0,1.2, "",1,1,"c" );


$pdf->setXY(16.1,10.65);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',9);
$pdf->setXY(16.1,10.65);
$pdf->MultiCell(1.5,1.2, iconv( 'UTF-8','cp874' , "เครื่องมือแพทย์"),0 ,'C' );


$pdf->setXY(17.6,10.65);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',7);
//1
$pdf->setXY(17.7,10.85);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,10.75);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการสินค้าทั่วไป"),0 ,'L' );

$pdf->setXY(17.7,11.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,10.95);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งกล่องโฟม"),0 ,'L' );

$pdf->setXY(17.7,11.35);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,11.25);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งผัก-ผลไม้"),0 ,'L' );






$pdf->setXY(19.6,10.65);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//2
$pdf->setXY(19.7,10.85);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,10.75);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ไม่ควบคุมอุณหภูมิ"),0 ,'L' );

$pdf->setXY(19.7,11.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,10.95);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Chilled 2-8 C"),0 ,'L' );

$pdf->setXY(19.7,11.35);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,11.25);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Frozen -15 C"),0 ,'L' );





$pdf->setXY(21.6,10.65);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//3
$pdf->setXY(21.7,10.85);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,10.75);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ด่วน 1 วัน"),0 ,'L' );

$pdf->setXY(21.7,11.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,10.95);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ธรรมดา 2-3 วัน"),0 ,'L' );

/*$pdf->setXY(21.7,11.35);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,11.25);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ภายในวัน"),0 ,'L' );*/



$pdf->setXY(23.6,10.65);
$pdf->Cell(1.2,1.2, "",1,1,"c" );

$pdf->setXY(24.8,10.65);
$pdf->Cell(1.2,1.2, "",1,1,"c" );



$pdf->setXY(26.0,10.65);
$pdf->Cell(1.2,1.2, "",1,1,"c" );


$pdf->setXY(27.2,10.65);
$pdf->Cell(2.1,1.2, "",1,1,"c" );


$pdf->setXY(27.2,10.65);
$pdf->Cell(2.1,1.2, "",1,1,"c" );
	
	
//แถว 8
$pdf->setXY(0.3,11.85);
$pdf->Cell(0.8,1.2, "",1,1,"c" );	

$pdf->setXY(1.1,11.85);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->setXY(2.6,11.85);
$pdf->Cell(2.5,1.2, "",1,1,"c" );


$pdf->setXY(5.1,11.85);
$pdf->Cell(6.0,1.2, "",1,1,"c" );

$pdf->setXY(11.1,11.85);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(12.6,11.85);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(14.1,11.85);
$pdf->Cell(2.0,1.2, "",1,1,"c" );


$pdf->setXY(16.1,11.85);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',9);
$pdf->setXY(16.1,11.85);
$pdf->MultiCell(1.5,1.2, iconv( 'UTF-8','cp874' , "เครื่องมือแพทย์"),0 ,'C' );


$pdf->setXY(17.6,11.85);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',7);
//1
$pdf->setXY(17.7,12.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,11.95);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการสินค้าทั่วไป"),0 ,'L' );

$pdf->setXY(17.7,12.35);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,12.25);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งกล่องโฟม"),0 ,'L' );

$pdf->setXY(17.7,12.65);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,12.55);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งผัก-ผลไม้"),0 ,'L' );






$pdf->setXY(19.6,11.85);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//2
$pdf->setXY(19.7,12.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,11.95);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ไม่ควบคุมอุณหภูมิ"),0 ,'L' );

$pdf->setXY(19.7,12.35);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,12.25);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Chilled 2-8 C"),0 ,'L' );

$pdf->setXY(19.7,12.65);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,12.55);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Frozen -15 C"),0 ,'L' );





$pdf->setXY(21.6,11.85);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//3
$pdf->setXY(21.7,12.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,11.95);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ด่วน 1 วัน"),0 ,'L' );

$pdf->setXY(21.7,12.35);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,12.25);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ธรรมดา 2-3 วัน"),0 ,'L' );

/*$pdf->setXY(21.7,12.65);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,12.55);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ภายในวัน"),0 ,'L' );*/



$pdf->setXY(23.6,11.85);
$pdf->Cell(1.2,1.2, "",1,1,"c" );

$pdf->setXY(24.8,11.85);
$pdf->Cell(1.2,1.2, "",1,1,"c" );



$pdf->setXY(26.0,11.85);
$pdf->Cell(1.2,1.2, "",1,1,"c" );


$pdf->setXY(27.2,11.85);
$pdf->Cell(2.1,1.2, "",1,1,"c" );


$pdf->setXY(27.2,11.85);
$pdf->Cell(2.1,1.2, "",1,1,"c" );
	
	
//แถว 8
$pdf->setXY(0.3,13.05);
$pdf->Cell(0.8,1.2, "",1,1,"c" );	

$pdf->setXY(1.1,13.05);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->setXY(2.6,13.05);
$pdf->Cell(2.5,1.2, "",1,1,"c" );


$pdf->setXY(5.1,13.05);
$pdf->Cell(6.0,1.2, "",1,1,"c" );

$pdf->setXY(11.1,13.05);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(12.6,13.05);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(14.1,13.05);
$pdf->Cell(2.0,1.2, "",1,1,"c" );


$pdf->setXY(16.1,13.05);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',9);
$pdf->setXY(16.1,13.05);
$pdf->MultiCell(1.5,1.2, iconv( 'UTF-8','cp874' , "เครื่องมือแพทย์"),0 ,'C' );


$pdf->setXY(17.6,13.05);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',7);
//1
$pdf->setXY(17.7,13.25);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,13.15);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการสินค้าทั่วไป"),0 ,'L' );

$pdf->setXY(17.7,13.55);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,13.45);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งกล่องโฟม"),0 ,'L' );

$pdf->setXY(17.7,13.85);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,13.75);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งผัก-ผลไม้"),0 ,'L' );






$pdf->setXY(19.6,13.05);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//2
$pdf->setXY(19.7,13.25);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,13.15);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ไม่ควบคุมอุณหภูมิ"),0 ,'L' );

$pdf->setXY(19.7,13.55);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,13.45);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Chilled 2-8 C"),0 ,'L' );

$pdf->setXY(19.7,13.85);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,13.75);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Frozen -15 C"),0 ,'L' );





$pdf->setXY(21.6,13.05);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//3
$pdf->setXY(21.7,13.25);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,13.15);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ด่วน 1 วัน"),0 ,'L' );

$pdf->setXY(21.7,13.55);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,13.45);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ธรรมดา 2-3 วัน"),0 ,'L' );

/*$pdf->setXY(21.7,13.85);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,13.75);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ภายในวัน"),0 ,'L' );
*/


$pdf->setXY(23.6,13.05);
$pdf->Cell(1.2,1.2, "",1,1,"c" );

$pdf->setXY(24.8,13.05);
$pdf->Cell(1.2,1.2, "",1,1,"c" );



$pdf->setXY(26.0,13.05);
$pdf->Cell(1.2,1.2, "",1,1,"c" );


$pdf->setXY(27.2,13.05);
$pdf->Cell(2.1,1.2, "",1,1,"c" );


$pdf->setXY(27.2,13.05);
$pdf->Cell(2.1,1.2, "",1,1,"c" );
	
	
//แถว 8
$pdf->setXY(0.3,14.25);
$pdf->Cell(0.8,1.2, "",1,1,"c" );	

$pdf->setXY(1.1,14.25);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->setXY(2.6,14.25);
$pdf->Cell(2.5,1.2, "",1,1,"c" );


$pdf->setXY(5.1,14.25);
$pdf->Cell(6.0,1.2, "",1,1,"c" );

$pdf->setXY(11.1,14.25);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(12.6,14.25);
$pdf->Cell(1.5,1.2, "",1,1,"c" );


$pdf->setXY(14.1,14.25);
$pdf->Cell(2.0,1.2, "",1,1,"c" );


$pdf->setXY(16.1,14.25);
$pdf->Cell(1.5,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',9);
$pdf->setXY(16.1,14.25);
$pdf->MultiCell(1.5,1.2, iconv( 'UTF-8','cp874' , "เครื่องมือแพทย์"),0 ,'C' );


$pdf->setXY(17.6,14.25);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

$pdf->SetFont('angsa','',7);
//1
$pdf->setXY(17.7,14.45);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,14.35);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการสินค้าทั่วไป"),0 ,'L' );

$pdf->setXY(17.7,14.75);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,14.65);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งกล่องโฟม"),0 ,'L' );

$pdf->setXY(17.7,15.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(18.0,14.95);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "บริการขนส่งผัก-ผลไม้"),0 ,'L' );






$pdf->setXY(19.6,14.25);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//2
$pdf->setXY(19.7,14.45);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,14.35);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ไม่ควบคุมอุณหภูมิ"),0 ,'L' );

$pdf->setXY(19.7,14.75);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,14.65);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Chilled 2-8 C"),0 ,'L' );

$pdf->setXY(19.7,15.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(20.0,14.95);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "Frozen -15 C"),0 ,'L' );





$pdf->setXY(21.6,14.25);
$pdf->Cell(2.0,1.2, "",1,1,"c" );

//3
$pdf->setXY(21.7,14.45);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,14.35);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ด่วน 1 วัน"),0 ,'L' );

$pdf->setXY(21.7,14.75);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,14.65);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ธรรมดา 2-3 วัน"),0 ,'L' );

/*$pdf->setXY(21.7,15.05);
$pdf->Cell(0.15,0.15, "",1,1,"c" );

$pdf->setXY(22.0,14.95);
$pdf->MultiCell(2.1,0.3, iconv( 'UTF-8','cp874' , "ภายในวัน"),0 ,'L' );*/



$pdf->setXY(23.6,14.25);
$pdf->Cell(1.2,1.2, "",1,1,"c" );

$pdf->setXY(24.8,14.25);
$pdf->Cell(1.2,1.2, "",1,1,"c" );



$pdf->setXY(26.0,14.25);
$pdf->Cell(1.2,1.2, "",1,1,"c" );


$pdf->setXY(27.2,14.25);
$pdf->Cell(2.1,1.2, "",1,1,"c" );


$pdf->setXY(27.2,14.25);
$pdf->Cell(2.1,1.2, "",1,1,"c" );
	

	
	
	
$pdf->SetFillColor(204,204,204);

$pdf->Cell(23.25,0.4,iconv('UTF-8','cp874','รวม'),1,0,"R",true);
$pdf->Cell(1.2,0.4,iconv('UTF-8','cp874',''),1,0,"R",true);
$pdf->Cell(1.2,0.4,iconv('UTF-8','cp874',''),1,0,"R",true);
$pdf->Cell(1.2,0.4,iconv('UTF-8','cp874',''),1,0,"R",true);
$pdf->Cell(2.1,0.4,iconv('UTF-8','cp874',''),1,0,"R",true);
		
//$pdf->setXY(0.3,11.85);
//$pdf->Cell(29,1.6, "",1,1,"c" );

$pdf->setXY(1.0,15.8);
$pdf->MultiCell(29,0.4, iconv( 'UTF-8','cp874' , "หมายเหตุ"),0 ,'L' );


$pdf->setXY(1.0,16.2);
$pdf->MultiCell(14,0.4, iconv( 'UTF-8','cp874' , "1. ประเภทสินค้าหากเป็นยาเย็นระบุ (ยาเย็น) / ยาธรรมดาระบุ (ยา)"),0 ,'L' );

$pdf->setXY(1.0,16.6);
$pdf->MultiCell(14,0.4, iconv( 'UTF-8','cp874' , "2.  ช่องประเภทสินค้า ระบุสินค้าที่บรรจุในกล่อง(เนื้อแช่แข็ง, ปลาแช่แข็ง, เนยแช่แข็ง, ผลไม้หรือสินค้าประเภทอื่น ๆ ฯลฯ)"),0 ,'L' );

$pdf->setXY(1.0,17.0);
$pdf->MultiCell(14,0.4, iconv( 'UTF-8','cp874' , "3. สินค้าประเภทผัก-ผลไม้ หากใช้บริการขนส่งผัก-ผลไม้ จะต้องเป็นลูกหรือเป็นผลเปลือกแข็งเท่านั้น"),0 ,'L' );


$pdf->setXY(15.0,16.2);
$pdf->MultiCell(14,0.4, iconv( 'UTF-8','cp874' , "4.  ช่องระบุขนาดกล่อง ระบุขนาดกล่องดังนี้ S1, S2,  A1, A2, B1, B2 / บริการขนส่งผัก-ผลไม้ ไม่ต้องระบุขนาดกล่อง แต่ต้องระบุน้ำหนัก (กิโลกรัม) ต่อกล่อง"),0 ,'L' );

$pdf->setXY(15.0,16.6);
$pdf->MultiCell(14,0.4, iconv( 'UTF-8','cp874' , "5. กรณีที่ผู้รับปลายทางไม่มีเบอร์โทรติดต่อให้ใช้เบอร์โทรติดต่อของผู้ส่งสินค้าแทน"),0 ,'L' );

$pdf->setXY(15.0,17.0);
$pdf->MultiCell(14,0.4, iconv( 'UTF-8','cp874' , "6. หากไม่ทราบวิธีคิดขนาดกล่อง ระบุน้ำหนักต่อกล่องในช่องน้ำหนักและปริมาตร กว้าง X ยาว X สูง (เซนติเมตร) ในช่องหมายเหตุ"),0 ,'L' );
	
$pdf->Cell(28.9,0.4,iconv('UTF-8','cp874',''),0,0,"C",true);
	
	
$pdf->SetFont('angsa','',8);	
$pdf->setXY(11,18.0);
$pdf->Cell(8,2.2, "",1,1,"c" );	
	
$pdf->setXY(11,18.1);
$pdf->MultiCell(8,0.3, iconv( 'UTF-8','cp874' , "ใบรายงานการส่งสินค้าหน้านี้เป็นใบรายงานการส่งสินค้าหน้าถัดมาที่ผู้ส่งสินค้า"),0 ,'C' );
	
$pdf->setXY(11,18.4);
$pdf->MultiCell(8,0.3, iconv( 'UTF-8','cp874' , "จะแนบไปกับใบรายงานการส่งสินค้าหน้าแรกด้วยทุกครั้ง(ถ้ามีการส่งหลายปลายทาง)และครอบคลุม"),0 ,'C' );
	
$pdf->setXY(11,18.7);
$pdf->MultiCell(8,0.3, iconv( 'UTF-8','cp874' , "คำรับรองของผู้ส่งสินค้าเช่นเดียวกันกับหน้าแรกทุกประการ"),0 ,'C' );

$pdf->setXY(11,19.0);
$pdf->MultiCell(8,0.3, iconv( 'UTF-8','cp874' , "(ลงชื่อผู้ส่งสินค้าทุกใบรายงานการส่งสินค้าหน้าถัดมา)"),0 ,'C' );
	
	
$pdf->setXY(11,19.8);
$pdf->MultiCell(8,0.3, iconv( 'UTF-8','cp874' , "ลงชื่อ  .................................................................  ผู้ส่งสินค้า วันที่ ............... / ................ / ..............."),0 ,'C' );
	
	
$pdf->Image("img/qrcode_inter.png",27.7,18.5,1.5,1.5);

$pdf->SetFont('angsa','',7);
$pdf->setXY(26.5,20.2);
$pdf->MultiCell(29,0, iconv( 'UTF-8','cp874' , "FM-RC-01, แก้ไขครั้งที่ 10.01-02-2026"),0 ,'L' );
	
	
}	

















	
$pdf->Output();
?>

