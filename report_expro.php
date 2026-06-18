<?php

define('FPDF_FONTPATH','font/');
 
require('fpdf.php');

function DateThai($strDate)
	{
		$strYear = date("Y",strtotime($strDate))+543;
		$strMonth= date("n",strtotime($strDate));
		$strDay= date("j",strtotime($strDate));
		$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		$strMonthThai=$strMonthCut[$strMonth];
		return "$strDay $strMonthThai $strYear";
	}

include"dbconnect.php";

$ref_id=$_GET["ref_id"];


$strSQL = "SELECT iv_no,employee_name,iv_date FROM st__expro WHERE ref_id = '".$ref_id."' ";
$objQuery = mysqli_query($new,$strSQL)or die ("Error Query [".$strSQL."]");;
$objResult = mysqli_fetch_array($objQuery);

$iv_no = $objResult["iv_no"];
$stock_date = Datethai($objResult["iv_date"]);
$employee_name = $objResult["employee_name"];

$strSQL1 = "SELECT * FROM (st__subexpro LEFT JOIN tb_product ON st__subexpro.product_ID=tb_product.product_id) WHERE ref_idd = '".$ref_id."' LIMIT 24";
$objQuery1 = mysqli_query($new,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);


$strSQL2 = "SELECT * FROM (st__subexpro LEFT JOIN tb_product ON st__subexpro.product_ID=tb_product.product_id) WHERE ref_idd = '".$ref_id."' LIMIT 24 OFFSET 24";
$objQuery2 = mysqli_query($new,$strSQL2) or die ("Error Query [".$strSQL2."]");
$Num_Rows2 = mysqli_num_rows($objQuery2);

date_default_timezone_set("Asia/Bangkok");



$pdf=new FPDF( 'P' , 'cm' , 'A4' );
$pdf->AddFont('angsa','','angsa.php');
$pdf->AddFont('angsana','B','angsab.php');
 
$pdf->AddPage();
$pdf->SetFont('angsana','B',18);

$pdf->Image("img/ecec.jpg",1.1,0.5,1.5,0.7);

/*$pdf->setXY(1.0,1.0);
$pdf->Cell(19.2,24.0, "",1,1,"c" );*/

$pdf->setXY(7.5,1.0);
$pdf->MultiCell(9,0.6, iconv( 'UTF-8','cp874' , "บันทึกรับ-จ่ายสินค้าจากคลังสินค้า"),0 ,'L' );
$pdf->setXY(8.0,1.7);
$pdf->MultiCell(10, 0.6, iconv( 'UTF-8','cp874' , "(In-Out Record of Goods)"),0 ,'L' );

$pdf->SetFont('angsana','B',14);

$pdf->setXY(17.0,1.2);
$pdf->MultiCell(10,0.6, iconv( 'UTF-8','cp874' , "เลขที่ :" ),0,'L' );

$pdf->setXY(18.0,1.7);
$pdf->Cell(2.0,0,'','T',0,'C',0);

$pdf->setXY(18.0,1.2);
$pdf->MultiCell(10,0.6, iconv( 'UTF-8','cp874' , "$iv_no" ),0,'L' );

$pdf->SetFont('angsa','',15);

$pdf->setXY(3.2,3.6);
$pdf->Cell(7.0,0,'','T',0,'C',0);

$pdf->setXY(12.3,3.6);
$pdf->Cell(6.0,0,'','T',0,'C',0);

$pdf->setXY(1.1,3.0);
$pdf->MultiCell(10,0.6, iconv( 'UTF-8','cp874' , "ชื่อผู้บันทึก :" ),0,'L' );

$pdf->setXY(3.2,3.0);
$pdf->MultiCell(10,0.6, iconv( 'UTF-8','cp874' , "$employee_name" ),0,'L' );

$pdf->setXY(11.1,3.0);
$pdf->MultiCell(10,0.6, iconv( 'UTF-8','cp874' , "วันที่ :" ),0,'L' );

$pdf->setXY(12.5,3.0);
$pdf->MultiCell(10,0.6, iconv( 'UTF-8','cp874' , "$stock_date" ),0,'L' );

$pdf->setXY(1.1,3.7);
$pdf->MultiCell(10,0.6, iconv( 'UTF-8','cp874' , "สาเหตุการบันทึก :" ),0,'L' );

$pdf->Image("img/pptt.jpg",4.15,3.85,0.25,0.3);

$pdf->setXY(4.5,3.7);
$pdf->MultiCell(10,0.6, iconv( 'UTF-8','cp874' , "รับสินค้าเข้าคลังสินค้า จากต่างประเทศ" ),0,'L' );

$pdf->Image("img/pptt.jpg",11.15,3.85,0.25,0.3);

$pdf->setXY(11.5,3.7);
$pdf->MultiCell(10,0.6, iconv( 'UTF-8','cp874' , "รับสินค้าเข้าคลังสินค้า จากในประเทศ" ),0,'L' );

$pdf->Image("img/pptt.jpg",4.15,4.45,0.25,0.3);

$pdf->setXY(4.5,4.3);
$pdf->MultiCell(10,0.6, iconv( 'UTF-8','cp874' , "เบิกเป็นสินค้าสาธิต" ),0,'L' );

$pdf->Image("img/pptt.jpg",11.15,4.45,0.25,0.3);

$pdf->setXY(11.5,4.3);
$pdf->MultiCell(10,0.6, iconv( 'UTF-8','cp874' , "เบิกเป็นสินค้าสำรองการใช้งาน" ),0,'L' );

$pdf->Image("img/pptt.jpg",4.15,5.05,0.25,0.3);

$pdf->setXY(4.5,4.9);
$pdf->MultiCell(10,0.6, iconv( 'UTF-8','cp874' , "เบิกสินค้าไปรวม/แยกชุดขาย" ),0,'L' );

$pdf->Image("img/pptt.jpg",11.15,5.05,0.25,0.3);

$pdf->setXY(11.5,4.9);
$pdf->MultiCell(10,0.6, iconv( 'UTF-8','cp874' , "อื่นๆ..........................................................................." ),0,'L' );

$pdf->SetFont('angsana','B',14);

$pdf->setXY(1.1,5.9);
$pdf->MultiCell(10,0.6, iconv( 'UTF-8','cp874' , "รับเข้า - จ่ายออก" ),0,'L' );

$pdf->SetFont('angsa','',15);

