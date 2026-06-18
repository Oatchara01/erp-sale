<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "databaseshopee.php";
include "shopeeAPI.php";
include "dbconnect.php";
include "dbconnect_acc.php";

$running = 12;

$refreshToken = getRefreshTokenFromDB($running);

if ($refreshToken) {
    $shopId = 24017696;
    $ret = getAccessTokenShopLevel($partnerId, $partnerKey, $shopId, $refreshToken);

    if ($ret) {
        updateShopToken($ret, $running);
    }
} else {
    echo "Error: ไม่พบ Refresh Token";
    exit;
}

$partner_id = '2007594';
$shop_id = '24017696';
$partner_key = "shpk6d4e6b6c4d744162716f4147625073594c645a4377685550774e67457266";
$host = 'https://partner.shopeemobile.com';

$accessToken1 = getTokenFromDB($running);
$access_token = base64_decode($accessToken1);

if (!function_exists('shopeeSign')) {
    function shopeeSign($partner_id, $path, $timestamp, $access_token, $shop_id, $partner_key) {
        $base_string = $partner_id . $path . $timestamp . $access_token . $shop_id;
        return hash_hmac('sha256', $base_string, $partner_key);
    }
}

if (!function_exists('shopeeGet')) {
    function shopeeGet($host, $path, $params) {
        $url = $host . $path . "?" . http_build_query($params);

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30
        ]);

        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            return ["error" => "curl_error", "message" => $error];
        }

        return json_decode($response, true);
    }
}

if (!function_exists('getEscrowListByDateRange')) {
    function getEscrowListByDateRange($date1, $date2) {
        global $host, $partner_id, $partner_key, $shop_id, $access_token;

        $path = "/api/v2/payment/get_escrow_list";
        $all_list = [];
        $page_no = 1;
        $page_size = 100;

        do {
            $timestamp = time();

            $sign = shopeeSign(
                $partner_id,
                $path,
                $timestamp,
                $access_token,
                $shop_id,
                $partner_key
            );

            $params = [
                "partner_id" => $partner_id,
                "timestamp" => $timestamp,
                "access_token" => $access_token,
                "shop_id" => $shop_id,
                "sign" => $sign,
                "release_time_from" => strtotime($date1 . " 00:08:00"),
                "release_time_to" => strtotime($date2 . " 00:08:00"),
                "page_size" => $page_size,
                "page_no" => $page_no
            ];

            $result = shopeeGet($host, $path, $params);

            if (!empty($result['error'])) {
                return $result;
            }

            $list = $result['response']['escrow_list'] ?? [];

            foreach ($list as $item) {
                $all_list[] = $item;
            }

            $page_no++;

        } while (count($list) == $page_size);

        return [
            "error" => "",
            "message" => "",
            "response" => [
                "escrow_list" => $all_list
            ]
        ];
    }
}

if (!function_exists('getEscrowDetailcheck')) {
    function getEscrowDetailcheck($order_sn) {
        global $host, $partner_id, $partner_key, $shop_id, $access_token;

        $path = "/api/v2/payment/get_escrow_detail";
        $timestamp = time();

        $sign = shopeeSign(
            $partner_id,
            $path,
            $timestamp,
            $access_token,
            $shop_id,
            $partner_key
        );

        $params = [
            "partner_id" => $partner_id,
            "timestamp" => $timestamp,
            "access_token" => $access_token,
            "shop_id" => $shop_id,
            "sign" => $sign,
            "order_sn" => $order_sn
        ];

        return shopeeGet($host, $path, $params);
    }
}

//$date1 = $_GET['date1'] ?? date("Y-m-d", strtotime("-1 day"));
//$date2 = $_GET['date2'] ?? date("Y-m-d");
$date1 = "2026-05-21";
$date2 = "2026-05-22";

$add_date = date('Y-m-d H:i:s');

$result = getEscrowListByDateRange($date1, $date2);
$escrow_list = $result['response']['escrow_list'] ?? [];

