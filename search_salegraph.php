<?php include('head.php'); 

include "dbconnect.php";
include "dbconnect_sale.php";

?>

<form name="frmSearch" method="GET" action="report_salegraph.php">
<div class="w3-white">
<div class="w3-panel w3-light-gray"><h4>Search ข้อมูลยอดขาย</h4></div>

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





</div>
<div class="w3-container w3-third">
  <input type="submit" value="Search" class="w3-button w3-teal">
 </div>
</div>
</div>

</form>
<div id="cr_bar"> <?php include "foot.php"; ?></div>		
