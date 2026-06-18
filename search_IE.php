<?php include('head.php'); 

include "dbconnect.php";
include "dbconnect_sale.php";

?>

<form name="frmSearch" method="GET" action="report_IE.php">
	
<div class="w3-white w3-container ">	
<div class="w3-panel w3-light-gray"><h4>รายงานใบกำกับภาษี</h4></div>

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

  บริษัท

<select name="company" id="company" style="width:160px" class="w3-input"   required>
<option  value="">**โปรดเลือกหน่วยงาน**</option>
<option  value="3">ออลล์เวล ไลฟ์ บจก.</option>
<option  value="4">โนเบิล เมด บจก.</option>

</select>

</div></div>
<div class="w3-half">
	
<div class="w3-container w3-third">

  ประเภทเอกสาร

<select name="typee" id="typee" style="width:160px" class="w3-input"   required>
<option  value="">**โปรดเลือกประเภทเอกสาร**</option>
<option  value="IE">IE</option>
<option  value="ET">ET</option>	
<option  value="AI">AI</option>
<option  value="IV">IV</option>
<option  value="IC">IC</option>		
<option  value="SR">SR</option>	
</select>

</div>	

<div class="w3-container w3-third">


  <input type="submit" value="Search" class="w3-button w3-teal">
 
</div>
</div>
</div>
	</div>
</form>
<div id="cr_bar"> <?php include "foot.php"; ?></div>
