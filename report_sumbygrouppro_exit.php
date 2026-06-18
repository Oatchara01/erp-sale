<?php include "dbconnect.php"; ?>
<?php include "error_page.php"; ?>
<?php
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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="shortcut icon" href="allwell.png" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/form_style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/w3.css">


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
 <div class="w3-white">
<div class="w3-container w3-padding-large">

	<center>
      <h2>
      <div align="center">
        <p align="left"><span class="style63">Download รายงานยอดขายเปรียบเทียบตามกลุ่มสินค้า</span><span class="style68"><br />
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
// Add some data
		include"dbconnect.php";

$start_date = $_GET["start_date"];
$end_date = $_GET["end_date"];
$start_date1 = $_GET["start_date1"];
$end_date1 = $_GET["end_date1"];
$modepro = $_GET["modepro"]; 
$company = $_GET["company"]; 
$type_type = $_GET["type_type"];
$price_ckk = $_GET["price_ckk"];
$count_ckk = $_GET["count_ckk"];

if($company=='3'){
$name_com = "ออลล์เวล ไลฟ์ บจก.";
}else{
$name_com = "โนเบิล เมด บจก.";

}

if($type_type=='1'){
$type_sale = "แผนกโรงพยาบาล";
}else if($type_type=='2'){
$type_sale = "แผนก Home Care";
}else if($type_type==''){
$type_sale = "";
}else{
$type_sale = "แผนก อื่นๆ";
}
$start_date_ = Datethai($start_date);
$start_date_ = Datethai($end_date);
$start_date_1 = Datethai($start_date1);
$start_date_1 = Datethai($end_date1);

$ff1 = "วันที่ $start_date_ ถึง $end_date_";
$ff2 = "วันที่ $start_date_1 ถึง $end_date_1";
$ff3 = "จำนวน $start_date_ ถึง $end_date_";
$ff4 =  "จำนวน $start_date_1 ถึง $end_date_1";
$ff5 = "ยอดขาย $start_date_ ถึง $end_date_";
$ff6 =  "ยอดขาย $start_date_1 ถึง $end_date_1";



$strSQL ="SELECT distinct product_no,group_pro FROM tb__buypro WHERE company ='".$company."' and product_no !='2609' and product_no !='4441'";

if($start_date !=""){ 
    $strSQL .= ' AND doc_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND doc_date <= "'.$end_date.'"'; 
}
if($modepro !=""){ 
    $strSQL .= ' AND group_pro = "'.$modepro.'"'; 
}
if($type_type !=""){ 
    $strSQL .= ' AND type_arae = "'.$type_type.'"'; 
}	 
	 