$pdf->setXY(1.1,6.5 );
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "รหัส Express" ),0,'L' );

$pdf->setXY(7.2,6.5 );
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "สินค้า" ),0,'L' );

$pdf->setXY(11.7,6.5 );
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "รับ" ),0,'L' );

$pdf->setXY(12.6,6.5 );
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "จ่าย" ),0,'L' );

$pdf->setXY(13.55,6.5 );
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "หน่วย" ),0,'L' );

$pdf->setXY(15.1,6.5 );
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "หมายเลข" ),0,'L' );

$pdf->setXY(17.75,6.5 );
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "หมายเหตุ" ),0,'L' );


$pdf->setX(7.2);
$pdf->MultiCell(2.0,0.5, iconv( 'UTF-8','cp874' , ""),0 ,'L' );


$i=1;
while($objResult1 = mysqli_fetch_array($objQuery1))
{

$unit_name  =$objResult1["unit_name"];
$product_name = $objResult1["sol_name"];
$express_code = $objResult1["express_code"];
//$product_name = substr($product_name1,0,90);	
$count_send = $objResult1["count"];
$count_receive = "";
$stock_remark = $objResult1["stock_remark"];
$sn_number = $objResult1["sn_number"];

$pdf->SetFont('angsa','',11);


$pdf->setX(0.8);
$pdf->MultiCell(9.0,0, iconv( 'UTF-8','cp874' , "$express_code"),0 ,'L' );
	
	
$pdf->setX(3.7);
$pdf->MultiCell(9.0,0, iconv( 'UTF-8//IGNORE','cp874//IGNORE' , "$product_name"),0 ,'L' );

$pdf->SetFont('angsa','',13);
$pdf->setX(11.4);
$pdf->MultiCell(1.0,0, iconv( 'UTF-8','cp874' , "$count_receive"),0 ,'R' );
	
$pdf->setX(12.4);
$pdf->MultiCell(1.0,0, iconv( 'UTF-8','cp874' , "$count_send"),0 ,'R' );	

$pdf->setX(13.3);
$pdf->MultiCell(1.5,0, iconv( 'UTF-8','cp874' , "$unit_name"),0 ,'C' );

$pdf->setX(14.6);
$pdf->MultiCell(2.5,0, iconv( 'UTF-8','cp874' , "$sn_number"),0 ,'L' );

$pdf->setX(17.2);
$pdf->MultiCell(3.0,0, iconv( 'UTF-8','cp874' , "$stock_remark"),0 ,'L' );


$pdf->setX(18.3);
$pdf->MultiCell( 9.0,0.7, iconv( 'UTF-8','cp874' , ""),0 ,'L' );


$i++;


}

//1

$pdf->SetFont('angsa','',15);

$pdf->setXY(0.7,6.5);
$pdf->Cell(2.7,0.7, "",1,1,"c" );

$pdf->setXY(3.4,6.5);
$pdf->Cell(8.0,0.7, "",1,1,"c" );

$pdf->setXY(11.4,6.5);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(12.4,6.5);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(13.4,6.5);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(14.6,6.5);
$pdf->Cell(2.5,0.7, "",1,1,"c" );

$pdf->setXY(17.1,6.5);
$pdf->Cell(3.0,0.7, "",1,1,"c" );

//2

$pdf->Image("img/pptt.jpg",3.4,7.45,0.25,0.3);
$pdf->setXY(0.7,7.2);
$pdf->Cell(2.7,0.7, "",1,1,"c" );

$pdf->setXY(3.4,7.2);
$pdf->Cell(8.0,0.7, "",1,1,"c" );

$pdf->setXY(11.4,7.2);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(12.4,7.2);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(13.4,7.2);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(14.6,7.2);
$pdf->Cell(2.5,0.7, "",1,1,"c" );

$pdf->setXY(17.1,7.2);
$pdf->Cell(3.0,0.7, "",1,1,"c" );

//3

$pdf->Image("img/pptt.jpg",3.4,8.15,0.25,0.3);
$pdf->setXY(0.7,7.9);
$pdf->Cell(2.7,0.7, "",1,1,"c" );

$pdf->setXY(3.4,7.9);
$pdf->Cell(8.0,0.7, "",1,1,"c" );

$pdf->setXY(11.4,7.9);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(12.4,7.9);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(13.4,7.9);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(14.6,7.9);
$pdf->Cell(2.5,0.7, "",1,1,"c" );

$pdf->setXY(17.1,7.9);
$pdf->Cell(3.0,0.7, "",1,1,"c" );

//4
$pdf->Image("img/pptt.jpg",3.4,8.85,0.25,0.3);
$pdf->setXY(0.7,8.6);
$pdf->Cell(2.7,0.7, "",1,1,"c" );

$pdf->setXY(3.4,8.6);
$pdf->Cell(8.0,0.7, "",1,1,"c" );

$pdf->setXY(11.4,8.6);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(12.4,8.6);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(13.4,8.6);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(14.6,8.6);
$pdf->Cell(2.5,0.7, "",1,1,"c" );

$pdf->setXY(17.1,8.6);
$pdf->Cell(3.0,0.7, "",1,1,"c" );
//5
$pdf->Image("img/pptt.jpg",3.4,9.55,0.25,0.3);
$pdf->setXY(0.7,9.3);
$pdf->Cell(2.7,0.7, "",1,1,"c" );

$pdf->setXY(3.4,9.3);
$pdf->Cell(8.0,0.7, "",1,1,"c" );

$pdf->setXY(11.4,9.3);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(12.4,9.3);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(13.4,9.3);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(14.6,9.3);
$pdf->Cell(2.5,0.7, "",1,1,"c" );

$pdf->setXY(17.1,9.3);
$pdf->Cell(3.0,0.7, "",1,1,"c" );

//6
$pdf->Image("img/pptt.jpg",3.4,10.25,0.25,0.3);
$pdf->setXY(0.7,10.0);
$pdf->Cell(2.7,0.7, "",1,1,"c" );

$pdf->setXY(3.4,10.0);
$pdf->Cell(8.0,0.7, "",1,1,"c" );

$pdf->setXY(11.4,10.0);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(12.4,10.0);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(13.4,10.0);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(14.6,10.0);
$pdf->Cell(2.5,0.7, "",1,1,"c" );

$pdf->setXY(17.1,10.0);
$pdf->Cell(3.0,0.7, "",1,1,"c" );


