<?php
function br_product_row_hos($i)
{
?>
	<tr class="so-product-row" id="br_row<?php echo $i; ?>"
		style="display:none;"
		ondragstart="brHandleDragStart(event, <?php echo $i; ?>)"
		ondragover="brHandleDragOver(event)"
		ondragenter="brHandleDragEnter(event)"
		ondragleave="brHandleDragLeave(event)"
		ondrop="brHandleDrop(event, <?php echo $i; ?>)"
		ondragend="brHandleDragEnd(event)">
		<td class="br-row-handle-cell">
			<div class="br-row-handle-wrap">
				<i class="fas fa-grip-vertical br-drag-handle"
					onmousedown="document.getElementById('br_row<?php echo $i; ?>').setAttribute('draggable', true)"
					onmouseup="document.getElementById('br_row<?php echo $i; ?>').removeAttribute('draggable')"
					onmouseleave="document.getElementById('br_row<?php echo $i; ?>').removeAttribute('draggable')"></i>
				<label class="so-row-checkbox-wrap">
					<input type="checkbox" class="so-row-checkbox" id="br_ck<?php echo $i; ?>" onchange="brToggleRowHighlight(this, <?php echo $i; ?>);">
					<span class="so-row-checkbox-dot" aria-hidden="true"></span>
				</label>
			</div>
			<input type='hidden' name="product_codet<?php echo $i; ?>" id="product_codet<?php echo $i; ?>" value="">
			<input type='hidden' name="product_c<?php echo $i; ?>" id="product_c<?php echo $i; ?>" value="">
			<input type='hidden' name="product_id<?php echo $i; ?>" id="product_id<?php echo $i; ?>">
			<input type='hidden' name="unit_name<?php echo $i; ?>" id="unit_name<?php echo $i; ?>">
			<input type='hidden' name="product_name<?php echo $i; ?>" id="product_name<?php echo $i; ?>">
			<input type='hidden' name="warranty<?php echo $i; ?>" id="warranty<?php echo $i; ?>">
			<input type='hidden' name="sale_remarkk<?php echo $i; ?>" id="sale_remarkk<?php echo $i; ?>">
			<input type='hidden' name="store<?php echo $i; ?>" id="store<?php echo $i; ?>">
			<input type='hidden' name="store_remark<?php echo $i; ?>" id="store_remark<?php echo $i; ?>">
			<input type='hidden' name="display_name<?php echo $i; ?>" id="display_name<?php echo $i; ?>">
		</td>
		<td><input type='text' name="product_code<?php echo $i; ?>" id="product_code<?php echo $i; ?>" class="so-input" readonly /></td>
		<td><span class="so-product-name-label" id="product_name_label<?php echo $i; ?>"></span></td>
		<td><input type='text' name="sale_count<?php echo $i; ?>" id="sale_count<?php echo $i; ?>" class="so-input" style="text-align:center" oninput="brUpdateRowTotal(<?php echo $i; ?>); brCalculateSummary();" /></td>
		<td><input type='text' name="product_price<?php echo $i; ?>" id="product_price<?php echo $i; ?>" class="so-input" style="text-align:right" oninput="brUpdateRowTotal(<?php echo $i; ?>); brCalculateSummary();" /></td>
		<td><input type='text' name="sum_amount<?php echo $i; ?>" id="sum_amount<?php echo $i; ?>" class="so-input" style="text-align:right" readonly /></td>
		<td><input type='text' name="br_period<?php echo $i; ?>" id="br_period<?php echo $i; ?>" class="so-input" style="text-align:center" oninput="brCalculateSummary();" /></td>
		<td class="so-product-remove-cell">
			<i class="far fa-edit br-action-icon" title="แก้ไขข้อมูลเพิ่มเติม" role="button" tabindex="0" aria-label="แก้ไขข้อมูลเพิ่มเติม" onclick="brOpenEditModal(<?php echo $i; ?>);"></i>
			<i class="far fa-trash-alt br-action-icon" title="ลบ" role="button" tabindex="0" aria-label="ลบรายการนี้" onclick="brClearRow(<?php echo $i; ?>);"></i>
		</td>
	</tr>
<?php
}
?>

