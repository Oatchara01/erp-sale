<?php include "test.php"; ?>
<?php include "error_page.php"; ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>บัตรสมาชิก</title>


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
<center>
     
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
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A1', 'รหัสบัตรสมาชิก')
            ->setCellValue('B1', 'ชื่อลูกค้า')
			->setCellValue('C1', 'วันเกิด')
			->setCellValue('D1', 'อาชีพ')
			->setCellValue('E1', 'ที่อยู่')
			->setCellValue('F1', 'จังหวัด')
			->setCellValue('G1', 'เบอร์โทร')
			->setCellValue('H1', 'Email')
			->setCellValue('I1', 'เขตการขาย')
			->setCellValue('J1', 'ประเภทลูกค้า')
			->setCellValue('K1', 'วันเกิด')
			->setCellValue('L1', 'สถานภาพสมรส')
			->setCellValue('M1', 'รายได้ต่อเดือน')
			->setCellValue('N1', 'ท่านสนใจสินค้าสำหรับ')
			->setCellValue('O1', 'ท่านรุ้จัก Allwel ครั้งแรกได้อย่างไร')
			->setCellValue('P1', 'สิ่งสำคัญในการเลือกซื้อสินค้า / บริการ')
			->setCellValue('Q1', 'ท่านเคยซื้อสินค้าจาก Allwell หรือไม่ ?')
			->setCellValue('R1', 'สถานะลูกค้า')
			->setCellValue('S1', 'อื่นๆ')
				
			;


function DateThai($strDate)
	{
		$strYear1 = date("Y",strtotime($strDate))+543;
		$strYear = substr($strYear1, 2 ,2);
		$strMonth= date("n",strtotime($strDate));
		$strDay= date("j",strtotime($strDate));
		$strHour= date("H",strtotime($strDate));
		$strMinute= date("i",strtotime($strDate));
		$strSeconds= date("s",strtotime($strDate));
		$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		$strMonthThai=$strMonthCut[$strMonth];
		return "$strDay $strMonthThai $strYear";
	}

// Write data from MySQL result
include"dbconnect.php";

$Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';
$occupation = isset($_GET['occupation']) ? $_GET['occupation'] : '';
$month = isset($_GET['month']) ? $_GET['month'] : '';
/*$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';*/
$salary  = isset($_GET['salary']) ? $_GET['salary'] : '';
$customer_no  = isset($_GET['customer_no']) ? $_GET['customer_no'] : '';
$cus_tel = isset($_GET['cus_tel']) ? $_GET['cus_tel'] : '';
$product_fer1  = isset($_GET['product_fer1']) ? $_GET['product_fer1'] : '';
$product_fer2  = isset($_GET['product_fer2']) ? $_GET['product_fer2'] : '';
$product_fer3  = isset($_GET['product_fer3']) ? $_GET['product_fer3'] : '';
$product_fer4  = isset($_GET['product_fer4']) ? $_GET['product_fer4'] : '';
$well_allwell = isset($_GET['well_allwell']) ? $_GET['well_allwell'] : '';	
$best_service1 = isset($_GET['best_service1']) ? $_GET['best_service1'] : '';	
$best_service2 = isset($_GET['best_service2']) ? $_GET['best_service2'] : '';
$best_service3 = isset($_GET['best_service3']) ? $_GET['best_service3'] : '';
$best_service4 = isset($_GET['best_service4']) ? $_GET['best_service4'] : '';
$status_cus = isset($_GET['status_cus']) ? $_GET['status_cus'] : '';

$strSQL = "SELECT *  FROM tb_customer  where customer_no !='' and close_ckk ='0'";

if($month !=""){ 
    $strSQL .= ' AND month = "'.$month.'"'; 
}	
/*if($start_date !=""){ 
    $strSQL .= ' AND brithday >= "'.$start_date.'"'; 
}
if($end_date !=""){ 
    $strSQL .= ' AND brithday <= "'.$end_date.'"'; 
}*/

if($occupation !=""){ 
	$strSQL .= ' AND occupation  = "'.$occupation.'"'; 
}
if($salary !=""){ 
	$strSQL .= ' AND salary  = "'.$salary.'"'; 
}

if($product_fer1 !=''){
$strSQL .= ' AND product_fer1  = "'.$product_fer1.'"'; 
}
if($product_fer2 !=''){
$strSQL .= ' AND product_fer2  = "'.$product_fer2.'"'; 
}
if($product_fer3 !=''){
$strSQL .= ' AND product_fer3  = "'.$product_fer3.'"'; 
}
if($product_fer4 !=''){
$strSQL .= ' AND product_fer4  = "'.$product_fer4.'"'; 
}
if($well_allwell !=''){
$strSQL .= ' AND well_allwell  = "'.$well_allwell.'"'; 
}

if($best_service1 !=''){
$strSQL .= ' AND best_service1  = "'.$best_service1.'"'; 
}
if($best_service12!=''){
$strSQL .= ' AND best_service2  = "'.$best_service2.'"'; 
}
if($best_service3 !=''){
$strSQL .= ' AND best_service3  = "'.$best_service3.'"'; 
}
if($best_service4 !=''){
$strSQL .= ' AND best_service4  = "'.$best_service4.'"'; 
}

if($status_cus !=''){
$strSQL .= ' AND status_cus  = "'.$status_cus.'"'; 
}

if($customer_no !=''){
$strSQL .= ' AND customer_no  = "'.$customer_no.'"'; 	
}
if($cus_tel !=''){
$strSQL .= ' AND cus_tel  LIKE "%'.$cus_tel.'%"'; 		
}


