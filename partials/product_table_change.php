<?php

/**
 * รายการสินค้า (Change Order) — 6-row product table, ported/trimmed from
 * partials/detail_brschos_so.php (10-row version) + the field layout of
 * detail_changehos.php / detail_changeng.php.
 */

if (!isset($ptcIsEngDept)) {
	$ptcIsEngDept = (($_SESSION["department"] ?? '') === 'วิศวกรรม');
}

$ptcSearchCodeEndpoint = $ptcIsEngDept ? 'data_product_engi.php' : 'data_product_hosi.php';
$ptcSearchNameEndpoint = $ptcIsEngDept ? 'data_product_eng_ptc.php' : 'data_product_hos_ptc.php';
$ptcSearchThaiEndpoint = $ptcIsEngDept ? 'data_product_ength.php' : 'data_product_searchth.php';
/* endpoint แยกเฉพาะ flow นี้ (ไม่ใช้ data_product_hos1.php ร่วมกับหน้าอื่นอีก 100+ หน้า)
   เพื่อ enforce close_pro/group1/แผนกให้ตรงกับ autocomplete ด้านบน */
$ptcDetailEndpoint = 'data_product_hos1_ptc.php';
?>
<script type="text/javascript" src="js/row-drag.js?v=<?php echo filemtime(__DIR__ . '/../js/row-drag.js'); ?>"></script>
<script type="text/javascript">
	if (typeof Swal === 'undefined') {
		var ptcSwalScript = document.createElement('script');
		ptcSwalScript.src = 'https://cdn.jsdelivr.net/npm/sweetalert2@11';
		document.head.appendChild(ptcSwalScript);
	}
</script>

