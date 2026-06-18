

<?php



header("Content-type:text/html; charset=UTF-8");        
header("Cache-Control: no-store, no-cache, must-revalidate");       
header("Cache-Control: post-check=0, pre-check=0", false);    
include"dbconnect.php";   
include"dbconnect_sale.php";   
 include ("head9.php");  
$em_id =  $_SESSION['code'];

if($em_id == 'ADM_1' or $em_id == 'ADM' or $em_id == 'EN' or $em_id == 'SUP_EN' or $em_id == 'VMD'  or $em_id =='SUP_MK' or $em_id =='PRM'or $em_id =='IT2'){



$product_code_search = urldecode($_GET["tel_1_search"]);

$pagesize = 50; // จำนวนรายการที่ต้องการแสดง
$table_db=" tb_customer"; // ตารางที่ต้องการค้นหา
$find_field="cus_tel"; // ฟิลที่ต้องการค้นหา 
$sql = "select * from $table_db  where close_ckk = '0' and customer_id !='799' and  locate('$product_code_search', $find_field) > 0 order by locate('$product_code_search', $find_field), $find_field limit $pagesize";

$result = mysqli_query($conn,$sql);
while ($row = mysqli_fetch_array( $result )) {
	$bill_name = $row["bill_name"];
	$customer_id = $row["customer_id"];

	$bill_name = str_replace("'", "'", $bill_name);
	// กำหนดตัวหนาให้กับคำที่มีการพิมพ์
	$display_name = preg_replace("/(" . $product_code_search . ")/iu", "<b>$1</b>", $bill_name);
	echo "<li onselect=\"this.setText('$customer_id').setValue('$customer_id');\">$display_name</li>";
}

}else{
	
$strSQL1 = "SELECT * FROM tb_user_zone WHERE em_id = '".$em_id."' ";
$objQuery1 = mysqli_query($com,$strSQL1) or die(mysqli_error());
$i=1;
while($objResult1 = mysqli_fetch_array($objQuery1))
{

$zone=$objResult1["code_zone"];

$product_code_search = urldecode($_GET["tel_1_search"]);

$pagesize = 50; // จำนวนรายการที่ต้องการแสดง
$table_db=" tb_customer"; // ตารางที่ต้องการค้นหา
$find_field="cus_tel"; // ฟิลที่ต้องการค้นหา 
$sql = "select * from $table_db  where close_ckk = '0' and customer_id !='799' and sale_code = '".$zone."' and  locate('$product_code_search', $find_field) > 0 order by locate('$product_code_search', $find_field), $find_field limit $pagesize";

$result = mysqli_query($conn,$sql);
while ($row = mysqli_fetch_array( $result )) {
	$customer_name = $row["customer_no"];
	$bill_name = $row["bill_name"];
	$customer_id = $row["customer_id"];

	$customer_name = str_replace("'", "'", $customer_name);
	// กำหนดตัวหนาให้กับคำที่มีการพิมพ์
	$display_name = preg_replace("/(" . $product_code_search . ")/iu", "<b>$1</b>", $bill_name);
	echo "<li onselect=\"this.setText('$customer_id').setValue('$customer_id');\">$display_name</li>";
}
}	
	
	
}

?>