<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "dbconnect.php";
include "dbconnect_sale.php";

date_default_timezone_set("Asia/Bangkok");

function h($str){
    return htmlspecialchars((string)$str, ENT_QUOTES, 'UTF-8');
}

function DateThai($strDate){
    if (empty($strDate)) return '';
    $timestamp = strtotime($strDate);
    if (!$timestamp) return '';

    $strYear = date("Y", $timestamp) + 543;
    $strMonth = date("n", $timestamp);
    $strDay = date("j", $timestamp);
    $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    return $strDay . " " . $strMonthCut[$strMonth] . " " . $strYear;
}

function money($num){
    return number_format((float)$num, 2);
}

function novat($num){
    return ((float)$num) / 1.07;
}

function esc($conn, $val){
    return mysqli_real_escape_string($conn, (string)$val);
}

function getCompanyName($company){
    if ($company == '3') {
        return "บริษัท ออลล์เวล ไลฟ์ จำกัด";
    } elseif ($company == '4') {
        return "บริษัท โนเบิล เมด จำกัด";
    }
    return "";
}

function getMonthThaiAndYear($start_date){
    $monthNames = array(
        "01" => "มกราคม",
        "02" => "กุมภาพันธ์",
        "03" => "มีนาคม",
        "04" => "เมษายน",
        "05" => "พฤษภาคม",
        "06" => "มิถุนายน",
        "07" => "กรกฎาคม",
        "08" => "สิงหาคม",
        "09" => "กันยายน",
        "10" => "ตุลาคม",
        "11" => "พฤศจิกายน",
        "12" => "ธันวาคม"
    );

    if (empty($start_date) || strpos($start_date, '-') === false) {
        return array("", "");
    }

    $date_arr = explode('-', $start_date);
    $yy = isset($date_arr[0]) ? $date_arr[0] : "";
    $mm = isset($date_arr[1]) ? $date_arr[1] : "";

    $thaiMonth = isset($monthNames[$mm]) ? $monthNames[$mm] : "";
    $thaiYear = !empty($yy) ? ($yy + 543) : "";

    return array($thaiMonth, $thaiYear);
}

function isSoSaleCode($saleCode){
    $soCodes = array('SOL99', 'SOL2', 'SOL1', 'SOL3', 'SOL4', 'SOL5', 'SOL6');
    return in_array($saleCode, $soCodes);
}

function renderMainHeader($start_date, $company_name){
    list($thaiMonth, $thaiYear) = getMonthThaiAndYear($start_date);
    ?>
    <div class="page-title">Monthly Sales Record</div>
    <div class="page-subtitle"><?php echo h(trim($thaiMonth . ' ' . $thaiYear)); ?></div>
    <div class="page-company"><?php echo h($company_name); ?></div>
    <?php
}

function renderSectionTitle($title, $code){
    ?>
    <div class="section-title"><?php echo h($title); ?></div>
    <div class="section-subtitle"><?php echo h($code); ?></div>
    <?php
}

function renderSaleTableHeader(){
    ?>
    <table class="report-table">
        <thead>
            <tr>
                <th width="10%">วันเดือนปี</th>
                <th width="5%">เลขที่</th>
                <th width="5%">ช่องทางการขาย</th>
                <th width="10%">ชื่อลูกค้า</th>
                <th width="10%">ที่อยู่ติดตั้ง</th>
                <th width="10%">ผู้แนะนำ</th>
                <th width="5%">ผู้ออกเอกสาร</th>
                <th width="15%">ชื่อสินค้า</th>
                <th width="5%">จำนวน</th>
				<th width="5%">หน่วย</th>
                <th width="10%">ยอดลูกหนี้</th>
                <th width="10%">รายได้จากขาย</th>
            </tr>
        </thead>
        <tbody>
    <?php
}

