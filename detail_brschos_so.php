<html>

<head>
	<link rel="stylesheet" href="css/autocomplete.css" type="text/css" />
	<link rel="stylesheet" href="css/so-product-search.css?v=<?php echo filemtime(__DIR__ . '/css/so-product-search.css'); ?>" type="text/css" />
	<script type="text/javascript" src="js/autocomplete.js"></script>
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/row-drag.js?v=<?php echo filemtime(__DIR__ . '/js/row-drag.js'); ?>"></script>
	<script type="text/javascript">
		/* โหลด SweetAlert2 เฉพาะตอนยังไม่มี (เผื่อหน้าแม่โหลดไว้แล้ว) - ตามแพทเทิร์นเดียวกับ
		   product_salehos.php ที่ใช้ Swal.fire() คอนเฟิร์มก่อนลบรายการอยู่แล้ว */
		if (typeof Swal === 'undefined') {
			var script = document.createElement('script');
			script.src = 'https://cdn.jsdelivr.net/npm/sweetalert2@11';
			document.head.appendChild(script);
		}
	</script>

</head>



<script language="JavaScript">
	function chkNumber(ele) {
		var vchar = String.fromCharCode(event.keyCode);
		if ((vchar < '0' || vchar > '9') && (vchar != '.')) return false;
		ele.onKeyPress = vchar;
	}

	/* ===== Drag-reorder + checkbox multi-select + bulk delete + Summary + Modal (Figma 627-2753 & 984-5469) ===== */
	var csFieldNames = ['product_codet', 'product_id', 'product_name', 'product_name_view', 'unit_name', 'sale_count', 'product_price', 'discount_unit', 'sum_amount', 'warranty', 'cal', 'pm', 'pm_year', 'sale_remarkk', 'sn'];
	var csActiveEditRowIndex = null;

	/* product_codet/product_name_view are plain <span> display tags (no .value), everything
	   else is a real form field - read/write through whichever the element actually supports. */
	function csGetFieldValue(el) {
		if (!el) {
			return '';
		}
		return ('value' in el) ? el.value : el.textContent;
	}

	function csSetFieldValue(el, val) {
		if (!el) {
			return;
		}
		if ('value' in el) {
			el.value = val || '';
		} else {
			el.textContent = val || '';
		}
	}

	function csGetRowData(i) {
		var data = {};
		csFieldNames.forEach(function(name) {
			data[name] = csGetFieldValue(document.getElementById(name + i));
		});
		return data;
	}

	function csSetRowData(i, data) {
		csFieldNames.forEach(function(name) {
			csSetFieldValue(document.getElementById(name + i), data[name]);
		});
		csUpdateRowVisibility();
	}

	function csShiftRows(fromIndex, toIndex) {
		if (fromIndex === toIndex) return;
		var rows = [];
		for (var i = 1; i <= 10; i++) {
			rows.push(csGetRowData(i));
		}
		var moved = rows.splice(fromIndex - 1, 1)[0];
		rows.splice(toIndex - 1, 0, moved);
		for (var j = 1; j <= 10; j++) {
			csSetRowData(j, rows[j - 1]);
		}
		csRecalcSummary();
	}

	/* ลากสลับแถว (js/row-drag.js — ลากได้ทั้งเมาส์และนิ้ว) */
	RowDrag.register({
		within: '#cs_product_table',
		row: 'tr.so-product-row',
		onDrop: function(fromRow, toRow) {
			csShiftRows(parseInt(fromRow.id.replace('cs_row', ''), 10), parseInt(toRow.id.replace('cs_row', ''), 10));
		}
	});

	function csToggleRowHighlight(checkbox, rowIndex) {
		var row = document.getElementById('cs_row' + rowIndex);
		if (row) {
			row.classList.toggle('checked-row', checkbox.checked);
		}
		csSyncSelectAllState();
		csUpdateDeleteButtonVisibility();
	}

	function csToggleSelectAll(master) {
		for (var i = 1; i <= 10; i++) {
			var idEl = document.getElementById('product_id' + i);
			var ck = document.getElementById('cs_ck' + i);
			if (idEl && idEl.value !== '' && ck) {
				ck.checked = master.checked;
				var row = document.getElementById('cs_row' + i);
				if (row) {
					row.classList.toggle('checked-row', master.checked);
				}
			}
		}
		csUpdateDeleteButtonVisibility();
	}

	function csSyncSelectAllState() {
		var master = document.getElementById('cs_select_all');
		if (!master) return;
		var anyFilled = false,
			allChecked = true;
		for (var i = 1; i <= 10; i++) {
			var idEl = document.getElementById('product_id' + i);
			if (!idEl || idEl.value === '') continue;
			anyFilled = true;
			var ck = document.getElementById('cs_ck' + i);
			if (!ck || !ck.checked) {
				allChecked = false;
			}
		}
		master.checked = anyFilled && allChecked;
	}

	function csUpdateDeleteButtonVisibility() {
		var btn = document.getElementById('cs_delete_selected_btn');
		if (!btn) return;
		var anyChecked = false;
		for (var i = 1; i <= 10; i++) {
			var ck = document.getElementById('cs_ck' + i);
			if (ck && ck.checked) {
				anyChecked = true;
				break;
			}
		}
		btn.style.display = anyChecked ? 'inline-flex' : 'none';
	}

	function csExecuteClearRow(i) {
		csFieldNames.forEach(function(name) {
			csSetFieldValue(document.getElementById(name + i), '');
		});
		var ck = document.getElementById('cs_ck' + i);
		if (ck) {
			ck.checked = false;
		}
		var row = document.getElementById('cs_row' + i);
		if (row) {
			row.classList.remove('checked-row');
		}
		csRecalcSummary();
	}

	/* คอนเฟิร์มก่อนลบด้วย SweetAlert2 เฉพาะแถวที่มีข้อมูลจริง (ตามแพทเทิร์น
	   clearRow()/executeClearRow() ของ product_salehos.php) - แถวว่างเคลียร์ตรงได้เลย
	   ไม่ต้องถาม กันความรำคาญเวลากดพลาดที่แถวที่ยังไม่มีอะไรให้ลบ */
	function csClearRow(i) {
		var idEl = document.getElementById('product_id' + i);
		var hasData = idEl && idEl.value.trim() !== '';
		if (!hasData) {
			csExecuteClearRow(i);
			return;
		}

		var nameEl = document.getElementById('product_name_view' + i);
		var productName = nameEl ? nameEl.textContent.trim() : '';
		var displayMsg = productName ?
			'คุณต้องการลบรายการ "' + productName + '" ใช่หรือไม่ ?' :
			'คุณต้องการลบรายการนี้ใช่หรือไม่ ?';

		if (typeof Swal === 'undefined') {
			if (confirm(displayMsg)) {
				csExecuteClearRow(i);
			}
			return;
		}

		Swal.fire({
			icon: 'warning',
			title: 'ยืนยันการลบรายการ',
			text: displayMsg,
			showCancelButton: true,
			confirmButtonText: 'ยืนยันลบ',
			cancelButtonText: 'ยกเลิก',
			reverseButtons: true,
			confirmButtonColor: '#DC3545',
			cancelButtonColor: '#612989'
		}).then(function(result) {
			if (result.isConfirmed) {
				csExecuteClearRow(i);
			}
		});
	}

	function csUpdateRowVisibility() {
		var highestFilled = 0;
		for (var i = 1; i <= 10; i++) {
			var idEl = document.getElementById('product_id' + i);
			var nameEl = document.getElementById('product_name' + i);
			var codeEl = document.getElementById('product_codet' + i);
			var priceEl = document.getElementById('product_price' + i);
			var qtyEl = document.getElementById('sale_count' + i);

			var idVal = idEl ? idEl.value.trim() : '';
			var nameVal = nameEl ? nameEl.value.trim() : '';
			var codeVal = codeEl ? codeEl.textContent.trim() : '';
			var priceVal = priceEl ? priceEl.value.trim() : '';
			var qtyVal = qtyEl ? qtyEl.value.trim() : '';

			if (idVal !== '' || nameVal !== '' || codeVal !== '' || priceVal !== '' || qtyVal !== '') {
				highestFilled = i;
			}
		}

		/* ไม่ +1 อีกต่อไป - ตารางโชว์เฉพาะแถวที่มีข้อมูลจริง แถวว่างถัดไปไม่ต้องเปิดค้างไว้
		   เพราะการเพิ่มสินค้าใหม่ทำผ่านช่องค้นหา (ซึ่งหาแถวว่างเองได้แม้แถวนั้นถูกซ่อนอยู่)
		   แต่ยังคง Math.max(1, ...) ไว้ให้มีแถวเริ่มต้นว่างๆ โชว์ไว้ 1 แถวเสมอตอนยังไม่มีข้อมูลเลย
		   เผื่อผู้ใช้ต้องการกรอกจำนวน/ราคาเองโดยไม่ผ่านช่องค้นหา */
		var maxVisible = Math.min(10, Math.max(1, highestFilled));
		for (var j = 1; j <= 10; j++) {
			var row = document.getElementById('cs_row' + j);
			if (row) {
				row.style.display = (j <= maxVisible) ? '' : 'none';
			}
		}
	}

	function csExecuteDeleteSelectedRows() {
		for (var j = 1; j <= 10; j++) {
			var ck2 = document.getElementById('cs_ck' + j);
			if (ck2 && ck2.checked) {
				/* เรียก csExecuteClearRow ตรงๆ ไม่ผ่าน csClearRow เพราะถามยืนยัน
				   ครั้งเดียวสำหรับทั้งชุดไปแล้ว ไม่ต้องให้ Swal ถามซ้ำทีละแถวอีก */
				csExecuteClearRow(j);
			}
		}
		csSyncSelectAllState();
		csUpdateDeleteButtonVisibility();
	}

	function csDeleteSelectedRows() {
		var anyChecked = false;
		for (var i = 1; i <= 10; i++) {
			var ck = document.getElementById('cs_ck' + i);
			if (ck && ck.checked) {
				anyChecked = true;
				break;
			}
		}
		if (!anyChecked) return;

		var displayMsg = 'ต้องการลบรายการที่เลือกใช่หรือไม่ ?';

		if (typeof Swal === 'undefined') {
			if (confirm(displayMsg)) {
				csExecuteDeleteSelectedRows();
			}
			return;
		}

		Swal.fire({
			icon: 'warning',
			title: 'ยืนยันการลบรายการ',
			text: displayMsg,
			showCancelButton: true,
			confirmButtonText: 'ยืนยันลบ',
			cancelButtonText: 'ยกเลิก',
			reverseButtons: true,
			confirmButtonColor: '#DC3545',
			cancelButtonColor: '#612989'
		}).then(function(result) {
			if (result.isConfirmed) {
				csExecuteDeleteSelectedRows();
			}
		});
	}

	function csRecalcSummary() {
		csUpdateRowVisibility();

		/* jAutoCalc คำนวณ sum_amount{i} ใหม่เฉพาะตอน focus/change/blur (keyEventsFire:false
		   ด้านล่าง) และเซ็ตค่าด้วย .val() เฉยๆ ไม่ trigger input/change ต่อ - หน่วงอ่านค่าไว้
		   200ms ให้ jAutoCalc คำนวณเสร็จก่อนเสมอ ป้องกันยอดรวมสุทธิค้างค่าเก่า (ตาม
		   product_salehos.php's calculateSummary() ที่แก้ปัญหาเดียวกันนี้ไว้แล้ว) */
		setTimeout(function() {
			var totalQty = 0;
			var totalAmount = 0;
			var itemCount = 0;
			for (var i = 1; i <= 10; i++) {
				var idEl = document.getElementById('product_id' + i);
				if (!idEl || idEl.value === '') {
					continue;
				}
				itemCount++;
				var qtyEl = document.getElementById('sale_count' + i);
				var amtEl = document.getElementById('sum_amount' + i);
				if (qtyEl) {
					totalQty += parseFloat(qtyEl.value) || 0;
				}
				if (amtEl) {
					totalAmount += parseFloat(String(amtEl.value).replace(/,/g, '')) || 0;
				}
			}
			var qtyOut = document.getElementById('cs_summary_qty');
			var amountOut = document.getElementById('cs_summary_net');
			var countOut = document.getElementById('cs_summary_item_count');
			if (qtyOut) {
				qtyOut.textContent = totalQty;
			}
			if (amountOut) {
				amountOut.textContent = totalAmount.toLocaleString('en-US', {
					minimumFractionDigits: 2,
					maximumFractionDigits: 2
				});
			}
			if (countOut) {
				countOut.textContent = itemCount + ' รายการ';
			}
		}, 200);
	}

	/* Modal Popup handlers (Figma node 984-5469) */
	function csOpenEditModal(rowIndex) {
		csActiveEditRowIndex = rowIndex;
		var warrantyEl = document.getElementById('warranty' + rowIndex);
		var calEl = document.getElementById('cal' + rowIndex);
		var pmEl = document.getElementById('pm' + rowIndex);
		var pmYearEl = document.getElementById('pm_year' + rowIndex);
		var remarkEl = document.getElementById('sale_remarkk' + rowIndex);
		var snEl = document.getElementById('sn' + rowIndex);

		document.getElementById('modal_warranty').value = warrantyEl ? warrantyEl.value : '';
		document.getElementById('modal_cal').value = calEl ? calEl.value : '';
		document.getElementById('modal_pm_year').value = pmYearEl ? pmYearEl.value : '';
		document.getElementById('modal_pm').value = pmEl ? pmEl.value : '';
		document.getElementById('modal_sale_remarkk').value = remarkEl ? remarkEl.value : '';
		document.getElementById('modal_sn').value = snEl ? snEl.value : '';

		var modal = document.getElementById('cs_edit_modal');
		if (modal) {
			modal.style.display = 'flex';
		}
	}

	function csCloseEditModal() {
		var modal = document.getElementById('cs_edit_modal');
		if (modal) {
			modal.style.display = 'none';
		}
		csActiveEditRowIndex = null;
	}

	function csSaveEditModal() {
		if (!csActiveEditRowIndex) return;
		var i = csActiveEditRowIndex;
		var warrantyEl = document.getElementById('warranty' + i);
		var calEl = document.getElementById('cal' + i);
		var pmEl = document.getElementById('pm' + i);
		var pmYearEl = document.getElementById('pm_year' + i);
		var remarkEl = document.getElementById('sale_remarkk' + i);
		var snEl = document.getElementById('sn' + i);

		if (warrantyEl) warrantyEl.value = document.getElementById('modal_warranty').value;
		if (calEl) calEl.value = document.getElementById('modal_cal').value;
		if (pmYearEl) pmYearEl.value = document.getElementById('modal_pm_year').value;
		if (pmEl) pmEl.value = document.getElementById('modal_pm').value;
		if (remarkEl) remarkEl.value = document.getElementById('modal_sale_remarkk').value;
		if (snEl) snEl.value = document.getElementById('modal_sn').value;

		csCloseEditModal();
	}

	/* ===== ค้นหาสินค้า -> เลือก -> เติมแถวว่าง (adapt จาก product_salehos.php: global_product_search
	   + doCallAjax) เชื่อมกับ #cs_product_search ที่มีอยู่แล้ว (เดิมใช้กรองแถวที่กรอกแล้วเท่านั้น) ===== */
	function csGetSelectedTypeCompany() {
		var sel = document.getElementById('company_select');
		return (sel && sel.value === '2') ? 'NBM' : 'AWL';
	}

	function csFindEmptyRowIndex() {
		for (var i = 1; i <= 10; i++) {
			var idEl = document.getElementById('product_id' + i);
			if (idEl && idEl.value.trim() === '') {
				return i;
			}
		}
		return -1;
	}

	function csApplyProductToRow(rowIndex, accessCode, product) {
		csSetFieldValue(document.getElementById('product_codet' + rowIndex), accessCode);
		csSetFieldValue(document.getElementById('product_id' + rowIndex), product.product_ID);
		csSetFieldValue(document.getElementById('product_name' + rowIndex), product.sol_name);
		csSetFieldValue(document.getElementById('product_name_view' + rowIndex), product.sol_name);
		csSetFieldValue(document.getElementById('unit_name' + rowIndex), product.unit_name);
		csSetFieldValue(document.getElementById('product_price' + rowIndex), product.sol_price);
		csSetFieldValue(document.getElementById('discount_unit' + rowIndex), product.discount);
		csSetFieldValue(document.getElementById('warranty' + rowIndex), product.war_hc);

		var qtyEl = document.getElementById('sale_count' + rowIndex);
		if (qtyEl && qtyEl.value.trim() === '') {
			qtyEl.value = '1';
		}

		var row = document.getElementById('cs_row' + rowIndex);
		if (row) {
			row.style.display = '';
		}

		csRecalcSummary();

		if (qtyEl) {
			qtyEl.focus();
			qtyEl.select();
		}
	}

	/* ดึงรายละเอียดสินค้าเต็มจาก access_code ที่เลือก (เดียวกับ data_product_hos1.php ที่
	   product_salehos.php เรียกใน doCallAjax, format=json ตัดปัญหาการ split string ด้วย "|") */
	function csDoCallAjax(accessCode, rowIndex) {
		var req = new XMLHttpRequest();
		req.open('POST', 'data_product_hos1.php', true);
		req.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		req.onreadystatechange = function() {
			if (req.readyState === 4) {
				if (req.responseText.trim() === '') {
					return;
				}
				try {
					var product = JSON.parse(req.responseText);
					if (product.found === false) {
						alert('ไม่พบรหัสสินค้า "' + accessCode + '" ในระบบ กรุณาตรวจสอบรหัสสินค้าอีกครั้ง');
						return;
					}
					csApplyProductToRow(rowIndex, accessCode, product);
				} catch (e) {
					console.error('Failed to parse product JSON:', e, req.responseText);
				}
			}
		};
		req.send(
			'product_code=' + encodeURIComponent(accessCode) +
			'&type_company=' + encodeURIComponent(csGetSelectedTypeCompany()) +
			'&format=json'
		);
	}