$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
//echo $strSQL;
$i = 2;
$n=1;
$sum = 0;
while($objResult = mysqli_fetch_array($objQuery))
{
	
$email_cus=$objResult["email_cus"];
$cus_tel =$objResult["cus_tel"];
$sale_code =$objResult["sale_code"];
$cus_province=$objResult["cus_province"];
$occupation =$objResult["occupation"];
$customer_name  =$objResult["customer_name"];
$customer_no  =$objResult["customer_no"];
$cus_address =$objResult["cus_address"];
$type_customer = $objResult["type_customer"];
$brithday = DateThai($objResult["brithday"]);	
$status = $objResult["status"];	
$salary = $objResult["salary"];
if($salary=='1'){
$salary_1 = '<30,000 ฿';	
}else if($salary=='2'){
$salary_1 = '30,001 - 50,000 ฿';	
}else if($salary=='3'){
$salary_1 = '50,001 - 100,000 ฿';	
}else if($salary=='4'){
$salary_1 = '100,001 - 200,000 ฿';	
}else if($salary=='5'){
$salary_1 = '>200,000 ฿';	
}else{
$salary_1 = '-';	
}
$product_fer1 = $objResult["product_fer1"];	
$product_fer2 = $objResult["product_fer2"];	
$product_fer3 = $objResult["product_fer3"];	
$product_fer4 = $objResult["product_fer4"];

if($product_fer1 =='0')	{
$product_1	='';
}else{
$product_1	='ผู้ป่วยพักฟื้น';	
}

if($product_fer2 =='0')	{
$product_2	='';
}else{
$product_2	='ผู้สูงอายุ';	
}
	
if($product_fer3 =='0')	{
$product_3	='';
}else{
$product_3	='ผู้ป่วยติดเตียง';	
}
	
if($product_fer4 =='0')	{
$product_4	='';
}else{
$product_4	='สินค้าดูแลสุขภาพ';	
}	
$product_sum ="$product_1,$product_2,$product_3,$product_4";
	
$well_allwell = $objResult["well_allwell"];	
if($well_allwell=='1'){	
$well_allwell1 = 'ผลการค้นหาบน Google';	
}else if($well_allwell=='2'){
$well_allwell1 = 'โฆษณา Banner บน Website';	
}else if($well_allwell=='3'){
$well_allwell1 = 'คนรู้จัก / บุคลากรทางการแพทย์แนะนำ';	
}else if($well_allwell=='4'){
$well_allwell1 = 'รู้จักจาก ฟาร์ ทริลเลียน';	
}else if($well_allwell=='2'){
$well_allwell1 = 'อื่นๆ';	
}	
	
$best_service1 = $objResult["best_service1"];
$best_service2 = $objResult["best_service2"];
$best_service3 = $objResult["best_service3"];
	
if($best_service1 =='0')	{
$best_1	='';
}else{
$best_1	='บริการก่อนและหลังการขาย';	
}
if($best_service2 =='0')	{
$best_2	='';
}else{
$best_2	='ความน่าเชื่อถือของบริษัท';	
}	
if($best_service3 =='0')	{
$best_3	='';
}else{
$best_3	='สินค้าที่มีคุณภาพ';	
}

$best_sum = "$best_1,$best_2,$best_3";
$best_service4 = $objResult["best_service4"];

if($best_service4=='1'){
$best_4	='เคย';
}else{
$best_4	='ไม่เคย';	
}
	
$status_cus = $objResult["status_cus"];	
if($status_cus=='0'){
$status_cus1 ='Gold Customer';	
}else if($status_cus=='1'){
$status_cus1 ='Platinum Customer';		
}else if($status_cus=='2'){
$status_cus1 ='Daimond Customer';		
}else{
$status_cus1 ='';		
}
	
$description = $objResult["description"];	
$brithday = Datethai($objResult["brithday"]);	
	
	
$strSQL1 = "SELECT  type_name  FROM tb_typecustomer  where  type_id ='".$type_customer."' ";	
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$objResult1 = mysqli_fetch_array($objQuery1);	

$type_name = $objResult1["type_name"];	

	$objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $customer_no);
	$objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $customer_name);
	$objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $brithday);
	$objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $occupation);
	$objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $cus_address);
	$objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $cus_province);
	$objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $cus_tel);
	$objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $email_cus);
	$objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $sale_code);
	$objPHPExcel->getActiveSheet()->setCellValue('J' . $i, $type_name);
	$objPHPExcel->getActiveSheet()->setCellValue('K' . $i, $brithday);
	$objPHPExcel->getActiveSheet()->setCellValue('L' . $i, $status);
	$objPHPExcel->getActiveSheet()->setCellValue('M' . $i, $salary_1);
	$objPHPExcel->getActiveSheet()->setCellValue('N' . $i, $product_sum);
	$objPHPExcel->getActiveSheet()->setCellValue('O' . $i, $well_allwell1);
	$objPHPExcel->getActiveSheet()->setCellValue('P' . $i, $best_sum);
	$objPHPExcel->getActiveSheet()->setCellValue('Q' . $i, $best_4);
	$objPHPExcel->getActiveSheet()->setCellValue('R' . $i, $status_cus1);
	$objPHPExcel->getActiveSheet()->setCellValue('S' . $i, $description);
	
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
        <p align="center"><a href="add_customer_rgister.php" target="_self"><span class="style63">กลับหน้าค้นหา</a> </span></p>
      </div>
      <div class="cleaner"></div>
   
</center>
<!-- end of wrapper -->
<div id="cr_bar_wrapper">
  <div id="cr_bar"><?php include "foot.php"; ?></div>
</div>
</body>
</html>
