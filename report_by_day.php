<?php include('head.php'); 

include"dbconnect.php";
?>

<div class="w3-container">
<div class="w3-padding-large"></div>
<div class="w3-bar w3-light-gray">
<div class="w3-half"><h4>รายงานสรุปตามวันที่</h4></div>
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-half">
<table>
  <tr><td>วันที่ขาย</td>
  <td><input name="start_date" type="date" id="start_date" class="w3-input w3-light-gray" value="<?php echo $_GET["start_date"];?>"></td>
  <td>วันที่จัดส่ง</td>
  <td> <input name="end_date" type="date" id="end_date" class="w3-input w3-light-gray" value="<?php echo $_GET["end_date"];?>"></td>
  <td><input type="submit" value="Search" class="w3-button w3-teal"></td>
  </tr>
  </table>
</div>
</div>
</form>
<?php

$start_date=$_GET["start_date"];	
$end_date=$_GET["end_date"];	


	$sql = "SELECT * FROM ((so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd)LEFT JOIN tb_salechannel ON so__main.sale_channel=tb_salechannel.salechannel_ID) where 1 ";
	


	if($start_date !=""){ 
    $sql .= ' AND register_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $sql .= ' AND register_date <= "'.$end_date.'"'; 
}

//echo $sql;
	//exit();

	$query = mysqli_query($conn,$sql);
	$num_rows = mysqli_num_rows($query);





	

?>

<?php
while($result=mysqli_fetch_array($query,MYSQLI_ASSOC)){


$salechannel_nameshort=$result["salechannel_nameshort"];
$sale_channel =$result["sale_channel"];


?>
</br>
	ช่องทางการขาย : <?php echo $salechannel_nameshort;  ?>

<div class="w3-padding-small"></div>
<table class="w3-table" id="myTable" border="1">
  <tr class="w3-gray">
    <th style="width:10%;" onclick="sortTable(0)"> <div align="center">วันที่ </div></th>
    <th style="width:5%;" onclick="sortTable(1)"> <div align="center">เลขที่อ้างอิง </div></th>
    <th style="width:10%;" onclick="sortTable(2)"> <div align="center">หมายเลขคำสั่งซื้อ </div></th>
    <th style="width:15%;" onclick="sortTable(3)"> <div align="center">ชื่อลูกค้า </div></th>
    <th style="width:25%;" onclick="sortTable(4)"> <div align="center">รายการสินค้า </div></th>
    <th style="width:5%;" onclick="sortTable(5)"> <div align="center">จำนวน </div></th>
	<th style="width:5%;" onclick="sortTable(6)"> <div align="center">ราคา </div></th>
	<th style="width:5%;" onclick="sortTable(7)"> <div align="center">รวมเป็นเงิน </div></th>
	<th style="width:5%;" onclick="sortTable(8)"> <div align="center">เลขที่เอกสาร </div></th>
	<th style="width:15%;" onclick="sortTable(9)"> <div align="center">การจัดส่ง </div></th>
  </tr>

<?php

	$sql1 = "SELECT * FROM ((so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd)LEFT JOIN tb_salechannel ON so__main.sale_channel=tb_salechannel.salechannel_ID) where sale_channel='".$sale_channel."' ";
	


	if($start_date !=""){ 
    $sql1 .= ' AND register_date >= "'.$start_date.'"'; 
}

if($end_date !=""){ 
    $sql1 .= ' AND register_date <= "'.$end_date.'"'; 
}

//echo $sql1;
	//exit();

	$query1 = mysqli_query($conn,$sql1);
	$num_rows1 = mysqli_num_rows($query1);




while($result1=mysqli_fetch_array($query1,MYSQLI_ASSOC)){

	$ref_id =$result1["ref_id"];
	




?>
  <tr>
    <td><div align="center"><?php echo DateThai($result1["register_date"]);?><br /><font color="#b3b3b3">Send : <?php echo DateThai($result1["delivery_date"]);?></font></div></td>
    <td><?php echo $result1["ref_id"];?></td>
    <td><?php echo $result1["order_id"];?></td>
    <td><?php echo $result1["customer_name"];?></td>



<?php
	$sql2 = "SELECT * FROM so__submain  where ref_idd='".$ref_id."' ";

		$query2 = mysqli_query($conn,$sql2);
	$num_rows2 = mysqli_num_rows($query2);




while($result2=mysqli_fetch_array($query2,MYSQLI_ASSOC)){
	?>

    <td>
		
							<?php echo $result2["product_name"];?><br />
			
    </td>
    <td>
		
			
							<center><?php echo $result2["sale_count"];?><br /></center>
		
    </td>
	<td><div align="right">
		
							<?php echo $result2["price_per_unit"];?><br />
			
    </div></td>
    <td><div align="right">
		
							<?php echo $result2["amount"];?><br />
			
    </div></td>
	<td align="right"><?php echo $result1["doc_no"];?></td>
	<td align="right"><?php echo $result1["delivery_name"];?></td>
<?php 
}
	?>

 </tr>
<?php
}
	}

