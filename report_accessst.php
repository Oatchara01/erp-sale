
<?php include('head.php'); ?>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

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
      <h2>
      <div align="center">
        <p align="center"><span class="style63">Download ข้อมูลลงทะเบียน Access Stoc</span><span class="style68"><br />
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
			->setCellValue('A1', 'วันที่')
	        ->setCellValue('B1', 'เลขที่เอกสาร')
            ->setCellValue('C1', 'ชื่อลูกค้า')
			->setCellValue('D1', 'ชื่อพนักงาน')
			->setCellValue('E1', 'รหัสสินค้า')
			->setCellValue('F1', 'ประเภทเอกสาร')
			->setCellValue('G1', 'จำนวนจ่าย')
			->setCellValue('H1', 'หมายเหตุ')
			
			;



include"dbconnect.php";
$start_date=$_GET["start_date"];	
$end_date=$_GET["end_date"];	

			
     
   
$strSQL = "SELECT stock_date,order_id,customer_name,employee_name,select_type_doc,ref_id,delivery_contact,billing_name,doc_no  FROM so__main  WHERE cancel_ckk='0' and  sale_channel != ''";

			
if($start_date !=""){ 

    $strSQL .= ' AND stock_date >= "'.$start_date.'"'; 

}

if($end_date !=""){ 
    $strSQL .= ' AND stock_date <= "'.$end_date.'"'; 

}

//echo $strSQL;
//exit();

$strSQL .=" order  by ref_id ASC  ";	

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);



//$objQuery  = mysql_query($strSQL);



$i = 2;
$n=2;
$sum = 0;

while($objResult = mysqli_fetch_array($objQuery))
{
$ref_id = $objResult["ref_id"];	
	
$strSQL1 = "SELECT stock_remark,product_id,sale_count FROM so__submain WHERE ref_idd = '".$ref_id."'";
	//echo $strSQL1;
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);	
while($objResult1 = mysqli_fetch_array($objQuery1))
{



if($objResult["customer_name"]!=""){
	$customer_name = $objResult["customer_name"];
}else if ($objResult["delivery_contact"]){
	$customer_name = $objResult["delivery_contact"];
}else{
	$customer_name = $objResult["billing_name"];
}
	
	if($objResult["select_type_doc"] =="1" or $objResult["select_type_doc"] =="2"){
	$select_type_doc = 'BRN / BRN P';
	}else{
	$select_type_doc = 'IV';
	}

	if($objResult["order_id"] !=''){
    $order_id = $objResult["order_id"];	 
	}else{
	 $order_id = $objResult["doc_no"];	 		
	}
    $employee_name = $objResult["employee_name"];
    $stock_date = DateThai($objResult["stock_date"]);
    
	$product_id = $objResult1["product_id"];
     $count = $objResult1["sale_count"];

     $stock_remark = $objResult1["stock_remark"];
	
$strSQL2 = "SELECT access_code_old FROM tb_product WHERE product_ID = '".$product_id."'";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$Num_Rows2 = mysqli_num_rows($objQuery2);	
while($objResult2 = mysqli_fetch_array($objQuery2))
{
$access_code = $objResult2["access_code_old"];	
	
	
	$objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $stock_date);
	$objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $order_id);
	$objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $customer_name);
	$objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $employee_name );
	$objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $access_code );
	$objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $select_type_doc);
	$objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $count);
	$objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $stock_remark);
	
	$i++;
	$n++;
}
}
}
	//$sum = $sum + $objResult["score"]; 







// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('accessstock');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// Save Excel 2007 file
echo"<a href='accessstock.xlsx'><img src='img/download_now_v2.gif' width='262' height='98' /></a>";
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$strFileName = "accessstock.xlsx";
$objWriter->save($strFileName);


?>
          </span></p>
       
      </div>
      <div class="cleaner"></div>
    </div>
    <!-- end of main -->
  </div>
  <!-- end of main wrapper -->
</div>
</center>
<!-- end of wrapper -->

</body>
</html>
<?php require_once('foot.php'); ?>
