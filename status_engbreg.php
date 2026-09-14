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
				<h4 style="margin:0;">BREG</h4>
			</div>

			<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME']; ?>">
				<div class="so-input-group" style="align-items: flex-end; margin-bottom: 20px;">
					<div style="flex: 1; max-width: 680px; min-width: 250px; display: flex; flex-direction: column; gap: 6px;">
						<label for="Keyword" style="font-size: 14px; color: #612989; font-weight: 500;">ค้นหาด้วยเลขที่เอกสาร/ชื่อพนักงาน</label>
						<div style="display: flex; gap: 12px; align-items: center;">
							<div class="so-search-wrapper" style="flex: 1; width: auto;">
								<i class="fas fa-search so-search-icon"></i>
								<input name="Keyword" id="Keyword" class="so-input" type="text" placeholder="Search" value="<?php echo htmlspecialchars(isset($_GET['Keyword']) ? $_GET['Keyword'] : ''); ?>">
							</div>
							<a href="register_bregawl.php" class="btn-so-outline" style="flex-shrink: 0; font-weight: 500;">
								<img src="img/icons/add_message.png" alt=""> เพิ่ม BREG
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
										<?php
										$bregStatusFilterOptions = array(
											'draft'       => 'ร่าง',
											'pending_sup' => 'รอหัวหน้า',
											'pending_dm'  => 'รอผู้บริหาร',
											'returned'    => 'ส่งกลับ',
											'approve'     => 'อนุมัติแล้ว',
											'rejected'    => 'ไม่อนุมัติ',
											'cancel'      => 'ยกเลิก',
										);
										$bregSelectedStatusApprove = isset($_GET['status_approve']) ? $_GET['status_approve'] : '';
										foreach ($bregStatusFilterOptions as $bregOptValue => $bregOptLabel) {
											$bregSel = ($bregSelectedStatusApprove === $bregOptValue) ? 'selected' : '';
											echo '<option value="' . htmlspecialchars($bregOptValue) . '" ' . $bregSel . '>' . htmlspecialchars($bregOptLabel) . '</option>';
										}
										?>
									</select>
								</div>
								<div>
									<label class="so-label" for="sale_code">เขตการขาย</label>
									<select name="sale_code" id="sale_code" class="so-select">
										<option value="">-- ทั้งหมด --</option>
										<?php
										$bregSelectedSaleCode = isset($_GET['sale_code']) ? $_GET['sale_code'] : '';
										$strSQL5 = "SELECT * FROM tb_team_adm where ckk ='0' ORDER BY sale_code ASC";
										$objQuery5 = mysqli_query($com, $strSQL5);
										while ($objResuut5 = mysqli_fetch_array($objQuery5)) {
											$sel = ($bregSelectedSaleCode == $objResuut5["sale_code"]) ? "selected" : "";
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
							<th style="white-space:nowrap;">ชื่อพนักงาน</th>
							<th style="white-space:nowrap; width:10%;">สถานะการอนุมัติ</th>
							<th style="white-space:nowrap;">อนุมัติโดย Sup</th>
							<th style="white-space:nowrap;">อนุมัติโดยผู้บริหาร</th>
							<th width="5%" style="text-align:center;"></th>
						</tr>
					</thead>
					<tbody>

						<?php

						date_default_timezone_set("Asia/Bangkok");

						$strSQL = "SELECT *  FROM hos__breg  where 1 ";

						if ($start_date != "") {
							$strSQL .= ' AND register_date >= "' . $start_date . '"';
						}

						if ($end_date != "") {
							$strSQL .= ' AND register_date <= "' . $end_date . '"';
						}

						if ($sale_code != "") {
							$strSQL .= ' AND sale_code = "' . mysqli_real_escape_string($conn, $sale_code) . '"';
						}

						/* สถานะการอนุมัติ — map ตาม (status_doc, send_sup, send_dm) แบบเดียวกับ
						   register_bregawl.php ไม่ใช่แค่ status_doc ตรง ๆ เพราะ Request เพียงค่าเดียว
						   ครอบคลุมทั้งรอหัวหน้า/รอผู้บริหาร/ถูกส่งกลับ แยกกันด้วย send_sup/send_dm เท่านั้น */
						$bregStatusFilterSql = array(
							'draft'       => " AND status_doc = 'Draft'",
							'pending_sup' => " AND status_doc = 'Request' AND send_sup = '1' AND send_dm = '0'",
							'pending_dm'  => " AND status_doc = 'Request' AND send_sup = '1' AND send_dm = '1'",
							'returned'    => " AND status_doc = 'Request' AND send_sup = '0' AND send_dm = '0'",
							'approve'     => " AND status_doc = 'Approve'",
							'rejected'    => " AND status_doc = 'Rejected'",
							'cancel'      => " AND status_doc = 'ยกเลิก'",
						);
						if ($status_approve != "" && isset($bregStatusFilterSql[$status_approve])) {
							$strSQL .= $bregStatusFilterSql[$status_approve];
						}

						if ($Keyword != "") {
							$strSQL .= ' AND (customer_name  LIKE "%' . $Keyword . '%"';
							$strSQL .= ' or iv_no  LIKE "%' . $Keyword . '%"';
							$strSQL .= ' or ref_id  LIKE "%' . $Keyword . '%"';
							$strSQL .= ' or add_by  LIKE "%' . $Keyword . '%")';
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


						$strSQL .= " order  by ref_id DESC   LIMIT $Page_Start , $Per_Page";
						$objQuery  = mysqli_query($conn, $strSQL);
						$Page_Num_Rows = $objQuery ? mysqli_num_rows($objQuery) : 0;

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
						while ($objResult = mysqli_fetch_array($objQuery)) {
							$row_id = "row-" . $objResult["ref_id"];
							$dropdown_id = "dropdown-" . $objResult["ref_id"];
							$row_id_js = htmlspecialchars(json_encode($row_id), ENT_QUOTES, 'UTF-8');
							$dropdown_id_js = htmlspecialchars(json_encode($dropdown_id), ENT_QUOTES, 'UTF-8');
							$edit_url = 'register_bregawl.php?ref_id=' . urlencode($objResult["ref_id"]);
							$copy_url = 'register_bregawl.php?copy_from=' . urlencode($objResult["ref_id"]);
							$preview_url = 'register_bregawl.php?ref_id=' . urlencode($objResult["ref_id"]);

							$sendSup = (string)$objResult["send_sup"];
							$sendDm = (string)$objResult["send_dm"];
							$statusDoc = (string)$objResult["status_doc"];
						?>
							<tr class="so-row" onclick="toggleRow(<?php echo $row_id_js; ?>, this)">
								<td style="text-align:center;"><img src="img/icons/arrow_down.png" class="caret-icon" style="width:12px; height:12px;" alt=""></td>
								<td><a href="<?php echo $edit_url; ?>" style="color:#612989; text-decoration:underline; font-weight:500;" onclick="event.stopPropagation();"><?php echo htmlspecialchars($objResult["ref_id"]); ?></a></td>
								<td><?php echo DateThai($objResult["register_date"]); ?></td>
								<td><?php echo htmlspecialchars($objResult["iv_no"]); ?></td>
								<td>
									<?php if ($objResult["iv_date"] == "0000-00-00 00:00:00" || $objResult["iv_date"] == "0000-00-00") {
										echo "-";
									} else {
										echo DateThai($objResult["iv_date"]);
									}
									?>
								</td>
								<td>
									<div align="left"><?php echo htmlspecialchars($objResult["add_by"]); ?></div>
								</td>
								<td>
									<?php if ($statusDoc == 'Rejected') { ?>
										<span class="badge-status rejected">ไม่อนุมัติ</span>
									<?php } else if ($statusDoc == 'ยกเลิก') { ?>
										<span class="badge-status cancel">ยกเลิก</span>
									<?php } else if ($statusDoc == 'Approve') { ?>
										<span class="badge-status approve">อนุมัติแล้ว</span>
									<?php } else if ($statusDoc == 'Draft') { ?>
										<span class="badge-status draft">ร่าง</span>
									<?php } else if ($statusDoc == 'Request' && $sendSup === '1' && $sendDm === '1') { ?>
										<span class="badge-status pending-exec">รอผู้บริหาร</span>
									<?php } else if ($statusDoc == 'Request' && $sendSup === '1' && $sendDm === '0') { ?>
										<span class="badge-status pending-mgr">รอหัวหน้า</span>
									<?php } else if ($statusDoc == 'Request' && $sendSup === '0' && $sendDm === '0') { ?>
										<span class="badge-status returned">ส่งกลับ</span>
									<?php } else { ?>
										<span class="badge-status draft"><?php echo htmlspecialchars($statusDoc); ?></span>
									<?php } ?>
								</td>
								<td>
									<div align="left"><?php echo htmlspecialchars($objResult["sup_name"]); ?> <br>
										<?php echo ($objResult["sup_date"] == "0000-00-00 00:00:00" || $objResult["sup_date"] == "" || $objResult["sup_date"] === null) ? "-" : DateThai($objResult["sup_date"]); ?>
									</div>
								</td>
								<td>
									<div align="left"><?php echo htmlspecialchars($objResult["dm_name"]); ?> <br>
										<?php echo ($objResult["dm_date"] == "0000-00-00 00:00:00" || $objResult["dm_date"] == "" || $objResult["dm_date"] === null) ? "-" : DateThai($objResult["dm_date"]); ?>
									</div>
								</td>
								<td style="text-align:center; position:relative;">
									<div class="so-dropdown">
										<button type="button" class="so-dropdown-trigger" aria-label="ตัวเลือกเพิ่มเติม" onclick="toggleDropdown(event, <?php echo $dropdown_id_js; ?>)">
											<i class="fas fa-ellipsis-v"></i>
										</button>
										<div id="<?php echo htmlspecialchars($dropdown_id); ?>" class="so-dropdown-menu">
											<a href="<?php echo $edit_url; ?>" class="so-dropdown-item">
												<i class="fas fa-edit" style="width:16px;"></i> แก้ไข
											</a>
											<a href="<?php echo $copy_url; ?>" class="so-dropdown-item">
												<i class="fas fa-copy" style="width:16px;"></i> คัดลอกใบเดิม
											</a>
											<a href="<?php echo $preview_url; ?>" class="so-dropdown-item">
												<i class="fas fa-search" style="width:16px;"></i> Preview
											</a>
										</div>
									</div>
								</td>
							</tr>

							<!-- Expanded Row Details -->
							<?php
							$strSQL2 = "SELECT * FROM (hos__subbreg2 LEFT JOIN tb_product ON hos__subbreg2.product_id2=tb_product.product_ID) WHERE ref_id2 = '" . $objResult["ref_id"] . "' ";
							$objQuery2 = mysqli_query($conn, $strSQL2) or die("Error Query [" . $strSQL2 . "]");
							$productRows = array();
							while ($objResult2 = mysqli_fetch_array($objQuery2)) {
								$productRows[] = array(
									'name' => $objResult2["sol_name"],
									'count' => $objResult2["count2"],
								);
							}

							$strSQL1 = "SELECT * FROM (hos__subbreg1 LEFT JOIN tb_product ON hos__subbreg1.product_id1=tb_product.product_ID) WHERE ref_id1 = '" . $objResult["ref_id"] . "' ";
							$objQuery1 = mysqli_query($conn, $strSQL1) or die("Error Query [" . $strSQL1 . "]");
							$partRows = array();
							while ($objResult1 = mysqli_fetch_array($objQuery1)) {
								$partRows[] = array(
									'name' => $objResult1["sol_name"],
									'count' => $objResult1["count1"],
								);
							}

							$itemRowCount = max(count($productRows), count($partRows));
							if ($itemRowCount === 0) {
							?>
								<tr class="expanded-row" data-row="<?php echo htmlspecialchars($row_id); ?>" style="display:none; background: #F1E1FF !important;">
									<td></td>
									<td colspan="9" style="padding: 10px 16px !important; font-size: 15px; color: #6B6875; text-align: left; vertical-align: middle; border-bottom: 1px solid #EDE9F0;">ไม่มีรายการสินค้า/อะไหล่</td>
								</tr>
							<?php
							}

							for ($itemIndex = 0; $itemIndex < $itemRowCount; $itemIndex++) {
								$productName = isset($productRows[$itemIndex]) ? $productRows[$itemIndex]['name'] : '-';
								$partName = isset($partRows[$itemIndex]) ? $partRows[$itemIndex]['name'] : '-';
								$itemCount = isset($partRows[$itemIndex]) ? $partRows[$itemIndex]['count'] : (isset($productRows[$itemIndex]) ? $productRows[$itemIndex]['count'] : '');
							?>
								<tr class="expanded-row" data-row="<?php echo htmlspecialchars($row_id); ?>" style="display:none; background: #F1E1FF !important;">
									<td></td>
									<td colspan="3" style="padding: 10px 16px !important; font-size: 15px; color: #3B3B3B; text-align: left; vertical-align: middle; border-bottom: 1px solid #EDE9F0;">
										<?php if ($itemIndex === 0) { ?>
											<strong style="display: block; margin-bottom: 4px;">รายการสินค้า</strong>
										<?php } ?>
										<?php echo htmlspecialchars($productName); ?>
									</td>
									<td colspan="4" style="padding: 10px 16px !important; font-size: 15px; color: #3B3B3B; text-align: left; vertical-align: middle; border-bottom: 1px solid #EDE9F0;">
										<?php if ($itemIndex === 0) { ?>
											<strong style="display: block; margin-bottom: 4px;">รายการอะไหล่</strong>
										<?php } ?>
										<?php echo htmlspecialchars($partName); ?>
									</td>
									<td colspan="2" style="padding: 10px 16px !important; font-size: 15px; color: #3B3B3B; text-align: center; vertical-align: middle; border-bottom: 1px solid #EDE9F0;">
										<?php if ($itemIndex === 0) { ?>
											<strong style="display: block; margin-bottom: 4px; text-align: center;">จำนวน</strong>
										<?php } ?>
										<?php echo ($itemCount === '' || $itemCount === null) ? '-' : number_format((float)$itemCount); ?>
									</td>
								</tr>
							<?php
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
</body>

</html>