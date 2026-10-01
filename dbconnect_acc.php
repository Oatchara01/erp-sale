<?php
require_once __DIR__ . '/includes/env.php';
$code = env_db_connect('DB_ACC');
mysqli_set_charset($code, "utf8");
if (!$code) {
	echo mysqli_error_con();
	}
 mysqli_set_charset($code,"utf8");

 ?>