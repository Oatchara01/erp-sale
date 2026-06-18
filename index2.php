<?php include('head.php'); ?>
<?php
$sql1 = "select * from so__main order by main_id desc limit 1";
$query1 = mysqli_query($conn,$sql1);
$fetch1 = mysqli_fetch_array($query1,MYSQLI_ASSOC); ?>
<div class="w3-container w3-padding-large">
<h2>Register Data</h2>
<div class="w3-half">
<form method="post" name="frmMain" action="save_register.php">
<div class="w3-quarter w3-bar w3-light-grey"><input type="checkbox" name="select_br_ptl" value="1">&nbsp;<label>ใบยืมสินค้า PTL</label></div>  
<div class="w3-quarter w3-bar w3-light-grey"><input type="checkbox" name="select_br_nbm" value="1">&nbsp;<label>ใบยืมสินค้า NBM</label></div>
<div class="w3-quarter w3-bar w3-light-grey"><input type="checkbox" name="select_so_ptl" value="1">&nbsp;<label>ใบสั่งขาย PTL</label></div>
<div class="w3-quarter w3-bar w3-light-grey"><input type="checkbox" name="select_so_nbm" value="1">&nbsp;<label>ใบสั่งขาย NBM</label></div>
<div class="w3-bar w3-light-grey"><label>วันที่:</label> <?php echo date("d/m/Y"); ?> | <label>เลขที่อ้างอิง:</label> <input type="text" name="ref_id" value="<?php echo $fetch1['ref_id']+1; ?>"> <input type="text" name="main_id" value="<?php echo $fetch1['main_id']+1; ?>" hidden> </div>
<hr>
<div class=""><div class="w3-light-grey">ช่องทางการขาย</div>
<select name="sale_channel" id="sale_channel" class="w3-select" onchange="showUser(this.value)">
<option class="w3-bar-item w3-button" value=""></option>
<?php
$sqlchannel = "select * from tb_salechannel order by salechannel_ID";
$querychannel = mysqli_query($conn,$sqlchannel);
while ($fetchchannel = mysqli_fetch_array($querychannel,MYSQLI_ASSOC)) { ?>
<option class="w3-bar-item w3-button" value="<?php echo $fetchchannel['salechannel_ID']; ?>"><?php echo $fetchchannel['salechannel_nameshort']; ?>&nbsp;&nbsp;<?php echo $fetchchannel['description_chanel']; ?></option>
<?php } ?>
</select>
<br>
<div class="w3-light-grey">การจัดส่ง</div>
<select name="delivery" class="w3-select">
<?php
$sqldeli = "SELECT tb_delivery.*,tb_sender.* FROM tb_delivery LEFT JOIN tb_sender ON tb_delivery.employee_send=tb_sender.sender_ID";
$querydeli = mysqli_query($conn,$sqldeli);
if (!$querydeli) {
	echo "Failed to fetch to MySQL: " . mysqli_error();
}
while ($fetchdeli = mysqli_fetch_array($querydeli,MYSQLI_ASSOC)) {
?>
<option class="w3-bar-item w3-button" value="<?php echo $fetchdeli['delivery_ID'];?>"><?php echo $fetchdeli['sender_name'];?> : <?php echo $fetchdeli['time_send']; ?> : <?php echo $fetchdeli['description_send']; ?><?php echo $fetchdeli['description_wrap'];?></option>
<?php } ?>
</select>
<br>
<div class="w3-light-grey">การชำระเงิน:</div>
<select name="payment" class="w3-select">
<?php
$payment = "select * from tb_payment order by payment_ID";
$sqlp = mysqli_query($conn,$payment);
while ($fetchp = mysqli_fetch_array($sqlp,MYSQLI_ASSOC)) { ?>
<option class="w3-bar-item w3-button" value="<?php echo $fetchp['payment_ID']; ?>"><?php echo $fetchp['payment_name']; ?> | <?php echo $fetchp['bank_name']; ?> | <?php echo $fetchp['book_number']; ?> | <?php echo $fetchp['branch_bank']; ?> | <?php echo $fetchp['book_type']; ?> | <?php echo $fetchp['book_name']; ?> | <?php echo $fetchp['description_payment']; ?></option>
<?php } ?>
</select>
<div class="w3-light-grey">หมายเหตุ:</div>
<input class="w3-input" name="sale_remark" style="width:100%">
<br>
<div class="w3-light-grey">ชื่อพนักงาน:</div>
<select class="w3-select" name="employee_name">
<?php
$emp = "select * from tb_employee where status=1 order by employee_ID";
$sqlemp = mysqli_query($conn,$emp);
while ($fetchemp = mysqli_fetch_array($sqlemp,MYSQLI_ASSOC)) { ?>
<option class="w3-bar-item w3-button" value="<?php echo $fetchemp['employee_ID']; ?>"><?php echo $fetchemp['employee_name']; ?></option>
<?php } ?>
</select>
</div><!--w3-half-->
</div><!--w3-half-->
<div class="w3-half w3-bar w3-container w3-light-grey" >
  <a class="w3-bar-item w3-button" onclick="openCity('br')">ใบยืมสินค้า</a>
  <a class="w3-bar-item w3-button" onclick="openCity('so')">ใบสั่งขาย</a>
  <a class="w3-bar-item w3-button" onclick="openCity('mo')">เพิ่มเติม</a>
