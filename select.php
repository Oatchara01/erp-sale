<?php
include('dbconnect.php');

$sale_channel = isset($_POST['sale_channel']) ? $_POST['sale_channel'] : "";
$Query = mysqli_query($conn,"SELECT * FROM tb_salechannel WHERE salechannel_nameshort='$sale_channel'");
$Rows = mysqli_num_rows($Query);
if ($Rows > 0) {
    while ($Result = mysqli_fetch_array($Query,MYSQLI)_ASSOC)) {
        echo "<option value=\"" . $Result['salechannel_ID'] . "\">" . $Result['salechannel_nameshort'] . "</option>";
    }
}else{
    echo "<option value=\"\">ไม่มีช่องทางการขายที่เลือก</option>";
}
?>