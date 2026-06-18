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
$date_edit = date('Y-m-d');
$add_date = date('Y-m-d H:i:s');
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";


include"dbconnect.php";


$h= round(abs(strtotime($start_date) - strtotime($end_date))/60/60/24);
	
$p = 0;
$j= $h+1;
while ($p < $j) {
$strNewDate = date ("Y-m-d", strtotime("+$p day", strtotime($start_date)));

$sql7="insert into tb_warranty_eng (date_install,add_by,add_date,ckk_h) values ('".$strNewDate."','".$add_by."','".$add_date."','4') ";
$objQuery7 = mysqli_query($conn,$sql7)or die(mysqli_error());	

	
$p++;
}




?>
<body>
<form  method="POST" name="frmMain"  enctype="multipart/form-data">
<div class="w3-white">
		<div class="w3-container w3-padding-large"><!-- main div -->
			<div class="w3-panel w3-light-gray"><h4>รายการติดตั้งสินค้า Online</h4></div>	
	
<center>
<span class="style15"><?php echo DateThai($start_date); ?>&nbsp;ถึง&nbsp;<?php echo DateThai($end_date); ?></span><br>
</center><br>
			
<table border= "1" width="100%" class='w3-table'>
<tr>
<td width="5%" align="center" class="style30">SN Number</td>
<td width="5%" align="center" class="style30">ชื่อลูกค้า</td>
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
<td width="5%" align="center" class="style30">ผลการรับประกัน</td> 
</tr>			
			
<?php
	
$strSQL51 = "SELECT DISTINCT date_save FROM tb_waranty  WHERE 1 ";
if($start_date !=""){ 
    $strSQL51 .= ' AND date_save >= "'.$start_date.'"'; 
}
if($end_date !=""){ 
    $strSQL51 .= ' AND date_save <= "'.$end_date.'"'; 
}
$objQuery51 = mysqli_query($conn,$strSQL51) or die ("Error Query [".$strSQL51."]");
$Num_Rows51 = mysqli_num_rows($objQuery51);

while($objResult51 = mysqli_fetch_array($objQuery51))
{	

$add_date = date('Y-m-d H:i:s');
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";
	
 $strSQL91 = "INSERT INTO tb_exportsn (channel,date_export,add_by,add_date) VALUES ('1','".$objResult51["date_save"]."','".$add_by."','".$add_date."')";
 $objQuery91 = mysqli_query($conn,$strSQL91)or die(mysqli_error());	
	
}	

$strSQL = "SELECT * FROM tb_waranty  WHERE 1 ";
if($start_date !=""){ 
    $strSQL .= ' AND date_save >= "'.$start_date.'"'; 
}
if($end_date !=""){ 
    $strSQL .= ' AND date_save <= "'.$end_date.'"'; 
}
$strSQL .=" order  by waranty_id  ASC  ";	
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);

while($objResult = mysqli_fetch_array($objQuery))
{
	
$strSQL2 = "SELECT war_hc,unit_hc,remark_hc,war_hos,unit_hos FROM  tb_product WHERE product_ID = '".$objResult["product_no"]."'";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);	
	

$warranty = substr($objResult["waranty"],0,1);
$customer_name = $objResult["customer_name"];	
$tel = $objResult["tel_cus"];	
$address = $objResult["cus_address"];	
$province = $objResult["cus_province"];	 
$postcode = $objResult["waranty"];
$warranty1 = $objResult["waranty"];
$register_date = $objResult["date_install"];
$product_sn1 = $objResult["serial_num"];

if($objResult["remark_war"]!=''){	
$more_warranty	= $objResult["remark_war"];
}else{
$more_warranty = $objResult2["remark_hc"];	
}
?>
	
<tr>
<td align="left" class="style30"><?php echo $objResult["serial_num"]; ?></td>
<td align="left" class="style30"><?php echo $objResult["product_name"]; ?></td>
<td align="left" class="style30"><?php echo $objResult["customer_name"]; ?></td>
<td align="left" class="style30"><?php echo $objResult["tel_cus"]; ?></td>
<td align="left" class="style30"><?php echo $objResult["cus_address"]; ?> <?php echo $objResult["cus_province"]; ?> <?php echo $objResult["cus_postcode"]; ?></td>
<td align="left" class="style30"><?php echo $objResult["date_install"]; ?></td>
<td align="right" class="style30"><?php echo $objResult["waranty"]; ?></td>
<td align="center" class="style30"><?php echo '0'; ?></td>
<td align="center" class="style30"><?php echo '0'; ?></td>
<td align="center" class="style30"><?php echo '-'; ?></td>


	
<?php
	
