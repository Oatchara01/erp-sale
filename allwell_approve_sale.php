<?php include('head.php'); ?>
<script src="dist/jautocalc.js"></script>
<link rel="stylesheet" href="css/autocomplete.css"  type="text/css"/>
<script type="text/javascript" src="js/autocomplete.js"></script>
<script>

function chkNumber(ele)
{
var vchar = String.fromCharCode(event.keyCode);
if ((vchar<'0' || vchar>'9') && (vchar != '.')) return false;
ele.onKeyPress=vchar;
}
</script>
<body>
<?php
$strSQL = "SELECT
so__main.*  ,tb_delivery.* ,tb_payment.*  FROM ((so__main  LEFT JOIN tb_delivery ON so__main.delivery=tb_delivery.delivery_id) LEFT JOIN tb_payment ON so__main.payment=tb_payment.payment_ID) WHERE ref_id = '".$_GET["ref_id"]."' ";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);
	
$sql26 = "SELECT *   FROM tb_comment_so where ref_id = '".$_GET["ref_id"]."'";
$qry26 = mysqli_query($conn,$sql26) or die(mysqli_error());
$rs26 = mysqli_fetch_assoc($qry26);
	
	
	
?>
<form  method="post" name="frmMain" action='allwell_approve.php' enctype="multipart/form-data" >
<div class="w3-white">
<div class="w3-container w3-padding-large"><!-- main div -->
<div class="w3-container w3-bar w3-light-gray w3-margin-bottom">
				<div class="w3-half">
					<h4>Register Data : Approve</h4>
				</div>
				<div class="w3-half">
				
<input type="submit" name="submit" id="submit" class="w3-button w3-green w3-center" value="Approve" >  
					
<a href="allwell_rejected.php?ref_id=<?php echo $objResult["ref_id"];?>" class="w3-button w3-red w3-center"><font color="330066">Rejected</font></a>

<?php if ($objResult["job_id"]!=''){ ?>
		
<a href="https://cs.allwellcenter.com/7112018.php?running=<?php echo $objResult["job_id"];?>" target="_blank" class="w3-button w3-grey w3-right"><font color="Blue">รายละเอียดจัดส่ง</font></a>

<?php } ?>								
<?php
if ($objResult["select_type_doc"]=='1'){
?>

<a href="report_loanptl.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey w3-right"><font color="Blue">ใบยืม AWL</font></a>&nbsp;&nbsp;
<?php
}

if ($objResult["select_type_doc"]=='2'){

?>

<a  href="report_loannbm.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey w3-right"><font color="DeepPink"> ใบยืม NBM</font></a>&nbsp;
<?php

}
if ($objResult["select_type_doc"]=='3'){

?>
	
<a href="report_saleptl1.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey w3-right"><font color="Blue">ใบสั่งขาย AWL</font></a>

<?php
}
if ($objResult["select_type_doc"]=='4'){

?>
		

<a href="report_salenbm1.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey w3-right"><font color="DeepPink">ใบสั่งขาย NBM</font></a>
<?php
}
?>					
					
	
				</div>
			</div>
<div class="w3-third"><!-- first half -->
<div class="w3-bar w3-border">


<?php
		if ($objResult["select_type_doc"]=='3'){
?>
<div class="w3-button"><input type="radio" name="select_type_doc" checked='checked' value="3" onclick="javascript:object();"  id="object3" >&nbsp;ใบสั่งขาย AWL</div>
<?php
	}else{
	?>
<div class="w3-button"><input type="radio" name="select_type_doc" value="3" onclick="javascript:object();"  id="object3" >&nbsp;ใบสั่งขาย AWL</div>
		<?php
}
			if ($objResult["select_type_doc"]=='4'){
			?>
<div class="w3-button"><input type="radio" name="select_type_doc" checked='checked' value="4" onclick="javascript:object();"  id="object4" >&nbsp;ใบสั่งขาย NBM</div>
<?php
			}else{
				?>
<div class="w3-button"><input type="radio" name="select_type_doc" value="4" onclick="javascript:object();"  id="object4">&nbsp;ใบสั่งขาย NBM</div>
					<?php
			}
						?>

