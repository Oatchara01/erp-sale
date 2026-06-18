<?php include ("head.php"); ?>
<link rel="stylesheet" href="css/autocomplete.css"  type="text/css"/>
<script type="text/javascript" src="js/autocomplete.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.microsoft.com/ajax/jQuery/jquery-1.4.2.min.js"></script>

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
function doCallAjax1(bill_id,billing_name,billing_address,billing_tel,tax_id,customer_no,tel_mem,ex_add,ex_aumper,ex_provin,ex_post,pre_name,customer_name,address1,address2,province,postcode,tel,delivery_contact,delivery_place) {
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

document.getElementById(billing_name).value = myArr[0];
document.getElementById(billing_address).value = myArr[1];
document.getElementById(billing_tel).value = myArr[2];
document.getElementById(tax_id).value = myArr[3];
document.getElementById(customer_no).value = myArr[4];
document.getElementById(tel_mem).value = myArr[5];
document.getElementById(ex_add).value = myArr[6];
document.getElementById(ex_aumper).value = myArr[7];
document.getElementById(ex_provin).value = myArr[8];
document.getElementById(ex_post).value = myArr[9];
document.getElementById(pre_name).value = myArr[10];
document.getElementById(customer_name).value = myArr[12];
document.getElementById(address1).value = myArr[13];
document.getElementById(address2).value = myArr[14];
document.getElementById(province).value = myArr[15];
document.getElementById(postcode).value = myArr[16];
document.getElementById(tel).value = myArr[17];	
document.getElementById(delivery_contact).value = myArr[18];
document.getElementById(delivery_place).value = myArr[19];
}
}
}
}

    
</script>


<script>
function showUser(str) {
    if (str == "") {
        document.getElementById("txtHint").innerHTML = "";

		
        return;
    } else { 
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("txtHint").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","getuser.php?q="+str,true);
        xmlhttp.send();




    }


}



function fncSum()
{

var payment = document.frmMain.payment.value;
 
document.frmMain.payment1.value  = payment;

}
	


function object() {
		if (document.getElementById('object1').checked) {
			document.getElementById('dt1').style.display = 'block';
			document.getElementById('dt2').style.display = 'none';
			document.getElementById('dt3').style.display = 'none';
			document.getElementById('dt4').style.display = 'none';
		}
		else if (document.getElementById('object2').checked) {
			document.getElementById('dt1').style.display = 'none';
			document.getElementById('dt2').style.display = 'block';
			document.getElementById('dt3').style.display = 'none';
			document.getElementById('dt4').style.display = 'none';
		}
		else if (document.getElementById('object3').checked) {
			document.getElementById('dt1').style.display = 'none';
			document.getElementById('dt2').style.display = 'none';
			document.getElementById('dt3').style.display = 'block';
			document.getElementById('dt4').style.display = 'none';
		}
		else if (document.getElementById('object4').checked) {
			document.getElementById('dt1').style.display = 'none';
			document.getElementById('dt2').style.display = 'none';
			document.getElementById('dt3').style.display = 'none';
			document.getElementById('dt4').style.display = 'block';
		}
	
	}


function ckk_1() {
		if (document.getElementById('object5').checked) {
			document.getElementById('dt5').style.display = 'block';
		}
		else if (document.getElementById('object6').checked) {
			document.getElementById('dt5').style.display = 'none';
		}
		else if (document.getElementById('object7').checked) {
			document.getElementById('dt5').style.display = 'none';
		}
}



function ckk_2() {
		if (document.getElementById('object8').checked) {
			document.getElementById('dv1').style.display = 'block';
			document.getElementById('dv2').style.display = 'none';
		}
		else if (document.getElementById('object9').checked) {
			document.getElementById('dv1').style.display = 'block';
			document.getElementById('dv2').style.display = 'none';
		}
		else if (document.getElementById('object10').checked) {
			document.getElementById('dv1').style.display = 'block';
			document.getElementById('dv2').style.display = 'none';
		}
			else if (document.getElementById('object11').checked) {
			document.getElementById('dv1').style.display = 'none';
			document.getElementById('dv2').style.display = 'block';
		}
}



</script>



<body>
<?php
$ref_id = $_GET["ref_id"];
	
$strSQL = "SELECT *  FROM hos__rental WHERE ref_id = '".$ref_id."' ";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);
	
$strSQL6 = "SELECT *  FROM tb_customer WHERE customer_id = '".$objResult["rental_id"]."' ";
$objQuery6 = mysqli_query($conn,$strSQL6) or die(mysqli_error());
$objResult6 = mysqli_fetch_array($objQuery6);	

$sql1 = "select * from so__main order by main_id desc limit 1";
$query1 = mysqli_query($conn,$sql1);
$fetch1 = mysqli_fetch_array($query1,MYSQLI_ASSOC); ?>

	<!--action="register_office1.php"-->
	<form action='register_allwell1.php' method="post" name="frmMain" enctype="multipart/form-data">
	<div class="w3-white">
		<div class="w3-container w3-padding-large"><!-- main div -->
			<div class="w3-panel w3-light-gray"><h4>Register Data</h4></div>
		<div class="w3-third"><!-- first half -->
			<div class="w3-bar w3-border">
<div class="w3-button">
<?php if($objResult["type_doc"]=='3'){ ?>	
<input type="radio" checked='checked' name="select_type_doc" onclick="javascript:object();" value="3" id="object3">&nbsp;ใบสั่งขาย AWL
<?php }else if($objResult["type_doc"]=='4'){ ?>
<input type="radio" checked='checked' name="select_type_doc" onclick="javascript:object();" value="4" id="object3">&nbsp;ใบสั่งขาย NBM
	
	<?php } ?>
	
<input type="hidden" name="ref_rentel"  value="<?php echo $ref_id; ?>" id="ref_rentel">
<input type="hidden" name="type"  value="<?php echo "IV"; ?>" id="type">
	
				</div>

			</div>
			<div class="w3-padding-small"></div>
				<div class="w3-bar">
					วันที่ : <span class="w3-light-grey"><?php echo DateThai(date("d-m-Y")); ?></span> | เลขที่อ้างอิง : <span name="ref_id" class=""><?php echo $fetch1['ref_id']+1; ?></span> <input type="hidden" name="main_id" value="<?php echo $fetch1['main_id']+1; ?>"><input type="hidden" name="ref_id" value="<?php echo $fetch1['ref_id']+1; ?>">
				</div>
			<div class="w3-padding-small"></div>
				<div class="w3-bar">
			ช่องทางการขาย
<select name="sale_channel" id="sale_channel" class="w3-select" onchange="showUser(this.value)" OnChange="resutName(this.value);" required>
<option  value="">**โปรดเลือกช่องทางการขาย**</option>
<?php
$sqlchannel = "select * from tb_salechannel order by salechannel_ID";
$querychannel = mysqli_query($conn,$sqlchannel);
while ($fetchchannel = mysqli_fetch_array($querychannel,MYSQLI_ASSOC)) { ?>
<option class="w3-bar-item w3-button" value="<?php echo $fetchchannel['salechannel_ID']; ?>"><?php echo $fetchchannel['salechannel_nameshort']; ?><?php echo $fetchchannel['description_chanel']; ?></option>
<?php } ?>
</select>
		</div>		
				<div class="w3-padding-small"></div>
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
							?>
									<option class="w3-bar-item w3-button" value="<?php echo $fetchdeli['delivery_id'];?>"><?php echo $fetchdeli["delivery_name"]; ?><?php echo $fetchdeli["time_delivery"]; ?></option>
							<?php } ?>
				</select>
<div class="w3-padding-small"></div>
การชำระเงิน:



<select name="payment" class="w3-select"  OnChange="fncSum();">
<option value="">**Please Select Item**</option>
<?php
$strSQL5 = "select * from tb_payment order by payment_ID";
$objQuery5 = mysqli_query($conn,$strSQL5);
if (!$objQuery5) {
	echo "Failed to fetch to MySQL: " . mysqli_error();
}
while ($objResuut5 = mysqli_fetch_array($objQuery5,MYSQLI_ASSOC)) {
?>
<option class="w3-bar-item w3-button"  value="<?php echo $objResuut5['payment_ID']; ?>"><?php echo $objResuut5['payment_name']; ?>  <?php echo $objResuut5['bank_name']; ?>    <?php echo $objResuut5['branch_bank']; ?> <?php echo $objResuut5['book_name']; ?> </option>
<?php } ?>
</select>
<div class="w3-padding-small"></div>
หมายเหตุ:
<textarea name="sale_remark"  class="w3-input" id="sale_remark"  rows="1"></textarea>
<div class="w3-padding-small"></div>
ชื่อพนักงาน:
<input name="employee_name" type="text" id="employee_name" value="<?php echo $objResult["sale_code"]; ?>" class="w3-input" /> 
	</p>		
			<input type="checkbox" name="buy_ckk" value="1"> &nbsp;ลูกค้าซื้อซ้ำ
