(function() {
	// JavaScript State สำหรับจัดการ Popup ลูกค้า
	var customerPopupSelected = null;
	var customerPopupTimer = null;
	var customerPopupData = [];
	var customerPopupKeyword = '';
	var customerPopupNextLastId = null;
	var customerPopupHasMore = false;
	var customerPopupLoading = false;
	var customerPopupPageSize = 20;
	var customerPopupAbortController = null;
	var customerPopupRequestId = 0;

	// ฟังก์ชันควบคุมป๊อปอัปรายชื่อลูกค้า
	function openCustomerPopup() {
		var modal = document.getElementById('customerPopupModal');
		var search = document.getElementById('customerPopupSearch');
		if (!modal) return;

		modal.style.display = 'flex';
		modal.setAttribute('aria-hidden', 'false');
		customerPopupSelected = null;
		customerPopupData = [];
		customerPopupKeyword = search ? (search.value || '') : '';
		customerPopupNextLastId = null;
		customerPopupHasMore = false;
		toggleCustomerPopupLoadMore(false, false);

		loadCustomerPopupRows(customerPopupKeyword, false);
		setTimeout(function() {
			if (search) {
				search.focus();
				search.select();
			}
		}, 50);
	}

	function closeCustomerPopup() {
		var modal = document.getElementById('customerPopupModal');
		if (!modal) return;

		modal.style.display = 'none';
		modal.setAttribute('aria-hidden', 'true');
	}

	function toggleCustomerPopupLoadMore(visible, loading) {
		var wrap = document.getElementById('customerPopupPagination');
		var button = document.getElementById('customerPopupLoadMore');
		if (!wrap || !button) return;

		wrap.style.display = visible ? 'flex' : 'none';
		button.disabled = !!loading;
		button.textContent = loading ? 'กำลังโหลด...' : 'โหลดเพิ่ม';
	}

	function loadCustomerPopupRows(keyword, append) {
		var tbody = document.getElementById('customerPopupRows');
		if (append && customerPopupLoading) return;

		if (!append && customerPopupAbortController) {
			customerPopupAbortController.abort();
		}

		customerPopupAbortController = new AbortController();
		var requestController = customerPopupAbortController;
		var requestId = ++customerPopupRequestId;
		customerPopupLoading = true;

		if (!append && tbody) {
			tbody.innerHTML = '<tr><td colspan="4" class="customer-popup-empty">กำลังค้นหา...</td></tr>';
		}

		if (!append) {
			customerPopupSelected = null;
			customerPopupData = [];
			customerPopupNextLastId = null;
			customerPopupHasMore = false;
			customerPopupKeyword = keyword || '';
		}

		toggleCustomerPopupLoadMore(append || customerPopupHasMore, append);

		var requestUrl = 'ajax_customer_popup_search.php?q=' + encodeURIComponent(customerPopupKeyword || '') +
			'&limit=' + encodeURIComponent(customerPopupPageSize);

		if (append && customerPopupNextLastId) {
			requestUrl += '&last_id=' + encodeURIComponent(customerPopupNextLastId);
		}

		fetch(requestUrl, {
				credentials: 'same-origin',
				signal: requestController.signal
			})
			.then(function(response) {
				return response.json();
			})
			.then(function(data) {
				if (requestId !== customerPopupRequestId) return;

				if (!data || !data.success) {
					customerPopupData = [];
					customerPopupHasMore = false;
					customerPopupNextLastId = null;
					renderCustomerPopupRows([]);
					return;
				}

				var newCustomers = data.customers || [];
				customerPopupData = append ? customerPopupData.concat(newCustomers) : newCustomers;
				customerPopupHasMore = !!(data.pagination && data.pagination.has_more);
				customerPopupNextLastId = data.pagination ? data.pagination.next_last_id : null;
				renderCustomerPopupRows(customerPopupData);
			})
			.catch(function(error) {
				if (error && error.name === 'AbortError') return;
				if (requestId !== customerPopupRequestId) return;

				customerPopupHasMore = false;
				customerPopupNextLastId = null;
				if (tbody) {
					tbody.innerHTML = '<tr><td colspan="4" class="customer-popup-empty">ไม่สามารถค้นหาข้อมูลได้</td></tr>';
				}
				toggleCustomerPopupLoadMore(false, false);
			})
			.finally(function() {
				if (requestId !== customerPopupRequestId) return;

				customerPopupLoading = false;
				customerPopupAbortController = null;
				if (customerPopupHasMore) {
					toggleCustomerPopupLoadMore(true, false);
				}
			});
	}

	function escapeCustomerPopupHtml(value) {
		return String(value || '').replace(/[&<>"']/g, function(char) {
			return {
				'&': '&amp;',
				'<': '&lt;',
				'>': '&gt;',
				'"': '&quot;',
				"'": '&#039;'
			} [char];
		});
	}

	function renderCustomerPopupRows(customers) {
		var tbody = document.getElementById('customerPopupRows');
		if (!tbody) return;

		customers = customers || customerPopupData || [];

		if (!customers || customers.length === 0) {
			tbody.innerHTML = '<tr><td colspan="4" class="customer-popup-empty">ไม่พบข้อมูลลูกค้า</td></tr>';
			toggleCustomerPopupLoadMore(false, false);
			return;
		}

		tbody.innerHTML = customers.map(function(customer, index) {
			var name = customer.customer_name || customer.bill_name || '-';
			var tel = customer.cus_tel || '-';
			var address = customer.cus_address || '-';

			return '<tr data-index="' + index + '" onclick="selectCustomerPopupRow(' + index + ')">' +
				'<td><button type="button" class="customer-popup-name" onclick="event.stopPropagation(); selectCustomerPopupRow(' + index + ');">' + escapeCustomerPopupHtml(name) + '</button></td>' +
				'<td>' + escapeCustomerPopupHtml(tel) + '</td>' +
				'<td>' + escapeCustomerPopupHtml(address) + '</td>' +
				'<td><button type="button" class="customer-popup-name" onclick="event.stopPropagation(); openCustomerPopupEdit(' + index + ');"><img src="img/icons/edit.png" alt="แก้ไข" style="width:18px;height:18px;object-fit:contain;"></button></td>' +
				'</tr>';
		}).join('');

		customerPopupData = customers;

		if (customerPopupSelected && customerPopupSelected.customer_id) {
			var rows = document.querySelectorAll('#customerPopupRows tr');
			rows.forEach(function(row) {
				row.classList.remove('selected');
			});
			for (var i = 0; i < customerPopupData.length; i++) {
				if (String(customerPopupData[i].customer_id) === String(customerPopupSelected.customer_id)) {
					if (rows[i]) rows[i].classList.add('selected');
					break;
				}
			}
		}
	}

	// เปิดหน้าแก้ไขลูกค้าในแท็บใหม่
	function openCustomerPopupEdit(index) {
		var customer = (customerPopupData || [])[index];
		if (!customer || !customer.customer_id) {
			alert('ไม่พบรหัสลูกค้า');
			return;
		}
		window.open('customer_add.php?customer_id=' + encodeURIComponent(customer.customer_id), '_blank');
	}

	function loadMoreCustomerPopupRows() {
		if (!customerPopupHasMore || !customerPopupNextLastId) return;
		loadCustomerPopupRows(customerPopupKeyword, true);
	}

	function selectCustomerPopupRow(index) {
		var rows = document.querySelectorAll('#customerPopupRows tr');
		var customer = (customerPopupData || [])[index];
		if (!customer) return;

		rows.forEach(function(row) {
			row.classList.remove('selected');
		});
		if (rows[index]) rows[index].classList.add('selected');
		customerPopupSelected = customer;
	}

	function confirmCustomerPopupSelection() {
		if (!customerPopupSelected) {
			alert('กรุณาเลือกลูกค้าก่อน');
			return;
		}

		var selectedCustId = String(customerPopupSelected.customer_id || '').trim();
		if (!selectedCustId) {
			alert('ข้อมูลลูกค้าที่เลือกไม่มีรหัสลูกค้า');
			return;
		}

		if (typeof window.customerPopupOnConfirm === 'function') {
			window.customerPopupOnConfirm(customerPopupSelected);
		}

		closeCustomerPopup();
	}

	window.openCustomerPopup = openCustomerPopup;
	window.closeCustomerPopup = closeCustomerPopup;
	window.confirmCustomerPopupSelection = confirmCustomerPopupSelection;
	window.loadMoreCustomerPopupRows = loadMoreCustomerPopupRows;
	window.selectCustomerPopupRow = selectCustomerPopupRow;
	window.openCustomerPopupEdit = openCustomerPopupEdit;

	document.addEventListener('DOMContentLoaded', function() {
		var search = document.getElementById('customerPopupSearch');
		if (search) {
			search.addEventListener('input', function() {
				clearTimeout(customerPopupTimer);
				customerPopupTimer = setTimeout(function() {
					customerPopupSelected = null;
					loadCustomerPopupRows(search.value, false);
				}, 250);
			});
		}
	});
})();
