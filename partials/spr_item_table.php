<?php
$sprSavedItems = isset($sprSavedItems) && is_array($sprSavedItems) ? $sprSavedItems : array();

/** แปลงแถวจาก DB (spr_load_items) ให้เป็นรูปเดียวกับที่ JS ใช้สร้างแถว */
$sprRowsToJs = function (array $rows) {
	$out = array();
	foreach ($rows as $row) {
		$out[] = array(
			'product_id'   => (string)($row['product_id'] ?? ''),
			'access_code'  => (string)($row['access_code'] ?? ''),
			'product_name' => (string)($row['sol_name'] ?? ''),
			'unit_name'    => (string)($row['unit_name'] ?? ''),
			'sale_count'   => (string)($row['sale_count'] ?? ''),
			'unit_price'   => (string)($row['unit_price'] ?? ''),
			'warranty_year'=> (string)($row['warranty_year'] ?? ''),
			'sale_remark'  => (string)($row['sale_remark'] ?? ''),
			'sn'           => (string)($row['sn'] ?? ''),
			'clear_br'     => (string)($row['clear_br'] ?? ''),
			'clear_ivno'   => (string)($row['clear_ivno'] ?? ''),
		);
	}
	return $out;
};
?>

<script type="text/javascript">
	var SPR_SAVED_ITEMS = <?php echo json_encode($sprRowsToJs($sprSavedItems), JSON_UNESCAPED_UNICODE); ?>;
	var sprRowSeq = 0;

	function sprEscapeHtml(value) {
		return String(value === null || value === undefined ? '' : value).replace(/[&<>"']/g, function(ch) {
			return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' }[ch];
		});
	}

	function sprGetTypeCompany() {
		var select = document.getElementById('type_company_select');
		return (select && select.value === '2') ? 'NBM' : 'AWL';
	}

	function sprFormatMoney(value) {
		var number = Number(value || 0);
		if (!isFinite(number)) number = 0;
		return number.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
	}

	/* ===== แถวหนึ่งแถวของตาราง =====
	   ฟิลด์ทุกตัวเป็น items[n][field] — ลำดับใน POST = ลำดับ <tr> ใน DOM (การลากจัดเรียง
	   ย้าย <tr> จริง ไม่ต้องสลับค่าทีละฟิลด์) n เป็นแค่ตัวนับกันชื่อชนกัน ไม่ต้องเรียงต่อเนื่อง */
	function sprBuildRowHtml(data) {
		data = data || {};
		var idx = sprRowSeq++;
		var p = 'items[' + idx + ']';

		var html = '<tr class="so-product-row spr-row" draggable="false"' +
			' ondragover="sprHandleDragOver(event)" ondragenter="sprHandleDragEnter(event)"' +
			' ondragleave="sprHandleDragLeave(event)" ondrop="sprHandleDrop(event, this)">';

		html += '<td class="spr-drag-cell"><i class="fas fa-grip-vertical cs-drag-handle" draggable="true" title="ลากเพื่อจัดเรียง" aria-hidden="true"' +
			' ondragstart="sprHandleDragStart(event, this)" ondragend="sprHandleDragEnd(event)"></i></td>';

		html += '<td class="spr-select-cell"><label class="so-row-checkbox-wrap" aria-label="เลือกรายการ">' +
			'<input type="checkbox" class="so-row-checkbox spr-row-selector" onchange="sprToggleRowSelection(this);">' +
			'<span class="so-row-checkbox-dot" aria-hidden="true"></span></label></td>';

		html += '<td>' +
			'<span class="cs-code-text spr-cell-code">' + sprEscapeHtml(data.access_code) + '</span>' +
			'<input type="hidden" name="' + p + '[product_id]" class="spr-f-product_id" value="' + sprEscapeHtml(data.product_id) + '">' +
			'<input type="hidden" name="' + p + '[product_code]" class="spr-f-access_code" value="' + sprEscapeHtml(data.access_code) + '">' +
			'</td>';

		html += '<td><span class="cs-product-name-text spr-cell-name">' + sprEscapeHtml(data.product_name) + '</span>' +
			'<input type="hidden" name="' + p + '[unit_name]" class="spr-f-unit_name" value="' + sprEscapeHtml(data.unit_name) + '"></td>';

		html += '<td><div class="cs-cell-pill">' +
			'<input type="text" name="' + p + '[sale_count]" class="so-input spr-f-count" inputmode="decimal" style="text-align:center"' +
			' value="' + sprEscapeHtml(data.sale_count || '1') + '" onchange="sprNormalizeCount(this); sprRefreshSummary();">' +
			'</div></td>';

		html += '<td><div class="cs-cell-pill">' +
			'<input type="text" name="' + p + '[unit_price]" class="so-input spr-f-price" inputmode="decimal" style="text-align:right"' +
			' value="' + sprEscapeHtml(data.unit_price || '0') + '" onchange="sprNormalizePrice(this); sprRefreshSummary();">' +
			'</div></td>';

		html += '<td class="spr-cell-amount" data-spr-amount>0.00</td>';

		html += '<td class="cs-row-actions-cell">' +
			'<input type="hidden" name="' + p + '[warranty_year]" class="spr-f-warranty_year" value="' + sprEscapeHtml(data.warranty_year) + '">' +
			'<input type="hidden" name="' + p + '[sale_remark]" class="spr-f-remark" value="' + sprEscapeHtml(data.sale_remark) + '">' +
			'<input type="hidden" name="' + p + '[sn]" class="spr-f-sn" value="' + sprEscapeHtml(data.sn) + '">' +
			'<input type="hidden" name="' + p + '[clear_br]" class="spr-f-clear_br" value="' + (data.clear_br === '1' ? '1' : '0') + '">' +
			'<input type="hidden" name="' + p + '[clear_ivno]" class="spr-f-clear_ivno" value="' + sprEscapeHtml(data.clear_ivno) + '">' +
			'<button type="button" class="cs-row-edit-btn" title="แก้ไขข้อมูลเพิ่มเติม" onclick="sprOpenEditModal(this);"><i class="far fa-edit" aria-hidden="true"></i></button>' +
			'<button type="button" class="so-product-remove-btn" title="ลบรายการ" onclick="sprRemoveRow(this);"><i class="far fa-trash-alt" aria-hidden="true"></i></button>' +
			'</td>';

		html += '</tr>';
		return html;
	}

	function sprTbody() {
		return document.getElementById('spr_tbody');
	}

	function sprRowAmount(row) {
		var count = parseFloat(row.querySelector('.spr-f-count') ? row.querySelector('.spr-f-count').value : '0') || 0;
		var price = parseFloat(row.querySelector('.spr-f-price') ? row.querySelector('.spr-f-price').value : '0') || 0;
		return count * price;
	}

	function sprAddRow(data) {
		var tbody = sprTbody();
		if (!tbody) return null;
		tbody.insertAdjacentHTML('beforeend', sprBuildRowHtml(data));
		sprRefreshSummary();
		sprSyncSelectAll();
		return tbody.lastElementChild;
	}

	function sprNormalizeCount(input) {
		var raw = String(input.value || '').replace(/[^0-9.]/g, '');
		var value = parseFloat(raw);
		input.value = (isNaN(value) || value <= 0) ? '1' : String(value);
	}

	function sprNormalizePrice(input) {
		var raw = String(input.value || '').replace(/[^0-9.]/g, '');
		var value = parseFloat(raw);
		input.value = isNaN(value) ? '0' : String(value);
	}

	function sprRefreshSummary() {
		var tbody = sprTbody();
		if (!tbody) return;
		var rows = tbody.querySelectorAll('tr.spr-row');
		var totalQty = 0;
		var grandTotal = 0;
		rows.forEach(function(row) {
			var qty = parseFloat(row.querySelector('.spr-f-count') ? row.querySelector('.spr-f-count').value : '0') || 0;
			totalQty += qty;
			var amount = sprRowAmount(row);
			grandTotal += amount;
			var amountCell = row.querySelector('[data-spr-amount]');
			if (amountCell) amountCell.textContent = sprFormatMoney(amount);
		});

		var countEl = document.getElementById('spr_item_count');
		if (countEl) countEl.textContent = rows.length + ' รายการ';
		var qtyEl = document.getElementById('spr_qty_total');
		if (qtyEl) qtyEl.textContent = String(totalQty);
		var grandEl = document.getElementById('spr_grand_total');
		if (grandEl) grandEl.textContent = sprFormatMoney(grandTotal);
		var emptyEl = document.getElementById('spr_empty_state');
		if (emptyEl) emptyEl.style.display = rows.length === 0 ? '' : 'none';
	}

	function sprSyncSelectAll() {
		var selectors = Array.prototype.slice.call(document.querySelectorAll('.spr-row-selector'));
		var selectAll = document.getElementById('spr_select_all');
		if (!selectAll) return;
		var selectedCount = selectors.filter(function(input) { return input.checked; }).length;
		selectAll.checked = selectors.length > 0 && selectedCount === selectors.length;
		selectAll.indeterminate = selectedCount > 0 && selectedCount < selectors.length;
	}

	function sprToggleRowSelection(input) {
		var row = input ? input.closest('tr.spr-row') : null;
		if (row) row.classList.toggle('checked-row', !!input.checked);
		sprSyncSelectAll();
	}

	function sprToggleAllRows(input) {
		document.querySelectorAll('.spr-row-selector').forEach(function(selector) {
			selector.checked = !!input.checked;
			var row = selector.closest('tr.spr-row');
			if (row) row.classList.toggle('checked-row', !!input.checked);
		});
		sprSyncSelectAll();
	}

	function sprRemoveRow(button) {
		var row = button.closest('tr');
		if (!row) return;
		var nameEl = row.querySelector('.spr-cell-name');
		var productName = nameEl ? nameEl.textContent.trim() : '';
		var message = productName ? 'คุณต้องการลบรายการ "' + productName + '" ใช่หรือไม่ ?' : 'คุณต้องการลบรายการนี้ใช่หรือไม่ ?';

		function doRemove() {
			row.remove();
			sprRefreshSummary();
			sprSyncSelectAll();
		}

		if (typeof Swal === 'undefined') {
			if (confirm(message)) doRemove();
			return;
		}

		Swal.fire({
			icon: 'warning',
			title: 'ยืนยันการลบรายการ',
			text: message,
			showCancelButton: true,
			confirmButtonText: 'ยืนยันลบ',
			cancelButtonText: 'ยกเลิก',
			reverseButtons: true,
			confirmButtonColor: '#DC3545',
			cancelButtonColor: '#612989'
		}).then(function(result) {
			if (result.isConfirmed) doRemove();
		});
	}

	/* ===== ลากจัดเรียง — ย้าย <tr> จริง ลำดับ POST จึงตามไปเอง ===== */
	var sprDraggedRow = null;

	function sprHandleDragStart(event, handle) {
		sprDraggedRow = handle.closest('tr');
		event.dataTransfer.effectAllowed = 'move';
		try { event.dataTransfer.setData('text/plain', 'spr-row'); } catch (e) {}
		if (sprDraggedRow) sprDraggedRow.classList.add('dragging');
	}

	function sprHandleDragOver(event) {
		event.preventDefault();
		event.dataTransfer.dropEffect = 'move';
	}

	function sprHandleDragEnter(event) {
		if (event.currentTarget) event.currentTarget.classList.add('drag-over');
	}

	function sprHandleDragLeave(event) {
		if (event.currentTarget) event.currentTarget.classList.remove('drag-over');
	}

	function sprHandleDrop(event, targetRow) {
		event.preventDefault();
		if (targetRow) targetRow.classList.remove('drag-over');
		if (!sprDraggedRow || sprDraggedRow === targetRow) return;

		var rows = Array.prototype.slice.call(targetRow.parentNode.children);
		var from = rows.indexOf(sprDraggedRow);
		var to = rows.indexOf(targetRow);
		if (from < 0 || to < 0) return;

		targetRow.parentNode.insertBefore(sprDraggedRow, from < to ? targetRow.nextSibling : targetRow);
	}

	function sprHandleDragEnd() {
		document.querySelectorAll('tr.spr-row').forEach(function(row) {
			row.classList.remove('dragging', 'drag-over');
		});
		sprDraggedRow = null;
	}

	/* ===== เติมสินค้าจากช่องค้นหา ===== */
	function sprFetchProduct(accessCode) {
		var request = new XMLHttpRequest();
		request.open('POST', 'data_product_spr1.php', true);
		request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		request.onreadystatechange = function() {
			if (request.readyState !== 4) return;

			if (request.status !== 200 || request.responseText.trim() === '') {
				sprNotify('ไม่สามารถดึงข้อมูลสินค้าได้', 'กรุณาลองใหม่อีกครั้ง', 'error');
				return;
			}

			var product;
			try {
				product = JSON.parse(request.responseText);
			} catch (e) {
				sprNotify('ไม่สามารถอ่านข้อมูลสินค้าได้', 'รูปแบบข้อมูลจากระบบไม่ถูกต้อง', 'error');
				return;
			}

			if (product.found === false) {
				sprNotify('ไม่พบสินค้า', 'ไม่พบรหัสสินค้า "' + accessCode + '" ในระบบ', 'warning');
				return;
			}

			var row = sprAddRow({
				product_id: product.product_ID,
				access_code: product.access_code || accessCode,
				product_name: product.sol_name,
				unit_name: product.unit_name,
				sale_count: '1',
				unit_price: product.sol_price || '0',
				sale_remark: '',
				sn: '',
				clear_br: '0',
				clear_ivno: ''
			});

			if (row) {
				var countInput = row.querySelector('.spr-f-count');
				if (countInput) {
					countInput.focus();
					countInput.select();
				}
			}
		};
		request.send('product_code=' + encodeURIComponent(accessCode) + '&type_company=' + sprGetTypeCompany());
	}

	function sprNotify(title, text, icon) {
		if (typeof Swal === 'undefined') {
			alert(title + (text ? '\n' + text : ''));
			return;
		}
		Swal.fire({ title: title, text: text, icon: icon || 'info', confirmButtonColor: '#612989' });
	}

	/* ===== Modal "ข้อมูลรายการเพิ่มเติม" — หมายเหตุ/SN/เคลียร์ยืมของแถว ===== */
	var sprEditingRow = null;

	function sprOpenEditModal(button) {
		sprEditingRow = button.closest('tr');
		if (!sprEditingRow) return;

		document.getElementById('spr_modal_warranty_year').value = (sprEditingRow.querySelector('.spr-f-warranty_year') || {}).value || '';
		document.getElementById('spr_modal_remark').value = (sprEditingRow.querySelector('.spr-f-remark') || {}).value || '';
		document.getElementById('spr_modal_clear_ivno').value = (sprEditingRow.querySelector('.spr-f-clear_ivno') || {}).value || '';

		var modal = document.getElementById('spr_edit_modal');
		if (modal) modal.style.display = 'flex';
	}

	function sprCloseEditModal() {
		var modal = document.getElementById('spr_edit_modal');
		if (modal) modal.style.display = 'none';
		sprEditingRow = null;
	}

	function sprSaveEditModal() {
		if (sprEditingRow) {
			var warrantyInput = document.getElementById('spr_modal_warranty_year');
			var warrantyYear = String(warrantyInput.value || '').trim();
			if (warrantyYear === '' || !/^\d+(?:\.\d+)?$/.test(warrantyYear)) {
				sprNotify('ข้อมูลไม่ครบถ้วน', 'กรุณาระบุจำนวนปีรับประกันเป็นตัวเลข', 'warning');
				warrantyInput.focus();
				return;
			}

			var warrantyEl = sprEditingRow.querySelector('.spr-f-warranty_year');
			if (warrantyEl) warrantyEl.value = warrantyYear;
			var remarkEl = sprEditingRow.querySelector('.spr-f-remark');
			if (remarkEl) remarkEl.value = document.getElementById('spr_modal_remark').value;
			var clearBrEl = sprEditingRow.querySelector('.spr-f-clear_br');
			var clearIvnoEl = sprEditingRow.querySelector('.spr-f-clear_ivno');
			var clearIvno = document.getElementById('spr_modal_clear_ivno').value.trim();
			var isClear = clearIvno !== '';
			if (clearBrEl) clearBrEl.value = isClear ? '1' : '0';
			if (clearIvnoEl) clearIvnoEl.value = clearIvno;

		}
		sprCloseEditModal();
	}

	/** จำนวนแถวรวม — fncSubmit() ใช้ตรวจว่ามีอย่างน้อย 1 รายการ */
	function sprTotalRowCount() {
		var tbody = sprTbody();
		return tbody ? tbody.querySelectorAll('tr.spr-row').length : 0;
	}

	function sprClearAllRows() {
		var tbody = sprTbody();
		if (tbody) tbody.innerHTML = '';
		sprRefreshSummary();
		sprSyncSelectAll();
	}

	/** เพิ่มแถวจากการนำเข้าจาก modal เคลียร์ยืม (partials/spr_clear_loan_modal.php) */
	function sprAddRowFromClearLoan(item) {
		return sprAddRow({
			product_id: item.product_id,
			access_code: item.access_code,
			product_name: item.product_name,
			unit_name: item.unit_name,
			sale_count: item.count || '1',
			unit_price: item.unit_price || '0',
			warranty_year: '',
			sale_remark: '',
			sn: item.sn || '',
			clear_br: '1',
			clear_ivno: item.ref_id_br || ''
		});
	}
