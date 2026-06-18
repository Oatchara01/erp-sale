<?php

define('FPDF_FONTPATH','font/');

require('ean13.php');



$ref_id=$_GET["ref_id"];



include"dbconnect.php";

$strSQL = "SELECT * from hos__so where ref_id='$ref_id'";

$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$arr = mysqli_fetch_array($objQuery);

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

$id = $arr["id"];
$main_id = $arr["main_id"];
$company = $arr["company"];
$suggest = $arr["suggest"];
$date = $arr["date"];
$ref_no = $arr["ref_no"];
$job_no = $arr["job_no"];
$dep_no = $arr["dep_no"];
$sale_channel = $arr["sale_channel"];
$bill_name = $arr["bill_name"];
$bill_address = $arr["bill_address"];
$bill_tel = $arr["bill_tel"];
$payment = $arr["payment"];
$delivery_place = $arr["delivery_place"];
$delivery_contact = $arr["delivery_contact"];
$po_no = $arr["po_no"];
$delivery_contract = $arr["delivery_contract"];
$free_items = $arr["free_items"];
$book_clear = $arr["book_clear"];
$book_no = $arr["book_no"];
$brn_clear = $arr["brn_clear"];
$brn_no = $arr["brn_no"];
$brnp_clear = $arr["brnp_clear"];
$brnp_no = $arr["brnp_no"];
$installed = $arr["installed"];
$bq = $arr["bq"];
$ot = $arr["ot"];
$with_pr = $arr["with_pr"];
$full_bill = $arr["full_bill"];
$slip1 = $arr["slip1"];
$slip2 = $arr["slip2"];
$slip3 = $arr["slip3"];
$slip4 = $arr["slip4"];
$slip5 = $arr["slip5"];
$type_type = $arr["type_type"];
$type_detail = $arr["type_detail"];
$delivery_choice = $arr["delivery_choice"];
$delivery_date = $arr["delivery_date"];
$delivery_time = $arr["delivery_time"];
$big_car = $arr["big_car"];
$map = $arr["map"];
$mapfile = $arr["mapfile"];
$call_before = $arr["call_before"];
$assign = $arr["assign"];
$sale_comment = $arr["sale_comment"];
$sale = $arr["sale"];
$sale_date = $arr["sale_date"];
$approve = $arr["approve"];
$approve_date = $arr["approve_date"];
$admin = $arr["admin"];
$admin_date = $arr["admin_date"];
$status = $arr["status"];

$pdf=new FPDF( 'P' , 'cm' , 'A4' );
 
$pdf->AddPage();

/////////////////////////

$pdf=new PDF_Code128();
$pdf->AddPage();
$pdf->AddFont('angsa','','angsa.php');
$pdf->AddFont('angsana','B','angsab.php');
$pdf->AddFont('times','','times.php');


$pdf->SetFont('angsa','',14);

$pdf->Code128(170,25,$doc_no,25,8);

$pdf->SetXY(170,35);

$pdf->MultiCell(20, 0.6 , iconv( 'UTF-8','cp874' , "$ref_no"),0 ,'L' );

$pdf->SetFont('angsana','B',18);

$pdf->setXY(160,8);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , ""),0 ,'L' );

$pdf->SetFont('angsana','BU',20);

$pdf->setXY(98,20 );
$pdf->MultiCell(90, 0.6, iconv( 'UTF-8','cp874' , "ใบสั่งขาย"),0 ,'L' );
$pdf->setXY(90,25 );
$pdf->MultiCell(100,0.6, iconv( 'UTF-8','cp874' , "(SALE ORDER)"),0 ,'L' );
$pdf->SetFont('angsa','',10);

$pdf->setXY( 40,5  );
$pdf->MultiCell(40,5.0, iconv( 'UTF-8','cp874' , ""),0 ,'L' );

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
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "$dep_no"),0 ,'L' );



$pdf->setXY(180,19);
$pdf->Cell(20,0,'','T',0,'c',0);


