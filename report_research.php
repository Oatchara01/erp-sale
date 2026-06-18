
<?php
define('FPDF_FONTPATH','font/');

require('fpdf.php');

$iv_number =$_GET["running_id"];

	include "dbconnect_cs.php";

$strSQL = "SELECT * from tb_research  WHERE  running_id = '".$iv_number."' ";
$objQuery = mysqli_query($com1,$strSQL)or die ("Error Query [".$strSQL."]");;
$objResult = mysqli_fetch_array($objQuery);



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





$running_id=$objResult["running_id"];
$date_research=DateThai($objResult["date_research"]);
$customer_name  =$objResult["customer_name"];
$customer_tel  =$objResult["customer_tel"];
$iv_number  =$objResult["iv_number"];
$team_send  =$objResult["team_send"];
$employee_code  =$objResult["employee_code"];
$sale_neat  =$objResult["sale_neat"];
$sale_data  =$objResult["sale_data"];
$sale_3  =$objResult["sale_3"];
$sale_4  =$objResult["sale_4"];
$product_good  =$objResult["product_good"];
$product_link  =$objResult["product_link"];
$product_corect  =$objResult["product_corect"];
$cs_neat  =$objResult["cs_neat"];
$cs_explain  =$objResult["cs_explain"];
$cs_3 =$objResult["cs_3"];
$cs_4 =$objResult["cs_4"];
$cs_5 =$objResult["cs_5"];
$suggest  =$objResult["suggest"];
$problem  =$objResult["problem"];
$suggest_1  =$objResult["suggest_1"];
$suggest_2  =$objResult["suggest_2"];
$problem_1  =$objResult["problem_1"];
$employee_send  =$objResult["employee_send"];
if($objResult["employee_date"]=='0000-00-00'){
$employee_date = '-';	
}else{
$employee_date = DateThai($objResult["employee_date"]);
}	
	
$customer_receive  =$objResult["customer_receive"];
if($objResult["customer_date"]=='0000-00-00'){
$customer_date  = "-";	
}else{
$customer_date = DateThai($objResult["customer_date"]);
}
$product_name  =$objResult["product_name"];


$pdf=new FPDF( 'P' , 'cm' , 'A4' );
$pdf->AddFont('angsa','','angsa.php');
$pdf->AddFont('angsana','B','angsab.php');
 
$pdf->AddPage();
$pdf->SetFont('angsana','BU',18);
$pdf->Image("img/allwell_logo.png",7.8,0.5,5.0,1.5);
$pdf->Image("img/SGS_ISO 9001_with_UKAS_TCL_HR.jpg",16.5,0.7,3.5,1.7);

$pdf->setXY(2.8,2.5);
$pdf->MultiCell( 20,0.6, iconv( 'UTF-8','cp874' , "แบบสำรวจความพึงพอใจหลังการขาย   (Customer's Satisfaction Questionnaire after sale)"),0 ,'L' );

/*$pdf->setXY(4.2,3.5);
$pdf->MultiCell( 15,0.6, iconv( 'UTF-8','cp874' , "(Customer's Satisfaction Questionnaire after sale)"),0 ,'L' );*/



$pdf->SetFont('angsa','',16);



$pdf->setXY(3.1,4.2);
$pdf->Cell(5.5,0,'','T',0,'C',0);

$pdf->setXY(1.2,3.6);
$pdf->MultiCell(5,0.6, iconv( 'UTF-8','cp874' , "ชื่อลูกค้า :" ),0,'L' );

$pdf->SetFont('angsa','',12);
$pdf->setXY(3.1,3.6);
$pdf->MultiCell(8.0, 0.6 , iconv( 'UTF-8','cp874' , "$customer_name" ),0,'L' );

$pdf->SetFont('angsa','',16);

$pdf->setXY(10.5,4.2);
$pdf->Cell(5.0,0,'','T',0,'C',0);

$pdf->setXY(8.8,3.6);
$pdf->MultiCell(5,0.6, iconv( 'UTF-8','cp874' , "โทรศัพท์ :" ),0,'L' );

$pdf->setXY(10.5,3.6);
$pdf->MultiCell( 5  , 0.6 , iconv( 'UTF-8','cp874' , "$customer_tel" ),0,'L' );




$pdf->setXY(17.0,4.2);
$pdf->Cell(3.0,0,'','T',0,'C',0);

$pdf->setXY(16.0,3.6);
$pdf->MultiCell(5,0.6, iconv( 'UTF-8','cp874' , "วันที่ :" ),0,'L' );

$pdf->setXY(17.0,3.6);
$pdf->MultiCell( 5  , 0.6 , iconv( 'UTF-8','cp874' , "$date_research" ),0,'L' );


$pdf->setXY(3.1,4.9);
$pdf->Cell(5.5,0,'','T',0,'C',0);

$pdf->setXY(1.2,4.3);
$pdf->MultiCell(5,0.6, iconv( 'UTF-8','cp874' , "เลขที่ IV :" ),0,'L' );

$pdf->setXY(3.1,4.3);
$pdf->MultiCell( 5  , 0.6 , iconv( 'UTF-8','cp874' , "$iv_number" ),0,'L' );



$pdf->setXY(10.5,4.9);
$pdf->Cell(5.0,0,'','T',0,'C',0);

