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
//and iv_no_ref LIKE '%IV%' 
$strSQL ="SELECT credit_no,date_credit,bill_id,customer_name,customer_tel,address_name,ref_credit,ref_id,sale_code,iv_no_ref,return_des  FROM tb_credit_note WHERE company_type ='".$company."' and date_credit >='".$start_date."' and date_credit <='".$end_date."' and credit_no !='' and status_doc='Approve' and new_bill='0' and iv_no_ref LIKE '%ET%'";
$objQuery =mysqli_query($conn,$strSQL);
$j=1;
while($objResult = mysqli_fetch_array($objQuery))
{	
	
	
$strSQL9 = "SELECT iv_no_ref FROM tb_credit_note  WHERE ref_credit = '".$objResult["ref_credit"]."' and sale_code LIKE '%SOL%'";
$objQuery9 = mysqli_query($conn,$strSQL9) or die(mysqli_error());
$objResult9 = mysqli_fetch_array($objQuery9);

if($objResult9["iv_no_ref"]==''){

$sql1 = "SELECT *  FROM hos__so where iv_no = '".$objResult["iv_no_ref"]."'";
$qry1 = mysqli_query($conn,$sql1) or die(mysqli_error());
$rs1 = mysqli_fetch_assoc($qry1);
$iv_no = $rs1["iv_no"];	
$iv_date = $rs1["iv_date"];	
$iv_time = $rs1["iv_time"];	
$doc_date = "$iv_dateT$iv_time";	
$sale_channel = "";
	
}else{
	
$sql1 = "SELECT ref_id,doc_no,doc_release_date,doc_time,bill_id,billing_name,tax_id,billing_tel,ex_post,billing_address,ref_id,po_no,employee_name,email,sale_channel  FROM so__main where doc_no = '".$objResult["iv_no_ref"]."'";
$qry1 = mysqli_query($conn,$sql1) or die(mysqli_error());
$rs1 = mysqli_fetch_assoc($qry1);
	
$sale_channel = $rs1["sale_channel"];	
$iv_no = $rs1["doc_no"];	
$iv_date = $rs1["doc_release_date"];	
$iv_time = $rs1["doc_time"];	
	
$doc_date = "$iv_dateT$iv_time";	
	
}
	

	
$fdsfse = substr($rs1["ref_id"],0,2);	
//echo $fdsfse;	
	
$fileContent ="";	

$sisis = $objResult["credit_no"];
$doc = explode('/' ,$objResult["credit_no"]);
$doc1 =	$doc[0].'_'.$doc[1];
	
if($company=='3'){	
$downloadfile = "$tempDir/$sisis.txt";
	}else if($company=='4'){	
$downloadfile = "$tempDir/$doc1.txt";		
	}
	
	
if($sale_channel=='31'){	
$cred = 'CSMT';	
$iv_no_1 = $iv_no;		
}else{
$cred = "";	
$iv_no_1 = "";		
}	
	

	
$sql = "SELECT email_cus,bill_postcode,brun_no,h_ckk,tax_id  FROM tb_customer where customer_id = '".$objResult["bill_id"]."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);




$tax_id_ckk = substr($rs1["tax_id"],0,1);

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
	
$tel_ckk = substr($objResult["customer_tel"],0,3);
$tel_bkk = substr($objResult["customer_tel"],3);
$bill_tel = "+$tel_ckk-$tel_bkk";

$fileContent .= "\"C\",\"".$tax_all."\",\"00000\",\"\"\n";
$fileContent .= "\"H\",\"81\",\"ใบลดหนี้/รับคินสินค้า\",\"".$objResult["credit_no"]."\",\"".$objResult["date_credit"]."T00:00:00\",\"CDNG99\",\"".$objResult["remark_et"]."\",\"".$objResult["iv_no_ref"]."\",\"".$iv_date."T".$iv_time."\",\"81\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"".$objResult["sale_code"]."\",\"\",\"\",\"\",\"\",\"00000\",\"\",\"\",\"\",\"Y\",\"".$objResult["credit_no"]."\"\n";

$fileContent .= "\"B\",\"".$rs1["bill_id"]."\",\"".$objResult["customer_name"]."\",\"".$type_tax."\",\"".$rs1["tax_id"]."\",\"".$brun_no."\",\"\",\"\",\"".$rs1["email"]."\",\"\",\"".$rs["bill_postcode"]."\",\"\",\"\",\"".$objResult["address_name"]."\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"TH\"\n";
	
	
$strSQL1 = "SELECT sol_name,access_code,access_name,unit_price,count,unit_name,sum_amount,discount_unit,sum_discount,tb_subcredit.product_id FROM (tb_subcredit LEFT JOIN tb_product ON tb_subcredit.product_ID=tb_product.product_id) WHERE ref_creditt = '".$objResult["ref_credit"]."'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
$i = 1;
while($objResult1 = mysqli_fetch_array($objQuery1))
{
	
/*$strSQL22 = "SELECT SUM(sum_amount) AS sum_amount FROM so__submain WHERE ref_idd = '".$rs1["ref_id"]."'";
$objQuery22 = mysqli_query($conn,$strSQL22) or die ("Error Query [".$strSQL2."]");
$objResult22 = mysqli_fetch_array($objQuery22);	*/
	
	
if($objResult1["product_id"]=='3196' or $objResult1["product_id"]=='4389' or $objResult1["product_id"]=='3612' or $objResult1["product_id"]=='4401' or $objResult1["product_id"]=='4504' or $objResult1["product_id"]=='4505' or $objResult1["product_id"]=='4506' or $objResult1["product_id"]=='4507'){
$s_01 = "0.00"; 
}else{
$s_01 = number_format($objResult1["sum_amount"]/1.07, 2, '.', ''); 
}	

	
if($objResult1["product_id"]=='3196' or $objResult1["product_id"]=='4389' or $objResult1["product_id"]=='3612' or $objResult1["product_id"]=='4401' or $objResult1["product_id"]=='4504' or $objResult1["product_id"]=='4505' or $objResult1["product_id"]=='4506' or $objResult1["product_id"]=='4507'){
$s_02 = "0.00"; 
}else{ 
$s_02 =  number_format($objResult1["sum_amount"], 2, '.', ''); 
}
	
	
	
$fileContent .= "\"L\",\"".$i."\",\"".$objResult1["access_code"]."\",\"".$objResult1["access_name"]."\",\"\",\"\",\"\",\"\",\"\",\"\",\"".number_format($objResult1["unit_price"], 2, '.', '' )."\",\"THB\",\"\",\"\",\"\",\"\",\"\",\"".number_format($objResult1["count"], 2, '.', '' )."\",\"\",\"\",\"VAT\",\"7.00\",\"".number_format(($objResult1["unit_price"]*$objResult1["count"])/1.07, 2, '.', '' )."\",\"THB\",\"".number_format((($objResult1["unit_price"]*$objResult1["count"])/1.07)*0.07, 2, '.', '' )."\",\"THB\",\"false\",\"".number_format(($objResult1["discount_unit"]*$objResult1["count"])/1.07, 2, '.', '' )."\",\"THB\",\"95\",\"\",\"\",\"\",\"".$s_01."\",\"THB\",\"".$s_02."\",\"THB\",\"".$objResult1["unit_name"]."\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"\n";
	

	
$i++;	
}	



if($fdsfse=='SO'){	
	
$strSQL12 = "SELECT SUM(amount) AS sum_amount FROM hos__subso WHERE ref_idd = '".$rs1["ref_id"]."'";
$objQuery12 = mysqli_query($conn,$strSQL12) or die ("Error Query [".$strSQL12."]");
$objResult12 = mysqli_fetch_array($objQuery12);	

}else{
	
$strSQL12 = "SELECT SUM(sum_amount) AS sum_amount FROM so__submain WHERE ref_idd = '".$rs1["ref_id"]."'";
$objQuery12 = mysqli_query($conn,$strSQL12) or die ("Error Query [".$strSQL12."]");
$objResult12 = mysqli_fetch_array($objQuery12);	
	
	
}
	
$strSQL2 = "SELECT SUM(sum_amount) AS sum_amount,SUM(count) AS count,SUM(unit_price) AS unit_price,SUM(discount_unit) AS discount_unit FROM tb_subcredit WHERE ref_creditt = '".$objResult["ref_credit"]."'";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);
	
