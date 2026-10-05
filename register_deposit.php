<?php

include('head.php');

if (!isset($conn)) {
    include('dbconnect.php');
}

date_default_timezone_set("Asia/Bangkok");


/*
|--------------------------------------------------------------------------
| Helper
|--------------------------------------------------------------------------
*/

function depPost($key, $default = '')
{
    return isset($_POST[$key])
        ? trim((string)$_POST[$key])
        : $default;
}


function depH($value)
{
    return htmlspecialchars(
        (string)$value,
        ENT_QUOTES,
        'UTF-8'
    );
}


function depMoney($value)
{
    $value = str_replace(
        ',',
        '',
        trim((string)$value)
    );

    if ($value === '' || !is_numeric($value)) {
        return 0;
    }

    return (float)$value;
}


/*
|--------------------------------------------------------------------------
| อ่าน Column จริงของ tb_deposit
| ป้องกันกรณีบาง Server ไม่มีบาง field
|--------------------------------------------------------------------------
*/

$depositColumns = array();

$sqlColumns = "SHOW COLUMNS FROM tb_deposit";
$queryColumns = mysqli_query($conn, $sqlColumns);

if ($queryColumns) {

    while ($columnRow = mysqli_fetch_assoc($queryColumns)) {

        $depositColumns[
            $columnRow['Field']
        ] = true;
    }
}


function depHasColumn($columns, $name)
{
    return isset($columns[$name]);
}


/*
|--------------------------------------------------------------------------
| อ่าน Column จริงของ tb_transaction
| รายละเอียดการจัดส่ง/หน้างานของระบบเดิมเก็บอยู่ตารางนี้
|--------------------------------------------------------------------------
*/

$transactionColumns = array();
$sqlTransactionColumns = "SHOW COLUMNS FROM tb_transaction";
$queryTransactionColumns = mysqli_query($conn, $sqlTransactionColumns);

if ($queryTransactionColumns) {
    while ($transactionColumnRow = mysqli_fetch_assoc($queryTransactionColumns)) {
        $transactionColumns[$transactionColumnRow['Field']] = true;
    }
}


/*
|--------------------------------------------------------------------------
| MODE
|--------------------------------------------------------------------------
*/

$editMode = false;
$editDepositCode = '';

if (
    isset($_GET['deposit_code']) &&
    trim($_GET['deposit_code']) !== ''
) {

    $editMode = true;
    $editDepositCode = trim($_GET['deposit_code']);
}


/*
|--------------------------------------------------------------------------
| Default Data
|--------------------------------------------------------------------------
*/

$depData = array(
    'deposit_code' => '',
    'bill_date' => date('Y-m-d'),
    'iv_no' => '',
    'bill_name' => '',
    'bill_address' => '',
    'bill_tel' => '',
    'customer_contact' => '',
    'tax_id' => '',

    'delivery_date' => '',
    'delivery_time' => '',
    'department' => '',
    'delivery_name' => '',
    'delivery_tel' => '',
    'delivery_address' => '',

    'payment' => '',
    'bank_name' => '',
    'bank_card' => '',
    'check_no' => '',
    'branch_name' => '',
    'payment_date' => '',

    'employee_signature_name' => '',

    'more' => '0',
    'runway' => '0',
    'road' => '0',
    'soy' => '0',
    'soy_big' => '',
    'height_ltd' => '0',
    'car_load' => '0',
    'no_car_road' => '0',
    'car_park' => '',
    'car_road' => '0',
    'car_home' => '0',
    'door_long' => '',
    'slope' => '0',
    'bundai' => '0',
    'unit_bundai' => '',
    'door_bigger' => '',
    'door_longer' => '',
    'room_bigger' => '',
    'room_longer' => '',
    'type_door' => '',
    'home_type' => '',
    'install' => '',
    'bundai_install' => '0',
    'bundai_big' => '',
    'bundai_hug' => '',
    'type_bundai' => '',
    'lip' => '0',
    'lip_big' => '',
    'lip_long' => '',
    'lip_weight' => '',
    'up' => '0',
    'no_up' => '0',
    'head_bad' => '0',
    'want_employee' => '0',
    'employee_unit' => '',
    'ferniger_name' => '',
    'ferniger_address' => '',
    'want_ex' => '0',
    'want_credit' => '0',
    'bank' => '',
    'want_prem' => '0',
    'description_ja' => '',
    'sum_unit_price' => '0'
);


for ($i = 1; $i <= 15; $i++) {

    $depData['product_name' . $i] = '';
    $depData['h_product_name' . $i] = '';
    $depData['unit_price' . $i] = '0';
}


/*
|--------------------------------------------------------------------------
| LOAD EDIT DATA
|--------------------------------------------------------------------------
*/

if ($editMode) {

    $editCodeDb = mysqli_real_escape_string(
        $conn,
        $editDepositCode
    );

    $sqlEdit = "
        SELECT *
        FROM tb_deposit
        WHERE deposit_code = '{$editCodeDb}'
        LIMIT 1
    ";

    $queryEdit = mysqli_query(
        $conn,
        $sqlEdit
    );

    if (!$queryEdit) {

        die(
            'Error : ' .
            depH(mysqli_error($conn))
        );
    }


    $rowEdit = mysqli_fetch_assoc(
        $queryEdit
    );

    if (!$rowEdit) {

        die(
            'ไม่พบใบเงินมัดจำเลขที่ ' .
            depH($editDepositCode)
        );
    }


    foreach ($rowEdit as $key => $value) {

        $depData[$key] = $value;
    }


    /*
    |--------------------------------------------------------------------------
    | โหลดรายละเอียดการจัดส่งจาก tb_transaction
    | ระบบเดิมใช้ ref_id เชื่อมกับเลขที่เอกสาร
    |--------------------------------------------------------------------------
    */

    if (!empty($transactionColumns)) {

        $sqlTransactionEdit = "
            SELECT *
            FROM tb_transaction
            WHERE ref_id = '{$editCodeDb}'
            LIMIT 1
        ";

        $queryTransactionEdit = mysqli_query($conn, $sqlTransactionEdit);

        if ($queryTransactionEdit) {
            $transactionEdit = mysqli_fetch_assoc($queryTransactionEdit);

            if ($transactionEdit) {

                // checkbox / field ที่ชื่อเหมือนกัน
                $sameFields = array(
                    'runway','road','soy','soy_big','height_ltd','car_load',
                    'no_car_road','car_park','car_road','car_home','door_long',
                    'slope','bundai','unit_bundai','door_longer','room_bigger',
                    'room_longer','type_door','home_type','install',
                    'bundai_install','bundai_big','bundai_hug','type_bundai',
                    'lip','lip_big','lip_long','lip_weight','up','no_up',
                    'head_bad','want_employee','employee_unit','ferniger_name',
                    'ferniger_address','want_ex','want_credit','bank','want_prem'
                );

                foreach ($sameFields as $field) {
                    if (array_key_exists($field, $transactionEdit)) {
                        $depData[$field] = $transactionEdit[$field];
                    }
                }

                // ชื่อ field หน้าใหม่ -> ชื่อ column ระบบเดิม
                if (array_key_exists('door_big', $transactionEdit)) {
                    $depData['door_bigger'] = $transactionEdit['door_big'];
                }

                if (array_key_exists('description', $transactionEdit)) {
                    $depData['description_ja'] = $transactionEdit['description'];
                }

                // ถ้ามี record รายละเอียดการจัดส่ง ให้เปิด section อัตโนมัติ
                $depData['more'] = '1';
            }
        }
    }
}


/*
|--------------------------------------------------------------------------
| เลขที่เอกสารใหม่
|--------------------------------------------------------------------------
*/

if (!$editMode) {

    $sqlNext = "
        SELECT MAX(
            CAST(deposit_code AS UNSIGNED)
        ) AS max_code
        FROM tb_deposit
    ";

    $queryNext = mysqli_query(
        $conn,
        $sqlNext
    );

    $nextCode = 1;

    if ($queryNext) {

        $nextRow = mysqli_fetch_assoc(
            $queryNext
        );

        $nextCode =
            isset($nextRow['max_code'])
            ? ((int)$nextRow['max_code'] + 1)
            : 1;
    }

    $depData['deposit_code'] =
        $nextCode;
}


/*
|--------------------------------------------------------------------------
| SAVE / UPDATE
|--------------------------------------------------------------------------
*/

