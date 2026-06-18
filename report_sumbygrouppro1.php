<?php //include('head.php') ;

include "dbconnect.php";


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
}else if($company=='3'){	
$name_com = "โนเบิล เมด บจก.";	
}else{
$name_com = "";

}

if($type_type=='1'){
$type_sale = "แผนกโรงพยาบาล";
}else if($type_type=='2'){
$type_sale = "แผนก Home Care";
}else if($type_type=='3'){
$type_sale = "แผนก อื่นๆ";
}else{
$type_sale = "";
}




$strSQL ="SELECT distinct group_pro,product_no FROM tb__buypro WHERE doc_date >='".$start_date."' and doc_date <='".$end_date."' and  product_no !='2609' and product_no !='4441' ";

if($modepro !=""){ 
    $strSQL .= ' AND group_pro = "'.$modepro.'"'; 
}
if($type_type !=""){ 
    $strSQL .= ' AND type_arae = "'.$type_type.'"'; 
}	 
	 
if($company !=""){ 
    $strSQL .= ' AND company = "'.$company.'"'; 
}
$strSQL .=" order  by group_pro ASC";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);

$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
$save5="insert into tb_mode_proreport (name,product_no) values ('".$objResult["group_pro"]."','".$objResult["product_no"]."')";
$qsave5=mysqli_query($conn,$save5);
}

$strSQL ="SELECT distinct group_pro,product_no FROM tb__buypro WHERE doc_date >='".$start_date1."' and doc_date <='".$end_date1."' and  product_no !='2609' and product_no !='4441' ";

if($modepro !=""){ 
    $strSQL .= ' AND group_pro = "'.$modepro.'"'; 
}
if($type_type !=""){ 
    $strSQL .= ' AND type_arae = "'.$type_type.'"'; 
}	 
	 
if($company !=""){ 
    $strSQL .= ' AND company = "'.$company.'"'; 
}
$strSQL .=" order  by group_pro ASC";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);

$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
$save5="insert into tb_mode_proreport (name,product_no) values ('".$objResult["group_pro"]."','".$objResult["product_no"]."')";
$qsave5=mysqli_query($conn,$save5);
}


?>
 <div class="w3-white">
<div class="w3-container w3-padding-large">

<h3 align="center">รายงานยอดขายเปรียบเทียบตามกลุ่มสินค้า</h3>
<h3 align="center">วันที่ <?php echo Datethai($start_date); ?> ถึง  <?php echo Datethai($end_date); ?> </h3>
<h3 align="center">เปรียบเทียบกับ</h3>
<h3 align="center">วันที่ <?php echo Datethai($start_date1); ?> ถึง  <?php echo Datethai($end_date1); ?> </h3>
<h3 align="center"><?php if($type_type!=''){ echo $type_sale; } ?></h3>
<h3 align="center"><?php if($company!=''){ echo $name_com; } ?></h3><br>



	
<center>
      <h2>
      <div align="center">
        <p align="center" class="style68">
          <?php
