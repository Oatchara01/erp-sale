<?php include('head.php'); 

include "dbconnect.php";
include "dbconnect_sale.php";

?>

<form name="frmSearch" method="POST" action="report_twodate3.php">
<div class="w3-panel w3-light-gray"><h4>รายงานตามวันที่ (เลือกวัน)</h4></div>

<div class="w3-container w3-padding-large">

<div class="w3-half">

<div class="w3-container w3-third">

วันที่ซื้อ :
<input name="start_date" type="date" id="start_date" class="w3-input w3-light-gray" value="<?php echo $_POST["start_date"];?>">
</div>


<div class="w3-container w3-third">


  สินค้า
    <input name="product_code" type="text" id="product_code" class="w3-input w3-light-gray" value="<?php echo $_POST["product_code"];?>">

  <input name="h_product_code" type="hidden" id="h_product_code" class="w3-input w3-light-gray" value="<?php echo $_POST["h_product_code"];?>">

</div>
</div>

<div class="w3-half">


<div class="w3-container w3-third">


  <input type="submit" name="submit" value="Search" class="w3-button w3-teal">
 </div>
</div>
</div>

</form>
<?php require_once('foot.php'); ?>



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
		return "data_reort_pro.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_code","h_product_code");
        </script>