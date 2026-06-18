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
<?php
$strSQL = "SELECT *  FROM so__main  WHERE ref_id = '".$_GET["ref_id"]."' ";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);
?>

<div class="w3-white w3-container">
	<div class="w3-panel w3-light-grey">
		<div class="w3-half">
		<h3>Register Data</h3>
			</div><div class="w3-half">
		
<a href="report_brnpsol_awl.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-yellow w3-right"><font color="Blue">แบบฟอร์มใบยืม</font></a>&nbsp;&nbsp;
		
		
		<?php if ($objResult["job_id"]!=''){ ?>
		
<a href="https://cs.allwellcenter.com/7112018.php?running=<?php echo $objResult["job_id"];?>" target="_blank" class="w3-button w3-grey w3-right"><font color="Blue">รายละเอียดจัดส่ง</font></a>

<?php } ?>								

		<?php
		 if($objResult["approve_complete"]=='' or $objResult["approve_complete"]=='Request'){
		if($_SESSION['name']=='รุจิรา'){ 
		?>
<a href="sendadmin_edit.php?ref_id=<?php echo $objResult["ref_id"];?>&bill_vat=<?php echo $objResult["bill_vat"];?>" class="w3-button w3-grey w3-right"><font color="330066">ส่งข้อมูลให้ Admin</font></a>
		
	<?php } 
		}
		?>
		
	<?php if($objResult["approve_complete"]==''){  ?>
	<a href="sendsup_edit.php?ref_id=<?php echo $objResult["ref_id"];?>&select_type_doc=<?php echo $objResult["select_type_doc"]; ?>" class="w3-button w3-grey w3-right"><font color="red">ส่งข้อมูลให้ Sup</font></a>

		
	<?php 
												}
		?>
		</div>
	</div>
	
	<form action="register_allwell_bredit1.php" method="post" name="frmMain" enctype="multipart/form-data">
	<div class="w3-bar">
	<?php
		if ($objResult["select_type_doc"]=='1'){
?>
		<input type="radio" name="select_type_doc" value="1" checked='checked' required>ใบยืม AWL
		<input type="radio" name="select_type_doc" value="2" required> ใบยืม NBM
<?php }else if ($objResult["select_type_doc"]=='2'){ ?>

		<input type="radio" name="select_type_doc" value="1"  required>ใบยืม AWL
		<input type="radio" name="select_type_doc" value="2" checked='checked' required> ใบยืม NBM


		<?php
			
}
		?>
		
			</p>
		<?php
		if ($objResult["send_stock"]=='1'){
?>
		<input type="checkbox" name="send_stock" value="1" checked='checked' > ส่งใบยืมไปให้ Stock
		<?php }else{ ?>
				<input type="checkbox" name="send_stock" value="1"  > ส่งใบยืมไปให้ Stock
		<?php } ?>
		
		<span class="w3-light-grey w3-right"> เลขที่อ้างอิง : <?php echo $objResult['ref_id']; ?></span>
		<input type="hidden" name="ref_id" class="w3-input" value="<?php echo $objResult['ref_id']; ?>">
		<input type="hidden" name="main_id" class="w3-input" value="<?php echo $objResult['main_id']; ?>">
<input type="hidden" name='start_date'  class='w3-input' value="<?php echo $_GET["start_date"];?>" readonly/>
<input type="hidden" name='end_date'  class='w3-input' value="<?php echo $_GET["end_date"];?>" readonly/>


	</div>
	
	<div class="w3-bar w3-padding-small"></div><!-- bar -->
	<div class="w3-half 1">
		<div class="w3-bar w3-margin-bottom">
			<span>ชื่อลูกค้า/รพ.</span> <input type="text" name="customer_name" id="customer_name" value="<?php echo $objResult['customer_name']; ?>" class="w3-input" style="width:90%;"  required>
			<input type ='hidden' name="h_customer"  id="h_customer" class="w3-input" >
<input type ='hidden' name="job_id"  id="job_id" value="<?php echo $objResult['job_id']; ?>" class="w3-input" >
		</div>
		<div class="w3-bar w3-margin-bottom">
			<span>ที่อยู่</span> <textarea name="address1" id="address1" class="w3-input" style="width:90%;" rows="1"><?php echo $objResult['address1']; ?></textarea>
		</div>
		<div class="w3-bar w3-margin-bottom">
			<span>สถานที่ส่งสินค้า</span> <textarea name="delivery_place" class="w3-input" style="width:90%;" rows="1" required><?php echo $objResult['delivery_place']; ?></textarea>
		</div>
		<div class="w3-bar w3-margin-bottom">
			<span>ชื่อผู้ติดต่อ/โทร.</span> <input type="text" name="delivery_contact" value="<?php echo $objResult['delivery_contact']; ?>" class="w3-input" style="width:90%;" required>
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
								if($objResult["delivery"] == $fetchdeli["delivery_id"])
{
$sel = "selected";
}
else
{
$sel = "";
}
								
							?>
									<option class="w3-bar-item w3-button" value="<?php echo $fetchdeli['delivery_id'];?>"  <?php echo $sel;?>><?php echo $fetchdeli["delivery_name"]; ?><?php echo $fetchdeli["time_delivery"]; ?></option>
							<?php } ?>
				</select></div>
		
	<div class="w3-bar w3-margin-bottom">	
		ช่องทางการขาย
