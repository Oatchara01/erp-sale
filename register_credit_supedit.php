<?php include ("head.php"); ?>
<?php include('dbconnect_sale.php'); ?>

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

<body>
<?php

$ref_credit =$_GET["ref_credit"];

$sql = "SELECT *   FROM tb_credit_note where ref_credit = '".$ref_credit."'";
$qry = mysqli_query($conn,$sql) or die(mysqli_error());
$rs = mysqli_fetch_assoc($qry);


$strSQL1 = "SELECT * FROM  (tb_subcredit LEFT JOIN tb_product ON tb_subcredit.product_ID=tb_product.product_id) WHERE ref_creditt = '".$ref_credit."' ";
//echo $strSQL;
//exit();
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

	 ?>



	<!--action="register_office1.php"-->
	<form action='register_credit_supedit1.php' method="post" name="frmMain" enctype="multipart/form-data">
	<div class="w3-white">
		<div class="w3-container w3-padding-large"><!-- main div -->


			<div class="w3-container w3-bar w3-light-gray w3-margin-bottom">
		
		<div class="w3-half">
					<h4>ใบสั่งลดหนี้ (Credit Note Order)</h4>
					</div>
						<div class="w3-half">
					<?php if($rs["send_dm"]=='0'){ ?>
<a href="send_credit_admin.php?ref_credit=<?php echo $rs["ref_credit"];?>&sale_code=<?php echo $_SESSION["code"]; ?>" target="_blank" class="w3-button w3-grey w3-right"><font color="red">ส่งใบสั่งลดหนี้ให้ผู้บริหารอนุมัติ</font></a>&nbsp;&nbsp;
					<?php } ?>
				</div></div>
<div class="w3-bar">
				<span class="w3-light-grey w3-right"> เลขที่อ้างอิง : <?php echo $rs["ref_credit"]; ?></span>
		<input type="hidden" name="ref_credit" class="w3-input" value=" <?php echo   $rs["ref_credit"]; ?>" >
	</div>

</p>
<?php
date_default_timezone_set("Asia/Bangkok");

$month = date('m');
$day = date('d');
$year = date('Y');

$today = $year . '-' . $month . '-' . $day;


?>

<?php if($rs["company_type"]=='3'){ ?>
<input type="radio" name="company_type" id="company_type" value = '3' checked='checked' class="button4"  >&nbsp;&nbsp; AWL&nbsp;&nbsp;
<input type="radio" name="company_type" id="company_type" value = '4'  class="button4"  >&nbsp;&nbsp; NBM</p>
<?php }else{ ?>
<input type="radio" name="company_type" id="company_type" value = '3'  class="button4"  >&nbsp;&nbsp; AWL&nbsp;&nbsp;
<input type="radio" name="company_type" id="company_type" value = '4' checked='checked' class="button4"  >&nbsp;&nbsp; NBM</p>
	
	<?php } ?>

	
วันที่ :&nbsp;&nbsp;
<input type="date" name="date_credit" id="date_credit" value ="<?php echo $rs["date_credit"]; ?>" class="button4" style="width:12%;"  > 

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

		
		
		
<?php if($rs["ttype_doc"]=='1'){ ?>
<input type="checkbox" name="ttype_doc" id="ttype_doc" value = '1' checked='checked' class="button4"  >&nbsp;&nbsp; คืนสืนค้า&nbsp;&nbsp;
<input type="checkbox" name="ttype_doc" id="ttype_doc" value = '2' class="button4"  >&nbsp;&nbsp; ส่วนลด&nbsp;&nbsp;

<?php }else if($rs["ttype_doc"]=='2'){ ?>
<input type="checkbox" name="ttype_doc" id="ttype_doc" value = '1'  class="button4"  >&nbsp;&nbsp; คืนสืนค้า&nbsp;&nbsp;
<input type="checkbox" name="ttype_doc" id="ttype_doc" value = '2' checked='checked' class="button4"  >&nbsp;&nbsp; ส่วนลด&nbsp;&nbsp;


	<?php } ?>
</p>
เลขที่ IV :&nbsp;&nbsp;
<input type="text" name="iv_no_ref" id="iv_no_ref" value ="<?php echo $rs["iv_no_ref"];?>" class="button4" style="width:30%;"  > 
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	
หมายเลขคำสั่งซื้อ :&nbsp;&nbsp;
<input type="text" name="ref_order_id" id="ref_order_id" value ="<?php echo $rs["ref_order_id"];?>" class="button4" style="width:26%;"  > 
</p>
เลขที่สัญญาเช่า :&nbsp;&nbsp;
<input type="text" name="ref_rental" id="ref_rental" value ="<?php echo $rs["ref_rental"];?>" class="button4" style="width:30%;"  > 
	