</div>
<div class="w3-padding-small"></div>
<div class="w3-bar">
วันที่ <span class="w3-light-gray"><?php echo DateThai($objResult["register_date"]); ?></span>&nbsp;&nbsp;เลขที่อ้างอิง:&nbsp;<span class="w3-light-gray"><?php echo $objResult['ref_id']; ?></span> <input type="hidden" name="ref_id" class="w3-input25" value="<?php echo $objResult['ref_id']; ?>"> 
	<input type="hidden" name="main_id" value="<?php echo $objResult['main_id']; ?>">
	<input type="hidden" name="ref_id" id="ref_id" value="<?php echo $objResult['ref_id']; ?>">
<input type="hidden" name="register_date" value="<?php echo $objResult['register_date']; ?>">
<input type="hidden" name="register_time" value="<?php echo $objResult['register_time']; ?>">
<input type="hidden" name='start_date'  class='w3-input' value="<?php echo $_GET["start_date"];?>" readonly/>
<input type="hidden" name='end_date'  class='w3-input' value="<?php echo $_GET["end_date"];?>" readonly/>

</div>
<div class="w3-padding-small"></div>

<div class="w3-padding-small"></div>
<div class="w3-bar">
การจัดส่ง
		<input name="delivery" type='text' class="w3-input" id="delivery" value="<?php echo $objResult["delivery_name"]; ?><?php echo $objResult["time_delivery"]; ?>" readonly> 


</div>
<div class="w3-padding-small"></div>
<div class="w3-bar">
การชำระเงิน

<?php
if($objResult["select_type_doc"]=='3' or $objResult["select_type_doc"]=='1'){ 
$erer = '4';	 
}else{
$erer = '3';	
}
?>
	

<!--input name="payment" type='text' class="w3-input" id="payment"  value="<?php echo $objResult["payment_name"]; ?><?php echo $objResult["bank_name"]; ?><?php echo $objResult["book_name"]; ?>" placeholder="Search การชำระเงิน..."/>> 
<input name="h_payment" type="text" id="h_payment" value="<?php echo $objResult["payment"]; ?>" class="w3-input"  -->

