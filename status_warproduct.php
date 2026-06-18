<?php include('head.php'); 

include "dbconnect.php";
?>
<body>
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">

<div class="w3-white">
<div class="w3-container w3-padding-large">
	<div class="w3-panel w3-light-grey"><h3>รายการรับประกันสินค้า</h3></div>

<div class="w3-container w3-bar w3-quarter">
			ค้นหา : <input name="Keyword" class="w3-input" style="width:90%;" type="text" id="Keyword" value="<?php echo 	$Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : ''; ?>"></div>
	
	<div class="w3-bar w3-quarter w3-padding-xsmall">
		<input type="submit" class="w3-button w3-teal" value="Search"></div>
		</div>

<?php
	$Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';

include "dbconnect.php";

$strSQL = "SELECT product_ID FROM tb_product WHERE close_pro='0' AND (war_hc !='0' OR war_hos!='0')";


if($Keyword !=""){ //แสดงว่ามีค่า end_date ส่งมา หรือมีการค้นหา ก็ใหเต่อ String query
	$strSQL .= ' AND sol_name  LIKE "%'.$Keyword.'%"'; 
	}

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);



	$Per_Page = '30';  
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


$strSQL .=" order  by group1 ASC   LIMIT $Page_Start , $Per_Page";
$objQuery  = mysqli_query($conn,$strSQL);
?>
<div class="w3-container">
	<table border="1" width="100%" class="w3-table">
		<thead class="w3-gray">
			<th width="5%">ID สินค้า</th>
			<th width="8%">รหัสสินค้า</th>
			<th width="15%">ชื่อสินค้า</th>
			<th width="8%">ระยะรับประกัน HomeCare</th>
			<th width="10%">หมายเหตุ HomeCare</th>
			<th width="8%">ระยะรับประกัน Hospital</th>
			<th width="10%">หมายเหตุ Hospital</th>
			<?php if($_SESSION["name"]=='รุจิรา' or $_SESSION["name"]=='อัจฉรา' or $_SESSION["name"]=='ชลชินี' or $_SESSION["name"]=='พัชร์ชนัญ'){ ?>
			<th width="5%">แก้ไข</th>
			<?php } ?>
	</thead>
<?php
$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{   
	$strSQL6 = "SELECT access_code,sol_name,war_hc,unit_hc,remark_hc,war_hos,unit_hos,remark_hos FROM tb_product WHERE product_ID='".$objResult["product_ID"]."'";
	$objQuery6 = mysqli_query($conn,$strSQL6);
 	$objResult6 = mysqli_fetch_array($objQuery6);
	
		
?>
	<tbody>
			<tr>
				<td><?php echo $objResult["product_ID"];?></td>
				<td><div align="left"><?php echo $objResult6["access_code"];?></div></td>
				<td><div align="left"><?php echo $objResult6["sol_name"];?></div></td>
			
				<td><div align="center"><?php if($objResult6["war_hc"]!='0'){ echo $objResult6["war_hc"];?> <?php echo $objResult6["unit_hc"]; } ?></div></td>
				<td><div align="left"><?php echo $objResult6["remark_hc"];?></div></td>
				<td><div align="center"><?php if($objResult6["war_hos"]!='0'){ echo $objResult6["war_hos"];?> <?php echo $objResult6["unit_hos"]; } ?></div></td>
				<td><div align="left"><?php echo $objResult6["remark_hos"];?></div></td>
				
<?php if($_SESSION["name"]=='รุจิรา' or $_SESSION["name"]=='อัจฉรา' or $_SESSION["name"]=='ชลชินี' or $_SESSION["name"]=='พัชร์ชนัญ'){ ?>
<td><a href="edit_warpro.php?product_ID=<?php echo $objResult["product_ID"];?>"><img src="img/edit-icon.png" width="23" height="23" border="0" /></a>	</td>
<?php } ?>				
		
			
						<?php  
/*<td><a href="createnew_product.php?product_ID=<?php echo $objResult["product_ID"];?>"><img src="img/create.png" width="23" height="23" border="0" /></a></td>*/
 ?>


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
<div id="cr_bar"> <?php include "foot.php"; ?></div>	
</body>
</html>