$pdf->setXY(8.8,4.3);
$pdf->MultiCell(5,0.6, iconv( 'UTF-8','cp874' , "ทีมจัดส่ง :" ),0,'L' );

$pdf->setXY(10.5,4.3);
$pdf->MultiCell( 5  , 0.6 , iconv( 'UTF-8','cp874' , "$team_send" ),0,'L' );


$pdf->setXY(3.1,5.55);
$pdf->Cell(17.0,0,'','T',0,'C',0);
$pdf->setXY(3.1,6.1);
$pdf->Cell(17.0,0,'','T',0,'C',0);
$pdf->setXY(1.2,5.0);
$pdf->MultiCell(5,0.6, iconv( 'UTF-8','cp874' , "สินค้า :" ),0,'L' );
$pdf->SetFont('angsa','',14);
$pdf->setXY(3.1,5.0);
$pdf->MultiCell( 17.0, 0.6 , iconv( 'UTF-8','cp874' , "$product_name" ),0,'L' );

$pdf->SetFont('angsa','',16);
$pdf->setXY(1.2,6.2);
$pdf->MultiCell(19.0,0.6, iconv( 'UTF-8','cp874' , "โปรดใส่เครื่องหมาย      ลงในช่องที่ท่านเห็นด้วย" ),0,'L' );

$pdf->Image("img/23012019.png",4.5,6.3,0.35,0.35);

$pdf->setXY(1.2,6.7);
$pdf->MultiCell(19.0,0.6, iconv( 'UTF-8','cp874' , "(คะแนนการประเมิน มากที่สุด = 5, มาก = 4, ปานกลาง = 3, น้อย = 2, น้อยที่สุด = 1)" ),0,'L' );

$pdf->SetFont('angsana','B',14);

$pdf->setXY(1.2,7.3);
$pdf->MultiCell(19.0,0.6, iconv( 'UTF-8','cp874' , "ส่วนที่ 1 ความพึงพอใจต่อพนักงานขาย" ),0,'L' );




$pdf->SetFont('angsa','',14);

$pdf->setXY(1.0,7.9);
$pdf->Cell(0.9,0.6,  "" ,1,'C');
$pdf->setXY(1.0,7.9);
$pdf->Cell(0.9,0.6, iconv( 'UTF-8','cp874' , "ลำดับ" ),0,'C');

$pdf->setXY(1.0,8.5);
$pdf->Cell(0.9,0.6,"" ,1,'C');
$pdf->setXY(1.3,8.5);
$pdf->Cell(0.9,0.6, iconv( 'UTF-8','cp874' , "1" ),0,'C');

$pdf->setXY(1.0,9.1);
$pdf->Cell(0.9,0.6,"" ,1,'C');
$pdf->setXY(1.3,9.1);
$pdf->Cell(0.9,0.6, iconv( 'UTF-8','cp874' , "2" ),0,'C');

$pdf->setXY(1.0,9.7);
$pdf->Cell(0.9,0.6,"" ,1,'C');
$pdf->setXY(1.3,9.7);
$pdf->Cell(0.9,0.6, iconv( 'UTF-8','cp874' , "3" ),0,'C');

$pdf->setXY(1.0,10.3);
$pdf->Cell(0.9,0.6,"" ,1,'C');
$pdf->setXY(1.3,10.3);
$pdf->Cell(0.9,0.6, iconv( 'UTF-8','cp874' , "4" ),0,'C');





$pdf->setXY(1.9,7.9);
$pdf->Cell(10.0,0.6,'',1,'C',1);
$pdf->setXY(6.0,7.9);
$pdf->Cell(0.9,0.6, iconv( 'UTF-8','cp874' , "รายละเอียด" ),0,'C');



$pdf->setXY(1.9,8.5);
$pdf->Cell(10.0,0.6,'',1,'C',1);
$pdf->setXY(2.0,8.5);
$pdf->Cell(0.9,0.6, iconv( 'UTF-8','cp874' , "พนักงานขายกิริยามารยาทเรียบร้อย พูดจาสุภาพ อัธยาศัยดี วางตัวเหมาะสม" ),0,'C');

$pdf->setXY(1.9,9.1);
$pdf->Cell(10.0,0.6,'',1,'C',1);
$pdf->SetFont('angsa','',12);
$pdf->setXY(2.0,9.1);
$pdf->Cell(0.9,0.6, iconv( 'UTF-8','cp874' , "พนักงานขายมีความรุ้ความชำนาญในตัวสินค้า สามารถแนะนำ ตอบข้อซักถามได้ชัดเจน" ),0,'C');

$pdf->SetFont('angsa','',14);

$pdf->setXY(1.9,9.7);
$pdf->Cell(10.0,0.6,'',1,'C',1);
$pdf->setXY(2.0,9.7);
$pdf->Cell(0.9,0.6, iconv( 'UTF-8','cp874' , "พนักงานขายบริการด้วยความรวดเร็ว/เอาใจใส่ และมีความเต็มใจให้บริการ" ),0,'C');

$pdf->setXY(1.9,10.3);
$pdf->Cell(10.0,0.6,'',1,'C',1);
$pdf->setXY(2.0,10.3);
$pdf->Cell(0.9,0.6, iconv( 'UTF-8','cp874' , "การติดต่อพนักงานขายในช่องทางต่างๆ รวดเร็ว และมีประสิทธิภาพ" ),0,'C');




