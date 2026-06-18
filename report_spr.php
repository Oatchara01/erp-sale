<?php

define('FPDF_FONTPATH','font/');
 
require('fpdf.php');

$ref_id=$_GET["ref_id"];

include"dbconnect.php";

$strSQL = "SELECT * FROM hos__spr WHERE ref_id = '".$ref_id."' ";
$objQuery = mysqli_query($conn,$strSQL)or die ("Error Query [".$strSQL."]");;
$objResult = mysqli_fetch_array($objQuery);

$strSQL1 = "SELECT * FROM (hos__subspr LEFT JOIN tb_product ON hos__subspr.product_ID=tb_product.product_id) WHERE ref_idd = '".$ref_id."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);


$strSQL2 = "SELECT SUM(sum_amount) As sum_amount FROM hos__subspr WHERE ref_idd = '".$ref_id."' ";
$objQuery2 = mysqli_query($conn,$strSQL2)or die ("Error Query [".$strSQL2."]");;
$objResult2 = mysqli_fetch_array($objQuery2);

$sum_a = number_format($objResult2["sum_amount"],2)."";

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



 $spr_date = DateThai($objResult['spr_date']);

 $customer = $objResult['customer'];
 $address = $objResult['address'];
 $type_company  = $objResult['type_company'];
 $wo_no  = $objResult['wo_no'];
 $spr_no = $objResult['spr_no'];
 $equipment = $objResult['equipment'];
 $sn_num = $objResult['sn_num'];
 $engineer = $objResult['engineer'];
 $per_no = $objResult['per_no'];
 $clear_brn = $objResult['clear_brn'];
 $brn_no = $objResult['brn_no'];
 $clear_brnp = $objResult['clear_brnp'];
 $brnp_no = $objResult['brnp_no'];
 $clear_epe = $objResult['clear_epe'];
 $epe_no = $objResult['epe_no'];
 $pro_ckk = $objResult['pro_ckk'];
 $sn_ckk = $objResult['sn_ckk'];
 $pro_des = mysqli_real_escape_string($conn,$objResult['pro_des']);
 $sup_name = $objResult['sup_name'];
 $send_cm = $objResult['send_cm'];
 $cm_name = $objResult['cm_name'];
 $comment_cm = $objResult['comment_cm'];
  $cm_date = DateThai($objResult['cm_date']);
 $sup_date = DateThai($objResult['sup_date']);
 $engineer_date = DateThai($objResult['engineer_date']);
if($objResult['date_receive']=='0000-00-00'){
	$date_receive='ไม่ระบุวันที่';
}else{
 $date_receive = DateThai($objResult['date_receive']);
}


if($objResult['date_imstall']=='0001-01-01'){
	$date_imstall='ไม่ระบุวันที่';
}else{
 $date_imstall = DateThai($objResult['date_imstall']);
}

 if($objResult['date_exp']=='0001-01-01'){
 $date_exp = 'ไม่ระบุวันที่';
}else{
 $date_exp = DateThai($objResult['date_exp']);
}
 
$status_doc = $objResult['status_doc'];
$stock_print=$objResult["stock_print"];
if($objResult['stock_date']!='0000-00-00'){
$stock_date = DateThai($objResult['stock_date']); 
}else{
$stock_date ='';	
}
$stock_name = 	$objResult['stock_name'];


$qfirst = "select * from st__signature where ref_id = '".$ref_id."'";
$first = mysqli_query($new,$qfirst);
$ffirst = mysqli_fetch_array($first);

$cus_name = $ffirst["cs_name"];
$cs_dt = DateThai($ffirst["cs_dt"]);

$qfirst2 = "select name,surname from tb_user where em_id = '".$ffirst["cs_code"]."'";
$first2 = mysqli_query($conn,$qfirst2);
$ffirst2 = mysqli_fetch_array($first2);
$name = $ffirst2["name"];
$surname = $ffirst2["surname"];

$cs_name = "$name $surname";

	
$pdf=new FPDF( 'P' , 'cm' , 'A4' );
$pdf->AddFont('angsa','','angsa.php');
$pdf->AddFont('angsana','B','angsab.php');
 
