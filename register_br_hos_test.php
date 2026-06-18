<?php
	include('dbconnect.php');
	if ($_POST['submit']) {
		
		$objective_des = $_POST['objective_des'];
		echo $objective_des;

}
else {
	echo "No Data!";
	echo header('refresh:3;'. $_SERVER['HTTP_REFERER']);
}
?>