<?php

define('FPDF_FONTPATH','font/');
 
require('fpdf1.php');

$ref_id=$_GET["ref_id"];

include"dbconnect.php";

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

$pdf=new FPDF( 'P' , 'cm' , 'A4' );
$pdf->AddFont('angsa','','angsa.php');
$pdf->AddFont('angsana','B','angsab.php');
$pdf->AddFont('times','','times.php');


include"dbconnect.php";

$strSQL = "SELECT * FROM hos__consig  WHERE ref_id = '".$ref_id."' ";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);

$strSQL1 = "SELECT * FROM (hos__subconsig LEFT JOIN tb_product ON hos__subconsig.product_ID=tb_product.product_id) WHERE ref_idd = '".$ref_id."'  LIMIT 11";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);


$strSQL2 = "SELECT * FROM (hos__subconsig LEFT JOIN tb_product ON hos__subconsig.product_ID=tb_product.product_id) WHERE ref_idd = '".$ref_id."'  LIMIT 15  OFFSET 11";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$Num_Rows2 = mysqli_num_rows($objQuery2);

$strSQL3 = "SELECT * FROM (hos__subconsig LEFT JOIN tb_product ON hos__subconsig.product_ID=tb_product.product_id) WHERE ref_idd = '".$ref_id."'  LIMIT 15  OFFSET 22";
$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$Num_Rows3 = mysqli_num_rows($objQuery3);


$strSQL15 = "SELECT SUM(amount) AS amount_1 FROM hos__subconsig WHERE ref_idd = '".$ref_id."'";
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResult15= mysqli_fetch_array($objQuery15);


$summary=number_format($objResult15['amount_1'],2)."";


$ref_id=$objResult["ref_id"];
$date_br = DateThai($objResult["iv_date"]);
$iv_no =$objResult["iv_no"];
$customer =$objResult["customer"];
$address =$objResult["address"];
$delivery_tel =$objResult["delivery_tel"];
$delivery_address =$objResult["delivery_address"];
$objective =$objResult["objective"]; 
$objective_des =$objResult["objective_des"]; 

$sale = $objResult["sale"];
$sale_code = $objResult["sale_code"];
$approve = $objResult["approve"];
$sale_name = "$sale / $sale_code";
$sale_comment = $objResult["sale_comment"];
$type_doc = $objResult["company"];


$approve_name = $objResult["cm_name"];

$month = date('m');
$day = date('d');
$year = date('Y');

$today1 = $year . '-' . $month . '-' . $day;
$today  = DateThai($today1);



 
$pdf->AddPage();


if($type_doc =='1'){
$pdf->SetFont('angsana','B',26);
$pdf->setXY(7.8,0.3);
$pdf->MultiCell(20, 0.6 , iconv( 'UTF-8','cp874' , "บริษัท ออลล์เวล ไลฟ์ จำกัด"),0 ,'L' );
	
$pdf->Image("img/allwell_2307.png",1.2,0.3,2.5,3.0);
	
$pdf->SetFont('angsa','',13);
$pdf->setXY(5.6,1.0);
$pdf->MultiCell(20, 0.4 , iconv( 'UTF-8','cp874' , "73, 75  ซอยจรัญสนิทวงศ์ 89/2  แขวงบางอ้อ  เขตบางพลัด  กรุงเทพมหานคร  10700"),0 ,'L' );
	
$pdf->setXY(5.6,1.4);
$pdf->MultiCell(20,0.6, iconv( 'UTF-8','cp874' , "73, 75  Soi Charansanitwong 89/2,  Bang-Or,  Bang-Plad,  Bankok  10700"),0 ,'L' );

	
$pdf->setXY(5.6,2.0);
$pdf->MultiCell(20, 0.4 , iconv( 'UTF-8','cp874' , "โทร : 0-2424-3555 (อัตโนมัติ) แฟ็กซ์ : 0-2424-3322 E-mail : Sales@AllwellLifeGroup.com"),0 ,'L' );

$pdf->Image("img/sgs.jpg",17.4,0.3,3.0,1.8);	
	
$pdf->SetFont('angsana','B',14);	
$pdf->setXY(11.5,2.3);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Cert. No. TH10/4321"),0 ,'R' );
	
$pdf->SetFont('angsana','B',22);
$pdf->setXY(9.0,2.5);
$pdf->MultiCell(20,0.6, iconv( 'UTF-8','cp874' , "ใบเบิก-จ่ายสินค้า"),0 ,'L' );

$pdf->SetFont('angsana','B',22);
$pdf->setXY(7.5,3.0);
$pdf->MultiCell(20, 0.8 , iconv( 'UTF-8','cp874' , "STOCK MOVEMENT ORDER"),0 ,'L' );	

}

if($type_doc =='2'){
	
$pdf->setXY(15.9,0.4);
$pdf->Cell(4.7,1.2,"",1,1,"c" );		
	
$pdf->SetFont('angsana','B',14);
$pdf->setXY(17.2,0.5);
$pdf->MultiCell(20, 0.6 , iconv( 'UTF-8','cp874' , "ใบเบิก-จ่ายสินค้า"),0 ,'L' );

$pdf->setXY(16.0,0.95);
$pdf->MultiCell(20, 0.6 , iconv( 'UTF-8','cp874' , "STOCK MOVEMENT OEDER"),0 ,'L' );	
	
	

$pdf->SetFont('angsana','B',26);
$pdf->setXY(8.4,0.3);
$pdf->MultiCell(20, 0.6 , iconv( 'UTF-8','cp874' , "บริษัท โนเบิล เมด จำกัด"),0 ,'L' );	
	
$pdf->setXY(8.4,1.0);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "NOBLE MED CO.,LTD"),0 ,'L' );
	

$pdf->SetFont('angsa','',13);
$pdf->setXY(6.6,1.9);
$pdf->MultiCell(20, 0.4 , iconv( 'UTF-8','cp874' , "73  ซอยจรัญสนิทวงศ์ 89/2  แขวงบางอ้อ  เขตบางพลัด  กรุงเทพมหานคร  10700"),0 ,'L' );
	
$pdf->setXY(6.6,2.2);
$pdf->MultiCell(20,0.6, iconv( 'UTF-8','cp874' , "73  Soi  Charansanitwong 89/2,  Bang-Or,  Bang-Plad,  Bankok  10700"),0 ,'L' );

	
$pdf->setXY(6.6,2.8);
$pdf->MultiCell(20, 0.4 , iconv( 'UTF-8','cp874' , "TEL : 0-2880-5566  FAX : 0-2880-5533 "),0 ,'L' );

$pdf->Image("img/nbm_select.png",1.1,0.3,4.0,2.0);

}


	
$pdf->setXY(1.1,3.8);
$pdf->Cell(10.5,3.2, "",1,1,"c" );

$pdf->setXY(11.6,3.8);
$pdf->Cell(4.5,1.0, "",1,1,"c" );

$pdf->setXY(16.1,3.8);
$pdf->Cell(4.5,1.0, "",1,1,"c" );

$pdf->setXY(11.6,4.8);
$pdf->Cell(9,2.2, "",1,1,"c" );	

	
/*$pdf->setXY(16.0,6.6);
$pdf->Cell(4.5,1.0, "",1,1,"c" );*/
	
$pdf->SetFont('angsa','',14); 

$pdf->setXY(1.3,4.0);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "ชื่อลูกค้า"),0 ,'L' );
$pdf->setXY(1.3,4.3);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "Customer Name"),0 ,'L' );

$pdf->SetFont('angsana','B',14);
$pdf->setXY(3.6,3.9);
$pdf->MultiCell(8, 0.5, iconv( 'UTF-8//IGNORE','cp874//IGNORE' , "$customer"),0 ,'L' );

