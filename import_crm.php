<?php include('head.php'); ?>


<style type="text/css">
<!--
.style15 {
	font-size: 17px; color: #000000;
}
.style30 {font-size: 12; }
.style32 {font-size: 11px}
.style33 {font-size: 12px; }
.style34 {color: #FF0000}
.style35 {font-size: 12px; color: #f2f2f2; }
.style37 {color: #FF0000; font-size: 14px; }
.style38 {color: #f2f2f2}
.style39 {font-size: 14px}
.style40 {font-size: 16px; color: #FF0000; }
-->

.button {
    background-color: #339900;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
}
	
.button1 {border-radius: 2px;}
.button2 {border-radius: 4px;}
.button3 {border-radius: 8px;}
.button4 {border-radius: 12px;}
.button5 {border-radius: 50%;}
</style>

<body>
<?
include "dbconnect.php";
   	date_default_timezone_set("Asia/Bangkok");

$files_url = $_POST['linkurl']; ////'uploads/installdata_test2.csv';
$objCSV = fopen($files_url,'r');

$objArr = fgetcsv($objCSV, 1000, ",");

while(($objArr = fgetcsv($objCSV, 1000, ",")) !== FALSE) { 

	
$cus_tel = $objArr[0];
$tel = $objArr[12];
$first_name = $objArr[1];
$last_name = $objArr[2];
$customer_name = "$first_name $last_name";
$email = $objArr[3];
$brithday = $objArr[4];
$cus_addno = $objArr[5];
$cus_addtum = $objArr[6];
$add_all ="$cus_addno $cus_addtum";
$cus_ampher = $objArr[7];
$cus_province = $objArr[8];
$cus_postcode = $objArr[9];
$sex = $objArr[10];
$age = $objArr[11];
$type_customer = '6';
$preface_name ='คุณ';
$update_crm = date('Y-m-d');
$add_date = date('Y-m-d H:i:s');

$cus_date = "$objArr[13] $objArr[14]";	
	
if($cus_tel!=''){	

$strSQL = "SELECT customer_id,customer_no,cus_tel,add_date  FROM tb_customer  where cus_tel LIKE '%".$tel."%' and close_ckk='0'";
//echo $strSQL;
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
$objResult = mysqli_fetch_array($objQuery);

if($objResult["cus_tel"]!=''){
if($objResult["customer_id"]!='' and $objResult["customer_no"]==''){

$yearMonth = substr(date("Y")+543, -2);
$sql = "SELECT MAX(customer_no) AS MAXID FROM tb_customer";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
$maxId = substr($rs['MAXID'], -4);
$maxId3 = substr($rs['MAXID'],-6);

$maxId1 = substr($maxId3,0,-4);

if($maxId1 == $yearMonth)
{
$maxId1 = ($maxId + 1);
$maxId2 = substr("0000".$maxId1, -4);
$nextId = $yearMonth.$maxId2;
}
else 
{
$maxId1 = "0001"; 
$nextId = $yearMonth.$maxId1;

}

$customer_no =$nextId;



$save="UPDATE tb_customer SET customer_no='".$customer_no."',customer_name='".$customer_name."',cus_address='".$add_all."',cus_ampher='".$cus_ampher."',cus_province='".$cus_province."',cus_postcode='".$cus_postcode."',cus_tel='".$cus_tel."',brithday='".$brithday."',email_cus='".$email."',add_date='".$cus_date."',online='1',cus_addno='".$cus_addno."',cus_addtum='".$cus_addtum."',preface_name='".$preface_name."',agree_ckk='1',update_crm='".$update_crm."',first_name='".$first_name."',last_name='".$last_name."',age='".$age."',sex='".$sex."' where customer_id = '".$objResult["customer_id"]."'";
$qsave=mysqli_query($conn,$save);

}else if($objResult["customer_id"]!='' and $objResult["customer_no"]!=''){


$save="UPDATE tb_customer SET customer_name='".$customer_name."',cus_address='".$add_all."',cus_ampher='".$cus_ampher."',cus_province='".$cus_province."',cus_postcode='".$cus_postcode."',cus_tel='".$cus_tel."',brithday='".$brithday."',email_cus='".$email."',cus_addno='".$cus_addno."',cus_addtum='".$cus_addtum."',update_crm='".$update_crm."',first_name='".$first_name."',last_name='".$last_name."',age='".$age."',sex='".$sex."' where customer_id = '".$objResult["customer_id"]."'";
$qsave=mysqli_query($conn,$save);
	
/*if($objResult["add_date"]=="0000-00-00 00:00:00"){
$save1="UPDATE tb_customer SET add_date='".$cus_date."' where customer_id = '".$objResult["customer_id"]."'";	
$qsave1=mysqli_query($conn,$save1);
}*/
	


}
}else{
$yearMonth = substr(date("Y")+543, -2);
$sql = "SELECT MAX(customer_no) AS MAXID FROM tb_customer";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
$maxId = substr($rs['MAXID'], -4);
$maxId3 = substr($rs['MAXID'],-6);

$maxId1 = substr($maxId3,0,-4);

if($maxId1 == $yearMonth)
{
$maxId1 = ($maxId + 1);
$maxId2 = substr("0000".$maxId1, -4);
$nextId = $yearMonth.$maxId2;
}
else 
{
$maxId1 = "0001"; 
$nextId = $yearMonth.$maxId1;

}

$customer_no =$nextId;

$qfirst = "select * from tb_customer ORDER BY customer_id DESC LIMIT 1";
$first = mysqli_query($conn,$qfirst);
$Num_Rows88 = mysqli_num_rows($first);
$ffirst = mysqli_fetch_array($first);
	
$customer_id = $ffirst['customer_id']+1;	
	

$save="insert into tb_customer
(customer_no,customer_name,type_customer,cus_address,cus_ampher,cus_province,cus_postcode,cus_tel,bill_name,bill_address,bill_ampher,billl_province,bill_postcode,bill_tel,sale_code,brithday,email_cus,add_date,online,cus_addno,cus_addtum,preface_name,agree_ckk,update_crm,first_name,last_name,age,sex)
values
('".$customer_no."','".$customer_name."','".$type_customer."','".$add_all."','".$cus_ampher."','".$cus_province."','".$cus_postcode."','".$cus_tel."','".$customer_name."','".$add_all."','".$cus_ampher."','".$cus_province."','".$cus_postcode."','".$cus_tel."','SOL3','".$brithday."','".$email."','".$cus_date."','1','".$cus_addno."','".$cus_addtum."','".$preface_name."','1','".$update_crm."','".$first_name."','".$last_name."','".$age."','".$sex."')";
$qsave=mysqli_query($conn,$save);
	
	
$sql = "INSERT INTO tb_selected_sales (sale_code, id_customer, customer_name) VALUES ('SOL3', '$customer_id', '$customer_name')";
$qsave2 = mysqli_query($conn, $sql);

}	

	
if($objResult["customer_id"]!=''){
$strSQL5 = "SELECT SUM(sum_amount)  as total  FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE doc_no !='' and cancel_ckk ='0' and approve_complete='Approve' and bill_id = '".$objResult["customer_id"]."'";
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$objResult5 = mysqli_fetch_array($objQuery5);	
	
if($objResult5["total"]>='150000'){	

$save1="UPDATE tb_customer SET status_cus='2',date_update ='".$update_crm."' where customer_id = '".$objResult["customer_id"]."'";
$qsave1=mysqli_query($conn,$save1);	
	
}else if($objResult5["total"]>='50000'){	
	
$save="UPDATE tb_customer SET status_cus='1',date_update ='".$update_crm."' where customer_id = '".$objResult["customer_id"]."'";
$qsave1=mysqli_query($conn,$save1);	
	
}
}

}


}

	


 
fclose($objCSV);  
 if($qsave){

echo "<script language=\"JavaScript\">";
echo "alert('Importข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_cuscrm.php';";
echo "</script>";
	  }else{
   echo 'ไม่สามารถ Import ข้อมูลได้';
 }
?>

<?php include('foot.php'); ?>