</div>

<div class="w3-container w3-twothird "><!-- second half -->
<div class="w3-bar w3-light-grey w3-border">
  <a class="w3-bar-item w3-button"  onclick="openCity('so')"><font color="404040"><b>ใบสั่งขาย</b></font></a>
  <a class="w3-bar-item w3-button"  onclick="openCity('mo')"><font color="404040"><b>เพิ่มเติม</b></font></a>

<div class="dropdown">
<button class="w3-bar-item w3-button" ><font color="404040"><b>ที่อยู่เพิ่มเติม</b></font></button>
<div class="dropdown-content w3-light-grey w3-border">
<a class="w3-bar-item w3-button" onclick="openCity('so1')"><font color="404040"><b>ที่อยู่เพิ่มเติม 2</b></font></a>
<a class="w3-bar-item w3-button" onclick="openCity('so2')"><font color="404040"><b>ที่อยู่เพิ่มเติม 3</b></font></a>
<a class="w3-bar-item w3-button" onclick="openCity('so3')"><font color="404040"><b>ที่อยู่เพิ่มเติม 4</b></font></a>
<a class="w3-bar-item w3-button" onclick="openCity('so4')"><font color="404040"><b>ที่อยู่เพิ่มเติม 5</b></font></a>
<a class="w3-bar-item w3-button" onclick="openCity('so5')"><font color="404040"><b>ที่อยู่เพิ่มเติม 6</b></font></a>
<a class="w3-bar-item w3-button" onclick="openCity('so6')"><font color="404040"><b>ที่อยู่เพิ่มเติม 7</b></font></a>
<a class="w3-bar-item w3-button" onclick="openCity('so7')"><font color="404040"><b>ที่อยู่เพิ่มเติม 8</b></font></a>
<a class="w3-bar-item w3-button" onclick="openCity('so8')"><font color="404040"><b>ที่อยู่เพิ่มเติม 9</b></font></a>
<a class="w3-bar-item w3-button" onclick="openCity('so9')"><font color="404040"><b>ที่อยู่เพิ่มเติม 10</b></font></a>
</div>
</div>
</div>		


<div id="so" class="city" >
<div class="w3-half w3-container"><!-- first so half -->
	<input type="checkbox" name="have_order" value="1"> &nbsp; มีออร์เดอร์ฝาก &nbsp;&nbsp;
<input type="checkbox" name="run_id" value="1"> &nbsp;Run เลขที่เอกสาร IE</p>
	เลขที่เอกสาร <input name="doc_no" value="IV" class="w3-input"  type="text" style="width:90%;">
	</p>
	วันที่ออกเอกสาร <input name="doc_release_date" class="w3-input"  type="date" style="width:90%;">
	</p>
	<input name="doc_time" class="w3-input"  type="hidden">	
<input name="admin_name" class="w3-input"  type="hidden">		
	<div class="w3-half">
ID ลูกค้า
<input type='text' name = "bill_id"  value="<?php echo $objResult6["customer_id"]; ?>" id = "bill_id" style="width:90%;" class="w3-input" placeholder="Search ชื่อลูกค้า..."   OnChange="JavaScript:doCallAjax1('bill_id','billing_name','billing_address','billing_tel','tax_id','customer_no','tel_mem','ex_add','ex_aumper','ex_provin','ex_post','pre_name','customer_name','address1','address2','province','postcode','tel','delivery_contact','delivery_place');" required> 
<input type='hidden' name = "h_bill_id"  id = "h_bill_id"  class="button4" readonly>	
		</div>
	
	<div class="w3-half">
เบอร์โทร
<input type='text' name = "tel_1"  id = "tel_1" style="width:90%;" class="w3-input" placeholder="Search เบอร์โทร..."   OnChange="JavaScript:doCallAjax1('tel_1','billing_name','billing_address','billing_tel','tax_id','customer_no','tel_mem','ex_add','ex_aumper','ex_provin','ex_post','pre_name','customer_name','address1','address2','province','postcode','tel','delivery_contact','delivery_place');"/> 
<input type='hidden' name = "h_tel_1"  id = "h_tel_1"  class="button4" readonly>	
		</div>
	รหัสบัตรสมาชิก
	<input name="customer_no1" id="customer_no1"  type='text' class="w3-input" placeholder="Search รหัสสมาชิก..."   OnChange="JavaScript:doCallAjax1('customer_no1','billing_name','billing_address','billing_tel','tax_id','customer_no','tel_mem','ex_add','ex_aumper','ex_provin','ex_post','pre_name','customer_name','address1','address2','province','postcode','tel','delivery_contact','delivery_place');">
	<input type='hidden' name = "h_customer_no"   id = "h_customer_no"  class="button4" readonly>
<input name="customer_no" id="customer_no"  value="<?php echo $objResult6["customer_no"]; ?>"  type='text' class="w3-input" >
	<input name="ref_rentel" id="ref_rentel" value="<?php echo $objResult["ref_id"]; ?>" class="w3-input"  type="hidden" style="width:90%;">
	
	<input name="tel_mem" id="tel_mem" type='hidden' class="w3-input" readonly>
คำนำหน้าชื่อ:
<input name="pre_name" id="pre_name"  value="<?php echo $objResult6["preface_name"]; ?>" type='text' class="w3-input" >	
	
ชื่อที่ออกบิล:
<input name="add_by" value="<?php echo $_SESSION['name']; ?>&nbsp;<?php echo $_SESSION['surname']; ?>" type='hidden' class="w3-input" >

<input name="billing_name" id="billing_name"  value="<?php echo $objResult6["bill_name"]; ?>"  type='text' class="w3-input" >
	
	
<div class="w3-padding-small"></div>
ทีอยู่ที่ออกบิล:
<textarea name="billing_address" id="billing_address" class="w3-input" rows="1" ><?php echo $objResult6["bill_address"]; ?> <?php echo $objResult6["bill_ampher"]; ?> <?php echo $objResult6["billl_province"]; ?> <?php echo $objResult6["bill_postcode"]; ?></textarea>
	
<div class="w3-bar">
 <input type='hidden' name="ex_add" id="ex_add" class="w3-input" value="<?php echo $objResult6["bill_address"]; ?>" rows="1" >
			</div>
			<div class="w3-bar">
				 <input type='hidden' name="ex_aumper" id="ex_aumper" value="<?php echo $objResult6["bill_ampher"]; ?>" class="w3-input" rows="1" >
			</div>
			<div class="w3-bar">
				<input type='hidden' name="ex_provin" id="ex_provin" value="<?php echo $objResult6["billl_province"]; ?>" class="w3-input" rows="1" >
			</div>
			<div class="w3-bar">
				 <input type='hidden' name="ex_post" id="ex_post" value="<?php echo $objResult6["bill_postcode"]; ?>" class="w3-input" rows="1" >
			</div>	
	
<div class="w3-padding-small"></div>
<div class="w3-half">
Tel.:
<input type="text" name="billing_tel" id="billing_tel" value="<?php echo $objResult6["bill_tel"]; ?>" class="w3-input" >
</div>
<div class="w3-padding-small"></div>
<div class="w3-bar w3-half w3-container">
<input type="checkbox" name="bill_vat" value="1"> &nbsp;บิล VAT
	
<input type="text" name="tax_id" id="tax_id" value="<?php echo $objResult6["tax_id"]; ?>" class="w3-input" >
</div>
	
	</p>
<div class="w3-padding-small"></div>
<div class="w3-bar">

</div>
<div class="w3-padding-small"></div>
การโอนเงิน
<select name="transfer" class="w3-select">
<option value="">**Please Select Item**</option>
<?php
$strSQL3 = "SELECT * FROM tb_transfer ORDER BY tranfer_ID ASC";
$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
while($objResult3 = mysqli_fetch_array($objQuery3))
{

?>
<option value="<?php echo $objResult3["tranfer_name"];?>"><?php echo $objResult3["tranfer_name"];?></option>

<?php
}
?>

</select>
<div class="w3-padding-small"></div>
<div class="w3-bar">
ส่งบัญชีตรวจสอบ
<input type="checkbox" name="account_approve" id="account_approve" value="1" required>
</div>
<div class="w3-padding-small"></div>
<div class="w3-bar">
วันที่โอน
<input type="date" name="transfer_date" id="transfer_date" class="w3-input">
</div>
<div class="w3-padding-small"></div>
<div class="w3-bar">
จำนวนเงินโอน/เก็บปลายทาง
<input type="text" name="amount" class="w3-input">
</div>
</div><!-- close so first half -->

