<?php


include("dbconnect.php");
include ("error_page.php"); 
include("head.php");


?>

<form name="frmadd" method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">

<?php 

$ref_id = $_GET["ref_id"];
$sale_code = $_GET['sale_code'];
$employee_code = $_GET['employee_code'];


?>
<div  class="w3-white" >
	<div class="w3-container">
		<div class="w3-panel w3-light-grey"><h3>รายละเอียดการแก้ไข</h3></div>
<div class="w3-bar w3-margin-bottom">
รายละเอียด :
<textarea name="description"  class="w3-input" id="description" style="width:50%" rows="2" required></textarea>
	
	<input type="hidden" name="employee_code" value = "<?php echo $employee_code; ?>" style="width:30%;" class="w3-input"  readonly>
	<input type="hidden" name="sale_code" value = "<?php echo $sale_code; ?>" style="width:30%;" class="w3-input"  readonly>
	<input type="hidden" name="ref_id" value = "<?php echo $ref_id; ?>" style="width:30%;" class="w3-input"  readonly>
	</div>	
		
		<br>
		<div class="w3-bar w3-center">
			<input type="submit" name="submit" class="w3-button w3-teal be-border" value="submit">
	</div><br>

	</div></div>

</form>
<?php
if(isset($_POST["submit"])) {
date_default_timezone_set("Asia/Bangkok");
	

$ref_id = $_POST["ref_id"];
$sale_code = $_POST['sale_code'];
$employee_code = $_POST['employee_code'];
$description = $_POST['description'];
$name =  $_SESSION['name'];
$surname =	$_SESSION['surname'];
$add_by = "$name $surname";
$month =	date("m");
$yearto = date("Y")+543;
$yearsave = date("Y");
$today_save = "$yearsave-$month";

	

$strSQL = "UPDATE st__checkbr SET send_sup='0'  where ref_id ='".$ref_id."'";
$objQuery = mysqli_query($conn,$strSQL);	
	
	
$qfirst = "select lind_add from tb_user where em_id = '".$employee_code."'";
$first = mysqli_query($conn,$qfirst);
$ffirst = mysqli_fetch_array($first);
	
$lind_add = $ffirst["lind_add"];


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
$sToken = $lind_add; 
//$sToken	="CMXUBCXx0tXyGUKwsShIQ4j66thdHOm6iD3MsQlmmIU";
$sMessage = "มีการส่งกลับการตรวจเช็ครายการใบยืมประจำเดือน $month-$yearto
เขตการขาย : $sale_code
ส่งกลับโดย : $add_by
รายละเอียด : $description
รบกวนทำการแก้ได้ทางลิงค์ด้านล่างค่ะ
https://sol.allwellcenter.com/
";
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
echo 'error:' . curl_error($chOne);
}
else {
$result_ = json_decode($result, true);
echo "status : ".$result_['status']; echo "message : ". $result_['message'];
}
curl_close( $chOne ); 



 if($objQuery){
   echo "<script language=\"JavaScript\">";
echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='status_appckkst.php';";
echo "</script>";
  } else {
   echo "Cannot";
  }
	
}

?>

