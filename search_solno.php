<?php include('head.php'); 

include "dbconnect.php";
include "dbconnect_sale.php";

?>

<form name="frmSearch" method="GET" action="report_solno.php">
<div class="w3-panel w3-light-gray"><h4>รายงานสรุปแยก SOL และ IV ที่ออกบิลแล้ว</h4></div>
<div class="w3-white">
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
ช่องทางการขาย
<select name="sale_channel" id="sale_channel" class="w3-select" style="width:200px" >
<option  value="">**โปรดเลือกช่องทางการขาย**</option>
<?php
$sqlchannel = "select * from tb_salechannel order by salechannel_ID";
$querychannel = mysqli_query($conn,$sqlchannel);
while ($fetchchannel = mysqli_fetch_array($querychannel,MYSQLI_ASSOC)) { ?>
<option class="w3-bar-item w3-button" value="<?php echo $fetchchannel['salechannel_ID']; ?>"><?php echo $fetchchannel['salechannel_nameshort']; ?><?php echo $fetchchannel['description_chanel']; ?></option>
<?php } ?>
</select>

</div></div>
<div class="w3-half">
<div class="w3-container w3-third">

  เลขที่ IV เคลียร์
  <input name="iv_no" type="text" id="iv_no" class="w3-input w3-light-gray" value="<?php echo $_GET["iv_no"];?>">

</div>
<div class="w3-container w3-third">


  <input type="submit" value="Search" class="w3-button w3-teal">
 
</div>
</div>
</div>
</form>
<div id="cr_bar"> <?php include "foot.php"; ?></div>