$pdf->AddPage();
$pdf->SetFont('angsana','B',18);

if($type_company=='1'){
$pdf->Image("img/GC.png",1.1,0.5,1.6,0.6);

}else if ($type_company=='2'){
$pdf->Image("img/GCF.jpg",1.1,0.55,1.8,0.4);
$pdf->Image("img/nbm_select.png",1.4,1.1,2.8,1.5);

$pdf->setXY(19.2,0.45);
$pdf->MultiCell(10,0.6, iconv( 'UTF-8','cp874' , "NB" ),0,'L' );

}


$pdf->setXY(1.0,1.0);
$pdf->Cell(19.2,24.0, "",1,1,"c" );

$pdf->setXY(8.5,1.3);
$pdf->MultiCell(9,0.6, iconv( 'UTF-8','cp874' , "ใบเบิกเครื่องและอะไหล่"),0 ,'L' );
$pdf->setXY(7.8,2.0);
$pdf->MultiCell(10, 0.6, iconv( 'UTF-8','cp874' , "(Device and Spare Part Request)"),0 ,'L' );


$pdf->setXY(1.0,2.7);
$pdf->Cell(19.2,0,'','T',0,'C',0);

$pdf->SetFont('angsana','B',14);

$pdf->setXY(17.0,1.2);
$pdf->MultiCell(10,0.6, iconv( 'UTF-8','cp874' , "SPR :" ),0,'L' );

$pdf->setXY(18.0,1.7);
$pdf->Cell(2.0,0,'','T',0,'C',0);

$pdf->setXY(18.0,1.2);
$pdf->MultiCell(10,0.6, iconv( 'UTF-8','cp874' , "$spr_no" ),0,'L' );

$pdf->SetFont('angsa','',15);

$pdf->setXY(1.1,3.0);
$pdf->MultiCell(10,0.6, iconv( 'UTF-8','cp874' , "Engineer :" ),0,'L' );

$pdf->setXY(15.1,3.0);
$pdf->MultiCell(10,0.6, iconv( 'UTF-8','cp874' , "Date :" ),0,'L' );

$pdf->setXY(1.1,3.6);
$pdf->MultiCell(10,0.6, iconv( 'UTF-8','cp874' , "Customer :" ),0,'L' );

$pdf->setXY(15.1,3.6);
$pdf->MultiCell(10,0.6, iconv( 'UTF-8','cp874' , "W/O No. :" ),0,'L' );

$pdf->setXY(1.1,4.2);
$pdf->MultiCell(10,0.6, iconv( 'UTF-8','cp874' , "Address :" ),0,'L' );

$pdf->setXY(1.1,4.8);
$pdf->MultiCell(10,0.6, iconv( 'UTF-8','cp874' , "Equipment :" ),0,'L' );

$pdf->setXY(9.5,4.8);
$pdf->MultiCell(10,0.6, iconv( 'UTF-8','cp874' , "วันที่สินค้าเข้า :" ),0,'L' );

$pdf->setXY(15.1,4.8);
$pdf->MultiCell(10,0.6, iconv( 'UTF-8','cp874' , "S/N :" ),0,'L' );

$pdf->setXY(1.1,5.4);
$pdf->MultiCell(10,0.6, iconv( 'UTF-8','cp874' , "วันที่ติดตั้ง :" ),0,'L' );

$pdf->setXY(9.5,5.4);
$pdf->MultiCell(10,0.6, iconv( 'UTF-8','cp874' , "วันที่หมดประกัน :" ),0,'L' );

$pdf->setXY(15.1,5.4);
$pdf->MultiCell(10,0.6, iconv( 'UTF-8','cp874' , "PER. :" ),0,'L' );



$pdf->SetFont('angsa','',14);
$pdf->setXY(2.9,3.6);
$pdf->Cell(12.0,0,'','T',0,'C',0);

$pdf->setXY(16.1,3.6);
$pdf->Cell(3.8,0,'','T',0,'C',0);

$pdf->setXY(2.9,4.2);
$pdf->Cell(12.0,0,'','T',0,'C',0);

$pdf->setXY(16.9,4.2);
$pdf->Cell(3.0,0,'','T',0,'C',0);

