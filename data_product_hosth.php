<?php
header("Content-type:text/html; charset=UTF-8");        
header("Cache-Control: no-store, no-cache, must-revalidate");       
header("Cache-Control: post-check=0, pre-check=0", false);    
include"dbconnect.php";   
include"head2.php";   
$em_id =  $_SESSION['code'];

$product_code_search = urldecode($_GET["product_code_search"]);

if($em_id == 'EN1' or $em_id == 'EN2' or $em_id == 'EN3' or $em_id == 'EN4' or $em_id == 'EN5' or $em_id == 'EN6' or $em_id == 'EN7' or $em_id == 'EN8' or $em_id == 'EN9' or $em_id == 'EN10' or $em_id == 'EN11' or $em_id == 'EN12' or $em_id == 'EN13' or $em_id == 'EN14' or $em_id == 'EN15' or $em_id == 'EN16' or $em_id == 'EN17' or $em_id == 'SUP_EN'){
	
$pagesize = 50; // จำนวนรายการที่ต้องการแสดง
$table_db=" tb_product"; // ตารางที่ต้องการค้นหา
$find_field="sol_name"; // ฟิลที่ต้องการค้นหา
$sql = "select * from $table_db  where engineer_ckk='1' and type_company='AWL'  and locate('$product_code_search', $find_field) > 0 order by locate('$product_code_search', $find_field), $find_field limit $pagesize";
$result = mysqli_query($conn,$sql);
while ($row = mysqli_fetch_array( $result )) {
	$access_name = $row["sol_name"]; // ฟิลที่ต้องการส่งค่ากลับ
	$access_code =$row["access_code"]; // ฟิลที่ต้องการแสดงค่า	

	// ป้องกันเครื่องหมาย '
	$access_name = str_replace("'", "'", $access_name);
	// กำหนดตัวหนาให้กับคำที่มีการพิมพ์
	$display_name = preg_replace("/(" . $product_code_search . ")/iu", "<b>$1</b>", $access_name);
	echo "<li onselect=\"this.setText('$access_code').setValue('$access_code');\">$display_name</li>";
}	
	
}else{
$pagesize = 50; // จำนวนรายการที่ต้องการแสดง
$table_db=" tb_product"; // ตารางที่ต้องการค้นหา
$find_field="sol_name"; // ฟิลที่ต้องการค้นหา
$sql = "select * from $table_db  where sale_ckk='1' and type_company='AWL'  and locate('$product_code_search', $find_field) > 0 order by locate('$product_code_search', $find_field), $find_field limit $pagesize";
$result = mysqli_query($conn,$sql);
while ($row = mysqli_fetch_array( $result )) {
	$access_name = $row["sol_name"]; // ฟิลที่ต้องการส่งค่ากลับ
	$access_code =$row["access_code"]; // ฟิลที่ต้องการแสดงค่า	

	// ป้องกันเครื่องหมาย '
	$access_name = str_replace("'", "'", $access_name);
	// กำหนดตัวหนาให้กับคำที่มีการพิมพ์
	$display_name = preg_replace("/(" . $product_code_search . ")/iu", "<b>$1</b>", $access_name);
	echo "<li onselect=\"this.setText('$access_code').setValue('$access_code');\">$display_name</li>";
}
}
?>