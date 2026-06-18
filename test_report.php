<?php
//header("Content-Type: image/png");


//header("Content-Disposition: attachment; filename=สรุปงานแผนกบริการลูกค้า.png");


define('FPDF_FONTPATH','font/');
 
require('fpdf.php');
 
require('tcpdf.php');
require_once('tcpdf_include.php');
$ref_id=$_GET["ref_id"];



include"dbconnect.php";

$strSQL = "SELECT
so__main.* ,tb_salechannel.*, tb_delivery.*,tb_province.* ,tb_employee.* FROM ((((so__main LEFT JOIN tb_salechannel ON so__main.sale_channel=tb_salechannel.salechannel_ID)LEFT JOIN tb_delivery ON so__main.delivery=tb_delivery.delivery_ID)LEFT JOIN tb_province ON so__main.province=tb_province.province_ID)LEFT JOIN tb_employee ON so__main.employee_name =tb_employee.employee_ID) WHERE ref_id = '".$ref_id."' ";
//echo  $strSQL;
//exit();

$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);

$strSQL1 = "SELECT * FROM so__submain WHERE ref_idd = '".$ref_id."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

$strSQL15 = "SELECT SUM(sum_amount) AS amount_1 FROM so__submain WHERE ref_idd = '".$ref_id."' ";
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




//$newDate = date("d-m-Y", strtotime($start_date));
$ref_id=$objResult["ref_id"];
$delivery =$objResult["delivery"];
$time_send =$objResult["time_send"];
$description_wrap=$objResult["description_wrap"];
$time_description="$time_send $description_wrap";
$job_id =$objResult["job_id"];
$date = date('d-m-Y H:i:s');
$salechannel_name=$objResult["salechannel_name"];
$register_date=$objResult["register_date"];
$time_delivery=$objResult["time_delivery"];
$packing_remark =$objResult["packing_remark"];

$date1 = explode('-' , $register_date );
$newDate = $date1[2].'-'.$date1[1].'-'.$date1[0];


$register_time =$objResult["register_time"];

$doc_no =$objResult["doc_no"];
$address1 =$objResult["address1"];
$address2 =$objResult["address2"];
$province_id =$objResult["province_id"];
$province_name =$objResult["province_name"];
$zip_code  =$objResult["zip_code"];
$delivery_place =$objResult["delivery_place"];

$postcode =$objResult["postcode"];
$return_contact =$objResult["return_contact"];
$customer_name =$objResult["customer_name"];
$order_id  =$objResult["order_id"];
$salechannel_nameshort =$objResult["salechannel_nameshort"];
$sn =$objResult["sn"];
$bq =$objResult["bq"];
$ot =$objResult["ot"];

$delivery_company =$objResult["delivery_company"];
$delivery_sale =$objResult["delivery_sale"];
$deliver_engineer =$objResult["deliver_engineer"];
$big_car =$objResult["big_car"];
$maps =$objResult["maps"];
$delivery_date  =$objResult["delivery_date"];
$delivery_time  =$objResult["delivery_time"];
$call_before  =$objResult["call_before"];
$assign_date_time  =$objResult["assign_date_time"];
$sale_remark = $objResult["sale_remark"];
$returns = $objResult["returns"];
$return_address = $objResult["return_address"];
$return_contact = $objResult["return_contact"];
$employee_name = $objResult["employee_name"];
$approve_name = $objResult["approve_name"];

$style = array(
    'position' => '',
    'align' => 'C',
    'stretch' => false,
    'fitwidth' => true,
    'cellfitalign' => '',
    'border' => true,
    'hpadding' => 'auto',
    'vpadding' => 'auto',
    'fgcolor' => array(0,0,0),
    'bgcolor' => false, //array(255,255,255),
    'text' => true,
    'font' => 'helvetica',
    'fontsize' => 8,
    'stretchtext' => 4
);

$pdf=new FPDF( 'P' , 'cm' , 'A4' );
$pdf->AddFont('angsa','','angsa.php');
$pdf->AddFont('angsana','B','angsab.php');
$pdf->AddFont('times','','times.php');
$pdf->AddFont('helvetica','','helvetica.php');
 
