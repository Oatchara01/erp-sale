<?php include('head.php');

include "dbconnect.php";
include "dbconnect_sale.php";

?>
<style>
	@import url('https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap');

	body {
		background-color: #F4EFF8 !important;
		background-image: none !important;
		font-family: 'Prompt', sans-serif !important;
		color: #4A4A4A !important;
	}

	.status-so-page {
		font-family: 'Prompt', sans-serif !important;
		background-color: transparent;
		padding: 24px 16px;
		min-height: 100vh;
		max-width: 1490px;
		margin: 0 auto;
	}

	.status-so-page h4 {
		font-family: 'Prompt', sans-serif !important;
		font-weight: 600;
		color: #612989;
		margin-top: 0;
	}

	.so-card {
		background: transparent;
		border: none;
		box-shadow: none;
		padding: 0;
		margin-bottom: 24px;
	}

	/* Form inputs & controls */
	.so-input-group {
		display: flex;
		justify-content: space-between;
		align-items: center;
		gap: 12px;
		margin-bottom: 20px;
		flex-wrap: wrap;
	}

	.so-search-wrapper {
		position: relative;
		width: 680px;
		max-width: 100%;
	}

	.so-search-icon {
		position: absolute;
		left: 16px;
		top: 50%;
		transform: translateY(-50%);
		color: #8E8B94;
	}

	.so-input {
		width: 100%;
		height: 42px;
		padding: 0 16px;
		padding-left: 40px;
		/* for search icon */
		border-radius: 10px;
		background: #F5F6F8;
		border: 1px solid transparent;
		font-size: 14px;
		font-family: 'Prompt', sans-serif !important;
		transition: all 0.3s ease;
	}

	.so-input:focus,
	.so-select:focus {
		background: #FFFFFF;
		border-color: #612989;
		box-shadow: 0 0 0 3px rgba(97, 41, 137, 0.1);
		outline: none;
	}

	.so-modal-input {
		padding-left: 16px;
	}

	.so-select {
		width: 100%;
		height: 42px;
		padding: 0 16px;
		border-radius: 10px;
		background: #F5F6F8;
		border: 1px solid transparent;
		font-size: 14px;
		font-family: 'Prompt', sans-serif !important;
		transition: all 0.3s ease;
	}

	/* Buttons */
	.btn-so-primary {
		background: #612989;
		color: #FFFFFF;
		border: none;
		border-radius: 24px;
		height: 42px;
		padding: 0 24px;
		font-weight: 600;
		cursor: pointer;
		transition: all 0.3s ease;
		box-shadow: 0 4px 12px rgba(97, 41, 137, 0.2);
		display: inline-flex;
		align-items: center;
		gap: 8px;
		text-decoration: none;
	}

	.btn-so-primary:hover {
		background: #502173;
		box-shadow: 0 6px 16px rgba(97, 41, 137, 0.3);
		color: #FFFFFF;
	}

	.btn-so-secondary {
		background: #FFFFFF;
		color: #612989;
		border: 1px solid #EFEBEF;
		border-radius: 24px;
		height: 42px;
		padding: 0 40px;
		font-weight: 500;
		cursor: pointer;
		transition: all 0.3s ease;
		display: inline-flex;
		align-items: center;
		gap: 8px;
	}

	.btn-so-secondary:hover {
		background: #EFEBFF;
		border-color: #612989;
	}

	.btn-so-outline {
		background: #FFFFFF;
		color: #612989 !important;
		border: 1px solid #EDE9F0;
		border-radius: 9999px;
		height: 42px;
		padding: 0 24px;
		font-weight: 600;
		cursor: pointer;
		transition: all 0.3s ease;
		display: inline-flex;
		align-items: center;
		gap: 8px;
		text-decoration: none;
	}

	.btn-so-outline:hover {
		background: #F4EFF8;
		color: #502173 !important;
		border-color: #612989;
	}

	.btn-so-danger {
		background: #DC3545;
		color: #FFFFFF;
		border: none;
		border-radius: 24px;
		height: 42px;
		padding: 0 20px;
		font-weight: 500;
		cursor: pointer;
		transition: all 0.3s ease;
	}

	.btn-so-danger:hover {
		background: #BD2130;
	}

	/* Modern Table */
	.so-table-wrapper {
		overflow: visible;
		border-radius: 10px;
		border: 1px solid #EDE9F0;
		background: #FFFFFF;
	}

	.so-table {
		width: 100%;
		border-collapse: collapse;
		font-size: 14px;
	}

	.so-table th {
		background: #FFFFFF;
		color: #612989;
		font-size: 16px;
		font-weight: 600;
		padding: 25px 16px;
		text-align: left;
		border-bottom: 1px solid #612989;
	}

	.so-table td {
		padding: 14px 16px;
		border-bottom: 1px solid #EDE9F0;
		color: #3B3B3B;
		background: #FFFFFF;
	}

	/* ปรับระยะห่างขอบสุดทางซ้ายและขวาของตาราง */
	.so-table th:first-child,
	.so-table td:first-child {
		padding-left: 40px;
	}

	.so-table th:last-child,
	.so-table td:last-child {
		padding-right: 40px;
	}

	.so-row {
		cursor: pointer;
		transition: background-color 0.2s ease;
	}

	.so-row:hover {
		background-color: #FAF8FD;
	}

	.so-row.is-expanded {
		background-color: #F6EFFC;
	}

	.caret-icon {
		transition: transform 0.2s ease;
	}

	.so-row.is-expanded .caret-icon {
		transform: rotate(180deg);
		color: #612989;
	}

	/* Badges for status_doc */
	.badge-status {
		display: inline-flex;
		align-items: center;
		padding: 4px 12px;
		border-radius: 20px;
		font-size: 12px;
		font-weight: 500;
	}

	.badge-status.approve {
		background-color: #F6FFED;
		color: #389E0D;
	}

	/* อนุมัติแล้ว / Approve */
	.badge-status.draft {
		background-color: #FFF7E6;
		color: #D48806;
	}

	/* Draft */
	.badge-status.rejected {
		background-color: #FFF1F0;
		color: #CF1322;
	}

	/* Rejected / ไม่อนุมัติ */
	.badge-status.cancel {
		background-color: #F5F5F5;
		color: #595959;
	}

	/* ยกเลิก */
	.badge-status.pending-mgr {
		background-color: #FFF7E6;
		color: #D48806;
	}

	/* รอหัวหน้า */
	.badge-status.pending-exec {
		background-color: #F9F0FF;
		color: #531DAB;
	}

	/* รอผู้บริหาร */
	.badge-status.returned {
		background-color: #FFF2E8;
		color: #D4380D;
	}

	/* ส่งกลับ */

	/* Expanded Row Details */
	.so-row.is-expanded,
	.so-row.is-expanded td {
		background-color: #F1E1FF !important;
	}

	.expanded-row td {
		padding: 0 !important;
		background: #F1E1FF !important;
		border-bottom: 1px solid #EDE9F0;
	}

	.expanded-container {
		padding: 20px 24px;
		display: flex;
		gap: 24px;
		flex-wrap: wrap;
		align-items: flex-start;
	}

	.expanded-products-card {
		flex: 1;
		min-width: 300px;
		background: transparent;
		border: none;
		padding: 0;
		box-shadow: none;
	}

	.sub-table {
		width: 100%;
		border-collapse: collapse;
		font-size: 12px;
		table-layout: fixed;
	}

	.sub-table th {
		background: transparent;
		font-size: 15px;
		font-weight: 500;
		padding: 8px 12px !important;
		text-align: left;
		border-bottom: none;
	}

	.sub-table td {
		font-size: 14px;
		padding: 10px 12px !important;
		border-bottom: none;
		color: #3B3B3B;
	}

	/* Actions Menu */
	.actions-menu-list {
		list-style: none;
		padding: 0;
		margin: 0;
	}

	.actions-menu-list li {
		margin-bottom: 8px;
	}

	.actions-menu-list li:last-child {
		margin-bottom: 0;
	}

	.btn-action-item {
		display: flex;
		align-items: center;
		gap: 10px;
		width: 100%;
		padding: 10px 14px;
		border-radius: 8px;
		color: #4A4A4A;
		font-size: 13px;
		font-weight: 500;
		text-decoration: none;
		transition: all 0.2s ease;
		border: none;
		background: transparent;
		cursor: pointer;
		text-align: left;
	}

	.btn-action-item:hover {
		background: #F6EFFC;
		color: #612989;
	}

	/* Modals */
	.so-modal-header {
		border-bottom: none;
		padding-bottom: 0;
		margin-bottom: 24px;
		display: flex;
		justify-content: space-between;
		align-items: center;
	}

	.so-modal-footer {
		border-top: none;
		padding-top: 0;
		margin-top: 24px;
		display: flex;
		justify-content: flex-end;
		gap: 12px;
	}

	.so-form-row {
		display: grid;
		grid-template-columns: 1fr 1fr;
		gap: 16px;
		margin-bottom: 16px;
	}

	.filter-pill {
		background-color: #F5F6F8;
		border: 1px solid transparent;
		color: #3B3B3B;
		padding: 10px 20px;
		border-radius: 50px;
		font-size: 13px;
		font-family: 'Prompt', sans-serif !important;
		font-weight: 500;
		cursor: pointer;
		transition: all 0.2s ease;
	}

	.filter-pill.active {
		background-color: #612989;
		color: #ffffff;
	}

	.btn-filter-submit {
		background-color: #612989;
		color: #ffffff;
		border: none;
		padding: 10px 32px;
		border-radius: 50px;
		font-size: 14px;
		font-weight: 500;
		cursor: pointer;
		font-family: 'Prompt', sans-serif !important;
		transition: background-color 0.2s;
	}

	.btn-filter-submit:hover {
		background-color: #4A1E68;
	}

	.btn-filter-reset {
		background-color: #ffffff;
		color: #3B3B3B;
		border: 1px solid #EDE9F0;
		padding: 10px 32px;
		border-radius: 50px;
		font-size: 14px;
		font-weight: 500;
		cursor: pointer;
		font-family: 'Prompt', sans-serif !important;
		transition: background-color 0.2s;
		display: inline-flex;
		align-items: center;
	}

	.btn-filter-reset:hover {
		background-color: #F5F6F8;
	}

	.pagination-wrapper {
		display: flex;
		justify-content: space-between;
		align-items: center;
		margin-top: 20px;
		font-size: 13px;
		flex-wrap: wrap;
		gap: 12px;
	}

	.pagination-links {
		display: flex;
		gap: 6px;
	}

	.pagination-btn {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		min-width: 32px;
		height: 32px;
		padding: 0 6px;
		border-radius: 6px;
		border: 1px solid #EFEBEF;
		color: #3B3B3B;
		text-decoration: none;
		transition: all 0.2s ease;
	}

	.pagination-btn:hover {
		background: #EFEBFF;
		border-color: #612989;
		color: #612989;
	}

	.pagination-btn.active {
		background: #612989;
		color: #FFFFFF;
		border-color: #612989;
	}

	/* Dropdown style */
	.so-dropdown {
		position: relative;
		display: inline-block;
	}

	.so-dropdown-trigger {
		background: none;
		border: none;
		cursor: pointer;
		padding: 8px;
		color: #8E8B94;
		font-size: 16px;
		transition: color 0.2s;
	}

	.so-dropdown-trigger:hover {
		color: #612989;
	}

	.so-dropdown-menu {
		display: none;
		position: absolute;
		right: 0;
		top: 100%;
		background-color: #ffffff;
		width: 186px;
		box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.1);
		border-radius: 8px;
		z-index: 1000;
		border: 1px solid #EDE9F0;
		padding: 0;
		overflow: hidden;
	}

	.so-dropdown-menu.show {
		display: block;
	}

	.so-dropdown-item {
		color: #3B3B3B;
		padding: 10px 16px;
		text-decoration: none;
		display: flex;
		align-items: center;
		gap: 12px;
		font-size: 13px;
		text-align: left;
		font-family: 'Prompt', sans-serif !important;
		transition: background-color 0.2s, color 0.2s;
		border-bottom: 1px solid #EDE9F0;
	}

	.so-dropdown-item:last-child {
		border-bottom: none;
	}

	.so-dropdown-item i {
		color: #8E8B94;
		transition: color 0.2s;
	}

	.so-dropdown-item:hover {
		background-color: #612989;
		color: #ffffff !important;
		text-decoration: none;
	}

	.so-dropdown-item:hover i {
		color: #ffffff !important;
	}

	@media (max-width: 600px) {
		.so-form-row {
			grid-template-columns: 1fr;
		}
	}
