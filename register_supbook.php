<?php include('head.php');
include('dbconnect.php');
include('dbconnect_sale.php');

$savedRefId = isset($_GET["ref_id"]) ? mysqli_real_escape_string($conn, $_GET["ref_id"]) : "";
$savedJong = null;
$savedProducts = [];

if ($savedRefId !== "") {
	$savedJongQuery = mysqli_query($conn, "SELECT * FROM hos__jongproduct WHERE ref_id = '" . $savedRefId . "' LIMIT 1");
	if ($savedJongQuery) {
		$savedJong = mysqli_fetch_assoc($savedJongQuery);
	}
	// Load products
	$savedProductsQuery = mysqli_query($conn, "SELECT sj.*, p.access_code, p.access_name, p.sol_name, p.unit_name FROM hos__subjongpro sj LEFT JOIN tb_product p ON sj.product_id = p.product_ID WHERE sj.ref_idd = '" . $savedRefId . "'");
	if ($savedProductsQuery) {
		while ($row = mysqli_fetch_assoc($savedProductsQuery)) {
			$displayName = (!empty($row['sol_name'])) ? $row['sol_name'] : ($row['access_name'] ?? $row['product_code']);
			$savedProducts[] = [
				'product_id' => $row['product_id'],
				'product_code' => $row['access_code'] ?? $row['product_code'],
				'product_name' => $displayName,
				'unit_name' => $row['unit_name'] ?? '',
				'count' => (float)$row['count'],
				'remark' => $row['sale_remark'],
				'showRemark' => !empty($row['sale_remark']),
				'id' => $row['id']
			];
		}
	}
}
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="css/credit-term-modal.css?v=20260704">
<link rel="stylesheet" href="css/customer-popup.css">

<link rel="stylesheet" href="css/autocomplete.css" type="text/css" />
<script type="text/javascript" src="js/autocomplete.js"></script>
<script type="text/javascript" src="js/customer-popup.js"></script>