$pdf->setXY(11.9,7.9);
$pdf->Cell(1.6,0.6,'',1,'C',1);

$pdf->setXY(12.0,7.9);
$pdf->Cell(0.9,0.6, iconv( 'UTF-8','cp874' , "มากที่สุด" ),0,'C');


$pdf->setXY(11.9,8.5);
$pdf->Cell(1.6,0.6,'',1,'C',1);

if($sale_neat=="5")
{
$pdf->Image("img/23012019.png",12.5,8.6,0.35,0.35);
}

$pdf->setXY(11.9,9.1);
$pdf->Cell(1.6,0.6,'',1,'C',1);


if($sale_data=="5")
{
	$pdf->Image("img/23012019.png",12.5,9.2,0.35,0.35);
}
$pdf->setXY(11.9,9.7);
$pdf->Cell(1.6,0.6,'',1,'C',1);


if($sale_3=="5")
{
	$pdf->Image("img/23012019.png",12.5,9.8,0.35,0.35);
}

$pdf->setXY(11.9,10.3);
$pdf->Cell(1.6,0.6,'',1,'C',1);
if($sale_3=="5")
{
	$pdf->Image("img/23012019.png",12.5,10.4,0.35,0.35);
}





$pdf->setXY(13.5,7.9);
$pdf->Cell(1.6,0.6,'',1,'C',1);
$pdf->setXY(13.9,7.9);
$pdf->Cell(0.9,0.6, iconv( 'UTF-8','cp874' , "มาก" ),0,'C');

$pdf->setXY(13.5,8.5);
$pdf->Cell(1.6,0.6,'',1,'C',1);
if($sale_neat=="4")
{
$pdf->Image("img/23012019.png",14.1,8.6,0.35,0.35);
}

$pdf->setXY(13.5,9.1);
$pdf->Cell(1.6,0.6,'',1,'C',1);
if($sale_data=="4")
{
$pdf->Image("img/23012019.png",14.1,9.2,0.35,0.35);
}

$pdf->setXY(13.5,9.7);
$pdf->Cell(1.6,0.6,'',1,'C',1);
if($sale_3=="4")
{
$pdf->Image("img/23012019.png",14.1,9.8,0.35,0.35);
}

$pdf->setXY(13.5,10.3);
$pdf->Cell(1.6,0.6,'',1,'C',1);
if($sale_4=="4")
{
$pdf->Image("img/23012019.png",14.1,10.4,0.35,0.35);
}




$pdf->setXY(15.1,7.9);
$pdf->Cell(1.6,0.6,'',1,'C',1);
$pdf->setXY(15.2,7.9);
$pdf->Cell(0.9,0.6, iconv( 'UTF-8','cp874' , "ปานกลาง" ),0,'C');

$pdf->setXY(15.1,8.5);
$pdf->Cell(1.6,0.6,'',1,'C',1);
if($sale_neat=="3")
{
$pdf->Image("img/23012019.png",15.7,8.6,0.35,0.35);
}
$pdf->setXY(15.1,9.1);
$pdf->Cell(1.6,0.6,'',1,'C',1);

if($sale_data=="3")
{
$pdf->Image("img/23012019.png",15.7,9.2,0.35,0.35);
}

$pdf->setXY(15.1,9.7);
$pdf->Cell(1.6,0.6,'',1,'C',1);

if($sale_3=="3")
{
$pdf->Image("img/23012019.png",15.7,9.8,0.35,0.35);
}

$pdf->setXY(15.1,10.3);
$pdf->Cell(1.6,0.6,'',1,'C',1);

if($sale_4=="3")
{
$pdf->Image("img/23012019.png",15.7,10.4,0.35,0.35);
}




//น้อย
$pdf->setXY(16.7,7.9);
$pdf->Cell(1.6,0.6,'',1,'C',1);
$pdf->setXY(17.1,7.9);
$pdf->Cell(0.9,0.6, iconv( 'UTF-8','cp874' , "น้อย" ),0,'C');

$pdf->setXY(16.7,8.5);
$pdf->Cell(1.6,0.6,'',1,'C',1);
if($sale_neat=="2")
{
$pdf->Image("img/23012019.png",17.2,8.6,0.35,0.35);
}

$pdf->setXY(16.7,9.1);
$pdf->Cell(1.6,0.6,'',1,'C',1);
if($sale_data=="2")
{
$pdf->Image("img/23012019.png",17.2,9.2,0.35,0.35);
} 

$pdf->setXY(16.7,9.7);
$pdf->Cell(1.6,0.6,'',1,'C',1);
if($sale_3=="2")
{
$pdf->Image("img/23012019.png",17.2,9.8,0.35,0.35);
} 

$pdf->setXY(16.7,10.3);
$pdf->Cell(1.6,0.6,'',1,'C',1);
if($sale_4=="2")
{
$pdf->Image("img/23012019.png",17.2,10.4,0.35,0.35);
} 



//น้อยที่สุด
$pdf->setXY(18.3,7.9);
$pdf->Cell(1.7,0.6,'',1,'C',1);
$pdf->setXY(18.4,7.9);
$pdf->Cell(0.9,0.6, iconv( 'UTF-8','cp874' , "น้อยที่สุด" ),0,'C');

$pdf->setXY(18.3,8.5);
$pdf->Cell(1.7,0.6,'',1,'C',1);
if($sale_neat=="1")
{
$pdf->Image("img/23012019.png",18.8,8.6,0.35,0.35);
} 

