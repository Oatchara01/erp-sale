<?php
header("Content-type:text/html; charset=UTF-8");        
header("Cache-Control: no-store, no-cache, must-revalidate");       
header("Cache-Control: post-check=0, pre-check=0", false);    
include"dbconnect.php";   

//province name auto complete
$employee_name_search = urldecode($_GET["employee_name_search"]);

$pagesize = 50; // จำนวนรายการที่ต้องการแสดง
$table_db=" tb_employee"; // ตารางที่ต้องการค้นหา
$find_field="employee_name"; // ฟิลที่ต้องการค้นหา
$sql = "select * from $table_db  where locate('$employee_name_search', $find_field) > 0 order by locate('$employee_name_search', $find_field), $find_field limit $pagesize";
$result = mysqli_query($conn,$sql);
while ($row = mysqli_fetch_array( $result )) {
	$employee_name = $row["employee_name"]; // ฟิลที่ต้องการส่งค่ากลับ
	$employee_ID =$row["employee_ID"];
	// ป้องกันเครื่องหมาย '
	$employee_name = str_replace("'", "'", $employee_name);
	// กำหนดตัวหนาให้กับคำที่มีการพิมพ์
	$display_name = preg_replace("/(" . $employee_name_search . ")/iu", "<b>$1</b>", $employee_name);
	echo "<li onselect=\"this.setText('$employee_name').setValue('$employee_ID');\">$display_name</li>";
}
?>