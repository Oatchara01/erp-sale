<?php

define('FPDF_FONTPATH','font/');

require('ean13.php');



$ref_id=$_GET["ref_id"];



include"dbconnect.php";

$strSQL = "SELECT
so__main.* ,tb_salechannel.*, tb_delivery.* , tb_payment.* FROM (((so__main LEFT JOIN tb_salechannel ON so__main.sale_channel=tb_salechannel.salechannel_ID)LEFT JOIN tb_delivery ON so__main.delivery=tb_delivery.delivery_ID)LEFT JOIN tb_payment ON so__main.payment=tb_payment.payment_ID) WHERE ref_id = '".$ref_id."' ";
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




$ref_id=$objResult["ref_id"];
$delivery =$objResult["delivery"];
$time_send =$objResult["time_send"];
$description_wrap=$objResult["description_wrap"];
$time_description="$time_send $description_wrap";
$job_id =$objResult["job_id"];
$date = date('d-m-Y H:i:s');
$prefor_name=$objResult["prefer_name"];
$register_date=DateThai($objResult["register_date"]);

$date1 = explode('-' , $register_date );
$newDate = $date1[2].'-'.$date1[1].'-'.$date1[0];

$register_time =$objResult["register_time"];

$doc_no =$objResult["doc_no"];
$address1 =$objResult["address1"];
$address2 =$objResult["address2"];
$province_name =$objResult["province_name"];
$zip_code  =$objResult["zip_code"];
$delivery_place =$objResult["delivery_place"];

$postcode =$objResult["postcode"];
$return_contact =$objResult["return_contact"];
$customer_name =$objResult["customer_name"];
$po_no  =$objResult["po_no"];
$salechannel_nameshort =$objResult["salechannel_nameshort"];
$sn =$objResult["sn"];
$bq =$objResult["bq"];
$ot =$objResult["ot"];

$delivery_company =$objResult["delivery_company"];
$delivery_sale =$objResult["delivery_sale"];
$deliver_engineer =$objResult["deliver_engineer"];
$big_car =$objResult["big_car"];
$maps =$objResult["maps"];
$delivery_date  =DateThai($objResult["delivery_date"]);


$delivery_time  =$objResult["delivery_time"];
$call_before  =$objResult["call_before"];
$assign_date_time  =$objResult["assign_date_time"];
$sale_remarkk = $objResult["sale_remark"];
$returns = $objResult["returns"];
$return_address = $objResult["return_address"];
$return_contact = $objResult["return_contact"];
$employee_name = $objResult["employee_name"];
$approve_name = $objResult["approve_name"];

$billing_name = $objResult["billing_name"];
$billing_address = $objResult["billing_address"];
$billing_tel =  $objResult["billing_tel"];
$delivery_contract=  $objResult["delivery_contract"];

$discount=  $objResult["discount"];
$full_bill =  $objResult["full_bill"];
$with_pr   =  $objResult["with_pr"];
$clear_book_no   =  $objResult["clear_book_no"];
$clear_brn_no   =  $objResult["clear_brn_no"];
$clear_brnp_no   =  $objResult["clear_brnp_no"];

$type_com   =  $objResult["type_com"];
$type_po   =  $objResult["type_po"];
$type_type   =  $objResult["type_type"];
$type_type_detail   =  $objResult["type_type_detail"];


$waranty   =  $objResult["waranty"];
$cal   =  $objResult["cal"];
$pm   =  $objResult["pm"];
$install_place   =  $objResult["install_place"];

$time_delivery=$objResult["time_delivery"];
$packing_remark =$objResult["packing_remark"];
$deposit_no  =$objResult["deposit_no"];

$clear_book_ckk   =  $objResult["clear_book_ckk"];
$clear_brn_no_ckk   =  $objResult["clear_brn_no_ckk"];
$clear_brnp_no_ckk   =  $objResult["clear_brnp_no_ckk"];
$sn_ckk   =  $objResult["sn_ckk"];
$bq_ckk   =  $objResult["bq_ckk"];
$ot_ckk   =  $objResult["ot_ckk"];
$delivery_contact  =  $objResult["delivery_contact"];
$delivery_name =   $objResult["delivery_name"];
$tel =   $objResult["tel"];
$payment_name =   $objResult["payment_name"];
$pament =$objResult["pament"];



$pdf=new FPDF( 'P' , 'cm' , 'A4' );
 




/////////////////////////

$pdf=new PDF_Code128();
$pdf->AddPage();
$pdf->AddFont('angsa','','angsa.php');
$pdf->AddFont('angsana','B','angsab.php');
$pdf->AddFont('times','','times.php');


$pdf->SetFont('angsa','',14);

$pdf->Image("img/nb_logo.jpg",55,16,28,12);


$pdf->Code128(170,25,$doc_no,25,8);




$pdf->SetXY(170,35);

$pdf->MultiCell(20, 0.6 , iconv( 'UTF-8','cp874' , "$doc_no"),0 ,'L' );



$pdf->SetFont('angsana','B',18);



$pdf->setXY(160,8);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "$delivery_name"),0 ,'L' );



$pdf->SetFont('angsana','BU',20);

$pdf->setXY(98,20 );
$pdf->MultiCell(90, 0.6, iconv( 'UTF-8','cp874' , "ใบสั่งขาย"),0 ,'L' );
$pdf->setXY(90,25 );
$pdf->MultiCell(100,0.6, iconv( 'UTF-8','cp874' , "(SALE ORDER)"),0 ,'L' );
$pdf->SetFont('angsa','',10);

