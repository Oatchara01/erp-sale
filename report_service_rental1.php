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
.style39 {font-size: 14px; color: #000000;}
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
//$company = $_GET["company"]; 

include"dbconnect.php";
?>
<body>



<div class="w3-white">
		<div class="w3-container w3-padding-large"><!-- main div -->
			<div class="w3-panel w3-light-gray"><h4>รายการติดตั้งสินค้าใบสั่งเช่า</h4></div>	
	
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
<!--td width="6%" align="center" class="style30">จังหวัด</td> 
<td width="6%" align="center" class="style30">รหัสไปรษณีย์</td--> 
<td width="5%" align="center" class="style30">วันที่ซื้อ</td> 
<td width="5%" align="center" class="style30">ระยะรับประกัน</td>
<td width="5%" align="center" class="style30">ผลการติดตั้ง</td> 

	</tr>
			

<?php

$date_edit = date('Y-m-d');
$add_date = date('Y-m-d H:i:s');
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";
	
$strSQL51 = "SELECT DISTINCT stock_date FROM hos__rental  WHERE iv_no!='' and status_doc = 'Approve'";

if($start_date !=""){ 
    $strSQL51 .= ' AND stock_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL51 .= ' AND stock_date <= "'.$end_date.'"'; 
}
$objQuery51 = mysqli_query($conn,$strSQL51) or die ("Error Query [".$strSQL51."]");
$Num_Rows51 = mysqli_num_rows($objQuery51);

while($objResult51 = mysqli_fetch_array($objQuery51))
{	

$add_date = date('Y-m-d H:i:s');
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";
	
 $strSQL91 = "INSERT INTO tb_exportsn (channel,date_export,add_by,add_date) VALUES ('4','".$objResult51["stock_date"]."','".$add_by."','".$add_date."')";
 $objQuery91 = mysqli_query($conn,$strSQL91)or die(mysqli_error());	
	
}	
	
	
	
$strSQL = "SELECT rental_id,rental_name,rental_address,rental_tel,ref_id,delivery_date,iv_no,stock_date  FROM hos__rental  WHERE iv_no!='' and status_doc = 'Approve'";

if($start_date !=""){ 

    $strSQL .= ' AND stock_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND stock_date <= "'.$end_date.'"'; 
}

$strSQL .=" order  by ref_id ASC  ";	

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);


$i = 2;
$n=2;
$sum = 0;

