<?php include "test.php"; ?>
<?php include ("error_page.php");  ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>แบบสอบถามเก็บข้อมูลลูกค้าเตียงไฟฟ้า กลุ่ม HOMECARE</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/form_style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/autocomplete.css"  type="text/css"/>

<style type="text/css">
<!--
.style15 {
	font-size: 18px
}
.style63 {
	color: #000000;
	font-size: 18px;
}
.style68 {
	font-size: 11px
}
-->
</style>
</head>
<body>
<div id="wrapper">
  <div id="header">
    <div id="site_title">
      <h1><a href="report_quo_allwell.php"></a></h1>
      <!-- end of site_title -->
    </div>
    
  </div>
  <div id="main_wrapper"> <span class="top"></span><span class="bottom"></span>
    <div id="main">
	<center>
      <h2>
      <div align="center">
        <p align="left"><span class="style63">Download สรุปรายการลูกค้า</span><span class="style68"><br />
          </span></p>
        <p align="center" class="style68">
          <?
//ส่งค่ามาจากฟอร์ม
error_reporting(E_ALL);
date_default_timezone_set('Europe/London');
/** PHPExcel */
require_once 'Classes/PHPExcel.php';
// Create new PHPExcel object
$objPHPExcel = new PHPExcel();
// Set properties
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");

			
$objPHPExcel->setActiveSheetIndex(0)
	
	        ->setCellValue('A1', 'ชื่อที่ิออกบิล')
            ->setCellValue('B1', 'ที่อยู่ออกบิล')
			->setCellValue('C1', 'เบอร์โทร ')
			->setCellValue('D1', 'หมายเลขคำสั่งซื้อ')
			->setCellValue('E1', 'เลขที่เอกสาร')
			->setCellValue('F1', 'ชือพนักงาน')
			->setCellValue('G1', 'วันที่สร้างเอกสาร')
			->setCellValue('H1', 'รหัส Express')
			->setCellValue('I1', 'จำนวน')
				->setCellValue('J1', 'ราคาต่อหน่วย')
				->setCellValue('K1', 'ส่วนลดต่อหน่วย')
				->setCellValue('L1', 'ราคารวม')

			;




function DateThai($strDate)
	{
		$strYear = date("Y",strtotime($strDate))+543;
		$strMonth= date("n",strtotime($strDate));
		$strDay= date("j",strtotime($strDate));
		$strHour= date("H",strtotime($strDate));
		$strMinute= date("i",strtotime($strDate));
		$strSeconds= date("s",strtotime($strDate));
		$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		$strMonthThai=$strMonthCut[$strMonth];
		return "$strDay $strMonthThai $strYear";
	}

include"dbconnect.php";
$start_date=$_GET["start_date"];	
$end_date=$_GET["end_date"];
$company=$_GET["company"];
$sale_channel =$_GET["sale_channel"];

$strSQL = "SELECT distinct iv_no  FROM  so__main where 1 ";

if($start_date !=""){ 

    $strSQL .= ' AND iv_date >= "'.$start_date.'"'; 

}

if($end_date !=""){ 
    $strSQL .= ' AND iv_date <= "'.$end_date.'"'; 

}

if($company !=""){ 
    $strSQL .= ' AND select_type_doc = "'.$company.'"'; 

}

if($sale_channel !=""){ 
    $strSQL .= ' AND sale_channel = "'.$sale_channel.'"'; 

}

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);


$i = 2;
$n=1;
$sum = 0;

while($objResult = mysqli_fetch_array($objQuery))
{

	$iv_no = $objResult["iv_no"];

$strSQL6 = "SELECT iv_date,employee_name  FROM  so__main where iv_no = '".$iv_no."'";

$objQuery6 = mysqli_query($conn,$strSQL6) or die ("Error Query [".$strSQL6."]");
$Num_Rows6 = mysqli_num_rows($objQuery6);
$objResult6 = mysqli_fetch_array($objQuery6);

$iv_date = $objResult6["iv_date"];
$employee_name = $objResult6["employee_name"];


$strSQL2 = "SELECT salechannel_name,address1,address2,province_id,zip_code  FROM  tb_salechannel where salechannel_ID = '".$sale_channel."'";



$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$Num_Rows2 = mysqli_num_rows($objQuery2);
$objResult2 = mysqli_fetch_array($objQuery2);

	$salechannel_name = $objResult2["salechannel_name"];
	$address1 = $objResult2["address1"];
	$address2 = $objResult2["address2"];
	$province_id = $objResult2["province_id"];
	$zip_code = $objResult2["zip_code"];
$sum_address ="$address1 $address2 $province_id $zip_code";


	
$strSQL3 = "SELECT distinct product_code,price_per_unit FROM  (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) where iv_no  = '".$iv_no."' and sum_amount !='0.00'";
$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$Num_Rows3 = mysqli_num_rows($objQuery3);


while($objResult3 = mysqli_fetch_array($objQuery3)){

	$price_per_unit = $objResult3["price_per_unit"];
	$product_code = $objResult3["product_code"];


$strSQL4 = "SELECT express_code   FROM  tb_product where product_ID = '".$product_code."' ";
$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
$Num_Rows4 = mysqli_num_rows($objQuery4);
$objResult4 = mysqli_fetch_array($objQuery4);

$express_code = $objResult4["express_code"];


$strSQL5 = "SELECT SUM(sum_amount) AS sum_amount,SUM(sale_count) AS sale_count,SUM(price_per_unit) AS price_per_unit,SUM(discount_unit) AS discount_unit  FROM  (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) where iv_no  = '".$iv_no."' and price_per_unit='".$price_per_unit."' and product_code='".$product_code."' and sum_amount !='0.00'";
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$Num_Rows5 = mysqli_num_rows($objQuery5);


$objResult5 = mysqli_fetch_array($objQuery5);

$sum_amount = $objResult5["sum_amount"];
$sale_count = $objResult5["sale_count"];
$discount_unit = $objResult5["discount_unit"];

	



	$objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $salechannel_name);
	$objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $sum_address);
	$objPHPExcel->getActiveSheet()->setCellValue('C' . $i, '');
	$objPHPExcel->getActiveSheet()->setCellValue('D' . $i, '');
	$objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $iv_no);
	$objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $employee_name);
	$objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $iv_date);
	$objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $express_code);
	$objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $sale_count);
	$objPHPExcel->getActiveSheet()->setCellValue('J' . $i, $price_per_unit);
	$objPHPExcel->getActiveSheet()->setCellValue('K' . $i, $discount_unit);
	$objPHPExcel->getActiveSheet()->setCellValue('L' . $i, $sum_amount);




	$i++;
	$n++;
	//$sum = $sum + $objResult["score"]; 
}
}






// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('sale');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// Save Excel 2007 file
echo"<a href='sale.xlsx'><img src='img/download_now_v2.gif' width='262' height='98' /></a>";
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$strFileName = "sale.xlsx";
$objWriter->save($strFileName);


?>
          </span></p>
        <p align="center"><a href="report_sumexpress.php" target="_self"><span class="style63">กลับหน้าค้นหา</a> </span></p>
      </div>
      <div class="cleaner"></div>
    </div>
    <!-- end of main -->
  </div>
  <!-- end of main wrapper -->
</div>
</center>
<!-- end of wrapper -->
<div id="cr_bar_wrapper">
  <div id="cr_bar"> Copyright © 2019 phar trillion co., ltd. </div>
</div>
</body>
</html>
