<link rel="stylesheet" href="css/autocomplete.css" type="text/css" />
<script type="text/javascript" src="js/autocomplete.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/row-drag.js?v=<?php echo filemtime(__DIR__ . '/js/row-drag.js'); ?>"></script>

<script type="text/javascript">
	if (typeof Swal === 'undefined') {
		var rtSwalScript = document.createElement('script');
		rtSwalScript.src = 'https://cdn.jsdelivr.net/npm/sweetalert2@11';
		document.head.appendChild(rtSwalScript);
	}
</script>

<script language="JavaScript">
	var RT_ROW_COUNT = 10;
	var rtRowFields = ['product_id', 'product_name', 'unit_name', 'sale_count', 'product_price', 'sum_amount', 'sn_number', 'warranty', 'sale_remarkk', 'display_name', 'free_count', 'delivery_cost'];
	var rtActiveEditRowIndex = null;

	var RT_DELETE_ICON_HTML = '<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="width:100%;height:100%;">' +
		'<path d="M4 6H20V8H4V6Z" fill="#EF5350"/>' +
		'<path d="M10 2H14V4H10V2Z" fill="#EF5350"/>' +
		'<path d="M5 9H19V20C19 21.1046 18.1046 22 17 22H7C5.89543 22 5 21.1046 5 20V9Z" fill="#EF5350"/>' +
		'<rect x="9" y="11" width="2" height="7" rx="1" fill="#ffffff"/>' +
		'<rect x="13" y="11" width="2" height="7" rx="1" fill="#ffffff"/>' +
		'</svg>';
	var RT_DELETE_CUSTOM_CLASS = {
		popup: 'figma-delete-popup',
		title: 'figma-delete-title',
		htmlContainer: 'figma-delete-html',
		confirmButton: 'figma-delete-confirm-btn',
		cancelButton: 'figma-delete-cancel-btn',
		actions: 'figma-delete-actions',
		icon: 'figma-delete-icon'
	};

	/* ===== บริษัท (AWL/NBM) จาก #rt_type_doc_select: 4=NBM, อื่น/ไม่มี=AWL ===== */
	function rtGetSelectedCompany() {
		var sel = document.getElementById('rt_type_doc_select');
		if (!sel) return 'AWL';
		return sel.value === '4' ? 'NBM' : 'AWL';
	}

	function rtEscapeHtml(text) {
		if (!text) return '';
		return text.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
	}

	/* ===== อ่าน/เขียนข้อมูลทั้งแถว (ใช้ตอนลาก-สลับตำแหน่ง) ===== */
	function rtGetRowData(i) {
		var data = {};
		rtRowFields.forEach(function(f) {
			var el = document.getElementById(f + i);
			if (el) data[f] = el.value;
		});
		var label = document.getElementById('product_name_label' + i);
		data.product_name_label = label ? label.textContent : '';
		var codeEl = document.getElementById('product_codet' + i);
		data.product_codet = codeEl ? codeEl.textContent : '';
		var row = document.getElementById('rt_row' + i);
		data.display = row ? row.style.display : 'none';
		var cb = document.getElementById('rt_ck' + i);
		data.checked = cb ? cb.checked : false;
		return data;
	}

	function rtSetRowData(i, data) {
		rtRowFields.forEach(function(f) {
			var el = document.getElementById(f + i);
			if (el && data[f] !== undefined) el.value = data[f];
		});
		var label = document.getElementById('product_name_label' + i);
		if (label) label.textContent = data.product_name_label || '';
		var codeEl = document.getElementById('product_codet' + i);
		if (codeEl) codeEl.textContent = data.product_codet || '';
		var row = document.getElementById('rt_row' + i);
		if (row) row.style.display = data.display !== undefined ? data.display : 'none';
		var cb = document.getElementById('rt_ck' + i);
		if (cb) cb.checked = !!data.checked;
		if (row) row.classList.toggle('checked-row', !!data.checked);
	}

	/* ===== ลาก-วางสลับตำแหน่งแถว (js/row-drag.js — ลากได้ทั้งเมาส์และนิ้ว) ===== */
	RowDrag.register({
		within: '#rt_product_table',
		row: 'tr.rt-product-row',
		onDrop: function(fromRow, toRow) {
			rtShiftRows(parseInt(fromRow.id.replace('rt_row', ''), 10), parseInt(toRow.id.replace('rt_row', ''), 10));
		}
	});

	function rtShiftRows(fromIndex, toIndex) {
		var allData = [];
		for (var i = 1; i <= RT_ROW_COUNT; i++) allData.push(rtGetRowData(i));
		var moved = allData.splice(fromIndex - 1, 1)[0];
		allData.splice(toIndex - 1, 0, moved);
		for (var j = 1; j <= RT_ROW_COUNT; j++) rtSetRowData(j, allData[j - 1]);
		rtCalculateSummary();
	}

	/* ===== เลือกแถวด้วย checkbox / ลบหลายรายการ ===== */
	function rtToggleRowHighlight(checkbox, rowIndex) {
		var row = document.getElementById('rt_row' + rowIndex);
		if (row) row.classList.toggle('checked-row', checkbox.checked);
		rtSyncSelectAllState();
		rtUpdateDeleteButtonVisibility();
	}

	function rtSyncSelectAllState() {
		var master = document.getElementById('rt_select_all');
		if (!master) return;
		var boxes = document.querySelectorAll('#rt_product_table tbody .so-row-checkbox');
		var allChecked = boxes.length > 0;
		boxes.forEach(function(cb) {
			if (!cb.checked) allChecked = false;
		});
		master.checked = allChecked;
	}

	function rtToggleSelectAll(master) {
		for (var i = 1; i <= RT_ROW_COUNT; i++) {
			var cb = document.getElementById('rt_ck' + i);
			var row = document.getElementById('rt_row' + i);
			if (cb) cb.checked = master.checked;
			if (row) row.classList.toggle('checked-row', master.checked);
		}
		rtUpdateDeleteButtonVisibility();
	}

	function rtUpdateDeleteButtonVisibility() {
		var hasChecked = false;
		for (var i = 1; i <= RT_ROW_COUNT; i++) {
			var cb = document.getElementById('rt_ck' + i);
			if (cb && cb.checked) {
				hasChecked = true;
				break;
			}
		}
		var btn = document.getElementById('rt_delete_selected_btn');
		if (btn) btn.style.display = hasChecked ? 'inline-flex' : 'none';
	}

	function rtDeleteSelectedRows() {
		var indexes = [];
		for (var i = 1; i <= RT_ROW_COUNT; i++) {
			var cb = document.getElementById('rt_ck' + i);
			if (cb && cb.checked) indexes.push(i);
		}
		if (!indexes.length) return;
		Swal.fire({
			title: 'ลบรายการที่เลือก ?',
			html: 'คุณต้องการลบสินค้าที่เลือกไว้ ' + indexes.length + ' รายการ',
			showCancelButton: true,
			confirmButtonText: 'ยืนยันลบ',
			cancelButtonText: 'ยกเลิก',
			reverseButtons: true,
			iconHtml: RT_DELETE_ICON_HTML,
			customClass: RT_DELETE_CUSTOM_CLASS,
			buttonsStyling: false
		}).then(function(result) {
			if (result.isConfirmed) {
				indexes.forEach(function(i) {
					rtExecuteClearRow(i);
				});
				rtUpdateDeleteButtonVisibility();
			}
		});
	}

	/* ===== ลบ/เคลียร์แถวเดียว ===== */
	function rtExecuteClearRow(rowIndex) {
		rtRowFields.forEach(function(f) {
			var el = document.getElementById(f + rowIndex);
			if (el) el.value = '';
		});
		var label = document.getElementById('product_name_label' + rowIndex);
		if (label) label.textContent = '';
		var cb = document.getElementById('rt_ck' + rowIndex);
		if (cb) cb.checked = false;
		var row = document.getElementById('rt_row' + rowIndex);
		if (row) {
			row.classList.remove('checked-row');
			row.style.display = 'none';
		}
		rtCalculateSummary();
		rtSyncSelectAllState();
	}

	function rtClearRow(rowIndex) {
		var idEl = document.getElementById('product_id' + rowIndex);
		var hasData = idEl && idEl.value.trim() !== '';
		if (!hasData) {
			rtExecuteClearRow(rowIndex);
			return;
		}
		var label = document.getElementById('product_name_label' + rowIndex);
		var name = label ? label.textContent.trim() : '';
		var displayMsg = name ?
			'คุณต้องการลบรายการ "' + rtEscapeHtml(name) + '" ใช่หรือไม่ ?' :
			'คุณต้องการลบรายการนี้ใช่หรือไม่ ?';

		if (typeof Swal === 'undefined') {
			if (confirm(displayMsg)) rtExecuteClearRow(rowIndex);
			return;
		}

		Swal.fire({
			title: 'ลบรายการสินค้า ?',
			html: displayMsg,
			showCancelButton: true,
			confirmButtonText: 'ยืนยันลบ',
			cancelButtonText: 'ยกเลิก',
			reverseButtons: true,
			iconHtml: RT_DELETE_ICON_HTML,
			customClass: RT_DELETE_CUSTOM_CLASS,
			buttonsStyling: false
		}).then(function(result) {
			if (result.isConfirmed) rtExecuteClearRow(rowIndex);
		});
	}

	function rtOpenEditModal(rowIndex) {
		rtActiveEditRowIndex = rowIndex;
		var remarkEl = document.getElementById('sale_remarkk' + rowIndex);
		var displayNameEl = document.getElementById('display_name' + rowIndex);

		var remarkInput = document.getElementById('rt_modal_sale_remarkk');
		if (remarkInput) {
			remarkInput.value = remarkEl ? remarkEl.value : '';
		}
		var displayNameInput = document.getElementById('rt_modal_display_name');
		if (displayNameInput) {
			displayNameInput.value = displayNameEl ? displayNameEl.value : '';
		}
		rtSyncModalClearButtons();
		var modal = document.getElementById('rt_edit_modal');
		if (modal) modal.style.display = 'flex';
	}

	function rtCloseEditModal() {
		var modal = document.getElementById('rt_edit_modal');
		if (modal) modal.style.display = 'none';
		rtActiveEditRowIndex = null;
	}

	function rtSaveEditModal() {
		if (!rtActiveEditRowIndex) return;
		var remarkEl = document.getElementById('sale_remarkk' + rtActiveEditRowIndex);
		var displayNameEl = document.getElementById('display_name' + rtActiveEditRowIndex);

		if (remarkEl && document.getElementById('rt_modal_sale_remarkk')) {
			remarkEl.value = document.getElementById('rt_modal_sale_remarkk').value;
		}
		if (displayNameEl && document.getElementById('rt_modal_display_name')) {
			displayNameEl.value = document.getElementById('rt_modal_display_name').value;
		}
		rtCloseEditModal();
	}

	function rtSyncModalClearButtons() {
		var modal = document.getElementById('rt_edit_modal');
		if (!modal) return;
		modal.querySelectorAll('.so-modal-clear').forEach(function(btn) {
			var target = document.getElementById(btn.getAttribute('data-target'));
			if (!target) return;
			btn.classList.toggle('is-visible', (target.value || '').trim() !== '');
		});
	}

	document.addEventListener('DOMContentLoaded', function() {
		var modal = document.getElementById('rt_edit_modal');
		if (!modal) return;
		modal.querySelectorAll('[data-clearable="true"]').forEach(function(input) {
			input.addEventListener('input', rtSyncModalClearButtons);
		});
		modal.querySelectorAll('.so-modal-clear').forEach(function(btn) {
			btn.addEventListener('click', function() {
				var target = document.getElementById(btn.getAttribute('data-target'));
				if (!target) return;
				target.value = '';
				target.focus();
				rtSyncModalClearButtons();
			});
		});
	});

	/* ===== ค้นหาสินค้า -> ตรวจค่าเช่า/ค่าจัดส่ง -> เติมแถวว่าง ===== */
	function rtFindFirstEmptyRow() {
		for (var i = 1; i <= RT_ROW_COUNT; i++) {
			var idEl = document.getElementById('product_id' + i);
			if (idEl && idEl.value.trim() === '') return i;
		}
		return -1;
	}

	function rtApplyProductToRow(rowIndex, accessCode, product) {
		var codeEl = document.getElementById('product_codet' + rowIndex);
		if (codeEl) codeEl.textContent = accessCode;
		document.getElementById('product_id' + rowIndex).value = product.product_ID;
		document.getElementById('product_name' + rowIndex).value = product.sol_name;
		var label = document.getElementById('product_name_label' + rowIndex);
		if (label) label.textContent = product.sol_name;
		document.getElementById('unit_name' + rowIndex).value = product.unit_name;
		document.getElementById('warranty' + rowIndex).value = product.vvv;

		/* ค่าเช่า/ค่าจัดส่ง มาจากช่องกรอกส่วนหัว ไม่ใช่ราคาขายจาก catalog (sol_price) —
		   ราคาเช่าต่อเดือนเป็นคนละค่ากับราคาขายสินค้า ค่าเช่าลงแถวผ่าน rtDistributeRent() ใน rtCalculateSummary() */
		document.getElementById('delivery_cost' + rowIndex).value = document.getElementById('rt_header_delivery').value;

		var row = document.getElementById('rt_row' + rowIndex);
		if (row) row.style.display = '';

		var qtyEl = document.getElementById('sale_count' + rowIndex);
		if (qtyEl && !qtyEl.value) qtyEl.value = '1';
		var freeEl = document.getElementById('free_count' + rowIndex);
		if (freeEl && !freeEl.value) freeEl.value = '0';

		rtCalculateSummary();

		setTimeout(function() {
			if (qtyEl) {
				qtyEl.focus();
				qtyEl.select();
			}
		}, 100);
	}

	function rtDoCallAjax(accessCode, rowIndex) {
		var req = new XMLHttpRequest();
		req.open('POST', 'data_product_rental.php', true);
		req.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		req.onreadystatechange = function() {
			if (req.readyState === 4) {
				if (req.responseText.trim() === '') return;
				try {
					var product = JSON.parse(req.responseText);
					if (product.found === false) {
						alert('ไม่พบรหัสสินค้า "' + accessCode + '" ในระบบ กรุณาตรวจสอบรหัสสินค้าอีกครั้ง');
						return;
					}
					rtApplyProductToRow(rowIndex, accessCode, product);
				} catch (e) {
					console.error('Failed to parse product JSON:', e, req.responseText);
				}
			}
		};
		req.send('product_code=' + encodeURIComponent(accessCode) + '&type_company=' + encodeURIComponent(rtGetSelectedCompany()) + '&format=json');
	}

	function rtValidateHeaderFields() {
		var rent = document.getElementById('rt_header_rent').value.trim();
		var delivery = document.getElementById('rt_header_delivery').value.trim();
		if (rent === '' || delivery === '' || isNaN(parseFloat(rent)) || isNaN(parseFloat(delivery))) {
			var msg = 'กรุณากรอกค่าเช่า/เดือน และค่าจัดส่งก่อนเลือกสินค้า';
			if (typeof Swal === 'undefined') {
				alert(msg);
			} else {
				Swal.fire({
					icon: 'warning',
					title: 'กรอกข้อมูลไม่ครบ',
					text: msg,
					confirmButtonColor: '#612989'
				});
			}
			return false;
		}
		return true;
	}

	/* ===== สรุปยอด (จำนวนรวม / เงินประกัน = ค่าเช่า/เดือน x2 / ยอดรวม = ค่าเช่า/เดือน + ค่าจัดส่ง) =====
	   ค่าเช่า/เดือนเป็นค่าเช่าของทั้งใบ ไม่คูณจำนวนชิ้นหรือจำนวนรายการ */
	function rtParseNumber(value) {
		var n = parseFloat((value || '').toString().replace(/,/g, ''));
		return isNaN(n) ? 0 : n;
	}

	function rtFormatMoney(value) {
		return value.toLocaleString(undefined, {
			minimumFractionDigits: 2,
			maximumFractionDigits: 2
		});
	}

	/* ค่าเช่าทั้งใบเก็บที่แถวสินค้าแถวแรกแถวเดียว แถวอื่นเป็น 0 — ผลรวม amount ทุกแถวจึงเท่ากับค่าเช่า/เดือน
	   (ตัวอ่านฝั่ง SO/ฉบับพิมพ์ใช้ SUM(amount): includes/rental_so_sync.php, from_rental.php) */
	function rtDistributeRent() {
		var rentRaw = document.getElementById('rt_header_rent').value.trim();
		var rentAmount = rtFormatMoney(rtParseNumber(rentRaw));
		var isFirstProductRow = true;
		for (var i = 1; i <= RT_ROW_COUNT; i++) {
			var idEl = document.getElementById('product_id' + i);
			if (!idEl || idEl.value.trim() === '') continue;
			document.getElementById('product_price' + i).value = isFirstProductRow ? rentRaw : '0';
			document.getElementById('sum_amount' + i).value = isFirstProductRow ? rentAmount : '0.00';
			isFirstProductRow = false;
		}
	}

	/* เรียกทุกครั้งที่รายการเปลี่ยน (เพิ่ม/ลบ/ลากแถว/แก้จำนวน) — ไม่แตะเงินประกัน
	   เงินประกันคำนวณใหม่เฉพาะตอนแก้ช่องค่าเช่า/เดือน (rtOnHeaderRentInput) */
	function rtCalculateSummary() {
		rtDistributeRent();
		rtRenderTotals();
	}

	function rtRenderTotals() {
		var qty = 0;
		var itemCount = 0;
		var hasVisibleRow = false;
		for (var i = 1; i <= RT_ROW_COUNT; i++) {
			var rowEl = document.getElementById('rt_row' + i);
			if (rowEl && rowEl.style.display !== 'none') hasVisibleRow = true;
			var qtyEl = document.getElementById('sale_count' + i);
			if (qtyEl) qty += rtParseNumber(qtyEl.value);
			var idEl = document.getElementById('product_id' + i);
			if (idEl && idEl.value.trim() !== '') itemCount++;
		}
		var deposit = rtParseNumber(document.getElementById('rt_deposit_amount').value);
		var rent = rtParseNumber(document.getElementById('rt_header_rent').value);
		var delivery = rtParseNumber(document.getElementById('rt_header_delivery').value);

		document.getElementById('rt_summary_qty').textContent = qty.toLocaleString();
		document.getElementById('rt_summary_deposit').textContent = rtFormatMoney(deposit);
		document.getElementById('rt_summary_amount').textContent = rtFormatMoney(rent + delivery);
		var countEl = document.getElementById('rt_summary_item_count');
		if (countEl) countEl.textContent = itemCount + ' รายการ';

		// กล่อง "ยังไม่มีรายการสินค้า" แสดงเมื่อไม่มีแถวไหนแสดงอยู่ (เหมือน #product_empty_state ของ product_salehos.php)
		var emptyState = document.getElementById('rt_empty_state');
		if (emptyState) emptyState.style.display = hasVisibleRow ? 'none' : '';
	}

	/* แก้ค่าเช่า/ค่าจัดส่งส่วนหัว -> อัปเดตทุกแถวที่มีสินค้าทันที แล้วแสดงยอดรวมใหม่ (ไม่แตะเงินประกัน) */
	function rtApplyHeaderToRows() {
		var delivery = document.getElementById('rt_header_delivery').value;
		for (var i = 1; i <= RT_ROW_COUNT; i++) {
			var idEl = document.getElementById('product_id' + i);
			if (!idEl || idEl.value.trim() === '') continue;
			document.getElementById('delivery_cost' + i).value = delivery;
		}
		rtCalculateSummary();
	}

	/* แก้ช่องค่าเช่า/เดือน -> เงินประกัน = ค่าเช่า/เดือน x2 ทับค่าที่ผู้ใช้แก้เอง (จุดเดียวที่คำนวณเงินประกันอัตโนมัติ) */
	function rtOnHeaderRentInput() {
		var rent = rtParseNumber(document.getElementById('rt_header_rent').value);
		document.getElementById('rt_deposit_amount').value = (rent * 2).toFixed(2);
		rtApplyHeaderToRows();
	}

	/* ===== แก้เงินประกันในช่องเดิม (Enter/blur = บันทึก, Esc = ยกเลิก) ===== */
	function rtStartDepositEdit() {
		var wrap = document.getElementById('rt_deposit_display');
		var input = document.getElementById('rt_deposit_input');
		if (!wrap || !input) return;
		input.value = rtParseNumber(document.getElementById('rt_deposit_amount').value).toFixed(2);
		wrap.style.display = 'none';
		input.style.display = '';
		input.focus();
		input.select();
	}

	function rtFinishDepositEdit(commit) {
		var wrap = document.getElementById('rt_deposit_display');
		var input = document.getElementById('rt_deposit_input');
		if (!wrap || !input || input.style.display === 'none') return;
		if (commit) {
			var raw = input.value.replace(/,/g, '').trim();
			var n = parseFloat(raw);
			if (raw !== '' && !isNaN(n) && n >= 0) {
				document.getElementById('rt_deposit_amount').value = n.toFixed(2);
			}
		}
		input.style.display = 'none';
		wrap.style.display = '';
		rtRenderTotals();
	}

	function rtDepositInputKeydown(e) {
		if (e.key === 'Enter') {
			e.preventDefault();
			rtFinishDepositEdit(true);
		} else if (e.key === 'Escape') {
			e.preventDefault();
			rtFinishDepositEdit(false);
		}
	}
