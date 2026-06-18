
<?php
//header("Content-Type: image/png");


//header("Content-Disposition: attachment; filename=สรุปงานแผนกบริการลูกค้า.png");


define('FPDF_FONTPATH','font/');
 
require('fpdf.php');

$running=$_GET["job_no"];

$conn = mysqli_connect('localhost:3306','allwell_itadmin','Pass@2020','allwell_cs');
mysqli_set_charset($conn, "utf8");

$sol = mysqli_connect('localhost:3306','allwell_itadmin','Pass@2020','allwell_sol');
mysqli_set_charset($sol, "utf8");

$strSQL = "SELECT * FROM tb_register_data WHERE running = '".$running."' ";
$objQuery = mysqli_query($conn,$strSQL)or die ("Error Query [".$strSQL."]");;
$objResult = mysqli_fetch_array($objQuery);

$strSQL1 = "SELECT * FROM tb_transaction WHERE running = '".$running."' ";
$objQuery1 = mysqli_query($conn,$strSQL1)or die ("Error Query [".$strSQL1."]");;
$objResult1 = mysqli_fetch_array($objQuery1);

$strSQL2 = "SELECT bill_id,bill_name FROM hos__so WHERE ref_id = '".$objResult["ref_id"]."' ";
$objQuery2 = mysqli_query($sol,$strSQL2)or die ("Error Query [".$strSQL1."]");;
$objResult2 = mysqli_fetch_array($objQuery2);

$strSQL3 = "SELECT * FROM tb_desbill WHERE bill_id = '".$objResult2["bill_id"]."' ";
$objQuery3 = mysqli_query($conn,$strSQL3)or die ("Error Query [".$strSQL1."]");;
$objResult3 = mysqli_fetch_array($objQuery3);


//echo $strSQL;

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



$start_date=$objResult["start_date"];

$date = explode('-' , $objResult["start_date"] );
$newDate = $date[2].'-'.$date[1].'-'.$date[0];

$bill_name = $objResult2["bill_name"];
//$newDate = date("d-m-Y", strtotime($start_date));
$between_date=$objResult["between_date"];
$status =$objResult["status"];
$start_time =$objResult["start_time"];
$end_time=$objResult["end_time"];
$department=$objResult["department"];
$customer_name=$objResult["customer_name"];
$employee_name=$objResult["employee_name"];
$type_company=$objResult["type_company"];
$type_customer =$objResult["type_customer"];
$ref_id = $objResult["ref_id"];
$customer_tel =$objResult["customer_tel"];
$province_name=$objResult["province_name"];
$employee_tel =$objResult["employee_tel"];
$add_by =$objResult["add_by"];
$want_bus =$objResult["want_bus"];
$address_send =$objResult["address_send"];
$customer_contact =$objResult["customer_contact"];
$description =$objResult["description"];
$have_map =$objResult["have_map"];
$add_date =$objResult["add_date"];
$newadd_date = date("d-m-Y H:i:s", strtotime($add_date));
$upload_name  =$objResult["upload_name"];

$product_sn =$objResult["product_sn"];
$product_name=$objResult["product_name"];
$price  =$objResult["price"];
$unit_credit  =$objResult["unit_credit"];
$fix_date=$objResult["fix_date"];
$no_price =$objResult["no_price"];
$call_customer=$objResult["call_customer"];
$credit =$objResult["credit"];
$call_employee =$objResult["call_employee"];
$cash =$objResult["cash"];
$unit_bill  =$objResult["unit_bill"];
$unit_check  =$objResult["unit_check"];
$unit_tran  =$objResult["unit_tran"];
$tran  =$objResult["tran"];

$check_peper  =$objResult["check_peper"];
$bill =$objResult["bill"];
$amphur_name =$objResult["amphur_name"];
$province_name =$objResult["province_name"];
$address_name  =$objResult["address_name"];


$status_comment =$objResult["status_comment"];
$type_word  =$objResult["type_word"];
$employee_send =$objResult["employee_send"];
$time_send =$objResult["time_send"];
$summary_cs   =$objResult["summary_cs"];
$description_cs=$objResult["description_cs"];
$run_long  =$objResult["run_long"];
$summary_sup =$objResult["summary_sup"];
$description_sup  =$objResult["description_sup"];
$dep =$objResult["dep"];
$dept  =$objResult["dept"];

$time="$start_time - $end_time";
$date = date('d-m-Y H:i:s');


$runway  =$objResult1["runway"];
$road  =$objResult1["road"];
$soy  =$objResult1["soy"];
$soy_long  =$objResult1["soy_long"];
$soy_big  =$objResult1["soy_big"];
$car_load  =$objResult1["car_load"];
$car_park  =$objResult1["car_park"];
$car_road  =$objResult1["car_road"];
$no_car_road  =$objResult1["no_car_road"];
$car_home  =$objResult1["car_home"];
$door_long  =$objResult1["door_long"];
$slope  =$objResult1["slope"];
$bundai  =$objResult1["bundai"];
$unit_bundai  =$objResult1["unit_bundai"];
$door_big  =$objResult1["door_big"];
$door_longer  =$objResult1["door_longer"];
$type_door  =$objResult1["type_door"];
$home_type  =$objResult1["home_type"];
$install  =$objResult1["install"];
$bundai_install  =$objResult1["bundai_install"];
$bundai_big  =$objResult1["bundai_big"];
$lip  =$objResult1["lip"];
$lip_big  =$objResult1["lip_big"];
$lip_long  =$objResult1["lip_long"];
$lip_weight  =$objResult1["lip_weight"];
$want_employee  =$objResult1["want_employee"];
$employee_unit  =$objResult1["employee_unit"];
$ferniger_address  =$objResult1["ferniger_address"];
$ferniger_name  =$objResult1["ferniger_name"];
$want_ex  =$objResult1["want_ex"];
$want_credit  =$objResult1["want_credit"];
$want_prem  =$objResult1["want_prem"];

$room_bigger  =$objResult1["room_bigger"];
$room_longer  =$objResult1["room_longer"];
$bundai_hug  =$objResult1["bundai_hug"];
$bank  =$objResult1["bank"];

$description_tran=$objResult1["description"];
$type_bundai =$objResult1["type_bundai"];
$head_bad=$objResult1["head_bad"];
$up=$objResult1["up"];
$no_up=$objResult1["no_up"];
$height_ltd=$objResult1["height_ltd"];


$pdf=new FPDF( 'P' , 'cm' , 'A4' );
$pdf->AddFont('angsa','','angsa.php');
$pdf->AddFont('angsana','B','angsab.php');
 
$pdf->AddPage();
$pdf->SetFont('angsana','BU',20);



$pdf->setXY( 8.0, 1.0  );
$pdf->MultiCell( 9  , 0.6 , iconv( 'UTF-8','cp874' , "ใบแจ้งรายละเอียดการจัดส่งสินค้า"),0 ,'L' );
$pdf->setXY( 8.8, 1.5  );
$pdf->MultiCell( 5.5  , 0.6 , iconv( 'UTF-8','cp874' , "Delivery Information"),0 ,'L' );



$pdf->SetFont('angsana','B',16);

$pdf->setXY( 15, 2.5  );
$pdf->MultiCell( 5  , 0.6 , iconv( 'UTF-8','cp874' , "ID NO." ),0,'L' );


$pdf->SetFont('angsa','',16);

$pdf->setXY( 16.5, 3.1  );
$pdf->Cell(3.5,0,'','T',0,'C',0);

$pdf->setXY( 16.5, 2.5  );
$pdf->MultiCell( 5  , 0.6 , iconv( 'UTF-8','cp874' , "$running" ),0,'L' );




$pdf->SetFont('angsa','',16);


$pdf->SetFont('angsana','B',16);

$pdf->setXY( 1.6,2.8);
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "ชื่อที่ต้องการออกบิล  :" ),0,'L' );

$pdf->setXY( 1.6,3.5  );
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "ชื่อผู้ติดต่อ  :" ),0,'L' );

$pdf->setXY(8.0,3.5  );
$pdf->MultiCell(10.0,0.6 , iconv( 'UTF-8','cp874' , "ผู้รับสินค้า  :" ),0,'L' );


$pdf->SetFont('angsa','',15);
$pdf->setXY( 4.5, 4.1  );
$pdf->Cell(3.5,0,'','T',0,'c',0);
$pdf->setXY(10.0, 4.1  );
$pdf->Cell(4.0,0,'','T',0,'c',0);
$pdf->setXY( 5.1, 3.4);
$pdf->Cell(9.0,0,'','T',0,'c',0);

$pdf->setXY( 5.1,2.8);
$pdf->MultiCell(9.0, 0.6 , iconv( 'UTF-8//IGNORE','cp874//IGNORE' , "$bill_name" ),0,'L' );

$pdf->setXY( 4.5,3.5  );
$pdf->MultiCell(6.0, 0.6 , iconv( 'UTF-8//IGNORE','cp874//IGNORE' , "$customer_name" ),0,'L' );
$pdf->setXY(10.0,3.5  );
$pdf->MultiCell(6.0, 0.6 , iconv( 'UTF-8//IGNORE','cp874//IGNORE' , "$customer_contact" ),0,'L' );


