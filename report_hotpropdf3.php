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
$start_date1 = date('Y-m-d');
$start_date = Datethai($start_date1);
$time = date('H:i:s');
$today = "$start_date $time";


			$this->AddFont('angsa','','angsa.php');
	
			$this->Ln(5);	
			$this->SetFont('angsa','B',14);
			$this->Cell(0,0,iconv( 'UTF-8','TIS-620','รายงานสินค้าคงเหลือ+จุดสั่งซื้อ'),0,1,"C");
			$this->Ln(6);	
			$this->Cell(0,0,iconv( 'UTF-8','TIS-620','บริษัท ฟาร์ ทริลเลียน จำกัด'),0,1,"C");
			$this->Ln(6);	
			$this->Cell(0,0,iconv( 'UTF-8','TIS-620',$today),0,1,"C");
				
			$this->Ln(10);			
			//หัวตาราง
		$this->SetFillColor(204,204,204);
		$this->SetFont('angsa','B',12);

		$this->Cell(15,6,iconv('UTF-8','cp874','รหัสสินค้า'),0,0,"C",true);
		$this->Cell(30,6,iconv('UTF-8','cp874','รายการสินค้า'),0,0,"C",true);
		$this->Cell(15,6,iconv('UTF-8','cp874','หน่วย'),0,0,"R",true);
		$this->Cell(12,6,iconv('UTF-8','cp874','พร้อมขาย'),0,0,"R",true);
		$this->Cell(12,6,iconv('UTF-8','cp874','คงเหลือ'),0,0,"R",true);
		$this->Cell(12,6,iconv('UTF-8','cp874','หมดอายุ'),0,0,"R",true);
		$this->Cell(12,6,iconv('UTF-8','cp874','มีปัญหา'),0,0,"R",true);
		$this->Cell(12,6,iconv('UTF-8','cp874','จอง'),0,0,"R",true);
		$this->Cell(12,6,iconv('UTF-8','cp874','Order'),0,0,"R",true);
		$this->Cell(12,6,iconv('UTF-8','cp874','จุดสั่งซื้อ'),0,0,"R",true);
		$this->Cell(12,6,iconv('UTF-8','cp874','สั่งซื้อ'),0,0,"R",true);
		$this->Cell(12,6,iconv('UTF-8','cp874','สั่งแล้ว'),0,0,"R",true);
		$this->Cell(18,6,iconv('UTF-8','cp874','เลขที่ใบสั่งซื้อ'),0,0,"C",true);
			$this->MultiCell(15,6,iconv('UTF-8','cp874','รวมซื้อ'),0,0,"C",true);

