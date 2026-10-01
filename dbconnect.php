<?php
require_once __DIR__ . '/includes/env.php';

$conn = env_db_connect('DB');

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


$new = env_db_connect('DB_STOCK');

if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
mysqli_set_charset($new,"utf8");