$pdf->SetFont('angsana','B',16);
$pdf->setXY( 1.6, 4.2 );
$pdf->MultiCell(10, 0.5 , iconv( 'UTF-8','cp874' , "เบอร์โทร :" ),0,'L' );

$pdf->SetFont('angsa','',16);
$pdf->setXY( 4.5, 4.8  );
$pdf->Cell(9,0,'','T',0,'c',0);

$pdf->setXY( 4.5, 4.2 );
$pdf->MultiCell(11.0, 0.6 , iconv( 'UTF-8','cp874' , "$customer_tel" ),0,'L' );

$pdf->SetFont('angsana','B',14);
$pdf->setXY( 1.6, 4.7  );
$pdf->MultiCell(3, 0.45, iconv( 'UTF-8','cp874' , "สถานที่จัดส่ง /เขต/รพ./จังหวัด:" ),0,'L' );

$pdf->SetFont('angsa','',16);
$pdf->setXY( 4.5, 5.5);
$pdf->Cell(9,0,'','T',0,'c',0);
$pdf->setXY( 4.5,6.0);
$pdf->Cell(9,0,'','T',0,'c',0);


$pdf->setXY( 4.5, 4.9  );
$pdf->MultiCell(9, 0.6 , iconv( 'UTF-8//IGNORE','cp874//IGNORE' , "$province_name" ),0,'L' );
$pdf->SetFont('angsa','',14);
$pdf->setXY( 4.5,5.5);
$pdf->MultiCell(9, 0.45, iconv( 'UTF-8//IGNORE','cp874//IGNORE' , "$address_name" ),0,'L' );

$pdf->SetFont('angsana','B',16);
$pdf->setXY( 1.6,6.8);
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "แผนก/ที่อยู่ :" ),0,'L' );

$pdf->SetFont('angsa','',14);
$pdf->setXY( 4.5, 6.4);
$pdf->Cell(9,0,'','T',0,'c',0);



$pdf->setXY( 4.5,7.3);
$pdf->Cell(9,0,'','T',0,'c',0);
$pdf->setXY( 4.5,7.8);
$pdf->Cell(9,0,'','T',0,'c',0);
$pdf->setXY( 4.5,8.3);
$pdf->Cell(9,0,'','T',0,'c',0);
$pdf->setXY( 4.5,8.8);
$pdf->Cell(9,0,'','T',0,'c',0);
$pdf->setXY( 4.5,9.3);
$pdf->Cell(9,0,'','T',0,'c',0);




$pdf->setXY( 4.5,6.8);
$pdf->MultiCell(9, 0.5, iconv( 'UTF-8//IGNORE','cp874//IGNORE' , "$address_send" ),0,'L' );

/*$pdf->SetFont('angsana','B',16);
$pdf->setXY( 1.6,7.5);
$pdf->MultiCell(9, 0.6 , iconv( 'UTF-8','cp874' , "อำเภอ :" ),0,'L' );

$pdf->SetFont('angsa','',16);
$pdf->setXY(4.5,7.5);
$pdf->MultiCell(3.5, 0.65 , iconv( 'UTF-8','cp874' , "$amphur_name" ),0,'L' );
$pdf->setXY( 4.5, 8.1  );
$pdf->Cell(3.5,0,'','T',0,'c',0);
$pdf->setXY( 4.5, 8.7  );
$pdf->Cell(3.5,0,'','T',0,'c',0);


$pdf->SetFont('angsana','B',16);
$pdf->setXY(8.0, 7.5);
$pdf->MultiCell(5, 0.6 , iconv( 'UTF-8','cp874' , "จังหวัด :" ),0,'L' );
$pdf->SetFont('angsa','',16);

$pdf->setXY(9.5,8.1);
$pdf->Cell(4.0,0,'','T',0,'c',0);
$pdf->setXY(9.5,8.7);
$pdf->Cell(4.0,0,'','T',0,'c',0);
$pdf->setXY(9.5,7.5);
$pdf->MultiCell(6, 0.6 , iconv( 'UTF-8','cp874' , "$province_name" ),0,'L' );*/





$pdf->SetFont('angsana','B',16);
$pdf->setXY( 1.6,9.9);
$pdf->MultiCell(9, 0.6 , iconv( 'UTF-8','cp874' , "ข้อมูลเพิ่มเติม :" ),0,'L' );

$pdf->SetFont('angsa','',13);



/*$pdf->setXY( 4.5, 9.9);
$pdf->Cell(9,0,'','T',0,'c',0);*/
$pdf->setXY( 4.5, 10.4);
$pdf->Cell(9,0,'','T',0,'c',0);
$pdf->setXY( 4.5, 10.8);
$pdf->Cell(9,0,'','T',0,'c',0);
$pdf->setXY( 4.5, 11.2);
$pdf->Cell(9,0,'','T',0,'c',0);
$pdf->setXY( 4.5, 11.6);
$pdf->Cell(9,0,'','T',0,'c',0);
$pdf->setXY( 4.5, 12.1);
$pdf->Cell(9,0,'','T',0,'c',0);
$pdf->setXY( 4.5, 12.5);
$pdf->Cell(9,0,'','T',0,'c',0);
$pdf->setXY( 4.5, 12.9);
$pdf->Cell(9,0,'','T',0,'c',0);

$pdf->setXY(4.5,10.0);
$pdf->MultiCell(9, 0.42, iconv( 'UTF-8//IGNORE','cp874//IGNORE' , "$description" ),0,'L' );

$pdf->SetFont('angsana','B',16);
$pdf->setXY( 1.6, 13.1  );
$pdf->MultiCell(9, 0.6 , iconv( 'UTF-8','cp874' , "ชื่อพนักงาน :" ),0,'L' );
$pdf->SetFont('angsa','',16);

$pdf->setXY( 4.5, 13.6 );
$pdf->Cell(4.0,0,'','T',0,'c',0);
$pdf->setXY( 4.5, 13.1  );
$pdf->MultiCell(9, 0.6 , iconv( 'UTF-8//IGNORE','cp874//IGNORE' , "$employee_name" ),0,'L' );

$pdf->SetFont('angsana','B',16);
$pdf->setXY( 8.6, 13.1);
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "เบอร์โทร :" ),0,'L' );
$pdf->SetFont('angsa','',16);

$pdf->setXY( 10.5, 13.6);
$pdf->Cell(3.0,0,'','T',0,'c',0);
$pdf->setXY( 10.5, 13.1);
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8//IGNORE','cp874//IGNORE' , "$employee_tel" ),0,'L' );






$pdf->SetFont('angsana','B',16);
$pdf->setXY( 16.5, 4.1  );
$pdf->Cell(0,3.5,'','T',0,'C',0);

$pdf->setXY( 15, 3.5  );
$pdf->MultiCell( 5  , 0.6 , iconv( 'UTF-8','cp874' , "วันที่:" ),0,'L' );

$pdf->setXY( 16.5, 6.1  );
$pdf->Cell(0,3.5,'','T',0,'C',0);
$pdf->setXY( 15, 5.5  );
$pdf->MultiCell(5  , 0.6 , iconv( 'UTF-8','cp874' , "เวลา:" ),0,'L' );

$pdf->setXY( 15,4.5);
$pdf->MultiCell(5  , 0.6 , iconv( 'UTF-8','cp874' , "วันที่ประมาณ:" ),0,'L' );

$pdf->setXY( 16.5, 7.6);
$pdf->Cell(0,3.5,'','T',0,'C',0);
$pdf->setXY( 15,7.1);
$pdf->MultiCell( 5  , 0.6 , iconv( 'UTF-8','cp874' , "แผนก:" ),0,'L' );

$pdf->setXY( 16.5,6.9);
$pdf->Cell(0,3.5,'','T',0,'C',0);
$pdf->setXY( 15,6.3);
$pdf->MultiCell( 5  , 0.6 , iconv( 'UTF-8','cp874' , "สถานะ:" ),0,'L' );


$pdf->SetFont('angsa','',14);

$pdf->setXY( 16.5, 3.5  );

$pdf->MultiCell( 5  , 0.6 , iconv( 'UTF-8','cp874' , "$newDate" ),0,'L' );

$pdf->setXY( 16.5, 5.5  );
$pdf->MultiCell(5  , 0.6 , iconv( 'UTF-8','cp874' , "$time" ),0,'L' );

$pdf->setXY( 17.2,5.1);
$pdf->Cell(0,3.5,'','T',0,'C',0);
$pdf->setXY( 17.3,4.5);
$pdf->MultiCell( 3.55  , 0.6 , iconv( 'UTF-8','cp874' , "$between_date" ),0,'L' );

$pdf->setXY( 16.5,7.1);
$pdf->MultiCell( 5  , 0.6 , iconv( 'UTF-8','cp874' , "$department" ),0,'L' );
$pdf->setXY( 16.5,6.3);
$pdf->MultiCell( 5  , 0.6 , iconv( 'UTF-8','cp874' , "$status_comment" ),0,'L' );


$pdf->SetFont('angsana','B',16);
$pdf->setXY( 15.3,8.0  );
$pdf->Cell( 4.7,2.5, "",1,1,"c" );