$pdf->AddPage();
/*
include "src/BarcodeGenerator.php";
include "src/BarcodeGeneratorPNG.php";
 include "src/BarcodeGeneratorHTML.php";


    
    $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
    $border = 1;//กำหนดความหน้าของเส้น Barcode
    $height = 30;//กำหนดความสูงของ Barcode
 
  $code= $generator->getBarcode($doc_no , $generator::TYPE_CODE_128,$border,$height);
 


$pdf->SetFont('angsa','',10);

$pdf->setXY(17.3,2.5);
$pdf->MultiCell( 9  , 0.6 , iconv( 'UTF-8','cp874' , "$code"),0 ,'L' );
*/
//include"ex.php";

$pdf->SetFont('helvetica', '', 11);

$pdf->Cell(0, 0, 'CODE 93 - USS-93', 0, 1);
$pdf->write1DBarcode('TEST93', 'C93', '', '', '', 18, 0.4, $style, 'N');
$pdf->Ln();

$pdf->Cell(0, 0, 'EAN 13', 0, 1);
$pdf->write1DBarcode('1234567890128', 'EAN13', '', '', '', 18, 0.4, $style, 'N');

$pdf->Ln();


$pdf->SetFont('angsana','B',18);


$pdf->setXY( 16.0, 1.0  );
$pdf->MultiCell( 9  , 0.6 , iconv( 'UTF-8','cp874' , "Kerry เก็บเงินปลายทาง"),0 ,'L' );

$pdf->SetFont('angsana','BU',20);

$pdf->setXY( 8.0, 2.0  );
$pdf->MultiCell( 9  , 0.6 , iconv( 'UTF-8','cp874' , "ใบสั่งพิมพ์ใบเบิกจ่ายสินค้า"),0 ,'L' );
$pdf->setXY(6.0, 2.5  );
$pdf->MultiCell( 10.0  , 0.6 , iconv( 'UTF-8','cp874' , "(Request for issuing stock movement order)"),0 ,'L' );

$pdf->SetFont('angsa','',10);

$pdf->setXY( 4.0,0.5  );
$pdf->MultiCell(4.0, 0.6 , iconv( 'UTF-8','cp874' , "$time_delivery $packing_remark"),0 ,'L' );




$pdf->SetFont('angsa','',14);

$pdf->setXY( 1.0, 0.8  );
$pdf->MultiCell( 9  , 0.6 , iconv( 'UTF-8','cp874' , "เลขที่อ้างอิง :"),0 ,'L' );

$pdf->setXY( 2.8, 0.8  );
$pdf->MultiCell( 9  , 0.6 , iconv( 'UTF-8','cp874' , "$ref_id"),0 ,'L' );

$pdf->setXY( 1.0,1.6);
$pdf->MultiCell( 0.25  , 0.25 , iconv( 'UTF-8','cp874' , "" ),1,'L' );
$pdf->setXY( 1.3, 1.4);
$pdf->MultiCell( 5  , 0.6 , iconv( 'UTF-8','cp874' , "ก" ),0,'L' );

$pdf->setXY( 2.0,1.6);
$pdf->MultiCell( 0.25  , 0.25 , iconv( 'UTF-8','cp874' , "" ),1,'L' );
$pdf->setXY( 2.3, 1.4);
$pdf->MultiCell( 5  , 0.6 , iconv( 'UTF-8','cp874' , "C" ),0,'L' );

$pdf->setXY( 1.0, 2.0  );
$pdf->MultiCell( 9  , 0.6 , iconv( 'UTF-8','cp874' , "ฝากสินค้าเลขที่"),0 ,'L' );

$pdf->setXY(3.2, 2.5);
$pdf->Cell(2.0,0,'','T',0,'c',0);

$pdf->setXY( 1.0, 2.6  );
$pdf->MultiCell( 9  , 0.6 , iconv( 'UTF-8','cp874' , "เลขที่ลงงาน"),0 ,'L' );
$pdf->setXY( 3.2, 2.6  );
$pdf->MultiCell( 9  , 0.6 , iconv( 'UTF-8','cp874' , "$job_id"),0 ,'L' );


$pdf->setXY(3.2, 3.1);
$pdf->Cell(2.0,0,'','T',0,'c',0);

