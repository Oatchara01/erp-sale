<?php
$bregTypeProductOptions = isset($bregTypeProductOptions) && is_array($bregTypeProductOptions) ? $bregTypeProductOptions : array();
$bregSavedItems1 = isset($bregSavedItems1) && is_array($bregSavedItems1) ? $bregSavedItems1 : array();
$bregSavedItems2 = isset($bregSavedItems2) && is_array($bregSavedItems2) ? $bregSavedItems2 : array();

/** แปลงแถวจาก DB ให้เป็นรูปเดียวกับที่ JS ใช้สร้างแถว */
$bregRowsToJs = function (array $rows) {
	$out = array();
	foreach ($rows as $row) {
		$out[] = array(
			'product_id'   => (string)($row['product_id'] ?? ''),
			'access_code'  => (string)($row['access_code'] ?? ''),
			'product_name' => (string)($row['sol_name'] ?? ''),
			'unit_name'    => (string)($row['unit_name'] ?? ''),
			'count'        => (string)($row['count_value'] ?? ''),
			'sn'           => (string)($row['sn_number'] ?? ''),
			'remark'       => (string)($row['remark_eng'] ?? ''),
			'type_probd'   => (string)($row['type_probd'] ?? ''),
		);
	}
	return $out;
};
?>

<script type="text/javascript">
	/* ===== ข้อมูลตั้งต้นจากฝั่ง PHP ===== */
	var BREG_TYPE_PRODUCT_OPTIONS = <?php echo json_encode(array_values($bregTypeProductOptions), JSON_UNESCAPED_UNICODE); ?>;
	var BREG_SAVED_ITEMS = {
		g1: <?php echo json_encode($bregRowsToJs($bregSavedItems1), JSON_UNESCAPED_UNICODE); ?>,
		g2: <?php echo json_encode($bregRowsToJs($bregSavedItems2), JSON_UNESCAPED_UNICODE); ?>
	};

	var BREG_GROUPS = {
		g1: { hasType: false, label: 'รายการอะไหล่' },
		g2: { hasType: true, label: 'รายการอะไหล่' }
	};

	function bregEscapeHtml(value) {
		return String(value === null || value === undefined ? '' : value).replace(/[&<>"']/g, function(ch) {
			return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' }[ch];
		});
	}

	function bregGetTypeCompany() {
		// หน้านี้เป็น AWL อย่างเดียว (type_doc = 1) เหมือน register_bregawl.php เดิม
		var typeDoc = document.querySelector('input[name="type_doc"]');
		return (typeDoc && typeDoc.value === '2') ? 'NBM' : 'AWL';
	}

	function bregBuildTypeOptions(currentValue) {
		var current = String(currentValue || '').trim();
		var options = BREG_TYPE_PRODUCT_OPTIONS.slice();
		if (current !== '' && options.indexOf(current) === -1) {
			options.unshift(current);
		}

		var html = '<option value="">' + (options.length ? 'เลือกประเภทสินค้า' : 'ไม่มีข้อมูลประเภทสินค้า') + '</option>';
		options.forEach(function(name) {
			html += '<option value="' + bregEscapeHtml(name) + '"' + (name === current ? ' selected' : '') + '>' + bregEscapeHtml(name) + '</option>';
		});
		return html;
	}

	/* ===== แถวหนึ่งแถวของตาราง =====
	   ฟิลด์ทุกตัวเป็น array (ชื่อลงท้าย []) ลำดับใน POST = ลำดับ <tr> ใน DOM
	   การลากจัดเรียงจึงย้าย <tr> จริง ไม่ต้องสลับค่าทีละฟิลด์แบบตารางแบบช่องตายตัว */
	function bregBuildRowHtml(group, data) {
		data = data || {};
		var hasType = BREG_GROUPS[group].hasType;
		var p = group + '_';

		var html = '<tr class="so-product-row breg-row" draggable="false"' +
			' ondragover="bregHandleDragOver(event)" ondragenter="bregHandleDragEnter(event)"' +
			' ondragleave="bregHandleDragLeave(event)" ondrop="bregHandleDrop(event, this)">';

		html += '<td><i class="fas fa-grip-vertical cs-drag-handle" draggable="true" title="ลากเพื่อจัดเรียง" aria-hidden="true"' +
			' ondragstart="bregHandleDragStart(event, this)" ondragend="bregHandleDragEnd(event)"></i></td>';

		html += '<td>' +
			'<span class="cs-code-text breg-cell-code">' + bregEscapeHtml(data.access_code) + '</span>' +
			'<input type="hidden" name="' + p + 'product_id[]" class="breg-f-product_id" value="' + bregEscapeHtml(data.product_id) + '">' +
			'<input type="hidden" name="' + p + 'product_code[]" class="breg-f-access_code" value="' + bregEscapeHtml(data.access_code) + '">' +
			'<input type="hidden" name="' + p + 'product_name[]" class="breg-f-product_name" value="' + bregEscapeHtml(data.product_name) + '">' +
			'<input type="hidden" name="' + p + 'unit_name[]" class="breg-f-unit_name" value="' + bregEscapeHtml(data.unit_name) + '">' +
			'</td>';

		html += '<td><span class="cs-product-name-text breg-cell-name">' + bregEscapeHtml(data.product_name) + '</span>' +
			'<span class="breg-cell-unit">' + (data.unit_name ? 'หน่วย: ' + bregEscapeHtml(data.unit_name) : '') + '</span></td>';

		html += '<td><div class="cs-cell-pill">' +
			'<input type="text" name="' + p + 'count[]" class="so-input breg-f-count" inputmode="numeric" style="text-align:center"' +
			' value="' + bregEscapeHtml(data.count || '1') + '" onchange="bregNormalizeCount(this); bregRefreshSummary(\'' + group + '\');">' +
			'</div></td>';

		html += '<td><div class="cs-cell-pill">' +
			'<input type="text" name="' + p + 'sn[]" class="so-input breg-f-sn" placeholder="ใส่เลข SN" value="' + bregEscapeHtml(data.sn) + '">' +
			'</div></td>';

		if (hasType) {
			html += '<td><div class="so-select-wrapper breg-type-wrapper">' +
				'<select name="' + p + 'type_probd[]" class="so-select breg-f-type_probd">' + bregBuildTypeOptions(data.type_probd) + '</select>' +
				'</div></td>';
		}

		html += '<td class="cs-row-actions-cell">' +
			'<input type="hidden" name="' + p + 'remark[]" class="breg-f-remark" value="' + bregEscapeHtml(data.remark) + '">' +
			'<button type="button" class="cs-row-edit-btn" title="แก้ไขข้อมูลเพิ่มเติม" onclick="bregOpenEditModal(this);"><i class="far fa-edit" aria-hidden="true"></i></button>' +
			'<button type="button" class="so-product-remove-btn" title="ลบรายการ" onclick="bregRemoveRow(this);"><i class="far fa-trash-alt" aria-hidden="true"></i></button>' +
			'</td>';

		html += '</tr>';
		return html;
	}

	function bregTbody(group) {
		return document.getElementById('breg_tbody_' + group);
	}

	function bregRowGroup(row) {
		var table = row.closest('table');
		return table ? table.getAttribute('data-breg-group') : null;
	}

	function bregAddRow(group, data) {
		var tbody = bregTbody(group);
		if (!tbody) return null;
		tbody.insertAdjacentHTML('beforeend', bregBuildRowHtml(group, data));
		bregRefreshSummary(group);
		return tbody.lastElementChild;
	}

	/* จำนวนเป็นจำนวนเต็มบวก (คอลัมน์ count1/count2 เป็น decimal(20,0))
	   ค่าที่กรอกผิดรูปหรือ < 1 จะถูกดันกลับเป็น 1 ทันทีที่ออกจากช่อง */
	function bregNormalizeCount(input) {
		var raw = String(input.value || '').replace(/[^0-9]/g, '');
		var value = parseInt(raw, 10);
		input.value = (isNaN(value) || value < 1) ? '1' : String(value);
	}

	function bregRefreshSummary(group) {
		var tbody = bregTbody(group);
		var countEl = document.getElementById('breg_count_' + group);
		var emptyEl = document.getElementById('breg_empty_' + group);
		if (!tbody) return;

		var rows = tbody.querySelectorAll('tr.breg-row');
		var totalQty = 0;
		rows.forEach(function(row) {
			var qty = parseInt(row.querySelector('.breg-f-count') ? row.querySelector('.breg-f-count').value : '0', 10);
			if (!isNaN(qty)) totalQty += qty;
		});

		if (countEl) countEl.textContent = rows.length + ' รายการ';
		var qtyEl = document.getElementById('breg_qty_' + group);
		if (qtyEl) qtyEl.textContent = String(totalQty);
		if (emptyEl) emptyEl.style.display = rows.length === 0 ? '' : 'none';
	}

	/* ===== ลบแถว ===== */
	function bregRemoveRow(button) {
		var row = button.closest('tr');
		if (!row) return;
		var group = bregRowGroup(row);
		var nameEl = row.querySelector('.breg-cell-name');
		var productName = nameEl ? nameEl.textContent.trim() : '';
		var message = productName ? 'คุณต้องการลบรายการ "' + productName + '" ใช่หรือไม่ ?' : 'คุณต้องการลบรายการนี้ใช่หรือไม่ ?';

		function doRemove() {
			row.remove();
			bregRefreshSummary(group);
		}

		if (typeof Swal === 'undefined') {
			if (confirm(message)) doRemove();
			return;
		}

		Swal.fire({
			icon: 'warning',
			title: 'ยืนยันการลบรายการ',
			text: message,
			showCancelButton: true,
			confirmButtonText: 'ยืนยันลบ',
			cancelButtonText: 'ยกเลิก',
			reverseButtons: true,
			confirmButtonColor: '#DC3545',
			cancelButtonColor: '#612989'
		}).then(function(result) {
			if (result.isConfirmed) doRemove();
		});
	}

	/* ===== ลากจัดเรียง — ย้าย <tr> จริง ลำดับ POST จึงตามไปเอง ===== */
	var bregDraggedRow = null;

	function bregHandleDragStart(event, handle) {
		bregDraggedRow = handle.closest('tr');
		event.dataTransfer.effectAllowed = 'move';
		try { event.dataTransfer.setData('text/plain', 'breg-row'); } catch (e) {}
		if (bregDraggedRow) bregDraggedRow.classList.add('dragging');
	}

	function bregHandleDragOver(event) {
		event.preventDefault();
		event.dataTransfer.dropEffect = 'move';
	}

	function bregHandleDragEnter(event) {
		if (event.currentTarget) event.currentTarget.classList.add('drag-over');
	}

	function bregHandleDragLeave(event) {
		if (event.currentTarget) event.currentTarget.classList.remove('drag-over');
	}

	function bregHandleDrop(event, targetRow) {
		event.preventDefault();
		if (targetRow) targetRow.classList.remove('drag-over');
		if (!bregDraggedRow || bregDraggedRow === targetRow) return;
		// ห้ามลากข้ามกลุ่ม — สองตารางเป็นคนละ hos__subbreg
		if (bregDraggedRow.parentNode !== targetRow.parentNode) return;

		var rows = Array.prototype.slice.call(targetRow.parentNode.children);
		var from = rows.indexOf(bregDraggedRow);
		var to = rows.indexOf(targetRow);
		if (from < 0 || to < 0) return;

		targetRow.parentNode.insertBefore(bregDraggedRow, from < to ? targetRow.nextSibling : targetRow);
	}

	function bregHandleDragEnd() {
		document.querySelectorAll('tr.breg-row').forEach(function(row) {
			row.classList.remove('dragging', 'drag-over');
		});
		bregDraggedRow = null;
	}

	/* ===== เติมสินค้าจากช่องค้นหา =====
	   ค้นหาแล้วเลือก → ยิง data_product_hos1.php (format=json) เอารายละเอียดสินค้า
	   → เพิ่มเป็นแถวใหม่ท้ายตาราง สินค้าซ้ำเพิ่มได้อีกแถวโดยตั้งใจ เพราะแต่ละแถว
	   มีหมายเลขเครื่อง (SN) ของตัวเอง */
	function bregFetchProduct(group, accessCode) {
		var request = new XMLHttpRequest();
		request.open('POST', 'data_product_hos1.php', true);
		request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		request.onreadystatechange = function() {
			if (request.readyState !== 4) return;

			if (request.status !== 200 || request.responseText.trim() === '') {
				bregNotify('ไม่สามารถดึงข้อมูลสินค้าได้', 'กรุณาลองใหม่อีกครั้ง', 'error');
				return;
			}

			var product;
			try {
				product = JSON.parse(request.responseText);
			} catch (e) {
				bregNotify('ไม่สามารถอ่านข้อมูลสินค้าได้', 'รูปแบบข้อมูลจากระบบไม่ถูกต้อง', 'error');
				return;
			}

			if (product.found === false) {
				bregNotify('ไม่พบสินค้า', 'ไม่พบรหัสสินค้า "' + accessCode + '" ในระบบ', 'warning');
				return;
			}

			var row = bregAddRow(group, {
				product_id: product.product_ID,
				access_code: accessCode,
				product_name: product.sol_name,
				unit_name: product.unit_name,
				count: '1',
				sn: '',
				remark: '',
				type_probd: product.product_type || ''
			});

			if (row) {
				var countInput = row.querySelector('.breg-f-count');
				if (countInput) {
					countInput.focus();
					countInput.select();
				}
			}
		};
		request.send('product_code=' + encodeURIComponent(accessCode) + '&format=json&type_company=' + bregGetTypeCompany());
	}

	function bregNotify(title, text, icon) {
		if (typeof Swal === 'undefined') {
			alert(title + (text ? '\n' + text : ''));
			return;
		}
		Swal.fire({ title: title, text: text, icon: icon || 'info', confirmButtonColor: '#612989' });
	}

	/* ===== Modal "ข้อมูลรายการเพิ่มเติม" — หมายเหตุของแถว ===== */
	var bregEditingRow = null;

	function bregOpenEditModal(button) {
		bregEditingRow = button.closest('tr');
		if (!bregEditingRow) return;

		var remarkEl = bregEditingRow.querySelector('.breg-f-remark');
		document.getElementById('breg_modal_remark').value = remarkEl ? remarkEl.value : '';

		var modal = document.getElementById('breg_edit_modal');
		if (modal) modal.style.display = 'flex';
	}

	function bregCloseEditModal() {
		var modal = document.getElementById('breg_edit_modal');
		if (modal) modal.style.display = 'none';
		bregEditingRow = null;
	}

	/* ปุ่ม × ล้างเฉพาะช่องหมายเหตุใน modal (ไม่กระทบ hidden input ของแถวจนกว่าจะกด "อัพเดท") */
	function bregClearEditModalRemark() {
		var input = document.getElementById('breg_modal_remark');
		if (!input) return;
		input.value = '';
		input.focus();
	}

	function bregSaveEditModal() {
		if (bregEditingRow) {
			var remarkEl = bregEditingRow.querySelector('.breg-f-remark');
			if (remarkEl) remarkEl.value = document.getElementById('breg_modal_remark').value;
		}
		bregCloseEditModal();
	}

	/* ===== สลับกลุ่มด้วย radio — ซ่อน/แสดงเท่านั้น ข้อมูลอีกกลุ่มยังอยู่ใน DOM
	   และยังถูก POST ไปพร้อมกันทั้งสองกลุ่ม ===== */
	function bregSwitchGroup(group) {
		['g1', 'g2'].forEach(function(name) {
			var panel = document.getElementById('breg_panel_' + name);
			if (panel) panel.style.display = (name === group) ? '' : 'none';

			// หัวการ์ด (จำนวนรายการ) และกล่องจำนวนรวม อยู่นอก breg_panel_* — ต้องสลับคู่กันเอง
			var countEl = document.getElementById('breg_count_' + name);
			if (countEl) countEl.style.display = (name === group) ? '' : 'none';

			var qtyBox = document.getElementById('breg_qty_box_' + name);
			if (qtyBox) qtyBox.style.display = (name === group) ? '' : 'none';
		});
		var title = document.getElementById('breg_group_title');
		if (title && BREG_GROUPS[group]) title.textContent = BREG_GROUPS[group].label;
	}

	/** จำนวนแถวรวมทั้งสองกลุ่ม — fncSubmit() ใช้ตรวจว่ามีอย่างน้อย 1 รายการ */
	function bregTotalRowCount() {
		return document.querySelectorAll('#breg_tbody_g1 tr.breg-row, #breg_tbody_g2 tr.breg-row').length;
	}