$pdf->setXY(2.9,4.8);
$pdf->Cell(17.0,0,'','T',0,'C',0);

$pdf->setXY(2.9,5.4);
$pdf->Cell(6.5,0,'','T',0,'C',0);

$pdf->setXY(11.8,5.4);
$pdf->Cell(3.2,0,'','T',0,'C',0);

$pdf->setXY(16.3,5.4);
$pdf->Cell(3.5,0,'','T',0,'C',0);

$pdf->setXY(2.9,6.0);
$pdf->Cell(6.5,0,'','T',0,'C',0);

$pdf->setXY(12.2,6.0);
$pdf->Cell(2.8,0,'','T',0,'C',0);

$pdf->setXY(16.3,6.0);
$pdf->Cell(3.5,0,'','T',0,'C',0);



$pdf->setXY(2.9,3.0);
$pdf->MultiCell(10,0.6, iconv( 'UTF-8//IGNORE','cp874//IGNORE' , "$engineer" ),0,'L' );

$pdf->setXY(17.2,3.0);
$pdf->MultiCell(10,0.6, iconv( 'UTF-8','cp874' , "$spr_date" ),0,'L' );

$pdf->setXY(2.9,3.6);
$pdf->MultiCell(12,0.6, iconv( 'UTF-8//IGNORE','cp874//IGNORE' , "$customer" ),0,'L' );


$pdf->setXY(17.2,3.6);
$pdf->MultiCell(10,0.6, iconv( 'UTF-8//IGNORE','cp874//IGNORE' , "$wo_no" ),0,'L' );

$pdf->setXY(2.9,4.2);
$pdf->MultiCell(17,0.6, iconv( 'UTF-8//IGNORE','cp874//IGNORE' , "$address" ),0,'L' );

$pdf->setXY(2.9,4.8);
$pdf->MultiCell(8.0,0.6, iconv( 'UTF-8//IGNORE','cp874//IGNORE' , "$equipment" ),0,'L' );

$pdf->setXY(12.2,4.8);
$pdf->MultiCell(8.0,0.6, iconv( 'UTF-8','cp874' , "$date_receive" ),0,'L' );

if($sn_ckk=='0'){

$pdf->setXY(16.5,4.8);
$pdf->MultiCell(8.0,0.6, iconv( 'UTF-8//IGNORE','cp874//IGNORE' , "$sn_num" ),0,'L' );

}else{

$pdf->setXY(16.5,4.8);
$pdf->MultiCell(8.0,0.6, iconv( 'UTF-8','cp874' , "ตามเอกสารแนบท้าย" ),0,'L' );
	
}
	
$pdf->setXY(2.9,5.4);
$pdf->MultiCell(8.0,0.6, iconv( 'UTF-8','cp874' , "$date_imstall" ),0,'L' );

$pdf->setXY(12.2,5.4);
$pdf->MultiCell(8.0,0.6, iconv( 'UTF-8','cp874' , "$date_exp" ),0,'L' );

$pdf->setXY(16.5,5.4);
$pdf->MultiCell(8.0,0.6, iconv( 'UTF-8','cp874' , "$per_no" ),0,'L' );



$pdf->setXY(1.2,6.5);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(1.2,7.2);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(1.2,7.9);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(1.2,8.6);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(1.2,9.3);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(1.2,10.0);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(1.2,10.7);
$pdf->Cell(1.0,0.7, "",1,1,"c" );

$pdf->setXY(1.2,11.4);
$pdf->Cell(1.0,0.7, "",1,1,"c" );




$pdf->setXY(1.3,6.5 );
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "Item" ),0,'L' );

$pdf->setXY(2.2,6.5);
$pdf->Cell(10.0,0.7, "",1,1,"c" );

$pdf->setXY(2.2,7.2);
$pdf->Cell(10.0,0.7, "",1,1,"c" );

$pdf->setXY(2.2,7.9);
$pdf->Cell(10.0,0.7, "",1,1,"c" );

$pdf->setXY(2.2,8.6);
$pdf->Cell(10.0,0.7, "",1,1,"c" );

$pdf->setXY(2.2,9.3);
$pdf->Cell(10.0,0.7, "",1,1,"c" );