$pdf->setXY( 1.0,3.5);
$pdf->Cell( 9.6,5.5, "",1,1,"c" );

$pdf->setXY( 10.6,3.5);
$pdf->Cell( 9.6,5.5, "",1,1,"c" );


$pdf->setXY( 1.0,3.6);
$pdf->MultiCell( 9  , 0.6 , iconv( 'UTF-8','cp874' , "ชื่อลูกค้า/รพ"),0 ,'L' );
$pdf->setXY( 3.2,3.6);
$pdf->MultiCell( 9  , 0.6 , iconv( 'UTF-8','cp874' , "$salechannel_name"),0 ,'L' );

$pdf->setXY( 1.0,4.1);
$pdf->MultiCell( 9  , 0.6 , iconv( 'UTF-8','cp874' , "ที่อยู่"),0 ,'L' );
$pdf->setXY( 3.2,4.1);
$pdf->MultiCell(7.0, 0.6 , iconv( 'UTF-8','cp874' , "$address1 $address2"),0 ,'L' );

$pdf->setXY(3.2, 4.6);
$pdf->Cell(7.3,0,'','T',0,'c',0);
$pdf->setXY(3.2, 5.2);
$pdf->Cell(7.3,0,'','T',0,'c',0);

$pdf->setXY(1.0, 5.8);
$pdf->Cell(9.5,0,'','T',0,'c',0);

$pdf->setXY( 3.2,5.3);
$pdf->MultiCell(7.0, 0.6 , iconv( 'UTF-8','cp874' , "$province_id"),0 ,'L' );

$pdf->setXY( 9.0,5.3);
$pdf->MultiCell(7.0, 0.6 , iconv( 'UTF-8','cp874' , "$zip_code"),0 ,'L' );

$pdf->setXY( 1.0,5.9);
$pdf->MultiCell( 9  , 0.6 , iconv( 'UTF-8','cp874' , "สถานที่ส่งสินค้า"),0 ,'L' );
$pdf->setXY( 3.3,5.9);
$pdf->MultiCell(7.0, 0.6 , iconv( 'UTF-8','cp874' , "$delivery_place"),0 ,'L' );
$pdf->setXY(3.3, 6.4);
$pdf->Cell(7.2,0,'','T',0,'c',0);

$pdf->setXY( 1.0,6.5);
$pdf->MultiCell( 9  , 0.6 , iconv( 'UTF-8','cp874' , "Ward/ชั้น/ตึก"),0 ,'L' );
$pdf->setXY( 3.2,6.5);
$pdf->MultiCell(7.0, 0.6 , iconv( 'UTF-8','cp874' , "$province_name $postcode"),0 ,'L' );
$pdf->setXY(3.2,7.0);
$pdf->Cell(7.3,0,'','T',0,'c',0);
$pdf->setXY(3.2,7.6);
$pdf->Cell(7.3,0,'','T',0,'c',0);


$pdf->setXY( 1.0,7.7);
$pdf->MultiCell( 9  , 0.6 , iconv( 'UTF-8','cp874' , "ชื่อผู้ติดต่อ/โทร"),0 ,'L' );
$pdf->setXY( 3.2,7.7);
$pdf->MultiCell(7.0, 0.6 , iconv( 'UTF-8','cp874' , "$return_contact"),0 ,'L' );
$pdf->setXY(3.2,8.2);
$pdf->Cell(7.3,0,'','T',0,'c',0);

$pdf->setXY(3.2,8.8);
$pdf->Cell(7.3,0,'','T',0,'c',0);
$pdf->setXY( 3.2,8.3);
$pdf->MultiCell(8.3, 0.6 , iconv( 'UTF-8','cp874' , "$customer_name : $order_id"),0 ,'L' );

/*$pdf->SetFont('helvetica','',14);
$pdf->setXY( 17.3,2.5);
$pdf->MultiCell(4.0, 0.6 , iconv( 'UTF-8','cp874' , "ทดสอบ"),0 ,'L' );*/





$pdf->SetFont('angsa','',14);
$pdf->setXY( 10.7,3.6);
$pdf->MultiCell( 9  , 0.6 , iconv( 'UTF-8','cp874' , "วันที่"),0 ,'L' );
$pdf->setXY( 11.5,3.6);
$pdf->MultiCell(12.4,0.6 , iconv( 'UTF-8','cp874' , "$newDate"),0 ,'L' );

