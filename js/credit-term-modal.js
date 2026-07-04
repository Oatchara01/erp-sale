(function() {
	var creditTermState = {
		billId: '',
		loading: false,
		saving: false,
		summary: null,
		debts: [],
		tracksByRefId: {},
		selectedRefIdOff: ''
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

	function getCurrentBillId() {
		logger.log('getCurrentBillId');
		var hidden = getElement('h_bill_id');
		var visible = getElement('bill_id');
		return String((hidden && hidden.value) || (visible && visible.value) || '').trim();
	}

	function findDebtByRefId(refIdOff) {
		var target = String(refIdOff || '');
		for (var i = 0; i < creditTermState.debts.length; i++) {
			if (String(creditTermState.debts[i].id_off) === target) {
				return creditTermState.debts[i];
			}
		}
		return null;
	}

	function updateSummaryValues(summary) {
		var safeSummary = summary || {};
		var creditDay = String(safeSummary.credit_day || '').trim();

		getElement('creditTermSummaryDay').textContent = creditDay !== '' ? creditDay : '-';
		getElement('creditTermSummaryAmount').textContent = formatMoney(safeSummary.credit_amount || 0);
		getElement('creditTermSummaryOutstanding').textContent = formatMoney(safeSummary.total_outstanding || 0);
		getElement('creditTermSummaryRemaining').textContent = formatMoney(safeSummary.remaining_credit || 0);
	}

	function renderTrackColumn(containerId, html) {
		var element = getElement(containerId);
		if (element) {
			element.innerHTML = html;
		}
	}

	function renderTrackDetails() {
		var selectedDebt = findDebtByRefId(creditTermState.selectedRefIdOff);
		var input = getElement('creditTermTrackInput');
		var button = getElement('creditTermTrackSaveButton');
		var selectedDoc = getElement('creditTermSelectedDoc');

		if (button) {
			button.disabled = creditTermState.saving || !selectedDebt;
			button.textContent = creditTermState.saving ? 'กําลังบันทึก...' : 'บันทึกการติดตาม';
		}

		if (!selectedDebt) {
			if (selectedDoc) {
				selectedDoc.textContent = 'เลือกรายการหนี้เพื่อดูรายละเอียดการติดตาม';
			}
			renderTrackColumn('creditTermTrackDateList', '<p class="credit-term-detail-empty">ยังไม่ได้เลือกรายการ</p>');
			renderTrackColumn('creditTermTrackDescList', '<p class="credit-term-detail-empty">เลือกรายการหนี้ทางด้านบนก่อน</p>');
			renderTrackColumn('creditTermTrackByList', '<p class="credit-term-detail-empty">ยังไม่มีข้อมูลผู้ติดตาม</p>');
			if (input) {
				input.disabled = true;
			}
			return;
		}

		if (selectedDoc) {
			selectedDoc.textContent = 'ใบสั่งขาย ' + (selectedDebt.IV_number || '-') + ' | ยอดหนี้คงค้าง ' + formatMoney(selectedDebt.balance_amount || 0) + ' บาท';
		}

		var tracks = creditTermState.tracksByRefId[String(selectedDebt.id_off)] || [];
		if (!tracks.length) {
			renderTrackColumn('creditTermTrackDateList', '<p class="credit-term-detail-empty">ยังไม่มีประวัติการติดตาม</p>');
			renderTrackColumn('creditTermTrackDescList', '<p class="credit-term-detail-empty">กรอกข้อมูลด้านล่างเพื่อเพิ่มการติดตามรายการนี้</p>');
			renderTrackColumn('creditTermTrackByList', '<p class="credit-term-detail-empty">ยังไม่มีชื่อผู้ติดตาม</p>');
		} else {
			var dateHtml = '';
			var descHtml = '';
			var byHtml = '';

			for (var i = 0; i < tracks.length; i++) {
				var track = tracks[i] || {};
				dateHtml += '<div class="credit-term-detail-item">' + escapeHtml(track.add_date || '-') + '</div>';
				descHtml += '<div class="credit-term-detail-item">' + escapeHtml(track.des_track || '-') + '</div>';
				byHtml += '<div class="credit-term-detail-item">' + escapeHtml(track.add_by || '-') + '</div>';
			}

			renderTrackColumn('creditTermTrackDateList', dateHtml);
			renderTrackColumn('creditTermTrackDescList', descHtml);
			renderTrackColumn('creditTermTrackByList', byHtml);
		}

		if (input) {
			input.disabled = false;
			input.placeholder = 'บันทึกข้อมูลการติดตามสำหรับใบสั่งขาย ' + (selectedDebt.IV_number || '');
		}
	}

	function renderDebtRows(message) {
		var tableBody = getElement('creditTermTableBody');
		if (!tableBody) {
			return;
		}

		if (message) {
			tableBody.innerHTML = '<tr class="credit-term-empty-row"><td><span class="credit-term-caret" aria-hidden="true"></span></td><td colspan="5">' + escapeHtml(message) + '</td></tr>';
			renderTrackDetails();
			return;
		}

		if (!creditTermState.debts.length) {
			tableBody.innerHTML = '<tr class="credit-term-empty-row"><td><span class="credit-term-caret" aria-hidden="true"></span></td><td colspan="5">ไม่พบรายการหนี้คงค้าง</td></tr>';
			renderTrackDetails();
			return;
		}

		var html = '';
		for (var i = 0; i < creditTermState.debts.length; i++) {
			var debt = creditTermState.debts[i] || {};
			var refIdOff = String(debt.id_off || '');
			var isSelected = refIdOff === String(creditTermState.selectedRefIdOff || '');
			var productNames = String(debt.product_names || '').trim();
			var trackCount = Number(debt.track_count || 0);
			var countHtml = trackCount > 0 ? '<span class="credit-term-track-count">' + trackCount + ' รายการ</span>' : '<span class="credit-term-track-count">ยังไม่มี</span>';

			html += '<tr class="' + (isSelected ? 'credit-term-row-selected' : '') + '" onclick="selectCreditTermDebt(\'' + escapeHtml(refIdOff) + '\')">';
			html += '<td><button type="button" class="credit-term-row-btn ' + (isSelected ? 'is-selected' : '') + '" onclick="selectCreditTermDebt(\'' + escapeHtml(refIdOff) + '\'); event.stopPropagation();"><span class="credit-term-caret" aria-hidden="true"></span></button></td>';
			html += '<td>' + escapeHtml(debt.IV_number || '-') + '<br>' + countHtml + '</td>';
			html += '<td>' + escapeHtml(productNames !== '' ? productNames : '-') + '</td>';
			html += '<td>' + formatMoney(debt.unit_cash || 0) + '</td>';
			html += '<td>' + formatMoney(debt.paid_amount || 0) + '</td>';
			html += '<td>' + formatMoney(debt.balance_amount || 0) + '</td>';
			html += '</tr>';
		}

		tableBody.innerHTML = html;
		renderTrackDetails();
	}

	function setSelectedDebt(refIdOff) {
		if (!findDebtByRefId(refIdOff)) {
			return;
		}
		creditTermState.selectedRefIdOff = String(refIdOff || '');
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
		updateSummaryValues({
			credit_day: '-',
			credit_amount: 0,
			total_outstanding: 0,
			remaining_credit: 0
		});
		renderDebtRows('กําลังโหลดข้อมูลเครดิตเทอม...');

		fetch('ajax_credit_term_modal.php?bill_id=' + encodeURIComponent(billId), {
			credentials: 'same-origin',
			cache: 'no-store'
		})
			.then(function(response) {
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

	function findDebtFromList(debts, refIdOff) {
		var target = String(refIdOff || '');
		for (var i = 0; i < debts.length; i++) {
			if (String((debts[i] || {}).id_off || '') === target) {
				return debts[i];
			}
		}
		return null;
	}

	function saveCreditTermTrack() {
		var input = getElement('creditTermTrackInput');
		var refIdOff = String(creditTermState.selectedRefIdOff || '');
		var description = input ? String(input.value || '').trim() : '';

		if (refIdOff === '') {
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

		creditTermState.saving = true;
		renderTrackDetails();

		fetch('ajax_credit_term_track_save.php', {
			method: 'POST',
			credentials: 'same-origin',
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
			},
			body: 'ref_id_off=' + encodeURIComponent(refIdOff) + '&des_track=' + encodeURIComponent(description)
		})
			.then(function(response) {
				return response.json();
			})
			.then(function(data) {
				if (!data || !data.success) {
					throw new Error((data && data.message) ? data.message : 'ไม่สามารถบันทึกการติดตามได้');
				}

				creditTermState.tracksByRefId[refIdOff] = Array.isArray(data.tracks) ? data.tracks : [];

				var debt = findDebtByRefId(refIdOff);
				if (debt) {
					debt.track_count = Number(data.track_count || creditTermState.tracksByRefId[refIdOff].length || 0);
				}

				if (input) {
					input.value = '';
				}

				renderDebtRows();
				if (input) {
					input.focus();
				}
			})
			.catch(function(error) {
				alert(error && error.message ? error.message : 'ไม่สามารถบันทึกการติดตามได้');
			})
			.finally(function() {
				creditTermState.saving = false;
				renderTrackDetails();
			});
	}

	window.selectCreditTermDebt = function(refIdOff) {
		setSelectedDebt(refIdOff);
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

		var input = getElement('creditTermTrackInput');
		if (input) {
			input.addEventListener('keydown', function(event) {
				if ((event.ctrlKey || event.metaKey) && event.key === 'Enter') {
					event.preventDefault();
					saveCreditTermTrack();
				}
			});
		}
	});
})();