function renderSaleRow($date, $docNo, $channel, $customer, $address_send, $suggest, $owner, $product, $qty, $unit, $amount, $amountNoVat){
    ?>
    <tr>
        <td class="center"><?php echo h(DateThai($date)); ?></td>
        <td class="center"><?php echo h($docNo); ?></td>
        <td class="left"><?php echo h($channel); ?></td>
        <td class="left"><?php echo h($customer); ?></td>
        <td class="left"><?php echo h($address_send); ?></td>
        <td class="left"><?php echo h($suggest); ?></td>
        <td class="left"><?php echo h($owner); ?></td>
        <td class="left"><?php echo h($product); ?></td>
        <td class="right"><?php echo h($qty); ?></td>
		<td class="left"><?php echo h($unit); ?></td>
        <td class="right"><?php echo money($amount); ?></td>
        <td class="right"><?php echo money($amountNoVat); ?></td>
    </tr>
    <?php
}

function renderCreditTableHeader(){
    ?>
    <table class="report-table">
        <thead>
            <tr>
                <th width="10%">วันเดือนปี</th>
                <th width="10%">เลขที่</th>
                <th width="25%">ชื่อลูกค้า</th>
                <th width="25%">ชื่อสินค้า</th>
                <th width="10%">จำนวน</th>
				<th width="5%">หน่วย</th>
                <th width="10%">ยอดลูกหนี้</th>
                <th width="10%">รายได้จากขาย</th>
            </tr>
        </thead>
        <tbody>
    <?php
}

function renderCreditRow($date, $docNo, $customer, $product, $qty, $unit, $amount, $amountNoVat){
    ?>
    <tr>
        <td class="center"><?php echo h(DateThai($date)); ?></td>
        <td class="center"><?php echo h($docNo); ?></td>
        <td class="left"><?php echo h($customer); ?></td>
        <td class="left"><?php echo h($product); ?></td>
        <td class="right"><?php echo h($qty); ?></td>
		  <td class="center"><?php echo h($unit); ?></td>
        <td class="right"><?php echo money($amount); ?></td>
        <td class="right"><?php echo money($amountNoVat); ?></td>
    </tr>
    <?php
}

function renderSummaryTable($label, $code, $gross, $net, $summaryType = 'red'){
    $summaryClass = ($summaryType === 'blue') ? 'summary-blue' : 'summary-red';
    ?>
    <table class="summary-table <?php echo $summaryClass; ?>">
        <tr>
            <td width="80%" class="left-cell"><?php echo h($label . ' : ' . $code); ?></td>
            <td width="10%" class="right-cell"><?php echo money($gross); ?></td>
            <td width="10%" class="right-cell"><?php echo money($net); ?></td>
        </tr>
    </table>
    <?php
}

function getSaleChannelName($conn, $saleChannelId){
    $saleChannelId = esc($conn, $saleChannelId);
    $sql = "SELECT salechannel_nameshort FROM tb_salechannel WHERE salechannel_ID = '$saleChannelId' LIMIT 1";
    $query = mysqli_query($conn, $sql);

    if (!$query) {
        return '';
    }

    $row = mysqli_fetch_assoc($query);
    return $row ? $row['salechannel_nameshort'] : '';
}

function getProductInfo($conn, $productId){
    $productId = esc($conn, $productId);
    $sql = "SELECT sol_name AS product_name, unit_name FROM tb_product WHERE product_ID = '$productId' LIMIT 1";
    $query = mysqli_query($conn, $sql);

    if (!$query) {
        return array('product_name' => '', 'unit_name' => '');
    }

    $row = mysqli_fetch_assoc($query);

    if (!$row) {
        return array('product_name' => '', 'unit_name' => '');
    }

    return $row;
}

function getAddressSend($conn, $refId){
    $refId = esc($conn, $refId);
    $sql = "SELECT address_send FROM tb_register_data WHERE ref_id = '$refId' LIMIT 1";
    $query = mysqli_query($conn, $sql);

    if (!$query) {
        return '';
    }

    $row = mysqli_fetch_assoc($query);
    return isset($row['address_send']) ? $row['address_send'] : '';
}

function buildDateWhere($field, $start_date, $end_date){
    $sql = "";
    if ($start_date != "") {
        $sql .= " AND $field >= '$start_date' ";
    }
    if ($end_date != "") {
        $sql .= " AND $field <= '$end_date' ";
    }
    return $sql;
}