<div class="w3-half w3-container w3-border"><!-- so second half -->
<font color="#FF0000"><b>ใช้สำหรับจ่าหน้าพัสดุเท่านั้น</b></font><br />
ชื่อผู้รับสินค้า
<input name="customer_name" id="customer_name" value="<?php echo $objResult6["customer_name"]; ?>" type="text" class="w3-input">
ที่อยู่ในการจัดส่ง
<input name="address1" id="address1" class="w3-input" value="<?php echo $objResult6["cus_address"]; ?>" type="text">
<input name="address2" id="address2" class="w3-input" value="<?php echo $objResult6["cus_ampher"]; ?>" type="text">
จังหวัด
<select name="province" class="w3-select">
				<option class="w3-bar" value=""></option>
				<?php
					$province="select * from tb_province order by province_name";
					$prosql=mysqli_query($conn,$province);
					while ($fepro=mysqli_fetch_array($prosql)) {
						if($objResult6["cus_province"] == $fepro["province_name"]){
							$sel = "selected";
						} else {
							$sel = "";
						}
				?>
				<option class="w3-bar" value="<?php echo $fepro["province_name"]; ?>"<?php echo $sel;?>><?php echo $fepro["province_name"]; ?></option>
				<?php } ?>
			</select>

รหัสไปรษณีย์
<input name="postcode" id="postcode" type="text"  value="<?php echo $objResult6["cus_postcode"]; ?>" class="w3-input">
โทรศัพท์
<input name="tel" id="tel" type="text" value="<?php echo $objResult6["cus_tel"]; ?>" class="w3-input">
<div class="w3-margin-bottom"></div>
</div><!-- close so second half -->
</div><!-- close so -->

<div id="so1" class="w3-container city" style="display:none">
	<div class="w3-half w3-container"><b>ที่อยู่เพิ่มเติม 2</b><br><br><!-- so1 second half -->
<font color="#FF0000"><b>ใช้สำหรับจ่าหน้าพัสดุเท่านั้น</b></font><br />
ชื่อผู้รับสินค้า
<input name="ex1customer_name" type="text" class="w3-input">
ที่อยู่ในการจัดส่ง
<input name="ex1address1" class="w3-input"  type="text">
<input name="ex1address2" class="w3-input"  type="text">
จังหวัด
<select name="ex1province" class="w3-select">
<option class="w3-bar" value=""></option>
<?php
$province="select * from tb_province order by province_name";
$prosql=mysqli_query($conn,$province);
while ($fepro=mysqli_fetch_array($prosql)) { ?>
<option class="w3-bar" value="<?php echo $fepro["province_name"]; ?>"><?php echo $fepro["province_name"]; ?></option>
<?php } ?>
</select>

รหัสไปรษณีย์
<input name="ex1postcode" type="text"  class="w3-input">
โทรศัพท์
<input name="ex1tel" type="text"  class="w3-input">
<div class="w3-margin-bottom"></div>
</div><!-- close so1 second half -->
</div><!-- close so1  -->

<div id="so2" class="w3-container city" style="display:none">
<div class="w3-half w3-container"><b>ที่อยู่เพิ่มเติม 3</b><br><br><!-- so2 second half -->
<font color="#FF0000"><b>ใช้สำหรับจ่าหน้าพัสดุเท่านั้น</b></font><br />
ชื่อผู้รับสินค้า
<input name="ex2customer_name" type="text" class="w3-input">
ที่อยู่ในการจัดส่ง
<input name="ex2address1" class="w3-input"  type="text">
<input name="ex2address2" class="w3-input"  type="text">
จังหวัด
<select name="ex2province" class="w3-select">
<option class="w3-bar" value=""></option>
<?php
$province="select * from tb_province order by province_name";
$prosql=mysqli_query($conn,$province);
while ($fepro=mysqli_fetch_array($prosql)) { ?>
<option class="w3-bar" value="<?php echo $fepro["province_name"]; ?>"><?php echo $fepro["province_name"]; ?></option>
<?php } ?>
</select>

รหัสไปรษณีย์
<input name="ex2postcode" type="text"  class="w3-input">
โทรศัพท์
<input name="ex2tel" type="text"  class="w3-input">
<div class="w3-margin-bottom"></div>
</div><!-- close so2 second half -->
</div><!-- close so2  -->

<div id="so3" class="w3-container city" style="display:none">
<div class="w3-half w3-container"><b>ที่อยู่เพิ่มเติม 4</b><br><br><!-- so3 second half -->
<font color="#FF0000"><b>ใช้สำหรับจ่าหน้าพัสดุเท่านั้น</b></font><br />
ชื่อผู้รับสินค้า
<input name="ex3customer_name" type="text" class="w3-input">
ที่อยู่ในการจัดส่ง
<input name="ex3address1" class="w3-input"  type="text">
<input name="ex3address2" class="w3-input"  type="text">
จังหวัด
<select name="ex3province" class="w3-select">
<option class="w3-bar" value=""></option>
<?php
$province="select * from tb_province order by province_name";
$prosql=mysqli_query($conn,$province);
while ($fepro=mysqli_fetch_array($prosql)) { ?>
<option class="w3-bar" value="<?php echo $fepro["province_name"]; ?>"><?php echo $fepro["province_name"]; ?></option>
<?php } ?>
</select>

รหัสไปรษณีย์
<input name="ex3postcode" type="text"  class="w3-input">
โทรศัพท์
<input name="ex3tel" type="text"  class="w3-input">
<div class="w3-margin-bottom"></div>
</div><!-- close so3 second half -->
</div><!-- close so3  -->

<div id="so4" class="w3-container city" style="display:none">
<div class="w3-half w3-container"><b>ที่อยู่เพิ่มเติม 5</b><br><br><!-- so4 second half -->
<font color="#FF0000"><b>ใช้สำหรับจ่าหน้าพัสดุเท่านั้น</b></font><br />
ชื่อผู้รับสินค้า
<input name="ex4customer_name" type="text" class="w3-input">
ที่อยู่ในการจัดส่ง
<input name="ex4address1" class="w3-input"  type="text">
<input name="ex4address2" class="w3-input"  type="text">
จังหวัด
<select name="ex4province" class="w3-select">
<option class="w3-bar" value=""></option>
<?php
$province="select * from tb_province order by province_name";
$prosql=mysqli_query($conn,$province);
while ($fepro=mysqli_fetch_array($prosql)) { ?>
<option class="w3-bar" value="<?php echo $fepro["province_name"]; ?>"><?php echo $fepro["province_name"]; ?></option>
<?php } ?>
</select>

รหัสไปรษณีย์
<input name="ex4postcode" type="text"  class="w3-input">
โทรศัพท์
<input name="ex4tel" type="text"  class="w3-input">
<div class="w3-margin-bottom"></div>
</div><!-- close so4 second half -->
</div><!-- close so4  -->

<div id="so5" class="w3-container city" style="display:none">
<div class="w3-half w3-container"><b>ที่อยู่เพิ่มเติม 6</b><br><br><!-- so5 second half -->
<font color="#FF0000"><b>ใช้สำหรับจ่าหน้าพัสดุเท่านั้น</b></font><br />
ชื่อผู้รับสินค้า
<input name="ex5customer_name" type="text" class="w3-input">
ที่อยู่ในการจัดส่ง
<input name="ex5address1" class="w3-input"  type="text">
<input name="ex5address2" class="w3-input"  type="text">
จังหวัด
<select name="ex5province" class="w3-select">
<option class="w3-bar" value=""></option>
<?php
$province="select * from tb_province order by province_name";
$prosql=mysqli_query($conn,$province);
while ($fepro=mysqli_fetch_array($prosql)) { ?>
<option class="w3-bar" value="<?php echo $fepro["province_name"]; ?>"><?php echo $fepro["province_name"]; ?></option>
<?php } ?>
</select>

รหัสไปรษณีย์
<input name="ex5postcode" type="text"  class="w3-input">
โทรศัพท์
<input name="ex5tel" type="text"  class="w3-input">
<div class="w3-margin-bottom"></div>
</div><!-- close so5 second half -->
</div><!-- close so5  -->

