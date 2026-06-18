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
<div class="w3-panel w3-light-gray"><h4>CUSTOMER CRM</h4></div>



</p>
<?php
$to_day = date('Y-m-d');
include "dbconnect.php";

$strSQL = "SELECT *  FROM tb_customer  where update_crm = '".$to_day."' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
$strSQL .=" order  by customer_id ASC";
$objQuery  = mysqli_query($conn,$strSQL);
?>

<div class="w3-container">
	<table border="1" width="100%" class="w3-table">
		<thead class="w3-gray">
			<th width="5%">ลำดับ</th>
			<th width="5%">ID ลูกค้า</th>
			<th width="5%">รหัสสมาชิกลูกค้า</th>
			<th width="10%">ชื่อลูกค้า</th>
			<th width="10%">เบอร์โทร</th>
			<th width="10%">วันเดือนปีเกิด</th>
			<th width="8%">วันที่สมัครสมาชิก</th>
			<th width="8%">สถานะ</th>
			
	</thead>
<?php
$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{

?>
		<tbody>
			<tr>
				<td><?php echo $i;?></td>
				<td><?php echo $objResult["customer_id"];?></td>
				<td><?php echo $objResult["customer_no"];?></td>
				<td><?php echo $objResult["customer_name"];?></td>
				<td><?php echo $objResult["cus_tel"];?></td>
				<td><?php echo Datethai($objResult["brithday"]);?></td>
				<td><?php echo Datethai($objResult["add_date"]);?></td>
				
				<?php 
 if($objResult["customer_no"]!=''){
 
 if($objResult["status_cus"]=='0'){ ?>
				<td bgcolor="#FFFF00">Gold Customer</td>
				<?php }else if($objResult["status_cus"]=='1'){ ?>
				<td  bgcolor="#CCFF99">Platinum Customer</td>
				<?php }else if($objResult["status_cus"]=='2'){ ?>
				<td  bgcolor="#00FF00">Daimond Customer</td>
				<?php
}	 }else{ ?>
				<td></td>
				<?php
		  
 } ?>
				
</tr>
</tbody>
			

<?php
$i++;
}
?>

</table><br><br>
</div></div>
<div id="cr_bar"><?php include "foot.php"; ?></div>

</form>
</body>
</html>