$pdf->setXY( 40,5  );
$pdf->MultiCell(40,5.0, iconv( 'UTF-8','cp874' , "$time_delivery $packing_remark"),0 ,'L' );

$pdf->SetFont('angsa','',14);

$pdf->setXY( 10,20);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "เลขที่อ้างอิง :"),0 ,'L' );

$pdf->setXY( 28,20);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "$ref_id"),0 ,'L' );

$pdf->setXY( 10,13);
$pdf->MultiCell(3,3, iconv( 'UTF-8','cp874' , "" ),1,'L' );
$pdf->setXY(13,14);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "ก" ),0,'L' );

$pdf->setXY(20,13);
$pdf->MultiCell(3,3, iconv( 'UTF-8','cp874' , "" ),1,'L' );
$pdf->setXY(23,14);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "C" ),0,'L' );


$pdf->setXY( 158,16);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "ฝากสินค้าเลขที่ "),0 ,'L' );

$pdf->setXY(180,16);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "$deposit_no"),0 ,'L' );



$pdf->setXY(180,19);
$pdf->Cell(20,0,'','T',0,'c',0);


$pdf->setXY(158,22);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "วันที่"),0 ,'L' );
$pdf->setXY(166,22);
$pdf->MultiCell(124,0.6 , iconv( 'UTF-8','cp874' , "$register_date"),0 ,'L' );

$pdf->setXY(185,22);
$pdf->MultiCell(124,0.6 , iconv( 'UTF-8','cp874' , "$register_time"),0 ,'L' );



$pdf->setXY(10,26);
$pdf->MultiCell(90,0.6, iconv( 'UTF-8','cp874' , "เลขที่ลงงาน"),0 ,'L' );
$pdf->setXY(28,26);
$pdf->MultiCell(90,0.6, iconv( 'UTF-8','cp874' , "$job_id"),0 ,'L' );


$pdf->setXY(28,29);
$pdf->Cell(20,0,'','T',0,'c',0);



$pdf->setXY( 10,36);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "ชื่อผู้แนะนำ/รพ./แผนก"),0 ,'L' );
$pdf->setXY(42,36);
$pdf->MultiCell(160, 0.6 , iconv( 'UTF-8','cp874' , "$prefor_name"),0 ,'L' );

$pdf->setXY(42,39);
$pdf->Cell(160,0,'','T',0,'c',0);


$pdf->setXY(10,42);
$pdf->MultiCell(90,0.6,iconv( 'UTF-8','cp874' , "ชื่อที่ต้องการออกบิล"),0 ,'L' );
$pdf->setXY(42,42);
$pdf->MultiCell(160,0.6,iconv( 'UTF-8','cp874' , "$billing_name"),0 ,'L' );

$pdf->setXY(42,45);
$pdf->Cell(160,0,'','T',0,'c',0);


$pdf->setXY( 10,48);
$pdf->MultiCell(90,0.6, iconv( 'UTF-8','cp874' , "ที่อยู่ที่ต้องการออกบิล"),0 ,'L' );
$pdf->setXY(42,45);
$pdf->MultiCell(160,6.0, iconv( 'UTF-8','cp874' , "$billing_address"),0 ,'L' );
$pdf->setXY(42,51);
$pdf->Cell(160,0,'','T',0,'c',0);



$pdf->setXY(42,57);
$pdf->Cell(160,0,'','T',0,'c',0);


$pdf->setXY(10,60);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "เบอร์โทร"),0 ,'L' );
$pdf->setXY(42,60);
$pdf->MultiCell(160, 0.6 , iconv( 'UTF-8','cp874' , "$billing_tel"),0 ,'L' );


$pdf->setXY(42,63);
$pdf->Cell(160,0,'','T',0,'c',0);





$pdf->setXY(10,66);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "สถานที่ส่งสินค้า"),0 ,'L' );
$pdf->setXY(42,66);
$pdf->MultiCell(160, 0.6 , iconv( 'UTF-8','cp874' , "$delivery_place"),0 ,'L' );
$pdf->setXY(42,69);
$pdf->Cell(160,0,'','T',0,'c',0);


$pdf->setXY(10,72);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "ชื่อผู้ติดต่อ/โทร"),0 ,'L' );
$pdf->setXY(37,72);
$pdf->MultiCell(75, 0.6 , iconv( 'UTF-8','cp874' , "$delivery_contact"),0 ,'L' );
$pdf->setXY(37,75);
$pdf->Cell(70,0,'','T',0,'c',0);

$pdf->setXY(110,72);
$pdf->MultiCell(90,0.6, iconv( 'UTF-8','cp874' , "เบอร์โทร"),0 ,'L' );

$pdf->setXY(130,72);
$pdf->MultiCell(75, 0.6 , iconv( 'UTF-8','cp874' , "$tel"),0 ,'L' );

$pdf->setXY(130,75);
$pdf->Cell(72,0,'','T',0,'c',0);



$pdf->setXY( 10,78);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "ใบสั่งซื้อเลขที่"),0 ,'L' );
$pdf->setXY(42,78);
$pdf->MultiCell(40, 0.6 , iconv( 'UTF-8','cp874' , "$po_no"),0 ,'L' );
$pdf->setXY(42,81);
$pdf->Cell(55,0,'','T',0,'c',0);

$pdf->setXY(110,78);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "กำหนดส่งตามสัญญา"),0 ,'L' );

