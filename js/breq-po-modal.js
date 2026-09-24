/* Modal "ค้นหาเอกสาร PO" ของ register_breng_brgq.php (ใบยืมตรวจเช็คสินค้า BREQ) — Figma 3006:3922
 * เลือกทีละแถวด้วยการคลิก (มติ Q22=ข ไม่ใช่ checkbox หลายแถว) แล้ว append ลงตารางหลักทีละรายการ
 * (มติ Q25=ก) ผ่าน window.breqAddItemRow() ของ js/breq-item-table.js — ดูแผน §4.2
 */
(function() {
	var breqPoState = {
		items: [],
		selectedIndex: -1,
		searchTimer: null,
		loading: false
	};

	function escapeHtml(value) {
		return String(value === null || value === undefined ? '' : value).replace(/[&<>"']/g, function(ch) {
			return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' }[ch];
		});
	}

	function formatDate(value) {
		var raw = String(value === undefined || value === null ? '' : value).trim();
		if (raw === '' || raw === '0000-00-00') return '-';
		var datePart = raw.split(/[T ]/)[0];
		var match = datePart.match(/^(\d{4})-(\d{1,2})-(\d{1,2})$/);
		if (match) {
			var year = Number(match[1]);
			if (year < 2400) year += 543;
			var month = ('0' + match[2]).slice(-2);
			var day = ('0' + match[3]).slice(-2);
			return day + '/' + month + '/' + (year % 100);
		}
		return raw;
	}

	function notify(title, text, icon) {
		if (typeof Swal === 'undefined') {
			alert(title + (text ? '\n' + text : ''));
			return;
		}
		Swal.fire({ title: title, text: text, icon: icon || 'info', confirmButtonColor: '#612989' });
	}

	function getLockedPoNo() {
		var el = document.getElementById('po_no');
		return el ? String(el.value || '').trim() : '';
	}

	function rowIsDisabled(item, lockedPoNo) {
		var remaining = Number(item.remaining);
		if (!isFinite(remaining) || remaining <= 0) return true;
		if (lockedPoNo !== '' && String(item.po_no) !== lockedPoNo) return true;
		return false;
	}

	function renderLockNote() {
		var note = document.getElementById('breqPoLockNote');
		if (!note) return;
		var lockedPoNo = getLockedPoNo();
		if (lockedPoNo !== '') {
			note.textContent = 'เอกสารนี้ล็อกไว้กับใบสั่งซื้อเลขที่ ' + lockedPoNo + ' แล้ว — เลือกได้เฉพาะรายการของใบนี้';
			note.style.display = '';
		} else {
			note.style.display = 'none';
		}
	}

	function renderRows() {
		var tbody = document.getElementById('breqPoModalRows');
		if (!tbody) return;

		if (breqPoState.loading) {
			tbody.innerHTML = '<tr><td colspan="6" class="customer-popup-empty">กำลังค้นหา...</td></tr>';
			return;
		}

		var items = breqPoState.items || [];
		if (items.length === 0) {
			tbody.innerHTML = '<tr><td colspan="6" class="customer-popup-empty">ไม่พบรายการ</td></tr>';
			return;
		}

		var lockedPoNo = getLockedPoNo();
		var html = '';
		items.forEach(function(item, index) {
			var disabled = rowIsDisabled(item, lockedPoNo);
			var selected = (index === breqPoState.selectedIndex);
			var rowClasses = [];
			if (disabled) rowClasses.push('is-disabled');
			if (selected) rowClasses.push('selected');

			html += '<tr class="' + rowClasses.join(' ') + '"' +
				(disabled ? '' : ' onclick="window.breqSelectPoRow(' + index + ');"') + '>' +
				'<td>' + escapeHtml(item.po_no) + '</td>' +
				'<td>' + escapeHtml(item.product_name) + '</td>' +
				'<td>' + escapeHtml(item.sale_count) + '</td>' +
				'<td>' + escapeHtml(item.remaining) + '</td>' +
				'<td>' + formatDate(item.stock_date) + '</td>' +
				'<td>' + escapeHtml(item.lot_no) + '</td>' +
				'</tr>';
		});

		tbody.innerHTML = html;
	}

	function getSelectedCompany() {
		var el = document.getElementById('company_select');
		return el ? String(el.value || '1') : '1';
	}

	function fetchItems(keyword) {
		breqPoState.loading = true;
		renderRows();

		var url = 'ajax_breq_po_items.php?q=' + encodeURIComponent(keyword || '') + '&company=' + encodeURIComponent(getSelectedCompany()) + '&limit=100';
		fetch(url, { credentials: 'same-origin' })
			.then(function(res) {
				return res.text().then(function(body) {
					var data;
					try {
						data = JSON.parse(body);
					} catch (error) {
						throw new Error('เซิร์ฟเวอร์ตอบกลับไม่ถูกต้อง (HTTP ' + res.status + ')');
					}
					if (!res.ok) {
						throw new Error(data.message || ('HTTP ' + res.status));
					}
					return data;
				});
			})
			.then(function(data) {
				breqPoState.loading = false;
				if (!data || !data.success) {
					breqPoState.items = [];
					notify('ค้นหาไม่สำเร็จ', (data && data.message) ? data.message : 'ไม่สามารถค้นหารายการ PO ได้', 'error');
				} else {
					breqPoState.items = data.items || [];
				}
				breqPoState.selectedIndex = -1;
				renderRows();
			})
			.catch(function() {
				breqPoState.loading = false;
				breqPoState.items = [];
				breqPoState.selectedIndex = -1;
				renderRows();
				notify('เชื่อมต่อไม่สำเร็จ', 'ไม่สามารถค้นหารายการ PO ได้ กรุณาลองใหม่อีกครั้ง', 'error');
			});
	}

	window.breqSelectPoRow = function(index) {
		var lockedPoNo = getLockedPoNo();
		var item = breqPoState.items[index];
		if (!item || rowIsDisabled(item, lockedPoNo)) return;
		breqPoState.selectedIndex = index;
		renderRows();
	};

	window.breqOpenPoModal = function() {
		var modal = document.getElementById('breqPoModal');
		if (!modal) return;
		modal.style.display = 'flex';
		modal.setAttribute('aria-hidden', 'false');

		breqPoState.selectedIndex = -1;
		renderLockNote();

		var search = document.getElementById('breqPoModalSearch');
		if (search) search.value = '';
		fetchItems('');

		setTimeout(function() {
			if (search) search.focus();
		}, 50);
	};

	window.breqClosePoModal = function() {
		var modal = document.getElementById('breqPoModal');
		if (!modal) return;
		modal.style.display = 'none';
		modal.setAttribute('aria-hidden', 'true');
	};

	window.breqConfirmPoModal = function() {
		var item = breqPoState.items[breqPoState.selectedIndex];
		if (!item) {
			notify('แจ้งเตือน', 'กรุณาเลือกรายการสินค้าก่อน', 'warning');
			return;
		}

		var added = window.breqAddItemRow ? window.breqAddItemRow(item) : false;
		if (!added) {
			notify('มีรายการนี้อยู่แล้ว', 'สินค้าและ Lot เดียวกันถูกเพิ่มไว้ในตารางแล้ว กรุณาเลือกรายการอื่น', 'warning');
			return;
		}

		// ล็อก PO ของเอกสารไว้กับแถวแรกที่เพิ่ม (มติ Q21=ก) — in__br.po_no เป็นคอลัมน์เดี่ยว
		var poNoField = document.getElementById('po_no');
		var refIdStockField = document.getElementById('ref_id_stock');
		if (poNoField && poNoField.value.trim() === '') {
			poNoField.value = item.po_no;
		}
		if (refIdStockField && refIdStockField.value.trim() === '') {
			refIdStockField.value = item.ref_id;
		}

		var display = document.getElementById('breq_po_display');
		if (display && poNoField) {
			display.textContent = poNoField.value;
		}

		window.breqClosePoModal();
	};

	document.addEventListener('DOMContentLoaded', function() {
		var search = document.getElementById('breqPoModalSearch');
		if (search) {
			search.addEventListener('input', function() {
				clearTimeout(breqPoState.searchTimer);
				var keyword = search.value;
				breqPoState.searchTimer = setTimeout(function() {
					fetchItems(keyword);
				}, 250);
			});
		}
	});
})();