$updated = 0;
$inserted = 0;
$not_found = 0;
$duplicate = 0;
$error_count = 0;
$total_amount = 0;
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>อัปเดตการรับเงิน Shopee</title>
</head>
<body>

<h2>
    อัปเดตการรับเงิน Shopee วันที่
    <?= htmlspecialchars($date1) ?>
    ถึง
    <?= htmlspecialchars($date2) ?>
</h2>

<form method="get">
    วันที่เริ่มต้น:
    <input type="date" name="date1" value="<?= htmlspecialchars($date1) ?>">
    วันที่สิ้นสุด:
    <input type="date" name="date2" value="<?= htmlspecialchars($date2) ?>">
    <button type="submit">ค้นหา / อัปเดต</button>
</form>

<br>

<?php if (!empty($result['error'])): ?>
    <pre><?php print_r($result); ?></pre>
<?php endif; ?>

<table border="1" cellpadding="8" cellspacing="0" width="100%">
    <tr>
        <th>ลำดับ</th>
        <th>Order SN</th>
        <th>วันที่โอนเงิน</th>
        <th>ยอดที่ Shopee โอน</th>
        <th>IV No</th>
        <th>IV Date</th>
        <th>สถานะ Update</th>
        <th>สถานะ Insert</th>
    </tr>

