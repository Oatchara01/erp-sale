<?php


include('head.php');
include('dbconnect_sale.php');



?>


<style type="text/css">
	<!--
	.style15 {
		font-size: 18px;
		color: #000000;
	}

	.style30 {
		font-size: 12;
	}

	.style32 {
		font-size: 11px
	}

	.style33 {
		font-size: 12px;
	}

	.style34 {
		color: #FF0000
	}

	.style35 {
		font-size: 14px;
		color: #f2f2f2;
	}

	.style37 {
		color: #FF0000;
		font-size: 14px;
	}

	.style38 {
		color: #f2f2f2
	}

	.style39 {
		font-size: 14px;
		color: #000000;
	}

	.style40 {
		font-size: 14px;
		color: #FF0000;
	}
	-->
	.button
	{
	background-color:
	#339900;
	border:
	none;
	color:
	white;
	padding:
	14px
	16px;
	text-align:
	center;
	text-decoration:
	none;
	display:
	inline-block;
	font-size:
	16px;
	margin:
	4px
	2px;
	cursor:
	pointer;
	}
	.button1
	{
	border-radius:
	2px;
	}
	.button2
	{
	border-radius:
	4px;
	}
	.button3
	{
	border-radius:
	8px;
	}
	.button4
	{
	border-radius:
	12px;
	}
	.button5
	{
	border-radius:
	50%;
	}
</style>


<body>
	<form method="post" name="frmMain" enctype="multipart/form-data">
		<div class="w3-white">
			<div class="w3-container w3-padding-large">
				<div class="w3-panel w3-light-gray">
					<h4>EDIT : CUSTOMER</h4>
				</div>
				<?php
				$strSQL = "SELECT *  FROM tb_customer WHERE customer_id = '" . $_GET["customer_id"] . "' ";
				$objQuery = mysqli_query($conn, $strSQL) or die(mysqli_error());
				$objResult = mysqli_fetch_array($objQuery);


				$strSQLmode = "SELECT *  FROM tb_mode_customer WHERE id_mode = '" . $objResult["mode_name"] . "' ";
				$objQuerymode = mysqli_query($conn, $strSQLmode) or die(mysqli_error());
				$objResultmode = mysqli_fetch_array($objQuerymode);
				?>
				<fieldset>
					<legend><b>
							<font color="red">ข้อมูลพื้นฐาน</font>
						</b></legend>
					</p>
					<!--div class="w3-container w3-third">
		เขตการขาย

<select name="sale_code" id="sale_code"  class="w3-input" >
<option value="">**Please Select**</option>
<?php

