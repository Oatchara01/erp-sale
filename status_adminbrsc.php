<?php
include('head.php');
include "dbconnect.php";
include "dbconnect_sale.php";
?>
<link rel="stylesheet" href="css/so-status-ui.css">
<link rel="stylesheet" href="css/register-receive.css?v=<?php echo filemtime(__DIR__ . '/css/register-receive.css'); ?>">
<script src="js/receive-history.js?v=<?php echo filemtime(__DIR__ . '/js/receive-history.js'); ?>"></script>

<script>
	function toggleRow(rowId, triggerEl) {
		const row = document.getElementById(rowId);
		if (!row) return;
		const isVisible = row.style.display !== 'none';

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

	function toggleDropdown(event, dropdownId) {
		event.stopPropagation();

		const trigger = event.currentTarget;
		const menu = document.getElementById(dropdownId);
		if (!menu) return;

		const isCurrentlyOpen = menu.classList.contains('show');

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
			const menuWidth = 186;
			const menuHeight = menu.offsetHeight || 190;
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

	function openFilterModal() {
		const modal = document.getElementById('filterModal');
		if (modal) modal.style.display = 'block';
		const startDate = document.getElementById('modal_start_date');
		if (startDate) startDate.focus();
	}

	function closeFilterModal() {
		const modal = document.getElementById('filterModal');
		if (modal) modal.style.display = 'none';
	}

	function syncKeyword() {
		const modalKw = document.getElementById('modalKeyword');
		const kw = document.getElementById('Keyword');
		if (modalKw && kw) modalKw.value = kw.value;
	}

	function resetFilters() {
		if (document.getElementById('modal_start_date')) document.getElementById('modal_start_date').value = '';
		if (document.getElementById('modal_end_date')) document.getElementById('modal_end_date').value = '';
		if (document.getElementById('modal_status_doc')) document.getElementById('modal_status_doc').value = '';
		if (document.getElementById('modal_sale_code')) document.getElementById('modal_sale_code').value = '';
		if (document.getElementById('Keyword')) document.getElementById('Keyword').value = '';
		if (document.getElementById('modalKeyword')) document.getElementById('modalKeyword').value = '';
		const form = document.getElementById('modalFilterForm');
		if (form) form.submit();
	}

	document.addEventListener('keydown', function(event) {
		if (event.key === 'Escape' && document.getElementById('filterModal') && document.getElementById('filterModal').style.display === 'block') {
			closeFilterModal();
		}
		if ((event.key === 'Enter' || event.key === ' ') && event.target.classList && event.target.classList.contains('so-row')) {
			event.preventDefault();
			event.target.click();
		}
	});

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
</script>

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
				<h4 style="margin:0px;">Status ใบยืมฝากขาย</h4>
			</div>

			<?php
			date_default_timezone_set("Asia/Bangkok");
			$to_day = date('Y-m-d');

			$Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';
			$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
			$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
			$sale_code = isset($_GET['sale_code']) ? $_GET['sale_code'] : '';
			$status_doc = isset($_GET['status_doc']) ? $_GET['status_doc'] : '';
			$scriptName = htmlspecialchars($_SERVER['SCRIPT_NAME'], ENT_QUOTES, 'UTF-8');
			?>

			<form name="frmSearch" method="GET" action="<?php echo $scriptName; ?>" id="mainSearchForm">
				<input type="hidden" name="start_date" value="<?php echo htmlspecialchars($start_date); ?>">
				<input type="hidden" name="end_date" value="<?php echo htmlspecialchars($end_date); ?>">
				<input type="hidden" name="sale_code" value="<?php echo htmlspecialchars($sale_code); ?>">
				<input type="hidden" name="status_doc" value="<?php echo htmlspecialchars($status_doc); ?>">

				<div class="so-input-group" style="align-items: flex-end; margin-bottom: 20px;">
					<!-- Left: Search Wrapper + Label + Add Button -->
					<div style="flex: 1; max-width: 680px; min-width: 250px; display: flex; flex-direction: column; gap: 6px;">
						<div style="font-size: 14px; color: #612989; font-weight: 500; font-family: 'Prompt', sans-serif !important;">
							ค้นหาด้วยเลขที่อ้างอิง/ชื่อลูกค้า/เลขที่เอกสาร
						</div>
						<div style="display: flex; gap: 12px; align-items: center;">
							<div class="so-search-wrapper" style="flex: 1; width: auto;">
								<i class="fas fa-search so-search-icon"></i>
								<input name="Keyword" class="so-input" type="text" id="Keyword" placeholder="Search" value="<?php echo htmlspecialchars($Keyword); ?>">
							</div>

							<!-- + เพิ่มใบยืมฝากขาย button -->
							<a href="register_supbrcshos.php" class="btn-so-outline" style="text-decoration:none; flex-shrink: 0;">
								<img src="img/icons/add_message.png" alt="" style="width: 16px; height: 16px; vertical-align: middle; margin-right: 6px;"> เพิ่มใบยืมฝากขาย
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
							<input type="hidden" name="Keyword" id="modalKeyword" value="<?php echo htmlspecialchars($Keyword); ?>">

							<div class="so-modal-header" style="border-bottom: none; padding-bottom: 0; margin-bottom: 24px;">
								<h5 id="filterModalTitle" style="margin:0; font-weight:600; color:#3B3B3B; font-size:20px; font-family: 'Prompt', sans-serif !important;">Filters</h5>
								<button type="button" onclick="closeFilterModal()" aria-label="ปิดหน้าต่างตัวกรอง" style="background:none; border:none; padding:0; font-size:28px; cursor:pointer; color:#8E8B94; line-height: 1;">&times;</button>
							</div>

							<!-- Row 1: Dates -->
							<div class="so-form-row">
								<div>
									<label class="so-label">ตั้งแต่วันที่</label>
									<input type="date" name="start_date" id="modal_start_date" class="so-select so-modal-input" value="<?php echo htmlspecialchars($start_date); ?>">
								</div>
								<div>
									<label class="so-label">ถึงวันที่</label>
									<input type="date" name="end_date" id="modal_end_date" class="so-select so-modal-input" value="<?php echo htmlspecialchars($end_date); ?>">
								</div>
							</div>

							<!-- Row 2: Status & Sales Zone -->
							<div class="so-form-row">
								<div>
									<label class="so-label">สถานะการอนุมัติ</label>
									<select name="status_doc" id="modal_status_doc" class="so-select">
										<option value="">Select</option>
										<option value="รอหัวหน้า" <?php if ($status_doc == 'รอหัวหน้า' || $status_doc == 'Request') echo 'selected'; ?>>รอหัวหน้า</option>
										<option value="ส่งกลับ" <?php if ($status_doc == 'ส่งกลับ') echo 'selected'; ?>>ส่งกลับ</option>
										<option value="รอผู้บริหาร" <?php if ($status_doc == 'รอผู้บริหาร') echo 'selected'; ?>>รอผู้บริหาร</option>
										<option value="Rejected" <?php if ($status_doc == 'Rejected') echo 'selected'; ?>>ไม่อนุมัติ</option>
										<option value="Approve" <?php if ($status_doc == 'Approve') echo 'selected'; ?>>อนุมัติแล้ว</option>
										<option value="ยกเลิก" <?php if ($status_doc == 'ยกเลิก') echo 'selected'; ?>>ยกเลิก</option>
									</select>
								</div>
								<div>
	<label class="so-label">เขตการขาย</label>

	<?php
	$emid = isset($_SESSION['code']) ? trim($_SESSION['code']) : '';
	$type_login = isset($_SESSION['type_login']) ? trim($_SESSION['type_login']) : '';
	$type_login_lower = strtolower($type_login);

	$emid_safe = mysqli_real_escape_string($com, $emid);
	?>

	<?php if ($type_login_lower == 'sale') { ?>

		<!-- Sale ล็อกเขตตัวเอง -->
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

			// Admin / IT / Owner เห็นทั้งหมด
			if (
				$type_login_lower == 'admin' ||
				$type_login_lower == 'it' ||
				$type_login_lower == 'owner'
			) {

				$strSQL5 = "
					SELECT sale_code, sale_name
					FROM tb_team_adm
					ORDER BY sale_code ASC
				";

			}

			// Engineer / SUP_EN
			else if (
				$emid == 'SUP_EN' ||
				$type_login_lower == 'engineer'
			) {

				$strSQL5 = "
					SELECT sale_code, sale_name
					FROM tb_team_adm
					WHERE sale_code LIKE '%EN%'
					ORDER BY sale_code ASC
				";

			}

			// SOL
			else if ($type_login_lower == 'sol') {

				$strSQL5 = "
					SELECT sale_code, sale_name
					FROM tb_team_adm
					WHERE sale_code IN (
						'SOL1','SOL2','SOL3','SOL4','SOL5',
						'SOL6','SOL7','SOL8','SOL9','SOL0','SM1'
					)
					ORDER BY sale_code ASC
				";

			}

			// User อื่น ดูสิทธิ์จาก user_sale_permission
			else {

				$strSQL5 = "
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

			$objQuery5 = mysqli_query($com, $strSQL5);

			if ($objQuery5) {

				while ($objResuut5 = mysqli_fetch_assoc($objQuery5)) {

					$selected = (
						isset($sale_code) &&
						$sale_code == $objResuut5['sale_code']
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
						<?php echo $selected; ?>
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

			<?php
			// ยอดหนี้คงค้างของใบยืมฝากขาย = มูลค่ารายการที่ยังไม่ถูกเคลียร์ (ขายออก) จาก hos__subconsig
			// เทียบกับ hos__subso (clear_br + clear_ivno) เช่นเดียวกับ ajax_cshos_modal.php
			function getConsigOutstandingAmount($conn, $refId, $ivNo)
			{
				$outstandingAmount = 0.0;
				$refIdEsc = mysqli_real_escape_string($conn, $refId);
				$ivNoEsc = mysqli_real_escape_string($conn, $ivNo);

				$itemsSql = "SELECT product_id, count, amount, clear_ckk FROM hos__subconsig WHERE ref_idd = '{$refIdEsc}'";
				$itemsResult = mysqli_query($conn, $itemsSql);
				if ($itemsResult) {
					while ($item = mysqli_fetch_assoc($itemsResult)) {
						$borrowQty = isset($item['count']) ? (float)$item['count'] : 0.0;
						$itemAmount = isset($item['amount']) ? (float)$item['amount'] : 0.0;
						$productId = isset($item['product_id']) ? (string)$item['product_id'] : '';

						$clearedQty = 0.0;
						if (isset($item['clear_ckk']) && $item['clear_ckk'] == '1') {
							$clearedQty = $borrowQty;
						} elseif ($productId !== '' && $ivNoEsc !== '') {
							$prodIdEsc = mysqli_real_escape_string($conn, $productId);
							$clearQ = mysqli_query($conn, "SELECT SUM(count) AS cnt FROM hos__subso WHERE clear_br = '1' AND product_id = '{$prodIdEsc}' AND clear_ivno = '{$ivNoEsc}' AND status_so = 'Approve'");
							if ($clearQ && $clearRow = mysqli_fetch_assoc($clearQ)) {
								$clearedQty = (float)$clearRow['cnt'];
							}
						}

						if ($clearedQty > $borrowQty) $clearedQty = $borrowQty;
						$remainingQty = $borrowQty - $clearedQty;
						if ($remainingQty < 0) $remainingQty = 0;

						$itemOutstandingAmount = ($borrowQty > 0) ? ($itemAmount * ($remainingQty / $borrowQty)) : 0.0;
						$outstandingAmount += $itemOutstandingAmount;
					}
				}
				return $outstandingAmount;
			}
			
			
			
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
			
			

			$strSQL = "SELECT * FROM hos__consig WHERE $sddd";

			if ($start_date != "") {
				$strSQL .= ' AND iv_date >= "' . mysqli_real_escape_string($conn, $start_date) . '"';
			}
			if ($end_date != "") {
				$strSQL .= ' AND iv_date <= "' . mysqli_real_escape_string($conn, $end_date) . '"';
			}
			if ($sale_code != "") {
				$strSQL .= ' AND sale_code = "' . mysqli_real_escape_string($conn, $sale_code) . '"';
			}
			if ($status_doc != "") {
				if ($status_doc == 'รอหัวหน้า' || $status_doc == 'Request') {
					$strSQL .= ' AND (status_doc = "รอหัวหน้า" OR status_doc = "Request")';
				} else if ($status_doc == 'ส่งกลับ') {
					$strSQL .= ' AND (status_doc = "Returned" OR status_doc = "ส่งกลับ")';
				} else if ($status_doc == 'รอผู้บริหาร') {
					$strSQL .= ' AND status_doc = "Request" AND send_cm = "1"';
				} else {
					$strSQL .= ' AND status_doc = "' . mysqli_real_escape_string($conn, $status_doc) . '"';
				}
			}
			if ($Keyword != "") {
				$kwEsc = mysqli_real_escape_string($conn, $Keyword);
				$strSQL .= ' AND (customer LIKE "%' . $kwEsc . '%" OR iv_no LIKE "%' . $kwEsc . '%" OR sale_comment LIKE "%' . $kwEsc . '%" OR ref_id LIKE "%' . $kwEsc . '%")';
			}

			$objQuery = mysqli_query($conn, $strSQL) or die("Error Query [" . $strSQL . "]");
			$Num_Rows = mysqli_num_rows($objQuery);

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
				$Num_Pages = (int)($Num_Rows / $Per_Page) + 1;
			}

			$strSQL .= " ORDER BY id DESC LIMIT $Page_Start, $Per_Page";
			$objQuery = mysqli_query($conn, $strSQL);
			?>

			<div class="so-table-wrapper">
				<table class="so-table" id="soTable">
					<thead>
						<tr>
							<th width="3%"></th>
							<th width="3%"></th>
							<th width="12%">เลขที่อ้างอิง</th>
							<th width="12%">วันที่ลงทะเบียน</th>
							<th width="12%">เลขที่เอกสาร</th>
							<th width="12%">วันที่ออกเอกสาร</th>
							<th width="17%">ชื่อลูกค้า</th>
							<th width="10%">เขตการขาย</th>
							<th width="12%" style="text-align: right;">ยอดหนี้คงค้าง</th>
							<th width="11%" style="white-space: nowrap;">สถานะการอนุมัติ</th>
							<th width="2%" style="text-align: right;"></th>
						</tr>
					</thead>
					<tbody>
						<?php
						if ($Num_Rows > 0) {
							while ($objResult = mysqli_fetch_array($objQuery)) {
								$rowId = 'row-' . $objResult["id"];
								$dropdownId = 'drop-' . $objResult["id"];

								$isMissingRefIdst = (empty($objResult["ref_idst"]) && $objResult["status_doc"] != 'ยกเลิก' && $objResult["status_doc"] != 'Rejected');

								// Format Date
								$dateSaveStr = !empty($objResult["date_save"]) ? DateThai($objResult["date_save"]) : '-';
								$ivDateStr = ($objResult["iv_date"] == "0000-00-00" || empty($objResult["iv_date"])) ? '-' : DateThai($objResult["iv_date"]);

								// Status badge style mapping
								$statusDoc = $objResult["status_doc"];
								$badgeClass = 'draft';
								$badgeText = $statusDoc;

								if ($statusDoc == 'Approve') {
									$badgeClass = 'approve';
									$badgeText = 'อนุมัติแล้ว';
								} else if ($statusDoc == 'Rejected') {
									$badgeClass = 'rejected';
									$badgeText = 'ไม่อนุมัติ';
								} else if ($statusDoc == 'ยกเลิก') {
									$badgeClass = 'cancel';
									$badgeText = 'ยกเลิก';
								} else if ($statusDoc == 'Request' && ($objResult["send_cm"] ?? '') == '1') {
									$badgeClass = 'pending-exec';
									$badgeText = 'รอผู้บริหาร';
								} else if ($statusDoc == 'รอหัวหน้า' || $statusDoc == 'Request') {
									$badgeClass = 'pending-mgr';
									$badgeText = 'รอหัวหน้า';
								} else if ($statusDoc == 'Returned' || $statusDoc == 'ส่งกลับ') {
									$badgeClass = 'returned';
									$badgeText = 'ส่งกลับ';
								} else if ($statusDoc == 'Draft') {
									$badgeClass = 'draft';
									$badgeText = 'Draft';
								}

								$outstandingAmount = getConsigOutstandingAmount($conn, $objResult["ref_id"], $objResult["iv_no"]);
						?>
								<tr class="so-row" onclick="toggleRow('<?php echo $rowId; ?>', this)" role="button" tabindex="0" aria-expanded="false">
									<td style="vertical-align: middle; text-align: center;">
										<img src="img/icons/arrow_down.png" class="caret-icon" alt="">
									</td>
									<td style="text-align:center; vertical-align:middle;">
										<?php if (isset($objResult["que_ckk"]) && $objResult["que_ckk"] == '1') { ?>
											<i class="fas fa-bolt" style="background: linear-gradient(180deg, #FF2B00 0%, #FF6600 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-size: 20px;" title="รายการด่วน"></i>
										<?php } ?>
									</td>
									<td>
										<a href="register_supbrcshos.php?ref_id=<?php echo urlencode($objResult["ref_id"]); ?>" onclick="event.stopPropagation();" style="font-weight: 500; color: #612989; text-decoration: underline;"><?php echo htmlspecialchars($objResult["ref_id"]); ?></a>
									</td>
									<td><?php echo $dateSaveStr; ?></td>
									<td style="color: #612989; font-weight: 500;"><?php echo htmlspecialchars($objResult["iv_no"] ? $objResult["iv_no"] : '-'); ?></td>
									<td><?php echo $ivDateStr; ?></td>
									<td>
										<div style="font-weight: 500; color: #3B3B3B;"><?php echo htmlspecialchars($objResult["customer"]); ?></div>
									</td>
									<td><?php echo htmlspecialchars($objResult["sale_code"] . ' - ' . $objResult["sale"]); ?></td>
									<td style="text-align: right;"><?php echo number_format($outstandingAmount, 2); ?></td>
									<td>
										<span class="badge-status <?php echo $badgeClass; ?>"><?php echo htmlspecialchars($badgeText); ?></span>
									</td>
									<td onclick="event.stopPropagation();" style="text-align: right;">
										<div class="so-dropdown">
											<button class="so-dropdown-trigger" type="button" onclick="toggleDropdown(event, '<?php echo $dropdownId; ?>')" aria-haspopup="true" aria-expanded="false" aria-label="เมนูดำเนินการ">
												<i class="fas fa-ellipsis-v"></i>
											</button>
											<div class="so-dropdown-menu" id="<?php echo $dropdownId; ?>">
												<a class="so-dropdown-item" href="register_supbrcshos.php?ref_id=<?php echo urlencode($objResult["ref_id"]); ?>">
													<i class="fas fa-edit" style="width:16px;"></i> แก้ไข
												</a>
												<a class="so-dropdown-item" href="javascript:void(0);" onclick="if(confirm('!!!ต้องการเพิ่มเอกสารใหม่โดยCopyเอกสารเดิมใช่หรือไม่')) { window.location='register_supbrcshos.php?copy_from=<?php echo urlencode($objResult["ref_id"]); ?>'; }">
													<i class="fas fa-copy" style="width:16px;"></i> คัดลอกใบเดิม
												</a>
												<a class="so-dropdown-item" href="report_brcshos.php?ref_id=<?php echo urlencode($objResult["ref_id"]); ?>" target="_blank">
													<i class="fas fa-search" style="width:16px;"></i> Preview
												</a>
												<a class="so-dropdown-item" href="report_brcshos_n.php?ref_id=<?php echo urlencode($objResult["ref_id"]); ?>" target="_blank">
													<i class="fas fa-print" style="width:16px;"></i> Print ใบยืมต่อเนื่อง
												</a>
												<?php if ((string)$objResult["status_doc"] === 'Approve') { ?>
													<!-- คืนสินค้า / ประวัติการคืน — ฟอร์มใบคืนแบบรวม register_receive.php (เฉพาะเอกสารที่อนุมัติแล้ว) -->
													<a class="so-dropdown-item" href="register_receive.php?source_type=consig&source_ref=<?php echo urlencode($objResult["ref_id"]); ?>">
														<i class="fas fa-undo-alt" style="width:16px;"></i> คืนสินค้า
													</a>
													<a class="so-dropdown-item" href="#" onclick="rcOpenReceiveHistory(event, 'consig', <?php echo htmlspecialchars(json_encode((string)$objResult["ref_id"]), ENT_QUOTES, 'UTF-8'); ?>, <?php echo htmlspecialchars(json_encode((string)$objResult["iv_no"] !== '' ? (string)$objResult["iv_no"] : (string)$objResult["ref_id"], JSON_UNESCAPED_UNICODE), ENT_QUOTES, 'UTF-8'); ?>); return false;">
														<i class="fas fa-history" style="width:16px;"></i> ประวัติการคืน
													</a>
												<?php } ?>
											</div>
										</div>
									</td>
								</tr>

								<!-- Expanded Row Details (Products List & Shipping Code) -->
								<tr class="expanded-row" id="<?php echo $rowId; ?>" style="display: none;">
									<td colspan="11">
										<div class="expanded-container" style="flex-direction: column;">
											<div class="expanded-products-card" style="width: 100%;">
												<table class="sub-table">
													<thead>
														<tr>
															<th style="width: 45%;">รายการสินค้า</th>
															<th style="width: 55%;">หมายเหตุ</th>
														</tr>
													</thead>
													<tbody>
														<?php
														$strSQL1 = "SELECT * FROM (hos__subconsig LEFT JOIN tb_product ON hos__subconsig.product_ID=tb_product.product_id) WHERE ref_idd = '" . mysqli_real_escape_string($conn, $objResult["ref_id"]) . "' ";
														$objQuery1 = mysqli_query($conn, $strSQL1);
														if ($objQuery1 && mysqli_num_rows($objQuery1) > 0) {
															while ($objResult1 = mysqli_fetch_array($objQuery1)) {
														?>
																<tr>
																	<td>
																		<div style="font-weight: 500; color: #3B3B3B;"><?php echo htmlspecialchars($objResult1["sol_name"]); ?></div>
																	</td>
																	<td>
																		<div style="color: #666;"><?php echo htmlspecialchars($objResult1["sale_remark"] ? $objResult1["sale_remark"] : '-'); ?></div>
																	</td>
																</tr>
															<?php
															}
														} else {
															?>
															<tr>
																<td colspan="2" style="text-align: center; color: #8E8B94; padding: 16px;">ไม่พบรายการสินค้า</td>
															</tr>
														<?php } ?>
													</tbody>
												</table>
											</div>
										</div>
									</td>
								</tr>
							<?php
							}
						} else {
							?>
							<tr>
								<td colspan="11" style="text-align: center; color: #8E8B94; padding: 32px;">ไม่พบข้อมูลรายการใบยืมฝากขาย</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>

			<!-- Pagination -->
			<div class="pagination-wrapper">
				<div>
					<strong>พบทั้งหมด</strong> <?php echo number_format($Num_Rows); ?> <strong>รายการ</strong> |
					<strong>จำนวน</strong> <?php echo number_format($Num_Pages); ?> <strong>หน้า</strong>
				</div>
				<div class="pagination-links">
					<?php
					$queryParams = $_GET;

					if ($Prev_Page > 0) {
						$queryParams['Page'] = $Prev_Page;
						echo '<a class="pagination-btn" href="' . $scriptName . '?' . http_build_query($queryParams) . '"><i class="fas fa-chevron-left"></i></a> ';
					}

					for ($i = 1; $i <= $Num_Pages; $i++) {
						$queryParams['Page'] = $i;
						if ($i != $Page) {
							echo '<a class="pagination-btn" href="' . $scriptName . '?' . http_build_query($queryParams) . '">' . $i . '</a> ';
						} else {
							echo '<span class="pagination-btn active">' . $i . '</span> ';
						}
					}

					if ($Page < $Num_Pages && $Num_Pages > 0) {
						$queryParams['Page'] = $Next_Page;
						echo '<a class="pagination-btn" href="' . $scriptName . '?' . http_build_query($queryParams) . '"><i class="fas fa-chevron-right"></i></a> ';
					}
					?>
				</div>
			</div>

		</div>
	</div>
</body>

</html>