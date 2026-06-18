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

$pdf=new FPDF( 'P' , 'cm' , 'A4' );
$pdf->AddFont('angsa','','angsa.php');
$pdf->AddFont('angsana','B','angsab.php');


 
$pdf->AddPage();

include"dbconnect.php";
$start_date=$_GET["start_date"];	
$end_date=$_GET["end_date"];
$sale_channel=$_GET["sale_channel"];



$strSQL5 = "SELECT SUM(sale_count) AS sale_count_1 FROM (((so__main LEFT JOIN  tb_salechannel ON so__main.sale_channel=tb_salechannel.salechannel_ID)LEFT JOIN tb_delivery ON so__main.delivery=tb_delivery.delivery_ID)LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) where 1 ";
	


	if($start_date !=""){ 
    $strSQL5 .= ' AND register_date >= "'.$start_date.'"'; 
	}

	if($end_date !=""){ 
    $strSQL5 .= ' AND register_date <= "'.$end_date.'"'; 
	}

	if($sale_channel !=""){ 
    $strSQL5 .= ' AND sale_channel = "'.$sale_channel.'"'; 
}

//echo $strSQL3;
//exit();

	$objQuery5 = mysqli_query($conn,$strSQL5);
	$objResult5= mysqli_fetch_array($objQuery5);

	$sale_count2=$objResult5['sale_count_1'];
	$sale_count_2= number_format( $sale_count2,2)."";


$strSQL6 = "SELECT SUM(sum_amount) AS amount_2 FROM (((so__main LEFT JOIN  tb_salechannel ON so__main.sale_channel=tb_salechannel.salechannel_ID)LEFT JOIN tb_delivery ON so__main.delivery=tb_delivery.delivery_ID)LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) where 1 ";
	


	if($start_date !=""){ 
    $strSQL6 .= ' AND register_date >= "'.$start_date.'"'; 
	}

	if($end_date !=""){ 
    $strSQL6 .= ' AND register_date <= "'.$end_date.'"'; 
	}
	if($sale_channel !=""){ 
    $strSQL6 .= ' AND sale_channel = "'.$sale_channel.'"'; 
}

//echo $strSQL3;
//exit();

	$objQuery6 = mysqli_query($conn,$strSQL6);
	$objResult6= mysqli_fetch_array($objQuery6);

	$amount_2=$objResult6['amount_2'];
	$amount_23= number_format( $amount_2,2)."";


$date = explode('-' , $_GET["start_date"] );
$newDate = $date[2].'-'.$date[1].'-'.$date[0];
$date1 = explode('-' , $_GET["end_date"] );
$newDate1 = $date1[2].'-'.$date1[1].'-'.$date1[0];


$pdf->SetFont('angsana','B',18);
		$pdf->Cell(4.0,2.0,iconv('UTF-8','cp874','รายงานสรุปตามสินค้า'),0,"C");
		$pdf->Ln(1.0);
	$pdf->Cell(3.0,2.0,iconv('UTF-8','cp874','ระหว่างวันที่ :'),0,"C");
	$pdf->Cell(2.2,2.0,iconv('UTF-8','cp874',$newDate),0,"C");
	$pdf->Cell(0.6,2.0,iconv('UTF-8','cp874','ถึง'),0,"C");
	$pdf->Cell(2.0,2.0,iconv('UTF-8','cp874',$newDate1),0,"C");
	$pdf->Ln(1.0);

$strSQL = "SELECT * FROM tb_salechannel WHERE salechannel_ID = '".$_GET["sale_channel"]."' ";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);

$salechannel_nameshort=$objResult["salechannel_nameshort"];


$pdf->SetTextColor(255,0,0);
	$pdf->Cell(2.0,2.0,iconv('UTF-8','cp874',$salechannel_nameshort),0,"C");
	$pdf->Cell(10.0,2.0,iconv('UTF-8','cp874',''),0,"C");
	$pdf->Cell(1.8,2.0,iconv('UTF-8','cp874',$sale_count_2),0,"C");
	$pdf->Cell(1.5,2.0,iconv('UTF-8','cp874',''),0,"C");
	$pdf->Cell(2.0,2.0,iconv('UTF-8','cp874',$amount_23),0,"C");
	$pdf->Cell(1.5,2.0,iconv('UTF-8','cp874','บาท'),0,"C");
	$pdf->Ln(0.2);
	$pdf->Cell(19.5,1.2,iconv('UTF-8','cp874',''),0,"C");
	$pdf->Ln(1.0);


	$sql = "SELECT distinct product_code,sol_code,sol_name FROM ((((so__main LEFT JOIN  tb_salechannel ON so__main.sale_channel=tb_salechannel.salechannel_ID)LEFT JOIN tb_delivery ON so__main.delivery=tb_delivery.delivery_ID)LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd)LEFT JOIN tb_product ON so__submain.product_ID=tb_product.product_id) where 1 ";	


	if($start_date !=""){ 
    $sql .= ' AND register_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $sql .= ' AND register_date <= "'.$end_date.'"'; 
}

