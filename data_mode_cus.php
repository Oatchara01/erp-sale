

<?php
session_start();

header("Content-type:text/html; charset=UTF-8");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
include "dbconnect.php";
include "dbconnect_sale.php";
//  include ("head9.php");  
$em_id =  $_SESSION['code'] ?? '';
$type_login =  $_SESSION['type_login'] ?? '';
$user_type =  $_SESSION['user_type'] ?? '';

$name =  $_SESSION['name'] ?? '';

if ($name == 'มาลินี' or $em_id == 'S31') {
	$sale_code = "(sale_code = 'S31' OR sale_code = 'S32' ) and";
} else {
	$sale_code = "";
}

$product_code_search = urldecode($_GET["bill_search"]);

$pagesize = 50; // จำนวนรายการที่ต้องการแสดง
$table_db = " tb_mode_customer"; // ตารางที่ต้องการค้นหา
$find_field = "mode_name"; // ฟิลที่ต้องการค้นหา 
$sql = "select * from $table_db  where $sale_code locate('$product_code_search', $find_field) > 0 order by locate('$product_code_search', $find_field), $find_field limit $pagesize";

$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_array($result)) {
	$bill_name = $row["mode_name"];
	$customer_id = $row["id_mode"];

	$bill_name = str_replace("'", "'", $bill_name);
	// กำหนดตัวหนาให้กับคำที่มีการพิมพ์
	$display_name = preg_replace("/(" . $product_code_search . ")/iu", "<b>$1</b>", $bill_name);
	echo "<li onselect=\"this.setText('$bill_name').setValue('$customer_id');\">$display_name</li>";
}


?>