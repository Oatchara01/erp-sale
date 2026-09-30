<?php include('head.php');

include "dbconnect.php";
include "dbconnect_sale.php";
?>
<link rel="stylesheet" href="css/so-status-ui.css">

<body>

	<div class="status-so-page">
		<div class="so-card">
			<div class="w3-container w3-bar w3-margin-bottom" style="padding-left:0px; padding-right:0px;">
				<h4 style="margin:0px;">รายการใบสั่งลดหนี้ (ทั้งหมด)</h4>
			</div>

			<?php
			$Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';
			$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
			$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
			$status_doc = isset($_GET['status_doc']) ? $_GET['status_doc'] : '';
			$ttype_doc = isset($_GET['ttype_doc']) ? $_GET['ttype_doc'] : '';
			$have_order = isset($_GET['have_order']) ? $_GET['have_order'] : '';
			$sale_code = isset($_GET['sale_code']) ? $_GET['sale_code'] : '';
			$scriptName = htmlspecialchars($_SERVER['SCRIPT_NAME'], ENT_QUOTES, 'UTF-8');
			?>

			<form name="frmSearch" method="GET" action="<?php echo $scriptName; ?>" id="mainSearchForm">
				<!-- preserve modal filter values as hidden fields in main search -->
				<input type="hidden" name="start_date" value="<?php echo htmlspecialchars($start_date); ?>">
				<input type="hidden" name="end_date" value="<?php echo htmlspecialchars($end_date); ?>">
				<input type="hidden" name="status_doc" value="<?php echo htmlspecialchars($status_doc); ?>">
				<input type="hidden" name="ttype_doc" value="<?php echo htmlspecialchars($ttype_doc); ?>">
				<input type="hidden" name="have_order" value="<?php echo htmlspecialchars($have_order); ?>">
				<input type="hidden" name="sale_code" value="<?php echo htmlspecialchars($sale_code); ?>">

				<div class="so-input-group" style="align-items: flex-end; margin-bottom: 20px;">
					<!-- Left: Search Wrapper + Label + Add Button -->
					<div style="flex: 1; max-width: 680px; min-width: 250px; display: flex; flex-direction: column; gap: 6px;">
						<div style="font-size: 14px; color: #612989; font-weight: 500; font-family: 'Prompt', sans-serif !important;">
							ค้นหาด้วยเลขที่เอกสาร/ชื่อลูกค้า/หมายเลขคำสั่งซื้อ
						</div>
						<div style="display: flex; gap: 12px; align-items: center;">
							<div class="so-search-wrapper" style="flex: 1; width: auto;">
								<i class="fas fa-search so-search-icon"></i>
								<input name="Keyword" class="so-input" type="text" id="Keyword" placeholder="Search" value="<?php echo htmlspecialchars($Keyword); ?>">
							</div>

							<!-- สร้างใบคืนสินค้า: placeholder, ยังไม่มี route จริงจากหน้านี้ -->
							<a href="#" class="btn-so-outline" style="text-decoration:none; flex-shrink: 0;">
								<i class="fas fa-plus" style="margin-right:6px;"></i> สร้างใบคืนสินค้า
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
							<!-- hidden keyword field synced from main search -->
							<input type="hidden" name="Keyword" id="modalKeyword" value="<?php echo htmlspecialchars($Keyword); ?>">

							<div class="so-modal-header" style="border-bottom: 1px solid #EDE9F0; padding-bottom: 16px; margin-bottom: 24px;">
								<h5 id="filterModalTitle" style="margin:0; font-weight:600; color:#3B3B3B; font-size:20px; font-family: 'Prompt', sans-serif !important;">Filters</h5>
								<button type="button" onclick="closeFilterModal()" aria-label="ปิดหน้าต่างตัวกรอง" style="background:none; border:none; padding:0; font-size:28px; cursor:pointer; color:#8E8B94; line-height: 1;">&times;</button>
							</div>

							<!-- Row 1: Dates -->
							<div class="so-form-row">
								<div>
									<label class="so-label" style="color:#612989; font-size:13px; font-weight:500; display:block; margin-bottom:6px;">ตั้งแต่วันที่</label>
									<input type="date" name="start_date" id="modal_start_date" class="so-select so-modal-input" value="<?php echo htmlspecialchars($start_date); ?>">
								</div>
								<div>
									<label class="so-label" style="color:#612989; font-size:13px; font-weight:500; display:block; margin-bottom:6px;">ถึงวันที่</label>
									<input type="date" name="end_date" id="modal_end_date" class="so-select so-modal-input" value="<?php echo htmlspecialchars($end_date); ?>">
								</div>
							</div>

							<!-- Row 2: สถานะการอนุมัติ / ประเภท -->
							<div class="so-form-row">
								<div>
									<label class="so-label" style="color:#612989; font-size:13px; font-weight:500; display:block; margin-bottom:6px;">สถานะการอนุมัติ</label>
									<select name="status_doc" id="modal_status_doc" class="so-select">
										<option value="">Select</option>
										<option value="Draft" <?php if ($status_doc == 'Draft') echo 'selected'; ?>>Draft</option>
										<option value="Approve" <?php if ($status_doc == 'Approve') echo 'selected'; ?>>สมบูรณ์</option>
										<option value="Rejected" <?php if ($status_doc == 'Rejected') echo 'selected'; ?>>ไม่อนุมัติ</option>
										<option value="Returned" <?php if ($status_doc == 'Returned') echo 'selected'; ?>>ส่งกลับ</option>
										<option value="ยกเลิก" <?php if ($status_doc == 'ยกเลิก') echo 'selected'; ?>>ยกเลิก</option>
										<option value="รอผู้บริหาร" <?php if ($status_doc == 'รอผู้บริหาร') echo 'selected'; ?>>รอผู้บริหาร</option>
										<option value="รอหัวหน้า" <?php if ($status_doc == 'รอหัวหน้า') echo 'selected'; ?>>รอหัวหน้า</option>
										<option value="ยังไม่ได้กดส่งให้ SUP" <?php if ($status_doc == 'ยังไม่ได้กดส่งให้ SUP') echo 'selected'; ?>>ยังไม่ได้กดส่งให้ SUP</option>
									</select>
								</div>
								<div>
									<label class="so-label" style="color:#612989; font-size:13px; font-weight:500; display:block; margin-bottom:6px;">ประเภท</label>
									<select name="ttype_doc" id="modal_ttype_doc" class="so-select">
										<option value="">Select</option>
										<option value="1" <?php if ($ttype_doc == '1') echo 'selected'; ?>>คืนสินค้า</option>
										<option value="2" <?php if ($ttype_doc == '2') echo 'selected'; ?>>ส่วนลด</option>
									</select>
								</div>
							</div>

							<!-- Row 3: ช่องทางการขาย / เขตการขาย -->
							<div class="so-form-row">
								<div>
									<label class="so-label" style="color:#612989; font-size:13px; font-weight:500; display:block; margin-bottom:6px;">ช่องทางการขาย</label>
									<select name="have_order" id="modal_have_order" class="so-select">
										<option value="">Select</option>
										<option value="1" <?php if ($have_order == '1') echo 'selected'; ?>>Shoppee / Lazada (API)</option>
										<option value="0" <?php if ($have_order == '0') echo 'selected'; ?>>Normal Order</option>
									</select>
								</div>
								<div>
									<label class="so-label" style="color:#612989; font-size:13px; font-weight:500; display:block; margin-bottom:6px;">เขตการขาย (Sale)</label>
									<select name="sale_code" id="modal_sale_code" class="so-select">
										<option value="">Select</option>
										<?php
										$strSQL5 = "SELECT * FROM tb_team_adm ORDER BY sale_code ASC";
										$objQuery5 = mysqli_query($com, $strSQL5);
										while ($objResuut5 = mysqli_fetch_array($objQuery5)) {
										?>
											<option value="<?php echo htmlspecialchars($objResuut5["sale_code"]); ?>" <?php if ($sale_code == $objResuut5["sale_code"]) echo 'selected'; ?>>
												<?php echo htmlspecialchars($objResuut5["sale_code"]); ?> - <?php echo htmlspecialchars($objResuut5["sale_name"]); ?>
											</option>
										<?php
										}
										?>
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
					document.getElementById('modal_status_doc').value = '';
					document.getElementById('modal_ttype_doc').value = '';
					document.getElementById('modal_have_order').value = '';
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
							<th width="9%">เลขที่อ้างอิง</th>
							<th width="10%">วันที่ลงทะเบียน</th>
							<th width="9%">เลขที่ลดหนี้</th>
							<th width="9%">อ้างอิง IV</th>
							<th width="10%">ยอดขายรวม</th>
							<th width="16%">ชื่อลูกค้า</th>
							<th width="14%">สถานะเอกสาร</th>
							<th width="8%">เขตการขาย</th>
							<th width="3%"></th>
						</tr>
					</thead>
					<tbody>

						<?php
						date_default_timezone_set("Asia/Bangkok");
						$to_day = date('Y-m-d');

						// Base FROM/JOIN + WHERE conditions are built once and reused for both the
						// COUNT query and the paginated SELECT so the two stay in sync.
						$fromSQL = "FROM tb_credit_note cn LEFT JOIN hos__so s ON cn.ref_id = s.ref_id";
						$whereSQL = " WHERE 1";

						if ($start_date != "") {
							$whereSQL .= ' AND cn.date_credit >= "' . mysqli_real_escape_string($conn, $start_date) . '"';
						}

						if ($end_date != "") {
							$whereSQL .= ' AND cn.date_credit <= "' . mysqli_real_escape_string($conn, $end_date) . '"';
						}

						if ($Keyword != "") {
							$escKeyword = mysqli_real_escape_string($conn, $Keyword);
							$whereSQL .= ' AND (cn.customer_name LIKE "%' . $escKeyword . '%"';
							$whereSQL .= ' OR cn.ref_credit LIKE "%' . $escKeyword . '%"';
							$whereSQL .= ' OR cn.credit_no LIKE "%' . $escKeyword . '%"';
							$whereSQL .= ' OR cn.iv_no_ref LIKE "%' . $escKeyword . '%")';
						}

						if ($status_doc != "") {
							if ($status_doc == 'รอผู้บริหาร') {
								$whereSQL .= ' AND cn.status_doc = "Request" AND cn.send_dm = "1"';
							} else if ($status_doc == 'รอหัวหน้า') {
								$whereSQL .= ' AND cn.status_doc = "Request" AND cn.send_sup = "1"';
							} else if ($status_doc == 'ยังไม่ได้กดส่งให้ SUP') {
								$whereSQL .= ' AND cn.status_doc = "Request" AND cn.send_sup = "0"';
							} else {
								$whereSQL .= ' AND cn.status_doc = "' . mysqli_real_escape_string($conn, $status_doc) . '"';
							}
						}

						if ($ttype_doc != "") {
							$whereSQL .= ' AND cn.ttype_doc = "' . mysqli_real_escape_string($conn, $ttype_doc) . '"';
						}

						if ($have_order != "") {
							$whereSQL .= ' AND s.have_order = "' . mysqli_real_escape_string($conn, $have_order) . '"';
						}

						if ($sale_code != "") {
							$whereSQL .= ' AND cn.sale_code = "' . mysqli_real_escape_string($conn, $sale_code) . '"';
						}

						// Count total rows before LIMIT (COUNT(*) instead of fetching every row)
						$countSQL = "SELECT COUNT(*) AS cnt " . $fromSQL . $whereSQL;
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

						$strSQL = "SELECT cn.* " . $fromSQL . $whereSQL . " ORDER BY cn.credit_id DESC LIMIT $Page_Start, $Per_Page";
						$objQuery = mysqli_query($conn, $strSQL) or die("Error Query [" . $strSQL . "]");

						$i = 1;
						while ($objResult = mysqli_fetch_array($objQuery)) {
							$ref_credit = $objResult['ref_credit'];
							$ref_credit_url = urlencode($ref_credit);
							$row_id = "row-" . $ref_credit;
							$dropdown_id = "dropdown-" . $ref_credit;
							$row_id_js = htmlspecialchars(json_encode($row_id), ENT_QUOTES, 'UTF-8');
							$dropdown_id_js = htmlspecialchars(json_encode($dropdown_id), ENT_QUOTES, 'UTF-8');

							// Sum amount for the row
							$strSQL3 = "SELECT SUM(sum_amount) AS sum_amount FROM tb_subcredit WHERE ref_creditt = '" . mysqli_real_escape_string($conn, $ref_credit) . "'";
							$objQuery3 = mysqli_query($conn, $strSQL3) or die("Error Query [" . $strSQL3 . "]");
							$objResult3 = mysqli_fetch_array($objQuery3);
							$total_amount = number_format($objResult3["sum_amount"], 0);

							// Map status_doc/send_dm/send_sup to badge class and display text (เงื่อนไขเดิมทุกจุด)
							$status_class = '';
							$status_text = '';
							if ($objResult["status_doc"] == 'Draft') {
								$status_class = 'draft';
								$status_text = 'Draft';
							} else if ($objResult["status_doc"] == 'Rejected') {
								$status_class = 'rejected';
								$status_text = 'ไม่อนุมัติ';
							} else if ($objResult["status_doc"] == 'ยกเลิก') {
								$status_class = 'cancel';
								$status_text = $objResult["status_doc"];
							} else if ($objResult["status_doc"] == 'Returned') {
								$status_class = 'sent-back';
								$status_text = 'ส่งกลับ';
							} else if ($objResult["status_doc"] == 'Approve') {
								$status_class = 'approve';
								$status_text = 'สมบูรณ์';
							} else if ($objResult["send_dm"] == '1' && $objResult["status_doc"] == 'Request') {
								$status_class = 'pending-exec';
								$status_text = 'รอผู้บริหาร';
							} else if ($objResult["send_sup"] == '1' && $objResult["status_doc"] == 'Request') {
								$status_class = 'pending-mgr';
								$status_text = 'รอหัวหน้า';
							} else if ($objResult["send_sup"] == '0' && $objResult["status_doc"] == 'Request') {
								$status_class = 'returned';
								$status_text = 'ยังไม่ได้กดส่งให้ SUP';
							}
						?>
							<!-- Main Row -->
							<tr class="so-row" role="button" tabindex="0" aria-expanded="false" onclick="toggleRow(<?php echo $row_id_js; ?>, this)">
								<td style="text-align:center; vertical-align:middle;">
									<img src="img/icons/arrow_down.png" class="caret-icon" alt="">
								</td>
								<td><a href="register_credinot.php?ref_credit=<?php echo $ref_credit_url; ?>&start_date=<?php echo urlencode($start_date); ?>&end_date=<?php echo urlencode($end_date); ?>" style="color:#612989; text-decoration:underline; font-weight:500;"><?php echo htmlspecialchars($objResult["ref_credit"]); ?></a></td>
								<td><?php echo DateThai($objResult["date_credit"]); ?></td>
								<td><?php echo htmlspecialchars($objResult["credit_no"]); ?></td>
								<td><?php echo htmlspecialchars($objResult["iv_no_ref"]); ?></td>
								<td><?php echo $total_amount; ?></td>
								<td>
									<div align="left"><?php echo htmlspecialchars($objResult["customer_name"]); ?></div>
								</td>
								<td>
									<?php if (!empty($status_text)) { ?>
										<span class="badge-status <?php echo $status_class; ?>">
											<?php echo htmlspecialchars($status_text); ?>
										</span>
									<?php } else { ?>
										-
									<?php } ?>
								</td>
								<td><?php echo htmlspecialchars($objResult["sale_code"]); ?></td>
								<td style="text-align:center; vertical-align:middle; position:relative;">
									<div class="so-dropdown">
										<button type="button" class="so-dropdown-trigger" aria-label="ตัวเลือกเพิ่มเติม" aria-haspopup="true" aria-expanded="false" onclick="toggleDropdown(event, <?php echo $dropdown_id_js; ?>)">
											<i class="fas fa-ellipsis-v"></i>
										</button>
										<div id="<?php echo htmlspecialchars($dropdown_id); ?>" class="so-dropdown-menu">
											<?php if ($objResult["close_mount"] == '0') { ?>
												<a href="register_credinot.php?ref_credit=<?php echo $ref_credit_url; ?>&start_date=<?php echo urlencode($start_date); ?>&end_date=<?php echo urlencode($end_date); ?>" class="so-dropdown-item">
													<i class="fas fa-edit" style="width:16px;"></i> แก้ไข
												</a>
											<?php } ?>

											<a href="report_credit_adm.php?ref_credit=<?php echo $ref_credit_url; ?>" target="_blank" class="so-dropdown-item">
												<i class="fas fa-eye" style="width:16px;"></i> Preview
											</a>

											<?php if ($objResult["credit_no"] != '') { ?>
												<a href="report_credit_adm.php?ref_credit=<?php echo $ref_credit_url; ?>" class="so-dropdown-item">
													<i class="fas fa-print" style="width:16px;"></i> Print
												</a>
											<?php } ?>

											<a href="register_credit_createnew.php?ref_credit=<?php echo $ref_credit_url; ?>&start_date=<?php echo urlencode($start_date); ?>&end_date=<?php echo urlencode($end_date); ?>" class="so-dropdown-item">
												<i class="fas fa-copy" style="width:16px;"></i> Copy Doc
											</a>
										</div>
									</div>
								</td>
							</tr>

							<!-- Expanded Row Detail -->
							<tr id="<?php echo htmlspecialchars($row_id); ?>" class="expanded-row" style="display:none;">
								<td colspan="10">
									<div class="expanded-container">
										<div class="expanded-products-card">
											<table class="sub-table">
												<thead>
													<tr>
														<th width="40%">รายการสินค้า</th>
														<th width="15%" style="text-align:center;">จำนวน</th>
														<th width="15%" style="text-align:right !important;">ราคา/หน่วย</th>
														<th width="15%" style="text-align:right !important;">ส่วนลด/หน่วย</th>
														<th width="15%" style="text-align:right !important;">ยอดรวม/สินค้า</th>
													</tr>
												</thead>
												<tbody>
													<?php
													$sqlSub = "SELECT tb_subcredit.*, tb_product.sol_name, tb_product.unit_name FROM tb_subcredit LEFT JOIN tb_product ON tb_subcredit.product_ID = tb_product.product_id WHERE ref_creditt = '" . mysqli_real_escape_string($conn, $ref_credit) . "'";
													$qrySub = mysqli_query($conn, $sqlSub);
													$subRowsCount = mysqli_num_rows($qrySub);

													if ($subRowsCount > 0) {
														while ($subResult = mysqli_fetch_array($qrySub)) {
													?>
															<tr>
																<td><?php echo htmlspecialchars($subResult['sol_name'] ?? ''); ?></td>
																<td style="text-align:center;"><?php echo number_format($subResult['count'] ?? 0, 0); ?> <?php echo htmlspecialchars($subResult['unit_name'] ?? ''); ?></td>
																<td style="text-align:right;"><?php echo number_format($subResult['unit_price'] ?? $subResult['price'] ?? 0, 2); ?></td>
																<td style="text-align:right;"><?php echo number_format($subResult['discount_unit'] ?? $subResult['discount'] ?? 0, 2); ?></td>
																<td style="text-align:right;"><?php echo number_format($subResult['sum_amount'] ?? 0, 2); ?></td>
															</tr>
														<?php
														}
														?>
														<tr style="border-top: 1px solid #EDE9F0;">
															<td colspan="4" style="text-align:right; font-weight:500; padding: 14px 12px !important; font-size: 14px; color: #3B3B3B;">ยอดรวม</td>
															<td style="text-align:right; font-size:16px; color:#612989; font-weight:600; padding: 14px 12px !important;"><?php echo $total_amount; ?></td>
														</tr>
													<?php
													} else {
													?>
														<tr>
															<td colspan="5" style="text-align:center; color:#8E8B94; padding:20px;">ไม่มีข้อมูลรายการสินค้า</td>
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
							$i++;
						}
						?>

					</tbody>
				</table>
			</div>

			<!-- Pagination -->
			<div class="pagination-wrapper">
				<div>
					พบทั้งหมด <strong><?php echo $Num_Rows; ?></strong> รายการ (หน้าที่ <?php echo $Page; ?> จาก <?php echo $Num_Pages; ?> หน้า)
				</div>
				<div class="pagination-links">
					<?php
					$pagParams = "&Keyword=" . urlencode($Keyword) . "&start_date=" . urlencode($start_date) . "&end_date=" . urlencode($end_date) . "&status_doc=" . urlencode($status_doc) . "&ttype_doc=" . urlencode($ttype_doc) . "&have_order=" . urlencode($have_order) . "&sale_code=" . urlencode($sale_code);

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

		document.addEventListener('keydown', function(event) {
			if ((event.key === 'Enter' || event.key === ' ') && event.target.classList && event.target.classList.contains('so-row')) {
				event.preventDefault();
				event.target.click();
			}
		});

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