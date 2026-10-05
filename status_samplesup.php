<?php
require_once __DIR__ . '/includes/smp_repo.php';

include('head.php');

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
				<h4 style="margin:0;">รายการใบเบิกสินค้าเพื่อสนับสนุนการขาย</h4>
			</div>

			<form name="frmSearch" method="GET" action="<?php echo htmlspecialchars($_SERVER['SCRIPT_NAME']); ?>">
				<div class="so-input-group" style="align-items: flex-end; margin-bottom: 20px;">
					<div style="flex: 1; max-width: 680px; min-width: 250px; display: flex; flex-direction: column; gap: 6px;">
						<label for="Keyword" style="font-size: 14px; color: #612989; font-weight: 500;">ค้นหาด้วยเลขที่เอกสาร/ชื่อ</label>
						<div style="display: flex; gap: 12px; align-items: center;">
							<div class="so-search-wrapper" style="flex: 1; width: auto;">
								<i class="fas fa-search so-search-icon"></i>
								<input name="Keyword" id="Keyword" class="so-input" type="text" placeholder="Search" value="<?php echo htmlspecialchars(isset($_GET['Keyword']) ? $_GET['Keyword'] : ''); ?>">
							</div>
							<a href="register_supsmp.php" class="btn-so-outline" style="flex-shrink: 0; font-weight: 500;">
								<img src="img/icons/add_message.png" alt=""> สร้างใบ SMP
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
					<div class="w3-modal-content w3-card-4" role="dialog" aria-modal="true" aria-labelledby="filterModalTitle" style="border-radius:16px; max-width:680px;">
						<div class="w3-container" style="padding:32px;">
							<div class="so-modal-header">
								<h5 id="filterModalTitle" style="margin:0; font-weight:600; color:#3B3B3B; font-size:20px;">Filters</h5>
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

							<!-- Row 2: สถานะการอนุมัติ + เขตการขาย -->
							<div class="so-form-row" style="align-items: flex-start;">
								<div>
									<label class="so-label" for="status_approve">สถานะการอนุมัติ</label>
									<select name="status_approve" id="status_approve" class="so-select">
										<option value="">-- ทั้งหมด --</option>
										<?php
										$smpStatusFilterOptions = array(
											'pending_sup'  => 'รอหัวหน้า',
											'returned'     => 'ส่งกลับ',
											'pending_exec' => 'รอผู้บริหาร',
											'rejected'     => 'ไม่อนุมัติ',
											'approve'      => 'อนุมัติแล้ว',
											'cancel'       => 'ยกเลิก',
										);
										$smpSelectedStatusApprove = isset($_GET['status_approve']) ? $_GET['status_approve'] : '';
										foreach ($smpStatusFilterOptions as $smpOptValue => $smpOptLabel) {
											$smpSel = ($smpSelectedStatusApprove === $smpOptValue) ? 'selected' : '';
											echo '<option value="' . htmlspecialchars($smpOptValue) . '" ' . $smpSel . '>' . htmlspecialchars($smpOptLabel) . '</option>';
										}
										?>
									</select>
								</div>
								<div>
	<label class="so-label" for="sale_code">เขตการขาย</label>

	<?php
	$emid = isset($_SESSION['code']) ? trim($_SESSION['code']) : '';
	$type_login = isset($_SESSION['type_login']) ? trim($_SESSION['type_login']) : '';

	$type_login_lower = strtolower($type_login);
	$emid_safe = mysqli_real_escape_string($com, $emid);

	$smpSelectedSaleCode = isset($_GET['sale_code'])
		? trim($_GET['sale_code'])
		: '';
	?>

	<?php if ($type_login_lower == 'sale') { ?>

		<!-- Sale ล็อกเขตของตัวเอง -->
		<input
			type="hidden"
			name="sale_code"
			id="sale_code"
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
		// =========================================================
		// Admin / IT / Owner เห็นทั้งหมด
		// =========================================================
		if (
			$type_login_lower == 'admin' ||
			$type_login_lower == 'it' ||
			$type_login_lower == 'owner'
		) {

			$teamSql = "
				SELECT
					sale_code,
					sale_name
				FROM tb_team_adm
				ORDER BY sale_code ASC
			";

		}

		// =========================================================
		// Engineer / SUP_EN
		// =========================================================
		else if (
			$emid == 'SUP_EN' ||
			$type_login_lower == 'engineer'
		) {

			$teamSql = "
				SELECT
					sale_code,
					sale_name
				FROM tb_team_adm
				WHERE sale_code LIKE '%EN%'
				ORDER BY sale_code ASC
			";

		}

		// =========================================================
		// SOL
		// =========================================================
		else if ($type_login_lower == 'sol') {

			$teamSql = "
				SELECT
					sale_code,
					sale_name
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

		// =========================================================
		// User อื่น ดูสิทธิ์จาก user_sale_permission
		// =========================================================
		else {

			$teamSql = "
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
			name="sale_code"
			id="sale_code"
			class="so-select"
		>
			<option value="">-- ทั้งหมด --</option>

			<?php
			$objQuery5 = mysqli_query($com, $teamSql);

			if ($objQuery5) {

				while ($objResuut5 = mysqli_fetch_assoc($objQuery5)) {

					$sel = (
						$smpSelectedSaleCode == $objResuut5['sale_code']
					)
						? 'selected'
						: '';
			?>

					<option
						value="<?php echo htmlspecialchars(
							$objResuut5['sale_code'],
							ENT_QUOTES,
							'UTF-8'
						); ?>"
						<?php echo $sel; ?>
					>
						<?php echo htmlspecialchars(
							$objResuut5['sale_code'],
							ENT_QUOTES,
							'UTF-8'
						); ?>
						-
						<?php echo htmlspecialchars(
							$objResuut5['sale_name'],
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

			$Keyword        = isset($_GET['Keyword'])        ? $_GET['Keyword']        : '';
			$start_date     = isset($_GET['start_date'])     ? $_GET['start_date']     : '';
			$end_date       = isset($_GET['end_date'])       ? $_GET['end_date']       : '';
			$sale_code      = isset($_GET['sale_code'])      ? $_GET['sale_code']      : '';
			$status_approve = isset($_GET['status_approve']) ? $_GET['status_approve'] : '';

			?>

			<div class="so-table-wrapper">
				<table class="so-table smp-status-table">
					<colgroup>
						<col style="width:3%;">
						<col style="width:12%;">
						<col style="width:11%;">
						<col style="width:10%;">
						<col style="width:15%;">
						<col style="width:8%;">
						<col style="width:15%;">
						<col style="width:9%;">
						<col style="width:12%;">
						<col style="width:5%;">
					</colgroup>
					<thead>
						<tr>
							<th width="3%"></th>
							<th style="white-space:nowrap;">เลขที่อ้างอิง</th>
							<th style="white-space:nowrap;">วันที่ลงทะเบียน</th>
							<th style="white-space:nowrap;">เลขที่เอกสาร</th>
							<th style="white-space:nowrap;">หมายเลขคำสั่งซื้อใหม่</th>
							<th style="white-space:nowrap;">Comment</th>
							<th style="white-space:nowrap;">ชื่อลูกค้า</th>
							<th style="white-space:nowrap;">เขตการขาย</th>
							<th style="white-space:nowrap; width:12%;">สถานะการอนุมัติ</th>
							<th width="5%" style="text-align:center;"></th>
						</tr>
					</thead>
					<tbody>

						<?php

						date_default_timezone_set("Asia/Bangkok");
						
						
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
						
						
						

						/* ผู้ใช้ทุกคนที่เข้าหน้านี้เห็นเอกสาร SMP ทุกเขตและทุกสถานะ */
						$strSQL = "SELECT * FROM hos__smp WHERE $sddd ";

						if ($start_date != "") {
							$strSQL .= ' AND smp_date >= "' . mysqli_real_escape_string($conn, $start_date) . '"';
						}

						if ($end_date != "") {
							$strSQL .= ' AND smp_date <= "' . mysqli_real_escape_string($conn, $end_date) . '"';
						}

						if ($sale_code != "") {
							$strSQL .= ' AND sale_code = "' . mysqli_real_escape_string($conn, $sale_code) . '"';
						}
						
						
						/* สถานะการอนุมัติ — map ตาม smp_is_awaiting_sup()/smp_is_awaiting_dm() ใน includes/smp_repo.php
						   "ยกเลิก" ไม่มีสถานะของตัวเอง: smp_run_document_action() เขียน status_sup = 'Rejected'
						   แล้วแยกจากไม่อนุมัติด้วย log 'Cancelled' ใน tb_document_status_log */
						$smpHasStatusLog = smp_table_exists($conn, 'tb_document_status_log');
						$smpCancelledExists = "EXISTS (SELECT 1 FROM tb_document_status_log l WHERE l.ref_id = hos__smp.ref_idsmp AND l.status_doc = 'Cancelled')";
						$smpStatusFilterSql = array(
							'pending_sup'  => " AND status_sup = 'Request' AND send_sup = '1' AND send_dm = '0' AND send_stock = '0' AND send_admin = '0'",
							'returned'     => " AND status_sup = 'Returned'",
							'pending_exec' => " AND status_sup = 'Request' AND send_dm = '1' AND send_stock = '0' AND send_admin = '0'",
							'rejected'     => " AND status_sup = 'Rejected'" . ($smpHasStatusLog ? " AND NOT " . $smpCancelledExists : ""),
							'approve'      => " AND status_sup = 'Approve'",
							'cancel'       => $smpHasStatusLog ? " AND status_sup = 'Rejected' AND " . $smpCancelledExists : " AND 1 = 0",
						);
						if ($status_approve != "" && isset($smpStatusFilterSql[$status_approve])) {
							$strSQL .= $smpStatusFilterSql[$status_approve];
						}

						if ($Keyword != "") {
							$kw = mysqli_real_escape_string($conn, $Keyword);
							$strSQL .= ' AND (ref_idsmp LIKE "%' . $kw . '%"';
							$strSQL .= ' OR smp_no LIKE "%' . $kw . '%"';
							$strSQL .= ' OR order_no LIKE "%' . $kw . '%"';
							$strSQL .= ' OR customer_name LIKE "%' . $kw . '%")';
						}

						$objQuery = mysqli_query($conn, $strSQL) or die("Error Query [" . $strSQL . "]");
						$Num_Rows = mysqli_num_rows($objQuery);


						$Per_Page = '20';
						$Page = isset($_GET['Page']) ? $_GET['Page'] : '';

						if (!isset($_GET['Page'])) {
							$Page = 1;
						}

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


						$strSQL .= " order by id_smp DESC LIMIT $Page_Start , $Per_Page";
						$objQuery  = mysqli_query($conn, $strSQL);

						$smpPageRows = array();
						while ($objQuery && $smpPageRow = mysqli_fetch_assoc($objQuery)) {
							$smpPageRows[] = $smpPageRow;
						}
						$Page_Num_Rows = count($smpPageRows);

						/* ref_id ที่ถูกยกเลิก — ดึงครั้งเดียวสำหรับทั้งหน้า */
						$smpCancelledRefs = array();
						if ($smpHasStatusLog && $Page_Num_Rows > 0) {
							$smpRejectedIds = array();
							foreach ($smpPageRows as $smpPageRow) {
								if ((string)$smpPageRow['status_sup'] === 'Rejected') {
									$smpRejectedIds[] = "'" . mysqli_real_escape_string($conn, (string)$smpPageRow['ref_idsmp']) . "'";
								}
							}
							if (count($smpRejectedIds) > 0) {
								$smpCancelQuery = mysqli_query($conn, "SELECT DISTINCT ref_id FROM tb_document_status_log WHERE status_doc = 'Cancelled' AND ref_id IN (" . implode(',', $smpRejectedIds) . ")");
								while ($smpCancelQuery && $smpCancelRow = mysqli_fetch_assoc($smpCancelQuery)) {
									$smpCancelledRefs[(string)$smpCancelRow['ref_id']] = true;
								}
							}
						}

						?>

						<?php if ($Page_Num_Rows === 0) { ?>
							<tr>
								<td colspan="10" style="text-align:center; padding:40px 16px; color:#6B6875;">
									<?php echo ($Num_Rows > 0)
										? 'ไม่พบข้อมูลในหน้านี้ — ลองกลับไปหน้าแรก'
										: 'ไม่พบรายการที่ตรงกับเงื่อนไข ลองล้างตัวกรองหรือเปลี่ยนคำค้น'; ?>
								</td>
							</tr>
						<?php } ?>

						<?php
						foreach ($smpPageRows as $objResult) {
							$refId = (string)$objResult["ref_idsmp"];
							$statusSup = (string)$objResult["status_sup"];
							$safeIdPart = preg_replace('/[^a-zA-Z0-9_-]/', '', $refId);
							$row_id = "row-" . $safeIdPart;
							$dropdown_id = "dropdown-" . $safeIdPart;
							$row_id_js = htmlspecialchars(json_encode($row_id), ENT_QUOTES, 'UTF-8');
							$dropdown_id_js = htmlspecialchars(json_encode($dropdown_id), ENT_QUOTES, 'UTF-8');

							$isDraftOrReturned = ($statusSup === 'Draft' || $statusSup === 'Returned');
							$edit_url = 'register_supsmp.php?ref_idsmp=' . urlencode($refId);
							$copy_url = 'register_supsmp.php?copy_from=' . urlencode($refId);
							$preview_url = 'report_sample.php?ref_idsmp=' . urlencode($refId);
							$copy_url_js = htmlspecialchars(json_encode($copy_url), ENT_QUOTES, 'UTF-8');

							/* ===================== Status badge ===================== */
							$statusText = $statusSup;
							$statusClass = 'draft';

							if ($statusSup === 'Approve') {
								$statusText = 'อนุมัติแล้ว';
								$statusClass = 'approve';
							} else if ($statusSup === 'Rejected') {
								if (isset($smpCancelledRefs[$refId])) {
									$statusText = 'ยกเลิก';
									$statusClass = 'cancel';
								} else {
									$statusText = 'ไม่อนุมัติ';
									$statusClass = 'rejected';
								}
							} else if ($statusSup === 'Returned') {
								$statusText = 'ส่งกลับ';
								$statusClass = 'returned';
							} else if ($statusSup === 'Draft') {
								$statusText = 'ยังไม่กดส่ง';
								$statusClass = 'draft';
							} else if ($statusSup === 'Request') {
								$smpStage = smp_stage_of($objResult);
								if ($smpStage === 'sup') {
									$statusText = 'รอหัวหน้า';
									$statusClass = 'pending-mgr';
								} else if ($smpStage === 'dm') {
									$statusText = 'รอผู้บริหาร';
									$statusClass = 'pending-exec';
								}
								// อื่น ๆ (legacy เช่น send_sup = 0 หรือส่งคลังแล้ว) — แสดงค่าดิบ ไม่เดาสถานะ
							} else if ($statusSup === '') {
								$statusText = '-';
							}

							$commentSale = trim((string)($objResult["comment_sale"] ?? ''));
						?>
							<tr class="so-row" role="button" tabindex="0" aria-expanded="false" onclick="toggleRow(<?php echo $row_id_js; ?>, this)">
								<td style="text-align:center;"><img src="img/icons/arrow_down.png" class="caret-icon" style="width:12px; height:12px;" alt=""></td>
								<td><a href="<?php echo htmlspecialchars($edit_url); ?>" style="color:#612989; text-decoration:underline; font-weight:500;" onclick="event.stopPropagation();"><?php echo htmlspecialchars($refId); ?></a></td>
								<td><?php echo DateThai($objResult["smp_date"]); ?></td>
								<td><?php echo htmlspecialchars((string)$objResult["smp_no"]); ?></td>
								<td><?php echo htmlspecialchars((string)$objResult["order_no"]); ?></td>
								<td style="max-width:320px;">
									<div title="<?php echo htmlspecialchars($commentSale); ?>" style="overflow:hidden; text-overflow:ellipsis; white-space:nowrap;"><?php echo $commentSale !== '' ? htmlspecialchars($commentSale) : '-'; ?></div>
								</td>
								<td><div align="left"><?php echo htmlspecialchars((string)$objResult["customer_name"]); ?></div></td>
								<td><div align="left"><?php echo htmlspecialchars((string)$objResult["sale_code"]); ?></div></td>
								<td>
									<span class="badge-status <?php echo htmlspecialchars($statusClass); ?>"><?php echo htmlspecialchars($statusText); ?></span>
								</td>
								<td style="text-align:center; position:relative;">
									<div class="so-dropdown">
										<button type="button" class="so-dropdown-trigger" aria-label="ตัวเลือกเพิ่มเติม" aria-haspopup="true" aria-expanded="false" onclick="toggleDropdown(event, <?php echo $dropdown_id_js; ?>)">
											<i class="fas fa-ellipsis-v"></i>
										</button>
										<div id="<?php echo htmlspecialchars($dropdown_id); ?>" class="so-dropdown-menu">
											<a href="<?php echo htmlspecialchars($edit_url); ?>" class="so-dropdown-item">
												<i class="fas fa-edit" style="width:16px;"></i> แก้ไข
											</a>
											<?php if (!$isDraftOrReturned) { ?>
												<a href="#" class="so-dropdown-item" onclick="event.preventDefault(); confirmGo('!!!ต้องการเพิ่มเอกสารใบเบิกสินค้าใช่หรือไม่', <?php echo $copy_url_js; ?>);">
													<i class="fas fa-copy" style="width:16px;"></i> Duplicate
												</a>
											<?php } ?>
											<?php if ($statusSup !== 'Draft') { ?>
												<a href="<?php echo htmlspecialchars($preview_url); ?>" target="_blank" rel="noopener noreferrer" class="so-dropdown-item" onclick="event.stopPropagation();">
													<i class="fas fa-search" style="width:16px;"></i> Preview
												</a>
											<?php } ?>
										</div>
									</div>
								</td>
							</tr>

							<!-- Expanded Row Detail -->
							<tr id="<?php echo htmlspecialchars($row_id); ?>" class="expanded-row" style="display:none;">
								<td colspan="10">
									<div class="expanded-container">
										<?php
										$smpParcelNos = array_filter(array(trim((string)($objResult["ref_no"] ?? '')), trim((string)($objResult["ref_no1"] ?? ''))), 'strlen');
										if (count($smpParcelNos) > 0) {
										?>
											<div style="font-size:13px; color:#6B6875; margin-bottom:8px;">เลขพัสดุ: <?php echo htmlspecialchars(implode(' / ', $smpParcelNos)); ?></div>
										<?php } ?>
										<div class="expanded-products-card">
											<table class="sub-table">
												<thead>
													<tr>
														<th width="28%">รายการสินค้า</th>
														<th width="18%">เคลียร์ยืม</th>
														<th width="10%" style="text-align:center;">จำนวน</th>
														<th width="14%" style="text-align:right !important;">ราคา/หน่วย</th>
														<th width="16%" style="text-align:right !important;">ยอดรวม</th>
													</tr>
												</thead>
												<tbody>
													<?php
													$smpItemRows = smp_load_items($conn, $refId);
													$smpItemsTotal = 0.0;

													if (count($smpItemRows) === 0) {
													?>
														<tr>
															<td colspan="5" style="text-align:center; color:#8E8B94; padding:20px;">ไม่มีรายการสินค้า</td>
														</tr>
													<?php
													} else {
														foreach ($smpItemRows as $smpItemRow) {
															$smpSaleCount = (float)($smpItemRow['sale_count'] ?? 0);
															$smpUnitPrice = (float)($smpItemRow['unit_price'] ?? 0);
															$smpSumAmount = (float)($smpItemRow['sum_amount'] ?? ($smpSaleCount * $smpUnitPrice));
															$smpItemsTotal += $smpSumAmount;
															$smpBrNo = trim((string)($smpItemRow['br_no'] ?? ''));
													?>
															<tr>
																<td><?php echo htmlspecialchars((string)($smpItemRow['sol_name'] ?? '-')); ?></td>
																<td>
																	<?php if ((string)($smpItemRow['clear_br'] ?? '0') === '1') { ?>
																		<span style="display:inline-flex; align-items:center; gap:6px;">
																			<img src="img/icons/checkmark.png" alt="เคลียร์แล้ว" style="width:18px; height:18px; flex-shrink:0;">
																			<span><?php echo htmlspecialchars($smpBrNo !== '' ? $smpBrNo : 'เคลียร์แล้ว'); ?></span>
																		</span>
																	<?php } else { ?>
																		-
																	<?php } ?>
																</td>
																<td style="text-align:center;"><?php echo number_format($smpSaleCount); ?></td>
																<td style="text-align:right;"><?php echo number_format($smpUnitPrice, 2); ?></td>
																<td style="text-align:right;"><?php echo number_format($smpSumAmount, 2); ?></td>
															</tr>
													<?php
														}
													?>
														<tr style="border-top: 1px solid #EDE9F0;">
															<td colspan="4" style="text-align:right; font-weight:500; padding: 14px 12px !important; font-size: 14px; color: #3B3B3B;">ยอดรวม</td>
															<td style="text-align:right; font-size:16px; color:#612989; font-weight:600; padding: 14px 12px !important;"><?php echo number_format($smpItemsTotal, 2); ?></td>
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
					$pagParams = "&Keyword=" . urlencode($Keyword) . "&start_date=" . urlencode($start_date) . "&end_date=" . urlencode($end_date) . "&sale_code=" . urlencode($sale_code)
						. "&status_approve=" . urlencode($status_approve);

					if ($Prev_Page) {
						echo "<a class='pagination-btn' aria-label='หน้าก่อนหน้า' href='$_SERVER[SCRIPT_NAME]?Page=$Prev_Page$pagParams'><i class='fas fa-chevron-left'></i></a>";
					}

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
						echo "<a class='pagination-btn' aria-label='หน้าถัดไป' href='$_SERVER[SCRIPT_NAME]?Page=$Next_Page$pagParams'><i class='fas fa-chevron-right'></i></a>";
					}
					?>
				</div>
			</div>
		</div> <!-- so-card -->
	</div> <!-- status-so-page -->

	<!-- JS Helpers for Expandable Rows, Kebab Dropdowns, and Filter Modal -->
	<script>
		function toggleRow(rowId, triggerEl) {
			const row = document.getElementById(rowId);
			if (!row) return;
			const isVisible = row.style.display !== 'none';

			document.querySelectorAll('.expanded-row').forEach(r => {
				if (r.id !== rowId) r.style.display = 'none';
			});
			document.querySelectorAll('.so-row').forEach(r => {
				if (r !== triggerEl) {
					r.classList.remove('is-expanded');
					r.setAttribute('aria-expanded', 'false');
				}
			});

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

		function confirmGo(message, url) {
			if (confirm(message)) {
				window.location = url;
			}
		}

		function toggleDropdown(event, dropdownId) {
			event.stopPropagation();

			const trigger = event.currentTarget;
			const menu = document.getElementById(dropdownId);
			if (!menu) return;

			const isCurrentlyOpen = menu.classList.contains('show');

			document.querySelectorAll('.so-dropdown-menu').forEach(m => m.classList.remove('show'));
			document.querySelectorAll('.so-dropdown-trigger').forEach(t => t.setAttribute('aria-expanded', 'false'));

			if (!isCurrentlyOpen) {
				menu.classList.add('show');
				trigger.setAttribute('aria-expanded', 'true');

				const rect = trigger.getBoundingClientRect();
				const menuWidth = 186;
				const menuHeight = menu.offsetHeight || 150;
				const spaceBelow = window.innerHeight - rect.bottom;

				menu.style.position = 'fixed';
				menu.style.zIndex = '99999';
				menu.style.left = Math.max(10, (rect.right - menuWidth)) + 'px';

				if (spaceBelow < menuHeight + 10 && rect.top > menuHeight) {
					menu.style.top = (rect.top - menuHeight - 4) + 'px';
				} else {
					menu.style.top = (rect.bottom + 4) + 'px';
				}
			}
		}

		document.addEventListener('click', function(event) {
			if (!event.target.closest('.so-dropdown')) {
				document.querySelectorAll('.so-dropdown-menu').forEach(m => m.classList.remove('show'));
				document.querySelectorAll('.so-dropdown-trigger').forEach(t => t.setAttribute('aria-expanded', 'false'));
			}
		});

		window.addEventListener('scroll', function() {
			document.querySelectorAll('.so-dropdown-menu.show').forEach(m => m.classList.remove('show'));
			document.querySelectorAll('.so-dropdown-trigger').forEach(t => t.setAttribute('aria-expanded', 'false'));
		}, true);

		document.addEventListener('keydown', function(event) {
			if (event.key === 'Escape' && document.getElementById('filterModal') && document.getElementById('filterModal').style.display === 'block') {
				closeFilterModal();
			}
			if ((event.key === 'Enter' || event.key === ' ') && event.target.classList && event.target.classList.contains('so-row')) {
				event.preventDefault();
				event.target.click();
			}
		});

		function openFilterModal() {
			document.getElementById('filterModal').style.display = 'block';
			const startDate = document.getElementById('start_date');
			if (startDate) startDate.focus();
		}

		function closeFilterModal() {
			document.getElementById('filterModal').style.display = 'none';
		}

		function resetFilters() {
			const fields = ['start_date', 'end_date', 'sale_code', 'status_approve'];
			fields.forEach(id => {
				const el = document.getElementById(id);
				if (el) el.value = '';
			});
			document.forms['frmSearch'].submit();
		}

		function updateFilterBadge() {
			const fields = ['start_date', 'end_date', 'sale_code', 'status_approve'];
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

		document.addEventListener('DOMContentLoaded', function() {
			updateFilterBadge();
		});
	</script>
</body>

</html>
