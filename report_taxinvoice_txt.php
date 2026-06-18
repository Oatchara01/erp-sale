<?
include "dbconnect.php";
include "dbconnect_sale.php";

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


date_default_timezone_set("Asia/Bangkok");
$start_date = $_GET["start_date"];
$end_date = $_GET["end_date"];
$company = $_GET["company"]; 
$time = date('H:i:s');

if($company=='3'){
$tax_all = '0105541072483';
}else if($company=='4'){
$tax_all = '0105552125923';
}

$tempDir = sys_get_temp_dir() . '/download_files_' . time();
mkdir($tempDir);

$strSQL ="SELECT doc_no,doc_release_date,doc_time,bill_id,billing_name,tax_id,billing_tel,ex_post,billing_address,ref_id,po_no,employee_name,email,new_bill,date_oldbill,desnew_bill,pre_name,sale_channel  FROM so__main WHERE select_type_doc ='".$company."' and doc_release_date >='".$start_date."' and doc_release_date <='".$end_date."' and doc_no LIKE '%ET%' and cancel_ckk ='0' and approve_complete='Approve' and new_bill !='0'";
$objQuery =mysqli_query($conn,$strSQL);
$j=1;
while($objResult = mysqli_fetch_array($objQuery))
{	
	
$fileContent ="";	

$si = $objResult["doc_no"];
$sis = "_0";
$sisi = $objResult["new_bill"];
$sisis = $si.$sis.$sisi ;


$doc = explode('/' ,$objResult["doc_no"]);
$doc1 =	$doc[0].'_'.$doc[1];
	
//if($company=='3'){	
$downloadfile = "$tempDir/$sisis.txt";
	/*}else if($company=='4'){	
$downloadfile = "$tempDir/$doc1.txt";		
	}*/

	
$sql = "SELECT email_cus,brun_no,h_ckk,type_customer  FROM tb_customer where customer_id = '".$objResult["bill_id"]."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);

$tax_id_ckk = substr($objResult["tax_id"],0,1);

if($tax_id_ckk=='0'){
$type_tax ='TXID';
}else{
$type_tax ='NIDN';
}

if($rs["h_ckk"]=='2'){
$brun_no =$rs["brun_no"];
}else{
if($tax_id_ckk=='0'){
$brun_no ='00000';
}else{	
$brun_no ='';	
}
}
	
$sale_channel = $objResult["sale_channel"];		
if($sale_channel=='31'){	
$cred = 'CSMT';	
}else{
$cred = "";		
}
	
$tel_ckk = substr($objResult["billing_tel"],0,3);
$tel_bkk = substr($objResult["billing_tel"],3);
$bill_tel = "+$tel_ckk-$tel_bkk";
	
$billing = $objResult["billing_name"];	
$pre_name = $objResult["pre_name"];	
$billing_name = "$pre_name $billing";		
	

$fileContent .= "\"C\",\"".$tax_all."\",\"00000\",\"\"\n";
$fileContent .= "\"H\",\"T03\",\"TAX INVOICE/RECEIPT\",\"".$objResult["doc_no"]."_0".$objResult["new_bill"]."\",\"".$objResult["doc_release_date"]."T".$objResult["doc_time"]."\",\"TIVC01\",\"\",\"".$objResult["doc_no"]."\",\"".$objResult["date_oldbill"]."T".$objResult["doc_time"]."\",\"T03\",\"\",\"\",\"".$objResult["po_no"]."\",\"\",\"\",\"\",\"\",\"".$objResult["employee_name"]."\",\"\",\"\",\"\",\"\",\"00000\",\"\",\"\",\"\",\"Y\",\"".$objResult["doc_no"]."_0".$objResult["new_bill"]."\"\n";
$fileContent .= "\"B\",\"".$objResult["bill_id"]."\",\"".$billing_name."\",\"".$type_tax."\",\"".$objResult["tax_id"]."\",\"".$brun_no."\",\"\",\"\",\"".$objResult["email"]."\",\"\",\"".$objResult["ex_post"]."\",\"\",\"\",\"".$objResult["billing_address"]."\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"TH\"\n";

$strSQL1 = "SELECT sol_name,access_code,access_name,price_per_unit,sale_count,unit_name,sum_amount,discount_unit,product_code FROM (so__submain LEFT JOIN tb_product ON so__submain.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
$i = 1;
while($objResult1 = mysqli_fetch_array($objQuery1))
{
	
if($objResult1["product_code"]=='3196' or $objResult1["product_code"]=='4389' or $objResult1["product_code"]=='3612' or $objResult1["product_code"]=='4401' or $objResult1["product_code"]=='4504' or $objResult1["product_code"]=='4505' or $objResult1["product_code"]=='4506' or $objResult1["product_code"]=='4507'){
$s_01 = "0.00"; 
}else{
$s_01 = number_format($objResult1["sum_amount"]/1.07, 2, '.', ''); 
}	

	
if($objResult1["product_code"]=='3196' or $objResult1["product_code"]=='4389' or $objResult1["product_code"]=='3612' or $objResult1["product_code"]=='4401' or $objResult1["product_code"]=='4504' or $objResult1["product_code"]=='4505' or $objResult1["product_code"]=='4506' or $objResult1["product_code"]=='4507'){
$s_02 = "0.00"; 
}else{ 
$s_02 =  number_format($objResult1["sum_amount"], 2, '.', ''); 
}	
	

if($objResult1["product_code"]=='3196' or $objResult1["product_code"]=='4389' or $objResult1["product_code"]=='3612' or $objResult1["product_code"]=='4401' or $objResult1["product_code"]=='4504' or $objResult1["product_code"]=='4505' or $objResult1["product_code"]=='4506' or $objResult1["product_code"]=='4507'){
	
$fileContent .= "\"L\",\"".$i."\",\"".$objResult1["access_code"]."\",\"".$objResult1["access_name"]."\",\"\",\"\",\"\",\"\",\"\",\"\",\"".number_format($objResult1["price_per_unit"], 2, '.', '' )."\",\"THB\",\"\",\"\",\"\",\"\",\"\",\"".number_format($objResult1["sale_count"], 2, '.', '' )."\",\"\",\"\",\"VAT\",\"7.00\",\"".number_format(($objResult1["price_per_unit"]*$objResult1["sale_count"])/1.07, 2, '.', '' )."\",\"THB\",\"".number_format((($objResult1["price_per_unit"]*$objResult1["sale_count"])/1.07)*0.07, 2, '.', '' )."\",\"THB\",\"false\",\"".number_format(($objResult1["discount_unit"]*$objResult1["sale_count"])/1.07, 2, '.', '' )."\",\"THB\",\"95\",\"\",\"\",\"\",\"".$s_01."\",\"THB\",\"".$s_02."\",\"THB\",\"".$objResult1["unit_name"]."\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"\n";	
	
	
	
}else{	
	
$fileContent .= "\"L\",\"".$i."\",\"".$objResult1["access_code"]."\",\"".$objResult1["access_name"]."\",\"\",\"\",\"\",\"\",\"\",\"\",\"".number_format($objResult1["price_per_unit"], 2, '.', '' )."\",\"THB\",\"\",\"\",\"\",\"\",\"\",\"".number_format($objResult1["sale_count"], 2, '.', '' )."\",\"\",\"\",\"VAT\",\"7.00\",\"".number_format((($objResult1["price_per_unit"]*$objResult1["sale_count"])-($objResult1["discount_unit"]*$objResult1["sale_count"]))/1.07, 2, '.', '' )."\",\"THB\",\"".number_format(((($objResult1["price_per_unit"]*$objResult1["sale_count"])-($objResult1["discount_unit"]*$objResult1["sale_count"]))/1.07)*0.07, 2, '.', '' )."\",\"THB\",\"false\",\"".number_format(($objResult1["discount_unit"]*$objResult1["sale_count"])/1.07, 2, '.', '' )."\",\"THB\",\"95\",\"\",\"\",\"\",\"".$s_01."\",\"THB\",\"".$s_02."\",\"THB\",\"".$objResult1["unit_name"]."\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"\n";	
	
}	

	
$i++;	
}	
	
	
$strSQL2 = "SELECT SUM(sum_amount) AS sum_amount,SUM(sale_count) AS sale_count,SUM(price_per_unit) AS price_per_unit,SUM(discount_unit) AS discount_unit FROM so__submain WHERE ref_idd = '".$objResult["ref_id"]."'";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);
	