</div><!--w3-half w3-bar w3-container w3-light-grey-->
<div id="br" class="w3-container w3-half city">
<div id="txtHint"></div>
</div><!-- close br -->
<div id="so" class="w3-container w3-half city" style="display:none">
<div id="first" class="w3-half">
<label>ชื่อที่ออกบิล:</label>
<input name="billing_name" class="w3-input" style="width:98%">
<label>ทีอยู่ที่ออกบิล:</label>
<textarea name="billing_address" class="w3-input" cols="100%" style="width:98%"></textarea>
<div class="w3-half"><label>Tel.:</label>
<input type="text" name="billing_tel" class="w3-input" style="width:98%"></div><div class="w3-half"><input type="checkbox" value="1">บิล VAT</div>
<div class="w3-bar">
<div class="w3-bar w3-half">
<label>การชำระเงิน</label>
<select name="payment" class="w3-select" style="width:98%" disabled>
<?php
$psearch="select so__main.payment,tb_payment.payment_ID from so__main left join tv_payment on so__main.payment=tb_payment.payment_ID";
$sqlp = mysqli_query($conn,$psearch);
$np = mysqli_num_rows($sqlp);
if ($np > 0) {
	$fp=mysqli_fetch_array($sqlp,MYSQLI_ASSOC); ?>
	<option class="w3-bar-item w3-button" value="<?php echo $np['payment_ID']; ?>"><?php echo $np['payment_name']; ?>&nbsp;<?php echo $np['bank_name']; ?>&nbsp;<?php echo $np['book_number']; ?>&nbsp;<?php echo $np['branch_bank']; ?>&nbsp;<?php echo $np['book_type']; ?>&nbsp;<?php echo $np['book_name']; ?>&nbsp;<?php echo $np['description_payment']; ?></option>
<?php }
else { ?>
	<option class="w3-bar-item w3-button" value=""></option>
<?php } ?>
<?php
$payment="select * from tb_payment order by payment_ID";
$sqlpy=mysqli_query($conn,$payment);
while ($fpy=mysqli_fetch_array($sqlpy,MYSQLI_ASSOC)) { ?>
<option class="w3-bar-item w3-button" value="<?php echo $fpy['payment_ID']; ?>"><?php echo $fpy['payment_name']; ?>&nbsp;<?php echo $fpy['bank_name']; ?>&nbsp;<?php echo $fpy['book_number']; ?>&nbsp;<?php echo $fpy['branch_bank']; ?>&nbsp;<?php echo $fpy['book_type']; ?>&nbsp;<?php echo $fpy['book_name']; ?>&nbsp;<?php echo $fpy['description_payment']; ?></option>
<?php } ?>
</select>
</div><!--w3-bar w3-half-->
<div class="w3-bar w3-half">
<label>การโอนเงิน</label>
<select name="transfer" class="w3-select" style="width:98%" disabled>
</select>
</div><!--w3-bar w3-half-->
<div class="w3-bar"><label>ส่งบัญชีตรวจสอบ</label>
<input type="checkbox" name="account_approve" value="1"></div>
<div class="w3-bar">
<div class="w3-half">
<label>วันที่โอน</label>
<input type="date" name="transfer_date" id="transfer_date" class="w3-input" style="width:98%"></div><!-- w3-half  -->
<div class="w3-half">
<label>จำนวนเงินโอน/เก็บปลายทาง</label>
<input type="text" name="amount" class="w3-input" style="width:98%"></div><!-- w3-half  -->
</div><!-- w3-bar  -->
</div><!-- w3-bar  -->
</div><!--first-->
<div id="second" class="w3-container w3-half w3-pale-red">
<h4>ใช้สำหรับจ่าหน้าพัสดุเท่านั้น</h4>
<label>ชื่อผู้รับสินค้า</label>
<input name="delivery_name" type="text" class="w3-input" style="width:100%">
<label>ที่อยู่ในการจัดส่ง</label>
<input name="address1" class="w3-input" type="text" style="width:100%">
<input name="address2" class="w3-input" type="text" style="width:100%">
<label>จังหวัด</label>
<select name="province" class="w3-select" style="width:100%">
<option class="w3-bar" value=""></option>
<?php
$province="select * from tb_province order by province_name";
$prosql=mysqli_query($conn,$province);
while ($fepro=mysqli_fetch_array($prosql)) { ?>
<option class="w3-bar" value="<?php echo $fepro["province_ID"]; ?>"><?php echo $fepro["province_name"]; ?></option>
<?php } ?>
</select>
<label>รหัสไปรษณีย์</label>
<input name="postcode" type="text" class="w3-input" style="width:100%">
<label>โทรศัพท์</label>
<input name="tel" type="text" class="w3-input" style="width:100%">
</div><!--second-->
</div><!-- close so -->