<div class="so-product-summary-bar" id="br_summary_bar">
	<div class="so-product-summary-col">
		<span class="so-product-summary-label">จำนวนรวม(ชิ้น)</span>
		<span class="so-product-summary-value" id="br_summary_qty">0</span>
	</div>
	<div class="so-product-summary-col">
		<span class="so-product-summary-label">ยอดรวม</span>
		<span class="so-product-summary-value" id="br_summary_amount">0.00</span>
	</div>
	<div class="so-product-summary-col">
		<span class="so-product-summary-label">ยอดรวมสุทธิ</span>
		<span class="so-product-summary-value" id="br_summary_net">0.00</span>
	</div>
</div>

<div class="br-product-header-row">
	<div class="br-global-search-block">
		<label class="br-global-search-label" for="br_global_search">ค้นหารายการสินค้า</label>
		<div class="br-product-search-wrap br-global-search-wrap">
			<div class="br-global-search-bar">
				<i class="fas fa-search"></i>
				<input type="text" id="br_global_search" placeholder="ค้นหาด้วยรหัสสินค้า / ชื่อสินค้า" autocomplete="off" oninput="brGlobalSearchInput();">
			</div>
			<div class="br-product-search-dropdown" id="br_global_search_dd"></div>
		</div>
	</div>
	<button type="button" class="br-delete-selected-btn" id="br_delete_selected_btn" onclick="brDeleteSelectedRows();">
		<i class="far fa-trash-alt"></i> ลบรายการที่เลือก
	</button>
</div>

<div class="so-product-table-wrap" id="br_product_table_wrap">
	<table class="so-product-table" id="br_product_table">
		<thead>
			<tr>
				<th style="width:70px;text-align:center;">
					<label class="so-row-checkbox-wrap">
						<input type="checkbox" id="br_select_all" class="so-row-checkbox" onclick="brToggleSelectAll(this);">
						<span class="so-row-checkbox-dot" aria-hidden="true"></span>
					</label>
				</th>
				<th>รหัสสินค้า</th>
				<th>รายการสินค้า</th>
				<th style="text-align:center;">จำนวน</th>
				<th style="text-align:center;">ราคา/หน่วย</th>
				<th style="text-align:center;">ยอดรวม</th>
				<th style="text-align:center;">จำนวนวันที่ยืม</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php
			// จำนวนแถวต้องรองรับเอกสารที่ BOM แตกองค์ประกอบเกิน 8 รายการ (1 สินค้าชุดแตกได้ถึง 10 องค์ประกอบ/ช่อง)
			// ถ้า render แค่ 8 แถวตายตัว edit mode จะโหลดข้อมูลมาไม่ครบ แล้ว save ทับ (DELETE+INSERT) ทำให้แถวส่วนเกินหายถาวร
			$brRowCount = max(8, isset($savedProducts) ? count($savedProducts) : 0);
			for ($i = 1; $i <= $brRowCount; $i++) br_product_row_hos($i);
			?>
		</tbody>
	</table>
</div>

