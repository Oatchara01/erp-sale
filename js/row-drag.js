/* ลากสลับแถวตารางสินค้า — ใช้ Pointer Events แทน HTML5 drag & drop
   เพื่อให้ลากได้ทั้งเมาส์ นิ้ว (มือถือ / iPad) และ trackpad (ต้นแบบจาก product_salehos.php)

   วิธีใช้:
     1) ใส่ class "rd-handle" ที่ไอคอน/ช่องสำหรับลาก (ต้องอยู่ใน markup ตั้งแต่แรก เพราะ touch-action ต้องมีก่อนนิ้วแตะ)
     2) RowDrag.register({
            within: '#table_id',          // selector ของตาราง/tbody ที่ครอบแถว
            row: 'tr.so-product-row',     // selector ของแถวที่ลากได้
            resolveRow: function (el) {}, // (ไม่บังคับ) แปลง element ใต้นิ้วเป็นแถวปลายทาง
            onDrop: function (fromRow, toRow, after) {}
        });
        after = true เมื่อลากลง (วางใต้แถวปลายทาง), false เมื่อลากขึ้น (วางเหนือแถวปลายทาง)
   ลงทะเบียนก่อนตารางจะมีอยู่จริงได้ เพราะดัก pointerdown ที่ document (รองรับแถวที่สร้างด้วย JS ทีหลัง) */
(function () {
	'use strict';

	if (window.RowDrag) return;

	var configs = [];
	var drag = null; // { cfg, from, target, after, pointerId, handle, x, y, raf }
	var EDGE = 60;

	var css =
		'.rd-handle{cursor:grab;touch-action:none;user-select:none;-webkit-user-select:none;-webkit-touch-callout:none}' +
		'@media (pointer: coarse){i.rd-handle{padding:10px 6px;font-size:18px}}' +
		'.rd-dragging{opacity:.4}' +
		'.rd-over-before>td{box-shadow:inset 0 2px 0 #612989}' +
		'.rd-over-after>td{box-shadow:inset 0 -2px 0 #612989}' +
		'body.rd-active,body.rd-active *{cursor:grabbing!important;user-select:none;-webkit-user-select:none}';
	var style = document.createElement('style');
	style.appendChild(document.createTextNode(css));
	(document.head || document.documentElement).appendChild(style);

	function findConfig(handle) {
		for (var i = 0; i < configs.length; i++) {
			if (handle.closest(configs[i].within)) return configs[i];
		}
		return null;
	}

	// ขอบบนที่มองเห็นจริง — navbar ของระบบเป็น position: fixed สูง 64px บังขอบบนของหน้าอยู่
	function topEdge() {
		var nav = document.getElementById('top-navbar');
		if (!nav) return 0;
		var bottom = nav.getBoundingClientRect().bottom;
		return bottom > 0 ? bottom : 0;
	}

	function clearTarget() {
		if (drag.target) drag.target.classList.remove('rd-over-before', 'rd-over-after');
		drag.target = null;
	}

	function updateTarget() {
		// นิ้วอยู่ใต้ navbar / นอกจอ → หาแถวจากขอบที่มองเห็นแทน เส้นบอกตำแหน่งจะได้ไม่หาย
		var y = Math.min(Math.max(drag.y, topEdge() + 1), window.innerHeight - 1);
		var el = document.elementFromPoint(drag.x, y);
		var row = null;
		if (el) row = drag.cfg.resolveRow ? drag.cfg.resolveRow(el) : el.closest(drag.cfg.row);
		if (row && (row === drag.from || row.parentNode !== drag.from.parentNode || row.getClientRects().length === 0)) {
			row = null;
		}
		if (row === drag.target) return;

		clearTarget();
		if (!row) return;
		drag.after = !!(drag.from.compareDocumentPosition(row) & Node.DOCUMENT_POSITION_FOLLOWING);
		row.classList.add(drag.after ? 'rd-over-after' : 'rd-over-before');
		drag.target = row;
	}

	// เลื่อนหน้าจออัตโนมัติเมื่อลากไปใกล้ขอบบน/ล่าง (รายการยาวบนมือถือ)
	function autoScroll() {
		if (!drag) return;
		var top = topEdge();
		var h = window.innerHeight;
		var dy = 0;
		if (drag.y < top + EDGE) {
			dy = -Math.ceil((top + EDGE - drag.y) / 4);
		} else if (drag.y > h - EDGE) {
			dy = Math.ceil((drag.y - (h - EDGE)) / 4);
		}
		if (dy !== 0) {
			window.scrollBy(0, dy);
			updateTarget();
		}
		drag.raf = requestAnimationFrame(autoScroll);
	}

	function onMove(e) {
		if (!drag || e.pointerId !== drag.pointerId) return;
		e.preventDefault();
		drag.y = e.clientY;
		updateTarget();
	}

	function onEnd(e) {
		if (!drag || e.pointerId !== drag.pointerId) return;
		var d = drag;
		drag = null;

		cancelAnimationFrame(d.raf);
		d.handle.removeEventListener('pointermove', onMove);
		d.handle.removeEventListener('pointerup', onEnd);
		d.handle.removeEventListener('pointercancel', onEnd);
		d.handle.removeEventListener('lostpointercapture', onEnd);
		document.body.classList.remove('rd-active');
		d.from.classList.remove('rd-dragging');
		if (d.target) d.target.classList.remove('rd-over-before', 'rd-over-after');

		if (e.type === 'pointerup' && d.target) {
			d.cfg.onDrop(d.from, d.target, d.after);
		}
	}

	document.addEventListener('pointerdown', function (e) {
		if (drag) return; // กำลังลากอยู่ (เช่นนิ้วที่สองแตะ) — ไม่เริ่มรอบใหม่ทับ
		if (e.pointerType === 'mouse' && e.button !== 0) return;
		var handle = e.target.closest ? e.target.closest('.rd-handle') : null;
		if (!handle) return;
		var cfg = findConfig(handle);
		if (!cfg) return;
		var row = handle.closest(cfg.row);
		if (!row) return;
		e.preventDefault();

		var rect = handle.getBoundingClientRect();
		handle.setPointerCapture(e.pointerId);
		drag = {
			cfg: cfg,
			from: row,
			target: null,
			after: false,
			pointerId: e.pointerId,
			handle: handle,
			// หาแถวปลายทางจากแนวคอลัมน์ไอคอนลาก นิ้วเลื่อนออกด้านข้างก็ยังหาแถวเจอ
			x: rect.left + rect.width / 2,
			y: e.clientY,
			raf: null
		};

		row.classList.add('rd-dragging');
		document.body.classList.add('rd-active');
		handle.addEventListener('pointermove', onMove);
		handle.addEventListener('pointerup', onEnd);
		handle.addEventListener('pointercancel', onEnd);
		handle.addEventListener('lostpointercapture', onEnd);
		drag.raf = requestAnimationFrame(autoScroll);
	});

	window.RowDrag = {
		register: function (cfg) {
			configs.push(cfg);
		}
	};
})();
