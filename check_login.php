<?php
session_start();
ob_start();

?>
<?php
/*<script type="text/javascript" src="//laz-g-cdn.alicdn.com/sj/securesdk/0.0.3/securesdk_lzd_v1.js" id="J_secure_sdk_v2" data-appkey="124441"></script>*/


	require_once('dbconnect.php');
	require_once('head_first.php');
    
	$strSQL = "SELECT * FROM tb_user WHERE user_id = '".$_POST["txtUsername"]."' 
	and pass = '".$_POST['txtPassword']."'";
	$objQuery = mysqli_query($conn,$strSQL);
	$objResult = mysqli_fetch_array($objQuery);
$rows = mysqli_num_rows($objQuery);


   $strSQL1 = "SELECT line_add FROM tb_user WHERE user_id = '".$_POST["txtUsername"]."' ";
	$objQuery1 = mysqli_query($conn,$strSQL1);
	$objResult1 = mysqli_fetch_array($objQuery1);
     $line_add = $objResult1["line_add"];

 
?>
	<div class="w3-container" id="outer">
	<div id="inner" class="w3-center">

	<?php		


		
$browser="";       
function chkBrowser($nameBroser){ 
return preg_match("/".$nameBroser."/",$_SERVER['HTTP_USER_AGENT']); 
} 
if(chkBrowser("MSIE")==1){
$browser="IE 9";
if(chkBrowser("MSIE 8")==1){
$browser="IE 8";
}elseif(chkBrowser("MSIE 7")==1){
$browser="IE 7";
}elseif(chkBrowser("MSIE 10")==1){
$browser="IE 10";
}elseif(chkBrowser("MSIE 6")==1){
$browser="IE 6";
}else{
$browser="OTHER IE more than Version 9";
}  
}elseif(chkBrowser("Firefox")==1){
$browser="Firefox";
}elseif(chkBrowser("Chrome")==1){
$browser="Chrome";
}elseif(chkBrowser("Chrome")==0 && chkBrowser("Safari")==1){
$browser="Safari";
}elseif(chkBrowser("Opera")==1){
$browser="Opera";
}elseif(chkBrowser("Netscape")==1){
$browser="Netscape";
}else{
$browser="OTHER IE more than Version 9";
}
$Com_name=gethostbyaddr($_SERVER['REMOTE_ADDR']);
$ip=GetHostByName($_SERVER['REMOTE_ADDR']);

$date_today = date('Y-m-d H:i:s');
		
$date = date('Y-m-d H:i:s');
$timestamp = strtotime($date);
$timestamp1 = $timestamp*1000;


	if($rows==1)
	{
		
		$_SESSION["emid"] = $objResult["em_id"];
			$_SESSION["UserID"] = $objResult["user_id"];
			$_SESSION["name"] = $objResult["name"];
			$_SESSION["surname"] = $objResult["surname"];
			$_SESSION["position"] = $objResult["position"];
			$_SESSION["mail_intra"] = $objResult["mail_intra"];
			$_SESSION["ext"] = $objResult["ext"];
			$_SESSION["user_type"] = $objResult["user_type"];
			$_SESSION["employee_tel"] = $objResult["employee_tel"];
			$_SESSION["department"] = $objResult["department"];
			$_SESSION["code"] = $objResult["code"];
			$_SESSION["type_login"] = $objResult["type_login"];

	

			
          if($objResult["name"]=="ริสา" or $objResult["name"]=="ชนิกานต์" or $objResult["name"]=="ปาลิตา")
			{
			header("location:main_mk.php");	
			
		} else if ($objResult["code"] == "SMD") {
        header("Location: main_admin.php");
        exit;
			}else if($objResult["type_login"]=="Admin")
			{
			header("location:main_admin.php");	
			}
			else if($objResult["type_login"]=="Test")
			{
			header("location:main_test.php");	
			}
			else if ($objResult["type_login"]=="AllWell")
			{
				header("location:main_allwell.php");
			}
			else if ($objResult["type_login"]=="Stock")
			{
		echo "<script language=\"JavaScript\">";
        echo "alert('กรุณา Login ระบบ ERP Stock');window.location='stock.allwellcenter.com";
        echo "</script>";
				
			}
			else if ($objResult["type_login"]=="It")
			{
				header("location:main_admin.php");
			}
			else if ($objResult["type_login"]=="RPA")
			{
				header("location:main_admins.php");	
			
			}
			else if ($objResult["type_login"]=="Sale" and $_SESSION["code"]=='INT')
			{
				header("location:main_admin.php");	
				
			}
			else if ($objResult["type_login"]=="Sale" and $_SESSION["code"]=='HR')
			{
				header("location:main_admin.php");		
				
			}
			else if ($objResult["type_login"]=="Sale")
			{
				header("location:main_salehos.php");
			}else if ($objResult["type_login"]=="Sup_Sale")
			{
				header("location:main_suphos.php");
			}
			else if ($objResult["type_login"]=="Sup_AllWell")
			{
				header("location:main_supallwell.php");
			}else if ($objResult["type_login"]=="Engineer")
			{
				header("location:main_engineer.php");
			}else if ($objResult["type_login"]=="Admin_hos")
			{
				header("location:main_adminhos.php");
			}
			
	


	session_write_close();
		

		
		}else{
		
		
		


		
			echo "<h3>ชื่อผู้ใช้และรหัสผ่านไม่ถูกต้อง!</h3><br /><a href='index.php'><h5>Go Back To Login Again</h5></a></div>";
		
		
				
		
	}
	mysqli_close($conn);
	require_once('foot.php');
?>
</div>