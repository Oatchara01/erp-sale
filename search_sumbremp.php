<?php include('head.php'); 

include "dbconnect.php";
include "dbconnect_sale.php";

?>

<form name="frmSearch" method="GET" action="report_sumbremp_1.php">
<div class="w3-white">
<div class="w3-container w3-padding-large">

<div class="w3-panel w3-light-gray"><h4>รายงานสรุปการยืมสินค้า</h4></div>

<div class="w3-container w3-padding-large">

<div class="w3-half">
<div class="w3-container w3-third">
ชื่อลูกค้า 
<input type="text" name="customer_name" id="customer_name" class="w3-input" >
</div>

<div class="w3-container w3-third">
เขตการขาย :
<select name="sc" id="sc" style="width:160px" class="w3-input" >
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT distinct sale_name,sale_code FROM tb_team_adm where ckk!='2'  ORDER BY sale_code DESC";
$objQuery5 = mysqli_query($com,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5))
{
?>
<option value="<?php echo $objResuut5["sale_code"];?>"><?php echo $objResuut5["sale_code"];?> - <?php echo $objResuut5["sale_name"];?></option>
<?php
}
?>
</select>
<!--<input type='text' class="w3-input"  name="sale_code"  placeholder="Search ชื่อพนักงาน..." >            
<input name="h_sale_code" type="hidden" id="h_sale_code"  />-->
</div>


<div class="w3-container w3-third">

  <input type="submit" value="Search" class="w3-button w3-teal">
 </div>
</div>
</div>

</form>
  <br></div></div>
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
		return "data_employee_name.php?employee_name_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("sale_code","h_sale_code");
        </script>
