<?php include('head.php'); ?>
<script type="text/javascript">
function ck_type_document1(){
var ck = document.getElementById('type_document1');
if(ck.checked == true){
document.getElementById('frm_type_document1').style.display = "";
}else{
document.getElementById('frm_type_document1').style.display = "none";
}
}

function ck_type_document2(){
var ck = document.getElementById('type_document2');
if(ck.checked == true){
document.getElementById('frm_type_document2').style.display = "";
}else{
document.getElementById('frm_type_document2').style.display = "none";
}
}

function ck_frm(){
var ck = document.getElementById('description_other');
if(ck.checked == true){
document.getElementById('frm_txt').style.display = "";
}else{
document.getElementById('frm_txt').style.display = "none";
}
}

function ck_delivery(){
var ck = document.getElementById('delivery');
if(ck.checked == true){
document.getElementById('frm_delivery').style.display = "";
}else{
document.getElementById('frm_delivery').style.display = "none";
}
}

function ck_start_date(){
var ck = document.getElementById('start_date');
if(ck.checked == true){
document.getElementById('frm_start_date').style.display = "";
}else{
document.getElementById('frm_start_date').style.display = "none";
}
}

function ck_between_date(){
var ck = document.getElementById('between_date');
if(ck.checked == true){
document.getElementById('frm_between_date').style.display = "";
}else{
document.getElementById('frm_between_date').style.display = "none";
}
}
</script>
<body>
<?php
$sql1 = "select * from hot__main order by main_id desc limit 1";
$query1 = mysqli_query($conn,$sql1);
$fetch1 = mysqli_fetch_array($query1,MYSQLI_ASSOC); ?>

<!--action="register_office1.php"-->
<form action='register_sale_hot1.php' method="POST" name="frmMain" >
<div class="w3-container w3-padding-large"><!-- main div -->
<div class="w3-panel w3-light-gray"><h4>Register Data</h4></div>

<div class="w3-third">
 <div class="w3-bar">
  <div class="w3-third">
   <input type="checkbox" name="type_company" value="1">  <img src="img/logo.png" width="70" height="30" border="0" />
  </div>
  <div class="w3-third">
   <input type="checkbox" name="type_company" value="2">  <img src="img/nbm_select.png" width="60" height="30" border="0" />
  </div>
 </div>
</div>

<div class="w3-bar"></div>

<div class="w3-third">
 <div class="w3-bar">
  <div class="w3-third">
   <input type="checkbox" name="type_document1" id="type_document1" onClick="ck_type_document1();" value="1"  > ใบสั่งขาย
  </div>
  <div class="w3-third">
   <input type="checkbox" name="type_document2" value="2"> ใบสั่งพิมพ์ใบเบิกจ่ายสินค้า
  </div>
 </div>
</div>

<div class="w3-bar"></div>

<div id="frm_type_document1" style="display:none;" class="w3-margin-top">

 <div class="w3-bar w3-margin-bottom">
    วันที่ : <span class="w3-light-grey"><?php echo DateThai(date("d-m-Y")); ?></span> | เลขที่อ้างอิง : <span name="ref_id" class=""><?php echo $fetch1['ref_id']+1; ?></span><input type="hidden" name="main_id" value="<?php echo $fetch1['main_id']+1; ?>"><input type="hidden" name="ref_id" value="<?php echo $fetch1['ref_id']+1; ?>">
 </div>
 <div class="w3-bar w3-margin-bottom w3-quarter">
    ช่องทางการขาย :
  <select name="sale_channel" style="width:90%" class="w3-select">
    <option class="w3-bar-block" value="">**Please Select Item**</option>
    <option class="w3-bar-block" value="Sale">Sale</option>
    <option class="w3-bar-block" value="ผู้แนะนำ">ผู้แนะนำ</option>
  </select>
</div>
<div class="w3-bar w3-margin-bottom w3-quarter">
  เลขที่ IV : <input name="doc_no" type='text' id="doc_no"  style="width:90%"  class="w3-input"/>
</div>

<div class="w3-bar w3-margin-bottom w3-quarter">
 ชื่อที่ต้องการออกบิล :
  <select name="billing_name" style="width:90%" class="w3-select" >
    <option value="">**Please Select Item**</option>
    <option class="w3-bar-block" value="Sale">Sale</option>
    <option class="w3-bar-block" value="ผู้แนะนำ">ผู้แนะนำ</option>
  </select>
