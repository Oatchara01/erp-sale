<?php
date_default_timezone_set("Asia/Bangkok");
define('FPDF_FONTPATH','font/');
require('fpdf.php');



$customer_name = $_GET["customer_name"];
$sale_code = $_GET["sale_code"];

function DateThai($strDate)
	{
		$strYear = date("Y",strtotime($strDate))+543;
		$strMonth= date("n",strtotime($strDate));
		$strDay= date("j",strtotime($strDate));
		$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		$strMonthThai=$strMonthCut[$strMonth];
		return "$strDay $strMonthThai $strYear";
	}

function cutStr($str, $maxChars='', $holder=''){

    if (strlen($str) > $maxChars ){
			$str = iconv_substr($str, 0, $maxChars,"UTF-8") . $holder;
	} 
	return $str;
} 	
class PDF extends FPDF
{

function Header(){
	$this->Ln(5);	
	$this->SetFillColor(204,204,204);
			$this->SetFont('angsa','B',16);
			$this->Cell(100,6,iconv('UTF-8','cp874','รายงานสรุปการยืมสินค้า'),0,0,"L",true);
			$this->Cell(100,6,iconv('UTF-8','cp874','บริษัท ออลล์เวล ไลฟ์ จำกัด'),0,0,"R",true);
			$this->MultiCell(1,6,iconv('UTF-8','cp874',''),0,0,"R",true);
			$this->Cell(200,0,iconv('UTF-8','cp874',''),1,"L");
			$this->Ln(5);			

		}