error_reporting(E_ALL);
date_default_timezone_set('Europe/London');
require_once 'Classes/PHPExcel.php';
$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");

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
}else if($company=='4'){
$name_com = "โนเบิล เมด บจก.";
}else{
$name_com = "";
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
$end_date_ = Datethai($end_date);
$start_date_1 = Datethai($start_date1);
$end_date_1 = Datethai($end_date1);

$ff1 = "วันที่ $start_date_ ถึง $end_date_";
$ff2 = "วันที่ $start_date_1 ถึง $end_date_1";
$ff3 = "จำนวน $start_date_ ถึง $end_date_";
$ff4 =  "จำนวน $start_date_1 ถึง $end_date_1";
$ff5 = "ยอดขาย $start_date_ ถึง $end_date_";
$ff6 =  "ยอดขาย $start_date_1 ถึง $end_date_1";






			
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




$strSQL ="SELECT distinct name FROM tb_mode_proreport WHERE 1 ";
$objQuery =mysqli_query($conn,$strSQL);
			
$i = 8;
$n=1;


while($objResult=mysqli_fetch_array($objQuery)){

$group_pro = $objResult["name"];


	$objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $group_pro);
	$objPHPExcel->getActiveSheet()->setCellValue('B' . $i, '');
	$objPHPExcel->getActiveSheet()->setCellValue('C' . $i, '');
	$objPHPExcel->getActiveSheet()->setCellValue('D' . $i, '');
	$objPHPExcel->getActiveSheet()->setCellValue('E' . $i, '');
	$objPHPExcel->getActiveSheet()->setCellValue('F' . $i, '');

$i++;
	$n++;



$strSQLs ="SELECT distinct product_no FROM tb_mode_proreport WHERE  name ='".$objResult["name"]."'";
$strSQLs .=" order  by name ASC";	 
$objQuerys =mysqli_query($conn,$strSQLs);

$count_old = 0;
$count_old1 = 0;
$sum_old = 0;
$sum_old1 = 0;
$dis_old = 0;
$dis_old1 = 0;
$k=0;

while($objResults=mysqli_fetch_array($objQuerys)){




$strSQL1 ="SELECT SUM(amount) as amount,SUM(count) as count  FROM tb__buypro  WHERE product_no = '".$objResults["product_no"]."' and group_pro ='".$objResult["name"]."'";

if($start_date !=""){ 
    $strSQL1 .= ' AND doc_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL1 .= ' AND doc_date <= "'.$end_date.'"'; 
}
if($type_type !=""){ 
    $strSQL1 .= ' AND type_arae = "'.$type_type.'"'; 
}	

if($company !=""){ 
    $strSQL1 .= ' AND company = "'.$company.'"'; 
}	 


$objQuery1 =mysqli_query($conn,$strSQL1);
$objResult1 = mysqli_fetch_array($objQuery1);	
	
	

//ลดหนี้

$strSQL11 ="SELECT SUM(amount) as amount  FROM tb__discash  WHERE  product_no = '".$objResults["product_no"]."'  and group_1 ='".$objResult["name"]."'";

if($start_date !=""){ 
    $strSQL11 .= ' AND date_cash >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL11 .= ' AND date_cash <= "'.$end_date.'"'; 
}
if($type_type !=""){ 
    $strSQL11 .= ' AND type_arae = "'.$type_type.'"'; 
}	 

if($company !=""){ 
    $strSQL11 .= ' AND company = "'.$company.'"'; 
}	 

$objQuery11 =mysqli_query($conn,$strSQL11);
$objResult11 = mysqli_fetch_array($objQuery11);	
	





////ล่าสุด

$strSQL_1 ="SELECT SUM(amount) as amount,SUM(count) as count  FROM tb__buypro  WHERE product_no = '".$objResults["product_no"]."' and group_pro ='".$objResult["name"]."'";

if($start_date1 !=""){ 
    $strSQL_1 .= ' AND doc_date >= "'.$start_date1.'"'; 
}

if($end_date1 !=""){ 
    $strSQL_1 .= ' AND doc_date <= "'.$end_date1.'"'; 
}
if($type_type !=""){ 
    $strSQL_1 .= ' AND type_arae = "'.$type_type.'"'; 
}	

if($company !=""){ 
    $strSQL_1 .= ' AND company = "'.$company.'"'; 
}	 


$objQuery_1 =mysqli_query($conn,$strSQL_1);
$objResult_1 = mysqli_fetch_array($objQuery_1);	
	
	

//ลดหนี้

$strSQL11 ="SELECT SUM(amount) as amount  FROM tb__discash  WHERE  product_no = '".$objResults["product_no"]."'  and group_1 ='".$objResult["name"]."'";

if($start_date1 !=""){ 
    $strSQL11 .= ' AND date_cash >= "'.$start_date1.'"'; 
}

if($end_date1 !=""){ 
    $strSQL11 .= ' AND date_cash <= "'.$end_date1.'"'; 
}
if($type_type !=""){ 
    $strSQL11 .= ' AND type_arae = "'.$type_type.'"'; 
}	 

if($company !=""){ 
    $strSQL11 .= ' AND company = "'.$company.'"'; 
}	 

$objQuery11 =mysqli_query($conn,$strSQL11);
$objResult_11 = mysqli_fetch_array($objQuery11);	
	




	
$strSQL75 = "SELECT sol_name,access_code  FROM tb_product WHERE  product_ID='".$objResults["product_no"]."'";
$objQuery75 = mysqli_query($conn,$strSQL75) or die ("Error Query [".$strSQL75."]");
$objResult75 = mysqli_fetch_array($objQuery75);

$amount_sum1 = $objResult_1["amount"];
$count_sum1 = $objResult_1["count"];
$dis_sum1 = $objResult_11["amount"];	

$amount_sum = $objResult1["amount"];
$count_sum = $objResult1["count"];
$dis_sum = $objResult11["amount"];	
	
	
$count_old += $count_sum;
$count_old1 += $count_sum1;
$sum_old +=$amount_sum;
$sum_old1 +=$amount_sum1;
$dis_old  += $dis_sum;
$dis_old1 += $dis_sum1;
	


$access_code = $objResult75["access_code"]; 
$sol_name = $objResult75["sol_name"];
$count_sum27 = number_format($count_sum,0);
$count_sum37 = number_format($count_sum1,0);
$count_sum27_27 = number_format(($amount_sum-$dis_sum),2);
$count_sum37_37 = number_format(($amount_sum1-$dis_sum1),2); 

	$objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $access_code);
	$objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $sol_name);
	$objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $count_sum27);
	$objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $count_sum37);
	$objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $count_sum27_27);
	$objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $count_sum37_37);



