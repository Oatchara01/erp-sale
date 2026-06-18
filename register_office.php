<?php include('head.php'); ?>
<link rel="stylesheet" href="css/autocomplete.css"  type="text/css"/>
<script type="text/javascript" src="js/autocomplete.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>


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


</script>
<body>
<?php
		$sql1 = "select * from so__main order by main_id desc limit 1";
		$query1 = mysqli_query($conn,$sql1);
		$fetch1 = mysqli_fetch_array($query1,MYSQLI_ASSOC); ?>

	<!--action="register_office1.php"-->
	<form action='register_office1.php' method="post" name="frmMain" enctype="multipart/form-data">
		<div class="w3-container w3-padding-large"><!-- main div -->
			<div class="w3-panel w3-light-gray"><h4>Register Data</h4></div>
		<div class="w3-half"><!-- first half -->
			<div class="w3-bar w3-border">
<div class="w3-button"><input type="radio" checked="checked" name="select_type_doc" onclick="javascript:object();" value="1" id="object1">&nbsp;ใบยืมสินค้า PTL</div>
<div class="w3-button"><input type="radio" name="select_type_doc" onclick="javascript:object();" value="2" id="object2">&nbsp;ใบยืมสินค้า NBM</div>
<div class="w3-button"><input type="radio" name="select_type_doc" onclick="javascript:object();" value="3" id="object3">&nbsp;ใบสั่งขาย PTL</div>
<div class="w3-button"><input type="radio" name="select_type_doc" onclick="javascript:object();" value="4" id="object4">&nbsp;ใบสั่งขาย NBM</div>
			</div>
			<div class="w3-padding-small"></div>
				<div class="w3-bar">
					วันที่ : <span class="w3-light-grey"><?php echo DateThai(date("d-m-Y")); ?></span> | เลขที่อ้างอิง : <span name="ref_id" class=""><?php echo $fetch1['ref_id']+1; ?></span> <input type="hidden" name="main_id" value="<?php echo $fetch1['main_id']+1; ?>"><input type="hidden" name="ref_id" value="<?php echo $fetch1['ref_id']+1; ?>">
				</div>
				<div class="w3-padding-small"></div>
				ช่องทางการขาย
				<div class="search-sale_channel">
                <select name="sale_channel" id="sale_channel" class="w3-select" onchange="showUser(this.value)"  >
<option  value="">**โปรดเลือกช่องทางการขาย**</option>
<?php
$sqlchannel = "select * from tb_salechannel order by salechannel_ID";
$querychannel = mysqli_query($conn,$sqlchannel);
while ($fetchchannel = mysqli_fetch_array($querychannel,MYSQLI_ASSOC)) { ?>
<option class="w3-bar-item w3-button" value="<?php echo $fetchchannel['salechannel_ID']; ?>"><?php echo $fetchchannel['salechannel_nameshort']; ?><?php echo $fetchchannel['description_chanel']; ?></option>
<?php } ?>
</select>

<?php /*onchange="document.getElementById('sale_code').value = this.value.split('|')[0];

document.getElementById('sale_name').value  = this.value.split('|')[1]; 
">
		<input name="sale_code" type='text' class="w3-input" id="sale_code" placeholder="Search การจัดส่ง..."> 
		<input name="sale_name" type='text' class="w3-input" id="sale_name" placeholder="Search การจัดส่ง..."> 

*/?>
				</div>
				<div class="w3-padding-small"></div>
				การจัดส่ง
		<input name="delivery" type='text' class="w3-input" id="delivery" placeholder="Search การจัดส่ง..."> 
		<input name="h_delivery" type="hidden" id="h_delivery" value="" class="w3-input" /> 


				<?php /*<select name="delivery" class="w3-select"  >
					<option value="">**Please Select Item**</option>
					<?php
							$sqldeli = "SELECT tb_delivery.*,tb_sender.* FROM tb_delivery LEFT JOIN tb_sender ON tb_delivery.employee_send=tb_sender.sender_ID";
							$querydeli = mysqli_query($conn,$sqldeli);
							if (!$querydeli) {
								echo "Failed to fetch to MySQL: " . mysqli_error();
							}
							while ($fetchdeli = mysqli_fetch_array($querydeli,MYSQLI_ASSOC)) {
							?>
									<option class="w3-bar-item w3-button" value="<?php echo $fetchdeli['delivery_id'];?>"><?php echo $fetchdeli['delivery_name'];?> | <?php echo $fetchdeli['time_delivery']; ?> | <?php echo $fetchdeli['remark']; ?><?php echo $fetchdeli['packing_remark'];?></option>
							<?php } ?>
				</select>*/?>