$pdf->setXY(2.2,10.0);
$pdf->Cell(10.0,0.7, "",1,1,"c" );

$pdf->setXY(2.2,10.7);
$pdf->Cell(10.0,0.7, "",1,1,"c" );

$pdf->setXY(2.2,11.4);
$pdf->Cell(10.0,0.7, "",1,1,"c" );



$pdf->setXY(6.2,6.5 );
$pdf->MultiCell(9.0, 0.6 , iconv( 'UTF-8','cp874' ,"Description"),0,'L' );

$pdf->setXY(12.2,6.5);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(12.2,7.2);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(12.2,7.9);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(12.2,8.6);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(12.2,9.3);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(12.2,10.0);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(12.2,10.7);
$pdf->Cell(1.2,0.7, "",1,1,"c" );

$pdf->setXY(12.2,11.4);
$pdf->Cell(1.2,0.7, "",1,1,"c" );




$pdf->setXY(12.4,6.5 );
$pdf->MultiCell(9.0, 0.6 , iconv( 'UTF-8','cp874' ,"Qty."),0,'L' );

$pdf->setXY(13.4,6.5);
$pdf->Cell(1.5,0.7, "",1,1,"c" );

$pdf->setXY(13.4,7.2);
$pdf->Cell(1.5,0.7, "",1,1,"c" );

$pdf->setXY(13.4,7.9);
$pdf->Cell(1.5,0.7, "",1,1,"c" );

$pdf->setXY(13.4,8.6);
$pdf->Cell(1.5,0.7, "",1,1,"c" );

$pdf->setXY(13.4,9.3);
$pdf->Cell(1.5,0.7, "",1,1,"c" );

$pdf->setXY(13.4,10.0);
$pdf->Cell(1.5,0.7, "",1,1,"c" );

$pdf->setXY(13.4,10.7);
$pdf->Cell(1.5,0.7, "",1,1,"c" );

$pdf->setXY(13.4,11.4);
$pdf->Cell(1.5,0.7, "",1,1,"c" );



$pdf->setXY(13.75,6.5 );
$pdf->MultiCell(9.0, 0.6 , iconv( 'UTF-8','cp874' ,"Unit"),0,'L' );

$pdf->setXY(14.9,6.5);
$pdf->Cell(2.0,0.7, "",1,1,"c" );

$pdf->setXY(14.9,7.2);
$pdf->Cell(2.0,0.7, "",1,1,"c" );

$pdf->setXY(14.9,7.9);
$pdf->Cell(2.0,0.7, "",1,1,"c" );

$pdf->setXY(14.9,8.6);
$pdf->Cell(2.0,0.7, "",1,1,"c" );

$pdf->setXY(14.9,9.3);
$pdf->Cell(2.0,0.7, "",1,1,"c" );

$pdf->setXY(14.9,10.0);
$pdf->Cell(2.0,0.7, "",1,1,"c" );

$pdf->setXY(14.9,10.7);
$pdf->Cell(2.0,0.7, "",1,1,"c" );

$pdf->setXY(14.9,11.4);
$pdf->Cell(2.0,0.7, "",1,1,"c" );

$pdf->setXY(14.9,12.1);
$pdf->Cell(2.0,0.7, "",1,1,"c" );



$pdf->setXY(15.15,6.5 );
$pdf->MultiCell(9.0, 0.6 , iconv( 'UTF-8','cp874' ,"Unit Price"),0,'L' );


$pdf->setXY(16.9,6.5);
$pdf->Cell(3.0,0.7, "",1,1,"c" );

$pdf->setXY(16.9,7.2);
$pdf->Cell(3.0,0.7, "",1,1,"c" );

$pdf->setXY(16.9,7.9);
$pdf->Cell(3.0,0.7, "",1,1,"c" );

$pdf->setXY(16.9,8.6);
$pdf->Cell(3.0,0.7, "",1,1,"c" );

$pdf->setXY(16.9,9.3);
$pdf->Cell(3.0,0.7, "",1,1,"c" );

$pdf->setXY(16.9,10.0);
$pdf->Cell(3.0,0.7, "",1,1,"c" );

$pdf->setXY(16.9,10.7);
$pdf->Cell(3.0,0.7, "",1,1,"c" );

