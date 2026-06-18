<?php include('head.php'); ?>


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
<div class="w3-container w3-white">	
<form   method="GET" name="frmMain" enctype="multipart/form-data" >

</p>
<div class="w3-container w3-padding-large">
	<div class="w3-panel w3-light-grey"><h3>รายการสินค้ายอดนิยมออนไลน์</h3></div>

<div class="w3-container w3-bar w3-quarter">
ค้นหา : <input name="Keyword" class="w3-input" style="width:90%;" type="text" id="Keyword" value="<?php echo 	$Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : ''; ?>"></div>
<div class="w3-bar w3-quarter w3-padding-xsmall">
<input type="submit" class="w3-button w3-teal" value="Search"></div>
		</div>

<?php
	$Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';

include "dbconnect.php";
include "dbconnect_sale.php";

$strSQL = "SELECT product_ID,access_code,sol_name,unit_name,ecom_ckk,ecom_count  FROM tb_product  where popular_2='1' and close_pro ='0'";

if($Keyword !=""){ //แสดงว่ามีค่า end_date ส่งมา หรือมีการค้นหา ก็ใหเต่อ String query
	$strSQL .= ' AND sol_name  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or sol_code  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or access_code   LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or access_name  LIKE "%'.$Keyword.'%"'; 
	
}

$objQuery = mysqli_query($new,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);



	$Per_Page = '10';  
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


$strSQL .=" order  by product_ID DESC   LIMIT $Page_Start , $Per_Page";
$objQuery  = mysqli_query($new,$strSQL);
?>
<div class="w3-container">
	<table border="1" width="100%" class="w3-table">
		<thead class="w3-gray">
			<th width="5%">ID สินค้า</th>
			<th width="10%">รหัสสินค้า</th>
			<th width="15%">ชื่อสินค้า</th>
			<th width="5%">หน่วย</th>
			<th width="8%">เลือกสินค้า</th>
			<th width="10%">จำนวนต่ำกว่ากำหนด</th>

	</thead>
<?php
$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{   

?>
		
		
<tbody>
<tr>
				<td><?php echo $objResult["product_ID"]; ?></td>
				<td><div align="left"><?php echo $objResult["access_code"];?></div></td>
				<td><div align="left"><?php echo $objResult["sol_name"];?></div></td>
				<td><div align="center"><?php echo $objResult["unit_name"];?></div></td>
				<td style="width:8%;"><?php if($objResult["ecom_ckk"]=='1'){ ?>
	<input type='checkbox' name = "ecom_ckk[<?php echo $objResult["product_ID"];?>]" checked='checked' value="1" id = "ecom_ckk[<?php echo $objResult["product_ID"];?>]" >
	<?php }else{ ?>
	<input type='checkbox' name = "ecom_ckk[<?php echo $objResult["product_ID"];?>]" value="1" id = "ecom_ckk[<?php echo $objResult["product_ID"];?>]" >
	<?php } ?>
	</td>
<td style="width:8%;">
<input type='text' name = "ecom_count[<?php echo $objResult["product_ID"];?>]" value="<?php echo $objResult["ecom_count"];?>" id = "ecom_count[<?php echo $objResult["product_ID"];?>]" placeholder="จำนวนต่ำกว่ากำหนด" style="color:black;text-align:center"   class="w3-input"  />

	
	<input name = "product_ID[<?php echo $objResult["product_ID"];?>]" value="<?php echo $objResult["product_ID"];?>" id = "product_ID[<?php echo $objResult["product_ID"];?>]" type='hidden' class="w3-input"  />

</td>
</tr>
</tbody>
			

<?php
	$i++;
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
	
	
<br><center>
 <input type="button" name ="Submit" value="บันทึก" class = "w3-button w3-teal" onClick="this.form.action='online_cls.php'; submit()">
	</center>	<br>	
</div>	</div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>	

</form>

</body>
</html>


