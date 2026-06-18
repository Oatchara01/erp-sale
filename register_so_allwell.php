<?php include('head.php'); ?>
<link rel="stylesheet" href="css/autocomplete.css"  type="text/css"/>
<script type="text/javascript" src="js/autocomplete.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.microsoft.com/ajax/jQuery/jquery-1.4.2.min.js"></script>

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
		$sql = "select * from so__main order by main_id desc limit 1";
		$query = mysqli_query($conn,$sql);
		$fetch = mysqli_fetch_array($query,MYSQLI_ASSOC); 
		
		
		
				$sql1 = "select * from tb_deposit where deposit_code = '".$_GET["deposit_code"]."'";
				$query1 = mysqli_query($conn,$sql1);
				$fetch1 = mysqli_fetch_array($query1,MYSQLI_ASSOC); 
		
		
		?>

	<!--action="register_office1.php"-->
	<form action='register_allwell1.php' method="post" name="frmMain" enctype="multipart/form-data">
	<div class="w3-white">
		<div class="w3-container w3-padding-large"><!-- main div -->
			<div class="w3-panel w3-light-gray"><h4>Register Data</h4></div>
		<div class="w3-third"><!-- first half -->
			<div class="w3-bar w3-border">
<div class="w3-button"><input type="radio" name="select_type_doc" onclick="javascript:object();" value="3" id="object3">&nbsp;ใบสั่งขาย PTL</div>
<div class="w3-button"><input type="radio" name="select_type_doc" onclick="javascript:object();" value="4" id="object4">&nbsp;ใบสั่งขาย NBM</div>
			</div>
			<div class="w3-padding-small"></div>
				<div class="w3-bar">
					วันที่ : <span class="w3-light-grey"><?php echo DateThai(date("d-m-Y")); ?></span> | เลขที่อ้างอิง : <span name="ref_id" class=""><?php echo $fetch['ref_id']+1; ?></span> <input type="hidden" name="main_id" value="<?php echo $fetch['main_id']+1; ?>"><input type="hidden" name="ref_id" value="<?php echo $fetch['ref_id']+1; ?>">
				</div>
				<?php /*<div class="w3-padding-small"></div>
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

onchange="document.getElementById('sale_code').value = this.value.split('|')[0];

document.getElementById('sale_name').value  = this.value.split('|')[1]; 
">
		<input name="sale_code" type='text' class="w3-input" id="sale_code" placeholder="Search การจัดส่ง..."> 
		<input name="sale_name" type='text' class="w3-input" id="sale_name" placeholder="Search การจัดส่ง..."> 


				</div>*/?>
				<div class="w3-padding-small"></div>
				การจัดส่ง
	<?php /*	<input name="delivery" type='text' class="w3-input" id="delivery" placeholder="Search การจัดส่ง..."> 
		<input name="h_delivery" type="hidden" id="h_delivery" value="" class="w3-input" /> */?>


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
									<option class="w3-bar-item w3-button" value="<?php echo $fetchdeli['delivery_id'];?>"><?php echo $fetchdeli['delivery_name'];?> <?php echo $fetchdeli['packing_remark'];?></option>
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

<?php /*		<input name="employee_name" type='text' class="w3-input" id="employee_name" placeholder="Search พนักงาน..."> 
		<input name="h_employee_name" type="hidden" id="h_employee_name" value="" class="w3-input" /> */?>



<select  name="employee_name" class="w3-select"  >
<option value="">**Please Select Item**</option>

<?php
$emp = "select * from tb_employee where department_id='1' order by employee_ID";
$sqlemp = mysqli_query($conn,$emp);
while ($fetchemp = mysqli_fetch_array($sqlemp,MYSQLI_ASSOC)) { ?>
<option class="w3-bar-item w3-button" value="<?php echo $fetchemp['employee_name']; ?>"><?php echo $fetchemp['employee_name']; ?></option>
<?php } ?>
</select>
</div><!-- 1st half -->
<!-- tab -->
<div class="w3-twothird w3-container"><!-- second half -->
<div class="w3-bar w3-light-grey w3-border">
  <a class="w3-button"  onclick="openCity('so')"><font color="404040"><b>ใบสั่งขาย</b></font></a>
  <a class="w3-button"  onclick="openCity('mo')"><font color="404040"><b>เพิ่มเติม</b></font></a>
  <a class="w3-button"  onclick="openCity('ca')"><font color="404040"><b>การโทรรีวิว</b></font></a>
  <a class="w3-button"  onclick="openCity('rs')"><font color="404040"><b>แบบสอบถาม</b></font></a>


