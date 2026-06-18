<?php include('head.php'); ?>
<?php include('dbconnect_sale.php'); ?>

<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

<link rel="stylesheet" href="css/autocomplete.css"  type="text/css"/>
<script type="text/javascript" src="js/autocomplete.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script src="dist/jautocalc.js"></script>

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

	
<style>
	.none {
    display:none;
	}
</style>

<div class="w3-white w3-container">
	<div class="w3-panel w3-light-grey"><h3>ใบเบิกสินค้าเพื่อสนับสนุนการขาย</h3></p>	
	<h5>(Sample Request)</h5>
	</div>
	<form action="register_chang426_save.php" method="post" name="frmMain" enctype="multipart/form-data"  onSubmit="JavaScript:return fncSubmit();" >
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
	<div class="w3-bar">
		
		<?php
			include('dbconnect.php');

			$yearMonth = substr(date("Y")+543, -2).date("m");
$sql = "SELECT MAX(ref_idsmp) AS MAXID FROM hos__smp";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
$maxId = substr($rs['MAXID'], -4);
$maxId3 = substr($rs['MAXID'],-8);

$maxId1 = substr($maxId3,0,-4);
$so = "RSMP";

if($maxId1 == $yearMonth)
{
$maxId1 = ($maxId + 1);
$maxId2 = substr("00000".$maxId1, -4);
$nextId = $yearMonth.$maxId2;
}
else 
{
$maxId1 = "0001"; 
$nextId = $yearMonth.$maxId1;

}


		
date_default_timezone_set("Asia/Bangkok");

$month = date('m');
$day = date('d');
$year = date('Y');

$today = $year . '-' . $month . '-' . $day;

$sql12 = "SELECT * FROM so__main  where  ref_id = '".$_GET['ref_id']."'";
$qry12 = mysqli_query($conn,$sql12) or die(mysqli_error());
$rs12 = mysqli_fetch_array($qry12);

$sql10 = "SELECT * FROM tb__glu426  where  id = '".$_GET['id']."'";
$qry10 = mysqli_query($conn,$sql10) or die(mysqli_error());
$rs10 = mysqli_fetch_array($qry10);

		

		?>
		<span class="w3-light-grey w3-right"> เลขที่อ้างอิง : <?php echo $so; echo $nextId; ?></span>
		<input type="hidden" name="ref_idsmp" class="w3-input" value="<?php echo $so; echo $nextId; ?>">
		<input type="hidden" name="id_pp" class="w3-input" value="<?php echo $_GET["id"]; ?>">
	</div>

	<div class="w3-bar w3-padding-small"></div>
		<div class="w3-half 1">
	<div class="w3-bar w3-margin-bottom">
			<input type="radio" name="type_company"  checked ='checked' value="1">&nbsp;AWL
<input type="radio" name="type_company"  value="2" >&nbsp;NBM
				</div>		
	
		<div class="w3-bar w3-margin-bottom">
			วันที่คลัง  :<input type="date" name="smp_date" value = "<?php echo $today; ?>" style="width:30%;" class="w3-input"  required>
</div>
			<div class="w3-bar w3-margin-bottom">
ที่อยู่ :<textarea 
    name="address_name" id="address_name" class="w3-input"   style="width:90%;"  required>
    <?php echo isset($rs12["delivery_place"]) ? htmlspecialchars($rs12["delivery_place"], ENT_QUOTES, 'UTF-8') : ''; ?>
</textarea>

</div>

<div class="w3-bar w3-margin-bottom">
เขตการขาย :

<select name="sale_code" id="sale_code" style="width:330px" class="w3-input" required>
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_team_adm ORDER BY sale_code ASC";
$objQuery5 = mysqli_query($com,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5)){

?>
<option value="<?php echo $objResuut5["sale_code"];?>"><?php echo $objResuut5["sale_code"];?> - <?php echo $objResuut5["sale_name"];?></option>
<?php
}
?>
</select>

</div>