<script language="JavaScript">
	/* ===== C1: field ทั้งหมดต่อแถวที่ต้องขยับตอน drag-reorder (ported จาก
	   detail_brschos_so.php's csFieldNames/csGetFieldValue/csSetFieldValue/csShiftRows,
	   ตัดฟิลด์ warranty/cal/pm/pm_year/print_name/discount_unit ออกเพราะ hos__subchange
	   ไม่มีคอลัมน์เหล่านี้) ===== */
	var ptcFieldNames = ['product_codet', 'product_id', 'product_name', 'product_name_view', 'unit_name', 'count_stock', 'count_sale', 'product_price', 'sum_amount', 'sn', 'sale_remarkk'];

	/* กรองสินค้าตามบริษัทที่เลือกใน #company_select (1=AWL/2=NBM ตามหน้านี้) - พอร์ตจาก
	   csGetSelectedTypeCompany() ของ detail_brschos_so.php, อ่านค่าสดทุกครั้งที่เรียกใช้
	   เผื่อผู้ใช้เปลี่ยน company หลังหน้าโหลดแล้ว */
	function ptcGetSelectedTypeCompany() {
		var sel = document.getElementById('company_select');
		return (sel && sel.value === '2') ? 'NBM' : 'AWL';
	}

	/* product_codet/product_name_view เป็น <span> แสดงผลล้วน (ไม่มี .value) ที่เหลือเป็น
	   form field จริง - อ่าน/เขียนผ่าน property ที่ element นั้นรองรับจริง */
	function ptcGetFieldValue(el) {
		if (!el) return '';
		return ('value' in el) ? el.value : el.textContent;
	}

	function ptcSetFieldValue(el, val) {
		if (!el) return;
		if ('value' in el) {
			el.value = val || '';
		} else {
			el.textContent = val || '';
		}
	}

	function ptcGetRowData(i) {
		var data = {};
		ptcFieldNames.forEach(function(name) {
			data[name] = ptcGetFieldValue(document.getElementById(name + i));
		});
		return data;
	}

	function ptcSetRowData(i, data) {
		ptcFieldNames.forEach(function(name) {
			ptcSetFieldValue(document.getElementById(name + i), data[name]);
		});
	}

	function ptcShiftRows(fromIndex, toIndex) {
		if (fromIndex === toIndex) return;
		var rows = [];
		for (var i = 1; i <= 6; i++) {
			rows.push(ptcGetRowData(i));
		}
		var moved = rows.splice(fromIndex - 1, 1)[0];
		rows.splice(toIndex - 1, 0, moved);
		for (var j = 1; j <= 6; j++) {
			ptcSetRowData(j, rows[j - 1]);
		}
		ptcRecalcSummary();
		ptcSyncRowVisibility();
		ptcUpdatePendingState();
	}

	/* แสดงเฉพาะแถวที่มีข้อมูลจริง (อย่างน้อย 1 แถวเสมอ เพื่อให้มีที่เติมสินค้าแรกได้ - แถวที่ 2-6
	   มี style="display:none;" ติดตัวมาจาก PHP อยู่แล้ว) ไม่เผยแถวว่างถัดไปล่วงหน้า - จะเลือกสินค้า
	   เพิ่มอีกกี่ชิ้นก็แค่ค้นหา/เลือกซ้ำ ระบบจะหาแถวว่างที่ซ่อนอยู่ให้เอง (ptcFindEmptyRowIndex)
	   แล้วเผยแถวนั้นพร้อมข้อมูลในคราวเดียว - เรียกซ้ำได้ทุกจุดที่ข้อมูลแถวเปลี่ยน (เติม/ลบ/ลากสลับ)
	   เพื่อ sync ให้ตรงเสมอ */
	function ptcSyncRowVisibility() {
		var lastFilled = 0;
		for (var i = 1; i <= 6; i++) {
			var idEl = document.getElementById('product_id' + i);
			if (idEl && idEl.value.trim() !== '') lastFilled = i;
		}
		var showUpTo = Math.max(1, lastFilled);
		for (var j = 1; j <= 6; j++) {
			var row = document.getElementById('ptc_row' + j);
			if (row) row.style.display = (j <= showUpTo) ? '' : 'none';
		}
	}

	/* ลากสลับแถว (js/row-drag.js — ลากได้ทั้งเมาส์และนิ้ว) */
	RowDrag.register({
		within: '#ptc_product_table',
		row: 'tr.so-product-row',
		onDrop: function(fromRow, toRow) {
			ptcShiftRows(parseInt(fromRow.id.replace('ptc_row', ''), 10), parseInt(toRow.id.replace('ptc_row', ''), 10));
		}
	});

	/* ===== เติมข้อมูลสินค้าลงแถวว่างแรกจากรหัสที่เลือกจากช่องค้นหาเดียวด้านบนตาราง
	   (ปลายทาง $ptcDetailEndpoint - data_product_hos1_ptc.php เฉพาะ flow นี้) ===== */
	function ptcFindEmptyRowIndex() {
		for (var i = 1; i <= 6; i++) {
			var idEl = document.getElementById('product_id' + i);
			if (idEl && idEl.value.trim() === '') {
				return i;
			}
		}
		return -1;
	}

	/* ===== C1 (Addendum 3): แถวที่เพิ่งเติมสินค้าแล้วแต่ยังไม่กรอกแลกเข้า/แลกออก
	   แสดงตัวเลขเป็นสีเทาอ่อนตาม Figma (node 599:3876 แถวที่ 3) จนกว่าจะกรอกจำนวนแถวนั้น ===== */
	function ptcUpdatePendingState() {
		for (var i = 1; i <= 6; i++) {
			var idEl = document.getElementById('product_id' + i);
			var row = document.getElementById('ptc_row' + i);
			if (!row) continue;
			var hasProduct = idEl && idEl.value.trim() !== '';
			var stockEl = document.getElementById('count_stock' + i);
			var saleEl = document.getElementById('count_sale' + i);
			var stockEmpty = !stockEl || parseFloat(stockEl.value) === 0 || isNaN(parseFloat(stockEl.value));
			var saleEmpty = !saleEl || parseFloat(saleEl.value) === 0 || isNaN(parseFloat(saleEl.value));
			row.classList.toggle('is-pending', hasProduct && stockEmpty && saleEmpty);
		}
	}

	function ptcApplyProductToRow(rowIndex, accessCode, product) {
		ptcSetFieldValue(document.getElementById('product_codet' + rowIndex), accessCode);
		ptcSetFieldValue(document.getElementById('product_id' + rowIndex), product.product_ID);
		ptcSetFieldValue(document.getElementById('product_name' + rowIndex), product.sol_name);
		ptcSetFieldValue(document.getElementById('product_name_view' + rowIndex), product.sol_name);
		ptcSetFieldValue(document.getElementById('unit_name' + rowIndex), product.unit_name);
		ptcSetFieldValue(document.getElementById('product_price' + rowIndex), product.sol_price);
		ptcRecalcSummary();
		ptcSyncRowVisibility();
		ptcUpdatePendingState();

		var stockEl = document.getElementById('count_stock' + rowIndex);
		if (stockEl) {
			stockEl.focus();
			stockEl.select();
		}
	}

	function ptcSearchDoCallAjax(accessCode, rowIndex) {
		var req = new XMLHttpRequest();
		req.open('POST', '<?php echo $ptcDetailEndpoint; ?>', true);
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
					ptcApplyProductToRow(rowIndex, accessCode, product);
				} catch (e) {
					console.error('Failed to parse product JSON:', e, req.responseText);
				}
			}
		};
		req.send('product_code=' + encodeURIComponent(accessCode) + '&format=json&type_company=' + ptcGetSelectedTypeCompany());
	}

	function ptcClearRow(i) {
		var idEl = document.getElementById('product_id' + i);
		var hasData = idEl && idEl.value.trim() !== '';

		function doClear() {
			ptcFieldNames.forEach(function(name) {
				ptcSetFieldValue(document.getElementById(name + i), '');
			});
			ptcRecalcSummary();
			ptcSyncRowVisibility();
			ptcUpdatePendingState();
		}

		if (!hasData) {
			doClear();
			return;
		}

		var nameEl = document.getElementById('product_name_view' + i);
		var productName = nameEl ? nameEl.textContent.trim() : '';
		var displayMsg = productName ? 'คุณต้องการลบรายการ "' + productName + '" ใช่หรือไม่ ?' : 'คุณต้องการลบรายการนี้ใช่หรือไม่ ?';

		if (typeof Swal === 'undefined') {
			if (confirm(displayMsg)) doClear();
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
			if (result.isConfirmed) doClear();
		});
	}

	/* มูลค่ารวมฝั่งแลกเข้า/แลกออก (จำนวน x ราคา/หน่วย) ของทั้ง 6 แถว - ใช้เทียบว่า
	   "ราคาต้องเท่ากัน" ตาม business rule การแลกเปลี่ยนสินค้า (เรียกจาก fncSubmit() ก่อน submit ด้วย) */
	function ptcGetValueTotals() {
		var valueIn = 0,
			valueOut = 0;
		for (var i = 1; i <= 6; i++) {
			var idEl = document.getElementById('product_id' + i);
			if (!idEl || idEl.value === '') continue;
			var stockEl = document.getElementById('count_stock' + i);
			var saleEl = document.getElementById('count_sale' + i);
			var priceEl = document.getElementById('product_price' + i);
			var price = priceEl ? (parseFloat(priceEl.value) || 0) : 0;
			if (stockEl) valueIn += (parseFloat(stockEl.value) || 0) * price;
			if (saleEl) valueOut += (parseFloat(saleEl.value) || 0) * price;
		}
		return {
			in: valueIn,
			out: valueOut
		};
	}

	/* มูลค่ารวม แลกเข้า/แลกออก/คงเหลือ ของทั้ง 6 แถว (ไม่ใช่จำนวนชิ้น) - อิงจาก
	   ptcGetValueTotals() ตัวเดียวกับที่ fncSubmit() ใช้ตรวจก่อน submit */
	function ptcRecalcSummary() {
		setTimeout(function() {
			var itemCount = 0;
			for (var i = 1; i <= 6; i++) {
				var idEl = document.getElementById('product_id' + i);
				if (!idEl || idEl.value === '') continue;
				itemCount++;
			}
			var valueTotals = ptcGetValueTotals();
			var inOut = document.getElementById('ptc_summary_in');
			var outOut = document.getElementById('ptc_summary_out');
			var netOut = document.getElementById('ptc_summary_net');
			var countOut = document.getElementById('ptc_summary_item_count');
			if (inOut) inOut.textContent = valueTotals.in.toFixed(2);
			if (outOut) outOut.textContent = valueTotals.out.toFixed(2);
			if (netOut) netOut.textContent = (valueTotals.in - valueTotals.out).toFixed(2);
			if (countOut) countOut.textContent = itemCount + ' รายการ';
		}, 200);
	}

	/* Modal แก้ไข "ข้อมูลรายการสินค้าเพิ่มเติม" — มีเฉพาะ หมายเลข SN (sn{i}) และ หมายเหตุสินค้า (sale_remarkk{i})
	   ตาม Figma (hos__subchange ไม่มีคอลัมน์ warranty/cal/pm/pm_year/print_name แบบฝั่ง BR/CS) */
	var ptcActiveEditRowIndex = null;

	function ptcOpenEditModal(rowIndex) {
		ptcActiveEditRowIndex = rowIndex;
		var snEl = document.getElementById('sn' + rowIndex);
		document.getElementById('ptc_modal_sn').value = snEl ? snEl.value : '';
		var remarkEl = document.getElementById('sale_remarkk' + rowIndex);
		document.getElementById('ptc_modal_sale_remarkk').value = remarkEl ? remarkEl.value : '';
		var modal = document.getElementById('ptc_edit_modal');
		if (modal) modal.style.display = 'flex';
	}

	function ptcCloseEditModal() {
		var modal = document.getElementById('ptc_edit_modal');
		if (modal) modal.style.display = 'none';
		ptcActiveEditRowIndex = null;
	}

	function ptcSaveEditModal() {
		if (!ptcActiveEditRowIndex) return;
		var snEl = document.getElementById('sn' + ptcActiveEditRowIndex);
		if (snEl) snEl.value = document.getElementById('ptc_modal_sn').value;
		var remarkEl = document.getElementById('sale_remarkk' + ptcActiveEditRowIndex);
		if (remarkEl) remarkEl.value = document.getElementById('ptc_modal_sale_remarkk').value;
		ptcCloseEditModal();
	}
