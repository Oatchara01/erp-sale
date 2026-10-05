<?php include('head.php');

include "dbconnect.php";
include "dbconnect_sale.php";
require_once __DIR__ . '/includes/po_repo.php';

// ตัวกรองสถานะ 4 กลุ่มตาม mockup — map จาก key ของ po_status_info()
$poStatusFilters = array(
	'waiting' => 'รอเปิดใบสั่งขาย',
	'opened' => 'เปิดใบสั่งขายแล้ว',
	'rejected' => 'ไม่อนุมัติ',
	'cancelled' => 'ยกเลิก',
);
// key ของ po_status_info() → [label, class ของ badge-status ใน css/so-status-ui.css]
$poStatusBadges = array(
	'draft' => array('รอเปิดใบสั่งขาย', 'pending-mgr'),
	'waiting_send' => array('รอเปิดใบสั่งขาย', 'pending-mgr'),
	'waiting_so' => array('รอเปิดใบสั่งขาย', 'pending-mgr'),
	'opened' => array('เปิดใบสั่งขายแล้ว', 'approve'),
	'returned' => array('ไม่อนุมัติ', 'rejected'),
	'cancelled' => array('ยกเลิก', 'cancel'),
);

$getParam = function ($key) {
	return isset($_GET[$key]) && !is_array($_GET[$key]) ? trim((string)$_GET[$key]) : '';
};
$Keyword = $getParam('Keyword');
$start_date = $getParam('start_date');
$end_date = $getParam('end_date');
$sale_code = $getParam('sale_code');
$status_filter = isset($poStatusFilters[$getParam('status_filter')]) ? $getParam('status_filter') : '';
$poHasStatusColumn = po_has_status_column($conn);
$scriptName = htmlspecialchars($_SERVER['SCRIPT_NAME'], ENT_QUOTES, 'UTF-8');

// =========================================================
// เขตการขายทั้งหมด
// ใช้สำหรับแสดงชื่อในคอลัมน์ตาราง
// =========================================================
$saleNames = array();

$saleQuery = mysqli_query(
	$com,
	"
	SELECT
		sale_code,
		sale_name
	FROM tb_team_adm
	ORDER BY sale_code ASC
	"
);

while ($saleQuery && ($saleRow = mysqli_fetch_assoc($saleQuery))) {

	$saleNames[(string)$saleRow['sale_code']] =
		(string)$saleRow['sale_name'];

}


// =========================================================
// สิทธิ์การมองเห็น Dropdown เขตการขาย
// =========================================================
$emid = isset($_SESSION['code'])
	? trim($_SESSION['code'])
	: '';

$type_login = isset($_SESSION['type_login'])
	? trim($_SESSION['type_login'])
	: '';

$type_login_lower = strtolower($type_login);

$emid_safe = mysqli_real_escape_string($com, $emid);


// =========================================================
// Sale ล็อกเขตของตัวเอง
// =========================================================
if ($type_login_lower == 'sale') {

	$saleDropdownOptions = array(
		array(
			'sale_code' => $emid,
			'sale_name' => isset($saleNames[$emid])
				? $saleNames[$emid]
				: $emid
		)
	);

}


