<?php 

include('head.php');
include('dbconnect_sale.php');

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
<div class="w3-panel w3-light-gray"><h4>อนุมัติรายชื่อลูกค้า</h4></div>



</p>
<?php
include "dbconnect.php";

$strSQL = "SELECT *  FROM tb_customer_pre  where send_ad ='1' and status_cus = 'Request'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
$strSQL .=" order  by id DESC ";
$objQuery  = mysqli_query($conn,$strSQL);
?>
<div class="w3-container">
	<table border="1" width="100%" class="w3-table">
		<thead class="w3-gray">
			<th width="8%">ประเภทลุกค้า</th>
			<th width="10%">ชื่อลูกค้า</th>
			<th width="10%">ชื่อออกบิล</th>
			<th width="15%">ที่อยู่</th> 
			<th width="10%">จังหวัด</th>
			<th width="10%">เบอร์โทร</th>
			<th width="10%">ชื่อผู้ติดต่อ</th>
			<th width="8%">เขตการขาย</th>
			<th width="5%">ดูรายละเอียด</th>
			
	</thead>
<?php
$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{

$sql23 = "SELECT *   FROM tb_typecustomer where type_id  = '".$objResult["type_customer"]."'";
$qry23 = mysqli_query($conn,$sql23) or die(mysqli_error());
$rs23 = mysqli_fetch_assoc($qry23);	
	
?>
		<tbody>
			<tr>
			    <td><?php echo $rs23["type_name"];?></td>
				<td><?php echo $objResult["customer_name"];?></td>
				<td><?php echo $objResult["bill_name"];?></td>
				<td><?php echo $objResult["cus_address"];?></td>
				<td><?php echo $objResult["cus_province"];?></td>
				<td><?php echo $objResult["cus_tel"];?></td>
				<td><?php echo $objResult["contact_name"];?></td>
				<td><?php echo $objResult["sale_code"];?></td>
				
<td><a href="approve_customer.php?id=<?php echo $objResult["id"];?>"><img src="img/edit-icon.png" width="23" height="23" border="0" /></a></td>




</tr>
</tbody>
			

<?php
}
?>

</table>
<div class="w3-panel"><strong>พบทั้งหมด</strong> <?= $Num_Rows;?>
      <strong>รายการ</strong></div>
<div id="cr_bar"><?php include "foot.php"; ?></div>

</form>
</body>
</html>


