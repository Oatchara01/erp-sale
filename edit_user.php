<?php 


include('head.php');

 
 
 ?>


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


<body>
<form   method="post" name="frmMain" enctype="multipart/form-data" >

<?php
		$strSQL = "SELECT *  FROM tb_user WHERE id = '".$_GET["id"]."' ";


		$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
		$objResult = mysqli_fetch_array($objQuery);
	?>
<div class="w3-white">
<div class="w3-panel w3-light-gray"><h4>ADD : USER</h4></div>

<div class=" w3-container w3-half">

รหัสพนักงาน
<input name="em_id" value ="<?php  echo $objResult["em_id"];?>" class="w3-input" >
<input type = "hidden" name="id" value ="<?php  echo $objResult["id"];?>" class="w3-input" >

</div><div class=" w3-container w3-half">


User ใช้งาน
<input name="user_id" class="w3-input" value ="<?php  echo $objResult["user_id"];?>">
</div><div class=" w3-container w3-half">

 รหัสผ่าน
<input name="pass" class="w3-input" value ="<?php  echo $objResult["pass"];?>">
</div><div class=" w3-container w3-half">

ชื่อพนักงาน
<input name="name" class="w3-input" value ="<?php  echo $objResult["name"];?>">

</div><div class=" w3-container w3-half">
นามสกุลพนักงาน
<input name="surname" class="w3-input" value ="<?php  echo $objResult["surname"];?>">



</div><div class=" w3-container w3-half">

ตำแหน่ง
<input name="position" class="w3-input" value ="<?php  echo $objResult["position"];?>">
</div><div class=" w3-container w3-half">

อีเมลล์
<input name="mail_intra" class="w3-input" value ="<?php  echo $objResult["mail_intra"];?>">
</div><div class=" w3-container w3-half">

เบอร์โต๊ะ
<input name="ext" class="w3-input" value ="<?php  echo $objResult["ext"];?>">
</div><div class=" w3-container w3-half">

เบอร์โทรศัพท์
<input name="employee_tel" class="w3-input" value ="<?php  echo $objResult["employee_tel"];?>">
</div><div class=" w3-container w3-half">

แผนก
<input name="department" class="w3-input" value ="<?php  echo $objResult["department"];?>">
</div><div class=" w3-container w3-half">

รหัส
<input name="code" class="w3-input" value ="<?php  echo $objResult["code"];?>">
</div>
<div class=" w3-container w3-half">

ประเภทการ Login
<input name="type_login" class="w3-input" value ="<?php  echo $objResult["type_login"];?>">

</div>




<br>
<center>
		  <input type="button" name ="Submit" value="บันทึก" class = "button button4" onClick="this.form.action='edit_user1.php'; submit()">
</center>

</p>

</div>

<div id="cr_bar"><?php include "foot.php"; ?></div>

</form>

</body>
</html>