$pdf->setXY(18.3,9.1);
$pdf->Cell(1.7,0.6,'',1,'C',1);
if($sale_data=="1")
{
$pdf->Image("img/23012019.png",18.8,9.2,0.35,0.35);
} 


$pdf->setXY(18.3,9.7);
$pdf->Cell(1.7,0.6,'',1,'C',1);
if($sale_3=="1")
{
$pdf->Image("img/23012019.png",18.8,9.8,0.35,0.35);
} 

$pdf->setXY(18.3,10.3);
$pdf->Cell(1.7,0.6,'',1,'C',1);
if($sale_4=="1")
{
$pdf->Image("img/23012019.png",18.8,10.4,0.35,0.35);
} 


$pdf->setXY(1.0,11.1);
$pdf->Cell(19,1.2,'',1,'C',1);

$pdf->setXY(1.2,11.1);
$pdf->Cell(0.9,0.6, iconv( 'UTF-8','cp874' , "ข้อเสนอแนะอื่นๆ" ),0,'C');

$pdf->setXY(1.2,11.6);
$pdf->MultiCell(18.0,0.6, iconv( 'UTF-8','cp874' , "$suggest $problem" ),0,'L');


$pdf->setXY(1.1,12.15);
$pdf->Cell(18.6,0,'','T',0,'C',0);






$pdf->SetFont('angsana','B',14);

$pdf->setXY(1.2,12.4);
$pdf->MultiCell(19.0,0.6, iconv( 'UTF-8','cp874' , "ส่วนที่ 2 ความพึงพอใจต่อสิน้คา / ผลิตภัณฑ์" ),0,'L' );




$pdf->SetFont('angsa','',14);

$pdf->setXY(1.0,12.95);
$pdf->Cell(0.9,0.6,  "" ,1,'C');
$pdf->setXY(1.0,12.95);
$pdf->Cell(0.9,0.6, iconv( 'UTF-8','cp874' , "ลำดับ" ),0,'C');

$pdf->setXY(1.0,13.55);
$pdf->Cell(0.9,0.6,"" ,1,'C');
$pdf->setXY(1.3,13.55);
$pdf->Cell(0.9,0.6, iconv( 'UTF-8','cp874' , "1" ),0,'C');

$pdf->setXY(1.0,14.15);
$pdf->Cell(0.9,0.6,"" ,1,'C');
$pdf->setXY(1.3,14.15);
$pdf->Cell(0.9,0.6, iconv( 'UTF-8','cp874' , "2" ),0,'C');

$pdf->setXY(1.0,14.75);
$pdf->Cell(0.9,0.6,"" ,1,'C');
$pdf->setXY(1.3,14.75);
$pdf->Cell(0.9,0.6, iconv( 'UTF-8','cp874' , "3" ),0,'C');


$pdf->setXY(1.9,12.95);
$pdf->Cell(10.0,0.6,'',1,'C',1);
$pdf->setXY(6.0,12.95);
$pdf->Cell(0.9,0.6, iconv( 'UTF-8','cp874' , "รายละเอียด" ),0,'C');



$pdf->setXY(1.9,13.55);
$pdf->Cell(10.0,0.6,'',1,'C',1);
$pdf->setXY(2.0,13.55);
$pdf->Cell(0.9,0.6, iconv( 'UTF-8','cp874' , "สินค้ามีคุณภาพ และสามารถใช้งานได้อย่างมีประสิทธิภาพ" ),0,'C');

$pdf->setXY(1.9,14.15);
$pdf->Cell(10.0,0.6,'',1,'C',1);
$pdf->setXY(2.0,14.15);
$pdf->Cell(0.9,0.6, iconv( 'UTF-8','cp874' , "สินค้าตรงกับความต้องการของลูกค้า" ),0,'C');


$pdf->setXY(1.9,14.75);
$pdf->Cell(10.0,0.6,'',1,'C',1);
$pdf->setXY(2.0,14.75);
$pdf->Cell(0.9,0.6, iconv( 'UTF-8','cp874' , "ความพึงพอใจในสินค้า" ),0,'C');


$pdf->setXY(11.9,12.95);
$pdf->Cell(1.6,0.6,'',1,'C',1);

$pdf->setXY(12.0,12.95);
$pdf->Cell(0.9,0.6, iconv( 'UTF-8','cp874' , "มากที่สุด" ),0,'C');


$pdf->setXY(11.9,13.55);
$pdf->Cell(1.6,0.6,'',1,'C',1);

if($product_good=="5")
{
$pdf->Image("img/23012019.png",12.5,13.65,0.35,0.35);
}

$pdf->setXY(11.9,14.15);
$pdf->Cell(1.6,0.6,'',1,'C',1);


if($product_link=="5")
{
	$pdf->Image("img/23012019.png",12.5,14.25,0.35,0.35);
}

$pdf->setXY(11.9,14.75);
$pdf->Cell(1.6,0.6,'',1,'C',1);


if($product_corect=="5")
{
	$pdf->Image("img/23012019.png",12.5,14.85,0.35,0.35);
}






$pdf->setXY(13.5,12.95);
$pdf->Cell(1.6,0.6,'',1,'C',1);
$pdf->setXY(13.9,12.95);
$pdf->Cell(0.9,0.6, iconv( 'UTF-8','cp874' , "มาก" ),0,'C');