if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['save_deposit'])
) {

    $formMode = depPost(
        'form_mode',
        'add'
    );

    $depositCode = depPost(
        'deposit_code'
    );


    /*
    |--------------------------------------------------------------------------
    | Basic Data
    |--------------------------------------------------------------------------
    */

    $saveData = array();

    $saveData['deposit_code'] = $depositCode;
    $saveData['bill_date'] = depPost('bill_date');
    $saveData['iv_no'] = depPost('iv_no');
    $saveData['bill_name'] = depPost('bill_name');
    $saveData['bill_address'] = depPost('bill_address');
    $saveData['bill_tel'] = depPost('bill_tel');
    $saveData['customer_contact'] = depPost('customer_contact');
    $saveData['tax_id'] = depPost('tax_id');

    $saveData['delivery_date'] = depPost('delivery_date');
    $saveData['delivery_time'] = depPost('delivery_time');
    $saveData['department'] = depPost('department');
    $saveData['delivery_name'] = depPost('delivery_name');
    $saveData['delivery_tel'] = depPost('delivery_tel');
    $saveData['delivery_address'] = depPost('delivery_address');


    /*
    |--------------------------------------------------------------------------
    | Product
    |--------------------------------------------------------------------------
    */

    $sumUnitPrice = 0;

    for ($i = 1; $i <= 15; $i++) {

        $saveData[
            'product_name' . $i
        ] = depPost(
            'product_name' . $i
        );


        $saveData[
            'h_product_name' . $i
        ] = depPost(
            'h_product_name' . $i
        );


        $unitPrice = depMoney(
            depPost(
                'unit_price' . $i,
                '0'
            )
        );

        $saveData[
            'unit_price' . $i
        ] = $unitPrice;

        $sumUnitPrice += $unitPrice;
    }


    $saveData['sum_unit_price'] =
        $sumUnitPrice;


    /*
    |--------------------------------------------------------------------------
    | Payment
    |--------------------------------------------------------------------------
    */

    $paymentSelect =
        depPost('payment_select');

    $paymentCustom =
        depPost('payment_custom');


    $saveData['payment'] =
        $paymentSelect === '__custom__'
        ? $paymentCustom
        : $paymentSelect;


    $saveData['bank_name'] =
        depPost('bank_name');

    $saveData['bank_card'] =
        depPost('bank_card');

    $saveData['check_no'] =
        depPost('check_no');

    $saveData['branch_name'] =
        depPost('branch_name');

    $saveData['payment_date'] =
        depPost('payment_date');


    /*
    |--------------------------------------------------------------------------
    | Signature / Map
    |--------------------------------------------------------------------------
    */

    $signatureNew =
        depPost(
            'employee_signature_name'
        );

    $signatureOld =
        depPost(
            'employee_signature_old'
        );


    $saveData[
        'employee_signature_name'
    ] =
        $signatureNew !== ''
        ? $signatureNew
        : $signatureOld;


    /*
    |--------------------------------------------------------------------------
    | Delivery Detail
    |--------------------------------------------------------------------------
    */

    $checkboxFields = array(
        'more',
        'runway',
        'road',
        'soy',
        'height_ltd',
        'car_load',
        'no_car_road',
        'car_road',
        'car_home',
        'slope',
        'bundai',
        'bundai_install',
        'lip',
        'up',
        'no_up',
        'head_bad',
        'want_employee',
        'want_ex',
        'want_credit',
        'want_prem'
    );


    foreach (
        $checkboxFields
        as $checkboxField
    ) {

        $saveData[$checkboxField] =
            isset($_POST[$checkboxField])
            ? '1'
            : '0';
    }


    $textFields = array(
        'soy_big',
        'car_park',
        'door_long',
        'unit_bundai',
        'door_bigger',
        'door_longer',
        'room_bigger',
        'room_longer',
        'type_door',
        'home_type',
        'install',
        'bundai_big',
        'bundai_hug',
        'type_bundai',
        'lip_big',
        'lip_long',
        'lip_weight',
        'employee_unit',
        'ferniger_name',
        'ferniger_address',
        'bank',
        'description_ja'
    );


    foreach (
        $textFields
        as $textField
    ) {

        $saveData[$textField] =
            depPost($textField);
    }


    /*
    |--------------------------------------------------------------------------
    | Add By
    |--------------------------------------------------------------------------
    */

    $sessionName =
        isset($_SESSION['name'])
        ? $_SESSION['name']
        : '';

    $sessionSurname =
        isset($_SESSION['surname'])
        ? $_SESSION['surname']
        : '';

    $addBy = trim(
        $sessionName .
        ' ' .
        $sessionSurname
    );


    if (
        depHasColumn(
            $depositColumns,
            'add_by'
        )
    ) {

        $saveData['add_by'] =
            $addBy;
    }


    if (
        depHasColumn(
            $depositColumns,
            'add_date'
        ) &&
        $formMode === 'add'
    ) {

        $saveData['add_date'] =
            date('Y-m-d H:i:s');
    }


    /*
    |--------------------------------------------------------------------------
    | เก็บเฉพาะ Column ที่มีจริงใน tb_deposit
    | รายละเอียดการจัดส่งจะบันทึกแยกใน tb_transaction
    |--------------------------------------------------------------------------
    */

    $transactionFormFields = array(
        'runway','road','soy','soy_big','height_ltd','car_load','no_car_road',
        'car_park','car_road','car_home','door_long','slope','bundai',
        'unit_bundai','door_bigger','door_longer','room_bigger','room_longer',
        'type_door','home_type','install','bundai_install','bundai_big',
        'bundai_hug','type_bundai','lip','lip_big','lip_long','lip_weight',
        'up','no_up','head_bad','want_employee','employee_unit','ferniger_name',
        'ferniger_address','want_ex','want_credit','bank','want_prem',
        'description_ja'
    );

    $filteredData = array();

    foreach (
        $saveData
        as $field => $value
    ) {

        if (in_array($field, $transactionFormFields, true)) {
            continue;
        }

        if (
            depHasColumn(
                $depositColumns,
                $field
            )
        ) {

            $filteredData[
                $field
            ] = $value;
        }
    }


    mysqli_begin_transaction(
        $conn
    );


    try {

        /*
        |--------------------------------------------------------------------------
        | UPDATE
        |--------------------------------------------------------------------------
        */

        if (
            $formMode === 'edit'
        ) {

            $updateParts = array();


            foreach (
                $filteredData
                as $field => $value
            ) {

                if (
                    $field ===
                    'deposit_code'
                ) {
                    continue;
                }


                $fieldSafe =
                    str_replace(
                        '`',
                        '',
                        $field
                    );


                $valueSafe =
                    mysqli_real_escape_string(
                        $conn,
                        (string)$value
                    );


                $updateParts[] =
                    "`{$fieldSafe}` = '{$valueSafe}'";
            }


            $codeDb =
                mysqli_real_escape_string(
                    $conn,
                    $depositCode
                );


            $sqlSave = "
                UPDATE tb_deposit
                SET
                    " .
                    implode(
                        ",\n",
                        $updateParts
                    ) .
                "
                WHERE deposit_code = '{$codeDb}'
                LIMIT 1
            ";


            if (
                !mysqli_query(
                    $conn,
                    $sqlSave
                )
            ) {

                throw new Exception(
                    mysqli_error($conn)
                );
            }


            $message =
                'อัปเดตข้อมูลเรียบร้อยแล้ว';

        } else {

            /*
            |--------------------------------------------------------------------------
            | INSERT
            |--------------------------------------------------------------------------
            */

            $insertFields = array();
            $insertValues = array();


            foreach (
                $filteredData
                as $field => $value
            ) {

                $fieldSafe =
                    str_replace(
                        '`',
                        '',
                        $field
                    );


                $valueSafe =
                    mysqli_real_escape_string(
                        $conn,
                        (string)$value
                    );


                $insertFields[] =
                    "`{$fieldSafe}`";

                $insertValues[] =
                    "'{$valueSafe}'";
            }


            $sqlSave = "
                INSERT INTO tb_deposit
                (
                    " .
                    implode(
                        ',',
                        $insertFields
                    ) .
                    "
                )
                VALUES
                (
                    " .
                    implode(
                        ',',
                        $insertValues
                    ) .
                    "
                )
            ";


            if (
                !mysqli_query(
                    $conn,
                    $sqlSave
                )
            ) {

                throw new Exception(
                    mysqli_error($conn)
                );
            }


            $message =
                'บันทึกข้อมูลเรียบร้อยแล้ว';
        }


        /*
        |--------------------------------------------------------------------------
        | SAVE / UPDATE : tb_transaction
        | รายละเอียดการจัดส่ง/หน้างาน
        |--------------------------------------------------------------------------
        */

        if (!empty($transactionColumns)) {

            $transactionData = array();

            // ref_id ใช้เลข deposit_code เชื่อมเอกสาร
            if (depHasColumn($transactionColumns, 'ref_id')) {
                $transactionData['ref_id'] = $depositCode;
            }

            $transactionMap = array(
                'runway' => 'runway',
                'road' => 'road',
                'soy' => 'soy',
                'soy_big' => 'soy_big',
                'height_ltd' => 'height_ltd',
                'car_load' => 'car_load',
                'no_car_road' => 'no_car_road',
                'car_park' => 'car_park',
                'car_road' => 'car_road',
                'car_home' => 'car_home',
                'door_long' => 'door_long',
                'slope' => 'slope',
                'bundai' => 'bundai',
                'unit_bundai' => 'unit_bundai',
                'door_bigger' => 'door_big',
                'door_longer' => 'door_longer',
                'room_bigger' => 'room_bigger',
                'room_longer' => 'room_longer',
                'type_door' => 'type_door',
                'home_type' => 'home_type',
                'install' => 'install',
                'bundai_install' => 'bundai_install',
                'bundai_big' => 'bundai_big',
                'bundai_hug' => 'bundai_hug',
                'type_bundai' => 'type_bundai',
                'lip' => 'lip',
                'lip_big' => 'lip_big',
                'lip_long' => 'lip_long',
                'lip_weight' => 'lip_weight',
                'up' => 'up',
                'no_up' => 'no_up',
                'head_bad' => 'head_bad',
                'want_employee' => 'want_employee',
                'employee_unit' => 'employee_unit',
                'ferniger_name' => 'ferniger_name',
                'ferniger_address' => 'ferniger_address',
                'want_ex' => 'want_ex',
                'want_credit' => 'want_credit',
                'bank' => 'bank',
                'want_prem' => 'want_prem',
                'description_ja' => 'description'
            );

            foreach ($transactionMap as $formField => $dbField) {
                if (depHasColumn($transactionColumns, $dbField)) {
                    $transactionData[$dbField] = isset($saveData[$formField])
                        ? $saveData[$formField]
                        : '';
                }
            }

            if (depHasColumn($transactionColumns, 'add_by')) {
                $transactionData['add_by'] = $addBy;
            }

            if (depHasColumn($transactionColumns, 'add_date')) {
                $transactionData['add_date'] = date('Y-m-d H:i:s');
            }

            $codeDbTransaction = mysqli_real_escape_string($conn, $depositCode);

            $sqlCheckTransaction = "
                SELECT 1
                FROM tb_transaction
                WHERE ref_id = '{$codeDbTransaction}'
                LIMIT 1
            ";

            $queryCheckTransaction = mysqli_query($conn, $sqlCheckTransaction);
            $hasTransaction = $queryCheckTransaction && mysqli_num_rows($queryCheckTransaction) > 0;

            if ($hasTransaction) {

                $transactionUpdateParts = array();

                foreach ($transactionData as $field => $value) {
                    if ($field === 'ref_id') {
                        continue;
                    }

                    $fieldSafe = str_replace('`', '', $field);
                    $valueSafe = mysqli_real_escape_string($conn, (string)$value);
                    $transactionUpdateParts[] = "`{$fieldSafe}` = '{$valueSafe}'";
                }

                if (!empty($transactionUpdateParts)) {
                    $sqlTransactionSave = "
                        UPDATE tb_transaction
                        SET " . implode(",\n", $transactionUpdateParts) . "
                        WHERE ref_id = '{$codeDbTransaction}'
                        LIMIT 1
                    ";

                    if (!mysqli_query($conn, $sqlTransactionSave)) {
                        throw new Exception('Update tb_transaction : ' . mysqli_error($conn));
                    }
                }

            } else {

                // สร้าง record เฉพาะเมื่อผู้ใช้ติ๊กระบุรายละเอียดหน้างาน
                // หรือมีข้อมูลรายละเอียดอย่างน้อย 1 ค่า
                $hasDeliveryDetail = depPost('more') === '1';

                if (!$hasDeliveryDetail) {
                    foreach ($transactionMap as $formField => $dbField) {
                        $v = isset($saveData[$formField]) ? trim((string)$saveData[$formField]) : '';
                        if ($v !== '' && $v !== '0') {
                            $hasDeliveryDetail = true;
                            break;
                        }
                    }
                }

                if ($hasDeliveryDetail && depHasColumn($transactionColumns, 'ref_id')) {

                    $transactionFields = array();
                    $transactionValues = array();

                    foreach ($transactionData as $field => $value) {
                        $fieldSafe = str_replace('`', '', $field);
                        $valueSafe = mysqli_real_escape_string($conn, (string)$value);
                        $transactionFields[] = "`{$fieldSafe}`";
                        $transactionValues[] = "'{$valueSafe}'";
                    }

                    $sqlTransactionSave = "
                        INSERT INTO tb_transaction
                        (" . implode(',', $transactionFields) . ")
                        VALUES
                        (" . implode(',', $transactionValues) . ")
                    ";

                    if (!mysqli_query($conn, $sqlTransactionSave)) {
                        throw new Exception('Insert tb_transaction : ' . mysqli_error($conn));
                    }
                }
            }
        }


        mysqli_commit(
            $conn
        );


        echo "
        <script>
            alert(" .
            json_encode(
                $message,
                JSON_UNESCAPED_UNICODE
            ) .
            ");

            window.location =
                " .
                json_encode(
                    $_SERVER['PHP_SELF'] .
                    '?deposit_code=' .
                    urlencode($depositCode)
                ) .
                ";
        </script>
        ";

        exit;


    } catch (Exception $e) {

        mysqli_rollback(
            $conn
        );

        echo "
        <script>
            alert(" .
            json_encode(
                'ไม่สามารถบันทึกข้อมูลได้ : ' .
                $e->getMessage(),
                JSON_UNESCAPED_UNICODE
            ) .
            ");
        </script>
        ";
    }
}


/*
|--------------------------------------------------------------------------
| Payment List
|--------------------------------------------------------------------------
*/

$paymentOptions = array();

$sqlPayment = "
    SELECT
        id,
        pay_in
    FROM tb_bank
    ORDER BY id
";

$queryPayment = mysqli_query(
    $code,
    $sqlPayment
);

if ($queryPayment) {

    while (
        $paymentRow =
        mysqli_fetch_assoc(
            $queryPayment
        )
    ) {

        $paymentOptions[] =
            $paymentRow;
    }
}


/*
|--------------------------------------------------------------------------
| ตรวจ Payment เดิม
|--------------------------------------------------------------------------
*/

$currentPayment =
    isset($depData['payment'])
    ? (string)$depData['payment']
    : '';

$paymentMatched = false;

foreach (
    $paymentOptions
    as $paymentOption
) {

    if (
        (string)$paymentOption[
            'id'
        ] === $currentPayment
    ) {

        $paymentMatched = true;
        break;
    }
}

?>

<script src="libs/jquery.js"></script>
<script src="src/jSignature.js"></script>

<link
    rel="stylesheet"
    href="css/so-core.css?v=<?php
        echo file_exists(
            __DIR__ . '/css/so-core.css'
        )
        ? filemtime(
            __DIR__ . '/css/so-core.css'
        )
        : time();
    ?>"
>


<style>

.deposit-main {
    max-width: 1200px;
    margin: 0 auto;
    padding-bottom: 40px;
    box-sizing: border-box;
    font-family: 'Prompt', sans-serif;
}

.dep-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    margin-bottom: 24px;
}

.dep-title {
    margin: 0;
    color: #612989;
    font-family: 'Prompt', sans-serif;
    font-size: 28px;
    font-weight: 600;
}

.dep-ref {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-top: 6px;
    flex-wrap: wrap;
}

.dep-ref-label {
    font-size: 14px;
    color: #888;
}

.dep-ref-value {
    color: #612989;
    font-size: 16px;
    font-weight: 500;
}

.dep-mode {
    display: inline-flex;
    align-items: center;
    padding: 4px 10px;
    border-radius: 15px;
    background: #f3eaf8;
    color: #612989;
    font-size: 12px;
}

.dep-card {
    background: #fff;
    border: 1px solid #eee;
    border-radius: 16px;
    padding: 24px;
    margin-bottom: 20px;
    box-shadow: 0 3px 12px rgba(0,0,0,.03);
    box-sizing: border-box;
}

.dep-section-head {
    display: flex;
    align-items: center;
    gap: 12px;
}

.dep-section-icon {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    background: #f4edf9;
    color: #612989;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-shrink: 0;
}

.dep-section-title {
    margin: 0;
    font-size: 19px;
    font-weight: 500;
    color: #292929;
}

.dep-divider {
    border: 0;
    border-top: 1px solid #eee;
    margin: 18px 0 24px;
}

.dep-grid-2 {
    display: grid;
    grid-template-columns:
        repeat(2, minmax(0,1fr));
    gap: 20px 24px;
}

.dep-grid-3 {
    display: grid;
    grid-template-columns:
        repeat(3, minmax(0,1fr));
    gap: 20px 24px;
}

.dep-full {
    grid-column: 1 / -1;
}

.dep-field {
    min-width: 0;
}

.dep-label {
    display: block;
    margin-bottom: 8px;
    font-size: 14px;
    color: #404040;
}

.dep-input,
.dep-select,
.dep-textarea {
    width: 100%;
    min-height: 42px;
    padding: 9px 12px;
    border: 1px solid #ddd;
    border-radius: 8px;
    background: #fff;
    color: #333;
    font-family: 'Prompt', sans-serif;
    font-size: 14px;
    box-sizing: border-box;
    outline: none;
}

.dep-input:focus,
.dep-select:focus,
.dep-textarea:focus {
    border-color: #8d54b4;
    box-shadow:
        0 0 0 3px
        rgba(97,41,137,.08);
}

.dep-textarea {
    resize: vertical;
    min-height: 86px;
}

.dep-input[readonly] {
    background: #f8f8f8;
    color: #777;
}

.dep-product-table {
    width: 100%;
    border-collapse: collapse;
}

.dep-product-table th {
    padding: 10px;
    background: #faf8fc;
    color: #612989;
    font-size: 13px;
    font-weight: 500;
    text-align: left;
    border-bottom: 1px solid #eee;
}

.dep-product-table td {
    padding: 6px;
    vertical-align: middle;
}

.dep-product-no {
    width: 45px;
    text-align: center;
    color: #8a8a8a;
}

.dep-price {
    text-align: right;
}

.dep-product-extra {
    margin-top: 12px;
}

.dep-add-product-btn {
    height: 38px;
    padding: 0 18px;
    border: 1px solid #d9cce2;
    border-radius: 20px;
    background: #fff;
    color: #612989;
    cursor: pointer;
    font-family: 'Prompt', sans-serif;
}

.dep-total-wrap {
    margin-top: 16px;
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 14px;
}

.dep-total-label {
    font-weight: 500;
}

.dep-total-input {
    max-width: 240px;
    font-size: 16px;
    font-weight: 600;
    color: #612989;
    text-align: right;
}

.dep-check-grid {
    display: grid;
    grid-template-columns:
        repeat(3, minmax(0,1fr));
    gap: 14px 24px;
}

.dep-check {
    display: flex;
    align-items: flex-start;
    gap: 8px;
    font-size: 14px;
}

.dep-mini-input {
    margin-top: 7px;
}

.dep-signature-box {
    background: #fafafa;
    border: 1px dashed #d3d3d3;
    border-radius: 12px;
    min-height: 220px;
    overflow: hidden;
}

#employee_send_signature {
    min-height: 220px;
}

