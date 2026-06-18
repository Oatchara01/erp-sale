
<?php


define('FPDF_FONTPATH','font/');
 
require('fpdf.php');

$ref_id=$_GET["ref_id"];

include"dbconnect.php";

$strSQL1 = "Update  hos__jongproduct set print_st = '1',stock_print = '".$stock."' WHERE ref_id = '".$ref_id."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die(mysqli_error());


$strSQL = "SELECT * FROM hos__jongproduct WHERE ref_id = '".$ref_id."' ";

$objQuery = mysqli_query($conn,$strSQL)or die ("Error Query [".$strSQL."]");;
$objResult = mysqli_fetch_array($objQuery);

$strSQL1 = "SELECT * FROM (hos__subjongpro LEFT JOIN tb_product ON hos__subjongpro.product_ID=tb_product.product_id) WHERE ref_idd = '".$ref_id."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);


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



 $date_jong = DateThai($objResult['date_jong']);
 $date_receive = DateThai($objResult['date_receive']);

 $customer = $objResult['customer'];
 $address_send = $objResult['address_send'];
 $sale_name  = $objResult['sale_name'];
 $sale_code  = $objResult['sale_code'];
$register_ckk = $objResult['register_ckk'];
$cancel_ckk = $objResult['cancel_ckk'];
$status_doc=$objResult['status_doc'];
$bq_no =$objResult['bq_no'];
$drescription =$objResult['drescription'];
$approve_name=$objResult['approve_name'];
$date_approve=DateThai($objResult['date_approve']);
$remark=$objResult['remark'];
$newadd_date = date("d-m-Y H:i:s");
$iv_no =$objResult['iv_no'];

$pdf=new FPDF( 'P' , 'cm' , 'A4' );
$pdf->AddFont('angsa','','angsa.php');
$pdf->AddFont('angsana','B','angsab.php');
 
$pdf->AddPage();
$pdf->SetFont('angsana','BU',20);



$pdf->setXY( 8.9, 1.0  );
$pdf->MultiCell( 9  , 0.6 , iconv( 'UTF-8','cp874' , "ใบจองสินค้า"),0 ,'L' );
$pdf->setXY( 8.2, 1.5  );
$pdf->MultiCell( 5.5  , 0.6 , iconv( 'UTF-8','cp874' , "(Product Booking)"),0 ,'L' );



$pdf->SetFont('angsana','B',14);

$pdf->setXY( 1.4,3.0);
$pdf->Cell( 6.0,6.2, "",1,1,"c" );

$pdf->setXY( 1.4,9.2);
$pdf->Cell( 6.0,2.8, "",1,1,"c" );



$pdf->setXY( 7.4,3.0);
$pdf->Cell( 3.0,9.0, "",1,1,"c" );

$pdf->setXY( 10.4,3.0);
$pdf->Cell( 7.0,9.0, "",1,1,"c" );


$pdf->setXY( 17.4,3.0);
$pdf->Cell(1.5,9.0, "",1,1,"c" );

$pdf->setXY( 18.9,3.0);
$pdf->Cell( 1.5,9.0, "",1,1,"c" );


$pdf->setXY( 1.4,12.0);
$pdf->Cell( 19.0,1.5, "",1,1,"c" );

$pdf->setXY( 1.4,13.5);
$pdf->Cell( 19.0,1.0, "",1,1,"c" );



$pdf->setXY( 1.4, 3.8  );
$pdf->Cell(19.0,0,'','T',0,'C',0);


$pdf->setXY( 3.8,3.1 );
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "ข้อมูลการจอง" ),0,'L' );


$pdf->setXY( 8.0,3.1 );
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "รหัสสินค้า" ),0,'L' );

$pdf->setXY(13.5,3.1 );
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "รายการ" ),0,'L' );

$pdf->setXY(17.5,3.1 );
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "จำนวน" ),0,'L' );

$pdf->setXY(19.1,3.1 );
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "หน่วย" ),0,'L' );







$pdf->SetFont('angsa','',14);


