<?php 

include('head.php');
include('dbconnect_sale.php');

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


<body>
<form   method="GET" name="frmMain" enctype="multipart/form-data" >
<div class="w3-white">
		<div class="w3-container w3-padding-large">
<div class="w3-panel w3-light-gray">
	
<div class="w3-half"><h4>CUSTOMER</h4></div>
			
<div class="w3-half">			
<?php if($_SESSION["name"]=='นงลักษณ์' or $_SESSION["name"]=='สุดารัตน์' or $_SESSION["name"]=='อุษณีย์' or $_SESSION["name"]=='อัจฉรา' or $_SESSION["name"]=='พัชร์ชนัญ' or $_SESSION["name"]=='ชลชินี' ){ ?>
	
<a href="report_credit_thb.php" target="_blank" class="w3-button w3-grey w3-right"><font color="Blue">ข้อมูลวงเงินลูกค้า</font></a>	
	
<?php } ?>	
</div></div>

<div class="w3-container w3-bar w3-quarter">
			ชื่อลูกค้า : <input name="Keyword" class="w3-input" style="width:90%;" type="text" id="Keyword" value="<?php echo 	$Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : ''; ?>"></div>
	<div class="w3-container w3-bar w3-quarter">
			ชื่อออกบิล : <input name="bill_name" class="w3-input" style="width:90%;" type="text" id="bill_name" value="<?php echo 	$bill_name = isset($_GET['bill_name']) ? $_GET['bill_name'] : ''; ?>"></div>
	<div class="w3-container w3-bar w3-quarter">
			รหัสลูกค้า AWL : <input name="Keyword2" class="w3-input" style="width:90%;" type="text" id="Keyword2" value="<?php echo 	$Keyword2 = isset($_GET['Keyword2']) ? $_GET['Keyword2'] : ''; ?>"></div>
	<div class="w3-container w3-bar w3-quarter">
			รหัสลูกค้า NBM : <input name="Keyword3" class="w3-input" style="width:90%;" type="text" id="Keyword3" value="<?php echo 	$Keyword3 = isset($_GET['Keyword3']) ? $_GET['Keyword3'] : ''; ?>"></div>
	<div class="w3-container w3-bar w3-quarter">
			เบอร์โทรศัพท์ : <input name="Keyword1" class="w3-input" style="width:90%;" type="text" id="Keyword1" value="<?php echo 	$Keyword1 = isset($_GET['Keyword1']) ? $_GET['Keyword1'] : ''; ?>"></div>
		<div class="w3-container w3-bar w3-quarter">
			รหัสสมาชิก : <input name="Keyword4" class="w3-input" style="width:90%;" type="text" id="Keyword4" value="<?php echo 	$Keyword4 = isset($_GET['Keyword4']) ? $_GET['Keyword4'] : ''; ?>"></div>
			<div class="w3-container w3-bar w3-quarter">
						หมายเหตุ : <input name="Keyword5" class="w3-input" style="width:90%;" type="text" id="Keyword5" value="<?php echo 	$Keyword5 = isset($_GET['Keyword5']) ? $_GET['Keyword5'] : ''; ?>"></div>
			<div class="w3-container w3-bar w3-quarter">
						ID ลูกค้า : <input name="Keyword6" class="w3-input" style="width:90%;" type="text" id="Keyword6" value="<?php echo 	$Keyword6 = isset($_GET['Keyword6']) ? $_GET['Keyword6'] : ''; ?>"></div>
		<!--div class="w3-container w3-bar w3-quarter">
			เขตการขาย
			<select name="sale_code" id="sale_code" style="width:90%;" class="w3-input" >
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_team_adm where ckk!='1' ORDER BY sale_code ASC";
$objQuery5 = mysqli_query($com,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5)){
if($_GET['sale_code'] == $objResuut5["sale_code"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>
<option value="<?php echo $objResuut5["sale_code"];?>" <?php echo $sel;?>><?php echo $objResuut5["sale_code"];?> - <?php echo $objResuut5["sale_name"];?></option>
<?php
}
?>
</select>
			</div-->
			
		<div class="w3-bar w3-quarter w3-padding-xsmall">
		<input type="submit" class="w3-button w3-teal" value="Search"></div>
		</div>
<?php
$name =	$_SESSION["name"];

	if($name=='ปิยะ' or $name=='พัชร์ชนัญ' or $name=='บรรจบพร' or $name=='อัจฉรา' or $name=='ขนิษฐา' or $name=='สุภัสสร'){	?>
	<a href="customer_add.php"><img src="img/add.png" align="right"  width="60" height="60" border="0" /></a> 
	<?php }else if($name=='ภานุวัฒน์' or $name=='วาสนา' or $name=='เกศนีย์'){ ?>
	<a href="add_customer_allwell.php"><img src="img/add.png" width="50" align="right" height="50" /></a>
	<?php } ?>
</p>
<?php
$Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';
$Keyword1 = isset($_GET['Keyword1']) ? $_GET['Keyword1'] : '';
$Keyword2 = isset($_GET['Keyword2']) ? $_GET['Keyword2'] : '';
$Keyword3 = isset($_GET['Keyword3']) ? $_GET['Keyword3'] : '';
$Keyword4 = isset($_GET['Keyword4']) ? $_GET['Keyword4'] : '';
$Keyword5 = isset($_GET['Keyword5']) ? $_GET['Keyword5'] : '';
$Keyword6 = isset($_GET['Keyword6']) ? $_GET['Keyword6'] : '';
$bill_name = isset($_GET['bill_name']) ? $_GET['bill_name'] : '';
$sale_code = isset($_GET['sale_code']) ? $_GET['sale_code'] : '';
include "dbconnect.php";
	
	

?>
<div class="w3-container">
	<table border="1" width="100%" class="w3-table">
		<thead class="w3-gray">
			<th width="5%">ID ลูกค้า</th>
			<th width="5%">รหัสสมาชิกลูกค้า</th>
			<th width="5%">รหัสลูกค้า AWL</th>
			<th width="5%">รหัสลูกค้า NBM</th>
			<th width="8%">ประเภทลูกค้า</th>
			<th width="10%">ชื่อลูกค้า</th>
			<th width="10%">ชื่อออกบิล</th>
			<th width="15%">ที่อยู่</th> 
			<th width="10%">จังหวัด</th>
			<th width="10%">เบอร์โทร</th>
			<th width="10%">ชื่อผู้ติดต่อ</th>
			<!--th width="8%">เขตการขาย</th-->
			<th width="8%">สถานะ</th>
			<th width="5%">VIP</th>
			<th width="10%">หมายเหตุ</th>
			<th width="5%">แก้ไข</th>
			<th width="5%">ข้อมูลการขาย</th>
	</thead>
<?php
		
if($Keyword !='' or $Keyword1 !='' or $Keyword2 !='' or $Keyword3 !='' or $Keyword4 !='' or $Keyword5 !='' or  $Keyword6 !='' or $bill_name !='' or $sale_code!=''){		
		
$strSQL = "SELECT *  FROM tb_customer  where 1";

if($Keyword !=""){ 
	$strSQL .= ' AND customer_name  LIKE "%'.$Keyword.'%"'; 
	
}
if($Keyword1 !=""){ 
	$strSQL .= ' AND cus_tel  LIKE "%'.$Keyword1.'%"'; 
	}

if($Keyword2 !=""){ 
	$strSQL .= ' AND customer_code  LIKE "%'.$Keyword2.'%"'; 
	}
if($Keyword6 !=""){ 
	$strSQL .= ' AND customer_id  = "'.$Keyword6.'"'; 
	}

if($Keyword3 !=""){ 
	$strSQL .= ' AND customer_coden  LIKE "%'.$Keyword3.'%"'; 
	}
	if($Keyword4 !=""){ 
	$strSQL .= ' AND customer_no  LIKE "%'.$Keyword4.'%"'; 
	}
	if($Keyword5 !=""){ 
	$strSQL .= ' AND remark_cus  LIKE "%'.$Keyword5.'%"'; 
	}
	if($bill_name !=''){
		$strSQL .= ' AND bill_name  LIKE "%'.$bill_name.'%"'; 
	}
	/*if($sale_code !=''){
		$strSQL .= ' AND sale_code  = "'.$sale_code.'"'; 
	}*/
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


$strSQL .=" order  by customer_id DESC   LIMIT $Page_Start , $Per_Page";
$objQuery  = mysqli_query($conn,$strSQL);
		
		
		
$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{

$sql23 = "SELECT *   FROM tb_typecustomer where type_id  = '".$objResult["type_customer"]."'";
$qry23 = mysqli_query($conn,$sql23) or die(mysqli_error());
$rs23 = mysqli_fetch_assoc($qry23);	

	
?>
		<tbody>
			<tr>
				<?php if($objResult["close_ckk"]=='1'){ ?>
					<td bgcolor="#FF0000">
				<?php }else{ ?>
				<td>
					<?php } ?>
				<?php echo $objResult["customer_id"];?></td>
				<td><?php echo $objResult["customer_no"];?></td>
				<td><?php echo $objResult["customer_code"];?></td>
				<td><?php echo $objResult["customer_coden"];?></td>
			    <td><?php echo $rs23["type_name"];?></td>
				<td><?php echo $objResult["customer_name"];?></td>
				<td><?php echo $objResult["bill_name"];?></td>
				<td><?php echo $objResult["cus_address"];?></td>
				<td><?php echo $objResult["cus_province"];?></td>
				<td><?php echo $objResult["cus_tel"];?></td>
				<td><?php echo $objResult["contact_name"];?></td>
				<!--td><?php echo $objResult["sale_code"];?></td-->
				
				<?php 
 if($objResult["customer_no"]!=''){
 
 if($objResult["status_cus"]=='0'){ ?>
				<td bgcolor="#FFFF00">Gold Customer</td>
				<?php }else if($objResult["status_cus"]=='1'){ ?>
				<td  bgcolor="#CCFF99">Platinum Customer</td>
				<?php }else if($objResult["status_cus"]=='2'){ ?>
				<td  bgcolor="#00FF00">Daimond Customer</td>
				<?php
}	 }else{ ?>
				<td></td>
				<?php } ?>
				<?php  if($objResult["vip_ckk"]=='1'){ ?>
				<td  bgcolor="#00FF00">VIP</td>
				<?php }else{ ?>
				<td></td>
				<?php } ?>
				<td><?php echo $objResult["remark_cus"];?></td>
				
<td><a href="edit_customer.php?customer_id=<?php echo $objResult["customer_id"];?>"><img src="img/edit-icon.png" width="23" height="23" border="0" /></a></td>
				
<td><a href="status_customer_sale.php?bill_id=<?php echo $objResult["customer_id"];?>"  target="_blank"><img src="img/create.png" width="23" height="23" border="0" /></a></td>



</tr>
</tbody>
			

<?php
}
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
		echo " <a href='$_SERVER[SCRIPT_NAME]?Page=$Prev_Page&Keyword=$Keyword&Keyword1=$Keyword1&Keyword2=$Keyword2&Keyword3=$Keyword3&Keyword4=$Keyword4&Keyword5=$Keyword5&bill_name=$bill_name&Keyword6=$Keyword6'><span class='style40'><< Back</span></a> ";
	}

	for($i=1; $i<=$Num_Pages; $i++){
		if($i != $Page)
		{
			echo "[ <a href='$_SERVER[SCRIPT_NAME]?Page=$i&Keyword=$Keyword&Keyword1=$Keyword1&Keyword2=$Keyword2&Keyword3=$Keyword3&Keyword4=$Keyword4&bill_name=$bill_name&Keyword5=$Keyword5&Keyword6=$Keyword6'><span class='style40'>$i</span></a> ]";
			

		}
		else
		{
			echo "<b> $i </b>";
		}
	}
	if($Page!=$Num_Pages)
	{
		echo " <a href ='$_SERVER[SCRIPT_NAME]?Page=$Next_Page&Keyword=$Keyword&Keyword1=$Keyword1&Keyword2=$Keyword2&Keyword3=$Keyword3&Keyword4=$Keyword4&bill_name=$bill_name&Keyword5=$Keyword5&Keyword6=$Keyword6'><span class='style40'>Next>></span></a> ";
	}
	
	?>
</div></div></div>
<div id="cr_bar"><?php include "foot.php"; ?></div>

</form>
</body>
</html>