<select name="h_payment"  id="h_payment" class="w3-select" >
<option value="">**Please Select Item**</option>
<?php
$strSQL5 = "select * from tb_bank  where close_ckk='0' and company !='".$erer."' order by number ASC";
$objQuery5 = mysqli_query($code,$strSQL5);
while ($objResuut5 = mysqli_fetch_array($objQuery5,MYSQLI_ASSOC)) {
if($objResult["payment"] == $objResuut5["id"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>
	
<option class="w3-bar-item w3-button"  value="<?php echo $objResuut5['id']; ?>"  <?php echo $sel;?>><?php echo $objResuut5['pay_in']; ?>  <?php echo $objResuut5['bank_name']; ?>    <?php echo $objResuut5['branch_bank']; ?> <?php echo $objResuut5['book_name']; ?> </option>
<?php } ?>
</select>


</div>
<div class="w3-padding-small"></div>
<div class="w3-bar">
หมายเหต
<textarea name="sale_remark"  class="w3-input" id="sale_remark"  rows="1" readonly><?php echo $objResult['sale_remark']; ?></textarea>
</div>
<div class="w3-padding-small"></div>
<div class="w3-bar">
ชื่อพนักงาน


<input name="employee_name" type='text' class="w3-input" value ="<?php echo $objResult['employee_name']; ?>" id="employee_name" readonly> 

</p>	
	<?php if($objResult['buy_ckk']=='1'){ ?>
			<input type="checkbox" name="buy_ckk" checked='checked' value="1"> &nbsp;ลูกค้าซื้อซ้ำ

	<?php }else{ ?>
		<input type="checkbox" name="buy_ckk" value="1"> &nbsp;ลูกค้าซื้อซ้ำ
	<?php } ?>
	</p>
	<?php if($objResult['que_ckk'] =='1'){ ?>
	<input type="checkbox" name="que_ckk" checked='checked' value="1"> &nbsp; <font color='red'>งานด่วน</font> &nbsp;&nbsp;
<?php }else{
?>
	<input type="checkbox" name="que_ckk" value="1"> &nbsp; <font color='red'>งานด่วน</font> &nbsp;&nbsp;
	<?php } ?>

</div>
	
<b>หมายเหตุแจ้งแผนกที่เกี่ยวข้อง</b>	
<br><br>	
จัดส่ง :
<textarea name="comment_cs"  class="w3-input" style="width:90%" id="comment_cs"  rows="2"><?php echo $rs26["comment_cs"]; ?></textarea>	
	
ช่าง :
<textarea name="comment_en"  class="w3-input" style="width:90%" id="comment_en"  rows="2"><?php echo $rs26["comment_en"]; ?></textarea>	
	
คลังสินค้า :
<textarea name="comment_st"  class="w3-input" style="width:90%" id="comment_st"  rows="2"><?php echo $rs26["comment_st"]; ?></textarea>	
	
Admin :
<textarea name="comment_ad"  class="w3-input" style="width:90%" id="comment_ad"  rows="2"><?php echo $rs26["comment_ad"]; ?></textarea>	
	<br>		
</div>

<div class="w3-twothird w3-container">
<div class="w3-bar w3-light-grey w3-border">
  <a class="w3-button" onclick="openCity('so')"><font color="404040"><b>ใบสั่งขาย</b></font></a>
  <a class="w3-button" onclick="openCity('mo')"><font color="404040"><b>เพิ่มเติม</b></font></a>
</div>

<div id="so" class="city" >
<div class="w3-padding-small"></div>
<div class="w3-half w3-container">
ชื่อที่ออกบิล
<input name="billing_name" type='text' value="<?php echo $objResult['billing_name']; ?>" class="w3-input" readonly>
ทีอยู่ที่ออกบิล
<textarea name="billing_address" class="w3-input" rows="1" readonly><?php echo $objResult['billing_address']; ?></textarea>
<div class="w3-half">
Tel.
<input type="text" name="billing_tel" value="<?php echo $objResult['billing_tel']; ?>" class="w3-input" readonly>
</div>
<div class="w3-bar w3-half w3-container">
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
<div class="w3-bar">
</div>

การโอนเงิน
<input type="text" name="transfer" value="<?php echo $objResult['transfer']; ?>" class="w3-input" readonly>

<div class="w3-bar">
ส่งบัญชีตรวจสอบ

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
วันที่โอน
<input type="date" name="transfer_date" id="transfer_date"  value="<?php echo $objResult['transfer_date']; ?>" class="w3-input" readonly>
</div>
<div class="w3-bar">
จำนวนเงินโอน/เก็บปลายทาง
<input type="text" name="amount" value="<?php echo $objResult['amount']; ?>" class="w3-input" readonly>
</div>
</div>

<div class="w3-half w3-container w3-border">
<font color="#FF0000"><b>ใช้สำหรับจ่าหน้าพัสดุเท่านั้น</b></font><br />
ชื่อผู้รับสินค้า
<input name="customer_name" type="text" value="<?php echo $objResult['customer_name']; ?>" class="w3-input" readonly>
ที่อยู่ในการจัดส่ง
<input name="address1" class="w3-input" value="<?php echo $objResult['address1']; ?>" type="text" readonly>
<input name="address2" class="w3-input" value="<?php echo $objResult['address2']; ?>" type="text" readonly>
จังหวัด

<input name="province" class="w3-input" value="<?php echo $objResult['province']; ?>" type="text" readonly>


รหัสไปรษณีย์
<input name="postcode" type="text" value="<?php echo $objResult["postcode"]; ?>" class="w3-input" readonly>
โทรศัพท์
<input name="tel" type="text" value="<?php echo $objResult["tel"]; ?>" class="w3-input" readonly>
<div class="w3-margin-bottom"></div>
</div>
</div>





<div id="mo" class="city" style="display:none">
<div class="w3-padding-small"></div>
<div class="w3-container w3-third">
ชื่อผู้แนะนำ
<input name="prefer_name" value="<?php echo $objResult["prefer_name"]; ?>" class="w3-input" readonly>
ใบสั่งซื้อเลขที่
<input name="po_no" class="w3-input" value="<?php echo $objResult["po_no"]; ?>" readonly>
กำหนดส่งตามสัญญา
<input name="delivery_contract" value="<?php echo $objResult["delivery_contract"]; ?>" class="w3-input" readonly>

<?php
if($objResult["clear_book_ckk"]=='1'){
?>
<input type="checkbox" name="clear_book_ckk" checked="checked" value="1">&nbsp;

<?php
}else{
	?>
<input type="checkbox" name="clear_book_ckk" value="1">&nbsp;


<?php
}
?>



เคลียร์ใบจอง
<input name="clear_book_no" class="w3-input" value="<?php echo $objResult["clear_book_no"]; ?>" readonly>


<?php
if($objResult["clear_brn_no_ckk"]=='1'){
?>

<input type="checkbox" name="clear_brn_no_ckk" checked='checked' value="1">&nbsp;

<?php
}else{
?>
	<input type="checkbox" name="clear_brn_no_ckk" value="1">&nbsp;
<?php
}
?>


เคลียร์ใบยืม BRN
<input name="clear_brn_no" class="w3-input" value="<?php echo $objResult["clear_brn_no"]; ?>" readonly>

<?php
if($objResult["clear_brnp_no_ckk"]=='1'){
?>
<input type="checkbox" name="clear_brnp_no_ckk" checked='checked' value="1">&nbsp;

<?php
}else{
	?>

<input type="checkbox" name="clear_brnp_no_ckk" value="1">&nbsp;

		<?php
}
		?>


เคลียร์ใบยืม BRNP
<input name="clear_brnp_no" class="w3-input" value="<?php echo $objResult["clear_brnp_no"]; ?>" readonly>
</div>
<div class="w3-container w3-third">

<?php
if($objResult["sn_ckk"]=='1'){
?>
<input type="checkbox" name="sn_ckk" checked="checked" value="1">&nbsp;
<?php
}else{
	?>
<input type="checkbox" name="sn_ckk" value="1">&nbsp;

		<?php
}
		?>



ต้องการ SN
<input name="sn" value="<?php echo $objResult["sn"]; ?>" class="w3-input" readonly>

<?php
if($objResult["bq_ckk"]=='1'){
?>
<input type="checkbox" name="bq_ckk" checked="checked" value="1">&nbsp;
<?php
}else{
	?>
<input type="checkbox" name="bq_ckk" value="1">&nbsp;

		<?php
}
		?>


BQ เลขที่
<input name="bq"  value="<?php echo $objResult["bq"]; ?>" class="w3-input" readonly>


<?php
if($objResult["ot_ckk"]=='1'){
?>
<input type="checkbox" name="ot_ckk" checked="checked" value="1">&nbsp;
<?php
}else{
	?>
<input type="checkbox" name="ot_ckk" value="1">&nbsp;

		<?php
}
		?>


OT เลขที่
<input name="ot" value="<?php echo $objResult["ot"]; ?>" class="w3-input" readonly>
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
 แนบใบเสนอราคา
เลขที่
<input name="pr_no" value="<?php echo $objResult["pr_no"]; ?>" class="w3-input" readonly>

<br />

<?php 
if($objResult["type_type"]=='1'){
?>

<input type="radio" name="type_type" checked="checked" value="1" onclick="javascript:ckk_1();" id="object6"> พิมพ์ตามคอม
<br />
<input type="radio" name="type_type" value="2" onclick="javascript:ckk_1();" id="object7"> พิมพ์ตามใบสั่งซื้อ
<br />
<input type="radio" name="type_type" value="3" onclick="javascript:ckk_1();" id="object5"> พิมพ์ตามที่เขียน
<br />

<?php
}else if($objResult["type_type"]=='2'){
	?>
<input type="radio" name="type_type"  value="1" onclick="javascript:ckk_1();" id="object6"> พิมพ์ตามคอม
<br />
<input type="radio" name="type_type" checked="checked" value="2" onclick="javascript:ckk_1();" id="object7"> พิมพ์ตามใบสั่งซื้อ
<br />
<input type="radio" name="type_type" value="3" onclick="javascript:ckk_1();" id="object5"> พิมพ์ตามที่เขียน
<br />

		<?php
}else if($objResult["type_type"]=='3'){

			?>
<input type="radio" name="type_type"  value="1" onclick="javascript:ckk_1();" id="object6"> พิมพ์ตามคอม
<br />
<input type="radio" name="type_type" value="2" onclick="javascript:ckk_1();" id="object7"> พิมพ์ตามใบสั่งซื้อ
<br />
<input type="radio" name="type_type" checked="checked" value="3" onclick="javascript:ckk_1();" id="object5"> พิมพ์ตามที่เขียน
<br />

	<?php
}else {

			?>
<input type="radio" name="type_type"  value="1" onclick="javascript:ckk_1();" id="object6"> พิมพ์ตามคอม
<br />
<input type="radio" name="type_type" value="2" onclick="javascript:ckk_1();" id="object7"> พิมพ์ตามใบสั่งซื้อ
<br />
<input type="radio" name="type_type"  value="3" onclick="javascript:ckk_1();" id="object5"> พิมพ์ตามที่เขียน
<br />
<?php 
		}
if($objResult["type_type"]=='3'){
?>
ระบุ
<textarea name="type_type_detail" class="w3-input" style="resize: none;width:100%" readonly><?php echo $objResult["type_type_detail"];?></textarea>
<?php
}else{
	?>

<div id="dt5" style="display:none">
ระบุ
<textarea name="type_type_detail" class="w3-input" style="resize: none;width:100%" readonly></textarea>
</div> <?php }	?>
</div>
<div class="w3-container w3-third">
สถานที่ติดตั้งเครื่อง
<input name="install_place" value="<?php echo $objResult["install_place"]; ?>" class="w3-input" readonly><br />




แนบไฟล์<br>

<input type='hidden' name='upload1' id='upload1' value ="<?php echo $objResult['upload1']; ?>"  />
<input type='hidden' name='upload2' id='upload2' value ="<?php echo $objResult['upload2']; ?>"  />
<input type='hidden' name='upload3' id='upload3' value ="<?php echo $objResult['upload3']; ?>"  />
<input type='hidden' name='upload4' id='upload4' value ="<?php echo $objResult['upload4']; ?>"  />
<input type='hidden' name='upload5' id='upload5' value ="<?php echo $objResult['upload5']; ?>"  />

<input name="upload1"  type="file">
<?php if($objResult['upload1']!=''){ ?><a href="upload/<?php echo $objResult['upload1']; ?>" target="_blank">คลิ๊กเพื่อดูรูป</a><?php } ?></p>
<input name="upload2"  type="file">
<?php if($objResult['upload2']!=''){ ?><a href="upload/<?php echo $objResult['upload2']; ?>" target="_blank">คลิ๊กเพื่อดูรูป</a><?php } ?></p>	
<input name="upload3"  type="file">
<?php if($objResult['upload3']!=''){ ?><a href="upload/<?php echo $objResult['upload3']; ?>" target="_blank">คลิ๊กเพื่อดูรูป</a><?php } ?></p>	
<input name="upload4"  type="file">
<?php if($objResult['upload4']!=''){ ?><a href="upload/<?php echo $objResult['upload4']; ?>" target="_blank">คลิ๊กเพื่อดูรูป</a><?php } ?></p>	
<input name="upload5"  type="file">
<?php if($objResult['upload5']!=''){ ?><a href="upload/<?php echo $objResult['upload5']; ?>" target="_blank">คลิ๊กเพื่อดูรูป</a><?php } ?></p>	



</div>


</div><!--third third -->
</div><!-- close more -->
</div><!-- close second half -->
<div class="w3-bar w3-light-grey w3-border">
  <a class="w3-bar-item w3-button" onclick="openCity1('pd')"><font color="#404040"><b>รายการสินค้า</b></font></a>
  <a class="w3-bar-item w3-button" onclick="openCity1('cs')"><font color="#404040"><b>รายละเอียดการจัดส่ง</b></font></a>
</div>


<div id="pd" class="w3-container city1">

<?php 

$strSQL1 = "SELECT * FROM (so__submain LEFT JOIN tb_product ON so__submain.product_ID=tb_product.product_id) WHERE ref_idd = '".$_GET["ref_id"]."' ";
///echo $strSQL;
//exit();

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
	<td align="center"><b>เคลียร์ยืม</b></td>
	<td align="center"><b>เคลียร์จอง</b></td>
</tr>
<?php
$i = 1;


while($objResult1 = mysqli_fetch_array($objQuery1))
{
?>

<tr>

<td >
<input type='hidden' name = "id[<?php echo $objResult1["id"];?>]" value="<?php echo $objResult1["id"];?>" id = "id[<?php echo $objResult1["id"];?>]"    size='16' readonly/>
<input type='hidden' name = "product_id[<?php echo $objResult1["id"];?>]" value="<?php echo $objResult1["product_id"];?>" id = "product_id[<?php echo $objResult1["id"];?>]"    size='16' readonly/>
 <input type='text' name = "product_code[<?php echo $objResult1["id"];?>]" value="<?php echo $objResult1["sol_code"];?>" id = "product_code[<?php echo $objResult1["id"];?>]"  class="w3-input"    size='16' readonly/>  


</td>

<td> <input type='text' name = "product_name[<?php echo $objResult1["id"];?>]"  value="<?php echo $objResult1["sol_name"];?>" id = "product_name[<?php echo $objResult1["id"];?>]"  class="w3-input" readonly></td>

<td><input type='text' name = "unit_name[<?php echo $objResult1["id"];?>]" value="<?php echo $objResult1["unit_name"];?>" id = "unit_name[<?php echo $objResult1["id"];?>]"  class="w3-input"    size='9' readonly/></td>

<td><input type='text' name = "sale_count[<?php echo $objResult1["id"];?>]" value="<?php echo $objResult1["sale_count"];?>" id = "sale_count[<?php echo $objResult1["id"];?>]"  class="w3-input" style="color:black;text-align:center"   size='7' /></td>

<td><input type='text' name = "product_price[<?php echo $objResult1["id"];?>]" value="<?php $price_per_unit= $objResult1["price_per_unit"]; echo number_format( $price_per_unit,2)."";?>" id = "product_price[<?php echo $objResult1["id"];?>]"  class="w3-input"  style="color:black;text-align:right"   /></td>

<td><input type='text' name = "discount_unit[<?php echo $objResult1["id"];?>]" value="<?php $discount_unit= $objResult1["discount_unit"]; echo number_format( $discount_unit,2)."";?>" id = "discount_unit[<?php echo $objResult1["id"];?>]"  class="w3-input"  style="color:black;text-align:right"   /></td>


<td><input type='text' name = "sum_amount[<?php echo $objResult1["id"];?>]" value="<?php  $sum_amount=$objResult1["sum_amount"]; echo number_format( $sum_amount,2)."";?>" id = "sum_amount[<?php echo $objResult1["id"];?>]"  class="w3-input" style="color:black;text-align:right"    readonly/></td>


<td><input type='text' name = "warranty[<?php echo $objResult1["id"];?>]" value="<?php echo $objResult1["warranty"];?>" id = "warranty[<?php echo $objResult1["id"];?>]"  class="w3-input"  OnKeyPress="return chkNumber(this)" /></td>

<td><input type='text' name = "cal[<?php echo $objResult1["id"];?>]" value="<?php echo $objResult1["cal"];?>" id = "cal[<?php echo $objResult1["id"];?>]"  class="w3-input"   OnKeyPress="return chkNumber(this)"/></td>

<td><input type='text' name = "pm[<?php echo $objResult1["id"];?>]" value="<?php echo $objResult1["pm"];?>" id = "pm[<?php echo $objResult1["id"];?>]"  class="w3-input"   OnKeyPress="return chkNumber(this)"/></td>



<td>
	<textarea name = "sale_remarkk[<?php echo $objResult1["id"];?>]"  id = "sale_remarkk[<?php echo $objResult1["id"];?>]"  class="w3-input"    size='13' ><?php echo $objResult1["sale_remark"];?></textarea>
	</td>
	
<td>
	<textarea name = "sn[<?php echo $objResult1["id"];?>]"  id = "sn[<?php echo $objResult1["id"];?>]"  class="w3-input" size='13' ><?php echo $objResult1["sn_number"];?></textarea></td>	

<td style="width:8%;">
	<?php if($objResult1["clear_br"]=='1'){ ?>
	<input type='checkbox' name = "clear_br[<?php echo $objResult1["id"];?>]" checked='checked' value="1" id = "clear_br[<?php echo $objResult1["id"];?>]" >
	<?php }else{ ?>
	<input type='checkbox' name = "clear_br[<?php echo $objResult1["id"];?>]" value="1" id = "clear_br[<?php echo $objResult1["id"];?>]" >
	<?php } ?>
	<input type='text' name = "clear_ivno[<?php echo $objResult1["id"];?>]" value="<?php echo $objResult1["clear_ivno"];?>" id = "clear_ivno[<?php echo $objResult1["id"];?>]" placeholder="เลขที่ใบยืม"  class="w3-input"  />
	</td>

<td style="width:8%;">
	<?php if($objResult1["jong_ckk"]=='1'){ ?>
	<input type='checkbox' name = "jong_ckk[<?php echo $objResult1["id"];?>]" checked='checked' value="1" id = "jong_ckk[<?php echo $objResult1["id"];?>]" >
	<?php }else{ ?>
	<input type='checkbox' name = "jong_ckk[<?php echo $objResult1["id"];?>]" value="1" id = "jong_ckk[<?php echo $objResult1["id"];?>]" >
	<?php } ?>
	<input type='text' name = "jong_no[<?php echo $objResult1["id"];?>]" value="<?php echo $objResult1["jong_no"];?>" id = "jong_no[<?php echo $objResult1["id"];?>]" placeholder="เลขที่ใบจอง"  class="w3-input"  />
	</td>
</tr>

<?
	$i++;

}

?>

</table>


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

สถานที่ส่งสินค้า:
<textarea name="delivery_place" class="w3-input" cols="20" rows="1" style="width:100%;resize: none" ><?php echo $objResult["delivery_place"] ; ?></textarea>
ชื่อผู้ติดต่อ/TEL.:
<input type="text" name="delivery_contact" value ="<?php echo $objResult["delivery_contact"]; ?>" class="w3-input" >
</div><!-- second third-->
<div class="w3-quarter"><!-- 3rd quarter-->
<?php
if ($objResult["return_date"]=='1'){
?>
<input type="checkbox" name="return" checked="checked" value="1">รับคืนสินค้า<br>
<?php
}else{
	?>
<input type="checkbox" name="return" value="1">รับคืนสินค้า<br>
<?php
}
	?>
วันที่รับคืน
<input type="date" name="return_date"  value ="<?php echo $objResult["return_date"] ; ?>" class="w3-input" >
เวลา
<input type="text" name="return_time" value ="<?php echo $objResult["return_time"] ; ?>" class="w3-input" >
ที่อยู่รับคืนสินค้า:
<input type="text" name="return_address" value ="<?php echo $objResult["return_address"] ; ?>" class="w3-input" >
ชื่อผู้ติดต่อ/TEL.:
<input type="text" name="return_contact" value ="<?php echo $objResult["return_contact"] ; ?>" class="w3-input" >
</div><!-- 3rd quarter-->
<div class="w3-quarter w3-container">



</div></div><!-- forth quarter -->

<?php } ?>

<?php 

				$sql1 = "select * from tb_register_data where ref_id = '".$_GET["ref_id"]."'";
				$query1 = mysqli_query($conn,$sql1);
				$fetch1 = mysqli_fetch_array($query1,MYSQLI_ASSOC); 



if ($objResult["delivery_type"]=='4'){
?>


<div class="w3-quarter"><!-- first third-->
<input type="checkbox" name="" hidden><br \>
วันที่ส่ง
<input type="date" name="delivery_date" value="<?php echo $objResult["delivery_date"];?>" class="w3-input" >
เวลาส่ง
<input type="text" name="delivery_time" value="<?php echo $objResult["delivery_time"];?>" class="w3-input" >


</div><!-- first third-->
<div class="w3-quarter w3-container"><!-- second third-->

สถานที่ส่งสินค้า:
<textarea name="delivery_place" class="w3-input" cols="20" rows="2" style="width:100%;resize: none" ><?php echo $objResult["delivery_place"] ; ?></textarea>
ชื่อผู้ติดต่อ/TEL.:
<input type="text" name="delivery_contact" value ="<?php echo $objResult["delivery_contact"]; ?>" class="w3-input" >
</div><!-- second third-->
<div class="w3-quarter"><!-- 3rd quarter-->
<?php
if ($objResult["return_date"]=='1'){
?>
<input type="checkbox" name="return" checked="checked" value="1">รับคืนสินค้า<br>
<?php
}else{
	?>
<input type="checkbox" name="return" value="1">รับคืนสินค้า<br>
<?php
}
	?>
วันที่รับคืน
<input type="date" name="return_date"  value ="<?php echo $objResult["return_date"] ; ?>" class="w3-input" >
เวลา
<input type="text" name="return_time" value ="<?php echo $objResult["return_time"] ; ?>" class="w3-input" >
ที่อยู่รับคืนสินค้า:
<input type="text" name="return_address" value ="<?php echo $objResult["return_address"] ; ?>" class="w3-input" >
ชื่อผู้ติดต่อ/TEL.:
<input type="text" name="return_contact" value ="<?php echo $objResult["return_contact"] ; ?>" class="w3-input" >
</div><!-- 3rd quarter-->

<div class="w3-container w3-third">
	<?php if ($fetch1["send_cs"]=='1'){ ?>
<input type="checkbox" name="send_cs" checked="checked" value="1">&nbsp;ส่งข้อมูลไประบบลงงาน 
	<?php }else{ ?>
	<input type="checkbox" name="send_cs" value="1">&nbsp;ส่งข้อมูลไประบบลงงาน 
	<?php } ?>
	
	</div>
<div class="w3-container w3-third">
	<?php if ($fetch1["mk_research"]=='1'){ ?>
<input type="checkbox" name="mk_research" checked='checked' value="1">&nbsp; cs ทำแบบสอบถาม 
	<?php }else{ ?>
<input type="checkbox" name="mk_research"  value="1">&nbsp; cs ทำแบบสอบถาม 	
	<?php } ?>
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

	   <input name="company_name" type='text' class="w3-input"  id="company_name" value="<?php echo $fetch1["type_company"]; ?>" size="20"  />
<?php /*
<select name="company_name" id="company_name" class="w3-input"   >
<option  value="">**โปรดเลือกหน่วยงาน**</option>
<option  value="ฟาร์ ทริลเลี่ยน บจก.">ฟาร์ ทริลเลี่ยน บจก.</option>
<option  value="โนเบิล เมด บจก.">โนเบิล เมด บจก.</option>
<option  value="อื่นๆ">อื่นๆ</option>
</select>*/ ?>


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
 if ($fetch1["check_detail"]=='1'){
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


</div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>		
 
</form>
</body>
</html>






