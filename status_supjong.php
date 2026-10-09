<?php include('head.php');

include "dbconnect.php";
include "dbconnect_sale.php";

?>
<link rel="stylesheet" href="css/so-status-ui.css?v=<?php echo filemtime(__DIR__ . '/css/so-status-ui.css'); ?>">
<link rel="stylesheet" href="sweetalert2/dist/sweetalert2.min.css">
<script src="sweetalert2/dist/sweetalert2.min.js"></script>

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
				<h4 style="margin:0;">รายการใบจองสินค้า</h4>
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
							<a href="register_supbook.php" class="btn-so-outline" style="flex-shrink: 0; font-weight: 500;">
								<img src="img/icons/add_message.png" alt=""> เพิ่มใบจอง
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
									<div class="so-input-wrapper calendar-wrapper">
										<input type="date" name="start_date" id="start_date" class="so-select so-modal-input" value="<?php echo htmlspecialchars(isset($_GET['start_date']) ? $_GET['start_date'] : ''); ?>">
									</div>
								</div>
								<div>
									<label class="so-label" for="end_date">ถึงวันที่</label>
									<div class="so-input-wrapper calendar-wrapper">
										<input type="date" name="end_date" id="end_date" class="so-select so-modal-input" value="<?php echo htmlspecialchars(isset($_GET['end_date']) ? $_GET['end_date'] : ''); ?>">
									</div>
								</div>
							</div>

							<!-- Row 2: สถานะการอนุมัติ + ประเภทใบจอง -->
							<div class="so-form-row">
								<div>
									<label class="so-label" for="status_approve">สถานะการอนุมัติ</label>
									<select name="status_approve" id="status_approve" class="so-select">
										<option value="">-- ทั้งหมด --</option>
										<option value="Request" <?php echo (isset($_GET['status_approve']) && $_GET['status_approve'] == 'Request') ? 'selected' : ''; ?>>รอหัวหน้า</option>
										<option value="Draft" <?php echo (isset($_GET['status_approve']) && $_GET['status_approve'] == 'Draft') ? 'selected' : ''; ?>>Draft</option>
										<option value="Approve" <?php echo (isset($_GET['status_approve']) && $_GET['status_approve'] == 'Approve') ? 'selected' : ''; ?>>อนุมัติแล้ว</option>
										<option value="Rejected" <?php echo (isset($_GET['status_approve']) && $_GET['status_approve'] == 'Rejected') ? 'selected' : ''; ?>>ไม่อนุมัติ</option>
										<option value="cancel" <?php echo (isset($_GET['status_approve']) && $_GET['status_approve'] == 'cancel') ? 'selected' : ''; ?>>ยกเลิก</option>
									</select>
								</div>
								<div>
									<label class="so-label" for="type_jong">ประเภทใบจอง</label>
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
									<label class="so-label" for="sale_code">เขตการขาย</label>
									<?php

	$emid = isset($_SESSION['code']) ? trim($_SESSION['code']) : '';
	$type_login = isset($_SESSION['type_login']) ? trim($_SESSION['type_login']) : '';

	$type_login_lower = strtolower($type_login);

	?>

	<?php if ($type_login_lower == 'sale') { ?>

		<!-- Sale ล็อกเขตเป็นของตัวเอง -->
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

			$emid_safe = mysqli_real_escape_string($com, $emid);

			/* Admin / IT / Owner เห็นทั้งหมด */
			if (
				$type_login_lower == 'admin' ||
				$type_login_lower == 'it' ||
				$type_login_lower == 'owner'
			) {

				$strSQL5 = "
					SELECT *
					FROM tb_team_adm
					ORDER BY sale_code ASC
				";

			}

			/* Engineer */
			else if (
				$emid == 'SUP_EN' ||
				$type_login_lower == 'engineer'
			) {

				$strSQL5 = "
					SELECT *
					FROM tb_team_adm
					WHERE sale_code LIKE '%EN%'
					ORDER BY sale_code ASC
				";

			}

			/* SOL */
			else if ($type_login_lower == 'sol') {

				$strSQL5 = "
					SELECT *
					FROM tb_team_adm
					WHERE sale_code IN (
						'SOL1','SOL2','SOL3','SOL4','SOL5',
						'SOL6','SOL7','SOL8','SOL9','SOL0','SM1'
					)
					ORDER BY sale_code ASC
				";

			}

			/* User อื่น อ่านจาก user_sale_permission */
			else {

				$strSQL5 = "
	SELECT DISTINCT t.*
	FROM tb_team_adm t
	INNER JOIN user_sale_permission p
		ON p.sale_code COLLATE utf8mb3_general_ci
		 = t.sale_code COLLATE utf8mb3_general_ci
	WHERE p.em_id = '".$emid_safe."'
	ORDER BY t.sale_code ASC
";

			}


			$objQuery5 = mysqli_query($com, $strSQL5);

			if ($objQuery5) {

				while ($objResuut5 = mysqli_fetch_array($objQuery5)) {

					$selected = '';

					if ($sale_code == $objResuut5["sale_code"]) {
						$selected = 'selected';
					}

			?>

				<option
					value="<?php echo htmlspecialchars(
						$objResuut5["sale_code"],
						ENT_QUOTES,
						'UTF-8'
					); ?>"
					<?php echo $selected; ?>
				>
					<?php echo htmlspecialchars(
						$objResuut5["sale_code"],
						ENT_QUOTES,
						'UTF-8'
					); ?>
					-
					<?php echo htmlspecialchars(
						$objResuut5["sale_name"],
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
								<div>
									<label class="so-label" for="status_jong">สถานะใบจอง</label>
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

			<div class="so-table-wrapper so-table-wrapper--fit">
				<table class="so-table so-table-fit">
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
							<th style="white-space:nowrap; width:10%;">สถานะ</th>
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

					$strSQL = "SELECT * FROM hos__jongproduct WHERE $sddd";

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
					$Page = max(1, (int)($_GET['Page'] ?? 1));

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
					$Page_Num_Rows = $objQuery ? mysqli_num_rows($objQuery) : 0;

					?>


					<?php if ($Page_Num_Rows === 0) { ?>
						<tr>
							<td colspan="10" style="text-align:center; padding:40px 16px; color:#6B6875;">
								<?php echo ($Num_Rows > 0)
									? 'ไม่พบข้อมูลในหน้านี้ — ลองกลับไปหน้าแรก'
									: 'ไม่พบใบจองที่ตรงกับเงื่อนไข ลองล้างตัวกรองหรือเปลี่ยนคำค้น'; ?>
							</td>
						</tr>
					<?php } ?>

					<?php
					$i = 1;
					while ($objResult = mysqli_fetch_array($objQuery)) {
						$row_id = "row-" . $objResult["ref_id"];
						$dropdown_id = "dropdown-" . $objResult["ref_id"];
						// json_encode ต้องผ่าน htmlspecialchars ด้วย มิฉะนั้น double quote ที่ครอบ string
						// จะไปปิด attribute onclick ก่อนกำหนด
						$row_id_js = htmlspecialchars(json_encode($row_id), ENT_QUOTES, 'UTF-8');
						$dropdown_id_js = htmlspecialchars(json_encode($dropdown_id), ENT_QUOTES, 'UTF-8');
						$ref_id_js = htmlspecialchars(json_encode($objResult["ref_id"]), ENT_QUOTES, 'UTF-8');
					?>
						<tr class="so-row" onclick="toggleRow(<?php echo $row_id_js; ?>, this)">
							<td style="text-align:center;"><img src="img/icons/arrow_down.png" class="caret-icon" style="width:12px; height:12px;" alt=""></td>
							<td><a href="register_supbook.php?ref_id=<?php echo urlencode($objResult["ref_id"]); ?>&start_date=<?php echo urlencode($start_date); ?>&end_date=<?php echo urlencode($end_date); ?>" style="color: #612989; text-decoration: underline; font-weight: 500;"><?php echo htmlspecialchars($objResult["ref_id"]); ?></a></td>
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
								<?php } else if ($objResult["status_doc"] == 'Returned') { ?>
									<span class="badge-status rejected">ส่งกลับ</span>
								<?php } else if ($objResult["close_jong"] == '1') { ?>
									<span class="badge-status closed">ปิดใบจอง</span>
								<?php } else if ($objResult["status_doc"] == 'Approve') { ?>
									<span class="badge-status approve">อนุมัติแล้ว</span>
								<?php } else if ($objResult["status_doc"] == 'Request') { ?>
									<span class="badge-status pending-mgr">รอหัวหน้า</span>
								<?php } else if ($objResult["status_doc"] == 'Draft') { ?>
									<span class="badge-status draft">Draft</span>
								<?php } else { ?>
									<span class="badge-status draft"><?php echo htmlspecialchars($objResult["status_doc"]); ?></span>
								<?php } ?>
							</td>
							<td style="text-align:center; position:relative;">
								<div class="so-dropdown">
									<button type="button" class="so-dropdown-trigger" aria-label="ตัวเลือกเพิ่มเติม" onclick="toggleDropdown(event, <?php echo $dropdown_id_js; ?>)">
										<i class="fas fa-ellipsis-v"></i>
									</button>
									<div id="<?php echo htmlspecialchars($dropdown_id); ?>" class="so-dropdown-menu">
										<a href="register_supbook.php?ref_id=<?php echo urlencode($objResult["ref_id"]); ?>&start_date=<?php echo urlencode($start_date); ?>&end_date=<?php echo urlencode($end_date); ?>" class="so-dropdown-item">
											<i class="fas fa-edit" style="width:16px;"></i> แก้ไข
										</a>
										<a href="register_supbook.php?ref_id=<?php echo urlencode($objResult["ref_id"]); ?>&copy=1" class="so-dropdown-item">
											<i class="fas fa-copy" style="width:16px;"></i> คัดลอกใบเดิม
										</a>
										<a href="report_jongpro.php?ref_id=<?php echo urlencode($objResult["ref_id"]); ?>" class="so-dropdown-item" target="_blank">
											<i class="fas fa-print" style="width:16px;"></i> พิมพ์รายงาน
										</a>
										
										<?php 
												
						            if ($type_login_lower == 'sup_sale') { ?>
										<a href="javascript:void(0);" onclick="confirmCloseJongSup(<?php echo $ref_id_js; ?>)" class="so-dropdown-item">
											<i class="fas fa-lock" style="width:16px;"></i> ปิดใบจอง
										</a>
										<?php } ?>
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
							<tr class="expanded-row" data-row="<?php echo htmlspecialchars($row_id); ?>" style="display:none; background: #F1E1FF !important;">
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
						. "&status_approve=" . urlencode($status_approve) . "&type_jong=" . urlencode($type_jong) . "&status_jong=" . urlencode($status_jong);

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
		</div> <!-- so-card -->
	</div> <!-- status-so-page -->

	<!-- JS Helpers for Expandable Rows, Kebab Dropdowns, and Filter Modal -->
		<script>
			function confirmCloseJongSup(refId) {
				Swal.fire({
					title: 'ปิดใบจอง ?',
					text: 'คุณต้องการปิดใบจอง เลขที่เอกสาร " ' + refId + ' " ใช่ไหม ?',
					showCancelButton: true,
					confirmButtonText: 'ตกลง',
					cancelButtonText: 'ยกเลิก',
					reverseButtons: true,
					iconHtml: `
						<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 100%; height: 100%;">
							<path d="M14 2H6C4.9 2 4 2.9 4 4V20C4 21.1 4.9 22 6 22H18C19.1 22 20 21.1 20 20V8L14 2Z" fill="#4A4A4A"/>
							<path d="M14 2V8H20L14 2Z" fill="#333333"/>
							<path d="M9 11L15 17" stroke="#FFFFFF" stroke-width="2.5" stroke-linecap="round"/>
							<path d="M15 11L9 17" stroke="#FFFFFF" stroke-width="2.5" stroke-linecap="round"/>
						</svg>
					`,
					customClass: {
						popup: 'figma-close-so-popup',
						title: 'figma-close-so-title',
						htmlContainer: 'figma-close-so-html',
						confirmButton: 'figma-close-so-confirm-btn',
						cancelButton: 'figma-close-so-cancel-btn',
						actions: 'figma-close-so-actions',
						icon: 'figma-close-so-icon'
					},
					buttonsStyling: false
				}).then(function(result) {
					if (!result.isConfirmed) return;

					Swal.fire({
						title: 'กำลังปิดใบจอง...',
						allowOutsideClick: false,
						allowEscapeKey: false,
						showConfirmButton: false,
						didOpen: function() {
							Swal.showLoading();
						},
						customClass: {
							popup: 'figma-result-popup',
							title: 'figma-result-title'
						}
					});

					fetch('close_jongsup1.php?ref_id=' + encodeURIComponent(refId))
						.then(function(res) {
							return res.json();
						})
						.then(function(data) {
							if (data && data.success) {
								Swal.fire({
									title: data.message || 'ปิดใบจองเรียบร้อยแล้ว',
									icon: 'success',
									confirmButtonText: 'ตกลง',
									iconColor: '#612989',
									customClass: {
										popup: 'figma-result-popup',
										title: 'figma-result-title',
										confirmButton: 'figma-result-confirm-btn',
										actions: 'figma-result-actions'
									},
									buttonsStyling: false
								}).then(function() {
									location.reload();
								});
							} else {
								Swal.fire({
									title: (data && data.message) || 'ไม่สามารถปิดใบจองได้',
									icon: 'error',
									confirmButtonText: 'ตกลง',
									iconColor: '#EF5350',
									customClass: {
										popup: 'figma-result-popup',
										title: 'figma-result-title',
										confirmButton: 'figma-result-confirm-btn',
										actions: 'figma-result-actions'
									},
									buttonsStyling: false
								});
							}
						})
						.catch(function() {
							Swal.fire({
								title: 'เกิดข้อผิดพลาด ไม่สามารถปิดใบจองได้',
								icon: 'error',
								confirmButtonText: 'ตกลง',
								iconColor: '#EF5350',
								customClass: {
									popup: 'figma-result-popup',
									title: 'figma-result-title',
									confirmButton: 'figma-result-confirm-btn',
									actions: 'figma-result-actions'
								},
								buttonsStyling: false
							});
						});
				});
			}

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