<div id="so6" class="w3-container city" style="display:none">
<div class="w3-half w3-container"><b>ที่อยู่เพิ่มเติม 7</b><br><br><!-- so6 second half -->
<font color="#FF0000"><b>ใช้สำหรับจ่าหน้าพัสดุเท่านั้น</b></font><br />
ชื่อผู้รับสินค้า
<input name="ex6customer_name" type="text" class="w3-input">
ที่อยู่ในการจัดส่ง
<input name="ex6address1" class="w3-input"  type="text">
<input name="ex6address2" class="w3-input"  type="text">
จังหวัด
<select name="ex6province" class="w3-select">
<option class="w3-bar" value=""></option>
<?php
$province="select * from tb_province order by province_name";
$prosql=mysqli_query($conn,$province);
while ($fepro=mysqli_fetch_array($prosql)) { ?>
<option class="w3-bar" value="<?php echo $fepro["province_name"]; ?>"><?php echo $fepro["province_name"]; ?></option>
<?php } ?>
</select>

รหัสไปรษณีย์
<input name="ex6postcode" type="text"  class="w3-input">
โทรศัพท์
<input name="ex6tel" type="text"  class="w3-input">
<div class="w3-margin-bottom"></div>
</div><!-- close so6 second half -->
</div><!-- close so6  -->

<div id="so7" class="w3-container city" style="display:none">
<div class="w3-half w3-container"><b>ที่อยู่เพิ่มเติม 8</b><br><br><!-- so7 second half -->
<font color="#FF0000"><b>ใช้สำหรับจ่าหน้าพัสดุเท่านั้น</b></font><br />
ชื่อผู้รับสินค้า
<input name="ex7customer_name" type="text" class="w3-input">
ที่อยู่ในการจัดส่ง
<input name="ex7address1" class="w3-input"  type="text">
<input name="ex7address2" class="w3-input"  type="text">
จังหวัด
<select name="ex7province" class="w3-select">
<option class="w3-bar" value=""></option>
<?php
$province="select * from tb_province order by province_name";
$prosql=mysqli_query($conn,$province);
while ($fepro=mysqli_fetch_array($prosql)) { ?>
<option class="w3-bar" value="<?php echo $fepro["province_name"]; ?>"><?php echo $fepro["province_name"]; ?></option>
<?php } ?>
</select>

รหัสไปรษณีย์
<input name="ex7postcode" type="text"  class="w3-input">
โทรศัพท์
<input name="ex7tel" type="text"  class="w3-input">
<div class="w3-margin-bottom"></div>
</div><!-- close so7 second half -->
</div><!-- close so7  -->

<div id="so8" class="w3-container city" style="display:none">
<div class="w3-half w3-container"><b>ที่อยู่เพิ่มเติม 9</b><br><br><!-- so8 second half -->
<font color="#FF0000"><b>ใช้สำหรับจ่าหน้าพัสดุเท่านั้น</b></font><br />
ชื่อผู้รับสินค้า
<input name="ex8customer_name" type="text" class="w3-input">
ที่อยู่ในการจัดส่ง
<input name="ex8address1" class="w3-input"  type="text">
<input name="ex8address2" class="w3-input"  type="text">
จังหวัด
<select name="ex8province" class="w3-select">
<option class="w3-bar" value=""></option>
<?php
$province="select * from tb_province order by province_name";
$prosql=mysqli_query($conn,$province);
while ($fepro=mysqli_fetch_array($prosql)) { ?>
<option class="w3-bar" value="<?php echo $fepro["province_name"]; ?>"><?php echo $fepro["province_name"]; ?></option>
<?php } ?>
</select>

รหัสไปรษณีย์
<input name="ex8postcode" type="text"  class="w3-input">
โทรศัพท์
<input name="ex8tel" type="text"  class="w3-input">
<div class="w3-margin-bottom"></div>
</div><!-- close so8 second half -->
</div><!-- close so8  -->

<div id="so9" class="w3-container city" style="display:none">
<div class="w3-half w3-container"><b>ที่อยู่เพิ่มเติม 10</b><br><br><!-- so9 second half -->
<font color="#FF0000"><b>ใช้สำหรับจ่าหน้าพัสดุเท่านั้น</b></font><br />
ชื่อผู้รับสินค้า
<input name="ex9customer_name" type="text" class="w3-input">
ที่อยู่ในการจัดส่ง
<input name="ex9address1" class="w3-input"  type="text">
<input name="ex9address2" class="w3-input"  type="text">
จังหวัด
<select name="ex9province" class="w3-select">
<option class="w3-bar" value=""></option>
<?php
$province="select * from tb_province order by province_name";
$prosql=mysqli_query($conn,$province);
while ($fepro=mysqli_fetch_array($prosql)) { ?>
<option class="w3-bar" value="<?php echo $fepro["province_name"]; ?>"><?php echo $fepro["province_name"]; ?></option>
<?php } ?>
</select>

รหัสไปรษณีย์
<input name="ex9postcode" type="text"  class="w3-input">
โทรศัพท์
<input name="ex9tel" type="text"  class="w3-input">
<div class="w3-margin-bottom"></div>
</div><!-- close so9 second half -->
</div><!-- close so9  -->

	
<div class="w3-padding-small"></div>



<div id="mo" class="w3-container city" style="display:none">
<div class="w3-third"><!--first third -->
ชื่อผู้แนะนำ
<input name="prefer_name" value ="German Bed" class="w3-input">
<div class="w3-padding-small"></div>
ใบสั่งซื้อเลขที่
<input name="po_no" class="w3-input" >
<div class="w3-padding-small"></div>
กำหนดส่งตามสัญญา:
<input name="delivery_contract" class="w3-input" >
<div class="w3-padding-small"></div>
<input type="checkbox" name="clear_book_ckk" value="1">&nbsp; เคลียร์ใบจอง:
<input name="clear_book_no" class="w3-input" placeholder="เลขที่" >
<div class="w3-padding-small"></div>
<input type="checkbox" name="clear_brn_no_ckk" value="1">&nbsp;เคลียร์ใบยืม BRN:
<input name="clear_brn_no" class="w3-input" placeholder="เลขที่" >
<div class="w3-padding-small"></div>
<input type="checkbox" name="clear_brnp_no_ckk" value="1">&nbsp;เคลียร์ใบยืม BRNP:
<input name="clear_brnp_no" class="w3-input" placeholder="เลขที่" >
<div class="w3-padding-small"></div>
</div><!--first third -->
<div class="w3-container w3-third"><!--second third -->
<input type="checkbox" name="sn_ckk" value="1">&nbsp;ต้องการ SN:
<input name="sn" class="w3-input" >
<div class="w3-padding-small"></div>
<input type="checkbox" name="bq_ckk" value="1">&nbsp;BQ เลขที่:
<input name="bq" class="w3-input" >
<div class="w3-padding-small"></div>
<input type="checkbox" name="ot_ckk" value="1">&nbsp;OT เลขที่:
<input name="ot" class="w3-input" >
<div class="w3-padding-small"></div>
เลขที่อ้างอิงสลิป:
<input name="slip_no" id="slip_no"  class="w3-input" >



</div><!--second third -->
<div class="w3-third"><!--third third -->
สถานที่ติดตั้งเครื่อง
<input name="install_place" class="w3-input" >
<div class="w3-padding-small"></div>
ใบเสนอราคา
เลขที่
<input name="pr_no" class="w3-input" >
<div class="w3-padding-small"></div>
<input type="radio" name="type_type" checked="checked" value="1" onclick="javascript:ckk_1();" id="object6"> พิมพ์ตามคอม
<br />
<input type="radio" name="type_type" value="2" onclick="javascript:ckk_1();" id="object7"> พิมพ์ตามใบสั่งซื้อ
<br />
<input type="radio" name="type_type" value="3" onclick="javascript:ckk_1();" id="object5"> พิมพ์ตามที่เขียน
<br />
<div id="dt5" style="display:none">

ระบุ:
<textarea name="type_type_detail" class="w3-input" style="resize: none;width:100%"></textarea>
</div>

แนบไฟล์ </p>
<input name="upload1"  type="file"></p>
<input name="upload2"  type="file"></p>
<input name="upload3"  type="file"></p>
<input name="upload4"  type="file"></p>
<input name="upload5"  type="file"></p>


</div><!--third third -->
</div><!-- close more -->
</div><!-- close second half -->
<div class="w3-bar w3-light-grey w3-border">
 <a class="w3-bar-item w3-button" onclick="openCity1('pd')"><font color="#404040"><b>รายการสินค้า</b></font></a>
  <a class="w3-bar-item w3-button" onclick="openCity1('cs')"><font color="#404040"><b>รายละเอียดการจัดส่ง</b></font></a>	
	<!--a href="status_kangbr1.php" class="w3-button w3-grey w3-right" target="_blank" ><font color="red">ค้นหาเลขที่ใบยืม</font></a-->
</div>


