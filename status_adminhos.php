<?php include('head.php');

include "dbconnect.php";
include "dbconnect_sale.php";
?>
<link rel="stylesheet" href="css/so-status-ui.css?v=<?php echo filemtime(__DIR__ . '/css/so-status-ui.css'); ?>">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<style>
/* =========================================================
   DELIVERY MODAL : รายละเอียดเอกสาร
   แก้เฉพาะส่วน Modal เท่านั้น
========================================================= */

.delivery-modal {
    display: none;
    position: fixed;
    inset: 0;
    width: 100%;
    height: 100%;
    z-index: 999999;
    padding: 24px;

    align-items: center;
    justify-content: center;

    font-family: 'Prompt', sans-serif !important;
}

.delivery-modal.is-open {
    display: flex !important;
}

.delivery-modal-backdrop {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    background: rgba(38, 26, 46, 0.42);
    backdrop-filter: blur(1px);
    -webkit-backdrop-filter: blur(1px);
}

.delivery-modal-dialog {
    position: relative;
    z-index: 2;

    width: min(1080px, 100%);
    max-height: calc(100vh - 48px);

    background: #fff;
    border-radius: 14px;
    overflow: hidden;

    box-shadow:
        0 22px 60px rgba(34, 22, 43, 0.24),
        0 4px 16px rgba(34, 22, 43, 0.10);

    animation: deliveryModalIn .18s ease-out;
}

.delivery-modal-scroll {
    max-height: calc(100vh - 48px);
    overflow-y: auto;
    overflow-x: hidden;
    overscroll-behavior: contain;
}

/* scrollbar */
.delivery-modal-scroll::-webkit-scrollbar {
    width: 8px;
}

.delivery-modal-scroll::-webkit-scrollbar-track {
    background: #f5f3f7;
}

.delivery-modal-scroll::-webkit-scrollbar-thumb {
    background: #cfc3d8;
    border-radius: 20px;
}

.delivery-modal-scroll::-webkit-scrollbar-thumb:hover {
    background: #b5a2c4;
}

.delivery-loading {
    min-height: 260px;
    padding: 70px 20px;

    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;

    text-align: center;
    font-family: 'Prompt', sans-serif !important;
    font-size: 14px;
    color: #7c7581;
}

.delivery-loading-icon {
    width: 34px;
    height: 34px;
    margin-bottom: 13px;

    border: 3px solid #eee8f2;
    border-top-color: #612989;
    border-radius: 50%;

    animation: deliverySpin .75s linear infinite;
}

.delivery-modal-error {
    min-height: 260px;
    padding: 55px 30px;

    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;

    text-align: center;
    font-family: 'Prompt', sans-serif !important;
}

.delivery-modal-error-icon {
    width: 46px;
    height: 46px;
    margin-bottom: 13px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 50%;
    background: #fff0f0;
    color: #d93025;

    font-size: 20px;
}

.delivery-modal-error-title {
    margin-bottom: 5px;
    color: #3b3b3b;
    font-size: 16px;
    font-weight: 500;
}

.delivery-modal-error-text {
    color: #8e8b94;
    font-size: 12px;
    line-height: 1.6;
}