while($objResult = mysqli_fetch_array($objQuery))
{
	
$ref_id = $objResult["ref_id"];	
	
$strSQL4 = "SELECT type_customer  FROM tb_customer  where customer_id  = '".$objResult["bill_id"]."'";	
$objQuery4 = mysqli_query($conn,$strSQL4);
$Num_Rows4 = mysqli_num_rows($objQuery4);
$objResult4 = mysqli_fetch_array($objQuery4);		
	
$strSQL1 = "SELECT remark_sale,sn_number,warranty,product_id,count FROM hos__subrental WHERE ref_idd = '".$ref_id."'";
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

	if($objResult["delivery_date"]=='0000-00-00'){
	$register_date = $objResult["stock_date"];
	}else{
    $register_date = $objResult["delivery_date"];
	}
    $warranty2 = substr($objResult1["warranty"],0,1);
	if($warranty2=='99' or $warranty2=='9'){
	$warranty = "99";	
	}else if($warranty2=='0'){
    $warranty = $objResult2["war_hc"];
	}else{
    $warranty = $warranty2;
	}
	$year = 'month';
	$warranty1 ="$warranty$year";
    $doc_no = $objResult["iv_no"];
	$product_id = $objResult1["product_id"];
	$count = $objResult1["count"];

		
$strSQL2 = "SELECT sol_name,war_hc FROM tb_product WHERE product_ID = '".$product_id."'";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$Num_Rows2 = mysqli_num_rows($objQuery2);	
$objResult2 = mysqli_fetch_array($objQuery2);	

//$sol_name = $objResult2["sol_name"];	

	
	
	
$datedate = date ("Y-m-d", strtotime($warranty1, strtotime($register_date)));	
	
$sql4="select product_sn from tb_products_in_stock where product_sn='".$product_sn1."'";
$result4 = mysqli_query($service,$sql4) or die(mysqli_error());
$num4=mysqli_num_rows($result4); 
	
$sql41="select product_sn from tb_products_in_stock where product_sn='".$product_sn1."' ";
$result41 = mysqli_query($servicenb,$sql41) or die(mysqli_error());
$num41=mysqli_num_rows($result41); 
?>		
		
<tr>
<td align="center" class="style30"><?php echo  $product_sn1; ?></td>
<td align="center" class="style30"><?php echo $objResult2["sol_name"]; ?></td>
<td align="center" class="style30"><?php echo $doc_no; ?></td>
<td align="center" class="style30"><?php echo $objResult["rental_name"]; ?></td>
<td align="center" class="style30"><?php echo $objResult["rental_tel"]; ?></td>
<td align="center" class="style30"><?php echo $objResult["rental_address"]; ?></td>
<!--td align="center" class="style30"><?php echo $province; ?></td>
<td align="center" class="style30"><?php echo $postcode; ?></td-->
<td align="center" class="style30"><?php echo $register_date; ?></td>
<td align="center" class="style30"><?php echo $warranty1; ?></td>

	
<?php	
	

if($num4 > 0){	
	
	
if($objResult4["type_customer"]=='1' or $objResult4["type_customer"]=='2'){		
    $customer_name = "";
	$bill_id = "";
	$tel = "";
	$address = "";		
	$province = "";	 
    $postcode = "";	
	$cus_id  = $objResult["rental_id"];
}else{
	$customer_name = $objResult["rental_name"];
	$bill_id = $objResult["rental_id"];
	$tel = $objResult["rental_tel"];
	$address = $objResult["rental_address"];		
	$province = "";	 
    $postcode = "";
    $cus_id  = '22522';
	
}	
	

$sql3="select install_cus_name from tb_installation_data where product_sn='".$product_sn1."' and close_install='0'";
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
	
$strSQL9 = "UPDATE tb_installation_data SET install_cus_name ='".$customer_name."',install_cus_address='".$address."',install_cus_tel='".$tel."',install_date='".$register_date."',warranty_phase='".$warranty1."',out_insurance_date='".$datedate."',add_date_search='".$date_edit."',warranty='".$warranty."',ref_id = '".$ref_id."',register_id ='".$bill_id."'  where product_sn='".$product_sn1."'";
$objQuery9 = mysqli_query($service,$strSQL9)or die(mysqli_error());

		}elseif($num == '0'){
 $strSQL9 = "INSERT INTO tb_installation_data (iv_no,install_cus_id,install_cus_name,install_cus_address,install_cus_tel,product_sn,buy_date,install_date,warranty_phase,out_insurance_date,add_by,add_date,add_date_search,warranty,cus_id,register_id,ref_id) VALUES ('".$doc_no."','".$product_sn1."','".$customer_name."','".$address."','".$tel."','".$product_sn1."','".$register_date."','".$register_date."','".$warranty1."','".$datedate."','".$add_by."','".$add_date."','".$date_edit."','".$warranty."','".$cus_id."','".$bill_id."','".$ref_id."')";
 $objQuery9 = mysqli_query($service,$strSQL9)or die(mysqli_error());
	 
?>
<td align="center" class="style30"><font color='green'><?php echo "ติดตั้งเรียบร้อยแล้ว";  ?></font></td>
	
<?php	

	
}
$sql1_up="update tb_products_in_stock set buy_status='1' where product_sn='".$product_sn1."' ";
$objQuery5 = mysqli_query($service,$sql1_up)or die(mysqli_error());		
	

	
	
}else if($num41 > 0){
	
if($objResult4["type_customer"]=='1' or $objResult4["type_customer"]=='2'){		
    $customer_name = "";
	$bill_id = "";
	$tel = "";
	$address = "";		
	$province = "";	 
    $postcode = "";	
	$cus_id  = $objResult["rental_id"];
}else{
	$customer_name = $objResult["rental_name"];
	$bill_id = $objResult["rental_id"];
	$tel = $objResult["rental_tel"];
	$address = $objResult["rental_address"];		
	$province = "";	 
    $postcode = "";
    $cus_id  = '1023';
	
}	
	

$sql3="select * from tb_installation_data where product_sn='".$product_sn1."' and close_install='0'";
$result = mysqli_query($servicenb,$sql3) or die(mysqli_error());
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
	
		 $strSQL9 = "UPDATE tb_installation_data SET install_cus_name ='".$customer_name."',install_cus_address='".$address."',install_cus_tel='".$tel."',install_date='".$register_date."',warranty_phase='".$warrannty."',out_insurance_date='".$datedate."',add_date_search='".$date_edit."',warranty='".$warranty."',ref_id = '".$ref_id."',register_id ='".$bill_id."'  where product_sn='".$product_sn1."'";
		
		$objQuery9 = mysqli_query($servicenb,$strSQL9)or die(mysqli_error());

		}elseif($num == '0'){
 $strSQL9 = "INSERT INTO tb_installation_data (iv_no,install_cus_id,install_cus_name,install_cus_address,install_cus_tel,product_sn,buy_date,install_date,warranty_phase,out_insurance_date,add_by,add_date,add_date_search,warranty,cus_id,register_id,ref_id) VALUES ('".$doc_no."','".$product_sn1."','".$customer_name."','".$address."','".$tel."','".$product_sn1."','".$register_date."','".$register_date."','".$warrannty."','".$datedate."','".$add_by."','".$add_date."','".$date_edit."','".$warranty."','".$cus_id."','".$bill_id."','".$ref_id."')";
 $objQuery9 = mysqli_query($servicenb,$strSQL9)or die(mysqli_error());

?>
<td align="center" class="style30"><font color='green'><?php echo "ติดตั้งเรียบร้อยแล้ว";  ?></font></td>
	
<?php			
	
}
	
$sql1_up="update tb_products_in_stock set buy_status='1' where product_sn='".$product_sn1."' ";
$objQuery5 = mysqli_query($servicenb,$sql1_up)or die(mysqli_error());	
	

	
}else{	
$MSGM.="ขออภัยค่ะ รายการ  '".$product_sn1."'ไม่มีสินค้าใน Stock<br>";	
?>
<td align="center" class="style30"><font color='red'><?php echo "ขออภัยค่ะ รายการ  '".$product_sn1."'ไม่มีสินค้าใน Stock<br>";  ?></font></td>
	
<?php	
}
}
	?>
	</tr>
	<?
}
}
}
	
?>
</table>



<br><br><center>
<a href="main_salehos.php" class="w3-button w3-green w3-center"><font color="330066">กลับหน้าหลัก</font></a>
			</center><br><br>
</div></div>
<div id="cr_bar"><?php include "foot.php"; ?></div>
