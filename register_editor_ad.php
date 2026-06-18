<?php include('head.php'); ?>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

<link rel="stylesheet" href="css/autocomplete.css"  type="text/css"/>
<script type="text/javascript" src="js/autocomplete.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>

<script>
function object() {
		if (document.getElementById('type_st').checked) {
			document.getElementById('dt1').style.display = 'block';
			document.getElementById('dt2').style.display = 'none';
			
		}
		else if (document.getElementById('type_en').checked) {
			document.getElementById('dt1').style.display = 'none';
			document.getElementById('dt2').style.display = 'block';
			
		}
		
	}
</script>
	
<style>
	.none {
    display:none;
	}
</style>
		<?php
	
$strSQL = "SELECT *  FROM no__complete WHERE ref_id = '".$_GET["ref_id"]."' ";
$objQuery = mysqli_query($conn,$strSQL) or die(mysqli_error());
$objResult = mysqli_fetch_array($objQuery);
	

$strSQL1 = "SELECT * FROM  no__subcomplete WHERE ref_idd = '".$_GET["ref_id"]."'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

date_default_timezone_set("Asia/Bangkok");


		?>
<div class="w3-container w3-white">
	<div class="w3-panel w3-light-grey"><h3>ใบแจ้งสินค้าไม่สมบูรณ์</h3>
		<div class="w3-half">
	<h3>Incomplete Delivery</h3>
		</div><div class="w3-half">
		<?php if($objResult["send_sup"]=='0'){ ?>			
<a href="send_nosup.php?ref_id=<?php echo $objResult["ref_id"];?>" target="_blank" class="w3-button w3-yellow w3-right"><font color="red">ส่งใบแจ้งสินค้าไม่สมบูรณ์ให้ Sup อนุมัติ</font></button></a>&nbsp;&nbsp;
									  <?php } ?>
	</div></div>
	<form action='register_editor_ad1.php' method="post" name="frmMain" enctype="multipart/form-data">
	<div class="w3-bar">
		

		<span class="w3-light-grey w3-right"> เลขที่อ้างอิง : <?php echo $objResult["ref_id"]; ?></span>
		<input type="hidden" name="ref_id" class="w3-input" value="<?php echo $objResult["ref_id"]; ?>">
	</div>
	
	<div class="w3-bar w3-padding-small"></div><!-- bar -->
	<div class="w3-half 1">
		<div class="w3-bar w3-margin-bottom">
			<span>วันที่</span> <input type="date" name="date_create" id="date_create" value = "<?php echo $objResult["date_create"]; ?>" class="w3-input" style="width:90%;" readonly>
		</div>
		
		<div class="w3-bar w3-margin-bottom">
				<span>ชื่อลูกค้า </span> <input type="text" name="customer" value = "<?php echo $objResult["customer"]; ?>" id="customer" class="w3-input" style="width:90%;"  >
		</div>
		
<div class="w3-bar w3-margin-bottom">
				<span>ที่อยู่ออกบิล </span> <textarea type="text" name="cus_add"  id="cus_add" class="w3-input" style="width:90%;" rows="2" ><?php echo $objResult["cus_add"]; ?></textarea>
		</div>
		<div class="w3-bar w3-margin-bottom">
			<span>วันที่ซื้อ</span> <input type="date" name="iv_date" id="iv_date" value = "<?php echo $objResult["iv_date"]; ?>" class="w3-input" style="width:90%;" readonly>
		</div>
	<div class="w3-bar w3-margin-bottom">
			ผู้ติดต่อ/เบอร์โทร <input type="text" name="contact" id="contact" value = "<?php echo $objResult["contact"]; ?>"  class="w3-input" style="width:90%;"  readonly>
						</div>	
			
		
	</div>
	<div class="w3-half 2">
		<div class="w3-bar w3-margin-bottom">
			<span>พนักงานผู้แจ้ง</span> <input type="text" name="add_by" id="add_by" value="<?php echo $objResult["add_by"]; ?>" class="w3-input" style="width:90%;"  readonly>
						</div>
	
		<div class="w3-bar w3-margin-bottom ">
					<span>เบอร์โทร</span>  <input type="text" name="cus_tel" value="<?php echo $objResult["cus_tel"]; ?>"  id="cus_tel" class="w3-input" style="width:90%;" >
			
		</div>
		<div class="w3-bar w3-margin-bottom">
				<span>ที่อยู่ติดตั้ง </span> <textarea type="text" name="cus_send"  id="cus_send" class="w3-input" style="width:90%;" rows="2" ><?php echo $objResult["cus_send"]; ?></textarea>
		</div>
		<div class="w3-bar w3-margin-bottom">
				<span>อาการเสีย </span> <textarea type="text" name="bad_condition"  id="bad_condition" class="w3-input" style="width:90%;" rows="2" required><?php echo $objResult["bad_condition"]; ?></textarea>
		</div>
				<div class="w3-bar w3-margin-bottom">
