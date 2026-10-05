<?php include('head.php');

include "dbconnect.php";
include "dbconnect_sale.php";

?>
<link rel="stylesheet" href="css/so-status-ui.css">

<body>
	<script>
		(function() {
			var collapsed = localStorage.getItem("sidebar_collapsed") === "1";
			document.body.classList.add("has-sidebar");
			if (collapsed) {
				document.body.classList.add("sidebar-collapsed");
				var sidebar = document.getElementById("sidebar");
				if (sidebar) sidebar.classList.add("sidebar-collapsed");
			}
		})();
	</script>
	<div class="status-so-page">
		<div class="so-card">
			<div class="w3-container w3-bar w3-margin-bottom" style="padding-left:0;padding-right:0;">
				<h4 style="margin:0;">รายการใบเสนอราคา</h4>
			</div>

			<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME']; ?>">
				<div class="so-input-group" style="align-items: flex-end; margin-bottom: 20px;">
					<div style="flex: 1; max-width: 680px; min-width: 250px; display: flex; flex-direction: column; gap: 6px;">
						<label for="Keyword" style="font-size: 14px; color: #612989; font-weight: 500;">ค้นหาด้วยเลขที่เอกสาร/ชื่อลูกค้า</label>
						<div style="display: flex; gap: 12px; align-items: center;">
							<div class="so-search-wrapper" style="flex: 1; width: auto;">
								<i class="fas fa-search so-search-icon"></i>
								<input name="Keyword" id="Keyword" class="so-input" type="text" placeholder="ค้นหา..." value="<?php echo htmlspecialchars(isset($_GET['Keyword']) ? $_GET['Keyword'] : ''); ?>">
							</div>
							<a href="register_qou.php" class="btn-so-outline" style="flex-shrink: 0; font-weight: 500;">
								<img src="img/icons/add_message.png" alt=""> เพิ่มใบเสนอราคา
							</a>
						</div>
					</div>
					<button type="button" class="btn-so-secondary" id="filterBtn" onclick="openFilterModal()">
						<i class="fas fa-filter"></i> Filters
						<span id="filterBadge" style="display:none; background:#612989; color:#fff; border-radius:50%; width:20px; height:20px; font-size:11px; line-height:20px; text-align:center; margin-left:6px; font-weight:700; vertical-align:middle;"></span>
					</button>
				</div>

				<!-- Filter Modal -->
				<div id="filterModal" class="w3-modal" style="display:none; z-index:9999;">
					<div class="w3-modal-content w3-card-4" style="border-radius:16px; max-width:680px;">
						<div class="w3-container" style="padding:32px;">
							<div class="so-modal-header">
								<h5 style="margin:0; font-weight:600; color:#3B3B3B; font-size:20px;">Filters</h5>
								<button type="button" onclick="closeFilterModal()" aria-label="ปิด" style="background:none; border:none; font-size:28px; cursor:pointer; color:#8E8B94; line-height:1; padding:0;">&times;</button>
							</div>

							<!-- Row 1: ช่วงวันที่ -->
							<div class="so-form-row">
								<div>
									<label class="so-label" for="start_date">ตั้งแต่วันที่</label>
									<input type="date" name="start_date" id="start_date" class="so-select so-modal-input" value="<?php echo htmlspecialchars(isset($_GET['start_date']) ? $_GET['start_date'] : ''); ?>">
								</div>
								<div>
									<label class="so-label" for="end_date">ถึงวันที่</label>
									<input type="date" name="end_date" id="end_date" class="so-select so-modal-input" value="<?php echo htmlspecialchars(isset($_GET['end_date']) ? $_GET['end_date'] : ''); ?>">
								</div>
							</div>

							<!-- Row 2: สถานะการอนุมัติ + ประเภทใบจอง -->
							<div class="so-form-row">
								<div>
									<label class="so-label" for="status_approve">สถานะการอนุมัติ</label>
									<select name="status_approve" id="status_approve" class="so-select">
										<option value="">-- ทั้งหมด --</option>
										<option value="Request" <?php echo (isset($_GET['status_approve']) && $_GET['status_approve'] == 'Request') ? 'selected' : ''; ?>>รอหัวหน้า</option>
										<option value="Draft" <?php echo (isset($_GET['status_approve']) && $_GET['status_approve'] == 'Draft') ? 'selected' : ''; ?>>ร่าง</option>
										<option value="Approve" <?php echo (isset($_GET['status_approve']) && $_GET['status_approve'] == 'Approve') ? 'selected' : ''; ?>>อนุมัติแล้ว</option>
										<option value="Rejected" <?php echo (isset($_GET['status_approve']) && $_GET['status_approve'] == 'Rejected') ? 'selected' : ''; ?>>ไม่อนุมัติ</option>
										<option value="cancel" <?php echo (isset($_GET['status_approve']) && $_GET['status_approve'] == 'cancel') ? 'selected' : ''; ?>>ยกเลิก</option>
									</select>
								</div>
								<div>
									<label class="so-label" for="type_jong">ประเภทใบเสนอราคา</label>
									<select name="type_jong" id="type_jong" class="so-select">
										<option value="">-- ทั้งหมด --</option>
										<option value="1" <?php echo (isset($_GET['type_head']) && $_GET['type_head'] == '1') ? 'selected' : ''; ?>>สินค้าขาย</option>
										<option value="2" <?php echo (isset($_GET['type_head']) && $_GET['type_head'] == '2') ? 'selected' : ''; ?>>สินค้าเช่า</option>
										
									</select>
								</div>
									<div>
									<label class="so-label" for="ref_so">สถานะใบเสนอราคา</label>
									<select name="ref_so" id="ref_so" class="so-select">
										<option value="">-- ทั้งหมด --</option>
									<option value="0" <?php echo (isset($_GET['ref_so']) && $_GET['ref_so'] == 'ref_so') ? 'selected' : ''; ?>>รอเปิดใบสั่งขาย</option>
									<option value="1" <?php echo (isset($_GET['ref_so']) && $_GET['ref_so'] == 'ref_so') ? 'selected' : ''; ?>>เปิดใบสั่งขายแล้ว</option>
									</select>
								</div>
							</div>

							<div class="so-modal-footer">
								<button type="submit" class="btn-filter-submit">ตกลง</button>
								<button type="button" class="btn-filter-reset" onclick="resetFilters()">
									<i class="fas fa-sync-alt" style="margin-right:6px;"></i> รีเซ็ต
								</button>
							</div>
						</div>
					</div>
				</div>
			</form>


			<?php

			$Keyword       = isset($_GET['Keyword'])        ? $_GET['Keyword']        : '';
			$start_date    = isset($_GET['start_date'])     ? $_GET['start_date']     : '';
			$end_date      = isset($_GET['end_date'])       ? $_GET['end_date']       : '';
			$status_approve = isset($_GET['status_approve']) ? $_GET['status_approve'] : '';
			$type_head     = isset($_GET['type_head'])      ? $_GET['type_head']      : '';
			$ref_so = isset($_GET['ref_so'])      ? $_GET['ref_so']      : ''; 

			?>

			<div class="so-table-wrapper">
				<table class="so-table">
					<thead>
						<tr>
							<th width="3%"></th>
							<th style="white-space:nowrap;">เลขที่อ้างอิง</th>
							<th style="white-space:nowrap;">วันที่ลงทะเบียน</th>
							<th style="white-space:nowrap;">ชื่อลูกค้า</th>
							<th style="white-space:nowrap; width:10%;">สถานะ</th>
							<th width="5%" style="text-align:center;"></th>
						</tr>
					</thead>
					<tbody>

					<?php

					date_default_timezone_set("Asia/Bangkok");

					$strSQL = "SELECT *  FROM qou__main  where  1";

					if ($start_date != "") {
						$strSQL .= ' AND register_date >= "' . $start_date . '"';
					}

					if ($end_date != "") {
						$strSQL .= ' AND register_date <= "' . $end_date . '"';
					}

				
					if ($Keyword != "") {
						$strSQL .= ' AND (cus_name LIKE "%' . $Keyword . '%"';
						$strSQL .= ' OR ref_id LIKE "%' . $Keyword . '%")';
					}

					// Filter: สถานะการอนุมัติ
					if ($status_approve != '') {
						$strSQL .= " AND status_doc = '" . $conn->real_escape_string($status_approve) . "' AND cancel_ckk = '0' AND close_jong = '0'";
					}

					// Filter: ประเภทใบจอง
					if ($type_head != '') {
						$strSQL .= " AND type_head = '" . (int)$type_head . "'";
					}
                    if ($ref_so != '') {
						 if ($ref_so == '0') {
						$strSQL .= " AND ref_so = ''";
						 }else if ($ref_so == '1') {
						$strSQL .= " AND ref_so != ''";
						 }
					}
				

					$objQuery = mysqli_query($conn, $strSQL) or die("Error Query [" . $strSQL . "]");
					$Num_Rows = mysqli_num_rows($objQuery);

					$Per_Page = '20';
					$Page = max(1, (int)($_GET['Page'] ?? 1));

					$Prev_Page = $Page - 1;
					$Next_Page = $Page + 1;

					$Page_Start = (($Per_Page * $Page) - $Per_Page);
					if ($Num_Rows <= $Per_Page) {
						$Num_Pages = 1;
					} else if (($Num_Rows % $Per_Page) == 0) {
						$Num_Pages = ($Num_Rows / $Per_Page);
					} else {
						$Num_Pages = ($Num_Rows / $Per_Page) + 1;
						$Num_Pages = (int)$Num_Pages;
					}


					$strSQL .= " order  by main_id  DESC   LIMIT $Page_Start , $Per_Page";
					$objQuery  = mysqli_query($conn, $strSQL);
					$Page_Num_Rows = $objQuery ? mysqli_num_rows($objQuery) : 0;

					?>


					<?php if ($Page_Num_Rows === 0) { ?>
						<tr>
							<td colspan="10" style="text-align:center; padding:40px 16px; color:#6B6875;">
								<?php echo ($Num_Rows > 0)
									? 'ไม่พบข้อมูลในหน้านี้ — ลองกลับไปหน้าแรก'
									: 'ไม่พบใบจองที่ตรงกับเงื่อนไข ลองล้างตัวกรองหรือเปลี่ยนคำค้น'; ?>
							</td>
						</tr>
					<?php } ?>

					<?php
					$i = 1;
					while ($objResult = mysqli_fetch_array($objQuery)) {
						$row_id = "row-" . $objResult["ref_id"];
						$dropdown_id = "dropdown-" . $objResult["ref_id"];
						// json_encode ต้องผ่าน htmlspecialchars ด้วย มิฉะนั้น double quote ที่ครอบ string
						// จะไปปิด attribute onclick ก่อนกำหนด
						$row_id_js = htmlspecialchars(json_encode($row_id), ENT_QUOTES, 'UTF-8');
						$dropdown_id_js = htmlspecialchars(json_encode($dropdown_id), ENT_QUOTES, 'UTF-8');
						$ref_id_js = htmlspecialchars(json_encode($objResult["ref_id"]), ENT_QUOTES, 'UTF-8');
					?>
						<tr class="so-row" onclick="toggleRow(<?php echo $row_id_js; ?>, this)">
							<td style="text-align:center;"><img src="img/icons/arrow_down.png" class="caret-icon" style="width:12px; height:12px;" alt=""></td>
							<td><a href="register_qou.php?ref_id=<?php echo urlencode($objResult["ref_id"]); ?>&start_date=<?php echo urlencode($start_date); ?>&end_date=<?php echo urlencode($end_date); ?>" style="color: #612989; text-decoration: underline; font-weight: 500;"><?php echo htmlspecialchars($objResult["ref_id"]); ?></a></td>
							<td><?php echo DateThai($objResult["register_date"]); ?></td>
							<td>
								<div align="left"><?php echo htmlspecialchars($objResult["cus_name"]); ?></div>
							</td>
							
							<td>
								
								<?php if ($objResult["status_doc"] == 'Rejected') { ?>
									<span class="badge-status rejected">ไม่อนุมัติ</span>
								<?php } else if ($objResult["status_doc"] == 'Cancelled') { ?>
								<span class="badge-status cancel">ยกเลิก</span>
								<?php } else if ($objResult["status_doc"] == 'Returned') { ?>
									<span class="badge-status rejected">ส่งกลับ</span>
								<?php } else if ($objResult["ref_so"] != '') { ?>
									<span class="badge-status closed">เปิดใบสั่งขายแล้ว</span>
								<?php } else if ($objResult["status_doc"] == 'Approve') { ?>
									<span class="badge-status approve">อนุมัติแล้ว</span>
								<?php } else if ($objResult["status_doc"] == 'Request') { ?>
									<span class="badge-status pending-mgr">รอหัวหน้า</span>
								<?php } else if ($objResult["status_doc"] == 'Draft') { ?>
									<span class="badge-status draft">ร่าง</span>
								<?php } else { ?>
									<span class="badge-status draft"><?php echo htmlspecialchars($objResult["status_doc"]); ?></span>
								<?php } ?>
							</td>
							<td style="text-align:center; position:relative;">
								<div class="so-dropdown">
									<button type="button" class="so-dropdown-trigger" aria-label="ตัวเลือกเพิ่มเติม" onclick="toggleDropdown(event, <?php echo $dropdown_id_js; ?>)">
										<i class="fas fa-ellipsis-v"></i>
									</button>
									<div id="<?php echo htmlspecialchars($dropdown_id); ?>" class="so-dropdown-menu">
										<a href="register_qou.php?ref_id=<?php echo urlencode($objResult["ref_id"]); ?>&start_date=<?php echo urlencode($start_date); ?>&end_date=<?php echo urlencode($end_date); ?>" class="so-dropdown-item">
											<i class="fas fa-edit" style="width:16px;"></i> แก้ไข
										</a>
										<a href="register_qou.php?copy_ref=<?php echo urlencode($objResult["ref_id"]); ?>&copy=1" class="so-dropdown-item">
											<i class="fas fa-copy" style="width:16px;"></i> คัดลอกใบเดิม
										</a>
										<a href="formnb_qou.php?ref_id=<?php echo urlencode($objResult["ref_id"]); ?>" class="so-dropdown-item" target="_blank">
											<i class="fas fa-print" style="width:16px;"></i> พิมพ์รายงาน
										</a>
									</div>
								</div>
							</td>
						</tr>

<tr id="<?php echo htmlspecialchars($row_id); ?>" 
    class="expanded-row" 
    style="display:none;">

    <td colspan="11">
        <div class="expanded-container">

            <!-- Left: Items Sub-table -->
            <div class="expanded-products-card">

                <table class="sub-table">

                    <thead>
                        <tr>
                            <th width="40%">รายการสินค้า</th>

                            <th width="5%" style="text-align:center;">
                                จำนวน
                            </th>

                            <th width="10%" style="text-align:right !important;">
                                ราคา/หน่วย
                            </th>

                            <th width="10%" style="text-align:right !important;">
                                ส่วนลด/หน่วย
                            </th>

                            <th width="15%" style="text-align:right !important;">
                                ยอดรวม/สินค้า
                            </th>
                        </tr>
                    </thead>


                    <tbody>

                    <?php

                    $ref_id_sub = mysqli_real_escape_string(
                        $conn,
                        $objResult["ref_id"]
                    );


                    $sqlSub = "
                        SELECT 
                            qou__sbmain.*,
                            tb_product.sol_name
                        FROM qou__sbmain
                        LEFT JOIN tb_product
                            ON qou__sbmain.product_ID = tb_product.product_id
                        WHERE qou__sbmain.ref_idd = '$ref_id_sub'
                    ";


                    $qrySub = mysqli_query($conn, $sqlSub);


                    // เช็ก SQL Error ก่อน
                    if (!$qrySub) {

                        echo '
                        <tr>
                            <td colspan="5"
                                style="
                                    text-align:center;
                                    color:#d32f2f;
                                    padding:20px;
                                ">
                                SQL Error : ' . htmlspecialchars(mysqli_error($conn)) . '
                            </td>
                        </tr>
                        ';

                    } else {


                        $subRowsCount = mysqli_num_rows($qrySub);


                        if ($subRowsCount > 0) {


                            // ยอดรวมทั้งหมด
                            $total_amount = 0;


                            while ($subResult = mysqli_fetch_assoc($qrySub)) {


                                // ชื่อสินค้า
                                $item_name = !empty($subResult['sol_name'])
                                    ? $subResult['sol_name']
                                    : '-';


                                // จำนวน
                                $qty = isset($subResult['count'])
                                    ? (float)$subResult['count']
                                    : 0;


                                // ราคา/หน่วย
                                $price = isset($subResult['price'])
                                    ? (float)$subResult['price']
                                    : 0;


                                // ส่วนลด/หน่วย
                                $discount = isset($subResult['discount'])
                                    ? (float)$subResult['discount']
                                    : 0;


                                // ยอดรวมสินค้ารายการนี้
                                $amount = isset($subResult['amount'])
                                    ? (float)$subResult['amount']
                                    : 0;


                                // บวกสะสมยอดรวม
                                $total_amount += $amount;

                    ?>

                                <tr>

                                    <td>
                                        <?php echo htmlspecialchars($item_name); ?>
                                    </td>


                                    <td style="text-align:center;">
                                        <?php echo number_format($qty, 0); ?>
                                    </td>


                                    <td style="text-align:right;">
                                        <?php echo number_format($price, 2); ?>
                                    </td>


                                    <td style="text-align:right;">
                                        <?php echo number_format($discount, 2); ?>
                                    </td>


                                    <td style="text-align:right;">
                                        <?php echo number_format($amount, 2); ?>
                                    </td>

                                </tr>


                    <?php

                            }

                    ?>


                            <!-- ยอดรวม -->
                            <tr style="border-top:1px solid #EDE9F0;">

                                <td colspan="4"
                                    style="
                                        text-align:right;
                                        font-weight:500;
                                        padding:14px 12px !important;
                                        font-size:14px;
                                        color:#3B3B3B;
                                    ">

                                    ยอดรวม

                                </td>


                                <td
                                    style="
                                        text-align:right;
                                        font-size:16px;
                                        color:#612989;
                                        font-weight:600;
                                        padding:14px 12px !important;
                                    ">

                                    <?php echo number_format($total_amount, 2); ?>

                                </td>

                            </tr>


                    <?php

                        } else {

                    ?>

                            <tr>

                                <td colspan="5"
                                    style="
                                        text-align:center;
                                        color:#8E8B94;
                                        padding:20px;
                                    ">

                                    ไม่มีข้อมูลรายการสินค้า

                                </td>

                            </tr>


                    <?php

                        }

                    }

                    ?>

                    </tbody>

                </table>

            </div>

        </div>

    </td>

</tr>
<?php
}
?>
					</tbody>
				</table>
			</div> <!-- so-table-wrapper -->

			<div class="pagination-wrapper">
				<div>
					แสดง <?php echo ($Num_Rows > 0 ? $Page_Start + 1 : 0); ?> ถึง <?php echo min($Page_Start + $Per_Page, $Num_Rows); ?> จาก <?php echo $Num_Rows; ?> รายการ
				</div>
				<div class="pagination-links">
					<?php
					$pagParams = "&Keyword=" . urlencode($Keyword) . "&start_date=" . urlencode($start_date) . "&end_date=" . urlencode($end_date) .  "&status_approve=" . urlencode($status_approve) . "&type_head=" . urlencode($type_head) . "&ref_so=" . urlencode($ref_so);

					if ($Prev_Page) {
						echo "<a class='pagination-btn' href='$_SERVER[SCRIPT_NAME]?Page=$Prev_Page$pagParams'><i class='fas fa-chevron-left'></i></a>";
					}

					// Show maximum of 7 page links for better responsiveness
					$start_p = max(1, $Page - 3);
					$end_p = min($Num_Pages, $Page + 3);

					if ($start_p > 1) {
						echo "<a class='pagination-btn' href='$_SERVER[SCRIPT_NAME]?Page=1$pagParams'>1</a>";
						if ($start_p > 2) echo "<span style='padding:4px;'>...</span>";
					}

					for ($p = $start_p; $p <= $end_p; $p++) {
						$activeClass = ($p == $Page) ? 'active' : '';
						echo "<a class='pagination-btn $activeClass' href='$_SERVER[SCRIPT_NAME]?Page=$p$pagParams'>$p</a>";
					}

					if ($end_p < $Num_Pages) {
						if ($end_p < $Num_Pages - 1) echo "<span style='padding:4px;'>...</span>";
						echo "<a class='pagination-btn' href='$_SERVER[SCRIPT_NAME]?Page=$Num_Pages$pagParams'>$Num_Pages</a>";
					}

					if ($Page != $Num_Pages && $Num_Pages > 1) {
						echo "<a class='pagination-btn' href='$_SERVER[SCRIPT_NAME]?Page=$Next_Page$pagParams'><i class='fas fa-chevron-right'></i></a>";
					}
					?>
				</div>
			</div>
		</div> <!-- so-card -->
	</div> <!-- status-so-page -->

	<!-- JS Helpers for Expandable Rows, Kebab Dropdowns, and Filter Modal -->
		<script>
			function toggleRow(rowKey, triggerEl) {
				// หาแถวรายละเอียดจาก id ที่ PHP สร้างไว้ เช่น row-QOUxxxxx
				const row = document.getElementById(rowKey);

				if (!row) {
					console.error('ไม่พบ expanded row:', rowKey);
					return;
				}

				const isVisible = row.style.display === 'table-row';

				// ปิดรายการสินค้าแถวอื่นทั้งหมด
				document.querySelectorAll('.expanded-row').forEach(function(r) {
					if (r !== row) {
						r.style.display = 'none';
					}
				});

				// เอาสถานะ expanded ของแถวอื่นออก
				document.querySelectorAll('.so-row').forEach(function(r) {
					if (r !== triggerEl) {
						r.classList.remove('is-expanded');
					}
				});

				// เปิด/ปิดรายการสินค้าของแถวที่กด
				if (isVisible) {
					row.style.display = 'none';
					triggerEl.classList.remove('is-expanded');
				} else {
					row.style.display = 'table-row';
					triggerEl.classList.add('is-expanded');
				}
			}

			function toggleDropdown(event, dropdownId) {
				event.stopPropagation();
				const menu = document.getElementById(dropdownId);

				// ปิดเมนูตัวอื่นทั้งหมดก่อน
				document.querySelectorAll('.so-dropdown-menu').forEach(m => {
					if (m !== menu) m.classList.remove('show');
				});

				if (menu) {
					const isShowing = menu.classList.contains('show');
					if (!isShowing) {
						const trigger = event.currentTarget;
						const rect = trigger.getBoundingClientRect();

						// ตั้งค่าให้เป็น fixed
						menu.style.position = 'fixed';

						// วัดขนาดความกว้างของเมนู (ปกติ 186px)
						menu.style.display = 'block';
						const menuWidth = menu.offsetWidth || 186;
						menu.style.display = '';

						// คำนวณตำแหน่ง Top และ Left (ให้อิงจากขอบขวาของปุ่ม trigger)
						const top = rect.bottom;
						let left = rect.right - menuWidth;

						// ป้องกันไม่ให้เมนูหลุดออกนอกขอบหน้าจอด้านซ้าย/ขวา
						if (left < 10) {
							left = 10;
						}
						if (left + menuWidth > window.innerWidth - 10) {
							left = window.innerWidth - menuWidth - 10;
						}

						menu.style.top = top + 'px';
						menu.style.left = left + 'px';
					}
					menu.classList.toggle('show');
				}
			}

			document.addEventListener('click', function(event) {
				if (!event.target.closest('.so-dropdown')) {
					document.querySelectorAll('.so-dropdown-menu').forEach(m => m.classList.remove('show'));
				}
			});

			window.addEventListener('scroll', function() {
				document.querySelectorAll('.so-dropdown-menu').forEach(m => m.classList.remove('show'));
			}, true);

			function openFilterModal() {
				document.getElementById('filterModal').style.display = 'block';
			}

			function closeFilterModal() {
				document.getElementById('filterModal').style.display = 'none';
			}

			function resetFilters() {
				const fields = ['start_date', 'end_date', 'sale_code', 'status_approve', 'type_jong', 'status_jong'];
				fields.forEach(id => {
					const el = document.getElementById(id);
					if (el) el.value = '';
				});
				document.forms['frmSearch'].submit();
			}

			function updateFilterBadge() {
				const fields = ['start_date', 'end_date', 'sale_code', 'status_approve', 'type_jong', 'status_jong'];
				const count = fields.filter(id => {
					const el = document.getElementById(id);
					return el && el.value !== '';
				}).length;
				const badge = document.getElementById('filterBadge');
				if (badge) {
					if (count > 0) {
						badge.textContent = count;
						badge.style.display = 'inline-block';
					} else {
						badge.style.display = 'none';
					}
				}
			}

			// Initialize badge count from current GET params on page load
			document.addEventListener('DOMContentLoaded', function() {
				updateFilterBadge();
			});
		</script>
</body>

</html>