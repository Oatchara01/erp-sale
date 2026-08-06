<?php
include "dbconnect.php"; 

$strProduct = isset($_POST["product_code"]) ? trim($_POST["product_code"]) : '';

if ($strProduct !== '') {
	$strSQL = "SELECT * FROM tb_product WHERE access_code = ?";
	$stmt = mysqli_prepare($conn, $strSQL);
	if ($stmt) {
		mysqli_stmt_bind_param($stmt, "s", $strProduct);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		if ($result && $objResult = mysqli_fetch_array($result)) {
			$war_hc = $objResult["war_hc"];	
			$unit_hc = $objResult["unit_hc"];
			$vvv = "$war_hc $unit_hc";	
				
			echo $objResult["product_ID"]."|".$objResult["sol_name"]."|".$objResult["unit_name"]."|".$objResult["sol_price"]."|".'0'."|".$vvv;
		}
	}
}
?>