$i++;
	$n++;
	$k++;
$count_old++;
$count_old1++;
$sum_old++;
$sum_old1++;
$dis_old++;
$dis_old1++;



}



$countw_sum27 = number_format($count_old-$k,0);
$countw_sum37 = number_format($count_old1-$k,0);
$countw_sum27_27 = number_format(($sum_old-$dis_old),2);
$countw_sum37_37 = number_format(($sum_old1-$dis_old1),2); 


	$objPHPExcel->getActiveSheet()->setCellValue('A' . $i,'ยอดรวม');
	$objPHPExcel->getActiveSheet()->setCellValue('B' . $i, '');
	$objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $countw_sum27);
	$objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $countw_sum37);
	$objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $countw_sum27_27);
	$objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $countw_sum37_37);





$n++;

$i++;
}



$strSQL1 ="SELECT SUM(amount) as amount,SUM(count) as count  FROM tb__buypro  WHERE   1";

if($start_date !=""){ 
    $strSQL1 .= ' AND doc_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL1 .= ' AND doc_date <= "'.$end_date.'"'; 
}
if($type_type !=""){ 
    $strSQL1 .= ' AND type_arae = "'.$type_type.'"'; 
}	

if($company !=""){ 
    $strSQL1 .= ' AND company = "'.$company.'"'; 
}	 


$objQuery1 =mysqli_query($conn,$strSQL1);
$objResult1 = mysqli_fetch_array($objQuery1);	
	
	

//ลดหนี้

$strSQL11 ="SELECT SUM(amount) as amount  FROM tb__discash  WHERE    1";

if($start_date !=""){ 
    $strSQL11 .= ' AND date_cash >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL11 .= ' AND date_cash <= "'.$end_date.'"'; 
}
if($type_type !=""){ 
    $strSQL11 .= ' AND type_arae = "'.$type_type.'"'; 
}	 

if($company !=""){ 
    $strSQL11 .= ' AND company = "'.$company.'"'; 
}	 

$objQuery11 =mysqli_query($conn,$strSQL11);
$objResult11 = mysqli_fetch_array($objQuery11);	
	