$pdf->setXY(158,22);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "วันที่"),0 ,'L' );
$pdf->setXY(166,22);
$pdf->MultiCell(124,0.6 , iconv( 'UTF-8','cp874' , "$date"),0 ,'L' );

$pdf->setXY(185,22);
$pdf->MultiCell(124,0.6 , iconv( 'UTF-8','cp874' , ""),0 ,'L' );



$pdf->setXY(10,26);
$pdf->MultiCell(90,0.6, iconv( 'UTF-8','cp874' , "เลขที่ลงงาน"),0 ,'L' );
$pdf->setXY(28,26);
$pdf->MultiCell(90,0.6, iconv( 'UTF-8','cp874' , "$job_id"),0 ,'L' );


$pdf->setXY(28,29);
$pdf->Cell(20,0,'','T',0,'c',0);



$pdf->setXY( 10,36);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "ชื่อผู้แนะนำ/รพ./แผนก"),0 ,'L' );
$pdf->setXY(42,36);
$pdf->MultiCell(160, 0.6 , iconv( 'UTF-8','cp874' , "$suggest"),0 ,'L' );

$pdf->setXY(42,39);
$pdf->Cell(160,0,'','T',0,'c',0);


$pdf->setXY(10,42);
$pdf->MultiCell(90,0.6,iconv( 'UTF-8','cp874' , "ชื่อที่ต้องการออกบิล"),0 ,'L' );
$pdf->setXY(42,42);
$pdf->MultiCell(160,0.6,iconv( 'UTF-8','cp874' , "$bill_name"),0 ,'L' );

$pdf->setXY(42,45);
$pdf->Cell(160,0,'','T',0,'c',0);


$pdf->setXY( 10,48);
$pdf->MultiCell(90,0.6, iconv( 'UTF-8','cp874' , "ที่อยู่ที่ต้องการออกบิล"),0 ,'L' );
$pdf->setXY(42,45);
$pdf->MultiCell(160,6.0, iconv( 'UTF-8','cp874' , "$bill_address"),0 ,'L' );
$pdf->setXY(42,51);
$pdf->Cell(160,0,'','T',0,'c',0);



$pdf->setXY(42,57);
$pdf->Cell(160,0,'','T',0,'c',0);


$pdf->setXY(10,60);
$pdf->MultiCell(90, 0.6 , iconv( 'UTF-8','cp874' , "เบอร์โทร"),0 ,'L' );
$pdf->setXY(42,60);
$pdf->MultiCell(160, 0.6 , iconv( 'UTF-8','cp874' , "$bill_tel"),0 ,'L' );

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
$pdf->MultiCell(75, 0.6 , iconv( 'UTF-8','cp874' , ""),0 ,'L' );

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

if ($payment==''){

$pdf->setXY(25,84);
$pdf->MultiCell(3,3, iconv( 'UTF-8','cp874' , "" ),1,'L' );
}else{

	$pdf->Image("img/cor.jpeg",24.5,82,8,5);

}

$pdf->setXY(30,85);
$pdf->MultiCell(90,0.6 , iconv( 'UTF-8','cp874' , "$payment"),0 ,'L' );


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


$pd = "select * from (hos__subso LEFT JOIN tb_product ON hos__subso.product_ID=tb_product.product_id) where ref_idd ='$ref_id'";
$qpd = mysqli_query($conn,$pd) or die(mysqli_error());