</div>
</br>

<div id="so" class="city" >
<div class="w3-half w3-container"><!-- first so half -->
ชื่อที่ออกบิล:

<input name="deposit_id" value="<?php echo $fetch1["deposit_id"]; ?>" type='hidden' class="w3-input" >
<input name="add_by" value="<?php echo $_SESSION['name']; ?>&nbsp;<?php echo $_SESSION['surname']; ?>" type='hidden' class="w3-input" >
<input name="billing_name" value="<?php echo $fetch1["bill_name"]; ?>" type='text' class="w3-input" >
<div class="w3-padding-small"></div>
ทีอยู่ที่ออกบิล:
<textarea name="billing_address" class="w3-input" rows="1"><?php echo $fetch1["bill_address"]; ?></textarea>
<div class="w3-padding-small"></div>
<div class="w3-half">
Tel.:
<input type="text" name="billing_tel" value="<?php echo $fetch1["bill_tel"]; ?>" class="w3-input">
</div>
<div class="w3-padding-small"></div>
<div class="w3-bar w3-half w3-container">
<input type="checkbox" name="bill_vat" value="1"> &nbsp;บิล VAT
</div></p>
<div class="w3-padding-small"></div>
<div class="w3-bar">
<?php /*การชำระเงิน<input name="payment1" type='text' class="w3-input" id="payment1" placeholder="Search การชำระเงิน..."    > 
	

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
<input type="checkbox" name="account_approve" value="1">
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
<div class="w3-padding-small"></div>
</div><!-- close so first half -->
<?php /*
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
</div><!-- close so second half -->*/ ?>
</div><!-- close so -->


<div id="ca" class="w3-container city" style="display:none">

วันที่โทร :
<input type='date' name="review_date_call" class="w3-input" >
<div class="w3-padding-small"></div>
รายละเอียดการโทร :
<textarea  name="review_call_des" class="w3-input" ></textarea>
<div class="w3-padding-small"></div>
วันที่ลูกค้ามารีวิว :
<input type='date' name="review_date" class="w3-input" >
<div class="w3-padding-small"></div>
วันที่ส่งโปรโมชั่น :
<input type='date' name="promotion_date" class="w3-input" >
<div class="w3-padding-small"></div>
หมายเหตุ :
<textarea  name="review_description" class="w3-input" ></textarea>
<div class="w3-padding-small"></div>

</div>
<div id="rs" class="w3-container city" style="display:none">

 <table border="1" class="w3-table" width="100%">
<tr>
<td width="7%" align="center" bgcolor="#D3D3D3">ลำดับ</td>
<td width="50%" align="center" bgcolor="#D3D3D3">รายละเอียด</td> 
<td width="8%" align="center" bgcolor="#D3D3D3">มากที่สุด</td>
<td width="8%" align="center" bgcolor="#D3D3D3">มาก</td>

<td width="8%" align="center" bgcolor="#D3D3D3">ปานกลาง</td>
<td width="8%" align="center" bgcolor="#D3D3D3">น้อย</td>
<td width="8%" align="center" bgcolor="#D3D3D3">น้อยที่สุด</td>

</tr>
<tr>
<td align="center" bgcolor="#B0C4DE"><div align="center">
<span class='style39'></span>
</div></td>

<td align="left" bgcolor="#B0C4DE"><div align="left" >
<span class='style39'>ส่วนที่ 1 ความพึงพอใจต่อพนักงานขาย</span>
</div></td>

<td align="center" bgcolor="#B0C4DE"><div align="center">
</div></td>

<td align="center" bgcolor="#B0C4DE"><div align="center">
</div></td>

 
<td align="center" bgcolor="#B0C4DE"><div align="center">
</div></td>


<td align="center" bgcolor="#B0C4DE"><div align="center">
</div></td>


<td align="center" bgcolor="#B0C4DE"><div align="center">
</div></td>


</tr>

<tr>
<td align="center"><div align="center">
<span class='style39'>1</span>
</div></td>

