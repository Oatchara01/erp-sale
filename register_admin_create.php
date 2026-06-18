<?php include('head.php'); ?>
<body>
<?php
$strSQL = "SELECT * FROM so__main WHERE ref_id = '".$_GET["ref_id"]."' ";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);
?>
<form action="register_admin_edit1.php" method="post" name="frmMain" >
<div class="w3-container w3-padding-large"><!-- main div -->
<div class="w3-container w3-panel w3-light-gray"><h4>Edit Data : Admin</h4></div>
<div class="w3-container w3-half"><!-- first half -->
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
<div class="w3-panel">
<?php
	$date = explode('-' , $objResult["register_date"] );
$xdate = $date[2].'-'.$date[1].'-'.$date[0];
 /*echo $xdate;*/?>
<?php
$sql1 = "select * from so__main order by main_id desc limit 1";
$query1 = mysqli_query($conn,$sql1);
$fetch1 = mysqli_fetch_array($query1,MYSQLI_ASSOC); ?>


วันที่ : <span class="w3-light-grey"><?php echo datethai($xdate); ?></span>เลขที่อ้างอิง : <span name="ref_id" class="w3-light-grey"><?php echo $fetch1['ref_id']+1; ?></span> <input type="hidden" name="main_id" value="<?php echo $fetch1['main_id']+1; ?>"><input type="hidden" name="ref_id" value="<?php echo $fetch1['ref_id']+1; ?>"><br />
<input type="hidden" name="register_date" value="<?php echo $objResult['register_date']; ?>">
<input type="hidden" name="register_time" value="<?php echo $objResult['register_time']; ?>">
</div>
<div class="w3-bar">
ช่องทางการขาย
<select name="sale_channel" id="sale_channel" class="w3-select" onchange="showUser(this.value)">
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
<div class="w3-bar">
การจัดส่ง
<select name="delivery" class="w3-select"  >
<option value="">**Please Select Item**</option>

