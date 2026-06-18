
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<style type="text/css">
<!--
.style8 {color: #6633FF; font-weight: bold; }
.style9 {
	color: #FF0000;
	font-weight: bold;
	font-size: 24px;
}

.style10 {
	color: #006600;
	font-weight: bold;
	font-size: 24px;
}
-->
</style>
</head>
<body>
<center></br></br>

<?php
include("dbconnect.php");
date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

$main_id = $_POST["main_id"];
$ref_id = $_POST["ref_id"];
$transfer = $_POST["transfer"];
$approve_name = $_POST["approve_name"];
$approve_complete = $_POST["approve_complete"];




$save="Update  so__main set ref_id='$ref_id',transfer='$transfer',approve_name='$approve_name',approve_complete='$approve_complete' where main_id='$main_id'";


//echo $save;
//exit();

$qsave=mysqli_query($conn,$save);







	
if($qsave)
	{
	//บันทึกเรียบร้อย
	
	/*print " <img src='img/small_compleate.gif' />Save Successfully <br />";	*/
print " <img src='img/small_compleate.gif' /><span class='style10'>ref_id: </span><font color='0000ff'>".$ref_id." </font><span class='style10'>Save Successfully</span><br />";
	}
else
	{
    //บันทึกไม่ได
	
	print "<img src='img/false.png' /><span class='style9'> Error to save data </span><br />";

	}
	
}



/*if (!$qsave) {
	echo "Error to save data".mysqli_error();
}
else {
	echo "Save Successfully";
}
}
*/
?>

<p align="center"><a href="status_approve.php"><span class="style18">กลับสู่หน้าหลัก</span></a></p>

</center>
</body>
</html>