if($want_bus=="0")
{

$pdf->setXY( 16.5, 9.0  );
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "ต้องการรถใหญ่" ),0,'L' );
$pdf->setXY(17.5,8.2);
$pdf->MultiCell( 0.70 , 0.70 , iconv( 'UTF-8','cp874' , "" ),1,'L' );
}
else if($want_bus=="1")
{
$pdf->Image("images/cor.jpeg",16.8,8.2,2.0,1.0);

$pdf->setXY( 16.5,9.5);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "ต้องการรถใหญ่" ),0,'L' );

}


$pdf->SetFont('angsana','B',16);


$pdf->setXY( 16, 11.0);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "รายละเอียดการเก็บเงิน" ),0,'L' );


$pdf->SetFont('angsa','',16);

if($no_price=="0")
{

$pdf->setXY(16.0,11.6);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "ไม่ต้องเก็บเงิน" ),0,'L' );
$pdf->setXY( 15.45,11.8);
$pdf->MultiCell( 0.35  , 0.35 , iconv( 'UTF-8','cp874' , "" ),1,'L' );
}
else if($no_price=="1")
{

$pdf->Image("images/cor.jpeg",15.2,11.6,0.90,0.60);

$pdf->setXY( 16.0,11.6);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "ไม่ต้องเก็บเงิน" ),0,'L' );
}
if($cash=="0")
{
$pdf->setXY(16.0,12.2);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "เก็บเงินสด" ),0,'L' );
$pdf->setXY(17.9,12.2);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "$price" ),0,'L' );
$pdf->setXY(19.7,12.2);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "บาท " ),0,'L' );
$pdf->setXY(17.9,12.2);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "$price" ),0,'L' );

$pdf->setXY( 15.45,12.4  );
$pdf->MultiCell( 0.35  , 0.35 , iconv( 'UTF-8','cp874' , "" ),1,'L' );
}
else if($cash=="1")
{
$pdf->Image("images/cor.jpeg",15.2,12.2,0.90,0.60);
$pdf->setXY( 16.0,12.2);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "เก็บเงินสด " ),0,'L' );
$pdf->setXY(17.9,12.2);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "$price" ),0,'L' );
$pdf->setXY(19.7,12.2);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "บาท " ),0,'L' );

}
if($credit=="0")
{
$pdf->setXY(16.0,12.8);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "รูดการ์ด" ),0,'L' );
$pdf->setXY(17.9,12.8);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "$unit_credit"),0,'L' );
$pdf->setXY(19.7,12.8);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "บาท" ),0,'L' );
$pdf->setXY( 15.45,13.0);
$pdf->MultiCell( 0.35  , 0.35 , iconv( 'UTF-8','cp874' , "" ),1,'L' );
}
else if($credit=="1")
{
$pdf->SetFont('angsa','',14);
$pdf->Image("images/cor.jpeg",15.2,12.8,0.90,0.60);
$pdf->setXY(16.0,12.8);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "รูดการ์ด " ),0,'L' );
$pdf->setXY(17.3,12.8);
$pdf->MultiCell(2.5, 0.6 , iconv( 'UTF-8','cp874' , "$unit_credit"),0,'L' );
$pdf->setXY(19.7,12.8);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "บาท" ),0,'L' );

}

$pdf->SetFont('angsa','',16);

if($bill=="0")
{
$pdf->setXY(16.0,13.4);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "วางบิล" ),0,'L' );
$pdf->setXY(17.9,13.4);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "$unit_bill" ),0,'L' );
$pdf->setXY(19.7,13.4);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "บาท" ),0,'L' );
$pdf->setXY( 15.45,13.6);
$pdf->MultiCell( 0.35  , 0.35 , iconv( 'UTF-8','cp874' , "" ),1,'L' );
}
else if($bill=="1")
{

$pdf->Image("images/cor.jpeg",15.2,13.4,0.90,0.60);

$pdf->setXY(16.0,13.4);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "วางบิล" ),0,'L' );
$pdf->setXY(17.9,13.4);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "$unit_bill" ),0,'L' );
$pdf->setXY(19.7,13.4);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "บาท" ),0,'L' );
}

if($check_peper=="0")
{
$pdf->setXY(16.0,14.0);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "รับเช็ค" ),0,'L' );
$pdf->setXY(17.9,14.0);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "$unit_check" ),0,'L' );
$pdf->setXY(19.7,14.0);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "บาท" ),0,'L' );
$pdf->setXY( 15.45,14.2);
$pdf->MultiCell( 0.35  , 0.35 , iconv( 'UTF-8','cp874' , "" ),1,'L' );
}
else if($check_peper=="1")
{

$pdf->Image("images/cor.jpeg",15.2,14.0,0.90,0.60);

$pdf->setXY(16.0,14.0);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "รับเช็ค" ),0,'L' );
$pdf->setXY(17.9,14.0);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "$unit_check" ),0,'L' );
$pdf->setXY(19.7,14.0);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "บาท" ),0,'L' );
}

if($tran=="0")
{$pdf->setXY(16.0,14.6);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "ลูกค้าโอนเงินหน้างาน" ),0,'L' );
$pdf->setXY( 15.45,14.8);
$pdf->MultiCell( 0.35  , 0.35 , iconv( 'UTF-8','cp874' , "" ),1,'L' );
$pdf->setXY(16.0,15.2);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "จำนวนเงิน" ),0,'L' );
$pdf->setXY(17.9,15.2);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "$unit_tran" ),0,'L' );
$pdf->setXY(19.7,15.2);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "บาท" ),0,'L' );

}
else if($tran=="1")
{
$pdf->setXY(16.0,14.6);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "ลูกค้าโอนเงินหน้างาน" ),0,'L' );
$pdf->Image("images/cor.jpeg",15.2,14.6,0.90,0.60);

$pdf->setXY(16.0,15.2);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "จำนวนเงิน" ),0,'L' );
$pdf->setXY(17.9,15.2);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "$unit_tran" ),0,'L' );
$pdf->setXY(19.7,15.2);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "บาท" ),0,'L' );
}

if($dep=="0")
{$pdf->setXY(16.0,15.8);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "อื่นๆ :" ),0,'L' );
$pdf->setXY( 15.45,16.0);
$pdf->MultiCell( 0.35  , 0.35 , iconv( 'UTF-8','cp874' , "" ),1,'L' );
$pdf->setXY(17.0,15.8);
$pdf->MultiCell( 3.8, 0.6 , iconv( 'UTF-8','cp874' , "$dept" ),0,'L' );

}
else if($dep=="1")
{
$pdf->setXY(16.0,15.8);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "อื่นๆ :" ),0,'L' );
$pdf->Image("images/cor.jpeg",15.2,15.8,0.90,0.60);

$pdf->setXY(17.0,15.8);
$pdf->MultiCell( 3.8, 0.6 , iconv( 'UTF-8','cp874' , "$dept" ),0,'L' );
}
$pdf->setXY( 17.0,16.4);
$pdf->Cell(3.8,0,'','T',0,'c',0);

$pdf->setXY( 16.9,17.0);
$pdf->Cell(3.8,0,'','T',0,'c',0);
$pdf->setXY( 16.9,17.6);
$pdf->Cell(3.8,0,'','T',0,'c',0);



if($fix_date=="0")
{
$pdf->setXY( 15.45,17.8);
$pdf->MultiCell( 0.35  , 0.35 , iconv( 'UTF-8','cp874' , "" ),1,'L' );
//หมายเหตุ
$pdf->setXY( 16.0, 17.6);
$pdf->MultiCell(5.0, 0.6 , iconv( 'UTF-8','cp874' , "นัดวันเวลาเรียบร้อยแล้ว (ห้ามเลื่อน)" ),0,'L' );

}

else if($fix_date=="1")
{

$pdf->Image("images/cor.jpeg",15.2,17.6,0.90,0.60);

$pdf->setXY(16.0,17.6 );
$pdf->MultiCell( 5.0, 0.6 , iconv( 'UTF-8','cp874' , "นัดวันเวลาเรียบร้อยแล้ว (ห้ามเลื่อน)" ),0,'L' );

}


if($call_employee=="0")
{

$pdf->setXY( 15.45,19.0);
$pdf->MultiCell( 0.35  , 0.35 , iconv( 'UTF-8','cp874' , "" ),1,'L' );
//หมายเหตุ
$pdf->setXY(16.0,18.8);
$pdf->MultiCell( 4.7, 0.6 , iconv( 'UTF-8','cp874' , "ติดต่อกลับเจ้าของงานเมื่องานเรียบร้อย" ),0,'L' );

}

else if($call_employee=="1")
{

$pdf->Image("images/cor.jpeg",15.2,18.8,0.90,0.60);

$pdf->setXY(16.0, 18.8);
$pdf->MultiCell( 4.7, 0.6 , iconv( 'UTF-8','cp874' , "ติดต่อกลับเจ้าของงานเมื่องานเรียบร้อย" ),0,'L' );

}