$pdf->setXY(140,78);
$pdf->MultiCell(40, 0.6 , iconv( 'UTF-8','cp874' , "$delivery_contract"),0 ,'L' );

$pdf->setXY(140,81);
$pdf->Cell(62,0,'','T',0,'c',0);

$pdf->setXY( 10,85);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "ชำระโดย"),0 ,'L' );

if ($payment_name==''){

$pdf->setXY(25,84);
$pdf->MultiCell(3,3, iconv( 'UTF-8','cp874' , "" ),1,'L' );
}else{

	$pdf->Image("img/cor.jpeg",24.5,82,8,5);

}

$pdf->setXY(30,85);
$pdf->MultiCell(90,0.6 , iconv( 'UTF-8','cp874' , "$payment_name"),0 ,'L' );


$pdf->setXY(110,84);
$pdf->MultiCell(3,3, iconv( 'UTF-8','cp874' , "" ),1,'L' );


$pdf->setXY(115,85);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "อื่นๆ"),0 ,'L' );










$pdf->SetFont('angsa','',14);


$pdf->setXY(10,92);
$pdf->Cell(15,50, "",1,1,"c" );

$pdf->setXY(25,92);
$pdf->Cell(30,50, "",1,1,"c" );

$pdf->setXY(55,92);
$pdf->Cell(109,50, "",1,1,"c" );

$pdf->setXY(146,92);
$pdf->Cell(18,50, "",1,1,"c" );


$pdf->setXY(164,92);
$pdf->Cell(19,50, "",1,1,"c" );

$pdf->setXY(183,92);
$pdf->Cell(19,50, "",1,1,"c" );

$pdf->setXY( 10,142);
$pdf->Cell(136,8, "",1,1,"c" );

$pdf->setXY(183,142);
$pdf->Cell(19,8, "",1,1,"c" );


$pdf->setXY(146,142);
$pdf->Cell(37,8, "",1,1,"c" );


$pdf->setXY( 10,150);
$pdf->Cell(136,8, "",1,1,"c" );

$pdf->setXY(146,150);
$pdf->Cell(37,8, "",1,1,"c" );




$pdf->setXY(183,150);
$pdf->Cell(19,8, "",1,1,"c" );




$pdf->setXY(10,98);
$pdf->Cell(192,0,'','T',0,'c',0);

$pdf->setXY( 12,94);
$pdf->MultiCell( 90, 0.6 , iconv( 'UTF-8','cp874' , "ลำดับ"),0 ,'L' );


$pdf->setXY(30,94);
$pdf->MultiCell( 90, 0.6 , iconv( 'UTF-8','cp874' , "รหัสสินค้า"),0 ,'L' );

$pdf->setXY(95,94);
$pdf->MultiCell( 90, 0.6 , iconv( 'UTF-8','cp874' , "รายละเอียด"),0 ,'L' );

$pdf->setXY(150,94);
$pdf->MultiCell( 90,1.0, iconv( 'UTF-8','cp874' , "จำนวน"),0 ,'L' );


$pdf->setXY(163,94);
$pdf->MultiCell( 90, 0.6 , iconv( 'UTF-8','cp874' , "ราคาต่อหน่วย"),0 ,'L' );

$pdf->setXY(185,94);
$pdf->MultiCell(90,1.0, iconv( 'UTF-8','cp874' , "ยอดรวม"),0 ,'L' );


$strSQL1 = "SELECT * FROM so__submain WHERE ref_idd = '".$ref_id."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

if ($Num_Rows1 > 7){

	$pdf->setXY(76,120);
$pdf->MultiCell(90,0, iconv( 'UTF-8','cp874' , "*รายละเอียดตามเอกสารแนบท้าย"),0 ,'L' );


}else{

$i=1;
while($objResult1 = mysqli_fetch_array($objQuery1))
{

$sum_amount1  =$objResult1["sum_amount"];
$sum_amount= number_format( $sum_amount1,2)."";

$price_per_unit_1  =$objResult1["price_per_unit"];
$price_per_unit= number_format( $price_per_unit_1,2)."";

$product_code  =$objResult1["product_code"];
$product_name  =$objResult1["product_name"];
$sale_count  =$objResult1["sale_count"];
$unit_name  =$objResult1["unit_name"];
$sale_remark = $objResult1["sale_remark"];
$product = "$product_name:$sale_remark";


$pdf->setX(183);
$pdf->MultiCell( 90,5.5, iconv( 'UTF-8','cp874' , ""),0 ,'L' );


$pdf->setX(13);
$pdf->MultiCell(90,0, iconv( 'UTF-8','cp874' , "$i"),0 ,'L' );


$pdf->setX(26);
$pdf->MultiCell(90,0, iconv( 'UTF-8','cp874' , "$product_code"),0 ,'L' );

//$pdf->Code128(26,0,$product_code,25,8);



$pdf->setX(56);
$pdf->MultiCell(90,0, iconv( 'UTF-8','cp874' , "$product"),0 ,'L' );

$pdf->setX(146);
$pdf->MultiCell(18,0, iconv( 'UTF-8','cp874' , "$sale_count $unit_name"),0 ,'R' );


$pdf->setX(164);
$pdf->MultiCell(19,0, iconv( 'UTF-8','cp874' , "$price_per_unit"),0 ,'R' );

$pdf->setX(183);
$pdf->MultiCell( 19,0, iconv( 'UTF-8','cp874' , "$sum_amount"),0 ,'R' );



$i++;


}

$pdf->setX(183);
$pdf->MultiCell( 90,5.5, iconv( 'UTF-8','cp874' , ""),0 ,'L' );

$pdf->setX(168);
$pdf->MultiCell(90,0, iconv( 'UTF-8','cp874' , "total :"),0 ,'L' );

$pdf->setX(183);
$pdf->MultiCell(19,0, iconv( 'UTF-8','cp874' , "$summary"),0 ,'R' );


}

