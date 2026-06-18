<?php 


include('head.php');

 
 
 ?>


<style type="text/css">
<!--
.style15 {
	font-size: 18px; color: #000000;
}
.style30 {font-size: 12; }
.style32 {font-size: 11px}
.style33 {font-size: 12px; }
.style34 {color: #FF0000}
.style35 {font-size: 14px; color: #f2f2f2; }
.style37 {color: #FF0000; font-size: 14px; }
.style38 {color: #f2f2f2}
.style39 {font-size: 14px; color: #000000;}
.style40 {font-size: 14px; color: #FF0000; }
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

.button1 {border-radius: 2px;}
.button2 {border-radius: 4px;}
.button3 {border-radius: 8px;}
.button4 {border-radius: 12px;}
.button5 {border-radius: 50%;}
</style>
<?php
include("dbconnect.php");

/*$sql1 = "select * from tb_vendor where vendor_code  LIKE '%".$POST_["vendor_group_code"]."%'' order by vendor_code desc limit 1";
$query1 = mysqli_query($conn,$sql1);
$fetch1 = mysqli_fetch_array($query1,MYSQLI_ASSOC); */

?>
<script type="text/javascript">
	function sSelect(){
		var vendor_group_code = document.frmMain.vendor_group_code.value
		
		if(vendor_group_code == 'VD1'){
			document.frmMain.vendor_group_name.value  = "Supplier ต่างประเทศ";
		}else if(vendor_group_code == 'VD2'){
			document.frmMain.vendor_group_name.value  = "Supplier ในประเทศ";
		}else if(vendor_group_code == 'VONE'){
			document.frmMain.vendor_group_name.value  = "Supplier เงินสด";
		}
	}
</script>

<body>
<form   method="GET" name="frmMain" enctype="multipart/form-data" >
<div class="w3-white">
<div class="w3-container w3-padding-large">

<div class="w3-panel w3-light-gray"><h4>ADD : VENDOR</h4></div>

<div class="w3-half">

<div class="w3-container w3-third">
รหัสกลุ่มผู้ขาย
<select name="vendor_group_code" id="vendor_group_code" class="w3-input"   onchange="sSelect()">
<option  value="">**โปรดเลือกรหัสกลุ่ม**</option>
<option  value="VD1">VD1 Supplier ต่างประเทศ</option>
<option  value="VD2">VD2 Supplier ในประเทศ</option>
<option  value="VONE">VONE Supplier เงินสด</option>

</select>

</div><div class="w3-container w3-third">
ชื่อกลุ่มผู้ขาย
<input name="vendor_group_name" class="w3-input" >
</div><div class="w3-container w3-third">
รหัสผู้ขาย
<input name="vendor_code"  class="w3-input" >
</div>

</div>

<div class="w3-half">

<div class="w3-container w3-third">

คำนำหน้าชื่อ 
<input name="prefix" class="w3-input" >

</div><div class="w3-container w3-third">
 ชื่อผู้ภาษาไทย
<input name="vendor_name_th" class="w3-input" >
</div><div class="w3-container w3-third">
 รหัสผู้ขายเก่า
<input name="vendor_code_old" class="w3-input" >
</div>

</div>


<div class="w3-half">

<div class="w3-container w3-third">
 สกุลเงิน
<input name="currency" class="w3-input" >
</div><div class="w3-container w3-third">
 รหัสบัญชีเจ้าหนี้
<input name="account_payable_code" class="w3-input" >
</div><div class="w3-container w3-third">
ชื่อบัญชีเจ้าหนี้
<input name="account_payable_name" class="w3-input" >
</div>

</div>

<div class="w3-half">

<div class="w3-container w3-third">

<input type='checkbox' name="condition_id"  value='1'>&nbsp;เงื่อนไขการชำระเงิน
</div><div class="w3-container w3-third">
 รหัสกลุ่มจัดซื้อ (Pur Group)
<input name="pur_group_code" class="w3-input" >
</div><div class="w3-container w3-third">
 ชื่อรหัสกลุ่มจัดซื้อ
<input name="pur_group_name" class="w3-input" >
</div>

</div>


<div class="w3-half">

<div class="w3-container w3-third">
เลขที่ผู้เสียภาษี
<input name="tax_number" class="w3-input" >
</div><div class="w3-container w3-third">
 หมายเลขโทรศัพท์ติดต่อ1
<input name="telephone_number1" class="w3-input" >
</div><div class="w3-container w3-third">
หมายเลขโทรศัพท์ติดต่อ2
<input name="telephone_number2" class="w3-input" >
</div>

</div>

<div class="w3-half">

<div class="w3-container w3-third">
เบอร์มือถือ
<input name="mobile_number" class="w3-input" >
</div><div class="w3-container w3-third">
 เบอร์แฟกซ์
<input name="fax" class="w3-input" >
</div><div class="w3-container w3-third">
 อีเมลล์
<input name="email" class="w3-input" >
</div>

</div>


<div class="w3-half">

<div class="w3-container w3-third">
เว็บไซต์
<input name="website" class="w3-input" >
</div><div class="w3-container w3-third">
ลำดับผู้ติดต่อ
<input name="contact_number" class="w3-input" >
</div><div class="w3-container w3-third">
คำนำหน้าผู้ติดต่อ
<input  name="contact_prefix" class="w3-input" >
</div>

</div>

<div class="w3-half">

<div class="w3-container w3-third">
ชื่อผู้ติดต่อ
<input name="contact_name" class="w3-input" >
</div><div class="w3-container w3-third">
 ตำแหน่งผู้ติดต่อ
<input name="contact_position" class="w3-input" >
</div><div class="w3-container w3-third">
 หมายเหตุ
<input name="description" class="w3-input" >
</div>

</div>




<div class="w3-half">

<div class="w3-container w3-third">
หมายเลขโทรศัพท์ติดต่อ1
<input name="contact_telephone1" class="w3-input" >
</div><div class="w3-container w3-third">
หมายเลขโทรศัพท์ติดต่อ2
<input name="contact_telephone2" class="w3-input" >
</div><div class="w3-container w3-third">
Mobile ผู้ติดต่อ
<input  name="contact_mobile" class="w3-input" >
</div>

</div>

<div class="w3-half">

<div class="w3-container w3-third">
Fax ผู้ติดต่อ
<input name="contact_fax" class="w3-input" >
</div><div class="w3-container w3-third">
 Email ผู้ติดต่อ
<input name="contact_email" class="w3-input" >
</div><div class="w3-container w3-third">
 อาคาร
<input name="buiding" class="w3-input" >
</div>

</div>


<div class="w3-half">

<div class="w3-container w3-third">
เลขที่
<input name="house_number" class="w3-input" >
</div><div class="w3-container w3-third">
หมู่ที่
<input name="village_no" class="w3-input" >
</div><div class="w3-container w3-third">
ซอย
<input  name="alley" class="w3-input" >
</div>

</div>

<div class="w3-half">

<div class="w3-container w3-third">
ถนน
<input name="road" class="w3-input" >
</div><div class="w3-container w3-third">
 แขวง
<input name="district" class="w3-input" >
</div><div class="w3-container w3-third">
 เขต
<input name="area" class="w3-input" >
</div>

</div>


<div class="w3-half">

<div class="w3-container w3-third">
จังหวัด
<input name="province" class="w3-input" >
</div><div class="w3-container w3-third">
ไปรษณีย์
<input name="post_code" class="w3-input" >
</div><div class="w3-container w3-third">
ประเทศ
<input  name="country" class="w3-input" >
</div>

</div>

<div class="w3-half">

<div class="w3-container w3-third">
ภ.ง.ด.
<input name="tax_id" class="w3-input" >
</div>

</div>







<br>
<center>
		  <input type="button" name ="Submit" value="บันทึก" class = "button button4" onClick="this.form.action='add_vendor1.php'; submit()">
</center>

</p>


<div class="w3-container w3-bar w3-quarter">
			ค้นหา : <input name="Keyword" class="w3-input" style="width:90%;" type="text" id="Keyword" value="<?php echo 	$Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : ''; ?>"></div>
		<div class="w3-bar w3-quarter w3-padding-xsmall">
		<input type="submit" class="w3-button w3-teal" value="Search"></div>
		</div>

<?php
	$Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';

include "dbconnect.php";

$strSQL = "SELECT *  FROM tb_vendor  where 1";

if($Keyword !=""){ //แสดงว่ามีค่า end_date ส่งมา หรือมีการค้นหา ก็ใหเต่อ String query
	$strSQL .= ' AND vendor_name_th  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or vendor_code   LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or vendor_code_old   LIKE "%'.$Keyword.'%"'; 
	
}

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);



	$Per_Page = '20';  
	$Page = isset($_GET['Page']) ? $_GET['Page'] : '';

	if(!isset($_GET['Page']))
	{
		$Page=1;
	}

	$Prev_Page = $Page-1;
	$Next_Page = $Page+1;

	$Page_Start = (($Per_Page*$Page)-$Per_Page);
	if($Num_Rows<=$Per_Page)
	{
		$Num_Pages =1;
	}
	else if(($Num_Rows % $Per_Page)==0)
	{
		$Num_Pages =($Num_Rows/$Per_Page) ;
	}
	else
	{
		$Num_Pages =($Num_Rows/$Per_Page)+1;
		$Num_Pages = (int)$Num_Pages;
	}


$strSQL .=" order  by vendor_id DESC   LIMIT $Page_Start , $Per_Page";
$objQuery  = mysqli_query($conn,$strSQL);
?>
<div class="w3-container">
	<table border="1" width="100%" class="w3-table">
		<thead class="w3-gray">
			<th width="15%">รหัสผู้ขาย</th>
			<th width="15%">ชื่อกลุ่มผู้ขาย</th>
			<th width="20%">ชื่อ Vendor ภาษาไทย</th>
			 <th width="15%">จังหวัด</th>
			<th width="15%">ประเทศ</th>
			<th width="15%">หมายเลขโทรศัพท์ติดต่อ</th>
			<th width="5%">แก้ไข</th>
	</thead>
<?php
$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
?>
		<tbody>
			<tr>
				<td><?php echo $objResult["vendor_code"];?></td>
				<td><?php echo $objResult["vendor_group_name"];?></td>
				<td><?php echo $objResult["vendor_name_th"];?></td>
				<td><?php echo $objResult["province"];?></td>
				<td><?php echo $objResult["country"];?></td>
				<td><?php echo $objResult["contact_telephone1"];?></td>
				<td><a href="edit_vendor.php?vendor_id=<?php echo $objResult["vendor_id"];?>"><img src="img/edit-icon.png" width="23" height="23" border="0" /></a></td>



</tr>
</tbody>
			

<?php
}
?>

</table>
<div class="w3-panel"><strong>พบทั้งหมด</strong> <?= $Num_Rows;?>
      <strong>รายการ<span class="style14"> :</span>จำนวน</strong>
      <?=$Num_Pages;?>
      <strong>หน้า<span class="style14"> :</span></strong>
      <?
	if($Prev_Page)
	{
		echo " <a href='$_SERVER[SCRIPT_NAME]?Page=$Prev_Page&Keyword=$Keyword'><span class='style40'><< Back</span></a> ";
	}

	for($i=1; $i<=$Num_Pages; $i++){
		if($i != $Page)
		{
			echo "[ <a href='$_SERVER[SCRIPT_NAME]?Page=$i&Keyword=$Keyword'><span class='style40'>$i</span></a> ]";
			

		}
		else
		{
			echo "<b> $i </b>";
		}
	}
	if($Page!=$Num_Pages)
	{
		echo " <a href ='$_SERVER[SCRIPT_NAME]?Page=$Next_Page&Keyword=$Keyword'><span class='style40'>Next>></span></a> ";
	}
	
	?>
</div>
</div></div>
<div id="cr_bar"><?php include "foot.php"; ?></div>


</form>
</body>
</html>