$pdf->setXY(16.9,11.4);
$pdf->Cell(3.0,0.7, "",1,1,"c" );

$pdf->setXY(16.9,12.1);
$pdf->Cell(3.0,0.7, "",1,1,"c" );

$pdf->setXY(17.8,6.5 );
$pdf->MultiCell(9.0, 0.6 , iconv( 'UTF-8','cp874' ,"Amount"),0,'L' );



$pdf->SetFont('angsa','',14);


$pdf->setX(17.0);
$pdf->MultiCell(2.0,0.5, iconv( 'UTF-8','cp874' , ""),0 ,'L' );


$i=1;
while($objResult1 = mysqli_fetch_array($objQuery1))
{

$unit_name  =$objResult1["unit_name"];
$product_name1  =$objResult1["access_name"];
$product_name = substr($product_name1,0,70);	
$sale_count  =$objResult1["sale_count"];
$unit_price  =number_format($objResult1["unit_price"],2)."";
$sale_remark  =$objResult1["sale_remark"];
$sum_amount =number_format($objResult1["sum_amount"],2)."";


$pdf->setX(1.5);
$pdf->MultiCell( 9.0,0, iconv( 'UTF-8','cp874' , "$i"),0 ,'L' );
	
$pdf->SetFont('angsa','',10);
$pdf->setX(2.2);
$pdf->Cell(10,0, iconv( 'UTF-8//IGNORE','cp874//IGNORE' , "$product_name $sale_remark"),0 ,'L' );

$pdf->SetFont('angsa','',14);
$pdf->setX(11.9);
$pdf->MultiCell(1.5,0, iconv( 'UTF-8','cp874' , "$sale_count"),0 ,'R' );

$pdf->setX(13.5);
$pdf->MultiCell(1.5,0, iconv( 'UTF-8','cp874' , "$unit_name"),0 ,'C' );

$pdf->setX(14.9);
$pdf->MultiCell(2.0,0, iconv( 'UTF-8','cp874' , "$unit_price"),0 ,'R' );

$pdf->setX(16.9);
$pdf->MultiCell(3.0,0, iconv( 'UTF-8','cp874' , "$sum_amount"),0 ,'R' );


$pdf->setX(18.3);
$pdf->MultiCell( 9.0,0.7, iconv( 'UTF-8','cp874' , ""),0 ,'L' );


$i++;


}

$pdf->setXY(16.0,12.1);
$pdf->MultiCell(9.0, 0.6 , iconv( 'UTF-8','cp874' ,"Total"),0,'L' );


$pdf->setXY(16.9,12.1);
$pdf->MultiCell(3.0, 0.6 , iconv( 'UTF-8','cp874' ,"$sum_a"),0,'R' );

if($clear_brn=='1'){
$pdf->Image("img/cor.jpeg",1.1,13.0,1.0,0.60);
}else{
$pdf->setXY(1.3,13.2);
$pdf->Cell(0.4,0.3, "",1,1,"c" );
}

$pdf->setXY(1.8,13.1 );
$pdf->MultiCell(9.0, 0.6 , iconv( 'UTF-8','cp874' ,"Clear ใบยืมติดเล่มเลขที่"),0,'L' );

$pdf->setXY(5.0,13.6);
$pdf->Cell(1.5,0,'','T',0,'C',0);

$pdf->setXY(5.0,13.1 );
$pdf->MultiCell(9.0, 0.6 , iconv( 'UTF-8','cp874' ,"$brn_no"),0,'L' );


if($clear_brnp=='1'){
$pdf->Image("img/cor.jpeg",6.5,13.0,1.0,0.60);

}else{
$pdf->setXY(6.7,13.2);
$pdf->Cell(0.4,0.3, "",1,1,"c" );

}

$pdf->setXY(7.2,13.1 );
$pdf->MultiCell(9.0, 0.6 , iconv( 'UTF-8','cp874' ,"Clear ใบยืมกระดาษต่อเนื่องเลขที่ "),0,'L' );

$pdf->setXY(11.8,13.6);
$pdf->Cell(1.5,0,'','T',0,'C',0);

