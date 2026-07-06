<?php header("Content-Type: text/html; charset=utf-8");
include("head.php"); ?>
<?php include('dbconnect_sale.php'); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="css/credit-term-modal.css?v=20260704">
<style>
	/* Custom Circular Checkbox/Radio Styling */
	.shipping-custom-radio {
		display: inline-block;
		position: relative;
		cursor: pointer;
		width: 20px;
		height: 20px;
		margin: 0;
		vertical-align: middle;
	}

	.shipping-custom-radio input {
		position: absolute;
		opacity: 0;
		cursor: pointer;
		height: 0;
		width: 0;
	}

	.shipping-custom-radio .checkmark {
		position: absolute;
		top: 0;
		left: 0;
		height: 20px;
		width: 20px;
		background-color: #fff;
		border: 1px solid #ccc;
		border-radius: 50%;
		transition: all 0.2s ease;
		box-sizing: border-box;
	}

	.shipping-custom-radio input:checked~.checkmark {
		background-color: #612989;
		border-color: #612989;
	}

	.shipping-custom-radio .checkmark:after {
		content: "";
		position: absolute;
		display: none;
	}

	.shipping-custom-radio input:checked~.checkmark:after {
		display: block;
	}

	.shipping-custom-radio .checkmark:after {
		left: 6px;
		top: 2px;
		width: 5px;
		height: 10px;
		border: solid white;
		border-width: 0 2px 2px 0;
		transform: rotate(45deg);
	}

	/* Clear Loan/Reserve Modal Styles */
	.clear-loan-popup-box {
		width: min(1096px, 96vw);
		height: min(980px, 92vh);
		padding-bottom: 92px;
	}

	.clear-loan-header {
		padding: 24px 32px 0;
		border-bottom: 1px solid #eee7f4;
	}

	.clear-loan-title {
		margin: 0;
		padding-bottom: 14px;
		border-bottom: 1px solid #eee7f4;
		color: #3b3b3b;
		font-size: 20px;
		font-weight: 500;
		line-height: 1.35;
	}

	.clear-loan-top-controls {
		display: flex;
		flex-direction: column;
		gap: 16px;
		padding: 18px 0;
	}

	.clear-loan-type-group {
		display: flex;
		flex-wrap: wrap;
		gap: 24px;
	}

	.clear-loan-radio-label {
		position: relative;
		display: flex;
		align-items: center;
		gap: 8px;
		font-size: 14px;
		color: #612989;
		font-weight: 500;
		cursor: pointer;
	}

	.so-custom-radio-input {
		position: absolute;
		opacity: 0;
		pointer-events: none;
	}

	.so-custom-radio-circle {
		width: 20px;
		height: 20px;
		border-radius: 50%;
		border: 1.5px solid #EFEBEF;
		display: inline-block;
		position: relative;
		box-sizing: border-box;
	}

	.so-custom-radio-input:checked+.so-custom-radio-circle {
		border-color: #612989;
	}

	.so-custom-radio-input:checked+.so-custom-radio-circle::after {
		content: "";
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
		width: 10px;
		height: 10px;
		background-color: #612989;
		border-radius: 50%;
	}

	.clear-loan-search-wrap {
		width: 100%;
		max-width: 600px;
	}

	.clear-loan-search-label {
		display: block;
		margin-bottom: 8px;
		font-size: 13px;
		font-weight: 500;
		color: #612989;
	}

	.clear-loan-search {
		height: 42px;
		display: flex;
		align-items: center;
		gap: 12px;
		padding: 0 14px;
		box-sizing: border-box;
		border-radius: 10px;
		border: 1px solid transparent;
		background: #f5f6f8;
		transition: border-color 0.2s, box-shadow 0.2s, background-color 0.2s;
	}

	.clear-loan-search i {
		color: #2f3337;
		font-size: 16px;
	}

	.clear-loan-search input {
		width: 100%;
		border: 0;
		outline: none;
		background: transparent;
		color: #3b3b3b;
		font-size: 16px;
		font-family: 'Prompt', sans-serif;
	}

	.clear-loan-search:focus-within {
		background-color: #FFFFFF;
		border-color: #612989;
		box-shadow: 0 0 0 3px rgba(97, 41, 137, 0.1);
	}

	.clear-loan-table-wrap {
		flex: 1;
		overflow: auto;
		border-top: 1px solid #612989;
		border-bottom: 1px solid #f0edf2;
	}

	.clear-loan-table-container {
		width: 100%;
		overflow-x: auto;
	}

	.clear-loan-table {
		width: 100%;
		min-width: 1080px;
		border-collapse: collapse;
		table-layout: auto;
		color: #3b3b3b;
		font-family: 'Prompt', sans-serif;
	}

	.clear-loan-table th,
	.clear-loan-table td {
		padding: 16px 12px;
		text-align: left;
		font-size: 14px;
		border-bottom: 1px solid #EFEBEF;
		color: #4A4A4A;
		vertical-align: middle;
	}

	.clear-loan-table th {
		padding: 12px 12px;
		color: #612989;
		font-size: 16px;
		font-weight: 500;
		white-space: nowrap;
	}

	.clear-loan-table th:first-child,
	.clear-loan-table td:first-child,
	.clear-loan-table th:nth-child(2),
	.clear-loan-table td:nth-child(2) {
		width: 40px;
		padding-left: 18px;
		padding-right: 6px;
	}

	.clear-loan-table tbody tr:hover {
		background-color: #F5F6F8;
	}

	.clear-loan-check-circle {
		width: 20px;
		height: 20px;
		border-radius: 50%;
		background-color: #F5F6F8;
		display: inline-block;
		cursor: pointer;
		position: relative;
		border: 1px solid transparent;
	}

	.clear-loan-check-input {
		position: absolute;
		opacity: 0;
		pointer-events: none;
	}

	.clear-loan-check-input:checked+.clear-loan-check-circle {
		background-color: #612989;
	}

	.clear-loan-check-input:checked+.clear-loan-check-circle::after {
		content: "";
		position: absolute;
		top: 4px;
		left: 7px;
		width: 5px;
		height: 9px;
		border: solid white;
		border-width: 0 2px 2px 0;
		transform: rotate(45deg);
	}

	.clear-loan-expand-btn {
		border: 0;
		background: transparent;
		cursor: pointer;
		color: #4A4A4A;
		display: inline-flex;
		align-items: center;
		justify-content: center;
		width: 24px;
		transition: transform 0.2s;
		padding: 0;
	}

	.clear-loan-expand-btn.expanded {
		transform: rotate(180deg);
	}

	.clear-loan-expand-btn:disabled {
		opacity: 0.35;
		cursor: default;
	}

	.clear-loan-subrow {
		display: none;
		background-color: #F1EDFA;
	}

	.clear-loan-subrow.show {
		display: table-row;
	}

	.clear-loan-subrow td {
		border-bottom: none;
		padding: 10px 12px;
		font-size: 14px;
		color: #4A4A4A;
		vertical-align: middle;
	}

	.clear-loan-item-option {
		position: relative;
		display: flex;
		align-items: center;
		gap: 12px;
		cursor: pointer;
	}

	.clear-loan-item-meta {
		display: block;
		margin-top: 4px;
		color: #6d6d6d;
		font-size: 12px;
	}

	.clear-loan-state-row td {
		padding: 28px 12px;
		text-align: center;
		color: #6d6d6d;
	}

	.clear-loan-table tbody tr:has(.clear-loan-check-input:checked) {
		background-color: #F1EDFA;
	}

	.clear-loan-actions {
		display: flex;
		align-items: center;
		justify-content: flex-end;
		padding: 22px 32px;
		border-top: 1px solid #f0edf2;
		position: absolute;
		bottom: 0;
		left: 0;
		right: 0;
		background: #fff;
		z-index: 10;
		border-radius: 0 0 10px 10px;
	}

	.clear-loan-action-container {
		display: flex;
		align-items: center;
		gap: 16px;
	}

	.clear-loan-btn {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		gap: 12px;
		height: 48px;
		padding: 0 40px;
		border-radius: 24px;
		font-size: 16px;
		font-weight: 500;
		font-family: 'Prompt', sans-serif;
		cursor: pointer;
		border: none;
		transition: all 0.2s;
	}

	.clear-loan-btn-primary {
		background-color: #612989;
		color: #FFFFFF;
		box-shadow: 0 2px 8px rgba(97, 41, 137, 0.2);
	}

	.clear-loan-btn-primary:hover:not(:disabled) {
		background-color: #502072;
	}

	.clear-loan-btn-primary:disabled {
		opacity: 0.5;
		cursor: not-allowed;
		box-shadow: none;
	}

	.clear-loan-btn-secondary {
		background-color: #FFFFFF;
		color: #4A4A4A;
		box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
		border: 1px solid #EFEBEF;
	}

	.clear-loan-btn-secondary:hover {
		background-color: #F8F8F8;
	}

	.credit-term-trigger {
		cursor: pointer;
		display: inline-flex;
		align-items: center;
		gap: 10px;
		padding: 0;
		border: none;
		background: transparent;
		font-family: 'Prompt', sans-serif;
		color: #612989;
	}

	.credit-term-trigger.is-empty {
		display: none;
	}

	.credit-term-trigger:disabled {
		cursor: default;
	}

	.credit-term-trigger:focus-visible {
		outline: 2px solid rgba(97, 41, 137, 0.35);
		outline-offset: 4px;
		border-radius: 8px;
	}

	.credit-term-trigger-text {
		font-size: 14px;
		line-height: 1.4;
		color: #612989;
		text-decoration: underline;
		text-underline-offset: 2px;
	}

	.credit-term-trigger-icon {
		width: 19.5px;
		height: 19.5px;
		object-fit: contain;
		flex: 0 0 19.5px;
	}

	.credit-term-popup-box {
		width: min(1096px, 96vw);
		height: min(884px, 92vh);
	}

	.credit-term-popup-content {
		display: flex;
		flex: 1;
		flex-direction: column;
		min-height: 0;
		padding: 22px 30px 30px;
		gap: 20px;
	}

	.credit-term-summary {
		display: grid;
		grid-template-columns: repeat(4, minmax(0, 1fr));
		background: #F5F6F8;
		border-radius: 10px;
		overflow: hidden;
	}
	.credit-term-summary-item {
		padding: 18px 20px 16px;
		text-align: center;
		position: relative;
	}
	.credit-term-summary-item:not(:last-child)::after {
		content: "";
		position: absolute;
		top: 14px;
		right: 0;
		width: 1px;
		height: calc(100% - 28px);
		background: #C9C3CE;
	}
	.credit-term-summary-label {
		margin: 0 0 10px;
		font-size: 16px;
		font-weight: 400;
		color: #696969;
	}
	.credit-term-summary-value {
		margin: 0;
		font-size: 20px;
		font-weight: 400;
		color: #3B3B3B;
		min-height: 30px;
	}
	.credit-term-summary-item.is-highlight .credit-term-summary-label {
		color: #3B3B3B;
	}
	.credit-term-summary-item.is-highlight .credit-term-summary-value {
		color: #612989;
		font-size: 24px;
	}
	.credit-term-table-panel {
		border: 1px solid #EFEBEF;
		border-radius: 10px;
		background: #FFFFFF;
		overflow: hidden;
	}
	.credit-term-table-wrap {
		overflow: auto;
		border-bottom: 1px solid #EFEBEF;
	}
	.credit-term-table {
		width: 100%;
		min-width: 920px;
		border-collapse: collapse;
		font-family: 'Prompt', sans-serif;
		color: #3B3B3B;
	}
	.credit-term-table th,
	.credit-term-table td {
		padding: 18px 14px;
		font-size: 14px;
		border-bottom: 1px solid #EFEBEF;
		vertical-align: middle;
	}
	.credit-term-table th {
		padding-top: 16px;
		padding-bottom: 16px;
		font-size: 16px;
		font-weight: 500;
		color: #612989;
		text-align: left;
		white-space: nowrap;
	}
	.credit-term-table th:first-child,
	.credit-term-table td:first-child {
		width: 42px;
		padding-left: 18px;
		padding-right: 6px;
	}
	.credit-term-table th:nth-child(2) {
		width: 15%;
	}
	.credit-term-table th:nth-child(3) {
		width: 41%;
	}
	.credit-term-table th:nth-child(4),
	.credit-term-table th:nth-child(5),
	.credit-term-table th:nth-child(6) {
		width: 14%;
		text-align: right;
	}
	.credit-term-table td:nth-child(4),
	.credit-term-table td:nth-child(5),
	.credit-term-table td:nth-child(6) {
		text-align: right;
	}
	.credit-term-empty-row td {
		padding-top: 22px;
		padding-bottom: 22px;
		color: #8E8B94;
		text-align: center !important;
	}
	.credit-term-caret {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		width: 0;
		height: 0;
		border-left: 6px solid #4A4A4A;
		border-top: 5px solid transparent;
		border-bottom: 5px solid transparent;
		opacity: 0.5;
	}
	.credit-term-skeleton-line {
		height: 18px;
		border-radius: 999px;
		background: linear-gradient(90deg, rgba(255, 255, 255, 0.2) 0%, rgba(255, 255, 255, 0.9) 50%, rgba(255, 255, 255, 0.2) 100%);
		background-size: 200% 100%;
		animation: creditTermShimmer 1.8s infinite;
	}
	.credit-term-skeleton-line + .credit-term-skeleton-line {
		margin-top: 14px;
	}
	.credit-term-skeleton-line.short {
		width: 70%;
	}
	.credit-term-skeleton-line.medium {
		width: 82%;
	}
	.credit-term-skeleton-input {
		height: 42px;
		border-radius: 10px;
		background: #F5F6F8;
		margin-top: 18px;
		position: relative;
		overflow: hidden;
	}
	.credit-term-skeleton-input::after {
		content: "";
		position: absolute;
		inset: 0;
		background: linear-gradient(90deg, rgba(255, 255, 255, 0.2) 0%, rgba(255, 255, 255, 0.9) 50%, rgba(255, 255, 255, 0.2) 100%);
		background-size: 200% 100%;
		animation: creditTermShimmer 1.8s infinite;
	}
	@keyframes creditTermShimmer {
		0% {
			background-position: 200% 0;
		}
		100% {
			background-position: -200% 0;
		}
	}

	@media (max-width: 768px) {
		.clear-loan-popup-box {
			width: 100%;
			height: auto;
			max-height: 94vh;
		}

		.clear-loan-header {
			padding: 22px 18px 0;
		}

		.clear-loan-actions {
			padding: 16px 18px;
		}

		.clear-loan-action-container {
			width: 100%;
			flex-direction: column;
		}

		.clear-loan-btn {
			width: 100%;
		}

		.credit-term-popup-content {
			padding: 18px 16px 20px;
		}
		.credit-term-summary {
			grid-template-columns: 1fr;
		}
		.credit-term-summary-item:not(:last-child)::after {
			top: auto;
			right: 16px;
			left: 16px;
			bottom: 0;
			width: auto;
			height: 1px;
		}
	}

</style>
<script>
	var HttPRequest = false;
	var clearLoanPopupTimer = null;
	var clearLoanPopupRequest = null;
	var clearLoanPopupRequestToken = 0;
	var clearLoanPopupDocuments = [];
	var clearLoanPopupType = 'reserve';
	var clearLoanPopupNextLastId = null;
	var clearLoanPopupHasMore = false;
	var clearLoanPopupLoadingMore = false;
	var clearLoanPopupSelectedKeys = {};
	var clearLoanPopupExpandedKeys = {};

	function setElementValue(id, value) {
		var element = document.getElementById(id);
		if (element) {
			var normalizedValue = value || "";
			if ('value' in element) {
				element.value = normalizedValue;
			} else {
				element.textContent = normalizedValue;
			}
			if (id === 'display_credit_thb') {
				syncCreditTermTriggerState();
			}
		}
	}

	function syncCreditTermTriggerState() {
		var trigger = document.getElementById('display_credit_thb_trigger');
		var valueElement = document.getElementById('display_credit_thb');
		if (!trigger || !valueElement) return;

		var creditTermValue = (valueElement.textContent || valueElement.value || '').trim();
		var hasCreditTerm = creditTermValue !== '';
		trigger.classList.toggle('is-empty', !hasCreditTerm);
		trigger.disabled = !hasCreditTerm;
		trigger.setAttribute('aria-disabled', hasCreditTerm ? 'false' : 'true');
	}

	function setFieldValueBySelector(selector, value) {
		var element = document.querySelector(selector);
		if (element) {
			element.value = value || "";
		}
	}

	function setSelectedShippingId(value) {
		setFieldValueBySelector('input[name="shipping_id"]', value || '');
	}

	function ensureHiddenField(name, id) {
		var form = document.forms['frmMain'];
		if (!form) return null;

		var field = form.elements[name];
		if (!field || (field.length && !field.tagName)) {
			field = document.createElement('input');
			field.type = 'hidden';
			field.name = name;
			form.appendChild(field);
		}

		if (id && !field.id) {
			field.id = id;
		}

		return field;
	}

	function setLegacyFieldValue(name, value, id) {
		var field = ensureHiddenField(name, id);
		if (field) {
			field.value = value || '';
		}
	}

	function updateDeliveryContractRequirement() {
		var haveOrderCheckbox = document.getElementById('have_order');
		var deliveryContractInput = document.getElementById('delivery_contract');
		if (!haveOrderCheckbox || !deliveryContractInput) {
			return;
		}

		var isRequired = !!haveOrderCheckbox.checked;
		deliveryContractInput.required = isRequired;
		if (!isRequired) {
			deliveryContractInput.setCustomValidity('');
		}
	}

	function validateDeliveryContractRequirement() {
		var haveOrderCheckbox = document.getElementById('have_order');
		var deliveryContractInput = document.getElementById('delivery_contract');
		if (!haveOrderCheckbox || !deliveryContractInput) {
			return true;
		}

		if (haveOrderCheckbox.checked && deliveryContractInput.value === '') {
			alert('กรุณาระบุวันที่กำหนดส่งตามสัญญา เมื่อเลือกออเดอร์ฝาก');
			deliveryContractInput.focus();
			return false;
		}

		return true;
	}

	function syncShippingFieldsToLegacy() {
		var contactName = document.querySelector('input[name="contact_name"]');
		var contactTel = document.querySelector('input[name="contact_tel"]');
		var contactProvince = document.querySelector('select[name="contact_province"]');
		var shippingAddress = document.querySelector('input[name="shipping_address"]');
		var installLocation = document.querySelector('input[name="install_location"]');

		setLegacyFieldValue('customer_name', contactName ? contactName.value : '', 'customer_name');
		setLegacyFieldValue('customer_tel', contactTel ? contactTel.value : '', 'customer_tel');
		setLegacyFieldValue('province_name', contactProvince ? contactProvince.value : '', 'province_name');
		setLegacyFieldValue('address_name', shippingAddress ? shippingAddress.value : '', 'address_name');
		setLegacyFieldValue('address_1', shippingAddress ? shippingAddress.value : '', 'address_1');
		setLegacyFieldValue('address_send', installLocation ? installLocation.value : '', 'address_send');
	}

	function getCheckedValue(name, fallback) {
		var checked = document.querySelector('input[name="' + name + '"]:checked');
		return checked ? checked.value : (fallback || '');
	}

	function joinSizeParts() {
		var parts = Array.prototype.slice.call(arguments).filter(function(value) {
			return value !== undefined && value !== null && String(value).trim() !== '';
		});
		return parts.join(' x ');
	}

	function splitSizeParts(value, expectedParts) {
		var parts = String(value || '')
			.split(/\s*x\s*/i)
			.map(function(part) {
				return String(part || '').trim();
			})
			.filter(function(part) {
				return part !== '';
			});

		while (parts.length < expectedParts) {
			parts.push('');
		}

		return parts.slice(0, expectedParts);
	}

	function syncExtraAddressFieldsToLegacy() {
		var rows = document.querySelectorAll('.extra-addr-row');
		for (var i = 1; i <= 9; i++) {
			var row = rows[i - 1];
			setLegacyFieldValue('customer_name' + i, row ? (row.querySelector('input[name^="extra_contact_name"]') || {}).value : '');
			setLegacyFieldValue('customer_tel' + i, row ? (row.querySelector('input[name^="extra_contact_tel"]') || {}).value : '');
			setLegacyFieldValue('province_name' + i, row ? (row.querySelector('select[name^="extra_contact_province"]') || {}).value : '');
			setLegacyFieldValue('address_name' + i, row ? (row.querySelector('input[name^="extra_shipping_address"]') || {}).value : '');
		}
	}

	function syncAddressDetailFieldsToLegacy() {
		var parkFront = getCheckedValue('park_front', '1');
		var entranceType = getCheckedValue('entrance_type', '1');
		var moveFurniture = getCheckedValue('move_furn', '0');

		var valueOf = function(selector) {
			var el = document.querySelector(selector);
			return el ? el.value : '';
		};

		setLegacyFieldValue('car_home', parkFront === '1' ? '1' : '0');
		setLegacyFieldValue('car_road', parkFront === '0' ? '1' : '0');
		setLegacyFieldValue('car_park', valueOf('input[name="park_location"]'));
		setLegacyFieldValue('height_ltd', document.querySelector('input[name="is_high_roof"]') && document.querySelector('input[name="is_high_roof"]').checked ? '1' : '0');
		setLegacyFieldValue('slope', entranceType === '1' ? '1' : '0');
		setLegacyFieldValue('bundai', entranceType === '2' ? '1' : '0');
		setLegacyFieldValue('unit_bundai', valueOf('input[name="stair_count"]'));
		setLegacyFieldValue('install', valueOf('input[name="install_floor"]'));
		setLegacyFieldValue('home_type', getCheckedValue('room_type', '1'));
		setLegacyFieldValue('install_room', getCheckedValue('room_type', '1'));
		setLegacyFieldValue('room_bigger', valueOf('input[name="door_width"]'));
		setLegacyFieldValue('room_longer', valueOf('input[name="door_height"]'));
		setLegacyFieldValue('bundai_big', joinSizeParts(valueOf('input[name="stair_width"]'), valueOf('input[name="stair_height"]')));
		setLegacyFieldValue('lip_big', joinSizeParts(valueOf('input[name="elev_door_width"]'), valueOf('input[name="elev_door_height"]')));
		setLegacyFieldValue('lip_long', joinSizeParts(valueOf('input[name="elev_width"]'), valueOf('input[name="elev_height"]'), valueOf('input[name="elev_depth"]')));
		setLegacyFieldValue('lip_weight', valueOf('input[name="elev_capacity"]'));
		setLegacyFieldValue('want_employee', moveFurniture === '1' ? '1' : '0');
		setLegacyFieldValue('employee_unit', valueOf('input[name="move_furn_count"]'));
		setLegacyFieldValue('ferniger_name', valueOf('input[name="move_furn_detail"]'));
		setLegacyFieldValue('description_ja', valueOf('input[name="addr_note"]'));
	}

	function syncFormCompatibilityFields() {
		ensureHiddenField('customer_typename', 'customer_typename');
		syncShippingFieldsToLegacy();
		syncExtraAddressFieldsToLegacy();
		syncAddressDetailFieldsToLegacy();
	}

	function applyShippingSelection(data) {
		if (Array.isArray(data)) {
			var selectedItems = data.filter(function(item) {
				return item && !item.is_all;
			});

			if (!selectedItems.length) {
				if (window.originalShippingData) {
					setFieldValueBySelector('input[name="contact_name"]', window.originalShippingData.shipping_name || window.originalShippingData.customer_name || '');
					setFieldValueBySelector('input[name="contact_tel"]', window.originalShippingData.shipping_tel || window.originalShippingData.customer_tel || '');
					setFieldValueBySelector('select[name="contact_province"]', window.originalShippingData.shipping_province || '');
					setFieldValueBySelector('input[name="shipping_address"]', window.originalShippingData.shipping_full_address || '');
					setFieldValueBySelector('input[name="install_location"]', window.originalShippingData.install_location || window.originalShippingData.shipping_full_address || '');
				} else {
					setFieldValueBySelector('input[name="contact_name"]', '');
					setFieldValueBySelector('input[name="contact_tel"]', '');
					setFieldValueBySelector('select[name="contact_province"]', '');
					setFieldValueBySelector('input[name="shipping_address"]', '');
					setFieldValueBySelector('input[name="install_location"]', '');
				}
				setSelectedShippingId('');
				syncShippingFieldsToLegacy();
				return;
			}

			var firstItem = selectedItems[0];
			var mergedAddresses = selectedItems.map(function(item) {
				return String(item.shipping_full_address || item.shipping_address || '').trim();
			}).filter(Boolean).join(' | ');

			var mergedInstallLocations = selectedItems.map(function(item) {
				return String(item.install_location || '').trim();
			}).filter(Boolean).join(' | ');

			setFieldValueBySelector('input[name="contact_name"]', firstItem.shipping_name || firstItem.customer_name || '');
			setFieldValueBySelector('input[name="contact_tel"]', firstItem.shipping_tel || firstItem.customer_tel || '');
			setFieldValueBySelector('select[name="contact_province"]', firstItem.shipping_province || '');
			setFieldValueBySelector('input[name="shipping_address"]', mergedAddresses);
			setFieldValueBySelector('input[name="install_location"]', mergedInstallLocations);
			setSelectedShippingId(firstItem.row_id || '');
			syncShippingFieldsToLegacy();
			return;
		}

		data = data || {};
		if (data.is_all) {
			if (window.originalShippingData) {
				setFieldValueBySelector('input[name="contact_name"]', window.originalShippingData.shipping_name || window.originalShippingData.customer_name || '');
				setFieldValueBySelector('input[name="contact_tel"]', window.originalShippingData.shipping_tel || window.originalShippingData.customer_tel || '');
				setFieldValueBySelector('select[name="contact_province"]', window.originalShippingData.shipping_province || '');
				setFieldValueBySelector('input[name="shipping_address"]', window.originalShippingData.shipping_full_address || '');
				setFieldValueBySelector('input[name="install_location"]', window.originalShippingData.install_location || window.originalShippingData.shipping_full_address || '');
			} else {
				setFieldValueBySelector('input[name="contact_name"]', '');
				setFieldValueBySelector('input[name="contact_tel"]', '');
				setFieldValueBySelector('select[name="contact_province"]', '');
				setFieldValueBySelector('input[name="shipping_address"]', '');
				setFieldValueBySelector('input[name="install_location"]', '');
			}
			setSelectedShippingId('');
			syncShippingFieldsToLegacy();
			return;
		}

		var fullAddress = String(data.shipping_full_address || '').trim();

		setFieldValueBySelector('input[name="contact_name"]', data.shipping_name || data.customer_name || '');
		setFieldValueBySelector('input[name="contact_tel"]', data.shipping_tel || data.customer_tel || '');
		setFieldValueBySelector('select[name="contact_province"]', data.shipping_province || '');
		setFieldValueBySelector('input[name="shipping_address"]', fullAddress);
		setFieldValueBySelector('input[name="install_location"]', data.install_location || '');
		setSelectedShippingId(data.row_id || '');

		syncShippingFieldsToLegacy();
	}

	function bindShippingFieldMirrors() {
		var selectors = [
			'input[name="contact_name"]',
			'input[name="contact_tel"]',
			'select[name="contact_province"]',
			'input[name="shipping_address"]',
			'input[name="install_location"]'
		];

		selectors.forEach(function(selector) {
			var element = document.querySelector(selector);
			if (!element) return;
			element.addEventListener('input', syncShippingFieldsToLegacy);
			element.addEventListener('change', syncShippingFieldsToLegacy);
		});

		syncShippingFieldsToLegacy();
	}

	function doCallAjax1(bill_id, bill_name, bill_address, bill_tel, tax_id, pre_name, mode_name, email, customer_typename, payment, credit_thb, mode, onComplete) {
		if (typeof mode === 'function') {
			onComplete = mode;
			mode = undefined;
		}

		HttPRequest = false;
		if (window.XMLHttpRequest) {
			HttPRequest = new XMLHttpRequest();
			if (HttPRequest.overrideMimeType) HttPRequest.overrideMimeType('text/html');
		} else if (window.ActiveXObject) {
			try {
				HttPRequest = new ActiveXObject("Msxml2.XMLHTTP");
			} catch (e) {
				try {
					HttPRequest = new ActiveXObject("Microsoft.XMLHTTP");
				} catch (e) {}
			}
		}
		if (!HttPRequest) {
			alert('Cannot create XMLHTTP instance');
			return false;
		}

		var url = 'data_bill_name1.php';
		var billIdVal = "";
		var billIdElem = document.getElementById(bill_id);
		if (billIdElem) {
			billIdVal = billIdElem.value;
		} else {
			billIdVal = bill_id;
		}
		var pmeters = "bill_id=" + encodeURIComponent(billIdVal);
		HttPRequest.open('POST', url, true);
		HttPRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		HttPRequest.setRequestHeader("Content-length", pmeters.length);
		HttPRequest.setRequestHeader("Connection", "close");
		HttPRequest.send(pmeters);

		HttPRequest.onreadystatechange = function() {
			if (HttPRequest.readyState === 4) {
				// 200 เท่านั้นถึงจะประมวลผล (กัน error เงียบๆ)
				if (HttPRequest.status !== 200) {
					console.error('XHR error', HttPRequest.status);
					if (typeof onComplete === 'function') {
						onComplete(false, ['โหลดข้อมูลลูกค้าไม่สำเร็จ']);
					}
					return;
				}

				var myProduct = HttPRequest.responseText || '';
				if (myProduct !== "") {
					var myArr = myProduct.split("|");
					var customerData = {
						bill_name: myArr[0] || '',
						bill_address_full: myArr[1] || '',
						bill_tel: myArr[2] || '',
						tax_id: myArr[3] || '',
						customer_no: myArr[4] || '',
						customer_tel: myArr[5] || '',
						bill_address: myArr[6] || '',
						bill_ampher: myArr[7] || '',
						bill_province: myArr[8] || '',
						bill_postcode: myArr[9] || '',
						preface_name: myArr[10] || '',
						tax_id_repeat: myArr[11] || '',
						delivery_name: myArr[12] || '',
						delivery_address: myArr[13] || '',
						delivery_ampher: myArr[14] || '',
						delivery_province: myArr[15] || '',
						delivery_postcode: myArr[16] || '',
						delivery_tel: myArr[17] || '',
						contact_name: myArr[18] || '',
						delivery_full_address: myArr[19] || '',
						mode_name: myArr[20] || '',
						email: myArr[21] || '',
						customer_type_name: myArr[22] || '',
						credit_ckk: myArr[23] || '',
						credit_thb: myArr[24] || '',
						vip_ckk: myArr[25] || ''
					};

					var isCustomerMode = (mode === 'customer' || mode === undefined);
					var isBillingMode = (mode === 'billing' || mode === undefined);

					if (isBillingMode) {
						setElementValue(bill_name, customerData.bill_name);
						setElementValue(bill_address, customerData.bill_address_full);
						setElementValue(bill_tel, customerData.bill_tel);
						setElementValue(tax_id, customerData.tax_id);

						var preNameVal = customerData.preface_name.trim();
						var preNameSelect = document.getElementById(pre_name);
						if (preNameSelect) {
							var exists = false;
							for (var i = 0; i < preNameSelect.options.length; i++) {
								if (preNameSelect.options[i].value === preNameVal) {
									exists = true;
									break;
								}
							}
							if (!exists && preNameVal !== "") {
								var opt = document.createElement('option');
								opt.value = preNameVal;
								opt.innerHTML = preNameVal;
								preNameSelect.appendChild(opt);
							}
							preNameSelect.value = preNameVal;
						}
					}

					if (isCustomerMode) {
						setElementValue('display_bill_name', customerData.bill_name);
						setElementValue('display_bill_tel', customerData.bill_tel);

						setElementValue(mode_name, customerData.mode_name);
						setElementValue('display_mode_name', customerData.mode_name);
						setElementValue(customer_typename, customerData.customer_type_name);
						setElementValue('display_customer_typename', customerData.customer_type_name);
						setElementValue('display_credit_thb', customerData.credit_thb);

						var vipCkk = customerData.vip_ckk.trim();
						var vipIcon = document.getElementById('display_vip_icon');
						if (vipIcon) {
							if (vipCkk === "1") {
								vipIcon.style.display = "";
							} else {
								vipIcon.style.display = "none";
							}
						}

						// เก็บ bill_id ที่ค้นหาได้ไว้ใน hidden
						var sourceBillIdElem = document.getElementById(bill_id);
						var billIdToSet = sourceBillIdElem ? sourceBillIdElem.value : bill_id;
						var hBillIdElem = document.getElementById('h_bill_id');
						if (hBillIdElem) hBillIdElem.value = billIdToSet;
						var displayBillId = document.getElementById('display_bill_id');
						if (displayBillId) displayBillId.textContent = billIdToSet;
					}

					if (isCustomerMode) {
						setElementValue(payment, customerData.credit_ckk);
						setElementValue(credit_thb, customerData.credit_thb);
						var defaultShipping = {
							customer_name: customerData.bill_name,
							customer_tel: customerData.delivery_tel || customerData.customer_tel,
							shipping_name: customerData.contact_name || customerData.delivery_name || customerData.bill_name,
							shipping_province: customerData.delivery_province,
							shipping_full_address: customerData.delivery_full_address || customerData.delivery_address || ''
						};
						window.originalShippingData = defaultShipping;
						if (window.isInitialDraftLoad) {
							window.isInitialDraftLoad = false;
						} else {
							applyShippingSelection(defaultShipping);
						}

						// เก็บ bank id ของลูกค้าไว้ใน hidden เพื่อ restore dropdown ภายหลัง
						var cusCkk = customerData.credit_ckk.trim();
						var hCreditCkk = document.getElementById('h_credit_ckk_value');
						if (hCreditCkk) hCreditCkk.value = cusCkk;

						resolveBankPaymentMode(cusCkk, function(resolvedMode) {
							var customerPaymentModeInput = document.getElementById('h_customer_payment_mode');
							if (customerPaymentModeInput) {
								customerPaymentModeInput.value = resolvedMode;
							}
							switchPaymentMode(resolvedMode);
							evaluateDebtPanel();
						});
					}

					if (typeof onComplete === 'function') {
						onComplete(true, []);
					}
				} else if (typeof onComplete === 'function') {
					onComplete(false, ['ไม่พบข้อมูลลูกค้า']);
				}
			}
		};
	}

	// ----- เงื่อนไขการแสดงตารางหนี้: payment != '0' และมีวงเงิน > 0 -----
	function shouldShowDebtPanel() {
		var payVal = (document.getElementById('payment').value || '').trim();
		var creditRaw = (document.getElementById('credit_thb').value || '0').replace(/,/g, '');
		var creditNum = parseFloat(creditRaw) || 0;
		return (payVal !== '0' && creditNum > 0);
	}

	function evaluateDebtPanel() {
		if (shouldShowDebtPanel()) {
			var cusId = (document.getElementById('h_bill_id').value || '').trim();
			if (cusId) {
				showDebts(cusId);
			} else {
				// ไม่มีลูกค้า -> ซ่อน
				hideDebts();
			}
		} else {
			hideDebts();
		}
	}

	function hasSelectedCustomerForPaymentMode() {
		var hBillId = document.getElementById('h_bill_id');
		return !!(hBillId && String(hBillId.value || '').trim() !== '');
	}

	function getResolvedCustomerPaymentMode() {
		var modeInput = document.getElementById('h_customer_payment_mode');
		return modeInput ? String(modeInput.value || '').trim() : '';
	}

	function resolveBankPaymentMode(bankId, onComplete) {
		var normalizedBankId = String(bankId === undefined || bankId === null ? '' : bankId).trim();
		if (normalizedBankId === '') {
			if (typeof onComplete === 'function') {
				onComplete('cash', '');
			}
			return;
		}

		var xhr = new XMLHttpRequest();
		xhr.open('GET', 'get_bank_credit_flag.php?id=' + encodeURIComponent(normalizedBankId), true);
		xhr.onreadystatechange = function() {
			if (xhr.readyState !== 4) {
				return;
			}

			var resolvedMode = 'cash';
			var resolvedFlag = '';
			if (xhr.status === 200) {
				try {
					var response = JSON.parse(xhr.responseText || '{}');
					resolvedFlag = String(response.credit_ckk || '').trim();
					if (response.success && resolvedFlag === '1') {
						resolvedMode = 'credit';
					}
				} catch (error) {
					console.error('resolveBankPaymentMode parse error', error);
				}
			}

			if (typeof onComplete === 'function') {
				onComplete(resolvedMode, resolvedFlag);
			}
		};
		xhr.send();
	}

	function loadTypeBankOptions(callback) {
		var xhr = new XMLHttpRequest();
		xhr.open('GET', 'typebank_options.php', true);
		xhr.onreadystatechange = function() {
			if (xhr.readyState !== 4) {
				return;
			}

			var paymentMethodSelect = document.getElementById('payment_method');
			if (!paymentMethodSelect) {
				if (typeof callback === 'function') {
					callback();
				}
				return;
			}

			if (xhr.status === 200) {
				paymentMethodSelect.innerHTML = '<option value="0">เลือกวิธีชำระเงิน</option>' + (xhr.responseText || '');
				var savedValue = paymentMethodSelect.getAttribute('data-saved-value') || paymentMethodSelect.value || '0';
				if (savedValue && Array.prototype.some.call(paymentMethodSelect.options, function(option) {
						return option.value === savedValue;
					})) {
					paymentMethodSelect.value = savedValue;
				}
			} else {
				console.error('โหลดรายการวิธีชำระเงินไม่สำเร็จ');
				paymentMethodSelect.innerHTML = '<option value="0">เลือกวิธีชำระเงิน</option>';
			}

			if (typeof callback === 'function') {
				callback();
			}
		};
		xhr.send();
	}

	// โหลด options ช่องทางชำระเงิน
	function loadBankOptions(creditOnly, callback) {
		var xhr = new XMLHttpRequest();
		xhr.open('GET', 'bank_options_awl.php?credit_only=' + (creditOnly ? '1' : '0'), true);
		xhr.onreadystatechange = function() {
			if (xhr.readyState === 4) {
				if (xhr.status === 200) {
					var sel = document.getElementById('payment');
					var prev = sel.value; // เก็บค่าเดิมไว้ (กันเด้ง reset กรณีโหลดใหม่)
					sel.innerHTML = '<option value="">เลือกวิธีชำระเงิน</option>' + xhr.responseText;
					// พยายาม restore ค่าเดิม ถ้ายังอยู่ใน options ใหม่
					if ([...sel.options].some(o => o.value === prev)) sel.value = prev;

					// ซิงค์ค่าไปยัง dropdown ฝั่ง cash
					var cashSel = document.getElementById('payment_cash_select');
					if (cashSel) {
						cashSel.innerHTML = sel.innerHTML;
						cashSel.value = sel.value;
					}

					if (typeof callback === 'function') {
						callback();
					}
				} else {
					console.error('โหลดช่องทางชำระเงินไม่สำเร็จ');
				}
			}
		};
		xhr.send();
	}

	var lastDebtPanelWarningKey = '';

	// แสดงตารางหนี้คงค้าง
	function showDebts(cusId) {
		var xhr = new XMLHttpRequest();
		xhr.open('GET', 'get_debts.php?cus_id=' + encodeURIComponent(cusId), true);
		xhr.onreadystatechange = function() {
			if (xhr.readyState === 4) {
				if (xhr.status === 200) {
					try {
						var res = JSON.parse(xhr.responseText || '{}');

						// ดึงวงเงิน
						var creditInput = document.getElementById('credit_thb').value || '0';
						var credit = parseFloat(String(creditInput).replace(/,/g, '').trim()) || 0;

						// ยอดหนี้
						var rawOutstanding = res.total_outstanding || 0;
						var outstanding = parseFloat(String(rawOutstanding).replace(/,/g, '').trim()) || 0;

						// วงเงินคงเหลือ
						var remain = credit - outstanding;
						document.getElementById('sum_ca').value = remain;

						var billName = document.getElementById('bill_name').value || '-';
						var creditSummaryEl = document.getElementById('credit_summary');
						var warningKey = [cusId, credit, outstanding].join('|');

						// Summary
						var summaryHtml = `
            <div style="margin-bottom:16px; font-weight:bold;">
              วงเงิน: ${numberFormat(credit)} |
              ยอดวงเงินคงเหลือ:
              <span style="color:${remain < 0 ? 'red' : 'green'};">
                ${numberFormat(remain)}
              </span>
            </div>
          `;

						// แสดงผล
						document.getElementById('debt_table_wrap').innerHTML =
							summaryHtml + (res.html || '');
						document.getElementById('debt_panel').style.display = 'block';


						if (remain < 0) {
							if (creditSummaryEl) {
								creditSummaryEl.innerHTML =
									"<span style='color:#c62828;'>ยอดหนี้คงค้างเกินวงเงิน กรุณาติดต่อบัญชีเพื่อขอเพิ่มวงเงินก่อนทำรายการต่อ</span>";
							}

							if (lastDebtPanelWarningKey !== warningKey) {
								lastDebtPanelWarningKey = warningKey;
								Swal.fire({
									title: "กรุณาติดต่อบัญชี",
									html: "<div style='font-size:16px; text-align:left;'>" +
										"<p>เพื่อขอเพิ่มวงเงินของคุณ เนื่องจากวงเงินของคุณไม่เพียงพอ</p>" +
										"<hr>" +
										"<p><b> " + billName + "</b></p>" +
										"<p><b>วงเงิน: " + numberFormat(credit) + " บาท</b></p>" +
										"<p><b>ยอดวงเงินคงเหลือ:</b> " +
										"<span style='color:red; font-weight:bold;'>" +
										numberFormat(remain) + " บาท" +
										"</span>" +
										"</p>" +
										"</div>",
									icon: "warning",
									confirmButtonText: "รับทราบ"
								});
							}
						} else {
							lastDebtPanelWarningKey = '';
							if (creditSummaryEl) {
								creditSummaryEl.innerHTML = '';
							}
						}
					} catch (e) {
						console.error('Parse JSON error', e);
						hideDebts();
					}
				} else {
					console.error('โหลดยอดหนี้คงค้างไม่สำเร็จ');
					hideDebts();
				}
			}
		};
		xhr.send();
	}


	function hideDebts() {
		lastDebtPanelWarningKey = '';
		document.getElementById('debt_panel').style.display = 'none';
		document.getElementById('debt_table_wrap').innerHTML = '';
		document.getElementById('credit_summary').innerHTML = '';
	}

	// utility แปลงตัวเลขให้อ่านง่าย
	function numberFormat(n) {
		return (Number(n) || 0).toLocaleString('en-US', {
			minimumFractionDigits: 2,
			maximumFractionDigits: 2
		});
	}

	// กรณีผู้ใช้แก้ไขค่า payment เองภายหลัง
	document.addEventListener('DOMContentLoaded', function() {
		// เริ่มต้นโหลดในโหมดเงินสด/เครดิตตามค่าเริ่มต้น
		loadTypeBankOptions();
		switchPaymentMode('credit');

		// ผู้ใช้แก้ไขวงเงิน -> ประเมินใหม่ (ถ้าวงเงินเป็น 0 จะซ่อน)
		document.getElementById('credit_thb').addEventListener('input', function() {
			evaluateDebtPanel();
			updateCreditDisplay();
		});
	});

	// สลับโหมดการชำระเงิน (เครดิต / เงินสด)
	function switchPaymentMode(mode) {
		var isCredit = (mode === 'credit');

		var radCredit = document.getElementById('pay_mode_credit');
		var radCash = document.getElementById('pay_mode_cash');
		var creditLabel = document.getElementById('lbl-pay_mode_credit');
		var creditDaysInput = document.getElementById('display_credit_days');

		if (isCredit) {
			if (radCredit) radCredit.disabled = false;
			if (creditDaysInput) creditDaysInput.disabled = false;
			if (creditLabel) creditLabel.classList.remove('is-disabled');
			if (radCredit) radCredit.checked = true;
			document.getElementById('lbl-pay_mode_credit')?.classList.add('active');
			document.getElementById('lbl-pay_mode_cash')?.classList.remove('active');

			document.getElementById('row-credit-fields').style.display = 'grid';
			document.getElementById('row-cash-fields').style.display = 'none';

			loadBankOptions(false, function() {
				var savedCusCkk = document.getElementById('h_credit_ckk_value').value || '';
				var sel = document.getElementById('payment');
				if (savedCusCkk && savedCusCkk !== '0') {
					sel.value = savedCusCkk;
				} else {
					sel.value = '';
				}
				var cashSel = document.getElementById('payment_cash_select');
				if (cashSel) cashSel.value = sel.value;
				updateCreditDisplay();
				evaluateDebtPanel();
			});
		} else {
			var shouldDisableCredit = hasSelectedCustomerForPaymentMode() && getResolvedCustomerPaymentMode() === 'cash';
			if (radCredit) radCredit.disabled = shouldDisableCredit;
			if (creditDaysInput) creditDaysInput.disabled = true;
			if (creditLabel) creditLabel.classList.toggle('is-disabled', shouldDisableCredit);
			if (radCash) radCash.checked = true;
			document.getElementById('lbl-pay_mode_cash')?.classList.add('active');
			document.getElementById('lbl-pay_mode_credit')?.classList.remove('active');

			document.getElementById('row-cash-fields').style.display = 'grid';
			document.getElementById('row-credit-fields').style.display = 'none';

			loadBankOptions(true, function() {
				var sel = document.getElementById('payment');
				var savedCusCkk = document.getElementById('h_credit_ckk_value').value || '';
				if (savedCusCkk && [...sel.options].some(function(option) {
						return option.value === savedCusCkk;
					})) {
					sel.value = savedCusCkk;
				} else if (savedCusCkk === '0' || !savedCusCkk) {
					sel.value = '';
				} else {
					sel.value = '';
				}
				var cashSel = document.getElementById('payment_cash_select');
				if (cashSel) cashSel.value = sel.value;
				evaluateDebtPanel();
			});
		}
	}

	// อัปเดตข้อมูลการแสดงผลเครดิต
	function updateCreditDisplay() {
		var sel = document.getElementById('payment');
		var selectedText = sel.options[sel.selectedIndex]?.text || '';
		var creditDays = selectedText.match(/\d+/) ? selectedText.match(/\d+/)[0] : '';

		var displayDays = document.getElementById('display_credit_days');
		if (displayDays) displayDays.value = creditDays || '30';

		var creditLimit = document.getElementById('credit_thb').value || '0';
		var formattedLimit = parseFloat(creditLimit.replace(/,/g, '')) || 0;
		var displayLimit = document.getElementById('display_credit_limit');
		if (displayLimit) displayLimit.value = formattedLimit.toLocaleString('en-US');
	}
</script>

<script>
	const lastOkValues = {};

	function num(v) {
		return parseFloat(String(v || '').replace(/,/g, '')) || 0;
	}

	function calcTotal() {
		let total = 0;
		for (let i = 1; i <= 20; i++) {
			const el = document.getElementById('sum_amount' + i);
			if (el) total += num(el.value);
		}
		const totalInput = document.getElementById('sum_amount_total');
		if (totalInput) totalInput.value = total.toFixed(2);
		return total;
	}

	function checkOverLimit(changedId) {
		setTimeout(function() {
			const total = calcTotal();
			const sumCaEl = document.getElementById('sum_ca');
			const limit = sumCaEl ? num(sumCaEl.value) : 0;

			if (limit > 0 && total > limit) {
				showOverLimitPopup(total, limit);

				const el = document.getElementById(changedId);
				if (el && lastOkValues[changedId] !== undefined) {
					el.value = lastOkValues[changedId];
				}
				calcTotal();
				if (el) {
					el.focus();
					if (typeof el.select === 'function') el.select();
				}
			} else {
				const el = document.getElementById(changedId);
				if (el) lastOkValues[changedId] = el.value;
			}
		}, 30);
	}

	function bindRow(i) {
		['sale_count', 'product_price', 'discount_unit'].forEach(function(prefix) {
			const id = prefix + i;
			const el = document.getElementById(id);
			if (!el) return;

			lastOkValues[id] = el.value;
			el.addEventListener('focus', function() {
				lastOkValues[id] = el.value;
			});
			el.addEventListener('input', function() {
				checkOverLimit(id);
			});
			el.addEventListener('change', function() {
				checkOverLimit(id);
			});
		});
	}

	document.addEventListener('DOMContentLoaded', function() {
		for (let i = 1; i <= 20; i++) bindRow(i);
		calcTotal();
	});
</script>

<script>
	function object() {
		if (document.getElementById('object1').checked) {
			document.getElementById('dt1').style.display = 'block';
			document.getElementById('dt2').style.display = 'none';
			document.getElementById('dt3').style.display = 'none';
			document.getElementById('dt4').style.display = 'none';
		} else if (document.getElementById('object2').checked) {
			document.getElementById('dt1').style.display = 'none';
			document.getElementById('dt2').style.display = 'block';
			document.getElementById('dt3').style.display = 'none';
			document.getElementById('dt4').style.display = 'none';
		} else if (document.getElementById('object3').checked) {
			document.getElementById('dt1').style.display = 'none';
			document.getElementById('dt2').style.display = 'none';
			document.getElementById('dt3').style.display = 'block';
			document.getElementById('dt4').style.display = 'none';
		} else if (document.getElementById('object4').checked) {
			document.getElementById('dt1').style.display = 'none';
			document.getElementById('dt2').style.display = 'none';
			document.getElementById('dt3').style.display = 'none';
			document.getElementById('dt4').style.display = 'block';
		}

	}


	function ckk_1() {
		if (document.getElementById('object5').checked) {
			document.getElementById('dt5').style.display = 'block';
		} else if (document.getElementById('object6').checked) {
			document.getElementById('dt5').style.display = 'none';
		} else if (document.getElementById('object7').checked) {
			document.getElementById('dt5').style.display = 'none';
		}
	}
</script>

<style type="text/css">
	.button {
		background-color: #339900;
		border: none;
		color: white;
		padding: 8px 10px;
		text-align: center;
		text-decoration: none;
		display: inline-block;
		font-size: 16px;
		margin: 4px 2px;
		cursor: pointer;
	}

	.button1 {
		border-radius: 2px;
	}

	.button2 {
		border-radius: 4px;
	}

	.button3 {
		border-radius: 8px;
	}

	.button4 {
		border-radius: 12px;
	}

	.button5 {
		border-radius: 50%;
	}

	.style15 {
		font-size: 18px;
		color: #000000;
	}

	.style30 {
		font-size: 12px;
	}

	.style32 {
		font-size: 11px;
	}

	.style33 {
		font-size: 12px;
	}

	.style34 {
		color: #FF0000;
	}

	.style35 {
		font-size: 12px;
		color: #f2f2f2;
	}

	.style37 {
		color: #FF0000;
		font-size: 14px;
	}

	.style38 {
		color: #f2f2f2;
	}

	.style39 {
		font-size: 14px;
	}

	.style40 {
		font-size: 16px;
		color: #FF0000;
	}

	/* ================= MODERN PREMIUM THEME ================= */
	@import url('https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap');

	body {
		background-color: #F4EFF8 !important;
		background-image: none !important;
		font-family: 'Prompt', sans-serif !important;
		color: #4A4A4A !important;
	}

	/* Modern Header Layout */
	.so-header-container {
		display: flex;
		justify-content: space-between;
		align-items: center;
		margin: 0 auto;
		padding: 16px 0;
		width: 100%;
		max-width: 1096px;
		box-sizing: border-box;
	}

	.so-header-left {
		display: flex;
		flex-direction: column;
	}

	.so-title {
		font-size: 28px;
		font-weight: 600;
		color: #612989;
		margin: 0 0 8px 0;
	}

	.so-ref-info {
		display: flex;
		align-items: center;
		gap: 8px;
		font-size: 14px;
	}

	.so-ref-label {
		color: #8E8B94;
	}

	.so-ref-value {
		color: #612989;
		font-weight: 700;
	}

	.so-header-right {
		display: flex;
		gap: 12px;
	}

	/* Buttons */
	.btn-clear-loan-reserve {
		background-color: #F1E1FF;
		color: #612989;
		border: none;
		border-radius: 20px;
		padding: 10px 24px;
		font-size: 14px;
		font-weight: 600;
		cursor: pointer;
		transition: all 0.2s ease;
		font-family: 'Prompt', sans-serif;
	}

	.btn-clear-loan-reserve:hover {
		background-color: #DCD6FA;
	}

	.btn-preview-so {
		background-color: #FFFFFF;
		color: #612989;
		border: 1px solid transparent;
		border-radius: 20px;
		padding: 10px 24px;
		font-size: 14px;
		font-weight: 600;
		cursor: pointer;
		transition: all 0.2s ease;
		display: inline-flex;
		align-items: center;
		gap: 8px;
		font-family: 'Prompt', sans-serif;
		box-shadow: 0px 0px 4px 0px rgba(0, 0, 0, 0.25);
	}

	.btn-preview-so:hover {
		background-color: #FAF9FC;
		opacity: 0.9;
	}

	/* Tabs */
	.so-tabs-container {
		display: flex;
		background-color: transparent;
		margin-bottom: -1px;
		padding-left: 50px;
		position: relative;
	}

	.so-tab-btn {
		background: #FFFFFF;
		border: 1px solid #FFFFFF;
		border-bottom: none;
		outline: none;
		padding: 12px 28px;
		font-size: 14px;
		font-weight: 500;
		color: #3B3B3B;
		cursor: pointer;
		transition: all 0.2s ease;
		position: relative;
		/* margin-right: 6px; */
		font-family: 'Prompt', sans-serif;
	}

	.so-tab-btn:first-child {
		border-radius: 12px 0 0 0;
	}

	.so-tab-btn:last-child {
		border-radius: 0 12px 0 0;
	}

	.so-tab-btn:hover {
		color: #612989;
		background: #EFEBFF;
	}

	.so-tab-btn.active {
		color: #612989;
		font-weight: 500;
		font-size: 14px;
		background: #FFFFFF;
		padding-bottom: 11px;
	}

	.so-tab-btn.active::after {
		content: "";
		position: absolute;
		bottom: 0;
		left: 0;
		right: 0;
		height: 4px;
		background-color: #612989;
		border-radius: 25px;
	}

	/* Card Container */
	.so-card {
		background-color: #FFFFFF;
		border-radius: 10px;
		box-shadow: 0 4px 20px rgba(97, 41, 137, 0.04);
		padding: 32px;
		margin-bottom: 30px;
		border: 1px solid #EFEBEF;
		position: relative;
		width: 100%;
		max-width: 1096px;
		margin-left: auto;
		margin-right: auto;
		box-sizing: border-box;
	}

	/* Tab content */
	.so-tab-content {
		display: none;
	}

	.so-tab-content.active {
		display: block;
		background-color: transparent;
	}

	/* Grid Layouts */
	.so-grid-3 {
		display: grid;
		grid-template-columns: repeat(3, 1fr);
		gap: 24px;
		margin-bottom: 24px;
	}

	.so-grid-2 {
		display: grid;
		grid-template-columns: repeat(2, 1fr);
		gap: 24px;
		margin-bottom: 24px;
	}

	.so-grid-3-2-1 {
		display: grid;
		grid-template-columns: 2fr 1fr;
		gap: 24px;
		margin-bottom: 24px;
	}

	@media (max-width: 992px) {

		.so-grid-3,
		.so-grid-3-2-1 {
			grid-template-columns: repeat(2, 1fr);
		}
	}

	@media (max-width: 768px) {

		.so-grid-3,
		.so-grid-2,
		.so-grid-3-2-1 {
			grid-template-columns: 1fr;
			gap: 16px;
		}
	}

	/* Field styling */
	.so-field-group {
		display: flex;
		flex-direction: column;
		gap: 8px;
	}

	.so-label {
		font-size: 13px;
		font-weight: 500;
		color: #612989;
	}

	.so-label .required {
		color: #DC3545;
		margin-left: 2px;
	}

	.so-input {
		background-color: #F5F6F8;
		border: 1px solid transparent;
		border-radius: 10px;
		padding: 0 16px;
		font-size: 14px;
		color: #333333;
		font-family: 'Prompt', sans-serif;
		outline: none;
		transition: all 0.2s ease;
		height: 42px;
		line-height: 40px;
		box-sizing: border-box;
	}

	.so-input:focus {
		background-color: #FFFFFF;
		border-color: #612989;
		box-shadow: 0 0 0 3px rgba(97, 41, 137, 0.1);
	}

	.so-textarea {
		background-color: #F5F6F8;
		border: 1px solid transparent;
		border-radius: 12px;
		padding: 12px 16px;
		font-size: 14px;
		color: #333333;
		font-family: 'Prompt', sans-serif;
		outline: none;
		transition: all 0.2s ease;
		resize: vertical;
		box-sizing: border-box;
		width: 100%;
	}

	.so-textarea:focus {
		background-color: #FFFFFF;
		border-color: #612989;
		box-shadow: 0 0 0 3px rgba(97, 41, 137, 0.1);
	}

	/* Input Clear Wrapper */
	.so-input-wrapper {
		position: relative;
		display: flex;
	}

	.so-input-wrapper .so-input {
		width: 328px;
		padding-right: 40px;
	}

	/* fa-times clear icon inside wrappers */
	.so-input-wrapper>i.fas.fa-times {
		position: absolute;
		right: 12px;
		top: 50%;
		transform: translateY(-50%);
		cursor: pointer;
		color: #8E8B94;
		font-size: 14px;
		z-index: 1;
	}

	.so-input-clear {
		position: absolute;
		right: 12px;
		top: 50%;
		transform: translateY(-50%);
		background: transparent;
		border: none;
		color: #8E8B94;
		font-size: 20px;
		cursor: pointer;
		display: flex;
		align-items: center;
		justify-content: center;
		width: 24px;
		height: 24px;
		border-radius: 50%;
	}

	.so-input-clear:hover {
		color: #333333;
		background-color: rgba(0, 0, 0, 0.05);
	}

	/* Select wrapper and select styling */
	.so-select-wrapper {
		position: relative;
		display: flex;
		width: 328px;
	}

	.so-select {
		width: 100%;
		background-color: #F5F6F8;
		border: 1px solid transparent;
		border-radius: 10px;
		padding: 0 32px 0 16px;
		font-size: 14px;
		color: #333333;
		font-family: 'Prompt', sans-serif;
		outline: none;
		transition: all 0.2s ease;
		height: 42px;
		line-height: 40px;
		appearance: none;
		-webkit-appearance: none;
		-moz-appearance: none;
		cursor: pointer;
		box-sizing: border-box;
	}

	.so-select:focus {
		background-color: #FFFFFF;
		border-color: #612989;
		box-shadow: 0 0 0 3px rgba(97, 41, 137, 0.1);
	}

	.so-select-wrapper::after {
		content: '\f078';
		font-family: 'Font Awesome 5 Free';
		font-weight: 900;
		position: absolute;
		right: 16px;
		top: 50%;
		transform: translateY(-50%);
		color: #8E8B94;
		pointer-events: none;
		font-size: 12px;
	}

	.so-select:disabled {
		opacity: 0.8;
		cursor: not-allowed;
	}

	/* Section Title */
	.so-section-title-container {
		margin: 32px 0 24px 0;
		border-bottom: 1px solid #EFEBEF;
		padding-bottom: 12px;
	}

	.so-section-title {
		font-size: 20px;
		font-weight: 500;
		color: #3B3B3B;
		margin: 0;
	}

	.so-divider {
		border: 2px solid #EDE9F0;
	}

	/* Custom Grid for Date & Toggles */
	.so-grid-3-custom {
		display: grid;
		grid-template-columns: 1fr 2fr;
		gap: 24px;
		margin-bottom: 24px;
	}

	@media (max-width: 768px) {
		.so-grid-3-custom {
			grid-template-columns: 1fr;
			gap: 16px;
		}
	}

	.so-toggle-group {
		display: flex;
		align-items: flex-end;
		gap: 12px;
		height: 48px;
		/* Align with input height */
	}

	@media (max-width: 768px) {
		.so-toggle-group {
			height: auto;
			flex-wrap: wrap;
		}
	}

	/* Date picker calendar icon placement */
	.calendar-wrapper {
		position: relative;
	}

	.calendar-wrapper::after {
		content: '';
		background-image: url('img/icons/calendar.png');
		background-size: contain;
		background-repeat: no-repeat;
		background-position: center;
		position: absolute;
		right: 16px;
		top: 50%;
		transform: translateY(-50%);
		pointer-events: none;
		width: 18px;
		height: 18px;
	}

	.calendar-wrapper input[type="date"]::-webkit-calendar-picker-indicator {
		position: absolute;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		width: auto;
		height: auto;
		color: transparent;
		background: transparent;
		cursor: pointer;
	}

	/* Time picker clock icon placement */
	.time-wrapper {
		position: relative;
		display: flex;
		align-items: center;
		width: 100%;
	}

	.time-wrapper::after {
		content: '';
		background-image: url('img/icons/clock.png');
		background-size: contain;
		background-repeat: no-repeat;
		background-position: center;
		position: absolute;
		right: 16px;
		top: 50%;
		transform: translateY(-50%);
		pointer-events: none;
		width: 18px;
		height: 18px;
	}

	.time-wrapper input[type="time"]::-webkit-calendar-picker-indicator {
		position: absolute;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		width: auto;
		height: auto;
		color: transparent;
		background: transparent;
		cursor: pointer;
	}

	/* Checklist layout for document attachments */
	.so-checkbox-grid {
		display: grid;
		grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
		gap: 12px;
		margin-bottom: 24px;
	}

	.so-checkbox-pill {
		display: inline-flex;
		align-items: center;
		gap: 10px;
		padding: 12px 16px;
		background-color: #F8F7FC;
		border-radius: 10px;
		font-size: 14px;
		font-weight: 500;
		color: #4A4A4A;
		cursor: pointer;
		transition: all 0.2s ease;
		border: 1px solid #EFEBEF;
	}

	.so-checkbox-pill:hover {
		background-color: #F1EDFA;
		border-color: #D3C9FC;
	}

	.so-checkbox-pill input[type="checkbox"] {
		width: 18px;
		height: 18px;
		accent-color: #612989;
		cursor: pointer;
		margin: 0;
	}

	/* Pills styling for extra documents tab */
	.so-doc-pill {
		display: flex;
		align-items: center;
		justify-content: center;
		background-color: #F4F3F7;
		color: #5f5f5f;
		border-radius: 8px;
		padding: 10px 16px;
		font-size: 14px;
		font-weight: 400;
		cursor: pointer;
		transition: all 0.2s ease;
		text-align: center;
		user-select: none;
		height: 42px;
		box-sizing: border-box;
	}

	.so-doc-pill:hover {
		background-color: #EFEBFF;
		color: #612989;
	}

	.so-doc-pill input[type="checkbox"] {
		display: none;
	}

	.so-doc-pill:has(input:checked) {
		background-color: #612989;
		color: #FFFFFF;
	}

	.so-doc-pill:has(input:checked):hover {
		background-color: #502073;
		color: #FFFFFF;
	}

	.so-doc-grid {
		display: grid;
		grid-template-columns: repeat(6, 1fr);
		gap: 16px;
		margin-bottom: 24px;
		align-items: end;
	}

	@media (max-width: 992px) {
		.so-doc-grid {
			grid-template-columns: repeat(3, 1fr);
		}

		.so-doc-grid>.so-doc-pill {
			grid-column: span 1 !important;
		}

		.so-doc-grid>.so-doc-other-wrapper {
			grid-column: span 3 !important;
		}
	}

	@media (max-width: 576px) {
		.so-doc-grid {
			grid-template-columns: 1fr;
		}

		.so-doc-grid>.so-doc-pill {
			grid-column: span 1 !important;
		}

		.so-doc-grid>.so-doc-other-wrapper {
			grid-column: span 1 !important;
		}
	}

	.so-checkbox-pill-other {
		display: flex;
		align-items: center;
		gap: 10px;
		grid-column: span 2;
	}

	@media (max-width: 768px) {
		.so-checkbox-pill-other {
			grid-column: span 1;
			flex-direction: column;
			align-items: stretch;
		}
	}

	/* Radio Group */
	.so-radio-group-vertical {
		display: flex;
		flex-direction: column;
		gap: 10px;
	}

	.so-radio-label {
		display: inline-flex;
		align-items: center;
		gap: 10px;
		font-size: 14px;
		color: #4A4A4A;
		cursor: pointer;
	}

	.so-radio-label input[type="radio"] {
		width: 18px;
		height: 18px;
		accent-color: #612989;
		cursor: pointer;
		margin: 0;
	}

	/* File Upload input */
	.so-file-uploads {
		display: flex;
		flex-direction: column;
		gap: 8px;
	}

	.so-file-input-wrapper {
		background-color: #F8F7FC;
		border: 1px dashed #D3C9FC;
		border-radius: 10px;
		padding: 8px 12px;
		font-size: 13px;
		transition: all 0.2s ease;
	}

	.so-file-input-wrapper:hover {
		background-color: #F1EDFA;
	}

	.so-file-input {
		font-family: 'Prompt', sans-serif;
		cursor: pointer;
	}

	/* Fieldset and legend */
	.so-fieldset {
		border: 1px solid #EFEBEF;
		border-radius: 12px;
		padding: 24px;
		margin-bottom: 24px;
	}

	.so-legend {
		font-size: 15px;
		font-weight: 600;
		color: #612989;
		padding: 0 10px;
	}

	/* Buttons footer */
	.so-footer-buttons {
		display: flex;
		justify-content: center;
		margin-top: 30px;
	}

	.btn-submit-so {
		background-color: #612989;
		color: #FFFFFF;
		border: none;
		border-radius: 24px;
		padding: 12px 48px;
		font-size: 16px;
		font-weight: 600;
		cursor: pointer;
		transition: all 0.2s ease;
		box-shadow: 0 4px 12px rgba(97, 41, 137, 0.2);
		font-family: 'Prompt', sans-serif;
	}

	.btn-submit-so:hover {
		background-color: #502173;
		box-shadow: 0 6px 16px rgba(97, 41, 137, 0.3);
	}

	/* Collapsible Section styles */
	.collapsible-clear-section {
		max-height: 0;
		overflow: hidden;
		transition: max-height 0.3s ease-out;
		margin-bottom: 0;
	}

	.collapsible-clear-section.show {
		max-height: 500px;
		margin-bottom: 24px;
	}

	/* Bottom tabs */
	.bottom-tabs-container {
		display: flex;
		border-bottom: 2px solid #EFEBEF;
		margin-bottom: 24px;
		gap: 8px;
	}

	.bottom-tab-btn {
		background: transparent;
		border: none;
		outline: none;
		padding: 10px 20px;
		font-size: 15px;
		font-weight: 500;
		color: #8E8B94;
		cursor: pointer;
		text-decoration: none !important;
		border-bottom: 3px solid transparent;
		transition: all 0.2s ease;
		font-family: 'Prompt', sans-serif;
	}

	.bottom-tab-btn:hover {
		color: #612989;
	}

	.bottom-tab-btn.active {
		color: #612989;
		font-weight: 600;
		border-bottom: 3px solid #612989;
	}

	/* Checkbox/Toggle styling for modern pills */
	.so-toggle-pill {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		background-color: #F1F0F5;
		color: #495057;
		padding: 10px 24px;
		border-radius: 10px;
		font-size: 14px;
		font-weight: 500;
		cursor: pointer;
		transition: all 0.2s ease;
		user-select: none;
		border: 1px solid transparent;
		min-width: 120px;
		text-align: center;
		font-family: 'Prompt', sans-serif;
		box-sizing: border-box;
		height: 42px;
	}

	.so-toggle-pill input[type="checkbox"] {
		display: none;
	}

	.so-toggle-pill.active,
	.so-toggle-pill:has(input[type="checkbox"]:checked) {
		background-color: #612989;
		color: #FFFFFF;
		border-color: #612989;
		font-weight: 500;
	}

	.so-toggle-pill-outline {
		background-color: #FFFFFF;
		color: #612989;
		border: 1px solid #EFEBEF;
		border-radius: 24px;
	}

	.so-toggle-pill-outline.active,
	.so-toggle-pill-outline:has(input[type="checkbox"]:checked) {
		background-color: #EFEBFF;
		color: #612989;
		border-color: #612989;
	}

	/* Autocomplete style tweaks for integration */
	.autocomplete {
		z-index: 9999 !important;
	}

	.so-input-with-checkbox {
		display: flex;
		align-items: center;
		gap: 12px;
		width: 100%;
	}

	.so-checkbox-label {
		display: inline-flex;
		align-items: center;
		gap: 6px;
		font-size: 14px;
		font-weight: 500;
		color: #4A4A4A;
		cursor: pointer;
		white-space: nowrap;
	}

	.so-checkbox-label input[type="checkbox"] {
		width: 18px;
		height: 18px;
		accent-color: #612989;
		cursor: pointer;
		margin: 0;
	}

	/* Radio Button Styling */
	.so-payment-modes {
		display: flex;
		gap: 32px;
		margin-bottom: 24px;
	}

	.so-payment-radio-label {
		display: inline-flex;
		align-items: center;
		gap: 12px;
		font-size: 15px;
		font-weight: 500;
		color: #4A4A4A;
		cursor: pointer;
		user-select: none;
	}

	.so-payment-radio-label input[type="radio"] {
		appearance: none;
		-webkit-appearance: none;
		width: 22px;
		height: 22px;
		border: 2px solid #E2DCE8;
		border-radius: 50%;
		outline: none;
		margin: 0;
		display: flex;
		align-items: center;
		justify-content: center;
		transition: all 0.2s ease;
		background-color: #FFFFFF;
	}

	.so-payment-radio-label input[type="radio"]::before {
		content: "";
		width: 10px;
		height: 10px;
		border-radius: 50%;
		background-color: #612989;
		transform: scale(0);
		transition: transform 0.2s ease;
	}

	.so-payment-radio-label input[type="radio"]:checked {
		border-color: #612989;
	}

	.so-payment-radio-label input[type="radio"]:checked::before {
		transform: scale(1);
	}

	.so-payment-radio-label:has(input[type="radio"]:checked) {
		color: #612989;
	}

	.so-payment-radio-label.is-disabled {
		opacity: 0.55;
		cursor: not-allowed;
		pointer-events: none;
	}

	/* Customer Info custom grid */
	.so-customer-grid {
		display: grid;
		grid-template-columns: 2fr 1fr;
		gap: 24px;
		margin-bottom: 24px;
	}

	@media (max-width: 768px) {
		.so-customer-grid {
			grid-template-columns: 1fr;
			gap: 16px;
		}
	}

	.so-customer-left {
		display: flex;
		flex-direction: column;
		gap: 24px;
	}

	.so-customer-right-box {
		width: 680px;
		margin: 27px 10px 0 0;
		background-color: #F1F0F5;
		border-radius: 10px;
		display: flex;
		align-items: center;
		justify-content: center;
		box-sizing: border-box;
	}

	.btn-add-customer {
		background-color: #FFFFFF;
		color: #612989;
		border: 1px solid #EFEBEF;
		border-radius: 24px;
		padding: 12px 32px;
		font-size: 14px;
		font-weight: 600;
		cursor: pointer;
		display: inline-flex;
		align-items: center;
		gap: 8px;
		box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
		font-family: 'Prompt', sans-serif;
		transition: all 0.2s ease;
	}

	.btn-add-customer:hover {
		background-color: #EFEBFF;
		border-color: #612989;
		transform: translateY(-1px);
	}

	.search-wrapper {
		position: relative;
	}

	.search-wrapper::after {
		content: '\f002';
		font-family: 'Font Awesome 5 Free';
		font-weight: 900;
		position: absolute;
		right: 16px;
		top: 50%;
		transform: translateY(-50%);
		color: #8E8B94;
		pointer-events: none;
		font-size: 16px;
	}

	/* Customer top grid layout to match new design */
	.so-customer-top-grid {
		display: grid;
		grid-template-columns: 328px 1fr;
		gap: 24px;
		margin-bottom: 24px;
	}

	@media (max-width: 768px) {
		.so-customer-top-grid {
			grid-template-columns: 1fr;
			gap: 16px;
		}
	}

	.so-customer-top-left {
		display: flex;
		flex-direction: column;
		gap: 24px;
		justify-content: space-between;
	}

	.so-customer-pills-row {
		display: flex;
		gap: 16px;
		align-items: center;
		height: 42px;
		margin-bottom: 4px;
	}

	/* Special pill buttons styling for customer section */
	.btn-add-customer-pill {
		background-color: #FFFFFF;
		color: #612989;
		border: 1px solid #EFEBEF;
		border-radius: 24px;
		height: 42px;
		padding: 0 24px;
		font-size: 14px;
		font-weight: 500;
		cursor: pointer;
		display: inline-flex;
		align-items: center;
		gap: 8px;
		box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
		font-family: 'Prompt', sans-serif;
		transition: all 0.2s ease;
		box-sizing: border-box;
	}

	.btn-add-customer-pill:hover {
		background-color: #EFEBFF;
		border-color: #612989;
	}

	.so-toggle-pill-outline-custom {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		background-color: #FFFFFF;
		color: #612989;
		border: 1px solid #EFEBEF;
		border-radius: 24px;
		height: 42px;
		padding: 0 24px;
		font-size: 14px;
		font-weight: 500;
		cursor: pointer;
		transition: all 0.2s ease;
		min-width: 120px;
		text-align: center;
		font-family: 'Prompt', sans-serif;
		box-sizing: border-box;
		user-select: none;
	}

	.so-toggle-pill-outline-custom input[type="checkbox"] {
		display: none;
	}

	.so-toggle-pill-outline-custom.active,
	.so-toggle-pill-outline-custom:has(input[type="checkbox"]:checked) {
		background-color: #EFEBFF;
		color: #612989;
		border-color: #612989;
	}

	.so-toggle-pill-outline-custom span {
		display: inline-flex;
		align-items: center;
		gap: 6px;
	}

	.so-customer-top-right {
		display: flex;
		flex-direction: column;
	}

	.so-customer-top-right .so-textarea {
		height: 118px;
		resize: none;
	}

	/* Responsive refinements for dense form layouts */
	.w3-container[style*="max-width: 1200px"] {
		width: min(100%, 1200px);
		padding-inline: 16px;
		box-sizing: border-box;
	}

	.so-header-container,
	.so-tabs-container,
	.so-card {
		container-type: inline-size;
	}

	.so-input-wrapper,
	.so-select-wrapper,
	.so-input-wrapper .so-input,
	.so-select-wrapper .so-select {
		width: 100%;
		max-width: 100%;
		min-width: 0;
	}

	.so-input,
	.so-select,
	.so-textarea {
		max-width: 100%;
	}

	.so-header-left,
	.so-header-right,
	.so-ref-info,
	.so-payment-modes,
	.so-customer-pills-row,
	.so-toggle-group {
		flex-wrap: wrap;
	}

	.so-header-right,
	.so-payment-modes,
	.so-toggle-group,
	.so-customer-pills-row {
		row-gap: 12px;
	}

	.so-tab-btn,
	.so-toggle-pill,
	.so-toggle-pill-outline-custom,
	.btn-add-customer-pill,
	.btn-preview-so,
	.btn-clear-loan-reserve,
	.so-payment-radio-label,
	.customer-popup-add,
	.customer-popup-actions button {
		min-height: 44px;
	}

	.customer-info-display-card,
	.so-payment-modes,
	.so-customer-pills-row {
		width: 100%;
		box-sizing: border-box;
	}

	.so-address-actions {
		flex-wrap: wrap;
		row-gap: 12px;
	}

	.so-address-action-btn {
		min-height: 44px;
	}

	#debt_table_wrap,
	#debt_panel {
		max-width: 100%;
		overflow-x: auto;
	}

	.so-sticky-actions,
	.so-sticky-actions-inner {
		box-sizing: border-box;
	}

	@container (max-width: 860px) {
		.so-header-container {
			flex-direction: column;
			align-items: flex-start;
			gap: 16px;
		}

		.so-header-right {
			width: 100%;
		}

		.so-header-right>button {
			flex: 1 1 220px;
			justify-content: center;
		}

		.so-tabs-container {
			padding-left: 0;
			flex-wrap: wrap;
			gap: 8px;
		}

		.so-tab-btn {
			flex: 1 1 220px;
			text-align: center;
			border-radius: 12px;
			border-bottom: 1px solid #ffffff;
		}

		.so-tab-btn.active {
			padding-bottom: 12px;
		}

		.so-address-action-btn {
			flex: 1 1 220px;
			justify-content: center;
		}

		.so-card {
			padding: 24px 18px;
		}

		.so-customer-top-grid {
			grid-template-columns: 1fr;
		}

		.customer-info-display-card {
			flex-direction: column;
			gap: 18px;
			padding: 18px;
		}

		.cidc-label {
			width: 96px;
			flex: 0 0 96px;
		}
	}

	@container (max-width: 560px) {
		.so-ref-info {
			flex-direction: column;
			align-items: flex-start;
			gap: 4px;
		}

		.so-card {
			padding: 20px 14px;
		}

		.so-title {
			font-size: clamp(24px, 6vw, 28px);
		}

		.so-section-title {
			font-size: 18px;
		}

		.so-toggle-pill,
		.so-toggle-pill-outline-custom,
		.btn-add-customer-pill,
		.so-payment-radio-label,
		.customer-popup-add,
		.so-address-action-btn {
			width: 100%;
			justify-content: center;
		}

		.so-payment-modes {
			gap: 12px;
		}

		.so-payment-radio-label {
			padding: 10px 14px;
			border: 1px solid #ece3f4;
			border-radius: 12px;
			background: #fff;
		}

		.cidc-row {
			flex-direction: column;
			align-items: flex-start;
			gap: 4px;
		}

		.cidc-label {
			width: auto;
			flex: none;
		}
	}

	@media (max-width: 768px) {
		.so-input-with-checkbox {
			flex-direction: column;
			align-items: stretch;
		}

		.so-checkbox-label {
			white-space: normal;
		}

		.so-fieldset {
			padding: 18px 14px;
		}
	}

	@media (max-width: 640px) {
		.so-sticky-actions {
			padding: 14px 12px !important;
		}

		.so-sticky-actions-inner {
			padding-right: 0 !important;
			flex-direction: column;
			align-items: stretch !important;
		}

		.so-sticky-actions-inner>button {
			width: 100%;
			justify-content: center;
		}

</style>

<body>
	<?php

	$yearMonth = substr(date("Y") + 543, -2) . date("m");
	$sql = "SELECT MAX(ref_id) AS MAXID FROM hos__so";
	$qry = mysqli_query($conn, $sql) or die(mysqli_error());
	$rs = mysqli_fetch_assoc($qry);
	$maxId = substr($rs['MAXID'], -4);
	$maxId3 = substr($rs['MAXID'], -8);

	$maxId1 = substr($maxId3, 0, -4);
	$so = "SO";

	if ($maxId1 == $yearMonth) {
		$maxId1 = ($maxId + 1);
		$maxId2 = substr("00000" . $maxId1, -4);
		$nextId = $yearMonth . $maxId2;
	} else {
		$maxId1 = "0001";
		$nextId = $yearMonth . $maxId1;
	}

	$savedRefId = isset($_GET["ref_id"]) ? mysqli_real_escape_string($conn, $_GET["ref_id"]) : "";
	$savedSo = null;
	$savedRegister = null;
	$savedProducts = array();
	$savedProductsForForm = array();
	$savedOtherBill = null;
	$savedCommentSo = null;
	$savedCommentSoItems = array();
	$savedTransaction = null;
	$savedDeliveryPrint = null;
	$savedDeliveryBill = null;
	$savedShippingAddresses = array();
	$savedFormSession = null;

	if ($savedRefId !== "") {
		if (isset($_SESSION['register_suphos_saved_form'][$savedRefId])) {
			$savedFormSession = $_SESSION['register_suphos_saved_form'][$savedRefId];
			unset($_SESSION['register_suphos_saved_form'][$savedRefId]);
		}

		$savedSoQuery = mysqli_query($conn, "SELECT * FROM hos__so WHERE ref_id = '" . $savedRefId . "' LIMIT 1");
		if ($savedSoQuery) {
			$savedSo = mysqli_fetch_assoc($savedSoQuery);
		}

		$savedRegisterQuery = mysqli_query($conn, "SELECT * FROM tb_register_data WHERE ref_id = '" . $savedRefId . "' LIMIT 1");
		if ($savedRegisterQuery) {
			$savedRegister = mysqli_fetch_assoc($savedRegisterQuery);
		}

		$savedOtherBillQuery = mysqli_query($conn, "SELECT * FROM tb_other_bill WHERE ref_id = '" . $savedRefId . "' LIMIT 1");
		if ($savedOtherBillQuery) {
			$savedOtherBill = mysqli_fetch_assoc($savedOtherBillQuery);
		}

		$savedCommentSoQuery = mysqli_query($conn, "SELECT * FROM tb_comment_so WHERE ref_id = '" . $savedRefId . "' ORDER BY id DESC LIMIT 1");
		if ($savedCommentSoQuery) {
			$savedCommentSo = mysqli_fetch_assoc($savedCommentSoQuery);
		}

		$savedCommentSoItemsQuery = mysqli_query($conn, "SELECT department_id, message, sort_order FROM tb_comment_so_item WHERE ref_id = '" . $savedRefId . "' ORDER BY sort_order ASC, id ASC");
		if ($savedCommentSoItemsQuery) {
			while ($savedCommentSoItem = mysqli_fetch_assoc($savedCommentSoItemsQuery)) {
				$savedCommentSoItems[] = $savedCommentSoItem;
			}
		}

		$savedTransactionQuery = mysqli_query($conn, "SELECT * FROM tb_transaction WHERE ref_id = '" . $savedRefId . "' LIMIT 1");
		if ($savedTransactionQuery) {
			$savedTransaction = mysqli_fetch_assoc($savedTransactionQuery);
		}

		$savedDeliveryPrintQuery = mysqli_query($conn, "SELECT * FROM tb_delivery_print WHERE ref_id = '" . $savedRefId . "' LIMIT 1");
		if ($savedDeliveryPrintQuery) {
			$savedDeliveryPrint = mysqli_fetch_assoc($savedDeliveryPrintQuery);
		}

		$savedDeliveryBillQuery = mysqli_query($conn, "SELECT * FROM tb_delivery_bill WHERE ref_id = '" . $savedRefId . "' LIMIT 1");
		if ($savedDeliveryBillQuery) {
			$savedDeliveryBill = mysqli_fetch_assoc($savedDeliveryBillQuery);
		}

		$savedShippingAddressOrderBy = "";
		$savedShippingAddressIdColumnQuery = mysqli_query($conn, "SHOW COLUMNS FROM tb_shipping_address LIKE 'id'");
		if ($savedShippingAddressIdColumnQuery && mysqli_num_rows($savedShippingAddressIdColumnQuery) > 0) {
			$savedShippingAddressOrderBy = " ORDER BY id ASC";
		}

		$savedShippingAddressQuery = mysqli_query($conn, "SELECT ref_id, contact_name, telephone, province, address FROM tb_shipping_address WHERE ref_id = '" . $savedRefId . "'" . $savedShippingAddressOrderBy);
		if ($savedShippingAddressQuery) {
			while ($savedShippingAddressRow = mysqli_fetch_assoc($savedShippingAddressQuery)) {
				$savedShippingAddresses[] = $savedShippingAddressRow;
			}
		}

		$savedProductQuery = mysqli_query($conn, "SELECT hos__subso.*, tb_product.sol_name AS master_product_name, tb_product.access_code AS master_access_code, tb_product.unit_name AS master_unit_name FROM hos__subso LEFT JOIN tb_product ON hos__subso.product_id = tb_product.product_ID WHERE hos__subso.ref_idd = '" . $savedRefId . "' AND COALESCE(hos__subso.bom_ckk, '0') <> '1'");
		if ($savedProductQuery) {
			while ($savedProduct = mysqli_fetch_assoc($savedProductQuery)) {
				$savedProducts[] = $savedProduct;
			}
		}
	}

	if (count($savedProducts) > 0) {
		foreach ($savedProducts as $savedProduct) {
			$savedProductsForForm[] = array(
				'product_id' => (string)($savedProduct["product_id"] ?? ""),
				'product_code' => (string)($savedProduct["master_access_code"] ?? ""),
				'product_name' => (string)($savedProduct["master_product_name"] ?? $savedProduct["admin_remark"] ?? $savedProduct["display_name"] ?? $savedProduct["product_code"] ?? ""),
				'product_sn' => (string)($savedProduct["sn"] ?? ""),
				'unit_name' => (string)($savedProduct["master_unit_name"] ?? ""),
				'sale_count' => (string)($savedProduct["count"] ?? ""),
				'product_price' => (string)($savedProduct["price"] ?? ""),
				'discount_unit' => (string)($savedProduct["discount"] ?? ""),
				'sum_amount' => (string)($savedProduct["amount"] ?? ""),
				'warranty' => (string)($savedProduct["warranty"] ?? ""),
				'cal' => (string)($savedProduct["cal"] ?? ""),
				'pm_year' => (string)($savedProduct["pm_year"] ?? ""),
				'pm' => (string)($savedProduct["pm"] ?? ""),
				'sale_remarkk' => (string)($savedProduct["sale_remark"] ?? ""),
				'clear_br' => (string)($savedProduct["clear_br"] ?? ""),
				'clear_ivno' => (string)($savedProduct["clear_ivno"] ?? ""),
				'jong_ckk' => (string)($savedProduct["jong_ckk"] ?? ""),
				'jong_no' => (string)($savedProduct["jong_no"] ?? ""),
				'display_name' => (string)($savedProduct["admin_remark"] ?? $savedProduct["display_name"] ?? ""),
				'subso_db_id' => (string)($savedProduct["id"] ?? "")
			);
		}
	}

	if (!empty($savedFormSession['products']) && is_array($savedFormSession['products'])) {
		$savedProductsForForm = $savedFormSession['products'];
	}

	$savedExtraAddressRows = array();

	if (!empty($savedShippingAddresses) && is_array($savedShippingAddresses)) {
		foreach ($savedShippingAddresses as $savedShippingAddress) {
			$savedExtraAddressRows[] = array(
				'contact_name' => (string)($savedShippingAddress['contact_name'] ?? ''),
				'telephone' => (string)($savedShippingAddress['telephone'] ?? ''),
				'province' => (string)($savedShippingAddress['province'] ?? ''),
				'address' => (string)($savedShippingAddress['address'] ?? '')
			);
		}
	} elseif (!empty($savedDeliveryPrint) && is_array($savedDeliveryPrint)) {
		for ($extraIndex = 1; $extraIndex <= 9; $extraIndex++) {
			$legacyExtraAddress = array(
				'contact_name' => (string)($savedDeliveryPrint['customer_name' . $extraIndex] ?? ''),
				'telephone' => (string)($savedDeliveryPrint['customer_tel' . $extraIndex] ?? ''),
				'province' => (string)($savedDeliveryPrint['province_name' . $extraIndex] ?? ''),
				'address' => (string)($savedDeliveryPrint['address_name' . $extraIndex] ?? '')
			);

			if ($legacyExtraAddress['contact_name'] !== '' || $legacyExtraAddress['telephone'] !== '' || $legacyExtraAddress['province'] !== '' || $legacyExtraAddress['address'] !== '') {
				$savedExtraAddressRows[] = $legacyExtraAddress;
			}
		}
	}

	if (count($savedExtraAddressRows) === 0) {
		$savedExtraAddressRows[] = array(
			'contact_name' => '',
			'telephone' => '',
			'province' => '',
			'address' => ''
		);
	}

	$savedFirstExtraAddress = $savedExtraAddressRows[0];
	$savedDeliveryBillAddress = array(
		'contact_name' => (string)($savedDeliveryBill['customer_nameb'] ?? ''),
		'telephone' => (string)($savedDeliveryBill['customer_telb'] ?? ''),
		'province' => (string)($savedDeliveryBill['province'] ?? ''),
		'address' => (string)($savedDeliveryBill['address_nameb'] ?? '')
	);
	$printCoverRefId = ($savedSo !== null && !empty($savedSo['ref_id'])) ? (string)$savedSo['ref_id'] : '';
	$coverSheetMainReports = array(
		array('label' => '99std', 'file' => 'report_h99std.php'),
		array('label' => '99std+k', 'file' => 'report_h99std_k.php'),
		array('label' => 'a5ptl', 'file' => 'report_ha5ptl.php'),
		array('label' => 'a5ptl+k', 'file' => 'report_ha5ptl_k.php'),
		array('label' => 'a4ptl', 'file' => 'report_ha4ptl.php'),
		array('label' => 'a4ptl+k', 'file' => 'report_ha4ptl_k.php'),
		array('label' => 'a5nbm', 'file' => 'report_ha5nbm.php'),
		array('label' => 'a5nbm+k', 'file' => 'report_ha5nbm_k.php'),
		array('label' => 'a4nbm', 'file' => 'report_ha4nbm.php'),
		array('label' => 'a4nbm+k', 'file' => 'report_ha4nbm_k.php')
	);
	$coverSheetExtraReports = array(
		array('label' => '99std', 'file_pattern' => 'report_h99std%s.php'),
		array('label' => '99std+k', 'file_pattern' => 'report_h99std_k%s.php'),
		array('label' => 'a5', 'file_pattern' => 'report_ha5all%s.php'),
		array('label' => 'a5+k', 'file_pattern' => 'report_ha5all_k%s.php'),
		array('label' => 'a4', 'file_pattern' => 'report_ha4all%s.php'),
		array('label' => 'a4+k', 'file_pattern' => 'report_ha4all_k%s.php')
	);
	$billDeliveryReports = array(
		array('label' => '99std', 'file' => 'reportb_h99std.php'),
		array('label' => 'a5ptl', 'file' => 'reportb_ha5ptl.php'),
		array('label' => 'a4ptl', 'file' => 'reportb_ha4ptl.php'),
		array('label' => 'a5nbm', 'file' => 'reportb_ha5nbm.php'),
		array('label' => 'a4nbm', 'file' => 'reportb_ha4nbm.php')
	);

	function so_saved_h($value)
	{
		return htmlspecialchars((string)($value ?? ""), ENT_QUOTES, "UTF-8");
	}

	function so_saved_display($value)
	{
		$value = trim((string)($value ?? ""));
		return $value !== "" ? so_saved_h($value) : "-";
	}

	function so_saved_money($value)
	{
		if ($value === null || $value === "") {
			return "-";
		}

		return is_numeric($value) ? number_format((float)$value, 2) : so_saved_h($value);
	}

	function so_saved_checked($row, $key)
	{
		return isset($row[$key]) && trim((string)$row[$key]) === "1";
	}

	function so_saved_time_value($value)
	{
		$value = trim((string)($value ?? ""));
		if (preg_match('/\b([01]?\d|2[0-3]):([0-5]\d)(?::[0-5]\d)?\b/', $value, $matches)) {
			return sprintf('%02d:%02d', (int)$matches[1], (int)$matches[2]);
		}
		return "";
	}

	function so_saved_delivery_time_part($savedSo, $savedRegister, $partIndex)
	{
		$deliveryTime = (string)($savedSo["delivery_time"] ?? "");
		if ($deliveryTime !== "") {
			preg_match_all('/\b([01]?\d|2[0-3]):([0-5]\d)(?::[0-5]\d)?\b/', $deliveryTime, $matches, PREG_SET_ORDER);
			if (isset($matches[$partIndex])) {
				return sprintf('%02d:%02d', (int)$matches[$partIndex][1], (int)$matches[$partIndex][2]);
			}
		}

		$fallbackKey = $partIndex === 0 ? "start_time" : "end_time";
		return so_saved_time_value($savedRegister[$fallbackKey] ?? "");
	}

	function so_saved_buddhist_date_input($value)
	{
		$value = trim((string)($value ?? ""));
		if ($value === "") {
			return "";
		}

		if (preg_match('/^(\d{4})-(\d{2})-(\d{2})(?:\s.*)?$/', $value, $matches)) {
			return sprintf('%02d/%02d/%04d', (int)$matches[3], (int)$matches[2], (int)$matches[1] + 543);
		}

		if (preg_match('/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/', $value, $matches)) {
			$year = (int)$matches[3];
			if ($year < 2400) {
				$year += 543;
			}
			return sprintf('%02d/%02d/%04d', (int)$matches[1], (int)$matches[2], $year);
		}

		return $value;
	}





	?>

	<?php if (isset($_GET["saved"]) && $_GET["saved"] === "1") { ?>
		<script>
			document.addEventListener('DOMContentLoaded', function() {
				if (typeof Swal === 'undefined') {
					alert('บันทึกข้อมูลเรียบร้อยแล้ว');
					return;
				}

				Swal.fire({
					title: 'บันทึกข้อมูลเรียบร้อยแล้ว',
					text: 'ระบบแสดงข้อมูลที่บันทึกไว้ในหน้านี้แล้ว',
					icon: 'success',
					confirmButtonColor: '#612989',
					confirmButtonText: 'ตกลง'
				});
			});
		</script>
	<?php } ?>

	<?php if (false && ($savedSo || $savedRegister)) { ?>
		<div style="max-width: 1200px; margin: 24px auto 0; padding: 0 16px; box-sizing: border-box;">
			<div style="background: #fff; border: 1px solid #EBEBEB; border-left: 5px solid #612989; border-radius: 8px; padding: 20px 24px; box-shadow: 0 6px 18px rgba(0,0,0,0.06); font-family: 'Prompt', sans-serif;">
				<div style="display: flex; justify-content: space-between; gap: 16px; align-items: flex-start; flex-wrap: wrap; margin-bottom: 16px;">
					<div>
						<div style="font-size: 13px; color: #7a7280; margin-bottom: 4px;">ข้อมูลที่บันทึกแล้ว</div>
						<div style="font-size: 22px; font-weight: 600; color: #2d2533;">เลขที่อ้างอิง <?php echo so_saved_display($savedRefId); ?></div>
					</div>
					<a href="register_suphos_edit.php?ref_id=<?php echo urlencode($savedRefId); ?>" style="background: #612989; color: #fff; text-decoration: none; border-radius: 22px; padding: 10px 20px; font-size: 14px;">เปิดหน้าแก้ไข</a>
				</div>

				<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 12px; margin-bottom: 18px;">
					<div style="background: #F8F7FC; border-radius: 8px; padding: 12px;">
						<div style="font-size: 12px; color: #7a7280;">ลูกค้า/ออกบิล</div>
						<div style="font-size: 15px; color: #2d2533; font-weight: 500;"><?php echo so_saved_display($savedSo["bill_name"] ?? ""); ?></div>
					</div>
					<div style="background: #F8F7FC; border-radius: 8px; padding: 12px;">
						<div style="font-size: 12px; color: #7a7280;">ผู้ติดต่อจัดส่ง</div>
						<div style="font-size: 15px; color: #2d2533; font-weight: 500;"><?php echo so_saved_display($savedRegister["customer_name"] ?? ($savedSo["delivery_contact"] ?? "")); ?></div>
					</div>
					<div style="background: #F8F7FC; border-radius: 8px; padding: 12px;">
						<div style="font-size: 12px; color: #7a7280;">เบอร์โทร</div>
						<div style="font-size: 15px; color: #2d2533; font-weight: 500;"><?php echo so_saved_display($savedRegister["customer_tel"] ?? ($savedSo["delivery_tel"] ?? "")); ?></div>
					</div>
					<div style="background: #F8F7FC; border-radius: 8px; padding: 12px;">
						<div style="font-size: 12px; color: #7a7280;">วันที่ส่ง</div>
						<div style="font-size: 15px; color: #2d2533; font-weight: 500;"><?php echo so_saved_display($savedSo["delivery_date"] ?? ($savedRegister["start_date"] ?? "")); ?></div>
					</div>
					<div style="background: #F8F7FC; border-radius: 8px; padding: 12px;">
						<div style="font-size: 12px; color: #7a7280;">เวลาส่ง</div>
						<div style="font-size: 15px; color: #2d2533; font-weight: 500;"><?php echo so_saved_display($savedSo["delivery_time"] ?? (($savedRegister["start_time"] ?? "") . " " . ($savedRegister["end_time"] ?? ""))); ?></div>
					</div>
					<div style="background: #F8F7FC; border-radius: 8px; padding: 12px;">
						<div style="font-size: 12px; color: #7a7280;">พนักงาน</div>
						<div style="font-size: 15px; color: #2d2533; font-weight: 500;"><?php echo so_saved_display($savedRegister["employee_name"] ?? ($savedSo["sale"] ?? "")); ?></div>
					</div>
				</div>

				<div style="margin-bottom: 16px;">
					<div style="font-size: 13px; color: #7a7280; margin-bottom: 4px;">ที่อยู่จัดส่ง</div>
					<div style="font-size: 15px; color: #2d2533;"><?php echo so_saved_display($savedRegister["address_name"] ?? ($savedSo["delivery_address"] ?? "")); ?></div>
				</div>

				<?php if (count($savedProducts) > 0) { ?>
					<div style="overflow-x: auto;">
						<table style="width: 100%; border-collapse: collapse; font-size: 14px;">
							<thead>
								<tr style="background: #F4F3F7; color: #4A4A4A;">
									<th style="text-align: left; padding: 10px; border-bottom: 1px solid #EBEBEB;">สินค้า</th>
									<th style="text-align: right; padding: 10px; border-bottom: 1px solid #EBEBEB;">จำนวน</th>
									<th style="text-align: right; padding: 10px; border-bottom: 1px solid #EBEBEB;">ราคา</th>
									<th style="text-align: right; padding: 10px; border-bottom: 1px solid #EBEBEB;">รวม</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($savedProducts as $savedProduct) { ?>
									<tr>
										<td style="padding: 10px; border-bottom: 1px solid #F0EEF2;">
											<div style="font-weight: 500; color: #2d2533;"><?php echo so_saved_display($savedProduct["product_name"] ?? ($savedProduct["product_code"] ?? "")); ?></div>
											<?php if (!empty($savedProduct["sale_remark"])) { ?>
												<div style="font-size: 12px; color: #7a7280;"><?php echo so_saved_h($savedProduct["sale_remark"]); ?></div>
											<?php } ?>
										</td>
										<td style="padding: 10px; border-bottom: 1px solid #F0EEF2; text-align: right;"><?php echo so_saved_display($savedProduct["count"] ?? ""); ?></td>
										<td style="padding: 10px; border-bottom: 1px solid #F0EEF2; text-align: right;"><?php echo so_saved_money($savedProduct["price"] ?? ""); ?></td>
										<td style="padding: 10px; border-bottom: 1px solid #F0EEF2; text-align: right;"><?php echo so_saved_money($savedProduct["amount"] ?? ""); ?></td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				<?php } ?>
			</div>
		</div>
	<?php } ?>

	<?php if (count($savedProductsForForm) > 0) { ?>
		<script>
			document.addEventListener('DOMContentLoaded', function() {
				var savedProductsForForm = <?php echo json_encode($savedProductsForForm, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>;

				savedProductsForForm.forEach(function(product, index) {
					var rowIndex = index + 1;
					var row = document.getElementById('product_row_' + rowIndex);
					if (!row) {
						return;
					}

					row.style.display = '';

					var setValue = function(prefix, value) {
						var element = document.getElementById(prefix + rowIndex);
						if (element) {
							element.value = value || '';
						}
					};

					setValue('product_id', product.product_id);
					setValue('product_codet', product.product_code);
					setValue('h_product_codet', product.product_code);
					setValue('product_name', product.product_name);
					setValue('product_sn', product.product_sn);
					setValue('unit_name', product.unit_name);
					setValue('sale_count', product.sale_count);
					setValue('product_price', product.product_price);
					setValue('discount_unit', product.discount_unit);
					setValue('sum_amount', product.sum_amount);
					setValue('warranty', product.warranty);
					setValue('cal', product.cal);
					setValue('pm_year', product.pm_year);
					setValue('pm', product.pm);
					setValue('sale_remarkk', product.sale_remarkk);
					setValue('clear_br', product.clear_br);
					setValue('clear_ivno', product.clear_ivno);
					setValue('jong_ckk', product.jong_ckk);
					setValue('jong_no', product.jong_no);
					setValue('display_name', product.display_name);
					setValue('subso_db_id', product.subso_db_id);

					var productNameLabel = document.getElementById('product_name_label' + rowIndex);
					if (productNameLabel) {
						productNameLabel.textContent = product.product_name || product.product_code || '';
					}

					if (typeof formatNumberInput === 'function') {
						var priceElement = document.getElementById('product_price' + rowIndex);
						var discountElement = document.getElementById('discount_unit' + rowIndex);
						if (priceElement && priceElement.value !== '') {
							formatNumberInput(priceElement);
						}
						if (discountElement && discountElement.value !== '') {
							formatNumberInput(discountElement);
						}
					}

					if (typeof updateRowTotal === 'function') {
						updateRowTotal(rowIndex);
					}
				});

				if (typeof calculateSummary === 'function') {
					calculateSummary();
				}
			});
		</script>
	<?php } ?>

	<!--action="register_office1.php"-->
	<form action='<?php echo ($savedSo !== null) ? "register_suphos_edit1.php" : "register_suphos1.php"; ?>' method="post" name="frmMain" enctype="multipart/form-data" onSubmit="JavaScript:return fncSubmit();">

		<script language="javascript">
			function fncSubmit() //ตรวจสอบข้อมูลก่อนบันทึก
			{
				syncFormCompatibilityFields();
				if (typeof syncDeptComments === 'function') {
					syncDeptComments();
				}
				if (typeof syncDeliveryTimeRange === 'function') {
					syncDeliveryTimeRange();
				}
				updateDeliveryContractRequirement();
				if (!validateDeliveryContractRequirement()) {
					return false;
				}

				if (document.frmMain.sale_code && document.frmMain.sale_code.value == "") {
					alert('กรุณาเลือกแผนก/เขตการขาย');
					document.frmMain.sale_code.focus();
					return false;
				}
				if (document.frmMain.payment.value == "") {
					alert('กรุณาเลือกช่องทางการชำระเงิน');
					var visiblePayment = document.getElementById('payment_cash_select') || document.getElementById('payment_method') || document.getElementById('pay_mode_cash');
					if (visiblePayment) {
						visiblePayment.focus();
					}
					return false;
				}

				if (document.frmMain.payment.value != "") {
					if (document.frmMain.payment.value == "7") {


						if (document.frmMain.date_tranfer && document.frmMain.date_tranfer.type !== "hidden" && document.frmMain.date_tranfer.value == "") {

							alert('กรุณาใส่วันที่โอน');
							document.frmMain.date_tranfer.focus();
							return false;
						}
					}
				}

				if (document.frmMain.start_time.value == "") {

					alert('กรุณาใส่เวลาส่ง');
					document.frmMain.start_time.focus();
					return false;
				}

				if (document.frmMain.customer_name.value == "") {
					alert('กรุณาใส่ชื่อลูกค้า');
					document.frmMain.customer_name.focus();
					return false;
				}

				if (document.frmMain.customer_tel.value == "") {
					alert('กรุณาใส่เบอร์โทรลูกค้า');
					document.frmMain.customer_tel.focus();
					return false;
				}
				if (document.frmMain.address_1.value == "") {
					alert('กรุณาใส่สถานที่ส่งสินค้า');
					document.frmMain.address_1.focus();
					return false;
				}

				if (document.frmMain.address_name.value == "") {
					alert('กรุณาใส่ที่อยู่ในการส่งสินค้า');
					document.frmMain.address_name.focus();
					return false;
				}

				if (document.frmMain.address_send.value == "") {
					alert('กรุณาใส่สถานที่ติดตั้งเครื่อง');
					document.frmMain.address_send.focus();
					return false;
				}

				if (document.frmMain.h_employee_name.value == "") {
					alert('กรุณาเลือกชื่อพนักงาน');
					document.frmMain.employee_name.focus();
					return false;
				}

				if (document.frmMain.province_name.value == "") {
					alert('กรุณาเลือกจังหวัดที่ต้องการจัดส่ง');
					document.frmMain.province_name.focus();
					return false;
				}

				if (window.soSubmitConfirmed) {
					return true;
				}

				if (typeof Swal === 'undefined') {
					return confirm('ยืนยันการบันทึกข้อมูลใช่หรือไม่?');
				}

				Swal.fire({
					title: 'ยืนยันการบันทึกข้อมูล',
					text: 'ตรวจสอบข้อมูลเรียบร้อยแล้ว ต้องการบันทึกข้อมูลนี้ใช่หรือไม่?',
					icon: 'question',
					showCancelButton: true,
					confirmButtonColor: '#612989',
					cancelButtonColor: '#8a8a8a',
					confirmButtonText: 'ยืนยันบันทึก',
					cancelButtonText: 'ยกเลิก'
				}).then(function(result) {
					if (!result.isConfirmed) {
						return;
					}

					var form = document.forms['frmMain'];
					var submitValue = form.querySelector('input[type="hidden"][name="submit"]');
					if (!submitValue) {
						submitValue = document.createElement('input');
						submitValue.type = 'hidden';
						submitValue.name = 'submit';
						form.appendChild(submitValue);
					}
					submitValue.value = 'submit';
					window.soSubmitConfirmed = true;
					HTMLFormElement.prototype.submit.call(form);
				});

				return false;
			}

			function saveDraft() {
				syncFormCompatibilityFields();
				if (typeof syncDeptComments === 'function') {
					syncDeptComments();
				}
				if (typeof syncDeliveryTimeRange === 'function') {
					syncDeliveryTimeRange();
				}

				var form = document.forms['frmMain'];
				if (!form) {
					return;
				}

				var btn = form.querySelector('[name="save_draft"]');
				var defaultHtml = btn ? btn.innerHTML : '';
				var formData = new FormData(form);
				formData.set('is_draft', '1');

				if (btn) {
					btn.disabled = true;
					btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
				}

				fetch('register_suphos_draft1.php', {
						method: 'POST',
						body: formData
					})
					.then(function(res) {
						return res.json();
					})
					.then(function(data) {
						if (data && data.success) {
							return Swal.fire({
								title: 'Save Draft success',
								text: 'Ref ID: ' + data.ref_id,
								icon: 'success',
								confirmButtonColor: '#612989'
							}).then(function() {
								window.location.href = 'register_suphos.php?ref_id=' + encodeURIComponent(data.ref_id) + '&saved=1';
							});
						}

						var message = data && data.message ? data.message : 'Unable to save draft';
						return Swal.fire('Error', message, 'error');
					})
					.catch(function() {
						return Swal.fire('Error', 'Unable to save draft', 'error');
					})
					.finally(function() {
						if (btn) {
							btn.disabled = false;
							btn.innerHTML = defaultHtml;
						}
					});
			}

			function openPrintReport() {
				var form = document.forms.frmMain;
				var refInput = form ? form.querySelector('input[name="ref_id"]') : null;
				var typeDocSelect = document.getElementById('type_doc_select');
				var refId = refInput ? refInput.value.trim() : '';
				var typeDoc = typeDocSelect ? typeDocSelect.value : '';

				if (!form || !refId) {
					Swal.fire('แจ้งเตือน', 'ไม่พบเลขที่อ้างอิง (ref_id)', 'warning');
					return;
				}

				var reportUrl = '';
				if (typeDoc === '3') {
					reportUrl = 'report_salehosptl1.php';
				} else if (typeDoc === '4') {
					reportUrl = 'report_salehosnbm1.php';
				} else {
					Swal.fire('แจ้งเตือน', 'ไม่สามารถระบุประเภทเอกสารได้', 'warning');
					return;
				}

				if (typeof updateRowTotal === 'function') {
					for (var rowIndex = 1; rowIndex <= 30; rowIndex++) {
						updateRowTotal(rowIndex);
					}
				}

				var previewTarget = 'salehos_preview_' + Date.now();
				var previewWindow = window.open('', previewTarget);
				if (!previewWindow) {
					Swal.fire('แจ้งเตือน', 'เบราว์เซอร์บล็อกหน้าต่าง Preview กรุณาอนุญาต Pop-up แล้วลองใหม่', 'warning');
					return;
				}

				var previewFlag = document.createElement('input');
				previewFlag.type = 'hidden';
				previewFlag.name = '_report_preview';
				previewFlag.value = '1';
				form.appendChild(previewFlag);

				var originalAction = form.getAttribute('action');
				var originalMethod = form.getAttribute('method');
				var originalTarget = form.getAttribute('target');

				form.action = reportUrl;
				form.method = 'post';
				form.target = previewTarget;
				HTMLFormElement.prototype.submit.call(form);

				if (originalAction === null) form.removeAttribute('action');
				else form.setAttribute('action', originalAction);
				if (originalMethod === null) form.removeAttribute('method');
				else form.setAttribute('method', originalMethod);
				if (originalTarget === null) form.removeAttribute('target');
				else form.setAttribute('target', originalTarget);
				previewFlag.remove();
			}
		</script>

		<div class="w3-container" style="max-width: 1200px; margin: 0 auto;"><!-- main div -->

			<!-- Header Section -->
			<div class="so-header-container">
				<div class="so-header-left">
					<h1 class="so-title">Register Sale Order</h1>
					<div class="so-ref-info">
						<span class="so-ref-label">เลขที่อ้างอิง</span>
						<span class="so-ref-value"><?php echo ($savedSo !== null) ? $savedSo['ref_id'] : ($so . $nextId); ?></span>
					</div>

				</div>
				<div class="so-header-right">
					<button type="button" class="btn-clear-loan-reserve" id="clearLoanTriggerButton">เคลียร์จอง/ยืม</button>
					<button type="button" class="btn-preview-so" onclick="openPrintReport();"><img src="img/icons/preview.png" alt="preview" style="width: 16px; height: 16px;"> Preview</button>
				</div>
			</div>

			<!-- Tab buttons -->
			<div class="so-tabs-container">
				<button type="button" class="so-tab-btn active" onclick="switchSoTab(event, 'tab-document-info')">ข้อมูลเอกสาร</button>
				<button type="button" class="so-tab-btn" onclick="switchSoTab(event, 'tab-admin-info')">Admin</button>
			</div>

			<input type="hidden" name="ref_id" value="<?php echo ($savedSo !== null) ? so_saved_h($savedSo['ref_id']) : so_saved_h($so . $nextId); ?>">
			<input type="hidden" name="_preview_sale" value="<?php echo so_saved_h($_SESSION['name'] ?? ''); ?>">
			<input type="hidden" name="redirect_to" value="register_suphos.php">

			<!-- Card Container -->
			<div>

				<!-- TAB 1: ข้อมูลเอกสาร -->
				<div id="tab-document-info" class="so-tab-content active">

					<!-- เคลียร์ยืม/จอง Section (hidden by default) -->
					<div class="so-card">
						<!-- <div id="clear_loan_reserve_section" class="collapsible-clear-section">
							<div style="background-color: #FAF9FC; border-radius: 12px; padding: 20px; margin-bottom: 24px; border: 1px dashed #D3C9FC;">
								<h3 class="so-section-sub-title" style="color: #612989; margin: 0 0 16px 0; font-size: 16px; font-weight: 600;">เคลียร์ยืม/จอง</h3>
								<div class="so-grid-3">
									<div class="so-field-group">
										<div class="so-input-with-checkbox">
											<label class="so-checkbox-label">
												<input type="checkbox" name="book_clear" value="1"> เคลียร์ใบจอง :
											</label>
											<input name="book_no" class="so-input" placeholder="เลขที่..." style="flex: 1;">
										</div>
									</div>
									<div class="so-field-group">
										<div class="so-input-with-checkbox">
											<label class="so-checkbox-label">
												<input type="checkbox" name="brn_clear" value="1"> เคลียร์ใบยืมสินค้า ติดเล่ม :
											</label>
											<input name="brn_no" class="so-input" placeholder="เลขที่..." style="flex: 1;">
										</div>
									</div>
									<div class="so-field-group">
										<div class="so-input-with-checkbox">
											<label class="so-checkbox-label">
												<input type="checkbox" name="brnp_clear" value="1"> เคลียร์ใบยืมสินค้า กระดาษต่อเนื่อง :
											</label>
											<input name="brnp_no" class="so-input" placeholder="เลขที่..." style="flex: 1;">
										</div>
									</div>
								</div>
							</div>
						</div> -->

						<div class="so-grid-3">
							<!-- บริษัท* -->
							<div class="so-field-group">
								<label class="so-label">บริษัท<span class="required">*</span></label>
								<div class="so-select-wrapper">
									<select class="so-select" name="type_doc" id="type_doc_select" onchange="var r=document.querySelector('input[name=type_doc]'); if(r)r.value=this.value;">
										<option value="3">AWL</option>
										<option value="4">NBM</option>
									</select>
								</div>
							</div>

							<!-- ประเภท* -->
							<div class="so-field-group">
								<label class="so-label">ประเภท<span class="required">*</span></label>
								<div class="so-select-wrapper">
									<select class="so-select" id="doc_type_select" onchange="
									document.getElementById('ic_ckk').checked = false;
									document.getElementById('et_ckk').checked = false;
									if(this.value == '2') document.getElementById('et_ckk').checked = true;
									if(this.value == '3') document.getElementById('ic_ckk').checked = true;
								">
										<option value="1">ใบสั่งขาย</option>
										<option value="2">ใบสั่งขาย E-Tax</option>
										<option value="3">ใบฝากขาย (IC)</option>
									</select>
								</div>
							</div>

							<!-- E-Mail* -->
							<div class="so-field-group">
								<label class="so-label">E-Mail<span class="required">*</span></label>
								<div class="so-input-wrapper">
									<input type="text" name="email" id="email" class="so-input" value="<?php echo ($savedSo !== null) ? so_saved_h($savedSo['email'] ?? '') : ''; ?>" placeholder="example@email.com" style="padding-right: 32px;">
									<i class="fas fa-times" style="position: absolute; right: 12px; cursor: pointer; color: #8E8B94;" onclick="document.getElementById('email').value=''"></i>
								</div>
							</div>
						</div>

						<div class="so-grid-3">
							<!-- แผนก/เขตการขาย* -->
							<div class="so-field-group">
								<label class="so-label">แผนก/เขตการขาย<span class="required">*</span></label>
								<div class="so-select-wrapper">
									<?php
									$saleCodeQueries = array(
										'SS1' => "SELECT * FROM tb_team_ss1 ORDER BY sale_code ASC",
										'SS2' => "SELECT * FROM tb_team_ss2 ORDER BY sale_code ASC",
										'SS3' => "SELECT * FROM tb_team_ss3 WHERE ckk_1='0' ORDER BY sale_code ASC",
										'SS5' => "SELECT * FROM tb_team_ss3 WHERE sale_code IN ('S31','S32') ORDER BY sale_code ASC",
										'SUP_MK' => "SELECT * FROM tb_team_adm WHERE ckk='1' ORDER BY sale_code ASC",
										'SUP_EN' => "SELECT * FROM tb_team_en ORDER BY sale_code ASC"
									);
									$userSaleCode = isset($_SESSION['code']) ? $_SESSION['code'] : '';
									$saleCodeSql = isset($saleCodeQueries[$userSaleCode]) ? $saleCodeQueries[$userSaleCode] : "SELECT * FROM tb_team_adm WHERE ckk='0' ORDER BY sale_code ASC";
									$saleCodeQuery = mysqli_query($com, $saleCodeSql);
									?>
									<select name="sale_code" id="sale_code" class="so-select">
										<option value="">เลือกแผนก/เขตการขาย</option>
										<?php if ($saleCodeQuery) { ?>
											<?php while ($saleCodeRow = mysqli_fetch_array($saleCodeQuery, MYSQLI_ASSOC)) { ?>
												<option value="<?php echo htmlspecialchars($saleCodeRow['sale_code'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($saleCodeRow['sale_code'] . ' - ' . $saleCodeRow['sale_name'], ENT_QUOTES, 'UTF-8'); ?></option>
											<?php } ?>
										<?php } ?>
									</select>
								</div>
							</div>

							<!-- ช่องทางการขาย* -->
							<div class="so-field-group">
								<label class="so-label">ช่องทางการขาย<span class="required">*</span></label>
								<div class="so-select-wrapper">
									<select name="sale_channel" id="sale_channel" class="so-select">
										<option value="">เลือกช่องทางการขาย</option>
										<?php
										$sqlchannel = "SELECT * FROM tb_salechannel ORDER BY salechannel_ID";
										$querychannel = false;
										$saleChannelTable = mysqli_query($conn, "SHOW TABLES LIKE 'tb_salechannel'");
										if ($saleChannelTable && mysqli_num_rows($saleChannelTable) > 0) {
											$querychannel = mysqli_query($conn, $sqlchannel);
										}
										if ($querychannel) {
											while ($fetchchannel = mysqli_fetch_array($querychannel, MYSQLI_ASSOC)) {
												$channelLabel = trim($fetchchannel['salechannel_nameshort'] . ' ' . $fetchchannel['description_chanel']);
										?>
												<option value="<?php echo htmlspecialchars($fetchchannel['salechannel_ID'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($channelLabel, ENT_QUOTES, 'UTF-8'); ?></option>
										<?php
											}
										}
										?>
									</select>
								</div>
							</div>

							<!-- Extra document options that were next to type_doc in original: ใบฝากขาย, ขอบิล E-Tax (Hidden since it's now in the dropdown) -->
							<div class="so-field-group" style="display: none;">
								<div style="display: flex; gap: 16px; align-items: center; height: 48px;">
									<label class="so-checkbox-label">
										<input type="checkbox" name="ic_ckk" id="ic_ckk" value="1">
										<span style="color: #612989; font-weight: 600;">ใบฝากขาย</span>
									</label>
									<label class="so-checkbox-label">
										<input type="checkbox" name="et_ckk" id="et_ckk" value="1">
										<span style="color: #612989; font-weight: 600;">ขอบิล E-Tax</span>
									</label>
								</div>
							</div>
						</div>

						<!-- Section: ข้อมูลเอกสาร -->
						<div class="so-section-title-container">
							<h2 class="so-section-title">ข้อมูลเอกสาร</h2>
							<hr class="so-divider">
						</div>

						<?php
						date_default_timezone_set("Asia/Bangkok");
						$month = date('m');
						$day = date('d');
						$year = date('Y');
						$today = $year . '-' . $month . '-' . $day;
						?>

						<div class="so-grid-3-custom">
							<!-- วันที่ -->
							<div class="so-field-group">
								<label class="so-label">วันที่</label>
								<div class="so-input-wrapper calendar-wrapper">
									<input type="date" name="date_so" id="date_so" value="<?php echo $today; ?>" class="so-input">
								</div>
							</div>

							<!-- Toggles: งานด่วน, ออเดอร์ฝาก, ไม่ได้ประมาณการ -->
							<div class="so-field-group">
								<label class="so-label">&nbsp;</label>
								<div class="so-toggle-group">
									<label class="so-toggle-pill<?php echo so_saved_checked($savedSo, 'que_ckk') ? ' active' : ''; ?>" id="lbl-que_ckk">
										<input type="checkbox" name="que_ckk" id="que_ckk" value="1" <?php echo so_saved_checked($savedSo, 'que_ckk') ? ' checked' : ''; ?>>
										<span>งานด่วน</span>
									</label>
									<label class="so-toggle-pill<?php echo so_saved_checked($savedSo, 'have_order') ? ' active' : ''; ?>" id="lbl-have_order">
										<input type="checkbox" name="have_order" id="have_order" value="1" <?php echo so_saved_checked($savedSo, 'have_order') ? ' checked' : ''; ?>>
										<span>ออเดอร์ฝาก</span>
									</label>
									<label class="so-toggle-pill<?php echo so_saved_checked($savedSo, 'plan_ckk') ? ' active' : ''; ?>" id="lbl-plan_ckk">
										<input type="checkbox" name="plan_ckk" id="plan_ckk" value="1" <?php echo so_saved_checked($savedSo, 'plan_ckk') ? ' checked' : ''; ?>>
										<span>ไม่ได้ประมาณการ</span>
									</label>
								</div>
							</div>
						</div>

						<div class="so-grid-3">
							<!-- เลขที่ใบสั่งซื้อ/สัญญา -->
							<div class="so-field-group">
								<label class="so-label">เลขที่ใบสั่งซื้อ/สัญญา</label>
								<input name="po_no" class="so-input" placeholder="เช่น lv58945820965">
							</div>

							<!-- วันที่กำหนดส่งตามสัญญา* -->
							<div class="so-field-group">
								<label class="so-label">วันที่กำหนดส่งตามสัญญา<span class="required">*</span></label>
								<div class="so-input-wrapper calendar-wrapper">
									<input name="delivery_contract" type='date' id="delivery_contract" class="so-input" placeholder="กรุณาระบุเป็นวันที่เท่านั้น !!!">
								</div>
							</div>

							<!-- เลขที่ใบงานบริการ -->
							<div class="so-field-group">
								<label class="so-label">เลขที่ใบงานบริการ</label>
								<input name="cm_no" id="cm_no" class="so-input" placeholder="เช่น 932813829r7">
							</div>
						</div>
					</div>

				</div><!-- End TAB 1 -->

				<!-- TAB 2: Admin -->
				<div id="tab-admin-info" class="so-tab-content">
					<style>
						.admin-ui-title {
							font-size: 20px;
							font-weight: 500;
							color: #3B3B3B;
							margin: 0 0 24px 0;
							padding-bottom: 16px;
							border-bottom: 1px solid #EFEBEF;
						}

						.admin-ui-grid {
							display: grid;
							grid-template-columns: repeat(4, 1fr);
							gap: 24px;
							margin-bottom: 24px;
						}

						@media (max-width: 992px) {
							.admin-ui-grid {
								grid-template-columns: repeat(2, 1fr);
							}

							.admin-ui-field.span-3 {
								grid-column: span 2;
							}
						}

						@media (max-width: 768px) {
							.admin-ui-grid {
								grid-template-columns: 1fr;
							}

							.admin-ui-field.span-3 {
								grid-column: span 1;
							}
						}

						.admin-ui-field {
							display: flex;
							flex-direction: column;
							gap: 8px;
						}

						.admin-ui-field.span-3 {
							grid-column: span 3;
						}

						.admin-ui-label {
							font-size: 14px;
							font-weight: 400;
							color: #6E3CBC;
						}

						.admin-ui-input-wrapper {
							position: relative;
							display: flex;
							align-items: center;
						}

						.admin-ui-input {
							width: 100%;
							background-color: #F5F5F7;
							border: 1px solid transparent;
							border-radius: 12px;
							padding: 0 16px;
							font-size: 16px;
							font-weight: 400;
							color: #612989;
							font-family: 'Prompt', sans-serif;
							outline: none;
							height: 48px;
							box-sizing: border-box;
							transition: all 0.2s ease;
						}

						.admin-ui-input:focus {
							background-color: #FFFFFF;
							border-color: #6E3CBC;
							box-shadow: 0 0 0 3px rgba(110, 60, 188, 0.1);
						}

						.admin-ui-input.has-icon {
							padding-right: 48px;
						}

						.admin-ui-icon {
							position: absolute;
							right: 16px;
							color: #3B3B3B;
							font-size: 18px;
							pointer-events: none;
						}

						.admin-ui-icon-clickable {
							position: absolute;
							right: 16px;
							color: #8E8B94;
							font-size: 16px;
							cursor: pointer;
						}

						.admin-ui-btn {
							background-color: #F1E1FF;
							color: #612989;
							border: none;
							border-radius: 24px;
							height: 48px;
							padding: 0 24px;
							font-size: 16px;
							font-weight: 500;
							cursor: pointer;
							display: flex;
							align-items: center;
							justify-content: center;
							gap: 8px;
							font-family: 'Prompt', sans-serif;
							margin-top: 25px;
						}
					
</style>

					<div class="so-card">
						<h2 class="admin-ui-title">ข้อมูลเพิ่มเติม (Admin)</h2>

						<!-- Row 1 -->
						<div class="admin-ui-grid" style="margin-bottom: 24px;">
							<div class="admin-ui-field">
								<label class="admin-ui-label">เลขที่เอกสาร</label>
								<div class="admin-ui-input-wrapper">
									<input type="text" name="admin_doc_no" class="admin-ui-input" value="<?php echo ($savedSo !== null) ? so_saved_h($savedSo['iv_no'] ?? '') : ''; ?>" placeholder="No.">
								</div>
							</div>
							<div class="admin-ui-field">
								<button type="button" class="admin-ui-btn">
									<img src="img/icons/doc.png" alt="doc" style="width: 16px; height: 16px;"> Run เอกสาร
								</button>
							</div>
							<div class="admin-ui-field">
								<label class="admin-ui-label">เลขที่ลงงาน</label>
								<div class="admin-ui-input-wrapper">
									<input type="text" name="admin_work_no" class="admin-ui-input has-icon" value="<?php echo ($savedSo !== null) ? so_saved_h($savedSo['job_no'] ?? '') : ''; ?>">
									<i class="fas fa-search admin-ui-icon"></i>
								</div>
							</div>
							<div class="admin-ui-field">
								<label class="admin-ui-label">เลขที่ SR ลดหนี้</label>
								<div class="admin-ui-input-wrapper">
									<input type="text" name="admin_sr_no" class="admin-ui-input has-icon" value="<?php echo ($savedSo !== null) ? so_saved_h($savedSo['sr_no'] ?? '') : ''; ?>">
									<i class="fas fa-search admin-ui-icon"></i>
								</div>
							</div>
						</div>

						<!-- Row 2 -->
						<div class="admin-ui-grid" style="margin-bottom: 24px;">
							<div class="admin-ui-field">
								<label class="admin-ui-label">เลขที่ใบฝาก</label>
								<div class="admin-ui-input-wrapper">
									<input type="text" name="admin_deposit_no" class="admin-ui-input has-icon" value="<?php echo ($savedSo !== null) ? so_saved_h($savedSo['order_no'] ?? '') : ''; ?>">
									<i class="fas fa-search admin-ui-icon"></i>
								</div>
							</div>
							<div class="admin-ui-field">
								<label class="admin-ui-label">วันที่ออกเอกสาร</label>
								<div class="admin-ui-input-wrapper">
									<input type="text" name="admin_doc_date" class="admin-ui-input has-icon" value="<?php echo ($savedSo !== null) ? so_saved_h(so_saved_buddhist_date_input($savedSo['iv_date'] ?? '')) : ''; ?>">
									<i class="far fa-calendar-alt admin-ui-icon"></i>
								</div>
							</div>
							<div class="admin-ui-field">
								<label class="admin-ui-label">จำนวนกล่อง</label>
								<div class="admin-ui-input-wrapper">
									<input type="text" name="admin_box_count" class="admin-ui-input" value="<?php echo ($savedRegister !== null) ? so_saved_h($savedRegister['count_box'] ?? '') : ''; ?>" placeholder="Numbers only">
								</div>
							</div>
							<div class="admin-ui-field">
								<label class="admin-ui-label">จำนวนครั้งที่แก้ไขบิล</label>
								<div class="admin-ui-input-wrapper">
									<input type="text" name="admin_edit_count" class="admin-ui-input" value="<?php echo ($savedSo !== null) ? so_saved_h($savedSo['new_bill'] ?? '') : ''; ?>" placeholder="Numbers only">
								</div>
							</div>
						</div>

						<!-- Row 3 -->
						<div class="admin-ui-grid" style="margin-bottom: 24px;">
							<div class="admin-ui-field">
								<label class="admin-ui-label">วันที่ออกเอกสาร (เดิม)</label>
								<div class="admin-ui-input-wrapper">
									<input type="text" name="admin_old_doc_date" class="admin-ui-input has-icon" value="<?php echo ($savedSo !== null) ? so_saved_h(so_saved_buddhist_date_input($savedSo['date_oldbill'] ?? '')) : ''; ?>">
									<i class="far fa-calendar-alt admin-ui-icon"></i>
								</div>
							</div>
							<div class="admin-ui-field span-3">
								<label class="admin-ui-label">สาเหตุการแก้ไขบิล</label>
								<div class="admin-ui-input-wrapper">
									<input type="text" name="admin_edit_reason" class="admin-ui-input has-icon" value="<?php echo ($savedSo !== null) ? so_saved_h($savedSo['desnew_bill'] ?? '') : ''; ?>">
									<i class="fas fa-times admin-ui-icon-clickable" onclick="this.previousElementSibling.value=''"></i>
								</div>
							</div>
						</div>

						<!-- Row 4 -->
						<div class="admin-ui-grid">
							<div class="admin-ui-field">
								<button type="button" class="admin-ui-btn">
									<img src="img/icons/circle_x.png" alt="circle_x" style="width: 16px; height: 16px;"> ยกเลิกเอกสาร
								</button>
							</div>
							<div class="admin-ui-field span-3">
								<label class="admin-ui-label">หมายเหตุการยกเลิก</label>
								<div class="admin-ui-input-wrapper">
									<input type="text" name="admin_cancel_reason" class="admin-ui-input has-icon" value="<?php echo ($savedSo !== null) ? so_saved_h($savedSo['remark_cancel'] ?? '') : ''; ?>">
									<i class="fas fa-times admin-ui-icon-clickable" onclick="this.previousElementSibling.value=''"></i>
								</div>
							</div>
						</div>

					</div>

				</div>
				<!-- End TAB 2 -->

				<div class="so-card">
					<!-- Section: ข้อมูลลูกค้า -->
					<div class="so-section-title-container">
						<h2 class="so-section-title">ข้อมูลลูกค้า</h2>
						<hr class="so-divider">
					</div>

					<div class="so-customer-top-grid">
						<div class="so-customer-top-left">
							<!-- Pills Row: Add Customer & Bill Info Toggle -->
							<div class="so-customer-pills-row">
								<button type="button" class="btn-add-customer-pill" onclick="openCustomerPopup();">
									<img src="img/icons/add_user.png" alt="add_user" style="width: 23px;"> ข้อมูลลูกค้า
								</button>
								<label class="so-toggle-pill-outline-custom" id="lbl-full_bill">
									<input type="checkbox" name="full_bill" id="full_bill" value="1">
									<span><img src="img/icons/user_card.png" alt="user_card" style="width: 23px;"> ข้อมูลออกบิล</span>
								</label>
							</div>

							<!-- เลขประจำตัวผู้เสียภาษี -->
							<div class="so-field-group">
								<label class="so-label">เลขประจำตัวผู้เสียภาษี<span class="required">*</span></label>
								<div class="so-input-wrapper">
									<input type="text" name="tax_id" id="tax_id" class="so-input" placeholder="เลขประจำตัวผู้เสียภาษี..." style="padding-right: 32px;">
									<i class="fas fa-times" style="position: absolute; right: 12px; cursor: pointer; color: #8E8B94;" onclick="document.getElementById('tax_id').value=''"></i>
								</div>
							</div>
						</div>

						<div class="so-customer-top-right">
							<!-- ค้นหาลูกค้า (ข้อมูลลูกค้า) -->
							<div class="so-field-group" style="height: 100%;">
								<label class="so-label">ข้อมูลลูกค้า</label>
								<style>
									.customer-info-display-card {
										background-color: #F4F5F7;
										border-radius: 12px;
										padding: 24px;
										display: flex;
										gap: 48px;
										font-family: 'Prompt', sans-serif;
										width: 100%;
										box-sizing: border-box;
									}

									.cidc-col {
										flex: 1;
										display: flex;
										flex-direction: column;
										gap: 16px;
									}

									.cidc-row {
										display: flex;
										align-items: center;
									}

									.cidc-label {
										width: 100px;
										font-size: 14px;
										color: #6C757D;
										font-weight: 400;
									}

									.cidc-value {
										flex: 1;
										font-size: 14px;
										color: #3B3B3B;
										display: flex;
										align-items: center;
									}

									.cidc-value-input {
										background: transparent;
										border: none;
										outline: none;
										font-size: 14px;
										color: #3B3B3B;
										width: 100%;
										font-family: 'Prompt', sans-serif;
										resize: none;
										padding: 0;
										margin: 0;
									}

									.cidc-value-input.purple-text {
										color: #612989;
									}

									.cidc-value-input.underline {
										text-decoration: underline;
									}

									.cidc-display-text {
										font-size: 14px;
										color: #3B3B3B;
										font-family: 'Prompt', sans-serif;
										line-height: 24px;
										min-height: 24px;
										display: inline-block;
									}

									.cidc-status-icon {
										width: 24px;
										height: 20px;
										margin-right: 8px;
										object-fit: contain;
									}
								
</style>

								<div class="customer-info-display-card">
									<!-- Column 1 -->
									<div class="cidc-col">
										<div class="cidc-row">
											<div class="cidc-label">รหัสลูกค้า</div>
											<div class="cidc-value">
												<span id="display_bill_id" class="cidc-display-text"></span>
												<input type="hidden" name="bill_id" id="bill_id">
												<input type='hidden' name="h_bill_id" id="h_bill_id" readonly>
												<!-- billing_id เตรียมไว้สำหรับผูกกับ billing address record โดยตรง แต่ disable การใช้งานใน save flow ชั่วคราว -->
												<input type="hidden" name="billing_id" id="billing_id" value="">
												<input type="hidden" name="shipping_id" id="shipping_id" value="<?php echo isset($savedRegister['shipping_id']) ? htmlspecialchars($savedRegister['shipping_id'], ENT_QUOTES, 'UTF-8') : ''; ?>">
											</div>
										</div>
										<div class="cidc-row">
											<div class="cidc-label">เบอร์โทร</div>
											<div class="cidc-value">
												<input type="text" name="display_bill_tel" id="display_bill_tel" class="cidc-value-input" readonly placeholder="">
											</div>
										</div>
										<div class="cidc-row">
											<div class="cidc-label">สถานะลูกค้า</div>
											<div class="cidc-value">
												<img src="img/icons/vip.png" class="cidc-status-icon" id="display_vip_icon" alt="VIP" style="display: none;">
												<input type="text" id="display_mode_name" class="cidc-value-input" readonly placeholder="">
											</div>
										</div>
									</div>

									<!-- Column 2 -->
									<div class="cidc-col">
										<div class="cidc-row">
											<div class="cidc-label">ชื่อลูกค้า</div>
											<div class="cidc-value">
												<input type="text" name="display_bill_name" id="display_bill_name" class="cidc-value-input" readonly placeholder="">
											</div>
										</div>
										<div class="cidc-row">
											<div class="cidc-label">ประเภทลูกค้า</div>
											<div class="cidc-value">
												<input type="text" id="display_customer_typename" class="cidc-value-input" readonly placeholder="">
											</div>
										</div>
										<div class="cidc-row">
											<div class="cidc-label">เครดิตเทอม</div>
											<div class="cidc-value">
												<button type="button" class="credit-term-trigger is-empty" id="display_credit_thb_trigger" aria-haspopup="dialog" aria-controls="creditTermPopupModal" aria-disabled="true" disabled>
													<span id="display_credit_thb" class="credit-term-trigger-text"></span>
													<img src="img/icons/edit.png?v=20260610" class="credit-term-trigger-icon" alt="แก้ไข">
												</button>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="so-grid-3">
						<!-- คำนำหน้าชื่อ -->
						<div class="so-field-group">
							<label class="so-label">คำนำหน้าชื่อ<span class="required">*</span></label>
							<div class="so-select-wrapper">
								<select name="pre_name" id="pre_name" class="so-select">
									<option value="">Select</option>
									<option value="นาย">นาย</option>
									<option value="นาง">นาง</option>
									<option value="นางสาว">นางสาว</option>
									<option value="บริษัท">บริษัท</option>
									<option value="หจก.">หจก.</option>
								</select>
							</div>
						</div>

						<!-- ชื่อออกบิล -->
						<div class="so-field-group">
							<label class="so-label">ชื่อออกบิล<span class="required">*</span></label>
							<div class="so-input-wrapper">
								<input type='text' name="bill_name" id="bill_name" class="so-input" placeholder="ชื่อที่ต้องการออกบิล..." style="padding-right: 32px;">
								<i class="fas fa-times" style="position: absolute; right: 12px; cursor: pointer; color: #8E8B94;" onclick="document.getElementById('bill_name').value=''"></i>
							</div>
						</div>

						<!-- เบอร์โทรศัพท์ -->
						<div class="so-field-group">
							<label class="so-label">เบอร์โทรศัพท์<span class="required">*</span></label>
							<div class="so-input-wrapper">
								<input type='text' name="bill_tel" id="bill_tel" class="so-input" readonly placeholder="เบอร์โทรศัพท์..." style="padding-right: 32px;">
								<i class="fas fa-times" style="position: absolute; right: 12px; cursor: pointer; color: #8E8B94;" onclick="document.getElementById('bill_tel').value=''"></i>
							</div>
						</div>
					</div>

					<!-- ที่อยู่ออกบิล -->
					<div class="so-field-group" style="margin-bottom: 24px;">
						<label class="so-label">ที่อยู่ออกบิล<span class="required">*</span></label>
						<div class="so-input-wrapper" style="width: 100%; max-width: 1032px;">
							<input type="text" name="bill_address" id="bill_address" class="so-input" style="width: 100%; max-width: 1032px; padding-right: 32px;" readonly placeholder="ที่อยู่ที่ใช้ในการออกบิล...">
							<i class="fas fa-times" style="position: absolute; right: 12px; cursor: pointer; color: #8E8B94;" onclick="document.getElementById('bill_address').value=''"></i>
						</div>
					</div>

					<div class="so-grid-3">
						<!-- ผู้แนะนำ -->
						<div class="so-field-group">
							<label class="so-label">ผู้แนะนำ</label>
							<div class="so-input-wrapper">
								<input type="text" name="suggest" id="suggest" class="so-input" placeholder="ระบุชื่อผู้แนะนำ..." required style="padding-right: 32px;">
								<i class="fas fa-times" style="position: absolute; right: 12px; cursor: pointer; color: #8E8B94;" onclick="document.getElementById('suggest').value=''"></i>
							</div>
						</div>

						<!-- ลูกค้าซื้อซ้ำ -->
						<div class="so-field-group" style="justify-content: flex-end;">
							<div style="display: flex; align-items: center; height: 42px;">
								<label class="so-toggle-pill<?php echo so_saved_checked($savedSo, 'repeat_cus') ? ' active' : ''; ?>" id="lbl-repeat_cus">
									<input type="checkbox" name="repeat_cus" id="repeat_cus" value="1" <?php echo so_saved_checked($savedSo, 'repeat_cus') ? ' checked' : ''; ?>>
									<span>ลูกค้าซื้อซ้ำ</span>
								</label>
							</div>
						</div>
					</div>
				</div>

				<div class="so-card">
					<!-- Section: การชำระเงิน -->
					<div class="so-section-title-container">
						<h2 class="so-section-title">การชำระเงิน</h2>
						<hr class="so-divider">
					</div>

					<!-- Radio Buttons Toggle for Credit vs Cash -->
					<div class="so-payment-modes">
						<label class="so-payment-radio-label" id="lbl-pay_mode_credit">
							<input type="radio" name="pay_mode" id="pay_mode_credit" value="credit" onclick="switchPaymentMode('credit')">
							<span>เครดิต</span>
						</label>
						<label class="so-payment-radio-label" id="lbl-pay_mode_cash">
							<input type="radio" name="pay_mode" id="pay_mode_cash" value="cash" onclick="switchPaymentMode('cash')">
							<span>ชำระเงินสด</span>
						</label>
					</div>

					<!-- Hidden inputs for mapping and state -->
					<input type="hidden" id="h_credit_ckk_value" value="">
					<input type="hidden" id="h_customer_payment_mode" value="">

					<!-- Hidden actual select dropdown which is required by the form -->
					<select name="payment" id="payment" style="display:none;">
						<option value="">**Please Select Item**</option>
					</select>

					<!-- Row: Credit Fields (Only shown in Credit mode) -->
					<div class="so-grid-2" id="row-credit-fields" style="display: none;">
						<!-- จำนวนเครดิต (วัน) -->
						<div class="so-field-group">
							<label class="so-label">จำนวนเครดิต (วัน)</label>
							<input type="text" id="display_credit_days" class="so-input" readonly placeholder="30">
						</div>

						<!-- ยอดเงินเครดิต -->
						<div class="so-field-group">
							<label class="so-label">ยอดเงินเครดิต</label>
							<input type="text" id="display_credit_limit" class="so-input" readonly placeholder="0.00">
						</div>
					</div>

					<!-- Row: Cash Fields (Only shown in Cash mode) -->
					<div class="so-grid-3" id="row-cash-fields" style="display: none; margin-bottom: 24px;">
						<!-- วิธีชำระเงิน -->
						<div class="so-field-group">
							<label class="so-label">วิธีชำระเงิน</label>
							<div class="so-select-wrapper">
								<select id="payment_method" name="payment_method" class="so-select" data-saved-value="<?php echo ($savedSo !== null && isset($savedSo['payment_method'])) ? (int)$savedSo['payment_method'] : 0; ?>">
									<option value="0">เลือกวิธีชำระเงิน</option>
								</select>
							</div>
						</div>

						<!-- ช่องทางการชำระ -->
						<div class="so-field-group">
							<label class="so-label">ช่องทางการชำระ</label>
							<div class="so-select-wrapper">
								<select id="payment_cash_select" class="so-select" onchange="document.getElementById('payment').value = this.value; evaluateDebtPanel();">
									<option value="">Select</option>
								</select>
							</div>
						</div>

						<!-- หลักฐานการโอนเงิน -->
						<div class="so-field-group">
							<label class="so-label">หลักฐานการโอนเงิน</label>
							<div class="so-file-upload">
								<label for="slip_upload" class="so-input" style="display: flex; justify-content: space-between; align-items: center; cursor: pointer; color: #333333;">
									<span id="file_name_display"><?php echo ($savedSo !== null && !empty($savedSo['slip1'])) ? so_saved_h($savedSo['slip1']) : 'Choose File'; ?></span>
									<i class="far fa-image" style="color: #333333; font-size: 18px;"></i>
								</label>
								<input type="file" id="slip_upload" style="display: none;" onchange="syncSlipUploadToSlip1(this)">
							</div>
						</div>
					</div>

					<!-- รายละเอียดการชำระเงิน -->
					<div class="so-field-group" style="margin-bottom: 24px;">
						<label class="so-label">รายละเอียดการชำระเงิน</label>
						<div class="so-input-wrapper">
							<input type="text" name="payment_des" id="payment_des" class="so-input" placeholder="ระบุรายละเอียดเพิ่มเติม..." style="width: 1032px; max-width: 100%; padding-right: 32px;">
							<i class="fas fa-times" style="position: absolute; right: 12px; cursor: pointer; color: #8E8B94;" onclick="document.getElementById('payment_des').value=''"></i>
						</div>
					</div>
				</div>


				<!-- Bottom product & delivery details section -->
				<div class="so-card" style="padding: 24px;">
					<div id="pd" class="w3-container city1">

						<?php
						if ($_SESSION["department"] == 'วิศวกรรม') {
							include('product_engineer.php');
						} else {
							include('product_salehos.php');
						}
						?>

					</div>

					<!-- วงเงิน (ซ่อน/เก็บค่าเหมือนเดิม) -->
					<input type="hidden" name="credit_thb" id="credit_thb">
					<input type="hidden" name="sum_ca" id="sum_ca">
					<input type="hidden" name="sum_amount_total" id="sum_amount_total" value="0">

					<!-- พื้นที่ตารางหนี้คงค้าง -->
					<div id="debt_panel" style="margin-top:16px; display:none;">
						<h4 class="so-section-sub-title" style="color: #612989; font-size: 15px; font-weight: 600; margin-bottom: 12px;">ยอดหนี้คงค้าง</h4>
						<div id="debt_table_wrap"></div>
						<div id="credit_summary" style="margin-top:8px; font-weight:600;"></div>
					</div>

					<!-- เอกสารแนบบิล HIDDEN -->
				</div>

				<!-- NEW DELIVERY CARD -->
				<div class="so-tabs-container" style="margin-top: 24px;">
					<button type="button" class="so-tab-btn active" onclick="openDelTab('del_info', this)">ข้อมูลการจัดส่ง</button>
					<button type="button" class="so-tab-btn" onclick="openDelTab('del_cost', this)">ค่าจัดส่ง</button>
				</div>
				<div class="so-card" style="padding: 24px;">

					<!-- TAB 1: ข้อมูลการจัดส่ง -->
					<div id="del_info" class="so-del-tab-content">
						<style>
							#del_info .so-section-title-container {
								margin-bottom: 24px;
							}

							#del_info .so-section-title {
								font-size: 18px;
								color: #3B3B3B;
								font-weight: 500;
								margin: 0 0 16px 0;
								font-family: 'Prompt', sans-serif;
							}

							#del_info .so-divider {
								border: none;
								border-top: 2px solid #EDE9F0;
								margin: 0;
							}

							#del_info .so-grid-6-col {
								display: grid;
								grid-template-columns: repeat(6, 1fr);
								gap: 20px 16px;
								margin-top: 24px;
							}

							#del_info .so-field-group {
								display: flex;
								flex-direction: column;
								gap: 8px;
								margin-top: 0 !important;
							}

							#del_info .so-label {
								font-size: 14px;
								font-weight: 500;
								color: #612989 !important;
								margin: 0;
								font-family: 'Prompt', sans-serif;
							}

							#del_info .so-select-wrapper {
								position: relative;
								display: flex;
								align-items: center;
								width: 100% !important;
							}

							#del_info .so-select,
							#del_info .so-input {
								background-color: #F4F3F7 !important;
								border: none !important;
								border-radius: 8px !important;
								font-family: 'Prompt', sans-serif !important;
								font-size: 14px !important;
								color: #333333 !important;
								width: 100% !important;
								height: 42px !important;
								padding: 0 12px !important;
								box-sizing: border-box !important;
								outline: none !important;
								transition: background-color 0.2s ease !important;
							}

							#del_info .so-select:focus,
							#del_info .so-input:focus {
								background-color: #ECEAF0 !important;
							}

							#del_info .so-select {
								padding-right: 40px !important;
								appearance: none !important;
								-webkit-appearance: none !important;
								-moz-appearance: none !important;
							}

							#del_info .so-toggle-btn {
								flex: 1;
								text-align: center;
								background-color: #F4F3F7;
								border-radius: 8px;
								padding: 12px;
								cursor: pointer;
								transition: all 0.2s ease;
								display: flex;
								align-items: center;
								justify-content: center;
								height: 42px;
								box-sizing: border-box;
							}

							#del_info .so-toggle-btn span {
								color: #6e6e6eff;
								font-size: 14px;
								font-weight: 400;
								font-family: 'Prompt', sans-serif;
								transition: color 0.2s ease;
							}

							#del_info .so-toggle-btn:has(input:checked) {
								background-color: #612989 !important;
							}

							#del_info .so-toggle-btn:has(input:checked) span {
								color: #FFFFFF !important;
							}
						
</style>

						<div class="so-section-title-container">
							<h3 class="so-section-title">ข้อมูลการจัดส่ง</h3>
							<hr class="so-divider">
						</div>

						<div class="so-grid-6-col">
							<!-- วิธีการจัดส่ง -->
							<div class="so-field-group" style="grid-column: span 2;">
								<label class="so-label">วิธีการจัดส่ง<span style="color:red">*</span></label>
								<div class="so-select-wrapper">
									<select name="delivery_type" id="delivery_type" class="so-select">
										<option value="1">Sale รับเอง</option>
										<option value="2">ช่างรับเอง</option>
										<option value="3">ลูกค้ารับเอง</option>
										<option value="4">บริษัทจัดส่ง</option>
									</select>
								</div>
							</div>

							<!-- บริษัทขนส่ง -->
							<div class="so-field-group" style="grid-column: span 2;">
								<label class="so-label">บริษัทขนส่ง<span style="color:red">*</span></label>
								<div class="so-select-wrapper">
									<select name="transport_company" id="transport_company" class="so-select">
										<option value="">เลือกบริษัทขนส่ง</option>
										<option value="1">Kerry</option>
										<option value="2">Flash</option>
										<option value="3">J&T</option>
										<option value="4">ไปรษณีย์ไทย</option>
									</select>
								</div>
							</div>

							<!-- วันที่ในการจัดส่ง -->
							<div class="so-field-group" style="grid-column: span 2;">
								<label class="so-label">วันที่ในการจัดส่ง<span style="color:red">*</span></label>
								<div class="calendar-wrapper" style="width: 100%; display: flex;">
									<input name="start_date" type="date" id="start_date" class="so-input" style="padding-right: 40px;" />
								</div>
							</div>

							<!-- เลือกช่วงเวลา -->
							<div class="so-field-group" style="grid-column: span 1;">
								<label class="so-label">ช่วงเวลา</label>
								<div class="so-select-wrapper">
									<select name="time_range" id="time_range" class="so-select">
										<option value="">เลือกช่วงเวลา</option>
										<option value="morning">ช่วงเช้า</option>
										<option value="afternoon">ช่วงบ่าย</option>
										<option value="allday">ทั้งวัน</option>
										<option value="specific">กำหนดเวลา</option>
									</select>
								</div>
							</div>

							<!-- เวลาในการจัดส่ง -->
							<div class="so-field-group" style="grid-column: span 1;">
								<label class="so-label">เวลาในการจัดส่ง<span style="color:red">*</span></label>
								<div class="time-wrapper">
									<input id="start_time" name="start_time" class="so-input" type="time" value="<?php echo so_saved_h(so_saved_delivery_time_part($savedSo, $savedRegister, 0)); ?>" style="padding-right: 40px;" />
								</div>
							</div>

							<!-- ช่วงวันที่โดยประมาณ -->
							<div class="so-field-group" style="grid-column: span 4;">
								<label class="so-label">ช่วงวันที่โดยประมาณ</label>
								<div style="position: relative; display: flex; align-items: center; width: 100%;">
									<input name="between_date" class="so-input" type="text" id="between_date" placeholder="ช่วงวันที่โดยประมาณ" style="padding-right: 36px !important;" />
									<i class="fas fa-times" style="position: absolute; right: 12px; cursor: pointer; color: #8E8B94;" onclick="document.getElementById('between_date').value=''"></i>
								</div>
							</div>

							<!-- หมายเหตุสถานะเพิ่มเติม -->
							<div class="so-field-group" style="grid-column: span 6;">
								<label class="so-label">หมายเหตุสถานะเพิ่มเติม</label>
								<div style="position: relative; display: flex; align-items: center; width: 100%;">
									<input name="status_comment" type="text" id="status_comment" class="so-input" placeholder="หมายเหตุสถานะเพิ่มเติม" style="padding-right: 36px !important;" />
									<i class="fas fa-times" style="position: absolute; right: 12px; cursor: pointer; color: #8E8B94;" onclick="document.getElementById('status_comment').value=''"></i>
								</div>
							</div>
						</div>

						<div style="display: flex; gap: 16px; margin-top: 24px;">
							<label class="so-toggle-btn">
								<input type="checkbox" id="call_customer" name="call_customer" value="1" style="display:none;" <?php echo so_saved_checked($savedRegister, 'call_customer') ? ' checked' : ''; ?> onchange="this.parentElement.style.backgroundColor = this.checked ? '#612989' : '#F4F3F7'; this.nextElementSibling.style.color = this.checked ? '#FFFFFF' : '#6e6e6eff';">
								<span style="color: #6e6e6eff; font-size: 14px; font-weight: 500; font-family: 'Prompt', sans-serif;">ต้องการให้โทรแจ้ง</span>
							</label>

							<label class="so-toggle-btn">
								<input type="checkbox" name="ref_12" id="ref_12" value="1" style="display:none;" <?php echo so_saved_checked($savedOtherBill, 'ref_12') ? ' checked' : ''; ?> onchange="this.parentElement.style.backgroundColor = this.checked ? '#612989' : '#F4F3F7'; this.nextElementSibling.style.color = this.checked ? '#FFFFFF' : '#6e6e6eff';">
								<span style="color: #6e6e6eff; font-size: 14px; font-weight: 500; font-family: 'Prompt', sans-serif;">ส่งสินค้าด้วยใบรับสินค้า (ไม่ระบุราคา)</span>
							</label>
						</div>
					</div>

					<!-- TAB 2: ค่าจัดส่ง -->
					<div id="del_cost" class="so-del-tab-content" style="display:none;">
						<h3 class="so-section-title" style="font-size: 18px; color: #3B3B3B; margin-bottom: 24px;">ค่าจัดส่ง</h3>

						<div class="so-grid-3">
							<div class="so-field-group">
								<label class="so-label" style="color: #612989;">วันที่คีย์ค่าส่ง</label>
								<div style="position: relative; display: flex; align-items: center;">
									<input name="shipping_date" type="date" id="shipping_date" class="so-input" style="background-color: #F4F3F7; border:none; border-radius: 8px; width: 100%; font-family: 'Prompt', sans-serif; height: 42px;" />
								</div>
							</div>

							<div class="so-field-group">
								<label class="so-label" style="color: #612989;">รหัสอ้างอิง 1</label>
								<div style="position: relative; display: flex; align-items: center;">
									<input name="shipping_ref1" type="text" id="shipping_ref1" class="so-input" placeholder="" style="background-color: #F4F3F7; border:none; border-radius: 8px; width: 100%; padding-right: 32px; font-family: 'Prompt', sans-serif;" />
									<i class="fas fa-times" style="position: absolute; right: 12px; cursor: pointer; color: #8E8B94;" onclick="document.getElementById('shipping_ref1').value=''"></i>
								</div>
							</div>

							<div class="so-field-group">
								<label class="so-label" style="color: #612989;">รหัสอ้างอิง 2</label>
								<div style="position: relative; display: flex; align-items: center;">
									<input name="shipping_ref2" type="text" id="shipping_ref2" class="so-input" placeholder="" style="background-color: #F4F3F7; border:none; border-radius: 8px; width: 100%; padding-right: 32px; font-family: 'Prompt', sans-serif;" />
									<i class="fas fa-times" style="position: absolute; right: 12px; cursor: pointer; color: #8E8B94;" onclick="document.getElementById('shipping_ref2').value=''"></i>
								</div>
							</div>
						</div>

						<div class="so-grid-3" style="margin-top: 16px;">
							<div class="so-field-group">
								<label class="so-label" style="color: #612989;">ค่าจัดส่ง</label>
								<input name="shipping_cost" type="text" id="shipping_cost" class="so-input" value="0.00" style="background-color: #F4F3F7; border:none; border-radius: 8px; width: 100%; font-family: 'Prompt', sans-serif;" />
							</div>
						</div>
					</div>
				</div>
				<!-- NEW DELIVERY CARD END -->

				<!-- NEW ADDRESS CARD -->
				<div class="so-tabs-container" style="margin-top: 24px;">
					<button type="button" class="so-tab-btn active" onclick="openAddrTab('addr_main', this)">ที่อยู่</button>
					<button type="button" class="so-tab-btn" onclick="openAddrTab('addr_detail', this)">รายละเอียดที่อยู่</button>
					<button type="button" class="so-tab-btn" onclick="openAddrTab('addr_extra', this)">ที่อยู่เพิ่มเติม</button>
				</div>
				<div class="so-card" style="padding: 24px;">

					<!-- TAB 1: ที่อยู่ -->
					<div id="addr_main" class="so-addr-tab-content">
						<h3 class="so-section-title" style="font-size: 18px; color: #3B3B3B; margin-bottom: 24px;">ที่อยู่จัดส่ง</h3>
						<hr style="border: 0; border-top: 1px solid #EBEBEB; margin-bottom: 24px;">

						<div class="so-address-actions" style="display: flex; gap: 16px; margin-bottom: 24px;">
							<button type="button" class="so-address-action-btn so-address-action-btn-primary" onclick="openShippingAddressPopup()" style="background-color: #F4E8FF; color: #612989; border: none; border-radius: 24px; padding: 10px 24px; font-family: 'Prompt', sans-serif; font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 8px;">
								<i class="fas fa-search"></i> ค้นหาที่อยู่
							</button>
							<input type="hidden" name="save_to_customer_db" id="save_to_customer_db" value="0">
							<button type="button" class="so-address-action-btn so-address-action-btn-secondary" onclick="toggleSaveToCustomerDb(this)" style="background-color: #FFFFFF; color: #612989; border: 1px solid #EBEBEB; border-radius: 24px; padding: 10px 24px; font-family: 'Prompt', sans-serif; font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 8px;">
								<img src="img/icons/database.png" alt="database" style="width: 16px; height: 16px;"> เพิ่มลงฐานลูกค้า
							</button>
						</div>

						<div class="so-grid-3">
							<div class="so-field-group">
								<label class="so-label" style="color: #612989;">ชื่อผู้ติดต่อ<span style="color:red">*</span></label>
								<div style="position: relative; display: flex; align-items: center;">
									<input name="contact_name" type="text" class="so-input" value="<?php echo so_saved_h($savedSo['delivery_contact'] ?? ($savedRegister['customer_name'] ?? '')); ?>" placeholder="ใส่ชื่อผู้ติดต่อ" style="background-color: #F4F3F7; border:none; border-radius: 8px; width: 100%; padding-right: 32px;" />
									<i class="fas fa-times" style="position: absolute; right: 12px; cursor: pointer; color: #8E8B94;" onclick="this.previousElementSibling.value=''"></i>
								</div>
							</div>
							<div class="so-field-group">
								<label class="so-label" style="color: #612989;">เบอร์โทร<span style="color:red">*</span></label>
								<input name="contact_tel" type="text" class="so-input" value="<?php echo so_saved_h($savedSo['delivery_tel'] ?? ($savedRegister['customer_tel'] ?? '')); ?>" placeholder="ใส่เฉพาะตัวเลข" style="background-color: #F4F3F7; border:none; border-radius: 8px; width: 100%;" />
							</div>
							<div class="so-field-group">
								<label class="so-label" style="color: #612989;">จังหวัด<span style="color:red">*</span></label>
								<div class="so-select-wrapper">
									<select name="contact_province" class="so-select" style="background-color: #F4F3F7; border:none; border-radius: 8px;">
										<option value="">เลือกจังหวัด</option>
										<?php
										$strSQL_prov_main = "select * from tb_province order by province_ID ";
										$objQuery_prov_main = mysqli_query($conn, $strSQL_prov_main);
										if ($objQuery_prov_main) {
											$selectedProvinceMain = (string)($savedSo['province_name'] ?? ($savedRegister['province_name'] ?? ''));
											while ($objResuut_prov_main = mysqli_fetch_array($objQuery_prov_main, MYSQLI_ASSOC)) {
												$provName = (string)$objResuut_prov_main['province_name'];
												$isSelectedMain = ($provName === $selectedProvinceMain) ? ' selected' : '';
										?>
												<option value="<?php echo so_saved_h($provName); ?>" <?php echo $isSelectedMain; ?>><?php echo so_saved_h($provName); ?></option>
										<?php
											}
										}
										?>
									</select>
								</div>
							</div>
						</div>

						<div class="so-field-group" style="margin-top: 16px;">
							<label class="so-label" style="color: #612989;">ที่อยู่ในการส่งสินค้า<span style="color:red">*</span></label>
							<div style="position: relative; display: flex; align-items: center;">
								<input name="shipping_address" type="text" class="so-input" value="<?php echo so_saved_h($savedSo['delivery_address'] ?? ($savedRegister['address_name'] ?? '')); ?>" placeholder="ใส่ที่อยู่ส่งสินค้า" style="background-color: #F4F3F7; border:none; border-radius: 8px; width: 100%; padding-right: 32px;" />
								<i class="fas fa-times" style="position: absolute; right: 12px; cursor: pointer; color: #8E8B94;" onclick="this.previousElementSibling.value=''"></i>
							</div>
						</div>

						<div class="so-field-group" style="margin-top: 16px;">
							<label class="so-label" style="color: #612989;">สถานที่ติดตั้งเครื่อง<span style="color:red">*</span></label>
							<div style="position: relative; display: flex; align-items: center;">
								<input name="install_location" id="install_location" type="text" class="so-input" value="<?php echo ($savedSo !== null) ? so_saved_h($savedSo['install_place'] ?? '') : ''; ?>" placeholder="ใส่ที่ติดตั้งเครื่อง" style="background-color: #F4F3F7; border:none; border-radius: 8px; width: 100%; padding-right: 32px;" />
								<i class="fas fa-times" style="position: absolute; right: 12px; cursor: pointer; color: #8E8B94;" onclick="this.previousElementSibling.value=''"></i>
							</div>
						</div>
					</div>

					<!-- TAB 2: ที่อยู่เพิ่มเติม -->
					<div id="addr_extra" class="so-addr-tab-content" style="display:none;">
						<div id="extra_address_list">
							<div class="extra-addr-row" data-index="1">
								<h3 class="so-section-title extra-addr-title" style="font-size: 18px; color: #3B3B3B; margin-bottom: 24px;">ที่อยู่เพิ่มเติม 1</h3>
								<hr style="border: 0; border-top: 1px solid #EBEBEB; margin-bottom: 24px;">

								<div class="so-grid-3">
									<div class="so-field-group">
										<label class="so-label extra-contact-name-label" style="color: #612989;">ชื่อผู้ติดต่อ (เพิ่มเติม1)</label>
										<div style="position: relative; display: flex; align-items: center;">
											<input name="extra_contact_name_1" type="text" class="so-input" value="<?php echo so_saved_h($savedFirstExtraAddress['contact_name']); ?>" placeholder="ชื่อผู้ติดต่อ" style="background-color: #F4F3F7; border:none; border-radius: 8px; width: 100%; padding-right: 32px;" />
											<i class="fas fa-times" style="position: absolute; right: 12px; cursor: pointer; color: #8E8B94;" onclick="this.previousElementSibling.value=''"></i>
										</div>
									</div>
									<div class="so-field-group">
										<label class="so-label extra-contact-tel-label" style="color: #612989;">เบอร์โทร (เพิ่มเติม1)</label>
										<div style="position: relative; display: flex; align-items: center;">
											<input name="extra_contact_tel_1" type="text" class="so-input" value="<?php echo so_saved_h($savedFirstExtraAddress['telephone']); ?>" placeholder="เบอร์โทร" style="background-color: #F4F3F7; border:none; border-radius: 8px; width: 100%; padding-right: 32px;" />
											<i class="fas fa-times" style="position: absolute; right: 12px; cursor: pointer; color: #8E8B94;" onclick="this.previousElementSibling.value=''"></i>
										</div>
									</div>
									<div class="so-field-group">
										<label class="so-label" style="color: #612989;">จังหวัด</label>
										<div class="so-select-wrapper">
											<select name="extra_contact_province_1" class="so-select" style="background-color: #F4F3F7; border:none; border-radius: 8px;">
												<option value="">เลือกจังหวัด</option>
												<?php
												$strSQL_prov_extra = "select * from tb_province order by province_ID ";
												$objQuery_prov_extra = mysqli_query($conn, $strSQL_prov_extra);
												if ($objQuery_prov_extra) {
													while ($objResuut_prov_extra = mysqli_fetch_array($objQuery_prov_extra, MYSQLI_ASSOC)) {
														$extraProvinceName = (string)$objResuut_prov_extra['province_name'];
														$extraProvinceSelected = $extraProvinceName === (string)$savedFirstExtraAddress['province'] ? ' selected' : '';
												?>
														<option value="<?php echo so_saved_h($extraProvinceName); ?>" <?php echo $extraProvinceSelected; ?>><?php echo so_saved_h($extraProvinceName); ?></option>
												<?php
													}
												}
												?>
											</select>
										</div>
									</div>
								</div>

								<div style="display: flex; gap: 16px; margin-top: 16px; align-items: flex-end; margin-bottom: 24px;">
									<div class="so-field-group" style="flex: 1;">
										<label class="so-label extra-shipping-address-label" style="color: #612989;">ที่อยู่ส่งสินค้า (เพิ่มเติม1)</label>
										<div style="position: relative; display: flex; align-items: center;">
											<input name="extra_shipping_address_1" type="text" class="so-input" value="<?php echo so_saved_h($savedFirstExtraAddress['address']); ?>" placeholder="ที่อยู่ส่งสินค้า" style="background-color: #F4F3F7; border:none; border-radius: 8px; width: 100%; padding-right: 32px;" />
											<i class="fas fa-times" style="position: absolute; right: 12px; cursor: pointer; color: #8E8B94;" onclick="this.previousElementSibling.value=''"></i>
										</div>
									</div>
									<button type="button" onclick="removeExtraAddress(this)" style="background-color: #FFFFFF; color: #DC3545; border: 1px solid #EBEBEB; border-radius: 24px; padding: 0 24px; height: 42px; font-family: 'Prompt', sans-serif; font-weight: 500; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px;">
										<i class="far fa-trash-alt"></i> ลบที่อยู่
									</button>
								</div>
							</div>
						</div>

						<div style="margin-top: 24px; display: flex; gap: 16px; align-items: center; flex-wrap: wrap;">
							<button type="button" onclick="addExtraAddress()" style="background-color: #F4E8FF; color: #612989; border: none; border-radius: 24px; padding: 10px 24px; font-family: 'Prompt', sans-serif; font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 8px;">
								<img src="img/icons/add_address.png" alt="add_address" style="width: 16px; height: 16px;"> เพิ่มที่อยู่
							</button>
							<button type="button" onclick="toggleDeliveryPrintPanel()" style="background-color: #FFFFFF; color: #612989; border: 1px solid #EBEBEB; border-radius: 24px; padding: 10px 24px; font-family: 'Prompt', sans-serif; font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 8px;">
								<img src="img/icons/print.png" alt="print" style="width: 16px; height: 16px; object-fit: contain;"> พิมพ์ใบปะ
							</button>
						</div>

						<div id="delivery_print_panel" style="display:none; margin-top: 20px; border: 1px solid #EBEBEB; border-radius: 12px; padding: 18px; background-color: #FCFBFD;">
							<div style="display: flex; justify-content: space-between; gap: 12px; align-items: center; flex-wrap: wrap;">
								<h3 class="so-section-title" style="font-size: 18px; color: #3B3B3B; margin: 0;">ชุดพิมพ์ใบปะหน้า</h3>
								<span style="font-size: 13px; color: #7A6F85;">
									<?php echo $printCoverRefId !== '' ? 'เลขที่อ้างอิง: ' . so_saved_h($printCoverRefId) : 'ยังไม่มี ref_id สำหรับพิมพ์'; ?>
								</span>
							</div>
							<p style="margin: 10px 0 0; font-size: 13px; line-height: 1.6; color: #6C6772;">
								การพิมพ์ใบปะหน้าใช้ข้อมูลจากฐานข้อมูลที่บันทึกแล้ว หากเพิ่งแก้ไขที่อยู่เพิ่มเติมหรือที่อยู่ส่งบิล กรุณากดบันทึกก่อนพิมพ์
							</p>

							<div style="margin-top: 18px;">
								<h4 style="margin: 0 0 12px; font-size: 15px; color: #3B3B3B;">ใบปะหน้ากล่องหลัก</h4>
								<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 10px;">
									<?php foreach ($coverSheetMainReports as $reportConfig) { ?>
										<button type="button" onclick="openDeliveryPrintReport('<?php echo htmlspecialchars($reportConfig['file'], ENT_QUOTES, 'UTF-8'); ?>')" style="background-color: #FFFFFF; color: #612989; border: 1px solid #E5D8EF; border-radius: 10px; padding: 11px 14px; font-family: 'Prompt', sans-serif; font-size: 14px; font-weight: 500; cursor: pointer; text-align: center;">
											<?php echo htmlspecialchars($reportConfig['label'], ENT_QUOTES, 'UTF-8'); ?>
										</button>
									<?php } ?>
								</div>
							</div>

							<div style="margin-top: 18px;">
								<h4 style="margin: 0 0 12px; font-size: 15px; color: #3B3B3B;">ใบปะหน้าที่อยู่เพิ่มเติม</h4>
								<div id="delivery_print_extra_groups" style="display: flex; flex-direction: column; gap: 14px;"></div>
							</div>
						</div>

						<div style="margin-top: 28px;">
							<h3 class="so-section-title" style="font-size: 18px; color: #3B3B3B; margin-bottom: 12px;">ที่อยู่ส่งบิล</h3>
							<hr style="border: 0; border-top: 1px solid #EBEBEB; margin-bottom: 18px;">

							<div class="so-grid-3">
								<div class="so-field-group">
									<label class="so-label" style="color: #612989;">ชื่อผู้ติดต่อ</label>
									<div style="position: relative; display: flex; align-items: center;">
										<input name="bill_extra_contact_name_2" type="text" class="so-input" placeholder="ชื่อผู้ติดต่อ" value="<?php echo so_saved_h($savedDeliveryBillAddress['contact_name']); ?>" style="background-color: #F4F3F7; border:none; border-radius: 8px; width: 100%; padding-right: 32px;" />
										<i class="fas fa-times" style="position: absolute; right: 12px; cursor: pointer; color: #8E8B94;" onclick="this.previousElementSibling.value=''"></i>
									</div>
								</div>
								<div class="so-field-group">
									<label class="so-label" style="color: #612989;">เบอร์โทร</label>
									<div style="position: relative; display: flex; align-items: center;">
										<input name="bill_extra_contact_tel_2" type="text" class="so-input" placeholder="เบอร์โทร" value="<?php echo so_saved_h($savedDeliveryBillAddress['telephone']); ?>" style="background-color: #F4F3F7; border:none; border-radius: 8px; width: 100%; padding-right: 32px;" />
										<i class="fas fa-times" style="position: absolute; right: 12px; cursor: pointer; color: #8E8B94;" onclick="this.previousElementSibling.value=''"></i>
									</div>
								</div>
								<div class="so-field-group">
									<label class="so-label" style="color: #612989;">จังหวัด</label>
									<div class="so-select-wrapper">
										<select name="bill_extra_contact_province_2" class="so-select" style="background-color: #F4F3F7; border:none; border-radius: 8px;">
											<option value="">เลือกจังหวัด</option>
											<?php
											$strSQL_prov_bill_extra = "select * from tb_province order by province_ID ";
											$objQuery_prov_bill_extra = mysqli_query($conn, $strSQL_prov_bill_extra);
											if ($objQuery_prov_bill_extra) {
												while ($objResuut_prov_bill_extra = mysqli_fetch_array($objQuery_prov_bill_extra, MYSQLI_ASSOC)) {
													$billExtraProvinceName = (string)$objResuut_prov_bill_extra['province_name'];
													$billExtraProvinceSelected = $billExtraProvinceName === $savedDeliveryBillAddress['province'] ? ' selected' : '';
											?>
													<option value="<?php echo so_saved_h($billExtraProvinceName); ?>" <?php echo $billExtraProvinceSelected; ?>><?php echo so_saved_h($billExtraProvinceName); ?></option>
											<?php
												}
											}
											?>
										</select>
									</div>
								</div>
							</div>

							<div style="display: flex; gap: 20px; margin-top: 16px; align-items: flex-end;">
								<div class="so-field-group" style="flex: 1;">
									<label class="so-label" style="color: #612989;">ที่อยู่ส่งสินค้า</label>
									<div style="position: relative; display: flex; align-items: center;">
										<input name="bill_extra_shipping_address_2" type="text" class="so-input" placeholder="ที่อยู่ส่งสินค้า" value="<?php echo so_saved_h($savedDeliveryBillAddress['address']); ?>" style="background-color: #F4F3F7; border:none; border-radius: 8px; width: 100%; padding-right: 32px;" />
										<i class="fas fa-times" style="position: absolute; right: 12px; cursor: pointer; color: #8E8B94;" onclick="this.previousElementSibling.value=''"></i>
									</div>
								</div>
								<button type="button" onclick="toggleBillDeliveryPrintPanel()" style="background-color: #FFFFFF; color: #612989; border: 1px solid #EBEBEB; border-radius: 24px; padding: 10px 24px; height: 42px; min-width: 146px; font-family: 'Prompt', sans-serif; font-weight: 500; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px;">
									<img src="img/icons/print.png" alt="print" style="width: 16px; height: 16px; object-fit: contain;"> พิมพ์
								</button>
							</div>

							<div id="bill_delivery_print_panel" style="display:none; margin-top: 18px; border: 1px solid #EBEBEB; border-radius: 12px; padding: 18px; background-color: #FCFBFD;">
								<div style="display: flex; justify-content: space-between; gap: 12px; align-items: center; flex-wrap: wrap;">
									<h3 class="so-section-title" style="font-size: 18px; color: #3B3B3B; margin: 0;">ชุดพิมพ์ใบปะจัดส่งบิล</h3>
									<span style="font-size: 13px; color: #7A6F85;">
										<?php echo $printCoverRefId !== '' ? 'เลขที่อ้างอิง: ' . so_saved_h($printCoverRefId) : 'ยังไม่มี ref_id สำหรับพิมพ์'; ?>
									</span>
								</div>
								<p style="margin: 10px 0 0; font-size: 13px; line-height: 1.6; color: #6C6772;">
									ใบปะจัดส่งบิลมีรายการเดียว โดยดึงข้อมูลจากเอกสารที่บันทึกแล้ว
								</p>
								<div style="margin-top: 18px; display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 10px;">
									<?php foreach ($billDeliveryReports as $reportConfig) { ?>
										<button type="button" onclick="openBillDeliveryPrintReport('<?php echo htmlspecialchars($reportConfig['file'], ENT_QUOTES, 'UTF-8'); ?>')" style="background-color: #FFFFFF; color: #612989; border: 1px solid #E5D8EF; border-radius: 10px; padding: 11px 14px; font-family: 'Prompt', sans-serif; font-size: 14px; font-weight: 500; cursor: pointer; text-align: center;">
											<?php echo htmlspecialchars($reportConfig['label'], ENT_QUOTES, 'UTF-8'); ?>
										</button>
									<?php } ?>
								</div>
							</div>
						</div>

						<script>
							const deliveryPrintRefId = <?php echo json_encode($printCoverRefId, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>;
							const deliveryPrintCanOpen = <?php echo $printCoverRefId !== '' ? 'true' : 'false'; ?>;
							const deliveryPrintExtraReports = <?php echo json_encode($coverSheetExtraReports, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>;

							function getExtraAddressRowCount() {
								return Math.min(document.querySelectorAll('#extra_address_list .extra-addr-row').length, 9);
							}

							function toggleDeliveryPrintPanel() {
								const panel = document.getElementById('delivery_print_panel');
								if (!panel) {
									return;
								}

								const shouldShow = panel.style.display === 'none' || panel.style.display === '';
								panel.style.display = shouldShow ? 'block' : 'none';
								if (shouldShow) {
									renderDeliveryPrintExtraGroups();
								}
							}

							function openDeliveryPrintReport(fileName) {
								if (!deliveryPrintCanOpen || !deliveryPrintRefId) {
									const message = 'กรุณาบันทึกใบสั่งขายก่อนพิมพ์ใบปะหน้า เพื่อให้ระบบมี ref_id และข้อมูลล่าสุดสำหรับรายงาน';
									if (typeof Swal !== 'undefined') {
										Swal.fire({
											icon: 'info',
											title: 'ยังพิมพ์ไม่ได้',
											text: message,
											confirmButtonColor: '#612989'
										});
									} else {
										alert(message);
									}
									return;
								}

								window.open(fileName + '?ref_id=' + encodeURIComponent(deliveryPrintRefId), '_blank');
							}

							function renderDeliveryPrintExtraGroups() {
								const container = document.getElementById('delivery_print_extra_groups');
								if (!container) {
									return;
								}

								const rowCount = getExtraAddressRowCount();
								container.innerHTML = '';

								if (rowCount === 0) {
									container.innerHTML = '<div style="font-size: 13px; color: #7A6F85;">ยังไม่มีรายการที่อยู่เพิ่มเติม</div>';
									return;
								}

								for (let index = 1; index <= rowCount; index++) {
									const group = document.createElement('div');
									group.style.border = '1px solid #EFE7F5';
									group.style.borderRadius = '10px';
									group.style.padding = '14px';
									group.style.backgroundColor = '#FFFFFF';

									const title = document.createElement('div');
									title.textContent = 'ที่อยู่เพิ่มเติม ' + index;
									title.style.fontSize = '14px';
									title.style.fontWeight = '600';
									title.style.color = '#3B3B3B';
									title.style.marginBottom = '10px';
									group.appendChild(title);

									const buttonWrap = document.createElement('div');
									buttonWrap.style.display = 'grid';
									buttonWrap.style.gridTemplateColumns = 'repeat(auto-fit, minmax(120px, 1fr))';
									buttonWrap.style.gap = '10px';

									deliveryPrintExtraReports.forEach(function(reportConfig) {
										const button = document.createElement('button');
										button.type = 'button';
										button.textContent = reportConfig.label;
										button.style.backgroundColor = '#FFFFFF';
										button.style.color = '#612989';
										button.style.border = '1px solid #E5D8EF';
										button.style.borderRadius = '10px';
										button.style.padding = '11px 14px';
										button.style.fontFamily = "'Prompt', sans-serif";
										button.style.fontSize = '14px';
										button.style.fontWeight = '500';
										button.style.cursor = 'pointer';
										button.onclick = function() {
											openDeliveryPrintReport(reportConfig.file_pattern.replace('%s', index));
										};
										buttonWrap.appendChild(button);
									});

									group.appendChild(buttonWrap);
									container.appendChild(group);
								}
							}

							function toggleBillDeliveryPrintPanel() {
								const panel = document.getElementById('bill_delivery_print_panel');
								if (!panel) {
									return;
								}

								panel.style.display = (panel.style.display === 'none' || panel.style.display === '') ? 'block' : 'none';
							}

							function openBillDeliveryPrintReport(fileName) {
								if (!deliveryPrintCanOpen || !deliveryPrintRefId) {
									const message = 'กรุณาบันทึกใบสั่งขายก่อนพิมพ์ใบปะจัดส่งบิล เพื่อให้ระบบมี ref_id และข้อมูลล่าสุดสำหรับรายงาน';
									if (typeof Swal !== 'undefined') {
										Swal.fire({
											icon: 'info',
											title: 'ยังพิมพ์ไม่ได้',
											text: message,
											confirmButtonColor: '#612989'
										});
									} else {
										alert(message);
									}
									return;
								}

								window.open(fileName + '?ref_id=' + encodeURIComponent(deliveryPrintRefId), '_blank');
							}

							function addExtraAddress() {
								const list = document.getElementById('extra_address_list');
								const template = list.querySelector('.extra-addr-row').cloneNode(true);

								// Clear inputs in cloned node
								template.querySelectorAll('input').forEach(input => input.value = '');
								template.querySelectorAll('select').forEach(select => select.selectedIndex = 0);

								list.appendChild(template);
								updateExtraAddressIndices();
							}

							function removeExtraAddress(btn) {
								const list = document.getElementById('extra_address_list');
								if (list.querySelectorAll('.extra-addr-row').length > 1) {
									btn.closest('.extra-addr-row').remove();
									updateExtraAddressIndices();
								} else {
									alert('ต้องมีที่อยู่เพิ่มเติมอย่างน้อย 1 รายการ หรือถ้าไม่ต้องการใช้ ให้เว้นว่างข้อมูลไว้ครับ');
								}
							}

							function updateExtraAddressIndices() {
								const rows = document.querySelectorAll('.extra-addr-row');
								rows.forEach((row, index) => {
									const displayIndex = index + 1;
									row.setAttribute('data-index', displayIndex);
									row.querySelector('.extra-addr-title').innerHTML = 'ที่อยู่เพิ่มเติม ' + displayIndex;
									row.querySelector('.extra-contact-name-label').innerHTML = 'ชื่อผู้ติดต่อ (เพิ่มเติม' + displayIndex + ')';
									row.querySelector('.extra-contact-tel-label').innerHTML = 'เบอร์โทร (เพิ่มเติม' + displayIndex + ')';
									row.querySelector('.extra-shipping-address-label').innerHTML = 'ที่อยู่ส่งสินค้า (เพิ่มเติม' + displayIndex + ')';

									// Update input names dynamically
									const contactName = row.querySelector('input[name^="extra_contact_name"]');
									if (contactName) contactName.name = 'extra_contact_name_' + displayIndex;

									const contactTel = row.querySelector('input[name^="extra_contact_tel"]');
									if (contactTel) contactTel.name = 'extra_contact_tel_' + displayIndex;

									const contactProvince = row.querySelector('select[name^="extra_contact_province"]');
									if (contactProvince) contactProvince.name = 'extra_contact_province_' + displayIndex;

									const shippingAddress = row.querySelector('input[name^="extra_shipping_address"]');
									if (shippingAddress) shippingAddress.name = 'extra_shipping_address_' + displayIndex;
								});

								renderDeliveryPrintExtraGroups();
							}

							(function restoreRenderedExtraAddresses() {
								const savedExtraAddressRows = <?php echo json_encode($savedExtraAddressRows, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>;
								if (!Array.isArray(savedExtraAddressRows) || savedExtraAddressRows.length === 0) {
									return;
								}

								const list = document.getElementById('extra_address_list');
								if (!list) {
									return;
								}

								while (list.querySelectorAll('.extra-addr-row').length < savedExtraAddressRows.length) {
									addExtraAddress();
								}

								savedExtraAddressRows.forEach((item, index) => {
									const displayIndex = index + 1;
									const nameInput = document.querySelector('input[name="extra_contact_name_' + displayIndex + '"]');
									const telInput = document.querySelector('input[name="extra_contact_tel_' + displayIndex + '"]');
									const provinceInput = document.querySelector('select[name="extra_contact_province_' + displayIndex + '"]');
									const addressInput = document.querySelector('input[name="extra_shipping_address_' + displayIndex + '"]');

									if (nameInput) nameInput.value = item.contact_name || '';
									if (telInput) telInput.value = item.telephone || '';
									if (provinceInput) provinceInput.value = item.province || '';
									if (addressInput) addressInput.value = item.address || '';
								});

								renderDeliveryPrintExtraGroups();
							})();
						</script>
					</div>

					<!-- TAB 3: รายละเอียดที่อยู่ -->
					<div id="addr_detail" class="so-addr-tab-content" style="display:none;">
						<h3 class="so-section-title" style="font-size: 18px; color: #3B3B3B; margin-bottom: 24px;">รายละเอียดที่อยู่</h3>
						<hr style="border: 0; border-top: 1px solid #EBEBEB; margin-bottom: 24px;">

						<div class="so-grid-3" style="align-items: end;">
							<div class="so-field-group">
								<label class="so-label" style="color: #612989;">จอดรถหน้าบ้าน</label>
								<div style="display: flex; gap: 16px; height: 42px; align-items: center;">
									<label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-family: 'Prompt', sans-serif; font-size: 14px; color: #333; font-weight: 500;">
										<input type="radio" name="park_front" value="1" checked style="accent-color: #612989; width: 18px; height: 18px;"> ได้
									</label>
									<label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-family: 'Prompt', sans-serif; font-size: 14px; color: #333; font-weight: 500;">
										<input type="radio" name="park_front" value="0" style="accent-color: #612989; width: 18px; height: 18px;"> ไม่ได้
									</label>
								</div>
							</div>
							<div class="so-field-group">
								<label class="so-label" style="color: #612989;">สถานที่จอดรถ</label>
								<input name="park_location" type="text" class="so-input" placeholder="สถานที่จอดรถ" style="background-color: #F4F3F7; border:none; border-radius: 8px; width: 100%;" />
							</div>
							<div class="so-field-group">
								<label style="cursor: pointer; display: block;">
									<input type="checkbox" name="is_high_roof" value="1" style="display: none;" <?php echo so_saved_checked($savedTransaction, 'height_ltd') ? ' checked' : ''; ?> onchange="this.nextElementSibling.style.backgroundColor = this.checked ? '#612989' : '#F4F3F7'; this.nextElementSibling.style.color = this.checked ? 'white' : '#6e6e6e';">
									<div style="background-color: <?php echo so_saved_checked($savedTransaction, 'height_ltd') ? '#612989' : '#F4F3F7'; ?>; border-radius: 8px; padding: 10px; display: flex; align-items: center; justify-content: center; color: <?php echo so_saved_checked($savedTransaction, 'height_ltd') ? 'white' : '#6e6e6e'; ?>; font-size: 14px; font-family: 'Prompt', sans-serif; height: 42px; transition: all 0.2s; user-select: none;">รถหลังคาสูงเข้าได้</div>
								</label>
							</div>
						</div>

						<div class="so-grid-3" style="margin-top: 16px;">
							<div class="so-field-group">
								<label class="so-label" style="color: #612989;">ทางเข้าบ้าน</label>
								<div style="display: flex; gap: 16px; height: 42px; align-items: center;">
									<label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-family: 'Prompt', sans-serif; font-size: 14px; color: #333; font-weight: 500;">
										<input type="radio" name="entrance_type" value="1" checked style="accent-color: #612989; width: 18px; height: 18px;"> ทางราบ
									</label>
									<label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-family: 'Prompt', sans-serif; font-size: 14px; color: #333; font-weight: 500;">
										<input type="radio" name="entrance_type" value="2" style="accent-color: #612989; width: 18px; height: 18px;"> บันไดก่อนเข้าบ้าน
									</label>
								</div>
							</div>
							<div class="so-field-group">
								<label class="so-label" style="color: #612989;">จำนวนขั้นบันได</label>
								<input name="stair_count" type="text" class="so-input" placeholder="ใส่เฉพาะตัวเลข" style="background-color: #F4F3F7; border:none; border-radius: 8px; width: 100%;" />
							</div>
							<div class="so-field-group">
								<label class="so-label" style="color: #612989;">ชั้นที่ติดตั้ง</label>
								<input name="install_floor" type="text" class="so-input" placeholder="ใส่เฉพาะตัวเลข" style="background-color: #F4F3F7; border:none; border-radius: 8px; width: 100%;" />
							</div>
						</div>

						<div class="so-grid-3" style="margin-top: 16px;">
							<div class="so-field-group" style="min-width: 0;">
								<label class="so-label" style="color: #612989;">ห้องที่ติดตั้ง</label>
								<div style="display: flex; gap: 16px; height: 42px; align-items: center;">
									<label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-family: 'Prompt', sans-serif; font-size: 14px; color: #333; font-weight: 500;">
										<input type="radio" name="room_type" value="1" checked style="accent-color: #612989; width: 18px; height: 18px;"> ห้องโถง
									</label>
									<label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-family: 'Prompt', sans-serif; font-size: 14px; color: #333; font-weight: 500;">
										<input type="radio" name="room_type" value="2" style="accent-color: #612989; width: 18px; height: 18px;"> ห้องนอน
									</label>
								</div>
							</div>
							<div class="so-field-group" style="min-width: 0;">
								<label class="so-label" style="color: #612989;">ขนาดประตูห้อง</label>
								<div style="display: flex; gap: 16px;">
									<input name="door_width" type="text" class="so-input" placeholder="ความกว้าง (ซม.)" style="background-color: #F4F3F7; border:none; border-radius: 8px; flex: 1; min-width: 0;" />
									<input name="door_height" type="text" class="so-input" placeholder="ความสูง (ซม.)" style="background-color: #F4F3F7; border:none; border-radius: 8px; flex: 1; min-width: 0;" />
								</div>
							</div>
							<div class="so-field-group" style="min-width: 0;">
								<label class="so-label" style="color: #612989;">ขนาดบันได</label>
								<div style="display: flex; gap: 16px;">
									<input name="stair_width" type="text" class="so-input" placeholder="ความกว้าง (ซม.)" style="background-color: #F4F3F7; border:none; border-radius: 8px; flex: 1; min-width: 0;" />
									<input name="stair_height" type="text" class="so-input" placeholder="ความสูง (ซม.)" style="background-color: #F4F3F7; border:none; border-radius: 8px; flex: 1; min-width: 0;" />
								</div>
							</div>
						</div>

						<div class="so-grid-3" style="margin-top: 16px;">
							<div class="so-field-group" style="min-width: 0;">
								<label class="so-label" style="color: #612989;">ประตูลิฟต์</label>
								<div style="display: flex; gap: 16px;">
									<input name="elev_door_width" type="text" class="so-input" placeholder="ความกว้าง (ซม.)" style="background-color: #F4F3F7; border:none; border-radius: 8px; flex: 1; min-width: 0;" />
									<input name="elev_door_height" type="text" class="so-input" placeholder="ความสูง (ซม.)" style="background-color: #F4F3F7; border:none; border-radius: 8px; flex: 1; min-width: 0;" />
								</div>
							</div>
							<div class="so-field-group" style="grid-column: span 1; min-width: 0;">
								<label class="so-label" style="color: #612989;">ขนาดห้องลิฟต์</label>
								<div style="display: flex; gap: 16px;">
									<input name="elev_width" type="text" class="so-input" placeholder="ความกว้าง (ซม.)" style="background-color: #F4F3F7; border:none; border-radius: 8px; min-width: 0; flex: 1;" />
									<input name="elev_height" type="text" class="so-input" placeholder="ความสูง (ซม.)" style="background-color: #F4F3F7; border:none; border-radius: 8px; min-width: 0; flex: 1;" />
									<input name="elev_depth" type="text" class="so-input" placeholder="ความลึก (ซม.)" style="background-color: #F4F3F7; border:none; border-radius: 8px; min-width: 0; flex: 1;" />
								</div>
							</div>
							<div class="so-field-group" style="min-width: 0;">
								<label class="so-label" style="color: #612989;">ขนาดบรรทุกของลิฟต์</label>
								<input name="elev_capacity" type="text" class="so-input" placeholder="น้ำหนัก (กก.)" style="background-color: #F4F3F7; border:none; border-radius: 8px; width: 100%;" />
							</div>
						</div>

						<div class="so-grid-3" style="margin-top: 16px;">
							<div class="so-field-group">
								<label class="so-label" style="color: #612989;">การย้ายเฟอร์นิเจอร์</label>
								<div style="display: flex; gap: 16px; height: 42px; align-items: center;">
									<label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-family: 'Prompt', sans-serif; font-size: 14px; color: #333; font-weight: 500;">
										<input type="radio" name="move_furn" value="0" checked style="accent-color: #612989; width: 18px; height: 18px;"> ไม่
									</label>
									<label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-family: 'Prompt', sans-serif; font-size: 14px; color: #333; font-weight: 500;">
										<input type="radio" name="move_furn" value="1" style="accent-color: #612989; width: 18px; height: 18px;"> ย้าย
									</label>
								</div>
							</div>
							<div class="so-field-group">
								<label class="so-label" style="color: #612989;">จำนวนชิ้นที่ย้าย</label>
								<input name="move_furn_count" type="text" class="so-input" placeholder="ใส่เฉพาะตัวเลข" style="background-color: #F4F3F7; border:none; border-radius: 8px; width: 100%;" />
							</div>
							<div class="so-field-group" style="grid-column: span 1;">
								<label class="so-label" style="color: #612989;">รายละเอียดเฟอร์นิเจอร์</label>
								<input name="move_furn_detail" type="text" class="so-input" placeholder="รายละเอียดเฟอร์นิเจอร์" style="background-color: #F4F3F7; border:none; border-radius: 8px; width: 100%;" />
							</div>
						</div>

						<div class="so-field-group" style="margin-top: 16px;">
							<label class="so-label" style="color: #612989;">หมายเหตุเพิ่มเติม</label>
							<input name="addr_note" type="text" class="so-input" placeholder="lorem ipsum" style="background-color: #F4F3F7; border:none; border-radius: 8px; width: 100%;" />
						</div>
					</div>
				</div>

				<script>
					function openAddrTab(tabId, element) {
						var contents = document.getElementsByClassName('so-addr-tab-content');
						for (var i = 0; i < contents.length; i++) {
							contents[i].style.display = 'none';
						}

						var container = element.parentElement;
						var btns = container.getElementsByClassName('so-tab-btn');
						for (var i = 0; i < btns.length; i++) {
							btns[i].classList.remove('active');
						}

						document.getElementById(tabId).style.display = 'block';
						element.classList.add('active');
					}
				</script>



				<!-- NEW DOCUMENT TABS CARD -->
				<div class="so-tabs-container" style="margin-top: 24px;">
					<button type="button" class="so-tab-btn active" onclick="open3Tab('tab_doc_extra', this)"><span style="color: #E81A70; margin-right: 6px;">●</span>เอกสารเพิ่มเติม</button>
					<button type="button" class="so-tab-btn" onclick="open3Tab('tab_dept_comment', this)">ข้อความแจ้งแผนก</button>
					<button type="button" class="so-tab-btn" onclick="open3Tab('tab_attach_file', this)">แนบไฟล์</button>
					<button type="button" class="so-tab-btn" onclick="open3Tab('tab_related_docs', this)">เอกสารที่เกี่ยวข้อง</button>
				</div>
				<div class="so-card" style="padding: 24px;">

					<!-- TAB 1: เอกสารเพิ่มเติม -->
					<div id="tab_doc_extra" class="so-3tab-content">
						<h3 style="font-size: 18px; color: #3B3B3B; margin-bottom: 24px;">เอกสารเพิ่มเติม</h3>
						<hr style="border: 0; border-top: 1px solid #EBEBEB; margin-bottom: 24px;">

						<div class="so-doc-grid">
							<label class="so-doc-pill">
								<input type="checkbox" name="ref_3" value="1" <?php echo so_saved_checked($savedOtherBill, 'ref_3') ? ' checked' : ''; ?>>
								<span>ใบ อย.</span>
							</label>
							<label class="so-doc-pill">
								<input type="checkbox" name="ref_6" value="1" <?php echo so_saved_checked($savedOtherBill, 'ref_6') ? ' checked' : ''; ?>>
								<span>ใบนำเข้าสินค้า</span>
							</label>
							<label class="so-doc-pill">
								<input type="checkbox" name="ref_8" value="1" <?php echo so_saved_checked($savedOtherBill, 'ref_8') ? ' checked' : ''; ?>>
								<span>ใบ PM</span>
							</label>
							<label class="so-doc-pill">
								<input type="checkbox" name="ref_9" value="1" <?php echo so_saved_checked($savedOtherBill, 'ref_9') ? ' checked' : ''; ?>>
								<span>ใบ CAL</span>
							</label>
							<label class="so-doc-pill">
								<input type="checkbox" name="ref_11" value="1" <?php echo so_saved_checked($savedOtherBill, 'ref_11') ? ' checked' : ''; ?>>
								<span>ใบประเมินสินค้า</span>
							</label>
							<label class="so-doc-pill">
								<input type="checkbox" name="ref_5" value="1" <?php echo so_saved_checked($savedOtherBill, 'ref_5') ? ' checked' : ''; ?>>
								<span>ใบช่างอบรม</span>
							</label>
							<label class="so-doc-pill" style="grid-column: span 2;">
								<input type="checkbox" name="ref_2" value="1" <?php echo so_saved_checked($savedOtherBill, 'ref_2') ? ' checked' : ''; ?>>
								<span>เอกสารตามไฟล์แนบ</span>
							</label>
							<label class="so-doc-pill" style="grid-column: span 2;">
								<input type="checkbox" name="ref_1" value="1" <?php echo so_saved_checked($savedOtherBill, 'ref_1') ? ' checked' : ''; ?>>
								<span>เอกสาร N-Health</span>
							</label>
							<label class="so-doc-pill" style="grid-column: span 2;">
								<input type="checkbox" name="ref_4" value="1" <?php echo so_saved_checked($savedOtherBill, 'ref_4') ? ' checked' : ''; ?>>
								<span>ใบตัวแทนจำหน่าย</span>
							</label>
							<label class="so-doc-pill" style="grid-column: span 2;">
								<input type="checkbox" name="ref_7" value="1" <?php echo so_saved_checked($savedOtherBill, 'ref_7') ? ' checked' : ''; ?>>
								<span>ใบ CER เครื่องมือที่ใช้ทดสอบ</span>
							</label>
							<div class="so-doc-other-wrapper" style="grid-column: span 4; display: flex; flex-direction: column; justify-content: flex-end;">
								<label style="color: #612989; font-weight: 400; font-size: 14px; margin-bottom: 8px; display: block; font-family: 'Prompt', sans-serif;">อื่นๆ</label>
								<input type="text" name="ref_des" class="so-input" value="<?php echo so_saved_h($savedOtherBill['ref_des'] ?? ''); ?>" placeholder="ระบุรายละเอียดอื่นๆ..." style="width: 100%;" oninput="document.getElementById('ref_10_hidden').checked = (this.value.trim() !== '');">
								<input type="checkbox" name="ref_10" id="ref_10_hidden" value="1" style="display:none;" <?php echo (so_saved_checked($savedOtherBill, 'ref_10') || trim((string)($savedOtherBill['ref_des'] ?? '')) !== '') ? ' checked' : ''; ?>>
								<!-- Hidden inputs to keep old compatibility if needed -->
								<input type="checkbox" name="ref_13" value="1" style="display:none;" <?php echo so_saved_checked($savedOtherBill, 'ref_13') ? ' checked' : ''; ?>>
							</div>
						</div>
					</div>

					<!-- TAB 2: ข้อความแจ้งแผนก -->
					<div id="tab_dept_comment" class="so-3tab-content" style="display:none;">
						<h3 style="font-size: 18px; color: #3B3B3B; margin-bottom: 24px;">ข้อความแจ้งแผนกที่เกี่ยวข้อง</h3>
						<hr style="border: 0; border-top: 1px solid #EBEBEB; margin-bottom: 24px;">

						<div style="display: flex; gap: 16px; align-items: center; margin-bottom: 24px;">
							<button type="button" onclick="addDeptComment()" style="background-color: #EFEBFF; color: #612989; border: none; border-radius: 24px; padding: 10px 24px; font-family: 'Prompt', sans-serif; font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 8px;">
								<img src="img/icons/add_message.png" alt="add_message" style="width: 16px; height: 16px;"> เพิ่มข้อความ
							</button>
							<button type="button" id="technician_required_btn" class="<?php echo ((isset($savedCommentSo['technician_required']) && (string)$savedCommentSo['technician_required'] === '1') ? 'btn-dept-active' : ''); ?>" onclick="toggleTechnicianRequired(this);" style="background-color: #F4F3F7; border: none; padding: 10px 24px; border-radius: 8px; color: #333; font-size: 16px; font-family: 'Prompt', sans-serif; cursor: pointer; transition: background-color 0.2s, color 0.2s; width: 328px;">
								ต้องการช่างไปตรวจรับ
							</button>
							<input type="hidden" name="technician_required" id="hidden_technician_required" value="<?php echo ((isset($savedCommentSo['technician_required']) && (string)$savedCommentSo['technician_required'] === '1') ? '1' : '0'); ?>">
						</div>

						<div id="dept_comment_list">
							<!-- Dynamic comments will go here -->
						</div>

						<!-- Hidden textareas to submit to backend -->
						<textarea name="comment_cs" id="hidden_comment_cs" style="display:none;"></textarea>
						<textarea name="comment_en" id="hidden_comment_en" style="display:none;"></textarea>
						<textarea name="comment_st" id="hidden_comment_st" style="display:none;"></textarea>
						<textarea name="comment_ad" id="hidden_comment_ad" style="display:none;"></textarea>
						<input type="hidden" name="dept_comment_items" id="hidden_dept_comment_items" value="">
					</div>

					<!-- TAB 3: แนบไฟล์ -->
					<div id="tab_attach_file" class="so-3tab-content" style="display:none;">
						<h3 style="font-size: 18px; color: #3B3B3B; margin-bottom: 24px;">แนบไฟล์เพิ่มเติม</h3>
						<hr style="border: 0; border-top: 1px solid #EBEBEB; margin-bottom: 24px;">

						<button type="button" onclick="triggerAttachFile()" style="background-color: #EFEBFF; color: #612989; border: none; border-radius: 24px; padding: 10px 24px; font-family: 'Prompt', sans-serif; font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 8px; margin-bottom: 24px;">
							<img src="img/icons/import_file.png" alt="import_file" style="width: 16px; height: 16px;"> เพิ่มไฟล์
						</button>

						<div id="attach_file_list" style="display: flex; flex-wrap: wrap; gap: 16px;">
							<!-- Dynamic files will go here -->
						</div>

						<!-- slip1 is reserved for payment proof; additional files use slip2-slip5. -->
						<input type="file" name="slip1" id="hidden_slip1" style="display:none;" onchange="handleFileSelect(this, 1)">
						<input type="file" name="slip2" id="hidden_slip2" style="display:none;" onchange="handleFileSelect(this, 2)">
						<input type="file" name="slip3" id="hidden_slip3" style="display:none;" onchange="handleFileSelect(this, 3)">
						<input type="file" name="slip4" id="hidden_slip4" style="display:none;" onchange="handleFileSelect(this, 4)">
						<input type="file" name="slip5" id="hidden_slip5" style="display:none;" onchange="handleFileSelect(this, 5)">
					</div>

					<!-- TAB 4: เอกสารที่เกี่ยวข้อง -->
					<div id="tab_related_docs" class="so-3tab-content" style="display:none;">
						<div class="so-related-doc-table">
							<div class="so-related-doc-header">
								<div>ชื่อเอกสาร</div>
								<div>หมายเลข SN</div>
								<div></div>
							</div>
							<div id="related_doc_rows">
								<div class="so-related-doc-empty">ยังไม่มีเอกสารที่เกี่ยวข้อง</div>
							</div>
						</div>
					</div>
				</div>

				<style>
					.btn-dept-active {
						background-color: #612989 !important;
						color: #FFFFFF !important;
					}

					.so-doc-pill {
						background-color: #F4F3F7;
						border: 1px solid transparent;
						border-radius: 8px;
						padding: 12px;
						display: flex;
						align-items: center;
						justify-content: center;
						cursor: pointer;
						transition: all 0.2s ease;
						text-align: center;
						color: #8E8B94;
						font-weight: 500;
					}

					.so-doc-pill:has(input:checked) {
						background-color: #612989;
						border-color: #612989;
						color: #ffffff;
					}

					.so-doc-pill input[type="checkbox"] {
						display: none;
					}

					.dept-row {
						display: flex;
						gap: 16px;
						margin-bottom: 16px;
						align-items: flex-end;
					}

					.so-related-doc-table {
						background-color: #FFFFFF;
						border-radius: 8px;
						overflow: hidden;
						min-height: 330px;
						margin: -24px;
						font-family: 'Prompt', sans-serif;
					}

					.so-related-doc-header,
					.so-related-doc-row {
						display: grid;
						grid-template-columns: minmax(260px, 1fr) minmax(180px, 280px) 96px;
						align-items: center;
					}

					.so-related-doc-header {
						color: #612989;
						font-size: 16px;
						font-weight: 600;
						border-bottom: 1px solid #612989;
					}

					.so-related-doc-header>div,
					.so-related-doc-row>div {
						padding: 18px 46px;
					}

					.so-related-doc-row {
						color: #3B3B3B;
						font-size: 16px;
						border-bottom: 1px solid #EBEBEB;
						min-height: 78px;
					}

					.so-related-doc-action {
						width: 32px;
						height: 32px;
						border: none;
						background-color: transparent;
						color: #612989;
						cursor: pointer;
						display: inline-flex;
						align-items: center;
						justify-content: center;
						font-size: 24px;
						padding: 0;
					}

					.so-related-doc-action img {
						width: 23.97px;
						height: 24px;
						object-fit: contain;
					}

					.so-related-doc-empty {
						color: #8E8B94;
						font-size: 16px;
						padding: 32px 46px;
					}

					@media (max-width: 768px) {
						.so-related-doc-table {
							margin: -16px;
							overflow-x: auto;
						}

						.so-related-doc-header,
						.so-related-doc-row {
							grid-template-columns: minmax(220px, 1fr) minmax(150px, 180px) 70px;
							min-width: 560px;
						}

						.so-related-doc-header>div,
						.so-related-doc-row>div {
							padding: 14px 18px;
						}
					}
				
</style>

				<script>
					function open3Tab(tabId, element) {
						var contents = document.getElementsByClassName('so-3tab-content');
						for (var i = 0; i < contents.length; i++) {
							contents[i].style.display = 'none';
						}

						var container = element.parentElement;
						var btns = container.getElementsByClassName('so-tab-btn');
						for (var i = 0; i < btns.length; i++) {
							btns[i].classList.remove('active');
						}

						document.getElementById(tabId).style.display = 'block';

						element.classList.add('active');
						if (tabId === 'tab_related_docs' && typeof renderRelatedDocuments === 'function') {
							renderRelatedDocuments();
						}
					}

					function escapeRelatedDocValue(value) {
						return String(value || '')
							.replace(/&/g, '&amp;')
							.replace(/"/g, '&quot;')
							.replace(/</g, '&lt;')
							.replace(/>/g, '&gt;');
					}

					function getRelatedDocFieldValue(prefix, rowIndex) {
						const element = document.getElementById(prefix + rowIndex);
						return element ? String(element.value || '').trim() : '';
					}

					function getRelatedDocSn(rowIndex) {
						const rowSn = getRelatedDocFieldValue('product_sn', rowIndex) || getRelatedDocFieldValue('sn', rowIndex);
						if (rowSn !== '') {
							return rowSn;
						}

						const documentSn = document.querySelector('input[name="sn_no"]');
						return documentSn ? String(documentSn.value || '').trim() : '';
					}

					function getRelatedDocRefId() {
						const refInput = document.querySelector('input[name="ref_id"]');
						return refInput ? String(refInput.value || '').trim() : '';
					}

					function parseRelatedDocSnList(rawValue) {
						return String(rawValue || '')
							.split(/\r\n|\n|\r|,|;/)
							.map(function(item) {
								return item.trim();
							})
							.filter(function(item) {
								return item.length > 2;
							});
					}

					function openRelatedDocument(rowIndex) {
						const refId = getRelatedDocRefId();
						const productId = getRelatedDocFieldValue('product_id', rowIndex);
						const snList = parseRelatedDocSnList(getRelatedDocSn(rowIndex));

						if (refId === '') {
							alert('กรุณาบันทึกเอกสารก่อนดูรายละเอียดเอกสาร');
							return;
						}

						if (snList.length === 0) {
							alert('ไม่พบ Serial Number สำหรับรายการนี้');
							return;
						}

						if (snList.length === 1) {
							if (productId === '') {
								alert('ไม่พบรหัสสินค้า สำหรับเปิดรายละเอียดเอกสารรายสินค้า');
								return;
							}

							window.open(
								'register_adminhos_doc_sn1.php?product_sn=' + encodeURIComponent(snList[0]) +
								'&product_ID=' + encodeURIComponent(productId) +
								'&ref_id=' + encodeURIComponent(refId),
								'_blank'
							);
							return;
						}

						window.open('register_adminhos_doc_sn.php?ref_id=' + encodeURIComponent(refId), '_blank');
					}

					function renderRelatedDocuments() {
						const rowsContainer = document.getElementById('related_doc_rows');
						if (!rowsContainer) return;

						const rows = [];
						for (let i = 1; i <= 30; i++) {
							const deleted = getRelatedDocFieldValue('row_deleted', i) === '1';
							const productId = getRelatedDocFieldValue('product_id', i);
							const productCode = getRelatedDocFieldValue('product_codet', i) || getRelatedDocFieldValue('h_product_codet', i);
							const productName = getRelatedDocFieldValue('display_name', i) || getRelatedDocFieldValue('product_name', i) || productCode;

							if (!deleted && (productId !== '' || productCode !== '' || productName !== '')) {
								rows.push({
									name: productName,
									sn: getRelatedDocSn(i),
									rowIndex: i
								});
							}
						}

						if (rows.length === 0) {
							rowsContainer.innerHTML = '<div class="so-related-doc-empty">ยังไม่มีเอกสารที่เกี่ยวข้อง</div>';
							return;
						}

						rowsContainer.innerHTML = rows.map(function(row) {
							const safeName = escapeRelatedDocValue(row.name);
							const safeSn = escapeRelatedDocValue(row.sn);
							return `
								<div class="so-related-doc-row">
									<div>${safeName}</div>
									<div>${safeSn || '-'}</div>
									<div>
										<button type="button" class="so-related-doc-action" title="ดูเอกสาร" aria-label="ดูเอกสารแถวที่ ${row.rowIndex}" onclick="openRelatedDocument(${row.rowIndex})">
											<img src="img/icons/view_doc.png" alt="ดูเอกสาร">
										</button>
									</div>
								</div>
							`;
						}).join('');
					}

					document.addEventListener('DOMContentLoaded', function() {
						renderRelatedDocuments();

						const snInput = document.querySelector('input[name="sn_no"]');
						if (snInput) {
							snInput.addEventListener('input', renderRelatedDocuments);
						}

						for (let i = 1; i <= 30; i++) {
							['product_codet', 'h_product_codet', 'product_name', 'display_name', 'product_id', 'product_sn', 'row_deleted'].forEach(function(prefix) {
								const element = document.getElementById(prefix + i);
								if (element) {
									element.addEventListener('input', renderRelatedDocuments);
									element.addEventListener('change', renderRelatedDocuments);
								}
							});
						}
					});

					// === Department Comments JS ===
					let commentIdCounter = 0;
					const savedCommentSoForDept = <?php echo json_encode($savedCommentSo); ?>;
					const savedCommentSoItemsForDept = <?php echo json_encode($savedCommentSoItems); ?>;
					const deptCodeToId = {
						cs: '1',
						en: '2',
						st: '3',
						ad: '4'
					};
					const deptIdToCode = {
						'1': 'cs',
						'2': 'en',
						'3': 'st',
						'4': 'ad'
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
					}

					function toggleTechnicianRequired(button) {
						const isActive = !button.classList.contains('btn-dept-active');
						setTechnicianRequired(isActive);
					}

					function addDeptComment(defaultDept = '', defaultText = '') {
						const list = document.getElementById('dept_comment_list');
						const rowId = 'dept_row_' + commentIdCounter++;
						const selectedDept = normalizeDeptValue(defaultDept);
						const defaultTextValue = escapeDeptCommentValue(defaultText);

						const row = document.createElement('div');
						row.className = 'dept-row';
						row.id = rowId;

						row.innerHTML = `
        <div style="flex: 0 0 200px;">
            <label style="color: #612989; font-size: 13px; font-weight: 600; margin-bottom: 8px; display: block;">แผนก</label>
            <div class="so-select-wrapper">
                <select class="so-select" onchange="syncDeptComments()">
                    <option value="">เลือกแผนก</option>
                    <option value="1" ${selectedDept === '1' ? 'selected' : ''}>จัดส่ง</option>
                    <option value="2" ${selectedDept === '2' ? 'selected' : ''}>ช่าง</option>
                    <option value="3" ${selectedDept === '3' ? 'selected' : ''}>คลังสินค้า</option>
                    <option value="4" ${selectedDept === '4' ? 'selected' : ''}>Admin</option>
                    <option value="4" ${selectedDept === '5' ? 'selected' : ''}>บัญชี</option>
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

						document.getElementById('hidden_comment_cs').value = cs;
						document.getElementById('hidden_comment_en').value = en;
						document.getElementById('hidden_comment_st').value = st;
						document.getElementById('hidden_comment_ad').value = ad;
						document.getElementById('hidden_dept_comment_items').value = JSON.stringify(items);
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
									addDeptComment(item.department_id, item.message);
									addedAny = true;
								}
							});
						} else if (savedCommentSoForDept) {
							['cs', 'en', 'st', 'ad'].forEach(function(dept) {
								const commentText = savedCommentSoForDept['comment_' + dept];
								if (commentText && commentText.trim() !== '') {
									commentText.split('\n').forEach(function(line) {
										if (line.trim() !== '') {
											addDeptComment(dept, line);
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

					// === Attach Files JS ===
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

					function syncSlipUploadToSlip1(input) {
						const fileNameDisplay = document.getElementById('file_name_display');
						const slip1Input = document.getElementById('hidden_slip1');
						const slip1HiddenVal = document.getElementById('hidden_slip_val1');
						const maxFileSize = 1100000;

						fileNameDisplay.textContent = input.files && input.files[0] ? input.files[0].name : 'Choose File';

						if (!slip1Input) {
							return;
						}

						if (input.files && input.files.length > 0) {
							if (input.files[0].size > maxFileSize) {
								input.value = '';
								slip1Input.value = '';
								if (slip1HiddenVal) {
									slip1HiddenVal.value = '';
								}
								fileNameDisplay.textContent = 'Choose File';
								if (typeof Swal !== 'undefined') {
									Swal.fire({
										icon: 'warning',
										title: 'ไฟล์มีขนาดเกินกำหนด',
										text: 'กรุณาแนบไฟล์ที่มีขนาดไม่เกิน 1 MB'
									});
								} else {
									alert('กรุณาแนบไฟล์ที่มีขนาดไม่เกิน 1 MB');
								}
								renderFileList();
								return;
							}

							const dt = new DataTransfer();
							dt.items.add(input.files[0]);
							slip1Input.files = dt.files;
							if (slip1HiddenVal) {
								slip1HiddenVal.value = '';
							}
						} else {
							slip1Input.value = '';
						}

						renderFileList();
					}

					function renderFileList() {
						const list = document.getElementById('attach_file_list');
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
						input.value = ''; // Clear file
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
				</script>
				<!-- NEW 3 TABS CARD END -->


				<!-- Section: ข้อมูลเพิ่มเติม (ถูกซ่อนไว้) -->
				<div id="hidden-extra-info" style="display: none;">
					<div class="so-section-title-container">
						<h2 class="so-section-title">ข้อมูลเพิ่มเติม</h2>
						<hr class="so-divider">
					</div>

					<div class="so-grid-3">
						<!-- แนบใบเสนอราคา -->
						<div class="so-field-group">
							<label class="so-label">แนบใบเสนอราคา</label>
							<div class="so-input-with-checkbox">
								<label class="so-checkbox-label">
									<input name="with_pr" type="checkbox" value="1"> แนบใบเสนอราคา
								</label>
								<input name="pr_no" class="so-input" placeholder="เลขที่ใบเสนอราคา..." style="flex: 1;">
							</div>
						</div>

						<!-- ต้องการ SN -->
						<div class="so-field-group">
							<label class="so-label">ต้องการ SN</label>
							<div class="so-input-with-checkbox">
								<label class="so-checkbox-label">
									<input type="checkbox" name="sn_ckk" value="1"> ต้องการ SN
								</label>
								<input name="sn_no" class="so-input" placeholder="เลขที่ SN..." style="flex: 1;">
							</div>
						</div>
					</div>

					<div class="so-grid-2">
						<!-- รูปแบบการพิมพ์ -->
						<div class="so-field-group">
							<label class="so-label">รูปแบบการพิมพ์</label>
							<div class="so-radio-group-vertical">
								<label class="so-radio-label">
									<input type="radio" name="type_type" checked="checked" value="1" onclick="javascript:ckk_1();" id="object6">
									<span>พิมพ์ตามคอม</span>
								</label>
								<label class="so-radio-label">
									<input type="radio" name="type_type" value="2" onclick="javascript:ckk_1();" id="object7">
									<span>พิมพ์ตามใบสั่งซื้อ</span>
								</label>
								<label class="so-radio-label">
									<input type="radio" name="type_type" value="3" onclick="javascript:ckk_1();" id="object5">
									<span>พิมพ์ตามที่เขียน</span>
								</label>
							</div>
							<div id="dt5" style="display:none; margin-top: 10px;">
								<textarea name="type_detail" class="so-textarea" rows="2" placeholder="ระบุรายละเอียดเพิ่มเติม..."></textarea>
							</div>
						</div>

					</div>
				</div> <!-- End hidden-extra-info -->
			</div>
		</div>
		</div><!-- End Card Container -->

		<script>
			function syncDeliveryTimeRange() {
				var timeRange = document.getElementById('time_range');
				var startTime = document.querySelector('input[name="start_time"]');
				var endTime = document.querySelector('input[name="end_time"]');
				if (!timeRange || !startTime || !endTime) {
					return;
				}

				var timeRangeMap = {
					morning: ['08:00', '12:00'],
					afternoon: ['13:00', '17:00'],
					allday: ['08:00', '17:00']
				};

				if (timeRangeMap[timeRange.value]) {
					startTime.value = timeRangeMap[timeRange.value][0];
					endTime.value = timeRangeMap[timeRange.value][1];
				}
			}

			document.addEventListener('DOMContentLoaded', function() {
				var timeRange = document.getElementById('time_range');
				var startTime = document.querySelector('input[name="start_time"]');
				var form = document.forms['frmMain'];
				if (timeRange) {
					timeRange.addEventListener('change', syncDeliveryTimeRange);
				}
				if (timeRange && startTime) {
					startTime.addEventListener('input', function() {
						if (timeRange.value !== '' && timeRange.value !== 'specific') {
							timeRange.value = 'specific';
						}
					});
				}
				if (form) {
					form.addEventListener('submit', syncDeliveryTimeRange);
				}
			});

			function openDelTab(tabId, element) {
				var contents = document.getElementsByClassName('so-del-tab-content');
				for (var i = 0; i < contents.length; i++) {
					contents[i].style.display = 'none';
				}

				var container = element.parentElement;
				var btns = container.getElementsByClassName('so-tab-btn');
				for (var i = 0; i < btns.length; i++) {
					btns[i].classList.remove('active');
				}

				document.getElementById(tabId).style.display = 'block';
				element.classList.add('active');
			}
		</script>


		<!-- ปุ่ม action ติดล่างของฟอร์มหลัก: submit จริงและปุ่ม draft สำหรับต่อยอด logic ภายหลัง -->
		</div>
		<div class="so-sticky-actions" style="width: 100%; background-color: white; padding: 16px 24px; display: flex; gap: 16px; justify-content: flex-end; box-shadow: 0 -4px 10px rgba(0, 0, 0, 0.05); align-items: center; border-top: 1px solid #EBEBEB; margin-top: 24px; box-sizing: border-box;">
			<div class="so-sticky-actions-inner" style="max-width: 1200px; width: 100%; display: flex; gap: 16px; justify-content: flex-end; margin: 0 auto; padding-right: 24px;">
				<button type="submit" name="submit" value="submit" style="background-color: #612989; color: #fff; border: 1px solid #612989; border-radius: 24px; padding: 12px 32px; font-family: 'Prompt', sans-serif; font-size: 16px; font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.08);">
					<i class="far fa-save"></i> บันทึกข้อมูล
				</button>
				<button type="button" name="save_draft" onclick="saveDraft()" style="background-color: white; color: #612989; border: 1px solid #EBEBEB; border-radius: 24px; padding: 12px 32px; font-family: 'Prompt', sans-serif; font-size: 16px; font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);">
					<i class="far fa-save"></i> Save Draft
				</button>
			</div>
		</div>
		<!-- hidden fields กลุ่มนี้ยังคงส่งค่าไปกับ form แม้ไม่มี input ให้ผู้ใช้แก้บนหน้า -->
		<input type="hidden" name="end_time" value="<?php echo so_saved_h(so_saved_delivery_time_part($savedSo, $savedRegister, 1)); ?>">
		<input type="hidden" name="mode_name" id="mode_name" value="">
		<input type="hidden" name="sale_comment" value="">
		<input type="hidden" name="head_1" value="">
		<input type="hidden" name="have_map" value="">
		<input type="hidden" name="customer_contact" value="">
		<input type="hidden" name="address_send" id="address_send" value="<?php echo ($savedSo !== null) ? so_saved_h($savedSo['install_place'] ?? '') : ''; ?>">
		<input type="hidden" name="customer_typename" id="customer_typename" value="">
		<input type="hidden" name="date_tranfer" value="">
		<input type="hidden" name="redirect_to" value="register_suphos.php">
		<input type="hidden" name="slip1" id="hidden_slip_val1" value="<?php echo ($savedSo !== null) ? so_saved_h($savedSo['slip1']) : ''; ?>">
		<input type="hidden" name="slip2" id="hidden_slip_val2" value="<?php echo ($savedSo !== null) ? so_saved_h($savedSo['slip2']) : ''; ?>">
		<input type="hidden" name="slip3" id="hidden_slip_val3" value="<?php echo ($savedSo !== null) ? so_saved_h($savedSo['slip3']) : ''; ?>">
		<input type="hidden" name="slip4" id="hidden_slip_val4" value="<?php echo ($savedSo !== null) ? so_saved_h($savedSo['slip4']) : ''; ?>">
		<input type="hidden" name="slip5" id="hidden_slip_val5" value="<?php echo ($savedSo !== null) ? so_saved_h($savedSo['slip5']) : ''; ?>">
	</form>

	<!-- Modal รายชื่อลูกค้า: ใช้ค้นหา/เลือก customer เพื่อนำข้อมูลไปเติมในฟอร์มหลัก -->
	<div id="customerPopupModal" class="customer-popup-modal" aria-hidden="true">
		<div class="customer-popup-box" role="dialog" aria-modal="true" aria-labelledby="customerPopupTitle">
			<button type="button" class="customer-popup-close" onclick="closeCustomerPopup()" aria-label="Close">&times;</button>

			<div class="clear-loan-header">
				<h2 id="customerPopupTitle">ข้อมูลลูกค้า</h2>
				<div class="customer-popup-toolbar" style="margin-top: 18px;">
					<div class="customer-popup-search-wrap">
						<label for="customerPopupSearch">ค้นหาลูกค้า</label>
						<div class="customer-popup-search">
							<i class="fas fa-search" aria-hidden="true"></i>
							<input type="text" id="customerPopupSearch" placeholder="ค้นหาด้วยชื่อ / เบอร์โทร">
						</div>
					</div>
					<button type="button" class="customer-popup-add" onclick="window.open('customer_add.php', '_blank');">
						<i class="fas fa-sliders-h" aria-hidden="true"></i>
						เพิ่มข้อมูลลูกค้า
					</button>
				</div>
			</div>

			<div class="customer-popup-table-wrap">
				<table class="customer-popup-table">
					<thead>
						<tr>
							<th>ชื่อลูกค้า</th>
							<th>เบอร์โทร</th>
							<th>ที่อยู่</th>
							<th></th>
						</tr>
					</thead>
					<tbody id="customerPopupRows">
						<tr>
							<td colspan="4" class="customer-popup-empty">พิมพ์ชื่อหรือเบอร์โทรเพื่อค้นหา</td>
						</tr>
					</tbody>
				</table>
			</div>

			<div class="customer-popup-pagination" id="customerPopupPagination" style="display:none;">
				<button type="button" class="customer-popup-loadmore" id="customerPopupLoadMore" onclick="loadMoreCustomerPopupRows()">โหลดเพิ่ม</button>
			</div>

			<div class="customer-popup-actions">
				<button type="button" class="customer-popup-confirm" onclick="confirmCustomerPopupSelection()">ตกลง</button>
				<button type="button" class="customer-popup-cancel" onclick="closeCustomerPopup()">ยกเลิก</button>
			</div>
		</div>
	</div>

	<!-- Modal ข้อมูลออกบิล: แยกข้อมูล billing ออกจาก customer หลัก และให้เลือกมา bind เข้าฟอร์ม -->
	<div id="fullBillPopupModal" class="customer-popup-modal" aria-hidden="true">
		<div class="customer-popup-box fullbill-popup-box" role="dialog" aria-modal="true" aria-labelledby="fullBillPopupTitle">
			<button type="button" class="customer-popup-close" onclick="closeFullBillPopup(false)" aria-label="Close">&times;</button>

			<div class="clear-loan-header">
				<h2 id="fullBillPopupTitle">ข้อมูลการออกบิล</h2>
				<div class="customer-popup-toolbar" style="margin-top: 18px;">
					<div class="customer-popup-search-wrap">
						<label for="fullBillPopupSearch">ค้นหาข้อมูลออกบิล</label>
						<div class="customer-popup-search">
							<i class="fas fa-search" aria-hidden="true"></i>
							<input type="text" id="fullBillPopupSearch" placeholder="ค้นหาด้วยชื่อ / เบอร์โทร">
						</div>
					</div>
					<button type="button" class="customer-popup-add" onclick="window.open('billing_info_add.php', '_blank');">
						<i class="fas fa-sliders-h" aria-hidden="true"></i>
						เพิ่มข้อมูลออกบิล
					</button>
				</div>
			</div>

			<div class="customer-popup-table-wrap">
				<table class="customer-popup-table fullbill-popup-table">
					<thead>
						<tr>
							<th>ชื่อลูกค้า</th>
							<th>เบอร์โทร</th>
							<th>วันที่ต้องการสินค้า</th>
							<th>เลขที่ผู้เสียภาษี</th>
							<th></th>
						</tr>
					</thead>
					<tbody id="fullBillPopupRows">
						<tr>
							<td colspan="5" class="customer-popup-empty">พิมพ์ชื่อหรือเบอร์โทรเพื่อค้นหา</td>
						</tr>
					</tbody>
				</table>
			</div>

			<div class="customer-popup-pagination" id="fullBillPopupPagination" style="display:none;">
				<button type="button" class="customer-popup-loadmore" id="fullBillPopupLoadMore" onclick="loadMoreFullBillPopupRows()">โหลดเพิ่ม</button>
			</div>

			<div class="customer-popup-actions">
				<button type="button" class="customer-popup-confirm" onclick="confirmFullBillPopupSelection()">ตกลง</button>
				<button type="button" class="customer-popup-cancel" onclick="closeFullBillPopup(false)">ยกเลิก</button>
			</div>
		</div>
	</div>

	<!-- Credit Term Modal -->
	<div id="creditTermPopupModal" class="customer-popup-modal" aria-hidden="true">
		<div class="customer-popup-box credit-term-popup-box" role="dialog" aria-modal="true" aria-labelledby="creditTermPopupTitle">
			<button type="button" class="customer-popup-close" onclick="closeCreditTermPopup()" aria-label="Close">&times;</button>

			<div class="clear-loan-header">
				<h2 id="creditTermPopupTitle">เครดิตเทอม</h2>
			</div>

			<div class="credit-term-popup-content">
				<div class="credit-term-summary">
					<div class="credit-term-summary-item">
						<p class="credit-term-summary-label">เครดิต (วัน)</p>
						<p class="credit-term-summary-value" id="creditTermSummaryDay">-</p>
					</div>
					<div class="credit-term-summary-item">
						<p class="credit-term-summary-label">เครดิต (ยอดเงิน)</p>
						<p class="credit-term-summary-value" id="creditTermSummaryAmount">0.00</p>
					</div>
					<div class="credit-term-summary-item">
						<p class="credit-term-summary-label">ยอดรวมหนี้คงค้าง</p>
						<p class="credit-term-summary-value" id="creditTermSummaryOutstanding">0.00</p>
					</div>
					<div class="credit-term-summary-item is-highlight">
						<p class="credit-term-summary-label">ยอดเครดิตคงเหลือ</p>
						<p class="credit-term-summary-value" id="creditTermSummaryRemaining">0.00</p>
					</div>
				</div>

				<div class="credit-term-table-panel">
					<div class="credit-term-table-wrap">
						<table class="credit-term-table">
							<thead>
								<tr>
									<th></th>
									<th>เลขที่ใบสั่งขาย</th>
									<th>รายการสินค้า</th>
									<th>ยอดที่ต้องชำระ</th>
									<th>ยอดชำระแล้ว</th>
									<th>ยอดหนี้คงค้าง</th>
								</tr>
							</thead>
							<tbody id="creditTermTableBody">
								<tr class="credit-term-empty-row">
									<td><span class="credit-term-caret" aria-hidden="true"></span></td>
									<td colspan="5">เลือกลูกค้าแล้วกดเปิดเครดิตเทอมเพื่อดูข้อมูล</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Modal ที่อยู่จัดส่ง: ใช้เลือก shipping address ของลูกค้าที่ถูกเลือกอยู่ก่อนหน้า -->
	<div id="shippingAddressPopupModal" class="customer-popup-modal shipping-popup-modal" aria-hidden="true">
		<div class="customer-popup-box shipping-popup-box" role="dialog" aria-modal="true" aria-labelledby="shippingAddressPopupTitle">
			<button type="button" class="customer-popup-close" onclick="closeShippingAddressPopup()" aria-label="Close">&times;</button>

			<div class="clear-loan-header">
				<h2 id="shippingAddressPopupTitle">ที่อยู่จัดส่ง</h2>
				<div class="customer-popup-toolbar shipping-popup-toolbar" style="margin-top: 18px;">
					<div class="customer-popup-search-wrap">
						<label for="shippingAddressPopupSearch">ค้นหาที่อยู่จัดส่ง</label>
						<div class="customer-popup-search">
							<i class="fas fa-search"></i>
							<input type="text" id="shippingAddressPopupSearch" placeholder="ค้นหาด้วยชื่อ / เบอร์โทร">
						</div>
					</div>
					<button type="button" class="customer-popup-add" onclick="openShippingAddressCreatePage(getCurrentShippingPopupCustomerId())">
						<i class="fas fa-stream"></i> เพิ่มที่อยู่จัดส่ง
					</button>
				</div>
			</div>

			<div class="customer-popup-table-wrap">
				<table class="customer-popup-table shipping-popup-table">
					<thead>
						<tr>
							<th></th>
							<th>รหัสลูกค้า</th>
							<th>ชื่อลูกค้า</th>
							<th>เบอร์โทร</th>
							<th>ชื่อผู้รับสินค้า</th>
							<th>ที่อยู่จัดส่ง</th>
							<th></th>
						</tr>
					</thead>
					<tbody id="shippingAddressPopupRows">
						<tr>
							<td colspan="7" class="customer-popup-empty">เลือกลูกค้าก่อนค้นหาที่อยู่จัดส่ง</td>
						</tr>
					</tbody>
				</table>
			</div>

			<div class="customer-popup-pagination" id="shippingAddressPopupPagination" style="display:none;">
				<button type="button" class="customer-popup-loadmore" id="shippingAddressPopupLoadMore" onclick="loadMoreShippingAddressPopupRows()">โหลดเพิ่ม</button>
			</div>

			<div class="customer-popup-actions">
				<button type="button" class="customer-popup-confirm" onclick="confirmShippingAddressPopupSelection()">ตกลง</button>
				<button type="button" class="customer-popup-cancel" onclick="closeShippingAddressPopup()">ย้อนกลับ</button>
			</div>
		</div>
	</div>

	<script>
		// State ของ popup แต่ละตัวถูกแยกชุดกัน เพื่อไม่ให้การค้นหา/การเลือกค่าใน modal หนึ่งไปรบกวนอีก modal
		var customerPopupSelected = null;
		var customerPopupTimer = null;
		var customerPopupData = [];
		var customerPopupKeyword = '';
		var customerPopupNextLastId = null;
		var customerPopupHasMore = false;
		var customerPopupLoading = false;
		var customerPopupPageSize = 20;
		var fullBillPopupSelected = null;
		var fullBillPopupTimer = null;
		var fullBillPopupData = [];
		var fullBillPopupKeyword = '';
		var fullBillPopupNextLastId = null;
		var fullBillPopupHasMore = false;
		var fullBillPopupLoading = false;
		var fullBillPopupPageSize = 20;
		var fullBillPopupPreviousChecked = false;
		var shippingAddressPopupSelected = null;
		var shippingAddressPopupTimer = null;
		var shippingAddressPopupData = [];
		var shippingAddressPopupKeyword = '';
		var shippingAddressPopupNextLastId = null;
		var shippingAddressPopupHasMore = false;
		var shippingAddressPopupLoading = false;
		var shippingAddressPopupPageSize = 20;
		var shippingAddressPopupCustomerId = '';
		var shippingAddressPopupSelectedKeys = [];

		// เปิด modal ลูกค้า พร้อม reset state การเลือกเดิมและยิงค้นหารอบแรกจาก keyword ปัจจุบัน
		function openCustomerPopup() {
			var modal = document.getElementById('customerPopupModal');
			var search = document.getElementById('customerPopupSearch');
			if (!modal) return;

			modal.style.display = 'flex';
			modal.setAttribute('aria-hidden', 'false');
			customerPopupSelected = null;
			customerPopupData = [];
			customerPopupKeyword = search ? (search.value || '') : '';
			customerPopupNextLastId = null;
			customerPopupHasMore = false;
			toggleCustomerPopupLoadMore(false, false);

			loadCustomerPopupRows(customerPopupKeyword, false);
			setTimeout(function() {
				if (search) {
					search.focus();
					search.select();
				}
			}, 50);
		}

		// ปิด modal ลูกค้าแบบไม่แก้ค่าที่ฟอร์มหลัก
		function closeCustomerPopup() {
			var modal = document.getElementById('customerPopupModal');
			if (!modal) return;

			modal.style.display = 'none';
			modal.setAttribute('aria-hidden', 'true');
		}

		// เปิด modal ข้อมูลออกบิล และรีเซ็ตผลลัพธ์เพื่อป้องกันข้อมูลค้างจากรอบก่อน
		function openFullBillPopup() {
			var modal = document.getElementById('fullBillPopupModal');
			var search = document.getElementById('fullBillPopupSearch');
			if (!modal) return;

			modal.style.display = 'flex';
			modal.setAttribute('aria-hidden', 'false');
			fullBillPopupSelected = null;
			fullBillPopupData = [];
			fullBillPopupKeyword = search ? (search.value || '') : '';
			fullBillPopupNextLastId = null;
			fullBillPopupHasMore = false;
			toggleFullBillPopupLoadMore(false, false);

			loadFullBillPopupRows(fullBillPopupKeyword, false);

			setTimeout(function() {
				if (search) {
					search.focus();
					search.select();
				}
			}, 50);
		}

		// เปิดหน้าเพิ่ม/แก้ไข billing info โดยแนบ customer_id/billing_id ไปใน query string เมื่อมีข้อมูล
		// หมายเหตุ: billing_id ยังใช้เพื่อเปิด record เดิมในหน้าจัดการข้อมูลบิลเท่านั้น
		// แต่ใน flow บันทึกเอกสารปัจจุบันได้พักการใช้งาน billing_id ไว้ชั่วคราวแล้ว
		function openBillingInfoCreatePage(customerId, billingId) {
			var url = 'billing_info_add.php';
			if (customerId) {
				url += '?customer_id=' + encodeURIComponent(customerId);
				if (billingId) {
					url += '&billing_id=' + encodeURIComponent(billingId);
				}
			}
			window.open(url, '_blank');
		}

		// บังคับให้มี customer ก่อนจึงจะสร้าง shipping address ใหม่ได้ เพราะ shipping ผูกกับ customer โดยตรง
		function openShippingAddressCreatePage(customerId) {
			var resolvedCustomerId = String(customerId || getCurrentShippingPopupCustomerId() || '').trim();
			if (!resolvedCustomerId) {
				alert('กรุณาเลือกลูกค้าก่อนเพิ่มที่อยู่จัดส่ง');
				return;
			}
			var url = 'shipping_info_add.php';
			url += '?customer_id=' + encodeURIComponent(resolvedCustomerId);
			window.open(url, '_blank');
		}

		function toggleSaveToCustomerDb(btn) {
			var customerId = getCurrentShippingPopupCustomerId();
			if (!customerId) {
				alert('เลือกลูกค้าก่อน');
				return;
			}
			var hiddenInput = document.getElementById('save_to_customer_db');
			if (!hiddenInput) return;

			if (hiddenInput.value === '1') {
				hiddenInput.value = '0';
				btn.style.backgroundColor = '#FFFFFF';
				btn.style.color = '#612989';
				btn.style.borderColor = '#EBEBEB';
				btn.innerHTML = '<img src="img/icons/database.png" alt="database" style="width: 16px; height: 16px;"> เพิ่มลงฐานลูกค้า';
			} else {
				hiddenInput.value = '1';
				btn.style.backgroundColor = '#612989';
				btn.style.color = '#FFFFFF';
				btn.style.borderColor = '#612989';
				btn.innerHTML = '<i class="fas fa-check"></i> เพิ่มลงฐานลูกค้า (เลือกแล้ว)';
			}
		}

		// ปิด modal ข้อมูลออกบิล และคืนสถานะ checkbox full_bill หากผู้ใช้ยกเลิกการเลือก
		function closeFullBillPopup(keepChecked) {
			var modal = document.getElementById('fullBillPopupModal');
			var checkbox = document.getElementById('full_bill');
			if (!modal) return;

			modal.style.display = 'none';
			modal.setAttribute('aria-hidden', 'true');

			if (!keepChecked && checkbox) {
				checkbox.checked = fullBillPopupPreviousChecked;
				updateToggleStyle(checkbox);
			}
		}

		// รวม logic หา customer_id ปัจจุบันจากหลาย source:
		// 1) รายการที่เพิ่งเลือกจาก popup
		// 2) hidden/input ที่ถูก fill ไว้ในฟอร์ม
		// 3) ข้อความที่แสดงบนหน้าจอ
		function getCurrentShippingPopupCustomerId() {
			var hiddenBillId = document.getElementById('h_bill_id');
			var billId = document.getElementById('bill_id');
			var displayBillId = document.getElementById('display_bill_id');
			var popupCustomerId = '';
			if (window.customerPopupSelected && window.customerPopupSelected.customer_id) {
				popupCustomerId = window.customerPopupSelected.customer_id;
			}
			if (!popupCustomerId && window.fullBillPopupSelected && window.fullBillPopupSelected.customer_id) {
				popupCustomerId = window.fullBillPopupSelected.customer_id;
			}
			return String(
				popupCustomerId ||
				(hiddenBillId && hiddenBillId.value) ||
				(billId && billId.value) ||
				(displayBillId && displayBillId.textContent) ||
				''
			).trim();
		}

		// เปิดหน้าจัดการที่อยู่จัดส่งเดิม โดยต้องมี customer ปัจจุบันก่อนเสมอ
		function openShippingAddressManagePage(shippingId) {
			var customerId = getCurrentShippingPopupCustomerId();
			if (!customerId) {
				alert('กรุณาเลือกลูกค้าก่อนจัดการที่อยู่จัดส่ง');
				return;
			}
			var url = 'shipping_info_add.php?customer_id=' + encodeURIComponent(customerId);
			if (shippingId) {
				url += '&shipping_id=' + encodeURIComponent(shippingId);
			}
			window.open(url, '_blank');
		}

		// เปิด modal ที่อยู่จัดส่ง:
		// - เก็บ snapshot ค่าจัดส่งเดิมครั้งแรกไว้ใน window.originalShippingData
		// - reset state ของ popup
		// - query ข้อมูล shipping address ของ customer ปัจจุบัน
		function openShippingAddressPopup() {
			var customerId = getCurrentShippingPopupCustomerId();
			var modal = document.getElementById('shippingAddressPopupModal');
			var search = document.getElementById('shippingAddressPopupSearch');
			var tbody = document.getElementById('shippingAddressPopupRows');
			if (!modal || !tbody) return;

			// เก็บค่าเดิมจากฟอร์มไว้เพื่อใช้ revert หรือ fallback เมื่อผู้ใช้ยังไม่เลือกที่อยู่ใหม่
			if (!window.originalShippingData) {
				var contactName = document.querySelector('input[name="contact_name"]');
				var contactTel = document.querySelector('input[name="contact_tel"]');
				var contactProvince = document.querySelector('select[name="contact_province"]');
				var shippingAddress = document.querySelector('input[name="shipping_address"]');
				var installLocation = document.querySelector('input[name="install_location"]');

				window.originalShippingData = {
					customer_name: contactName ? contactName.value : '',
					customer_tel: contactTel ? contactTel.value : '',
					shipping_name: contactName ? contactName.value : '',
					shipping_province: contactProvince ? contactProvince.value : '',
					shipping_full_address: shippingAddress ? shippingAddress.value : '',
					install_location: installLocation ? installLocation.value : ''
				};
			}

			shippingAddressPopupCustomerId = customerId;
			shippingAddressPopupSelected = null;
			shippingAddressPopupData = [];
			shippingAddressPopupNextLastId = null;
			shippingAddressPopupHasMore = false;
			shippingAddressPopupKeyword = search ? (search.value || '') : '';
			toggleShippingAddressPopupLoadMore(false, false);
			modal.style.display = 'flex';
			modal.setAttribute('aria-hidden', 'false');

			loadShippingAddressPopupRows(shippingAddressPopupKeyword, false);
			setTimeout(function() {
				if (search) {
					search.focus();
					search.select();
				}
			}, 50);
		}

		// ปิด modal ที่อยู่จัดส่งโดยไม่แตะค่าบนฟอร์มหลัก
		function closeShippingAddressPopup() {
			var modal = document.getElementById('shippingAddressPopupModal');
			if (!modal) return;

			modal.style.display = 'none';
			modal.setAttribute('aria-hidden', 'true');
		}

		// Escape HTML ก่อน render string จากฐานข้อมูลลง innerHTML เพื่อลดความเสี่ยง XSS ฝั่ง client
		function escapeCustomerPopupHtml(value) {
			return String(value || '').replace(/[&<>"']/g, function(char) {
				return {
					'&': '&amp;',
					'<': '&lt;',
					'>': '&gt;',
					'"': '&quot;',
					"'": '&#039;'
				} [char];
			});
		}

		// ควบคุมปุ่ม "โหลดเพิ่ม" ของ popup ลูกค้า ทั้งสถานะการแสดงผลและสถานะ loading
		function toggleCustomerPopupLoadMore(visible, loading) {
			var wrap = document.getElementById('customerPopupPagination');
			var button = document.getElementById('customerPopupLoadMore');
			if (!wrap || !button) return;

			wrap.style.display = visible ? 'flex' : 'none';
			button.disabled = !!loading;
			button.textContent = loading ? 'กำลังโหลด...' : 'โหลดเพิ่ม';
		}

		// ควบคุมปุ่ม "โหลดเพิ่ม" ของ popup ข้อมูลออกบิล
		function toggleFullBillPopupLoadMore(visible, loading) {
			var wrap = document.getElementById('fullBillPopupPagination');
			var button = document.getElementById('fullBillPopupLoadMore');
			if (!wrap || !button) return;

			wrap.style.display = visible ? 'flex' : 'none';
			button.disabled = !!loading;
			button.textContent = loading ? 'กำลังโหลด...' : 'โหลดเพิ่ม';
		}

		// Render ตารางลูกค้า:
		// - ถ้าไม่มีข้อมูล แสดง empty state
		// - ถ้ามีข้อมูล สร้าง row และผูก event สำหรับเลือก/แก้ไข
		// - ถ้ามี customer ที่ถูกเลือกอยู่แล้ว จะ mark แถวเดิมกลับเข้าไป
		function renderCustomerPopupRows(customers) {
			var tbody = document.getElementById('customerPopupRows');
			if (!tbody) return;

			customers = customers || customerPopupData || [];

			if (!customers || customers.length === 0) {
				tbody.innerHTML = '<tr><td colspan="4" class="customer-popup-empty">ไม่พบข้อมูลลูกค้า</td></tr>';
				toggleCustomerPopupLoadMore(false, false);
				return;
			}

			tbody.innerHTML = customers.map(function(customer, index) {
				var name = customer.customer_name || customer.bill_name || '-';
				var tel = customer.cus_tel || '-';
				var address = customer.cus_address || '-';

				return '<tr data-index="' + index + '" onclick="selectCustomerPopupRow(' + index + ')">' +
					'<td><button type="button" class="customer-popup-name" onclick="event.stopPropagation(); selectCustomerPopupRow(' + index + ');">' + escapeCustomerPopupHtml(name) + '</button></td>' +
					'<td>' + escapeCustomerPopupHtml(tel) + '</td>' +
					'<td>' + escapeCustomerPopupHtml(address) + '</td>' +
					'<td><button type="button" class="customer-popup-name" onclick="event.stopPropagation(); openCustomerPopupEdit(' + index + ');"><img src="img/icons/edit.png?v=20260610" alt="แก้ไข" style="width:18px;height:18px;object-fit:contain;"></button></td>' +
					'</tr>';
			}).join('');

			customerPopupData = customers;
			window.customerPopupData = customers;

			if (customerPopupSelected && customerPopupSelected.customer_id) {
				var rows = document.querySelectorAll('#customerPopupRows tr');
				rows.forEach(function(row) {
					row.classList.remove('selected');
				});
				for (var i = 0; i < customerPopupData.length; i++) {
					if (String(customerPopupData[i].customer_id) === String(customerPopupSelected.customer_id)) {
						if (rows[i]) rows[i].classList.add('selected');
						break;
					}
				}
			}

			toggleCustomerPopupLoadMore(customerPopupHasMore, false);
		}

		// โหลดลูกค้าจาก backend แบบ initial load หรือ append สำหรับ pagination
		function loadCustomerPopupRows(keyword, append) {
			var tbody = document.getElementById('customerPopupRows');
			if (customerPopupLoading) return;
			customerPopupLoading = true;

			// initial search จะแสดง loading state ในตาราง ส่วน append จะคงข้อมูลเดิมไว้
			if (!append && tbody) {
				tbody.innerHTML = '<tr><td colspan="4" class="customer-popup-empty">กำลังค้นหา...</td></tr>';
			}

			if (!append) {
				customerPopupSelected = null;
				customerPopupData = [];
				customerPopupNextLastId = null;
				customerPopupHasMore = false;
				customerPopupKeyword = keyword || '';
			}

			toggleCustomerPopupLoadMore(append || customerPopupHasMore, append);

			var requestUrl = 'ajax_customer_popup_search.php?q=' + encodeURIComponent(customerPopupKeyword || '') +
				'&limit=' + encodeURIComponent(customerPopupPageSize);

			if (append && customerPopupNextLastId) {
				requestUrl += '&last_id=' + encodeURIComponent(customerPopupNextLastId);
			}

			// ใช้ last_id เป็น cursor สำหรับ "โหลดเพิ่ม" แทนการ reload ทั้งชุด
			fetch(requestUrl, {
					credentials: 'same-origin'
				})
				.then(function(response) {
					return response.json();
				})
				.then(function(data) {
					if (!data || !data.success) {
						customerPopupData = [];
						customerPopupHasMore = false;
						customerPopupNextLastId = null;
						renderCustomerPopupRows([]);
						return;
					}

					var newCustomers = data.customers || [];
					customerPopupData = append ? customerPopupData.concat(newCustomers) : newCustomers;
					customerPopupHasMore = !!(data.pagination && data.pagination.has_more);
					customerPopupNextLastId = data.pagination ? data.pagination.next_last_id : null;
					renderCustomerPopupRows(customerPopupData);
				})
				.catch(function() {
					customerPopupHasMore = false;
					customerPopupNextLastId = null;
					if (tbody) {
						tbody.innerHTML = '<tr><td colspan="4" class="customer-popup-empty">ไม่สามารถค้นหาข้อมูลได้</td></tr>';
					}
					toggleCustomerPopupLoadMore(false, false);
				})
				.finally(function() {
					customerPopupLoading = false;
					if (customerPopupHasMore) {
						toggleCustomerPopupLoadMore(true, false);
					}
				});
		}

		// เปิดหน้าแก้ไขลูกค้าจากรายการที่เลือกใน popup
		function openCustomerPopupEdit(index) {
			var customer = (customerPopupData || [])[index];
			if (!customer || !customer.customer_id) {
				alert('ไม่พบรหัสลูกค้า');
				return;
			}

			window.open('customer_add.php?customer_id=' + encodeURIComponent(customer.customer_id), '_blank');
		}

		// wrapper สั้นๆ สำหรับ pagination ของ popup ลูกค้า
		function loadMoreCustomerPopupRows() {
			if (!customerPopupHasMore || !customerPopupNextLastId) return;
			loadCustomerPopupRows(customerPopupKeyword, true);
		}

		// ควบคุมปุ่ม "โหลดเพิ่ม" ของ popup ที่อยู่จัดส่ง
		function toggleShippingAddressPopupLoadMore(visible, loading) {
			var wrap = document.getElementById('shippingAddressPopupPagination');
			var button = document.getElementById('shippingAddressPopupLoadMore');
			if (!wrap || !button) return;

			wrap.style.display = visible ? 'flex' : 'none';
			button.disabled = !!loading;
			button.textContent = loading ? 'กำลังโหลด...' : 'โหลดเพิ่ม';
		}

		// Render ตารางที่อยู่จัดส่งและจำแถวที่เลือกไว้ผ่าน selection key ของแต่ละ row
		function renderShippingAddressPopupRows(addresses) {
			var tbody = document.getElementById('shippingAddressPopupRows');
			if (!tbody) return;

			addresses = addresses || shippingAddressPopupData || [];
			if (!addresses.length) {
				tbody.innerHTML = '<tr><td colspan="7" class="customer-popup-empty">ไม่พบข้อมูลที่อยู่จัดส่ง</td></tr>';
				shippingAddressPopupSelected = null;
				toggleShippingAddressPopupLoadMore(false, false);
				return;
			}

			var selectedKey = shippingAddressPopupSelected ? String(shippingAddressPopupSelected.__selectionKey || shippingAddressPopupSelected.row_id) : '';
			var rowsHtml = [];

			rowsHtml = rowsHtml.concat(addresses.map(function(address, index) {
				address.__selectionKey = address.row_id ? ('row-' + address.row_id) : ('customer-' + (address.customer_id || '0') + '-' + index);
				var customerCode = address.customer_code || '-';
				var customerName = address.customer_name || '-';
				var phone = address.shipping_tel || address.customer_tel || '-';
				var shippingName = address.shipping_name || customerName;
				var fullAddress = address.shipping_full_address || address.shipping_address || '-';
				var rowClass = selectedKey === address.__selectionKey ? 'selected' : '';
				var isChecked = selectedKey === address.__selectionKey ? 'checked' : '';

				return '<tr class="' + rowClass + '" data-index="' + index + '" onclick="selectShippingAddressPopupRow(' + index + ')">' +
					'<td class="shipping-popup-select-cell" style="text-align: center;">' +
					'<label class="shipping-custom-radio" onclick="event.stopPropagation();">' +
					'<input type="radio" class="shipping-popup-radio-input" name="shipping_popup_choice" ' + isChecked + ' onclick="selectShippingAddressPopupRow(' + index + ')">' +
					'<span class="checkmark"></span>' +
					'</label>' +
					'</td>' +
					'<td>' + escapeCustomerPopupHtml(customerCode) + '</td>' +
					'<td>' + escapeCustomerPopupHtml(customerName) + '</td>' +
					'<td>' + escapeCustomerPopupHtml(phone) + '</td>' +
					'<td>' + escapeCustomerPopupHtml(shippingName) + '</td>' +
					'<td>' + escapeCustomerPopupHtml(fullAddress) + '</td>' +
					'<td><button type="button" class="customer-popup-name" onclick="event.stopPropagation(); openShippingAddressManagePage(\'' + (address.row_id || '') + '\');"><img src="img/icons/edit.png?v=20260610" alt="แก้ไข" style="width:18px;height:18px;object-fit:contain;"></button></td>' +
					'</tr>';
			}));

			tbody.innerHTML = rowsHtml.join('');
			shippingAddressPopupData = addresses;
			if (!shippingAddressPopupSelected && addresses.length > 0) {
				// Select first row by default
				selectShippingAddressPopupRow(0);
			}

			toggleShippingAddressPopupLoadMore(shippingAddressPopupHasMore, false);
		}

		function loadShippingAddressPopupRows(keyword, append) {
			var tbody = document.getElementById('shippingAddressPopupRows');
			if (shippingAddressPopupLoading) return;
			shippingAddressPopupLoading = true;

			if (!append && tbody) {
				tbody.innerHTML = '<tr><td colspan="7" class="customer-popup-empty">กำลังค้นหา...</td></tr>';
			}

			if (!append) {
				shippingAddressPopupSelected = null;
				shippingAddressPopupData = [];
				shippingAddressPopupNextLastId = null;
				shippingAddressPopupHasMore = false;
				shippingAddressPopupKeyword = keyword || '';
			}

			toggleShippingAddressPopupLoadMore(append || shippingAddressPopupHasMore, append);

			var requestUrl = 'ajax_shipping_address_popup_search.php?customer_id=' + encodeURIComponent(shippingAddressPopupCustomerId) +
				'&q=' + encodeURIComponent(shippingAddressPopupKeyword || '') +
				'&limit=' + encodeURIComponent(shippingAddressPopupPageSize);

			if (append && shippingAddressPopupNextLastId) {
				requestUrl += '&last_id=' + encodeURIComponent(shippingAddressPopupNextLastId);
			}

			fetch(requestUrl, {
					credentials: 'same-origin'
				})
				.then(function(response) {
					return response.json();
				})
				.then(function(data) {
					if (!data || !data.success) {
						shippingAddressPopupData = [];
						shippingAddressPopupHasMore = false;
						shippingAddressPopupNextLastId = null;
						renderShippingAddressPopupRows([]);
						return;
					}

					var newAddresses = data.addresses || [];
					shippingAddressPopupData = append ? shippingAddressPopupData.concat(newAddresses) : newAddresses;
					shippingAddressPopupHasMore = !!(data.pagination && data.pagination.has_more);
					shippingAddressPopupNextLastId = data.pagination ? data.pagination.next_last_id : null;
					renderShippingAddressPopupRows(shippingAddressPopupData);
				})
				.catch(function() {
					shippingAddressPopupHasMore = false;
					shippingAddressPopupNextLastId = null;
					if (tbody) {
						tbody.innerHTML = '<tr><td colspan="7" class="customer-popup-empty">ไม่สามารถค้นหาข้อมูลได้</td></tr>';
					}
					toggleShippingAddressPopupLoadMore(false, false);
				})
				.finally(function() {
					shippingAddressPopupLoading = false;
					if (shippingAddressPopupHasMore) {
						toggleShippingAddressPopupLoadMore(true, false);
					}
				});
		}

		function loadMoreShippingAddressPopupRows() {
			if (!shippingAddressPopupHasMore || !shippingAddressPopupNextLastId) return;
			loadShippingAddressPopupRows(shippingAddressPopupKeyword, true);
		}

		function selectShippingAddressPopupRow(index) {
			var rows = document.querySelectorAll('#shippingAddressPopupRows tr');
			var address = (shippingAddressPopupData || [])[index];
			if (!address) return;

			rows.forEach(function(row) {
				row.classList.remove('selected');
			});
			var rowPosition = index;
			if (rows[rowPosition]) rows[rowPosition].classList.add('selected');
			var radios = document.querySelectorAll('input[name="shipping_popup_choice"]');
			radios.forEach(function(radio, radioIndex) {
				radio.checked = radioIndex === rowPosition;
			});
			shippingAddressPopupSelected = address;
		}

		function confirmShippingAddressPopupSelection() {
			if (!shippingAddressPopupSelected) {
				alert('กรุณาเลือกที่อยู่จัดส่งก่อน');
				return;
			}

			applyShippingSelection(shippingAddressPopupSelected);
			closeShippingAddressPopup();
		}

		function renderShippingAddressPopupRowsLegacyMulti(addresses) {
			var tbody = document.getElementById('shippingAddressPopupRows');
			var selectAllCheckbox = document.getElementById('shippingAddressSelectAll');
			if (!tbody) return;

			addresses = addresses || shippingAddressPopupData || [];
			if (!addresses.length) {
				tbody.innerHTML = '<tr><td colspan="7" class="customer-popup-empty">ไม่พบข้อมูลที่อยู่จัดส่ง</td></tr>';
				shippingAddressPopupSelected = [];
				shippingAddressPopupSelectedKeys = [];
				if (selectAllCheckbox) {
					selectAllCheckbox.checked = false;
					selectAllCheckbox.indeterminate = false;
				}
				toggleShippingAddressPopupLoadMore(false, false);
				return;
			}

			var selectedKeys = Array.isArray(shippingAddressPopupSelectedKeys) ? shippingAddressPopupSelectedKeys.slice() : [];
			tbody.innerHTML = addresses.map(function(address, index) {
				address.__selectionKey = address.row_id ? ('row-' + address.row_id) : ('customer-' + (address.customer_id || '0') + '-' + index);
				var isChecked = selectedKeys.indexOf(address.__selectionKey) !== -1;
				var customerCode = address.customer_code || '-';
				var customerName = address.customer_name || '-';
				var phone = address.shipping_tel || address.customer_tel || '-';
				var shippingName = address.shipping_name || customerName;
				var fullAddress = address.shipping_full_address || address.shipping_address || '-';

				return '<tr class="' + (isChecked ? 'selected' : '') + '" data-index="' + index + '" onclick="selectShippingAddressPopupRow(' + index + ')">' +
					'<td class="shipping-popup-select-cell"><input type="checkbox" class="shipping-popup-checkbox-input" ' + (isChecked ? 'checked' : '') + ' onclick="event.stopPropagation(); selectShippingAddressPopupRow(' + index + ')"></td>' +
					'<td>' + escapeCustomerPopupHtml(customerCode) + '</td>' +
					'<td>' + escapeCustomerPopupHtml(customerName) + '</td>' +
					'<td>' + escapeCustomerPopupHtml(phone) + '</td>' +
					'<td>' + escapeCustomerPopupHtml(shippingName) + '</td>' +
					'<td>' + escapeCustomerPopupHtml(fullAddress) + '</td>' +
					'<td><button type="button" class="customer-popup-name" onclick="event.stopPropagation(); openShippingAddressManagePage();"><img src="img/icons/edit.png?v=20260610" alt="แก้ไข" style="width:18px;height:18px;object-fit:contain;"></button></td>' +
					'</tr>';
			}).join('');

			shippingAddressPopupData = addresses;
			shippingAddressPopupSelectedKeys = shippingAddressPopupData.map(function(address) {
				return address.__selectionKey;
			}).filter(function(key) {
				return selectedKeys.indexOf(key) !== -1;
			});
			shippingAddressPopupSelected = shippingAddressPopupData.filter(function(address) {
				return shippingAddressPopupSelectedKeys.indexOf(address.__selectionKey) !== -1;
			});

			if (selectAllCheckbox) {
				var totalCount = shippingAddressPopupData.length;
				var selectedCount = shippingAddressPopupSelectedKeys.length;
				selectAllCheckbox.checked = totalCount > 0 && selectedCount === totalCount;
				selectAllCheckbox.indeterminate = selectedCount > 0 && selectedCount < totalCount;
			}

			toggleShippingAddressPopupLoadMore(shippingAddressPopupHasMore, false);
		}

		function loadShippingAddressPopupRowsLegacyMulti(keyword, append) {
			var tbody = document.getElementById('shippingAddressPopupRows');
			if (shippingAddressPopupLoading) return;
			shippingAddressPopupLoading = true;

			if (!append && tbody) {
				tbody.innerHTML = '<tr><td colspan="7" class="customer-popup-empty">กำลังค้นหา...</td></tr>';
			}

			if (!append) {
				shippingAddressPopupSelected = [];
				shippingAddressPopupSelectedKeys = [];
				shippingAddressPopupData = [];
				shippingAddressPopupNextLastId = null;
				shippingAddressPopupHasMore = false;
				shippingAddressPopupKeyword = keyword || '';
			}

			toggleShippingAddressPopupLoadMore(append || shippingAddressPopupHasMore, append);

			var requestUrl = 'ajax_shipping_address_popup_search.php?customer_id=' + encodeURIComponent(shippingAddressPopupCustomerId) +
				'&q=' + encodeURIComponent(shippingAddressPopupKeyword || '') +
				'&limit=' + encodeURIComponent(shippingAddressPopupPageSize);

			if (append && shippingAddressPopupNextLastId) {
				requestUrl += '&last_id=' + encodeURIComponent(shippingAddressPopupNextLastId);
			}

			fetch(requestUrl, {
					credentials: 'same-origin'
				})
				.then(function(response) {
					return response.json();
				})
				.then(function(data) {
					if (!data || !data.success) {
						shippingAddressPopupData = [];
						shippingAddressPopupHasMore = false;
						shippingAddressPopupNextLastId = null;
						renderShippingAddressPopupRows([]);
						return;
					}

					var newAddresses = data.addresses || [];
					shippingAddressPopupData = append ? shippingAddressPopupData.concat(newAddresses) : newAddresses;
					shippingAddressPopupHasMore = !!(data.pagination && data.pagination.has_more);
					shippingAddressPopupNextLastId = data.pagination ? data.pagination.next_last_id : null;
					renderShippingAddressPopupRows(shippingAddressPopupData);
				})
				.catch(function() {
					shippingAddressPopupHasMore = false;
					shippingAddressPopupNextLastId = null;
					if (tbody) {
						tbody.innerHTML = '<tr><td colspan="7" class="customer-popup-empty">ไม่สามารถค้นหาข้อมูลได้</td></tr>';
					}
					toggleShippingAddressPopupLoadMore(false, false);
				})
				.finally(function() {
					shippingAddressPopupLoading = false;
					if (shippingAddressPopupHasMore) {
						toggleShippingAddressPopupLoadMore(true, false);
					}
				});
		}

		function toggleShippingAddressSelectAllLegacyMulti(checked) {
			var availableKeys = (shippingAddressPopupData || []).map(function(address) {
				return address.__selectionKey;
			});
			shippingAddressPopupSelectedKeys = checked ? availableKeys.slice() : [];
			shippingAddressPopupSelected = (shippingAddressPopupData || []).filter(function(address) {
				return shippingAddressPopupSelectedKeys.indexOf(address.__selectionKey) !== -1;
			});
			renderShippingAddressPopupRows(shippingAddressPopupData);
		}

		function selectShippingAddressPopupRowLegacyMulti(index) {
			var address = (shippingAddressPopupData || [])[index];
			if (!address) return;

			var selectedKeys = Array.isArray(shippingAddressPopupSelectedKeys) ? shippingAddressPopupSelectedKeys.slice() : [];
			var keyIndex = selectedKeys.indexOf(address.__selectionKey);
			if (keyIndex === -1) {
				selectedKeys.push(address.__selectionKey);
			} else {
				selectedKeys.splice(keyIndex, 1);
			}

			shippingAddressPopupSelectedKeys = selectedKeys;
			shippingAddressPopupSelected = (shippingAddressPopupData || []).filter(function(item) {
				return shippingAddressPopupSelectedKeys.indexOf(item.__selectionKey) !== -1;
			});
			renderShippingAddressPopupRows(shippingAddressPopupData);
		}

		function confirmShippingAddressPopupSelectionLegacyMulti() {
			if (!shippingAddressPopupSelected || !shippingAddressPopupSelected.length) {
				alert('กรุณาเลือกที่อยู่จัดส่งก่อน');
				return;
			}

			applyShippingSelection(shippingAddressPopupSelected);
			closeShippingAddressPopup();
		}

		function renderFullBillPopupRows(customers) {
			var tbody = document.getElementById('fullBillPopupRows');
			if (!tbody) return;

			customers = customers || fullBillPopupData || [];

			if (!customers || customers.length === 0) {
				tbody.innerHTML = '<tr><td colspan="5" class="customer-popup-empty">ไม่พบข้อมูลออกบิล</td></tr>';
				toggleFullBillPopupLoadMore(false, false);
				return;
			}

			tbody.innerHTML = customers.map(function(customer, index) {
				var name = customer.customer_name || customer.bill_name || '-';
				var tel = customer.cus_tel || customer.bill_tel || '-';
				var billDetail = customer.bill_name || '-';
				if (customer.bill_address) {
					billDetail += ' ' + customer.bill_address;
				}
				var taxId = customer.tax_id || '-';

				return '<tr data-index="' + index + '" onclick="selectFullBillPopupRow(' + index + ')">' +
					'<td><button type="button" class="customer-popup-name" onclick="event.stopPropagation(); selectFullBillPopupRow(' + index + ');">' + escapeCustomerPopupHtml(name) + '</button></td>' +
					'<td>' + escapeCustomerPopupHtml(tel) + '</td>' +
					'<td>' + escapeCustomerPopupHtml(billDetail) + '</td>' +
					'<td>' + escapeCustomerPopupHtml(taxId) + '</td>' +
					'<td><button type="button" class="customer-popup-name" onclick="event.stopPropagation(); openFullBillPopupEdit(' + index + ');"><img src="img/icons/edit.png?v=20260610" alt="แก้ไข" style="width:18px;height:18px;object-fit:contain;"></button></td>' +
					'</tr>';
			}).join('');

			fullBillPopupData = customers;

			if (fullBillPopupSelected && fullBillPopupSelected.customer_id) {
				var rows = document.querySelectorAll('#fullBillPopupRows tr');
				rows.forEach(function(row) {
					row.classList.remove('selected');
				});
				for (var i = 0; i < fullBillPopupData.length; i++) {
					if (String(fullBillPopupData[i].customer_id) === String(fullBillPopupSelected.customer_id)) {
						if (rows[i]) rows[i].classList.add('selected');
						break;
					}
				}
			}

			toggleFullBillPopupLoadMore(fullBillPopupHasMore, false);
		}

		function loadFullBillPopupRows(keyword, append) {
			var tbody = document.getElementById('fullBillPopupRows');
			if (fullBillPopupLoading) return;
			fullBillPopupLoading = true;

			if (!append && tbody) {
				tbody.innerHTML = '<tr><td colspan="5" class="customer-popup-empty">กำลังค้นหา...</td></tr>';
			}

			if (!append) {
				fullBillPopupSelected = null;
				fullBillPopupData = [];
				fullBillPopupNextLastId = null;
				fullBillPopupHasMore = false;
				fullBillPopupKeyword = keyword || '';
			}

			toggleFullBillPopupLoadMore(append || fullBillPopupHasMore, append);

			var requestUrl = 'ajax_fullbill_popup_search.php?q=' + encodeURIComponent(fullBillPopupKeyword || '') +
				'&limit=' + encodeURIComponent(fullBillPopupPageSize);

			if (append && fullBillPopupNextLastId) {
				requestUrl += '&last_id=' + encodeURIComponent(fullBillPopupNextLastId);
			}

			fetch(requestUrl, {
					credentials: 'same-origin'
				})
				.then(function(response) {
					return response.json();
				})
				.then(function(data) {
					if (!data || !data.success) {
						fullBillPopupData = [];
						fullBillPopupHasMore = false;
						fullBillPopupNextLastId = null;
						renderFullBillPopupRows([]);
						return;
					}

					var newCustomers = data.customers || [];
					fullBillPopupData = append ? fullBillPopupData.concat(newCustomers) : newCustomers;
					fullBillPopupHasMore = !!(data.pagination && data.pagination.has_more);
					fullBillPopupNextLastId = data.pagination ? data.pagination.next_last_id : null;
					renderFullBillPopupRows(fullBillPopupData);
				})
				.catch(function() {
					fullBillPopupHasMore = false;
					fullBillPopupNextLastId = null;
					if (tbody) {
						tbody.innerHTML = '<tr><td colspan="5" class="customer-popup-empty">ไม่สามารถค้นหาข้อมูลได้</td></tr>';
					}
					toggleFullBillPopupLoadMore(false, false);
				})
				.finally(function() {
					fullBillPopupLoading = false;
					if (fullBillPopupHasMore) {
						toggleFullBillPopupLoadMore(true, false);
					}
				});
		}

		function loadMoreFullBillPopupRows() {
			if (!fullBillPopupHasMore || !fullBillPopupNextLastId) return;
			loadFullBillPopupRows(fullBillPopupKeyword, true);
		}

		function selectFullBillPopupRow(index) {
			var rows = document.querySelectorAll('#fullBillPopupRows tr');
			var customer = (fullBillPopupData || [])[index];
			if (!customer) return;

			rows.forEach(function(row) {
				row.classList.remove('selected');
			});
			if (rows[index]) rows[index].classList.add('selected');
			fullBillPopupSelected = customer;
		}

		function openFullBillPopupEdit(index) {
			var customer = (fullBillPopupData || [])[index];
			if (!customer || !customer.customer_id) {
				alert('ไม่พบรหัสลูกค้า');
				return;
			}

			// billing_id ตรงนี้ใช้เพื่อเปิดรายการ billing address เดิมให้แก้ไขได้ตรง record
			// ไม่ได้ถูกส่งต่อไปใช้บันทึกลง tb_register_data ใน flow ปัจจุบัน
			openBillingInfoCreatePage(customer.customer_id, customer.billing_id || '');
		}

		function confirmFullBillPopupSelection() {
			if (!fullBillPopupSelected) {
				alert('กรุณาเลือกข้อมูลออกบิลก่อน');
				return;
			}

			if (!String(fullBillPopupSelected.customer_id || '').trim()) {
				alert('ข้อมูลออกบิลที่เลือกไม่มีรหัสลูกค้า');
				return;
			}

			var selectedCustId = fullBillPopupSelected.customer_id || '';

			doCallAjax1(selectedCustId, 'bill_name', 'bill_address', 'bill_tel', 'tax_id', 'pre_name', 'mode_name', 'email', 'customer_typename', 'payment', 'credit_thb', 'billing', function(success, missingFields) {
				if (!success) {
					var missingMessage = (missingFields && missingFields.length) ? missingFields.join(', ') : 'ข้อมูลออกบิลไม่ครบถ้วน';
					alert('ไม่สามารถดึงข้อมูลออกบิลได้ครบ: ' + missingMessage);
					return;
				}
				var checkbox = document.getElementById('full_bill');
				if (checkbox) {
					checkbox.checked = true;
					updateToggleStyle(checkbox);
				}
				closeFullBillPopup(true);
			});
		}

		function handleBillingInfoCreated(customerId) {
			var resolvedId = String(customerId || '').trim();
			var checkbox = document.getElementById('full_bill');

			if (!resolvedId) {
				loadFullBillPopupRows('', false);
				return;
			}

			if (checkbox) {
				checkbox.checked = true;
				updateToggleStyle(checkbox);
			}

			doCallAjax1(resolvedId, 'bill_name', 'bill_address', 'bill_tel', 'tax_id', 'pre_name', 'mode_name', 'email', 'customer_typename', 'payment', 'credit_thb', 'billing', function(success) {
				if (success) {
					closeFullBillPopup(true);
				}
				loadFullBillPopupRows('', false);
			});
		}

		function selectCustomerPopupRow(index) {
			var rows = document.querySelectorAll('#customerPopupRows tr');
			var customer = (customerPopupData || [])[index];
			if (!customer) return;

			rows.forEach(function(row) {
				row.classList.remove('selected');
			});
			if (rows[index]) rows[index].classList.add('selected');
			customerPopupSelected = customer;
		}

		function confirmCustomerPopupSelection() {
			if (!customerPopupSelected) {
				alert('กรุณาเลือกลูกค้าก่อน');
				return;
			}

			if (!String(customerPopupSelected.customer_id || '').trim()) {
				alert('ข้อมูลลูกค้าที่เลือกไม่มีรหัสลูกค้า');
				return;
			}

			var billId = document.getElementById('bill_id');
			if (billId) {
				console.log(billId);
				billId.value = customerPopupSelected.customer_id || '';
			}
			var hiddenBillId = document.getElementById('h_bill_id');
			if (hiddenBillId) {
				hiddenBillId.value = customerPopupSelected.customer_id || '';
			}
			var displayBillId = document.getElementById('display_bill_id');
			if (displayBillId) {
				displayBillId.textContent = customerPopupSelected.customer_id || '';
			}

			doCallAjax1('bill_id', 'bill_name', 'bill_address', 'bill_tel', 'tax_id', 'pre_name', 'mode_name', 'email', 'customer_typename', 'payment', 'credit_thb', undefined, function(success, missingFields) {
				if (!success) {
					var missingMessage = (missingFields && missingFields.length) ? missingFields.join(', ') : 'ข้อมูลลูกค้าไม่ครบถ้วน';
					alert('ไม่สามารถดึงข้อมูลลูกค้าได้ครบ: ' + missingMessage);
					return;
				}
				closeCustomerPopup();
			});
		}

		document.addEventListener('DOMContentLoaded', function() {
			syncCreditTermTriggerState();
			var search = document.getElementById('customerPopupSearch');
			var customerModal = document.getElementById('customerPopupModal');
			var fullBillCheckbox = document.getElementById('full_bill');
			var fullBillSearch = document.getElementById('fullBillPopupSearch');
			var fullBillModal = document.getElementById('fullBillPopupModal');
			var shippingAddressSearch = document.getElementById('shippingAddressPopupSearch');
			var shippingAddressModal = document.getElementById('shippingAddressPopupModal');
			var creditTermTrigger = document.getElementById('display_credit_thb_trigger');
			var creditTermModal = document.getElementById('creditTermPopupModal');
			var clearLoanSearch = document.getElementById('clearLoanSearch');
			var clearLoanModal = document.getElementById('clearLoanModal');
			var clearLoanTriggerButton = document.getElementById('clearLoanTriggerButton');

			bindShippingFieldMirrors();

			if (search) {
				search.addEventListener('input', function() {
					clearTimeout(customerPopupTimer);
					customerPopupTimer = setTimeout(function() {
						customerPopupSelected = null;
						loadCustomerPopupRows(search.value, false);
					}, 250);
				});
			}

			if (fullBillSearch) {
				fullBillSearch.addEventListener('input', function() {
					clearTimeout(fullBillPopupTimer);
					fullBillPopupTimer = setTimeout(function() {
						fullBillPopupSelected = null;
						loadFullBillPopupRows(fullBillSearch.value, false);
					}, 250);
				});
			}

			if (shippingAddressSearch) {
				shippingAddressSearch.addEventListener('input', function() {
					clearTimeout(shippingAddressPopupTimer);
					shippingAddressPopupTimer = setTimeout(function() {
						shippingAddressPopupSelected = null;
						loadShippingAddressPopupRows(shippingAddressSearch.value, false);
					}, 250);
				});
			}

			if (clearLoanSearch) {
				clearLoanSearch.addEventListener('input', scheduleClearLoanPopupSearch);
			}

			if (creditTermTrigger) {
				creditTermTrigger.addEventListener('click', invokeCreditTermPopupOpen);
				creditTermTrigger.addEventListener('keydown', function(event) {
					if (event.key === 'Enter' || event.key === ' ') {
						event.preventDefault();
						invokeCreditTermPopupOpen();
					}
				});
			}

			if (clearLoanTriggerButton) {
				clearLoanTriggerButton.addEventListener('click', function() {
					toggleClearSection();
				});
			}

			var clearLoanTypeInputs = document.getElementsByName('clear_loan_type');
			for (var clearLoanTypeIndex = 0; clearLoanTypeIndex < clearLoanTypeInputs.length; clearLoanTypeIndex++) {
				clearLoanTypeInputs[clearLoanTypeIndex].addEventListener('change', function() {
					loadClearLoanPopupRows();
				});
			}

			if (clearLoanModal) {
				clearLoanModal.addEventListener('change', function(event) {
					if (event.target && event.target.classList.contains('clear-loan-check-input')) {
						updateClearLoanSelectionSummary();
					}
				});
			}


			if (fullBillCheckbox) {
				fullBillCheckbox.addEventListener('change', function() {
					fullBillPopupPreviousChecked = !this.checked;
					updateToggleStyle(this);
					if (this.checked) {
						openFullBillPopup();
					}
				});
			}

			var haveOrderCheckbox = document.getElementById('have_order');
			var deliveryContractInput = document.getElementById('delivery_contract');
			if (haveOrderCheckbox && deliveryContractInput) {
				haveOrderCheckbox.addEventListener('change', updateDeliveryContractRequirement);
				deliveryContractInput.addEventListener('input', function() {
					if (deliveryContractInput.value !== '') {
						deliveryContractInput.setCustomValidity('');
					}
				});
				updateDeliveryContractRequirement();
			}

			['que_ckk', 'have_order', 'plan_ckk', 'repeat_cus', 'full_bill'].forEach(function(id) {
				var cb = document.getElementById(id);
				if (cb) {
					updateToggleStyle(cb);
				}
			});

			[{
					modal: customerModal,
					onClose: closeCustomerPopup
				},
				{
					modal: fullBillModal,
					onClose: function() {
						closeFullBillPopup(false);
					}
				},
				{
					modal: shippingAddressModal,
					onClose: closeShippingAddressPopup
				},
				{
					modal: creditTermModal,
					onClose: invokeCreditTermPopupClose
				}
			].forEach(function(entry) {
				if (!entry.modal) return;
				entry.modal.addEventListener('click', function(event) {
					if (event.target === entry.modal) {
						entry.onClose();
					}
				});
			});

			document.addEventListener('keydown', function(event) {
				if (event.key !== 'Escape') return;
				if (creditTermModal && creditTermModal.style.display === 'flex') {
					invokeCreditTermPopupClose();
				}
			});
		});

		function switchSoTab(evt, tabId) {
			evt.preventDefault();
			var i, tabcontent, tablinks;

			tabcontent = document.getElementsByClassName("so-tab-content");
			for (i = 0; i < tabcontent.length; i++) {
				tabcontent[i].classList.remove("active");
			}

			tablinks = document.getElementsByClassName("so-tab-btn");
			for (i = 0; i < tablinks.length; i++) {
				tablinks[i].classList.remove("active");
			}

			document.getElementById(tabId).classList.add("active");
			evt.currentTarget.classList.add("active");
		}

		function invokeCreditTermPopupOpen() {
			if (typeof window.openCreditTermPopup === 'function') {
				window.openCreditTermPopup();
				return;
			}

			var modal = document.getElementById('creditTermPopupModal');
			var trigger = document.getElementById('display_credit_thb_trigger');
			var tableBody = document.getElementById('creditTermTableBody');
			if (!modal || !trigger || trigger.disabled) return;
			modal.style.display = 'flex';
			modal.setAttribute('aria-hidden', 'false');
			if (typeof window.loadCreditTermModalData === 'function') {
				window.loadCreditTermModalData();
			} else if (tableBody) {
				tableBody.innerHTML = '<tr class="credit-term-empty-row"><td><span class="credit-term-caret" aria-hidden="true"></span></td><td colspan="5">ไม่สามารถโหลดสคริปต์เครดิตเทอมได้ กรุณารีเฟรชหน้าอีกครั้ง</td></tr>';
			}
		}

		function invokeCreditTermPopupClose() {
			if (typeof window.closeCreditTermPopup === 'function') {
				window.closeCreditTermPopup();
				return;
			}

			var modal = document.getElementById('creditTermPopupModal');
			if (!modal) return;
			modal.style.display = 'none';
			modal.setAttribute('aria-hidden', 'true');
		}
		function openClearLoanPopup() {
			var modal = document.getElementById('clearLoanModal');
			var search = document.getElementById('clearLoanSearch');
			if (!modal) return;

			modal.style.display = 'flex';
			modal.setAttribute('aria-hidden', 'false');
			loadClearLoanPopupRows(false);
			updateClearLoanSelectionSummary();
			setTimeout(function() {
				if (search) {
					search.focus();
					search.select();
				}
			}, 50);
		}

		function closeClearLoanPopup() {
			var modal = document.getElementById('clearLoanModal');
			if (!modal) return;

			modal.style.display = 'none';
			modal.setAttribute('aria-hidden', 'true');
		}

		function toggleClearSection() {
			var modal = document.getElementById('clearLoanModal');
			if (!modal || modal.style.display === 'flex') {
				closeClearLoanPopup();
				return;
			}

			openClearLoanPopup();
		}

		function escapeClearLoanHtml(value) {
			return String(value === undefined || value === null ? '' : value)
				.replace(/&/g, '&amp;')
				.replace(/</g, '&lt;')
				.replace(/>/g, '&gt;')
				.replace(/"/g, '&quot;')
				.replace(/'/g, '&#39;');
		}

		function getClearLoanSelectedType() {
			var checked = document.querySelector('input[name="clear_loan_type"]:checked');
			return checked ? checked.value : 'reserve';
		}

		function resetClearLoanPopupState() {
			clearLoanPopupDocuments = [];
			clearLoanPopupNextLastId = null;
			clearLoanPopupHasMore = false;
			clearLoanPopupLoadingMore = false;
			clearLoanPopupSelectedKeys = {};
			clearLoanPopupExpandedKeys = {};
		}

		function normalizeClearLoanDocument(documentRow) {
			var normalized = documentRow || {};
			normalized.doc_type = normalized.doc_type || clearLoanPopupType;
			normalized.internal_id = parseInt(normalized.internal_id, 10) || 0;
			normalized.document_key = normalized.document_key || ((normalized.doc_type || clearLoanPopupType) + ':' + normalized.internal_id);
			normalized.has_items = normalized.has_items !== false;
			normalized.items_loaded = normalized.items_loaded === true;
			normalized.items_loading = normalized.items_loading === true;
			normalized.items = Array.isArray(normalized.items) ? normalized.items : [];
			return normalized;
		}

		function scheduleClearLoanPopupSearch() {
			clearTimeout(clearLoanPopupTimer);
			clearLoanPopupTimer = setTimeout(function() {
				loadClearLoanPopupRows(false);
			}, 250);
		}

		function captureClearLoanSelectionState() {
			var selected = {};
			var checkedInputs = document.querySelectorAll('#clearLoanModal .clear-loan-check-input:checked');
			for (var index = 0; index < checkedInputs.length; index++) {
				selected[String(checkedInputs[index].value || '')] = true;
			}
			clearLoanPopupSelectedKeys = selected;
		}

		function isClearLoanSelectionChecked(key) {
			return !!clearLoanPopupSelectedKeys[String(key || '')];
		}

		function updateClearLoanLoadMoreButton() {
			var button = document.getElementById('clearLoanLoadMoreButton');
			var wrap = document.getElementById('clearLoanLoadMoreWrap');
			if (!button || !wrap) return;

			var shouldShow = clearLoanPopupHasMore || clearLoanPopupLoadingMore;
			wrap.style.display = shouldShow ? 'block' : 'none';
			button.style.display = shouldShow ? 'inline-flex' : 'none';
			button.disabled = clearLoanPopupLoadingMore;
			button.textContent = clearLoanPopupLoadingMore ? 'กำลังโหลด...' : 'โหลดเพิ่ม';
		}


		function getClearLoanTableColumnCount(docType) {
			return docType === 'loan' ? 10 : 9;
		}

		function renderClearLoanTableState(message) {
			var tableBody = document.getElementById('clearLoanTableBody');
			if (!tableBody) return;
			resetClearLoanPopupState();
			updateClearLoanTableHeaders(clearLoanPopupType);
			tableBody.innerHTML = '<tr class="clear-loan-state-row"><td colspan="' + getClearLoanTableColumnCount(clearLoanPopupType) + '">' + escapeClearLoanHtml(message) + '</td></tr>';
			updateClearLoanSelectionSummary();
			updateClearLoanLoadMoreButton();
		}

		function updateClearLoanTableHeaders(docType) {
			var labels = docType === 'loan' ? {
				clearLoanHeaderReference: 'วันที่ลงทะเบียน',
				clearLoanHeaderRegisteredDate: 'เลขที่เอกสาร',
				clearLoanHeaderDocumentNo: 'รายการสินค้า',
				clearLoanHeaderRequiredDate: 'จำนวน',
				clearLoanHeaderCustomerName: 'หมายเลข SN',
				clearLoanHeaderSaleZone: 'ชื่อลูกค้า',
				clearLoanHeaderStatus: 'เขตการขาย',
				clearLoanHeaderExtra: 'สถานะ'
			} : {
				clearLoanHeaderReference: 'เลขที่อ้างอิง',
				clearLoanHeaderRegisteredDate: 'วันที่ลงทะเบียน',
				clearLoanHeaderDocumentNo: 'เลขที่ใบจอง',
				clearLoanHeaderRequiredDate: 'วันที่ต้องการสินค้า',
				clearLoanHeaderCustomerName: 'ชื่อลูกค้า',
				clearLoanHeaderSaleZone: 'เขตการขาย',
				clearLoanHeaderStatus: 'สถานะ',
				clearLoanHeaderExtra: ''
			};
			var headerIds = Object.keys(labels);
			for (var index = 0; index < headerIds.length; index++) {
				var headerId = headerIds[index];
				var headerElement = document.getElementById(headerId);
				if (headerElement) {
					headerElement.textContent = labels[headerId];
				}
			}
			var extraHeader = document.getElementById('clearLoanHeaderExtra');
			if (extraHeader) {
				extraHeader.style.display = docType === 'loan' ? '' : 'none';
			}
		}

		function buildReserveClearLoanDocumentRows(documentRow, docIndex) {
			var rows = [];
			var items = Array.isArray(documentRow.items) ? documentRow.items : [];
			var hasItems = documentRow.has_items !== false;
			var expanded = !!clearLoanPopupExpandedKeys[documentRow.document_key];
			var groupId = 'clear-loan-subrow-' + docIndex;
			var documentKey = escapeClearLoanHtml(documentRow.document_key || ('doc-' + docIndex));
			var documentChecked = isClearLoanSelectionChecked(documentRow.document_key);
			var expandButtonClass = 'clear-loan-expand-btn' + (expanded ? ' expanded' : '') + (hasItems ? '' : ' disabled');
			var expandButton = hasItems ?
				'<button type="button" class="' + expandButtonClass + '" onclick="toggleClearRow(' + docIndex + ')" aria-expanded="' + (expanded ? 'true' : 'false') + '" aria-controls="' + groupId + '">&#9660;</button>' :
				'<button type="button" class="' + expandButtonClass + '" disabled aria-expanded="false">&#9660;</button>';

			rows.push('<tr>');
			rows.push('<td><label class="clear-loan-item-option"><input type="checkbox" class="clear-loan-check-input" value="' + documentKey + '" data-entry-type="document" data-doc-index="' + docIndex + '"' + (documentChecked ? ' checked' : '') + '><span class="clear-loan-check-circle" aria-hidden="true"></span></label></td>');
			rows.push('<td>' + expandButton + '</td>');
			rows.push('<td>' + escapeClearLoanHtml(documentRow.reference_no || '-') + '</td>');
			rows.push('<td>' + escapeClearLoanHtml(documentRow.registered_date || '-') + '</td>');
			rows.push('<td>' + escapeClearLoanHtml(documentRow.document_no || '-') + '</td>');
			rows.push('<td>' + escapeClearLoanHtml(documentRow.required_date || '-') + '</td>');
			rows.push('<td>' + escapeClearLoanHtml(documentRow.customer_name || '-') + '</td>');
			rows.push('<td>' + escapeClearLoanHtml(documentRow.sale_zone || '-') + '</td>');
			rows.push('<td>' + escapeClearLoanHtml(documentRow.status || '-') + '</td>');
			rows.push('</tr>');
			rows.push('<tr class="' + groupId + ' clear-loan-subrow' + (expanded ? ' show' : '') + '" aria-hidden="' + (expanded ? 'false' : 'true') + '">');
			rows.push('<td></td><td></td>');
			rows.push('<td colspan="3" style="color: #612989; font-weight: 600; padding-top: 14px; padding-bottom: 6px;">\u0E23\u0E32\u0E22\u0E01\u0E32\u0E23\u0E2A\u0E34\u0E19\u0E04\u0E49\u0E32</td>');
			rows.push('<td style="color: #612989; font-weight: 600; padding-top: 14px; padding-bottom: 6px; text-align: center;">\u0E08\u0E33\u0E19\u0E27\u0E19</td>');
			rows.push('<td colspan="3"></td>');
			rows.push('</tr>');

			if (!hasItems) {
				rows.push('<tr class="' + groupId + ' clear-loan-subrow' + (expanded ? ' show' : '') + '" aria-hidden="' + (expanded ? 'false' : 'true') + '"><td></td><td></td><td colspan="7">\u0E44\u0E21\u0E48\u0E1E\u0E1A\u0E23\u0E32\u0E22\u0E01\u0E32\u0E23\u0E2A\u0E34\u0E19\u0E04\u0E49\u0E32</td></tr>');
				return rows;
			}

			if (documentRow.items_loading) {
				rows.push('<tr class="' + groupId + ' clear-loan-subrow' + (expanded ? ' show' : '') + '" aria-hidden="' + (expanded ? 'false' : 'true') + '"><td></td><td></td><td colspan="7">\u0E01\u0E33\u0E25\u0E31\u0E07\u0E42\u0E2B\u0E25\u0E14...</td></tr>');
				return rows;
			}

			if (!documentRow.items_loaded) {
				rows.push('<tr class="' + groupId + ' clear-loan-subrow' + (expanded ? ' show' : '') + '" aria-hidden="' + (expanded ? 'false' : 'true') + '"><td></td><td></td><td colspan="7">Expand to load items</td></tr>');
				return rows;
			}

			if (!items.length) {
				rows.push('<tr class="' + groupId + ' clear-loan-subrow' + (expanded ? ' show' : '') + '" aria-hidden="' + (expanded ? 'false' : 'true') + '"><td></td><td></td><td colspan="7">\u0E44\u0E21\u0E48\u0E1E\u0E1A\u0E23\u0E32\u0E22\u0E01\u0E32\u0E23\u0E2A\u0E34\u0E19\u0E04\u0E49\u0E32</td></tr>');
				return rows;
			}

			for (var itemIndex = 0; itemIndex < items.length; itemIndex++) {
				var item = items[itemIndex] || {};
				var productLabel = escapeClearLoanHtml(item.product_id || '-');
				var productName = escapeClearLoanHtml(item.product_name || '');
				var productCode = escapeClearLoanHtml(item.product_code || '');
				var snText = escapeClearLoanHtml(item.sn || '');
				var metaParts = [];
				if (productName) {
					metaParts.push(productName + (productCode ? ' (' + productCode + ')' : ''));
				}
				if (snText) {
					metaParts.push('SN: ' + snText);
				}
				var itemKey = escapeClearLoanHtml(item.item_key || ((documentRow.document_key || ('doc-' + docIndex)) + '-' + itemIndex));
				var itemChecked = isClearLoanSelectionChecked(item.item_key);
				rows.push('<tr class="' + groupId + ' clear-loan-subrow' + (expanded ? ' show' : '') + '" aria-hidden="' + (expanded ? 'false' : 'true') + '">');
				rows.push('<td></td>');
				rows.push('<td><label class="clear-loan-item-option"><input type="checkbox" class="clear-loan-check-input" value="' + itemKey + '" data-entry-type="item" data-doc-index="' + docIndex + '" data-item-index="' + itemIndex + '"' + (itemChecked ? ' checked' : '') + '><span class="clear-loan-check-circle" aria-hidden="true"></span></label></td>');
				rows.push('<td colspan="3">' + productLabel + (metaParts.length ? '<span class="clear-loan-item-meta">' + metaParts.join(' | ') + '</span>' : '') + '</td>');
				rows.push('<td style="text-align: center;">' + escapeClearLoanHtml(item.quantity || '0') + '</td>');
				rows.push('<td colspan="3"></td>');
				rows.push('</tr>');
			}

			return rows;
		}

		function buildLoanClearLoanDocumentRows(documentRow, docIndex) {
			var rows = [];
			var documentKey = escapeClearLoanHtml(documentRow.document_key || ('doc-' + docIndex));
			var documentChecked = isClearLoanSelectionChecked(documentRow.document_key);
			rows.push('<tr>');
			rows.push('<td><label class="clear-loan-item-option"><input type="checkbox" class="clear-loan-check-input" value="' + documentKey + '" data-entry-type="document" data-doc-index="' + docIndex + '"' + (documentChecked ? ' checked' : '') + '><span class="clear-loan-check-circle" aria-hidden="true"></span></label></td>');
			rows.push('<td></td>');
			rows.push('<td>' + escapeClearLoanHtml(documentRow.registered_date || '-') + '</td>');
			rows.push('<td>' + escapeClearLoanHtml(documentRow.document_no_display || documentRow.reference_no || documentRow.document_no || '-') + '</td>');
			rows.push('<td>' + escapeClearLoanHtml(documentRow.loan_product_name || documentRow.loan_product_id || '-') + '</td>');
			rows.push('<td style="text-align: center;">' + escapeClearLoanHtml(documentRow.loan_quantity || '0') + '</td>');
			rows.push('<td>' + escapeClearLoanHtml(documentRow.loan_sn || '-') + '</td>');
			rows.push('<td>' + escapeClearLoanHtml(documentRow.customer_name || '-') + '</td>');
			rows.push('<td>' + escapeClearLoanHtml(documentRow.sale_zone || '-') + '</td>');
			rows.push('<td>' + escapeClearLoanHtml(documentRow.status || '-') + '</td>');
			rows.push('</tr>');
			return rows;
		}

		function buildClearLoanDocumentRows(documentRow, docIndex) {
			if ((documentRow.doc_type || clearLoanPopupType) === 'loan') {
				return buildLoanClearLoanDocumentRows(documentRow, docIndex);
			}
			return buildReserveClearLoanDocumentRows(documentRow, docIndex);
		}

		function renderClearLoanPopupRows(documents) {
			var tableBody = document.getElementById('clearLoanTableBody');
			updateClearLoanTableHeaders(clearLoanPopupType);
			if (!tableBody) return;
			if (!documents || !documents.length) {
				renderClearLoanTableState('No documents found');
				return;
			}

			var rows = [];
			for (var docIndex = 0; docIndex < documents.length; docIndex++) {
				var builtRows = buildClearLoanDocumentRows(documents[docIndex] || {}, docIndex);
				rows = rows.concat(builtRows);
			}
			tableBody.innerHTML = rows.join('');
			updateClearLoanSelectionSummary();
			updateClearLoanLoadMoreButton();
		}

		function getClearLoanRowField(prefix, rowIndex) {
			return document.getElementById(prefix + rowIndex) ||
				document.querySelector('input[name="' + prefix + rowIndex + '"], select[name="' + prefix + rowIndex + '"], textarea[name="' + prefix + rowIndex + '"]');
		}

		function setClearLoanRowField(prefix, rowIndex, value) {
			var field = getClearLoanRowField(prefix, rowIndex);
			if (field) {
				field.value = value == null ? '' : String(value);
			}
			return field;
		}

		function getClearLoanRowValue(prefix, rowIndex) {
			var field = getClearLoanRowField(prefix, rowIndex);
			return field ? String(field.value || '').trim() : '';
		}

		function isClearLoanRowEmpty(rowIndex) {
			if (getClearLoanRowValue('row_deleted', rowIndex) === '1') {
				return true;
			}
			var prefixes = ['product_id', 'product_codet', 'h_product_codet', 'product_name', 'display_name', 'product_sn', 'sale_count', 'product_price', 'discount_unit', 'sum_amount', 'clear_ivno', 'jong_no'];
			for (var i = 0; i < prefixes.length; i++) {
				if (getClearLoanRowValue(prefixes[i], rowIndex) !== '') {
					return false;
				}
			}
			return true;
		}

		function getClearLoanAvailableRows(limit) {
			var rows = [];
			for (var rowIndex = 1; rowIndex <= limit; rowIndex++) {
				if (getClearLoanRowField('product_id', rowIndex) && isClearLoanRowEmpty(rowIndex)) {
					rows.push(rowIndex);
				}
			}
			return rows;
		}

		function buildClearLoanImportItems() {
			var selectedInputs = document.querySelectorAll('#clearLoanModal .clear-loan-check-input:checked');
			var documents = Array.isArray(clearLoanPopupDocuments) ? clearLoanPopupDocuments : [];
			var importMap = {};
			var importItems = [];
			for (var index = 0; index < selectedInputs.length; index++) {
				var input = selectedInputs[index];
				var entryType = input.getAttribute('data-entry-type');
				var docIndex = parseInt(input.getAttribute('data-doc-index'), 10);
				var itemIndex = parseInt(input.getAttribute('data-item-index'), 10);
				var documentRow = documents[docIndex];
				var items = documentRow && Array.isArray(documentRow.items) ? documentRow.items : [];
				if (!documentRow) {
					continue;
				}
				if (entryType === 'document') {
					for (var docItemIndex = 0; docItemIndex < items.length; docItemIndex++) {
						var documentItem = items[docItemIndex] || {};
						var documentImportKey = docIndex + ':' + docItemIndex;
						if (importMap[documentImportKey]) {
							continue;
						}
						importMap[documentImportKey] = true;
						importItems.push({
							document_no: documentRow.document_no || '',
							doc_type: documentRow.doc_type || clearLoanPopupType,
							item: documentItem
						});
					}
					continue;
				}
				if (entryType === 'item' && !isNaN(itemIndex) && items[itemIndex]) {
					var itemImportKey = docIndex + ':' + itemIndex;
					if (importMap[itemImportKey]) {
						continue;
					}
					importMap[itemImportKey] = true;
					importItems.push({
						document_no: documentRow.document_no || '',
						doc_type: documentRow.doc_type || clearLoanPopupType,
						item: items[itemIndex]
					});
				}
			}
			return importItems;
		}

		function getClearLoanPrimaryDocument() {
			var selectedInputs = document.querySelectorAll('#clearLoanModal .clear-loan-check-input:checked');
			var documents = Array.isArray(clearLoanPopupDocuments) ? clearLoanPopupDocuments : [];
			for (var index = 0; index < selectedInputs.length; index++) {
				var docIndex = parseInt(selectedInputs[index].getAttribute('data-doc-index'), 10);
				if (!isNaN(docIndex) && documents[docIndex]) {
					return documents[docIndex];
				}
			}
			return null;
		}

		function setClearLoanSelectValue(id, value, addMissingOption) {
			var select = document.getElementById(id);
			if (!select) return;
			var normalizedValue = value == null ? '' : String(value);
			for (var index = 0; index < select.options.length; index++) {
				if (select.options[index].value === normalizedValue) {
					select.value = normalizedValue;
					select.dispatchEvent(new Event('change', {
						bubbles: true
					}));
					return;
				}
			}
			if (addMissingOption && normalizedValue !== '') {
				var option = document.createElement('option');
				option.value = normalizedValue;
				option.textContent = normalizedValue;
				select.appendChild(option);
				select.value = normalizedValue;
				select.dispatchEvent(new Event('change', {
					bubbles: true
				}));
			}
		}

		function mapClearLoanDocumentHeader(documentRow) {
			var companyMap = {
				'1': '3',
				'2': '4',
				'3': '3',
				'4': '4'
			};
			setClearLoanSelectValue('type_doc_select', companyMap[String(documentRow.company || '')] || documentRow.company);
			setClearLoanSelectValue('sale_code', documentRow.sale_code || '', true);
			setClearLoanSelectValue('doc_type_select', '1');

			var deliveryContract = document.getElementById('delivery_contract');
			if (deliveryContract) {
				deliveryContract.value = documentRow.required_date_raw || '';
				deliveryContract.dispatchEvent(new Event('change', {
					bubbles: true
				}));
			}
		}

		function loadClearLoanCustomer(documentRow, onComplete) {
			var customerId = String(documentRow.customer_id || '').trim();
			var billId = document.getElementById('bill_id');
			var hiddenBillId = document.getElementById('h_bill_id');
			var displayBillId = document.getElementById('display_bill_id');
			if (billId) billId.value = customerId;
			if (hiddenBillId) hiddenBillId.value = customerId;
			if (displayBillId) displayBillId.textContent = customerId;

			doCallAjax1('bill_id', 'bill_name', 'bill_address', 'bill_tel', 'tax_id', 'pre_name', 'mode_name', 'email', 'customer_typename', 'payment', 'credit_thb', undefined, onComplete);
		}

		function populateClearLoanRow(rowIndex, entry) {
			var item = entry && entry.item ? entry.item : {};
			var docType = entry && entry.doc_type ? entry.doc_type : clearLoanPopupType;
			var documentNo = entry && entry.document_no ? entry.document_no : '';
			var quantity = item.quantity == null || item.quantity === '' ? '1' : String(item.quantity);
			var productId = item.product_id || '';
			var productCode = item.product_code || productId || '';
			var productName = item.product_name || productId || productCode || '';
			var productSn = item.sn || '';
			var row = document.getElementById('product_row_' + rowIndex);
			if (row) {
				row.style.display = '';
			}
			setClearLoanRowField('row_deleted', rowIndex, '');
			setClearLoanRowField('subso_db_id', rowIndex, '');
			setClearLoanRowField('product_id', rowIndex, productId);
			setClearLoanRowField('product_codet', rowIndex, productCode);
			setClearLoanRowField('h_product_codet', rowIndex, productCode);
			setClearLoanRowField('product_name', rowIndex, productName);
			setClearLoanRowField('display_name', rowIndex, productName);
			setClearLoanRowField('product_sn', rowIndex, productSn);
			setClearLoanRowField('sn', rowIndex, productSn);
			setClearLoanRowField('sale_count', rowIndex, quantity);
			setClearLoanRowField('product_price', rowIndex, '');
			setClearLoanRowField('discount_unit', rowIndex, '');
			setClearLoanRowField('sum_amount', rowIndex, '');
			setClearLoanRowField('unit_name', rowIndex, '');
			setClearLoanRowField('warranty', rowIndex, item.warranty || '');
			setClearLoanRowField('cal', rowIndex, '');
			setClearLoanRowField('pm', rowIndex, '');
			setClearLoanRowField('pm_year', rowIndex, '');
			setClearLoanRowField('sale_remarkk', rowIndex, '');
			if (docType === 'loan') {
				setClearLoanRowField('clear_br', rowIndex, '1');
				setClearLoanRowField('clear_ivno', rowIndex, documentNo);
				setClearLoanRowField('jong_ckk', rowIndex, '');
				setClearLoanRowField('jong_no', rowIndex, '');
			} else {
				setClearLoanRowField('clear_br', rowIndex, '');
				setClearLoanRowField('clear_ivno', rowIndex, '');
				setClearLoanRowField('jong_ckk', rowIndex, '1');
				setClearLoanRowField('jong_no', rowIndex, documentNo);
			}
			var productNameLabel = document.getElementById('product_name_label' + rowIndex);
			if (productNameLabel) {
				productNameLabel.textContent = productName;
			}
			if (typeof formatNumberInput === 'function') {
				var priceElement = getClearLoanRowField('product_price', rowIndex);
				var discountElement = getClearLoanRowField('discount_unit', rowIndex);
				if (priceElement && priceElement.value !== '') {
					formatNumberInput(priceElement);
				}
				if (discountElement && discountElement.value !== '') {
					formatNumberInput(discountElement);
				}
			}
			if (typeof updateRowTotal === 'function') {
				updateRowTotal(rowIndex);
			}
		}

		function requestClearLoanDocumentItems(docIndex, onComplete) {
			var documents = Array.isArray(clearLoanPopupDocuments) ? clearLoanPopupDocuments : [];
			var documentRow = documents[docIndex];
			if (!documentRow) {
				if (typeof onComplete === 'function') onComplete(false);
				return;
			}
			if (documentRow.items_loaded) {
				if (typeof onComplete === 'function') onComplete(true);
				return;
			}
			if (!documentRow.has_items) {
				documentRow.items_loaded = true;
				documentRow.items = [];
				renderClearLoanPopupRows(clearLoanPopupDocuments);
				if (typeof onComplete === 'function') onComplete(true);
				return;
			}
			if (documentRow.items_loading) {
				if (typeof onComplete === 'function') onComplete(false);
				return;
			}

			documentRow.items_loading = true;
			renderClearLoanPopupRows(clearLoanPopupDocuments);

			jQuery.ajax({
				url: 'ajax_clear_loan_popup_search.php',
				type: 'GET',
				dataType: 'json',
				cache: false,
				data: {
					action: 'items',
					type: documentRow.doc_type || clearLoanPopupType,
					document_id: documentRow.internal_id
				}
			}).done(function(response) {
				documentRow.items_loading = false;
				if (!response || response.success !== true) {
					renderClearLoanPopupRows(clearLoanPopupDocuments);
					if (typeof onComplete === 'function') onComplete(false);
					return;
				}
				documentRow.items = Array.isArray(response.items) ? response.items : [];
				documentRow.items_loaded = true;
				documentRow.has_items = documentRow.items.length > 0;
				renderClearLoanPopupRows(clearLoanPopupDocuments);
				if (typeof onComplete === 'function') onComplete(true);
			}).fail(function() {
				documentRow.items_loading = false;
				renderClearLoanPopupRows(clearLoanPopupDocuments);
				if (typeof onComplete === 'function') onComplete(false);
			});
		}

		function loadClearLoanPopupRows(loadMore) {
			var selectedType = getClearLoanSelectedType();
			var search = document.getElementById('clearLoanSearch');
			var keyword = search ? search.value : '';
			clearLoanPopupType = selectedType;
			loadMore = loadMore === true;
			updateClearLoanTableHeaders(clearLoanPopupType);

			if (typeof jQuery === 'undefined') {
				renderClearLoanTableState('Refresh required');
				return;
			}
			if (loadMore && (!clearLoanPopupHasMore || clearLoanPopupLoadingMore)) {
				return;
			}
			if (clearLoanPopupRequest && typeof clearLoanPopupRequest.abort === 'function') {
				clearLoanPopupRequest.abort();
			}

			if (!loadMore) {
				resetClearLoanPopupState();
				renderClearLoanTableState('กำลังโหลด...');
			} else {
				captureClearLoanSelectionState();
				clearLoanPopupLoadingMore = true;
				updateClearLoanLoadMoreButton();
			}

			clearLoanPopupRequestToken += 1;
			var requestToken = clearLoanPopupRequestToken;
			var requestData = {
				action: 'list',
				type: selectedType,
				keyword: keyword,
				limit: 50
			};
			if (loadMore && clearLoanPopupNextLastId !== null) {
				requestData.last_id = clearLoanPopupNextLastId;
			}

			clearLoanPopupRequest = jQuery.ajax({
				url: 'ajax_clear_loan_popup_search.php',
				type: 'GET',
				dataType: 'json',
				cache: false,
				data: requestData
			}).done(function(response) {
				if (requestToken !== clearLoanPopupRequestToken) {
					return;
				}
				if (!response || response.success !== true) {
					if (!loadMore) {
						renderClearLoanTableState((response && response.message) ? response.message : 'โหลดข้อมูลไม่สำเร็จ');
					} else {
						clearLoanPopupLoadingMore = false;
						updateClearLoanLoadMoreButton();
					}
					return;
				}

				var incoming = Array.isArray(response.documents) ? response.documents.map(normalizeClearLoanDocument) : [];
				if (loadMore) {
					clearLoanPopupDocuments = clearLoanPopupDocuments.concat(incoming);
				} else {
					clearLoanPopupDocuments = incoming;
				}

				var pagination = response.pagination || {};
				clearLoanPopupHasMore = pagination.has_more === true;
				clearLoanPopupNextLastId = pagination.next_last_id != null ? pagination.next_last_id : null;
				clearLoanPopupLoadingMore = false;
				renderClearLoanPopupRows(clearLoanPopupDocuments);
			}).fail(function(xhr, statusText) {
				if (statusText === 'abort' || requestToken !== clearLoanPopupRequestToken) {
					return;
				}
				clearLoanPopupLoadingMore = false;
				if (!loadMore) {
					renderClearLoanTableState('โหลดข้อมูลไม่สำเร็จ');
				} else {
					updateClearLoanLoadMoreButton();
				}
			});
		}

		function loadMoreClearLoanRows() {
			loadClearLoanPopupRows(true);
		}

		function toggleClearRow(docIndex) {
			captureClearLoanSelectionState();
			var documentRow = Array.isArray(clearLoanPopupDocuments) ? clearLoanPopupDocuments[docIndex] : null;
			if (!documentRow) return;
			var documentKey = documentRow.document_key;
			if (clearLoanPopupExpandedKeys[documentKey]) {
				delete clearLoanPopupExpandedKeys[documentKey];
				renderClearLoanPopupRows(clearLoanPopupDocuments);
				return;
			}

			clearLoanPopupExpandedKeys[documentKey] = true;
			if (documentRow.has_items && !documentRow.items_loaded) {
				requestClearLoanDocumentItems(docIndex);
				return;
			}
			renderClearLoanPopupRows(clearLoanPopupDocuments);
		}

		function updateClearLoanSelectionSummary() {
			var selectedCount = document.querySelectorAll('#clearLoanModal .clear-loan-check-input:checked').length;
			var button = document.getElementById('clearLoanApplyButton');
			if (button) {
				button.disabled = selectedCount === 0;
			}
		}

		function ensureClearLoanDocumentsReadyForImport(onComplete) {
			var checkedDocuments = document.querySelectorAll('#clearLoanModal .clear-loan-check-input[data-entry-type="document"]:checked');
			var queue = [];
			var queueMap = {};
			for (var index = 0; index < checkedDocuments.length; index++) {
				var docIndex = parseInt(checkedDocuments[index].getAttribute('data-doc-index'), 10);
				if (!isNaN(docIndex) && !queueMap[docIndex]) {
					queueMap[docIndex] = true;
					queue.push(docIndex);
				}
			}

			function loadNext(position) {
				if (position >= queue.length) {
					if (typeof onComplete === 'function') onComplete(true);
					return;
				}
				var currentIndex = queue[position];
				var documentRow = clearLoanPopupDocuments[currentIndex];
				if (!documentRow || documentRow.items_loaded || !documentRow.has_items) {
					loadNext(position + 1);
					return;
				}
				requestClearLoanDocumentItems(currentIndex, function(success) {
					if (!success) {
						if (typeof onComplete === 'function') onComplete(false);
						return;
					}
					loadNext(position + 1);
				});
			}

			loadNext(0);
		}

		function getSelectedClearLoanDocuments() {
			var selectedInputs = document.querySelectorAll('#clearLoanModal .clear-loan-check-input:checked');
			var documents = Array.isArray(clearLoanPopupDocuments) ? clearLoanPopupDocuments : [];
			var seen = {};
			var selectedDocuments = [];
			for (var index = 0; index < selectedInputs.length; index++) {
				var docIndex = parseInt(selectedInputs[index].getAttribute('data-doc-index'), 10);
				if (isNaN(docIndex) || seen[docIndex] || !documents[docIndex]) {
					continue;
				}
				seen[docIndex] = true;
				selectedDocuments.push(documents[docIndex]);
			}
			return selectedDocuments;
		}

		function validateClearLoanDocumentCompatibility(documents) {
			if (!documents || documents.length <= 1) {
				return {
					valid: true
				};
			}
			var firstDocument = documents[0] || {};
			var baseCustomerId = String(firstDocument.customer_id || '').trim();
			var baseCompany = String(firstDocument.company || '').trim();
			var baseSaleCode = String(firstDocument.sale_code || '').trim();
			var baseRequiredDate = String(firstDocument.required_date_raw || '').trim();
			for (var index = 1; index < documents.length; index++) {
				var documentRow = documents[index] || {};
				if (String(documentRow.customer_id || '').trim() !== baseCustomerId) {
					return {
						valid: false,
						message: 'กรุณาเลือกเอกสารของลูกค้ารายเดียวกัน'
					};
				}
				if (String(documentRow.company || '').trim() !== baseCompany) {
					return {
						valid: false,
						message: 'กรุณาเลือกเอกสารที่อยู่บริษัทเดียวกัน'
					};
				}
				if (String(documentRow.sale_code || '').trim() !== baseSaleCode) {
					return {
						valid: false,
						message: 'กรุณาเลือกเอกสารที่มีเขตการขายเดียวกัน'
					};
				}
				if (String(documentRow.required_date_raw || '').trim() !== baseRequiredDate) {
					return {
						valid: false,
						message: 'กรุณาเลือกเอกสารที่มีวันที่กำหนดส่งเดียวกัน'
					};
				}
			}
			return {
				valid: true
			};
		}

		function confirmClearLoanSelection() {
			captureClearLoanSelectionState();
			ensureClearLoanDocumentsReadyForImport(function(ready) {
				if (!ready) {
					alert('ไม่สามารถโหลดรายการสินค้าของเอกสารที่เลือกได้');
					return;
				}

				var selectedDocuments = getSelectedClearLoanDocuments();
				var importItems = buildClearLoanImportItems();
				var primaryDocument = selectedDocuments.length ? selectedDocuments[0] : getClearLoanPrimaryDocument();
				if (!importItems.length) {
					alert('กรุณาเลือกรายการที่ต้องการนำเข้า');
					return;
				}
				if (!primaryDocument || !String(primaryDocument.customer_id || '').trim()) {
					alert('ไม่พบรหัสลูกค้าในเอกสารต้นทาง');
					return;
				}
				var compatibility = validateClearLoanDocumentCompatibility(selectedDocuments);
				if (!compatibility.valid) {
					alert(compatibility.message);
					return;
				}
				var availableRows = getClearLoanAvailableRows(30);
				if (availableRows.length < importItems.length) {
					alert('แถวสินค้าว่างไม่เพียงพอ กรุณาเคลียร์หรือเพิ่มแถวก่อน');
					return;
				}
				loadClearLoanCustomer(primaryDocument, function(success, missingFields) {
					if (!success) {
						var missingMessage = (missingFields && missingFields.length) ? missingFields.join(', ') : 'โหลดข้อมูลลูกค้าไม่สำเร็จ';
						alert('ไม่สามารถนำเข้าข้อมูลได้: ' + missingMessage);
						return;
					}
					mapClearLoanDocumentHeader(primaryDocument);
					for (var index = 0; index < importItems.length; index++) {
						populateClearLoanRow(availableRows[index], importItems[index]);
					}
					if (typeof syncFormCompatibilityFields === 'function') syncFormCompatibilityFields();
					if (typeof calculateSummary === 'function') calculateSummary();
					if (typeof renderRelatedDocuments === 'function') renderRelatedDocuments();
					closeClearLoanPopup();
				});
			});
		}

		function updateToggleStyle(checkbox) {
			var label = document.getElementById('lbl-' + checkbox.id);
			if (!label) return;

			if (checkbox.checked) {
				label.classList.add('active');
			} else {
				label.classList.remove('active');
			}
		}

		function applySavedToggleState(checkbox, value) {
			if (!checkbox) return;

			var normalizedValue = String(value === undefined || value === null ? '' : value).trim();
			checkbox.checked = normalizedValue === '1';
			updateToggleStyle(checkbox);

			if (checkbox.id === 'have_order') {
				updateDeliveryContractRequirement();
			}
		}

		function normalizeTimeInputValue(value) {
			var match = String(value === undefined || value === null ? '' : value).match(/\b([01]?\d|2[0-3]):([0-5]\d)(?::[0-5]\d)?\b/);
			if (!match) return '';

			return String(match[1]).padStart(2, '0') + ':' + match[2];
		}

		var originalOpenCity1 = openCity1;
		openCity1 = function(cityName, elem) {
			if (typeof originalOpenCity1 === 'function') {
				var i;
				var x = document.getElementsByClassName("city1");
				for (i = 0; i < x.length; i++) {
					x[i].style.display = "none";
				}
				var target = document.getElementById(cityName);
				if (target) target.style.display = "block";
			}

			var buttons = document.querySelectorAll('.bottom-tab-btn');
			buttons.forEach(function(btn) {
				btn.classList.remove('active');
			});
			if (elem) {
				elem.classList.add('active');
			} else {
				var targetBtn = document.querySelector('.bottom-tab-btn[onclick*="' + cityName + '"]');
				if (targetBtn) targetBtn.classList.add('active');
			}
		};
	</script>


	<div id="cr_bar"> <?php include "foot.php"; ?></div>
</body>



<script type="text/javascript">
	function make_autocom(autoObj, showObj) {
		var mkAutoObj = autoObj;
		var mkSerValObj = showObj;
		new Autocomplete(mkAutoObj, function() {
			this.setValue = function(id) {
				document.getElementById(mkSerValObj).value = id;
			}
			if (this.isModified)
				this.setValue("");
			if (this.value.length < 1 && this.isNotClick)
				return;
			return "data_bill_name.php?bill_search=" + encodeURIComponent(this.value);
		});
	}

	// การใช้งาน
	// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
</script>


<script type="text/javascript">
	function make_autocom(autoObj, showObj) {
		var mkAutoObj = autoObj;
		var mkSerValObj = showObj;
		new Autocomplete(mkAutoObj, function() {
			this.setValue = function(id) {
				document.getElementById(mkSerValObj).value = id;
			}
			if (this.isModified)
				this.setValue("");
			if (this.value.length < 1 && this.isNotClick)
				return;
			return "data_sale1.php?employee_name_search=" + encodeURIComponent(this.value);
		});
	}

	// การใช้งาน
	// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
	make_autocom("employee_name", "h_employee_name");
</script>


<script>
	/*
	$('#more').click(function() {
				if ($(this).is(":checke
						if (search) {
							search.addEventListener('input', function() {
								clearTimeout(customerPopupTimer);
								customerPopupTimer = setTimeout(function() {
									customerPopupSelected = null;
									loadCustomerPopupRows(search.value, false);
								}, 250);
							});
						}

						if (fullBillCheckbox) {
							fullBillCheckbox.addEventListener('change', function() {
									fullBillPopupPreviousChecked = !this.checked;
									updateToggleStyle(this);
									if (this.checked) {
										openFullBillPopup();
									}
									tring(v || "").replace(/,/g, '')) || 0;
							}

							function calcTotal() {
								let total = 0;
								for (let i = 1; i <= 20; i++) {
									const el = document.getElementById('sum_amount' + i);
									if (el) total += num(el.value);
								}
								document.getElementById('sum_amount_total').value = total.toFixed(2);
								return total;
							}

							function checkOverLimit(changedId) {
								setTimeout(() => {
									const total = calcTotal();
									const limit = num(document.getElementById('sum_ca')?.value);

									if (limit > 0 && total > limit) {

						// โชว์ Popup แทน alert
										showOverLimitPopup(total, limit);

						// (เลือกได้) จะย้อนค่าเดิมหรือไม่ก็ได้
										const el = document.getElementById(changedId);
										if (el && lastOkValues[changedId] !== undefined) {
											el.value = lastOkValues[changedId];
										}
										calcTotal();
										if (el) {
											el.focus();
											el.select?.();
										}

									} else {
										const el = document.getElementById(changedId);
										if (el) lastOkValues[changedId] = el.value;
									}
								}, 30);
							}


							function bindRow(i) {
								const ids = ['sale_count', 'product_price', 'discount_unit'].map(x => x + i);
								ids.forEach(id => {
									const el = document.getElementById(id);
									if (!el) return;

							// เก็บค่าเริ่มต้นไว้ก่อน
									lastOkValues[id] = el.value;

									el.addEventListener('focus', () => lastOkValues[id] = el.value);
									el.addEventListener('input', () => checkOverLimit(id));
									el.addEventListener('change', () => checkOverLimit(id));
								});
							}

							document.addEventListener('DOMContentLoaded', () => {
								for (let i = 1; i <= 20; i++) bindRow(i);
								calcTotal();
							});
*/
</script>

<script>
	let modalLock = false;

	function fmt2(n) {
		return (Number(n) || 0).toLocaleString('th-TH', {
			minimumFractionDigits: 2,
			maximumFractionDigits: 2
		});
	}


	function showOverLimitPopup(total, limit) {
		if (modalLock) return;
		modalLock = true;

		document.getElementById('ol_total').textContent = fmt2(total);
		document.getElementById('ol_limit').textContent = fmt2(limit);

		document.getElementById('overLimitModal').style.display = 'block';
	}

	function goMainSuphos() {
		window.location.href = 'main_suphos_so.php';
	}
</script>

<style>
	/* Modal box */
	#overLimitModal .box {
		width: min(520px, 92vw);
		background: #fff;
		border-radius: 14px;
		margin: 7vh auto;
		padding: 26px 22px 22px;
		position: relative;
		text-align: center;
		box-shadow: 0 8px 30px rgba(0, 0, 0, .25);
		font-family: Arial, sans-serif;
	}

	#overLimitModal .closeX {
		position: absolute;
		right: 14px;
		top: 10px;
		font-size: 28px;
		cursor: pointer;
		color: #333;
		line-height: 1;
	}

	#overLimitModal .icon {
		width: 86px;
		height: 86px;
		margin: 6px auto 10px;
	}

	#overLimitModal .title {
		font-size: 28px;
		margin: 10px 0 18px;
	}

	#overLimitModal .row {
		font-size: 18px;
		margin: 10px 0;
	}

	#overLimitModal .btnBack {
		margin-top: 18px;
		padding: 12px 26px;
		border: none;
		border-radius: 22px;
		background: #612989;
		color: #fff;
		font-size: 16px;
		cursor: pointer;
	}

	#overLimitModal .btnBack:hover {
		opacity: .92;
	}

	/* ถ้าอยากให้ทั้งหน้าเป็น Prompt */
	body {
		font-family: 'Prompt', sans-serif;
	}

	/* หรือกำหนดเฉพาะ popup */
	.overlimitModal,
	.overlimitModal * {
		font-family: 'Prompt', sans-serif !important;
	}

	/* ปุ่มกลับ */
	.btnBack {
		font-family: 'Prompt', sans-serif !important;
		font-weight: 500;
	}

	*/

</style>

<style>
	.customer-popup-modal {
		display: none;
		position: fixed;
		z-index: 99998;
		inset: 0;
		align-items: center;
		justify-content: center;
		background: rgba(0, 0, 0, 0.45);
		padding: 24px;
		box-sizing: border-box;
		font-family: 'Prompt', sans-serif;
	}

	.customer-popup-box {
		width: min(1096px, 96vw);
		height: min(1226px, 92vh);
		background: #fff;
		border-radius: 10px;
		position: relative;
		display: flex;
		flex-direction: column;
		overflow: hidden;
		box-shadow: 0 18px 50px rgba(0, 0, 0, 0.24);
	}

	.customer-popup-close {
		position: absolute;
		top: 4px;
		right: 18px;
		width: 28px;
		height: 28px;
		border: 0;
		background: transparent;
		color: #3b3b3b;
		font-size: 52px;
		line-height: 1;
		cursor: pointer;
		z-index: 1;
	}

	.customer-popup-header {
		padding: 24px 32px 10px;
		border-bottom: 1px solid #eee7f4;
	}

	.customer-popup-header h2 {
		margin: 0;
		color: #3b3b3b;
		font-size: 20px;
		font-weight: 500;
		line-height: 1.35;
		border-bottom: 1px solid #eee7f4;
		padding-bottom: 14px;
	}

	.customer-popup-toolbar {
		display: flex;
		align-items: flex-end;
		justify-content: space-between;
		gap: 20px;
		flex-wrap: nowrap;
		width: 100%;
	}

	.customer-popup-search-wrap {
		flex: 1 1 auto;
		max-width: none;
		min-width: 0;
	}

	.customer-popup-search-wrap label {
		display: block;
		margin-bottom: 4px;
		color: #612989;
		font-size: 14px;
		font-weight: 400;
	}

	.customer-popup-search {
		height: 42px;
		display: flex;
		align-items: center;
		gap: 12px;
		background: #f5f6f8;
		border-radius: 10px;
		padding: 0 14px;
		box-sizing: border-box;
	}

	.customer-popup-search i {
		color: #2f3337;
		font-size: 16px;
	}

	.customer-popup-search input {
		width: 100%;
		border: 0;
		outline: none;
		background: transparent;
		color: #3b3b3b;
		font-size: 16px;
		font-family: 'Prompt', sans-serif;
	}

	.customer-popup-add {
		height: 42px;
		display: inline-flex;
		flex: 0 0 auto;
		align-items: center;
		justify-content: center;
		gap: 10px;
		border: 0;
		border-radius: 25px;
		background: #fff;
		color: #612989;
		font-family: 'Prompt', sans-serif;
		font-size: 14px;
		font-weight: 500;
		padding: 0 24px;
		cursor: pointer;
		box-shadow: 0 0 4px rgba(0, 0, 0, 0.25);
		white-space: nowrap;
	}

	.customer-popup-table-wrap {
		flex: 1;
		overflow: auto;
		border-top: 1px solid #612989;
		border-bottom: 1px solid #f0edf2;
	}

	.customer-popup-table {
		width: 100%;
		border-collapse: collapse;
		table-layout: fixed;
		color: #3b3b3b;
		font-family: 'Prompt', sans-serif;
	}

	.customer-popup-table th {
		height: 40px;
		padding: 0 36px;
		text-align: left;
		color: #612989;
		font-size: 16px;
		font-weight: 500;
		border-bottom: 1px solid #612989;
		white-space: nowrap;
	}

	.customer-popup-table th:nth-child(1) {
		width: 20%;
	}

	.customer-popup-table th:nth-child(2) {
		width: 16%;
	}

	.customer-popup-table th:nth-child(3) {
		width: 46%;
	}

	.customer-popup-table th:nth-child(4) {
		width: 18%;
	}

	.fullbill-popup-table th:nth-child(1) {
		width: 16%;
	}

	.fullbill-popup-table th:nth-child(2) {
		width: 14%;
	}

	.fullbill-popup-table th:nth-child(3) {
		width: 42%;
	}

	.fullbill-popup-table th:nth-child(4) {
		width: 20%;
	}

	.fullbill-popup-table th:nth-child(5) {
		width: 8%;
	}

	.shipping-popup-box {
		width: min(1120px, 96vw);
		height: min(980px, 92vh);
	}

	.shipping-popup-toolbar {
		align-items: end;
	}

	.shipping-popup-table th:nth-child(1) {
		width: 4.5%;
	}

	.shipping-popup-table th:nth-child(2) {
		width: 10.5%;
	}

	.shipping-popup-table th:nth-child(3) {
		width: 14%;
	}

	.shipping-popup-table th:nth-child(4) {
		width: 13%;
	}

	.shipping-popup-table th:nth-child(5) {
		width: 12%;
	}

	.shipping-popup-table th:nth-child(6) {
		width: 39%;
	}

	.shipping-popup-table th:nth-child(7) {
		width: 7%;
	}

	.shipping-popup-checkall {
		display: inline-flex;
		align-items: center;
		gap: 8px;
		font-weight: 500;
		white-space: nowrap;
	}

	.shipping-popup-select-cell {
		padding-inline-end: 0;
		text-align: center;
	}

	.shipping-popup-checkbox-input,
	.shipping-popup-checkall input {
		width: 18px;
		height: 18px;
		accent-color: #6f33a3;
		cursor: pointer;
		margin: 0;
	}

	.shipping-popup-table tbody tr.selected {
		background: #f1e1ff;
	}

	.shipping-popup-table tbody tr[data-index="-1"] td {
		font-weight: 500;
	}

	.customer-popup-table td {
		height: 63px;
		padding: 0 36px;
		font-size: 14px;
		font-weight: 300;
		border-bottom: 1px solid #ebebeb;
		vertical-align: middle;
	}

	.customer-popup-table tbody tr {
		cursor: pointer;
	}

	.customer-popup-table tbody tr:hover,
	.customer-popup-table tbody tr.selected {
		background: #f1e1ff;
	}

	.customer-popup-name {
		border: 0;
		background: transparent;
		color: #3B3B3B;
		font-family: 'Prompt', sans-serif;
		font-size: 14px;
		font-weight: 300;
		text-decoration: underline;
		cursor: pointer;
		padding: 0;
		text-align: left;
	}

	.customer-popup-empty {
		text-align: center;
		color: #696969;
		cursor: default;
	}

	.customer-popup-pagination {
		display: flex;
		justify-content: center;
		padding: 4px 32px 0;
	}

	.customer-popup-loadmore {
		min-width: 152px;
		height: 40px;
		border: 1px solid #d9c8ea;
		border-radius: 20px;
		background: #fff;
		color: #612989;
		font-family: 'Prompt', sans-serif;
		font-size: 14px;
		font-weight: 500;
		cursor: pointer;
		box-shadow: 0 0 4px rgba(0, 0, 0, 0.1);
		transition: background 0.2s, color 0.2s, border-color 0.2s, box-shadow 0.2s;
	}

	.customer-popup-loadmore:hover:not(:disabled) {
		background: #612989;
		color: #fff;
		border-color: #612989;
		box-shadow: 0 4px 10px rgba(97, 41, 137, 0.2);
	}

	.customer-popup-loadmore:disabled {
		opacity: 0.7;
		cursor: wait;
	}

	.customer-popup-actions {
		display: flex;
		justify-content: flex-end;
		gap: 24px;
		padding: 22px 32px;
	}

	.customer-popup-actions button {
		width: 152px;
		height: 42px;
		border-radius: 21px;
		font-family: 'Prompt', sans-serif;
		font-size: 14px;
		font-weight: 500;
		cursor: pointer;
		box-shadow: 0 0 4px rgba(0, 0, 0, 0.25);
		transition: background 0.2s, color 0.2s, box-shadow 0.2s;
	}

	.customer-popup-confirm {
		border: 0;
		background: #612989;
		color: #fff;
	}

	.customer-popup-confirm:hover {
		background: #54237a;
		box-shadow: 0 4px 12px rgba(97, 41, 137, 0.3);
	}

	.customer-popup-cancel {
		border: 0;
		background: #fff;
		color: #3b3b3b;
	}

	.customer-popup-cancel:hover {
		background: #f6effd;
		color: #612989;
	}

	.fullbill-popup-box {
		width: min(1096px, 96vw);
		height: min(1226px, 92vh);
		max-height: none;
	}

	.fullbill-popup-body {
		padding: 24px 32px 8px;
		overflow: auto;
	}

	.fullbill-popup-note {
		margin-bottom: 18px;
		padding: 14px 16px;
		border-radius: 12px;
		background: #f7f3fb;
		color: #612989;
		font-size: 14px;
		line-height: 1.6;
	}

	.fullbill-popup-grid {
		display: grid;
		grid-template-columns: repeat(2, minmax(0, 1fr));
		gap: 16px;
	}

	.fullbill-popup-item {
		padding: 16px 18px;
		border: 1px solid #ece3f4;
		border-radius: 14px;
		background: #fff;
	}

	.fullbill-popup-item-wide {
		grid-column: 1 / -1;
	}

	.fullbill-popup-item label {
		display: block;
		margin-bottom: 8px;
		color: #7a6d86;
		font-size: 13px;
	}

	.fullbill-popup-value {
		color: #2f3337;
		font-size: 16px;
		line-height: 1.6;
		word-break: break-word;
	}

	.fullbill-popup-value-multiline {
		white-space: pre-wrap;
	}

	#overLimitModal {
		display: none;
		position: fixed;
		z-index: 99999;
		left: 0;
		top: 0;
		width: 100%;
		height: 100%;
		background: rgba(0, 0, 0, 0.45);
	}

	#overLimitModal .box {
		width: min(520px, 92vw);
		background: #fff;
		border-radius: 14px;
		margin: 7vh auto;
		padding: 26px 22px 22px;
		position: relative;
		text-align: center;
		box-shadow: 0 8px 30px rgba(0, 0, 0, 0.25);
		font-family: 'Prompt', sans-serif;
	}

	#overLimitModal .closeX {
		position: absolute;
		right: 14px;
		top: 10px;
		font-size: 28px;
		cursor: pointer;
		color: #333;
		line-height: 1;
	}

	#overLimitModal .icon {
		width: 86px;
		height: 86px;
		margin: 6px auto 10px;
	}

	#overLimitModal .title {
		font-size: 28px;
		margin: 10px 0 18px;
	}

	#overLimitModal .row {
		font-size: 18px;
		margin: 10px 0;
	}

	#overLimitModal .btnBack {
		margin-top: 18px;
		padding: 12px 26px;
		border: none;
		border-radius: 22px;
		background: #612989;
		color: #fff;
		font-size: 16px;
		cursor: pointer;
		font-family: 'Prompt', sans-serif;
		font-weight: 500;
	}

	#overLimitModal .btnBack:hover {
		opacity: 0.92;
	}

	@media (max-width: 768px) {
		.customer-popup-modal {
			padding: 12px;
		}

		.customer-popup-box,
		.fullbill-popup-box,
		.shipping-popup-box {
			width: 100%;
			height: auto;
			max-height: 94vh;
		}

		.customer-popup-header {
			padding: 22px 18px 10px;
		}

		.customer-popup-table {
			min-width: 780px;
		}

		.shipping-popup-table {
			min-width: 980px;
		}

		.customer-popup-table th,
		.customer-popup-table td {
			padding: 0 18px;
		}

		.customer-popup-actions {
			gap: 12px;
			padding: 16px 18px;
		}

		.customer-popup-actions button {
			flex: 1;
			width: auto;
		}

		.fullbill-popup-body {
			padding: 20px 18px 8px;
		}

		.fullbill-popup-grid {
			grid-template-columns: 1fr;
		}
	}

	body,
	#overLimitModal,
	#overLimitModal * {
		font-family: 'Prompt', sans-serif;

</style>

<div id="overLimitModal">
	<div class="box">
		<div class="closeX" onclick="goMainSuphos()">×</div>

		<!-- icon (SVG) -->
		<svg class="icon" viewBox="0 0 64 64" aria-hidden="true">
			<path d="M32 6 L60 58 H4 Z" fill="#ff3b30" />
			<rect x="29" y="22" width="6" height="18" rx="3" fill="#fff" />
			<circle cx="32" cy="46" r="3.2" fill="#fff" />
		</svg>

		<div class="title">กรุณาติดต่อบัญชี</div>
		<div class="row">เพื่อขอเพิ่มวงเงิน เนื่องจากยอดรวมสินค้าเกินวงเงินคงเหลือ</div>


		<div class="row">ยอดรวมสินค้า : <b id="ol_total">0</b></div>
		<div class="row">วงเงินคงเหลือ : <b id="ol_limit">0</b></div>

		<button type="button" class="btnBack" onclick="goMainSuphos()">กลับสู่หน้าหลัก</button>
	</div>
</div>

<!-- Clear Loan/Reserve Modal -->
<div id="clearLoanModal" class="customer-popup-modal" aria-hidden="true">
	<div class="customer-popup-box clear-loan-popup-box" role="dialog" aria-modal="true" aria-labelledby="clearLoanPopupTitle">
		<button type="button" class="customer-popup-close" onclick="closeClearLoanPopup()" aria-label="Close">&times;</button>

		<div class="clear-loan-header">
			<h2 id="clearLoanPopupTitle" class="clear-loan-title">เคลียร์จอง/ยืม</h2>
			<div class="clear-loan-top-controls">
				<div class="clear-loan-type-group" role="radiogroup" aria-label="ประเภทเอกสาร">
					<label class="clear-loan-radio-label">
						<input type="radio" name="clear_loan_type" value="reserve" class="so-custom-radio-input" checked>
						<span class="so-custom-radio-circle" aria-hidden="true"></span>
						ใบจอง
					</label>
					<label class="clear-loan-radio-label">
						<input type="radio" name="clear_loan_type" value="loan" class="so-custom-radio-input">
						<span class="so-custom-radio-circle" aria-hidden="true"></span>
						ใบยืม
					</label>
				</div>
				<div class="clear-loan-search-wrap">
					<label class="clear-loan-search-label" for="clearLoanSearch">ค้นหา</label>
					<div class="clear-loan-search">
						<i class="fas fa-search" aria-hidden="true"></i>
						<input type="text" id="clearLoanSearch" placeholder="ค้นหาจากเลขที่ใบจอง/รหัสสมาชิก/ชื่อลูกค้า/รหัสสินค้า/ชื่อสินค้า">
					</div>
				</div>
			</div>
		</div>

		<div class="clear-loan-table-wrap">
			<div class="clear-loan-table-container">
				<table class="clear-loan-table">
					<thead>
						<tr>
							<th style="width: 40px;"></th>
							<th style="width: 40px;"></th>
							<th id="clearLoanHeaderReference"></th>
							<th id="clearLoanHeaderRegisteredDate"></th>
							<th id="clearLoanHeaderDocumentNo"></th>
							<th id="clearLoanHeaderRequiredDate"></th>
							<th id="clearLoanHeaderCustomerName"></th>
							<th id="clearLoanHeaderSaleZone"></th>
							<th id="clearLoanHeaderStatus"></th>
							<th id="clearLoanHeaderExtra" style="display: none;"></th>
						</tr>
					</thead>
					<tbody id="clearLoanTableBody">
						<tr class="clear-loan-state-row">
							<td colspan="9">Preparing data...</td>
						</tr>
					</tbody>
				</table>
			</div>

			<div id="clearLoanLoadMoreWrap" class="clear-loan-actions" style="display: none; padding-top: 12px; border-top: none;">
				<div class="clear-loan-action-container">
					<button type="button" class="clear-loan-btn clear-loan-btn-secondary" id="clearLoanLoadMoreButton" onclick="loadMoreClearLoanRows()" style="display: none;">โหลดเพิ่ม</button>
				</div>
			</div>

			<div class="clear-loan-actions">
				<div class="clear-loan-action-container">
					<button type="button" class="clear-loan-btn clear-loan-btn-primary" id="clearLoanApplyButton" onclick="confirmClearLoanSelection()" disabled>
						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
							<rect x="5" y="10" width="14" height="5" rx="1"></rect>
							<path d="M12 10V6"></path>
							<path d="M10 6h4"></path>
							<path d="M7 15v3"></path>
							<path d="M10 15v3"></path>
							<path d="M14 15v3"></path>
							<path d="M17 15v3"></path>
						</svg>
						Clear
					</button>
					<button type="button" class="clear-loan-btn clear-loan-btn-secondary" onclick="closeClearLoanPopup()">ยกเลิก</button>
				</div>
			</div>
		</div>
	</div>

	<?php if ($savedSo !== null): ?>
		<script>
			document.addEventListener('DOMContentLoaded', function() {
				var savedSo = <?php echo json_encode($savedSo); ?>;
				var savedRegister = <?php echo json_encode($savedRegister); ?>;
				var savedOtherBill = <?php echo json_encode($savedOtherBill); ?>;
				var savedCommentSo = <?php echo json_encode($savedCommentSo); ?>;
				var savedCommentSoItems = <?php echo json_encode($savedCommentSoItems); ?>;
				var savedTransaction = <?php echo json_encode($savedTransaction); ?>;
				var savedDeliveryPrint = <?php echo json_encode($savedDeliveryPrint); ?>;
				var savedShippingAddresses = <?php echo json_encode($savedShippingAddresses); ?>;
				var savedProducts = <?php echo json_encode($savedProducts); ?>;
				var inferredTimeRange = (function() {
					var startTime = '';
					var endTime = '';

					if (savedRegister) {
						startTime = ((savedRegister.start_time || '') + '').trim().substring(0, 5);
						endTime = ((savedRegister.end_time || '') + '').trim().substring(0, 5);
					}

					if ((!startTime || !endTime) && savedSo && savedSo.delivery_time) {
						var timeParts = (savedSo.delivery_time.match(/\b(?:[01]?\d|2[0-3]):[0-5]\d(?::[0-5]\d)?\b/g) || []).map(function(part) {
							return part.substring(0, 5);
						});
						startTime = startTime || (timeParts[0] || '');
						endTime = endTime || (timeParts[1] || '');
					}

					if (startTime === '08:00' && endTime === '12:00') return 'morning';
					if (startTime === '13:00' && endTime === '17:00') return 'afternoon';
					if (startTime === '08:00' && endTime === '17:00') return 'allday';
					if (startTime || endTime) return 'specific';
					return '';
				})();

				function formatSavedAdminDateInput(value) {
					var raw = String(value || '').trim();
					var matches;
					var year;
					if (raw === '') {
						return '';
					}
					matches = raw.match(/^(\d{4})-(\d{2})-(\d{2})(?:\s.*)?$/);
					if (matches) {
						return matches[3] + '/' + matches[2] + '/' + String(parseInt(matches[1], 10) + 543);
					}
					matches = raw.match(/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/);
					if (matches) {
						year = parseInt(matches[3], 10);
						if (year < 2400) {
							year += 543;
						}
						return String(parseInt(matches[1], 10)).padStart(2, '0') + '/' +
							String(parseInt(matches[2], 10)).padStart(2, '0') + '/' +
							String(year);
					}
					return raw;
				}

				// 1. Populate simple text/select inputs by name or id
				var simpleMappings = {
					'date_so': savedSo.date_so,
					'suggest': savedSo.suggest,
					'bill_id': savedSo.bill_id,
					'pre_name': savedSo.pre_name,
					'bill_name': savedSo.bill_name,
					'bill_address': savedSo.bill_address,
					'bill_tel': savedSo.bill_tel,
					'tax_id': savedSo.tax_id,
					'payment': savedSo.payment,
					'payment_method': savedSo.payment_method,
					'payment_des': savedSo.payment_des,
					'cm_no': savedSo.cm_no,
					'date_tranfer': savedSo.date_tranfer,
					'po_no': savedSo.po_no,
					'delivery_contract': savedSo.delivery_contract,
					'shipping_date': savedSo.date_ker || '',
					'shipping_ref1': savedSo.order_refer_code || '',
					'shipping_ref2': savedSo.order_refer_code1 || '',
					'shipping_cost': savedSo.ker_bath || '',
					'book_no': savedSo.book_no,
					'brn_no': savedSo.brn_no,
					'brnp_no': savedSo.brnp_no,
					'sn_no': savedSo.sn_no,
					'pr_no': savedSo.pr_no,
					'type_detail': savedSo.type_detail,
					'delivery_type': savedSo.delivery_type,
					'start_date': savedSo.delivery_date,
					'address_name': savedSo.delivery_address,
					'customer_name': savedSo.delivery_contact,
					'customer_tel': savedSo.delivery_tel,
					'address_send': savedSo.install_place,
					'address_1': savedSo.address_1,
					'sale_code': savedSo.sale_code,
					'sale_channel': savedSo.sale_channel || '',
					// Address main:
					'contact_name': savedSo.delivery_contact || (savedRegister && savedRegister.customer_name) || '',
					'contact_tel': savedSo.delivery_tel || (savedRegister && savedRegister.customer_tel) || '',
					'contact_province': savedSo.province_name || (savedRegister && savedRegister.province_name) || '',
					'shipping_address': savedSo.delivery_address || (savedRegister && savedRegister.address_name) || '',
					'install_location': savedSo.install_place || (savedRegister && savedRegister.address_send) || '',
					// Address details (mapped from tb_transaction):
					'park_location': savedTransaction ? (savedTransaction.car_park || '') : '',
					'stair_count': savedTransaction ? (savedTransaction.unit_bundai || '') : '',
					'install_floor': savedTransaction ? (savedTransaction.install || '') : '',
					'door_width': savedTransaction ? (savedTransaction.room_bigger || '') : '',
					'door_height': savedTransaction ? (savedTransaction.room_longer || '') : '',
					'elev_capacity': savedTransaction ? (savedTransaction.lip_weight || '') : '',
					'move_furn_count': savedTransaction ? (savedTransaction.employee_unit || '') : '',
					'move_furn_detail': savedTransaction ? (savedTransaction.ferniger_name || '') : '',
					'addr_note': savedTransaction ? (savedTransaction.description || '') : '',
					// Autocomplete employee mappings:
					'employee_name': (savedRegister && savedRegister.employee_name) || '',
					'h_employee_name': (savedRegister && savedRegister.h_employee_name) || '',
					// Delivery schedule fields:
					'between_date': savedSo.date_send_key || (savedRegister && savedRegister.between_date) || '',
					'status_comment': (savedRegister && savedRegister.description) || (savedRegister && savedRegister.status_comment) || savedSo.status_comment || '',
					// Shipping extras:
					'transport_company': savedSo.transport_company || '',
					// Admin:
					'admin_doc_no': savedSo.iv_no || '',
					'admin_work_no': savedSo.job_no || '',
					'admin_sr_no': savedSo.sr_no || '',
					'admin_deposit_no': savedSo.order_no || '',
					'admin_doc_date': formatSavedAdminDateInput(savedSo.iv_date || ''),
					'admin_box_count': (savedRegister && savedRegister.count_box !== undefined && savedRegister.count_box !== null) ? savedRegister.count_box : '',
					'admin_edit_count': savedSo.new_bill || '',
					'admin_old_doc_date': formatSavedAdminDateInput(savedSo.date_oldbill || ''),
					'admin_edit_reason': savedSo.desnew_bill || '',
					'admin_cancel_reason': savedSo.remark_cancel || '',
					'time_range': inferredTimeRange
				};

				// Set simple field values
				Object.keys(simpleMappings).forEach(function(key) {
					var val = simpleMappings[key];
					if (val !== undefined && val !== null) {
						var inputs = document.querySelectorAll('[name="' + key + '"], #' + key);
						inputs.forEach(function(input) {
							if (input.type !== 'radio' && input.type !== 'checkbox') {
								input.value = val;
							}
						});
					}
				});

				if (savedTransaction) {
					var stairParts = splitSizeParts(savedTransaction.bundai_big, 2);
					setFieldValueBySelector('input[name="stair_width"]', stairParts[0]);
					setFieldValueBySelector('input[name="stair_height"]', stairParts[1]);

					var elevDoorParts = splitSizeParts(savedTransaction.lip_big, 2);
					setFieldValueBySelector('input[name="elev_door_width"]', elevDoorParts[0]);
					setFieldValueBySelector('input[name="elev_door_height"]', elevDoorParts[1]);

					var elevRoomParts = splitSizeParts(savedTransaction.lip_long, 3);
					setFieldValueBySelector('input[name="elev_width"]', elevRoomParts[0]);
					setFieldValueBySelector('input[name="elev_height"]', elevRoomParts[1]);
					setFieldValueBySelector('input[name="elev_depth"]', elevRoomParts[2]);
				}

				// Populate customer card display inputs
				var savedBillId = savedSo.bill_id || '';
				if (savedBillId !== '') {
					window.isInitialDraftLoad = true;
					var hBillIdElem = document.getElementById('h_bill_id');
					if (hBillIdElem) hBillIdElem.value = savedBillId;
					var displayBillId = document.getElementById('display_bill_id');
					if (displayBillId) displayBillId.textContent = savedBillId;
					setElementValue('display_bill_name', savedSo.bill_name || '');
					setElementValue('display_bill_tel', savedSo.bill_tel || '');
					setElementValue('display_mode_name', savedSo.mode_cus || '');

					doCallAjax1(savedBillId, 'bill_name', 'bill_address', 'bill_tel', 'tax_id', 'pre_name', 'mode_name', 'email', 'customer_typename', 'payment', 'credit_thb', undefined, function(success) {
						if (success) {
							// Restore specific saved order overrides
							if (savedSo.bill_name) document.getElementById('bill_name').value = savedSo.bill_name;
							if (savedSo.bill_address) document.getElementById('bill_address').value = savedSo.bill_address;
							if (savedSo.bill_tel) document.getElementById('bill_tel').value = savedSo.bill_tel;
							if (savedSo.tax_id) document.getElementById('tax_id').value = savedSo.tax_id;
							if (savedSo.pre_name) document.getElementById('pre_name').value = savedSo.pre_name;
							if (savedSo.install_place) {
								setFieldValueBySelector('input[name="install_location"]', savedSo.install_place);
								setLegacyFieldValue('address_send', savedSo.install_place, 'address_send');
							}

							var paymentMethodSelect = document.getElementById('payment_method');
							if (paymentMethodSelect) {
								var savedPaymentMethod = savedSo.payment_method ? String(savedSo.payment_method) : '';
								paymentMethodSelect.setAttribute('data-saved-value', savedPaymentMethod);
								if (savedPaymentMethod) {
									paymentMethodSelect.value = savedPaymentMethod;
								}
							}

							var isCreditPayment = (savedSo.payment !== '0' && savedSo.payment !== '');
							if (isCreditPayment) {
								switchPaymentMode('credit');
								setTimeout(function() {
									var sel = document.getElementById('payment');
									if (sel) {
										sel.value = savedSo.payment;
										updateCreditDisplay();
									}
								}, 500);
							} else {
								switchPaymentMode('cash');
								setTimeout(function() {
									var sel = document.getElementById('payment');
									if (sel) {
										sel.value = savedSo.payment;
										var cashSel = document.getElementById('payment_cash_select');
										if (cashSel) cashSel.value = savedSo.payment;
									}
								}, 500);
							}
						}
					});
				}

				// 2. Handle type_doc (company) select and doc_type_select
				if (savedSo.type_doc) {
					// Set company select (AWL=3, NBM=4)
					var typeDocSel = document.getElementById('type_doc_select');
					if (typeDocSel) {
						typeDocSel.value = savedSo.type_doc;
					}
					// Also sync hidden radio if exists
					var typeDocRadio = document.querySelector('input[name="type_doc"][value="' + savedSo.type_doc + '"]');
					if (typeDocRadio) {
						typeDocRadio.checked = true;
					}
				}
				// Set document type select based on ic_ckk/et_ckk
				(function() {
					var docTypeSel = document.getElementById('doc_type_select');
					if (!docTypeSel) return;
					if (savedSo.ic_ckk === '1') {
						docTypeSel.value = '3';
					} else if (savedSo.et_ckk === '1') {
						docTypeSel.value = '2';
					} else {
						docTypeSel.value = '1';
					}
				})();

				// 3. Handle type_type radio buttons (รูปแบบการพิมพ์)
				if (savedSo.type_type) {
					var typeTypeRadio = document.querySelector('input[name="type_type"][value="' + savedSo.type_type + '"]');
					if (typeTypeRadio) {
						typeTypeRadio.checked = true;
						if (typeof ckk_1 === 'function') {
							ckk_1();
						}
					}
				}

				// 4. Handle address details radio buttons
				var parkFrontVal = '';
				if (savedTransaction) {
					parkFrontVal = savedTransaction.car_home === '1' ? '1' : (savedTransaction.car_road === '1' ? '0' : '');
				}
				if (parkFrontVal !== '') {
					var pfRadio = document.querySelector('input[name="park_front"][value="' + parkFrontVal + '"]');
					if (pfRadio) pfRadio.checked = true;
				}

				var entTypeVal = '';
				if (savedTransaction) {
					entTypeVal = savedTransaction.slope === '1' ? '1' : (savedTransaction.bundai === '1' ? '2' : '');
				}
				if (entTypeVal !== '') {
					var entRadio = document.querySelector('input[name="entrance_type"][value="' + entTypeVal + '"]');
					if (entRadio) {
						entRadio.checked = true;
						if (typeof ckk_2 === 'function') {
							ckk_2();
						}
					}
				}

				var roomTypeVal = '';
				if (savedTransaction) {
					roomTypeVal = savedTransaction.install_room || savedTransaction.home_type || '';
				}
				if (roomTypeVal) {
					var rtRadio = document.querySelector('input[name="room_type"][value="' + roomTypeVal + '"]');
					if (rtRadio) rtRadio.checked = true;
				}

				if (savedTransaction && savedTransaction.want_employee) {
					var mfRadio = document.querySelector('input[name="move_furn"][value="' + savedTransaction.want_employee + '"]');
					if (mfRadio) {
						mfRadio.checked = true;
						if (typeof object === 'function') {
							object();
						}
					}
				}

				// 5. Handle checkboxes (รวม toggle pills)
				var checkboxes = ['with_pr', 'sn_ckk', 'book_clear', 'brn_clear', 'brnp_clear', 'full_bill', 'ic_ckk', 'et_ckk', 'que_ckk', 'have_order', 'plan_ckk', 'repeat_cus'];
				checkboxes.forEach(function(cbName) {
					var checkedVal = savedSo[cbName];
					var cb = document.getElementById(cbName) || document.querySelector('input[type="checkbox"][name="' + cbName + '"]');
					if (cb) {
						if (typeof applySavedToggleState === 'function') {
							applySavedToggleState(cb, checkedVal);
						} else {
							cb.checked = (String(checkedVal).trim() === '1');
							if (typeof updateToggleStyle === 'function') {
								updateToggleStyle(cb);
							}
						}
					}
				});

				var callCustomerCheckbox = document.querySelector('input[name="call_customer"]');
				if (callCustomerCheckbox && savedRegister) {
					callCustomerCheckbox.checked = (savedRegister.call_customer === '1');
					callCustomerCheckbox.dispatchEvent(new Event('change'));
				}

				var ref12Checkbox = document.querySelector('input[name="ref_12"]');
				if (ref12Checkbox && savedOtherBill) {
					ref12Checkbox.checked = (savedOtherBill.ref_12 === '1');
					ref12Checkbox.dispatchEvent(new Event('change'));
				}

				var hrCb = document.querySelector('input[name="is_high_roof"]');
				if (hrCb && savedTransaction) {
					hrCb.checked = (savedTransaction.height_ltd === '1');
					hrCb.dispatchEvent(new Event('change'));
				}

				// 6. Handle comments from savedCommentSo and tb_comment_so_item
				if (savedCommentSo) {
					if (document.getElementById('hidden_comment_cs')) document.getElementById('hidden_comment_cs').value = savedCommentSo.comment_cs || '';
					if (document.getElementById('hidden_comment_en')) document.getElementById('hidden_comment_en').value = savedCommentSo.comment_en || '';
					if (document.getElementById('hidden_comment_st')) document.getElementById('hidden_comment_st').value = savedCommentSo.comment_st || '';
					if (document.getElementById('hidden_comment_ad')) document.getElementById('hidden_comment_ad').value = savedCommentSo.comment_ad || '';
					if (typeof setTechnicianRequired === 'function') {
						setTechnicianRequired(savedCommentSo.technician_required === '1' || savedCommentSo.technician_required === 1);
					}
				} else if (typeof setTechnicianRequired === 'function') {
					setTechnicianRequired(false);
				}

				if (typeof addDeptComment === 'function' && typeof syncDeptComments === 'function') {
					var list = document.getElementById('dept_comment_list');
					if (list) list.innerHTML = '';

					var addedAny = false;
					if (Array.isArray(savedCommentSoItems) && savedCommentSoItems.length > 0) {
						savedCommentSoItems.forEach(function(item) {
							if (item.message && item.message.trim() !== '') {
								addDeptComment(item.department_id, item.message);
								addedAny = true;
							}
						});
					} else if (savedCommentSo) {
						var depts = ['cs', 'en', 'st', 'ad'];
						depts.forEach(function(dept) {
							var commentText = savedCommentSo['comment_' + dept];
							if (commentText && commentText.trim() !== '') {
								var lines = commentText.split('\n');
								lines.forEach(function(line) {
									addDeptComment(dept, line);
									addedAny = true;
								});
							}
						});
					}
					if (!addedAny) {
						addDeptComment();
					}
				}

				// 7. Handle checkboxed other fields in tb_other_bill
				if (savedOtherBill) {
					var otherCheckboxes = ['ref_1', 'ref_2', 'ref_3', 'ref_4', 'ref_5', 'ref_6', 'ref_7', 'ref_8', 'ref_9', 'ref_10', 'ref_11', 'ref_12', 'ref_13', 'head_1'];
					otherCheckboxes.forEach(function(cbName) {
						var cbVal = savedOtherBill[cbName];
						var cb = document.querySelector('input[name="' + cbName + '"]');
						if (cb) {
							cb.checked = (cbVal === '1');
						}
					});
					if (savedOtherBill.ref_des) {
						var refDesInput = document.querySelector('input[name="ref_des"]');
						if (refDesInput) {
							refDesInput.value = savedOtherBill.ref_des;
						}
					}
				}

				// 8. Handle start_time and end_time
				if (savedSo.delivery_time && savedSo.delivery_time.trim() !== '') {
					var timeParts = savedSo.delivery_time.match(/\b(?:[01]?\d|2[0-3]):[0-5]\d(?::[0-5]\d)?\b/g) || [];
					if (timeParts.length > 0 && document.querySelector('input[name="start_time"]')) {
						document.querySelector('input[name="start_time"]').value = normalizeTimeInputValue(timeParts[0]);
					}
					if (timeParts.length > 1 && document.querySelector('input[name="end_time"]')) {
						document.querySelector('input[name="end_time"]').value = normalizeTimeInputValue(timeParts[1]);
					}
				} else if (savedRegister) {
					// Fallback: ดึงเวลาจาก tb_register_data
					if (savedRegister.start_time && document.querySelector('input[name="start_time"]')) {
						document.querySelector('input[name="start_time"]').value = normalizeTimeInputValue(savedRegister.start_time);
					}
					if (savedRegister.end_time && document.querySelector('input[name="end_time"]')) {
						document.querySelector('input[name="end_time"]').value = normalizeTimeInputValue(savedRegister.end_time);
					}
				}

				// 9. Restore extra delivery addresses from tb_shipping_address first, then fallback to tb_delivery_print
				if (Array.isArray(savedShippingAddresses) && savedShippingAddresses.length > 0) {
					var existingExtraRows = document.querySelectorAll('#extra_address_list .extra-addr-row').length;
					while (existingExtraRows < savedShippingAddresses.length && typeof addExtraAddress === 'function') {
						addExtraAddress();
						existingExtraRows++;
					}

					savedShippingAddresses.forEach(function(item, index) {
						var displayIndex = index + 1;
						var extraNameInput = document.querySelector('input[name="extra_contact_name_' + displayIndex + '"]');
						var extraTelInput = document.querySelector('input[name="extra_contact_tel_' + displayIndex + '"]');
						var extraProvinceInput = document.querySelector('select[name="extra_contact_province_' + displayIndex + '"]');
						var extraAddressInput = document.querySelector('input[name="extra_shipping_address_' + displayIndex + '"]');

						if (extraNameInput) extraNameInput.value = item.contact_name || '';
						if (extraTelInput) extraTelInput.value = item.telephone || '';
						if (extraProvinceInput) extraProvinceInput.value = item.province || '';
						if (extraAddressInput) extraAddressInput.value = item.address || '';
					});
				} else if (savedDeliveryPrint) {
					var extraAddressItems = [];
					for (var extraIndex = 1; extraIndex <= 9; extraIndex++) {
						var nameValue = savedDeliveryPrint['customer_name' + extraIndex] || '';
						var telValue = savedDeliveryPrint['customer_tel' + extraIndex] || '';
						var provinceValue = savedDeliveryPrint['province_name' + extraIndex] || '';
						var addressValue = savedDeliveryPrint['address_name' + extraIndex] || '';

						if (nameValue || telValue || provinceValue || addressValue) {
							extraAddressItems.push({
								name: nameValue,
								tel: telValue,
								province: provinceValue,
								address: addressValue
							});
						}
					}

					if (extraAddressItems.length > 0) {
						var existingExtraRows = document.querySelectorAll('#extra_address_list .extra-addr-row').length;
						while (existingExtraRows < extraAddressItems.length && typeof addExtraAddress === 'function') {
							addExtraAddress();
							existingExtraRows++;
						}

						extraAddressItems.forEach(function(item, index) {
							var displayIndex = index + 1;
							var extraNameInput = document.querySelector('input[name="extra_contact_name_' + displayIndex + '"]');
							var extraTelInput = document.querySelector('input[name="extra_contact_tel_' + displayIndex + '"]');
							var extraProvinceInput = document.querySelector('select[name="extra_contact_province_' + displayIndex + '"]');
							var extraAddressInput = document.querySelector('input[name="extra_shipping_address_' + displayIndex + '"]');

							if (extraNameInput) extraNameInput.value = item.name;
							if (extraTelInput) extraTelInput.value = item.tel;
							if (extraProvinceInput) extraProvinceInput.value = item.province;
							if (extraAddressInput) extraAddressInput.value = item.address;
						});
					}
				}

				// 10. Handle Products table
				if (Array.isArray(savedProducts) && savedProducts.length > 0) {
					savedProducts.forEach(function(prod, index) {
						var i = index + 1;
						if (i <= 30) {
							var rowFields = {
								'subso_db_id': prod.id || prod.ID || '',
								'product_id': prod.product_id || prod.product_ID || '',
								'product_sn': prod.sn || prod.product_sn || '',
								'unit_name': prod.unit_name,
								'warranty': prod.warranty,
								'cal': prod.cal,
								'pm': prod.pm,
								'pm_year': prod.pm_year,
								'sale_remarkk': prod.sale_remark,
								'clear_br': prod.clear_br,
								'clear_ivno': prod.clear_ivno,
								'jong_ckk': prod.jong_ckk,
								'jong_no': prod.jong_no,
								'display_name': prod.admin_remark || prod.display_name,
								'product_codet': prod.product_code || prod.product_codet,
								'product_name': prod.product_name,
								'sale_count': prod.count,
								'product_price': prod.price,
								'discount_unit': prod.discount,
								'sum_amount': prod.amount
							};

							Object.keys(rowFields).forEach(function(key) {
								var el = document.getElementById(key + i) || document.querySelector('input[name="' + key + i + '"]');
								if (el) {
									el.value = rowFields[key] || '';
								}
							});

							var labelEl = document.getElementById('product_name_label' + i);
							if (labelEl) {
								labelEl.textContent = prod.product_name || '';
							}

							var row = document.getElementById('product_row_' + i);
							if (row) {
								row.style.display = '';
							}
						}
					});
				}

				// 11. Sync compatibility fields and calculate grand total
				if (typeof syncFormCompatibilityFields === 'function') {
					syncFormCompatibilityFields();
				}
				if (typeof calculateSummary === 'function') {
					calculateSummary();
				}
				if (typeof renderFileList === 'function') {
					renderFileList();
				}
			});
		</script>
		<?php endif; ?>
	<script src="js/credit-term-modal.js?v=<?php echo filemtime(__DIR__ . '/js/credit-term-modal.js'); ?>"></script>




