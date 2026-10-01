// Shared tab-dot behavior for the doc_tabs_card partial (loaded by the partial itself).
// The ● on a tab button (.so-tab-dot[data-tab-dot="<tab id>"]) is shown only while that tab
// holds user-entered data:
//   tab_doc_extra    - a visible pill/checkbox is ticked or a text field has text
//                      (hidden compat checkboxes are ignored - the user cannot see them)
//   tab_dept_comment - any message input has text, or "ต้องการช่างไปตรวจรับ" is on
//   tab_attach_file  - the tab lists at least one file (new or existing; slip1 is not listed)
// Pages that set values programmatically without firing events can call docTabsRefreshDots().

function docTabsHasText(inputs) {
	return Array.prototype.some.call(inputs, function(input) {
		return String(input.value || '').trim() !== '';
	});
}

function docTabsHasData(tabId) {
	const tab = document.getElementById(tabId);
	if (!tab) return false;

	if (tabId === 'tab_doc_extra') {
		return !!tab.querySelector('.so-doc-pill input[type="checkbox"]:checked, .so-input-with-checkbox input[type="checkbox"]:checked') ||
			docTabsHasText(tab.querySelectorAll('.so-doc-other-wrapper input[type="text"], .so-input-with-checkbox input.so-input'));
	}

	if (tabId === 'tab_dept_comment') {
		const technician = document.getElementById('hidden_technician_required');
		return (technician && technician.value === '1') ||
			docTabsHasText(tab.querySelectorAll('.dept-text-input'));
	}

	if (tabId === 'tab_attach_file') {
		const list = document.getElementById('attach_file_list');
		if (list) return list.children.length > 0;
		// Fallback mode of the partial: plain file inputs, no rendered list.
		return Array.prototype.some.call(tab.querySelectorAll('input[type="file"]'), function(input) {
			return input.files && input.files.length > 0;
		});
	}

	return false;
}

function docTabsRefreshDots() {
	document.querySelectorAll('.so-tab-dot[data-tab-dot]').forEach(function(dot) {
		dot.style.display = docTabsHasData(dot.dataset.tabDot) ? '' : 'none';
	});
}

(function() {
	if (window.docTabsDotsBound) return;
	window.docTabsDotsBound = true;

	function refreshSoon() {
		setTimeout(docTabsRefreshDots, 0);
	}

	function bind() {
		document.querySelectorAll('[data-doc-tabs-card]').forEach(function(card) {
			card.addEventListener('input', docTabsRefreshDots);
			card.addEventListener('change', docTabsRefreshDots);
			// Deferred so inline onclick handlers (remove row, toggle technician) run first.
			card.addEventListener('click', refreshSoon);
		});

		// Rows and file cards are rendered by JS (restoreDeptComments, renderFileList).
		if (typeof MutationObserver !== 'undefined') {
			['dept_comment_list', 'attach_file_list'].forEach(function(id) {
				const list = document.getElementById(id);
				if (list) new MutationObserver(docTabsRefreshDots).observe(list, { childList: true });
			});
		}

		docTabsRefreshDots();
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', bind);
	} else {
		bind();
	}
	// Pages that prefill fields from JS finish after DOMContentLoaded handlers have run.
	window.addEventListener('load', docTabsRefreshDots);
})();
