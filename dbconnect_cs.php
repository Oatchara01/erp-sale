<?php
$com1 = mysqli_connect("localhost","root","","invoice_receipt");
mysqli_set_charset($com1, "utf8");
if (!$com1) {
	echo mysqli_error_con();
	}
 mysqli_set_charset($com1,"utf8");

 ?>