<style>
	@import url('https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap');

	body {
		background-color: #F4EFF8 !important;
		background-image: none !important;
		font-family: 'Prompt', sans-serif !important;
		color: #3B3B3B !important;
		margin: 0;
		padding: 20px 0 0 0;
	}

	.so-card {
		background: #FFFFFF;
		border-radius: 10px;
		border: 1px solid #EFEBEF;
		box-shadow: 0 4px 20px rgba(97, 41, 137, 0.04);
		padding: clamp(16px, 3vw, 32px);
		max-width: 1096px;
		margin: 0 auto 30px auto;
		box-sizing: border-box;
	}

	/* Modern Header Layout (เหมือน register_suphos.php) */
	.so-header-container {
		display: flex;
		justify-content: space-between;
		align-items: center;
		margin: 0 auto;
		padding: 16px 0;
		width: 100%;
		max-width: 1096px;
		box-sizing: border-box;
		flex-wrap: wrap;
		gap: 12px;
	}

	.so-header-left {
		display: flex;
		flex-direction: column;
		min-width: 0;
	}

	.so-title {
		font-size: 28px;
		font-weight: 600;
		color: #612989;
		line-height: 1.15;
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
		flex-wrap: wrap;
	}

	.btn-preview-so {
		background-color: #FFFFFF;
		color: #612989;
		border: 1px solid transparent;
		border-radius: 20px;
		height: 44px;
		padding: 0 24px;
		font-size: 14px;
		font-weight: 600;
		cursor: pointer;
		transition: all 0.2s ease;
		display: inline-flex;
		align-items: center;
		justify-content: center;
		gap: 8px;
		font-family: 'Prompt', sans-serif;
		box-shadow: 0px 0px 4px 0px rgba(0, 0, 0, 0.25);
	}

	.btn-preview-so:hover {
		background-color: #FAF9FC;
		opacity: 0.9;
	}

	/* Tab content */
	.so-tab-content {
		display: none;
	}

	.so-tab-content.active {
		display: block;
		background-color: transparent;
	}

	/* Section Title (หัวข้อภายในกล่อง so-card) */
	.so-section-title-container {
		margin: 0 0 24px 0;
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

	/* หัวข้อย่อยภายในกล่อง (เล็กกว่าชื่อกล่องหลัก) */
	.so-subsection-title-container {
		margin: 24px 0 24px 0;
		border-bottom: 1px solid #EFEBEF;
		padding-bottom: 12px;
	}

	.so-subsection-title {
		font-size: 15px;
		font-weight: 600;
		color: #3B3B3B;
		margin: 0;
	}

	@media (max-width: 768px) {
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

		.so-card {
			padding: 24px 18px;
		}

		.so-title {
			font-size: clamp(24px, 6vw, 28px);
		}

		.so-section-title {
			font-size: 18px;
		}
	}

	.so-grid-2 {
		display: grid;
		grid-template-columns: 1fr 1fr;
		gap: 32px;
	}

	.so-grid-3 {
		display: grid;
		grid-template-columns: 1fr 1fr 1fr;
		gap: 24px;
	}

	@media (max-width: 900px) {
		.so-grid-3 {
			grid-template-columns: 1fr 1fr;
		}
	}

	@media (max-width: 768px) {

		.so-grid-2,
		.so-grid-3 {
			grid-template-columns: 1fr;
			gap: 16px;
		}
	}

	.so-field-group {
		display: flex;
		flex-direction: column;
		gap: 6px;
		margin-bottom: 18px;
	}

	.so-label {
		font-size: 14px;
		font-weight: 500;
		color: #612989;
		margin-bottom: 2px;
		display: inline-block;
	}

	.so-input,
	.so-select,
	.so-textarea {
		width: 100%;
		border-radius: 10px;
		background: #F5F6F8;
		border: 1px solid transparent;
		font-size: 14px;
		font-family: 'Prompt', sans-serif !important;
		transition: all 0.3s ease;
		color: #3B3B3B;
		box-sizing: border-box;
	}

	.so-input,
	.so-select {
		height: 42px;
		padding: 0 16px;
	}

	.so-textarea {
		padding: 12px 16px;
		min-height: 80px;
		resize: vertical;
	}

	.so-input:focus,
	.so-select:focus,
	.so-textarea:focus {
		background: #FFFFFF;
		border-color: #612989;
		box-shadow: 0 0 0 3px rgba(97, 41, 137, 0.1);
		outline: none;
	}

	.so-input:disabled,
	.so-select:disabled {
		color: #8E8B94;
		cursor: not-allowed;
	}

	.so-input-wrapper {
		position: relative;
		width: 100%;
	}

	.so-input-wrapper .so-input {
		padding-right: 36px;
	}

	.so-select-wrapper {
		position: relative;
		width: 100%;
		display: flex;
	}

	.so-select-wrapper .so-select {
		padding-right: 32px;
		appearance: none;
		-webkit-appearance: none;
		-moz-appearance: none;
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

	.so-clear-icon {
		position: absolute;
		right: 12px;
		top: 50%;
		transform: translateY(-50%);
		cursor: pointer;
		color: #8E8B94;
		font-size: 14px;
	}

	.so-clear-icon:hover {
		color: #612989;
	}

	.so-radio-group {
		display: flex;
		flex-wrap: wrap;
		gap: 20px;
		margin-top: 4px;
		margin-bottom: 4px;
	}

	.so-radio-label {
		display: flex;
		align-items: center;
		gap: 8px;
		font-size: 14px;
		font-weight: 500;
		color: #3B3B3B;
		cursor: pointer;
	}

	.so-radio-label input[type="radio"] {
		accent-color: #612989;
		width: 18px;
		height: 18px;
		cursor: pointer;
		margin: 0;
	}

	.btn-so-primary {
		background: #612989;
		color: #FFFFFF;
		border: none;
		border-radius: 24px;
		height: 44px;
		padding: 0 48px;
		font-size: 16px;
		font-weight: 600;
		cursor: pointer;
		transition: all 0.3s ease;
		box-shadow: 0 4px 12px rgba(97, 41, 137, 0.2);
		display: inline-flex;
		align-items: center;
		justify-content: center;
		gap: 8px;
		text-decoration: none;
	}

	.btn-so-primary:hover {
		background: #502173;
		box-shadow: 0 6px 16px rgba(97, 41, 137, 0.3);
		color: #FFFFFF;
	}

	.btn-so-secondary {
		background: #FFFFFF;
		color: #612989;
		border: 1px solid #EFEBEF;
		border-radius: 24px;
		height: 42px;
		padding: 0 24px;
		font-weight: 500;
		cursor: pointer;
		transition: all 0.3s ease;
		display: inline-flex;
		align-items: center;
		gap: 8px;
	}

	.btn-so-secondary:hover {
		background: #EFEBFF;
		border-color: #612989;
	}

	/* Tabs (เหมือน register_suphos.php) */
	.so-tabs-container {
		display: flex;
		background-color: transparent;
		margin: 0 auto -1px auto;
		padding-left: 50px;
		position: relative;
		max-width: 1096px;
		box-sizing: border-box;
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

	@media (max-width: 768px) {
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
	}

	.so-search-input-wrapper {
		position: relative;
		width: 100%;
		display: flex;
		align-items: center;
	}

	.so-search-input-wrapper input {
		padding-right: 46px;
		cursor: pointer;
	}

	.so-search-input-btn {
		position: absolute;
		right: 6px;
		background: transparent;
		border: none;
		color: #612989;
		cursor: pointer;
		font-size: 16px;
		display: flex;
		align-items: center;
		justify-content: center;
		height: 30px;
		width: 36px;
		transition: color 0.2s;
	}

	.so-search-input-btn:hover {
		color: #502173;
	}

	/* Autocomplete Overrides */
	.autocomplete_list {
		background: #FFFFFF !important;
		border: 1px solid #EFEBEF !important;
		border-radius: 8px !important;
		box-shadow: 0 4px 12px rgba(97, 41, 137, 0.08) !important;
		padding: 4px 0 !important;
		z-index: 99999 !important;
		max-height: 250px !important;
		overflow-y: auto !important;
	}

	.autocomplete_list li {
		font-family: 'Prompt', sans-serif !important;
		padding: 8px 16px !important;
		color: #3B3B3B !important;
		border-bottom: 1px solid #F5F6F8 !important;
		font-size: 14px !important;
		transition: background 0.2s, color 0.2s;
	}

	.autocomplete_list li b {
		color: #612989 !important;
	}

	.autocomplete_list .current_item {
		background: #EFEBFF !important;
		color: #612989 !important;
	}

	/* Customer Popup Modal Styling moved to css/customer-popup.css */

	/* Dynamic product list */
	.so-product-section-header {
		display: flex;
		align-items: center;
		justify-content: space-between;
		margin-bottom: 16px;
	}

	.so-product-count {
		font-size: 14px;
		color: #612989;
		font-weight: 500;
	}

	.so-product-total-box {
		background: #F5F6F8;
		border-radius: 10px;
		padding: 14px 20px;
		display: flex;
		flex-direction: column;
		align-items: center;
		justify-content: center;
		gap: 6px;
		margin-bottom: 16px;
	}

	.so-product-total-label {
		font-size: 14px;
		color: #8E8B94;
		font-weight: 400;
	}

	.so-product-total-value {
		font-size: 20px;
		color: #3B3B3B;
		font-weight: 600;
	}

	.so-product-search-wrap {
		position: relative;
		display: flex;
		align-items: center;
		background: #F5F6F8;
		border-radius: 10px;
		border: 1px solid transparent;
		padding: 0 16px;
		height: 42px;
		gap: 10px;
		margin-bottom: 16px;
	}

	.so-product-search-wrap:focus-within {
		background: #FFFFFF;
		border-color: #612989;
		box-shadow: 0 0 0 3px rgba(97, 41, 137, 0.1);
	}

	.so-product-search-wrap i {
		color: #8E8B94;
	}

	.so-product-search-wrap input {
		border: 0;
		outline: none;
		background: transparent;
		width: 100%;
		font-size: 14px;
		font-family: 'Prompt', sans-serif;
		color: #000000;
	}

	.product-search-dropdown {
		display: none;
		position: absolute;
		top: calc(100% + 4px);
		left: 0;
		right: 0;
		background: #FFFFFF;
		border: 1px solid #EFEBEF;
		border-radius: 8px;
		box-shadow: 0 4px 12px rgba(97, 41, 137, 0.08);
		max-height: 260px;
		overflow-y: auto;
		z-index: 500;
	}

	.product-search-item {
		padding: 10px 16px;
		font-size: 14px;
		cursor: pointer;
		border-bottom: 1px solid #F5F6F8;
		color: #000000;
	}

	.product-search-item:hover {
		background: #F1E1FF;
	}

	.product-search-empty {
		padding: 16px;
		text-align: center;
		color: #8E8B94;
		font-size: 14px;
	}

	.so-product-table-wrap {
		width: 100%;
		overflow-x: auto;
		-webkit-overflow-scrolling: touch;
	}

	.so-product-dyn-table {
		width: 100%;
		min-width: 480px;
		border-collapse: collapse;
		font-family: 'Prompt', sans-serif;
	}

	.so-product-dyn-table th {
		text-align: left;
		font-size: 14px;
		font-weight: 500;
		color: #612989;
		border-bottom: 1px solid #612989;
		padding: 10px 8px;
	}

	.so-product-dyn-table td {
		padding: 10px 8px;
		border-bottom: 1px solid #EDE9F0;
		font-size: 14px;
		vertical-align: middle;
		color: #000000;
	}

	.so-product-dyn-table .col-handle {
		width: 32px;
		text-align: center;
		color: #C9C2D4;
		cursor: grab;
	}

	.so-product-dyn-table .col-qty {
		width: 110px;
	}

	.so-product-dyn-table .col-actions {
		width: 80px;
		text-align: right;
		white-space: nowrap;
	}

	.product-qty-input {
		height: 36px !important;
		padding: 0 10px !important;
		text-align: center;
		color: #000000 !important;
	}

	.product-row-icon-btn {
		background: transparent;
		border: none;
		color: #8E8B94;
		cursor: pointer;
		font-size: 14px;
		padding: 6px;
		transition: color 0.2s;
	}

	.product-row-icon-btn:hover {
		color: #612989;
	}

	.product-row-remark-text {
		margin-top: 4px;
		font-size: 13px;
		color: #8E8B94;
	}

	.product-empty {
		text-align: center;
		color: #8E8B94;
		padding: 24px !important;
	}

	.product-row.drag-over {
		background: #F1E1FF;
	}

	/* Customer info card (ข้อมูลลูกค้า) */
	.so-customer-top-grid {
		display: grid;
		grid-template-columns: 328px 1fr;
		gap: 24px;
		margin-bottom: 0;
	}

	.so-customer-top-left {
		grid-column: 1;
		grid-row: 1;
		display: flex;
		flex-direction: column;
		justify-content: space-between;
	}

	.so-customer-top-right {
		grid-column: 2;
		grid-row: 1;
		display: flex;
		flex-direction: column;
	}

	.so-customer-address-wrap {
		grid-column: 1 / span 2;
		grid-row: 2;
	}

	.so-customer-pills-row {
		display: flex;
		gap: 16px;
		align-items: center;
		height: 42px;
		margin-bottom: 4px;
	}

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

	@media (max-width: 768px) {
		.so-customer-top-grid {
			grid-template-columns: 1fr;
			gap: 16px;
		}

		.so-customer-top-left {
			grid-column: auto;
			grid-row: auto;
			justify-content: flex-start;
			gap: 16px;
		}

		.so-customer-top-right {
			grid-column: auto;
			grid-row: auto;
		}

		.so-customer-address-wrap {
			grid-column: auto;
			grid-row: auto;
		}

		.customer-info-display-card {
			flex-direction: column;
			gap: 18px;
			padding: 18px;
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

	/* Credit term trigger + popup (shared logic lives in js/credit-term-modal.js & css/credit-term-modal.css) */
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

	.clear-loan-header {
		padding: 24px 32px 0;
		border-bottom: 1px solid #eee7f4;
	}

	.credit-term-popup-box {
		width: min(1096px, 96vw);
		height: min(884px, 92vh);
	}

	.product-remark-popup-box {
		width: min(1096px, 92vw);
		height: auto;
	}

	.product-remark-popup-body {
		padding: 24px 32px 28px;
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

	@media (max-width: 768px) {
		.clear-loan-header {
			padding: 22px 18px 0;
		}
	}

	.so-sticky-actions {
		width: 100%;
		background-color: #FFFFFF;
		padding: 16px 24px;
		display: flex;
		gap: 16px;
		justify-content: flex-end;
		align-items: center;
		box-shadow: 0 -4px 10px rgba(0, 0, 0, 0.05);
		border-top: 1px solid #EBEBEB;
		margin-top: 24px;
		box-sizing: border-box;
	}

	.so-sticky-actions-inner {
		max-width: 1200px;
		width: 100%;
		display: flex;
		gap: 16px;
		justify-content: flex-end;
		margin: 0 auto;
		padding-right: 24px;
		box-sizing: border-box;
	}

	.btn-so-submit {
		background-color: #612989;
		color: #FFFFFF;
		border: 1px solid #612989;
		border-radius: 24px;
		padding: 12px 32px;
		font-family: 'Prompt', sans-serif;
		font-size: 16px;
		font-weight: 500;
		cursor: pointer;
		display: flex;
		align-items: center;
		gap: 8px;
		box-shadow: 0 4px 6px rgba(0, 0, 0, 0.08);
	}

	.btn-so-draft {
		background-color: #FFFFFF;
		color: #612989;
		border: 1px solid #EBEBEB;
		border-radius: 24px;
		padding: 12px 32px;
		font-family: 'Prompt', sans-serif;
		font-size: 16px;
		font-weight: 500;
		cursor: pointer;
		display: flex;
		align-items: center;
		gap: 8px;
		box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
	}

	@media (max-width: 768px) {
		.so-sticky-actions {
			padding: 14px 12px;
		}

		.so-sticky-actions-inner {
			padding-right: 0;
			flex-direction: column;
			align-items: stretch;
		}

		.so-sticky-actions-inner>button {
			width: 100%;
			justify-content: center;
		}
	}
</style>

<div class="w3-container register-so-main" style="max-width: 1200px; margin: 0 auto;">
	<?php
	$yearMonth = substr(date("Y") + 543, -2) . date("m");
	$sql = "SELECT MAX(ref_id) AS MAXID FROM hos__jongproduct";
	$qry = mysqli_query($conn, $sql) or die(mysqli_error());
	$rs = mysqli_fetch_assoc($qry);
	$maxId = substr($rs['MAXID'], -4);
	$maxId3 = substr($rs['MAXID'], -8);

	$maxId1 = substr($maxId3, 0, -4);
	$so = "PD";

	if ($maxId1 == $yearMonth) {
		$maxId1 = ($maxId + 1);
		$maxId2 = substr("00000" . $maxId1, -4);
		$nextId = $yearMonth . $maxId2;
	} else {
		$maxId1 = "0001";
		$nextId = $yearMonth . $maxId1;
	}

	date_default_timezone_set("Asia/Bangkok");

	$month = date('m');
	$day = date('d');
	$year = date('Y');

	$today = $year . '-' . $month . '-' . $day;
	?>

	<!-- Header Section -->
	<div class="so-header-container">
		<div class="so-header-left">
			<h1 class="so-title">Product Booking</h1>
			<div class="so-ref-info">
				<span class="so-ref-label">เลขที่จอง</span>
				<span class="so-ref-value"><?php echo $savedJong !== null ? $savedJong['ref_id'] : ($so . $nextId); ?></span>
			</div>
		</div>
		<div class="so-header-right">
			<button type="button" class="btn-preview-so" onclick="previewBooking();">
				<img src="img\icons\preview.png" alt=""> Preview
			</button>
		</div>
	</div>

	<form action="<?php echo ($savedJong !== null) ? 'register_supbook_edit1.php' : 'register_supbook1.php'; ?>" method="post" name="frmMain" enctype="multipart/form-data">
		<?php if ($savedJong !== null) { ?>
			<input type="hidden" name="ref_id" value="<?php echo htmlspecialchars($savedJong['ref_id'], ENT_QUOTES, 'UTF-8'); ?>">
		<?php } else { ?>
			<input type="hidden" name="ref_idsmp" value="<?php echo $so;
															echo $nextId; ?>">
		<?php } ?>


		<!-- Tab buttons -->
		<div class="so-tabs-container">
			<button type="button" class="so-tab-btn active" onclick="switchSoTab(event, 'tabDoc')">ข้อมูลเอกสาร</button>
			<button type="button" class="so-tab-btn" onclick="switchSoTab(event, 'tabAdmin')">Admin</button>
		</div>

		<!-- TAB 1: ข้อมูลเอกสาร -->
		<div id="tabDoc" class="so-tab-content active">

			<!-- กล่อง: ข้อมูลเอกสาร -->
			<div class="so-card">
				<div class="so-grid-3">
					<div class="so-field-group">
						<label class="so-label">บริษัท <span style="color:red;">*</span></label>
						<div class="so-select-wrapper">
							<select class="so-select" name="company" id="company_select">
								<option value="1" <?php echo ($savedJong !== null && $savedJong['company'] == '1') ? 'selected' : ''; ?>>AWL</option>
								<option value="2" <?php echo ($savedJong !== null && $savedJong['company'] == '2') ? 'selected' : ''; ?>>NBM</option>
							</select>
						</div>
					</div>

					<div class="so-field-group">
						<label class="so-label">ประเภทการจอง <span style="color:red;">*</span></label>
						<select name="type_jong" id="type_jong" class="so-select" required>
							<option value="">**Please Select**</option>
							<option value="1" <?php echo ($savedJong !== null && $savedJong['type_jong'] == '1') ? 'selected' : ''; ?>>จองมีสัญญา</option>
							<option value="2" <?php echo ($savedJong !== null && $savedJong['type_jong'] == '2') ? 'selected' : ''; ?>>จองตามการประมาณการ</option>
							<option value="3" <?php echo ($savedJong !== null && $savedJong['type_jong'] == '3') ? 'selected' : ''; ?>>จองสินค้าสาธิต</option>
						</select>
					</div>

					<div class="so-field-group">
						<label class="so-label" for="sale_code">แผนก/เขตการขาย <span style="color:red;">*</span></label>
						<?php
						$selected_sale_code = ($savedJong !== null) ? $savedJong['sale_code'] : ($_GET['sale_code'] ?? '');

						if ($_SESSION['code'] == 'SS1') {
						?>
							<select name="sale_code" id="sale_code" class="so-select" required>
								<option value="">**Please Select**</option>
								<?php
								$strSQL5 = "SELECT * FROM tb_team_ss1 ORDER BY sale_code ASC";
								$objQuery5 = mysqli_query($com, $strSQL5);
								while ($objResuut5 = mysqli_fetch_array($objQuery5)) {
									$sel = ($selected_sale_code == $objResuut5["sale_code"]) ? "selected" : "";
								?>
									<option value="<?php echo $objResuut5["sale_code"]; ?>" <?php echo $sel; ?>><?php echo $objResuut5["sale_code"]; ?> - <?php echo $objResuut5["sale_name"]; ?></option>
								<?php
								}
								?>
							</select>
						<?php
						} else if ($_SESSION['code'] == 'SS2') {
						?>
							<select name="sale_code" id="sale_code" class="so-select" required>
								<option value="">**Please Select**</option>
								<?php
								$strSQL5 = "SELECT * FROM tb_team_ss2 ORDER BY sale_code ASC";
								$objQuery5 = mysqli_query($com, $strSQL5);
								while ($objResuut5 = mysqli_fetch_array($objQuery5)) {
									$sel = ($selected_sale_code == $objResuut5["sale_code"]) ? "selected" : "";
								?>
									<option value="<?php echo $objResuut5["sale_code"]; ?>" <?php echo $sel; ?>><?php echo $objResuut5["sale_code"]; ?> - <?php echo $objResuut5["sale_name"]; ?></option>
								<?php
								}
								?>
							</select>
						<?php
						} else if ($_SESSION['code'] == 'SS5') {
						?>
							<select name="sale_code" id="sale_code" class="so-select">
								<option value="">**Please Select**</option>
								<?php
								$strSQL5 = "SELECT * FROM tb_team_ss3 where sale_code IN ('S31','S32') ORDER BY sale_code ASC";
								$objQuery5 = mysqli_query($com, $strSQL5);
								while ($objResuut5 = mysqli_fetch_array($objQuery5)) {
									$sel = ($selected_sale_code == $objResuut5["sale_code"]) ? "selected" : "";
								?>
									<option value="<?php echo $objResuut5["sale_code"]; ?>" <?php echo $sel; ?>><?php echo $objResuut5["sale_code"]; ?> - <?php echo $objResuut5["sale_name"]; ?></option>
								<?php
								}
								?>
							</select>
						<?php
						} else if ($_SESSION['code'] == 'SUP_EN') {
						?>
							<select name="sale_code" id="sale_code" class="so-select" required>
								<option value="">**Please Select**</option>
								<?php
								$strSQL5 = "SELECT * FROM tb_team_en ORDER BY sale_code ASC";
								$objQuery5 = mysqli_query($com, $strSQL5);
								while ($objResuut5 = mysqli_fetch_array($objQuery5)) {
									$sel = ($selected_sale_code == $objResuut5["sale_code"]) ? "selected" : "";
								?>
									<option value="<?php echo $objResuut5["sale_code"]; ?>" <?php echo $sel; ?>><?php echo $objResuut5["sale_code"]; ?> - <?php echo $objResuut5["sale_name"]; ?></option>
								<?php
								}
								?>
							</select>
						<?php
						} else {
						?>
							<select name="sale_code" id="sale_code" class="so-select" required>
								<option value="">**Please Select**</option>
								<?php
								$strSQL5 = "SELECT * FROM tb_team_all ORDER BY sale_code ASC";
								$objQuery5 = mysqli_query($com, $strSQL5);
								while ($objResuut5 = mysqli_fetch_array($objQuery5)) {
									$sel = ($selected_sale_code == $objResuut5["sale_code"]) ? "selected" : "";
								?>
									<option value="<?php echo $objResuut5["sale_code"]; ?>" <?php echo $sel; ?>><?php echo $objResuut5["sale_code"]; ?> - <?php echo $objResuut5["sale_name"]; ?></option>
								<?php
								}
								?>
							</select>
						<?php
						}
						?>
					</div>
				</div>

				<div class="so-subsection-title-container">
					<h3 class="so-subsection-title">ข้อมูลเอกสาร</h3>
				</div>

				<div class="so-grid-2">
					<div class="so-field-group">
						<label class="so-label" for="date_jong">วันที่แจ้ง</label>
						<input type="date" name="date_jong" id="date_jong" value="<?php echo ($savedJong !== null) ? $savedJong['date_jong'] : $today; ?>" class="so-input">
					</div>
					<div class="so-field-group">
						<label class="so-label" for="date_receive">วันที่ต้องการสินค้า <span style="color:red;">*</span></label>
						<input type="date" name="date_receive" id="date_receive" class="so-input" value="<?php echo ($savedJong !== null) ? $savedJong['date_receive'] : ''; ?>" required>
					</div>
				</div>

			</div>

			<!-- กล่อง: ข้อมูลลูกค้า -->
			<div class="so-card">
				<div class="so-section-title-container">
					<h2 class="so-section-title">ข้อมูลลูกค้า</h2>
					<hr class="so-divider">
				</div>

				<div class="so-customer-top-grid">
					<div class="so-customer-top-left">
						<div class="so-customer-pills-row">
							<button type="button" class="btn-add-customer-pill" onclick="openCustomerPopup();">
								<img src="img/icons/add_user.png" alt="add_user" style="width: 23px;"> ข้อมูลลูกค้า
							</button>
						</div>

						<div class="so-field-group" style="margin-bottom: 0;">
							<label class="so-label" for="customer">ชื่อลูกค้า</label>
							<div class="so-input-wrapper">
								<input type="text" name="customer" id="customer" class="so-input" readonly placeholder="จะแสดงผลอัตโนมัติเมื่อเลือกเสร็จสิ้น" value="<?php echo ($savedJong !== null) ? htmlspecialchars($savedJong['customer'], ENT_QUOTES, 'UTF-8') : ''; ?>">
								<i class="fas fa-times so-clear-icon" onclick="clearCustomerSelection();"></i>
							</div>
						</div>
					</div>

					<div class="so-customer-top-right">
						<div class="so-field-group" style="height: 100%; margin-bottom: 0;">
							<label class="so-label">ข้อมูลลูกค้า</label>
							<div class="customer-info-display-card">
								<div class="cidc-col">
									<div class="cidc-row">
										<div class="cidc-label">รหัสลูกค้า</div>
										<div class="cidc-value">
											<span id="display_bill_id" class="cidc-display-text"><?php echo ($savedJong !== null) ? htmlspecialchars($savedJong['customer_id'], ENT_QUOTES, 'UTF-8') : ''; ?></span>
											<input type="hidden" name="bill_id" id="bill_id" value="<?php echo ($savedJong !== null) ? htmlspecialchars($savedJong['customer_id'], ENT_QUOTES, 'UTF-8') : ''; ?>">
											<input type="hidden" name="h_bill_id" id="h_bill_id" readonly value="<?php echo ($savedJong !== null) ? htmlspecialchars($savedJong['customer_id'], ENT_QUOTES, 'UTF-8') : ''; ?>">
										</div>
									</div>
									<div class="cidc-row">
										<div class="cidc-label">เบอร์โทร</div>
										<div class="cidc-value">
											<input type="text" id="display_bill_tel" class="cidc-value-input" readonly>
										</div>
									</div>
									<div class="cidc-row">
										<div class="cidc-label">สถานะลูกค้า</div>
										<div class="cidc-value">
											<img src="img/icons/vip.png" class="cidc-status-icon" id="display_vip_icon" alt="VIP" style="display: none;">
											<input type="text" id="display_mode_name" class="cidc-value-input" readonly>
										</div>
									</div>
								</div>
								<div class="cidc-col">
									<div class="cidc-row">
										<div class="cidc-label">ชื่อลูกค้า</div>
										<div class="cidc-value">
											<input type="text" id="display_bill_name" class="cidc-value-input" readonly>
										</div>
									</div>
									<div class="cidc-row">
										<div class="cidc-label">ประเภทลูกค้า</div>
										<div class="cidc-value">
											<input type="text" id="display_customer_typename" class="cidc-value-input" readonly>
										</div>
									</div>
									<div class="cidc-row">
										<div class="cidc-label">เครดิตยอดขาย</div>
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

					<div class="so-customer-address-wrap">
						<div class="so-field-group" style="margin-bottom: 0;">
							<label class="so-label" for="address_send">ที่อยู่ลูกค้า <span style="color:red;">*</span></label>
							<div class="so-input-wrapper">
								<input type="text" name="address_send" id="address_send" class="so-input" placeholder="ระบุสถานที่ส่งสินค้า..." style="padding-right: 36px;" value="<?php echo ($savedJong !== null) ? htmlspecialchars($savedJong['address_send'], ENT_QUOTES, 'UTF-8') : ''; ?>" required>
								<i class="fas fa-times so-clear-icon" onclick="clearFieldValue('address_send');"></i>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- กล่อง: หมายเหตุ -->
			<div class="so-card">
				<div class="so-section-title-container">
					<h2 class="so-section-title">หมายเหตุ</h2>
				</div>
				<hr class="so-divider" style="margin: -12px 0 24px 0;">
				<div class="so-field-group" style="margin-bottom: 0;">
					<label class="so-label" for="drescription">หมายเหตุ</label>
					<textarea name="drescription" id="drescription" class="so-textarea" placeholder="ระบุรายละเอียดเพิ่มเติม..." style="margin-bottom: 0;"><?php echo ($savedJong !== null) ? htmlspecialchars($savedJong['drescription'], ENT_QUOTES, 'UTF-8') : ''; ?></textarea>
				</div>
			</div>


			<!-- กล่อง: รายการสินค้า -->
			<div class="so-card">
				<div class="so-section-title-container so-product-section-header">
					<h2 class="so-section-title">รายการสินค้า</h2>
					<span class="so-product-count" id="productItemCount">0 รายการ</span>
				</div>
				<hr class="so-divider" style="margin: -12px 0 24px 0;">

				<div class="so-product-total-box">
					<span class="so-product-total-label">จำนวนรวม(ชิ้น)</span>
					<span class="so-product-total-value" id="productTotalQty">0</span>
				</div>

				<div class="so-product-search-wrap">
					<i class="fas fa-search"></i>
					<input type="text" id="productSearchInput" placeholder="ค้นหาด้วยรหัสสินค้า / ชื่อสินค้า" autocomplete="off">
					<div id="productSearchResults" class="product-search-dropdown"></div>
				</div>

				<div class="so-product-table-wrap">
					<table class="so-product-dyn-table">
						<thead>
							<tr>
								<th class="col-handle"></th>
								<th>รหัสสินค้า</th>
								<th>รายการสินค้า</th>
								<th class="col-qty">จำนวน</th>
								<th class="col-actions"></th>
							</tr>
						</thead>
						<tbody id="productTableBody">
							<tr id="productEmptyRow">
								<td colspan="5" class="product-empty">ยังไม่มีรายการสินค้า ค้นหาด้านบนเพื่อเพิ่มรายการ</td>
							</tr>
						</tbody>
					</table>
				</div>

				<div id="productHiddenInputs"></div>
			</div>
		</div>

		<!-- TAB 2: Admin -->
		<div id="tabAdmin" class="so-tab-content">
			<div class="so-card">
				<div class="so-section-title-container">
					<h2 class="so-section-title">Admin</h2>
					<hr class="so-divider">
				</div>
			</div>
		</div>
</div>

<div class="so-sticky-actions">
	<div class="so-sticky-actions-inner">
		<button type="submit" name="submit" id="btn_submit_form" value="submit" class="btn-so-submit">
			<i class="far fa-save"></i> บันทึกข้อมูล
		</button>
		<button type="button" name="save_draft" onclick="saveDraft()" class="btn-so-draft">
			<i class="far fa-save"></i> Save Draft
		</button>
	</div>
</div>
</form>

<!-- HTML โครงสร้างป๊อปอัปค้นหาลูกค้า (ตามสไตล์ของ register_suphos.php) -->
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

<!-- ป๊อปอัปเครดิตเทอม/หนี้คงค้าง (ใช้ระบบร่วมกับ register_suphos.php ผ่าน js/credit-term-modal.js) -->
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

<!-- ป๊อปอัปหมายเหตุสินค้า (แก้ไขหมายเหตุรายการสินค้าในตาราง) -->
<div id="productRemarkModal" class="customer-popup-modal" aria-hidden="true">
	<div class="customer-popup-box product-remark-popup-box" role="dialog" aria-modal="true" aria-labelledby="productRemarkModalTitle">
		<button type="button" class="customer-popup-close" onclick="closeProductRemarkModal()" aria-label="Close">&times;</button>
		<div class="customer-popup-header">
			<h2 id="productRemarkModalTitle">ข้อมูลรายการสินค้าเพิ่มเติม</h2>
		</div>
		<div class="product-remark-popup-body">
			<div class="so-field-group" style="margin-bottom:0;">
				<label class="so-label" for="productRemarkModalInput">หมายเหตุสินค้า</label>
				<div class="so-input-wrapper">
					<input type="text" id="productRemarkModalInput" class="so-input" placeholder="ระบุหมายเหตุสินค้า...">
					<i class="fas fa-times so-clear-icon" onclick="clearFieldValue('productRemarkModalInput')"></i>
				</div>
			</div>
		</div>
		<div class="customer-popup-actions">
			<button type="button" class="customer-popup-confirm" onclick="confirmProductRemarkModal()">อัพเดท</button>
			<button type="button" class="customer-popup-cancel" onclick="closeProductRemarkModal()">ยกเลิก</button>
		</div>
	</div>
</div>

<!-- <div id="cr_bar"><?php include "foot.php"; ?></div> -->

<script>
	var PRODUCT_SEARCH_DEPT = '<?php echo ($_SESSION['department'] == "วิศวกรรม") ? "eng" : "sale"; ?>';

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

	function clearFieldValue(id) {
		var el = document.getElementById(id);
		if (el) el.value = '';
	}

	function clearCustomerSelection() {
		clearFieldValue('bill_id');
		clearFieldValue('h_bill_id');
		clearFieldValue('customer');
		clearFieldValue('address_send');

		var displayBillId = document.getElementById('display_bill_id');
		if (displayBillId) displayBillId.textContent = '';
		clearFieldValue('display_bill_tel');
		clearFieldValue('display_mode_name');
		clearFieldValue('display_bill_name');
		clearFieldValue('display_customer_typename');
		clearFieldValue('display_credit_thb');

		var vipIcon = document.getElementById('display_vip_icon');
		if (vipIcon) vipIcon.style.display = 'none';

		syncCreditTermTriggerState();
	}

	// ตั้งค่าฟิลด์แสดงผล พร้อม format ตัวเลขให้ display_credit_thb และ sync สถานะปุ่มเครดิตเทอม
	function setElementValue(id, value) {
		var element = document.getElementById(id);
		if (element) {
			var normalizedValue = value || "";
			if (id === 'display_credit_thb') {
				var trimmed = String(normalizedValue).trim();
				if (trimmed !== "") {
					var number = Number(trimmed.replace(/,/g, ''));
					if (!isNaN(number)) {
						normalizedValue = number.toLocaleString('en-US', {
							minimumFractionDigits: 2,
							maximumFractionDigits: 2
						});
					}
				}
			}
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

	function invokeCreditTermPopupOpen() {
		if (typeof window.openCreditTermPopup === 'function') {
			window.openCreditTermPopup();
			return;
		}
		var modal = document.getElementById('creditTermPopupModal');
		var trigger = document.getElementById('display_credit_thb_trigger');
		if (!modal || !trigger || trigger.disabled) return;
		modal.style.display = 'flex';
		modal.setAttribute('aria-hidden', 'false');
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

	// ฟังก์ชัน AJAX หลักในการเชื่อมต่อข้อมูลออกบิลลูกค้า
	var HttPRequest = false;

	function doCallAjax1(bill_id, customer, address_send) {
		HttPRequest = false;
		if (window.XMLHttpRequest) {
			HttPRequest = new XMLHttpRequest();
			if (HttPRequest.overrideMimeType) {
				HttPRequest.overrideMimeType('text/html');
			}
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
		var billIdVal = document.getElementById(bill_id).value;
		var pmeters = "bill_id=" + encodeURIComponent(billIdVal);
		HttPRequest.open('POST', url, true);
		HttPRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		HttPRequest.setRequestHeader("Content-length", pmeters.length);
		HttPRequest.setRequestHeader("Connection", "close");
		HttPRequest.send(pmeters);

		HttPRequest.onreadystatechange = function() {
			if (HttPRequest.readyState == 4) {
				if (HttPRequest.status === 200) {
					var myProduct = HttPRequest.responseText;
					if (myProduct != "") {
						var myArr = myProduct.split("|");
						document.getElementById(customer).value = myArr[0];
						// ดึงเฉพาะที่อยู่ออกบิลรวม (myArr[1]) ตามความต้องการของลูกค้า: "ดึงเฉพาะที่อยู่ของ 'ลูกค้า'"
						if (address_send && document.getElementById(address_send)) {
							document.getElementById(address_send).value = myArr[1];
						}

						// เติมข้อมูลลงกล่องแสดงผลข้อมูลลูกค้า (customer-info-display-card)
						setElementValue('display_bill_name', myArr[0]);
						setElementValue('display_bill_tel', myArr[2]);
						setElementValue('display_mode_name', myArr[20]);
						setElementValue('display_customer_typename', myArr[22]);
						setElementValue('display_credit_thb', myArr[24]);

						var vipCkk = (myArr[25] || '').trim();
						var vipIcon = document.getElementById('display_vip_icon');
						if (vipIcon) {
							vipIcon.style.display = (vipCkk === "1") ? "" : "none";
						}

						var billIdVal2 = document.getElementById(bill_id).value;
						var displayBillId = document.getElementById('display_bill_id');
						if (displayBillId) displayBillId.textContent = billIdVal2;
					}
				}
			}
		}
	}

	// Hook เรียกโดย js/customer-popup.js เมื่อผู้ใช้กด "ตกลง" เลือกลูกค้าในป๊อปอัป
	window.customerPopupOnConfirm = function(selectedCustomer) {
		var selectedCustId = String((selectedCustomer && selectedCustomer.customer_id) || '').trim();

		var billId = document.getElementById('bill_id');
		if (billId) {
			billId.value = selectedCustId;
		}
		var hiddenBillId = document.getElementById('h_bill_id');
		if (hiddenBillId) {
			hiddenBillId.value = selectedCustId;
		}

		// เรียกดึงข้อมูลบิลลูกค้าและกรอกลงที่อยู่และชื่อฟิลด์จริง
		doCallAjax1('bill_id', 'customer', 'address_send');
	};

	// ===== รายการสินค้าแบบไดนามิก =====
	var productRows = <?php echo count($savedProducts) > 0 ? json_encode($savedProducts, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) : '[]'; ?>;
	var productSearchTimer = null;
	var productDragIndex = null;

	function escapeProductHtml(value) {
		return String(value == null ? '' : value).replace(/[&<>"']/g, function(char) {
			return {
				'&': '&amp;',
				'<': '&lt;',
				'>': '&gt;',
				'"': '&quot;',
				"'": '&#039;'
			} [char];
		});
	}

	function renderProductTable() {
		var tbody = document.getElementById('productTableBody');
		var hiddenWrap = document.getElementById('productHiddenInputs');
		if (!tbody) return;

		document.getElementById('productItemCount').textContent = productRows.length + ' รายการ';
		var totalQty = productRows.reduce(function(sum, r) {
			return sum + (parseFloat(r.count) || 0);
		}, 0);
		document.getElementById('productTotalQty').textContent = totalQty;

		if (productRows.length === 0) {
			tbody.innerHTML = '<tr id="productEmptyRow"><td colspan="5" class="product-empty">ยังไม่มีรายการสินค้า ค้นหาด้านบนเพื่อเพิ่มรายการ</td></tr>';
			hiddenWrap.innerHTML = '';
			return;
		}

		tbody.innerHTML = productRows.map(function(row, idx) {
			var remarkBlock = row.remark ?
				('<div class="product-row-remark-text">' + escapeProductHtml(row.remark) + '</div>') : '';

			return '<tr draggable="true" class="product-row" data-idx="' + idx + '" ' +
				'ondragstart="productDragStart(event,' + idx + ')" ondragover="productDragOver(event,' + idx + ')" ondrop="productDrop(event,' + idx + ')" ondragend="productDragEnd(event)" ondragleave="productDragLeave(event)">' +
				'<td class="col-handle"><i class="fas fa-grip-vertical"></i></td>' +
				'<td>' + escapeProductHtml(row.product_code) + '</td>' +
				'<td>' + escapeProductHtml(row.product_name) + remarkBlock + '</td>' +
				'<td class="col-qty"><input type="number" min="1" class="so-input product-qty-input" value="' + row.count + '" oninput="updateProductCount(' + idx + ',this.value)"></td>' +
				'<td class="col-actions">' +
				'<button type="button" class="product-row-icon-btn" onclick="openProductRemarkModal(' + idx + ')" title="แก้ไขหมายเหตุ"><i class="fas fa-pen"></i></button>' +
				'<button type="button" class="product-row-icon-btn" onclick="removeProductRow(' + idx + ')" title="ลบ"><i class="fas fa-trash"></i></button>' +
				'</td>' +
				'</tr>';
		}).join('');

		var isEditMode = <?php echo ($savedJong !== null) ? 'true' : 'false'; ?>;
		hiddenWrap.innerHTML = productRows.map(function(row) {
			if (isEditMode) {
				return '<input type="hidden" name="id[]" value="' + escapeProductHtml(row.id || '') + '">' +
					'<input type="hidden" name="product_id[]" value="' + escapeProductHtml(row.product_id) + '">' +
					'<input type="hidden" name="count[]" value="' + escapeProductHtml(row.count) + '">' +
					'<input type="hidden" name="sale_remarkk[]" value="' + escapeProductHtml(row.remark || '') + '">';
			} else {
				return '<input type="hidden" name="product_id[]" value="' + escapeProductHtml(row.product_id) + '">' +
					'<input type="hidden" name="product_code[]" value="' + escapeProductHtml(row.product_code) + '">' +
					'<input type="hidden" name="sale_count[]" value="' + escapeProductHtml(row.count) + '">' +
					'<input type="hidden" name="sale_remark[]" value="' + escapeProductHtml(row.remark || '') + '">';
			}
		}).join('');
	}

	function addProductRow(product) {
		productRows.push({
			product_id: product.product_id,
			product_code: product.product_code,
			product_name: product.product_name,
			unit_name: product.unit_name,
			count: 1,
			remark: ''
		});
		renderProductTable();
	}

	function removeProductRow(idx) {
		productRows.splice(idx, 1);
		renderProductTable();
	}

	function updateProductCount(idx, val) {
		productRows[idx].count = val;
		var totalQty = productRows.reduce(function(sum, r) {
			return sum + (parseFloat(r.count) || 0);
		}, 0);
		document.getElementById('productTotalQty').textContent = totalQty;
		var hiddenWrap = document.getElementById('productHiddenInputs');
		if (hiddenWrap) {
			var inputs = hiddenWrap.querySelectorAll('input[name="sale_count[]"]');
			if (inputs[idx]) inputs[idx].value = val;
		}
	}

	function updateProductRemark(idx, val) {
		productRows[idx].remark = val;
		var hiddenWrap = document.getElementById('productHiddenInputs');
		if (hiddenWrap) {
			var inputs = hiddenWrap.querySelectorAll('input[name="sale_remark[]"]');
			if (inputs[idx]) inputs[idx].value = val;
		}
	}

	var productRemarkEditIndex = null;

	function openProductRemarkModal(idx) {
		productRemarkEditIndex = idx;
		var input = document.getElementById('productRemarkModalInput');
		if (input) input.value = productRows[idx].remark || '';

		var modal = document.getElementById('productRemarkModal');
		if (modal) {
			modal.style.display = 'flex';
			modal.setAttribute('aria-hidden', 'false');
		}
	}

	function closeProductRemarkModal() {
		var modal = document.getElementById('productRemarkModal');
		if (modal) {
			modal.style.display = 'none';
			modal.setAttribute('aria-hidden', 'true');
		}
		productRemarkEditIndex = null;
	}

	function confirmProductRemarkModal() {
		if (productRemarkEditIndex === null) return;
		var input = document.getElementById('productRemarkModalInput');
		var value = input ? input.value : '';
		updateProductRemark(productRemarkEditIndex, value);
		renderProductTable();
		closeProductRemarkModal();
	}

	function productDragStart(e, idx) {
		productDragIndex = idx;
		e.dataTransfer.effectAllowed = 'move';
		try {
			e.dataTransfer.setData('text/plain', String(idx));
		} catch (err) {}
	}

	function productDragOver(e, idx) {
		e.preventDefault();
		e.currentTarget.classList.add('drag-over');
	}

	function productDragLeave(e) {
		e.currentTarget.classList.remove('drag-over');
	}

	function productDrop(e, idx) {
		e.preventDefault();
		e.currentTarget.classList.remove('drag-over');
		if (productDragIndex === null || productDragIndex === idx) return;
		var moved = productRows.splice(productDragIndex, 1)[0];
		productRows.splice(idx, 0, moved);
		productDragIndex = null;
		renderProductTable();
	}

	function productDragEnd(e) {
		productDragIndex = null;
	}

	// ควบคุมเหตุการณ์หลังโหลดเอกสารเสร็จสิ้น
	document.addEventListener('DOMContentLoaded', function() {
		syncCreditTermTriggerState();

		var creditTermTrigger = document.getElementById('display_credit_thb_trigger');
		var creditTermModal = document.getElementById('creditTermPopupModal');

		if (creditTermTrigger) {
			creditTermTrigger.addEventListener('click', invokeCreditTermPopupOpen);
			creditTermTrigger.addEventListener('keydown', function(event) {
				if (event.key === 'Enter' || event.key === ' ') {
					event.preventDefault();
					invokeCreditTermPopupOpen();
				}
			});
		}

		if (creditTermModal) {
			creditTermModal.addEventListener('click', function(event) {
				if (event.target === creditTermModal) {
					invokeCreditTermPopupClose();
				}
			});
		}

		document.addEventListener('keydown', function(event) {
			if (event.key !== 'Escape') return;
			if (creditTermModal && creditTermModal.style.display === 'flex') {
				invokeCreditTermPopupClose();
			}
		});

		var productInput = document.getElementById('productSearchInput');
		var productResults = document.getElementById('productSearchResults');
		if (productInput && productResults) {
			productInput.addEventListener('input', function() {
				clearTimeout(productSearchTimer);
				var keyword = productInput.value.trim();
				if (keyword.length < 1) {
					productResults.style.display = 'none';
					productResults.innerHTML = '';
					return;
				}
				productSearchTimer = setTimeout(function() {
					fetch('ajax_product_popup_search.php?dept=' + PRODUCT_SEARCH_DEPT + '&q=' + encodeURIComponent(keyword))
						.then(function(res) {
							return res.json();
						})
						.then(function(data) {
							if (!data || !data.success || !data.products.length) {
								productResults.innerHTML = '<div class="product-search-empty">ไม่พบสินค้า</div>';
								productResults.style.display = 'block';
								return;
							}
							productResults.innerHTML = data.products.map(function(p, i) {
								return '<div class="product-search-item" data-i="' + i + '">' +
									'<b>' + escapeProductHtml(p.product_code) + '</b> - ' + escapeProductHtml(p.product_name) +
									'</div>';
							}).join('');
							productResults.style.display = 'block';
							productResults.querySelectorAll('.product-search-item').forEach(function(el) {
								el.addEventListener('click', function() {
									var i = parseInt(el.getAttribute('data-i'), 10);
									addProductRow(data.products[i]);
									productInput.value = '';
									productResults.style.display = 'none';
									productResults.innerHTML = '';
								});
							});
						})
						.catch(function() {
							productResults.innerHTML = '<div class="product-search-empty">ค้นหาไม่สำเร็จ</div>';
							productResults.style.display = 'block';
						});
				}, 250);
			});

			document.addEventListener('click', function(e) {
				if (!productResults.contains(e.target) && e.target !== productInput) {
					productResults.style.display = 'none';
				}
			});
		}

		renderProductTable();

		<?php if ($savedJong !== null) { ?>
			// Load customer info (passing null for address to not overwrite saved shipping address)
			doCallAjax1('bill_id', 'customer', null);

			// Restore the custom saved shipping address
			var addrInput = document.getElementById('address_send');
			if (addrInput) {
				addrInput.value = <?php echo json_encode($savedJong['address_send'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>;
			}
		<?php } ?>
	});

	function previewBooking() {
		var form = document.forms['frmMain'];
		if (!form) return;

		var flag = document.createElement('input');
		flag.type = 'hidden';
		flag.name = 'preview_mode';
		flag.value = '1';
		form.appendChild(flag);

		var originalAction = form.action;
		var originalTarget = form.target;
		form.action = 'report_jongpro.php';
		form.target = '_blank';

		HTMLFormElement.prototype.submit.call(form);

		form.action = originalAction;
		form.target = originalTarget;
		form.removeChild(flag);
	}

	function saveDraft() {
		var form = document.forms['frmMain'];
		if (!form) return;

		var btn = form.querySelector('[name="save_draft"]');
		var defaultHtml = btn ? btn.innerHTML : '';
		var formData = new FormData(form);
		formData.set('is_draft', '1');

		if (btn) {
			btn.disabled = true;
			btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
		}

		fetch('register_supbook_draft1.php', {
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
						window.location.href = 'register_supbook.php?ref_id=' + encodeURIComponent(data.ref_id) + '&saved=1';
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

	<?php if (isset($_GET["saved"]) && $_GET["saved"] === "1") { ?>
		document.addEventListener('DOMContentLoaded', function() {
			Swal.fire({
				title: 'บันทึกข้อมูลเรียบร้อยแล้ว',
				text: 'ระบบแสดงข้อมูลที่บันทึกไว้ในหน้านี้แล้ว',
				icon: 'success',
				confirmButtonColor: '#612989',
				confirmButtonText: 'ตกลง'
			});
		});
	<?php } ?>
</script>
<script src="js/credit-term-modal.js?v=<?php echo filemtime(__DIR__ . '/js/credit-term-modal.js'); ?>"></script>