@keyframes deliveryModalIn {
    from {
        opacity: 0;
        transform: translateY(12px) scale(.985);
    }

    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

@keyframes deliverySpin {
    to {
        transform: rotate(360deg);
    }
}

@media (max-width: 768px) {
    .delivery-modal {
        padding: 12px;
        align-items: flex-start;
    }

    .delivery-modal-dialog {
        width: 100%;
        max-height: calc(100vh - 24px);
        margin-top: 0;
        border-radius: 12px;
    }

    .delivery-modal-scroll {
        max-height: calc(100vh - 24px);
    }
}
</style>

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
			<div class="w3-container w3-bar w3-margin-bottom" style="padding-left:0px; padding-right:0px;">
				<h4 style="margin:0px;">Status SO</h4>
			</div>

			<?php
			$Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';
			$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
			$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
			$sale_code = isset($_GET['sale_code']) ? $_GET['sale_code'] : '';
			$status_doc = isset($_GET['status_doc']) ? $_GET['status_doc'] : '';
			$type_doc = isset($_GET['type_doc']) ? $_GET['type_doc'] : '';
			$have_order = isset($_GET['have_order']) ? $_GET['have_order'] : '';
			$no_iv = isset($_GET['no_iv']) ? $_GET['no_iv'] : '';
			$is_deposit = isset($_GET['is_deposit']) ? $_GET['is_deposit'] : '';
			$scriptName = htmlspecialchars($_SERVER['SCRIPT_NAME'], ENT_QUOTES, 'UTF-8');
			?>

			<form name="frmSearch" method="GET" action="<?php echo $scriptName; ?>" id="mainSearchForm">
				<!-- preserve modal filter values as hidden fields in main search -->
				<input type="hidden" name="start_date" value="<?php echo htmlspecialchars($start_date); ?>">
				<input type="hidden" name="end_date" value="<?php echo htmlspecialchars($end_date); ?>">
				<input type="hidden" name="sale_code" value="<?php echo htmlspecialchars($sale_code); ?>">
				<input type="hidden" name="status_doc" value="<?php echo htmlspecialchars($status_doc); ?>">
				<input type="hidden" name="type_doc" value="<?php echo htmlspecialchars($type_doc); ?>">
				<input type="hidden" name="have_order" value="<?php echo htmlspecialchars($have_order); ?>">
				<input type="hidden" name="no_iv" value="<?php echo htmlspecialchars($no_iv); ?>">
				<input type="hidden" name="is_deposit" value="<?php echo htmlspecialchars($is_deposit); ?>">

				<div class="so-input-group" style="align-items: flex-end; margin-bottom: 20px;">
					<!-- Left: Search Wrapper + Label + Add Button -->
					<div style="flex: 1; max-width: 680px; min-width: 250px; display: flex; flex-direction: column; gap: 6px;">
						<div style="font-size: 14px; color: #612989; font-weight: 500; font-family: 'Prompt', sans-serif !important;">
							ค้นหาด้วยเลขที่เอกสาร/ชื่อออกบิล
						</div>
						<div style="display: flex; gap: 12px; align-items: center;">
							<div class="so-search-wrapper" style="flex: 1; width: auto;">
								<i class="fas fa-search so-search-icon"></i>
								<input name="Keyword" class="so-input" type="text" id="Keyword" placeholder="Search" value="<?php echo htmlspecialchars($Keyword); ?>">
							</div>

							<!-- + เพิ่มใบสั่งขาย button (next to Search Input) -->
							<a href="register_suphos.php" class="btn-so-outline" style="text-decoration:none; flex-shrink: 0;">
								<img src="img/icons/add_message.png" alt="" style="width: 16px; height: 16px; vertical-align: middle; margin-right: 6px;"> เพิ่มใบสั่งขาย
							</a>
						</div>
					</div>

					<!-- Right: Filters Button -->
					<button type="button" class="btn-so-secondary" onclick="openFilterModal()">
						<i class="fas fa-filter"></i> Filters
					</button>
				</div>
			</form>

			<!-- Filter Modal -->
			<div id="filterModal" class="w3-modal" style="display:none; z-index:9999;">
				<div class="w3-modal-content w3-card-4" role="dialog" aria-modal="true" aria-labelledby="filterModalTitle" style="border-radius:16px; max-width:640px;">
					<div class="w3-container" style="padding:32px;">
						<form method="GET" action="<?php echo $scriptName; ?>" id="modalFilterForm">
							<!-- hidden keyword field synced from main search -->
							<input type="hidden" name="Keyword" id="modalKeyword" value="<?php echo htmlspecialchars($Keyword); ?>">

							<div class="so-modal-header" style="border-bottom: none; padding-bottom: 0; margin-bottom: 24px;">
								<h5 id="filterModalTitle" style="margin:0; font-weight:600; color:#3B3B3B; font-size:20px; font-family: 'Prompt', sans-serif !important;">Filters</h5>
								<button type="button" onclick="closeFilterModal()" aria-label="ปิดหน้าต่างตัวกรอง" style="background:none; border:none; padding:0; font-size:28px; cursor:pointer; color:#8E8B94; line-height: 1;">&times;</button>
							</div>

							<!-- Row 1: Dates -->
							<div class="so-form-row">
								<div>
									<label class="so-label">ตั้งแต่วันที่</label>
									<div class="so-input-wrapper calendar-wrapper">
										<input type="date" name="start_date" id="modal_start_date" class="so-select so-modal-input" value="<?php echo htmlspecialchars($start_date); ?>">
									</div>
								</div>
								<div>
									<label class="so-label">ถึงวันที่</label>
									<div class="so-input-wrapper calendar-wrapper">
										<input type="date" name="end_date" id="modal_end_date" class="so-select so-modal-input" value="<?php echo htmlspecialchars($end_date); ?>">
									</div>
								</div>
							</div>

							<!-- Row 2: Status & Type -->
							<div class="so-form-row">
								<div>
									<label class="so-label">สถานะการอนุมัติ</label>
									<select name="status_doc" id="modal_status_doc" class="so-select">
										<option value="">Select</option>
										<option value="รอหัวหน้า" <?php if ($status_doc == 'รอหัวหน้า') echo 'selected'; ?>>รอหัวหน้า</option>
										<option value="ส่งกลับ" <?php if ($status_doc == 'ส่งกลับ') echo 'selected'; ?>>ส่งกลับ</option>
										<option value="รอผู้บริหาร" <?php if ($status_doc == 'รอผู้บริหาร') echo 'selected'; ?>>รอผู้บริหาร</option>
										<option value="Rejected" <?php if ($status_doc == 'Rejected') echo 'selected'; ?>>ไม่อนุมัติ</option>
										<option value="Approve" <?php if ($status_doc == 'Approve') echo 'selected'; ?>>อนุมัติแล้ว</option>
										<option value="ยกเลิก" <?php if ($status_doc == 'ยกเลิก') echo 'selected'; ?>>ยกเลิก</option>
										<option value="Draft" <?php if ($status_doc == 'Draft') echo 'selected'; ?>>Draft</option>
									</select>
								</div>
								<div>
									<label class="so-label">ประเภท</label>
									<select name="type_doc" id="modal_type_doc" class="so-select">
										<option value="">Select</option>
										<option value="1" <?php if ($type_doc == '1') echo 'selected'; ?>>ใบสั่งขาย</option>
										<option value="2" <?php if ($type_doc == '2') echo 'selected'; ?>>ใบสั่งขาย E-Tax</option>
										<option value="3" <?php if ($type_doc == '3') echo 'selected'; ?>>ใบฝากขาย (IC)</option>
										<!-- <option value="4" <?php if ($type_doc == '4') echo 'selected'; ?>>ใบกำกับอิเล็กทรอนิกส์ (IE)</option> -->
									</select>
								</div>
							</div>

							<!-- Row 3: Sales Channel & Zone -->
							<div class="so-form-row">
								<div>
									<label class="so-label">ช่องทางการขาย</label>
									<select name="have_order" id="modal_have_order" class="so-select">
										<option value="">Select</option>
										<option value="1" <?php if ($have_order == '1') echo 'selected'; ?>>Shoppee / Lazada (API)</option>
										<option value="0" <?php if ($have_order == '0') echo 'selected'; ?>>Normal Order</option>
									</select>
								</div>
								<div>
	<label class="so-label">เขตการขาย (Sale)</label>

	<?php

	$emid = isset($_SESSION['code']) ? trim($_SESSION['code']) : '';
	$type_login = isset($_SESSION['type_login']) ? trim($_SESSION['type_login']) : '';

	$type_login_lower = strtolower($type_login);

	?>

	<?php if ($type_login_lower == 'sale') { ?>

		<!-- Sale ล็อกเขตเป็นของตัวเอง -->
		<input
			type="hidden"
			name="sale_code"
			id="modal_sale_code"
			value="<?php echo htmlspecialchars($emid, ENT_QUOTES, 'UTF-8'); ?>"
		>

		<input
			type="text"
			class="so-select"
			value="<?php echo htmlspecialchars($emid, ENT_QUOTES, 'UTF-8'); ?>"
			readonly
			style="background:#f5f5f5; cursor:not-allowed;"
		>

	<?php } else { ?>

		<select name="sale_code" id="modal_sale_code" class="so-select">
			<option value="">Select</option>

			<?php

			$emid_safe = mysqli_real_escape_string($com, $emid);

			/* Admin / IT / Owner เห็นทั้งหมด */
			if (
				$type_login_lower == 'admin' ||
				$type_login_lower == 'it' ||
				$type_login_lower == 'owner'
			) {

				$strSQL5 = "
					SELECT *
					FROM tb_team_adm
					ORDER BY sale_code ASC
				";

			}

			/* Engineer */
			else if (
				$emid == 'SUP_EN' ||
				$type_login_lower == 'engineer'
			) {

				$strSQL5 = "
					SELECT *
					FROM tb_team_adm
					WHERE sale_code LIKE '%EN%'
					ORDER BY sale_code ASC
				";

			}

			/* SOL */
			else if ($type_login_lower == 'sol') {

				$strSQL5 = "
					SELECT *
					FROM tb_team_adm
					WHERE sale_code IN (
						'SOL1','SOL2','SOL3','SOL4','SOL5',
						'SOL6','SOL7','SOL8','SOL9','SOL0','SM1'
					)
					ORDER BY sale_code ASC
				";

			}

			/* User อื่น อ่านจาก user_sale_permission */
			else {

				$strSQL5 = "
	SELECT DISTINCT t.*
	FROM tb_team_adm t
	INNER JOIN user_sale_permission p
		ON p.sale_code COLLATE utf8mb3_general_ci
		 = t.sale_code COLLATE utf8mb3_general_ci
	WHERE p.em_id = '".$emid_safe."'
	ORDER BY t.sale_code ASC
";

			}


			$objQuery5 = mysqli_query($com, $strSQL5);

			if ($objQuery5) {

				while ($objResuut5 = mysqli_fetch_array($objQuery5)) {

					$selected = '';

					if ($sale_code == $objResuut5["sale_code"]) {
						$selected = 'selected';
					}

			?>

				<option
					value="<?php echo htmlspecialchars(
						$objResuut5["sale_code"],
						ENT_QUOTES,
						'UTF-8'
					); ?>"
					<?php echo $selected; ?>
				>
					<?php echo htmlspecialchars(
						$objResuut5["sale_code"],
						ENT_QUOTES,
						'UTF-8'
					); ?>
					-
					<?php echo htmlspecialchars(
						$objResuut5["sale_name"],
						ENT_QUOTES,
						'UTF-8'
					); ?>
				</option>

			<?php
				}
			}
			?>

		</select>

	<?php } ?>

