<?php

define('FPDF_FONTPATH','font/');
 
require('fpdf.php');


include"dbconnect.php";

$sql1 = "SELECT *   FROM hos__proreceive where rp_no = '".$_GET["rp_no"]."'";
$qry1 = mysqli_query($conn,$sql1) or die(mysqli_error());
$rs1 = mysqli_fetch_assoc($qry1);


$strSQL1 = "SELECT * FROM  (hos__subproreceive LEFT JOIN tb_product ON hos__subproreceive.product_ID=tb_product.product_id) WHERE ref_rpno = '".$_GET["rp_no"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

$strSQL15 = "SELECT SUM(count) AS amount_1 FROM hos__subproreceive WHERE ref_rpno = '".$_GET["rp_no"]."' ";
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResult15= mysqli_fetch_array($objQuery15);

$summary_1=$objResult15['amount_1'];



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





$type_company=$rs1["type_company"];

$iv_date = DateThai($rs1["iv_date"]);
$type_customer =$rs1["type_customer"];
$show_name =$rs1["show_name"];

if($show_name=='1'){
$customer =$rs1["customer"];
$address =$rs1["address"];
}else if($show_name=='2'){
$customer =$rs1["bill_name"];
$address =$rs1["bill_address"];
}
	

$rp_no = $rs1["rp_no"];
$iv_noref = $rs1["iv_noref"];




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
if($type_company=='1'){
$pdf->Image("img/nex_ptl.jpg",2.5,0.5,19,5.0);
}else{
$pdf->Image("img/nex_nbm.jpg",2.5,0.5,19,5.0);	
}



$pdf->setXY(2.0,5.6);
$pdf->Cell(10.5,0.7, "",1,1,"c" );

$pdf->setXY(12.5,5.6);
$pdf->Cell(5.0,0.7, "",1,1,"c" );

$pdf->setXY(17.5,5.6);
$pdf->Cell(5.0,0.7, "",1,1,"c" );

$pdf->setXY(2.0,6.3);
$pdf->Cell(15.5,1.4, "",1,1,"c" );

$pdf->setXY(17.5,6.3);
$pdf->Cell(5.0,1.4, "",1,1,"c" );


$pdf->SetFont('angsa','',14); 

$pdf->setXY(2.05,5.7);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "ชื่อลูกค้า"),0 ,'L' );

$pdf->setXY(2.05,6.4);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "ที่อยู่"),0 ,'L' );

$pdf->SetFont('angsa','',15); 

$pdf->setXY(3.2,6.4);
$pdf->MultiCell(14.0,0.6, iconv( 'UTF-8','cp874' , "$address"),0 ,'L' );



$pdf->SetFont('angsana','B',14);


$pdf->setXY(3.5,5.7);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "$customer"),0 ,'L' );

$pdf->SetFont('angsa','',14); 

$pdf->setXY(12.55,5.7);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "วันที่"),0 ,'L' );


$pdf->setXY(14.2,5.7);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "$iv_date"),0 ,'L' );

$pdf->setXY(17.55,5.7);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "เลขที่"),0 ,'L' );

$pdf->setXY(19.5,5.7);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "$rp_no"),0 ,'L' );


$pdf->setXY(17.55,6.4);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "อ้่างอิงเอกสารเลขที่"),0 ,'L' );

$pdf->setXY(19.5,7.0);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "$iv_noref"),0 ,'L' );

$pdf->setXY(2.0,7.7);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(2.0,7.7);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "ลำดับ"),0 ,'L' );

$pdf->setXY(3.0,7.7);
$pdf->Cell(3.0,0.7, "",1,1,"c" );

$pdf->setXY(3.6,7.7);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "รหัสสินค้า"),0 ,'L' );

$pdf->setXY(6.0,7.7);
$pdf->Cell(8.5,0.7, "",1,1,"c" );

$pdf->setXY(9.8,7.7);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "รายการ"),0 ,'L' );

$pdf->setXY(14.5,7.7);
$pdf->Cell(1.5,0.7, "",1,1,"c" );

$pdf->setXY(14.65,7.7);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "จำนวน"),0 ,'L' );

$pdf->setXY(16.0,7.7);
$pdf->Cell(1.5,0.7, "",1,1,"c" );

$pdf->setXY(16.2,7.7);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "หน่วย"),0 ,'L' );

$pdf->setXY(17.5,7.7);
$pdf->Cell(5.0,0.7, "",1,1,"c" );

$pdf->setXY(19.2,7.7);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "หมายเหตุ"),0 ,'L' );

$pdf->setXY(19.2,8.2);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , ""),0 ,'L' );

