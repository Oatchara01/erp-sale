<?php include('head.php'); ?>
<script language="JavaScript">
var HttPRequest = false;
function doCallAjax(customer,address) {
HttPRequest = false;
if (window.XMLHttpRequest) { // Mozilla, Safari,...
HttPRequest = new XMLHttpRequest();

if (HttPRequest.overrideMimeType) {
HttPRequest.overrideMimeType('text/html');
}
} else if (window.ActiveXObject) { // IE
try {
HttPRequest = new ActiveXObject("Msxml2.XMLHTTP");
} catch (e) {
try {
HttPRequest = new ActiveXObject("Microsoft.XMLHTTP");
} catch (e) {}
}
}

if (!HttPRequest) {

alert('Cannot create XMLHTTP instance');
return false;
}
var url = 'data_customer_popup.php';
var pmeters = "customer=" + encodeURI( document.getElementById(customer).value);
HttPRequest.open('POST',url,true);

HttPRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
HttPRequest.setRequestHeader("Content-length", pmeters.length);
HttPRequest.setRequestHeader("Connection", "close");
HttPRequest.send(pmeters);

HttPRequest.onreadystatechange = function()
{
if(HttPRequest.readyState == 4) // Return Request
{
var myProduct = HttPRequest.responseText;

if(myProduct != "")
{

var myArr = myProduct.split("|");

document.getElementById(address).value = myArr[0];

}}}}

</script>
<script>
	function toggleField(hideObj,showObj){
		hideObj.disabled=true;        
		hideObj.style.display='none';
		showObj.disabled=false;   
		showObj.style.display='inline';
		showObj.focus();
	}

	function toggleField2(hideObj2,showObj2){
		hideObj2.disabled=true;        
		hideObj2.style.display='none';
		showObj2.disabled=false;   
		showObj2.style.display='inline';
		showObj2.focus();
	}


	function openTab(tabName) {
		var i;
		var x = document.getElementsByClassName("tab");
		for (i = 0; i < x.length; i++) {
			x[i].style.display = "none";  
		}
		document.getElementById(tabName).style.display = "block";  
	}

	function ck_option2(){
		var ck = document.getElementById('option2');
		if(ck.clicked == true){
			document.getElementById('frm_option2').style.display = "";
		}else{
			document.getElementById('frm_option2').style.display = "none";
		}
	}

	function ck_option4(){
		var ck = document.getElementById('option4');
		if(ck.checked == true){
			document.getElementById('frm_option4').style.display = "";
		}else{
			document.getElementById('frm_option4').style.display = "none";
		}
	}

	function ck_option5(){
		var ck = document.getElementById('option5');
		if(ck.checked == true){
			document.getElementById('frm_option5').style.display = "";
		}else{
			document.getElementById('frm_option5').style.display = "none";
		}
	}

	function ck_type_document2(){
		var ck = document.getElementById('type_document2');
		if(ck.checked == true){
			document.getElementById('frm_type_document2').style.display = "";
		}else{
			document.getElementById('frm_type_document2').style.display = "none";
		}
	}

	function ck_frm(){
		var ck = document.getElementById('description_other');
		if(ck.checked == true){
			document.getElementById('frm_txt').style.display = "";
		}else{
			document.getElementById('frm_txt').style.display = "none";
		}
	}

	function ck_delivery(){
		var ck = document.getElementById('delivery');
		if(ck.checked == true){
			document.getElementById('frm_delivery').style.display = "";
		}else{
			document.getElementById('frm_delivery').style.display = "none";
		}
	}

	function ck_start_date(){
		var ck = document.getElementById('start_date');
		if(ck.checked == true){
			document.getElementById('frm_start_date').style.display = "";
		}else{
			document.getElementById('frm_start_date').style.display = "none";
		}
	}

	function ck_between_date(){
		var ck = document.getElementById('between_date');
		if(ck.checked == true){
			document.getElementById('frm_between_date').style.display = "";
		}else{
			document.getElementById('frm_between_date').style.display = "none";
		}
	}

	// Select checkboxes used to control/toggle disable of target checkboxes
	function object() {
		if (document.getElementById('object1').checked) {
			document.getElementById('dt1').style.display = 'block';
			document.getElementById('dt2').style.display = 'none';
			document.getElementById('dt4').style.display = 'none';
			document.getElementById('dt5').style.display = 'none';
		}
		else if (document.getElementById('object2').checked) {
			document.getElementById('dt1').style.display = 'none';
			document.getElementById('dt2').style.display = 'block';
			document.getElementById('dt4').style.display = 'none';
			document.getElementById('dt5').style.display = 'none';
		}
		else if (document.getElementById('object3').checked) {
			document.getElementById('dt1').style.display = 'none';
			document.getElementById('dt2').style.display = 'none';
			document.getElementById('dt4').style.display = 'none';
			document.getElementById('dt5').style.display = 'none';
		}
		else if (document.getElementById('object4').checked) {
			document.getElementById('dt1').style.display = 'none';
			document.getElementById('dt2').style.display = 'none';
			document.getElementById('dt4').style.display = 'block';
			document.getElementById('dt5').style.display = 'none';
		}
		else if (document.getElementById('object5').checked) {
			document.getElementById('dt1').style.display = 'none';
			document.getElementById('dt2').style.display = 'none';
			document.getElementById('dt4').style.display = 'none';
			document.getElementById('dt5').style.display = 'block';
		}
	}

	function openmaps() {
		if (document.getElementById('mapsn').checked) {
			document.getElementById('ityes').style.display = 'block';
		}
		else {
			document.getElementById('ityes').style.display = 'none';
		}
	}
    $(function () {
        // NAME AUTO-COMPLETE
        $('#customer-name').autocomplete({
          source: function (request, response) {
            $.ajax({
              type: "POST",
              url: "adsearch.php",
              data: {
                term: request.term,
                type: "customer_name"
              },
              success: response,
              dataType: 'json',
              minLength: 2,
              delay: 100
            });
          }
        });

        // EMAIL AUTO-COMPLETE
        $('#addreaa').autocomplete({
          source: function (request, response) {
            $.ajax({
              type: "POST",
              url: "adsearch.php",
              data: {
                term: request.term,
                type: "address"
              },
              success: response,
              dataType: 'json',
              minLength: 2,
              delay: 100
            });
          }
        });
      });

