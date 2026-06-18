<?php include('head.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
   
  <script>
        function toggleAll(source) {
            var checkboxes = document.getElementsByName('order_ckk[]');
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = source.checked;
            }
        }
    </script> 
</head>
<body>

<form name="frmSearch" method="POST" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-white">
<div class="w3-container w3-padding-large">
<div class="w3-container w3-bar w3-light-gray w3-margin-bottom"><h4>รายการออเดอร์ LAZADA รอปริ้นใบปะ</h4></div>
	

<?php	
	
date_default_timezone_set("Asia/Bangkok");


include "dbconnect.php";
$strSQL = "SELECT order_id,order_refer_code,cs_remark,ref_id FROM so__main  where printst_ckk='0' and sale_channel='1' and doc_no !=''";

if($Keyword1 !=""){ //แสดงว่ามีค่า end_date ส่งมา หรือมีการค้นหา ก็ใหเต่อ String query
$strSQL .= ' AND order_refer_code  LIKE "%'.$Keyword1.'%"'; 
}

$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);


$strSQL .=" order  by order_id DESC ";
$objQuery  = mysqli_query($conn,$strSQL);


?>

<table border="1" width="100%" class="w3-table">
<thead class="w3-gray">
<td width="2%"><div align="center"><font color='black'>เลือก</font><br>
<input type="checkbox" onclick="toggleAll(this)" id="selectAll">
</div></td> 
<th width="8%"> หมายเลขคำสั่งซื้อ</th>
<th width="5%"> เลขขนส่ง</th>
<th width="5%"> ประเภทขนส่ง</th>
<th width="20%"> รายการสินค้า</th>
</thead>
<tbody>
<?php
$i = 1;
while ($objResult = mysqli_fetch_array($objQuery)) {
?>
<tr>
<td bgcolor="#00FF00">
    <input type="checkbox" name="order_ckk[]" value="1">
    <input type="hidden" name="order_id[]" value="<?php echo $objResult["order_id"];?>">
    <input type="hidden" name="ref_id[]" value="<?php echo $objResult["ref_id"];?>">
</td>
<td> <?php echo $objResult["order_id"];?></td>
<td> <?php echo $objResult["order_refer_code"];?></td>
<td> <?php echo $objResult["cs_remark"];?></td>

<td ><div align="left">
<?php
$strSQL1 = "SELECT sol_name FROM (so__submain LEFT JOIN tb_product ON so__submain.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."'  order by id ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

while($objResult1 = mysqli_fetch_array($objQuery1))
{
?>
<?php
	echo $objResult1["sol_name"]; 
	?><br />
<?php
}
?>
</div>
</td>
	
	
	
</tr>

<?php } ?>
	
	
	
	
</table>

 <div class="w3-panel" >     <strong>พบทั้งหมด</strong>
      <?= $Num_Rows+$Num_Rowsh1;?>
      <strong>รายการ</strong>
      
	 <br> 
	 
	 <div align="center">
		  <input type="button" name ="Submit" value="ดึงใบปะ" class="w3-button w3-teal" onClick="this.form.action='status_getlzd.php'; submit()">
	</div>		 
  
	  </div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>		 
</form>
</body>
</html>