$strSQL3 = "SELECT sum_amount,sale_count,price_per_unit,discount_unit FROM so__submain  WHERE ref_idd = '".$objResult["ref_id"]."'";
$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
	
$sum = 0;
$i = 0;	
$sum1 = 0;
$i1 = 0;		
	
while($objResult3 = mysqli_fetch_array($objQuery3))
{

if($objResult3["price_per_unit"]!='0.00'){	
$sum =$objResult3["sum_amount"]+$sum;
$sum++;	
$i++;
}	
	
if($objResult3["discount_unit"]!='0.00'){	
$sum1 =($objResult3["discount_unit"]*$objResult3["sale_count"])+$sum1;
$sum1++;	
$i1++;
}	
	
}	
	
	
$fileContent .= "\"F\",\"".$Num_Rows1."\",\"\",\"\",\"VAT\",\"7.00\",\"".number_format($objResult2["sum_amount"]/1.07, 2, '.', '')."\",\"THB\",\"".number_format(($objResult2["sum_amount"]/1.07)*0.07, 2, '.', '')."\",\"THB\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"".$objResult["doc_release_date"]."T".$objResult["doc_time"]."\",\"\",\"\",\"".number_format($objResult2["sum_amount"]/1.07, 2, '.', '')."\",\"THB\",\"\",\"\",\"".number_format(($sum1-$i1)/1.07, 2, '.', '')."\",\"THB\",\"\",\"\",\"".number_format($objResult2["sum_amount"]/1.07, 2, '.', '')."\",\"THB\",\"".number_format(($objResult2["sum_amount"]/1.07)*0.07, 2, '.', '')."\",\"THB\",\"".number_format($objResult2["sum_amount"], 2, '.', '')."\",\"THB\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"".$cred."\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"\n";	

$fileContent .= "\"T\",\"1\"\n";	
	
file_put_contents($downloadfile, $fileContent, FILE_APPEND);
	
$j++;
} 

$zipFile = sys_get_temp_dir() . '/download_files_' . time() . '.zip';
$zip = new ZipArchive();
$zip->open($zipFile, ZipArchive::CREATE);

$files = glob("$tempDir/*");
foreach ($files as $file) {
    $zip->addFile($file, basename($file));
}

$zip->close();

// Set headers for ZIP file download
header("Content-disposition: attachment; filename=E_Tax_Homecare.zip");
header("Content-Type: application/zip");
header("Content-Length: " . filesize($zipFile));
readfile($zipFile);

// Clean up temporary files and directory
unlink($zipFile);
array_map('unlink', glob("$tempDir/*"));
rmdir($tempDir);


?>
	
	
	
	
	
	
	
	
	
	
	