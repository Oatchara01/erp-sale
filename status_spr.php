<?php
require_once __DIR__ . '/includes/spr_repo.php';

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
				<h4 style="margin:0;">รายการใบเบิกเครื่องและอะไหล่ (SPR)</h4>
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
							<a href="register_engspr.php" class="btn-so-outline" style="flex-shrink: 0; font-weight: 500;">
								<img src="img/icons/add_message.png" alt=""> สร้างใบ SPR
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
										$sprStatusFilterOptions = array(
											'pending_sup'  => 'รอหัวหน้า',
											'returned'     => 'ส่งกลับ',
											'pending_exec' => 'รอผู้บริหาร',
											'rejected'     => 'ไม่อนุมัติ',
											'approve'      => 'อนุมัติแล้ว',
											'cancel'       => 'ยกเลิก',
										);
										$sprSelectedStatusApprove = isset($_GET['status_approve']) ? $_GET['status_approve'] : '';
										foreach ($sprStatusFilterOptions as $sprOptValue => $sprOptLabel) {
											$sprSel = ($sprSelectedStatusApprove === $sprOptValue) ? 'selected' : '';
											echo '<option value="' . htmlspecialchars($sprOptValue) . '" ' . $sprSel . '>' . htmlspecialchars($sprOptLabel) . '</option>';
										}
										?>
									</select>
								</div>
								<div>
									<label class="so-label" for="sale_code">เขตการขาย</label>
									<select name="sale_code" id="sale_code" class="so-select">
										<option value="">-- ทั้งหมด --</option>
										<?php
										$sprSelectedSaleCode = isset($_GET['sale_code']) ? $_GET['sale_code'] : '';
										$strSQL5 = "SELECT * FROM tb_team_en ORDER BY sale_code ASC";
										$objQuery5 = mysqli_query($com, $strSQL5);
										while ($objResuut5 = mysqli_fetch_array($objQuery5)) {
											$sel = ($sprSelectedSaleCode == $objResuut5["sale_code"]) ? "selected" : "";
										?>
											<option value="<?php echo htmlspecialchars($objResuut5["sale_code"]); ?>" <?php echo $sel; ?>><?php echo htmlspecialchars($objResuut5["sale_code"]); ?> - <?php echo htmlspecialchars($objResuut5["sale_name"]); ?></option>
										<?php
										}
										?>
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

			$Keyword        = isset($_GET['Keyword'])        ? $_GET['Keyword']        : '';
			$start_date     = isset($_GET['start_date'])     ? $_GET['start_date']     : '';
			$end_date       = isset($_GET['end_date'])       ? $_GET['end_date']       : '';
			$sale_code      = isset($_GET['sale_code'])      ? $_GET['sale_code']      : '';
			$status_approve = isset($_GET['status_approve']) ? $_GET['status_approve'] : '';

			?>

			<div class="so-table-wrapper">
				<table class="so-table">
					<thead>
						<tr>
							<th width="3%"></th>
							<th style="white-space:nowrap;">เลขที่อ้างอิง</th>
							<th style="white-space:nowrap;">วันที่ลงทะเบียน</th>
							<th style="white-space:nowrap;">เลขที่เอกสาร</th>
							<th style="white-space:nowrap;">เลขที่ใบงานบริการ</th>
							<th style="white-space:nowrap;">ลูกค้า</th>
							<th style="white-space:nowrap;">เขตการขาย</th>
							<th style="white-space:nowrap; width:12%;">สถานะ</th>
							<th width="5%" style="text-align:center;"></th>
						</tr>
					</thead>
					<tbody>

						<?php

						date_default_timezone_set("Asia/Bangkok");

						$strSQL = "SELECT * FROM hos__spr WHERE type_company = '1'";

						if ($start_date != "") {
							$strSQL .= ' AND spr_date >= "' . mysqli_real_escape_string($conn, $start_date) . '"';
						}

						if ($end_date != "") {
							$strSQL .= ' AND spr_date <= "' . mysqli_real_escape_string($conn, $end_date) . '"';
						}

						if ($sale_code != "") {
							$strSQL .= ' AND sale_code = "' . mysqli_real_escape_string($conn, $sale_code) . '"';
						}

						/* สถานะการอนุมัติ — map ตาม (status_doc, send_sup, sup_name, send_cm, cm_name) แบบเดียวกับ
						   spr_stage_of() ใน includes/spr_repo.php ไม่ใช่แค่ status_doc ตรง ๆ เพราะ Request เพียงค่าเดียว
						   ครอบคลุมทั้งรอหัวหน้า/รอผู้บริหาร แยกกันด้วย sup_name/cm_name เท่านั้น */
						$sprStatusFilterSql = array(
							'pending_sup'  => " AND status_doc = 'Request' AND send_sup = '1' AND (sup_name IS NULL OR sup_name = '')",
							'returned'     => " AND status_doc = 'Returned'",
							'pending_exec' => " AND status_doc = 'Request' AND send_cm = '1' AND (cm_name IS NULL OR cm_name = '')",
							'rejected'     => " AND status_doc = 'Rejected'",
							'approve'      => " AND status_doc = 'Approve'",
							'cancel'       => " AND status_doc = 'ยกเลิก'",
						);
						if ($status_approve != "" && isset($sprStatusFilterSql[$status_approve])) {
							$strSQL .= $sprStatusFilterSql[$status_approve];
						}

						if ($Keyword != "") {
							$kw = mysqli_real_escape_string($conn, $Keyword);
							$strSQL .= ' AND (customer LIKE "%' . $kw . '%"';
							$strSQL .= ' OR ref_id LIKE "%' . $kw . '%"';
							$strSQL .= ' OR spr_no LIKE "%' . $kw . '%"';
							$strSQL .= ' OR brnp_no LIKE "%' . $kw . '%"';
							$strSQL .= ' OR wo_no LIKE "%' . $kw . '%")';
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


						$strSQL .= " order by ref_id DESC LIMIT $Page_Start , $Per_Page";
						$objQuery  = mysqli_query($conn, $strSQL);
						$Page_Num_Rows = $objQuery ? mysqli_num_rows($objQuery) : 0;

						?>

						<?php if ($Page_Num_Rows === 0) { ?>
							<tr>
								<td colspan="9" style="text-align:center; padding:40px 16px; color:#6B6875;">
									<?php echo ($Num_Rows > 0)
										? 'ไม่พบข้อมูลในหน้านี้ — ลองกลับไปหน้าแรก'
										: 'ไม่พบรายการที่ตรงกับเงื่อนไข ลองล้างตัวกรองหรือเปลี่ยนคำค้น'; ?>
								</td>
							</tr>
						<?php } ?>

						<?php
						while ($objResult = mysqli_fetch_assoc($objQuery)) {
							$refId = (string)$objResult["ref_id"];
							$safeIdPart = preg_replace('/[^a-zA-Z0-9_-]/', '', $refId);
							$row_id = "row-" . $safeIdPart;
							$dropdown_id = "dropdown-" . $safeIdPart;
							$row_id_js = htmlspecialchars(json_encode($row_id), ENT_QUOTES, 'UTF-8');
							$dropdown_id_js = htmlspecialchars(json_encode($dropdown_id), ENT_QUOTES, 'UTF-8');
							$edit_url = 'register_engspr.php?ref_id=' . urlencode($refId);
							$copy_url = 'register_engspr.php?copy_from=' . urlencode($refId);
							$preview_url = 'report_spr1.php?ref_id=' . urlencode($refId);

							/* ===================== Status badge ===================== */
							$statusDoc = (string)$objResult["status_doc"];
							$statusText = $statusDoc;
							$statusClass = 'draft';

							if ($statusDoc === 'Approve') {
								$statusText = 'อนุมัติแล้ว';
								$statusClass = 'approve';
							} else if ($statusDoc === 'ยกเลิก') {
								$statusText = 'ยกเลิก';
								$statusClass = 'cancel';
							} else if ($statusDoc === 'Rejected') {
								$statusText = 'ไม่อนุมัติ';
								$statusClass = 'rejected';
							} else if ($statusDoc === 'Returned') {
								$statusText = 'ส่งกลับ';
								$statusClass = 'returned';
							} else if ($statusDoc === 'Draft') {
								$statusText = 'ยังไม่กดส่ง';
								$statusClass = 'draft';
							} else if ($statusDoc === 'Request') {
								$sprStage = spr_stage_of($objResult);
								if ($sprStage === 'sup') {
									$statusText = 'รอหัวหน้า';
									$statusClass = 'pending-mgr';
								} else if ($sprStage === 'cm') {
									$statusText = 'รอผู้บริหาร';
									$statusClass = 'pending-exec';
								} else {
									// legacy row ที่ยังไม่เคยผ่าน routing ใหม่ (send_sup/send_cm ไม่ตรงเงื่อนไขใด) —
									// แสดงค่าดิบไว้ก่อน ไม่เดาสถานะและไม่แก้ไขข้อมูลในฐานข้อมูล
									$statusText = $statusDoc;
									$statusClass = 'draft';
								}
							} else if ($statusDoc === '') {
								$statusText = '-';
								$statusClass = 'draft';
							}
						?>
							<tr class="so-row" role="button" tabindex="0" aria-expanded="false" onclick="toggleRow(<?php echo $row_id_js; ?>, this)">
								<td style="text-align:center;"><img src="img/icons/arrow_down.png" class="caret-icon" style="width:12px; height:12px;" alt=""></td>
								<td><a href="<?php echo $edit_url; ?>" style="color:#612989; text-decoration:underline; font-weight:500;" onclick="event.stopPropagation();"><?php echo htmlspecialchars($refId); ?></a></td>
								<td><?php echo DateThai($objResult["spr_date"]); ?></td>
								<td><?php echo htmlspecialchars($objResult["spr_no"]); ?></td>
								<td><?php echo htmlspecialchars($objResult["wo_no"]); ?></td>
								<td><div align="left"><?php echo htmlspecialchars($objResult["customer"]); ?></div></td>
								<td><div align="left"><?php echo htmlspecialchars($objResult["sale_code"]); ?></div></td>
								<td>
									<span class="badge-status <?php echo htmlspecialchars($statusClass); ?>"><?php echo htmlspecialchars($statusText); ?></span>
								</td>
								<td style="text-align:center; position:relative;">
									<div class="so-dropdown">
										<button type="button" class="so-dropdown-trigger" aria-label="ตัวเลือกเพิ่มเติม" aria-haspopup="true" aria-expanded="false" onclick="toggleDropdown(event, <?php echo $dropdown_id_js; ?>)">
											<i class="fas fa-ellipsis-v"></i>
										</button>
										<div id="<?php echo htmlspecialchars($dropdown_id); ?>" class="so-dropdown-menu">
											<a href="<?php echo $edit_url; ?>" class="so-dropdown-item">
												<i class="fas fa-edit" style="width:16px;"></i> แก้ไข
											</a>
											<a href="<?php echo $copy_url; ?>" class="so-dropdown-item">
												<i class="fas fa-copy" style="width:16px;"></i> Duplicate
											</a>
											<a href="<?php echo $preview_url; ?>" target="_blank" rel="noopener noreferrer" class="so-dropdown-item" onclick="event.stopPropagation();">
												<i class="fas fa-search" style="width:16px;"></i> Preview
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
														<th width="28%">รายการสินค้า</th>
														<th width="14%">S/N</th>
														<th width="18%">เคลียร์ยืม</th>
														<th width="10%" style="text-align:center;">จำนวน</th>
														<th width="14%" style="text-align:right !important;">ราคา/หน่วย</th>
														<th width="16%" style="text-align:right !important;">ยอดรวม</th>
													</tr>
												</thead>
												<tbody>
													<?php
													$sprItemRows = spr_load_items($conn, $refId);
													$sprItemsTotal = 0.0;

													if (count($sprItemRows) === 0) {
													?>
														<tr>
															<td colspan="6" style="text-align:center; color:#8E8B94; padding:20px;">ไม่มีรายการสินค้า</td>
														</tr>
													<?php
													} else {
														foreach ($sprItemRows as $sprItemRow) {
															$sprSaleCount = (float)($sprItemRow['sale_count'] ?? 0);
															$sprUnitPrice = (float)($sprItemRow['unit_price'] ?? 0);
															$sprSumAmount = (float)($sprItemRow['sum_amount'] ?? ($sprSaleCount * $sprUnitPrice));
															$sprItemsTotal += $sprSumAmount;
													?>
															<tr>
																<td><?php echo htmlspecialchars((string)($sprItemRow['sol_name'] ?? '-')); ?></td>
																<td><?php echo htmlspecialchars(((string)($sprItemRow['sn'] ?? '')) !== '' ? (string)$sprItemRow['sn'] : '-'); ?></td>
																<td>
																	<?php if ((string)($sprItemRow['clear_br'] ?? '0') === '1') { ?>
																		<span style="display:inline-flex; align-items:center; gap:6px;">
																			<img src="img/icons/checkmark.png" alt="เคลียร์แล้ว" style="width:18px; height:18px; flex-shrink:0;">
																			<span><?php echo htmlspecialchars(trim((string)($sprItemRow['clear_ivno'] ?? '')) !== '' ? (string)$sprItemRow['clear_ivno'] : 'เคลียร์แล้ว'); ?></span>
																		</span>
																	<?php } else { ?>
																		-
																	<?php } ?>
																</td>
																<td style="text-align:center;"><?php echo number_format($sprSaleCount); ?></td>
																<td style="text-align:right;"><?php echo number_format($sprUnitPrice, 2); ?></td>
																<td style="text-align:right;"><?php echo number_format($sprSumAmount, 2); ?></td>
															</tr>
													<?php
														}
													?>
															<tr style="border-top: 1px solid #EDE9F0;">
																<td colspan="5" style="text-align:right; font-weight:500; padding: 14px 12px !important; font-size: 14px; color: #3B3B3B;">ยอดรวม</td>
																<td style="text-align:right; font-size:16px; color:#612989; font-weight:600; padding: 14px 12px !important;"><?php echo number_format($sprItemsTotal, 2); ?></td>
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
