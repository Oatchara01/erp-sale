<?php include('head.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
   
</head>
<body>

<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-white">
<div class="w3-container w3-padding-large">
<div class="w3-container w3-bar w3-light-gray w3-margin-bottom"><h4>รายการ SN มีปัญลงติดตั้งรับประกัน</h4></div>
	

<?php	
	
	date_default_timezone_set("Asia/Bangkok");

$to_day = date('Y-m-d');

include "dbconnect.php";
$strSQL = "SELECT *  FROM tb_snproprem  where ckk_close ='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);


$strSQL .=" order  by id ASC ";
$objQuery  = mysqli_query($conn,$strSQL);


?>

<table border="1" width="100%" class="w3-table">
<thead class="w3-gray">
<th width="10%" >ดำเนินการ</th>
<th width="10%" >SN สินค้า</th>
<th width="10%" >หมายเหตุ</th>
<th width="10%" >วันที่บันทึก</th>

</thead>
<?php
$i = 1;
while($objResult = mysqli_fetch_array($objQuery))
{
?>
<tbody>

 <tr>
<td bgcolor="#00FF00" >
	
<input type='checkbox' name = "ckk_close[<?php echo $objResult["id"];?>]" value="1" id = "ckk_close[<?php echo $objResult["id"];?>]" >

</td>

<td ><?php echo $objResult["id"];?>
<input type='hidden' name = "id[<?php echo $objResult["id"];?>]" value="<?php echo $objResult["id"];?>" id = "id[<?php echo $objResult["id"];?>]" >
</td>
		
<td ><?php echo $objResult["des"];?></td>
<td ><?php echo Datethai($objResult["add_date"]); ?></td>

	
	
</tr>	
	
	
	
	
<?php } ?>	
	
</tbody>
	
	
	
	
	
	
	
	
	
	
	
</table>

 <div class="w3-panel"  >    <strong>พบทั้งหมด</strong>
      <?= $Num_Rows;?>
      <strong>รายการ</strong>
      
	 <br> 
<?php if ($_SESSION['name']=='อัจฉรา' or $_SESSION['name']=='ชลชินี') { ?> 		 
	 <div align="center">
		  <input type="button" name ="Submit" value="บันทึก" class="w3-button w3-teal" onClick="this.form.action='status_snproprem_save.php'; submit()">
	</div>		 
<?php } ?>	  
	  </div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>		 
</form>
</body>
</html>