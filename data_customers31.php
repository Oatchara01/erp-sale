<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);


header("Content-type:text/html; charset=UTF-8");        
header("Cache-Control: no-store, no-cache, must-revalidate");       
header("Cache-Control: post-check=0, pre-check=0", false);    
include"dbconnect.php";   
include"head2.php"; 
include "dbconnect_sale.php";
$name = $_SESSION["name"];
$em_id = $_SESSION["code"];

//province name auto complete
$customer_code_search = urldecode($_GET["customer_code_search"]);


if($name=='ชลชินี' or $name=='สมบัติ' or $name=='อัจฉรา' or  $name=='ลักษณาวรรณ'){
$pagesize = 50; // จำนวนรายการที่ต้องการแสดง
$table_db=" tb_customer"; // ตารางที่ต้องการค้นหา
$find_field="customer_name"; // ฟิลที่ต้องการค้นหา
$sql = "select * from $table_db  where  close_ckk='0' and locate('$customer_code_search', $find_field) > 0 order by locate('$customer_code_search', $find_field), $find_field limit $pagesize";
$result = mysqli_query($conn,$sql);
while ($row = mysqli_fetch_array( $result )) {
	$customer_name = $row["customer_name"]; // ฟิลที่ต้องการส่งค่ากลับ
	$customer_id =$row["customer_id"];
	// ป้องกันเครื่องหมาย '
	$customer_name = str_replace("'", "'", $customer_name);
	// กำหนดตัวหนาให้กับคำที่มีการพิมพ์
	$display_name = preg_replace("/(" . $customer_code_search . ")/iu", "<b>$1</b>", $customer_name);
	echo "<li onselect=\"this.setText('$customer_name').setValue('$customer_id');\">$display_name</li>";	
}	
}else{

   $pagesize = 50;
$em_id = $_SESSION['code'] ?? '';
$customer_code_search = urldecode($_GET["customer_code_search"] ?? '');
$customer_code_search_sql = mysqli_real_escape_string($conn, $customer_code_search);

$strSQL77 = "SELECT code_zone FROM tb_user_zone WHERE em_id = '" . mysqli_real_escape_string($com, $em_id) . "'";
$objQuery77 = mysqli_query($com, $strSQL77) or die(mysqli_error($com));

while ($objResult77 = mysqli_fetch_array($objQuery77)) {
    $zone_code = $objResult77["code_zone"];

    $strSQL71 = "SELECT id_customer FROM tb_selected_sales WHERE sale_code = '" . mysqli_real_escape_string($conn, $zone_code) . "'";
    $objQuery71 = mysqli_query($conn, $strSQL71) or die(mysqli_error($conn));

    while ($objResult71 = mysqli_fetch_array($objQuery71)) {
        $customer_id = $objResult71["id_customer"];

        $sql = "SELECT customer_id, customer_name
                FROM tb_customer
                WHERE close_ckk = '0'
                  AND customer_id = '" . mysqli_real_escape_string($conn, $customer_id) . "'
                  AND LOCATE('$customer_code_search_sql', customer_name) > 0
                ORDER BY customer_name ASC
                LIMIT $pagesize";
		
	

        $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
		

        while ($row = mysqli_fetch_array($result)) {
            $customer_name = $row["customer_name"];
            $customer_id   = $row["customer_id"];

            $display_name = preg_replace("/(" . preg_quote($customer_code_search, "/") . ")/iu", "<b>$1</b>", $customer_name);
            echo "<li onselect=\"this.setText('$customer_name').setValue('$customer_id');\">$display_name</li>";
        }
    }
}
}
?>