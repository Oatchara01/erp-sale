<?php
$conn = mysqli_connect("localhost","root","web@ptli","dbserviceengineer");

// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
mysqli_set_charset($conn,"utf8");

?>