<?php include('head.php'); 

include "dbconnect.php";
include "dbconnect_sale.php";

?>

<form name="frmSearch" method="GET" action="report_jong_order.php">
<div class="w3-white">
<div class="w3-container w3-padding-large">

<div class="w3-panel w3-light-gray"><h4>ดึงข้อมูล Monthly Sales Record</h4></div>

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


  เขตการขาย
<select name="sale_code" id="sale_code" style="width:160px" class="w3-input" >
<option value="">**Please Select**</option>


<?php

$strSQL5 = "SELECT * FROM tb_team_all ORDER BY sale_code ASC";
//echo $strSQL5;
//exit();
$objQuery5 = mysqli_query($com,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5))
{
?>
<option value="<?php echo $objResuut5["sale_code"];?>"><?php echo $objResuut5["sale_code"];?> - <?php echo $objResuut5["sale_name"];?></option>
<?php
}
?>
</select>

</div>
</div>

<div class="w3-half">


<div class="w3-container w3-third">


  <input type="submit" value="Search" class="w3-button w3-teal">
 </div>
</div>
</div>

</form>
  <br></div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>
