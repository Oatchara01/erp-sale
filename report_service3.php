<?php include("head.php");  ?>

<link rel="stylesheet" href="css/w32.css">
<style type="text/css">
<!--

.style15 {
	font-size: 18px; color: #000000;
}
.style16 {font-size: 18px; color: #FF0000;}
.style17 {font-size: 18px; color: #3333FF;}
.style32 {font-size: 11px}
.style33 {font-size: 12px; }
.style34 {color: #FF0000}
.style35 {font-size: 12px; color: #f2f2f2; }
.style37 {color: #FF0000; font-size: 14px; }
.style38 {color: #f2f2f2 }
.style30 {font-size: 14px; color: #000000;}
.style40 {font-size: 15px; color: #000000; }
-->

.button {
    background-color: #339900;
    border: none;
    color: white;
    padding: 14px 16px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
}

.button1 {border-radius: 2px; background-color:#FF9999;  padding: 0.1px 0.1px; margin: 0.5px 0.5px;}
.button2 {border-radius: 2px; background-color:#CCFF66;  padding: 0.1px 0.1px; margin: 0.5px 0.5px;}
.button3 {border-radius: 2px; background-color:#FF3333;  padding: 0.1px 0.1px; margin: 0.5px 0.5px;}
.button4 {border-radius: 12px;}
.button5 {border-radius: 50%;}



</style>



<?php


date_default_timezone_set("Asia/Bangkok");

$start_date = $_GET["start_date"];
$end_date = $_GET["end_date"];
$add_date = date('Y-m-d H:i:s');
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";	



$h= round(abs(strtotime($start_date) - strtotime($end_date))/60/60/24);
	
$p = 0;
$j= $h+1;
while ($p < $j) {
$strNewDate = date ("Y-m-d", strtotime("+$p day", strtotime($start_date)));

/*$strSQL53 = "SELECT date_install  FROM tb_warranty_eng  WHERE date_install='".$strNewDate."' and ckk_h='1'";
$objQuery53 = mysqli_query($conn,$strSQL53) or die ("Error Query [".$strSQL53."]");
$objResult53 = mysqli_fetch_array($objQuery53);	
	
if($objResult53["date_install"]!=''){	}else{*/	
	
$sql7="insert into tb_warranty_eng (date_install,add_by,add_date,ckk_h) values ('".$strNewDate."','".$add_by."','".$add_date."','1') ";
$objQuery7 = mysqli_query($conn,$sql7)or die(mysqli_error());	
//}	
	
$p++;
}




?>
<body>

<form  method="POST" name="frmMain"  enctype="multipart/form-data">
<div class="w3-white">
		<div class="w3-container w3-padding-large"><!-- main div -->
			<div class="w3-panel w3-light-gray"><h4>รายการติดตั้งสินค้า</h4></div>	
	
<center>
<span class="style15"><?php echo DateThai($start_date); ?>&nbsp;ถึง&nbsp;<?php echo DateThai($end_date); ?></span><br>
</center>
<br>


<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="5%" align="center" class="style30">SN สินนค้า</td>
<td width="5%" align="center" class="style30">ชื่อสินค้า</td> 
<td width="5%" align="center" class="style30">เลขที่เอกสาร</td> 
<td width="5%" align="center" class="style30">ชื่อลูกค้า</td>
<td width="5%" align="center" class="style30">เบอร์โทร</td> 
<td width="5%" align="center" class="style30">ที่อยู่</td> 
<!--td width="5%" align="center" class="style30">จังหวัด</td> 
<td width="5%" align="center" class="style30">รหัสไปรษณีย์</td--> 
<td width="5%" align="center" class="style30">วันที่ซื้อ</td> 
<td width="5%" align="center" class="style30">ระยะรับประกัน</td>
<td width="5%" align="center" class="style30">PM</td>
<td width="5%" align="center" class="style30">CAL</td> 
<td width="5%" align="center" class="style30">หมายเหตุ</td>
<td width="5%" align="center" class="style30">ผลการติดตั้ง</td> 
</tr>

<?php
	
$strSQL51 = "SELECT DISTINCT date_disburse  FROM so__main  WHERE doc_no NOT LIKE '%BRNP%' and cancel_ckk='0'";

if($start_date !=""){ 
    $strSQL51 .= ' AND date_disburse >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL51 .= ' AND date_disburse <= "'.$end_date.'"'; 
}
$objQuery51 = mysqli_query($conn,$strSQL51) or die ("Error Query [".$strSQL51."]");
$Num_Rows51 = mysqli_num_rows($objQuery51);

while($objResult51 = mysqli_fetch_array($objQuery51))
{	


	
/*$strSQL53 = "SELECT date_install  FROM tb_warranty_eng  WHERE date_install='".$objResult51["date_disburse"]."' and ckk_h='1'";
$objQuery53 = mysqli_query($conn,$strSQL53) or die ("Error Query [".$strSQL53."]");
$objResult53 = mysqli_fetch_array($objQuery53);	
	
if($objResult53["date_install"]!=''){	}else{
$sql7="insert into tb_warranty_eng (date_install,add_by,add_date,ckk_h) values ('".$objResult51["date_disburse"]."','".$add_by."','".$add_date."','1') ";
$objQuery7 = mysqli_query($conn,$sql7)or die(mysqli_error());	
	
}*/
	

	
 $strSQL91 = "INSERT INTO tb_exportsn (channel,date_export,add_by,add_date) VALUES ('1','".$objResult51["date_disburse"]."','".$add_by."','".$add_date."')";
 $objQuery91 = mysqli_query($conn,$strSQL91)or die(mysqli_error());	
	
}	

$strSQL = "SELECT customer_name,doc_no,delivery_date,delivery_time,postcode,province,delivery_place,billing_address,address2,address1,billing_tel,tel,billing_name,delivery_contact,ref_id,stock_date,bill_id  FROM so__main  WHERE doc_no NOT LIKE '%BRNP%' and cancel_ckk='0'";

if($start_date !=""){ 
    $strSQL .= ' AND date_disburse >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND date_disburse <= "'.$end_date.'"'; 
}

$strSQL .=" order  by ref_id ASC  ";	
//echo $strSQL;
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);


while($objResult = mysqli_fetch_array($objQuery))
{
$ref_id = $objResult["ref_id"];	
	
	
$sql = "SELECT status_cus,customer_no,customer_code,customer_coden,customer_id  FROM tb_customer where customer_id = '".$objResult["bill_id"]."' and customer_no !=''";
	//echo $sqll;
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
	
if($rs["customer_no"] !=''){
if($rs["status_cus"]=='0'){
$status_cus="Gold Customer";
}else if($rs["status_cus"]=='1'){ 
$status_cus="Platinum Customer";
}else if($rs["status_cus"]=='2'){ 
$status_cus="Daimond Customer";

}	
	 
$customer_no = $rs["customer_no"];	  
$customer_code = $rs["customer_code"];	  	 
$customer_coden = $rs["customer_coden"];	  	 
$customer_id = $rs["customer_id"];	  	 
}else{
	 
$customer_no = "";	  
$customer_code = "";	  	 
$customer_coden = "";	  	 
$customer_id = "";	
$status_cus='';
	 
 }
	
$date_edit = date('Y-m-d');
$add_date = date('Y-m-d H:i:s');
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";
	
	
$strSQL1 = "SELECT sale_remark,sn_number,cal,pm,warranty,product_id,sale_count,product_id FROM so__submain WHERE ref_idd = '".$ref_id."'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

while($objResult1 = mysqli_fetch_array($objQuery1))
{

$sn_number =  $objResult1["sn_number"];
$str_arr = explode("\n",$sn_number);


foreach ($str_arr as $test =>$value){
$product_sn = $str_arr[$test];
$product_sn1 =  trim($product_sn);

if($product_sn1!=''){
	
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
	if($objResult["delivery_place"]!=""){
	$address = $objResult["delivery_place"];
	}else if($objResult["address1"]!=""){
	$address1 = $objResult["address1"];
    $address2 = $objResult["address2"];	
    $address = "$address1 $address2";
		
	}else if($objResult["billing_address"]!=""){
	 $address = $objResult["billing_address"];		
			
	}
    $province = $objResult["province"];	 
    $postcode = $objResult["postcode"];
	
	if($objResult["delivery_date"]=='0000-00-00'){
	 $register_date=$objResult["delivery_time"];
	}else{
    $register_date = $objResult["delivery_date"];
	}



    $warranty = $objResult1["warranty"];
	$year ='year';
	$warranty1 ="$warranty$year";
	
    $pm = $objResult1["pm"];
    $cal = $objResult1["cal"];
 	$doc_no = $objResult["doc_no"];
	$product_id = $objResult1["product_id"];
	$count = $objResult1["sale_count"];
$sale_remark = $objResult1["sale_remark"];
	
$strSQL2 = "SELECT sol_name,war_hc,unit_hc,remark_hc FROM tb_product WHERE product_ID = '".$product_id."'";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$Num_Rows2 = mysqli_num_rows($objQuery2);	
$objResult2 = mysqli_fetch_array($objQuery2);
$sol_name = $objResult2["sol_name"];	
if($objResult2["unit_hc"]=='ปี'){	
$unit_hc = "year";
}else{
$unit_hc = "month";	
}
$war_hc =	$objResult2["war_hc"];
$warrannty = "$war_hc$unit_hc";
	
$datedate = date ("Y-m-d", strtotime($warrannty, strtotime($register_date)));	
	
$sql4="select product_sn from tb_products_in_stock where product_sn='".$product_sn1."' ";
$result4 = mysqli_query($service,$sql4) or die(mysqli_error());
$num4=mysqli_num_rows($result4); 
	
$sql41="select product_sn from tb_products_in_stock where product_sn='".$product_sn1."' ";
$result41 = mysqli_query($servicenb,$sql41) or die(mysqli_error());
$num41=mysqli_num_rows($result41); 
	?>
	
<tr>
<td align="center" class="style30"><?php echo  $product_sn1; ?></td>
<td align="left" class="style30"><?php echo $sol_name; ?></td>
<td align="center" class="style30"><?php echo $doc_no; ?></td>
<td align="center" class="style30"><?php echo $customer_name; ?></td>
<td align="center" class="style30"><?php echo $tel; ?></td>
<td align="center" class="style30"><?php echo $address; ?></td>
<!--td align="center" class="style30"><?php echo $province; ?></td>
<td align="center" class="style30"><?php echo $postcode; ?></td-->
<td align="center" class="style30"><?php echo $register_date; ?></td>
<td align="center" class="style30"><?php echo $warrannty; ?></td>
<td align="center" class="style30"><?php echo $pm; ?></td>
<td align="center" class="style30"><?php echo $cal; ?></td>
<td align="center" class="style30"><?php echo $objResult2["remark_hc"]; ?></td>	
	
	
<?php
if($num4 > 0){	

$sql3="select install_cus_name from tb_installation_data where product_sn='".$product_sn1."' ";
$result = mysqli_query($service,$sql3) or die(mysqli_error());
$num=mysqli_num_rows($result);
$objResult3 = mysqli_fetch_array($result);
	
if($num > 0 and $objResult3["install_cus_name"] !='') {

 $MSG.="ขออภัยค่ะ รายการ  '".$product_sn1."'มีการติดตั้งข้อมูลแล้ว  ในชื่อคุณ '".$objResult3["install_cus_name"]."'<br>";
?>
<td align="center" class="style30"><font color='red'><?php echo "ขออภัยค่ะ รายการ  '".$product_sn1."'มีการติดตั้งข้อมูลแล้ว  ในชื่อคุณ '".$objResult3["install_cus_name"]."'<br>";  ?></font></td>
	
	<?php	
}else if($num > 0 and $objResult3["install_cus_name"] =='')   		
        {
		 $MSG.="ขออภัยค่ะ รายการ  '".$product_sn1."'มีการติดตั้งข้อมูลตัวแทนจำหน่ายแล้ว และได้อัพเดตข้อมูลลูกค้าเรียบร้อยแล้วคะ<br>";
?>
<td align="center" class="style30"><font color='red'><?php echo "ขออภัยค่ะ รายการ  '".$product_sn1."'มีการติดตั้งข้อมูลตัวแทนจำหน่ายแล้ว และได้อัพเดตข้อมูลลูกค้าเรียบร้อยแล้วคะ<br>";  ?></font></td>
	
	<?php	
$strSQL9 = "UPDATE tb_installation_data SET install_cus_name ='".$customer_name."',install_cus_address='".$address."',install_cus_tel='".$tel."',install_date='".$register_date."',warranty_phase='".$warrannty."',out_insurance_date='".$datedate."',add_date_search='".$date_edit."',more_warranty='".$objResult2["remark_hc"]."',warranty='".$objResult2["unit_hc"]."',ref_id = '".$ref_id."',register_id ='".$objResult["bill_id"]."'  where product_sn='".$product_sn1."'";
		
$objQuery9 = mysqli_query($service,$strSQL9)or die(mysqli_error());

		}elseif($num == '0'){
 $strSQL9 = "INSERT INTO tb_installation_data (iv_no,install_cus_id,install_cus_name,install_cus_address,install_cus_tel,product_sn,buy_date,install_date,warranty_phase,out_insurance_date,add_by,add_date,add_date_search,more_warranty,warranty,cus_id,register_id,ref_id) VALUES ('".$doc_no."','".$product_sn1."','".$customer_name."','".$address."','".$tel."','".$product_sn1."','".$register_date."','".$register_date."','".$warrannty."','".$datedate."','".$add_by."','".$add_date."','".$date_edit."','".$objResult2["remark_hc"]."','".$objResult2["unit_hc"]."','22522','".$objResult["bill_id"]."','".$ref_id."')";
 $objQuery9 = mysqli_query($service,$strSQL9)or die(mysqli_error());
	?>
<td align="center" class="style30"><font color='green'><?php echo "ติดตั้งเรียบร้อยแล้ว";  ?></font></td>
	
	<?php	 

if($pm > 0) {
$alltimepmyear1=($pm * $objResult2["unit_hc"]);
$dayduration=365/$pm;
	for($i=0;$i<$alltimepmyear1;$i++) {
		$j=$i+1;
		$addtime=floor($dayduration*$j);
		$pmdate = date ("Y-m-d", strtotime("+".$addtime." day", strtotime($register_date)));  
		
     $sql2_up="insert into tb_service_check (product_sn,service_check_terms,service_check_date,service_check_type,add_by,add_date) values ('".$product_sn1."','".$j."','".$pmdate."','PM','".$add_by."','".$add_date."') ";
    $objQuery6 = mysqli_query($service,$sql2_up)or die(mysqli_error());
}
}


if($cal > 0) {
$alltimecalyear1=$cal * $objResult2["unit_hc"];
$dayduration=365/$cal;
	for($i=0;$i<$alltimecalyear1;$i++) {
		$j=$i+1;
		$addtime=floor($dayduration*$j);
		$caldate = date ("Y-m-d", strtotime("+".$addtime." day", strtotime($register_date)));  

$sql3_up="insert into tb_service_check (product_sn,service_check_terms,service_check_date,service_check_type,add_by,add_date) values ('".$product_sn1."','".$j."','".$caldate."','CAL','".$add_by."','".$add_date."') ";
$objQuery7 = mysqli_query($service,$sql3_up)or die(mysqli_error());
	}
}
		
	
}
$sql1_up="update tb_products_in_stock set buy_status='1' where product_sn='".$product_sn1."' ";
$objQuery5 = mysqli_query($service,$sql1_up)or die(mysqli_error());		
	

	
	
}else if($num41 > 0){

$sql3="select * from tb_installation_data where product_sn='".$product_sn1."' ";
$result = mysqli_query($servicenb,$sql3) or die(mysqli_error());
$num=mysqli_num_rows($result);
$objResult3 = mysqli_fetch_array($result);	

if($num > 0 and $objResult3["install_cus_name"] !='') {

 $MSG.="ขออภัยค่ะ รายการ  '".$product_sn1."'มีการติดตั้งข้อมูลแล้ว  ในชื่อคุณ '".$objResult3["install_cus_name"]."'<br>";
?>	
<td align="center" class="style30"><font color='red'><?php echo "ขออภัยค่ะ รายการ  '".$product_sn1."'มีการติดตั้งข้อมูลแล้ว  ในชื่อคุณ '".$objResult3["install_cus_name"]."'<br>";  ?></font></td>	
<?	
}else if($num > 0 and $objResult3["install_cus_name"] =='')   		
        {
		 $MSG.="ขออภัยค่ะ รายการ  '".$product_sn1."'มีการติดตั้งข้อมูลตัวแทนจำหน่ายแล้ว และได้อัพเดตข้อมูลลูกค้าเรียบร้อยแล้วคะ<br>";
	?>
<td align="center" class="style30"><font color='red'><?php echo "ขออภัยค่ะ รายการ  '".$product_sn1."'มีการติดตั้งข้อมูลตัวแทนจำหน่ายแล้ว และได้อัพเดตข้อมูลลูกค้าเรียบร้อยแล้วคะ<br>";  ?></font></td>
	
	<?php
		 $strSQL9 = "UPDATE tb_installation_data SET install_cus_name ='".$customer_name."',install_cus_address='".$address."',install_cus_tel='".$tel."',install_date='".$register_date."',warranty_phase='".$warrannty."',out_insurance_date='".$datedate."',add_date_search='".$date_edit."',more_warranty='".$objResult2["remark_hc"]."',warranty='".$objResult2["unit_hc"]."',ref_id = '".$ref_id."',register_id ='".$objResult["bill_id"]."'  where product_sn='".$product_sn1."'";
		
		$objQuery9 = mysqli_query($servicenb,$strSQL9)or die(mysqli_error());

		}elseif($num == '0'){
 $strSQL9 = "INSERT INTO tb_installation_data (iv_no,install_cus_id,install_cus_name,install_cus_address,install_cus_tel,product_sn,buy_date,install_date,warranty_phase,out_insurance_date,add_by,add_date,add_date_search,more_warranty,warranty,cus_id,register_id,ref_id) VALUES ('".$doc_no."','".$product_sn1."','".$customer_name."','".$address."','".$tel."','".$product_sn1."','".$register_date."','".$register_date."','".$warrannty."','".$datedate."','".$add_by."','".$add_date."','".$date_edit."','".$objResult2["remark_hc"]."','".$objResult2["unit_hc"]."','1023','".$objResult["bill_id"]."','".$ref_id."')";
 $objQuery9 = mysqli_query($servicenb,$strSQL9)or die(mysqli_error());
?>
<td align="center" class="style30"><font color='green'><?php echo "ติดตั้งเรียบร้อยแล้ว";  ?></font></td>
	
	<?php
	
if($pm > 0) {
$alltimepmyear1=($pm * $objResult2["unit_hc"]);
$dayduration=365/$pm;
	for($i=0;$i<$alltimepmyear1;$i++) {
		$j=$i+1;
		$addtime=floor($dayduration*$j);
		$pmdate = date ("Y-m-d", strtotime("+".$addtime." day", strtotime($register_date)));  
		
     $sql2_up="insert into tb_service_check (product_sn,service_check_terms,service_check_date,service_check_type,add_by,add_date) values ('".$product_sn1."','".$j."','".$pmdate."','PM','".$add_by."','".$add_date."') ";
    $objQuery6 = mysqli_query($servicenb,$sql2_up)or die(mysqli_error());
}
}


if($cal > 0) {
$alltimecalyear1=$cal * $objResult2["unit_hc"];
$dayduration=365/$cal;
	for($i=0;$i<$alltimecalyear1;$i++) {
		$j=$i+1;
		$addtime=floor($dayduration*$j);
		$caldate = date ("Y-m-d", strtotime("+".$addtime." day", strtotime($register_date)));  

$sql3_up="insert into tb_service_check (product_sn,service_check_terms,service_check_date,service_check_type,add_by,add_date) values ('".$product_sn1."','".$j."','".$caldate."','CAL','".$add_by."','".$add_date."') ";
$objQuery7 = mysqli_query($servicenb,$sql3_up)or die(mysqli_error());
	}
}				
	
}
	
$sql1_up="update tb_products_in_stock set buy_status='1' where product_sn='".$product_sn1."' ";
$objQuery5 = mysqli_query($servicenb,$sql1_up)or die(mysqli_error());	
	

	
}else{	
$MSGM.="ขออภัยค่ะ รายการ  '".$product_sn1."'ไม่มีสินค้าใน Stock<br>";
?>
<td align="center" class="style30"><font color='red'><?php echo "ขออภัยค่ะ รายการ  '".$product_sn1."'ไม่มีสินค้าใน Stock<br>";  ?></font></td>
	
	<?php	
	
}

?>


</tr>
	
	
	
	
<?php	

}
}
}
}

//if($MSGM != ""){ echo ("$MSGM"); } 
//if($MSG != ""){	 echo ("$MSG");  }	
?>
<?php
	
$strSQL = "SELECT customer_name,doc_no,delivery_date,delivery_time,postcode,province,delivery_place,billing_address,address2,address1,billing_tel,tel,billing_name,delivery_contact,ref_id,stock_date,bill_id  FROM so__main  WHERE doc_no NOT LIKE '%BRNP%' and cancel_ckk='0' and date_disburse ='0000-00-00'";

if($start_date !=""){ 
    $strSQL .= ' AND doc_release_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND doc_release_date <= "'.$end_date.'"'; 
}

$strSQL .=" order  by ref_id ASC  ";	
//echo $strSQL;
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);


while($objResult = mysqli_fetch_array($objQuery))
{
$ref_id = $objResult["ref_id"];	
	
	
$sql = "SELECT status_cus,customer_no,customer_code,customer_coden,customer_id  FROM tb_customer where customer_id = '".$objResult["bill_id"]."' and customer_no !=''";
	//echo $sqll;
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
	
if($rs["customer_no"] !=''){
if($rs["status_cus"]=='0'){
$status_cus="Gold Customer";
}else if($rs["status_cus"]=='1'){ 
$status_cus="Platinum Customer";
}else if($rs["status_cus"]=='2'){ 
$status_cus="Daimond Customer";

}	
	 
$customer_no = $rs["customer_no"];	  
$customer_code = $rs["customer_code"];	  	 
$customer_coden = $rs["customer_coden"];	  	 
$customer_id = $rs["customer_id"];	  	 
}else{
	 
$customer_no = "";	  
$customer_code = "";	  	 
$customer_coden = "";	  	 
$customer_id = "";	
$status_cus='';
	 
 }
	
$date_edit = date('Y-m-d');
$add_date = date('Y-m-d H:i:s');
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";
	
	
$strSQL1 = "SELECT sale_remark,sn_number,cal,pm,warranty,product_id,sale_count,product_id FROM so__submain WHERE ref_idd = '".$ref_id."'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

while($objResult1 = mysqli_fetch_array($objQuery1))
{

$sn_number =  $objResult1["sn_number"];
$str_arr = explode("\n",$sn_number);


foreach ($str_arr as $test =>$value){
$product_sn = $str_arr[$test];
$product_sn1 =  trim($product_sn);

if($product_sn1!=''){
	
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
	if($objResult["delivery_place"]!=""){
	$address = $objResult["delivery_place"];
	}else if($objResult["address1"]!=""){
	$address1 = $objResult["address1"];
    $address2 = $objResult["address2"];	
    $address = "$address1 $address2";
		
	}else if($objResult["billing_address"]!=""){
	 $address = $objResult["billing_address"];		
			
	}
    $province = $objResult["province"];	 
    $postcode = $objResult["postcode"];
	
	if($objResult["delivery_date"]=='0000-00-00'){
	 $register_date=$objResult["delivery_time"];
	}else{
    $register_date = $objResult["delivery_date"];
	}



    $warranty = $objResult1["warranty"];
	$year ='year';
	$warranty1 ="$warranty$year";
	
    $pm = $objResult1["pm"];
    $cal = $objResult1["cal"];
 	$doc_no = $objResult["doc_no"];
	$product_id = $objResult1["product_id"];
	$count = $objResult1["sale_count"];
$sale_remark = $objResult1["sale_remark"];
	
$strSQL2 = "SELECT sol_name,war_hc,unit_hc,remark_hc FROM tb_product WHERE product_ID = '".$product_id."'";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$Num_Rows2 = mysqli_num_rows($objQuery2);	
$objResult2 = mysqli_fetch_array($objQuery2);
$sol_name = $objResult2["sol_name"];	
if($objResult2["unit_hc"]=='ปี'){	
$unit_hc = "year";
}else{
$unit_hc = "month";	
}
$war_hc =	$objResult2["war_hc"];
$warrannty = "$war_hc$unit_hc";
	
$datedate = date ("Y-m-d", strtotime($warrannty, strtotime($register_date)));	
	
$sql4="select product_sn from tb_products_in_stock where product_sn='".$product_sn1."' ";
$result4 = mysqli_query($service,$sql4) or die(mysqli_error());
$num4=mysqli_num_rows($result4); 
	
$sql41="select product_sn from tb_products_in_stock where product_sn='".$product_sn1."' ";
$result41 = mysqli_query($servicenb,$sql41) or die(mysqli_error());
$num41=mysqli_num_rows($result41); 
	?>
	
<tr>
<td align="center" class="style30"><?php echo  $product_sn1; ?></td>
<td align="left" class="style30"><?php echo $sol_name; ?></td>
<td align="center" class="style30"><?php echo $doc_no; ?></td>
<td align="center" class="style30"><?php echo $customer_name; ?></td>
<td align="center" class="style30"><?php echo $tel; ?></td>
<td align="center" class="style30"><?php echo $address; ?></td>
<!--td align="center" class="style30"><?php echo $province; ?></td>
<td align="center" class="style30"><?php echo $postcode; ?></td-->
<td align="center" class="style30"><?php echo $register_date; ?></td>
<td align="center" class="style30"><?php echo $warrannty; ?></td>
<td align="center" class="style30"><?php echo $pm; ?></td>
<td align="center" class="style30"><?php echo $cal; ?></td>
<td align="center" class="style30"><?php echo $objResult2["remark_hc"]; ?></td>	
	
	
<?php
if($num4 > 0){	

$sql3="select install_cus_name from tb_installation_data where product_sn='".$product_sn1."' ";
$result = mysqli_query($service,$sql3) or die(mysqli_error());
$num=mysqli_num_rows($result);
$objResult3 = mysqli_fetch_array($result);
	
if($num > 0 and $objResult3["install_cus_name"] !='') {

 $MSG.="ขออภัยค่ะ รายการ  '".$product_sn1."'มีการติดตั้งข้อมูลแล้ว  ในชื่อคุณ '".$objResult3["install_cus_name"]."'<br>";
?>
<td align="center" class="style30"><font color='red'><?php echo "ขออภัยค่ะ รายการ  '".$product_sn1."'มีการติดตั้งข้อมูลแล้ว  ในชื่อคุณ '".$objResult3["install_cus_name"]."'<br>";  ?></font></td>
	
	<?php	
}else if($num > 0 and $objResult3["install_cus_name"] =='')   		
        {
		 $MSG.="ขออภัยค่ะ รายการ  '".$product_sn1."'มีการติดตั้งข้อมูลตัวแทนจำหน่ายแล้ว และได้อัพเดตข้อมูลลูกค้าเรียบร้อยแล้วคะ<br>";
?>
<td align="center" class="style30"><font color='red'><?php echo "ขออภัยค่ะ รายการ  '".$product_sn1."'มีการติดตั้งข้อมูลตัวแทนจำหน่ายแล้ว และได้อัพเดตข้อมูลลูกค้าเรียบร้อยแล้วคะ<br>";  ?></font></td>
	
	<?php	
$strSQL9 = "UPDATE tb_installation_data SET install_cus_name ='".$customer_name."',install_cus_address='".$address."',install_cus_tel='".$tel."',install_date='".$register_date."',warranty_phase='".$warrannty."',out_insurance_date='".$datedate."',add_date_search='".$date_edit."',more_warranty='".$objResult2["remark_hc"]."',warranty='".$objResult2["unit_hc"]."',ref_id = '".$ref_id."',register_id ='".$objResult["bill_id"]."'  where product_sn='".$product_sn1."'";
		
$objQuery9 = mysqli_query($service,$strSQL9)or die(mysqli_error());

		}elseif($num == '0'){
 $strSQL9 = "INSERT INTO tb_installation_data (iv_no,install_cus_id,install_cus_name,install_cus_address,install_cus_tel,product_sn,buy_date,install_date,warranty_phase,out_insurance_date,add_by,add_date,add_date_search,more_warranty,warranty,cus_id,register_id,ref_id) VALUES ('".$doc_no."','".$product_sn1."','".$customer_name."','".$address."','".$tel."','".$product_sn1."','".$register_date."','".$register_date."','".$warrannty."','".$datedate."','".$add_by."','".$add_date."','".$date_edit."','".$objResult2["remark_hc"]."','".$objResult2["unit_hc"]."','22522','".$objResult["bill_id"]."','".$ref_id."')";
 $objQuery9 = mysqli_query($service,$strSQL9)or die(mysqli_error());
	?>
<td align="center" class="style30"><font color='green'><?php echo "ติดตั้งเรียบร้อยแล้ว";  ?></font></td>
	
	<?php	 

if($pm > 0) {
$alltimepmyear1=($pm * $objResult2["unit_hc"]);
$dayduration=365/$pm;
	for($i=0;$i<$alltimepmyear1;$i++) {
		$j=$i+1;
		$addtime=floor($dayduration*$j);
		$pmdate = date ("Y-m-d", strtotime("+".$addtime." day", strtotime($register_date)));  
		
     $sql2_up="insert into tb_service_check (product_sn,service_check_terms,service_check_date,service_check_type,add_by,add_date) values ('".$product_sn1."','".$j."','".$pmdate."','PM','".$add_by."','".$add_date."') ";
    $objQuery6 = mysqli_query($service,$sql2_up)or die(mysqli_error());
}
}


if($cal > 0) {
$alltimecalyear1=$cal * $objResult2["unit_hc"];
$dayduration=365/$cal;
	for($i=0;$i<$alltimecalyear1;$i++) {
		$j=$i+1;
		$addtime=floor($dayduration*$j);
		$caldate = date ("Y-m-d", strtotime("+".$addtime." day", strtotime($register_date)));  

$sql3_up="insert into tb_service_check (product_sn,service_check_terms,service_check_date,service_check_type,add_by,add_date) values ('".$product_sn1."','".$j."','".$caldate."','CAL','".$add_by."','".$add_date."') ";
$objQuery7 = mysqli_query($service,$sql3_up)or die(mysqli_error());
	}
}
		
	
}
$sql1_up="update tb_products_in_stock set buy_status='1' where product_sn='".$product_sn1."' ";
$objQuery5 = mysqli_query($service,$sql1_up)or die(mysqli_error());		
	

	
	
}else if($num41 > 0){

$sql3="select * from tb_installation_data where product_sn='".$product_sn1."' ";
$result = mysqli_query($servicenb,$sql3) or die(mysqli_error());
$num=mysqli_num_rows($result);
$objResult3 = mysqli_fetch_array($result);	

if($num > 0 and $objResult3["install_cus_name"] !='') {

 $MSG.="ขออภัยค่ะ รายการ  '".$product_sn1."'มีการติดตั้งข้อมูลแล้ว  ในชื่อคุณ '".$objResult3["install_cus_name"]."'<br>";
?>	
<td align="center" class="style30"><font color='red'><?php echo "ขออภัยค่ะ รายการ  '".$product_sn1."'มีการติดตั้งข้อมูลแล้ว  ในชื่อคุณ '".$objResult3["install_cus_name"]."'<br>";  ?></font></td>	
<?	
}else if($num > 0 and $objResult3["install_cus_name"] =='')   		
        {
		 $MSG.="ขออภัยค่ะ รายการ  '".$product_sn1."'มีการติดตั้งข้อมูลตัวแทนจำหน่ายแล้ว และได้อัพเดตข้อมูลลูกค้าเรียบร้อยแล้วคะ<br>";
	?>
<td align="center" class="style30"><font color='red'><?php echo "ขออภัยค่ะ รายการ  '".$product_sn1."'มีการติดตั้งข้อมูลตัวแทนจำหน่ายแล้ว และได้อัพเดตข้อมูลลูกค้าเรียบร้อยแล้วคะ<br>";  ?></font></td>
	
	<?php
		 $strSQL9 = "UPDATE tb_installation_data SET install_cus_name ='".$customer_name."',install_cus_address='".$address."',install_cus_tel='".$tel."',install_date='".$register_date."',warranty_phase='".$warrannty."',out_insurance_date='".$datedate."',add_date_search='".$date_edit."',more_warranty='".$objResult2["remark_hc"]."',warranty='".$objResult2["unit_hc"]."',ref_id = '".$ref_id."',register_id ='".$objResult["bill_id"]."'  where product_sn='".$product_sn1."'";
		
		$objQuery9 = mysqli_query($servicenb,$strSQL9)or die(mysqli_error());

		}elseif($num == '0'){
 $strSQL9 = "INSERT INTO tb_installation_data (iv_no,install_cus_id,install_cus_name,install_cus_address,install_cus_tel,product_sn,buy_date,install_date,warranty_phase,out_insurance_date,add_by,add_date,add_date_search,more_warranty,warranty,cus_id,register_id,ref_id) VALUES ('".$doc_no."','".$product_sn1."','".$customer_name."','".$address."','".$tel."','".$product_sn1."','".$register_date."','".$register_date."','".$warrannty."','".$datedate."','".$add_by."','".$add_date."','".$date_edit."','".$objResult2["remark_hc"]."','".$objResult2["unit_hc"]."','1023','".$objResult["bill_id"]."','".$ref_id."')";
 $objQuery9 = mysqli_query($servicenb,$strSQL9)or die(mysqli_error());
?>
<td align="center" class="style30"><font color='green'><?php echo "ติดตั้งเรียบร้อยแล้ว";  ?></font></td>
	
	<?php
	
if($pm > 0) {
$alltimepmyear1=($pm * $objResult2["unit_hc"]);
$dayduration=365/$pm;
	for($i=0;$i<$alltimepmyear1;$i++) {
		$j=$i+1;
		$addtime=floor($dayduration*$j);
		$pmdate = date ("Y-m-d", strtotime("+".$addtime." day", strtotime($register_date)));  
		
     $sql2_up="insert into tb_service_check (product_sn,service_check_terms,service_check_date,service_check_type,add_by,add_date) values ('".$product_sn1."','".$j."','".$pmdate."','PM','".$add_by."','".$add_date."') ";
    $objQuery6 = mysqli_query($servicenb,$sql2_up)or die(mysqli_error());
}
}


if($cal > 0) {
$alltimecalyear1=$cal * $objResult2["unit_hc"];
$dayduration=365/$cal;
	for($i=0;$i<$alltimecalyear1;$i++) {
		$j=$i+1;
		$addtime=floor($dayduration*$j);
		$caldate = date ("Y-m-d", strtotime("+".$addtime." day", strtotime($register_date)));  

$sql3_up="insert into tb_service_check (product_sn,service_check_terms,service_check_date,service_check_type,add_by,add_date) values ('".$product_sn1."','".$j."','".$caldate."','CAL','".$add_by."','".$add_date."') ";
$objQuery7 = mysqli_query($servicenb,$sql3_up)or die(mysqli_error());
	}
}				
	
}
	
$sql1_up="update tb_products_in_stock set buy_status='1' where product_sn='".$product_sn1."' ";
$objQuery5 = mysqli_query($servicenb,$sql1_up)or die(mysqli_error());	
	

	
}else{	
$MSGM.="ขออภัยค่ะ รายการ  '".$product_sn1."'ไม่มีสินค้าใน Stock<br>";
?>
<td align="center" class="style30"><font color='red'><?php echo "ขออภัยค่ะ รายการ  '".$product_sn1."'ไม่มีสินค้าใน Stock<br>";  ?></font></td>
	
	<?php	
	
}

?>


</tr>
	
	
	
	
<?php	

}
}
}
}

//if($MSGM != ""){ echo ("$MSGM"); } 
//if($MSG != ""){	 echo ("$MSG");  }	
?>


</table>

	
<br><br><center>
<a href="main_salehos.php" class="w3-button w3-green w3-center"><font color="330066">กลับหน้าหลัก</font></a>
			</center><br><br>
</div></div>
<div id="cr_bar"><?php include "foot.php"; ?></div>