</script>

<div class="cs-product-toolbar-row breg-toolbar-row">
	<div class="so-field-group cs-product-search-wrap">
		<label class="so-label" for="breg_product_search">ค้นหารายการอะไหล่</label>
		<div class="cs-product-search-bar">
			<i class="fas fa-search" aria-hidden="true"></i>
			<input type="text" id="breg_product_search" placeholder="ค้นหาด้วยรหัส / ชื่ออะไหล่" autocomplete="off">
		</div>
	</div>

	<!-- radio สลับสองกลุ่ม — ข้อมูลของอีกกลุ่มยังอยู่และยังถูกบันทึกพร้อมกันทั้งคู่ -->
	<div class="breg-group-switch" id="breg_group_switch">
		<label class="so-radio-label is-active" data-breg-group="g1">
			<input type="radio" name="breg_group" value="g1" checked onchange="bregSwitchGroup('g1'); bregSyncGroupSwitchUi();">
			<span>อะไหล่</span>
		</label>
		<label class="so-radio-label" data-breg-group="g2">
			<input type="radio" name="breg_group" value="g2" onchange="bregSwitchGroup('g2'); bregSyncGroupSwitchUi();">
			<span>อะไหล่จากสินค้า</span>
		</label>
	</div>
</div>

<script type="text/javascript">
	(function() {
		/* ช่องค้นหาช่องเดียวใช้ร่วมกันทั้งสองกลุ่ม — เติมลงกลุ่มที่กำลังเปิดอยู่
		   (autocomplete.js ผูก instance กับ id เดียว จึงสร้างช่องเดียวแล้วอ่าน radio
		   ตอนเลือกสินค้า แทนการสร้าง 2 instance ที่ต้อง sync กันเอง) */
		function bregActiveGroup() {
			var checked = document.querySelector('input[name="breg_group"]:checked');
			return checked ? checked.value : 'g1';
		}

		var bregAcInstance = new Autocomplete("breg_product_search", function() {
			this.setValue = function(accessCode) {
				if (!accessCode) return;
				bregFetchProduct(bregActiveGroup(), accessCode);
				document.getElementById('breg_product_search').value = '';
			};

			if (this.value.length < 1 && this.isNotClick) return;
			return 'data_product_engall.php?product_code_search=' + encodeURIComponent(this.value) +
				'&type_company=' + bregGetTypeCompany();
		}, { select_first: 0 });

		/* autocomplete.js แปะไอคอนวงกลมทับ input ทุกครั้งที่ new Autocomplete()
		   ซ่อนทิ้งเพราะช่องนี้มีไอคอนแว่นขยายด้านซ้ายอยู่แล้ว (เหมือน partials/product_table_change.php) */
		if (bregAcInstance.image && bregAcInstance.image.e) {
			bregAcInstance.image.e.style.display = 'none';
		}

		/* autocomplete.js เดิมฟังแค่ keydown/keypress — เพิ่ม paste ด้วยเมาส์ */
		var searchInput = document.getElementById('breg_product_search');
		var acInstance = Autocomplete.inst[Autocomplete.inst.length - 1];
		searchInput.addEventListener('paste', function() {
			setTimeout(function() {
				acInstance.isModified = 1;
				acInstance.isNotClick = 1;
				acInstance.isON = 1;
				acInstance.request();
			}, 0);
		});
	})();
