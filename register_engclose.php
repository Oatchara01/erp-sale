<?php include ("head.php"); ?>
<?php include('dbconnect_sale.php'); ?>

<html>
<head>


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
</head>
<body>
<?php
date_default_timezone_set("Asia/Bangkok");

$sql = "select * from tb_register_eng where ref_id ='".$_GET["ref_id"]."'";
$query = mysqli_query($conn,$sql);
$fetch = mysqli_fetch_array($query,MYSQLI_ASSOC); 

$strSQL = "SELECT * FROM tb_product WHERE product_ID = '".$fetch["product_code"]."' ";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
	

?>	
<form action='register_engclose1.php' method="post" name="frmMain" enctype="multipart/form-data">
<div class="w3-white">
		<div class="w3-container w3-padding-large"><!-- main div -->
			<div class="w3-panel w3-light-gray">
				<div class="w3-half">
				<h4>รายการรับเรื่องจากลูกค้าของช่าง (ปิดงาน)</h4>
					</div> <div class="w3-half">
				
							</div>	
			</div>







		วันที่ : &nbsp;&nbsp;&nbsp;<?php echo $fetch["date_story"]; ?>
		&nbsp;&nbsp;เวลา&nbsp;&nbsp;<?php echo $fetch["time_story"]; ?></p>
		
		
โรงพยาบาล : &nbsp;<input type="text" name="customer_name"  id="customer_name" value="<?php echo $fetch["customer_name"]; ?>"  class="button4" style="width:20%;" readonly> &nbsp;&nbsp;&nbsp;

แผนก  : &nbsp;

<input type='text' name = "address_name"  id = "address_name" class="button4"  value="<?php echo $fetch["address_name"]; ?>" style="width:20%;" readonly> 
<input type='hidden' name = "ref_id"  id = "ref_id" class="button4"  value="<?php echo $fetch["ref_id"]; ?>" style="width:20%;" /> 


</p>
ชื่อลูกค้า  : &nbsp;&nbsp;&nbsp;

<input type='text' name = "contact_name"  id = "contact_name" class="button4"  value="<?php echo $fetch["contact_name"]; ?>" style="width:20%;" readonly></p>

<?php if($fetch["type_eng"]=='1'){ ?>	
	
 <input type='radio' name="type_eng" id="type_eng" value='1' checked='checked' >ลูกค้าแจ้งซ่อม  &nbsp;&nbsp;&nbsp;
 <input type='radio' name="type_eng" id="type_eng" value='2' >เช็คสถานที่ลูกค้า
	
	<?php }else if($fetch["type_eng"]=='2'){ ?>
	 <input type='radio' name="type_eng" id="type_eng" value='1' >ลูกค้าแจ้งซ่อม  &nbsp;&nbsp;&nbsp;
 <input type='radio' name="type_eng" id="type_eng" value='2' checked='checked' >เช็คสถานที่ลูกค้า
	
	<?php }else{ ?>
	 <input type='radio' name="type_eng" id="type_eng" value='1'  >ลูกค้าแจ้งซ่อม  &nbsp;&nbsp;&nbsp;
 <input type='radio' name="type_eng" id="type_eng" value='2' >เช็คสถานที่ลูกค้า
	<?php } ?>

</p>
วันที่นัดหมาย : &nbsp;<input type="date" name="date_plan"  id="date_plan" value="<?php echo $fetch["date_plan"]; ?>"  class="button4" style="width:20%;" readonly> &nbsp;&nbsp;&nbsp;

เวลาที่นัดหมาย  : &nbsp;

<input type='text' name = "time_plan"  id = "time_plan" class="button4"  value="<?php echo $fetch["time_plan"]; ?>" style="width:20%;" readonly> 
 </p>
รายละเอียด  : </p> 

<textarea type='text' name = "description"  id = "description" class="button4"   style="width:25%;" readonly><?php echo $fetch["description"]; ?></textarea>
</p>

เบอร์โทรศัพท์ : &nbsp;<input type="text" name="tel_number"  id="tel_number" value="<?php echo $fetch["tel_number"]; ?>"  class="button4" style="width:20%;" readonly> &nbsp;&nbsp;&nbsp;

				</p>

เขตการขาย : &nbsp;

