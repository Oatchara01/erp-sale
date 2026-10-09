<?php include('head.php');

include "dbconnect.php";
include "dbconnect_sale.php";
require_once __DIR__ . '/includes/receivepro_repo.php';

// ตัวกรองสถานะ — key เดียวกับ rp_status_info() (includes/receivepro_repo.php)
$rpStatusFilters = array(
	'draft' => 'Draft',
	'submitted' => 'Submitted',
	'cancelled' => 'ยกเลิก',
);
// key ของ rp_status_info() → [label, class ของ badge-status ใน css/so-status-ui.css]
$rpStatusBadges = array(
	'draft' => array('Draft', 'draft'),
	'submitted' => array('Submitted', 'approve'),
	'cancelled' => array('ยกเลิก', 'cancel'),
);

$getParam = function ($key) {
	return isset($_GET[$key]) && !is_array($_GET[$key]) ? trim((string)$_GET[$key]) : '';
};
$Keyword = $getParam('Keyword');
$start_date = $getParam('start_date');
$end_date = $getParam('end_date');
$sale_code = $getParam('sale_code');
$status_filter = isset($rpStatusFilters[$getParam('status_filter')]) ? $getParam('status_filter') : '';
$rpHasStatusColumn = rp_has_status_column($conn);
$scriptName = htmlspecialchars($_SERVER['SCRIPT_NAME'], ENT_QUOTES, 'UTF-8');

// เขตการขายทั้งหมด — ใช้แสดงชื่อในคอลัมน์ตาราง
$saleNames = array();
$saleQuery = mysqli_query($com, "SELECT sale_code, sale_name FROM tb_team_adm ORDER BY sale_code ASC");
while ($saleQuery && ($saleRow = mysqli_fetch_assoc($saleQuery))) {
	$saleNames[(string)$saleRow['sale_code']] = (string)$saleRow['sale_name'];
}

