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

$strSQL9 = "SELECT bill_name FROM hos__so WHERE ref_id = '".$rs1["ref_iddoc"]."' ";
$objQuery9 = mysqli_query($conn,$strSQL9);
$objResult9= mysqli_fetch_array($objQuery9);

$strSQL8 = "SELECT bill_name FROM hos__smp WHERE ref_idsmp = '".$rs1["ref_iddoc"]."' ";
$objQuery8 = mysqli_query($conn,$strSQL8);
$objResult8= mysqli_fetch_array($objQuery8);

if($objResult9["bill_name"]!=''){
$bill_name = $objResult9["bill_name"];
}else{
$bill_name = $objResult8["customer_name"];
}

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

if($type_company =='1'){
$pdf->SetFont('angsana','B',20);

$pdf->setXY(2.0,1.0);
$pdf->MultiCell( 9  , 0.6 , iconv( 'UTF-8','cp874' , "บริษัท ออลล์เวล ไลฟ์ จำกัด"),0 ,'L' );

$pdf->SetFont('angsa','',15);
$pdf->setXY(2.0,1.6);
$pdf->MultiCell( 9  , 0.4 , iconv( 'UTF-8','cp874' , "73,75 ซอยจรัญสนิทวงศ์ 89/2 แขวงบางอ้อ"),0 ,'L' );

$pdf->setXY(2.0,2.0);
$pdf->MultiCell( 9  , 0.4 , iconv( 'UTF-8','cp874' , "เขตบางพลัด กรุงเทพมหานคร 10700"),0 ,'L' );

$pdf->setXY(2.0,2.4);
$pdf->MultiCell( 9  , 0.4 , iconv( 'UTF-8','cp874' , "โทร : 0-2424-3555 (อัตโนมัติ)"),0 ,'L' );

$pdf->setXY(2.0,2.8);
$pdf->MultiCell( 9  , 0.4 , iconv( 'UTF-8','cp874' , "แฟ็กซ์ : 0-2424-3322"),0 ,'L' );

$pdf->Image("img/allwell_logo.png",9.5,1.5,6.0,1.5);

$pdf->SetFont('angsana','B',20);

$pdf->setXY(11.4,3.5);
$pdf->MultiCell(9.0,1.6, iconv( 'UTF-8','cp874' , "ใบรับสินค้า"),0 ,'L' );

$pdf->SetFont('angsa','',20);

$pdf->setXY(10.4,4.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "(Received Product Form)"),0 ,'L' );



$pdf->SetFont('angsana','B',18);

$pdf->setXY(13.6,1.0);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "ALLWELL LIFE CO., LTD"),0 ,'R' );

$pdf->SetFont('angsa','',15);

$pdf->setXY(13.6,1.6);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "73,75 Soi Charansanitwong 89/2,"),0 ,'R' );

$pdf->setXY(13.6,2.0);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Bang-Or, Bang-Plad,Bankok 10700"),0 ,'R' );

$pdf->setXY(13.6,2.4);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "TEL : 0-2424-3555 (Auto)"),0 ,'R' );

$pdf->setXY(13.6,2.8);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "FAX : 0-2424-3322"),0 ,'R' );

}

if($type_company =='2'){
$pdf->SetFont('angsana','B',20);

$pdf->setXY(2.0,1.0);
$pdf->MultiCell( 9  , 0.6 , iconv( 'UTF-8','cp874' , "บริษัท โนเบิล เมด จำกัด"),0 ,'L' );

$pdf->SetFont('angsa','',15);
$pdf->setXY(2.0,1.6);
$pdf->MultiCell( 9  , 0.4 , iconv( 'UTF-8','cp874' , "73 ซอยจรัญสนิทวงศ์ 89/2 แขวงบางอ้อ"),0 ,'L' );

$pdf->setXY(2.0,2.0);
$pdf->MultiCell( 9  , 0.4 , iconv( 'UTF-8','cp874' , "เขตบางพลัด กรุงเทพมหานคร 10700"),0 ,'L' );

$pdf->setXY(2.0,2.4);
$pdf->MultiCell( 9  , 0.4 , iconv( 'UTF-8','cp874' , "โทร : 0-2880-5566 (อัตโนมัติ)"),0 ,'L' );

$pdf->setXY(2.0,2.8);
$pdf->MultiCell( 9  , 0.4 , iconv( 'UTF-8','cp874' , "แฟ็กซ์ : 0-2880-5533"),0 ,'L' );

$pdf->Image("img/nbm_select.png",10.5,1.5,4.0,2.0);

$pdf->SetFont('angsana','B',20);

$pdf->setXY(11.4,3.5);
$pdf->MultiCell(9.0,1.6, iconv( 'UTF-8','cp874' , "ใบรับสินค้า"),0 ,'L' );

$pdf->SetFont('angsa','',20);

$pdf->setXY(10.4,4.5);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "(Received Product Form)"),0 ,'L' );



$pdf->SetFont('angsana','B',18);

$pdf->setXY(13.6,1.0);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "NOBLE MED CO.,LTD"),0 ,'R' );

$pdf->SetFont('angsa','',15);

$pdf->setXY(13.6,1.6);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "73 Soi Charansanitwong 89/2,"),0 ,'R' );

$pdf->setXY(13.6,2.0);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Bang-Or, Bang-Plad,Bankok 10700"),0 ,'R' );

