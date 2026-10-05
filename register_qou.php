<?php
include("head.php");

if (!isset($conn)) {
    include("dbconnect.php");
}

date_default_timezone_set("Asia/Bangkok");


/*
|--------------------------------------------------------------------------
| Helper
|--------------------------------------------------------------------------
*/

function qouPost($key, $default = '')
{
    return isset($_POST[$key])
        ? trim($_POST[$key])
        : $default;
}


function qouEsc($conn, $value)
{
    return mysqli_real_escape_string(
        $conn,
        (string)$value
    );
}


function qouMoney($value)
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


function qouH($value)
{
    return htmlspecialchars(
        (string)$value,
        ENT_QUOTES,
        'UTF-8'
    );
}


/*
|--------------------------------------------------------------------------
| Generate Next Quotation Reference
|--------------------------------------------------------------------------
*/

function getNextQuotationRef(
    $conn,
    $typeDoc,
    $prefix,
    $yearMonth
) {

    $typeDocDb = qouEsc(
        $conn,
        $typeDoc
    );

    $sql = "
        SELECT MAX(ref_id) AS MAXID
        FROM qou__main
        WHERE type_doc = '{$typeDocDb}'
    ";

    $qry = mysqli_query(
        $conn,
        $sql
    );

    if (!$qry) {

        die(
            "Error Generate Reference : " .
            mysqli_error($conn)
        );
    }


    $rs = mysqli_fetch_assoc($qry);

    $maxRefId = isset($rs['MAXID'])
        ? $rs['MAXID']
        : '';


    $maxId = substr(
        $maxRefId,
        -4
    );

    $maxId3 = substr(
        $maxRefId,
        -8
    );

    $maxId1 = substr(
        $maxId3,
        0,
        -4
    );


    if ($maxId1 == $yearMonth) {

        $running =
            intval($maxId) + 1;

        $running = str_pad(
            $running,
            4,
            '0',
            STR_PAD_LEFT
        );

    } else {

        $running = '0001';

    }


    return
        $prefix .
        $yearMonth .
        $running;
}


/*
|--------------------------------------------------------------------------
| Upload File
|--------------------------------------------------------------------------
*/

function qouUploadFile(
    $fieldName,
    $oldFile = ''
) {

    if (
        !isset($_FILES[$fieldName]) ||
        !isset($_FILES[$fieldName]['error']) ||
        $_FILES[$fieldName]['error'] !== UPLOAD_ERR_OK
    ) {

        return $oldFile;
    }


    $uploadDir = __DIR__ . '/qou/';


    if (!is_dir($uploadDir)) {

        @mkdir(
            $uploadDir,
            0777,
            true
        );
    }


    $fileName = basename(
        $_FILES[$fieldName]['name']
    );


    $diskName = @iconv(
        'UTF-8',
        'TIS-620//TRANSLIT',
        $fileName
    );


    if ($diskName === false || $diskName === '') {
        $diskName = $fileName;
    }


    move_uploaded_file(
        $_FILES[$fieldName]['tmp_name'],
        $uploadDir . $diskName
    );


    return $fileName;
}


/*
|--------------------------------------------------------------------------
| Default Data
|--------------------------------------------------------------------------
*/

$qouData = array(

    'ref_id' => '',

    'register_date' => date('Y-m-d'),

    'type_doc' => '1',

    'type_head' => '1',

    'cus_name' => '',

    'description' => '',

    'payment_dead' => '',

    'payment_dead_other_wrap' => '',

    'set_price' => '',

    'delivery_dead' => '',

    'delivery_date' => '',

    'waranty' => '',

    'cusmail_name' => '',

    'email' => '',

    'iv_date' => '',

    'iv_no' => '',

    'remark_ckk' => '0',

    'waranty_ckk' => '0',

    'remark1' => '',

    'remark2' => '',

    'remark3' => '',

    'remark4' => '',

    'remark5' => '',

    'speck' => '',

    'catalog' => '',

    'picture' => ''

);


/*
|--------------------------------------------------------------------------
| MODE
|--------------------------------------------------------------------------
*/

$editMode = false;
$copyMode = false;
$editRefId = '';
$copyRefId = '';
$loadRefId = '';


if (
    isset($_GET['ref_id']) &&
    trim($_GET['ref_id']) !== ''
) {

    $editMode = true;
    $editRefId = trim($_GET['ref_id']);
    $loadRefId = $editRefId;

} elseif (
    isset($_GET['copy_ref']) &&
    trim($_GET['copy_ref']) !== ''
) {

    $copyMode = true;
    $copyRefId = trim($_GET['copy_ref']);
    $loadRefId = $copyRefId;
}


/*
|--------------------------------------------------------------------------
| POST : SAVE
|--------------------------------------------------------------------------
*/