$pdf->SetFont('angsa','',14); 
	
$pdf->setXY(1.3,5.0);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "ที่อยู่"),0 ,'L' );
$pdf->setXY(1.3,5.3);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Address"),0 ,'L' );

$pdf->setXY(2.7,5.0);
$pdf->MultiCell(9,0.5, iconv( 'UTF-8','cp874' , "$address"),0 ,'L' );
	
$pdf->setXY(1.3,6.0);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "เบอร์โทรศัพท์"),0 ,'L' );
$pdf->setXY(1.3,6.3);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Telephone"),0 ,'L' );

$pdf->setXY(4.0,6.2);
$pdf->MultiCell(7.0, 0.6 , iconv( 'UTF-8','cp874' , "$delivery_tel"),0 ,'L' );
	
$pdf->setXY(11.8,3.9);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "วันที่"),0 ,'L' );
$pdf->setXY(11.8,4.2);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Date"),0 ,'L' );

$pdf->setXY(13.9,4.0);
$pdf->MultiCell(14.0,0.6, iconv( 'UTF-8','cp874' , "$date_br"),0 ,'L' );


$pdf->setXY(16.8,3.95);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "เลขที่"),0 ,'L' );
$pdf->setXY(16.8,4.25);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "No."),0 ,'L' );	

$pdf->SetFont('angsana','B',17);

$pdf->setXY(17.8,3.95);
$pdf->MultiCell(14.0,0.6, iconv( 'UTF-8','cp874' , "$iv_no"),0 ,'L' );


$pdf->SetFont('angsa','',14); 
	
$pdf->setXY(11.8,4.9);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "สถานที่ส่งสินค้า"),0 ,'L' );
$pdf->setXY(11.8,5.2);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Ship To"),0 ,'L' );

$pdf->setXY(13.3,5.4);
$pdf->MultiCell(8.0,0.5, iconv( 'UTF-8','cp874' , "$delivery_address"),0 ,'L' );
	
	
$pdf->setXY(1.1,7.1);
$pdf->Cell(1.0,1.0, "",1,1,"c" );

$pdf->setXY(2.1,7.1);
$pdf->Cell(3.0,1.0, "",1,1,"c" );

$pdf->setXY(5.1,7.1);
$pdf->Cell(8.5,1.0, "",1,1,"c" );

$pdf->setXY(13.6,7.1);
$pdf->Cell(2.0,1.0, "",1,1,"c" );

$pdf->setXY(15.6,7.1);
$pdf->Cell(2.5,1.0, "",1,1,"c" );

$pdf->setXY(18.1,7.1);
$pdf->Cell(2.5,1.0, "",1,1,"c" );

$pdf->SetFont('angsa','',14); 

$pdf->setXY(1.2,7.1);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "ลำดับ"),0 ,'L' );
$pdf->setXY(1.25,7.4);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Item"),0 ,'L' );

$pdf->setXY(2.8,7.1);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "รหัสสินค้า"),0 ,'L' );
$pdf->setXY(2.7,7.4);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Product Code"),0 ,'L' );

$pdf->setXY(8.4,7.1);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "รายละเอียดสินค้า"),0 ,'L' );
$pdf->setXY(8.7,7.4);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Description"),0 ,'L' );

$pdf->setXY(14.1,7.1);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "จำนวน"),0 ,'L' );
$pdf->setXY(14.3,7.4);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Qty."),0 ,'L' );

$pdf->setXY(15.9,7.1);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "ราคาต่อหน่วย"),0 ,'L' );
$pdf->setXY(16.1,7.4);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Price/Unit"),0 ,'L' );

$pdf->setXY(18.6,7.1);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "จำนวนเงิน"),0 ,'L' );
$pdf->setXY(18.8,7.4);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Amount"),0 ,'L' );


$pdf->setX(17.3);
$pdf->MultiCell( 9.0,0.5, iconv( 'UTF-8','cp874' , ""),0 ,'L' );

$pdf->SetFont('angsa','',11); 
$i=1;
while($objResult1 = mysqli_fetch_array($objQuery1))
{

$sum_amount1  =$objResult1["amount"];

$sum_amount = number_format( $sum_amount1,2)."";

$price_per_unit_1  =$objResult1["price"];
$price_per_unit= number_format( $price_per_unit_1,2)."";

$product_code1  =$objResult1["access_code"];
$product_code = substr($product_code1,0,12);	
$product_name  =$objResult1["sol_name"];
//$product_name = substr($product_name1,0,40);

$sale_count  = number_format($objResult1["count"],0)."";


$unit_name  =$objResult1["unit_name"];
$sale_remark = $objResult1["sale_remark"];
$sn = $objResult1["sn"];


$pdf->setX(1.35);
$pdf->MultiCell( 9.0,0, iconv( 'UTF-8','cp874' , "$i"),0 ,'L' );


$pdf->setX(2.15);
$pdf->MultiCell( 9.0,0, iconv( 'UTF-8','cp874' , "$product_code"),0 ,'L' );

$pdf->setX(5.3);
$pdf->Cell(10,0.0, iconv( 'UTF-8','cp874' , "$product_name"),0 ,'L' );

$pdf->setX(13.5);
$pdf->MultiCell(1.9,0, iconv( 'UTF-8','cp874' , "$sale_count $unit_name"),0 ,'R' );

$pdf->setX(15.95);
$pdf->MultiCell(2.0,0, iconv( 'UTF-8','cp874' , "$price_per_unit"),0 ,'R' );


$pdf->setX(18.55);
$pdf->MultiCell(2.0,0, iconv( 'UTF-8','cp874' , "$sum_amount"),0 ,'R' );

$pdf->setX(18.9);
$pdf->MultiCell( 9.0,0.5, iconv( 'UTF-8','cp874' , ""),0 ,'L' );

if($sale_remark!=''){
$pdf->setX(5.3);
$pdf->Cell(10,0.0, iconv( 'UTF-8','cp874' , "$sale_remark"),0 ,'L' );
	
$pdf->setX(18.9);
$pdf->MultiCell( 9.0,0.5, iconv( 'UTF-8','cp874' , ""),0 ,'L' );
}	
	
if($sn!=''){	
$pdf->SetFont('angsa','',11); 
$str_arr = explode("\n",$sn);

foreach ($str_arr as $test =>$value){
$product_sn = $str_arr[$test];
$product_sn1 =  trim($product_sn);	
if($product_sn1!=''){
	
$pdf->setX(5.3);
$pdf->Cell(10,0.0, iconv( 'UTF-8','cp874' , "SN : $product_sn1"),0 ,'L' );
	
$pdf->setX(18.9);
$pdf->MultiCell( 9.0,0.35, iconv( 'UTF-8','cp874' , ""),0 ,'L' );
}	
}	
}

$i++;


}

$pdf->setXY(1.1,8.1);
$pdf->Cell(1.0,11.0, "",1,1,"c" );

$pdf->setXY(2.1,8.1);
$pdf->Cell(3.0,11.0, "",1,1,"c" );

$pdf->setXY(5.1,8.1);
$pdf->Cell(8.5,11.0, "",1,1,"c" );

$pdf->setXY(13.6,8.1);
$pdf->Cell(2.0,11.0, "",1,1,"c" );

$pdf->setXY(15.6,8.1);
$pdf->Cell(2.5,11.0, "",1,1,"c" );

$pdf->setXY(18.1,8.1);
$pdf->Cell(2.5,11.0, "",1,1,"c" );


///
$pdf->setXY(1.1,19.1);
$pdf->Cell(4.0,1.2, "",1,1,"c" );