function getSoSaleRows($conn, $start_date, $end_date, $companyDoc, $companyIv, $saleCode){
    $rows = array();
    $saleCode = esc($conn, $saleCode);
    $companyDoc = esc($conn, $companyDoc);
    $companyIv = esc($conn, $companyIv);

    $sqlDoc = "SELECT doc_no, doc_release_date, customer_name, ref_id, sale_channel, add_by, prefer_name
               FROM so__main
               WHERE doc_no != '' AND cancel_ckk = '0' ";
    $sqlDoc .= buildDateWhere("doc_release_date", $start_date, $end_date);
    if ($companyDoc != "") $sqlDoc .= " AND select_type_doc = '$companyDoc' ";
    if ($saleCode != "")   $sqlDoc .= " AND employee_name = '$saleCode' ";
    $sqlDoc .= " ORDER BY doc_no ASC ";

    $queryDoc = mysqli_query($conn, $sqlDoc);
    if ($queryDoc) {
        while ($main = mysqli_fetch_assoc($queryDoc)) {
            $refId = $main['ref_id'];
            $address_send = getAddressSend($conn, $refId);

            $refIdEsc = esc($conn, $refId);
            $sqlSub = "SELECT product_id, sale_count, sum_amount FROM so__submain WHERE ref_idd = '$refIdEsc'";
            $querySub = mysqli_query($conn, $sqlSub);

            if ($querySub) {
                while ($sub = mysqli_fetch_assoc($querySub)) {
                    $product = getProductInfo($conn, $sub['product_id']);
                    $channel = getSaleChannelName($conn, $main['sale_channel']);

                    $rows[] = array(
                        'date' => $main['doc_release_date'],
                        'doc_no' => $main['doc_no'],
                        'channel' => $channel,
                        'customer' => $main['customer_name'],
                        'address_send' => $address_send,
                        'suggest' => $main['prefer_name'],
                        'owner' => $main['add_by'],
                        'product' => $product['product_name'],
                        'qty' => $sub['sale_count'],
                        'unit' => $product['unit_name'],
                        'amount' => (float)$sub['sum_amount'],
                        'amount_novat' => novat($sub['sum_amount'])
                    );
                }
            }
        }
    }

    $sqlIv = "SELECT iv_no, iv_date, customer_name, ref_id, sale_channel, add_by, prefer_name
              FROM so__main
              WHERE iv_no != '' AND cancel_ckk = '0' ";
    $sqlIv .= buildDateWhere("iv_date", $start_date, $end_date);
    if ($companyIv != "") $sqlIv .= " AND select_type_doc = '$companyIv' ";
    if ($saleCode != "")  $sqlIv .= " AND employee_name = '$saleCode' ";
    $sqlIv .= " ORDER BY iv_no ASC ";

    $queryIv = mysqli_query($conn, $sqlIv);
    if ($queryIv) {
        while ($main = mysqli_fetch_assoc($queryIv)) {
            $refId = $main['ref_id'];
            $address_send = getAddressSend($conn, $refId);

            $refIdEsc = esc($conn, $refId);
            $sqlSub = "SELECT product_id, sale_count, sum_amount FROM so__submain WHERE ref_idd = '$refIdEsc'";
            $querySub = mysqli_query($conn, $sqlSub);

            if ($querySub) {
                while ($sub = mysqli_fetch_assoc($querySub)) {
                    $product = getProductInfo($conn, $sub['product_id']);
                    $channel = getSaleChannelName($conn, $main['sale_channel']);

                    $rows[] = array(
                        'date' => $main['iv_date'],
                        'doc_no' => $main['iv_no'],
                        'channel' => $channel,
                        'customer' => $main['customer_name'],
                        'address_send' => $address_send,
                        'suggest' => $main['prefer_name'],
                        'owner' => $main['add_by'],
                        'product' => $product['product_name'],
                        'qty' => $sub['sale_count'],
                        'unit' => $product['unit_name'],
                        'amount' => (float)$sub['sum_amount'],
                        'amount_novat' => novat($sub['sum_amount'])
                    );
                }
            }
        }
    }

    return $rows;
}