$pdf->setXY(13.5,13.55);
$pdf->Cell(1.6,0.6,'',1,'C',1);
if($product_good=="4")
{
$pdf->Image("img/23012019.png",14.1,13.65,0.35,0.35);
}

$pdf->setXY(13.5,14.15);
$pdf->Cell(1.6,0.6,'',1,'C',1);
if($product_link=="4")
{
$pdf->Image("img/23012019.png",14.1,14.25,0.35,0.35);
}

$pdf->setXY(13.5,14.75);
$pdf->Cell(1.6,0.6,'',1,'C',1);
if($product_corect=="4")
{
$pdf->Image("img/23012019.png",14.1,14.85,0.35,0.35);
}



$pdf->setXY(15.1,12.95);
$pdf->Cell(1.6,0.6,'',1,'C',1);
$pdf->setXY(15.2,12.95);
$pdf->Cell(0.9,0.6, iconv( 'UTF-8','cp874' , "ปานกลาง" ),0,'C');

$pdf->setXY(15.1,13.55);
$pdf->Cell(1.6,0.6,'',1,'C',1);
if($product_good=="3")
{
$pdf->Image("img/23012019.png",15.7,13.65,0.35,0.35);
}
$pdf->setXY(15.1,14.15);
$pdf->Cell(1.6,0.6,'',1,'C',1);

if($product_link=="3")
{
$pdf->Image("img/23012019.png",15.7,14.25,0.35,0.35);
}

$pdf->setXY(15.1,14.75);
$pdf->Cell(1.6,0.6,'',1,'C',1);

if($product_corect=="3")
{
$pdf->Image("img/23012019.png",15.7,14.85,0.35,0.35);
}


//น้อย
$pdf->setXY(16.7,12.95);
$pdf->Cell(1.6,0.6,'',1,'C',1);
$pdf->setXY(17.1,12.95);
$pdf->Cell(0.9,0.6, iconv( 'UTF-8','cp874' , "น้อย" ),0,'C');

$pdf->setXY(16.7,13.55);
$pdf->Cell(1.6,0.6,'',1,'C',1);
if($product_good=="2")
{
$pdf->Image("img/23012019.png",17.2,13.55,0.35,0.35);
}

$pdf->setXY(16.7,14.15);
$pdf->Cell(1.6,0.6,'',1,'C',1);
if($product_link=="2")
{
$pdf->Image("img/23012019.png",17.2,14.25,0.35,0.35);
} 

$pdf->setXY(16.7,14.75);
$pdf->Cell(1.6,0.6,'',1,'C',1);
if($product_corect=="2")
{
$pdf->Image("img/23012019.png",17.2,14.85,0.35,0.35);
} 



//น้อยที่สุด
$pdf->setXY(18.3,12.95);
$pdf->Cell(1.7,0.6,'',1,'C',1);
$pdf->setXY(18.4,12.95);
$pdf->Cell(0.9,0.6, iconv( 'UTF-8','cp874' , "น้อยที่สุด" ),0,'C');

$pdf->setXY(18.3,13.55);
$pdf->Cell(1.7,0.6,'',1,'C',1);
if($product_good=="1")
{
$pdf->Image("img/23012019.png",18.8,13.65,0.35,0.35);
} 

$pdf->setXY(18.3,14.15);
$pdf->Cell(1.7,0.6,'',1,'C',1);

if($product_link=="1")
{
$pdf->Image("img/23012019.png",18.8,14.25,0.35,0.35);
} 

$pdf->setXY(18.3,14.75);
$pdf->Cell(1.7,0.6,'',1,'C',1);

if($product_corect=="1")
{
$pdf->Image("img/23012019.png",18.8,14.85,0.35,0.35);
} 



$pdf->setXY(1.0,15.6);
$pdf->Cell(19,1.2,'',1,'C',1);

$pdf->setXY(1.2,15.6);
$pdf->Cell(0.9,0.6, iconv( 'UTF-8','cp874' , "ข้อเสนอแนะอื่นๆ" ),0,'C');

$pdf->setXY(1.2,16.1);
$pdf->MultiCell(18.0,0.6, iconv( 'UTF-8','cp874' , "$suggest_1" ),0,'L');


$pdf->setXY(1.1,16.65);
$pdf->Cell(18.6,0,'','T',0,'C',0);




$pdf->SetFont('angsana','B',14);

$pdf->setXY(1.2,16.9);
$pdf->MultiCell(19.0,0.6, iconv( 'UTF-8','cp874' , "ส่วนที่ 3 ความพึงพอใจต่อพนักงานผู้ติดตั้ง / สาธิต เตียงปรับไฟฟ้า" ),0,'L' );




$pdf->SetFont('angsa','',14);

$pdf->setXY(1.0,17.45);
$pdf->Cell(0.9,0.6,  "" ,1,'C');
$pdf->setXY(1.0,17.45);
$pdf->Cell(0.9,0.6, iconv( 'UTF-8','cp874' , "ลำดับ" ),0,'C');

$pdf->setXY(1.0,18.05);
$pdf->Cell(0.9,0.6,"" ,1,'C');
$pdf->setXY(1.3,18.05);
$pdf->Cell(0.9,0.6, iconv( 'UTF-8','cp874' , "1" ),0,'C');

