
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
        <p align="center"><span class="style63">Download รายการติดตั้ง</span><span class="style68"><br />
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
			->setCellValue('A1', 'รหัสสินนค้า')
	        ->setCellValue('B1', 'ชื่อลูกค้า')
            ->setCellValue('C1', 'เบอร์โทร')
			->setCellValue('D1', 'ที่อยู่')
			->setCellValue('E1', 'จังหวัด')
			->setCellValue('F1', 'รหัสไปรษณีย์')
			->setCellValue('G1', 'วันที่ซื้อ')
			->setCellValue('H1', 'ระยะรับประกัน')
			->setCellValue('I1', 'PM')
			->setCellValue('J1', 'CAL')
			->setCellValue('K1', 'เลขที่เอกสาร')
            ->setCellValue('L1', 'จำนวนรับประกัน')
	        ->setCellValue('M1', 'หมายเหตุ')
			->setCellValue('N1', 'ชื่อสินค้า')
			;



include"dbconnect.php";
$start_date=$_GET["start_date"];	
$end_date=$_GET["end_date"];	

			
     
   
$strSQL = "SELECT sn_number,customer_name,id,doc_no,cal,pm,warranty,register_date,postcode,province,delivery_place,billing_address,address2,address1,billing_tel,tel,billing_name,delivery_contact,product_id  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE 1";

if($start_date !=""){ 

    $strSQL .= ' AND register_date >= "'.$start_date.'"'; 

}

if($end_date !=""){ 
    $strSQL .= ' AND register_date <= "'.$end_date.'"'; 

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
	$sn_number =  $objResult["sn_number"];

$str_arr = explode("\n",$sn_number);


foreach ($str_arr as $test =>$value){
$product_sn = $str_arr[$test];
$product_sn1 =  trim($product_sn);

if($objResult["customer_name"]!=""){
	$customer_name = $objResult["customer_name"];
}else if ($objResult["delivery_contact"]){
	$customer_name = $objResult["delivery_contact"];
}else{
	$customer_name = $objResult["billing_name"];
}
	
	if($objResult["tel"]!=""){
	$tel = $objResult["tel"];
	}else{
		$tel = $objResult["billing_tel"];	
	}
	if($objResult["address1"]!=""){
	$address1 = $objResult["address1"];
    $address2 = $objResult["address2"];	
    $address = "$address1 $address2";
	}else if($objResult["billing_address"]!=""){
	 $address = $objResult["billing_address"];		
	}else{
	$address = $objResult["delivery_place"];		
	}
    $province = $objResult["province"];	 
    $postcode = $objResult["postcode"];
    $register_date = $objResult["register_date"];
    $warranty = $objResult["warranty"];
	$warranty1 ="$warranty year";
    $pm = $objResult["pm"];
    $cal = $objResult["cal"];
 	$doc_no = $objResult["doc_no"];
	$id = $objResult["id"];
	$product_id = $objResult["product_id"];
$strSQL1 = "SELECT sale_remark FROM so__submain WHERE id = '".$id."'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);	
while($objResult1 = mysqli_fetch_array($objQuery1))
{
$sale_remark = $objResult1["sale_remark"];
	
$strSQL2 = "SELECT sol_name FROM tb_product WHERE product_ID = '".$product_id."'";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$Num_Rows2 = mysqli_num_rows($objQuery2);	
while($objResult2 = mysqli_fetch_array($objQuery2))
{
$sol_name = $objResult2["sol_name"];	
	
	
	$objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $product_sn1);
	$objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $customer_name);
	$objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $tel);
	$objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $address );
	$objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $province );
	$objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $postcode);
	$objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $register_date);
	$objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $warranty1);
	$objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $pm);
	$objPHPExcel->getActiveSheet()->setCellValue('J' . $i, $cal);
	$objPHPExcel->getActiveSheet()->setCellValue('k' . $i, $doc_no);
	$objPHPExcel->getActiveSheet()->setCellValue('L' . $i, $warranty);
	$objPHPExcel->getActiveSheet()->setCellValue('M' . $i, $sale_remark);
		$objPHPExcel->getActiveSheet()->setCellValue('N' . $i, $sol_name);
	$i++;
	$n++;
}
}
}
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
        <p align="center"><a href="search_service_engineer.php" target="_self"><span class="style63">กลับหน้าค้นหา</a> </span></p>
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
