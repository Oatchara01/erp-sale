<?php include('head.php'); 

include "dbconnect.php";


?>

<form name="frmSearch" method="GET" action="report_actual.php">
<div class="w3-panel w3-light-gray"><h4>รายงานสรุปยอดขาย</h4></div>
<div class="w3-white">
<div class="w3-container w3-padding-large">

<div class="w3-half">



<div class="w3-container w3-third">


  เขตการขาย

	<select name="id_year" id="id_year" style="width:160px" class="w3-input" >
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_year ORDER BY id_year ASC";
//echo $strSQL5;
//exit();
$objQuery5 = mysqli_query($conn,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5))
{
?>
<option value="<?php echo $objResuut5["year_no"];?>"><?php echo $objResuut5["year_name"];?></option>
<?php
}
?>
</select>




</div>


<div class="w3-container w3-third">


  <input type="submit" value="Search" class="w3-button w3-teal">
 </div>
</div>
</div>

</form>
<?php require_once('foot.php'); ?>