</script>

<script src="dist/jautocalc.js"></script>

<div class="so-product-summary-bar" id="ptc_summary_bar">
	<div class="so-product-summary-col">
		<span class="so-product-summary-label">ยอดแลกสินค้าเข้า</span>
		<span class="so-product-summary-value" id="ptc_summary_in">0</span>
	</div>
	<div class="so-product-summary-col">
		<span class="so-product-summary-label">ยอดแลกสินค้าออก</span>
		<span class="so-product-summary-value" id="ptc_summary_out">0</span>
	</div>
	<div class="so-product-summary-col is-highlight">
		<span class="so-product-summary-label">ยอดหักลบ(คงเหลือ)</span>
		<span class="so-product-summary-value" id="ptc_summary_net">0</span>
	</div>
</div>

<!-- C1: ช่องค้นหาสินค้าเดียวเหนือตาราง แทนช่องค้นหา 3 ช่องต่อแถวเดิม ผูกกับ endpoint
     ตามแผนก ($ptcSearchNameEndpoint ที่คำนวณไว้ด้านบนแล้ว) เลือกแล้วเติมแถวว่างแถวแรก -->
<div class="cs-product-toolbar-row">
	<div class="so-field-group cs-product-search-wrap">
		<label class="so-label" for="ptc_product_search">ค้นหารายการสินค้า</label>
		<div class="cs-product-search-bar">
			<i class="fas fa-search" aria-hidden="true"></i>
			<input type="text" id="ptc_product_search" placeholder="ค้นหาด้วยรหัสสินค้า / ชื่อสินค้า" autocomplete="off">
		</div>
	</div>