$amount_sum = $objResult1["amount"];
$count_sum = $objResult1["count"];
$dis_sum = $objResult11["amount"];	




////ล่าสุด

$strSQL1 ="SELECT SUM(amount) as amount,SUM(count) as count  FROM tb__buypro  WHERE    1";

if($start_date1 !=""){ 
    $strSQL1 .= ' AND doc_date >= "'.$start_date1.'"'; 
}

if($end_date1 !=""){ 
    $strSQL1 .= ' AND doc_date <= "'.$end_date1.'"'; 
}
if($type_type !=""){ 
    $strSQL1 .= ' AND type_arae = "'.$type_type.'"'; 
}	

if($company !=""){ 
    $strSQL1 .= ' AND company = "'.$company.'"'; 
}	 


$objQuery1 =mysqli_query($conn,$strSQL1);
$objResult1 = mysqli_fetch_array($objQuery1);	
	
	

//ลดหนี้

$strSQL11 ="SELECT SUM(amount) as amount  FROM tb__discash  WHERE   1";

if($start_date1 !=""){ 
    $strSQL11 .= ' AND date_cash >= "'.$start_date1.'"'; 
}

if($end_date1 !=""){ 
    $strSQL11 .= ' AND date_cash <= "'.$end_date1.'"'; 
}
if($type_type !=""){ 
    $strSQL11 .= ' AND type_arae = "'.$type_type.'"'; 
}	 

if($company !=""){ 
    $strSQL11 .= ' AND company = "'.$company.'"'; 
}	 

$objQuery11 =mysqli_query($conn,$strSQL11);
$objResult11 = mysqli_fetch_array($objQuery11);	
	
$amount_sum1 = $objResult1["amount"];
$count_sum1 = $objResult1["count"];
$dis_sum1 = $objResult11["amount"];	

$count_sum27 = number_format($count_sum,0);
$count_sum37 = number_format($count_sum1,0);
$count_sum27_27 = number_format(($amount_sum-$dis_sum),2);
$count_sum37_37 = number_format(($amount_sum1-$dis_sum1),2); 


	$objPHPExcel->getActiveSheet()->setCellValue('A' . $i,'ยอดรวม');
	$objPHPExcel->getActiveSheet()->setCellValue('B' . $i, '');
	$objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $count_sum27);
	$objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $count_sum37);
	$objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $count_sum27_27);
	$objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $count_sum37_37);





// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('sumbygroup');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// Save Excel 2007 file
echo"<a href='sumbygroup.xlsx'><img src='img/download_now_v2.gif' width='262' height='98' /></a>";
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$strFileName = "sumbygroup.xlsx";
$objWriter->save($strFileName);
	
	
	
	
	
?>	
	
	

 <table width="90%" border="1" cellpadding="0"  cellspacing="0" align="center">
  <thead>
 <tr> 
 
	<th width="10%">รหัสสินค้า</th>
	<th width="20%">ชื่อสินค้า </th>
	<?php if($count_ckk=='1'){ ?>
    <th width="10%">จำนวน <br><font color="red"> วันที่ <?php echo Datethai($start_date); ?><br> ถึง <br> <?php echo Datethai($end_date); ?> </font></th>
	<th width="10%">จำนวน  <br><font color="red"> วันที่ <?php echo Datethai($start_date1); ?><br> ถึง  <br><?php echo Datethai($end_date1); ?> </font></th> 
	 <?php } ?>
	<?php if($price_ckk=='1'){ ?>
    <th width="10%">ยอดขาย <br><font color="red"> วันที่ <?php echo Datethai($start_date); ?><br> ถึง <br><?php echo Datethai($end_date); ?> </font></th>
	<th width="10%">ยอดขาย  <br><font color="red"> วันที่ <?php echo Datethai($start_date1); ?><br> ถึง  <br><?php echo Datethai($end_date1); ?> </font></th> 
	 <?php } ?>
   
  </tr>
  </thead>
  
