<?php include "test.php"; ?>
<?php include ("error_page.php");  ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>รายงานสรุปความพึงพอใจลูกค้าหลังการขาย</title>
<?php /*<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/form_style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/autocomplete.css"  type="text/css"/>*/ ?>

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
        <p align="left"><span class="style63">Download รายงานสรุปความพึงพอใจลูกค้าหลังการขาย</span><span class="style68"><br />
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

$start_date=$_GET["start_date"];	
			
$date_arr = explode('-' , $start_date );
$mm = $date_arr[1];
$yy = $date_arr[0];
$_month_name = array("01"=>"มกราคม",  "02"=>"กุมภาพันธ์",  "03"=>"มีนาคม", "04"=>"เมษายน",  "05"=>"พฤษภาคม",  "06"=>"มิถุนายน","07"=>"กรกฎาคม",  "08"=>"สิงหาคม",  "09"=>"กันยายน",
"10"=>"ตุลาคม", "11"=>"พฤศจิกายน",  "12"=>"ธันวาคม");

$thai= $_month_name[$mm];
$year =$yy+543;

function cellColor($cells,$color){
    global $objPHPExcel;

    $objPHPExcel->getActiveSheet()->getStyle($cells)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}

cellColor('A2:A100', 'DCDCDC');
cellColor('B2:B100', 'DCDCDC');
cellColor('C2:C100', 'DCDCDC');
cellColor('D2:D100', 'DCDCDC');
cellColor('E2:E100', 'FF9999');
cellColor('F2:F100', 'FF9999');
			
cellColor('G2:G100', 'FF9999');
cellColor('H2:H100', 'FF9999');
cellColor('I2:I100', 'FF9999');
			
cellColor('J2:J100', 'CCFF66');
cellColor('K2:K100', 'CCFF66');
cellColor('L2:L100', 'CCFF66');			
cellColor('M2:M100', 'CCFF66');
			
cellColor('N2:N100', 'FF9966');
cellColor('O2:O100', 'FF9966');
cellColor('P2:P100', 'FF9966');
cellColor('Q2:Q100', 'FF9966');
cellColor('R2:R100', 'FF9966');			
cellColor('S2:S100', 'FF9966');

			
			

$styleArray=array(
'borders'=>array(
'allborders'=>array(
'style'=>PHPExcel_Style_Border::BORDER_MEDIUM
)
)
);

$objPHPExcel->getActiveSheet()->getStyle('A2:s2')->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('A3:s3')->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('A4:s4')->applyFromArray($styleArray);
//$objPHPExcel->getActiveSheet()->getStyle('A4:X4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
//$objPHPExcel->getActiveSheet()->getStyle('A3:X3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
			
			
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);

$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);

$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);

$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);

$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);

$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);

$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);

$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
			
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);

$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);

$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);

$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);

$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);

$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);

$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);

$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
			
$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);

$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);