</script>

<div class="so-product-summary-bar rt-summary-bar-3col" id="rt_summary_bar">
	<div class="so-product-summary-col">
		<span class="so-product-summary-label">จำนวนรวม(ชิ้น)</span>
		<span class="so-product-summary-value" id="rt_summary_qty">0</span>
	</div>
	<div class="so-product-summary-col">
		<span class="so-product-summary-label">เงินประกัน</span>
		<span class="rt-deposit-display" id="rt_deposit_display">
			<span class="so-product-summary-value rt-deposit-value" id="rt_summary_deposit">0.00</span>
			<button type="button" class="rt-deposit-edit-btn" title="แก้ไขเงินประกัน" aria-label="แก้ไขเงินประกัน" onclick="rtStartDepositEdit();">
				<img src="img/icons/edit.svg" alt="">
			</button>
		</span>
		<input type="text" id="rt_deposit_input" class="so-input rt-deposit-input" inputmode="decimal" style="display:none;"
			aria-label="เงินประกัน" onkeydown="rtDepositInputKeydown(event);" onblur="rtFinishDepositEdit(true);">
		<input type="hidden" name="deposit_amount" id="rt_deposit_amount" value="0.00">
	</div>
	<div class="so-product-summary-col">
		<span class="so-product-summary-label">ยอดรวม</span>
		<span class="so-product-summary-value" id="rt_summary_amount">0.00</span>
	</div>