</script>

<?php
$bregGroupDefs = array(
	'g1' => array('label' => 'รายการอะไหล่ที่ต้องการเบิก', 'hasType' => false),
	'g2' => array('label' => 'เบิกอะไหล่จากสินค้า', 'hasType' => true),
);
foreach ($bregGroupDefs as $bregKey => $bregDef) :
?>
	<div id="breg_panel_<?php echo $bregKey; ?>" class="breg-group-panel"<?php echo $bregKey === 'g1' ? '' : ' style="display:none;"'; ?>>
		<div class="so-product-table-wrap">
			<table class="so-product-table breg-product-table" id="breg_table_<?php echo $bregKey; ?>" data-breg-group="<?php echo $bregKey; ?>">
				<thead>
					<tr>
						<th aria-label="ลากจัดเรียง"></th>
						<th>รหัสสินค้า</th>
						<th>รายการสินค้า</th>
						<th>จำนวน</th>
						<th>หมายเลข SN</th>
						<?php if ($bregDef['hasType']) { ?><th>ประเภทสินค้า</th><?php } ?>
						<th aria-label="จัดการรายการ"></th>
					</tr>
				</thead>
				<tbody id="breg_tbody_<?php echo $bregKey; ?>"></tbody>
			</table>
		</div>

		<div class="breg-empty-state" id="breg_empty_<?php echo $bregKey; ?>">
			ยังไม่มีรายการในกลุ่มนี้ — ค้นหาสินค้าจากช่องด้านบนเพื่อเพิ่มรายการ
		</div>
	</div>