function getSoSaleTotal($conn, $start_date, $end_date, $companyDoc, $companyIv, $saleCode){
    $saleCode = esc($conn, $saleCode);
    $companyDoc = esc($conn, $companyDoc);
    $companyIv = esc($conn, $companyIv);

    $sql1 = "SELECT SUM(sum_amount) AS total
             FROM (so__main LEFT JOIN so__submain ON so__main.ref_id = so__submain.ref_idd)
             WHERE doc_no != '' AND cancel_ckk = '0' ";
    $sql1 .= buildDateWhere("doc_release_date", $start_date, $end_date);
    if ($companyDoc != "") $sql1 .= " AND select_type_doc = '$companyDoc' ";
    if ($saleCode != "")   $sql1 .= " AND employee_name = '$saleCode' ";

    $q1 = mysqli_query($conn, $sql1);
    $r1 = $q1 ? mysqli_fetch_assoc($q1) : array();
    $total1 = (float)($r1['total'] ?? 0);

    $sql2 = "SELECT SUM(sum_amount) AS total
             FROM (so__main LEFT JOIN so__submain ON so__main.ref_id = so__submain.ref_idd)
             WHERE iv_no != '' AND cancel_ckk = '0' ";
    $sql2 .= buildDateWhere("iv_date", $start_date, $end_date);
    if ($companyIv != "") $sql2 .= " AND select_type_doc = '$companyIv' ";
    if ($saleCode != "")  $sql2 .= " AND employee_name = '$saleCode' ";

    $q2 = mysqli_query($conn, $sql2);
    $r2 = $q2 ? mysqli_fetch_assoc($q2) : array();
    $total2 = (float)($r2['total'] ?? 0);

    return $total1 + $total2;
}

function getHosSaleRows($conn, $start_date, $end_date, $company, $saleCode){
    $rows = array();
    $saleCode = esc($conn, $saleCode);
    $company = esc($conn, $company);

    $sql1 = "SELECT iv_no, iv_date, bill_name, ref_id, sale, suggest
             FROM hos__so
             WHERE status_doc = 'Approve' AND have_order = '0' AND ic_ckk = '0' ";
    $sql1 .= buildDateWhere("iv_date", $start_date, $end_date);
    if ($company != "")  $sql1 .= " AND type_doc = '$company' ";
    if ($saleCode != "") $sql1 .= " AND sale_code = '$saleCode' ";
    $sql1 .= " ORDER BY iv_no ASC ";

    $q1 = mysqli_query($conn, $sql1);
    if ($q1) {
        while ($main = mysqli_fetch_assoc($q1)) {
            $refId = $main['ref_id'];
            $address_send = getAddressSend($conn, $refId);

            $refIdEsc = esc($conn, $refId);
            $sqlSub = "SELECT product_id, count, amount FROM hos__subso WHERE ref_idd = '$refIdEsc'";
            $qSub = mysqli_query($conn, $sqlSub);

            if ($qSub) {
                while ($sub = mysqli_fetch_assoc($qSub)) {
                    $product = getProductInfo($conn, $sub['product_id']);

                    $rows[] = array(
                        'date' => $main['iv_date'],
                        'doc_no' => $main['iv_no'],
                        'channel' => '',
                        'customer' => $main['bill_name'],
                        'address_send' => $address_send,
                        'suggest' => $main['suggest'],
                        'owner' => $main['sale'],
                        'product' => $product['product_name'],
                        'qty' => $sub['count'],
                        'unit' => $product['unit_name'],
                        'amount' => (float)$sub['amount'],
                        'amount_novat' => novat($sub['amount'])
                    );
                }
            }
        }
    }

    $sql2 = "SELECT iv_no, iv_date, bill_name, ref_id, sale, suggest
             FROM hos__so
             WHERE status_doc = 'Approve' AND have_order = '1' AND have_product = '2' AND ic_ckk = '0' ";
    $sql2 .= buildDateWhere("iv_date", $start_date, $end_date);
    if ($company != "")  $sql2 .= " AND type_doc = '$company' ";
    if ($saleCode != "") $sql2 .= " AND sale_code = '$saleCode' ";
    $sql2 .= " ORDER BY iv_no ASC ";

    $q2 = mysqli_query($conn, $sql2);
    if ($q2) {
        while ($main = mysqli_fetch_assoc($q2)) {
            $refId = $main['ref_id'];
            $address_send = getAddressSend($conn, $refId);

            $refIdEsc = esc($conn, $refId);
            $sqlSub = "SELECT product_id, count, amount FROM hos__subso WHERE ref_idd = '$refIdEsc'";
            $qSub = mysqli_query($conn, $sqlSub);

            if ($qSub) {
                while ($sub = mysqli_fetch_assoc($qSub)) {
                    $product = getProductInfo($conn, $sub['product_id']);

                    $rows[] = array(
                        'date' => $main['iv_date'],
                        'doc_no' => $main['iv_no'],
                        'channel' => '',
                        'customer' => $main['bill_name'],
                        'address_send' => $address_send,
                        'suggest' => $main['suggest'],
                        'owner' => $main['sale'],
                        'product' => $product['product_name'],
                        'qty' => $sub['count'],
                        'unit' => $product['unit_name'],
                        'amount' => (float)$sub['amount'],
                        'amount_novat' => novat($sub['amount'])
                    );
                }
            }
        }
    }

    return $rows;
}

