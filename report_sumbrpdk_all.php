<?php
date_default_timezone_set("Asia/Bangkok");
define('FPDF_FONTPATH','font/');
require('fpdf.php');





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

	


			$this->AddFont('angsa','','angsa.php');
	
			$this->Ln(5);	
	$this->SetTextColor(0,0,0);
			$this->SetFont('angsa','B',16);
			$this->Cell(0,0,iconv( 'UTF-8','TIS-620','รายงานสรุปการยืมสินค้า'),0,1,"C");
					
			$this->Ln(10);	
			
		}

		
		function Footer(){
			$this->AddFont('angsa','','angsa.php');
			$this->SetFont('angsa','',12);

			$start_date1 = date('Y-m-d');
			$start_date = Datethai($start_date1);
			$time = date('H:i:s');
			$today = "$start_date $time";

			$this->SetY(-5);
			$this->Cell(0,0,iconv( 'UTF-8','TIS-620',$today),0,1,"L");
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

$strSQL5 = "SELECT DISTINCT product_id  FROM st__sbmain where sh_ckk='1' and type_doc = '3' ";	
$strSQL5 .=" order  by date_st ASC  ";
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$Num_Rows5 = mysqli_num_rows($objQuery5);


while($objResult5 = mysqli_fetch_array($objQuery5))
{	
$h_product_code = $objResult5["product_id"];	

$strSQL1 = "SELECT access_code,access_name,sol_code,group1,unit_name,product_ID FROM tb_product WHERE product_ID = '".$h_product_code."' ";
$objQuery1 = mysqli_query($conn,$strSQL1);
$objResult1 = mysqli_fetch_array($objQuery1);

$this->SetFont('angsa','B',16);
/*$this->SetTextColor(255,0,0);
$this->Cell(0,0,iconv( 'UTF-8','TIS-620',$objResult1['group1']),0,1,"C");*/

		$this->Ln(6);
$this->SetFont('angsa','B',14);
$this->SetTextColor(255,0,0);
$this->Cell(50,0,iconv( 'UTF-8','TIS-620',$objResult1['access_code']),0,1,"C");
$this->Cell(200,0,iconv( 'UTF-8','cp874',$objResult1['access_name']),0,1,"C");
$this->Cell(350,0,iconv( 'UTF-8','cp874',$objResult1['sol_code']),0,1,"C");
		$this->Ln(6);
			//หัวตาราง
		$this->SetFillColor(204,204,204);
		$this->SetFont('angsa','B',12);
$this->SetTextColor(0,0,0);
		$this->Cell(10,6,iconv('UTF-8','cp874','วันที่'),0,0,"C",true);
		$this->Cell(40,6,iconv('UTF-8','cp874','เลขที่เอกสาร'),0,0,"C",true);
		$this->Cell(60,6,iconv('UTF-8','cp874','ชื่อลูกค้า'),0,0,"C",true);
		$this->Cell(30,6,iconv('UTF-8','cp874','จำนวนจ่าย'),0,0,"C",true);
		$this->Cell(30,6,iconv('UTF-8','cp874','หมายเหตุ'),0,0,"C",true);
		$this->Cell(20,6,iconv('UTF-8','cp874','รหัสผู้ยืม'),0,0,"C",true);
		$this->MultiCell(5,6,iconv('UTF-8','cp874',''),0,0,"L");


$this->Cell(195,0,iconv('UTF-8','cp874',''),1,"L");




		$this->Ln(3);	
	
$strSQL = "SELECT date_st,count_send,ref_idd,stock_remark  FROM st__sbmain where sh_ckk='1' and type_doc = '3' and product_id = '".$h_product_code."'";	
$strSQL .=" order  by date_st ASC  ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);


while($objResult = mysqli_fetch_array($objQuery))
{
	
$strSQL2 = "SELECT  iv_no,customer_name,sale_code,sale_name  FROM st__main  where  ref_id ='".$objResult["ref_idd"]."' ";	
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$Num_Rows2 = mysqli_num_rows($objQuery2);
$objResult2 = mysqli_fetch_array($objQuery2);

$strSQL3 = "SELECT unit_name FROM tb_product WHERE product_ID = '".$h_product_code."' ";
$objQuery3 = mysqli_query($conn,$strSQL3);
$objResult3 = mysqli_fetch_array($objQuery3);
	
$count_send = $objResult["count_send"];
$unit_name = $objResult3["unit_name"];
$sum = "$count_send $unit_name";	
$sale_code	= $objResult2["sale_code"];
$sale_name	= $objResult2["sale_name"];	
$sale = "$sale_name($sale_code)";

if($sale_code=='SOL3' or $sale_code=='(SOL1)' or $sale_code=='(SOL2)'){

	$this->SetFont('angsa','',12);
	$this->Cell(1,6,iconv('UTF-8','cp874',''),0,"L");
	$this->Cell(20,6,iconv('UTF-8','cp874',DateThai($objResult["date_st"])),0,"L");
	$this->Cell(20,6,iconv('UTF-8','cp874',$objResult2["iv_no"]),0,"L");
	$this->Cell(80,6,iconv('UTF-8','cp874',$objResult2["customer_name"]),0,"L");
	$this->Cell(20,6,iconv('UTF-8','cp874',$sum),0,"R");
	$this->Cell(30,6,iconv('UTF-8','cp874',$objResult["stock_remark"]),0,"R");
	$this->MultiCell(20,6,iconv('UTF-8','cp874',$sale),0,"R");

$this->Cell(200,0,iconv('UTF-8','cp874',''),1,"L");
$this->Ln(2);
	
}
}
	
$strSQL9 = "SELECT SUM(count_send) AS sum_count  FROM st__sbmain where  type_doc = '3' and sh_ckk='1' and product_id = '".$h_product_code."'";	
$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$objResult9 = mysqli_fetch_array($objQuery9);
$sum_count	= $objResult9["sum_count"];
$sum_all = "$sum_count $unit_name";		
	$this->SetFont('angsa','B',14);
$this->SetTextColor(0,0,255);
$this->Cell(1,6,iconv('UTF-8','cp874',''),0,"L");
	$this->Cell(20,6,iconv('UTF-8','cp874',''),0,"L");
	$this->Cell(20,6,iconv('UTF-8','cp874',''),0,"L");
	$this->Cell(80,6,iconv('UTF-8','cp874','รวมจำนวนการยืมสินค้า'),0,"L");
	$this->Cell(20,6,iconv('UTF-8','cp874',$sum_all),0,"R");
	$this->Cell(30,6,iconv('UTF-8','cp874',''),0,"R");
	$this->MultiCell(20,6,iconv('UTF-8','cp874',''),0,"R");

	$this->Cell(20,6,iconv('UTF-8','cp874',''),0,"L");
	$this->Cell(20,6,iconv('UTF-8','cp874',''),0,"L");
$this->Cell(100,0,iconv('UTF-8','cp874',''),1,"L");	
	$this->MultiCell(20,0.5,iconv('UTF-8','cp874',''),0,"R");
	$this->Cell(20,6,iconv('UTF-8','cp874',''),0,"L");
	$this->Cell(20,6,iconv('UTF-8','cp874',''),0,"L");
$this->Cell(100,0,iconv('UTF-8','cp874',''),1,"L");	
}
	$this->Ln(6);
}


}
	


$pdf=new PDF( 'P' , 'mm' , 'A4' );
$pdf->AddFont('angsa','','angsa.php');
$pdf->AddFont('angsa','B','angsab.php');
$pdf->AddFont('angsa','I','angsai.php');
$pdf->AddFont('angsa','BI','angsaz.php');
$pdf->SetFont('angsa','',12);
$pdf->AddPage();
$pdf->BasicTable();
$pdf->Output();
?>