$pdf->setXY(1.0,18.65);
$pdf->Cell(0.9,0.9,"" ,1,'C');
$pdf->setXY(1.3,18.65);
$pdf->Cell(0.9,0.6, iconv( 'UTF-8','cp874' , "2" ),0,'C');

$pdf->setXY(1.0,19.55);
$pdf->Cell(0.9,0.9,"" ,1,'C');
$pdf->setXY(1.3,19.55);
$pdf->Cell(0.9,0.6, iconv( 'UTF-8','cp874' , "3" ),0,'C');

$pdf->setXY(1.0,20.45);
$pdf->Cell(0.9,0.9,"" ,1,'C');
$pdf->setXY(1.3,20.45);
$pdf->Cell(0.9,0.6, iconv( 'UTF-8','cp874' , "4" ),0,'C');

$pdf->setXY(1.0,21.35);
$pdf->Cell(0.9,0.6,"" ,1,'C');
$pdf->setXY(1.3,21.35);
$pdf->Cell(0.9,0.6, iconv( 'UTF-8','cp874' , "5" ),0,'C');



$pdf->setXY(1.9,17.45);
$pdf->Cell(10.0,0.6,'',1,'C',1);
$pdf->setXY(6.0,17.45);
$pdf->Cell(0.9,0.6, iconv( 'UTF-8','cp874' , "รายละเอียด" ),0,'C');


$pdf->SetFont('angsa','',13);
$pdf->setXY(1.9,18.05);
$pdf->Cell(10.0,0.6,'',1,'C',1);
$pdf->setXY(2.0,18.05);
$pdf->Cell(0.9,0.6, iconv( 'UTF-8','cp874' , "พนักงานจัดส่งมีกิริยามารยาทเรียบร้อย พูดจาสุภาพ อัธยาศัยดี วางตัวเหมาะสม" ),0,'C');

$pdf->SetFont('angsa','',13);
$pdf->setXY(1.9,18.65);
$pdf->Cell(10.0,0.9,'',1,'C',1);
$pdf->setXY(2.0,18.65);
$pdf->MultiCell(10.0,0.42, iconv( 'UTF-8','cp874' , "พนักงานจัดส่งมีความรู้ความชำนาญในสินค้า สามารถอธิบาย สาธิตวิธีการใช้งาน และตอบข้อซักถามได้ชัดเจน" ),0,'L');

$pdf->setXY(1.9,19.55);
$pdf->Cell(10.0,0.9,'',1,'C',1);

$pdf->setXY(2.0,19.55);
$pdf->MultiCell(10,0.42, iconv( 'UTF-8','cp874' , "พนักงานจัดส่งดูแลสินค้า รวมถึงกระบวนการขนย้ายสินค้าเข้าติดตั้ง ณ สถานที่ใช้งานเป็นอย่างดี" ),0,'L');

$pdf->setXY(1.9,20.45);
$pdf->Cell(10.0,0.9,'',1,'C',1);
$pdf->setXY(2.0,20.45);
$pdf->MultiCell(9.6,0.42, iconv( 'UTF-8','cp874' , "พนักงานจัดส่งสินค้าโทรประสานงานก่อนส่งสินค้าจริงและส่งมอบสินค้าตามเวลาที่ได้นัดหมายไว้" ),0,'L');

$pdf->SetFont('angsa','',13);
$pdf->setXY(1.9,21.35);
$pdf->Cell(10.0,0.6,'',1,'C',1);
$pdf->setXY(2.0,21.35);
$pdf->MultiCell(13,0.6, iconv( 'UTF-8','cp874' , "มาตรฐานการขนส่งของพนักงานจัดส่ง เมื่อเทียบกับบริษัทอื่นๆ" ),0,'L');

$pdf->SetFont('angsa','',14);
$pdf->setXY(11.9,17.45);
$pdf->Cell(1.6,0.6,'',1,'C',1);

$pdf->setXY(12.0,17.45);
$pdf->Cell(0.9,0.6, iconv( 'UTF-8','cp874' , "มากที่สุด" ),0,'C');


$pdf->setXY(11.9,18.05);
$pdf->Cell(1.6,0.6,'',1,'C',1);

if($cs_neat=="5")
{
$pdf->Image("img/23012019.png",12.5,18.15,0.35,0.35);
}

$pdf->setXY(11.9,18.65);
$pdf->Cell(1.6,0.9,'',1,'C',1);


if($cs_explain=="5")
{
	$pdf->Image("img/23012019.png",12.5,18.75,0.35,0.35);
}

$pdf->setXY(11.9,19.55);
$pdf->Cell(1.6,0.9,'',1,'C',1);


if($cs_3=="5")
{
	$pdf->Image("img/23012019.png",12.5,19.65,0.35,0.35);
}

$pdf->setXY(11.9,20.45);
$pdf->Cell(1.6,0.9,'',1,'C',1);
if($cs_4=="5")
{
	$pdf->Image("img/23012019.png",12.5,20.55,0.35,0.35);
}

$pdf->setXY(11.9,21.35);
$pdf->Cell(1.6,0.6,'',1,'C',1);
if($cs_5=="5")
{
	$pdf->Image("img/23012019.png",12.5,21.45,0.35,0.35);
}