$strSQL6 = "SELECT * FROM tb_team_adm ORDER BY sale_code ASC";
$objQuery6 = mysqli_query($com, $strSQL6);
while ($objResuut6 = mysqli_fetch_array($objQuery6)) {
	if ($objResult["sale_code"] == $objResuut6["sale_code"]) {
		$sel = "selected";
	} else {
		$sel = "";
	}
?>
<option value="<?php echo $objResuut6["sale_code"]; ?>" <?php echo $sel; ?>><?php echo $objResuut6["sale_code"]; ?> - <?php echo $objResuut6["sale_name"]; ?></option>
<?php
}
?>
</select>
</div-->

					<div class="w3-container w3-third">
						ประเภทลูกค้า
						<select name="type_customer" id="type_customer" class="w3-input">
							<option value="">**Please Select Item**</option>
							<?php
							$strSQL5 = "select * from tb_typecustomer order by type_id";
							$objQuery5 = mysqli_query($conn, $strSQL5);
							if (!$objQuery5) {
								echo "Failed to fetch to MySQL: " . mysqli_error();
							}
							while ($objResuut5 = mysqli_fetch_array($objQuery5, MYSQLI_ASSOC)) {
								if ($objResult["type_customer"] == $objResuut5["type_id"]) {
									$sel = "selected";
								} else {
									$sel = "";
								}
							?>

								<option class="w3-bar-item w3-button" value="<?php echo $objResuut5['type_id']; ?>" <?php echo $sel; ?>><?php echo $objResuut5['type_name']; ?></option>
							<?php } ?>
						</select>



					</div>
					<div class="w3-container w3-third">
						รหัสลูกค้า AWL
						<input name="customer_code" value="<?php echo $objResult["customer_code"]; ?>" class="w3-input">
					</div>
					<div class="w3-container w3-third">
						รหัสลูกค้า NBM
						<input name="customer_coden" value="<?php echo $objResult["customer_coden"]; ?>" class="w3-input">
					</div>
					<div class="w3-container w3-third">
						คำนำหน้าชื่อ
						<input name="preface_name" value="<?php echo $objResult["preface_name"]; ?>" class="w3-input">


					</div>


					<div class="w3-container w3-third">
						กลุ่มลูกค้า
						<input name="mode_name" id="mode_name" placeholder="ค้นหากลุ่มลูกค้า..." value="<?php echo $objResultmode["mode_name"]; ?>" class="w3-input">
						<input name="h_mode_name" type='hidden' id="h_mode_name" value="<?php echo $objResult["mode_name"]; ?>" class="w3-input">
					</div>
					<div class="w3-container w3-third">
						หมายเหตุ(รหัสลูกค้าอื่นๆ)
						<textarea name="remark_cus" rows="2" class="w3-input"><?php echo $objResult["remark_cus"]; ?></textarea>
					</div>
					<?php if ($_SESSION["name"] == 'นงลักษณ์' or $_SESSION["name"] == 'อัจฉรา' or $_SESSION["name"] == 'พัชร์ชนัญ' or $_SESSION["name"] == 'สุดารัตน์' or $_SESSION["name"] == 'รุจิรา') { ?>
						<div class="w3-container w3-third">
							การชำระเงิน
							<select name="credit_ckk" id="credit_ckk" class="w3-input">
								<option value="">**Please Select Item**</option>
								<?php
								$strSQL5 = "select * from tb_bank where close_ckk ='0' order by id";
								$objQuery5 = mysqli_query($code, $strSQL5);
								if (!$objQuery5) {
									echo "Failed to fetch to MySQL: " . mysqli_error();
								}
								while ($objResuut5 = mysqli_fetch_array($objQuery5, MYSQLI_ASSOC)) {
									if ($objResult["credit_ckk"] == $objResuut5["id"]) {
										$sel = "selected";
									} else {
										$sel = "";
									}
								?>

									<option class="w3-bar-item w3-button" value="<?php echo $objResuut5['id']; ?>" <?php echo $sel; ?>><?php echo $objResuut5['pay_in']; ?></option>
								<?php } ?>
							</select>
						</div>

						<div class="w3-container w3-third">
							วงเงิน
							<input name="credit_thb" id="credit_thb" value="<?php echo number_format($objResult["credit_thb"], 2) . ""; ?>" style="color:black;text-align:right" class="w3-input">
						</div>

					<?php } ?>

					</p>
				</fieldset>
				</p>
				<fieldset>
					<legend><b>
							<font color="red">สิทธิ์การใช้งาน</font>
						</b></legend><br>

					<div class="w3-container ">
						เขตการขาย <font color="red">*</font><br>

						<?php
						$strSQL5 = "SELECT * FROM tb_team_all where 1";
						$objQuery5 = mysqli_query($com, $strSQL5);
						while ($objResuut5 = mysqli_fetch_array($objQuery5)) {

							$strSQL6 = "SELECT * FROM tb_selected_sales WHERE id_customer ='" . $_GET["customer_id"] . "' and sale_code ='" . $objResuut5["sale_code"] . "'";
							$objQuery6 = mysqli_query($conn, $strSQL6);
							$Num_Rows6 = mysqli_num_rows($objQuery6);
							$objResult6 = mysqli_fetch_array($objQuery6, MYSQLI_ASSOC);

						?>
							<div class="w3-container w3-third"><label>
									<?php if ($Num_Rows6 > 0) { ?>
										<input type="checkbox" name="sale_code[]" checked='checked' value="<?php echo $objResuut5["sale_code"]; ?>">
									<?php } else { ?>
										<input type="checkbox" name="sale_code[]" value="<?php echo $objResuut5["sale_code"]; ?>">
									<?php } ?>
									<?php echo $objResuut5["sale_code"]; ?>
								</label></div>
						<?php
						}
						?>
					</div>

					<br>
				</fieldset>
				</p>
				<fieldset>
					<legend><b>
							<font color="red">ข้อมูลลูกค้า</font>
						</b></legend>
					</p>


					<div class="w3-container w3-third">

						<?php /**/ ?>
						ชื่อลูกค้า
						<input name="customer_name" value="<?php echo $objResult["customer_name"]; ?>" class="w3-input">
						<input name="customer_id" type='hidden' value="<?php echo $objResult["customer_id"]; ?>" class="w3-input">

					</div>
					<div class="w3-container w3-third">
						ที่อยู่
						<input name="cus_address" value="<?php echo $objResult["cus_address"]; ?>" class="w3-input">
					</div>
					<div class="w3-container w3-third">
						เขต/อำเภอ
						<input name="cus_ampher" value="<?php echo $objResult["cus_ampher"]; ?>" class="w3-input">
					</div>




					<div class="w3-container w3-third">
						จังหวัด
						<select name="cus_province" class="w3-select">
							<option class="w3-bar" value="">**โปรดเลือกจังหวัด**</option>
							<?php
							$province = "select * from tb_province order by province_name";
							$prosql = mysqli_query($conn, $province);
							while ($fepro = mysqli_fetch_array($prosql)) {

								if ($objResult["cus_province"] == $fepro["province_name"]) {
									$sel = "selected";
								} else {
									$sel = "";
								} ?>
								<option class="w3-bar" value="<?php echo $fepro["province_name"]; ?>" <?php echo $sel; ?>><?php echo $fepro["province_name"]; ?></option>
							<?php } ?>
						</select>

					</div>
					<div class="w3-container w3-third">
						รหัสไปรษณีย์
						<input name="cus_postcode" value="<?php echo $objResult["cus_postcode"]; ?>" class="w3-input">
					</div>
					<div class="w3-container w3-third">
						โทรศัพท์
						<input name="cus_tel" value="<?php echo $objResult["cus_tel"]; ?>" maxlength="15" onKeyUp="if(isNaN(this.value)){ alert('กรุณากรอกตัวเลข'); this.value='';}" class="w3-input">
					</div>



					<div class="w3-container w3-third">
						แฟ็กซ์
						<input name="cus_fax" value="<?php echo $objResult["cus_fax"]; ?>" class="w3-input">
					</div>
					<div class="w3-container w3-third">
						<?php if ($objResult["vip_ckk"] == '1') { ?>
							<br><input type='checkbox' value='1' checked='checked' id='vip_ckk' name='vip_ckk'> ลูกค้า VIP
						<?php } else { ?>
							<br><input type='checkbox' value='1' id='vip_ckk' name='vip_ckk'> ลูกค้า VIP
						<?php } ?>
					</div>
					</p>
				</fieldset>
				</p>
				<fieldset>
					<legend><b>
							<font color="red">ข้อมูลการออกบิล</font>
						</b></legend>
					</p>

					<div class="w3-container w3-third">
						ชื่อที่ใช้ออกบิล
						<input name="bill_name" value="<?php echo $objResult["bill_name"]; ?>" class="w3-input">
					</div>
					<div class="w3-container w3-third">
						ที่อยู่ออกบิล
						<input name="bill_address" value="<?php echo $objResult["bill_address"]; ?>" class="w3-input">
					</div>


					<div class="w3-container w3-third">
						เขต/อำเภอ
						<input name="bill_ampher" value="<?php echo $objResult["bill_ampher"]; ?>" class="w3-input">
					</div>
					<div class="w3-container w3-third">

						จังหวัด
						<select name="billl_province" class="w3-select">
							<option class="w3-bar" value="">**โปรดเลือกจังหวัด**</option>
							<?php
							$province = "select * from tb_province order by province_name";
							$prosql = mysqli_query($conn, $province);
							while ($fepro = mysqli_fetch_array($prosql)) {

								if ($objResult["billl_province"] == $fepro["province_name"]) {
									$sel = "selected";
								} else {
									$sel = "";
								} ?>

								<option class="w3-bar" value="<?php echo $fepro["province_name"]; ?>" <?php echo $sel; ?>><?php echo $fepro["province_name"]; ?></option>
							<?php } ?>
						</select>


					</div>
					<div class="w3-container w3-third">
						รหัสไปรษณีย์
						<input name="bill_postcode" value="<?php echo $objResult["bill_postcode"]; ?>" class="w3-input">
					</div>


					<div class="w3-container w3-third">
						โทรศัพท์
						<input name="bill_tel" value="<?php echo $objResult["bill_tel"]; ?>" class="w3-input">
					</div>
					<div class="w3-container w3-third">
						TAX ID
						<input name="tax_id" value="<?php echo $objResult["tax_id"]; ?>" class="w3-input">
					</div>

					<div class="w3-container w3-third">
						<?php if ($objResult["h_ckk"] == '1') { ?>
							<input type="radio" name="h_ckk" id='h_ckk' checked='checked' value='1'>
						<?php } else { ?>
							<input type="radio" name="h_ckk" id='h_ckk' value='1'>
						<?php } ?>

						สำนักงานใหญ่
						<?php if ($objResult["h_ckk"] == '2') { ?>
							<input type="radio" name="h_ckk" id='h_ckk' checked='checked' value='2'>
						<?php } else { ?>
							<input type="radio" name="h_ckk" id='h_ckk' value='2'>
						<?php } ?>


						สาขา เลขที่ <input name="brun_no" value="<?php echo $objResult["brun_no"]; ?>" class="w3-input">
					</div>
					<div class="w3-container w3-third">
						E-Mail
						<input name="email_cus" value="<?php echo $objResult["email_cus"]; ?>" class="w3-input">
					</div>
					</p>
				</fieldset>
				</p>
				<fieldset>
					<legend><b>
							<font color="red">ข้อมูลการเช่า</font>
						</b></legend>
					</p>

					<div class="w3-container w3-third">
						ชื่อผู้เช่า
						<input name="rental_name" id="rental_name" value="<?php echo $objResult["rental_name"]; ?>" class="w3-input">
					</div>


					<div class="w3-container w3-third">
						ที่อยู่ผู้เช่า
						<input name="rental_address" id="rental_address" value="<?php echo $objResult["rental_address"]; ?>" class="w3-input">
					</div>
					<div class="w3-container w3-third">
						เขต/อำเภอ
						<input name="rental_ampher" id="rental_ampher" value="<?php echo $objResult["rental_ampher"]; ?>" class="w3-input">
					</div>
					<div class="w3-container w3-third">
						จังหวัด
						<select name="rental_province" class="w3-select">
							<option class="w3-bar" value="">**โปรดเลือกจังหวัด**</option>
							<?php
							$province = "select * from tb_province order by province_name";
							$prosql = mysqli_query($conn, $province);
							while ($fepro = mysqli_fetch_array($prosql)) {

								if ($objResult["rental_province"] == $fepro["province_name"]) {
									$sel = "selected";
								} else {
									$sel = "";
								} ?>

								<option class="w3-bar" value="<?php echo $fepro["province_name"]; ?>" <?php echo $sel; ?>><?php echo $fepro["province_name"]; ?></option>
							<?php } ?>
						</select>

					</div>


					<div class="w3-container w3-third">
						รหัสไปรษณีย์
						<input name="rental_postcode" id="rental_postcode" value="<?php echo $objResult["rental_postcode"]; ?>" class="w3-input">
					</div>
					<div class="w3-container w3-third">
						โทรศัพท์
						<input name="rental_tel" id="rental_tel" value="<?php echo $objResult["rental_tel"]; ?>" class="w3-input">
					</div>
					<div class="w3-container w3-third">
						ชื่อผู้ติดต่อกรณีฉุกเฉิน
						<input name="rental_emer" id="rental_emer" value="<?php echo $objResult["rental_emer"]; ?>" class="w3-input">
					</div>
					<div class="w3-container w3-third">
						โทรผู้ติดต่อกรณีฉุกเฉิน
						<input name="rental_emertel" id="rental_emertel" value="<?php echo $objResult["rental_emertel"]; ?>" class="w3-input">
					</div>
					<div class="w3-container w3-third">
						ชื่อผู้ติดต่อ
						<input name="rental_contact" id="rental_contact" value="<?php echo $objResult["rental_contact"]; ?>" class="w3-input">
					</div>
					<div class="w3-container w3-third">
						โทรผู้ติดต่อ
						<input name="rental_contacttel" id="rental_contacttel" value="<?php echo $objResult["rental_contacttel"]; ?>" class="w3-input">
					</div>
					<div class="w3-container w3-third">
						ชื่อผู้ป่วย
						<input name="patient_name" id="patient_name" value="<?php echo $objResult["patient_name"]; ?>" class="w3-input">
					</div>
					<div class="w3-container w3-third">
						สถานที่ติดตั้ง
						<textarea name="install_address" id="install_address" class="w3-input" rows="2" style="width:90%"><?php echo $objResult["install_address"]; ?></textarea>

					</div>

					</p>
				</fieldset>
				</p>
				<fieldset>
					<legend><b>
							<font color="red">ข้อมูลการจัดส่ง</font>
						</b></legend>
					</p>

					<div class="w3-container w3-third">
						ชื่อที่ใช้ในการจัดส่ง
						<input name="delivery_name" value="<?php echo $objResult["delivery_name"]; ?>" class="w3-input">
					</div>


					<div class="w3-container w3-third">
						ที่อยู่
						<input name="del_address" value="<?php echo $objResult["del_address"]; ?>" class="w3-input">
					</div>
					<div class="w3-container w3-third">
						เขต/อำเภอ
						<input name="del_ampher" value="<?php echo $objResult["del_ampher"]; ?>" class="w3-input">
					</div>
					<div class="w3-container w3-third">
						จังหวัด
						<select name="del_province" class="w3-select">
							<option class="w3-bar" value="">**โปรดเลือกจังหวัด**</option>
							<?php
							$province = "select * from tb_province order by province_name";
							$prosql = mysqli_query($conn, $province);
							while ($fepro = mysqli_fetch_array($prosql)) {

								if ($objResult["del_province"] == $fepro["province_name"]) {
									$sel = "selected";
								} else {
									$sel = "";
								} ?>

								<option class="w3-bar" value="<?php echo $fepro["province_name"]; ?>" <?php echo $sel; ?>><?php echo $fepro["province_name"]; ?></option>
							<?php } ?>
						</select>

					</div>


					<div class="w3-container w3-third">
						รหัสไปรษณีย์
						<input name="del_postcode" value="<?php echo $objResult["del_postcode"]; ?>" class="w3-input">
					</div>
					<div class="w3-container w3-third">
						โทรศัพท์
						<input name="del_tel" value="<?php echo $objResult["del_tel"]; ?>" class="w3-input">
					</div>
					<div class="w3-container w3-third">
						ผู้ติดต่อ
						<input name="contact_name" value="<?php echo $objResult["contact_name"]; ?>" class="w3-input">
					</div>

					<div class="w3-container w3-third">
						รับประกันสินค้า
						<input name="warranty" value="<?php echo $objResult["warranty"]; ?>" class="w3-input">
					</div>
					<div class="w3-container w3-third">
						<?php if ($objResult["close_ckk"] == '1') { ?>
							<input type="checkbox" name="close_ckk" id="close_ckk" checked='checked' value="1"> ปิดรายชื่อลูกค้า
						<?php } else { ?>
							<input type="checkbox" name="close_ckk" id="close_ckk" value="1"> ปิดรายชื่อลูกค้า
						<?php } ?>
					</div>


					</p>
				</fieldset>
				</p>





				<br>
				<center>
					<?php
					$name =	$_SESSION["name"];
					if ($_SESSION['user_type'] == "Engineer") {
					} else {
						//if($name=='ปิยะ' or $name=='พัชร์ชนัญ' or $name=='บรรจบพร' or $name=='สุภาวดี' or $name=='ขนิษฐา'){	
					?>
						<input type="button" name="Submit" value="บันทึก" class="button button4" onClick="this.form.action='edit_customer1.php'; submit()">
					<?php } ?>
				</center>

				<br>
			</div>
		</div>



		<div id="cr_bar"><?php include "foot.php"; ?></div>

	</form>

</body>

</html>

<script type="text/javascript">
	function make_autocom(autoObj, showObj) {
		var mkAutoObj = autoObj;
		var mkSerValObj = showObj;
		new Autocomplete(mkAutoObj, function() {
			this.setValue = function(id) {
				document.getElementById(mkSerValObj).value = id;
			}
			if (this.isModified)
				this.setValue("");
			if (this.value.length < 1 && this.isNotClick)
				return;
			return "data_mode_cus.php?bill_search=" + encodeURIComponent(this.value);
		});
	}

	// การใช้งาน
	// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
	make_autocom("mode_name", "h_mode_name");
</script>