</script>

<script src="dist/jautocalc.js"></script>
</head>

<body>

	<div class="so-product-summary-bar" id="cs_summary_bar">
		<div class="so-product-summary-col">
			<span class="so-product-summary-label">จำนวนรวม(ชิ้น)</span>
			<span class="so-product-summary-value" id="cs_summary_qty">0</span>
		</div>
		<div class="so-product-summary-col is-highlight">
			<span class="so-product-summary-label">ยอดรวมสุทธิ</span>
			<span class="so-product-summary-value" id="cs_summary_net">0.00</span>
		</div>
	</div>

	<div class="cs-product-toolbar-row">
		<div class="so-field-group so-search-group">
			<label class="so-label" for="cs_product_search">ค้นหารายการสินค้า</label>
			<div class="so-search-box">
				<i class="fas fa-search so-search-icon" aria-hidden="true"></i>
				<input type="text" id="cs_product_search" class="so-input so-search-input" autocomplete="off" placeholder="ค้นหาด้วยรหัสสินค้า / ชื่อสินค้า" role="combobox" aria-autocomplete="list" aria-expanded="false" aria-controls="cs_product_results">
				<ul class="so-search-results" id="cs_product_results" role="listbox" hidden></ul>
			</div>
		</div>

		<div class="cs-product-header-row">
			<button type="button" class="cs-delete-selected-btn" id="cs_delete_selected_btn" style="display:none;" onclick="csDeleteSelectedRows();">
				<i class="far fa-trash-alt"></i> ลบรายการที่เลือก
			</button>
		</div>
	</div>

	<script type="text/javascript">
		/* dropdown ค้นหาสินค้า — pattern: docs/product-search-dropdown-pattern.md (endpoint ajax_smp_product.php)
		   เลือก -> เติมแถวว่างแถวแรก (สูงสุด 10) -> csDoCallAjax ดึงรายละเอียดเต็ม -> focus ช่องจำนวน (พฤติกรรมเดิม)
		   ช่องนี้ไม่กรองแถวที่มีอยู่แล้ว (เดิมมี csFilterProductRows แต่ชนกับการค้นหาสินค้าใหม่) */
		var csSearchTimer = null;
		var csSearchToken = 0;
		var csSearchItems = [];
		var csSearchActive = -1;

		function csEscapeHtml(value) {
			return String(value == null ? '' : value).replace(/[&<>"']/g, function(ch) {
				return {
					'&': '&amp;',
					'<': '&lt;',
					'>': '&gt;',
					'"': '&quot;',
					"'": '&#039;'
				} [ch];
			});
		}

		function csCloseSearchResults() {
			var list = document.getElementById('cs_product_results');
			var input = document.getElementById('cs_product_search');
			if (!list || !input) return;
			list.hidden = true;
			list.innerHTML = '';
			input.setAttribute('aria-expanded', 'false');
			input.removeAttribute('aria-activedescendant');
			csSearchItems = [];
			csSearchActive = -1;
		}

		function csShowSearchNote(message) {
			var list = document.getElementById('cs_product_results');
			csSearchItems = [];
			csSearchActive = -1;
			list.innerHTML = '<li class="so-search-note" role="presentation">' + csEscapeHtml(message) + '</li>';
			list.hidden = false;
			document.getElementById('cs_product_search').setAttribute('aria-expanded', 'true');
		}

		function csSetActiveSearchOption(index) {
			var options = document.getElementById('cs_product_results').querySelectorAll('.so-search-option');
			var input = document.getElementById('cs_product_search');
			csSearchActive = index;
			Array.prototype.forEach.call(options, function(option, i) {
				var active = (i === index);
				option.classList.toggle('is-active', active);
				option.setAttribute('aria-selected', active ? 'true' : 'false');
				if (active) {
					input.setAttribute('aria-activedescendant', option.id);
					option.scrollIntoView({
						block: 'nearest'
					});
				}
			});
		}

		function csRenderSearchResults(items, hasMore) {
			if (items.length === 0) {
				csShowSearchNote('ไม่พบสินค้าที่ตรงกับคำค้นของบริษัทที่เลือก');
				return;
			}
			var list = document.getElementById('cs_product_results');
			csSearchItems = items;
			list.innerHTML = items.map(function(item, index) {
				var sub = String(item.access_name || '').trim();
				return '<li class="so-search-option" role="option" id="cs_product_option_' + index + '" data-so-index="' + index + '" aria-selected="false">' +
					'<span class="so-search-option-code">' + csEscapeHtml(item.access_code) + '</span>' +
					'<span class="so-search-option-name">' + csEscapeHtml(item.sol_name) + '</span>' +
					(sub !== '' && sub !== item.sol_name ? '<span class="so-search-option-sub">' + csEscapeHtml(sub) + '</span>' : '') +
					'</li>';
			}).join('') + (hasMore ? '<li class="so-search-note" role="presentation">แสดง ' + items.length + ' รายการแรก — พิมพ์คำค้นให้เจาะจงขึ้น</li>' : '');
			list.hidden = false;
			document.getElementById('cs_product_search').setAttribute('aria-expanded', 'true');
			csSetActiveSearchOption(0);
		}

		function csRunSearch() {
			var keyword = document.getElementById('cs_product_search').value.trim();
			var token = ++csSearchToken;
			if (keyword === '') {
				csCloseSearchResults();
				return;
			}
			fetch('ajax_smp_product.php?q=' + encodeURIComponent(keyword) + '&company=' + csGetSelectedTypeCompany(), {
					credentials: 'same-origin',
					cache: 'no-store'
				})
				.then(function(res) {
					return res.json();
				})
				.then(function(data) {
					if (token !== csSearchToken) return; // พิมพ์ต่อไปแล้วระหว่างรอ
					if (!data || !data.success) throw new Error((data && data.message) || 'ไม่สามารถค้นหาสินค้าได้');
					csRenderSearchResults(Array.isArray(data.items) ? data.items : [], !!data.has_more);
				})
				.catch(function(error) {
					if (token !== csSearchToken) return;
					csShowSearchNote(error && error.message ? error.message : 'ไม่สามารถค้นหาสินค้าได้');
				});
		}

		function csPickSearchOption(index) {
			var item = csSearchItems[index];
			if (!item) return;
			document.getElementById('cs_product_search').value = '';
			csSearchToken++;
			csCloseSearchResults();
			var rowIndex = csFindEmptyRowIndex();
			if (rowIndex === -1) {
				alert('ไม่สามารถเพิ่มสินค้าได้ (ตารางเต็ม 10 รายการแล้ว)');
				return;
			}
			csDoCallAjax(item.access_code, rowIndex);
		}

		(function() {
			var input = document.getElementById('cs_product_search');
			var list = document.getElementById('cs_product_results');
			if (!input || !list) return;

			input.addEventListener('input', function() {
				clearTimeout(csSearchTimer);
				csSearchTimer = setTimeout(csRunSearch, 250);
			});

			input.addEventListener('keydown', function(event) {
				if (event.key === 'Enter') {
					event.preventDefault(); // Enter ในช่องค้นหาต้องไม่ submit ฟอร์ม
					if (csSearchActive >= 0) csPickSearchOption(csSearchActive);
					return;
				}
				if (event.key === 'Escape') {
					if (!list.hidden) {
						event.stopPropagation();
						csCloseSearchResults();
					}
					return;
				}
				if (event.key !== 'ArrowDown' && event.key !== 'ArrowUp') return;
				if (csSearchItems.length === 0) return;
				event.preventDefault();
				var next = csSearchActive + (event.key === 'ArrowDown' ? 1 : -1);
				if (next < 0) next = csSearchItems.length - 1;
				if (next >= csSearchItems.length) next = 0;
				csSetActiveSearchOption(next);
			});

			// mousedown (ไม่ใช่ click) — เลือกก่อนที่ช่องค้นหาจะเสีย focus
			list.addEventListener('mousedown', function(event) {
				var option = event.target.closest('.so-search-option');
				if (!option) return;
				event.preventDefault();
				csPickSearchOption(parseInt(option.getAttribute('data-so-index'), 10));
			});

			input.addEventListener('blur', function() {
				setTimeout(csCloseSearchResults, 150);
			});
		})();
	</script>

	<div class="so-product-table-wrap" id="cs_product_table_wrap" oninput="csRecalcSummary();">
		<table class="so-product-table" id="cs_product_table">

			<thead>
				<tr>
					<th>
						<label class="so-row-checkbox-wrap">
							<input type="checkbox" class="so-row-checkbox" id="cs_select_all" aria-label="เลือกทุกรายการ" onclick="csToggleSelectAll(this);">
							<span class="so-row-checkbox-dot" aria-hidden="true"></span>
						</label>
					</th>
					<th>รหัสสินค้า</th>
					<th>รายการสินค้า</th>
					<th>จำนวน</th>
					<th>ราคา/หน่วย</th>
					<th>ยอดรวม</th>
					<th aria-label="จัดการรายการ"></th>
				</tr>
			</thead>
			<tbody>
				<?php
				function cs_product_row($i)
				{
				?>
					<tr class="so-product-row" id="cs_row<?php echo $i; ?>">
						<td>
							<div class="cs-row-controls-inner">
								<i class="fas fa-grip-vertical cs-drag-handle rd-handle"
									title="ลากเพื่อจัดเรียง"
									aria-hidden="true"></i>
								<label class="so-row-checkbox-wrap">
									<input type="checkbox" class="so-row-checkbox" id="cs_ck<?php echo $i; ?>" aria-label="เลือกรายการที่ <?php echo $i; ?>" onchange="csToggleRowHighlight(this,<?php echo $i; ?>);">
									<span class="so-row-checkbox-dot" aria-hidden="true"></span>
								</label>
							</div>
						</td>
						<td>
							<span class="cs-code-text" id="product_codet<?php echo $i; ?>"></span>
							<input type='hidden' name="product_id<?php echo $i; ?>" id="product_id<?php echo $i; ?>" />
							<input type='hidden' name="product_name<?php echo $i; ?>" id="product_name<?php echo $i; ?>" />
							<input type='hidden' name="unit_name<?php echo $i; ?>" id="unit_name<?php echo $i; ?>" />
							<input type='hidden' name="discount_unit<?php echo $i; ?>" id="discount_unit<?php echo $i; ?>" />
							<input type='hidden' name="warranty<?php echo $i; ?>" id="warranty<?php echo $i; ?>" />
							<input type='hidden' name="cal<?php echo $i; ?>" id="cal<?php echo $i; ?>" />
							<input type='hidden' name="pm<?php echo $i; ?>" id="pm<?php echo $i; ?>" />
							<input type='hidden' name="pm_year<?php echo $i; ?>" id="pm_year<?php echo $i; ?>" />
							<input type='hidden' name="sale_remarkk<?php echo $i; ?>" id="sale_remarkk<?php echo $i; ?>" />
							<input type='hidden' name="sn<?php echo $i; ?>" id="sn<?php echo $i; ?>" />
						</td>
						<td>
							<span class="cs-product-name-text" id="product_name_view<?php echo $i; ?>"></span>
						</td>
						<td>
							<div class="cs-cell-pill">
								<input type='text' name="sale_count<?php echo $i; ?>" id="sale_count<?php echo $i; ?>" class="so-input" style="text-align:center" onchange="csRecalcSummary();" />
							</div>
						</td>
						<td>
							<div class="cs-cell-pill">
								<input type='text' name="product_price<?php echo $i; ?>" id="product_price<?php echo $i; ?>" class="so-input" style="text-align:right" onchange="csRecalcSummary();" />
							</div>
						</td>
						<td>
							<input type='text' name="sum_amount<?php echo $i; ?>" id="sum_amount<?php echo $i; ?>" class="so-input" style="text-align:right" value="" jAutoCalc='{sale_count<?php echo $i; ?>} * {product_price<?php echo $i; ?>} - {discount_unit<?php echo $i; ?>} * {sale_count<?php echo $i; ?>}' readonly />
						</td>
						<td class="cs-row-actions-cell">
							<button type="button" class="cs-row-edit-btn" id="cs_extra_toggle_btn<?php echo $i; ?>" title="แก้ไขข้อมูลเพิ่มเติม" aria-label="แก้ไขข้อมูลเพิ่มเติมของรายการที่ <?php echo $i; ?>" onclick="csOpenEditModal(<?php echo $i; ?>);">
								<i class="fas fa-pen" aria-hidden="true"></i>
							</button>
							<button type="button" class="so-product-remove-btn" title="ลบรายการ" aria-label="ลบรายการที่ <?php echo $i; ?>" onclick="csClearRow(<?php echo $i; ?>);"><i class="fas fa-trash-alt" aria-hidden="true"></i></button>
						</td>
					</tr>
				<?php
				}

				for ($i = 1; $i <= 10; $i++) {
					cs_product_row($i);
				}
				?>
			</tbody>
		</table>
	</div>

	<!-- Modal Popup (Figma node 984-5469: ข้อมูลรายการสินค้าเพิ่มเติม) -->
	<div id="cs_edit_modal" class="cs-modal-overlay" data-so-modal-lock style="display:none;">
		<div class="cs-modal-card">
			<div class="cs-modal-header">
				<h3 class="cs-modal-title">ข้อมูลรายการสินค้าเพิ่มเติม</h3>
				<button type="button" class="cs-modal-close-btn" onclick="csCloseEditModal();">&times;</button>
			</div>
			<div class="cs-modal-body">
				<div class="cs-modal-grid-4">
					<div class="so-field-group">
						<label class="so-label">รับประกัน(ปี)*</label>
						<input type="text" id="modal_warranty" class="so-input" placeholder="ใส่เฉพาะตัวเลข" />
					</div>
					<div class="so-field-group">
						<label class="so-label">CAL/ปี</label>
						<input type="text" id="modal_cal" class="so-input" placeholder="ใส่จำนวนครั้งต่อปี" onkeypress="return chkNumber(this);" />
					</div>
					<div class="so-field-group">
						<label class="so-label">PM(ปี)</label>
						<input type="text" id="modal_pm_year" class="so-input" placeholder="ใส่เฉพาะตัวเลข" onkeypress="return chkNumber(this);" />
					</div>
					<div class="so-field-group">
						<label class="so-label">PM (จำนวนครั้ง/ปี)</label>
						<input type="text" id="modal_pm" class="so-input" placeholder="ใส่จำนวนครั้งต่อปี" onkeypress="return chkNumber(this);" />
					</div>
				</div>
				<div class="cs-modal-grid-2">
					<div class="so-field-group">
						<label class="so-label">หมายเหตุสินค้า</label>
						<input type="text" id="modal_sale_remarkk" class="so-input" placeholder="ระบุหมายเหตุสินค้า" />
					</div>
					<div class="so-field-group">
						<label class="so-label">หมายเลข SN</label>
						<input type="text" id="modal_sn" class="so-input" placeholder="ใส่เลข SN" />
					</div>
				</div>
			</div>
			<div class="cs-modal-footer">
				<button type="button" class="cs-modal-btn-update" onclick="csSaveEditModal();">อัพเดท</button>
				<button type="button" class="cs-modal-btn-cancel" onclick="csCloseEditModal();">ยกเลิก</button>
			</div>
		</div>
	</div>

	<script>
		/* ย้าย modal ไปแขวนที่ <body> ตอนโหลดหน้า
		   partial นี้ถูก include อยู่ใน <div id="pd" class="so-card"> และ .so-card มี
		   container-type: inline-size (register-suphos.css:1428) ซึ่งบังคับ contain: layout
		   ทำให้ .so-card กลายเป็น containing block ของลูกที่ position: fixed
		   -> overlay จะคลุมแค่การ์ดรายการสินค้า ไม่ใช่ทั้งจอ และบนมือถือจะกินพื้นที่แคบมาก
		   ช่องในฟอร์ม modal ใช้แค่ id ไม่มี name จึงไม่ถูก submit การย้ายออกจาก <form> ปลอดภัย
		   (csOpenEditModal/csSaveEditModal อ้างอิงทุกอย่างผ่าน getElementById อยู่แล้ว) */
		(function csDetachEditModal() {
			var modal = document.getElementById('cs_edit_modal');
			if (modal && modal.parentNode !== document.body) {
				document.body.appendChild(modal);
			}
		})();
	</script>

</body>

</html>

<script>
	$('form').jAutoCalc({
		attribute: 'jAutoCalc',
		thousandOpts: [',', '.', ' '],
		decimalOpts: ['.', ','],
		decimalPlaces: -1,
		initFire: true,
		chainFire: true,
		keyEventsFire: false,
		readOnlyResults: true,
		showParseError: true,
		emptyAsZero: false,
		smartIntegers: false,
		onShowResult: null,
		funcs: {},
		vars: {}
	});
	csRecalcSummary();
	$(document).ready(function() {
		csUpdateRowVisibility();
	});
</script>