.dep-signature-actions {
    margin-top: 12px;
}

.dep-sticky {
    position: sticky;
    bottom: 0;
    z-index: 50;
    width: 100%;
    padding: 16px 24px;
    background: #fff;
    border-top: 1px solid #ebebeb;
    box-shadow:
        0 -4px 12px
        rgba(0,0,0,.05);
    box-sizing: border-box;
}

.dep-sticky-inner {
    max-width: 1200px;
    margin: 0 auto;
    display: flex;
    justify-content: flex-end;
    gap: 12px;
}

.dep-save-btn {
    height: 42px;
    padding: 0 32px;
    border: 1px solid #612989;
    border-radius: 24px;
    background: #612989;
    color: #fff;
    cursor: pointer;
    font-family: 'Prompt', sans-serif;
    font-size: 15px;
}

.dep-back-btn {
    height: 42px;
    padding: 0 26px;
    border: 1px solid #ddd;
    border-radius: 24px;
    background: #fff;
    color: #555;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 15px;
}

.dep-more-wrap {
    margin-top: 15px;
}

.dep-more-toggle {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
}

.dep-hidden {
    display: none;
}

@media (max-width: 900px) {

    .dep-grid-3 {
        grid-template-columns:
            repeat(2, minmax(0,1fr));
    }

    .dep-check-grid {
        grid-template-columns:
            repeat(2, minmax(0,1fr));
    }
}

