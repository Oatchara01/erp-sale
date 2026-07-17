// Shared "แนบไฟล์" tab behavior for the doc_tabs_card partial, used by
// register_suphos.php and register_supbrhos.php. Posts to slip1-slip5 input
// names; elements that only exist in edit-mode pages (hidden_slip_val{i},
// file_name_display) are optional and null-guarded.

function triggerAttachFile() {
	for (let i = 2; i <= 5; i++) {
		const input = document.getElementById('hidden_slip' + i);
		const hiddenVal = document.getElementById('hidden_slip_val' + i);
		if (input && !input.value && (!hiddenVal || !hiddenVal.value)) {
			input.click();
			return;
		}
	}
	alert('สามารถแนบไฟล์เพิ่มเติมได้สูงสุด 4 ไฟล์ครับ');
}

function handleFileSelect(input, index) {
	const maxFileSize = 1100000;
	if (input.files && input.files[0] && input.files[0].size > maxFileSize) {
		input.value = '';
		if (typeof Swal !== 'undefined') {
			Swal.fire({
				icon: 'warning',
				title: 'ไฟล์มีขนาดเกินกำหนด',
				text: 'กรุณาแนบไฟล์ที่มีขนาดไม่เกิน 1 MB'
			});
		} else {
			alert('กรุณาแนบไฟล์ที่มีขนาดไม่เกิน 1 MB');
		}
	}
	renderFileList();
}

function renderFileList() {
	const list = document.getElementById('attach_file_list');
	if (!list) return;

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

	for (let i = 2; i <= 5; i++) {
		const input = document.getElementById('hidden_slip' + i);
		const hiddenVal = document.getElementById('hidden_slip_val' + i);
		if (!input) continue;

		if (input.files && input.files[0]) {
			const fileName = input.files[0].name;

			const fileBox = document.createElement('div');
			fileBox.style.cssText = 'background-color: #FFFFFF; border: 1px solid #EBEBEB; border-radius: 8px; padding: 12px 16px; display: flex; align-items: center; justify-content: space-between; width: 300px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);';

			fileBox.innerHTML = `
                <div style="display: flex; flex-direction: column; overflow: hidden;">
                    <span style="font-size: 12px; color: #612989; font-weight: 600;">ไฟล์ใหม่</span>
                    <span style="color: #612989; text-overflow: ellipsis; white-space: nowrap; overflow: hidden; font-size: 14px;">${fileName}</span>
                </div>
                <i class="far fa-trash-alt" style="color: #DC3545; cursor: pointer; font-size: 16px; margin-left: 12px;" onclick="removeFile(${i})"></i>
            `;
			list.appendChild(fileBox);
		} else if (hiddenVal && hiddenVal.value) {
			const fileName = hiddenVal.value;

			const fileBox = document.createElement('div');
			fileBox.style.cssText = 'background-color: #FFFFFF; border: 1px solid #EBEBEB; border-radius: 8px; padding: 12px 16px; display: flex; align-items: center; justify-content: space-between; width: 300px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);';

			fileBox.innerHTML = `
                <div style="display: flex; flex-direction: column; overflow: hidden;">
                    <span style="font-size: 12px; color: #28a745; font-weight: 600;">ไฟล์เดิม</span>
                    <a href="upload/${fileName}" target="_blank" style="color: #612989; text-decoration: underline; text-overflow: ellipsis; white-space: nowrap; overflow: hidden; font-size: 14px;">${fileName}</a>
                </div>
                <i class="far fa-trash-alt" style="color: #DC3545; cursor: pointer; font-size: 16px; margin-left: 12px;" onclick="removeExistingFile(${i})"></i>
            `;
			list.appendChild(fileBox);
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
	renderFileList();
}

document.addEventListener('DOMContentLoaded', function() {
	renderFileList();
});
