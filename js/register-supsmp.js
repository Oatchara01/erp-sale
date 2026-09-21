/* register_supsmp.php — ใบเบิกสินค้าเพื่อสนับสนุนการขาย (SMP)
   ตารางสินค้า dynamic (products[n][...]), modal ข้อมูลเพิ่มเติม, เคลียร์ยืม, ลูกค้า/ที่อยู่, Save Draft, Preview, Submit */
(function () {
	'use strict';

	var form = document.getElementById('smp-form');
	if (!form) return;

	var busy = false;
	var rowSeq = 0;
	var popupTarget = 'customer';
	var savedFlag = /[?&]saved=1(&|$)/.test(window.location.search);
	var submittedFlag = /[?&]submitted=1(&|$)/.test(window.location.search);
	var updatedFlag = /[?&]updated=1(&|$)/.test(window.location.search);
	var isRequest = !!window.SMP_IS_REQUEST;

	/* ===================== helpers ===================== */
	function esc(value) {
		return String(value === null || value === undefined ? '' : value).replace(/[&<>"']/g, function (ch) {
			return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' }[ch];
		});
	}
	function money(value) {
		var n = Number(value || 0);
		if (!isFinite(n)) n = 0;
		return n.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
	}
	function notify(title, text, icon) {
		if (typeof Swal === 'undefined') { alert(title + (text ? '\n' + text : '')); return; }
		Swal.fire({ title: title, text: text || '', icon: icon || 'info', confirmButtonColor: '#612989', confirmButtonText: 'ตกลง' });
	}
	function el(id) { return document.getElementById(id); }
	function named(name) { return form.elements[name] || null; }
	function setValue(name, value) {
		var field = named(name);
		if (!field) return;
		if (field.length !== undefined && !field.tagName) { /* RadioNodeList */
			Array.prototype.forEach.call(field, function (r) { r.checked = (r.value === String(value)); });
			return;
		}
		if (field.type === 'checkbox') {
			field.checked = String(value) === '1';
			field.dispatchEvent(new Event('change', { bubbles: true }));
			return;
		}
		if (field.tagName === 'SELECT' && !Array.prototype.some.call(field.options, function (o) { return o.value === String(value); })) return; /* ค่าที่ไม่มีใน options คงค่าเริ่มต้นไว้ */
		field.value = value === null || value === undefined ? '' : value;
	}
	function getValue(name) {
		var field = named(name);
		if (!field) return '';
		if (field.length !== undefined && !field.tagName) return field.value || '';
		return String(field.value || '').trim();
	}

	/* บริษัทของใบ SMP: dropdown type_company 1 = AWL, 2 = NBM — endpoint ค้นหาสินค้ารับเป็นชื่อ AWL/NBM */
	function companyCode() { return getValue('type_company') === '2' ? 'NBM' : 'AWL'; }

	/* ===================== tabs ===================== */
	window.openDelTab = function (tabId, button) {
		Array.prototype.forEach.call(document.getElementsByClassName('so-del-tab-content'), function (c) { c.style.display = 'none'; });
		Array.prototype.forEach.call(button.parentElement.getElementsByClassName('so-tab-btn'), function (b) { b.classList.remove('active'); });
		el(tabId).style.display = 'block';
		button.classList.add('active');
	};
	/* สลับแท็บของ partials/doc_tabs_card.php (การ์ดแนบไฟล์) — pattern เดียวกับ brOpen3Tab ของ Change Order */
	window.smpOpenAttachTab = function (tabId, button) {
		Array.prototype.forEach.call(document.getElementsByClassName('so-3tab-content'), function (c) { c.style.display = 'none'; });
		Array.prototype.forEach.call(button.parentElement.getElementsByClassName('so-tab-btn'), function (b) { b.classList.remove('active'); });
		el(tabId).style.display = 'block';
		button.classList.add('active');
	};
	window.smpOpenAddrTab = function (tabId, button) {
		Array.prototype.forEach.call(document.getElementsByClassName('smp-addr-tab'), function (c) { c.style.display = 'none'; });
		Array.prototype.forEach.call(button.parentElement.getElementsByClassName('so-tab-btn'), function (b) { b.classList.remove('active'); });
		el(tabId).style.display = 'block';
		button.classList.add('active');
	};
	/* ===================== ช่วงเวลาจัดส่ง (พอร์ตจาก register_supchange.php: syncChgDeliveryTimeRange*) =====================
	   time_range_ui เป็น UI ล้วน (ไม่ถูกบันทึก) — เติม start_time/end_time ตาม preset; end_time เป็น hidden จึงตั้งได้จาก preset เท่านั้น */
	var TIME_RANGES = { morning: ['08:00', '12:00'], afternoon: ['13:00', '17:00'], allday: ['08:00', '17:00'] };
	function hhmm(field) { return field ? String(field.value || '').trim().substring(0, 5) : ''; }
	function presetMatching(start, end) {
		return Object.keys(TIME_RANGES).filter(function (key) { return TIME_RANGES[key][0] === start && TIME_RANGES[key][1] === end; })[0] || '';
	}
	function syncTimeRange() {
		var range = named('time_range_ui'), start = named('start_time'), end = named('end_time');
		if (!range || !start) return;
		var preset = TIME_RANGES[range.value];
		if (preset) {
			start.value = preset[0];
			if (end) end.value = preset[1];
		} else if (range.value === 'specific') {
			if (presetMatching(hhmm(start), hhmm(end))) { /* เดิมเป็นค่าของ preset — ล้างให้กรอกเอง */
				start.value = '';
				if (end) end.value = '';
			}
			start.focus();
		} else {
			start.value = '';
			if (end) end.value = '';
		}
	}
	function syncTimeRangeFromInputs() {
		var range = named('time_range_ui'), start = named('start_time'), end = named('end_time');
		if (!range || !start) return;
		var s = hhmm(start), e = hhmm(end), matched = presetMatching(s, e);
		if (!s && !e) range.value = '';
		else if (matched) range.value = matched;
		else if (s === '08:00' && !e) { if (range.value !== 'allday' && range.value !== 'morning') range.value = 'morning'; }
		else if (s === '13:00' && !e) range.value = 'afternoon';
		else range.value = 'specific';
	}
	(function () {
		var range = named('time_range_ui'), start = named('start_time');
		if (range) range.addEventListener('change', syncTimeRange);
		if (start) ['input', 'change'].forEach(function (type) { start.addEventListener(type, syncTimeRangeFromInputs); });
	})();

	/* ===================== ที่อยู่ส่งสินค้า =====================
	   ฟอร์มมีช่องเดียว (address_merged_ui เหมือน Change Order) แต่ backend และหน้า edit ยังอ่าน address_1 กับ address_name1 แยกกัน — copy ค่าให้ทั้งคู่ */
	function syncDeliveryAddress() {
		var merged = named('address_merged_ui'), first = named('address_1'), second = named('address_name1');
		if (!merged) return;
		if (first) first.value = merged.value;
		if (second) second.value = merged.value;
	}
	(function () {
		var merged = named('address_merged_ui');
		if (merged) ['input', 'change'].forEach(function (type) { merged.addEventListener(type, syncDeliveryAddress); });
	})();

	/* ตอน validate ต้องแสดงแท็บที่มีช่องที่ขาดก่อน focus */
	function revealField(field) {
		var pane = field.closest('.so-del-tab-content, .smp-addr-tab');
		if (!pane || pane.style.display !== 'none') return;
		var group = pane.classList.contains('smp-addr-tab') ? 'smp-addr-tab' : 'so-del-tab-content';
		var position = Array.prototype.indexOf.call(pane.parentElement.getElementsByClassName(group), pane);
		var tabs = pane.closest('.so-card').previousElementSibling; /* .so-tabs-container ของการ์ดนี้ */
		var buttons = tabs ? tabs.getElementsByClassName('so-tab-btn') : [];
		if (buttons[position]) buttons[position].click();
	}

	/* ===================== ตารางสินค้า ===================== */
	function tbody() { return el('smp_tbody'); }

	function buildRow(data) {
		data = data || {};
		var p = 'products[' + (rowSeq++) + ']';
		return '<tr class="so-product-row smp-row" draggable="false">' +
			'<td class="smp-drag-cell"><i class="fas fa-grip-vertical cs-drag-handle" draggable="true" title="ลากเพื่อจัดเรียง" aria-hidden="true" data-smp-drag></i></td>' +
			'<td class="smp-select-cell"><label class="so-row-checkbox-wrap" aria-label="เลือกรายการ">' +
				'<input type="checkbox" class="so-row-checkbox smp-row-selector">' +
				'<span class="so-row-checkbox-dot" aria-hidden="true"></span></label></td>' +
			'<td><span class="cs-code-text smp-cell-code">' + esc(data.access_code) + '</span>' +
				'<input type="hidden" name="' + p + '[product_id]" class="smp-f-product_id" value="' + esc(data.product_id) + '">' +
				'<input type="hidden" name="' + p + '[product_code]" value="' + esc(data.access_code) + '"></td>' +
			'<td><span class="cs-product-name-text smp-cell-name">' + esc(data.product_name) + '</span>' +
				'<input type="hidden" name="' + p + '[product_name]" value="' + esc(data.product_name) + '">' +
				'<input type="hidden" name="' + p + '[unit_name]" value="' + esc(data.unit_name) + '"></td>' +
			'<td><div class="cs-cell-pill"><input type="text" name="' + p + '[sale_count]" class="so-input smp-f-count" inputmode="decimal" style="text-align:center" value="' + esc(data.sale_count || '1') + '"></div></td>' +
			'<td><div class="cs-cell-pill"><input type="text" name="' + p + '[unit_price]" class="so-input smp-f-price" inputmode="decimal" style="text-align:right" value="' + esc(data.unit_price || '0') + '"></div></td>' +
			'<td class="smp-cell-amount" data-smp-amount>0.00</td>' +
			'<td><div class="cs-cell-pill"><input type="text" name="' + p + '[sn]" class="so-input smp-f-sn" value="' + esc(data.sn) + '" placeholder="ใส่เลข SN" autocomplete="off"></div></td>' +
			'<td class="cs-row-actions-cell">' +
				'<input type="hidden" name="' + p + '[waranty]" class="smp-f-waranty" value="' + esc(data.waranty) + '">' +
				'<input type="hidden" name="' + p + '[sale_remark]" class="smp-f-remark" value="' + esc(data.sale_remark) + '">' +
				'<input type="hidden" name="' + p + '[br_no]" class="smp-f-br_no" value="' + esc(data.br_no) + '">' +
				'<input type="hidden" name="' + p + '[clear_br]" class="smp-f-clear_br" value="' + (data.br_no || data.clear_br === '1' ? '1' : '0') + '">' +
				'<button type="button" class="cs-row-edit-btn" title="แก้ไขข้อมูลเพิ่มเติม" data-smp-edit><i class="far fa-edit" aria-hidden="true"></i></button>' +
				'<button type="button" class="so-product-remove-btn" title="ลบรายการ" data-smp-remove><i class="far fa-trash-alt" aria-hidden="true"></i></button>' +
			'</td></tr>';
	}

	function addRow(data) {
		var body = tbody();
		body.insertAdjacentHTML('beforeend', buildRow(data));
		refreshSummary();
		return body.lastElementChild;
	}

	function refreshSummary() {
		var rows = tbody().querySelectorAll('tr.smp-row');
		var qty = 0, total = 0;
		rows.forEach(function (row) {
			var count = parseFloat(String(row.querySelector('.smp-f-count').value).replace(/,/g, '')) || 0;
			var price = parseFloat(String(row.querySelector('.smp-f-price').value).replace(/,/g, '')) || 0;
			qty += count;
			total += count * price;
			row.querySelector('[data-smp-amount]').textContent = money(count * price);
		});
		el('smp_item_count').textContent = rows.length + ' รายการ';
		el('smp_qty_total').textContent = qty.toLocaleString('en-US', { maximumFractionDigits: 2 });
		el('smp_grand_total').textContent = money(total);
		el('smp_empty_state').style.display = rows.length === 0 ? '' : 'none';
		syncSelection();
	}

	/* ===================== เลือกหลายรายการ + ลบทีเดียว ===================== */
	function selectors() {
		return Array.prototype.slice.call(tbody().querySelectorAll('.smp-row-selector'));
	}
	function syncSelection() {
		var all = selectors();
		var checked = all.filter(function (input) { return input.checked; });
		var selectAll = el('smp_select_all');
		if (selectAll) {
			selectAll.checked = all.length > 0 && checked.length === all.length;
			selectAll.indeterminate = checked.length > 0 && checked.length < all.length;
		}
		el('smp_delete_selected_btn').style.display = checked.length ? 'inline-flex' : 'none';
	}
	function markRow(input) {
		var row = input.closest('tr.smp-row');
		if (row) row.classList.toggle('checked-row', !!input.checked);
	}
	window.smpToggleAllRows = function (input) {
		selectors().forEach(function (selector) {
			selector.checked = !!input.checked;
			markRow(selector);
		});
		syncSelection();
	};
	window.smpDeleteSelectedRows = function () {
		var rows = selectors().filter(function (input) { return input.checked; })
			.map(function (input) { return input.closest('tr.smp-row'); });
		if (!rows.length) return;
		confirmDelete('คุณต้องการลบรายการที่เลือก ' + rows.length + ' รายการ ใช่หรือไม่ ?', function () {
			rows.forEach(function (row) { row.remove(); });
			var selectAll = el('smp_select_all');
			if (selectAll) { selectAll.checked = false; selectAll.indeterminate = false; }
			refreshSummary();
		});
	};

	/* ===================== ลากจัดเรียง — ย้าย <tr> จริง ลำดับ POST จึงตามไปเอง ===================== */
	var draggedRow = null;
	tbody().addEventListener('dragstart', function (event) {
		var handle = event.target.closest ? event.target.closest('[data-smp-drag]') : null;
		if (!handle) return;
		draggedRow = handle.closest('tr.smp-row');
		event.dataTransfer.effectAllowed = 'move';
		try { event.dataTransfer.setData('text/plain', 'smp-row'); } catch (e) {}
		if (draggedRow) draggedRow.classList.add('dragging');
	});
	tbody().addEventListener('dragover', function (event) {
		if (!draggedRow) return;
		event.preventDefault();
		event.dataTransfer.dropEffect = 'move';
	});
	tbody().addEventListener('dragenter', function (event) {
		var row = event.target.closest ? event.target.closest('tr.smp-row') : null;
		if (row && draggedRow && row !== draggedRow) row.classList.add('drag-over');
	});
	tbody().addEventListener('dragleave', function (event) {
		var row = event.target.closest ? event.target.closest('tr.smp-row') : null;
		if (row && !row.contains(event.relatedTarget)) row.classList.remove('drag-over');
	});
	tbody().addEventListener('drop', function (event) {
		var targetRow = event.target.closest ? event.target.closest('tr.smp-row') : null;
		event.preventDefault();
		if (targetRow) targetRow.classList.remove('drag-over');
		if (!draggedRow || !targetRow || draggedRow === targetRow) return;
		var rows = Array.prototype.slice.call(targetRow.parentNode.children);
		var from = rows.indexOf(draggedRow);
		var to = rows.indexOf(targetRow);
		if (from < 0 || to < 0) return;
		targetRow.parentNode.insertBefore(draggedRow, from < to ? targetRow.nextSibling : targetRow);
	});
	tbody().addEventListener('dragend', function () {
		tbody().querySelectorAll('tr.smp-row').forEach(function (row) { row.classList.remove('dragging', 'drag-over'); });
		draggedRow = null;
	});

	tbody().addEventListener('change', function (event) {
		var target = event.target;
		if (target.classList.contains('smp-row-selector')) {
			markRow(target);
			syncSelection();
		} else if (target.classList.contains('smp-f-count')) {
			var v = parseFloat(String(target.value).replace(/[^0-9.]/g, ''));
			target.value = (isNaN(v) || v <= 0) ? '1' : String(v);
			refreshSummary();
		} else if (target.classList.contains('smp-f-price')) {
			var pv = parseFloat(String(target.value).replace(/[^0-9.]/g, ''));
			target.value = isNaN(pv) ? '0' : String(pv);
			refreshSummary();
		}
	});
	tbody().addEventListener('click', function (event) {
		var edit = event.target.closest('[data-smp-edit]');
		var remove = event.target.closest('[data-smp-remove]');
		if (edit) openEditModal(edit.closest('tr'));
		if (remove) removeRow(remove.closest('tr'));
	});

	/* ใช้ร่วมกันระหว่างถังขยะรายแถวกับปุ่มลบรายการที่เลือก ให้ dialog หน้าตาเดียวกัน */
	function confirmDelete(message, onConfirm) {
		if (typeof Swal === 'undefined') { if (confirm(message)) onConfirm(); return; }
		Swal.fire({
			icon: 'warning', title: 'ยืนยันการลบรายการ', text: message, showCancelButton: true,
			confirmButtonText: 'ยืนยันลบ', cancelButtonText: 'ยกเลิก', reverseButtons: true,
			confirmButtonColor: '#DC3545', cancelButtonColor: '#612989'
		}).then(function (r) { if (r.isConfirmed) onConfirm(); });
	}

	function removeRow(row) {
		var name = row.querySelector('.smp-cell-name').textContent.trim();
		var message = name ? 'คุณต้องการลบรายการ "' + name + '" ใช่หรือไม่ ?' : 'คุณต้องการลบรายการนี้ใช่หรือไม่ ?';
		confirmDelete(message, function () { row.remove(); refreshSummary(); });
	}

	/* ----- modal ข้อมูลรายการสินค้าเพิ่มเติม ----- */
	var editingRow = null;
	function openEditModal(row) {
		editingRow = row;
		el('smp_modal_waranty').value = row.querySelector('.smp-f-waranty').value;
		el('smp_modal_br_no').value = row.querySelector('.smp-f-br_no').value;
		el('smp_modal_remark').value = row.querySelector('.smp-f-remark').value;
		el('smp_edit_modal').style.display = 'flex';
		el('smp_modal_waranty').focus();
	}
	window.smpCloseEditModal = function () {
		el('smp_edit_modal').style.display = 'none';
		editingRow = null;
	};
	window.smpSaveEditModal = function () {
		if (!editingRow) return;
		var waranty = el('smp_modal_waranty').value.trim();
		if (!/^\d+$/.test(waranty)) {
			notify('ข้อมูลไม่ครบถ้วน', 'กรุณาระบุจำนวนปีรับประกันเป็นตัวเลข', 'warning');
			el('smp_modal_waranty').focus();
			return;
		}
		var brNo = el('smp_modal_br_no').value.trim();
		editingRow.querySelector('.smp-f-waranty').value = waranty;
		editingRow.querySelector('.smp-f-br_no').value = brNo;
		editingRow.querySelector('.smp-f-clear_br').value = brNo !== '' ? '1' : '0';
		editingRow.querySelector('.smp-f-remark').value = el('smp_modal_remark').value.trim();
		smpCloseEditModal();
	};
	el('smp_edit_modal').addEventListener('click', function (event) { if (event.target === el('smp_edit_modal')) smpCloseEditModal(); });

	/* ----- ค้นหาสินค้าแล้วเพิ่มแถว ----- */
	function warantyFrom(product) {
		var years = String(product.war_hc === undefined || product.war_hc === null ? '' : product.war_hc).trim();
		return (String(product.unit_hc || '').trim() === 'ปี' && /^\d+$/.test(years)) ? years : '0';
	}
	function fetchAndAddProduct(accessCode) {
		var request = new XMLHttpRequest();
		request.open('POST', 'data_product_hos1.php', true);
		request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		request.onreadystatechange = function () {
			if (request.readyState !== 4) return;
			var product;
			try { product = JSON.parse(request.responseText); } catch (e) { product = null; }
			if (request.status !== 200 || !product) { notify('ไม่สามารถดึงข้อมูลสินค้าได้', 'กรุณาลองใหม่อีกครั้ง', 'error'); return; }
			if (product.found === false) { notify('ไม่พบสินค้า', 'ไม่พบรหัสสินค้า "' + accessCode + '" ในระบบ', 'warning'); return; }
			var row = addRow({
				product_id: product.product_ID, access_code: accessCode, product_name: product.sol_name, unit_name: product.unit_name,
				sale_count: '1', unit_price: product.sol_price || '0', waranty: warantyFrom(product), sale_remark: '', sn: '', br_no: '', clear_br: '0'
			});
			var count = row.querySelector('.smp-f-count');
			count.focus(); count.select();
		};
		request.send('product_code=' + encodeURIComponent(accessCode) + '&type_company=' + companyCode() + '&format=json');
	}
	(function initProductSearch() {
		var input = el('smp_product_search');
		var ac = new Autocomplete('smp_product_search', function () {
			this.setValue = function (accessCode) {
				if (!accessCode) return;
				fetchAndAddProduct(accessCode);
				input.value = '';
			};
			if (this.value.length < 1 && this.isNotClick) return;
			return 'data_pro_notdemoth.php?product_code_search=' + encodeURIComponent(this.value) + '&type_company=' + companyCode();
		}, { select_first: 0 });
		if (ac.image && ac.image.e) ac.image.e.style.display = 'none';
		var instance = Autocomplete.inst[Autocomplete.inst.length - 1];
		input.addEventListener('paste', function () {
			setTimeout(function () { instance.isModified = 1; instance.isNotClick = 1; instance.isON = 1; instance.request(); }, 0);
		});
	})();

	/* ===================== เคลียร์ยืม ===================== */
	var loanDocs = [];
	var loanSelected = {};
	var loanItemMap = {};
	var loanToken = 0;

	window.smpOpenClearLoanModal = function () {
		var modal = el('smpClearLoanModal');
		modal.style.display = 'flex';
		modal.setAttribute('aria-hidden', 'false');
		loanSelected = {};
		updateLoanImportBtn();
		searchLoans(el('smpClearLoanSearch').value);
	};
	window.smpCloseClearLoanModal = function () {
		var modal = el('smpClearLoanModal');
		modal.style.display = 'none';
		modal.setAttribute('aria-hidden', 'true');
	};
	function loanState(message) {
		el('smpClearLoanRows').innerHTML = '<tr class="clear-loan-state-row"><td colspan="6">' + esc(message) + '</td></tr>';
	}
	function searchLoans(keyword) {
		var token = ++loanToken;
		loanState('กำลังค้นหา...');
		var url = 'data_clearbr_search_for_smp.php?keyword=' + encodeURIComponent(keyword || '') + '&sale_code=' + encodeURIComponent(getValue('sale_code')) + '&type_company=' + encodeURIComponent(getValue('type_company'));
		fetch(url, { credentials: 'same-origin', cache: 'no-store' })
			.then(function (res) { return res.json(); })
			.then(function (data) {
				if (token !== loanToken) return;
				if (!data || !data.success) { loanState((data && data.message) || 'ค้นหาไม่สำเร็จ'); return; }
				loanDocs = data.docs || [];
				renderLoans();
			})
			.catch(function () { if (token === loanToken) loanState('ค้นหาไม่สำเร็จ กรุณาลองใหม่'); });
	}
	function renderLoans() {
		if (!loanDocs.length) { loanState(getValue('sale_code') ? 'ไม่พบใบยืมที่ค้างเคลียร์' : 'ไม่พบใบยืมที่ค้างเคลียร์ (เลือกแผนก/เขตการขายก่อนเพื่อค้นหาใบยืมของเขตนั้น)'); return; }
		var html = '';
		loanItemMap = {};
		loanDocs.forEach(function (doc, docIndex) {
			html += '<tr><td><button type="button" class="clear-loan-expand-btn" data-smp-loan-doc="' + docIndex + '"><i class="fas fa-chevron-down" aria-hidden="true"></i></button></td><td></td>' +
				'<td>' + esc(doc.iv_no) + '</td><td>' + esc(doc.date_br) + '</td><td>' + esc(doc.customer) + '</td><td>' + doc.items.length + '</td></tr>';
			doc.items.forEach(function (item, itemIndex) {
				var key = docIndex + '|' + itemIndex;
				loanItemMap[key] = { doc: doc, item: item };
				var selectable = item.company_match !== false;
				var note = selectable ? '' : '<span class="clear-loan-item-meta smp-loan-mismatch">สินค้าของ ' + esc(item.product_company || 'บริษัทอื่น') + ' — นำเข้าใบ SMP (' + companyCode() + ') ไม่ได้</span>';
				html += '<tr class="clear-loan-subrow' + (selectable ? '' : ' smp-loan-disabled') + '" data-smp-loan-row="' + docIndex + '"><td></td>' +
					'<td><label class="clear-loan-item-option" aria-label="เลือกรายการ"><input type="checkbox" class="clear-loan-check-input"' + (selectable ? '' : ' disabled') + ' data-smp-loan-key="' + key + '"><span class="clear-loan-check-circle" aria-hidden="true"></span></label></td>' +
					'<td colspan="2">' + esc(item.product_name) + ' (' + esc(item.access_code) + ')' + note + '</td>' +
					'<td>' + esc(item.count) + ' ' + esc(item.unit_name) + '</td><td></td></tr>';
			});
		});
		el('smpClearLoanRows').innerHTML = html;
	}
	function updateLoanImportBtn() { el('smpClearLoanImportBtn').disabled = Object.keys(loanSelected).length === 0; }
	el('smpClearLoanRows').addEventListener('click', function (event) {
		var expand = event.target.closest('[data-smp-loan-doc]');
		if (!expand) return;
		var open = expand.classList.toggle('expanded');
		el('smpClearLoanRows').querySelectorAll('[data-smp-loan-row="' + expand.getAttribute('data-smp-loan-doc') + '"]').forEach(function (r) { r.classList.toggle('show', open); });
	});
	el('smpClearLoanRows').addEventListener('change', function (event) {
		var key = event.target.getAttribute('data-smp-loan-key');
		if (key === null) return;
		if (event.target.checked) loanSelected[key] = loanItemMap[key]; else delete loanSelected[key];
		updateLoanImportBtn();
	});
	/* SN ในใบยืมเก็บหลายตัวคั่นด้วยขึ้นบรรทัดใหม่ — ช่อง SN เป็น input บรรทัดเดียว จึงคั่นด้วย , แทน */
	function loanSn(value) {
		return String(value === null || value === undefined ? '' : value)
			.split(/[\r\n]+/)
			.map(function (part) { return part.trim(); })
			.filter(Boolean)
			.join(', ');
	}

	window.smpImportClearLoanSelection = function () {
		var keys = Object.keys(loanSelected);
		if (!keys.length) return;
		var ivNos = [];
		keys.forEach(function (key) {
			var entry = loanSelected[key];
			if (!entry) return;
			addRow({
				product_id: entry.item.product_id, access_code: entry.item.access_code, product_name: entry.item.product_name, unit_name: entry.item.unit_name,
				sale_count: entry.item.count || '1', unit_price: entry.item.unit_price || '0', waranty: entry.item.waranty || '0',
				sale_remark: '', sn: loanSn(entry.item.sn), br_no: entry.doc.iv_no, clear_br: '1'
			});
			if (ivNos.indexOf(entry.doc.iv_no) === -1) ivNos.push(entry.doc.iv_no);
		});
		var current = getValue('brnp_no');
		var merged = current ? current.split(/\s*,\s*/).filter(Boolean) : [];
		ivNos.forEach(function (no) { if (merged.indexOf(no) === -1) merged.push(no); });
		setValue('brnp_no', merged.join(', '));
		setValue('brnp_ckk', '1');
		smpCloseClearLoanModal();
		notify('นำเข้ารายการเรียบร้อย', 'นำเข้า ' + keys.length + ' รายการจากใบยืมที่เลือกแล้ว', 'success');
	};
	(function () {
		var timer = null, box = el('smpClearLoanSearch');
		box.addEventListener('input', function () { clearTimeout(timer); timer = setTimeout(function () { searchLoans(box.value); }, 300); });
		var modal = el('smpClearLoanModal');
		modal.addEventListener('click', function (event) { if (event.target === modal) smpCloseClearLoanModal(); });
		document.body.appendChild(modal);
		document.body.appendChild(el('smp_edit_modal'));
	})();

	/* ===================== แลกสินค้า CRM ===================== */
	/* เปิด CRM = ช่องเลขที่อ้างอิงใช้งานได้และเป็น required; ปิด = ล้างค่าและปิดช่อง (server ก็ล้าง crm_ref ให้ซ้ำอีกชั้น) */
	(function () {
		var toggle = el('crm_ckk'), ref = el('crm_ref'), star = el('crm_ref_required');
		function sync() {
			var on = toggle.checked;
			ref.disabled = !on;
			ref.required = on;
			ref.setAttribute('aria-required', on ? 'true' : 'false');
			star.hidden = !on;
			if (!on) { ref.value = ''; ref.classList.remove('is-invalid'); }
		}
		toggle.addEventListener('change', function () { sync(); if (toggle.checked && document.activeElement === toggle) ref.focus(); });
		ref.addEventListener('input', function () { ref.classList.remove('is-invalid'); });
		sync();
	})();

	/* ===================== ลูกค้า / ที่อยู่ ===================== */
	function setText(id, value) { var node = el(id); if (node) node.textContent = value === null || value === undefined ? '' : value; }
	function setCredit(value) {
		var raw = String(value === null || value === undefined ? '' : value).trim();
		el('credit_thb').value = raw.replace(/,/g, '');
		var number = Number(raw.replace(/,/g, ''));
		setText('display_credit_thb', raw !== '' && !isNaN(number) ? money(number) : raw);
		var trigger = el('display_credit_thb_trigger');
		trigger.classList.toggle('is-empty', raw === '');
		trigger.disabled = raw === '';
		trigger.setAttribute('aria-disabled', raw === '' ? 'true' : 'false');
	}
	function fillCustomerCard(c) {
		var id = String(c.customer_id || '').trim();
		setValue('customer_id', id);
		el('bill_id').value = id;
		el('h_bill_id').value = id;
		setText('display_customer_id', id);
		setText('display_customer_name', c.customer_name || c.bill_name);
		setText('display_customer_tel', c.cus_tel || c.bill_tel);
		setText('display_customer_typename', c.type_name);
		setText('display_mode_name', c.status_cus);
		el('display_vip_icon').style.display = String(c.vip_ckk) === '1' ? '' : 'none';
		setCredit(c.credit_thb);
	}
	/* เลือก option ของ select ตามชื่อ (value หรือข้อความตรงกัน) — ไม่พบคงค่าเดิมไว้ */
	function selectByText(select, wanted) {
		if (!select) return;
		wanted = String(wanted || '').trim();
		Array.prototype.forEach.call(select.options, function (o) { if (o.value === wanted || o.text === wanted) select.value = o.value; });
	}
	/* รหัสไปรษณีย์ลูกค้า: รับเฉพาะตัวเลข */
	(function () {
		var postcode = named('cus_postcode');
		if (!postcode) return;
		postcode.addEventListener('input', function () {
			var digits = postcode.value.replace(/\D/g, '');
			if (digits !== postcode.value) postcode.value = digits;
		});
	})();
	window.smpOpenCustomerPopup = function (target) {
		popupTarget = target === 'address' ? 'address' : 'customer';
		openCustomerPopup();
	};
	window.customerPopupOnConfirm = function (c) {
		c = c || {};
		var id = String(c.customer_id || '').trim();
		if (popupTarget === 'customer') {
			fillCustomerCard(c);
			setValue('customer_name', c.customer_name || c.bill_name || '');
			setValue('cus_tel', c.cus_tel || c.bill_tel || '');
			setValue('customer_typename', c.type_name || '');
			setValue('address_name', c.cus_address || '');
			setValue('cus_ampher', c.cus_ampher || '');
			setValue('cus_postcode', c.cus_postcode || '');
			var cusProvince = named('cus_province');
			cusProvince.value = ''; /* จังหวัดที่ไม่ตรงกับ option ต้องไม่ค้างค่าของลูกค้าคนก่อน */
			selectByText(cusProvince, c.cus_province);
		}
		var request = new XMLHttpRequest();
		request.open('POST', 'data_rental_name.php', true);
		request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		request.onreadystatechange = function () {
			if (request.readyState !== 4 || request.status !== 200 || request.responseText === '') return;
			var parts = request.responseText.split('|');
			if (popupTarget === 'customer' && !getValue('address_name')) setValue('address_name', parts[8] || '');
			setValue('customer_name1', parts[11] || parts[1] || '');
			setValue('customer_tel', parts[12] || parts[2] || '');
			setValue('address_merged_ui', parts[14] || '');
			syncDeliveryAddress();
			selectByText(named('province_name'), parts[15]);
		};
		request.send('rental_id=' + encodeURIComponent(id));
	};

	/* ===================== ไฟล์แนบ ===================== */
	var allowedExt = ['jpg', 'jpeg', 'png', 'pdf'];
	function checkFiles() {
		var inputs = form.querySelectorAll('input[type="file"][name^="up_img"]');
		for (var i = 0; i < inputs.length; i++) {
			var file = inputs[i].files && inputs[i].files[0];
			if (!file) continue;
			var ext = file.name.split('.').pop().toLowerCase();
			if (allowedExt.indexOf(ext) === -1) return 'ไฟล์แนบช่องที่ ' + (i + 1) + ': รองรับเฉพาะไฟล์ JPG, PNG หรือ PDF';
			if (file.size > 1048576) return 'ไฟล์แนบช่องที่ ' + (i + 1) + ': ขนาดไฟล์เกิน 1MB';
		}
		return '';
	}

	/* ===================== validate / submit / draft / preview ===================== */
	var requiredFields = [
		['sale_code', 'กรุณาเลือกแผนก/เขตการขาย'],
		['smp_date', 'กรุณาระบุวันที่เอกสาร'],
		['customer_name', 'กรุณาใส่ชื่อลูกค้า'],
		['cus_tel', 'กรุณาใส่เบอร์โทรศัพท์ลูกค้า'],
		['address_name', 'กรุณาใส่ที่อยู่ลูกค้า'],
		['cus_province', 'กรุณาเลือกจังหวัดลูกค้า'],
		['cus_ampher', 'กรุณาใส่เขต/อำเภอลูกค้า'],
		['cus_postcode', 'กรุณาใส่รหัสไปรษณีย์ลูกค้า']
	];
	var requiredDelivery = [
		['start_time', 'กรุณาใส่เวลาส่ง'],
		['customer_name1', 'กรุณาใส่ชื่อผู้ติดต่อ'],
		['customer_tel', 'กรุณาใส่เบอร์โทรลูกค้า'],
		['address_merged_ui', 'กรุณาใส่ที่อยู่ในการส่งสินค้า'], /* ช่องที่เห็น — address_1/address_name1 เป็น hidden ที่ copy ค่าไป (focus ไม่ได้) */
		['address_send', 'กรุณาใส่สถานที่ติดตั้งเครื่อง'],
		['province_name', 'กรุณาเลือกจังหวัดที่ต้องการจัดส่ง']
	];
	function fail(message, field) {
		if (field) { revealField(field); }
		notify('ข้อมูลไม่ครบถ้วน', message, 'warning');
		if (field) { field.focus(); if (field.scrollIntoView) field.scrollIntoView({ behavior: 'smooth', block: 'center' }); }
		return false;
	}
	function validateSubmit() {
		for (var i = 0; i < requiredFields.length; i++) {
			if (getValue(requiredFields[i][0]) === '') return fail(requiredFields[i][1], named(requiredFields[i][0]));
		}
		if (!/^\d{5}$/.test(getValue('cus_postcode'))) return fail('รหัสไปรษณีย์ต้องเป็นตัวเลข 5 หลัก', named('cus_postcode'));
		if (el('crm_ckk').checked && getValue('crm_ref') === '') {
			el('crm_ref').classList.add('is-invalid');
			return fail('กรุณาระบุเลขที่อ้างอิง (CRM) เมื่อเลือกแลกสินค้า CRM', el('crm_ref'));
		}
		var rows = tbody().querySelectorAll('tr.smp-row');
		if (rows.length === 0) return fail('กรุณาเพิ่มรายการสินค้าอย่างน้อย 1 รายการ', el('smp_product_search'));
		for (var r = 0; r < rows.length; r++) {
			if (!/^\d+$/.test(rows[r].querySelector('.smp-f-waranty').value)) {
				openEditModal(rows[r]);
				notify('ข้อมูลไม่ครบถ้วน', 'รายการที่ ' + (r + 1) + ': กรุณาระบุจำนวนปีรับประกัน', 'warning');
				return false;
			}
		}
		for (var d = 0; d < requiredDelivery.length; d++) {
			if (getValue(requiredDelivery[d][0]) === '') return fail(requiredDelivery[d][1], named(requiredDelivery[d][0]));
		}
		var fileProblem = checkFiles();
		if (fileProblem) return fail(fileProblem, null);
		return true;
	}
	function setBusy(on, button, busyHtml) {
		busy = on;
		['smp_btn_draft', 'smp_btn_submit'].forEach(function (id) { if (el(id)) el(id).disabled = on; });
		if (button) {
			if (on) { button.setAttribute('data-html', button.innerHTML); button.innerHTML = busyHtml; }
			else if (button.getAttribute('data-html')) button.innerHTML = button.getAttribute('data-html');
		}
	}
	window.smpSubmit = function () {
		if (busy || !validateSubmit()) return;
		var button = isRequest ? el('smp_btn_draft') : el('smp_btn_submit');
		var send = function () {
			setBusy(true, button, '<i class="fas fa-spinner fa-spin"></i> กำลังบันทึก...');
			HTMLFormElement.prototype.submit.call(form);
		};
		if (isRequest) { send(); return; } /* Update ไม่ต้องยืนยัน */
		if (typeof Swal === 'undefined') { if (confirm('ยืนยันการส่งใบเบิกสินค้า (SMP) ใช่หรือไม่?')) send(); return; }
		Swal.fire({
			icon: 'question', title: 'ยืนยันการส่งใบเบิกสินค้า', text: 'ต้องการบันทึกและส่งเอกสารนี้ใช่หรือไม่?', showCancelButton: true,
			confirmButtonText: 'ยืนยัน', cancelButtonText: 'ยกเลิก', reverseButtons: true,
			confirmButtonColor: '#612989', cancelButtonColor: '#6c757d'
		}).then(function (r) { if (r.isConfirmed) send(); });
	};
	/* Update เอกสารที่ถูกส่งกลับ — validate เต็ม คงสถานะ Returned (Submit ปกติจึงเป็นทางเดียวที่ส่งกลับเข้า Request) */
	window.smpUpdateReturned = function () {
		if (busy || !validateSubmit()) return;
		setBusy(true, el('smp_btn_draft'), '<i class="fas fa-spinner fa-spin"></i> กำลังบันทึก...');
		form.action = 'register_supsmp_update1.php';
		HTMLFormElement.prototype.submit.call(form);
	};
	/* ===================== แถบอนุมัติ (approver) ===================== */
	function openReasonPopup(opts) {
		var refInput = el('ref_idsmp');
		var refId = refInput ? refInput.value.trim() : '';
		if (typeof Swal === 'undefined') {
			var fallback = (window.prompt(opts.label) || '').trim();
			if (fallback !== '') opts.onConfirm(fallback);
			return;
		}
		Swal.fire({
			title: opts.title,
			html: '<p class="so-reason-subtitle">' + esc(opts.subtitleText) + ' "' + esc(refId) + '"</p>' +
				'<label class="so-reason-label">' + esc(opts.label) + '<span class="so-reason-required">*</span></label>',
			input: 'textarea',
			inputPlaceholder: opts.placeholder || '',
			iconHtml: '<div class="so-reason-icon-circle" style="background:' + opts.iconBg + '"><img src="' + opts.iconSrc + '" alt="" style="width: 36px; height: 36px;"></div>',
			showCancelButton: true, showCloseButton: true, reverseButtons: false,
			confirmButtonText: 'ตกลง', cancelButtonText: 'ยกเลิก', buttonsStyling: false,
			customClass: {
				popup: 'figma-delete-popup so-reason-popup', title: 'figma-delete-title so-reason-title',
				htmlContainer: 'figma-delete-html so-reason-html', confirmButton: 'figma-delete-confirm-btn so-reason-confirm-btn',
				cancelButton: 'figma-delete-cancel-btn so-reason-cancel-btn', actions: 'figma-delete-actions so-reason-actions',
				icon: 'figma-delete-icon so-reason-icon', input: 'so-reason-textarea', closeButton: 'so-reason-close-btn'
			},
			preConfirm: function (value) {
				var trimmed = (value || '').trim();
				if (trimmed === '') { Swal.showValidationMessage('กรุณาระบุเหตุผล'); return false; }
				return trimmed;
			}
		}).then(function (result) { if (result.isConfirmed) opts.onConfirm(result.value); });
	}
	window.smpToggleApproveOverflowMenu = function () {
		var menu = el('smpApproveOverflowMenu');
		if (menu) menu.style.display = (menu.style.display === 'none' || !menu.style.display) ? 'block' : 'none';
	};
	document.addEventListener('click', function (e) {
		var menu = el('smpApproveOverflowMenu'), trigger = el('smp_btn_approve_overflow');
		if (!menu || !menu.style.display || menu.style.display === 'none') return;
		if (trigger && (e.target === trigger || trigger.contains(e.target))) return;
		if (!menu.contains(e.target)) menu.style.display = 'none';
	});
	/* ===== ส่งกลับ / ไม่อนุมัติ / ยกเลิก / อนุมัติ — ทุก action ไป register_supsmp_action1.php (สิทธิ์ตรวจซ้ำที่ server) ===== */
	var approveReasonConfig = {
		'return': {
			title: 'ส่งกลับเอกสารนี้ ?', subtitleText: 'ส่งกลับเอกสารเลขที่', label: 'ระบุเหตุผลการส่งกลับ',
			placeholder: 'ระบุเหตุผลการส่งกลับ', iconBg: '#FFF4E5', iconSrc: 'img/icons/send_back.png'
		},
		'reject': {
			title: 'ไม่อนุมัติเอกสารนี้ ?', subtitleText: 'ไม่อนุมัติเอกสารเลขที่', label: 'ระบุเหตุผลที่ไม่อนุมัติ',
			placeholder: 'ระบุเหตุผลที่ไม่อนุมัติ', iconBg: '#FEECEB', iconSrc: 'img/icons/reject.png'
		}
	};
	/* ค่า action มากับ hidden (ไม่ใช่ value ของปุ่ม) เพราะส่งด้วย form.submit() แบบ programmatic — endpoint ไม่บันทึกค่าฟอร์มใด ๆ */
	function submitApproveAction(action, reason, isCancel) {
		busy = true;
		el('smp_approve_action').value = isCancel ? '' : action;
		el('smp_approve_reason').value = reason;
		el('smp_cancel_doc').value = isCancel ? '1' : '';
		form.action = 'register_supsmp_action1.php';
		HTMLFormElement.prototype.submit.call(form);
	}
	/* ส่งกลับ / ไม่อนุมัติ — บังคับกรอกเหตุผล ข้าม validation ฟอร์ม */
	window.smpRunApproveAction = function (action) {
		var config = approveReasonConfig[action];
		if (busy || !config) return;
		openReasonPopup(Object.assign({}, config, {
			onConfirm: function (reason) {
				if (busy) return;
				submitApproveAction(action, reason, false);
			}
		}));
	};
	/* ยกเลิกเอกสาร — ผู้อนุมัติด่าน sup (ใบ Request) หรือเจ้าของใบ Draft/Returned (server ตรวจซ้ำ) */
	window.smpTriggerCancelDoc = function () {
		if (busy) return;
		openReasonPopup({
			title: 'ยกเลิกเอกสารนี้ ?', subtitleText: 'ต้องการยกเลิกเอกสารเลขที่', label: 'ระบุเหตุผลในการยกเลิก',
			placeholder: 'ระบุเหตุผลในการยกเลิก', iconBg: '#F4F5F7', iconSrc: 'img/icons/cancel_document.png',
			onConfirm: function (reason) {
				if (busy) return;
				submitApproveAction('cancel', reason, true);
			}
		});
	};
	/* ภาพรวมค่าในฟอร์ม (ไม่รวม hidden ของ action) — ใช้ตรวจว่าผู้อนุมัติแก้ค้างโดยยังไม่ได้ Update */
	var formSnapshot = '';
	var userTouchedForm = false;
	function snapshotForm() {
		var skip = { approve_action: 1, smp_approve_reason: 1, smp_cancel_doc: 1 };
		var parts = [];
		Array.prototype.forEach.call(form.elements, function (field) {
			var type = (field.type || '').toLowerCase();
			if (!field.name || field.disabled || skip[field.name] || type === 'button' || type === 'submit' || type === 'reset') return;
			if (type === 'file') {
				if (field.files && field.files.length) parts.push(field.name + '=file:' + field.files[0].name + ':' + field.files[0].size);
				return;
			}
			if ((type === 'checkbox' || type === 'radio') && !field.checked) return;
			parts.push(field.name + '=' + field.value);
		});
		return parts.join('');
	}
	/* อนุมัติ — ต่างจาก 3 action ข้างบนตรงที่ต้องผ่าน validation ฟอร์มตามปกติ และ endpoint ตัดสินจากข้อมูลที่บันทึกไว้
	   (ทั้งเช็คยอดใบยืมและเส้นทางส่งต่อ) จึงบล็อกถ้ามีการแก้ไขที่ยังไม่ได้กด Update */
	window.smpApproveDocument = function () {
		if (busy) return;
		if (snapshotForm() !== formSnapshot) {
			notify('มีการแก้ไขที่ยังไม่ได้บันทึก', 'กรุณากด Update เพื่อบันทึกการแก้ไขก่อนอนุมัติ เพราะระบบอนุมัติตามข้อมูลที่บันทึกไว้แล้ว', 'warning');
			return;
		}
		if (!validateSubmit()) return;
		submitApproveAction('approve', '', false);
	};
	window.smpSaveDraft = function () {
		if (busy) return;
		var fileProblem = checkFiles();
		if (fileProblem) { notify('แนบไฟล์ไม่ได้', fileProblem, 'warning'); return; }
		var button = el('smp_btn_draft');
		setBusy(true, button, '<i class="fas fa-spinner fa-spin"></i> Saving...');
		fetch('register_supsmp_draft1.php', { method: 'POST', body: new FormData(form), credentials: 'same-origin' })
			.then(function (res) { return res.json(); })
			.then(function (data) {
				if (data && data.success) {
					var target = 'register_supsmp.php?ref_idsmp=' + encodeURIComponent(data.ref_id) + '&saved=1';
					if (typeof Swal === 'undefined') { alert('บันทึกแบบร่างเรียบร้อยแล้ว (เลขที่ ' + data.ref_id + ')'); window.location.href = target; return; }
					Swal.fire({ title: 'บันทึกแบบร่างเรียบร้อยแล้ว', text: 'เลขที่อ้างอิง: ' + data.ref_id, icon: 'success', confirmButtonColor: '#612989' })
						.then(function () { window.location.href = target; });
					return;
				}
				setBusy(false, button);
				notify('บันทึกไม่สำเร็จ', (data && data.message) || 'เกิดข้อผิดพลาดในการบันทึก', 'error');
			})
			.catch(function (err) { setBusy(false, button); notify('บันทึกไม่สำเร็จ', String(err), 'error'); });
	};
	/* Preview — POST ค่าปัจจุบันทั้งฟอร์มไป report_sample.php แบบ _report_preview=1 (ไม่แตะฐานข้อมูล ไม่จองเลข) */
	window.smpOpenPreview = function () {
		/* เปิดดูอย่างเดียว: ช่องฟอร์มถูกล็อก (disabled ไม่ถูกส่ง) จึงเปิดรายงานของใบที่บันทึกไว้แทนการ POST ค่าในฟอร์ม */
		if (window.SMP_READ_ONLY) {
			var savedRef = getValue('ref_idsmp');
			if (savedRef) window.open('report_sample.php?ref_idsmp=' + encodeURIComponent(savedRef), '_blank', 'noopener,noreferrer');
			return;
		}
		var target = 'smp_preview_' + Date.now();
		var win = window.open('', target);
		if (!win) { notify('เปิด Preview ไม่ได้', 'เบราว์เซอร์บล็อกหน้าต่างใหม่ กรุณาอนุญาต Pop-up แล้วลองอีกครั้ง', 'warning'); return; }
		var flag = document.createElement('input');
		flag.type = 'hidden'; flag.name = '_report_preview'; flag.value = '1';
		form.appendChild(flag);
		var original = { action: form.getAttribute('action'), method: form.getAttribute('method'), target: form.getAttribute('target'), enctype: form.getAttribute('enctype') };
		form.action = 'report_sample.php'; form.method = 'post'; form.target = target; form.enctype = 'application/x-www-form-urlencoded';
		HTMLFormElement.prototype.submit.call(form);
		Object.keys(original).forEach(function (attr) {
			if (original[attr] === null) form.removeAttribute(attr); else form.setAttribute(attr, original[attr]);
		});
		flag.remove();
	};
	form.addEventListener('submit', function (event) { event.preventDefault(); smpSubmit(); });

	/* ===================== เติมข้อมูล Draft กลับเข้าฟอร์ม ===================== */
	Object.keys(window.SMP_PREFILL || {}).forEach(function (name) { setValue(name, window.SMP_PREFILL[name]); });
	syncTimeRangeFromInputs(); /* setValue ไม่ยิง event ให้ช่อง time — ซิงก์ dropdown ช่วงเวลากับเวลาที่โหลดจาก Draft เอง */
	syncDeliveryAddress(); /* hidden address_1/address_name1 ต้องตรงกับช่องที่แสดง แม้ Draft เก่าสองค่าจะไม่ตรงกัน */
	if (window.SMP_SAVED_CUSTOMER) fillCustomerCard(window.SMP_SAVED_CUSTOMER);
	else if (window.SMP_PREFILL && window.SMP_PREFILL.customer_typename) setText('display_customer_typename', window.SMP_PREFILL.customer_typename);
	(window.SMP_SAVED_ITEMS || []).forEach(function (item) { addRow(item); });
	refreshSummary();
	formSnapshot = snapshotForm();
	/* เผื่อค่าบางช่องถูกเติมหลังโหลด (เช่น ข้อมูลลูกค้า) — ถ้าผู้ใช้ยังไม่แตะฟอร์ม ให้ถ่ายภาพรวมใหม่ตอนโหลดเสร็จ */
	form.addEventListener('input', function () { userTouchedForm = true; });
	form.addEventListener('change', function () { userTouchedForm = true; });
	window.addEventListener('load', function () { if (!userTouchedForm) formSnapshot = snapshotForm(); });

	/* สลับบริษัท: สินค้าคนละบริษัทปนกันไม่ได้ — ถ้ามีรายการอยู่ให้ยืนยันก่อนแล้วล้างทั้งตาราง (ผูกหลัง prefill เพื่อไม่ให้ Draft เด้งถามตอนโหลด) */
	var companySelect = named('type_company');
	var lastCompany = companySelect.value;
	companySelect.addEventListener('change', function () {
		var next = companySelect.value;
		if (tbody().querySelectorAll('tr.smp-row').length === 0) { lastCompany = next; return; }
		var applySwitch = function () {
			tbody().innerHTML = '';
			setValue('brnp_no', '');
			setValue('brnp_ckk', '0');
			lastCompany = next;
			refreshSummary();
		};
		var revert = function () { companySelect.value = lastCompany; };
		var label = next === '2' ? 'NBM' : 'AWL';
		if (typeof Swal === 'undefined') { if (confirm('เปลี่ยนเป็น ' + label + ' รายการสินค้าทั้งหมดจะถูกล้าง ต้องการดำเนินการต่อหรือไม่?')) applySwitch(); else revert(); return; }
		Swal.fire({
			title: 'เปลี่ยนบริษัทเป็น ' + label + ' ?', text: 'รายการสินค้าที่เลือกไว้ทั้งหมดจะถูกล้าง เพราะสินค้าของแต่ละบริษัทปนกันไม่ได้', icon: 'warning',
			showCancelButton: true, confirmButtonColor: '#612989', confirmButtonText: 'ล้างรายการและเปลี่ยน', cancelButtonText: 'ยกเลิก'
		}).then(function (result) { if (result.isConfirmed) applySwitch(); else revert(); });
	});

	if (submittedFlag || updatedFlag) notify('บันทึกข้อมูลเรียบร้อยแล้ว', 'ระบบแสดงข้อมูลที่บันทึกไว้ในหน้านี้แล้ว', 'success');
	else if (savedFlag) notify('บันทึกแบบร่างเรียบร้อยแล้ว', 'เปิดแบบร่างเดิมเพื่อแก้ไขต่อได้ที่หน้านี้', 'success');
})();
