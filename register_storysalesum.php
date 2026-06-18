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
	<form action='register_storysalesum1.php' method="post" name="frmMain" enctype="multipart/form-data">
		<div class="w3-white w3-container w3-padding-large"><!-- main div -->
			<div class="w3-panel w3-light-gray"><h4>รายการรับเรื่องจากลูกค้า</h4>
			</div>


<?php
date_default_timezone_set("Asia/Bangkok");

$id_story = $_GET["id_story"];

$strSQL = "SELECT *  FROM tb_register_story  where id_story = '".$_GET["id_story"]."'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
$objResult = mysqli_fetch_array($objQuery);


?>

<input type="hidden" name="id_story"  id="id_story" value = "<?php echo $objResult["id_story"]; ?>" class="button4" style="width:20%;" >

		วันที่ : &nbsp;&nbsp;&nbsp;<?php echo Datethai($objResult["date_story"]); ?>
		&nbsp;&nbsp;เวลา&nbsp;&nbsp;<?php echo $objResult["time_story"]; ?></p>
		
		
โรงพยาบาล : &nbsp;<input type="text" name="customer_name"  id="customer_name" value = "<?php echo $objResult["customer_name"]; ?>"  class="button4" style="width:20%;" > &nbsp;&nbsp;&nbsp;

แผนก  : &nbsp;

<input type='text' name = "address_name"  id = "address_name" class="button4" value = "<?php echo $objResult["address_name"]; ?>" style="width:20%;" /> 


</p>
ชื่อลูกค้า  : &nbsp;&nbsp;&nbsp;

<input type='text' name = "contact_name"  id = "contact_name" class="button4" value = "<?php echo $objResult["contact_name"]; ?>" style="width:20%;" />

</p> 
รายละเอียด  : </p> 

<textarea type='text' name = "description"  id = "description" class="button4"  style="width:25%;" ><?php echo $objResult["description"]; ?></textarea>
</p>

เบอร์โทรศัพท์ : &nbsp;<input type="text" name="tel_number"  id="tel_number" value = "<?php echo $objResult["tel_number"]; ?>" class="button4" style="width:20%;" > &nbsp;&nbsp;&nbsp;

FAX  : &nbsp;

<input type='text' name = "fax"  id = "fax" class="button4" value = "<?php echo $objResult["fax"]; ?>" style="width:20%;" /> 

</p>

E-mail  : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<input type='text' name = "email"  id = "email" class="button4" value = "<?php echo $objResult["email"]; ?>" style="width:20%;" />

				</p>
<input type='hidden' name = "sale_code"  id = "sale_code" class="button4" value = "<?php echo $objResult["sale_code"]; ?>" style="width:20%;" />
<!--เขตการขาย : &nbsp;


<select name="sale_code" id="sale_code" style="width:260px" class="button4" >
<option value="">**Please Select**</option>
<?php

$strSQL5 = "SELECT * FROM tb_team_adm ORDER BY sale_code ASC";
//echo $strSQL5;
//exit();
$objQuery5 = mysqli_query($com,$strSQL5);
while($objResuut5 = mysqli_fetch_array($objQuery5))
{
if($objResult["sale_code"] == $objResuut5["sale_code"])
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
?>&nbsp;&nbsp;&nbsp;
</select-->


ผู้รับเรื่อง  : &nbsp;

<input type='text' name = "receive_name"  id = "receive_name" class="button4" value = "<?php echo $objResult["receive_name"]; ?>"  style="width:18%;" />
</p>

หมายเหตุ Admin  : </p>

<textarea type='text' name = "remark_adm"  id = "remark_adm" class="button4"  style="width:25%;" ><?php echo $objResult["remark_adm"]; ?></textarea>
</p>

การดำเนินการของ Sale  : </p>

<textarea type='text' name = "remark_sale"  id = "remark_sale" class="button4"  style="width:25%;" ><?php echo $objResult["remark_sale"]; ?></textarea>
&nbsp;&nbsp;&nbsp;


<?php if($objResult["summary_sale"]=='1'){ ?>
<input type="checkbox" checked='checked' name="summary_sale" value = "1">&nbsp;ปิดงาน
<?php }else{ ?>

<input type="checkbox" name="summary_sale"  value="1" >&nbsp;ปิดงาน

			<?php } ?>


</p></p>

<?php if($objResult["summary_sale"]=='1'){ 
}else{
	?>
<center>
<input type="submit" name="submit" value="บันทึก" class="w3-button w3-teal" >
</center>
<?php } ?>

</form> </div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>		

 
  <!--/div-->

  </body>
</html>
  

