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

<?php

$strSQL = "SELECT *  FROM qou__main WHERE ref_id = '".$_GET['ref_id']."' ";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);

$yearMonth = substr(date("Y")+543, -2).date("m");
$sql = "SELECT MAX(ref_id) AS MAXID FROM qou__main where type_doc ='".$objResult["type_doc"]."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);
$maxId = substr($rs['MAXID'], -4);
$maxId3 = substr($rs['MAXID'],-8);

$maxId1 = substr($maxId3,0,-4);
 if($objResult["type_doc"]=='1'){ 
 $so = "AWL";
 }else if($objResult["type_doc"]=='2'){ 
$so = "NBM";	
 } 



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


<body>

	<form action='register_qou_create1.php' method="post" name="frmMain" enctype="multipart/form-data">
	<div class="w3-white">
		<div class="w3-container w3-padding-large"><!-- main div -->
			<div class="w3-panel w3-light-gray">
				<div class="w3-half">
				<h4>Register Data</h4>
			</div><div class="w3-half">
				
		</div></div>
		<div class="w3-third"><!-- first half -->
			<div class="w3-bar w3-border">
				<?php if($objResult["type_doc"]=='1'){ ?>
<div class="w3-button"><input type="radio" checked='checked' name="type_doc"  value="1" id="type_doc">&nbsp; AWL</div>
<div class="w3-button"><input type="radio"  name="type_doc"  value="2" id="type_doc">&nbsp; NBM</div>
				<?php }else if($objResult["type_doc"]=='2'){ ?>
	<div class="w3-button"><input type="radio"  name="type_doc"  value="1" id="type_doc">&nbsp; AWL</div>
<div class="w3-button"><input type="radio" checked='checked' name="type_doc"  value="2" id="type_doc">&nbsp; NBM</div>			
				<?php } ?>
<br>
			<div class="w3-button">
	<?php if($objResult["type_head"]=='1'){ ?>
	<input type="radio"  name="type_head"  checked='checked' value="1" id="type_head" required>&nbsp; สินค้าขาย
	<input type="radio"  name="type_head"  value="2" id="type_head" required>&nbsp; สินค้าเช่า
	<?php }else if($objResult["type_head"]=='2'){ ?>
	<input type="radio"  name="type_head"  value="1" id="type_head" required>&nbsp; สินค้าขาย
	<input type="radio"  name="type_head" checked='checked'  value="2" id="type_head" required>&nbsp; สินค้าเช่า
		<?php }else{ ?>
	<input type="radio"  name="type_head"  value="1" id="type_head" required>&nbsp; สินค้าขาย
	<input type="radio"  name="type_head"   value="2" id="type_head" required>&nbsp; สินค้าเช่า		
	<?php } ?>
				</div></div>
			<div class="w3-padding-small"></div>
				<div class="w3-bar">
					วันที่ : <span class="w3-light-grey"><?php echo DateThai($objResult["register_date"]); ?></span>  | เลขที่อ้างอิง : <span  ><?php echo "$so$nextId"; ?></span> 
					<input name="ref_id" id="ref_id" class="w3-input" value="<?php echo "$so$nextId"; ?>"  type="hidden" style="width:90%;">
				</div>
			<div class="w3-padding-small"></div>
				<div class="w3-bar">
			เรียน :
<textarea name="cus_name"  class="w3-input" id="cus_name"  style="width:90%;"><?php echo $objResult["cus_name"] ?></textarea>
		</div>	
			
			เบอร์โทรพนักงาน :
	<input name="iv_no" id="iv_no" class="w3-input" value="<?php echo $objResult["iv_no"] ?>"  type="text" style="width:90%;">
			
			
	<input name="iv_date" id="iv_date" class="w3-input" value="<?php echo $objResult["iv_date"] ?>" type="hidden" style="width:90%;">
			
					E-mail to :
	<input name="cusmail_name" id="cusmail_name" value="<?php echo $objResult["cusmail_name"] ?>" class="w3-input" placeholder="ชื่อผู้รับ"  type="text" style="width:90%;">
			
					E-mail Address :
	<input name="email" id="email" class="w3-input" value="<?php echo $objResult["email"] ?>" placeholder="E-mail Address"  type="text" style="width:90%;">
				
หมายเหตุ:
<textarea name="description"  class="w3-input" id="description" style="width:90%;"  rows="2"><?php echo $objResult["description"] ?></textarea>
<div class="w3-padding-small"></div>

</div>

<div class="w3-twothird w3-container"><!-- second half -->
<div class="w3-bar w3-light-grey w3-border">
  <a class="w3-button"  onclick="openCity('so')"><font color="404040"><b>รายละเอียดเพิ่มเติม</b></font></a>