$pdf->setX(17.0);
$pdf->MultiCell( 9.0,0.5, iconv( 'UTF-8','cp874' , ""),0 ,'L' );

$i=1;
while($objResult1 = mysqli_fetch_array($objQuery1))
{

$unit_name  =$objResult1["unit_name"];
$product_code1  =$objResult1["access_code"];
$product_code = substr($product_code1,0,15);	
$product_name1  =$objResult1["access_name"];
$product_name = substr($product_name1,0,70);	
$sale_count  =$objResult1["count"];




$pdf->setX(7.6);
$pdf->MultiCell( 9.0,0, iconv( 'UTF-8','cp874' , "$product_code"),0 ,'L' );

$pdf->setX(10.5);
$pdf->Cell(10,0, iconv( 'UTF-8','cp874' , "$product_name"),0 ,'L' );


$pdf->setX(16.9);
$pdf->MultiCell(1.9,0, iconv( 'UTF-8','cp874' , "$sale_count"),0 ,'R' );

$pdf->setX(18.0);
$pdf->MultiCell(2.0,0, iconv( 'UTF-8','cp874' , "$unit_name"),0 ,'R' );


$pdf->setX(18.3);
$pdf->MultiCell( 9.0,0.7, iconv( 'UTF-8','cp874' , ""),0 ,'L' );


$i++;


}

$pdf->setXY(7.4,4.55);
$pdf->Cell(13.0,0,'','T',0,'c',0);     

$pdf->setXY(7.4,5.25);
$pdf->Cell(13.0,0,'','T',0,'c',0);     

$pdf->setXY(7.4,5.95);
$pdf->Cell(13.0,0,'','T',0,'c',0); 

$pdf->setXY(7.4,6.65);
$pdf->Cell(13.0,0,'','T',0,'c',0); 

$pdf->setXY(7.4,7.35);
$pdf->Cell(13.0,0,'','T',0,'c',0); 

$pdf->setXY(7.4,8.05);
$pdf->Cell(13.0,0,'','T',0,'c',0); 

$pdf->setXY(7.4,8.75);
$pdf->Cell(13.0,0,'','T',0,'c',0); 

$pdf->setXY(7.4,9.45);
$pdf->Cell(13.0,0,'','T',0,'c',0); 

$pdf->setXY(7.4,10.15);
$pdf->Cell(13.0,0,'','T',0,'c',0); 

$pdf->setXY(7.4,10.85);
$pdf->Cell(13.0,0,'','T',0,'c',0); 

$pdf->setXY(7.4,11.55);
$pdf->Cell(13.0,0,'','T',0,'c',0); 



$pdf->setXY( 1.4,4.0);
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "วันที่แจ้ง :" ),0,'L' );


$pdf->setXY(3.4,4.55);
$pdf->Cell(4.0,0,'','T',0,'c',0);

$pdf->setXY( 4.0,4.0);
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "$date_jong" ),0,'L' );


$pdf->setXY( 1.4,4.6);
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "ชื่อลูกค้า :" ),0,'L' );

$pdf->setXY( 3.4,5.15);
$pdf->Cell(4.0,0,'','T',0,'c',0);

$pdf->setXY( 3.5,4.6);
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "$customer" ),0,'L' );

$pdf->setXY( 1.4,5.8);
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "วันที่ต้องการรับสินค้า :" ),0,'L' );

$pdf->setXY( 4.7,6.35);
$pdf->Cell(2.7,0,'','T',0,'c',0);

$pdf->setXY(4.7,5.8);
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "$date_receive" ),0,'L' );

$pdf->setXY( 1.4,6.4);
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "ชื่อพนักงาน :" ),0,'L' );

$pdf->setXY( 3.4,6.95);
$pdf->Cell(4.0,0,'','T',0,'c',0);

$pdf->setXY(3.4,6.4);
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "$sale_name " ),0,'L' );

$pdf->setXY( 1.4,7.0);
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "เลขที่ BQ :" ),0,'L' );

$pdf->setXY(3.4,7.0);
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "$bq_no" ),0,'L' );

