/* หน้า register_receive.php (ใบคืนสินค้า) — ต้องโหลดหลัง js/so-required-fields.js และ SweetAlert2
 * ค่าตั้งต้นมาจาก window.rcPageConfig (mode, receiveRef, readOnly, noPrice)
 * บันทึกทุกปุ่มผ่าน register_receive1.php (rc_action = draft | submit | cancel)
 * ตัวบันทึกฝั่งเซิร์ฟเวอร์คำนวณยอดค้างและตรวจใหม่ทั้งหมด — ที่นี่ตรวจเพื่อให้ผู้ใช้เห็นก่อนเท่านั้น
 */
(function() {
	'use strict';

	var config = window.rcPageConfig || {};
	var busy = false; // กันกดซ้ำระหว่างรอบันทึก
	var dirty = false; // มีการแก้ไขที่ยังไม่ได้บันทึก

	/* เวลาเริ่มจัดส่งของแต่ละช่วง (กฎเดียวกับ DELIVERY_TIME_RANGE_PRESETS ใน js/delivery-transport.js ส่วนเวลาเริ่ม) */
	var TIME_RANGE_PRESETS = {
		morning: '08:00',
		afternoon: '13:00',
		allday: '08:00'
	};

	function byId(id) {
		return document.getElementById(id);
	}

	function all(selector, root) {
		return Array.prototype.slice.call((root || document).querySelectorAll(selector));
	}

	function notify(title, text, icon) {
		if (typeof Swal === 'undefined') {
			alert(title + (text ? '\n' + text : ''));
			return Promise.resolve();
		}
		return Swal.fire({
			title: title,
			text: text || '',
			icon: icon || 'info',
			confirmButtonColor: '#612989',
			confirmButtonText: 'ตกลง'
		});
	}

	function confirmDialog(title, text, confirmText) {
		if (typeof Swal === 'undefined') {
			return Promise.resolve(window.confirm(title + '\n' + text));
		}
		return Swal.fire({
			title: title,
			text: text,
			icon: 'question',
			showCancelButton: true,
			confirmButtonText: confirmText,
			cancelButtonText: 'ยกเลิก',
			confirmButtonColor: '#612989',
			reverseButtons: true,
			focusCancel: true
		}).then(function(result) { return !!result.isConfirmed; });
	}

	function formatNumber(value, digits) {
		var number = Number(value || 0);
		if (!isFinite(number)) number = 0;
		return number.toLocaleString('en-US', { minimumFractionDigits: digits, maximumFractionDigits: digits });
	}

	/* จำนวนเต็มบวกเท่านั้น — null เมื่อไม่ใช่ (รูปแบบเดียวกับ rc_choose_lines ฝั่ง server) */
	function parseQty(raw) {
		var text = String(raw === undefined || raw === null ? '' : raw).replace(/,/g, '').trim();
		return /^\d+$/.test(text) ? parseInt(text, 10) : null;
	}

	function markDirty() {
		dirty = true;
	}

	/* ===================== แถวสินค้า ===================== */
	function itemRows() {
		return all('#rc_items_body tr.rc-row');
	}

	function detailRowOf(row) {
		var next = row.nextElementSibling;
		return (next && next.classList.contains('rc-detail-row')) ? next : null;
	}

	function rowIsPlain(row) {
		return !row.classList.contains('rc-row-sn');
	}

	function rowQtyInput(row) {
		return row.querySelector('.rc-qty');
	}

	/* ยอดรายแถวและสรุปบนการ์ดนับทุกแถวที่ยังแสดงบนจอ (ไม่ว่าติ๊กหรือไม่ — แถวที่กดถังขยะออกแล้วไม่นับ)
	   ช่องติ๊กมีผลแค่ว่าแถวไหนถูกบันทึกเป็นการคืน */
	function refreshSummary() {
		var totalQty = 0;
		var totalAmount = 0;
		var pickedRows = 0;

		itemRows().forEach(function(row) {
			var price = parseFloat(row.getAttribute('data-price')) || 0;
			var qty = 0;
			var picked = false;

			if (rowIsPlain(row)) {
				var check = row.querySelector('.rc-pick');
				var input = rowQtyInput(row);
				picked = !!(check && check.checked);
				if (input) input.disabled = !picked || !!config.readOnly;
				var parsed = input ? parseQty(input.value) : null;
				qty = parsed || 0;
			} else {
				var detail = detailRowOf(row);
				var snChecks = detail ? all('.rc-pick-sn', detail) : [];
				var count = snChecks.filter(function(c) { return c.checked; }).length;
				qty = snChecks.length;
				picked = count > 0;
				var group = row.querySelector('.rc-pick-group');
				if (group) {
					group.checked = snChecks.length > 0 && count === snChecks.length;
					group.indeterminate = count > 0 && count < snChecks.length;
				}
				var countLabel = row.querySelector('.rc-sn-count');
				if (countLabel) countLabel.textContent = String(snChecks.length);
			}

			var amount = qty * price;
			var totalCell = row.querySelector('.rc-line-total');
			if (totalCell) totalCell.textContent = config.noPrice ? '-' : formatNumber(amount, 2);
			row.classList.toggle('is-selected', picked);
			pickedRows++;
			totalQty += qty;
			totalAmount += amount;
		});

		byId('rc_total_qty').textContent = formatNumber(totalQty, 0);
		// ใบคืนจากฟอร์มเดิมไม่มีราคา (ไม่รู้เอกสารต้นทาง) — แสดงขีดแทน 0.00
		byId('rc_total_amount').textContent = config.noPrice ? '-' : formatNumber(totalAmount, 2);
		byId('rc_items_count').textContent = pickedRows + ' รายการ';

		var checkAll = byId('rc_check_all');
		var rows = itemRows();
		var pickedNow = rows.filter(function(row) { return row.classList.contains('is-selected'); }).length;
		checkAll.checked = rows.length > 0 && pickedNow === rows.length;
		checkAll.indeterminate = pickedNow > 0 && pickedNow < rows.length;
		updateEmptyState();
	}

	/* ไม่มีแถวเหลือ (ลบหมด) หรือค้นหาแล้วไม่พบ */
	function updateEmptyState() {
		var rows = itemRows();
		var visible = rows.filter(function(row) { return !row.hidden; }).length;
		var empty = byId('rc_items_empty');
		empty.textContent = rows.length === 0 ? 'ไม่มีรายการสินค้า' : 'ไม่พบรายการที่ค้นหา';
		empty.hidden = visible > 0;
	}

	function setRowPicked(row, picked) {
		if (rowIsPlain(row)) {
			var check = row.querySelector('.rc-pick');
			if (check) check.checked = picked;
		} else {
			var detail = detailRowOf(row);
			if (detail) all('.rc-pick-sn', detail).forEach(function(c) { c.checked = picked; });
		}
	}

	function toggleDetail(button) {
		var row = button.closest('tr');
		var detail = detailRowOf(row);
		if (!detail) return;
		var open = detail.hidden;
		detail.hidden = !open;
		row.classList.toggle('is-open', open);
		button.setAttribute('aria-expanded', open ? 'true' : 'false');
	}

	/* ช่องจำนวน: ห้ามเกินยอดค้าง (ตัวบันทึกตรวจซ้ำอีกชั้น) ช่องว่าง/ไม่ใช่ตัวเลขคืนเป็นค่าสูงสุด */
	function clampQty(input) {
		var max = parseQty(input.getAttribute('data-max')) || 0;
		var value = parseQty(input.value);
		if (value === null || value < 1) value = max;
		if (value > max) value = max;
		input.value = String(value);
	}

	function filterRows(keyword) {
		var needle = String(keyword || '').trim().toLowerCase();
		var visible = 0;
		itemRows().forEach(function(row) {
			var show = needle === '' || (row.getAttribute('data-search') || '').indexOf(needle) !== -1;
			row.hidden = !show;
			var detail = detailRowOf(row);
			if (detail) detail.style.display = show ? '' : 'none';
			if (show) visible++;
		});
		updateEmptyState();
	}

	/* ===================== เรียงลำดับ (ลากที่จุดจับ หรือลูกศรขึ้น/ลงบนจุดจับ) และลบแถว ===================== */
	var draggingRow = null;

	function mainRowOf(tr) {
		if (!tr) return null;
		return tr.classList.contains('rc-detail-row') ? tr.previousElementSibling : tr;
	}

	/* กลุ่ม = แถวหลัก + แถวรายละเอียด S/N (ถ้ามี) — ย้าย/ลบด้วยกันเสมอ */
	function groupEnd(row) {
		return detailRowOf(row) || row;
	}

	function moveGroup(row, referenceNode) {
		var body = byId('rc_items_body');
		var detail = detailRowOf(row);
		body.insertBefore(row, referenceNode);
		if (detail) body.insertBefore(detail, row.nextSibling);
	}

	function clearDropMarkers() {
		itemRows().forEach(function(row) {
			row.classList.remove('is-drop-before', 'is-drop-after');
		});
	}

	function bindRowSorting() {
		var body = byId('rc_items_body');
		if (config.readOnly) return;

		// tr ลากได้เฉพาะตอนจับที่จุดจับ — ไม่ให้การลากคลุมข้อความในช่องกรอกกลายเป็นการย้ายแถว
		body.addEventListener('mousedown', function(event) {
			var handle = event.target.closest('.rp-drag-handle');
			if (handle) handle.closest('tr').draggable = true;
		});
		body.addEventListener('mouseup', function(event) {
			var row = event.target.closest('tr');
			if (row && row !== draggingRow) row.draggable = false;
		});

		body.addEventListener('dragstart', function(event) {
			var row = event.target.closest('tr');
			if (!row || !row.draggable) return;
			draggingRow = row;
			row.classList.add('is-dragging');
			event.dataTransfer.effectAllowed = 'move';
			event.dataTransfer.setData('text/plain', ''); // Firefox ต้องมี data ถึงจะเริ่มลาก
		});

		body.addEventListener('dragover', function(event) {
			if (!draggingRow) return;
			var target = mainRowOf(event.target.closest('tr'));
			if (!target || target.parentNode !== body) return;
			event.preventDefault();
			clearDropMarkers();
			if (target === draggingRow) return;
			var rect = target.getBoundingClientRect();
			target.classList.add(event.clientY < rect.top + rect.height / 2 ? 'is-drop-before' : 'is-drop-after');
		});

		body.addEventListener('drop', function(event) {
			if (!draggingRow) return;
			var target = mainRowOf(event.target.closest('tr'));
			if (!target || target.parentNode !== body || target === draggingRow) return;
			event.preventDefault();
			var rect = target.getBoundingClientRect();
			moveGroup(draggingRow, event.clientY < rect.top + rect.height / 2 ? target : groupEnd(target).nextSibling);
			markDirty();
		});

		body.addEventListener('dragend', function() {
			if (draggingRow) {
				draggingRow.classList.remove('is-dragging');
				draggingRow.draggable = false;
			}
			draggingRow = null;
			clearDropMarkers();
		});

		body.addEventListener('keydown', function(event) {
			var handle = event.target.closest('.rp-drag-handle');
			if (!handle || (event.key !== 'ArrowUp' && event.key !== 'ArrowDown')) return;
			event.preventDefault();
			var row = handle.closest('tr');
			if (event.key === 'ArrowUp') {
				var previous = mainRowOf(row.previousElementSibling);
				if (!previous) return;
				moveGroup(row, previous);
			} else {
				var next = groupEnd(row).nextElementSibling;
				if (!next) return;
				moveGroup(row, groupEnd(next).nextSibling);
			}
			markDirty();
			handle.focus();
		});
	}

	/* ถังขยะ: เอาแถวออกจากหน้าจอเท่านั้น ไม่กระทบเอกสารต้นทาง — แถวที่เอาออกไม่ถูกส่ง จึงไม่ถูกบันทึกเป็นการคืน (โหลดหน้าใหม่แล้วกลับมา) */
	function deleteRow(row) {
		var code = (row.querySelector('.rp-col-code') || {}).textContent || '';
		confirmDialog('ลบรายการนี้ออกจากหน้าจอ ?', 'รายการ ' + code.trim() + ' จะไม่ถูกบันทึกเป็นการคืน (โหลดหน้าใหม่เพื่อนำกลับมา)', 'ลบรายการ')
			.then(function(confirmed) {
				if (!confirmed) return;
				var detail = detailRowOf(row);
				if (detail) detail.parentNode.removeChild(detail);
				row.parentNode.removeChild(row);
				markDirty();
				refreshSummary();
			});
	}

	/* ===================== ฟอร์ม ===================== */
	/* เลือกช่วงเวลาแล้วเติมเวลาเริ่มจัดส่งให้ทางเดียว (กฎเดียวกับ js/delivery-transport.js) — แก้เวลาเองแล้วช่วงเวลาไม่เปลี่ยนตาม
	   กำหนดเวลา = ล้างให้ผู้ใช้เลือกเอง */
	function bindTimeRangePreset() {
		var select = byId('time_range');
		var input = byId('time_between');
		select.addEventListener('change', function() {
			if (TIME_RANGE_PRESETS[select.value]) {
				input.value = TIME_RANGE_PRESETS[select.value];
			} else if (select.value === 'specific') {
				input.value = '';
				input.focus();
			} else {
				input.value = '';
			}
		});
	}

	/* ===================== Validation (ต้องตรงกับ rc_header_from_post / rc_choose_lines) ===================== */
	function focusField(field) {
		if (!field) return;
		if (typeof field.scrollIntoView === 'function') field.scrollIntoView({ behavior: 'smooth', block: 'center' });
		if (typeof field.focus === 'function') setTimeout(function() { field.focus(); }, 250);
	}

	function validateItems() {
		var picked = 0;
		var problem = null;
		itemRows().forEach(function(row) {
			if (problem || !row.classList.contains('is-selected')) return;
			picked++;
			if (!rowIsPlain(row)) return;
			var input = rowQtyInput(row);
			var qty = parseQty(input.value);
			var max = parseQty(input.getAttribute('data-max')) || 0;
			if (qty === null || qty < 1) {
				problem = { message: 'จำนวนที่คืนต้องเป็นจำนวนเต็มมากกว่า 0', field: input };
			} else if (qty > max) {
				problem = { message: 'จำนวนที่คืนเกินยอดค้าง (ค้าง ' + max + ')', field: input };
			}
		});
		if (problem) return problem;
		if (picked === 0) {
			return { message: 'กรุณาเลือกรายการที่จะคืนอย่างน้อย 1 รายการ', field: byId('rc_product_search') };
		}
		return null;
	}

	/* ===================== บันทึก / ยกเลิก ===================== */
	var actionLabels = {
		draft: { busy: 'กำลังบันทึก...', fail: 'บันทึกร่างไม่สำเร็จ' },
		submit: { busy: 'กำลังส่ง...', fail: 'Submit ไม่สำเร็จ' },
		cancel: { busy: 'กำลังยกเลิก...', fail: 'ยกเลิกใบคืนไม่สำเร็จ' }
	};

	function setButtonsBusy(isBusy, activeButton) {
		all('.rc-action-btn').forEach(function(button) {
			if (isBusy) {
				button.setAttribute('data-default-html', button.innerHTML);
				button.disabled = true;
			} else if (button.hasAttribute('data-default-html')) {
				button.innerHTML = button.getAttribute('data-default-html');
				button.disabled = false;
			}
		});
		if (isBusy && activeButton) {
			var action = activeButton.getAttribute('data-rc-action');
			activeButton.innerHTML = '<i class="fas fa-spinner fa-spin" aria-hidden="true"></i> ' + actionLabels[action].busy;
		}
	}

	function post(action, formData, button) {
		busy = true;
		setButtonsBusy(true, button);
		formData.set('rc_action', action);

		fetch('register_receive1.php', {
			method: 'POST',
			body: formData,
			credentials: 'same-origin'
		})
			.then(function(response) {
				return response.text().then(function(text) {
					var data = null;
					try { data = JSON.parse(text); } catch (e) { data = null; }
					if (!data) throw new Error('เซิร์ฟเวอร์ตอบกลับไม่ถูกต้อง (HTTP ' + response.status + ')');
					return data;
				});
			})
			.then(function(data) {
				if (data.success) {
					// ไปหน้าถัดไปทันที — ห้ามปลด busy เพื่อกันกดซ้ำระหว่างเปลี่ยนหน้า
					dirty = false;
					window.location.href = data.redirect;
					return;
				}
				busy = false;
				setButtonsBusy(false);
				notify(actionLabels[action].fail, data.message || 'เกิดข้อผิดพลาด', 'error');
			})
			.catch(function(error) {
				busy = false;
				setButtonsBusy(false);
				notify(actionLabels[action].fail, error && error.message ? error.message : String(error), 'error');
			});
	}

	window.rcSave = function(action, button) {
		if (busy || !actionLabels[action]) return;
		var form = document.forms.frmMain;

		// Save Draft และ Submit ตรวจเท่ากัน — ดอกจันตรวจด้วย soValidateRequired() ได้กรอบแดงพร้อมกัน
		if (!soValidateRequired(form)) return;

		var problem = validateItems();
		if (problem) {
			notify('ข้อมูลไม่ครบถ้วน', problem.message, 'warning').then(function() { focusField(problem.field); });
			return;
		}

		if (action !== 'submit') {
			post(action, new FormData(form), button);
			return;
		}
		confirmDialog('ยืนยัน Submit ใบคืนสินค้า ?', 'ระบบจะส่งใบคืนให้ Stock ทันที หลัง Submit แล้วแก้ไขและยกเลิกไม่ได้', 'Submit')
			.then(function(confirmed) {
				if (confirmed && !busy) post(action, new FormData(form), button);
			});
	};

	window.rcCancel = function(button) {
		if (busy || !config.receiveRef) return;
		confirmDialog(
			'ยกเลิกใบคืนสินค้านี้ ?',
			'ใบคืนเลขที่ ' + config.receiveRef + ' จะถูกลบออกจริง ยอดค้างกลับไปที่เอกสารต้นทาง และกู้คืนไม่ได้',
			'ยกเลิกใบคืน'
		).then(function(confirmed) {
			if (!confirmed || busy) return;
			var formData = new FormData();
			formData.set('receive_ref', config.receiveRef);
			post('cancel', formData, button);
		});
	};

	/* แท็บในการ์ดแนบไฟล์ (partials/doc_tabs_card.php) — ใบคืนมีแท็บเดียว จึงแค่สลับ active */
	window.rcOpen3Tab = function(tabId, element) {
		all('.so-3tab-content').forEach(function(tab) { tab.style.display = (tab.id === tabId) ? 'block' : 'none'; });
		all('.so-tab-btn').forEach(function(btn) { btn.classList.toggle('active', btn === element); });
	};

	/* ===================== เริ่มต้นหน้า ===================== */
	document.addEventListener('DOMContentLoaded', function() {
		var form = document.forms.frmMain;
		var body = byId('rc_items_body');

		itemRows().forEach(function(row) {
			var input = rowQtyInput(row);
			if (input) clampQty(input);
		});
		refreshSummary();

		body.addEventListener('change', function(event) {
			var target = event.target;
			if (target.classList.contains('rc-pick-group')) {
				setRowPicked(target.closest('tr'), target.checked);
			} else if (target.classList.contains('rc-qty')) {
				clampQty(target);
			}
			refreshSummary();
		});
		body.addEventListener('input', function(event) {
			if (event.target.classList.contains('rc-qty')) refreshSummary();
		});
		body.addEventListener('click', function(event) {
			var caret = event.target.closest('.rc-caret');
			if (caret) {
				toggleDetail(caret);
				return;
			}
			var trash = event.target.closest('[data-rc-row-action="delete"]');
			if (trash && !config.readOnly) deleteRow(trash.closest('tr'));
		});
		bindRowSorting();

		byId('rc_check_all').addEventListener('change', function() {
			var checked = this.checked;
			itemRows().forEach(function(row) {
				if (!row.hidden) setRowPicked(row, checked);
			});
			refreshSummary();
		});

		byId('rc_product_search').addEventListener('input', function() {
			filterRows(this.value);
		});
		byId('rc_product_search').addEventListener('keydown', function(event) {
			if (event.key === 'Enter') event.preventDefault();
		});

		bindTimeRangePreset();

		// ช่องติ๊กเลือกแถว/ช่องค้นหาไม่ใช่ข้อมูลที่ต้องบันทึกซ้ำ จึงไม่ถือเป็นการแก้ไข (ช่องติ๊กรายการนับ เพราะเปลี่ยนสิ่งที่จะคืน)
		var onFormEdited = function(event) {
			var target = event.target;
			if (['rc_product_search', 'rc_check_all'].indexOf(target.id) !== -1) return;
			markDirty();
		};
		form.addEventListener('input', onFormEdited);
		form.addEventListener('change', onFormEdited);

		// ปุ่ม × ล้างค่าในช่อง
		document.addEventListener('click', function(event) {
			var clear = event.target.closest('[data-rp-clear]');
			if (!clear) return;
			var input = byId(clear.getAttribute('data-rp-clear'));
			if (input && !input.disabled) {
				input.value = '';
				input.dispatchEvent(new Event('input', { bubbles: true }));
				input.focus();
			}
		});

		// แบบฟอร์มพิมพ์อ่านจากฐานข้อมูล — แก้ค้างอยู่จะพิมพ์ออกมาไม่ตรงกับที่เห็นบนจอ
		var printLink = byId('rc_print_link');
		if (printLink) {
			printLink.addEventListener('click', function(event) {
				if (!dirty || config.readOnly) return;
				event.preventDefault();
				notify('มีการแก้ไขที่ยังไม่ได้บันทึก', 'กรุณากด Update ก่อนพิมพ์', 'warning');
			});
		}

		window.addEventListener('beforeunload', function(event) {
			if (!dirty || config.readOnly) return;
			event.preventDefault();
			event.returnValue = '';
		});
	});
})();
