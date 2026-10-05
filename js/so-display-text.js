// ฟิลด์ฟอร์มที่แสดงเป็น text อย่างเดียว: hidden input เก็บค่าที่ POST ส่วน element ที่ data-so-display ชี้ไปแสดงค่า (ว่าง = "-")
// markup: <span id="X_text" class="so-display-text is-empty">-</span><input type="hidden" name="X" id="X" data-so-display="X_text">
// สไตล์อยู่ที่ .so-display-text ใน css/so-core.css ส่วนกรอบแดงฟิลด์บังคับอยู่ที่ js/so-required-fields.js (soFieldTarget)
// การตั้ง .value ด้วยโค้ดไม่ยิง event — ทุกจุดที่เขียน .value ของ hidden input ต้องเรียก soSyncDisplayText(element) ตาม
var SO_DISPLAY_EMPTY_TEXT = '-';

function soSyncDisplayText(element) {
	var displayId = element && element.dataset ? element.dataset.soDisplay : '';
	var display = displayId ? document.getElementById(displayId) : null;
	if (!display) return;
	var text = String(element.value || '').trim();
	display.textContent = text === '' ? SO_DISPLAY_EMPTY_TEXT : text;
	display.classList.toggle('is-empty', text === '');
}

function soSyncAllDisplayText() {
	var controls = document.querySelectorAll('[data-so-display]');
	for (var i = 0; i < controls.length; i++) {
		soSyncDisplayText(controls[i]);
	}
}

// DOMContentLoaded: ค่าที่ PHP พิมพ์ลง value="" มาตั้งแต่แรก
// pageshow: เบราว์เซอร์คืนค่า hidden input ให้เองตอนกด Back/รีเฟรช โดยไม่ผ่านโค้ดของหน้า
document.addEventListener('DOMContentLoaded', soSyncAllDisplayText);
window.addEventListener('pageshow', soSyncAllDisplayText);
