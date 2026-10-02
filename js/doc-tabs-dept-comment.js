// Shared "ข้อความแจ้งแผนก" tab behavior for the doc_tabs_card partial, used by
// register_suphos.php and register_supbrhos.php. The calling page must declare
// `const savedCommentSoForDept = ...;` and `const savedCommentSoItemsForDept = ...;`
// (a plain object/null and an array respectively) in an inline <script> BEFORE
// this file's <script src> tag — classic top-level const/let bindings are
// visible to later script tags on the same page.

let commentIdCounter = 0;
const deptCodeToId = {
	cs: '1',
	en: '2',
	st: '3',
	ad: '4',
	ac: '5'
};
const deptIdToCode = {
	'1': 'cs',
	'2': 'en',
	'3': 'st',
	'4': 'ad',
	'5': 'ac'
};

function normalizeDeptValue(dept) {
	const value = String(dept || '');
	return deptCodeToId[value] || value;
}

function getDeptCode(dept) {
	const value = String(dept || '');
	return deptIdToCode[value] || value;
}

function escapeDeptCommentValue(value) {
	return String(value || '')
		.replace(/&/g, '&amp;')
		.replace(/"/g, '&quot;')
		.replace(/</g, '&lt;')
		.replace(/>/g, '&gt;');
}

function setTechnicianRequired(required) {
	const hidden = document.getElementById('hidden_technician_required');
	const button = document.getElementById('technician_required_btn');
	if (hidden) hidden.value = required ? '1' : '0';
	if (button) button.classList.toggle('btn-dept-active', !!required);
	// จุด ● บนแท็บ (js/doc-tabs-dots.js) — ค่านี้ถูกตั้งจากโค้ดตอน restore จึงไม่มี event ให้ดัก
	if (typeof docTabsRefreshDots === 'function') docTabsRefreshDots();
}

function toggleTechnicianRequired(button) {
	const isActive = !button.classList.contains('btn-dept-active');
	setTechnicianRequired(isActive);
}

function addDeptComment(defaultDept = '', defaultText = '', lockDept = false) {
	const list = document.getElementById('dept_comment_list');
	if (!list) return;

	const rowId = 'dept_row_' + commentIdCounter++;
	const selectedDept = normalizeDeptValue(defaultDept);
	const defaultTextValue = escapeDeptCommentValue(defaultText);

	const row = document.createElement('div');
	row.className = 'dept-row';
	row.id = rowId;

	row.innerHTML = `
        <div style="flex: 0 0 200px;">
            <label style="color: #612989; font-size: 13px; font-weight: 600; margin-bottom: 8px; display: block;">แผนก</label>
            <div class="so-select-wrapper${lockDept ? ' dept-locked' : ''}">
                <select class="so-select" onchange="syncDeptComments()" ${lockDept ? 'disabled' : ''}>
                    <option value="">เลือกแผนก</option>
                    <option value="1" ${selectedDept === '1' ? 'selected' : ''}>จัดส่ง</option>
                    <option value="2" ${selectedDept === '2' ? 'selected' : ''}>ช่าง</option>
                    <option value="3" ${selectedDept === '3' ? 'selected' : ''}>คลังสินค้า</option>
                    <option value="4" ${selectedDept === '4' ? 'selected' : ''}>Admin</option>
                    <option value="5" ${selectedDept === '5' ? 'selected' : ''}>บัญชี</option>
                </select>
            </div>
        </div>
        <div style="flex: 1; position: relative;">
            <label style="color: #612989; font-size: 13px; font-weight: 600; margin-bottom: 8px; display: block;">ข้อความ</label>
            <div style="position: relative; display: flex; align-items: center;">
                <input type="text" class="so-input dept-text-input" placeholder="กรอกข้อความสำหรับแจ้งแผนก..." style="width: 100%; padding-right: 60px;" value="${defaultTextValue}" oninput="syncDeptComments(); this.nextElementSibling.style.display = this.value ? 'block' : 'none';">
                <i class="fas fa-times" style="position: absolute; right: 40px; cursor: pointer; color: #8E8B94; display: ${defaultText ? 'block' : 'none'};" onclick="this.previousElementSibling.value=''; syncDeptComments(); this.style.display='none';"></i>
                <i class="far fa-trash-alt" style="position: absolute; right: 16px; color: #DC3545; cursor: pointer;" onclick="document.getElementById('${rowId}').remove(); syncDeptComments();"></i>
            </div>
        </div>
    `;
	list.appendChild(row);
	syncDeptComments();
}

function syncDeptComments() {
	let cs = '',
		en = '',
		st = '',
		ad = '';
	let items = [];

	const rows = document.querySelectorAll('.dept-row');
	rows.forEach((row, index) => {
		const dept = row.querySelector('select').value;
		const deptCode = getDeptCode(dept);
		const text = row.querySelector('.dept-text-input').value;

		if (dept !== '' && text.trim() !== '') {
			items.push({
				department_id: parseInt(dept, 10),
				message: text,
				sort_order: index + 1
			});

			if (deptCode === 'cs') cs += (cs ? '\n' : '') + text;
			if (deptCode === 'en') en += (en ? '\n' : '') + text;
			if (deptCode === 'st') st += (st ? '\n' : '') + text;
			if (deptCode === 'ad') ad += (ad ? '\n' : '') + text;
		}
	});

	const csEl = document.getElementById('hidden_comment_cs');
	const enEl = document.getElementById('hidden_comment_en');
	const stEl = document.getElementById('hidden_comment_st');
	const adEl = document.getElementById('hidden_comment_ad');
	const itemsEl = document.getElementById('hidden_dept_comment_items');
	if (csEl) csEl.value = cs;
	if (enEl) enEl.value = en;
	if (stEl) stEl.value = st;
	if (adEl) adEl.value = ad;
	if (itemsEl) itemsEl.value = JSON.stringify(items);
}

function restoreDeptComments() {
	const list = document.getElementById('dept_comment_list');
	if (!list) return;

	list.innerHTML = '';
	let addedAny = false;

	if (savedCommentSoForDept && typeof setTechnicianRequired === 'function') {
		setTechnicianRequired(savedCommentSoForDept.technician_required === '1' || savedCommentSoForDept.technician_required === 1);
	}

	if (Array.isArray(savedCommentSoItemsForDept) && savedCommentSoItemsForDept.length > 0) {
		savedCommentSoItemsForDept.forEach(function(item) {
			if (item.message && item.message.trim() !== '') {
				addDeptComment(item.department_id, item.message, true);
				addedAny = true;
			}
		});
	} else if (savedCommentSoForDept) {
		['cs', 'en', 'st', 'ad'].forEach(function(dept) {
			const commentText = savedCommentSoForDept['comment_' + dept];
			if (commentText && commentText.trim() !== '') {
				commentText.split('\n').forEach(function(line) {
					if (line.trim() !== '') {
						addDeptComment(dept, line, true);
						addedAny = true;
					}
				});
			}
		});
	}

	if (!addedAny) {
		addDeptComment();
	} else {
		syncDeptComments();
	}
}

document.addEventListener('DOMContentLoaded', restoreDeptComments);