</div>
<!--button class="btn btn-default btn-sm" type="button"  href="#Lowmodal2" data-toggle="modal_a" data-target="#Lowmodal2" onClick="js_popup('getDataC.php');"></button-->

<div class="w3-bar"></div>

<div class="w3-bar w3-margin-bottom w3-quarter">
  ใบสั่งซื้อเลขที่ : <input name="po_no" type='text' id="po_no" style="width:90%" class="w3-input"/>
</div>
<div class="w3-bar w3-margin-bottom w3-quarter">
  กำหนดส่งตามสัญญา : <input name="delivery_contract" type='text' id="delivery_contract" style="width:90%" class="w3-input"/>
</div>
<div class="w3-bar w3-margin-bottom w3-quarter">
  วันที่ออกบิล : <input name="" type='date' id="billing_date" style="width:90%" class="w3-input"/></p>
</div>

<div class="w3-bar"></div>

<div class="w3-bar w3-margin-bottom w3-quarter">
  ที่อยู่ที่ต้องการออกบิล : <textarea name="billing_address"  class="w3-input" id="billing_address" style="width:90%" cols="35" rows="1"></textarea>
</div>
<div class="w3-bar w3-margin-bottom w3-quarter">
  ชำระโดย : 
  <select name="credit" class="w3-select" style="width:90%">
   <option value="">**Please Select Item**</option>
    <?php
	  $strSQL4 = "SELECT * FROM tb_credit ORDER BY credit_id ASC";
	  $objQuery4 = mysqli_query($conn,$strSQL4);
	  while($objResuut4 = mysqli_fetch_array($objQuery4)){
	?>
   <option value="<?php echo $objResuut4["credit_name"];?>"><?php echo $objResuut4["credit_name"];?></option>
	<?php
		}
	?>
  </select>
</div>
<div class="w3-bar w3-margin-bottom w3-quarter">
  Sale Comment : <textarea name="billing_address"  class="w3-input" id="billing_address" style="width:90%" cols="35" rows="1"></textarea>
</div>

<div class="w3-bar"></div>

<div class="w3-bar w3-margin-bottom w3-quarter">
  เลขที่ผู้เสียภาษี : <input name="billing_no" type='text' id="billing_no" style="width:90%" class="w3-input"/>
</div>
<div class="w3-bar w3-margin-bottom w3-quarter">
  เบอร์โทรศัพท์ : <input name="billing_tel" type='text' id="billing_tel" style="width:90%" class="w3-input"/>
</div>
<div class="w3-bar w3-margin-bottom w3-quarter">
 <div class="w3-half">
  BQ เลขที่ : <input name="bq" type='text' id="bq" style="width:80%" class="w3-input"/>
 </div>
 <div class="w3-half">
  OT เลขที่ : <input name="ot" type='text' id="ot"  style="width:80%"  class="w3-input"/>
 </div>
</div>

<div class="w3-bar"></div>

<input type="checkbox" name="description_other" id="description_other" onClick="ck_frm();" value="1"/> <b>รายละเอียดเพิ่มเติม</b><br/>
<div id="frm_txt" style="display:none;">
  รายการของแถมอื่น ๆ : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; พิมพ์ตาม 
  <input type='checkbox'  name='type_com' id = 'type_com' value='1' />&nbsp;Computer
			  &nbsp; <input type='checkbox'  name='type_so' id = 'type_so' value='1' />&nbsp;ใบสั่งซื้อ
			   &nbsp; <input type='checkbox'  name='type_type' id = 'type_type' value='1' />&nbsp;ที่เขียน
  
  </p>
<textarea name="free_item"  class="button4" id="free_item" cols="35" rows="2"></textarea>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<textarea name="type_type_detail"  class="button4" id="type_type_detail" cols="35" rows="2"></textarea></p>
  <input type='checkbox'  name='with_pr' id = 'with_pr' value='1' />&nbsp;แนบใบเสนอราคา</p>
 <input type='checkbox'  name='clear_book_nockk' id = 'clear_book_nockk' value='1' />&nbsp;Clear ใบจองสินค้า เลขที่
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 รับประกัน &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PM &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; CAL

 </p>
   <input name="clear_book_no" type='text' id="clear_book_no"  size="20"  class="button4"/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <input name="waranty" type='text' id="waranty"  size="20"  class="button4"/>