$pdf->setXY(5.1,19.1);
$pdf->Cell(13.0,1.2, "",1,1,"c" );

$pdf->setXY(18.1,19.1);
$pdf->Cell(2.5,1.2, "",1,1,"c" );

$pdf->setXY(1.2,19.25);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "รวมทั้งสิ้น"),0 ,'L' );
$pdf->setXY(1.25,19.75);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Total Amount"),0 ,'L' );

if($Num_Rows2 > 0){
$pdf->setXY(18.5,19.75);
$pdf->MultiCell(2.0,0, iconv( 'UTF-8','cp874' , ""),0 ,'R' );
}else{
$pdf->setXY(18.5,19.75);
$pdf->MultiCell(2.0,0, iconv( 'UTF-8','cp874' , "$summary"),0 ,'R' );
	
}



$pdf->setXY(1.1,20.35);
$pdf->Cell(9.75,2.0, "",1,1,"c" );

$pdf->SetFont('angsa','',14); 

$pdf->setXY(1.3,20.9);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "ผู้เบิกสินค้า"),0 ,'L' );
$pdf->setXY(1.3,21.25);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "Requested by"),0 ,'L' );

$pdf->setXY(3.5,20.7);
//$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "$sale"),0 ,'L' );

$pdf->setXY(2.8,20.93);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "........................................................."),0 ,'L' );

$pdf->setXY(7.5,20.9);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "วันที่"),0 ,'L' );
$pdf->setXY(7.5,21.25);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "Date"),0 ,'L' );

$pdf->setXY(8.15,20.93);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "................................."),0 ,'L' );

$pdf->setXY(8.8,20.7);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "$today"),0 ,'L' );


$pdf->setXY(3.4,21.5);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "$sale / $sale_code"),0 ,'L' );

$pdf->setXY(2.8,21.7);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "(.........................................................)"),0 ,'L' );



$pdf->setXY(1.1,22.35);
$pdf->Cell(9.75,2.5, "",1,1,"c" );

$pdf->SetFont('angsana','B',12);
$pdf->setXY(1.8,22.4);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "ได้รับสินค้าตามรายการข้างบนนี้ ในสภาพเรียบร้อย และถูกต้องแล้ว"),0 ,'L' );

$pdf->SetFont('angsa','',14); 

$pdf->setXY(1.3,23.1);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "รับของโดย"),0 ,'L' );
$pdf->setXY(1.3,23.5);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "Received by"),0 ,'L' );


$pdf->setXY(2.8,23.18);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "........................................................."),0 ,'L' );

$pdf->setXY(7.5,23.15);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "วันที่"),0 ,'L' );
$pdf->setXY(7.5,23.9);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "Date"),0 ,'L' );

$pdf->setXY(8.15,23.28);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "................................"),0 ,'L' );


$pdf->setXY(2.8,23.85);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "(.........................................................)"),0 ,'L' );



$pdf->setXY(1.1,24.85);
$pdf->Cell(9.75,1.8, "",1,1,"c" );


$pdf->SetFont('angsa','',14); 

$pdf->setXY(1.3,25.35);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "ผู้อนุมัติ"),0 ,'L' );
$pdf->setXY(1.3,25.75);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "Authorized by"),0 ,'L' );

$pdf->setXY(3.8,25.2);
//$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "$approve_name"),0 ,'L' );

$pdf->setXY(2.8,25.43);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "........................................................."),0 ,'L' );

$pdf->setXY(7.5,25.4);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "วันที่"),0 ,'L' );
$pdf->setXY(7.5,25.75);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "Date"),0 ,'L' );

$pdf->setXY(8.15,25.73);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "................................"),0 ,'L' );

$pdf->setXY(8.8,25.6);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "$today"),0 ,'L' );


$pdf->setXY(3.8,26.0);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "$approve_name"),0 ,'L' );

$pdf->setXY(2.8,26.2);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "(.........................................................)"),0 ,'L' );



$pdf->setXY(10.85,20.35);
$pdf->Cell(9.75,2.0, "",1,1,"c" );


$pdf->setXY(10.85,20.5);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "วัตถุประสงค์การเบิก"),0 ,'L' );
$pdf->setXY(10.85,20.9);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "Purpose"),0 ,'L' );

if ($objective=='1'){

$pdf->setXY(14.1,20.6);
$pdf->MultiCell(7.0,0.6, iconv( 'UTF-8','cp874' , "สินค้าฝากขาย (มีใบรับประกัน) $objective_des"),0 ,'L' );


}




$pdf->setXY(10.85,22.35);
$pdf->Cell(9.75,2.5, "",1,1,"c" );


$pdf->SetFont('angsa','',14); 

$pdf->setXY(10.85,22.55);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "คลังสินค้า"),0 ,'L' );
$pdf->setXY(10.85,22.95);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "Stock"),0 ,'L' );


$pdf->setXY(12.65,22.65);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "........................................................."),0 ,'L' );

$pdf->setXY(17.5,22.55);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "วันที่"),0 ,'L' );
$pdf->setXY(17.5,22.95);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "Date"),0 ,'L' );

$pdf->setXY(18.15,22.65);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , ".............................."),0 ,'L' );


$pdf->setXY(12.6,23.25);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "(.........................................................)"),0 ,'L' );


$pdf->setXY(11.3,23.85);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "จัดส่งโดย"),0 ,'L' );
$pdf->setXY(11.3,24.15);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "Delivery by"),0 ,'L' );


$pdf->setXY(12.65,23.95);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "........................................................."),0 ,'L' );

$pdf->setXY(17.5,23.85);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "วันที่"),0 ,'L' );
$pdf->setXY(17.5,24.15);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "Date"),0 ,'L' );

$pdf->setXY(18.15,23.95);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , ".............................."),0 ,'L' );


$pdf->setXY(12.6,24.50);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "(.........................................................)"),0 ,'L' );





$pdf->setXY(10.85,24.85);
$pdf->Cell(9.75,1.8, "",1,1,"c" );

$pdf->setXY(10.85,25.0);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "หมายเหตุ"),0 ,'L' );
$pdf->setXY(10.85,25.4);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "Remarks"),0 ,'L' );




if($type_doc =='1'){
$pdf->SetFont('angsa','',11); 

$pdf->setXY(1.15,26.6);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "อนุมัติวันที่ 1 ก.พ.2564"),0 ,'L' );

$pdf->setXY(11.5,26.6);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "FM-SA-25:Rev.5"),0 ,'R' );
}
if($type_doc =='2'){
$pdf->SetFont('angsa','',11); 

$pdf->setXY(1.15,26.6);
//$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "อนุมัติวันที่ 04 ก.ค.2567"),0 ,'L' );

$pdf->setXY(11.5,26.6);
//$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "040767:Rev.0"),0 ,'R' );
}


