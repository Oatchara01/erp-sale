<?php include('head.php'); ?>
<script src="libs/jquery.js"></script>
<script src="src/jSignature.js"></script>
<link href="css/form_style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/autocomplete.js"></script>

<link rel="stylesheet" href="css/autocomplete.css"  type="text/css"/>
<script type="text/javascript" src="js/autocomplete.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>


<script language="javascript" type="text/javascript">


function clearText(field) {
  if (field.defaultValue == field.value) field.value = '';
  else if (field.value == '') field.value = field.defaultValue;
}
</script>
<script>
(function($) {
	var topics = {};
	$.publish = function(topic, args) {
	  if (topics[topic]) {
	    var currentTopic = topics[topic],
	    args = args || {};
	
	    for (var i = 0, j = currentTopic.length; i < j; i++) {
	      currentTopic[i].call($, args);
	    }
	  }
	};
$.subscribe = function(topic, callback) {
	  if (!topics[topic]) {
	    topics[topic] = [];
	  }
	  topics[topic].push(callback);
	  return {
	    "topic": topic,
	    "callback": callback
	  };
	};
	/*$.unsubscribe = function(handle) {
	  var topic = handle.topic;
	  if (topics[topic]) {
	    var currentTopic = topics[topic];
	
	    for (var i = 0, j = currentTopic.length; i < j; i++) {
	      if (currentTopic[i] === handle.callback) {
	        currentTopic.splice(i, 1);
	      }
	    }
	  }
	};*/
})(jQuery);
</script> 
<script language="javascript">
	function fncSubmit() { //ห้ามชื่อสินค้า ยี่ห้อสินค้า รุ่นสินค้าเป็
		if(document.frmAdd.department_name.value == "") {
			alert('เลือกประเภทงาน');
			document.frmAdd.department_name.focus();
			return false;
		}	
		if(document.frmAdd.company_name.value == "") {
			alert('เลือกหน่วยงาน');
			document.frmAdd.company_name.focus();
			return false;
		}	
		/*if(document.frmAdd.province_name.value == "") {
			alert('กรุณากรอกจังหวัด');
			document.frmAdd.province_name.focus();
			return false;
		}
		if(document.frmAdd.province_name.value == "กรุงเทพมหานคร") {
			alert('กรุณากรอกเขต');
			document.frmAdd.amphur_name.focus();
			return false;
		}*/	
		document.frmAdd.submit();
	}
	$(document).ready(function() {	
		var $sigdiv = $("#employee_send_signature").jSignature({'UndoButton':true})
			, $tools = $('#tools_emp')
			, $extraarea_emp = $('#displayarea_emp')
			, pubsubprefix_emp = 'jSignature.demo1.'
		var export_plugins = $sigdiv.jSignature('listPlugins','export')
			, chops = ['<span><b>***กรุณาเลือกเป็น default </b></span><select class="w3-select" style="width:10%;">','<option value="">(select export format)</option>']
			, name
		for(var i in export_plugins){
			if (export_plugins.hasOwnProperty(i)) {
				name = export_plugins[i]
				chops.push('<option value="' + name + '">' + name + '</option>')
			}
		}
		chops.push('</select><span><b> or: </b></span>')
	
	$(chops.join('')).bind('change', function(e) {
		if (e.target.value !== '') {
			var data = $sigdiv.jSignature('getData', e.target.value)
			$.publish(pubsubprefix_emp + 'formatchanged')
				if (typeof data === 'string') {
					$('textarea', $tools).val(data)
				}
				else if($.isArray(data) && data.length === 2) {
					$('textarea', $tools).val(data.join(','))
					$.publish(pubsubprefix_emp + data[0], data);
				}
				else {
					try {
						$('textarea', $tools).val(JSON.stringify(data))
					}
					catch (ex) {
						$('textarea', $tools).val('Not sure how to stringify this, likely binary, format.')
					}
				}
			}
	}).appendTo($tools)
	$('<textarea id="employee_signature_name" name="employee_signature_name" class="w3-input" style="display:none;"></textarea>').appendTo($tools)
	$('<input type="button" class="w3-button w3-pale-red" value="Reset">').bind('click', function(e){
		$sigdiv.jSignature('reset')
	}).appendTo($tools)
	$.subscribe(pubsubprefix_emp + 'image/png;base64', function(data) {
		var i = new Image()
		i.src = 'data:' + data[0] + ',' + data[1]
		/*$('<span><b>As you can see, one of the problems of "image" extraction (besides not working on some old Androids, elsewhere) is that it extracts A LOT OF DATA and includes all the decoration that is not part of the signature.</b></span>').appendTo($extraarea)*/
		$(i).appendTo($extraarea_emp)
		});
	})