@media (max-width: 650px) {

    .deposit-main {
        padding-left: 8px;
        padding-right: 8px;
    }

    .dep-header {
        flex-direction: column;
        align-items: flex-start;
    }

    .dep-title {
        font-size: 23px;
    }

    .dep-card {
        padding: 18px 15px;
    }

    .dep-grid-2,
    .dep-grid-3,
    .dep-check-grid {
        grid-template-columns: 1fr;
    }

    .dep-sticky {
        padding: 12px;
    }

    .dep-sticky-inner {
        display: grid;
        grid-template-columns: 1fr 1fr;
    }

    .dep-save-btn,
    .dep-back-btn {
        width: 100%;
    }
}

</style>


<div class="w3-container deposit-main">

    <div class="dep-header">

        <div>

            <br>

            <h1 class="dep-title">
                ใบเงินมัดจำ
            </h1>

            <div class="dep-ref">

                <span class="dep-ref-label">
                    เลขที่อ้างอิง
                </span>

                <span class="dep-ref-value">
                    <?php
                    echo depH(
                        $depData['deposit_code']
                    );
                    ?>
                </span>

                <span class="dep-mode">

                    <?php
                    echo $editMode
                        ? 'แก้ไขข้อมูล'
                        : 'เอกสารใหม่';
                    ?>

                </span>

            </div>

        </div>

    </div>
