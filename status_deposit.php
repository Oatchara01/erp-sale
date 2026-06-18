<?php include('head.php'); ?>
<body>
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-white">
<div class="w3-container w3-padding-large">
<div class="w3-panel w3-light-grey"><h3>รายการใบเงินมัดจำ</h3></div>
<div class="w3-bar w3-quarter">
วันที่ : <input    name="start_date" class="w3-input"   style="width:90%;"  value="<?php echo isset($_GET['start_date']) ? htmlspecialchars($_GET['start_date'], ENT_QUOTES, 'UTF-8') : ''; ?>"     type="date"  id="start_date"></div>
<div class="w3-bar w3-quarter">
ถึง :<input    name="end_date" class="w3-input"   style="width:90%;"  value="<?php echo isset($_GET['end_date']) ? htmlspecialchars($_GET['end_date'], ENT_QUOTES, 'UTF-8') : ''; ?>"     type="date"     id="end_date"></div>
<div class="w3-bar w3-quarter">
ค้นหา : <input name="Keyword" class="w3-input" style="width:90%;" type="text" id="Keyword" value="<?php echo 	$keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : ''; ?>"></div>
<div class="w3-bar w3-quarter w3-padding-xsmall">
<input type="submit" class="w3-button w3-teal" value="Search"></div>
</div>
</form>
<?php		  
	$keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';
	$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
	$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';

include "dbconnect.php";

$strSQL = "SELECT *  FROM tb_deposit  where 1 ";

if($start_date !=""){ 
    $strSQL .= ' AND bill_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $strSQL .= ' AND bill_date <= "'.$end_date.'"'; 
}
if($keyword !=""){ //แสดงว่ามีค่า end_date ส่งมา หรือมีการค้นหา ก็ใหเต่อ String query
	$strSQL .= ' AND iv_no  LIKE "%'.$keyword.'%"'; 
	$strSQL .= ' or bill_name  LIKE "%'.$keyword.'%"'; 
	$strSQL .= ' or bill_tel  LIKE "%'.$keyword.'%"'; 
	$strSQL .= ' or delivery_name  LIKE "%'.$keyword.'%"'; 
	$strSQL .= ' or customer_contact  LIKE "%'.$keyword.'%"'; 

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


$strSQL .=" order  by deposit_code DESC   LIMIT $Page_Start , $Per_Page";
$objQuery  = mysqli_query($conn,$strSQL);
?>
<div class="w3-container">
<table border="1" width="100%" class="w3-table">
<thead class="w3-gray">
<th width="5%">เลขที่อ้างอิง</th>
<th width="10%">วันที่</th>
<th width="10%">เลขที่</th>
<th width="10%">ชื่อลูกค้า</th> 
<th width="10%">เบอร์โทร</th>
<th width="23%">รายการสินค้า</th>
<th width="22%">ชื่อผู้ติดต่อ</th>
<th width="5%">Status</th>
<th width="5%">แก้ไข</th>
<th width="5%">สร้างใบสั่งขาย</th>
	<th width="5%">Print</th>
</thead>
<?php
$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
?>
<tbody>
<tr align="">
<td><?php echo $objResult["deposit_code"];?></td>
<td><?php echo DateThai($objResult["bill_date"]);?></td>
<td><?php echo $objResult["iv_no"];?></td>
<td><?php echo $objResult["bill_name"];?></td>
<td><?php echo $objResult["bill_tel"];?></td>

<td><div align="left">

	<?php echo $objResult["product_name1"];?> </p>
	<?php echo $objResult["product_name2"];?> </p>
	<?php echo $objResult["product_name3"];?> </p>
	<?php echo $objResult["product_name4"];?> </p>
	<?php echo $objResult["product_name5"];?> 


</div></td>

<td><div align="left"><?php echo $objResult["customer_contact"];?></div></td>




<td bgcolor="#FF3030"><?php echo "กำลังดำเนินการ";?></td>



<td>
	<?php if($objResult["deposit_code"]!='1'){ ?>
	<a href="register_deposit_edit.php?deposit_code=<?php echo $objResult["deposit_code"];?>"><img src="img/edit-icon.png" width="23" height="23" border="0" /></a>
<?php } ?>
</td>
<td>
	<?php if($objResult["deposit_code"]!='1'){ ?>
	<a href="register_so_allwell.php?deposit_code=<?php echo $objResult["deposit_code"];?>"><img src="img/create.png" width="23" height="23" border="0" /></a>
		
		<?php } ?> </td>

<td> <p align="center"><a href="report_deposit.php?deposit_code=<?php echo $objResult["deposit_code"];?>"><img src="img/print_icon-2.png"   width="60" height="60" border="0" /></a> </td>

</tr>
<?php
$i++;
}
?>
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
		echo " <a href='$_SERVER[SCRIPT_NAME]?Page=$Prev_Page&Keyword=$_GET[Keyword]&start_date=$_GET[start_date]&end_date=$_GET[end_date]'><span class='style40'><< Back</span></a> ";
	}

	for($i=1; $i<=$Num_Pages; $i++){
		if($i != $Page)
		{
			echo "[ <a href='$_SERVER[SCRIPT_NAME]?Page=$i&Keyword=$_GET[Keyword]&start_date=$_GET[start_date]&end_date=$_GET[end_date]'><span class='style40'>$i</span></a> ]";
			

		}
		else
		{
			echo "<b> $i </b>";
		}
	}
	if($Page!=$Num_Pages)
	{
		echo " <a href ='$_SERVER[SCRIPT_NAME]?Page=$Next_Page&Keyword=$_GET[Keyword]&start_date=$_GET[start_date]&end_date=$_GET[end_date]'><span class='style40'>Next>></span></a> ";
	}
	
	?>
</div>
<?php include('foot.php'); ?>
</div>
</body>
</html>