$pdf->setXY( 10.7,4.1);
$pdf->MultiCell( 9  , 0.6 , iconv( 'UTF-8','cp874' , "วัตถุประสงค์การเบิก"),0 ,'L' );

$pdf->setXY( 10.7,4.9);
$pdf->MultiCell( 0.25  , 0.25 , iconv( 'UTF-8','cp874' , "" ),1,'L' );
$pdf->setXY(11.0, 4.7);
$pdf->MultiCell( 5  , 0.6 , iconv( 'UTF-8','cp874' , "เป็นสินค้าสำรอง" ),0,'L' );
$pdf->setXY(13.5,5.2);
$pdf->Cell(6.0,0,'','T',0,'c',0);

$pdf->setXY( 10.7,5.5);
$pdf->MultiCell( 0.25  , 0.25 , iconv( 'UTF-8','cp874' , "" ),1,'L' );
$pdf->setXY(11.0, 5.3);
$pdf->MultiCell( 5  , 0.6 , iconv( 'UTF-8','cp874' , "สำหรับลูกค้าทดลองใช้" ),0,'L' );

$pdf->setXY(14.2,5.8);
$pdf->Cell(5.3,0,'','T',0,'c',0);

$pdf->setXY(19.6, 5.3);
$pdf->MultiCell( 5  , 0.6 , iconv( 'UTF-8','cp874' , "วัน" ),0,'L' );


$pdf->setXY( 10.7,6.1);
$pdf->MultiCell( 0.25  , 0.25 , iconv( 'UTF-8','cp874' , "" ),1,'L' );
$pdf->setXY(11.0, 5.9);
$pdf->MultiCell( 5  , 0.6 , iconv( 'UTF-8','cp874' , "ส่งสินค้าล่วงหน้าเพื่อรอรับใบสั่งซื้อ" ),0,'L' );


$pdf->setXY( 10.7,6.7);
$pdf->MultiCell( 0.25  , 0.25 , iconv( 'UTF-8','cp874' , "" ),1,'L' );
$pdf->setXY(11.0, 6.5);
$pdf->MultiCell(9.0, 0.6 , iconv( 'UTF-8','cp874' , "แลกเปลี่ยนสินค้า ตามใบงานบริการเลขที่" ),0,'L' );


$pdf->setXY(16.7,7.0);
$pdf->Cell(2.8,0,'','T',0,'c',0);

$pdf->setXY(19.5,6.5);
$pdf->MultiCell(9.0, 0.6 , iconv( 'UTF-8','cp874' , "*" ),0,'L' );


$pdf->setXY( 10.7,7.9);
$pdf->MultiCell( 0.25  , 0.25 , iconv( 'UTF-8','cp874' , "" ),1,'L' );
$pdf->setXY(11.0, 7.7);
$pdf->MultiCell( 5  , 0.6 , iconv( 'UTF-8','cp874' , "อื่นๆ" ),0,'L' );

$pdf->setXY(12.0, 7.7);
$pdf->MultiCell( 7.5  , 0.6 , iconv( 'UTF-8','cp874' , "$salechannel_nameshort" ),0,'L' );


$pdf->setXY(12.0,8.2);
$pdf->Cell(7.5,0,'','T',0,'c',0);

$pdf->setXY(12.0,8.8);
$pdf->Cell(7.5,0,'','T',0,'c',0);




$pdf->setXY( 13.2,3.6);
$pdf->MultiCell(12.4,0.6 , iconv( 'UTF-8','cp874' , "$register_time"),0 ,'L' );


$pdf->setXY(15.5,3.5);
$pdf->Cell(4.7,0.6, "",1,1,"c" );


$pdf->setXY( 16.5,3.6);
$pdf->MultiCell( 9.0, 0.6 , iconv( 'UTF-8','cp874' , "เลขที่"),0 ,'L' );
$pdf->setXY( 18.0,3.6);
$pdf->MultiCell(12.4,0.6 , iconv( 'UTF-8','cp874' , "$doc_no"),0 ,'L' );



$pdf->setXY(3.2, 4.1);
$pdf->Cell(17.0,0,'','T',0,'c',0);