$strSQL .=" order  by group_pro ASC";	 
$objQuery =mysqli_query($conn,$strSQL);
while($objResult=mysqli_fetch_array($objQuery)){

$strSQL1 ="SELECT SUM(amount) as amount  FROM tb__buypro  WHERE company = '".$company."'  and product_no = '".$objResult["product_no"]."' and group_pro ='".$objResult["group_pro"]."'";

if($start_date !=""){ 
    $strSQL1 .= ' AND doc_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL1 .= ' AND doc_date <= "'.$end_date.'"'; 
}
if($type_type !=""){ 
    $strSQL1 .= ' AND type_arae = "'.$type_type.'"'; 
}	 


$objQuery1 =mysqli_query($conn,$strSQL1);
$objResult1 = mysqli_fetch_array($objQuery1);	
	
	
$strSQL2 ="SELECT SUM(count) as count  FROM tb__buypro  WHERE company = '".$company."'  and product_no = '".$objResult["product_no"]."'  and group_pro ='".$objResult["group_pro"]."'";

if($start_date !=""){ 
    $strSQL2 .= ' AND doc_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL2 .= ' AND doc_date <= "'.$end_date.'"'; 
}	
if($type_type !=""){ 
    $strSQL2 .= ' AND type_arae = "'.$type_type.'"'; 
}	 
	
$objQuery2 =mysqli_query($conn,$strSQL2);
$objResult2 = mysqli_fetch_array($objQuery2);	
	
	
	
//ลดหนี้

$strSQL11 ="SELECT SUM(amount) as amount  FROM tb__discash  WHERE company = '".$company."'  and product_no = '".$objResult["product_no"]."'  and group_1 ='".$objResult["group_pro"]."'";

if($start_date !=""){ 
    $strSQL11 .= ' AND date_cash >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL11 .= ' AND date_cash <= "'.$end_date.'"'; 
}
if($type_type !=""){ 
    $strSQL11 .= ' AND type_arae = "'.$type_type.'"'; 
}	 

$objQuery11 =mysqli_query($conn,$strSQL11);
$objResult11 = mysqli_fetch_array($objQuery11);	
	
$amount_sum = $objResult1["amount"];
$count_sum = $objResult2["count"];
$dis_sum = $objResult11["amount"];	


	
$strSQL17 = "SELECT *  FROM tb__bypro_no2   WHERE product_no = '".$objResult["product_no"]."'  and group_pro ='".$objResult["group_pro"]."' ";
if($start_date !=""){ 
$strSQL17 .= ' AND date_cash = "'.$start_date.'"'; 
}

$objQuery17 = mysqli_query($conn,$strSQL17) or die ("Error Query [".$strSQL17."]");
$Num_Rows17 = mysqli_num_rows($objQuery17);
if($Num_Rows17 > 0){

$strSQL71 = "UPDATE tb__bypro_no2 SET amount_sum='".$amount_sum."',count_sum='".$count_sum."',dis_sum='".$dis_sum."' where product_no='".$objResult["product_no"]."'   and group_pro ='".$objResult["group_pro"]."'  and date_cash ='".$start_date."'";
$objQuery71 = mysqli_query($conn,$strSQL71);	
	

}else{

	
$strSQL71 = "insert into tb__bypro_no2 (product_no,amount_sum,count_sum,dis_sum,group_pro,date_cash) values ('".$objResult["product_no"]."','".$amount_sum."','".$count_sum."','".$dis_sum."','".$objResult["group_pro"]."','".$start_date."')";
//echo $strSQL71;
$objQuery71 = mysqli_query($conn,$strSQL71);

}	
	
}
	 
	 
$strSQL ="SELECT distinct product_no,group_pro FROM tb__buypro WHERE company ='".$company."' ";