$this->Cell(200,0,iconv('UTF-8','cp874',''),1,"L");




		$this->Ln(3);	
		}

		
		function Footer(){
			$this->AddFont('angsa','','angsa.php');
			$this->SetFont('angsa','',12);
			$this->SetY(-3);
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

$strSQL9 = "SELECT DISTINCT group1  FROM tb_product  WHERE popular_3 ='1'";
$strSQL9 .=" order  by number ASC  ";	
$objQuery9 = mysqli_query($conn,$strSQL9) or die ("Error Query [".$strSQL9."]");
$Num_Rows9 = mysqli_num_rows($objQuery9);

while($objResult9 = mysqli_fetch_array($objQuery9))
{	
	
	$this->SetTextColor(0,0,0);
	$this->SetFont('angsa','B',16);
    $this->Cell(10,6,iconv('UTF-8','cp874',''),0,0,"C");
	$this->Cell(100,6,iconv('UTF-8','cp874',$objResult9["group1"]),0,0,"L");
$this->Ln(6);
		
	
$strSQL = "SELECT expire_total,problem_total,reorder_point,access_code,access_name,order_no,unit_name,product_ID,ordered,order_count  FROM tb_product  WHERE popular_3 ='1'  and group1 = '".$objResult9["group1"]."'";
	

$strSQL .=" order  by number ASC  ";	


$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);


while($objResult = mysqli_fetch_array($objQuery))
{
	
$product_code1  =$objResult["access_code"];
$product_code = substr($product_code1,0,8);	
	
$product_name1  =$objResult["access_name"];
$product_name = substr($product_name1,0,50);	

$strSQL16 = "SELECT SUM(count) AS count FROM (hos__jongproduct LEFT JOIN hos__subjongpro ON hos__jongproduct.ref_id=hos__subjongpro.ref_idd) WHERE product_id = '".$objResult["product_ID"]."' and close_jong ='0' ";
$objQuery16 = mysqli_query($conn,$strSQL16);
$objResult16 = mysqli_fetch_array($objQuery16);

//ใบจอง
$count_jong =$objResult16['count'];
$jong= number_format( $count_jong,2)."";

$strSQL1 = "SELECT SUM(count) AS count FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id=hos__subso.ref_idd) WHERE product_id = '".$objResult["product_ID"]."' and have_order ='1' and have_product = '0' ";
$objQuery1 = mysqli_query($conn,$strSQL1);
$objResult1 = mysqli_fetch_array($objQuery1);

$strSQL2 = "SELECT SUM(sale_count) AS count FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE product_id = '".$objResult["product_ID"]."' and have_order ='1' and have_product = '0' and cancel_ckk='0'";
$objQuery2 = mysqli_query($conn,$strSQL2);
$objResult2 = mysqli_fetch_array($objQuery2);

$count_hot =$objResult1['count'];
$count_sol =$objResult2['count'];

//ใบฝาก
$count_sale = $count_hot+$count_sol;
$sale= number_format( $count_sale,2)."";


$strSQL3 = "SELECT SUM(count_send) AS count_send ,SUM(count_receive) AS count_receive FROM st__sbmain WHERE product_id = '".$objResult["product_ID"]."' ";
$objQuery3 = mysqli_query($conn,$strSQL3);
$objResult3 = mysqli_fetch_array($objQuery3);

$count_send = $objResult3["count_send"];
$count_receive = $objResult3["count_receive"];
//คงเหลือ
$count_pro =$count_receive-$count_send;
$count_pro1= number_format( $count_pro,2)."";


//สั่งซื้อ
$buy_pro = $count_pro-($objResult["expire_total"]+$objResult["problem_total"]+$jong+$sale+$objResult["reorder_point"]);
$buy_pro1= number_format( $buy_pro,2)."";

//พร้อมขาย
$buy_sale = $count_pro-($objResult["expire_total"]+$objResult["problem_total"]+$jong+$sale);
$buy_sale1= number_format( $buy_sale,2)."";

$this->AddFont('angsa','','angsa.php');
			$this->SetFont('angsa','',12);
		$this->SetTextColor(0,0,0);

		$this->Cell(15,6,iconv('UTF-8','cp874',$product_code),0,"L");
	$this->SetFont('angsa','',10);
		$this->Cell(30,6,iconv('UTF-8','cp874',$product_name1),0,"L");
	$this->SetFont('angsa','',12);
		$this->Cell(15,6,iconv('UTF-8','cp874',$objResult["unit_name"]),0,0,"R");
		$this->SetTextColor(0,0,255);

		$this->Cell(12,6,iconv('UTF-8','cp874',$buy_sale1),0,0,"R");
				$this->SetTextColor(0,0,0);

			$this->SetFont('angsa','B',12);
		$this->Cell(12,6,iconv('UTF-8','cp874',$count_pro1),0,0,"R");
		$this->AddFont('angsa','','angsa.php');
			$this->SetFont('angsa','',12);
		$this->Cell(12,6,iconv('UTF-8','cp874',$objResult["expire_total"]),0,0,"R");
		$this->Cell(12,6,iconv('UTF-8','cp874',$objResult["problem_total"]),0,0,"R");
		$this->Cell(12,6,iconv('UTF-8','cp874',$jong),0,0,"R");
		$this->Cell(12,6,iconv('UTF-8','cp874',$sale),0,0,"R");
        $this->SetTextColor(34,139,34);
		$this->Cell(12,6,iconv('UTF-8','cp874',$objResult["reorder_point"]),0,0,"R");
		$this->SetTextColor(255,0,0);
		$this->Cell(12,6,iconv('UTF-8','cp874',$buy_pro1),0,0,"R");
		
		if ($objResult["ordered"]=='1'){
		$this->Cell(7,6,iconv('UTF-8','cp874',''),0,0,"C");
		$this->SetTextColor(255,0,0);
		$this->SetFont('angsa','B',14);
		$this->Cell(3.0,3.0,iconv('UTF-8','cp874','*'),1,"R");
		}else{
		$this->Cell(7,6,iconv('UTF-8','cp874',''),0,0,"C");
		$this->Cell(3.0,3.0,iconv('UTF-8','cp874',''),1,"R");
		}
		$this->SetTextColor(0,0,0);
		$this->SetFont('angsa','',12);
		$this->Cell(18,6,iconv('UTF-8','cp874',$objResult["order_no"]),0,"L");
		$this->MultiCell(15,6,iconv('UTF-8','cp874',$objResult["order_count"]),0,"R");

$this->Cell(200,0,iconv('UTF-8','cp874',''),1,"L");
$this->Ln(3);
}
}


}
	}


$pdf=new PDF( 'P' , 'mm' , 'A4' );
//$header=array('วันที่','ID งาน','แผนก','ผู้ส่ง','รายละเอียด');
$pdf->AddFont('angsa','','angsa.php');
$pdf->AddFont('angsa','B','angsab.php');
$pdf->AddFont('angsa','I','angsai.php');
$pdf->AddFont('angsa','BI','angsaz.php');
$pdf->SetFont('angsa','',12);
$pdf->AddPage();
$pdf->BasicTable();
$pdf->Output();
?>