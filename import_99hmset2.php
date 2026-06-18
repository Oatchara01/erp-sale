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
if($objArr[0]!=''){

$sql1 = "SELECT MAX(main_id) AS main_id FROM so__main";
$query1 = mysqli_query($conn,$sql1) or die(mysqli_error());
//$fetch1 = mysqli_fetch_assoc($query1);
while($fetch1 = mysqli_fetch_array($query1)){
	
$create_order = date('Y-m-d H:i:s');


$ref_id = $fetch1['ref_id']+1;
$main_id =$fetch1['main_id']+1;
$doc_release_date= date('Y-m-d');
$register_date = date('Y-m-d');
$register_time = date('H:i:s');
$delivery_date = date('Y-m-d');
$customer_name = $objArr[1];
$delivery_name = $objArr[1];
$tax_id = "";


$order_name = $objArr[1];
$delivery_contact = "$objArr[1] / $objArr[6]";
$address1 = "$objArr[2]";
$province = trim($objArr[4]);
$delivery_place = "$objArr[2] $objArr[3] $objArr[4] $objArr[5]";


$postcode =	$objArr[14];
$upload1 = $objArr[19];	
$upload2 = $objArr[20];	

	
$billing_name =	$objArr[1];	
$billing_address = "$objArr[2] $objArr[3] $objArr[4] $objArr[5]";
$billing_postcode =	$objArr[5];	
$billing_add = $objArr[2];
$billing_aum = $objArr[3];
$billing_pro = trim($objArr[4]);	
	
	
$billing_tel =	$objArr[6];	
$sale_remark = "บริจาคน้ำท่วมเชียงราย (ไม่ต้องส่งของ)"; 


$tel =	$objArr[6];
$add_date = date('Y-m-d H:i:s');
   
$name = $_SESSION["name"];
$surname =	$_SESSION["surname"];
$add_by = "$name $surname";
$order_refer_code = "";
$order_id = "";
$sale_channel = '3';
	
$delivery = '7';
$payment = '22';
$employee_name ="SOL99";
$job_id = "99 HealthMart";
$approve_complete = "Approve";
$pre_name = 'คุณ';
$delivery_type ='4';	
$email_cus =  "";
	


$bill_id = "200559";
	
	
$date = explode('-' , $register_date);
$year = $date[0]+543;
$mont = $date[1];
$year1 = substr($year, 2 ,2);

$sql = "SELECT MAX(run_no) AS MAXID FROM tb_doc_ptl where mount_no ='".$mont."' and year_no = '".$year1."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);

$maxId = $rs["MAXID"];

$so = "IE";


$maxId1 = ($maxId + 1);
$maxId2 = substr("0000".$maxId1, -4);
$nextId = $maxId2;
$doc_no = $so.$year1.$mont.$nextId;

$save9="insert into tb_doc_ptl (doc_no,year_no,mount_no,run_no,ref_so,iv_date) values ('".$doc_no."','".$year1."','".$mont."','".$nextId."','".$main_id."','".$register_date."')";
$qsave9=mysqli_query($conn,$save9);
	

	
	
	
$bill_vat = '1';
$send_supadm = '1';
$select_type_doc = '3';	
//$doc_no = "IV";	
$status_vat = "Approve";

	
	
	
$strSQL = "INSERT INTO so__main (ref_id,register_date,register_time,delivery_name,address1,address2,province,postcode,billing_address,billing_name,billing_tel,tel,order_id,customer_name,order_name,delivery_contact,delivery_place,add_date,add_by,order_refer_code,sale_channel,select_type_doc,doc_release_date,status_doc,delivery_date,approve_complete,employee_name,job_id,delivery,payment,sale_remark,send_stock,bill_id,doc_no,prefer_name,po_no,ex_add,ex_aumper,ex_provin,ex_post,pre_name,tax_id,bill_vat,send_supadm,status_vat,delivery_type,create_order,email,upload1,upload2,allwell_ckk) VALUES ('".$main_id."','".$register_date."','".$register_time."','".$delivery_name."','".$address1."','".$address2."','".$province."','".$postcode."','".$billing_address."','".$billing_name."','".$billing_tel."','".$tel."','".$order_id."','".$customer_name."','".$order_name."','".$delivery_contact."','".$delivery_place."','".$add_date."','".$add_by."','".$order_refer_code."','".$sale_channel."','".$select_type_doc."','".$doc_release_date."','".$select_type_doc."','".$delivery_date."','".$approve_complete."','".$employee_name."','".$job_id."','".$delivery."','".$payment."','".$sale_remark."','1','".$bill_id."','".$doc_no."','99 HealthMart','".$order_id."','".$billing_add."','".$billing_aum."','".$billing_pro."','".$billing_postcode."','".$pre_name."','".$tax_id."','".$bill_vat."','".$send_supadm."','".$status_vat."','".$delivery_type."','".$create_order."','".$email_cus."','".$upload1."','".$upload2."','1')";

	
$objQuery = mysqli_query($conn,$strSQL)or die(mysqli_error());
	

//mysql_affected_rows()




	$strSQL1 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,status_sol)
values ('".$main_id."','".$objArr[9]."','".$objArr[9]."','".$objArr[10]."','".$objArr[10]."','".$objArr[13]."','0.00','5016','5016','','Approve')";

$objQuery1 = mysqli_query($conn,$strSQL1);




	$strSQL4 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,status_sol,sale_remark)
values ('".$main_id."','".$objArr[9]."','0.00','0.00','0.00','0.00','0.00','5016','5016','','Approve','บริจาคน้ำท่วมเชียงราย')";

$objQuery4 = mysqli_query($conn,$strSQL4);





if($objArr[11] !='0'){

$discount_unit = $objArr[11];
$discount = -$discount_unit;

$strSQL2 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,status_sol)
values ('".$main_id."','1','1','0.00','0.00','".$discount."','".$discount_unit."','3196','3196','','Approve')";
$objQuery2 = mysqli_query($conn,$strSQL2);
	
}


if($objArr[12] !='0'){

$strSQL3 = "insert into so__submain
(ref_idd,sale_count,sale_countref,price_per_unit,price_per_unitref,sum_amount,discount_unit,product_id,product_code,warranty,status_sol)
values ('".$main_id."','1','1','".$objArr[12]."','".$objArr[12]."','".$objArr[12]."','0.00','5204','5204','','Approve')";

	$objQuery3 = mysqli_query($conn,$strSQL3);

}


	

}


		   
	  }
	   }
	

	

	







	 
fclose($objCSV);  
 //$objQuery = mysql_query($strSQL); 
 if($objQuery){
$sql2 = "SELECT ref_id FROM so__main WHERE sale_channel = '3' and register_date = '" . $register_date . "' and add_by ='" . $add_by . "' ";
$result2 = mysqli_query($conn, $sql2);
$Num_Rows21 = mysqli_num_rows($result2);	
	 
	echo "<script language=\"JavaScript\">";
echo "alert('Importข้อมูลของท่านเรียบร้อยแล้วจำนวน $Num_Rows21 ออเดอร์');window.location='main_admin.php';";
echo "</script>";
	  }else{
   echo 'ไม่สามารถ Import ข้อมูลได้';
 }
?>

<?php include('foot.php'); ?>
