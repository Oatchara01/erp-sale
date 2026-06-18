<?php include('head.php'); 

include "dbconnect.php";
include "dbconnect_sale.php";

$type_login = $_SESSION["type_login"];
$user_type = $_SESSION['user_type'];
if($type_login=='Sale' and $user_type=='Engineer'){
$sale ="eng_ckk='1'";
}else if($type_login=='Sale' or $type_login=='Sup_Sale'){
$sale ="sale_ckk='1'";	
}else if($type_login=='AllWell' or $type_login=='Sup_AllWell'){
$sale ="online_ckk='1'";	
}else if($type_login=='AllWell' or $type_login=='It'){
$sale ="adm_ckk='1'";	
}
?>

<form name="frmSearch" method="GET" action="report_productall.php">
	<div class="w3-white">
<div class="w3-panel w3-light-gray"><h4>รายงานสินค้าคงเหลือแบบเลือกรายการ</h4></div>

<div class="w3-container w3-padding-large">

<div class="w3-half">

<div class="w3-container w3-third">


หมวดสินค้า :
<select name="group" id="group" style="width:160" class="w3-input" >
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_modepro where $sale ORDER BY mode_name ASC";
$objQuery5 = mysqli_query($new,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5)){
?>
<option value="<?php echo $objResuut5["mode_name"];?>"><?php echo $objResuut5["mode_name"];?></option>
<?php
}
?>
</select>

</div>
<div class="w3-container w3-third">


  รหัสสินค้า
<input type='text' name = "product_codet"  id = "product_codet" class="w3-input" placeholder="ค้นหา รหัสสินค้า..." /> 
<input type='hidden' name = "h_product_codet"  id = "h_product_codet"  class="w3-input" readonly>

</div>
<div class="w3-container w3-third">

ชื่อภาษาอังกฤษ
<input type='text' name = "product_code"  id = "product_code" class="w3-input" placeholder="ค้นหา ชื่อสินค้า..." /> 
<input type='hidden' name = "h_product_code"  id = "h_product_code"  class="w3-input" readonly>

</div></div>
<div class="w3-half">
<div class="w3-container w3-third">

ชื่อภาษาไทย
<input type='text' name = "product_code1"  id = "product_code1" class="w3-input" placeholder="ค้นหา ชื่อสินค้า..." /> 
<input type='hidden' name = "h_product_code1"  id = "h_product_code1"  class="w3-input" readonly>

</div>
<div class="w3-container w3-third">
  <input type="submit" value="Search" class="w3-button w3-teal">
 </div>
</div>
</div>
</div>
</form>
	
<div id="cr_bar"><?php include "foot.php"; ?></div>




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
		return "data_product_search2.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_code","h_product_code");
        </script>


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
		return "data_product_search3.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_code1","h_product_code1");
        </script>




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
		return "data_pro_notdemo1.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_codet","h_product_codet");
        </script>