//1
$pdf->Image("img/pptt.jpg",3.4,10.95,0.25,0.3);
$pdf->setXY(0.7,10.7);
$pdf->Cell(2.7,0.7, "",1,1,"c" );

$pdf->setXY(3.4,10.7);
$pdf->Cell(8.0,0.7, "",1,1,"c" );

$pdf->setXY(11.4,10.7);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(12.4,10.7);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(13.4,10.7);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(14.6,10.7);
$pdf->Cell(2.5,0.7, "",1,1,"c" );

$pdf->setXY(17.1,10.7);
$pdf->Cell(3.0,0.7, "",1,1,"c" );

//2
$pdf->Image("img/pptt.jpg",3.4,11.65,0.25,0.3);
$pdf->setXY(0.7,11.4);
$pdf->Cell(2.7,0.7, "",1,1,"c" );

$pdf->setXY(3.4,11.4);
$pdf->Cell(8.0,0.7, "",1,1,"c" );

$pdf->setXY(11.4,11.4);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(12.4,11.4);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(13.4,11.4);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(14.6,11.4);
$pdf->Cell(2.5,0.7, "",1,1,"c" );

$pdf->setXY(17.1,11.4);
$pdf->Cell(3.0,0.7, "",1,1,"c" );

//3
$pdf->Image("img/pptt.jpg",3.4,12.35,0.25,0.3);
$pdf->setXY(0.7,12.1);
$pdf->Cell(2.7,0.7, "",1,1,"c" );

$pdf->setXY(3.4,12.1);
$pdf->Cell(8.0,0.7, "",1,1,"c" );

$pdf->setXY(11.4,12.1);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(12.4,12.1);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(13.4,12.1);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(14.6,12.1);
$pdf->Cell(2.5,0.7, "",1,1,"c" );

$pdf->setXY(17.1,12.1);
$pdf->Cell(3.0,0.7, "",1,1,"c" );
//4
$pdf->Image("img/pptt.jpg",3.4,13.05,0.25,0.3);
$pdf->setXY(0.7,12.8);
$pdf->Cell(2.7,0.7, "",1,1,"c" );

$pdf->setXY(3.4,12.8);
$pdf->Cell(8.0,0.7, "",1,1,"c" );

$pdf->setXY(11.4,12.8);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(12.4,12.8);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(13.4,12.8);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(14.6,12.8);
$pdf->Cell(2.5,0.7, "",1,1,"c" );

$pdf->setXY(17.1,12.8);
$pdf->Cell(3.0,0.7, "",1,1,"c" );
//5
$pdf->Image("img/pptt.jpg",3.4,13.75,0.25,0.3);
$pdf->setXY(0.7,13.5);
$pdf->Cell(2.7,0.7, "",1,1,"c" );

$pdf->setXY(3.4,13.5);
$pdf->Cell(8.0,0.7, "",1,1,"c" );

$pdf->setXY(11.4,13.5);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(12.4,13.5);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(13.4,13.5);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(14.6,13.5);
$pdf->Cell(2.5,0.7, "",1,1,"c" );

$pdf->setXY(17.1,13.5);
$pdf->Cell(3.0,0.7, "",1,1,"c" );

//6
$pdf->Image("img/pptt.jpg",3.4,14.45,0.25,0.3);
$pdf->setXY(0.7,14.2);
$pdf->Cell(2.7,0.7, "",1,1,"c" );

$pdf->setXY(3.4,14.2);
$pdf->Cell(8.0,0.7, "",1,1,"c" );

$pdf->setXY(11.4,14.2);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(12.4,14.2);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(13.4,14.2);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(14.6,14.2);
$pdf->Cell(2.5,0.7, "",1,1,"c" );

$pdf->setXY(17.1,14.2);
$pdf->Cell(3.0,0.7, "",1,1,"c" );

//1
$pdf->Image("img/pptt.jpg",3.4,15.15,0.25,0.3);
$pdf->setXY(0.7,14.9);
$pdf->Cell(2.7,0.7, "",1,1,"c" );

$pdf->setXY(3.4,14.9);
$pdf->Cell(8.0,0.7, "",1,1,"c" );

$pdf->setXY(11.4,14.9);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(12.4,14.9);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(13.4,14.9);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(14.6,14.9);
$pdf->Cell(2.5,0.7, "",1,1,"c" );

$pdf->setXY(17.1,14.9);
$pdf->Cell(3.0,0.7, "",1,1,"c" );

//2
$pdf->Image("img/pptt.jpg",3.4,15.85,0.25,0.3);
$pdf->setXY(0.7,15.6);
$pdf->Cell(2.7,0.7, "",1,1,"c" );

$pdf->setXY(3.4,15.6);
$pdf->Cell(8.0,0.7, "",1,1,"c" );

$pdf->setXY(11.4,15.6);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(12.4,15.6);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(13.4,15.6);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(14.6,15.6);
$pdf->Cell(2.5,0.7, "",1,1,"c" );

$pdf->setXY(17.1,15.6);
$pdf->Cell(3.0,0.7, "",1,1,"c" );

//3
$pdf->Image("img/pptt.jpg",3.4,16.55,0.25,0.3);
$pdf->setXY(0.7,16.3);
$pdf->Cell(2.7,0.7, "",1,1,"c" );

$pdf->setXY(3.4,16.3);
$pdf->Cell(8.0,0.7, "",1,1,"c" );

$pdf->setXY(11.4,16.3);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(12.4,16.3);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(13.4,16.3);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(14.6,16.3);
$pdf->Cell(2.5,0.7, "",1,1,"c" );

$pdf->setXY(17.1,16.3);
$pdf->Cell(3.0,0.7, "",1,1,"c" );

//4
$pdf->Image("img/pptt.jpg",3.4,17.25,0.25,0.3);
$pdf->setXY(0.7,17.0);
$pdf->Cell(2.7,0.7, "",1,1,"c" );

$pdf->setXY(3.4,17.0);
$pdf->Cell(8.0,0.7, "",1,1,"c" );

$pdf->setXY(11.4,17.0);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(12.4,17.0);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(13.4,17.0);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(14.6,17.0);
$pdf->Cell(2.5,0.7, "",1,1,"c" );

$pdf->setXY(17.1,17.0);
$pdf->Cell(3.0,0.7, "",1,1,"c" );