$pdf->SetFont('angsa','',12);

$pdf->setXY(10.6, 7.1);
$pdf->MultiCell(10.0, 0.6 , iconv( 'UTF-8','cp874' , "(เฉพาะกรณีแลกเปลี่ยนสินค้าที่มีหมายเลขเครื่องต้องระบุเลขที่ใบงานบริการทุกครั้ง)" ),0,'L' );


$pdf->setXY(17.5,3.0);
$pdf->MultiCell( 9  , 0.6 , iconv( 'UTF-8','cp874' , "$date"),0 ,'L' );

$pdf->setXY( 4.0, 0.8  );
$pdf->MultiCell( 4.0, 0.6 , iconv( 'UTF-8','cp874' , "$time_description"),0 ,'L' );

$pdf->SetFont('angsa','',14);


$pdf->setXY( 1.0,9.2);
$pdf->Cell(1.5,6.0, "",1,1,"c" );

$pdf->setXY(2.5,9.2);
$pdf->Cell(3.0,6.0, "",1,1,"c" );

$pdf->setXY(5.5,9.2);
$pdf->Cell(11.0,6.0, "",1,1,"c" );

$pdf->setXY(16.5,9.2);
$pdf->Cell(1.8,6.0, "",1,1,"c" );

$pdf->setXY(18.3,9.2);
$pdf->Cell(1.9,6.0, "",1,1,"c" );

$pdf->setXY( 1.0,15.2);
$pdf->Cell(17.3,0.8, "",1,1,"c" );

$pdf->setXY(18.3,15.2);
$pdf->Cell(1.9,0.8, "",1,1,"c" );




$pdf->setXY(1.0,9.8);
$pdf->Cell(19.2,0,'','T',0,'c',0);

$pdf->setXY( 1.2,9.2);
$pdf->MultiCell( 9.0, 0.6 , iconv( 'UTF-8','cp874' , "ลำดับ"),0 ,'L' );


$pdf->setXY(3.0,9.2);
$pdf->MultiCell( 9.0, 0.6 , iconv( 'UTF-8','cp874' , "รหัสสินค้า"),0 ,'L' );

$pdf->setXY(10.5,9.2);
$pdf->MultiCell( 9.0, 0.6 , iconv( 'UTF-8','cp874' , "รายละเอียด"),0 ,'L' );


$pdf->setXY(16.8,9.2);
$pdf->MultiCell( 9.0, 0.6 , iconv( 'UTF-8','cp874' , "จำนวน"),0 ,'L' );

$pdf->setXY(18.2,9.0);
$pdf->MultiCell( 9.0,1.0, iconv( 'UTF-8','cp874' , "ราคาต่อหน่วย"),0 ,'L' );

$strSQL1 = "SELECT * FROM so__submain WHERE ref_idd = '".$ref_id."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

$i=1;
while($objResult1 = mysqli_fetch_array($objQuery1))
{

$price_per_unit_1  =$objResult1["price_per_unit"];
$price_per_unit= number_format( $price_per_unit_1,2)."";

$product_code  =$objResult1["product_code"];
$product_name  =$objResult1["product_name"];
$sale_count  =$objResult1["sale_count"];
$unit_name  =$objResult1["unit_name"];


$pdf->setX(1.3);
$pdf->MultiCell( 9.0,0, iconv( 'UTF-8','cp874' , "$i"),0 ,'L' );


$pdf->setX(2.6);
$pdf->MultiCell( 9.0,0, iconv( 'UTF-8','cp874' , "$product_code"),0 ,'L' );

$pdf->setX(5.6);
$pdf->MultiCell( 9.0,0, iconv( 'UTF-8','cp874' , "$product_name"),0 ,'L' );


$pdf->setX(16.6);
$pdf->MultiCell( 9.0,0, iconv( 'UTF-8','cp874' , "$sale_count $unit_name"),0 ,'L' );

$pdf->setX(18.3);
$pdf->MultiCell( 9.0,0, iconv( 'UTF-8','cp874' , "$price_per_unit"),0 ,'L' );

$pdf->setX(18.3);
$pdf->MultiCell( 9.0,0.6, iconv( 'UTF-8','cp874' , ""),0 ,'L' );


$i++;


}
$pdf->setX(16.8);
$pdf->MultiCell( 9.0,0, iconv( 'UTF-8','cp874' , "total :"),0 ,'L' );