</div>
</br>

<div id="so" class="city" >
<div class="w3-half w3-container"><!-- first so half -->
	
	กำหนดเวลาชำระเงิน :
	<input name="payment_dead" id="payment_dead" value="<?php echo $objResult["payment_dead"] ?>"  class="w3-input" placeholder="จำนวนวัน,เงินสด" type="text" style="width:90%;">
	
	กำหนดยืนราคา :
	<input name="set_price" id="set_price" class="w3-input" value="<?php echo $objResult["set_price"] ?>"  type="text" style="width:90%;">
	
	กำหนดส่งสินค้า :
	<input name="delivery_dead" id="delivery_dead" class="w3-input" value="<?php echo $objResult["delivery_dead"] ?>"  type="text" style="width:90%;">
	
	รับประกันสินค้า :
	<input name="waranty" id="waranty" class="w3-input" value="<?php echo $objResult["waranty"] ?>"  type="text" style="width:90%;">
	<?php if($objResult["waranty_ckk"]=='1'){ ?>
	<input name="waranty_ckk" id="waranty_ckk" checked='checked' value='1' type="checkbox" > <font color='blue' >รับประกันอุปกรณ์ที่เกี่ยวข้องกับระบบไฟฟ้าและมอเตอร์ 2 ปี </font>
	<?php }else{ ?>
	<input name="waranty_ckk" id="waranty_ckk"  value='1' type="checkbox" > <font color='blue' >รับประกันอุปกรณ์ที่เกี่ยวข้องกับระบบไฟฟ้าและมอเตอร์ 2 ปี </font>
	<?php } ?>
	<br>
	<input name="speck" id="speck" class="w3-input" value="<?php echo $objResult["speck"] ?>"  type="hidden" style="width:90%;">
	<input name="catalog" id="catalog" class="w3-input" value="<?php echo $objResult["catalog"] ?>"  type="hidden" style="width:90%;">
	<input name="picture" id="picture" class="w3-input" value="<?php echo $objResult["picture"] ?>"  type="hidden" style="width:90%;">
	แนบ Speck :<br>
<input name="speck"  type="file"><br>
	แนบ Catalog :<br>
<input name="catalog"  type="file"><br>
	แนบรูปภาพ :<br>
<input name="picture"  type="file">
	
	

</div>
</div><!-- close so first half -->

<div class="w3-half w3-container "><!-- so second half -->
	<?php if($objResult["remark_ckk"]=='1'){ ?>
	<input name="remark_ckk" id="remark_ckk"  value='1' checked='checked'  type="checkbox" >
	<?php }else{ ?>
	<input name="remark_ckk" id="remark_ckk"  value='1'  type="checkbox" >
	<?php } ?>
	
	หมายเหตุ:<br>
	1.
<textarea name="remark1"  class="w3-input" id="remark1" style="width:90%;"  rows="2"><?php echo $objResult["remark1"] ?></textarea>
	2.
<textarea name="remark2"  class="w3-input" id="remark2" style="width:90%;"  rows="2"><?php echo $objResult["remark2"] ?></textarea>
	3.
<textarea name="remark3"  class="w3-input" id="remark3" style="width:90%;"  rows="2"><?php echo $objResult["remark3"] ?></textarea>
	4.
<textarea name="remark4"  class="w3-input" id="remark4" style="width:90%;"  rows="2"><?php echo $objResult["remark4"] ?></textarea>
	5.
<textarea name="remark5"  class="w3-input" id="remark5" style="width:90%;"  rows="2"><?php echo $objResult["remark5"] ?></textarea>

</div><!-- close so -->


	
<div class="w3-padding-small"></div>






</div><!--third third -->
</div><!-- close more -->
<!-- close second half -->
<div class="w3-bar w3-light-grey w3-border">
 <a class="w3-bar-item w3-button" onclick="openCity1('pd')"><font color="#404040"><b>รายการสินค้า</b></font></a>
</div>


<div id="pd" class="w3-container city1">


<?php
	
	if($objResult["type_doc"]=='1'){
	 include "register_qou_detail.php";
	}else if($objResult["type_doc"]=='2'){
		
	include "register_qou_detailnb.php";	
	}
	
	?>
	

</div> 

<center>
	
<input type="submit" name="submit" class="w3-button w3-teal" >
	
</center><br>

 </div> </div>
</form>
<div id="cr_bar"> <?php include "foot.php"; ?></div>		
 
  <!--/div-->

  
  

</body>
</html>