if($status=="ส่ง")
{

$pdf->Image("images/cor.jpeg",1.6,13.79,0.70,0.40);

$pdf->setXY( 2.8,13.9);
$pdf->MultiCell( 0.25  , 0.25 , iconv( 'UTF-8','cp874' , "" ),1,'L' );
$pdf->setXY( 2.1, 13.7);
$pdf->MultiCell( 5  , 0.6 , iconv( 'UTF-8','cp874' , "ส่ง" ),0,'L' );
$pdf->setXY( 3.3,13.7);
$pdf->MultiCell( 5  , 0.6 , iconv( 'UTF-8','cp874' , "รับ" ),0,'L' );
}

else if($status=="รับ")
{
$pdf->setXY( 1.6, 13.9);
$pdf->MultiCell( 0.25  , 0.25 , iconv( 'UTF-8','cp874' , "" ),1,'L' );
$pdf->Image("images/cor.jpeg",2.8,13.79,0.70,0.40);

//หมายเหตุ
$pdf->setXY( 2.1, 13.7);
$pdf->MultiCell( 5 , 0.6 , iconv( 'UTF-8','cp874' , "ส่ง" ),0,'L' );
$pdf->setXY( 3.3,13.7);
$pdf->MultiCell( 5  , 0.6 , iconv( 'UTF-8','cp874' , "รับ" ),0,'L' );
}
$pdf->SetFont('angsana','B',16);
$pdf->setXY( 1.6, 14.3);
$pdf->MultiCell( 12  , 0.6 , iconv( 'UTF-8','cp874' , "อ้างอิงเอกสาร no:" ),0,'L' );

$pdf->SetFont('angsa','',16);

$pdf->setXY(4.5, 14.9);
$pdf->Cell(9.0,0,'','T',0,'c',0);
$pdf->setXY(4.5, 15.5);
$pdf->Cell(9.0,0,'','T',0,'c',0);
if($ref_id !=''){
$pdf->setXY( 4.5, 14.3);
$pdf->MultiCell( 9, 0.6 , iconv( 'UTF-8//IGNORE','cp874//IGNORE' , "$product_sn เลขที่อ้างอิง  $ref_id" ),0,'L' );
}else{
$pdf->setXY( 4.5, 14.3);
$pdf->MultiCell( 9, 0.6 , iconv( 'UTF-8//IGNORE','cp874//IGNORE' , "$product_sn" ),0,'L' );	
}

$pdf->SetFont('angsana','B',16);
$pdf->setXY( 1.6,15.8);
$pdf->MultiCell(12, 0.6 , iconv( 'UTF-8','cp874' , "รายละเอียดงาน :" ),0,'L' );

$pdf->SetFont('angsa','',14);
$pdf->setXY(4.5, 16.3);
$pdf->Cell(9.0,0,'','T',0,'c',0);
$pdf->setXY(4.5, 16.8);
$pdf->Cell(9.0,0,'','T',0,'c',0);
$pdf->setXY(4.5, 17.3);
$pdf->Cell(9.0,0,'','T',0,'c',0);
$pdf->setXY(4.5, 17.8);
$pdf->Cell(9.0,0,'','T',0,'c',0);
$pdf->setXY(4.5, 18.3);
$pdf->Cell(9.0,0,'','T',0,'c',0);
$pdf->setXY(4.5, 18.8);
$pdf->Cell(9.0,0,'','T',0,'c',0);
$pdf->setXY(4.5, 19.3);
$pdf->Cell(9.0,0,'','T',0,'c',0);
$pdf->setXY(4.5, 19.8);
$pdf->Cell(9.0,0,'','T',0,'c',0);

$pdf->setXY( 4.5,15.8);
$pdf->MultiCell(9,0.5, iconv( 'UTF-8//IGNORE','cp874//IGNORE' , "$product_name" ),0,'L' );




$pdf->SetFont('angsana','B',12);

$pdf->setXY( 1.6, 20.0 );
$pdf->MultiCell(5  , 0.6 , iconv( 'UTF-8','cp874' , "เวลาลงงาน:" ),0,'L' );

$pdf->SetFont('angsa','',12);

$pdf->setXY(3.4, 20 );
$pdf->MultiCell(5  , 0.6 , iconv( 'UTF-8','cp874' , "$newadd_date" ),0,'L' );

$pdf->SetFont('angsa','',12);
$pdf->setXY(6.0, 20 );
$pdf->MultiCell(5  , 0.6 , iconv( 'UTF-8','cp874' , "$add_by" ),0,'L' );

$pdf->SetFont('angsana','B',12);
$pdf->setXY( 16.6, 20 );
$pdf->MultiCell(5  , 0.6 , iconv( 'UTF-8','cp874' , "เวลา Print:" ),0,'L' );

$pdf->SetFont('angsa','',12);
$pdf->setXY( 18.0, 20 );
$pdf->MultiCell(5  , 0.6 , iconv( 'UTF-8','cp874' , "$date" ),0,'L' );


$pdf->SetFont('angsa','',16);
$pdf->setXY( 1.4,21  );
$pdf->Cell( 19.2,3.8, "",1,1,"c" );

$pdf->setXY( 1.6, 21.5 );
$pdf->MultiCell(5  , 0.6 , iconv( 'UTF-8','cp874' , "แผนที่  :" ),0,'L' );

if($have_map=="2")
{



$pdf->setXY(3.7,21.5);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "มีแผนที่" ),0,'L' );
$pdf->setXY( 3.2,21.6);
$pdf->MultiCell( 0.35  , 0.35 , iconv( 'UTF-8','cp874' , "" ),1,'L' );

$pdf->setXY(6.8,21.5);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "ไม่มีแผนที่" ),0,'L' );
$pdf->Image("images/cor.jpeg",5.9,21.5,0.90,0.60);

}

else if($have_map=="1")
{

$pdf->Image("images/cor.jpeg",3.5,21.5,0.90,0.60);
$pdf->setXY(4.6,21.5);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "มีแผนที่" ),0,'L' );

$pdf->SetFont('angsana','B',20);
$pdf->setXY(9,23);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "ตามเอกสารแนบท้าย" ),0,'L' );

$pdf->SetFont('angsa','',16);
$pdf->setXY( 6.5,21.7);
$pdf->MultiCell( 0.35  , 0.35 , iconv( 'UTF-8','cp874' , "" ),1,'L' );
$pdf->setXY(7.0,21.5);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "ไม่มีแผนที่" ),0,'L' );
}

$pdf->SetFont('angsa','',16);
$pdf->setXY( 15.0,25.5);
$pdf->MultiCell(12, 0.6 , iconv( 'UTF-8','cp874' , "ผู้อนุมัติ :" ),0,'L' );
$pdf->setXY(16.5,26.1);
$pdf->Cell(4.0,0,'','T',0,'c',0);
$pdf->setXY( 16.5,26.3);
$pdf->MultiCell(12, 0.6 , iconv( 'UTF-8','cp874' , "(........................................)" ),0,'L' );
$pdf->setXY( 15.0,26.9);
$pdf->MultiCell(12, 0.6 , iconv( 'UTF-8','cp874' , "วันที่ :" ),0,'L' );
$pdf->setXY( 16.5,26.9);
$pdf->MultiCell(12, 0.6 , iconv( 'UTF-8','cp874' , "............/............./............." ),0,'L' );

$pdf->SetFont('angsa','',11);
$pdf->setXY(0.5,27.6);
$pdf->MultiCell(12,0, iconv( 'UTF-8','cp874' , "อนุมัติวันที่ 29 พ.ย. 2565" ),0,'L' );

$pdf->setXY(18.5,27.6);
$pdf->MultiCell(12,0, iconv( 'UTF-8','cp874' , "FM-SA-05 : Rev.2" ),0,'L' );

if($objResult["check_detail"]=='1')
			  {
$pdf->AddPage();
	
$pdf->SetFont('angsa','',11);
$pdf->setXY(0.5,27.6);
$pdf->MultiCell(12,0, iconv( 'UTF-8','cp874' , "อนุมัติวันที่ 29 พ.ย. 2565" ),0,'L' );

$pdf->setXY(18.5,27.6);
$pdf->MultiCell(12,0, iconv( 'UTF-8','cp874' , "FM-SA-05 : Rev.2" ),0,'L' );
	
	
$pdf->SetFont('angsana','BU',20);

$pdf->setXY( 8.0, 1.0  );
$pdf->MultiCell( 9  , 0.6 , iconv( 'UTF-8','cp874' , "ใบแจ้งรายละเอียดการจัดส่งสินค้า"),0 ,'L' );
$pdf->setXY( 8.8, 1.5  );
$pdf->MultiCell( 5.5  , 0.6 , iconv( 'UTF-8','cp874' , "Delivery Information"),0 ,'L' );
$pdf->SetFont('angsana','B',16);

$pdf->SetFont('angsana','B',16);

$pdf->setXY( 15, 2.5  );
$pdf->MultiCell( 5  , 0.6 , iconv( 'UTF-8','cp874' , "ID NO." ),0,'L' );


$pdf->SetFont('angsa','',16);

$pdf->setXY( 16.5, 3.1  );
$pdf->Cell(3.5,0,'','T',0,'C',0);

$pdf->setXY( 16.5, 2.5  );
$pdf->MultiCell( 5  , 0.6 , iconv( 'UTF-8','cp874' , "$running" ),0,'L' );



$pdf->SetFont('angsana','B',16);

$pdf->setXY( 1.6,2.5  );
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "ชื่อผู้ติดต่อ  :" ),0,'L' );

