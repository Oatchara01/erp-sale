<html>
<head>
<title>Select Product</title>
<link rel="stylesheet" href="css/w3.css">
</head>
<script language="javascript">
	function selData(no2,ProductCode,ProductName,UnitName,ProductPrice)
	{

		var sProductCode = self.opener.document.getElementById("product_code_a" +no2);
		sProductCode.value = ProductCode;

		var sProductName = self.opener.document.getElementById("product_name_a" +no2);
		sProductName.value = ProductName;

		var sUnitName = self.opener.document.getElementById("unit_name_a" +no2);
		sUnitName.value = UnitName;

		var sProductPrice = self.opener.document.getElementById("product_price_a" +no2);
		sProductPrice.value = ProductPrice;

		window.close();
	}
</script>
<body>
		 <form name="frmSearch" method="POST" >

<input name="Keyword" type="text" id="Keyword" value="<?php echo $_POST["Keyword"];?>">
<input type="submit" value="Search"></th></p>


<?php

include('dbconnect.php');
$strSQL = "SELECT * FROM tb_product  where product_code LIKE '%".$_POST["Keyword"]."%' or product_name LIKE '%".$_POST["Keyword"]."%' ";
//echo $strSQL;
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");

?>



<table width="600" border="1" class="w3-table">
  <tr>
    <th width="91"> <div align="center">ProductCode</div></th>
    <th width="98"> <div align="center">ProductName</div></th>
    <th width="198"> <div align="center">Unit</div></th>
    <th width="97"> <div align="center">Price</div></th>
  </tr>
<?php
while($objResult = mysqli_fetch_array($objQuery))
{
?>
  <tr>
    <td><div align="center"><a href="javascript:window.open('','_self');window.close()" OnClick="selData('<?php echo $_GET["Line_a"];?>' , '<?php echo $objResult["product_code"];?>','<?php echo $objResult["product_name"];?>' ,'<?php echo $objResult["unit_name"];?>','<?php echo $objResult["product_price"];?>');">
	<?php echo $objResult["product_code"];?>
	</a></div></td>
    <td><?php echo $objResult["product_name"];?></td>
    <td><?php echo $objResult["unit_name"];?></td>
    <td><?php echo $objResult["product_price"];?></td>
  </tr>
<?php
}
?>
</table>
<?php
mysqli_close($conn);
?>
</form>
</body>
</html>