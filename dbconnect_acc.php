<?php
$code = mysqli_connect("localhost","invoice_receipt_test","vk54A7~c0","invoice_receipt_test");
mysqli_set_charset($code, "utf8");
if (!$code) {
	echo mysqli_error_con();
	}
 mysqli_set_charset($code,"utf8");

 ?>