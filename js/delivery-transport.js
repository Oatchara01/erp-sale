// ใช้ร่วมกันทุกฟอร์มที่ include partials/delivery_info_tab.php (suphos, supbrhos, supbrcshos, supchange, suprental)
// ฟอร์มที่ใช้ต้องเรียก validateTransportCompanyRequirement() ใน fncSubmit และ
// updateTransportCompanyRequirement(String(ค่าที่บันทึกไว้)) หลังเติมค่า delivery_type ตอน edit
// บริษัทขนส่ง/สถานที่รับสินค้า: ตัวเลือกเปลี่ยนตามวิธีการจัดส่ง และบังคับเลือกเมื่อ delivery_type = 3 หรือ 4
// 3 = พนักงานรับ/ลูกค้ารับ -> สถานที่รับ, 4 = บริษัทขนส่งภายนอก -> บริษัทขนส่ง, อื่น ๆ -> ซ่อน
// เปลี่ยนวิธีการจัดส่งแล้วค่าเดิมไม่อยู่ในรายการใหม่ -> ล้างค่า
var TRANSPORT_OPTIONS_BY_DELIVERY = {
	'3': [
		['7', 'รับที่ Show Room'],
		['8', 'รับที่โกดัง'],
		['9', 'รับที่ตึกเก่า']
	],
	'4': [
		['5', 'SPX Express'],
		['1', 'Kerry Express'],
		['6', 'Inter Express']
	]
};
var TRANSPORT_TEXT_BY_DELIVERY = {
	'3': {
		label: 'สถานที่รับสินค้า',
		placeholder: 'เลือกสถานที่รับสินค้า',
		alert: 'กรุณาเลือกสถานที่รับสินค้า เมื่อเลือกวิธีการจัดส่งเป็นพนักงานรับ/ลูกค้ารับ'
	},
	'4': {
		label: 'บริษัทขนส่ง',
		placeholder: 'เลือกบริษัทขนส่ง',
		alert: 'กรุณาเลือกบริษัทขนส่ง เมื่อเลือกวิธีการจัดส่งเป็นบริษัทขนส่งภายนอก'
	}
};
// รหัสเก่าที่เลิกใช้แล้ว แสดงเฉพาะเอกสารเดิมที่บันทึกไว้ (บริษัทขนส่งภายนอก)
var TRANSPORT_LEGACY_LABELS = {
	'2': 'Flash',
	'3': 'J&T',
	'4': 'ไปรษณีย์ไทย'
};

// preferredValue: ใช้ตอนโหลดข้อมูลเดิม (edit) เพื่อคืนค่าที่บันทึกไว้ รวมถึงรหัสเก่า
function updateTransportCompanyRequirement(preferredValue) {
	var deliveryTypeSel = document.getElementById('delivery_type');
	var transportSel = document.getElementById('transport_company');
	if (!deliveryTypeSel || !transportSel) return;
	var deliveryType = deliveryTypeSel.value;
	var options = TRANSPORT_OPTIONS_BY_DELIVERY[deliveryType] || [];
	var texts = TRANSPORT_TEXT_BY_DELIVERY[deliveryType] || TRANSPORT_TEXT_BY_DELIVERY['4'];
	var fromSaved = typeof preferredValue === 'string';
	var wanted = fromSaved ? preferredValue : transportSel.value;

	var transportGroup = transportSel.closest('.so-field-group');
	if (transportGroup) {
		transportGroup.style.display = options.length ? '' : 'none';
	}

	var label = document.querySelector('label[for="transport_company"]');
	if (label && label.firstChild && label.firstChild.nodeType === 3) {
		label.firstChild.nodeValue = texts.label;
	}

	transportSel.innerHTML = '';
	transportSel.appendChild(new Option(texts.placeholder, ''));
	var found = false;
	options.forEach(function(opt) {
		transportSel.appendChild(new Option(opt[1], opt[0]));
		if (opt[0] === wanted) found = true;
	});
	if (!found && fromSaved && deliveryType === '4' && TRANSPORT_LEGACY_LABELS[wanted]) {
		transportSel.appendChild(new Option(TRANSPORT_LEGACY_LABELS[wanted] + ' (เดิม)', wanted));
		found = true;
	}
	transportSel.value = found ? wanted : '';
}
document.addEventListener('DOMContentLoaded', function() {
	var deliveryTypeSel = document.getElementById('delivery_type');
	if (deliveryTypeSel) {
		deliveryTypeSel.addEventListener('change', function() {
			updateTransportCompanyRequirement();
		});
	}
	updateTransportCompanyRequirement();
});

function validateTransportCompanyRequirement() {
	var deliveryTypeSel = document.getElementById('delivery_type');
	var transportSel = document.getElementById('transport_company');
	if (!deliveryTypeSel || !transportSel) return true;
	var texts = TRANSPORT_TEXT_BY_DELIVERY[deliveryTypeSel.value];
	if (texts && transportSel.value === '') {
		alert(texts.alert);
		transportSel.focus();
		return false;
	}
	return true;
}
