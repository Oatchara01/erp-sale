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

	 ?>


<body>

	<form action='register_supqou_edit1.php' method="post" name="frmMain" enctype="multipart/form-data">
	<div class="w3-white">
		<div class="w3-container w3-padding-large"><!-- main div -->
			<div class="w3-panel w3-light-gray">
				<div class="w3-half">
				<h4>Register Data</h4>
			</div><div class="w3-half">
				
				<?php if($objResult["status_doc"]=='Approve'){  ?>
				
			<a href="formnb_qou.php?ref_id=<?php echo $objResult["ref_id"];?>" class="w3-button w3-grey w3-right"><font color="FF0099">Print ใบเสนอราคา</font></a>	
	<?php  
															 }
				?>
				
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

			</div>
			<div class="w3-padding-small"></div>
				<div class="w3-bar">
					วันที่ : <span class="w3-light-grey"><?php echo DateThai($objResult["register_date"]); ?></span>  | เลขที่อ้างอิง : <span  ><?php echo $objResult["ref_id"]; ?></span> 
					<input name="ref_id" id="ref_id" class="w3-input" value="<?php echo $objResult["ref_id"] ?>"  type="hidden" style="width:90%;">
				</div>
			<div class="w3-padding-small"></div>
				<div class="w3-bar">
			เรียน :
<input type="text" name="cus_name"  class="w3-input" value="<?php echo $objResult["cus_name"] ?>" id="cus_name"  style="width:90%;">
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
  <select name="payment_dead" id="payment_dead" class="w3-input" style="width:90%">
    <option value="">**Please Select Item**</option>
    <?php
      $strSQL5 = "select * from qou__cash order by cash_id ";
      $objQuery5 = mysqli_query($conn,$strSQL5);
      if (!$objQuery5) {
        echo "Failed to fetch to MySQL: " . mysqli_error($conn);
      }
      while ($objResuut5 = mysqli_fetch_array($objQuery5,MYSQLI_ASSOC)) {
	  if($objResult["payment_dead"] == $objResuut5["cash_name"])
		{
		$sel = "selected";
		}
		else
		{
		$sel = "";
		}
	  
    ?>
    <option class="w3-bar-item w3-button" value="<?php echo $objResuut5['cash_name']; ?>"<?php echo $sel;?>><?php echo $objResuut5['cash_name']; ?></option>
    <?php } ?>
  </select>
 <input name="payment_dead_other_wrap" id="payment_dead_other_wrap" value="<?php echo $objResult["payment_dead_other_wrap"] ?>" style="width:90%" class="w3-input" placeholder="ระบุเงื่อนไขการชำระเงิน...">


  กำหนดยืนราคา :
  <!-- แก้ type ให้ถูกต้อง -->
  <input name="set_price" id="set_price" class="w3-input" value="<?php echo $objResult["set_price"] ?>" style="width:90%" type="date">

  กำหนดส่งสินค้า :
  <select name="delivery_dead" id="delivery_dead" class="w3-input" style="width:90%">
    <option value="">**Please Select Item**</option>
    <?php
      $strSQL5 = "select * from qou__delivery order by delivery_id ";
      $objQuery5 = mysqli_query($conn,$strSQL5);
      if (!$objQuery5) {
        echo "Failed to fetch to MySQL: " . mysqli_error($conn);
      }
      while ($objResuut5 = mysqli_fetch_array($objQuery5,MYSQLI_ASSOC)) {
		  
	  if($objResult["delivery_dead"] == $objResuut5["delivery_name"])
		{
		$sel = "selected";
		}
		else
		{
		$sel = "";
		}	  
    ?>
      <option class="w3-bar-item w3-button" value="<?php echo $objResuut5['delivery_name']; ?>" <?php echo $sel;?>>
        <?php echo $objResuut5['delivery_name']; ?>
      </option>
    <?php } ?>
  </select>

  <!-- ช่องวันที่ เมื่อเลือก “เลือกวันที่” -->
 
    <input type="date" name="delivery_date" value="<?php echo $objResult["delivery_date"] ?>" id="delivery_date" style="width:90%" class="w3-input">
 

  รับประกันสินค้า :
  <select name="waranty" id="waranty" class="w3-input" style="width:90%">
    <option value="">**Please Select Item**</option>
    <?php
      $strSQL5 = "select * from qou__warranty order by warranty_id ";
      $objQuery5 = mysqli_query($conn,$strSQL5);
      if (!$objQuery5) {
        echo "Failed to fetch to MySQL: " . mysqli_error($conn);
      }
      while ($objResuut5 = mysqli_fetch_array($objQuery5,MYSQLI_ASSOC)) {
		  
	  if($objResult["waranty"] == $objResuut5["warranty_name"])
		{
		$sel = "selected";
		}
		else
		{
		$sel = "";
		}	  	  
		  
    ?>
      <option class="w3-bar-item w3-button" value="<?php echo $objResuut5['warranty_name']; ?>" <?php echo $sel;?>>
        <?php echo $objResuut5['warranty_name']; ?>
      </option>
    <?php } ?>
  </select>

	
	<br>
	<input name="speck" id="speck" class="w3-input" value="<?php echo $objResult["speck"] ?>"  type="hidden" style="width:90%;">
	<input name="catalog" id="catalog" class="w3-input" value="<?php echo $objResult["catalog"] ?>"  type="hidden" style="width:90%;">
	<input name="picture" id="picture" class="w3-input" value="<?php echo $objResult["picture"] ?>"  type="hidden" style="width:90%;">
	แนบ Speck :<br>
