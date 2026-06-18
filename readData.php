<html>
<head>
<title>ThaiCreate.Com</title>
</head>
<body>
<?php
for($i=1;$i<=(int)$_POST["hdnMaxLine"];$i++)
{
	echo $_POST["product_code".$i];
	echo "<br>";
	echo $_POST["product_name".$i];
	echo "<br>";
	echo $_POST["unit_name".$i];
	echo "<br>";
	echo $_POST["sale_count".$i];
	echo "<br>";
	echo $_POST["product_price".$i];
	echo "<br>";
	echo $_POST["amount".$i];
	echo "<hr>";
}
?>
</body>
</html>