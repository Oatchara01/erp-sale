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

<style type="text/css">
<!--
.style15 {
	font-size: 16px; color: #000000;
}
.style30 {font-size: 12; }
.style32 {font-size: 11px}
.style33 {font-size: 12px; }
.style34 {color: #FF0000}
.style35 {font-size: 12px; color: #f2f2f2; }
.style37 {color: #FF0000; font-size: 14px; }
.style38 {color: #f2f2f2}
.style39 {font-size: 14px}
.style40 {font-size: 16px; color: #FF0000; }
-->
</style>


</head>
<body>

<?php
$q = intval($_GET['q']);

$con = mysqli_connect('localhost:3307','root','web@ptli','sol');
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}
mysqli_set_charset($con,"utf8");

mysqli_select_db($con,"ajax_demo");
$sql="SELECT tb_salechannel.*,tb_province.* FROM tb_salechannel LEFT JOIN tb_province ON tb_salechannel.province_id=tb_province.province_ID WHERE salechannel_ID = '".$q."'";
$result = mysqli_query($con,$sql);
?>
</p>

<table>

<?php

while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
	?>
	<tr>
	
	<td class='style15'>วัตถุประสงค์การเบิก:</td>
	<td><input name='objective'  class='style15' value="<?php echo $row["salechannel_nameshort"];?>"/>
	</tr>
	<tr>
	<td class='style15'>หมายเลขคำสั่งซื้อ:</td>
	<td><input type='text' name='order_no' >
	</tr>
	<tr>
	<td class='style15'>ชื่อลูกค้าตามคำสั่งซื้อ:</td>
	<td><input type='text' name='order_name' >
	</tr>
    <tr>
	<td class='style15'>ชื่อลูกค้า:</td>
    <td class='style15'> <?php echo $row["salechannel_nameshort"];?></td>
	</tr>
	<tr>
	<td class='style15'>ชื่อลูกค้า:</td>
    <td class='style15'><?php echo $row["salechannel_nameshort"];?></td>
	</tr>
	<tr>
	<td class='style15'>ที่อยู่:</td>
    <td class='style15'><?php echo $row["address1"];?></td>
	</tr>
	<tr>
	<td></td>
  <td class='style15'><?php echo $row["address2"];  echo $row['province_name'];   echo $row['zip_code']; ?></td>
	</tr>
	<tr>
	<td class='style15'>หมายเหตุ:</td>
    <td class='style15'><?php echo $row['description_chanel']; ?></td>
    </tr>
<?php
}
//echo "</table>";
//mysqli_close($con);
?>
</body>
</html>