<td align="left"><div align="left">
<span class='style39'>พนักงานขายกิริยามารยาทเรียบร้อยหรือไม่</span>
</div></td>

<td align="center"><div align="center">
<input type='radio'  name='emp_neat' id = 'emp_neat' value='5' /></div></td>

<td align="center"><div align="center">
<input type='radio'  name='emp_neat' id = 'emp_neat' value='4' /></div></td>


<td align="center"><div align="center">
<input type='radio'  name='emp_neat' id = 'emp_neat' value='3' /></div></td>


<td align="center"><div align="center">
<input type='radio'  name='emp_neat' id = 'emp_neat' value='2' /></div></td>


<td align="center"><div align="center">
<input type='radio'  name='emp_neat' id = 'emp_neat' value='1' /></div></td>


</tr>

<tr>
<td align="center"><div align="center">
<span class='style39'>2</span>
</div></td>

<td align="left"><div align="left">
<span class='style39'>พนักงานขายให้ข้อมูลรายละเอียดครบถ้วนหรือไม่</span>
</div></td>

<td align="center"><div align="center">
<input type='radio'  name='emp_complete' id = 'emp_complete' value='5' /></div></td>

<td align="center"><div align="center">
<input type='radio'  name='emp_complete' id = 'emp_complete' value='4' /></div></td>


<td align="center"><div align="center">
<input type='radio'  name='emp_complete' id = 'emp_complete' value='3' /></div></td>


<td align="center"><div align="center">
<input type='radio'  name='emp_complete' id = 'emp_complete' value='2' /></div></td>


<td align="center"><div align="center">
<input type='radio'  name='emp_complete' id = 'emp_complete' value='1' /></div></td>


</tr>



<tr>
<td align="center" bgcolor="#B0C4DE"><div align="center">
</div></td>

<td align="left" bgcolor="#B0C4DE"><div align="left">
<span class='style39'>ส่วนที่ 2 ความพึงพอใจต่อสินค้า/ผลิตภัณฑ์</span>
</div></td>

<td align="center" bgcolor="#B0C4DE"><div align="center">
</div></td>

<td align="center" bgcolor="#B0C4DE"><div align="center">
</div></td>


<td align="center" bgcolor="#B0C4DE"><div align="center">
</div></td>


<td align="center" bgcolor="#B0C4DE"><div align="center">
</div></td>


<td align="center" bgcolor="#B0C4DE"><div align="center">
</div></td>


</tr>


<tr>
<td align="center"><div align="center">
<span class='style39'>1</span>
</div></td>

<td align="left"><div align="left">
<span class='style39'>สินค้าใช้งานได้ดีหรือไม่</span>
</div></td>

<td align="center"><div align="center">
<input type='radio'  name='product_good' id = 'product_good' value='5' /></div></td>

<td align="center"><div align="center">
<input type='radio'  name='product_good' id = 'product_good' value='4' /></div></td>


<td align="center"><div align="center">
<input type='radio'  name='product_good' id = 'product_good' value='3' /></div></td>


<td align="center"><div align="center">
<input type='radio'  name='product_good' id = 'product_good' value='2' /></div></td>


<td align="center"><div align="center">
<input type='radio'  name='product_good' id = 'product_good' value='1' /></div></td>


</tr>
<tr>
<td align="center"><div align="center">
<span class='style39'>2</span>
</div></td>

<td align="left"><div align="left">
<span class='style39'>พอใจในตัวสินค้าหรือไม่</span>
</div></td>

<td align="center"><div align="center">
<input type='radio'  name='product_like' id = 'product_like' value='5' /></div></td>

<td align="center"><div align="center">
<input type='radio'  name='product_like' id = 'product_like' value='4' /></div></td>


<td align="center"><div align="center">
<input type='radio'  name='product_like' id = 'product_like' value='3' /></div></td>


<td align="center"><div align="center">
<input type='radio'  name='product_like' id = 'product_like' value='2' /></div></td>


<td align="center"><div align="center">
<input type='radio'  name='product_like' id = 'product_like' value='1' /></div></td>


</tr>


<tr>
<td align="center" bgcolor="#B0C4DE"><div align="center">
</div></td>