if ($bq_ckk =='1'){
	
$pdf->Image("img/cor.jpeg",13,144,8,5);

$pdf->setXY(20,146.5);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "BQ เลขที่" ),0,'L' );


}else{

$pdf->setXY(15,145);
$pdf->MultiCell(3,3, iconv( 'UTF-8','cp874' , "" ),1,'L' );
$pdf->setXY(20,146.5);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "BQ เลขที่" ),0,'L' );

}
$pdf->setXY(35,146.5);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "$bq" ),0,'L' );


$pdf->setXY(35,149);
$pdf->Cell(30,0,'','T',0,'c',0);


if ($ot_ckk =='1'){
	
$pdf->Image("img/cor.jpeg",70,144,8,5);

$pdf->setXY(77,146.5);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "OT เลขที่" ),0,'L' );


}else{

$pdf->setXY(72,145);
$pdf->MultiCell(3,3, iconv( 'UTF-8','cp874' , "" ),1,'L' );
$pdf->setXY(75,146.5);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "OT เลขที่" ),0,'L' );

}

$pdf->setXY(93,146.5);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "$ot" ),0,'L' );


$pdf->setXY(93,149);
$pdf->Cell(30,0,'','T',0,'c',0);

$pdf->setXY(155,145);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "ส่วนลดพิเศษ" ),0,'L' );

$pdf->setXY(155,152);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "ราคาสุทธิ" ),0,'L' );






if ($full_bill=='1'){

$pdf->Image("img/cor.jpeg",13,152,8,5);

$pdf->setXY(20,154.5);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "ต้องการใบกำกับภาษีเต็มรูปแบบ" ),0,'L' );

}else{

$pdf->setXY(15,153.5);
$pdf->MultiCell(3,3, iconv( 'UTF-8','cp874' , "" ),1,'L' );
$pdf->setXY(20,154.5);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "ต้องการใบกำกับภาษีเต็มรูปแบบ" ),0,'L' );

}


$pdf->setXY(10,162);
$pdf->Cell(96,55, "",1,1,"c" );

$pdf->setXY(106,162);
$pdf->Cell(96,55, "",1,1,"c" );

$pdf->setXY(10,219);
$pdf->Cell(96,35, "",1,1,"c" );

$pdf->setXY(106,219);
$pdf->Cell(96,35, "",1,1,"c" );


$pdf->setXY(15,165);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "Sales Comment" ),0,'L' );

$pdf->setXY(15,168);
$pdf->MultiCell(85,5.5, iconv( 'UTF-8','cp874' , "$sale_remarkk" ),0,'L' );

$pdf->setXY(15,173);
$pdf->Cell(85,0,'','T',0,'c',0);

$pdf->setXY(15,179);
$pdf->Cell(85,0,'','T',0,'c',0);

$pdf->setXY(15,184);
$pdf->Cell(85,0,'','T',0,'c',0);



if ($with_pr=='1'){

$pdf->Image("img/cor.jpeg",13,187,8,5);

$pdf->setXY(20,189.5);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "แนบใบเสนอราคา" ),0,'L' );



}else{
$pdf->setXY(16,188);
$pdf->MultiCell(3,3, iconv( 'UTF-8','cp874' , "" ),1,'L' );
$pdf->setXY(20,189);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "แนบใบเสนอราคา" ),0,'L' );


}


if ($clear_book_ckk =='1'){

$pdf->Image("img/cor.jpeg",13,193,8,5);

$pdf->setXY(20,195.5);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "clear ใบจองสินค้าเลขที่" ),0,'L' );


}else{
$pdf->setXY(16,194);
$pdf->MultiCell(3,3, iconv( 'UTF-8','cp874' , "" ),1,'L' );
$pdf->setXY(20,195);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "clear ใบจองสินค้าเลขที่" ),0,'L' );

}

$pdf->setXY(53,195);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "$clear_book_no" ),0,'L' );

$pdf->setXY(53,198);
$pdf->Cell(50,0,'','T',0,'c',0);


$pdf->setXY(13,201);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "ไม่ต้องส่งสินค้า" ),0,'L' );


if ($clear_brn_no_ckk =='1'){
$pdf->Image("img/cor.jpeg",13,205,8,5);

$pdf->setXY(20,207);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "clear ใบยืมสินค้าติดเล่ม BRN" ),0,'L' );

}else{

$pdf->setXY(16,206);
$pdf->MultiCell(3,3, iconv( 'UTF-8','cp874' , "" ),1,'L' );
$pdf->setXY(20,207);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "clear ใบยืมสินค้าติดเล่ม BRN" ),0,'L' );

}


$pdf->setXY(62,207);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "$clear_brn_no" ),0,'L' );

$pdf->setXY(62,210);
$pdf->Cell(40,0,'','T',0,'c',0);