</div>
							</div>

							<!-- Row 4: Pills Toggles -->
							<div class="so-form-pills" style="display: flex; gap: 12px; margin-top: 8px; margin-bottom: 24px;">
								<input type="hidden" name="no_iv" id="modal_no_iv" value="<?php echo htmlspecialchars($no_iv); ?>">
								<button type="button" id="pill_no_iv" class="filter-pill <?php echo ($no_iv == '1') ? 'active' : ''; ?>" onclick="toggleFilterPill('no_iv')">
									รอใส่เลขที่เอกสาร
								</button>
								<input type="hidden" name="is_deposit" id="modal_is_deposit" value="<?php echo htmlspecialchars($is_deposit); ?>">
								<button type="button" id="pill_is_deposit" class="filter-pill <?php echo ($is_deposit == '1') ? 'active' : ''; ?>" onclick="toggleFilterPill('is_deposit')">
									ใบฝาก
								</button>
							</div>

							<!-- Footer Buttons -->
							<div class="so-modal-footer">
								<button type="submit" class="btn-filter-submit" onclick="syncKeyword()">ตกลง</button>
								<button type="button" class="btn-filter-reset" onclick="resetFilters()">
									<i class="fas fa-sync-alt" style="margin-right: 6px;"></i> รีเซ็ต
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>

			<script>
				function openFilterModal() {
					document.getElementById('filterModal').style.display = 'block';
					document.getElementById('modal_start_date').focus();
				}

				function closeFilterModal() {
					document.getElementById('filterModal').style.display = 'none';
				}

				document.addEventListener('keydown', function(event) {
					if (event.key === 'Escape' && document.getElementById('filterModal').style.display === 'block') {
						closeFilterModal();
					}
				});

				function syncKeyword() {
					document.getElementById('modalKeyword').value = document.getElementById('Keyword').value;
				}

				function toggleFilterPill(fieldId) {
					const input = document.getElementById('modal_' + fieldId);
					const pill = document.getElementById('pill_' + fieldId);
					if (input.value === '1') {
						input.value = '';
						pill.classList.remove('active');
					} else {
						input.value = '1';
						pill.classList.add('active');
					}
				}

				function resetFilters() {
					document.getElementById('modal_start_date').value = '';
					document.getElementById('modal_end_date').value = '';
					document.getElementById('modal_status_doc').value = '';
					document.getElementById('modal_sale_code').value = '';
					document.getElementById('modal_type_doc').value = '';
					document.getElementById('modal_have_order').value = '';
					document.getElementById('modal_no_iv').value = '';
					document.getElementById('modal_is_deposit').value = '';
					document.getElementById('Keyword').value = '';
					document.getElementById('modalKeyword').value = '';
					document.getElementById('modalFilterForm').submit();
				}
			</script>

			<div class="so-table-wrapper so-table-wrapper--fit">
				<table class="so-table so-table-fit so-table-fit--fixed" id="soTable">
					<thead>
						<tr>
							<th width="3%"></th>
							<th width="3%"></th>
							<th width="9%">เลขที่อ้างอิง</th>
							<th width="10%">เลขที่เอกสาร</th>
							<th width="11%">วันที่ออกเอกสาร</th>
							<th width="20%">ชื่อออกบิล</th>
							<th width="13%">เขตการขาย</th>
							<th width="9%">สถานะลูกค้า</th>
							<th width="10%">ยอดรวม</th>
							<th width="12%">สถานะการอนุมัติ</th>
							<th width="3%"></th>
						</tr>
					</thead>
					<tbody>

						<?php
						date_default_timezone_set("Asia/Bangkok");
						$to_day = date('Y-m-d');

						/* =========================================================
						   สิทธิ์การมองเห็นเอกสาร
						   ========================================================= */
						$emid = isset($_SESSION['code']) ? trim($_SESSION['code']) : '';
						$type_login = isset($_SESSION['type_login']) ? trim($_SESSION['type_login']) : '';

						$emid_safe = mysqli_real_escape_string($conn, $emid);
						$type_login_lower = strtolower($type_login);

						$sddd = "";

						/* IT / Admin / Owner : เห็นทั้งหมด */
						if (in_array($type_login_lower, array('it', 'admin', 'owner'), true)) {

							$sddd = "";

						/* Sale : เห็นเฉพาะ sale_code ของตัวเอง */
						} else if ($type_login_lower == 'sale') {

							$sddd = " AND sale_code = '" . $emid_safe . "'";

						/* Engineer / SUP_EN : เห็นเฉพาะเขต EN */
						} else if ($emid == 'SUP_EN' || $type_login_lower == 'engineer') {

							$sddd = " AND sale_code LIKE '%EN%'";

						/* SOL : ใช้สิทธิ์กลุ่ม SOL เดิม */
						} else if ($type_login_lower == 'sol') {

							$sddd = " AND sale_code IN (
								'SOL1','SOL2','SOL3','SOL4','SOL5',
								'SOL6','SOL7','SOL8','SOL9','SOL0','SM1'
							)";

						/* User อื่น ๆ : อ่านสิทธิ์จาก user_sale_permission */
						} else {

							$sql_permission = "
								SELECT sale_code
								FROM user_sale_permission
								WHERE em_id = '" . $emid_safe . "'
							";

							$query_permission = mysqli_query($conn, $sql_permission);

							$sale_permission = array();

							if ($query_permission) {
								while ($row_permission = mysqli_fetch_assoc($query_permission)) {
									if (isset($row_permission['sale_code']) && trim($row_permission['sale_code']) != '') {
										$sale_permission[] = "'" . mysqli_real_escape_string(
											$conn,
											trim($row_permission['sale_code'])
										) . "'";
									}
								}
							}

							if (!empty($sale_permission)) {
								$sddd = " AND sale_code IN (" . implode(',', $sale_permission) . ")";
							} else {
								/*
								 * ไม่มีสิทธิ์ในตาราง = ไม่เห็นเอกสาร
								 * ป้องกันกรณี User ยังไม่ได้กำหนดสิทธิ์แล้วเห็นทั้งหมด
								 */
								$sddd = " AND 1=0";
							}
						}

						$strSQL = "SELECT * FROM hos__so WHERE 1" . $sddd;

						if ($start_date != "") {
							$strSQL .= ' AND date_so >= "' . mysqli_real_escape_string($conn, $start_date) . '"';
						}

						if ($end_date != "") {
							$strSQL .= ' AND date_so <= "' . mysqli_real_escape_string($conn, $end_date) . '"';
						}

						if ($sale_code != "") {
							$strSQL .= ' AND sale_code = "' . mysqli_real_escape_string($conn, $sale_code) . '"';
						}

						if ($status_doc != "") {
							// Sup อนุมัติแล้วแต่ status_doc ยังค้างเป็น 'Request' โดยตั้ง send_cm='1' (ส่งบัญชี) หรือ '2' (IC ส่งอนุมัติต่อ)
							// จึงต้องแยกด้วย send_cm ให้ตรงกับป้ายสถานะด้านล่าง
							if ($status_doc == 'รอหัวหน้า') {
								$strSQL .= ' AND (status_doc = "รอหัวหน้า" OR (status_doc = "Request" AND (send_cm IS NULL OR send_cm NOT IN ("1", "2"))))';
							} else if ($status_doc == 'รอผู้บริหาร') {
								$strSQL .= ' AND (status_doc = "รอผู้บริหาร" OR (status_doc = "Request" AND send_cm IN ("1", "2")))';
							} else {
								$strSQL .= ' AND status_doc = "' . mysqli_real_escape_string($conn, $status_doc) . '"';
							}
						}

						if ($type_doc != "") {
							if ($type_doc == '1') {
								// เอกสาร IE ระบุด้วย prefix iv_no เท่านั้น (et_ckk/ic_ckk เป็น 0 เหมือนใบสั่งขายปกติ)
								// จึงต้องกันออกจากกลุ่มนี้ ไม่งั้นจะถูกนับเป็นใบสั่งขายทั่วไป
								$strSQL .= ' AND (et_ckk = "0" OR et_ckk IS NULL OR et_ckk = "") AND (ic_ckk = "0" OR ic_ckk IS NULL OR ic_ckk = "") AND (iv_no IS NULL OR iv_no NOT LIKE "IE%")';
							} else if ($type_doc == '2') {
								$strSQL .= ' AND et_ckk = "1"';
							} else if ($type_doc == '3') {
								$strSQL .= ' AND ic_ckk = "1"';
							} else if ($type_doc == '4') {
								$strSQL .= ' AND iv_no LIKE "IE%"';
							}
						}

						if ($have_order != "") {
							$strSQL .= ' AND have_order = "' . mysqli_real_escape_string($conn, $have_order) . '"';
						}

						if ($no_iv == "1") {
							$strSQL .= ' AND (iv_no = "" OR iv_no IS NULL)';
						}

						if ($is_deposit == "1") {
							$strSQL .= ' AND have_order = "1" AND (have_product = "0" OR have_product IS NULL OR have_product = "")';
						}

						if ($Keyword != "") {
							$escKeyword = mysqli_real_escape_string($conn, $Keyword);
							$strSQL .= ' AND (bill_name LIKE "%' . $escKeyword . '%"';
							$strSQL .= ' OR brnp_no LIKE "%' . $escKeyword . '%"';
							$strSQL .= ' OR cm_no LIKE "%' . $escKeyword . '%"';
							$strSQL .= ' OR iv_no LIKE "%' . $escKeyword . '%"';
							$strSQL .= ' OR ref_id LIKE "%' . $escKeyword . '%"';
							$strSQL .= ' OR order_refer_code LIKE "%' . $escKeyword . '%"';
							$strSQL .= ' OR po_no LIKE "%' . $escKeyword . '%")';
						}

						// Count total rows before LIMIT (COUNT(*) instead of fetching every row)
						$countSQL = "SELECT COUNT(*) AS cnt" . substr($strSQL, strlen("SELECT *"));
						$objQueryCount = mysqli_query($conn, $countSQL) or die("Error Query [" . $countSQL . "]");
						$rsCount = mysqli_fetch_assoc($objQueryCount);
						$Num_Rows = (int)$rsCount['cnt'];

						$Per_Page = 20;
						$Page = isset($_GET['Page']) ? (int)$_GET['Page'] : 1;
						if ($Page < 1) $Page = 1;

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

						$strSQL .= " ORDER BY id DESC LIMIT $Page_Start, $Per_Page";
						$objQuery = mysqli_query($conn, $strSQL) or die("Error Query [" . $strSQL . "]");

						$i = 1;
						while ($objResult = mysqli_fetch_array($objQuery)) {
							$ref_id = $objResult['ref_id'];
							$ref_id_url = urlencode($ref_id);
							$row_id = "row-" . $ref_id;
							$dropdown_id = "dropdown-" . $ref_id;
							// json_encode ต้องผ่าน htmlspecialchars ด้วย มิฉะนั้น double quote ที่ครอบ string
							// จะไปปิด attribute onclick ก่อนกำหนด
							$row_id_js = htmlspecialchars(json_encode($row_id), ENT_QUOTES, 'UTF-8');
							$dropdown_id_js = htmlspecialchars(json_encode($dropdown_id), ENT_QUOTES, 'UTF-8');

							// Check Customer VIP Status
							$sqlCustomer = "SELECT vip_ckk FROM tb_customer WHERE customer_id = '" . mysqli_real_escape_string($conn, $objResult["bill_id"]) . "'";
							$qryCustomer = mysqli_query($conn, $sqlCustomer);
							$rsCustomer = mysqli_fetch_assoc($qryCustomer);
							$vip_status = ($rsCustomer && $rsCustomer['vip_ckk'] == '1') ? 'VIP' : '-';

							// Calculate SO Total Amount
							$sqlTotal = "SELECT SUM(amount) AS total_amount FROM hos__subso WHERE ref_idd = '" . mysqli_real_escape_string($conn, $objResult["ref_id"]) . "'";
							$qryTotal = mysqli_query($conn, $sqlTotal);
							$rsTotal = mysqli_fetch_assoc($qryTotal);
							$total_amount = $rsTotal && $rsTotal['total_amount'] ? number_format($rsTotal['total_amount'], 2) : '0.00';

							// Get prefix of iv_no for conditional actions
							$iv_prefix = substr($objResult['iv_no'], 0, 2);

							// Determine bill name display based on have_order
							$bill_name_display = '';
							$bill_name_display = $objResult["bill_name"];


							// Map status_doc to class and display text
							$status_class = '';
							$status_text = '';
							if ($objResult["status_doc"] == 'Approve' || $objResult["status_doc"] == 'อนุมัติแล้ว') {
								$status_class = 'approve';
								$status_text = 'อนุมัติแล้ว';
							} else if ($objResult["status_doc"] == 'Draft' || empty($objResult["status_doc"])) {
								$status_class = '';
								$status_text = '';
							} else if ($objResult["status_doc"] == 'Rejected' || $objResult["status_doc"] == 'ไม่อนุมัติ') {
								$status_class = 'rejected';
								$status_text = 'ไม่อนุมัติ';
							} else if ($objResult["status_doc"] == 'ยกเลิก') {
								$status_class = 'cancel';
								$status_text = 'ยกเลิก';
							} else if ($objResult["status_doc"] == 'รอหัวหน้า' || ($objResult["status_doc"] == 'Request' && !in_array((string)$objResult["send_cm"], ['1', '2'], true))) {
								$status_class = 'pending-mgr';
								$status_text = 'รอหัวหน้า';
							} else if ($objResult["status_doc"] == 'รอผู้บริหาร' || $objResult["status_doc"] == 'Request') {
								// เหลือเฉพาะ Request ที่ send_cm='1'/'2' = Sup อนุมัติแล้ว รอผู้บริหาร
								$status_class = 'pending-exec';
								$status_text = 'รอผู้บริหาร';
							} else if ($objResult["status_doc"] == 'ส่งกลับ' || $objResult["status_doc"] == 'Returned') {
								$status_class = 'returned';
								$status_text = 'ส่งกลับ';
							} else {
								$status_text = htmlspecialchars($objResult["status_doc"]);
							}

						?>
							<!-- Main Row -->
							<tr class="so-row" role="button" tabindex="0" aria-expanded="false" onclick="toggleRow(<?php echo $row_id_js; ?>, this)">
								<td style="text-align:center; vertical-align:middle;">
									<img src="img/icons/arrow_down.png" class="caret-icon" alt="">
								</td>
								<td style="text-align:center; vertical-align:middle;">
									<?php if ($objResult["que_ckk"] == '1') { ?>
										<i class="fas fa-bolt" style="color: #FA8C16; font-size: 20px;" title="รายการด่วน"></i>
									<?php } ?>
								</td>
								<td>
									<a href="register_suphos.php?ref_id=<?php echo $ref_id_url; ?>" style="color:#612989; text-decoration:underline; font-weight:500;"><?php echo htmlspecialchars($objResult["ref_id"]); ?></a>
								</td>
								<td><?php echo htmlspecialchars($objResult["iv_no"]); ?></td>
								<td><?php echo DateThai($objResult["date_so"]); ?></td>
								<td>
									<div align="left"><?php echo htmlspecialchars($bill_name_display); ?></div>
								</td>
								<td><?php echo htmlspecialchars($objResult["sale_code"]); ?></td>
								<td>
									<?php if ($vip_status == 'VIP') { ?>
										<span><img src="img/icons/vip.png" alt="" style="width: 24px; height: 20px; margin-right: 4px; vertical-align: middle;">VIP</span>
									<?php } else { ?>
										-
									<?php } ?>
								</td>
								<td><?php echo $total_amount; ?></td>
								<td>
									<?php if (!empty($status_text)) { ?>
										<span class="badge-status <?php echo $status_class; ?>">
											<?php echo $status_text; ?>
										</span>
									<?php } else { ?>
										-
									<?php } ?>
								</td>
								<td style="text-align:center; vertical-align:middle; position:relative;">
									<div class="so-dropdown">
										<button type="button" class="so-dropdown-trigger" aria-label="ตัวเลือกเพิ่มเติม" aria-haspopup="true" aria-expanded="false" onclick="toggleDropdown(event, <?php echo $dropdown_id_js; ?>)">
											<i class="fas fa-ellipsis-v"></i>
										</button>
										<div id="<?php echo htmlspecialchars($dropdown_id); ?>" class="so-dropdown-menu">
											<!-- แก้ไข -->
											<a href="register_suphos.php?ref_id=<?php echo $ref_id_url; ?>&start_date=<?php echo urlencode($start_date); ?>&end_date=<?php echo urlencode($end_date); ?>" class="so-dropdown-item">
												<i class="fas fa-edit" style="width:16px;"></i> แก้ไข
											</a>

											<!-- คัดลอกใบเดิม -->
											<a href="register_suphos.php?copy_from=<?php echo $ref_id_url; ?>" onclick="return confirmNav(event, this, 'ต้องการเพิ่มเอกสารใหม่โดยCopyเอกสารเดิมใช่หรือไม่')" class="so-dropdown-item">
												<i class="fas fa-copy" style="width:16px;"></i> คัดลอกใบเดิม
											</a>

											<!-- Preview -->
											<?php
											$preview_url = ($objResult['type_doc'] == '4') ? 'report_salehosnbm2.php' : 'report_salehosptl1.php';
											?>
											<a href="<?php echo $preview_url; ?>?ref_id=<?php echo $ref_id_url; ?>" target="_blank" class="so-dropdown-item">
												<i class="fas fa-search" style="width:16px;"></i> Preview
											</a>
											
	<a href="javascript:void(0);"
   class="so-dropdown-item"
   onclick='return openDeliveryModal(
       event,
       <?php echo json_encode(
           $ref_id,
           JSON_UNESCAPED_UNICODE | JSON_HEX_APOS | JSON_HEX_QUOT
       ); ?>
   );'>

    <img src="img/icons/icon-delivery.svg"
         alt=""
         style="width:16px; height:16px; object-fit:contain; margin-right:6px; vertical-align:middle;">

    รายละเอียดเอกสาร
