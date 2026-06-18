

<?php



header("Content-type:text/html; charset=UTF-8");        
header("Cache-Control: no-store, no-cache, must-revalidate");       
header("Cache-Control: post-check=0, pre-check=0", false);    
include"dbconnect.php";   
include"dbconnect_sale.php";   
 include ("head9.php");  
$em_id =  $_SESSION['code'];
$type_login =  $_SESSION['type_login'];
$user_type =  $_SESSION['user_type'];

if($user_type=='Sale'){

$strSQL71 = "SELECT * FROM tb_selected_sales WHERE sale_code ='".$em_id."'";

$objQuery71 = mysqli_query($conn,$strSQL71) or die(mysqli_error());
$i=1;
while($objResult71 = mysqli_fetch_array($objQuery71))
{

$customer_id=$objResult71["id_customer"];

$product_code_search = urldecode($_GET["bill_search"]);

$pagesize = 50; // จำนวนรายการที่ต้องการแสดง
$table_db=" tb_customer"; // ตารางที่ต้องการค้นหา
$find_field="customer_name"; // ฟิลที่ต้องการค้นหา 
$sql = "select * from $table_db  where close_ckk = '0' and customer_id = '".$customer_id."' and customer_id !='799' and  locate('$product_code_search', $find_field) > 0 order by locate('$product_code_search', $find_field), $find_field limit $pagesize";
$result = mysqli_query($conn,$sql);
while ($row = mysqli_fetch_array( $result )) {
	$bill_name = $row["customer_name"];
	$customer_id = $row["customer_id"];

	$bill_name = str_replace("'", "'", $bill_name);
	// กำหนดตัวหนาให้กับคำที่มีการพิมพ์
	$display_name = preg_replace("/(" . $product_code_search . ")/iu", "<b>$1</b>", $bill_name);
	echo "<li onselect=\"this.setText('$customer_id').setValue('$customer_id');\">$display_name</li>";
}
}	
}else if($type_login=='Sup_Sale'){
	
$product_code_search = urldecode($_GET["bill_search"]);
$pagesize = 50;
$find_field = "customer_name";

$strSQL77 = "SELECT * FROM tb_user_zone WHERE em_id = '".$em_id."' ";
$objQuery77 = mysqli_query($com, $strSQL77) or die(mysqli_error($com));

while ($objResult77 = mysqli_fetch_array($objQuery77)) {
    $zone_code = $objResult77["code_zone"];
    
    $strSQL71 = "SELECT * FROM tb_selected_sales WHERE sale_code = '".$zone_code."' ";
    $objQuery71 = mysqli_query($conn, $strSQL71) or die(mysqli_error($conn));

    while ($objResult71 = mysqli_fetch_array($objQuery71)) {
        $customer_id = $objResult71["id_customer"];
        $table_db = "tb_customer";

        $sql = "SELECT * FROM $table_db  
                WHERE close_ckk = '0' 
                  AND customer_id = '".$customer_id."' 
                  AND LOCATE('$product_code_search', $find_field) > 0 
                ORDER BY LOCATE('$product_code_search', $find_field), $find_field 
                LIMIT $pagesize";


        $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        while ($row = mysqli_fetch_array($result)) {
            $customer_name = $row["customer_name"];
            $bill_name = $row["bill_name"];
            $customer_id = $row["customer_id"];

            $display_name = preg_replace("/(" . preg_quote($product_code_search, '/') . ")/iu", "<b>$1</b>", $customer_name);
            echo "<li onselect=\"this.setText('$customer_id').setValue('$customer_id');\">$display_name</li>";
        }
    }
}
	
}else if($type_login=='AllWell' and $em_id !='MK'){
	
	
$product_code_search = urldecode($_GET["bill_search"]);

$pagesize = 50;
$table_db = "tb_customer c LEFT JOIN tb_selected_sales s ON c.customer_id = s.id_customer";
$find_field = "c.customer_name"; // ระบุ alias ด้วย
$sql = "SELECT c.customer_name,c.bill_name,c.customer_id 
        FROM $table_db  
        WHERE c.close_ckk = '0' 
          AND s.sale_code LIKE '%SOL%' 
          AND LOCATE('$product_code_search', $find_field) > 0 
        ORDER BY LOCATE('$product_code_search', $find_field), $find_field 
        LIMIT $pagesize";

$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_array($result)) {
    $customer_name = $row["customer_name"];
    $bill_name = $row["bill_name"];
    $customer_id = $row["customer_id"];

    // ขีดเส้นใต้คำที่ค้นหา
    $display_name = preg_replace("/(" . preg_quote($product_code_search, '/') . ")/iu", "<b>$1</b>", $customer_name);
    
    echo "<li onselect=\"this.setText('$customer_id').setValue('$customer_id');\">$display_name</li>";
}

	
}else{



$product_code_search = urldecode($_GET["bill_search"]);

$pagesize = 50; // จำนวนรายการที่ต้องการแสดง
$table_db=" tb_customer"; // ตารางที่ต้องการค้นหา
$find_field="customer_name"; // ฟิลที่ต้องการค้นหา 
$sql = "select * from $table_db  where close_ckk = '0' and customer_id !='799' and  locate('$product_code_search', $find_field) > 0 order by locate('$product_code_search', $find_field), $find_field limit $pagesize";

$result = mysqli_query($conn,$sql);
while ($row = mysqli_fetch_array( $result )) {
	$bill_name = $row["customer_name"];
	$customer_id = $row["customer_id"];

	$bill_name = str_replace("'", "'", $bill_name);
	// กำหนดตัวหนาให้กับคำที่มีการพิมพ์
	$display_name = preg_replace("/(" . $product_code_search . ")/iu", "<b>$1</b>", $bill_name);
	echo "<li onselect=\"this.setText('$bill_name').setValue('$customer_id');\">$display_name</li>";
}
}

?>