<?php


$strSQL ="SELECT distinct name FROM tb_mode_proreport WHERE 1 ";
$objQuery =mysqli_query($conn,$strSQL);
while($objResult=mysqli_fetch_array($objQuery)){

?>

 <tr> 
	 <td align="left"><font color ="blue"><b>หมวดสินค้า : </b></font></td>
      <td align="left"><font color ="blue"><b><?php echo $objResult["name"]; ?></b></font></td>
	 <?php if($count_ckk=='1'){ ?>
	  <td align="right"></td> 
	  <td align="right"></td> 
	 <?php } ?>
	<?php if($price_ckk=='1'){ ?>
      <td align="right"></td> 
	  <td align="right"></td>  
	  <?php } ?>

    </tr>	

<?php
$strSQLs ="SELECT distinct product_no FROM tb_mode_proreport WHERE  name ='".$objResult["name"]."'";
$strSQLs .=" order  by name ASC";	 
$objQuerys =mysqli_query($conn,$strSQLs);

$count_old = 0;
$count_old1 = 0;
$sum_old = 0;
$sum_old1 = 0;
$dis_old = 0;
$dis_old1 = 0;
$k=0;

while($objResults=mysqli_fetch_array($objQuerys)){




$strSQL1 ="SELECT SUM(amount) as amount,SUM(count) as count  FROM tb__buypro  WHERE product_no = '".$objResults["product_no"]."' and group_pro ='".$objResult["name"]."'";

if($start_date !=""){ 
    $strSQL1 .= ' AND doc_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL1 .= ' AND doc_date <= "'.$end_date.'"'; 
}
if($type_type !=""){ 
    $strSQL1 .= ' AND type_arae = "'.$type_type.'"'; 
}	

if($company !=""){ 
    $strSQL1 .= ' AND company = "'.$company.'"'; 
}	 


$objQuery1 =mysqli_query($conn,$strSQL1);
$objResult1 = mysqli_fetch_array($objQuery1);	
	
	

//ลดหนี้

$strSQL11 ="SELECT SUM(amount) as amount  FROM tb__discash  WHERE  product_no = '".$objResults["product_no"]."'  and group_1 ='".$objResult["name"]."'";

if($start_date !=""){ 
    $strSQL11 .= ' AND date_cash >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL11 .= ' AND date_cash <= "'.$end_date.'"'; 
}
if($type_type !=""){ 
    $strSQL11 .= ' AND type_arae = "'.$type_type.'"'; 
}	 

if($company !=""){ 
    $strSQL11 .= ' AND company = "'.$company.'"'; 
}	 

$objQuery11 =mysqli_query($conn,$strSQL11);
$objResult11 = mysqli_fetch_array($objQuery11);	
	
$amount_sum = $objResult1["amount"];
$count_sum = $objResult1["count"];
$dis_sum = $objResult11["amount"];	




////ล่าสุด

$strSQL1 ="SELECT SUM(amount) as amount,SUM(count) as count  FROM tb__buypro  WHERE product_no = '".$objResults["product_no"]."' and group_pro ='".$objResult["name"]."'";

if($start_date1 !=""){ 
    $strSQL1 .= ' AND doc_date >= "'.$start_date1.'"'; 
}

if($end_date1 !=""){ 
    $strSQL1 .= ' AND doc_date <= "'.$end_date1.'"'; 
}
if($type_type !=""){ 
    $strSQL1 .= ' AND type_arae = "'.$type_type.'"'; 
}	

if($company !=""){ 
    $strSQL1 .= ' AND company = "'.$company.'"'; 
}	 


$objQuery1 =mysqli_query($conn,$strSQL1);
$objResult1 = mysqli_fetch_array($objQuery1);	
	
	

//ลดหนี้

$strSQL11 ="SELECT SUM(amount) as amount  FROM tb__discash  WHERE  product_no = '".$objResults["product_no"]."'  and group_1 ='".$objResult["name"]."'";

if($start_date1 !=""){ 
    $strSQL11 .= ' AND date_cash >= "'.$start_date1.'"'; 
}

if($end_date1 !=""){ 
    $strSQL11 .= ' AND date_cash <= "'.$end_date1.'"'; 
}
if($type_type !=""){ 
    $strSQL11 .= ' AND type_arae = "'.$type_type.'"'; 
}	 

if($company !=""){ 
    $strSQL11 .= ' AND company = "'.$company.'"'; 
}	 

$objQuery11 =mysqli_query($conn,$strSQL11);
$objResult11 = mysqli_fetch_array($objQuery11);	
	
$amount_sum1 = $objResult1["amount"];
$count_sum1 = $objResult1["count"];
$dis_sum1 = $objResult11["amount"];	



$count_old += $count_sum;
$count_old1 += $count_sum1;
$sum_old +=$amount_sum;
$sum_old1 +=$amount_sum1;
$dis_old  += $dis_sum;
$dis_old1 += $dis_sum1;

	
$strSQL75 = "SELECT sol_name,access_code  FROM tb_product WHERE  product_ID='".$objResults["product_no"]."'";
$objQuery75 = mysqli_query($conn,$strSQL75) or die ("Error Query [".$strSQL75."]");
$objResult75 = mysqli_fetch_array($objQuery75);

?>
  
    <tr> 
	  <td align="left"><?php echo $objResult75["access_code"]; ?></td>
      <td align="left"><?php echo $objResult75["sol_name"]; ?></td>
		<?php if($count_ckk=='1'){ ?>
	  <td align="right"><?php echo number_format($count_sum,0); ?></td> 
	  <td align="right"><?php echo number_format($count_sum1,0); ?></td> 
		 <?php } ?>
	<?php if($price_ckk=='1'){ ?>
      <td align="right"><?php echo number_format(($amount_sum-$dis_sum),2); ?></td>  
	  <td align="right"><?php echo number_format(($amount_sum1-$dis_sum1),2); ?></td>  
	 <?php } ?>

    </tr>

	<?php 
	$k++; 


$count_old++;
$count_old1++;
$sum_old++;
$sum_old1++;
$dis_old++;
$dis_old1++;

}


	
	
	 
?>
	 
 <tr> 
	 <td align="left"><font color ="red"><b>รวมยอดทั้งหมด : </b></font></td>
      <td align="left"></td>
	 <?php if($count_ckk=='1'){ ?>
	  <td align="right"><font color ="red"><b><?php echo number_format($count_old-$k,0); ?></b></font></td> 
	  <td align="right"><font color ="red"><b><?php echo number_format($count_old1-$k,0); ?></b></font></td> 
		 <?php } ?>
	<?php if($price_ckk=='1'){ ?>
      <td align="right"><font color ="red"><b><?php echo number_format((($sum_old)-$dis_old),2); ?></b></font></td>  
	  <td align="right"><font color ="red"><b><?php echo number_format((($sum_old1)-$dis_old1),2); ?></b></font></td>  
	

    </tr>	
		 
	 <tr> 
	 <td align="left"></td>
       <td align="left"></td>
		  <td align="left"></td>
		  <td align="left"></td>
		  <td align="left"></td>
		  <td align="left"></td>
	 <?php } ?>

    </tr>	 

	 <?php
	 }

