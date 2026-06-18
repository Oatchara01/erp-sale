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
</script>
<div class='w3-container'>
	<div class='w3-panel w3-light-grey'>
		<span><h3>Sale Order</h3></span>
	</div>
	<div class='w3-bar w3-margin-bottom'>
		<input type='radio' name='company' value='21'><b> Phartrillion</b> <input type='radio' name='company' value='22'><b> Noble Med</b>
	</div>
	<div class='w3-half'>
		<div class='w3-half 1.1 w3-bar w3-margin-bottom'>
			<span>วันที่</span>
			<input type='text' name='date' class='w3-input' style='width:90%;' value='<?php echo DateThai(date('Y-m-d')); ?>'>
		</div>
		<div class='w3-half 1.2 w3-bar w3-margin-bottom'>
			<span>เลขที่อ้างอิง</span>
			<input type='text' name='ref_id' class='w3-input' style='width:90%;' value='<?php $ref='select ref_id from so__main order by ref_id desc limit 1'; $qref=mysqli_query($conn,$ref); $fref=mysqli_fetch_array($qref); echo $fref['ref_id']+1; ?>' readonly>
			<input type='hidden' name='main_id' class='w3-input' style='width:90%;' value='<?php $main='select main_id from so__main order by main_id desc limit 1'; $qmain=mysqli_query($conn,$main); $fmain=mysqli_fetch_array($qmain); echo $fmain['main_id']+1; ?>' readonly>
		</div>
		<div class='w3-half 2.1 w3-bar w3-margin-bottom'>
			<span>เลขที่ลงงาน</span>
			<input type='text' name='job_id' class='w3-input' style='width:90%;'>
		</div>
		<div class='w3-half 2.2 w3-bar w3-margin-bottom'>
			<span>ฝากสินค้าเลขที่</span>
			<input type='text' name='deposit_no' class='w3-input' style='width:90%;'>
		</div>
		<div class='w3-half 3.1 w3-bar w3-margin-bottom'>
			<span>ช่องทางการขาย</span>
			<input type='text' name='sale_channel' list='sale_channel' class='w3-input' style='width:90%;'>
				<datalist id="sale_channel">
						<option>Sale</option>
				</datalist>
		</div>
		<div class='w3-half 3.2 w3-bar w3-margin-bottom'>
			<span>ใบสั่งซื้อเลขที่</span>
			<input type='text' name='po_no' class='w3-input' style='width:90%;'>
		</div>
		<div class='w3-bar w3-margin-bottom'>
			<span>กำหนดส่งตามสัญญา</span>
			<input type='text' name='delivery_contract' class='w3-input' style='width:95%;'>
		</div>
	</div>
	<div class='w3-half'>
		<div class='w3-half 1.1 w3-bar w3-margin-bottom'>
			<span>ชื่อที่ต้องการออกบิล</span>
			<input type='text' name='billing_name' class='w3-input' style='width:90%;'>
		</div>
		<div class='w3-half 1.2 w3-bar w3-margin-bottom'>
			<span>ที่อยู่ที่ต้องการออกบิล</span>
			<textarea name='billing_address' class='w3-input' rows='2' style='width:90%;'></textarea>
		</div>
		<div class='w3-half 2.1 w3-bar w3-margin-bottom'>
			<span>เบอร์โทรศัพท์</span>
			<input type='tel' name='billing_tel' class='w3-input' style='width:90%;'>
		</div>
		<div class='w3-half 2.2 w3-bar w3-margin-bottom'>
			<span>ชำระโดย</span>
			<select name="payment" class="w3-select w3-light-grey" style="width:90%; height:90%;" onchange="if(this.options[this.selectedIndex].value=='customOption'){ toggleField(this,this.nextSibling); this.selectedIndex='0';	}">
				<option></option>
				<option>เงินสด (C.O.D.)</option>
				<option>Cr.30 วัน</option>
				<option>Cr.45 วัน</option>
				<option value="customOption">อื่น ๆ (พิมพ์)</option>
			</select><input name="payment" style="display:none; width:90%;" class="w3-input" disabled="disabled" onblur="if(this.value==''){toggleField(this,this.previousSibling);}">
		</div>
		<div class='w3-half 3.1 w3-bar w3-margin-bottom'>
			<span>สถานที่ส่งสินค้า</span>
			<textarea name='delivery_place' class='w3-input' rows='2' style='width:90%;'></textarea>
		</div>
		<div class='w3-half 3.2 w3-bar w3-margin-bottom'>
			<span>ชื่อผู้ติดต่อ/โทร</span>
			<input type='text' name='delivery_contact' class='w3-input' style='width:90%;'>
		</div>
	</div>
	<div class='w3-bar'></div>
	<div class='w3-half'>
		<span>รายการของแถม</span>
		<textarea name='free_item' rows='3' class='w3-input' style='width:90%;'></textarea>
	</div>
	<div class='w3-half'>
		<div class="w3-bar w3-pale-blue">
			<a class="w3-bar-item w3-button" onclick="openTab('1')"><b>เพิ่มเติม</b></a>
			<a class="w3-bar-item w3-button" onclick="openTab('2')"><b>การจัดส่ง</b></a>
		</div>
		<div id="1" class="tab w3-padding-small">
			<div class="w3-half w3-container w3-padding-small">
				<div class="w3-bar"><input type="checkbox" name="clear_book_ckk" value="1"> Clear ใบจองสินค้า เลขที่ <input type="text" name="clear_book_no" class="w3-input" style="width:90%;"></div>
				<div class="w3-bar"><input type="checkbox" name="clear_brn_no_ckk" value="1"> Clear ใบยืมสินค้าติดเล่ม <input type="text" name="clear_brn_no" class="w3-input" style="width:90%;" placeholder="BRN No."></div>
				<div class="w3-bar"><input type="checkbox" name="clear_brnp_no_ckk" value="1"> Clear ใบยืมฯ กระดาษต่อเนื่อง <input type="text" name="clear_brnp_no" class="w3-input" style="width:90%;" placeholder="BRN P No."></div>
				<div class="w3-bar">สถานที่ติดตั้งเครื่อง <input name="install_place" class="w3-input" style="width:90%;"></div>					
			</div>
			<div class="w3-half w3-padding-small">
				<div class="w3-bar">BQ เลขที่ <input type="text" name="bq" class="w3-input" style="width:90%;"></div>
				<div class="w3-bar">OT เลขที่ <input type="text" name="ot" class="w3-input" style="width:90%;"></div>	
				<div class="w3-bar"><input type="checkbox" name="with_pr" value="1"> แนบใบเสนอราคา</div>
				<div class="w3-bar"><input type="checkbox" name="type_com" value="1"> พิมพ์ตามคอม</div>
				<div class="w3-bar"><input type="checkbox" name="type_po" value="1"> พิมพ์ตามใบสั่งซื้อ</div>
				<div class="w3-bar">พิมพ์ตามที่เขียน <textarea name="type_type_detail" rows="1" class="w3-input" style="width:90%;"></textarea></div>		
			</div>
		</div>
		<div id="2" class="tab w3-padding-small" style="display:none">
			<div class="w3-bar w3-padding-small">
				<div class="w3-half"><input type="radio" name="delivery_type" value="1"> บริษัทจัดส่ง</div>
				<div class="w3-half"><input type="radio" name="delivery_type" value="2"> ส่งสินค้าแผนกช่าง</div>
			</div>
			<div class="w3-bar w3-padding-small">
				<div class="w3-half"><input type="radio" name="delivery_type" value="3"> Sale รับเอง</div>
				<div class="w3-half"><input type="radio" name="delivery_type" value="4"> ลูกค้ารับเอง</div>
			</div>
			<div class="w3-bar w3-padding-small">
				<div class="w3-half">วันที่จัดส่ง<input type="text" name="delivery_date" class="w3-input" style="width:90%;"></div>
				<div class="w3-half">เวลาที่จัดส่ง<input type="text" name="delivery_time" class="w3-input" style="width:90%;"></div>
			</div>
			<div class="w3-bar w3-padding-small">
				<div class="w3-half"><input type="checkbox" name="big_car" value="1"> ต้องการรถใหญ่</div>
				<div class="w3-half"><input type="checkbox" name="maps" value="1"> มีแผนที่ประกอบ</div>
			</div>
			<div class="w3-bar w3-padding-small">
				<div class="w3-half"><input type="checkbox" name="call_before" value="1"> แจ้งลูกค้าก่อนส่ง</div>
				<div class="w3-half"><input type="checkbox" name="assign_date_time" value="1"> นัดวันและเวลาเรียบร้อยแล้ว</div>
			</div>
			<div class="w3-bar w3-padding-small">
				Sale Comment<textarea name="sale_remark" rows="1" class="w3-input"></textarea>
			</div>
		</div>
	</div>
	<div class="w3-bar w3-margin-bottom w3-margin-top"></div>
			<?php include ('product_sale_hos.php'); ?>
		<div class="w3-bar w3-center">
			<input type="submit" name="submit" class="w3-button w3-teal be-border" value="บันทึกข้อมูล">
		</div>
	</div>
	</form>
</div>
<?php include('foot.php'); ?>