<?php if ($editMode && !empty($qouData['deposit_code'])) { ?>
        <div class="qou-header-right">
            <a
                class="qou-btn-preview"
                href="report_deposit.php?deposit_code=<?php echo urlencode($qouData['ref_id']); ?>"
                target="_blank"
                rel="noopener"
                title="Preview ใบเสนอราคา"
            >
                <i class="far fa-file-alt"></i>
                Preview
            </a>
        </div>
        <?php } ?>

    <form
        method="post"
        id="frmDeposit"
        name="frmDeposit"
        onsubmit="return depBeforeSubmit();"
    >

        <input
            type="hidden"
            name="form_mode"
            value="<?php
                echo $editMode
                    ? 'edit'
                    : 'add';
            ?>"
        >

        <input
            type="hidden"
            name="deposit_code"
            value="<?php
                echo depH(
                    $depData[
                        'deposit_code'
                    ]
                );
            ?>"
        >


        <!-- =================================================
             ข้อมูลเอกสาร
        ================================================== -->

        <div class="dep-card">

            <div class="dep-section-head">

                <div class="dep-section-icon">
                    <i class="far fa-file-alt"></i>
                </div>

                <h2 class="dep-section-title">
                    ข้อมูลเอกสาร
                </h2>

            </div>

            <hr class="dep-divider">


            <div class="dep-grid-2">

                <div class="dep-field">

                    <label class="dep-label">
                        วันที่ออกบิล
                    </label>

                    <input
                        name="bill_date"
                        type="date"
                        class="dep-input"
                        value="<?php
                            echo depH(
                                $depData[
                                    'bill_date'
                                ]
                            );
                        ?>"
                    >

                </div>


                <div class="dep-field">

                    <label class="dep-label">
                        เลขที่
                    </label>

                    <input
                        name="iv_no"
                        type="text"
                        class="dep-input"
                        value="<?php
                            echo depH(
                                $depData[
                                    'iv_no'
                                ]
                            );
                        ?>"
                    >

                </div>

            </div>

        </div>


        <!-- =================================================
             ข้อมูลลูกค้า
        ================================================== -->

        <div class="dep-card">

            <div class="dep-section-head">

                <div class="dep-section-icon">
                    <i class="far fa-user"></i>
                </div>

                <h2 class="dep-section-title">
                    ข้อมูลลูกค้า
                </h2>

            </div>

            <hr class="dep-divider">


            <div class="dep-grid-3">

                <div class="dep-field">

                    <label class="dep-label">
                        ชื่อลูกค้าที่ออกบิล
                    </label>

                    <input
                        name="bill_name"
                        type="text"
                        class="dep-input"
                        value="<?php
                            echo depH(
                                $depData[
                                    'bill_name'
                                ]
                            );
                        ?>"
                    >

                </div>


                <div class="dep-field">

                    <label class="dep-label">
                        เบอร์โทร
                    </label>

                    <input
                        name="bill_tel"
                        type="text"
                        class="dep-input"
                        value="<?php
                            echo depH(
                                $depData[
                                    'bill_tel'
                                ]
                            );
                        ?>"
                    >

                </div>


                <div class="dep-field">

                    <label class="dep-label">
                        ชื่อผู้ติดต่อ
                    </label>

                    <input
                        name="customer_contact"
                        type="text"
                        class="dep-input"
                        value="<?php
                            echo depH(
                                $depData[
                                    'customer_contact'
                                ]
                            );
                        ?>"
                    >

                </div>


                <div class="dep-field">

                    <label class="dep-label">
                        เลขประจำตัวผู้เสียภาษี
                    </label>

                    <input
                        name="tax_id"
                        type="text"
                        class="dep-input"
                        value="<?php
                            echo depH(
                                $depData[
                                    'tax_id'
                                ]
                            );
                        ?>"
                    >

                </div>


                <div class="dep-field dep-full">

                    <label class="dep-label">
                        ที่อยู่ออกบิล
                    </label>

                    <textarea
                        name="bill_address"
                        class="dep-textarea"
                        rows="2"
                    ><?php
                        echo depH(
                            $depData[
                                'bill_address'
                            ]
                        );
                    ?></textarea>

                </div>

            </div>

        </div>


        <!-- =================================================
             จัดส่ง
        ================================================== -->

        <div class="dep-card">

            <div class="dep-section-head">

                <div class="dep-section-icon">
                    <i class="fas fa-truck"></i>
                </div>

                <h2 class="dep-section-title">
                    ข้อมูลการจัดส่ง
                </h2>

            </div>

            <hr class="dep-divider">


            <div class="dep-grid-3">

                <div class="dep-field">

                    <label class="dep-label">
                        วันที่ส่งสินค้า
                    </label>

                    <input
                        name="delivery_date"
                        type="date"
                        class="dep-input"
                        value="<?php
                            echo depH(
                                $depData[
                                    'delivery_date'
                                ]
                            );
                        ?>"
                    >

                </div>


                <div class="dep-field">

                    <label class="dep-label">
                        เวลา
                    </label>

                    <input
                        name="delivery_time"
                        type="text"
                        class="dep-input"
                        value="<?php
                            echo depH(
                                $depData[
                                    'delivery_time'
                                ]
                            );
                        ?>"
                    >

                </div>


                <div class="dep-field">

                    <label class="dep-label">
                        แผนก
                    </label>

                    <input
                        name="department"
                        type="text"
                        class="dep-input"
                        value="<?php
                            echo depH(
                                $depData[
                                    'department'
                                ]
                            );
                        ?>"
                    >

                </div>


                <div class="dep-field">

                    <label class="dep-label">
                        ชื่อผู้ติดต่อ
                    </label>

                    <input
                        name="delivery_name"
                        type="text"
                        class="dep-input"
                        value="<?php
                            echo depH(
                                $depData[
                                    'delivery_name'
                                ]
                            );
                        ?>"
                    >

                </div>


                <div class="dep-field">

                    <label class="dep-label">
                        เบอร์โทร
                    </label>

                    <input
                        name="delivery_tel"
                        type="text"
                        class="dep-input"
                        value="<?php
                            echo depH(
                                $depData[
                                    'delivery_tel'
                                ]
                            );
                        ?>"
                    >

                </div>


                <div class="dep-field dep-full">

                    <label class="dep-label">
                        ที่อยู่จัดส่ง
                    </label>

                    <textarea
                        name="delivery_address"
                        class="dep-textarea"
                        rows="2"
                    ><?php
                        echo depH(
                            $depData[
                                'delivery_address'
                            ]
                        );
                    ?></textarea>

                </div>

            </div>

        </div>


        <!-- =================================================
             PRODUCTS
        ================================================== -->

        <div class="dep-card">

            <div class="dep-section-head">

                <div class="dep-section-icon">
                    <i class="fas fa-box-open"></i>
                </div>

                <h2 class="dep-section-title">
                    รายการสินค้า
                </h2>

            </div>

            <hr class="dep-divider">


            <div style="overflow-x:auto;">

                <table class="dep-product-table">

                    <thead>

                        <tr>

                            <th style="width:55px;">
                                #
                            </th>

                            <th>
                                รายการสินค้า
                            </th>

                            <th style="width:220px; text-align:right;">
                                มูลค่า
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                    <?php
                    for ($i = 1; $i <= 15; $i++) {

                        $extraClass = '';

                        if ($i >= 6 && $i <= 10) {
                            $extraClass = ' product-group-2';
                        }

                        if ($i >= 11) {
                            $extraClass = ' product-group-3';
                        }
                    ?>

                        <tr
                            class="product-row<?php
                                echo $extraClass;
                            ?>"
                            <?php

                            $showProductRow = true;

                            if (
                                $i >= 6 &&
                                $i <= 10
                            ) {

                                $showProductRow =
                                    trim(
                                        (string)$depData[
                                            'product_name' . $i
                                        ]
                                    ) !== '' ||
                                    trim(
                                        (string)$depData[
                                            'unit_price' . $i
                                        ]
                                    ) !== '' &&
                                    (float)$depData[
                                        'unit_price' . $i
                                    ] != 0;
                            }

                            if ($i >= 11) {

                                $showProductRow =
                                    trim(
                                        (string)$depData[
                                            'product_name' . $i
                                        ]
                                    ) !== '' ||
                                    (
                                        trim(
                                            (string)$depData[
                                                'unit_price' . $i
                                            ]
                                        ) !== '' &&
                                        (float)$depData[
                                            'unit_price' . $i
                                        ] != 0
                                    );
                            }


                            if (
                                $i > 5 &&
                                !$showProductRow
                            ) {
                                echo 'style="display:none;"';
                            }

                            ?>
                        >

                            <td class="dep-product-no">

                                <?php
                                echo $i;
                                ?>

                            </td>


                            <td>

                                <input
                                    name="product_name<?php echo $i; ?>"
                                    id="product_name<?php echo $i; ?>"
                                    type="text"
                                    class="dep-input"
                                    value="<?php
                                        echo depH(
                                            $depData[
                                                'product_name' . $i
                                            ]
                                        );
                                    ?>"
                                    placeholder="ระบุรายการสินค้า"
                                >

                                <input
                                    type="hidden"
                                    name="h_product_name<?php echo $i; ?>"
                                    id="h_product_name<?php echo $i; ?>"
                                    value="<?php
                                        echo depH(
                                            $depData[
                                                'h_product_name' . $i
                                            ]
                                        );
                                    ?>"
                                >

                            </td>


                            <td>

                                <input
                                    name="unit_price<?php echo $i; ?>"
                                    id="unit_price<?php echo $i; ?>"
                                    type="text"
                                    class="dep-input dep-price"
                                    value="<?php
                                        echo number_format(
                                            depMoney(
                                                $depData[
                                                    'unit_price' . $i
                                                ]
                                            ),
                                            2
                                        );
                                    ?>"
                                    oninput="depCalculateTotal();"
                                    onblur="depFormatMoney(this);"
                                >

                            </td>

                        </tr>

                    <?php
                    }
                    ?>

                    </tbody>

                </table>

            </div>


            <div class="dep-product-extra">

                <button
                    type="button"
                    class="dep-add-product-btn"
                    id="btnMoreProduct"
                    onclick="depShowMoreProducts();"
                >
                    <i class="fas fa-plus"></i>
                    เพิ่มรายการสินค้า
                </button>

            </div>


            <div class="dep-total-wrap">

                <span class="dep-total-label">
                    รวมเป็นเงิน
                </span>

                <input
                    name="sum_unit_price"
                    id="sum_unit_price"
                    type="text"
                    class="dep-input dep-total-input"
                    value="<?php
                        echo number_format(
                            depMoney(
                                $depData[
                                    'sum_unit_price'
                                ]
                            ),
                            2
                        );
                    ?>"
                    readonly
                >

            </div>

        </div>


        <!-- =================================================
             PAYMENT
        ================================================== -->

        <div class="dep-card">

            <div class="dep-section-head">

                <div class="dep-section-icon">
                    <i class="far fa-credit-card"></i>
                </div>

                <h2 class="dep-section-title">
                    ข้อมูลการรับชำระ
                </h2>

            </div>

            <hr class="dep-divider">


            <div class="dep-grid-3">

                <div class="dep-field">

                    <label class="dep-label">
                        รายการรับชำระ
                    </label>

                    <select
                        name="payment_select"
                        id="payment_select"
                        class="dep-select"
                        onchange="depPaymentChange();"
                    >

                        <option value="">
                            -- เลือกช่องทางการชำระ --
                        </option>

                        <?php

                        foreach (
                            $paymentOptions
                            as $paymentOption
                        ) {

                            $paymentId =
                                (string)$paymentOption[
                                    'id'
                                ];

                        ?>

                            <option
                                value="<?php
                                    echo depH(
                                        $paymentId
                                    );
                                ?>"
                                <?php
                                echo
                                    $paymentId ===
                                    $currentPayment
                                    ? 'selected'
                                    : '';
                                ?>
                            >
                                <?php
                                echo depH(
                                    $paymentOption[
                                        'pay_in'
                                    ]
                                );
                                ?>
                            </option>

                        <?php
                        }
                        ?>

                        <option
                            value="__custom__"
                            <?php
                            echo (
                                $currentPayment !== '' &&
                                !$paymentMatched
                            )
                                ? 'selected'
                                : '';
                            ?>
                        >
                            อื่น ๆ
                        </option>

                    </select>

                </div>


                <div
                    class="dep-field"
                    id="payment_custom_wrap"
                    style="display:none;"
                >

                    <label class="dep-label">
                        ระบุช่องทางการชำระ
                    </label>

                    <input
                        type="text"
                        name="payment_custom"
                        id="payment_custom"
                        class="dep-input"
                        value="<?php
                            echo !$paymentMatched
                                ? depH(
                                    $currentPayment
                                )
                                : '';
                        ?>"
                    >

                </div>


                <div class="dep-field">

                    <label class="dep-label">
                        ธนาคาร
                    </label>

                    <select
                        name="bank_name"
                        class="dep-select"
                    >

                        <option value="">
                            -- เลือกธนาคาร --
                        </option>

                        <option
                            value="ไทยพานิช"
                            <?php
                            echo
                                $depData[
                                    'bank_name'
                                ] === 'ไทยพานิช'
                                ? 'selected'
                                : '';
                            ?>
                        >
                            ไทยพานิช
                        </option>

                        <option
                            value="กรุงศรี"
                            <?php
                            echo
                                $depData[
                                    'bank_name'
                                ] === 'กรุงศรี'
                                ? 'selected'
                                : '';
                            ?>
                        >
                            กรุงศรี
                        </option>

                    </select>

                </div>


                <div class="dep-field">

                    <label class="dep-label">
                        บัตรของธนาคาร
                    </label>

                    <input
                        name="bank_card"
                        type="text"
                        class="dep-input"
                        value="<?php
                            echo depH(
                                $depData[
                                    'bank_card'
                                ]
                            );
                        ?>"
                    >

                </div>


                <div class="dep-field">

                    <label class="dep-label">
                        เลขที่ / CHQ#
                    </label>

                    <input
                        name="check_no"
                        type="text"
                        class="dep-input"
                        value="<?php
                            echo depH(
                                $depData[
                                    'check_no'
                                ]
                            );
                        ?>"
                    >

                </div>


                <div class="dep-field">

                    <label class="dep-label">
                        สาขา
                    </label>

                    <input
                        name="branch_name"
                        type="text"
                        class="dep-input"
                        value="<?php
                            echo depH(
                                $depData[
                                    'branch_name'
                                ]
                            );
                        ?>"
                    >

                </div>


                <div class="dep-field">

                    <label class="dep-label">
                        ลงวันที่ / Date
                    </label>

                    <input
                        name="payment_date"
                        type="date"
                        class="dep-input"
                        value="<?php
                            echo depH(
                                $depData[
                                    'payment_date'
                                ]
                            );
                        ?>"
                    >

                </div>

            </div>

        </div>


        <!-- =================================================
             MAP
        ================================================== -->

        <div class="dep-card">

            <div class="dep-section-head">

                <div class="dep-section-icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>

                <h2 class="dep-section-title">
                    วาดแผนที่
                </h2>

            </div>

            <hr class="dep-divider">


            <div class="dep-signature-box">

                <div
                    id="employee_send_signature"
                ></div>

            </div>


            <input
                type="hidden"
                name="employee_signature_name"
                id="employee_signature_name"
                value=""
            >


            <input
                type="hidden"
                name="employee_signature_old"
                id="employee_signature_old"
                value="<?php
                    echo depH(
                        $depData[
                            'employee_signature_name'
                        ]
                    );
                ?>"
            >


            <div class="dep-signature-actions">

                <button
                    type="button"
                    class="dep-add-product-btn"
                    onclick="depResetSignature();"
                >
                    <i class="fas fa-undo"></i>
                    ล้างแผนที่
                </button>

            </div>

        </div>


        <!-- =================================================
             DELIVERY DETAIL
        ================================================== -->

        <div class="dep-card">

            <div class="dep-section-head">

                <div class="dep-section-icon">
                    <i class="fas fa-home"></i>
                </div>

                <h2 class="dep-section-title">
                    รายละเอียดการจัดส่ง
                </h2>

            </div>

            <hr class="dep-divider">


            <label class="dep-more-toggle">

                <input
                    type="checkbox"
                    name="more"
                    id="more"
                    value="1"
                    <?php
                    echo
                        (string)$depData[
                            'more'
                        ] === '1'
                        ? 'checked'
                        : '';
                    ?>
                >

                <strong>
                    ระบุรายละเอียดหน้างาน
                </strong>

            </label>


            <div
                id="delivery_more"
                class="dep-more-wrap"
                style="<?php
                    echo
                        (string)$depData[
                            'more'
                        ] === '1'
                        ? ''
                        : 'display:none;';
                ?>"
            >


                <div class="dep-check-grid">


                    <div class="dep-check">

                        <input
                            type="checkbox"
                            name="runway"
                            value="1"
                            <?php
                            echo
                                $depData[
                                    'runway'
                                ] == '1'
                                ? 'checked'
                                : '';
                            ?>
                        >

                        <span>
                            ติดถนนรันเวย์
                        </span>

                    </div>


                    <div class="dep-check">

                        <input
                            type="checkbox"
                            name="road"
                            value="1"
                            <?php
                            echo
                                $depData[
                                    'road'
                                ] == '1'
                                ? 'checked'
                                : '';
                            ?>
                        >

                        <span>
                            ติดถนนวิ่งสวนกัน
                        </span>

                    </div>


                    <div class="dep-check">

                        <input
                            type="checkbox"
                            name="soy"
                            value="1"
                            <?php
                            echo
                                $depData[
                                    'soy'
                                ] == '1'
                                ? 'checked'
                                : '';
                            ?>
                        >

                        <span>
                            เข้าซอย
                        </span>

                    </div>


                    <div class="dep-field">

                        <label class="dep-label">
                            ทางเข้ากว้าง (เมตร)
                        </label>

                        <input
                            name="soy_big"
                            class="dep-input"
                            value="<?php
                                echo depH(
                                    $depData[
                                        'soy_big'
                                    ]
                                );
                            ?>"
                        >

                    </div>


                    <div class="dep-check">

                        <input
                            type="checkbox"
                            name="height_ltd"
                            value="1"
                            <?php
                            echo
                                $depData[
                                    'height_ltd'
                                ] == '1'
                                ? 'checked'
                                : '';
                            ?>
                        >

                        <span>
                            มีตัวจำกัดความสูง
                        </span>

                    </div>


                    <div class="dep-check">

                        <input
                            type="checkbox"
                            name="car_load"
                            value="1"
                            <?php
                            echo
                                $depData[
                                    'car_load'
                                ] == '1'
                                ? 'checked'
                                : '';
                            ?>
                        >

                        <span>
                            รถยนต์สามารถเข้าได้
                        </span>

                    </div>


                    <div class="dep-check">

                        <input
                            type="checkbox"
                            name="no_car_road"
                            value="1"
                            <?php
                            echo
                                $depData[
                                    'no_car_road'
                                ] == '1'
                                ? 'checked'
                                : '';
                            ?>
                        >

                        <span>
                            รถยนต์เข้าไม่ได้
                        </span>

                    </div>


                    <div class="dep-field">

                        <label class="dep-label">
                            สามารถจอดได้ที่
                        </label>

                        <input
                            name="car_park"
                            class="dep-input"
                            value="<?php
                                echo depH(
                                    $depData[
                                        'car_park'
                                    ]
                                );
                            ?>"
                        >

                    </div>


                    <div class="dep-check">

                        <input
                            type="checkbox"
                            name="car_road"
                            value="1"
                            <?php
                            echo
                                $depData[
                                    'car_road'
                                ] == '1'
                                ? 'checked'
                                : '';
                            ?>
                        >

                        <span>
                            จอดรถข้างถนน
                        </span>

                    </div>


                    <div class="dep-check">

                        <input
                            type="checkbox"
                            name="car_home"
                            value="1"
                            <?php
                            echo
                                $depData[
                                    'car_home'
                                ] == '1'
                                ? 'checked'
                                : '';
                            ?>
                        >

                        <span>
                            จอดรถหน้าบ้านได้
                        </span>

                    </div>


                    <div class="dep-field">

                        <label class="dep-label">
                            ประตูหน้าบ้านสูง (เมตร)
                        </label>

                        <input
                            name="door_long"
                            class="dep-input"
                            value="<?php
                                echo depH(
                                    $depData[
                                        'door_long'
                                    ]
                                );
                            ?>"
                        >

                    </div>


                    <div class="dep-check">

                        <input
                            type="checkbox"
                            name="slope"
                            value="1"
                            <?php
                            echo
                                $depData[
                                    'slope'
                                ] == '1'
                                ? 'checked'
                                : '';
                            ?>
                        >

                        <span>
                            มีทางราบก่อนประตูบ้าน
                        </span>

                    </div>


                    <div class="dep-check">

                        <input
                            type="checkbox"
                            name="bundai"
                            value="1"
                            <?php
                            echo
                                $depData[
                                    'bundai'
                                ] == '1'
                                ? 'checked'
                                : '';
                            ?>
                        >

                        <span>
                            มีบันไดก่อนประตูบ้าน
                        </span>

                    </div>


                    <div class="dep-field">

                        <label class="dep-label">
                            จำนวนบันได (ขั้น)
                        </label>

                        <input
                            name="unit_bundai"
                            class="dep-input"
                            value="<?php
                                echo depH(
                                    $depData[
                                        'unit_bundai'
                                    ]
                                );
                            ?>"
                        >

                    </div>


                    <div class="dep-field">

                        <label class="dep-label">
                            ประตูบ้านกว้าง (เมตร)
                        </label>

                        <input
                            name="door_bigger"
                            class="dep-input"
                            value="<?php
                                echo depH(
                                    $depData[
                                        'door_bigger'
                                    ]
                                );
                            ?>"
                        >

                    </div>


                    <div class="dep-field">

                        <label class="dep-label">
                            ประตูบ้านสูง (เมตร)
                        </label>

                        <input
                            name="door_longer"
                            class="dep-input"
                            value="<?php
                                echo depH(
                                    $depData[
                                        'door_longer'
                                    ]
                                );
                            ?>"
                        >

                    </div>


                    <div class="dep-field">

                        <label class="dep-label">
                            ประตูห้องกว้าง (เมตร)
                        </label>

                        <input
                            name="room_bigger"
                            class="dep-input"
                            value="<?php
                                echo depH(
                                    $depData[
                                        'room_bigger'
                                    ]
                                );
                            ?>"
                        >

                    </div>


                    <div class="dep-field">

                        <label class="dep-label">
                            ประตูห้องสูง (เมตร)
                        </label>

                        <input
                            name="room_longer"
                            class="dep-input"
                            value="<?php
                                echo depH(
                                    $depData[
                                        'room_longer'
                                    ]
                                );
                            ?>"
                        >

                    </div>


                    <div class="dep-field">

                        <label class="dep-label">
                            ประตูบ้านเป็นแบบ
                        </label>

                        <input
                            name="type_door"
                            class="dep-input"
                            value="<?php
                                echo depH(
                                    $depData[
                                        'type_door'
                                    ]
                                );
                            ?>"
                        >

                    </div>


                    <div class="dep-field">

                        <label class="dep-label">
                            พื้นบ้านเป็นแบบ
                        </label>

                        <input
                            name="home_type"
                            class="dep-input"
                            value="<?php
                                echo depH(
                                    $depData[
                                        'home_type'
                                    ]
                                );
                            ?>"
                        >

                    </div>


                    <div class="dep-field">

                        <label class="dep-label">
                            ติดตั้งที่ชั้น
                        </label>

                        <input
                            name="install"
                            class="dep-input"
                            value="<?php
                                echo depH(
                                    $depData[
                                        'install'
                                    ]
                                );
                            ?>"
                        >

                    </div>


                    <div class="dep-check">

                        <input
                            type="checkbox"
                            name="bundai_install"
                            value="1"
                            <?php
                            echo
                                $depData[
                                    'bundai_install'
                                ] == '1'
                                ? 'checked'
                                : '';
                            ?>
                        >

                        <span>
                            มีบันไดสำหรับขึ้นติดตั้ง
                        </span>

                    </div>


                    <div class="dep-field">

                        <label class="dep-label">
                            บันไดกว้าง (เมตร)
                        </label>

                        <input
                            name="bundai_big"
                            class="dep-input"
                            value="<?php
                                echo depH(
                                    $depData[
                                        'bundai_big'
                                    ]
                                );
                            ?>"
                        >

                    </div>


                    <div class="dep-field">

                        <label class="dep-label">
                            หักมุมบันได
                        </label>

                        <input
                            name="bundai_hug"
                            class="dep-input"
                            value="<?php
                                echo depH(
                                    $depData[
                                        'bundai_hug'
                                    ]
                                );
                            ?>"
                        >

                    </div>


                    <div class="dep-field">

                        <label class="dep-label">
                            ชนิดของบันได
                        </label>

                        <input
                            name="type_bundai"
                            class="dep-input"
                            value="<?php
                                echo depH(
                                    $depData[
                                        'type_bundai'
                                    ]
                                );
                            ?>"
                        >

                    </div>


                    <div class="dep-check">

                        <input
                            type="checkbox"
                            name="lip"
                            value="1"
                            <?php
                            echo
                                $depData[
                                    'lip'
                                ] == '1'
                                ? 'checked'
                                : '';
                            ?>
                        >

                        <span>
                            มีลิฟท์
                        </span>

                    </div>


                    <div class="dep-field">

                        <label class="dep-label">
                            ลิฟท์กว้าง (เมตร)
                        </label>

                        <input
                            name="lip_big"
                            class="dep-input"
                            value="<?php
                                echo depH(
                                    $depData[
                                        'lip_big'
                                    ]
                                );
                            ?>"
                        >

                    </div>


                    <div class="dep-field">

                        <label class="dep-label">
                            ลิฟท์สูง (เมตร)
                        </label>

                        <input
                            name="lip_long"
                            class="dep-input"
                            value="<?php
                                echo depH(
                                    $depData[
                                        'lip_long'
                                    ]
                                );
                            ?>"
                        >

                    </div>


                    <div class="dep-field">

                        <label class="dep-label">
                            ลิฟท์รับน้ำหนักได้
                        </label>

                        <input
                            name="lip_weight"
                            class="dep-input"
                            value="<?php
                                echo depH(
                                    $depData[
                                        'lip_weight'
                                    ]
                                );
                            ?>"
                        >

                    </div>


                    <div class="dep-check">

                        <input
                            type="checkbox"
                            name="up"
                            value="1"
                            <?php
                            echo
                                $depData[
                                    'up'
                                ] == '1'
                                ? 'checked'
                                : '';
                            ?>
                        >

                        <span>
                            ขึ้นลิฟท์ได้
                        </span>

                    </div>


                    <div class="dep-check">

                        <input
                            type="checkbox"
                            name="no_up"
                            value="1"
                            <?php
                            echo
                                $depData[
                                    'no_up'
                                ] == '1'
                                ? 'checked'
                                : '';
                            ?>
                        >

                        <span>
                            ขึ้นลิฟท์ไม่ได้
                        </span>

                    </div>


                    <div class="dep-check">

                        <input
                            type="checkbox"
                            name="head_bad"
                            value="1"
                            <?php
                            echo
                                $depData[
                                    'head_bad'
                                ] == '1'
                                ? 'checked'
                                : '';
                            ?>
                        >

                        <span>
                            ต้องถอดหัวเตียง-ท้ายเตียง
                        </span>

                    </div>


                    <div class="dep-check">

                        <input
                            type="checkbox"
                            name="want_employee"
                            value="1"
                            <?php
                            echo
                                $depData[
                                    'want_employee'
                                ] == '1'
                                ? 'checked'
                                : '';
                            ?>
                        >

                        <span>
                            ต้องการเจ้าหน้าที่ย้ายเฟอร์นิเจอร์
                        </span>

                    </div>


                    <div class="dep-field">

                        <label class="dep-label">
                            จำนวนคนที่ใช้
                        </label>

                        <input
                            name="employee_unit"
                            class="dep-input"
                            value="<?php
                                echo depH(
                                    $depData[
                                        'employee_unit'
                                    ]
                                );
                            ?>"
                        >

                    </div>


                    <div class="dep-field">

                        <label class="dep-label">
                            ย้ายเฟอร์นิเจอร์
                        </label>

                        <input
                            name="ferniger_name"
                            class="dep-input"
                            value="<?php
                                echo depH(
                                    $depData[
                                        'ferniger_name'
                                    ]
                                );
                            ?>"
                        >

                    </div>


                    <div class="dep-field">

                        <label class="dep-label">
                            ย้ายไปที่
                        </label>

                        <input
                            name="ferniger_address"
                            class="dep-input"
                            value="<?php
                                echo depH(
                                    $depData[
                                        'ferniger_address'
                                    ]
                                );
                            ?>"
                        >

                    </div>


                    <div class="dep-check">

                        <input
                            type="checkbox"
                            name="want_ex"
                            value="1"
                            <?php
                            echo
                                $depData[
                                    'want_ex'
                                ] == '1'
                                ? 'checked'
                                : '';
                            ?>
                        >

                        <span>
                            ต้องเตรียมอุปกรณ์ไปถอดประกอบ
                        </span>

                    </div>


                    <div class="dep-check">

                        <input
                            type="checkbox"
                            name="want_credit"
                            value="1"
                            <?php
                            echo
                                $depData[
                                    'want_credit'
                                ] == '1'
                                ? 'checked'
                                : '';
                            ?>
                        >

                        <span>
                            ต้องเตรียมเครื่องรูดบัตร
                        </span>

                    </div>


                    <div class="dep-field">

                        <label class="dep-label">
                            ธนาคารเครื่องรูดบัตร
                        </label>

                        <input
                            name="bank"
                            class="dep-input"
                            value="<?php
                                echo depH(
                                    $depData[
                                        'bank'
                                    ]
                                );
                            ?>"
                        >

                    </div>


                    <div class="dep-check">

                        <input
                            type="checkbox"
                            name="want_prem"
                            value="1"
                            <?php
                            echo
                                $depData[
                                    'want_prem'
                                ] == '1'
                                ? 'checked'
                                : '';
                            ?>
                        >

                        <span>
                            ต้องการเตรียมฟิล์มยืดสำหรับเก็บเตียงหรือที่นอนเก่า
                        </span>

                    </div>


                    <div class="dep-field dep-full">

                        <label class="dep-label">
                            รายละเอียดเพิ่มเติม
                        </label>

                        <textarea
                            name="description_ja"
                            class="dep-textarea"
                            rows="3"
                        ><?php
                            echo depH(
                                $depData[
                                    'description_ja'
                                ]
                            );
                        ?></textarea>

                    </div>

                </div>

            </div>

        </div>


        <!-- =================================================
             ACTION
        ================================================== -->

        <div class="dep-sticky">

            <div class="dep-sticky-inner">

                <a
                    href="status_deposit.php"
                    class="dep-back-btn"
                >
                    กลับ
                </a>


                <button
                    type="submit"
                    name="save_deposit"
                    value="1"
                    id="depSaveButton"
                    class="dep-save-btn"
                >

                    <i class="far fa-save"></i>

                    <?php
                    echo $editMode
                        ? 'Update'
                        : 'Save';
                    ?>

                </button>

            </div>

        </div>

    </form>

