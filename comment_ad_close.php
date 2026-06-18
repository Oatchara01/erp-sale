
<?php include ("head.php"); ?>
<form action='comment_ad_close1.php' method="post" name="frmMain" enctype="multipart/form-data" >

<div class="w3-container w3-white">
	
	
<div class="w3-container w3-bar w3-light-gray w3-margin-bottom"><h4>หมายเหตุแจ้ง Admin</h4></div>	

<br><fieldset><legend><b></b></legend>	
<br>

<?php
$ref_id =$_GET["ref_id"];

$sql26 = "SELECT * FROM tb_comment_so where ref_id = '".$ref_id."'";
$qry26 = mysqli_query($conn,$sql26) or die(mysqli_error());
$rs26 = mysqli_fetch_assoc($qry26);

?>
<input type="hidden" name="ref_id" class="w3-input" value=" <?php echo $rs26["ref_id"]; ?>" >	
<font color='red'>หมายเหตุแจ้ง Admin :</font><br>
<fieldset><?php echo $rs26["comment_ad"]; ?><br></fieldset>	
<br>
<?php if($rs26['complete_adckk']=='2'){ ?>
	<input type="checkbox" name="complete_adckk" id="complete_adckk" checked='checked' value="2">&nbsp;ดำเนินการเรียบร้อยแล้ว 

	<?php }else if($rs26['complete_adckk']=='0'){ ?>

	<input type="checkbox" name="complete_adckk" id="complete_adckk" value="1">&nbsp;ดำเนินการเรียบร้อยแล้ว 

		<?php
	} 
		?>

หมายเหตุ การดำเนิน :
<textarea name="cls_desad"  class="w3-input" style="width:90%" id="cls_desad"  rows="3"><?php echo $rs26["cls_desad"]; ?></textarea>	


<br></fieldset>	<br>


<center>
<input type="submit" name="submit" value="บันทึก" class="w3-button w3-teal" >
</center><br>

</form>