function getHosSaleTotal($conn, $start_date, $end_date, $company, $saleCode){
    $saleCode = esc($conn, $saleCode);
    $company = esc($conn, $company);

    $sql1 = "SELECT SUM(amount) AS total
             FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id = hos__subso.ref_idd)
             WHERE status_doc = 'Approve' AND have_order = '0' AND ic_ckk = '0' ";
    $sql1 .= buildDateWhere("iv_date", $start_date, $end_date);
    if ($company != "")  $sql1 .= " AND type_doc = '$company' ";
    if ($saleCode != "") $sql1 .= " AND sale_code = '$saleCode' ";

    $q1 = mysqli_query($conn, $sql1);
    $r1 = $q1 ? mysqli_fetch_assoc($q1) : array();
    $total1 = (float)($r1['total'] ?? 0);

    $sql2 = "SELECT SUM(amount) AS total
             FROM (hos__so LEFT JOIN hos__subso ON hos__so.ref_id = hos__subso.ref_idd)
             WHERE status_doc = 'Approve' AND have_order = '1' AND have_product = '2' AND ic_ckk = '0' ";
    $sql2 .= buildDateWhere("iv_date", $start_date, $end_date);
    if ($company != "")  $sql2 .= " AND type_doc = '$company' ";
    if ($saleCode != "") $sql2 .= " AND sale_code = '$saleCode' ";

    $q2 = mysqli_query($conn, $sql2);
    $r2 = $q2 ? mysqli_fetch_assoc($q2) : array();
    $total2 = (float)($r2['total'] ?? 0);

    return $total1 + $total2;
}

function getCreditRows($conn, $start_date, $end_date, $company, $saleCode){
    $rows = array();
    $company = esc($conn, $company);
    $saleCode = esc($conn, $saleCode);

    $sql = "SELECT credit_no, date_credit, customer_name, ref_credit
            FROM tb_credit_note
            WHERE credit_no != '' AND status_doc = 'Approve' ";
    $sql .= buildDateWhere("date_credit", $start_date, $end_date);
    if ($company != "")  $sql .= " AND company_type = '$company' ";
    if ($saleCode != "") $sql .= " AND sale_code = '$saleCode' ";
    $sql .= " ORDER BY credit_no ASC ";

    $query = mysqli_query($conn, $sql);
    if ($query) {
        while ($main = mysqli_fetch_assoc($query)) {
            $refCredit = esc($conn, $main['ref_credit']);
            $sqlSub = "SELECT product_id, count, sum_amount FROM tb_subcredit WHERE ref_creditt = '$refCredit'";
            $querySub = mysqli_query($conn, $sqlSub);

            if ($querySub) {
                while ($sub = mysqli_fetch_assoc($querySub)) {
                    $product = getProductInfo($conn, $sub['product_id']);

                    $rows[] = array(
                        'date' => $main['date_credit'],
                        'doc_no' => $main['credit_no'],
                        'customer' => $main['customer_name'],
                        'product' => $product['product_name'],
                        'qty' => $sub['count'],
                        'unit' => $product['unit_name'],
                        'amount' => (float)$sub['sum_amount'],
                        'amount_novat' => novat($sub['sum_amount'])
                    );
                }
            }
        }
    }

    return $rows;
}

