<?php include('head.php');

include "dbconnect.php";
include "dbconnect_sale.php";
require_once __DIR__ . '/includes/receive_repo.php';

// key ของ rc_list_status() → [label, class ของ badge-status ใน css/so-status-ui.css]
$rcStatusBadges = rc_list_status_badges();
// ตัวกรองสถานะ — เฉพาะ key ที่ rc_list_status_where() กรองได้ (hos__receive ยังไม่มี workflow อนุมัติ)
$rcStatusFilters = array();
foreach (array('draft', 'wait_product', 'wait_stock', 'complete', 'incomplete') as $rcFilterKey) {
	$rcStatusFilters[$rcFilterKey] = $rcStatusBadges[$rcFilterKey][0];
}

$getParam = function ($key) {
	return isset($_GET[$key]) && !is_array($_GET[$key]) ? trim((string)$_GET[$key]) : '';
};
$Keyword = $getParam('Keyword');
$start_date = $getParam('start_date');
$end_date = $getParam('end_date');
$sale_code = $getParam('sale_code');
$status_filter = isset($rcStatusFilters[$getParam('status_filter')]) ? $getParam('status_filter') : '';
$scriptName = htmlspecialchars($_SERVER['SCRIPT_NAME'], ENT_QUOTES, 'UTF-8');

$emid = isset($_SESSION['code']) ? (string)$_SESSION['code'] : '';

// เขตการขายที่แต่ละ role เห็น — เงื่อนไขเดิมของหน้านี้
if ($emid == 'SS1') {
	$sddd = "sale_code IN ('S15','S16','S21','S22','S13')";
} else if ($emid == 'SS2') {
	$sddd = "sale_code IN ('S11','S12','S17','S24','S14')";
} else if ($emid == 'SS3') {
	$sddd = "sale_code IN ('S31','S32','S33','MM1','SOL1','SOL2','SOL3','SOL4','SOL5','SOL6','SOL7','SOL8','SOL99')";
} else if ($emid == 'SS5') {
	$sddd = "sale_code IN ('S31','S32')";
} else if ($emid == 'SUP_EN') {
	$sddd = "sale_code LIKE '%EN%'";
} else if ($emid == 'SUP_MK') {
	$sddd = "sale_code IN ('MK','SOL91','SOL93','SOL93','SOL94','SOL99')";
} else if ($emid == 'SM1') {
	$sddd = "sale_code IN ('SOL1','SOL2','SOL3','SOL4','SOL5','SOL6','SOL7','SOL8','SOL99')";
} else {
	$sddd = "1";
}