<div class="w3-bar w3-margin-bottom">			
แนบไฟล์รูป SN สินค้า <br>
<input name="img_upsn" id="img_upsn" style="width:90%;"  class="w3-input"  type="file" required>
</div>

<!--div class="w3-bar w3-margin-bottom">			
			
<input name="up_img2" style="width:90%;"  class="w3-input"  type="file">
</div>
<div class="w3-bar w3-margin-bottom">			
			
<input name="up_img3" style="width:90%;"  class="w3-input"  type="file">
</div-->		
			
</div>
<div class="w3-half 1">
<div class="w3-bar w3-margin-bottom">
			ชื่อลูกค้า 
			<input type="text" name="customer_name" id="customer_name" class="w3-input" style="width:90%;"  value="<?php echo $rs12["customer_name"]; ?>" required>
	<input type="hidden" name="bill_id" id="bill_id" class="w3-input" style="width:90%;"  value="<?php echo $rs12["bill_id"]; ?>" >
	<input type="hidden" name="ref_idsale" id="ref_idsale" class="w3-input" style="width:90%;"  value="<?php echo $rs12["ref_id"]; ?>" >
</div>
<div class="w3-bar w3-margin-bottom">
	<font color='red'>หมายเลขคำสั่งซื้อใหม่</font>
	<input type="text" name="order_no" id="order_no" class="w3-input" style="width:90%;" >
	<font color='red'>เลขที่อ้างอิงใบสั่งขายใหม่</font>
	<input type="text" name="ref_idnew" id="ref_idnew" class="w3-input" style="width:90%;" >
	
	<input type="hidden" name="bill_id" id="bill_id" class="w3-input" style="width:90%;"  value="<?php echo $rs12["bill_id"]; ?>" >
	<input type="hidden" name="ref_idsale" id="ref_idsale" class="w3-input" style="width:90%;"  value="<?php echo $rs12["ref_id"]; ?>" >
</div>

<div class="w3-bar w3-margin-bottom">
			Comment Sale:&nbsp;
			<textarea name="comment_sale" id="comment_sale" class="w3-input" style="width:90%;"  required>เบิกเครื่องวัดระดับน้ำตาลในเลือด GLUCOALL-1B (เฉพาะเครื่อง) ทดแทนลูกค้าซื้อเครื่องวัดน้ำตาล G-426</textarea>
</div>
<div class="w3-bar w3-margin-bottom">
			Comment Sup :&nbsp;
			<textarea name="comment_sup" id="comment_sup" class="w3-input" style="width:90%;"  ></textarea>
</div>
</div>
		
		

	</p>
	<div class="w3-bar w3-light-grey w3-border">
  <a class="w3-bar-item w3-button" onclick="openCity1('pd')"><font color="#404040"><b>รายการสินค้า</b></font></a>
 <a class="w3-bar-item w3-button" onclick="openCity1('cs')"><font color="#404040"><b>รายละเอียดการจัดส่ง</b></font></a>
</div>

<?php 

$sql11 = "SELECT access_code,sol_name,unit_name,sol_price  FROM tb_product where product_ID = '5499'";
$qry11 = mysqli_query($conn,$sql11) or die(mysqli_error());
$rs11 = mysqli_fetch_assoc($qry11);	

?>

<div id="pd" class="w3-container city1">

<table width="100%" border="0" class="w3-table">

    <th>รหัสสินค้า</th>
    <th>ชื่อสินค้า</th>
    <th>หน่วย</th>
    <th>จำนวน</th>
    <th>ราคาต่อหน่วย</th>
    <th>ยอดรวม</th>
	<th>จำนวนรับประกัน</th>
	<th>หมายเหตุ</th>
	<th><font color='red'>หมายเลขเครื่องเดิม</font></th>
	<th><font color='red'>หมายเลขเครื่องใหม่</font></th>
	<th>เคลียร์ยืม</th>
	
<tbody>
<tr>
<td style="width:10%;">