<?php if($objResult["type_doc"]=='1'){ ?>			
<input type="radio" name="type_doc" checked='checked' id="type_doc"  value="1" required> 
<?php }else{ ?>
<input type="radio" name="type_doc"  id="type_doc"  value="1" required> 
<?php } ?>			
<font color='blue' ><u><b>คลังสินค้า</b></u></font><br>
<!--div id="dt1" style="display:none"-->		
<div class="w3-bar">
<?php if($objResult["type_st1"]=='1'){ ?>		
<input type="checkbox" name="type_st1"  checked='checked' id="type_st1" value="1"> 
<?php }else{ ?>
<input type="checkbox" name="type_st1"  id="type_st1" value="1"> 	
<?php } ?>	
สินค้าไม่ครบตาม Order	
</div>
<div class="w3-bar">
<?php if($objResult["type_st2"]=='1'){ ?>		
<input type="checkbox" name="type_st2"  checked='checked' id="type_st2" value="1"> 
<?php }else{ ?>
<input type="checkbox" name="type_st2" id="type_st2" value="1"> 
<?php } ?>	
อุปกรณ์ประกอบไม่ครบตาม Order
</div>				
<?php if($objResult["type_doc"]=='2'){ ?>				
<input type="radio" name="type_doc"  checked='checked'  id="type_doc"  value="2"  required> 
<?php }else{ ?>
<input type="radio" name="type_doc"  id="type_doc"  value="2"  required> 
<?php } ?>			
			
<font color='blue' ><u><b>วิศวกรรม</b></u></font><br>

<div class="w3-bar">
<?php if($objResult["type_en2"]=='1'){ ?>		
<input type="checkbox" name="type_en2" checked='checked' id="type_en2" value="1"> 
<?php }else{ ?>
<input type="checkbox" name="type_en2" id="type_en2" value="1"> 	
<?php } ?>	
สินค้าชำรุดไม่สามารถใช้งานได้ <b><u>ระบุ</u></b>
<textarea name="des_en2"   id="des_en2" class="w3-input" rows="2" style="width:100%;" ><?php echo $objResult["des_en2"]; ?></textarea>
</div>				
			
<?php if($objResult["type_doc"]=='3'){ ?>			
<input type="radio" name="type_doc" checked='checked' id="type_doc"  value="3"  required>
<?php }else{ ?>
<input type="radio" name="type_doc"  id="type_doc"  value="3"  required>
			
<?php } ?>			
			
<font color='blue' ><u><b>จัดส่ง</b></u></font><br>
<div class="w3-bar">
<?php if($objResult["cs_nockk"]=='1'){ ?>		
<input type="checkbox" checked='checked' name="cs_nockk" id="cs_nockk" value="1"> 
<?php }else{ ?>
<input type="checkbox" name="cs_nockk" id="cs_nockk" value="1"> 	
<?php } ?>	
	
	การจัดส่งไม่สมบูรณ์
</div>					
<?php if($objResult["type_doc"]=='4'){ ?>	
<input type="radio" name="type_doc" checked='checked' id="type_doc"  value="4"  required>
<?php }else{ ?>
<input type="radio" name="type_doc"  id="type_doc"  value="4"  required>
			
<?php } ?>			
			
<font color='blue' ><u><b>สำนักงาน</b></u></font><br>
<div class="w3-bar">
<?php if($objResult["adm_docckk"]=='1'){ ?>	
<input type="checkbox" name="adm_docckk" checked='checked' id="adm_docckk" value="1">
<?php }else{ ?>
<input type="checkbox" name="adm_docckk" id="adm_docckk" value="1">	
<?php } ?>	

เอกสารไม่ครบ ต้องส่งตามหลัง
</div>					
<div class="w3-bar">
<?php if($objResult["adm_noprockk"]=='1'){ ?>		
<input type="checkbox" name="adm_noprockk" checked='checked' id="adm_noprockk" value="1">
<?php }else{ ?>
<input type="checkbox" name="adm_noprockk" id="adm_noprockk" value="1">
<?php } ?>	
	