</div>

<div class="cs-product-toolbar-row rt-product-header-row">
	<div class="so-field-group cs-product-search-wrap">
		<label class="so-label" for="rt_product_search">ค้นหารายการสินค้า</label>
		<div class="cs-product-search-bar">
			<i class="fas fa-search" aria-hidden="true"></i>
			<input type="text" id="rt_product_search" placeholder="ค้นหาด้วยรหัสสินค้า / ชื่อสินค้า" autocomplete="off">
		</div>
	</div>

	<div class="so-field-group rt-header-input">
		<label class="so-label" for="rt_header_rent">ค่าเช่า/เดือน<span class="rt-required-mark">*</span></label>
		<input type="text" id="rt_header_rent" class="so-input" placeholder="ใส่เฉพาะตัวเลข" oninput="rtOnHeaderRentInput();">
	</div>

	<div class="so-field-group rt-header-input">
		<label class="so-label" for="rt_header_delivery">ค่าจัดส่ง<span class="rt-required-mark">*</span></label>
		<input type="text" id="rt_header_delivery" class="so-input" placeholder="ใส่เฉพาะตัวเลข" oninput="rtApplyHeaderToRows();">
	</div>

	<div class="cs-product-header-row">
		<button type="button" class="cs-delete-selected-btn" id="rt_delete_selected_btn" style="display:none;" onclick="rtDeleteSelectedRows();">
			<i class="far fa-trash-alt"></i> ลบรายการที่เลือก
		</button>
	</div>