$strSQL3 = "SELECT sum_amount,count,unit_price,discount_unit FROM tb_subcredit  WHERE ref_creditt = '".$objResult["ref_credit"]."'";
$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
	
$sum = 0;
$i = 0;	
$sum1 = 0;
$i1 = 0;		
	
while($objResult3 = mysqli_fetch_array($objQuery3))
{

if($objResult3["unit_price"]!='0.00'){	
$sum =$objResult3["sum_amount"]+$sum;
$sum++;	
$i++;
}	
	
if($objResult3["discount_unit"]!='0.00'){	
$sum1 =($objResult3["discount_unit"]*$objResult3["count"])+$sum1;
$sum1++;	
$i1++;
}	
	
}	

$sum_cor = $objResult12["sum_amount"]-$objResult2["sum_amount"];	
	
$fileContent .= "\"F\",\"".$Num_Rows1."\",\"\",\"\",\"VAT\",\"7.00\",\"".number_format($objResult2["sum_amount"]/1.07, 2, '.', '')."\",\"THB\",\"".number_format(($objResult2["sum_amount"]/1.07)*0.07, 2, '.', '')."\",\"THB\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"false\",\"0.00\",\"THB\",\"95\",\"\",\"\",\"\",\"\",\"".number_format($objResult12["sum_amount"]/1.07, 2, '.', '')."\",\"THB\",\"".number_format($sum_cor/1.07, 2, '.', '')."\",\"THB\",\"".number_format(($objResult12["sum_amount"]-$sum_cor)/1.07, 2, '.', '')."\",\"THB\",\"".number_format(($sum1-$i1)/1.07, 2, '.', '')."\",\"THB\",\"\",\"\",\"".number_format($objResult2["sum_amount"]/1.07, 2, '.', '')."\",\"THB\",\"".number_format(($objResult2["sum_amount"]/1.07)*0.07, 2, '.', '')."\",\"THB\",\"".number_format($objResult2["sum_amount"], 2, '.', '')."\",\"THB\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"".$cred."\",\"\",\"".$iv_no_1."\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"\n";	
	
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
header("Content-disposition: attachment; filename=Credit_Note.zip");
header("Content-Type: application/zip");
header("Content-Length: " . filesize($zipFile));
readfile($zipFile);

// Clean up temporary files and directory
unlink($zipFile);
array_map('unlink', glob("$tempDir/*"));
rmdir($tempDir);


?>
	
	
	
	
	
	
	
	
	
	
	