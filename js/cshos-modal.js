(function() {
	var cshosState = {
		billId: '',
		loading: false,
		summary: null,
		cshosLoans: [],
		debts: [],
		tracks: {},
		activeTab: 'cshos',
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

	function formatDate(value) {
		var raw = String(value === undefined || value === null ? '' : value).trim();
		if (raw === '' || raw === '0000-00-00') {
			return '-';
		}
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

	function getTodayIso() {
		var now = new Date();
		var month = ('0' + (now.getMonth() + 1)).slice(-2);
		var day = ('0' + now.getDate()).slice(-2);
		return now.getFullYear() + '-' + month + '-' + day;
	}

	function getCurrentBillId() {
		var hidden = getElement('h_bill_id');
		var visible = getElement('bill_id');
		var customerIdInput = getElement('customer_id');
		var displayBillId = getElement('display_bill_id');
		return String(
			(hidden && hidden.value) ||
			(visible && visible.value) ||
			(customerIdInput && customerIdInput.value) ||
			(displayBillId && (displayBillId.textContent || displayBillId.innerText)) ||
			''
		).trim();
	}

	function renderStatBar() {
		var bar = getElement('cshosStatBar');
		if (!bar) return;

		var summary = cshosState.summary || {};
		var items;

		if (cshosState.activeTab === 'debts') {
			items = [
				{ label: 'ยอดฝากขาย', value: formatMoney(summary.total_cshos_amount) },
				{ label: 'ยอดขายแล้ว', value: formatMoney(summary.total_cshos_sold) },
				{ label: 'วงเงิน', value: formatMoney(summary.credit_amount) },
				{ label: 'ยอดคงค้าง', value: formatMoney(summary.total_outstanding) }
			];
		} else {
			items = [
				{ label: 'ยอดฝากขาย', value: formatMoney(summary.total_cshos_amount) },
				{ label: 'ยอดขายแล้ว', value: formatMoney(summary.total_cshos_sold) },
				{ label: 'ยอดคงค้าง', value: formatMoney(summary.total_cshos_outstanding) }
			];
		}

		bar.style.gridTemplateColumns = 'repeat(' + items.length + ', 1fr)';
		bar.innerHTML = items.map(function(item) {
			return '<div class="cshos-stat-item">' +
				'<p class="cshos-stat-label">' + escapeHtml(item.label) + '</p>' +
				'<p class="cshos-stat-value">' + item.value + '</p>' +
				'</div>';
		}).join('');
	}

	function renderCshosTab() {
		var tbody = getElement('cshosTableBody');
		if (!tbody) return;

		if (cshosState.loading) {
			tbody.innerHTML = '<tr><td colspan="4" class="cshos-empty-row"><i class="fas fa-spinner fa-spin"></i> กำลังโหลดข้อมูลใบยืมฝากขาย...</td></tr>';
			return;
		}

		var loans = cshosState.cshosLoans || [];
		if (loans.length === 0) {
			tbody.innerHTML = '<tr><td colspan="4" class="cshos-empty-row">ไม่พบรายการใบยืมฝากขายสำหรับลูกค้ารายนี้</td></tr>';
			return;
		}

		var html = '';
		loans.forEach(function(item) {
			var products = item.product_names || [];
			var productsHtml = products.length
				? products.map(function(name) {
					return '<div class="cshos-product-line">' + escapeHtml(name) + '</div>';
				}).join('')
				: '<div class="cshos-product-line">-</div>';

			html += '<tr>' +
				'<td><a class="cshos-doc-link" href="register_supbrcshos.php?ref_id=' + encodeURIComponent(item.ref_id) + '" target="_blank" rel="noopener">' + escapeHtml(item.ref_id) + '</a></td>' +
				'<td>' + productsHtml + '</td>' +
				'<td style="text-align: right;">' + formatMoney(item.outstanding_qty).replace(/\.00$/, '') + '</td>' +
				'<td style="text-align: right; font-weight: 600;">' + formatMoney(item.outstanding_amount) + '</td>' +
				'</tr>';
		});

		tbody.innerHTML = html;
	}

	function renderDebtsTab() {
		var tbody = getElement('cshosDebtTableBody');
		if (!tbody) return;

		if (cshosState.loading) {
			tbody.innerHTML = '<tr><td colspan="6" class="cshos-empty-row"><i class="fas fa-spinner fa-spin"></i> กำลังโหลดข้อมูลยอดหนี้คงค้าง...</td></tr>';
			return;
		}

		var debts = cshosState.debts || [];
		if (debts.length === 0) {
			tbody.innerHTML = '<tr><td colspan="6" class="cshos-empty-row">ไม่พบรายการหนี้คงค้างสำหรับลูกค้ารายนี้</td></tr>';
			return;
		}

		var html = '';
		debts.forEach(function(debt) {
			var refIdOff = debt.id_off;
			var isExpanded = cshosState.expandedRefIdOff === refIdOff;
			var trackList = cshosState.tracks[refIdOff] || [];

			html += '<tr class="' + (isExpanded ? 'cshos-row-expanded' : '') + '">' +
				'<td>' +
					'<button type="button" class="cshos-caret-btn ' + (isExpanded ? 'is-expanded' : '') + '" onclick="window.toggleCshosTrackRow(\'' + escapeHtml(refIdOff) + '\')" title="ดูประวัติการติดตาม">' +
						'<span class="cshos-caret" aria-hidden="true"></span>' +
					'</button>' +
				'</td>' +
				'<td><strong>' + escapeHtml(debt.IV_number || debt.ref_id) + '</strong></td>' +
				'<td>' + escapeHtml(debt.product_names || '-') + '</td>' +
				'<td style="text-align: right;">' + formatMoney(debt.amount_due) + '</td>' +
				'<td style="text-align: right; color: #28A745;">' + formatMoney(debt.paid_amount) + '</td>' +
				'<td style="text-align: right; font-weight: 700; color: #DC3545;">' + formatMoney(debt.outstanding_amount) + '</td>' +
				'</tr>';

			if (isExpanded) {
				var rowsHtml = '';
				trackList.forEach(function(t) {
					rowsHtml += '<tr>' +
						'<td class="cshos-track-date">' + formatDate(t.add_date) + '</td>' +
						'<td>' + escapeHtml(t.des_track) + '</td>' +
						'<td class="cshos-track-by">' + escapeHtml(t.add_by) + '</td>' +
						'</tr>';
				});

				if (trackList.length === 0) {
					rowsHtml = '<tr><td colspan="3" class="cshos-track-empty">ยังไม่มีประวัติการติดตามหนี้</td></tr>';
				}

				var inputId = 'cshosTrackInput_' + escapeHtml(refIdOff);

				html += '<tr class="cshos-track-row">' +
					'<td colspan="6">' +
						'<div class="cshos-track-container">' +
							'<table class="cshos-track-table">' +
								'<thead><tr>' +
									'<th scope="col">วันที่ติดตาม</th>' +
									'<th scope="col">การติดตาม</th>' +
									'<th scope="col" class="cshos-track-col-by">ชื่อผู้ติดตาม</th>' +
								'</tr></thead>' +
								'<tbody>' + rowsHtml +
								'<tr>' +
									'<td class="cshos-track-date">' + formatDate(getTodayIso()) + '</td>' +
									'<td colspan="2" class="cshos-track-input-cell">' +
										'<div class="cshos-track-input-wrap">' +
											'<input type="text" id="' + inputId + '" class="cshos-track-input" placeholder="กรอกบันทึกการติดตามหนี้เพิ่มเติม..." oninput="window.onCshosTrackInputChange(\'' + escapeHtml(refIdOff) + '\')">' +
											'<button type="button" class="cshos-track-input-clear" onclick="window.clearCshosTrackInput(\'' + escapeHtml(refIdOff) + '\')" aria-label="ล้างข้อความ">&times;</button>' +
										'</div>' +
									'</td>' +
								'</tr>' +
								'</tbody>' +
							'</table>' +
							'<div class="cshos-track-actions">' +
								'<button type="button" class="cshos-track-save-btn" onclick="window.saveCshosDebtTrack(\'' + escapeHtml(refIdOff) + '\')">' +
									'<i class="fas fa-save" aria-hidden="true"></i> บันทึก' +
								'</button>' +
							'</div>' +
						'</div>' +
					'</td>' +
					'</tr>';
			}
		});

		tbody.innerHTML = html;
	}

	window.switchCshosTab = function(tabName) {
		cshosState.activeTab = tabName;

		var tabCshosContent = getElement('cshosTabContentCshos');
		var tabDebtsContent = getElement('cshosTabContentDebts');

		renderStatBar();

		if (tabName === 'cshos') {
			if (tabCshosContent) tabCshosContent.classList.add('is-active');
			if (tabDebtsContent) tabDebtsContent.classList.remove('is-active');
			renderCshosTab();
		} else {
			if (tabDebtsContent) tabDebtsContent.classList.add('is-active');
			if (tabCshosContent) tabCshosContent.classList.remove('is-active');
			renderDebtsTab();
		}
	};

	window.toggleCshosTrackRow = function(refIdOff) {
		if (cshosState.expandedRefIdOff === refIdOff) {
			cshosState.expandedRefIdOff = '';
		} else {
			cshosState.expandedRefIdOff = refIdOff;
		}
		renderDebtsTab();
	};

	window.onCshosTrackInputChange = function(refIdOff) {
		var input = getElement('cshosTrackInput_' + refIdOff);
		if (!input) return;
		var wrap = input.closest('.cshos-track-input-wrap');
		if (!wrap) return;
		wrap.classList.toggle('has-value', (input.value || '').trim() !== '');
	};

	window.clearCshosTrackInput = function(refIdOff) {
		var input = getElement('cshosTrackInput_' + refIdOff);
		if (!input) return;
		input.value = '';
		window.onCshosTrackInputChange(refIdOff);
		input.focus();
	};

	window.saveCshosDebtTrack = function(refIdOff) {
		var input = getElement('cshosTrackInput_' + refIdOff);
		if (!input) return;
		var desTrack = (input.value || '').trim();
		if (!desTrack) {
			alert('กรุณากรอกข้อมูลการติดตาม');
			return;
		}

		var formData = new FormData();
		formData.append('ref_id_off', refIdOff);
		formData.append('des_track', desTrack);

		fetch('ajax_credit_term_track_save.php', {
			method: 'POST',
			body: formData
		})
		.then(function(res) { return res.json(); })
		.then(function(data) {
			if (data.success) {
				cshosState.tracks[refIdOff] = data.tracks || [];
				renderDebtsTab();
			} else {
				alert(data.message || 'บันทึกการติดตามไม่สำเร็จ');
			}
		})
		.catch(function(err) {
			alert('เกิดข้อผิดพลาดในการเชื่อมต่อระบบบันทึกการติดตาม');
		});
	};

	window.openCshosPopup = function() {
		var billId = getCurrentBillId();
		if (!billId) {
			alert('กรุณาเลือกลูกค้าก่อนเปิดดูข้อมูลใบยืมฝากขาย/ยอดหนี้คงค้าง');
			return;
		}

		var modal = getElement('cshosPopupModal');
		if (modal) {
			modal.style.display = 'flex';
			modal.setAttribute('aria-hidden', 'false');
		}

		cshosState.billId = billId;
		cshosState.loading = true;
		window.switchCshosTab(cshosState.activeTab);

		fetch('ajax_cshos_modal.php?bill_id=' + encodeURIComponent(billId))
			.then(function(res) { return res.json(); })
			.then(function(data) {
				cshosState.loading = false;
				if (data.success) {
					cshosState.summary = data.summary || {};
					cshosState.cshosLoans = data.cshos_loans || [];
					cshosState.debts = data.debts || [];
					cshosState.tracks = data.tracks || {};
					window.switchCshosTab(cshosState.activeTab);
				} else {
					alert(data.message || 'ไม่สามารถโหลดข้อมูลได้');
				}
			})
			.catch(function(err) {
				cshosState.loading = false;
				alert('เกิดข้อผิดพลาดในการเชื่อมต่อข้อมูลใบยืมฝากขาย/ยอดหนี้คงค้าง');
			});
	};

	window.closeCshosPopup = function() {
		var modal = getElement('cshosPopupModal');
		if (modal) {
			modal.style.display = 'none';
			modal.setAttribute('aria-hidden', 'true');
		}
	};
})();
