<!-- ===================== Popup "เคลียร์ยืม" =====================
     Reuse ของ css/register-suphos.css (.clear-loan-*) — ค้นหาใบยืม (hos__br) ที่อนุมัติ
     แล้วและยังไม่ปิด ผ่าน data_clearbr_search_for_spr.php แล้วนำเข้ารายการที่เลือกเป็น
     แถวในตารางสินค้าของ register_engspr.php (clear_br=1, clear_ivno=ref_id_br ของใบยืม) -->
<div id="sprClearLoanModal" class="customer-popup-modal" aria-hidden="true" style="display:none;">
	<div class="customer-popup-box clear-loan-popup-box" role="dialog" aria-modal="true" aria-labelledby="sprClearLoanTitle">
		<button type="button" class="customer-popup-close" onclick="sprCloseClearLoanModal()" aria-label="Close">&times;</button>

		<div class="clear-loan-header">
			<h2 id="sprClearLoanTitle" class="clear-loan-title">เคลียร์ยืม — ค้นหาใบยืมที่ต้องการเคลียร์</h2>
		</div>

		<div class="clear-loan-top-controls">
			<div class="clear-loan-search-wrap">
				<label class="clear-loan-search-label" for="sprClearLoanSearch">ค้นหาด้วยเลขที่ใบยืม / ชื่อลูกค้า</label>
				<div class="clear-loan-search">
					<i class="fas fa-search" aria-hidden="true"></i>
					<input type="text" id="sprClearLoanSearch" placeholder="ระบุเลขที่ใบยืมหรือชื่อลูกค้า" autocomplete="off">
				</div>
			</div>
		</div>

		<div class="clear-loan-table-wrap">
			<div class="clear-loan-table-container">
				<table class="clear-loan-table">
					<thead>
						<tr>
							<th aria-label="ขยาย"></th>
							<th aria-label="เลือก"></th>
							<th>เลขที่ใบยืม</th>
							<th>วันที่</th>
							<th>ชื่อลูกค้า</th>
							<th>จำนวนรายการ</th>
						</tr>
					</thead>
					<tbody id="sprClearLoanRows">
						<tr class="clear-loan-state-row"><td colspan="6">พิมพ์คำค้นหาแล้วกด Enter หรือรอผลค้นหาอัตโนมัติ</td></tr>
					</tbody>
				</table>
			</div>
		</div>

		<div class="clear-loan-actions">
			<div class="clear-loan-action-container">
				<button type="button" class="clear-loan-btn clear-loan-btn-secondary" onclick="sprCloseClearLoanModal()">ยกเลิก</button>
				<button type="button" class="clear-loan-btn clear-loan-btn-primary" id="sprClearLoanImportBtn" disabled onclick="sprImportClearLoanSelection()">นำเข้ารายการที่เลือก</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	var sprClearLoanDocs = [];
	var sprClearLoanSelected = {}; // key: refIdBr + '|' + product_id -> item data
	var sprClearLoanRequestToken = 0;

	function sprEscapeHtmlCl(value) {
		return String(value === null || value === undefined ? '' : value).replace(/[&<>"']/g, function(ch) {
			return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' }[ch];
		});
	}

	function sprOpenClearLoanModal() {
		var modal = document.getElementById('sprClearLoanModal');
		if (!modal) return;
		modal.style.display = 'flex';
		modal.setAttribute('aria-hidden', 'false');
		sprClearLoanSelected = {};
		sprUpdateClearLoanImportBtn();
		sprSearchClearLoan('');
	}

	function sprCloseClearLoanModal() {
		var modal = document.getElementById('sprClearLoanModal');
		if (!modal) return;
		modal.style.display = 'none';
		modal.setAttribute('aria-hidden', 'true');
	}

	function sprSearchClearLoan(keyword) {
		var requestToken = ++sprClearLoanRequestToken;
		var tbody = document.getElementById('sprClearLoanRows');
		tbody.innerHTML = '<tr class="clear-loan-state-row"><td colspan="6">กำลังค้นหา...</td></tr>';

		// ใบยืมต้องเป็นบริษัทเดียวกับใบ SPR — sprGetTypeCompany() มาจาก partials/spr_item_table.php
		var url = 'data_clearbr_search_for_spr.php?keyword=' + encodeURIComponent(keyword || '') +
			'&type_company=' + encodeURIComponent(sprGetTypeCompany());
		fetch(url, { credentials: 'same-origin', cache: 'no-store' })
			.then(function(res) { return res.json(); })
			.then(function(data) {
				if (requestToken !== sprClearLoanRequestToken) return;
				if (!data || !data.success) {
					tbody.innerHTML = '<tr class="clear-loan-state-row"><td colspan="6">' + sprEscapeHtmlCl((data && data.message) || 'ค้นหาไม่สำเร็จ') + '</td></tr>';
					return;
				}
				sprClearLoanDocs = data.docs || [];
				sprRenderClearLoanRows();
			})
			.catch(function() {
				if (requestToken !== sprClearLoanRequestToken) return;
				tbody.innerHTML = '<tr class="clear-loan-state-row"><td colspan="6">ค้นหาไม่สำเร็จ กรุณาลองใหม่</td></tr>';
			});
	}

	function sprRenderClearLoanRows() {
		var tbody = document.getElementById('sprClearLoanRows');
		if (!sprClearLoanDocs.length) {
			tbody.innerHTML = '<tr class="clear-loan-state-row"><td colspan="6">ไม่พบใบยืมที่ค้างเคลียร์</td></tr>';
			return;
		}

		var html = '';
		sprClearLoanDocs.forEach(function(doc, docIndex) {
			html += '<tr>' +
				'<td><button type="button" class="clear-loan-expand-btn" onclick="sprToggleClearLoanDoc(' + docIndex + ', this)"><i class="fas fa-chevron-down" aria-hidden="true"></i></button></td>' +
				'<td></td>' +
				'<td>' + sprEscapeHtmlCl(doc.iv_no) + '</td>' +
				'<td>' + sprEscapeHtmlCl(doc.date_br) + '</td>' +
				'<td>' + sprEscapeHtmlCl(doc.customer) + '</td>' +
				'<td>' + doc.items.length + '</td>' +
				'</tr>';

			doc.items.forEach(function(item, itemIndex) {
				var key = doc.ref_id_br + '|' + item.product_id + '|' + itemIndex;
				// ใบยืมเก่าบางใบมีสินค้าต่างบริษัทปนอยู่ — แสดงให้เห็นแต่เลือกไม่ได้ (server ก็ไม่รับ)
				var selectable = item.company_match !== false;
				var mismatchNote = selectable ? '' :
					'<span class="clear-loan-item-meta spr-clear-loan-mismatch">สินค้าของ ' + sprEscapeHtmlCl(item.product_company || 'บริษัทอื่น') +
					' — นำเข้าใบ SPR ของ ' + sprEscapeHtmlCl(sprGetTypeCompany()) + ' ไม่ได้</span>';
				html += '<tr class="clear-loan-subrow' + (selectable ? '' : ' spr-clear-loan-disabled') + '" data-spr-doc="' + docIndex + '">' +
					'<td></td>' +
					'<td><label class="clear-loan-item-option" aria-label="เลือกรายการ">' +
						'<input type="checkbox" class="clear-loan-check-input"' + (selectable ? '' : ' disabled') +
						' onchange="sprToggleClearLoanItem(\'' + key + '\', this.checked)">' +
						'<span class="clear-loan-check-circle" aria-hidden="true"></span></label></td>' +
					'<td colspan="2">' + sprEscapeHtmlCl(item.product_name) + ' (' + sprEscapeHtmlCl(item.access_code) + ')' + mismatchNote + '</td>' +
					'<td>' + sprEscapeHtmlCl(item.count) + ' ' + sprEscapeHtmlCl(item.unit_name) + '</td>' +
					'<td></td>' +
					'</tr>';
				sprClearLoanItemLookup(key, doc, item);
			});
		});
		tbody.innerHTML = html;
	}

	var sprClearLoanItemMap = {};
	function sprClearLoanItemLookup(key, doc, item) {
		sprClearLoanItemMap[key] = { doc: doc, item: item };
	}

	function sprToggleClearLoanDoc(docIndex, button) {
		var expanded = button.classList.toggle('expanded');
		document.querySelectorAll('.clear-loan-subrow[data-spr-doc="' + docIndex + '"]').forEach(function(row) {
			row.classList.toggle('show', expanded);
		});
	}

	function sprToggleClearLoanItem(key, checked) {
		if (checked) {
			sprClearLoanSelected[key] = sprClearLoanItemMap[key];
		} else {
			delete sprClearLoanSelected[key];
		}
		sprUpdateClearLoanImportBtn();
	}

	function sprUpdateClearLoanImportBtn() {
		var btn = document.getElementById('sprClearLoanImportBtn');
		if (!btn) return;
		btn.disabled = Object.keys(sprClearLoanSelected).length === 0;
	}

	function sprImportClearLoanSelection() {
		var keys = Object.keys(sprClearLoanSelected);
		if (keys.length === 0) return;

		keys.forEach(function(key) {
			var entry = sprClearLoanSelected[key];
			if (!entry) return;
			sprAddRowFromClearLoan({
				product_id: entry.item.product_id,
				access_code: entry.item.access_code,
				product_name: entry.item.product_name,
				unit_name: entry.item.unit_name,
				count: entry.item.count,
				unit_price: entry.item.unit_price,
				ref_id_br: entry.doc.ref_id_br
			});
		});

		sprNotify('นำเข้ารายการเรียบร้อย', 'นำเข้า ' + keys.length + ' รายการจากใบยืมที่เลือกแล้ว', 'success');
		sprCloseClearLoanModal();
	}

	document.addEventListener('DOMContentLoaded', function() {
		var searchInput = document.getElementById('sprClearLoanSearch');
		if (searchInput) {
			var sprClearLoanSearchTimer = null;
			searchInput.addEventListener('input', function() {
				clearTimeout(sprClearLoanSearchTimer);
				var value = searchInput.value;
				sprClearLoanSearchTimer = setTimeout(function() { sprSearchClearLoan(value); }, 300);
			});
		}

		var modal = document.getElementById('sprClearLoanModal');
		if (modal) {
			modal.addEventListener('click', function(event) {
				if (event.target === modal) sprCloseClearLoanModal();
			});
			if (modal.parentNode !== document.body) {
				document.body.appendChild(modal);
			}
		}
	});
</script>