</script>
<script language="JavaScript">
	function addCommas(nStr) {
		nStr += '';
		x = nStr.split('.');
		x1 = x[0];
		x2 = x.length > 1 ? '.' + x[1] : '';
		var rgx = /(\d+)(\d{3})/;
		while (rgx.test(x1)) {
			x1 = x1.replace(rgx, '$1' + ',' + '$2');
		}
		return x1 + x2;
	}

	function chkNum(ele) {
		var num = parseFloat(ele.value);
		ele.value = addCommas(num.toFixed(2));
	}

	function fncSum() {
		var unit_price1 = document.frmAdd.unit_price1.value.replace(',','');
		var unit_price2 = document.frmAdd.unit_price2.value.replace(',','');
		var unit_price3 = document.frmAdd.unit_price3.value.replace(',','');
		var unit_price4 = document.frmAdd.unit_price4.value.replace(',','');
		var unit_price5 = document.frmAdd.unit_price5.value.replace(',','');

		var unit_price6 = document.frmAdd.unit_price6.value.replace(',','');
		var unit_price7 = document.frmAdd.unit_price7.value.replace(',','');
		var unit_price8 = document.frmAdd.unit_price8.value.replace(',','');
		var unit_price9 = document.frmAdd.unit_price9.value.replace(',','');
		var unit_price10 = document.frmAdd.unit_price10.value.replace(',','');


		var unit_price11 = document.frmAdd.unit_price11.value.replace(',','');
		var unit_price12 = document.frmAdd.unit_price12.value.replace(',','');
		var unit_price13 = document.frmAdd.unit_price13.value.replace(',','');
		var unit_price14 = document.frmAdd.unit_price14.value.replace(',','');
		var unit_price15 = document.frmAdd.unit_price15.value.replace(',','');

		var TotSum = parseFloat(unit_price1)+parseFloat(unit_price2)+parseFloat(unit_price3)+parseFloat(unit_price4)+parseFloat(unit_price5)+parseFloat(unit_price6)+parseFloat(unit_price7)+parseFloat(unit_price8)+parseFloat(unit_price9)+parseFloat(unit_price10)+parseFloat(unit_price11)+parseFloat(unit_price12)+parseFloat(unit_price13)+parseFloat(unit_price14)+parseFloat(unit_price15);
		
		document.frmAdd.unit_price1.value = addCommas(document.frmAdd.unit_price1.value );
		document.frmAdd.unit_price2.value = addCommas(document.frmAdd.unit_price2.value );
		document.frmAdd.unit_price3.value = addCommas(document.frmAdd.unit_price3.value );
		document.frmAdd.unit_price4.value = addCommas(document.frmAdd.unit_price4.value );
		document.frmAdd.unit_price5.value = addCommas(document.frmAdd.unit_price5.value );

		document.frmAdd.unit_price6.value = addCommas(document.frmAdd.unit_price6.value );
		document.frmAdd.unit_price7.value = addCommas(document.frmAdd.unit_price7.value );
		document.frmAdd.unit_price8.value = addCommas(document.frmAdd.unit_price8.value );
		document.frmAdd.unit_price9.value = addCommas(document.frmAdd.unit_price9.value );
		document.frmAdd.unit_price10.value = addCommas(document.frmAdd.unit_price10.value );


		document.frmAdd.unit_price11.value = addCommas(document.frmAdd.unit_price11.value );
		document.frmAdd.unit_price12.value = addCommas(document.frmAdd.unit_price12.value );
		document.frmAdd.unit_price13.value = addCommas(document.frmAdd.unit_price13.value );
		document.frmAdd.unit_price14.value = addCommas(document.frmAdd.unit_price14.value );
		document.frmAdd.unit_price15.value = addCommas(document.frmAdd.unit_price15.value );

		document.frmAdd.sum_unit_price.value = addCommas(TotSum);
	}




