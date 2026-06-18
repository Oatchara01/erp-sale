<?php include('head.php'); ?>
<?php include('dbconnect_sale.php'); ?>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

<link rel="stylesheet" href="css/autocomplete.css"  type="text/css"/>
<script type="text/javascript" src="js/autocomplete.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>

<style type="text/css">
<!--
.style15 {
	font-size: 18px; color: #000000;
}
.style30 {font-size: 12; }
.style32 {font-size: 11px}
.style33 {font-size: 12px; }
.style34 {color: #FF0000}
.style35 {font-size: 14px; color: #f2f2f2; }
.style37 {color: #FF0000; font-size: 14px; }
.style38 {color: #f2f2f2}
.style39 {font-size: 14px; color: #000000;}
.style40 {font-size: 14px; color: #FF0000; }
-->

.button {
    background-color: #339900;
    border: none;
    color: white;
    padding: 14px 16px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
}

.button1 {border-radius: 2px;}
.button2 {border-radius: 4px;}
.button3 {border-radius: 8px;}
.button4 {border-radius: 12px;}
.button5 {border-radius: 50%;}
</style>
<?php
			include('dbconnect.php');

$qfirst = "select * from hos__smp where ref_idsmp = '".$_GET["ref_idsmp"]."'";
$first = mysqli_query($conn,$qfirst);
$ffirst = mysqli_fetch_array($first);

$strSQL1 = "SELECT * FROM  (hos__subsmp LEFT JOIN tb_product ON hos__subsmp.product_ID=tb_product.product_id) WHERE reff_idsmp = '".$_GET["ref_idsmp"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);



		
date_default_timezone_set("Asia/Bangkok");

$month = date('m');
$day = date('d');
$year = date('Y');

$today = $year . '-' . $month . '-' . $day;



		?>
	
<style>
	.none {
    display:none;
	}
</style>
<form action="register_chang426_edit1.php" method="post" name="frmMain" enctype="multipart/form-data"  onSubmit="JavaScript:return fncSubmit();" >
	
<script language="javascript">
function fncSubmit()   //ห้ามชื่อสินค้า ยี่ห้อสินค้า รุ่นสินค้าเป็
{
	if(document.frmMain.order_no.value == ""){
		if(document.frmMain.ref_idnew.value == ""){
		alert('กรุณาใส่หมายเลขคำสั่งซื้อใหม่หรือเลขที่อ้างอิงใบสั่งขายใหม่อย่างใดอย่างหนึ่งค่ะ');
		document.frmMain.customer_tel.focus();
		return false;
		}
		}
		
	document.frmMain.submit();
}
</script>
	
<div class="w3-white w3-container">
	<div class="w3-panel w3-light-grey"><h3>ใบเบิกสินค้าเพื่อสนับสนุนการขาย</h3></p>	
	<h5>(Sample Request)</h5>

<a href="report_sample.php?ref_idsmp=<?php echo $_GET["ref_idsmp"];?>" target="_blank" class="w3-button w3-yellow w3-right"><font color="black">Print Preview</font></a>&nbsp;&nbsp;
<?php if($ffirst['status_sup']=='Request'){?>
<a href="sample_sendstockglu.php?ref_idsmp=<?php echo $_GET["ref_idsmp"]; ?>&type_company=<?php echo $ffirst['type_company']; ?>" target="_blank" class="w3-button w3-green w3-right"><font color="black">ส่งใบเบิกให้ Stock</font></a>

<?php } ?>

	</div>
		
<div class="w3-bar">

		
		
		<span class="w3-light-grey w3-right"> เลขที่อ้างอิง : <?php echo $ffirst['ref_idsmp']; ?></span>
		<input type="hidden" name="ref_idsmp" class="w3-input" value="<?php echo $ffirst['ref_idsmp']; ?>">
	</div>

	<div class="w3-bar w3-padding-small"></div><!-- bar -->
		<div class="w3-half 1">
<div class="w3-bar w3-margin-bottom">
				<?php if ($ffirst['type_company']=='1'){ ?>
			<input type="radio" name="type_company"  checked ='checked' value="1">&nbsp;AWL
<input type="radio" name="type_company"  value="2" >&nbsp;NBM
				<?php }else{ ?>
			<input type="radio" name="type_company"  value="1">&nbsp;AWL
<input type="radio" name="type_company" checked ='checked'  value="2" >&nbsp;NBM	
				<?php } ?>
				</div>	
			
		<div class="w3-bar w3-margin-bottom">
			วันที่คลัง  :<input type="date" name="smp_date" value = "<?php echo $ffirst['smp_date']; ?>" style="width:30%;" class="w3-input"  required>
</div>
			<div class="w3-bar w3-margin-bottom">
ที่อยุ่ :<textarea name="address_name" id="address_name" class="w3-input" style="width:90%;"  required><?php echo $ffirst['address_name']; ?></textarea>
</div>



<div class="w3-bar w3-margin-bottom">


เขตการขาย :


				<select name="sale_code" id="sale_code" style="width:330px" class="w3-input" >
<option value="">**Please Select**</option>


<?php

$strSQL5 = "SELECT * FROM tb_team_adm ORDER BY sale_code ASC";
//echo $strSQL5;
//exit();
$objQuery5 = mysqli_query($com,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5))
{
if($ffirst["sale_code"] == $objResuut5["sale_code"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>
<option value="<?php echo $objResuut5["sale_code"];?>" <?php echo $sel;?>><?php echo $objResuut5["sale_code"];?> - <?php echo $objResuut5["sale_name"];?></option>
<?php
}
?>
</select>



</div>
			
<div class="w3-bar w3-margin-bottom">		
	
<input type='hidden' name='img_upsn_1' id='up_img1_1' value ="<?php echo $ffirst['img_upsn']; ?>"  />

	
แนบไฟล์รูป SN สินค้า<br>
<input name="img_upsn"   type="file"><a href="smp_up/<?php echo $ffirst['img_upsn']; ?>" target="_blank">ดูข้อมูลเพิ่มเติม</a>
</div>

			
</div>
<div class="w3-half 1">
<div class="w3-bar w3-margin-bottom">
ชื่อลูกค้า 
<input type="text" name="customer_name" id="customer_name" value = "<?php echo $ffirst['customer_name']; ?>" class="w3-input" style="width:90%;"  required>
</div>
<div class="w3-bar w3-margin-bottom">
<font color='red'>หมายเลขคำสั่งซื้อใหม่ </font>
<input type="text" name="order_no" id="order_no" value = "<?php echo $ffirst['order_no']; ?>" class="w3-input" style="width:90%;"  >
	<font color='red'>เลขที่อ้างอิงใบสั่งขายใหม่</font>
	<input type="text" name="ref_idnew" id="ref_idnew"  value = "<?php echo $ffirst['ref_idnew']; ?>" class="w3-input" style="width:90%;" >
</div>

<div class="w3-bar w3-margin-bottom">
			Comment Sale :&nbsp;
			<textarea name="comment_sale" id="comment_sale" class="w3-input" style="width:90%;"  required><?php echo $ffirst['comment_sale']; ?></textarea>
</div>
<div class="w3-bar w3-margin-bottom">
			Comment Sup :&nbsp;
			<textarea name="comment_sup" id="comment_sup" class="w3-input" style="width:90%;"  ><?php echo $ffirst['comment_sup']; ?></textarea>
</div>
<div class="w3-bar w3-margin-bottom">
	<?php if($ffirst['brnp_ckk']=='1'){ ?>
	<input type="checkbox" name="brnp_ckk" id="brnp_ckk" checked='checked' value ='1'>
	<?php }else{ ?>
	<input type="checkbox" name="brnp_ckk" id="brnp_ckk"  value ='1'>
	<?php } ?>
			เคลียร์ใบยืม เลขที่  
			<input type="text" name="brnp_no" id="brnp_no" value = "<?php echo $ffirst['brnp_no']; ?>" class="w3-input" style="width:90%;"  >
</div>	
	<div class="w3-bar w3-margin-bottom">
	<?php if($ffirst['crm_ckk']=='1'){ ?>
	<input type="checkbox" name="crm_ckk" id="crm_ckk" checked='checked' value ='1'>
		<?php }else{ ?>
		<input type="checkbox" name="crm_ckk" id="crm_ckk"  value ='1'>
		<?php } ?>	

			แลกสินค้าระบบ CRM เลขที่อ้างอิง  
			<input type="text" name="crm_ref" id="crm_ref" value="<?php echo $ffirst['crm_ref']; ?>" class="w3-input" style="width:90%;"  >
</div>			
</div>
		
		

	</p>
	<div class="w3-bar w3-light-grey w3-border">
  <a class="w3-bar-item w3-button" onclick="openCity1('pd')"><font color="#404040"><b>รายการสินค้า</b></font></a>
  <a class="w3-bar-item w3-button" onclick="openCity1('cs')"><font color="#404040"><b>รายละเอียดการจัดส่ง</b></font></a>
</div>


<div id="pd" class="w3-container city1">

<table width="100%" border="0" class="w3-table">

    <th>รหัสสินค้า</th>
    <th>ชื่อสินค้า</th>
    <th>หน่วย</th>
    <th>จำนวน</th>
    <th>ราคาต่อหน่วย</th>
    <th>ยอดรวม</th>
	<th>หมายเลขเครื่อง</th>
	<th>จำนวนรับประกัน</th>
	<th>หมายเหตุ</th>
	<th><font color ='red'>หมายเลขเครื่องเดิม</font></th>
	<th><font color ='red'>SN ยี่ห้ออื่น</font></th>
	<th>เคลียร์ยืม</th>
	<tbody>

<?php

$i = 1;
while($objResult1 = mysqli_fetch_array($objQuery1))
{
	
?>

<tr>
<td style="width:10%;">


<input type='text' name = "product_code[<?php echo $objResult1["subsmp_id"]; ?>]"  id = "product_code[<?php echo $objResult1["subsmp_id"]; ?>]" class="w3-input" value = "<?php echo $objResult1["access_code"]; ?>"  size="7" /> 
<input type='hidden' name = "product_id[<?php echo $objResult1["subsmp_id"]; ?>]" value = "<?php echo $objResult1["product_id"]; ?>" id = "product_id[<?php echo $objResult1["subsmp_id"]; ?>]" class="w3-input" />
<input type='hidden' name = "subsmp_id[<?php echo $objResult1["subsmp_id"]; ?>]" value = "<?php echo $objResult1["subsmp_id"]; ?>" id = "subsmp_id[<?php echo $objResult1["subsmp_id"]; ?>]" class="w3-input" />


</td>
<td  style="width:8%;">
<textarea  name = "product_name[<?php echo $objResult1["subsmp_id"]; ?>]"  id = "product_name[<?php echo $objResult1["subsmp_id"]; ?>]"   rows="2" class="w3-input" readonly><?php echo $objResult1["sol_name"]; ?></textarea>
	</td>
<td style="width:5%;">
<input type='text' name = "unit_name[<?php echo $objResult1["subsmp_id"]; ?>]"  id = "unit_name[<?php echo $objResult1["subsmp_id"]; ?>]" value = "<?php echo $objResult1["unit_name"]; ?>" class="w3-input" readonly/>
</td>
<td style="width:5%;">
<input type='text' name = "sale_count[<?php echo $objResult1["subsmp_id"]; ?>]" id = "sale_count[<?php echo $objResult1["subsmp_id"]; ?>]" value = "<?php echo $objResult1["sale_count"]; ?>" class="w3-input" style="color:black;text-align:center"  />
</td>
<td style="width:8%;">
<input type='text' name = "product_price[<?php echo $objResult1["subsmp_id"]; ?>]"  id = "product_price[<?php echo $objResult1["subsmp_id"]; ?>]" value="<?php  $price=$objResult1["unit_price"]; echo number_format( $price,2)."";?>" class="w3-input" size="7" style="color:black;text-align:right" readonly>
</td >



<td style="width:8%;"><input type='text' name = "sum_amount[<?php echo $objResult1["subsmp_id"]; ?>]"  id = "sum_amount[<?php echo $objResult1["subsmp_id"]; ?>]" value="<?php  $sum_amount=$objResult1["sum_amount"]; echo number_format( $sum_amount,2)."";?>"  class="w3-input" size="7" style="color:black;text-align:right" readonly/>
</td>
	
<td  style="width:10%;">
<textarea  name = "sn[<?php echo $objResult1["subsmp_id"]; ?>]"  id = "sn[<?php echo $objResult1["subsmp_id"]; ?>]"   rows="2" class="w3-input" ><?php echo $objResult1["sn"]; ?></textarea>
	</td>

<td style="width:5%;">
<input type='text' name = "waranty[<?php echo $objResult1["subsmp_id"]; ?>]" id = "waranty[<?php echo $objResult1["subsmp_id"]; ?>]" value = "<?php echo $objResult1["waranty"]; ?>" class="w3-input" style="color:black;text-align:center"  />
</td>
<td  style="width:8%;">
<textarea  name = "sale_remark[<?php echo $objResult1["subsmp_id"]; ?>]"  id = "sale_remark[<?php echo $objResult1["subsmp_id"]; ?>]"   rows="2" class="w3-input" ><?php echo $objResult1["sale_remark"]; ?></textarea></td>
<td  style="width:10%;">
<textarea  name = "sn_old[<?php echo $objResult1["subsmp_id"]; ?>]"  id = "sn_old[<?php echo $objResult1["subsmp_id"]; ?>]"   rows="2" class="w3-input" ><?php echo $objResult1["sn_old"]; ?></textarea>
	</td>
<td  style="width:10%;">
<textarea  name = "sn_out[<?php echo $objResult1["subsmp_id"]; ?>]"  id = "sn_out[<?php echo $objResult1["subsmp_id"]; ?>]"   rows="2" class="w3-input" ><?php echo $objResult1["sn_out"]; ?></textarea>
	</td>	
	<td style="width:8%;">
<?php if($objResult1["clear_br"]=='1'){ ?>
	<input type='checkbox' name = "clear_br[<?php echo $objResult1["subsmp_id"];?>]" checked='checked' value="1" id = "clear_br[<?php echo $objResult1["subsmp_id"];?>]" >
	<?php }else{ ?>
	<input type='checkbox' name = "clear_br[<?php echo $objResult1["subsmp_id"];?>]" value="1" id = "clear_br[<?php echo $objResult1["subsmp_id"];?>]" >
	<?php } ?>
<input type='text' name = "br_no[<?php echo $objResult1["subsmp_id"]; ?>]" value="<?php echo $objResult1["br_no"];?>" id = "br_no[<?php echo $objResult1["subsmp_id"]; ?>]" placeholder="เลขที่ใบยืม"  class="w3-input"  />
</td>


</tr>
<?php } ?>

</table>
</div>

<div id="cs" class="w3-container city1" style="display:none">

<?php if($ffirst["delivery_type"]=='1') { ?>
<input type="radio" name="delivery_type" value="1" checked='checked' >&nbsp;Sale รับเอง
<input type="radio" name="delivery_type" value="2"  >&nbsp;บริษัทจัดส่ง <br />


<?php }else if ($ffirst["delivery_type"]=='2') { ?>

<input type="radio" name="delivery_type" value="1"  >&nbsp;Sale รับเอง
<input type="radio" name="delivery_type" value="2" checked='checked' >&nbsp;บริษัทจัดส่ง 

<?php }else{ ?>
	<input type="radio" name="delivery_type" value="1"  >&nbsp;Sale รับเอง
<input type="radio" name="delivery_type" value="2" >&nbsp;บริษัทจัดส่ง 
	<?php } ?>


	<?php
		$sql1 = "select * from tb_register_data where ref_id = '".$ffirst["ref_idsmp"]."'";
				$query1 = mysqli_query($conn,$sql1);
				$fetch1 = mysqli_fetch_array($query1,MYSQLI_ASSOC); 
	?>

 วันที่ รับ-ส่ง :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input name="start_date" type='date' id="start_date" value="<?php echo $fetch1["start_date"]; ?>"  class="button4" style="width:20%" /></p>


วันที่ต้องการโดยประมาณ :
	  <input name="between_date"  class="button4" type='text'  value="<?php echo $fetch1["between_date"]; ?>" id="between_date" style="width:20%" />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 เวลา :&nbsp;&nbsp;&nbsp;&nbsp;
<input id="start_time"  name="start_time"  value="<?php echo $fetch1["start_time"]; ?>" class="button4" type="text" style="width:10%"/>
ถึง
<input id="end_time" name="end_time"  value="<?php echo $fetch1["end_time"]; ?>"  class="button4" type="text" style="width:10%"/></p>



สถานะการทำงาน : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<input type='radio'  name='status' id = 'status' value='ส่ง' checked='checked'/>ส่ง
&nbsp; <input type='radio'  name='status' id = 'status' value='รับ' />รับ

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
สถานะ :&nbsp;&nbsp;
      <input name="status_comment" type='text' id="status_comment" value="<?php echo $fetch1["status_comment"]; ?>"  style="width:22%" class="button4"/></p>

<?php if($fetch1["fix_date"]=='1'){ ?>

<input type="checkbox"  name="fix_datetime" checked='checked' id = "fix_datetime" value="1">นัดวันและเวลาเรียบร้อยแล้ว &nbsp;&nbsp;
<?php }else{ ?>

<input type="checkbox"  name="fix_datetime" id = "fix_datetime" value="1">นัดวันและเวลาเรียบร้อยแล้ว &nbsp;&nbsp;

	<?php } ?>
	
<?php 
	if($fetch1["on_time"]=='1'){
	?>

<input type="checkbox"  id = "on_time" checked='checked' name="on_time" value="1">งานสำคัญต้องตรงเวลา&nbsp;&nbsp;;

<?php }else{ ?>
<input type="checkbox"  id = "on_time" name="on_time" value="1">งานสำคัญต้องตรงเวลา&nbsp;&nbsp;

	<?php } ?>
<?php
	if($fetch1["call_customer"]=='1'){
		?>

<input type="checkbox" checked='checked' id = "call_customer" name="call_customer" value="1">โทรแจ้งลูกค้าก่อนไป
<?php }else{ ?>

<input type="checkbox"  id = "call_customer" name="call_customer" value="1">โทรแจ้งลูกค้าก่อนไป

	<?php } 
	if($fetch1["call_employee"]=='1'){
	?>
&nbsp;&nbsp;<input type="checkbox"  id = "call_back" checked='checked' name="call_back" value="1">ต้องการให้โทรกลับเมื่อส่งสินค้าเสร็จแล้ว
&nbsp;&nbsp;
<?php }else{ ?>
&nbsp;&nbsp;<input type="checkbox"  id = "call_back"  name="call_back" value="1">ต้องการให้โทรกลับเมื่อส่งสินค้าเสร็จแล้ว
&nbsp;&nbsp;

	<?php } 
	?>
<?php 
	if($fetch1["no_price"]=='1'){
	?>

<input type="checkbox"  id = "no_money" checked='checked' name="no_money" value="1">ไม่ต้องเก็บเงิน&nbsp;&nbsp;

<?php }else{ ?>
<input type="checkbox"  id = "no_money" name="no_money" value="1">ไม่ต้องเก็บเงิน&nbsp;&nbsp;

	<?php } ?>
<?php
		if($fetch1["want_bus"]=='1'){

	?>


<input type="checkbox" checked='checked'  name="want_bus" value="1">ต้องการรถใหญ่</p>
<?php }else{ ?>

<input type="checkbox"   name="want_bus" value="1">ต้องการรถใหญ่</p>

	<?php } 
		?>
	



แผนก - ฝ่าย :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="department_show" value="<?php echo $fetch1["department_show"]; ?>"  class="button4" type='text' id="department_show">

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
       ประเภทลูกค้า :

<select name="customer_typename" class="button4" >
<option value="">**Please Select Item**</option>
<?php
$strSQL4 = "SELECT * FROM tb_typecustomer ORDER BY type_name ASC";
$objQuery4 = mysqli_query($conn,$strSQL4);
while($objResuut4 = mysqli_fetch_array($objQuery4)){
if($fetch1["type_customer"] == $objResuut4["type_name"]) {
								$sel = "selected";
							}
							else {
								$sel = "";
							}	
	
?>
<option value="<?php echo $objResuut4["type_name"];?>"<?php echo $sel;?>><?php echo $objResuut4["type_name"];?></option>
<?php
}
?>
</select>

</p>



       หน่วยงาน :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	   	   <input name="company_name"  value="<?php echo $fetch1["type_company"]; ?>"  class="button4" type='text' id="company_name">


&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
       ประเภทงาน :&nbsp;&nbsp;
	   <input name="department_name" value="<?php echo $fetch1["department"]; ?>"  class="button4" type='text' id="department_name">

</p>



ชื่อพนักงาน :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="employee_name" value="<?php echo $fetch1["employee_name"]; ?>" class="button4" type='text' value="<?php echo $_SESSION['name']; ?>" id="employee_name" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 เบอร์โทรพนักงาน :&nbsp;
<input name="employee_tel" value="<?php echo $fetch1["employee_tel"]; ?>" class="button4" type='text' id="employee_tel" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 
<input name="add_by" value="<?php echo $fetch1["add_by"]; ?>" type='hidden' class="button4" >


</p>
สถาที่ส่งสินค้า :</p>
          
<textarea  class="button4" name="address_1"  style="width:50%" ><?php echo $fetch1["address_1"]; ?></textarea>
</p>
ที่อยู่ในการส่งสินค้า :</p>
<textarea   class="button4" name="address_name1" style="width:50%" ><?php echo $fetch1["address_name"]; ?></textarea>               
</p>

  สถานที่ติดตั้งเครื่อง :</p>
<textarea   class="button4" name="address_send"  style="width:50%" rows="2"><?php echo $fetch1["address_send"]; ?></textarea>
</p>

ชื่อผู้ติดต่อ  :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="customer_name1"  class="button4" type='text' value="<?php echo $fetch1["customer_name"]; ?>" id="customer_name1">




&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 เบอร์โทรลูกค้า :
<input name="customer_tel" value="<?php echo $fetch1["customer_tel"]; ?>"  class="button4" type='text' id="customer_tel" >
</p>
เลขที่เอกสาร/เลขที่เครื่อง :</p> 
<textarea name="product_sn"  class="button4" id="product_sn" style="width:50%" rows="2"><?php echo $fetch1["product_sn"]; ?></textarea>
</p>
สินค้า/เอกสาร :</p>
<textarea name="product"  class="button4" id="product" style="width:50%" rows="2"><?php echo $fetch1["product_name"]; ?></textarea>


</p>
รายละเอียดเพิ่มเติม :</p>
     <textarea name="description"  class="button4" id="description" style="width:50%" rows="2"><?php echo $fetch1["description"]; ?></textarea>




	
</div><!-- cs -->



<?php if($ffirst["send_stock"]=='0'){ ?>

	<div class="w3-bar w3-center">
			<input type="submit" name="submit" class="w3-button w3-teal be-border" value="บันทึกข้อมูล">
	</div>

<?php } ?><br>
	</div>
	</form>
</div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>		




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
</script>