$pdf->setXY( 3.4,7.55);
$pdf->Cell(4.0,0,'','T',0,'c',0);     

$pdf->setXY( 1.4,7.6);
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "ผู้จองสินค้า :" ),0,'L' );

$pdf->setXY(3.4,8.4);
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "$sale_name " ),0,'L' );

$pdf->setXY( 3.4,9.0);
$pdf->Cell(4.0,0,'','T',0,'c',0);



$pdf->setXY( 1.4,9.3);
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "ผู้อนุมัติ :" ),0,'L' );

if($status_doc == "Approve"){


$pdf->Image("img/cor.jpeg",2.8,9.3,0.9,0.5);


$pdf->setXY(5.5,9.4);
$pdf->MultiCell( 0.40, 0.40 , iconv( 'UTF-8','cp874' , "" ),1,'L' );



}else{

$pdf->setXY( 3.0,9.4);
$pdf->MultiCell( 0.40, 0.40 , iconv( 'UTF-8','cp874' , "" ),1,'L' );

$pdf->Image("img/cor.jpeg",5.3,9.3,0.9,0.5);

}




$pdf->setXY(3.5,9.3);
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "อนุมัติ" ),0,'L' );


$pdf->setXY( 6.0,9.3);
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "ไม่อนุมัติ" ),0,'L' );

$pdf->setXY(3.0,10.5);
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "$approve_name " ),0,'L' );

$pdf->setXY( 2.9,11.1);
$pdf->Cell(4.5,0,'','T',0,'c',0);

$pdf->setXY( 3.5,11.2);
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "$date_approve" ),0,'L' );

$pdf->setXY( 2.9,11.8);
$pdf->Cell(4.5,0,'','T',0,'c',0);

$pdf->setXY( 1.4,12.1);
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "หมายเหตุ :" ),0,'L' );

$pdf->setXY( 3.5,12.1);
$pdf->MultiCell(16.5, 0.6 , iconv( 'UTF-8','cp874' , "$drescription $address_send" ),0,'L' );


$pdf->setXY(3.5,12.7);
$pdf->Cell(16.5,0,'','T',0,'c',0);

$pdf->setXY(3.5,13.3);
$pdf->Cell(16.5,0,'','T',0,'c',0);


$pdf->setXY( 1.4,13.6);
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "คลังสินค้า :" ),0,'L' );

$pdf->setXY( 3.5,13.6);
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "$iv_no" ),0,'L' );


$pdf->setXY(3.5,14.1);
$pdf->Cell(3.5,0,'','T',0,'c',0);

if($register_ckk=='1'){
$pdf->Image("img/cor.jpeg",7.7,13.6,0.9,0.5);

}else{

$pdf->setXY( 8.0,13.7);
$pdf->MultiCell( 0.40, 0.40 , iconv( 'UTF-8','cp874' , "" ),1,'L' );
}

$pdf->setXY( 8.5,13.6);
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "ลงทะเบียน" ),0,'L' );

if($cancel_ckk=='1'){
$pdf->Image("img/cor.jpeg",10.2,13.6,0.9,0.5);

}else{

$pdf->setXY( 10.5,13.7);
$pdf->MultiCell( 0.40, 0.40 , iconv( 'UTF-8','cp874' , "" ),1,'L' );
}

$pdf->setXY( 11.0,13.6);
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "ยกเลิก" ),0,'L' );

$pdf->setXY( 13.0,13.6);
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "หมายเหตุ" ),0,'L' );

$pdf->setXY(14.5,14.1);
$pdf->Cell(5.8,0,'','T',0,'c',0);

$pdf->setXY(14.5,13.6);
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "$remark" ),0,'L' );












$pdf->SetFont('angsa','',11);


 $pdf->setXY( 1.4,14.5);
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "อนุมัติวันที่ 18 มี.ค. 2557" ),0,'L' );


 $pdf->setXY( 18.5,14.5);
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "FM-SA-14:Rev.4" ),0,'L' );


$pdf->Output();
?>