// =========================================================
// User อื่น
// =========================================================
else {

	// Admin / IT / Owner เห็นทั้งหมด
	if (
		$type_login_lower == 'admin' ||
		$type_login_lower == 'it' ||
		$type_login_lower == 'owner'
	) {

		$saleDropdownSql = "
			SELECT
				sale_code,
				sale_name
			FROM tb_team_adm
			ORDER BY sale_code ASC
		";

	}


	// Engineer / SUP_EN
	else if (
		$emid == 'SUP_EN' ||
		$type_login_lower == 'engineer'
	) {

		$saleDropdownSql = "
			SELECT
				sale_code,
				sale_name
			FROM tb_team_adm
			WHERE sale_code LIKE '%EN%'
			ORDER BY sale_code ASC
		";

	}


	// SOL
	else if ($type_login_lower == 'sol') {

		$saleDropdownSql = "
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


	// User อื่น ดูจาก user_sale_permission
	else {

		$saleDropdownSql = "
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


	// =====================================================
	// ดึง Dropdown Options
	// =====================================================
	$saleDropdownOptions = array();

	$saleDropdownQuery = mysqli_query(
		$com,
		$saleDropdownSql
	);

	if ($saleDropdownQuery) {

		while (
			$saleDropdownRow =
			mysqli_fetch_assoc($saleDropdownQuery)
		) {

			$saleDropdownOptions[] = $saleDropdownRow;

		}

	}

}

?>
<link rel="stylesheet" href="css/so-status-ui.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
			<div class="w3-container w3-bar w3-margin-bottom" style="padding-left:0px; padding-right:0px; display:flex; align-items:center; gap:16px;">
				<a href="javascript:history.back()" aria-label="ย้อนกลับ" style="color:#612989; font-size:20px; text-decoration:none;"><i class="fas fa-chevron-left"></i></a>
				<h4 style="margin:0px;">ใบ PO</h4>
			</div>

			<form name="frmSearch" method="GET" action="<?php echo $scriptName; ?>" id="mainSearchForm">
				<!-- preserve modal filter values as hidden fields in main search -->
				<input type="hidden" name="start_date" value="<?php echo htmlspecialchars($start_date); ?>">
				<input type="hidden" name="end_date" value="<?php echo htmlspecialchars($end_date); ?>">
				<input type="hidden" name="sale_code" value="<?php echo htmlspecialchars($sale_code); ?>">
				<input type="hidden" name="status_filter" value="<?php echo htmlspecialchars($status_filter); ?>">

				<div class="so-input-group" style="align-items: flex-end; margin-bottom: 20px;">
					<div style="flex: 1; max-width: 680px; min-width: 250px; display: flex; flex-direction: column; gap: 6px;">
						<div style="font-size: 14px; color: #612989; font-weight: 500; font-family: 'Prompt', sans-serif !important;">
							ค้นหาด้วยเลขที่เอกสาร/ชื่อลูกค้า
						</div>
						<div style="display: flex; gap: 12px; align-items: center;">
							<div class="so-search-wrapper" style="flex: 1; width: auto;">
								<i class="fas fa-search so-search-icon"></i>
								<input name="Keyword" class="so-input" type="text" id="Keyword" placeholder="Search" value="<?php echo htmlspecialchars($Keyword); ?>">
							</div>

               <?php if (in_array($type_login_lower, ['admin', 'it'], true)) { ?>
							<a href="register_poawl.php" class="btn-so-outline" style="text-decoration:none; flex-shrink: 0;">
								<img src="img/icons/add_message.png" alt="" style="width: 16px; height: 16px; vertical-align: middle; margin-right: 6px;"> สร้างใบ PO
							</a>
                  <?php } ?>

						</div>
					</div>

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

							<div class="so-form-row">
								<div>
									<label class="so-label">สถานะการอนุมัติ</label>
									<select name="status_filter" id="modal_status_filter" class="so-select">
										<option value="">Select</option>
										<?php foreach ($poStatusFilters as $poFilterKey => $poFilterLabel) { ?>
											<option value="<?php echo $poFilterKey; ?>" <?php echo $poFilterKey === $status_filter ? 'selected' : ''; ?>><?php echo $poFilterLabel; ?></option>
										<?php } ?>
									</select>
								</div>
								<div>
	<label class="so-label">เขตการขาย</label>

	<?php if ($type_login_lower == 'sale') { ?>

		<!-- Sale ล็อกเขตตัวเอง -->
		<input
			type="hidden"
			name="sale_code"
			id="modal_sale_code"
			value="<?php echo htmlspecialchars(
				$emid,
				ENT_QUOTES,
				'UTF-8'
			); ?>"
		>

		<input
			type="text"
			class="so-select"
			value="<?php echo htmlspecialchars(
				$emid . ' - ' . (
					isset($saleNames[$emid])
						? $saleNames[$emid]
						: $emid
				),
				ENT_QUOTES,
				'UTF-8'
			); ?>"
			readonly
			style="background:#f5f5f5; cursor:not-allowed;"
		>

	<?php } else { ?>

		<select
			name="sale_code"
			id="modal_sale_code"
			class="so-select"
		>

			<option value="">Select</option>

			<?php foreach ($saleDropdownOptions as $saleOpt) { ?>

				<?php
				$saleCodeOpt =
					(string)$saleOpt['sale_code'];

				$saleNameOpt =
					(string)$saleOpt['sale_name'];

				$selected = (
					isset($sale_code) &&
					(string)$sale_code === $saleCodeOpt
				)
					? 'selected'
					: '';
				?>

				<option
					value="<?php echo htmlspecialchars(
						$saleCodeOpt,
						ENT_QUOTES,
						'UTF-8'
					); ?>"
					<?php echo $selected; ?>
				>
					<?php echo htmlspecialchars(
						$saleCodeOpt . ' - ' . $saleNameOpt,
						ENT_QUOTES,
						'UTF-8'
					); ?>
				</option>

			<?php } ?>

		</select>

	<?php } ?>