<div class="w3-padding-small"></div>
การชำระเงิน:


		<input name="payment" type='text' class="w3-input" id="payment" placeholder="Search การชำระเงิน..."    OnChange="fncSum();"> 
		<input name="h_payment" type="hidden" id="h_payment" value="" class="w3-input" /> 


<?php/*
<select name="payment" class="w3-select"  >
<option value="">**Please Select Item**</option>
<?php
$strSQL5 = "select * from tb_payment order by payment_ID";
$objQuery5 = mysqli_query($conn,$strSQL5);
if (!$objQuery5) {
	echo "Failed to fetch to MySQL: " . mysqli_error();
}
while ($objResuut5 = mysqli_fetch_array($objQuery5,MYSQLI_ASSOC)) {
?>
<option class="w3-bar-item w3-button"  value="<?php echo $objResuut5['payment_ID']; ?>"><?php echo $objResuut5['payment_name']; ?> | <?php echo $objResuut5['bank_name']; ?> | <?php echo $objResuut5['book_number']; ?> | <?php echo $objResuut5['branch_bank']; ?> | <?php echo $objResuut5['book_type']; ?> | <?php echo $objResuut5['book_name']; ?> | <?php echo $objResuut5['description_payment']; ?></option>
<?php } ?>
</select>*/?>
<div class="w3-padding-small"></div>
หมายเหตุ:
<textarea name="sale_remark"  class="w3-input" id="sale_remark"  rows="1"></textarea>
<div class="w3-padding-small"></div>
ชื่อพนักงาน:

		<input name="employee_name" type='text' class="w3-input" id="employee_name" placeholder="Search พนักงาน..."> 
		<input name="h_employee_name" type="hidden" id="h_employee_name" value="" class="w3-input" /> 



<?php /*<select  name="employee_name" class="w3-select"  >
<option value="">**Please Select Item**</option>

<?php
$emp = "select * from tb_employee where status=1 order by employee_ID";
$sqlemp = mysqli_query($conn,$emp);
while ($fetchemp = mysqli_fetch_array($sqlemp,MYSQLI_ASSOC)) { ?>
<option class="w3-bar-item w3-button" value="<?php echo $fetchemp['employee_ID']; ?>"><?php echo $fetchemp['employee_name']; ?></option>
<?php } ?>
</select>*/?>
</div><!-- 1st half -->
<!-- tab -->
<div class="w3-half w3-container"><!-- second half -->
<div class="w3-bar w3-light-grey w3-border">
  <a class="w3-button"  onclick="openCity('br')"><font color="404040"><b>ใบยืมสินค้า</b></font></a>
  <a class="w3-button" onclick="openCity('so')"><font color="404040"><b>ใบสั่งขาย</b></font></a>
  <a class="w3-button" onclick="openCity('mo')"><font color="404040"><b>เพิ่มเติม</b></font></a>
  <a class="w3-button" onclick="openCity('ca')"><font color="404040"><b>การโทรรีวิว</b></font></a>


</div>
<div id="br" class="city">
<div id="txtHint"></div>
</div><!-- close br -->
</br>

<div id="so" class="city" style="display:none">
<div class="w3-half w3-container"><!-- first so half -->
ชื่อที่ออกบิล:
<input name="billing_name" type='text' class="w3-input" >
ทีอยู่ที่ออกบิล:
<textarea name="billing_address" class="w3-input" rows="1"></textarea>
<div class="w3-half">
Tel.:
<input type="text" name="billing_tel" class="w3-input">
</div>
<div class="w3-bar w3-half w3-container">
<input type="checkbox" name="bill_vat" value="1"> &nbsp;บิล VAT
</div>
<div class="w3-bar">การชำระเงิน
<input name="payment1" type='text' class="w3-input" id="payment1" placeholder="Search การชำระเงิน..."    > 
	