$pdf->SetFont('angsa','',16);
$pdf->setXY( 4.5, 3.1  );
$pdf->Cell(9,0,'','T',0,'c',0);
$pdf->setXY( 4.5,2.5  );
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8//IGNORE','cp874//IGNORE' , "$customer_name" ),0,'L' );

$pdf->SetFont('angsana','B',16);
$pdf->setXY( 1.6, 3.2 );
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "เบอร์โทร :" ),0,'L' );

$pdf->SetFont('angsa','',16);
$pdf->setXY( 4.5, 3.8  );
$pdf->Cell(9,0,'','T',0,'c',0);

$pdf->setXY( 4.5, 3.2 );
$pdf->MultiCell(11.0, 0.6 , iconv( 'UTF-8','cp874' , "$customer_tel" ),0,'L' );

$pdf->SetFont('angsana','B',16);
$pdf->setXY( 1.6, 3.9  );
$pdf->MultiCell(12, 0.6 , iconv( 'UTF-8','cp874' , "สถานที่จัดส่ง :" ),0,'L' );

$pdf->SetFont('angsa','',16);
$pdf->setXY( 4.5, 4.5  );
$pdf->Cell(9,0,'','T',0,'c',0);

$pdf->setXY( 4.5, 3.9  );
$pdf->MultiCell(9, 0.6 , iconv( 'UTF-8//IGNORE','cp874//IGNORE' , "$address_name" ),0,'L' );

$pdf->SetFont('angsana','B',16);
$pdf->setXY( 1.6, 4.5  );
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "ที่อยู่จัดส่ง :" ),0,'L' );

$pdf->SetFont('angsa','',16);
$pdf->setXY( 4.5, 5.1  );
$pdf->Cell(9,0,'','T',0,'c',0);

$pdf->setXY( 4.5, 5.7  );
$pdf->Cell(9,0,'','T',0,'c',0);
$pdf->setXY( 4.5, 6.3  );
$pdf->Cell(9,0,'','T',0,'c',0);


$pdf->setXY( 4.5, 4.5 );
$pdf->MultiCell(9, 0.6 , iconv( 'UTF-8//IGNORE','cp874//IGNORE' , "$address_send" ),0,'L' );

$pdf->SetFont('angsana','B',16);
$pdf->setXY( 16.5, 4.1  );
$pdf->Cell(0,3.5,'','T',0,'C',0);

$pdf->setXY( 15, 3.5  );
$pdf->MultiCell( 5  , 0.6 , iconv( 'UTF-8','cp874' , "วันที่:" ),0,'L' );

$pdf->setXY( 16.5, 5.1  );
$pdf->Cell(0,3.5,'','T',0,'C',0);
$pdf->setXY( 15, 4.5  );
$pdf->MultiCell(5  , 0.6 , iconv( 'UTF-8','cp874' , "เวลา:" ),0,'L' );

$pdf->setXY( 16.5, 6.1  );
$pdf->Cell(0,3.5,'','T',0,'C',0);
$pdf->setXY( 15,5.5 );
$pdf->MultiCell( 5  , 0.6 , iconv( 'UTF-8','cp874' , "แผนก:" ),0,'L' );

$pdf->SetFont('angsa','',16);

$pdf->setXY( 16.5, 3.5  );
$pdf->MultiCell( 5  , 0.6 , iconv( 'UTF-8','cp874' , "$newDate" ),0,'L' );

$pdf->setXY( 16.5, 4.5  );
$pdf->MultiCell(5  , 0.6 , iconv( 'UTF-8','cp874' , "$time" ),0,'L' );

$pdf->setXY( 16.5,5.5 );
$pdf->MultiCell( 5  , 0.6 , iconv( 'UTF-8','cp874' , "$department" ),0,'L' );

$pdf->SetFont('angsa','',16);

if($runway=="0")
{

$pdf->setXY( 2.0,6.6);
$pdf->MultiCell( 0.35  , 0.35 , iconv( 'UTF-8','cp874' , "" ),1,'L' );
//หมายเหตุ
$pdf->setXY( 2.5,6.4);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "ติดถนนรันเวย์" ),0,'L' );

}

else if($runway=="1")
{

$pdf->Image("images/cor.jpeg",1.8,6.4,0.90,0.60);

$pdf->setXY( 2.5,6.4);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "ติดถนนรันเวย์" ),0,'L' );

}

if($road=="0")
{

$pdf->setXY( 5.5,6.6);
$pdf->MultiCell( 0.35  , 0.35 , iconv( 'UTF-8','cp874' , "" ),1,'L' );
//หมายเหตุ
$pdf->setXY( 6.0,6.4);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "ติดถนนวิ่งสวนกัน" ),0,'L' );

}

else if($road=="1")
{

$pdf->Image("images/cor.jpeg",5.3,6.4,0.90,0.60);

$pdf->setXY( 6.0,6.4);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "ติดถนนวิ่งสวนกัน" ),0,'L' );

}

if($soy=="0")
{

$pdf->setXY( 2.0,7.2);
$pdf->MultiCell( 0.35  , 0.35 , iconv( 'UTF-8','cp874' , "" ),1,'L' );
//หมายเหตุ
$pdf->setXY( 2.5,7.0);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "เข้าซอย" ),0,'L' );

}

else if($soy=="1")
{

$pdf->Image("images/cor.jpeg",1.8,7.0,0.90,0.60);

$pdf->setXY( 2.5,7.0);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "เข้าซอย" ),0,'L' );

}

$pdf->SetFont('angsana','B',16);

$pdf->setXY( 5.3,7.0);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "ทางเข้า กว้าง :" ),0,'L' );

$pdf->SetFont('angsa','',16);

$pdf->setXY( 7.8,7.0);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "$soy_long" ),0,'L' );

$pdf->setXY(9.0,7.0);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "เมตร" ),0,'L' );

if($hieght_ltd=="1")
{


	$pdf->Image("images/cor.jpeg",10.2,7.0,0.90,0.60);
//หมายเหตุ
$pdf->setXY(10.8,7.0);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "มีตัวจำกัดความสูง" ),0,'L' );

}

else 
{

$pdf->setXY(10.2,7.2);
$pdf->MultiCell( 0.35  , 0.35 , iconv( 'UTF-8','cp874' , "" ),1,'L' );

$pdf->setXY( 10.8,7.0);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "มีตัวจำกัดความสูง" ),0,'L' );

}


if($car_load=="0")
{

$pdf->setXY( 2.0,7.8);
$pdf->MultiCell( 0.35  , 0.35 , iconv( 'UTF-8','cp874' , "" ),1,'L' );
//หมายเหตุ
$pdf->setXY( 2.5,7.6);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "รถยนต์เข้าได้" ),0,'L' );

}

else if($car_load=="1")
{

$pdf->Image("images/cor.jpeg",1.8,7.6,0.90,0.60);

$pdf->setXY( 2.5,7.6);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "รถยนต์เข้าได้" ),0,'L' );

}

if($no_car_road=="0")
{

$pdf->setXY( 5.5,7.8);
$pdf->MultiCell( 0.35  , 0.35 , iconv( 'UTF-8','cp874' , "" ),1,'L' );
//หมายเหตุ
$pdf->setXY(6.0,7.6);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "รถยนต์เข้าไม่ได้" ),0,'L' );

}

else if($no_car_road=="1")
{

$pdf->Image("images/cor.jpeg",5.3,7.6,0.90,0.60);

$pdf->setXY(6.0,7.6);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "รถยนต์เข้าไม่ได้" ),0,'L' );

}
$pdf->SetFont('angsana','B',16);

$pdf->setXY( 9.0,7.6);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "สามารถจอดได้ที่ :" ),0,'L' );

$pdf->SetFont('angsa','',16);

$pdf->setXY( 12.0,8.2);
$pdf->Cell(0,8,'','T',0,'C',0);

$pdf->setXY( 12.0,7.6);
$pdf->MultiCell( 8, 0.6 , iconv( 'UTF-8','cp874' , "$car_park" ),0,'L' );

$pdf->SetFont('angsa','',16);

if($car_road=="0")
{

$pdf->setXY( 2.0,8.4);
$pdf->MultiCell( 0.35  , 0.35 , iconv( 'UTF-8','cp874' , "" ),1,'L' );
//หมายเหตุ
$pdf->setXY( 2.5,8.2);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "จอดรถข้างถนน" ),0,'L' );

}

else if($car_road=="1")
{

$pdf->Image("images/cor.jpeg",1.8,8.2,0.90,0.60);

$pdf->setXY( 2.5,8.8);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "จอดรถข้างถนน" ),0,'L' );

}

if($car_home=="0")
{

$pdf->setXY( 5.5,8.4);
$pdf->MultiCell( 0.35 ,0.35 , iconv( 'UTF-8','cp874' , "" ),1,'L' );
//หมายเหตุ
$pdf->setXY( 6.0,8.2);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "จอดรถหน้าบ้านได้" ),0,'L' );

}

else if($car_home=="1")
{

$pdf->Image("images/cor.jpeg",5.3,8.2,0.90,0.60);

$pdf->setXY(6.0,8.2);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "จอดรถหน้าบ้านได้" ),0,'L' );

}