<td align="left" bgcolor="#B0C4DE"><div align="left">
<span class='style39'>ส่วนที่ 3 ความพึงพอใจต่อพนักงานผู้ติดตั้ง/สาธิต เตียงปรับไฟฟ้า</span>
</div></td>

<td align="center" bgcolor="#B0C4DE"><div align="center">
</div></td>

<td align="center" bgcolor="#B0C4DE"><div align="center">
</div></td>


<td align="center" bgcolor="#B0C4DE"><div align="center">
</div></td>


<td align="center" bgcolor="#B0C4DE"><div align="center">
</div></td>


<td align="center" bgcolor="#B0C4DE"><div align="center">
</div></td>


</tr>



<tr>
<td align="center"><div align="center">
<span class='style39'>1</span>
</div></td>

<td align="left"><div align="left">
<span class='style39'>พนักงานผู้ติดตั้ง/สาธิต กิริยามารยาท และการแต่งกาย เรียบร้อยหรือไม่</span>
</div></td>

<td align="center"><div align="center">
<input type='radio'  name='cs_manner' id = 'cs_manner' value='5' /></div></td>

<td align="center"><div align="center">
<input type='radio'  name='cs_manner' id = 'cs_manner' value='4' /></div></td>


<td align="center"><div align="center">
<input type='radio'  name='cs_manner' id = 'cs_manner' value='3' /></div></td>


<td align="center"><div align="center">
<input type='radio'  name='cs_manner' id = 'cs_manner' value='2' /></div></td>


<td align="center"><div align="center">
<input type='radio'  name='cs_manner' id = 'cs_manner' value='1' /></div></td>


</tr>

<tr>
<td align="center"><div align="center">
<span class='style39'>2</span>
</div></td>

<td align="left"><div align="left">
<span class='style39'>พนักงานผู้ติดตั้ง/สาธิต อธิบายวิธีการใช้งานผลิตภัณฑ์ได้ดีหรือไม่</span>
</div></td>

<td align="center"><div align="center">
<input type='radio'  name='cs_explain' id = 'cs_explain' value='5' /></div></td>

<td align="center"><div align="center">
<input type='radio'  name='cs_explain' id = 'cs_explain' value='4' /></div></td>


<td align="center"><div align="center">
<input type='radio'  name='cs_explain' id = 'cs_explain' value='3' /></div></td>


<td align="center"><div align="center">
<input type='radio'  name='cs_explain' id = 'cs_explain' value='2' /></div></td>


<td align="center"><div align="center">
<input type='radio'  name='cs_explain' id = 'cs_explain' value='1' /></div></td>


</tr>

</table>

</p>
ข้อเสนอแนะอื่นๆ 
<textarea name="research_remark"  class="w3-input" id="research_remark"  rows="1"></textarea>
</p>
</div>
<div id="mo" class="w3-container city" style="display:none">
<div class="w3-third"><!--first third -->
ชื่อผู้แนะนำ
<input name="prefer_name" class="w3-input">
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




</div><!--second third -->
<div class="w3-third"><!--third third -->
สถานที่ติดตั้งเครื่อง
<input name="install_place" class="w3-input" >
<div class="w3-padding-small"></div>
<input name="with_pr" type="checkbox" value="1"> แนบใบเสนอราคา
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
</div>


<div id="pd" class="w3-container city1">

<?php include ('register_allwell_detail.php')?>

</div>
<div id="cs" class="w3-container city1" style="display:none">

<input type="radio" name="delivery_type" value="1" onclick="javascript:ckk_2();" id="object8">&nbsp;Sale รับเอง
<input type="radio" name="delivery_type" value="2"  onclick="javascript:ckk_2();" id="object9">&nbsp;ช่างรับเอง<br />
<input type="radio" name="delivery_type" value="3"  onclick="javascript:ckk_2();" id="object10">&nbsp;ลูกค้ารับเอง 
<input type="radio" name="delivery_type" value="4"  onclick="javascript:ckk_2();" id="object11">&nbsp;บริษัทจัดส่ง <br />

</p>
<div id="dv1" style="display:none">
<div class="w3-quarter w3-container"><!-- first quarter -->


