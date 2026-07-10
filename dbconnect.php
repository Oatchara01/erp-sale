<?php
$conn = mysqli_connect("localhost", "root", "", "allwell_sol_test");
// $conn = mysqli_connect("localhost","root","","allwell_sol_test_1");

if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
mysqli_set_charset($conn, "utf8");
mysqli_query($conn, "SET sql_mode = ''");



/*$salso = mysqli_connect("localhost:3306","joe","secret","allwell_sol_test");

if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
mysqli_set_charset($salso,"utf8");


//$mysqli -> close();


$stock = mysqli_connect("localhost:3306","joe","secret","allwell_sol_test");

if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
mysqli_set_charset($stock,"utf8");


$inter = mysqli_connect("localhost:3306","joe","secret","allwell_inter");

if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
mysqli_set_charset($inter,"utf8");


$news = mysqli_connect("localhost:3306","joe","secret","allwell_sol_test");

if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
mysqli_set_charset($news,"utf8");*/


/*$stock_out = mysqli_connect("27.254.145.133","allwell_stock","Pass@2020","allwell_stock");

if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
mysqli_set_charset($stock_out,"utf8");*/