<div id="pd" class="w3-container city1">
<?php if($objResult["type_doc"]=='3'){ ?>	
<?php include ('register_allwell_detail.php')?>
<?php }else if($objResult["type_doc"]=='4'){ ?>
<?php include ('register_allwell_detailnb.php')?>

	<?php } ?>
</div> 

<div id="cs" class="w3-container city1" style="display:none">
<?php if($objResult["delivery_type"]=='1') { ?>
<input type="radio" name="delivery_type" value="1" checked='checked' >&nbsp;Sale รับเอง
<input type="radio" name="delivery_type" value="2"  >&nbsp;ช่างรับเอง<br />
<input type="radio" name="delivery_type" value="3"  >&nbsp;ลูกค้ารับเอง 
<input type="radio" name="delivery_type" value="4"  >&nbsp;บริษัทจัดส่ง <br />

</p>

<?php }else if ($objResult["delivery_type"]=='2') { ?>

<input type="radio" name="delivery_type" value="1"  >&nbsp;Sale รับเอง
<input type="radio" name="delivery_type" value="2" checked='checked' >&nbsp;ช่างรับเอง<br />
<input type="radio" name="delivery_type" value="3"  >&nbsp;ลูกค้ารับเอง 
<input type="radio" name="delivery_type" value="4"  >&nbsp;บริษัทจัดส่ง <br />

<?php }else if ($objResult["delivery_type"]=='3') { ?>

<input type="radio" name="delivery_type" value="1"  >&nbsp;Sale รับเอง
<input type="radio" name="delivery_type" value="2"  >&nbsp;ช่างรับเอง<br />
<input type="radio" name="delivery_type" value="3" checked='checked' >&nbsp;ลูกค้ารับเอง 
<input type="radio" name="delivery_type" value="4"  >&nbsp;บริษัทจัดส่ง <br />


<?php }else if ($objResult["delivery_type"]=='4') { ?>

<input type="radio" name="delivery_type" value="1"  >&nbsp;Sale รับเอง
<input type="radio" name="delivery_type" value="2"  >&nbsp;ช่างรับเอง<br />
<input type="radio" name="delivery_type" value="3"  >&nbsp;ลูกค้ารับเอง 
<input type="radio" name="delivery_type" value="4" checked='checked' >&nbsp;บริษัทจัดส่ง <br />

<?php }else{ ?>

<input type="radio" name="delivery_type" value="1"  >&nbsp;Sale รับเอง
<input type="radio" name="delivery_type" value="2"  >&nbsp;ช่างรับเอง<br />
<input type="radio" name="delivery_type" value="3"  >&nbsp;ลูกค้ารับเอง 
<input type="radio" name="delivery_type" value="4" >&nbsp;บริษัทจัดส่ง <br />
	<?php } ?>

	<?php
		$sql2 = "select * from tb_register_data where ref_id = '".$objResult["ref_id"]."'";
		$query2 = mysqli_query($conn,$sql2);
		$fetch2 = mysqli_fetch_array($query2,MYSQLI_ASSOC); 
	?>
</p>

<div class="w3-quarter w3-container"><!-- first quarter -->


วันที่ส่ง
<input type="date" name="delivery_date" value ="<?php echo $objResult["delivery_date"]; ?>" class="w3-input">
เวลาส่ง
<input type="text" name="delivery_time" value="ก่อน 15.00 น." class="w3-input">
การส่งสินค้า<br>
	<?php if($fetch2["big_car"]=='1'){ ?>
<input type="checkbox" name="big_car" checked='checked' value="1">&nbsp;ต้องการรถใหญ่<br />
	<?php }else{ ?>
	<input type="checkbox" name="big_car" value="1">&nbsp;ต้องการรถใหญ่<br />
	<?php } ?>
	<?php if($fetch2["call_before"]=='1'){ ?>
<input type="checkbox" name="call_before" checked='checked' value="1">&nbsp;โทรแจ้งลูกค้าก่อนไป<br />
	<?php }else{ ?>
<input type="checkbox" name="call_before" value="1">&nbsp;โทรแจ้งลูกค้าก่อนไป<br />	
	<?php } ?>
	<?php if($fetch2["maps"]=='1'){ ?>
<input type="checkbox" name="maps"  checked='checked'  value="1">&nbsp;มีแผนที่ประกอบ</p>
<?php }else{ ?>
<input type="checkbox" name="maps" value="1">&nbsp;มีแผนที่ประกอบ</p>
<?php } ?>


  <input name="upload_map"  type="file"></p>

<?php if($fetch2["fix_date"]=='1'){ ?>

<input type="checkbox"  name="fix_datetime" checked='checked' id = "fix_datetime" value="1">&nbsp;นัดวันและเวลาเรียบร้อยแล้ว <br />
<?php }else{ ?>

<input type="checkbox"  name="fix_datetime" id = "fix_datetime" value="1">&nbsp;นัดวันและเวลาเรียบร้อยแล้ว <br />

	<?php } ?>

</div><!-- first quarter -->
<div class="w3-quarter w3-container"><!-- second quarter -->

สถานที่ส่งสินค้า:
<textarea name="delivery_place" id="delivery_place" class="w3-input" rows="1" style="width:100%;resize: none" > <?php echo $objResult6["del_address"]; ?> <?php echo $objResult6["del_ampher"]; ?> <?php echo $objResult6["del_province"]; ?> <?php echo $objResult6["del_postcode"]; ?></textarea>
ชื่อผู้ติดต่อ/TEL.:
<input type="text" name="delivery_contact" id="delivery_contact" value ="<?php echo $objResult6["contact_name"]; ?>" class="w3-input" >
</div><!-- second quarter -->
<div class="w3-quarter w3-container"><!-- third quarter -->
<input type="checkbox" name="return" value="1">&nbsp;รับคืนสินค้า<br>
วันที่รับคืน
<input type="date" name="return_date" class="w3-input" >
เวลา
<input type="text" name="return_time"  class="w3-input" >
ที่อยู่รับคืนสินค้า:
<input type="text" name="return_address" class="w3-input" >
ชื่อผู้ติดต่อ/TEL.:
<input type="text" name="return_contact" class="w3-input" >

<div class="w3-quarter w3-container">

<div id="dt1" style="display:none">
					
<input type="checkbox"  checked="checked" value="1">&nbsp;

<a href="report_loanptl.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey"><font color="Blue">ใบยืม AWL</font></a>&nbsp;&nbsp;
</div>

<div id="dt2" style="display:none">
<input type="checkbox" name="select_br_nbm" checked="checked" value="1">&nbsp;
					

<a  href="report_loannbm.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey"><font color="DeepPink"> ใบยืม NBM</font></a>&nbsp;

</div>

<div id="dt3" style="display:none">

<input type="checkbox" name="select_so_ptl" checked="checked" value="1">&nbsp;
		
<a href="report_saleptl.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey"><font color="Blue">ใบสั่งขาย AWL</font></a><br />

</div>
		
	<div id="dt4" style="display:none">

		
<input type="checkbox" name="select_so_nbm" checked="checked" value="1">&nbsp;
				

<a href="report_salenbm.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey"><font color="DeepPink">ใบสั่งขาย NBM</font></a>
</div></div><!-- forth quarter -->
</div>



	
	



<div class="w3-container w3-third">
<input type="checkbox" name="send_cs" value="1">&nbsp;ส่งข้อมูลไประบบลงงาน 
	</div>
<div class="w3-container w3-third"> 
	<?php if($fetch2["mk_research"]=='1'){ ?>
<input type="checkbox" name="mk_research" checked='checked' value="1">&nbsp; <span class="style34"><u>cs ทำแบบสอบถาม </u></span> 
	<?php }else{ ?>
<input type="checkbox" name="mk_research" value="1">&nbsp; <span class="style34"><u>cs ทำแบบสอบถาม </u></span> 
	
	<?php } ?>
	</div>
	<div class="w3-container w3-third">
.
	</div>
	<div class="w3-container w3-third">
 วันที่ รับ-ส่ง :
      <input name="start_date" type='date' id="start_date" value="<?php echo $fetch2["start_date"] ?>"  class="w3-input"  />

	</div><div class="w3-container w3-third">

วันที่ต้องการโดยประมาณ :
	  <input name="between_date"  class="w3-input"  type='text'  value="<?php echo $fetch2["between_date"] ?>" id="between_date"  />
 </div><div class="w3-container w3-third">

 เวลา :
<input id="start_time"  name="start_time"  class="w3-input" value="<?php echo $fetch2["start_time"] ?>" type="text" />
ถึง
<input id="end_time" name="end_time"   class="w3-input" value="<?php echo $fetch2["end_time"] ?>" type="text" />

