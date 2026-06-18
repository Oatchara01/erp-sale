<?php include "dbconnect.php"; ?>
<?php include('head.php'); ?>
<body>
<?php
$strSQL = "SELECT * FROM so__main WHERE ref_id = '".$_GET["ref_id"]."' ";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);
?>

<form action="register_office1.php" method="post" name="frmMain" >
<div class="w3-container w3-padding-large">
<div class="w3-panel w3-light-gray"><h4>Edit Data : Stock</h4></div>
<div class="w3-half"><!--left half -->
<div class="w3-bar w3-border">
<?php
if ($objResult["select_br_ptl"]=='1'){
?>
<div class="w3-button"><input type="checkbox" name="select_br_ptl" checked='checked' value="1">&nbsp;ใบยืมสินค้า PTL</div>
<?php
}else{
	?>
<div class="w3-button"><input type="checkbox" name="select_br_ptl" value="1">&nbsp;ใบยืมสินค้า PTL</div>

		<?php
}

		if ($objResult["select_br_nbm"]=='1'){

			?>
<div class="w3-button"><input type="checkbox" name="select_br_nbm" checked='checked' value="1">&nbsp;ใบยืมสินค้า NBM</div>

				<?php
		}else{
					?>
		<div class="w3-button"><input type="checkbox" name="select_br_nbm" value="1">&nbsp;ใบยืมสินค้า NBM</div>
					<?php
					}
	if ($objResult["select_so_ptl"]=='1'){

?>
<div class="w3-button"><input type="checkbox" name="select_so_ptl" checked='checked' value="1">&nbsp;ใบสั่งขาย PTL</div>
<?php
	}else{
	?>
<div class="w3-button"><input type="checkbox" name="select_so_ptl" value="1">&nbsp;ใบสั่งขาย PTL</div>

		<?php
}
			if ($objResult["select_so_nbm"]=='1'){

			?>
<div class="w3-button"><input type="checkbox" name="select_so_nbm" checked='checked' value="1">&nbsp;ใบสั่งขาย NBM</div>
<?php
			}else{
				?>
					<div class="w3-button"><input type="checkbox" name="select_so_nbm" value="1">&nbsp;ใบสั่งขาย NBM</div>


					<?php
			}
						?>
						</div>
<div class="w3-padding-small"></div>
<div class="w3-bar">
<?php
	$date = explode('-' , $objResult["register_date"] );
$xdate = $date[2].'-'.$date[1].'-'.$date[0];
 /*echo $xdate;*/?>
<div class="w3-bar">วันที่: <?php echo DateThai($objResult["register_date"]); ?> เลขที่อ้างอิง:&nbsp;<span class="w3-light-gray"><?php echo $objResult['ref_id']; ?></span><input type="hidden" name="ref_id" class="w3-input25" value="<?php echo $objResult['ref_id']; ?>"> <input type="hidden" name="main_id" value="<?php echo $objResult['main_id']; ?>">
<input type="hidden" name="register_date" value="<?php echo $objResult['register_date']; ?>">
<input type="hidden" name="register_time" value="<?php echo $objResult['register_time']; ?>"></div>
</div>
<div class="w3-padding-small"></div>
<div class="w3-bar">ช่องทางการขาย


