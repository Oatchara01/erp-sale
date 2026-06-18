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

$strSQL ="SELECT iv_no,iv_date,iv_time,bill_id,bill_name,tax_id,bill_tel,bill_address,ref_id,po_no,sale_code,email  FROM hos__so WHERE type_doc ='".$company."' and iv_date >='".$start_date."' and iv_date <='".$end_date."' and iv_no LIKE '%ET%' and status_doc='Approve' and new_bill='0'";
$objQuery =mysqli_query($conn,$strSQL);
$j=1;
while($objResult = mysqli_fetch_array($objQuery))
{	
	
$fileContent ="";	

$sisis = $objResult["iv_no"];
	
$doc = explode('/' ,$objResult["iv_no"]);
$doc1 =	$doc[0].'_'.$doc[1];
	
$downloadfile = "$tempDir/$sisis.txt";	
/*if($company=='3'){	
	}else if($company=='4'){	
$downloadfile = "$tempDir/$doc1.txt";		
	}*/

	
$sql = "SELECT email_cus,brun_no,h_ckk,bill_postcode  FROM tb_customer where customer_id = '".$objResult["bill_id"]."'";
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
	
$tel_ckk = substr($objResult["bill_tel"],0,3);
$tel_bkk = substr($objResult["bill_tel"],3);
$bill_tel = "+$tel_ckk-$tel_bkk";

$fileContent .= "\"C\",\"".$tax_all."\",\"00000\",\"\"\n";
$fileContent .= "\"H\",\"T03\",\"TAX INVOICE/RECEIPT\",\"".$objResult["iv_no"]."\",\"".$objResult["iv_date"]."T".$objResult["iv_time"]."\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"".$objResult["po_no"]."\",\"\",\"\",\"\",\"\",\"".$objResult["sale_code"]."\",\"\",\"\",\"\",\"\",\"00000\",\"\",\"\",\"\",\"Y\",\"".$objResult["iv_no"]."\"\n";
$fileContent .= "\"B\",\"".$objResult["bill_id"]."\",\"".$objResult["bill_name"]."\",\"".$type_tax."\",\"".$objResult["tax_id"]."\",\"".$brun_no."\",\"\",\"\",\"".$objResult["email"]."\",\"\",\"".$rs["bill_postcode"]."\",\"\",\"\",\"".$objResult["bill_address"]."\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"TH\"\n";

$strSQL1 = "SELECT sol_name,access_code,access_name,price,count,unit_name,amount,discount,product_code FROM (hos__subso LEFT JOIN tb_product ON hos__subso.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
$i = 1;
while($objResult1 = mysqli_fetch_array($objQuery1))
{
	
if($objResult1["product_code"]=='3196' or $objResult1["product_code"]=='4389' or $objResult1["product_code"]=='3612' or $objResult1["product_code"]=='4401' or $objResult1["product_code"]=='4504' or $objResult1["product_code"]=='4505' or $objResult1["product_code"]=='4506' or $objResult1["product_code"]=='4507'){
$s_01 = "0.00"; 
}else{
$s_01 = number_format($objResult1["amount"]/1.07, 2, '.', ''); 
}	

	
if($objResult1["product_code"]=='3196' or $objResult1["product_code"]=='4389' or $objResult1["product_code"]=='3612' or $objResult1["product_code"]=='4401' or $objResult1["product_code"]=='4504' or $objResult1["product_code"]=='4505' or $objResult1["product_code"]=='4506' or $objResult1["product_code"]=='4507'){
$s_02 = "0.00"; 
}else{ 
$s_02 =  number_format($objResult1["amount"], 2, '.', ''); 
}	
	
	
	
if($objResult1["product_code"]=='3196' or $objResult1["product_code"]=='4389' or $objResult1["product_code"]=='3612' or $objResult1["product_code"]=='4401' or $objResult1["product_code"]=='4504' or $objResult1["product_code"]=='4505' or $objResult1["product_code"]=='4506' or $objResult1["product_code"]=='4507'){
	
$fileContent .= "\"L\",\"".$i."\",\"".$objResult1["access_code"]."\",\"".$objResult1["access_name"]."\",\"\",\"\",\"\",\"\",\"\",\"\",\"".number_format($objResult1["price"], 2, '.', '' )."\",\"THB\",\"\",\"\",\"\",\"\",\"\",\"".number_format($objResult1["count"], 2, '.', '' )."\",\"\",\"\",\"VAT\",\"7.00\",\"".number_format(($objResult1["price"]*$objResult1["count"])/1.07, 2, '.', '' )."\",\"THB\",\"".number_format((($objResult1["price"]*$objResult1["count"])/1.07)*0.07, 2, '.', '' )."\",\"THB\",\"false\",\"".number_format(($objResult1["discount"]*$objResult1["count"])/1.07, 2, '.', '' )."\",\"THB\",\"95\",\"\",\"\",\"\",\"".$s_01."\",\"THB\",\"".$s_02."\",\"THB\",\"".$objResult1["unit_name"]."\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"\n";	
	
	
}else{	
	
$fileContent .= "\"L\",\"".$i."\",\"".$objResult1["access_code"]."\",\"".$objResult1["access_name"]."\",\"\",\"\",\"\",\"\",\"\",\"\",\"".number_format($objResult1["price"], 2, '.', '' )."\",\"THB\",\"\",\"\",\"\",\"\",\"\",\"".number_format($objResult1["count"], 2, '.', '' )."\",\"\",\"\",\"VAT\",\"7.00\",\"".number_format((($objResult1["price"]*$objResult1["count"])-($objResult1["discount"]*$objResult1["count"]))/1.07, 2, '.', '' )."\",\"THB\",\"".number_format(((($objResult1["price"]*$objResult1["count"])-($objResult1["discount"]*$objResult1["count"]))/1.07)*0.07, 2, '.', '' )."\",\"THB\",\"false\",\"".number_format(($objResult1["discount"]*$objResult1["count"])/1.07, 2, '.', '' )."\",\"THB\",\"95\",\"\",\"\",\"\",\"".$s_01."\",\"THB\",\"".$s_02."\",\"THB\",\"".$objResult1["unit_name"]."\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"\n";	

}

	
$i++;	
}	
	
	
$strSQL2 = "SELECT SUM(amount) AS amount,SUM(count) AS count,SUM(price) AS price,SUM(discount) AS discount FROM hos__subso WHERE ref_idd = '".$objResult["ref_id"]."'";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);
	