<?php
$sqldeli = "SELECT tb_delivery.*,tb_sender.* FROM tb_delivery LEFT JOIN tb_sender ON tb_delivery.employee_send=tb_sender.sender_ID";
$querydeli = mysqli_query($conn,$sqldeli);
if (!$querydeli) {
	echo "Failed to fetch to MySQL: " . mysqli_error();
}
while ($fetchdeli = mysqli_fetch_array($querydeli,MYSQLI_ASSOC)) {
if($objResult["delivery"] == $fetchdeli["delivery_ID"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>
<option class="w3-bar-item w3-button" value="<?php echo $fetchdeli['delivery_id'];?>"><?php echo $fetchdeli['delivery_name'];?> | <?php echo $fetchdeli['time_delivery']; ?> | <?php echo $fetchdeli['remark']; ?><?php echo $fetchdeli['packing_remark'];?></option>
<?php } ?>
</select>
</div>
<div class="w3-padding-small"></div>
<div class="w3-bar">
การชำระเงิน:
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
<div class="w3-bar">
หมายเหตุ:
<textarea name="sale_remark"  class="w3-input" id="sale_remark"  rows="1"><?php echo $objResult['sale_remark']; ?></textarea>
</div>
<div class="w3-padding-small"></div>
<div class="w3-bar">
ชื่อพนักงาน:
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
</div><!-- first half -->

<div class="w3-container w3-half"><!-- second half -->
<div class="w3-bar w3-light-grey w3-border">
  <a class="w3-bar-item w3-button" onclick="openCity('st')"><font color="#404040"><b>Admin ลงทะเบียน</b></font></a>
  <a class="w3-bar-item w3-button" onclick="openCity('so')"><font color="#404040"><b>ใบสั่งขาย</b></font></a>
  <a class="w3-bar-item w3-button" onclick="openCity('mo')"><font color="#404040"><b>เพิ่มเติม</b></font></a>
  <a class="w3-bar-item w3-button"  onclick="openCity('br')"><font color="#404040"><b>ใบยืมสินค้า</b></font></a>
</div>

<div id="st" class="w3-container city" >
<div class="w3-half"><!-- first right half -->
<div class="w3-half w3-bar">
เลขที่เอกสาร <input name="doc_no" class="w3-input" value="<?php echo $objResult['doc_no']; ?>" type="text">
</div>
<div class="w3-container w3-half w3-bar">
เลขที่ลงงาน <input name="job_id" class="w3-input" value="<?php echo $objResult['job_id']; ?>" type="text">
</div>
<div class="w3-bar">
วันที่ออกเอกสาร <input name="doc_release_date" class="w3-input" value="<?php echo $objResult['doc_release_date']; ?>" type="date">
</div>

<div class="w3-bar">
<a href="report_loanptl.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-purple">ใบยืม PTL</a>
<a href="report_saleptl.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-deep-purple">ใบสั่งขาย PTL</button></a><br />
</div>

<div class="w3-bar">
<a  href="report_loannbm.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-pale-red">ใบยืม NBM</a>
<a href="report_salenbm.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-pink">ใบสั่งขาย NBM</a>
</div>
ใบปะหน้ากล่อง :<br />

<a href="report_99std.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-purple">99std</a> 
<a href="report_a5ptl.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-blue">a5ptl</a> 
<a href="report_a4ptl.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-blue">a4ptl</a> 
<a href="report_a5nbm.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-pink">a5nbm</a>  
<a href="report_a4nbm.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-pink">a4nbm</a> 
 
<a href="report_99std_k.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-purple">99std+k</a> 
<a href="report_a5ptl_k.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-blue">a5ptl+k</a> 
<a href="report_a4ptl_k.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-blue">a4ptl+k</a> 
<a href="report_a5nbm_k.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-pink">a5nbm+k</a> 
<a href="report_a4nbm_k.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-pink">a4nbm+k</a>
</div><!-- first right half -->

<div class="w3-half"><!-- second right half -->
<div class="w3-bar w3-left w3-half">
<a href="" target="_blank" class="w3-button w3-blue" style="width:100%;">สรุปยืมแบบรวม PTL</a>
</div>
<div class="w3-bar w3-right w3-half">
<a href="" target="_blank" class="w3-button w3-pink" style="width:100%;">สรุปยืมแบบรวม NBM</a>
</div>
<div class="w3-bar w3-center">
<a href="" target="_blank" class="w3-button w3-purple" style="width:100%;">รายชื่อที่ต้องการออกบิล</a>
</div>
<div class="w3-bar">
<?php
if ($objResult['job_id']=='1'){
?>
คลิ๊กสมบูรณ์เมื่อออกบิลแล้ว <input type='checkbox' name='admin_commplete' checked='checked' value='1'>
<?php
}else{
	?>
คลิ๊กสมบูรณ์เมื่อออกบิลแล้ว <input type='checkbox' name='admin_commplete' value='1'>

		<?php
}
			?>
</div>
</div><!-- second right half -->
</div><!-- close st -->

<div id="so" class="w3-container city" style="display:none">
<div class="w3-half w3-container"><!--first half-->
<div class="w3-bar">
ชื่อที่ออกบิล: <input name="billing_name" type='text' class="w3-input" value="<?php echo $objResult['billing_name']; ?>">
</div>
<div class="w3-bar">
ทีอยู่ที่ออกบิล: <textarea name="billing_address" class="w3-input" rows="1"><?php echo $objResult['billing_address']; ?></textarea>
</div>
<div class="w3-bar w3-half">
Tel.: <input type="text" name="billing_tel" class="w3-input" value="<?php echo $objResult['billing_tel']; ?>">
</div>
<div class="w3-bar w3-half">
<?php
if($objResult['full_bill']=='1'){
?>
<input type="checkbox" name="full_bill" checked='checked' value="1"> บิล VAT
<?php
}else{
	?>
<input type="checkbox" name="full_bill" value="1"> บิล VAT
		<?php
}
?>
</div>
<div class="w3-bar">
การชำระเงิน:
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
<div class="w3-bar">
การโอนเงิน:
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
ส่งบัญชีตรวจสอบ
<?php
if ($objResult["account_approve"]=='1'){
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
วันที่โอน
<input type="date" name="transfer_date" id="transfer_date" class="w3-input" value="<?php echo $objResult["transfer_date"];?>">
</div>
<div class="w3-bar">
จำนวนเงินโอน/เก็บปลายทาง
<input type="text" name="amount" class="w3-input" value="<?php echo $objResult["amount"];?>">
</div>
</div><!-- first half -->
<div class="w3-half w3-container w3-border"><!--second half-->
<h4><font color="#FF0000"><b>ใช้สำหรับจ่าหน้าพัสดุเท่านั้น</b></font></h4>
ชื่อผู้รับสินค้า
<input name="delivery_name" type="text" class="w3-input" value="<?php echo $objResult["delivery_name"];?>">
ที่อยู่ในการจัดส่ง
<input name="address1" class="w3-input" type="text" value="<?php echo $objResult["address1"];?>">
<input name="address2" class="w3-input" type="text" value="<?php echo $objResult["address2"];?>">
จังหวัด
<select name="province" class="w3-select">
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
รหัสไปรษณีย์
<input name="postcode" type="text" value="<?php echo $objResult["postcode"];?>" class="w3-input">
โทรศัพท์
<input name="tel" type="text"  value="<?php echo $objResult["tel"];?>" class="w3-input">
</div><!-- second half -->
</div><!-- close so -->

<div id="mo" class="w3-container city" style="display:none">
<div class="w3-third"><!-- 1st 3rd -->
ชื่อผู้แนะนำ
<input name="prefer_name" class="w3-input" value="<?php echo $objResult["prefer_name"];?>" >
ใบสั่งซื้อเลขที่
<input name="po_no" class="w3-input" value="<?php echo $objResult["po_no"];?>" >
กำหนดส่งตามสัญญา:
<input name="delivery_contract" class="w3-input" value="<?php echo $objResult["delivery_contract"];?>" >
เคลียร์ใบจอง:
<input name="clear_book_no" class="w3-input" value="<?php echo $objResult["clear_book_no"];?>" placeholder="เลขที่" >
เคลียร์ใบยืม BRN:
<input name="clear_brn_no" class="w3-input" value="<?php echo $objResult["clear_brn_no"];?>" placeholder="เลขที่" >
เคลียร์ใบยืม BRNP:
<input name="clear_brnp_no" class="w3-input" value="<?php echo $objResult["clear_brnp_no"];?>" placeholder="เลขที่" >
</div>
<div class="w3-third w3-container"><!-- 2nd 3rd -->
ต้องการ SN:
<input name="sn" class="w3-input" value="<?php echo $objResult["sn"];?>" >
BQ เลขที่:
<input name="bq" class="w3-input" value="<?php echo $objResult["bq"];?>" >
OT เลขที่:
<input name="ot" class="w3-input" value="<?php echo $objResult["ot"];?>" >
รับประกัน (ปี)
<input name="warranty" class="w3-input" value="<?php echo $objResult["warranty"];?>" >
Cal (ครั้ง/ปี)
<input name="cal" class="w3-input" value="<?php echo $objResult["cal"];?>" >
PM (ครั้ง/ปี)
<input name="pm" class="w3-input" value="<?php echo $objResult["pm"];?>" >
</div>
<div class="w3-third"><!-- 3rd 3rd -->
สถานที่ติดตั้งเครื่อง
<input name="install_place" class="w3-input" value="<?php echo $objResult["install_place"];?>" ><br />
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
			?>
แนบใบเสนอราคา<br />

<?php 
if($objResult["type_com"]=='1'){
?>
<input type="checkbox" checked='checked' name="type_com" value="1">

<?php
}else{
	?>
<input type="checkbox" name="type_com" value="1">

		<?php
}
			?>
พิมพ์ตามคอม<br />

<?php 
if($objResult["type_so"]=='1'){
?>
<input type="checkbox" name="type_so" checked='checked' value="1">

<?php
}else{
	?>
<input type="checkbox" name="type_so" value="1">

		<?php
}
			?>
พิมพ์ตามใบสั่งซื้อ<br />
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
พิมพ์ตามที่เขียน<br />
ระบุ:
<textarea name="type_type_detail" class="w3-input" style="resize: none;width:100%"><?php echo $objResult["type_type_detail"];?></textarea>
</div>
</div><!-- close more -->

<div id="br" class="w3-container city" style="display:none">
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
วัตถุประสงค์การเบิก: <input name='objective'  class='w3-input' value="<?php echo $row["salechannel_nameshort"];?>"/>
</div>
<div class="w3-bar">
หมายเลขคำสั่งซื้อ: <input type='text' class='w3-input' name='order_id'  value="<?php echo $objResult["order_id"]; ?>">
</div>
<div class="w3-bar">
ชื่อลูกค้าตามคำสั่งซื้อ: <input type='text' class='w3-input' name='order_name' value="<?php echo $objResult["order_name"]; ?>" >
</div>
<div class="w3-bar">
ชื่อลูกค้า: <span class="w3-padding-small"><?php echo $row["salechannel_nameshort"];?></span>
</div>
<div class="w3-bar">
วันที่: <span class="w3-padding-small"><?php echo DateThai($objResult["register_date"]); ?></span>
</div>
<div class="w3-bar">
เลขที่เอกสาร: <span class="w3-padding-small"><?php echo $objResult["doc_no"];?></span>
</div>
<div class="w3-bar">
เลขที่ลงงาน: <span class="w3-padding-small"><?php echo $objResult["job_id"];?></span>
</div>
<div class="w3-bar">
วันที่ออกเอกสาร: <span class="w3-padding-small"><?php echo $objResult["doc_release_date"];?></span>
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
</div><!-- close br -->
</div><!-- second half -->

<div class="w3-bar w3-light-grey w3-border">
    <a class="w3-bar-item w3-button" onclick="openCity1('stoc')"><font color="#404040"><b>เอกสารแนบเพิ่มเติม</b></font></a>
	<a class="w3-bar-item w3-button" onclick="openCity1('pd')"><font color="#404040"><b>รายการสินค้า</b></font></a>
	<a class="w3-bar-item w3-button" onclick="openCity1('cs')"><font color="#404040"><b>รายละเอียดการจัดส่ง</b></font></a>
	<a class="w3-bar-item w3-button" onclick="openCity1('ot')"><font color="#404040"><b>ปิดงาน</b></font></a>
</div>

<div id="stoc" class="w3-container city1" style="display:none">
<div class="w3-quarter w3-container">
<b>เอกสารเพิ่มเติม Lazada</b><br />
1. ใบบาร์โค้ด<br />
2. รายละเอียดลูกค้า<br />
3.<br />
4.<br />
5.
</div>
<div class="w3-quarter w3-container">
<b>เอกสารเพิ่มเติม 99 HM</b><br />
1. Slip<br />
2. รายละเอียดลูกค้า<br />
3.<br />
4.<br />
5.
</div>
<div class="w3-quarter w3-container">
<b>เอกสารเพิ่มเติม 11 Street</b><br />
1. ใบบาร์โค้ด<br />
2. รายละเอียดลูกค้า<br />
3.<br />
4.<br />
5.
</div>
</div>

<div id="pd" class="w3-container city1">

<?php 
$strSQL1 = "SELECT * FROM so__submain WHERE ref_idd = '".$_GET["ref_id"]."' ";
///echo $strSQL;
//exit();
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
?>
<table width="100%" border="0" class="w3-table">
<tr>
	<td><div class="w3-center"><h5>No.</h5></div></td>
    <td><div class="w3-center"><h5>Product Code</h5></div></td>
    <td><div class="w3-center"><h5>Product Name</h5></div></td>
    <td><div class="w3-center"><h5>Unit Name</h5></div></td>
    <td><div class="w3-center"><h5>Sale Count</h5></div></td>
    <td><div class="w3-center"><h5>Product Price</h5></div></td>
    <td><div class="w3-center"><h5>Amount</h5></div></td>
    <td><div class="w3-center"><h5>Sale Remark</h5></div></td>
    <td><div class="w3-center"><h5>Stock Remark</h5></div></td>
</tr>
<?php
$i = 1;
while($objResult1 = mysqli_fetch_array($objQuery1))
{
?>
<tr>
<td><?=$i?> <input type='hidden' name = "Number_run<?php echo $i;?>" style="color:black;text-align:center" id = "Number_run[]<?php echo $objResult1["id"];?>" value ="<?php echo $i;?>" />   <input type='hidden' name = "id[]" value="<?php echo $objResult1["id"];?>" id = "id[]"    size='16' readonly/> 

</td>
<td style="width:15%;">
<select name="product[]<?php echo $objResult1["id"];?>" class="w3-select" onchange="document.getElementById('product_code<?php echo $i;?>').value = this.value.split('|')[0];

document.getElementById('product_name<?php echo $i;?>').value  = this.value.split('|')[1]; 
document.getElementById('unit_name<?php echo $i;?>').value  = this.value.split('|')[2];
document.getElementById('product_price<?php echo $i;?>').value  = this.value.split('|')[3];
">
<option value=""></option>
<?php
$strSQL2 = "SELECT * FROM tb_product ORDER BY product_ID ASC";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
while($objResult2 = mysqli_fetch_array($objQuery2))
{
if($objResult1["product_code"] == $objResult2["product_code"])
{
$sel = "selected";
}
else
{
$sel = ""; 
}
?>
<option value="<?php echo $objResult2["product_code"];?>|<?php  echo $objResult2["product_name"];?>|<?php  echo $objResult2["unit_name"];?>|<?php  echo $objResult2["product_price"];?>" <?php echo $sel;?>><?php echo $objResult2["product_code"];?> |<?php  echo $objResult2["product_name"];?>|<?php  echo $objResult2["unit_name"];?>|<?php  echo $objResult2["product_price"];?></option>

<?php
}
?>
</select>

 <input type='hidden' name = "product_code[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["product_code"];?>" id = "product_code[]<?php echo $objResult1["id"];?>"      size='16' readonly/>  


</div></td>

<td> <input type='text' name = "product_name[]<?php echo $objResult1["id"];?>"  value="<?php echo $objResult1["product_name"];?>" id = "product_name[]<?php echo $objResult1["id"];?>"  class="w3-input" readonly></textarea></td>

<td><input type='text' name = "unit_name[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["unit_name"];?>" id = "unit_name[]<?php echo $objResult1["id"];?>"  class="w3-input"    size='9' readonly/></td>

<td><input type='text' name = "sale_count[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["sale_count"];?>" id = "sale_count[]<?php echo $objResult1["id"];?>"  class="w3-input" style="color:black;text-align:center"   size='7' /></td>

<td><input type='text' name = "product_price[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["price_per_unit"];?>" id = "product_price[]<?php echo $objResult1["id"];?>"  class="w3-input"  style="color:black;text-align:right"   size='10' /></td>

<td><input type='text' name = "sum_amount[]<?php echo $objResult1["id"];?>" value="<?php  $amount=$objResult1["amount"]; echo number_format( $amount,2)."";?>" id = "sum_amount[]<?php echo $objResult1["id"];?>"  class="w3-input" style="color:black;text-align:right"  size='10' value="" jAutoCalc= '{sale_count<?php echo $i;?>} * {product_price<?php echo $i;?>}'/></td>
<?php/* */?>
<td><input type='text' name = "sale_remarkk[]<?php echo $objResult1["id"];?>"  id = "sale_remarkk[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["sale_remarkk"];?>" class="w3-input"    size='13' /></td>

<td><input type='text' name = "stock_remark[]<?php echo $objResult1["id"];?>"  id = "stock_remark[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["stock_remark"];?>" class="w3-input"    size='13' /></td>
</tr>
<?
	$i++;
}
?>
</table>
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
<input type="hidden" name="hdnLine" value="<?php echo $i;?>">
</div>

<div id="cs" class="w3-container city1" style="display:none">
<div class="w3-quarter"><!-- first third-->
<input type="checkbox" name="" hidden><br \>
วันที่ส่ง
<input type="date" name="delivery_date" value="<?php echo $objResult["delivery_date"];?>" class="w3-input" >
เวลาส่ง
<input type="text" name="delivery_time" value="<?php echo $objResult["delivery_time"];?>" class="w3-input" >
การส่งสินค้า<br>
<?php
if($objResult["delivery_company"]){
?>
<input type="checkbox" name="delivery_company" checked='checked' value="1">บริษัทจัดส่ง<br />
<?php
}else{
	?>
<input type="checkbox" name="delivery_company" value="1">บริษัทจัดส่ง<br />
		<?php
}
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
				if($objResult["assign_date_time"]){
						?>
<input type="checkbox" name="assign_date_time" checked='checked' value="1">นัดวันเวลาเรียบร้อยแล้ว<br />

<?php
				}else{
	?>
<input type="checkbox" name="assign_date_time" value="1">นัดวันเวลาเรียบร้อยแล้ว<br />
</div><!-- first third-->
<div class="w3-quarter w3-container"><!-- second third-->
<?php
}
		if($objResult["delivery_sale"]){
			?>
<input type="checkbox" name="delivery_sale" checked='checked' value="1">Sale รับเอง
<?php
		}else{
	?>
<input type="checkbox" name="delivery_sale" value="1">Sale รับเอง

		<?php
}
		if($objResult["delivery_engineer"]){
			?>
	
<input type="checkbox" name="delivery_engineer" checked='checked' value="1">ช่างรับเอง

<?php
		}else{
		?>
<input type="checkbox" name="delivery_engineer" value="1">ช่างรับเอง

			<?php
}
			if($objResult["delivery_customer"]){
				?>

<input type="checkbox" name="delivery_customer" checked='checked' value="1">ลูกค้ารับเอง <br />
<?php
			}else{
	?>
<input type="checkbox" name="delivery_customer" value="1">ลูกค้ารับเอง <br />

		<?php
}
		?>
สถานที่ส่งสินค้า:
<textarea name="delivery_place" class="w3-input" cols="20" rows="1" style="width:100%;resize: none" ></textarea>
ชื่อผู้ติดต่อ/TEL.:
<input type="text" name="delivery_contact" class="w3-input" >
</div><!-- second third-->
<div class="w3-quarter"><!-- 3rd third-->
<input type="checkbox" name="return" value="1">รับคืนสินค้า<br>
วันที่รับคืน
<input type="text" name="return_date" class="w3-input" >
เวลา
<input type="text" name="return_time" class="w3-input" >
ที่อยู่รับคืนสินค้า:
<input type="text" name="return_address" class="w3-input" >
ชื่อผู้ติดต่อ/TEL.:
<input type="text" name="return_contact" class="w3-input" >
</div><!-- 3rd third-->

<div class="w3-quarter w3-container">
<a href="report_loanptl.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-purple">ใบยืม PTL</a><br />
<a href="#" target="_blank" class="w3-button w3-deep-purple">ใบสั่งขาย PTL</button></a><br />
<a href="report_loannbm.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-pale-red">ใบยืม NBM</a><br />
<a href="#" target="_blank" class="w3-button w3-pink">ใบสั่งขาย NBM</a>
</div><!-- forth quarter -->
</div>
<center>
<input type="submit" name="submit" class="w3-button w3-teal" >
</center>

<?php require_once('foot.php'); ?>
</div>
</form>

</body>
</html>