&nbsp;&nbsp;&nbsp;&nbsp;
   <input name="pm" type='text' id="pm"  size="20"  class="button4"/>
&nbsp;&nbsp;&nbsp;&nbsp;
   <input name="cal" type='text' id="cal"  size="20"  class="button4"/></p>


<input type='checkbox'  name='clear_brn_nockk' id = 'clear_brn_nockk' value='1' />&nbsp;Clear ใบยืมสินค้าติดเล่ม BRN
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 <input type='checkbox'  name='clear_brnp_nockk' id = 'clear_brnp_nockk' value='1' />&nbsp;Clear ใบยืมสินค้าติดเล่ม BRN
</p>
  <input name="clear_brn_no" type='text' id="clear_brn_no"  size="20"  class="button4"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="clear_brnp_no" type='text' id="clear_brnp_no"  size="20"  class="button4"/>
</p> สถานที่ติดตั้งเครื่อง </p>
 <textarea name="install_place"  class="button4" id="install_place" cols="35" rows="2"></textarea></p>






</br> </br>

</div>


 <input type="checkbox" name="delivery" id="delivery" onClick="ck_delivery();" value="1"/>&nbsp;&nbsp;&nbsp;การจัดส่ง<br/>

<div id="frm_delivery" style="display:none;">
</p></p>




 สถานที่ส่ง   
 </p>
 <textarea name="delivery_place"  class="button4" id="delivery_place" cols="35" rows="2"></textarea>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 ชื่อผู้ติดต่อ : &nbsp;<input name="delivery_contact" type='text' id="delivery_contact"  size="20"  class="button4"/>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  เบอร์โทรศัพท์ :
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="delivery_tel" type='text' id="delivery_tel"  size="20"  class="button4"/> </p>

<input type='checkbox'  name='delivery_contact' id = 'delivery_contact' value='1' />&nbsp;บริษัทจัดส่ง&nbsp;&nbsp;&nbsp;
 <input type='checkbox'  name='delivery_engineer' id = 'delivery_engineer' value='1' />&nbsp; ส่งสินค้าแผนกช่าง &nbsp;&nbsp;&nbsp;

<input type='checkbox'  name='delivery_sale' id = 'delivery_sale' value='1' />&nbsp;Sale รับเอง&nbsp;&nbsp;&nbsp;
 <input type='checkbox'  name='delivery_customer' id = 'delivery_customer' value='1' />&nbsp;ลูกค้ารับเอง &nbsp;&nbsp;&nbsp;</p>


<input type='checkbox'  name='start_date' id = 'start_date' value='1' onClick="ck_start_date();" />&nbsp;วันที่รับ - ส่ง&nbsp;&nbsp;&nbsp;
 <input type='checkbox'  name='between_date' id = 'between_date' value='1' onClick="ck_between_date();"/>&nbsp;ช่วงวัน - เวลาที่รับ - ส่ง &nbsp;&nbsp;&nbsp;


<div id="frm_start_date" style="display:none;">
</p>

 วันที่ : &nbsp;<input name="delivery_date" type='date' id="delivery_date"  size="20"  class="button4"/>&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp; เวลา : &nbsp;<input name="start_time" type='text' id="start_time"  size="20"  class="button4"/> &nbsp;&nbsp;&nbsp;
 ถึง :&nbsp;&nbsp;&nbsp;<input name="end_time" type='text' id="end_time"  size="20"  class="button4"/>

</p>

</div>


<div id="frm_between_date" style="display:none;">
</p>
 วันที่โดยประมาณ : &nbsp;<input name="delivery_betweendate" type='text' id="delivery_betweendate"  size="20"  class="button4"/>&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp; เวลา : &nbsp;<input name="start_time" type='text' id="start_time"  size="20"  class="button4"/> &nbsp;&nbsp;&nbsp;
 ถึง :&nbsp;&nbsp;&nbsp;<input name="end_time" type='text' id="end_time"  size="20"  class="button4"/>

</p>

</div>





</br> </br>
</div>

</div>










<div id="frm_type_document1" style="display:none;">











</div>














</br>

<?php include ('product_name_other1.php'); ?>


</div>

</br>