</div>


<script>

/*
|--------------------------------------------------------------------------
| PRODUCT
|--------------------------------------------------------------------------
*/

var depVisibleProductGroup = 1;


document.addEventListener(
    'DOMContentLoaded',
    function () {

        var group2HasData = false;
        var group3HasData = false;

        for (
            var i = 6;
            i <= 10;
            i++
        ) {

            var p =
                document.getElementById(
                    'product_name' + i
                );

            var price =
                document.getElementById(
                    'unit_price' + i
                );

            if (
                (
                    p &&
                    p.value.trim() !== ''
                ) ||
                (
                    price &&
                    parseFloat(
                        String(
                            price.value
                        ).replace(
                            /,/g,
                            ''
                        )
                    ) > 0
                )
            ) {

                group2HasData = true;
            }
        }


        for (
            var j = 11;
            j <= 15;
            j++
        ) {

            var p3 =
                document.getElementById(
                    'product_name' + j
                );

            var price3 =
                document.getElementById(
                    'unit_price' + j
                );

            if (
                (
                    p3 &&
                    p3.value.trim() !== ''
                ) ||
                (
                    price3 &&
                    parseFloat(
                        String(
                            price3.value
                        ).replace(
                            /,/g,
                            ''
                        )
                    ) > 0
                )
            ) {

                group3HasData = true;
            }
        }


        if (group2HasData) {

            document
                .querySelectorAll(
                    '.product-group-2'
                )
                .forEach(
                    function(row) {
                        row.style.display =
                            'table-row';
                    }
                );

            depVisibleProductGroup = 2;
        }


        if (group3HasData) {

            document
                .querySelectorAll(
                    '.product-group-2, .product-group-3'
                )
                .forEach(
                    function(row) {
                        row.style.display =
                            'table-row';
                    }
                );

            depVisibleProductGroup = 3;
        }


        if (
            depVisibleProductGroup >= 3
        ) {

            var moreBtn =
                document.getElementById(
                    'btnMoreProduct'
                );

            if (moreBtn) {
                moreBtn.style.display =
                    'none';
            }
        }


        depCalculateTotal();
        depPaymentChange();

    }
);


