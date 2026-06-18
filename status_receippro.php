<?php 
include('head.php'); 
include "dbconnect.php";

?>
<body>
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-white w3-container w3-padding-large">

<div class="w3-container w3-panel w3-light-gray"><h4>รายการสินค้ายอดนิยมออนไลน์สินค้าเข้าพร้อมขาย</h4></div>




<div class="w3-container">
	<table border="1" width="100%" class="w3-table">
		<thead class="w3-gray">
			<td width="5%">ลำดับ</td >
			<td width="10%">รหัสสินค้า</td >
			<td width="25%">ชื่อสินค้า</td > 
			<td width="10%">หน่วย</td >
			<td width="10%">ยดคงเหลือ</td >
			<td width="5%">เปิดในแพลตฟอร์มแล้ว</td >
	</thead>
	

<?php	
	
	date_default_timezone_set("Asia/Bangkok");

$to_day = date('Y-m-d');


$strSQL = "SELECT access_code,sol_name,unit_name,product_ID  FROM tb_product  WHERE popular_2 ='1' and close_pro ='0' and close_out='1' and  close_in='1'";
	
$strSQL .=" order  by number ASC  ";	
$objQuery = mysqli_query($new,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);

$i=1;
while($objResult = mysqli_fetch_array($objQuery))
{
$strSQL37 = "SELECT SUM(count_send) AS count_send ,SUM(count_receive) AS count_receive FROM st__sbmain WHERE product_id = '".$objResult["product_ID"]."' ";
$objQuery37 = mysqli_query($new,$strSQL37);
$objResult37 = mysqli_fetch_array($objQuery37);

$count_send7 = $objResult37["count_send"];
$count_receive7 = $objResult37["count_receive"];
//คงเหลือ
$count_pro7 =$count_receive7-$count_send7;	

?>
		
<tr>
<td><?php echo $i;?></td>
<td><?php echo $objResult["access_code"];?></td>
<td><div align="left"><?php echo $objResult["sol_name"];?></div></td>
<td><?php echo $objResult["unit_name"];?></td>
<td><?php echo $count_pro7;?></td>
<td>
<a href=javascript:if(confirm('!!!เปิดสินค้าในส่วนของแพลตฟอร์มเรียบร้อยแล้วใช่หรือไม่')==true){window.location='almostpro_open.php?product_ID=<?php echo $objResult["product_ID"];?>';}><img src="img/create.png" width="23" height="23" border="0" /></a>
</td>				

	
				
			</tr>
			<?php $i++; 
				
}
?>
		
	</table>

 
      <br></div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>		


</body>
</html>