</script>

<div class="spr-summary-panel" aria-label="สรุปรายการสินค้า">
	<div class="spr-summary-item">
		<span class="spr-summary-label">จำนวนรวม(ชิ้น)</span>
		<strong class="spr-summary-value" id="spr_qty_total">0</strong>
	</div>
	<div class="spr-summary-divider" aria-hidden="true"></div>
	<div class="spr-summary-item">
		<span class="spr-summary-label">ยอดรวม</span>
		<strong class="spr-summary-value" id="spr_grand_total">0.00</strong>
	</div>
</div>

<div class="cs-product-toolbar-row spr-toolbar-row">
	<div class="so-field-group cs-product-search-wrap">
		<label class="so-label" for="spr_product_search">ค้นหารายการสินค้า</label>
		<div class="cs-product-search-bar">
			<i class="fas fa-search" aria-hidden="true"></i>
			<input type="text" id="spr_product_search" placeholder="ค้นหาด้วยรหัส / ชื่อสินค้า" autocomplete="off">
		</div>
	</div>
</div>

<script type="text/javascript">
	(function() {
		var sprAcInstance = new Autocomplete("spr_product_search", function() {
			this.setValue = function(accessCode) {
				if (!accessCode) return;
				sprFetchProduct(accessCode);
				document.getElementById('spr_product_search').value = '';
			};

			if (this.value.length < 1 && this.isNotClick) return;
			return 'data_product_engall.php?product_code_search=' + encodeURIComponent(this.value) +
				'&type_company=' + sprGetTypeCompany();
		}, { select_first: 0 });

		if (sprAcInstance.image && sprAcInstance.image.e) {
			sprAcInstance.image.e.style.display = 'none';
		}

		var searchInput = document.getElementById('spr_product_search');
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
</script>

<div class="so-product-table-wrap">
	<table class="so-product-table spr-product-table" id="spr_table">
		<thead>
			<tr>
				<th aria-label="ลากจัดเรียง"></th>
				<th class="spr-select-cell"><label class="so-row-checkbox-wrap" aria-label="เลือกทุกรายการ"><input type="checkbox" id="spr_select_all" class="so-row-checkbox" onchange="sprToggleAllRows(this);"><span class="so-row-checkbox-dot" aria-hidden="true"></span></label></th>
				<th>รหัสสินค้า</th>
				<th>รายการสินค้า</th>
				<th>จำนวน</th>
				<th>ราคาต่อหน่วย</th>
				<th>ยอดรวม</th>
				<th aria-label="จัดการรายการ"></th>
			</tr>
		</thead>
		<tbody id="spr_tbody"></tbody>
	</table>
</div>

<div class="breg-empty-state" id="spr_empty_state">
	ยังไม่มีรายการสินค้า — ค้นหาสินค้าจากช่องด้านบน หรือกด "เคลียร์ยืม" เพื่อนำเข้ารายการจากใบยืม
</div>

<!-- Modal ข้อมูลรายการเพิ่มเติม (รับประกัน/เลขที่ใบยืม/หมายเหตุสินค้า) -->
<div id="spr_edit_modal" class="cs-modal-overlay" style="display:none;">
	<div class="cs-modal-card spr-remark-modal-card">
		<div class="cs-modal-header">
			<h3 class="cs-modal-title">ข้อมูลรายการสินค้าเพิ่มเติม</h3>
			<button type="button" class="cs-modal-close-btn" onclick="sprCloseEditModal();" aria-label="ปิด">&times;</button>
		</div>
		<div class="cs-modal-body spr-modal-body">
			<div class="spr-modal-fields">
				<div class="so-field-group">
					<label class="so-label" for="spr_modal_warranty_year">รับประกัน(ปี)<span class="required">*</span></label>
					<div class="so-input-wrapper">
						<input type="text" id="spr_modal_warranty_year" class="so-input" placeholder="ใส่จำนวนปีรับประกัน" inputmode="decimal" autocomplete="off">
					</div>
				</div>
				<div class="so-field-group">
					<label class="so-label" for="spr_modal_clear_ivno">เลขที่ใบยืม</label>
					<div class="so-input-wrapper">
						<input type="text" id="spr_modal_clear_ivno" class="so-input" placeholder="กรอกเลขที่ใบยืม" autocomplete="off">
						<button type="button" class="fas fa-times so-clear-icon" onclick="document.getElementById('spr_modal_clear_ivno').value='';" aria-label="ล้างเลขที่ใบยืม"></button>
					</div>
				</div>
				<div class="so-field-group">
					<label class="so-label" for="spr_modal_remark">หมายเหตุสินค้า</label>
					<div class="so-input-wrapper">
						<input type="text" id="spr_modal_remark" class="so-input" placeholder="กรอกหมายเหตุสินค้า" autocomplete="off">
						<button type="button" class="fas fa-times so-clear-icon" onclick="document.getElementById('spr_modal_remark').value='';" aria-label="ล้างหมายเหตุสินค้า"></button>
					</div>
				</div>
			</div>
		</div>
		<div class="cs-modal-footer">
			<button type="button" class="cs-modal-btn-update" onclick="sprSaveEditModal();">อัพเดท</button>
			<button type="button" class="cs-modal-btn-cancel" onclick="sprCloseEditModal();">ยกเลิก</button>
		</div>
	</div>
</div>

<script type="text/javascript">
	(function sprDetachModal() {
		var modal = document.getElementById('spr_edit_modal');
		if (modal && modal.parentNode !== document.body) {
			document.body.appendChild(modal);
		}
	})();

	(function sprRestoreSavedRows() {
		SPR_SAVED_ITEMS.forEach(function(row) {
			sprAddRow(row);
		});
		sprRefreshSummary();
	})();

	/* เปลี่ยนบริษัทตอนมีรายการอยู่แล้ว — ต้องล้างรายการ เพราะ product_id ของแต่ละแถวผูกกับ
	   บริษัทเดิม (pattern เดียวกับ register_supbrhos.php) กดยกเลิก = คืนค่าบริษัทเดิม */
	(function sprBindCompanyChange() {
		var companySelect = document.getElementById('type_company_select');
		if (!companySelect) return;

		var previousCompanyValue = companySelect.value;

		companySelect.addEventListener('change', function() {
			var nextCompanyValue = companySelect.value;
			if (nextCompanyValue === previousCompanyValue) return;

			if (sprTotalRowCount() === 0) {
				previousCompanyValue = nextCompanyValue;
				return;
			}

			function applyChange() {
				sprClearAllRows();
				previousCompanyValue = nextCompanyValue;
			}

			function cancelChange() {
				companySelect.value = previousCompanyValue;
			}

			var message = 'รายการสินค้าทั้งหมด ' + sprTotalRowCount() + ' รายการจะถูกล้าง เพื่อป้องกันสินค้าข้ามบริษัท';

			if (typeof Swal === 'undefined') {
				if (confirm('เปลี่ยนบริษัท ?\n' + message)) applyChange();
				else cancelChange();
				return;
			}

			Swal.fire({
				icon: 'warning',
				title: 'เปลี่ยนบริษัท ?',
				text: message,
				showCancelButton: true,
				confirmButtonText: 'ยืนยัน',
				cancelButtonText: 'ยกเลิก',
				reverseButtons: true,
				confirmButtonColor: '#612989'
			}).then(function(result) {
				if (result.isConfirmed) applyChange();
				else cancelChange();
			});
		});
	})();
</script>
