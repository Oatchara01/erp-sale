<?php include('head.php');

include "dbconnect.php";
include "dbconnect_sale.php";
require_once __DIR__ . '/includes/breq_repo.php';

?>
<link rel="stylesheet" href="css/so-status-ui.css?v=<?php echo filemtime(__DIR__ . '/css/so-status-ui.css'); ?>">
<link rel="stylesheet" href="css/register-receive.css?v=<?php echo filemtime(__DIR__ . '/css/register-receive.css'); ?>">
<script src="js/receive-history.js?v=<?php echo filemtime(__DIR__ . '/js/receive-history.js'); ?>"></script>

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
	<?php
	$Keyword        = isset($_GET['Keyword'])        ? trim((string)$_GET['Keyword'])   : '';
	$start_date     = isset($_GET['start_date'])     ? (string)$_GET['start_date']      : '';
	$end_date       = isset($_GET['end_date'])       ? (string)$_GET['end_date']        : '';
	$sale_code      = isset($_GET['sale_code'])      ? (string)$_GET['sale_code']       : '';
	$status_approve = isset($_GET['status_approve']) ? (string)$_GET['status_approve']  : '';

	/* สถานะการอนุมัติของ BREQ — map จาก (status_doc, send_sup) ตาม includes/breq_repo.php
	   ยกเลิก กับ ไม่อนุมัติ บันทึกเป็น status_doc = 'Rejected' เหมือนกัน แยกด้วย log ล่าสุดใน tb_document_status_log
	   ('Cancelled' = ยกเลิก — ดู breq_run_document_action) ส่วน 'ส่งกลับ' / 'ยกเลิก' เป็นค่าไทยของใบเก่า */
	$breqStatusFilterOptions = array(
		'draft'        => 'ร่าง',
		'pending_send' => 'รอส่งหัวหน้า',
		'pending_sup'  => 'รอหัวหน้า',
		'returned'     => 'ส่งกลับ',
		'approve'      => 'อนุมัติแล้ว',
		'rejected'     => 'ไม่อนุมัติ',
		'cancel'       => 'ยกเลิก',
	);
	$breqLastLogSql = "(SELECT l.status_doc FROM tb_document_status_log l WHERE l.ref_id = in__br.ref_id_br ORDER BY l.created_at DESC, l.id DESC LIMIT 1)";
	$breqCancelledSql = "((status_doc = 'Rejected' AND " . $breqLastLogSql . " IN ('Cancelled','ยกเลิก')) OR status_doc = 'ยกเลิก')";
	$breqStatusFilterSql = array(
		'draft'        => " AND status_doc = 'Draft'",
		'pending_send' => " AND status_doc = 'Request' AND send_sup <> '1'",
		'pending_sup'  => " AND status_doc = 'Request' AND send_sup = '1'",
		'returned'     => " AND status_doc IN ('Returned','ส่งกลับ')",
		'approve'      => " AND status_doc = 'Approve'",
		'rejected'     => " AND status_doc = 'Rejected' AND NOT " . $breqCancelledSql,
		'cancel'       => " AND " . $breqCancelledSql,
	);

	/** badge ของแถว — คืน [class, label] */
	function breq_status_badge(array $row)
	{
		$statusDoc = (string)$row['status_doc'];
		$lastLog = (string)($row['last_log_status'] ?? '');
		if ($statusDoc === 'ยกเลิก' || ($statusDoc === 'Rejected' && ($lastLog === 'Cancelled' || $lastLog === 'ยกเลิก'))) {
			return array('cancel', 'ยกเลิก');
		}
		if ($statusDoc === 'Rejected') {
			return array('rejected', 'ไม่อนุมัติ');
		}
		if ($statusDoc === 'Approve') {
			return array('approve', 'อนุมัติแล้ว');
		}
		if ($statusDoc === 'Draft') {
			return array('draft', 'ร่าง');
		}
		if ($statusDoc === 'Returned' || $statusDoc === 'ส่งกลับ') {
			return array('returned', 'ส่งกลับ');
		}
		if ($statusDoc === 'Request') {
			return breq_is_awaiting_sup($row) ? array('pending-mgr', 'รอหัวหน้า') : array('closed', 'รอส่งหัวหน้า');
		}
		return array('draft', $statusDoc);
	}

	function breq_list_date($value)
	{
		$value = (string)$value;
		if ($value === '' || $value === '0000-00-00' || $value === '0000-00-00 00:00:00') {
			return '-';
		}
		return DateThai($value);
	}
	?>
	<div class="status-so-page">
		<div class="so-card">
			<div class="w3-container w3-bar w3-margin-bottom" style="padding-left:0;padding-right:0;">
				<h4 style="margin:0;">BREQ</h4>
			</div>

			<form name="frmSearch" method="GET" action="<?php echo htmlspecialchars($_SERVER['SCRIPT_NAME']); ?>">
				<div class="so-input-group" style="align-items: flex-end; margin-bottom: 20px;">
					<div style="flex: 1; max-width: 680px; min-width: 250px; display: flex; flex-direction: column; gap: 6px;">
						<label for="Keyword" style="font-size: 14px; color: #612989; font-weight: 500;">ค้นหาด้วยเลขที่เอกสาร/ชื่อพนักงาน</label>
						<div style="display: flex; gap: 12px; align-items: center;">
							<div class="so-search-wrapper" style="flex: 1; width: auto;">
								<i class="fas fa-search so-search-icon"></i>
								<input name="Keyword" id="Keyword" class="so-input" type="text" placeholder="Search" value="<?php echo htmlspecialchars($Keyword); ?>">
							</div>
							<a href="register_breng_brgq.php" class="btn-so-outline" style="flex-shrink: 0; font-weight: 500;">
								<img src="img/icons/add_message.png" alt=""> เพิ่ม BREQ
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

							<!-- Row 1: ช่วงวันที่ (date_br = วันที่สร้างใบ — iv_date ยังว่างจนกว่า Admin จะออกเลข) -->
							<div class="so-form-row">
								<div>
									<label class="so-label" for="start_date">ตั้งแต่วันที่</label>
									<div class="so-input-wrapper calendar-wrapper">
										<input type="date" name="start_date" id="start_date" class="so-select so-modal-input" value="<?php echo htmlspecialchars($start_date); ?>">
									</div>
								</div>
								<div>
									<label class="so-label" for="end_date">ถึงวันที่</label>
									<div class="so-input-wrapper calendar-wrapper">
										<input type="date" name="end_date" id="end_date" class="so-select so-modal-input" value="<?php echo htmlspecialchars($end_date); ?>">
									</div>
								</div>
							</div>

							<!-- Row 2: สถานะการอนุมัติ + เขตการขาย -->
							<div class="so-form-row" style="align-items: flex-start;">
								<div>
									<label class="so-label" for="status_approve">สถานะการอนุมัติ</label>
									<select name="status_approve" id="status_approve" class="so-select">
										<option value="">-- ทั้งหมด --</option>
										<?php foreach ($breqStatusFilterOptions as $breqOptValue => $breqOptLabel) { ?>
											<option value="<?php echo htmlspecialchars($breqOptValue); ?>" <?php echo ($status_approve === $breqOptValue) ? 'selected' : ''; ?>><?php echo htmlspecialchars($breqOptLabel); ?></option>
										<?php } ?>
									</select>
								</div>
								<div>
									<label class="so-label" for="sale_code">เขตการขาย</label>
									<select name="sale_code" id="sale_code" class="so-select">
										<option value="">-- ทั้งหมด --</option>
										<?php
										$strSQL5 = "SELECT * FROM tb_team_adm where ckk ='0' ORDER BY sale_code ASC";
										$objQuery5 = mysqli_query($com, $strSQL5);
										while ($objQuery5 && $objResuut5 = mysqli_fetch_array($objQuery5)) {
											$sel = ($sale_code == $objResuut5["sale_code"]) ? "selected" : "";
										?>
											<option value="<?php echo htmlspecialchars($objResuut5["sale_code"]); ?>" <?php echo $sel; ?>><?php echo htmlspecialchars($objResuut5["sale_code"]); ?> - <?php echo htmlspecialchars($objResuut5["sale_name"]); ?></option>
										<?php } ?>
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

			<div class="so-table-wrapper so-table-wrapper--fit">
				<!-- table-layout: fixed + colgroup — ความกว้างคอลัมน์คงที่ ไม่ขยับตามชื่อสินค้ายาว ๆ ตอนกางแถว -->
				<table class="so-table so-table-fit" style="table-layout:fixed; width:100%;">
					<colgroup>
						<col style="width:5%;">
						<col style="width:13%;">
						<col style="width:13%;">
						<col style="width:14%;">
						<col style="width:15%;">
						<col style="width:15%;">
						<col style="width:17%;">
						<col style="width:8%;">
					</colgroup>
					<thead>
						<tr>
							<th></th>
							<th style="white-space:nowrap;">เลขที่อ้างอิง</th>
							<th style="white-space:nowrap;">เลขที่เอกสาร</th>
							<th style="white-space:nowrap;">วันที่ออกเอกสาร</th>
							<th style="white-space:nowrap;">เลขที่ PO</th>
							<th style="white-space:nowrap;">ชื่อพนักงาน</th>
							<th style="white-space:nowrap;">สถานะการอนุมัติ</th>
							<th style="text-align:center;"></th>
						</tr>
					</thead>
					<tbody>
						<?php
						date_default_timezone_set("Asia/Bangkok");

						$sessionSaleCode = (string)($_SESSION['code'] ?? '');

						$strSQL = "SELECT in__br.*, " . $breqLastLogSql . " AS last_log_status FROM in__br WHERE 1";

						// Draft เห็นได้เฉพาะคนสร้าง (in__br.sale_code) — ดู includes/breq_repo.php
						$strSQL .= " AND (status_doc <> 'Draft' OR sale_code = '" . mysqli_real_escape_string($conn, $sessionSaleCode) . "')";

						if ($start_date != "") {
							$strSQL .= " AND date_br >= '" . mysqli_real_escape_string($conn, $start_date) . "'";
						}
						if ($end_date != "") {
							$strSQL .= " AND date_br <= '" . mysqli_real_escape_string($conn, $end_date) . "'";
						}
						if ($sale_code != "") {
							$strSQL .= " AND sale_code = '" . mysqli_real_escape_string($conn, $sale_code) . "'";
						}
						if ($status_approve != "" && isset($breqStatusFilterSql[$status_approve])) {
							$strSQL .= $breqStatusFilterSql[$status_approve];
						}
						if ($Keyword != "") {
							// ครอบวงเล็บ ไม่งั้น OR หลุดออกจากเงื่อนไขด้านบน — ชื่อพนักงานของ BREQ อยู่ใน customer
							$keywordLike = "'%" . mysqli_real_escape_string($conn, $Keyword) . "%'";
							$strSQL .= " AND (ref_id_br LIKE " . $keywordLike
								. " OR iv_no LIKE " . $keywordLike
								. " OR po_no LIKE " . $keywordLike
								. " OR customer LIKE " . $keywordLike . ")";
						}

						$objQuery = mysqli_query($conn, $strSQL) or die("Error Query [" . $strSQL . "]");
						$Num_Rows = mysqli_num_rows($objQuery);

						$Per_Page = 20;
						$Page = isset($_GET['Page']) ? max(1, (int)$_GET['Page']) : 1;

						$Prev_Page = $Page - 1;
						$Next_Page = $Page + 1;

						$Page_Start = (($Per_Page * $Page) - $Per_Page);
						if ($Num_Rows <= $Per_Page) {
							$Num_Pages = 1;
						} else if (($Num_Rows % $Per_Page) == 0) {
							$Num_Pages = ($Num_Rows / $Per_Page);
						} else {
							$Num_Pages = (int)(($Num_Rows / $Per_Page) + 1);
						}

						$strSQL .= " ORDER BY id DESC LIMIT $Page_Start, $Per_Page";
						$objQuery = mysqli_query($conn, $strSQL);
						$Page_Num_Rows = $objQuery ? mysqli_num_rows($objQuery) : 0;
						?>

						<?php if ($Page_Num_Rows === 0) { ?>
							<tr>
								<td colspan="8" style="text-align:center; padding:40px 16px; color:#6B6875;">
									<?php echo ($Num_Rows > 0)
										? 'ไม่พบข้อมูลในหน้านี้ — ลองกลับไปหน้าแรก'
										: 'ไม่พบรายการที่ตรงกับเงื่อนไข ลองล้างตัวกรองหรือเปลี่ยนคำค้น'; ?>
								</td>
							</tr>
						<?php } ?>

						<?php
						while ($objQuery && $objResult = mysqli_fetch_assoc($objQuery)) {
							$refId = (string)$objResult["ref_id_br"];
							$row_id = "row-" . $refId;
							$dropdown_id = "dropdown-" . $refId;
							$row_id_js = htmlspecialchars(json_encode($row_id), ENT_QUOTES, 'UTF-8');
							$dropdown_id_js = htmlspecialchars(json_encode($dropdown_id), ENT_QUOTES, 'UTF-8');
							$edit_url = 'register_breng_brgq.php?ref_id_br=' . urlencode($refId);
							$copy_url = 'register_breng_brgq.php?copy_from=' . urlencode($refId);
							$preview_url = 'report_loanhosptl1_breq.php?ref_id_br=' . urlencode($refId);
							// ชื่อเมนูตามสิทธิ์ (ฟอร์มตรวจสิทธิ์ซ้ำฝั่ง server — ตรงนี้เป็นแค่ UX)
							$canEdit = breq_user_can_edit_document($objResult, $_SESSION) || breq_user_can_admin_edit($objResult, $_SESSION);
							list($badgeClass, $badgeLabel) = breq_status_badge($objResult);

							$strSQL2 = "SELECT s.count, s.return_product, p.sol_name FROM in__subbr s LEFT JOIN tb_product p ON s.product_id = p.product_id"
								. " WHERE s.ref_idd_br = '" . mysqli_real_escape_string($conn, $refId) . "' AND s.product_id <> '' ORDER BY s.id ASC";
							$objQuery2 = mysqli_query($conn, $strSQL2) or die("Error Query [" . $strSQL2 . "]");
							$itemRows = array();
							while ($objResult2 = mysqli_fetch_assoc($objQuery2)) {
								$itemRows[] = array(
									'name'     => (string)$objResult2["sol_name"],
									'count'    => (float)$objResult2["count"],
									'returned' => (float)$objResult2["return_product"],
								);
							}
							$returnHistory = array('ref_id' => $refId, 'iv_no' => (string)$objResult["iv_no"], 'items' => $itemRows);
							$returnHistory_js = htmlspecialchars(json_encode($returnHistory, JSON_UNESCAPED_UNICODE), ENT_QUOTES, 'UTF-8');
						?>
							<tr class="so-row" onclick="toggleRow(<?php echo $row_id_js; ?>, this)">
								<td style="text-align:center;"><img src="img/icons/arrow_down.png" class="caret-icon" style="width:12px; height:10px;" alt=""></td>
								<td><a href="<?php echo htmlspecialchars($edit_url); ?>" style="color:#612989; text-decoration:underline; font-weight:500;" onclick="event.stopPropagation();"><?php echo htmlspecialchars($refId); ?></a></td>
								<td><?php echo $objResult["iv_no"] !== '' ? htmlspecialchars($objResult["iv_no"]) : '-'; ?></td>
								<td><?php echo breq_list_date($objResult["iv_date"]); ?></td>
								<td><?php echo (string)$objResult["po_no"] !== '' ? htmlspecialchars($objResult["po_no"]) : '-'; ?></td>
								<td>
									<div align="left"><?php echo htmlspecialchars($objResult["customer"]); ?></div>
								</td>
								<td><span class="badge-status <?php echo $badgeClass; ?>"><?php echo htmlspecialchars($badgeLabel); ?></span></td>
								<td style="text-align:center; position:relative;">
									<div class="so-dropdown">
										<button type="button" class="so-dropdown-trigger" aria-label="ตัวเลือกเพิ่มเติม" onclick="toggleDropdown(event, <?php echo $dropdown_id_js; ?>)">
											<i class="fas fa-ellipsis-v"></i>
										</button>
										<div id="<?php echo htmlspecialchars($dropdown_id); ?>" class="so-dropdown-menu">
											<a href="<?php echo htmlspecialchars($edit_url); ?>" class="so-dropdown-item">
												<i class="fas fa-edit" style="width:16px;"></i> แก้ไข
											</a>
											<a href="<?php echo htmlspecialchars($copy_url); ?>" class="so-dropdown-item">
												<i class="fas fa-copy" style="width:16px;"></i> คัดลอกใบเดิม
											</a>
											<a href="<?php echo htmlspecialchars($preview_url); ?>" target="_blank" rel="noopener noreferrer" class="so-dropdown-item" onclick="event.stopPropagation();">
												<i class="fas fa-search" style="width:16px;"></i> Preview
											</a>
											<?php if ((string)$objResult["status_doc"] === 'Approve') { ?>
												<!-- ฟอร์มใบคืนแบบรวม register_receive.php (เฉพาะเอกสารที่อนุมัติแล้ว) — ประวัติการคืนด้านล่างแสดงใบคืนต่อท้ายสรุปยอดยืม/คืน -->
												<a href="register_receive.php?source_type=breq&source_ref=<?php echo urlencode($refId); ?>" class="so-dropdown-item">
													<i class="fas fa-undo-alt" style="width:16px;"></i> คืนสินค้า
												</a>
												<a href="#" class="so-dropdown-item" data-return-history="<?php echo $returnHistory_js; ?>" onclick="openReturnHistory(event, this);">
													<i class="fas fa-history" style="width:16px;"></i> ประวัติการคืน
												</a>
											<?php } ?>
										</div>
									</div>
								</td>
							</tr>

							<!-- Expanded Row Details -->
							<?php if (count($itemRows) === 0) { ?>
								<tr class="expanded-row" data-row="<?php echo htmlspecialchars($row_id); ?>" style="display:none; background: #F1E1FF !important;">
									<td></td>
									<td colspan="7" style="padding: 10px 16px !important; font-size: 15px; color: #6B6875; text-align: left; vertical-align: middle; border-bottom: 1px solid #EDE9F0;">ไม่มีรายการสินค้า</td>
								</tr>
							<?php } ?>
							<?php foreach ($itemRows as $itemIndex => $item) { ?>
								<tr class="expanded-row" data-row="<?php echo htmlspecialchars($row_id); ?>" style="display:none; background: #F1E1FF !important;">
									<td></td>
									<!-- สินค้าคลุมคอลัมน์ เลขที่อ้างอิง+เลขที่เอกสาร / ยืม ใต้วันที่ออกเอกสาร / คืน ใต้เลขที่ PO -->
									<td colspan="2" style="padding: 10px 16px !important; font-size: 15px; color: #3B3B3B; text-align: left; vertical-align: middle; border-bottom: 1px solid #EDE9F0;">
										<?php if ($itemIndex === 0) { ?>
											<strong style="display: block; margin-bottom: 4px;">รายการสินค้า</strong>
										<?php } ?>
										<?php echo $item['name'] !== '' ? htmlspecialchars($item['name']) : '-'; ?>
									</td>
									<td style="padding: 10px 16px !important; font-size: 15px; color: #3B3B3B; text-align: center; vertical-align: middle; border-bottom: 1px solid #EDE9F0;">
										<?php if ($itemIndex === 0) { ?>
											<strong style="display: block; margin-bottom: 4px;">จำนวนยืม</strong>
										<?php } ?>
										<?php echo number_format($item['count']); ?>
									</td>
									<td style="padding: 10px 16px !important; font-size: 15px; color: #3B3B3B; text-align: center; vertical-align: middle; border-bottom: 1px solid #EDE9F0;">
										<?php if ($itemIndex === 0) { ?>
											<strong style="display: block; margin-bottom: 4px;">จำนวนคืน</strong>
										<?php } ?>
										<?php echo number_format($item['returned']); ?>
									</td>
									<td colspan="3" style="border-bottom: 1px solid #EDE9F0;"></td>
								</tr>
							<?php } ?>
						<?php } ?>
					</tbody>
				</table>
			</div> <!-- so-table-wrapper -->

			<div class="pagination-wrapper">
				<div>
					แสดง <?php echo ($Num_Rows > 0 ? $Page_Start + 1 : 0); ?> ถึง <?php echo min($Page_Start + $Per_Page, $Num_Rows); ?> จาก <?php echo $Num_Rows; ?> รายการ
				</div>
				<div class="pagination-links">
					<?php
					$pagBase = htmlspecialchars($_SERVER['SCRIPT_NAME'], ENT_QUOTES);
					$pagParams = htmlspecialchars("&Keyword=" . urlencode($Keyword) . "&start_date=" . urlencode($start_date) . "&end_date=" . urlencode($end_date)
						. "&sale_code=" . urlencode($sale_code) . "&status_approve=" . urlencode($status_approve), ENT_QUOTES);

					if ($Prev_Page) {
						echo "<a class='pagination-btn' href='$pagBase?Page=$Prev_Page$pagParams'><i class='fas fa-chevron-left'></i></a>";
					}

					$start_p = max(1, $Page - 3);
					$end_p = min($Num_Pages, $Page + 3);

					if ($start_p > 1) {
						echo "<a class='pagination-btn' href='$pagBase?Page=1$pagParams'>1</a>";
						if ($start_p > 2) echo "<span style='padding:4px;'>...</span>";
					}

					for ($p = $start_p; $p <= $end_p; $p++) {
						$activeClass = ($p == $Page) ? 'active' : '';
						echo "<a class='pagination-btn $activeClass' href='$pagBase?Page=$p$pagParams'>$p</a>";
					}

					if ($end_p < $Num_Pages) {
						if ($end_p < $Num_Pages - 1) echo "<span style='padding:4px;'>...</span>";
						echo "<a class='pagination-btn' href='$pagBase?Page=$Num_Pages$pagParams'>$Num_Pages</a>";
					}

					if ($Page < $Num_Pages) {
						echo "<a class='pagination-btn' href='$pagBase?Page=$Next_Page$pagParams'><i class='fas fa-chevron-right'></i></a>";
					}
					?>
				</div>
			</div>
		</div> <!-- so-card -->
	</div> <!-- status-so-page -->

	<!-- Modal: ประวัติการคืน (สรุปยอดยืม/คืน/คงค้างรายสินค้าจาก in__subbr) -->
	<div id="returnHistoryModal" class="w3-modal" style="display:none; z-index:9999;" onclick="if (event.target === this) closeReturnHistory();">
		<div class="w3-modal-content w3-card-4" style="border-radius:16px; max-width:680px;">
			<div class="w3-container" style="padding:32px;">
				<div class="so-modal-header">
					<h5 style="margin:0; font-weight:600; color:#3B3B3B; font-size:20px;">ประวัติการคืน <span id="returnHistoryRef" style="color:#612989; font-weight:500; font-size:16px;"></span></h5>
					<button type="button" onclick="closeReturnHistory()" aria-label="ปิด" style="background:none; border:none; font-size:28px; cursor:pointer; color:#8E8B94; line-height:1; padding:0;">&times;</button>
				</div>
				<div class="so-table-wrapper" style="margin-top:16px;">
					<table class="so-table">
						<thead>
							<tr>
								<th>รายการสินค้า</th>
								<th style="text-align:center; white-space:nowrap;">จำนวนยืม</th>
								<th style="text-align:center; white-space:nowrap;">คืนแล้ว</th>
								<th style="text-align:center; white-space:nowrap;">คงค้าง</th>
							</tr>
						</thead>
						<tbody id="returnHistoryRows"></tbody>
					</table>
				</div>
				<!-- ใบคืนสินค้าของเอกสารนี้ (ใบเดิมและใบใหม่) โหลดจาก ajax_receive_history.php -->
				<h6 style="margin:24px 0 8px; font-weight:600; color:#3B3B3B; font-size:16px;">ใบคืนสินค้า</h6>
				<div id="returnHistoryReceipts"></div>
			</div>
		</div>
	</div>

	<!-- JS Helpers for Expandable Rows, Kebab Dropdowns, and Modals -->
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

		function formatQty(value) {
			return Number(value || 0).toLocaleString('en-US', { maximumFractionDigits: 2 });
		}

		function openReturnHistory(event, link) {
			event.preventDefault();
			event.stopPropagation();
			document.querySelectorAll('.so-dropdown-menu').forEach(m => m.classList.remove('show'));

			const data = JSON.parse(link.getAttribute('data-return-history'));
			document.getElementById('returnHistoryRef').textContent = data.iv_no || data.ref_id;

			const tbody = document.getElementById('returnHistoryRows');
			tbody.innerHTML = '';
			if (data.items.length === 0) {
				const tr = tbody.insertRow();
				const td = tr.insertCell();
				td.colSpan = 4;
				td.style.textAlign = 'center';
				td.style.color = '#6B6875';
				td.textContent = 'ไม่มีรายการสินค้า';
			}
			data.items.forEach(item => {
				const tr = tbody.insertRow();
				const outstanding = Math.max(0, item.count - item.returned);
				[item.name || '-', formatQty(item.count), formatQty(item.returned), formatQty(outstanding)].forEach((text, index) => {
					const td = tr.insertCell();
					td.textContent = text;
					if (index > 0) td.style.textAlign = 'center';
					if (index === 3 && outstanding > 0) {
						td.style.color = '#D4380D';
						td.style.fontWeight = '600';
					}
				});
			});

			document.getElementById('returnHistoryModal').style.display = 'block';
			rcLoadReceiveHistory(document.getElementById('returnHistoryReceipts'), 'breq', data.ref_id);
		}

		function closeReturnHistory() {
			document.getElementById('returnHistoryModal').style.display = 'none';
		}

		document.addEventListener('DOMContentLoaded', function() {
			updateFilterBadge();
		});
	</script>
</body>

</html>
