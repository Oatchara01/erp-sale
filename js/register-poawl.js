/* หน้า register_poawl.php (ใบ PO) — ต้องโหลดหลัง product_salehos.php และ js/doc-tabs-attach.js
 * ใช้ฟังก์ชันของตารางสินค้า (productTableHasItems / productTableClearAll / productTableFillRows)
 * และ popup ลูกค้าจาก js/customer-popup.js
 */
(function() {
	'use strict';

	var config = window.poPageConfig || {};
	var busy = false; // กันกดซ้ำระหว่างรอบันทึก

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
			confirmButtonText: 'ตกลง',
			customClass: { htmlContainer: 'po-swal-multiline' }
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

	function byId(id) {
		return document.getElementById(id);
	}

	function setText(id, value) {
		var el = byId(id);
		if (el) el.textContent = (value === null || value === undefined || String(value).trim() === '') ? '-' : String(value);
	}

	function formatMoney(value) {
		var number = Number(value || 0);
		if (!isFinite(number)) number = 0;
		return number.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
	}

	function escapeHtml(value) {
		return String(value === undefined || value === null ? '' : value)
			.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
			.replace(/"/g, '&quot;').replace(/'/g, '&#39;');
	}

	function parseNumber(raw) {
		var text = String(raw === undefined || raw === null ? '' : raw).replace(/,/g, '').trim();
		if (text === '') return null;
		return /^-?\d+(\.\d+)?$/.test(text) ? parseFloat(text) : NaN;
	}

	/* ===================== ลูกค้า (ลำดับช่องตาม data_bill_name1.php เหมือน register_bregawl.php) ===================== */

	/* สถานะลูกค้า = "รหัสสมาชิก - เกรด" — status_cus: 0=Gold, 1=Platinum, 2=Diamond */
	function formatCustomerStatus(customerNo, statusCus) {
		var labels = { '0': 'Gold', '1': 'Platinum', '2': 'Diamond' };
		var label = labels[String(statusCus === undefined || statusCus === null ? '' : statusCus).trim()];
		if (!label) return '-';
		var no = String(customerNo === undefined || customerNo === null ? '' : customerNo).trim();
		return (no !== '' ? no : '-') + ' - ' + label;
	}

	function updateCreditTermTrigger(creditThb) {
		var raw = String(creditThb === undefined || creditThb === null ? '' : creditThb).trim();
		var amount = raw === '' ? NaN : Number(raw.replace(/,/g, ''));
		var hasCreditTerm = raw !== '' && !isNaN(amount);
		setText('display_credit_thb', hasCreditTerm ? formatMoney(amount) : '');
		var trigger = byId('display_credit_thb_trigger');
		if (trigger) {
			trigger.classList.toggle('is-empty', !hasCreditTerm);
			trigger.disabled = !hasCreditTerm;
			trigger.setAttribute('aria-disabled', hasCreditTerm ? 'false' : 'true');
		}
	}

	var customerRequestToken = 0;

	/* fillBillName: เลือกลูกค้าใหม่ = เติมชื่อออกบิลให้ (แก้ต่อได้) ; เปิดร่างเดิม = คงชื่อที่บันทึกไว้ */
	function loadCustomerDetail(customerId, fillBillName) {
		customerId = String(customerId || '').trim();
		if (customerId === '') return;
		var token = ++customerRequestToken;

		var request = new XMLHttpRequest();
		request.open('POST', 'data_bill_name1.php', true);
		request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		request.onreadystatechange = function() {
			if (request.readyState !== 4) return;
			if (token !== customerRequestToken) return; // เปลี่ยนลูกค้าไปแล้วระหว่างรอ

			if (request.status !== 200 || request.responseText.trim() === '') {
				notify('ไม่พบข้อมูลลูกค้า', 'ไม่พบรายละเอียดของรหัสลูกค้า ' + customerId, 'warning');
				updateCreditTermTrigger('');
				return;
			}

			var f = request.responseText.split('|');
			// 0 bill_name, 4 customer_no, 5 cus_tel, 22 ประเภทลูกค้า, 24 credit_thb, 25 vip_ckk, 26 customer_code, 28 status_cus
			setText('display_bill_id', f[26] || '');
			setText('display_bill_tel', f[5] || '');
			setText('display_customer_status', formatCustomerStatus(f[4], f[28]));
			setText('display_bill_name', f[0] || '');
			setText('display_customer_typename', f[22] || '');
			updateCreditTermTrigger(f[24] || '');

			var vipIcon = byId('display_vip_icon');
			if (vipIcon) vipIcon.style.display = (String(f[25]).trim() === '1') ? '' : 'none';

			var billName = byId('bill_name');
			if (billName && (fillBillName || billName.value.trim() === '')) {
				billName.value = f[0] || '';
			}
		};
		request.send('bill_id=' + encodeURIComponent(customerId));
	}

	window.customerPopupOnConfirm = function(selectedCustomer) {
		var customerId = String((selectedCustomer || {}).customer_id || '').trim();
		if (customerId === '') return;
		byId('bill_id').value = customerId;
		byId('h_bill_id').value = customerId;
		soClearFieldInvalid(byId('btn_open_customer'));
		loadCustomerDetail(customerId, true);
		var trigger = byId('btn_open_customer');
		if (trigger) trigger.focus();
	};

	/* ===================== เครดิตเทอม (อ่านอย่างเดียว) ===================== */
	var creditTermRequestToken = 0;

	function renderCreditTermDebts(debts, message) {
		var body = byId('poCreditTermTableBody');
		if (!body) return;
		if (message || !debts || debts.length === 0) {
			body.innerHTML = '<tr class="credit-term-empty-row"><td colspan="4">' + escapeHtml(message || 'ไม่พบรายการหนี้คงค้าง') + '</td></tr>';
			return;
		}
		body.innerHTML = debts.map(function(debt) {
			debt = debt || {};
			return '<tr><td>' + escapeHtml(debt.IV_number || '-') + '</td><td>' + formatMoney(debt.amount_due) +
				'</td><td>' + formatMoney(debt.paid_amount) + '</td><td>' + formatMoney(debt.outstanding_amount) + '</td></tr>';
		}).join('');
	}

	function openCreditTermModal() {
		var trigger = byId('display_credit_thb_trigger');
		var modal = byId('poCreditTermModal');
		var billId = String(byId('bill_id').value || '').trim();
		if (!trigger || trigger.disabled || !modal || billId === '') return;

		modal.style.display = 'flex';
		modal.setAttribute('aria-hidden', 'false');
		var closeBtn = modal.querySelector('.customer-popup-close');
		if (closeBtn) closeBtn.focus();

		var token = ++creditTermRequestToken;
		setText('poCreditSummaryDay', '-');
		setText('poCreditSummaryAmount', '0.00');
		setText('poCreditSummaryOutstanding', '0.00');
		setText('poCreditSummaryRemaining', '0.00');
		renderCreditTermDebts(null, 'กำลังโหลดข้อมูลเครดิตเทอม...');

		fetch('ajax_credit_term_modal.php?bill_id=' + encodeURIComponent(billId), { credentials: 'same-origin', cache: 'no-store' })
			.then(function(response) {
				if (!response.ok) throw new Error('ไม่สามารถโหลดข้อมูลเครดิตเทอมได้');
				return response.json();
			})
			.then(function(data) {
				if (token !== creditTermRequestToken) return;
				if (!data || !data.success) throw new Error((data && data.message) || 'ไม่สามารถโหลดข้อมูลเครดิตเทอมได้');
				var summary = data.summary || {};
				setText('poCreditSummaryDay', String(summary.credit_day || '').trim() !== '' ? summary.credit_day : '-');
				setText('poCreditSummaryAmount', formatMoney(summary.credit_amount));
				setText('poCreditSummaryOutstanding', formatMoney(summary.total_outstanding));
				setText('poCreditSummaryRemaining', formatMoney(summary.remaining_credit));
				renderCreditTermDebts(Array.isArray(data.debts) ? data.debts : []);
			})
			.catch(function(error) {
				if (token !== creditTermRequestToken) return;
				renderCreditTermDebts(null, error && error.message ? error.message : 'ไม่สามารถโหลดข้อมูลเครดิตเทอมได้');
			});
	}

	window.poCloseCreditTermModal = function() {
		var modal = byId('poCreditTermModal');
		if (!modal) return;
		modal.style.display = 'none';
		modal.setAttribute('aria-hidden', 'true');
		var trigger = byId('display_credit_thb_trigger');
		if (trigger && !trigger.disabled) trigger.focus();
	};

	/* ===================== บริษัท AWL/NBM — เปลี่ยนแล้วต้องล้างสินค้าทั้งหมด ===================== */
	function bindCompanySwitch() {
		var select = byId('type_doc_select');
		if (!select) return;
		select.setAttribute('data-prev', select.value);

		select.addEventListener('change', function() {
			var previous = select.getAttribute('data-prev');
			if (!productTableHasItems()) {
				select.setAttribute('data-prev', select.value);
				return;
			}
			var next = select.value;
			select.value = previous; // ค้างค่าเดิมไว้จนกว่าจะยืนยัน
			confirmDialog('เปลี่ยนบริษัท ?', 'การเปลี่ยนบริษัทจะล้างรายการสินค้าที่เลือกไว้ทั้งหมด เพื่อไม่ให้สินค้าต่างบริษัทปนกัน', 'ล้างรายการและเปลี่ยน')
				.then(function(confirmed) {
					if (!confirmed) {
						select.focus();
						return;
					}
					productTableClearAll();
					select.value = next;
					select.setAttribute('data-prev', next);
					select.focus();
				});
		});
	}

	/* ===================== Validation (ต้องตรงกับ po_validate_for_submit / po_normalize_items) ===================== */
	function collectFilledRows() {
		var rows = [];
		for (var i = 1; i <= (config.maxItems || 30); i++) {
			var productId = byId('product_id' + i);
			if (productId && String(productId.value).trim() !== '') rows.push(i);
		}
		return rows;
	}

	/* ดอกจันทุกตัวตรวจด้วย soValidateRequired() (js/so-required-fields.js) ได้กรอบแดงพร้อมกัน ไม่มี alert
	   ยกเว้นลูกค้า: ดอกจันอยู่บนปุ่ม #btn_open_customer (ไม่ใช่ .so-label) และค่าจริงคือ hidden bill_id ตัวตรวจกลางมองไม่เห็น
	   จึงมาร์กกรอบแดงที่ปุ่มเอง — ล้างเมื่อเลือกลูกค้าจาก popup (customerPopupOnConfirm) */
	function validateRequiredFields() {
		var form = document.forms.frmMain;
		var fieldsOk = soValidateRequired(form);
		var customerButton = byId('btn_open_customer');
		var customerMissing = form.bill_id.value.trim() === '';

		if (customerButton) {
			if (customerMissing) {
				soMarkFieldInvalid(customerButton);
				// ฟิลด์อื่นแดงอยู่ด้วย → ตัวตรวจกลางเลื่อนไปฟิลด์แรกให้แล้ว เลื่อนเองเฉพาะตอนมีแค่ลูกค้าที่ขาด
				if (fieldsOk) {
					customerButton.scrollIntoView({ block: 'center' });
					customerButton.focus({ preventScroll: true });
				}
			} else {
				soClearFieldInvalid(customerButton);
			}
		}
		return fieldsOk && !customerMissing;
	}

	function validateForSubmit() {
		if (!validateRequiredFields()) return { silent: true };

		var rows = collectFilledRows();
		if (rows.length === 0) {
			return { message: 'กรุณาเพิ่มรายการสินค้าอย่างน้อย 1 รายการ', field: byId('global_product_search') };
		}
		for (var r = 0; r < rows.length; r++) {
			var i = rows[r];
			var label = 'รายการที่ ' + (r + 1);
			var qty = parseNumber(byId('sale_count' + i).value);
			var price = parseNumber(byId('product_price' + i).value);
			var discount = parseNumber(byId('discount_unit' + i).value);
			if (qty === null || isNaN(qty) || qty <= 0) return { message: label + ': จำนวนต้องเป็นตัวเลขมากกว่า 0', field: byId('sale_count' + i) };
			if (price === null || isNaN(price) || price < 0) return { message: label + ': ราคา/หน่วยต้องเป็นตัวเลขตั้งแต่ 0 ขึ้นไป', field: byId('product_price' + i) };
			if (discount !== null && (isNaN(discount) || discount < 0)) return { message: label + ': ส่วนลด/หน่วยต้องเป็นตัวเลขตั้งแต่ 0 ขึ้นไป', field: byId('discount_unit' + i) };
			if (discount !== null && discount > price) return { message: label + ': ส่วนลด/หน่วยต้องไม่มากกว่าราคา/หน่วย', field: byId('discount_unit' + i) };
		}
		return null;
	}

	function focusField(field) {
		if (!field) return;
		if (typeof field.scrollIntoView === 'function') field.scrollIntoView({ behavior: 'smooth', block: 'center' });
		if (typeof field.focus === 'function') setTimeout(function() { field.focus(); }, 250);
	}

	/* ===================== บันทึก (Save Draft / Submit / ออกใบสั่งขาย) ===================== */
	var actionLabels = {
		draft: { busy: 'กำลังบันทึก...', fail: 'บันทึกร่างไม่สำเร็จ' },
		submit: { busy: 'กำลังส่ง...', fail: 'Submit ไม่สำเร็จ' },
		create_so: { busy: 'กำลังบันทึก...', fail: 'ออกใบสั่งขายไม่สำเร็จ' },
		update: { busy: 'กำลังบันทึก...', fail: 'อัปเดตไม่สำเร็จ' },
		return: { busy: 'กำลังส่งกลับ...', fail: 'ส่งกลับไม่สำเร็จ' },
		cancel: { busy: 'กำลังยกเลิก...', fail: 'ยกเลิกเอกสารไม่สำเร็จ' }
	};

	function setButtonsBusy(isBusy, activeButton) {
		var buttons = document.querySelectorAll('.po-action-btn');
		Array.prototype.forEach.call(buttons, function(button) {
			if (isBusy) {
				button.setAttribute('data-default-html', button.innerHTML);
				button.disabled = true;
			} else {
				button.disabled = false;
				if (button.hasAttribute('data-default-html')) button.innerHTML = button.getAttribute('data-default-html');
			}
		});
		if (isBusy && activeButton) {
			var action = activeButton.getAttribute('data-po-action');
			activeButton.innerHTML = '<i class="fas fa-spinner fa-spin" aria-hidden="true"></i> ' + actionLabels[action].busy;
		}
	}

	function send(action, button) {
		var formData = new FormData(document.forms.frmMain);
		formData.set('po_action', action);
		post(action, formData, button);
	}

	function post(action, formData, button) {
		busy = true;
		setButtonsBusy(true, button);

		fetch('register_posave1.php?po_action=' + encodeURIComponent(action), {
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

	window.poSave = function(action, button) {
		if (busy || !actionLabels[action]) return;

		if (action === 'draft') {
			if (!validateRequiredFields()) return;
			send(action, button);
			return;
		}

		var problem = validateForSubmit();
		if (problem) {
			if (problem.silent) return;
			notify('ข้อมูลไม่ครบถ้วน', problem.message, 'warning').then(function() { focusField(problem.field); });
			return;
		}

		// Update ใบจริง — ตรวจครบเหมือน Submit แต่บันทึกทันทีไม่ต้องยืนยัน
		if (action === 'update') {
			send(action, button);
			return;
		}

		var dialog = action === 'submit'
			? confirmDialog('ยืนยันส่งใบ PO ?', 'ใบ PO จะถูกส่งให้ Sale (ยังแก้ไขได้ด้วยปุ่ม Update จนกว่าจะออกใบสั่งขาย)', 'Submit')
			: confirmDialog('ออกใบสั่งขาย ?', 'ระบบจะบันทึกและส่งใบ PO นี้ แล้วเปิดหน้าออกใบสั่งขายพร้อมข้อมูลจาก PO', 'ออกใบสั่งขาย');
		dialog.then(function(confirmed) {
			if (confirmed && !busy) send(action, button);
		});
	};

	/* ===================== ส่งกลับ / ยกเลิกเอกสาร (popup เหตุผล — pattern soOpenReasonPopup ของ register_suphos.php) ===================== */
	function openReasonPopup(opts) {
		var refId = config.refId || '';
		if (typeof Swal === 'undefined') {
			var fallback = (window.prompt(opts.label) || '').trim();
			if (fallback !== '') opts.onConfirm(fallback);
			return;
		}
		Swal.fire({
			title: opts.title,
			html: '<p class="so-reason-subtitle">' + escapeHtml(opts.subtitleText + ' "' + refId + '"') + '</p>' +
				'<label class="so-reason-label">' + escapeHtml(opts.label) + '<span class="so-reason-required">*</span></label>',
			input: 'textarea',
			inputPlaceholder: opts.label,
			inputAttributes: { maxlength: '1000' },
			iconHtml: '<div class="so-reason-icon-circle" style="background:' + opts.iconBg + '"><img src="' + opts.iconSrc + '" alt="" style="width: 36px; height: 36px;"></div>',
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
			if (result.isConfirmed) opts.onConfirm(result.value);
		});
	}

	/* ส่งแค่ ref_id + เหตุผล ไม่ส่งข้อมูลฟอร์ม → ไม่ต้องผ่าน validation ของ Submit */
	function runReasonAction(action, button, popup) {
		if (busy) return;
		closeOverflowMenu();
		openReasonPopup(Object.assign({}, popup, {
			onConfirm: function(reason) {
				if (busy) return;
				var formData = new FormData();
				formData.set('po_action', action);
				formData.set('ref_id', config.refId || '');
				formData.set('reason', reason);
				post(action, formData, button);
			}
		}));
	}

	window.poReturnDocument = function(button) {
		runReasonAction('return', button, {
			title: 'ส่งกลับเอกสารนี้ ?',
			subtitleText: 'ส่งกลับใบ PO เลขที่',
			label: 'ระบุเหตุผลการส่งกลับ',
			iconBg: '#FFF4E5',
			iconSrc: 'img/icons/send_back.png'
		});
	};

	window.poCancelDocument = function(button) {
		runReasonAction('cancel', button, {
			title: 'ยกเลิกเอกสารนี้ ?',
			subtitleText: 'ต้องการยกเลิกใบ PO เลขที่',
			label: 'ระบุเหตุผลในการยกเลิก',
			iconBg: '#F4F5F7',
			iconSrc: 'img/icons/cancel_document.png'
		});
	};

	function closeOverflowMenu() {
		var menu = byId('poOverflowMenu');
		var trigger = byId('btn_po_overflow');
		if (menu) menu.hidden = true;
		if (trigger) trigger.setAttribute('aria-expanded', 'false');
	}

	window.poToggleOverflowMenu = function() {
		var menu = byId('poOverflowMenu');
		var trigger = byId('btn_po_overflow');
		if (!menu) return;
		var open = menu.hidden;
		menu.hidden = !open;
		if (trigger) trigger.setAttribute('aria-expanded', open ? 'true' : 'false');
		if (open) {
			var first = menu.querySelector('button');
			if (first) first.focus();
		}
	};

	/* ===================== แท็บ แนบไฟล์ / การส่งกลับเอกสาร ===================== */
	window.poSwitchTab = function(tab) {
		var targetId = tab.getAttribute('data-po-tab');
		Array.prototype.forEach.call(document.querySelectorAll('.po-attach-tabs .so-tab-btn'), function(button) {
			var isActive = (button === tab);
			button.classList.toggle('active', isActive);
			button.setAttribute('aria-selected', isActive ? 'true' : 'false');
		});
		Array.prototype.forEach.call(document.querySelectorAll('.po-tab-panel'), function(panel) {
			panel.hidden = (panel.id !== targetId);
		});
	};

	/* ===================== เริ่มต้นหน้า ===================== */
	document.addEventListener('DOMContentLoaded', function() {
		bindCompanySwitch();

		if (Array.isArray(config.savedItems) && config.savedItems.length > 0) {
			productTableFillRows(config.savedItems);
		}

		var billId = byId('bill_id');
		if (billId && billId.value.trim() !== '') {
			loadCustomerDetail(billId.value, false);
		}

		var creditTrigger = byId('display_credit_thb_trigger');
		if (creditTrigger) creditTrigger.addEventListener('click', openCreditTermModal);

		var creditModal = byId('poCreditTermModal');
		if (creditModal) {
			creditModal.addEventListener('click', function(event) {
				if (event.target === creditModal) window.poCloseCreditTermModal();
			});
		}

		document.addEventListener('click', function(event) {
			var wrap = document.querySelector('.po-overflow-wrap');
			if (wrap && !wrap.contains(event.target)) closeOverflowMenu();
		});

		document.addEventListener('keydown', function(event) {
			if (event.key !== 'Escape') return;
			var overflowMenu = byId('poOverflowMenu');
			if (overflowMenu && !overflowMenu.hidden) {
				closeOverflowMenu();
				var overflowTrigger = byId('btn_po_overflow');
				if (overflowTrigger) overflowTrigger.focus();
				return;
			}
			if (creditModal && creditModal.style.display === 'flex') {
				window.poCloseCreditTermModal();
				return;
			}
			var customerModal = byId('customerPopupModal');
			if (customerModal && customerModal.style.display === 'flex' && typeof closeCustomerPopup === 'function') {
				closeCustomerPopup();
				var trigger = byId('btn_open_customer');
				if (trigger) trigger.focus();
			}
		});
	});
})();