</script>

<script type="text/javascript">


function ck_frm(){
var ck = document.getElementById('ckk');
if(ck.checked == true){
document.getElementById('frm_txt').style.display = "";
document.getElementById('frm_tx').style.display = "";

}else{
document.getElementById('frm_txt').style.display = "none";
document.getElementById('frm_tx').style.display = "none";

}

}



function ck_frm1(){
var ck = document.getElementById('ckk1');
if(ck.checked == true){
document.getElementById('frm_txt1').style.display = "";
document.getElementById('frm_tx1').style.display = "";

}else{
document.getElementById('frm_txt1').style.display = "none";
document.getElementById('frm_tx1').style.display = "none";

}

}




</script>




<script>
function toggleField(hideObj,showObj){
		hideObj.disabled=true;        
		hideObj.style.display='none';
		showObj.disabled=false;   
		showObj.style.display='inline';
		showObj.focus();
	}
</script>
<form action="register_deposit1.php" name="frmAdd" method="post" onSubmit="JavaScript:return fncSubmit();">
	<div class="w3-container w3-padding-large"><!-- main div -->
		<div class="w3-panel w3-light-gray"><h4>Register : Deposit</h4></div>
		<!-- -->
			<?php
				$sql1 = "select * from tb_deposit order by deposit_code desc limit 1";
				$query1 = mysqli_query($conn,$sql1);
				$fetch1 = mysqli_fetch_array($query1,MYSQLI_ASSOC); ?>
		<!-- -->
		<input name="deposit_code" type='hidden' id="deposit_code" value="<?php echo $fetch1['deposit_code']+1; ?>" />
 		<div class="w3-half">
			<div class="w3-half">
				<div class="w3-bar w3-margin-bottom">
					<span>วันที่ออกบิล</span>
					<input name="bill_date" type='date' id="bill_date" class="w3-input" style="width:90%;" value="<?php echo date('Y-m-d'); ?>"  />
										<span>เลขที่</span>
										<?php $no = $fetch1['deposit_code']+1; 
										$year = (date("Y")+543);


										$iv_no = "$no/$year";
										?>
					<input name="iv_no" type='text' id="iv_no" class="w3-input" value ="<?php echo $iv_no; ?>" style="width:90%;"   />

				</div>
			</div>
			<div class="w3-half">
				<div class="w3-bar w3-margin-bottom">
					<span>ชื่อลูกค้าที่ออกบิล</span>
					<input name="bill_name" class="w3-input" type='text' id="bill_name" style="width:100%;" />
					<input name="add_by" type='hidden' id="add_by" value="<?php echo $_SESSION['name']; ?><?php echo $_SESSION['surname']; ?>" />
				</div>
			</div>
			<div class="w3-bar w3-margin-bottom">
				<span>ที่อยู่ออกบิล</span>
				<textarea class="w3-input" name="bill_address" rows="1" id="bill_address" style="width:100%;"/></textarea>
			</div>
			<div class="w3-third 1">
				<div class="w3-bar w3-margin-bottom">
					<span>เบอร์โทร</span>
					<input name="bill_tel" type='text' class="w3-input" id="bill_tel" style="width:90%;">
				</div>
			</div>
			<div class="w3-third 2">
				<div class="w3-bar w3-margin-bottom">
					<span>ชื่อผู้ติดต่อ</span>
					<input name="customer_contact" type="text" id="customer_contact" style="width:90%;" class="w3-input" />
				</div>
			</div>
			<div class="w3-third 3">
				<div class="w3-bar w3-margin-bottom">
					<span>เลขประจำตัวผู้เสียภาษี</span>
					<input name="tax_id" class="w3-input" id="tax_id" style="width:100%;" />
				</div>
			</div>
			<div class="w3-third 2">
				<div class="w3-bar w3-margin-bottom">
					<span>วันที่ส่งสินค้า</span>
					<input name="delivery_date" type='date' id="delivery_date" style="width:90%;" class="w3-input" />
				</div>
					</div>
				<div class="w3-third 2">
				<div class="w3-bar w3-margin-bottom">
					<span>เวลา</span>
					<input name="delivery_time" type='text' class="w3-input" id="delivery_time" style="width:90%;">
				</div>
			</div>
				<div class="w3-third 2">
				<div class="w3-bar w3-margin-bottom">
				<span>ชื่อผู้ติดต่อ</span>
				<input name="delivery_name" class="w3-input" type='text' id="delivery_name" style="width:90%;" />
			</div>
			</div>
			<div class="w3-third 2">
				<div class="w3-bar w3-margin-bottom">
				<span>แผนก</span>
				<input name="department" type="text" id="department" style="width:90%;" value="Online" class="w3-input" />
			</div>
			</div>
				<div class="w3-third 2">
				<div class="w3-bar w3-margin-bottom">
				<span>เบอร์โทร</span>
				<input name="delivery_tel" class="w3-input" type='text' id="delivery_tel" style="width:100%;" />
			</div>
			</div>
			<div class="w3-bar w3-margin-bottom">
				<span>ที่อยู่จัดส่ง</span>
				<textarea class="w3-input" name="delivery_address" rows="1" id="delivery_address" style="width:100%;" /></textarea>
			</div>
		</div>
		<div class="w3-half w3-container">
			<div class="w3-bar w3-twothird 0">
				<legend class="w3-margin-bottom">รายการสินค้า</legend>
				<input name="product_name1" type="text" id="product_name1" style="width:90%;" class="w3-input" placeholder="1." />
				<input type='hidden' name = "h_product_name1"  id = "h_product_name1"  class="w3-input" >

				<input name="product_name2" type="text" id="product_name2" style="width:90%;" class="w3-input" placeholder="2." />
				<input type='hidden' name = "h_product_name2"  id = "h_product_name2"  class="w3-input" >

				<input name="product_name3" type="text" id="product_name3" style="width:90%;" class="w3-input" placeholder="3." />
				<input type='hidden' name = "h_product_name3"  id = "h_product_name3"  class="w3-input" >

				<input name="product_name4" type="text" id="product_name4" style="width:90%;" class="w3-input" placeholder="4." />
				<input type='hidden' name = "h_product_name4"  id = "h_product_name4"  class="w3-input" >

				<input name="product_name5" type="text" id="product_name5" style="width:90%;" class="w3-input" placeholder="5." />
				<input type='hidden' name = "h_product_name5"  id = "h_product_name5"  class="w3-input" >

 
 <input type="checkbox" name="ckk" id="ckk" onClick="ck_frm();" />เพิ่มเติม