//5
$pdf->Image("img/pptt.jpg",3.4,17.95,0.25,0.3);
$pdf->setXY(0.7,17.7);
$pdf->Cell(2.7,0.7, "",1,1,"c" );

$pdf->setXY(3.4,17.7);
$pdf->Cell(8.0,0.7, "",1,1,"c" );

$pdf->setXY(11.4,17.7);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(12.4,17.7);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(13.4,17.7);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(14.6,17.7);
$pdf->Cell(2.5,0.7, "",1,1,"c" );

$pdf->setXY(17.1,17.7);
$pdf->Cell(3.0,0.7, "",1,1,"c" );

//6
$pdf->Image("img/pptt.jpg",3.4,18.65,0.25,0.3);
$pdf->setXY(0.7,18.4);
$pdf->Cell(2.7,0.7, "",1,1,"c" );

$pdf->setXY(3.4,18.4);
$pdf->Cell(8.0,0.7, "",1,1,"c" );

$pdf->setXY(11.4,18.4);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(12.4,18.4);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(13.4,18.4);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(14.6,18.4);
$pdf->Cell(2.5,0.7, "",1,1,"c" );

$pdf->setXY(17.1,18.4);
$pdf->Cell(3.0,0.7, "",1,1,"c" );

//1
$pdf->Image("img/pptt.jpg",3.4,19.35,0.25,0.3);
$pdf->setXY(0.7,19.1);
$pdf->Cell(2.7,0.7, "",1,1,"c" );

$pdf->setXY(3.4,19.1);
$pdf->Cell(8.0,0.7, "",1,1,"c" );

$pdf->setXY(11.4,19.1);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(12.4,19.1);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(13.4,19.1);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(14.6,19.1);
$pdf->Cell(2.5,0.7, "",1,1,"c" );

$pdf->setXY(17.1,19.1);
$pdf->Cell(3.0,0.7, "",1,1,"c" );

//2
$pdf->Image("img/pptt.jpg",3.4,20.05,0.25,0.3);
$pdf->setXY(0.7,19.8);
$pdf->Cell(2.7,0.7, "",1,1,"c" );

$pdf->setXY(3.4,19.8);
$pdf->Cell(8.0,0.7, "",1,1,"c" );

$pdf->setXY(11.4,19.8);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(12.4,19.8);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(13.4,19.8);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(14.6,19.8);
$pdf->Cell(2.5,0.7, "",1,1,"c" );

$pdf->setXY(17.1,19.8);
$pdf->Cell(3.0,0.7, "",1,1,"c" );

//3
$pdf->Image("img/pptt.jpg",3.4,20.75,0.25,0.3);
$pdf->setXY(0.7,20.5);
$pdf->Cell(2.7,0.7, "",1,1,"c" );

$pdf->setXY(3.4,20.5);
$pdf->Cell(8.0,0.7, "",1,1,"c" );

$pdf->setXY(11.4,20.5);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(12.4,20.5);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(13.4,20.5);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(14.6,20.5);
$pdf->Cell(2.5,0.7, "",1,1,"c" );

$pdf->setXY(17.1,20.5);
$pdf->Cell(3.0,0.7, "",1,1,"c" );

//4
$pdf->Image("img/pptt.jpg",3.4,21.45,0.25,0.3);
$pdf->setXY(0.7,21.2);
$pdf->Cell(2.7,0.7, "",1,1,"c" );

$pdf->setXY(3.4,21.2);
$pdf->Cell(8.0,0.7, "",1,1,"c" );

$pdf->setXY(11.4,21.2);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(12.4,21.2);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(13.4,21.2);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(14.6,21.2);
$pdf->Cell(2.5,0.7, "",1,1,"c" );

$pdf->setXY(17.1,21.2);
$pdf->Cell(3.0,0.7, "",1,1,"c" );

//5
$pdf->Image("img/pptt.jpg",3.4,22.15,0.25,0.3);
$pdf->setXY(0.7,21.9);
$pdf->Cell(2.7,0.7, "",1,1,"c" );

$pdf->setXY(3.4,21.9);
$pdf->Cell(8.0,0.7, "",1,1,"c" );

$pdf->setXY(11.4,21.9);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(12.4,21.9);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(13.4,21.9);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(14.6,21.9);
$pdf->Cell(2.5,0.7, "",1,1,"c" );

$pdf->setXY(17.1,21.9);
$pdf->Cell(3.0,0.7, "",1,1,"c" );

//6
$pdf->Image("img/pptt.jpg",3.4,22.85,0.25,0.3);
$pdf->setXY(0.7,22.6);
$pdf->Cell(2.7,0.7, "",1,1,"c" );

$pdf->setXY(3.4,22.6);
$pdf->Cell(8.0,0.7, "",1,1,"c" );

$pdf->setXY(11.4,22.6);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(12.4,22.6);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(13.4,22.6);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(14.6,22.6);
$pdf->Cell(2.5,0.7, "",1,1,"c" );

$pdf->setXY(17.1,22.6);
$pdf->Cell(3.0,0.7, "",1,1,"c" );

//6
$pdf->Image("img/pptt.jpg",3.4,23.55,0.25,0.3);
$pdf->setXY(0.7,23.3);
$pdf->Cell(2.7,0.7, "",1,1,"c" );

$pdf->setXY(3.4,23.3);
$pdf->Cell(8.0,0.7, "",1,1,"c" );

$pdf->setXY(11.4,23.3);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(12.4,23.3);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(13.4,23.3);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(14.6,23.3);
$pdf->Cell(2.5,0.7, "",1,1,"c" );

$pdf->setXY(17.1,23.3);
$pdf->Cell(3.0,0.7, "",1,1,"c" );

$pdf->setXY(1.3,24.6);
$pdf->Cell(0.4,0.4, "",1,1,"c" );
$pdf->SetFont('angsa','',13);
$pdf->setXY(1.9,24.45);
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "เฉพาะกรณีเป็นสินค้าสาธิตเท่านั้น" ),0,'L' );
$pdf->SetFont('angsa','',15);
$pdf->setXY(1.3,25.3);
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "ผู้อนุมัติ............................................" ),0,'L' );

$pdf->setXY(1.3,26.0);
$pdf->MultiCell(9.0, 0.6 , iconv( 'UTF-8','cp874' ,"(........................................................)"),0,'L' );

$pdf->setXY(1.2,24.5);
$pdf->Cell(5.5,2.5, "",1,1,"c" );


