<?php
include('head.php');
include "dbconnect.php";
include "dbconnect_sale.php";
?>
<link rel="stylesheet" href="css/so-status-ui.css">

<script>
	function toggleRow(rowId, triggerEl) {
		const row = document.getElementById(rowId);
		if (!row) return;
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
			const menuWidth = 186;
			const menuHeight = menu.offsetHeight || 190;
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

	function openFilterModal() {
		const modal = document.getElementById('filterModal');
		if (modal) modal.style.display = 'block';
		const startDate = document.getElementById('modal_start_date');
		if (startDate) startDate.focus();
	}

	function closeFilterModal() {
		const modal = document.getElementById('filterModal');
		if (modal) modal.style.display = 'none';
	}

	function syncKeyword() {
		const modalKw = document.getElementById('modalKeyword');
		const kw = document.getElementById('Keyword');
		if (modalKw && kw) modalKw.value = kw.value;
	}

	function toggleFilterPill(fieldId) {
		const input = document.getElementById('modal_' + fieldId);
		const pill = document.getElementById('pill_' + fieldId);
		if (input && pill) {
			if (input.value === '1') {
				input.value = '';
				pill.classList.remove('active');
			} else {
				input.value = '1';
				pill.classList.add('active');
			}
		}
	}

	function resetFilters() {
		if (document.getElementById('modal_start_date')) document.getElementById('modal_start_date').value = '';
		if (document.getElementById('modal_end_date')) document.getElementById('modal_end_date').value = '';
		if (document.getElementById('modal_status_doc')) document.getElementById('modal_status_doc').value = '';
		if (document.getElementById('modal_type_br')) document.getElementById('modal_type_br').value = '';
		if (document.getElementById('modal_sale_code')) document.getElementById('modal_sale_code').value = '';
		if (document.getElementById('modal_status_br')) document.getElementById('modal_status_br').value = '';
		if (document.getElementById('modal_no_iv')) document.getElementById('modal_no_iv').value = '';
		const pillNoIv = document.getElementById('pill_no_iv');
		if (pillNoIv) pillNoIv.classList.remove('active');
		if (document.getElementById('Keyword')) document.getElementById('Keyword').value = '';
		if (document.getElementById('modalKeyword')) document.getElementById('modalKeyword').value = '';
		const form = document.getElementById('modalFilterForm');
		if (form) form.submit();
	}

	function openClearBrModal(event, refIdBr) {
		if (event) {
			event.preventDefault();
			event.stopPropagation();
		}

		var openDropdowns = document.querySelectorAll('.so-dropdown-menu.show');
		openDropdowns.forEach(function(el) {
			el.classList.remove('show');
		});

		var modal = document.getElementById('clearBrModal');
		var loading = document.getElementById('clearBrLoading');
		var content = document.getElementById('clearBrContent');
		if (!modal) return;

		window.__cbrRefId = refIdBr;

		modal.style.display = 'flex';
		loading.style.display = 'block';
		content.style.display = 'none';

		fetch('ajax_get_clear_br_details.php?ref_id_br=' + encodeURIComponent(refIdBr))
			.then(function(res) {
				return res.json();
			})
			.then(function(res) {
				loading.style.display = 'none';
				if (!res.success) {
					alert(res.message || 'เกิดข้อผิดพลาดในการโหลดข้อมูล');
					closeClearBrModal();
					return;
				}
				var d = res.data;
				document.getElementById('cbrIvNo').textContent = d.iv_no || '-';
				document.getElementById('cbrDateBr').textContent = d.date_br || '-';
				document.getElementById('cbrCustomer').textContent = d.customer || '-';
				document.getElementById('cbrSaleCode').textContent = d.sale_code || '-';

				var tbody = document.getElementById('cbrItemsTableBody');
				tbody.innerHTML = '';
				if (!d.items || d.items.length === 0) {
					tbody.innerHTML = '<tr><td colspan="3" style="text-align:center; padding:20px; color:#8E8B94;">ไม่พบรายการสินค้า</td></tr>';
				} else {
					d.items.forEach(function(item, idx) {
						var subRowId = 'cbr-sub-' + idx;
						var productId = item.product_id || '';

						var tr = document.createElement('tr');
						tr.className = 'so-row cbr-item-row';
						tr.setAttribute('role', 'button');
						tr.setAttribute('tabindex', '0');
						tr.setAttribute('aria-expanded', 'false');
						tr.onclick = function() {
							toggleCbrItemRow(subRowId, productId, tr);
						};
						tr.innerHTML = '<td style="vertical-align:middle;"><span style="display:inline-flex; align-items:center; gap:8px;"><img src="img/icons/arrow_down.png" class="caret-icon" alt="" style="width:12px; height:12px; flex-shrink:0;"><span><span style="font-weight:500; color:#3B3B3B;">' + escapeHtmlLocal(item.product_name) + '</span>' + (item.product_code ? '<div style="font-size:12px; color:#8E8B94;">' + escapeHtmlLocal(item.product_code) + '</div>' : '') + '</span></span></td>' +
							'<td style="text-align:center; vertical-align:middle; font-weight:600;">' + item.borrow_qty + '</td>' +
							'<td style="text-align:center; vertical-align:middle; color:#FF830F; font-weight:600;">' + item.remaining_qty + '</td>';
							// '<td style="text-align:center; vertical-align:middle; font-weight:500; color:#3B3B3B;">' + (item.sn ? escapeHtmlLocal(item.sn) : '-') + '</td>';
						tbody.appendChild(tr);

						var subTr = document.createElement('tr');
						subTr.className = 'expanded-row cbr-sub-row';
						subTr.id = subRowId;
						subTr.style.display = 'none';
						subTr.setAttribute('data-loaded', '0');
						subTr.innerHTML = '<td colspan="3"><div class="expanded-container"><div class="expanded-products-card" id="' + subRowId + '-body"></div></div></td>';
						tbody.appendChild(subTr);
					});
				}

				content.style.display = 'block';
			})
			.catch(function(err) {
				console.error(err);
				alert('เกิดข้อผิดพลาดในการเชื่อมต่อเซิร์ฟเวอร์');
				closeClearBrModal();
			});
	}

	function closeClearBrModal() {
		var modal = document.getElementById('clearBrModal');
		if (modal) {
			modal.style.display = 'none';
		}
	}

	function escapeHtmlLocal(text) {
		if (!text) return '';
		return String(text)
			.replace(/&/g, "&amp;")
			.replace(/</g, "&lt;")
			.replace(/>/g, "&gt;")
			.replace(/"/g, "&quot;")
			.replace(/'/g, "&#039;");
	}

	function formatMoneyLocal(value) {
		var n = parseFloat(value);
		if (isNaN(n)) n = 0;
		return n.toLocaleString('en-US', {
			minimumFractionDigits: 2,
			maximumFractionDigits: 2
		});
	}

	function renderCbrDocsTable(docs) {
		var head = '<table class="sub-table" style="min-width:820px;"><thead><tr>' +
			'<th style="width:13%;">วันที่ออกเอกสาร</th>' +
			'<th style="width:15%;">เลขที่เอกสาร</th>' +
			'<th style="width:20%;">ชื่อลูกค้า</th>' +
			'<th style="width:11%; text-align:center;">จำนวนเคลียร์</th>' +
			'<th style="width:12%; text-align:right;">ราคา/หน่วย</th>' +
			'<th style="width:13%; text-align:right;">ยอดรวม/สินค้า</th>' +
			'<th style="width:16%;">หมายเลข SN</th>' +
			'</tr></thead><tbody>';

		if (!docs || docs.length === 0) {
			return head + '<tr><td colspan="7" style="text-align:center; color:#8E8B94; padding:16px;">ไม่พบเอกสารที่เคลียร์</td></tr></tbody></table>';
		}

		var body = '';
		docs.forEach(function(doc) {
			body += '<tr>' +
				'<td>' + escapeHtmlLocal(doc.doc_date) + '</td>' +
				'<td style="color:#612989; font-weight:500;">' + escapeHtmlLocal(doc.doc_no) + '</td>' +
				'<td>' + escapeHtmlLocal(doc.customer) + '</td>' +
				'<td style="text-align:center; font-weight:600;">' + doc.cleared_qty + '</td>' +
				'<td style="text-align:right;">' + formatMoneyLocal(doc.price) + '</td>' +
				'<td style="text-align:right;">' + formatMoneyLocal(doc.amount) + '</td>' +
				'<td>' + escapeHtmlLocal(doc.sn) + '</td>' +
				'</tr>';
		});
		return head + body + '</tbody></table>';
	}

	function toggleCbrItemRow(subRowId, productId, triggerEl) {
		var subRow = document.getElementById(subRowId);
		if (!subRow) return;
		var isVisible = subRow.style.display !== 'none';

		// ปิดแถวย่อยอื่น ๆ + รีเซ็ต caret ของแถวสินค้าอื่น
		document.querySelectorAll('.cbr-sub-row').forEach(function(r) {
			if (r.id !== subRowId) r.style.display = 'none';
		});
		document.querySelectorAll('.cbr-item-row').forEach(function(r) {
			if (r !== triggerEl) {
				r.classList.remove('is-expanded');
				r.setAttribute('aria-expanded', 'false');
			}
		});

		if (isVisible) {
			subRow.style.display = 'none';
			triggerEl.classList.remove('is-expanded');
			triggerEl.setAttribute('aria-expanded', 'false');
			return;
		}

		subRow.style.display = 'table-row';
		triggerEl.classList.add('is-expanded');
		triggerEl.setAttribute('aria-expanded', 'true');

		if (subRow.getAttribute('data-loaded') === '1') return;

		var body = document.getElementById(subRowId + '-body');
		if (body) {
			body.innerHTML = '<div style="text-align:center; padding:16px; color:#8E8B94;"><i class="fas fa-spinner fa-spin" style="color:#612989;"></i> กำลังโหลดเอกสารที่เคลียร์...</div>';
		}

		fetch('ajax_get_clear_br_item_docs.php?ref_id_br=' + encodeURIComponent(window.__cbrRefId || '') + '&product_id=' + encodeURIComponent(productId))
			.then(function(res) {
				return res.json();
			})
			.then(function(res) {
				if (!body) return;
				if (!res.success) {
					body.innerHTML = '<div style="text-align:center; padding:16px; color:#CF1322;">' + escapeHtmlLocal(res.message || 'เกิดข้อผิดพลาดในการโหลดข้อมูล') + '</div>';
					return;
				}
				body.innerHTML = renderCbrDocsTable(res.data.items);
				subRow.setAttribute('data-loaded', '1');
			})
			.catch(function(err) {
				console.error(err);
				if (body) body.innerHTML = '<div style="text-align:center; padding:16px; color:#CF1322;">เกิดข้อผิดพลาดในการเชื่อมต่อเซิร์ฟเวอร์</div>';
			});
	}

	document.addEventListener('keydown', function(event) {
		if (event.key === 'Escape' && document.getElementById('filterModal') && document.getElementById('filterModal').style.display === 'block') {
			closeFilterModal();
		}
		if (event.key === 'Escape' && document.getElementById('clearBrModal') && document.getElementById('clearBrModal').style.display === 'flex') {
			closeClearBrModal();
		}
		if ((event.key === 'Enter' || event.key === ' ') && event.target.classList && event.target.classList.contains('so-row')) {
			event.preventDefault();
			event.target.click();
		}
	});

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
				<h4 style="margin:0px;">รายการใบยืม</h4>
			</div>

			<?php
			date_default_timezone_set("Asia/Bangkok");
			$emid = isset($_SESSION['code']) ? $_SESSION['code'] : '';

			$sddd = "1";

			$Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';
			$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
			$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
			$sale_code = isset($_GET['sale_code']) ? $_GET['sale_code'] : '';
			$status_doc = isset($_GET['status_doc']) ? $_GET['status_doc'] : '';
			$type_br = isset($_GET['type_br']) ? $_GET['type_br'] : '';
			$status_br = isset($_GET['status_br']) ? $_GET['status_br'] : '';
			$no_iv = isset($_GET['no_iv']) ? $_GET['no_iv'] : '';
			$scriptName = htmlspecialchars($_SERVER['SCRIPT_NAME'], ENT_QUOTES, 'UTF-8');
			$add_url = ($emid == 'SUP_EN') ? 'register_supbreng.php' : 'register_supbrhos.php';
			?>

			<form name="frmSearch" method="GET" action="<?php echo $scriptName; ?>" id="mainSearchForm">
				<input type="hidden" name="start_date" value="<?php echo htmlspecialchars($start_date); ?>">
				<input type="hidden" name="end_date" value="<?php echo htmlspecialchars($end_date); ?>">
				<input type="hidden" name="sale_code" value="<?php echo htmlspecialchars($sale_code); ?>">
				<input type="hidden" name="status_doc" value="<?php echo htmlspecialchars($status_doc); ?>">
				<input type="hidden" name="type_br" value="<?php echo htmlspecialchars($type_br); ?>">
				<input type="hidden" name="status_br" value="<?php echo htmlspecialchars($status_br); ?>">
				<input type="hidden" name="no_iv" value="<?php echo htmlspecialchars($no_iv); ?>">

				<div class="so-input-group" style="align-items: flex-end; margin-bottom: 20px;">
					<!-- Left: Search Wrapper + Label + Add Button -->
					<div style="flex: 1; max-width: 680px; min-width: 250px; display: flex; flex-direction: column; gap: 6px;">
						<div style="font-size: 14px; color: #612989; font-weight: 500; font-family: 'Prompt', sans-serif !important;">
							ค้นหาด้วยเลขที่อ้างอิง/ชื่อลูกค้า/เลขที่เอกสาร
						</div>
						<div style="display: flex; gap: 12px; align-items: center;">
							<div class="so-search-wrapper" style="flex: 1; width: auto;">
								<i class="fas fa-search so-search-icon"></i>
								<input name="Keyword" class="so-input" type="text" id="Keyword" placeholder="Search" value="<?php echo htmlspecialchars($Keyword); ?>">
							</div>

							<!-- + เพิ่มใบยืมสินค้า button -->
							<a href="<?php echo $add_url; ?>" class="btn-so-outline" style="text-decoration:none; flex-shrink: 0;">
								<img src="img/icons/add_message.png" alt="" style="width: 16px; height: 16px; vertical-align: middle; margin-right: 6px;"> เพิ่มใบยืมสินค้า
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
							<input type="hidden" name="Keyword" id="modalKeyword" value="<?php echo htmlspecialchars($Keyword); ?>">

							<div class="so-modal-header" style="border-bottom: none; padding-bottom: 0; margin-bottom: 24px;">
								<h5 id="filterModalTitle" style="margin:0; font-weight:600; color:#3B3B3B; font-size:20px; font-family: 'Prompt', sans-serif !important;">Filters</h5>
								<button type="button" onclick="closeFilterModal()" aria-label="ปิดหน้าต่างตัวกรอง" style="background:none; border:none; padding:0; font-size:28px; cursor:pointer; color:#8E8B94; line-height: 1;">&times;</button>
							</div>

							<!-- Row 1: Dates -->
							<div class="so-form-row">
								<div>
									<label class="so-label">ตั้งแต่วันที่</label>
									<input type="date" name="start_date" id="modal_start_date" class="so-select so-modal-input" value="<?php echo htmlspecialchars($start_date); ?>">
								</div>
								<div>
									<label class="so-label">ถึงวันที่</label>
									<input type="date" name="end_date" id="modal_end_date" class="so-select so-modal-input" value="<?php echo htmlspecialchars($end_date); ?>">
								</div>
							</div>

							<!-- Row 2: Status & Type -->
							<div class="so-form-row">
								<div>
									<label class="so-label">สถานะการอนุมัติ</label>
									<select name="status_doc" id="modal_status_doc" class="so-select">
										<option value="">Select</option>
										<option value="รอหัวหน้า" <?php if ($status_doc == 'รอหัวหน้า' || $status_doc == 'Request') echo 'selected'; ?>>รอหัวหน้า</option>
										<option value="ส่งกลับ" <?php if ($status_doc == 'ส่งกลับ') echo 'selected'; ?>>ส่งกลับ</option>
										<option value="รอผู้บริหาร" <?php if ($status_doc == 'รอผู้บริหาร') echo 'selected'; ?>>รอผู้บริหาร</option>
										<option value="Rejected" <?php if ($status_doc == 'Rejected' || $status_doc == 'ไม่อนุมัติ') echo 'selected'; ?>>ไม่อนุมัติ</option>
										<option value="Approve" <?php if ($status_doc == 'Approve' || $status_doc == 'อนุมัติแล้ว') echo 'selected'; ?>>อนุมัติแล้ว</option>
										<option value="ยกเลิก" <?php if ($status_doc == 'ยกเลิก') echo 'selected'; ?>>ยกเลิก</option>
									</select>
								</div>
								<div>
									<label class="so-label">ประเภทใบยืม</label>
									<select name="type_br" id="modal_type_br" class="so-select">
										<option value="">Select</option>
										<option value="1" <?php if ($type_br == '1') echo 'selected'; ?>>ใบยืมลูกค้า</option>
										<option value="2" <?php if ($type_br == '2') echo 'selected'; ?>>ใบยืมพนักงาน</option>
									</select>
								</div>
							</div>

							<!-- Row 3: Sales Zone & Loan Status -->
							<div class="so-form-row">
								<div>
									<label class="so-label">เขตการขาย</label>
									<select name="sale_code" id="modal_sale_code" class="so-select">
										<option value="">Select</option>
										<?php
										if ($emid == 'SS1') {
											$strSQL5 = "SELECT * FROM tb_team_ss1 ORDER BY sale_code ASC";
										} else if ($emid == 'SS2') {
											$strSQL5 = "SELECT * FROM tb_team_ss2 ORDER BY sale_code ASC";
										} else if ($emid == 'SS3') {
											$strSQL5 = "SELECT * FROM tb_team_ss3 ORDER BY sale_code ASC";
										} else if ($emid == 'SS5') {
											$strSQL5 = "SELECT * FROM tb_team_ss3 WHERE sale_code IN ('S31','S32') ORDER BY sale_code ASC";
										} else if ($emid == 'MK2') {
											$strSQL5 = "SELECT * FROM tb_team_sm1 ORDER BY sale_code ASC";
										} else if ($emid == 'SUP_EN') {
											$strSQL5 = "SELECT * FROM tb_team_en ORDER BY sale_code ASC";
										} else {
											$strSQL5 = "SELECT * FROM tb_team_all ORDER BY sale_code ASC";
										}
										$objQuery5 = mysqli_query($com, $strSQL5);
										if ($objQuery5) {
											while ($objResuut5 = mysqli_fetch_array($objQuery5)) {
												$selected = ($sale_code == $objResuut5["sale_code"]) ? 'selected' : '';
										?>
												<option value="<?php echo htmlspecialchars($objResuut5["sale_code"]); ?>" <?php echo $selected; ?>>
													<?php echo htmlspecialchars($objResuut5["sale_code"]); ?> - <?php echo htmlspecialchars($objResuut5["sale_name"]); ?>
												</option>
										<?php
											}
										}
										?>
									</select>
								</div>
								<div>
									<label class="so-label">สถานะใบยืม</label>
									<select name="status_br" id="modal_status_br" class="so-select">
										<option value="">Select</option>
										<option value="open" <?php if ($status_br == 'open') echo 'selected'; ?>>ใบยืมคงค้าง</option>
										<option value="closed" <?php if ($status_br == 'closed') echo 'selected'; ?>>ใบยืมเคลียร์ครบแล้ว</option>
									</select>
								</div>
							</div>

							<!-- Row 4: Pills Toggles -->
							<div class="so-form-pills" style="display: flex; gap: 12px; margin-top: 8px; margin-bottom: 24px; flex-wrap: wrap;">
								<input type="hidden" name="no_iv" id="modal_no_iv" value="<?php echo htmlspecialchars($no_iv); ?>">
								<button type="button" id="pill_no_iv" class="filter-pill <?php echo ($no_iv == '1') ? 'active' : ''; ?>" onclick="toggleFilterPill('no_iv')">
									รอใส่เลขที่เอกสาร
								</button>
							</div>

							<!-- Footer Buttons -->
							<div class="so-modal-footer" style="margin-top: 24px;">
								<button type="submit" class="btn-filter-submit" onclick="syncKeyword()">ตกลง</button>
								<button type="button" class="btn-filter-reset" onclick="resetFilters()">
									<i class="fas fa-sync-alt" style="margin-right: 6px;"></i> รีเซ็ต
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>

			<!-- Table Section -->
			<div class="so-table-wrapper">
				<table class="so-table" id="soTable">
					<thead>
						<tr>
							<th width="3%"></th>
							<th width="3%"></th>
							<th width="10%">เลขที่อ้างอิง</th>
							<th width="12%">วันที่ลงทะเบียน</th>
							<th width="11%">เลขที่เอกสาร</th>
							<th width="11%">วันที่ออกเอกสาร</th>
							<th width="23%">ชื่อลูกค้า</th>
							<th width="10%">เขตการขาย</th>
							<th width="12%">สถานะ</th>
							<th width="4%"></th>
						</tr>
					</thead>
					<tbody>
						<?php
						$strSQL = "SELECT * FROM hos__br WHERE $sddd";

						if ($start_date != "") {
							$strSQL .= ' AND date_br >= "' . mysqli_real_escape_string($conn, $start_date) . '"';
						}

						if ($end_date != "") {
							$strSQL .= ' AND date_br <= "' . mysqli_real_escape_string($conn, $end_date) . '"';
						}

						if ($sale_code != "") {
							$strSQL .= ' AND sale_code = "' . mysqli_real_escape_string($conn, $sale_code) . '"';
						}

						if ($status_doc != "") {
							if ($status_doc == 'รอหัวหน้า' || $status_doc == 'Request') {
								$strSQL .= ' AND (status_doc = "รอหัวหน้า" OR status_doc = "Request")';
							} else if ($status_doc == 'ส่งกลับ') {
								$strSQL .= ' AND status_doc = "ส่งกลับ"';
							} else if ($status_doc == 'รอผู้บริหาร') {
								$strSQL .= ' AND status_doc = "รอผู้บริหาร"';
							} else if ($status_doc == 'Approve' || $status_doc == 'อนุมัติแล้ว') {
								$strSQL .= ' AND (status_doc = "Approve" OR status_doc = "อนุมัติแล้ว")';
							} else if ($status_doc == 'Rejected' || $status_doc == 'ไม่อนุมัติ') {
								$strSQL .= ' AND (status_doc = "Rejected" OR status_doc = "ไม่อนุมัติ")';
							} else if ($status_doc == 'ยกเลิก') {
								$strSQL .= ' AND status_doc = "ยกเลิก"';
							} else {
								$strSQL .= ' AND status_doc = "' . mysqli_real_escape_string($conn, $status_doc) . '"';
							}
						}

						if ($type_br != "") {
							$strSQL .= ' AND type_br = "' . mysqli_real_escape_string($conn, $type_br) . '"';
						}

						if ($status_br == "open") {
							$strSQL .= ' AND (status_br = "open" OR send_admin = "0")';
						} else if ($status_br == "closed") {
							$strSQL .= ' AND (status_br = "closed" OR send_admin = "1")';
						}

						if ($no_iv == "1") {
							$strSQL .= ' AND (iv_no = "" OR iv_no IS NULL OR iv_no = "0")';
						}

						if ($Keyword != "") {
							$kw = mysqli_real_escape_string($conn, $Keyword);
							$strSQL .= ' AND (customer LIKE "%' . $kw . '%" OR iv_no LIKE "%' . $kw . '%" OR status_doc LIKE "%' . $kw . '%" OR ref_id_br LIKE "%' . $kw . '%")';
						}

						// Count total rows before LIMIT
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

						$strSQL .= " ORDER BY id DESC LIMIT $Page_Start, $Per_Page";
						$objQuery = mysqli_query($conn, $strSQL) or die("Error Query [" . $strSQL . "]");

						if ($Num_Rows > 0) {
							$i = 1;
							while ($objResult = mysqli_fetch_array($objQuery)) {
								$ref_id_br = $objResult['ref_id_br'];
								$ref_id_url = urlencode($ref_id_br);
								$row_id = "row-" . preg_replace('/[^a-zA-Z0-9_-]/', '', $ref_id_br) . "-" . $i;
								$dropdown_id = "dropdown-" . preg_replace('/[^a-zA-Z0-9_-]/', '', $ref_id_br) . "-" . $i;
								$row_id_js = htmlspecialchars(json_encode($row_id), ENT_QUOTES, 'UTF-8');
								$dropdown_id_js = htmlspecialchars(json_encode($dropdown_id), ENT_QUOTES, 'UTF-8');

								// Edit link routing according to role
								$edit_target = ($emid == 'SUP_EN') ? 'register_supbreng_edit.php' : 'register_supbrhos.php';
								$create_target = ($emid == 'SUP_EN') ? 'register_supbreng_createnew.php' : 'register_supbrhos_createnew.php';

								// Map status_doc to class and display text
								$status_class = 'draft';
								$status_text = htmlspecialchars($objResult["status_doc"]);
								if ($objResult["status_doc"] == 'Approve' || $objResult["status_doc"] == 'อนุมัติแล้ว') {
									$status_class = 'approve';
									$status_text = 'อนุมัติแล้ว';
								} else if ($objResult["status_doc"] == 'Rejected' || $objResult["status_doc"] == 'ไม่อนุมัติ') {
									$status_class = 'rejected';
									$status_text = 'ไม่อนุมัติ';
								} else if ($objResult["status_doc"] == 'Request' || $objResult["status_doc"] == 'รอหัวหน้า' || $objResult["status_doc"] == 'Draft') {
									$status_class = 'pending-mgr';
									$status_text = 'รอหัวหน้า';
								} else if ($objResult["status_doc"] == 'ส่งกลับ') {
									$status_class = 'returned';
									$status_text = 'ส่งกลับ';
								} else if ($objResult["status_doc"] == 'รอผู้บริหาร') {
									$status_class = 'pending-exec';
									$status_text = 'รอผู้บริหาร';
								} else if ($objResult["status_doc"] == 'ยกเลิก') {
									$status_class = 'cancel';
									$status_text = 'ยกเลิก';
								}
						?>
								<!-- Main Row -->
								<tr class="so-row" role="button" tabindex="0" aria-expanded="false" onclick="toggleRow(<?php echo $row_id_js; ?>, this)">
									<td style="text-align:center; vertical-align:middle;">
										<img src="img/icons/arrow_down.png" class="caret-icon" alt="">
									</td>
									<td style="text-align:center; vertical-align:middle;">
										<?php if (isset($objResult["que_ckk"]) && $objResult["que_ckk"] == '1') { ?>
											<i class="fas fa-bolt" style="background: linear-gradient(180deg, #FF2B00 0%, #FF6600 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-size: 20px;" title="รายการด่วน"></i>
										<?php } ?>
									</td>
									<td>
										<a href="<?php echo $edit_target; ?>?ref_id_br=<?php echo $ref_id_url; ?>&start_date=<?php echo urlencode($start_date); ?>&end_date=<?php echo urlencode($end_date); ?>" style="color:#612989; text-decoration:underline; font-weight:500;" onclick="event.stopPropagation();">
											<?php echo htmlspecialchars($objResult["ref_id_br"]); ?>
										</a>
									</td>
									<td><?php echo DateThai($objResult["date_br"]); ?></td>
									<td><?php echo $objResult["iv_no"] ? htmlspecialchars($objResult["iv_no"]) : '-'; ?></td>
									<td>
										<?php
										if ($objResult["iv_date"] == "0000-00-00" || empty($objResult["iv_date"])) {
											echo "-";
										} else {
											echo DateThai($objResult["iv_date"]);
										}
										?>
									</td>
									<td><?php echo htmlspecialchars($objResult["customer"]); ?></td>
									<td><span class="badge-status" style="background: #F5F6F8; color: #4A4A4A;"><?php echo htmlspecialchars($objResult["sale_code"]); ?></span></td>
									<td>
										<span class="badge-status <?php echo $status_class; ?>">
											<?php echo $status_text; ?>
										</span>
									</td>
									<td style="text-align:center; vertical-align:middle; position:relative;">
										<div class="so-dropdown">
											<button type="button" class="so-dropdown-trigger" aria-label="ตัวเลือกเพิ่มเติม" aria-haspopup="true" aria-expanded="false" onclick="toggleDropdown(event, <?php echo $dropdown_id_js; ?>)">
												<i class="fas fa-ellipsis-v"></i>
											</button>
											<div id="<?php echo htmlspecialchars($dropdown_id); ?>" class="so-dropdown-menu">
												<!-- แก้ไข -->
												<a href="<?php echo $edit_target; ?>?ref_id_br=<?php echo $ref_id_url; ?>&start_date=<?php echo urlencode($start_date); ?>&end_date=<?php echo urlencode($end_date); ?>" class="so-dropdown-item">
													<i class="fas fa-edit" style="width:16px;"></i> แก้ไข
												</a>

												<!-- คัดลอกใบเดิม -->
												<a href="<?php echo $create_target; ?>?ref_id_br=<?php echo $ref_id_url; ?>&start_date=<?php echo urlencode($start_date); ?>&end_date=<?php echo urlencode($end_date); ?>" onclick="return confirm('!!!ต้องการเพิ่มเอกสารใหม่โดยCopyเอกสารเดิมใช่หรือไม่')" class="so-dropdown-item">
													<i class="fas fa-copy" style="width:16px;"></i> คัดลอกใบเดิม
												</a>

												<!-- พิมพ์ / Print -->
												<?php
												$report_url = (isset($objResult['company']) && $objResult['company'] == '2') ? 'report_loanhosnbm1.php' : 'report_loanhosptl1.php';
												?>
												<a href="<?php echo $report_url; ?>?ref_id_br=<?php echo $ref_id_url; ?>" target="_blank" class="so-dropdown-item">
													<i class="fas fa-print" style="width:16px;"></i> พิมพ์เอกสาร
												</a>

												<!-- รายละเอียดเคลียร์ยืม -->
												<a href="#" onclick="openClearBrModal(event, <?php echo htmlspecialchars(json_encode($objResult['ref_id_br']), ENT_QUOTES, 'UTF-8'); ?>); return false;" class="so-dropdown-item">
													<i class="fas fa-list-alt" style="width:16px;"></i> รายละเอียดเคลียร์ยืม
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
															<th width="45%">รายการสินค้า</th>
															<th width="15%" style="text-align:center;">จำนวน</th>
															<th width="20%" style="text-align:right !important;">ราคา/หน่วย</th>
															<th width="20%" style="text-align:right !important;">ยอดรวม</th>
														</tr>
													</thead>
													<tbody>
														<?php
														$sqlSub = "SELECT hos__subbr.*, tb_product.sol_name AS prod_sol_name FROM hos__subbr LEFT JOIN tb_product ON hos__subbr.product_ID=tb_product.product_id WHERE ref_idd_br = '" . mysqli_real_escape_string($conn, $objResult["ref_id_br"]) . "'";
														$qrySub = mysqli_query($conn, $sqlSub);
														$subRowsCount = $qrySub ? mysqli_num_rows($qrySub) : 0;
														$subTotalSum = 0;

														if ($subRowsCount > 0) {
															while ($subResult = mysqli_fetch_array($qrySub)) {
																$item_name = !empty($subResult['prod_sol_name']) ? $subResult['prod_sol_name'] : (isset($subResult['sol_name']) ? $subResult['sol_name'] : '');
																$qty = isset($subResult['count']) ? (int)$subResult['count'] : (isset($subResult['num']) ? (int)$subResult['num'] : 1);
																$price = isset($subResult['price']) ? (float)$subResult['price'] : 0;
																$amount = isset($subResult['amount']) ? (float)$subResult['amount'] : ($qty * $price);
																$subTotalSum += $amount;
														?>
																<tr>
																	<td><?php echo htmlspecialchars($item_name); ?></td>
																	<td style="text-align:center;"><?php echo $qty; ?></td>
																	<td style="text-align:right;"><?php echo number_format($price, 2); ?></td>
																	<td style="text-align:right;"><?php echo number_format($amount, 2); ?></td>
																</tr>
															<?php
															}
															?>
															<tr style="border-top: 1px solid #EDE9F0;">
																<td colspan="3" style="text-align:right; font-weight:500; padding: 14px 12px !important; font-size: 14px; color: #3B3B3B;">ยอดรวม</td>
																<td style="text-align:right; font-size:16px; color:#612989; font-weight:600; padding: 14px 12px !important;"><?php echo number_format($subTotalSum, 2); ?></td>
															</tr>
														<?php
														} else {
														?>
															<tr>
																<td colspan="4" style="text-align:center; color:#8E8B94; padding:20px;">ไม่มีข้อมูลรายการสินค้า</td>
															</tr>
														<?php } ?>
													</tbody>
												</table>
											</div>
										</div>
									</td>
								</tr>
							<?php
								$i++;
							}
						} else {
							?>
							<tr>
								<td colspan="10" style="text-align:center; padding:40px; color:#8E8B94;">
									<i class="fas fa-inbox" style="font-size:32px; margin-bottom:8px; display:block;"></i>
									ไม่พบข้อมูลเอกสารยืม-คืนตามเงื่อนไขที่เลือก
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>

			<!-- Pagination Restyling -->
			<div class="pagination-wrapper">
				<div>
					พบทั้งหมด <strong><?php echo number_format($Num_Rows); ?></strong> รายการ (หน้าที่ <?php echo $Page; ?> จาก <?php echo $Num_Pages; ?> หน้า)
				</div>
				<div class="pagination-links">
					<?php
					$pagParams = "&Keyword=" . urlencode($Keyword) . "&start_date=" . urlencode($start_date) . "&end_date=" . urlencode($end_date) . "&sale_code=" . urlencode($sale_code) . "&status_doc=" . urlencode($status_doc) . "&type_br=" . urlencode($type_br) . "&status_br=" . urlencode($status_br) . "&no_iv=" . urlencode($no_iv);

					if ($Prev_Page && $Prev_Page >= 1) {
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

					if ($Page != $Num_Pages && $Num_Pages > 1) {
						echo "<a class='pagination-btn' aria-label='หน้าถัดไป' href='$scriptName?Page=$Next_Page$pagParams'><i class='fas fa-chevron-right'></i></a>";
					}
					?>
				</div>
			</div>
			<!-- Modal: รายละเอียดเคลียร์ยืม -->
			<div id="clearBrModal" class="so-modal" style="display:none;" role="dialog" aria-modal="true" aria-labelledby="clearBrModalTitle">
				<div class="so-modal-backdrop" onclick="closeClearBrModal()"></div>
				<div class="so-modal-content cbr-modal-content">
					<div class="so-modal-header" style="display:flex; align-items:center; justify-content:space-between; padding-bottom: 16px; margin-bottom: 20px; border-bottom: 1px solid #EDE9F0;">
						<h3 id="clearBrModalTitle" class="so-modal-title" style="margin:0; font-size:20px; font-weight:600; color:#1C1B1F; display:flex; align-items:center; gap:10px;">
							<i class="fas fa-file-alt" style="color:#612989; font-size:22px;"></i>
							รายละเอียดเคลียร์ยืม
						</h3>
						<button type="button" class="so-modal-close" onclick="closeClearBrModal()" aria-label="ปิด">&times;</button>
					</div>
					<div class="so-modal-body" style="padding:0;">
						<div id="clearBrLoading" style="text-align:center; padding: 48px; color:#8E8B94;">
							<i class="fas fa-spinner fa-spin" style="font-size:32px; margin-bottom:12px; display:block; color:#612989;"></i>
							กำลังโหลดข้อมูลรายละเอียดเคลียร์ยืม...
						</div>
						<div id="clearBrContent" style="display:none;">
							<!-- Summary Card Grid (Matching Image Design) -->
							<div class="cbr-summary-grid">
								<div>
									<div style="font-size:14px; font-weight:500; color:#612989; margin-bottom:6px;">เลขที่เอกสาร</div>
									<div id="cbrIvNo" style="font-size:15px; color:#4A4A4A; font-weight:400;">-</div>
								</div>
								<div>
									<div style="font-size:14px; font-weight:500; color:#612989; margin-bottom:6px;">วันที่ออกเอกสาร</div>
									<div style="display:flex; align-items:center; gap:10px;">
										<span id="cbrDateBr" style="font-size:15px; color:#4A4A4A; font-weight:400;">-</span>
										<i class="far fa-calendar" style="color:#8E8B94; font-size:16px;"></i>
									</div>
								</div>
								<div>
									<div style="font-size:14px; font-weight:500; color:#612989; margin-bottom:6px;">ชื่อลูกค้า</div>
									<div id="cbrCustomer" style="font-size:15px; color:#4A4A4A; font-weight:400;">-</div>
								</div>
								<div>
									<div style="font-size:14px; font-weight:500; color:#612989; margin-bottom:6px;">แผนก/เขตการขาย</div>
									<div id="cbrSaleCode" style="font-size:15px; color:#4A4A4A; font-weight:400;">-</div>
								</div>
							</div>

							<!-- Items Table Section -->
							<h4 style="font-size:16px; font-weight:600; color:#1C1B1F; margin-top:0; margin-bottom:14px;">รายการสินค้าและการเคลียร์</h4>
							<div class="so-table-wrapper cbr-table-wrapper">
								<table class="so-table cbr-table">
									<thead>
										<tr style="background:#F9F8FA;">
											<!-- ตัวอย่างเช่น กำหนดความกว้างคอลัมน์รายการสินค้าเป็น 250px หรือ 300px -->
											<th style="width:280px; font-size:14px; font-weight:600; padding:14px 16px; color:#1C1B1F; border-bottom:1px solid #EDE9F0;">รายการสินค้า</th>
											<th style="font-size:14px; font-weight:600; text-align:center; width:100px; padding:14px 16px; color:#1C1B1F; border-bottom:1px solid #EDE9F0;">จำนวนยืม</th>
											<th style="font-size:14px; font-weight:600; text-align:center; width:110px; padding:14px 16px; color:#FF830F; border-bottom:1px solid #EDE9F0;">จำนวนคงค้าง</th>
											<!-- <th style="font-size:14px; font-weight:600; text-align:center; width:140px; padding:14px 16px; color:#1C1B1F; border-bottom:1px solid #EDE9F0;">หมายเลข SN</th> -->
										</tr>
									</thead>
									<tbody id="cbrItemsTableBody">
										<!-- Dynamic Rows -->
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
</body>

</html>