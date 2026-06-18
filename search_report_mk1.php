<?php include('head.php'); 

include "dbconnect.php";
include "dbconnect_sale.php";

?>

<form name="frmSearch" method="GET" action="report_summarymk_pro1.php">
<div class="w3-panel w3-light-gray"><h4>ประวัติการขาย / แยกตามสินค้า</h4></div>

<div class="w3-container w3-padding-large">

<div class="w3-half">

<div class="w3-container w3-third">

วันที่ :
<input name="start_date" type="date" id="start_date" class="w3-input w3-light-gray" value="<?php echo $_GET["start_date"];?>">
</div>
<div class="w3-container w3-third">


  ถึง
  <input name="end_date" type="date" id="end_date" class="w3-input w3-light-gray" value="<?php echo $_GET["end_date"];?>">

</div>

<div class="w3-container w3-third">


  สินค้า
    <input name="product_code" type="text" id="product_code" class="w3-input w3-light-gray" value="<?php echo $_GET["product_code"];?>">

  <input name="h_product_code" type="hidden" id="h_product_code" class="w3-input w3-light-gray" value="<?php echo $_GET["h_product_code"];?>">

</div>
</div>

<div class="w3-half">

<div class="w3-container w3-third">


  เขตการขาย


<select name="sale_code" id="sale_code" style="width:160px" class="w3-input" >
<option  value="">**Please Select**</option>
<option  value="(SOL99)">(SOL99)</option>
<option  value="รัชดาภรณ์ สีสัน (SOL2)">รัชดาภรณ์ สีสัน (SOL2)</option>
<option  value="หทัยชนก  ไชยแสง (SOL1)">หทัยชนก  ไชยแสง (SOL1)</option>
<option  value="SOL3">SOL3</option>

</select>



</div>
<div class="w3-container w3-third">


  <input type="submit" value="Search" class="w3-button w3-teal">
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
		return "data_prostockmk.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_code","h_product_code");
        </script>