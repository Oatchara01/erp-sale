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
		$pdf->Cell(4.0,2.0,iconv('UTF-8','cp874','สรุปจำนวนลูกค้า'),0,"C");
		$pdf->Ln(0.2);
$pdf->Cell(5.0,1.2,iconv('UTF-8','cp874',''),0,"C");
$pdf->Ln(1.0);

	$pdf->Cell(3.0,2.0,iconv('UTF-8','cp874','วันที่ลงงาน:'),0,"C");
	$pdf->Cell(2.2,2.0,iconv('UTF-8','cp874',$newDate),0,"C");
		$pdf->Cell(0.6,2.0,iconv('UTF-8','cp874','ถึง'),0,"C");
			$pdf->Cell(2.0,2.0,iconv('UTF-8','cp874',$newDate1),0,"C");



$pdf->Ln(1.0);


	$sql = "SELECT distinct salechannel_nameshort,sale_channel FROM ((so__main LEFT JOIN  tb_salechannel ON so__main.sale_channel=tb_salechannel.salechannel_ID)LEFT JOIN tb_delivery ON so__main.delivery=tb_delivery.delivery_ID) where 1 ";
	


	if($start_date !=""){ 
    $sql .= ' AND register_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $sql .= ' AND register_date <= "'.$end_date.'"'; 
}


$query = mysqli_query($conn,$sql) or die(mysqli_error());



	while($result = mysqli_fetch_array($query)){

	

$salechannel_nameshort=$result["salechannel_nameshort"];
$sale_channel =$result["sale_channel"];

$pdf->SetFont('angsana','B',16);


	$pdf->SetTextColor(0,0,255);

$pdf->Cell(0.5,2.0,iconv('UTF-8','cp874',''),0,"C");
		$pdf->Cell(9.0,2.0,iconv('UTF-8','cp874',$salechannel_nameshort),0,"C");
				$pdf->Ln(1.0);

$pdf->SetFont('angsana','B',14);
	$pdf->SetTextColor(0,0,0);
		$pdf->Cell(1.5,2.0,iconv('UTF-8','cp874','ID'),0,"C");	
		$pdf->Cell(2.3,2.0,iconv('UTF-8','cp874','วันที่ลงงาน'),0,"C");
		$pdf->Cell(2.3,2.0,iconv('UTF-8','cp874','วันที่ส่ง'),0,"C");
		$pdf->Cell(6.0,2.0,iconv('UTF-8','cp874','ชื่อที่ต้องการออกบิล'),0,"C");
		$pdf->Cell(5.0,2.0,iconv('UTF-8','cp874','การจัดส่ง'),0,"C");
		$pdf->Cell(2.0,2.0,iconv('UTF-8','cp874','เลขที่เอกสาร'),0,"C");
		$pdf->Ln(0.2);

		$pdf->Cell(19.5,1.2,iconv('UTF-8','cp874',''),0,"C");


$pdf->Ln(0.5);


$pdf->SetFont('angsa','',14);

$sql1 = "SELECT * FROM ((so__main LEFT JOIN  tb_salechannel ON so__main.sale_channel=tb_salechannel.salechannel_ID)LEFT JOIN tb_delivery ON so__main.delivery=tb_delivery.delivery_ID) where sale_channel='".$sale_channel."'  ";
	


	if($start_date !=""){ 
    $sql1 .= ' AND register_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $sql1 .= ' AND register_date <= "'.$end_date.'"'; 
}
//echo $sql1;
//exit();

$query1 = mysqli_query($conn,$sql1) or die(mysqli_error());



	while($result1 = mysqli_fetch_array($query1)){

$date2 = explode('-' ,$result1["register_date"] );
$register_date = $date2[2].'-'.$date2[1].'-'.$date2[0];

if($result1["delivery_date"]!=''){
$date3 = explode('-' , $result1["delivery_date"] );
$delivery_date = $date3[2].'-'.$date3[1].'-'.$date3[0];
}else{
$delivery_date ='00-00-0000';
}


$ref_id=$result1["ref_id"];
$order_id=$result1["order_id"];
$billing_name=$result1["billing_name"];
$doc_no=$result1["doc_no"];
$delivery_name=$result1["delivery_name"];




	$pdf->Cell(1.5,2.0,iconv('UTF-8','cp874',$ref_id),0,"C");
	$pdf->Cell(2.3,2.0,iconv('UTF-8','cp874',$register_date),0,"C");

	$pdf->Cell(2.3,2.0,iconv('UTF-8','cp874',$delivery_date),0,"C");
	$pdf->Cell(6.0,2.0,iconv('UTF-8','cp874',$billing_name),0,"C");
	$pdf->Cell(5.0,2.0,iconv('UTF-8','cp874',$delivery_name),0,"C");
	$pdf->Cell(2.0,2.0,iconv('UTF-8','cp874',$doc_no),0,"C");
	$pdf->Ln(0.2);
	$pdf->Cell(19.5,1.2,iconv('UTF-8','cp874',''),0,"C");
	$pdf->Ln(0.5);







	}



$strSQL2 = "SELECT *  FROM so__main  where sale_channel='".$sale_channel."' ";
	


	if($start_date !=""){ 
    $strSQL2 .= ' AND register_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL2 .= ' AND register_date <= "'.$end_date.'"'; 
}
//echo $strSQL2;
//exit();
	$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
	$Num_Rows2 = mysqli_num_rows($objQuery2);

$resultData2 = array();
for ($i=0;$i<mysqli_num_rows($objQuery2);$i++) {
	$result2 = mysqli_fetch_array($objQuery2);
	array_push($resultData2,$result2);
	}





$sale= count($resultData2);
 $pdf->SetFont('angsana','B',14);
	$pdf->SetTextColor(0,0,255);
	$pdf->Cell(4.3,2.0,iconv('UTF-8','cp874','สรุปจำนวนลูกค้า "ตามวันที่" ='),0,"C");
		$pdf->Cell(1.6,2.0,iconv('UTF-8','cp874',$newDate),0,"C");
			$pdf->Cell(0.2,2.0,iconv('UTF-8','cp874','-'),0,"C");
	$pdf->Cell(1.6,2.0,iconv('UTF-8','cp874',$newDate1),0,"C");

		$pdf->Cell(0.2,2.0,iconv('UTF-8','cp874','('),0,"C");
	$pdf->Cell(0.6,2.0,iconv('UTF-8','cp874',$sale),0,"C");
	$pdf->Cell(0.6,2.0,iconv('UTF-8','cp874','ราย'),0,"C");
			$pdf->Cell(0.2,2.0,iconv('UTF-8','cp874',')'),0,"C");


$pdf->Ln(1.5);

	




	}

