// Shared "แนบไฟล์" tab behavior for the doc_tabs_card partial, used by
// register_suphos.php, register_supbrhos.php, register_supchange.php and register_supsmp.php.
// Default: posts to slip1-slip5 input names (slip1 reserved, slots 2-5 dynamic, links to upload/).
// A page can override this via data-* on #attach_file_list (emitted by the partial's
// attach_file config): first-slot, last-slot, base-url, max-bytes, allowed-ext.
// Elements that only exist in edit-mode pages (hidden_slip_val{i}, hidden_remove_val{i},
// file_name_display) are optional and null-guarded.

function attachConfig() {
	const list = document.getElementById('attach_file_list');
	const data = list ? list.dataset : {};
	return {
		firstSlot: parseInt(data.firstSlot, 10) || 2,
		lastSlot: parseInt(data.lastSlot, 10) || 5,
		baseUrl: data.baseUrl || 'upload/',
		maxBytes: parseInt(data.maxBytes, 10) || 1100000,
		allowedExt: data.allowedExt ? data.allowedExt.toLowerCase().split(',') : []
	};
}

function triggerAttachFile() {
	const cfg = attachConfig();
	for (let i = cfg.firstSlot; i <= cfg.lastSlot; i++) {
		const input = document.getElementById('hidden_slip' + i);
		const hiddenVal = document.getElementById('hidden_slip_val' + i);
		if (input && !input.value && (!hiddenVal || !hiddenVal.value)) {
			input.click();
			return;
		}
	}
	alert('สามารถแนบไฟล์เพิ่มเติมได้สูงสุด ' + (cfg.lastSlot - cfg.firstSlot + 1) + ' ไฟล์ครับ');
}

function handleFileSelect(input, index) {
	const cfg = attachConfig();
	const file = input.files && input.files[0];
	if (file) {
		const ext = file.name.split('.').pop().toLowerCase();
		let title = '';
		let problem = '';
		if (cfg.allowedExt.length && cfg.allowedExt.indexOf(ext) === -1) {
			title = 'ชนิดไฟล์ไม่ถูกต้อง';
			problem = 'รองรับเฉพาะไฟล์ ' + cfg.allowedExt.join(', ').toUpperCase();
		} else if (file.size > cfg.maxBytes) {
			title = 'ไฟล์มีขนาดเกินกำหนด';
			problem = 'กรุณาแนบไฟล์ที่มีขนาดไม่เกิน 1 MB';
		}
		if (problem) {
			input.value = '';
			if (typeof Swal !== 'undefined') {
				Swal.fire({
					icon: 'warning',
					title: title,
					text: problem
				});
			} else {
				alert(problem);
			}
		}
	}
	renderFileList();
}

function renderFileList() {
	const list = document.getElementById('attach_file_list');
	if (!list) return;

	const cfg = attachConfig();
	const fileNameDisplay = document.getElementById('file_name_display');
	const slip1Input = document.getElementById('hidden_slip1');
	const slip1HiddenVal = document.getElementById('hidden_slip_val1');
	list.innerHTML = '';

	if (fileNameDisplay) {
		if (slip1Input && slip1Input.files && slip1Input.files[0]) {
			fileNameDisplay.textContent = slip1Input.files[0].name;
		} else if (slip1HiddenVal && slip1HiddenVal.value) {
			fileNameDisplay.textContent = slip1HiddenVal.value;
		} else {
			fileNameDisplay.textContent = 'Choose File';
		}
	}

	for (let i = cfg.firstSlot; i <= cfg.lastSlot; i++) {
		const input = document.getElementById('hidden_slip' + i);
		const hiddenVal = document.getElementById('hidden_slip_val' + i);
		if (!input) continue;

		if (input.files && input.files[0]) {
			const fileName = input.files[0].name;

			const fileWrap = document.createElement('div');
			fileWrap.style.cssText = 'display: flex; flex-direction: column; width: 300px;';

			fileWrap.innerHTML = `
                <span style="font-size: 12px; color: #612989; font-weight: 600; margin-bottom: 4px;">ไฟล์ใหม่</span>
                <div style="background-color: #FFFFFF; border: 1px solid #EBEBEB; border-radius: 8px; padding: 12px 16px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                    <span style="color: #612989; text-decoration: underline; text-overflow: ellipsis; white-space: nowrap; overflow: hidden; font-size: 14px;">${fileName}</span>
                    <i class="far fa-trash-alt" style="color: #DC3545; cursor: pointer; font-size: 16px; margin-left: 12px;" onclick="removeFile(${i})"></i>
                </div>
            `;
			list.appendChild(fileWrap);
		} else if (hiddenVal && hiddenVal.value) {
			const fileName = hiddenVal.value;

			const fileWrap = document.createElement('div');
			fileWrap.style.cssText = 'display: flex; flex-direction: column; width: 300px;';

			fileWrap.innerHTML = `
                <span style="font-size: 12px; color: #28a745; font-weight: 600; margin-bottom: 4px;">ไฟล์เดิม</span>
                <div style="background-color: #FFFFFF; border: 1px solid #EBEBEB; border-radius: 8px; padding: 12px 16px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                    <a href="${cfg.baseUrl}${fileName}" target="_blank" style="color: #612989; text-decoration: underline; text-overflow: ellipsis; white-space: nowrap; overflow: hidden; font-size: 14px;">${fileName}</a>
                    <i class="far fa-trash-alt" style="color: #DC3545; cursor: pointer; font-size: 16px; margin-left: 12px;" onclick="removeExistingFile(${i})"></i>
                </div>
            `;
			list.appendChild(fileWrap);
		}
	}
}

function removeFile(index) {
	const input = document.getElementById('hidden_slip' + index);
	if (input) {
		input.value = ''; // Clear file
	}
	if (index === 1) {
		const slipUploadInput = document.getElementById('slip_upload');
		const fileNameDisplay = document.getElementById('file_name_display');
		if (slipUploadInput) {
			slipUploadInput.value = '';
		}
		if (fileNameDisplay) {
			fileNameDisplay.textContent = 'Choose File';
		}
	}
	renderFileList();
}

function removeExistingFile(index) {
	const hiddenVal = document.getElementById('hidden_slip_val' + index);
	if (hiddenVal) {
		hiddenVal.value = ''; // Clear file reference to delete from DB
	}
	// Pages whose backend deletes by explicit flag (register_supsmp.php: remove_up_img{i}) provide this input.
	const removeFlag = document.getElementById('hidden_remove_val' + index);
	if (removeFlag) {
		removeFlag.value = '1';
	}
	renderFileList();
}

document.addEventListener('DOMContentLoaded', function() {
	renderFileList();
});