if($Num_Rows2 > 0){
$pdf->AddPage();


if($type_doc =='1'){
$pdf->SetFont('angsana','B',26);
$pdf->setXY(7.8,0.3);
$pdf->MultiCell(20, 0.6 , iconv( 'UTF-8','cp874' , "บริษัท ออลล์เวล ไลฟ์ จำกัด"),0 ,'L' );
	
$pdf->Image("img/allwell_2307.png",1.2,0.3,2.5,3.0);
	
$pdf->SetFont('angsa','',13);
$pdf->setXY(5.6,1.0);
$pdf->MultiCell(20, 0.4 , iconv( 'UTF-8','cp874' , "73, 75  ซอยจรัญสนิทวงศ์ 89/2  แขวงบางอ้อ  เขตบางพลัด  กรุงเทพมหานคร  10700"),0 ,'L' );
	
$pdf->setXY(5.6,1.4);
$pdf->MultiCell(20,0.6, iconv( 'UTF-8','cp874' , "73, 75  Soi Charansanitwong 89/2,  Bang-Or,  Bang-Plad,  Bankok  10700"),0 ,'L' );

	
$pdf->setXY(5.6,2.0);
$pdf->MultiCell(20, 0.4 , iconv( 'UTF-8','cp874' , "โทร : 0-2424-3555 (อัตโนมัติ) แฟ็กซ์ : 0-2424-3322 E-mail : Sales@AllwellLifeGroup.com"),0 ,'L' );

$pdf->Image("img/sgs.jpg",17.4,0.3,3.0,1.8);	
	
$pdf->SetFont('angsana','B',14);	
$pdf->setXY(11.5,2.3);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Cert. No. TH10/4321"),0 ,'R' );
	
$pdf->SetFont('angsana','B',22);
$pdf->setXY(9.0,2.5);
$pdf->MultiCell(20,0.6, iconv( 'UTF-8','cp874' , "ใบเบิก-จ่ายสินค้า"),0 ,'L' );

$pdf->SetFont('angsana','B',22);
$pdf->setXY(7.5,3.0);
$pdf->MultiCell(20, 0.8 , iconv( 'UTF-8','cp874' , "STOCK MOVEMENT ORDER"),0 ,'L' );	

}

if($type_doc =='2'){
	
$pdf->setXY(15.9,0.4);
$pdf->Cell(4.7,1.2,"",1,1,"c" );		
	
$pdf->SetFont('angsana','B',14);
$pdf->setXY(17.2,0.5);
$pdf->MultiCell(20, 0.6 , iconv( 'UTF-8','cp874' , "ใบเบิก-จ่ายสินค้า"),0 ,'L' );

$pdf->setXY(16.0,0.95);
$pdf->MultiCell(20, 0.6 , iconv( 'UTF-8','cp874' , "STOCK MOVEMENT OEDER"),0 ,'L' );	
	
	

$pdf->SetFont('angsana','B',26);
$pdf->setXY(8.4,0.3);
$pdf->MultiCell(20, 0.6 , iconv( 'UTF-8','cp874' , "บริษัท โนเบิล เมด จำกัด"),0 ,'L' );	
	
$pdf->setXY(8.4,1.0);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "NOBLE MED CO.,LTD"),0 ,'L' );
	

$pdf->SetFont('angsa','',13);
$pdf->setXY(6.6,1.9);
$pdf->MultiCell(20, 0.4 , iconv( 'UTF-8','cp874' , "73  ซอยจรัญสนิทวงศ์ 89/2  แขวงบางอ้อ  เขตบางพลัด  กรุงเทพมหานคร  10700"),0 ,'L' );
	
$pdf->setXY(6.6,2.2);
$pdf->MultiCell(20,0.6, iconv( 'UTF-8','cp874' , "73  Soi  Charansanitwong 89/2,  Bang-Or,  Bang-Plad,  Bankok  10700"),0 ,'L' );

	
$pdf->setXY(6.6,2.8);
$pdf->MultiCell(20, 0.4 , iconv( 'UTF-8','cp874' , "TEL : 0-2880-5566  FAX : 0-2880-5533 "),0 ,'L' );

$pdf->Image("img/nbm_select.png",1.1,0.3,4.0,2.0);

}


	
$pdf->setXY(1.1,3.8);
$pdf->Cell(10.5,3.2, "",1,1,"c" );

$pdf->setXY(11.6,3.8);
$pdf->Cell(4.5,1.0, "",1,1,"c" );

$pdf->setXY(16.1,3.8);
$pdf->Cell(4.5,1.0, "",1,1,"c" );

$pdf->setXY(11.6,4.8);
$pdf->Cell(9,2.2, "",1,1,"c" );	

	
/*$pdf->setXY(16.0,6.6);
$pdf->Cell(4.5,1.0, "",1,1,"c" );*/
	
$pdf->SetFont('angsa','',14); 

$pdf->setXY(1.3,4.0);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "ชื่อลูกค้า"),0 ,'L' );
$pdf->setXY(1.3,4.3);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "Customer Name"),0 ,'L' );

$pdf->SetFont('angsana','B',14);
$pdf->setXY(3.6,3.9);
$pdf->MultiCell(8, 0.5, iconv( 'UTF-8//IGNORE','cp874//IGNORE' , "$customer"),0 ,'L' );

$pdf->SetFont('angsa','',14); 
	
$pdf->setXY(1.3,5.0);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "ที่อยู่"),0 ,'L' );
$pdf->setXY(1.3,5.3);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Address"),0 ,'L' );

$pdf->setXY(2.7,5.0);
$pdf->MultiCell(9,0.5, iconv( 'UTF-8','cp874' , "$address"),0 ,'L' );
	
$pdf->setXY(1.3,6.0);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "เบอร์โทรศัพท์"),0 ,'L' );
$pdf->setXY(1.3,6.3);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Telephone"),0 ,'L' );

$pdf->setXY(4.0,6.2);
$pdf->MultiCell(7.0, 0.6 , iconv( 'UTF-8','cp874' , "$delivery_tel"),0 ,'L' );
	
$pdf->setXY(11.8,3.9);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "วันที่"),0 ,'L' );
$pdf->setXY(11.8,4.2);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Date"),0 ,'L' );

$pdf->setXY(13.9,4.0);
$pdf->MultiCell(14.0,0.6, iconv( 'UTF-8','cp874' , "$date_br"),0 ,'L' );


$pdf->setXY(16.8,3.95);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "เลขที่"),0 ,'L' );
$pdf->setXY(16.8,4.25);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "No."),0 ,'L' );	

$pdf->SetFont('angsana','B',17);

$pdf->setXY(17.8,3.95);
$pdf->MultiCell(14.0,0.6, iconv( 'UTF-8','cp874' , "$iv_no"),0 ,'L' );


$pdf->SetFont('angsa','',14); 
	
$pdf->setXY(11.8,4.9);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "สถานที่ส่งสินค้า"),0 ,'L' );
$pdf->setXY(11.8,5.2);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Ship To"),0 ,'L' );

$pdf->setXY(13.3,5.4);
$pdf->MultiCell(8.0,0.5, iconv( 'UTF-8','cp874' , "$delivery_address"),0 ,'L' );
	
	
$pdf->setXY(1.1,7.1);
$pdf->Cell(1.0,1.0, "",1,1,"c" );

$pdf->setXY(2.1,7.1);
$pdf->Cell(3.0,1.0, "",1,1,"c" );

$pdf->setXY(5.1,7.1);
$pdf->Cell(8.5,1.0, "",1,1,"c" );

$pdf->setXY(13.6,7.1);
$pdf->Cell(2.0,1.0, "",1,1,"c" );

$pdf->setXY(15.6,7.1);
$pdf->Cell(2.5,1.0, "",1,1,"c" );

$pdf->setXY(18.1,7.1);
$pdf->Cell(2.5,1.0, "",1,1,"c" );

$pdf->SetFont('angsa','',14); 

$pdf->setXY(1.2,7.1);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "ลำดับ"),0 ,'L' );
$pdf->setXY(1.25,7.4);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Item"),0 ,'L' );

$pdf->setXY(2.8,7.1);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "รหัสสินค้า"),0 ,'L' );
$pdf->setXY(2.7,7.4);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Product Code"),0 ,'L' );

$pdf->setXY(8.4,7.1);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "รายละเอียดสินค้า"),0 ,'L' );
$pdf->setXY(8.7,7.4);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Description"),0 ,'L' );

