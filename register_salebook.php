<?php include('head.php'); 
include('dbconnect.php');
?>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

<link rel="stylesheet" href="css/autocomplete.css"  type="text/css"/>
<script type="text/javascript" src="js/autocomplete.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>

<script language="JavaScript">

var HttPRequest = false;
function doCallAjax1(bill_id,customer,address_send) {
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
var url = 'data_bill_name1.php';
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

document.getElementById(customer).value = myArr[0];
document.getElementById(address_send).value = myArr[1];

}
}
}
}

    
</script>

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
	<div class="w3-panel w3-light-grey"><h3>ใบจองสินค้า</h3></p>	
	<h5>(Product Booking)</h5>
	</div>
	<form action="register_salebook1.php" method="post" name="frmMain" enctype="multipart/form-data"  >
		

	<div class="w3-bar">
	
		<?php
			

$yearMonth = substr(date("Y")+543, -2).date("m");
$sql = "SELECT MAX(ref_id) AS MAXID FROM hos__jongproduct";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
$maxId = substr($rs['MAXID'], -4);
$maxId3 = substr($rs['MAXID'],-8);

$maxId1 = substr($maxId3,0,-4);
$so = "PD";

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
			<input type="radio" name="company"  checked ='checked' value="1">&nbsp;AWL
           				</div>
			<div class="w3-bar w3-margin-bottom">
<input type="radio" name="type_jong" id="type_jong"   value="1" required>&nbsp;จองมีสัญญา
<input type="radio" name="type_jong" id="type_jong"   value="2" required>&nbsp;จองตามการประมาณการ
<input type="radio" name="type_jong" id="type_jong"   value="3" required>&nbsp;จองสินค้าสาธิต
				
</div>

		<div class="w3-bar w3-margin-bottom">
			วันที่แจ้ง  :<input type="date" name="date_jong" value = "<?php echo $today; ?>" style="width:30%;" class="w3-input"  >
			
</div>
<div class="w3-bar w3-margin-bottom">
			เลขที่ BQ 
			<input type="text" name="bq_no" id="bq_no" class="w3-input" style="width:90%;"  >
</div>

			<div class="w3-bar w3-margin-bottom">
หมายเหตุ :&nbsp;		
			<textarea name="drescription" id="drescription" class="w3-input" style="width:90%;"  ></textarea>
			</div>
</div>
<div class="w3-half 1">

<div class="w3-bar w3-margin-bottom">
			วันที่ต้องการสินค้า :<input type="date" name="date_receive"  style="width:30%;" class="w3-input"  required>
			
</div>

	รหัสลูกค้า  : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<input type='text' name = "bill_id"  id = "bill_id" class="w3-input" placeholder="Search ชื่อลูกค้า..."  style="width:90%;" OnChange="JavaScript:doCallAjax1('bill_id','customer');"/> 
<input type='hidden' name = "h_bill_id"  id = "h_bill_id"  class="button4" readonly>
	
<div class="w3-bar w3-margin-bottom">
			ชื่อลูกค้า 
			<input type="text" name="customer" id="customer" class="w3-input" style="width:90%;"  required>
</div>

<div class="w3-bar w3-margin-bottom">
	สถานที่ส่ง :<textarea name="address_send" id="address_send" class="w3-input" style="width:90%;"  required></textarea>

</div>
</div>
		
		

	</p>

<div class="w3-bar w3-light-grey w3-border">
  <a class="w3-bar-item w3-button" onclick="openCity1('pd')"><font color="#404040"><b>รายการสินค้า</b></font></a>
</div>

<div id="pd" class="w3-container city1">


<?php
	
 if($_SESSION['department']=="วิศวกรรม"){ 
		include ('detail_engjong.php');
 }else{
	include ('detail_salejong.php');
 }	
	?>	

</div>


	<div class="w3-bar w3-center">
			<input type="submit" name="submit" class="w3-button w3-teal be-border" value="บันทึกข้อมูล">
	</div><br>
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

<?php if($_SESSION['department']=="วิศวกรรม"){ ?>

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
		return "data_bill_name.php?bill_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("bill_id","h_bill_id");
</script> 

<?php }else{ ?>

  
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
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("bill_id","h_bill_id");
</script> 

<?php
}
?>