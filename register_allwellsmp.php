<?php include('head.php'); ?>
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

	
<style>
	.none {
    display:none;
	}
</style>


<script language="JavaScript">

var HttPRequest = false;
function doCallAjax1(bill_id,customer_name,customer_tel,address_name,customer_typename) {
HttPRequest = false;
if (window.XMLHttpRequest) { // Mozilla, Safari,...
HttPRequest = new XMLHttpRequest();

if (HttPRequest.overrideMimeType) {
HttPRequest.overrideMimeType('text/html');
}
} else if (window.ActiveXObject) { // IE
try {
HttPRequest = new ActiveXObject("Msxml2.XMLHTTP");
} catch (e) {
try {
HttPRequest = new ActiveXObject("Microsoft.XMLHTTP");
} catch (e) {}
}
}

if (!HttPRequest) {

alert('Cannot create XMLHTTP instance');
return false;
}
var url = 'data_smp_name.php';
var pmeters = "bill_id=" + encodeURI( document.getElementById(bill_id).value);
HttPRequest.open('POST',url,true);

HttPRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
HttPRequest.setRequestHeader("Content-length", pmeters.length);
HttPRequest.setRequestHeader("Connection", "close");
HttPRequest.send(pmeters);

HttPRequest.onreadystatechange = function()
{
if(HttPRequest.readyState == 4) // Return Request
{
var myProduct = HttPRequest.responseText;

if(myProduct != "")
{

var myArr = myProduct.split("|");

//document.getElementById(bill_id).value = myArr[0];
document.getElementById(customer_name).value = myArr[0];
document.getElementById(customer_tel).value = myArr[1];
document.getElementById(address_name).value = myArr[2];
document.getElementById(customer_typename).value = myArr[3];

}
}
}
}

    
</script>



<div class="w3-white" >
		<div class="w3-container w3-padding-large">
	<div class="w3-panel w3-light-grey"><h3>ใบเบิกสินค้าเพื่อสนับสนุนการขาย</h3></p>	
	<h5>(Sample Request)</h5>
	</div>
	<form action="register_allwellsmp1.php" method="post" name="frmMain" enctype="multipart/form-data"   onSubmit="JavaScript:return fncSubmit();" >
		