<input type='text' name = "product_codet1" value="<?php echo $rs11["access_code"]; ?>"  id = "product_codet1" class="w3-input" placeholder="Search รหัส"  size="7"  readonly>
<input type='hidden' name = "product_id1" value="<?php echo '5499'; ?>"  id = "product_id1" class="w3-input" />

</td>
<td  style="width:8%;">
<textarea  name = "product_name1"  id = "product_name1"  rows="2" class="w3-input" readonly><?php echo $rs11["sol_name"]; ?></textarea>
</td>
<td style="width:5%;">
<input type='text' name = "unit_name1"  id = "unit_name1"  value="<?php echo $rs11["unit_name"]; ?>"   class="w3-input" readonly/>
</td>
<td style="width:5%;">
<input type='text' name = "sale_count1" id = "sale_count1"  class="w3-input" style="color:black;text-align:center"  required>
</td>
<td style="width:8%;">
<input type='text' name = "product_price1"  id = "product_price1" value="<?php echo $rs11["sol_price"]; ?>" class="w3-input" size="7" style="color:black;text-align:right" readonly>
</td >
	
<td style="width:8%;"><input type='text' name = "sum_amount1"  id = "sum_amount1"  class="w3-input" size="7" style="color:black;text-align:right" value="" jAutoCalc= '{sale_count1} * {product_price1}'readonly/>
</td>
<td style="width:5%;">
<input type='text' name = "waranty1" id = "waranty1"  class="w3-input" style="color:black;text-align:center"  />
</td>
	
<td style="width:10%;">
<textarea name = "sale_remark1" id = "sale_remark1"  class="w3-input"   ></textarea>
</td>
<td style="width:10%;">
<textarea name = "sn_old1" id = "sn_old1"  class="w3-input"   readonly><?php echo trim($rs10["sn"]); ?></textarea>
</td>	
<td style="width:10%;">
<textarea name = "sn1" id = "sn1"  class="w3-input"  ></textarea>
</td>	
	
<td style="width:8%;">
	<input type='checkbox' name = "clear_br1" value="1" id = "clear_br1"  class="w3-input" >
	<input type='text' name = "br_no1" id = "br_no1"  class="w3-input"  >
</td>
	
<td style="width:2%;"><a onclick="document.getElementById('product_code1').value = '';

document.getElementById('product_name1').value  = ''; 
document.getElementById('unit_name1').value  = '';
document.getElementById('product_price1').value  = '';
document.getElementById('sale_count1').value  = '';
document.getElementById('sum_amount1').value  = '';
document.getElementById('product_codet1').value  = '';
document.getElementById('product_id1').value  = '';

"><img src="img/false.png" width="16" height="16" border="16" /></a></td>




</tr>
</table>
</div>

<div id="cs" class="w3-container city1" style="display:none">

<input type="radio" name="delivery_type" value="1"  >&nbsp;Sale รับเอง
<input type="radio" name="delivery_type" value="2" checked='checked'>&nbsp;บริษัทจัดส่ง 

</p>




 วันที่ รับ-ส่ง :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input name="start_date" type='date' id="start_date" value="<?php echo $today; ?>"   class="button4" style="width:20%" /></p>


วันที่ต้องการโดยประมาณ :
	  <input name="between_date"  class="button4" type='text' id="between_date" style="width:20%" />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 เวลา :&nbsp;&nbsp;&nbsp;&nbsp;
<input id="start_time"  name="start_time"  class="button4" type="text" style="width:10%"/>
ถึง
<input id="end_time" name="end_time"  class="button4" type="text" style="width:10%"/></p>



สถานะการทำงาน : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<input type='radio'  name='status' id = 'status' value='ส่ง' checked='checked'/>ส่ง
&nbsp; <input type='radio'  name='status' id = 'status' value='รับ' />รับ

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
สถานะ :&nbsp;&nbsp;
      <input name="status_comment" type='text' id="status_comment"  style="width:22%" class="button4"/></p>