<?php /*
<select name="payment1" class="w3-select" disabled>
<option value="">**Please Select Item**</option>
<?php
$strSQL5 = "select * from tb_payment order by payment_ID";
$objQuery5 = mysqli_query($conn,$strSQL5);
if (!$objQuery5) {
	echo "Failed to fetch to MySQL: " . mysqli_error();
}
while ($objResuut5 = mysqli_fetch_array($objQuery5,MYSQLI_ASSOC)) {
?>
<option class="w3-bar-item w3-button"  value="<?php echo $objResuut5['payment_ID']; ?>"><?php echo $objResuut5['payment_name']; ?> | <?php echo $objResuut5['bank_name']; ?> | <?php echo $objResuut5['book_number']; ?> | <?php echo $objResuut5['branch_bank']; ?> | <?php echo $objResuut5['book_type']; ?> | <?php echo $objResuut5['book_name']; ?> | <?php echo $objResuut5['description_payment']; ?></option>
<?php } ?>
</select>*/?>
</div>
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
<div class="w3-bar">
ส่งบัญชีตรวจสอบ
<input type="checkbox" name="account_approve" value="1">
</div>
<div class="w3-bar">
วันที่โอน
<input type="date" name="transfer_date" id="transfer_date" class="w3-input">
</div>
<div class="w3-bar">
จำนวนเงินโอน/เก็บปลายทาง
<input type="text" name="amount" class="w3-input">
</div>
</div><!-- close so first half -->

<div class="w3-half w3-container w3-border"><!-- so second half -->
<font color="#FF0000"><b>ใช้สำหรับจ่าหน้าพัสดุเท่านั้น</b></font><br />
ชื่อผู้รับสินค้า
<input name="customer_name" type="text" class="w3-input">
ที่อยู่ในการจัดส่ง
<input name="address1" class="w3-input" type="text">
<input name="address2" class="w3-input" type="text">
จังหวัด
<select name="province" class="w3-select">
<option class="w3-bar" value=""></option>
<?php
$province="select * from tb_province order by province_name";
$prosql=mysqli_query($conn,$province);
while ($fepro=mysqli_fetch_array($prosql)) { ?>
<option class="w3-bar" value="<?php echo $fepro["province_name"]; ?>"><?php echo $fepro["province_name"]; ?></option>
<?php } ?>
</select>
รหัสไปรษณีย์
<input name="postcode" type="text" class="w3-input">
โทรศัพท์
<input name="tel" type="text" class="w3-input">
</div><!-- close so second half -->
</div><!-- close so -->


<div id="ca" class="w3-container city" style="display:none">

วันที่โทร :
<input type='date' name="review_date_call" class="w3-input" >

รายละเอียดการโทร :
<textarea  name="review_call_des" class="w3-input" ></textarea>
วันที่ลูกค้ามารีวิว :
<input type='date' name="review_date" class="w3-input" >
วันที่ส่งโปรโมชั่น :
<input type='date' name="promotion_date" class="w3-input" >
หมายเหตุ :
<textarea  name="review_description" class="w3-input" ></textarea>

</div>

<div id="mo" class="w3-container city" style="display:none">
<div class="w3-third"><!--first third -->
ชื่อผู้แนะนำ
<input name="prefer_name" class="w3-input" >
ใบสั่งซื้อเลขที่
<input name="po_no" class="w3-input" >
กำหนดส่งตามสัญญา:
<input name="delivery_contract" class="w3-input" >
 <input type="checkbox" name="clear_book_ckk" value="1">&nbsp; เคลียร์ใบจอง:
<input name="clear_book_no" class="w3-input" placeholder="เลขที่" >
<input type="checkbox" name="clear_brn_no_ckk" value="1">&nbsp;เคลียร์ใบยืม BRN:
<input name="clear_brn_no" class="w3-input" placeholder="เลขที่" >
<input type="checkbox" name="clear_brnp_no_ckk" value="1">&nbsp;เคลียร์ใบยืม BRNP:
<input name="clear_brnp_no" class="w3-input" placeholder="เลขที่" >
</div><!--first third -->
<div class="w3-container w3-third"><!--second third -->
<input type="checkbox" name="sn_ckk" value="1">&nbsp;ต้องการ SN:
<input name="sn" class="w3-input" >
<input type="checkbox" name="bq_ckk" value="1">&nbsp;BQ เลขที่:
<input name="bq" class="w3-input" >
<input type="checkbox" name="ot_ckk" value="1">&nbsp;OT เลขที่:
<input name="ot" class="w3-input" >
</div><!--second third -->
<div class="w3-third"><!--third third -->
สถานที่ติดตั้งเครื่อง
<input name="install_place" class="w3-input" ><br />
<input name="with_pr" type="checkbox" value="1">
แนบใบเสนอราคา
<br />
<input type="radio" name="type_type" checked="checked" value="1" onclick="javascript:ckk_1();" id="object6">พิมพ์ตามคอม
<br />
<input type="radio" name="type_type" value="2" onclick="javascript:ckk_1();" id="object7">พิมพ์ตามใบสั่งซื้อ
<br />
<input type="radio" name="type_type" value="3" onclick="javascript:ckk_1();" id="object5">พิมพ์ตามที่เขียน
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
  <a class="w3-bar-item w3-button" onclick="openCity1('ot')"><font color="#404040"><b>ปิดงาน</b></font></a>
