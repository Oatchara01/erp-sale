<?php
session_start();
ob_start();
// bank_options.php
require_once 'dbconnect_acc.php'; // ไฟล์เชื่อมต่อ DB ที่ประกาศ $code = mysqli_connect(...)

$creditOnly = isset($_GET['credit_only']) ? trim($_GET['credit_only']) : '';
$sdd = $_SESSION["code"];


$sql = "
  SELECT id, pay_in
  FROM tb_bank
  WHERE close_ckk='0' AND company!='4'

";  

//" . ($creditOnly == '0' ? " AND credit_ckk='1' " : " AND credit_ckk='0' ") . "  ORDER BY number

if (in_array($sdd, ['S31', 'S32', 'MM1', 'SS3'])) {
    $sql .= ($creditOnly == '0') ? " AND credit_ckk='1' " : " AND credit_ckk='0' ";
}
$sql .= " ORDER BY number";

$res = mysqli_query($code, $sql);
if (!$res) {
  http_response_code(500);
  echo "/* Failed to fetch to MySQL: ".mysqli_error($code)." */";
  exit;
}

$options = '';
while ($row = mysqli_fetch_assoc($res)) {
  // หมายเหตุ: ถ้าต้องการให้เลือกค่า '0' เพื่อ trigger เงื่อนไข สามารถเพิ่ม option แยกเอง
  $options .= '<option value="'.htmlspecialchars($row['id'], ENT_QUOTES).'">'.
               htmlspecialchars($row['pay_in'], ENT_QUOTES).'
			   </option>';
}

// อาจเพิ่มตัวเลือกพิเศษค่า '0' (เครดิต) ถ้าธุรกิจคุณใช้ค่านี้จริง ๆ
// $options = '<option value="0">ชำระแบบเครดิต (credit)</option>'.$options;

echo $options;
