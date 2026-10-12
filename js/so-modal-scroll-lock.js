// ล็อกการเลื่อนของหน้าหลังขณะมี modal เปิดอยู่ (ต้องมี css/so-modal-ipad.css ด้วย)
// modal ทุกตัวเปิด/ปิดด้วย style.display จึงดูการเปลี่ยน style แทนการแก้ฟังก์ชันเปิด/ปิดของแต่ละตัว
// คลาสอยู่บน <html> ไม่ใช่ <body> เพราะ SweetAlert ล็อก body ของมันเอง (swal2-shown) จะได้ไม่ชนกัน
// สไตล์ล็อกอยู่ที่ html.so-modal-open ใน css/so-modal-ipad.css
// modal ที่ใช้คลาสอื่น (breqPoModal, brEditModal ฯลฯ) ใส่ data-so-modal-lock บน element ที่เปิด/ปิดด้วย style.display
var SO_MODAL_LOCK_SELECTOR = '.customer-popup-modal, #overLimitModal, [data-so-modal-lock]';
var SO_MODAL_LOCK_CLASS = 'so-modal-open';

function soAnyModalOpen() {
	var modals = document.querySelectorAll(SO_MODAL_LOCK_SELECTOR);
	for (var i = 0; i < modals.length; i++) {
		if (window.getComputedStyle(modals[i]).display !== 'none') return true;
	}
	return false;
}

function soSyncModalScrollLock() {
	var root = document.documentElement;
	var locked = root.classList.contains(SO_MODAL_LOCK_CLASS);
	var shouldLock = soAnyModalOpen();
	if (shouldLock === locked) return;

	if (shouldLock) {
		// วัดก่อนซ่อน scrollbar เพื่อชดเชยความกว้างที่หายไป (overlay scrollbar บน iPad ได้ 0)
		var scrollbarWidth = window.innerWidth - root.clientWidth;
		root.style.setProperty('--so-scrollbar-comp', scrollbarWidth + 'px');
		root.classList.add(SO_MODAL_LOCK_CLASS);
	} else {
		root.classList.remove(SO_MODAL_LOCK_CLASS);
		root.style.removeProperty('--so-scrollbar-comp');
	}
}

document.addEventListener('DOMContentLoaded', function() {
	var observer = new MutationObserver(soSyncModalScrollLock);
	var modals = document.querySelectorAll(SO_MODAL_LOCK_SELECTOR);
	for (var i = 0; i < modals.length; i++) {
		observer.observe(modals[i], { attributes: true, attributeFilter: ['style', 'class'] });
	}
	soSyncModalScrollLock();
});

// กด Back แล้วเบราว์เซอร์คืนหน้าจาก bfcache พร้อม modal ที่เปิดค้างอยู่ ต้องซิงก์สถานะล็อกใหม่
window.addEventListener('pageshow', soSyncModalScrollLock);
