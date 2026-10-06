/* หน้า register_receivepro.php (ใบส่งสินค้า) — ต้องโหลดหลัง js/so-required-fields.js และ SweetAlert2
 * ค่าตั้งต้นมาจาก window.rpPageConfig (mode, rpNo, savedItems, canAddRows, readOnly, sentReceive)
 * บันทึกทุกปุ่มผ่าน register_receivepro1.php (rp_action)
 */
(function() {
	'use strict';

	var config = window.rpPageConfig || {};
	var busy = false; // กันกดซ้ำระหว่างรอบันทึก
	var dirty = false; // มีการแก้ไขที่ยังไม่ได้บันทึก

	function byId(id) {
		return document.getElementById(id);
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

	function escapeHtml(value) {
		return String(value === undefined || value === null ? '' : value)
			.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
			.replace(/"/g, '&quot;').replace(/'/g, '&#39;');
	}

	/* คืน null เมื่อว่าง, NaN เมื่อไม่ใช่ตัวเลข (รูปแบบเดียวกับ rp_parse_number ฝั่ง server) */
	function parseNumber(raw) {
		var text = String(raw === undefined || raw === null ? '' : raw).replace(/,/g, '').trim();
		if (text === '') return null;
		return /^\d+(\.\d+)?$/.test(text) ? parseFloat(text) : NaN;
	}

	function formatQty(value) {
		var number = Number(value || 0);
		if (!isFinite(number)) number = 0;
		return number.toLocaleString('en-US', { maximumFractionDigits: 2 });
	}

	function markDirty() {
		dirty = true;
	}

	/* ===================== แถวสินค้า ===================== */
	function itemsBody() {
		return byId('rp_items_body');
	}

	function itemRows() {
		return Array.prototype.slice.call(itemsBody().children);
	}

	function rowField(row, name) {
		return row.querySelector('[name="' + name + '[]"]');
	}

	function createRow(item) {
		var row = document.createElement('tr');
		var code = item.access_code || '-';
		row.innerHTML =
			'<td class="rp-col-drag">' +
				'<button type="button" class="rp-drag-handle" title="ลากเพื่อเรียงลำดับ" aria-label="เรียงลำดับ ' + escapeHtml(code) + ' — ลาก หรือกดลูกศรขึ้น/ลง"><i class="fas fa-grip-vertical" aria-hidden="true"></i></button>' +
			'</td>' +
			'<td class="rp-col-check">' +
				'<label class="rp-check"><input type="checkbox" class="rp-row-check" aria-label="เลือก ' + escapeHtml(code) + '"><span class="rp-check-mark" aria-hidden="true"></span></label>' +
			'</td>' +
			'<td class="rp-col-code">' + escapeHtml(code) +
				'<input type="hidden" name="item_id[]" value="' + escapeHtml(item.id || '') + '">' +
				'<input type="hidden" name="item_product_id[]" value="' + escapeHtml(item.product_id) + '">' +
				'<input type="hidden" name="item_remark[]" value="' + escapeHtml(item.remark || '') + '">' +
				'<input type="hidden" name="item_proname[]" value="' + escapeHtml(item.proname || '') + '">' +
				// ไม่มีช่องยอดรวมบนหน้าแล้ว — ส่งค่าเดิมกลับไปเพื่อไม่ให้ยอดของเอกสารเก่าถูกล้างตอนบันทึกซ้ำ
				'<input type="hidden" name="item_amount[]" value="' + escapeHtml(item.amount || '0.00') + '">' +
			'</td>' +
			'<td class="rp-col-name">' +
				'<div class="rp-item-name">' + escapeHtml(item.sol_name || '-') + '</div>' +
			'</td>' +
			'<td class="rp-col-qty"><input type="text" inputmode="decimal" name="item_qty[]" class="so-input rp-num-input" autocomplete="off" aria-label="จำนวน ' + escapeHtml(code) + '" value="' + escapeHtml(item.qty) + '"></td>' +
			'<td class="rp-col-actions"><span class="rp-row-actions">' +
				'<button type="button" class="rp-row-btn" data-rp-row-action="edit" title="ข้อมูลเพิ่มเติม" aria-label="ข้อมูลเพิ่มเติมของ ' + escapeHtml(code) + '"><img src="img/icons/edit.svg" alt=""></button>' +
				'<button type="button" class="rp-row-btn" data-rp-row-action="delete" title="ลบรายการ" aria-label="ลบ ' + escapeHtml(code) + '"><img src="img/icons/trash.svg" alt=""></button>' +
			'</span></td>';
		return row;
	}

	function refreshSummary() {
		var rows = itemRows();
		var totalQty = 0;
		var selected = 0;
		rows.forEach(function(row) {
			var qty = parseNumber(rowField(row, 'item_qty').value);
			if (qty !== null && !isNaN(qty)) totalQty += qty;
			var checked = row.querySelector('.rp-row-check').checked;
			row.classList.toggle('is-selected', checked);
			if (checked) selected++;
		});

		byId('rp_items_count').textContent = rows.length + ' รายการ';
		byId('rp_total_qty').textContent = formatQty(totalQty);
		byId('rp_items_empty').hidden = rows.length > 0;

		var checkAll = byId('rp_check_all');
		checkAll.checked = rows.length > 0 && selected === rows.length;
		checkAll.indeterminate = selected > 0 && selected < rows.length;
		checkAll.disabled = rows.length === 0 || !!config.readOnly;

		var bulk = byId('rp_bulk_delete');
		bulk.hidden = selected === 0 || !!config.readOnly;
		byId('rp_bulk_count').textContent = selected;
	}

	function addProduct(product) {
		if (!config.canAddRows) return;
		if (itemRows().length >= (config.maxItems || 100)) {
			notify('เพิ่มรายการไม่ได้', 'รายการสินค้าเกิน ' + (config.maxItems || 100) + ' รายการ', 'warning');
			return;
		}
		var row = createRow({
			id: '',
			product_id: product.product_id,
			access_code: product.access_code,
			sol_name: product.sol_name,
			qty: '1',
			amount: '0.00',
			remark: '',
			proname: ''
		});
		itemsBody().appendChild(row);
		markDirty();
		refreshSummary();
	}

	function clearAllRows() {
		itemsBody().innerHTML = '';
		refreshSummary();
	}

	function removeRows(rows) {
		rows.forEach(function(row) {
			if (row.parentNode) row.parentNode.removeChild(row);
		});
		markDirty();
		refreshSummary();
	}

	function deleteRow(row) {
		// เอกสารที่ Submit แล้วเพิ่มแถวกลับไม่ได้ จึงถามก่อนลบ — ร่างค้นหาเพิ่มใหม่ได้ ลบทันที
		if (config.canAddRows) {
			removeRows([row]);
			return;
		}
		confirmDialog('ลบรายการนี้ ?', 'เอกสารที่ Submit แล้วเพิ่มรายการสินค้ากลับไม่ได้ (มีผลเมื่อกด Update)', 'ลบรายการ')
			.then(function(confirmed) {
				if (confirmed) removeRows([row]);
			});
	}

	function deleteSelectedRows() {
		var rows = itemRows().filter(function(row) {
			return row.querySelector('.rp-row-check').checked;
		});
		if (rows.length === 0) return;
		var text = config.canAddRows
			? 'ต้องการลบ ' + rows.length + ' รายการที่เลือกใช่หรือไม่'
			: 'ต้องการลบ ' + rows.length + ' รายการที่เลือกใช่หรือไม่ — เอกสารที่ Submit แล้วเพิ่มรายการสินค้ากลับไม่ได้ (มีผลเมื่อกด Update)';
		confirmDialog('ลบรายการที่เลือก ?', text, 'ลบรายการ').then(function(confirmed) {
			if (confirmed) removeRows(rows);
		});
	}

	/* ===================== เรียงลำดับแถว (ลากที่จุดจับ หรือลูกศรขึ้น/ลงบนจุดจับ) ===================== */
	var draggingRow = null;

	function clearDropMarkers() {
		itemRows().forEach(function(row) {
			row.classList.remove('is-drop-before', 'is-drop-after');
		});
	}

	function bindRowSorting() {
		var body = itemsBody();

		// tr ลากได้เฉพาะตอนจับที่จุดจับ — ไม่ให้การลากคลุมข้อความในช่องกรอกกลายเป็นการย้ายแถว
		body.addEventListener('mousedown', function(event) {
			var handle = event.target.closest('.rp-drag-handle');
			if (handle && !config.readOnly) handle.closest('tr').draggable = true;
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
			var target = event.target.closest('tr');
			if (!target || target.parentNode !== body) return;
			event.preventDefault();
			clearDropMarkers();
			if (target === draggingRow) return;
			var rect = target.getBoundingClientRect();
			target.classList.add(event.clientY < rect.top + rect.height / 2 ? 'is-drop-before' : 'is-drop-after');
		});

		body.addEventListener('drop', function(event) {
			if (!draggingRow) return;
			var target = event.target.closest('tr');
			if (!target || target.parentNode !== body || target === draggingRow) return;
			event.preventDefault();
			var rect = target.getBoundingClientRect();
			body.insertBefore(draggingRow, event.clientY < rect.top + rect.height / 2 ? target : target.nextSibling);
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
			if (event.key === 'ArrowUp' && row.previousElementSibling) {
				body.insertBefore(row, row.previousElementSibling);
			} else if (event.key === 'ArrowDown' && row.nextElementSibling) {
				body.insertBefore(row.nextElementSibling, row);
			} else {
				return;
			}
			markDirty();
			handle.focus();
		});
	}

	/* ===================== Popup ข้อมูลรายการสินค้าเพิ่มเติม ===================== */
	var modalRow = null;
	var modalOpener = null;

	function openItemModal(row, opener) {
		modalRow = row;
		modalOpener = opener || null;
		byId('rp_modal_remark').value = rowField(row, 'item_remark').value;
		byId('rp_modal_proname').value = rowField(row, 'item_proname').value;
		var modal = byId('rpItemModal');
		modal.hidden = false;
		modal.setAttribute('aria-hidden', 'false');
		byId('rp_modal_remark').focus();
	}

	window.rpCloseItemModal = function() {
		var modal = byId('rpItemModal');
		if (!modal || modal.hidden) return;
		modal.hidden = true;
		modal.setAttribute('aria-hidden', 'true');
		if (modalOpener && document.body.contains(modalOpener)) modalOpener.focus();
		modalRow = null;
		modalOpener = null;
	};

	window.rpConfirmItemModal = function() {
		if (!modalRow) return;
		rowField(modalRow, 'item_remark').value = byId('rp_modal_remark').value.trim();
		rowField(modalRow, 'item_proname').value = byId('rp_modal_proname').value.trim();
		markDirty();
		window.rpCloseItemModal();
	};

	/* Tab วนอยู่ใน popup ระหว่างที่เปิด */
	function trapModalFocus(event) {
		var modal = byId('rpItemModal');
		if (event.key !== 'Tab' || !modal || modal.hidden) return;
		var focusable = modal.querySelectorAll('button, input');
		var first = focusable[0];
		var last = focusable[focusable.length - 1];
		if (event.shiftKey && document.activeElement === first) {
			event.preventDefault();
			last.focus();
		} else if (!event.shiftKey && document.activeElement === last) {
			event.preventDefault();
			first.focus();
		}
	}

	/* ===================== ค้นหาสินค้า (data_receivepro_product.php) ===================== */
	var searchTimer = null;
	var searchToken = 0;
	var searchItems = [];
	var searchActive = -1;

	function searchInput() {
		return byId('rp_product_search');
	}

	function closeSearchResults() {
		var list = byId('rp_product_results');
		var input = searchInput();
		if (!list || !input) return;
		list.hidden = true;
		list.innerHTML = '';
		input.setAttribute('aria-expanded', 'false');
		input.removeAttribute('aria-activedescendant');
		searchItems = [];
		searchActive = -1;
	}

	function showSearchNote(message) {
		var list = byId('rp_product_results');
		searchItems = [];
		searchActive = -1;
		list.innerHTML = '<li class="rp-search-note" role="presentation">' + escapeHtml(message) + '</li>';
		list.hidden = false;
		searchInput().setAttribute('aria-expanded', 'true');
	}

	function setActiveSearchOption(index) {
		var list = byId('rp_product_results');
		var options = list.querySelectorAll('.rp-search-option');
		searchActive = index;
		Array.prototype.forEach.call(options, function(option, i) {
			var isActive = (i === index);
			option.classList.toggle('is-active', isActive);
			option.setAttribute('aria-selected', isActive ? 'true' : 'false');
			if (isActive) {
				searchInput().setAttribute('aria-activedescendant', option.id);
				option.scrollIntoView({ block: 'nearest' });
			}
		});
	}

	function renderSearchResults(items, hasMore) {
		if (items.length === 0) {
			showSearchNote('ไม่พบสินค้าที่ตรงกับคำค้นของบริษัทที่เลือก');
			return;
		}
		var list = byId('rp_product_results');
		searchItems = items;
		list.innerHTML = items.map(function(item, index) {
			var sub = String(item.access_name || '').trim();
			return '<li class="rp-search-option" role="option" id="rp_product_option_' + index + '" data-rp-index="' + index + '" aria-selected="false">' +
				'<span class="rp-search-option-code">' + escapeHtml(item.access_code) + '</span>' +
				'<span class="rp-search-option-name">' + escapeHtml(item.sol_name) + '</span>' +
				(sub !== '' && sub !== item.sol_name ? '<span class="rp-search-option-sub">' + escapeHtml(sub) + '</span>' : '') +
				'</li>';
		}).join('') + (hasMore ? '<li class="rp-search-note" role="presentation">แสดง ' + items.length + ' รายการแรก — พิมพ์คำค้นให้เจาะจงขึ้น</li>' : '');
		list.hidden = false;
		searchInput().setAttribute('aria-expanded', 'true');
		setActiveSearchOption(0);
	}

	function runSearch() {
		var input = searchInput();
		var keyword = input.value.trim();
		var token = ++searchToken;
		if (keyword === '') {
			closeSearchResults();
			return;
		}
		var url = 'data_receivepro_product.php?q=' + encodeURIComponent(keyword) +
			'&company=' + encodeURIComponent(byId('type_company_select').value);
		fetch(url, { credentials: 'same-origin', cache: 'no-store' })
			.then(function(response) { return response.json(); })
			.then(function(data) {
				if (token !== searchToken) return; // พิมพ์ต่อไปแล้วระหว่างรอ
				if (!data || !data.success) throw new Error((data && data.message) || 'ไม่สามารถค้นหาสินค้าได้');
				renderSearchResults(Array.isArray(data.items) ? data.items : [], !!data.has_more);
			})
			.catch(function(error) {
				if (token !== searchToken) return;
				showSearchNote(error && error.message ? error.message : 'ไม่สามารถค้นหาสินค้าได้');
			});
	}

	function pickSearchOption(index) {
		var item = searchItems[index];
		if (!item) return;
		addProduct(item);
		var input = searchInput();
		input.value = '';
		searchToken++;
		closeSearchResults();
		input.focus();
	}

	function bindProductSearch() {
		var input = searchInput();
		if (!input) return;
		var list = byId('rp_product_results');

		input.addEventListener('input', function() {
			clearTimeout(searchTimer);
			searchTimer = setTimeout(runSearch, 250);
		});

		input.addEventListener('keydown', function(event) {
			if (event.key === 'Enter') {
				event.preventDefault(); // Enter ในช่องค้นหาต้องไม่ submit ฟอร์ม
				if (searchActive >= 0) pickSearchOption(searchActive);
				return;
			}
			if (event.key === 'Escape') {
				if (!list.hidden) {
					event.stopPropagation();
					closeSearchResults();
				}
				return;
			}
			if (event.key !== 'ArrowDown' && event.key !== 'ArrowUp') return;
			if (searchItems.length === 0) return;
			event.preventDefault();
			var next = searchActive + (event.key === 'ArrowDown' ? 1 : -1);
			if (next < 0) next = searchItems.length - 1;
			if (next >= searchItems.length) next = 0;
			setActiveSearchOption(next);
		});

		// mousedown (ไม่ใช่ click) — เลือกก่อนที่ช่องค้นหาจะเสีย focus แล้วรายการถูกปิด
		list.addEventListener('mousedown', function(event) {
			var option = event.target.closest('.rp-search-option');
			if (!option) return;
			event.preventDefault();
			pickSearchOption(parseInt(option.getAttribute('data-rp-index'), 10));
		});

		input.addEventListener('blur', function() {
			setTimeout(closeSearchResults, 150);
		});
	}

	/* ===================== บริษัท AWL/NBM — เปลี่ยนแล้วต้องล้างสินค้าทั้งหมด ===================== */
	function bindCompanySwitch() {
		var select = byId('type_company_select');
		if (!select || select.disabled) return;
		select.setAttribute('data-prev', select.value);

		select.addEventListener('change', function() {
			var previous = select.getAttribute('data-prev');
			closeSearchResults();
			if (itemRows().length === 0) {
				select.setAttribute('data-prev', select.value);
				markDirty();
				return;
			}
			var next = select.value;
			select.value = previous; // ค้างค่าเดิมไว้จนกว่าจะยืนยัน
			confirmDialog('เปลี่ยนบริษัท ?', 'การเปลี่ยนบริษัทจะล้างรายการสินค้าที่เลือกไว้ทั้งหมด เพื่อไม่ให้สินค้าต่างบริษัทปนกัน', 'ล้างรายการและเปลี่ยน')
				.then(function(confirmed) {
					if (confirmed) {
						clearAllRows();
						select.value = next;
						select.setAttribute('data-prev', next);
						markDirty();
					}
					select.focus();
				});
		});
	}

	/* ===================== Validation (ต้องตรงกับ rp_validate_required / rp_collect_items_from_post) ===================== */
	function focusField(field) {
		if (!field) return;
		if (typeof field.scrollIntoView === 'function') field.scrollIntoView({ behavior: 'smooth', block: 'center' });
		if (typeof field.focus === 'function') setTimeout(function() { field.focus(); }, 250);
	}

	/* strict = เอกสารจริง (Submit / Update): จำนวนต้องมากกว่า 0 และต้องมีอย่างน้อย 1 รายการ
	   ยกเว้นเอกสารเก่าที่ไม่มีแถวสินค้ามาตั้งแต่ต้น — ยัง Update ข้อมูลลูกค้าได้ */
	function validateItems(strict) {
		var rows = itemRows();
		if (strict && rows.length === 0) {
			if (config.canAddRows) {
				return { message: 'กรุณาเพิ่มรายการสินค้าอย่างน้อย 1 รายการ', field: searchInput() };
			}
			if ((config.savedItems || []).length > 0) {
				return { message: 'เอกสารที่ Submit แล้วต้องเหลือรายการสินค้าอย่างน้อย 1 รายการ', field: null };
			}
		}
		for (var i = 0; i < rows.length; i++) {
			var label = 'รายการที่ ' + (i + 1);
			var qtyField = rowField(rows[i], 'item_qty');
			var qty = parseNumber(qtyField.value);
			if ((qty !== null && isNaN(qty)) || (strict && (qty === null || qty <= 0))) {
				return { message: label + ': จำนวนต้องเป็นตัวเลขมากกว่า 0', field: qtyField };
			}
		}
		return null;
	}

	/* ===================== บันทึก / ส่งรับจ่าย / ยกเลิก ===================== */
	var actionLabels = {
		draft: { busy: 'กำลังบันทึก...', fail: 'บันทึกร่างไม่สำเร็จ' },
		submit: { busy: 'กำลังส่ง...', fail: 'Submit ไม่สำเร็จ' },
		update: { busy: 'กำลังบันทึก...', fail: 'อัปเดตไม่สำเร็จ' },
		send_receive: { busy: 'กำลังส่ง...', fail: 'ส่งข้อมูลไปรับจ่ายไม่สำเร็จ' },
		cancel: { busy: 'กำลังยกเลิก...', fail: 'ยกเลิกเอกสารไม่สำเร็จ' }
	};

	function setButtonsBusy(isBusy, activeButton) {
		var buttons = document.querySelectorAll('.rp-action-btn');
		Array.prototype.forEach.call(buttons, function(button) {
			if (isBusy) {
				button.setAttribute('data-default-html', button.innerHTML);
				button.setAttribute('data-default-disabled', button.disabled ? '1' : '0');
				button.disabled = true;
			} else if (button.hasAttribute('data-default-html')) {
				button.innerHTML = button.getAttribute('data-default-html');
				button.disabled = button.getAttribute('data-default-disabled') === '1';
			}
		});
		if (isBusy && activeButton) {
			var action = activeButton.getAttribute('data-rp-action');
			activeButton.innerHTML = '<i class="fas fa-spinner fa-spin" aria-hidden="true"></i> ' + actionLabels[action].busy;
		}
	}

	function post(action, formData, button) {
		busy = true;
		setButtonsBusy(true, button);
		formData.set('rp_action', action);

		fetch('register_receivepro1.php', {
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

	window.rpSave = function(action, button) {
		if (busy || !actionLabels[action]) return;
		var form = document.forms.frmMain;
		var strict = (action !== 'draft');

		// ดอกจันตรวจด้วย soValidateRequired() ได้กรอบแดงพร้อมกัน — Save Draft ไม่บังคับกรอก
		if (strict && !soValidateRequired(form)) return;

		var problem = validateItems(strict);
		if (problem) {
			notify('ข้อมูลไม่ครบถ้วน', problem.message, 'warning').then(function() { focusField(problem.field); });
			return;
		}

		if (action !== 'submit') {
			post(action, new FormData(form), button);
			return;
		}
		confirmDialog('ยืนยัน Submit ใบส่งสินค้า ?', 'หลัง Submit จะแก้หัวเอกสารและเพิ่มรายการสินค้าไม่ได้ (ยังแก้ข้อมูลลูกค้า จำนวน และลบรายการได้ด้วยปุ่ม Update)', 'Submit')
			.then(function(confirmed) {
				if (confirmed && !busy) post(action, new FormData(form), button);
			});
	};

	function documentFormData() {
		var formData = new FormData();
		formData.set('rp_no', config.rpNo || '');
		return formData;
	}

	/* ส่งรับจ่าย/ยกเลิก ทำกับข้อมูลที่บันทึกแล้ว — มีการแก้ค้างอยู่ต้องให้ Update ก่อน ไม่งั้นค่าที่ส่งไปจะไม่ตรงกับที่เห็นบนจอ */
	function blockWhenDirty(actionText) {
		if (!dirty) return false;
		notify('มีการแก้ไขที่ยังไม่ได้บันทึก', 'กรุณากด Update ก่อน' + actionText, 'warning');
		return true;
	}

	window.rpSendReceive = function(button) {
		if (busy || !config.rpNo || blockWhenDirty('ส่งข้อมูลไปรับจ่าย')) return;
		confirmDialog('ส่งข้อมูลไปรับจ่าย ?', 'ระบบจะส่งข้อมูลใบส่งสินค้าเลขที่ ' + config.rpNo + ' ไปฝั่งรับจ่ายทันที และส่งซ้ำไม่ได้', 'ส่งข้อมูล')
			.then(function(confirmed) {
				if (confirmed && !busy) post('send_receive', documentFormData(), button);
			});
	};

	window.rpCancelDocument = function(button) {
		if (busy || !config.rpNo) return;
		var subtitle = 'ต้องการยกเลิกใบส่งสินค้าเลขที่ "' + config.rpNo + '" — ยกเลิกแล้วไม่สามารถนำกลับมาใช้ได้อีก';
		if (config.sentReceive) {
			subtitle += ' เอกสารนี้ส่งข้อมูลไปรับจ่ายแล้ว ระบบจะไม่ลบข้อมูลฝั่งรับจ่ายให้ กรุณาแจ้งฝั่งรับจ่ายด้วย';
		}
		var onConfirm = function(reason) {
			if (busy) return;
			var formData = documentFormData();
			formData.set('reason', reason);
			post('cancel', formData, button);
		};

		if (typeof Swal === 'undefined') {
			var fallback = (window.prompt(subtitle + '\nระบุเหตุผลในการยกเลิก') || '').trim();
			if (fallback !== '') onConfirm(fallback);
			return;
		}
		// popup เหตุผลแบบเดียวกับใบ PO / ใบสั่งขาย (class จาก css/so-core.css)
		Swal.fire({
			title: 'ยกเลิกเอกสารนี้ ?',
			html: '<p class="so-reason-subtitle">' + escapeHtml(subtitle) + '</p>' +
				'<label class="so-reason-label">ระบุเหตุผลในการยกเลิก<span class="so-reason-required">*</span></label>',
			input: 'textarea',
			inputPlaceholder: 'ระบุเหตุผลในการยกเลิก',
			inputAttributes: { maxlength: '1000' },
			iconHtml: '<div class="so-reason-icon-circle" style="background:#F4F5F7"><img src="img/icons/cancel_document.png" alt="" style="width: 36px; height: 36px;"></div>',
			showCancelButton: true,
			showCloseButton: true,
			confirmButtonText: 'ตกลง',
			cancelButtonText: 'ยกเลิก',
			buttonsStyling: false,
			customClass: {
				popup: 'figma-delete-popup so-reason-popup',
				title: 'figma-delete-title so-reason-title',
				htmlContainer: 'figma-delete-html so-reason-html',
				confirmButton: 'figma-delete-confirm-btn so-reason-confirm-btn',
				cancelButton: 'figma-delete-cancel-btn so-reason-cancel-btn',
				actions: 'figma-delete-actions so-reason-actions',
				icon: 'figma-delete-icon so-reason-icon',
				input: 'so-reason-textarea',
				closeButton: 'so-reason-close-btn'
			},
			preConfirm: function(value) {
				var trimmed = (value || '').trim();
				if (trimmed === '') {
					Swal.showValidationMessage('กรุณาระบุเหตุผล');
					return false;
				}
				return trimmed;
			}
		}).then(function(result) {
			if (result.isConfirmed) onConfirm(result.value);
		});
	};

	/* ===================== เมนูพิมพ์ ===================== */
	function closePrintMenu() {
		var menu = byId('rpPrintMenu');
		var trigger = byId('btn_rp_print');
		if (menu) menu.hidden = true;
		if (trigger) trigger.setAttribute('aria-expanded', 'false');
	}

	window.rpTogglePrintMenu = function() {
		var menu = byId('rpPrintMenu');
		var trigger = byId('btn_rp_print');
		if (!menu) return;
		// แบบฟอร์มพิมพ์อ่านจากฐานข้อมูล — แก้ค้างอยู่จะพิมพ์ออกมาไม่ตรงกับที่เห็นบนจอ
		if (menu.hidden && blockWhenDirty('พิมพ์')) return;
		var open = menu.hidden;
		menu.hidden = !open;
		if (trigger) trigger.setAttribute('aria-expanded', open ? 'true' : 'false');
		if (open) {
			var first = menu.querySelector('a');
			if (first) first.focus();
		}
	};

	/* ===================== เริ่มต้นหน้า ===================== */
	document.addEventListener('DOMContentLoaded', function() {
		var form = document.forms.frmMain;
		var body = itemsBody();

		(Array.isArray(config.savedItems) ? config.savedItems : []).forEach(function(item) {
			body.appendChild(createRow(item));
		});
		refreshSummary();

		bindRowSorting();
		bindProductSearch();
		bindCompanySwitch();

		body.addEventListener('input', refreshSummary);
		body.addEventListener('change', refreshSummary);
		body.addEventListener('click', function(event) {
			var button = event.target.closest('[data-rp-row-action]');
			if (!button) return;
			var row = button.closest('tr');
			if (button.getAttribute('data-rp-row-action') === 'edit') openItemModal(row, button);
			else deleteRow(row);
		});

		byId('rp_check_all').addEventListener('change', function() {
			var checked = this.checked;
			itemRows().forEach(function(row) {
				row.querySelector('.rp-row-check').checked = checked;
			});
			refreshSummary();
		});
		byId('rp_bulk_delete').addEventListener('click', deleteSelectedRows);

		// ช่องติ๊กเลือกแถว/ช่องค้นหาไม่ใช่ข้อมูลเอกสาร ส่วนบริษัทนับเองใน bindCompanySwitch (กดยกเลิกแล้วค่าไม่เปลี่ยน)
		var onFormEdited = function(event) {
			var target = event.target;
			if (target.classList.contains('rp-row-check')) return;
			if (['rp_check_all', 'rp_product_search', 'type_company_select'].indexOf(target.id) !== -1) return;
			markDirty();
		};
		form.addEventListener('input', onFormEdited);
		form.addEventListener('change', onFormEdited);

		// ปุ่ม × ล้างค่าในช่อง (ทั้งในฟอร์มและใน popup)
		document.addEventListener('click', function(event) {
			var clear = event.target.closest('[data-rp-clear]');
			if (clear) {
				var input = byId(clear.getAttribute('data-rp-clear'));
				if (input && !input.disabled) {
					input.value = '';
					input.dispatchEvent(new Event('input', { bubbles: true }));
					input.focus();
				}
				return;
			}
			var printWrap = document.querySelector('.rp-print-wrap');
			if (printWrap && !printWrap.contains(event.target)) closePrintMenu();
		});

		var printMenu = byId('rpPrintMenu');
		if (printMenu) {
			printMenu.addEventListener('click', function(event) {
				if (event.target.closest('a')) closePrintMenu();
			});
		}

		var modal = byId('rpItemModal');
		modal.addEventListener('mousedown', function(event) {
			if (event.target === modal) window.rpCloseItemModal();
		});
		modal.addEventListener('keydown', function(event) {
			if (event.key === 'Enter' && event.target.tagName === 'INPUT') {
				event.preventDefault();
				window.rpConfirmItemModal();
			}
		});

		document.addEventListener('keydown', function(event) {
			trapModalFocus(event);
			if (event.key !== 'Escape') return;
			if (!modal.hidden) {
				window.rpCloseItemModal();
				return;
			}
			if (printMenu && !printMenu.hidden) {
				closePrintMenu();
				var trigger = byId('btn_rp_print');
				if (trigger) trigger.focus();
			}
		});

		window.addEventListener('beforeunload', function(event) {
			if (!dirty || config.readOnly) return;
			event.preventDefault();
			event.returnValue = '';
		});
	});
})();
