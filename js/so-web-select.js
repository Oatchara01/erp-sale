// Opt in a document via data-so-web-selects on this script, or opt in form containers.
// A DOM picker avoids the iPad system menu's font, which page CSS cannot control.
(function () {
	'use strict';
	var states = new Map();
	var opened = null;
	var sequence = 0;
	var copiedStyles = ['height', 'padding', 'border', 'borderRadius', 'backgroundColor', 'color', 'fontSize', 'fontWeight', 'marginTop'];

	function sync(state) {
		var select = state.select;
		var option = select.options[select.selectedIndex];
		var text = option ? option.text : '';
		if (state.text.textContent !== text) state.text.textContent = text;
		state.button.disabled = select.matches(':disabled');
		state.button.setAttribute('aria-required', String(select.required));
		state.button.setAttribute('aria-invalid', String(select.classList.contains('so-field-invalid')));
		var styleKey = select.className + '|' + select.getAttribute('style') + '|' + state.button.disabled;
		if (state.styleKey !== styleKey) {
			var style = getComputedStyle(select);
			copiedStyles.forEach(function (property) { state.button.style[property] = style[property]; });
			state.sourceDisplay = style.display;
			state.styleKey = styleKey;
		}
		state.button.hidden = select.hidden || state.sourceDisplay === 'none';
		if (opened === state && (state.button.disabled || !state.button.getClientRects().length)) close();
	}

	function close() {
		if (!opened) return;
		opened.list.remove();
		opened.button.setAttribute('aria-expanded', 'false');
		opened.button.removeAttribute('aria-activedescendant');
		opened.list = null;
		opened = null;
	}

	function activate(state, index) {
		state.active = index;
		Array.from(state.list.children).forEach(function (row) { row.classList.toggle('is-active', Number(row.dataset.index) === index); });
		var row = state.list.querySelector('[data-index="' + index + '"]');
		if (row) {
			state.button.setAttribute('aria-activedescendant', row.id);
			row.scrollIntoView({ block: 'nearest' });
		}
	}

	function allowed(option) {
		return !!option && !option.disabled && !option.hidden && !(option.parentElement.tagName === 'OPTGROUP' && (option.parentElement.disabled || option.parentElement.hidden));
	}

	function choose(state, index) {
		if (!allowed(state.select.options[index])) return;
		var previous = state.select.selectedIndex;
		state.select.selectedIndex = index;
		close();
		if (previous !== index) {
			state.select.dispatchEvent(new Event('input', { bubbles: true }));
			state.select.dispatchEvent(new Event('change', { bubbles: true }));
		}
		sync(state); // onchange may reject the new value (e.g. changing company).
		state.button.focus({ preventScroll: true });
	}

	function open(state) {
		sync(state);
		if (state.button.disabled) return;
		close();
		var list = document.createElement('div');
		list.id = state.listId;
		list.className = 'so-web-select-list';
		list.setAttribute('role', 'listbox');
		list.setAttribute('aria-label', state.label);
		// Keep popup dropdowns above their dialog, including pages with a focus trap.
		var dialog = state.button.closest('[role="dialog"], dialog, .customer-popup-modal, [data-so-modal-lock]');
		// Keep keyboard focus on the combobox; allow touch scrolling in the list.
		list.addEventListener('mousedown', function (event) { event.preventDefault(); });
		Array.from(state.select.options).forEach(function (option, index) {
			if (option.hidden || option.parentElement.hidden) return;
			var row = document.createElement('div');
			row.id = state.listId + '-' + index;
			row.dataset.index = index;
			row.setAttribute('role', 'option');
			row.setAttribute('aria-selected', String(index === state.select.selectedIndex));
			row.setAttribute('aria-disabled', String(!allowed(option)));
			row.textContent = option.text;
			row.addEventListener('click', function () { choose(state, index); });
			list.appendChild(row);
		});
		state.list = list;
		opened = state;
		(dialog || document.body).appendChild(list);
		if (dialog) {
			var highest = 10050;
			for (var ancestor = dialog; ancestor; ancestor = ancestor.parentElement) {
				var zIndex = parseInt(getComputedStyle(ancestor).zIndex, 10);
				if (!isNaN(zIndex)) highest = Math.max(highest, zIndex + 1);
			}
			list.style.zIndex = highest;
		}
		var rect = state.button.getBoundingClientRect();
		var viewport = window.visualViewport;
		var top = viewport ? viewport.offsetTop : 0;
		var bottom = top + (viewport ? viewport.height : window.innerHeight);
		var left = viewport ? viewport.offsetLeft : 0;
		var width = viewport ? viewport.width : window.innerWidth;
		list.style.width = Math.min(rect.width, width - 16) + 'px';
		list.style.left = Math.max(left + 8, Math.min(rect.left, left + width - list.offsetWidth - 8)) + 'px';
		var below = bottom - rect.bottom - 12;
		var above = rect.top - top - 12;
		var upwards = below < 180 && above > below;
		list.style.maxHeight = Math.max(44, Math.min(320, upwards ? above : below)) + 'px';
		list.style.top = (upwards ? rect.top - list.offsetHeight - 4 : rect.bottom + 4) + 'px';
		state.button.setAttribute('aria-expanded', 'true');
		var selected = state.select.selectedIndex;
		state.openSelection = selected;
		activate(state, selected >= 0 && allowed(state.select.options[selected]) ? selected : firstAllowed(state));
	}

	function firstAllowed(state) {
		return Array.from(state.select.options).findIndex(allowed);
	}

	function enhance(select) {
		if (states.has(select) || select.multiple || select.size > 1) return;
		if (!select.closest('.so-select-wrapper')) {
			var wrapper = document.createElement('div');
			wrapper.className = 'so-select-wrapper';
			select.before(wrapper);
			wrapper.appendChild(select);
		}
		// Additional-address rows are cloned; discard the copied presentation button.
		if (select.nextElementSibling && select.nextElementSibling.classList.contains('so-web-select-button')) select.nextElementSibling.remove();
		var label = select.labels && select.labels[0];
		var button = document.createElement('button');
		var text = document.createElement('span');
		var listId = 'so-web-select-list-' + (++sequence);
		var state = { select: select, button: button, text: text, listId: listId, label: label ? label.textContent.trim() : (select.name || 'เลือก'), list: null };
		button.type = 'button';
		button.className = 'so-web-select-button';
		button.setAttribute('role', 'combobox');
		button.setAttribute('aria-haspopup', 'listbox');
		button.setAttribute('aria-expanded', 'false');
		button.setAttribute('aria-controls', listId);
		button.setAttribute('aria-label', state.label);
		button.appendChild(text);
		select.after(button);
		select.classList.add('so-web-select-native');
		select.tabIndex = -1;
		select.setAttribute('aria-hidden', 'true');
		select.addEventListener('focus', function () { button.focus({ preventScroll: true }); });
		select.addEventListener('change', function () { sync(state); });
		button.addEventListener('click', function () { opened === state ? close() : open(state); });
		button.addEventListener('keydown', function (event) {
			var key = event.key;
			if (key === 'Escape' || key === 'Tab') { close(); return; }
			if (key === 'Enter' || key === ' ') {
				event.preventDefault();
				opened === state ? choose(state, state.active) : open(state);
				return;
			}
			if (['ArrowDown', 'ArrowUp', 'Home', 'End'].indexOf(key) !== -1) {
				event.preventDefault();
				if (opened !== state) { open(state); return; }
				var indexes = Array.from(select.options).map(function (option, index) { return allowed(option) ? index : -1; }).filter(function (index) { return index !== -1; });
				var current = indexes.indexOf(state.active);
				var next = key === 'Home' ? 0 : key === 'End' ? indexes.length - 1 : Math.max(0, Math.min(indexes.length - 1, current + (key === 'ArrowDown' ? 1 : -1)));
				if (indexes.length) activate(state, indexes[next]);
			} else if (key.length === 1) {
				event.preventDefault();
				if (opened !== state) open(state);
				state.search = Date.now() - (state.searchAt || 0) < 700 ? (state.search || '') + key : key;
				state.searchAt = Date.now();
				var index = Array.from(select.options).findIndex(function (option) { return allowed(option) && option.text.trim().toLocaleLowerCase().startsWith(state.search.toLocaleLowerCase()); });
				if (index >= 0) activate(state, index);
			}
		});
		states.set(select, state);
		new MutationObserver(function () { sync(state); if (opened === state) open(state); }).observe(select, { attributes: true, childList: true, subtree: true, characterData: true });
		sync(state);
	}

	function init() {
		var pageOptIn = document.querySelector('script[data-so-web-selects]');
		var roots = pageOptIn ? [document.body] : Array.from(document.querySelectorAll('[data-so-web-selects]'));
		if (!roots.length) return;
		function scan() { roots.forEach(function (root) { root.querySelectorAll('select.so-select').forEach(enhance); }); }
		scan();
		var observer = new MutationObserver(scan);
		roots.forEach(function (root) { observer.observe(root, { childList: true, subtree: true }); });
		// Existing prefill, address and jQuery code assign .value without change events.
		setInterval(function () {
			states.forEach(function (state, select) {
				if (!select.isConnected) { if (opened === state) close(); states.delete(select); return; }
				sync(state);
				if (opened === state && state.openSelection !== select.selectedIndex) open(state);
			});
		}, 200);
		document.addEventListener('pointerdown', function (event) { if (opened && !opened.button.contains(event.target) && !opened.list.contains(event.target)) close(); });
		document.addEventListener('focusin', function (event) { if (opened && event.target !== opened.button && !opened.list.contains(event.target)) close(); });
		window.addEventListener('resize', function () { close(); states.forEach(function (state) { state.styleKey = null; sync(state); }); });
		window.addEventListener('scroll', function (event) { if (opened && (!(event.target instanceof Node) || !opened.list.contains(event.target))) close(); }, true);
		if (window.visualViewport) { window.visualViewport.addEventListener('resize', close); window.visualViewport.addEventListener('scroll', close); }
		document.addEventListener('reset', function (event) {
			if (opened && opened.select.form === event.target) close();
			setTimeout(function () { states.forEach(sync); }, 0);
		});
	}

	if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init);
	else init();
})();
