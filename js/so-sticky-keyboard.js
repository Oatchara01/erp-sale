// iPad Safari: แป้นพิมพ์ลอยทับหน้าเว็บโดยไม่ย่อ layout viewport แถบปุ่มล่าง (.so-sticky-actions, sticky bottom: 0) จึงไปอยู่หลังแป้นพิมพ์
// และลอยกลางจอเมื่อเลื่อน ขณะแป้นพิมพ์เปิดใส่คลาส so-kb-open บน <html> ให้ css/so-core.css ปลดแถบออกจาก sticky
// วิธีตรวจแป้นพิมพ์ชุดเดียวกับ js/customer-popup.js: ไม่ทำอะไรถ้า layout viewport ย่อเอง (Android Chrome) หรือผู้ใช้ซูมอยู่
(function () {
	var vv = window.visualViewport;
	if (!vv) return;

	function syncStickyKeyboard() {
		var keyboardOpen = vv.scale <= 1.01 && (window.innerHeight - vv.height) > 120;
		document.documentElement.classList.toggle('so-kb-open', keyboardOpen);
	}

	vv.addEventListener('resize', syncStickyKeyboard);
	syncStickyKeyboard();
})();
