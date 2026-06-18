<?php include('head.php'); 

include "dbconnect.php";
include "dbconnect_sale.php";

?>

<form name="frmSearch" method="GET" action="report_acc.php">
<div class="w3-white">
<div class="w3-container w3-padding-large">
<div class="w3-panel w3-light-gray"><h4>รายงานยอดขายประจำวัน</h4></div>



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
</div>

<div class="w3-half">

<div class="w3-container w3-third">
การชำระเงิน
			
				<select name="payment" class="w3-select">
				<option value="">**Please Select Item**</option>
				<?php
					$strSQL5 = "select * from tb_payment order by payment_ID";
					$objQuery5 = mysqli_query($conn,$strSQL5);
					if (!$objQuery5) {
						echo "Failed to fetch to MySQL: " . mysqli_error();
					}
					while ($objResuut5 = mysqli_fetch_array($objQuery5,MYSQLI_ASSOC)) {
						if($_GET["payment"] == $objResuut5["payment_ID"]) {
							$sel = "selected";
						}
						else {
							$sel = "";
						}
				?>
				<option class="w3-bar-item w3-button"  value="<?php echo $objResuut5['payment_ID']; ?>"<?php echo $sel;?>><?php echo $objResuut5['payment_name']; ?> | <?php echo $objResuut5['bank_name']; ?></option>
				<?php } ?>
				</select>

 </div>
	
	<div class="w3-container w3-third">


  สินค้า
    <input name="product_code" type="text" id="product_code" class="w3-input w3-light-gray" value="<?php echo $_GET["product_code"];?>">

  <input name="h_product_code" type="hidden" id="h_product_code" class="w3-input w3-light-gray" value="<?php echo $_GET["h_product_code"];?>">

</div><div class="w3-container w3-third">


   เขตการขาย
	
	<select name="sale_code" id="sale_code" style="width:160px" class="w3-input" >
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_team_adm where  ckk='1'  ORDER BY sale_code ASC ";
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
<div class="w3-container w3-third">


  <input type="submit" value="Search" class="w3-button w3-teal">
 </div><br>
</div>
</div>
</div>

</form>
<div id="cr_bar"><?php include "foot.php"; ?></div>

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
		return "data_reort_pro.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_code","h_product_code");
        </script>

