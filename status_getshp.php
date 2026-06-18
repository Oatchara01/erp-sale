<?php include('head.php'); ?>
<link rel="stylesheet" href="css/autocomplete.css"  type="text/css"/>
<script type="text/javascript" src="js/autocomplete.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
   
  <script>
        function toggleAll(source) {
            var checkboxes = document.querySelectorAll('input[type="checkbox"][name^="order_ckk"]');
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = source.checked;
            }
        }
	  
	          function toggleAll1(source) {
            var checkboxes = document.querySelectorAll('input[type="checkbox"][name^="drop_ckk"]');
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = source.checked;
            }
        }
	  
	          function toggleAll2(source) {
            var checkboxes = document.querySelectorAll('input[type="checkbox"][name^="pickupto_ckk"]');
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = source.checked;
            }
        }
	  
	          function toggleAll3(source) {
            var checkboxes = document.querySelectorAll('input[type="checkbox"][name^="dropto_ckk"]');
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = source.checked;
            }
        }
	  
    </script>
</head>
<body>


<div class="w3-white">
<div class="w3-container w3-padding-large">
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-container w3-bar w3-light-gray w3-margin-bottom"><h4>1123.3 รายการออเดอร์  Shopee รอกดรับ</h4></div>
	
<div class="w3-row" style="display: flex; gap: 10px;">
    <div class="w3-third" style="flex: 1;">
        ขนส่ง
        <select name="cs_remark" id="cs_remark" style="width:90%" class="w3-input w3-light-gray">
            <option value="">**โปรดเลือกขนส่ง**</option>
            <option value="SPX Express">SPX Express</option>
            <option value="Flash Express">Flash Express</option>
            <option value="Express Delivery - ส่งด่วน">Express Delivery - ส่งด่วน</option>
        </select>
    </div>

    <div class="w3-third" style="flex: 1;">
        หมายเลขคำสั่งซื้อ : 
        <input name="Keyword" class="w3-input" style="width:90%;" type="text" id="Keyword" value="<?php echo isset($_GET['Keyword']) ? $_GET['Keyword'] : '';?>">
    </div>

    <div class="w3-third" style="flex: 1;">
        เลขขนส่ง : 
        <input name="tracking_number" class="w3-input" style="width:90%;" type="text" id="tracking_number" value="<?php echo isset($_GET['tracking_number']) ? $_GET['tracking_number'] : '';?>">
    </div>

    <div class="w3-third" style="flex: 1;">
        รหัสสินค้า : 
        <input name="product_codet" class="w3-input" style="width:90%;" type="text" id="product_codet" value="<?php echo isset($_GET['product_codet']) ? $_GET['product_codet'] : '';?>">
		<input type='hidden' name = "h_product_codet"  id = "h_product_codet" value="<?php echo isset($_GET['h_product_codet']) ? $_GET['h_product_codet'] : '';?>" class="w3-input" readonly>
		

    </div>
</div></div>        
<br>
<center>
<input type="submit" class="w3-button w3-teal" value="Search">    
</center>    
</form><br>    
	
	
<?php	
	
date_default_timezone_set("Asia/Bangkok");

$cs_remark = isset($_GET['cs_remark']) ? $_GET['cs_remark'] : '';
$Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';
$tracking_number = isset($_GET['tracking_number']) ? $_GET['tracking_number'] : '';
$product_codet = isset($_GET['product_codet']) ? $_GET['product_codet'] : '';
$h_product_codet = isset($_GET['h_product_codet']) ? $_GET['h_product_codet'] : '';
	
$strSQL = "Update  so__main set ckk_item='1' Where sale_channel= '12'";
$objQuery = mysqli_query($conn,$strSQL);	

$strSQL = "Update  so__uppack set ckk_closd='1' Where sale_channel= '12'";
$objQuery = mysqli_query($conn,$strSQL);	
	

include "dbconnect.php";
	
if($h_product_codet!=''){	
$strSQL = "SELECT DISTINCT order_id,order_refer_code,cs_remark,register_date,ref_id,create_order FROM (so__main LEFT JOIN so__submain ON so__main.ref_id=so__submain.ref_idd) WHERE printst_ckk='0' AND sale_channel='12' and product_id ='".$h_product_codet."' and cancel_ckk='0' and ckk_h='0'  and cs_remark NOT LIKE '%Instant%' and doc_no !='' and order_id !=''";
}else{
$strSQL = "SELECT order_id, order_refer_code, cs_remark, ref_id,register_date,create_order FROM so__main WHERE printst_ckk='0' AND sale_channel='12' and cancel_ckk='0' and ckk_h='0' and cs_remark NOT LIKE '%Instant%' and doc_no !='' and order_id !=''";	
}

if ($cs_remark != "") { 
    $strSQL .= " AND cs_remark LIKE '%$cs_remark%'"; 
}

