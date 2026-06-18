<?php include('head.php'); ?>
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

	function ck_type_document1(){
		var ck = document.getElementById('type_document1');
		if(ck.checked == true){
			document.getElementById('frm_type_document1').style.display = "";
		}else{
			document.getElementById('frm_type_document1').style.display = "none";
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
	function qtype() {
		if (document.getElementById('type1').checked) {
			document.getElementById('detail').style.display = 'none';
		}
		else if (document.getElementById('type2').checked) {
			document.getElementById('detail').style.display = 'none';
		}
		else if (document.getElementById('type3').checked) {
			document.getElementById('detail').style.display = 'block';
		}
	}
	function openmaps() {
		if (document.getElementById('mapn').checked) {
			document.getElementById('ityes').style.display = 'block';
		}
		else {
			document.getElementById('ityes').style.display = 'none';
		}
	}
</script>
<?php
	include("dbconnect.php");
	if ($_GET["ref_id"]) {
		$ref_id = $_GET["ref_id"];
		$admin = "select * from hos__so where ref_id='$ref_id'";
		$qadmin = mysqli_query($conn,$admin);
		$fadmin = mysqli_fetch_array($qadmin,MYSQLI_ASSOC);
?>
<div class="w3-container">
	<div class="w3-panel w3-light-grey"><h3>Admin Sale Order</h3></div>
	<form action="admin_sale_hos1.php" method="post" name="frmMain">
	<div class="w3-bar">
		<!-- -->
		<input type="hidden" name="id" value="<?php echo $fadmin['id']; ?>">
		<input type="hidden" name="main_id" value="<?php echo $fadmin['main_id']; ?>">
		<!-- -->
		<?php if ($fadmin["company"] == 1) { ?>
			<input type="radio" name="company" value="1" checked> Phar Trillion
			<input type="radio" name="company" value="2"> Noble Med
		<?php } else if ($fadmin["company"] == 2) { ?>
			<input type="radio" name="company" value="1"> Phar Trillion
			<input type="radio" name="company" value="2" checked> Noble Med
		<?php } ?>
	</div>
	
	<div class="w3-bar"></div>
	<div class="w3-bar w3-margin-bottom"></div>
		<div class="w3-half"><!--ครึ่งแรก-->
			<div class="w3-half 11">
				<div class="w3-half">
					วันที่ <input type="text" name="date" class="w3-input" style="width:80%;" value="<?php echo datethai($fadmin["date"]); ?>" readonly>
				</div>
				<div class="w3-half">
					เลขที่อ้างอิง <input type="text" name="ref_id" class="w3-input" style="width:80%;" value="<?php echo $fadmin["ref_id"]; ?>" readonly>
				</div>
			</div>
			<div class="w3-half 12">
				<div class="w3-half">
					เลขที่ลงงาน <input type="text" name="job_no" class="w3-input" style="width:80%;" value="<?php echo $fadmin["job_no"]; ?>">
				</div>
				<div class="w3-half">
					ฝากสินค้าเลขที่ <input type="text" name="dep_no" class="w3-input" style="width:80%;" value="<?php echo $fadmin["dep_no"]; ?>">
				</div>
			</div>
			<div class="w3-bar w3-padding-small"></div>
			<div class="w3-half 21">
				ช่องทางการขาย <input type="text" name="sale_channel" list="sale_channel" class="w3-input" style="width:90%;" value="<?php echo $fadmin["sale_channel"]; ?>">
			</div>
			<div class="w3-half 22">
				ชื่อผู้แนะนำ/ร.พ./แผนก <input type="text" name="suggest" class="w3-input" style="width:90%;" value="<?php echo $fadmin["suggest"]; ?>">
			</div>
			<div class="w3-bar w3-padding-small"></div>
			<div class="w3-half 31">
				ชื่อที่ต้องการออกบิล <input type="text" name="bill_name" class="w3-input" style="width:90%;" value="<?php echo $fadmin["bill_name"]; ?>">
			</div>
			<div class="w3-half 32">
				ที่อยู่ที่ใช้ในการออกบิล <input type="text" name="bill_address" class="w3-input" style="width:90%" value="<?php echo $fadmin["bill_address"]; ?>">
			</div>
			<div class="w3-bar w3-padding-small"></div>
			<div class="w3-half 24">
				เบอร์โทรศัพท์ <input type="text" name="bill_tel" class="w3-input" style="width:90%;" value="<?php echo $fadmin["bill_tel"]; ?>">
			</div>
			<div class="w3-half 242">
				ชำระโดย <select name="payment" class="w3-select" style="width:90%; height:90%;"
						onchange="if(this.options[this.selectedIndex].value=='customOption'){
						toggleField(this,this.nextSibling);
						this.selectedIndex='0';
				}">
						<option value="<?php echo $fadmin["payment"]; ?>"><?php echo $fadmin["payment"]; ?></option>
						<option>เงินสด (C.O.D.)</option>
						<option>Cr.30 วัน</option>
						<option>Cr.45 วัน</option>
						<option value="customOption">อื่น ๆ (พิมพ์)</option>
					</select><input name="payment" style="display:none; width:90%;" class="w3-input" disabled="disabled" onblur="if(this.value==''){toggleField(this,this.previousSibling);}">
			</div>				
			
			<div class="w3-bar w3-padding-small"></div>
			<div class="w3-half 31">
				สถานที่ส่งสินค้า <input name="delivery_place" class="w3-input" style="width:90%;" value="<?php echo $fadmin["delivery_place"]; ?>">
			</div>
			<div class="w3-half 32">
				ชื่อผู้ติดต่อ/โทร <input type="text" name="delivery_contact" class="w3-input" style="width:90%;" value="<?php echo $fadmin["delivery_contact"]; ?>">
			</div>
			<div class="w3-bar w3-padding-small"></div>
			<div class="w3-half 33">
				ใบสั่งซื้อเลขที่ <input type="text" name="po_no" class="w3-input" style="width:90%;" value="<?php echo $fadmin["po_no"]; ?>">
			</div>
			<div class="w3-half 34">
				กำหนดส่งตามสัญญา <input type="text" name="delivery_contract" class="w3-input" style="width:90%;" value="<?php echo $fadmin["delivery_contract"]; ?>">
			</div>
			<div class="w3-bar w3-margin-bottom"></div>
		</div><!-- จบครึ่งแรก -->
		<div class="w3-half"><!-- ครึ่งสอง -->
			<div class="w3-bar w3-pale-blue">
				<a class="w3-bar-item w3-button" onclick="openTab('1')"><b>เพิ่มเติม</b></a>
				<a class="w3-bar-item w3-button" onclick="openTab('2')"><b>การจัดส่ง</b></a>
				<a class="w3-bar-item w3-button" onclick="openTab('3')"><b>พิมพ์</b></a>
			</div>
			<div id="3" class="tab w3-padding-small" style="display:none">
				<div class="w3-half w3-container w3-padding-small">
					<div class="w3-bar">ใบปะหน้ากล่อง</div>
			<div class="w3-bar w3-half 1">
				<a href="report_99std.php?ref_id=<?php echo $fadmin["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DarkViolet">99std</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 1">
				<a href="report_99std_k.php?ref_id=<?php echo $fadmin["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DarkViolet">99std+k</font></a>
			</div>
			<div class="w3-bar w3-half 2">
				<a href="report_a5ptl.php?ref_id=<?php echo $fadmin["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a5ptl</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 2">
				<a href="report_a5ptl_k.php?ref_id=<?php echo $fadmin["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a5ptl+k</font></a>
			</div>
			<div class="w3-bar w3-half 3">
				<a href="report_a4ptl.php?ref_id=<?php echo $fadmin["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a4ptl</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 3">
				<a href="report_a4ptl_k.php?ref_id=<?php echo $fadmin["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="Blue">a4ptl+k</font></a>
			</div>
			<div class="w3-bar w3-half 4">
				<a href="report_a5nbm.php?ref_id=<?php echo $fadmin["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DeepPink">a5nbm</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 4">
				<a href="report_a5nbm_k.php?ref_id=<?php echo $fadmin["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DeepPink">a5nbm+k</font></a>
			</div>
			<div class="w3-bar w3-half 5">
				<a href="report_a4nbm.php?ref_id=<?php echo $fadmin["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DeepPink">a4nbm</font></a>
			</div>
			<div class="w3-bar w3-half w3-margin-bottom 5">
				<a href="report_a4nbm_k.php?ref_id=<?php echo $fadmin["ref_id"];?>" target="_blank" class="w3-button w3-grey" style="width:90%;"><font color="DeepPink">a4nbm+k</font></a>
			</div>
				</div>
			</div>
			<div id="1" class="tab w3-padding-small">
				<div class="w3-half w3-container w3-padding-small">
					<?php if ($fadmin["book_clear"]==1) { ?>
						<div class="w3-bar"><input type="checkbox" name="book_clear" value="1" checked> Clear ใบจองสินค้า เลขที่ <input type="text" name="brn_no" class="w3-input" style="width:90%;" value="<?php echo $fadmin["book_no"]; ?>"></div>
					<?php } else if ($fadmin["book_clear"]==0) { ?>
						<div class="w3-bar"><input type="checkbox" name="book_clear" value="1"> Clear ใบจองสินค้า เลขท <input type="text" name="brn_no" class="w3-input" style="width:90%;" value="<?php echo $fadmin["book_no"]; ?>"></div>
					<?php } ?>

					<div class="w3-padding-small"></div>

					<?php if ($fadmin["brn_clear"]==1) { ?>
						<div class="w3-bar"><input type="checkbox" name="brn_clear" value="1" checked> Clear ใบยืมสินค้าติดเล่ม <input type="text" name="brn_no" class="w3-input" style="width:90%;" value="<?php echo $fadmin["brn_no"]; ?>"></div>
					<?php } else if ($fadmin["brn_clear"]==0) { ?>
						<div class="w3-bar"><input type="checkbox" name="brn_clear" value="1"> Clear ใบยืมสินค้าติดเล่ม <input type="text" name="brn_no" class="w3-input" style="width:90%;" value="<?php echo $fadmin["brn_no"]; ?>"></div>
					<?php } ?>

					<div class="w3-padding-small"></div>

					<?php if ($fadmin["brnp_clear"]==1) { ?>
						<div class="w3-bar"><input type="checkbox" name="brnp_clear" value="1" checked> Clear ใบยืมฯ กระดาษต่อเนื่อง <input type="text" name="brnp_no" class="w3-input" style="width:90%;" value="<?php echo $fadmin["brnp_no"]; ?>"></div>
					<?php } else if ($fadmin["brnp_clear"]==0) { ?>
						<div class="w3-bar"><input type="checkbox" name="brnp_clear" value="1" checked> Clear ใบยืมฯ กระดาษต่อเนื่อง <input type="text" name="brnp_no" class="w3-input" style="width:90%;" value="<?php echo $fadmin["brnp_no"]; ?>"></div>
					<?php } ?>

					<div class="w3-padding-small"></div>

					<div class="w3-bar">สถานที่ติดตั้งเครื่อง <input name="installed" class="w3-input" style="width:90%;" value="<?php echo $fadmin["installed"]; ?>"></div>					
				</div>
				<div class="w3-half w3-padding-small">
					<div class="w3-bar">BQ เลขที่ <input type="text" name="bq" class="w3-input" style="width:90%;" value="<?php echo $fadmin["bq"]; ?>"></div>
					<div class="w3-padding-small"></div>
					<div class="w3-bar">OT เลขที่ <input type="text" name="ot" class="w3-input" style="width:90%;" value="<?php echo $fadmin["ot"]; ?>"></div>	
					<div class="w3-padding-small"></div>
					<div class="w3-bar w3-half">
						<?php if ($fadmin["with_pr"]==1) { ?>
							<input type="checkbox" name="with_pr" value="1" checked> แนบใบเสนอราคา
						<?php } else if ($fadmin["with_pr"]==0) { ?>
							<input type="checkbox" name="with_pr" value="1"> แนบใบเสนอราคา
						<?php } ?>
					</div>
					<div class="w3-bar w3-half">
						<?php if ($fadmin["full_bill"]==1) { ?>
							<input type="checkbox" name="full_bill" value="1" checked> ต้องการบิลเต็มรูปแบบ
						<?php } else if ($fadmin["full_bill"]==0) { ?>
							<input type="checkbox" name="full_bill" value="1"> ต้องการบิลเต็มรูปแบบ
						<?php } ?>
					</div>
					<div class="w3-padding-small"></div>
					<?php if ($fadmin["type_type"]==1) { ?>
						<div class="w3-bar"><input type="radio" onclick="javascript:qtype();" name="type_type" value="1" id="type1" checked> พิมพ์ตามคอม</div>
						<div class="w3-bar"><input type="radio" onclick="javascript:qtype();" name="type_type" value="2" id="type2"> พิมพ์ตามใบสั่งซื้อ</div>
						<div class="w3-bar"><input type="radio" onclick="javascript:qtype();" name="type_type" value="3" id="type3"> พิมพ์ตามที่เขียน
							<div id="detail" style="display:none">
								<textarea name="type_detail" class="w3-input" style="width:90%;"></textarea>
							</div>
						</div>
					<?php } else if ($fadmin["type_type"]==2) { ?>
						<div class="w3-bar"><input type="radio" onclick="javascript:qtype();" name="type_type" value="1" id="type1"> พิมพ์ตามคอม</div>
						<div class="w3-bar"><input type="radio" onclick="javascript:qtype();" name="type_type" value="2" id="type2" checked> พิมพ์ตามใบสั่งซื้อ</div>
						<div class="w3-bar"><input type="radio" onclick="javascript:qtype();" name="type_type" value="3" id="type3"> พิมพ์ตามที่เขียน
							<div id="detail" style="display:none">
								<textarea name="type_detail" class="w3-input" style="width:90%;"></textarea>
							</div>
						</div>
					<?php } else if ($fadmin["type_type"]==3) { ?>
						<div class="w3-bar"><input type="radio" onclick="javascript:qtype();" name="type_type" value="1" id="type1"> พิมพ์ตามคอม</div>
						<div class="w3-bar"><input type="radio" onclick="javascript:qtype();" name="type_type" value="2" id="type2"> พิมพ์ตามใบสั่งซื้อ</div>
						<div class="w3-bar"><input type="radio" onclick="javascript:qtype();" name="type_type" value="3" id="type3" checked> พิมพ์ตามที่เขียน
							<div id="detail">
								<textarea name="type_detail" class="w3-input" style="width:90%;"><?php echo $fadmin["type_detail"]; ?></textarea>
							</div>
						</div>
					<?php } ?>
				</div>
			</div>
			<div id="2" class="tab w3-padding-small" style="display:none">
			<?php if ($fadmin["delivery_choice"]==1) { ?>
				<div class="w3-bar w3-padding-small">
					<div class="w3-half"><input type="radio" name="delivery_choice" value="1" checked> บริษัทจัดส่ง</div>
					<div class="w3-half"><input type="radio" name="delivery_choice" value="2" > ส่งสินค้าแผนกช่าง</div>
				</div>
				<div class="w3-bar w3-padding-small">
					<div class="w3-half"><input type="radio" name="delivery_choice" value="3" > Sale รับเอง</div>
					<div class="w3-half"><input type="radio" name="delivery_choice" value="4" > ลูกค้ารับเอง</div>
				</div>
			<?php } else if ($fadmin["delivery_choice"]==2) { ?>
				<div class="w3-bar w3-padding-small">
					<div class="w3-half"><input type="radio" name="delivery_choice" value="1" > บริษัทจัดส่ง</div>
					<div class="w3-half"><input type="radio" name="delivery_choice" value="2" checked> ส่งสินค้าแผนกช่าง</div>
				</div>
				<div class="w3-bar w3-padding-small">
					<div class="w3-half"><input type="radio" name="delivery_choice" value="3" > Sale รับเอง</div>
					<div class="w3-half"><input type="radio" name="delivery_choice" value="4" > ลูกค้ารับเอง</div>
				</div>
			<?php } else if ($fadmin["delivery_choice"]==3) { ?>
				<div class="w3-bar w3-padding-small">
					<div class="w3-half"><input type="radio" name="delivery_choice" value="1" > บริษัทจัดส่ง</div>
					<div class="w3-half"><input type="radio" name="delivery_choice" value="2" > ส่งสินค้าแผนกช่าง</div>
				</div>
				<div class="w3-bar w3-padding-small">
					<div class="w3-half"><input type="radio" name="delivery_choice" value="3" checked> Sale รับเอง</div>
					<div class="w3-half"><input type="radio" name="delivery_choice" value="4" > ลูกค้ารับเอง</div>
				</div>
			<?php } else if ($fadmin["delivery_choice"]==4) { ?>
				<div class="w3-bar w3-padding-small">
					<div class="w3-half"><input type="radio" name="delivery_choice" value="1" > บริษัทจัดส่ง</div>
					<div class="w3-half"><input type="radio" name="delivery_choice" value="2" > ส่งสินค้าแผนกช่าง</div>
				</div>
				<div class="w3-bar w3-padding-small">
					<div class="w3-half"><input type="radio" name="delivery_choice" value="3" > Sale รับเอง</div>
					<div class="w3-half"><input type="radio" name="delivery_choice" value="4" checked> ลูกค้ารับเอง</div>
				</div>
			<?php } ?>
				<div class="w3-bar w3-padding-small">
					<div class="w3-half">วันที่จัดส่ง<input type="text" name="delivery_date" class="w3-input" style="width:90%;" value="<?php echo $fadmin["delivery_date"]; ?>"></div>
					<div class="w3-half">เวลาที่จัดส่ง<input type="text" name="delivery_time" class="w3-input" style="width:90%;" value="<?php echo $fadmin["delivery_time"]; ?>"></div>
				</div>
				<div class="w3-bar w3-padding-small">
				<?php if ($fadmin["big_car"]==1) { ?>
					<div class="w3-half"><input type="checkbox" name="big_car" value="1" checked> ต้องการรถใหญ่</div>
				<?php } else if ($fadmin["big_car"]==0) { ?>
					<div class="w3-half"><input type="checkbox" name="big_car" value="1"> ต้องการรถใหญ่</div>
				<?php } ?>
				<?php if ($fadmin["map"]==1) { ?>
					<div class="w3-half"><input type="checkbox" name="map" id="mapn" value="1" onclick="javascript:openmaps();" checked> มีแผนที่ประกอบ
						<a href="map/<?php echo $fadmin["mapfile"]; ?>" target="_blank">คลิกเพื่อดูแผนที่</a>
					</div>
				<?php } else if ($fadmin["map"]==0) { ?>
					<div class="w3-half"><input type="checkbox" name="map" id="mapn" value="1" onclick="javascript:openmaps();" checked> มีแผนที่ประกอบ
						<div id="ityes" style="display:none">
							<input type="file" name="mapfile" id="mapfile" class="w3-input" style="width:90%">
						</div>
					</div>
				<?php } ?>
				</div>
				<div class="w3-bar w3-padding-small">
				<?php if ($fadmin["call_before"]==1) { ?>
					<div class="w3-half"><input type="checkbox" name="call_before" value="1" checked> แจ้งลูกค้าก่อนส่ง</div>
				<?php } else if ($fadmin["call_before"]==0) { ?>
					<div class="w3-half"><input type="checkbox" name="call_before" value="1"> แจ้งลูกค้าก่อนส่ง</div>
				<?php } ?>
				<?php if ($fadmin["assign"]==1) { ?>
					<div class="w3-half"><input type="checkbox" name="assign" value="1" checked> นัดวันและเวลาเรียบร้อยแล้ว</div>
				<?php } else if ($fadmin["assign"]==0) { ?>
					<div class="w3-half"><input type="checkbox" name="assign" value="1"> นัดวันและเวลาเรียบร้อยแล้ว</div>
				<?php } ?>
				</div>
				<div class="w3-bar w3-padding-small"></div>
					Sale Comment<textarea name="sale_comment" rows="1" class="w3-input"><?php echo $fadmin['sale_comment']; ?></textarea>
				</div>
			<div class="w3-bar w3-padding-small"></div>
			
			<div class="w3-bar">
				<div class="w3-half">
					Sale
					<input type="hidden" name="sale" value="<?php echo $fadmin['sale']; ?>">
					<input type="text" name="sale_name" class="w3-input w3-center" style="width:90%;" value="<?php $sales = $fadmin['sale']; $salen=mysqli_query($conn,"select * from tb_user where em_id='$sales'"); $fsalen = mysqli_fetch_array($salen); echo $fsalen['name'].'&nbsp;'.$fsalen['surname']; ?>" readonly>
					<input type="text" name="sale_date" class="w3-input w3-center" style="width:90%;" value="<?php echo datethai($fadmin['sale_date']); ?>" readonly>
				</div>
				<div class="w3-half">
					Approve
					<input type="hidden" name="approve" value="<?php echo $fadmin['approve']; ?>">
					<input type="text" name="approve_name" class="w3-input w3-center" style="width:90%;" value="<?php $approves=$fadmin['approve']; $approven=mysqli_query($conn,"select * from tb_user where em_id='$approves'"); $fapproven = mysqli_fetch_array($approven); echo $fapproven['name']." ".$fapproven['surname']; ?>">
					<input type="text" name="sale_date" class="w3-input w3-center" style="width:90%;" value="<?php echo datethai($fadmin['approve_date']); ?>">
				</div>
			</div>			
		</div><!-- จบครึ่งสอง -->
		<div class="w3-bar w3-margin-bottom"><!-- ท่อนล่าง -->
			<?php include ('pd_ad_hos.php'); ?>
		</div><!-- จบท่อนล่าง -->
		<div class="w3-bar w3-center">
			<input type="submit" name="submit" class="w3-button w3-teal w3-border" value="save">
		</div>
	</div>
	</form>
</div>
<?php include('foot.php'); } ?>
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