$pdf->setXY(11.8,13.1 );
$pdf->MultiCell(9.0, 0.6 , iconv( 'UTF-8','cp874' ,"$brnp_no"),0,'L' );

if($clear_epe=='1'){

$pdf->Image("img/cor.jpeg",13.2,13.0,1.0,0.60);
}else{
$pdf->setXY(13.5,13.2);
$pdf->Cell(0.4,0.3, "",1,1,"c" );
}

$pdf->setXY(13.9,13.1 );
$pdf->MultiCell(9.0, 0.6 , iconv( 'UTF-8','cp874' ,"ของเสียส่งไปต่างประเทศตาม EPE"),0,'L' );

$pdf->setXY(18.6,13.1);
$pdf->MultiCell(9.0, 0.6 , iconv( 'UTF-8','cp874' ,"$epe_no"),0,'L' );

$pdf->setXY(18.5,13.6);
$pdf->Cell(1.5,0,'','T',0,'C',0);

$pdf->setXY(1.0,14.0);
$pdf->Cell(19.1,0,'','T',0,'C',0);

if($pro_ckk=='1'){

$pdf->Image("img/cor.jpeg",1.8,14.3,1.0,0.60);
}else{
$pdf->setXY(2.0,14.5);
$pdf->Cell(0.4,0.3, "",1,1,"c" );
}

$pdf->setXY(2.6,14.3 );
$pdf->MultiCell(9.0, 0.6 , iconv( 'UTF-8','cp874' ,"อะไหล่คืนใช้งานไม่ได้"),0,'L' );

if($pro_ckk=='2'){
$pdf->Image("img/cor.jpeg",7.8,14.3,1.0,0.60);
}else{
$pdf->setXY(8.0,14.5);
$pdf->Cell(0.4,0.3, "",1,1,"c" );
}

$pdf->setXY(8.6,14.3 );
$pdf->MultiCell(9.0, 0.6 , iconv( 'UTF-8','cp874' ,"อะไหล่คืนใช้งานได้ แต่สภาพไม่สมบูรณ์ (โปรดกรอกรายละเอียด)"),0,'L' );

$pdf->setXY(1.2,15.2);
$pdf->MultiCell(9.0, 0.6 , iconv( 'UTF-8','cp874' ,"อาการเสีย :"),0,'L' );

$pdf->setXY(2.8,15.0);
$pdf->MultiCell(17.0, 0.4 , iconv('UTF-8','cp874//ASCII//TRANSLIT//IGNORE',"$pro_des"),0,'L');


$pdf->setXY(2.8,15.8);
$pdf->Cell(17.0,0,'','T',0,'C',0);


$pdf->setXY(3.0,16.4 );
$pdf->MultiCell(9.0, 0.6 , iconv( 'UTF-8','cp874' ,"$engineer/$engineer_date"),0,'L' );

$pdf->setXY(2.5,17.0);
$pdf->Cell(4.0,0,'','T',0,'C',0);

$pdf->setXY(3.3,17.0 );
$pdf->MultiCell(9.0, 0.6 , iconv( 'UTF-8','cp874' ,"Engineer/Date"),0,'L' );


$pdf->setXY(16.0,16.4);
$pdf->MultiCell(9.0, 0.6 , iconv( 'UTF-8','cp874' ,"$sup_name/$sup_date"),0,'L' );


$pdf->setXY(15.5,17.0);
$pdf->Cell(4.0,0,'','T',0,'C',0);

$pdf->setXY(16.3,17.0 );
$pdf->MultiCell(9.0, 0.6 , iconv( 'UTF-8','cp874' ,"Supervisor/Date"),0,'L' );


$pdf->setXY(1.0,17.8);
$pdf->Cell(19.1,0,'','T',0,'C',0);



$pdf->setXY(1.2,18.3);
$pdf->MultiCell(9.0, 0.6 , iconv( 'UTF-8','cp874' ,"Comment :"),0,'L' );

$pdf->setXY(2.8,18.3);
$pdf->MultiCell(17.0, 0.6 , iconv( 'UTF-8','cp874' ,"$comment_cm"),0,'L' );


$pdf->setXY(2.8,18.9);
$pdf->Cell(17.0,0,'','T',0,'C',0);