$pdf->setX(18.3);
$pdf->MultiCell( 9.0,0, iconv( 'UTF-8','cp874' , "$summary"),0 ,'L' );


$pdf->setXY( 5.6,13.4);
$pdf->MultiCell( 0.25  , 0.25 , iconv( 'UTF-8','cp874' , "" ),1,'L' );
$pdf->setXY(6.0,13.2);
$pdf->MultiCell( 5  , 0.6 , iconv( 'UTF-8','cp874' , "ไม่ต้องการ" ),0,'L' );


if ($sn!=''){

$pdf->Image("img/cor.jpeg",7.7,13.1,0.90,0.60);

}else{


$pdf->setXY(8.0,13.4);
$pdf->MultiCell( 0.25  , 0.25 , iconv( 'UTF-8','cp874' , "" ),1,'L' );
}

$pdf->setXY(8.5,13.2);
$pdf->MultiCell( 5  , 0.6 , iconv( 'UTF-8','cp874' , "ต้องการ" ),0,'L' );



$pdf->setXY(10.5,13.2);
$pdf->MultiCell( 5  , 0.6 , iconv( 'UTF-8','cp874' , "Serial No." ),0,'L' );

$pdf->setXY(12.0,13.2);
$pdf->MultiCell(4.2, 0.6 , iconv( 'UTF-8','cp874' , "$sn" ),0,'L' );


$pdf->setXY(12.0,13.7);
$pdf->Cell(4.2,0,'','T',0,'c',0);

if ($bq!=''){
$pdf->Image("img/cor.jpeg",5.6,13.9,0.70,0.40);

$pdf->setXY(6.3,13.8);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "BQ เลขที่" ),0,'L' );

}else{

$pdf->setXY( 5.6,14.0);
$pdf->MultiCell( 0.25  , 0.25 , iconv( 'UTF-8','cp874' , "" ),1,'L' );
$pdf->setXY(6.0,13.8);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "BQ เลขที่" ),0,'L' );

}

$pdf->setXY(8.0,13.8);
$pdf->MultiCell(8.2, 0.6 , iconv( 'UTF-8','cp874' , "$bq" ),0,'L' );


$pdf->setXY(8.0,14.3);
$pdf->Cell(8.2,0,'','T',0,'c',0);

if ($ot!=''){
$pdf->Image("img/cor.jpeg",5.6,14.5,0.70,0.40);
$pdf->setXY(6.3,14.4);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "OT เลขที่" ),0,'L' );


}else{


$pdf->setXY( 5.6,14.6);
$pdf->MultiCell( 0.25  , 0.25 , iconv( 'UTF-8','cp874' , "" ),1,'L' );
$pdf->setXY(6.0,14.4);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "OT เลขที่" ),0,'L' );

}

$pdf->setXY(8.0,14.4);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "$ot" ),0,'L' );


$pdf->setXY(8.0,14.9);
$pdf->Cell(8.2,0,'','T',0,'c',0);

$pdf->SetFont('angsana','B',18);

$pdf->setXY(10.5,15.2);
$pdf->MultiCell( 9.0, 0.6 , iconv( 'UTF-8','cp874' , "TOTAL"),0 ,'L' );



$pdf->setXY( 1.0,16.2);
$pdf->Cell( 9.6,5.5, "",1,1,"c" );

$pdf->setXY( 10.6,16.2);
$pdf->Cell( 9.6,5.5, "",1,1,"c" );

$pdf->SetFont('angsa','',14);

if ($delivery_company=='1'){
$pdf->Image("img/cor.jpeg",1.3,16.3,0.70,0.40);

$pdf->setXY(2.0,16.2);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "บริษัทจัดส่ง" ),0,'L' );

}else{

$pdf->setXY(1.6,16.4);
$pdf->MultiCell( 0.25  , 0.25 , iconv( 'UTF-8','cp874' , "" ),1,'L' );
$pdf->setXY(2.0,16.2);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "บริษัทจัดส่ง" ),0,'L' );

}