if ($clear_brnp_no_ckk =='1'){
$pdf->Image("img/cor.jpeg",13,211,8,5);

$pdf->setXY(20,213);
$pdf->MultiCell(60, 0.6 , iconv( 'UTF-8','cp874' , "clear ใบยืมสินค้ากระดาษต่อเนื่อง BRNP" ),0,'L' );

}else{

$pdf->setXY(16,212);
$pdf->MultiCell(3,3, iconv( 'UTF-8','cp874' , "" ),1,'L' );
$pdf->setXY(20,213);
$pdf->MultiCell(60, 0.6 , iconv( 'UTF-8','cp874' , "clear ใบยืมสินค้ากระดาษต่อเนื่อง BRNP" ),0,'L' );

}

$pdf->setXY(75,213);
$pdf->MultiCell( 50, 0.6 , iconv( 'UTF-8','cp874' , "$clear_brnp_no" ),0,'L' );

$pdf->setXY(75,216);
$pdf->Cell(28,0,'','T',0,'c',0);


$type_type_detail   =  $objResult["type_type_detail"];

if ($type_type=='1'){

$pdf->Image("img/cor.jpeg",13,220,8,5);

$pdf->setXY(20,222.5);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "พิมพ์ตาม Computer" ),0,'L' );


}else{

$pdf->setXY(16,222);
$pdf->MultiCell(3,3, iconv( 'UTF-8','cp874' , "" ),1,'L' );
$pdf->setXY(20,223);
$pdf->MultiCell(60, 0.6 , iconv( 'UTF-8','cp874' , "พิมพ์ตาม Computer" ),0,'L' );

}

if ($type_type=='2'){
$pdf->Image("img/cor.jpeg",13,227,8,5);

$pdf->setXY(20,229);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "พิมพ์ตามใบสั่งซื้อ" ),0,'L' );


}else{


$pdf->setXY(16,228);
$pdf->MultiCell(3,3, iconv( 'UTF-8','cp874' , "" ),1,'L' );
$pdf->setXY(21,229);
$pdf->MultiCell(60, 0.6 , iconv( 'UTF-8','cp874' , "พิมพ์ตามใบสั่งซื้อ" ),0,'L' );

}

if ($type_type=='3'){
$pdf->Image("img/cor.jpeg",13,233,8,5);

$pdf->setXY(20,232);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "พิมพ์ตามที่เขียน" ),0,'L' );

}else{

$pdf->setXY(16,234);
$pdf->MultiCell(3,3, iconv( 'UTF-8','cp874' , "" ),1,'L' );
$pdf->setXY(20,235);
$pdf->MultiCell(60,0.6, iconv( 'UTF-8','cp874' , "พิมพ์ตามที่เขียน" ),0,'L' );

}

$pdf->setXY(15,238);
$pdf->MultiCell(85,5.5, iconv( 'UTF-8','cp874' , "$type_type_detail" ),0,'L' );


$pdf->setXY(15,243);
$pdf->Cell(85,0,'','T',0,'c',0);
$pdf->setXY(15,249);
$pdf->Cell(85,0,'','T',0,'c',0);




 $pdf->setXY(20,261);
$pdf->Cell(60,0,'','T',0,'c',0);

$pdf->setXY(23,258);
$pdf->MultiCell(65, 0.6 , iconv( 'UTF-8','cp874' , "$employee_name / $register_date" ),0,'L' );

$pdf->setXY(30,263);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "Sale Signature/Area/Date" ),0,'L' );


$pdf->setXY(10,276);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "อนุมัติวันที่ 29 สิงหาคม 2559" ),0,'L' );

$pdf->setXY(95,258);
$pdf->MultiCell(60, 0.6 , iconv( 'UTF-8','cp874' , "$doc_no" ),0,'L' );
$pdf->setXY(95,266);
$pdf->MultiCell(60, 0.6 , iconv( 'UTF-8','cp874' , "$register_date" ),0,'L' );



$pdf->setXY(91,261);
$pdf->MultiCell(60, 0.6 , iconv( 'UTF-8','cp874' , "$delivery_dtae" ),0,'L' );

$pdf->setXY(130,261);
$pdf->Cell(60,0,'','T',0,'c',0);

$pdf->setXY(130,258);
$pdf->MultiCell(60, 0.6 , iconv( 'UTF-8','cp874' , "$approve_name / $register_date" ),0,'L' );

$pdf->setXY(135,263);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "Authorized Signature/Area/Date" ),0,'L' );


$pdf->setXY(140,276);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "$date" ),0,'L' );

$pdf->setXY(176,276);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "FM-SA-02:Rev.9" ),0,'L' );


if ($delivery_company=='1'){

$pdf->Image("img/cor.jpeg",108,163,8,5);

$pdf->setXY(115,165);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "บริษัทจัดส่ง" ),0,'L' );


}else{

$pdf->setXY(110,164);
$pdf->MultiCell(3,3, iconv( 'UTF-8','cp874' , "" ),1,'L' );
$pdf->setXY(113,165);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "บริษัทจัดส่ง" ),0,'L' );

}

if ($deliver_engineer=='1'){

$pdf->Image("img/cor.jpeg",151,163,8,5);

$pdf->setXY(158,165);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "Engineer รับเอง" ),0,'L' );

}else{

$pdf->setXY(153,164);
$pdf->MultiCell(3,3, iconv( 'UTF-8','cp874' , "" ),1,'L' );
$pdf->setXY(158,165);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "Engineer รับเอง" ),0,'L' );

}

if ($delivery_sale=='1'){
$pdf->Image("img/cor.jpeg",108,169,8,5);

$pdf->setXY(115,171);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "Sale รับเอง" ),0,'L' );

}else{

$pdf->setXY(110,170);
$pdf->MultiCell(3,3, iconv( 'UTF-8','cp874' , "" ),1,'L' );
$pdf->setXY(115,171);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "Sale รับเอง" ),0,'L' );

}



