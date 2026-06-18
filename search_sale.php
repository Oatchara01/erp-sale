<?php include('head.php'); 

include "dbconnect.php";
include "dbconnect_sale.php";

?>

<form name="frmSearch" method="GET" action="report_salerecord.php">
<div class="w3-white">
<div class="w3-panel w3-light-gray"><h4>ดึงข้อมูล Monthly Sales Record</h4></div>

<div class="w3-container w3-padding-large">

<div class="w3-half">

<div class="w3-container w3-third">

<input name="code" type="hidden" id="code" class="w3-input w3-light-gray" value="<?php echo $_SESSION['code'];?>">
<input name="name" type="hidden" id="name" class="w3-input w3-light-gray" value="<?php echo $_SESSION["name"];?>">
<input name="surname" type="hidden" id="surname" class="w3-input w3-light-gray" value="<?php echo $_SESSION["surname"];?>">


วันที่ :
<input name="start_date" type="date" id="start_date" class="w3-input w3-light-gray" value="<?php echo $_GET["start_date"];?>">
</div>
<div class="w3-container w3-third">


  ถึง
  <input name="end_date" type="date" id="end_date" class="w3-input w3-light-gray" value="<?php echo $_GET["end_date"];?>">

</div>




<div class="w3-container w3-third">

  บริษัท

<select name="company" id="company" style="width:160px" class="w3-input"   >
<option  value="">**โปรดเลือกหน่วยงาน**</option>
<option  value="3">ออลล์เวล ไลฟ์ บจก.</option>
<option  value="4">โนเบิล เมด บจก.</option>

</select>
</div>
</div>
<div class="w3-container w3-third">
กลุ่มลูกค้า
<input type='text' name = "mode_name" value ="<?php echo $_GET["mode_name"]; ?>"  id = "mode_name" class="w3-input" placeholder="ค้นหากลุ่มลูกค้า..."  style="width:50%;" /> 
<input type='hidden' name = "h_mode_name"  id = "h_mode_name" value ="<?php echo $_GET["h_mode_name"]; ?>"    class="button4" readonly>
	
</div>	
<div class="w3-container w3-third">


  <input type="submit" value="Search" class="w3-button w3-teal">
 </div><br>
</div>
</div>

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
		return "data_mode_cus.php?bill_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("mode_name","h_mode_name");
</script> 
	
	