function depShowMoreProducts()
{
    if (
        depVisibleProductGroup === 1
    ) {

        document
            .querySelectorAll(
                '.product-group-2'
            )
            .forEach(
                function(row) {

                    row.style.display =
                        'table-row';

                }
            );

        depVisibleProductGroup = 2;

        return;
    }


    if (
        depVisibleProductGroup === 2
    ) {

        document
            .querySelectorAll(
                '.product-group-3'
            )
            .forEach(
                function(row) {

                    row.style.display =
                        'table-row';

                }
            );

        depVisibleProductGroup = 3;


        var button =
            document.getElementById(
                'btnMoreProduct'
            );

        if (button) {

            button.style.display =
                'none';
        }
    }
}


function depNumber(value)
{
    var clean =
        String(
            value || ''
        ).replace(
            /,/g,
            ''
        );

    var num =
        parseFloat(
            clean
        );

    return isNaN(num)
        ? 0
        : num;
}


function depCalculateTotal()
{
    var total = 0;

    for (
        var i = 1;
        i <= 15;
        i++
    ) {

        var input =
            document.getElementById(
                'unit_price' + i
            );

        if (input) {

            total += depNumber(
                input.value
            );
        }
    }


    var totalInput =
        document.getElementById(
            'sum_unit_price'
        );


    if (totalInput) {

        totalInput.value =
            total.toLocaleString(
                'en-US',
                {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }
            );
    }
}