$pdf->setXY(16.0,19.4);
$pdf->MultiCell(9.0, 0.6 , iconv( 'UTF-8','cp874' ,"$cm_name/$cm_date"),0,'L' );


$pdf->setXY(15.5,20.0);
$pdf->Cell(4.0,0,'','T',0,'C',0);

$pdf->setXY(16.3,20.0 );
$pdf->MultiCell(9.0, 0.6 , iconv( 'UTF-8','cp874' ,"Supervisor/Date"),0,'L' );

if($status_doc =='Approve'){

$pdf->Image("img/cor.jpeg",1.1,19.6,1.0,0.60);

}else if($status_doc =='Rejected'){

$pdf->setXY(1.4,19.8);
$pdf->Cell(0.4,0.3, "",1,1,"c" );

$pdf->Image("img/cor.jpeg",3.1,19.6,1.0,0.60);
}else{

$pdf->setXY(1.4,19.8);
$pdf->Cell(0.4,0.3, "",1,1,"c" );
$pdf->setXY(3.4,19.8);
$pdf->Cell(0.4,0.3, "",1,1,"c" );


}

$pdf->setXY(2.1,19.6);
$pdf->MultiCell(20, 0.6 , iconv( 'UTF-8','cp874' , "YES" ),0,'L' );


$pdf->setXY(3.9,19.6);
$pdf->MultiCell(20, 0.6 , iconv( 'UTF-8','cp874' , "NO" ),0,'L' );

$pdf->setXY(1.0,20.8);
$pdf->Cell(19.1,0,'','T',0,'C',0);


$pdf->setXY(1.9,21);
$pdf->MultiCell(9.0, 0.6 , iconv( 'UTF-8','cp874' ,"ผู้รับเอกสาร (Stock)"),0,'L' );

if($stock_print!=''){
$pdf->setXY(1.9,22.4);
$pdf->MultiCell(9.0, 0.6 , iconv( 'UTF-8','cp874' ," $stock_print "),0,'L' );
}
$pdf->setXY(1.9,23.0);
$pdf->Cell(3.0,0,'','T',0,'C',0);


if($stock_print!=''){
$pdf->setXY(2.2,23.1);
$pdf->MultiCell(9.0, 0.6 , iconv( 'UTF-8','cp874' ," $stock_date "),0,'L' );
}
$pdf->setXY(1.9,23.3);
$pdf->MultiCell(9.0, 0.6 , iconv( 'UTF-8','cp874' ,"................................"),0,'L' );


$pdf->setXY(1.4,24.5);
$pdf->Cell(0.4,0.3, "",1,1,"c" );

$pdf->setXY(1.9,24.3);
$pdf->MultiCell(9.0, 0.6 , iconv( 'UTF-8','cp874' ,"ได้รับอะไหล่ครบถ้วน"),0,'L' );



$pdf->setXY(1.0,20.8);
$pdf->Cell(5.0,4.2, "",1,1,"c" );

$pdf->setXY(6.9,21);
$pdf->MultiCell(9.0, 0.6 , iconv( 'UTF-8','cp874' ,"ผู้รับสินค้า (ช่าง)"),0,'L' );

$pdf->setXY(6.9,23.0);
$pdf->Cell(3.0,0,'','T',0,'C',0);

$pdf->setXY(6.9,23.3);
$pdf->MultiCell(9.0, 0.6 , iconv( 'UTF-8','cp874' ,"................................"),0,'L' );
		  
if($cs_name!=' '){
	
$pdf->Image("$cus_name",7.1,21.8,2.0,0.5,'png');
	
$pdf->setXY(7.1,22.4);
$pdf->MultiCell(9.0, 0.6 , iconv( 'UTF-8','cp874' ," $cs_name "),0,'L' );
}
if($cs_name!=' '){
$pdf->setXY(7.2,23.1);
$pdf->MultiCell(9.0, 0.6 , iconv( 'UTF-8','cp874' ," $cs_dt "),0,'L' );
}

$pdf->setXY(6.4,24.5);
$pdf->Cell(0.4,0.3, "",1,1,"c" );