$sum = "select sum(amount) as sum_amount from hos__subso where ref_id='$ref_id'";
$qsum = mysqli_query($conn,$sum);
$fsum = mysqli_fetch_array($qsum)
$i=1;
while($frr = mysqli_fetch_array($qpd))
{

$sum_amount1  =$fsum["sum_amount"];
$sum_amount= number_format( $sum_amount1,2)."";

$price1  =$frr["price"];
$price= number_format( $price1,2)."";

$access_code  =$frr["access_code"];
$access_name  =$frr["access_name"];
$count  =$frr["count"];
$unit  =$frr["unit"];
$sale_remark = $frr["sale_remark"];
$product = "$access_name:$sale_remark";



$pdf->setX(183);
$pdf->MultiCell( 90,5.5, iconv( 'UTF-8','cp874' , ""),0 ,'L' );


$pdf->setX(13);
$pdf->MultiCell(90,0, iconv( 'UTF-8','cp874' , "$i"),0 ,'L' );


$pdf->setX(26);
$pdf->MultiCell(90,0, iconv( 'UTF-8','cp874' , "$access_code"),0 ,'L' );

$pdf->setX(56);
$pdf->MultiCell(90,0, iconv( 'UTF-8','cp874' , "$product"),0 ,'L' );

$pdf->setX(146);
$pdf->MultiCell(18,0, iconv( 'UTF-8','cp874' , "$count $unit"),0 ,'R' );


$pdf->setX(164);
$pdf->MultiCell(19,0, iconv( 'UTF-8','cp874' , "$price"),0 ,'R' );

$pdf->setX(183);
$pdf->MultiCell( 19,0, iconv( 'UTF-8','cp874' , "$sum_amount"),0 ,'R' );



$i++;


}

$pdf->setX(183);
$pdf->MultiCell( 90,5.5, iconv( 'UTF-8','cp874' , ""),0 ,'L' );

$pdf->setX(168);
$pdf->MultiCell(90,0, iconv( 'UTF-8','cp874' , "total :"),0 ,'L' );

$pdf->setX(183);
$pdf->MultiCell(19,0, iconv( 'UTF-8','cp874' , "$sum_amount"),0 ,'R' );




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


/*$pdf->setXY(183,143);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "$discount" ),0,'L' );*/




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
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "รายการของแถม" ),0,'L' );

$pdf->setXY(15,168);
$pdf->MultiCell(85,5.5, iconv( 'UTF-8','cp874' , "" ),0,'L' );

$pdf->setXY(14,168);
$pdf->MultiCell(85,5.5, iconv( 'UTF-8','cp874' , "1" ),0,'L' );

$pdf->setXY(14,174);
$pdf->MultiCell(85,5.5, iconv( 'UTF-8','cp874' , "2" ),0,'L' );

$pdf->setXY(14,179);
$pdf->MultiCell(85,5.5, iconv( 'UTF-8','cp874' , "3" ),0,'L' );

 
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


if ($book_clear =='1'){

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
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "$book_no" ),0,'L' );

$pdf->setXY(53,198);
$pdf->Cell(50,0,'','T',0,'c',0);


$pdf->setXY(13,201);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "ไม่ต้องส่งสินค้า" ),0,'L' );


if ($brn_clear =='1'){
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
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "$brn_no" ),0,'L' );

$pdf->setXY(62,210);
$pdf->Cell(40,0,'','T',0,'c',0);


if ($brnp_clear =='1'){
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
$pdf->MultiCell( 50, 0.6 , iconv( 'UTF-8','cp874' , "$brnp_no" ),0,'L' );

$pdf->setXY(75,216);
$pdf->Cell(28,0,'','T',0,'c',0);

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
$pdf->MultiCell(85,5.5, iconv( 'UTF-8','cp874' , "$type_detail" ),0,'L' );


$pdf->setXY(15,243);
$pdf->Cell(85,0,'','T',0,'c',0);
$pdf->setXY(15,249);
$pdf->Cell(85,0,'','T',0,'c',0);




 $pdf->setXY(20,261);
$pdf->Cell(60,0,'','T',0,'c',0);

$pdf->setXY(23,258);
$pdf->MultiCell(65, 0.6 , iconv( 'UTF-8','cp874' , "" ),0,'L' );

$pdf->setXY(30,263);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "Sale Signature/Area/Date" ),0,'L' );


$pdf->setXY(10,276);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "อนุมัติวันที่ 29 สิงหาคม 2559" ),0,'L' );