<div id="mo" class="w3-container w3-half city" style="display:none">
<div id="1st" class="w3-third w3-container">
<label>ชื่อผู้แนะนำ</label>
<input name="prefer_name" class="w3-input" style="width:100%">
<label>ใบสั่งซื้อเลขที่</label>
<input name="order_no" class="w3-input" style="width:100%">
<label>กำหนดส่งตามสัญญา:</label>
<input name="delivery_contract" class="w3-input" style="width:100%">
<label>เคลียร์ใบจอง:</label>
<input name="clear_book_no" class="w3-input" placeholder="เลขที่" style="width:100%">
<label>เคลียร์ใบยืม BRN:</label>
<input name="clear_brn_no" class="w3-input" placeholder="เลขที่" style="width:100%">
<label>เคลียร์ใบยืม BRNP:</label>
<input name="clear_brnp_no" class="w3-input" placeholder="เลขที่" style="width:100%">
</div><!-- 1st third -->
<div id="2nd" class="w3-third w3-container">
<label>ต้องการ SN:</label>
<input name="sn" class="w3-input" style="width:100%">
<label>BQ เลขที่:</label>
<input name="bq" class="w3-input" style="width:100%">
<label>OT เลขที่:</label>
<input name="ot" class="w3-input" style="width:100%">
<label>รับประกัน (ปี)</label>
<input name="warranty" class="w3-input" style="width:100%">
<label>Cal (ครั้ง/ปี)</label>
<input name="cal" class="w3-input" style="width:100%">
<label>PM (ครั้ง/ปี)</label>
<input name="pm" class="w3-input" style="width:100%">
</div><!-- 2nd -->
<div id="3rd" class="w3-third w3-container">
<label>สถานที่ติดตั้งเครื่อง</label>
<input name="install_place" class="w3-input" style="width:100%"><br />
<input name="with_pr" type="checkbox" value="1">
<label>แนบใบเสนอราคา</label><br />
<input type="checkbox" name="type_com" value="1">
<label>พิมพ์ตามคอม</label><br />
<input type="checkbox" name="type_po" value="1">
<label>พิมพ์ตามใบสั่งซื้อ</label><br />
<input type="checkbox" name="type_type" value="1">
<label>พิมพ์ตามที่เขียน</label><br />
<label>ระบุ:</label>
<textarea name="type_type_detail" class="w3-input" style="resize: none;width:100%"></textarea>
</div><!-- close 3rd -->
</div><!-- close mo -->
<!--Product List -->
<hr>
<div class="w3-bar w3-light-grey">
  <a class="w3-bar-item w3-button" onclick="openCity1('pd')"><font color="magenta"><b>รายการสินค้า</b></font></a>
  <a class="w3-bar-item w3-button" onclick="openCity1('cs')"><font color="blue"><b>รายละเอียดการจัดส่ง</b></font></a>
  <a class="w3-bar-item w3-button" onclick="openCity1('ot')"><font color="purple"><b>ปิดงาน</b></font></a>
