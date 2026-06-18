<?php include "dbconnect.php"; ?>
<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sale Online</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/w3.css">
<link rel="stylesheet" href="css/tab.css">
<link rel="stylesheet" href="awesome/css/all.css">
<script type="text/javascript" src="js/w3open.js"></script>
<script type="text/javascript" src="js/tab.js"></script>
<script type="text/javascript" src="js/ready.js"></script>
<script type="text/javascript" src="js/table.js"></script>
<script src="js/jquery-3.4.1.min.js" type="text/javascript"></script>
<script type="text/javascript" src="dist/jautocalc.js"></script>

<script> //tab
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

function getText3(){
      var in1=document.getElementById('in1').value;
      var in2=document.getElementById('in2').value;
      var in3=in1+in2;
      document.getElementById('in3').value=in3;
   }

function openCity(cityName) {
  var i;
  var x = document.getElementsByClassName("city");
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";  
  }
  document.getElementById(cityName).style.display = "block";  
}

function openCity1(cityName) {
  var i;
  var x = document.getElementsByClassName("city1");
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";  
  }
  document.getElementById(cityName).style.display = "block";  
}
</script>
</head>
<body>
<?php include('head.php'); ?>
  
    <div id="header">
    <div id="site_title">
      <h1><a href="#"></a></h1>
      <!-- end of site_title -->
    </div>  
   

  <div id=""> 
  <div class="w3-container w3-padding-large">


<?php
$sql1 = "select * from so__main order by main_id desc limit 1";
$query1 = mysqli_query($conn,$sql1);
$fetch1 = mysqli_fetch_array($query1,MYSQLI_ASSOC); ?>


<h2><span class="style15">Register Data</span></h2>

<form action="save_register.php" method="post" name="frmMain" >
<div id="1st half" class="w3-container w3-half">
<input type="checkbox" name="select_br_ptl" value="1">&nbsp;ใบยืมสินค้า PTL 
<input type="checkbox" name="select_br_nbm" value="1">&nbsp;ใบยืมสินค้า NBM
<input type="checkbox" name="select_so_ptl" value="1">&nbsp;ใบสั่งขาย PTL
<input type="checkbox" name="select_so_nbm" value="1">&nbsp;ใบสั่งขาย NBM
</p>

วันที่: <?php echo date("d/m/Y"); ?> &nbsp;&nbsp;เลขที่อ้างอิง:&nbsp;<input type="text" name="ref_id" value="<?php echo $fetch1['ref_id']+1; ?>"> <input type="text" name="main_id" value="<?php echo $fetch1['main_id']+1; ?>" hidden> </p>
ช่องทางการขาย</p>
<select name="sale_channel" id="sale_channel" class="buttonn button4"  style="width:100%" onchange="showUser(this.value)">
<option  value="">**โปรดเลือกช่องทางการขาย**</option>
<?php
$sqlchannel = "select * from tb_salechannel order by salechannel_ID";
$querychannel = mysqli_query($conn,$sqlchannel);
while ($fetchchannel = mysqli_fetch_array($querychannel,MYSQLI_ASSOC)) { ?>
<option class="w3-bar-item w3-button" value="<?php echo $fetchchannel['salechannel_ID']; ?>"><?php echo $fetchchannel['salechannel_nameshort']; ?>&nbsp;&nbsp;<?php echo $fetchchannel['description_chanel']; ?></option>
<?php } ?>
</select>
<br>
การจัดส่ง</p>
<select name="delivery" class="buttonn button4"  style="width:100%">
<option value="">**Please Select Item**</option>

<?php
$sqldeli = "SELECT tb_delivery.*,tb_sender.* FROM tb_delivery LEFT JOIN tb_sender ON tb_delivery.employee_send=tb_sender.sender_ID";
$querydeli = mysqli_query($conn,$sqldeli);
if (!$querydeli) {
	echo "Failed to fetch to MySQL: " . mysqli_error();
}
while ($fetchdeli = mysqli_fetch_array($querydeli,MYSQLI_ASSOC)) {
?>
<option class="w3-bar-item w3-button" value="<?php echo $fetchdeli['delivery_ID'];?>"><?php echo $fetchdeli['sender_name'];?> : <?php echo $fetchdeli['time_send']; ?> : <?php echo $fetchdeli['description_send']; ?><?php echo $fetchdeli['description_wrap'];?></option>
<?php } ?>
</select>
<br>
การชำระเงิน:</p>
<select name="payment" class="buttonn button4"  style="width:100%">
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
</select>
</p>
หมายเหตุ:</p>
<textarea name="sale_remark"  class="button4" id="sale_remark" style="width:100%" rows="2"></textarea></p>
<br>
ชื่อพนักงาน:
<select  name="employee_name" class="buttonn button4"  style="width:100%">
<option value="">**Please Select Item**</option>