if ($deliver_customer=='1'){

$pdf->Image("img/cor.jpeg",151,169,8,5);

$pdf->setXY(158,171);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "ลูกค้ารับเอง" ),0,'L' );

}else{

$pdf->setXY(153,170);
$pdf->MultiCell(3,3, iconv( 'UTF-8','cp874' , "" ),1,'L' );
$pdf->setXY(158,171);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "ลูกค้ารับเอง" ),0,'L' );

}


$pdf->setXY(108,176);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "วันที่" ),0,'L' );

$pdf->setXY(118,176);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "$delivery_date" ),0,'L' );

$pdf->setXY(118,179);
$pdf->Cell(33,0,'','T',0,'c',0);


$pdf->setXY(153,176);
$pdf->MultiCell(45, 0.6 , iconv( 'UTF-8','cp874' , "เวลา" ),0,'L' );


$pdf->setXY(163,176);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "$delivery_time" ),0,'L' );

$pdf->setXY(163,179);
$pdf->Cell(33,0,'','T',0,'c',0);



if ($big_car=='1'){
$pdf->Image("img/cor.jpeg",108,181,8,5);

$pdf->setXY(115,183);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "ต้องการรถใหญ่" ),0,'L' );


}else{

$pdf->setXY(108,182);
$pdf->MultiCell(3,3, iconv( 'UTF-8','cp874' , "" ),1,'L' );
$pdf->setXY(113,183);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "ต้องการรถใหญ่" ),0,'L' );

}

if ($maps=='1'){

$pdf->Image("img/cor.jpeg",108,187,8,5);

$pdf->setXY(115,189);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "มีแผนที่ประกอบ(ด้านหลัง)" ),0,'L' );

}else{
$pdf->setXY(108,188);
$pdf->MultiCell(3,3, iconv( 'UTF-8','cp874' , "" ),1,'L' );
$pdf->setXY(113,189);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "มีแผนที่ประกอบ(ด้านหลัง)" ),0,'L' );

}

if ($call_before=='1'){
$pdf->Image("img/cor.jpeg",108,193,8,5);

$pdf->setXY(115,195.5);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "โทรแจ้งลูกค้าก่อนไป" ),0,'L' );

}else{

$pdf->setXY(110.5,194);
$pdf->MultiCell(3,3, iconv( 'UTF-8','cp874' , "" ),1,'L' );
$pdf->setXY(115,195.5);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "โทรแจ้งลูกค้าก่อนไป" ),0,'L' );

}

if ($assign_date_time=='1'){
	
$pdf->Image("img/cor.jpeg",108,199,8,5);

$pdf->setXY(115,201);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "นัดวันและเวลาเรียบร้อยแล้ว" ),0,'L' );

}else{

$pdf->setXY(110.5,200);
$pdf->MultiCell(3,3, iconv( 'UTF-8','cp874' , "" ),1,'L' );
$pdf->setXY(115,201);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "นัดวันและเวลาเรียบร้อยแล้ว" ),0,'L' );

}



$pdf->setXY(108,222.5);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "ระยะเวลารับประกัน" ),0,'L' );

$pdf->setXY(139,222.5);
$pdf->MultiCell(55, 0.6 , iconv( 'UTF-8','cp874' , "$waranty" ),0,'L' );

$pdf->setXY(190,222.5);
$pdf->MultiCell(55, 0.6 , iconv( 'UTF-8','cp874' , "ปี" ),0,'L' );


$pdf->setXY(139,225);
$pdf->Cell(50,0,'','T',0,'c',0);

$pdf->setXY(108,228);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "จำนวนครั้งในการ CAL" ),0,'L' );

$pdf->setXY(140,228);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "$cal" ),0,'L' );

$pdf->setXY(190,228);
$pdf->MultiCell(55, 0.6 , iconv( 'UTF-8','cp874' , "ครั้ง/ปี" ),0,'L' );


$pdf->setXY(140,231);
$pdf->Cell(49,0,'','T',0,'c',0);

$pdf->setXY(108,234);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "จำนวนครั้งในการ PM" ),0,'L' );

$pdf->setXY(140,234);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "$pm" ),0,'L' );

$pdf->setXY(190,234);
$pdf->MultiCell(55, 0.6 , iconv( 'UTF-8','cp874' , "ครั้ง/ปี" ),0,'L' );


$pdf->setXY(140,237);
$pdf->Cell(49,0,'','T',0,'c',0);

$pdf->setXY(108,240);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "สถานที่ติดตั้งเครื่อง" ),0,'L' );

$pdf->setXY(140,238);
$pdf->MultiCell(49,5.5, iconv( 'UTF-8','cp874' , "$install_place" ),0,'L' );



$pdf->setXY(140,243);
$pdf->Cell(49,0,'','T',0,'c',0);

$pdf->setXY(140,249);
$pdf->Cell(49,0,'','T',0,'c',0);



/////////////////////////////////

if ($Num_Rows1 > 7){

$pdf->AddPage();



$pdf->SetFont('angsa','',14);

$pdf->Image("img/nb_logo.jpg",55,16,28,12);


$pdf->Code128(170,25,$doc_no,25,8);




$pdf->SetXY(170,35);

$pdf->MultiCell(20, 0.6 , iconv( 'UTF-8','cp874' , "$doc_no"),0 ,'L' );



$pdf->SetFont('angsana','B',18);



$pdf->setXY(160,8);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "$delivery_name"),0 ,'L' );