$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);


			
$objPHPExcel->setActiveSheetIndex(0)
	
			->setCellValue('L1', 'สรุปผลความพึงพอใจลูกค้าหลังการขาย')
	 ->setCellValue('M1', $thai)
	->setCellValue('N1', 'ประจำปี')
	->setCellValue('O1', $year)
	
	       ->setCellValue('E2', 'ความพึงพอใจต่อพนักงานขาย')
            ->setCellValue('L2', 'ความพึงพอใจต่อสินค้า/ผลิตภัณฑ์')
			->setCellValue('R2', 'ความพึงพอใจต่อพนักงานผู้ติดตั้ง/สาธิต')
	
	->setCellValue('E3', '1')
	->setCellValue('F3', '2')
	->setCellValue('G3', '3')
	->setCellValue('H3', '4')

	
	->setCellValue('J3', '1')
	->setCellValue('K3', '2')
	->setCellValue('L3', '3')
   
	
	->setCellValue('N3', '1')
	->setCellValue('O3', '2')
	->setCellValue('P3', '3')
	->setCellValue('Q3', '4')
	->setCellValue('R3', '5')

	
	
	
	->setCellValue('A4', 'เลขที่เอกสาร')
	->setCellValue('B4', 'ลำดับ')
    ->setCellValue('C4', 'รายชื่อลูกค้า')
	->setCellValue('D4', 'เขตการขาย')
	->setCellValue('E4', 'พนักงานขายกิริยามารยาทเรียบร้อย พูดจาสุภาพ อัธยาศัยดี วางตัวเหมาะสม')
	->setCellValue('F4', 'พนักงานขายมีความรู้ความชำนาญในตัวสินค้า สามารถแนะนำ ตอบข้อซักถามได้ชัดเจน')
	->setCellValue('G4', 'พนักงานขายบริการด้วยความรวดเร็ว/เอาใจใส่ และมีความเต็มใจให้บริการ')
	->setCellValue('H4', 'การติดต่อพนักงานขายในช่องทางต่างๆ รวดเร็ว และมีประสิทธิภาพ')
	->setCellValue('I4', 'ข้อเสนอแนะ')
  
	
	->setCellValue('J4', 'สินค้ามีคุณภาพ และสามารถใช้งานได้อย่างมีประสิทธิภาพ')
	->setCellValue('K4', 'สินค้าตรงกับความต้องการของลูกค้า')
	->setCellValue('L4', 'ความพึงพอใจในสินค้า')
	->setCellValue('M4', 'ข้อเสนอแนะ')
   
	
	->setCellValue('N4', 'พนักงานจัดส่งมีกิริยามารยาทเรียบร้อย พูดจาสุภาพ อัธยาศัยดี วางตัวเหมาะสม')
	->setCellValue('O4', 'พนักงานจัดส่งมีความรู้ความชำนาญในสินค้า สามารถอธิบาย สาธิตวิธีการใช้งาน และตอบข้อซักถามได้ชัดเจน')
	->setCellValue('P4', 'พนักงานจัดส่งดูแลสินค้า รวมถึงกระบวนการขนย้ายสินค้าเข้าติดตั้ง ณ สถานที่ใช้งานเป็นอย่างดี')
	->setCellValue('Q4', 'พนักงานจัดส่งสินค้าโทรประสานงานก่อนส่งสินค้าจริง และส่งมอบสินค้าตามเวลาที่ได้นัดหมายไว้')
	->setCellValue('R4', 'มาตรฐานการขนส่งของพนักงานจัดส่ง เมื่อเทียบกับบริษัทอื่นๆ')
	->setCellValue('S4', 'ข้อเสนอแนะ')
	

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

include"dbconnect_cs.php";
$start_date=$_GET["start_date"];	
$end_date=$_GET["end_date"];
$type_customer=$_GET["type_customer"];			

$strSQL = "SELECT *  FROM  tb_research where 1 ";

if($start_date !=""){ 

    $strSQL .= ' AND date_research >= "'.$start_date.'"'; 

}

if($end_date !=""){ 
    $strSQL .= ' AND date_research <= "'.$end_date.'"'; 

}
if($type_customer !=''){ 
    $strSQL .= ' AND  type_customer = "'.$type_customer.'"'; 

}


$objQuery = mysqli_query($com1,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);


$i = 5;
$n=1;
$sum = 0;

