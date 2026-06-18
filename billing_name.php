<?php include('head3.php');
$main_id=$_GET['main_id'];
$sql = "select ref_id,doc_no,billing_name,billing_address,billing_tel from so__main where main_id=$main_id";
$query = mysqli_query($conn,$sql);
$fetch = mysqli_fetch_array($query,MYSQLI_ASSOC);
?>
<body>
<div class="w3-container">
	<div class="w3-padding large w3-bar"><h2>รายชื่อที่ต้องการออกบิล</h2></div>
	<form name="billing" method="post" action="save_billing.php" >
		<div class="w3-center">
			<b>เลขที่อ้างอิง</b>
			<input name="ref_id" type="" class="w3-input w3-center" value="<?php echo $fetch['ref_id']; ?>" readonly>
			<b>เลขที่เอกสาร</b>
			<input name="doc_no" class="w3-input w3-center" value="<?php echo $fetch['doc_no']; ?>" readonly>
			<b>ชื่อที่ต้องการออกบิล</b>
			<input name="billing_name" type="text" class="w3-input w3-center" value="<?php echo $fetch['billing_name']; ?>">
			<b>ที่อยู่ที่ต้องการออกบิล</b>
			<textarea name="billing_address" rows="2" class="w3-input w3-center"><?php echo $fetch['billing_address']; ?></textarea>
			<b>เบอร์โทรศัพท์</b>
			<input name="billing_tel" type="text" class="w3-input w3-center" value="<?php echo $fetch['billing_tel']; ?>">
			<input name="submit" type="submit" class="w3-button w3-teal" value="Submit">
	</form>
</div>
<?php require_once('foot.php'); ?>