</div>

<div class="so-product-table-wrap" id="rt_product_table_wrap">
	<table width="100%" class="so-product-table rt-product-table" id="rt_product_table">
		<thead>
			<tr>
				<th>
					<label class="so-row-checkbox-wrap">
						<input type="checkbox" class="so-row-checkbox" id="rt_select_all" aria-label="เลือกทุกรายการ" onclick="rtToggleSelectAll(this);">
						<span class="so-row-checkbox-dot" aria-hidden="true"></span>
					</label>
				</th>
				<th>รหัสสินค้า</th>
				<th>รายการสินค้า</th>
				<th>ของแถม</th>
				<th>จำนวน</th>
				<th>หมายเลข SN</th>
				<th>เพิ่มเติม</th>
			</tr>
		</thead>
		<tbody>
			<?php
			function rt_product_row($i)
			{
			?>
				<tr class="so-product-row rt-product-row" id="rt_row<?php echo $i; ?>" style="display:none;">
					<td>
						<div class="cs-row-controls-inner">
							<i class="fas fa-grip-vertical cs-drag-handle rd-handle"
								title="ลากเพื่อจัดเรียง"
								aria-hidden="true"></i>
							<label class="so-row-checkbox-wrap">
								<input type="checkbox" class="so-row-checkbox" id="rt_ck<?php echo $i; ?>" aria-label="เลือกรายการที่ <?php echo $i; ?>" onchange="rtToggleRowHighlight(this,<?php echo $i; ?>);">
								<span class="so-row-checkbox-dot" aria-hidden="true"></span>
							</label>
						</div>
						<input type='hidden' name="product_id<?php echo $i; ?>" id="product_id<?php echo $i; ?>" />
						<input type='hidden' name="product_name<?php echo $i; ?>" id="product_name<?php echo $i; ?>" />
						<input type='hidden' name="unit_name<?php echo $i; ?>" id="unit_name<?php echo $i; ?>" />
						<input type='hidden' name="product_price<?php echo $i; ?>" id="product_price<?php echo $i; ?>" />
						<input type='hidden' name="delivery_cost<?php echo $i; ?>" id="delivery_cost<?php echo $i; ?>" />
						<input type='hidden' name="warranty<?php echo $i; ?>" id="warranty<?php echo $i; ?>" />
						<input type='hidden' name="sale_remarkk<?php echo $i; ?>" id="sale_remarkk<?php echo $i; ?>" />
						<input type='hidden' name="display_name<?php echo $i; ?>" id="display_name<?php echo $i; ?>" />
					</td>
					<td class="cs-code-col">
						<span class="cs-code-text" id="product_codet<?php echo $i; ?>"></span>
					</td>
					<td>
						<span class="so-product-name-label" id="product_name_label<?php echo $i; ?>"></span>
					</td>
					<td>
						<div class="cs-cell-pill">
							<input type='text' name="free_count<?php echo $i; ?>" id="free_count<?php echo $i; ?>" class="so-input" style="text-align:center" value="0">
						</div>
					</td>
					<td>
						<div class="cs-cell-pill">
							<input type='text' name="sale_count<?php echo $i; ?>" id="sale_count<?php echo $i; ?>" class="so-input" style="text-align:center" oninput="rtCalculateSummary();">
						</div>
						<input type='hidden' name="sum_amount<?php echo $i; ?>" id="sum_amount<?php echo $i; ?>" value="">
					</td>
					<td>
						<div class="cs-cell-pill">
							<input type='text' name="sn_number<?php echo $i; ?>" id="sn_number<?php echo $i; ?>" class="so-input" placeholder="ใส่เลข SN">
						</div>
					</td>
					<td class="rt-row-actions-cell">
						<div class="rt-row-actions">
							<button type="button" class="rt-row-action-btn" title="แก้ไขข้อมูลเพิ่มเติม" aria-label="แก้ไขข้อมูลเพิ่มเติมของรายการที่ <?php echo $i; ?>" onclick="rtOpenEditModal(<?php echo $i; ?>);">
								<img src="img/icons/edit.png" alt="">
							</button>
							<button type="button" class="rt-row-action-btn is-delete" title="ลบรายการ" aria-label="ลบรายการที่ <?php echo $i; ?>" onclick="rtClearRow(<?php echo $i; ?>);">
								<img src="img/icons/trash.svg" alt="">
							</button>
						</div>
					</td>
				</tr>
			<?php
			}

			for ($rtI = 1; $rtI <= 10; $rtI++) {
				rt_product_row($rtI);
			}
			?>
		</tbody>
	</table>