</p>

ชื่อลูกค้า :&nbsp;&nbsp;
<input type="text" name="customer_name" id="customer_name" value ="<?php echo $rs["customer_name"];?>" class="button4" style="width:30%;"  > 
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
เบอร์โทร :&nbsp;&nbsp;
<input type="text" name="customer_tel" id="customer_tel" value ="<?php echo $rs["customer_tel"];?>" class="button4" style="width:30%;"  > 

</p>
ที่อยู่ :  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
       สาเหตุที่คืน : <br>
<textarea name="address_name" id="address_name"  class="button4" style="width:35%;"  ><?php echo $rs["address_name"];?> </textarea>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<textarea name="return_des" id="return_des"  class="button4" style="width:35%;"  ><?php echo $rs["return_des"];?></textarea>

</p>
ชำระคืนค่าสินค้าโดย :</p>
<?php if($rs["type_return"]=='1'){ ?>
<input type="radio" name="type_return" id="type_return" checked='checked'  value ='1' class="button4"  required>&nbsp;&nbsp; เงินสด&nbsp;&nbsp;
<?php }else{ ?>
<input type="radio" name="type_return" id="type_return"  value ='1'  required>&nbsp;&nbsp; เงินสด&nbsp;&nbsp;
<?php } ?>
</p>
<?php if($rs["type_return"]=='2'){ ?>
<input type="radio" name="type_return" id="type_return" checked='checked' value ='2'  checked='checked'  required>&nbsp;&nbsp; โอนเงินเข้าบัญชี&nbsp;&nbsp;
<?php }else{ ?>
<input type="radio" name="type_return" id="type_return"  value ='2'  required>&nbsp;&nbsp; โอนเงินเข้าบัญชี&nbsp;&nbsp;
<?php } ?>
ธนาคาร  :&nbsp;&nbsp;
<input type="text" name="bank_name" id="bank_name" value ="<?php echo $rs["bank_name"];?>" class="button4" style="width:12%;"  >
&nbsp;&nbsp; ชื่อบัญชี  :&nbsp;&nbsp;
<input type="text" name="account_name" id="account_name" value ="<?php echo $rs["account_name"];?>" class="button4" style="width:12%;"  >
&nbsp;&nbsp; เลขที่บัญชี  :&nbsp;&nbsp;
<input type="text" name="account_no" id="account_no" value ="<?php echo $rs["account_no"];?>" class="button4" style="width:12%;"  >
&nbsp;&nbsp;แนบไฟล์รูป Book Bank 
<input type="hidden" name="h_book_bank" id="h_book_bank" value ="<?php echo $rs["book_bank"];?>" class="button4" style="width:12%;"  >

<input name="book_bank"  type="file"> <?php if($rs['book_bank']!=''){ ?><a href="credit_no/<?php echo $rs['book_bank']; ?>" target="_blank">ดูไฟล์แนบ</a><?php } ?>
</p>
</p>
<?php if($rs["type_return"]=='3'){ ?>
<input type="radio" name="type_return" id="type_return"   value ='3' checked='checked' required>&nbsp;&nbsp; ลดหนี้จากยอดลูกหนี้ค้างชำระ&nbsp;&nbsp;
<?php }else{ ?>
<input type="radio" name="type_return" id="type_return"  value ='3'  required>&nbsp;&nbsp; ลดหนี้จากยอดลูกหนี้ค้างชำระ&nbsp;&nbsp;
<?php } ?>
</p>
<?php if($rs["type_return"]=='4'){ ?>
<input type="radio" name="type_return" id="type_return"  value ='4' checked='checked' required>&nbsp;&nbsp;ไม่ต้องชำระเงิน&nbsp;&nbsp;
<?php }else{ ?>
<input type="radio" name="type_return" id="type_return"  value ='4'  required>&nbsp;&nbsp; ไม่ต้องชำระเงิน&nbsp;&nbsp;
<?php } ?>
</p>
ผู้ขอคืนสินค้า :&nbsp;
<input type="text" name="send_return_name" id="send_return_name" value ="<?php echo $rs["send_return_name"];?>"  class="button4" style="width:12%;"  > &nbsp;&nbsp;