</a>
											

											<!-- ใบกำกับภาษี ET/IE -->
											<?php if ($objResult['et_ckk'] == '1') {
												$ivv = substr($objResult['iv_no'], 0, 2);
												$report_url = ($ivv == 'ET') ? 'report_EThos.php' : 'report_IEhos.php';
											?>
												<a href="<?php echo $report_url; ?>?ref_id=<?php echo $ref_id_url; ?>" target="_blank" class="so-dropdown-item">
													<i class="fas fa-file-invoice-dollar" style="width:16px;"></i> ใบกำกับภาษี ET/IE
												</a>
											<?php } ?>

											<!-- ใบส่งสินค้า -->
											<?php
							if (in_array($type_login_lower, array('it', 'admin', 'owner'), true)) {
							if ($objResult['send_admin'] == '1') { ?>
												<a href="register_receivepro_so.php?ref_id=<?php echo $ref_id_url; ?>" onclick="return confirmNav(event, this, 'ต้องการสร้างใบส่งสินค้าใช่หรือไม่')" class="so-dropdown-item">
													<i class="fas fa-truck" style="width:16px;"></i> ใบส่งสินค้า
												</a>
											<?php }
							}
											?>

											<!-- สร้างใบลดหนี้ -->
											<?php if ($objResult['send_admin'] == '1') { ?>
												<a href="register_credinot.php?ref_id=<?php echo $ref_id_url; ?>" onclick="return confirmNav(event, this, 'ต้องการสร้างใบสั่งลดหนี้ใช่หรือไม่')" class="so-dropdown-item">
													<i class="fas fa-file-invoice" style="width:16px;"></i> สร้างใบลดหนี้
												</a>
											<?php } ?>
										</div>
									</div>
								</td>
							</tr>

							<!-- Expanded Row Detail -->
							<tr id="<?php echo htmlspecialchars($row_id); ?>" class="expanded-row" style="display:none;">
								<td colspan="11">
									<div class="expanded-container">
										<!-- Left: Items Sub-table -->
										<div class="expanded-products-card">
											<table class="sub-table">
												<thead>
													<tr>
														<th width="40%">รายการสินค้า</th>
														<th width="20%">เคลียร์ของ/ยืม</th>
														<th width="5%" style="text-align:center;">จำนวน</th>
														<th width="10%" style="text-align:right !important;">ราคา/หน่วย</th>
														<th width="10%" style="text-align:right !important;">ส่วนลด/หน่วย</th>
														<th width="15%" style="text-align:right !important;">ยอดรวม/สินค้า</th>
													</tr>
												</thead>
												<tbody>
													<?php
													$sqlSub = "SELECT * FROM hos__subso LEFT JOIN tb_product ON hos__subso.product_ID=tb_product.product_id WHERE ref_idd = '" . mysqli_real_escape_string($conn, $objResult["ref_id"]) . "'";
													$qrySub = mysqli_query($conn, $sqlSub);
													$subRowsCount = mysqli_num_rows($qrySub);

													if ($subRowsCount > 0) {
														while ($subResult = mysqli_fetch_array($qrySub)) {
															$item_name = $subResult['sol_name'] ?? '-';
															$clear_status = '-';
															$clear_values = [];
															if (trim($subResult['clear_ivno']) != '') {
																$clear_values[] = htmlspecialchars($subResult['clear_ivno']);
															}
															if (trim($subResult['jong_no']) != '') {
																$clear_values[] = htmlspecialchars($subResult['jong_no']);
															}
															if (!empty($clear_values)) {
																$clear_status = '<i class="fas fa-check-circle" style="color:#389E0D; margin-right: 6px;"></i><span style="color:#3B3B3B;">' . implode(' / ', $clear_values) . '</span>';
															}
													?>
															<tr>
																<td><?php echo htmlspecialchars($item_name); ?></td>
																<td><?php echo $clear_status; ?></td>
																<td style="text-align:center;"><?php echo (int)$subResult['count']; ?></td>
																<td style="text-align:right;"><?php echo number_format($subResult['price'], 2); ?></td>
																<td style="text-align:right;"><?php echo number_format($subResult['discount'], 2); ?></td>
																<td style="text-align:right;"><?php echo number_format($subResult['amount'], 2); ?></td>
															</tr>
														<?php
														}
														?>
														<tr style="border-top: 1px solid #EDE9F0;">
															<td colspan="5" style="text-align:right; font-weight:500; padding: 14px 12px !important; font-size: 14px; color: #3B3B3B;">ยอดรวม</td>
															<td style="text-align:right; font-size:16px; color:#612989; font-weight:600; padding: 14px 12px !important;"><?php echo $total_amount; ?></td>
														</tr>
													<?php
													} else {
													?>
														<tr>
															<td colspan="6" style="text-align:center; color:#8E8B94; padding:20px;">ไม่มีข้อมูลรายการสินค้า</td>
														</tr>
													<?php
													}
													?>
												</tbody>
											</table>
										</div>
									</div>
								</td>
							</tr>
						<?php
							$i++;
						}
						?>

					</tbody>
				</table>
			</div>

			<!-- Pagination Restyling -->
			<div class="pagination-wrapper">
				<div>
					พบทั้งหมด <strong><?php echo $Num_Rows; ?></strong> รายการ (หน้าที่ <?php echo $Page; ?> จาก <?php echo $Num_Pages; ?> หน้า)
				</div>
				<div class="pagination-links">
					<?php
					$pagParams = "&Keyword=" . urlencode($Keyword) . "&start_date=" . urlencode($start_date) . "&end_date=" . urlencode($end_date) . "&sale_code=" . urlencode($sale_code) . "&status_doc=" . urlencode($status_doc) . "&type_doc=" . urlencode($type_doc) . "&have_order=" . urlencode($have_order) . "&no_iv=" . urlencode($no_iv) . "&is_deposit=" . urlencode($is_deposit);

					if ($Prev_Page) {
						echo "<a class='pagination-btn' aria-label='หน้าก่อนหน้า' href='$scriptName?Page=$Prev_Page$pagParams'><i class='fas fa-chevron-left'></i></a>";
					}

					// Show maximum of 7 page links for better responsiveness
					$start_p = max(1, $Page - 3);
					$end_p = min($Num_Pages, $Page + 3);

					if ($start_p > 1) {
						echo "<a class='pagination-btn' href='$scriptName?Page=1$pagParams'>1</a>";
						if ($start_p > 2) echo "<span style='padding:4px;'>...</span>";
					}

					for ($p = $start_p; $p <= $end_p; $p++) {
						$activeClass = ($p == $Page) ? 'active' : '';
						echo "<a class='pagination-btn $activeClass' href='$scriptName?Page=$p$pagParams'>$p</a>";
					}

					if ($end_p < $Num_Pages) {
						if ($end_p < $Num_Pages - 1) echo "<span style='padding:4px;'>...</span>";
						echo "<a class='pagination-btn' href='$scriptName?Page=$Num_Pages$pagParams'>$Num_Pages</a>";
					}

					if ($Page != $Num_Pages && $Num_Pages > 1) {
						echo "<a class='pagination-btn' aria-label='หน้าถัดไป' href='$scriptName?Page=$Next_Page$pagParams'><i class='fas fa-chevron-right'></i></a>";
					}
					?>
				</div>
			</div>

		</div>
	</div>

	<script>
		function toggleRow(rowId, triggerEl) {
			// Toggle expanded row display
			const row = document.getElementById(rowId);
			const isVisible = row.style.display !== 'none';

			// Hide all other expanded rows for clean layout (optional)
			document.querySelectorAll('.expanded-row').forEach(r => {
				if (r.id !== rowId) {
					r.style.display = 'none';
				}
			});
			document.querySelectorAll('.so-row').forEach(r => {
				if (r !== triggerEl) {
					r.classList.remove('is-expanded');
					r.setAttribute('aria-expanded', 'false');
				}
			});

			// Toggle clicked row
			if (isVisible) {
				row.style.display = 'none';
				triggerEl.classList.remove('is-expanded');
				triggerEl.setAttribute('aria-expanded', 'false');
			} else {
				row.style.display = 'table-row';
				triggerEl.classList.add('is-expanded');
				triggerEl.setAttribute('aria-expanded', 'true');
			}
		}

		// Keyboard: Enter/Space บนแถวทำงานเหมือนคลิก
		document.addEventListener('keydown', function(event) {
			if ((event.key === 'Enter' || event.key === ' ') && event.target.classList && event.target.classList.contains('so-row')) {
				event.preventDefault();
				event.target.click();
			}
		});

		function toggleDropdown(event, dropdownId) {
			event.stopPropagation(); // Prevent row click expansion

			const trigger = event.currentTarget;
			const menu = document.getElementById(dropdownId);
			if (!menu) return;

			const isCurrentlyOpen = menu.classList.contains('show');

			// Close all other dropdowns
			document.querySelectorAll('.so-dropdown-menu').forEach(m => {
				m.classList.remove('show');
			});
			document.querySelectorAll('.so-dropdown-trigger').forEach(t => {
				t.setAttribute('aria-expanded', 'false');
			});

			if (!isCurrentlyOpen) {
				menu.classList.add('show');
				trigger.setAttribute('aria-expanded', 'true');

				const rect = trigger.getBoundingClientRect();
				menu.style.display = 'block';
				const menuWidth = menu.offsetWidth || 186;
				const menuHeight = menu.offsetHeight || 190;
				menu.style.display = '';

				const spaceBelow = window.innerHeight - rect.bottom;

				menu.style.position = 'fixed';
				menu.style.zIndex = '99999';

				let left = rect.right - menuWidth;
				if (left < 10) left = 10;
				if (left + menuWidth > window.innerWidth - 10) {
					left = window.innerWidth - menuWidth - 10;
				}
				menu.style.left = left + 'px';

				if (spaceBelow < menuHeight + 10 && rect.top > menuHeight) {
					menu.style.top = (rect.top - menuHeight - 4) + 'px';
				} else {
					menu.style.top = (rect.bottom + 4) + 'px';
				}
			}
		}

		// ยืนยันด้วย Swal ก่อนเปลี่ยนหน้าไปยัง href ของลิงก์ (คงไว้ให้คลิกขวา/เปิดแท็บใหม่ได้)
		function confirmNav(event, link, text) {
			event.preventDefault();
			event.stopPropagation();
			document.querySelectorAll('.so-dropdown-menu').forEach(m => {
				m.classList.remove('show');
			});
			document.querySelectorAll('.so-dropdown-trigger').forEach(t => {
				t.setAttribute('aria-expanded', 'false');
			});

			Swal.fire({
				text: text,
				icon: 'question',
				showCancelButton: true,
				confirmButtonColor: '#612989',
				cancelButtonColor: '#8a8a8a',
				confirmButtonText: 'ยืนยัน',
				cancelButtonText: 'ยกเลิก'
			}).then(function(result) {
				if (result.isConfirmed) {
					window.location.href = link.href;
				}
			});
			return false;
		}

		// Close dropdowns when clicking anywhere outside
		document.addEventListener('click', function(event) {
			if (!event.target.closest('.so-dropdown')) {
				document.querySelectorAll('.so-dropdown-menu').forEach(m => {
					m.classList.remove('show');
				});
				document.querySelectorAll('.so-dropdown-trigger').forEach(t => {
					t.setAttribute('aria-expanded', 'false');
				});
			}
		});

		window.addEventListener('scroll', function() {
			document.querySelectorAll('.so-dropdown-menu.show').forEach(m => {
				m.classList.remove('show');
			});
			document.querySelectorAll('.so-dropdown-trigger').forEach(t => {
				t.setAttribute('aria-expanded', 'false');
			});
		}, true);
		
		
		// =========================================================
		// รายละเอียดเอกสาร : Delivery Modal
		// =========================================================

		function openDeliveryModal(event, refId) {

			if (event) {
				event.preventDefault();
				event.stopPropagation();
			}

			/* ปิด dropdown action */
			document.querySelectorAll('.so-dropdown-menu').forEach(function(menu) {
				menu.classList.remove('show');
				menu.style.display = '';
			});

			document.querySelectorAll('.so-dropdown-trigger').forEach(function(btn) {
				btn.setAttribute('aria-expanded', 'false');
			});


			var modal = document.getElementById('deliveryModal');
			var content = document.getElementById('deliveryModalContent');

			if (!modal || !content) {
				console.error('Delivery modal element not found');
				return false;
			}


			/* แสดง Loading ก่อนยิง AJAX */
			content.innerHTML =
				'<div class="delivery-loading">' +
					'<div class="delivery-loading-icon"></div>' +
					'<div>กำลังโหลดรายละเอียดเอกสาร...</div>' +
				'</div>';


			/* เปิด Modal */
			modal.classList.add('is-open');
			modal.setAttribute('aria-hidden', 'false');

			document.body.style.overflow = 'hidden';


			/* โหลดรายละเอียด */
			fetch(
				'ajax_delivery_cs.php?ref_id=' + encodeURIComponent(refId),
				{
					method: 'GET',
					credentials: 'same-origin',
					cache: 'no-store',
					headers: {
						'X-Requested-With': 'XMLHttpRequest'
					}
				}
			)
			.then(function(response) {

				if (!response.ok) {
					throw new Error('HTTP ' + response.status);
				}

				return response.text();

			})
			.then(function(html) {

				if (!html || !html.trim()) {
					throw new Error('ไม่พบข้อมูลที่ส่งกลับจาก ajax_delivery_cs.php');
				}

				content.innerHTML = html;

				/* เลื่อน Modal กลับด้านบนทุกครั้งที่เปิดรายการใหม่ */
				var scrollBox = modal.querySelector('.delivery-modal-scroll');

				if (scrollBox) {
					scrollBox.scrollTop = 0;
				}

			})
			.catch(function(error) {

				console.error('Delivery AJAX Error:', error);

				content.innerHTML =
					'<div class="delivery-modal-error">' +
						'<div class="delivery-modal-error-icon">' +
							'<i class="fas fa-exclamation"></i>' +
						'</div>' +
						'<div class="delivery-modal-error-title">' +
							'ไม่สามารถโหลดรายละเอียดเอกสารได้' +
						'</div>' +
						'<div class="delivery-modal-error-text">' +
							(error && error.message ? error.message : 'เกิดข้อผิดพลาดในการโหลดข้อมูล') +
						'</div>' +
					'</div>';

			});

			return false;
		}


		function closeDeliveryModal() {

			var modal = document.getElementById('deliveryModal');

			if (!modal) {
				return;
			}

			modal.classList.remove('is-open');
			modal.setAttribute('aria-hidden', 'true');

			document.body.style.overflow = '';
		}


		/* ESC ปิด Modal */
		document.addEventListener('keydown', function(event) {

			if (event.key !== 'Escape') {
				return;
			}

			var modal = document.getElementById('deliveryModal');

			if (modal && modal.classList.contains('is-open')) {
				closeDeliveryModal();
			}

		});
		
		
		
		
		
		
	</script>

	<!-- <div id="cr_bar"> <?php include "foot.php"; ?></div> -->
	
	
<!-- =====================================================
     DELIVERY MODAL : รายละเอียดเอกสาร
===================================================== -->

<div id="deliveryModal"
     class="delivery-modal"
     aria-hidden="true">

    <div class="delivery-modal-backdrop"
         onclick="closeDeliveryModal()"></div>

    <div class="delivery-modal-dialog"
         role="dialog"
         aria-modal="true"
         aria-label="รายละเอียดเอกสาร"
         onclick="event.stopPropagation();">

        <div class="delivery-modal-scroll">

            <div id="deliveryModalContent">

                <div class="delivery-loading">
                    <div class="delivery-loading-icon"></div>
                    <div>กำลังโหลดรายละเอียดเอกสาร...</div>
                </div>

            </div>

        </div>

    </div>

</div>

</div>	
	
	
</body>

</html>