<div id="frm_txt" style="display:none;">

				<input name="product_name6" type="text" id="product_name6" style="width:90%;" class="w3-input" placeholder="6." />
								<input type='hidden' name = "h_product_name6"  id = "h_product_name6"  class="w3-input" >

				<input name="product_name7" type="text" id="product_name7" style="width:90%;" class="w3-input" placeholder="7." />
								<input type='hidden' name = "h_product_name7"  id = "h_product_name7"  class="w3-input" >

				<input name="product_name8" type="text" id="product_name8" style="width:90%;" class="w3-input" placeholder="8." />
								<input type='hidden' name = "h_product_name8"  id = "h_product_name8"  class="w3-input" >

				<input name="product_name9" type="text" id="product_name9" style="width:90%;" class="w3-input" placeholder="9." />
								<input type='hidden' name = "h_product_name9"  id = "h_product_name9"  class="w3-input" >

				<input name="product_name10" type="text" id="product_name10" style="width:90%;" class="w3-input" placeholder="10." />
								<input type='hidden' name = "h_product_name10"  id = "h_product_name10"  class="w3-input" >

<input type="checkbox" name="ckk1" id="ckk1" onClick="ck_frm1();" />เพิ่มเติม
</div>
<div id="frm_txt1" style="display:none;">
				<input name="product_name11" type="text" id="product_name11" style="width:90%;" class="w3-input" placeholder="11." />
				<input type='hidden' name = "h_product_name11"  id = "h_product_name11"  class="w3-input" >

				<input name="product_name12" type="text" id="product_name12" style="width:90%;" class="w3-input" placeholder="12." />
								<input type='hidden' name = "h_product_name12"  id = "h_product_name12"  class="w3-input" >

				<input name="product_name13" type="text" id="product_name13" style="width:90%;" class="w3-input" placeholder="13." />
								<input type='hidden' name = "h_product_name13"  id = "h_product_name13"  class="w3-input" >

				<input name="product_name14" type="text" id="product_name14" style="width:90%;" class="w3-input" placeholder="14." />
								<input type='hidden' name = "h_product_name14"  id = "h_product_name14"  class="w3-input" >

				<input name="product_name15" type="text" id="product_name15" style="width:90%;" class="w3-input" placeholder="15." />
								<input type='hidden' name = "h_product_name15"  id = "h_product_name15"  class="w3-input" >