ลูกค้าเปลี่ยนใจ ไม่รับสินค้า <b><u>ระบุสาเหตุ</u></b>
<textarea name="adm_noprodes"   id="adm_noprodes" class="w3-input" rows="2" style="width:100%;" ><?php echo $objResult["adm_noprodes"]; ?></textarea>
</div>
				
		</div>
		
		</div>


<fieldset><legend ><b><font color="red">ส่วนเพิ่มเติมการรับเรื่อง</font></b></legend></p>
<div class="w3-half ">
<div class="w3-bar w3-margin-bottom">
			<span>ได้รับสินค้าคืนจากลูกค้า วันที่</span> <input type="date" name="date_receive" id="date_receive" value = "<?php echo $objResult["date_receive"]; ?>" class="w3-input" style="width:90%;" required>
		</div>
	
	<div class="w3-bar w3-margin-bottom">
			<span>ลงงานจัดส่ง ID</span> <input type="text" name="delivery_no" id="delivery_no" value = "<?php echo $objResult["delivery_no"]; ?>" class="w3-input" style="width:90%;" >
		</div>
	
</div>
		
		<div class="w3-half ">
<div class="w3-bar w3-margin-bottom">
			<span>การแก้ไข</span> <textarea type="text" name="editor"  id="editor" class="w3-input" style="width:90%;" rows="2" required><?php echo $objResult["editor"]; ?></textarea>
		</div>
			
	<div class="w3-bar w3-margin-bottom">
			<span>เลขที่ Tracking</span> <input type="text" name="tracking" id="tracking" value = "<?php echo $objResult["tracking"]; ?>" class="w3-input" style="width:90%;" >
		</div>		
			
</div>

		</p>
</fieldset>
</p>
		

	</p>
	<div class="w3-bar w3-light-grey w3-border">
  <a class="w3-bar-item w3-button" onclick="openCity1('pd')"><font color="#404040"><b>สินค้า</b></font></a>


</div>



<div id="pd" class="w3-container city1"></p>
<table width="100%" border="0" class="w3-table">
<thead>

    <th>ID</th>
    <th>ชื่อสินค้า</th>
	<th>จำนวน</th>
	<th>หมายเลขเครื่อง</th>

</thead>
<tbody>

<?php

$i = 1;
while($objResult1 = mysqli_fetch_array($objQuery1))
{

$strSQL2 = "SELECT * FROM  tb_product WHERE product_ID = '".$objResult1["product_id"]."' ";

$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$objResult2 = mysqli_fetch_array($objQuery2);
 
	?>

<tr>
<td style="width:8%;">
	<input type="text" name="product[]<?php echo $objResult1["id_submain"];?>" class="w3-input w3-center" size="8%" value="<?php echo $objResult2["access_code"]; ?>">
<input type="hidden" name="product_id[]<?php echo $objResult1["id_submain"];?>" class="w3-input w3-center" size="8%" value="<?php echo $objResult1["product_id"]; ?>">
	<input type="hidden" name="id_run[]<?php echo $objResult1["id_submain"];?>" class="w3-input w3-center" size="8%" value="<?php echo $objResult1["id_submain"]; ?>">
</td>	

<td style="width:15%;">
<textarea name = "product_name[]<?php echo $objResult1["id_submain"];?>"   id = "product_name[]<?php echo $id;?>"  class="w3-input" readonly><?php echo $objResult2["sol_name"]; ?></textarea>
	
</td>
	
<td style="width:5%;">
<input type="text" name="count[]<?php echo $objResult1["id_submain"];?>" class="w3-input w3-center" size="1%" value="<?php echo $objResult1["count"]; ?>">
</td>	
	<td style="width:15%;">
<textarea name = "sn[]<?php echo $objResult1["id_submain"];?>"   id = "sn[]<?php echo $objResult1["id_submain"];?>"  class="w3-input" readonly><?php echo $objResult1["sn"]; ?></textarea>
</td>
<td style="width:2%;"><a href="delete_pro.php?ref_id=<?php echo $objResult["ref_id"];?>&id_submain=<?php echo $objResult1["id_submain"];?>"><img src="img/false.png" width="16" height="16" border="0" /></a></td>
</tr>

<?php
	$i++;
	}

?>



</tbody>
</table>





<?php if($objResult["send_sup"]=='0'){ ?>		
	<div class="w3-bar w3-center">
	<input type="Submit" name ="Submit" value="บันทึก" class = "w3-button w3-green w3-center" >
	</div><br>
	<?php } ?>
	</form>
</div></div>



</div>
<?php include('foot.php'); ?>




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