?> 
</table>
<?php


/*
if ($register!='' and $delivery!='') {
$total="select ref_id from so__main where register_date = '".$register."' and delivery_date='".$delivery."'";
$qtotal=mysqli_query($conn,$total);
$ftotal=mysqli_fetch_array($qtotal);
	$amount="select SUM(amount) as a from so__submain where ref_idd[]='".$ftotal['ref_id']."'";
	$qamount=mysqli_query($conn,$amount);
	$famount=mysqli_fetch_assoc($qamount);
	$sum=$famount['a'];
	echo "<div class='w3-panel w3-sand w3-border w3-center'><h5>รวมมูลค่า&nbsp;&nbsp;" .$sum. "&nbsp;&nbsp;บาท</h5></div>";
}
else if ($register!='' and $delivery=='') {
$total="select ref_id from so__main where register_date = '".$register."'";
$qtotal=mysqli_query($conn,$total);
$ftotal=mysqli_fetch_array($qtotal);
	$amount="select SUM(amount) as a from so__submain where ref_idd='".$ftotal['ref_id']."'";
	$qamount=mysqli_query($conn,$amount);
	$famount=mysqli_fetch_assoc($qamount);
	$sum=$famount['a'];
	echo "<div class='w3-panel w3-sand w3-border w3-center'><h5>รวมมูลค่า&nbsp;&nbsp;" .$sum. "&nbsp;&nbsp;บาท</h5></div>";
}
else if ($register=='' and $delivery!='') {
$total="select ref_id from so__main where delivery_date='".$delivery."'";
$qtotal=mysqli_query($conn,$total);
$ftotal=mysqli_fetch_array($qtotal);
	$amount="select SUM(amount) as a from so__submain where ref_idd='".$ftotal['ref_id']."'";
	$qamount=mysqli_query($conn,$amount);
	$famount=mysqli_fetch_assoc($qamount);
	$sum=$famount['a'];
	echo "<div class='w3-panel w3-sand w3-border w3-center'><h5>รวมมูลค่า&nbsp;&nbsp;" .$sum. "&nbsp;&nbsp;บาท</h5></div>";
}
else if ($register=='' and $delivery=='') {
	echo "<div class='w3-panel w3-sand w3-border w3-center'><h5>รวมมูลค่า&nbsp;&nbsp;0&nbsp;&nbsp;บาท</h5></div>";
}*/
?>
Total <?php echo $num_rows;?> Record : <?php echo $num_pages;?> Page :
<?php
if($prev_page)
{
	echo " <a href='$_SERVER[SCRIPT_NAME]?Page=$prev_page&register_date=$register&delivery_date=$delivery'><< Back</a> ";
}

for($i=1; $i<=$num_pages; $i++){
	if($i != $page)
	{
		echo "[ <a href='$_SERVER[SCRIPT_NAME]?Page=$i&register_date=$register&delivery_date=$delivery'>$i</a> ]";
	}
	else
	{
		echo "<b> $i </b>";
	}
}
if($page!=$num_pages)
{
	echo " <a href ='$_SERVER[SCRIPT_NAME]?Page=$next_page&register_date=$register&delivery_date=$delivery'>Next>></a> ";
}
$conn = null;
?>
<?php require_once('foot.php'); ?>
</div>
</body>
</html>