$pdf->setXY(6.9,24.3);
$pdf->MultiCell(9.0, 0.6 , iconv( 'UTF-8','cp874' ,"ได้รับอะไหล่ครบถ้วน"),0,'L' );


$pdf->setXY(6.0,20.8);
$pdf->Cell(4.5,4.2, "",1,1,"c" );


$pdf->setXY(11.9,21);
$pdf->MultiCell(9.0, 0.6 , iconv( 'UTF-8','cp874' ,"ผู้จ่ายสินค้า (Stock)"),0,'L' );

$pdf->setXY(11.9,23.0);
$pdf->Cell(3.0,0,'','T',0,'C',0);

if($stock_name!=''){
$pdf->setXY(12.1,22.4);
$pdf->MultiCell(9.0, 0.6 , iconv( 'UTF-8','cp874' ," $stock_name "),0,'L' );
}
if($stock_name!=''){
$pdf->setXY(12.2,23.1);
$pdf->MultiCell(9.0, 0.6 , iconv( 'UTF-8','cp874' ," $stock_date "),0,'L' );
}
$pdf->setXY(11.9,23.3);
$pdf->MultiCell(9.0, 0.6 , iconv( 'UTF-8','cp874' ,"................................"),0,'L' );


$pdf->setXY(16.4,21.5);
$pdf->Cell(0.4,0.3, "",1,1,"c" );

$pdf->setXY(16.9,21.3);
$pdf->MultiCell(9.0, 0.6 , iconv( 'UTF-8','cp874' ,"จากคลังสินค้าชำรุด"),0,'L' );


$pdf->setXY(16.4,22.5);
$pdf->Cell(0.4,0.3, "",1,1,"c" );

$pdf->setXY(16.9,22.3);
$pdf->MultiCell(9.0, 0.6 , iconv( 'UTF-8','cp874' ,"เข้า Stock ชำรุด"),0,'L' );


$pdf->setXY(16.4,23.5);
$pdf->Cell(0.4,0.3, "",1,1,"c" );

$pdf->setXY(16.9,23.3);
$pdf->MultiCell(9.0, 0.6 , iconv( 'UTF-8','cp874' ,"ทำลาย"),0,'L' );




$pdf->SetFont('angsa','U',12);

$pdf->setXY(1.0,25.4);
$pdf->MultiCell(20, 0.6 , iconv( 'UTF-8','cp874' , "คำแนะนำ" ),0,'L' );


$pdf->SetFont('angsa','',12);

$pdf->setXY(2.5,25.2);
$pdf->MultiCell(20, 0.6 , iconv( 'UTF-8','cp874' , "กรณีที่เบิกอะไหล่ประเภท 1.สินค้าชำรุดแรกเข้า 2.ใช้ในการแลกเปลี่ยนเครื่อง และอะไหล่ที่ไม่สมบูรณ์ ที่อยู่ในระยรับประกัน" ),0,'L' );

$pdf->setXY( 2.5,25.8);
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "จะต้องเขียนใบ Product Error Report ก่อนเขียนเอกสารฉบับนี้ทุกครั้ง" ),0,'L' );

if($type_company=='1'){


 $pdf->setXY( 1.0,26.5);
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "อนุมัติวันที่ 18 มี.ค. 2557" ),0,'L' );


 $pdf->setXY( 18.1,26.5);
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "FM-EN-02:Rev.6" ),0,'L' );

}else if($type_company=='2'){

 $pdf->setXY( 18.1,26.5);
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "150360:Rev.2" ),0,'L' );

}

if($sn_ckk=='1'){
$pdf->AddPage();
	
	
$pdf->SetFont('angsana','B',18);
$pdf->setXY(1.0,1.0);
$pdf->Cell(19.2,24.0, "",1,1,"c" );

$pdf->setXY(8.5,1.3);
$pdf->MultiCell(9,0.6, iconv( 'UTF-8','cp874' , "หมายเลขเครื่อง"),0 ,'L' );	

$pdf->SetFont('angsa','',14);	
	
$pdf->setXY(2.0,2.5);
$pdf->MultiCell(19.0,0.6, iconv( 'UTF-8','cp874' , "$sn_num" ),0,'L' );	
}

$pdf->Output();
?>