</div>
<div id="pd" class="w3-container city1">
<?php require('testadd.php'); ?>
</div><!-- pd -->
<div id="cs" class="w3-container city1" style="display:none">
<div id="#1" class="w3-container w3-quarter">
<input type="checkbox" name="" hidden><br \>
<label>วันที่ส่ง</label>
<input type="date" name="delivery_date" class="w3-input" style="width:100%">
<label>เวลาส่ง</label>
<input type="text" name="delivery_time" class="w3-input" style="width:100%">
<label>การส่งสินค้า</label><br>
<input type="checkbox" name="delivery_company" value="1">&nbsp;บริษัทจัดส่ง<br />
<input type="checkbox" name="big_car" value="1">&nbsp;ต้องการรถใหญ่<br />
<input type="checkbox" name="call_before" value="1">&nbsp;โทรแจ้งลูกค้าก่อนไป<br />
<input type="checkbox" name="maps" value="1">&nbsp;มีแผนที่ประกอบ<br />
<input type="checkbox" name="assign_date_time" value="1">&nbsp;นัดวันเวลาเรียบร้อยแล้ว
</div><!-- #1 -->
<div id="#2" class="w3-container w3-quarter">
<input type="checkbox" name="delivery_sale" value="1">&nbsp;Sale รับเอง
<input type="checkbox" name="delivery_engineer" value="1">&nbsp;ช่างรับเอง
<input type="checkbox" name="delivery_customer" value="1">&nbsp;ลูกค้ารับเอง <br />
<label>สถานที่ส่งสินค้า:</label>
<textarea name="delivery_place" class="w3-input" cols="20" rows="1" style="width:100%;resize: none" ></textarea>
<label>ชื่อผู้ติดต่อ/TEL.:</label>
<input type="text" name="delivery_contact" class="w3-input" style="width:100%">
</div><!-- #2 -->
<div id="#3" class="w3-container w3-quarter">
<input type="checkbox" name="return" value="1">&nbsp;รับคืนสินค้า<br>
<label>วันที่รับคืน</label>
<input type="text" name="return_date" class="w3-input" style="width:100%">
<label>เวลา</label>
<input type="text" name="return_time" class="w3-input" style="width:100%">
<label>ที่อยู่รับคืนสินค้า:</label>
<input type="text" name="return_address" class="w3-input" style="width:100%">
<label>ชื่อผู้ติดต่อ/TEL.:</label>
<input type="text" name="return_contact" class="w3-input" style="width:100%">
</div><!-- #3 -->
<div id="#4" class="w3-container w3-quarter">
<button name="br_ptl" action="" class="w3-button">ใบยืม PTL</button>
<button name="so_ptl" action="" class="w3-button">ใบสั่งขาย PTL</button><br />
<button name="br_nbm" action="" class="w3-button">ใบยืม NBM</button>
<button name="so_nbm" action="" class="w3-button">ใบสั่งขาย NBM</button><br />
<input type="submit" name="submit" class="fa fa-save w3-button">
</div><!-- #4 -->
</div><!-- cs -->
<div id="ot" class="w3-container city1" style="display:none">
test3
</div><!-- ot -->
</form>
</div><!--w3-container w3-padding-large-->
</body>
</html>