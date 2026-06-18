<?php include('head.php'); 

include "dbconnect.php";
include "dbconnect_sale.php";

?>
<body>
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-white">
<div class="w3-container w3-padding-large">

<div class="w3-container w3-panel w3-light-gray"><h4>Approve ขอปรับปรุงยอดสต็อก</h4></div>


<div class="w3-container">
	<table border="1" width="100%" class="w3-table">
		<thead class="w3-gray">
			
			<td width="8%">วันที่ปรับปรุงรายการ</td >
			<td width="10%">เลขที่เอกสาร</td > 
			<td width="15%">ชื่อผู้ออกบิล</td >
			<td width="15%">รายละเอียดการแก้ไข</td >
			<td width="10%">ผู้ดำเนินการ</td >
			<td width="2%">ดูรายละเอียด</td >
	</thead>


<?php	
	
	date_default_timezone_set("Asia/Bangkok");

$to_day = date('Y-m-d');


$emid = $_SESSION['code'];


$strSQL = "SELECT *  FROM st__main_new  where  status_doc ='Request'";
$objQuery = mysqli_query($new,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
$strSQL .=" order  by id DESC   ";
$objQuery  = mysqli_query($new,$strSQL);


?>

	
<?php
$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
	
?>
		
			<tr>
				

				<td ><?php echo DateThai($objResult["add_date"]); ?></td>
				<td ><?php echo $objResult["iv_no"];?></td>
				<td ><?php echo $objResult["customer_name"];?></td>
				<td ><div align="left"><?php echo $objResult["edit_remark"];?></div></td>
				<td ><?php echo $objResult["add_by"];?></td>
				<td><a href="register_apprefst.php?ref_id=<?php echo $objResult["ref_id"];?>"><img src="img/create.png" width="23" height="23" border="0" /></a></td>
				
			</tr>
			<?php 

	$i++; 			
}
		
?>
		
	</table>
 <br>
 </div></div>

</form>
     
<div id="cr_bar"> <?php include "foot.php"; ?></div>		
</body>
</html>