</div>

<script type="text/javascript">
	(function() {
		var ptcProductAcInstance = new Autocomplete("ptc_product_search", function() {
			this.setValue = function(accessCode) {
				if (!accessCode) {
					return;
				}
				var rowIndex = ptcFindEmptyRowIndex();
				if (rowIndex === -1) {
					alert('ไม่สามารถเพิ่มสินค้าได้ (ตารางเต็ม 6 รายการแล้ว)');
					document.getElementById('ptc_product_search').value = '';
					return;
				}
				ptcSearchDoCallAjax(accessCode, rowIndex);
				document.getElementById('ptc_product_search').value = '';
			};

			if (this.value.length < 1 && this.isNotClick) return;
			return '<?php echo $ptcSearchNameEndpoint; ?>?product_code_search=' + encodeURIComponent(this.value) + '&type_company=' + ptcGetSelectedTypeCompany();
		}, {
			select_first: 0
		});

		/* autocomplete.js สร้างไอคอนวงกลมขวาสุดทับ input เองทุกครั้งที่ new Autocomplete() -
		   ซ่อนเฉพาะของ instance นี้เพราะมีไอคอนแว่นขยายซ้ายมืออยู่แล้ว (เหมือน detail_brschos_so.php) */
		if (ptcProductAcInstance.image && ptcProductAcInstance.image.e) {
			ptcProductAcInstance.image.e.style.display = 'none';
		}

		/* ดักจับ paste ด้วยเมาส์ (js/autocomplete.js เดิมฟังแค่ keydown/keypress) */
		var ptcSearchInput = document.getElementById('ptc_product_search');
		var ptcAcInstance = Autocomplete.inst[Autocomplete.inst.length - 1];
		ptcSearchInput.addEventListener('paste', function() {
			setTimeout(function() {
				ptcAcInstance.isModified = 1;
				ptcAcInstance.isNotClick = 1;
				ptcAcInstance.isON = 1;
				ptcAcInstance.request();
			}, 0);
		});
	})();