<script language="javascript">
function fncSubmit()   //ห้ามชื่อสินค้า ยี่ห้อสินค้า รุ่นสินค้าเป็
{
	
	if(document.frmMain.start_time.value == ""){
			
		alert('กรุณาใส่เวลาส่ง');
		document.frmMain.start_time.focus();
		return false;
		}
	
		if(document.frmMain.customer_name1.value == ""){
		alert('กรุณาใส่ชื่อลูกค้า');
		document.frmMain.customer_name1.focus();
		return false;
		}
	
	if(document.frmMain.customer_tel.value == ""){
		alert('กรุณาใส่เบอร์โทรลูกค้า');
		document.frmMain.customer_tel.focus();
		return false;
		}
	if(document.frmMain.address_1.value == ""){
		alert('กรุณาใส่สถานที่ส่งสินค้า');
		document.frmMain.address_1.focus();
		return false;
		}
	
		if(document.frmMain.address_name.value == ""){
		alert('กรุณาใส่ที่อยู่ในการส่งสินค้า');
		document.frmMain.address_name.focus();
		return false;
		}
	
	if(document.frmMain.address_send.value == ""){
		alert('กรุณาใส่สถานที่ติดตั้งเครื่อง');
		document.frmMain.address_send.focus();
		return false;
		}
	if(document.frmMain.province_name.value == ""){
		alert('กรุณาเลือกจังหวัดที่ต้องการจัดส่ง');
		document.frmMain.province_name.focus();
		return false;
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



		?>
		<span class="w3-light-grey w3-right"> เลขที่อ้างอิง : <?php echo $so; echo $nextId; ?></span>
		<input type="hidden" name="ref_idsmp" class="w3-input" value="<?php echo $so; echo $nextId; ?>">
	</div>

	<div class="w3-bar w3-padding-small"></div><!-- bar -->
		<div class="w3-half 1">
			<div class="w3-bar w3-margin-bottom">
			<input type="radio" name="type_company"  checked ='checked' value="1">&nbsp;AWL

				</div>
			
		<div class="w3-bar w3-margin-bottom">
			
			วันที่คลัง  :<input type="date" name="smp_date" value = "<?php echo $today; ?>" style="width:30%;" class="w3-input"  required>
</div>
			<div class="w3-bar w3-margin-bottom">
ที่อยุ่ :<textarea name="address_name" id="address_name" class="w3-input" style="width:90%;"  required></textarea>
</div>

	<div class="w3-bar w3-margin-bottom">
ชื่อพนักงาน:
		
<?php if ($_SESSION['name']=='หัทญา') { ?> 
<input type="text" name="sale_code" value = "<?php echo '(SOL99)'; ?>" style="width:80%;" class="w3-input"  required>
		
<?php }else{ ?>
		
<select  name="sale_code" class="w3-input" style="width:90%;" >
<option value="">**Please Select Item**</option>

<?php
$emp = "select * from tb_employee where department_id='1' order by employee_ID";
$sqlemp = mysqli_query($conn,$emp);
while ($fetchemp = mysqli_fetch_array($sqlemp,MYSQLI_ASSOC)) { ?>
<option class="w3-bar-item w3-button" value="<?php echo $fetchemp['employee_name']; ?>"><?php echo $fetchemp['employee_name']; ?></option>
<?php } ?>
</select>
		
		<?php } ?>

</div>
			
<div class="w3-bar w3-margin-bottom">			
			แนบไฟล์
<input name="up_img1" style="width:90%;"  class="w3-input"  type="file">
</div>

<div class="w3-bar w3-margin-bottom">			
			
<input name="up_img2" style="width:90%;"  class="w3-input"  type="file">
</div>
<div class="w3-bar w3-margin-bottom">			
			
<input name="up_img3" style="width:90%;"  class="w3-input"  type="file">
</div>				
			
			
</div>
<div class="w3-half 1">
	
<div class="w3-bar w3-margin-bottom">	
	ID ลูกค้า
<input type='text' name = "bill_id"  id = "bill_id" style="width:90%;" class="w3-input" placeholder="Search ชื่อลูกค้า..."   OnChange="JavaScript:doCallAjax1('bill_id','customer_name','customer_tel','address_name','customer_typename');" required> 
<input type='hidden' name = "h_bill_id"  id = "h_bill_id"  class="button4" readonly>	
</div>
<div class="w3-bar w3-margin-bottom">
			ชื่อลูกค้า 
			<input type="text" name="customer_name" id="customer_name" class="w3-input" style="width:90%;"  required>
</div>
	
<div class="w3-bar w3-margin-bottom">
			เบอร์โทร 
			<input type="text" name="customer_tel" id="customer_tel" class="w3-input" style="width:90%;"  required>
</div>	
<div class="w3-bar w3-margin-bottom">
			หมายเลขคำสั่งซื้อ 
			<input type="text" name="order_id" id="order_id" class="w3-input" style="width:90%;"  >
</div>	
	

<div class="w3-bar w3-margin-bottom">
			Comment :&nbsp;
			<textarea name="comment_sale" id="comment_sale" class="w3-input" style="width:90%;"  required></textarea>
</div>
<div class="w3-bar w3-margin-bottom">
	<input type="checkbox" name="brnp_ckk" id="brnp_ckk"  value ='1'>
			เคลียร์ใบยืม เลขที่  
			<input type="text" name="brnp_no" id="brnp_no" class="w3-input" style="width:90%;"  >
</div>		
<div class="w3-bar w3-margin-bottom">
	<input type="checkbox" name="crm_ckk" id="crm_ckk"  value ='1'>
			แลกสินค้าระบบ CRM เลขที่อ้างอิง  
			<input type="text" name="crm_ref" id="crm_ref" class="w3-input" style="width:90%;"  >
</div>		
</div>
		
		

	</p>
	<div class="w3-bar w3-light-grey w3-border">
<a class="w3-bar-item w3-button" onclick="openCity1('pd')"><font color="#404040"><b>รายการสินค้า</b></font></a>
<a class="w3-bar-item w3-button" onclick="openCity1('cs')"><font color="#404040"><b>รายละเอียดการจัดส่ง</b></font></a>
</div>


<div id="pd" class="w3-container city1">

<?php include ('detail_allwellsmp.php')?>

</div>

<div id="cs" class="w3-container city1" style="display:none">

<input type="radio" name="delivery_type" value="1" checked='checked' >&nbsp;Sale รับเอง
<input type="radio" name="delivery_type" value="2" >&nbsp;บริษัทจัดส่ง 

</p>




 วันที่ รับ-ส่ง :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input name="start_date" type='date' id="start_date"   class="button4" style="width:20%" /></p>


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
		
	 


<?php
if($_SESSION['department']=="วิศวกรรม"){
	$department="ฝ่ายวิศวกรรม";
}else{
	$department="ฝ่ายขาย";	
}
?>

แผนก - ฝ่าย :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="department_show" value="<?php echo $department; ?>" class="button4" type='text' id="department_show">


&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
       ประเภทลูกค้า :

<input name="customer_typename"  class="button4" type='text' id="customer_typename">
</p>


       หน่วยงาน :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<select name="company_name" id="company_name" class="button4"  style="width:14%" >
<option value="">**Please Select Item**</option>
<?php
$strSQL5 = "SELECT * FROM tb_company ORDER BY seq  ASC";
$objQuery5 = mysqli_query($conn,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5))
{
?>
<option value="<?php echo $objResuut5["company_name"];?>"><?php echo $objResuut5["company_name"];?></option>
<?php
}
?>
</select>

&nbsp;&nbsp;&nbsp;&nbsp;
<?php
if($_SESSION['department']=="วิศวกรรม"){
$sale='วิศวกรรม';
	}else{
$sale='Sale';	
}
?>
       ประเภทงาน :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	   <input name="department_name" value="<?php echo $sale; ?>"  class="button4" type='text' id="department_name">

</p>



ชื่อพนักงาน :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="employee_name"  class="button4" type='text' value="<?php echo $_SESSION['name']; ?>" id="employee_name" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 เบอร์โทรพนักงาน :&nbsp;
<input name="employee_tel"  class="button4" type='text' id="employee_tel" >
<input name="add_by" value="<?php echo $_SESSION['name']; ?>&nbsp;<?php echo $_SESSION['surname']; ?>" type='hidden' class="button4" >

จังหวัด :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
<select name="province_name" id ="province_name" class="button4" style="width:30%" >
<option value="">**Please Select Item**</option>
<?php
$strSQL5 = "select * from tb_province order by province_ID ";
$objQuery5 = mysqli_query($conn,$strSQL5);
if (!$objQuery5) {
	echo "Failed to fetch to MySQL: " . mysqli_error();
}
while ($objResuut5 = mysqli_fetch_array($objQuery5,MYSQLI_ASSOC)) {
?>
<option class="w3-bar-item w3-button"  value="<?php echo $objResuut5['province_name']; ?>"><?php echo $objResuut5['province_name']; ?></option>
<?php } ?>
</select>
</p>
สถานที่ส่งสินค้า :</p>
<input type='text'  class="button4" name="address_1" style="width:50%" >             


</p>
ที่อยู่ในการส่งสินค้า :</p>
<input type='text'  class="button4" name="address_name1" style="width:50%" >             


</p>

  สถานที่ติดตั้งเครื่อง :</p>
<textarea   class="button4" name="address_send"  style="width:50%" rows="2"></textarea>
</p>
ชื่อผู้ติดต่อ  :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="customer_name1"  class="button4" type='text' id="customer_name1">


&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 เบอร์โทรลูกค้า :
<input name="customer_tel"  class="button4" type='text' id="customer_tel" >
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
</div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>



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
		return "data_bill_name2.php?bill_search=" +encodeURIComponent(this.value);
    });	
}	
make_autocom("bill_id","h_bill_id");
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