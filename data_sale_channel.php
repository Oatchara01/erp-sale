<?php
/*
header("Content-type:text/html; charset=UTF-8");        
header("Cache-Control: no-store, no-cache, must-revalidate");       
header("Cache-Control: post-check=0, pre-check=0", false);    
include"dbconnect.php";   

//province name auto complete
$sale_channel_search = urldecode($_GET["sale_channel_search"]);

$pagesize = 50; // จำนวนรายการที่ต้องการแสดง
$table_db=" tb_salechannel"; // ตารางที่ต้องการค้นหา
$find_field="salechannel_nameshort"; // ฟิลที่ต้องการค้นหา
$sql = "select * from $table_db  where locate('$sale_channel_search', $find_field) > 0 order by locate('$sale_channel_search', $find_field), $find_field limit $pagesize";
$result = mysqli_query($conn,$sql);
while ($row = mysqli_fetch_array( $result )) {
	$salechannel_nameshort = $row["salechannel_nameshort"]; // ฟิลที่ต้องการส่งค่ากลับ
	$description_chanel =$row["description_chanel"]; // ฟิลที่ต้องการแสดงค่า	
	$salechannel_ID =$row["salechannel_ID"];
	// ป้องกันเครื่องหมาย '
	$salechannel_nameshort = str_replace("'", "'", $salechannel_nameshort);
	// กำหนดตัวหนาให้กับคำที่มีการพิมพ์
	$display_name = preg_replace("/(" . $sale_channel_search . ")/iu", "<b>$1</b>", $salechannel_nameshort);
	echo "<li onselect=\"this.setText('$salechannel_nameshort $description_chanel').setValue('$salechannel_ID');\">$display_name</li>";
}*/
?>


<?php
include"dbconnect.php"; 
 
// Check connection
if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
 
if(isset($_REQUEST["term"])){
    // Prepare a select statement
    $sql = "SELECT * FROM tb_salechannel WHERE salechannel_nameshort LIKE ?";
    
    if($stmt = mysqli_prepare($conn, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_term);
        
        // Set parameters
        $param_term = $_REQUEST["term"] . '%';
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
            
            // Check number of rows in the result set
            if(mysqli_num_rows($result) > 0){
                // Fetch result rows as an associative array
                while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                    echo "<p>" . $row["salechannel_nameshort"] . " " . $row["description_chanel"] . "</p>";
                }
            } else{
                echo "<p>No matches found</p>";
            }
        } else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
        }
    }
     
    // Close statement
    mysqli_stmt_close($stmt);
}
 
// close connection
mysqli_close($conn);
?>