$pdf->setXY(13.6,2.4);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "TEL : 0-2880-5566 (Auto)"),0 ,'R' );

$pdf->setXY(13.6,2.8);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "FAX : 0-2880-5533"),0 ,'R' );

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


$pdf->SetFont('angsa','',16); 

$pdf->setXY(2.05,5.7);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "ชื่อลูกค้า"),0 ,'L' );

$pdf->setXY(2.05,6.4);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "ที่อยู่"),0 ,'L' );

$pdf->SetFont('angsa','',14); 

$pdf->setXY(3.2,6.4);
$pdf->MultiCell(14.0,0.6, iconv( 'UTF-8','cp874//IGNORE' , "$address"),0 ,'L' );



$pdf->SetFont('angsana','B',16);
//$pdf->SetFont('angsa','',12); 

$pdf->setXY(3.5,5.7);
$pdf->MultiCell(12.0,0.6, iconv( 'UTF-8','cp874//IGNORE' , "$customer"),0 ,'L' );

$pdf->SetFont('angsa','',16); 

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
$product_name = substr($product_name1,0,30);	
}	
$sale_count  =$objResult1["count"];
$unit_name  =$objResult1["unit_name"];
$sale_remark = $objResult1["sale_remark"];


$pdf->setX(2.1);
$pdf->MultiCell( 9.0,0, iconv( 'UTF-8','cp874' , "$i"),0 ,'L' );


$pdf->setX(3.1);
$pdf->MultiCell( 9.0,0, iconv( 'UTF-8','cp874' , "$product_code"),0 ,'L' );
$pdf->SetFont('angsa','',16);

$pdf->setX(6.1);
$pdf->MultiCell(8.5,0, iconv( 'UTF-8//IGNORE','cp874//IGNORE' , "$product_name"),0 ,'L' );
//$pdf->MultiCell(8.5,0, iconv( 'UTF-8','cp874' , "โคมไฟส่องตรวจ Examination Lamp"),0 ,'L' );
$pdf->SetFont('angsa','',16);

$pdf->setX(14.5);
$pdf->MultiCell(1.5,0, iconv( 'UTF-8','cp874' , "$sale_count"),0 ,'R' );
	
$pdf->setX(15.3);
$pdf->MultiCell(1.9,0, iconv( 'UTF-8','cp874' , "$unit_name"),0 ,'R' );

$pdf->SetFont('angsa','',14);	
$pdf->setX(17.5);
//$pdf->MultiCell(5,0.6, iconv( 'UTF-8','cp874' , "$sale_remark"),0 ,'L' );
$pdf->MultiCell(5,0, iconv( 'UTF-8','cp874' , "$sale_remark"),0 ,'L' );
	
	$pdf->setX(18.3);
$pdf->MultiCell( 9.0,0.6, iconv( 'UTF-8','cp874' , ""),0 ,'L' );
/*$pdf->setX(6.1);	
	$pdf->MultiCell(10,0, iconv( 'UTF-8','cp874' , "โคมไฟส่องตรวจ หลอดฮาโลเจน 3 หลอด"),0 ,'L' );	
	$pdf->setX(18.3);
$pdf->MultiCell( 9.0,0.6, iconv( 'UTF-8','cp874' , ""),0 ,'L' );
$pdf->setX(6.1);	
	$pdf->MultiCell(10,0, iconv( 'UTF-8','cp874' , "ใช้งานแบบตั้งพื้น"),0 ,'L' );	*/
	
 //โคมไฟส่องตรวจ Examination Lamp โคมไฟส่องตรวจ หลอดฮาโลเจน 3 หลอด ใช้งานแบบตั้งพื้น 
$i++;


}

$pdf->SetFont('angsa','',16);

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

	//$summary_1

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
$pdf->Cell(9.0,0.6, iconv( 'UTF-8','cp874' , "ผู้รับ................................................................วันที่................................."),0 ,'L' );

$pdf->setXY(2.05,25.4);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Received by"),0 ,'L' );

$pdf->setXY(8.8,25.4);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Date"),0 ,'L' );

$pdf->SetFont('angsana','B',16);
$pdf->setXY(12.55,22.3);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "*** เอกสารต้นฉบับสีขาว นำกลับบริษัทฯ"),0 ,'L' );
$pdf->setXY(12.55,22.9);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "เอกสารสำเนาสีฟ้า ให้ลูกค้าเป็นหลักฐาน"),0 ,'L' );

$pdf->SetFont('angsa','',16); 


$pdf->setXY(12.55,25.0);
$pdf->Cell(9.0,0.6, iconv( 'UTF-8','cp874' , "ผู้ส่ง...............................................................วันที่..........................."),0 ,'L' );

$pdf->setXY(12.55,25.4);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Delivered by"),0 ,'L' );

$pdf->setXY(18.2,25.4);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Date"),0 ,'L' );


$pdf->SetFont('angsa','',13); 
$pdf->setXY(2.0,26.1);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "อนุมัติวันที่ 18 พ.ค.2561"),0 ,'L' );

$pdf->setXY(20.1,26.1);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "FM-OF-15:Rev.0"),0 ,'L' );



$pdf->SetFont('angsana','B',20);
$pdf->setXY(3.0,27.5);
$pdf->MultiCell(20,0.6, iconv( 'UTF-8','cp874' , "ชื่อที่ออกบิล : $bill_name"),0 ,'L' );




$pdf->Output();
?>