$pdf->setXY(95,258);
$pdf->MultiCell(60, 0.6 , iconv( 'UTF-8','cp874' , "$doc_no" ),0,'L' );
$pdf->setXY(95,266);
$pdf->MultiCell(60, 0.6 , iconv( 'UTF-8','cp874' , "$date" ),0,'L' );



$pdf->setXY(91,261);
$pdf->MultiCell(60, 0.6 , iconv( 'UTF-8','cp874' , "$delivery_dtae" ),0,'L' );

$pdf->setXY(130,261);
$pdf->Cell(60,0,'','T',0,'c',0);

$pdf->setXY(130,258);
$pdf->MultiCell(60, 0.6 , iconv( 'UTF-8','cp874' , "$approve / $approve_date" ),0,'L' );

$pdf->setXY(135,263);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "Authorized Signature/Area/Date" ),0,'L' );


$pdf->setXY(140,276);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "$date" ),0,'L' );

$pdf->setXY(176,276);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "FM-SA-02:Rev.9" ),0,'L' );


if ($delivery_type ='4'){

$pdf->Image("img/cor.jpeg",108,163,8,5);

$pdf->setXY(115,165);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "บริษัทจัดส่ง" ),0,'L' );


}else{

$pdf->setXY(110,164);
$pdf->MultiCell(3,3, iconv( 'UTF-8','cp874' , "" ),1,'L' );
$pdf->setXY(113,165);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "บริษัทจัดส่ง" ),0,'L' );

}

if ($delivery_type=='2'){

$pdf->Image("img/cor.jpeg",151,163,8,5);

$pdf->setXY(158,165);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "Engineer รับเอง" ),0,'L' );

}else{

$pdf->setXY(153,164);
$pdf->MultiCell(3,3, iconv( 'UTF-8','cp874' , "" ),1,'L' );
$pdf->setXY(158,165);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "Engineer รับเอง" ),0,'L' );

}

if ($delivery_type=='1'){
$pdf->Image("img/cor.jpeg",108,169,8,5);

$pdf->setXY(115,171);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "Sale รับเอง" ),0,'L' );

}else{

$pdf->setXY(110,170);
$pdf->MultiCell(3,3, iconv( 'UTF-8','cp874' , "" ),1,'L' );
$pdf->setXY(115,171);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "Sale รับเอง" ),0,'L' );

}



if ($delivery_type=='3'){

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

$pdf->setXY(115,205);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "Sale Comment" ),0,'L' );

$pdf->setXY(115,208);
$pdf->MultiCell(85,4.0, iconv( 'UTF-8','cp874' , "$sale_remark" ),0,'L' );


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
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "" ),0,'L' );

$pdf->setXY(190,228);
$pdf->MultiCell(55, 0.6 , iconv( 'UTF-8','cp874' , "ครั้ง/ปี" ),0,'L' );


$pdf->setXY(140,231);
$pdf->Cell(49,0,'','T',0,'c',0);

$pdf->setXY(108,234);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "จำนวนครั้งในการ PM" ),0,'L' );

$pdf->setXY(140,234);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "" ),0,'L' );

$pdf->setXY(190,234);
$pdf->MultiCell(55, 0.6 , iconv( 'UTF-8','cp874' , "ครั้ง/ปี" ),0,'L' );


$pdf->setXY(140,237);
$pdf->Cell(49,0,'','T',0,'c',0);

$pdf->setXY(108,240);
$pdf->MultiCell(50, 0.6 , iconv( 'UTF-8','cp874' , "สถานที่ติดตั้งเครื่อง" ),0,'L' );

$pdf->setXY(140,238);
$pdf->MultiCell(49,5.5, iconv( 'UTF-8','cp874' , "$installed" ),0,'L' );



$pdf->setXY(140,243);
$pdf->Cell(49,0,'','T',0,'c',0);

$pdf->setXY(140,249);
$pdf->Cell(49,0,'','T',0,'c',0);


$pdf->Output();
?>