while($objResult = mysqli_fetch_array($objQuery))
{

	
	$iv_number =  $objResult["iv_number"];
	$customer_name = $objResult["customer_name"];
	
	$sale_neat = $objResult["sale_neat"];
	$sale_data = $objResult["sale_data"];
	$sale_3 = $objResult["sale_3"];
	$sale_4 = $objResult["sale_4"];
	$sale_code = $objResult["sale_code"];
		
	$sum_sale = ($sale_neat+$sale_data+$sale_3+$sale_4)/4;
	$sum_sale1 = $sale_neat+$sale_data+$sale_3+$sale_4;
	$sale_persent = ($sum_sale1*100)/20;
	if($sale_persent >= '80'){
		$sale_pass = "P";
	}else{
		$sale_pass = "F";
	}
		
	$product_good = $objResult["product_good"];
	$product_link = $objResult["product_link"];
	$product_corect =  $objResult["product_corect"];
	
	$sum_pro = ($product_good+$product_link+$product_corect)/3;
	$sum_pro1 = $product_good+$product_link+$product_corect;
	$pro_persent = ($sum_pro1*100)/15;
	if($pro_persent >= '80'){
		$pro_pass = "P";
	}else{
		$pro_pass = "F";
	}
	
	
	$cs_neat = $objResult["cs_neat"];
	$cs_explain = $objResult["cs_explain"];
	$cs_3 = $objResult["cs_3"];
	$cs_4 = $objResult["cs_4"];
	$cs_5 = $objResult["cs_5"];
	$sum_cs = ($cs_neat+$cs_explain+$cs_3+$cs_4+$cs_5)/5;
	$sum_cs1 = $cs_neat+$cs_explain+$cs_3+$cs_4+$cs_5;
	$cs_persent = ($sum_cs1*100)/25;
	if($cs_persent >= '80'){
		$cs_pass = "P";
	}else{
		$cs_pass = "F";
	}
	
	$suggest = $objResult["suggest"];
	$suggest_1 = $objResult["suggest_1"];
	$suggest_2 = $objResult["suggest_2"];
    $problem = $objResult["problem"];
    $description = "$suggest $problem $suggest_1 $suggest_2";

$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':S'.$i.'')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
/*$objPHPExcel->getActiveSheet()->getStyle('B3'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('C3'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objPHPExcel->getActiveSheet()->getStyle('D3'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objPHPExcel->getActiveSheet()->getStyle('E3'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('F3'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('G3'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('H3'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);*/
	
	$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':S'.$i.'')->applyFromArray($styleArray);

	$objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $iv_number);
	$objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $n);
	$objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $customer_name);
	$objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $sale_code);
	$objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $sale_neat);
	$objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $sale_data);
	$objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $sale_3);
	$objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $sale_4);
	$objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $suggest);
	/*$objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $sum_sale);
	$objPHPExcel->getActiveSheet()->setCellValue('J' . $i, $sale_persent);
	$objPHPExcel->getActiveSheet()->setCellValue('K' . $i, $sale_pass);*/
	
	$objPHPExcel->getActiveSheet()->setCellValue('J' . $i, $product_good);
	$objPHPExcel->getActiveSheet()->setCellValue('K' . $i, $product_link);
	$objPHPExcel->getActiveSheet()->setCellValue('L' . $i, $product_corect);
	$objPHPExcel->getActiveSheet()->setCellValue('M' . $i, $suggest_1);
	/*$objPHPExcel->getActiveSheet()->setCellValue('O' . $i, $sum_pro);
	$objPHPExcel->getActiveSheet()->setCellValue('P' . $i, $pro_persent);
	$objPHPExcel->getActiveSheet()->setCellValue('Q' . $i, $pro_pass);*/
	
	$objPHPExcel->getActiveSheet()->setCellValue('N' . $i, $cs_neat);
	$objPHPExcel->getActiveSheet()->setCellValue('O' . $i, $cs_explain);
	$objPHPExcel->getActiveSheet()->setCellValue('P' . $i, $cs_3);
	$objPHPExcel->getActiveSheet()->setCellValue('Q' . $i, $cs_4);
	$objPHPExcel->getActiveSheet()->setCellValue('R' . $i, $cs_5);
	$objPHPExcel->getActiveSheet()->setCellValue('S' . $i, $suggest_2);
	/*$objPHPExcel->getActiveSheet()->setCellValue('W' . $i, $sum_cs);
    $objPHPExcel->getActiveSheet()->setCellValue('X' . $i, $cs_persent);
	$objPHPExcel->getActiveSheet()->setCellValue('Y' . $i, $cs_pass);
	$objPHPExcel->getActiveSheet()->setCellValue('Z' . $i, $description);*/

	$i++;
	$n++;
	//$sum = $sum + $objResult["score"]; 
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
        <p align="center"><a href="search_sumresearch_sale.php" target="_self"><span class="style63">กลับหน้าค้นหา</a> </span></p>
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
  <div id="cr_bar"> Copyright © 2020 phar trillion co., ltd. </div>
</div>
</body>
</html>