$pdf->setXY(13.5,17.45);
$pdf->Cell(1.6,0.6,'',1,'C',1);
$pdf->setXY(13.9,17.45);
$pdf->Cell(0.9,0.6, iconv( 'UTF-8','cp874' , "มาก" ),0,'C');

$pdf->setXY(13.5,18.05);
$pdf->Cell(1.6,0.6,'',1,'C',1);
if($cs_neat=="4")
{
$pdf->Image("img/23012019.png",14.1,18.15,0.35,0.35);
}

$pdf->setXY(13.5,18.65);
$pdf->Cell(1.6,0.9,'',1,'C',1);
if($cs_explain=="4")
{
$pdf->Image("img/23012019.png",14.1,18.75,0.35,0.35);
}

$pdf->setXY(13.5,19.55);
$pdf->Cell(1.6,0.9,'',1,'C',1);
if($cs_3=="4")
{
$pdf->Image("img/23012019.png",14.1,19.65,0.35,0.35);
}

$pdf->setXY(13.5,20.45);
$pdf->Cell(1.6,0.9,'',1,'C',1);
if($cs_4=="4")
{
$pdf->Image("img/23012019.png",14.1,20.55,0.35,0.35);
}

$pdf->setXY(13.5,21.35);
$pdf->Cell(1.6,0.6,'',1,'C',1);
if($cs_5=="4")
{
$pdf->Image("img/23012019.png",14.1,21.45,0.35,0.35);
}


$pdf->setXY(15.1,17.45);
$pdf->Cell(1.6,0.6,'',1,'C',1);
$pdf->setXY(15.2,17.45);
$pdf->Cell(0.9,0.6, iconv( 'UTF-8','cp874' , "ปานกลาง" ),0,'C');

$pdf->setXY(15.1,18.05);
$pdf->Cell(1.6,0.6,'',1,'C',1);
if($cs_neat=="3")
{
$pdf->Image("img/23012019.png",15.7,18.15,0.35,0.35);
}
$pdf->setXY(15.1,18.65);
$pdf->Cell(1.6,0.9,'',1,'C',1);

if($cs_explain=="3")
{
$pdf->Image("img/23012019.png",15.7,18.75,0.35,0.35);
}

$pdf->setXY(15.1,19.55);
$pdf->Cell(1.6,0.9,'',1,'C',1);
if($cs_3=="3")
{
$pdf->Image("img/23012019.png",15.7,19.65,0.35,0.35);
}

$pdf->setXY(15.1,20.45);
$pdf->Cell(1.6,0.9,'',1,'C',1);
if($cs_4=="3")
{
$pdf->Image("img/23012019.png",15.7,20.55,0.35,0.35);
}

$pdf->setXY(15.1,21.35);
$pdf->Cell(1.6,0.6,'',1,'C',1);
if($cs_5=="3")
{
$pdf->Image("img/23012019.png",15.7,21.45,0.35,0.35);
}


//น้อย
$pdf->setXY(16.7,17.45);
$pdf->Cell(1.6,0.6,'',1,'C',1);
$pdf->setXY(17.1,17.45);
$pdf->Cell(0.9,0.6, iconv( 'UTF-8','cp874' , "น้อย" ),0,'C');

$pdf->setXY(16.7,18.05);
$pdf->Cell(1.6,0.6,'',1,'C',1);
if($cs_neat=="2")
{
$pdf->Image("img/23012019.png",17.2,18.15,0.35,0.35);
}

$pdf->setXY(16.7,18.65);
$pdf->Cell(1.6,0.9,'',1,'C',1);
if($cs_explain=="2")
{
$pdf->Image("img/23012019.png",17.2,18.75,0.35,0.35);
} 

$pdf->setXY(16.7,19.55);
$pdf->Cell(1.6,0.9,'',1,'C',1);
if($cs_3=="2")
{
$pdf->Image("img/23012019.png",17.2,19.65,0.35,0.35);
} 

$pdf->setXY(16.7,20.45);
$pdf->Cell(1.6,0.9,'',1,'C',1);
if($cs_4=="2")
{
$pdf->Image("img/23012019.png",17.2,20.55,0.35,0.35);
} 

$pdf->setXY(16.7,21.35);
$pdf->Cell(1.6,0.6,'',1,'C',1);
if($cs_5=="2")
{
$pdf->Image("img/23012019.png",17.2,21.45,0.35,0.35);
} 



//น้อยที่สุด
$pdf->setXY(18.3,17.45);
$pdf->Cell(1.7,0.6,'',1,'C',1);
$pdf->setXY(18.4,17.45);
$pdf->Cell(0.9,0.6, iconv( 'UTF-8','cp874' , "น้อยที่สุด" ),0,'C');

$pdf->setXY(18.3,18.05);
$pdf->Cell(1.7,0.6,'',1,'C',1);
if($cs_neat=="1")
{
$pdf->Image("img/23012019.png",18.8,18.15,0.35,0.35);
} 

$pdf->setXY(18.3,18.65);
$pdf->Cell(1.7,0.9,'',1,'C',1);

if($cs_explain=="1")
{
$pdf->Image("img/23012019.png",18.8,18.75,0.35,0.35);
} 

$pdf->setXY(18.3,19.55);
$pdf->Cell(1.7,0.9,'',1,'C',1);
if($cs_3=="1")
{
$pdf->Image("img/23012019.png",18.8,19.65,0.35,0.35);
} 

