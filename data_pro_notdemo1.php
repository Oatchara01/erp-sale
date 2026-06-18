<?php
header("Content-type:text/html; charset=UTF-8");        
header("Cache-Control: no-store, no-cache, must-revalidate");       
header("Cache-Control: post-check=0, pre-check=0", false);    
include"dbconnect.php";   

include"head2.php"; 

$type_login = $_SESSION["type_login"];
$user_type = $_SESSION['user_type'];
if($type_login=='Sale' and $user_type=='Engineer'){
$sale ="engineer_ckk='1' and";
}else if($type_login=='Sale' or $type_login=='Sup_Sale'){
$sale ="sale_ckk='1' and";	
}else if($type_login=='AllWell' or $type_login=='Sup_AllWell'){
$sale ="online_ckk='1' and";	
}else if($type_login=='AllWell' or $type_login=='It'){
$sale ="adm_ckk='1' and";	
}else{
$sale ="";		
}

//province name auto complete
$product_code_search = urldecode($_GET["product_code_search"]);

$pagesize = 50; // จำนวนรายการที่ต้องการแสดง
$table_db=" tb_product"; // ตารางที่ต้องการค้นหา
$find_field="access_code"; // ฟิลที่ต้องการค้นหา
$sql = "select * from $table_db  where $sale  locate('$product_code_search', $find_field) > 0 order by locate('$product_code_search', $find_field), $find_field limit $pagesize";
//echo $sql;
$result = mysqli_query($conn,$sql);
while ($row = mysqli_fetch_array( $result )) {
		$access_code =$row["access_code"]; 	
       $product_ID =$row["product_ID"]; 	
	// ป้องกันเครื่องหมาย '
	$access_code = str_replace("'", "'", $access_code);
	// กำหนดตัวหนาให้กับคำที่มีการพิมพ์
	$display_name = preg_replace("/(" . $product_code_search . ")/iu", "<b>$1</b>", $access_code);
	echo "<li onselect=\"this.setText('$access_code').setValue('$product_ID');\">$display_name</li>";
}
?>