$pdf->SetFont('angsana','B',16);


$pdf->setXY(9,8.2);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "ประตูหน้าบ้านสูง :" ),0,'L' );

$pdf->SetFont('angsa','',16);

$pdf->setXY( 12.5,8.2);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "$door_long" ),0,'L' );
$pdf->setXY(18.0,8.2);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "เมตร" ),0,'L' );



if($slope=="0")
{

$pdf->setXY( 2.0,9.0);
$pdf->MultiCell( 0.35  , 0.35 , iconv( 'UTF-8','cp874' , "" ),1,'L' );
//หมายเหตุ
$pdf->setXY( 2.5,8.8);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "มีทางราบก่อนประตูบ้าน" ),0,'L' );

}

else if($slope=="1")
{

$pdf->Image("images/cor.jpeg",1.8,8.8,0.90,0.60);

$pdf->setXY( 2.5,8.8);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "มีทางราบก่อนประตูบ้าน" ),0,'L' );

}

if($bundai=="0")
{

$pdf->setXY( 7.0,9.0);
$pdf->MultiCell( 0.35  , 0.35 , iconv( 'UTF-8','cp874' , "" ),1,'L' );
//หมายเหตุ
$pdf->setXY( 7.5,8.8);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "มีบันไดก่อนประตูบ้าน" ),0,'L' );

}

else if($bundai=="1")
{

$pdf->Image("images/cor.jpeg",6.8,8.8,0.90,0.60);

$pdf->setXY(7.5,8.8);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "มีบันไดก่อนประตูบ้าน" ),0,'L' );

}

$pdf->SetFont('angsana','B',16);


$pdf->setXY( 12.0,8.8);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "จำนวน :" ),0,'L' );

$pdf->SetFont('angsa','',16);

$pdf->setXY( 13.5,8.8);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "$unit_bundai" ),0,'L' );
$pdf->setXY( 18.0,8.8);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "ขั้น" ),0,'L' );


$pdf->SetFont('angsana','B',16);

$pdf->setXY( 1.6,9.4);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "ประตูบ้านกว้าง :" ),0,'L' );

$pdf->SetFont('angsa','',16);

$pdf->setXY( 4.5,9.4);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "$door_big " ),0,'L' );
$pdf->setXY( 5.8,9.4);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "เมตร" ),0,'L' );

$pdf->SetFont('angsana','B',16);

$pdf->setXY( 7.1,9.4);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "สูง :" ),0,'L' );

$pdf->SetFont('angsa','',16);

$pdf->setXY(8.0,9.4);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "$door_longer " ),0,'L' );
$pdf->setXY( 10.0,9.4);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "เมตร" ),0,'L' );

$pdf->SetFont('angsana','B',16);

$pdf->setXY( 11.0,9.4);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "ประตูบ้านเป็นแบบ :" ),0,'L' );

$pdf->SetFont('angsa','',16);
$pdf->setXY( 14.3,10.0);
$pdf->Cell(0,4.7,'','T',0,'C',0);

$pdf->setXY( 14.3,9.4);
$pdf->MultiCell( 4.7, 0.6 , iconv( 'UTF-8','cp874' , "$type_door " ),0,'L' );


$pdf->SetFont('angsana','B',16);

$pdf->setXY( 9.0,10.0);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "พื้นบ้านเป็นแบบ :" ),0,'L' );

$pdf->SetFont('angsa','',16);

$pdf->setXY( 12.0,10.6);
$pdf->Cell(8.0,0,'','T',0,'C',0);
$pdf->setXY(12.0,10.0);
$pdf->MultiCell( 12.6, 0.6 , iconv( 'UTF-8','cp874' , "$home_type " ),0,'L' );

$pdf->SetFont('angsana','B',16);

$pdf->setXY( 1.6,10.0);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "ติดตั้งที่ชั้น :" ),0,'L' );

$pdf->SetFont('angsa','',16);
$pdf->setXY( 3.8,10.6);
$pdf->Cell(4.5,0,'','T',0,'C',0);


$pdf->setXY( 3.8, 10.0);
$pdf->MultiCell( 4.0, 0.6 , iconv( 'UTF-8','cp874' , "$install" ),0,'L' );


$pdf->SetFont('angsana','B',16);

$pdf->setXY( 1.6, 10.6);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "ประตูห้องกว้าง :" ),0,'L' );

$pdf->SetFont('angsa','',16);

$pdf->setXY( 4.5, 10.6);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "$room_bigger " ),0,'L' );
$pdf->setXY( 5.8,10.6);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "เมตร" ),0,'L' );

$pdf->SetFont('angsana','B',16);

$pdf->setXY( 7.1,10.6);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "สูง :" ),0,'L' );

$pdf->setXY( 12.0, 10.6);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "ชนิดบันได :" ),0,'L' );

$pdf->SetFont('angsa','',16);

$pdf->setXY( 14.0, 11.2);
$pdf->Cell(6.0,0,'','T',0,'C',0);

$pdf->setXY( 14.0, 10.6);
$pdf->MultiCell( 4, 0.6 , iconv( 'UTF-8','cp874' , "$type_bundai" ),0,'L' );	



$pdf->SetFont('angsa','',16);

$pdf->setXY(9.0,10.6);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "$room_longer " ),0,'L' );
$pdf->setXY( 11.0,10.6);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "เมตร" ),0,'L' );
	


if($bundai_install=="0")
{

$pdf->setXY( 2.0,11.4);
$pdf->MultiCell( 0.35  , 0.35 , iconv( 'UTF-8','cp874' , "" ),1,'L' );
//หมายเหตุ
$pdf->setXY( 2.5,11.2);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "บันได" ),0,'L' );

}

else if($bundai_install=="1")
{

$pdf->Image("images/cor.jpeg",1.8,11.2,0.90,0.60);

$pdf->setXY( 2.7,11.2);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "บันได" ),0,'L' );

}

$pdf->SetFont('angsana','B',16);

$pdf->setXY( 7.1, 11.2);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "กว้าง :" ),0,'L' );
$pdf->SetFont('angsa','',16);


$pdf->setXY( 9.5,11.2);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "$bundai_big" ),0,'L' );

$pdf->setXY( 11,11.2);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "เมตร" ),0,'L' );
$pdf->SetFont('angsana','B',16);
$pdf->setXY( 13.5, 11.2);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "หักมุมบันได :" ),0,'L' );

$pdf->SetFont('angsa','',16);

$pdf->setXY( 16.0, 11.8  );
$pdf->Cell(4,0,'','T',0,'C',0);

$pdf->setXY( 16.0, 11.2);
$pdf->MultiCell( 4, 0.6 , iconv( 'UTF-8','cp874' , "$bundai_hug" ),0,'L' );

if($lip=="0")
{

$pdf->setXY( 2.0,12.0);
$pdf->MultiCell( 0.35  , 0.35 , iconv( 'UTF-8','cp874' , "" ),1,'L' );
//หมายเหตุ
$pdf->setXY( 2.5,11.8);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "ลิฟท์" ),0,'L' );

}

else if($lip=="1")
{

$pdf->Image("images/cor.jpeg",1.8,11.8,0.90,0.60);

$pdf->setXY( 2.5,11.8);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "ลิฟท์" ),0,'L' );

}

$pdf->SetFont('angsana','B',16);

$pdf->setXY( 4.0, 11.8);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "กว้าง :" ),0,'L' );

$pdf->SetFont('angsa','',16);

$pdf->setXY( 5.5, 11.8);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "$lip_big" ),0,'L' );

$pdf->setXY( 7.0,11.8);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "เมตร" ),0,'L' );
$pdf->SetFont('angsana','B',16);


$pdf->setXY( 8.5,11.8);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "สูง :" ),0,'L' );

$pdf->SetFont('angsa','',16);

$pdf->setXY( 9.5,11.8);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "$lip_long" ),0,'L' );

$pdf->setXY( 11.0,11.8);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "เมตร" ),0,'L' );

$pdf->SetFont('angsana','B',16);


$pdf->setXY( 13.5,11.8);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "รับน้ำหนักได้ :" ),0,'L' );

$pdf->SetFont('angsa','',16);

$pdf->setXY( 16.0,11.8);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "$lip_weight" ),0,'L' );

$pdf->setXY( 18.0,11.8);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "กิโลกรัม" ),0,'L' );

$pdf->SetFont('angsa','',16);
if($want_employee=="0")
{

$pdf->setXY( 2.0,12.6);
$pdf->MultiCell( 0.35  , 0.35 , iconv( 'UTF-8','cp874' , "" ),1,'L' );
//หมายเหตุ
$pdf->setXY( 2.5,12.4);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "ต้องการเจ้าหน้าที่ย้ายเฟอร์นิเจอร์" ),0,'L' );

}

else if($want_employee=="1")
{

$pdf->Image("images/cor.jpeg",1.8,12.4,0.90,0.60);

$pdf->setXY( 2.5,12.4);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "ต้องการเจ้าหน้าที่ย้ายเฟอร์นิเจอร์" ),0,'L' );

}
	
