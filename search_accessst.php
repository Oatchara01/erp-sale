<?php include('head.php'); ?>

<form name="frmSearch" method="GET" action="report_accessst2.php">
	<div class="w3-white">
<div class="w3-container w3-padding-large">


<div class="w3-panel w3-light-gray"><h4>ดึงข้อมูลลงทะเบียน Access Stock</h4></div>
			
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
<select name="sale_channel" id="sale_channel" class="w3-select" onchange="showUser(this.value)" OnChange="resutName(this.value);">
<option  value="">**โปรดเลือกช่องทางการขาย**</option>
<?php
$sqlchannel = "select * from tb_salechannel order by salechannel_ID";
$querychannel = mysqli_query($conn,$sqlchannel);
while ($fetchchannel = mysqli_fetch_array($querychannel,MYSQLI_ASSOC)) { ?>
<option class="w3-bar-item w3-button" value="<?php echo $fetchchannel['salechannel_ID']; ?>"><?php echo $fetchchannel['salechannel_nameshort']; ?><?php echo $fetchchannel['description_chanel']; ?></option>
<?php } ?>
</select>


</div>
</div>

<div class="w3-half">

<div class="w3-container w3-third">

  บริษัท

<select name="company" id="company" style="width:160px" class="w3-input"   >
<option  value="">**โปรดเลือกหน่วยงาน**</option>
<option  value="1/3">ฟาร์ ทริลเลี่ยน บจก.</option>
<option  value="2/4">โนเบิล เมด บจก.</option>

</select>

</div>
<div class="w3-container w3-third">


  <input type="submit" value="Search" class="w3-button w3-teal">
 </div>
</div>
</div>


</form>
<div id="cr_bar"><?php include "foot.php"; ?></div>

