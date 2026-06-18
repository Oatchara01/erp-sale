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

$year_ckk = $_GET["year_ckk"];	
$type_customer=$_GET["type_customer"];	
			
$year_1 =$year_ckk+543;

function cellColor($cells,$color){
    global $objPHPExcel;

    $objPHPExcel->getActiveSheet()->getStyle($cells)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
             'rgb' => $color
        )
    ));
}

cellColor('A2:F2', 'DCDCDC');
cellColor('A3:F3', 'DCDCDC');
cellColor('D5:D16', 'DCDCDC');
cellColor('E5:E16', 'DCDCDC');
cellColor('F5:F16', 'DCDCDC');
			
			

$styleArray=array(
'borders'=>array(
'allborders'=>array(
'style'=>PHPExcel_Style_Border::BORDER_MEDIUM
)
)
);

$objPHPExcel->getActiveSheet()->getStyle('A2:x2')->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('A3:x3')->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('A4:x4')->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('A4:X4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
$objPHPExcel->getActiveSheet()->getStyle('A3:X3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
			
			
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);

$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);

$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);

$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);

$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);

$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);

			


include"dbconnect_cs.php";
$year_ckk = $_GET["year_ckk"];	

$jan_1 = "01";
$feb_1 = "02";
$march_1 = "03";
$apil_1 = "04";
$may_1 = "05";
$june_1 = "06";
$july_1 = "07";
$aug_1= "08";
$sep_1 = "09";
$oat_1 = "10";
$nov_1 = "11";
$Dec_1 = "12";


$jan = "$year_ckk-$jan_1";
$feb = "$year_ckk-$feb_1";
$march = "$year_ckk-$march_1";
$apil = "$year_ckk-$apil_1";
$may = "$year_ckk-$may_1";
$june = "$year_ckk-$june_1";
$july = "$year_ckk-$july_1";
$aug = "$year_ckk-$aug_1";
$sep = "$year_ckk-$sep_1";
$oat = "$year_ckk-$oat_1";
$nov = "$year_ckk-$nov_1";
$Dec = "$year_ckk-$Dec_1";


