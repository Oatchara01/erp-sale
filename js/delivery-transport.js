// ใช้ร่วมกันทุกฟอร์มที่ include partials/delivery_info_tab.php (suphos, supbrhos, supbrcshos, supchange, suprental, supsmp)
// ฟอร์มที่ใช้ต้องเรียก validateTransportCompanyRequirement(), validateDeliveryDateRange() และ validateDeliveryTimeRange() ใน fncSubmit และ
// updateTransportCompanyRequirement(String(ค่าที่บันทึกไว้)) หลังเติมค่า delivery_type ตอน edit
// validateDeliveryTimeRangeChoice() เรียกเฉพาะปุ่มบันทึก/Save Draft ของผู้สร้าง ไม่เรียกตอนอนุมัติหรือ Admin limited update
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

// ช่วงจัดส่ง 2 คู่ใช้กฎเดียวกัน: จัดส่งวันที่ (start_date) / ถึงวันที่ (between_date)
// และ จัดส่งตั้งแต่เวลา (start_time) / ถึงเวลา (end_time)
// ช่อง "ถึง" ไม่บังคับ แต่เติมให้เท่ากับช่องเริ่มอัตโนมัติ และต้องไม่ก่อนช่องเริ่ม
// วันที่เป็น YYYY-MM-DD เวลาเป็น HH:MM จึงเทียบกันแบบ string ได้ (length ตัดวินาทีของเวลาในเอกสารเก่าทิ้งก่อนเทียบ)
// เอกสารเก่าที่ between_date เป็นข้อความอิสระ date input จะปัดเป็นค่าว่างเอง แล้วถูกเติมเป็นวันที่ตอนบันทึก
// เอกสารเก่าที่ end_time ค้างค่า preset เดิมจนก่อน start_time จะแสดงตามจริง แล้วแจ้งเตือนตอนบันทึก
var DELIVERY_RANGES = {
	date: {
		startId: 'start_date',
		endId: 'between_date',
		length: 10,
		alert: 'ถึงวันที่ต้องไม่ก่อนจัดส่งวันที่'
	},
	time: {
		startId: 'start_time',
		endId: 'end_time',
		length: 5,
		alert: 'ถึงเวลาต้องไม่ก่อนจัดส่งตั้งแต่เวลา'
	}
};

function deliveryRangeValue(input, range) {
	return input.value.substring(0, range.length);
}

function bindDeliveryRange(range) {
	var startInput = document.getElementById(range.startId);
	var endInput = document.getElementById(range.endId);
	if (!startInput || !endInput) return;
	var lastStart = deliveryRangeValue(startInput, range);

	// ค่าที่เติมด้วยโค้ดตอน edit ไม่ยิง change จึงจำค่าเดิมตอน focus แทน
	startInput.addEventListener('focus', function() {
		lastStart = deliveryRangeValue(startInput, range);
	});
	startInput.addEventListener('change', function() {
		var start = deliveryRangeValue(startInput, range);
		var end = deliveryRangeValue(endInput, range);
		// ช่องถึงเท่ากับช่องเริ่มเดิม = ส่งวัน/เวลาเดียว ให้ขยับตามค่าใหม่ ไม่งั้นแก้ย้อนหลังแล้วจะกลายเป็นช่วงโดยไม่ตั้งใจ
		if (start && (end === '' || end < start || end === lastStart)) {
			endInput.value = start;
		}
		endInput.min = start;
		lastStart = start;
	});
	endInput.addEventListener('focus', function() {
		endInput.min = deliveryRangeValue(startInput, range);
	});
	// ตรวจตอน blur ไม่ใช่ change: พิมพ์ปีทีละหลักจะยิง change ตั้งแต่ปียังพิมพ์ไม่ครบ
	endInput.addEventListener('blur', function() {
		var start = deliveryRangeValue(startInput, range);
		var end = deliveryRangeValue(endInput, range);
		if (start && end !== '' && end < start) {
			alert(range.alert);
			endInput.value = start;
		}
	});
}
document.addEventListener('DOMContentLoaded', function() {
	bindDeliveryRange(DELIVERY_RANGES.date);
	bindDeliveryRange(DELIVERY_RANGES.time);
	bindDeliveryTimeRangePreset();
});

function validateDeliveryRange(range) {
	var startInput = document.getElementById(range.startId);
	var endInput = document.getElementById(range.endId);
	if (!startInput || !endInput) return true;
	var start = deliveryRangeValue(startInput, range);
	if (start && endInput.value === '') {
		endInput.value = start;
	}
	if (start && deliveryRangeValue(endInput, range) < start) {
		alert(range.alert);
		endInput.focus();
		return false;
	}
	return true;
}

function validateDeliveryDateRange() {
	return validateDeliveryRange(DELIVERY_RANGES.date);
}

function validateDeliveryTimeRange() {
	return validateDeliveryRange(DELIVERY_RANGES.time);
}

// เลือกช่วงเวลา (time_range): เก็บแยกคอลัมน์จาก start_time/end_time บังคับเลือกที่หน้าฟอร์มอย่างเดียว
// เอกสารเก่าไม่มีค่านี้ จึงไม่ตรวจฝั่ง backend และไม่ตรวจตอนอนุมัติ ไม่งั้นเอกสารที่ค้างอนุมัติจะเดินต่อไม่ได้
function validateDeliveryTimeRangeChoice() {
	var timeRangeSel = document.getElementById('time_range');
	if (!timeRangeSel) return true;
	if (timeRangeSel.value === '') {
		alert('กรุณาเลือกช่วงเวลา');
		timeRangeSel.focus();
		return false;
	}
	return true;
}

// เลือกช่วงเวลาแล้วเติม start_time/end_time ให้ (กฎเดียวกับ return_time_range ของส่วนที่อยู่การคืน)
// ผูกทางเดียว: แก้เวลาเองแล้วช่วงเวลาไม่เปลี่ยนตาม และไม่ sync ตอนโหลดหน้า เอกสารเดิมจึงแสดงตามที่บันทึก
var DELIVERY_TIME_RANGE_PRESETS = {
	morning: ['08:00', '12:00'],
	afternoon: ['13:00', '17:00'],
	allday: ['08:00', '17:00']
};

function bindDeliveryTimeRangePreset() {
	var timeRangeSel = document.getElementById('time_range');
	var startInput = document.getElementById(DELIVERY_RANGES.time.startId);
	var endInput = document.getElementById(DELIVERY_RANGES.time.endId);
	if (!timeRangeSel || !startInput || !endInput) return;

	timeRangeSel.addEventListener('change', function() {
		var preset = DELIVERY_TIME_RANGE_PRESETS[timeRangeSel.value];
		if (preset) {
			startInput.value = preset[0];
			endInput.value = preset[1];
		} else if (timeRangeSel.value === 'specific') {
			// เวลาเริ่มที่เป็นค่า preset ค้างอยู่ให้ล้าง เวลาที่ผู้ใช้กรอกเองคงไว้
			var start = deliveryRangeValue(startInput, DELIVERY_RANGES.time);
			if (start === '08:00' || start === '13:00') {
				startInput.value = '';
			}
			endInput.value = '';
			startInput.focus();
		} else {
			startInput.value = '';
			endInput.value = '';
		}
		// ค่าที่เติมด้วยโค้ดไม่ยิง change ของ bindDeliveryRange จึงต้องขยับ min เอง ไม่งั้น min เดิมค้างจนช่องถึงเวลาไม่ผ่าน
		endInput.min = deliveryRangeValue(startInput, DELIVERY_RANGES.time);
	});
}
