<?php
// YOU MIGHT WANT TO ADD SOME SECURITY ON THIS PAGE
// E.G. CHECK IF VALID USER LOGIN
// if (isset($_SESSION['admin'])) { ... DO SEARCH AS BELOW ... }
 
// (1) CONNECT TO DATABASE
include('dbconnect.php');

// (2) SEARCHING FOR?
$data = [];
switch ($_POST['type']) {
  // (2A) INVALID SEARCH TYPE
  default :
    break;
 
  // (2B) SEARCH FOR USER
  case "customer":
    // You might want to limit number of results on massive databases
    // SELECT * FROM XYZ WHERE `FIELD` LIKE ? LIMIT 20
    $stmt = $pdo->prepare("SELECT * FROM tb_customer WHERE customer_name LIKE ?");
    $stmt->execute(["%" . $_POST['term'] . "%"]);
    while ($row = $stmt->fetch(PDO::FETCH_NAMED)) {
      $data[] = $row['customer_name'];
    }
    break;
 
  // (2C) SEARCH FOR EMAIL
  case "address":
    $stmt = $pdo->prepare("SELECT * FROM tb_customer WHERE address LIKE ?");
    $stmt->execute(["%" . $_POST['term'] . "%"]);
    while ($row = $stmt->fetch(PDO::FETCH_NAMED)) {
      $data[] = $row['address'];
    }
    break;
}

// (3) RETURN RESULT
$pdo = null;
echo json_encode($data);
?>