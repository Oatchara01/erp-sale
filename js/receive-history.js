/* modal "ประวัติการคืน" ของใบคืนสินค้า — ใช้ร่วมกันในหน้ารายการเอกสารต้นทาง 5 หน้า
 * (status_supbrhos / status_adminbrsc / status_brhos_breq / status_engbreg / status_samplesup)
 * ต้องโหลดคู่กับ css/register-receive.css (.rc-history-*) ข้อมูลมาจาก ajax_receive_history.php
 *
 *   rcOpenReceiveHistory(event, sourceType, sourceRef, title)  เปิด modal ของตัวเอง
 *   rcLoadReceiveHistory(container, sourceType, sourceRef)     เติมตารางลงใน element ที่หน้ามี modal อยู่แล้ว (หน้า BREQ)
 */
(function() {
	'use strict';

	function escapeHtml(value) {
		return String(value === undefined || value === null ? '' : value)
			.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
			.replace(/"/g, '&quot;').replace(/'/g, '&#39;');
	}

	function formatDate(value) {
		var match = /^(\d{4})-(\d{2})-(\d{2})/.exec(String(value || ''));
		if (!match || match[1] === '0000') return '-';
		return match[3] + '/' + match[2] + '/' + (parseInt(match[1], 10) + 543);
	}

	function renderTable(items) {
		if (!items.length) {
			return '<div class="rc-history-empty">ยังไม่มีใบคืนสินค้าของเอกสารนี้</div>';
		}
		var rows = items.map(function(item) {
			var status = item.status_label
				? '<span class="rc-history-pill" style="background:' + escapeHtml(item.status_color || '#7A767D') + ';">' + escapeHtml(item.status_label) + '</span>'
				: '-';
			var legacy = item.is_legacy ? '<span class="rc-history-legacy">(ใบเดิม)</span>' : '';
			return '<tr>' +
				'<td><a href="' + escapeHtml(item.url) + '" style="color:#612989;text-decoration:underline;font-weight:500;">' + escapeHtml(item.ref_id) + '</a>' + legacy + '</td>' +
				'<td>' + escapeHtml(formatDate(item.date_receive)) + '</td>' +
				'<td style="text-align:center;">' + escapeHtml(item.total_qty) + '</td>' +
				'<td>' + status + '</td>' +
				'<td>' + escapeHtml(item.add_by || '-') + '</td>' +
				'</tr>';
		}).join('');
		return '<div style="overflow-x:auto;"><table class="rc-history-table"><thead><tr>' +
			'<th>เลขที่ใบคืน</th><th>วันที่ฝากคืน</th><th style="text-align:center;">จำนวนรวม</th><th>สถานะ</th><th>ผู้บันทึก</th>' +
			'</tr></thead><tbody>' + rows + '</tbody></table></div>';
	}

	function fetchHistory(sourceType, sourceRef) {
		var url = 'ajax_receive_history.php?source_type=' + encodeURIComponent(sourceType) + '&source_ref=' + encodeURIComponent(sourceRef);
		return fetch(url, { credentials: 'same-origin', cache: 'no-store' })
			.then(function(response) {
				return response.text().then(function(text) {
					var data = null;
					try { data = JSON.parse(text); } catch (e) { data = null; }
					if (!data) throw new Error('เซิร์ฟเวอร์ตอบกลับไม่ถูกต้อง (HTTP ' + response.status + ')');
					if (!data.success) throw new Error(data.message || 'โหลดประวัติการคืนไม่สำเร็จ');
					return data.data;
				});
			});
	}

	window.rcLoadReceiveHistory = function(container, sourceType, sourceRef) {
		container.innerHTML = '<div class="rc-history-empty">กำลังโหลด...</div>';
		return fetchHistory(sourceType, sourceRef)
			.then(function(data) { container.innerHTML = renderTable(data.items); return data; })
			.catch(function(error) { container.innerHTML = '<div class="rc-history-error">' + escapeHtml(error.message) + '</div>'; });
	};

	function overlay() {
		var element = document.getElementById('rcHistoryOverlay');
		if (element) return element;
		element = document.createElement('div');
		element.id = 'rcHistoryOverlay';
		element.className = 'rc-history-overlay';
		element.hidden = true;
		element.innerHTML =
			'<div class="rc-history-box" role="dialog" aria-modal="true" aria-labelledby="rcHistoryTitle">' +
			'<div class="rc-history-head"><h2 class="rc-history-title" id="rcHistoryTitle">ประวัติการคืน <span id="rcHistoryRef"></span></h2>' +
			'<button type="button" class="rc-history-close" id="rcHistoryClose" aria-label="ปิด">&times;</button></div>' +
			'<div id="rcHistoryBody"></div></div>';
		document.body.appendChild(element);
		element.addEventListener('mousedown', function(event) {
			if (event.target === element) closeOverlay();
		});
		document.getElementById('rcHistoryClose').addEventListener('click', closeOverlay);
		document.addEventListener('keydown', function(event) {
			if (event.key === 'Escape' && !element.hidden) closeOverlay();
		});
		return element;
	}

	function closeOverlay() {
		var element = document.getElementById('rcHistoryOverlay');
		if (element) element.hidden = true;
	}

	window.rcOpenReceiveHistory = function(event, sourceType, sourceRef, title) {
		if (event) {
			event.preventDefault();
			event.stopPropagation();
		}
		Array.prototype.forEach.call(document.querySelectorAll('.so-dropdown-menu'), function(menu) { menu.classList.remove('show'); });
		var element = overlay();
		document.getElementById('rcHistoryRef').textContent = title || sourceRef;
		element.hidden = false;
		window.rcLoadReceiveHistory(document.getElementById('rcHistoryBody'), sourceType, sourceRef);
	};
})();