</div>
<div class="so-product-empty-state" id="rt_empty_state"<?php if (!empty($savedRentalProducts)) echo ' style="display:none;"'; ?>>ยังไม่มีรายการสินค้า — ค้นหาสินค้าจากช่องด้านบน</div>

<div id="rt_edit_modal" class="cs-modal-overlay" style="display:none;">
	<div class="cs-modal-card">
		<div class="cs-modal-header">
			<h3 class="cs-modal-title">ข้อมูลรายการสินค้าเพิ่มเติม</h3>
			<button type="button" class="cs-modal-close-btn" onclick="rtCloseEditModal();" aria-label="ปิด">&times;</button>
		</div>
		<div class="cs-modal-body">
			<div class="so-field-group">
				<label class="so-label">หมายเหตุสินค้า</label>
				<div class="so-modal-input-wrap">
					<input type="text" id="rt_modal_sale_remarkk" class="so-input" placeholder="ระบุหมายเหตุสินค้า" data-clearable="true">
					<button type="button" class="so-modal-clear" data-target="rt_modal_sale_remarkk" aria-label="ล้างข้อมูล">&times;</button>
				</div>
			</div>
		</div>
		<div class="cs-modal-footer">
			<button type="button" class="cs-modal-btn-update" onclick="rtSaveEditModal();">อัพเดท</button>
			<button type="button" class="cs-modal-btn-cancel" onclick="rtCloseEditModal();">ยกเลิก</button>
		</div>
	</div>