if($head_bad=="0")
{

$pdf->setXY( 13.0,12.6);
$pdf->MultiCell( 0.35  , 0.35 , iconv( 'UTF-8','cp874' , "" ),1,'L' );
//หมายเหตุ
$pdf->setXY( 14.0,12.4);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "ต้องถอดหัวเตียง-ท้ายเตียง" ),0,'L' );

}

else if($head_bad=="1")
{

$pdf->Image("images/cor.jpeg",13.0,12.4,0.90,0.60);

$pdf->setXY( 14.0,12.4);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "ต้องถอดหัวเตียง-ท้ายเตียง" ),0,'L' );

}

$pdf->SetFont('angsana','B',16);

$pdf->setXY( 8.5,12.4);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "จำนวน :" ),0,'L' );

$pdf->SetFont('angsa','',16);

$pdf->setXY( 10,12.4);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "$employee_unit" ),0,'L' );

$pdf->setXY( 11.0,12.4);
$pdf->MultiCell( 5, 0.6 , iconv( 'UTF-8','cp874' , "คน" ),0,'L' );

$pdf->SetFont('angsana','B',16);

$pdf->setXY( 1.6, 13.6);
$pdf->MultiCell( 10, 0.7 , iconv( 'UTF-8','cp874' , "ย้ายเฟอร์นิเจอร์ :" ),0,'L' );

$pdf->SetFont('angsa','',16);
	
	if($up=="1")
{
$pdf->Image("images/cor.jpeg",1.8,12.4,0.90,0.60);

//หมายเหตุ
$pdf->setXY( 2.5,13.0);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "ขึ้นลิฟท์ได้" ),0,'L' );

}

else 
{

$pdf->setXY( 2.0,13.2);
$pdf->MultiCell( 0.35  , 0.35 , iconv( 'UTF-8','cp874' , "" ),1,'L' );

$pdf->setXY( 2.5,13.0);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "ขึ้นลิฟท์ได้" ),0,'L' );

}
	

	if($no_up=="1")
{
$pdf->Image("images/cor.jpeg",5.0,12.4,0.90,0.60);

//หมายเหตุ
$pdf->setXY( 5.5,13.0);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "ขึ้นลิฟท์ไม่ได้" ),0,'L' );

}

else 
{

$pdf->setXY( 5.0,13.2);
$pdf->MultiCell( 0.35  , 0.35 , iconv( 'UTF-8','cp874' , "" ),1,'L' );

$pdf->setXY( 5.5,13.0);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "ขึ้นลิฟท์ไม่ได้" ),0,'L' );

}

$pdf->setXY( 4.5,14.2);
$pdf->Cell(6,0,'','T',0,'C',0);
$pdf->setXY( 4.5,14.8);
$pdf->Cell(6,0,'','T',0,'C',0);

$pdf->setXY( 4.5,13.6);
$pdf->MultiCell( 6, 0.7 , iconv( 'UTF-8','cp874' , "$ferniger_name " ),0,'L' );

$pdf->SetFont('angsana','B',16);

$pdf->setXY( 12,13.6);
$pdf->MultiCell( 6, 0.7 , iconv( 'UTF-8','cp874' , "ย้ายไปที่  :" ),0,'L' );

$pdf->SetFont('angsa','',16);

$pdf->setXY( 14,14.8);
$pdf->Cell(6,0,'','T',0,'C',0);
$pdf->setXY( 14,14.2);
$pdf->Cell(6,0,'','T',0,'C',0);

$pdf->setXY(14,13.6);
$pdf->MultiCell( 6, 0.7 , iconv( 'UTF-8','cp874' , "$ferniger_address " ),0,'L' );

if($want_ex=="0")
{

$pdf->setXY( 2.0,15.0);
$pdf->MultiCell( 0.35  , 0.35 , iconv( 'UTF-8','cp874' , "" ),1,'L' );
//หมายเหต
$pdf->setXY( 2.5,14.8);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "ต้องเตรียมอุปกรณ์ไปถอดประกอบ" ),0,'L' );

}

else if($want_ex=="1")
{

$pdf->Image("images/cor.jpeg",1.8,14.8,0.90,0.60);

$pdf->setXY( 2.5,14.8);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "ต้องเตรียมอุปกรณ์ไปถอดประกอบ" ),0,'L' );

}

if($want_prem=="0")
{

$pdf->setXY( 9.0,15.0);
$pdf->MultiCell( 0.35  , 0.35 , iconv( 'UTF-8','cp874' , "" ),1,'L' );
//หมายเหตุ
$pdf->setXY( 9.5,14.8);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "ต้องการให้เตรียมพรีมยืดไปซิวเก็บเตียงหรือที่นอนเก่า" ),0,'L' );

}

else if($want_prem=="1")
{

$pdf->Image("images/cor.jpeg",8.8,14.8,0.90,0.60);

$pdf->setXY(9.5,14.8);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "ต้องการให้เตรียมพรีมยืดไปซิวเก็บเตียงหรือที่นอนเก่า" ),0,'L' );

}

if($want_credit=="0")
{

$pdf->setXY( 2.0,15.6);
$pdf->MultiCell( 0.35  , 0.35 , iconv( 'UTF-8','cp874' , "" ),1,'L' );
//หมายเหตุ
$pdf->setXY( 2.5,15.4);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "ต้องเตรียมเครื่องรูดบัตร" ),0,'L' );

}

else if($want_credit=="1")
{

$pdf->Image("images/cor.jpeg",1.8,15.4,0.90,0.60);

$pdf->setXY( 2.5,15.4);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "ต้องเตรียมเครื่องรูดบัตร" ),0,'L' );

}

$pdf->SetFont('angsana','B',16);


$pdf->setXY( 7.1,15.4);
$pdf->MultiCell( 10, 0.6 , iconv( 'UTF-8','cp874' , "ของธนาคาร :" ),0,'L' );

$pdf->SetFont('angsa','',16);
$pdf->setXY( 9.5,15.9);
$pdf->Cell(10.5,0,'','T',0,'C',0);


$pdf->setXY( 9.5,15.4);
$pdf->MultiCell( 10.5, 0.6 , iconv( 'UTF-8','cp874' , "$bank" ),0,'L' );


$pdf->SetFont('angsana','B',16);

$pdf->setXY( 1.6,16.0);
$pdf->MultiCell(10, 0.6 , iconv( 'UTF-8','cp874' , "เพิ่มเติม  :" ),0,'L' );

$pdf->SetFont('angsa','',16);
$pdf->setXY( 3.5,16.6);
$pdf->Cell(16.5,0,'','T',0,'c',0);
$pdf->setXY( 3.5,17.2);
$pdf->Cell(16.5,0,'','T',0,'c',0);
$pdf->setXY( 3.5,17.8);
$pdf->Cell(16.5,0,'','T',0,'c',0);
$pdf->setXY( 3.5,18.4);
$pdf->Cell(16.5,0,'','T',0,'c',0);
$pdf->setXY( 3.5,19.0);
$pdf->Cell(16.5,0,'','T',0,'c',0);	
$pdf->setXY( 3.5,19.6);
$pdf->Cell(16.5,0,'','T',0,'c',0);
$pdf->setXY( 3.5,20.2);
$pdf->Cell(16.5,0,'','T',0,'c',0);

$pdf->setXY( 3.5,16.0);
$pdf->MultiCell(16.5, 0.6 , iconv( 'UTF-8','cp874' , "$description_tran" ),0,'L' );


			  }

if($objResult["upload_name"]!=''){
			  $pdf->AddPage();
$path = "uploads/$upload_name";

$pdf->SetFont('angsana','BU',20);

$pdf->setXY( 8.0, 1.0  );
$pdf->MultiCell( 9  , 0.6 , iconv( 'UTF-8','cp874' , "แผนที่การจัดส่งสินค้า"),0 ,'L' );





$pdf->Image($path,1.5,3.0,18.0,12.0);

}