// ตัวเลือกเขตการขายของตัวกรอง — เงื่อนไขเดิมของหน้านี้ (ไม่รวมเขตที่ ckk = 1)
$saleDropdownOptions = array();
$saleDropdownQuery = mysqli_query($com, "SELECT sale_code, sale_name FROM tb_team_adm WHERE ckk!='1' ORDER BY sale_code ASC");
while ($saleDropdownQuery && ($saleDropdownRow = mysqli_fetch_assoc($saleDropdownQuery))) {
	$saleDropdownOptions[] = $saleDropdownRow;
}
?>
<link rel="stylesheet" href="css/so-status-ui.css?v=<?php echo filemtime(__DIR__ . '/css/so-status-ui.css'); ?>">
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
				<h4 style="margin:0px;">ใบส่งสินค้า</h4>
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

							<a href="register_receivepro.php" class="btn-so-outline" style="text-decoration:none; flex-shrink: 0; font-weight: 700;">
								<img src="img/icons/add_message.png" alt="" style="width: 16px; height: 16px; vertical-align: middle; margin-right: 6px;"> เพิ่มใบส่งสินค้า
							</a>
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

							<div class="so-form-row">
								<div>
									<label class="so-label">สถานะ</label>
									<select name="status_filter" id="modal_status_filter" class="so-select">
										<option value="">Select</option>
										<?php foreach ($rpStatusFilters as $rpFilterKey => $rpFilterLabel) { ?>
											<option value="<?php echo $rpFilterKey; ?>" <?php echo $rpFilterKey === $status_filter ? 'selected' : ''; ?>><?php echo $rpFilterLabel; ?></option>
										<?php } ?>
									</select>
								</div>
								<div>
									<label class="so-label">เขตการขาย</label>
									<select name="sale_code" id="modal_sale_code" class="so-select">
										<option value="">Select</option>
										<?php
										$saleCodeFound = false;
										foreach ($saleDropdownOptions as $saleOpt) {
											$saleCodeOpt = (string)$saleOpt['sale_code'];
											$saleIsSelected = ($sale_code === $saleCodeOpt);
											$saleCodeFound = $saleCodeFound || $saleIsSelected;
										?>
											<option value="<?php echo htmlspecialchars($saleCodeOpt, ENT_QUOTES, 'UTF-8'); ?>" <?php echo $saleIsSelected ? 'selected' : ''; ?>><?php echo htmlspecialchars($saleCodeOpt . ' - ' . (string)$saleOpt['sale_name'], ENT_QUOTES, 'UTF-8'); ?></option>
										<?php } ?>
										<?php if ($sale_code !== '' && !$saleCodeFound) { ?>
											<!-- เขตที่กรองอยู่แต่ไม่อยู่ในตัวเลือก ต้องไม่หลุดตอนกดตกลงซ้ำ -->
											<option value="<?php echo htmlspecialchars($sale_code, ENT_QUOTES, 'UTF-8'); ?>" selected><?php echo htmlspecialchars($sale_code, ENT_QUOTES, 'UTF-8'); ?></option>
										<?php } ?>
									</select>
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

			<!-- Preview Modal — ใบส่งสินค้ามีแบบฟอร์มพิมพ์หลายแบบ (rp_print_forms) ให้เลือกก่อนเปิด -->
			<div id="previewModal" class="w3-modal" style="display:none; z-index:9999;" onclick="if (event.target === this) closePreviewModal();">
				<div class="w3-modal-content w3-card-4" role="dialog" aria-modal="true" aria-labelledby="previewModalTitle" style="border-radius:16px; max-width:420px;">
					<div class="w3-container" style="padding:32px;">
						<div class="so-modal-header" style="border-bottom: none; padding-bottom: 0; margin-bottom: 8px;">
							<h5 id="previewModalTitle" style="margin:0; font-weight:600; color:#3B3B3B; font-size:20px; font-family: 'Prompt', sans-serif !important;">Preview</h5>
							<button type="button" onclick="closePreviewModal()" aria-label="ปิดหน้าต่างเลือกแบบฟอร์ม" style="background:none; border:none; padding:0; font-size:28px; cursor:pointer; color:#8E8B94; line-height: 1;">&times;</button>
						</div>
						<div style="font-size:13px; color:#8E8B94; margin-bottom:16px; font-family: 'Prompt', sans-serif !important;">
							เลือกแบบฟอร์มของเลขที่เอกสาร <span id="previewModalRpNo" style="color:#612989; font-weight:500;"></span>
						</div>
						<div style="border:1px solid #EDE9F0; border-radius:8px; overflow:hidden;">
							<?php foreach (rp_print_forms() as $rpFormFile => $rpFormLabel) { ?>
								<a href="#" target="_blank" rel="noopener" class="so-dropdown-item" data-form-file="<?php echo htmlspecialchars($rpFormFile, ENT_QUOTES, 'UTF-8'); ?>" onclick="closePreviewModal();">
									<i class="fas fa-file-alt" style="width:16px;"></i> <?php echo htmlspecialchars($rpFormLabel, ENT_QUOTES, 'UTF-8'); ?>
								</a>
							<?php } ?>
						</div>
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

				function closePreviewModal() {
					document.getElementById('previewModal').style.display = 'none';
				}

				document.addEventListener('keydown', function(event) {
					if (event.key !== 'Escape') return;
					if (document.getElementById('filterModal').style.display === 'block') closeFilterModal();
					if (document.getElementById('previewModal').style.display === 'block') closePreviewModal();
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

			<div class="so-table-wrapper so-table-wrapper--fit">
				<table class="so-table so-table-fit" id="rpTable">
					<thead>
						<tr>
							<th width="3%"></th>
							<th width="13%">เลขที่เอกสาร</th>
							<th width="12%">วันที่</th>
							<th width="14%">เลขที่อ้างอิง</th>
							<th width="26%">ชื่อลูกค้า</th>
							<th width="17%">เขตการขาย</th>
							<th width="12%">สถานะ</th>
							<th width="3%"></th>
						</tr>
					</thead>
					<tbody>

						<?php
						date_default_timezone_set("Asia/Bangkok");

						$strSQL = "SELECT * FROM hos__proreceive WHERE 1";

						if ($start_date != "") {
							$strSQL .= ' AND iv_date >= "' . mysqli_real_escape_string($conn, $start_date) . '"';
						}

						if ($end_date != "") {
							$strSQL .= ' AND iv_date <= "' . mysqli_real_escape_string($conn, $end_date) . '"';
						}

						if ($sale_code != "") {
							$strSQL .= ' AND sale_code = "' . mysqli_real_escape_string($conn, $sale_code) . '"';
						}

						if ($Keyword != "") {
							$safeKeyword = mysqli_real_escape_string($conn, $Keyword);
							$strSQL .= ' AND (iv_noref LIKE "%' . $safeKeyword . '%"';
							$strSQL .= ' OR rp_no LIKE "%' . $safeKeyword . '%"';
							$strSQL .= ' OR customer LIKE "%' . $safeKeyword . '%")';
						}

						// เงื่อนไขตามลำดับเดียวกับ rp_status_info() — Draft มาก่อนยกเลิก, ฐานที่ยังไม่มี status_doc = เอกสารจริงทั้งหมด
						$rpNotDraft = $rpHasStatusColumn ? " AND COALESCE(status_doc, '') <> 'Draft'" : '';
						if ($status_filter === 'draft') {
							$strSQL .= $rpHasStatusColumn ? " AND status_doc = 'Draft'" : " AND 0";
						} else if ($status_filter === 'cancelled') {
							$strSQL .= $rpNotDraft . " AND COALESCE(cancel_ckk, '') = '1'";
						} else if ($status_filter === 'submitted') {
							$strSQL .= $rpNotDraft . " AND COALESCE(cancel_ckk, '') <> '1'";
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

						$strSQL .= " ORDER BY id_proreceive DESC LIMIT $Page_Start, $Per_Page";
						$objQuery = mysqli_query($conn, $strSQL) or die("Error Query [" . $strSQL . "]");

						if ($Num_Rows === 0) {
						?>
							<tr>
								<td colspan="8" style="text-align:center; color:#8E8B94; padding:24px;">ไม่พบข้อมูล</td>
							</tr>
						<?php
						}

						while ($objResult = mysqli_fetch_array($objQuery)) {
							$rp_no = (string)$objResult['rp_no'];
							$rp_no_url = urlencode($rp_no);
							// rp_no ไม่มี unique key — id ของ DOM ใช้ id_proreceive กันซ้ำ
							$row_id = "row-" . (int)$objResult['id_proreceive'];
							$dropdown_id = "dropdown-" . (int)$objResult['id_proreceive'];
							// json_encode ต้องผ่าน htmlspecialchars ด้วย มิฉะนั้น double quote จะปิด attribute onclick ก่อนกำหนด
							$row_id_js = htmlspecialchars(json_encode($row_id), ENT_QUOTES, 'UTF-8');
							$dropdown_id_js = htmlspecialchars(json_encode($dropdown_id), ENT_QUOTES, 'UTF-8');
							$rp_no_js = htmlspecialchars(json_encode($rp_no), ENT_QUOTES, 'UTF-8');

							$rpStatusInfo = rp_status_info($objResult);
							list($badgeText, $badgeClass) = $rpStatusBadges[$rpStatusInfo['key']];

							// Draft ที่วันที่ยังว่างถูกเก็บเป็น 0000-00-00
							$rpIvDate = substr((string)$objResult['iv_date'], 0, 10);
							$rowSaleCode = (string)$objResult['sale_code'];
							$saleDisplay = $rowSaleCode . (isset($saleNames[$rowSaleCode]) && $saleNames[$rowSaleCode] !== '' ? ' - ' . $saleNames[$rowSaleCode] : '');
						?>
							<!-- Main Row -->
							<tr class="so-row" role="button" tabindex="0" aria-expanded="false" onclick="toggleRow(<?php echo $row_id_js; ?>, this)">
								<td style="text-align:center; vertical-align:middle;">
									<img src="img/icons/arrow_down.png" class="caret-icon" alt="">
								</td>
								<td>
									<a href="register_receivepro.php?rp_no=<?php echo $rp_no_url; ?>" onclick="event.stopPropagation();" style="color:#612989; text-decoration:underline; font-weight:500;"><?php echo htmlspecialchars($rp_no); ?></a>
								</td>
								<td><?php echo rp_valid_iso_date($rpIvDate) ? DateThai($rpIvDate) : '-'; ?></td>
								<td><?php echo htmlspecialchars((string)$objResult["iv_noref"]); ?></td>
								<td>
									<div align="left"><?php echo htmlspecialchars((string)$objResult["customer"]); ?></div>
								</td>
								<td><?php echo htmlspecialchars($saleDisplay); ?></td>
								<td>
									<span class="badge-status <?php echo $badgeClass; ?>"><?php echo $badgeText; ?></span>
								</td>
								<td style="text-align:center; vertical-align:middle; position:relative;">
									<div class="so-dropdown">
										<button type="button" class="so-dropdown-trigger" aria-label="ตัวเลือกเพิ่มเติม" aria-haspopup="true" aria-expanded="false" onclick="toggleDropdown(event, <?php echo $dropdown_id_js; ?>)">
											<i class="fas fa-ellipsis-v"></i>
										</button>
										<div id="<?php echo htmlspecialchars($dropdown_id); ?>" class="so-dropdown-menu">
											<a href="register_receivepro.php?rp_no=<?php echo $rp_no_url; ?>" class="so-dropdown-item">
												<i class="fas fa-edit" style="width:16px;"></i> แก้ไข
											</a>
											<a href="register_receivepro.php?copy_from=<?php echo $rp_no_url; ?>" onclick="return confirmCopyRp(event, this);" class="so-dropdown-item">
												<i class="fas fa-copy" style="width:16px;"></i> คัดลอกใบเดิม
											</a>
											<a href="#" onclick="return openPreviewModal(event, <?php echo $rp_no_js; ?>);" class="so-dropdown-item">
												<i class="fas fa-search" style="width:16px;"></i> Preview
											</a>
										</div>
									</div>
								</td>
							</tr>

							<!-- Expanded Row Detail -->
							<tr id="<?php echo htmlspecialchars($row_id); ?>" class="expanded-row" style="display:none;">
								<td colspan="8">
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
													$rpItems = rp_load_items($conn, $rp_no);
													foreach ($rpItems as $rpItem) {
														// ชื่อเดียวกับแบบฟอร์มพิมพ์: ckk_name = 1 ใช้ชื่อที่กรอกแทนชื่อสินค้า
														$rpItemName = ((string)$rpItem['ckk_name'] === '1' && trim((string)$rpItem['proname']) !== '')
															? (string)$rpItem['proname']
															: (string)($rpItem['sol_name'] ?? '');
													?>
														<tr>
															<td><?php echo htmlspecialchars($rpItemName !== '' ? $rpItemName : '-'); ?></td>
															<td style="text-align:center;"><?php echo htmlspecialchars(rp_trim_number($rpItem['qty'])); ?></td>
															<td></td>
														</tr>
													<?php
													}
													if (count($rpItems) === 0) {
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
		// คัดลอกใบเดิม — ยืนยันด้วย SweetAlert แล้วค่อยไปหน้า register_receivepro.php?copy_from=
		function confirmCopyRp(event, linkEl) {
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

		// Preview — ใส่ rp_no ของแถวที่กดลงในลิงก์แบบฟอร์มทุกแบบ แล้วเปิด popup ให้เลือก
		function openPreviewModal(event, rpNo) {
			event.preventDefault();
			event.stopPropagation();
			closeAllDropdowns();

			var modal = document.getElementById('previewModal');
			modal.querySelectorAll('[data-form-file]').forEach(function(link) {
				link.href = link.getAttribute('data-form-file') + '?rp_no=' + encodeURIComponent(rpNo);
			});
			document.getElementById('previewModalRpNo').textContent = rpNo;
			modal.style.display = 'block';
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

		function closeAllDropdowns() {
			document.querySelectorAll('.so-dropdown-menu').forEach(m => {
				m.classList.remove('show');
			});
			document.querySelectorAll('.so-dropdown-trigger').forEach(t => {
				t.setAttribute('aria-expanded', 'false');
			});
		}

		function toggleDropdown(event, dropdownId) {
			event.stopPropagation(); // Prevent row click expansion

			const trigger = event.currentTarget;
			const menu = document.getElementById(dropdownId);
			if (!menu) return;

			const isCurrentlyOpen = menu.classList.contains('show');

			closeAllDropdowns();

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
				closeAllDropdowns();
			}
		});

		window.addEventListener('scroll', closeAllDropdowns, true);
	</script>
</body>

</html>
