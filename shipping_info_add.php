<?php
include('head.php');
include('dbconnect.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['UserID'])) {
    header('Location: index.php');
    exit();
}

date_default_timezone_set('Asia/Bangkok');

function fetchRows($connection, $sql)
{
    $rows = array();
    if (!$connection) {
        return $rows;
    }

    $query = mysqli_query($connection, $sql);
    if ($query) {
        while ($row = mysqli_fetch_assoc($query)) {
            $rows[] = $row;
        }
    }

    return $rows;
}

function esc($connection, $value)
{
    return mysqli_real_escape_string($connection, $value);
}

function h($value)
{
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function postValue($key, $default = '')
{
    return isset($_POST[$key]) ? trim($_POST[$key]) : $default;
}

function requestIntValue($primaryKey, $fallbackKey = '')
{
    if (isset($_POST[$primaryKey]) && trim((string)$_POST[$primaryKey]) !== '') {
        return (int)$_POST[$primaryKey];
    }
    if ($fallbackKey !== '' && isset($_POST[$fallbackKey]) && trim((string)$_POST[$fallbackKey]) !== '') {
        return (int)$_POST[$fallbackKey];
    }
    if (isset($_GET[$primaryKey]) && trim((string)$_GET[$primaryKey]) !== '') {
        return (int)$_GET[$primaryKey];
    }
    if ($fallbackKey !== '' && isset($_GET[$fallbackKey]) && trim((string)$_GET[$fallbackKey]) !== '') {
        return (int)$_GET[$fallbackKey];
    }

    return 0;
}

$prefaceOptions = array(
    'คุณ',
    'มหาวิทยาลัย',
    'บริษัท',
    'หจก.',
    'คลินิก',
    'ร้าน',
    'มูลนิธิ',
    'ร้านขายยา',
    'ร้านค้า',
    'โรงพยาบาล',
    'โรงเรียน',
    'สถาบัน',
    'สำนักงาน',
    'หสน.',
    'หสม.'
);

$provinces = fetchRows($conn, "SELECT province_name FROM tb_province ORDER BY province_name ASC");
$customerId = requestIntValue('customer_id', 'bill_id');
$shippingId = isset($_REQUEST['shipping_id']) ? (int)$_REQUEST['shipping_id'] : 0;

$formData = array(
    'customer_id' => $customerId,
    'customer_name' => '',
    'customer_code' => '',
    'preface_name' => '',
    'shipping_name' => '',
    'shipping_tel' => '',
    'shipping_address' => '',
    'shipping_province' => '',
    'shipping_ampher' => '',
    'shipping_postcode' => '',
    'install_location' => '',
    'location_link' => '',
    'map_image' => ''
);

$errorMessage = '';
$successMessage = '';

if ($customerId > 0) {
    $customerRows = fetchRows($conn, "SELECT customer_name, customer_code, preface_name, delivery_name, del_address, del_ampher, del_province, del_postcode, del_tel, install_address, location_link, location_map FROM tb_customer WHERE customer_id = {$customerId} LIMIT 1");
    $customerRow = !empty($customerRows) ? $customerRows[0] : null;
    if ($customerRow) {
        $formData['customer_name'] = $customerRow['customer_name'] ?? '';
        $formData['customer_code'] = $customerRow['customer_code'] ?? '';

        // เคลียร์ค่าให้เป็นช่องว่างทั้งหมดตามที่ผู้ใช้ต้องการสำหรับการเพิ่มใหม่
        $formData['preface_name'] = '';
        $formData['shipping_name'] = '';
        $formData['shipping_tel'] = '';
        // Clear address fields because this is adding a new shipping address
        $formData['shipping_address'] = '';
        $formData['shipping_province'] = '';
        $formData['shipping_ampher'] = '';
        $formData['shipping_postcode'] = '';
        $formData['install_location'] = '';
        $formData['location_link'] = '';
        $formData['map_image'] = '';
    }

    if ($shippingId > 0) {
        $shippingRows = fetchRows($conn, "SELECT * FROM tb_customer_shipping_address WHERE id = {$shippingId} LIMIT 1");
        $shippingRow = !empty($shippingRows) ? $shippingRows[0] : null;
        if ($shippingRow) {
            $formData['preface_name'] = $shippingRow['shipping_preface_name'] ?? $formData['preface_name'];
            $formData['shipping_name'] = $shippingRow['shipping_name'] ?? '';
            $formData['shipping_tel'] = $shippingRow['shipping_tel'] ?? '';
            $formData['shipping_address'] = $shippingRow['shipping_address'] ?? '';
            $formData['shipping_province'] = $shippingRow['shipping_province'] ?? '';
            $formData['shipping_ampher'] = $shippingRow['shipping_ampher'] ?? '';
            $formData['shipping_postcode'] = $shippingRow['shipping_postcode'] ?? '';
            $formData['install_location'] = $shippingRow['install_location'] ?? '';
            $formData['location_link'] = $shippingRow['location_link'] ?? '';
            $formData['map_image'] = $shippingRow['map_image'] ?? '';
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($formData as $key => $value) {
        $formData[$key] = postValue($key, $value);
    }

    $customerId = (int)$formData['customer_id'];
    $formData['customer_id'] = $customerId;
    $formData['shipping_tel'] = preg_replace('/[^0-9]/', '', $formData['shipping_tel']);
    $formData['shipping_postcode'] = preg_replace('/[^0-9]/', '', $formData['shipping_postcode']);

    if (
        $formData['preface_name'] === '' ||
        $formData['shipping_tel'] === '' ||
        $formData['shipping_address'] === '' ||
        $formData['shipping_province'] === '' ||
        $formData['shipping_ampher'] === '' ||
        $formData['shipping_postcode'] === ''
    ) {
        $errorMessage = 'กรุณากรอกข้อมูลให้ครบถ้วน';
    }

    if ($errorMessage !== '' && $customerId > 0) {
        $errorMessage = 'กรุณากรอกข้อมูลให้ครบถ้วนในช่องที่มีเครื่องหมาย *';
    }

    if ($errorMessage === '' && $customerId <= 0) {
        $errorMessage = 'Please open this form from a customer record before saving.';
    }

    if ($errorMessage === '') {
        $mapImageName = '';
        if (isset($_FILES['map_image']) && $_FILES['map_image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/maps/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $tmpName = $_FILES['map_image']['tmp_name'];
            $ext = strtolower(pathinfo($_FILES['map_image']['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

            if (in_array($ext, $allowed)) {
                $newFileName = 'map_' . $customerId . '_' . time() . '.' . $ext;
                if (move_uploaded_file($tmpName, $uploadDir . $newFileName)) {
                    $mapImageName = $newFileName;
                }
            }
        }

        mysqli_begin_transaction($conn);

        mysqli_begin_transaction($conn);

        if ($shippingId > 0) {
            $updateFields = array(
                "shipping_preface_name='" . esc($conn, $formData['preface_name']) . "'",
                "shipping_name='" . esc($conn, $formData['shipping_name']) . "'",
                "shipping_address='" . esc($conn, $formData['shipping_address']) . "'",
                "shipping_ampher='" . esc($conn, $formData['shipping_ampher']) . "'",
                "shipping_province='" . esc($conn, $formData['shipping_province']) . "'",
                "shipping_postcode='" . esc($conn, $formData['shipping_postcode']) . "'",
                "shipping_tel='" . esc($conn, $formData['shipping_tel']) . "'",
                "install_location='" . esc($conn, $formData['install_location']) . "'",
                "location_link='" . esc($conn, $formData['location_link']) . "'",
                "updated_at='" . date('Y-m-d H:i:s') . "'"
            );
            if ($mapImageName !== '') {
                $updateFields[] = "map_image='" . esc($conn, $mapImageName) . "'";
            }
            $sql = "UPDATE tb_customer_shipping_address SET " . implode(", ", $updateFields) . " WHERE id=" . (int)$shippingId;
        } else {
            $insertCols = array(
                "customer_id",
                "shipping_preface_name",
                "shipping_name",
                "shipping_address",
                "shipping_ampher",
                "shipping_province",
                "shipping_postcode",
                "shipping_tel",
                "install_location",
                "location_link",
                "created_at",
                "updated_at"
            );
            $now = date('Y-m-d H:i:s');
            $insertVals = array(
                "'" . esc($conn, $customerId) . "'",
                "'" . esc($conn, $formData['preface_name']) . "'",
                "'" . esc($conn, $formData['shipping_name']) . "'",
                "'" . esc($conn, $formData['shipping_address']) . "'",
                "'" . esc($conn, $formData['shipping_ampher']) . "'",
                "'" . esc($conn, $formData['shipping_province']) . "'",
                "'" . esc($conn, $formData['shipping_postcode']) . "'",
                "'" . esc($conn, $formData['shipping_tel']) . "'",
                "'" . esc($conn, $formData['install_location']) . "'",
                "'" . esc($conn, $formData['location_link']) . "'",
                "'" . $now . "'",
                "'" . $now . "'"
            );

            if ($mapImageName !== '') {
                $insertCols[] = "map_image";
                $insertVals[] = "'" . esc($conn, $mapImageName) . "'";
            }
            $sql = "INSERT INTO tb_customer_shipping_address (" . implode(", ", $insertCols) . ") VALUES (" . implode(", ", $insertVals) . ")";
        }

        $allOk = mysqli_query($conn, $sql) ? true : false;

        if ($allOk) {
            mysqli_commit($conn);
            $successMessage = 'บันทึกข้อมูลจัดส่งสำเร็จ';
            if ($mapImageName !== '') {
                $formData['map_image'] = $mapImageName;
            }
        } else {
            mysqli_rollback($conn);
            $errorMessage = 'ไม่สามารถบันทึกข้อมูลจัดส่งได้';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/w3.css">
    <link rel="stylesheet" href="css/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="css/tab.css">
    <link rel="stylesheet" href="awesome/css/all.css">
    <title>ข้อมูลการจัดส่ง</title>
    <style>
        :root {
            --primary: #612989;
            --border: #ece7f2;
            --input-bg: #f5f6f8;
            --text: #2f3337;
            --danger: #d92d20;
            --shadow: 0 22px 54px rgba(35, 20, 49, 0.18);
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            padding: clamp(10px, 2vw, 20px);
            background: #f3edf8;
            color: var(--text);
            font-family: 'Prompt', sans-serif;
        }

        .shipping-shell {
            width: 100%;
        }

        .shipping-page {
            width: min(100%, 1120px);
            margin: 0 auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: var(--shadow);
            overflow: hidden;
            container-type: inline-size;
        }

        .shipping-header {
            position: relative;
            padding: 22px 32px 16px;
            border-bottom: 1px solid var(--border);
        }

        .shipping-header h1 {
            margin: 0;
            font-size: clamp(20px, 2.5vw, 22px);
            font-weight: 600;
            color: #3b3b3b;
        }

        .close-button {
            position: absolute;
            top: 10px;
            right: 18px;
            border: 0;
            background: transparent;
            color: #494949;
            font-size: 38px;
            line-height: 1;
            cursor: pointer;
        }

        .shipping-form {
            padding: 18px 32px 24px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(12, minmax(0, 1fr));
            gap: 18px 22px;
        }

        .field {
            grid-column: span 4;
            min-width: 0;
        }

        .field.span-12 {
            grid-column: span 12;
        }

        .label {
            display: block;
            margin: 0 0 8px;
            color: var(--primary);
            font-size: 14px;
            font-weight: 400;
            white-space: nowrap;
        }

        .required {
            color: #f04438;
        }

        .control,
        .select,
        .file-control {
            width: 100%;
            height: 42px;
            border: 0;
            border-radius: 10px;
            background: var(--input-bg);
            color: var(--text);
            font-family: 'Prompt', sans-serif;
            font-size: 16px;
            padding: 0 16px;
            outline: none;
        }

        .file-wrap {
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            background: var(--input-bg);
        }

        .file-control {
            padding-right: 52px;
            display: flex;
            align-items: center;
        }

        .file-wrap input[type="file"] {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
        }

        .file-icon {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #5e5e5e;
            font-size: 22px;
            pointer-events: none;
        }

        .control-wrap {
            position: relative;
        }

        .control.has-clear {
            padding-right: 42px;
        }

        .clear {
            position: absolute;
            top: 50%;
            right: 12px;
            transform: translateY(-50%);
            border: 0;
            background: transparent;
            color: #8E8B94;
            font-size: 18px;
            cursor: pointer;
        }

        .error-box {
            margin-bottom: 18px;
            padding: 12px 14px;
            border-radius: 12px;
            background: #fef3f2;
            color: var(--danger);
            font-size: 14px;
        }

        .success-box {
            margin-bottom: 18px;
            padding: 12px 14px;
            border-radius: 12px;
            background: #edfdf3;
            color: #027a48;
            font-size: 14px;
        }

        .popup-modal {
            position: fixed;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            background: rgba(28, 18, 41, 0.35);
            z-index: 9999;
        }

        .popup-modal[hidden] {
            display: none;
        }

        .popup-card {
            width: min(100%, 380px);
            padding: 28px 24px 22px;
            border-radius: 24px;
            background: #fff;
            box-shadow: 0 24px 60px rgba(49, 27, 71, 0.2);
            text-align: center;
        }

        .popup-badge {
            width: 64px;
            height: 64px;
            margin: 0 auto 14px;
            border-radius: 999px;
            display: grid;
            place-items: center;
            color: #fff;
            font-size: 30px;
            font-weight: 700;
        }

        .popup-badge-success {
            background: linear-gradient(135deg, #6fbf73, #3d9e56);
        }

        .popup-badge-confirm {
            background: linear-gradient(135deg, #7a3fb0, #612989);
        }

        .popup-title {
            margin: 0 0 10px;
            font-size: 24px;
            font-weight: 600;
            color: #2f3337;
        }

        .popup-text {
            margin: 0 0 20px;
            font-size: 15px;
            color: #5f6368;
            line-height: 1.5;
        }

        .popup-actions {
            display: flex;
            justify-content: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .actions {
            display: flex;
            justify-content: flex-end;
            gap: 16px;
            padding-top: 24px;
            flex-wrap: wrap;
        }

        .btn {
            min-width: 158px;
            min-height: 44px;
            border-radius: 24px;
            font-family: 'Prompt', sans-serif;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
        }

        .btn-primary {
            border: 0;
            background: var(--primary);
            color: #fff;
        }

        .btn-secondary {
            border: 1px solid #dfdfdf;
            background: #fff;
            color: #333;
            box-shadow: 0 0 4px rgba(0, 0, 0, .1);
        }

        @container (max-width: 900px) {

            .field,
            .field.span-12 {
                grid-column: span 12;
            }

            .shipping-header,
            .shipping-form {
                padding-left: 18px;
                padding-right: 18px;
            }

            .actions {
                flex-direction: column-reverse;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="shipping-shell">
        <div class="shipping-page">
            <div class="shipping-header">
                <h1>ข้อมูลการจัดส่ง</h1>
            </div>

            <form method="post" class="shipping-form" id="shippingForm" enctype="multipart/form-data" novalidate>
                <input type="hidden" name="customer_id" value="<?php echo (int)$formData['customer_id']; ?>">
                <input type="hidden" name="shipping_id" value="<?php echo (int)$shippingId; ?>">
                <?php if ($errorMessage !== '') { ?>
                    <div class="error-box"><?php echo h($errorMessage); ?></div>
                <?php } ?>
                <?php if ($successMessage !== '') { ?>
                    <div class="success-box"><?php echo h($successMessage); ?></div>
                <?php } ?>

                <div class="grid">
                    <div class="field">
                        <label class="label" for="preface_name">คำนำหน้าชื่อ<span class="required">*</span></label>
                        <select class="select" name="preface_name" id="preface_name" required>
                            <option value="">Select</option>
                            <?php foreach ($prefaceOptions as $option) { ?>
                                <option value="<?php echo h($option); ?>" <?php echo ($formData['preface_name'] === $option) ? 'selected' : ''; ?>><?php echo h($option); ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="field">
                        <label class="label" for="shipping_name">ชื่อผู้รับสินค้า</label>
                        <div class="control-wrap">
                            <input type="text" class="control has-clear" name="shipping_name" id="shipping_name" value="<?php echo h($formData['shipping_name']); ?>" placeholder="กรอกชื่อผู้รับสินค้า">
                            <i class="fas fa-times clear" onclick="this.previousElementSibling.value=''"></i>
                        </div>
                    </div>

                    <div class="field">
                        <label class="label" for="shipping_tel">เบอร์โทร<span class="required">*</span></label>
                        <input type="text" class="control" name="shipping_tel" id="shipping_tel" inputmode="numeric" maxlength="15" value="<?php echo h($formData['shipping_tel']); ?>" placeholder="ใส่เฉพาะตัวเลข" required>
                    </div>

                    <div class="field span-12">
                        <label class="label" for="shipping_address">ที่อยู่ เลขที่/ตรอก/ซอย/ถนน<span class="required">*</span></label>
                        <div class="control-wrap">
                            <input type="text" class="control has-clear" name="shipping_address" id="shipping_address" value="<?php echo h($formData['shipping_address']); ?>" placeholder="กรอกรายละเอียดที่อยู่จัดส่ง" required>
                            <i class="fas fa-times clear" onclick="this.previousElementSibling.value=''"></i>
                        </div>
                    </div>

                    <div class="field">
                        <label class="label" for="shipping_province">จังหวัด<span class="required">*</span></label>
                        <select class="select" name="shipping_province" id="shipping_province" required>
                            <option value="">Select</option>
                            <?php foreach ($provinces as $province) { ?>
                                <option value="<?php echo h($province['province_name']); ?>" <?php echo ($formData['shipping_province'] === $province['province_name']) ? 'selected' : ''; ?>><?php echo h($province['province_name']); ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="field">
                        <label class="label" for="shipping_ampher">เขต/อำเภอ<span class="required">*</span></label>
                        <input type="text" class="control" name="shipping_ampher" id="shipping_ampher" value="<?php echo h($formData['shipping_ampher']); ?>" placeholder="กรอกเขตหรืออำเภอ" required>
                    </div>

                    <div class="field">
                        <label class="label" for="shipping_postcode">รหัสไปรษณีย์<span class="required">*</span></label>
                        <input type="text" class="control" name="shipping_postcode" id="shipping_postcode" inputmode="numeric" maxlength="10" value="<?php echo h($formData['shipping_postcode']); ?>" placeholder="ใส่เฉพาะตัวเลข" required>
                    </div>

                    <div class="field">
                        <label class="label" for="install_location">หน่วยงานที่ติดตั้ง</label>
                        <input type="text" class="control" name="install_location" id="install_location" value="<?php echo h($formData['install_location']); ?>" placeholder="ใส่เฉพาะตัวเลข">
                    </div>

                    <div class="field">
                        <label class="label" for="location_link">Location Link</label>
                        <input type="text" class="control" name="location_link" id="location_link" value="<?php echo h($formData['location_link']); ?>" placeholder="ใส่เฉพาะตัวเลข">
                    </div>

                    <div class="field">
                        <label class="label" for="map_image">ภาพแผนที่</label>
                        <div class="file-wrap">
                            <div class="file-control" id="mapImageLabel"><?php echo h($formData['map_image'] !== '' ? $formData['map_image'] : 'Choose File'); ?></div>
                            <input type="file" name="map_image" id="map_image" accept=".jpg,.jpeg,.png,.gif,.webp">
                            <span class="file-icon"><i class="far fa-images"></i></span>
                        </div>
                    </div>
                </div>

                <div class="actions">
                    <button type="submit" class="btn btn-primary"><?php echo $shippingId > 0 ? 'อัพเดต' : 'เพิ่ม'; ?></button>
                    <button type="button" class="btn btn-secondary" onclick="window.close()">ยกเลิก</button>
                </div>
            </form>

            <div id="shippingConfirmModal" class="popup-modal" hidden>
                <div class="popup-card">
                    <div class="popup-badge popup-badge-confirm">?</div>
                    <div class="popup-title">ยืนยันการบันทึก</div>
                    <p class="popup-text">ต้องการบันทึกข้อมูลการจัดส่งนี้ใช่หรือไม่</p>
                    <div class="popup-actions">
                        <button type="button" class="btn btn-primary" id="shippingConfirmOk">ตกลง</button>
                        <button type="button" class="btn btn-secondary" id="shippingConfirmCancel">ยกเลิก</button>
                    </div>
                </div>
            </div>

            <div id="shippingSuccessModal" class="popup-modal" <?php echo $successMessage !== '' ? '' : 'hidden'; ?>>
                <div class="popup-card">
                    <div class="popup-badge popup-badge-success">✓</div>
                    <div class="popup-title">บันทึกสำเร็จ</div>
                    <p class="popup-text"><?php echo h($successMessage !== '' ? $successMessage : 'บันทึกข้อมูลการจัดส่งสำเร็จ'); ?></p>
                    <div class="popup-actions">
                        <button type="button" class="btn btn-primary" id="shippingSuccessOk">ตกลง</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var shippingForm = document.getElementById('shippingForm');
        var shippingConfirmModal = document.getElementById('shippingConfirmModal');
        var shippingConfirmOk = document.getElementById('shippingConfirmOk');
        var shippingConfirmCancel = document.getElementById('shippingConfirmCancel');
        var shippingSuccessModal = document.getElementById('shippingSuccessModal');
        var shippingSuccessOk = document.getElementById('shippingSuccessOk');

        function togglePopup(modal, visible) {
            if (!modal) return;
            if (visible) {
                modal.removeAttribute('hidden');
            } else {
                modal.setAttribute('hidden', 'hidden');
            }
        }

        if (shippingForm) {
            shippingForm.addEventListener('submit', function(event) {
                if (shippingForm.dataset.confirmed === 'yes') {
                    shippingForm.dataset.confirmed = '';
                    return;
                }

                event.preventDefault();

                if (typeof shippingForm.reportValidity === 'function' && !shippingForm.reportValidity()) {
                    return;
                }

                togglePopup(shippingConfirmModal, true);
            });
        }

        if (shippingConfirmCancel) {
            shippingConfirmCancel.addEventListener('click', function() {
                togglePopup(shippingConfirmModal, false);
            });
        }

        if (shippingConfirmOk) {
            shippingConfirmOk.addEventListener('click', function() {
                togglePopup(shippingConfirmModal, false);
                if (!shippingForm) return;
                shippingForm.dataset.confirmed = 'yes';
                shippingForm.requestSubmit ? shippingForm.requestSubmit() : shippingForm.submit();
            });
        }

        if (shippingSuccessOk) {
            shippingSuccessOk.addEventListener('click', function() {
                togglePopup(shippingSuccessModal, false);
            });
        }

        document.querySelectorAll('[data-clear-target]').forEach(function(button) {
            button.addEventListener('click', function() {
                var target = document.getElementById(button.getAttribute('data-clear-target'));
                if (target) {
                    target.value = '';
                    target.focus();
                }
            });
        });

        ['shipping_tel', 'shipping_postcode'].forEach(function(id) {
            var input = document.getElementById(id);
            if (!input) return;
            input.addEventListener('input', function() {
                input.value = input.value.replace(/[^0-9]/g, '');
            });
        });

        var mapImageInput = document.getElementById('map_image');
        var mapImageLabel = document.getElementById('mapImageLabel');
        if (mapImageInput && mapImageLabel) {
            mapImageInput.addEventListener('change', function() {
                var fileName = mapImageInput.files && mapImageInput.files[0] ? mapImageInput.files[0].name : 'Choose File';
                mapImageLabel.textContent = fileName;
            });
        }
    </script>
</body>

</html>