<input name="speck"  type="file"><a href="qou/<?php echo $objResult['speck']; ?>" target="_blank"><?php echo $objResult['speck']; ?></a><br>
	แนบ Catalog :<br>
<input name="catalog"  type="file"><a href="qou/<?php echo $objResult['catalog']; ?>" target="_blank"><?php echo $objResult['catalog']; ?></a><br>
	แนบรูปภาพ :<br>
<input name="picture"  type="file"><a href="qou/<?php echo $objResult['picture']; ?>" target="_blank"><?php echo $objResult['picture']; ?></a>
	
	

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

<div class="w3-bar w3-light-grey w3-border">
 <a class="w3-bar-item w3-button" onclick="openCity1('pd')"><font color="#404040"><b>รายการสินค้า</b></font></a>
</div>


<div id="pd" class="w3-container city1">

<?php 

$strSQL1 = "SELECT * FROM (qou__sbmain LEFT JOIN tb_product ON qou__sbmain.product_ID=tb_product.product_id) WHERE ref_idd = '".$_GET["ref_id"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

?>

<table width="100%" border="0" class="w3-table">
<thead>

    <th>รหัสสินค้า</th>
    <th>ชื่อสินค้า</th>
    <th>หน่วย</th>
    <th>จำนวน</th>
    <th>ราคาต่อหน่วย</th>
	<th>ส่วนลด/หน่วย</th>
    <th>ยอดรวม</th>
	
</thead>


<?php
$i = 1;


while($objResult1 = mysqli_fetch_array($objQuery1))
{
?>

<tr>

<td style="width:15%;">
<input type='hidden' name = "id[]" value="<?php echo $objResult1["id"];?>" id = "id[]"    size='16' readonly/>
<input type='hidden' name = "product_id[]" value="<?php echo $objResult1["product_id"];?>" id = "product_id[]"    size='16' readonly/>
 <input type='text' name = "product_code[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["sol_code"];?>" id = "product_code[]<?php echo $objResult1["id"];?>"  class="w3-input"    size='16' readonly/>  


</td>


<td style="width:15%;"><teaxarea name = "product_name[]<?php echo $objResult1["id"];?>" id = "product_name[]<?php echo $objResult1["id"];?>" style="color:black;text-align:left" class="w3-input" readonly><?php echo $objResult1["sol_name"];?></teaxarea></td>	
	
	

<td><input type='text' name = "unit_name[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["unit_name"];?>" id = "unit_name[]<?php echo $objResult1["id"];?>"  class="w3-input"    size='9' readonly/></td>

<td><input type='text' name = "sale_count[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["count"];?>" id = "sale_count[]<?php echo $objResult1["id"];?>"  class="w3-input" style="color:black;text-align:center"   size='7' /></td>

<td><input type='text' name = "product_price[]<?php echo $objResult1["id"];?>" value="<?php $price_per_unit= $objResult1["price"]; echo number_format( $price_per_unit,2)."";?>" id = "product_price[]<?php echo $objResult1["id"];?>"  class="w3-input"  style="color:black;text-align:right"   /></td>

<td><input type='text' name = "discount_unit[]<?php echo $objResult1["id"];?>" value="<?php $discount_unit= $objResult1["discount"]; echo number_format( $discount_unit,2)."";?>" id = "discount_unit[]<?php echo $objResult1["id"];?>"  class="w3-input"  style="color:black;text-align:right"   /></td>


<td><input type='text' name = "sum_amount[]<?php echo $objResult1["id"];?>" value="<?php  $sum_amount=$objResult1["amount"]; echo number_format( $sum_amount,2)."";?>" id = "sum_amount[]<?php echo $objResult1["id"];?>"  class="w3-input" style="color:black;text-align:right"    readonly/></td>

<td><a href="product_qoudel.php?ref_id=<?php echo $objResult["ref_id"];?>&id=<?php echo $objResult1["id"];?>"><img src="img/false.png" width="16" height="16" border="0" /></a></td>


</tr>

<?
	$i++;

}

?>

</table>

<?php
	
	if($objResult["type_doc"]=='1'){
	 include "register_qou_detail1.php";
	}else if($objResult["type_doc"]=='2'){
		
	include "register_qou_detailnb1.php";	
	}
	
	?>
	

</div> 

<center>
	
<input type="submit" name="submit" class="w3-button w3-teal" >
	
</center>


</form></div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>		

  
  <!--/div-->

  
  

</body>
</html>