</div>


			</div>
			<div class="w3-bar w3-third 0">
				<legend class="w3-margin-bottom">มูลค่า</legend>

				<input name="unit_price1" type="text" id="unit_price1" style="text-align:right;padding-right:2px; width:100%;" value="0" class="w3-input" OnChange="fncSum();"/>
				<input name="unit_price2" type="text" id="unit_price2" style="text-align:right;padding-right:2px; width:100%;" value="0" class="w3-input" OnChange="fncSum();"/>
				<input name="unit_price3" type="text" id="unit_price3" style="text-align:right;padding-right:2px; width:100%;" value="0" class="w3-input" OnChange="fncSum();"/>
				<input name="unit_price4" type="text" id="unit_price4" style="text-align:right;padding-right:2px; width:100%;" value="0" class="w3-input" OnChange="fncSum();"/>
				<input name="unit_price5" type="text" id="unit_price5" style="text-align:right;padding-right:2px; width:100%;" value="0" class="w3-input" OnChange="fncSum();"/>
			
			<div id="frm_tx" style="display:none;">
.
				<input name="unit_price6" type="text" id="unit_price6" style="text-align:right;padding-right:2px; width:100%;" value="0" class="w3-input" OnChange="fncSum();"/>
				<input name="unit_price7" type="text" id="unit_price7" style="text-align:right;padding-right:2px; width:100%;" value="0" class="w3-input" OnChange="fncSum();"/>
				<input name="unit_price8" type="text" id="unit_price8" style="text-align:right;padding-right:2px; width:100%;" value="0" class="w3-input" OnChange="fncSum();"/>
				<input name="unit_price9" type="text" id="unit_price9" style="text-align:right;padding-right:2px; width:100%;" value="0" class="w3-input" OnChange="fncSum();"/>
				<input name="unit_price10" type="text" id="unit_price10" style="text-align:right;padding-right:2px; width:100%;" value="0" class="w3-input" OnChange="fncSum();"/>

</div>
<div id="frm_tx1" style="display:none;">
.
				<input name="unit_price11" type="text" id="unit_price11" style="text-align:right;padding-right:2px; width:100%;" value="0" class="w3-input" OnChange="fncSum();"/>
				<input name="unit_price12" type="text" id="unit_price12" style="text-align:right;padding-right:2px; width:100%;" value="0" class="w3-input" OnChange="fncSum();"/>
				<input name="unit_price13" type="text" id="unit_price13" style="text-align:right;padding-right:2px; width:100%;" value="0" class="w3-input" OnChange="fncSum();"/>
				<input name="unit_price14" type="text" id="unit_price14" style="text-align:right;padding-right:2px; width:100%;" value="0" class="w3-input" OnChange="fncSum();"/>
				<input name="unit_price15" type="text" id="unit_price15" style="text-align:right;padding-right:2px; width:100%;" value="0" class="w3-input" OnChange="fncSum();"/>