<select name="sale_channel" id="sale_channel" class="w3-select"   onchange="showUser(this.value)">
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
<div class="w3-padding-small"></div>
<div class="w3-bar">การจัดส่ง
<select name="delivery" class="w3-select">
<option value="">**Please Select Item**</option>
<?php
$sqldeli = "SELECT tb_delivery.*,tb_sender.* FROM tb_delivery LEFT JOIN tb_sender ON tb_delivery.employee_send=tb_sender.sender_ID";
$querydeli = mysqli_query($conn,$sqldeli);

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
<option class="w3-bar-item w3-button" value="<?php echo $fetchdeli['delivery_id'];?>" <?php echo $sel;?>><?php echo $fetchdeli['delivery_name'];?> | <?php echo $fetchdeli['time_delivery']; ?> | <?php echo $fetchdeli['remark']; ?><?php echo $fetchdeli['packing_remark'];?></option>
<?php } ?>
</select>
</div>
<div class="w3-padding-small"></div>
<div class="w3-bar">การชำระเงิน
<select name="payment" class="w3-select"  >
<option value="">**Please Select Item**</option>
<?php
$strSQL5 = "select * from tb_payment order by payment_ID";
$objQuery5 = mysqli_query($conn,$strSQL5);
if (!$objQuery5) {
	echo "Failed to fetch to MySQL: " . mysqli_error();
}
while ($objResuut5 = mysqli_fetch_array($objQuery5,MYSQLI_ASSOC)) {
if($objResult["payment"] == $objResuut5["payment_ID"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>
<option class="w3-bar-item w3-button"  value="<?php echo $objResuut5['payment_ID']; ?>"<?php echo $sel;?>><?php echo $objResuut5['payment_name']; ?> | <?php echo $objResuut5['bank_name']; ?> | <?php echo $objResuut5['book_number']; ?> | <?php echo $objResuut5['branch_bank']; ?> | <?php echo $objResuut5['book_type']; ?> | <?php echo $objResuut5['book_name']; ?> | <?php echo $objResuut5['description_payment']; ?></option>
<?php } ?>
</select>
</div>
<div class="w3-padding-small"></div>
<div class="w3-bar">หมายเหตุ
<textarea name="sale_remark"  class="w3-input" id="sale_remark" rows="1"><?php echo $objResult['sale_remark']; ?></textarea>
</div>
<div class="w3-padding-small"></div>
<div class="w3-bar">ชื่อพนักงาน
<select  name="employee_name" class="w3-select"  >
<option value="">**Please Select Item**</option>

<?php
$emp = "select * from tb_employee where status=1 order by employee_ID";
$sqlemp = mysqli_query($conn,$emp);
while ($fetchemp = mysqli_fetch_array($sqlemp,MYSQLI_ASSOC)) {
if($objResult["employee_name"] == $fetchemp["employee_ID"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>
<option class="w3-bar-item w3-button" value="<?php echo $fetchemp['employee_ID']; ?>"<?php echo $sel;?>><?php echo $fetchemp['employee_name']; ?></option>
<?php } ?>
</select>
</div>
</div><!-- 1st half -->
<div class="w3-container w3-half"><!-- right half -->
<div class="w3-bar w3-light-grey w3-border">
    <a class="w3-bar-item w3-button" onclick="openCity('ck')"><font color="#404040"><b>ส่วนงานคลังสินค้า-1</b></font></a>
<a class="w3-bar-item w3-button" onclick="openCity('br')"><font color="#404040"><b>ใบยืมสินค้า</b></font></a>
  <a class="w3-bar-item w3-button" onclick="openCity('so')"><font color="#404040"><b>ใบสั่งขาย</b></font></a>
  <a class="w3-bar-item w3-button" onclick="openCity('mo')"><font color="#404040"><b>เพิ่มเติม</b></font></a>
</div>

<div id="br" class="w3-container city">
<div >


<?php
$sale_channel=$objResult["sale_channel"];
include "dbconnect.php";
$sql="SELECT tb_salechannel.*,tb_province.* FROM tb_salechannel LEFT JOIN tb_province ON tb_salechannel.province_id=tb_province.province_ID WHERE salechannel_ID = '".$sale_channel."'";

//echo  $sql;
//exit();

$result = mysqli_query($conn,$sql) or die(mysqli_error());
$row = mysqli_fetch_array($result);

?>
<div class="w3-bar">
วัตถุประสงค์การเบิก: <input name='objective'  class='w3-input' value="<?php echo $row["salechannel_nameshort"];?>" readonly/>
</div>
<div class="w3-bar">
หมายเลขคำสั่งซื้อ: <input type='text' class='w3-input' name='order_id'  value="<?php echo $objResult["order_id"]; ?>" readonly>
</div>
<div class="w3-bar">
ชื่อลูกค้าตามคำสั่งซื้อ: <input type='text' class='w3-input' name='order_name' value="<?php echo $objResult["order_name"]; ?>" readonly>
</div>
<div class="w3-bar">
ชื่อลูกค้า: <span class="w3-padding-small"><?php echo $row["salechannel_nameshort"];?></span>
</div>

<div class="w3-bar">
วันที่ออกเอกสาร: <span class="w3-padding-small">
<?php if ($objResult["doc_release_date"]=="0000-00-00") { echo "-"; } else { echo DateThai($objResult["doc_release_date"]); } ?></span>
</div>
<div class="w3-bar">
ชื่อลูกค้า: <span class="w3-padding-small"><?php echo $row["salechannel_nameshort"];?></span>
</div>
<div class="w3-bar">
ที่อยู่: <span class="w3-padding-small"><?php echo $row["address1"]; ?>&nbsp;<?php echo $row["address2"]; ?>&nbsp;<?php echo $row['province_name']; ?>&nbsp;<?php echo $row['zip_code']; ?></span>
</div>
<div class="w3-bar">
หมายเหตุ: <span class="w3-padding-small"><?php echo $row['description_chanel']; ?></span>
</div>
</div>
</div><!-- close br -->

<div id="so" class="w3-container city" style="display:none">
<div class="w3-half"><!--bill-->
<div class="w3-bar">ชื่อที่ออกบิล
<input name="billing_name" type='text' value="<?php echo $objResult['billing_name']; ?>" class="w3-input" readonly>
</div>
<div class="w3-bar">ทีอยู่ที่ออกบิล
<textarea name="billing_address" class="w3-input" readonly><?php echo $objResult['billing_address']; ?></textarea>
</div>
<div class="w3-bar w3-half">Tel.
<input type="text" name="billing_tel" value="<?php echo $objResult['billing_tel']; ?>" class="w3-input" readonly>
</div>
<div class="w3-bar w3-half">

<?php
if ($objResult['bill_vat']=='1'){
?>
<input type="checkbox" name="bill_vat" checked='checked' value="1"> &nbsp;บิล VAT
<?php
}else{

?>
<input type="checkbox" name="bill_vat" value="1"> &nbsp;บิล VAT

<?php
}
?>
</div>
<div class="w3-bar">การชำระเงิน
<select name="payment" class="w3-select" disabled>
<option value="">**Please Select Item**</option>
<?php
$strSQL6 = "select * from tb_payment order by payment_ID";
$objQuery6 = mysqli_query($conn,$strSQL6);
if (!$objQuery6) {
	echo "Failed to fetch to MySQL: " . mysqli_error();
}
while ($objResuut6 = mysqli_fetch_array($objQuery6,MYSQLI_ASSOC)) {
if($objResult["payment"] == $objResuut6["payment_ID"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>
<option class="w3-bar-item w3-button"  value="<?php echo $objResuut6['payment_ID']; ?>"<?php echo $sel;?>><?php echo $objResuut6['payment_name']; ?> | <?php echo $objResuut6['bank_name']; ?> | <?php echo $objResuut6['book_number']; ?> | <?php echo $objResuut6['branch_bank']; ?> | <?php echo $objResuut6['book_type']; ?> | <?php echo $objResuut6['book_name']; ?> | <?php echo $objResuut6['description_payment']; ?></option>
<?php } ?>
</select>
</div>
<div class="w3-bar">การโอนเงิน
<select name="transfer" class="w3-select">
<option value="">**Please Select Item**</option>
<?php
$strSQL3 = "SELECT * FROM tb_transfer ORDER BY tranfer_ID ASC";
$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
while($objResult3 = mysqli_fetch_array($objQuery3)){
if($objResult["transfer"] == $objResult3["tranfer_name"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>
<option value="<?php echo $objResult3["tranfer_name"];?>"<?php echo $sel;?>><?php echo $objResult3["tranfer_name"];?></option>
<?php
}
?>
</select>
</div>
<div class="w3-bar">
<?php
if($objResult["account_approve"]=='1'){
?>
<input type="checkbox" name="account_approve" checked='checked' value="1">
<?php
}else{
	?>
<input type="checkbox" name="account_approve" value="1">


		<?php
}
			?>
			</div>
<div class="w3-bar">
วันที่โอน <input type="date" name="transfer_date" id="transfer_date" value="<?php echo $objResult['transfer_date']; ?>" class="w3-input" readonly>
</div>
<div class="w3-bar">
จำนวนเงินโอน/เก็บปลายทาง <input type="text" name="amount" value="<?php echo $objResult['amount']; ?>" class="w3-input" readonly>
</div>
</div><!--bill-->
<div class="w3-half w3-container w3-border"><!--post detail-->
<h4><font color="#FF0000"><b>ใช้สำหรับจ่าหน้าพัสดุเท่านั้น</b></font></h4>
<div class="w3-bar">
ชื่อผู้รับสินค้า
<input name="delivery_name" type="text" value="<?php echo $objResult['delivery_name']; ?>" class="w3-input" readonly>
</div>
<div class="w3-bar">
ที่อยู่ในการจัดส่ง
<input name="address1" class="w3-input" value="<?php echo $objResult['address1']; ?>" type="text" readonly>
<input name="address2" class="w3-input" value="<?php echo $objResult['address2']; ?>" type="text" readonly>
</div>
<div class="w3-bar">
จังหวัด

<select name="province" class="w3-select" >
<option class="w3-bar" value=""></option>
<?php
$province="select * from tb_province order by province_name";
$prosql=mysqli_query($conn,$province);
while ($fepro=mysqli_fetch_array($prosql)) {
if($objResult["province"] == $fepro["province_ID"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>
<option class="w3-bar" value="<?php echo $fepro["province_ID"]; ?>"<?php echo $sel;?>><?php echo $fepro["province_name"]; ?></option>
<?php } ?>
</select>
</div>
<div class="w3-bar">
รหัสไปรษณีย์ <input name="postcode" type="text" value="<?php echo $objResult['postcode']; ?>" class="w3-input" readonly>
</div>
<div class="w3-bar">
โทรศัพท์ <input name="tel" type="text" value="<?php echo $objResult['tel']; ?>" class="w3-input" readonly>
</div>
</div><!--post detail-->
</div><!-- close so -->

<div id="mo" class="w3-container city" style="display:none">
<div class="w3-third"><!-- 1st 3rd -->
<div class="w3-bar">
ชื่อผู้แนะนำ <input name="prefer_name" value="<?php echo $objResult['prefer_name']; ?>" class="w3-input" readonly>
</div>
<div class="w3-bar">
ใบสั่งซื้อเลขที่
<input name="order_no" value="<?php echo $objResult['order_no']; ?>" class="w3-input" readonly>
</div>
<div class="w3-bar">
กำหนดส่งตามสัญญา
<input name="delivery_contract" value="<?php echo $objResult['delivery_contract']; ?>" class="w3-input" readonly>
</div>
<div class="w3-bar">
เคลียร์ใบจอง
<input name="clear_book_no" value="<?php echo $objResult['clear_book_no']; ?>" class="w3-input" placeholder="เลขที่" readonly>
</div>
<div class="w3-bar">
เคลียร์ใบยืม BRN
<input name="clear_brn_no" value="<?php echo $objResult['clear_brn_no']; ?>" class="w3-input" placeholder="เลขที่" readonly>
</div>
<div class="w3-bar">
เคลียร์ใบยืม BRNP
<input name="clear_brnp_no" value="<?php echo $objResult['clear_brnp_no']; ?>" class="w3-input" placeholder="เลขที่" readonly>
</div>
</div><!-- 1st 3rd -->
<div class="w3-third w3-container"><!-- 2nd 3rd -->
<div class="w3-bar">
ต้องการ SN
<input name="sn" value="<?php echo $objResult['sn']; ?>" class="w3-input" readonly>
</div>
<div class="w3-bar">
BQ เลขที่
<input name="bq" value="<?php echo $objResult['bq']; ?>" class="w3-input" readonly>
</div>
<div class="w3-bar">
OT เลขที่
<input name="ot" value="<?php echo $objResult['ot']; ?>" class="w3-input" readonly>
</div>
<div class="w3-bar">
รับประกัน (ปี)
<input name="warranty" value="<?php echo $objResult['warranty']; ?>" class="w3-input" readonly>
</div>
<div class="w3-bar">
Cal (ครั้ง/ปี)
<input name="cal" value="<?php echo $objResult['cal']; ?>" class="w3-input" readonly>
</div>
<div class="w3-bar">
PM (ครั้ง/ปี)
<input name="pm" value="<?php echo $objResult['pm']; ?>" class="w3-input" readonly>
</div>
</div><!-- 2nd 3rd -->
<div class="w3-third"><!-- 3rd 3rd -->
<div class="w3-bar">
สถานที่ติดตั้งเครื่อง
<input name="install_place" value="<?php echo $objResult['install_place']; ?>" class="w3-input" readonly>
</div>
<div class="w3-bar">
<?php
if($objResult["with_pr"]=='1'){
?>
<input name="with_pr" type="checkbox" checked='checked' value="1">
<?php
}else{
?>
<input name="with_pr" type="checkbox" value="1">

	<?php
}
	?> แนบใบเสนอราคา
</div>
<div class="w3-bar">
<?php
if($objResult["type_com"]=='1'){
?>
<input type="checkbox" name="type_com" checked='checked' value="1">

<?php
}else{
	?>
		<input type="checkbox" name="type_com" value="1">
<?php
}
		?> พิมพ์ตามคอม
</div>
<div class="w3-bar">
 <?php
if($objResult["type_po"]=='1'){
?>
<input type="checkbox" name="type_po" checked='checked' value="1">

<?php
}else{
	?>
<input type="checkbox" name="type_po" value="1">
		<?php
}
			?>
			พิมพ์ตามใบสั่งซื้อ
 </div>
<div class="w3-bar">
<?php
if($objResult["type_type"]=='1'){
?>
<input type="checkbox" name="type_type" checked='checked' value="1">
<?php
}else{
	?>
		<input type="checkbox" name="type_type" value="1">

<?php
}
	?>
	พิมพ์ตามทีเขียน
 </div>
<div class="w3-bar">
ระบุ
<textarea name="type_type_detail" class="w3-input" style="resize: none;width:100%" readonly><?php echo $objResult["type_type_detail"]; ?></textarea>
</div>
</div><!-- 3rd 3rd -->
</div><!-- close more -->

<div id="ck" class="w3-container city" style="display:none">
หมายเลขคำสั่งซื้อ
<input name="order_id" class="w3-input w3-sand" value="<?php echo $objResult['order_id']; ?>"  type="text" readonly>
ชื่อลูกค้าตามคำสั่งซื้อ
<input name="order_name" class="w3-input w3-sand" value="<?php echo $objResult['order_name']; ?>"  type="text" readonly>
เลขที่เอกสาร
<input name="iv_number" class="w3-input w3-sand" value="<?php echo $objResult['iv_number']; ?>"  type="text" readonly>
ชื่อที่ออกบิล
<input name="name_iv" class="w3-input w3-sand" value="<?php echo $objResult['name_iv']; ?>"  type="text" readonly>
รหัสอ้างอิงการส่ง
<input name="order_refer_code" class="w3-input w3-sand" value="<?php echo $objResult['order_refer_code']; ?>"  type="text" readonly>
</div><!-- close more -->
</div><!-- right half -->
 
<div class="w3-bar w3-light-grey w3-border">
  <a class="w3-bar-item w3-button" onclick="openCity1('stoc')"><font color="#404040"><b>ส่วนงานคลังสินค้า-2</b></font></a>
  <a class="w3-bar-item w3-button" onclick="openCity1('cs')"><font color="#404040"><b>รายละเอียดการจัดส่ง</b></font></a>
  <a class="w3-bar-item w3-button" onclick="openCity1('ot')"><font color="#404040"><b>ปิดงาน</b></font></a>
</div>

<div id="cs" class="w3-container city1" style="display:none">
<div class="w3-quarter"><!-- 1st 4nd -->
<input type="checkbox" name="" hidden><br \>
<div class="w3-bar">วันที่ส่ง <input type="date" name="delivery_date" value="<?php echo $objResult['delivery_date']; ?>"  class="w3-input" readonly></div>
<div class="w3-bar">เวลาส่ง <input type="text" name="delivery_time" value="<?php echo $objResult['delivery_time']; ?>"  class="w3-input" readonly></div>
<div class="w3-bar">การส่งสินค้า</div>
<?php
if($objResult["delivery_company"]=='1'){
?>
<input type="checkbox" name="delivery_company" checked='checked' value="1">&nbsp;บริษัทจัดส่ง<br />
<?php
}else{
	?>
<input type="checkbox" name="delivery_company" value="1">&nbsp;บริษัทจัดส่ง<br />
<?php
}
if($objResult["big_car"]=='1'){
		?>
<input type="checkbox" name="big_car" checked='checked' value="1">&nbsp;ต้องการรถใหญ่<br />
<?php
}else{
			?>

<input type="checkbox" name="big_car" value="1">&nbsp;ต้องการรถใหญ่<br />
<?php
		}
if($objResult["call_before"]=='1'){
	?>

<input type="checkbox" name="call_before" checked='checked' value="1">&nbsp;โทรแจ้งลูกค้าก่อนไป<br />
<?php
}else{
	?>
<input type="checkbox" name="call_before" value="1">&nbsp;โทรแจ้งลูกค้าก่อนไป<br />

		<?php
}
		if($objResult["maps"]=='1'){
			?>
<input type="checkbox" name="maps" checked='checked' value="1">&nbsp;มีแผนที่ประกอบ<br />
<?php
		}else{
				?>
<input type="checkbox" name="maps" value="1">&nbsp;มีแผนที่ประกอบ<br />

<?php
}
if($objResult["assign_date_time"]=='1'){
						?>
<input type="checkbox" name="assign_date_time" checked='checked' value="1">&nbsp;นัดวันเวลาเรียบร้อยแล้ว<br />
<?php
}else{
							?>
<input type="checkbox" name="assign_date_time" value="1">&nbsp;นัดวันเวลาเรียบร้อยแล้ว<br />
<?php
						}
								?>
</div><!-- 1st 3rd -->
<div class="w3-container w3-quarter"><!-- 2nd 4nd -->
<div class="w3-bar">
<?php
if($objResult["delivery_sale"]=='1'){
?>
<input type="checkbox" name="delivery_sale" checked='checked' value="1">&nbsp;Sale รับเอง
<?php
}else{
	?>
<input type="checkbox" name="delivery_sale" value="1">&nbsp;Sale รับเอง

<?php
}
if($objResult["delivery_engineer"]=='1'){
?>
<input type="checkbox" name="delivery_engineer" checked='checked' value="1">&nbsp;ช่างรับเอง

<?php
}else{
	?>
		<input type="checkbox" name="delivery_engineer" value="1">&nbsp;ช่างรับเอง
<?php
}
		
		if($objResult["delivery_customer"]=='1'){
?>
<input type="checkbox" name="delivery_customer" checked='checked' value="1">&nbsp;ลูกค้ารับเอง <br />

<?php
		}else{
	?>
		<input type="checkbox" name="delivery_customer" value="1">&nbsp;ลูกค้ารับเอง <br />
<?php
}
	?>
	</div>
<div class="w3-bar">
สถานที่ส่งสินค้า <textarea name="delivery_place" class="w3-input" cols="20" rows="1" style="width:100%;resize: none" readonly><?php echo $objResult["delivery_place"]; ?></textarea>
</div>
<div class="w3-bar">
ชื่อผู้ติดต่อ/TEL. <input type="text" name="delivery_contact" value="<?php echo $objResult["delivery_contact"]; ?>" class="w3-input" readonly>
</div>
</div><!-- 2nd 3rd -->
<div class="w3-quarter"><!-- 3rd 4nd -->
<div class="w3-bar">
<?php
if($objResult["returns"]=='1'){
?>
<input type="checkbox" name="returns" checked='checked' value="1">&nbsp;รับคืนสินค้า<br>
<?php
}else{
	?>
<input type="checkbox" name="returns" value="1">&nbsp;รับคืนสินค้า<br>
<?php
}
	?>
	</div>
<div class="w3-bar">วันที่รับคืน <input type="text" name="return_date" value="<?php echo $objResult["return_date"]; ?>" class="w3-input" readonly></div>
<div class="w3-bar">เวลา <input type="text" name="return_time" value="<?php echo $objResult["return_time"]; ?>" class="w3-input" readonly></div>
<div class="w3-bar">ที่อยู่รับคืนสินค้า <input type="text" name="return_address"  value="<?php echo $objResult["return_address"]; ?>" class="w3-input" readonly></div>
<div class="w3-bar">ชื่อผู้ติดต่อ/TEL. <input type="text" name="return_contact" value="<?php echo $objResult["return_contact"]; ?>" class="w3-input" readonly></div>
</div><!-- 3rd 4nd -->
<div class="w3-quarter w3-container"><!-- 4nd 4nd -->
<a href="report_loanptl.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-purple">ใบยืม PTL</a><br />
<a href="report_saleptl.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-deep-purple">ใบสั่งขาย PTL</button></a><br />
<a  href="report_loannbm.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-pale-red">ใบยืม NBM</a><br />
<a href="report_salenbm.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-pink">ใบสั่งขาย NBM</a>
</div><!-- 4nd 4nd -->
</div><!-- cs -->

<div id="stoc" class="w3-container city1" >

<?php include ('table_stock3.php'); ?>





</div>
</br>
<center>

 <input type="button" name ="Submit" value="บันทึก" class = "button button4" onClick="this.form.action='register_stock_edit1.php'; submit()">

</center>
<?php require_once('foot.php'); ?>
</div>
</form>
</body>
</html>