<input type="checkbox"  name="fix_datetime" id = "fix_datetime" value="1">นัดวันและเวลาเรียบร้อยแล้ว &nbsp;&nbsp;
<input type="checkbox"  id = "on_time" name="on_time" value="1">งานสำคัญต้องตรงเวลา&nbsp;&nbsp;


<input type="checkbox"  id = "call_customer" name="call_customer" value="1">โทรแจ้งลูกค้าก่อนไป
		
&nbsp;&nbsp;<input type="checkbox"  id = "call_back" name="call_back" value="1">ต้องการให้โทรกลับเมื่อส่งสินค้าเสร็จแล้ว&nbsp;&nbsp;
<input type="checkbox"  id = "no_money" name="no_money" value="1">ไม่ต้องเก็บเงิน&nbsp;&nbsp;
<input type="checkbox"   name="want_bus" value="1">ต้องการรถใหญ่</p>
		
	 


<?php $department="ฝ่ายขาย"; ?>

แผนก - ฝ่าย :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="department_show" value="<?php echo $department; ?>" class="button4" type='text' id="department_show">


&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
       ประเภทลูกค้า :

<input name="customer_typename" value="<?php echo "ลูกค้าทั่วไป"; ?>" class="button4" type='text' id="customer_typename">
</p>


       หน่วยงาน :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="company_name" value="<?php echo "ออลล์เวล ไลฟ์ บจก."; ?>" class="button4" type='text' id="company_name">

&nbsp;&nbsp;&nbsp;&nbsp;
<?php
$sale='Sale';	
?>
       ประเภทงาน :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	   <input name="department_name" value="<?php echo $sale; ?>"  class="button4" type='text' id="department_name">

</p>
ชื่อผู้ติดต่อ  :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="customer_name1"  class="button4" type='text'  value="<?php echo $rs12["customer_name"]; ?>" id="customer_name">

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 ผู้รับสินค้า :&nbsp;&nbsp;
<input name="customer_contact"  value="<?php echo $rs12["customer_name"]; ?>" class="button4" type='text' id="customer_contact">


&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 เบอร์โทรลูกค้า :
<input name="customer_tel"  class="button4" type='text'  value="<?php echo $rs12["tel"]; ?>" id="customer_tel" >
</p>
ชื่อพนักงาน :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="employee_name"  class="button4" type='text' value="<?php echo $_SESSION['name']; ?>" id="employee_name" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 เบอร์โทรพนักงาน :&nbsp;
<input name="employee_tel"  class="button4" type='text' id="employee_tel" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 ผู้ลงงาน :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="add_by" value="<?php echo $_SESSION['name']; ?>&nbsp;<?php echo $_SESSION['surname']; ?>" type='text' class="button4" >



</p>
สถานที่ส่งสินค้า :</p>
<textarea  class="button4" name="address_1" style="width:50%" ><?php echo "SPX Express"; ?></textarea>            


</p>
ที่อยู่ในการส่งสินค้า :</p>
<textarea  class="button4" name="address_name1"  style="width:50%" ><?php echo $rs12["delivery_place"]; ?></textarea>            
</p>

  สถานที่ติดตั้งเครื่อง :</p>
<textarea   class="button4" name="address_send" style="width:50%" rows="2"><?php echo $rs12["delivery_place"]; ?></textarea>
</p>
เลขที่เอกสาร/เลขที่เครื่อง : </p>
<textarea name="product_sn"  class="button4" id="product_sn" style="width:50%" rows="2"></textarea>
</p>
สินค้า/เอกสาร :</p>
<textarea name="product"  class="button4" id="product" style="width:50%" rows="2"></textarea>


</p>
รายละเอียดเพิ่มเติม :</p> 
     <textarea name="description"  class="button4" id="description" style="width:50%" rows="2"></textarea>



	
</div><!-- cs -->


	<div class="w3-bar w3-center">
			<input type="submit" name="submit" class="w3-button w3-teal be-border" value="บันทึกข้อมูล">
	</div>
	</div>
	</form>
</div>
<?php include('foot.php'); ?>



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