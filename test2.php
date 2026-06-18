<!--?php include "error_page.php"; ?>
<?php
@session_start();

 $user_id_login= $_SESSION['user_id_login'];
 $name=$_SESSION['name_show'];
 $surname=$_SESSION['surname_show'];
 $tel =$_SESSION['telephone'];
 $user_type = $_SESSION['usertype']; 
 $type_login=$_SESSION['typelogin'];
  $department=$_SESSION['department'];
$em_id=$_SESSION['em_id'];



if ($user_id_login=="" ) {
	print"Access Denine<br>  Please Login <br>";
	print"Go to Login page ... ";
	print "<meta http-equiv=refresh content=3;URL=index.php>";
	exit();
} 
?-->