<?php include('head.php'); 
include "dbconnect_acc.php";
?>
<body>
<form name="frmSearch" method="POST" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-white">
<div class="w3-container w3-padding-large">
<div class="w3-panel w3-light-gray"><h4>รายการเก็บเงินปลายทาง</h4></div>

<?php
$strSQL ="SELECT * FROM tb_register_data WHERE ref_id ='".$_GET["ref_id"]."'";	
$objQuery = mysqli_query($code,$strSQL) or die ("Error Query [".$strSQL."]");
$objResult = mysqli_fetch_array($objQuery);
?>	
	
<div class="w3-container">	
	หมายเหตุโชว์รูม :&nbsp;
<textarea name="remark_salehc"  class="w3-input" style="width:90%" id="remark_salehc"  rows="2"><?php echo $objResult["remark_salehc"];?></textarea></p>
	
	<input type="hidden" value = "<?php echo $_GET["ref_id"]; ?>" name="ref_id" class="w3-input" style="width:90%;">
	<input type="hidden" value = "<?php echo $_GET["start_date"]; ?>" name="start_date" class="w3-input" style="width:90%;">
	<input type="hidden" value = "<?php echo $_GET["end_date"]; ?>" name="end_date" class="w3-input" style="width:90%;">
	<input type="hidden" value = "<?php echo $_GET["Keyword"]; ?>" name="Keyword" class="w3-input" style="width:90%;">
<br>
	<center><input type="submit" name="save" value="บันทึก" class="w3-button w3-teal" ></center>

	
	
	
<?php
if ($_POST["save"]) {	
$ref_id = $_POST["ref_id"];
$start_date = $_POST["start_date"];
$end_date = $_POST["end_date"];
$Keyword = $_POST["Keyword"];
$remark_salehc = $_POST["remark_salehc"];
	
include "dbconnect_acc.php";
	
$strSQL89="Update  tb_register_data set remark_salehc = '".$remark_salehc."'  where ref_id='".$ref_id."'";
$save = mysqli_query($code,$strSQL89);	
	
if ($save) {
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='report_waitcod.php?ref_id=$ref_id&start_date=$start_date&end_date=$end_date&Keyword=$Keyword';";
echo "</script>";

}else{
echo "<script>alert('ไม่สามารถบันทึกได้ : " . mysqli_error($code) . "');</script>";	
}
}
	?>
</div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>		
</body>
</html>