<?php include('head.php'); 

include "dbconnect.php";
include "dbconnect_sale.php";

?>

<form name="frmSearch" method="GET" action="report_buyckk.php">
<div class="w3-white">
<div class="w3-container w3-padding-large">
<div class="w3-panel w3-light-gray"><h4>รายงานลูกค้าซื้อซ้ำ</h4></div>



<div class="w3-half">

<div class="w3-container w3-third">

วันที่ออกเอกสาร :
<input name="start_date" type="date" id="start_date" class="w3-input w3-light-gray" value="<?php echo $_GET["start_date"];?>">
</div>
	
	<div class="w3-container w3-third">

ถึง :
<input name="end_date" type="date" id="end_date" class="w3-input w3-light-gray" value="<?php echo $_GET["end_date"];?>">
</div>

<div class="w3-container w3-third">


  สินค้า
    <input name="product_code" type="text" id="product_code" class="w3-input" placeholder="Search ชื่อสินค้า..." value="<?php echo $_GET["product_code"];?>">

  <input name="h_product_code" type="hidden" id="h_product_code" class="w3-input " value="<?php echo $_GET["h_product_code"];?>">

</div>
	</div>

<div class="w3-half">
<div class="w3-container w3-third">
หมวดสินค้า

	<select name="group1" id="group1" style="width:160" class="w3-input" >
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_modepro ORDER BY id ASC";

$objQuery5 = mysqli_query($conn,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5)){
if($_GET["group1"] == $objResuut5["mode_name"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>
<option value="<?php echo $objResuut5["mode_name"];?>"<?php echo $sel;?>><?php echo $objResuut5["mode_name"];?></option>
<?php
}
?>
</select>
</div>	
	
<?php /*<div class="w3-container w3-third">


ลูกค้า
<input type='text' name = "bill_id"  id = "bill_id" class="w3-input" placeholder="Search ชื่อลูกค้า..." value="<?php echo $_GET["bill_id"];?>"  /> 
<input type='hidden' name = "h_bill_id"  id = "h_bill_id"  class="button4" value="<?php echo $_GET["h_bill_id"];?>"  readonly>	
	
</div>*/ ?>


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
		return "data_reort_pro.php?product_code_search=" +encodeURIComponent(this.value);
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
		return "data_bill_search.php?bill_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("bill_id","h_bill_id");
</script> 

