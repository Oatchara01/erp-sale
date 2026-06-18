<?php include('head.php'); 

include "dbconnect.php";
include "dbconnect_sale.php";

?>

<form name="frmSearch" method="GET" action="report_soltype.php">
<div class="w3-panel w3-light-gray"><h4>รายงานสรุปแยก SOL </h4></div>
<div class="w3-white" >
<div class="w3-container w3-padding-large">

<div class="w3-half">


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

</div>

<div class="w3-container w3-third">

  เลขที่ SOL
  <input name="doc_no" type="text" id="doc_no" class="w3-input w3-light-gray" value="<?php echo $_GET["doc_no"];?>">

</div>
<div class="w3-container w3-third">


  <input type="submit" value="Search" class="w3-button w3-teal">
 
</div>

</div>

</div>
</div>
</form>
<div id="cr_bar"> <?php include "foot.php"; ?></div>
