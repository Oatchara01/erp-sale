
<?php
ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(~E_NOTICE);

$day_check = date('Y-m-d');
$day_time = date('H:i:s');

$strSQLw = "SELECT *  FROM tb_register_story  where summary_sale = '0' and date_line !='".$day_check."'";
$objQueryw = mysqli_query($conn,$strSQLw) or die ("Error Query [".$strSQLw."]");
$Num_Rowsw = mysqli_num_rows($objQueryw);
while($objResultw = mysqli_fetch_array($objQueryw))
{

$save19="UPDATE tb_register_story SET ckk_mor ='0',ckk_eve ='0',date_line='".$day_check."' where id_story ='".$objResultw["id_story"]."'";
$qsave19=mysqli_query($conn,$save19);	

}


?>