if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    in_array(qouPost('submit'), array('submit', 'submit_sup', 'cancel_doc', 'approve_doc', 'return_doc', 'reject_doc'), true)
) {

    /*
    |--------------------------------------------------------------------------
    | Submit Action
    | submit     = Save Draft / Update
    | submit_sup = Save + Send to SUP Approval
    | cancel_doc  = Cancel document + save status log
    | approve_doc = SUP Approve
    | return_doc  = SUP Return + reason log
    | reject_doc  = SUP Reject + reason log
    |--------------------------------------------------------------------------
    */

    $submitAction = qouPost('submit');

    /*
    |--------------------------------------------------------------------------
    | Mode
    |--------------------------------------------------------------------------
    */

    $formMode = qouPost(
        'form_mode',
        'add'
    );


    $postedRefId = qouPost(
        'ref_id'
    );


    /*
    |--------------------------------------------------------------------------
    | รับค่าจาก Form
    |--------------------------------------------------------------------------
    */

    $type_doc = qouPost(
        'type_doc',
        '1'
    );


    $type_head = qouPost(
        'type_head',
        '1'
    );


    $cus_name =
        qouPost('cus_name');


    $description =
        qouPost('description');


    $payment_dead =
        qouPost('payment_dead');


    $payment_dead_other =
        qouPost(
            'payment_dead_other'
        );


    $payment_dead_other_wrap = '';

    if (
        $payment_dead === 'อื่นๆ' ||
        strtolower($payment_dead) === 'other'
    ) {

        $payment_dead_other_wrap =
            $payment_dead_other;
    }


    $set_price =
        qouPost('set_price');


    $delivery_dead =
        qouPost('delivery_dead');


    $delivery_date =
        qouPost('delivery_date');


    $waranty =
        qouPost('waranty');


    $cusmail_name =
        qouPost('cusmail_name');


    $email =
        qouPost('email');


    $iv_date =
        qouPost('iv_date');


    $iv_no =
        qouPost('iv_no');


    $remark_ckk =
        isset($_POST['remark_ckk'])
            ? '1'
            : '0';


    $waranty_ckk =
        isset($_POST['waranty_ckk'])
            ? qouPost('waranty_ckk')
            : '0';


    $remark1 =
        qouPost('remark1');

    $remark2 =
        qouPost('remark2');

    $remark3 =
        qouPost('remark3');

    $remark4 =
        qouPost('remark4');

    $remark5 =
        qouPost('remark5');


    /*
    |--------------------------------------------------------------------------
    | Validate
    |--------------------------------------------------------------------------
    */

    if (
        $type_doc !== '1' &&
        $type_doc !== '2'
    ) {

        echo "
        <script>
            alert('กรุณาเลือกบริษัท');
            history.back();
        </script>
        ";

        exit;
    }


    if (
        $type_head !== '1' &&
        $type_head !== '2'
    ) {

        echo "
        <script>
            alert('กรุณาเลือกประเภทสินค้า');
            history.back();
        </script>
        ";

        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | Add By
    |--------------------------------------------------------------------------
    */

    $add_date =
        date('Y-m-d H:i:s');


    $sessionName =
        isset($_SESSION['name'])
            ? $_SESSION['name']
            : '';


    $sessionSurname =
        isset($_SESSION['surname'])
            ? $_SESSION['surname']
            : '';


    $add_by = trim(
        $sessionName .
        ' ' .
        $sessionSurname
    );


    /*
    |--------------------------------------------------------------------------
    | SUP APPROVAL ACTION
    |--------------------------------------------------------------------------
    | ใช้ได้เฉพาะเอกสาร status_doc=Request, send_sup=1
    | และผู้ใช้ SS3 / IT / owner เท่านั้น
    */
    if (in_array($submitAction, array('approve_doc', 'return_doc', 'reject_doc'), true)) {

        if ($postedRefId === '') {
            echo "<script>alert('ไม่พบเลขที่เอกสาร');history.back();</script>";
            exit;
        }

        $sessionCode = isset($_SESSION['code']) ? trim((string)$_SESSION['code']) : '';
        $sessionTypeLogin = isset($_SESSION['type_login']) ? strtolower(trim((string)$_SESSION['type_login'])) : '';

        $canSupApprove = (
            $sessionCode === 'SS3' ||
            $sessionTypeLogin === 'it' ||
            $sessionTypeLogin === 'owner'
        );

        if (!$canSupApprove) {
            echo "<script>alert('คุณไม่มีสิทธิ์ดำเนินการอนุมัติเอกสารนี้');history.back();</script>";
            exit;
        }

        $ref_id = $postedRefId;
        $refDb = qouEsc($conn, $ref_id);

        $sqlCheckApproval = "
            SELECT status_doc, send_sup
            FROM qou__main
            WHERE ref_id = '{$refDb}'
            LIMIT 1
        ";

        $queryCheckApproval = mysqli_query($conn, $sqlCheckApproval);

        if (!$queryCheckApproval) {
            echo "<script>alert('ตรวจสอบสถานะเอกสารไม่สำเร็จ');history.back();</script>";
            exit;
        }

        $approvalDoc = mysqli_fetch_assoc($queryCheckApproval);

        if (
            !$approvalDoc ||
            strtolower(trim((string)$approvalDoc['status_doc'])) !== 'request' ||
            (string)$approvalDoc['send_sup'] !== '1'
        ) {
            echo "<script>alert('เอกสารนี้ไม่ได้อยู่ในสถานะรอ SUP อนุมัติ');window.location='register_qou.php?ref_id=" . urlencode($ref_id) . "';</script>";
            exit;
        }

        $supReason = qouPost('sup_action_reason');

        if (in_array($submitAction, array('return_doc', 'reject_doc'), true) && $supReason === '') {
            echo "<script>alert('กรุณาระบุหมายเหตุ');history.back();</script>";
            exit;
        }

        if ($submitAction === 'approve_doc') {
            $newStatus = 'Approve';
            $successMessage = 'อนุมัติเอกสารเรียบร้อยแล้ว';
        } elseif ($submitAction === 'return_doc') {
            $newStatus = 'Returned';
            $successMessage = 'ส่งกลับเอกสารเรียบร้อยแล้ว';
        } else {
            $newStatus = 'Rejected';
            $successMessage = 'ไม่อนุมัติเอกสารเรียบร้อยแล้ว';
        }

        $newStatusDb = qouEsc($conn, $newStatus);
        $reasonDb = qouEsc($conn, $supReason);
        $userNameDb = qouEsc($conn, $add_by);

        // ข้อมูลผู้อนุมัติ / ผู้ไม่อนุมัติ
        $supCode = isset($_SESSION['emid']) ? trim((string)$_SESSION['emid']) : '';
        $supCodeDb = qouEsc($conn, $supCode);
        $supNameDb = qouEsc($conn, $add_by);
        $supDateDb = qouEsc($conn, $add_date);

        $sessionUserId = '';
        if (!empty($_SESSION['username'])) {
            $sessionUserId = $_SESSION['username'];
        } elseif (!empty($_SESSION['user_id'])) {
            $sessionUserId = $_SESSION['user_id'];
        } elseif (!empty($_SESSION['code'])) {
            $sessionUserId = $_SESSION['code'];
        } elseif (!empty($_SESSION['login'])) {
            $sessionUserId = $_SESSION['login'];
        }

        $userIdDb = qouEsc($conn, $sessionUserId);
        $actionDateDb = qouEsc($conn, date('Y-m-d H:i:s'));

        mysqli_begin_transaction($conn);

        try {

            if (in_array($submitAction, array('approve_doc', 'reject_doc'), true)) {

                $sqlSupAction = "
                    UPDATE qou__main
                    SET
                        status_doc = '{$newStatusDb}',
                        sup_name = '{$supNameDb}',
                        sup_date = '{$supDateDb}',
                        sup_code = '{$supCodeDb}'
                    WHERE ref_id = '{$refDb}'
                ";

            } else {

                // ส่งกลับ (Returned) เปลี่ยนเฉพาะสถานะ ไม่ถือเป็นผลอนุมัติสุดท้าย
                $sqlSupAction = "
                    UPDATE qou__main
                    SET status_doc = '{$newStatusDb}'
                    WHERE ref_id = '{$refDb}'
                ";
            }

            if (!mysqli_query($conn, $sqlSupAction)) {
                throw new Exception('อัปเดตสถานะเอกสารไม่สำเร็จ : ' . mysqli_error($conn));
            }

            /* ส่งกลับ / ไม่อนุมัติ ต้องเก็บเหตุผลลง Status Log */
            if (in_array($submitAction, array('return_doc', 'reject_doc'), true)) {

                $sqlSupLog = "
                    INSERT INTO tb_document_status_log
                    (ref_id, status_doc, reason, user_id, user_name, created_at)
                    VALUES
                    ('{$refDb}', '{$newStatusDb}', '{$reasonDb}', '{$userIdDb}', '{$userNameDb}', '{$actionDateDb}')
                ";

                if (!mysqli_query($conn, $sqlSupLog)) {
                    throw new Exception('บันทึกประวัติสถานะไม่สำเร็จ : ' . mysqli_error($conn));
                }
            }

            mysqli_commit($conn);

            $goRef = urlencode($ref_id);
            $successMessageJs = json_encode($successMessage, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            echo "<script>alert({$successMessageJs});window.location='register_qou.php?ref_id={$goRef}';</script>";
            exit;

        } catch (Exception $e) {

            mysqli_rollback($conn);
            $errorMessageJs = json_encode($e->getMessage(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            echo "<script>alert({$errorMessageJs});history.back();</script>";
            exit;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | CANCEL DOCUMENT
    |--------------------------------------------------------------------------
    */
    if ($submitAction === 'cancel_doc') {

        $cancelReason = qouPost('cancel_reason');

        if ($postedRefId === '') {
            echo "<script>alert('กรุณาบันทึกเอกสารก่อนยกเลิก');history.back();</script>";
            exit;
        }

        if ($cancelReason === '') {
            echo "<script>alert('กรุณาระบุหมายเหตุการยกเลิก');history.back();</script>";
            exit;
        }

        $ref_id = $postedRefId;
        $refDb = qouEsc($conn, $ref_id);
        $reasonDb = qouEsc($conn, $cancelReason);
        $userNameDb = qouEsc($conn, $add_by);

        $sessionUserId = '';
        if (!empty($_SESSION['username'])) {
            $sessionUserId = $_SESSION['username'];
        } elseif (!empty($_SESSION['user_id'])) {
            $sessionUserId = $_SESSION['user_id'];
        } elseif (!empty($_SESSION['code'])) {
            $sessionUserId = $_SESSION['code'];
        } elseif (!empty($_SESSION['login'])) {
            $sessionUserId = $_SESSION['login'];
        }

        $userIdDb = qouEsc($conn, $sessionUserId);
        $cancelDate = date('Y-m-d H:i:s');
        $cancelDateDb = qouEsc($conn, $cancelDate);

        mysqli_begin_transaction($conn);

        try {
            $sqlCancel = "
                UPDATE qou__main
                SET status_doc = 'Cancelled'
                WHERE ref_id = '{$refDb}'
            ";

            if (!mysqli_query($conn, $sqlCancel)) {
                throw new Exception('ยกเลิกเอกสารไม่สำเร็จ : ' . mysqli_error($conn));
            }

            $sqlStatusLog = "
                INSERT INTO tb_document_status_log
                (ref_id, status_doc, reason, user_id, user_name, created_at)
                VALUES
                ('{$refDb}', 'Cancelled', '{$reasonDb}', '{$userIdDb}', '{$userNameDb}', '{$cancelDateDb}')
            ";

            if (!mysqli_query($conn, $sqlStatusLog)) {
                throw new Exception('บันทึกประวัติการยกเลิกไม่สำเร็จ : ' . mysqli_error($conn));
            }

            mysqli_commit($conn);

            $goRef = urlencode($ref_id);
            echo "<script>alert('ยกเลิกเอกสารเรียบร้อยแล้ว');window.location='register_qou.php?ref_id={$goRef}';</script>";
            exit;

        } catch (Exception $e) {
            mysqli_rollback($conn);
            $error = qouH($e->getMessage());
            echo "<script>alert('{$error}');history.back();</script>";
            exit;
        }
    }


    mysqli_begin_transaction(
        $conn
    );


    try {

        /*
        |--------------------------------------------------------------------------
        | EDIT MODE
        |--------------------------------------------------------------------------
        */

        if (
            $formMode === 'edit' &&
            $postedRefId !== ''
        ) {

            $ref_id =
                $postedRefId;


            $refDb =
                qouEsc(
                    $conn,
                    $ref_id
                );


            /*
            |--------------------------------------------------------------------------
            | ดึงข้อมูลไฟล์เดิม
            |--------------------------------------------------------------------------
            */

            $sqlOld = "
                SELECT
                    speck,
                    catalog,
                    picture
                FROM qou__main
                WHERE ref_id = '{$refDb}'
                LIMIT 1
            ";


            $queryOld =
                mysqli_query(
                    $conn,
                    $sqlOld
                );


            if (!$queryOld) {

                throw new Exception(
                    mysqli_error($conn)
                );
            }


            $oldData =
                mysqli_fetch_assoc(
                    $queryOld
                );


            if (!$oldData) {

                throw new Exception(
                    'ไม่พบใบเสนอราคาที่ต้องการแก้ไข'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Upload ใหม่ / เก็บไฟล์เดิม
            |--------------------------------------------------------------------------
            */

            $speck =
                qouUploadFile(
                    'speck',
                    isset($oldData['speck'])
                        ? $oldData['speck']
                        : ''
                );


            $catalog =
                qouUploadFile(
                    'catalog',
                    isset($oldData['catalog'])
                        ? $oldData['catalog']
                        : ''
                );


            $picture =
                qouUploadFile(
                    'picture',
                    isset($oldData['picture'])
                        ? $oldData['picture']
                        : ''
                );


            /*
            |--------------------------------------------------------------------------
            | Escape
            |--------------------------------------------------------------------------
            */

            $cusNameDb =
                qouEsc(
                    $conn,
                    $cus_name
                );


            $descriptionDb =
                qouEsc(
                    $conn,
                    $description
                );


            $paymentDb =
                qouEsc(
                    $conn,
                    $payment_dead
                );


            $paymentOtherDb =
                qouEsc(
                    $conn,
                    $payment_dead_other_wrap
                );


            $setPriceDb =
                qouEsc(
                    $conn,
                    $set_price
                );


            $deliveryDb =
                qouEsc(
                    $conn,
                    $delivery_dead
                );


            $deliveryDateDb =
                qouEsc(
                    $conn,
                    $delivery_date
                );


            $warantyDb =
                qouEsc(
                    $conn,
                    $waranty
                );


            $cusmailDb =
                qouEsc(
                    $conn,
                    $cusmail_name
                );


            $emailDb =
                qouEsc(
                    $conn,
                    $email
                );


            $ivDateDb =
                qouEsc(
                    $conn,
                    $iv_date
                );


            $ivNoDb =
                qouEsc(
                    $conn,
                    $iv_no
                );


            $remark1Db =
                qouEsc(
                    $conn,
                    $remark1
                );


            $remark2Db =
                qouEsc(
                    $conn,
                    $remark2
                );


            $remark3Db =
                qouEsc(
                    $conn,
                    $remark3
                );


            $remark4Db =
                qouEsc(
                    $conn,
                    $remark4
                );


            $remark5Db =
                qouEsc(
                    $conn,
                    $remark5
                );


            $remarkCkkDb =
                qouEsc(
                    $conn,
                    $remark_ckk
                );


            $warantyCkkDb =
                qouEsc(
                    $conn,
                    $waranty_ckk
                );


            $typeHeadDb =
                qouEsc(
                    $conn,
                    $type_head
                );


            $speckDb =
                qouEsc(
                    $conn,
                    $speck
                );


            $catalogDb =
                qouEsc(
                    $conn,
                    $catalog
                );


            $pictureDb =
                qouEsc(
                    $conn,
                    $picture
                );


            /*
            |--------------------------------------------------------------------------
            | UPDATE MAIN
            |--------------------------------------------------------------------------
            */

            $sqlUpdate = "
                UPDATE qou__main
                SET
                    cus_name = '{$cusNameDb}',
                    description = '{$descriptionDb}',
                    payment_dead = '{$paymentDb}',
                    payment_dead_other_wrap = '{$paymentOtherDb}',
                    set_price = '{$setPriceDb}',
                    delivery_dead = '{$deliveryDb}',
                    delivery_date = '{$deliveryDateDb}',
                    waranty = '{$warantyDb}',
                    cusmail_name = '{$cusmailDb}',
                    email = '{$emailDb}',
                    iv_date = '{$ivDateDb}',
                    iv_no = '{$ivNoDb}',
                    remark_ckk = '{$remarkCkkDb}',
                    waranty_ckk = '{$warantyCkkDb}',
                    remark1 = '{$remark1Db}',
                    remark2 = '{$remark2Db}',
                    remark3 = '{$remark3Db}',
                    remark4 = '{$remark4Db}',
                    remark5 = '{$remark5Db}',
                    type_head = '{$typeHeadDb}',
                    speck = '{$speckDb}',
                    catalog = '{$catalogDb}',
                    picture = '{$pictureDb}'
                WHERE ref_id = '{$refDb}'
            ";


            if (
                !mysqli_query(
                    $conn,
                    $sqlUpdate
                )
            ) {

                throw new Exception(
                    'Update qou__main : ' .
                    mysqli_error($conn)
                );
            }


            /*
            |--------------------------------------------------------------------------
            | ลบสินค้าเดิม
            | แล้วบันทึกสินค้าที่มากับ Form ใหม่ทั้งหมด
            |--------------------------------------------------------------------------
            */

            $sqlDeleteProduct = "
                DELETE FROM qou__sbmain
                WHERE ref_idd = '{$refDb}'
            ";


            if (
                !mysqli_query(
                    $conn,
                    $sqlDeleteProduct
                )
            ) {

                throw new Exception(
                    'Delete Products : ' .
                    mysqli_error($conn)
                );
            }

        } else {

            /*
            |--------------------------------------------------------------------------
            | ADD MODE
            |--------------------------------------------------------------------------
            */

            $yearMonth =
                substr(
                    date('Y') + 543,
                    -2
                ) .
                date('m');


            if ($type_doc === '2') {

                $ref_id =
                    getNextQuotationRef(
                        $conn,
                        '2',
                        'NBM',
                        $yearMonth
                    );

            } else {

                $ref_id =
                    getNextQuotationRef(
                        $conn,
                        '1',
                        'AWL',
                        $yearMonth
                    );
            }


            /*
            |--------------------------------------------------------------------------
            | Upload
            |--------------------------------------------------------------------------
            */

            $speck =
                qouUploadFile(
                    'speck'
                );


            $catalog =
                qouUploadFile(
                    'catalog'
                );


            $picture =
                qouUploadFile(
                    'picture'
                );


            /*
            |--------------------------------------------------------------------------
            | Escape
            |--------------------------------------------------------------------------
            */

            $refDb =
                qouEsc(
                    $conn,
                    $ref_id
                );


            $registerDateDb =
                qouEsc(
                    $conn,
                    date('Y-m-d')
                );


            $typeDocDb =
                qouEsc(
                    $conn,
                    $type_doc
                );


            $cusNameDb =
                qouEsc(
                    $conn,
                    $cus_name
                );


            $descriptionDb =
                qouEsc(
                    $conn,
                    $description
                );


            $paymentDb =
                qouEsc(
                    $conn,
                    $payment_dead
                );


            $paymentOtherDb =
                qouEsc(
                    $conn,
                    $payment_dead_other_wrap
                );


            $setPriceDb =
                qouEsc(
                    $conn,
                    $set_price
                );


            $deliveryDb =
                qouEsc(
                    $conn,
                    $delivery_dead
                );


            $deliveryDateDb =
                qouEsc(
                    $conn,
                    $delivery_date
                );


            $warantyDb =
                qouEsc(
                    $conn,
                    $waranty
                );


            $cusmailDb =
                qouEsc(
                    $conn,
                    $cusmail_name
                );


            $emailDb =
                qouEsc(
                    $conn,
                    $email
                );


            $ivDateDb =
                qouEsc(
                    $conn,
                    $iv_date
                );


            $ivNoDb =
                qouEsc(
                    $conn,
                    $iv_no
                );


            $remark1Db =
                qouEsc(
                    $conn,
                    $remark1
                );


            $remark2Db =
                qouEsc(
                    $conn,
                    $remark2
                );


            $remark3Db =
                qouEsc(
                    $conn,
                    $remark3
                );


            $remark4Db =
                qouEsc(
                    $conn,
                    $remark4
                );


            $remark5Db =
                qouEsc(
                    $conn,
                    $remark5
                );


            $remarkCkkDb =
                qouEsc(
                    $conn,
                    $remark_ckk
                );


            $warantyCkkDb =
                qouEsc(
                    $conn,
                    $waranty_ckk
                );


            $typeHeadDb =
                qouEsc(
                    $conn,
                    $type_head
                );


            $addByDb =
                qouEsc(
                    $conn,
                    $add_by
                );


            $addDateDb =
                qouEsc(
                    $conn,
                    $add_date
                );


            $speckDb =
                qouEsc(
                    $conn,
                    $speck
                );


            $catalogDb =
                qouEsc(
                    $conn,
                    $catalog
                );


            $pictureDb =
                qouEsc(
                    $conn,
                    $picture
                );


            /*
            |--------------------------------------------------------------------------
            | INSERT MAIN
            |--------------------------------------------------------------------------
            */

            $sqlInsert = "
                INSERT INTO qou__main
                (
                    ref_id,
                    register_date,
                    type_doc,
                    cus_name,
                    description,
                    payment_dead,
                    set_price,
                    delivery_dead,
                    waranty,
                    cusmail_name,
                    email,
                    remark1,
                    remark2,
                    remark3,
                    remark4,
                    remark5,
                    iv_date,
                    iv_no,
                    add_by,
                    add_date,
                    speck,
                    catalog,
                    picture,
                    remark_ckk,
                    waranty_ckk,
                    type_head,
                    delivery_date,
                    payment_dead_other_wrap
                )
                VALUES
                (
                    '{$refDb}',
                    '{$registerDateDb}',
                    '{$typeDocDb}',
                    '{$cusNameDb}',
                    '{$descriptionDb}',
                    '{$paymentDb}',
                    '{$setPriceDb}',
                    '{$deliveryDb}',
                    '{$warantyDb}',
                    '{$cusmailDb}',
                    '{$emailDb}',
                    '{$remark1Db}',
                    '{$remark2Db}',
                    '{$remark3Db}',
                    '{$remark4Db}',
                    '{$remark5Db}',
                    '{$ivDateDb}',
                    '{$ivNoDb}',
                    '{$addByDb}',
                    '{$addDateDb}',
                    '{$speckDb}',
                    '{$catalogDb}',
                    '{$pictureDb}',
                    '{$remarkCkkDb}',
                    '{$warantyCkkDb}',
                    '{$typeHeadDb}',
                    '{$deliveryDateDb}',
                    '{$paymentOtherDb}'
                )
            ";


            if (
                !mysqli_query(
                    $conn,
                    $sqlInsert
                )
            ) {

                throw new Exception(
                    'Insert qou__main : ' .
                    mysqli_error($conn)
                );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | INSERT PRODUCTS
        |
        | product_id1 ... product_id15
        |--------------------------------------------------------------------------
        */

        for (
            $i = 1;
            $i <= 15;
            $i++
        ) {

            $product_id =
                qouPost(
                    'product_id' . $i
                );


            if ($product_id === '') {
                continue;
            }


            $sale_count =
                qouMoney(
                    isset(
                        $_POST[
                            'sale_count' . $i
                        ]
                    )
                        ? $_POST[
                            'sale_count' . $i
                        ]
                        : 0
                );


            $product_price =
                qouMoney(
                    isset(
                        $_POST[
                            'product_price' . $i
                        ]
                    )
                        ? $_POST[
                            'product_price' . $i
                        ]
                        : 0
                );


            $discount_unit =
                qouMoney(
                    isset(
                        $_POST[
                            'discount_unit' . $i
                        ]
                    )
                        ? $_POST[
                            'discount_unit' . $i
                        ]
                        : 0
                );


            $sum_amount =
                (
                    $sale_count *
                    $product_price
                )
                -
                (
                    $sale_count *
                    $discount_unit
                );


            $productIdDb =
                qouEsc(
                    $conn,
                    $product_id
                );


            $saleCountDb =
                qouEsc(
                    $conn,
                    $sale_count
                );


            $priceDb =
                qouEsc(
                    $conn,
                    $product_price
                );


            $discountDb =
                qouEsc(
                    $conn,
                    $discount_unit
                );


            $amountDb =
                qouEsc(
                    $conn,
                    $sum_amount
                );


            $refDb =
                qouEsc(
                    $conn,
                    $ref_id
                );


            $sqlProduct = "
                INSERT INTO qou__sbmain
                (
                    ref_idd,
                    count,
                    price,
                    amount,
                    discount,
                    product_id,
                    product_code
                )
                VALUES
                (
                    '{$refDb}',
                    '{$saleCountDb}',
                    '{$priceDb}',
                    '{$amountDb}',
                    '{$discountDb}',
                    '{$productIdDb}',
                    '{$productIdDb}'
                )
            ";


            if (
                !mysqli_query(
                    $conn,
                    $sqlProduct
                )
            ) {

                throw new Exception(
                    'บันทึกรายการสินค้าแถวที่ ' .
                    $i .
                    ' : ' .
                    mysqli_error($conn)
                );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Submit to SUP Approval
        |--------------------------------------------------------------------------
        */

        if ($submitAction === 'submit_sup') {

            $refDb = qouEsc($conn, $ref_id);
            $sendSupNameDb = qouEsc($conn, $add_by);
            $sendSupDateDb = qouEsc($conn, $add_date);

            $sqlSendSup = "
                UPDATE qou__main
                SET
                    send_sup = '1',
                    status_doc = 'Request',
                    send_supname = '{$sendSupNameDb}',
                    send_supdate = '{$sendSupDateDb}'
                WHERE ref_id = '{$refDb}'
            ";

            if (!mysqli_query($conn, $sqlSendSup)) {
                throw new Exception(
                    'ส่งเอกสารรอ SUP อนุมัติไม่สำเร็จ : ' .
                    mysqli_error($conn)
                );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Commit
        |--------------------------------------------------------------------------
        */

        mysqli_commit(
            $conn
        );


        $goRef =
            urlencode(
                $ref_id
            );


        $successMessage = ($submitAction === 'submit_sup')
            ? 'ส่งเอกสารรอ SUP อนุมัติเรียบร้อยแล้ว'
            : 'บันทึกข้อมูลเรียบร้อยแล้ว';

        $successMessageJs = json_encode(
            $successMessage,
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );

        echo "
        <script>
            alert({$successMessageJs});
            window.location =
                'register_qou.php?ref_id={$goRef}';
        </script>
        ";

        exit;


    } catch (Exception $e) {

        mysqli_rollback(
            $conn
        );


        $error =
            qouH(
                $e->getMessage()
            );


        echo "
        <div style=\"
            max-width:900px;
            margin:40px auto;
            padding:20px;
            background:#fff;
            border:1px solid #ddd;
            border-radius:10px;
        \">

            <h3 style=\"color:#c62828;\">
                ไม่สามารถบันทึกข้อมูลได้
            </h3>

            <div>
                {$error}
            </div>

            <br>

            <button
                type=\"button\"
                onclick=\"history.back();\"
            >
                กลับ
            </button>

        </div>
        ";

        exit;
    }
}


/*
|--------------------------------------------------------------------------
| LOAD EDIT DATA
|--------------------------------------------------------------------------
*/

if ($editMode || $copyMode) {

    $editRefDb =
        qouEsc(
            $conn,
            $loadRefId
        );


    $sqlEdit = "
        SELECT *
        FROM qou__main
        WHERE ref_id = '{$editRefDb}'
        LIMIT 1
    ";


    $queryEdit =
        mysqli_query(
            $conn,
            $sqlEdit
        );


    if (!$queryEdit) {

        die(
            'Error Query : ' .
            mysqli_error($conn)
        );
    }


    if (
        mysqli_num_rows(
            $queryEdit
        ) == 0
    ) {

        die(
            'ไม่พบใบเสนอราคา ' .
            qouH($loadRefId)
        );
    }


    $qouData =
        mysqli_fetch_assoc(
            $queryEdit
        );


    /*
    |--------------------------------------------------------------------------
    | COPY MODE
    | โหลดข้อมูลเดิมมาเป็นต้นแบบ แต่ถือเป็นเอกสารใหม่
    |--------------------------------------------------------------------------
    */
    if ($copyMode) {
        $qouData['ref_id'] = '';
        $qouData['register_date'] = date('Y-m-d');
        $qouData['status_doc'] = '';
        $qouData['send_sup'] = '0';
        $qouData['send_supname'] = '';
        $qouData['send_supdate'] = '';
    }


    /*
    |--------------------------------------------------------------------------
    | โหลดสินค้าเดิม
    |--------------------------------------------------------------------------
    */

    $sqlProducts = "
        SELECT *
        FROM qou__sbmain
        WHERE ref_idd = '{$editRefDb}'
        ORDER BY id
        LIMIT 15
    ";


    $queryProducts =
        mysqli_query(
            $conn,
            $sqlProducts
        );


    if (!$queryProducts) {

        die(
            'Error Products : ' .
            mysqli_error($conn)
        );
    }


    $productIndex = 1;


    while (
        $productRow =
            mysqli_fetch_assoc(
                $queryProducts
            )
    ) {

        ${'product_id' . $productIndex}
            =
            isset(
                $productRow['product_id']
            )
                ? $productRow['product_id']
                : '';


        ${'sale_count' . $productIndex}
            =
            isset(
                $productRow['count']
            )
                ? $productRow['count']
                : '';


        ${'product_price' . $productIndex}
            =
            isset(
                $productRow['price']
            )
                ? $productRow['price']
                : '';


        ${'discount_unit' . $productIndex}
            =
            isset(
                $productRow['discount']
            )
                ? $productRow['discount']
                : '';


        $productIndex++;
    }
}


/*
|--------------------------------------------------------------------------
| Reference Preview
|--------------------------------------------------------------------------
*/

$yearMonth =
    substr(
        date('Y') + 543,
        -2
    ) .
    date('m');


$quotationRefAWL =
    getNextQuotationRef(
        $conn,
        '1',
        'AWL',
        $yearMonth
    );


$quotationRefNBM =
    getNextQuotationRef(
        $conn,
        '2',
        'NBM',
        $yearMonth
    );


if ($editMode) {

    $quotationRef =
        $qouData['ref_id'];

} elseif ($copyMode && isset($qouData['type_doc']) && (string)$qouData['type_doc'] === '2') {

    $quotationRef =
        $quotationRefNBM;

} else {

    $quotationRef =
        $quotationRefAWL;
}

/*
|--------------------------------------------------------------------------
| Latest status reason banner
| แสดงเฉพาะ Returned / Cancelled / Rejected
| และดึง log ล่าสุดของสถานะปัจจุบันมาแสดง 1 รายการ
|--------------------------------------------------------------------------
*/
$latestStatusLog = null;
$showStatusReasonBanner = false;
$currentDocStatusForBanner = '';

if ($editMode && isset($qouData['status_doc'])) {
    $currentDocStatusForBanner = trim((string)$qouData['status_doc']);
    $statusBannerNormalized = strtolower($currentDocStatusForBanner);

    if (in_array($statusBannerNormalized, array('returned', 'cancelled', 'rejected'), true)) {
        $statusDb = qouEsc($conn, $currentDocStatusForBanner);
        $refDbBanner = qouEsc($conn, $qouData['ref_id']);

        $sqlLatestStatusLog = "
            SELECT id, ref_id, status_doc, reason, user_id, user_name, created_at
            FROM tb_document_status_log
            WHERE ref_id = '{$refDbBanner}'
              AND status_doc = '{$statusDb}'
            ORDER BY created_at DESC, id DESC
            LIMIT 1
        ";

        $queryLatestStatusLog = mysqli_query($conn, $sqlLatestStatusLog);

        if ($queryLatestStatusLog) {
            $latestStatusLog = mysqli_fetch_assoc($queryLatestStatusLog);
            if ($latestStatusLog) {
                $showStatusReasonBanner = true;
            }
        }
    }
}

?>

<link
    rel="stylesheet"
    href="css/autocomplete.css"
    type="text/css"
>

<script
    type="text/javascript"
    src="js/autocomplete.js"
></script>

<script
    type="text/javascript"
    src="js/jquery.min.js"
></script>

<link
    rel="stylesheet"
    href="css/so-core.css?v=<?php
        echo file_exists(
            __DIR__ .
            '/css/so-core.css'
        )
            ? filemtime(
                __DIR__ .
                '/css/so-core.css'
            )
            : time();
    ?>"
>


<style>

.register-qou-main {
    max-width: 1200px;
    margin: 0 auto;
    padding-bottom: 40px;
    box-sizing: border-box;
}

.qou-header-container {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    margin-bottom: 24px;
}

.qou-header-left {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.qou-title {
    margin: 0;
    font-family: 'Prompt', sans-serif;
    font-size: 28px;
    font-weight: 600;
    color: #612989;
}

.qou-ref-info {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}

.qou-ref-label {
    font-family: 'Prompt', sans-serif;
    font-size: 14px;
    color: #888;
}

.qou-ref-value {
    font-family: 'Prompt', sans-serif;
    font-size: 16px;
    font-weight: 500;
    color: #612989;
}

.qou-edit-badge {
    display: inline-flex;
    align-items: center;
    padding: 4px 10px;
    border-radius: 15px;
    background: #f3eaf8;
    color: #612989;
    font-family: 'Prompt', sans-serif;
    font-size: 12px;
}

.qou-card {
    background: #ffffff;
    border: 1px solid #eeeeee;
    border-radius: 16px;
    padding: 24px;
    margin-bottom: 20px;
    box-shadow:
        0 3px 12px
        rgba(0, 0, 0, 0.03);
    box-sizing: border-box;
}

.qou-section-title-container {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 4px;
}

.qou-section-title {
    margin: 0;
    font-family: 'Prompt', sans-serif;
    font-size: 19px;
    font-weight: 500;
    color: #292929;
}

.qou-section-icon {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    background: #f4edf9;
    color: #612989;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.qou-divider {
    border: 0;
    border-top: 1px solid #eeeeee;
    margin: 18px 0 24px;
}

.qou-grid-2 {
    display: grid;
    grid-template-columns:
        repeat(
            2,
            minmax(0, 1fr)
        );
    gap: 20px 24px;
}

.qou-grid-3 {
    display: grid;
    grid-template-columns:
        repeat(
            3,
            minmax(0, 1fr)
        );
    gap: 20px 24px;
}

.qou-full {
    grid-column: 1 / -1;
}

.qou-field-group {
    min-width: 0;
}

.qou-label {
    display: block;
    margin-bottom: 8px;
    font-family: 'Prompt', sans-serif;
    font-size: 14px;
    color: #404040;
}

.qou-required {
    color: #dc3545;
}

.qou-input,
.qou-select,
.qou-textarea {
    width: 100%;
    min-height: 42px;
    padding: 9px 12px;
    border: 1px solid #dddddd;
    border-radius: 8px;
    background: #ffffff;
    color: #333333;
    font-family: 'Prompt', sans-serif;
    font-size: 14px;
    box-sizing: border-box;
    outline: none;
}

.qou-input:focus,
.qou-select:focus,
.qou-textarea:focus {
    border-color: #8d54b4;
    box-shadow:
        0 0 0 3px
        rgba(97, 41, 137, 0.08);
}

.qou-textarea {
    resize: vertical;
    min-height: 90px;
}

.qou-document-summary-value {
    color: #333;
    font-family: 'Prompt', sans-serif;
    font-size: 16px;
    font-weight: 500;
}

.qou-radio-group {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}

.so-select-wrapper {
    width: 100%;
}

.so-select {
    width: 100%;
}

.qou-conditional-field {
    margin-top: 12px;
}

.qou-upload-grid {
    display: grid;
    grid-template-columns:
        repeat(
            3,
            minmax(0, 1fr)
        );
    gap: 16px;
}

.qou-upload-box {
    border:
        1px dashed
        #cfcfcf;
    border-radius: 12px;
    padding: 18px;
    background: #fafafa;
}

.qou-upload-icon {
    width: 38px;
    height: 38px;
    background: #f3eaf8;
    color: #612989;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 10px;
}

.qou-upload-title {
    font-family: 'Prompt', sans-serif;
    font-size: 14px;
    font-weight: 500;
    margin-bottom: 4px;
}

.qou-upload-description {
    font-family: 'Prompt', sans-serif;
    font-size: 12px;
    color: #999;
    margin-bottom: 12px;
}

.qou-file-old {
    margin-top: 8px;
    font-family: 'Prompt', sans-serif;
    font-size: 12px;
    color: #666;
}

.qou-file-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    margin-left: 5px;
    color: #612989;
    font-family: 'Prompt', sans-serif;
    font-size: 12px;
    font-weight: 500;
    text-decoration: none;
    word-break: break-all;
}

.qou-file-link:hover {
    color: #8d54b4;
    text-decoration: underline;
}

.qou-file-link i {
    font-size: 14px;
}

.qou-file-input {
    width: 100%;
}

.qou-remark-enable {
    display: flex;
    align-items: center;
    gap: 9px;
    margin-bottom: 20px;
    font-family: 'Prompt', sans-serif;
    font-size: 14px;
}

.qou-remark-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.qou-remark-row {
    display: grid;
    grid-template-columns:
        32px 1fr;
    gap: 8px;
    align-items: start;
}

.qou-remark-number {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: #f3eaf8;
    color: #612989;
    display: flex;
    justify-content: center;
    align-items: center;
    font-family: 'Prompt', sans-serif;
    font-size: 13px;
    margin-top: 5px;
}

.qou-product-wrap {
    overflow-x: auto;
}

.qou-sticky-actions {
    width: 100%;
    background: #ffffff;
    padding: 16px 24px;
    border-top:
        1px solid
        #ebebeb;
    box-shadow:
        0 -4px 12px
        rgba(0, 0, 0, 0.05);
    box-sizing: border-box;
    position: sticky;
    bottom: 0;
    z-index: 50;
    margin-top: 24px;
}

.qou-sticky-actions-inner {
    max-width: 1200px;
    width: 100%;
    margin: 0 auto;
    display: flex;
    justify-content: flex-end;
    gap: 12px;
}


.qou-header-right {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    margin-top: 20px;
}

.qou-btn-preview {
    height: 44px;
    padding: 0 24px;
    border: 1px solid #ded7e5;
    border-radius: 24px;
    background: #ffffff;
    color: #612989;
    font-family: 'Prompt', sans-serif;
    font-size: 15px;
    font-weight: 500;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 9px;
    text-decoration: none;
    box-sizing: border-box;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
    transition: all 0.2s ease;
}

.qou-btn-preview i {
    font-size: 18px;
}

.qou-btn-preview:hover {
    color: #612989;
    border-color: #612989;
    background: #f7f1fa;
    text-decoration: none;
}

.qou-btn-submit {
    height: 42px;
    padding: 0 30px;
    border:
        1px solid
        #612989;
    border-radius: 24px;
    background: #612989;
    color: #ffffff;
    font-family: 'Prompt', sans-serif;
    font-size: 15px;
    cursor: pointer;
}


.qou-btn-submit-sup {
    background: #2e7d32;
    border-color: #2e7d32;
}

.qou-btn-submit-sup:hover {
    background: #256628;
    border-color: #256628;
}

.qou-btn-cancel {
    height: 42px;
    padding: 0 26px;
    border:
        1px solid
        #dddddd;
    border-radius: 24px;
    background: #ffffff;
    color: #555555;
    font-family: 'Prompt', sans-serif;
    font-size: 15px;
    cursor: pointer;
}

.qou-btn-cancel:disabled {
    opacity: .45;
    cursor: not-allowed;
}

.qou-cancel-modal {
    position: fixed;
    inset: 0;
    z-index: 99999;
    background: rgba(0,0,0,.35);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    box-sizing: border-box;
}

.qou-cancel-modal-box {
    width: min(520px, 100%);
    background: #fff;
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 18px 50px rgba(0,0,0,.18);
    font-family: 'Prompt', sans-serif;
}

.qou-cancel-modal-box h3 {
    margin: 0 0 8px;
    color: #292929;
    font-size: 20px;
}

.qou-cancel-modal-box p {
    margin: 0 0 14px;
    color: #777;
    font-size: 14px;
}

.qou-cancel-modal-actions {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 16px;
}

.qou-btn-confirm-cancel {
    height: 42px;
    padding: 0 24px;
    border: 0;
    border-radius: 24px;
    background: #dc3545;
    color: #fff;
    font-family: 'Prompt', sans-serif;
    font-size: 14px;
    cursor: pointer;
}

.qou-sup-menu-wrap {
    position: relative;
}

.qou-btn-more {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    border: 1px solid #e4dfea;
    background: #fff;
    color: #612989;
    cursor: pointer;
    font-size: 22px;
    line-height: 1;
}

.qou-sup-menu {
    display: none;
    position: absolute;
    right: 0;
    bottom: 50px;
    min-width: 220px;
    background: #fff;
    border: 1px solid #eee8f2;
    border-radius: 12px;
    box-shadow: 0 12px 30px rgba(0,0,0,.12);
    padding: 8px;
    z-index: 1000;
}

.qou-sup-menu.open {
    display: block;
}

.qou-sup-menu button {
    width: 100%;
    border: 0;
    background: transparent;
    padding: 11px 12px;
    border-radius: 8px;
    text-align: left;
    cursor: pointer;
    font-family: 'Prompt', sans-serif;
    font-size: 14px;
}

.qou-sup-menu button:hover {
    background: #f8f5fa;
}

.qou-sup-return {
    color: #ef6c00;
}

.qou-sup-reject {
    color: #d32f2f;
}

.qou-btn-approve {
    height: 42px;
    padding: 0 28px;
    border-radius: 24px;
    border: 1px solid #a7ddbb;
    background: #e7f8ed;
    color: #138a45;
    font-family: 'Prompt', sans-serif;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
}

.qou-btn-approve:hover {
    background: #d9f3e2;
}

@media (max-width: 900px) {

    .qou-grid-3 {
        grid-template-columns:
            repeat(
                2,
                minmax(0, 1fr)
            );
    }

    .qou-upload-grid {
        grid-template-columns: 1fr;
    }
}

.qou-status-reason-banner {
    margin: 0 0 20px;
    border-radius: 10px;
    padding: 14px 16px;
    font-family: 'Prompt', sans-serif;
    position: relative;
    box-sizing: border-box;
}

.qou-status-reason-banner .qou-status-reason-title {
    font-size: 14px;
    font-weight: 500;
    margin-bottom: 6px;
}

.qou-status-reason-banner .qou-status-reason-text {
    font-size: 14px;
    color: #3b3b3b;
    line-height: 1.55;
    white-space: pre-wrap;
    word-break: break-word;
}

.qou-status-reason-banner.returned {
    background: #ffe2c2;
    color: #ef6c00;
}

.qou-status-reason-banner.cancelled {
    background: #fde2e2;
    color: #c62828;
}

.qou-status-reason-banner.rejected {
    background: #fde2e2;
    color: #d32f2f;
}

.qou-status-reason-close {
    position: absolute;
    top: 10px;
    right: 12px;
    border: 0;
    background: transparent;
    color: inherit;
    font-size: 16px;
    cursor: pointer;
    padding: 0;
    line-height: 1;
}

@media (max-width: 650px) {

    .register-qou-main {
        padding-left: 8px;
        padding-right: 8px;
    }

    .qou-header-container {
        flex-direction: column;
        align-items: flex-start;
    }

    .qou-title {
        font-size: 23px;
    }

    .qou-card {
        padding: 18px 15px;
    }

    .qou-grid-2,
    .qou-grid-3 {
        grid-template-columns: 1fr;
    }

    .qou-sticky-actions {
        padding: 12px;
    }

    .qou-sticky-actions-inner {
        display: grid;
        grid-template-columns:
            1fr 1fr;
    }

    .qou-btn-submit,
    .qou-btn-submit-sup,
    .qou-btn-cancel {
        width: 100%;
    }

    .qou-header-right {
        width: 100%;
        margin-top: 0;
        justify-content: flex-start;
    }

    .qou-btn-preview {
        width: auto;
    }
}

</style>


<div
    class="w3-container register-qou-main"
>

    <div class="qou-header-container">

        <div class="qou-header-left">

            <br>

            <h1 class="qou-title">
                ใบเสนอราคา
            </h1>

            <div class="qou-ref-info">

                <span class="qou-ref-label">
                    เลขที่อ้างอิง
                </span>

                <span
                    class="qou-ref-value"
                    id="quotation_ref_display"
                >
                    <?php
                    echo qouH(
                        $quotationRef
                    );
                    ?>
                </span>


                <?php
                if ($editMode) {
                ?>

                    <span class="qou-edit-badge">
                        
                    </span>

                <?php
                } elseif ($copyMode) {
                ?>

                    <span class="qou-edit-badge">
                       
                    </span>

                <?php
                }
                ?>

            </div>

        </div>

        <?php if ($editMode && !empty($qouData['ref_id'])) { ?>
        <div class="qou-header-right">
            <a
                class="qou-btn-preview"
                href="formnb_qou.php?ref_id=<?php echo urlencode($qouData['ref_id']); ?>"
                target="_blank"
                rel="noopener"
                title="Preview ใบเสนอราคา"
            >
                <i class="far fa-file-alt"></i>
                Preview
            </a>
        </div>
        <?php } ?>

    </div>

    <?php if ($showStatusReasonBanner && $latestStatusLog) {
        $bannerClass = strtolower(trim((string)$latestStatusLog['status_doc']));
        $bannerTitle = '';

        if ($bannerClass === 'returned') {
            $bannerTitle = 'เหตุผลในการส่งกลับ';
        } elseif ($bannerClass === 'cancelled') {
            $bannerTitle = 'เหตุผลในการยกเลิก';
        } elseif ($bannerClass === 'rejected') {
            $bannerTitle = 'เหตุผลที่ไม่อนุมัติ';
        }
    ?>
        <div class="qou-status-reason-banner <?php echo qouH($bannerClass); ?>" id="qouStatusReasonBanner">
            <button
                type="button"
                class="qou-status-reason-close"
                onclick="document.getElementById('qouStatusReasonBanner').style.display='none';"
                aria-label="ปิด"
            >&times;</button>

            <div class="qou-status-reason-title">
                <?php echo qouH($bannerTitle); ?>
            </div>

            <div class="qou-status-reason-text">
                <?php echo qouH(isset($latestStatusLog['reason']) ? $latestStatusLog['reason'] : ''); ?>
            </div>
        </div>
    <?php } ?>


    <form
        action="register_qou.php<?php
            echo $editMode
                ? '?ref_id=' . urlencode($editRefId)
                : '';
        ?>"
        method="post"
        name="frmMain"
        id="frmMain"
        enctype="multipart/form-data"
        onsubmit="return qouLockSubmit(this);"
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
            name="ref_id"
            value="<?php
                echo $editMode
                    ? qouH(
                        $qouData['ref_id']
                    )
                    : '';
            ?>"
        >


        <input
            type="hidden"
            name="cancel_reason"
            id="cancel_reason"
            value=""
        >


        <input
            type="hidden"
            name="sup_action_reason"
            id="sup_action_reason"
            value=""
        >


        <!-- ===============================
             ข้อมูลเอกสาร
        ================================ -->

        <div class="qou-card">

            <div
                class="qou-section-title-container"
            >

                <div class="qou-section-icon">
                    <i class="far fa-file-alt"></i>
                </div>

                <h2 class="qou-section-title">
                    ข้อมูลเอกสาร
                </h2>

            </div>

            <hr class="qou-divider">


            <div class="qou-grid-3">


                <div class="qou-field-group">

                    <label class="qou-label">
                        วันที่
                    </label>

                    <div
                        class="qou-document-summary-value"
                    >
                        <?php

                        $showDate =
                            $editMode &&
                            !empty(
                                $qouData[
                                    'register_date'
                                ]
                            )
                                ? $qouData[
                                    'register_date'
                                ]
                                : date('Y-m-d');


                        if (
                            function_exists(
                                'DateThai'
                            )
                        ) {

                            echo DateThai(
                                date(
                                    'd-m-Y',
                                    strtotime(
                                        $showDate
                                    )
                                )
                            );

                        } else {

                            echo date(
                                'd-m-Y',
                                strtotime(
                                    $showDate
                                )
                            );
                        }

                        ?>
                    </div>

                </div>


                <!-- บริษัท -->

                <div class="qou-field-group">

                    <label class="qou-label">

                        บริษัท

                        <span class="qou-required">
                            *
                        </span>

                    </label>


                    <div class="so-select-wrapper">

                        <select
                            class="so-select"
                            name="<?php
                                echo $editMode
                                    ? 'type_doc_display'
                                    : 'type_doc';
                            ?>"
                            id="company_select"
                            required
                            <?php
                                echo $editMode
                                    ? 'disabled'
                                    : '';
                            ?>
                        >

                            <option
                                value="1"
                                <?php
                                echo
                                    $qouData[
                                        'type_doc'
                                    ] == '1'
                                    ? 'selected'
                                    : '';
                                ?>
                            >
                                AWL
                            </option>

                            <option
                                value="2"
                                <?php
                                echo
                                    $qouData[
                                        'type_doc'
                                    ] == '2'
                                    ? 'selected'
                                    : '';
                                ?>
                            >
                                NBM
                            </option>

                        </select>


                        <?php
                        if ($editMode) {
                        ?>

                            <input
                                type="hidden"
                                name="type_doc"
                                value="<?php
                                    echo qouH(
                                        $qouData[
                                            'type_doc'
                                        ]
                                    );
                                ?>"
                            >

                        <?php
                        }
                        ?>

                    </div>

                </div>


                <!-- ประเภท -->

                <div class="qou-field-group">

                    <label class="qou-label">

                        ประเภท

                        <span class="qou-required">
                            *
                        </span>

                    </label>


                    <select
                        class="so-select"
                        name="type_head"
                        id="type_head"
                        required
                    >

                        <option
                            value="1"
                            <?php
                            echo
                                $qouData[
                                    'type_head'
                                ] == '1'
                                ? 'selected'
                                : '';
                            ?>
                        >
                            สินค้าขาย
                        </option>

                        <option
                            value="2"
                            <?php
                            echo
                                $qouData[
                                    'type_head'
                                ] == '2'
                                ? 'selected'
                                : '';
                            ?>
                        >
                            สินค้าเช่า
                        </option>

                    </select>

                </div>

            </div>


            <input
                name="iv_date"
                id="iv_date"
                type="hidden"
                value="<?php
                    echo qouH(
                        $qouData[
                            'iv_date'
                        ]
                    );
                ?>"
            >

        </div>


        <!-- ===============================
             ผู้รับใบเสนอราคา
        ================================ -->

        <div class="qou-card">

            <div
                class="qou-section-title-container"
            >

                <div class="qou-section-icon">
                    <i class="far fa-user"></i>
                </div>

                <h2 class="qou-section-title">
                    ข้อมูลผู้รับใบเสนอราคา
                </h2>

            </div>

            <hr class="qou-divider">


            <div class="qou-grid-2">


                <div class="qou-field-group">

                    <label
                        class="qou-label"
                        for="cus_name"
                    >
                        เรียน
                    </label>

                    <input
                        type="text"
                        name="cus_name"
                        id="cus_name"
                        class="qou-input"
                        value="<?php
                            echo qouH(
                                $qouData[
                                    'cus_name'
                                ]
                            );
                        ?>"
                        placeholder="ระบุชื่อผู้รับใบเสนอราคา"
                    >

                </div>


                <div class="qou-field-group">

                    <label
                        class="qou-label"
                        for="iv_no"
                    >
                        เบอร์โทรพนักงาน
                    </label>

                    <input
                        name="iv_no"
                        id="iv_no"
                        class="qou-input"
                        type="text"
                        value="<?php
                            echo qouH(
                                $qouData[
                                    'iv_no'
                                ]
                            );
                        ?>"
                        placeholder="ระบุเบอร์โทรพนักงาน"
                    >

                </div>


                <div class="qou-field-group">

                    <label
                        class="qou-label"
                        for="cusmail_name"
                    >
                        E-mail to
                    </label>

                    <input
                        name="cusmail_name"
                        id="cusmail_name"
                        class="qou-input"
                        value="<?php
                            echo qouH(
                                $qouData[
                                    'cusmail_name'
                                ]
                            );
                        ?>"
                        placeholder="ชื่อผู้รับ"
                        type="text"
                    >

                </div>


                <div class="qou-field-group">

                    <label
                        class="qou-label"
                        for="email"
                    >
                        E-mail Address
                    </label>

                    <input
                        name="email"
                        id="email"
                        class="qou-input"
                        value="<?php
                            echo qouH(
                                $qouData[
                                    'email'
                                ]
                            );
                        ?>"
                        placeholder="example@email.com"
                        type="text"
                    >

                </div>


                <div
                    class="qou-field-group qou-full"
                >

                    <label
                        class="qou-label"
                        for="description"
                    >
                        หมายเหตุ
                    </label>

                    <textarea
                        name="description"
                        id="description"
                        class="qou-textarea"
                        rows="3"
                        placeholder="ระบุรายละเอียดเพิ่มเติม..."
                    ><?php
                        echo qouH(
                            $qouData[
                                'description'
                            ]
                        );
                    ?></textarea>

                </div>

            </div>

        </div>


        <!-- ===============================
             เงื่อนไข
        ================================ -->

        <div class="qou-card">

            <div
                class="qou-section-title-container"
            >

                <div class="qou-section-icon">
                    <i class="far fa-calendar-alt"></i>
                </div>

                <h2 class="qou-section-title">
                    เงื่อนไขการเสนอราคา
                </h2>

            </div>

            <hr class="qou-divider">


            <div class="qou-grid-2">


                <!-- PAYMENT -->

                <div class="qou-field-group">

                    <label class="qou-label">
                        กำหนดเวลาชำระเงิน
                    </label>

                    <select
                        name="payment_dead"
                        id="payment_dead"
                        class="qou-select"
                    >

                        <option value="">
                            **Please Select Item**
                        </option>

                        <?php

                        $sqlCash = "
                            SELECT *
                            FROM qou__cash
                            ORDER BY cash_id
                        ";

                        $queryCash =
                            mysqli_query(
                                $conn,
                                $sqlCash
                            );


                        if ($queryCash) {

                            while (
                                $cashRow =
                                    mysqli_fetch_assoc(
                                        $queryCash
                                    )
                            ) {

                                $cashName =
                                    $cashRow[
                                        'cash_name'
                                    ];

                        ?>

                                <option
                                    value="<?php
                                        echo qouH(
                                            $cashName
                                        );
                                    ?>"
                                    <?php
                                    echo
                                        $qouData[
                                            'payment_dead'
                                        ] ===
                                        $cashName
                                        ? 'selected'
                                        : '';
                                    ?>
                                >
                                    <?php
                                    echo qouH(
                                        $cashName
                                    );
                                    ?>
                                </option>

                        <?php

                            }
                        }

                        ?>

                    </select>


                    <div
                        id="payment_dead_other_wrap"
                        class="qou-conditional-field"
                        style="display:none;"
                    >

                        <input
                            name="payment_dead_other"
                            id="payment_dead_other"
                            class="qou-input"
                            value="<?php
                                echo qouH(
                                    $qouData[
                                        'payment_dead_other_wrap'
                                    ]
                                );
                            ?>"
                            placeholder="ระบุเงื่อนไขการชำระเงิน..."
                        >

                    </div>

                </div>


                <!-- ยืนราคา -->

                <div class="qou-field-group">

                    <label class="qou-label">
                        กำหนดยืนราคา
                    </label>

                    <input
                        name="set_price"
                        id="set_price"
                        class="qou-input"
                        type="date"
                        value="<?php
                            echo qouH(
                                $qouData[
                                    'set_price'
                                ]
                            );
                        ?>"
                    >

                </div>


                <!-- DELIVERY -->

                <div class="qou-field-group">

                    <label class="qou-label">
                        กำหนดส่งสินค้า
                    </label>

                    <select
                        name="delivery_dead"
                        id="delivery_dead"
                        class="qou-select"
                    >

                        <option value="">
                            **Please Select Item**
                        </option>

                        <?php

                        $sqlDelivery = "
                            SELECT *
                            FROM qou__delivery
                            ORDER BY delivery_id
                        ";

                        $queryDelivery =
                            mysqli_query(
                                $conn,
                                $sqlDelivery
                            );


                        if ($queryDelivery) {

                            while (
                                $deliveryRow =
                                    mysqli_fetch_assoc(
                                        $queryDelivery
                                    )
                            ) {

                                $deliveryName =
                                    $deliveryRow[
                                        'delivery_name'
                                    ];

                        ?>

                            <option
                                value="<?php
                                    echo qouH(
                                        $deliveryName
                                    );
                                ?>"
                                <?php
                                echo
                                    $qouData[
                                        'delivery_dead'
                                    ] ===
                                    $deliveryName
                                    ? 'selected'
                                    : '';
                                ?>
                            >
                                <?php
                                echo qouH(
                                    $deliveryName
                                );
                                ?>
                            </option>

                        <?php

                            }
                        }

                        ?>

                    </select>


                    <div
                        id="delivery_dead_date_wrap"
                        class="qou-conditional-field"
                        style="display:none;"
                    >

                        <input
                            type="date"
                            name="delivery_date"
                            id="delivery_date"
                            class="qou-input"
                            value="<?php
                                echo qouH(
                                    $qouData[
                                        'delivery_date'
                                    ]
                                );
                            ?>"
                        >

                    </div>

                </div>


                <!-- WARRANTY -->

                <div class="qou-field-group">

                    <label class="qou-label">
                        รับประกันสินค้า
                    </label>

                    <select
                        name="waranty"
                        id="waranty"
                        class="qou-select"
                    >

                        <option value="">
                            **Please Select Item**
                        </option>

                        <?php

                        $sqlWarranty = "
                            SELECT *
                            FROM qou__warranty
                            ORDER BY warranty_id
                        ";

                        $queryWarranty =
                            mysqli_query(
                                $conn,
                                $sqlWarranty
                            );


                        if ($queryWarranty) {

                            while (
                                $warrantyRow =
                                    mysqli_fetch_assoc(
                                        $queryWarranty
                                    )
                            ) {

                                $warrantyName =
                                    $warrantyRow[
                                        'warranty_name'
                                    ];

                        ?>

                            <option
                                value="<?php
                                    echo qouH(
                                        $warrantyName
                                    );
                                ?>"
                                <?php
                                echo
                                    $qouData[
                                        'waranty'
                                    ] ===
                                    $warrantyName
                                    ? 'selected'
                                    : '';
                                ?>
                            >
                                <?php
                                echo qouH(
                                    $warrantyName
                                );
                                ?>
                            </option>

                        <?php

                            }
                        }

                        ?>

                    </select>

                </div>

            </div>

        </div>


        <!-- ===============================
             ไฟล์แนบ
        ================================ -->

        <div class="qou-card">

            <div
                class="qou-section-title-container"
            >

                <div class="qou-section-icon">
                    <i class="fas fa-paperclip"></i>
                </div>

                <h2 class="qou-section-title">
                    ไฟล์แนบ
                </h2>

            </div>

            <hr class="qou-divider">


            <div class="qou-upload-grid">


                <div class="qou-upload-box">

                    <div class="qou-upload-icon">
                        <i class="far fa-file-alt"></i>
                    </div>

                    <div class="qou-upload-title">
                        แนบ Spec
                    </div>

                    <input
                        name="speck"
                        id="speck"
                        class="qou-file-input"
                        type="file"
                    >

                    <?php
                    if (
                        $editMode &&
                        !empty(
                            $qouData['speck']
                        )
                    ) {
                    ?>

                        <div class="qou-file-old">
                            ไฟล์เดิม:
                            <a
                                href="qou/<?php echo rawurlencode($qouData['speck']); ?>"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="qou-file-link"
                            >
                                <i class="far fa-file-alt"></i>
                                <?php echo qouH($qouData['speck']); ?>
                            </a>
                        </div>

                    <?php
                    }
                    ?>

                </div>


                <div class="qou-upload-box">

                    <div class="qou-upload-icon">
                        <i class="far fa-file-pdf"></i>
                    </div>

                    <div class="qou-upload-title">
                        แนบ Catalog
                    </div>

                    <input
                        name="catalog"
                        id="catalog"
                        class="qou-file-input"
                        type="file"
                    >

                    <?php
                    if (
                        $editMode &&
                        !empty(
                            $qouData['catalog']
                        )
                    ) {
                    ?>

                        <div class="qou-file-old">
                            ไฟล์เดิม:
                            <a
                                href="qou/<?php echo rawurlencode($qouData['catalog']); ?>"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="qou-file-link"
                            >
                                <i class="far fa-file-pdf"></i>
                                <?php echo qouH($qouData['catalog']); ?>
                            </a>
                        </div>

                    <?php
                    }
                    ?>

                </div>


                <div class="qou-upload-box">

                    <div class="qou-upload-icon">
                        <i class="far fa-image"></i>
                    </div>

                    <div class="qou-upload-title">
                        แนบรูปภาพ
                    </div>

                    <input
                        name="picture"
                        id="picture"
                        class="qou-file-input"
                        type="file"
                    >

                    <?php
                    if (
                        $editMode &&
                        !empty(
                            $qouData['picture']
                        )
                    ) {
                    ?>

                        <div class="qou-file-old">
                            ไฟล์เดิม:
                            <a
                                href="qou/<?php echo rawurlencode($qouData['picture']); ?>"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="qou-file-link"
                            >
                                <i class="far fa-image"></i>
                                <?php echo qouH($qouData['picture']); ?>
                            </a>
                        </div>

                    <?php
                    }
                    ?>

                </div>

            </div>

        </div>


        <!-- ===============================
             หมายเหตุ
        ================================ -->

        <div class="qou-card">

            <div
                class="qou-section-title-container"
            >

                <div class="qou-section-icon">
                    <i class="far fa-comment-alt"></i>
                </div>

                <h2 class="qou-section-title">
                    หมายเหตุใบเสนอราคา
                </h2>

            </div>

            <hr class="qou-divider">


            <label class="qou-remark-enable">

                <input
                    name="remark_ckk"
                    id="remark_ckk"
                    value="1"
                    type="checkbox"
                    <?php
                    echo
                        $qouData[
                            'remark_ckk'
                        ] == '1'
                        ? 'checked'
                        : '';
                    ?>
                >

                <span>
                    แสดงหมายเหตุในใบเสนอราคา
                </span>

            </label>


            <div class="qou-remark-list">

                <?php
                for (
                    $remarkIndex = 1;
                    $remarkIndex <= 5;
                    $remarkIndex++
                ) {

                    $remarkField =
                        'remark' .
                        $remarkIndex;

                ?>

                    <div class="qou-remark-row">

                        <div class="qou-remark-number">
                            <?php
                            echo $remarkIndex;
                            ?>
                        </div>

                        <textarea
                            name="<?php
                                echo $remarkField;
                            ?>"
                            id="<?php
                                echo $remarkField;
                            ?>"
                            class="qou-textarea"
                            rows="2"
                            placeholder="ระบุหมายเหตุข้อที่ <?php
                                echo $remarkIndex;
                            ?>"
                        ><?php
                            echo qouH(
                                isset(
                                    $qouData[
                                        $remarkField
                                    ]
                                )
                                    ? $qouData[
                                        $remarkField
                                    ]
                                    : ''
                            );
                        ?></textarea>

                    </div>

                <?php
                }
                ?>

            </div>

        </div>


        <!-- ===============================
             รายการสินค้า
        ================================ -->

        <div class="qou-card">

            <div
                class="qou-section-title-container"
            >

                <div class="qou-section-icon">
                    <i class="fas fa-box-open"></i>
                </div>

                <h2 class="qou-section-title">
                    รายการสินค้า
                </h2>

            </div>

            <hr class="qou-divider">


            <div
                id="pd"
                class="qou-product-wrap"
            >

                <?php

                /*
                |--------------------------------------------------------------------------
                | ใช้ระบบเลือกสินค้าเดิม
                |--------------------------------------------------------------------------
                */

                include(
                    'product_salesol.php'
                );

                ?>

            </div>

        </div>


        <!-- ===============================
             Action
        ================================ -->

        <?php
        /*
        |--------------------------------------------------------------------------
        | Action Button Permission by status_doc
        |--------------------------------------------------------------------------
        | Draft / ว่าง  : แสดงทั้งหมด
        | Returned      : แสดงทั้งหมด
        | Request       : แสดง Cancel + Update, ซ่อน Submit
        | Cancelled     : ซ่อนทั้งหมด
        | Rejected      : ซ่อนทั้งหมด
        | Approve       : ซ่อนทั้งหมด
        */

        $currentStatus = '';

        if ($editMode && isset($qouData['status_doc'])) {
            $currentStatus = trim((string)$qouData['status_doc']);
        }

        $statusNormalized = strtolower($currentStatus);


        $currentSendSup = ($editMode && isset($qouData['send_sup']))
            ? (string)$qouData['send_sup']
            : '';

        $sessionCodeForAction = isset($_SESSION['code'])
            ? trim((string)$_SESSION['code'])
            : '';

        $sessionTypeForAction = isset($_SESSION['type_login'])
            ? strtolower(trim((string)$_SESSION['type_login']))
            : '';

        $canSupApproveAction = (
            $sessionCodeForAction === 'SS3' ||
            $sessionTypeForAction === 'it' ||
            $sessionTypeForAction === 'owner'
        );

        $showSupApprovalActions = (
            $editMode &&
            $statusNormalized === 'request' &&
            $currentSendSup === '1' &&
            $canSupApproveAction
        );

        $hideAllActions = in_array(
            $statusNormalized,
            array('cancelled', 'rejected', 'approve', 'approved'),
            true
        );

        $showCancelButton = !$hideAllActions;
        $showSaveButton   = !$hideAllActions;
        $showSubmitButton = !$hideAllActions && $statusNormalized !== 'request';

        // เอกสารใหม่ยังไม่มี ref_id จึงยังยกเลิกเอกสารไม่ได้
        if (!$editMode) {
            $showCancelButton = false;
        }
        ?>

        <?php if ($editMode || !$hideAllActions) { ?>

        <div class="qou-sticky-actions">

            <div
                class="qou-sticky-actions-inner"
            >

                <?php if ($showSupApprovalActions) { ?>

                <div class="qou-sup-menu-wrap">
                    <button
                        type="button"
                        class="qou-btn-more"
                        onclick="qouToggleSupMenu(event);"
                        title="ดำเนินการเพิ่มเติม"
                    >&#8942;</button>

                    <div id="qouSupMenu" class="qou-sup-menu">
                        <button
                            type="button"
                            class="qou-sup-return"
                            onclick="qouOpenSupReasonModal('return_doc');"
                        >
                            <i class="far fa-envelope-open"></i>
                            &nbsp;ส่งกลับ
                        </button>

                        <button
                            type="button"
                            class="qou-sup-reject"
                            onclick="qouOpenSupReasonModal('reject_doc');"
                        >
                            <i class="far fa-times-circle"></i>
                            &nbsp;ไม่อนุมัติ
                        </button>
                    </div>
                </div>

                <button
                    type="button"
                    class="qou-btn-approve"
                    onclick="qouApproveDocument();"
                >
                    <i class="far fa-check-circle"></i>
                    อนุมัติ
                </button>

                <?php } ?>


                <?php if ($showCancelButton) { ?>
                <button
                    type="button"
                    class="qou-btn-cancel"
                    onclick="qouOpenCancelModal();"
                >
                    ยกเลิกเอกสาร
                </button>
                <?php } ?>


                <?php if ($showSaveButton) { ?>
                <button
                    type="submit"
                    name="submit"
                    id="btn_submit_qou"
                    value="submit"
                    class="qou-btn-submit"
                >

                    <i class="far fa-save"></i>

                    <?php

                    echo $editMode
                        ? 'Update'
                        : 'Save Draft';

                    ?>

                </button>
                <?php } ?>


                <?php if ($showSubmitButton) { ?>
                <button
                    type="submit"
                    name="submit"
                    id="btn_submit_sup"
                    value="submit_sup"
                    class="qou-btn-submit qou-btn-submit-sup"
                    onclick="return qouConfirmSubmitSup();"
                >
                    <i class="fas fa-paper-plane"></i>
                    Submit
                </button>
                <?php } ?>

            </div>

        </div>

        <?php } ?>

    </form>

    <div id="qouCancelModal" class="qou-cancel-modal" style="display:none;">
        <div class="qou-cancel-modal-box">
            <h3>ยกเลิกเอกสาร</h3>
            <p>กรุณาระบุหมายเหตุการยกเลิกเอกสาร</p>
            <textarea id="qou_cancel_reason_input" class="qou-textarea" rows="4" placeholder="ระบุเหตุผล..."></textarea>
            <div class="qou-cancel-modal-actions">
                <button type="button" class="qou-btn-cancel" onclick="qouCloseCancelModal();">ปิด</button>
                <button type="button" class="qou-btn-confirm-cancel" onclick="qouConfirmCancelDocument();">ยืนยันยกเลิกเอกสาร</button>
            </div>
        </div>
    </div>


    <div id="qouSupReasonModal" class="qou-cancel-modal" style="display:none;">
        <div class="qou-cancel-modal-box">
            <h3 id="qou_sup_reason_title">ระบุหมายเหตุ</h3>
            <p id="qou_sup_reason_desc">กรุณาระบุเหตุผล</p>
            <textarea id="qou_sup_reason_input" class="qou-textarea" rows="4" placeholder="ระบุเหตุผล..."></textarea>
            <input type="hidden" id="qou_sup_reason_action" value="">
            <div class="qou-cancel-modal-actions">
                <button type="button" class="qou-btn-cancel" onclick="qouCloseSupReasonModal();">ปิด</button>
                <button type="button" class="qou-btn-confirm-cancel" id="qou_sup_reason_confirm" onclick="qouConfirmSupReason();">ยืนยัน</button>
            </div>
        </div>
    </div>

</div>


<script>

/*
|--------------------------------------------------------------------------
| Payment + Delivery
|--------------------------------------------------------------------------
*/

document.addEventListener(
    'DOMContentLoaded',
    function () {

        var paymentSel =
            document.getElementById(
                'payment_dead'
            );

        var paymentOtherWrap =
            document.getElementById(
                'payment_dead_other_wrap'
            );

        var paymentOther =
            document.getElementById(
                'payment_dead_other'
            );


        var deliverySel =
            document.getElementById(
                'delivery_dead'
            );

        var deliveryDateWrap =
            document.getElementById(
                'delivery_dead_date_wrap'
            );

        var deliveryDate =
            document.getElementById(
                'delivery_date'
            );


        function handlePayment()
        {
            if (
                !paymentSel ||
                !paymentOtherWrap ||
                !paymentOther
            ) {
                return;
            }


            var value =
                String(
                    paymentSel.value || ''
                ).trim();


            var isOther =
                value === 'อื่นๆ' ||
                value.toLowerCase() ===
                    'other';


            paymentOtherWrap.style.display =
                isOther
                    ? 'block'
                    : 'none';


            paymentOther.required =
                isOther;
        }


        function handleDelivery()
        {
            if (
                !deliverySel ||
                !deliveryDateWrap ||
                !deliveryDate
            ) {
                return;
            }


            var value =
                String(
                    deliverySel.value || ''
                ).trim();


            var option =
                deliverySel.options[
                    deliverySel.selectedIndex
                ];


            var text =
                option
                    ? String(
                        option.text || ''
                    ).trim()
                    : '';


            var showDate =
                value === 'เลือกวันที่' ||
                text === 'เลือกวันที่' ||
                value.toLowerCase() ===
                    'pick_date';


            deliveryDateWrap.style.display =
                showDate
                    ? 'block'
                    : 'none';


            deliveryDate.required =
                showDate;
        }


        if (paymentSel) {

            paymentSel.addEventListener(
                'change',
                handlePayment
            );
        }


        if (deliverySel) {

            deliverySel.addEventListener(
                'change',
                handleDelivery
            );
        }


        handlePayment();

        handleDelivery();

    }
);


/*
|--------------------------------------------------------------------------
| Reference ตามบริษัท
|--------------------------------------------------------------------------
*/

document.addEventListener(
    'DOMContentLoaded',
    function () {

        var editMode =
            <?php
            echo $editMode
                ? 'true'
                : 'false';
            ?>;


        /*
         * Edit mode ใช้เลขเดิม
         */
        if (editMode) {
            return;
        }


        var companySelect =
            document.getElementById(
                'company_select'
            );


        var refDisplay =
            document.getElementById(
                'quotation_ref_display'
            );


        var quotationRefs = {

            '1':
                <?php
                echo json_encode(
                    $quotationRefAWL
                );
                ?>,

            '2':
                <?php
                echo json_encode(
                    $quotationRefNBM
                );
                ?>

        };


        function updateQuotationRef()
        {
            if (
                !companySelect ||
                !refDisplay
            ) {
                return;
            }


            var company =
                companySelect.value;


            if (
                quotationRefs[
                    company
                ]
            ) {

                refDisplay.textContent =
                    quotationRefs[
                        company
                    ];
            }
        }


        if (companySelect) {

            companySelect.addEventListener(
                'change',
                updateQuotationRef
            );
        }


        updateQuotationRef();

    }
);


/*
|--------------------------------------------------------------------------
| Protect Submit
|--------------------------------------------------------------------------
*/

var qouSubmitting = false;
var qouClickedSubmitButton = null;


document.addEventListener('click', function (event) {
    var target = event.target.closest('button[type="submit"]');
    if (target && target.form && target.form.id === 'frmMain') {
        qouClickedSubmitButton = target;
    }
});


function qouConfirmSubmitSup()
{
    return confirm('ต้องการส่งเอกสารนี้ให้ SUP อนุมัติใช่หรือไม่ ?');
}


function qouLockSubmit(form)
{
    if (qouSubmitting) {
        return false;
    }


    var typeHead =
        document.getElementById(
            'type_head'
        );


    if (
        !typeHead ||
        typeHead.value === ''
    ) {

        alert(
            'กรุณาเลือกประเภทสินค้า'
        );


        if (typeHead) {
            typeHead.focus();
        }


        return false;
    }


    var paymentSel =
        document.getElementById(
            'payment_dead'
        );


    var paymentOther =
        document.getElementById(
            'payment_dead_other'
        );


    if (
        paymentSel &&
        paymentOther
    ) {

        var paymentValue =
            String(
                paymentSel.value || ''
            ).trim();


        if (
            (
                paymentValue === 'อื่นๆ' ||
                paymentValue.toLowerCase() ===
                    'other'
            ) &&
            paymentOther.value.trim() === ''
        ) {

            alert(
                'กรุณาระบุเงื่อนไขการชำระเงิน'
            );


            paymentOther.focus();

            return false;
        }
    }


    var deliverySel =
        document.getElementById(
            'delivery_dead'
        );


    var deliveryDate =
        document.getElementById(
            'delivery_date'
        );


    if (
        deliverySel &&
        deliveryDate
    ) {

        var deliveryValue =
            String(
                deliverySel.value || ''
            ).trim();


        var deliveryText =
            deliverySel.options[
                deliverySel.selectedIndex
            ]
                ? String(
                    deliverySel.options[
                        deliverySel.selectedIndex
                    ].text || ''
                ).trim()
                : '';


        if (
            (
                deliveryValue ===
                    'เลือกวันที่' ||
                deliveryText ===
                    'เลือกวันที่' ||
                deliveryValue.toLowerCase() ===
                    'pick_date'
            ) &&
            deliveryDate.value === ''
        ) {

            alert(
                'กรุณาระบุวันที่ส่งสินค้า'
            );


            deliveryDate.focus();

            return false;
        }
    }


    qouSubmitting = true;


    var btn = qouClickedSubmitButton;

    if (!btn) {
        btn = document.getElementById('btn_submit_qou');
    }

    if (btn) {

        var isSubmitSup = btn.value === 'submit_sup';

        btn.innerHTML = isSubmitSup
            ? '<i class="fas fa-spinner fa-spin"></i> กำลังส่งอนุมัติ...'
            : '<i class="fas fa-spinner fa-spin"></i> กำลังบันทึก...';

        setTimeout(
            function () {
                btn.disabled = true;
            },
            0
        );
    }


    return true;
}


/*
|--------------------------------------------------------------------------
| SUP Approval Actions
|--------------------------------------------------------------------------
*/
function qouNativeActionSubmit(actionValue)
{
    var form = document.getElementById('frmMain');
    if (!form) return;

    var oldAction = form.querySelector('input[data-qou-action="1"]');
    if (oldAction) oldAction.remove();

    var actionInput = document.createElement('input');
    actionInput.type = 'hidden';
    actionInput.name = 'submit';
    actionInput.value = actionValue;
    actionInput.setAttribute('data-qou-action', '1');
    form.appendChild(actionInput);

    HTMLFormElement.prototype.submit.call(form);
}

function qouToggleSupMenu(event)
{
    if (event) event.stopPropagation();
    var menu = document.getElementById('qouSupMenu');
    if (menu) menu.classList.toggle('open');
}

function qouApproveDocument()
{
    if (!confirm('ยืนยันอนุมัติเอกสารนี้ใช่หรือไม่ ?')) {
        return;
    }

    qouNativeActionSubmit('approve_doc');
}

function qouOpenSupReasonModal(action)
{
    var modal = document.getElementById('qouSupReasonModal');
    var input = document.getElementById('qou_sup_reason_input');
    var actionInput = document.getElementById('qou_sup_reason_action');
    var title = document.getElementById('qou_sup_reason_title');
    var desc = document.getElementById('qou_sup_reason_desc');
    var menu = document.getElementById('qouSupMenu');

    if (!modal || !actionInput) return;

    actionInput.value = action;
    if (input) input.value = '';
    if (menu) menu.classList.remove('open');

    if (action === 'return_doc') {
        if (title) title.textContent = 'ส่งกลับเอกสาร';
        if (desc) desc.textContent = 'กรุณาระบุหมายเหตุที่ต้องการให้ผู้จัดทำแก้ไข';
    } else {
        if (title) title.textContent = 'ไม่อนุมัติเอกสาร';
        if (desc) desc.textContent = 'กรุณาระบุเหตุผลที่ไม่อนุมัติเอกสาร';
    }

    modal.style.display = 'flex';

    setTimeout(function () {
        if (input) input.focus();
    }, 50);
}

function qouCloseSupReasonModal()
{
    var modal = document.getElementById('qouSupReasonModal');
    if (modal) modal.style.display = 'none';
}

function qouConfirmSupReason()
{
    var input = document.getElementById('qou_sup_reason_input');
    var actionInput = document.getElementById('qou_sup_reason_action');
    var hiddenReason = document.getElementById('sup_action_reason');

    var reason = input ? input.value.trim() : '';
    var action = actionInput ? actionInput.value : '';

    if (reason === '') {
        alert('กรุณาระบุหมายเหตุ');
        if (input) input.focus();
        return;
    }

    if (action !== 'return_doc' && action !== 'reject_doc') {
        return;
    }

    if (!confirm(action === 'return_doc'
        ? 'ยืนยันส่งกลับเอกสารนี้ใช่หรือไม่ ?'
        : 'ยืนยันไม่อนุมัติเอกสารนี้ใช่หรือไม่ ?')) {
        return;
    }

    if (hiddenReason) hiddenReason.value = reason;
    qouNativeActionSubmit(action);
}

document.addEventListener('click', function () {
    var menu = document.getElementById('qouSupMenu');
    if (menu) menu.classList.remove('open');
});


/*
|--------------------------------------------------------------------------
| Cancel
|--------------------------------------------------------------------------
*/

function qouOpenCancelModal()
{
    var modal = document.getElementById('qouCancelModal');
    var input = document.getElementById('qou_cancel_reason_input');

    if (!modal) return;

    if (input) input.value = '';
    modal.style.display = 'flex';

    setTimeout(function () {
        if (input) input.focus();
    }, 50);
}

function qouCloseCancelModal()
{
    var modal = document.getElementById('qouCancelModal');
    if (modal) modal.style.display = 'none';
}

function qouConfirmCancelDocument()
{
    var input = document.getElementById('qou_cancel_reason_input');
    var reason = input ? input.value.trim() : '';

    if (reason === '') {
        alert('กรุณาระบุหมายเหตุการยกเลิก');
        if (input) input.focus();
        return;
    }

    if (!confirm('ยืนยันยกเลิกเอกสารนี้ใช่หรือไม่ ?')) {
        return;
    }

    var reasonHidden = document.getElementById('cancel_reason');
    if (reasonHidden) reasonHidden.value = reason;

    var form = document.getElementById('frmMain');
    if (!form) return;

    var actionInput = document.createElement('input');
    actionInput.type = 'hidden';
    actionInput.name = 'submit';
    actionInput.value = 'cancel_doc';
    form.appendChild(actionInput);

    // ใช้ native submit โดยตรง เพราะใน form มี element name="submit"
    // ซึ่งจะชนกับ form.submit() และทำให้เกิด error: form.submit is not a function
    HTMLFormElement.prototype.submit.call(form);
}

document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
        qouCloseCancelModal();
        qouCloseSupReasonModal();
    }
});

</script>


<div id="cr_bar">

<?php
include("foot.php");
?>

</div>

</body>
</html>