วันที่ส่ง
<input type="date" name="delivery_date" value="<?php echo $fetch1["delivery_date"]; ?>"   class="w3-input">
เวลาส่ง
<input type="text" name="delivery_time" value="<?php echo $fetch1["delivery_time"]; ?>" class="w3-input">
การส่งสินค้า<br>
<input type="checkbox" name="big_car" value="1">&nbsp;ต้องการรถใหญ่<br />
<input type="checkbox" name="call_before" value="1">&nbsp;โทรแจ้งลูกค้าก่อนไป<br />
<input type="checkbox" name="maps" value="1">&nbsp;มีแผนที่ประกอบ</p>


  <input name="upload_map"  type="file"></p>


<input type="checkbox" name="assign_date_time" value="1">&nbsp;นัดวันเวลาเรียบร้อยแล้ว<br />
</div><!-- first quarter -->
<div class="w3-quarter w3-container"><!-- second quarter -->

สถานที่ส่งสินค้า:
<textarea name="delivery_place" class="w3-input" rows="1" style="width:100%;resize: none" ><?php echo $fetch1["delivery_address"]; ?></textarea>
ชื่อผู้ติดต่อ/TEL.:
<input type="text" name="delivery_contact" value="<?php echo $fetch1["delivery_name"]; ?>" class="w3-input" >
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
</div>


<div id="dv2" style="display:none">
<div class="w3-container w3-third">

 วันที่ รับ-ส่ง :
      <input name="start_date" type='date' id="start_date" value="<?php echo $fetch1["delivery_date"]; ?>"  class="w3-input"  />

	</div><div class="w3-container w3-third">

วันที่ต้องการโดยประมาณ :
	  <input name="between_date"  class="w3-input" type='text' id="between_date"  />
 </div><div class="w3-container w3-third">

 เวลา :
<input id="start_time"  name="start_time" value="<?php echo $fetch1["delivery_time"]; ?>"  class="w3-input" type="text" />
ถึง
<input id="end_time" name="end_time"  class="w3-input" type="text" />

</div><div class="w3-container w3-third">


สถานะการทำงาน : 

<input type='radio'  name='status' id = 'status' value='ส่ง' checked='checked'/>ส่ง
&nbsp; <input type='radio'  name='status' id = 'status' value='รับ' />รับ

</div><div class="w3-container w3-third">

สถานะ :
      <input name="status_comment" type='text' id="status_comment"  size="20" class="w3-input"/>
</div><div class="w3-container w3-third">


<input type="checkbox"  name="fix_datetime" id = "fix_datetime" value="1">นัดวันและเวลาเรียบร้อยแล้ว 
<input type="checkbox"  id = "no_money" name="no_money" value="1">ไม่ต้องเก็บเงิน
</div><div class="w3-container w3-third">

<input type="checkbox"  id = "call_customer" name="call_customer" value="1">โทรแจ้งลูกค้าก่อนไป
		
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox"  id = "call_back" name="call_back" value="1">ต้องการให้โทรกลับเมื่อส่งสินค้าเสร็จแล้ว

</div><div class="w3-container w3-third">
<input type="checkbox"   name="want_bus" value="1">ต้องการรถใหญ่
		</div><div class="w3-container w3-third">
	 
<input type="checkbox"  name="cash"id = "cash"  value="1">เก็บเงินสด
		 <input name="unit_cash" type='text' class="w3-input" id="unit_cash" size="20" rows="1" style="color:black;text-align:right" OnChange="JavaScript:chkNum(this)">  
		 </div><div class="w3-container w3-third">

	<input type="checkbox"  name="check_paper" id = "check_paper" value="1">รับเช็ค
	<input name="unit_check" type='text' class="w3-input"  id="unit_check" style="color:black;text-align:right" size="20" OnChange="JavaScript:chkNum(this)"/>
		</div><div class="w3-container w3-third">

<input type="checkbox"  id = "credit_card" name="credit_card" value="1">รูดการ์ด 
	<input name="unit_credit" type='text' class="w3-input"  id="unit_credit"  size="20" style="color:black;text-align:right"  OnChange="JavaScript:chkNum(this)"/> 
	</div><div class="w3-container w3-third">

<input type="checkbox"  id = "bill" name="bill" value="1">วางบิล
<input name="unit_bill" type='text' class="w3-input" style="color:black;text-align:right" id="unit_bill"  size="20" OnChange="JavaScript:chkNum(this)" />
</div><div class="w3-container w3-third">