$datedate = date ("Y-m-d", strtotime($warranty1, strtotime($register_date)));	
	
$sql4="select product_sn from tb_products_in_stock where product_sn='".$product_sn1."' ";
$result4 = mysqli_query($service,$sql4) or die(mysqli_error());
$num4=mysqli_num_rows($result4); 
	
$sql41="select product_sn from tb_products_in_stock where product_sn='".$product_sn1."' ";
$result41 = mysqli_query($servicenb,$sql41) or die(mysqli_error());
$num41=mysqli_num_rows($result41); 
	

if($num4 > 0){	

$sql3="select install_cus_name from tb_installation_data where product_sn='".$product_sn1."' ";
$result = mysqli_query($service,$sql3) or die(mysqli_error());
$num=mysqli_num_rows($result);
$objResult3 = mysqli_fetch_array($result);
	
if($num > 0 and $objResult3["install_cus_name"] !='') {

 $MSG.="ขออภัยค่ะ รายการ  '".$product_sn1."'มีการติดตั้งข้อมูลแล้ว  ในชื่อคุณ '".$objResult3["install_cus_name"]."'<br>";
	
$strSQL9 = "UPDATE tb_installation_data SET warranty='".$warranty."'  where product_sn='".$product_sn1."'";
$objQuery9 = mysqli_query($service,$strSQL9)or die(mysqli_error());		
?>
<td align="center" class="style30"><font color='red'><?php echo "ขออภัยค่ะ รายการ  '".$product_sn1."'มีการติดตั้งข้อมูลแล้ว  ในชื่อคุณ '".$objResult3["install_cus_name"]."'<br>";  ?></font></td>
	
	<?php

}else if($num > 0 and $objResult3["install_cus_name"] ==''){
		 $MSG.="ขออภัยค่ะ รายการ  '".$product_sn1."'มีการติดตั้งข้อมูลตัวแทนจำหน่ายแล้ว และได้อัพเดตข้อมูลลูกค้าเรียบร้อยแล้วคะ<br>";
	
?>
<td align="center" class="style30"><font color='red'><?php echo "ขออภัยค่ะ รายการ  '".$product_sn1."'มีการติดตั้งข้อมูลตัวแทนจำหน่ายแล้ว และได้อัพเดตข้อมูลลูกค้าเรียบร้อยแล้วคะ<br>";  ?></font></td>
	
	<?php

$strSQL9 = "UPDATE tb_installation_data SET install_cus_name ='".$customer_name."',install_cus_address='".$address."',install_cus_tel='".$tel."',install_date='".$register_date."',warranty_phase='".$warranty1."',out_insurance_date='".$datedate."',add_date_search='".$date_edit."',warranty='".$warranty."',more_warranty='".$more_warranty."'  where product_sn='".$product_sn1."'";
$objQuery9 = mysqli_query($service,$strSQL9)or die(mysqli_error());

		}elseif($num == '0'){
 $strSQL9 = "INSERT INTO tb_installation_data (install_cus_id,install_cus_name,install_cus_address,install_cus_tel,product_sn,buy_date,install_date,warranty_phase,out_insurance_date,add_by,add_date,add_date_search,warranty,cus_id,more_warranty) VALUES ('".$product_sn1."','".$customer_name."','".$address."','".$tel."','".$product_sn1."','".$register_date."','".$register_date."','".$warranty1."','".$datedate."','".$add_by."','".$add_date."','".$date_edit."','".$warranty."','22522','".$more_warranty."')";
 $objQuery9 = mysqli_query($service,$strSQL9)or die(mysqli_error());

?>
<td align="center" class="style30"><font color='green'><?php echo "ลงทะเบียนติดตั้งเรียบร้อยแล้ว";  ?></font></td>
	
	<?php
	
	
}
$sql1_up="update tb_products_in_stock set buy_status='1' where product_sn='".$product_sn1."' ";
$objQuery5 = mysqli_query($service,$sql1_up)or die(mysqli_error());		
	
$sql23="select cus_name from tb_waranty_cus where sn_num ='".$product_sn1."' ";
$result23 = mysqli_query($service,$sql23) or die(mysqli_error());
$num23=mysqli_num_rows($result23);
$objResult23 = mysqli_fetch_array($result23);	
if($num23 =='0'){	
	
$strSQL19 = "INSERT INTO tb_waranty_cus (sn_num,date_save,cus_name,cus_add,cus_addtum,cus_ampher,cus_province,cus_postcode,cus_tel,email,add_by,add_date) VALUES ('".$product_sn1."','".$objResult["date_save"]."','".$objResult["customer_name"]."','".$objResult["cus_add"]."','".$objResult["cus_addtum"]."','".$objResult["cus_ampher"]."','".$objResult["cus_province"]."','".$objResult["cus_postcode"]."','".$objResult["tel_cus"]."','".$objResult["email"]."','".$add_by."','".$add_date."')";
	
 $objQuery19 = mysqli_query($service,$strSQL19)or die(mysqli_error());	
	

	
	?>
<td align="center" class="style30"><font color='green'><?php echo "ลงทะเบียนรับประกันเรียบร้อยแล้ว";  ?></font></td>	
<?php
	
}else if($num23=='1' and $objResult23["cus_name"]==''){		
	
$strSQL19 = "UPDATE tb_waranty_cus SET date_save='".$objResult["date_save"]."',cus_name='".$objResult["customer_name"]."',cus_add='".$objResult["cus_add"]."',cus_addtum='".$objResult["cus_addtum"]."',cus_ampher='".$objResult["cus_ampher"]."',cus_province='".$objResult["cus_province"]."',cus_postcode='".$objResult["cus_postcode"]."',cus_tel='".$objResult["tel_cus"]."',email='".$objResult["email"]."',add_by='".$add_by."',add_date='".$add_date."'  where sn_num='".$product_sn1."'";
	
 $objQuery19 = mysqli_query($service,$strSQL19)or die(mysqli_error());		
?>	
<td align="center" class="style30"><font color='green'><?php echo "ลงทะเบียนรับประกันเรียบร้อยแล้ว";  ?></font></td>	
<?php
	
}else if($num23 > 0){
	?>
<td align="center" class="style30"><font color='red'><?php echo "ขออภัยค่ะ รายการ  '".$product_sn1."'มีการลงทะเบียนรับประกันแล้วค่ะในชื่อของ คุณ '".$objResult23["customer_name"]."' ?><br>";  ?></font></td>
	
<?php	
}
	
	
}else if($num41 > 0){

$sql3="select * from tb_installation_data where product_sn='".$product_sn1."' ";
$result = mysqli_query($servicenb,$sql3) or die(mysqli_error());
$num=mysqli_num_rows($result);
$objResult3 = mysqli_fetch_array($result);	

if($num > 0 and $objResult3["install_cus_name"] !='') {

 $MSG.="ขออภัยค่ะ รายการ  '".$product_sn1."'มีการติดตั้งข้อมูลแล้ว  ในชื่อคุณ '".$objResult3["install_cus_name"]."'<br>";
	
$strSQL9 = "UPDATE tb_installation_data SET warranty='".$warranty."'  where product_sn='".$product_sn1."'";
$objQuery9 = mysqli_query($servicenb,$strSQL9)or die(mysqli_error());	
	
?>
<td align="center" class="style30"><font color='red'><?php echo "ขออภัยค่ะ รายการ  '".$product_sn1."'มีการติดตั้งข้อมูลแล้ว  ในชื่อคุณ '".$objResult3["install_cus_name"]."'<br>";  ?></font></td>
	
	<?php
}else if($num > 0 and $objResult3["install_cus_name"] =='')   		
        {
		 $MSG.="ขออภัยค่ะ รายการ  '".$product_sn1."'มีการติดตั้งข้อมูลตัวแทนจำหน่ายแล้ว และได้อัพเดตข้อมูลลูกค้าเรียบร้อยแล้วคะ<br>";
?>
<td align="center" class="style30"><font color='red'><?php echo "ขออภัยค่ะ รายการ  '".$product_sn1."'มีการติดตั้งข้อมูลตัวแทนจำหน่ายแล้ว และได้อัพเดตข้อมูลลูกค้าเรียบร้อยแล้วคะ<br>";  ?></font></td>
	
	<?php

$strSQL9 = "UPDATE tb_installation_data SET install_cus_name ='".$customer_name."',install_cus_address='".$address."',install_cus_tel='".$tel."',install_date='".$register_date."',warranty_phase='".$warrannty."',out_insurance_date='".$datedate."',add_date_search='".$date_edit."',warranty='".$warranty."',more_warranty='".$more_warranty."'  where product_sn='".$product_sn1."'";
$objQuery9 = mysqli_query($servicenb,$strSQL9)or die(mysqli_error());

		}elseif($num == '0'){
 $strSQL9 = "INSERT INTO tb_installation_data (install_cus_id,install_cus_name,install_cus_address,install_cus_tel,product_sn,buy_date,install_date,warranty_phase,out_insurance_date,add_by,add_date,add_date_search,warranty,cus_id,more_warranty) VALUES ('".$product_sn1."','".$customer_name."','".$address."','".$tel."','".$product_sn1."','".$register_date."','".$register_date."','".$warrannty."','".$datedate."','".$add_by."','".$add_date."','".$date_edit."','".$warranty."','1023','".$more_warranty."')";
 $objQuery9 = mysqli_query($servicenb,$strSQL9)or die(mysqli_error());

?>
<td align="center" class="style30"><font color='green'><?php echo "ลงติดตั้งเรียบร้อยแล้ว";  ?></font></td>
	
	<?php	
}
	
$sql1_up="update tb_products_in_stock set buy_status='1' where product_sn='".$product_sn1."' ";
$objQuery5 = mysqli_query($servicenb,$sql1_up)or die(mysqli_error());	
	
$sql23="select cus_name from tb_waranty_cus where sn_num ='".$product_sn1."' ";
$result23 = mysqli_query($servicenb,$sql23) or die(mysqli_error());
$num23=mysqli_num_rows($result23);
$objResult23 = mysqli_fetch_array($result23);	

if($num23 =='0'){	
	
$strSQL19 = "INSERT INTO tb_waranty_cus (sn_num,date_save,cus_name,cus_add,cus_addtum,cus_ampher,cus_province,cus_postcode,cus_tel,email,add_by,add_date) VALUES ('".$product_sn1."','".$objResult["date_save"]."','".$objResult["customer_name"]."','".$objResult["cus_add"]."','".$objResult["cus_addtum"]."','".$objResult["cus_ampher"]."','".$objResult["cus_province"]."','".$objResult["cus_postcode"]."','".$objResult["tel_cus"]."','".$objResult["email"]."','".$add_by."','".$add_date."')";
 $objQuery19 = mysqli_query($servicenb,$strSQL19)or die(mysqli_error());	
	
	?>
<td align="center" class="style30"><font color='green'><?php echo "ลงทะเบียนรับประกันเรียบร้อยแล้ว";  ?></font></td>	
<?php
	
}else if($num23=='1' and $objResult23["cus_name"]==''){	
	
$strSQL19 = "UPDATE tb_waranty_cus SET date_save='".$objResult["date_save"]."',cus_name='".$objResult["customer_name"]."',cus_add='".$objResult["cus_add"]."',cus_addtum='".$objResult["cus_addtum"]."',cus_ampher='".$objResult["cus_ampher"]."',cus_province='".$objResult["cus_province"]."',cus_postcode='".$objResult["cus_postcode"]."',cus_tel='".$objResult["tel_cus"]."',email='".$objResult["email"]."',add_by='".$add_by."',add_date='".$add_date."' where sn_num='".$product_sn1."'";
 $objQuery19 = mysqli_query($servicenb,$strSQL19)or die(mysqli_error());	
	
?>
	
<td align="center" class="style30"><font color='green'><?php echo "ลงทะเบียนรับประกันเรียบร้อยแล้ว";  ?></font></td>		
<?php	
	
}else if($num23 > 0){
	?>
<td align="center" class="style30"><font color='red'><?php echo "ขออภัยค่ะ รายการ  '".$product_sn1."'มีการลงทะเบียนรับประกันแล้วค่ะในชื่อของ คุณ '".$objResult23["customer_name"]."' ?><br>";  ?></font></td>
	
<?php	
}
	
}else{	
$MSGM.="ขออภัยค่ะ รายการ  '".$product_sn1."'ไม่มีสินค้าใน Stock<br>";	
	
?>
<td align="center" class="style30"><font color='red'><?php echo "ขออภัยค่ะ รายการ  '".$product_sn1."'ไม่มีสินค้าใน Stock<br>";  ?></font></td>
	
	<?php
}
	
}
			
//if($MSGM != ""){ echo ("$MSGM"); } 
//if($MSG != ""){	 echo ("$MSG");  }
	
			
			
?>
</tr>
</table>



<br><br><center>
<a href="main_salehos.php" class="w3-button w3-green w3-center"><font color="330066">กลับหน้าหลัก</font></a>
			</center><br><br>
</div></div>
<div id="cr_bar"><?php include "foot.php"; ?></div>