if($start_date !=""){ 
    $strSQL .= ' AND doc_date >= "'.$start_date1.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND doc_date <= "'.$end_date1.'"'; 
}
	if($type_type !=""){ 
    $strSQL .= ' AND type_arae = "'.$type_type.'"'; 
}	 
if($modepro !=""){ 
    $strSQL .= ' AND group_pro = "'.$modepro.'"'; 
} 
$strSQL .=" order  by group_pro ASC";		 
$objQuery =mysqli_query($conn,$strSQL);
while($objResult=mysqli_fetch_array($objQuery)){

$strSQL1 ="SELECT SUM(amount) as amount  FROM tb__buypro  WHERE company = '".$company."'  and product_no = '".$objResult["product_no"]."' and group_pro ='".$objResult["group_pro"]."'";

if($start_date !=""){ 
    $strSQL1 .= ' AND doc_date >= "'.$start_date1.'"'; 
}

if($end_date !=""){ 
    $strSQL1 .= ' AND doc_date <= "'.$end_date1.'"'; 
}
if($type_type !=""){ 
    $strSQL1 .= ' AND type_arae = "'.$type_type.'"'; 
}	 

$objQuery1 =mysqli_query($conn,$strSQL1);
$objResult1 = mysqli_fetch_array($objQuery1);	
	
	
$strSQL2 ="SELECT SUM(count) as count  FROM tb__buypro  WHERE company = '".$company."' and product_no = '".$objResult["product_no"]."'  and group_pro ='".$objResult["group_pro"]."'";

if($start_date !=""){ 
    $strSQL2 .= ' AND doc_date >= "'.$start_date1.'"'; 
}

if($end_date !=""){ 
    $strSQL2 .= ' AND doc_date <= "'.$end_date1.'"'; 
}	
if($type_type !=""){ 
    $strSQL2 .= ' AND type_arae = "'.$type_type.'"'; 
}	 
	
$objQuery2 =mysqli_query($conn,$strSQL2);
$objResult2 = mysqli_fetch_array($objQuery2);	
	
	
	
//ลดหนี้

$strSQL11 ="SELECT SUM(amount) as amount  FROM tb__discash  WHERE company = '".$company."' and product_no = '".$objResult["product_no"]."'  and group_1 ='".$objResult["group_pro"]."'";

if($start_date !=""){ 
    $strSQL11 .= ' AND date_cash >= "'.$start_date1.'"'; 
}

if($end_date !=""){ 
    $strSQL11 .= ' AND date_cash <= "'.$end_date1.'"'; 
}
if($type_type !=""){ 
    $strSQL11 .= ' AND type_arae = "'.$type_type.'"'; 
}	 

$objQuery11 =mysqli_query($conn,$strSQL11);
$objResult11 = mysqli_fetch_array($objQuery11);	
	
$amount_sum = $objResult1["amount"];
$count_sum = $objResult2["count"];
$dis_sum = $objResult11["amount"];	


	
$strSQL17 = "SELECT *  FROM tb__bypro_no2   WHERE product_no = '".$objResult["product_no"]."'  and group_pro ='".$objResult["group_pro"]."' ";
if($start_date1 !=""){ 
$strSQL17 .= ' AND date_cash = "'.$start_date1.'"'; 
}

$objQuery17 = mysqli_query($conn,$strSQL17) or die ("Error Query [".$strSQL17."]");
$Num_Rows17 = mysqli_num_rows($objQuery17);
if($Num_Rows17 > 0){

$strSQL71 = "UPDATE tb__bypro_no2 SET amount_sum='".$amount_sum."',count_sum='".$count_sum."',dis_sum='".$dis_sum."' where product_no='".$objResult["product_no"]."'   and group_pro ='".$objResult["group_pro"]."'  and date_cash ='".$start_date."'";

	
$objQuery71 = mysqli_query($conn,$strSQL71);	
	

}else{

	
$strSQL71 = "insert into tb__bypro_no2 (product_no,amount_sum,count_sum,dis_sum,group_pro,date_cash) values ('".$objResult["product_no"]."','".$amount_sum."','".$count_sum."','".$dis_sum."','".$objResult["group_pro"]."','".$start_date1."')";
//echo $strSQL71;
$objQuery71 = mysqli_query($conn,$strSQL71);

}	
	
}
	 
	 



$strSQL7 = "SELECT distinct group_pro  FROM tb__bypro_no2   Order by group_pro ASC ";
$objQuery7 = mysqli_query($conn,$strSQL7) or die ("Error Query [".$strSQL7."]");
$Num_Rows7 = mysqli_num_rows($objQuery7);


			
$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('B1', 'รายงานยอดขายเปรียบเทียบตามกลุ่มสินค้า')
	->setCellValue('B2', $ff1)
            ->setCellValue('B3', 'เปรียบเทียบกับ ')
			->setCellValue('B4', $ff2)
			->setCellValue('B5', $type_sale)
			->setCellValue('B6', $name_com)

			->setCellValue('A7', 'รหัสสินค้า')
			->setCellValue('B7', 'ชื่อสินค้า ')
			->setCellValue('C7', $ff3)
			->setCellValue('D7', $ff4)
			->setCellValue('E7', $ff5)
			->setCellValue('F7', $ff6)

			

	
			;





$i = 8;
$n=1;