$pdf->setXY(7.8,25.3);
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "ผู้จ่ายสินค้า......................................." ),0,'L' );

$pdf->setXY(7.8,26.0);
$pdf->MultiCell(9.0, 0.6 , iconv( 'UTF-8','cp874' ,"(........................................................)"),0,'L' );

$pdf->setXY(14.8,25.3);
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "ผู้รับสินค้า......................................." ),0,'L' );

$pdf->setXY(14.8,26.0);
$pdf->MultiCell(9.0, 0.6 , iconv( 'UTF-8','cp874' ,"(........................................................)"),0,'L' );


$pdf->SetFont('angsa','',13);

$pdf->setXY( 1.0,27.0);
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "อนุมัติวันที่ 14 ธ.ค. 2565" ),0,'L' );


$pdf->setXY( 18.1,27.0);
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "FM-OF-07:Rev.6" ),0,'L' );

if($Num_Rows2 > '0'){
	
$pdf->AddPage();
$pdf->SetFont('angsana','B',18);

$pdf->Image("img/ecec.jpg",1.1,0.5,1.5,0.7);

/*$pdf->setXY(1.0,1.0);
$pdf->Cell(19.2,24.0, "",1,1,"c" );*/

$pdf->setXY(7.5,1.0);
$pdf->MultiCell(9,0.6, iconv( 'UTF-8','cp874' , "บันทึกรับ-จ่ายสินค้าจากคลังสินค้า"),0 ,'L' );
$pdf->setXY(8.0,1.7);
$pdf->MultiCell(10, 0.6, iconv( 'UTF-8','cp874' , "(In-Out Record of Goods)"),0 ,'L' );

$pdf->SetFont('angsana','B',14);

$pdf->setXY(17.0,1.2);
$pdf->MultiCell(10,0.6, iconv( 'UTF-8','cp874' , "เลขที่ :" ),0,'L' );

$pdf->setXY(18.0,1.7);
$pdf->Cell(2.0,0,'','T',0,'C',0);

$pdf->setXY(18.0,1.2);
$pdf->MultiCell(10,0.6, iconv( 'UTF-8','cp874' , "$iv_no" ),0,'L' );

$pdf->SetFont('angsa','',15);

$pdf->setXY(3.2,3.6);
$pdf->Cell(7.0,0,'','T',0,'C',0);

$pdf->setXY(12.3,3.6);
$pdf->Cell(6.0,0,'','T',0,'C',0);

$pdf->setXY(1.1,3.0);
$pdf->MultiCell(10,0.6, iconv( 'UTF-8','cp874' , "ชื่อผู้บันทึก :" ),0,'L' );

$pdf->setXY(3.2,3.0);
$pdf->MultiCell(10,0.6, iconv( 'UTF-8','cp874' , "$employee_name" ),0,'L' );

$pdf->setXY(11.1,3.0);
$pdf->MultiCell(10,0.6, iconv( 'UTF-8','cp874' , "วันที่ :" ),0,'L' );

$pdf->setXY(12.5,3.0);
$pdf->MultiCell(10,0.6, iconv( 'UTF-8','cp874' , "$stock_date" ),0,'L' );

$pdf->setXY(1.1,3.7);
$pdf->MultiCell(10,0.6, iconv( 'UTF-8','cp874' , "สาเหตุการบันทึก :" ),0,'L' );

$pdf->Image("img/pptt.jpg",4.15,3.85,0.25,0.3);

$pdf->setXY(4.5,3.7);
$pdf->MultiCell(10,0.6, iconv( 'UTF-8','cp874' , "รับสินค้าเข้าคลังสินค้า จากต่างประเทศ" ),0,'L' );

$pdf->Image("img/pptt.jpg",11.15,3.85,0.25,0.3);

$pdf->setXY(11.5,3.7);
$pdf->MultiCell(10,0.6, iconv( 'UTF-8','cp874' , "รับสินค้าเข้าคลังสินค้า จากในประเทศ" ),0,'L' );

$pdf->Image("img/pptt.jpg",4.15,4.45,0.25,0.3);

$pdf->setXY(4.5,4.3);
$pdf->MultiCell(10,0.6, iconv( 'UTF-8','cp874' , "เบิกเป็นสินค้าสาธิต" ),0,'L' );

$pdf->Image("img/pptt.jpg",11.15,4.45,0.25,0.3);

$pdf->setXY(11.5,4.3);
$pdf->MultiCell(10,0.6, iconv( 'UTF-8','cp874' , "เบิกเป็นสินค้าสำรองการใช้งาน" ),0,'L' );

$pdf->Image("img/pptt.jpg",4.15,5.05,0.25,0.3);

$pdf->setXY(4.5,4.9);
$pdf->MultiCell(10,0.6, iconv( 'UTF-8','cp874' , "เบิกสินค้าไปรวม/แยกชุดขาย" ),0,'L' );

$pdf->Image("img/pptt.jpg",11.15,5.05,0.25,0.3);

$pdf->setXY(11.5,4.9);
$pdf->MultiCell(10,0.6, iconv( 'UTF-8','cp874' , "อื่นๆ..........................................................................." ),0,'L' );

$pdf->SetFont('angsana','B',14);

$pdf->setXY(1.1,5.9);
$pdf->MultiCell(10,0.6, iconv( 'UTF-8','cp874' , "รับเข้า - จ่ายออก" ),0,'L' );

$pdf->SetFont('angsa','',15);

$pdf->setXY(1.1,6.5 );
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "รหัส Express" ),0,'L' );

$pdf->setXY(7.2,6.5 );
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "สินค้า" ),0,'L' );

$pdf->setXY(11.7,6.5 );
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "รับ" ),0,'L' );

$pdf->setXY(12.6,6.5 );
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "จ่าย" ),0,'L' );

$pdf->setXY(13.55,6.5 );
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "หน่วย" ),0,'L' );

$pdf->setXY(15.1,6.5 );
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "หมายเลข" ),0,'L' );

$pdf->setXY(17.75,6.5 );
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "หมายเหตุ" ),0,'L' );



$pdf->setX(7.2);
$pdf->MultiCell(2.0,0.5, iconv( 'UTF-8','cp874' , ""),0 ,'L' );