$strSQL1 ="SELECT SUM(amount) as amount,SUM(count) as count  FROM tb__buypro  WHERE   1";

if($start_date !=""){ 
    $strSQL1 .= ' AND doc_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL1 .= ' AND doc_date <= "'.$end_date.'"'; 
}
if($type_type !=""){ 
    $strSQL1 .= ' AND type_arae = "'.$type_type.'"'; 
}	

if($company !=""){ 
    $strSQL1 .= ' AND company = "'.$company.'"'; 
}
	 
if($modepro !=""){ 
    $strSQL1 .= ' AND group_pro = "'.$modepro.'"'; 
}

$objQuery1 =mysqli_query($conn,$strSQL1);
$objResult1 = mysqli_fetch_array($objQuery1);	
	
	

//ลดหนี้

$strSQL11 ="SELECT SUM(amount) as amount  FROM tb__discash  WHERE    1";

if($start_date !=""){ 
    $strSQL11 .= ' AND date_cash >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL11 .= ' AND date_cash <= "'.$end_date.'"'; 
}
if($type_type !=""){ 
    $strSQL11 .= ' AND type_arae = "'.$type_type.'"'; 
}	 

if($company !=""){ 
    $strSQL11 .= ' AND company = "'.$company.'"'; 
}	 
	 