<select name="sale_channel" id="sale_channel" class="w3-select"   style="width:90%;" >
<option  value="">**โปรดเลือกช่องทางการขาย**</option>
<?php
$sqlchannel = "select * from tb_salechannel order by salechannel_ID";
$querychannel = mysqli_query($conn,$sqlchannel);
while ($fetchchannel = mysqli_fetch_array($querychannel,MYSQLI_ASSOC)) 
	{
if($objResult["sale_channel"] == $fetchchannel["salechannel_ID"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>
<option class="w3-bar-item w3-button" value="<?php echo $fetchchannel['salechannel_ID']; ?>" <?php echo $sel;?>><?php echo $fetchchannel['salechannel_nameshort']; ?>&nbsp;&nbsp;<?php echo $fetchchannel['description_chanel']; ?></option>
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
while ($fetchemp = mysqli_fetch_array($sqlemp,MYSQLI_ASSOC)) { 

if($objResult["employee_name"] == $fetchemp["employee_name"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>

<option class="w3-bar-item w3-button" value="<?php echo $fetchemp['employee_name']; ?>"<?php echo $sel;?>><?php echo $fetchemp['employee_name']; ?></option>
<?php } ?>
</select>

		</div>
	</div>
	<div class="w3-half 2">
		<div class="w3-bar w3-half w3-margin-bottom">
			<span>วันที่</span> <input type="date" name="register_date" value="<?php echo $objResult['register_date']; ?>"  class="w3-input" style="width:90%;" required>
				กำหนดส่งตามสัญญา:
<input name="delivery_contract" value="<?php echo $objResult['delivery_contract']; ?>" class="w3-input" >
<?php
if($objResult['clear_book_ckk']=='1'){
?>
<input type="checkbox" name="clear_book_ckk" checked ="checked" value="1">&nbsp; เคลียร์ใบจอง:
<?php }else{ ?>
<input type="checkbox" name="clear_book_ckk" value="1">&nbsp; เคลียร์ใบจอง:

	<?php } ?>

<input name="clear_book_no"  value="<?php echo $objResult['clear_book_no']; ?>" class="w3-input" placeholder="เลขที่" >
<?php
if($objResult['clear_brn_no_ckk']=='1'){
?>
<input type="checkbox" name="clear_brn_no_ckk" checked="checked" value="1">&nbsp;เคลียร์ใบยืม BRN:
<?php }else{ ?>

<input type="checkbox" name="clear_brn_no_ckk" value="1">&nbsp;เคลียร์ใบยืม BRN:

	<?php } ?>

<input name="clear_brn_no" value="<?php echo $objResult['clear_brn_no']; ?>" class="w3-input" placeholder="เลขที่" >

<?php
if($objResult['clear_brnp_no_ckk']=='1'){
?>

<input type="checkbox" name="clear_brnp_no_ckk" checked="checked" value="1">&nbsp;เคลียร์ใบยืม BRNP:

<?php }else{ ?>
<input type="checkbox" name="clear_brnp_no_ckk" value="1">&nbsp;เคลียร์ใบยืม BRNP:

	<?php }?>

<input name="clear_brnp_no" value="<?php echo $objResult['clear_brnp_no']; ?>" class="w3-input" placeholder="เลขที่" >

<?php
if($objResult['sn_ckk']=='1'){
?>

		<input type="checkbox" name="sn_ckk" checked='checked' value="1">&nbsp;ต้องการ SN:

	<?php }else{ ?>

		<input type="checkbox" name="sn_ckk" value="1">&nbsp;ต้องการ SN:

		<?php } ?>



<input name="sn" value="<?php echo $objResult['sn']; ?>" class="w3-input" >
		</div>
		
		<div class="w3-bar w3-margin-bottom w3-half">
		
		<?php
if($objResult['bq_ckk']=='1'){
?>

<input type="checkbox" name="bq_ckk" checked='checked' value="1">&nbsp;BQ เลขที่:
<?php }else { ?>
<input type="checkbox" name="bq_ckk" value="1">&nbsp;BQ เลขที่:

	<?php } ?>

<input name="bq" value="<?php echo $objResult['bq']; ?>" class="w3-input" >

		
		<?php
if($objResult['ot_ckk']=='1'){
?>

<input type="checkbox" name="ot_ckk" checked='checked' value="1">&nbsp;OT เลขที่:
<?php }else{ ?>
<input type="checkbox" name="ot_ckk" value="1">&nbsp;OT เลขที่:

	<?php } ?>


<input name="ot" value="<?php echo $objResult['ot']; ?>" class="w3-input" >

			<span>วัตถุประสงค์การเบิก</span>
			<div class="w3-panel">

<?php
if($objResult['objective']=='1'){
?>
			<input type="radio" onclick="javascript:object();" name="objective" checked='checked' value="1" id="object1" required> เป็นสินค้าสำรอง
			<input type="text" name="objective_des" value="<?php echo $objResult['objective_des']; ?>" class="w3-input" placeholder="ใส่รายละเอียด" style="width:90%;">
<?php }else{ ?>
			<input type="radio" onclick="javascript:object();" name="objective" value="1" id="object1" required> เป็นสินค้าสำรอง

	<?php } ?>

				<div id="dt1" style="display:none">
					<input type="text" name="objective_des" value="<?php echo $objResult['objective_des']; ?>" class="w3-input" placeholder="ใส่รายละเอียด" style="width:90%;">
				</div>
			</div>
			<div class="w3-panel">
			
<?php
if($objResult['objective']=='2'){
?>

			<input type="radio" onclick="javascript:object();" name="objective" checked='checked' value="2" id="object2" required> สำหรับลูกค้าทดลองใช
			<input type="text" name="objective_des" class="w3-input" value="<?php echo $objResult['objective_des']; ?>" placeholder="ใส่จำนวนวัน" style="width:90%;">้
			<?php }else{ ?>
	<input type="radio" onclick="javascript:object();" name="objective" value="2" id="object2" required> สำหรับลูกค้าทดลองใช
				<?php } ?>


				<div id="dt2" style="display:none">
					<input type="text" name="objective_des" class="w3-input" value="<?php echo $objResult['objective_des']; ?>" placeholder="ใส่จำนวนวัน" style="width:90%;">
				</div>
			</div>
			<div class="w3-panel">
			
			<?php
if($objResult['objective']=='3'){
?>

			<input type="radio" onclick="javascript:object();" name="objective" value="3" checked="checked" id="object3" required> ส่งสินค้าล่วงหน้าเพื่อรอใบสั่งซื้อ
			<?php }else{ ?>
			<input type="radio" onclick="javascript:object();" name="objective" value="3" id="object3" required> ส่งสินค้าล่วงหน้าเพื่อรอใบสั่งซื้อ
<?php } ?>
			</div>
			<div class="w3-panel">
			
						<?php
if($objResult['objective']=='4'){
?>
			<input type="radio" onclick="javascript:object();" name="objective" checked="checked" value="4" id="object4" required> แลกเปลี่ยนสินค้าตามใบงานบริการเลขที่
			<input type="text" name="objective_des" class="w3-input" value="<?php echo $objResult['objective_des']; ?>" placeholder="ใส่เลขที่ใบงานบริการ" style="width:90%;">
			<?php }else{ ?>
			<input type="radio" onclick="javascript:object();" name="objective" value="4" id="object4" required> แลกเปลี่ยนสินค้าตามใบงานบริการเลขที่

	<?php } ?>
				<div id="dt4" style="display:none">
					<input type="text" name="objective_des" class="w3-input" value="<?php echo $objResult['objective_des']; ?>" placeholder="ใส่เลขที่ใบงานบริการ" style="width:90%;">
				</div>
			</div>
			<div class="w3-panel">
				<?php if($objResult['objective']=='6'){ ?>		
				<input type="radio" onclick="javascript:object();" name="objective" value="6" checked='checked' required>
				<?php }else{ ?>
				<input type="radio" onclick="javascript:object();" name="objective" value="6" required>
				<?php } ?>
				สินค้าฝากขาย (มีใบรับประกัน)
			</div>
			
			
<div class="w3-panel">
					<?php if ($objResult["objective"]=='7'){ ?>
<input type="radio" onclick="javascript:object();" name="objective" value="7" id="object6" checked="checked" required> สินค้าออกบูธ
					<?php }else{ ?>
<input type="radio" onclick="javascript:object();" name="objective" value="7" id="object6" required> สินค้าออกบูธ				
					<?php } ?>
			</div>			
			
			<div class="w3-panel">
<?php
if($objResult['objective']=='5'){
?>			
			<input type="radio" onclick="javascript:object();" name="objective" checked="checked" value="5" id="object5" required> อื่น ๆ

<input type="text" name="objective_des" class="w3-input" value="<?php echo $objResult['objective_des']; ?>" placeholder="ใส่รายละเอียดเพิ่มเติม" style="width:90%;">
			<?php }else{ ?>
			<input type="radio" onclick="javascript:object();" name="objective" value="5" id="object5" required> อื่น ๆ


	<?php } ?>
			
			<div id="dt5" style="display:none">
					<input type="text" name="objective_des" class="w3-input" value="<?php echo $objResult['objective_des']; ?>" placeholder="ใส่รายละเอียดเพิ่มเติม" style="width:90%;">
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
			<?php
if($objResult['returns']=='1'){
?>			
				<input type="checkbox" name="returns" checked='checked' value="1"> <span>รับคืนสินค้า</span>
				<?php }else{ ?>
				<input type="checkbox" name="returns" value="1"> <span>รับคืนสินค้า</span>

	<?php } ?>
			</div>
			<div class="w3-bar w3-half w3-margi-bottom">
				วันที่รับคืน
				<input type="date" name="return_date" class="w3-input" value="<?php echo $objResult['return_date']; ?>" style="width:90%;">
			</div>
			<div class="w3-bar w3-half w3-margi-bottom">
				เวลารับคืน
				<input type="text" name="return_time" value="<?php echo $objResult['return_time']; ?>" class="w3-input" style="width:90%;">
			</div>
			<div class="w3-bar w3-half w3-margin-bottom">
				<span>ชื่อผู้ติดต่อ/เบอร์โทร</span> <input type="text" name="return_contact" class="w3-input" value="<?php echo $objResult['return_contact']; ?>" style="width:90%;">
			</div>
			<div class="w3-bar w3-margin-bottom">
				<span>Ward/ตึก/ชั้น</span> <textarea name="return_address" class="w3-input" style="width:95%;"><?php echo $objResult['return_address']; ?></textarea>
			</div>
			
		</div>

</div>

<div id="pd" class="w3-container city1">

<?php 

$strSQL1 = "SELECT * FROM (so__submain LEFT JOIN tb_product ON so__submain.product_ID=tb_product.product_id) WHERE ref_idd = '".$_GET["ref_id"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);



?>

<table width="100%" border="0" class="w3-table">

<tr>
    <td align="center"><b>รหัสสินค้า</b></td>
    <td align="center"><b>ชื่อสินค้า</b></td>
    <td align="center"><b>หน่วย</b></td>
    <td align="center"><b>จำนวน</b></td>
    <td align="center"><b>ราคาต่อหน่วย</b></td>
	<td align="center"><b>ส่วนลด/หน่วย</b></td>
    <td align="center"><b>ยอดรวม</b></td>
	 <td align="center"><b>รับประกัน (ปี</b></td>
	 <td align="center"><b>Cal (ครั้ง/ปี)</b></td>
	 <td align="center"><b>PM (ครั้ง/ปี)</b></td>
    <td align="center"><b>หมายเหตุ</b></td>
	<td align="center"><b>หมายเลขเครื่อง</b></td>

</tr>
<?php
$i = 1;


while($objResult1 = mysqli_fetch_array($objQuery1))
{
	
$product_type = $objResult1["product_type"];
if($product_type=='สินค้าสาธิต'){

$save="Update   so__main set research_demo='1'   where ref_id ='".$_GET["ref_id"]."'";
$qsave=mysqli_query($conn,$save);

}		
	
?>

<tr>

<td >
<input type='hidden' name = "id[]" value="<?php echo $objResult1["id"];?>" id = "id[]"    size='16' readonly/>
<input type='hidden' name = "product_id[]" value="<?php echo $objResult1["product_id"];?>" id = "product_id[]"    size='16' readonly/>
 <input type='text' name = "product_code[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["sol_code"];?>" id = "product_code[]<?php echo $objResult1["id"];?>"  class="w3-input"    size='16' readonly/>  
</td>

<td> <textarea type='text' name = "product_name[]<?php echo $objResult1["id"];?>"  value="" id = "product_name[]<?php echo $objResult1["id"];?>"  class="w3-input" readonly><?php echo $objResult1["sol_name"];?></textarea></td>

<td><input type='text' name = "unit_name[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["unit_name"];?>" id = "unit_name[]<?php echo $objResult1["id"];?>"  class="w3-input"    size='9' readonly/></td>

<td><input type='text' name = "sale_count[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["sale_count"];?>" id = "sale_count[]<?php echo $objResult1["id"];?>"  class="w3-input" style="color:black;text-align:center"   size='7' /></td>

<td><input type='text' name = "product_price[]<?php echo $objResult1["id"];?>" value="<?php $price_per_unit= $objResult1["price_per_unit"]; echo number_format( $price_per_unit,2)."";?>" id = "product_price[]<?php echo $objResult1["id"];?>"  class="w3-input"  style="color:black;text-align:right"   /></td>

<td><input type='text' name = "discount_unit[]<?php echo $objResult1["id"];?>" value="<?php $discount_unit= $objResult1["discount_unit"]; echo number_format( $discount_unit,2)."";?>" id = "discount_unit[]<?php echo $objResult1["id"];?>"  class="w3-input"  style="color:black;text-align:right"   /></td>


<td><input type='text' name = "sum_amount[]<?php echo $objResult1["id"];?>" value="<?php  $sum_amount=$objResult1["sum_amount"]; echo number_format( $sum_amount,2)."";?>" id = "sum_amount[]<?php echo $objResult1["id"];?>"  class="w3-input" style="color:black;text-align:right"    readonly/></td>


<td><input type='text' name = "warranty[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["warranty"];?>" id = "warranty[]<?php echo $objResult1["id"];?>"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td><input type='text' name = "cal[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["cal"];?>" id = "cal[]<?php echo $objResult1["id"];?>"  class="w3-input"   OnKeyPress="return chkNumber(this)"/></td>

<td><input type='text' name = "pm[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["pm"];?>" id = "pm[]<?php echo $objResult1["id"];?>"  class="w3-input"   OnKeyPress="return chkNumber(this)"/></td>



<td><input type='text' name = "sale_remarkk[]<?php echo $objResult1["id"];?>"  id = "sale_remarkk[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["sale_remark"];?>" class="w3-input"    size='13' ></td>

<td> <textarea class="w3-input" name = "sn[]<?php echo $objResult1["id"];?>"  id = "sn[]<?php echo $objResult1["id"];?>" ><?php echo $objResult1["sn_number"];?></textarea></td>	

<td><a href="product_allwel_del.php?ref_id=<?php echo $objResult["ref_id"];?>&id=<?php echo $objResult1["id"];?>"><img src="img/false.png" width="16" height="16" border="0" ></a></td>


</tr>

<?
	$i++;

}

?>

</table>
<?php
if($Num_Rows1 < '8'){
if ($objResult["select_type_doc"]=='1'){
include ('data_product_allwell.php');
}else if ($objResult["select_type_doc"]=='2'){
include ('data_product_allwellnb.php');	
}
}

?>

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
</div>

<div id="cs" class="w3-container city1" style="display:none">

<?php

		if($objResult["delivery_type"]=='1'){
			?>
<input type="radio" name="delivery_type" checked='checked' value="1" onclick="javascript:ckk_2();" id="object8" >Sale รับเอง
<input type="radio" name="delivery_type" value="2" onclick="javascript:ckk_2();" id="object9" >ช่างรับเอง<br/>
<input type="radio" name="delivery_type" value="3" onclick="javascript:ckk_2();" id="object10" >ลูกค้ารับเอง 
<input type="radio" name="delivery_type"  value="4" onclick="javascript:ckk_2();" id="object11" >บริษัทจัดส่ง <br />

<?php
		}else if($objResult["delivery_type"]=='2'){
	?>
<input type="radio" name="delivery_type" value="1" onclick="javascript:ckk_2();" id="object8">Sale รับเอง
<input type="radio" name="delivery_type" checked='checked' value="2" onclick="javascript:ckk_2();" id="object9">ช่างรับเอง<br/>
<input type="radio" name="delivery_type" value="3" onclick="javascript:ckk_2();" id="object10" >ลูกค้ารับเอง 
<input type="radio" name="delivery_type"  value="4" onclick="javascript:ckk_2();" id="object11" >บริษัทจัดส่ง <br/>


		<?php
}else if($objResult["delivery_type"]=='3'){
		
			?>
	<input type="radio" name="delivery_type" value="1" onclick="javascript:ckk_2();" id="object8" >Sale รับเอง
	<input type="radio" name="delivery_type" value="2" onclick="javascript:ckk_2();" id="object9" >ช่างรับเอง<br/>
    <input type="radio" name="delivery_type" checked='checked' value="3" onclick="javascript:ckk_2();" id="object10" >ลูกค้ารับเอง 
	<input type="radio" name="delivery_type"  value="4" onclick="javascript:ckk_2();" id="object11" >บริษัทจัดส่ง <br/>


<?php
		}else if($objResult["delivery_type"]=='4'){
		?>

	<input type="radio" name="delivery_type" value="1" onclick="javascript:ckk_2();" id="object8" >Sale รับเอง
	<input type="radio" name="delivery_type" value="2" onclick="javascript:ckk_2();" id="object9" >ช่างรับเอง<br />
    <input type="radio" name="delivery_type"  value="3" onclick="javascript:ckk_2();" id="object10" >ลูกค้ารับเอง 
	<input type="radio" name="delivery_type" checked='checked' value="4" onclick="javascript:ckk_2();" id="object11" >บริษัทจัดส่ง <br />

			<?php
}else {
			?>
	<input type="radio" name="delivery_type" value="1" onclick="javascript:ckk_2();" id="object8" >Sale รับเอง
	<input type="radio" name="delivery_type" value="2" onclick="javascript:ckk_2();" id="object9" >ช่างรับเอง<br />
    <input type="radio" name="delivery_type"  value="3" onclick="javascript:ckk_2();" id="object10" >ลูกค้ารับเอง 
	<input type="radio" name="delivery_type"  value="4" onclick="javascript:ckk_2();" id="object11" >บริษัทจัดส่ง <br />

				<?php
			}
				?>



<?php 
if ($objResult["delivery_type"]=='1' or $objResult["delivery_type"]=='2' or $objResult["delivery_type"]=='3'){
?>


<div class="w3-quarter"><!-- first third-->
<input type="checkbox" name="" hidden><br \>
วันที่ส่ง
<input type="date" name="delivery_date" value="<?php echo $objResult["delivery_date"];?>" class="w3-input" >
เวลาส่ง
<input type="text" name="delivery_time" value="<?php echo $objResult["delivery_time"];?>" class="w3-input" >
การส่งสินค้า<br>
		<?php
		if($objResult["big_car"]){

			?>
<input type="checkbox" name="big_car" checked='checked' value="1">ต้องการรถใหญ่<br />
<?php
		}else{
	?>
<input type="checkbox" name="big_car" value="1">ต้องการรถใหญ่<br />

		<?php
}
		if($objResult["call_before"]){
			?>
<input type="checkbox" name="call_before" checked='checked' value="1">โทรแจ้งลูกค้าก่อนไป<br />
<?php
		}else{
	?>
<input type="checkbox" name="call_before" value="1">โทรแจ้งลูกค้าก่อนไป<br />
		<?php
}
		if($objResult["maps"]){
			?>
<input type="checkbox" name="maps" checked='checked' value="1">มีแผนที่ประกอบ<br />
<?php
		}else{
				?>
<input type="checkbox" name="maps" value="1">มีแผนที่ประกอบ<br />
					<?php
			}
				?>
<input type='hidden' name='upload_map' id='upload_map' value ="<?php echo $objResult['upload_map']; ?>"  />

<input name="upload_map"  type="file"><a href="upload/<?php echo $objResult['upload_map']; ?>" target="_blank"><?php echo $objResult['upload_map']; ?></a></p>

				<?php
				if($objResult["assign_date_time"]){
						?>
<input type="checkbox" name="assign_date_time" checked='checked' value="1">นัดวันเวลาเรียบร้อยแล้ว<br />

<?php
				}else{
	?>
<input type="checkbox" name="assign_date_time" value="1">นัดวันเวลาเรียบร้อยแล้ว<br />
<?php
}
	?>

</div><!-- first third-->
<div class="w3-quarter w3-container"><!-- second third-->

<?php /*สถานที่ส่งสินค้า:
<textarea  class="w3-input" cols="20" rows="1" style="width:100%;resize: none" ><?php echo $objResult["delivery_place"] ; ?></textarea>
ชื่อผู้ติดต่อ/TEL.:
<input type="text"  value ="<?php echo $objResult["delivery_contact"]; ?>" class="w3-input" >*/ ?>
</div><!-- second third-->
<div class="w3-quarter"><!-- 3rd quarter-->

</div><!-- 3rd quarter-->
<div class="w3-quarter w3-container">

<?php
if ($objResult["select_type_doc"]=='1'){
?>
<input type="checkbox"  checked="checked" value="1">&nbsp;

<a href="report_loanptl.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey"><font color="Blue">ใบยืม AWL</font></a>&nbsp;&nbsp;


<?php
}

if ($objResult["select_type_doc"]=='2'){

?>
<input type="checkbox" name="select_br_nbm" checked="checked" value="1">&nbsp;
					

<a  href="report_loannbm.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey"><font color="DeepPink"> ใบยืม NBM</font></a>&nbsp;

<?php
}

?>

</div><!-- forth quarter -->

<?php } ?>

<?php 

$sql1 = "select * from tb_register_data where ref_id = '".$_GET["ref_id"]."'";
$query1 = mysqli_query($conn,$sql1);
$fetch1 = mysqli_fetch_array($query1,MYSQLI_ASSOC); 



if ($objResult["delivery_type"]=='4'){
?>


<div class="w3-quarter w3-container"><!-- first third-->
<input type="checkbox" name="" hidden><br \>
วันที่ส่ง
<input type="date" name="delivery_date" value="<?php echo $objResult["delivery_date"];?>" class="w3-input" >
เวลาส่ง
<input type="text" name="delivery_time" value="<?php echo $objResult["delivery_time"];?>" class="w3-input" >


</div><!-- first third-->

<div class="w3-quarter w3-right w3-container">

<?php
if ($objResult["select_type_doc"]=='1'){
?>
<input type="checkbox"  checked="checked" value="1">&nbsp;

<a href="report_loanptl.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey"><font color="Blue">ใบยืม AWL</font></a>&nbsp;&nbsp;

<?php
}

if ($objResult["select_type_doc"]=='2'){

?>
<input type="checkbox" name="select_br_nbm" checked="checked" value="1">&nbsp;
					

<a  href="report_loannbm.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey"><font color="DeepPink"> ใบยืม NBM</font></a>&nbsp;

<?php
}
?>

</div>


<div class="w3-container w3-third">
	<?php if ($objResult["send_cs"]=='2'){ ?>
<input type="checkbox" name="send_cs" checked="checked" value="2">&nbsp;ส่งข้อมูลไประบบลงงาน 
	<?php }else{ ?>
	<input type="checkbox" name="send_cs" value="1">&nbsp;ส่งข้อมูลไประบบลงงาน 
	<?php } ?>
	
	</div>
<div class="w3-container w3-third">
	<?php if ($objResult["mk_research"]=='1'){ ?>
<input type="checkbox" name="mk_research" checked='checked' value="1">&nbsp; <span class="style34"><u>cs ทำแบบสอบถาม </u></span>  
	<?php }else{ ?>
<input type="checkbox" name="mk_research"  value="1">&nbsp; <span class="style34"><u>cs ทำแบบสอบถาม </u></span> 	
	<?php } ?>
	</div>
<div class="w3-container w3-third">
.
	</div>
	<div class="w3-container w3-third">
 วันที่ รับ-ส่ง :
      <input name="start_date" type='date' id="start_date" value="<?php echo $fetch1["start_date"]; ?>"  class="w3-input"  />

	</div><div class="w3-container w3-third">

วันที่ต้องการโดยประมาณ :
	  <input name="between_date"  class="w3-input" value="<?php echo $fetch1["between_date"]; ?>" type='text' id="between_date"  />
 </div><div class="w3-container w3-third">

 เวลา :
<input id="start_time"  name="start_time" value="<?php echo $fetch1["start_time"]; ?>" class="w3-input" type="text" />
ถึง
<input id="end_time" name="end_time"  value="<?php echo $fetch1["end_time"]; ?>" class="w3-input" type="text" />

</div><div class="w3-container w3-third">


สถานะการทำงาน : 

<?php if($fetch1["status"]=='ส่ง'){ ?>

<input type='radio'  name='status' id = 'status' value='ส่ง' checked='checked'/>ส่ง
&nbsp; <input type='radio'  name='status' id = 'status' value='รับ' />รับ

<?php }else if($fetch1["status"]=='รับ'){ ?>

<input type='radio'  name='status' id = 'status' value='ส่ง' />ส่ง
&nbsp; <input type='radio'  name='status' id = 'status' value='รับ' checked='checked'/>รับ

<?php } ?>

</div><div class="w3-container w3-third">

สถานะ :
      <input name="status_comment" type='text' id="status_comment" value="<?php echo $fetch1["status_comment"]; ?>" size="20" class="w3-input"/>
</div><div class="w3-container w3-third">

<?php if($fetch1["fix_date"]=='1'){ ?>

<input type="checkbox"  name="fix_datetime" id = "fix_datetime" checked='checked' value="1">นัดวันและเวลาเรียบร้อยแล้ว 
<?php }else { ?>
<input type="checkbox"  name="fix_datetime" id = "fix_datetime"  value="1">นัดวันและเวลาเรียบร้อยแล้ว 

<?php } if($fetch1["no_price"]=='1'){ ?>

<input type="checkbox"  id = "no_money" name="no_money" checked="checked" value="1">ไม่ต้องเก็บเงิน

<?php }else { ?>
<input type="checkbox"  id = "no_money" name="no_money" value="1">ไม่ต้องเก็บเงิน


<?php } ?>
</div><div class="w3-container w3-third">
<?php if($fetch1["call_customer"]=='1'){ ?>

<input type="checkbox"  id = "call_customer" name="call_customer"  checked="checked" value="1">โทรแจ้งลูกค้าก่อนไป
<?php }else { ?>
<input type="checkbox"  id = "call_customer" name="call_customer" value="1">โทรแจ้งลูกค้าก่อนไป
	<?php } if($fetch1["call_employee"]=='1'){ ?>
	
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox"  id = "call_back" name="call_back" checked="checked" value="1">ต้องการให้โทรกลับเมื่อส่งสินค้าเสร็จแล้ว
<?php }else { ?>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox"  id = "call_back" name="call_back" value="1">ต้องการให้โทรกลับเมื่อส่งสินค้าเสร็จแล้ว


<?php } ?>
</div><div class="w3-container w3-third">
<?php if($fetch1["want_bus"]=='1'){ ?>
<input type="checkbox"   name="want_bus" checked="checked" value="1">ต้องการรถใหญ่
<?php }else{ ?>
	<input type="checkbox"   name="want_bus" value="1">ต้องการรถใหญ่

<?php } ?>
		</div><div class="w3-container w3-third">
	 <?php if($fetch1["cash"]=='1'){ ?>

<input type="checkbox"  name="cash"id = "cash" checked="checked" value="1">เก็บเงินสด
<?php }else { ?>
	<input type="checkbox"  name="cash"id = "cash"  value="1">เก็บเงินสด


<?php } ?>
		 <input name="unit_cash" type='text' class="w3-input" id="unit_cash" value="<?php echo $fetch1["unit_cash"]; ?>" size="20" rows="1" style="color:black;text-align:right" OnChange="JavaScript:chkNum(this)">  
		 </div><div class="w3-container w3-third">

<?php if ($fetch1["check_paper"]=='1'){ ?>

	<input type="checkbox"  name="check_paper" id = "check_paper" checked='checked' value="1">รับเช็ค

	<?php }else{ ?>
	<input type="checkbox"  name="check_paper" id = "check_paper" value="1">รับเช็ค

		<?php } ?>
	<input name="unit_check" type='text' class="w3-input" value="<?php echo $fetch1["unit_check"]; ?>"  id="unit_check" style="color:black;text-align:right" size="20" OnChange="JavaScript:chkNum(this)"/>
		</div><div class="w3-container w3-third">

<?php if ($fetch1["credit_card"]=='1'){ ?>
<input type="checkbox"  id = "credit_card" name="credit_card" checked="checked" value="1">รูดการ์ด 
<?php }else { ?>
<input type="checkbox"  id = "credit_card" name="credit_card" value="1">รูดการ์ด 

<?php } ?>

	<input name="unit_credit" type='text' class="w3-input"  id="unit_credit" value="<?php echo $fetch1["unit_credit"]; ?>" size="20" style="color:black;text-align:right"  OnChange="JavaScript:chkNum(this)"/> 
	</div><div class="w3-container w3-third">

<?php if ($fetch1["bill"]=='1'){ ?>

<input type="checkbox"  id = "bill" name="bill" checked="checked" value="1">วางบิล

<?php }else{ ?>
<input type="checkbox"  id = "bill" name="bill" value="1">วางบิล

	<?php } ?>
<input name="unit_bill" type='text' class="w3-input" style="color:black;text-align:right" id="unit_bill" value="<?php echo $fetch1["unit_bill"]; ?>" size="20" OnChange="JavaScript:chkNum(this)" />
</div><div class="w3-container w3-third">

<?php if ($fetch1["tran"]=='1'){ ?>

<input type="checkbox"  name="tran"id = "tran" checked="checked" value="1">ลูกค้าโอนเงินหน้างาน
<?php }else { ?>
<input type="checkbox"  name="tran"id = "tran"  value="1">ลูกค้าโอนเงินหน้างาน
	<?php } ?>

		 <input name="unit_tran" type='text' class="w3-input" id="unit_tran" size="20" value="<?php echo $fetch1["unit_tran"]; ?>" style="color:black;text-align:right" rows="1"OnChange="JavaScript:chkNum(this)"> 
</div><div class="w3-container w3-third">

<?php if ($fetch1["tran"]=='1'){ ?>

<input type="checkbox"  id = "dep" name="dep" checked="checked" value="1">อื่นๆ
<?php }else { ?>
<input type="checkbox"  id = "dep" name="dep" value="1">อื่นๆ


	<?php } ?>



<input name="dept" type='text' class="w3-input"  id="dept" value="<?php echo $fetch1["dept"]; ?>" size="20"  />
</div><div class="w3-container w3-third">

แผนก - ฝ่าย :

<input name="department_show" type='text' class="w3-input"  id="department_show" value="<?php echo $fetch1["department_show"]; ?>" size="20"  />
<?php /*
<select name="department_show" id="department_show" class="w3-input"   >
<option  value="">**โปรดเลือกแผนก-ฝ่าย**</option>
<option  value="ฝ่ายการตลาด">ฝ่ายการตลาด</option>
<option  value="ฝ่ายขาย">ฝ่ายขาย</option>
<option  value="ฝ่ายสนับสนุนการขาย ธุรการ">ฝ่ายสนับสนุนการขาย ธุรการ</option>

</select>*/ ?>

</div><div class="w3-container w3-third">
       ประเภทลูกค้า :

<input name="customer_typename" type='text' class="w3-input"  id="customer_typename" value="<?php echo $fetch1["type_customer"]; ?>" size="20"  />

<?php /*
<select name="customer_typename" id="customer_typename" class="w3-input"   >
<option  value="">**โปรดเลือกประเภทลูกค้า**</option>
<option  value="ร้านขายยา">ร้านขายยา</option>
<option  value="ลูกค้าทั่วไป">ลูกค้าทั่วไป</option>
<option  value="โรงพยาบาล">โรงพยาบาล</option>

</select>*/ ?>


</div><div class="w3-container w3-third">
       หน่วยงาน :

	<select name="company_name" id="company_name" class="w3-input">
<option value="">**Please Select Item**</option>
<?php
$strSQL6 = "SELECT * FROM tb_company ORDER BY seq ASC";
$objQuery6 = mysqli_query($conn,$strSQL6) or die ("Error Query [".$strSQL6."]");
while($objResult6 = mysqli_fetch_array($objQuery6))
{
if($objResult["type_company"] == $objResult6["company_name"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>
<option value="<?php echo $objResult6["company_name"];?>" <?php echo $sel;?>><?php echo $objResult6["company_name"];?></option>

<?php
}
?>
</select>
	




</div><div class="w3-container w3-third">
       ประเภทงาน :
	   <input name="department_name" type='text' class="w3-input"  id="department_name" value="<?php echo $fetch1["department"]; ?>" size="20"  />
<?php /*
<select name="department_name" id="department_name" class="w3-input"   >
<option  value="">**โปรดเลือกประเภทงาน**</option>
<option  value="Online">Online</option>
<option  value="Sale">Sale</option>

</select>*/ ?>

</div><div class="w3-container w3-third">
ชื่อผู้ติดต่อ  :
<input name="customer_name1"  class="w3-input" type='text' value="<?php echo $fetch1["customer_name"]; ?>" id="customer_name1">

</div><div class="w3-container w3-third">
 ผู้รับสินค้า :
<input name="customer_contact" value="<?php echo $fetch1["customer_contact"]; ?>" class="w3-input" type='text' id="customer_contact">

</div><div class="w3-container w3-third">

 เบอร์โทรลูกค้า :
<input name="customer_tel"  class="w3-input" type='text' value="<?php echo $fetch1["customer_tel"]; ?>" id="customer_tel">

</div><div class="w3-container w3-third">

จังหวัด :
<select name="province_name" id ="province_name" class="w3-input" style="width:90%" >
<option value="">**Please Select Item**</option>
<?php
$strSQL5 = "select * from tb_province order by province_ID ";
$objQuery5 = mysqli_query($conn,$strSQL5);
if (!$objQuery5) {
	echo "Failed to fetch to MySQL: " . mysqli_error();
}
while ($objResuut5 = mysqli_fetch_array($objQuery5,MYSQLI_ASSOC)) {
if($fetch1["province_name"] == $objResuut5["province_name"])
{
$sel = "selected";
}
else
{
$sel = "";
}
	?>
<option class="w3-bar-item w3-button"  value="<?php echo $objResuut5['province_name']; ?>"<?php echo $sel;?>><?php echo $objResuut5['province_name']; ?></option>
<?php } ?>
</select>

 </div><div class="w3-container w3-third">
ชื่อโรงพยาบาล :
<input type='text'  class="w3-input" value="<?php echo $fetch1["address_name"]; ?>" name="address_name" >             


 </div>
<div class="w3-container w3-third">	

  ที่อยู่ :
<textarea   class="w3-input" name="address_send" cols="54" rows="1"><?php echo $fetch1["address_send"]; ?></textarea>

</div>
<div class="w3-container w3-third">
เลขที่เอกสาร/เลขที่เครื่อง : 
<textarea name="product_sn"  class="w3-input" id="product_sn" cols="54" rows="1"><?php echo $fetch1["product_sn"]; ?></textarea>

</div>
<div class="w3-container w3-third">
สินค้า/เอกสาร :  
<textarea name="product"  class="w3-input" id="product" cols="54" rows="1"><?php echo $fetch1["product_name"]; ?></textarea>

</div>

<div class="w3-container w3-third">
รายละเอียดเพิ่มเติม : 
     <textarea name="description"  class="w3-input" id="description" cols="54" rows="1"><?php echo $fetch1["description"]; ?></textarea>
</div>

<?php 
				$sql2 = "select * from tb_transaction where ref_id = '".$_GET["ref_id"]."'";
				$query2 = mysqli_query($conn,$sql2);
				$fetch2 = mysqli_fetch_array($query2,MYSQLI_ASSOC); 
				
	?>
		<?php
if ($fetch1["check_detail"]=='0' or $fetch1["check_detail"]==''){
		?>
	<fieldset><legend><input type="checkbox" name="more" id="more" value="1"> <b>รายละเอียดการจัดส่ง</b></legend>
	<div id="more-2" style="display:none;">
		<div class="w3-container w3-third 112">
			<div class="w3-bar 1">

						<input type="checkbox" name="runway"id = "runway" value="1"> ติดถนนรันเวย์
			</div>
			<div class="w3-container w3-bar 2">
					<input type="checkbox" name="road"id = "road" value="1"> ติดถนนวิ่งสวนกัน

			</div>
			<div class="w3-container w3-bar 3">
				<input type="checkbox" name="soy"id = "soy" value="1"> เข้าซอย

			</div>
			<div class="w3-container w3-bar 4">
				ทางเข้ากว้าง
				<input name="soy_big" class="w3-input" value="<?php echo $fetch1["soy_big"]; ?>" type='text' id="soy_big" style="color:black;text-align:left;width:90%;" placeholder="(เมตร)" />
			</div>
			<div class="w3-container w3-bar 5">
			 		<input type="checkbox" name="height_ltd" id = "height_ltd" value="1"> มีตัวจำกัดความสูง

			</div>
			<div class="w3-container w3-bar 6">
				<input type="checkbox" name="car_load"id = "car_load" value="1"> รถยนต์สามารถเข้าได้
			</div>
			<div class="w3-container w3-bar 7">
				<input type="checkbox" name="no_car_road"id = "no_car_road" value="1"> รถยนต์เข้าไม่ได้ สามารถจอดได้ที่ <input name="car_park" class="w3-input" type='text' id="car_park" style="width:90%;" />
			</div>
			<div class="w3-container w3-bar 8">
				การจอดรถ
			</div>
			<div class="w3-container w3-bar 9">
				<input type="checkbox" name="car_road" id = "car_road" value="1"> จอดรถข้างถนน
			</div>
			<div class="w3-container w3-bar 10">
				<input type="checkbox" name="car_home"id = "car_home" value="1"> จอดรถหน้าบ้านได้
			</div>
			<div class="w3-container w3-bar 11">
				ประตูหน้าบ้านสูง
				<input name="door_long" class="w3-input" type='text' id="door_long" style="color:black;text-align:left;width:90%;" placeholder="(เมตร)" />
			</div>
			<div class="w3-container w3-bar 12">
				<input type="checkbox" name="slope"id = "slope" value="1"> มีทางราบก่อนประตูบ้าน
			</div>
			<div class="w3-container w3-bar 13">
				<input type="checkbox" name="bundai"id = "bundai" value="1"> มีบันไดก่อนประตูบ้าน
			</div>
			<div class="w3-container w3-bar 14">
				<input name="unit_bundai" class="w3-input" type='text' id="unit_bundai" style="width:90%;" placeholder="จำนวน (ขั้น)" />
			</div>
			<div class="w3-container w3-bar 15">
				ประตูบ้านกว้าง
				<input name="door_bigger" class="w3-input" type='text' id="door_bigger" style="width:90%;" placeholder="(เมตร)" />
			</div>
			<div class="w3-container w3-bar 16">
				ประตูสูง 
				<input name="door_longer" class="w3-input" type='text' id="door_longer" style="width:90%;" placeholder="(เมตร)" />
			</div>
			<div class="w3-container w3-bar 17">
				ประตูห้องกว้าง 
				<input name="room_bigger" class="w3-input" type='text' id="room_bigger" style="width:90%;" placeholder="(เมตร)" />
			</div>
			<div class="w3-container w3-bar 18">
				ประตูห้องสูง 
				<input name="room_longer" class="w3-input" type='text' id="room_longer" style="width:90%;" placeholder="(เมตร)" />
			</div>
		</div>
		<div class="w3-container w3-third 212">
			<div class="w3-bar 1">
				ประตูบ้านเป็นแบบ
				<input name="type_door" class="w3-input" type='text' id="type_door" style="width:90%;" />
			</div>
			<div class="w3-container w3-bar 2">
				พื้นบ้านเป็นแบบ
				<input name="home_type" class="w3-input" type='text' id="home_type" style="width:90%;" />
			</div>
			<div class="w3-container w3-bar 3">
				ติดตั้งที่ชั้น
				<input name="install" class="w3-input" type='text' id="install" style="width:90%;" />
			</div>
			<div class="w3-container w3-bar 4">
				<input type="checkbox" name="bundai_install"id ="bundai_install" value="1"> บันไดกว้าง
			</div>
			<div class="w3-container w3-bar 5">
				<input name="bundai_big" class="w3-input" type='text' id="bundai_big" style="width:90%;" placeholder="เมตร" />
			</div>
			<div class="w3-container w3-bar 6">
				หักมุมบันได
				<input name="bundai_hug" class="w3-input" type='text' id="bundai_hug" style="width:90%;" />
			</div>
			<div class="w3-container w3-bar 7">
				ชนิดของบันได
				<input name="type_bundai" class="w3-input" type='text' id="type_bundai" style="width:90%;" />
			</div>
			<div class="w3-container w3-bar 8">
				<input type="checkbox" name="lip"id = "lip" value="1"> ลิฟท์กว้าง
			</div>
			<div class="w3-container w3-bar 9">
				<input name="lip_big" class="w3-input" type='text' id="lip_big" style="width:90%;" placeholder="เมตร" />
			</div>
			<div class="w3-container w3-bar 10">
				สูง
				<input name="lip_long" class="w3-input" type='text' id="lip_long" style="width:90%;" placeholder="เมตร" />
			</div>
			<div class="w3-container w3-bar 11">
				รับน้ำหนักได้ 
				<input name="lip_weight" class="w3-input" type='text' id="lip_weight" style="width:90%;" />
			</div>
			
		</div>
		<div class="w3-container w3-third 312">
			<div class="w3-container w3-bar 12">
				<input type="checkbox" name="up"id ="up" value="1"> ขึ้นลิฟท์ได้
			</div>
			<div class="w3-container w3-bar 13">
				<input type="checkbox" name="no_up"id ="no_up" value="1"> ขึ้นลิฟท์ไม่ได้
			</div>
			<div class="w3-container w3-bar 14">
				<input type="checkbox" name="head_bad"id ="head_bad" value="1"> ต้องถอดหัวเตียง-ท้ายเตียง
			</div>
			<div class="w3-container w3-bar 15">
				<input type="checkbox" name="want_employee"id ="want_employee" value="1"> ต้องการเจ้าหน้าที่ย้ายเฟอร์นิเจอร์
			</div>
			<div class="w3-container w3-bar 16">
				จำนวนคนที่ใช้ 
				<input name="employee_unit" class="w3-input" type='text' id="employee_unit" style="width:90%;" />
			</div>
			<div class="w3-container w3-bar 17">
				ย้ายเฟอร์นิเจอร์ 
				<input name="ferniger_name" class="w3-input" type='text' id="ferniger_name" style="width:90%;" />
			</div>
			<div class="w3-container w3-bar 18">
				ย้ายไปที่ 
				<input name="ferniger_address" class="w3-input" type='text' id="ferniger_address" style="width:90%;" />
			</div>
			<div class="w3-container w3-bar">
				<input type="checkbox" name="want_ex"id = "want_ex" value="1"> ต้องเตรียมอุปกรณ์ไปถอดประกอบ
			</div>
			<div class="w3-container w3-bar">
				<input type="checkbox" name="want_credit"id = "want_credit" value="1"> ต้องเตรียมเครื่องรูดบัตร
			</div>
			<div class="w3-container w3-bar">
				ธนาคาร 
				<input name="bank" class="w3-input" type='text' id="bank" style="width:90%;" />
			</div>
			<div class="w3-container w3-bar">
				<input type="checkbox" name="want_prem"id ="want_prem" value="1"> ต้องการให้เตรียมฟรีมยืดไปซิวเก็บเตียงหรือที่นอนเก่า
			</div>
			<div class="w3-container w3-bar">
				รายละเอียดเพิ่มเติม
				<textarea name="description_ja" class="w3-input" id="description_ja" cols="54" rows="1" style="width:90%;"></textarea>
			</div>
		</div>
	</div>
	</fieldset>
<?php
}else if ($fetch1["check_detail"]=='1'){
		?>
<fieldset><legend><input type="checkbox" name="more" id="more" value="1" checked="checked"> <b>รายละเอียดการจัดส่ง</b></legend>

		<div class="w3-third 112">
			<div class="w3-bar 1">

<?php
if ($fetch2["runway"]=='1'){
		?>
				<input type="checkbox" name="runway"id = "runway" checked='checked' value="1"> ติดถนนรันเวย์
	<?php
}else{
			?>
			<input type="checkbox" name="runway"id = "runway" value="1"> ติดถนนรันเวย
				<?php
		}
					?>
			</div>
			<div class="w3-bar 2">

			<?php
if ($fetch2["road"]=='1'){
		?>
				<input type="checkbox" name="road"id = "road" checked='checked' value="1"> ติดถนนวิ่งสวนกัน
<?php
			}else{
			?>

				<input type="checkbox" name="road"id = "road" value="1"> ติดถนนวิ่งสวนกัน
				<?php
		}
				?>

			</div>
			<div class="w3-bar 3">
			<?php
if ($fetch2["soy"]=='1'){
		?>
				<input type="checkbox" name="soy"id = "soy" checked='checked' value="1"> เข้าซอย
				<?php
			}else{
			?>
				<input type="checkbox" name="soy"id = "soy" value="1"> เข้าซอย

				<?php
		}
				?>
			</div>
			<div class="w3-bar 4">
				ทางเข้ากว้าง
				<input name="soy_big" class="w3-input" value="<?php echo $fetch2["soy_big"]; ?>" type='text' id="soy_big" style="color:black;text-align:left;width:90%;" placeholder="(เมตร)" />
			</div>
			<div class="w3-bar 5">
			<?php
		if ($fetch2["height_ltd"]=='1'){
		?>
				<input type="checkbox" name="height_ltd" id = "height_ltd" checked='checked' value="1"> มีตัวจำกัดความสูง
				<?php
				}else{
			?>
				<input type="checkbox" name="height_ltd" id = "height_ltd" value="1"> มีตัวจำกัดความสูง

				<?php
		}
				?>
			</div>
			<div class="w3-bar 6">
			<?php
		if ($fetch2["car_load"]=='1'){
		?>
				<input type="checkbox" name="car_load"id = "car_load" checked='checked' value="1"> รถยนต์สามารถเข้าได้
	<?php
				}else{
			?>
				<input type="checkbox" name="car_load"id = "car_load" value="1"> รถยนต์สามารถเข้าได้

				<?php
		}
				?>
			
			
			</div>
			<div class="w3-bar 7">
			<?php
		if ($fetch2["no_car_road"]=='1'){
		?>
				<input type="checkbox" name="no_car_road"id = "no_car_road" checked='checked' value="1">
			<?php
			}else{
			?>
			<input type="checkbox" name="no_car_road"id = "no_car_road" value="1">
		<?php
		}
			?>
				
				รถยนต์เข้าไม่ได้ สามารถจอดได้ที่ <input name="car_park" class="w3-input" type='text' id="car_park" value ="<?php echo $fetch2["car_park"]; ?>" style="width:90%;" />
			</div>
			<div class="w3-bar 8">
				การจอดรถ
			</div>
			<div class="w3-bar 9">
	<?php
		if ($fetch2["car_road"]=='1'){
		?>

				<input type="checkbox" name="car_road" id = "car_road" checked='checked' value="1"> จอดรถข้างถนน
<?php
				}else{
					?>
				<input type="checkbox" name="car_road" id = "car_road" value="1"> จอดรถข้างถนน

						<?php
				}
						?>

			</div>
			<div class="w3-bar 10">
	<?php
		if ($fetch2["car_home"]=='1'){
		?>

				<input type="checkbox" name="car_home"id = "car_home" checked='checked' value="1"> จอดรถหน้าบ้านได้
				<?php
			}else{
				?>
				<input type="checkbox" name="car_home"id = "car_home" value="1"> จอดรถหน้าบ้านได้

					<?php
				}
					?>
			</div>
			<div class="w3-bar 11">
				ประตูหน้าบ้านสูง
				<input name="door_long" class="w3-input" type='text' value="<?php echo $fetch2["door_long"]; ?>" id="door_long" style="color:black;text-align:left;width:90%;" placeholder="(เมตร)" />
			</div>
			<div class="w3-bar 12">
			<?php
		if ($fetch2["slope"]=='1'){
		?>
				<input type="checkbox" name="slope"id = "slope" checked='checked' value="1"> มีทางราบก่อนประตูบ้าน
				<?php
					}else{
		?>
		<input type="checkbox" name="slope"id = "slope" value="1"> มีทางราบก่อนประตูบ้าน
			<?php
		}
			?>

			</div>
			<div class="w3-bar 13">
	<?php
		if ($fetch2["bundai"]=='1'){
		?>
				<input type="checkbox" name="bundai"id = "bundai" checked='checked' value="1"> มีบันไดก่อนประตูบ้าน
				<?php
			}else{
			?>
				<input type="checkbox" name="bundai"id = "bundai" value="1"> มีบันไดก่อนประตูบ้าน

				<?php
		}
				?>
			</div>
			<div class="w3-bar 14">
				<input name="unit_bundai" class="w3-input" type='text' id="unit_bundai" value="<?php echo $fetch2["unit_bundai"]; ?>" style="width:90%;" placeholder="จำนวน (ขั้น)" />
			</div>
			<div class="w3-bar 15">
				ประตูบ้านกว้าง
				<input name="door_bigger" class="w3-input" type='text' id="door_bigger" value="<?php echo $fetch2["door_bigger"]; ?>" style="width:90%;" placeholder="(เมตร)" />
			</div>
			<div class="w3-bar 16">
				ประตูสูง 
				<input name="door_longer" class="w3-input" type='text' id="door_longer" value="<?php echo $fetch2["door_longer"]; ?>" style="width:90%;" placeholder="(เมตร)" />
			</div>
			<div class="w3-bar 17">
				ประตูห้องกว้าง 
				<input name="room_bigger" class="w3-input" type='text' id="room_bigger" value="<?php echo $fetch2["room_bigger"]; ?>" style="width:90%;" placeholder="(เมตร)" />
			</div>
			<div class="w3-bar 18">
				ประตูห้องสูง 
				<input name="room_longer" class="w3-input" type='text' id="room_longer"  value="<?php echo $fetch2["room_longer"]; ?>" style="width:90%;" placeholder="(เมตร)" />
			</div>
		</div>
		<div class="w3-third 212">
			<div class="w3-bar 1">
				ประตูบ้านเป็นแบบ
				<input name="type_door" class="w3-input" type='text' id="type_door"  value="<?php echo $fetch2["type_door"]; ?>" style="width:90%;" />
			</div>
			<div class="w3-bar 2">
				พื้นบ้านเป็นแบบ
				<input name="home_type" class="w3-input" type='text' id="home_type" value="<?php echo $fetch2["home_type"]; ?>" style="width:90%;" />
			</div>
			<div class="w3-bar 3">
				ติดตั้งที่ชั้น
				<input name="install" class="w3-input" type='text' id="install" value="<?php echo $fetch2["install"]; ?>" style="width:90%;" />
			</div>
			<div class="w3-bar 4">

			<?php
		if ($fetch2["bundai_install"]=='1'){
		?>
				<input type="checkbox" name="bundai_install"id ="bundai_install" checked='checked' value="1"> บันไดกว้าง
<?php
			}else{
			?>
				<input type="checkbox" name="bundai_install"id ="bundai_install" value="1"> บันไดกว้าง

				<?php
		}
				?>

			</div>
			<div class="w3-bar 5">
				<input name="bundai_big" class="w3-input" type='text' id="bundai_big" value="<?php echo $fetch2["bundai_big"]; ?>" style="width:90%;" placeholder="เมตร" />
			</div>
			<div class="w3-bar 6">
				หักมุมบันได
				<input name="bundai_hug" class="w3-input" type='text' id="bundai_hug" value="<?php echo $fetch2["bundai_hug"]; ?>" style="width:90%;" />
			</div>
			<div class="w3-bar 7">
				ชนิดของบันได
				<input name="type_bundai" class="w3-input" type='text' id="type_bundai" value="<?php echo $fetch2["type_bundai"]; ?>" style="width:90%;" />
			</div>
			<div class="w3-bar 8">
			<?php
		if ($fetch2["lip"]=='1'){
		?>
				<input type="checkbox" name="lip"id = "lip" checked='checked' value="1"> ลิฟท์กว้าง
				<?php
			}else{
			?>

				<input type="checkbox" name="lip"id = "lip" value="1"> ลิฟท์กว้าง

				<?php
		}
				?>
			</div>
			<div class="w3-bar 9">
				<input name="lip_big" class="w3-input" type='text' id="lip_big" value="<?php echo $fetch2["lip_big"]; ?>" style="width:90%;" placeholder="เมตร" />
			</div>
			<div class="w3-bar 10">
				สูง
				<input name="lip_long" class="w3-input" type='text' id="lip_long" value="<?php echo $fetch2["lip_long"]; ?>" style="width:90%;" placeholder="เมตร" />
			</div>
			<div class="w3-bar 11">
				รับน้ำหนักได้ 
				<input name="lip_weight" class="w3-input" type='text' id="lip_weight" value="<?php echo $fetch2["lip_weight"]; ?>" style="width:90%;" />
			</div>
			
		</div>
		<div class="w3-third 312">
			<div class="w3-bar 12">
		<?php
		if ($fetch2["up"]=='1'){
		?>
				<input type="checkbox" name="up"id ="up" checked='checked' value="1"> ขึ้นลิฟท์ได้
				<?php
		}else{
			?>
				<input type="checkbox" name="up"id ="up" value="1"> ขึ้นลิฟท์ได้

				<?php
		}
				?>
			</div>
			<div class="w3-bar 13">
			<?php
		if ($fetch2["no_up"]=='1'){
		?>
				<input type="checkbox" name="no_up"id ="no_up" checked='checked' value="1"> ขึ้นลิฟท์ไม่ได้
				<?php
				}else{
			?>
		<input type="checkbox" name="no_up"id ="no_up" value="1"> ขึ้นลิฟท์ไม่ได
				<?php
		}
				?>
			</div>
			<div class="w3-bar 14">
			<?php
		if ($fetch2["head_bad"]=='1'){
		?>
				<input type="checkbox" name="head_bad"id ="head_bad" checked='checked' value="1"> ต้องถอดหัวเตียง-ท้ายเตียง
				<?php
				}else{
			?>
				<input type="checkbox" name="head_bad"id ="head_bad" value="1"> ต้องถอดหัวเตียง-ท้ายเตียง

				<?php
		}
				?>
			</div>
			<div class="w3-bar 15">
			<?php
		if ($fetch2["want_employee"]=='1'){
		?>
				<input type="checkbox" name="want_employee"id ="want_employee" checked='checked' value="1"> ต้องการเจ้าหน้าที่ย้ายเฟอร์นิเจอร์
		<?php
				}else{
			?>
				<input type="checkbox" name="want_employee"id ="want_employee" value="1"> ต้องการเจ้าหน้าที่ย้ายเฟอร์นิเจอร์

				<?php
		}
				?>
			
			</div>
			<div class="w3-bar 16">
				จำนวนคนที่ใช้ 
				<input name="employee_unit" class="w3-input" type='text' value="<?php echo $fetch2["employee_unit"]; ?>" id="employee_unit" style="width:90%;" />
			</div>
			<div class="w3-bar 17">
				ย้ายเฟอร์นิเจอร์ 
				<input name="ferniger_name" class="w3-input" type='text' id="ferniger_name" value="<?php echo $fetch2["ferniger_name"]; ?>" style="width:90%;" />
			</div>
			<div class="w3-bar 18">
				ย้ายไปที่ 
				<input name="ferniger_address" class="w3-input" type='text' id="ferniger_address" value="<?php echo $fetch2["ferniger_address"]; ?>" style="width:90%;" />
			</div>
			<div class="w3-bar">
		<?php
		if ($fetch2["want_ex"]=='1'){
		?>
				<input type="checkbox" name="want_ex"id = "want_ex" checked='checked' value="1"> ต้องเตรียมอุปกรณ์ไปถอดประกอบ
				<?php
			}else{
			?>
				<input type="checkbox" name="want_ex"id = "want_ex" value="1"> ต้องเตรียมอุปกรณ์ไปถอดประกอบ

				<?php
		}
			?>
			</div>
			<div class="w3-bar">
		<?php
		if ($fetch2["want_credit"]=='1'){
		?>

				<input type="checkbox" name="want_credit"id = "want_credit" checked='checked' value="1"> ต้องเตรียมเครื่องรูดบัตร
		<?php
			}else{
					?>
				<input type="checkbox" name="want_credit"id = "want_credit" value="1"> ต้องเตรียมเครื่องรูดบัตร

						<?php
				}
						?>

			</div>
			<div class="w3-bar">
				ธนาคาร 
				<input name="bank" class="w3-input" type='text' id="bank" value="<?php echo $fetch2["bank"]; ?>" style="width:90%;" />
			</div>
			<div class="w3-bar">
		<?php
		if ($fetch2["want_prem"]=='1'){
		?>
				<input type="checkbox" name="want_prem"id ="want_prem" checked='checked' value="1"> ต้องการให้เตรียมฟรีมยืดไปซิวเก็บเตียงหรือที่นอนเก่า
				<?php
			}else{
					?>
				<input type="checkbox" name="want_prem"id ="want_prem" value="1"> ต้องการให้เตรียมฟรีมยืดไปซิวเก็บเตียงหรือที่นอนเก่า

						<?php
				}
						?>
			</div>
			<div class="w3-bar">
				รายละเอียดเพิ่มเติม
				<textarea name="description_ja" class="w3-input" id="description_ja" cols="54" rows="1" style="width:90%;"><?php echo $fetch2["description"]; ?></textarea>
			</div>
		</div>
	
	</fieldset>



<?php
		}
		?>



</div>

<?php } ?>
	
	<br></div>
<div class="w3-bar w3-center">
			<input type="submit" name="submit" class="w3-button w3-teal be-border" value="บันทึกข้อมูล">
	</div><br>
	</form></div>

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