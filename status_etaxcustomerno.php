<?php 
include('head.php'); 
include('dbconnect_sale.php'); 
?>

<body>
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-white">
<div class="w3-container w3-padding-large">
<div class="w3-panel w3-light-gray"><h4>ข้อมูลลูกค้าขอใบกำกับภาษี (Update ไม่สำเร็จ)</h4></div>

<div class="w3-bar w3-quarter">
ค้นหา : <input name="Keyword" class="w3-input" style="width:90%;" type="text" id="Keyword" value="<?php echo $Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';?>"></div>
<div class="w3-bar w3-quarter w3-padding-xsmall">
<input type="submit" class="w3-button w3-teal" value="Search"></div>
</div>
</form>
<?php	
	$Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';

	date_default_timezone_set("Asia/Bangkok");

include "dbconnect.php";

$strSQL = "SELECT *  FROM tb_customer_etax  where import_order='2' ";	

if($Keyword !=""){ 
	$strSQL .= ' AND order_id  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or customer_name  LIKE "%'.$Keyword.'%"'; 
	$strSQL .= ' or tel_num  LIKE "%'.$Keyword.'%"'; 

}
//echo $strSQL;
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


$strSQL .=" order  by id DESC   LIMIT $Page_Start , $Per_Page";
$objQuery  = mysqli_query($conn,$strSQL);


?>
<div class="w3-container">
	<table border="1" width="100%" class="w3-table">
		<thead class="w3-gray">
			<th width="5%">เลขที่อ้างอิง</th>
			<th width="8%">วันที่ลงทะเบียน</th>
			<th width="10%">ชื่อลูกค้า</th>
			<th width="8%">เลขผู้เสียภาษี</th>
			<th width="8%">เบอร์โทร</th>
			<th width="15%">ที่อยุ่</th> 
			<th width="8%">Email</th>
			<!--th width="8%">ยอดขาย</th-->
			<th width="8%">หมายเลขคำสังซื้อ</th>
			<th width="8%">ช่องทางการขาย</th>
			<th width="5%">สถานะ</th>
			<th width="5%">แก้ไข</th>
	</thead>
<?php
$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
	
$head_name = $objResult["head_name"];
$last_name = $objResult["last_name"];
$customer_name = "$head_name $last_name";


$address = $objResult["address"];
$sub_district = $objResult["sub_district"];
$district = $objResult["district"];
$province = $objResult["province"];
$postcode = $objResult["postcode"];

$address_name = "$address $sub_district $district $province $postcode";	
	
?>
		<tbody>
			<tr>
				<td><?php echo $objResult["ref_id"];?></td>
				<td><?php echo DateThai($objResult["add_date"]);	?></td>
				<td><?php echo $customer_name;?></td>
				<td><?php echo $objResult["tax_id"];?></td>
				<td><?php echo $objResult["tel_num"];?></td>
				<td><?php echo $address_name;?></td>
				<td><?php echo $objResult["mail_cus"];?></td>
				<!--td><div align="rihgt"><?php echo number_format($objResult["amount"],2)."";?></div></td-->
				<td><?php echo $objResult["order_id"];?></td>
				<td><?php echo $objResult["sale_channel"];?></td>
				<?php if($objResult["import_order"]=='2'){	?>
						<td bgcolor="#FF3030" >Import ไม่สำเร็จ</td>
				<?php }else if($objResult["import_order"]=='1'){	?>
						<td bgcolor="#00FF00" >Import สำเร็จ</td>
				<?php }else{ ?>
				<td  bgcolor="#FFFF00" >รอ Import</td>
				<?php } ?>
								
<td><a href="etaxcustomer_edit.php?ref_id=<?php echo $objResult["ref_id"];?>"><img src="img/edit-icon.png" width="23" height="23" border="0" /></a></td>


			</tr>
			<?php $i++; } ?>
		</tbody>
	</table>

 <div class="w3-panel">    <strong>พบทั้งหมด</strong>
      <?= $Num_Rows;?>
      <strong>รายการ<span class="style14"> :</span>จำนวน</strong>
      <?=$Num_Pages;?>
      <strong>หน้า<span class="style14"> :</span></strong>
      <?
	if($Prev_Page)
	{
		echo " <a href='$_SERVER[SCRIPT_NAME]?Page=$Prev_Page&Keyword=$Keyword'>
<font color='black'><< Back</font></a> ";
	}

	for($i=1; $i<=$Num_Pages; $i++){
		if($i != $Page)
		{
			echo "[ <a href='$_SERVER[SCRIPT_NAME]?Page=$i&Keyword=$Keyword'>
<font color='black'>$i</font></a> ]";
			

		}
		else
		{
			echo "<b> $i </b>";
		}
	}
	if($Page!=$Num_Pages)
	{
		echo " <a href ='$_SERVER[SCRIPT_NAME]?Page=$Next_Page&Keyword=$Keyword'>
<font color='black'>Next>></font></a> ";
	}
	
	?>
      <br></div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>		

</body>
</html>