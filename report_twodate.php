<?php

define('FPDF_FONTPATH','font/');
 
require('fpdf.php');









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

$pdf=new FPDF( 'L' , 'cm' , 'A4' );
$pdf->AddFont('angsa','','angsa.php');
$pdf->AddFont('angsana','B','angsab.php');


 
$pdf->AddPage();

include"dbconnect.php";
$start_date=$_GET["start_date"];	
$end_date=$_GET["end_date"];
$h_product_code =$_GET["h_product_code"];

$date = explode('-' , $_GET["start_date"] );
$newDate = $date[2].'-'.$date[1].'-'.$date[0];


$pdf->SetFont('angsana','B',18);
		$pdf->Cell(4.0,2.0,iconv('UTF-8','cp874','รายงานสรุปตามวันที่ :'),0,"C");
		$pdf->Cell(7.0,2.0,iconv('UTF-8','cp874',$newDate),0,"C");

	
		$pdf->Ln(0.2);
				$pdf->Cell(17.0,1.2,iconv('UTF-8','cp874',''),0,"C");
$pdf->Ln(0.8);

$started = microtime(true);
	$sql = "SELECT distinct salechannel_nameshort,sale_channel,salechannel_name FROM ((so__main LEFT JOIN  tb_salechannel ON so__main.sale_channel=tb_salechannel.salechannel_ID)LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) where 1 ";
	


	if($start_date !=""){ 
    $sql .= ' AND register_date = "'.$start_date.'"'; 
}
if($h_product_code !=""){ 
    $sql .= ' AND product_code = "'.$h_product_code.'"'; 
}

$query = mysqli_query($conn,$sql) or die(mysqli_error());



	while($result = mysqli_fetch_array($query)){



$salechannel_nameshort=$result["salechannel_nameshort"];
$sale_channel =$result["sale_channel"];
$salechannel_name = $result["salechannel_name"];
$sum_salechannel = "$salechannel_nameshort $salechannel_name";


$pdf->SetFont('angsana','B',18);
$pdf->Ln(1.0);
$pdf->Cell(4.0,2.0,iconv('UTF-8','cp874','ช่องทางการขาย :'),0,"C");
		$pdf->Cell(9.0,2.0,iconv('UTF-8','cp874',$sum_salechannel),0,"C");
				$pdf->Ln(1.0);

$pdf->SetFont('angsana','B',14);

		$pdf->Cell(2.0,2.0,iconv('UTF-8','cp874','วันที่'),0,"C");
		$pdf->Cell(1.0,2.0,iconv('UTF-8','cp874','ID'),0,"C");
		$pdf->Cell(3.0,2.0,iconv('UTF-8','cp874','หมายเลขคำสั่งซื้อ'),0,"C");
		$pdf->Cell(3.0,2.0,iconv('UTF-8','cp874','ชื่อลูกค้า'),0,"C");
		$pdf->Cell(9.0,2.0,iconv('UTF-8','cp874','รายการสินค้า'),0,"C");
		$pdf->Cell(1.5,2.0,iconv('UTF-8','cp874','จำนวน'),0,"C");
		$pdf->Cell(1.5,2.0,iconv('UTF-8','cp874','ราคา'),0,"C");
		$pdf->Cell(1.5,2.0,iconv('UTF-8','cp874','รวมเป็นเงิน'),0,"C");
		$pdf->Cell(2.0,2.0,iconv('UTF-8','cp874','เลขที่เอกสาร'),0,"C");
		$pdf->Cell(2.0,2.0,iconv('UTF-8','cp874','การจัดส่ง'),0,"C");
		$pdf->Ln(0.2);

		$pdf->Cell(28.2,1.2,iconv('UTF-8','cp874',''),0,"C");


$pdf->Ln(0.5);


$pdf->SetFont('angsa','',14);


$sql1 = "SELECT register_date,billing_name,ref_id,order_id,doc_no,delivery,customer_name,sale_count,price_per_unit,sum_amount,access_name  FROM ((so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) LEFT JOIN tb_product ON so__submain.product_ID=tb_product.product_id) where sale_channel='".$sale_channel."' ";
	


	if($start_date !=""){ 
    $sql1 .= ' AND register_date = "'.$start_date.'"'; 
}
		if($h_product_code !=""){ 
    $sql1 .= ' AND product_code = "'.$h_product_code.'"'; 
}



$query1 = mysqli_query($conn,$sql1) or die(mysqli_error());



	while($result1 = mysqli_fetch_array($query1)){

$register_date=$result1["register_date"];
$ref_id=$result1["ref_id"];
$order_id=$result1["order_id"];
$access_name=$result1["access_name"];


	$billing_name=$result1["billing_name"];
$sale_count=$result1["sale_count"];
$price_per_unit1=$result1["price_per_unit"];

$price_per_unit= number_format( $price_per_unit1,2)."";

$sum_amount1=$result1["sum_amount"];
$sum_amount= number_format( $sum_amount1,2)."";

$doc_no=$result1["doc_no"];
$delivery=$result1["delivery"];


$sql2 = "SELECT delivery_name FROM tb_delivery where delivery_id='".$delivery."' ";
	$query2 = mysqli_query($conn,$sql2) or die(mysqli_error());
	$result2 = mysqli_fetch_array($query2);
		$delivery_name=$result2["delivery_name"];


	$pdf->Cell(2.0,2.0,iconv('UTF-8','cp874',$register_date),0,"C");
	$pdf->Cell(1.0,2.0,iconv('UTF-8','cp874',$ref_id),0,"C");
	$pdf->Cell(3.0,2.0,iconv('UTF-8','cp874',$order_id),0,"C");
	$pdf->Cell(3.0,2.0,iconv('UTF-8','cp874',$billing_name),0,"C");

	$pdf->Cell(9.0,2.0,iconv('UTF-8','cp874',$access_name),0,"C");
	$pdf->Cell(1.5,2.0,iconv('UTF-8','cp874',$sale_count),0,"C");
	$pdf->Cell(1.5,2.0,iconv('UTF-8','cp874',$price_per_unit),0,"C");
	$pdf->Cell(1.5,2.0,iconv('UTF-8','cp874',$sum_amount),0,"C");
	$pdf->Cell(2.0,2.0,iconv('UTF-8','cp874',$doc_no),0,"C");
	$pdf->Cell(2.0,2.0,iconv('UTF-8','cp874',$delivery_name),0,"C");
	$pdf->Ln(0.2);
	$pdf->Cell(28.2,1.2,iconv('UTF-8','cp874',''),0,"C");
	$pdf->Ln(0.5);







	}

$strSQL1 = "SELECT SUM(sum_amount) AS amount_1 FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) where sale_channel='".$sale_channel."' ";
	


	if($start_date !=""){ 
    $strSQL1 .= ' AND register_date = "'.$start_date.'"'; 
}

		if($h_product_code !=""){ 
    $strSQL1 .= ' AND product_code = "'.$h_product_code.'"'; 
}

		
/*if($end_date !=""){ 
    $strSQL1 .= ' AND delivery_date = "'.$end_date.'"'; 
}*/
//echo $strSQL1;
//exit();
$objQuery1 = mysqli_query($conn,$strSQL1);
$objResult1= mysqli_fetch_array($objQuery1);

$summary_1=$objResult1['amount_1'];
$summary= number_format( $summary_1,2)."";


$strSQL2 = "SELECT SUM(sale_count) AS sale_count  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) where sale_channel='".$sale_channel."' ";
	


	if($start_date !=""){ 
    $strSQL2 .= ' AND register_date = "'.$start_date.'"'; 
}

		if($h_product_code !=""){ 
    $strSQL2 .= ' AND product_code = "'.$h_product_code.'"'; 
}
		
/*if($end_date !=""){ 
    $strSQL2 .= ' AND delivery_date = "'.$end_date.'"'; 
}*/
//echo $strSQL1;
//exit();
$objQuery2 = mysqli_query($conn,$strSQL2);
$objResult2= mysqli_fetch_array($objQuery2);


$sale_count1=$objResult2['sale_count'];
$sale_count= number_format( $sale_count1,2)."";

 $pdf->SetFont('angsana','B',14);

	$pdf->Cell(2.0,2.0,iconv('UTF-8','cp874','รวมตามช่องทางการขาย :'),0,"C");
		$pdf->Cell(16.0,2.0,iconv('UTF-8','cp874',''),0,"C");
	$pdf->Cell(1.5,2.0,iconv('UTF-8','cp874',$sale_count),0,"C");
	$pdf->Cell(2.0,2.0,iconv('UTF-8','cp874',$summary),0,"C");
		$pdf->Cell(1.5,2.0,iconv('UTF-8','cp874','บาท'),0,"C");
$pdf->Ln(0.5);






	}

