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


?>	
<form action='' method="post" name="frmMain" enctype="multipart/form-data">
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

</div>
</div>
</form>
<div id="cr_bar"> <?php include "foot.php"; ?></div>		

  
  <!--/div-->

  </body>
</html>
  