if($modepro !=""){ 
    $strSQL11 .= ' AND group_1 = "'.$modepro.'"'; 
}
	
$objQuery11 =mysqli_query($conn,$strSQL11);
$objResult11 = mysqli_fetch_array($objQuery11);	
	
$amount_sum = $objResult1["amount"];
$count_sum = $objResult1["count"];
$dis_sum = $objResult11["amount"];	




////ล่าสุด

$strSQL1 ="SELECT SUM(amount) as amount,SUM(count) as count  FROM tb__buypro  WHERE    1";

if($start_date1 !=""){ 
    $strSQL1 .= ' AND doc_date >= "'.$start_date1.'"'; 
}

if($end_date1 !=""){ 
    $strSQL1 .= ' AND doc_date <= "'.$end_date1.'"'; 
}
if($type_type !=""){ 
    $strSQL1 .= ' AND type_arae = "'.$type_type.'"'; 
}	

if($company !=""){ 
    $strSQL1 .= ' AND company = "'.$company.'"'; 
}	 
if($modepro !=""){ 
    $strSQL1 .= ' AND group_pro = "'.$modepro.'"'; 
}

$objQuery1 =mysqli_query($conn,$strSQL1);
$objResult1 = mysqli_fetch_array($objQuery1);	
	
	

//ลดหนี้

$strSQL11 ="SELECT SUM(amount) as amount  FROM tb__discash  WHERE   1";

if($start_date1 !=""){ 
    $strSQL11 .= ' AND date_cash >= "'.$start_date1.'"'; 
}

if($end_date1 !=""){ 
    $strSQL11 .= ' AND date_cash <= "'.$end_date1.'"'; 
}
if($type_type !=""){ 
    $strSQL11 .= ' AND type_arae = "'.$type_type.'"'; 
}	 

if($company !=""){ 
    $strSQL11 .= ' AND company = "'.$company.'"'; 
}
	if($modepro !=""){ 
    $strSQL11 .= ' AND group_1 = "'.$modepro.'"'; 
}
 

$objQuery11 =mysqli_query($conn,$strSQL11);
$objResult11 = mysqli_fetch_array($objQuery11);	
	
$amount_sum1 = $objResult1["amount"];
$count_sum1 = $objResult1["count"];
$dis_sum1 = $objResult11["amount"];	


	


?>
  
    <tr> 
	 <td align="left"><font color ="blue"><b>รวมยอดทั้งหมด : </b></font></td>
      <td align="left"></td>
	 <?php if($count_ckk=='1'){ ?>
	  <td align="right"><font color ="blue"><b><?php echo number_format($count_sum,0); ?></b></font></td> 
	  <td align="right"><font color ="blue"><b><?php echo number_format($count_sum1,0); ?></b></font></td> 
		 <?php } ?>
	<?php if($price_ckk=='1'){ ?>
      <td align="right"><font color ="blue"><b><?php echo number_format(($amount_sum-$dis_sum),2); ?></b></font></td>  
	  <td align="right"><font color ="blue"><b><?php echo number_format(($amount_sum1-$dis_sum1),2); ?></b></font></td>  
	 <?php } ?>


    </tr>	



</table>

<br>
</div>

</div>

<div id="cr_bar"> <?php include "foot.php"; ?></div>




