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


<body>
<form   method="GET" name="frmMain" enctype="multipart/form-data" >
<div class="w3-white">
		<div class="w3-container w3-padding-large">
<div class="w3-panel w3-light-gray"><h4>ADD : CUSTOMER</h4></div>






<div class="w3-container w3-bar w3-quarter">
			ชื่อลูกค้า : <input name="Keyword" class="w3-input" style="width:90%;" type="text" id="Keyword" value="<?php echo 	$Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : ''; ?>"></div>
			<div class="w3-container w3-bar w3-quarter">
			เบอร์โทรศัพท์ : <input name="Keyword1" class="w3-input" style="width:90%;" type="text" id="Keyword1" value="<?php echo 	$Keyword1 = isset($_GET['Keyword1']) ? $_GET['Keyword1'] : ''; ?>"></div>
		<div class="w3-container w3-bar w3-quarter">
			รหัสสมาชิก : <input name="Keyword4" class="w3-input" style="width:90%;" type="text" id="Keyword4" value="<?php echo 	$Keyword4 = isset($_GET['Keyword4']) ? $_GET['Keyword4'] : ''; ?>"></div>
			<div class="w3-container w3-bar w3-quarter">
			หมายเหตุ : <input name="Keyword5" class="w3-input" style="width:90%;" type="text" id="Keyword5" value="<?php echo 	$Keyword5 = isset($_GET['Keyword5']) ? $_GET['Keyword5'] : ''; ?>"></div>
		<div class="w3-bar w3-quarter w3-padding-xsmall">
		<input type="submit" class="w3-button w3-teal" value="Search"></div>
		</div>

<?php
$Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';
$Keyword1 = isset($_GET['Keyword1']) ? $_GET['Keyword1'] : '';
$Keyword4 = isset($_GET['Keyword4']) ? $_GET['Keyword4'] : '';
$Keyword5 = isset($_GET['Keyword5']) ? $_GET['Keyword5'] : '';

include "dbconnect.php";

$strSQL1 = "SELECT DISTINCT customer_id  FROM (tb_customer LEFT JOIN tb_selected_sales ON tb_customer.customer_id=tb_selected_sales.id_customer)  where tb_selected_sales.sale_code LIKE '%SOL%' and tb_customer.close_ckk = '0'";

if($Keyword !=""){ 
	$strSQL1 .= ' AND tb_customer.customer_name  LIKE "%'.$Keyword.'%"'; 
}
if($Keyword1 !=""){ 
	$strSQL1 .= ' AND tb_customer.cus_tel  LIKE "%'.$Keyword1.'%"'; 
	}
	if($Keyword5 !=""){ 
	$strSQL1 .= ' AND tb_customer.remark_cus  LIKE "%'.$Keyword5.'%"'; 
	}
	if($Keyword4 !=""){ 
	$strSQL1 .= ' AND tb_customer.customer_no  LIKE "%'.$Keyword4.'%"'; 
	}
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);



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


$strSQL1 .=" order  by customer_id DESC   LIMIT $Page_Start , $Per_Page";
$objQuery1  = mysqli_query($conn,$strSQL1);
?>
<div class="w3-container">
	
<a href="add_customer_allwell.php"><img src="img/add.png" width="50" align="right" height="50" /></a>

	<table border="1" width="100%" class="w3-table">
		<thead class="w3-gray">
			<th width="5%">ID ลูกค้า</th>
			<th width="5%">รหัสสมาชิกลูกค้า</th>
			<th width="20%">ชื่อลูกค้า</th>
			<th width="25%">ที่อยู่</th> 
			<th width="15%">จังหวัด</th>
			<th width="15%">เบอร์โทร</th>
			<th width="15%">ชื่อผู้ติดต่อ</th>
			<th width="10%">สถานะ</th>
			<th width="5%">VIP</th>
			<th width="10%">หมายเหตุ</th>
			<!--th width="10%">เขตการขาย</th-->
			<th width="5%">แก้ไข</th>
			<th width="5%">ข้อมูลการขาย</th>
	</thead>
<?php
$i = 1;
while($objResult1 = mysqli_fetch_array($objQuery1))
{
	
$strSQL = "SELECT *  FROM tb_customer  WHERE customer_id = '".$objResult1["customer_id"]."'";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);
	
	
?>
		<tbody>
			<tr>
				<td><?php echo $objResult["customer_id"];?></td>
				<td><?php echo $objResult["customer_no"];?></td>
				<td><?php echo $objResult["customer_name"];?></td>
				<td><?php echo $objResult["cus_address"];?></td>
				<td><?php echo $objResult["cus_province"];?></td>
				<td><?php echo $objResult["cus_tel"];?></td>
				<td><?php echo $objResult["contact_name"];?></td>
				

				<?php
 if($objResult["customer_no"] !=''){
 if($objResult["status_cus"]=='0'){ ?>
				<td bgcolor="#FFFF00">Gold Customer</td>
				<?php }else if($objResult["status_cus"]=='1'){ ?>
				<td  bgcolor="#CCFF99">Platinum Customer</td>
				<?php }else if($objResult["status_cus"]=='2'){ ?>
				<td  bgcolor="#00FF00">Daimond Customer</td>
				<?php
}									 
}else{ ?>
				<td></td>
				<?php } ?>
				<?php  if($objResult["vip_ckk"]=='1'){ ?>
				<td  bgcolor="#00FF00">VIP</td>
				<?php }else{ ?>
				<td></td>
				<?php } ?>
			<td><?php echo $objResult["remark_cus"];?></td>	
			<!--td><?php echo $objResult["sale_code"];?></td-->	
<td><a href="edit_customer_allwell.php?customer_id=<?php echo $objResult["customer_id"];?>"><img src="img/edit-icon.png" width="23" height="23" border="0" /></a></td>
<td><a href="status_customer_showromm.php?bill_id=<?php echo $objResult["customer_id"];?>" target="_blank"><img src="img/create.png" width="23" height="23" border="0" /></a></td>



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
		echo " <a href='$_SERVER[SCRIPT_NAME]?Page=$Prev_Page&Keyword=$Keyword&Keyword1=$Keyword1&Keyword4=$Keyword4&Keyword5=$Keyword5'><span class='style40'><< Back</span></a> ";
	}

	for($i=1; $i<=$Num_Pages; $i++){
		if($i != $Page)
		{
			echo "[ <a href='$_SERVER[SCRIPT_NAME]?Page=$i&Keyword=$Keyword&Keyword1=$Keyword1&Keyword4=$Keyword4&Keyword5=$Keyword5'><span class='style40'>$i</span></a> ]";
			

		}
		else
		{
			echo "<b> $i </b>";
		}
	}
	if($Page!=$Num_Pages)
	{
		echo " <a href ='$_SERVER[SCRIPT_NAME]?Page=$Next_Page&Keyword=$Keyword&Keyword1=$Keyword1&Keyword4=$Keyword4&Keyword5=$Keyword5'><span class='style40'>Next>></span></a> ";
	}
	
	?>
</div></div>
<div id="cr_bar"><?php include "foot.php"; ?></div>

</form>
</body>
</html>