$pdf->setXY(14.1,7.1);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "จำนวน"),0 ,'L' );
$pdf->setXY(14.3,7.4);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Qty."),0 ,'L' );

$pdf->setXY(15.9,7.1);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "ราคาต่อหน่วย"),0 ,'L' );
$pdf->setXY(16.1,7.4);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Price/Unit"),0 ,'L' );

$pdf->setXY(18.6,7.1);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "จำนวนเงิน"),0 ,'L' );
$pdf->setXY(18.8,7.4);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Amount"),0 ,'L' );


$pdf->setX(17.3);
$pdf->MultiCell( 9.0,0.5, iconv( 'UTF-8','cp874' , ""),0 ,'L' );

$pdf->SetFont('angsa','',11); 
$i=12;
while($objResult2 = mysqli_fetch_array($objQuery2))
{

$sum_amount1  =$objResult2["amount"];

$sum_amount = number_format( $sum_amount1,2)."";

$price_per_unit_1  =$objResult2["price"];
$price_per_unit= number_format( $price_per_unit_1,2)."";

$product_code1  =$objResult2["access_code"];
$product_code = substr($product_code1,0,12);	
$product_name  =$objResult2["sol_name"];
//$product_name = substr($product_name1,0,40);

$sale_count  = number_format($objResult2["count"],0)."";


$unit_name  =$objResult2["unit_name"];
$sale_remark = $objResult2["sale_remark"];
$sn = $objResult2["sn"];


$pdf->setX(1.35);
$pdf->MultiCell( 9.0,0, iconv( 'UTF-8','cp874' , "$i"),0 ,'L' );


$pdf->setX(2.15);
$pdf->MultiCell( 9.0,0, iconv( 'UTF-8','cp874' , "$product_code"),0 ,'L' );

$pdf->setX(5.3);
$pdf->Cell(10,0.0, iconv( 'UTF-8','cp874' , "$product_name"),0 ,'L' );

$pdf->setX(13.5);
$pdf->MultiCell(1.9,0, iconv( 'UTF-8','cp874' , "$sale_count $unit_name"),0 ,'R' );

$pdf->setX(15.95);
$pdf->MultiCell(2.0,0, iconv( 'UTF-8','cp874' , "$price_per_unit"),0 ,'R' );


$pdf->setX(18.55);
$pdf->MultiCell(2.0,0, iconv( 'UTF-8','cp874' , "$sum_amount"),0 ,'R' );

$pdf->setX(18.9);
$pdf->MultiCell( 9.0,0.5, iconv( 'UTF-8','cp874' , ""),0 ,'L' );

if($sale_remark!=''){
$pdf->setX(5.3);
$pdf->Cell(10,0.0, iconv( 'UTF-8','cp874' , "$sale_remark"),0 ,'L' );
	
$pdf->setX(18.9);
$pdf->MultiCell( 9.0,0.5, iconv( 'UTF-8','cp874' , ""),0 ,'L' );
}	
	
if($sn!=''){	
$pdf->SetFont('angsa','',11); 
$str_arr = explode("\n",$sn);

foreach ($str_arr as $test =>$value){
$product_sn = $str_arr[$test];
$product_sn1 =  trim($product_sn);	
if($product_sn1!=''){
	
$pdf->setX(5.3);
$pdf->Cell(10,0.0, iconv( 'UTF-8','cp874' , "SN : $product_sn1"),0 ,'L' );
	
$pdf->setX(18.9);
$pdf->MultiCell( 9.0,0.35, iconv( 'UTF-8','cp874' , ""),0 ,'L' );
}	
}	
}

$i++;


}

$pdf->setXY(1.1,8.1);
$pdf->Cell(1.0,11.0, "",1,1,"c" );

$pdf->setXY(2.1,8.1);
$pdf->Cell(3.0,11.0, "",1,1,"c" );

$pdf->setXY(5.1,8.1);
$pdf->Cell(8.5,11.0, "",1,1,"c" );

$pdf->setXY(13.6,8.1);
$pdf->Cell(2.0,11.0, "",1,1,"c" );

$pdf->setXY(15.6,8.1);
$pdf->Cell(2.5,11.0, "",1,1,"c" );

$pdf->setXY(18.1,8.1);
$pdf->Cell(2.5,11.0, "",1,1,"c" );


///
$pdf->setXY(1.1,19.1);
$pdf->Cell(4.0,1.2, "",1,1,"c" );

$pdf->setXY(5.1,19.1);
$pdf->Cell(13.0,1.2, "",1,1,"c" );

$pdf->setXY(18.1,19.1);
$pdf->Cell(2.5,1.2, "",1,1,"c" );

$pdf->setXY(1.2,19.25);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "รวมทั้งสิ้น"),0 ,'L' );
$pdf->setXY(1.25,19.75);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Total Amount"),0 ,'L' );

if($Num_Rows3 > 0){
$pdf->setXY(18.5,19.75);
$pdf->MultiCell(2.0,0, iconv( 'UTF-8','cp874' , ""),0 ,'R' );
}else{
$pdf->setXY(18.5,19.75);
$pdf->MultiCell(2.0,0, iconv( 'UTF-8','cp874' , "$summary"),0 ,'R' );
	
}




$pdf->setXY(1.1,20.35);
$pdf->Cell(9.75,2.0, "",1,1,"c" );

$pdf->SetFont('angsa','',14); 

$pdf->setXY(1.3,20.9);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "ผู้เบิกสินค้า"),0 ,'L' );
$pdf->setXY(1.3,21.25);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "Requested by"),0 ,'L' );

$pdf->setXY(3.5,20.7);
//$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "$sale"),0 ,'L' );

$pdf->setXY(2.8,20.93);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "........................................................."),0 ,'L' );

$pdf->setXY(7.5,20.9);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "วันที่"),0 ,'L' );
$pdf->setXY(7.5,21.25);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "Date"),0 ,'L' );

$pdf->setXY(8.15,20.93);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "................................."),0 ,'L' );

$pdf->setXY(8.8,20.7);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "$today"),0 ,'L' );


$pdf->setXY(3.4,21.5);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "$sale / $sale_code"),0 ,'L' );

$pdf->setXY(2.8,21.7);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "(.........................................................)"),0 ,'L' );



$pdf->setXY(1.1,22.35);
$pdf->Cell(9.75,2.5, "",1,1,"c" );

$pdf->SetFont('angsana','B',12);
$pdf->setXY(1.8,22.4);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "ได้รับสินค้าตามรายการข้างบนนี้ ในสภาพเรียบร้อย และถูกต้องแล้ว"),0 ,'L' );

$pdf->SetFont('angsa','',14); 

$pdf->setXY(1.3,23.1);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "รับของโดย"),0 ,'L' );
$pdf->setXY(1.3,23.5);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "Received by"),0 ,'L' );


$pdf->setXY(2.8,23.18);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "........................................................."),0 ,'L' );

$pdf->setXY(7.5,23.15);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "วันที่"),0 ,'L' );
$pdf->setXY(7.5,23.9);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "Date"),0 ,'L' );

$pdf->setXY(8.15,23.28);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "................................"),0 ,'L' );


$pdf->setXY(2.8,23.85);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "(.........................................................)"),0 ,'L' );



$pdf->setXY(1.1,24.85);
$pdf->Cell(9.75,1.8, "",1,1,"c" );


$pdf->SetFont('angsa','',14); 

$pdf->setXY(1.3,25.35);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "ผู้อนุมัติ"),0 ,'L' );
$pdf->setXY(1.3,25.75);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "Authorized by"),0 ,'L' );

$pdf->setXY(3.8,25.2);
//$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "$approve_name"),0 ,'L' );

$pdf->setXY(2.8,25.43);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "........................................................."),0 ,'L' );