$i=1;
while($objResult1 = mysqli_fetch_array($objQuery1))
{
$product_code1  =$objResult1["access_code"];
$product_code = substr($product_code1,0,10);	
$ckk_name  =$objResult1["ckk_name"];

if($ckk_name=='1'){	
$product_name  =$objResult1["proname"];
}else{
$product_name1  =$objResult1["access_name"];
$product_name = substr($product_name1,0,45);	
}	
$sale_count  =$objResult1["count"];
$unit_name  =$objResult1["unit_name"];
$sale_remark = $objResult1["sale_remark"];


$pdf->setX(2.1);
$pdf->MultiCell( 9.0,0, iconv( 'UTF-8','cp874' , "$i"),0 ,'L' );


$pdf->setX(3.1);
$pdf->MultiCell( 9.0,0, iconv( 'UTF-8','cp874' , "$product_code"),0 ,'L' );
$pdf->SetFont('angsa','',14);

$pdf->setX(6.1);
$pdf->MultiCell(12,0.0, iconv( 'UTF-8','cp874' , "$product_name"),0 ,'L' );
$pdf->SetFont('angsa','',14);

$pdf->setX(14.5);
$pdf->MultiCell(1.5,0, iconv( 'UTF-8','cp874' , "$sale_count"),0 ,'R' );
	
	$pdf->setX(15.3);
$pdf->MultiCell(1.9,0, iconv( 'UTF-8','cp874' , "$unit_name"),0 ,'R' );

$pdf->setX(17.5);
$pdf->MultiCell(10,0, iconv( 'UTF-8','cp874' , "$sale_remark"),0 ,'L' );
	
	$pdf->setX(18.3);
$pdf->MultiCell( 9.0,0.6, iconv( 'UTF-8','cp874' , ""),0 ,'L' );
	

$i++;


}


$pdf->setXY(2.0,8.4);
$pdf->Cell(1.0,13.0, "",1,1,"c" );

$pdf->setXY(3.0,8.4);
$pdf->Cell(3.0,13.0, "",1,1,"c" );

$pdf->setXY(6.0,8.4);
$pdf->Cell(8.5,13.0, "",1,1,"c" );

$pdf->setXY(14.5,8.4);
$pdf->Cell(1.5,13.0, "",1,1,"c" );

$pdf->setXY(16.0,8.4);
$pdf->Cell(1.5,13.0, "",1,1,"c" );

$pdf->setXY(17.5,8.4);
$pdf->Cell(5.0,13.0, "",1,1,"c" );







$pdf->setXY(2.0,21.4);
$pdf->Cell(12.5,0.7, "",1,1,"c" );
$pdf->setXY(9.0,21.4);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "รวม"),0 ,'L' );

$pdf->setXY(14.5,21.4);
$pdf->Cell(1.5,0.7, "",1,1,"c" );
$pdf->setXY(14.55,21.4);
$pdf->MultiCell(1.5,0.6, iconv( 'UTF-8','cp874' , "$Num_Rows1"),0 ,'R' );

$pdf->setXY(15.5,21.4);
$pdf->MultiCell(1.9,0.6, iconv( 'UTF-8','cp874' , "รายการ"),0 ,'R' );


$pdf->setXY(16.0,21.4);
$pdf->Cell(1.5,0.7, "",1,1,"c" );

$pdf->setXY(17.5,21.4);
$pdf->Cell(5.0,0.7, "",1,1,"c" );



$pdf->setXY(2.0,22.1);
$pdf->Cell(10.5,4.0, "",1,1,"c" );

$pdf->setXY(12.5,22.1);
$pdf->Cell(10.0,4.0, "",1,1,"c" );

$pdf->setXY(2.5,22.3);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "ได้รับสินค้าข้างต้นในสภาพเรียบร้อยสมบูรณ์"),0 ,'L' );

$pdf->setXY(2.5,22.9);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Received the above mentioned good in good order and condition"),0 ,'L' );

$pdf->setXY(2.05,25.0);
$pdf->Cell(9.0,0.6, iconv( 'UTF-8','cp874' , "ผู้รับ................................................................วันที่................................................."),0 ,'L' );

$pdf->setXY(2.05,25.4);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Received by"),0 ,'L' );

$pdf->setXY(8.8,25.4);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Date"),0 ,'L' );

$pdf->SetFont('angsana','B',16);
$pdf->setXY(12.55,22.3);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "*** เอกสารต้นฉบับสีขาว นำกลับบริษัทฯ"),0 ,'L' );
$pdf->setXY(12.55,22.9);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "เอกสารสำเนาสีฟ้า ให้ลูกค้าเป็นหลักฐาน"),0 ,'L' );

$pdf->SetFont('angsa','',14); 


$pdf->setXY(12.55,25.0);
$pdf->Cell(9.0,0.6, iconv( 'UTF-8','cp874' , "ผู้ส่ง...............................................................วันที่..........................................."),0 ,'L' );

$pdf->setXY(12.55,25.4);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Delivered by"),0 ,'L' );

$pdf->setXY(18.2,25.4);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Date"),0 ,'L' );


$pdf->SetFont('angsa','',13); 
$pdf->setXY(2.0,26.1);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "อนุมัติวันที่ 18 พ.ค.2561"),0 ,'L' );

$pdf->setXY(20.1,26.1);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "FM-OF-15:Rev.0"),0 ,'L' );








$pdf->Output();
?>