if ($Keyword != "") { 
    $strSQL .= " AND order_id LIKE '%$Keyword%'"; 
}

if ($tracking_number != "") { 
    $strSQL .= " AND order_refer_code LIKE '%$tracking_number%'"; 
}

if ($product_list != "") { 
    $strSQL .= " AND ref_id LIKE '%$product_list%'"; 
}

$objQuery = mysqli_query($conn, $strSQL) or die("Error Query [" . $strSQL . "]");
$Num_Rows = mysqli_num_rows($objQuery);

$strSQL .=" order by stock_remark DESC ";
$objQuery  = mysqli_query($conn,$strSQL);


?>
	
<form name="frmSearch" method="POST" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">	
<div class="w3-container">	
<table border="1" width="100%" class="w3-table">
<thead class="w3-gray">
<td width="2%"><div align="center"><font color='black'>pickup</font><br>
<input type="checkbox" onclick="toggleAll(this)" id="selectAll"> 
</div></td> 
<!--td width="2%"><div align="center"><font color='black'>dropoff</font><br>
<input type="checkbox" onclick="toggleAll1(this)" id="selectAll"> 
</div></td--> 
<td width="2%"><div align="center"><font color='black'>pickup วันถัดไป</font><br>
<input type="checkbox" onclick="toggleAll2(this)" id="selectAll"> 
</div></td> 
<!--td width="2%"><div align="center"><font color='black'>dropoff วันถัดไป</font><br>
<input type="checkbox" onclick="toggleAll3(this)" id="selectAll"> 
</div></td-->	
<th width="8%"> วันที่สั่งซื้อ</th>	
<th width="8%"> หมายเลขคำสั่งซื้อ</th>
<th width="5%"> เลขขนส่ง</th>
<th width="5%"> ประเภทขนส่ง</th>
<th width="8%"> รหัสสินค้า</th>	
<th width="20%"> รายการสินค้า</th>
<th width="8%"> จำนวนสินค้า</th>		
</thead>
<tbody>
<?php
$i = 1;
while ($objResult = mysqli_fetch_array($objQuery)) {
?>
<tr>
<td bgcolor="#00FF00">
   <input type="checkbox" name="order_ckk[<?php echo $objResult["order_id"];?>]" value="1">
   <input type="hidden" name="order_id[]" value="<?php echo $objResult["order_id"];?>">
   <input type="hidden" name="ref_id[]" value="<?php echo $objResult["ref_id"];?>">
</td>
<!--td bgcolor="#FFFF00">
   <input type="checkbox" name="drop_ckk[<?php echo $objResult["order_id"];?>]" value="1">
</td-->	
<td bgcolor="#FF9966">
   <input type="checkbox" name="pickupto_ckk[<?php echo $objResult["order_id"];?>]" value="1">
</td>	

<!--td bgcolor="#FF6600">
   <input type="checkbox" name="dropto_ckk[<?php echo $objResult["order_id"];?>]" value="1">
</td-->	
	
	
<td> <?php echo Datethai($objResult["create_order"]); echo " T: ";   echo  substr($objResult["create_order"],10); ?></td>	
<td> <?php echo $objResult["order_id"];?></td>
<td> <?php echo $objResult["order_refer_code"];?></td>
<td> <?php echo $objResult["cs_remark"];?></td>

<td ><div align="left">
<?php
$strSQL1 = "SELECT access_code FROM (so__submain LEFT JOIN tb_product ON so__submain.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."'   order by id";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

while($objResult1 = mysqli_fetch_array($objQuery1))
{
?>
<?php
	echo $objResult1["access_code"]; 
	?><br />
<?php
}
?>
</div>
</td>	
	
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
	
<td ><div align="right">
<?php
$strSQL1 = "SELECT sale_count,unit_name FROM (so__submain LEFT JOIN tb_product ON so__submain.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."'  order by id ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

while($objResult1 = mysqli_fetch_array($objQuery1))
{
?>
<?php
	echo $objResult1["sale_count"]; echo " "; echo $objResult1["unit_name"]; 
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
<input type="button" name ="Submit" value="กดรับออเดอร์" class="w3-button w3-teal" onClick="this.form.action='shp_upprocess.php'; submit()">
</div>		 
  
	  </div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>		 
</form>
</body>
</html>


<script type="text/javascript">
function make_autocom(autoObj,showObj){
	var mkAutoObj=autoObj; 
	var mkSerValObj=showObj; 
	new Autocomplete(mkAutoObj, function() {
		this.setValue = function(id) {		
			document.getElementById(mkSerValObj).value = id;
		}
		if ( this.isModified )
			this.setValue("");
		if ( this.value.length < 1 && this.isNotClick ) 
			return ;	
		return "data_product_stem.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_codet","h_product_codet");
        </script>



