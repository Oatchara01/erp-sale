<?php

define('FPDF_FONTPATH','font/');
 
require('fpdf.php');

$ref_id_br=$_GET["ref_id_br"];


include"dbconnect.php";

$strSQL = "SELECT * FROM hos__br  WHERE ref_id_br = '".$ref_id_br."' ";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);

$strSQL2 = "SELECT * FROM hos__br  WHERE ref_id_br = '".$ref_id_br."' and customer LIKE '%รามาธิบดี%'";
$objQuery2 = mysqli_query($conn,$strSQL2) or die(mysqli_error());
$Num_Rows2 = mysqli_num_rows($objQuery2);


$strSQL1 = "SELECT * FROM (hos__subbr LEFT JOIN tb_product ON hos__subbr.product_ID=tb_product.product_id) WHERE ref_idd_br = '".$ref_id_br."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

$strSQL15 = "SELECT SUM(amount) AS amount_1 FROM hos__subbr WHERE ref_idd_br = '".$ref_id_br."' ";
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
	    $strYear1 =substr( $strYear , 2 , 2 );
		return "$strDay $strMonthThai $strYear1";
	}


//$newDate = date("d-m-Y", strtotime($start_date));
$ref_id_br=$objResult["ref_id_br"];
$date_br = DateThai($objResult["iv_date"]);
$customer =$objResult["customer"];

$address =$objResult["address"];
$delivery_tel =$objResult["delivery_tel"];
$delivery_address =$objResult["delivery_address"];

$objective =$objResult["objective"];
$objective_des1 = $objResult["objective_des1"];
$objective_des2 = $objResult["objective_des2"];
$objective_des4 = $objResult["objective_des4"];
$objective_des5 = $objResult["objective_des5"];
$objective_des6 = $objResult["objective_des6"];

$sale = $objResult["sale"];
$sale_code = $objResult["sale_code"];
$approve = $objResult["approve"];
$sale_name = "$sale / $sale_code";
$sale_comment = $objResult["sale_comment"];



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

$pdf->SetFont('angsa','',16);

$pdf->setXY( 3.6,3.6);
$pdf->MultiCell(10.0, 0.6 , iconv( 'UTF-8//IGNORE','cp874//IGNORE' , "$customer"),0 ,'L' );

//if($Num_Rows2 >0){ }else{
$pdf->setXY(14.1,3.7);
$pdf->MultiCell( 9  , 0.6 , iconv( 'UTF-8//IGNORE','cp874//IGNORE' , "$date_br"),0 ,'L' );
//}

$pdf->setXY(3.4,4.8);
$pdf->MultiCell(8.0, 0.5 , iconv( 'UTF-8//IGNORE','cp874//IGNORE' , "$address"),0 ,'L' );

$pdf->setXY(14.1,5.2);
$pdf->MultiCell(6.5, 0.6 , iconv( 'UTF-8//IGNORE','cp874//IGNORE' , "$delivery_address"),0 ,'L' );


$pdf->setXY( 3.4,6.6);
$pdf->MultiCell(7.0, 0.6 , iconv( 'UTF-8//IGNORE','cp874//IGNORE' , "$delivery_tel"),0 ,'L' );

$pdf->setX(17.0);
$pdf->MultiCell( 9.0,2.5, iconv( 'UTF-8','cp874' , ""),0 ,'L' );


$strSQL1 = "SELECT * FROM (hos__subbr LEFT JOIN tb_product ON hos__subbr.product_ID=tb_product.product_id) WHERE ref_idd_br = '".$ref_id_br."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