</script>

<div class="so-product-table-wrap" id="ptc_product_table_wrap">
	<table class="so-product-table" id="ptc_product_table">
		<thead>
			<tr>
				<th aria-label="ลากจัดเรียง" style="width:36px;"></th>
				<th style="width:13%;">รหัสสินค้า</th>
				<th style="width:25%;">รายการสินค้า</th>
				<th style="width:9%;">แลกเข้า</th>
				<th style="width:9%;">แลกออก</th>
				<th style="width:14%;">ราคา/หน่วย</th>
				<th style="width:16%;">ยอดรวม</th>
				<th style="width:90px;" aria-label="จัดการรายการ"></th>
			</tr>
		</thead>
		<tbody>
			<?php
			function ptc_product_row($i)
			{
			?>
				<tr class="so-product-row" id="ptc_row<?php echo $i; ?>"
					<?php if ($i > 1) { ?>style="display:none;" <?php } ?>>
					<td>
						<i class="fas fa-grip-vertical cs-drag-handle rd-handle"
							title="ลากเพื่อจัดเรียง"
							aria-hidden="true"></i>
					</td>
					<td>
						<span class="cs-code-text" id="product_codet<?php echo $i; ?>"></span>
						<input type="hidden" name="product_id<?php echo $i; ?>" id="product_id<?php echo $i; ?>">
						<input type="hidden" name="product_name<?php echo $i; ?>" id="product_name<?php echo $i; ?>">
						<input type="hidden" name="unit_name<?php echo $i; ?>" id="unit_name<?php echo $i; ?>">
					</td>
					<td>
						<span class="cs-product-name-text" id="product_name_view<?php echo $i; ?>"></span>
					</td>
					<td>
						<div class="cs-cell-pill">
							<input type="text" name="count_stock<?php echo $i; ?>" id="count_stock<?php echo $i; ?>" class="so-input" style="text-align:center" onchange="ptcRecalcSummary(); ptcUpdatePendingState();">
						</div>
					</td>
					<td>
						<div class="cs-cell-pill">
							<input type="text" name="count_sale<?php echo $i; ?>" id="count_sale<?php echo $i; ?>" class="so-input" style="text-align:center" onchange="ptcRecalcSummary(); ptcUpdatePendingState();">
						</div>
					</td>
					<td>
						<div class="cs-cell-pill">
							<input type="text" name="product_price<?php echo $i; ?>" id="product_price<?php echo $i; ?>" class="so-input" style="text-align:right" onchange="ptcRecalcSummary(); ptcUpdatePendingState();">
						</div>
					</td>
					<td>
						<input type="text" name="sum_amount<?php echo $i; ?>" id="sum_amount<?php echo $i; ?>" class="so-input" style="text-align:right" value=""
							jAutoCalc='({count_stock<?php echo $i; ?>} + {count_sale<?php echo $i; ?>}) * {product_price<?php echo $i; ?>}' readonly>
					</td>
					<td class="cs-row-actions-cell">
						<input type="hidden" name="sn<?php echo $i; ?>" id="sn<?php echo $i; ?>">
						<input type="hidden" name="sale_remarkk<?php echo $i; ?>" id="sale_remarkk<?php echo $i; ?>">
						<button type="button" class="cs-row-edit-btn" title="แก้ไขข้อมูลเพิ่มเติม" aria-label="แก้ไขข้อมูลเพิ่มเติมของรายการที่ <?php echo $i; ?>" onclick="ptcOpenEditModal(<?php echo $i; ?>);">
							<img src="img/icons/edit.svg" alt="" width="16" height="16">
						</button>
						<button type="button" class="so-product-remove-btn" title="ลบรายการ" aria-label="ลบรายการที่ <?php echo $i; ?>" onclick="ptcClearRow(<?php echo $i; ?>);"><img src="img/icons/trash.svg" alt="" width="16" height="18"></button>
					</td>
				</tr>
			<?php
			}

			for ($ptcI = 1; $ptcI <= 6; $ptcI++) {
				ptc_product_row($ptcI);
			}
			?>
		</tbody>
	</table>