</script>
<style>
	.none {
    display:none;
	}
</style>
<?php
	include("dbconnect.php");
	$ref_id=$_GET["ref_id"];
	$br="select * from hos__br where ref_id='$ref_id'";
	$qbr=mysqli_query($conn,$br);
	$fbr=mysqli_fetch_array($qbr,MYSQLI_ASSOC);
?>
<div class="w3-container">
	<div class="w3-panel w3-light-grey"><h3>Admin Borrow Order</h3></div>
	<form action="admin_br_hos1.php" method="post" name="frmMain" enctype="multipart/form-data">
	<div class="w3-bar">
		<?php if($fbr["company"]==1) { ?>
			<input type="radio" name="company" value="1" checked='checked'> Phartrillion
			<input type="radio" name="company" value="2"> Noble Med
		<?php } else if($fbr["company"]==2) { ?>
			<input type="radio" name="company" value="1"> Phartrillion
			<input type="radio" name="company" value="2" checked='checked'> Noble Med
		<?php } ?>
		<span class="w3-light-grey w3-right"> เลขที่อ้างอิง : <?php echo $fbr['ref_id']; ?></span>
		<input type="hidden" name="ref_id" class="w3-input" value="<?php echo $fbr['ref_id']; ?>">
		<input type="hidden" name="main_id" class="w3-input" value="<?php echo $fbr['main_id']; ?>">
		<input type="hidden" name="id" class="w3-input" value="<?php echo $fbr['id']; ?>">
	</div>
	
	<div class="w3-bar w3-padding-small"></div><!-- bar -->
	<div class="w3-half 1">
		<div class="w3-bar w3-margin-bottom">
			<span>ชื่อลูกค้า/รพ.</span> <input type="text" name="customer" id="customer" class="w3-input" style="width:90%;" OnChange="JavaScript:doCallAjax('customer','address');" value="<?php echo $fbr["customer"]; ?>">
			<input type ='hidden' name="h_customer"  id="h_customer" class="w3-input" >

		</div>
		<div class="w3-bar w3-margin-bottom">
			<span>ที่อยู่</span> <textarea name="address" id="address" class="w3-input" style="width:90%;" rows="1"><?php echo $fbr["address"]; ?></textarea>
		</div>
		<div class="w3-bar w3-margin-bottom">
			<span>สถานที่ส่งสินค้า</span> <textarea name="delivery_place" class="w3-input" style="width:90%;" rows="1"><?php echo $fbr["delivery_place"]; ?></textarea>
		</div>
		<div class="w3-bar w3-margin-bottom">
			<span>ชื่อผู้ติดต่อ/โทร.</span> <input type="text" name="delivery_contact" class="w3-input" style="width:90%;" value="<?php echo $fbr["delivery_contact"]; ?>">
		</div>
	</div>
	<div class="w3-half 2">
		<div class="w3-bar w3-half w3-margin-bottom">
			<span>วันที่</span> <input type="text" name="date" class="w3-input" style="width:90%;" value="<?php echo $fbr["date"]; ?>">
		</div>
		<div class="w3-bar w3-half w3-margin-bottom">
			<span>เลขที่ BRNP</span> <input type="text" name="brnp_no" class="w3-input" style="width:90%;">
		</div>
		<div class="w3-bar w3-margin-bottom w3-half">
			<span>วัตถุประสงค์การเบิก</span>
			<?php if($fbr["objective"]==1) { ?>
			<div class="w3-panel"><input type="radio" onclick="javascript:object();" name="objective" value="1" id="object1" checked="checked"> เป็นสินค้าสำรอง
				<div id="dt1">
					<input type="text" name="objective_des1" class="w3-input" style="width:90%;" value="<?php echo $fbr["objective_des1"]; ?>">
				</div>
			</div>
			<div class="w3-panel"><input type="radio" onclick="javascript:object();" name="objective" value="2" id="object2"> สำหรับลูกค้าทดลองใช้
				<div id="dt2" style="display:none">
					<input type="text" name="objective_des2" class="w3-input" placeholder="ใส่จำนวนวัน" style="width:90%;">
				</div>
			</div>
			<div class="w3-panel"><input type="radio" onclick="javascript:object();" name="objective" value="3" id="object3"> ส่งสินค้าล่วงหน้าเพื่อรอใบสั่งซื้อ
			</div>
			<div class="w3-panel"><input type="radio" onclick="javascript:object();" name="objective" value="4" id="object4"> แลกเปลี่ยนสินค้าตามใบงานบริการเลขที่
				<div id="dt4" style="display:none">
					<input type="text" name="objective_des4" class="w3-input" placeholder="ใส่เลขที่ใบงานบริการ" style="width:90%;">
				</div>
			</div>
			<div class="w3-panel"><input type="radio" onclick="javascript:object();" name="objective" value="5" id="object5"> อื่น ๆ
				<div id="dt5" style="display:none">
					<input type="text" name="objective_des5" class="w3-input" placeholder="ใส่รายละเอียดเพิ่มเติม" style="width:90%;">
				</div>
			</div><?php } ?>
			<?php if($fbr["objective"]==2) { ?>
			<div class="w3-panel"><input type="radio" onclick="javascript:object();" name="objective" value="1" id="object1" > เป็นสินค้าสำรอง
				<div id="dt1" style="display:none">
					<input type="text" name="objective_des1" class="w3-input" style="width:90%;" placeholder="ใส่รายละเอียด">
				</div>
			</div>
			<div class="w3-panel"><input type="radio" onclick="javascript:object();" name="objective" value="2" id="object2" checked="checked"> สำหรับลูกค้าทดลองใช้
				<div id="dt2">
					<input type="text" name="objective_des2" class="w3-input" style="width:90%;" value="<?php echo $fbr["objective_des2"]; ?>">
				</div>
			</div>
			<div class="w3-panel"><input type="radio" onclick="javascript:object();" name="objective" value="3" id="object3"> ส่งสินค้าล่วงหน้าเพื่อรอใบสั่งซื้อ
			</div>
			<div class="w3-panel"><input type="radio" onclick="javascript:object();" name="objective" value="4" id="object4"> แลกเปลี่ยนสินค้าตามใบงานบริการเลขที่
				<div id="dt4" style="display:none">
					<input type="text" name="objective_des4" class="w3-input" placeholder="ใส่เลขที่ใบงานบริการ" style="width:90%;">
				</div>
			</div>
			<div class="w3-panel"><input type="radio" onclick="javascript:object();" name="objective" value="5" id="object5"> อื่น ๆ
				<div id="dt5" style="display:none">
					<input type="text" name="objective_des5" class="w3-input" placeholder="ใส่รายละเอียดเพิ่มเติม" style="width:90%;">
				</div>
			</div><?php } ?>
			<?php if($fbr["objective"]==3) { ?>
			<div class="w3-panel"><input type="radio" onclick="javascript:object();" name="objective" value="1" id="object1" checked="checked"> เป็นสินค้าสำรอง
				<div id="dt1" style="display:none">
					<input type="text" name="objective_des1" class="w3-input" style="width:90%;" placeholder="ใส่รายละเอียด">
				</div>
			</div>
			<div class="w3-panel"><input type="radio" onclick="javascript:object();" name="objective" value="2" id="object2"> สำหรับลูกค้าทดลองใช้
				<div id="dt2" style="display:none">
					<input type="text" name="objective_des2" class="w3-input" placeholder="ใส่จำนวนวัน" style="width:90%;">
				</div>
			</div>
			<div class="w3-panel"><input type="radio" onclick="javascript:object();" name="objective" value="3" id="object3" checked="checked"> ส่งสินค้าล่วงหน้าเพื่อรอใบสั่งซื้อ
			</div>
			<div class="w3-panel"><input type="radio" onclick="javascript:object();" name="objective" value="4" id="object4"> แลกเปลี่ยนสินค้าตามใบงานบริการเลขที่
				<div id="dt4" style="display:none">
					<input type="text" name="objective_des4" class="w3-input" placeholder="ใส่เลขที่ใบงานบริการ" style="width:90%;">
				</div>
			</div>
			<div class="w3-panel"><input type="radio" onclick="javascript:object();" name="objective" value="5" id="object5"> อื่น ๆ
				<div id="dt5" style="display:none">
					<input type="text" name="objective_des5" class="w3-input" placeholder="ใส่รายละเอียดเพิ่มเติม" style="width:90%;">
				</div>
			</div><?php } ?>
			<?php if($fbr["objective"]==4) { ?>
			<div class="w3-panel"><input type="radio" onclick="javascript:object();" name="objective" value="1" id="object1" checked="checked"> เป็นสินค้าสำรอง
				<div id="dt1" style="display:none">
					<input type="text" name="objective_des1" class="w3-input" style="width:90%;" placeholder="ใส่รายละเอียด">
				</div>
			</div>
			<div class="w3-panel"><input type="radio" onclick="javascript:object();" name="objective" value="2" id="object2"> สำหรับลูกค้าทดลองใช้
				<div id="dt2" style="display:none">
					<input type="text" name="objective_des2" class="w3-input" placeholder="ใส่จำนวนวัน" style="width:90%;">
				</div>
			</div>
			<div class="w3-panel"><input type="radio" onclick="javascript:object();" name="objective" value="3" id="object3"> ส่งสินค้าล่วงหน้าเพื่อรอใบสั่งซื้อ
			</div>
			<div class="w3-panel"><input type="radio" onclick="javascript:object();" name="objective" value="4" id="object4" checked="checked"> แลกเปลี่ยนสินค้าตามใบงานบริการเลขที่
				<div id="dt4">
					<input type="text" name="objective_des4" class="w3-input" style="width:90%;" value="<?php echo $fbr["objective_des4"]; ?>">
				</div>
			</div>
			<div class="w3-panel"><input type="radio" onclick="javascript:object();" name="objective" value="5" id="object5"> อื่น ๆ
				<div id="dt5" style="display:none">
					<input type="text" name="objective_des5" class="w3-input" placeholder="ใส่รายละเอียดเพิ่มเติม" style="width:90%;">
				</div>
			</div><?php } ?>
			<?php if($fbr["objective"]==5) { ?>
			<div class="w3-panel"><input type="radio" onclick="javascript:object();" name="objective" value="1" id="object1" checked="checked"> เป็นสินค้าสำรอง
				<div id="dt1" style="display:none">
					<input type="text" name="objective_des1" class="w3-input" style="width:90%;" placeholder="ใส่รายละเอียด">
				</div>
			</div>
			<div class="w3-panel"><input type="radio" onclick="javascript:object();" name="objective" value="2" id="object2"> สำหรับลูกค้าทดลองใช้
				<div id="dt2" style="display:none">
					<input type="text" name="objective_des2" class="w3-input" placeholder="ใส่จำนวนวัน" style="width:90%;">
				</div>
			</div>
			<div class="w3-panel"><input type="radio" onclick="javascript:object();" name="objective" value="3" id="object3"> ส่งสินค้าล่วงหน้าเพื่อรอใบสั่งซื้อ
			</div>
			<div class="w3-panel"><input type="radio" onclick="javascript:object();" name="objective" value="4" id="object4"> แลกเปลี่ยนสินค้าตามใบงานบริการเลขที่
				<div id="dt4" style="display:none">
					<input type="text" name="objective_des4" class="w3-input" placeholder="ใส่เลขที่ใบงานบริการ" style="width:90%;">
				</div>
			</div>
			<div class="w3-panel"><input type="radio" onclick="javascript:object();" name="objective" value="5" id="object5" checked="checked"> อื่น ๆ
				<div id="dt5">
					<input type="text" name="objective_des5" class="w3-input" placeholder="ใส่รายละเอียดเพิ่มเติม" style="width:90%;" value="<?php echo $fbr["objective_des5"]; ?>">
				</div>
			</div><?php } ?>
		</div>
		<div class="w3-bar w3-half">
			<span>BQ</span>
			<input type="text" name="bq" class="w3-input" style="width:90%" value="<?php echo $fbr["bq"]; ?>">
			<span>OT</span>
			<input type="text" name="ot" class="w3-input" style="width:90%" value="<?php echo $fbr["ot"]; ?>">
		</div>
	
	
	<div class="w3-bar">
		<div class="w3-half">
			<span>ผู้ขอ</span>
			<?php $sale=$fbr["sale"]; $sale=mysqli_query($conn,"select * from tb_user where em_id='$sale'"); $fsale=mysqli_fetch_array($sale); ?>
			<input type="text" name="employee_display" class="w3-input" style="width:90%;" value="<?php echo $fsale['name']; ?>&nbsp;<?php echo $fsale['surname']; ?>" readonly><input type="hidden" name="sale" class="w3-input" style="width:90%;" value="<?php echo $fsale['em_id']; ?>">
		</div>
		<div class="w3-half">
			<?php $ap=$fbr["approve"]; $approve=mysqli_query($conn,"select * from tb_user where em_id='$ap'"); $fap=mysqli_fetch_array($approve); ?>
				<span>ผู้อนุมัติ</span><input type="text" name="approve_display" class="w3-input" style="width:90%;" value="<?php echo $fap['name']; ?>&nbsp;<?php echo $fap['surname']; ?>" readonly><input type="hidden" name="approve" class="w3-input" style="width:90%;" value="<?php echo $fap['em_id']; ?>">
		</div>
	</div>
	</div>
	<div class="w3-bar w3-margin-bottom"></div>
	
	<div class="3 w3-margin-bottom w3-half">
		<div id="send">
			<div class="w3-half">
				<div class="w3-bar w3-margin-bottom"><span>การจัดส่งสินค้า</span></div>
				<?php if($fbr["delivery_choice"]==1) { ?>
					<div class="w3-bar"><input type="radio" name="delivery_choice" value="1" checked> บริษัทจัดส่ง</div>
					<div class="w3-bar"><input type="radio" name="delivery_choice" value="2"> Sale รับเอง</div>
					<div class="w3-bar"><input type="radio" name="delivery_choice" value="3"> Engineer รับเอง</div>
				<?php } else if($fbr["delivery_choice"]==2) { ?>
					<div class="w3-bar"><input type="radio" name="delivery_choice" value="1"> บริษัทจัดส่ง</div>
					<div class="w3-bar"><input type="radio" name="delivery_choice" value="2" checked> Sale รับเอง</div>
					<div class="w3-bar"><input type="radio" name="delivery_choice" value="3"> Engineer รับเอง</div>
				<?php } else if($fbr["delivery_choice"]==3) { ?>
					<div class="w3-bar"><input type="radio" name="delivery_choice" value="1"> บริษัทจัดส่ง</div>
					<div class="w3-bar"><input type="radio" name="delivery_choice" value="2"> Sale รับเอง</div>
					<div class="w3-bar"><input type="radio" name="delivery_choice" value="3" checked> Engineer รับเอง</div>
				<?php } ?>
				<br />
				<div class="w3-bar">วันที่ <input type="text" name="delivery_date" class="w3-input" style="width:90%;" value="<?php echo $fbr["delivery_date"]; ?> "></div>
				<div class="w3-bar w3-margin-bottom">เวลา <input type="text" name="delivery_time" class="w3-input" style="width:90%;" value="<?php echo $fbr["delivery_time"]; ?> "></div>
			</div>
			<div class="w3-half w3-margin-bottom">
				<div class="w3-bar w3-margin-bottom"><span><font color="FFFFFF">.</font></span></div>
				<?php if($fbr["map"]==0) { ?>
				<div class="w3-bar"><input type="checkbox" name="map" id="mapsn" value="1" onclick="javascript:openmaps();"> มีแผนที่ประกอบ</div>
					<div id="ityes" style="display:none">
						<input type="file" name="mapfile" class="w3-input" style="width:90%" accept="image/x-png,image/gif,image/jpeg" />
					</div>
				<?php } else if($fbr["map"]==1) { ?>
				<div class="w3-bar"><input type="checkbox" name="map" id="mapsn" value="1" onclick="javascript:openmaps();" checked> มีแผนที่ประกอบ</div>
					<div id="ityes">
						<a href="map/<?php echo $fbr["mapfile"]; ?>" target="_blank">คลิกเพื่อดูแผนที่</a>
					</div>
				<?php } ?>
				<?php if($fbr["call_before"]==0) { ?>
				<div class="w3-bar"><input type="checkbox" name="call_before" value="1"> โทรแจ้งลูกค้าก่อนไป</div>
				<?php } else if($fbr["call_before"]==1) { ?>
				<div class="w3-bar"><input type="checkbox" name="call_before" value="1" checked> โทรแจ้งลูกค้าก่อนไป</div>
				<?php } ?>
				<?php if($fbr["assign"]==0) { ?>
				<div class="w3-bar"><input type="checkbox" name="assign" value="1"> นัดวันและเวลาเรียบร้อยแล้ว</div>
				<?php } else if($fbr["assign"]==1) { ?>
				<div class="w3-bar"><input type="checkbox" name="assign" value="1" checked> นัดวันและเวลาเรียบร้อยแล้ว</div>
				<?php } ?>
				<br />
				<div class="w3-bar">หมายเหตุ <textarea name="sale_remark" class="w3-input" style="width:90%;"><?php echo $fbr["sale_comment"]; ?></textarea></div>
			</div>
		</div>
	</div>
	<div class="w3-half 4 w3-container w3-pale-red">
		<div id="return">
			<div class="w3-bar w3-margin-bottom"><span>การรับคืนสินค้า</span></div>
				<?php if($fbr["returns"]==0) { ?>
					<input type="checkbox" name="returns" value="1"> <span>รับคืนสินค้า</span>
				<?php } else if($fbr["returns"]==1) { ?>
					<input type="checkbox" name="returns" value="1" checked> <span>รับคืนสินค้า</span>
				<?php } ?>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom">
				วันที่รับคืน
				<input type="text" name="returns_date" class="w3-input" style="width:90%;" value="<?php echo $fbr["returns_date"]; ?>">
			</div>
			<div class="w3-bar w3-half w3-margin-bottom">
				<span>ชื่อผู้ติดต่อ/เบอร์โทร</span> <input type="text" name="returns_contact" class="w3-input" style="width:90%;" value="<?php echo $fbr["returns_contact"]; ?>">
			</div>
			<div class="w3-bar w3-margin-bottom">
				<span>Ward/ตึก/ชั้น</span> <textarea name="returns_address" class="w3-input" style="width:95%;"><?php echo $fbr["returns_address"]; ?></textarea>
			</div>
			
		</div>
	<div class="w3-bar w3-margin-bottom">
		<?php include ('pd_br_hos.php'); ?>
	</div>
	<div class="w3-bar w3-center">
			<input type="submit" name="submit" class="w3-button w3-teal be-border" value="บันทึกข้อมูล">
	</div>
	</div>
	</form>
</div>
<?php include('foot.php'); ?>
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
		return "data_customer_popup1.php?customer_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("customer","h_customer");
</script>
<script>
$('form').jAutoCalc({
  attribute: 'jAutoCalc',
  thousandOpts: [',', '.', ' '],
  decimalOpts: ['.', ','],
  decimalPlaces: -1,
  initFire: true,
  chainFire: true,
  keyEventsFire: false,
  readOnlyResults: true,
  showParseError: true,
  emptyAsZero: false,
  smartIntegers: false,
  onShowResult: null,
  funcs: {},
  vars: {}
});
</script>