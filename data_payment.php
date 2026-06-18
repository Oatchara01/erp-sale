<?php
header("Content-type:text/html; charset=UTF-8");        
header("Cache-Control: no-store, no-cache, must-revalidate");       
header("Cache-Control: post-check=0, pre-check=0", false);    
include"dbconnect.php";   

//province name auto complete
$payment_search = urldecode($_GET["payment_search"]);

$pagesize = 50; // จำนวนรายการที่ต้องการแสดง
$table_db=" tb_payment"; // ตารางที่ต้องการค้นหา
$find_field="payment_name"; // ฟิลที่ต้องการค้นหา
$sql = "select * from $table_db  where close_ckk='0' and locate('$payment_search', $find_field) > 0 order by locate('$payment_search', $find_field), $find_field limit $pagesize";
$result = mysqli_query($conn,$sql);
while ($row = mysqli_fetch_array( $result )) {
	$payment_name = $row["payment_name"]; // ฟิลที่ต้องการส่งค่ากลับ
	$bank_name =$row["bank_name"]; // ฟิลที่ต้องการแสดงค่า	
	$payment_ID =$row["payment_ID"];
	$book_name =$row["book_name"];

	// ป้องกันเครื่องหมาย '
	$payment_name = str_replace("'", "'", $payment_name);
	// กำหนดตัวหนาให้กับคำที่มีการพิมพ์
	$display_name = preg_replace("/(" . $payment_search . ")/iu", "<b>$1</b>", $payment_name);
	echo "<li onselect=\"this.setText('$payment_name $bank_name $book_name').setValue('$payment_ID');\">$display_name $bank_name $book_name</li>";
}
?>