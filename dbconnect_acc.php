<?php
$code = mysqli_connect("localhost","root","","invoice_receipt");
mysqli_set_charset($code, "utf8");
if (!$code) {
	echo mysqli_error_con();
	}
 mysqli_set_charset($code,"utf8");

 ?>