$pdf->SetFont('angsana','BU',20);

$pdf->setXY(98,20 );
$pdf->MultiCell(90, 0.6, iconv( 'UTF-8','cp874' , "ใบสั่งขาย"),0 ,'L' );
$pdf->setXY(90,25 );
$pdf->MultiCell(100,0.6, iconv( 'UTF-8','cp874' , "(SALE ORDER)"),0 ,'L' );
$pdf->SetFont('angsa','',10);

$pdf->setXY( 40,5  );
$pdf->MultiCell(40,5.0, iconv( 'UTF-8','cp874' , "$time_delivery $packing_remark"),0 ,'L' );

$pdf->SetFont('angsa','',14);

$pdf->setXY( 10,20);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "เลขที่อ้างอิง :"),0 ,'L' );

$pdf->setXY( 28,20);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "$ref_id"),0 ,'L' );

$pdf->setXY( 10,13);
$pdf->MultiCell(3,3, iconv( 'UTF-8','cp874' , "" ),1,'L' );
$pdf->setXY(13,14);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "ก" ),0,'L' );

$pdf->setXY(20,13);
$pdf->MultiCell(3,3, iconv( 'UTF-8','cp874' , "" ),1,'L' );
$pdf->setXY(23,14);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "C" ),0,'L' );


$pdf->setXY( 158,16);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "ฝากสินค้าเลขที่ "),0 ,'L' );

$pdf->setXY(180,16);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "$deposit_no"),0 ,'L' );



$pdf->setXY(180,19);
$pdf->Cell(20,0,'','T',0,'c',0);


$pdf->setXY(158,22);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "วันที่"),0 ,'L' );
$pdf->setXY(166,22);
$pdf->MultiCell(124,0.6 , iconv( 'UTF-8','cp874' , "$register_date"),0 ,'L' );

$pdf->setXY(185,22);
$pdf->MultiCell(124,0.6 , iconv( 'UTF-8','cp874' , "$register_time"),0 ,'L' );



$pdf->setXY(10,26);
$pdf->MultiCell(90,0.6, iconv( 'UTF-8','cp874' , "เลขที่ลงงาน"),0 ,'L' );
$pdf->setXY(28,26);
$pdf->MultiCell(90,0.6, iconv( 'UTF-8','cp874' , "$job_id"),0 ,'L' );


$pdf->setXY(28,29);
$pdf->Cell(20,0,'','T',0,'c',0);



$pdf->setXY( 10,36);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "ชื่อผู้แนะนำ/รพ./แผนก"),0 ,'L' );
$pdf->setXY(42,36);
$pdf->MultiCell(160, 0.6 , iconv( 'UTF-8','cp874' , "$prefor_name"),0 ,'L' );

$pdf->setXY(42,39);
$pdf->Cell(160,0,'','T',0,'c',0);


$pdf->setXY(10,42);
$pdf->MultiCell(90,0.6,iconv( 'UTF-8','cp874' , "ชื่อที่ต้องการออกบิล"),0 ,'L' );
$pdf->setXY(42,42);
$pdf->MultiCell(160,0.6,iconv( 'UTF-8','cp874' , "$billing_name"),0 ,'L' );

$pdf->setXY(42,45);
$pdf->Cell(160,0,'','T',0,'c',0);


$pdf->setXY( 10,48);
$pdf->MultiCell(90,0.6, iconv( 'UTF-8','cp874' , "ที่อยู่ที่ต้องการออกบิล"),0 ,'L' );
$pdf->setXY(42,45);
$pdf->MultiCell(160,6.0, iconv( 'UTF-8','cp874' , "$billing_address"),0 ,'L' );
$pdf->setXY(42,51);
$pdf->Cell(160,0,'','T',0,'c',0);



$pdf->setXY(42,57);
$pdf->Cell(160,0,'','T',0,'c',0);


$pdf->setXY(10,60);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "เบอร์โทร"),0 ,'L' );
$pdf->setXY(42,60);
$pdf->MultiCell(160, 0.6 , iconv( 'UTF-8','cp874' , "$billing_tel"),0 ,'L' );


$pdf->setXY(42,63);
$pdf->Cell(160,0,'','T',0,'c',0);





$pdf->setXY(10,66);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "สถานที่ส่งสินค้า"),0 ,'L' );
$pdf->setXY(42,66);
$pdf->MultiCell(160, 0.6 , iconv( 'UTF-8','cp874' , "$delivery_place"),0 ,'L' );
$pdf->setXY(42,69);
$pdf->Cell(160,0,'','T',0,'c',0);


$pdf->setXY(10,72);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "ชื่อผู้ติดต่อ/โทร"),0 ,'L' );
$pdf->setXY(37,72);
$pdf->MultiCell(75, 0.6 , iconv( 'UTF-8','cp874' , "$delivery_contact"),0 ,'L' );
$pdf->setXY(37,75);
$pdf->Cell(70,0,'','T',0,'c',0);

$pdf->setXY(110,72);
$pdf->MultiCell(90,0.6, iconv( 'UTF-8','cp874' , "เบอร์โทร"),0 ,'L' );

$pdf->setXY(130,72);
$pdf->MultiCell(75, 0.6 , iconv( 'UTF-8','cp874' , "$tel"),0 ,'L' );

$pdf->setXY(130,75);
$pdf->Cell(72,0,'','T',0,'c',0);



