
<?php
//header("Content-Type: image/png");


//header("Content-Disposition: attachment; filename=สรุปงานแผนกบริการลูกค้า.png");


define('FPDF_FONTPATH','font/');
 
require('fpdf.php');

$ref_id=$_GET["ref_id"];
$extra=$_GET["extra"];

include"dbconnect.php";

$strSQL = "SELECT
so__main.* ,tb_province.*  FROM (so__main LEFT JOIN tb_province ON so__main.province=tb_province.province_ID) WHERE ref_id = '".$ref_id."' ";
//echo  $strSQL;
//exit();

$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);

$strSQL1 = "SELECT * FROM so__submain WHERE ref_idd = '".$ref_id."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
if ($extra==1)
{
$strSQL2 = "SELECT * FROM so__extraaddress  WHERE ref_id = '".$ref_id."' and extra='1' ";
$objQuery2 = mysqli_query($conn,$strSQL2) or die("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);
} else if ($extra==2) {
$strSQL3 = "SELECT * FROM so__extraaddress  WHERE ref_id = '".$ref_id."' and extra='2' ";
$objQuery3 = mysqli_query($conn,$strSQL3) or die("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);
} else if ($extra==3) {
$strSQL4 = "SELECT * FROM so__extraaddress  WHERE ref_id = '".$ref_id."' and extra='3' ";
$objQuery4 = mysqli_query($conn,$strSQL4) or die("Error Query [".$strSQL4."]");
$objResult4 = mysqli_fetch_array($objQuery4);
}

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



	if ($extra == 1)
	{
		$ref_id=$objResult2["ref_id"];
		$delivery_name =$objResult2["customer_name"];
		$tel =$objResult2["tel"];
		$address1 =$objResult2["address1"];
		$address2 =	$objResult2["address2"];
		$province_name =$objResult2["province"];
		$postcode =$objResult2["postcode"];
	}
	else if ($extra== 2)
	{
		$ref_id=$objResult3["ref_id"];
		$delivery_name =$objResult3["customer_name"];
		$tel =$objResult3["tel"];
		$address1 =$objResult3["address1"];
		$address2 =	$objResult3["address2"];
		$province_name =$objResult3["province"];
		$postcode =$objResult3["postcode"];
	}
	else if ($extra == 3)
	{
		$ref_id=$objResult4["ref_id"];
		$delivery_name =$objResult4["customer_name"];
		$tel =$objResult4["tel"];
		$address1 =$objResult4["address1"];
		$address2 =	$objResult4["address2"];
		$province_name =$objResult4["province"];
		$postcode =$objResult4["postcode"];
	}
	else
	{
//$newDate = date("d-m-Y", strtotime($start_date));
$ref_id=$objResult["ref_id"];
$delivery_name =$objResult["customer_name"];
$tel =$objResult["tel"];
$address1 =$objResult["address1"];
$address2 =$objResult["address2"];
$province_name =$objResult["province"];
$postcode =$objResult["postcode"];
	}


$pdf=new FPDF( 'L' , 'cm' , 'A4' );
$pdf->AddFont('angsa','','angsa.php');
$pdf->AddFont('angsana','B','angsab.php');


 

$pdf->AddPage();

$pdf->SetFont('angsa','',24);
$pdf->setXY(26.5,1.0);
$pdf->MultiCell( 9  ,1.0, iconv( 'UTF-8','cp874' , "$ref_id #"),0 ,'L' );



$pdf->setXY(2.5,2.0);
$pdf->MultiCell(12.0,1.1, iconv( 'UTF-8','cp874' , "บริษัท โนเบิล เมด จำกัด"),0 ,'L' );

$pdf->setXY(2.5,3.0);
$pdf->MultiCell(12.0,1.1, iconv( 'UTF-8','cp874' , "73 ซอยจรัญสนิทวงศ์ 89/2"),0 ,'L' );

$pdf->setXY(2.5,4.0);
$pdf->MultiCell(12.0,1.0, iconv( 'UTF-8','cp874' , "แขวงบางอ้อ เขตบางพลัด กรุงเทพ ฯ 10700"),0 ,'L' );

$pdf->setXY(2.5,5.0);
$pdf->MultiCell(12.0,1.0, iconv( 'UTF-8','cp874' , "โทร : 0-2880-5566"),0 ,'L' );

$pdf->SetFont('angsana','B',30);

$pdf->setXY(13.0,8.0);
$pdf->MultiCell(20.0,1.5, iconv( 'UTF-8','cp874' , "$delivery_name"),0 ,'L' );
$pdf->SetFont('angsa','',30);

$pdf->setXY(13.0,9.0);
$pdf->MultiCell(12.0,1.5, iconv( 'UTF-8','cp874' , "โทร :"),0 ,'L' );


$pdf->setXY(15.0,9.0);
$pdf->MultiCell(12.0,1.5, iconv( 'UTF-8','cp874' , "$tel"),0 ,'L' );

$pdf->setXY(13.0,10.0);
$pdf->MultiCell(20.0,1.5, iconv( 'UTF-8','cp874' , "$address1"),0 ,'L' );

$pdf->setXY(13.0,11.5);
$pdf->MultiCell(20.0,1.5, iconv( 'UTF-8','cp874' , "$address2"),0 ,'L' );

$pdf->setXY(13.0,13.0);
$pdf->MultiCell(12.0,1.5, iconv( 'UTF-8','cp874' , "$province_name"),0 ,'L' );

$pdf->setXY(23.5,13.0);
$pdf->MultiCell(12.0,1.5, iconv( 'UTF-8','cp874' , "$postcode"),0 ,'L' );

$pdf->SetFont('angsana','B',30);


$pdf->setXY(13.0,14.8);
$pdf->MultiCell(15.0, 0.6 , iconv( 'UTF-8','cp874' , "**เก็บเงินปลายทาง** COD ยอดเงิน $summary บาท"),0 ,'L' );




$pdf->Output();
?>