$i=1;
while($objResult2 = mysqli_fetch_array($objQuery2))
{

$unit_name  =$objResult2["unit_name"];
$product_name = $objResult2["sol_name"];
//$product_name = substr($product_name1,0,100);	
$count_send = $objResult2["count_send"];
$count_receive = $objResult2["count_receive"];
$stock_remark = $objResult2["stock_remark"];
$sn_number = $objResult2["sn_number"];

$pdf->SetFont('angsa','',11);
	
$pdf->setX(0.8);
$pdf->MultiCell(9.0,0, iconv( 'UTF-8','cp874' , "$express_code"),0 ,'L' );
	
	
$pdf->setX(3.7);
$pdf->MultiCell(9.0,0, iconv( 'UTF-8//IGNORE','cp874//IGNORE' , "$product_name"),0 ,'L' );

$pdf->SetFont('angsa','',13);
$pdf->setX(11.4);
$pdf->MultiCell(1.0,0, iconv( 'UTF-8','cp874' , "$count_receive"),0 ,'R' );
	
$pdf->setX(12.4);
$pdf->MultiCell(1.0,0, iconv( 'UTF-8','cp874' , "$count_send"),0 ,'R' );	

$pdf->setX(13.3);
$pdf->MultiCell(1.5,0, iconv( 'UTF-8','cp874' , "$unit_name"),0 ,'C' );

$pdf->setX(14.6);
$pdf->MultiCell(2.5,0, iconv( 'UTF-8','cp874' , "$sn_number"),0 ,'L' );

$pdf->setX(17.2);
$pdf->MultiCell(3.0,0, iconv( 'UTF-8','cp874' , "$stock_remark"),0 ,'L' );

$pdf->setX(18.3);
$pdf->MultiCell( 9.0,0.7, iconv( 'UTF-8','cp874' , ""),0 ,'L' );


$i++;


}

//1

$pdf->SetFont('angsa','',15);

$pdf->setXY(0.7,6.5);
$pdf->Cell(2.7,0.7, "",1,1,"c" );

$pdf->setXY(3.4,6.5);
$pdf->Cell(8.0,0.7, "",1,1,"c" );

$pdf->setXY(11.4,6.5);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(12.4,6.5);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(13.4,6.5);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(14.6,6.5);
$pdf->Cell(2.5,0.7, "",1,1,"c" );

$pdf->setXY(17.1,6.5);
$pdf->Cell(3.0,0.7, "",1,1,"c" );

//2

$pdf->Image("img/pptt.jpg",3.4,7.45,0.25,0.3);
$pdf->setXY(0.7,7.2);
$pdf->Cell(2.7,0.7, "",1,1,"c" );

$pdf->setXY(3.4,7.2);
$pdf->Cell(8.0,0.7, "",1,1,"c" );

$pdf->setXY(11.4,7.2);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(12.4,7.2);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(13.4,7.2);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(14.6,7.2);
$pdf->Cell(2.5,0.7, "",1,1,"c" );

$pdf->setXY(17.1,7.2);
$pdf->Cell(3.0,0.7, "",1,1,"c" );

//3

$pdf->Image("img/pptt.jpg",3.4,8.15,0.25,0.3);
$pdf->setXY(0.7,7.9);
$pdf->Cell(2.7,0.7, "",1,1,"c" );

$pdf->setXY(3.4,7.9);
$pdf->Cell(8.0,0.7, "",1,1,"c" );

$pdf->setXY(11.4,7.9);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(12.4,7.9);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(13.4,7.9);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(14.6,7.9);
$pdf->Cell(2.5,0.7, "",1,1,"c" );

$pdf->setXY(17.1,7.9);
$pdf->Cell(3.0,0.7, "",1,1,"c" );

//4
$pdf->Image("img/pptt.jpg",3.4,8.85,0.25,0.3);
$pdf->setXY(0.7,8.6);
$pdf->Cell(2.7,0.7, "",1,1,"c" );

$pdf->setXY(3.4,8.6);
$pdf->Cell(8.0,0.7, "",1,1,"c" );

$pdf->setXY(11.4,8.6);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(12.4,8.6);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(13.4,8.6);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(14.6,8.6);
$pdf->Cell(2.5,0.7, "",1,1,"c" );

$pdf->setXY(17.1,8.6);
$pdf->Cell(3.0,0.7, "",1,1,"c" );
//5
$pdf->Image("img/pptt.jpg",3.4,9.55,0.25,0.3);
$pdf->setXY(0.7,9.3);
$pdf->Cell(2.7,0.7, "",1,1,"c" );

$pdf->setXY(3.4,9.3);
$pdf->Cell(8.0,0.7, "",1,1,"c" );

$pdf->setXY(11.4,9.3);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(12.4,9.3);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(13.4,9.3);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(14.6,9.3);
$pdf->Cell(2.5,0.7, "",1,1,"c" );

$pdf->setXY(17.1,9.3);
$pdf->Cell(3.0,0.7, "",1,1,"c" );

//6
$pdf->Image("img/pptt.jpg",3.4,10.25,0.25,0.3);
$pdf->setXY(0.7,10.0);
$pdf->Cell(2.7,0.7, "",1,1,"c" );

$pdf->setXY(3.4,10.0);
$pdf->Cell(8.0,0.7, "",1,1,"c" );

$pdf->setXY(11.4,10.0);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(12.4,10.0);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(13.4,10.0);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(14.6,10.0);
$pdf->Cell(2.5,0.7, "",1,1,"c" );

$pdf->setXY(17.1,10.0);
$pdf->Cell(3.0,0.7, "",1,1,"c" );


//1
$pdf->Image("img/pptt.jpg",3.4,10.95,0.25,0.3);
$pdf->setXY(0.7,10.7);
$pdf->Cell(2.7,0.7, "",1,1,"c" );

$pdf->setXY(3.4,10.7);
$pdf->Cell(8.0,0.7, "",1,1,"c" );

$pdf->setXY(11.4,10.7);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(12.4,10.7);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(13.4,10.7);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(14.6,10.7);
$pdf->Cell(2.5,0.7, "",1,1,"c" );

$pdf->setXY(17.1,10.7);
$pdf->Cell(3.0,0.7, "",1,1,"c" );

//2
$pdf->Image("img/pptt.jpg",3.4,11.65,0.25,0.3);
$pdf->setXY(0.7,11.4);
$pdf->Cell(2.7,0.7, "",1,1,"c" );

$pdf->setXY(3.4,11.4);
$pdf->Cell(8.0,0.7, "",1,1,"c" );