$pdf->setXY(7.5,25.4);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "วันที่"),0 ,'L' );
$pdf->setXY(7.5,25.75);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "Date"),0 ,'L' );

$pdf->setXY(8.15,25.73);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "................................"),0 ,'L' );

$pdf->setXY(8.8,25.6);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "$today"),0 ,'L' );


$pdf->setXY(3.8,26.0);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "$approve_name"),0 ,'L' );

$pdf->setXY(2.8,26.2);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "(.........................................................)"),0 ,'L' );



$pdf->setXY(10.85,20.35);
$pdf->Cell(9.75,2.0, "",1,1,"c" );


$pdf->setXY(10.85,20.5);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "วัตถุประสงค์การเบิก"),0 ,'L' );
$pdf->setXY(10.85,20.9);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "Purpose"),0 ,'L' );

if ($objective=='1'){

$pdf->setXY(14.1,20.6);
$pdf->MultiCell(7.0,0.6, iconv( 'UTF-8','cp874' , "สินค้าฝากขาย (มีใบรับประกัน) $objective_des"),0 ,'L' );


}




$pdf->setXY(10.85,22.35);
$pdf->Cell(9.75,2.5, "",1,1,"c" );


$pdf->SetFont('angsa','',14); 

$pdf->setXY(10.85,22.55);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "คลังสินค้า"),0 ,'L' );
$pdf->setXY(10.85,22.95);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "Stock"),0 ,'L' );


$pdf->setXY(12.65,22.65);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "........................................................."),0 ,'L' );

$pdf->setXY(17.5,22.55);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "วันที่"),0 ,'L' );
$pdf->setXY(17.5,22.95);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "Date"),0 ,'L' );

$pdf->setXY(18.15,22.65);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , ".............................."),0 ,'L' );


$pdf->setXY(12.6,23.25);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "(.........................................................)"),0 ,'L' );


$pdf->setXY(11.3,23.85);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "จัดส่งโดย"),0 ,'L' );
$pdf->setXY(11.3,24.15);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "Delivery by"),0 ,'L' );


$pdf->setXY(12.65,23.95);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "........................................................."),0 ,'L' );

$pdf->setXY(17.5,23.85);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "วันที่"),0 ,'L' );
$pdf->setXY(17.5,24.15);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "Date"),0 ,'L' );

$pdf->setXY(18.15,23.95);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , ".............................."),0 ,'L' );


$pdf->setXY(12.6,24.50);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "(.........................................................)"),0 ,'L' );





$pdf->setXY(10.85,24.85);
$pdf->Cell(9.75,1.8, "",1,1,"c" );

$pdf->setXY(10.85,25.0);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "หมายเหตุ"),0 ,'L' );
$pdf->setXY(10.85,25.4);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "Remarks"),0 ,'L' );




if($type_doc =='1'){
$pdf->SetFont('angsa','',11); 

$pdf->setXY(1.15,26.6);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "อนุมัติวันที่ 1 ก.พ.2564"),0 ,'L' );

$pdf->setXY(11.5,26.6);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "FM-SA-25:Rev.5"),0 ,'R' );
}
if($type_doc =='2'){
$pdf->SetFont('angsa','',11); 

$pdf->setXY(1.15,26.6);
//$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "อนุมัติวันที่ 04 ก.ค.2567"),0 ,'L' );

$pdf->setXY(11.5,26.6);
//$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "040767:Rev.0"),0 ,'R' );
}

}


if($Num_Rows3 > 0){
$pdf->AddPage();


if($type_doc =='1'){
$pdf->SetFont('angsana','B',26);
$pdf->setXY(7.8,0.3);
$pdf->MultiCell(20, 0.6 , iconv( 'UTF-8','cp874' , "บริษัท ออลล์เวล ไลฟ์ จำกัด"),0 ,'L' );
	
$pdf->Image("img/allwell_2307.png",1.2,0.3,2.5,3.0);
	
$pdf->SetFont('angsa','',13);
$pdf->setXY(5.6,1.0);
$pdf->MultiCell(20, 0.4 , iconv( 'UTF-8','cp874' , "73, 75  ซอยจรัญสนิทวงศ์ 89/2  แขวงบางอ้อ  เขตบางพลัด  กรุงเทพมหานคร  10700"),0 ,'L' );
	
$pdf->setXY(5.6,1.4);
$pdf->MultiCell(20,0.6, iconv( 'UTF-8','cp874' , "73, 75  Soi Charansanitwong 89/2,  Bang-Or,  Bang-Plad,  Bankok  10700"),0 ,'L' );

	
$pdf->setXY(5.6,2.0);
$pdf->MultiCell(20, 0.4 , iconv( 'UTF-8','cp874' , "โทร : 0-2424-3555 (อัตโนมัติ) แฟ็กซ์ : 0-2424-3322 E-mail : Sales@AllwellLifeGroup.com"),0 ,'L' );

$pdf->Image("img/sgs.jpg",17.4,0.3,3.0,1.8);	
	
$pdf->SetFont('angsana','B',14);	
$pdf->setXY(11.5,2.3);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Cert. No. TH10/4321"),0 ,'R' );
	
$pdf->SetFont('angsana','B',22);
$pdf->setXY(9.0,2.5);
$pdf->MultiCell(20,0.6, iconv( 'UTF-8','cp874' , "ใบเบิก-จ่ายสินค้า"),0 ,'L' );

$pdf->SetFont('angsana','B',22);
$pdf->setXY(7.5,3.0);
$pdf->MultiCell(20, 0.8 , iconv( 'UTF-8','cp874' , "STOCK MOVEMENT ORDER"),0 ,'L' );	

}

if($type_doc =='2'){
	
$pdf->setXY(15.9,0.4);
$pdf->Cell(4.7,1.2,"",1,1,"c" );		
	
$pdf->SetFont('angsana','B',14);
$pdf->setXY(17.2,0.5);
$pdf->MultiCell(20, 0.6 , iconv( 'UTF-8','cp874' , "ใบเบิก-จ่ายสินค้า"),0 ,'L' );

$pdf->setXY(16.0,0.95);
$pdf->MultiCell(20, 0.6 , iconv( 'UTF-8','cp874' , "STOCK MOVEMENT OEDER"),0 ,'L' );	
	
	

$pdf->SetFont('angsana','B',26);
$pdf->setXY(8.4,0.3);
$pdf->MultiCell(20, 0.6 , iconv( 'UTF-8','cp874' , "บริษัท โนเบิล เมด จำกัด"),0 ,'L' );	
	
$pdf->setXY(8.4,1.0);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "NOBLE MED CO.,LTD"),0 ,'L' );
	

$pdf->SetFont('angsa','',13);
$pdf->setXY(6.6,1.9);
$pdf->MultiCell(20, 0.4 , iconv( 'UTF-8','cp874' , "73  ซอยจรัญสนิทวงศ์ 89/2  แขวงบางอ้อ  เขตบางพลัด  กรุงเทพมหานคร  10700"),0 ,'L' );
	
$pdf->setXY(6.6,2.2);
$pdf->MultiCell(20,0.6, iconv( 'UTF-8','cp874' , "73  Soi  Charansanitwong 89/2,  Bang-Or,  Bang-Plad,  Bankok  10700"),0 ,'L' );

	
$pdf->setXY(6.6,2.8);
$pdf->MultiCell(20, 0.4 , iconv( 'UTF-8','cp874' , "TEL : 0-2880-5566  FAX : 0-2880-5533 "),0 ,'L' );

$pdf->Image("img/nbm_select.png",1.1,0.3,4.0,2.0);

}


	
$pdf->setXY(1.1,3.8);
$pdf->Cell(10.5,3.2, "",1,1,"c" );

