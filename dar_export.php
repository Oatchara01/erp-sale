<!--?php
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment; filename=testing.doc");
?-->
<html>
<head>
<link rel="stylesheet" href="css/w3.css">
<body>
<?php include('dbconnect.php');
	$get=$_GET['id'];
	$sql='select * from dar where id=$get';
	$query=mysqli_query($conn,$sql);
	$fetch=mysqli_fetch_array($query);
?>
<table name="dardardar" class="w3-table" border="1">
<tr>
<td><h3>ใบขอขึ้นทะเบียนเอกสาร</h3></td>
</tr>
<tr>
</body>
</html>