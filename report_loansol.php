<?php


define('FPDF_FONTPATH','font/');
 
require('fpdf.php');

$ref_id=$_GET["ref_id"];



include"dbconnect.php";

$strSQL = "SELECT * FROM so__main  WHERE ref_id = '".$ref_id."' ";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);


$strSQL1 = "SELECT * FROM (so__submain LEFT JOIN tb_product ON so__submain.product_ID=tb_product.product_id) WHERE ref_idd = '".$ref_id."' ";
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
	    $strYear1 =substr( $strYear , 2 , 2 );
		return "$strDay $strMonthThai $strYear1";
	}





//$newDate = date("d-m-Y", strtotime($start_date));
$ref_id=$objResult["ref_id"];
$doc_release_date = DateThai($objResult["doc_release_date"]);
$customer_name =$objResult["customer_name"];
$billing_address  =$objResult["delivery_place"];
$tel =$objResult["tel"];
$address1 =$objResult["address1"];
$address2 =$objResult["address2"];
$address = "$address1 $address2";

$objective =$objResult["objective"];
$objective_des = $objResult["objective_des"];

$sale = $objResult["billing_name"];
//$sale_code = $objResult["sale_code"];
$approve = $objResult["approve"];
$sale_name = "$sale";
$sale_comment = $objResult["sale_comment"];
$employee_name = $objResult["add_by"];


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

$pdf->setXY( 3.6,3.8);
$pdf->MultiCell( 9  , 0.6 , iconv( 'UTF-8','cp874' , "$customer_name"),0 ,'L' );

$pdf->setXY(13.6,3.9);
$pdf->MultiCell( 9  , 0.6 , iconv( 'UTF-8','cp874' , "$doc_release_date"),0 ,'L' );


$pdf->setXY(3.4,4.8);
$pdf->MultiCell(7.0, 0.6 , iconv( 'UTF-8','cp874' , "$billing_address"),0 ,'L' );

$pdf->setXY(13.6,5.5);
$pdf->MultiCell(6.5, 0.6 , iconv( 'UTF-8','cp874' , "$address"),0 ,'L' );


$pdf->setXY( 3.4,6.4);
$pdf->MultiCell(7.0, 0.6 , iconv( 'UTF-8','cp874' , "$tel"),0 ,'L' );

$pdf->setX(17.0);
$pdf->MultiCell( 9.0,2.3, iconv( 'UTF-8','cp874' , ""),0 ,'L' );


$strSQL1 = "SELECT * FROM (so__submain LEFT JOIN tb_product ON so__submain.product_ID=tb_product.product_id) WHERE ref_idd = '".$ref_id."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

$i=1;
while($objResult1 = mysqli_fetch_array($objQuery1))
{

$sum_amount1  =$objResult1["sum_amount"];
$sum_amount= number_format( $sum_amount1,2)."";

$price_per_unit_1  =$objResult1["price_per_unit"];
$price_per_unit= number_format( $price_per_unit_1,2)."";

$product_code1  =$objResult1["access_code"];
$product_code = substr($product_code1,0,10);	
$product_name1 =$objResult1["sol_name"]; //แก้ให้ชื่อวินค้าไม่ทับกับจำนวน
//var_dump($product_name1);
$product_name = mb_substr($product_name1, 0, 65, "UTF-8");
	
$sale_count  =$objResult1["sale_count"];
$unit_name  =$objResult1["unit_name"];
$sale_remark = $objResult1["sale_remark"];


$pdf->setX(1.2);
$pdf->MultiCell( 9.0,0, iconv( 'UTF-8','cp874' , "$i"),0 ,'L' );


$pdf->setX(1.8);
$pdf->MultiCell( 9.0,0, iconv( 'UTF-8','cp874' , "$product_code"),0 ,'L' );
$pdf->SetFont('angsa','',14);
$pdf->setX(4.5);
$pdf->MultiCell(15,0, iconv( 'UTF-8','cp874' , "$product_name"),0 ,'L' );

$pdf->SetFont('angsa','',16);
$pdf->setX(13.8);
$pdf->MultiCell(1.9,0, iconv( 'UTF-8','cp874' , "$sale_count"),0 ,'R' );

$pdf->setX(15.9);
$pdf->MultiCell(2.0,0, iconv( 'UTF-8','cp874' , "$price_per_unit"),0 ,'R' );


$pdf->setX(18.5);
$pdf->MultiCell(2.0,0, iconv( 'UTF-8','cp874' , "$sum_amount"),0 ,'R' );
$pdf->setX(18.3);
$pdf->MultiCell( 9.0,0.2, iconv( 'UTF-8','cp874' , ""),0 ,'L' );
	
$pdf->SetFont('angsa','',14);	
$pdf->setX(4.5);
$pdf->MultiCell(13,0.5, iconv( 'UTF-8','cp874' , "$sale_remark"),0 ,'L' );
	
$pdf->setX(18.3);
$pdf->MultiCell( 9.0,0.2, iconv( 'UTF-8','cp874' , ""),0 ,'L' );
	
$i++;


}

$pdf->setXY(18.6,18.5);
$pdf->MultiCell(2.0,0, iconv( 'UTF-8','cp874' , "$summary"),0 ,'R' );


$pdf->SetFont('angsa','',16);
$pdf->setXY(8.5,20.3);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "$today"),0 ,'L' );

$pdf->setXY(3.7,20.8);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874//ASCII//TRANSLIT//IGNORE', "$employee_name"),0 ,'L' );

$pdf->setXY(8.5,24.8);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "$today"),0 ,'L' );

$pdf->setXY(3.7,25.4);
$pdf->MultiCell(9.0,0.6, iconv( 'UTF-8','cp874' , "ชลชินี มิตรสันติสุข"),0 ,'L' );



if ($objective=='1'){

$pdf->setXY(13.0,20.4);
$pdf->MultiCell(7.0,0.6, iconv( 'UTF-8','cp874' , "เป็นสินค้าสำรอง $objective_des"),0 ,'L' );


}else if ($objective=='2'){
	
$pdf->setXY(13.0,20.4);
$pdf->MultiCell(7.0,0.6, iconv( 'UTF-8','cp874' , "สำหรับลูกค้าทดลองใช้ $objective_des"),0 ,'L' );


}else if ($objective=='3'){ 

$pdf->setXY(13.0,20.4);
$pdf->MultiCell(7.0,0.6, iconv( 'UTF-8','cp874' , "ส่งสินค้าล่วงหน้าเพื่อรอใบสั่งซื้อ"),0 ,'L' );
}else if ($objective=='7'){ 

$pdf->setXY(13.0,20.4);
$pdf->MultiCell(7.0,0.6, iconv( 'UTF-8','cp874' , "สินค้าออกบูธ"),0 ,'L' );

}else if ($objective=='4'){ 

$pdf->setXY(13.0,20.4);
$pdf->MultiCell(7.0,0.6, iconv( 'UTF-8','cp874' , "แลกเปลี่ยนสินค้าตามใบงานบริการเลขที่ $objective_des"),0 ,'L' );

}else if ($objective=='5'){ 

$pdf->setXY(13.0,20.4);
$pdf->MultiCell(6.8,0.6, iconv( 'UTF-8','cp874' , "$objective_des"),0 ,'L' );


}







/* $pdf->setXY(12.3,24.2);
$pdf->MultiCell(8.0,0.6, iconv( 'UTF-8','cp874' , "$sale_comment"),0 ,'L' );*/





$pdf->Output();
?>