$pdf->setXY(11.4,11.4);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(12.4,11.4);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(13.4,11.4);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(14.6,11.4);
$pdf->Cell(2.5,0.7, "",1,1,"c" );

$pdf->setXY(17.1,11.4);
$pdf->Cell(3.0,0.7, "",1,1,"c" );

//3
$pdf->Image("img/pptt.jpg",3.4,12.35,0.25,0.3);
$pdf->setXY(0.7,12.1);
$pdf->Cell(2.7,0.7, "",1,1,"c" );

$pdf->setXY(3.4,12.1);
$pdf->Cell(8.0,0.7, "",1,1,"c" );

$pdf->setXY(11.4,12.1);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(12.4,12.1);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(13.4,12.1);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(14.6,12.1);
$pdf->Cell(2.5,0.7, "",1,1,"c" );

$pdf->setXY(17.1,12.1);
$pdf->Cell(3.0,0.7, "",1,1,"c" );
//4
$pdf->Image("img/pptt.jpg",3.4,13.05,0.25,0.3);
$pdf->setXY(0.7,12.8);
$pdf->Cell(2.7,0.7, "",1,1,"c" );

$pdf->setXY(3.4,12.8);
$pdf->Cell(8.0,0.7, "",1,1,"c" );

$pdf->setXY(11.4,12.8);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(12.4,12.8);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(13.4,12.8);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(14.6,12.8);
$pdf->Cell(2.5,0.7, "",1,1,"c" );

$pdf->setXY(17.1,12.8);
$pdf->Cell(3.0,0.7, "",1,1,"c" );
//5
$pdf->Image("img/pptt.jpg",3.4,13.75,0.25,0.3);
$pdf->setXY(0.7,13.5);
$pdf->Cell(2.7,0.7, "",1,1,"c" );

$pdf->setXY(3.4,13.5);
$pdf->Cell(8.0,0.7, "",1,1,"c" );

$pdf->setXY(11.4,13.5);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(12.4,13.5);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(13.4,13.5);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(14.6,13.5);
$pdf->Cell(2.5,0.7, "",1,1,"c" );

$pdf->setXY(17.1,13.5);
$pdf->Cell(3.0,0.7, "",1,1,"c" );

//6
$pdf->Image("img/pptt.jpg",3.4,14.45,0.25,0.3);
$pdf->setXY(0.7,14.2);
$pdf->Cell(2.7,0.7, "",1,1,"c" );

$pdf->setXY(3.4,14.2);
$pdf->Cell(8.0,0.7, "",1,1,"c" );

$pdf->setXY(11.4,14.2);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(12.4,14.2);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(13.4,14.2);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(14.6,14.2);
$pdf->Cell(2.5,0.7, "",1,1,"c" );

$pdf->setXY(17.1,14.2);
$pdf->Cell(3.0,0.7, "",1,1,"c" );

//1
$pdf->Image("img/pptt.jpg",3.4,15.15,0.25,0.3);
$pdf->setXY(0.7,14.9);
$pdf->Cell(2.7,0.7, "",1,1,"c" );

$pdf->setXY(3.4,14.9);
$pdf->Cell(8.0,0.7, "",1,1,"c" );

$pdf->setXY(11.4,14.9);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(12.4,14.9);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(13.4,14.9);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(14.6,14.9);
$pdf->Cell(2.5,0.7, "",1,1,"c" );

$pdf->setXY(17.1,14.9);
$pdf->Cell(3.0,0.7, "",1,1,"c" );

//2
$pdf->Image("img/pptt.jpg",3.4,15.85,0.25,0.3);
$pdf->setXY(0.7,15.6);
$pdf->Cell(2.7,0.7, "",1,1,"c" );

$pdf->setXY(3.4,15.6);
$pdf->Cell(8.0,0.7, "",1,1,"c" );

$pdf->setXY(11.4,15.6);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(12.4,15.6);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(13.4,15.6);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(14.6,15.6);
$pdf->Cell(2.5,0.7, "",1,1,"c" );

$pdf->setXY(17.1,15.6);
$pdf->Cell(3.0,0.7, "",1,1,"c" );

//3
$pdf->Image("img/pptt.jpg",3.4,16.55,0.25,0.3);
$pdf->setXY(0.7,16.3);
$pdf->Cell(2.7,0.7, "",1,1,"c" );

$pdf->setXY(3.4,16.3);
$pdf->Cell(8.0,0.7, "",1,1,"c" );

$pdf->setXY(11.4,16.3);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(12.4,16.3);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(13.4,16.3);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(14.6,16.3);
$pdf->Cell(2.5,0.7, "",1,1,"c" );

$pdf->setXY(17.1,16.3);
$pdf->Cell(3.0,0.7, "",1,1,"c" );

//4
$pdf->Image("img/pptt.jpg",3.4,17.25,0.25,0.3);
$pdf->setXY(0.7,17.0);
$pdf->Cell(2.7,0.7, "",1,1,"c" );

$pdf->setXY(3.4,17.0);
$pdf->Cell(8.0,0.7, "",1,1,"c" );

$pdf->setXY(11.4,17.0);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(12.4,17.0);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(13.4,17.0);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(14.6,17.0);
$pdf->Cell(2.5,0.7, "",1,1,"c" );

$pdf->setXY(17.1,17.0);
$pdf->Cell(3.0,0.7, "",1,1,"c" );

//5
$pdf->Image("img/pptt.jpg",3.4,17.95,0.25,0.3);
$pdf->setXY(0.7,17.7);
$pdf->Cell(2.7,0.7, "",1,1,"c" );

$pdf->setXY(3.4,17.7);
$pdf->Cell(8.0,0.7, "",1,1,"c" );

$pdf->setXY(11.4,17.7);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(12.4,17.7);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(13.4,17.7);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(14.6,17.7);
$pdf->Cell(2.5,0.7, "",1,1,"c" );

$pdf->setXY(17.1,17.7);
$pdf->Cell(3.0,0.7, "",1,1,"c" );

//6
$pdf->Image("img/pptt.jpg",3.4,18.65,0.25,0.3);
$pdf->setXY(0.7,18.4);
$pdf->Cell(2.7,0.7, "",1,1,"c" );

$pdf->setXY(3.4,18.4);
$pdf->Cell(8.0,0.7, "",1,1,"c" );