</div>

<!-- Modal "ข้อมูลรายการสินค้าเพิ่มเติม" มีเฉพาะ หมายเลข SN และ หมายเหตุสินค้า ตาม Figma -->
<div id="ptc_edit_modal" class="cs-modal-overlay" style="display:none;">
	<div class="cs-modal-card">
		<div class="cs-modal-header">
			<h3 class="cs-modal-title">ข้อมูลรายการสินค้าเพิ่มเติม</h3>
			<button type="button" class="cs-modal-close-btn" onclick="ptcCloseEditModal();">&times;</button>
		</div>
		<div class="cs-modal-body">
			<div class="cs-modal-grid-2">
				<div class="so-field-group">
					<label class="so-label">หมายเลข SN</label>
					<input type="text" id="ptc_modal_sn" class="so-input" placeholder="ใส่เลข SN">
				</div>
				<div class="so-field-group">
					<label class="so-label">หมายเหตุสินค้า</label>
					<input type="text" id="ptc_modal_sale_remarkk" class="so-input" placeholder="ระบุหมายเหตุสินค้า">
				</div>
			</div>
		</div>
		<div class="cs-modal-footer">
			<button type="button" class="cs-modal-btn-update" onclick="ptcSaveEditModal();">อัพเดท</button>
			<button type="button" class="cs-modal-btn-cancel" onclick="ptcCloseEditModal();">ยกเลิก</button>
		</div>
	</div>
</div>

<script>
	(function ptcDetachEditModal() {
		var modal = document.getElementById('ptc_edit_modal');
		if (modal && modal.parentNode !== document.body) {
			document.body.appendChild(modal);
		}
	})();

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
		emptyAsZero: true,
		smartIntegers: false,
		onShowResult: null,
		funcs: {},
		vars: {}
	});
	ptcRecalcSummary();
	ptcSyncRowVisibility();
	ptcUpdatePendingState();
</script>
<?php
unset($ptcIsEngDept, $ptcSearchCodeEndpoint, $ptcSearchNameEndpoint, $ptcSearchThaiEndpoint, $ptcDetailEndpoint);
