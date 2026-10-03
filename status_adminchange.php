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
				<h4 style="margin:0;">รายการแลกเปลี่ยน</h4>
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
							<a href="register_supchange.php" class="btn-so-outline" style="flex-shrink: 0; font-weight: 500;">
								<img src="img/icons/add_message.png" alt=""> เพิ่มใบแลกเปลี่ยน
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

							<!-- Row 2: สถานะการอนุมัติ + เขตการขาย -->
							<div class="so-form-row" style="align-items: flex-start;">
								<div>
									<label class="so-label" for="status_approve">สถานะการอนุมัติ</label>
									<select name="status_approve" id="status_approve" class="so-select">
										<option value="">-- ทั้งหมด --</option>
										<option value="Request" <?php echo (isset($_GET['status_approve']) && $_GET['status_approve'] == 'Request') ? 'selected' : ''; ?>>รอหัวหน้า</option>
										<option value="Draft" <?php echo (isset($_GET['status_approve']) && $_GET['status_approve'] == 'Draft') ? 'selected' : ''; ?>>Draft</option>
										<option value="Approve" <?php echo (isset($_GET['status_approve']) && $_GET['status_approve'] == 'Approve') ? 'selected' : ''; ?>>อนุมัติแล้ว</option>
										<option value="ส่งกลับ" <?php echo (isset($_GET['status_approve']) && $_GET['status_approve'] == 'ส่งกลับ') ? 'selected' : ''; ?>>ส่งกลับ</option>
										<option value="ยกเลิก" <?php echo (isset($_GET['status_approve']) && $_GET['status_approve'] == 'ยกเลิก') ? 'selected' : ''; ?>>ยกเลิก</option>
									</select>
								</div>
								<div>
									<label class="so-label" for="sale_code">เขตการขาย</label>
									<select name="sale_code" id="sale_code" class="so-select">
										<option value="">-- ทั้งหมด --</option>
										<?php
										$selected_sale = isset($_GET['sale_code']) ? $_GET['sale_code'] : '';
										$strSQL5 = "SELECT * FROM tb_team_adm where ckk ='0' ORDER BY sale_code ASC";
										$objQuery5 = mysqli_query($com, $strSQL5);
										while ($objResuut5 = mysqli_fetch_array($objQuery5)) {
											$sel = ($selected_sale == $objResuut5["sale_code"]) ? "selected" : "";
										?>
											<option value="<?php echo $objResuut5["sale_code"]; ?>" <?php echo $sel; ?>><?php echo $objResuut5["sale_code"]; ?> - <?php echo $objResuut5["sale_name"]; ?></option>
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
							<th style="white-space:nowrap;">วันที่ออกเอกสาร</th>
							<th style="white-space:nowrap;">ชื่อลูกค้า</th>
							<th style="white-space:nowrap;">เขตการขาย</th>
							<th style="white-space:nowrap; width:10%;">สถานะการอนุมัติ</th>
							<th width="5%" style="text-align:center;"></th>
						</tr>
					</thead>
					<tbody>

						<?php

						date_default_timezone_set("Asia/Bangkok");

						$strSQL = "SELECT *  FROM hos__change  where status_doc !='Rejected' ";

						if ($start_date != "") {
							$strSQL .= ' AND date_change >= "' . $start_date . '"';
						}

						if ($end_date != "") {
							$strSQL .= ' AND date_change <= "' . $end_date . '"';
						}

						if ($sale_code != "") {
							$strSQL .= ' AND sale_code = "' . $sale_code . '"';
						}

						if ($status_approve != "") {
							$strSQL .= ' AND status_doc = "' . mysqli_real_escape_string($conn, $status_approve) . '"';
						}

						if ($Keyword != "") {
							$strSQL .= ' AND customer  LIKE "%' . $Keyword . '%"';
							$strSQL .= ' or iv_no  LIKE "%' . $Keyword . '%"';
							$strSQL .= ' or status_doc  LIKE "%' . $Keyword . '%"';
							$strSQL .= ' or ref_id  LIKE "%' . $Keyword . '%"';
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


						$strSQL .= " order  by id_change DESC   LIMIT $Page_Start , $Per_Page";
						$objQuery  = mysqli_query($conn, $strSQL);
						$Page_Num_Rows = $objQuery ? mysqli_num_rows($objQuery) : 0;

						?>

						<?php if ($Page_Num_Rows === 0) { ?>
							<tr>
								<td colspan="9" style="text-align:center; padding:40px 16px; color:#6B6875;">
									<?php echo ($Num_Rows > 0)
										? 'ไม่พบข้อมูลในหน้านี้ — ลองกลับไปหน้าแรก'
										: 'ไม่พบรายการแลกเปลี่ยนที่ตรงกับเงื่อนไข ลองล้างตัวกรองหรือเปลี่ยนคำค้น'; ?>
								</td>
							</tr>
						<?php } ?>

						<?php
						while ($objResult = mysqli_fetch_array($objQuery)) {
							$row_id = "row-" . $objResult["ref_id"];
							$dropdown_id = "dropdown-" . $objResult["ref_id"];
							$row_id_js = htmlspecialchars(json_encode($row_id), ENT_QUOTES, 'UTF-8');
							$dropdown_id_js = htmlspecialchars(json_encode($dropdown_id), ENT_QUOTES, 'UTF-8');
						?>
							<tr class="so-row" onclick="toggleRow(<?php echo $row_id_js; ?>, this)">
								<td style="text-align:center;"><img src="img/icons/arrow_down.png" class="caret-icon" style="width:12px; height:12px;" alt=""></td>
								<td><a href="register_supchange.php?ref_id=<?php echo urlencode($objResult["ref_id"]); ?>&start_date=<?php echo urlencode($start_date); ?>&end_date=<?php echo urlencode($end_date); ?>" style="color:#612989; text-decoration:underline; font-weight:500;"><?php echo htmlspecialchars($objResult["ref_id"]); ?></a></td>
								<td><?php echo DateThai($objResult["date_change"]); ?></td>
								<td><?php echo htmlspecialchars($objResult["iv_no"]); ?></td>
								<td>
									<?php if ($objResult["iv_date"] == "0000-00-00") {
										echo "-";
									} else {
										echo DateThai($objResult["iv_date"]);
									}
									?>
								</td>
								<td>
									<div align="left"><?php echo htmlspecialchars($objResult["customer"]); ?></div>
								</td>
								<td>
									<div align="left"><?php echo htmlspecialchars($objResult["sale_code"]); ?></div>
								</td>
								<td>
									<?php if ($objResult["status_doc"] == 'Rejected') { ?>
										<span class="badge-status rejected">ไม่อนุมัติ</span>
									<?php } else if ($objResult["status_doc"] == 'ยกเลิก') { ?>
										<span class="badge-status cancel">ยกเลิก</span>
									<?php } else if ($objResult["status_doc"] == 'Approve') { ?>
										<span class="badge-status approve">อนุมัติแล้ว</span>
									<?php } else if ($objResult["status_doc"] == 'Request') { ?>
										<span class="badge-status pending-mgr">รอหัวหน้า</span>
									<?php } else if ($objResult["status_doc"] == 'Draft') { ?>
										<span class="badge-status draft">Draft</span>
									<?php } else if ($objResult["status_doc"] == 'ส่งกลับ') { ?>
										<span class="badge-status returned">ส่งกลับ</span>
									<?php } else { ?>
										<span class="badge-status draft"><?php echo htmlspecialchars($objResult["status_doc"]); ?></span>
									<?php } ?>
								</td>
								<td style="text-align:center; position:relative;">
									<?php
									$has_edit    = ($objResult["close_mount"] == '0');
									$has_preview = ($objResult["send_admin"] == '1' && ($objResult["company"] == '1' || $objResult["company"] == '2'));
									?>
									<div class="so-dropdown">
										<button type="button" class="so-dropdown-trigger" aria-label="ตัวเลือกเพิ่มเติม" onclick="toggleDropdown(event, <?php echo $dropdown_id_js; ?>)">
											<i class="fas fa-ellipsis-v"></i>
										</button>
										<div id="<?php echo htmlspecialchars($dropdown_id); ?>" class="so-dropdown-menu">
											<?php if ($has_edit) { ?>
												<a href="register_supchange.php?ref_id=<?php echo urlencode($objResult["ref_id"]); ?>&start_date=<?php echo urlencode($start_date); ?>&end_date=<?php echo urlencode($end_date); ?>" class="so-dropdown-item">
													<i class="fas fa-edit" style="width:16px;"></i> แก้ไข
												</a>
											<?php } ?>
											<a class="so-dropdown-item" href="javascript:void(0);" onclick="if(confirm('!!!ต้องการเพิ่มเอกสารใหม่โดยCopyเอกสารเดิมใช่หรือไม่')) { window.location='register_supchange.php?copy_from=<?php echo urlencode($objResult["ref_id"]); ?>'; }">
												<i class="fas fa-copy" style="width:16px;"></i> คัดลอกใบเดิม
											</a>
											<?php if ($has_preview) {
												$preview_url = ($objResult["company"] == '1') ? 'report_changehosptl.php' : 'report_changehosnbm.php';
											?>
												<a href="<?php echo $preview_url; ?>?ref_id=<?php echo urlencode($objResult["ref_id"]); ?>" class="so-dropdown-item" target="_blank">
													<i class="fas fa-search" style="width:16px;"></i> Preview
												</a>
												<a href="report_changhos1.php?ref_id=<?php echo urlencode($objResult["ref_id"]); ?>" class="so-dropdown-item" target="_blank">
													<i class="fas fa-print" style="width:16px;"></i> Print ต่อเนื่อง
												</a>
											<?php } ?>
										</div>
									</div>
								</td>
							</tr>

							<!-- Expanded Row Details -->
							<?php
							$strSQL1 = "SELECT * FROM (hos__subchange LEFT JOIN tb_product ON hos__subchange.product_ID=tb_product.product_id) WHERE ref_idd = '" . $objResult["ref_id"] . "' ";
							$objQuery1 = mysqli_query($conn, $strSQL1) or die("Error Query [" . $strSQL1 . "]");
							$is_first = true;
							while ($objResult1 = mysqli_fetch_array($objQuery1)) {
							?>
								<tr class="expanded-row" data-row="<?php echo htmlspecialchars($row_id); ?>" style="display:none; background: #F1E1FF !important;">
									<td></td>
									<td colspan="4" style="padding: 10px 16px !important; font-size: 15px; color: #3B3B3B; text-align: left; vertical-align: middle; border-bottom: 1px solid #EDE9F0;">
										<?php if ($is_first) { ?>
											<strong style="display: block; margin-bottom: 4px;">รายการสินค้า</strong>
										<?php } ?>
										<?php echo htmlspecialchars($objResult1["sol_name"]); ?>
									</td>
									<td colspan="4" style="padding: 10px 16px !important; font-size: 15px; color: #3B3B3B; text-align: center; vertical-align: middle; border-bottom: 1px solid #EDE9F0;">
										<?php if ($is_first) { ?>
											<strong style="display: block; margin-bottom: 4px; text-align: center;">จำนวน</strong>
										<?php } ?>
										<?php echo number_format($objResult1["count_sale"]); ?>
									</td>
								</tr>
							<?php
								$is_first = false;
							}
							?>
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
						echo "<a class='pagination-btn' href='$_SERVER[SCRIPT_NAME]?Page=$Prev_Page$pagParams'><i class='fas fa-chevron-left'></i></a>";
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

			document.querySelectorAll('.so-dropdown-menu').forEach(m => {
				if (m !== menu) m.classList.remove('show');
			});

			if (menu) {
				const isShowing = menu.classList.contains('show');
				if (!isShowing) {
					const trigger = event.currentTarget;
					const rect = trigger.getBoundingClientRect();

					menu.style.position = 'fixed';

					menu.style.display = 'block';
					const menuWidth = menu.offsetWidth || 186;
					menu.style.display = '';

					const top = rect.bottom;
					let left = rect.right - menuWidth;

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
	<?php include('foot.php'); ?>
</body>

</html>