</div><div class="w3-container w3-third">


สถานะการทำงาน : 


<input type='radio'  name='status' id = 'status' value='ส่ง' />ส่ง
&nbsp; <input type='radio'  name='status' id = 'status' value='รับ' />รับ



</div><div class="w3-container w3-third">

สถานะ :
      <input name="status_comment" type='text' id="status_comment" value="<?php echo $fetch2["status_comment"]; ?>" size="20" class="w3-input"/>
</div><div class="w3-container w3-third">

<?php if($fetch2["fix_datetime"]=='1'){ ?>
<input type="checkbox" checked='checked' name="fix_datetime" id = "fix_datetime"  value="1">นัดวันและเวลาเรียบร้อยแล้ว 
	<?php }else{ ?>
<input type="checkbox"  name="fix_datetime" id = "fix_datetime"  value="1">นัดวันและเวลาเรียบร้อยแล้ว 
	<?php } ?>

<?php if($fetch2["no_money"]=='1'){ ?>
<input type="checkbox"  checked='checked' id = "no_money" name="no_money" value="1">ไม่ต้องเก็บเงิน
<?php }else{ ?>
<input type="checkbox"  id = "no_money" name="no_money" value="1">ไม่ต้องเก็บเงิน
	<?php } ?>

</div><div class="w3-container w3-third">
<?php if($fetch2["call_customer"]=='1'){ ?>
<input type="checkbox"  checked='checked' id = "call_customer" name="call_customer" value="1">โทรแจ้งลูกค้าก่อนไป
	<?php }else{ ?>
<input type="checkbox"  id = "call_customer" name="call_customer" value="1">โทรแจ้งลูกค้าก่อนไป	
	<?php } ?>
	<?php if($fetch2["call_back"]=='1'){ ?>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox"  checked='checked' id = "call_back" name="call_back" value="1">ต้องการให้โทรกลับเมื่อส่งสินค้าเสร็จแล้ว
<?php }else{ ?>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox"  id = "call_back" name="call_back" value="1">ต้องการให้โทรกลับเมื่อส่งสินค้าเสร็จแล้ว
	<?php } ?>

</div><div class="w3-container w3-third">
<?php if($fetch2["want_bus"]=='1'){ ?>
	<input type="checkbox"   name="want_bus"  checked='checked' value="1">ต้องการรถใหญ่
<?php }else{ ?>
		<input type="checkbox"   name="want_bus" value="1">ต้องการรถใหญ่
	<?php } ?>

		</div><div class="w3-container w3-third">
	 <?php if($fetch2["cash"]=='1'){ ?>
	<input type="checkbox"  name="cash" id = "cash"  value="1">เก็บเงินสด
<?php }else{ ?>
	<input type="checkbox"  name="cash" id = "cash"  value="1">เก็บเงินสด		
				<?php } ?>


		 <input name="unit_cash" type='text' class="w3-input" id="unit_cash" value="<?php echo $fetch2["unit_cash"]; ?>" size="20" rows="1" style="color:black;text-align:right" OnChange="JavaScript:chkNum(this)">  
		 </div><div class="w3-container w3-third">

<?php if($fetch2["check_paper"]=='1'){ ?>
	<input type="checkbox"  name="check_paper" checked='checked'  id = "check_paper" value="1">รับเช็ค
<?php }else{ ?>
	<input type="checkbox"  name="check_paper" id = "check_paper" value="1">รับเช็ค			 
			 <?php } ?>
		
	<input name="unit_check" type='text' class="w3-input" value="<?php echo $fetch2["unit_check"]; ?>" id="unit_check" style="color:black;text-align:right" size="20" OnChange="JavaScript:chkNum(this)"/>
		</div><div class="w3-container w3-third">

<?php if($fetch2["credit_card"]=='1'){ ?>
<input type="checkbox" checked='checked' id = "credit_card" name="credit_card" value="1">รูดการ์ด 
<?php }else{ ?>
<input type="checkbox"  id = "credit_card" name="credit_card" value="1">รูดการ์ด 			
			<?php } ?>


	<input name="unit_credit" type='text' class="w3-input"  id="unit_credit" value="<?php echo $fetch2["unit_credit"]; ?>" size="20" style="color:black;text-align:right"  OnChange="JavaScript:chkNum(this)"/> 
	</div><div class="w3-container w3-third">

<?php if($fetch2["bill"]=='1'){ ?>
<input type="checkbox"  checked='checked' id = "bill" name="bill" value="1">วางบิล
<?php }else{ ?>
<input type="checkbox"  id = "bill" name="bill" value="1">วางบิล	
			<?php } ?>

	
<input name="unit_bill" type='text' class="w3-input" style="color:black;text-align:right" value="<?php echo $fetch2["unit_bill"]; ?>" id="unit_bill"  size="20" OnChange="JavaScript:chkNum(this)" />
</div><div class="w3-container w3-third">

<?php if($fetch2["tran"]=='1'){ ?>
<input type="checkbox"  checked='checked' name="tran"id = "tran"  value="1">ลูกค้าโอนเงินหน้างาน
<?php }else{ ?>
<input type="checkbox"  name="tran"id = "tran"  value="1">ลูกค้าโอนเงินหน้างาน
			<?php } ?>

	
		 <input name="unit_tran" type='text' class="w3-input" id="unit_tran"  value="<?php echo $fetch2["unit_tran"]; ?>" size="20"  style="color:black;text-align:right" rows="1"OnChange="JavaScript:chkNum(this)"> 
</div><div class="w3-container w3-third">



<?php if($fetch2["dep"]=='1'){ ?>
<input type="checkbox" checked='checked' id = "dep" name="dep" value="1">อื่นๆ
<?php }else{ ?>
<input type="checkbox"  id = "dep" name="dep" value="1">อื่นๆ
			<?php } ?>

	

<input name="dept" type='text' class="w3-input"  id="dept"  value="<?php echo $fetch2["dept"]; ?>"  size="20"  />
</div><div class="w3-container w3-third">

แผนก - ฝ่าย :

<input name="department_show"  class="w3-input" value="ฝ่ายขาย" type='text' value="<?php echo $fetch2["department_show"]; ?>" id="department_show" >


</div><div class="w3-container w3-third">
       ประเภทลูกค้า :

<input name="customer_typename"  class="w3-input" value="ลูกค้าทั่วไป" type='text' value="<?php echo $fetch2["customer_typename"]; ?>" id="customer_typename" >

</div><div class="w3-container w3-third">
       หน่วยงาน :
<input name="company_name"  class="w3-input"  type='text' value="<?php echo $fetch2["company_name"]; ?>" id="company_name" >
	 



</div><div class="w3-container w3-third">
       ประเภทงาน :
<input name="department_name"  class="w3-input" value="Online"  type='text' id="department_name" >	 

</div><div class="w3-container w3-third">
ชื่อผู้ติดต่อ  :
<input name="customer_name1"  class="w3-input" type='text' value="<?php echo $fetch2["customer_name"]; ?>" id="customer_name1">

</div><div class="w3-container w3-third">
 ผู้รับสินค้า :
<input name="customer_contact"  class="w3-input" type='text'  value="<?php echo $fetch2["customer_contact"]; ?>" id="customer_contact">

</div><div class="w3-container w3-third">

 เบอร์โทรลูกค้า :
<input name="customer_tel"  class="w3-input" type='text' value="<?php echo $fetch2["customer_tel"]; ?>" id="customer_tel">

</div><div class="w3-container w3-third">
จังหวัด :
<input name="province_name"  class="w3-input" type='text' value="<?php echo $fetch2["province_name"]; ?>" id="province_name">

 </div><div class="w3-container w3-third">
ชื่อโรงพยาบาล :
<input type='text'  class="w3-input" value="<?php echo $fetch2["address_name"]; ?>" name="address_name" >             


 </div>
<div class="w3-container w3-third">	

  ที่อยู่ :
<textarea   class="w3-input" name="address_send" cols="54" rows="1"><?php echo $fetch2["address_send"]; ?></textarea>

</div>
<div class="w3-container w3-third">
เลขที่เอกสาร/เลขที่เครื่อง : 
<textarea name="product_sn"  class="w3-input" id="product_sn" cols="54" rows="1"><?php echo $fetch2["product_sn"]; ?></textarea>

</div>
<div class="w3-container w3-third">
สินค้า/เอกสาร :  
<textarea name="product"  class="w3-input" id="product" cols="54" rows="1"></textarea>

</div>

<div class="w3-container w3-third">
รายละเอียดเพิ่มเติม : 
     <textarea name="description"  class="w3-input" id="description" cols="54" rows="1"><?php echo $fetch2["description"]; ?></textarea>