<?php
$emp = "select * from tb_employee where status=1 order by employee_ID";
$sqlemp = mysqli_query($conn,$emp);
while ($fetchemp = mysqli_fetch_array($sqlemp,MYSQLI_ASSOC)) { ?>
<option class="w3-bar-item w3-button" value="<?php echo $fetchemp['employee_ID']; ?>"><?php echo $fetchemp['employee_name']; ?></option>
<?php } ?>
</select>
<!-- 1st half -->
</div><!--close 1st half -->

<div id="2nd half" class="w3-container w3-half">
<div class="w3-bar w3-light-grey">
  <a class="w3-bar-item w3-button"  onclick="openCity('br')"><font color="#FF0000"><b>ใบยืมสินค้า</b></font></a>
  <a class="w3-bar-item w3-button" onclick="openCity('so')"><font color="#228B22"><b>ใบสั่งขาย</b></font></a>
  <a class="w3-bar-item w3-button" onclick="openCity('mo')"><font color="#FF4500"><b>เพิ่มเติม</b></font></a>
</div>


</br>
<div id="br" class="city">
<div id="txtHint"></div>
</div><!-- close br -->
</br>


<div id="so" class="w3-container city w3-half" style="display:none">
ชื่อที่ออกบิล:</p>
<input name="billing_name" type='text' class="button4" style="width:100%"></p>
ทีอยู่ที่ออกบิล:
<textarea name="billing_address" class="button4" style="width:100%"></textarea></p>
Tel.:</p>
<input type="text" name="billing_tel" class="button4" style="width:100%"></p>

<input type="checkbox" name="bill_vat" value="1"> &nbsp;บิล VAT</p>
การชำระเงิน
<select name="payment" class="buttonn button4" style="width:40%" disabled>
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
</select>


การโอนเงิน
<select name="transfer" class="buttonn button4" style="width:40%" >

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

</select></p>

ส่งบัญชีตรวจสอบ
<input type="checkbox" name="account_approve" value="1"></p>
วันที่โอน
<input type="date" name="transfer_date" id="transfer_date" class="buttonn button4" style="width:35%">
จำนวนเงินโอน/เก็บปลายทาง
<input type="text" name="amount" class="button4" style="width:35%">
</br> </br></br>

<div id="2nd so half" class="w3-half">
<h4 ><font color="#FF0000"><b>ใช้สำหรับจ่าหน้าพัสดุเท่านั้น</b></font></h4>
ชื่อผู้รับสินค้า
<input name="delivery_name" type="text" class="buttonn button4" style="width:100%">
ที่อยู่ในการจัดส่ง
<input name="address1" class="button4" type="text" style="width:100%">
<input name="address2" class="button4" type="text" style="width:100%">
จังหวัด
<select name="province" class="buttonn button4" style="width:100%">
<option class="w3-bar" value=""></option>
<?php
$province="select * from tb_province order by province_name";
$prosql=mysqli_query($conn,$province);
while ($fepro=mysqli_fetch_array($prosql)) { ?>
<option class="w3-bar" value="<?php echo $fepro["province_ID"]; ?>"><?php echo $fepro["province_name"]; ?></option>
<?php } ?>
</select>
รหัสไปรษณีย์
<input name="postcode" type="text" class="button4" style="width:100%">
โทรศัพท์
<input name="tel" type="text" class="button4" style="width:100%">
</div><!-- close so -->



<div id="mo" class="w3-container city" style="display:none">
ชื่อผู้แนะนำ</p>
<input name="prefer_name" class="button4" style="width:100%"></p>
ใบสั่งซื้อเลขที่
</p><input name="order_no" class="button4" style="width:100%"></p>
กำหนดส่งตามสัญญา:</p>
<input name="delivery_contract" class="button4" style="width:100%"></p>
เคลียร์ใบจอง:</p>
<input name="clear_book_no" class="button4" placeholder="เลขที่" style="width:100%"></p>
เคลียร์ใบยืม BRN:</p>
<input name="clear_brn_no" class="button4" placeholder="เลขที่" style="width:100%"></p>
เคลียร์ใบยืม BRNP:</p>
<input name="clear_brnp_no" class="button4" placeholder="เลขที่" style="width:100%"></p>