<input type="checkbox"  name="tran"id = "tran"  value="1">ลูกค้าโอนเงินหน้างาน
		 <input name="unit_tran" type='text' class="w3-input" id="unit_tran" size="20" style="color:black;text-align:right" rows="1"OnChange="JavaScript:chkNum(this)"> 
</div><div class="w3-container w3-third">


<input type="checkbox"  id = "dep" name="dep" value="1">อื่นๆ
<input name="dept" type='text' class="w3-input"  id="dept"  size="20"  />
</div><div class="w3-container w3-third">

แผนก - ฝ่าย :

<select name="department_show" id="department_show" class="w3-input"   >
<option  value="ฝ่ายขาย">ฝ่ายขาย</option>
<option  value="ฝ่ายการตลาด">ฝ่ายการตลาด</option>

</select>

</div><div class="w3-container w3-third">
       ประเภทลูกค้า :
<select name="customer_typename" id="customer_typename" class="w3-input"   >
<option  value="">**โปรดเลือกประเภทลูกค้า**</option>
<option  value="ร้านขายยา">ร้านขายยา</option>
<option  value="ลูกค้าทั่วไป">ลูกค้าทั่วไป</option>
<option  value="โรงพยาบาล">โรงพยาบาล</option>

</select>


</div><div class="w3-container w3-third">
       หน่วยงาน :
<select name="company_name" id="company_name" class="w3-input"   >
<option  value="">**โปรดเลือกหน่วยงาน**</option>
<option  value="ฟาร์ ทริลเลี่ยน บจก.">ฟาร์ ทริลเลี่ยน บจก.</option>
<option  value="โนเบิล เมด บจก.">โนเบิล เมด บจก.</option>
<option  value="อื่นๆ">อื่นๆ</option>

</select>

</div><div class="w3-container w3-third">
       ประเภทงาน :
<select name="department_name" id="department_name" class="w3-input"   >
<option  value="Online">Online</option>
<option  value="Sale">Sale</option>

</select>

</div><div class="w3-container w3-third">
ชื่อผู้ติดต่อ  :
<input name="customer_name1"  class="w3-input" value="<?php echo $fetch1["delivery_name"]; ?>" type='text' id="customer_name1">

</div><div class="w3-container w3-third">
 ผู้รับสินค้า :
<input name="customer_contact"  class="w3-input" value="<?php echo $fetch1["delivery_name"]; ?>" type='text' id="customer_contact">

</div><div class="w3-container w3-third">

 เบอร์โทรลูกค้า :
<input name="customer_tel"  class="w3-input" value="<?php echo $fetch1["delivery_tel"]; ?>" type='text' id="customer_tel">

</div><div class="w3-container w3-third">
ชื่อโรงพยาบาล :
<input type='text'  class="w3-input" name="address_name" >             

 </div>
<div class="w3-container w3-third">	

  ที่อยู่ :
<textarea   class="w3-input" name="address_send" cols="54" rows="1"><?php echo $fetch1["delivery_address"]; ?></textarea>

</div>
<div class="w3-container w3-third">
เลขที่เอกสาร/เลขที่เครื่อง : 
<textarea name="product_sn"  class="w3-input" id="product_sn" cols="54" rows="1"></textarea>

</div>
<div class="w3-container w3-third">
สินค้า/เอกสาร :  
<textarea name="product"  class="w3-input" id="product"   cols="54" rows="1"><?php echo $fetch1["product_name1"]; echo $fetch1["product_name2"]; echo $fetch1["product_name3"]; echo $fetch1["product_name4"];  echo $fetch1["product_name5"]; echo $fetch1["product_name6"]; echo $fetch1["product_name7"]; echo $fetch1["product_name8"]; echo $fetch1["product_name9"];  echo $fetch1["product_name10"]; echo $fetch1["product_name11"]; echo $fetch1["product_name12"]; echo $fetch1["product_name13"]; echo $fetch1["product_name14"];  echo $fetch1["product_name15"]; ?></textarea>

</div>

<div class="w3-container w3-third">
รายละเอียดเพิ่มเติม : 
     <textarea name="description"  class="w3-input" id="description" cols="54" rows="1"></textarea>
</div>

