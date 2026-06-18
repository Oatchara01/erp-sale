<?php include ("head.php"); ?>
<?php include('dbconnect_sale.php'); ?>
<html>
<head>
<link rel="stylesheet" href="css/autocomplete.css"  type="text/css"/>
<script type="text/javascript" src="js/autocomplete.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>

<style type="text/css">

.button {
    background-color: #339900;
    border: none;
    color: white;
    padding: 8px 10px;
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
<style type="text/css">
<!--
.style15 {
	font-size: 18px; color: #000000;
}
.style30 {font-size: 12; }
.style32 {font-size: 11px}
.style33 {font-size: 12px; }
.style34 {color: #FF0000}
.style35 {font-size: 12px; color: #f2f2f2; }
.style37 {color: #FF0000; font-size: 14px; }
.style38 {color: #f2f2f2}
.style39 {font-size: 14px}
.style40 {font-size: 16px; color: #FF0000; }
-->
</style>

<script language="JavaScript">
var HttPRequest = false;
function doCallAjax(product_code,product_id,product_name,unit_name) {
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
var url = 'data_product_hos1.php';
var pmeters = "product_code=" + encodeURI( document.getElementById(product_code).value);
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

document.getElementById(product_id).value = myArr[0];
document.getElementById(product_name).value = myArr[1];
document.getElementById(unit_name).value = myArr[2];

}
}
}
}


function chkNumber(ele)

{

var vchar = String.fromCharCode(event.keyCode);
if ((vchar<'0' || vchar>'9') && (vchar != '.')) return false;
ele.onKeyPress=vchar;
}


</script>


</head>
<body>
<form action='register_cuseng1.php' method="post" name="frmMain" enctype="multipart/form-data"  onSubmit="JavaScript:return fncSubmit();"  >
		
		
  <script language="javascript">
function fncSubmit()   //ห้ามชื่อสินค้า ยี่ห้อสินค้า รุ่นสินค้าเป็
{
	
	if(document.frmMain.type_eng.value == "2")
	{
		if(document.frmMain.date_plan.value == "")
	{
		
		alert('กรุณาใส่วันที่นัดหมาย');
		document.frmMain.date_plan.focus();
		return false;
	}
		
	}	
	
	
	if(document.frmMain.type_eng.value == "2")
	{
		if(document.frmMain.time_plan.value == "")
	{
		
		alert('กรุณาใส่เวลานัดหมาย');
		document.frmMain.time_plan.focus();
		return false;
	}
		
	}	
	
	
	
	document.frmMain.submit();
}




</script>
		
		
		
		<div class="w3-white w3-container w3-padding-large"><!-- main div -->
			<div class="w3-panel w3-light-gray"><h4>รายการรับเรื่องจากลูกค้าของช่าง</h4></div>


<?php
date_default_timezone_set("Asia/Bangkok");

$register_date = Datethai(date("Y-m-d"));
$register_time = date("H:i:s");


$yearMonth = substr(date("Y")+543, -2).date("m");
$sql = "SELECT MAX(ref_id) AS MAXID FROM tb_register_eng";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
$maxId = substr($rs['MAXID'], -4);
$maxId3 = substr($rs['MAXID'],-8);

$maxId1 = substr($maxId3,0,-4);
$so = "EN";

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
			

?>

<span class="w3-light-grey w3-right"> เลขที่อ้างอิง : <?php echo $so; echo $nextId; ?></span>

		วันที่ : &nbsp;&nbsp;&nbsp;<?php echo $register_date; ?>
		&nbsp;&nbsp;เวลา&nbsp;&nbsp;<?php echo $register_time; ?><br><br>
	<input type="radio" name="type_company"   value="1" required>&nbsp;AWL
	<input type="radio" name="type_company"   value="2" required>&nbsp;NBM
<br><br>
		
		
โรงพยาบาล : &nbsp;<input type="text" name="customer_name"  id="customer_name"  class="button4" style="width:20%;" required> &nbsp;&nbsp;&nbsp;

แผนก  : &nbsp;

<input type='text' name = "address_name"  id = "address_name" class="button4"  style="width:20%;" > 


</p>
ชื่อลูกค้า  : &nbsp;&nbsp;&nbsp;

<input type='text' name = "contact_name"  id = "contact_name" class="button4"  style="width:20%;" required></p>

 <input type='radio' name="type_eng" id="type_eng" value='1' required>ลูกค้าแจ้งซ่อม  &nbsp;&nbsp;&nbsp;
 <input type='radio' name="type_eng" id="type_eng" value='2' required>เช็คสถานที่ลูกค้า

</p>
วันที่นัดหมาย : &nbsp;<input type="date" name="date_plan"  id="date_plan"  class="button4" style="width:20%;" > &nbsp;&nbsp;&nbsp;

เวลาที่นัดหมาย  : &nbsp;

<input type='text' name = "time_plan"  id = "time_plan" class="button4"  style="width:20%;" /> 
 </p>
รายละเอียด  : </p> 

<textarea type='text' name = "description"  id = "description" class="button4"  style="width:25%;" required></textarea>
</p>

เบอร์โทรศัพท์ : &nbsp;<input type="text" name="tel_number"  id="tel_number"  class="button4" style="width:20%;" required> &nbsp;&nbsp;&nbsp;

				</p>

<input type="hidden" name="sale_code"  id="sale_code" value="<?php echo "EN10"; ?>" class="button4" style="width:20%;" required>

ผู้รับเรื่อง  : &nbsp;

<input type='text' name = "receive_name"  id = "receive_name" class="button4" value="<?php echo $_SESSION['name']; ?>&nbsp;<?php echo $_SESSION['surname']; ?>"  style="width:18%;" readonly>
</p>

แนบไฟล์ </p>
<input name="img_1"  type="file">


</p>
<input name="img_2"  type="file">


</p>
<input name="img_3"  type="file">


</p>
<input name="img_4"  type="file">


</p>
<input name="img_5"  type="file">

</p>


<div class="w3-bar w3-light-grey w3-border">
 <a class="w3-bar-item w3-button" onclick="openCity1('pd')"><font color="#404040"><b>รายการสินค้า</b></font></a>
</div>

<div id="pd" class="w3-container city1">

<table width="100%" border="0" class="w3-table">

    <th>รหัสสินค้า</th>
    <th>ชื่อสินค้า</th>
    <th>หน่วย</th>
    <th>จำนวน</th>
	<th>หมายเลขเครื่อง</th>
    <th>หมายเหตุ</th>
	 
<tbody>
<tr>
<td style="width:10%;">

<input type='text' name = "product_codet1"  id = "product_codet1" class="w3-input" placeholder="Search รหัส"  size="7" OnChange="JavaScript:doCallAjax('product_codet1','product_id1','product_name1','unit_name1');"/> 
<input type='hidden' name = "h_product_codet1"  id = "h_product_codet1"  class="button4" readonly>


<input type='text' name = "product_code1"  id = "product_code1" class="w3-input" placeholder="Search ชื่ออังกฤษ"  size="7" OnChange="JavaScript:doCallAjax('product_code1','product_id1','product_name1','unit_name1');"/> 
<input type='hidden' name = "h_product_code1"  id = "h_product_code1"  class="button4" readonly>
	
<input type='text' name = "product_c1"  id = "product_c1" class="w3-input" placeholder="Search ชื่อไทย"  size="7" OnChange="JavaScript:doCallAjax('product_c1','product_id1','product_name1','unit_name1');"/> 
<input type='hidden' name = "h_product_c1"  id = "h_product_c1"  class="button4" readonly>	
<input type='hidden' name = "product_id1"  id = "product_id1" class="w3-input" />

</td>
<td  style="width:8%;">
<textarea  name = "product_name1"  id = "product_name1"  rows="2" class="w3-input" readonly></textarea>
</td>
<td style="width:5%;">
<input type='text' name = "unit_name1"  id = "unit_name1"  class="w3-input" readonly/>
</td>
<td style="width:5%;">
<input type='text' name = "sale_count1" id = "sale_count1"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td style="width:10%;">
<textarea name = "sn_number1" id = "sn_number1"  class="w3-input"   ></textarea>
</td>
<td style="width:10%;">
<textarea name = "sale_remark1" id = "sale_remark1"  class="w3-input"   ></textarea>
</td>	
	
<td style="width:2%;"><a onclick="document.getElementById('product_code1').value = '';

document.getElementById('product_name1').value  = ''; 
document.getElementById('unit_name1').value  = '';
document.getElementById('sale_remark1').value  = '';
document.getElementById('sale_count1').value  = '';
document.getElementById('sn_number1').value  = '';
document.getElementById('product_codet1').value  = '';
document.getElementById('product_id1').value  = '';
document.getElementById('h_product_code1').value  = '';
document.getElementById('product_c1').value  = '';
document.getElementById('h_product_c1').value  = '';

"><img src="img/false.png" width="16" height="16" border="16" /></a></td>




</tr>


</tbody>
</table>

</div>

<center>
<input type="submit" name="submit" value="บันทึก" class="w3-button w3-teal" >
</center>


</form>  </div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>		


  <!--/div-->

  </body>
</html>
  
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
		return "data_pro_engcus.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_code1","h_product_code1");
        </script>






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
		return "data_pro_codecus.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_codet1","h_product_codet1");
        </script>







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
		return "data_pro_thaicus.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("product_c1","h_product_c1");
        </script>



