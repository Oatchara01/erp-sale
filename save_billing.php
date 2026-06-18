	<?php
		include('dbconnect.php');
		if (isset($_POST["submit"])) {
		$ref_id=$_POST["ref_id"];
		$billing_name=$_POST["billing_name"];
		$billing_address=$_POST["billing_address"];
		$billing_tel=$_POST["billing_tel"];

			$save="update so__main set billing_name='$billing_name',billing_address='$billing_address',billing_tel='$billing_tel' where ref_id='$ref_id'";
			$qsave=mysqli_query($conn,$save);
			if (!$qsave) {
				echo "Error to save data!!".mysqli_error($conn);
			}
			else {
				echo "<script>window.close();</script>";;
			}
		
	}
	?>