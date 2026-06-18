<?php include('head.php'); ?>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

<link rel="stylesheet" href="css/autocomplete.css"  type="text/css"/>
<script type="text/javascript" src="js/autocomplete.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>






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


	
function ckk_2() {
		if (document.getElementById('object8').checked) {
			document.getElementById('dv1').style.display = 'block';
			document.getElementById('dv2').style.display = 'none';
		}
		else if (document.getElementById('object9').checked) {
			document.getElementById('dv1').style.display = 'block';
			document.getElementById('dv2').style.display = 'none';
		}
		else if (document.getElementById('object10').checked) {
			document.getElementById('dv1').style.display = 'block';
			document.getElementById('dv2').style.display = 'none';
		}
			else if (document.getElementById('object11').checked) {
			document.getElementById('dv1').style.display = 'none';
			document.getElementById('dv2').style.display = 'block';
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

<div class="w3-white w3-container">
	<div class="w3-panel w3-light-grey"><h3>Register Data</h3></div>
	<form action="register_allwell_br1.php" method="post" name="frmMain" enctype="multipart/form-data">
	<div class="w3-bar">
		
		<input type="radio" name="select_type_doc" value="2" checked='checked' required> ใบยืม NBM
		</p>
		<input type="checkbox" name="send_stock" value="1" > ส่งใบยืมไปให้ Stock
		<?php

			$qfirst = "select * from so__main ORDER BY main_id DESC LIMIT 1";
			$first = mysqli_query($conn,$qfirst);
			$ffirst = mysqli_fetch_array($first);
		?>
		<span class="w3-light-grey w3-right"> เลขที่อ้างอิง : <?php echo $ffirst['ref_id']+1; ?></span>
		<input type="hidden" name="ref_id" class="w3-input" value="<?php echo $ffirst['ref_id']+1; ?>">
		<input type="hidden" name="main_id" class="w3-input" value="<?php echo $ffirst['main_id']+1; ?>">
	</div>
	
	<div class="w3-bar w3-padding-small"></div><!-- bar -->
	<div class="w3-half 1">
		<div class="w3-bar w3-margin-bottom">
			<span>ชื่อลูกค้า/รพ.</span> <input type="text" name="customer_name" id="customer_name" class="w3-input" style="width:90%;"  required>
			<input type ='hidden' name="h_customer"  id="h_customer" class="w3-input" >

		</div>
		<div class="w3-bar w3-margin-bottom">
			<span>ที่อยู่</span> <textarea name="address1" id="address1" class="w3-input" style="width:90%;" rows="1"></textarea>
		</div>
		<div class="w3-bar w3-margin-bottom">
			<span>สถานที่ส่งสินค้า</span> <textarea name="delivery_place" class="w3-input" style="width:90%;" rows="1" required></textarea>
		</div>
		<div class="w3-bar w3-margin-bottom">
			<span>ชื่อผู้ติดต่อ/โทร.</span> <input type="text" name="delivery_contact" class="w3-input" style="width:90%;" required>
			<input name="add_by" value="<?php echo $_SESSION['name']; ?>&nbsp;<?php echo $_SESSION['surname']; ?>" type='hidden' class="w3-input" >

		</div>
		<div class="w3-bar w3-margin-bottom">
				การจัดส่ง

				<select name="delivery" class="w3-input"  style="width:90%;" required>
					<option value="">**Please Select Item**</option>
					<?php
							$sqldeli = "SELECT tb_delivery.*,tb_sender.* FROM tb_delivery LEFT JOIN tb_sender ON tb_delivery.employee_send=tb_sender.sender_ID";
							$querydeli = mysqli_query($conn,$sqldeli);
							if (!$querydeli) {
								echo "Failed to fetch to MySQL: " . mysqli_error();
							}
							while ($fetchdeli = mysqli_fetch_array($querydeli,MYSQLI_ASSOC)) {
							?>
									<option class="w3-bar-item w3-button" value="<?php echo $fetchdeli['delivery_id'];?>"><?php echo $fetchdeli["delivery_name"]; ?><?php echo $fetchdeli["time_delivery"]; ?></option>
							<?php } ?>
				</select></div>
		<div class="w3-bar w3-margin-bottom">
		ช่องทางการขาย
<select name="sale_channel" id="sale_channel" class="w3-select" onchange="showUser(this.value)" style="width:90%;" OnChange="resutName(this.value);" required>
<option  value="">**โปรดเลือกช่องทางการขาย**</option>
<?php
$sqlchannel = "select * from tb_salechannel order by salechannel_ID";
$querychannel = mysqli_query($conn,$sqlchannel);
while ($fetchchannel = mysqli_fetch_array($querychannel,MYSQLI_ASSOC)) { ?>
<option class="w3-bar-item w3-button" value="<?php echo $fetchchannel['salechannel_ID']; ?>"><?php echo $fetchchannel['salechannel_nameshort']; ?><?php echo $fetchchannel['description_chanel']; ?></option>
<?php } ?>
</select>
		</div>
		<div class="w3-bar w3-margin-bottom">
		<span>ชื่อ </span>
		<span>พนักงาน</span>
<select  name="employee_name" class="w3-select"  style="width:90%;">
<option value="">**Please Select Item**</option>

<?php
$emp = "select * from tb_employee where department_id='1' order by employee_ID";
$sqlemp = mysqli_query($conn,$emp);
while ($fetchemp = mysqli_fetch_array($sqlemp,MYSQLI_ASSOC)) { ?>
<option class="w3-bar-item w3-button" value="<?php echo $fetchemp['employee_name']; ?>"><?php echo $fetchemp['employee_name']; ?></option>
<?php } ?>
</select>

		</div>
	</div>
	<div class="w3-half 2">
		<div class="w3-bar w3-half w3-margin-bottom">
			<span>วันที่</span> <input type="date" name="register_date " class="w3-input" style="width:90%;" required>
				กำหนดส่งตามสัญญา:
<input name="delivery_contract" class="w3-input" >
<input type="checkbox" name="clear_book_ckk" value="1">&nbsp; เคลียร์ใบจอง:
<input name="clear_book_no" class="w3-input" placeholder="เลขที่" >
<input type="checkbox" name="clear_brn_no_ckk" value="1">&nbsp;เคลียร์ใบยืม BRN:
<input name="clear_brn_no" class="w3-input" placeholder="เลขที่" >
<input type="checkbox" name="clear_brnp_no_ckk" value="1">&nbsp;เคลียร์ใบยืม BRNP:
<input name="clear_brnp_no" class="w3-input" placeholder="เลขที่" >
		<input type="checkbox" name="sn_ckk" value="1">&nbsp;ต้องการ SN:
<input name="sn" class="w3-input" >
		</div>
		
		<div class="w3-bar w3-margin-bottom w3-half">
		
<input type="checkbox" name="bq_ckk" value="1">&nbsp;BQ เลขที่:
<input name="bq" class="w3-input" >
<input type="checkbox" name="ot_ckk" value="1">&nbsp;OT เลขที่:
<input name="ot" class="w3-input" >

			<span>วัตถุประสงค์การเบิก</span>
			<div class="w3-panel"><input type="radio" onclick="javascript:object();" name="objective" value="1" id="object1" required> เป็นสินค้าสำรอง
				<div id="dt1" style="display:none">
					<input type="text" name="objective_des" class="w3-input" placeholder="ใส่รายละเอียด" style="width:90%;">
				</div>
			</div>
			<div class="w3-panel"><input type="radio" onclick="javascript:object();" name="objective" value="2" id="object2" required> สำหรับลูกค้าทดลองใช้
				<div id="dt2" style="display:none">
					<input type="text" name="objective_des" class="w3-input" placeholder="ใส่จำนวนวัน" style="width:90%;">
				</div>
			</div>
			<div class="w3-panel"><input type="radio" onclick="javascript:object();" name="objective" value="3" id="object3" required> ส่งสินค้าล่วงหน้าเพื่อรอใบสั่งซื้อ
			</div>
			<div class="w3-panel"><input type="radio" onclick="javascript:object();" name="objective" value="4" id="object4" required> แลกเปลี่ยนสินค้าตามใบงานบริการเลขที่
				<div id="dt4" style="display:none">
					<input type="text" name="objective_des" class="w3-input" placeholder="ใส่เลขที่ใบงานบริการ" style="width:90%;">
				</div>
			</div>
			<div class="w3-panel"><input type="radio" onclick="javascript:object();" name="objective" value="6" required> สินค้าฝากขาย (มีใบรับประกัน)
			</div>
			<div class="w3-panel"><input type="radio" onclick="javascript:object();" name="objective" value="7" id="object6" required> สินค้าออกบูธ</div>


			<div class="w3-panel"><input type="radio" onclick="javascript:object();" name="objective" value="5" id="object5" required> อื่น ๆ
				<div id="dt5" style="display:none">
					<input type="text" name="objective_des" class="w3-input" placeholder="ใส่รายละเอียดเพิ่มเติม" style="width:90%;">
				</div>
			</div>
		</div>
		<?php /*<div class="w3-bar w3-half">
		
		</div>
	
	
	<div class="w3-bar">
		<div class="w3-half">
			<span>ผู้ขอ</span><input type="text" name="employee_display" class="w3-input" style="width:90%;" value="<?php echo $_SESSION['name']; ?>&nbsp;<?php echo $_SESSION['surname']; ?>" readonly><input type="hidden" name="sale" class="w3-input" style="width:90%;" value="<?php echo $_SESSION['emid']; ?>">
		</div>
		<div class="w3-half">
			<?php if($_SESSION['code']=="ss1") {?>
				<span>ผู้อนุมัติ</span><input type="text" name="approve_display" class="w3-input" style="width:90%;" value="<?php echo $_SESSION['name']; ?>&nbsp;<?php echo $_SESSION['surname']; ?>" readonly><input type="hidden" name="approve" class="w3-input" style="width:90%;" value="<?php echo $_SESSION['emid']; ?>">
			<?php } ?>
			<?php if($_SESSION['code']=="ss2") {?>
				<span>ผู้อนุมัติ</span><input type="text" name="approve_display" class="w3-input" style="width:90%;" value="<?php echo $_SESSION['name']; ?>&nbsp;<?php echo $_SESSION['surname']; ?>" readonly><input type="hidden" name="approve" class="w3-input" style="width:90%;" value="<?php echo $_SESSION['emid']; ?>">
			<?php } ?>
			<?php if($_SESSION['code']=="ss3") {?>
				<span>ผู้อนุมัติ</span><input type="text" name="approve_display" class="w3-input" style="width:90%;" value="<?php echo $_SESSION['name']; ?>&nbsp;<?php echo $_SESSION['surname']; ?>" readonly><input type="hidden" name="approve" class="w3-input" style="width:90%;" value="<?php echo $_SESSION['emid']; ?>">
			<?php } ?>
			<?php if($_SESSION['code']=="") {?>
				<span>ผู้อนุมัติ</span><input type="text" name="approve_display" class="w3-input" style="width:90%;" value="<?php echo $_SESSION['name']; ?>&nbsp;<?php echo $_SESSION['surname']; ?>" readonly><input type="hidden" name="approve" class="w3-input" style="width:90%;" value="<?php echo $_SESSION['emid']; ?>">
			<?php }
			else { ?>
				<span>ผู้อนุมัติ</span><input type="text" name="approve_display" class="w3-input" style="width:90%;" value="" readonly><input type="hidden" name="approve" class="w3-input" style="width:90%;" value="">
			<?php } ?>
		</div>
	</div>*/ ?>
	</div>
	</p>
	<div class="w3-bar w3-light-grey w3-border">
 <a class="w3-bar-item w3-button" onclick="openCity1('pd')"><font color="#404040"><b>รายการสินค้า</b></font></a>
 <a class="w3-bar-item w3-button" onclick="openCity1('cs')"><font color="#404040"><b>รายละเอียดการจัดส่ง</b></font></a>
    <a class="w3-bar-item w3-button" onclick="openCity1('rt')"><font color="#404040"><b>การรับสินค้า</b></font></a>

</div>
<div id="rt" class="w3-container city1" style="display:none">
<div class="w3-bar w3-margin-bottom"></div>
	<div class="w3-half 4 w3-container w3-pale-red">
		<div id="return">
			
				<input type="checkbox" name="returns" value="1"> <span>รับคืนสินค้า</span>
			</div>
			<div class="w3-bar w3-half w3-margi-bottom">
				วันที่รับคืน
				<input type="date" name="return_date" class="w3-input" style="width:90%;">
			</div>
			<div class="w3-bar w3-half w3-margi-bottom">
				เวลารับคืน
				<input type="text" name="return_time" class="w3-input" style="width:90%;">
			</div>
			<div class="w3-bar w3-half w3-margin-bottom">
				<span>ชื่อผู้ติดต่อ/เบอร์โทร</span> <input type="text" name="return_contact" class="w3-input" style="width:90%;">
			</div>
			<div class="w3-bar w3-margin-bottom">
				<span>Ward/ตึก/ชั้น</span> <textarea name="return_address" class="w3-input" style="width:95%;"></textarea>
			</div>
			
		</div>

</div>

<div id="pd" class="w3-container city1">
<?php include ('register_allwell_detailnb.php')?>
</div>

<div id="cs" class="w3-container city1" style="display:none">
<input type="radio" name="delivery_type" value="1" onclick="javascript:ckk_2();" id="object8">&nbsp;Sale รับเอง
<input type="radio" name="delivery_type" value="2"  onclick="javascript:ckk_2();" id="object9">&nbsp;ช่างรับเอง<br />
<input type="radio" name="delivery_type" value="3"  onclick="javascript:ckk_2();" id="object10">&nbsp;ลูกค้ารับเอง 
<input type="radio" name="delivery_type" value="4"  onclick="javascript:ckk_2();" id="object11">&nbsp;บริษัทจัดส่ง <br />

</p>
<div id="dv1" style="display:none">
<div class="w3-quarter w3-container"><!-- first quarter -->


วันที่ส่ง
<input type="date" name="delivery_date" class="w3-input">
เวลาส่ง
<input type="text" name="delivery_time" class="w3-input">
การส่งสินค้า<br>
<input type="checkbox" name="big_car" value="1">&nbsp;ต้องการรถใหญ่<br />
<input type="checkbox" name="call_before" value="1">&nbsp;โทรแจ้งลูกค้าก่อนไป<br />
<input type="checkbox" name="maps" value="1">&nbsp;มีแผนที่ประกอบ</p>


  <input name="upload_map"  type="file"></p>


<input type="checkbox" name="assign_date_time" value="1">&nbsp;นัดวันเวลาเรียบร้อยแล้ว<br />
</div><!-- first quarter -->
<div class="w3-quarter w3-container"><!-- second quarter -->

สถานที่ส่งสินค้า:
<textarea name="delivery_place" class="w3-input" rows="1" style="width:100%;resize: none" ></textarea>
ชื่อผู้ติดต่อ/TEL.:
<input type="text" name="delivery_contact" class="w3-input" >
</div><!-- second quarter -->
<div class="w3-quarter w3-container"><!-- third quarter -->
<input type="checkbox" name="return" value="1">&nbsp;รับคืนสินค้า<br>
วันที่รับคืน
<input type="date" name="return_date" class="w3-input" >
เวลา
<input type="text" name="return_time" class="w3-input" >
ที่อยู่รับคืนสินค้า:
<input type="text" name="return_address" class="w3-input" >
ชื่อผู้ติดต่อ/TEL.:
<input type="text" name="return_contact" class="w3-input" >
</div><!-- third quarter --><!-- forth quarter -->
<div class="w3-quarter w3-container">

<div id="dt1" style="display:none">
					
<input type="checkbox"  checked="checked" value="1">&nbsp;

<a href="report_loanptl.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey"><font color="Blue">ใบยืม AWL</font></a>&nbsp;&nbsp;
</div>

<div id="dt2" style="display:none">
<input type="checkbox" name="select_br_nbm" checked="checked" value="1">&nbsp;
					

<a  href="report_loannbm.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey"><font color="DeepPink"> ใบยืม NBM</font></a>&nbsp;

</div>

<div id="dt3" style="display:none">

<input type="checkbox" name="select_so_ptl" checked="checked" value="1">&nbsp;
		
<a href="report_saleptl.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey"><font color="Blue">ใบสั่งขาย AWL</font></button></a><br />

</div>
		
	<div id="dt4" style="display:none">

		
<input type="checkbox" name="select_so_nbm" checked="checked" value="1">&nbsp;
				

<a href="report_salenbm.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey"><font color="DeepPink">ใบสั่งขาย NBM</font></a>
</div></div><!-- forth quarter -->
</div>


<div id="dv2" style="display:none">
	
	<div class="w3-quarter"><!-- first third-->
<input type="checkbox" name="" hidden><br \>
วันที่ส่ง
<input type="date" name="delivery_date"  class="w3-input" >
เวลาส่ง
<input type="text" name="delivery_time"  class="w3-input" >


</div><!-- first third-->
<div class="w3-quarter w3-container"><!-- second third-->

สถานที่ส่งสินค้า:
<textarea name="delivery_place" class="w3-input" cols="20" rows="2" style="width:100%;resize: none" ></textarea>
ชื่อผู้ติดต่อ/TEL.:
<input type="text" name="delivery_contact" class="w3-input" >
</div><!-- second third-->
<div class="w3-quarter"><!-- 3rd quarter-->

<input type="checkbox" name="return" value="1">รับคืนสินค้า<br>

วันที่รับคืน
<input type="date" name="return_date"   class="w3-input" >
เวลา
<input type="text" name="return_time"  class="w3-input" >
ที่อยู่รับคืนสินค้า:
<input type="text" name="return_address"  class="w3-input" >
ชื่อผู้ติดต่อ/TEL.:
<input type="text" name="return_contact"  class="w3-input" >
</div><!-- 3rd quarter-->



<div class="w3-container w3-third">
<input type="checkbox" name="send_cs" value="1">&nbsp;ส่งข้อมูลไประบบลงงาน 
	</div>
<div class="w3-container w3-third">
<input type="checkbox" name="mk_research" value="1">&nbsp; <span class="style34"><u>cs ทำแบบสอบถาม </u></span> 
	</div>
	<div class="w3-container w3-third">
.
	</div>
	<div class="w3-container w3-third">
 วันที่ รับ-ส่ง :
      <input name="start_date" type='date' id="start_date"   class="w3-input"  />

	</div><div class="w3-container w3-third">

วันที่ต้องการโดยประมาณ :
	  <input name="between_date"  class="w3-input"  type='text' id="between_date"  />
 </div><div class="w3-container w3-third">

 เวลา :
<input id="start_time"  name="start_time"  class="w3-input" type="text" />
ถึง
<input id="end_time" name="end_time"   class="w3-input" type="text" />

</div><div class="w3-container w3-third">


สถานะการทำงาน : 


<input type='radio'  name='status' id = 'status' value='ส่ง' />ส่ง
&nbsp; <input type='radio'  name='status' id = 'status' value='รับ' />รับ



</div><div class="w3-container w3-third">

สถานะ :
      <input name="status_comment" type='text' id="status_comment"  size="20" class="w3-input"/>
</div><div class="w3-container w3-third">


<input type="checkbox"  name="fix_datetime" id = "fix_datetime"  value="1">นัดวันและเวลาเรียบร้อยแล้ว 


<input type="checkbox"  id = "no_money" name="no_money" value="1">ไม่ต้องเก็บเงิน



</div><div class="w3-container w3-third">

<input type="checkbox"  id = "call_customer" name="call_customer" value="1">โทรแจ้งลูกค้าก่อนไป
	
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox"  id = "call_back" name="call_back" value="1">ต้องการให้โทรกลับเมื่อส่งสินค้าเสร็จแล้ว


</div><div class="w3-container w3-third">

	<input type="checkbox"   name="want_bus" value="1">ต้องการรถใหญ่


		</div><div class="w3-container w3-third">
	 
	<input type="checkbox"  name="cash"id = "cash"  value="1">เก็บเงินสด



		 <input name="unit_cash" type='text' class="w3-input" id="unit_cash"  size="20" rows="1" style="color:black;text-align:right" OnChange="JavaScript:chkNum(this)">  
		 </div><div class="w3-container w3-third">


	<input type="checkbox"  name="check_paper" id = "check_paper" value="1">รับเช็ค

		
	<input name="unit_check" type='text' class="w3-input"  id="unit_check" style="color:black;text-align:right" size="20" OnChange="JavaScript:chkNum(this)"/>
		</div><div class="w3-container w3-third">


<input type="checkbox"  id = "credit_card" name="credit_card" value="1">รูดการ์ด 



	<input name="unit_credit" type='text' class="w3-input"  id="unit_credit"  size="20" style="color:black;text-align:right"  OnChange="JavaScript:chkNum(this)"/> 
	</div><div class="w3-container w3-third">


<input type="checkbox"  id = "bill" name="bill" value="1">วางบิล

	
<input name="unit_bill" type='text' class="w3-input" style="color:black;text-align:right" id="unit_bill"  size="20" OnChange="JavaScript:chkNum(this)" />
</div><div class="w3-container w3-third">


<input type="checkbox"  name="tran"id = "tran"  value="1">ลูกค้าโอนเงินหน้างาน
	
		 <input name="unit_tran" type='text' class="w3-input" id="unit_tran" size="20"  style="color:black;text-align:right" rows="1"OnChange="JavaScript:chkNum(this)"> 
</div><div class="w3-container w3-third">


<input type="checkbox"  id = "dep" name="dep" value="1">อื่นๆ


	

<input name="dept" type='text' class="w3-input"  id="dept"  size="20"  />
</div><div class="w3-container w3-third">

แผนก - ฝ่าย :


<select name="department_show" id="department_show" class="w3-input"   >
<option  value="">**โปรดเลือกแผนก-ฝ่าย**</option>
<option  value="ฝ่ายการตลาด">ฝ่ายการตลาด</option>
<option  value="ฝ่ายขาย">ฝ่ายขาย</option>
<option  value="ฝ่ายสนับสนุนการขาย ธุรการ">ฝ่ายสนับสนุนการขาย ธุรการ</option>

</select>

</div><div class="w3-container w3-third">
       ประเภทลูกค้า :


<select name="customer_typename" id="customer_typename" class="w3-input"   >
<option  value="">**โปรดเลือกประเภทลูกค้า**</option>
<option  value="ร้านขายยา">ร้านขายยา</option>
<option  value="ลูกค้าทั่วไป">ลูกค้าทั่วไป</option>
<option  value="โรงพยาบาล">โรงพยาบาล</option>

</select>


</div><div class="w3-container w3-third">
       หน่วยงาน :

	 
<select name="company_name" id="company_name" class="w3-input"   >
<option  value="">**โปรดเลือกหน่วยงาน**</option>
<option  value="ฟาร์ ทริลเลี่ยน บจก.">ฟาร์ ทริลเลี่ยน บจก.</option>
<option  value="โนเบิล เมด บจก.">โนเบิล เมด บจก.</option>
<option  value="อื่นๆ">อื่นๆ</option>
</select>


</div><div class="w3-container w3-third">
       ประเภทงาน :
	 
<select name="department_name" id="department_name" class="w3-input"   >
<option  value="">**โปรดเลือกประเภทงาน**</option>
<option  value="Online">Online</option>
<option  value="Sale">Sale</option>

</select>

</div><div class="w3-container w3-third">
ชื่อผู้ติดต่อ  :
<input name="customer_name1"  class="w3-input" type='text' value="<?php echo $fetch1["customer_name"]; ?>" id="customer_name1">

</div><div class="w3-container w3-third">
 ผู้รับสินค้า :
<input name="customer_contact"  class="w3-input" type='text' id="customer_contact">

</div><div class="w3-container w3-third">

 เบอร์โทรลูกค้า :
<input name="customer_tel"  class="w3-input" type='text' id="customer_tel">

</div><div class="w3-container w3-third">
ชื่อโรงพยาบาล :
<input type='text'  class="w3-input"  name="address_name" >             


 </div>
<div class="w3-container w3-third">	

  ที่อยู่ :
<textarea   class="w3-input" name="address_send" cols="54" rows="1"></textarea>

</div>
<div class="w3-container w3-third">
เลขที่เอกสาร/เลขที่เครื่อง : 
<textarea name="product_sn"  class="w3-input" id="product_sn" cols="54" rows="1"></textarea>

</div>
<div class="w3-container w3-third">
สินค้า/เอกสาร :  
<textarea name="product"  class="w3-input" id="product" cols="54" rows="1"></textarea>

</div>

<div class="w3-container w3-third">
รายละเอียดเพิ่มเติม : 
     <textarea name="description"  class="w3-input" id="description" cols="54" rows="1"></textarea>
</div>


	<fieldset><legend><input type="checkbox" name="more" id="more" value="1"> <b>รายละเอียดการจัดส่ง</b></legend>
	<div id="more-2" style="display:none;">
		<div class="w3-third 112">
			<div class="w3-bar 1">
				<input type="checkbox" name="runway"id = "runway" value="1"> ติดถนนรันเวย์
			</div>
			<div class="w3-bar 2">
				<input type="checkbox" name="road"id = "road" value="1"> ติดถนนวิ่งสวนกัน
			</div>
			<div class="w3-bar 3">
				<input type="checkbox" name="soy"id = "soy" value="1"> เข้าซอย
			</div>
			<div class="w3-bar 4">
				ทางเข้ากว้าง
				<input name="soy_big" class="w3-input" type='text' id="soy_big" style="color:black;text-align:left;width:90%;" placeholder="(เมตร)" />
			</div>
			<div class="w3-bar 5">
				<input type="checkbox" name="height_ltd" id = "height_ltd" value="1"> มีตัวจำกัดความสูง
			</div>
			<div class="w3-bar 6">
				<input type="checkbox" name="car_load"id = "car_load" value="1"> รถยนต์สามารถเข้าได้
			</div>
			<div class="w3-bar 7">
				<input type="checkbox" name="no_car_road"id = "no_car_road" value="1"> รถยนต์เข้าไม่ได้ สามารถจอดได้ที่ <input name="car_park" class="w3-input" type='text' id="car_park" style="width:90%;" />
			</div>
			<div class="w3-bar 8">
				การจอดรถ
			</div>
			<div class="w3-bar 9">
				<input type="checkbox" name="car_road" id = "car_road" value="1"> จอดรถข้างถนน
			</div>
			<div class="w3-bar 10">
				<input type="checkbox" name="car_home"id = "car_home" value="1"> จอดรถหน้าบ้านได้
			</div>
			<div class="w3-bar 11">
				ประตูหน้าบ้านสูง
				<input name="door_long" class="w3-input" type='text' id="door_long" style="color:black;text-align:left;width:90%;" placeholder="(เมตร)" />
			</div>
			<div class="w3-bar 12">
				<input type="checkbox" name="slope"id = "slope" value="1"> มีทางราบก่อนประตูบ้าน
			</div>
			<div class="w3-bar 13">
				<input type="checkbox" name="bundai"id = "bundai" value="1"> มีบันไดก่อนประตูบ้าน
			</div>
			<div class="w3-bar 14">
				<input name="unit_bundai" class="w3-input" type='text' id="unit_bundai" style="width:90%;" placeholder="จำนวน (ขั้น)" />
			</div>
			<div class="w3-bar 15">
				ประตูบ้านกว้าง
				<input name="door_bigger" class="w3-input" type='text' id="door_bigger" style="width:90%;" placeholder="(เมตร)" />
			</div>
			<div class="w3-bar 16">
				ประตูสูง 
				<input name="door_longer" class="w3-input" type='text' id="door_longer" style="width:90%;" placeholder="(เมตร)" />
			</div>
			<div class="w3-bar 17">
				ประตูห้องกว้าง 
				<input name="room_bigger" class="w3-input" type='text' id="room_bigger" style="width:90%;" placeholder="(เมตร)" />
			</div>
			<div class="w3-bar 18">
				ประตูห้องสูง 
				<input name="room_longer" class="w3-input" type='text' id="room_longer" style="width:90%;" placeholder="(เมตร)" />
			</div>
		</div>
		<div class="w3-third 212">
			<div class="w3-bar 1">
				ประตูบ้านเป็นแบบ
				<input name="type_door" class="w3-input" type='text' id="type_door" style="width:90%;" />
			</div>
			<div class="w3-bar 2">
				พื้นบ้านเป็นแบบ
				<input name="home_type" class="w3-input" type='text' id="home_type" style="width:90%;" />
			</div>
			<div class="w3-bar 3">
				ติดตั้งที่ชั้น
				<input name="install" class="w3-input" type='text' id="install" style="width:90%;" />
			</div>
			<div class="w3-bar 4">
				<input type="checkbox" name="bundai_install"id ="bundai_install" value="1"> บันไดกว้าง
			</div>
			<div class="w3-bar 5">
				<input name="bundai_big" class="w3-input" type='text' id="bundai_big" style="width:90%;" placeholder="เมตร" />
			</div>
			<div class="w3-bar 6">
				หักมุมบันได
				<input name="bundai_hug" class="w3-input" type='text' id="bundai_hug" style="width:90%;" />
			</div>
			<div class="w3-bar 7">
				ชนิดของบันได
				<input name="type_bundai" class="w3-input" type='text' id="type_bundai" style="width:90%;" />
			</div>
			<div class="w3-bar 8">
				<input type="checkbox" name="lip"id = "lip" value="1"> ลิฟท์กว้าง
			</div>
			<div class="w3-bar 9">
				<input name="lip_big" class="w3-input" type='text' id="lip_big" style="width:90%;" placeholder="เมตร" />
			</div>
			<div class="w3-bar 10">
				สูง
				<input name="lip_long" class="w3-input" type='text' id="lip_long" style="width:90%;" placeholder="เมตร" />
			</div>
			<div class="w3-bar 11">
				รับน้ำหนักได้ 
				<input name="lip_weight" class="w3-input" type='text' id="lip_weight" style="width:90%;" />
			</div>
			
		</div>
		<div class="w3-third 312">
			<div class="w3-bar 12">
				<input type="checkbox" name="up"id ="up" value="1"> ขึ้นลิฟท์ได้
			</div>
			<div class="w3-bar 13">
				<input type="checkbox" name="no_up"id ="no_up" value="1"> ขึ้นลิฟท์ไม่ได้
			</div>
			<div class="w3-bar 14">
				<input type="checkbox" name="head_bad"id ="head_bad" value="1"> ต้องถอดหัวเตียง-ท้ายเตียง
			</div>
			<div class="w3-bar 15">
				<input type="checkbox" name="want_employee"id ="want_employee" value="1"> ต้องการเจ้าหน้าที่ย้ายเฟอร์นิเจอร์
			</div>
			<div class="w3-bar 16">
				จำนวนคนที่ใช้ 
				<input name="employee_unit" class="w3-input" type='text' id="employee_unit" style="width:90%;" />
			</div>
			<div class="w3-bar 17">
				ย้ายเฟอร์นิเจอร์ 
				<input name="ferniger_name" class="w3-input" type='text' id="ferniger_name" style="width:90%;" />
			</div>
			<div class="w3-bar 18">
				ย้ายไปที่ 
				<input name="ferniger_address" class="w3-input" type='text' id="ferniger_address" style="width:90%;" />
			</div>
			<div class="w3-bar">
				<input type="checkbox" name="want_ex"id = "want_ex" value="1"> ต้องเตรียมอุปกรณ์ไปถอดประกอบ
			</div>
			<div class="w3-bar">
				<input type="checkbox" name="want_credit"id = "want_credit" value="1"> ต้องเตรียมเครื่องรูดบัตร
			</div>
			<div class="w3-bar">
				ธนาคาร 
				<input name="bank" class="w3-input" type='text' id="bank" style="width:90%;" />
			</div>
			<div class="w3-bar">
				<input type="checkbox" name="want_prem"id ="want_prem" value="1"> ต้องการให้เตรียมฟรีมยืดไปซิวเก็บเตียงหรือที่นอนเก่า
			</div>
			<div class="w3-bar">
				รายละเอียดเพิ่มเติม
				<textarea name="description_ja" class="w3-input" id="description_ja" cols="54" rows="1" style="width:90%;"></textarea>
			</div>
		</div>
	</div>
	</fieldset>

</div>

</div><!-- cs -->


	<div class="w3-bar w3-center">
			<input type="submit" name="submit" class="w3-button w3-teal be-border" value="บันทึกข้อมูล">
	</div><br>
	</div>
	</form>
</div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>		




        </script>

		<script>
$('#more').click(function() {
  if($(this).is(":checked")){
   $("#more-2").show();
  }
  else{
   $("#more-2").hide();
  }
});
</script>