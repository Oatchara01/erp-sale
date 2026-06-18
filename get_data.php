<?php

$sql = "SELECT *  FROM tb__buypro_ser   Order by sumary DESC";
    //$result = $conn->query($sql);
$result = mysqli_query($conn,$sql) or die ("Error Query [".$sql."]");
    //ส่งออกข้อมูลกลับไปที่ web browser ในรูปแบบ JSON
    $rows = array();
	//$rows1 = array();
    while($r = mysqli_fetch_assoc($result)) {
        $rows[] = $r["group_1"];
		$rows1[] = $r["sumary"];
    }
    echo json_encode($rows);
 echo json_encode($rows1);



?>