$pdf->setXY( 10,78);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "ใบสั่งซื้อเลขที่"),0 ,'L' );
$pdf->setXY(42,78);
$pdf->MultiCell(40, 0.6 , iconv( 'UTF-8','cp874' , "$po_no"),0 ,'L' );
$pdf->setXY(42,81);
$pdf->Cell(55,0,'','T',0,'c',0);

$pdf->setXY(110,78);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "กำหนดส่งตามสัญญา"),0 ,'L' );

$pdf->setXY(140,78);
$pdf->MultiCell(40, 0.6 , iconv( 'UTF-8','cp874' , "$delivery_contract"),0 ,'L' );

$pdf->setXY(140,81);
$pdf->Cell(62,0,'','T',0,'c',0);

$pdf->setXY( 10,85);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "ชำระโดย"),0 ,'L' );

if ($payment_name==''){

$pdf->setXY(25,84);
$pdf->MultiCell(3,3, iconv( 'UTF-8','cp874' , "" ),1,'L' );
}else{

	$pdf->Image("img/cor.jpeg",24.5,82,8,5);

}

$pdf->setXY(30,85);
$pdf->MultiCell(90,0.6 , iconv( 'UTF-8','cp874' , "$payment_name"),0 ,'L' );


$pdf->setXY(110,84);
$pdf->MultiCell(3,3, iconv( 'UTF-8','cp874' , "" ),1,'L' );


$pdf->setXY(115,85);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "อื่นๆ"),0 ,'L' );






$pdf->Ln(5);


$pdf->Cell(8,8,iconv('UTF-8','cp874','ลำดับ'),1,0,"C");

$pdf->Cell(30,8,iconv('UTF-8','cp874','รหัสสินค้า'),1,0,"C");

$pdf->Cell(95,8,iconv('UTF-8','cp874','รายละเอียด'),1,0,"C");

$pdf->Cell(17,8,iconv('UTF-8','cp874','จำนวน'),1,0,"C");

$pdf->Cell(21,8,iconv('UTF-8','cp874','ราคาต่อหน่วย'),1,0,"C");

$pdf->Cell(22,8,iconv('UTF-8','cp874','ยอดรวม'),1,0,"C");

$pdf->Ln();


$strSQL1 = "SELECT * FROM so__submain WHERE ref_idd = '".$ref_id."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

$i=1;
while($objResult1 = mysqli_fetch_array($objQuery1))
{

$sum_amount1  =$objResult1["sum_amount"];
$sum_amount= number_format( $sum_amount1,2)."";

$price_per_unit_1  =$objResult1["price_per_unit"];
$price_per_unit= number_format( $price_per_unit_1,2)."";

$product_code  =$objResult1["product_code"];
$product_name  =$objResult1["product_name"];
$sale_count  =$objResult1["sale_count"];
$unit_name  =$objResult1["unit_name"];
$sale_remark = $objResult1["sale_remark"];
$product = "$product_name:$sale_remark";



$pdf->Cell(8,8,iconv('UTF-8','cp874', "$i"),1,0,"C");

$pdf->Cell(30,8,iconv('UTF-8','cp874',"$product_code"),1,0,"L");



$pdf->Cell(95,8,iconv('UTF-8','cp874',"$product"),1,0,"L");

$pdf->Cell(17,8,iconv('UTF-8','cp874',"$sale_count $unit_name"),1,0,"R");

$pdf->Cell(21,8,iconv('UTF-8','cp874',"$price_per_unit"),1,0,"R");

$pdf->Cell(22,8,iconv('UTF-8','cp874',"$sum_amount"),1,0,"R");
$pdf->Ln();




$i++;


}



$pdf->Cell(171,8,iconv('UTF-8','cp874',"total :"),1,0,"C");

$pdf->Cell(22,8,iconv('UTF-8','cp874',"$summary"),1,0,"R");

$pdf->Ln();




 $pdf->setXY(20,261);
$pdf->Cell(60,0,'','T',0,'c',0);

$pdf->setXY(23,258);
$pdf->MultiCell(65, 0.6 , iconv( 'UTF-8','cp874' , "$employee_name / $register_date" ),0,'L' );

$pdf->setXY(30,263);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "Sale Signature/Area/Date" ),0,'L' );


$pdf->setXY(10,276);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "อนุมัติวันที่ 29 สิงหาคม 2559" ),0,'L' );

$pdf->setXY(95,258);
$pdf->MultiCell(60, 0.6 , iconv( 'UTF-8','cp874' , "$doc_no" ),0,'L' );
$pdf->setXY(95,266);
$pdf->MultiCell(60, 0.6 , iconv( 'UTF-8','cp874' , "$register_date" ),0,'L' );



$pdf->setXY(91,261);
$pdf->MultiCell(60, 0.6 , iconv( 'UTF-8','cp874' , "$delivery_dtae" ),0,'L' );

$pdf->setXY(130,261);
$pdf->Cell(60,0,'','T',0,'c',0);

$pdf->setXY(130,258);
$pdf->MultiCell(60, 0.6 , iconv( 'UTF-8','cp874' , "$approve_name / $register_date" ),0,'L' );

$pdf->setXY(135,263);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "Authorized Signature/Area/Date" ),0,'L' );


$pdf->setXY(140,276);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "$date" ),0,'L' );

$pdf->setXY(176,276);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "FM-SA-02:Rev.9" ),0,'L' );

}

$pdf->Output();
?>

