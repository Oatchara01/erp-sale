<?php include('head.php'); ?>
<script>
function showUser(str) {
    if (str == "") {
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else { 
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("txtHint").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","getuser.php?q="+str,true);
        xmlhttp.send();
    }
}
</script>
<body>
<?php
$sql1 = "select * from so__main order by main_id desc limit 1";
$query1 = mysqli_query($conn,$sql1);
$fetch1 = mysqli_fetch_array($query1,MYSQLI_ASSOC); ?>

<form action="register_office1.php" method="post" name="frmMain" >
<div class="w3-container w3-padding-large">
<div class="w3-panel w3-light-gray"><h4>Register Data : Stock</h4></div>
<div class="w3-half"><!--left half -->
<div class="w3-bar w3-border">
<div class="w3-button"><input type="checkbox" name="select_br_ptl" value="1">&nbsp;ใบยืมสินค้า PTL</div>
<div class="w3-button"><input type="checkbox" name="select_br_nbm" value="1">&nbsp;ใบยืมสินค้า NBM</div>
<div class="w3-button"><input type="checkbox" name="select_so_ptl" value="1">&nbsp;ใบสั่งขาย PTL</div>
<div class="w3-button"><input type="checkbox" name="select_so_nbm" value="1">&nbsp;ใบสั่งขาย NBM</div>
</div>
<div class="w3-padding-small"></div>
<div class="w3-bar">
วันที่: <span class="w3-light-grey"><?php echo datethai(date("Y-m-d")); ?></span> เลขที่อ้างอิง :<span class="w3-light-grey"><?php echo $fetch1['ref_id']+1; ?></span><input type="hidden" name="ref_id" value="<?php echo $fetch1['ref_id']+1; ?>"> <input type="hidden" name="main_id" value="<?php echo $fetch1['main_id']+1; ?>">
</div>
<div class="w3-padding-small"></div>
<div class="w3-bar">ช่องทางการขาย
<select name="sale_channel" id="sale_channel" class="w3-select" onchange="showUser(this.value)">
<option  value="">**โปรดเลือกช่องทางการขาย**</option>
<?php
$sqlchannel = "select * from tb_salechannel order by salechannel_ID";
$querychannel = mysqli_query($conn,$sqlchannel);
while ($fetchchannel = mysqli_fetch_array($querychannel,MYSQLI_ASSOC)) { ?>
<option class="w3-bar-item w3-button" value="<?php echo $fetchchannel['salechannel_ID']; ?>"><?php echo $fetchchannel['salechannel_nameshort']; ?>&nbsp;&nbsp;<?php echo $fetchchannel['description_chanel']; ?></option>
<?php } ?>
</select>
</div>
<div class="w3-padding-small"></div>
<div class="w3-bar">การจัดส่ง :
<select name="delivery" class="w3-select">
<option value="">**Please Select Item**</option>
<?php
$sqldeli = "SELECT tb_delivery.*,tb_sender.* FROM tb_delivery LEFT JOIN tb_sender ON tb_delivery.employee_send=tb_sender.sender_ID";
$querydeli = mysqli_query($conn,$sqldeli);
if (!$querydeli) {
	echo "Failed to fetch to MySQL: " . mysqli_error();
}
while ($fetchdeli = mysqli_fetch_array($querydeli,MYSQLI_ASSOC)) {
?>
<option class="w3-bar-item w3-button" value="<?php echo $fetchdeli['delivery_id'];?>"><?php echo $fetchdeli['delivery_name'];?> | <?php echo $fetchdeli['time_delivery']; ?> | <?php echo $fetchdeli['remark']; ?><?php echo $fetchdeli['packing_remark'];?></option>
<?php } ?>
</select>
</div>
<div class="w3-padding-small"></div>
<div class="w3-bar">การชำระเงิน
<select name="payment" class="w3-select">
<option value="">**Please Select Item**</option>
<?php
$strSQL5 = "select * from tb_payment order by payment_ID";
$objQuery5 = mysqli_query($conn,$strSQL5);
if (!$objQuery5) {
	echo "Failed to fetch to MySQL: " . mysqli_error();
}
while ($objResuut5 = mysqli_fetch_array($objQuery5,MYSQLI_ASSOC)) {
?>
<option class="w3-bar-item w3-button"  value="<?php echo $objResuut5['payment_ID']; ?>"><?php echo $objResuut5['payment_name']; ?> | <?php echo $objResuut5['bank_name']; ?> | <?php echo $objResuut5['book_number']; ?> | <?php echo $objResuut5['branch_bank']; ?> | <?php echo $objResuut5['book_type']; ?> | <?php echo $objResuut5['book_name']; ?> | <?php echo $objResuut5['description_payment']; ?></option>
<?php } ?>
</select>
</div>
<div class="w3-padding-small"></div>
<div class="w3-bar">หมายเหตุ
<textarea name="sale_remark"  class="w3-input" id="sale_remark" rows="1"></textarea>
</div>
<div class="w3-padding-small"></div>
<div class="w3-bar">ชื่อพนักงาน
<select  name="employee_name" class="w3-select">
<option value="">**Please Select Item**</option>
<?php
$emp = "select * from tb_employee where status=1 order by employee_ID";
$sqlemp = mysqli_query($conn,$emp);
while ($fetchemp = mysqli_fetch_array($sqlemp,MYSQLI_ASSOC)) { ?>
<option class="w3-bar-item w3-button" value="<?php echo $fetchemp['employee_ID']; ?>"><?php echo $fetchemp['employee_name']; ?></option>
<?php } ?>
</select>
</div>
</div><!-- 1st half -->
<div class="w3-container w3-half"><!-- right half -->
<div class="w3-bar w3-light-gray w3-border">
  <a class="w3-bar-item w3-button" onclick="openCity('br')"><font color="#404040"><b>ใบยืมสินค้า</b></font></a>
  <a class="w3-bar-item w3-button" onclick="openCity('so')"><font color="#404040"><b>ใบสั่งขาย</b></font></a>
  <a class="w3-bar-item w3-button" onclick="openCity('mo')"><font color="#404040"><b>เพิ่มเติม</b></font></a>
  <a class="w3-bar-item w3-button" onclick="openCity('ck')"><font color="#404040"><b>ส่วนงานคลังสินค้า-1</b></font></a>
</div>

<div id="br" class="w3-container city">
<div id="txtHint"></div>
</div><!-- close br -->

<div id="so" class="w3-container city" style="display:none">
<div class="w3-half"><!--bill-->
<div class="w3-bar">ชื่อที่ออกบิล
<input name="billing_name" type='text' class="w3-input">
</div>
<div class="w3-bar">ทีอยู่ที่ออกบิล
<textarea name="billing_address" class="w3-input"></textarea>
</div>
<div class="w3-bar w3-half">Tel.
<input type="text" name="billing_tel" class="w3-input">
</div>
<div class="w3-bar w3-half">
<input type="checkbox" name="bill_vat" value="1"> บิล VAT
</div>
<div class="w3-bar">การชำระเงิน
<select name="payment" class="w3-select" disabled>
<option value="">**Please Select Item**</option>
<?php
$strSQL5 = "select * from tb_payment order by payment_ID";
$objQuery5 = mysqli_query($conn,$strSQL5);
if (!$objQuery5) {
	echo "Failed to fetch to MySQL: " . mysqli_error();
}
while ($objResuut5 = mysqli_fetch_array($objQuery5,MYSQLI_ASSOC)) {
?>
<option class="w3-bar-item w3-button"  value="<?php echo $objResuut5['payment_ID']; ?>"><?php echo $objResuut5['payment_name']; ?> | <?php echo $objResuut5['bank_name']; ?> | <?php echo $objResuut5['book_number']; ?> | <?php echo $objResuut5['branch_bank']; ?> | <?php echo $objResuut5['book_type']; ?> | <?php echo $objResuut5['book_name']; ?> | <?php echo $objResuut5['description_payment']; ?></option>
<?php } ?>
</select>
</div>
<div class="w3-bar">การโอนเงิน
<select name="transfer" class="w3-select">
<option value="">**Please Select Item**</option>
<?php
$strSQL3 = "SELECT * FROM tb_transfer ORDER BY tranfer_ID ASC";
$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
while($objResult3 = mysqli_fetch_array($objQuery3))
{
?>
<option value="<?php echo $objResult3["tranfer_name"];?>"><?php echo $objResult3["tranfer_name"];?></option>
<?php
}
?>
</select>
</div>
<div class="w3-bar">
ส่งบัญชีตรวจสอบ <input type="checkbox" name="account_approve" value="1">
</div>
<div class="w3-bar">
วันที่โอน <input type="date" name="transfer_date" id="transfer_date" class="w3-input">
</div>
<div class="w3-bar">
จำนวนเงินโอน/เก็บปลายทาง <input type="text" name="amount" class="w3-input">
</div>
</div><!--bill-->
<div class="w3-half w3-container w3-border"><!--post detail-->
<h4><font color="#FF0000"><b>ใช้สำหรับจ่าหน้าพัสดุเท่านั้น</b></font></h4>
<div class="w3-bar">
ชื่อผู้รับสินค้า
<input name="delivery_name" type="text" class="w3-input">
</div>
<div class="w3-bar">
ที่อยู่ในการจัดส่ง
<input name="address1" class="w3-input" type="text">
<input name="address2" class="w3-input" type="text">
</div>
<div class="w3-bar">
จังหวัด
<select name="province" class="w3-select">
<option class="w3-bar" value=""></option>
<?php
$province="select * from tb_province order by province_name";
$prosql=mysqli_query($conn,$province);
while ($fepro=mysqli_fetch_array($prosql)) { ?>
<option class="w3-bar" value="<?php echo $fepro["province_ID"]; ?>"><?php echo $fepro["province_name"]; ?></option>
<?php } ?>
</select>
</div>
<div class="w3-bar">
รหัสไปรษณีย์ <input name="postcode" type="text" class="w3-input">
</div>
<div class="w3-bar">
โทรศัพท์ <input name="tel" type="text" class="w3-input">
</div>
</div><!--post detail-->
</div><!-- close so -->

<div id="mo" class="w3-container city" style="display:none">
<div class="w3-third"><!-- 1st 3rd -->
<div class="w3-bar">
ชื่อผู้แนะนำ <input name="prefer_name" class="w3-input">
</div>
<div class="w3-bar">
ใบสั่งซื้อเลขที่
<input name="order_no" class="w3-input">
</div>
<div class="w3-bar">
กำหนดส่งตามสัญญา
<input name="delivery_contract" class="w3-input">
</div>
<div class="w3-bar">
เคลียร์ใบจอง
<input name="clear_book_no" class="w3-input" placeholder="เลขที่">
</div>
<div class="w3-bar">
เคลียร์ใบยืม BRN
<input name="clear_brn_no" class="w3-input" placeholder="เลขที่">
</div>
<div class="w3-bar">
เคลียร์ใบยืม BRNP
<input name="clear_brnp_no" class="w3-input" placeholder="เลขที่">
</div>
</div><!-- 1st 3rd -->
<div class="w3-third w3-container"><!-- 2nd 3rd -->
<div class="w3-bar">
ต้องการ SN
<input name="sn" class="w3-input">
</div>
<div class="w3-bar">
BQ เลขที่
<input name="bq" class="w3-input">
</div>
<div class="w3-bar">
OT เลขที่
<input name="ot" class="w3-input">
</div>
<div class="w3-bar">
รับประกัน (ปี)
<input name="warranty" class="w3-input">
</div>
<div class="w3-bar">
Cal (ครั้ง/ปี)
<input name="cal" class="w3-input">
</div>
<div class="w3-bar">
PM (ครั้ง/ปี)
<input name="pm" class="w3-input">
</div>
</div><!-- 2nd 3rd -->
<div class="w3-third"><!-- 3rd 3rd -->
<div class="w3-bar">
สถานที่ติดตั้งเครื่อง
<input name="install_place" class="w3-input">
</div>
<div class="w3-bar">
<input name="with_pr" type="checkbox" value="1"> แนบใบเสนอราคา
</div>
<div class="w3-bar">
<input type="checkbox" name="type_com" value="1"> พิมพ์ตามคอม
</div>
<div class="w3-bar">
 <input type="checkbox" name="type_po" value="1"> พิมพ์ตามใบสั่งซื้อ
 </div>
<div class="w3-bar">
 <input type="checkbox" name="type_type" value="1"> พิมพ์ตามทีเขียน
 </div>
<div class="w3-bar">
ระบุ
<textarea name="type_type_detail" class="w3-input" style="resize: none;width:100%"></textarea>
</div>
</div><!-- 3rd 3rd -->
</div><!-- close more -->

<div id="ck" class="w3-container city" style="display:none">
หมายเลขคำสั่งซื้อ
<input name="order_id" class="w3-input w3-sand" type="text" readonly>
ชื่อลูกค้าตามคำสั่งซื้อ
<input name="order_name" class="w3-input w3-sand" type="text" readonly>
เลขที่เอกสาร
<input name="iv_number" class="w3-input w3-sand" type="text" readonly>
ชื่อที่ออกบิล
<input name="name_iv" class="w3-input w3-sand" type="text" readonly>
รหัสอ้างอิงการส่ง
<input name="order_refer_code" class="w3-input w3-sand" type="text" readonly>
</div><!-- close more -->
</div><!-- right half -->

<div class="w3-bar w3-light-grey w3-border">
  <a class="w3-bar-item w3-button" onclick="openCity1('pd')"><font color="#404040"><b>รายการสินค้า</b></font></a>
  <a class="w3-bar-item w3-button" onclick="openCity1('cs')"><font color="#404040"><b>รายละเอียดการจัดส่ง</b></font></a>
  <a class="w3-bar-item w3-button" onclick="openCity1('ot')"><font color="#404040"><b>ปิดงาน</b></font></a>
  <a class="w3-bar-item w3-button" onclick="openCity1('stoc')"><font color="#404040"><b>ส่วนงานคลังสินค้า-2</b></font></a>
</div>
<div id="pd" class="w3-container city1">
<?php include ('register_admin_detail.php')?>
</div>

<div id="cs" class="w3-container city1" style="display:none">
<div class="w3-quarter"><!-- 1st 4nd -->
<input type="checkbox" name="" hidden><br \>
<div class="w3-bar">วันที่ส่ง <input type="date" name="delivery_date" class="w3-input"></div>
<div class="w3-bar">เวลาส่ง <input type="text" name="delivery_time" class="w3-input"></div>
<div class="w3-bar">การส่งสินค้า</div>
<input type="checkbox" name="delivery_company" value="1">&nbsp;บริษัทจัดส่ง<br />
<input type="checkbox" name="big_car" value="1">&nbsp;ต้องการรถใหญ่<br />
<input type="checkbox" name="call_before" value="1">&nbsp;โทรแจ้งลูกค้าก่อนไป<br />
<input type="checkbox" name="maps" value="1">&nbsp;มีแผนที่ประกอบ<br />
<input type="checkbox" name="assign_date_time" value="1">&nbsp;นัดวันเวลาเรียบร้อยแล้ว<br />
</div><!-- 1st 3rd -->
<div class="w3-container w3-quarter"><!-- 2nd 4nd -->
<div class="w3-bar">
<input type="checkbox" name="delivery_sale" value="1">&nbsp;Sale รับเอง
<input type="checkbox" name="delivery_engineer" value="1">&nbsp;ช่างรับเอง
<input type="checkbox" name="delivery_customer" value="1">&nbsp;ลูกค้ารับเอง
</div>
<div class="w3-bar">
สถานที่ส่งสินค้า <textarea name="delivery_place" class="w3-input" cols="20" rows="1" style="width:100%;resize: none" ></textarea>
</div>
<div class="w3-bar">
ชื่อผู้ติดต่อ/TEL. <input type="text" name="delivery_contact" class="w3-input">
</div>
</div><!-- 2nd 3rd -->
<div class="w3-quarter"><!-- 3rd 4nd -->
<div class="w3-bar">
<input type="checkbox" name="return" value="1">&nbsp;รับคืนสินค้า
</div>
<div class="w3-bar">วันที่รับคืน <input type="text" name="return_date" class="w3-input"></div>
<div class="w3-bar">เวลา <input type="text" name="return_time" class="w3-input"></div>
<div class="w3-bar">ที่อยู่รับคืนสินค้า <input type="text" name="return_address" class="w3-input"></div>
<div class="w3-bar">ชื่อผู้ติดต่อ/TEL. <input type="text" name="return_contact" class="w3-input"></div>
</div><!-- 3rd 4nd -->
<div class="w3-quarter w3-container"><!-- 4nd 4nd -->
<a href="#" target="_blank" class="w3-button w3-purple">ใบยืม PTL</a><br />
<a href="#" target="_blank" class="w3-button w3-deep-purple">ใบสั่งขาย PTL</button></a><br />
<a href="#" target="_blank" class="w3-button w3-pale-red">ใบยืม NBM</a><br />
<a href="#" target="_blank" class="w3-button w3-pink">ใบสั่งขาย NBM</a>
</div><!-- 4nd 4nd -->
</div><!-- cs -->

<div id="stoc" class="w3-container city1" style="display:none">
<?php include ('register_admin_stock.php')?>
</div>
</br>
<center>
<input type="submit" name="submit" class="w3-button w3-teal" >
</center>
<?php require_once('foot.php'); ?>
</div>
</form>
</body>
</html>