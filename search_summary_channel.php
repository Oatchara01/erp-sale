<?php include('head.php'); ?>

<form name="frmSearch" method="GET" action="report_summary_channel.php">
<div class="w3-white">
<div class="w3-container w3-padding-large">
รายงานสรุปตามช่องทางการขาย </p>

วันที่ซื้อ :
<input name="start_date" type="date" id="start_date" class="w3-input w3-light-gray" value="<?php echo $_GET["start_date"];?>">
  วันที่ส่งสินค้า :
  <input name="end_date" type="date" id="end_date" class="w3-input w3-light-gray" value="<?php echo $_GET["end_date"];?>">

ช่องทางการขาย
<select name="sale_channel" id="sale_channel" class="w3-select" >
<option  value="">**โปรดเลือกช่องทางการขาย**</option>
<?php
$sqlchannel = "select * from tb_salechannel order by salechannel_ID";
$querychannel = mysqli_query($conn,$sqlchannel);
while ($fetchchannel = mysqli_fetch_array($querychannel,MYSQLI_ASSOC)) { ?>
<option class="w3-bar-item w3-button" value="<?php echo $fetchchannel['salechannel_ID']; ?>"><?php echo $fetchchannel['salechannel_nameshort']; ?><?php echo $fetchchannel['description_chanel']; ?></option>
<?php } ?>
</select>

  <input type="submit" value="Search" class="w3-button w3-teal">

</div>
</div>

</form>
<div id="cr_bar"><?php include "foot.php"; ?></div>
