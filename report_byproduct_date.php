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

$date = explode('-' , $_GET["start_date"] );
$newDate = $date[2].'-'.$date[1].'-'.$date[0];
$date1 = explode('-' , $_GET["end_date"] );
$newDate1 = $date1[2].'-'.$date1[1].'-'.$date1[0];


$pdf->SetFont('angsana','B',18);
		$pdf->Cell(4.0,2.0,iconv('UTF-8','cp874','รายงานสรุปตามสินค้า'),0,"C");
		$pdf->Ln(1.0);
	$pdf->Cell(2.0,2.0,iconv('UTF-8','cp874','ณ วันที่:'),0,"C");
	$pdf->Cell(2.0,2.0,iconv('UTF-8','cp874',$newDate),0,"C");


$pdf->Ln(1.0);


	$sql = "SELECT distinct product_code,sol_code,access_name FROM ((so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd)LEFT JOIN tb_product ON so__submain.product_ID=tb_product.product_id) where 1 ";
	


	if($start_date !=""){ 
    $sql .= ' AND register_date = "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $sql .= ' AND delivery_date = "'.$end_date.'"'; 
}


$query = mysqli_query($conn,$sql) or die(mysqli_error());



	while($result = mysqli_fetch_array($query)){

$product_code=$result["product_code"];
	
$sol_code=$result["sol_code"];
$product_name=$result["access_name"];

/*$salechannel_nameshort=$result["salechannel_nameshort"];
$sale_channel =$result["sale_channel"];
$pdf->Ln(0.5);
$pdf->Cell(8.0,1.2,iconv('UTF-8','cp874',''),B,"C");
$pdf->Ln(0.2);*/

$pdf->SetFont('angsana','B',16);

$pdf->SetTextColor(255,0,0);
		$pdf->Cell(9.0,2.0,iconv('UTF-8','cp874',$product_name),0,"C");
				
$pdf->Ln(0.2);
				$pdf->Cell(10.0,1.2,iconv('UTF-8','cp874',''),0,"C");
				$pdf->Ln(1.0);



$sql2 = "SELECT distinct salechannel_nameshort,sale_channel,salechannel_name FROM (so__main LEFT JOIN  tb_salechannel ON so__main.sale_channel=tb_salechannel.salechannel_ID) where 1 ";
	


	if($start_date !=""){ 
    $sql2 .= ' AND register_date = "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $sql2 .= ' AND delivery_date = "'.$end_date.'"'; 
}


$query2 = mysqli_query($conn,$sql2) or die(mysqli_error());



	while($result2 = mysqli_fetch_array($query2)){

$salechannel_nameshort=$result2["salechannel_nameshort"];
$sale_channel =$result2["sale_channel"];
$salechannel_name = $result2["salechannel_name"];
$sum_salechannel = "$salechannel_nameshort $salechannel_name";






$sql1 = "SELECT * FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) where sale_channel='".$sale_channel."' and product_code='".$product_code."' ";
	


	if($start_date !=""){ 
    $sql1 .= ' AND register_date = "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $sql1 .= ' AND delivery_date = "'.$end_date.'"'; 
}
//echo $sql1;
//exit();

$query1 = mysqli_query($conn,$sql1) or die(mysqli_error());
	$Num_Rows2 = mysqli_num_rows($query1);


	if($Num_Rows2!=''){

	$pdf->SetFont('angsana','B',16);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(4.0,2.0,iconv('UTF-8','cp874','ช่องทางการขาย :'),0,"C");
	$pdf->Cell(9.0,2.0,iconv('UTF-8','cp874',$sum_salechannel),0,"C");
	$pdf->Ln(1.0);

	$pdf->SetFont('angsana','B',14);
	$pdf->SetTextColor(0,0,0);
		$pdf->Cell(2.0,2.0,iconv('UTF-8','cp874','วันที่'),0,"C");
		$pdf->Cell(1.0,2.0,iconv('UTF-8','cp874','ID'),0,"C");
		$pdf->Cell(4.0,2.0,iconv('UTF-8','cp874','หมายเลขคำสั่งซื้อ'),0,"C");
		$pdf->Cell(5.0,2.0,iconv('UTF-8','cp874','ชื่อลูกค้า'),0,"C");
		$pdf->Cell(1.5,2.0,iconv('UTF-8','cp874','จำนวน'),0,"C");
		$pdf->Cell(1.8,2.0,iconv('UTF-8','cp874','ราคา'),0,"C");
		$pdf->Cell(2.0,2.0,iconv('UTF-8','cp874','รวมเป็นเงิน'),0,"C");
		$pdf->Cell(2.0,2.0,iconv('UTF-8','cp874','เลขที่เอกสาร'),0,"C");
		$pdf->Ln(0.2);

		$pdf->Cell(19.5,1.2,iconv('UTF-8','cp874',''),0,"C");


$pdf->Ln(0.5);


	while($result1 = mysqli_fetch_array($query1)){

	

$register_date=$result1["register_date"];
$ref_id=$result1["ref_id"];
$order_id=$result1["order_id"];

if($result1["order_name"]==''){
	$customer_name=$result1["customer_name"];
}else{
$customer_name=$result1["order_name"];
}

//$product_name=$result1["product_name"];
$sale_count=$result1["sale_count"];
$price_per_unit1=$result1["price_per_unit"];

$price_per_unit= number_format( $price_per_unit1,2)."";

$sum_amount1=$result1["sum_amount"];
$sum_amount= number_format( $sum_amount1,2)."";

$doc_no=$result1["doc_no"];
$delivery_name=$result1["delivery_name"];


$pdf->SetFont('angsa','',14);

	$pdf->Cell(2.0,2.0,iconv('UTF-8','cp874',$register_date),0,"C");
	$pdf->Cell(1.0,2.0,iconv('UTF-8','cp874',$ref_id),0,"C");
	$pdf->Cell(4.0,2.0,iconv('UTF-8','cp874',$order_id),0,"C");
	$pdf->Cell(5.0,2.0,iconv('UTF-8','cp874',$customer_name),0,"C");
	$pdf->Cell(1.5,2.0,iconv('UTF-8','cp874',$sale_count),0,"C");
	$pdf->Cell(1.8,2.0,iconv('UTF-8','cp874',$price_per_unit),0,"C");
	$pdf->Cell(2.0,2.0,iconv('UTF-8','cp874',$sum_amount),0,"C");
	$pdf->Cell(2.0,2.0,iconv('UTF-8','cp874',$doc_no),0,"C");
	$pdf->Ln(0.2);
	$pdf->Cell(19.5,1.2,iconv('UTF-8','cp874',''),0,"C");
	$pdf->Ln(0.5);







	}

$strSQL1 = "SELECT SUM(sum_amount) AS amount_1 FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) where sale_channel='".$sale_channel."' and product_code='".$product_code."'";
	


	if($start_date !=""){ 
    $strSQL1 .= ' AND register_date = "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL1 .= ' AND delivery_date = "'.$end_date.'"'; 
}
//echo $strSQL1;
//exit();
$objQuery1 = mysqli_query($conn,$strSQL1);
$objResult1= mysqli_fetch_array($objQuery1);

$summary_1=$objResult1['amount_1'];
$summary= number_format( $summary_1,2)."";


$strSQL2 = "SELECT SUM(sale_count) AS sale_count  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) where sale_channel='".$sale_channel."' and product_code='".$product_code."'";
	


	if($start_date !=""){ 
    $strSQL2 .= ' AND register_date = "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL2 .= ' AND delivery_date = "'.$end_date.'"'; 
}
//echo $strSQL1;
//exit();
$objQuery2 = mysqli_query($conn,$strSQL2);
$objResult2= mysqli_fetch_array($objQuery2);


$sale_count1=$objResult2['sale_count'];
$sale_count= number_format( $sale_count1,2)."";

 $pdf->SetFont('angsana','B',14);
	$pdf->SetTextColor(0,0,255);
	$pdf->Cell(2.0,2.0,iconv('UTF-8','cp874','รวมตามช่องทางการขาย :'),0,"C");
		$pdf->Cell(10.0,2.0,iconv('UTF-8','cp874',''),0,"C");
	$pdf->Cell(1.8,2.0,iconv('UTF-8','cp874',$sale_count),0,"C");
		$pdf->Cell(1.5,2.0,iconv('UTF-8','cp874',''),0,"C");
	$pdf->Cell(2.0,2.0,iconv('UTF-8','cp874',$summary),0,"C");
		$pdf->Cell(1.5,2.0,iconv('UTF-8','cp874','บาท'),0,"C");
$pdf->Ln(0.6);

	}














	}


$strSQL3 = "SELECT SUM(sum_amount) AS amount_3 FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) where  product_code='".$product_code."'";
	


	if($start_date !=""){ 
    $strSQL3 .= ' AND register_date = "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL3 .= ' AND delivery_date = "'.$end_date.'"'; 
}
//echo $strSQL1;
//exit();
$objQuery3 = mysqli_query($conn,$strSQL3);
$objResult3= mysqli_fetch_array($objQuery3);

$summary_3=$objResult3['amount_3'];
$summary3= number_format( $summary_3,2)."";


$strSQL4 = "SELECT SUM(sale_count) AS sale_count4  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) where  product_code='".$product_code."'";
	


	if($start_date !=""){ 
    $strSQL4 .= ' AND register_date = "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL4 .= ' AND delivery_date = "'.$end_date.'"'; 
}
//echo $strSQL1;
//exit();
$objQuery4 = mysqli_query($conn,$strSQL4);
$objResult4= mysqli_fetch_array($objQuery4);


$sale_count_4=$objResult4['sale_count4'];
$sale_count4= number_format( $sale_count_4,2)."";

 $pdf->SetFont('angsana','B',14);
	$pdf->SetTextColor(255,0,0);
	$pdf->Cell(2.0,2.0,iconv('UTF-8','cp874','รวมรายการสินค้า :'),0,"C");
		$pdf->Cell(10.0,2.0,iconv('UTF-8','cp874',''),0,"C");
	$pdf->Cell(1.8,2.0,iconv('UTF-8','cp874',$sale_count4),0,"C");
		$pdf->Cell(1.5,2.0,iconv('UTF-8','cp874',''),0,"C");
	$pdf->Cell(2.0,2.0,iconv('UTF-8','cp874',$summary3),0,"C");
		$pdf->Cell(1.5,2.0,iconv('UTF-8','cp874','บาท'),0,"C");
$pdf->Ln(1.5);

	}

$strSQL3 = "SELECT SUM(sale_count) AS sale_count_1 FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) where 1 ";
	


	if($start_date !=""){ 
    $strSQL3 .= ' AND register_date = "'.$start_date.'"'; 
	}

	if($end_date !=""){ 
    $strSQL3 .= ' AND delivery_date = "'.$end_date.'"'; 
	}

//echo $strSQL3;
//exit();

	$objQuery3 = mysqli_query($conn,$strSQL3);
	$objResult3= mysqli_fetch_array($objQuery3);

	$sale_count2=$objResult3['sale_count_1'];
	$sale_count_2= number_format( $sale_count2,2)."";


$strSQL4 = "SELECT SUM(sum_amount) AS amount_2 FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) where 1 ";
	


	if($start_date !=""){ 
    $strSQL4 .= ' AND register_date = "'.$start_date.'"'; 
	}

	if($end_date !=""){ 
    $strSQL4 .= ' AND delivery_date = "'.$end_date.'"'; 
	}

//echo $strSQL3;
//exit();

	$objQuery4 = mysqli_query($conn,$strSQL4);
	$objResult4= mysqli_fetch_array($objQuery4);

	$amount_2=$objResult4['amount_2'];
	$amount_23= number_format( $amount_2,2)."";

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