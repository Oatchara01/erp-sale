<?php
$com = mysqli_connect("localhost","root","","sale");
mysqli_set_charset($com, "utf8");
if (!$com) {
 echo mysqli_error_con();
 }
 mysqli_set_charset($com,"utf8");

?>