$pdf->setXY(11.6,3.8);
$pdf->Cell(4.5,1.0, "",1,1,"c" );

$pdf->setXY(16.1,3.8);
$pdf->Cell(4.5,1.0, "",1,1,"c" );

$pdf->setXY(11.6,4.8);
$pdf->Cell(9,2.2, "",1,1,"c" );	

	
/*$pdf->setXY(16.0,6.6);
$pdf->Cell(4.5,1.0, "",1,1,"c" );*/
	
$pdf->SetFont('angsa','',14); 

$pdf->setXY(1.3,4.0);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "ชื่อลูกค้า"),0 ,'L' );
$pdf->setXY(1.3,4.3);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "Customer Name"),0 ,'L' );

$pdf->SetFont('angsana','B',14);
$pdf->setXY(3.6,3.9);
$pdf->MultiCell(8, 0.5, iconv( 'UTF-8//IGNORE','cp874//IGNORE' , "$customer"),0 ,'L' );

$pdf->SetFont('angsa','',14); 
	
$pdf->setXY(1.3,5.0);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "ที่อยู่"),0 ,'L' );
$pdf->setXY(1.3,5.3);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Address"),0 ,'L' );

$pdf->setXY(2.7,5.0);
$pdf->MultiCell(9,0.5, iconv( 'UTF-8','cp874' , "$address"),0 ,'L' );
	
$pdf->setXY(1.3,6.0);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "เบอร์โทรศัพท์"),0 ,'L' );
$pdf->setXY(1.3,6.3);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Telephone"),0 ,'L' );

$pdf->setXY(4.0,6.2);
$pdf->MultiCell(7.0, 0.6 , iconv( 'UTF-8','cp874' , "$delivery_tel"),0 ,'L' );
	
$pdf->setXY(11.8,3.9);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "วันที่"),0 ,'L' );
$pdf->setXY(11.8,4.2);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Date"),0 ,'L' );

$pdf->setXY(13.9,4.0);
$pdf->MultiCell(14.0,0.6, iconv( 'UTF-8','cp874' , "$date_br"),0 ,'L' );


$pdf->setXY(16.8,3.95);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "เลขที่"),0 ,'L' );
$pdf->setXY(16.8,4.25);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "No."),0 ,'L' );	

$pdf->SetFont('angsana','B',17);

$pdf->setXY(17.8,3.95);
$pdf->MultiCell(14.0,0.6, iconv( 'UTF-8','cp874' , "$iv_no"),0 ,'L' );


$pdf->SetFont('angsa','',14); 
	
$pdf->setXY(11.8,4.9);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "สถานที่ส่งสินค้า"),0 ,'L' );
$pdf->setXY(11.8,5.2);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Ship To"),0 ,'L' );

$pdf->setXY(13.3,5.4);
$pdf->MultiCell(8.0,0.5, iconv( 'UTF-8','cp874' , "$delivery_address"),0 ,'L' );
	
	
$pdf->setXY(1.1,7.1);
$pdf->Cell(1.0,1.0, "",1,1,"c" );

$pdf->setXY(2.1,7.1);
$pdf->Cell(3.0,1.0, "",1,1,"c" );

$pdf->setXY(5.1,7.1);
$pdf->Cell(8.5,1.0, "",1,1,"c" );

$pdf->setXY(13.6,7.1);
$pdf->Cell(2.0,1.0, "",1,1,"c" );

$pdf->setXY(15.6,7.1);
$pdf->Cell(2.5,1.0, "",1,1,"c" );

$pdf->setXY(18.1,7.1);
$pdf->Cell(2.5,1.0, "",1,1,"c" );

$pdf->SetFont('angsa','',14); 

$pdf->setXY(1.2,7.1);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "ลำดับ"),0 ,'L' );
$pdf->setXY(1.25,7.4);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Item"),0 ,'L' );

$pdf->setXY(2.8,7.1);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "รหัสสินค้า"),0 ,'L' );
$pdf->setXY(2.7,7.4);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Product Code"),0 ,'L' );

$pdf->setXY(8.4,7.1);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "รายละเอียดสินค้า"),0 ,'L' );
$pdf->setXY(8.7,7.4);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Description"),0 ,'L' );

$pdf->setXY(14.1,7.1);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "จำนวน"),0 ,'L' );
$pdf->setXY(14.3,7.4);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Qty."),0 ,'L' );

$pdf->setXY(15.9,7.1);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "ราคาต่อหน่วย"),0 ,'L' );
$pdf->setXY(16.1,7.4);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Price/Unit"),0 ,'L' );

$pdf->setXY(18.6,7.1);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "จำนวนเงิน"),0 ,'L' );
$pdf->setXY(18.8,7.4);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Amount"),0 ,'L' );


$pdf->setX(17.3);
$pdf->MultiCell( 9.0,0.5, iconv( 'UTF-8','cp874' , ""),0 ,'L' );

$pdf->SetFont('angsa','',11); 
$i=19;
while($objResult3 = mysqli_fetch_array($objQuery3))
{

$sum_amount1  =$objResult3["amount"];

$sum_amount = number_format( $sum_amount1,2)."";

$price_per_unit_1  =$objResult3["price"];
$price_per_unit= number_format( $price_per_unit_1,2)."";

$product_code1  =$objResult3["access_code"];
$product_code = substr($product_code1,0,12);	
$product_name  =$objResult3["sol_name"];
//$product_name = substr($product_name1,0,40);

$sale_count  = number_format($objResult3["count"],0)."";


$unit_name  =$objResult3["unit_name"];
$sale_remark = $objResult3["sale_remark"];
$sn = $objResult3["sn"];


$pdf->setX(1.35);
$pdf->MultiCell( 9.0,0, iconv( 'UTF-8','cp874' , "$i"),0 ,'L' );


$pdf->setX(2.15);
$pdf->MultiCell( 9.0,0, iconv( 'UTF-8','cp874' , "$product_code"),0 ,'L' );

$pdf->setX(5.3);
$pdf->Cell(10,0.0, iconv( 'UTF-8','cp874' , "$product_name"),0 ,'L' );

$pdf->setX(13.5);
$pdf->MultiCell(1.9,0, iconv( 'UTF-8','cp874' , "$sale_count $unit_name"),0 ,'R' );

$pdf->setX(15.95);
$pdf->MultiCell(2.0,0, iconv( 'UTF-8','cp874' , "$price_per_unit"),0 ,'R' );


$pdf->setX(18.55);
$pdf->MultiCell(2.0,0, iconv( 'UTF-8','cp874' , "$sum_amount"),0 ,'R' );

$pdf->setX(18.9);
$pdf->MultiCell( 9.0,0.5, iconv( 'UTF-8','cp874' , ""),0 ,'L' );

if($sale_remark!=''){
$pdf->setX(5.3);
$pdf->Cell(10,0.0, iconv( 'UTF-8','cp874' , "$sale_remark"),0 ,'L' );
	
$pdf->setX(18.9);
$pdf->MultiCell( 9.0,0.5, iconv( 'UTF-8','cp874' , ""),0 ,'L' );
}	
	
if($sn!=''){	
$pdf->SetFont('angsa','',11); 
$str_arr = explode("\n",$sn);

foreach ($str_arr as $test =>$value){
$product_sn = $str_arr[$test];
$product_sn1 =  trim($product_sn);	
if($product_sn1!=''){
	
$pdf->setX(5.3);
$pdf->Cell(10,0.0, iconv( 'UTF-8','cp874' , "SN : $product_sn1"),0 ,'L' );
	
$pdf->setX(18.9);
$pdf->MultiCell( 9.0,0.35, iconv( 'UTF-8','cp874' , ""),0 ,'L' );
}	
}	
}

$i++;


}

