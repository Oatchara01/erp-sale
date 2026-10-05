// ตรวจฟิลด์บังคับ (label ที่มีดอกจัน) แล้วไฮไลท์กรอบแดงทุกฟิลด์ที่ว่างพร้อมกัน แทน alert ทีละฟิลด์
// ใช้กับฟอร์มตระกูล .so-* : หน้าที่ใช้เรียก soValidateRequired(form) ในปุ่มบันทึก/Save Draft ของตัวเอง
// สไตล์กรอบแดงอยู่ที่ .so-field-invalid ใน css/so-core.css
// ฟิลด์บังคับ = control ใน .so-field-group ที่ .so-label มี <span>*</span> (ทั้ง class="required" และ style="color:red")
// .so-field-group ที่ถูกซ่อนตามเงื่อนไข (เช่น E-Mail เมื่อไม่ใช่ E-Tax) ไม่ถูกตรวจ แต่ฟิลด์ในแท็บที่ไม่ได้เปิดอยู่ยังถูกตรวจ
var SO_FIELD_INVALID_CLASS = 'so-field-invalid';
var SO_REQUIRED_CONTROL_SELECTOR = 'input:not([type="hidden"]):not([type="checkbox"]):not([type="radio"]):not([type="file"]), select, textarea';

function soIsRequiredLabel(label) {
	var spans = label.getElementsByTagName('span');
	for (var i = 0; i < spans.length; i++) {
		if (spans[i].textContent.trim() === '*') return true;
	}
	return false;
}

function soCollectRequiredFields(form) {
	var fields = [];
	var labels = form.querySelectorAll('.so-label');
	for (var i = 0; i < labels.length; i++) {
		var label = labels[i];
		if (!soIsRequiredLabel(label)) continue;
		var group = label.closest('.so-field-group');
		// ตรวจ display ของ group เอง ไม่ใช่ ancestor: แท็บที่ปิดอยู่ซ่อนที่ container ของแท็บ ไม่ได้ซ่อนที่ group
		if (group && window.getComputedStyle(group).display === 'none') continue;
		var control = label.htmlFor ? document.getElementById(label.htmlFor) : null;
		if (!control && group) control = group.querySelector(SO_REQUIRED_CONTROL_SELECTOR);
		if (control) fields.push(control);
	}
	return fields;
}

function soIsFieldEmpty(control) {
	return String(control.value || '').trim() === '';
}

// ฟิลด์ที่แสดงเป็น text: label for= ชี้ hidden input ที่เก็บค่า และ hidden input ประกาศ data-so-display = id ของ element ที่แสดงค่า
// กรอบแดง/เลื่อนจอทำที่ element แสดงผล (target) ส่วนการเช็คว่างอ่านจาก control เสมอ
function soFieldTarget(control) {
	var displayId = control.dataset ? control.dataset.soDisplay : '';
	return (displayId && document.getElementById(displayId)) || control;
}

function soFieldControl(target) {
	if ('value' in target || !target.id) return target;
	return document.querySelector('[data-so-display="' + target.id + '"]') || target;
}

var soInvalidFieldTimer = null;

// ค่าที่เติมด้วยโค้ด (เลือกลูกค้า, popup ที่อยู่) ไม่ยิง input/change จึงวนเช็คเฉพาะช่วงที่ยังมีกรอบแดงค้างอยู่
function soRefreshInvalidFields() {
	var invalid = document.querySelectorAll('.' + SO_FIELD_INVALID_CLASS);
	for (var i = 0; i < invalid.length; i++) {
		// ฟิลด์ที่มาร์กเองเพราะรูปแบบผิด (soMarkFieldInvalid) มีค่าอยู่แล้ว ให้ล้างเมื่อผู้ใช้แก้ค่าเท่านั้น
		if (invalid[i].dataset.soInvalidValue !== undefined) continue;
		if (!soIsFieldEmpty(soFieldControl(invalid[i]))) invalid[i].classList.remove(SO_FIELD_INVALID_CLASS);
	}
	if (!document.querySelector('.' + SO_FIELD_INVALID_CLASS) && soInvalidFieldTimer) {
		clearInterval(soInvalidFieldTimer);
		soInvalidFieldTimer = null;
	}
}

function soWatchInvalidFields() {
	if (!soInvalidFieldTimer) {
		soInvalidFieldTimer = setInterval(soRefreshInvalidFields, 300);
	}
}

function soClearFieldInvalid(control) {
	control.classList.remove(SO_FIELD_INVALID_CLASS);
	delete control.dataset.soInvalidValue;
}

// ใช้กับกฎที่ไม่ใช่ "ว่าง" (เช่น E-Mail ผิดรูปแบบ): กรอบแดงค้างจนกว่าผู้ใช้จะแก้ค่า
function soMarkFieldInvalid(control) {
	control.classList.add(SO_FIELD_INVALID_CLASS);
	control.dataset.soInvalidValue = control.value;
}

function soOnFieldEdited(event) {
	var control = event.target;
	if (!control.classList || !control.classList.contains(SO_FIELD_INVALID_CLASS)) return;
	if (control.dataset.soInvalidValue !== undefined) {
		if (control.value !== control.dataset.soInvalidValue) soClearFieldInvalid(control);
		return;
	}
	if (!soIsFieldEmpty(control)) soClearFieldInvalid(control);
}
document.addEventListener('input', soOnFieldEdited);
document.addEventListener('change', soOnFieldEdited);

// เปิดแท็บที่ครอบฟิลด์อยู่ (ปุ่มแท็บอ้าง id ของ content ใน onclick เช่น openDelTab('del_info', this)) แล้วเลื่อนจอไปหา
function soRevealField(control) {
	var hiddenTabs = [];
	for (var node = control.parentElement; node && node !== document.body; node = node.parentElement) {
		if (node.id && window.getComputedStyle(node).display === 'none') hiddenTabs.push(node);
	}
	// เปิดจากแท็บนอกสุดเข้าหาแท็บในสุด
	for (var i = hiddenTabs.length - 1; i >= 0; i--) {
		var tabBtn = document.querySelector('.so-tab-btn[onclick*="\'' + hiddenTabs[i].id + '\'"]');
		if (tabBtn) tabBtn.click();
	}
	control.scrollIntoView({
		block: 'center'
	});
	control.focus({
		preventScroll: true
	});
}

// opts.only: รายชื่อ name/id ที่จะตรวจ (ไม่ส่ง = ตรวจทุกฟิลด์บังคับ) คืน true เมื่อผ่านทั้งหมด
function soValidateRequired(form, opts) {
	if (!form) return true;
	var only = opts && opts.only ? opts.only : null;
	var fields = soCollectRequiredFields(form);
	var firstInvalid = null;

	for (var i = 0; i < fields.length; i++) {
		var control = fields[i];
		var target = soFieldTarget(control);
		soClearFieldInvalid(target);
		if (only && only.indexOf(control.name) === -1 && only.indexOf(control.id) === -1) continue;
		if (!soIsFieldEmpty(control)) continue;
		target.classList.add(SO_FIELD_INVALID_CLASS);
		if (!firstInvalid) firstInvalid = target;
	}

	if (!firstInvalid) return true;
	soRevealField(firstInvalid);
	soWatchInvalidFields();
	return false;
}