$strSQL1 = "SELECT running_id  FROM  tb_research where date_research LIKE '%$jan%' and product_good !='0' and type_customer = '".$type_customer."'";
$objQuery1 = mysqli_query($com1,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

$strSQL2 = "SELECT running_id  FROM  tb_research where date_research LIKE '%$feb%' and product_good !='0' and type_customer = '".$type_customer."'";
$objQuery2 = mysqli_query($com1,$strSQL2) or die ("Error Query [".$strSQL2."]");
$Num_Rows2 = mysqli_num_rows($objQuery2);

$strSQL3 = "SELECT running_id  FROM  tb_research where date_research LIKE '%$march%' and product_good !='0' and type_customer = '".$type_customer."'";
$objQuery3 = mysqli_query($com1,$strSQL3) or die ("Error Query [".$strSQL3."]");
$Num_Rows3 = mysqli_num_rows($objQuery3);

$strSQL4 = "SELECT running_id  FROM  tb_research where date_research LIKE '%$apil%' and product_good !='0' and type_customer = '".$type_customer."'";
$objQuery4 = mysqli_query($com1,$strSQL4) or die ("Error Query [".$strSQL4."]");
$Num_Rows4 = mysqli_num_rows($objQuery4);

$strSQL5 = "SELECT running_id  FROM  tb_research where date_research LIKE '%$may%' and product_good !='0' and type_customer = '".$type_customer."'";
$objQuery5 = mysqli_query($com1,$strSQL5) or die ("Error Query [".$strSQL5."]");
$Num_Rows5 = mysqli_num_rows($objQuery5);

$strSQL6 = "SELECT running_id  FROM  tb_research where date_research LIKE '%$june%' and product_good !='0' and type_customer = '".$type_customer."'";
$objQuery6 = mysqli_query($com1,$strSQL6) or die ("Error Query [".$strSQL6."]");
$Num_Rows6 = mysqli_num_rows($objQuery6);

$strSQL7 = "SELECT running_id  FROM  tb_research where date_research LIKE '%$july%' and product_good !='0' and type_customer = '".$type_customer."'";
$objQuery7 = mysqli_query($com1,$strSQL7) or die ("Error Query [".$strSQL7."]");
$Num_Rows7 = mysqli_num_rows($objQuery7);

$strSQL8 = "SELECT running_id  FROM  tb_research where date_research LIKE '%$aug%' and product_good !='0' and type_customer = '".$type_customer."'";
$objQuery8 = mysqli_query($com1,$strSQL8) or die ("Error Query [".$strSQL8."]");
$Num_Rows8 = mysqli_num_rows($objQuery8);

$strSQL9 = "SELECT running_id  FROM  tb_research where date_research LIKE '%$sep%' and product_good !='0' and type_customer = '".$type_customer."'";
$objQuery9 = mysqli_query($com1,$strSQL9) or die ("Error Query [".$strSQL9."]");
$Num_Rows9 = mysqli_num_rows($objQuery9);

$strSQL10 = "SELECT running_id  FROM  tb_research where date_research LIKE '%$oat%' and product_good !='0' and type_customer = '".$type_customer."'";
$objQuery10 = mysqli_query($com1,$strSQL10) or die ("Error Query [".$strSQL10."]");
$Num_Rows10 = mysqli_num_rows($objQuery10);

$strSQL11 = "SELECT running_id  FROM  tb_research where date_research LIKE '%$nov%' and product_good !='0' and type_customer = '".$type_customer."'";
$objQuery11 = mysqli_query($com1,$strSQL11) or die ("Error Query [".$strSQL11."]");
$Num_Rows11 = mysqli_num_rows($objQuery11);

$strSQL12 = "SELECT running_id  FROM  tb_research where date_research LIKE '%$Dec%' and product_good !='0' and type_customer = '".$type_customer."'";
$objQuery12 = mysqli_query($com1,$strSQL12) or die ("Error Query [".$strSQL12."]");
$Num_Rows12 = mysqli_num_rows($objQuery12);

			
			
$strSQL21 = "SELECT running_id  FROM  tb_research where date_research LIKE '%$jan%'  and type_customer = '".$type_customer."'";
$objQuery21 = mysqli_query($com1,$strSQL21) or die ("Error Query [".$strSQL21."]");
$Num_Rows21 = mysqli_num_rows($objQuery21);

$strSQL22 = "SELECT running_id  FROM  tb_research where date_research LIKE '%$feb%'  and type_customer = '".$type_customer."'";
$objQuery22 = mysqli_query($com1,$strSQL22) or die ("Error Query [".$strSQL22."]");
$Num_Rows22 = mysqli_num_rows($objQuery22);

$strSQL23 = "SELECT running_id  FROM  tb_research where date_research LIKE '%$march%'  and type_customer = '".$type_customer."'";
$objQuery23 = mysqli_query($com1,$strSQL23) or die ("Error Query [".$strSQL23."]");
$Num_Rows23 = mysqli_num_rows($objQuery23);

$strSQL24 = "SELECT running_id  FROM  tb_research where date_research LIKE '%$apil%'  and type_customer = '".$type_customer."'";
$objQuery24 = mysqli_query($com1,$strSQL24) or die ("Error Query [".$strSQL24."]");
$Num_Rows24 = mysqli_num_rows($objQuery24);

$strSQL25 = "SELECT running_id  FROM  tb_research where date_research LIKE '%$may%'  and type_customer = '".$type_customer."'";
$objQuery25 = mysqli_query($com1,$strSQL25) or die ("Error Query [".$strSQL25."]");
$Num_Rows25 = mysqli_num_rows($objQuery25);

$strSQL26 = "SELECT running_id  FROM  tb_research where date_research LIKE '%$june%'  and type_customer = '".$type_customer."'";
$objQuery26 = mysqli_query($com1,$strSQL26) or die ("Error Query [".$strSQL26."]");
$Num_Rows26 = mysqli_num_rows($objQuery26);

$strSQL27 = "SELECT running_id  FROM  tb_research where date_research LIKE '%$july%'  and type_customer = '".$type_customer."'";
$objQuery27 = mysqli_query($com1,$strSQL27) or die ("Error Query [".$strSQL27."]");
$Num_Rows27 = mysqli_num_rows($objQuery27);

$strSQL28 = "SELECT running_id  FROM  tb_research where date_research LIKE '%$aug%'  and type_customer = '".$type_customer."'";
$objQuery28 = mysqli_query($com1,$strSQL28) or die ("Error Query [".$strSQL28."]");
$Num_Rows28 = mysqli_num_rows($objQuery28);

$strSQL29 = "SELECT running_id  FROM  tb_research where date_research LIKE '%$sep%'  and type_customer = '".$type_customer."'";
$objQuery29 = mysqli_query($com1,$strSQL29) or die ("Error Query [".$strSQL29."]");
$Num_Rows29 = mysqli_num_rows($objQuery29);

$strSQL30 = "SELECT running_id  FROM  tb_research where date_research LIKE '%$oat%'  and type_customer = '".$type_customer."'";
$objQuery30 = mysqli_query($com1,$strSQL30) or die ("Error Query [".$strSQL30."]");
$Num_Rows30 = mysqli_num_rows($objQuery30);

$strSQL31 = "SELECT running_id  FROM  tb_research where date_research LIKE '%$nov%'  and type_customer = '".$type_customer."'";
$objQuery31 = mysqli_query($com1,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);

$strSQL32 = "SELECT running_id  FROM  tb_research where date_research LIKE '%$Dec%'  and type_customer = '".$type_customer."'";
$objQuery32 = mysqli_query($com1,$strSQL32) or die ("Error Query [".$strSQL32."]");
$Num_Rows32 = mysqli_num_rows($objQuery32);
			
$sumall_jan1 = 	($Num_Rows1*100)/$Num_Rows21;
$sumall_jan2 = number_format( $sumall_jan1,2)."";			
$sumall_jan = "$sumall_jan2 %";
			
$sumall_feb1 = 	($Num_Rows2*100)/$Num_Rows22;
$sumall_feb2 = number_format( $sumall_feb1,2)."";			
$sumall_feb = "$sumall_feb2 %";
	
$sumall_march1 = 	($Num_Rows3*100)/$Num_Rows23;
$sumall_march2 = number_format( $sumall_march1,2)."";			
$sumall_march = "$sumall_march2 %";
	
$sumall_apil1 = 	($Num_Rows4*100)/$Num_Rows24;
$sumall_apil2 = number_format( $sumall_apil1,2)."";			
$sumall_apil = "$sumall_apil2 %";

$sumall_may1 = 	($Num_Rows5*100)/$Num_Rows25;
$sumall_may2 = number_format( $sumall_may1,2)."";			
$sumall_may = "$sumall_may2 %";
			
$sumall_june1 = ($Num_Rows6*100)/$Num_Rows26;
$sumall_june2 = number_format( $sumall_june1,2)."";			
$sumall_june = "$sumall_june2 %";

$sumall_july1 = ($Num_Rows7*100)/$Num_Rows27;
$sumall_july2 = number_format( $sumall_july1,2)."";			
$sumall_july = "$sumall_july2 %";			
	
			
$sumall_aug1 = ($Num_Rows8*100)/$Num_Rows28;
$sumall_aug2 = number_format( $sumall_aug1,2)."";			
$sumall_aug = "$sumall_aug2 %";		
			
$sumall_sep1 = ($Num_Rows9*100)/$Num_Rows29;
$sumall_sep2 = number_format( $sumall_sep1,2)."";			
$sumall_sep = "$sumall_sep2 %";	
			
$sumall_oat1 = ($Num_Rows10*100)/$Num_Rows30;
$sumall_oat2 = number_format( $sumall_oat1,2)."";			
$sumall_oat = "$sumall_oat2 %";	

$sumall_nov1 = ($Num_Rows11*100)/$Num_Rows31;
$sumall_nov2 = number_format( $sumall_nov1,2)."";			
$sumall_nov = "$sumall_nov2 %";				

$sumall_Dec1 = ($Num_Rows12*100)/$Num_Rows32;
$sumall_Dec2 = number_format( $sumall_Dec1,2)."";			
$sumall_Dec = "$sumall_Dec2 %";				
			

			
//เดือน 1			
$strSQLm1 = "SELECT SUM(sale_neat) As sale_neat,SUM(sale_data) As sale_data,SUM(sale_3) As sale_3,SUM(sale_4) As sale_4,SUM(product_good) As product_good,SUM(product_link) As product_link,SUM(product_corect) As product_corect,SUM(cs_neat) As cs_neat,SUM(cs_explain) As cs_explain,SUM(cs_3) As cs_3,SUM(cs_4) As cs_4,SUM(cs_5) As cs_5  FROM  tb_research where date_research LIKE '%$jan%' and product_good !='0'  and type_customer = '".$type_customer."'";

$objQuerym1 = mysqli_query($com1,$strSQLm1) or die ("Error Query [".$strSQLm1."]");
$objResultm1 = mysqli_fetch_array($objQuerym1);

$sale_neat1 = $objResultm1["sale_neat"];
$sale_data1 = $objResultm1["sale_data"];
$sale_31 = $objResultm1["sale_3"];
$sale_41 = $objResultm1["sale_4"];
$sum_sale1 = (($sale_neat1+$sale_data1+$sale_31+$sale_41)*100)/($Num_Rows1*20);
$sale_jan1 = number_format( $sum_sale1,2)."";
$sale_jan= "$sale_jan1 %";
			
			
$product_good1 = $objResultm1["product_good"];
$product_link1 = $objResultm1["product_link"];
$product_corect1 = $objResultm1["product_corect"];
$sum_pro1 = (($product_good1+$product_link1+$product_corect1)*100)/($Num_Rows1*15);
$pro_jan1 = number_format( $sum_pro1,2)."";
$pro_jan= "$pro_jan1 %";	
			
			
$cs_neat1 = $objResultm1["cs_neat"];
$cs_explain1 = $objResultm1["cs_explain"];
$cs_31 = $objResultm1["cs_3"];
$cs_41 = $objResultm1["cs_4"];
$cs_51 = $objResultm1["cs_5"];
$sum_cs1 = (($cs_neat1+$cs_explain1+$cs_31+$cs_41+$cs_51)*100)/($Num_Rows1*25);
$cs_jan1 = number_format( $sum_cs1,2)."";
$cs_jan= "$cs_jan1 %";
			
			
//เดือน 2			
$strSQLm2 = "SELECT SUM(sale_neat) As sale_neat,SUM(sale_data) As sale_data,SUM(sale_3) As sale_3,SUM(sale_4) As sale_4,SUM(product_good) As product_good,SUM(product_link) As product_link,SUM(product_corect) As product_corect,SUM(cs_neat) As cs_neat,SUM(cs_explain) As cs_explain,SUM(cs_3) As cs_3,SUM(cs_4) As cs_4,SUM(cs_5) As cs_5  FROM  tb_research where date_research LIKE '%$feb%' and product_good !='0'  and type_customer = '".$type_customer."'";

$objQuerym2 = mysqli_query($com1,$strSQLm2) or die ("Error Query [".$strSQLm2."]");
$objResultm2 = mysqli_fetch_array($objQuerym2);

$sale_neat2 = $objResultm2["sale_neat"];
$sale_data2 = $objResultm2["sale_data"];
$sale_32 = $objResultm2["sale_3"];
$sale_42 = $objResultm2["sale_4"];
$sum_sale2 = (($sale_neat2+$sale_data2+$sale_32+$sale_42)*100)/($Num_Rows2*20);
$sale_feb2 = number_format( $sum_sale2,2)."";
$sale_feb= "$sale_feb2 %";
			
			
$product_good2 = $objResultm2["product_good"];
$product_link2 = $objResultm2["product_link"];
$product_corect2 = $objResultm2["product_corect"];
$sum_pro2 = (($product_good2+$product_link2+$product_corect2)*100)/($Num_Rows2*15);
$pro_feb2 = number_format( $sum_pro2,2)."";
$pro_feb= "$pro_feb2 %";	
			
			
$cs_neat2 = $objResultm2["cs_neat"];
$cs_explain2 = $objResultm2["cs_explain"];
$cs_32 = $objResultm2["cs_3"];
$cs_42 = $objResultm2["cs_4"];
$cs_52 = $objResultm2["cs_5"];
$sum_cs2 = (($cs_neat2+$cs_explain2+$cs_32+$cs_42+$cs_52)*100)/($Num_Rows2*25);
$cs_feb2 = number_format( $sum_cs2,2)."";
$cs_feb= "$cs_feb2 %";
			
//เดือน 3			
$strSQLm3 = "SELECT SUM(sale_neat) As sale_neat,SUM(sale_data) As sale_data,SUM(sale_3) As sale_3,SUM(sale_4) As sale_4,SUM(product_good) As product_good,SUM(product_link) As product_link,SUM(product_corect) As product_corect,SUM(cs_neat) As cs_neat,SUM(cs_explain) As cs_explain,SUM(cs_3) As cs_3,SUM(cs_4) As cs_4,SUM(cs_5) As cs_5  FROM  tb_research where date_research LIKE '%$march%' and product_good !='0'  and type_customer = '".$type_customer."'";

$objQuerym3 = mysqli_query($com1,$strSQLm3) or die ("Error Query [".$strSQLm3."]");
$objResultm3 = mysqli_fetch_array($objQuerym3);

$sale_neat3 = $objResultm3["sale_neat"];
$sale_data3 = $objResultm3["sale_data"];
$sale_33 = $objResultm3["sale_3"];
$sale_43 = $objResultm3["sale_4"];
$sum_sale3 = (($sale_neat3+$sale_data3+$sale_33+$sale_43)*100)/($Num_Rows3*20);
$sale_march3 = number_format( $sum_sale3,2)."";
$sale_march= "$sale_march3 %";
			
			
$product_good3 = $objResultm3["product_good"];
$product_link3 = $objResultm3["product_link"];
$product_corect3 = $objResultm3["product_corect"];
$sum_pro3 = (($product_good3+$product_link3+$product_corect3)*100)/($Num_Rows3*15);
$pro_march3 = number_format( $sum_pro3,2)."";
$pro_march= "$pro_march3 %";	
			
			
$cs_neat3 = $objResultm3["cs_neat"];
$cs_explain3 = $objResultm3["cs_explain"];
$cs_33 = $objResultm3["cs_3"];
$cs_43 = $objResultm3["cs_4"];
$cs_53 = $objResultm3["cs_5"];
$sum_cs3 = (($cs_neat3+$cs_explain3+$cs_33+$cs_43+$cs_53)*100)/($Num_Rows3*25);
$cs_march3 = number_format( $sum_cs3,2)."";
$cs_march= "$cs_march3 %";

			
//เดือน 4			
$strSQLm4 = "SELECT SUM(sale_neat) As sale_neat,SUM(sale_data) As sale_data,SUM(sale_3) As sale_3,SUM(sale_4) As sale_4,SUM(product_good) As product_good,SUM(product_link) As product_link,SUM(product_corect) As product_corect,SUM(cs_neat) As cs_neat,SUM(cs_explain) As cs_explain,SUM(cs_3) As cs_3,SUM(cs_4) As cs_4,SUM(cs_5) As cs_5  FROM  tb_research where date_research LIKE '%$apil%' and product_good !='0'  and type_customer = '".$type_customer."'";

$objQuerym4 = mysqli_query($com1,$strSQLm4) or die ("Error Query [".$strSQLm4."]");
$objResultm4 = mysqli_fetch_array($objQuerym4);

$sale_neat4 = $objResultm4["sale_neat"];
$sale_data4 = $objResultm4["sale_data"];
$sale_34 = $objResultm4["sale_3"];
$sale_44 = $objResultm4["sale_4"];
$sum_sale4 = (($sale_neat4+$sale_data4+$sale_34+$sale_44)*100)/($Num_Rows4*20);
$sale_apil4 = number_format( $sum_sale4,2)."";
$sale_apil= "$sale_apil4 %";
			
			
$product_good4 = $objResultm4["product_good"];
$product_link4 = $objResultm4["product_link"];
$product_corect4 = $objResultm4["product_corect"];
$sum_pro4 = (($product_good4+$product_link4+$product_corect4)*100)/($Num_Rows4*15);
$pro_apil4 = number_format($sum_pro4,2)."";
$pro_apil= "$pro_apil4 %";	
			
			
$cs_neat4 = $objResultm4["cs_neat"];
$cs_explain4 = $objResultm4["cs_explain"];
$cs_34 = $objResultm4["cs_3"];
$cs_44 = $objResultm4["cs_4"];
$cs_54 = $objResultm4["cs_5"];
$sum_cs4 = (($cs_neat4+$cs_explain4+$cs_34+$cs_44+$cs_54)*100)/($Num_Rows4*25);
$cs_apil4 = number_format( $sum_cs4,2)."";
$cs_apil = "$cs_apil4 %";
	
			
//เดือน 5			
$strSQLm5 = "SELECT SUM(sale_neat) As sale_neat,SUM(sale_data) As sale_data,SUM(sale_3) As sale_3,SUM(sale_4) As sale_4,SUM(product_good) As product_good,SUM(product_link) As product_link,SUM(product_corect) As product_corect,SUM(cs_neat) As cs_neat,SUM(cs_explain) As cs_explain,SUM(cs_3) As cs_3,SUM(cs_4) As cs_4,SUM(cs_5) As cs_5  FROM  tb_research where date_research LIKE '%$may%' and product_good !='0'  and type_customer = '".$type_customer."'";

$objQuerym5 = mysqli_query($com1,$strSQLm5) or die ("Error Query [".$strSQLm5."]");
$objResultm5 = mysqli_fetch_array($objQuerym5);

$sale_neat5 = $objResultm5["sale_neat"];
$sale_data5 = $objResultm5["sale_data"];
$sale_35 = $objResultm5["sale_3"];
$sale_45 = $objResultm5["sale_4"];
$sum_sale5 = (($sale_neat5+$sale_data5+$sale_35+$sale_45)*100)/($Num_Rows5*20);
$sale_may5 = number_format( $sum_sale5,2)."";
$sale_may= "$sale_may5 %";
			
			
$product_good5 = $objResultm5["product_good"];
$product_link5 = $objResultm5["product_link"];
$product_corect5 = $objResultm5["product_corect"];
$sum_pro5 = (($product_good5+$product_link5+$product_corect5)*100)/($Num_Rows5*15);
$pro_may5 = number_format($sum_pro5,2)."";
$pro_may= "$pro_may5 %";	
			
			
$cs_neat5 = $objResultm5["cs_neat"];
$cs_explain5 = $objResultm5["cs_explain"];
$cs_35 = $objResultm5["cs_3"];
$cs_45 = $objResultm5["cs_4"];
$cs_55 = $objResultm5["cs_5"];
$sum_cs5 = (($cs_neat5+$cs_explain5+$cs_35+$cs_45+$cs_55)*100)/($Num_Rows5*25);
$cs_may5 = number_format( $sum_cs5,2)."";
$cs_may = "$cs_may5 %";
			
//เดือน 6			
$strSQLm6 = "SELECT SUM(sale_neat) As sale_neat,SUM(sale_data) As sale_data,SUM(sale_3) As sale_3,SUM(sale_4) As sale_4,SUM(product_good) As product_good,SUM(product_link) As product_link,SUM(product_corect) As product_corect,SUM(cs_neat) As cs_neat,SUM(cs_explain) As cs_explain,SUM(cs_3) As cs_3,SUM(cs_4) As cs_4,SUM(cs_5) As cs_5  FROM  tb_research where date_research LIKE '%$june%' and product_good !='0'  and type_customer = '".$type_customer."'";

$objQuerym6 = mysqli_query($com1,$strSQLm6) or die ("Error Query [".$strSQLm6."]");
$objResultm6 = mysqli_fetch_array($objQuerym6);

$sale_neat6 = $objResultm6["sale_neat"];
$sale_data6 = $objResultm6["sale_data"];
$sale_36 = $objResultm6["sale_3"];
$sale_46 = $objResultm6["sale_4"];
$sum_sale6 = (($sale_neat6+$sale_data6+$sale_36+$sale_46)*100)/($Num_Rows6*20);
$sale_june6 = number_format( $sum_sale6,2)."";
$sale_june= "$sale_june6 %";
			
			
$product_good6 = $objResultm6["product_good"];
$product_link6 = $objResultm6["product_link"];
$product_corect6 = $objResultm6["product_corect"];
$sum_pro6 = (($product_good6+$product_link6+$product_corect6)*100)/($Num_Rows6*15);
$pro_june6 = number_format($sum_pro6,2)."";
$pro_june = "$pro_june6 %";	
			
			
$cs_neat6 = $objResultm6["cs_neat"];
$cs_explain6 = $objResultm6["cs_explain"];
$cs_36 = $objResultm6["cs_3"];
$cs_46 = $objResultm6["cs_4"];
$cs_56 = $objResultm6["cs_5"];
$sum_cs6 = (($cs_neat6+$cs_explain6+$cs_36+$cs_46+$cs_56)*100)/($Num_Rows6*25);
$cs_june6 = number_format( $sum_cs6,2)."";
$cs_june = "$cs_june6 %";
			
									
//เดือน 7			
$strSQLm7 = "SELECT SUM(sale_neat) As sale_neat,SUM(sale_data) As sale_data,SUM(sale_3) As sale_3,SUM(sale_4) As sale_4,SUM(product_good) As product_good,SUM(product_link) As product_link,SUM(product_corect) As product_corect,SUM(cs_neat) As cs_neat,SUM(cs_explain) As cs_explain,SUM(cs_3) As cs_3,SUM(cs_4) As cs_4,SUM(cs_5) As cs_5  FROM  tb_research where date_research LIKE '%$july%' and product_good !='0'  and type_customer = '".$type_customer."'";

$objQuerym7 = mysqli_query($com1,$strSQLm7) or die ("Error Query [".$strSQLm7."]");
$objResultm7 = mysqli_fetch_array($objQuerym7);

$sale_neat7 = $objResultm7["sale_neat"];
$sale_data7 = $objResultm7["sale_data"];
$sale_37 = $objResultm7["sale_3"];
$sale_47 = $objResultm7["sale_4"];
$sum_sale7 = (($sale_neat7+$sale_data7+$sale_37+$sale_47)*100)/($Num_Rows7*20);
$sale_july7 = number_format( $sum_sale7,2)."";
$sale_july = "$sale_july7 %";
			
			
$product_good7 = $objResultm7["product_good"];
$product_link7 = $objResultm7["product_link"];
$product_corect7 = $objResultm7["product_corect"];
$sum_pro7 = (($product_good7+$product_link7+$product_corect7)*100)/($Num_Rows7*15);
$pro_july7 = number_format($sum_pro7,2)."";
$pro_july = "$pro_july7 %";	
			
			
$cs_neat7 = $objResultm7["cs_neat"];
$cs_explain7 = $objResultm7["cs_explain"];
$cs_37 = $objResultm7["cs_3"];
$cs_47 = $objResultm7["cs_4"];
$cs_57 = $objResultm7["cs_5"];
$sum_cs7 = (($cs_neat7+$cs_explain7+$cs_37+$cs_47+$cs_57)*100)/($Num_Rows7*25);
$cs_july7 = number_format( $sum_cs7,2)."";
$cs_july = "$cs_july7 %";
			

//เดือน 8			
$strSQLm8 = "SELECT SUM(sale_neat) As sale_neat,SUM(sale_data) As sale_data,SUM(sale_3) As sale_3,SUM(sale_4) As sale_4,SUM(product_good) As product_good,SUM(product_link) As product_link,SUM(product_corect) As product_corect,SUM(cs_neat) As cs_neat,SUM(cs_explain) As cs_explain,SUM(cs_3) As cs_3,SUM(cs_4) As cs_4,SUM(cs_5) As cs_5  FROM  tb_research where date_research LIKE '%$aug%' and product_good !='0'  and type_customer = '".$type_customer."'";

$objQuerym8 = mysqli_query($com1,$strSQLm8) or die ("Error Query [".$strSQLm8."]");
$objResultm8 = mysqli_fetch_array($objQuerym8);

$sale_neat8 = $objResultm8["sale_neat"];
$sale_data8 = $objResultm8["sale_data"];
$sale_38 = $objResultm8["sale_3"];
$sale_48 = $objResultm8["sale_4"];
$sum_sale8 = (($sale_neat8+$sale_data8+$sale_38+$sale_48)*100)/($Num_Rows8*20);
$sale_aug8 = number_format( $sum_sale8,2)."";
$sale_aug = "$sale_aug8 %";
			
			
$product_good8 = $objResultm8["product_good"];
$product_link8 = $objResultm8["product_link"];
$product_corect8 = $objResultm8["product_corect"];
$sum_pro8 = (($product_good8+$product_link8+$product_corect8)*100)/($Num_Rows8*15);
$pro_aug8 = number_format($sum_pro8,2)."";
$pro_aug = "$pro_aug8 %";	
			
			
$cs_neat8 = $objResultm8["cs_neat"];
$cs_explain8 = $objResultm8["cs_explain"];
$cs_38 = $objResultm8["cs_3"];
$cs_48 = $objResultm8["cs_4"];
$cs_58 = $objResultm8["cs_5"];
$sum_cs8 = (($cs_neat8+$cs_explain8+$cs_38+$cs_48+$cs_58)*100)/($Num_Rows8*25);
$cs_aug8 = number_format( $sum_cs8,2)."";
$cs_aug = "$cs_aug8 %";
			
					
//เดือน 9			
$strSQLm9 = "SELECT SUM(sale_neat) As sale_neat,SUM(sale_data) As sale_data,SUM(sale_3) As sale_3,SUM(sale_4) As sale_4,SUM(product_good) As product_good,SUM(product_link) As product_link,SUM(product_corect) As product_corect,SUM(cs_neat) As cs_neat,SUM(cs_explain) As cs_explain,SUM(cs_3) As cs_3,SUM(cs_4) As cs_4,SUM(cs_5) As cs_5  FROM  tb_research where date_research LIKE '%$sep%' and product_good !='0'  and type_customer = '".$type_customer."'";

$objQuerym9 = mysqli_query($com1,$strSQLm9) or die ("Error Query [".$strSQLm9."]");
$objResultm9 = mysqli_fetch_array($objQuerym9);

$sale_neat9 = $objResultm9["sale_neat"];
$sale_data9 = $objResultm9["sale_data"];
$sale_39 = $objResultm9["sale_3"];
$sale_49 = $objResultm9["sale_4"];
$sum_sale9 = (($sale_neat9+$sale_data9+$sale_39+$sale_49)*100)/($Num_Rows9*20);
$sale_sep9 = number_format( $sum_sale9,2)."";
$sale_sep = "$sale_sep9 %";
			
			
$product_good9 = $objResultm9["product_good"];
$product_link9 = $objResultm9["product_link"];
$product_corect9 = $objResultm9["product_corect"];
$sum_pro9 = (($product_good9+$product_link9+$product_corect9)*100)/($Num_Rows9*15);
$pro_sep9= number_format($sum_pro9,2)."";
$pro_sep = "$pro_sep9 %";	
			
			
$cs_neat9 = $objResultm9["cs_neat"];
$cs_explain9 = $objResultm9["cs_explain"];
$cs_39 = $objResultm9["cs_3"];
$cs_49 = $objResultm9["cs_4"];
$cs_59 = $objResultm9["cs_5"];
$sum_cs9 = (($cs_neat9+$cs_explain9+$cs_39+$cs_49+$cs_59)*100)/($Num_Rows9*25);
$cs_sep9 = number_format( $sum_cs9,2)."";
$cs_sep = "$cs_sep9 %";
			
							
//เดือน 10			
$strSQLm10 = "SELECT SUM(sale_neat) As sale_neat,SUM(sale_data) As sale_data,SUM(sale_3) As sale_3,SUM(sale_4) As sale_4,SUM(product_good) As product_good,SUM(product_link) As product_link,SUM(product_corect) As product_corect,SUM(cs_neat) As cs_neat,SUM(cs_explain) As cs_explain,SUM(cs_3) As cs_3,SUM(cs_4) As cs_4,SUM(cs_5) As cs_5  FROM  tb_research where date_research LIKE '%$oat%' and product_good !='0'  and type_customer = '".$type_customer."'";

$objQuerym10 = mysqli_query($com1,$strSQLm10) or die ("Error Query [".$strSQLm10."]");
$objResultm10 = mysqli_fetch_array($objQuerym10);

$sale_neat10 = $objResultm10["sale_neat"];
$sale_data10 = $objResultm10["sale_data"];
$sale_310 = $objResultm10["sale_3"];
$sale_410 = $objResultm10["sale_4"];
$sum_sale10 = (($sale_neat10+$sale_data10+$sale_310+$sale_410)*100)/($Num_Rows10*20);
$sale_oat10 = number_format( $sum_sale10,2)."";
$sale_oat = "$sale_oat10 %";
			
			
$product_good10 = $objResultm10["product_good"];
$product_link10 = $objResultm10["product_link"];
$product_corect10 = $objResultm10["product_corect"];
$sum_pro10 = (($product_good10+$product_link10+$product_corect10)*100)/($Num_Rows10*15);
$pro_oat10= number_format($sum_pro10,2)."";
$pro_oat = "$pro_oat10 %";	
			
			
$cs_neat10 = $objResultm10["cs_neat"];
$cs_explain10 = $objResultm10["cs_explain"];
$cs_310 = $objResultm10["cs_3"];
$cs_410 = $objResultm10["cs_4"];
$cs_510 = $objResultm10["cs_5"];
$sum_cs10 = (($cs_neat10+$cs_explain10+$cs_310+$cs_410+$cs_510)*100)/($Num_Rows10*25);
$cs_oat10 = number_format( $sum_cs10,2)."";
$cs_oat = "$cs_oat10 %";
			
						
//เดือน 11			
$strSQLm11 = "SELECT SUM(sale_neat) As sale_neat,SUM(sale_data) As sale_data,SUM(sale_3) As sale_3,SUM(sale_4) As sale_4,SUM(product_good) As product_good,SUM(product_link) As product_link,SUM(product_corect) As product_corect,SUM(cs_neat) As cs_neat,SUM(cs_explain) As cs_explain,SUM(cs_3) As cs_3,SUM(cs_4) As cs_4,SUM(cs_5) As cs_5  FROM  tb_research where date_research LIKE '%$nov%' and product_good !='0'  and type_customer = '".$type_customer."'";

$objQuerym11 = mysqli_query($com1,$strSQLm11) or die ("Error Query [".$strSQLm11."]");
$objResultm11 = mysqli_fetch_array($objQuerym11);

$sale_neat11 = $objResultm11["sale_neat"];
$sale_data11 = $objResultm11["sale_data"];
$sale_311 = $objResultm11["sale_3"];
$sale_411 = $objResultm11["sale_4"];
$sum_sale11 = (($sale_neat11+$sale_data11+$sale_311+$sale_411)*100)/($Num_Rows11*20);
$sale_nov11 = number_format( $sum_sale11,2)."";
$sale_nov = "$sale_nov11 %";
			
			
$product_good11 = $objResultm11["product_good"];
$product_link11 = $objResultm11["product_link"];
$product_corect11 = $objResultm11["product_corect"];
$sum_pro11 = (($product_good11+$product_link11+$product_corect11)*100)/($Num_Rows11*15);
$pro_nov11 = number_format($sum_pro11,2)."";
$pro_nov = "$pro_nov11 %";	
			
			
$cs_neat11 = $objResultm11["cs_neat"];
$cs_explain11 = $objResultm11["cs_explain"];
$cs_311 = $objResultm11["cs_3"];
$cs_411 = $objResultm11["cs_4"];
$cs_511 = $objResultm11["cs_5"];
$sum_cs11 = (($cs_neat11+$cs_explain11+$cs_311+$cs_411+$cs_511)*100)/($Num_Rows11*25);
$cs_nov11 = number_format( $sum_cs11,2)."";
$cs_nov = "$cs_nov11 %";
			
						
//เดือน 12			
$strSQLm12 = "SELECT SUM(sale_neat) As sale_neat,SUM(sale_data) As sale_data,SUM(sale_3) As sale_3,SUM(sale_4) As sale_4,SUM(product_good) As product_good,SUM(product_link) As product_link,SUM(product_corect) As product_corect,SUM(cs_neat) As cs_neat,SUM(cs_explain) As cs_explain,SUM(cs_3) As cs_3,SUM(cs_4) As cs_4,SUM(cs_5) As cs_5  FROM  tb_research where date_research LIKE '%$Dec%' and product_good !='0'  and type_customer = '".$type_customer."'";

$objQuerym12 = mysqli_query($com1,$strSQLm12) or die ("Error Query [".$strSQLm12."]");
$objResultm12 = mysqli_fetch_array($objQuerym12);

$sale_neat12 = $objResultm12["sale_neat"];
$sale_data12 = $objResultm12["sale_data"];
$sale_312 = $objResultm12["sale_3"];
$sale_412 = $objResultm12["sale_4"];
$sum_sale12 = (($sale_neat12+$sale_data12+$sale_312+$sale_412)*100)/($Num_Rows12*20);
$sale_Dec12 = number_format( $sum_sale12,2)."";
$sale_Dec = "$sale_Dec12 %";
			
			
$product_good12 = $objResultm12["product_good"];
$product_link12 = $objResultm12["product_link"];
$product_corect12 = $objResultm12["product_corect"];
$sum_pro12 = (($product_good12+$product_link12+$product_corect12)*100)/($Num_Rows12*15);
$pro_Dec12 = number_format($sum_pro12,2)."";
$pro_Dec = "$pro_Dec12 %";	
			
			
$cs_neat12 = $objResultm12["cs_neat"];
$cs_explain12 = $objResultm12["cs_explain"];
$cs_312 = $objResultm12["cs_3"];
$cs_412 = $objResultm12["cs_4"];
$cs_512 = $objResultm12["cs_5"];
$sum_cs12 = (($cs_neat12+$cs_explain12+$cs_312+$cs_412+$cs_512)*100)/($Num_Rows12*25);
$cs_Dec12 = number_format( $sum_cs12,2)."";
$cs_Dec = "$cs_Dec12 %";
			
								
			
			
			
			
			
			


$objPHPExcel->setActiveSheetIndex(0)
	
	->setCellValue('C1', 'สรุปการสำรวจลูกค้าภายนอก (หลังการขาย) ประจำปี')
	->setCellValue('D1', $year_1)
	->setCellValue('D2', 'ระดับความพึงพอใจ (%)')  
	->setCellValue('A3', 'No.')
	->setCellValue('B3', 'ข้อมูล')
    ->setCellValue('C3', 'ยอดการสำรวจความพึงพอใจลูกค้าภายนอก (เกรด C)')
	->setCellValue('D3', 'แผนกขาย')
	->setCellValue('E3', 'ด้านสินค้า')
	->setCellValue('F3', 'แผนกบริการลูกค้า')
	->setCellValue('B4', 'มาตรฐาน')
    ->setCellValue('C4', '100%')
	->setCellValue('D4', '80%')
	->setCellValue('E4', '80%')
	->setCellValue('F4', '80%')
	
	->setCellValue('A5', '1')
	->setCellValue('A6', '2')
	->setCellValue('A7', '3')
	->setCellValue('A8', '4')
	->setCellValue('A9', '5')
	->setCellValue('A10', '6')
	->setCellValue('A11', '7')
	->setCellValue('A12', '8')
	->setCellValue('A13', '9')
	->setCellValue('A14', '10')
	->setCellValue('A15', '11')
	->setCellValue('A16', '12')

	
	->setCellValue('B5', 'มกราคม')
	->setCellValue('B6', 'กุมภาพันธ์')
	->setCellValue('B7', 'มีนาคม')
	->setCellValue('B8', 'เมษายน')
	->setCellValue('B9', 'พฤษภาคม')
	->setCellValue('B10', 'มิถุนายน')
	->setCellValue('B11', 'กรกฎาคม')
	->setCellValue('B12', 'สิงหาคม')
	->setCellValue('B13', 'กันยายน')
	->setCellValue('B14', 'ตุลาคม')
	->setCellValue('B15', 'พฤศจิกายน')
	->setCellValue('B16', 'ธันวาคม')

	->setCellValue('C5', $sumall_jan)
	->setCellValue('C6', $sumall_feb)
	->setCellValue('C7', $sumall_march)
	->setCellValue('C8', $sumall_apil)
	->setCellValue('C9', $sumall_may)
	->setCellValue('C10', $sumall_june)
	->setCellValue('C11', $sumall_july)
	->setCellValue('C12', $sumall_aug)
	->setCellValue('C13', $sumall_sep)
	->setCellValue('C14', $sumall_oat)
	->setCellValue('C15', $sumall_nov)
	->setCellValue('C16', $sumall_Dec)
	
	
	->setCellValue('D5', $sale_jan)
	->setCellValue('D6', $sale_feb)
	->setCellValue('D7', $sale_march)
	->setCellValue('D8', $sale_apil)
	->setCellValue('D9', $sale_may)
	->setCellValue('D10', $sale_june)
	->setCellValue('D11', $sale_july)
	->setCellValue('D12', $sale_aug)
	->setCellValue('D13', $sale_sep)
	->setCellValue('D14', $sale_oat)
	->setCellValue('D15', $sale_nov)
	->setCellValue('D16', $sale_Dec)
	
	
	->setCellValue('E5', $pro_jan)
	->setCellValue('E6', $pro_feb)
	->setCellValue('E7', $pro_march)
	->setCellValue('E8', $pro_apil)
	->setCellValue('E9', $pro_may)
	->setCellValue('E10', $pro_june)
	->setCellValue('E11', $pro_july)
	->setCellValue('E12', $pro_aug)
	->setCellValue('E13', $pro_sep)
	->setCellValue('E14', $pro_oat)
	->setCellValue('E15', $pro_nov)
	->setCellValue('E16', $pro_Dec)
	
		->setCellValue('F5', $cs_jan)
	->setCellValue('F6', $cs_feb)
	->setCellValue('F7', $cs_march)
	->setCellValue('F8', $cs_apil)
	->setCellValue('F9', $cs_may)
	->setCellValue('F10', $cs_june)
	->setCellValue('F11', $cs_july)
	->setCellValue('F12', $cs_aug)
	->setCellValue('F13', $cs_sep)
	->setCellValue('F14', $cs_oat)
	->setCellValue('F15', $cs_nov)
	->setCellValue('F16', $cs_Dec)


			;


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
