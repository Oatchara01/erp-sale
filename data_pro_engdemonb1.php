<?php
header("Content-type:text/html; charset=UTF-8");        
header("Cache-Control: no-store, no-cache, must-revalidate");       
header("Cache-Control: post-check=0, pre-check=0", false);    
include"dbconnect.php";   

//province name auto complete
$product_code_search = urldecode($_GET["product_code_search"]);

$pagesize = 50; // จำนวนรายการที่ต้องการแสดง
$table_db=" tb_product"; // ตารางที่ต้องการค้นหา
$find_field="access_code"; // ฟิลที่ต้องการค้นหา
$sql = "select * from $table_db  where engineer_ckk ='1' and demo_ckk='0' and type_company = 'NBM' and close_pro ='0' and  locate('$product_code_search', $find_field) > 0 order by locate('$product_code_search', $find_field), $find_field limit $pagesize";
$result = mysqli_query($conn,$sql);
while ($row = mysqli_fetch_array( $result )) {
		$access_code =$row["access_code"]; 	
		$sol_code =$row["access_code"]; 
	
	// ป้องกันเครื่องหมาย '
	$access_code = str_replace("'", "'", $access_code);
	// กำหนดตัวหนาให้กับคำที่มีการพิมพ์
	$display_name = preg_replace("/(" . $product_code_search . ")/iu", "<b>$1</b>", $access_code);
	echo "<li onselect=\"this.setText('$sol_code').setValue('$sol_code');\">$display_name</li>";
}
?>