if ($delivery_sale=='1'){
$pdf->Image("img/cor.jpeg",4.0,16.3,0.70,0.40);

$pdf->setXY(4.5,16.2);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "Sale รับเอง" ),0,'L' );

}else{

$pdf->setXY(4.0,16.4);
$pdf->MultiCell( 0.25  , 0.25 , iconv( 'UTF-8','cp874' , "" ),1,'L' );
$pdf->setXY(4.5,16.2);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "Sale รับเอง" ),0,'L' );

}


if ($deliver_engineer=='1'){
$pdf->Image("img/cor.jpeg",6.7,16.3,0.70,0.40);

$pdf->setXY(7.2,16.2);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "Engineer รับเอง" ),0,'L' );

}else{

$pdf->setXY(6.7,16.4);
$pdf->MultiCell( 0.25  , 0.25 , iconv( 'UTF-8','cp874' , "" ),1,'L' );
$pdf->setXY(7.2,16.2);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "Engineer รับเอง" ),0,'L' );

}



if ($big_car=='1'){
$pdf->Image("img/cor.jpeg",1.3,16.9,0.70,0.40);

$pdf->setXY(2.0,16.8);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "ต้องการรถใหญ่" ),0,'L' );

}else{

$pdf->setXY(1.6,17.0);
$pdf->MultiCell( 0.25  , 0.25 , iconv( 'UTF-8','cp874' , "" ),1,'L' );
$pdf->setXY(2.0,16.8);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "ต้องการรถใหญ่" ),0,'L' );

}




if ($maps=='1'){
$pdf->Image("img/cor.jpeg",6.7,16.9,0.70,0.40);

$pdf->setXY(7.2,16.8);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "มีแผนที่ประกอบ" ),0,'L' );

}else{

$pdf->setXY(6.7,17.0);
$pdf->MultiCell( 0.25  , 0.25 , iconv( 'UTF-8','cp874' , "" ),1,'L' );
$pdf->setXY(7.2,16.8);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "มีแผนที่ประกอบ" ),0,'L' );

}

$pdf->setXY(2.0,17.4);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "วันที่" ),0,'L' );

$pdf->setXY(3.0,17.4);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "$delivery_date" ),0,'L' );

$pdf->setXY(3.0,17.9);
$pdf->Cell(3.3,0,'','T',0,'c',0);


$pdf->setXY(6.7,17.4);
$pdf->MultiCell(4.5, 0.6 , iconv( 'UTF-8','cp874' , "เวลา" ),0,'L' );


$pdf->setXY(7.5,17.4);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "$delivery_time" ),0,'L' );

$pdf->setXY(7.5,17.9);
$pdf->Cell(2.8,0,'','T',0,'c',0);


if ($call_before=='1'){
$pdf->Image("img/cor.jpeg",1.3,18.1,0.70,0.40);

$pdf->setXY(2.0,18.0);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "โทรแจ้งลูกค้าก่อนไป" ),0,'L' );

}else{

$pdf->setXY(1.6,18.2);
$pdf->MultiCell( 0.25  , 0.25 , iconv( 'UTF-8','cp874' , "" ),1,'L' );
$pdf->setXY(2.0,18.0);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "โทรแจ้งลูกค้าก่อนไป" ),0,'L' );

}


if ($assign_date_time=='1'){
$pdf->Image("img/cor.jpeg",1.3,18.7,0.70,0.40);

$pdf->setXY(2.0,18.6);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "นัดวันและเวลาเรียบร้อยแล้ว" ),0,'L' );

}else{

$pdf->setXY(1.6,18.8);
$pdf->MultiCell( 0.25  , 0.25 , iconv( 'UTF-8','cp874' , "" ),1,'L' );
$pdf->setXY(2.0,18.6);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "นัดวันและเวลาเรียบร้อยแล้ว" ),0,'L' );

}


$pdf->setXY(1.4,19.2);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "หมายเหตุ" ),0,'L' );



$pdf->setXY(2.9,19.2);
$pdf->MultiCell(7.5, 0.6 , iconv( 'UTF-8','cp874' , "$sale_remark" ),0,'L' );

$pdf->setXY(2.9,19.7);
$pdf->Cell(7.5,0,'','T',0,'c',0);