if($objResult2["bill_id"]!='' and $objResult3["bill_id"]!=''){

$time_bill = $objResult3["time_bill"];	
$time_check = $objResult3["time_check"];	
$address_bill = $objResult3["address_bill"];	
$address_check = $objResult3["address_check"];	
$step1 = $objResult3["step1"];	
$step2 = $objResult3["step2"];	
$step3 = $objResult3["step3"];	
$step4 = $objResult3["step4"];	
$doc_bill = $objResult3["doc_bill"];	
$step_del1 = $objResult3["step_del1"];	
$time_del = $objResult3["time_del"];	
$adress_del = $objResult3["adress_del"];	
$contact_name = $objResult3["contact_name"];	
$remark1 = $objResult3["remark1"];	
$step_del2 = $objResult3["step_del2"];	
$bank_tran = $objResult3["bank_tran"];	
$doc_check = $objResult3["doc_check"];	
$doc_del = $objResult3["doc_del"];	
$doc_power = $objResult3["doc_power"];	
$time_power = $objResult3["time_power"];	
$count_arkon = $objResult3["count_arkon"];	
$index_no = $objResult3["index_no"];	

	

$pdf->AddPage();
$pdf->SetFont('angsana','BU',20);

$pdf->setXY( 7.0, 1.0  );
$pdf->MultiCell(9,0.6, iconv( 'UTF-8','cp874' , "การรับเช็ค-วางบิล หรือเอกสารที่ใช้ (รพ.)"),0 ,'L' );

$pdf->setXY(0.9,2.0);
$pdf->Cell( 19.2,25.5, "",1,1,"c" );
	
$pdf->SetFont('angsana','BU',16);
$pdf->setXY(1.0,2.2);
$pdf->MultiCell(9,0.6, iconv( 'UTF-8','cp874' , "ข้อมูลการวางบิล"),0 ,'L' );

$pdf->setXY(1.0,9.4);
$pdf->MultiCell(9,0.6, iconv( 'UTF-8','cp874' , "ข้อมูลการรับเช็ค"),0 ,'L' );

$pdf->setXY(1.0,16.7);
$pdf->MultiCell(9,0.6, iconv( 'UTF-8','cp874' , "ข้อมูลการจัดส่ง"),0 ,'L' );

	
$pdf->SetFont('angsana','B',14);	
	
$pdf->setXY(1.0,3.0);
$pdf->MultiCell(9,0.5, iconv( 'UTF-8','cp874' , "วันที่/เวลา วางบิล :"),0 ,'L' );

$pdf->setXY(10.0,3.0);
$pdf->MultiCell(9,0.5, iconv( 'UTF-8','cp874' , "สถานที่วางบิล :"),0 ,'L' );

$pdf->setXY(1.0,4.8);
$pdf->MultiCell(19,0.5, iconv( 'UTF-8','cp874' , "ขั้นตอนการวางบิล1 :"),0 ,'L' );
	

$pdf->setXY(10.0,4.8);
$pdf->MultiCell(19,0.5, iconv( 'UTF-8','cp874' , "ขั้นตอนการวางบิล2 :"),0 ,'L' );

$pdf->setXY(1.0,6.6);
$pdf->MultiCell(19,0.5, iconv( 'UTF-8','cp874' , "ขั้นตอนการวางบิล3 :"),0 ,'L' );

$pdf->setXY(10.0,6.6);
$pdf->MultiCell(19,0.5, iconv( 'UTF-8','cp874' , "ขั้นตอนการวางบิล4 :"),0 ,'L' );
	
$pdf->setXY(1.0,8.4);
$pdf->MultiCell(19,0.5, iconv( 'UTF-8','cp874' , "เอกสารที่ต้องใช้วางบิล :"),0 ,'L' );
	

//รับเช็ค

$pdf->setXY(1.0,10.4);
$pdf->MultiCell(9,0.5, iconv( 'UTF-8','cp874' , "วันที่/เวลา รับเช็ค :"),0 ,'L' );

$pdf->setXY(10.0,10.4);
$pdf->MultiCell(9,0.5, iconv( 'UTF-8','cp874' , "สถานที่รับเช็ค :"),0 ,'L' );

$pdf->setXY(1.0,12.2);
$pdf->MultiCell(19,0.5, iconv( 'UTF-8','cp874' , "เอกสารรับเช็ค :"),0 ,'L' );
	

$pdf->setXY(10.0,12.2);
$pdf->MultiCell(19,0.5, iconv( 'UTF-8','cp874' , "ใบมอบอำนาจ :"),0 ,'L' );

$pdf->setXY(1.0,14.0);
$pdf->MultiCell(19,0.5, iconv( 'UTF-8','cp874' , "ระยะเวลาการมอบอำนาจ :"),0 ,'L' );

$pdf->setXY(10.0,14.0);
$pdf->MultiCell(19,0.5, iconv( 'UTF-8','cp874' , "จำนวนอากร :"),0 ,'L' );
	
$pdf->setXY(1.0,15.8);
$pdf->MultiCell(19,0.5, iconv( 'UTF-8','cp874' , "เลขที่ดัชนี :"),0 ,'L' );

	

//ส่งสินค้า
	
$pdf->setXY(1.0,17.8);
$pdf->MultiCell(9,0.5, iconv( 'UTF-8','cp874' , "ขั้นตอนการส่งสินค้า1 :"),0 ,'L' );

$pdf->setXY(10.0,17.8);
$pdf->MultiCell(9,0.5, iconv( 'UTF-8','cp874' , "วันที่/เวลา ส่งสินค้า :"),0 ,'L' );

$pdf->setXY(1.0,20.2);
$pdf->MultiCell(19,0.5, iconv( 'UTF-8','cp874' , "สถานที่ส่งสินค้า :"),0 ,'L' );
	

$pdf->setXY(10.0,20.2);
$pdf->MultiCell(19,0.5, iconv( 'UTF-8','cp874' , "ชื่อผู้ติอต่อ :"),0 ,'L' );

$pdf->setXY(1.0,22);
$pdf->MultiCell(19,0.5, iconv( 'UTF-8','cp874' , "หมายเหตุ1 :"),0 ,'L' );

$pdf->setXY(10.0,22);
$pdf->MultiCell(19,0.5, iconv( 'UTF-8','cp874' , "ขั้นตอนการส่งสินค้า2 :"),0 ,'L' );
	
$pdf->setXY(1.0,24.4);
$pdf->MultiCell(19,0.5, iconv( 'UTF-8','cp874' , "ธนาคารที่โอนเงิน :"),0 ,'L' );	

$pdf->setXY(10.0,24.4);
$pdf->MultiCell(19,0.5, iconv( 'UTF-8','cp874' , "เอกสารที่ใช้ส่งสินค้า :"),0 ,'L' );
	



$pdf->SetFont('angsa','',14);	
	

$pdf->setXY(4.0,3.0);
$pdf->MultiCell(6,0.5, iconv( 'UTF-8','cp874' , "$time_bill"),0 ,'L' );

$pdf->setXY(12.5,3.0);
$pdf->MultiCell(6,0.5, iconv( 'UTF-8','cp874' , "$address_bill"),0 ,'L' );

$pdf->setXY(4.0,4.8);
$pdf->MultiCell(6,0.5, iconv( 'UTF-8','cp874' , "$step1"),0 ,'L' );
	

$pdf->setXY(13.0,4.8);
$pdf->MultiCell(6,0.5, iconv( 'UTF-8','cp874' , "$step2"),0 ,'L' );

$pdf->setXY(4.0,6.6);
$pdf->MultiCell(6,0.5, iconv( 'UTF-8','cp874' , "$step3"),0 ,'L' );

$pdf->setXY(13.0,6.6);
$pdf->MultiCell(6,0.5, iconv( 'UTF-8','cp874' , "$step4"),0 ,'L' );
	
$pdf->setXY(4.2,8.4);
$pdf->MultiCell(19,0.5, iconv( 'UTF-8','cp874' , "$doc_bill"),0 ,'L' );

//check	


$pdf->setXY(3.7,10.4);
$pdf->MultiCell(6,0.5, iconv( 'UTF-8','cp874' , "$time_check"),0 ,'L' );

$pdf->setXY(12.5,10.4);
$pdf->MultiCell(7,0.5, iconv( 'UTF-8','cp874' , "$address_check"),0 ,'L' );

$pdf->setXY(3.5,12.2);
$pdf->MultiCell(7,0.5, iconv( 'UTF-8','cp874' , "$doc_check"),0 ,'L' );
	

$pdf->setXY(12.4,12.2);
$pdf->MultiCell(7,0.5, iconv( 'UTF-8','cp874' , "$doc_power"),0 ,'L' );

$pdf->setXY(4.8,14.0);
$pdf->MultiCell(7,0.5, iconv( 'UTF-8','cp874' , "$time_power"),0 ,'L' );

$pdf->setXY(12.4,14.0);
$pdf->MultiCell(7,0.5, iconv( 'UTF-8','cp874' , "$count_arkon"),0 ,'L' );
	
$pdf->setXY(3.0,15.8);
$pdf->MultiCell(19,0.5, iconv( 'UTF-8','cp874' , "$index_no"),0 ,'L' );

//ส่งสินค้า

$pdf->setXY(4.2,17.8);
$pdf->MultiCell(6,0.5, iconv( 'UTF-8','cp874' , "$step_del1"),0 ,'L' );

$pdf->setXY(13.0,17.8);
$pdf->MultiCell(6,0.5, iconv( 'UTF-8','cp874' , "$time_del"),0 ,'L' );

$pdf->setXY(3.5,20.2);
$pdf->MultiCell(6,0.5, iconv( 'UTF-8','cp874' , "$adress_del"),0 ,'L' );
	

$pdf->setXY(12.0,20.2);
$pdf->MultiCell(6,0.5, iconv( 'UTF-8','cp874' , "$contact_name"),0 ,'L' );

$pdf->setXY(2.8,22);
$pdf->MultiCell(7.0,0.5, iconv( 'UTF-8','cp874' , "$remark1"),0 ,'L' );

$pdf->setXY(13.2,22);
$pdf->MultiCell(7,0.5, iconv( 'UTF-8','cp874' , "$step_del2"),0 ,'L' );
	
$pdf->setXY(4.0,24.4);
$pdf->MultiCell(6,0.5, iconv( 'UTF-8','cp874' , "$bank_tran"),0 ,'L' );	

$pdf->setXY(13.2,24.4);
$pdf->MultiCell(6,0.5, iconv( 'UTF-8','cp874' , "$doc_del"),0 ,'L' );
	


}


$pdf->Output();
?>