function depFormatMoney(input)
{
    if (!input) {
        return;
    }

    var number =
        depNumber(
            input.value
        );


    input.value =
        number.toLocaleString(
            'en-US',
            {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }
        );


    depCalculateTotal();
}


/*
|--------------------------------------------------------------------------
| PAYMENT
|--------------------------------------------------------------------------
*/

function depPaymentChange()
{
    var select =
        document.getElementById(
            'payment_select'
        );

    var wrap =
        document.getElementById(
            'payment_custom_wrap'
        );

    if (
        !select ||
        !wrap
    ) {

        return;
    }


    wrap.style.display =
        select.value === '__custom__'
        ? 'block'
        : 'none';
}


/*
|--------------------------------------------------------------------------
| MORE DELIVERY
|--------------------------------------------------------------------------
*/

var moreCheckbox =
    document.getElementById(
        'more'
    );

if (moreCheckbox) {

    moreCheckbox.addEventListener(
        'change',
        function () {

            var box =
                document.getElementById(
                    'delivery_more'
                );

            if (!box) {
                return;
            }


            box.style.display =
                this.checked
                ? 'block'
                : 'none';

        }
    );
}


/*
|--------------------------------------------------------------------------
| SIGNATURE / MAP
|--------------------------------------------------------------------------
*/

var depSignatureChanged = false;
var depSignature = null;


$(document).ready(
    function () {

        depSignature =
            $('#employee_send_signature');


        if (
            depSignature.length
        ) {

            depSignature.jSignature({
                'UndoButton': true,
                'height': 220
            });


            depSignature.bind(
                'change',
                function () {

                    depSignatureChanged =
                        true;
                }
            );


            /*
             * ถ้ามีข้อมูลเดิม และ jSignature รองรับ
             * จะพยายามแสดงกลับ
             */
            var oldData =
                $('#employee_signature_old')
                .val();


            if (
                oldData &&
                oldData.indexOf(
                    'data:'
                ) === 0
            ) {

                try {

                    depSignature.jSignature(
                        'setData',
                        oldData
                    );

                    depSignatureChanged =
                        false;

                } catch (e) {

                    console.log(
                        'ไม่สามารถโหลดแผนที่เดิมเข้าสู่ jSignature ได้'
                    );
                }
            }
        }
    }
);


function depResetSignature()
{
    if (
        depSignature &&
        depSignature.length
    ) {

        depSignature.jSignature(
            'reset'
        );

        depSignatureChanged = true;


        var oldInput =
            document.getElementById(
                'employee_signature_old'
            );

        if (oldInput) {

            oldInput.value = '';
        }
    }
}


/*
|--------------------------------------------------------------------------
| SUBMIT
|--------------------------------------------------------------------------
*/

var depSubmitting = false;


function depBeforeSubmit()
{
    if (depSubmitting) {
        return false;
    }


    /*
     * เก็บ jSignature
     */
    if (
        depSignature &&
        depSignature.length &&
        depSignatureChanged
    ) {

        try {

            var data =
                depSignature.jSignature(
                    'getData',
                    'image/png;base64'
                );


            if (
                Array.isArray(data) &&
                data.length === 2
            ) {

                var signatureInput =
                    document.getElementById(
                        'employee_signature_name'
                    );


                if (signatureInput) {

                    signatureInput.value =
                        'data:' +
                        data[0] +
                        ',' +
                        data[1];
                }
            }

        } catch (e) {

            console.log(
                e
            );
        }
    }


    /*
     * เอา comma ราคาออกก่อน POST
     */
    for (
        var i = 1;
        i <= 15;
        i++
    ) {

        var priceInput =
            document.getElementById(
                'unit_price' + i
            );

        if (priceInput) {

            priceInput.value =
                String(
                    priceInput.value
                ).replace(
                    /,/g,
                    ''
                );
        }
    }


    var sumInput =
        document.getElementById(
            'sum_unit_price'
        );

    if (sumInput) {

        sumInput.value =
            String(
                sumInput.value
            ).replace(
                /,/g,
                ''
            );
    }


    depSubmitting = true;


    var button =
        document.getElementById(
            'depSaveButton'
        );


    if (button) {

        button.innerHTML =
            '<i class="fas fa-spinner fa-spin"></i> กำลังบันทึก...';

        setTimeout(
            function () {

                button.disabled = true;

            },
            0
        );
    }


    return true;
}

</script>


<div id="cr_bar">
<?php
include("foot.php");
?>
</div>

</body>
</html>