<?php require_once('head_first.php'); ?>
<?php
include("dbconnect.php");


	$strSQL = "SELECT * FROM tb_user WHERE em_id = '".$_POST['em_id']."'";
	$objQuery = mysqli_query($conn,$strSQL);
	$objResult = mysqli_fetch_array($objQuery);

$type_send = $_POST['type_send'];
$line_add = $objResult["line_add"];
$mail_intra = $objResult["mail_intra"];
$name = $objResult["name"];
$surname = $objResult["surname"];
$user_id = $objResult["user_id"];
$pass = $objResult["pass"];


if(!$objResult)
	{
echo "ไม่พบรหัสพนักงานนี้ในระบบ";

	}else{

 
             
	

if($type_send=='2'){

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
$sToken = "$line_add";
$sMessage = "Wellcom คุณ  $name   $surname

User : $user_id
PassWord : $pass

https://sol.allwellhealthcare.com กรณาคลิ๊กลิ้งค์นี้เพื่อดำเนินการเข้าสู่ระบบ";
$chOne = curl_init();
curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt( $chOne, CURLOPT_POST, 1);
curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=".$sMessage);
$headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$sToken.'', );
curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec( $chOne );
if(curl_error($chOne))
{
//echo 'error:' . curl_error($chOne);
}
else {
$result_ = json_decode($result, true);
//echo "status : ".$result_['status']; echo "message : ". $result_['message'];
}
curl_close( $chOne ); 

	}else if($type_send=='1'){


$to = $mail_intra;

			$headers = "From: prm@allwelllifegroup.com\r\n";
			$headers .= "Reply-To: prm@allwelllifegroup.com\r\n";
			$headers .= "Return-Path: prm@allwelllifegroup.com\r\n";
			$headers .= "CC: prm@allwelllifegroup.com\r\n";
			$headers .= "BCC: prm@allwelllifegroup.com\r\n";
			$headers .= "X-Mailer: PHP/" . phpversion();
			$headers .= "'MIME-Version: 1.0' . \r\nContent-type: text/html; charset=utf-8\r\n";

			$subject = "=?UTF-8?B?".base64_encode("Login")."?=";
			
			
			$body = "Welcome คุณ  ".$name."   ".$surname."<br>
			User : ".$user_id."<br>
			PassWord : ".$pass."<br>
			<a href='https://sol.allwellhealthcare.com'>กรณาคลิ๊กลิ้งค์นี้เพื่อดำเนินการเข้าสู่ระบบ</a>";
		
						 

			mail($to, $subject, $body, $headers);

	}
	?>
<br><br>
<center>
	<?php echo "ส่งข้อมูลการ Login ไปยังช่องทางที่คุณเลือก เรียบร้อยแล้วค่ะ"; ?><br><br>
	<a href='https://sol.allwellhealthcare.com'>กรุณาคลิ๊กลิ้งค์นี้เพื่อดำเนินการเข้าสู่ระบบ</a>
</center>
<?php
	}

?>