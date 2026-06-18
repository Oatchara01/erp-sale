<?php 
// require_once __DIR__ . "/../Models/Methos_User.php";
$stock = mysqli_connect("localhost","allwell_stock","Pass@2020","allwell_stock");

function username($stock, $em_id) {

    mysqli_set_charset($stock,"utf8");
    $stmt = $stock->prepare("SELECT * FROM tb_user WHERE em_id = ?");
    $stmt->bind_param("s", $em_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $vName = $result->fetch_array();

    if ($vName) {
        return $vName['name'] . ' ' . $vName['surname'];
    } else {
        return "ไม่พบข้อมูล";
    }
    // <td class='w3-center' style='vertical-align:middle;'>" . username($stock, $user['add_by']) . "</td>
}

function product_name($stock, $product_ID) { // รายการสินค้า 1 จำนวน

    mysqli_set_charset($stock,"utf8");
    $stmt = $stock->prepare("SELECT * FROM tb_product WHERE product_ID = ?");
    $stmt->bind_param("s", $product_ID);
    $stmt->execute();
    $result = $stmt->get_result();
    $vproduct = $result->fetch_array();

    if ($vproduct) {
        return $vproduct['sol_name'];
    } else {
        return "ไม่พบข้อมูล";
    }
    // product_name($stock, $user['product_ID']);
}

function rental_item($stock, $ref_id) { // รายการสินค้า จำนวน หน่วย   หลายจำนวน
    $query = "
        SELECT p.sol_name,p.unit_name,r.wr_count
        FROM tb__rental_item r
        INNER JOIN tb_product p ON r.product_ID = p.product_ID
        WHERE r.ref_id = '".$ref_id."'
    ";
    $result = mysqli_query($stock, $query);
    
    $items = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $items[] = $row['sol_name'].' <small class="w3-gray" style="padding:0px 4px;">'.$row['wr_count'].'</small> '.$row['unit_name'];
    }

    return $items; // ส่งกลับรายการสินค้าทั้งหมดเป็น array

    // ตัวอย่างการใช้งาน
    // $items = rental_item($stock, $user['ref_id']);  // ดึงรายการสินค้าจากฟังก์ชัน rental_item
    // $items_string = implode('<br>', $items); // แปลง array ให้เป็น string โดยคั่นด้วยลูกน้ำ
    //   <td style='vertical-align:middle;'>" . $items_string . "</td> // นำไปแสดง
}

function Date_thai_time($strDate) { // รายการสินค้า 1 จำนวน

        $strtime = substr($strDate,-8); // time

		$strYear = date("Y",strtotime($strDate))+543;
		$strMonth= date("n",strtotime($strDate));
		$strDay= date("j",strtotime($strDate));
		$strHour= date("H",strtotime($strDate));
		$strMinute= date("i",strtotime($strDate));
		$strSeconds= date("s",strtotime($strDate));
		$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		$strMonthThai=$strMonthCut[$strMonth];
		return "$strDay $strMonthThai $strYear $strtime";
}

function Status_name($status_key) {
    switch ($status_key) {
        case '0': $status_name = 'ดำเนินการ'; break;
        case '1': $status_name = '<font style="color:#ff8000;">Return</font>'; break;
        case '2': $status_name = '<font style="color:#bbbb00;">รอMDอนุมัติ</font>'; break;
        case '3': $status_name = '<font style="color:#4D9E46;">Approved</font>'; break;
        case '4': $status_name = '<font style="color:#E63946;">Rejected</font>'; break;
        default: $status_name = 'N/A'; break;
    }
    return $status_name;
}

?>