<select name="sale_code" id="sale_code" style="width:260px" class="button4" readonly>
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_team_en ORDER BY sale_code ASC";
//echo $strSQL5;
//exit();
$objQuery5 = mysqli_query($com,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5))
{

if($fetch["sale_code"] == $objResuut5["sale_code"])
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
</select>&nbsp;&nbsp;&nbsp;


ผู้รับเรื่อง  : &nbsp;

<input type='text' name = "receive_name"  id = "receive_name" class="button4"  value="<?php echo $fetch["receive_name"]; ?>"  style="width:18%;" readonly>
 </p>
อัพเดตการดำเนินการ  :</p> 

<textarea type='text' name = "pending_pre"  id = "pending_pre" class="button4" rows="3"  style="width:30%;" ></textarea>
</p>การดำเนินการ  :</p> 

<textarea type='text' name = "pending"  id = "pending" class="button4" rows="3"  style="width:30%;" readonly><?php echo $fetch["pending"]; ?></textarea>
</p>
เลขที่เอกสารช่าง  : &nbsp;

<?php
if($_GET["doc_noeng"] !=''){

$doc_noeng =$_GET["doc_noeng"];
}else{
	
$doc_noeng = $fetch["doc_noeng"];	
}

?>




<input type='text' name = "doc_noeng"  id = "doc_noeng" class="button4"  value="<?php echo $doc_noeng; ?>"  style="width:18%;" readonly>
 </p>


หมายเหตุ Admin  : </p> 

<textarea  name = "remark_adm"  id = "remark_adm" class="button4"   style="width:25%;" required></textarea>
</p>
แนบไฟล์ </p>
<input name="img_1"  type="file"><a href="regis_eng/<?php echo $fetch['img_1']; ?>" target="_blank"><?php if($fetch['img_1']!=''){ ?>คลิ๊กเพื่อดูเอกสาร <?php } ?></a>
</p>
<input name="img_2"  type="file"><a href="regis_eng/<?php echo $fetch['img_2']; ?>" target="_blank"><?php if($fetch['img_2']!=''){ ?>คลิ๊กเพื่อดูเอกสาร <?php } ?></a>
</p>
<input name="img_3"  type="file"><a href="regis_eng/<?php echo $fetch['img_3']; ?>" target="_blank"><?php if($fetch['img_3']!=''){ ?>คลิ๊กเพื่อดูเอกสาร <?php } ?></a>
</p>
<input name="img_4"  type="file"><a href="regis_eng/<?php echo $fetch['img_4']; ?>" target="_blank"><?php if($fetch['img_4']!=''){ ?>คลิ๊กเพื่อดูเอกสาร <?php } ?></a>
</p>
<input name="img_5"  type="file"><a href="regis_eng/<?php echo $fetch['img_5']; ?>" target="_blank"><?php if($fetch['img_5']!=''){ ?>คลิ๊กเพื่อดูเอกสาร <?php } ?></a>

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

<input type='text' name = "product_codet1" value="<?php echo $objResult["access_code"]; ?>"  id = "product_codet1" class="w3-input" placeholder="Search รหัส"  size="7" OnChange="JavaScript:doCallAjax('product_codet1','product_id1','product_name1','unit_name1');"/> 
<input type='hidden' name = "h_product_codet1"  id = "h_product_codet1"  class="button4" readonly>
<input type='hidden' name = "product_id1" value="<?php echo $objResult["product_ID"]; ?>" id = "product_id1" class="w3-input" />

</td>
<td  style="width:8%;">
<textarea  name = "product_name1"  id = "product_name1"  rows="2" class="w3-input" readonly><?php echo $objResult["sol_name"]; ?></textarea>
</td>
<td style="width:5%;">
<input type='text' name = "unit_name1"  id = "unit_name1" value="<?php echo $objResult["unit_name"]; ?>" class="w3-input" readonly/>
</td>
<td style="width:5%;">
<input type='text' name = "sale_count1" id = "sale_count1" value="<?php echo $fetch["count"]; ?>"  class="w3-input" style="color:black;text-align:center"  />
</td>
<td style="width:10%;">
<textarea name = "sn_number1" id = "sn_number1"  class="w3-input"   ><?php echo $fetch["sn_number"]; ?></textarea>
</td>
<td style="width:10%;">
<textarea name = "sale_remark1" id = "sale_remark1"  class="w3-input"   ><?php echo $fetch["sale_remark"]; ?></textarea>
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
<input type="submit" name="btn_sub" value="ปิดการดำเนินงาน" class="w3-button w3-teal" >
&nbsp;&nbsp;&nbsp;	
<input type="submit" name ="btn_sub1" value="อัพเดตดำเนินการ" class = "w3-button w3-teal w3-yellow" onClick="this.form.action=' register_engupdate.php'; submit()">



</center><br>
</div>
</div>
</form>
<div id="cr_bar"> <?php include "foot.php"; ?></div>		

  
  <!--/div-->

  </body>
</html>
  