$strSQL3 = "SELECT * FROM  so__main  where 1 ";
	


	if($start_date !=""){ 
    $strSQL3 .= ' AND register_date >= "'.$start_date.'"'; 
	}

	if($end_date !=""){ 
    $strSQL3 .= ' AND register_date <= "'.$end_date.'"'; 
	}

//echo $strSQL3;
//exit();

	$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
	$Num_Rows3 = mysqli_num_rows($objQuery3);


$resultData3 = array();
for ($i=0;$i<mysqli_num_rows($objQuery3);$i++) {
	$result3 = mysqli_fetch_array($objQuery3);
	array_push($resultData3,$result3);
	}

$sal3= count($resultData3);


	$pdf->SetTextColor(255,0,0);


    $pdf->Cell(4.3,2.0,iconv('UTF-8','cp874','สรุปจำนวนลูกค้า "ตามวันที่" ='),0,"C");
	$pdf->Cell(1.6,2.0,iconv('UTF-8','cp874',$newDate),0,"C");
	$pdf->Cell(0.2,2.0,iconv('UTF-8','cp874','-'),0,"C");
	$pdf->Cell(1.6,2.0,iconv('UTF-8','cp874',$newDate1),0,"C");
	$pdf->Cell(0.2,2.0,iconv('UTF-8','cp874','('),0,"C");
	$pdf->Cell(0.6,2.0,iconv('UTF-8','cp874',$sal3),0,"C");
	$pdf->Cell(0.6,2.0,iconv('UTF-8','cp874','ราย'),0,"C");
	$pdf->Cell(0.2,2.0,iconv('UTF-8','cp874',')'),0,"C");
	$pdf->Ln(1.5);
	$pdf->SetTextColor(0,0,0);

	$pdf->Cell(4.0,2.0,iconv('UTF-8','cp874','รวมลูกค้าทั้งหมด :'),0,"C");
	$pdf->Cell(2.0,2.0,iconv('UTF-8','cp874',$sal3),0,"C");
	$pdf->Cell(0.6,2.0,iconv('UTF-8','cp874','ราย'),0,"C");



	$pdf->Output();



?>