function getCreditTotal($conn, $start_date, $end_date, $company, $saleCode){
    $company = esc($conn, $company);
    $saleCode = esc($conn, $saleCode);

    $sql = "SELECT SUM(sum_amount) AS total
            FROM (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit = tb_subcredit.ref_creditt)
            WHERE credit_no != '' AND status_doc = 'Approve' ";
    $sql .= buildDateWhere("date_credit", $start_date, $end_date);
    if ($company != "")  $sql .= " AND company_type = '$company' ";
    if ($saleCode != "") $sql .= " AND sale_code = '$saleCode' ";

    $query = mysqli_query($conn, $sql);
    $row = $query ? mysqli_fetch_assoc($query) : array();

    return (float)($row['total'] ?? 0);
}

function renderSaleSection($conn, $start_date, $end_date, $company, $company1, $saleCode, $saleTitle = ''){
    if ($saleTitle == '') {
        $saleTitle = $saleCode;
    }

    renderSectionTitle($saleTitle, $saleCode);

    if (isSoSaleCode($saleCode)) {
        $saleRows = getSoSaleRows($conn, $start_date, $end_date, $company, $company1, $saleCode);
        $saleTotal = getSoSaleTotal($conn, $start_date, $end_date, $company, $company1, $saleCode);
    } else {
        $saleRows = getHosSaleRows($conn, $start_date, $end_date, $company, $saleCode);
        $saleTotal = getHosSaleTotal($conn, $start_date, $end_date, $company, $saleCode);
    }

    renderSaleTableHeader();
    foreach ($saleRows as $row) {
        renderSaleRow(
            $row['date'],
            $row['doc_no'],
            $row['channel'],
            $row['customer'],
            $row['address_send'],
            $row['suggest'],
            $row['owner'],
            $row['product'],
            $row['qty'],
            $row['unit'],
            $row['amount'],
            $row['amount_novat']
        );
    }
    echo "</tbody></table>";

    $saleNoVat = novat($saleTotal);
    renderSummaryTable("รวมยอดขายของ Sale", $saleCode, $saleTotal, $saleNoVat, 'red');

    $creditRows = getCreditRows($conn, $start_date, $end_date, $company, $saleCode);
    renderCreditTableHeader();
    foreach ($creditRows as $row) {
        renderCreditRow(
            $row['date'],
            $row['doc_no'],
            $row['customer'],
            $row['product'],
            $row['qty'],
            $row['unit'],
            $row['amount'],
            $row['amount_novat']
        );
    }
    echo "</tbody></table>";

    $creditTotal = getCreditTotal($conn, $start_date, $end_date, $company, $saleCode);
    $creditNoVat = novat($creditTotal);
    renderSummaryTable("รวมยอดลดหนี้ของ Sale", $saleCode, $creditTotal, $creditNoVat, 'red');

    $netTotal = $saleTotal - $creditTotal;
    $netNoVat = $saleNoVat - $creditNoVat;
    renderSummaryTable("ยอดสุทธิของ Sale", $saleCode, $netTotal, $netNoVat, 'blue');

    echo '<div class="divider"></div>';
}

function getTeamList($com, $emid, $name){
    $teams = array();

    if ($emid == 'SS3' || $emid == 'SOL99' || $emid == 'SOL4') {
        if ($emid == 'SOL4' || $emid == 'SOL99') {
            $rk = "ckk_1 = '2'";
        } else {
            $rk = "1";
        }
        $sql = "SELECT sale_code, sale_name FROM tb_team_ss3 WHERE $rk";
    } elseif ($emid == 'SS1') {
        $sql = "SELECT sale_code, sale_name FROM tb_team_ss1 WHERE 1";
    } elseif ($emid == 'SS2') {
        $sql = "SELECT sale_code, sale_name FROM tb_team_ss2 WHERE 1";
    } elseif ($emid == 'SS5') {
        $sql = "SELECT sale_code, sale_name FROM tb_team_ss3 WHERE sale_code IN ('S31','S32')";
    } elseif ($name == 'ทิพย์ภาพัน') {
        $sql = "SELECT sale_code, sale_name FROM tb_team_adm WHERE ckk='0'";
    } else {
        $sql = "SELECT sale_code, sale_name FROM tb_team_all";
    }

    $query = mysqli_query($com, $sql);
    if ($query) {
        while ($row = mysqli_fetch_assoc($query)) {
            $teams[] = $row;
        }
    }

    return $teams;
}