$pdf->setXY(11.4,18.4);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(12.4,18.4);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(13.4,18.4);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(14.6,18.4);
$pdf->Cell(2.5,0.7, "",1,1,"c" );

$pdf->setXY(17.1,18.4);
$pdf->Cell(3.0,0.7, "",1,1,"c" );

//1
$pdf->Image("img/pptt.jpg",3.4,19.35,0.25,0.3);
$pdf->setXY(0.7,19.1);
$pdf->Cell(2.7,0.7, "",1,1,"c" );

$pdf->setXY(3.4,19.1);
$pdf->Cell(8.0,0.7, "",1,1,"c" );

$pdf->setXY(11.4,19.1);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(12.4,19.1);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(13.4,19.1);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(14.6,19.1);
$pdf->Cell(2.5,0.7, "",1,1,"c" );

$pdf->setXY(17.1,19.1);
$pdf->Cell(3.0,0.7, "",1,1,"c" );

//2
$pdf->Image("img/pptt.jpg",3.4,20.05,0.25,0.3);
$pdf->setXY(0.7,19.8);
$pdf->Cell(2.7,0.7, "",1,1,"c" );

$pdf->setXY(3.4,19.8);
$pdf->Cell(8.0,0.7, "",1,1,"c" );

$pdf->setXY(11.4,19.8);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(12.4,19.8);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(13.4,19.8);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(14.6,19.8);
$pdf->Cell(2.5,0.7, "",1,1,"c" );

$pdf->setXY(17.1,19.8);
$pdf->Cell(3.0,0.7, "",1,1,"c" );

//3
$pdf->Image("img/pptt.jpg",3.4,20.75,0.25,0.3);
$pdf->setXY(0.7,20.5);
$pdf->Cell(2.7,0.7, "",1,1,"c" );

$pdf->setXY(3.4,20.5);
$pdf->Cell(8.0,0.7, "",1,1,"c" );

$pdf->setXY(11.4,20.5);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(12.4,20.5);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(13.4,20.5);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(14.6,20.5);
$pdf->Cell(2.5,0.7, "",1,1,"c" );

$pdf->setXY(17.1,20.5);
$pdf->Cell(3.0,0.7, "",1,1,"c" );

//4
$pdf->Image("img/pptt.jpg",3.4,21.45,0.25,0.3);
$pdf->setXY(0.7,21.2);
$pdf->Cell(2.7,0.7, "",1,1,"c" );

$pdf->setXY(3.4,21.2);
$pdf->Cell(8.0,0.7, "",1,1,"c" );

$pdf->setXY(11.4,21.2);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(12.4,21.2);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(13.4,21.2);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(14.6,21.2);
$pdf->Cell(2.5,0.7, "",1,1,"c" );

$pdf->setXY(17.1,21.2);
$pdf->Cell(3.0,0.7, "",1,1,"c" );

//5
$pdf->Image("img/pptt.jpg",3.4,22.15,0.25,0.3);
$pdf->setXY(0.7,21.9);
$pdf->Cell(2.7,0.7, "",1,1,"c" );

$pdf->setXY(3.4,21.9);
$pdf->Cell(8.0,0.7, "",1,1,"c" );

$pdf->setXY(11.4,21.9);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(12.4,21.9);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(13.4,21.9);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(14.6,21.9);
$pdf->Cell(2.5,0.7, "",1,1,"c" );

$pdf->setXY(17.1,21.9);
$pdf->Cell(3.0,0.7, "",1,1,"c" );

//6
$pdf->Image("img/pptt.jpg",3.4,22.85,0.25,0.3);
$pdf->setXY(0.7,22.6);
$pdf->Cell(2.7,0.7, "",1,1,"c" );

$pdf->setXY(3.4,22.6);
$pdf->Cell(8.0,0.7, "",1,1,"c" );

$pdf->setXY(11.4,22.6);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(12.4,22.6);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(13.4,22.6);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(14.6,22.6);
$pdf->Cell(2.5,0.7, "",1,1,"c" );

$pdf->setXY(17.1,22.6);
$pdf->Cell(3.0,0.7, "",1,1,"c" );

//6
$pdf->Image("img/pptt.jpg",3.4,23.55,0.25,0.3);
$pdf->setXY(0.7,23.3);
$pdf->Cell(2.7,0.7, "",1,1,"c" );

$pdf->setXY(3.4,23.3);
$pdf->Cell(8.0,0.7, "",1,1,"c" );

$pdf->setXY(11.4,23.3);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(12.4,23.3);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(13.4,23.3);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(14.6,23.3);
$pdf->Cell(2.5,0.7, "",1,1,"c" );

$pdf->setXY(17.1,23.3);
$pdf->Cell(3.0,0.7, "",1,1,"c" );

$pdf->setXY(1.3,24.6);
$pdf->Cell(0.4,0.4, "",1,1,"c" );
$pdf->SetFont('angsa','',13);
$pdf->setXY(1.9,24.45);
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "เฉพาะกรณีเป็นสินค้าสาธิตเท่านั้น" ),0,'L' );
$pdf->SetFont('angsa','',15);
$pdf->setXY(1.3,25.3);
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "ผู้อนุมัติ............................................" ),0,'L' );

$pdf->setXY(1.3,26.0);
$pdf->MultiCell(9.0, 0.6 , iconv( 'UTF-8','cp874' ,"(........................................................)"),0,'L' );

$pdf->setXY(1.2,24.5);
$pdf->Cell(5.5,2.5, "",1,1,"c" );


$pdf->setXY(7.8,25.3);
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "ผู้จ่ายสินค้า......................................." ),0,'L' );

$pdf->setXY(7.8,26.0);
$pdf->MultiCell(9.0, 0.6 , iconv( 'UTF-8','cp874' ,"(........................................................)"),0,'L' );

$pdf->setXY(14.8,25.3);
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "ผู้รับสินค้า......................................." ),0,'L' );

$pdf->setXY(14.8,26.0);
$pdf->MultiCell(9.0, 0.6 , iconv( 'UTF-8','cp874' ,"(........................................................)"),0,'L' );


$pdf->SetFont('angsa','',13);

$pdf->setXY( 1.0,27.0);
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "อนุมัติวันที่ 14 ธ.ค. 2565" ),0,'L' );


$pdf->setXY( 18.1,27.0);
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "FM-OF-07:Rev.6" ),0,'L' );
	
	
}

$pdf->Output();
?>



