<?php include('head.php');
include 'partials/so_status_ui.php';

include "dbconnect.php";
include "dbconnect_sale.php";

?>

<body>
	<div class="status-so-page">
		<div class="so-card">
			<div class="w3-container w3-bar w3-margin-bottom" style="padding-left:0;padding-right:0;">
				<h4 style="margin:0;">รายการใบจองสินค้า</h4>
			</div>

			<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME']; ?>">
				<div class="so-input-group" style="align-items: flex-end; margin-bottom: 20px;">
					<div style="flex: 1; max-width: 680px; min-width: 250px; display: flex; flex-direction: column; gap: 6px;">
						<div style="font-size: 14px; color: #612989; font-weight: 500;">ค้นหาด้วยเลขที่เอกสาร/ชื่อลูกค้า</div>
						<div style="display: flex; gap: 12px; align-items: center;">
							<div class="so-search-wrapper" style="flex: 1; width: auto;">
								<i class="fas fa-search so-search-icon"></i>
								<input name="Keyword" class="so-input" type="text" placeholder="ค้นหา..." value="<?php echo htmlspecialchars(isset($_GET['Keyword']) ? $_GET['Keyword'] : ''); ?>">
							</div>
							<a href="register_supbook.php" class="btn-so-outline" style="flex-shrink: 0; font-weight: 500;">
								<img src="img\icons\add_message.png" alt=""> เพิ่มใบจอง
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
								<span onclick="closeFilterModal()" style="font-size:28px; cursor:pointer; color:#8E8B94; line-height:1;">&times;</span>
							</div>

							<!-- Row 1: ช่วงวันที่ -->
							<div class="so-form-row">
								<div>
									<label class="so-label" style="color:#612989; font-size:13px; font-weight:500; display:block; margin-bottom:6px;">ตั้งแต่วันที่</label>
									<input type="date" name="start_date" id="start_date" class="so-select so-modal-input" value="<?php echo htmlspecialchars(isset($_GET['start_date']) ? $_GET['start_date'] : ''); ?>">
								</div>
								<div>
									<label class="so-label" style="color:#612989; font-size:13px; font-weight:500; display:block; margin-bottom:6px;">ถึงวันที่</label>
									<input type="date" name="end_date" id="end_date" class="so-select so-modal-input" value="<?php echo htmlspecialchars(isset($_GET['end_date']) ? $_GET['end_date'] : ''); ?>">
								</div>
							</div>

							<!-- Row 2: สถานะการอนุมัติ + ประเภทใบจอง -->
							<div class="so-form-row">
								<div>
									<label class="so-label" style="color:#612989; font-size:13px; font-weight:500; display:block; margin-bottom:6px;">สถานะการอนุมัติ</label>
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
									<label class="so-label" style="color:#612989; font-size:13px; font-weight:500; display:block; margin-bottom:6px;">ประเภทใบจอง</label>
									<select name="type_jong" id="type_jong" class="so-select">
										<option value="">-- ทั้งหมด --</option>
										<option value="1" <?php echo (isset($_GET['type_jong']) && $_GET['type_jong'] == '1') ? 'selected' : ''; ?>>จองมีสัญญา</option>
										<option value="2" <?php echo (isset($_GET['type_jong']) && $_GET['type_jong'] == '2') ? 'selected' : ''; ?>>จองตามการประมาณการ</option>
										<option value="3" <?php echo (isset($_GET['type_jong']) && $_GET['type_jong'] == '3') ? 'selected' : ''; ?>>จองสินค้าสาธิต</option>
									</select>
								</div>
							</div>

							<!-- Row 3: เขตการขาย + สถานะใบจอง -->
							<div class="so-form-row" style="align-items: flex-start;">
								<div>
									<label class="so-label" style="color:#612989; font-size:13px; font-weight:500; display:block; margin-bottom:6px;">เขตการขาย</label>
									<?php
									$selected_sale = isset($_GET['sale_code']) ? $_GET['sale_code'] : '';
									if ($_SESSION['code'] == 'SS1') {
										$strSQL5 = "SELECT * FROM tb_team_ss1 ORDER BY sale_code ASC";
									} else if ($_SESSION['code'] == 'SUP_MK') {
										$strSQL5 = "SELECT * FROM tb_team_allwell ORDER BY sale_code ASC";
									} else if ($_SESSION['code'] == 'SS2') {
										$strSQL5 = "SELECT * FROM tb_team_ss2 ORDER BY sale_code ASC";
									} else if ($_SESSION['code'] == 'SS3') {
										$strSQL5 = "SELECT * FROM tb_team_ss3 ORDER BY sale_code ASC";
									} else if ($_SESSION['code'] == 'SS5') {
										$strSQL5 = "SELECT * FROM tb_team_ss3 WHERE sale_code IN ('S31','S32') ORDER BY sale_code ASC";
									} else if ($_SESSION['code'] == 'SUP_EN') {
										$strSQL5 = "SELECT * FROM tb_team_en ORDER BY sale_code ASC";
									} else {
										$strSQL5 = "SELECT * FROM tb_team_all ORDER BY sale_code ASC";
									}
									$objQuery5 = mysqli_query($com, $strSQL5);
									?>
									<select name="sale_code" id="sale_code" class="so-select">
										<option value="">-- ทั้งหมด --</option>
										<?php while ($objResuut5 = mysqli_fetch_array($objQuery5)) {
											$sel = ($selected_sale == $objResuut5["sale_code"]) ? "selected" : ""; ?>
											<option value="<?php echo $objResuut5["sale_code"]; ?>" <?php echo $sel; ?>><?php echo $objResuut5["sale_code"]; ?> - <?php echo $objResuut5["sale_name"]; ?></option>
										<?php } ?>
									</select>
								</div>
								<div>
									<label class="so-label" style="color:#612989; font-size:13px; font-weight:500; display:block; margin-bottom:6px;">สถานะใบจอง</label>
									<select name="status_jong" id="status_jong" class="so-select">
										<option value="">-- ทั้งหมด --</option>
										<option value="open" <?php echo (isset($_GET['status_jong']) && $_GET['status_jong'] == 'open') ? 'selected' : ''; ?>>ใบจองคงค้าง</option>
										<option value="closed" <?php echo (isset($_GET['status_jong']) && $_GET['status_jong'] == 'closed') ? 'selected' : ''; ?>>ใบจองเคลียร์ครบแล้ว</option>
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
			$sale_code     = isset($_GET['sale_code'])      ? $_GET['sale_code']      : '';
			$status_approve = isset($_GET['status_approve']) ? $_GET['status_approve'] : '';
			$type_jong     = isset($_GET['type_jong'])      ? $_GET['type_jong']      : '';
			$status_jong   = isset($_GET['status_jong'])    ? $_GET['status_jong']    : '';

			?>

			<div class="so-table-wrapper">
				<table class="so-table">
					<thead>
						<tr>
							<th width="3%"></th>
							<th style="white-space:nowrap;">เลขที่อ้างอิง</th>
							<th style="white-space:nowrap;">วันที่ลงทะเบียน</th>
							<th style="white-space:nowrap;">เลขที่ใบจอง</th>
							<th style="white-space:nowrap;">วันที่ต้องการสินค้า</th>
							<th style="white-space:nowrap;">ชื่อลูกค้า</th>
							<th style="white-space:nowrap;">หมายเหตุ</th>
							<th style="white-space:nowrap;">เขตการขาย</th>
							<th style="white-space:nowrap;">สถานะ</th>
							<th width="5%" style="text-align:center;"></th>
						</tr>
					</thead>


					<?php

					date_default_timezone_set("Asia/Bangkok");

					$emid = $_SESSION['code'];

					if ($emid == 'SS1') {
						$sddd = " AND sale_code IN ('S15','S16','S21','S22','S14')";
					} else if ($emid == 'SS2') {
						$sddd = " AND sale_code IN ('S11','S12','S17','S24','S13')";
					} else if ($emid == 'SS3') {
						$sddd = " AND sale_code IN ('S31','S32','S33','MM1','SOL1','SOL2','SOL3','SOL4','SOL5','SOL6','SOL7','SOL8','SOL99')";
					} else if ($emid == 'SS5') {
						$sddd = " AND sale_code IN ('S31','S32')";
					} else if ($emid == 'SUP_MK') {
						$sddd = " and sale_code IN ('SOL91','SOL92','SOL93','SOL94','MK') ";
					} else if ($emid == 'SM1') {
						$sddd = " AND sale_code IN ('S31','S32','S33','MM1','MM2','SOL1','SOL2','SOL3','SOL4','SOL5','SOL6','SOL7','SOL8','SOL99')";
					} else if ($emid == 'SUP_EN') {
						$sddd = " and sale_code LIKE '%EN%'";
					} else {
						$sddd = "";
					}



					$strSQL = "SELECT *  FROM hos__jongproduct  where send_sup = '1' $sddd";

					if ($start_date != "") {
						$strSQL .= ' AND date_jong >= "' . $start_date . '"';
					}

					if ($end_date != "") {
						$strSQL .= ' AND date_jong <= "' . $end_date . '"';
					}

					if ($sale_code != "") {
						$strSQL .= ' AND sale_code = "' . $sale_code . '"';
					}

					if ($Keyword != "") {
						$strSQL .= ' AND (customer LIKE "%' . $Keyword . '%"';
						$strSQL .= ' OR iv_no LIKE "%' . $Keyword . '%"';
						$strSQL .= ' OR ref_id LIKE "%' . $Keyword . '%")';
					}

					// Filter: สถานะการอนุมัติ
					if ($status_approve == 'cancel') {
						$strSQL .= " AND cancel_ckk = '1'";
					} else if ($status_approve != '') {
						$strSQL .= " AND status_doc = '" . $conn->real_escape_string($status_approve) . "' AND cancel_ckk = '0' AND close_jong = '0'";
					}

					// Filter: ประเภทใบจอง
					if ($type_jong != '') {
						$strSQL .= " AND type_jong = '" . (int)$type_jong . "'";
					}

					// Filter: สถานะใบจอง
					if ($status_jong == 'open') {
						$strSQL .= " AND close_jong = '0' AND cancel_ckk = '0'";
					} else if ($status_jong == 'closed') {
						$strSQL .= " AND close_jong = '1'";
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


					$strSQL .= " order  by id_jong DESC   LIMIT $Page_Start , $Per_Page";
					$objQuery  = mysqli_query($conn, $strSQL);


					?>


					<?php
					$i = 1;
					while ($objResult = mysqli_fetch_array($objQuery)) {
						$row_id = "row-" . $objResult["ref_id"];
						$dropdown_id = "dropdown-" . $objResult["ref_id"];
					?>
						<tr class="so-row" onclick="toggleRow('<?php echo $row_id; ?>', this)">
							<td style="text-align:center;"><img src="img/icons/arrow_down.png" class="caret-icon" style="width:12px; height:12px;"></td>
							<td><a href="register_supbook.php?ref_id=<?php echo $objResult["ref_id"]; ?>&start_date=<?php echo urlencode($start_date); ?>&end_date=<?php echo urlencode($end_date); ?>" style="color: #612989; text-decoration: underline; font-weight: 500;"><?php echo htmlspecialchars($objResult["ref_id"]); ?></a></td>
							<td><?php echo DateThai($objResult["date_jong"]); ?></td>
							<td><?php echo htmlspecialchars($objResult["iv_no"]); ?></td>
							<td><?php echo Datethai($objResult["date_receive"]); ?></td>
							<td>
								<div align="left"><?php echo htmlspecialchars($objResult["customer"]); ?></div>
							</td>
							<td>
								<div align="left" title="<?php echo htmlspecialchars($objResult["drescription"]); ?>"><?php echo htmlspecialchars(mb_strimwidth($objResult["drescription"], 0, 50, "...")); ?></div>
							</td>
							<td>
								<div align="left"><?php echo htmlspecialchars($objResult["sale_code"]); ?></div>
							</td>
							<td>
								<?php if ($objResult["cancel_ckk"] == '1') { ?>
									<span class="badge-status cancel">ยกเลิก</span>
								<?php } else if ($objResult["status_doc"] == 'Rejected') { ?>
									<span class="badge-status rejected">ไม่อนุมัติ</span>
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
									<button type="button" class="so-dropdown-trigger" onclick="toggleDropdown(event, '<?php echo $dropdown_id; ?>')">
										<i class="fas fa-ellipsis-v"></i>
									</button>
									<div id="<?php echo $dropdown_id; ?>" class="so-dropdown-menu">
										<a href="register_supbook.php?ref_id=<?php echo $objResult["ref_id"]; ?>&start_date=<?php echo urlencode($start_date); ?>&end_date=<?php echo urlencode($end_date); ?>" class="so-dropdown-item">
											<i class="fas fa-edit" style="width:16px;"></i> แก้ไข
										</a>
										<a href="register_supbook.php?ref_id=<?php echo $objResult["ref_id"]; ?>&copy=1" class="so-dropdown-item">
											<i class="fas fa-copy" style="width:16px;"></i> คัดลอกใบเดิม
										</a>
										<a href="report_jongpro.php?ref_id=<?php echo $objResult["ref_id"]; ?>" class="so-dropdown-item" target="_blank">
											<i class="fas fa-print" style="width:16px;"></i> พิมพ์รายงาน
										</a>
									</div>
								</div>
							</td>
						</tr>

						<!-- Expanded Rows Details (Direct Row Injection) -->
						<?php
						$strSQL2 = "SELECT * FROM (hos__subjongpro LEFT JOIN tb_product ON hos__subjongpro.product_ID=tb_product.product_id) WHERE ref_idd = '" . $objResult["ref_id"] . "'  ";
						$objQuery2 = mysqli_query($conn, $strSQL2) or die("Error Query [" . $strSQL2 . "]");
						$is_first = true;
						while ($objResult2 = mysqli_fetch_array($objQuery2)) {
							$displayName = (!empty($objResult2['sol_name'])) ? $objResult2['sol_name'] : ($objResult2['product_name'] ?? $objResult2['product_code']);
						?>
							<tr class="expanded-row <?php echo $row_id; ?>" style="display:none; background: #F1E1FF !important;">
								<td></td>

								<!-- รายการสินค้า ชิดซ้าย -->
								<td colspan="4" style="padding: 10px 16px !important; font-size: 15px; color: #3B3B3B; text-align: left; vertical-align: middle; border-bottom: 1px solid #EDE9F0;">
									<?php if ($is_first) { ?>
										<strong style="display: block; margin-bottom: 4px;">รายการสินค้า</strong>
									<?php } ?>
									<?php echo htmlspecialchars($displayName); ?>
								</td>

								<!-- จำนวน -->
								<td colspan="5" style="padding: 10px 16px !important; font-size: 15px; color: #3B3B3B; text-align: center; vertical-align: middle; border-bottom: 1px solid #EDE9F0;">
									<?php if ($is_first) { ?>
										<strong style="display: block; margin-bottom: 4px; text-align: center;">จำนวน</strong>
									<?php } ?>
									<?php echo number_format($objResult2["count"]); ?>
								</td>
							</tr>
						<?php
							$is_first = false;
						}
						?>
					<?php
						$i++;
					}
					?>
				</table>
			</div> <!-- so-card -->

			<div class="pagination-wrapper">
				<div>
					แสดง <?php echo ($Num_Rows > 0 ? $Page_Start + 1 : 0); ?> ถึง <?php echo min($Page_Start + $Per_Page, $Num_Rows); ?> จาก <?php echo $Num_Rows; ?> รายการ
				</div>
				<div class="pagination-links">
					<?php
					$pagParams = "&Keyword=" . urlencode($Keyword) . "&start_date=" . urlencode($start_date) . "&end_date=" . urlencode($end_date) . "&sale_code=" . urlencode($sale_code);

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
		</div> <!-- status-so-page -->

		<!-- JS Helpers for Expandable Rows, Kebab Dropdowns, and Filter Modal -->
		<script>
			function toggleRow(rowClass, triggerEl) {
				const rows = document.querySelectorAll('.' + rowClass);
				const isVisible = rows.length > 0 && rows[0].style.display !== 'none';

				document.querySelectorAll('.expanded-row').forEach(r => {
					if (!r.classList.contains(rowClass)) r.style.display = 'none';
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