$pdf->setXY(2.9,20.3);
$pdf->Cell(7.5,0,'','T',0,'c',0);

$pdf->setXY(2.9,20.9);
$pdf->Cell(7.5,0,'','T',0,'c',0);


if ($returns=='1'){

$pdf->Image("img/cor.jpeg",10.7,16.3,0.70,0.40);

$pdf->setXY(11.2,16.2);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "รับสินค้าคืน" ),0,'L' );

}else{

$pdf->setXY(10.9,16.4);
$pdf->MultiCell( 0.25  , 0.25 , iconv( 'UTF-8','cp874' , "" ),1,'L' );
$pdf->setXY(11.2,16.2);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "รับสินค้าคืน" ),0,'L' );

}

$pdf->setXY(13.0,16.7);
$pdf->Cell(7.0,0,'','T',0,'c',0); 

/*$pdf->setXY(13.0,16.2);
$pdf->MultiCell(7.0, 0.6 , iconv( 'UTF-8','cp874' , "" ),0,'L' );*/


$pdf->setXY(11.1,16.8);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "Ward/ชั้น/ตึก" ),0,'L' );

$pdf->setXY(11.1,16.8);
$pdf->MultiCell(7.0, 0.6 , iconv( 'UTF-8','cp874' , "$return_address" ),0,'L' );


$pdf->setXY(13.0,17.3);
$pdf->Cell(7.0,0,'','T',0,'c',0); 

 $pdf->setXY(13.0,17.9);
$pdf->Cell(7.0,0,'','T',0,'c',0); 

 $pdf->setXY(13.0,18.5);
$pdf->Cell(7.0,0,'','T',0,'c',0); 

 $pdf->setXY(13.0,19.1);
$pdf->Cell(7.0,0,'','T',0,'c',0); 

$pdf->setXY(10.8,19.2);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "ชื่อผู้ติดต่อ/โทร" ),0,'L' );

 $pdf->setXY(13.0,19.7);
$pdf->Cell(7.0,0,'','T',0,'c',0); 


 $pdf->setXY(13.0,20.3);
$pdf->Cell(7.0,0,'','T',0,'c',0); 

 $pdf->setXY(13.0,20.9);
$pdf->Cell(7.0,0,'','T',0,'c',0); 


$pdf->setXY( 1.0,22.0);
$pdf->Cell( 19.2,3.0, "",1,1,"c" );

$pdf->SetFont('angsana','B',16);

$pdf->setXY(2.0,22.3);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "ผู้เบิกสินค้า" ),0,'L' );

$pdf->setXY(2.0,23.5);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "วันที่" ),0,'L' );

$pdf->setXY(11.2,22.3);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "ผู้อนุมัติ" ),0,'L' );


 $pdf->setXY(4.0,23.4);
$pdf->Cell(4.5,0,'','T',0,'c',0);

$pdf->setXY(13.2,23.4);
$pdf->Cell(4.5,0,'','T',0,'c',0);




 $pdf->setXY(4.0,24.0);
$pdf->Cell(4.5,0,'','T',0,'c',0);

 $pdf->setXY(13.2,24.0);
$pdf->Cell(4.5,0,'','T',0,'c',0);


$pdf->SetFont('angsa','',14);


$pdf->setXY(12.9,22.9);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "(" ),0,'L' );
$pdf->setXY(17.7,22.9);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , ")" ),0,'L' );


$pdf->setXY(3.7,22.9);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "(" ),0,'L' );
$pdf->setXY(8.5,22.9);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , ")" ),0,'L' );


$pdf->setXY(13.4,22.9);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "$approve_name" ),0,'L' );


$pdf->setXY(4.1,22.9);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "$employee_name" ),0,'L' );

$pdf->setXY(5.0,23.5);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "$newDate" ),0,'L' );
$pdf->setXY(14.5,23.5);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "$newDate" ),0,'L' );


$pdf->setXY(1.0,25.1);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "อนุมัติวันที่ 29 สิงหาคม 2559" ),0,'L' );

$pdf->setXY(1.0,25.7);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "$date" ),0,'L' );


$pdf->setXY(17.6,25.1);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "FM-SA-02:Rev.9" ),0,'L' );


$pdf->Output();
?>