ต้องการ SN:</p>
<input name="sn" class="button4" style="width:100%"></p>
BQ เลขที่:</p>
<input name="bq" class="button4" style="width:100%"></p>
OT เลขที่:</p>
<input name="ot" class="button4" style="width:100%"></p>
รับประกัน (ปี)</p>
<input name="warranty" class="button4" style="width:100%"></p>
Cal (ครั้ง/ปี)</p>
<input name="cal" class="button4" style="width:100%"></p>
PM (ครั้ง/ปี)</p>
<input name="pm" class="button4" style="width:100%"></p>

สถานที่ติดตั้งเครื่อง
<input name="install_place" class="button4" style="width:100%"><br />
<input name="with_pr" type="checkbox" value="1">
แนบใบเสนอราคา<br />
<input type="checkbox" name="type_com" value="1">
พิมพ์ตามคอม<br />
<input type="checkbox" name="type_po" value="1">
พิมพ์ตามใบสั่งซื้อ<br />
<input type="checkbox" name="type_type" value="1">
พิมพ์ตามที่เขียน<br />
ระบุ:
<textarea name="type_type_detail" class="button4" style="resize: none;width:100%"></textarea>
</div><!-- close more -->
</br>
</div><!-- close 2nd half -->

<div class="w3-bar w3-light-grey">
  <a class="w3-bar-item w3-button" onclick="openCity1('pd')"><font color="magenta"><b>รายการสินค้า</b></font></a>
  <a class="w3-bar-item w3-button" onclick="openCity1('cs')"><font color="blue"><b>รายละเอียดการจัดส่ง</b></font></a>
  <a class="w3-bar-item w3-button" onclick="openCity1('ot')"><font color="purple"><b>ปิดงาน</b></font></a>
</div>


<div id="pd" class="w3-container city1">

<?php include ('test_cal2.php')?>

</div>

<div id="cs" class="w3-container city1" style="display:none">
<input type="checkbox" name="" hidden><br \>
วันที่ส่ง

<input type="date" name="delivery_date" class="button4" style="width:100%">
เวลาส่ง
<input type="text" name="delivery_time" class="button4" style="width:100%">
การส่งสินค้า<br>
<input type="checkbox" name="delivery_company" value="1">&nbsp;บริษัทจัดส่ง<br />
<input type="checkbox" name="big_car" value="1">&nbsp;ต้องการรถใหญ่<br />
<input type="checkbox" name="call_before" value="1">&nbsp;โทรแจ้งลูกค้าก่อนไป<br />
<input type="checkbox" name="maps" value="1">&nbsp;มีแผนที่ประกอบ<br />
<input type="checkbox" name="assign_date_time" value="1">&nbsp;นัดวันเวลาเรียบร้อยแล้ว<br />

<input type="checkbox" name="delivery_sale" value="1">&nbsp;Sale รับเอง
<input type="checkbox" name="delivery_engineer" value="1">&nbsp;ช่างรับเอง
<input type="checkbox" name="delivery_customer" value="1">&nbsp;ลูกค้ารับเอง <br />
สถานที่ส่งสินค้า:
<textarea name="delivery_place" class="button4" cols="20" rows="1" style="width:100%;resize: none" ></textarea>
ชื่อผู้ติดต่อ/TEL.:
<input type="text" name="delivery_contact" class="button4" style="width:100%">

<input type="checkbox" name="return" value="1">&nbsp;รับคืนสินค้า<br>
วันที่รับคืน
<input type="text" name="return_date" class="button4" style="width:100%">
เวลา
<input type="text" name="return_time" class="button4" style="width:100%">
ที่อยู่รับคืนสินค้า:
<input type="text" name="return_address" class="button4" style="width:100%">
ชื่อผู้ติดต่อ/TEL.:
<input type="text" name="return_contact" class="button4" style="width:100%">

</br></br>
<button name="br_ptl" action="" class="w3-button">ใบยืม PTL</button>
<button name="so_ptl" action="" class="w3-button">ใบสั่งขาย PTL</button></br>
<button name="br_nbm" action="" class="w3-button">ใบยืม NBM</button>
<button name="so_nbm" action="" class="w3-button">ใบสั่งขาย NBM</button></br>


</div>
</br></br>

<center>
<input type="submit" name="submit" class="button button4" >
</center>


</form>
  </div>
  </div>

  
  <div id="cr_bar"> Copyright © 2018 phar trillion co., ltd. </div>
   </div>
</body>
</html>