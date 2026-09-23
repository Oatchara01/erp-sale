/* ตารางรายการสินค้าของ register_breng_brgq.php (ใบยืมตรวจเช็คสินค้า BREQ) — Figma 875:2756
 * แถวสร้างด้วย JS ล้วน (ไม่ใช่ PHP loop แบบเดิม) รับข้อมูลจาก js/breq-po-modal.js
 * เมื่อผู้ใช้กด "ตกลง" ในโมดัล PO — ดูแผน register_breng_brgq.php §5
 */
(function() {
	var breqRowSeq = 0;

	function escapeHtml(value) {
		return String(value === null || value === undefined ? '' : value).replace(/[&<>"']/g, function(ch) {
			return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' }[ch];
		});
	}

	function toNumber(value) {
		var num = Number(value);
		return isFinite(num) ? num : 0;
	}

	function tbody() {
		return document.getElementById('breq_item_tbody');
	}

	/* product_id + lot ซ้ำกับแถวที่มีอยู่แล้วหรือไม่ (มติ Q25 — กันเพิ่มซ้ำ) */
	function findDuplicateRow(productId, lot) {
		var rows = tbody() ? tbody().querySelectorAll('tr.breq-item-row') : [];
		for (var i = 0; i < rows.length; i++) {
			var pidEl = rows[i].querySelector('.breq-f-product_id');
			var lotEl = rows[i].querySelector('.breq-f-lot');
			var pid = pidEl ? pidEl.value : '';
			var rowLot = lotEl ? lotEl.value : '';
			if (String(pid) === String(productId) && String(rowLot) === String(lot)) {
				return rows[i];
			}
		}
		return null;
	}

	/* opts (ใช้ตอนโหลดเอกสารที่บันทึกไว้ผ่าน breqHydrateRows): count / br_period / sale_remark / readonly */
	function buildRowHtml(item, rowIndex, opts) {
		opts = opts || {};
		var remaining = toNumber(item.remaining);
		var price = toNumber(item.product_price);
		var defaultCount = opts.count !== undefined ? toNumber(opts.count) : (remaining > 0 ? 1 : 0);
		var sumAmount = price * defaultCount;
		var codeText = item.access_code || item.product_codesame || '';
		var disabledAttr = opts.readonly ? ' disabled' : '';

		var html = '<tr class="breq-item-row">';

		html += '<td>' +
			'<span class="cs-code-text">' + escapeHtml(codeText) + '</span>' +
			'<input type="hidden" name="check_in[' + rowIndex + ']" value="1">' +
			'<input type="hidden" name="key[' + rowIndex + ']" value="' + rowIndex + '">' +
			'<input type="hidden" name="product_id[' + rowIndex + ']" class="breq-f-product_id" value="' + escapeHtml(item.product_id) + '">' +
			'<input type="hidden" name="product_codet[' + rowIndex + ']" value="' + escapeHtml(item.product_codesame) + '">' +
			'<input type="hidden" name="product_name[' + rowIndex + ']" class="breq-f-product_name" value="' + escapeHtml(item.product_name) + '">' +
			'<input type="hidden" name="product_price[' + rowIndex + ']" class="breq-f-price" value="' + price + '">' +
			'<input type="hidden" name="sum_amount[' + rowIndex + ']" class="breq-f-sum_amount" value="' + sumAmount + '">' +
			'<input type="hidden" name="warranty[' + rowIndex + ']" value="' + escapeHtml(item.war_hc) + '">' +
			'<input type="hidden" name="lot[' + rowIndex + ']" class="breq-f-lot" value="' + escapeHtml(item.lot_no) + '">' +
			'<input type="hidden" name="sale_remarkk[' + rowIndex + ']" class="breq-f-remark" value="' + escapeHtml(opts.sale_remark) + '">' +
			'<input type="hidden" name="product_nameother[' + rowIndex + ']" class="breq-f-nameother" value="' + escapeHtml(item.product_nameother) + '">' +
			'</td>';

		html += '<td><span class="cs-product-name-text">' + escapeHtml(item.product_name) + '</span></td>';

		html += '<td><div class="cs-cell-pill">' +
			'<input type="number" name="sale_count[' + rowIndex + ']" class="so-input breq-f-count" min="1" max="' + remaining + '"' +
			' value="' + defaultCount + '" data-remaining="' + remaining + '" onchange="window.breqOnCountChange(this);"' + disabledAttr + '>' +
			'</div></td>';

		html += '<td><div class="cs-cell-pill">' +
			'<input type="text" class="so-input breq-remaining-input" value="' + remaining + '" disabled>' +
			'</div></td>';

		html += '<td><div class="cs-cell-pill">' +
			'<input type="text" name="br_period[' + rowIndex + ']" class="so-input" placeholder="ระยะเวลายืม" value="' + escapeHtml(opts.br_period) + '"' + disabledAttr + '>' +
			'</div></td>';

		html += '<td class="cs-row-actions-cell">' + (opts.readonly ? '' :
			'<button type="button" class="cs-row-edit-btn" title="แก้ไขข้อมูลเพิ่มเติม" onclick="window.breqOpenEditModal(this);"><i class="far fa-edit" aria-hidden="true"></i></button>' +
			'<button type="button" class="so-product-remove-btn" title="ลบรายการ" onclick="window.breqRemoveRow(this);"><i class="far fa-trash-alt" aria-hidden="true"></i></button>') +
			'</td>';

		html += '</tr>';
		return html;
	}

	function refreshCount() {
		var rows = tbody() ? tbody().querySelectorAll('tr.breq-item-row') : [];
		var countEl = document.getElementById('breq_item_count');
		var emptyEl = document.getElementById('breq_item_empty');
		if (countEl) countEl.textContent = rows.length + ' รายการ';
		if (emptyEl) emptyEl.style.display = rows.length === 0 ? '' : 'none';
	}

	/* ล้างตารางทั้งหมด — ใช้ตอนเปลี่ยนบริษัท เพราะ PO ที่ล็อกไว้ผูกกับบริษัทเดิม */
	window.breqClearAllItems = function() {
		if (tbody()) tbody().innerHTML = '';
		refreshCount();
	};

	/* ปลดล็อก PO ของเอกสาร (po_no/ref_id_stock ที่ breqConfirmPoModal ตั้งไว้จากแถวแรก) */
	window.breqResetPoLock = function() {
		var poNoField = document.getElementById('po_no');
		var refIdStockField = document.getElementById('ref_id_stock');
		var display = document.getElementById('breq_po_display');
		if (poNoField) poNoField.value = '';
		if (refIdStockField) refIdStockField.value = '';
		if (display) display.textContent = 'ค้นหาเอกสาร PO';
	};

	/* เพิ่มแถวใหม่จากรายการที่เลือกใน modal PO — คืน true ถ้าเพิ่มสำเร็จ, false ถ้าซ้ำ (ไม่เพิ่ม) */
	window.breqAddItemRow = function(item) {
		if (findDuplicateRow(item.product_id, item.lot_no)) {
			return false;
		}
		breqRowSeq += 1;
		if (tbody()) {
			tbody().insertAdjacentHTML('beforeend', buildRowHtml(item, breqRowSeq));
		}
		refreshCount();
		return true;
	};

	/* โหลดแถวของเอกสารที่บันทึกไว้ (Draft / Request) — items มาจาก breq_load_document() ใน includes/breq_repo.php */
	window.breqHydrateRows = function(items, readonly) {
		(items || []).forEach(function(item) {
			breqRowSeq += 1;
			if (tbody()) {
				tbody().insertAdjacentHTML('beforeend', buildRowHtml(item, breqRowSeq, {
					count: item.count,
					br_period: item.br_period,
					sale_remark: item.sale_remark,
					readonly: !!readonly
				}));
			}
		});
		refreshCount();
	};

	window.breqOnCountChange = function(input) {
		var remaining = toNumber(input.getAttribute('data-remaining'));
		var value = toNumber(input.value);
		if (value < 0) value = 0;
		if (remaining > 0 && value > remaining) value = remaining;
		input.value = value;

		var row = input.closest('tr');
		if (!row) return;
		var priceEl = row.querySelector('.breq-f-price');
		var sumEl = row.querySelector('.breq-f-sum_amount');
		if (priceEl && sumEl) {
			sumEl.value = toNumber(priceEl.value) * value;
		}
	};

	window.breqRemoveRow = function(button) {
		var row = button.closest('tr');
		if (!row) return;
		var nameEl = row.querySelector('.cs-product-name-text');
		var productName = nameEl ? nameEl.textContent.trim() : '';
		var message = productName ? 'คุณต้องการลบรายการ "' + productName + '" ใช่หรือไม่ ?' : 'คุณต้องการลบรายการนี้ใช่หรือไม่ ?';

		function doRemove() {
			row.remove();
			refreshCount();
			// ลบจนตารางว่าง = ไม่มีแถวไหนผูกกับ PO ที่ล็อกไว้แล้ว ปลดล็อกให้เลือก PO ใหม่ได้
			if (tbody() && tbody().querySelectorAll('tr.breq-item-row').length === 0) {
				window.breqResetPoLock();
			}
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
	};

	/* ===== Popup "รายการสินค้าเพิ่มเติม" (Figma 1011:4913) — ทำงานฝั่ง client ล้วน ===== */
	var breqEditingRow = null;

	window.breqOpenEditModal = function(button) {
		breqEditingRow = button.closest('tr');
		if (!breqEditingRow) return;

		var remarkEl = breqEditingRow.querySelector('.breq-f-remark');
		var nameOtherEl = breqEditingRow.querySelector('.breq-f-nameother');
		document.getElementById('breq_modal_remark').value = remarkEl ? remarkEl.value : '';
		document.getElementById('breq_modal_nameother').value = nameOtherEl ? nameOtherEl.value : '';

		var modal = document.getElementById('breq_edit_modal');
		if (modal) modal.style.display = 'flex';
	};

	window.breqCloseEditModal = function() {
		var modal = document.getElementById('breq_edit_modal');
		if (modal) modal.style.display = 'none';
		breqEditingRow = null;
	};

	window.breqSaveEditModal = function() {
		if (breqEditingRow) {
			var remarkEl = breqEditingRow.querySelector('.breq-f-remark');
			var nameOtherEl = breqEditingRow.querySelector('.breq-f-nameother');
			if (remarkEl) remarkEl.value = document.getElementById('breq_modal_remark').value;
			if (nameOtherEl) nameOtherEl.value = document.getElementById('breq_modal_nameother').value;
		}
		window.breqCloseEditModal();
	};

	document.addEventListener('DOMContentLoaded', function() {
		/* modal ต้องอยู่ระดับ body ไม่งั้น overlay จะถูก stacking context ของ .so-card ครอบ */
		var modal = document.getElementById('breq_edit_modal');
		if (modal && modal.parentNode !== document.body) {
			document.body.appendChild(modal);
		}
		refreshCount();
	});
})();