<?php endforeach; ?>

<!-- Modal ข้อมูลรายการเพิ่มเติม (หมายเหตุรายการ) -->
<div id="breg_edit_modal" class="cs-modal-overlay" style="display:none;">
	<div class="cs-modal-card breg-remark-modal-card">
		<div class="cs-modal-header">
			<h3 class="cs-modal-title">ข้อมูลรายการสินค้าเพิ่มเติม</h3>
			<button type="button" class="cs-modal-close-btn" onclick="bregCloseEditModal();" aria-label="ปิด">&times;</button>
		</div>
		<div class="cs-modal-body">
			<div class="so-field-group" style="margin-bottom:0;">
				<label class="so-label" for="breg_modal_remark">หมายเหตุสินค้า</label>
				<div class="so-input-wrapper">
					<input type="text" id="breg_modal_remark" class="so-input" placeholder="ระบุหมายเหตุสินค้า" autocomplete="off"
						onkeydown="if (event.key === 'Enter') { event.preventDefault(); }">
					<button type="button" class="fas fa-times so-clear-icon" onclick="bregClearEditModalRemark();" aria-label="ล้างค่าหมายเหตุสินค้า"></button>
				</div>
			</div>
		</div>
		<div class="cs-modal-footer">
			<button type="button" class="cs-modal-btn-update" onclick="bregSaveEditModal();">อัพเดท</button>
			<button type="button" class="cs-modal-btn-cancel" onclick="bregCloseEditModal();">ยกเลิก</button>
		</div>
	</div>
</div>

<script type="text/javascript">
	/* modal ต้องอยู่ระดับ body ไม่งั้น overlay จะถูก stacking context ของ .so-card ครอบ */
	(function bregDetachModal() {
		var modal = document.getElementById('breg_edit_modal');
		if (modal && modal.parentNode !== document.body) {
			document.body.appendChild(modal);
		}
	})();

	/* เติมรายการที่บันทึกไว้กลับเข้าตาราง (โหมดเปิด Draft เดิมกลับมาแก้) */
	(function bregRestoreSavedRows() {
		['g1', 'g2'].forEach(function(group) {
			(BREG_SAVED_ITEMS[group] || []).forEach(function(row) {
				bregAddRow(group, row);
			});
			bregRefreshSummary(group);
		});
	})();
</script>
