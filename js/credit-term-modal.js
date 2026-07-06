(function() {
	var creditTermState = {
		billId: '',
		loading: false,
		savingRefIdOff: '',
		summary: null,
		debts: [],
		tracksByRefId: {},
		draftsByRefId: {},
		selectedRefIdOff: '',
		expandedRefIdOff: ''
	};

	function getElement(id) {
		return document.getElementById(id);
	}

	function escapeHtml(value) {
		return String(value === undefined || value === null ? '' : value)
			.replace(/&/g, '&amp;')
			.replace(/</g, '&lt;')
			.replace(/>/g, '&gt;')
			.replace(/"/g, '&quot;')
			.replace(/'/g, '&#39;');
	}

	function formatMoney(value) {
		var number = Number(value || 0);
		if (!isFinite(number)) {
			number = 0;
		}
		return number.toLocaleString('en-US', {
			minimumFractionDigits: 2,
			maximumFractionDigits: 2
		});
	}

	function padDatePart(value) {
		var normalized = String(value === undefined || value === null ? '' : value).trim();
		return normalized.length >= 2 ? normalized : ('0' + normalized).slice(-2);
	}

	function formatTrackDateFromParts(yearValue, monthValue, dayValue) {
		var yearNumber = Number(yearValue);
		if (!isFinite(yearNumber)) {
			return '';
		}
		if (yearNumber < 2400) {
			yearNumber += 543;
		}
		return padDatePart(dayValue) + '/' + padDatePart(monthValue) + '/' + padDatePart(yearNumber % 100);
	}

	function formatTrackDate(value) {
		var raw = String(value === undefined || value === null ? '' : value).trim();
		if (raw === '') {
			return '-';
		}

		var datePart = raw.split(/[T ]/)[0];
		var dashMatch = datePart.match(/^(\d{4})-(\d{1,2})-(\d{1,2})$/);
		if (dashMatch) {
			return formatTrackDateFromParts(dashMatch[1], dashMatch[2], dashMatch[3]);
		}

		var slashIsoMatch = datePart.match(/^(\d{4})\/(\d{1,2})\/(\d{1,2})$/);
		if (slashIsoMatch) {
			return formatTrackDateFromParts(slashIsoMatch[1], slashIsoMatch[2], slashIsoMatch[3]);
		}

		var slashMatch = datePart.match(/^(\d{1,2})\/(\d{1,2})\/(\d{2,4})$/);
		if (slashMatch) {
			var yearNumber = Number(slashMatch[3]);
			if (slashMatch[3].length === 4 && yearNumber < 2400) {
				yearNumber += 543;
			}
			return padDatePart(slashMatch[1]) + '/' + padDatePart(slashMatch[2]) + '/' + padDatePart(yearNumber % 100);
		}

		return raw;
	}

	function getCurrentBillId() {
		var hidden = getElement('h_bill_id');
		var visible = getElement('bill_id');
		return String((hidden && hidden.value) || (visible && visible.value) || '').trim();
	}

	function getTrackInputId(refIdOff) {
		return 'creditTermTrackInput_' + String(refIdOff || '').replace(/[^a-zA-Z0-9_-]/g, '_');
	}

	function getTrackClearButtonId(refIdOff) {
		return 'creditTermTrackClear_' + String(refIdOff || '').replace(/[^a-zA-Z0-9_-]/g, '_');
	}

	function getTrackDraftValue(refIdOff) {
		return String(creditTermState.draftsByRefId[String(refIdOff || '')] || '');
	}

	function setTrackDraftValue(refIdOff, value) {
		var normalizedRefIdOff = String(refIdOff || '');
		if (normalizedRefIdOff === '') {
			return;
		}
		creditTermState.draftsByRefId[normalizedRefIdOff] = String(value === undefined || value === null ? '' : value);
	}

	function clearTrackDraftValue(refIdOff) {
		delete creditTermState.draftsByRefId[String(refIdOff || '')];
	}

	function findDebtByRefId(refIdOff) {
		var target = String(refIdOff || '');
		for (var i = 0; i < creditTermState.debts.length; i++) {
			if (String((creditTermState.debts[i] || {}).id_off || '') === target) {
				return creditTermState.debts[i];
			}
		}
		return null;
	}

	function findDebtFromList(debts, refIdOff) {
		var target = String(refIdOff || '');
		for (var i = 0; i < debts.length; i++) {
			if (String((debts[i] || {}).id_off || '') === target) {
				return debts[i];
			}
		}
		return null;
	}

	function isDebtExpanded(refIdOff) {
		return String(creditTermState.expandedRefIdOff || '') === String(refIdOff || '');
	}

	function updateSummaryValues(summary) {
		var safeSummary = summary || {};
		var creditDay = String(safeSummary.credit_day || '').trim();

		getElement('creditTermSummaryDay').textContent = creditDay !== '' ? creditDay : '-';
		getElement('creditTermSummaryAmount').textContent = formatMoney(safeSummary.credit_amount || 0);
		getElement('creditTermSummaryOutstanding').textContent = formatMoney(safeSummary.total_outstanding || 0);
		getElement('creditTermSummaryRemaining').textContent = formatMoney(safeSummary.remaining_credit || 0);
	}

	function buildTrackRowsHtml(tracks) {
		var html = '<div class="credit-term-inline-rows">';

		if (!tracks.length) {
			html += '<div class="credit-term-inline-data-row is-empty">'
				+ '<div class="credit-term-inline-row-text">ยังไม่มีประวัติการติดตาม</div>'
				+ '<div class="credit-term-inline-row-text">กรอกข้อมูลด้านล่างเพื่อเพิ่มการติดตามรายการนี้</div>'
				+ '<div class="credit-term-inline-row-text">ยังไม่มีชื่อผู้ติดตาม</div>'
				+ '</div>';
		} else {
			for (var i = 0; i < tracks.length; i++) {
				var track = tracks[i] || {};
				html += '<div class="credit-term-inline-data-row">'
					+ '<div class="credit-term-inline-row-text">' + escapeHtml(formatTrackDate(track.add_date || '')) + '</div>'
					+ '<div class="credit-term-inline-row-text">' + escapeHtml(track.des_track || '-') + '</div>'
					+ '<div class="credit-term-inline-row-text">' + escapeHtml(track.add_by || '-') + '</div>'
					+ '</div>';
			}
		}

		html += '</div>';
		return html;
	}

	function renderSubrow(debt) {
		var refIdOff = String((debt && debt.id_off) || '');
		var tracks = creditTermState.tracksByRefId[refIdOff] || [];
		var inputId = getTrackInputId(refIdOff);
		var clearButtonId = getTrackClearButtonId(refIdOff);
		var isSaving = creditTermState.savingRefIdOff === refIdOff;
		var draftValue = getTrackDraftValue(refIdOff);
		var hasDraftValue = draftValue.trim() !== '';
		var productNames = String((debt && debt.product_names) || '').trim();

		return '<tr class="credit-term-subrow">'
			+ '<td colspan="6">'
			+ '<div class="credit-term-inline-panel">'
			+ '<div class="credit-term-inline-summary-row">'
			+ '<div class="credit-term-inline-summary-caret"><span class="credit-term-caret" aria-hidden="true"></span></div>'
			+ '<div class="credit-term-inline-summary-cell">' + escapeHtml(debt.IV_number || '-') + '</div>'
			+ '<div class="credit-term-inline-summary-cell">' + escapeHtml(productNames !== '' ? productNames : '-') + '</div>'
			+ '<div class="credit-term-inline-summary-cell is-number">' + formatMoney(debt.unit_cash || 0) + '</div>'
			+ '<div class="credit-term-inline-summary-cell is-number">' + formatMoney(debt.paid_amount || 0) + '</div>'
			+ '<div class="credit-term-inline-summary-cell is-number">' + formatMoney(debt.balance_amount || 0) + '</div>'
			+ '</div>'
			+ '<div class="credit-term-inline-detail">'
			+ '<div class="credit-term-inline-label-row">'
			+ '<p class="credit-term-inline-title">วันที่ติดตาม</p>'
			+ '<p class="credit-term-inline-title">การติดตาม</p>'
			+ '<p class="credit-term-inline-title">ชื่อผู้ติดตาม</p>'
			+ '</div>'
			+ buildTrackRowsHtml(tracks)
			+ '<div class="credit-term-inline-compose-row">'
			+ '<div></div>'
			+ '<div class="credit-term-inline-compose-field">'
			+ '<div class="credit-term-inline-input-shell' + (isSaving ? ' is-disabled' : '') + '">'
			+ '<input type="text" id="' + inputId + '" class="credit-term-textarea credit-term-inline-input" data-ref-id-off="' + escapeHtml(refIdOff) + '" value="' + escapeHtml(draftValue) + '" placeholder="กรอกข้อมูลการติดตามสำหรับใบสั่งขาย ' + escapeHtml(debt.IV_number || '') + '"' + (isSaving ? ' disabled' : '') + '>'
			+ '<button type="button" id="' + clearButtonId + '" class="credit-term-inline-clear-btn' + (hasDraftValue ? '' : ' is-hidden') + '" aria-label="ล้างข้อความการติดตาม" onclick="clearCreditTermTrackInput(\'' + escapeHtml(refIdOff) + '\')"' + (isSaving ? ' disabled' : '') + '><i class="fas fa-times" aria-hidden="true"></i></button>'
			+ '</div>'
			+ '</div>'
			+ '<div class="credit-term-actions">'
			+ '<button type="button" class="credit-term-save-btn" onclick="saveCreditTermTrack(\'' + escapeHtml(refIdOff) + '\')"' + (isSaving ? ' disabled' : '') + '>' + (isSaving ? 'กำลังบันทึก...' : 'บันทึก') + '</button>'
			+ '</div>'
			+ '</div>'
			+ '</div>'
			+ '</div>'
			+ '</td>'
			+ '</tr>';
	}

	function renderDebtRows(message) {
		var tableBody = getElement('creditTermTableBody');
		if (!tableBody) {
			return;
		}

		if (message) {
			tableBody.innerHTML = '<tr class="credit-term-empty-row"><td><span class="credit-term-caret" aria-hidden="true"></span></td><td colspan="5">' + escapeHtml(message) + '</td></tr>';
			return;
		}

		if (!creditTermState.debts.length) {
			tableBody.innerHTML = '<tr class="credit-term-empty-row"><td><span class="credit-term-caret" aria-hidden="true"></span></td><td colspan="5">ไม่พบรายการหนี้คงค้าง</td></tr>';
			return;
		}

		var html = '';
		for (var i = 0; i < creditTermState.debts.length; i++) {
			var debt = creditTermState.debts[i] || {};
			var refIdOff = String(debt.id_off || '');
			var isSelected = refIdOff === String(creditTermState.selectedRefIdOff || '');
			var isExpanded = isDebtExpanded(refIdOff);
			var productNames = String(debt.product_names || '').trim();
			var trackCount = Number(debt.track_count || 0);
			var countHtml = trackCount > 0 ? '<span class="credit-term-track-count">' + trackCount + ' รายการ</span>' : '<span class="credit-term-track-count">ยังไม่มี</span>';

			html += '<tr class="' + (isSelected ? 'credit-term-row-selected' : '') + '" onclick="selectCreditTermDebt(\'' + escapeHtml(refIdOff) + '\')">';
			html += '<td><button type="button" class="credit-term-row-btn ' + (isSelected ? 'is-selected ' : '') + (isExpanded ? 'is-expanded' : '') + '" aria-label="สลับรายละเอียดติดตาม" aria-expanded="' + (isExpanded ? 'true' : 'false') + '" onclick="toggleCreditTermDebt(\'' + escapeHtml(refIdOff) + '\'); event.stopPropagation();"><span class="credit-term-caret" aria-hidden="true"></span></button></td>';
			html += '<td>' + escapeHtml(debt.IV_number || '-') + '<br>' + countHtml + '</td>';
			html += '<td>' + escapeHtml(productNames !== '' ? productNames : '-') + '</td>';
			html += '<td>' + formatMoney(debt.unit_cash || 0) + '</td>';
			html += '<td>' + formatMoney(debt.paid_amount || 0) + '</td>';
			html += '<td>' + formatMoney(debt.balance_amount || 0) + '</td>';
			html += '</tr>';

			if (isExpanded) {
				html += renderSubrow(debt);
			}
		}

		tableBody.innerHTML = html;
	}

	function updateTrackClearButton(refIdOff) {
		var input = getElement(getTrackInputId(refIdOff));
		var clearButton = getElement(getTrackClearButtonId(refIdOff));
		if (!input || !clearButton) {
			return;
		}

		var hasValue = String(input.value || '').trim() !== '';
		clearButton.classList.toggle('is-hidden', !hasValue);
		clearButton.disabled = input.disabled;
	}

	function clearTrackInput(refIdOff) {
		var normalizedRefIdOff = String(refIdOff || '');
		var input = getElement(getTrackInputId(normalizedRefIdOff));
		if (!input || input.disabled) {
			return;
		}

		input.value = '';
		setTrackDraftValue(normalizedRefIdOff, '');
		updateTrackClearButton(normalizedRefIdOff);
		input.focus();
	}

	function setSelectedDebt(refIdOff) {
		if (!findDebtByRefId(refIdOff)) {
			return;
		}
		creditTermState.selectedRefIdOff = String(refIdOff || '');
		renderDebtRows();
	}

	function toggleDebtExpansion(refIdOff) {
		if (!findDebtByRefId(refIdOff)) {
			return;
		}

		var normalizedRefIdOff = String(refIdOff || '');
		creditTermState.selectedRefIdOff = normalizedRefIdOff;
		creditTermState.expandedRefIdOff = isDebtExpanded(normalizedRefIdOff) ? '' : normalizedRefIdOff;
		renderDebtRows();
	}

	function loadCreditTermModalData(options) {
		var modal = getElement('creditTermPopupModal');
		var billId = getCurrentBillId();
		var preserveSelected = options && options.preserveSelected;
		var previousSelected = preserveSelected ? creditTermState.selectedRefIdOff : '';

		if (!modal || billId === '') {
			renderDebtRows('ไม่พบข้อมูลลูกค้าที่ใช้ตรวจสอบเครดิตเทอม');
			return;
		}

		creditTermState.loading = true;
		creditTermState.billId = billId;
		creditTermState.expandedRefIdOff = '';
		creditTermState.savingRefIdOff = '';
		creditTermState.draftsByRefId = {};
		updateSummaryValues({
			credit_day: '-',
			credit_amount: 0,
			total_outstanding: 0,
			remaining_credit: 0
		});
		renderDebtRows('กำลังโหลดข้อมูลเครดิตเทอม...');

		fetch('ajax_credit_term_modal.php?bill_id=' + encodeURIComponent(billId), {
			credentials: 'same-origin',
			cache: 'no-store'
		})
			.then(function(response) {
				if (!response.ok) {
					throw new Error('ไม่สามารถโหลดข้อมูลเครดิตเทอมได้');
				}
				return response.json();
			})
			.then(function(data) {
				if (!data || !data.success) {
					throw new Error((data && data.message) ? data.message : 'ไม่สามารถโหลดข้อมูลเครดิตเทอมได้');
				}

				creditTermState.summary = data.summary || null;
				creditTermState.debts = Array.isArray(data.debts) ? data.debts : [];
				creditTermState.tracksByRefId = data.tracks || {};

				var nextSelected = '';
				if (previousSelected && findDebtFromList(creditTermState.debts, previousSelected)) {
					nextSelected = previousSelected;
				} else if (data.selected_ref_id_off) {
					nextSelected = String(data.selected_ref_id_off);
				} else if (creditTermState.debts.length) {
					nextSelected = String(creditTermState.debts[0].id_off || '');
				}

				creditTermState.selectedRefIdOff = nextSelected;
				updateSummaryValues(creditTermState.summary);
				renderDebtRows();
			})
			.catch(function(error) {
				renderDebtRows(error && error.message ? error.message : 'ไม่สามารถโหลดข้อมูลเครดิตเทอมได้');
			})
			.finally(function() {
				creditTermState.loading = false;
			});
	}

	function saveCreditTermTrack(refIdOff) {
		var normalizedRefIdOff = String(refIdOff || creditTermState.selectedRefIdOff || '');
		var input = getElement(getTrackInputId(normalizedRefIdOff));
		var description = input ? String(input.value || '').trim() : '';
		var saveFailed = false;

		if (normalizedRefIdOff === '') {
			alert('กรุณาเลือกรายการหนี้ก่อนบันทึกการติดตาม');
			return;
		}

		if (description === '') {
			alert('กรุณากรอกข้อมูลการติดตาม');
			if (input) {
				input.focus();
			}
			return;
		}

		creditTermState.savingRefIdOff = normalizedRefIdOff;
		creditTermState.selectedRefIdOff = normalizedRefIdOff;
		creditTermState.expandedRefIdOff = normalizedRefIdOff;
		setTrackDraftValue(normalizedRefIdOff, description);
		renderDebtRows();
		input = getElement(getTrackInputId(normalizedRefIdOff));
		if (input) {
			input.value = description;
			updateTrackClearButton(normalizedRefIdOff);
		}

		fetch('ajax_credit_term_track_save.php', {
			method: 'POST',
			credentials: 'same-origin',
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
			},
			body: 'ref_id_off=' + encodeURIComponent(normalizedRefIdOff) + '&des_track=' + encodeURIComponent(description)
		})
			.then(function(response) {
				return response.json()
					.catch(function() {
						return null;
					})
					.then(function(data) {
						if (!response.ok) {
							throw new Error((data && data.message) ? data.message : 'ไม่สามารถบันทึกการติดตามได้');
						}
						return data;
					});
			})
			.then(function(data) {
				if (!data || !data.success) {
					throw new Error((data && data.message) ? data.message : 'ไม่สามารถบันทึกการติดตามได้');
				}

				creditTermState.tracksByRefId[normalizedRefIdOff] = Array.isArray(data.tracks) ? data.tracks : [];
				creditTermState.expandedRefIdOff = normalizedRefIdOff;
				clearTrackDraftValue(normalizedRefIdOff);

				var debt = findDebtByRefId(normalizedRefIdOff);
				if (debt) {
					debt.track_count = Number(data.track_count || creditTermState.tracksByRefId[normalizedRefIdOff].length || 0);
				}
			})
			.catch(function(error) {
				saveFailed = true;
				alert(error && error.message ? error.message : 'ไม่สามารถบันทึกการติดตามได้');
			})
			.finally(function() {
				creditTermState.savingRefIdOff = '';
				renderDebtRows();
				var finalInput = getElement(getTrackInputId(normalizedRefIdOff));
				if (finalInput) {
					if (saveFailed) {
						finalInput.value = description;
						updateTrackClearButton(normalizedRefIdOff);
					}
					finalInput.focus();
				}
			});
	}

	window.selectCreditTermDebt = function(refIdOff) {
		setSelectedDebt(refIdOff);
	};

	window.toggleCreditTermDebt = function(refIdOff) {
		toggleDebtExpansion(refIdOff);
	};

	window.clearCreditTermTrackInput = function(refIdOff) {
		clearTrackInput(refIdOff);
	};

	window.saveCreditTermTrack = saveCreditTermTrack;
	window.loadCreditTermModalData = loadCreditTermModalData;

	window.openCreditTermPopup = function() {
		var modal = getElement('creditTermPopupModal');
		var trigger = getElement('display_credit_thb_trigger');
		if (!modal || !trigger || trigger.disabled) {
			return;
		}

		modal.style.display = 'flex';
		modal.setAttribute('aria-hidden', 'false');
		loadCreditTermModalData();
	};

	window.closeCreditTermPopup = function() {
		var modal = getElement('creditTermPopupModal');
		if (!modal) {
			return;
		}

		modal.style.display = 'none';
		modal.setAttribute('aria-hidden', 'true');
	};

	document.addEventListener('DOMContentLoaded', function() {
		updateSummaryValues({
			credit_day: '-',
			credit_amount: 0,
			total_outstanding: 0,
			remaining_credit: 0
		});
		renderDebtRows('เลือกลูกค้าแล้วกดเปิดเครดิตเทอมเพื่อดูข้อมูล');

		document.addEventListener('input', function(event) {
			var target = event.target;
			if (!target || !target.classList || !target.classList.contains('credit-term-inline-input')) {
				return;
			}
			var refIdOff = target.getAttribute('data-ref-id-off') || '';
			setTrackDraftValue(refIdOff, target.value || '');
			updateTrackClearButton(refIdOff);
		});
	});
})();
