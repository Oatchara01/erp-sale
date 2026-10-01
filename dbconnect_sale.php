<?php
require_once __DIR__ . '/includes/env.php';
$com = env_db_connect('DB_SALE');
mysqli_set_charset($com, "utf8");
if (!$com) {
 echo mysqli_error_con();
 }
 mysqli_set_charset($com,"utf8");

?>