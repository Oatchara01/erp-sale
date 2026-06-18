<?php include('head.php'); 

include "dbconnect.php";
include "dbconnect_sale.php";

?>

<form name="frmSearch" method="GET" action="report_cusmember.php">
	<div class ="w3-white">
<div class="w3-panel w3-light-gray"><h4>รายงานการขายของสมาชิก Allwell</h4></div>

<div class="w3-container w3-padding-large">

<div class="w3-half">
<div class="w3-container w3-third">

วันที่ออกบิล :
<input name="start_date" type="date" id="start_date" class="w3-input w3-light-gray" value="<?php echo $_GET["start_date"];?>" >
</div>


<div class="w3-container w3-third">

ถึง :
<input name="end_date" type="date" id="end_date" class="w3-input w3-light-gray" value="<?php echo $_GET["end_date"];?>" >
</div>
<div class="w3-container w3-third">

ชื่อลูกค้า :
<input name="start_codecus" type="text" id="start_codecus" class="w3-input w3-light-gray" value="<?php echo $_GET["start_codecus"];?>">
<input name="h_start_codecus" type="hidden" id="h_start_codecus" class="w3-input w3-light-gray" value="<?php echo $_GET["h_start_codecus"];?>">
</div>



</div>

<div class="w3-half">
<div class="w3-container w3-third">

ชื่อสินค้า :
<input name="start_codepro" type="text" id="start_codepro" class="w3-input w3-light-gray" value="<?php echo $_GET["start_codepro"];?>">
<input name="h_start_codepro" type="hidden" id="h_start_codepro" class="w3-input w3-light-gray" value="<?php echo $_GET["h_start_codepro"];?>">

</div>

<div class="w3-container w3-third">

รหัสลูกค้า :
<input name="customer_no" type="text" id="customer_no" class="w3-input w3-light-gray" value="<?php echo $_GET["customer_no"];?>">

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
		return "data_pro_admdemothse.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("start_codepro","h_start_codepro");
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
		return "data_bill_namese.php?bill_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("start_codecus","h_start_codecus");
</script> 