วันที่ :&nbsp;
<input type="date" name="date_send_return" id="date_send_return" value ="<?php echo $rs["date_send_return"];?>" class="button4" style="width:12%;"  >
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;



ผู้แทนขาย :&nbsp;&nbsp;&nbsp;&nbsp;
<input type="text" name="sale_name" id="sale_name" value ="<?php echo $rs["sale_name"];?>" class="button4" style="width:12%;"  > &nbsp;&nbsp;


วันที่ :&nbsp;
<input type="date" name="sale_date" id="sale_date" value ="<?php echo $rs["sale_date"];?>" class="button4" style="width:12%;"  >
</p>

Sale : &nbsp;&nbsp;&nbsp;
<?php 
	if ($_SESSION['code']=='SS1'){
	?>
<select name="sale_code" id="sale_code" style="width:280px" class="button4" >
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_team_ss1 ORDER BY sale_code ASC";
//echo $strSQL5;
//exit();
$objQuery5 = mysqli_query($com,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5)){
if($rs["sale_code"] == $objResuut5["sale_code"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>
<option value="<?php echo $objResuut5["sale_code"];?>" <?php echo $sel;?>><?php echo $objResuut5["sale_code"];?> - <?php echo $objResuut5["sale_name"];?></option>
<?php
}
?>
</select>
<?php
}else 	if ($_SESSION['code']=='SS2'){

	?>
<select name="sale_code" id="sale_code" style="width:280px" class="button4" >
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_team_ss2 ORDER BY sale_code ASC";
//echo $strSQL5;
//exit();
$objQuery5 = mysqli_query($com,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5))
{
if($rs["sale_code"] == $objResuut5["sale_code"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>
<option value="<?php echo $objResuut5["sale_code"];?>" <?php echo $sel;?>><?php echo $objResuut5["sale_code"];?> - <?php echo $objResuut5["sale_name"];?></option>
<?php
}
?>
</select>

<?php
}else 	if ($_SESSION['code']=='SS3'){

	?>
<select name="sale_code" id="sale_code" style="width:280px" class="button4" >
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_team_ss3 ORDER BY sale_code ASC";
//echo $strSQL5;
//exit();
$objQuery5 = mysqli_query($com,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5))
{
if($rs["sale_code"] == $objResuut5["sale_code"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>
<option value="<?php echo $objResuut5["sale_code"];?>" <?php echo $sel;?>><?php echo $objResuut5["sale_code"];?> - <?php echo $objResuut5["sale_name"];?></option>
<?php
}
?>
</select>



<?php
}else 	if ($_SESSION['code']=='SS5'){

	?>
<select name="sale_code" id="sale_code" style="width:280px" class="button4" >
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_team_ss3 where sale_code IN ('S31','S32') ORDER BY sale_code ASC";
//echo $strSQL5;
//exit();
$objQuery5 = mysqli_query($com,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5))
{
if($rs["sale_code"] == $objResuut5["sale_code"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>
<option value="<?php echo $objResuut5["sale_code"];?>" <?php echo $sel;?>><?php echo $objResuut5["sale_code"];?> - <?php echo $objResuut5["sale_name"];?></option>
<?php
}
?>
</select>


<?php
}else 	if ($_SESSION['code']=='MK2'){

	?>
<select name="sale_code" id="sale_code" style="width:280px" class="button4" >
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_team_sm1 ORDER BY sale_code ASC";
//echo $strSQL5;
//exit();
$objQuery5 = mysqli_query($com,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5))
{
if($rs["sale_code"] == $objResuut5["sale_code"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>
<option value="<?php echo $objResuut5["sale_code"];?>" <?php echo $sel;?>><?php echo $objResuut5["sale_code"];?> - <?php echo $objResuut5["sale_name"];?></option>
<?php
}
?>
</select>


		<?php
}else 	if ($_SESSION['code']=='SUP_EN'){

	?>
<select name="sale_code" id="sale_code" style="width:280px" class="button4" >
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_team_en ORDER BY sale_code ASC";
//echo $strSQL5;
//exit();
$objQuery5 = mysqli_query($com,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5))
{
if($rs["sale_code"] == $objResuut5["sale_code"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>
<option value="<?php echo $objResuut5["sale_code"];?>" <?php echo $sel;?>><?php echo $objResuut5["sale_code"];?> - <?php echo $objResuut5["sale_name"];?></option>
<?php
}
?>
</select>


		<?php
}else 	{
			?>
				<select name="sale_code" id="sale_code" style="width:280px" class="button4" >
<option value="">**Please Select**</option>


<?php

$strSQL5 = "SELECT * FROM tb_team_all ORDER BY sale_code ASC";
//echo $strSQL5;
//exit();
$objQuery5 = mysqli_query($com,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5))
{
if($rs["sale_code"] == $objResuut5["sale_code"])
{
$sel = "selected";
}
else
{
$sel = "";
}
?>
<option value="<?php echo $objResuut5["sale_code"];?>" <?php echo $sel;?>><?php echo $objResuut5["sale_code"];?> - <?php echo $objResuut5["sale_name"];?></option>
<?php
}
?>
</select>


				<?php
}
			
?>
</div>

<div class="w3-bar w3-light-grey w3-border">
 <a class="w3-bar-item w3-button" onclick="openCity1('pd')"><font color="#404040"><b>รายการสินค้า</b></font></a>
 

</div>

<div id="pd" class="w3-container city1" >
	
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
<tbody>
<?php




$i = 1;
while($objResult1 = mysqli_fetch_array($objQuery1))
{
?>
<tr>
<td style="width:10%;">

<input type="hidden" name="id[]<?php echo $objResult1["id"];?>" class="w3-input w3-center" size="1%" value="<?php echo $objResult1['id']; ?>">

<input type="hidden" name="product_id[]<?php echo $objResult1["id"];?>" class="w3-input w3-center" size="1%" value="<?php echo $objResult1['product_id']; ?>">

<input type='text' name ="product_code[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["access_code"];?>" id ="product_code[]<?php echo $objResult1["id"];?>"    class="w3-input" /></td>

<td style="width:15%;"><textarea name = "product_name[]<?php echo $objResult1["id"];?>"   id = "product_name[]<?php echo $objResult1["id"];?>"  class="w3-input" readonly><?php echo $objResult1["sol_name"];?></textarea></td>	
	
<td style="width:5%;"><input type='text' name = "unit_name[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["unit_name"];?>" id = "unit_name[]<?php echo $objResult1["id"];?>"  class="w3-input"    readonly/></td>

<td style="width:5%;"><input type='text' name = "count[]<?php echo $objResult1["id"];?>" value="<?php echo $objResult1["count"];?>" id = "count[]<?php echo $objResult1["id"];?>"  class="w3-input" style="color:black;text-align:center"    /></td>

<td style="width:8%;"><input type='text' name = "unit_price[]<?php echo $objResult1["id"];?>" value="<?php  $price=$objResult1["unit_price"]; echo number_format( $price,2)."";?>" id = "unit_price[]<?php echo $objResult1["id"];?>"  class="w3-input"  style="color:black;text-align:right"    /></td>

<td style="width:8%;"><input type='text' name = "discount_unit[]<?php echo $objResult1["id"];?>" value="<?php  $discount_unit=$objResult1["discount_unit"]; echo number_format( $discount_unit,2)."";?>" id = "discount_unit[]<?php echo $objResult1["id"];?>"  class="w3-input" style="color:black;text-align:right"   /></td>


<td style="width:8%;">
<input type='text' name = "sum_amount[]<?php echo $objResult1["id"];?>" value="<?php  $sum_amount=$objResult1["sum_amount"]; echo number_format( $sum_amount,2)."";?>"  id = "sum_amount[]<?php echo $objResult1["id"];?>"  class="w3-input" style="color:black;text-align:right"   />
</td>

	<td style="width:2%;"><a href="credit_delete.php?ref_credit=<?php echo $rs["ref_credit"];?>&id=<?php echo $objResult1["id"];?>&code=<?php echo $_SESSION["type_login"]; ?>"><img src="img/false.png" width="16" height="16" border="0" /></a></td>

</tr>



<?php
	$i++;
	}
?>
</tbody>
</table>

<?php
	if($_SESSION["department"]=='วิศวกรรม'){
		include ('product_crediteng1.php');
	}else{	
	include ('product_creditsale1.php');
		}
		?>

</div>





<center>
	<?php if($rs["status_doc"]=='Request'){ ?>
<input type="submit" name="submit" value="บันทึก" class="w3-button w3-teal" >
	<?php } ?>
</center><br>
 </div> </div> </div>

</form>
<div id="cr_bar"> <?php include "foot.php"; ?></div>		

 
  <!--/div-->

  