</style>

<body>

	<div class="status-so-page">
		<div class="so-card">
			<div class="w3-container w3-bar w3-margin-bottom" style="padding-left:0px; padding-right:0px;">
				<h4 style="margin:0px;">Status SO</h4>
			</div>

			<?php
			$Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';
			$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
			$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
			$sale_code = isset($_GET['sale_code']) ? $_GET['sale_code'] : '';
			$status_doc = isset($_GET['status_doc']) ? $_GET['status_doc'] : '';
			$type_doc = isset($_GET['type_doc']) ? $_GET['type_doc'] : '';
			$have_order = isset($_GET['have_order']) ? $_GET['have_order'] : '';
			$no_iv = isset($_GET['no_iv']) ? $_GET['no_iv'] : '';
			$is_deposit = isset($_GET['is_deposit']) ? $_GET['is_deposit'] : '';
			?>

			<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" id="mainSearchForm">
				<!-- preserve modal filter values as hidden fields in main search -->
				<input type="hidden" name="start_date" value="<?php echo htmlspecialchars($start_date); ?>">
				<input type="hidden" name="end_date" value="<?php echo htmlspecialchars($end_date); ?>">
				<input type="hidden" name="sale_code" value="<?php echo htmlspecialchars($sale_code); ?>">
				<input type="hidden" name="status_doc" value="<?php echo htmlspecialchars($status_doc); ?>">
				<input type="hidden" name="type_doc" value="<?php echo htmlspecialchars($type_doc); ?>">
				<input type="hidden" name="have_order" value="<?php echo htmlspecialchars($have_order); ?>">
				<input type="hidden" name="no_iv" value="<?php echo htmlspecialchars($no_iv); ?>">
				<input type="hidden" name="is_deposit" value="<?php echo htmlspecialchars($is_deposit); ?>">

				<div class="so-input-group" style="align-items: flex-end; margin-bottom: 20px;">
					<!-- Left: Search Wrapper + Label + Add Button -->
					<div style="flex: 1; max-width: 680px; min-width: 250px; display: flex; flex-direction: column; gap: 6px;">
						<div style="font-size: 14px; color: #612989; font-weight: 500; font-family: 'Prompt', sans-serif !important;">
							ค้นหาด้วยเลขที่เอกสาร/ชื่อออกบิล
						</div>
						<div style="display: flex; gap: 12px; align-items: center;">
							<div class="so-search-wrapper" style="flex: 1; width: auto;">
								<i class="fas fa-search so-search-icon"></i>
								<input name="Keyword" class="so-input" type="text" id="Keyword" placeholder="Search" value="<?php echo htmlspecialchars($Keyword); ?>">
							</div>

							<!-- + เพิ่มใบสั่งขาย button (next to Search Input) -->
							<a href="register_suphos.php" class="btn-so-outline" style="text-decoration:none; flex-shrink: 0;">
								<img src="img/icons/add_message.png" style="width: 16px; height: 16px; vertical-align: middle; margin-right: 6px;"> เพิ่มใบสั่งขาย
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
				<div class="w3-modal-content w3-card-4" style="border-radius:16px; max-width:640px;">
					<div class="w3-container" style="padding:32px;">
						<form method="GET" action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" id="modalFilterForm">
							<!-- hidden keyword field synced from main search -->
							<input type="hidden" name="Keyword" id="modalKeyword" value="<?php echo htmlspecialchars($Keyword); ?>">

							<div class="so-modal-header" style="border-bottom: none; padding-bottom: 0; margin-bottom: 24px;">
								<h5 style="margin:0; font-weight:600; color:#3B3B3B; font-size:20px; font-family: 'Prompt', sans-serif !important;">Filters</h5>
								<span onclick="closeFilterModal()" style="font-size:28px; cursor:pointer; color:#8E8B94; line-height: 1;">&times;</span>
							</div>

							<!-- Row 1: Dates -->
							<div class="so-form-row">
								<div>
									<label class="so-label" style="color:#612989; font-size:13px; font-weight:500; display:block; margin-bottom:6px; font-family: 'Prompt', sans-serif !important;">ตั้งแต่วันที่</label>
									<input type="date" name="start_date" id="modal_start_date" class="so-select so-modal-input" value="<?php echo htmlspecialchars($start_date); ?>">
								</div>
								<div>
									<label class="so-label" style="color:#612989; font-size:13px; font-weight:500; display:block; margin-bottom:6px; font-family: 'Prompt', sans-serif !important;">ถึงวันที่</label>
									<input type="date" name="end_date" id="modal_end_date" class="so-select so-modal-input" value="<?php echo htmlspecialchars($end_date); ?>">
								</div>
							</div>

							<!-- Row 2: Status & Type -->
							<div class="so-form-row">
								<div>
									<label class="so-label" style="color:#612989; font-size:13px; font-weight:500; display:block; margin-bottom:6px; font-family: 'Prompt', sans-serif !important;">สถานะการอนุมัติ</label>
									<select name="status_doc" id="modal_status_doc" class="so-select">
										<option value="">Select</option>
										<option value="รอหัวหน้า" <?php if ($status_doc == 'รอหัวหน้า') echo 'selected'; ?>>รอหัวหน้า</option>
										<option value="ส่งกลับ" <?php if ($status_doc == 'ส่งกลับ') echo 'selected'; ?>>ส่งกลับ</option>
										<option value="รอผู้บริหาร" <?php if ($status_doc == 'รอผู้บริหาร') echo 'selected'; ?>>รอผู้บริหาร</option>
										<option value="Rejected" <?php if ($status_doc == 'Rejected') echo 'selected'; ?>>ไม่อนุมัติ</option>
										<option value="Approve" <?php if ($status_doc == 'Approve') echo 'selected'; ?>>อนุมัติแล้ว</option>
										<option value="ยกเลิก" <?php if ($status_doc == 'ยกเลิก') echo 'selected'; ?>>ยกเลิก</option>
										<option value="Draft" <?php if ($status_doc == 'Draft') echo 'selected'; ?>>Draft</option>
									</select>
								</div>
								<div>
									<label class="so-label" style="color:#612989; font-size:13px; font-weight:500; display:block; margin-bottom:6px; font-family: 'Prompt', sans-serif !important;">ประเภท</label>
									<select name="type_doc" id="modal_type_doc" class="so-select">
										<option value="">Select</option>
										<option value="3" <?php if ($type_doc == '3') echo 'selected'; ?>>ใบสั่งขาย</option>
										<option value="4" <?php if ($type_doc == '4') echo 'selected'; ?>>ใบสั่งขาย (NBM)</option>
									</select>
								</div>
							</div>

							<!-- Row 3: Sales Channel & Zone -->
							<div class="so-form-row">
								<div>
									<label class="so-label" style="color:#612989; font-size:13px; font-weight:500; display:block; margin-bottom:6px; font-family: 'Prompt', sans-serif !important;">ช่องทางการขาย</label>
									<select name="have_order" id="modal_have_order" class="so-select">
										<option value="">Select</option>
										<option value="1" <?php if ($have_order == '1') echo 'selected'; ?>>Shoppee / Lazada (API)</option>
										<option value="0" <?php if ($have_order == '0') echo 'selected'; ?>>Normal Order</option>
									</select>
								</div>
								<div>
									<label class="so-label" style="color:#612989; font-size:13px; font-weight:500; display:block; margin-bottom:6px; font-family: 'Prompt', sans-serif !important;">เขตการขาย (Sale)</label>
									<select name="sale_code" id="modal_sale_code" class="so-select">
										<option value="">Select</option>
										<?php
										$strSQL5 = "SELECT * FROM tb_team_adm ORDER BY sale_code ASC";
										$objQuery5 = mysqli_query($com, $strSQL5);
										while ($objResuut5 = mysqli_fetch_array($objQuery5)) {
										?>
											<option value="<?php echo $objResuut5["sale_code"]; ?>" <?php if ($sale_code == $objResuut5["sale_code"]) echo 'selected'; ?>>
												<?php echo $objResuut5["sale_code"]; ?> - <?php echo $objResuut5["sale_name"]; ?>
											</option>
										<?php
										}
										?>
									</select>
								</div>
							</div>

							<!-- Row 4: Pills Toggles -->
							<div class="so-form-pills" style="display: flex; gap: 12px; margin-top: 8px; margin-bottom: 24px;">
								<input type="hidden" name="no_iv" id="modal_no_iv" value="<?php echo htmlspecialchars($no_iv); ?>">
								<button type="button" id="pill_no_iv" class="filter-pill <?php echo ($no_iv == '1') ? 'active' : ''; ?>" onclick="toggleFilterPill('no_iv')">
									รอใส่เลขที่เอกสาร
								</button>
								<input type="hidden" name="is_deposit" id="modal_is_deposit" value="<?php echo htmlspecialchars($is_deposit); ?>">
								<button type="button" id="pill_is_deposit" class="filter-pill <?php echo ($is_deposit == '1') ? 'active' : ''; ?>" onclick="toggleFilterPill('is_deposit')">
									ใบฝาก
								</button>
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
				}

				function closeFilterModal() {
					document.getElementById('filterModal').style.display = 'none';
				}

				function syncKeyword() {
					document.getElementById('modalKeyword').value = document.getElementById('Keyword').value;
				}

				function toggleFilterPill(fieldId) {
					const input = document.getElementById('modal_' + fieldId);
					const pill = document.getElementById('pill_' + fieldId);
					if (input.value === '1') {
						input.value = '0';
						pill.classList.remove('active');
					} else {
						input.value = '1';
						pill.classList.add('active');
					}
				}

				function resetFilters() {
					document.getElementById('modal_start_date').value = '';
					document.getElementById('modal_end_date').value = '';
					document.getElementById('modal_status_doc').value = '';
					document.getElementById('modal_sale_code').value = '';
					document.getElementById('modal_type_doc').value = '';
					document.getElementById('modal_have_order').value = '';
					document.getElementById('modal_no_iv').value = '0';
					document.getElementById('modal_is_deposit').value = '0';
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
							<th width="3%"></th>
							<th width="9%">เลขที่อ้างอิง</th>
							<th width="10%">เลขที่เอกสาร</th>
							<th width="11%">วันที่ออกเอกสาร</th>
							<th width="20%">ชื่อออกบิล</th>
							<th width="13%">เขตการขาย</th>
							<th width="9%">สถานะลูกค้า</th>
							<th width="10%">ยอดรวม</th>
							<th width="12%">สถานะการอนุมัติ</th>
							<th width="3%"></th>
						</tr>
					</thead>
					<tbody>

						<?php
						date_default_timezone_set("Asia/Bangkok");
						$to_day = date('Y-m-d');

						$strSQL = "SELECT * FROM hos__so WHERE 1";

						if ($start_date != "") {
							$strSQL .= ' AND date_so >= "' . mysqli_real_escape_string($conn, $start_date) . '"';
						}

						if ($end_date != "") {
							$strSQL .= ' AND date_so <= "' . mysqli_real_escape_string($conn, $end_date) . '"';
						}

						if ($sale_code != "") {
							$strSQL .= ' AND sale_code = "' . mysqli_real_escape_string($conn, $sale_code) . '"';
						}

						if ($status_doc != "") {
							if ($status_doc == 'รอหัวหน้า') {
								$strSQL .= ' AND (status_doc = "รอหัวหน้า" OR status_doc = "Request")';
							} else {
								$strSQL .= ' AND status_doc = "' . mysqli_real_escape_string($conn, $status_doc) . '"';
							}
						}

						if ($type_doc != "") {
							if ($type_doc == '3') {
								$strSQL .= ' AND type_doc = "3"';
							} else if ($type_doc == '4') {
								$strSQL .= ' AND type_doc = "4"';
							}
						}

						if ($have_order != "") {
							$strSQL .= ' AND have_order = "' . mysqli_real_escape_string($conn, $have_order) . '"';
						}

						if ($no_iv == "1") {
							$strSQL .= ' AND (iv_no = "" OR iv_no IS NULL)';
						}

						if ($is_deposit == "1") {
							$strSQL .= ' AND (type_doc = "1" OR type_doc = "2")';
						}

						if ($Keyword != "") {
							$escKeyword = mysqli_real_escape_string($conn, $Keyword);
							$strSQL .= ' AND (bill_name LIKE "%' . $escKeyword . '%"';
							$strSQL .= ' OR brnp_no LIKE "%' . $escKeyword . '%"';
							$strSQL .= ' OR cm_no LIKE "%' . $escKeyword . '%"';
							$strSQL .= ' OR iv_no LIKE "%' . $escKeyword . '%"';
							$strSQL .= ' OR ref_id LIKE "%' . $escKeyword . '%"';
							$strSQL .= ' OR order_refer_code LIKE "%' . $escKeyword . '%"';
							$strSQL .= ' OR po_no LIKE "%' . $escKeyword . '%")';
						}

						// Copy of query to count total rows before LIMIT
						$countSQL = $strSQL;
						$objQueryCount = mysqli_query($conn, $countSQL) or die("Error Query [" . $countSQL . "]");
						$Num_Rows = mysqli_num_rows($objQueryCount);

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

						$strSQL .= " ORDER BY id DESC LIMIT $Page_Start, $Per_Page";
						$objQuery = mysqli_query($conn, $strSQL) or die("Error Query [" . $strSQL . "]");

						$i = 1;
						while ($objResult = mysqli_fetch_array($objQuery)) {
							// Check Customer VIP Status
							$sqlCustomer = "SELECT vip_ckk FROM tb_customer WHERE customer_id = '" . mysqli_real_escape_string($conn, $objResult["bill_id"]) . "'";
							$qryCustomer = mysqli_query($conn, $sqlCustomer);
							$rsCustomer = mysqli_fetch_assoc($qryCustomer);
							$vip_status = ($rsCustomer && $rsCustomer['vip_ckk'] == '1') ? 'VIP' : '-';

							// Calculate SO Total Amount
							$sqlTotal = "SELECT SUM(amount) AS total_amount FROM hos__subso WHERE ref_idd = '" . mysqli_real_escape_string($conn, $objResult["ref_id"]) . "'";
							$qryTotal = mysqli_query($conn, $sqlTotal);
							$rsTotal = mysqli_fetch_assoc($qryTotal);
							$total_amount = $rsTotal && $rsTotal['total_amount'] ? number_format($rsTotal['total_amount'], 2) : '0.00';

							// Get prefix of iv_no for conditional actions
							$iv_prefix = substr($objResult['iv_no'], 0, 2);

							// Determine bill name display based on have_order
							$bill_name_display = '';
							if ($objResult["have_order"] == '0') {
								$bill_name_display = $objResult["bill_name"];
							}

							// Map status_doc to class and display text
							$status_class = 'draft';
							$status_text = htmlspecialchars($objResult["status_doc"]);
							if ($objResult["status_doc"] == 'Approve' || $objResult["status_doc"] == 'อนุมัติแล้ว') {
								$status_class = 'approve';
								$status_text = 'อนุมัติแล้ว';
							} else if ($objResult["status_doc"] == 'Draft') {
								$status_class = 'draft';
								$status_text = 'Draft';
							} else if ($objResult["status_doc"] == 'Rejected' || $objResult["status_doc"] == 'ไม่อนุมัติ') {
								$status_class = 'rejected';
								$status_text = 'ไม่อนุมัติ';
							} else if ($objResult["status_doc"] == 'ยกเลิก') {
								$status_class = 'cancel';
								$status_text = 'ยกเลิก';
							} else if ($objResult["status_doc"] == 'รอหัวหน้า' || $objResult["status_doc"] == 'Request') {
								$status_class = 'pending-mgr';
								$status_text = 'รอหัวหน้า';
							} else if ($objResult["status_doc"] == 'รอผู้บริหาร') {
								$status_class = 'pending-exec';
								$status_text = 'รอผู้บริหาร';
							} else if ($objResult["status_doc"] == 'ส่งกลับ') {
								$status_class = 'returned';
								$status_text = 'ส่งกลับ';
							}

						?>
							<!-- Main Row -->
							<tr class="so-row" onclick="toggleRow('row-<?php echo $objResult['ref_id']; ?>', this)">
								<td style="text-align:center; vertical-align:middle;">
									<img src="img/icons/arrow_down.png" class="caret-icon">
								</td>
								<td style="text-align:center; vertical-align:middle;">
									<?php if ($objResult["que_ckk"] == '1') { ?>
										<i class="fas fa-bolt" style="color: #FA8C16; font-size: 20px;" title="รายการด่วน"></i>
									<?php } ?>
								</td>
								<td>
									<a href="register_suphos.php?ref_id=<?php echo $objResult['ref_id']; ?>" style="color:#612989; text-decoration:underline; font-weight:500;"><?php echo htmlspecialchars($objResult["ref_id"]); ?></a>
								</td>
								<td><?php echo htmlspecialchars($objResult["iv_no"]); ?></td>
								<td><?php echo DateThai($objResult["date_so"]); ?></td>
								<td>
									<div align="left"><?php echo htmlspecialchars($bill_name_display); ?></div>
								</td>
								<td><?php echo htmlspecialchars($objResult["sale_code"]); ?></td>
								<td>
									<?php if ($vip_status == 'VIP') { ?>
										<span><img src="img/icons/vip.png" style="width: 24px; height: 20px; margin-right: 4px; vertical-align: middle;">VIP</span>
									<?php } else { ?>
										-
									<?php } ?>
								</td>
								<td><?php echo $total_amount; ?></td>
								<td>
									<span class="badge-status <?php echo $status_class; ?>">
										<?php echo $status_text; ?>
									</span>
								</td>
								<td style="text-align:center; vertical-align:middle; position:relative;">
									<div class="so-dropdown">
										<button type="button" class="so-dropdown-trigger" onclick="toggleDropdown(event, 'dropdown-<?php echo $objResult['ref_id']; ?>')">
											<i class="fas fa-ellipsis-v"></i>
										</button>
										<div id="dropdown-<?php echo $objResult['ref_id']; ?>" class="so-dropdown-menu">
											<!-- แก้ไข -->
											<a href="register_suphos.php?ref_id=<?php echo $objResult['ref_id']; ?>&start_date=<?php echo urlencode($start_date); ?>&end_date=<?php echo urlencode($end_date); ?>" class="so-dropdown-item">
												<i class="fas fa-edit" style="width:16px;"></i> แก้ไข
											</a>

											<!-- คัดลอกใบเดิม -->
											<a href="javascript:if(confirm('!!!ต้องการเพิ่มเอกสารใหม่โดยCopyเอกสารเดิมใช่หรือไม่')==true){window.location='register_adminhos_createnew.php?ref_id=<?php echo $objResult['ref_id']; ?>&start_date=<?php echo urlencode($start_date); ?>&end_date=<?php echo urlencode($end_date); ?>'};" class="so-dropdown-item">
												<i class="fas fa-copy" style="width:16px;"></i> คัดลอกใบเดิม
											</a>

											<!-- Preview -->
											<?php
											$preview_url = ($objResult['type_doc'] == '4') ? 'report_salehosnbm2.php' : 'report_salehosptl1.php';
											?>
											<a href="<?php echo $preview_url; ?>?ref_id=<?php echo $objResult['ref_id']; ?>" target="_blank" class="so-dropdown-item">
												<i class="fas fa-search" style="width:16px;"></i> Preview
											</a>

											<!-- ใบกำกับภาษี ET/IE -->
											<?php if ($objResult['et_ckk'] == '1') {
												$ivv = substr($objResult['iv_no'], 0, 2);
												$report_url = ($ivv == 'ET') ? 'report_EThos.php' : 'report_IEhos.php';
											?>
												<a href="<?php echo $report_url; ?>?ref_id=<?php echo $objResult['ref_id']; ?>" target="_blank" class="so-dropdown-item">
													<i class="fas fa-file-invoice-dollar" style="width:16px;"></i> ใบกำกับภาษี ET/IE
												</a>
											<?php } ?>

											<!-- ใบส่งสินค้า -->
											<?php if ($objResult['send_admin'] == '1') { ?>
												<a href="javascript:if(confirm('!!!ต้องการสร้างใบรับสินค้าใช่หรือไม่')==true){window.location='register_receivepro_so.php?ref_id=<?php echo $objResult['ref_id']; ?>'};" class="so-dropdown-item">
													<i class="fas fa-truck" style="width:16px;"></i> ใบส่งสินค้า
												</a>
											<?php } ?>
										</div>
									</div>
								</td>
							</tr>

							<!-- Expanded Row Detail -->
							<tr id="row-<?php echo $objResult['ref_id']; ?>" class="expanded-row" style="display:none;">
								<td colspan="11">
									<div class="expanded-container">
										<!-- Left: Items Sub-table -->
										<div class="expanded-products-card">
											<table class="sub-table">
												<thead>
													<tr>
														<th width="40%">รายการสินค้า</th>
														<th width="20%">เคลียร์ของ/ยืม</th>
														<th width="5%" style="text-align:center;">จำนวน</th>
														<th width="10%" style="text-align:right !important;">ราคา/หน่วย</th>
														<th width="10%" style="text-align:right !important;">ส่วนลด/หน่วย</th>
														<th width="15%" style="text-align:right !important;">ยอดรวม/สินค้า</th>
													</tr>
												</thead>
												<tbody>
													<?php
													$sqlSub = "SELECT * FROM hos__subso LEFT JOIN tb_product ON hos__subso.product_ID=tb_product.product_id WHERE ref_idd = '" . mysqli_real_escape_string($conn, $objResult["ref_id"]) . "'";
													$qrySub = mysqli_query($conn, $sqlSub);
													$subRowsCount = mysqli_num_rows($qrySub);

													if ($subRowsCount > 0) {
														while ($subResult = mysqli_fetch_array($qrySub)) {
															$item_name = $subResult['sol_name'] ? $subResult['sol_name'] : $subResult['product_name'];
															$clear_status = '-';
															if (trim($subResult['clear_ivno']) != '') {
																$clear_status = '<i class="fas fa-check-circle" style="color:#389E0D; margin-right: 6px;"></i><span style="color:#3B3B3B;">' . htmlspecialchars($subResult['clear_ivno']) . '</span>';
															}
													?>
															<tr>
																<td><?php echo htmlspecialchars($item_name); ?></td>
																<td><?php echo $clear_status; ?></td>
																<td style="text-align:center;"><?php echo (int)$subResult['count']; ?></td>
																<td style="text-align:right;"><?php echo number_format($subResult['price'], 2); ?></td>
																<td style="text-align:right;"><?php echo number_format($subResult['discount'], 2); ?></td>
																<td style="text-align:right;"><?php echo number_format($subResult['amount'], 2); ?></td>
															</tr>
														<?php
														}
														?>
														<tr style="border-top: 1px solid #EDE9F0;">
															<td colspan="5" style="text-align:right; font-weight:500; padding: 14px 12px !important; font-size: 14px; color: #3B3B3B;">ยอดรวม</td>
															<td style="text-align:right; font-size:16px; color:#612989; font-weight:600; padding: 14px 12px !important;"><?php echo $total_amount; ?></td>
														</tr>
													<?php
													} else {
													?>
														<tr>
															<td colspan="6" style="text-align:center; color:#8E8B94; padding:20px;">ไม่มีข้อมูลรายการสินค้า</td>
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

			<!-- Pagination Restyling -->
			<div class="pagination-wrapper">
				<div>
					พบทั้งหมด <strong><?php echo $Num_Rows; ?></strong> รายการ (หน้าที่ <?php echo $Page; ?> จาก <?php echo $Num_Pages; ?> หน้า)
				</div>
				<div class="pagination-links">
					<?php
					$pagParams = "&Keyword=" . urlencode($Keyword) . "&start_date=" . urlencode($start_date) . "&end_date=" . urlencode($end_date) . "&sale_code=" . urlencode($sale_code) . "&status_doc=" . urlencode($status_doc) . "&type_doc=" . urlencode($type_doc) . "&have_order=" . urlencode($have_order) . "&no_iv=" . urlencode($no_iv) . "&is_deposit=" . urlencode($is_deposit);

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
				}
			});

			// Toggle clicked row
			if (isVisible) {
				row.style.display = 'none';
				triggerEl.classList.remove('is-expanded');
			} else {
				row.style.display = 'table-row';
				triggerEl.classList.add('is-expanded');
			}
		}

		function toggleDropdown(event, dropdownId) {
			event.stopPropagation(); // Prevent row click expansion

			// Close all other dropdowns
			document.querySelectorAll('.so-dropdown-menu').forEach(m => {
				if (m.id !== dropdownId) {
					m.classList.remove('show');
				}
			});

			// Toggle target dropdown
			const menu = document.getElementById(dropdownId);
			menu.classList.toggle('show');
		}

		// Close dropdowns when clicking anywhere outside
		document.addEventListener('click', function(event) {
			if (!event.target.closest('.so-dropdown')) {
				document.querySelectorAll('.so-dropdown-menu').forEach(m => {
					m.classList.remove('show');
				});
			}
		});
	</script>

	<!-- <div id="cr_bar"> <?php include "foot.php"; ?></div> -->
</body>

</html>