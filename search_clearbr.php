<?php include('head.php'); ?>

<form name="frmSearch" method="POST" action="report_clearbr.php">
<div class="w3-white">
<div class="w3-container w3-padding-large">


<div class="w3-panel w3-light-gray"><h4>รายการใบยืมที่ถูกเคลียร์แล้ว</h4></div>
			
<div class="w3-half">
<div class="w3-container w3-third">

เลขที่ใบยืม :
<input name="iv_no" type="text" id="iv_no" class="w3-input" value="<?php echo $_GET["iv_no"];?>"></div>
	
<div class="w3-container w3-third">
  รหัสสินค้า
<input type='text' name = "product_codet" value="<?php echo $_GET["product_codet"];?>" id = "product_codet" class="w3-input" placeholder="ค้นหา รหัสสินค้า..." /> 

</div>

<div class="w3-container w3-third">

ชื่อสินค้า
<input type='text' name = "product_code"  value="<?php echo $_GET["product_code"];?>" id = "product_code" class="w3-input" placeholder="ค้นหา ชื่อสินค้า..." /> 
<input type='hidden' name = "h_product_code" value="<?php echo $_GET["h_product_code"];?>" id = "h_product_code"  class="w3-input" readonly>

</div>	
	
	</div>
	
  <input type="submit" value="Search" class="w3-button w3-teal">

</div></div>

</form>
<div id="cr_bar"> <?php include "foot.php"; ?></div>


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
		return "data_product_search1.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_pro_notdemo1.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_codet","h_product_code");
        </script>