		function Footer(){
			$add_date1 = date('Y-m-d');
			$add_date2 = Datethai($add_date1);
            $time = date('H:i:s');
			$add_date = "$add_date2 $time";


			$this->AddFont('angsa','','angsa.php');
			$this->SetTextColor(0,0,0);
			$this->SetFont('angsa','',12);
			$this->SetY(-3);
			$this->Cell(0,0,iconv( 'UTF-8','TIS-620',$add_date),0,1,"L");
			$this->Cell(0,0,iconv( 'UTF-8','TIS-620','หน้า '.$this->PageNo()),0,1,"R");

			
		}
function LoadData($file)
{
	//Read file lines
	$lines=file($file);
	$data=array();
	foreach($lines as $line)
		$data[]=explode(';',chop($line));
	return $data;
}

//Simple table
function BasicTable()
{	
include "dbconnect.php";
include "dbconnect_sale.php";


$customer_name = $_GET["customer_name"];
$sale_code = $_GET["sc"];
//$pieces = explode(" ", $sale_code);
//$sc_code = $pieces[0];
//$sc_name = $pieces[1];

if($sale_code !=''){
	
$strSQL1 = "SELECT distinct sale_code,sale FROM hos__br WHERE close_br ='0' and status_doc='Approve' ";

if($customer_name !=""){ 
	$strSQL1 .= ' AND customer  LIKE "%'.$customer_name.'%"'; 

}
if($sale_code !=""){ 
	$strSQL1 .= ' AND sale_code  LIKE "%'.$sale_code.'%"'; 
	
}
	
	
$objQuery1 = mysqli_query($conn,$strSQL1);
while($objResult1 = mysqli_fetch_array($objQuery1)){

$this->Ln(5);
$this->SetFont('angsa','B',16);
$this->SetTextColor(255,0,0);
$this->Cell(30,0,iconv('UTF-8','cp874','รหัสพนักงาน'),0,"L");
$this->Cell(30,0,iconv('UTF-8','cp874',$objResult1["sale_code"]),0,"L");
$this->Cell(70,0,iconv('UTF-8','cp874',$objResult1["sale"]),0,"L");
$this->MultiCell(1,3.0,iconv('UTF-8','cp874',''),0,"R");
$this->Cell(100,0,iconv('UTF-8','cp874',''),1,"L");

$this->MultiCell(1,0.5,iconv('UTF-8','cp874',''),0,"R");
$this->Cell(100,0,iconv('UTF-8','cp874',''),1,"L");
	
	
	
		$this->Ln(6);
		$this->SetTextColor(0,0,0);
		$this->SetFillColor(204,204,204);
		$this->SetFont('angsa','B',14);

		$this->Cell(20,6,iconv('UTF-8','cp874','เลขที่ใบยืม'),0,0,"C",true);
		$this->Cell(20,6,iconv('UTF-8','cp874','วันที่'),0,0,"C",true);
		$this->Cell(60,6,iconv('UTF-8','cp874','ชื่อลูกค้าและสถานที่'),0,0,"C",true);
		$this->Cell(48,6,iconv('UTF-8','cp874','รายการสินค้า'),0,0,"C",true);
		$this->Cell(20,6,iconv('UTF-8','cp874','จำนวน'),0,0,"C",true);
		$this->Cell(37,6,iconv('UTF-8','cp874','หมายเหตุ'),0,0,"C",true);
		$this->MultiCell(1,6,iconv('UTF-8','cp874',''),0,0,"R",true);
			$this->Cell(200,0,iconv('UTF-8','cp874',''),1,"L");


		$this->Ln(10);	
	
//order_id
$strSQL9 = "SELECT iv_no,iv_date,customer,product_id,count,sale_remark FROM (hos__br LEFT JOIN hos__subbr ON hos__br.ref_id_br=hos__subbr.ref_idd_br) WHERE sale = '".$objResult1["sale"]."' and sale_code = '".$objResult1["sale_code"]."' and close_br = '0' and status_doc='Approve'";

if($customer_name !=""){ 
	$strSQL9 .= ' AND customer_name  LIKE "%'.$customer_name.'%"'; 
	
}
$strSQL9 .='order by iv_date DESC';
$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$i = 1;
while($objResult9 = mysqli_fetch_array($objQuery9))
{

$strSQL = "SELECT access_name,unit_name FROM tb_product WHERE product_ID = '".$objResult9["product_id"]."' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$access_name = $objResult["access_name"];
$product_code = substr($access_name,0,30);	

$count_send = $objResult9["count"];
$unit_name = $objResult["unit_name"];	
$unit = "$count_send $unit_name";	
	
$this->SetFont('angsa','',14);
	
		$this->Cell(20,0,iconv('UTF-8','cp874',$objResult9["iv_no"]),0,"L");
		$this->Cell(20,0,iconv('UTF-8','cp874',Datethai($objResult9["iv_date"])),0,"L");
		$this->SetFont('angsa','',11);
		$this->Cell(60,0,iconv('UTF-8//IGNORE','cp874//IGNORE',$objResult9["customer"]),0,"L");
		$this->Cell(48,0,iconv('UTF-8//IGNORE','cp874//IGNORE',$product_code),0,0,"L");
		$this->SetFont('angsa','',13);
		$this->Cell(20,0,iconv('UTF-8','cp874',$unit),0,0,"C");
		$this->SetFont('angsa','',11);
		$this->MultiCell(30,3,iconv('UTF-8','cp874',$objResult9["sale_remark"]),0,"L");

			$this->Cell(200,0,iconv('UTF-8','cp874',''),1,"L");

$this->Ln(6);

}

	$this->Ln(3);
	$this->SetTextColor(0,0,0);
	$this->SetFont('angsa','B',12);
	 $this->Cell(70,6,iconv('UTF-8','cp874',''),0,0,"L");
	 $this->Cell(100,6,iconv('UTF-8','cp874','ได้ทำการตรวจสอบรายการจองสินค้าดังกล่าวข้างต้นว่าถูกต้องเรียบร้อยแล้ว'),0,0,"C");
	  $this->Ln(12);
 $this->Cell(70,6,iconv('UTF-8','cp874',''),0,0,"L");
	$sale = $objResult1["sale"];
	$sale1 = $objResult1["sale_code"];
	$sale_name = "$sale1 $sale";
    $this->Cell(100,6,iconv('UTF-8','cp874',$sale_name),0,0,"C");
	 $this->Ln(5);


 $this->Cell(70,6,iconv('UTF-8','cp874',''),0,0,"L");
    $this->Cell(100,6,iconv('UTF-8','cp874','........./........./.........'),0,0,"C");

$this->Ln(5);
	$this->SetTextColor(0,0,0);
	$this->SetFont('angsa','B',14);
	 $this->Cell(70,6,iconv('UTF-8','cp874',''),0,0,"L");
	 $this->Cell(100,6,iconv('UTF-8','cp874','หากท่านได้คืนสินค้าแล้ว ทางคลังสินค้าต้องขออภัยด้วย'),0,0,"C");

$this->AddPage();
}
	
	


}else{

$strSQL1 = "SELECT sale_code,sale FROM hos__br WHERE close_br = '0' and status_doc='Approve' ";

if($customer_name !=""){ 
	$strSQL1 .= ' AND customer  LIKE "%'.$customer_name.'%"'; 
}
//echo $strSQL1;
$objQuery1 = mysqli_query($conn,$strSQL1);
while($objResult1 = mysqli_fetch_array($objQuery1)){

//echo $objResult1["sale_code"];	
	
$this->Ln(5);
$this->SetFont('angsa','B',16);
$this->SetTextColor(255,0,0);
$this->Cell(30,0,iconv('UTF-8','cp874','รหัสพนักงาน'),0,"L");
$this->Cell(30,0,iconv('UTF-8','cp874',$objResult1["sale_code"]),0,"L");
$this->Cell(70,0,iconv('UTF-8','cp874',$objResult1["sale_name"]),0,"L");
$this->MultiCell(1,3.0,iconv('UTF-8','cp874',''),0,"R");
$this->Cell(100,0,iconv('UTF-8','cp874',''),1,"L");

$this->MultiCell(1,0.5,iconv('UTF-8','cp874',''),0,"R");
$this->Cell(100,0,iconv('UTF-8','cp874',''),1,"L");
	
	
	
		$this->Ln(6);
		$this->SetTextColor(0,0,0);
		$this->SetFillColor(204,204,204);
		$this->SetFont('angsa','B',14);

		$this->Cell(20,6,iconv('UTF-8','cp874','เลขที่ใบยืม'),0,0,"C",true);
		$this->Cell(20,6,iconv('UTF-8','cp874','วันที่'),0,0,"C",true);
		$this->Cell(60,6,iconv('UTF-8','cp874','ชื่อลูกค้าและสถานที่'),0,0,"C",true);
		$this->Cell(48,6,iconv('UTF-8','cp874','รายการสินค้า'),0,0,"C",true);
		$this->Cell(20,6,iconv('UTF-8','cp874','จำนวน'),0,0,"C",true);
		$this->Cell(37,6,iconv('UTF-8','cp874','หมายเหตุ'),0,0,"C",true);
		$this->MultiCell(1,6,iconv('UTF-8','cp874',''),0,0,"R",true);
			$this->Cell(200,0,iconv('UTF-8','cp874',''),1,"L");


		$this->Ln(10);	
	
	
$strSQL9 = "SELECT iv_no,iv_date,customer,product_id,count,sale_remark FROM (hos__br LEFT JOIN hos__subbr ON hos__br.ref_id_br=hos__subbr.ref_idd_br) WHERE sale = '".$objResult1["sale"]."' and sale_code = '".$objResult1["sale_code"]."' and close_br = '0' and status_doc='Approve'";

if($customer_name !=""){ 
	$strSQL9 .= ' AND customer LIKE "%'.$customer_name.'%"'; 
	
}
$strSQL9 .='order by iv_date DESC';

$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$i = 1;
while($objResult9 = mysqli_fetch_array($objQuery9))
{

$strSQL = "SELECT access_name,unit_name FROM tb_product WHERE product_ID = '".$objResult9["product_id"]."' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);

$access_name = $objResult["access_name"];
$product_code = substr($access_name,0,30);	

$count_send = $objResult9["count"];
$unit_name = $objResult["unit_name"];	
$unit = "$count_send $unit_name";	
	
$this->SetFont('angsa','',14);
	
		$this->Cell(20,0,iconv('UTF-8','cp874',$objResult9["iv_no"]),0,"L");
		$this->Cell(20,0,iconv('UTF-8','cp874',Datethai($objResult9["iv_date"])),0,"L");
		$this->SetFont('angsa','',11);
		$this->Cell(60,0,iconv('UTF-8//IGNORE','cp874//IGNORE',$objResult9["customer"]),0,"L");
		$this->Cell(48,0,iconv('UTF-8//IGNORE','cp874//IGNORE',$product_code),0,0,"L");
		$this->SetFont('angsa','',13);
		$this->Cell(20,0,iconv('UTF-8','cp874',$unit),0,0,"C");
		$this->SetFont('angsa','',11);
		$this->MultiCell(40,3,iconv('UTF-8','cp874',$objResult9["sale_remark"]),0,"L");

			$this->Cell(200,0,iconv('UTF-8','cp874',''),1,"L");

$this->Ln(6);

}
	
	$this->Ln(3);
	$this->SetTextColor(0,0,0);
	$this->SetFont('angsa','B',12);
	 $this->Cell(70,6,iconv('UTF-8','cp874',''),0,0,"L");
	 $this->Cell(100,6,iconv('UTF-8','cp874','ได้ทำการตรวจสอบรายการจองสินค้าดังกล่าวข้างต้นว่าถูกต้องเรียบร้อยแล้ว'),0,0,"C");
	  $this->Ln(12);
 $this->Cell(70,6,iconv('UTF-8','cp874',''),0,0,"L");
	$sale = $objResult1["sale"];
	$sale1 = $objResult1["sale_code"];
	$sale_name = "$sale1 $sale";
    $this->Cell(100,6,iconv('UTF-8','cp874',$sale_name),0,0,"C");
	 $this->Ln(5);
	
 $this->Cell(70,6,iconv('UTF-8','cp874',''),0,0,"L");
    $this->Cell(100,6,iconv('UTF-8','cp874','........./........./.........'),0,0,"C");

$this->Ln(5);
	$this->SetTextColor(0,0,0);
	$this->SetFont('angsa','B',14);
	 $this->Cell(70,6,iconv('UTF-8','cp874',''),0,0,"L");
	 $this->Cell(100,6,iconv('UTF-8','cp874','หากท่านได้คืนสินค้าแล้ว ทางคลังสินค้าต้องขออภัยด้วย'),0,0,"C");

$this->AddPage();
	
	
}
	}
}
}


$pdf=new PDF( 'L' , 'mm' , 'A5' );

$pdf->AddFont('angsa','','angsa.php');
$pdf->AddFont('angsa','B','angsab.php');
$pdf->AddFont('angsa','I','angsai.php');
$pdf->AddFont('angsa','BI','angsaz.php');
$pdf->SetFont('angsa','',12);
$pdf->AddPage();
$pdf->BasicTable();
$pdf->Output();
