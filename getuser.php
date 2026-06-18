<!DOCTYPE html>

<html>
<head>
<style>
table {
    width: 100%;
    border-collapse: collapse;
}

table, td, th {
    border: 0px solid black;
    padding: 5px;
}

th {text-align: left;}
</style>
</head>
<body>

<?php
	include "dbconnect.php";
$q = intval($_GET['q']);


$sql="SELECT tb_salechannel.*,tb_province.* FROM tb_salechannel LEFT JOIN tb_province ON tb_salechannel.province_id=tb_province.province_ID WHERE salechannel_ID = '".$q."'";
$result = mysqli_query($con,$sql);
?>
</p>

<table>

<?php

while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
	?>
	<tr>
	
	<td>วัตถุประสงค์การเบิก:</td>
	<td><input name='objective' class="w3-input" value="<?php echo $row["salechannel_nameshort"];?>"/>
	</tr>
	<tr>
	<td>หมายเลขคำสั่งซื้อ:</td>
	<td><input type='text' class="w3-input" name='order_no' >
	</tr>
	<tr>
	<td>ชื่อลูกค้าตามคำสั่งซื้อ:</td>
	<td><input type='text' class="w3-input" name='order_name' >
	</tr>
    <tr>
	<td>ชื่อลูกค้า:</td>
    <td> <?php echo $row["salechannel_nameshort"];?></td>
	</tr>
	<tr>
	<td>ชื่อลูกค้า:</td>
    <td><?php echo $row["salechannel_nameshort"];?></td>
	</tr>
	<tr>
	<td>ที่อยู่:</td>
    <td><?php echo $row["address1"];?></td>
	</tr>
	<tr>
	<td></td>
  <td><?php echo $row["address2"];  echo $row['province_id'];   echo $row['zip_code']; ?></td>
	</tr>
	<tr>
	<td>หมายเหตุ:</td>
    <td><?php echo $row['description_chanel']; ?></td>
    </tr>
<?php
}
echo "</table>";
mysqli_close($con);
?>
</body>
</html>