$pdf->setXY(18.3,20.45);
$pdf->Cell(1.7,0.9,'',1,'C',1);
if($cs_4=="1")
{
$pdf->Image("img/23012019.png",18.8,20.55,0.35,0.35);
} 

$pdf->setXY(18.3,21.35);
$pdf->Cell(1.7,0.6,'',1,'C',1);
if($cs_5=="1")
{
$pdf->Image("img/23012019.png",18.8,21.45,0.35,0.35);
} 




$pdf->setXY(1.0,22.15);
$pdf->Cell(19,1.1,'',1,'C',1);

$pdf->setXY(1.2,22.15);
$pdf->Cell(0.9,0.6, iconv( 'UTF-8','cp874' , "ข้อเสนอแนะอื่นๆ" ),0,'C');

$pdf->setXY(1.2,22.6);
$pdf->MultiCell(18.0,0.6, iconv( 'UTF-8','cp874' , "$suggest_2" ),0,'L');


$pdf->setXY(1.1,23.15);
$pdf->Cell(18.6,0,'','T',0,'C',0);



$pdf->setXY(1.0,23.35);
$pdf->Cell(19,2.0,'',1,'C',1);




if($employee_send!="")
{
$pdf->setXY(1.2,23.6);
$pdf->MultiCell(6.0,0.6, iconv( 'UTF-8','cp874' , "เจ้าหน้าที่จัดส่ง/เจ้าหน้าที่โทรสอบถาม" ),0,'L' );


$pdf->setXY(6.5,24.2);
$pdf->Cell(4.0,0,'','T',0,'C',0);

$pdf->Image("$employee_send",6.5,23.4,2.5,1.0,'png');

	

}else if($employee_send =""){

$pdf->setXY(1.2,24.3);
$pdf->MultiCell(5,0.6, iconv( 'UTF-8','cp874' , "เจ้าหน้าที่จัดส่ง/เจ้าหน้าที่โทรสอบถาม" ),0,'L' );

$pdf->setXY(6.5,24.2);
$pdf->Cell(4.0,0,'','T',0,'C',0);


}


$pdf->setXY(4.0,24.8);
$pdf->Cell(3.0,0,'','T',0,'C',0);

$pdf->setXY(3.0,24.2);
$pdf->MultiCell(5,0.6, iconv( 'UTF-8','cp874' , "วันที่ :" ),0,'L' );

$pdf->setXY(4.0,24.2);
$pdf->MultiCell(5.0, 0.6 , iconv( 'UTF-8','cp874' , "$employee_date" ),0,'L' );





if($customer_receive!="")
{
$pdf->setXY(12.2,23.6);
$pdf->MultiCell(6.0,0.6, iconv( 'UTF-8','cp874' , "ผู้รับสินค้า" ),0,'L' );


$pdf->setXY(13.9,24.2);
$pdf->Cell(4.0,0,'','T',0,'C',0);

$pdf->Image("$customer_receive",13.9,23.4,2.5,1.0,'png');

	

}else if($customer_receive =""){

$pdf->setXY(12.2,23.6);
$pdf->MultiCell(5,0.6, iconv( 'UTF-8','cp874' , "ผู้รับสินค้า" ),0,'L' );

$pdf->setXY(13.9,24.2);
$pdf->Cell(4.0,0,'','T',0,'C',0);


}


$pdf->setXY(14.0,24.8);
$pdf->Cell(3.0,0,'','T',0,'C',0);

$pdf->setXY(13.0,24.2);
$pdf->MultiCell(5,0.6, iconv( 'UTF-8','cp874' , "วันที่ :" ),0,'L' );

$pdf->setXY(14.2,24.2);
$pdf->MultiCell(5.0, 0.6 , iconv( 'UTF-8','cp874' , "$customer_date" ),0,'L' );


$pdf->SetFont('angsa','',14);

$pdf->setXY(3.5,25.3);
$pdf->MultiCell(19.0,0.6, iconv( 'UTF-8','cp874' , "บริษัทขอขอบพระคุณเป็นอย่างสูงที่ท่านได้กรุณาสละเวลาในการเสนอแนะข้อคิดเห็นต่างๆ ในการปฏิบัติงานของเจ้าหน้าที่" ),0,'L' );
$pdf->setXY(3.5,26.0);
$pdf->MultiCell(19.0,0.6, iconv( 'UTF-8','cp874' , "โดยได้รับความไว้วางใจเลือกใช้ผลิตภัณฑ์และบริการ บริษัท ฯ หวังเป็นอย่างยิ่งว่า จะมีโอกาสได้รับการบริการจากท่านอีก" ),0,'L' );
$pdf->setXY(5.2,26.7);
$pdf->MultiCell(19.0,0.6, iconv( 'UTF-8','cp874' , "หากมีข้อสงสัย หรือพบปัญหา กรุณาติดต่อฝ่ายบริการลูกค้าสัมพันธ์ โทร 0-2424-3555" ),0,'L' );

$pdf->setXY(1.0,27.0);
$pdf->MultiCell(19.0,0.6, iconv( 'UTF-8','cp874' , "อนุมัติวัยที่ 9 ก.ค. 2563" ),0,'L' );

$pdf->setXY(18.0,27.0);
$pdf->MultiCell(19.0,0.6, iconv( 'UTF-8','cp874' , "FM-MK-09:Rev.3" ),0,'L' );


$pdf->Output();
?>