<!-- ป๊อปอัปข้อมูลรายการสินค้าเพิ่มเติม (หมายเหตุสินค้า และ ชื่อที่แสดงในใบส่งสินค้า) สไตล์สีม่วงเม็ดยา -->
<div id="brEditModal" class="customer-popup-modal" aria-hidden="true">
	<div class="customer-popup-box br-edit-popup-box" role="dialog" aria-modal="true" aria-labelledby="brEditModalTitle">
		<button type="button" class="customer-popup-close" onclick="brCloseEditModal();" aria-label="Close">&times;</button>
		<div class="customer-popup-header">
			<h2 id="brEditModalTitle">ข้อมูลรายการสินค้าเพิ่มเติม</h2>
		</div>
		<div class="br-edit-popup-body">
			<input type="hidden" id="br_edit_row_index">
			<div class="so-field-group" style="margin-bottom:0;">
				<label class="so-label" for="br_m_remark" style="color:#612989; font-weight: 500; font-size: 13px;">หมายเหตุสินค้า</label>
				<div class="so-input-wrapper">
					<input type="text" id="br_m_remark" class="so-input" placeholder="กรอกข้อมูล">
					<button type="button" class="fas fa-times so-clear-icon" onclick="clearFieldValue('br_m_remark');" aria-label="ล้างข้อมูล"></button>
				</div>
			</div>
			<!-- <div class="so-field-group" style="margin-bottom:0;">
				<label class="so-label" for="br_m_display_name" style="color:#612989; font-weight: 500; font-size: 13px;">ชื่อที่แสดงในใบส่งสินค้า</label>
				<div class="so-input-wrapper">
					<input type="text" id="br_m_display_name" class="so-input" placeholder="กรอกข้อมูล">
					<button type="button" class="fas fa-times so-clear-icon" onclick="clearFieldValue('br_m_display_name');" aria-label="ล้างข้อมูล"></button>
				</div>
			</div> -->
		</div>
		<div class="customer-popup-actions" style="border-top: none;">
			<button type="button" class="customer-popup-confirm" onclick="brSaveEditModal();" style="background: #612989; color: #FFF; border: none; padding: 0 34px; min-width: 152px; height: 42px; border-radius: 999px; cursor: pointer; font-size: 14px; font-weight: 600; font-family: 'Prompt'; box-shadow: 0 6px 16px rgba(97, 41, 137, 0.22); margin-right: 12px;">อัพเดท</button>
			<button type="button" class="customer-popup-cancel" onclick="brCloseEditModal();" style="background: #FFF; color: #612989; border: 1px solid #EFEBEF; padding: 0 34px; min-width: 152px; height: 42px; border-radius: 999px; cursor: pointer; font-size: 14px; font-weight: 600; font-family: 'Prompt'; box-shadow: 0 0 4px rgba(0, 0, 0, 0.25);">ยกเลิก</button>
		</div>
	</div>
</div>

