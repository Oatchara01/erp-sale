<?php include("head.php"); ?>
<?php include('dbconnect_sale.php'); ?>

<!-- Shared .so-* design-system primitives (cards, inputs, labels, buttons, etc.) -->
<link rel="stylesheet" href="css/so-core.css?v=<?php echo filemtime(__DIR__ . '/css/so-core.css'); ?>">
<!-- Page-specific styling for register_credinot.php -->
<link rel="stylesheet" href="css/register-credinot.css?v=<?php echo filemtime(__DIR__ . '/css/register-credinot.css'); ?>">

<body>
    <?php

    $ref_id = $_GET["ref_id"];
    $opener = isset($_GET['opener']) ? $_GET['opener'] : '';

    $escRefId = mysqli_real_escape_string($conn, $ref_id);

    $sql = "SELECT *   FROM hos__so where ref_id = '" . $escRefId . "'";
    $qry = mysqli_query($conn, $sql) or die(mysqli_error());
    $rs = mysqli_fetch_assoc($qry);

    $customerNo = '';
    $customerTypeName = '';
    $customerCreditThb = '';
    $customerStatusName = '-';
    $customerIsVip = false;
    if (!empty($rs['bill_id'])) {
        $escBillId = mysqli_real_escape_string($conn, $rs['bill_id']);
        $sqlCustomerNo = "SELECT customer_no, type_customer, credit_thb, status_cus, vip_ckk FROM tb_customer WHERE customer_id = '" . $escBillId . "'";
        $qryCustomerNo = mysqli_query($conn, $sqlCustomerNo) or die(mysqli_error());
        $rsCustomerNo = mysqli_fetch_assoc($qryCustomerNo);
        $customerNo = $rsCustomerNo['customer_no'] ?? '';
        $customerCreditThb = $rsCustomerNo['credit_thb'] ?? '';

        $statusCusVal = trim((string)($rsCustomerNo['status_cus'] ?? ''));
        if ($statusCusVal === '0') {
            $customerStatusName = 'Gold Customer';
        } elseif ($statusCusVal === '1') {
            $customerStatusName = 'Platinum Customer';
        } elseif ($statusCusVal === '2') {
            $customerStatusName = 'Diamond Customer';
        }
        $customerIsVip = (trim((string)($rsCustomerNo['vip_ckk'] ?? '')) === '1');

        if (!empty($rsCustomerNo['type_customer'])) {
            $escTypeCustomer = mysqli_real_escape_string($conn, $rsCustomerNo['type_customer']);
            $sqlTypeCustomer = "SELECT type_name FROM tb_typecustomer WHERE type_id = '" . $escTypeCustomer . "'";
            $qryTypeCustomer = mysqli_query($conn, $sqlTypeCustomer) or die(mysqli_error());
            $rsTypeCustomer = mysqli_fetch_assoc($qryTypeCustomer);
            $customerTypeName = $rsTypeCustomer['type_name'] ?? '';
        }
    }

    // เลขที่ IV ส่งมาจากหน้า register_suphos.php ได้ (ค่าสดในช่อง 'เลขที่เอกสาร' ที่อาจยังไม่ถูกบันทึกลง hos__so)
    // ถ้าไม่ส่งมา ให้ใช้ค่าจากฐานข้อมูลตามเดิม
    $ivNoParam = isset($_GET['iv_no']) ? trim($_GET['iv_no']) : '';
    $ivNoEffective = ($ivNoParam !== '') ? $ivNoParam : ($rs['iv_no'] ?? '');
    $escIvNo = mysqli_real_escape_string($conn, $ivNoEffective);


    $strSQL1 = "SELECT * FROM  (hos__subso LEFT JOIN tb_product ON hos__subso.product_ID=tb_product.product_id) WHERE ref_idd = '" . $escRefId . "' ";
    //echo $strSQL;
    //exit();
    $objQuery1 = mysqli_query($conn, $strSQL1) or die("Error Query [" . $strSQL1 . "]");
    $Num_Rows1 = mysqli_num_rows($objQuery1);

    $yearMonth = substr(date("Y") + 543, -2) . date("m");
    $sql1 = "SELECT MAX(ref_credit) AS MAXID FROM tb_credit_note";
    $qry1 = mysqli_query($conn, $sql1) or die(mysqli_error());
    $rs1 = mysqli_fetch_assoc($qry1);
    $maxId = substr($rs1['MAXID'], -4);
    $maxId3 = substr($rs1['MAXID'], -8);

    $maxId1 = substr($maxId3, 0, -4);
    $so = "SR";

    if ($maxId1 == $yearMonth) {
        $maxId1 = ($maxId + 1);
        $maxId2 = substr("00000" . $maxId1, -4);
        $nextId = $yearMonth . $maxId2;
    } else {
        $maxId1 = "0001";
        $nextId = $yearMonth . $maxId1;
    }


    date_default_timezone_set("Asia/Bangkok");

    $month = date('m');
    $day = date('d');
    $year = date('Y');

    $today = $year . '-' . $month . '-' . $day;

    ?>


    <!--action="register_office1.php"-->
    <form action='register_credinot1.php' method="post" name="frmMain" enctype="multipart/form-data">
        <div class="w3-container register-so-main" style="max-width: 1096px; margin: 0 auto;"><!-- main div -->

            <!-- Header Section -->
            <div class="so-header-container">
                <div class="so-header-left">
                    <h1 class="so-title">ใบลดหนี้ (Credit Note Order)</h1>
                    <div class="so-ref-info">
                        <span class="so-ref-label">เลขที่อ้างอิง</span>
                        <span class="so-ref-value"><?php echo $so;
                                                    echo $nextId; ?></span>
                    </div>
                </div>
            </div>

            <div class="so-tabs-container">
                <button type="button" class="so-tab-btn active">ข้อมูลเอกสาร</button>
            </div>

            <input type="hidden" name="ref_credit" value="<?php echo $so;
                                                            echo $nextId; ?>">
            <input type="hidden" name="mode_cus" id="mode_cus" value="<?php echo $rs["mode_cus"]; ?>">
            <input type="hidden" name="opener" value="<?php echo htmlspecialchars($opener); ?>">
            <input type="hidden" name="date_credit" id="date_credit" value="<?php echo $today; ?>">
            <input type="hidden" name="return_des" id="return_des" value="">

            <!-- ฟิลด์ required ที่ไม่มีตำแหน่งใน Figma ปัจจุบัน (ผู้ขอคืนสินค้า/ผู้แทนขาย) — ซ่อนไว้ก่อนตามที่ตกลง -->
            <input type="hidden" name="send_return_name" id="send_return_name" value="">
            <input type="hidden" name="date_send_return" id="date_send_return" value="">
            <input type="hidden" name="sale_name" id="sale_name" value="">
            <input type="hidden" name="sale_date" id="sale_date" value="">

            <div id="tab-document-info" class="so-tab-content active">

                <div class="so-card">
                    <div class="so-grid-3">
                        <!-- บริษัท -->
                        <div class="so-field-group">
                            <label class="so-label" for="company_type">บริษัท<span style="color:#D32F2F;">*</span></label>
                            <div class="so-select-wrapper">
                                <select class="so-select" name="company_type" id="company_type">
                                    <option value="3" selected>AWL</option>
                                    <option value="4">NBM</option>
                                </select>
                            </div>
                        </div>

                        <!-- แผนก/เขตการขาย -->
                        <div class="so-field-group">
                            <label class="so-label" for="sale_code">แผนก/เขตการขาย</label>
                            <div class="so-select-wrapper">
                                <?php
                                $saleCodeQueries = array(
                                    'SS1' => "SELECT * FROM tb_team_ss1 ORDER BY sale_code ASC",
                                    'SS2' => "SELECT * FROM tb_team_ss2 ORDER BY sale_code ASC",
                                    'SS3' => "SELECT * FROM tb_team_ss3 WHERE ckk_1='0' ORDER BY sale_code ASC",
                                    'SS5' => "SELECT * FROM tb_team_ss3 WHERE sale_code IN ('S31','S32') ORDER BY sale_code ASC",
                                    'SUP_MK' => "SELECT * FROM tb_team_adm WHERE ckk='1' ORDER BY sale_code ASC",
                                    'SUP_EN' => "SELECT * FROM tb_team_en ORDER BY sale_code ASC"
                                );
                                $userSaleCode = isset($_SESSION['code']) ? $_SESSION['code'] : '';
                                $saleCodeSql = isset($saleCodeQueries[$userSaleCode]) ? $saleCodeQueries[$userSaleCode] : "SELECT * FROM tb_team_adm WHERE ckk='0' ORDER BY sale_code ASC";
                                $saleCodeQuery = mysqli_query($com, $saleCodeSql);
                                ?>
                                <select name="sale_code" id="sale_code" class="so-select">
                                    <option value="">เลือกแผนก/เขตการขาย</option>
                                    <?php if ($saleCodeQuery) { ?>
                                        <?php while ($saleCodeRow = mysqli_fetch_array($saleCodeQuery, MYSQLI_ASSOC)) { ?>
                                            <option value="<?php echo htmlspecialchars($saleCodeRow['sale_code'], ENT_QUOTES, 'UTF-8'); ?>" <?php echo ($saleCodeRow['sale_code'] == ($rs['sale_code'] ?? '')) ? 'selected' : ''; ?>><?php echo htmlspecialchars($saleCodeRow['sale_code'] . ' - ' . $saleCodeRow['sale_name'], ENT_QUOTES, 'UTF-8'); ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <!-- ประเภทลดหนี้ -->
                        <div class="so-field-group">
                            <label class="so-label" for="ttype_doc">ประเภทการลดหนี้</label>
                            <div class="so-select-wrapper">
                                <select class="so-select" name="ttype_doc" id="ttype_doc">
                                    <option value="1" selected>คืนสินค้า</option>
                                    <option value="2">ส่วนลด</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="so-card">
                    <div class="so-section-title-container">
                        <h2 class="so-section-title">ข้อมูลเอกสารอ้างอิง</h2>
                        <hr class="so-divider">
                    </div>

                    <div class="so-customer-top-grid">
                        <div class="so-customer-top-left">
                            <div class="so-doc-pill-wrapper">
                                <span class="so-doc-pill">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="so-doc-pill-icon">
                                        <path d="M14 2H6C4.89543 2 4 2.89543 4 4V20C4 21.1046 4.89543 22 6 22H18C19.1046 22 20 21.1046 20 20V8L14 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M14 2V8H20" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        <circle cx="11.5" cy="14.5" r="2.5" stroke="currentColor" stroke-width="2" />
                                        <path d="M13.25 16.25L15.5 18.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                    </svg>
                                    ข้อมูลเอกสาร
                                </span>
                            </div>

                            <!-- เอกสารอ้างอิง (เลขที่ IV) -->
                            <div class="so-field-group">
                                <label class="so-label" for="iv_no_ref">เอกสารอ้างอิง<span style="color:#D32F2F;">*</span></label>
                                <div class="so-input-wrapper">
                                    <input type="text" name="iv_no_ref" id="iv_no_ref" value="<?php echo htmlspecialchars($ivNoEffective, ENT_QUOTES, 'UTF-8'); ?>" class="so-input">
                                    <button type="button" class="so-clear-icon" onclick="document.getElementById('iv_no_ref').value=''"><i class="fas fa-times"></i></button>
                                </div>
                            </div>

                            <!-- หมายเลขคำสั่งซื้อ (ref_id) -->
                            <div class="so-field-group">
                                <label class="so-label" for="ref_id">หมายเลขคำสั่งซื้อ<span style="color:#D32F2F;">*</span></label>
                                <div class="so-input-wrapper">
                                    <input type="text" name="ref_id" id="ref_id" value="<?php echo htmlspecialchars($rs["ref_id"] ?? '', ENT_QUOTES, 'UTF-8'); ?>" class="so-input">
                                    <button type="button" class="so-clear-icon" onclick="document.getElementById('ref_id').value=''"><i class="fas fa-times"></i></button>
                                </div>
                            </div>
                        </div>

                        <div class="so-customer-top-right">
                            <div class="so-field-group" style="height: 100%;">
                                <label class="so-label">ข้อมูลลูกค้า</label>
                                <div class="customer-info-display-card">
                                    <div class="cidc-col">
                                        <div class="cidc-row">
                                            <div class="cidc-label">รหัสสมาชิก</div>
                                            <div class="cidc-value">
                                                <span class="cidc-display-text"><?php echo htmlspecialchars($customerNo, ENT_QUOTES, 'UTF-8'); ?></span>
                                            </div>
                                        </div>
                                        <div class="cidc-row">
                                            <div class="cidc-label">เบอร์โทรศัพท์</div>
                                            <div class="cidc-value">
                                                <input type="text" name="customer_tel" id="customer_tel" value="<?php echo htmlspecialchars($rs["bill_tel"] ?? '', ENT_QUOTES, 'UTF-8'); ?>" class="cidc-value-input" readonly>
                                            </div>
                                        </div>
                                        <div class="cidc-row">
                                            <div class="cidc-label">สถานะลูกค้า</div>
                                            <div class="cidc-value">
                                                <img src="img/icons/vip.png" class="cidc-status-icon" alt="VIP" style="<?php echo $customerIsVip ? '' : 'display:none;'; ?>">
                                                <span class="cidc-display-text"><?php echo htmlspecialchars($customerStatusName, ENT_QUOTES, 'UTF-8'); ?></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="cidc-col">
                                        <div class="cidc-row">
                                            <div class="cidc-label">ชื่อลูกค้า</div>
                                            <div class="cidc-value">
                                                <input type="text" name="customer_name" id="customer_name" value="<?php echo htmlspecialchars($rs["bill_name"] ?? '', ENT_QUOTES, 'UTF-8'); ?>" class="cidc-value-input" readonly>
                                            </div>
                                        </div>
                                        <div class="cidc-row">
                                            <div class="cidc-label">ประเภทลูกค้า</div>
                                            <div class="cidc-value">
                                                <span class="cidc-display-text"><?php echo htmlspecialchars($customerTypeName, ENT_QUOTES, 'UTF-8'); ?></span>
                                            </div>
                                        </div>
                                        <div class="cidc-row">
                                            <div class="cidc-label">วงเงินเครดิต</div>
                                            <div class="cidc-value">
                                                <?php
                                                $formattedCredit = (is_numeric($customerCreditThb) && (float)$customerCreditThb > 0)
                                                    ? number_format((float)$customerCreditThb, 2)
                                                    : '0.00';
                                                ?>
                                                <span class="cidc-credit-term"><?php echo htmlspecialchars($formattedCredit, ENT_QUOTES, 'UTF-8'); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- ที่อยู่ -->
                            <div class="so-field-group" style="margin-top: 16px;">
                                <label class="so-label" for="address_name">ที่อยู่<span style="color:#D32F2F;">*</span></label>
                                <div class="so-input-wrapper">
                                    <input type="text" name="address_name" id="address_name" value="<?php echo htmlspecialchars($rs["bill_address"] ?? '', ENT_QUOTES, 'UTF-8'); ?>" class="so-input">
                                    <button type="button" class="so-clear-icon" onclick="document.getElementById('address_name').value=''"><i class="fas fa-times"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- การ์ดแก้ไขใบลดหนี้ E-Tax -->
                <div class="so-card">
                    <div class="so-section-title-container">
                        <h2 class="so-section-title">แก้ไขใบลดหนี้ E-Tax</h2>
                        <hr class="so-divider">
                    </div>

                    <div class="so-grid-2">
                        <!-- ครั้งที่ -->
                        <div class="so-field-group">
                            <label class="so-label" for="etax_count">ครั้งที่</label>
                            <div class="so-input-wrapper">
                                <input type="text" name="etax_count" id="etax_count" placeholder="ใส่เฉพาะตัวเลข" class="so-input">
                            </div>
                        </div>

                        <!-- วันที่เอกสารเดิม -->
                        <div class="so-field-group">
                            <label class="so-label" for="etax_orig_date">วันที่เอกสารเดิม</label>
                            <div class="so-input-wrapper calendar-wrapper">
                                <input type="date" name="etax_orig_date" id="etax_orig_date" class="so-input">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="so-card">
                    <div class="so-section-title-container">
                        <h2 class="so-section-title">ข้อมูลการคืนสินค้า</h2>
                        <hr class="so-divider">
                    </div>

                    <div class="so-grid-2">
                        <!-- ผู้รับคืนสินค้า -->
                        <div class="so-field-group">
                            <label class="so-label" for="receive_name">ผู้รับคืนสินค้า<span style="color:#D32F2F;">*</span></label>
                            <div class="so-input-wrapper">
                                <input type="text" name="receive_name" id="receive_name" class="so-input" required>
                                <button type="button" class="so-clear-icon" onclick="document.getElementById('receive_name').value=''"><i class="fas fa-times"></i></button>
                            </div>
                        </div>

                        <!-- วันที่ -->
                        <div class="so-field-group">
                            <label class="so-label" for="date_receive">วันที่<span style="color:#D32F2F;">*</span></label>
                            <div class="so-input-wrapper calendar-wrapper">
                                <input type="date" name="date_receive" id="date_receive" class="so-input" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="so-card">
                    <div class="so-section-title-container">
                        <h2 class="so-section-title">ข้อมูลการชำระเงินคืน</h2>
                        <hr class="so-divider">
                    </div>

                    <div class="so-grid-3">
                        <!-- วิธีชำระเงินคืน -->
                        <div class="so-field-group">
                            <label class="so-label" for="type_return">วิธีชำระเงินคืน<span style="color:#D32F2F;">*</span></label>
                            <div class="so-select-wrapper">
                                <select class="so-select" name="type_return" id="type_return" required>
                                    <option value="">เลือกวิธีชำระเงินคืน</option>
                                    <option value="1">เงินสด</option>
                                    <option value="2">โอนเงินเข้าบัญชี</option>
                                    <option value="3">ลดหนี้จากยอดลูกหนี้ค้างชำระ</option>
                                </select>
                            </div>
                        </div>

                        <!-- ธนาคาร -->
                        <div class="so-field-group">
                            <label class="so-label" for="bank_name">ธนาคาร</label>
                            <div class="so-input-wrapper">
                                <input type="text" name="bank_name" id="bank_name" class="so-input">
                            </div>
                        </div>

                        <!-- ชื่อบัญชี -->
                        <div class="so-field-group">
                            <label class="so-label" for="account_name">ชื่อบัญชี</label>
                            <div class="so-input-wrapper">
                                <input type="text" name="account_name" id="account_name" class="so-input">
                                <button type="button" class="so-clear-icon" onclick="document.getElementById('account_name').value=''"><i class="fas fa-times"></i></button>
                            </div>
                        </div>
                    </div>

                    <div class="so-grid-3">
                        <!-- เลขที่บัญชี -->
                        <div class="so-field-group">
                            <label class="so-label" for="account_no">เลขที่บัญชี</label>
                            <div class="so-input-wrapper">
                                <input type="text" name="account_no" id="account_no" class="so-input">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="so-card">
                    <div class="so-section-title-container">
                        <h2 class="so-section-title">รายการสินค้า</h2>
                        <hr class="so-divider">
                    </div>

                    <div class="credinot-table-wrap">
                        <table class="credinot-table">
                            <thead>
                                <tr>
                                    <th>ID สินค้า</th>
                                    <th>ชื่อสินค้า</th>
                                    <th>หน่วย</th>
                                    <th>จำนวน</th>
                                    <th>ราคาต่อหน่วย</th>
                                    <th>ส่วนลด/หน่วย</th>
                                    <th>ยอดรวม</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                $i = 1;
                                $grand_total_amount = 0;
                                while ($objResult1 = mysqli_fetch_array($objQuery1)) {


                                    $sql3 = "SELECT sum(count) as count3   FROM  (tb_credit_note LEFT JOIN tb_subcredit ON tb_credit_note.ref_credit=tb_subcredit.ref_creditt) where iv_no_ref = '" . $escIvNo . "' and product_id = '" . $objResult1['product_id'] . "' and status_doc ='Approve'";
                                    $qry3 = mysqli_query($conn, $sql3) or die(mysqli_error());

                                    while ($rs3 = mysqli_fetch_assoc($qry3)) {

                                        $count3 =  $rs3["count3"];

                                        $count2 = $objResult1["count"] - $count3;


                                ?>
                                    <?php

                                    }

                                    ?>
                                    <tr>
                                        <?php
                                        if ($count2 == '0') {
                                        } else {
                                            $sum_amount = ($objResult1["price"] - $objResult1["discount"]) * $count2;
                                            $grand_total_amount += $sum_amount;

                                        ?>
                                            <td>

                                                <input type="hidden" name="id[<?php echo $objResult1["id"]; ?>]" value="<?php echo $objResult1['id']; ?>">

                                                <input type="text" name="product_id[<?php echo $objResult1["id"]; ?>]" class="so-input" style="text-align:center;" value="<?php echo $objResult1['product_id']; ?>">

                                                <input type='hidden' name="product_code[<?php echo $objResult1["id"]; ?>]" value="<?php echo $objResult1["access_code"]; ?>" id="product_code[<?php echo $objResult1["id"]; ?>]">
                                            </td>

                                            <td><textarea name="product_name[<?php echo $objResult1["id"]; ?>]" id="product_name[<?php echo $objResult1["id"]; ?>]" class="so-textarea" readonly><?php echo $objResult1["sol_name"]; ?></textarea></td>

                                            <td><input type='text' name="unit_name[<?php echo $objResult1["id"]; ?>]" value="<?php echo $objResult1["unit_name"]; ?>" id="unit_name[<?php echo $objResult1["id"]; ?>]" class="so-input" readonly /></td>

                                            <td>

                                                <input type='text' name="count[<?php echo $objResult1["id"]; ?>]" value="<?php echo $count2; ?>" id="count[<?php echo $objResult1["id"]; ?>]" class="so-input" style="text-align:center" />

                                            </td>

                                            <td><input type='text' name="unit_price[<?php echo $objResult1["id"]; ?>]" value="<?php $price = $objResult1["price"];
                                                                                                                                echo number_format($price, 2) . ""; ?>" id="unit_price[<?php echo $objResult1["id"]; ?>]" class="so-input" style="text-align:right" /></td>

                                            <td><input type='text' name="discount_unit[<?php echo $objResult1["id"]; ?>]" value="<?php $discount_unit = $objResult1["discount"];
                                                                                                                                    echo number_format($discount_unit, 2) . ""; ?>" id="discount_unit[<?php echo $objResult1["id"]; ?>]" class="so-input" style="text-align:right" /></td>


                                            <td>
                                                <input type='text' name="sum_amount[<?php echo $objResult1["id"]; ?>]" value="<?php echo number_format($sum_amount, 2) . ""; ?>" id="sum_amount[<?php echo $objResult1["id"]; ?>]" class="so-input" style="text-align:right" />


                                            </td>


                                    </tr>


                            <?php
                                            $i++;
                                        }
                                    }
                            ?>

                            </tbody>
                        </table>
                    </div>

                    <div class="so-summary-box">
                        <div class="so-summary-content">
                            <div class="so-summary-row grand-total">
                                <span>ยอดรวมลดหนี้ทั้งสิ้น:</span>
                                <span id="grand_total_display"><?php echo number_format($grand_total_amount, 2); ?> บาท</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div><!-- /#tab-document-info -->

        </div>

        <div class="so-sticky-actions">
            <div class="so-sticky-actions-inner">
                <button type="submit" name="submit" value="submit" class="btn-so-submit">
                    <i class="far fa-paper-plane"></i> Submit
                </button>
                <button type="button" class="btn-so-draft" onclick="window.history.back();">
                    ยกเลิก
                </button>
            </div>
        </div>
    </form>

    </div>
    </div>
    <!-- <div id="cr_bar"> <?php include "foot.php"; ?></div> -->
    <!--/div-->