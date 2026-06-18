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
}
}
}
}
</script>
<script>
	function openTab(tabName) {
		var i;
		var x = document.getElementsByClassName("tab");
		for (i = 0; i < x.length; i++) {
			x[i].style.display = "none";  
		}
		document.getElementById(tabName).style.display = "block";  
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

<div class="w3-container">
	<div class="w3-panel w3-light-grey"><h3>Register Borrow Order</h3></div>
	<form action="register_br_hos1.php" method="post" name="frmMain" enctype="multipart/form-data">
	<div class="w3-bar">
		<input type="radio" name="company" value="1" checked='checked' required> <img src="img/ptl64.png">
		<input type="radio" name="company" value="2" required> <img src="img/nbm64.png">
	</div>
	
	<div class="w3-bar w3-padding-small"></div><!-- bar -->
	<div class="w3-half 1"><!-- 1 -->
		<div class="w3-bar w3-margin-bottom">
			<span>ชื่อลูกค้า/รพ.</span> <input type="text" name="customer" id="customer" class="w3-input" style="width:90%;" OnChange="JavaScript:doCallAjax('customer','address');" required>
			<input type ='hidden' name="h_customer"  id="h_customer" class="w3-input" >
		</div>
		<div class="w3-bar w3-margin-bottom">
			<span>ที่อยู่</span> <textarea name="address" id="address" class="w3-input" style="width:90%;" rows="1"></textarea>
		</div>
		<div class="w3-bar w3-margin-bottom">
			<span>สถานที่ส่งสินค้า</span> <textarea name="delivery_place" id="delivery_place" class="w3-input" style="width:90%;" rows="1" required></textarea>
		</div>
		<div class="w3-bar w3-margin-bottom">
			<span>ชื่อผู้ติดต่อ/โทร.</span> <input type="text" name="delivery_contact" id="delivery_contact" class="w3-input" style="width:90%;" required>
		</div>
	</div><!-- 1 -->
	<div class="w3-half 2"><!-- 2 -->
		<div class="w3-bar w3-half w3-margin-bottom">
			<span>วันที่</span> <input type="date" name="date" class="w3-input" style="width:90%;" required>
		</div>
		<div class="w3-bar w3-half w3-margin-bottom">
			<span>เลขที่ BRNP</span> <input type="text" name="brnp_no" class="w3-input w3-light-grey" style="width:90%;" readonly>
		</div>
		<div class="w3-bar"></div>
		<div class="w3-bar w3-margin-bottom w3-half">
			<span>วัตถุประสงค์การเบิก</span>
			<div class="w3-panel"><input type="radio" onclick="javascript:object();" name="objective" value="1" id="object1" required> เป็นสินค้าสำรอง
				<div id="dt1" style="display:none">
					<input type="text" name="objective_des1" class="w3-input" placeholder="ใส่รายละเอียด" style="width:90%;">
				</div>
			</div>
			<div class="w3-panel"><input type="radio" onclick="javascript:object();" name="objective" value="2" id="object2" required> สำหรับลูกค้าทดลองใช้
				<div id="dt2" style="display:none">
					<input type="text" name="objective_des2" class="w3-input" placeholder="ใส่จำนวนวัน" style="width:90%;">
				</div>
			</div>
			<div class="w3-panel"><input type="radio" onclick="javascript:object();" name="objective" value="3" id="object3" required> ส่งสินค้าล่วงหน้าเพื่อรอใบสั่งซื้อ
			</div>
			<div class="w3-panel"><input type="radio" onclick="javascript:object();" name="objective" value="4" id="object4" required> แลกเปลี่ยนสินค้าตามใบงานบริการเลขที่
				<div id="dt4" style="display:none">
					<input type="text" name="objective_des4" class="w3-input" placeholder="ใส่เลขที่ใบงานบริการ" style="width:90%;">
				</div>
			</div>
			<div class="w3-panel"><input type="radio" onclick="javascript:object();" name="objective" value="5" id="object5" required> อื่น ๆ
				<div id="dt5" style="display:none">
					<input type="text" name="objective_des5" class="w3-input" placeholder="ใส่รายละเอียดเพิ่มเติม" style="width:90%;">
				</div>
			</div>
		</div>
	</div><!-- 2 -->
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
	</div>

	<div class="w3-bar w3-margin-bottom"></div>
	
	<div class="w3-bar w3-pale-green">
		<a class="w3-bar-item w3-button" onclick="openTab('14')"><b>ข้อมูลสินค้า</b></a>
		<a class="w3-bar-item w3-button" onclick="openTab('3')"><b>การจัดส่ง</b></a>
		<a class="w3-bar-item w3-button" onclick="openTab('55')"><b>การรับคืน</b></a>
	</div>
	<div id="14" class="tab w3-bar w3-margin-bottom">
		<?php include ('product_br_hos.php'); ?>
	</div><!-- 14 -->
	<div id="3" class="tab w3-padding-small" style="display:none">
		<input type="radio" name="delivery_type" value="1" onclick="javascript:ckk_2();" id="object8">&nbsp;Sale รับเอง
		<input type="radio" name="delivery_type" value="2"  onclick="javascript:ckk_2();" id="object9">&nbsp;ช่างรับเอง<br />
		<input type="radio" name="delivery_type" value="3"  onclick="javascript:ckk_2();" id="object10">&nbsp;ลูกค้ารับเอง 
		<input type="radio" name="delivery_type" value="4"  onclick="javascript:ckk_2();" id="object11">&nbsp;บริษัทจัดส่ง <br />
			<div id="dv1" style="display:none"><!-- dv1 -->
				<div class="w3-half w3-container"><!-- first half -->
					วันที่รับ/ส่ง
					<input type="date" name="delivery_date" class="w3-input">
					เวลารับ/ส่ง
					<input type="text" name="delivery_time" class="w3-input">
				</div><!-- first half -->
			</div><!-- dv1 -->
			<div id="dv2" style="display:none"><!-- dv2 -->
				<div class="w3-container w3-third"><!-- first third -->
					<div class="w3-bar">
						วันที่ รับ-ส่ง
						<input name="start_date" type='date' id="start_date"   class="w3-input" />
					</div>
					<div class="w3-bar w3-margin-bottom"></div>
					<div class="w3-bar">
						วันที่ต้องการโดยประมาณ
						<input name="date_requir"  class="w3-input" type='text' id="date_requir" />
					</div>
					<div class="w3-bar w3-margin-bottom"></div>
					<div class="w3-half">เวลา
						<input id="start_time"  name="start_time"  class="w3-input" type="text"  style="width:99%;"/>
					</div>
					<div class="w3-half">ถึง
						<input id="end_time" name="end_time"  class="w3-input" type="text"/>
					</div>
					<div class="w3-bar w3-margin-bottom"></div>
					<div class="w3-bar">
						สถานะการทำงาน 
						<input type='radio'  name="work_status" id = "work_status" value="ส่ง" checked="checked"/>  ส่ง
						&nbsp; <input type="radio"  name="work_status" id = "work_status" value="รับ" />  รับ
					</div>
					<div class="w3-bar w3-margin-bottom"></div>
					<div class="w3-bar">
						สถานะ 
						<input name="status_comment" type='text' id="status_comment" class="w3-input">
					</div>
					<div class="w3-bar w3-margin-bottom"></div>
					<div class="w3-bar">
						แผนก - ฝ่าย
					<input type="text" name="department_show" id="department_show" class="w3-input" value="ฝ่ายขาย" readonly>
					</div>
					<div class="w3-bar w3-margin-bottom"></div>
					<div class="w3-bar">
						ประเภทลูกค้า
						<select name="customer_typename" id="customer_typename" class="w3-select"   >
							<option value="">**โปรดเลือกประเภทลูกค้า**</option>
							<option value="ร้านขายยา">ร้านขายยา</option>
							<option value="ลูกค้าทั่วไป">ลูกค้าทั่วไป</option>
							<option value="โรงพยาบาล">โรงพยาบาล</option>
						</select>
					</div>
					<div class="w3-bar w3-margin-bottom"></div>
					<div class="w3-bar">
						หน่วยงาน
						<select name="company_name" id="company_name" class="w3-select">
							<option value="">**โปรดเลือกหน่วยงาน**</option>
							<option value="ฟาร์ ทริลเลี่ยน บจก.">ฟาร์ ทริลเลี่ยน บจก.</option>
							<option value="โนเบิล เมด บจก.">โนเบิล เมด บจก.</option>
							<option value="อื่นๆ">อื่นๆ</option>				
						</select>
					</div>
					<div class="w3-bar w3-margin-bottom"></div>
					<div class="w3-bar">
						ประเภทงาน
						<input type="text" name="department_name" id="department_name" class="w3-input" value="Sale" readonly>
						</div>
					<div class="w3-bar w3-margin-bottom"></div>
				</div><!-- first third -->
				<div class="w3-container w3-third"><!-- second third -->
					<div class="w3-bar w3-half">
						<input type="checkbox"  name="cash" id = "cash"  value="1">  เก็บเงินสด
						<input name="unit_cash" type='text' class="w3-input" id="unit_cash" style="color:black;text-align:right;width:99%;" OnChange="JavaScript:chkNum(this)">
					</div>
					<div class="w3-bar w3-half">
						<input type="checkbox"  name="check_paper" id = "check_paper" value="1">  รับเช็ค
						<input name="unit_check" type='text' class="w3-input"  id="unit_check" style="color:black;text-align:right" OnChange="JavaScript:chkNum(this)"/>
					</div>
					<div class="w3-bar w3-margin-bottom"></div>
					<div class="w3-bar w3-half">
						<input type="checkbox"  id = "credit_card" name="credit_card" value="1">  รูดการ์ด 
						<input name="unit_credit" type='text' class="w3-input"  id="unit_credit" style="color:black;text-align:right;width:99%;"  OnChange="JavaScript:chkNum(this)"/> 
					</div>
					<div class="w3-bar w3-half">
						<input type="checkbox"  id = "bill" name="bill" value="1">  วางบิล
						<input name="unit_bill" type='text' class="w3-input" style="color:black;text-align:right" id="unit_bill" OnChange="JavaScript:chkNum(this)" />
					</div>
					<div class="w3-bar w3-margin-bottom"></div>
					<div class="w3-bar w3-half">
						<input type="checkbox"  name="tran"id = "tran"  value="1">  ลูกค้าโอนเงินหน้างาน
						<input name="unit_tran" type='text' class="w3-input" id="unit_tran" style="color:black;text-align:right;width:99%;" rows="1"OnChange="JavaScript:chkNum(this)">
					</div>
					<div class="w3-bar w3-half">
						<input type="checkbox" id = "dep" name="dep" value="1">  อื่นๆ
						<input name="dept" type='text' class="w3-input"  id="dept"/>
					</div>
					<div class="w3-bar w3-margin-bottom"></div>
					<div class="w3-bar"><input type="checkbox" name="want_bus" value="1">  ต้องการรถใหญ่ </div>
					<div class="w3-bar"><input type="checkbox"  name="fix_date" id = "fix_date" value="1">  นัดวันและเวลาเรียบร้อยแล้ว </div>
					<div class="w3-bar"><input type="checkbox"  id = "no_money" name="no_money" value="1">  ไม่ต้องเก็บเงิน</div>
					<div class="w3-bar"><input type="checkbox"  id = "call_customer" name="call_customer" value="1">  โทรแจ้งลูกค้าก่อนไป</div>
					<div class="w3-bar"><input type="checkbox"  id = "call_back" name="call_back" value="1">  ต้องการให้โทรกลับเมื่อส่งสินค้าเสร็จแล้ว</div>
					<div class="w3-bar"><input type="checkbox" name="have_map" id="have_map" value="1">  มีแผนที่ประกอบ</div>
						<div id="have_map-2" style="display:none;">
							<div class="w3-bar"><input type="file" name="mapfile1"></div>
							<div class="w3-bar"><input type="file" name="mapfile2"></div>
							<div class="w3-bar"><input type="file" name="mapfile3"></div>
							<div class="w3-bar"><input type="file" name="mapfile4"></div>
							<div class="w3-bar"><input type="file" name="mapfile5"></div>
						</div>
					</fieldset>
				</div><!-- second third -->
				<div class="w3-container w3-third"><!-- third third -->
					<div class="w3-bar">
						ชื่อโรงพยาบาล
						<input type='text'  class="w3-input" name="address_name" id="address_name">  
					</div>
					<div class="w3-bar w3-margin-bottom"></div>
					<div class="w3-bar">
						  ที่อยู่ 
						<textarea class="w3-input" name="address_send" id="address_send" cols="54" rows="1"></textarea>
					</div>
					<div class="w3-bar w3-margin-bottom"></div>
					<div class="w3-bar">
						เลขที่เอกสาร/เลขที่เครื่อง 
						<textarea name="product_sn"  class="w3-input" id="product_sn" cols="54" rows="1"></textarea>
					</div>
					<div class="w3-bar w3-margin-bottom"></div>
					<div class="w3-bar">
						สินค้า/เอกสาร 
						<input ty=e"text" name="product"  class="w3-input" id="product">
					</div>
					<div class="w3-bar w3-margin-bottom"></div>
					<div class="w3-bar">
						ชื่อผู้ติดต่อ
						<input name="customer_name"  class="w3-input" type='text' id="customer_name">
					</div>
					<div class="w3-bar w3-margin-bottom"></div>
					<div class="w3-bar">
						 ผู้รับสินค้า
						<input name="customer_contact"  class="w3-input" type='text' id="customer_contact">
					</div>
					<div class="w3-bar w3-margin-bottom"></div>
					<div class="w3-bar">
						 เบอร์โทรลูกค้า 
						<input name="customer_tel"  class="w3-input" type='text' id="customer_tel">
					</div>
					<div class="w3-bar w3-margin-bottom"></div>
					<div class="w3-bar">
						รายละเอียดเพิ่มเติม 
						<textarea name="description"  class="w3-input" id="description" cols="54" rows="1"></textarea>
					</div>
					<div class="w3-bar w3-margin-bottom"></div>
				</div><!-- third third -->
				<div class="w3-bar w3-margin-bottom"></div>
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
						<div class="w3-bar w3-margin-bottom"></div>
						<div class="w3-bar 5">
							<input type="checkbox" name="height_ltd" id = "height_ltd" value="1"> มีตัวจำกัดความสูง
						</div>
						<div class="w3-bar 6">
							<input type="checkbox" name="car_load"id = "car_load" value="1"> รถยนต์สามารถเข้าได้
						</div>
						<div class="w3-bar 7">
							<input type="checkbox" name="no_car_road"id = "no_car_road" value="1"> รถยนต์เข้าไม่ได้ สามารถจอดได้ที่ <input name="car_park" class="w3-input" type='text' id="car_park" style="width:90%;" />
						</div>
						<div class="w3-bar w3-margin-bottom"></div>
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
						<div class="w3-bar w3-margin-bottom"></div>
						<div class="w3-bar 12">
							<input type="checkbox" name="slope"id = "slope" value="1"> มีทางราบก่อนประตูบ้าน
						</div>
						<div class="w3-bar 13">
							<input type="checkbox" name="bundai"id = "bundai" value="1"> มีบันไดก่อนประตูบ้าน
						</div>
						<div class="w3-bar 14">
							<input name="unit_bundai" class="w3-input" type='text' id="unit_bundai" style="width:90%;" placeholder="จำนวน (ขั้น)" />
						</div>
						<div class="w3-bar w3-margin-bottom"></div>
						<div class="w3-bar 15">
							ประตูบ้านกว้าง
							<input name="door_bigger" class="w3-input" type='text' id="door_bigger" style="width:90%;" placeholder="(เมตร)" />
						</div>
						<div class="w3-bar w3-margin-bottom"></div>
						<div class="w3-bar 16">
							ประตูสูง 
							<input name="door_longer" class="w3-input" type='text' id="door_longer" style="width:90%;" placeholder="(เมตร)" />
						</div>
						<div class="w3-bar w3-margin-bottom"></div>
						<div class="w3-bar 17">
							ประตูห้องกว้าง 
							<input name="room_bigger" class="w3-input" type='text' id="room_bigger" style="width:90%;" placeholder="(เมตร)" />
						</div>
						<div class="w3-bar w3-margin-bottom"></div>
						<div class="w3-bar 18">
							ประตูห้องสูง 
							<input name="room_longer" class="w3-input" type='text' id="room_longer" style="width:90%;" placeholder="(เมตร)" />
						</div>
						<div class="w3-bar w3-margin-bottom"></div>
					</div>
					<div class="w3-third 212">
						<div class="w3-bar 1">
							ประตูบ้านเป็นแบบ
							<input name="type_door" class="w3-input" type='text' id="type_door" style="width:90%;" />
						</div>
						<div class="w3-bar w3-margin-bottom"></div>
						<div class="w3-bar 2">
							พื้นบ้านเป็นแบบ
							<input name="home_type" class="w3-input" type='text' id="home_type" style="width:90%;" />
						</div>
						<div class="w3-bar w3-margin-bottom"></div>
						<div class="w3-bar 3">
							ติดตั้งที่ชั้น
							<input name="install" class="w3-input" type='text' id="install" style="width:90%;" />
						</div>
						<div class="w3-bar w3-margin-bottom"></div>
						<div class="w3-bar 4">
							<input type="checkbox" name="bundai_install"id ="bundai_install" value="1"> บันไดกว้าง
						</div>
						<div class="w3-bar 5">
							<input name="bundai_big" class="w3-input" type='text' id="bundai_big" style="width:90%;" placeholder="เมตร" />
						</div>
						<div class="w3-bar w3-margin-bottom"></div>
						<div class="w3-bar 6">
							หักมุมบันได
							<input name="bundai_hug" class="w3-input" type='text' id="bundai_hug" style="width:90%;" />
						</div>
						<div class="w3-bar w3-margin-bottom"></div>
						<div class="w3-bar 7">
							ชนิดของบันได
							<input name="type_bundai" class="w3-input" type='text' id="type_bundai" style="width:90%;" />
						</div>
						<div class="w3-bar w3-margin-bottom"></div>
						<div class="w3-bar 8">
							<input type="checkbox" name="lip"id = "lip" value="1"> ลิฟท์กว้าง
						</div>
						<div class="w3-bar 9">
							<input name="lip_big" class="w3-input" type='text' id="lip_big" style="width:90%;" placeholder="เมตร" />
						</div>
						<div class="w3-bar w3-margin-bottom"></div>
						<div class="w3-bar 10">
							สูง
							<input name="lip_long" class="w3-input" type='text' id="lip_long" style="width:90%;" placeholder="เมตร" />
						</div>
						<div class="w3-bar w3-margin-bottom"></div>
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
						<div class="w3-bar w3-margin-bottom"></div>
						<div class="w3-bar 17">
							ย้ายเฟอร์นิเจอร์ 
							<input name="ferniger_name" class="w3-input" type='text' id="ferniger_name" style="width:90%;" />
						</div>
						<div class="w3-bar w3-margin-bottom"></div>
						<div class="w3-bar 18">
							ย้ายไปที่ 
							<input name="ferniger_address" class="w3-input" type='text' id="ferniger_address" style="width:90%;" />
						</div>
						<div class="w3-bar w3-margin-bottom"></div>
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
						<div class="w3-bar w3-margin-bottom"></div>
						<div class="w3-bar">
							<input type="checkbox" name="want_prem"id ="want_prem" value="1"> ต้องการให้เตรียมฟรีมยืดไปซิวเก็บเตียงหรือที่นอนเก่า
						</div>
						<div class="w3-bar w3-margin-bottom"></div>
						<div class="w3-bar">
							รายละเอียดเพิ่มเติม
							<textarea name="description_ja" class="w3-input" id="description_ja" cols="54" rows="1" style="width:90%;"></textarea>
						</div>
					</div>
				</div>
				</fieldset>
			</div><!-- dv2 -->
	</div><!-- 3 -->
	<div id="55" class="tab w3-padding-small" style="display:none">
		<div class="w3-bar w3-margin-bottom"><input type="checkbox" name="returns" value="1">  ต้องการให้รับคืนสินค้า</div>
		<div class="w3-bar w3-margin-bottom">วันที่รับคืน <input type="date" name="returns_date" class="w3-input"></div>
		<div class="w3-bar w3-margin-bottom">วันที่ต้องการโดยประมาณ <input type="date" name="returns_date_requir" class="w3-input"></div>
		<div class="w3-bar w3-margin-bottom w3-half">เวลาที่รับคืน <input type="text" name="returns_time_start" class="w3-input" style="width:99%"></div>
		<div class="w3-bar w3-margin-bottom w3-half">ถึงเวลา <input type="text" name="returns_time_end" class="w3-input"></div>
		<div class="w3-bar w3-margin-bottom"><input type="checkbox" name="returns_same" value="1">  ใช้ที่อยู่เดียวกับที่จัดส่ง</div>
		<div class="w3-bar w3-margin-bottom"><input type="checkbox" name="returns_notsame" id="returnno" value="1">  รับคืนจากที่อยู่อื่น</div>
		<div class="w3-bar w3-margin-bottom" id="returnno-2" style="display:none">Ward/ตึก/ชั้น <textarea name="return_address" class="w3-input" rows="3"></textarea></div>
	</div><!-- 55 -->
	<div class="w3-bar w3-center">
			<input type="submit" name="submit" class="w3-button w3-teal be-border" value="บันทึกข้อมูล">
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
$('#more').click(function() {
  if($(this).is(":checked")){
   $("#more-2").show();
  }
  else{
   $("#more-2").hide();
  }
});

$('#have_map').click(function() {
  if($(this).is(":checked")){
   $("#have_map-2").show();
  }
  else{
   $("#have_map-2").hide();
  }
});

$('#return').click(function() {
  if($(this).is(":checked")){
   $("#return-2").show();
  }
  else{
   $("#return-2").hide();
  }
});

$('#returnno').click(function() {
  if($(this).is(":checked")){
   $("#returnno-2").show();
  }
  else{
   $("#returnno-2").hide();
  }
});

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

$('#customer').blur(function (){
    $('#address_name').val($(this).val()); // <-- reverse your selectors here
});
$('#address_name').blur(function (){
    $('#customer').val($(this).val()); // <-- and here
});

$('#delivery_place').blur(function (){
    $('#address_send').val($(this).val()); // <-- reverse your selectors here
});
$('#address_send').blur(function (){
    $('#delivery_place').val($(this).val()); // <-- and here
});

$('#delivery_contact').blur(function (){
    $('#customer_name').val($(this).val()); // <-- reverse your selectors here
});
$('#customer_name').blur(function (){
    $('#delivery_contact').val($(this).val()); // <-- and here
});
</script>