/* =========================
   รับค่า GET
========================= */
$start_date = isset($_GET["start_date"]) ? esc($conn, $_GET["start_date"]) : '';
$end_date   = isset($_GET["end_date"]) ? esc($conn, $_GET["end_date"]) : '';
$sale_code  = isset($_GET["sale_code"]) ? esc($conn, $_GET["sale_code"]) : '';
$str_arr    = isset($_GET["company"]) ? esc($conn, $_GET["company"]) : '';
$company    = substr($str_arr, 0, 1);
$company1   = substr($str_arr, -1);
$emid       = isset($_GET["code"]) ? esc($conn, $_GET["code"]) : '';
$name       = isset($_GET["name"]) ? esc($conn, $_GET["name"]) : '';

$company_name = getCompanyName($company);
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>Monthly Sales Record</title>
    <link rel="stylesheet" href="css/w32.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
            font-family: 'Prompt', sans-serif;
        }

        body {
            margin: 20px;
            background: #f8fafc;
            color: #1f2937;
            font-size: 14px;
            line-height: 1.6;
        }

        .report-wrapper {
            max-width: 1400px;
            margin: 0 auto;
            background: #ffffff;
            padding: 24px;
            border-radius: 14px;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.06);
        }

        .page-title {
            text-align: center;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 4px;
            color: #111827;
        }

        .page-subtitle {
            text-align: center;
            font-size: 20px;
            font-weight: 500;
            margin-bottom: 4px;
            color: #374151;
        }

        .page-company {
            text-align: center;
            font-size: 18px;
            font-weight: 500;
            margin-bottom: 24px;
            color: #1d4ed8;
        }

        .section-title {
            text-align: center;
            font-size: 20px;
            font-weight: 600;
            margin-top: 26px;
            margin-bottom: 4px;
            color: #dc2626;
        }

        .section-subtitle {
            text-align: center;
            font-size: 15px;
            font-weight: 500;
            margin-bottom: 14px;
            color: #6b7280;
        }

        .report-table,
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
            background: #fff;
        }

        .report-table th {
            background: #b49ad3;
            color: #111827;
            font-size: 13px;
            font-weight: 600;
            padding: 10px 8px;
            border: 1px solid #cbd5e1;
            text-align: center;
        }

        .report-table td {
            border: 1px solid #dbeafe;
            padding: 8px 10px;
            font-size: 13px;
            color: #111827;
            vertical-align: middle;
        }

        .report-table tbody tr:nth-child(even) {
            background: #f9fbff;
        }

        .left {
            text-align: left;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .summary-table td {
            border: 1px solid #cbd5e1;
            padding: 10px 12px;
            font-size: 14px;
            font-weight: 600;
        }

        .summary-red td {
            background: #fff1f2;
            color: #b91c1c;
        }

        .summary-blue td {
            background: #eff6ff;
            color: #1d4ed8;
        }

        .left-cell {
            text-align: left;
        }

        .right-cell {
            text-align: right;
        }

        .divider {
            height: 1px;
            background: #e5e7eb;
            margin: 24px 0;
        }
    </style>
</head>
<body>
    <div class="report-wrapper">
        <?php renderMainHeader($start_date, $company_name); ?>

        <?php
        if ($sale_code != '') {
            renderSaleSection($conn, $start_date, $end_date, $company, $company1, $sale_code, "เขตการขาย");
        } else {
            $teams = getTeamList($com, $emid, $name);

            foreach ($teams as $team) {
                $sale_code1 = $team['sale_code'];
                $sale_name  = $team['sale_name'];
                renderSaleSection($conn, $start_date, $end_date, $company, $company1, $sale_code1, $sale_name);
            }
        }
        ?>
    </div>
</body>
</html>