while($objResult7=mysqli_fetch_array($objQuery7)){

$group_pro = $objResult7["group_pro"];


	$objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $group_pro);
	$objPHPExcel->getActiveSheet()->setCellValue('B' . $i, '');
	$objPHPExcel->getActiveSheet()->setCellValue('C' . $i, '');
	$objPHPExcel->getActiveSheet()->setCellValue('D' . $i, '');
	$objPHPExcel->getActiveSheet()->setCellValue('E' . $i, '');
	$objPHPExcel->getActiveSheet()->setCellValue('F' . $i, '');

$i++;
	$n++;



$strSQL71 = "SELECT distinct product_no  FROM tb__bypro_no2 WHERE  group_pro ='".$objResult7["group_pro"]."'  Order by amount_sum DESC ";
$objQuery71 = mysqli_query($conn,$strSQL71) or die ("Error Query [".$strSQL71."]");
$Num_Rows71 = mysqli_num_rows($objQuery71);
while($objResult71=mysqli_fetch_array($objQuery71)){
	
	
	
$strSQL75 = "SELECT sol_name,access_code  FROM tb_product WHERE  product_ID='".$objResult71["product_no"]."'";
$objQuery75 = mysqli_query($conn,$strSQL75) or die ("Error Query [".$strSQL75."]");
$objResult75 = mysqli_fetch_array($objQuery75);


$strSQL27 = "SELECT *  FROM tb__bypro_no2   WHERE product_no = '".$objResult71["product_no"]."'  and group_pro ='".$objResult7["group_pro"]."' ";
if($start_date !=""){ 
$strSQL27 .= ' AND date_cash = "'.$start_date.'"'; 
}
$objQuery27 = mysqli_query($conn,$strSQL27) or die ("Error Query [".$strSQL27."]");	
$objResult27 = mysqli_fetch_array($objQuery27);	
	
	
$strSQL37 = "SELECT *  FROM tb__bypro_no2   WHERE product_no = '".$objResult71["product_no"]."'  and group_pro ='".$objResult7["group_pro"]."' ";
if($start_date1 !=""){ 
$strSQL37 .= ' AND date_cash = "'.$start_date1.'"'; 
}
$objQuery37 = mysqli_query($conn,$strSQL37) or die ("Error Query [".$strSQL37."]");	
$objResult37 = mysqli_fetch_array($objQuery37);	


$access_code = $objResult75["access_code"]; 
$sol_name = $objResult75["sol_name"];
$count_sum27 = number_format($objResult27["count_sum"],2);
$count_sum37 = number_format($objResult37["count_sum"],2);

$count_sum27_27 = number_format((($objResult27["amount_sum"]-$objResult27["dis_sum"])/1.07),2);
$count_sum37_37 = number_format((($objResult37["amount_sum"]-$objResult37["dis_sum"])/1.07),2); 

	$objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $access_code);
	$objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $sol_name);
	$objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $count_sum27);
	$objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $count_sum37);
	$objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $count_sum27_27);
	$objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $count_sum37_37);



$i++;
	$n++;

}

$i++;
}




// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('sumbygroup');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// Save Excel 2007 file
echo"<a href='sumbygroup.xlsx'><img src='img/download_now_v2.gif' width='262' height='98' /></a>";
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$strFileName = "sumbygroup.xlsx";
$objWriter->save($strFileName);


///////////-------------------------


/*}
//อื่นๆ
else
{
echo"<br /><strong><h3><span class='style63'>ไม่สามารถดำเนินการได้ ติดต่อผู้ดูแลระบบค่ะ</span></h3></strong><br />";
}*/
?>
          </span></p>


        <p align="center"><a href="report_sumbygrouppro.php" target="_self"><span class="style63">กลับหน้าค้นหา</a> </span></p>
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
<div id="cr_bar"> <?php include "foot.php"; ?></div>

</div>
</body>
</html>