<script type="text/javascript">
	var BR_ROW_COUNT = <?php echo (int)$brRowCount; ?>; // เท่ากับจำนวนแถว <tr> ที่ render จริง (>= 8 เมื่อเอกสารมีองค์ประกอบ BOM เกิน 8 รายการ)
	var brSearchDept = <?php echo ($_SESSION['department'] ?? '') === 'วิศวกรรม' ? "'eng'" : "'sale'"; ?>;
	var brGlobalSearchTimer = null;
	var brDragSourceIndex = null;
	var brRowFields = ['product_codet', 'product_c', 'product_id', 'unit_name', 'product_name', 'warranty', 'br_period', 'sale_remarkk', 'product_code', 'sale_count', 'product_price', 'sum_amount', 'store', 'store_remark', 'display_name'];

	var BR_DELETE_ICON_HTML = '<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="width:100%;height:100%;">' +
		'<path d="M4 6H20V8H4V6Z" fill="#EF5350"/>' +
		'<path d="M10 2H14V4H10V2Z" fill="#EF5350"/>' +
		'<path d="M5 9H19V20C19 21.1046 18.1046 22 17 22H7C5.89543 22 5 21.1046 5 20V9Z" fill="#EF5350"/>' +
		'<rect x="9" y="11" width="2" height="7" rx="1" fill="#ffffff"/>' +
		'<rect x="13" y="11" width="2" height="7" rx="1" fill="#ffffff"/>' +
		'</svg>';
	var BR_DELETE_CUSTOM_CLASS = {
		popup: 'figma-delete-popup',
		title: 'figma-delete-title',
		htmlContainer: 'figma-delete-html',
		confirmButton: 'figma-delete-confirm-btn',
		cancelButton: 'figma-delete-cancel-btn',
		actions: 'figma-delete-actions',
		icon: 'figma-delete-icon'
	};

	function brEscapeHtml(text) {
		if (!text) return '';
		return text.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
	}

	/* ===== แถวสินค้า: อ่าน/เขียนค่าทั้งแถว (ใช้ตอนลาก-สลับตำแหน่ง) ===== */
	function brGetRowData(i) {
		var data = {};
		brRowFields.forEach(function(f) {
			var el = document.getElementById(f + i);
			if (el) data[f] = el.value;
		});
		var label = document.getElementById('product_name_label' + i);
		data.product_name_label = label ? label.textContent : '';
		var row = document.getElementById('br_row' + i);
		data.display = row ? row.style.display : '';
		var cb = document.getElementById('br_ck' + i);
		data.checked = cb ? cb.checked : false;
		return data;
	}

	function brSetRowData(i, data) {
		brRowFields.forEach(function(f) {
			var el = document.getElementById(f + i);
			if (el && data[f] !== undefined) el.value = data[f];
		});
		var label = document.getElementById('product_name_label' + i);
		if (label) label.textContent = data.product_name_label || '';
		var row = document.getElementById('br_row' + i);
		if (row) row.style.display = data.display !== undefined ? data.display : 'none';
		var cb = document.getElementById('br_ck' + i);
		if (cb) cb.checked = !!data.checked;
		if (row) row.classList.toggle('checked-row', !!data.checked);
	}

	/* ===== ลาก-วางสลับตำแหน่งแถว ===== */
	document.addEventListener('dragover', function(e) {
		e.preventDefault();
	}, false);
	document.addEventListener('drop', function(e) {
		e.preventDefault();
	}, false);

	function brHandleDragStart(e, i) {
		brDragSourceIndex = i;
		e.dataTransfer.effectAllowed = 'move';
		e.currentTarget.classList.add('dragging');
	}

	function brHandleDragOver(e) {
		e.preventDefault();
		e.dataTransfer.dropEffect = 'move';
		return false;
	}

	function brHandleDragEnter(e) {
		if (e.currentTarget.id !== 'br_row' + brDragSourceIndex) {
			e.currentTarget.classList.add('drag-over');
		}
	}

	function brHandleDragLeave(e) {
		e.currentTarget.classList.remove('drag-over');
	}

	function brHandleDrop(e, targetIndex) {
		e.preventDefault();
		e.stopPropagation();
		e.currentTarget.classList.remove('drag-over');
		if (brDragSourceIndex !== null && brDragSourceIndex !== targetIndex) {
			brShiftRows(brDragSourceIndex, targetIndex);
		}
		brDragSourceIndex = null;
		return false;
	}

	function brHandleDragEnd(e) {
		e.currentTarget.classList.remove('dragging');
		document.querySelectorAll('.so-product-row').forEach(function(row) {
			row.classList.remove('drag-over');
			row.removeAttribute('draggable');
		});
	}

	function brShiftRows(fromIndex, toIndex) {
		var allData = [];
		for (var i = 1; i <= BR_ROW_COUNT; i++) allData.push(brGetRowData(i));
		var moved = allData.splice(fromIndex - 1, 1)[0];
		allData.splice(toIndex - 1, 0, moved);
		for (var j = 1; j <= BR_ROW_COUNT; j++) brSetRowData(j, allData[j - 1]);
		brCalculateSummary();
		brUpdateDeleteButtonVisibility();
	}

	/* ===== เลือกแถวด้วย checkbox / ลบหลายรายการ ===== */
	function brToggleRowHighlight(checkbox, rowIndex) {
		var row = document.getElementById('br_row' + rowIndex);
		if (row) row.classList.toggle('checked-row', checkbox.checked);
		brSyncSelectAllState();
		brUpdateDeleteButtonVisibility();
	}

	function brSyncSelectAllState() {
		var master = document.getElementById('br_select_all');
		if (!master) return;
		var boxes = document.querySelectorAll('#br_product_table tbody .so-row-checkbox');
		var allChecked = boxes.length > 0;
		boxes.forEach(function(cb) {
			if (!cb.checked) allChecked = false;
		});
		master.checked = allChecked;
	}

	function brToggleSelectAll(master) {
		for (var i = 1; i <= BR_ROW_COUNT; i++) {
			var cb = document.getElementById('br_ck' + i);
			var row = document.getElementById('br_row' + i);
			if (cb) cb.checked = master.checked;
			if (row) row.classList.toggle('checked-row', master.checked);
		}
		brUpdateDeleteButtonVisibility();
	}

	function brUpdateDeleteButtonVisibility() {
		var hasChecked = false;
		for (var i = 1; i <= BR_ROW_COUNT; i++) {
			var cb = document.getElementById('br_ck' + i);
			if (cb && cb.checked) {
				hasChecked = true;
				break;
			}
		}
		var btn = document.getElementById('br_delete_selected_btn');
		if (btn) btn.style.display = hasChecked ? 'inline-flex' : 'none';
	}

	function brDeleteSelectedRows() {
		var indexes = [];
		for (var i = 1; i <= BR_ROW_COUNT; i++) {
			var cb = document.getElementById('br_ck' + i);
			if (cb && cb.checked) indexes.push(i);
		}
		if (!indexes.length) return;
		Swal.fire({
			title: 'ลบรายการที่เลือก ?',
			html: 'คุณต้องการลบสินค้าที่เลือกไว้ ' + indexes.length + ' รายการ',
			showCancelButton: true,
			confirmButtonText: 'ยืนยันลบ',
			cancelButtonText: 'ยกเลิก',
			reverseButtons: true,
			iconHtml: BR_DELETE_ICON_HTML,
			customClass: BR_DELETE_CUSTOM_CLASS,
			buttonsStyling: false
		}).then(function(result) {
			if (result.isConfirmed) {
				indexes.forEach(function(i) {
					brExecuteClearRow(i);
				});
				brUpdateDeleteButtonVisibility();
			}
		});
	}

	/* ===== ลบ/เคลียร์แถวเดียว ===== */
	function brExecuteClearRow(rowIndex) {
		brRowFields.forEach(function(f) {
			var el = document.getElementById(f + rowIndex);
			if (el) el.value = '';
		});
		var label = document.getElementById('product_name_label' + rowIndex);
		if (label) label.textContent = '';
		var cb = document.getElementById('br_ck' + rowIndex);
		if (cb) cb.checked = false;
		var row = document.getElementById('br_row' + rowIndex);
		if (row) {
			row.classList.remove('checked-row');
			row.style.display = 'none';
		}
		brCalculateSummary();
		brSyncSelectAllState();
	}

	function brClearRow(rowIndex) {
		var code = document.getElementById('product_code' + rowIndex).value;
		var productId = document.getElementById('product_id' + rowIndex).value;
		var hasData = !!(code || productId);
		if (!hasData) {
			brExecuteClearRow(rowIndex);
			return;
		}
		var name = document.getElementById('product_name' + rowIndex).value;
		if (!name) {
			var label = document.getElementById('product_name_label' + rowIndex);
			if (label) name = label.textContent || '';
		}
		Swal.fire({
			title: 'ลบรายการสินค้า ?',
			html: 'คุณต้องการลบ "' + brEscapeHtml(name || code) + '" ในรายการสินค้านี้',
			showCancelButton: true,
			confirmButtonText: 'ตกลง',
			cancelButtonText: 'ยกเลิก',
			reverseButtons: true,
			iconHtml: BR_DELETE_ICON_HTML,
			customClass: BR_DELETE_CUSTOM_CLASS,
			buttonsStyling: false
		}).then(function(result) {
			if (result.isConfirmed) brExecuteClearRow(rowIndex);
		});
	}

	/* ===== ป๊อปอัปข้อมูลเพิ่มเติม (หมายเหตุสินค้า และ ชื่อที่แสดงในใบส่งสินค้า) ===== */
	function brOpenEditModal(rowIndex) {
		document.getElementById('br_edit_row_index').value = rowIndex;
		document.getElementById('br_m_remark').value = document.getElementById('sale_remarkk' + rowIndex).value;
		var displayNameEl = document.getElementById('br_m_display_name');
		if (displayNameEl) {
			displayNameEl.value = document.getElementById('display_name' + rowIndex).value || '';
		}

		var modal = document.getElementById('brEditModal');
		modal.style.display = 'flex';
		modal.setAttribute('aria-hidden', 'false');
	}

	function brCloseEditModal() {
		var modal = document.getElementById('brEditModal');
		modal.style.display = 'none';
		modal.setAttribute('aria-hidden', 'true');
	}

	function brSaveEditModal() {
		var rowIndex = document.getElementById('br_edit_row_index').value;
		if (!rowIndex) return;
		document.getElementById('sale_remarkk' + rowIndex).value = document.getElementById('br_m_remark').value;
		var displayNameEl = document.getElementById('br_m_display_name');
		if (displayNameEl && document.getElementById('display_name' + rowIndex)) {
			document.getElementById('display_name' + rowIndex).value = displayNameEl.value;
		}
		brCloseEditModal();
	}

	/* ===== ค้นหาสินค้า (ช่องค้นหากลาง) และเติมลงแถวว่างแรก ===== */
	function brFindFirstEmptyRow() {
		for (var i = 1; i <= BR_ROW_COUNT; i++) {
			var codeEl = document.getElementById('product_code' + i);
			if (codeEl && codeEl.value.trim() === '') return i;
		}
		return -1;
	}

	function brFetchProduct(rowIndex, productCode) {
		var pmeters = 'product_code=' + encodeURIComponent(productCode) + '&format=json';
		fetch('data_product_hos1.php', {
				method: 'POST',
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded'
				},
				body: pmeters
			})
			.then(function(res) {
				return res.json();
			})
			.then(function(product) {
				if (!product || !product.product_ID) return;

				document.getElementById('product_code' + rowIndex).value = productCode;
				document.getElementById('product_id' + rowIndex).value = product.product_ID;
				document.getElementById('product_name' + rowIndex).value = product.sol_name;
				var label = document.getElementById('product_name_label' + rowIndex);
				if (label) label.textContent = product.sol_name;
				document.getElementById('unit_name' + rowIndex).value = product.unit_name;
				document.getElementById('product_price' + rowIndex).value = product.sol_price;
				document.getElementById('warranty' + rowIndex).value = product.vvv;
				document.getElementById('store' + rowIndex).value = product.store || '';
				document.getElementById('store_remark' + rowIndex).value = product.store_remark || '';

				var row = document.getElementById('br_row' + rowIndex);
				if (row) row.style.display = '';

				var qtyEl = document.getElementById('sale_count' + rowIndex);
				if (qtyEl && !qtyEl.value) qtyEl.value = '1';

				brUpdateRowTotal(rowIndex);
				brCalculateSummary();

				setTimeout(function() {
					if (qtyEl) {
						qtyEl.focus();
						qtyEl.select();
					}
				}, 100);
			})
			.catch(function(err) {
				console.error('brFetchProduct failed', err);
			});
	}

	function brGlobalSearchInput() {
		var input = document.getElementById('br_global_search');
		var dropdown = document.getElementById('br_global_search_dd');
		var q = input.value.trim();

		clearTimeout(brGlobalSearchTimer);

		if (q.length < 1) {
			dropdown.style.display = 'none';
			dropdown.innerHTML = '';
			return;
		}

		brGlobalSearchTimer = setTimeout(function() {
			fetch('ajax_product_search_br.php?dept=' + brSearchDept + '&q=' + encodeURIComponent(q))
				.then(function(res) {
					return res.json();
				})
				.then(function(data) {
					dropdown.innerHTML = '';
					if (!data.success || !data.products || data.products.length === 0) {
						dropdown.innerHTML = '<div class="br-product-search-empty">ไม่พบสินค้า</div>';
						dropdown.style.display = 'block';
						return;
					}
					data.products.forEach(function(p) {
						var item = document.createElement('div');
						item.className = 'br-product-search-item';
						item.innerHTML = '<b>' + p.product_code + '</b> - ' + p.product_name;
						item.onclick = function() {
							dropdown.style.display = 'none';
							dropdown.innerHTML = '';
							input.value = '';
							var rowIndex = brFindFirstEmptyRow();
							if (rowIndex === -1) {
								alert('เพิ่มสินค้าไม่ได้ ตารางเต็ม (' + BR_ROW_COUNT + ' รายการ)');
								return;
							}
							brFetchProduct(rowIndex, p.product_code);
						};
						dropdown.appendChild(item);
					});
					dropdown.style.display = 'block';
				});
		}, 250);
	}

	document.addEventListener('click', function(evt) {
		if (!evt.target.closest('.br-product-search-wrap')) {
			document.querySelectorAll('.br-product-search-dropdown').forEach(function(dd) {
				dd.style.display = 'none';
			});
		}
	});

	/* ===== คำนวณยอดรวม ===== */
	function brUpdateRowTotal(rowIndex) {
		var qty = parseFloat((document.getElementById('sale_count' + rowIndex).value || '').toString().replace(/,/g, '')) || 0;
		var price = parseFloat((document.getElementById('product_price' + rowIndex).value || '').toString().replace(/,/g, '')) || 0;
		var total = qty * price;
		document.getElementById('sum_amount' + rowIndex).value = total.toLocaleString(undefined, {
			minimumFractionDigits: 2,
			maximumFractionDigits: 2
		});
	}

	function brCalculateSummary() {
		var qty = 0;
		var amount = 0;
		var itemCount = 0;
		for (var i = 1; i <= BR_ROW_COUNT; i++) {
			var codeEl = document.getElementById('product_code' + i);
			if (codeEl && codeEl.value.trim() !== '') {
				itemCount++;
			}
			var qtyEl = document.getElementById('sale_count' + i);
			var amtEl = document.getElementById('sum_amount' + i);
			if (qtyEl && qtyEl.value) {
				var q = parseFloat(qtyEl.value.toString().replace(/,/g, ''));
				if (!isNaN(q)) qty += q;
			}
			if (amtEl && amtEl.value) {
				var a = parseFloat(amtEl.value.toString().replace(/,/g, ''));
				if (!isNaN(a)) amount += a;
			}
		}
		document.getElementById('br_summary_qty').textContent = qty.toLocaleString();
		document.getElementById('br_summary_amount').textContent = amount.toLocaleString(undefined, {
			minimumFractionDigits: 2,
			maximumFractionDigits: 2
		});
		var netAmount = amount; // Adjust this if there's any discount calculation
		document.getElementById('br_summary_net').textContent = netAmount.toLocaleString(undefined, {
			minimumFractionDigits: 2,
			maximumFractionDigits: 2
		});

		var countTitle = document.getElementById('br_summary_item_count_title');
		if (countTitle) countTitle.textContent = itemCount + ' รายการ';

		var countLabel = document.getElementById('br_item_count_label');
		if (countLabel) {
			countLabel.textContent = itemCount + ' รายการ';
		}
	}

	$(document).ready(function() {
		brCalculateSummary();
	});

	/* ===== คีย์บอร์ด: ให้ปุ่มไอคอน (แก้ไข/ลบ) ที่ role="button" กด Enter/Space ได้ ===== */
	document.addEventListener('keydown', function(e) {
		if (e.key !== 'Enter' && e.key !== ' ') return;
		var target = e.target;
		if (target && target.matches && target.matches('.br-action-icon[role="button"]')) {
			e.preventDefault();
			target.click();
		}
	});
</script>