</div>


<div id="pd" class="w3-container city1">

<?php include ('register_office_detail.php')?>

</div>

<div id="cs" class="w3-container city1" style="display:none">
<div class="w3-quarter w3-container"><!-- first quarter -->
<div class="w3-bar w3-text white"><font class="w3-text-white">xxx</font></div>
วันที่ส่ง
<input type="date" name="delivery_date" class="w3-input">
เวลาส่ง
<input type="text" name="delivery_time" class="w3-input">
การส่งสินค้า<br>
<input type="checkbox" name="delivery_company" value="1">&nbsp;บริษัทจัดส่ง<br />
<input type="checkbox" name="big_car" value="1">&nbsp;ต้องการรถใหญ่<br />
<input type="checkbox" name="call_before" value="1">&nbsp;โทรแจ้งลูกค้าก่อนไป<br />
<input type="checkbox" name="maps" value="1">&nbsp;มีแผนที่ประกอบ</p>


  <input name="upload_map"  type="file"></p>


<input type="checkbox" name="assign_date_time" value="1">&nbsp;นัดวันเวลาเรียบร้อยแล้ว<br />
</div><!-- first quarter -->
<div class="w3-quarter w3-container"><!-- second quarter -->
<input type="checkbox" name="delivery_sale" value="1">&nbsp;Sale รับเอง
<input type="checkbox" name="delivery_engineer" value="1">&nbsp;ช่างรับเอง
<input type="checkbox" name="delivery_customer" value="1">&nbsp;ลูกค้ารับเอง <br />
สถานที่ส่งสินค้า:
<textarea name="delivery_place" class="w3-input" rows="1" style="width:100%;resize: none" ></textarea>
ชื่อผู้ติดต่อ/TEL.:
<input type="text" name="delivery_contact" class="w3-input" >
</div><!-- second quarter -->
<div class="w3-quarter w3-container"><!-- third quarter -->
<input type="checkbox" name="return" value="1">&nbsp;รับคืนสินค้า<br>
วันที่รับคืน
<input type="date" name="return_date" class="w3-input" >
เวลา
<input type="text" name="return_time" class="w3-input" >
ที่อยู่รับคืนสินค้า:
<input type="text" name="return_address" class="w3-input" >
ชื่อผู้ติดต่อ/TEL.:
<input type="text" name="return_contact" class="w3-input" >
</div><!-- third quarter --><!-- forth quarter -->
<div class="w3-quarter w3-container">

<div id="dt1" style="display:none">
					
<input type="checkbox"  checked="checked" value="1">&nbsp;

<a href="report_loanptl.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey"><font color="Blue">ใบยืม PTL</font></a>&nbsp;&nbsp;
</div>

<div id="dt2" style="display:none">
<input type="checkbox" name="select_br_nbm" checked="checked" value="1">&nbsp;
					

<a  href="report_loannbm.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey"><font color="DeepPink"> ใบยืม NBM</font></a>&nbsp;

</div>

<div id="dt3" style="display:none">

<input type="checkbox" name="select_so_ptl" checked="checked" value="1">&nbsp;
		
<a href="report_saleptl.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey"><font color="Blue">ใบสั่งขาย PTL</font></button></a><br />

</div>
		
	<div id="dt4" style="display:none">

		
<input type="checkbox" name="select_so_nbm" checked="checked" value="1">&nbsp;
				

<a href="report_salenbm.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-grey"><font color="DeepPink">ใบสั่งขาย NBM</font></a>
</div></div><!-- forth quarter -->
</div><!-- cs -->


<center>
<input type="submit" name="submit" class="w3-button w3-teal" >
</center>


</form>
<div id="cr_bar"> Copyright © 2019 phar trillion co., ltd. </div>
  </div>
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
<!-- -->