if($sale_channel !=""){ 
    $sql .= ' AND sale_channel = "'.$sale_channel.'"'; 
}


$query = mysqli_query($conn,$sql) or die(mysqli_error());



	while($result = mysqli_fetch_array($query)){

	
$product_code=$result["product_code"];
	
$sol_code=$result["sol_code"];
$product_name=$result["sol_name"];




$strSQL3 = "SELECT SUM(sum_amount) AS amount_3 FROM (((so__main LEFT JOIN  tb_salechannel ON so__main.sale_channel=tb_salechannel.salechannel_ID)LEFT JOIN tb_delivery ON so__main.delivery=tb_delivery.delivery_ID)LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) where  product_code='".$product_code."'";
	


	if($start_date !=""){ 
    $strSQL3 .= ' AND register_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL3 .= ' AND register_date <= "'.$end_date.'"'; 
}

if($sale_channel !=""){ 
    $strSQL3 .= ' AND sale_channel = "'.$sale_channel.'"'; 
}
//echo $strSQL1;
//exit();
$objQuery3 = mysqli_query($conn,$strSQL3);
$objResult3= mysqli_fetch_array($objQuery3);

$summary_3=$objResult3['amount_3'];
$summary3= number_format( $summary_3,2)."";


$strSQL4 = "SELECT SUM(sale_count) AS sale_count4  FROM (((so__main LEFT JOIN  tb_salechannel ON so__main.sale_channel=tb_salechannel.salechannel_ID)LEFT JOIN tb_delivery ON so__main.delivery=tb_delivery.delivery_ID)LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) where  product_code='".$product_code."'";
	


	if($start_date !=""){ 
    $strSQL4 .= ' AND register_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL4 .= ' AND register_date <= "'.$end_date.'"'; 
}

if($sale_channel !=""){ 
    $strSQL4 .= ' AND sale_channel = "'.$sale_channel.'"'; 
}
//echo $strSQL1;
//exit();
$objQuery4 = mysqli_query($conn,$strSQL4);
$objResult4= mysqli_fetch_array($objQuery4);


$sale_count_4=$objResult4['sale_count4'];
$sale_count4= number_format( $sale_count_4,2)."";



 $pdf->SetFont('angsana','B',14);



	$pdf->SetTextColor(0,0,255);
	$pdf->Cell(2.0,2.0,iconv('UTF-8','cp874',$product_name),0,"C");
		$pdf->Cell(10.0,2.0,iconv('UTF-8','cp874',''),0,"C");
	$pdf->Cell(1.8,2.0,iconv('UTF-8','cp874',$sale_count4),0,"C");
		$pdf->Cell(1.5,2.0,iconv('UTF-8','cp874',''),0,"C");
	$pdf->Cell(2.0,2.0,iconv('UTF-8','cp874',$summary3),0,"C");
		$pdf->Cell(1.5,2.0,iconv('UTF-8','cp874','บาท'),0,"C");
			

$pdf->Ln(0.8);

	

}




	$pdf->SetTextColor(255,0,255);


	$pdf->Cell(2.0,2.0,iconv('UTF-8','cp874','รวมทั้งหมด :'),0,"C");
	$pdf->Cell(10.0,2.0,iconv('UTF-8','cp874',''),0,"C");
	$pdf->Cell(1.8,2.0,iconv('UTF-8','cp874',$sale_count_2),0,"C");
	$pdf->Cell(1.5,2.0,iconv('UTF-8','cp874',''),0,"C");
	$pdf->Cell(2.0,2.0,iconv('UTF-8','cp874',$amount_23),0,"C");
	$pdf->Cell(1.5,2.0,iconv('UTF-8','cp874','บาท'),0,"C");
	$pdf->Ln(0.5);




	$pdf->Output();



?>