</div>
							</div>

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

				function resetFilters() {
					document.getElementById('modal_start_date').value = '';
					document.getElementById('modal_end_date').value = '';
					document.getElementById('modal_status_filter').value = '';
					document.getElementById('modal_sale_code').value = '';
					document.getElementById('Keyword').value = '';
					document.getElementById('modalKeyword').value = '';
					document.getElementById('modalFilterForm').submit();
				}
			</script>

			<div class="so-table-wrapper">
				<table class="so-table" id="poTable">
					<thead>
						<tr>
							<th width="3%"></th>
							<th width="10%">เลขที่อ้างอิง</th>
							<th width="11%">วันที่ลงทะเบียน</th>
							<th width="11%">เลขที่ PO</th>
							<th width="20%">ชื่อลูกค้า</th>
							<th width="15%">เขตการขาย</th>
							<th width="13%">สถานะการอนุมัติ</th>
							<th width="14%">เลขที่ใบสั่งขาย</th>
							<th width="3%"></th>
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
						
						

						$strSQL = "SELECT * FROM hos__po WHERE $sddd ";

						if ($start_date != "") {
							$strSQL .= ' AND date_po >= "' . mysqli_real_escape_string($conn, $start_date) . '"';
						}

						if ($end_date != "") {
							$strSQL .= ' AND date_po <= "' . mysqli_real_escape_string($conn, $end_date) . '"';
						}

						if ($sale_code != "") {
							$strSQL .= ' AND sale_code = "' . mysqli_real_escape_string($conn, $sale_code) . '"';
						}

						if ($Keyword != "") {
							$safeKeyword = mysqli_real_escape_string($conn, $Keyword);
							$strSQL .= ' AND (bill_name LIKE "%' . $safeKeyword . '%"';
							$strSQL .= ' OR po_no LIKE "%' . $safeKeyword . '%"';
							$strSQL .= ' OR ref_id LIKE "%' . $safeKeyword . '%"';
							$strSQL .= ' OR ref_so LIKE "%' . $safeKeyword . '%")';
						}

						// เงื่อนไขตามลำดับเดียวกับ po_status_info() — "รอเปิดใบสั่งขาย" = draft + waiting_send + waiting_so
						$poNotDraft = $poHasStatusColumn ? " AND status_doc <> 'Draft'" : '';
						if ($status_filter === 'cancelled') {
							$strSQL .= $poNotDraft . " AND cancel_ckk = '1'";
						} else if ($status_filter === 'opened') {
							$strSQL .= $poNotDraft . " AND cancel_ckk <> '1' AND open_so = '1'";
						} else if ($status_filter === 'rejected') {
							$strSQL .= $poHasStatusColumn ? " AND status_doc = 'Returned' AND cancel_ckk <> '1' AND open_so <> '1'" : " AND 0";
						} else if ($status_filter === 'waiting') {
							$strSQL .= $poHasStatusColumn
								? " AND (status_doc = 'Draft' OR (cancel_ckk <> '1' AND open_so <> '1' AND status_doc <> 'Returned'))"
								: " AND cancel_ckk <> '1' AND open_so <> '1'";
						}

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
							$Num_Pages = (int)($Num_Rows / $Per_Page) + 1;
						}

						$strSQL .= " ORDER BY id DESC LIMIT $Page_Start, $Per_Page";
						$objQuery = mysqli_query($conn, $strSQL) or die("Error Query [" . $strSQL . "]");

						if ($Num_Rows === 0) {
						?>
							<tr>
								<td colspan="9" style="text-align:center; color:#8E8B94; padding:24px;">ไม่พบข้อมูล</td>
							</tr>
						<?php
						}

						while ($objResult = mysqli_fetch_array($objQuery)) {
							$ref_id = (string)$objResult['ref_id'];
							$ref_id_url = urlencode($ref_id);
							$row_id = "row-" . $ref_id;
							$dropdown_id = "dropdown-" . $ref_id;
							// json_encode ต้องผ่าน htmlspecialchars ด้วย มิฉะนั้น double quote จะปิด attribute onclick ก่อนกำหนด
							$row_id_js = htmlspecialchars(json_encode($row_id), ENT_QUOTES, 'UTF-8');
							$dropdown_id_js = htmlspecialchars(json_encode($dropdown_id), ENT_QUOTES, 'UTF-8');

							$poStatus = po_status_info($objResult);
							list($badgeText, $badgeClass) = $poStatusBadges[$poStatus['key']];
							// ตรงกับ po_load_for_sale_order(): Draft / ส่งกลับ / ยกเลิก / เปิด SO แล้ว → ออกใบสั่งขายไม่ได้
							$canOpenSo = !in_array($poStatus['key'], array('draft', 'returned', 'cancelled', 'opened'), true);

							$rowSaleCode = (string)$objResult['sale_code'];
							$saleDisplay = $rowSaleCode . (isset($saleNames[$rowSaleCode]) && $saleNames[$rowSaleCode] !== '' ? ' - ' . $saleNames[$rowSaleCode] : '');
							$refSo = trim((string)$objResult['ref_so']);
						?>
							<!-- Main Row -->
							<tr class="so-row" role="button" tabindex="0" aria-expanded="false" onclick="toggleRow(<?php echo $row_id_js; ?>, this)">
								<td style="text-align:center; vertical-align:middle;">
									<img src="img/icons/arrow_down.png" class="caret-icon" alt="">
								</td>
								<td>
									<a href="register_poawl.php?ref_id=<?php echo $ref_id_url; ?>" onclick="event.stopPropagation();" style="color:#612989; text-decoration:underline; font-weight:500;"><?php echo htmlspecialchars($ref_id); ?></a>
								</td>
								<td><?php echo DateThai($objResult["date_po"]); ?></td>
								<td><?php echo htmlspecialchars($objResult["po_no"]); ?></td>
								<td>
									<div align="left"><?php echo htmlspecialchars($objResult["bill_name"]); ?></div>
								</td>
								<td><?php echo htmlspecialchars($saleDisplay); ?></td>
								<td>
									<span class="badge-status <?php echo $badgeClass; ?>"><?php echo $badgeText; ?></span>
								</td>
								<td>
									<?php if ($refSo !== '') { ?>
										<a href="register_suphos.php?ref_id=<?php echo urlencode($refSo); ?>" onclick="event.stopPropagation();" style="color:#612989; text-decoration:underline;"><?php echo htmlspecialchars($refSo); ?></a>
									<?php } ?>
								</td>
								<td style="text-align:center; vertical-align:middle; position:relative;">
									<div class="so-dropdown">
										<button type="button" class="so-dropdown-trigger" aria-label="ตัวเลือกเพิ่มเติม" aria-haspopup="true" aria-expanded="false" onclick="toggleDropdown(event, <?php echo $dropdown_id_js; ?>)">
											<i class="fas fa-ellipsis-v"></i>
										</button>
										<div id="<?php echo htmlspecialchars($dropdown_id); ?>" class="so-dropdown-menu">
											<a href="register_poawl.php?ref_id=<?php echo $ref_id_url; ?>" class="so-dropdown-item">
												<i class="fas fa-edit" style="width:16px;"></i> แก้ไข
											</a>
											<a href="register_poawl.php?copy_from=<?php echo $ref_id_url; ?>" onclick="return confirmCopyPo(event, this);" class="so-dropdown-item">
												<i class="fas fa-copy" style="width:16px;"></i> คัดลอกใบเดิม
											</a>
											<?php if ($canOpenSo) { ?>
												<a href="register_suphos.php?ref_id=<?php echo $ref_id_url; ?>" class="so-dropdown-item">
													<i class="fas fa-file-signature" style="width:16px;"></i> ออกใบสั่งขาย
												</a>
											<?php } ?>
										</div>
									</div>
								</td>
							</tr>

							<!-- Expanded Row Detail -->
							<tr id="<?php echo htmlspecialchars($row_id); ?>" class="expanded-row" style="display:none;">
								<td colspan="9">
									<div class="expanded-container">
										<div class="expanded-products-card">
											<table class="sub-table">
												<thead>
													<tr>
														<th width="40%">รายการสินค้า</th>
														<th width="10%" style="text-align:center;">จำนวน</th>
														<th width="50%"></th>
													</tr>
												</thead>
												<tbody>
													<?php
													$sqlSub = "SELECT sol_name, `count` FROM hos__subpo LEFT JOIN tb_product ON hos__subpo.product_ID=tb_product.product_id WHERE ref_idd = '" . mysqli_real_escape_string($conn, $ref_id) . "' ORDER BY hos__subpo.id ASC";
													$qrySub = mysqli_query($conn, $sqlSub);
													if ($qrySub && mysqli_num_rows($qrySub) > 0) {
														while ($subResult = mysqli_fetch_assoc($qrySub)) {
													?>
															<tr>
																<td><?php echo htmlspecialchars((string)($subResult['sol_name'] ?? '-')); ?></td>
																<td style="text-align:center;"><?php echo htmlspecialchars(po_trim_number($subResult['count'])); ?></td>
																<td></td>
															</tr>
														<?php
														}
													} else {
														?>
														<tr>
															<td colspan="3" style="text-align:center; color:#8E8B94; padding:20px;">ไม่มีข้อมูลรายการสินค้า</td>
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
			</div>

			<div class="pagination-wrapper">
				<div>
					พบทั้งหมด <strong><?php echo $Num_Rows; ?></strong> รายการ (หน้าที่ <?php echo $Page; ?> จาก <?php echo $Num_Pages; ?> หน้า)
				</div>
				<div class="pagination-links">
					<?php
					$pagParams = htmlspecialchars("&Keyword=" . urlencode($Keyword) . "&start_date=" . urlencode($start_date) . "&end_date=" . urlencode($end_date) . "&sale_code=" . urlencode($sale_code) . "&status_filter=" . urlencode($status_filter), ENT_QUOTES, 'UTF-8');

					if ($Prev_Page) {
						echo "<a class='pagination-btn' aria-label='หน้าก่อนหน้า' href='$scriptName?Page=$Prev_Page$pagParams'><i class='fas fa-chevron-left'></i></a>";
					}

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

					if ($Page < $Num_Pages) {
						echo "<a class='pagination-btn' aria-label='หน้าถัดไป' href='$scriptName?Page=$Next_Page$pagParams'><i class='fas fa-chevron-right'></i></a>";
					}
					?>
				</div>
			</div>

		</div>
	</div>

	<script>
		// คัดลอกใบเดิม — ยืนยันด้วย SweetAlert แล้วค่อยไปหน้า register_poawl.php?copy_from=
		function confirmCopyPo(event, linkEl) {
			event.preventDefault();
			event.stopPropagation();
			var href = linkEl.getAttribute('href');
			if (typeof Swal === 'undefined') {
				if (confirm('ต้องการเพิ่มเอกสารใหม่โดยคัดลอกเอกสารเดิมใช่หรือไม่')) window.location.href = href;
				return false;
			}
			Swal.fire({
				title: 'คัดลอกใบเดิม',
				text: 'ต้องการเพิ่มเอกสารใหม่โดยคัดลอกเอกสารเดิมใช่หรือไม่',
				icon: 'question',
				showCancelButton: true,
				confirmButtonColor: '#612989',
				confirmButtonText: 'ตกลง',
				cancelButtonText: 'ยกเลิก',
				reverseButtons: true
			}).then(function(result) {
				if (result.isConfirmed) window.location.href = href;
			});
			return false;
		}

		function toggleRow(rowId, triggerEl) {
			const row = document.getElementById(rowId);
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
				const menuHeight = menu.offsetHeight || 140;
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
</body>

</html>