</div>

			</div>
			<div class="w3-bar w3-twothird w3-margin-top">
				<legend style="text-align:right; width:90%;">รวมเป็นเงิน</legend>
			</div>
			<div class="w3-bar w3-third total">
				<input name="sum_unit_price" type="text" id="sum_unit_price" style="text-align:right;padding-right:2px; width:100%;" value="0" class="w3-input" />
			</div>
			<div class="w3-bar w3-third w3-margin-bottom w3-margin-top">
				<span>รายการรับชำระ</span>
				<select name="payment" class="w3-select" style="width:90%; height:90%;"
							onchange="if(this.options[this.selectedIndex].value=='customOption'){
							toggleField(this,this.nextSibling);
							this.selectedIndex='0';
						}">
					<option value="">**เลือกช่องทางการชำระ**</option>
						<?php
							$strSQL5 = "select * from tb_payment order by payment_ID";
							$objQuery5 = mysqli_query($conn,$strSQL5);
							if (!$objQuery5) {
								echo "Failed to fetch to MySQL: " . mysqli_error();
							}
							while ($objResuut5 = mysqli_fetch_array($objQuery5,MYSQLI_ASSOC)) { ?>
					<option class="w3-bar-item w3-button" value="<?php echo $objResuut5['payment_ID']; ?>"><?php echo $objResuut5['payment_name']; ?></option>
						<?php } ?>
					<option class="w3-bar-item w3-button" value="customOption">อื่น ๆ (พิมพ์)</option>
				</select><input name="payment" style="display:none; width:90%;" class="w3-input" disabled="disabled" onblur="if(this.value==''){toggleField(this,this.previousSibling);}">
			</div>
			<div class="w3-bar w3-third w3-margin-bottom w3-margin-top">
				<span>ธนาคาร</span>

		<select name="bank_name" id="bank_name" class="w3-input"   >
		<option  value="">**โปรดเลือกธนาคาร**</option>
		<option  value="ไทยพานิช">ไทยพานิช</option>
		<option  value="กรุงศรี">กรุงศรี</option>

		</select>



			</div>
            <div class="w3-bar w3-third w3-margin-bottom w3-margin-top">
				<span>บัตรของธนาคาร</span>
				<input name="bank_card" type='text' class="w3-input" id="bank_card" style="width:100%;">
			</div>

			<div class="w3-bar">
				<div class="w3-third 1">
					<span>เลขที่ / chq#</span>
					<input name="check_no" type="text" id="check_no" style="width:90%;" class="w3-input" />
				</div>
				<div class="w3-third 2">
					<span>สาขา</span>
					<input name="branch_name" type='text' class="w3-input" id="branch_name" style="width:90%;" />
				</div>
				<div class="w3-third 3">
					<span>ลงวันที่ / Date</span>
					<input name="payment_date" type="date" id="payment_date" style="width:90%;" value="<?php echo date('Y-m-d'); ?>" class="w3-input" />
				</div>
			</div>
		</div>
		<div class="w3-panel w3-padding-large"></div>
		<div align="center" class="w3-panel"><legend>วาดแผนที่</legend></div>
		
		<div class="w3-bar w3-border w3-margin-bottom w3-light-grey">
			<div id="employee_send_signature_par">
			<div id="employee_send_signature"></div></div>
		</div>
	<div id="tools_emp" align="center"></div>

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
	<div class="w3-panel w3-center">
		<input type="submit" name="button" id="button" value="Submit" class="w3-button w3-teal w3-border" />
	</div>
</form>
<?php include('foot.php'); ?>
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
		return "data_product_deposit.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_name1","h_product_name1");
        </script>

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
		return "data_product_deposit.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_name2","h_product_name2");
        </script>

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
		return "data_product_deposit.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_name3","h_product_name3");
        </script>

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
		return "data_product_deposit.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_name4","h_product_name4");
        </script>

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
		return "data_product_deposit.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_name5","h_product_name5");
        </script>

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
		return "data_product_deposit.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_name6","h_product_name6");
        </script>

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
		return "data_product_deposit.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_name7","h_product_name7");
        </script>

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
		return "data_product_deposit.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_name8","h_product_name8");
        </script>

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
		return "data_product_deposit.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_name9","h_product_name9");
        </script>

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
		return "data_product_deposit.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_name10","h_product_name10");
        </script>

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
		return "data_product_deposit.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_name11","h_product_name11");
        </script>

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
		return "data_product_deposit.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_name12","h_product_name12");
        </script>

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
		return "data_product_deposit.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_name13","h_product_name13");
        </script>

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
		return "data_product_deposit.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_name14","h_product_name14");
        </script>

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
		return "data_product_deposit.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_name15","h_product_name15");
        </script>