</div>


	<?php
	$sql3 = "select * from tb_transaction where ref_id = '".$objResult["ref_id"]."'";
				$query3 = mysqli_query($conn,$sql3);
				$fetch3 = mysqli_fetch_array($query3,MYSQLI_ASSOC); 
if ($fetch2["check_detail"]=='0' or $fetch2["check_detail"]==''){
		?>
	<fieldset><legend><input type="checkbox" name="more" id="more" value="1"> <b>รายละเอียดการจัดส่ง</b></legend>
	<div id="more-2" style="display:none;">
		<div class="w3-container w3-third 112">
			<div class="w3-bar 1">

						<input type="checkbox" name="runway"id = "runway" value="1"> ติดถนนรันเวย์
			</div>
			<div class="w3-container w3-bar 2">
					<input type="checkbox" name="road"id = "road" value="1"> ติดถนนวิ่งสวนกัน

			</div>
			<div class="w3-container w3-bar 3">
				<input type="checkbox" name="soy"id = "soy" value="1"> เข้าซอย

			</div>
			<div class="w3-container w3-bar 4">
				ทางเข้ากว้าง
				<input name="soy_big" class="w3-input"  type='text' id="soy_big" style="color:black;text-align:left;width:90%;" placeholder="(เมตร)" />
			</div>
			<div class="w3-container w3-bar 5">
			 		<input type="checkbox" name="height_ltd" id = "height_ltd" value="1"> มีตัวจำกัดความสูง

			</div>
			<div class="w3-container w3-bar 6">
				<input type="checkbox" name="car_load"id = "car_load" value="1"> รถยนต์สามารถเข้าได้
			</div>
			<div class="w3-container w3-bar 7">
				<input type="checkbox" name="no_car_road"id = "no_car_road" value="1"> รถยนต์เข้าไม่ได้ สามารถจอดได้ที่ <input name="car_park" class="w3-input" type='text' id="car_park" style="width:90%;" />
			</div>
			<div class="w3-container w3-bar 8">
				การจอดรถ
			</div>
			<div class="w3-container w3-bar 9">
				<input type="checkbox" name="car_road" id = "car_road" value="1"> จอดรถข้างถนน
			</div>
			<div class="w3-container w3-bar 10">
				<input type="checkbox" name="car_home"id = "car_home" value="1"> จอดรถหน้าบ้านได้
			</div>
			<div class="w3-container w3-bar 11">
				ประตูหน้าบ้านสูง
				<input name="door_long" class="w3-input" type='text' id="door_long" style="color:black;text-align:left;width:90%;" placeholder="(เมตร)" />
			</div>
			<div class="w3-container w3-bar 12">
				<input type="checkbox" name="slope"id = "slope" value="1"> มีทางราบก่อนประตูบ้าน
			</div>
			<div class="w3-container w3-bar 13">
				<input type="checkbox" name="bundai"id = "bundai" value="1"> มีบันไดก่อนประตูบ้าน
			</div>
			<div class="w3-container w3-bar 14">
				<input name="unit_bundai" class="w3-input" type='text' id="unit_bundai" style="width:90%;" placeholder="จำนวน (ขั้น)" />
			</div>
			<div class="w3-container w3-bar 15">
				ประตูบ้านกว้าง
				<input name="door_bigger" class="w3-input" type='text' id="door_bigger" style="width:90%;" placeholder="(เมตร)" />
			</div>
			<div class="w3-container w3-bar 16">
				ประตูสูง 
				<input name="door_longer" class="w3-input" type='text' id="door_longer" style="width:90%;" placeholder="(เมตร)" />
			</div>
			<div class="w3-container w3-bar 17">
				ประตูห้องกว้าง 
				<input name="room_bigger" class="w3-input" type='text' id="room_bigger" style="width:90%;" placeholder="(เมตร)" />
			</div>
			<div class="w3-container w3-bar 18">
				ประตูห้องสูง 
				<input name="room_longer" class="w3-input" type='text' id="room_longer" style="width:90%;" placeholder="(เมตร)" />
			</div>
		</div>
		<div class="w3-container w3-third 212">
			<div class="w3-bar 1">
				ประตูบ้านเป็นแบบ
				<input name="type_door" class="w3-input" type='text' id="type_door" style="width:90%;" />
			</div>
			<div class="w3-container w3-bar 2">
				พื้นบ้านเป็นแบบ
				<input name="home_type" class="w3-input" type='text' id="home_type" style="width:90%;" />
			</div>
			<div class="w3-container w3-bar 3">
				ติดตั้งที่ชั้น
				<input name="install" class="w3-input" type='text' id="install" style="width:90%;" />
			</div>
			<div class="w3-container w3-bar 4">
				<input type="checkbox" name="bundai_install"id ="bundai_install" value="1"> บันไดกว้าง
			</div>
			<div class="w3-container w3-bar 5">
				<input name="bundai_big" class="w3-input" type='text' id="bundai_big" style="width:90%;" placeholder="เมตร" />
			</div>
			<div class="w3-container w3-bar 6">
				หักมุมบันได
				<input name="bundai_hug" class="w3-input" type='text' id="bundai_hug" style="width:90%;" />
			</div>
			<div class="w3-container w3-bar 7">
				ชนิดของบันได
				<input name="type_bundai" class="w3-input" type='text' id="type_bundai" style="width:90%;" />
			</div>
			<div class="w3-container w3-bar 8">
				<input type="checkbox" name="lip"id = "lip" value="1"> ลิฟท์กว้าง
			</div>
			<div class="w3-container w3-bar 9">
				<input name="lip_big" class="w3-input" type='text' id="lip_big" style="width:90%;" placeholder="เมตร" />
			</div>
			<div class="w3-container w3-bar 10">
				สูง
				<input name="lip_long" class="w3-input" type='text' id="lip_long" style="width:90%;" placeholder="เมตร" />
			</div>
			<div class="w3-container w3-bar 11">
				รับน้ำหนักได้ 
				<input name="lip_weight" class="w3-input" type='text' id="lip_weight" style="width:90%;" />
			</div>
			
		</div>
		<div class="w3-container w3-third 312">
			<div class="w3-container w3-bar 12">
				<input type="checkbox" name="up"id ="up" value="1"> ขึ้นลิฟท์ได้
			</div>
			<div class="w3-container w3-bar 13">
				<input type="checkbox" name="no_up"id ="no_up" value="1"> ขึ้นลิฟท์ไม่ได้
			</div>
			<div class="w3-container w3-bar 14">
				<input type="checkbox" name="head_bad"id ="head_bad" value="1"> ต้องถอดหัวเตียง-ท้ายเตียง
			</div>
			<div class="w3-container w3-bar 15">
				<input type="checkbox" name="want_employee"id ="want_employee" value="1"> ต้องการเจ้าหน้าที่ย้ายเฟอร์นิเจอร์
			</div>
			<div class="w3-container w3-bar 16">
				จำนวนคนที่ใช้ 
				<input name="employee_unit" class="w3-input" type='text' id="employee_unit" style="width:90%;" />
			</div>
			<div class="w3-container w3-bar 17">
				ย้ายเฟอร์นิเจอร์ 
				<input name="ferniger_name" class="w3-input" type='text' id="ferniger_name" style="width:90%;" />
			</div>
			<div class="w3-container w3-bar 18">
				ย้ายไปที่ 
				<input name="ferniger_address" class="w3-input" type='text' id="ferniger_address" style="width:90%;" />
			</div>
			<div class="w3-container w3-bar">
				<input type="checkbox" name="want_ex"id = "want_ex" value="1"> ต้องเตรียมอุปกรณ์ไปถอดประกอบ
			</div>
			<div class="w3-container w3-bar">
				<input type="checkbox" name="want_credit"id = "want_credit" value="1"> ต้องเตรียมเครื่องรูดบัตร
			</div>
			<div class="w3-container w3-bar">
				ธนาคาร 
				<input name="bank" class="w3-input" type='text' id="bank" style="width:90%;" />
			</div>
			<div class="w3-container w3-bar">
				<input type="checkbox" name="want_prem"id ="want_prem" value="1"> ต้องการให้เตรียมฟรีมยืดไปซิวเก็บเตียงหรือที่นอนเก่า
			</div>
			<div class="w3-container w3-bar">
				รายละเอียดเพิ่มเติม
				<textarea name="description_ja" class="w3-input" id="description_ja" cols="54" rows="1" style="width:90%;"></textarea>
			</div>
		</div>
	</div>
	</fieldset>
<?php
}else if ($fetch2["check_detail"]=='1'){
		?>
<fieldset><legend><input type="checkbox" name="more" id="more" value="1" checked="checked"> <b>รายละเอียดการจัดส่ง</b></legend>

		<div class="w3-third 112">
			<div class="w3-bar 1">

<?php
if ($fetch3["runway"]=='1'){
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
if ($fetch3["road"]=='1'){
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
if ($fetch3["soy"]=='1'){
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
				<input name="soy_big" class="w3-input" value="<?php echo $fetch3["soy_big"]; ?>" type='text' id="soy_big" style="color:black;text-align:left;width:90%;" placeholder="(เมตร)" />
			</div>
			<div class="w3-bar 5">
			<?php
		if ($fetch3["height_ltd"]=='1'){
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
		if ($fetch3["car_load"]=='1'){
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
		if ($fetch3["no_car_road"]=='1'){
		?>
				<input type="checkbox" name="no_car_road"id = "no_car_road" checked='checked' value="1">
			<?php
			}else{
			?>
			<input type="checkbox" name="no_car_road"id = "no_car_road" value="1">
		<?php
		}
			?>
				
				รถยนต์เข้าไม่ได้ สามารถจอดได้ที่ <input name="car_park" class="w3-input" type='text' id="car_park" value ="<?php echo $fetch3["car_park"]; ?>" style="width:90%;" />
			</div>
			<div class="w3-bar 8">
				การจอดรถ
			</div>
			<div class="w3-bar 9">
	<?php
		if ($fetch3["car_road"]=='1'){
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
		if ($fetch3["car_home"]=='1'){
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
				<input name="door_long" class="w3-input" type='text' value="<?php echo $fetch3["door_long"]; ?>" id="door_long" style="color:black;text-align:left;width:90%;" placeholder="(เมตร)" />
			</div>
			<div class="w3-bar 12">
			<?php
		if ($fetch3["slope"]=='1'){
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
		if ($fetch3["bundai"]=='1'){
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
				<input name="unit_bundai" class="w3-input" type='text' id="unit_bundai" value="<?php echo $fetch3["unit_bundai"]; ?>" style="width:90%;" placeholder="จำนวน (ขั้น)" />
			</div>
			<div class="w3-bar 15">
				ประตูบ้านกว้าง
				<input name="door_bigger" class="w3-input" type='text' id="door_bigger" value="<?php echo $fetch3["door_bigger"]; ?>" style="width:90%;" placeholder="(เมตร)" />
			</div>
			<div class="w3-bar 16">
				ประตูสูง 
				<input name="door_longer" class="w3-input" type='text' id="door_longer" value="<?php echo $fetch3["door_longer"]; ?>" style="width:90%;" placeholder="(เมตร)" />
			</div>
			<div class="w3-bar 17">
				ประตูห้องกว้าง 
				<input name="room_bigger" class="w3-input" type='text' id="room_bigger" value="<?php echo $fetch3["room_bigger"]; ?>" style="width:90%;" placeholder="(เมตร)" />
			</div>
			<div class="w3-bar 18">
				ประตูห้องสูง 
				<input name="room_longer" class="w3-input" type='text' id="room_longer"  value="<?php echo $fetch3["room_longer"]; ?>" style="width:90%;" placeholder="(เมตร)" />
			</div>
		</div>
		<div class="w3-third 212">
			<div class="w3-bar 1">
				ประตูบ้านเป็นแบบ
				<input name="type_door" class="w3-input" type='text' id="type_door"  value="<?php echo $fetch3["type_door"]; ?>" style="width:90%;" />
			</div>
			<div class="w3-bar 2">
				พื้นบ้านเป็นแบบ
				<input name="home_type" class="w3-input" type='text' id="home_type" value="<?php echo $fetch3["home_type"]; ?>" style="width:90%;" />
			</div>
			<div class="w3-bar 3">
				ติดตั้งที่ชั้น
				<input name="install" class="w3-input" type='text' id="install" value="<?php echo $fetch3["install"]; ?>" style="width:90%;" />
			</div>
			<div class="w3-bar 4">

			<?php
		if ($fetch3["bundai_install"]=='1'){
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
				<input name="bundai_big" class="w3-input" type='text' id="bundai_big" value="<?php echo $fetch3["bundai_big"]; ?>" style="width:90%;" placeholder="เมตร" />
			</div>
			<div class="w3-bar 6">
				หักมุมบันได
				<input name="bundai_hug" class="w3-input" type='text' id="bundai_hug" value="<?php echo $fetch3["bundai_hug"]; ?>" style="width:90%;" />
			</div>
			<div class="w3-bar 7">
				ชนิดของบันได
				<input name="type_bundai" class="w3-input" type='text' id="type_bundai" value="<?php echo $fetch3["type_bundai"]; ?>" style="width:90%;" />
			</div>
			<div class="w3-bar 8">
			<?php
		if ($fetch3["lip"]=='1'){
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
				<input name="lip_big" class="w3-input" type='text' id="lip_big" value="<?php echo $fetch3["lip_big"]; ?>" style="width:90%;" placeholder="เมตร" />
			</div>
			<div class="w3-bar 10">
				สูง
				<input name="lip_long" class="w3-input" type='text' id="lip_long" value="<?php echo $fetch3["lip_long"]; ?>" style="width:90%;" placeholder="เมตร" />
			</div>
			<div class="w3-bar 11">
				รับน้ำหนักได้ 
				<input name="lip_weight" class="w3-input" type='text' id="lip_weight" value="<?php echo $fetch3["lip_weight"]; ?>" style="width:90%;" />
			</div>
			
		</div>
		<div class="w3-third 312">
			<div class="w3-bar 12">
		<?php
		if ($fetch3["up"]=='1'){
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
		if ($fetch3["no_up"]=='1'){
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
		if ($fetch3["head_bad"]=='1'){
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
		if ($fetch3["want_employee"]=='1'){
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
				<input name="employee_unit" class="w3-input" type='text' value="<?php echo $fetch3["employee_unit"]; ?>" id="employee_unit" style="width:90%;" />
			</div>
			<div class="w3-bar 17">
				ย้ายเฟอร์นิเจอร์ 
				<input name="ferniger_name" class="w3-input" type='text' id="ferniger_name" value="<?php echo $fetch3["ferniger_name"]; ?>" style="width:90%;" />
			</div>
			<div class="w3-bar 18">
				ย้ายไปที่ 
				<input name="ferniger_address" class="w3-input" type='text' id="ferniger_address" value="<?php echo $fetch3["ferniger_address"]; ?>" style="width:90%;" />
			</div>
			<div class="w3-bar">
		<?php
		if ($fetch3["want_ex"]=='1'){
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
		if ($fetch3["want_credit"]=='1'){
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
				<input name="bank" class="w3-input" type='text' id="bank" value="<?php echo $fetch3["bank"]; ?>" style="width:90%;" />
			</div>
			<div class="w3-bar">
		<?php
		if ($fetch3["want_prem"]=='1'){
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
				<textarea name="description_ja" class="w3-input" id="description_ja" cols="54" rows="1" style="width:90%;"><?php echo $fetch3["description"]; ?></textarea>
			</div>
		</div>
	
	</fieldset>



<?php
		}
		?>

</div><!-- cs -->

<center>
<input type="submit" name="submit" class="w3-button w3-teal" >
</center>


</form></div></div>
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
		return "data_delivery.php?delivery_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("delivery","h_delivery");
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
		return "data_payment.php?payment_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("payment","h_payment");
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
		return "data_employee_name.php?employee_name_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("employee_name","h_employee_name");
        </script>













<!-- -->
<script type="text/javascript">//sn1
$(document).ready(function(){
    $('.search-salechannel input[id="sale_channel"]').on("keyup input", function(){
        /* Get input value on change */
        var inputVal = $(this).val();
        var resultDropdown = $(this).siblings(".resultsalechannel");
        if(inputVal.length){
            $.get("ldata_salechannel.php", {term: inputVal}).done(function(data){
                // Display the returned data in browser
                resultDropdown.html(data);
            });
        } else{
            resultDropdown.empty();
        }
    });
    
    // Set search input value on click of result item
    $(document).on("click", ".resultsalechannel p", function(){
        $(this).parents(".search-salechannel").find('input[id="sale_channel"]').val($(this).text());
        $(this).parent(".resultsn1").empty();
    });
});
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
		return "data_bill_name2.php?bill_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("bill_id","h_bill_id");
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
		return "data_bill_name3.php?tel_1_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("tel_1","h_tel_1");
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
		return "data_customer_no3.php?tel_1_search=" +encodeURIComponent(this.value);
    });	
}	
 
// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("customer_no1","h_customer_no");
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