<?php
if (empty($escrow_list)) {

    echo '<tr><td colspan="8" align="center">ไม่พบรายการโอนเงินในช่วงวันที่นี้</td></tr>';

} else {

    $i = 1;

    foreach ($escrow_list as $row) {

        $order_sn = $row['order_sn'] ?? '';

        if ($order_sn == '') {
            continue;
        }

        if (!empty($row['escrow_release_time'])) {
            $transfer_date = date("Y-m-d H:i:s", $row['escrow_release_time']);
        } else {
            $transfer_date = $date1 . " 00:00:00";
        }

        $payout_amount = $row['payout_amount'] ?? 0;

        $detail = getEscrowDetailcheck($order_sn);
        $income = $detail['response']['order_income'] ?? [];

        $escrow_amount = $income['escrow_amount'] ?? $income['payout_amount'] ?? $payout_amount;
        $total_amount += floatval($escrow_amount);

        $order_sn_safe = mysqli_real_escape_string($conn, $order_sn);
        $transfer_date_safe = mysqli_real_escape_string($conn, $transfer_date);
        $escrow_amount_safe = mysqli_real_escape_string($conn, $escrow_amount);

        $sql = "
            SELECT select_type_doc, create_order, ref_id
            FROM so__main
            WHERE order_id = '$order_sn_safe'
            LIMIT 1
        ";

        $qry = mysqli_query($conn, $sql);

        if (!$qry) {
            $update_status = "SQL Error: " . mysqli_error($conn);
            $insert_status = "-";
            $error_count++;
            ?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?= htmlspecialchars($order_sn) ?></td>
                <td><?= htmlspecialchars($transfer_date) ?></td>
                <td><?= number_format($escrow_amount, 2) ?> บาท</td>
                <td>-</td>
                <td>-</td>
                <td><?= $update_status ?></td>
                <td><?= $insert_status ?></td>
            </tr>
            <?php
            continue;
        }

        if (mysqli_num_rows($qry) == 0) {
            $update_status = "ไม่พบ order_id ใน so__main";
            $insert_status = "-";
            $not_found++;
            ?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?= htmlspecialchars($order_sn) ?></td>
                <td><?= htmlspecialchars($transfer_date) ?></td>
                <td><?= number_format($escrow_amount, 2) ?> บาท</td>
                <td>-</td>
                <td>-</td>
                <td><?= $update_status ?></td>
                <td><?= $insert_status ?></td>
            </tr>
            <?php
            continue;
        }

        $rs = mysqli_fetch_array($qry);

        $ref_id = $rs["ref_id"];
        $select_type_doc = $rs["select_type_doc"];

        if ($select_type_doc == '1') {
            $iv_no = "IV69050299";
        } else if ($select_type_doc == '2') {
            $iv_no = "IV69/050014";
        } else if ($select_type_doc == '3') {
            $iv_no = "IV69050299.1";
        } else if ($select_type_doc == '4') {
            $iv_no = "IV69/050014.1";
        } else {
            $iv_no = "";
        }

        $iv_date = "2026-05-25";

        $ref_id_safe = mysqli_real_escape_string($conn, $ref_id);
        $iv_no_safe = mysqli_real_escape_string($conn, $iv_no);
        $iv_date_safe = mysqli_real_escape_string($conn, $iv_date);
        $add_date_safe = mysqli_real_escape_string($conn, $add_date);

        $strSQL = "
            UPDATE so__main
            SET
                iv_no = '$iv_no_safe',
                iv_date = '$iv_date_safe'
            WHERE ref_id = '$ref_id_safe' and iv_no=''
        ";

        if (mysqli_query($conn, $strSQL)) {
            if (mysqli_affected_rows($conn) > 0) {
                $update_status = "อัปเดตสำเร็จ";
                $updated++;
            } else {
                $update_status = "ข้อมูลเดิมเหมือนเดิม";
                $not_found++;
            }
        } else {
            $update_status = "Update Error: " . mysqli_error($conn);
            $error_count++;
        }

        $insertSQL = "
            INSERT INTO shopee_transfer_log
            (
                ref_id,
                order_sn,
                transfer_date,
                transfer_amount,
                iv_no,
                iv_date,
                add_date
            )
            VALUES
            (
                '$ref_id_safe',
                '$order_sn_safe',
                '$transfer_date_safe',
                '$escrow_amount_safe',
                '$iv_no_safe',
                '$iv_date_safe',
                '$add_date_safe'
            )
            ON DUPLICATE KEY UPDATE
                ref_id = VALUES(ref_id),
                transfer_date = VALUES(transfer_date),
                transfer_amount = VALUES(transfer_amount),
                iv_no = VALUES(iv_no),
                iv_date = VALUES(iv_date)
        ";

        if (mysqli_query($conn, $insertSQL)) {
            if (mysqli_affected_rows($conn) == 1) {
                $insert_status = "บันทึกใหม่";
                $inserted++;
            } elseif (mysqli_affected_rows($conn) == 2) {
                $insert_status = "มีข้อมูลแล้ว / อัปเดตซ้ำ";
                $duplicate++;
            } else {
                $insert_status = "ข้อมูลเดิมเหมือนเดิม";
                $duplicate++;
            }
        } else {
            $insert_status = "Insert Error: " . mysqli_error($conn);
            $error_count++;
        }
?>

    <tr>
        <td><?= $i++ ?></td>
        <td><?= htmlspecialchars($order_sn) ?></td>
        <td><?= htmlspecialchars($transfer_date) ?></td>
        <td><?= number_format($escrow_amount, 2) ?> บาท</td>
        <td><?= htmlspecialchars($iv_no) ?></td>
        <td><?= htmlspecialchars($iv_date) ?></td>
        <td><?= $update_status ?></td>
        <td><?= $insert_status ?></td>
    </tr>

<?php
    }
}
?>

</table>

<br>

<b>สรุปผล</b><br>
จำนวนรายการที่พบ: <?= count($escrow_list) ?> รายการ<br>
ยอดโอนรวม: <?= number_format($total_amount, 2) ?> บาท<br>
อัปเดต so__main สำเร็จ: <?= $updated ?> รายการ<br>
ไม่พบ/ไม่ได้เปลี่ยนแปลง: <?= $not_found ?> รายการ<br>
บันทึกประวัติใหม่: <?= $inserted ?> รายการ<br>
ข้อมูลซ้ำ/อัปเดตซ้ำ: <?= $duplicate ?> รายการ<br>
Error: <?= $error_count ?> รายการ<br>

</body>
</html>