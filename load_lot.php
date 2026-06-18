<?php
include('dbconnect.php');

$id = $_GET['product_id'] ?? ''; // จริงๆ คือ id, ไม่ใช่ product_id ตรงๆ
$data = [];

if ($id) {
    // ป้องกัน SQL Injection ด้วย prepared statement
    $stmt1 = $conn->prepare("SELECT product_id FROM tb_prowaranty WHERE id = ?");
    $stmt1->bind_param("i", $id);
    $stmt1->execute();
    $result1 = $stmt1->get_result();
    $rs = $result1->fetch_assoc();
    $product_id = $rs['product_id'] ?? '';

    if ($product_id) {
        $stmt2 = $new->prepare("SELECT lot_no FROM st__lotno WHERE product_id = ? ORDER BY id");
        $stmt2->bind_param("s", $product_id);
        $stmt2->execute();
        $result2 = $stmt2->get_result();

        while ($row = $result2->fetch_assoc()) {
            $data[] = $row;
        }
    }
}

header('Content-Type: application/json');
echo json_encode($data);
?>
