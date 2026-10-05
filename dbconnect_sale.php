<?php
$com = mysqli_connect("localhost","allwell_saletest","t771@irV5","allwell_saletest");
mysqli_set_charset($com, "utf8");
if (!$com) {
 echo mysqli_error_con();
 }
 mysqli_set_charset($com,"utf8");

?>