<?php
include('head.php');
include('dbconnect.php');
include('dbconnect_sale.php');
?>
<link rel="stylesheet" href="css/so-status-ui.css?v=<?php echo filemtime(__DIR__ . '/css/so-status-ui.css'); ?>">
<link rel="stylesheet" href="css/register-receive.css?v=<?php echo filemtime(__DIR__ . '/css/register-receive.css'); ?>">
<script src="js/receive-history.js?v=<?php echo filemtime(__DIR__ . '/js/receive-history.js'); ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
	.so-dropdown-trigger {
		color: #8E8B94;
		background: transparent;
		border: none;
		cursor: pointer;
		padding: 8px;
		font-size: 16px;
		transition: color 0.2s ease;
	}

	.so-dropdown-trigger:hover,
	.so-dropdown-trigger.is-active {
		color: #612989 !important;
	}

	.so-dropdown-menu {
		width: 200px;
		border-radius: 12px;
		box-shadow: 0px 8px 24px rgba(0, 0, 0, 0.12);
		border: 1px solid #EDE9F0;
		overflow: hidden;
		padding: 0;
		background: #FFFFFF;
	}

	.so-dropdown-item {
		color: #3B3B3B;
		padding: 12px 18px;
		font-size: 15px;
		font-weight: 400;
		display: flex;
		align-items: center;
		gap: 14px;
		border-bottom: 1px solid #F0EEF2;
		transition: background-color 0.2s ease, color 0.2s ease;
		text-decoration: none;
		font-family: 'Prompt', sans-serif !important;
	}

	.so-dropdown-item:last-child {
		border-bottom: none;
	}

	.so-dropdown-item svg {
		width: 20px;
		height: 20px;
		flex-shrink: 0;
		color: #3B3B3B;
		transition: color 0.2s ease;
	}

	.so-dropdown-item:hover {
		background-color: #612989 !important;
		color: #FFFFFF !important;
		text-decoration: none;
	}

	.so-dropdown-item:hover i,
	.so-dropdown-item:hover svg {
		color: #FFFFFF !important;
	}

	@media (max-width: 640px) {
		.track-modal-info-grid {
			grid-template-columns: 1fr !important;
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

	<?php
	$Keyword        = isset($_GET['Keyword'])        ? trim($_GET['Keyword'])        : '';
	$start_date     = isset($_GET['start_date'])     ? trim($_GET['start_date'])     : '';
	$end_date       = isset($_GET['end_date'])       ? trim($_GET['end_date'])       : '';
	$sale_code      = isset($_GET['sale_code'])      ? trim($_GET['sale_code'])      : '';
	$status_approve = isset($_GET['status_approve']) ? trim($_GET['status_approve']) : '';
	$rental_status  = isset($_GET['rental_status'])  ? trim($_GET['rental_status'])  : '';

	/* =========================================================
					   สิทธิ์การมองเห็นเอกสาร
					   ========================================================= */

					$emid = isset($_SESSION['code']) ? trim($_SESSION['code']) : '';
					$type_login = isset($_SESSION['type_login']) ? trim($_SESSION['type_login']) : '';

					$emid_safe = mysqli_real_escape_string($conn, $emid);
					$type_login_lower = strtolower($type_login);

					$sddd = "1";

					/* IT / Admin / Owner : เห็นเอกสารทั้งหมด */
					if (in_array($type_login_lower, array('it', 'admin', 'owner'), true)) {

						$sddd = "1";

					/* Sale : เห็นเฉพาะ sale_code ของตัวเอง */
					} else if ($type_login_lower == 'sale') {

						$sddd = "sale_code = '" . $emid_safe . "'";

					/* Engineer / SUP_EN : เห็นเฉพาะเขต EN */
					} else if ($emid == 'SUP_EN' || $type_login_lower == 'engineer') {

						$sddd = "sale_code LIKE '%EN%'";

					/* SOL : ใช้สิทธิ์กลุ่ม SOL เดิม */
					} else if ($type_login_lower == 'sol') {

						$sddd = "sale_code IN (
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

								if (
									isset($row_permission['sale_code']) &&
									trim($row_permission['sale_code']) != ''
								) {

									$sale_permission[] =
										"'" .
										mysqli_real_escape_string(
											$conn,
											trim($row_permission['sale_code'])
										) .
										"'";
								}
							}
						}

						if (!empty($sale_permission)) {

							$sddd = "sale_code IN (" . implode(',', $sale_permission) . ")";

						} else {

							/*
							 * ไม่มีสิทธิ์ในตาราง = ไม่ให้เห็นเอกสาร
							 */
							$sddd = "1=0";
						}
					}
	?>

	<div class="status-so-page">
		<div class="so-card">
			<div class="w3-container w3-bar w3-margin-bottom" style="padding-left:0; padding-right:0;">
				<h4 style="margin:0;">Status ใบสั่งเช่า</h4>
			</div>

			<form name="frmSearch" id="frmSearch" method="GET" action="<?php echo htmlspecialchars($_SERVER['SCRIPT_NAME']); ?>">
				<!-- Keep modal values in main form when submitting via keyword -->
				<input type="hidden" name="start_date" id="main_start_date" value="<?php echo htmlspecialchars($start_date); ?>">
				<input type="hidden" name="end_date" id="main_end_date" value="<?php echo htmlspecialchars($end_date); ?>">
				<input type="hidden" name="sale_code" id="main_sale_code" value="<?php echo htmlspecialchars($sale_code); ?>">
				<input type="hidden" name="status_approve" id="main_status_approve" value="<?php echo htmlspecialchars($status_approve); ?>">
				<input type="hidden" name="rental_status" id="main_rental_status" value="<?php echo htmlspecialchars($rental_status); ?>">

				<div class="so-input-group" style="align-items: flex-end; margin-bottom: 20px;">
					<div style="flex: 1; max-width: 680px; min-width: 250px; display: flex; flex-direction: column; gap: 6px;">
						<label for="Keyword" style="font-size: 14px; color: #612989; font-weight: 500;">ค้นหาด้วยเลขที่เอกสาร/ชื่อผู้เช่า</label>
						<div style="display: flex; gap: 12px; align-items: center;">
							<div class="so-search-wrapper" style="flex: 1; width: auto;">
								<i class="fas fa-search so-search-icon"></i>
								<input name="Keyword" id="Keyword" class="so-input" type="text" placeholder="ค้นหา..." value="<?php echo htmlspecialchars($Keyword); ?>">
							</div>
							<a href="register_suprental.php" class="btn-so-outline" style="flex-shrink: 0; font-weight: 500;">
								<img src="img/icons/add_message.png" alt="" style="width: 16px; height: 16px; vertical-align: middle; margin-right: 6px;"> เพิ่มใบสั่งเช่า
							</a>
						</div>
					</div>
					<button type="button" class="btn-so-secondary" id="filterBtn" onclick="openFilterModal()">
						<i class="fas fa-filter"></i> Filters
						<span id="filterBadge" style="display:none; background:#612989; color:#fff; border-radius:50%; width:20px; height:20px; font-size:11px; line-height:20px; text-align:center; margin-left:6px; font-weight:700; vertical-align:middle;"></span>
					</button>
				</div>
				<!-- Filter Modal -->
				<div id="filterModal" class="w3-modal so-figma-filter-modal" style="display:none; z-index:9999;">
					<div class="w3-modal-content so-figma-filter-content">
						<div class="w3-container so-figma-filter-body">
							<div class="so-modal-header">
								<h5 style="margin:0; font-weight:600; color:#3B3B3B; font-size:20px;">Filters</h5>
								<button type="button" class="so-figma-modal-close" onclick="closeFilterModal()" aria-label="ปิด">
									<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
										<line x1="18" y1="6" x2="6" y2="18"></line>
										<line x1="6" y1="6" x2="18" y2="18"></line>
									</svg>
								</button>
							</div>

							<div class="so-form-row">
								<div>
									<label class="so-label" for="modal_start_date">ตั้งแต่วันที่</label>
									<div class="so-input-wrapper calendar-wrapper">
										<input type="date" name="modal_start_date" id="modal_start_date" class="so-select so-modal-input" value="<?php echo htmlspecialchars($start_date); ?>">
									</div>
								</div>
								<div>
									<label class="so-label" for="modal_end_date">ถึงวันที่</label>
									<div class="so-input-wrapper calendar-wrapper">
										<input type="date" name="modal_end_date" id="modal_end_date" class="so-select so-modal-input" value="<?php echo htmlspecialchars($end_date); ?>">
									</div>
								</div>
							</div>

							<div class="so-form-row" style="align-items: flex-start;">
								<div>
									<label class="so-label" for="modal_rental_status">สถานะใบสั่งเช่า</label>
									<select name="modal_rental_status" id="modal_rental_status" class="so-select">
										<option value="">Select</option>
										<option value="active" <?php echo ($rental_status == 'active') ? 'selected' : ''; ?>>กำลังเช่า</option>
										<option value="closed" <?php echo ($rental_status == 'closed') ? 'selected' : ''; ?>>ปิดการเช่าสินค้า</option>
									</select>
								</div>
								<div>
									<label class="so-label" for="modal_status_approve">สถานะการอนุมัติ</label>
									<select name="modal_status_approve" id="modal_status_approve" class="so-select">
										<option value="">Select</option>
										<option value="รอหัวหน้า" <?php echo ($status_approve == 'รอหัวหน้า' || $status_approve == 'Request') ? 'selected' : ''; ?>>รอหัวหน้า</option>
										<option value="ส่งกลับ" <?php echo ($status_approve == 'ส่งกลับ') ? 'selected' : ''; ?>>ส่งกลับ</option>
										<option value="รอผู้บริหาร" <?php echo ($status_approve == 'รอผู้บริหาร') ? 'selected' : ''; ?>>รอผู้บริหาร</option>
										<option value="ไม่อนุมัติ" <?php echo ($status_approve == 'ไม่อนุมัติ' || $status_approve == 'Rejected') ? 'selected' : ''; ?>>ไม่อนุมัติ</option>
										<option value="อนุมัติแล้ว" <?php echo ($status_approve == 'อนุมัติแล้ว' || $status_approve == 'Approve') ? 'selected' : ''; ?>>อนุมัติแล้ว</option>
										<option value="ยกเลิก" <?php echo ($status_approve == 'ยกเลิก') ? 'selected' : ''; ?>>ยกเลิก</option>
										<option value="ร่าง" <?php echo ($status_approve == 'ร่าง' || $status_approve == 'Draft') ? 'selected' : ''; ?>>ร่าง</option>
									</select>
								</div>
							</div>

							<div class="so-form-row so-form-row-single" style="align-items: flex-start;">
	<div>
		<label class="so-label" for="modal_sale_code">เขตการขาย</label>

		<?php
		$emid = isset($_SESSION['code']) ? trim($_SESSION['code']) : '';
		$type_login = isset($_SESSION['type_login']) ? trim($_SESSION['type_login']) : '';

		$type_login_lower = strtolower($type_login);
		$emid_safe = mysqli_real_escape_string($com, $emid);
		?>

		<?php if ($type_login_lower == 'sale') { ?>

			<!-- Sale ล็อกเขตของตัวเอง -->
			<input
				type="hidden"
				name="modal_sale_code"
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

			<?php

			/* Admin / IT / Owner เห็นทั้งหมด */
			if (
				$type_login_lower == 'admin' ||
				$type_login_lower == 'it' ||
				$type_login_lower == 'owner'
			) {

				$saleQuery = "
					SELECT sale_code, sale_name
					FROM tb_team_adm
					ORDER BY sale_code ASC
				";

			}

			/* Engineer / SUP_EN */
			else if (
				$emid == 'SUP_EN' ||
				$type_login_lower == 'engineer'
			) {

				$saleQuery = "
					SELECT sale_code, sale_name
					FROM tb_team_adm
					WHERE sale_code LIKE '%EN%'
					ORDER BY sale_code ASC
				";

			}

			/* SOL */
			else if ($type_login_lower == 'sol') {

				$saleQuery = "
					SELECT sale_code, sale_name
					FROM tb_team_adm
					WHERE sale_code IN (
						'SOL1',
						'SOL2',
						'SOL3',
						'SOL4',
						'SOL5',
						'SOL6',
						'SOL7',
						'SOL8',
						'SOL9',
						'SOL0',
						'SM1'
					)
					ORDER BY sale_code ASC
				";

			}

			/* User อื่น ดูสิทธิ์จาก user_sale_permission */
			else {

				$saleQuery = "
					SELECT DISTINCT
						t.sale_code,
						t.sale_name
					FROM tb_team_adm t

					INNER JOIN user_sale_permission p
						ON p.sale_code COLLATE utf8mb3_general_ci
						 =
						   t.sale_code COLLATE utf8mb3_general_ci

					WHERE p.em_id = '".$emid_safe."'

					ORDER BY t.sale_code ASC
				";

			}

			?>

			<select
				name="modal_sale_code"
				id="modal_sale_code"
				class="so-select"
			>
				<option value="">Select</option>

				<?php
				$objQuerySale = mysqli_query($com, $saleQuery);

				if ($objQuerySale) {

					while ($objResuutSale = mysqli_fetch_assoc($objQuerySale)) {

						$sel = (
							isset($sale_code) &&
							$sale_code == $objResuutSale['sale_code']
						)
							? 'selected'
							: '';
				?>

						<option
							value="<?php echo htmlspecialchars(
								$objResuutSale['sale_code'],
								ENT_QUOTES,
								'UTF-8'
							); ?>"
							<?php echo $sel; ?>
						>
							<?php echo htmlspecialchars(
								$objResuutSale['sale_code'],
								ENT_QUOTES,
								'UTF-8'
							); ?>
							-
							<?php echo htmlspecialchars(
								$objResuutSale['sale_name'],
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

							<div class="so-modal-footer">
								<button type="button" class="btn-filter-submit" onclick="applyFilters()">ตกลง</button>
								<button type="button" class="btn-filter-reset" onclick="resetFilters()">
									<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
										<path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path>
										<path d="M3 3v5h5"></path>
									</svg>
									รีเซ็ต
								</button>
							</div>
						</div>
					</div>
				</div>
			</form>

			<?php
			date_default_timezone_set("Asia/Bangkok");

			$strSQL = "SELECT * FROM hos__rental WHERE $sddd ";

			if ($start_date != "") {
				$strSQL .= ' AND (register_date >= "' . mysqli_real_escape_string($conn, $start_date) . '" OR iv_date >= "' . mysqli_real_escape_string($conn, $start_date) . '")';
			}

			if ($end_date != "") {
				$strSQL .= ' AND (register_date <= "' . mysqli_real_escape_string($conn, $end_date) . '" OR iv_date <= "' . mysqli_real_escape_string($conn, $end_date) . '")';
			}

			if ($sale_code != "") {
				$strSQL .= ' AND sale_code = "' . mysqli_real_escape_string($conn, $sale_code) . '"';
			}

			if ($status_approve != "") {
				$safeStatus = mysqli_real_escape_string($conn, $status_approve);
				if ($status_approve == 'Request' || $status_approve == 'รอหัวหน้า') {
					$strSQL .= ' AND (status_doc = "Request" OR status_doc = "รอหัวหน้า")';
				} else if ($status_approve == 'Approve' || $status_approve == 'อนุมัติแล้ว') {
					$strSQL .= ' AND (status_doc = "Approve" OR status_doc = "อนุมัติแล้ว")';
				} else if ($status_approve == 'Rejected' || $status_approve == 'ไม่อนุมัติ') {
					$strSQL .= ' AND (status_doc = "Rejected" OR status_doc = "ไม่อนุมัติ")';
				} else if ($status_approve == 'Draft' || $status_approve == 'ร่าง') {
					$strSQL .= ' AND (status_doc = "Draft" OR status_doc = "ร่าง")';
				} else {
					$strSQL .= ' AND status_doc = "' . $safeStatus . '"';
				}
			}

			if ($rental_status == "active") {
				$strSQL .= " AND NOT EXISTS (SELECT 1 FROM hos__rental_runiv rental_runiv WHERE rental_runiv.ref_idren = hos__rental.ref_id AND rental_runiv.close_ckk = '1')";
			} else if ($rental_status == "closed") {
				$strSQL .= " AND EXISTS (SELECT 1 FROM hos__rental_runiv rental_runiv WHERE rental_runiv.ref_idren = hos__rental.ref_id AND rental_runiv.close_ckk = '1')";
			}

			if ($Keyword != "") {
				$safeKw = mysqli_real_escape_string($conn, $Keyword);
				$strSQL .= " AND (rental_name LIKE '%$safeKw%' OR iv_no LIKE '%$safeKw%' OR ref_id LIKE '%$safeKw%')";
			}

			$objQuery = mysqli_query($conn, $strSQL) or die("Error Query [" . $strSQL . "]");
			$Num_Rows = mysqli_num_rows($objQuery);

			$Per_Page = 20;
			$Page = isset($_GET['Page']) ? (int)$_GET['Page'] : 1;
			if ($Page < 1) $Page = 1;

			$Prev_Page = $Page - 1;
			$Next_Page = $Page + 1;

			$Page_Start = ($Per_Page * $Page) - $Per_Page;
			if ($Num_Rows <= $Per_Page) {
				$Num_Pages = 1;
			} else if (($Num_Rows % $Per_Page) == 0) {
				$Num_Pages = (int)($Num_Rows / $Per_Page);
			} else {
				$Num_Pages = (int)($Num_Rows / $Per_Page) + 1;
			}

			$strSQL .= " ORDER BY id DESC LIMIT $Page_Start, $Per_Page";
			$objQuery = mysqli_query($conn, $strSQL);
			$Page_Num_Rows = $objQuery ? mysqli_num_rows($objQuery) : 0;
			?>

			<div class="so-table-wrapper">
				<table class="so-table">
					<thead>
						<tr>
							<th width="3%"></th>
							<th style="white-space:nowrap;">เลขที่อ้างอิง</th>
							<th style="white-space:nowrap;">วันที่ลงทะเบียน</th>
							<th style="white-space:nowrap;">เลขที่เอกสาร</th>
							<th style="white-space:nowrap;">วันที่ออกเอกสาร</th>
							<th style="white-space:nowrap;">ชื่อผู้เช่า</th>
							<th style="white-space:nowrap;">เขตการขาย</th>
							<th style="white-space:nowrap; text-align:center;">สถานะใบสั่งเช่า</th>
							<th style="white-space:nowrap; width:12%;">สถานะการอนุมัติ</th>
							<th width="5%" style="text-align:center;"></th>
						</tr>
					</thead>
					<tbody>
						<?php if ($Page_Num_Rows === 0) { ?>
							<tr>
								<td colspan="10" style="text-align:center; padding:40px 16px; color:#6B6875;">
									<?php echo ($Num_Rows > 0)
										? 'ไม่พบข้อมูลในหน้านี้ — ลองกลับไปหน้าแรก'
										: 'ไม่พบรายการใบสั่งเช่าที่ตรงกับเงื่อนไข ลองล้างตัวกรองหรือเปลี่ยนคำค้น'; ?>
								</td>
							</tr>
						<?php } ?>

						<?php
						while ($objResult = mysqli_fetch_array($objQuery)) {
							$row_id = "row-" . $objResult["ref_id"];
							$dropdown_id = "dropdown-" . $objResult["ref_id"];
							$row_id_js = htmlspecialchars(json_encode($row_id), ENT_QUOTES, 'UTF-8');
							$dropdown_id_js = htmlspecialchars(json_encode($dropdown_id), ENT_QUOTES, 'UTF-8');
							$ref_id_js = htmlspecialchars(json_encode($objResult["ref_id"]), ENT_QUOTES, 'UTF-8');
							$rental_name_js = htmlspecialchars(json_encode($objResult["rental_name"]), ENT_QUOTES, 'UTF-8');

							// Contract info for tracking modal
							$promis_no_val = !empty($objResult["promis_no"]) ? $objResult["promis_no"] : (!empty($objResult["iv_no"]) ? $objResult["iv_no"] : '-');
							$promis_no_js = htmlspecialchars(json_encode($promis_no_val), ENT_QUOTES, 'UTF-8');

							$raw_promis_date = (!empty($objResult["promis_date"]) && $objResult["promis_date"] != '0000-00-00')
								? $objResult["promis_date"]
								: ((!empty($objResult["start_promis"]) && $objResult["start_promis"] != '0000-00-00')
									? $objResult["start_promis"]
									: ((!empty($objResult["iv_date"]) && $objResult["iv_date"] != '0000-00-00')
										? $objResult["iv_date"]
										: $objResult["register_date"]));

							$promis_date_th_val = (!empty($raw_promis_date) && $raw_promis_date != '0000-00-00')
								? date("d/m/", strtotime($raw_promis_date)) . (date("Y", strtotime($raw_promis_date)) + 543)
								: '-';
							$promis_date_th_js = htmlspecialchars(json_encode($promis_date_th_val), ENT_QUOTES, 'UTF-8');

							$raw_end_promis = (!empty($objResult["end_promis"]) && $objResult["end_promis"] != '0000-00-00') ? $objResult["end_promis"] : '';
							$end_promis_th_val = (!empty($raw_end_promis) && $raw_end_promis != '0000-00-00')
								? date("d/m/", strtotime($raw_end_promis)) . (date("Y", strtotime($raw_end_promis)) + 543)
								: '-';
							$end_promis_th_js = htmlspecialchars(json_encode($end_promis_th_val), ENT_QUOTES, 'UTF-8');

							// Query close_ckk from hos__rental_runiv
							$strSQL12 = "SELECT close_ckk FROM hos__rental_runiv WHERE ref_idren = '" . mysqli_real_escape_string($conn, $objResult['ref_id']) . "' LIMIT 1";
							$objQuery12 = mysqli_query($conn, $strSQL12);
							$objResult12 = $objQuery12 ? mysqli_fetch_array($objQuery12) : null;
							$close_ckk = $objResult12 ? $objResult12["close_ckk"] : '0';
						?>
							<tr class="so-row" onclick="toggleRow(<?php echo $row_id_js; ?>, this)">
								<td style="text-align:center;">
									<img src="img/icons/arrow_down.png" class="caret-icon" style="width:12px; height:12px;" alt="">
								</td>
								<td>
									<a href="register_suprental.php?ref_id=<?php echo urlencode($objResult["ref_id"]); ?>&start_date=<?php echo urlencode($start_date); ?>&end_date=<?php echo urlencode($end_date); ?>" style="color:#612989; text-decoration:underline; font-weight:500;">
										<?php echo htmlspecialchars($objResult["ref_id"]); ?>
									</a>
								</td>
								<td><?php echo DateThai($objResult["register_date"]); ?></td>
								<td><?php echo htmlspecialchars($objResult["iv_no"]); ?></td>
								<td>
									<?php
									if ($objResult["iv_date"] == "0000-00-00" || empty($objResult["iv_date"])) {
										echo "-";
									} else {
										echo DateThai($objResult["iv_date"]);
									}
									?>
								</td>
								<td>
									<div align="left"><?php echo htmlspecialchars($objResult["rental_name"]); ?></div>
								</td>
								<td>
									<div align="center"><?php echo htmlspecialchars($objResult["sale_code"]); ?></div>
								</td>
								<td style="text-align:center;">
									<?php if ($close_ckk == '1') { ?>
										<img src="img/icons/close_rental.png" alt="ปิดการเช่าสินค้า" title="ปิดการเช่าสินค้า" style="width:28px; height:28px; vertical-align:middle;">
									<?php } else { ?>
										<img src="img/icons/load_rental.png" alt="อยู่ระหว่างการเช่าสินค้า" title="อยู่ระหว่างการเช่าสินค้า" style="width:28px; height:28px; vertical-align:middle;">
									<?php } ?>
								</td>
								<td>
									<?php if ($objResult["status_doc"] == 'Rejected' || $objResult["status_doc"] == 'ไม่อนุมัติ') { ?>
										<span class="badge-status rejected">ไม่อนุมัติ</span>
									<?php } else if ($objResult["status_doc"] == 'ยกเลิก') { ?>
										<span class="badge-status cancel">ยกเลิก</span>
									<?php } else if ($objResult["status_doc"] == 'Approve' || $objResult["status_doc"] == 'อนุมัติแล้ว') { ?>
										<span class="badge-status approve">อนุมัติแล้ว</span>
									<?php } else if ($objResult["status_doc"] == 'Request' || $objResult["status_doc"] == 'รอหัวหน้า') { ?>
										<span class="badge-status pending-mgr">รอหัวหน้า</span>
									<?php } else if ($objResult["status_doc"] == 'Draft' || $objResult["status_doc"] == 'ร่าง') { ?>
										<span class="badge-status draft">ร่าง</span>
									<?php } else if ($objResult["status_doc"] == 'ส่งกลับ') { ?>
										<span class="badge-status returned">ส่งกลับ</span>
									<?php } else if (!empty($objResult["status_doc"])) { ?>
										<span class="badge-status draft"><?php echo htmlspecialchars($objResult["status_doc"]); ?></span>
									<?php } else { ?>
										-
									<?php } ?>
								</td>
								<td style="text-align:center; position:relative;">
									<div class="so-dropdown">
										<button type="button" class="so-dropdown-trigger" aria-label="ตัวเลือกเพิ่มเติม" onclick="toggleDropdown(event, <?php echo $dropdown_id_js; ?>)">
											<i class="fas fa-ellipsis-v"></i>
										</button>
										<div id="<?php echo htmlspecialchars($dropdown_id); ?>" class="so-dropdown-menu">
											<!-- 1. แก้ไข -->
											<a href="register_suprental.php?ref_id=<?php echo urlencode($objResult["ref_id"]); ?>&start_date=<?php echo urlencode($start_date); ?>&end_date=<?php echo urlencode($end_date); ?>" class="so-dropdown-item">
												<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
													<path d="M12 4H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-6"></path>
													<path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
												</svg>
												<span>แก้ไข</span>
											</a>
											<!-- 2. คัดลอกใบเดิม -->
											<a href="javascript:void(0);" onclick="rtConfirmCopyRental(<?php echo $ref_id_js; ?>)" class="so-dropdown-item">
												<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
													<path d="M4 14H3a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v1"></path>
													<rect x="5" y="5" width="15" height="15" rx="3.5"></rect>
													<line x1="12.5" y1="9" x2="12.5" y2="16"></line>
													<line x1="9" y1="12.5" x2="16" y2="12.5"></line>
												</svg>
												<span>คัดลอกใบเดิม</span>
											</a>
											<!-- 3. Preview -->
											<a href="from_rental.php?ref_id=<?php echo urlencode($objResult["ref_id"]); ?>" class="so-dropdown-item" target="_blank">
												<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
													<path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h5"></path>
													<path d="M13 2v4a2 2 0 0 0 2 2h4"></path>
													<path d="M19 8v3"></path>
													<circle cx="15.5" cy="15.5" r="4"></circle>
													<line x1="18.5" y1="18.5" x2="22" y2="22"></line>
												</svg>
												<span>Preview</span>
											</a>
											<!-- 4. ต่อสัญญาเช่า -->
											<a href="open_rentaliv_sup.php?ref_id=<?php echo urlencode($objResult["ref_id"]); ?>&type=IV" class="so-dropdown-item">
												<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
													<path d="M9 5V3a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"></path>
													<rect x="2" y="5" width="20" height="15" rx="2.5"></rect>
													<polyline points="10.5 9.5 13.5 12.5 10.5 15.5"></polyline>
												</svg>
												<span>ต่อสัญญาเช่า</span>
											</a>
											<!-- 5. ปิดการเช่า -->
											<a href="close_suprental.php?ref_id=<?php echo urlencode($objResult["ref_id"]); ?>" class="so-dropdown-item">
												<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
													<circle cx="12" cy="12" r="9.5"></circle>
													<line x1="8.5" y1="8.5" x2="15.5" y2="15.5"></line>
													<line x1="15.5" y1="8.5" x2="8.5" y2="15.5"></line>
												</svg>
												<span>ปิดการเช่า</span>
											</a>
											<?php if ($objResult["status_doc"] == 'Approve' || $objResult["status_doc"] == 'อนุมัติแล้ว') { ?>
												<!-- คืนสินค้า / ประวัติการคืน — ฟอร์มใบคืนแบบรวม register_receive.php (เฉพาะเอกสารที่อนุมัติแล้ว) แยกจากการปิดการเช่า -->
												<a href="register_receive.php?source_type=rental&source_ref=<?php echo urlencode($objResult["ref_id"]); ?>" class="so-dropdown-item">
													<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
														<polyline points="3 7 3 13 9 13"></polyline>
														<path d="M3 13a9 9 0 1 0 3-7.7L3 8"></path>
													</svg>
													<span>คืนสินค้า</span>
												</a>
												<a href="#" onclick="rcOpenReceiveHistory(event, 'rental', <?php echo $ref_id_js; ?>, <?php echo htmlspecialchars(json_encode((string)$objResult["iv_no"] !== '' ? (string)$objResult["iv_no"] : (string)$objResult["ref_id"], JSON_UNESCAPED_UNICODE), ENT_QUOTES, 'UTF-8'); ?>); return false;" class="so-dropdown-item">
													<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
														<circle cx="12" cy="12" r="9.5"></circle>
														<polyline points="12 7 12 12 15.5 14"></polyline>
													</svg>
													<span>ประวัติการคืน</span>
												</a>
											<?php } ?>
											<!-- 6. การติดตาม -->
											<a href="javascript:void(0);" onclick="openTrackingModal(<?php echo $ref_id_js; ?>, <?php echo $rental_name_js; ?>, <?php echo $promis_no_js; ?>, <?php echo $promis_date_th_js; ?>, <?php echo $end_promis_th_js; ?>)" class="so-dropdown-item">
												<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
													<line x1="3" y1="6" x2="18" y2="6"></line>
													<line x1="3" y1="11" x2="14" y2="11"></line>
													<line x1="3" y1="16" x2="11" y2="16"></line>
													<circle cx="17.5" cy="15.5" r="3.5"></circle>
													<circle cx="17.5" cy="15.5" r="1" fill="currentColor"></circle>
													<line x1="17.5" y1="10" x2="17.5" y2="12"></line>
													<line x1="17.5" y1="19" x2="17.5" y2="21"></line>
													<line x1="12" y1="15.5" x2="14" y2="15.5"></line>
													<line x1="21" y1="15.5" x2="23" y2="15.5"></line>
												</svg>
												<span>การติดตาม</span>
											</a>
										</div>
									</div>
								</td>
							</tr>

							<!-- Expanded Row Details (Child Row) -->
							<?php
							$strSQL1 = "SELECT * FROM (hos__subrental LEFT JOIN tb_product ON hos__subrental.product_ID=tb_product.product_id) WHERE ref_idd = '" . mysqli_real_escape_string($conn, $objResult["ref_id"]) . "' ";
							$objQuery1 = mysqli_query($conn, $strSQL1);
							$is_first = true;
							if ($objQuery1 && mysqli_num_rows($objQuery1) > 0) {
								while ($objResult1 = mysqli_fetch_array($objQuery1)) {
							?>
									<tr class="expanded-row" data-row="<?php echo htmlspecialchars($row_id); ?>" style="display:none; background: #F1E1FF !important;">
										<td></td>
										<td colspan="5" style="padding: 10px 16px !important; font-size: 15px; color: #3B3B3B; text-align: left; vertical-align: middle; border-bottom: 1px solid #EDE9F0;">
											<?php if ($is_first) { ?>
												<strong style="display: block; margin-bottom: 4px;">รายการสินค้า</strong>
											<?php } ?>
											<?php echo htmlspecialchars($objResult1["sol_name"] ?? '-'); ?>
										</td>
										<td colspan="4" style="padding: 10px 16px !important; font-size: 15px; color: #3B3B3B; text-align: center; vertical-align: middle; border-bottom: 1px solid #EDE9F0;">
											<?php if ($is_first) { ?>
												<strong style="display: block; margin-bottom: 4px; text-align: center;">จำนวน</strong>
											<?php } ?>
											<?php echo number_format($objResult1["count"] ?? 0); ?>
										</td>
									</tr>
								<?php
									$is_first = false;
								}
							} else {
								?>
								<tr class="expanded-row" data-row="<?php echo htmlspecialchars($row_id); ?>" style="display:none; background: #F1E1FF !important;">
									<td></td>
									<td colspan="9" style="padding: 12px 16px !important; font-size: 14px; color: #8E8B94; text-align: center;">
										ไม่มีข้อมูลรายการสินค้า
									</td>
								</tr>
							<?php } ?>
						<?php } ?>
					</tbody>
				</table>
			</div>

			<!-- Pagination -->
			<div class="pagination-wrapper">
				<div>
					แสดง <?php echo ($Num_Rows > 0 ? $Page_Start + 1 : 0); ?> ถึง <?php echo min($Page_Start + $Per_Page, $Num_Rows); ?> จาก <?php echo $Num_Rows; ?> รายการ
				</div>
				<div class="pagination-links">
					<?php
					$pagParams = "&Keyword=" . urlencode($Keyword) . "&start_date=" . urlencode($start_date) . "&end_date=" . urlencode($end_date) . "&sale_code=" . urlencode($sale_code) . "&status_approve=" . urlencode($status_approve) . "&rental_status=" . urlencode($rental_status);

					if ($Prev_Page > 0) {
						echo "<a class='pagination-btn' href='{$_SERVER['SCRIPT_NAME']}?Page=$Prev_Page$pagParams'><i class='fas fa-chevron-left'></i></a>";
					}

					$start_p = max(1, $Page - 3);
					$end_p = min($Num_Pages, $Page + 3);

					if ($start_p > 1) {
						echo "<a class='pagination-btn' href='{$_SERVER['SCRIPT_NAME']}?Page=1$pagParams'>1</a>";
						if ($start_p > 2) echo "<span style='padding:4px;'>...</span>";
					}

					for ($p = $start_p; $p <= $end_p; $p++) {
						$activeClass = ($p == $Page) ? 'active' : '';
						echo "<a class='pagination-btn $activeClass' href='{$_SERVER['SCRIPT_NAME']}?Page=$p$pagParams'>$p</a>";
					}

					if ($end_p < $Num_Pages) {
						if ($end_p < $Num_Pages - 1) echo "<span style='padding:4px;'>...</span>";
						echo "<a class='pagination-btn' href='{$_SERVER['SCRIPT_NAME']}?Page=$Num_Pages$pagParams'>$Num_Pages</a>";
					}

					if ($Page < $Num_Pages && $Num_Pages > 1) {
						echo "<a class='pagination-btn' href='{$_SERVER['SCRIPT_NAME']}?Page=$Next_Page$pagParams'><i class='fas fa-chevron-right'></i></a>";
					}
					?>
				</div>
			</div>
		</div>
	</div>

	<!-- Tracking Modal (การติดตามใบสั่งเช่า - Figma Node 651-2337 Parity) -->
	<div id="trackingModal" class="w3-modal" style="display:none; z-index:99999; background:rgba(15, 23, 42, 0.45); backdrop-filter:blur(2px);">
		<div class="w3-modal-content" style="border-radius:16px; max-width:880px; width:92%; display:flex; flex-direction:column; overflow:hidden; margin:35px auto; background:#FFFFFF; box-shadow:0 20px 40px rgba(0,0,0,0.18);">
			<!-- Header -->
			<div style="padding:22px 32px 18px; border-bottom:1px solid #EDE9F0; display:flex; justify-content:space-between; align-items:center;">
				<h5 style="margin:0; font-weight:600; color:#1E293B; font-size:18px; font-family:'Prompt', sans-serif;">
					การติดตาม
				</h5>
				<button type="button" onclick="closeTrackingModal()" aria-label="ปิด" style="background:none; border:none; font-size:24px; cursor:pointer; color:#94A3B8; line-height:1; padding:4px 8px; border-radius:6px; transition:color 0.2s ease;" onmouseover="this.style.color='#475569'" onmouseout="this.style.color='#94A3B8'">&times;</button>
			</div>

			<!-- Body -->
			<div style="padding:24px 32px 28px; overflow-y:auto; max-height:calc(85vh - 75px);">
				<!-- Top Info Grid: เลขที่เอกสาร, เลขที่สัญญา, วันที่สัญญา, วันที่ครบสัญญา -->
				<div class="track-modal-info-grid" style="display:grid; grid-template-columns:repeat(3, 1fr); gap:14px 20px; margin-bottom:28px;">
					<div>
						<label style="display:block; font-size:13px; font-weight:500; color:#612989; margin-bottom:6px;">เลขที่เอกสาร</label>
						<div style="background:#F1F3F5; border-radius:8px; padding:8px 12px; font-size:14px; color:#1E293B; display:flex; justify-content:space-between; align-items:center; min-height:38px;">
							<span id="trackDocRefId" style="font-weight:500;">-</span>
							<i class="fas fa-times" style="color:#A0AEC0; font-size:12px;"></i>
						</div>
					</div>
					<div>
						<label style="display:block; font-size:13px; font-weight:500; color:#612989; margin-bottom:6px;">เลขที่สัญญา</label>
						<div style="background:#F1F3F5; border-radius:8px; padding:8px 12px; font-size:14px; color:#1E293B; display:flex; justify-content:space-between; align-items:center; min-height:38px;">
							<span id="trackPromisNo" style="font-weight:500;">-</span>
							<i class="fas fa-times" style="color:#A0AEC0; font-size:12px;"></i>
						</div>
					</div>
					<div>
						<label style="display:block; font-size:13px; font-weight:500; color:#612989; margin-bottom:6px;">วันที่สัญญา</label>
						<div style="background:#F1F3F5; border-radius:8px; padding:8px 12px; font-size:14px; color:#1E293B; display:flex; justify-content:space-between; align-items:center; min-height:38px;">
							<span id="trackPromisDate">-</span>
							<i class="far fa-calendar-alt" style="color:#718096; font-size:14px;"></i>
						</div>
					</div>
					<div>
						<label style="display:block; font-size:13px; font-weight:500; color:#612989; margin-bottom:6px;">วันที่ครบสัญญา</label>
						<div style="background:#F1F3F5; border-radius:8px; padding:8px 12px; font-size:14px; color:#1E293B; display:flex; justify-content:space-between; align-items:center; min-height:38px;">
							<span id="trackEndPromis">-</span>
							<i class="far fa-calendar-alt" style="color:#718096; font-size:14px;"></i>
						</div>
					</div>
				</div>

				<!-- Tracking Table -->
				<div style="overflow-x:auto;">
					<table style="width:100%; border-collapse:collapse; font-size:14px; font-family:'Prompt', sans-serif;">
						<thead>
							<tr style="border-bottom:2px solid #612989;">
								<th style="padding:10px 12px; color:#612989; font-weight:600; width:105px; text-align:center;">ครั้งที่ติดตาม</th>
								<th style="padding:10px 12px; color:#612989; font-weight:600; width:130px; text-align:left;">วันที่ติดตาม</th>
								<th style="padding:10px 12px; color:#612989; font-weight:600; text-align:left;">การติดตาม</th>
								<th style="padding:10px 12px; color:#612989; font-weight:600; width:120px; text-align:center;">ชื่อผู้ติดตาม</th>
							</tr>
						</thead>
						<tbody id="trackTableBody">
							<!-- Populated via JavaScript -->
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

	<!-- JavaScript Helpers -->
	<script>
		// Global tracking state
		var currentTrackingRefId = '';

		function toggleRow(rowKey, triggerEl) {
			const rows = Array.from(document.querySelectorAll('.expanded-row'))
				.filter(r => r.dataset.row === rowKey);
			const isVisible = rows.length > 0 && rows[0].style.display !== 'none';

			document.querySelectorAll('.expanded-row').forEach(r => {
				if (r.dataset.row !== rowKey) r.style.display = 'none';
			});
			document.querySelectorAll('.so-row').forEach(r => {
				if (r !== triggerEl) r.classList.remove('is-expanded');
			});

			if (isVisible) {
				rows.forEach(row => row.style.display = 'none');
				triggerEl.classList.remove('is-expanded');
			} else {
				rows.forEach(row => row.style.display = 'table-row');
				triggerEl.classList.add('is-expanded');
			}
		}

		function toggleDropdown(event, dropdownId) {
			event.stopPropagation();
			const menu = document.getElementById(dropdownId);
			const trigger = event.currentTarget;

			document.querySelectorAll('.so-dropdown-menu').forEach(m => {
				if (m !== menu) m.classList.remove('show');
			});
			document.querySelectorAll('.so-dropdown-trigger').forEach(btn => {
				if (btn !== trigger) btn.classList.remove('is-active');
			});

			if (menu) {
				const isShowing = menu.classList.contains('show');
				if (!isShowing) {
					const rect = trigger.getBoundingClientRect();

					menu.style.position = 'fixed';
					menu.style.display = 'block';
					menu.style.visibility = 'hidden';
					const menuWidth = menu.offsetWidth || 200;
					const menuHeight = menu.offsetHeight || 280;
					menu.style.display = '';
					menu.style.visibility = '';

					menu.style.zIndex = '99999';

					let left = rect.right - menuWidth;
					if (left < 10) left = 10;
					if (left + menuWidth > window.innerWidth - 10) {
						left = window.innerWidth - menuWidth - 10;
					}

					const spaceBelow = window.innerHeight - rect.bottom;
					let top = rect.bottom + 4;

					// If space below is not enough for the full dropdown, flip upwards (dropup)
					if (spaceBelow < menuHeight + 10 && rect.top > menuHeight + 10) {
						top = rect.top - menuHeight - 4;
					} else if (spaceBelow < menuHeight + 10) {
						top = Math.max(10, window.innerHeight - menuHeight - 10);
					}

					menu.style.top = top + 'px';
					menu.style.left = left + 'px';
					trigger.classList.add('is-active');
				} else {
					trigger.classList.remove('is-active');
				}
				menu.classList.toggle('show');
			}
		}

		document.addEventListener('click', function(event) {
			if (!event.target.closest('.so-dropdown')) {
				document.querySelectorAll('.so-dropdown-menu').forEach(m => m.classList.remove('show'));
				document.querySelectorAll('.so-dropdown-trigger').forEach(btn => btn.classList.remove('is-active'));
			}
		});

		window.addEventListener('scroll', function() {
			document.querySelectorAll('.so-dropdown-menu').forEach(m => m.classList.remove('show'));
			document.querySelectorAll('.so-dropdown-trigger').forEach(btn => btn.classList.remove('is-active'));
		}, true);

		function openFilterModal() {
			document.getElementById('filterModal').style.display = 'block';
		}

		function closeFilterModal() {
			document.getElementById('filterModal').style.display = 'none';
		}

		function applyFilters() {
			document.getElementById('main_start_date').value = document.getElementById('modal_start_date').value;
			document.getElementById('main_end_date').value = document.getElementById('modal_end_date').value;
			document.getElementById('main_sale_code').value = document.getElementById('modal_sale_code').value;
			document.getElementById('main_status_approve').value = document.getElementById('modal_status_approve').value;
			document.getElementById('main_rental_status').value = document.getElementById('modal_rental_status').value;
			document.forms['frmSearch'].submit();
		}

		function resetFilters() {
			document.getElementById('modal_start_date').value = '';
			document.getElementById('modal_end_date').value = '';
			document.getElementById('modal_sale_code').value = '';
			document.getElementById('modal_status_approve').value = '';
			document.getElementById('modal_rental_status').value = '';
			document.getElementById('main_start_date').value = '';
			document.getElementById('main_end_date').value = '';
			document.getElementById('main_sale_code').value = '';
			document.getElementById('main_status_approve').value = '';
			document.getElementById('main_rental_status').value = '';
			document.getElementById('Keyword').value = '';
			document.forms['frmSearch'].submit();
		}

		function updateFilterBadge() {
			const fields = ['main_start_date', 'main_end_date', 'main_sale_code', 'main_status_approve', 'main_rental_status'];
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

		// คัดลอกใบเดิม: ยืนยันด้วย SweetAlert2 แทน confirm() ของเบราว์เซอร์
		function rtConfirmCopyRental(refId) {
			Swal.fire({
				icon: 'question',
				title: 'คัดลอกใบเดิม',
				text: 'ต้องการเพิ่มเอกสารใหม่โดย Copy เอกสารเดิมใช่หรือไม่?',
				showCancelButton: true,
				confirmButtonColor: '#612989',
				cancelButtonColor: '#8E8B94',
				confirmButtonText: 'ยืนยัน',
				cancelButtonText: 'ยกเลิก',
				reverseButtons: true
			}).then(function(result) {
				if (result.isConfirmed) {
					window.location = 'register_suprental.php?copy_from=' + encodeURIComponent(refId);
				}
			});
		}

		// Tracking Modal Functions (Figma Node 651-2337 Parity)
		function openTrackingModal(refId, rentalName, promisNo, promisDate, endPromis) {
			currentTrackingRefId = refId;
			document.getElementById('trackDocRefId').textContent = refId || '-';
			document.getElementById('trackPromisNo').textContent = promisNo || '-';
			document.getElementById('trackPromisDate').textContent = promisDate || '-';
			document.getElementById('trackEndPromis').textContent = endPromis || '-';
			document.getElementById('trackingModal').style.display = 'block';

			// Close any open kebab dropdown
			document.querySelectorAll('.so-dropdown-menu').forEach(m => m.classList.remove('show'));

			loadTrackingHistory(refId);
		}

		function closeTrackingModal() {
			document.getElementById('trackingModal').style.display = 'none';
			currentTrackingRefId = '';
		}

		function escapeHtml(str) {
			return (str || '').toString().replace(/[&<>"']/g, function(m) {
				return {
					'&': '&amp;',
					'<': '&lt;',
					'>': '&gt;',
					'"': '&quot;',
					"'": '&#039;'
				} [m];
			});
		}

		function getTodayThaiShortDate() {
			const now = new Date();
			const day = String(now.getDate()).padStart(2, '0');
			const month = String(now.getMonth() + 1).padStart(2, '0');
			const yearBE = now.getFullYear() + 543;
			const shortYear = String(yearBE).slice(-2);
			return `${day}/${month}/${shortYear}`;
		}

		function loadTrackingHistory(refId) {
			const tbody = document.getElementById('trackTableBody');
			tbody.innerHTML = `
				<tr>
					<td colspan="4" style="text-align:center; padding:32px 16px; color:#8E8B94;">
						<i class="fas fa-spinner fa-spin" style="color:#612989; font-size:22px;"></i>
						<div style="margin-top:8px; font-size:13px;">กำลังโหลดประวัติการติดตาม...</div>
					</td>
				</tr>
			`;

			fetch('ajax_rental_contact.php?action=get&ref_id=' + encodeURIComponent(refId))
				.then(res => res.json())
				.then(res => {
					if (res.success) {
						if (res.doc_info) {
							if (res.doc_info.promis_no && document.getElementById('trackPromisNo').textContent === '-') {
								document.getElementById('trackPromisNo').textContent = res.doc_info.promis_no;
							}
							if (res.doc_info.promis_date_th && document.getElementById('trackPromisDate').textContent === '-') {
								document.getElementById('trackPromisDate').textContent = res.doc_info.promis_date_th;
							}
							if (res.doc_info.end_promis_th && document.getElementById('trackEndPromis').textContent === '-') {
								document.getElementById('trackEndPromis').textContent = res.doc_info.end_promis_th;
							}
						}

						let html = '';
						const list = res.data || [];

						list.forEach((item, index) => {
							html += `
								<tr style="border-bottom:1px solid #F1F3F5;">
									<td style="padding:12px 12px; text-align:center; color:#4A4A4A; vertical-align:middle;">${index + 1}</td>
									<td style="padding:12px 12px; color:#4A4A4A; vertical-align:middle; white-space:nowrap;">${escapeHtml(item.add_date_short || item.add_date_th || item.add_date)}</td>
									<td style="padding:12px 12px; color:#3B3B3B; line-height:1.5; vertical-align:middle; word-break:break-word; white-space:pre-wrap;">${escapeHtml(item.des_con)}</td>
									<td style="padding:12px 12px; text-align:center; color:#4A4A4A; vertical-align:middle;">${escapeHtml(item.add_by)}</td>
								</tr>
							`;
						});

						const nextIndex = list.length + 1;
						html += `
							<tr id="trackNewRow" style="border-bottom:none;">
								<td style="padding:12px 12px; text-align:center; color:#4A4A4A; vertical-align:middle; font-weight:500;">
									${nextIndex}
								</td>
								<td style="padding:12px 12px; vertical-align:middle;">
									<div style="background:#F1F3F5; border-radius:8px; padding:7px 10px; font-size:13px; color:#1E293B; display:inline-flex; align-items:center; gap:8px; white-space:nowrap;">
										<span>${getTodayThaiShortDate()}</span>
										<i class="far fa-calendar-alt" style="color:#718096; font-size:13px;"></i>
									</div>
								</td>
								<td style="padding:12px 12px; vertical-align:middle;">
									<div style="position:relative; width:100%;">
										<input type="text" id="trackInput" class="so-input" placeholder="กรอกข้อความบันทึกการติดตาม..."
										       style="height:38px; padding:6px 34px 6px 12px; font-size:13px; background:#F1F3F5; border:1px solid transparent; border-radius:8px; width:100%; font-family:'Prompt', sans-serif;"
										       onkeydown="if(event.key === 'Enter') { event.preventDefault(); submitTrackingNote(); }">
										<button type="button" onclick="document.getElementById('trackInput').value=''" title="ล้างข้อความ"
										        style="position:absolute; right:8px; top:50%; transform:translateY(-50%); background:none; border:none; color:#A0AEC0; cursor:pointer; padding:4px; font-size:12px; display:flex; align-items:center;">
											<i class="fas fa-times"></i>
										</button>
									</div>
								</td>
								<td style="padding:12px 12px; text-align:center; vertical-align:middle;">
									<button type="button" id="btnSaveTrack" onclick="submitTrackingNote()"
									        style="background:#612989; color:#FFFFFF; border:none; border-radius:20px; padding:7px 18px; font-size:13px; font-weight:500; cursor:pointer; display:inline-flex; align-items:center; gap:6px; box-shadow:0 2px 6px rgba(97,41,137,0.25); transition:all 0.2s ease; font-family:'Prompt', sans-serif;"
									        onmouseover="this.style.background='#522274'" onmouseout="this.style.background='#612989'">
										<i class="fas fa-save"></i>
										<span>บันทึก</span>
									</button>
								</td>
							</tr>
						`;

						tbody.innerHTML = html;
						setTimeout(() => {
							const input = document.getElementById('trackInput');
							if (input) input.focus();
						}, 50);
					} else {
						tbody.innerHTML = `<tr><td colspan="4" style="text-align:center; color:#CF1322; padding:16px;">เกิดข้อผิดพลาด: ${escapeHtml(res.message || 'ไม่สามารถโหลดข้อมูลได้')}</td></tr>`;
					}
				})
				.catch(err => {
					tbody.innerHTML = `<tr><td colspan="4" style="text-align:center; color:#CF1322; padding:16px;">เกิดข้อผิดพลาดในการโหลดข้อมูล: ${escapeHtml(err.message)}</td></tr>`;
				});
		}

		function submitTrackingNote() {
			const inputEl = document.getElementById('trackInput');
			if (!inputEl) return;
			const note = inputEl.value.trim();
			const btn = document.getElementById('btnSaveTrack');

			if (!note) {
				Swal.fire({
					icon: 'warning',
					title: 'กรุณากรอกข้อความ',
					text: 'กรุณากรอกข้อมูลการติดตามก่อนกดบันทึก',
					confirmButtonColor: '#612989',
					confirmButtonText: 'ตกลง'
				});
				return;
			}

			if (btn) {
				btn.disabled = true;
				btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> บันทึก...';
			}

			const formData = new FormData();
			formData.append('action', 'save');
			formData.append('ref_id', currentTrackingRefId);
			formData.append('des_con', note);

			fetch('ajax_rental_contact.php', {
					method: 'POST',
					body: formData
				})
				.then(res => res.json())
				.then(res => {
					if (btn) {
						btn.disabled = false;
						btn.innerHTML = '<i class="fas fa-save"></i> บันทึก';
					}

					if (res.success) {
						Swal.fire({
							icon: 'success',
							title: 'บันทึกสำเร็จ',
							text: 'บันทึกข้อมูลการติดตามเรียบร้อยแล้ว',
							timer: 1500,
							showConfirmButton: false
						});
						loadTrackingHistory(currentTrackingRefId);
					} else {
						Swal.fire({
							icon: 'error',
							title: 'เกิดข้อผิดพลาด',
							text: res.message || 'ไม่สามารถบันทึกข้อมูลได้',
							confirmButtonColor: '#612989',
							confirmButtonText: 'ตกลง'
						});
					}
				})
				.catch(err => {
					if (btn) {
						btn.disabled = false;
						btn.innerHTML = '<i class="fas fa-save"></i> บันทึก';
					}
					Swal.fire({
						icon: 'error',
						title: 'ข้อผิดพลาดการเชื่อมต่อ',
						text: err.message,
						confirmButtonColor: '#612989',
						confirmButtonText: 'ตกลง'
					});
				});
		}

		document.addEventListener('keydown', function(event) {
			if (event.key === 'Escape') {
				if (document.getElementById('filterModal').style.display === 'block') {
					closeFilterModal();
				}
				if (document.getElementById('trackingModal').style.display === 'block') {
					closeTrackingModal();
				}
			}
		});

		document.addEventListener('DOMContentLoaded', function() {
			updateFilterBadge();
		});
	</script>

</body>

</html>