$i=1;
while($objResult1 = mysqli_fetch_array($objQuery1))
{

$sum_amount1  =$objResult1["amount"];
$sum_amount= number_format( $sum_amount1,2)."";

$price_per_unit_1  =$objResult1["price"];
$price_per_unit= number_format( $price_per_unit_1,2)."";

$product_code1  =$objResult1["access_code"];
$product_code = substr($product_code1,0,10);	
$product_name1 =$objResult1["sol_name"]; //แก้ให้ชื่อวินค้าไม่ทับกับจำนวน
//var_dump($product_name1);
$product_name = mb_substr($product_name1, 0, 47, "UTF-8");
 	
$sale_count  =$objResult1["count"];
$unit_name  =$objResult1["unit_name"];
$sale_remark = $objResult1["sale_remark"];

$pdf->SetFont('angsa','',14);
	
$pdf->setX(1.5);
$pdf->MultiCell( 9.0,0.0, iconv( 'UTF-8','cp874' , "$i"),0 ,'L' );


$pdf->setX(2.3);
$pdf->MultiCell( 9.0,0, iconv( 'UTF-8','cp874' , "$product_code"),0 ,'L' );

$pdf->SetFont('angsa','',14);	
$pdf->setX(4.8);
//$pdf->MultiCell(30,0, iconv( 'UTF-8','cp874' , "$sale_remark"),0 ,'L' );
//$product_name =	utf8_decode($product_name);
//$pdf->MultiCell(10,0.5, iconv('UTF-8//IGNORE', 'cp874//IGNORE', "$product_name"), 0, 'L');

	
$pdf->MultiCell(50,0, iconv('UTF-8//IGNORE', 'cp874//IGNORE', "$product_name"), 0, 'L');
	
//$pdf->SetFont('angsa','',16);
$pdf->SetFont('angsa','',14);
$pdf->setX(13.55);
$pdf->MultiCell(1.9,0, iconv( 'UTF-8','cp874' , "$sale_count"),0 ,'R' );
	
$pdf->setX(14.5);
$pdf->MultiCell(1.9,0, iconv( 'UTF-8','cp874' , "$unit_name"),0 ,'R' );

$pdf->setX(16.4);
$pdf->MultiCell(2.0,0, iconv( 'UTF-8','cp874' , "$price_per_unit"),0 ,'R' );


$pdf->setX(18.6);
$pdf->MultiCell(2.0,0, iconv( 'UTF-8','cp874' , "$sum_amount"),0 ,'R' );

$pdf->setX(18.3);
$pdf->MultiCell( 9.0,0.4, iconv( 'UTF-8','cp874' , ""),0 ,'L' );
	
//$pdf->setX(13.15);
$pdf->setX(4.9);
$pdf->MultiCell(10,0.4, iconv( 'UTF-8','cp874' , "$sale_remark"),0 ,'L' );
	
$pdf->setX(14.5);
$pdf->setX(18.3);
$pdf->MultiCell( 9.0,0.4, iconv( 'UTF-8','cp874' , ""),0 ,'L' );


$i++;


}$pdf->SetFont('angsa','',16);

$pdf->setXY(18.6,18.6);
$pdf->MultiCell(2.0,0, iconv( 'UTF-8','cp874' , "$summary"),0 ,'R' );



$pdf->setXY(8.8,20.0);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "$today"),0 ,'L' );

$pdf->setXY(4.1,20.8);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8//IGNORE','cp874//IGNORE' , "$sale_name"),0 ,'L' );

$pdf->setXY(8.8,24.8);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "$today"),0 ,'L' );

$pdf->setXY(4.1,25.3);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "ชลชินี มิตรสันติสุข"),0 ,'L' );



if ($objective=='1'){

$pdf->setXY(14.0,19.6);
$pdf->MultiCell(7.0,0.6, iconv( 'UTF-8','cp874' , "เป็นสินค้าสำรอง $objective_des1"),0 ,'L' );


}else if ($objective=='2'){
	
$pdf->setXY(14.0,19.6);
$pdf->MultiCell(7.0,0.6, iconv( 'UTF-8','cp874' , "สำหรับลูกค้าทดลองใช้ $objective_des2"),0 ,'L' );


}else if ($objective=='3'){ 

$pdf->setXY(14.0,19.6);
$pdf->MultiCell(7.0,0.6, iconv( 'UTF-8','cp874' , "ส่งสินค้าล่วงหน้าเพื่อรอใบสั่งซื้อ"),0 ,'L' );
	
}else if ($objective=='7'){ 

$pdf->setXY(14.0,19.6);
$pdf->MultiCell(7.0,0.6, iconv( 'UTF-8','cp874' , "สินค้าออกบูธ"),0 ,'L' );
}else if ($objective=='4'){ 

$pdf->setXY(14.0,19.6);
$pdf->MultiCell(7.0,0.6, iconv( 'UTF-8','cp874' , "แลกเปลี่ยนสินค้าตามใบงานบริการเลขที่ $objective_des4"),0 ,'L' );

}else if ($objective=='5'){ 

$pdf->setXY(14.0,19.6);
$pdf->MultiCell(6.8,0.6, iconv( 'UTF-8','cp874' , "$objective_des5"),0 ,'L' );
	
}else if ($objective=='6'){ 

$pdf->setXY(14.0,19.6);
$pdf->MultiCell(6.8,0.6, iconv( 'UTF-8','cp874' , "สินค้าฝากขาย (มีใบรับประกัน) $objective_des6"),0 ,'L' );

}


/* $pdf->setXY(12.3,24.2);
$pdf->MultiCell(8.0,0.6, iconv( 'UTF-8','cp874' , "$sale_comment"),0 ,'L' );*/

$pdf->Output();
?>


