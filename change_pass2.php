<?php
	include('head.php');
	session_start();
	if($_SESSION['UserID'] == "")
	{
		echo "Please Login!";
		exit();
	}
	
	if($_POST["txtPassword"] != $_POST["txtConPassword"])
	{
		echo "<script language=\"JavaScript\">";
		echo "alert('Password not Match!');window.location='change_pass.php'";
		echo "</script>";
		exit();
	}
	$strSQL = "UPDATE tb_user SET pass = '".trim($_POST['txtPassword'])."'  WHERE em_id = '".$_POST["em_id"]."' ";
	$objQuery = mysqli_query($conn,$strSQL);
	?>
	<div class="w3-container w3-center">
	<?php
	echo "<h2>Save Completed!</h2><br>";		
	
	if($_SESSION["type_login"] == "Admin")
	{
		echo "<br> Back to <a href='main_admin.php'>หน้าหลัก Admin</a>";
	}
	else if($_SESSION["type_login"] == "Stock")
	{
		echo "<br> Back to <a href='main_stock.php'>หน้าหลัก Stock</a>";
	}
	else if($_SESSION["type_login"] == "Office")
	{
		echo "<br> Back to <a href='main_office.php'>หน้าหลัก Office</a>";
	}
	else if($_SESSION["type_login"] == "It")
	{
		echo "<br> Back to <a href='main_admin.php'>หน้าหลัก IT</a>";
	}
	?>
	</div>
	<?php
	mysqli_close($conn);
?>