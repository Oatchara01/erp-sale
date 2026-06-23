<?php
require_once 'dbconnect_acc.php';

function firstExistingColumn($connection, $tableName, $candidates)
{
    foreach ($candidates as $columnName) {
        $safeColumn = mysqli_real_escape_string($connection, $columnName);
        $safeTable = mysqli_real_escape_string($connection, $tableName);
        $check = mysqli_query($connection, "SHOW COLUMNS FROM `{$safeTable}` LIKE '{$safeColumn}'");
        if ($check && mysqli_num_rows($check) > 0) {
            return $columnName;
        }
    }

    return null;
}

$tableName = 'tb_typebank';
$idColumn = firstExistingColumn($code, $tableName, array('id_typebank', 'id', 'typebank_id', 'bank_type_id'));
$labelColumn = firstExistingColumn($code, $tableName, array('name_typebank', 'typebank_name', 'type_name', 'bank_type_name', 'name'));
$sortColumn = firstExistingColumn($code, $tableName, array('number', 'sort_order', 'id'));

if (!$idColumn || !$labelColumn) {
    http_response_code(500);
    echo '<option value="">ไม่พบโครงสร้าง tb_typebank ที่รองรับ</option>';
    exit;
}

$sql = "SELECT `{$idColumn}` AS option_id, `{$labelColumn}` AS option_label FROM `{$tableName}`";
if ($sortColumn) {
    $sql .= " ORDER BY `{$sortColumn}`";
}

$res = mysqli_query($code, $sql);
if (!$res) {
    http_response_code(500);
    echo '<option value="">โหลดวิธีชำระเงินไม่สำเร็จ</option>';
    exit;
}

$options = '';
while ($row = mysqli_fetch_assoc($res)) {
    $options .= '<option value="' . htmlspecialchars($row['option_id'], ENT_QUOTES) . '">' .
        htmlspecialchars($row['option_label'], ENT_QUOTES) .
        '</option>';
}

echo $options;