$pdf->setXY(1.1,8.1);
$pdf->Cell(1.0,11.0, "",1,1,"c" );

$pdf->setXY(2.1,8.1);
$pdf->Cell(3.0,11.0, "",1,1,"c" );

$pdf->setXY(5.1,8.1);
$pdf->Cell(8.5,11.0, "",1,1,"c" );

$pdf->setXY(13.6,8.1);
$pdf->Cell(2.0,11.0, "",1,1,"c" );

$pdf->setXY(15.6,8.1);
$pdf->Cell(2.5,11.0, "",1,1,"c" );

$pdf->setXY(18.1,8.1);
$pdf->Cell(2.5,11.0, "",1,1,"c" );


///
$pdf->setXY(1.1,19.1);
$pdf->Cell(4.0,1.2, "",1,1,"c" );

$pdf->setXY(5.1,19.1);
$pdf->Cell(13.0,1.2, "",1,1,"c" );

$pdf->setXY(18.1,19.1);
$pdf->Cell(2.5,1.2, "",1,1,"c" );

$pdf->setXY(1.2,19.25);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "รวมทั้งสิ้น"),0 ,'L' );
$pdf->setXY(1.25,19.75);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "Total Amount"),0 ,'L' );


$pdf->setXY(18.5,19.75);
$pdf->MultiCell(2.0,0, iconv( 'UTF-8','cp874' , "$summary"),0 ,'R' );




$pdf->setXY(1.1,20.35);
$pdf->Cell(9.75,2.0, "",1,1,"c" );

$pdf->SetFont('angsa','',14); 

$pdf->setXY(1.3,20.9);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "ผู้เบิกสินค้า"),0 ,'L' );
$pdf->setXY(1.3,21.25);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "Requested by"),0 ,'L' );

$pdf->setXY(3.5,20.7);
//$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "$sale"),0 ,'L' );

$pdf->setXY(2.8,20.93);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "........................................................."),0 ,'L' );

$pdf->setXY(7.5,20.9);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "วันที่"),0 ,'L' );
$pdf->setXY(7.5,21.25);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "Date"),0 ,'L' );

$pdf->setXY(8.15,20.93);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "................................."),0 ,'L' );

$pdf->setXY(8.8,20.7);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "$today"),0 ,'L' );


$pdf->setXY(3.4,21.5);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "$sale / $sale_code"),0 ,'L' );

$pdf->setXY(2.8,21.7);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "(.........................................................)"),0 ,'L' );



$pdf->setXY(1.1,22.35);
$pdf->Cell(9.75,2.5, "",1,1,"c" );

$pdf->SetFont('angsana','B',12);
$pdf->setXY(1.8,22.4);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "ได้รับสินค้าตามรายการข้างบนนี้ ในสภาพเรียบร้อย และถูกต้องแล้ว"),0 ,'L' );

$pdf->SetFont('angsa','',14); 

$pdf->setXY(1.3,23.1);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "รับของโดย"),0 ,'L' );
$pdf->setXY(1.3,23.5);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "Received by"),0 ,'L' );


$pdf->setXY(2.8,23.18);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "........................................................."),0 ,'L' );

$pdf->setXY(7.5,23.15);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "วันที่"),0 ,'L' );
$pdf->setXY(7.5,23.9);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "Date"),0 ,'L' );

$pdf->setXY(8.15,23.28);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "................................"),0 ,'L' );


$pdf->setXY(2.8,23.85);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "(.........................................................)"),0 ,'L' );



$pdf->setXY(1.1,24.85);
$pdf->Cell(9.75,1.8, "",1,1,"c" );


$pdf->SetFont('angsa','',14); 

$pdf->setXY(1.3,25.35);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "ผู้อนุมัติ"),0 ,'L' );
$pdf->setXY(1.3,25.75);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "Authorized by"),0 ,'L' );

$pdf->setXY(3.8,25.2);
//$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "$approve_name"),0 ,'L' );

$pdf->setXY(2.8,25.43);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "........................................................."),0 ,'L' );

$pdf->setXY(7.5,25.4);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "วันที่"),0 ,'L' );
$pdf->setXY(7.5,25.75);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "Date"),0 ,'L' );

$pdf->setXY(8.15,25.73);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "................................"),0 ,'L' );

$pdf->setXY(8.8,25.6);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "$today"),0 ,'L' );


$pdf->setXY(3.8,26.0);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "$approve_name"),0 ,'L' );

$pdf->setXY(2.8,26.2);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "(.........................................................)"),0 ,'L' );



$pdf->setXY(10.85,20.35);
$pdf->Cell(9.75,2.0, "",1,1,"c" );


$pdf->setXY(10.85,20.5);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "วัตถุประสงค์การเบิก"),0 ,'L' );
$pdf->setXY(10.85,20.9);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "Purpose"),0 ,'L' );

if ($objective=='1'){

$pdf->setXY(14.1,20.6);
$pdf->MultiCell(7.0,0.6, iconv( 'UTF-8','cp874' , "สินค้าฝากขาย (มีใบรับประกัน) $objective_des"),0 ,'L' );


}




$pdf->setXY(10.85,22.35);
$pdf->Cell(9.75,2.5, "",1,1,"c" );


$pdf->SetFont('angsa','',14); 

$pdf->setXY(10.85,22.55);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "คลังสินค้า"),0 ,'L' );
$pdf->setXY(10.85,22.95);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "Stock"),0 ,'L' );


$pdf->setXY(12.65,22.65);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "........................................................."),0 ,'L' );

$pdf->setXY(17.5,22.55);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "วันที่"),0 ,'L' );
$pdf->setXY(17.5,22.95);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "Date"),0 ,'L' );

$pdf->setXY(18.15,22.65);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , ".............................."),0 ,'L' );


$pdf->setXY(12.6,23.25);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "(.........................................................)"),0 ,'L' );


$pdf->setXY(11.3,23.85);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "จัดส่งโดย"),0 ,'L' );
$pdf->setXY(11.3,24.15);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "Delivery by"),0 ,'L' );


$pdf->setXY(12.65,23.95);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "........................................................."),0 ,'L' );

$pdf->setXY(17.5,23.85);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "วันที่"),0 ,'L' );
$pdf->setXY(17.5,24.15);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "Date"),0 ,'L' );

$pdf->setXY(18.15,23.95);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , ".............................."),0 ,'L' );


$pdf->setXY(12.6,24.50);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "(.........................................................)"),0 ,'L' );





$pdf->setXY(10.85,24.85);
$pdf->Cell(9.75,1.8, "",1,1,"c" );

$pdf->setXY(10.85,25.0);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "หมายเหตุ"),0 ,'L' );
$pdf->setXY(10.85,25.4);
$pdf->MultiCell(9.0,0.4, iconv( 'UTF-8','cp874' , "Remarks"),0 ,'L' );




if($type_doc =='1'){
$pdf->SetFont('angsa','',11); 

$pdf->setXY(1.15,26.6);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "อนุมัติวันที่ 1 ก.พ.2564"),0 ,'L' );

$pdf->setXY(11.5,26.6);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "FM-SA-25:Rev.5"),0 ,'R' );
}
if($type_doc =='2'){
$pdf->SetFont('angsa','',11); 

$pdf->setXY(1.15,26.6);
//$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "อนุมัติวันที่ 04 ก.ค.2567"),0 ,'L' );

$pdf->setXY(11.5,26.6);
//$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "040767:Rev.0"),0 ,'R' );
}

}


$pdf->Output();

?>


