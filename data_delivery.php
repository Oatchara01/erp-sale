<?php
header("Content-type:text/html; charset=UTF-8");        
header("Cache-Control: no-store, no-cache, must-revalidate");       
header("Cache-Control: post-check=0, pre-check=0", false);    
include"dbconnect.php";   

//province name auto complete
$delivery_search = urldecode($_GET["delivery_search"]);

$pagesize = 50; // จำนวนรายการที่ต้องการแสดง
$table_db=" tb_delivery"; // ตารางที่ต้องการค้นหา
$find_field="delivery_name"; // ฟิลที่ต้องการค้นหา
$sql = "select * from $table_db  where locate('$delivery_search', $find_field) > 0 order by locate('$delivery_search', $find_field), $find_field limit $pagesize";
$result = mysqli_query($conn,$sql);
while ($row = mysqli_fetch_array( $result )) {
	$delivery_name = $row["delivery_name"]; // ฟิลที่ต้องการส่งค่ากลับ
	$time_delivery =$row["time_delivery"]; // ฟิลที่ต้องการแสดงค่า	
	$delivery_id =$row["delivery_id"];
	// ป้องกันเครื่องหมาย '
	$delivery_name = str_replace("'", "'", $delivery_name);
	// กำหนดตัวหนาให้กับคำที่มีการพิมพ์
	$display_name = preg_replace("/(" . $delivery_search . ")/iu", "<b>$1</b>", $delivery_name );
	echo "<li onselect=\"this.setText('$delivery_name $time_delivery').setValue('$delivery_id');\">$display_name $time_delivery</li>";
}
?>