</div>

<script>
	(function rtDetachEditModal() {
		var modal = document.getElementById('rt_edit_modal');
		if (modal && modal.parentNode !== document.body) {
			document.body.appendChild(modal);
		}
	})();

	var rtProductAcInstance = new Autocomplete("rt_product_search", function() {
		this.setValue = function(accessCode) {
			if (!accessCode) return;
			if (!rtValidateHeaderFields()) {
				document.getElementById('rt_product_search').value = '';
				return;
			}
			var rowIndex = rtFindFirstEmptyRow();
			if (rowIndex === -1) {
				alert('ไม่สามารถเพิ่มสินค้าได้ (ตารางเต็ม ' + RT_ROW_COUNT + ' รายการแล้ว)');
				document.getElementById('rt_product_search').value = '';
				return;
			}
			rtDoCallAjax(accessCode, rowIndex);
			document.getElementById('rt_product_search').value = '';
		};

		if (this.value.length < 1 && this.isNotClick) return;
		return "data_pro_rental.php?product_code_search=" + encodeURIComponent(this.value) + "&type_company=" + encodeURIComponent(rtGetSelectedCompany());
	}, {
		select_first: 0
	});

	if (rtProductAcInstance.image && rtProductAcInstance.image.e) {
		rtProductAcInstance.image.e.style.display = 'none';
	}

	(function() {
		var searchInput = document.getElementById('rt_product_search');
		var acInstance = Autocomplete.inst[Autocomplete.inst.length - 1];
		searchInput.addEventListener('paste', function() {
			setTimeout(function() {
				acInstance.isModified = 1;
				acInstance.isNotClick = 1;
				acInstance.isON = 1;
				acInstance.request();
			}, 0);
		});
	})();

	/* render อย่างเดียว — jQuery ready อาจรันหลัง prefill ของ edit mode
	   (register_suprental.php) ซึ่งเขียนเงินประกันที่บันทึกไว้ลง rt_deposit_amount แล้ว */
	$(document).ready(function() {
		rtRenderTotals();
	});

	/* ===== เปลี่ยนบริษัท: ถ้ามีสินค้าอยู่ ให้ยืนยันก่อนล้างทั้ง 10 แถว ===== */
	(function rtInitCompanyChangeGuard() {
		var companySelect = document.getElementById('rt_type_doc_select');
		if (!companySelect) return;

		var rtPrevCompanyValue = companySelect.value;

		function rtHasAnyProduct() {
			for (var i = 1; i <= RT_ROW_COUNT; i++) {
				var idEl = document.getElementById('product_id' + i);
				if (idEl && idEl.value.trim() !== '') return true;
			}
			return false;
		}

		function rtClearAllRowsAndResetSearch() {
			for (var i = 1; i <= RT_ROW_COUNT; i++) {
				rtExecuteClearRow(i);
			}
			var searchInput = document.getElementById('rt_product_search');
			if (searchInput) searchInput.value = '';
			var selectAll = document.getElementById('rt_select_all');
			if (selectAll) selectAll.checked = false;
			rtUpdateDeleteButtonVisibility();
		}

		companySelect.addEventListener('change', function() {
			var newValue = companySelect.value;

			if (!rtHasAnyProduct()) {
				rtPrevCompanyValue = newValue;
				return;
			}

			Swal.fire({
				title: 'เปลี่ยนบริษัท ?',
				html: 'การเปลี่ยนบริษัทจะล้างรายการสินค้าทั้งหมดและคำนวณยอดใหม่ ต้องการดำเนินการต่อหรือไม่ ?',
				showCancelButton: true,
				confirmButtonText: 'ยืนยัน',
				cancelButtonText: 'ยกเลิก',
				reverseButtons: true,
				customClass: RT_DELETE_CUSTOM_CLASS,
				buttonsStyling: false
			}).then(function(result) {
				if (result.isConfirmed) {
					rtClearAllRowsAndResetSearch();
					rtPrevCompanyValue = newValue;
				} else {
					companySelect.value = rtPrevCompanyValue;
				}
			});
		});
	})();
</script>
