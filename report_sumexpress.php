<?php include('head.php'); 

include "dbconnect.php";

?>

<form name="frmSearch" method="GET" action="report_sumexpress1.php">
<div class="w3-panel w3-light-gray"><h4>รายงาน Export ข้อมูลง Express</h4></div>

<div class="w3-container w3-padding-large">

<div class="w3-half">

<div class="w3-container w3-third">

วันที่ออกเอกสาร :
<input name="start_date" type="date" id="start_date" class="w3-input w3-light-gray" value="<?php echo $_GET["start_date"];?>">
</div>
	
	<div class="w3-container w3-third">

ถึง :
<input name="end_date" type="date" id="end_date" class="w3-input w3-light-gray" value="<?php echo $_GET["end_date"];?>">
</div>

<div class="w3-container w3-third">

  บริษัท


<select name="company" id="company" style="width:160px" class="w3-input" >
<option  value="">**Please Select**</option>
<option  value="1">บริษัท ฟาร์ ทริลเลียน จำกัด</option>
<option  value="2">บริษัท โนเบิล เมด จำกัด</option>
2</select>


</div>


</div>

<div class="w3-half">

<div class="w3-container w3-third">


ช่องทางการขาย
			<select name="sale_channel" id="sale_channel" class="w3-select" onchange="showUser(this.value)">
				<option  value="">**โปรดเลือกช่องทางการขาย**</option>
				<?php
					$sqlchannel = "select * from tb_salechannel order by salechannel_ID";
					$querychannel = mysqli_query($conn,$sqlchannel);
					while ($fetchchannel = mysqli_fetch_array($querychannel,MYSQLI_ASSOC)) {
						if($_GET["sale_channel"] == $fetchchannel["salechannel_ID"]) {
							$sel = "selected";
						}
						else {
							$sel = "";
						} ?>
				<option class="w3-bar-item w3-button" value="<?php echo $fetchchannel['salechannel_ID']; ?>" <?php echo $sel;?>><?php echo $fetchchannel['salechannel_nameshort']; ?>&nbsp;&nbsp;<?php echo $fetchchannel['description_chanel']; ?></option>
				<?php } ?>
			</select>
</div>
	
<div class="w3-container w3-third">


  <input type="submit" value="Search" class="w3-button w3-teal">
 </div>
</div>
</div>

</form>
<?php require_once('foot.php'); ?>