$strSQL3 = "SELECT amount,count,price,discount FROM hos__subso  WHERE ref_idd = '".$objResult["ref_id"]."'";
$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
	
$sum = 0;
$i = 0;	
$sum1 = 0;
$i1 = 0;		
	
while($objResult3 = mysqli_fetch_array($objQuery3))
{

if($objResult3["price"]!='0.00'){	
$sum =$objResult3["amount"]+$sum;
$sum++;	
$i++;
}	
	
if($objResult3["discount"]!='0.00'){	
$sum1 =($objResult3["discount"]*$objResult3["count"])+$sum1;
$sum1++;	
$i1++;
}	
	
}	
	
	
$fileContent .= "\"F\",\"".$Num_Rows1."\",\"\",\"\",\"VAT\",\"7.00\",\"".number_format($objResult2["amount"]/1.07, 2, '.', '')."\",\"THB\",\"".number_format(($objResult2["amount"]/1.07)*0.07, 2, '.', '')."\",\"THB\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"".$objResult["iv_date"]."T".$objResult["iv_time"]."\",\"\",\"\",\"".number_format($objResult2["amount"]/1.07, 2, '.', '')."\",\"THB\",\"\",\"\",\"".number_format(($sum1-$i1)/1.07, 2, '.', '')."\",\"THB\",\"\",\"\",\"".number_format($objResult2["amount"]/1.07, 2, '.', '')."\",\"THB\",\"".number_format(($objResult2["amount"]/1.07)*0.07, 2, '.', '')."\",\"THB\",\"".number_format($objResult2["amount"], 2, '.', '')."\",\"THB\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"\n";	

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
header("Content-disposition: attachment; filename=E_Tax_Hospital.zip");
header("Content-Type: application/zip");
header("Content-Length: " . filesize($zipFile));
readfile($zipFile);

// Clean up temporary files and directory
unlink($zipFile);
array_map('unlink', glob("$tempDir/*"));
rmdir($tempDir);


?>
	
	
	
	
	
	
	
	
	
	
	