$strSQL3 = "SELECT SUM(sale_count) AS sale_count_1 FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) where 1 ";
	


	if($start_date !=""){ 
    $strSQL3 .= ' AND register_date = "'.$start_date.'"'; 
	}

if($h_product_code !=""){ 
    $strSQL3 .= ' AND product_code = "'.$h_product_code.'"'; 
}



	$objQuery3 = mysqli_query($conn,$strSQL3);
	$objResult3= mysqli_fetch_array($objQuery3);

	$sale_count2=$objResult3['sale_count_1'];
	$sale_count_2= number_format( $sale_count2,2)."";


$strSQL4 = "SELECT SUM(sum_amount) AS amount_2 FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) where 1 ";
	


	if($start_date !=""){ 
    $strSQL4 .= ' AND register_date = "'.$start_date.'"'; 
	}

if($h_product_code !=""){ 
    $strSQL4 .= ' AND product_code = "'.$h_product_code.'"'; 
}



	$objQuery4 = mysqli_query($conn,$strSQL4);
	$objResult4= mysqli_fetch_array($objQuery4);

	$amount_2=$objResult4['amount_2'];
	$amount_23= number_format( $amount_2,2)."";

	$pdf->Cell(2.0,2.0,iconv('UTF-8','cp874','รวมทั้งหมด :'),0,"C");
	$pdf->Cell(16.0,2.0,iconv('UTF-8','cp874',''),0,"C");
	$pdf->Cell(1.5,2.0,iconv('UTF-8','cp874',$sale_count_2),0,"C");
	$pdf->Cell(2.0,2.0,iconv('UTF-8','cp874',$amount_23),0,"C");
	$pdf->Cell(1.5,2.0,iconv('UTF-8','cp874','บาท'),0,"C");
	$pdf->Ln(0.5);




	$pdf->Output();



?>