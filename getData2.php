<html>
<head>
<title>Select Product</title>
<link rel="stylesheet" href="css/w3.css">
</head>
<script language="javascript">
	function selData(no1,ProductID,ProductCode,ProductName,Unit,Price)
	{

		var sProductID = self.opener.document.getElementById("product_id" +no1);
		sProductID.value = ProductID;

		var sProductCode = self.opener.document.getElementById("access_code" +no1);
		sProductCode.value = ProductCode;

		var sProductName = self.opener.document.getElementById("access_name" +no1);
		sProductName.value = ProductName;

		var sUnit = self.opener.document.getElementById("unit_name" +no1);
		sUnit.value = Unit;

		var sPrice = self.opener.document.getElementById("sol_price" +no1);
		sPrice.value = Price;

		window.close();
	}
</script>
<body>
<form name="frmSearch" method="POST" >
<div class="w3-threequarter w3-center"><input name="Keyword" type="text" id="Keyword" value="<?php echo $_POST["Keyword"];?>" class="w3-input"></div>
<div class="w3-quarter"><input type="submit" value="Search" class="w3-button w3-teal w3-border"></th></div>


<?php

include('dbconnect.php');
$strSQL = "SELECT * FROM tb_product where product_ID LIKE '%".$_POST["Keyword"]."%' or access_code LIKE '%".$_POST["Keyword"]."%' or access_name LIKE '%".$_POST["Keyword"]."%' or express_code LIKE '%".$_POST["Keyword"]."%' ";
//echo $strSQL;
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");

?>

<table width="100%" border="1" class="w3-table">
  <tr>
  	<th width="98"> <div align="center">Code</div></th>
    <th width="98"> <div align="center">Name</div></th>
    <th width="198"> <div align="center">Unit</div></th>
    <th width="97"> <div align="center">Price</div></th>
  </tr>
<?php
while($objResult = mysqli_fetch_array($objQuery))
{
?>
  <tr>
    <td><div align="center"><a href="javascript:window.open('','_self');window.close()" OnClick="selData('<?php echo $_GET["Line"];?>' , '<?php echo $objResult["product_ID"];?>','<?php echo $objResult["access_code"];?>' ,'<?php echo $objResult["access_name"];?>' ,'<?php echo $objResult["unit_name"];?>','<?php echo $objResult["sol_price"];?>');">
	<?php echo $objResult["access_code"];?>
	</a></div></td>
	<td><?php echo $objResult["access_name"];?></td>
    <td><?php echo $objResult["unit_name"];?></td>
    <td><?php echo $objResult["sol_price"];?></td>
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