// ตัวเลือกเขตการขายของตัวกรอง — ตารางทีมเดิมของแต่ละ role
$saleDropdownTables = array(
	'SS1' => "tb_team_ss1",
	'SS2' => "tb_team_ss2",
	'SS3' => "tb_team_ss3",
	'SS5' => "tb_team_ss3 WHERE sale_code IN ('S31','S32')",
	'MK2' => "tb_team_sm1",
	'SUP_EN' => "tb_team_en",
);
$saleDropdownFrom = isset($saleDropdownTables[$emid]) ? $saleDropdownTables[$emid] : "tb_team_all";
$saleDropdownOptions = array();
$saleDropdownQuery = mysqli_query($com, "SELECT sale_code, sale_name FROM $saleDropdownFrom ORDER BY sale_code ASC");
while ($saleDropdownQuery && ($saleDropdownRow = mysqli_fetch_assoc($saleDropdownQuery))) {
	$saleDropdownOptions[] = $saleDropdownRow;
}
?>
<link rel="stylesheet" href="css/so-status-ui.css?v=<?php echo filemtime(__DIR__ . '/css/so-status-ui.css'); ?>">

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
				<h4 style="margin:0px;">ใบคืนสินค้า</h4>
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
							ค้นหาด้วยเลขที่อ้างอิง/เลขที่เอกสาร/ชื่อลูกค้า
						</div>
						<div class="so-search-wrapper" style="width: auto;">
							<i class="fas fa-search so-search-icon"></i>
							<input name="Keyword" class="so-input" type="text" id="Keyword" placeholder="Search" value="<?php echo htmlspecialchars($Keyword); ?>">
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

							<!-- Row 2: Status & Zone -->
							<div class="so-form-row">
								<div>
									<label class="so-label">สถานะ</label>
									<select name="status_filter" id="modal_status_filter" class="so-select">
										<option value="">Select</option>
										<?php foreach ($rcStatusFilters as $rcFilterKey => $rcFilterLabel) { ?>
											<option value="<?php echo $rcFilterKey; ?>" <?php echo $rcFilterKey === $status_filter ? 'selected' : ''; ?>><?php echo $rcFilterLabel; ?></option>
										<?php } ?>
									</select>
								</div>
								<div>
									<label class="so-label">เขตการขาย (Sale)</label>
									<select name="sale_code" id="modal_sale_code" class="so-select">
										<option value="">Select</option>
										<?php foreach ($saleDropdownOptions as $saleDropdownRow) { ?>
											<option value="<?php echo htmlspecialchars($saleDropdownRow["sale_code"]); ?>" <?php if ($sale_code == $saleDropdownRow["sale_code"]) echo 'selected'; ?>>
												<?php echo htmlspecialchars($saleDropdownRow["sale_code"]); ?> - <?php echo htmlspecialchars($saleDropdownRow["sale_name"]); ?>
											</option>
										<?php } ?>
									</select>
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
				<table class="so-table" id="soTable">
					<thead>
						<tr>
							<th width="3%"></th>
							<th width="10%">เลขที่อ้างอิง</th>
							<th width="13%">เลขที่เอกสาร</th>
							<th width="11%">วันที่คืน</th>
							<th width="27%">ชื่อลูกค้า</th>
							<th width="9%">เขตการขาย</th>
							<th width="12%">รับคืนโดย</th>
							<th width="12%">สถานะ</th>
							<th width="3%"></th>
						</tr>
					</thead>
					<tbody>

						<?php
						date_default_timezone_set("Asia/Bangkok");

						$strWhere = $sddd;

						if ($start_date != "") {
							$strWhere .= ' AND date_receive >= "' . mysqli_real_escape_string($conn, $start_date) . '"';
						}

						if ($end_date != "") {
							$strWhere .= ' AND date_receive <= "' . mysqli_real_escape_string($conn, $end_date) . '"';
						}

						if ($sale_code != "") {
							$strWhere .= ' AND sale_code = "' . mysqli_real_escape_string($conn, $sale_code) . '"';
						}

						if ($status_filter != "") {
							$strWhere .= ' AND ' . rc_list_status_where($status_filter);
						}

						if ($Keyword != "") {
							// ครอบวงเล็บ ไม่งั้น OR จะหลุดตัวกรองเขตการขาย/วันที่ด้านบน
							$escKeyword = mysqli_real_escape_string($conn, $Keyword);
							$strWhere .= ' AND (customer_name LIKE "%' . $escKeyword . '%"';
							$strWhere .= ' OR iv_no LIKE "%' . $escKeyword . '%"';
							$strWhere .= ' OR ref_id LIKE "%' . $escKeyword . '%")';
						}

						// Count total rows before LIMIT (COUNT(*) instead of fetching every row)
						$countSQL = "SELECT COUNT(*) AS cnt FROM hos__receive WHERE $strWhere";
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

						$strSQL = "SELECT * FROM hos__receive WHERE $strWhere ORDER BY id_auto DESC LIMIT $Page_Start, $Per_Page";
						$objQuery = mysqli_query($conn, $strSQL) or die("Error Query [" . $strSQL . "]");

						if ($Num_Rows === 0) {
						?>
							<tr>
								<td colspan="9" style="text-align:center; color:#8E8B94; padding:24px;">ไม่พบข้อมูลใบคืนสินค้า</td>
							</tr>
						<?php
						}

						while ($objResult = mysqli_fetch_array($objQuery)) {
							$ref_id = (string)$objResult['ref_id'];
							// ref_id ไม่มี unique key — id ของ DOM ใช้ id_auto กันซ้ำ
							$row_id = "row-" . (int)$objResult['id_auto'];
							$dropdown_id = "dropdown-" . (int)$objResult['id_auto'];
							// json_encode ต้องผ่าน htmlspecialchars ด้วย มิฉะนั้น double quote จะปิด attribute onclick ก่อนกำหนด
							$row_id_js = htmlspecialchars(json_encode($row_id), ENT_QUOTES, 'UTF-8');
							$dropdown_id_js = htmlspecialchars(json_encode($dropdown_id), ENT_QUOTES, 'UTF-8');

							// ทุกใบเปิด register_receive.php — ใบจากฟอร์มเดิม (ไม่มี source_type) หน้านั้นแสดงแบบอ่านอย่างเดียว
							$detail_url = htmlspecialchars('register_receive.php?receive_ref=' . rawurlencode($ref_id), ENT_QUOTES, 'UTF-8');

							list($badgeText, $badgeClass) = $rcStatusBadges[rc_list_status($objResult)];

							$rcDateReceive = substr((string)$objResult['date_receive'], 0, 10);
							$rcStockDes = trim((string)($objResult['stock_des'] ?? ''));
						?>
							<!-- Main Row -->
							<tr class="so-row" role="button" tabindex="0" aria-expanded="false" onclick="toggleRow(<?php echo $row_id_js; ?>, this)">
								<td style="text-align:center; vertical-align:middle;">
									<img src="img/icons/arrow_down.png" class="caret-icon" alt="">
								</td>
								<td>
									<a href="<?php echo $detail_url; ?>" onclick="event.stopPropagation();" style="color:#612989; text-decoration:underline; font-weight:500;"><?php echo htmlspecialchars($ref_id); ?></a>
								</td>
								<td><?php echo htmlspecialchars((string)$objResult["iv_no"]); ?></td>
								<td><?php echo rc_valid_iso_date($rcDateReceive) ? DateThai($rcDateReceive) : '-'; ?></td>
								<td>
									<div align="left"><?php echo htmlspecialchars((string)$objResult["customer_name"]); ?></div>
								</td>
								<td><?php echo htmlspecialchars((string)$objResult["sale_code"]); ?></td>
								<td><?php echo htmlspecialchars((string)($objResult["stock_print"] ?? '')); ?></td>
								<td>
									<span class="badge-status <?php echo $badgeClass; ?>"><?php echo $badgeText; ?></span>
								</td>
								<td style="text-align:center; vertical-align:middle; position:relative;">
									<div class="so-dropdown">
										<button type="button" class="so-dropdown-trigger" aria-label="ตัวเลือกเพิ่มเติม" aria-haspopup="true" aria-expanded="false" onclick="toggleDropdown(event, <?php echo $dropdown_id_js; ?>)">
											<i class="fas fa-ellipsis-v"></i>
										</button>
										<div id="<?php echo htmlspecialchars($dropdown_id); ?>" class="so-dropdown-menu">
											<a href="<?php echo $detail_url; ?>" class="so-dropdown-item">
												<i class="fas fa-search" style="width:16px;"></i> ดูรายละเอียด
											</a>
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
														<th width="25%">S/N</th>
														<th width="25%">หมายเหตุ Stock</th>
													</tr>
												</thead>
												<tbody>
													<?php
													$sqlSub = "SELECT hos__subreceive.count, hos__subreceive.sn, hos__subreceive.stock_remark, tb_product.access_name FROM hos__subreceive LEFT JOIN tb_product ON hos__subreceive.product_ID=tb_product.product_id WHERE ref_idd = '" . mysqli_real_escape_string($conn, $ref_id) . "'";
													$qrySub = mysqli_query($conn, $sqlSub);
													$subRowsCount = $qrySub ? mysqli_num_rows($qrySub) : 0;

													if ($subRowsCount > 0) {
														while ($subResult = mysqli_fetch_array($qrySub)) {
															$rcSubSn = trim((string)$subResult['sn']);
															$rcSubRemark = trim((string)$subResult['stock_remark']);
													?>
															<tr>
																<td><?php echo htmlspecialchars((string)($subResult['access_name'] ?? '-')); ?></td>
																<td style="text-align:center;"><?php echo (int)$subResult['count']; ?></td>
																<td><?php echo $rcSubSn !== '' ? nl2br(htmlspecialchars($rcSubSn)) : '-'; ?></td>
																<td><?php echo $rcSubRemark !== '' ? nl2br(htmlspecialchars($rcSubRemark)) : '-'; ?></td>
															</tr>
														<?php
														}
													} else {
														?>
														<tr>
															<td colspan="4" style="text-align:center; color:#8E8B94; padding:20px;">ไม่มีข้อมูลรายการสินค้า</td>
														</tr>
													<?php
													}

													if ($rcStockDes !== '') {
													?>
														<tr style="border-top: 1px solid #EDE9F0;">
															<td colspan="4" style="padding: 14px 12px !important; font-size: 14px; color: #3B3B3B;"><span style="font-weight:500;">หมายเหตุจาก Stock:</span> <?php echo nl2br(htmlspecialchars($rcStockDes)); ?></td>
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

			<!-- Pagination Restyling -->
			<div class="pagination-wrapper">
				<div>
					พบทั้งหมด <strong><?php echo $Num_Rows; ?></strong> รายการ (หน้าที่ <?php echo $Page; ?> จาก <?php echo $Num_Pages; ?> หน้า)
				</div>
				<div class="pagination-links">
					<?php
					$pagParams = "&Keyword=" . urlencode($Keyword) . "&start_date=" . urlencode($start_date) . "&end_date=" . urlencode($end_date) . "&sale_code=" . urlencode($sale_code) . "&status_filter=" . urlencode($status_filter);
					$pagParams = htmlspecialchars($pagParams, ENT_QUOTES, 'UTF-8');

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
	</script>

</body>

</html>