<?php
if($fetch1["more"]=='0'){

?>

	<fieldset><legend><input type="checkbox" name="more" id="more" value="1"> <b>รายละเอียดการจัดส่ง</b></legend>
	<div id="more-2" style="display:none;">
		<div class="w3-third 112">
			<div class="w3-bar 1">
				<input type="checkbox" name="runway"id = "runway" value="1"> ติดถนนรันเวย์
			</div>
			<div class="w3-bar 2">
				<input type="checkbox" name="road"id = "road" value="1"> ติดถนนวิ่งสวนกัน
			</div>
			<div class="w3-bar 3">
				<input type="checkbox" name="soy"id = "soy" value="1"> เข้าซอย
			</div>
			<div class="w3-bar 4">
				ทางเข้ากว้าง
				<input name="soy_big" class="w3-input" type='text' id="soy_big" style="color:black;text-align:left;width:90%;" placeholder="(เมตร)" />
			</div>
			<div class="w3-bar 5">
				<input type="checkbox" name="height_ltd" id = "height_ltd" value="1"> มีตัวจำกัดความสูง
			</div>
			<div class="w3-bar 6">
				<input type="checkbox" name="car_load"id = "car_load" value="1"> รถยนต์สามารถเข้าได้
			</div>
			<div class="w3-bar 7">
				<input type="checkbox" name="no_car_road"id = "no_car_road" value="1"> รถยนต์เข้าไม่ได้ สามารถจอดได้ที่ <input name="car_park" class="w3-input" type='text' id="car_park" style="width:90%;" />
			</div>
			<div class="w3-bar 8">
				การจอดรถ
			</div>
			<div class="w3-bar 9">
				<input type="checkbox" name="car_road" id = "car_road" value="1"> จอดรถข้างถนน
			</div>
			<div class="w3-bar 10">
				<input type="checkbox" name="car_home"id = "car_home" value="1"> จอดรถหน้าบ้านได้
			</div>
			<div class="w3-bar 11">
				ประตูหน้าบ้านสูง
				<input name="door_long" class="w3-input" type='text' id="door_long" style="color:black;text-align:left;width:90%;" placeholder="(เมตร)" />
			</div>
			<div class="w3-bar 12">
				<input type="checkbox" name="slope"id = "slope" value="1"> มีทางราบก่อนประตูบ้าน
			</div>
			<div class="w3-bar 13">
				<input type="checkbox" name="bundai"id = "bundai" value="1"> มีบันไดก่อนประตูบ้าน
			</div>
			<div class="w3-bar 14">
				<input name="unit_bundai" class="w3-input" type='text' id="unit_bundai" style="width:90%;" placeholder="จำนวน (ขั้น)" />
			</div>
			<div class="w3-bar 15">
				ประตูบ้านกว้าง
				<input name="door_bigger" class="w3-input" type='text' id="door_bigger" style="width:90%;" placeholder="(เมตร)" />
			</div>
			<div class="w3-bar 16">
				ประตูสูง 
				<input name="door_longer" class="w3-input" type='text' id="door_longer" style="width:90%;" placeholder="(เมตร)" />
			</div>
			<div class="w3-bar 17">
				ประตูห้องกว้าง 
				<input name="room_bigger" class="w3-input" type='text' id="room_bigger" style="width:90%;" placeholder="(เมตร)" />
			</div>
			<div class="w3-bar 18">
				ประตูห้องสูง 
				<input name="room_longer" class="w3-input" type='text' id="room_longer" style="width:90%;" placeholder="(เมตร)" />
			</div>
		</div>
		<div class="w3-third 212">
			<div class="w3-bar 1">
				ประตูบ้านเป็นแบบ
				<input name="type_door" class="w3-input" type='text' id="type_door" style="width:90%;" />
			</div>
			<div class="w3-bar 2">
				พื้นบ้านเป็นแบบ
				<input name="home_type" class="w3-input" type='text' id="home_type" style="width:90%;" />
			</div>
			<div class="w3-bar 3">
				ติดตั้งที่ชั้น
				<input name="install" class="w3-input" type='text' id="install" style="width:90%;" />
			</div>
			<div class="w3-bar 4">
				<input type="checkbox" name="bundai_install"id ="bundai_install" value="1"> บันไดกว้าง
			</div>
			<div class="w3-bar 5">
				<input name="bundai_big" class="w3-input" type='text' id="bundai_big" style="width:90%;" placeholder="เมตร" />
			</div>
			<div class="w3-bar 6">
				หักมุมบันได
				<input name="bundai_hug" class="w3-input" type='text' id="bundai_hug" style="width:90%;" />
			</div>
			<div class="w3-bar 7">
				ชนิดของบันได
				<input name="type_bundai" class="w3-input" type='text' id="type_bundai" style="width:90%;" />
			</div>
			<div class="w3-bar 8">
				<input type="checkbox" name="lip"id = "lip" value="1"> ลิฟท์กว้าง
			</div>
			<div class="w3-bar 9">
				<input name="lip_big" class="w3-input" type='text' id="lip_big" style="width:90%;" placeholder="เมตร" />
			</div>
			<div class="w3-bar 10">
				สูง
				<input name="lip_long" class="w3-input" type='text' id="lip_long" style="width:90%;" placeholder="เมตร" />
			</div>
			<div class="w3-bar 11">
				รับน้ำหนักได้ 
				<input name="lip_weight" class="w3-input" type='text' id="lip_weight" style="width:90%;" />
			</div>
			
		</div>
		<div class="w3-third 312">
			<div class="w3-bar 12">
				<input type="checkbox" name="up"id ="up" value="1"> ขึ้นลิฟท์ได้
			</div>
			<div class="w3-bar 13">
				<input type="checkbox" name="no_up"id ="no_up" value="1"> ขึ้นลิฟท์ไม่ได้
			</div>
			<div class="w3-bar 14">
				<input type="checkbox" name="head_bad"id ="head_bad" value="1"> ต้องถอดหัวเตียง-ท้ายเตียง
			</div>
			<div class="w3-bar 15">
				<input type="checkbox" name="want_employee"id ="want_employee" value="1"> ต้องการเจ้าหน้าที่ย้ายเฟอร์นิเจอร์
			</div>
			<div class="w3-bar 16">
				จำนวนคนที่ใช้ 
				<input name="employee_unit" class="w3-input" type='text' id="employee_unit" style="width:90%;" />
			</div>
			<div class="w3-bar 17">
				ย้ายเฟอร์นิเจอร์ 
				<input name="ferniger_name" class="w3-input" type='text' id="ferniger_name" style="width:90%;" />
			</div>
			<div class="w3-bar 18">
				ย้ายไปที่ 
				<input name="ferniger_address" class="w3-input" type='text' id="ferniger_address" style="width:90%;" />
			</div>
			<div class="w3-bar">
				<input type="checkbox" name="want_ex"id = "want_ex" value="1"> ต้องเตรียมอุปกรณ์ไปถอดประกอบ
			</div>
			<div class="w3-bar">
				<input type="checkbox" name="want_credit"id = "want_credit" value="1"> ต้องเตรียมเครื่องรูดบัตร
			</div>
			<div class="w3-bar">
				ธนาคาร 
				<input name="bank" class="w3-input" type='text' id="bank" style="width:90%;" />
			</div>
			<div class="w3-bar">
				<input type="checkbox" name="want_prem"id ="want_prem" value="1"> ต้องการให้เตรียมฟรีมยืดไปซิวเก็บเตียงหรือที่นอนเก่า
			</div>
			<div class="w3-bar">
				รายละเอียดเพิ่มเติม
				<textarea name="description_ja" class="w3-input" id="description_ja" cols="54" rows="1" style="width:90%;"></textarea>
			</div>
		</div>
	</div>
	</fieldset>


<?php
}else if ($fetch1["more"]=='1'){
		?>

<?php
				$sql2 = "select * from tb_transaction where deposit_id = '".$_GET["deposit_code"]."'";
				$query2 = mysqli_query($conn,$sql2);
				$fetch2 = mysqli_fetch_array($query2,MYSQLI_ASSOC); ?>






<fieldset><legend><input type="checkbox" name="more" id="more" value="1" checked="checked"> <b>รายละเอียดการจัดส่ง</b></legend>

		<div class="w3-third 112">
			<div class="w3-bar 1">
<input type='hidden' value ="<?php echo $fetch2["id"]; ?>" class="w3-input" name="id" > 

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

</div><!-- cs -->

<center>
<input type="submit" name="submit" class="w3-button w3-teal" >
</center>

</div></div> </div>
</form>
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