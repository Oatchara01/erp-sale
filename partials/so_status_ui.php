<?php
/**
 * Shared "SO Status" UI kit — the .so-* design system.
 *
 * Extracted verbatim from status_adminhos.php so any page can reuse the same
 * look (page shell, buttons, modern table with expandable rows, status badges,
 * filter modal, kebab dropdown, pagination) without copy-pasting CSS.
 *
 * Usage (after head.php, which provides Font Awesome + w3.css):
 *     <?php include 'partials/so_status_ui.php'; ?>
 *
 * See docs/so-status-ui.md for the class catalogue, HTML skeletons, and the
 * JavaScript helpers the markup depends on.
 *
 * Guarded so it is safe to include more than once per request.
 */

if (!defined('SO_STATUS_UI_STYLE_PRINTED')) {
	define('SO_STATUS_UI_STYLE_PRINTED', true);
?>
<style>
	@import url('https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap');

	body {
		background-color: #F4EFF8 !important;
		background-image: none !important;
		font-family: 'Prompt', sans-serif !important;
		color: #4A4A4A !important;
	}

	.status-so-page,
	.status-so-page * {
		box-sizing: border-box;
	}

	.status-so-page {
		font-family: 'Prompt', sans-serif !important;
		background-color: transparent;
		padding: clamp(16px, 2vw, 24px) clamp(10px, 2vw, 16px);
		min-height: 100dvh;
		max-width: 1490px;
		margin: 0 auto;
	}

	.status-so-page h4 {
		font-family: 'Prompt', sans-serif !important;
		font-weight: 600;
		color: #612989;
		margin-top: 0;
	}

	.so-card {
		background: transparent;
		border: none;
		box-shadow: none;
		padding: 0;
		margin-bottom: 24px;
	}

	/* Form inputs & controls */
	.so-input-group {
		display: flex;
		justify-content: space-between;
		align-items: center;
		gap: 12px;
		margin-bottom: 20px;
		flex-wrap: wrap;
	}

	.so-search-wrapper {
		position: relative;
		width: 680px;
		max-width: 100%;
	}

	.so-search-icon {
		position: absolute;
		left: 16px;
		top: 50%;
		transform: translateY(-50%);
		color: #8E8B94;
	}

	.so-input {
		width: 100%;
		height: 42px;
		padding: 0 16px;
		padding-left: 40px;
		/* for search icon */
		border-radius: 10px;
		background: #F5F6F8;
		border: 1px solid transparent;
		font-size: 14px;
		font-family: 'Prompt', sans-serif !important;
		transition: all 0.3s ease;
	}

	.so-input:focus,
	.so-select:focus {
		background: #FFFFFF;
		border-color: #612989;
		box-shadow: 0 0 0 3px rgba(97, 41, 137, 0.1);
		outline: none;
	}

	.so-modal-input {
		padding-left: 16px;
	}

	.so-select {
		width: 100%;
		height: 42px;
		padding: 0 16px;
		border-radius: 10px;
		background: #F5F6F8;
		border: 1px solid transparent;
		font-size: 14px;
		font-family: 'Prompt', sans-serif !important;
		transition: all 0.3s ease;
	}

	/* Buttons */
	.btn-so-primary {
		background: #612989;
		color: #FFFFFF;
		border: none;
		border-radius: 24px;
		height: 42px;
		padding: 0 24px;
		font-weight: 600;
		cursor: pointer;
		transition: all 0.3s ease;
		box-shadow: 0 4px 12px rgba(97, 41, 137, 0.2);
		display: inline-flex;
		align-items: center;
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
		padding: 0 40px;
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

	.btn-so-outline {
		background: #FFFFFF;
		color: #612989 !important;
		border: 1px solid #EDE9F0;
		border-radius: 9999px;
		height: 42px;
		padding: 0 24px;
		font-weight: 600;
		cursor: pointer;
		transition: all 0.3s ease;
		display: inline-flex;
		align-items: center;
		gap: 8px;
		text-decoration: none;
	}

	.btn-so-outline:hover {
		background: #F4EFF8;
		color: #502173 !important;
		border-color: #612989;
	}

	.btn-so-danger {
		background: #DC3545;
		color: #FFFFFF;
		border: none;
		border-radius: 24px;
		height: 42px;
		padding: 0 20px;
		font-weight: 500;
		cursor: pointer;
		transition: all 0.3s ease;
	}

	.btn-so-danger:hover {
		background: #BD2130;
	}

	/* Modern Table */
	.so-table-wrapper {
		overflow-x: auto;
		overflow-y: visible;
		border-radius: 10px;
		border: 1px solid #EDE9F0;
		background: #FFFFFF;
		-webkit-overflow-scrolling: touch;
	}

	.so-table {
		width: 100%;
		min-width: 1120px;
		border-collapse: collapse;
		font-size: 14px;
	}

	.so-table th {
		background: #FFFFFF;
		font-size: 16px;
		font-weight: 600;
		padding: 25px 16px;
		text-align: left;
		border-bottom: 1px solid #612989;
	}

	.so-table td {
		padding: 14px 16px;
		border-bottom: 1px solid #EDE9F0;
		color: #3B3B3B;
		background: #FFFFFF;
		vertical-align: middle;
	}

	/* ปรับระยะห่างขอบสุดทางซ้ายและขวาของตาราง */
	.so-table th:first-child,
	.so-table td:first-child {
		padding-left: 40px;
	}

	.so-table th:last-child,
	.so-table td:last-child {
		padding-right: 40px;
	}

	.so-row {
		cursor: pointer;
		transition: background-color 0.2s ease;
	}

	.so-row:hover {
		background-color: #FAF8FD;
	}

	.so-row.is-expanded {
		background-color: #F6EFFC;
	}

	.caret-icon {
		transition: transform 0.2s ease;
	}

	.so-row.is-expanded .caret-icon {
		transform: rotate(180deg);
		color: #612989;
	}

	/* Badges for status_doc */
	.badge-status {
		display: inline-flex;
		align-items: center;
		padding: 4px 12px;
		border-radius: 20px;
		font-size: 12px;
		font-weight: 500;
	}

	.badge-status.approve {
		background-color: #F6FFED;
		color: #389E0D;
	}

	/* อนุมัติแล้ว / Approve */
	.badge-status.draft {
		background-color: #FFF7E6;
		color: #D48806;
	}

	/* Draft */
	.badge-status.rejected {
		background-color: #FFF1F0;
		color: #CF1322;
	}

	/* Rejected / ไม่อนุมัติ */
	.badge-status.cancel {
		background-color: #F5F5F5;
		color: #595959;
	}

	/* ยกเลิก */
	.badge-status.closed {
		background-color: #F9F0FF;
		color: #612989;
	}

	/* ปิดใบจอง */
	.badge-status.pending-mgr {
		background-color: #FFF7E6;
		color: #D48806;
	}

	/* รอหัวหน้า */
	.badge-status.pending-exec {
		background-color: #F9F0FF;
		color: #531DAB;
	}

	/* รอผู้บริหาร */
	.badge-status.returned {
		background-color: #FFF2E8;
		color: #D4380D;
	}

	/* ส่งกลับ */

	/* Expanded Row Details */
	.so-row.is-expanded,
	.so-row.is-expanded td {
		background-color: #F1E1FF !important;
	}

	.expanded-row > td {
		padding: 0 !important;
		background: #F1E1FF !important;
		border-bottom: 1px solid #EDE9F0;
	}

	.expanded-container {
		padding: 20px 24px;
		display: flex;
		gap: 24px;
		flex-wrap: wrap;
		align-items: flex-start;
	}

	.expanded-products-card {
		flex: 1;
		min-width: min(300px, 100%);
		background: transparent;
		border: none;
		padding: 0;
		box-shadow: none;
		overflow-x: auto;
		-webkit-overflow-scrolling: touch;
	}

	.sub-table {
		width: 100%;
		min-width: 760px;
		border-collapse: collapse;
		font-size: 12px;
		table-layout: fixed;
	}

	.sub-table th {
		background: transparent;
		font-size: 15px;
		font-weight: 500;
		padding: 8px 12px !important;
		text-align: left;
		border-bottom: none;
	}

	.sub-table td {
		font-size: 14px;
		padding: 10px 12px !important;
		border-bottom: none;
		color: #3B3B3B;
	}

	/* Actions Menu */
	.actions-menu-list {
		list-style: none;
		padding: 0;
		margin: 0;
	}

	.actions-menu-list li {
		margin-bottom: 8px;
	}

	.actions-menu-list li:last-child {
		margin-bottom: 0;
	}

	.btn-action-item {
		display: flex;
		align-items: center;
		gap: 10px;
		width: 100%;
		padding: 10px 14px;
		border-radius: 8px;
		color: #4A4A4A;
		font-size: 13px;
		font-weight: 500;
		text-decoration: none;
		transition: all 0.2s ease;
		border: none;
		background: transparent;
		cursor: pointer;
		text-align: left;
	}

	.btn-action-item:hover {
		background: #F6EFFC;
		color: #612989;
	}

	/* Modals */
	.so-modal-header {
		border-bottom: none;
		padding-bottom: 0;
		margin-bottom: 24px;
		display: flex;
		justify-content: space-between;
		align-items: center;
	}

	.so-modal-footer {
		border-top: none;
		padding-top: 0;
		margin-top: 24px;
		display: flex;
		justify-content: flex-end;
		gap: 12px;
	}

	.so-form-row {
		display: grid;
		grid-template-columns: 1fr 1fr;
		gap: 16px;
		margin-bottom: 16px;
	}

	.filter-pill {
		background-color: #F5F6F8;
		border: 1px solid transparent;
		color: #3B3B3B;
		padding: 10px 20px;
		border-radius: 50px;
		font-size: 13px;
		font-family: 'Prompt', sans-serif !important;
		font-weight: 500;
		cursor: pointer;
		transition: all 0.2s ease;
	}

	.filter-pill.active {
		background-color: #612989;
		color: #ffffff;
	}

	.btn-filter-submit {
		background-color: #612989;
		color: #ffffff;
		border: none;
		padding: 10px 32px;
		border-radius: 50px;
		font-size: 14px;
		font-weight: 500;
		cursor: pointer;
		font-family: 'Prompt', sans-serif !important;
		transition: background-color 0.2s;
	}

	.btn-filter-submit:hover {
		background-color: #4A1E68;
	}

	.btn-filter-reset {
		background-color: #ffffff;
		color: #3B3B3B;
		border: 1px solid #EDE9F0;
		padding: 10px 32px;
		border-radius: 50px;
		font-size: 14px;
		font-weight: 500;
		cursor: pointer;
		font-family: 'Prompt', sans-serif !important;
		transition: background-color 0.2s;
		display: inline-flex;
		align-items: center;
	}

	.btn-filter-reset:hover {
		background-color: #F5F6F8;
	}

	.pagination-wrapper {
		display: flex;
		justify-content: space-between;
		align-items: center;
		margin-top: 20px;
		font-size: 13px;
		flex-wrap: wrap;
		gap: 12px;
	}

	.pagination-links {
		display: flex;
		flex-wrap: wrap;
		gap: 6px;
	}

	.pagination-btn {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		min-width: 32px;
		height: 32px;
		padding: 0 6px;
		border-radius: 6px;
		border: 1px solid #EFEBEF;
		color: #3B3B3B;
		text-decoration: none;
		transition: all 0.2s ease;
	}

	.pagination-btn:hover {
		background: #EFEBFF;
		border-color: #612989;
		color: #612989;
	}

	.pagination-btn.active {
		background: #612989;
		color: #FFFFFF;
		border-color: #612989;
	}

	/* Dropdown style */
	.so-dropdown {
		position: relative;
		display: inline-block;
	}

	.so-dropdown-trigger {
		background: none;
		border: none;
		cursor: pointer;
		padding: 8px;
		color: #8E8B94;
		font-size: 16px;
		transition: color 0.2s;
	}

	.so-dropdown-trigger:hover {
		color: #612989;
	}

	.so-dropdown-menu {
		display: none;
		position: absolute;
		right: 0;
		top: 100%;
		background-color: #ffffff;
		width: 186px;
		box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.1);
		border-radius: 8px;
		z-index: 1000;
		border: 1px solid #EDE9F0;
		padding: 0;
		overflow: hidden;
	}

	.so-dropdown-menu.show {
		display: block;
	}

	.so-dropdown-item {
		color: #3B3B3B;
		padding: 10px 16px;
		text-decoration: none;
		display: flex;
		align-items: center;
		gap: 12px;
		font-size: 13px;
		text-align: left;
		font-family: 'Prompt', sans-serif !important;
		transition: background-color 0.2s, color 0.2s;
		border-bottom: 1px solid #EDE9F0;
	}

	.so-dropdown-item:last-child {
		border-bottom: none;
	}

	.so-dropdown-item i {
		color: #8E8B94;
		transition: color 0.2s;
	}

	.so-dropdown-item:hover {
		background-color: #612989;
		color: #ffffff !important;
		text-decoration: none;
	}

	.so-dropdown-item:hover i {
		color: #ffffff !important;
	}

	@media (max-width: 600px) {
		.so-form-row {
			grid-template-columns: 1fr;
		}
	}

	@media (max-width: 768px) {
		.status-so-page {
			padding: 16px 10px;
		}

		.status-so-page h4 {
			font-size: 18px;
		}

		.so-input-group {
			align-items: stretch !important;
		}

		.so-input-group>div:first-child {
			width: 100%;
			max-width: none !important;
			min-width: 0 !important;
		}

		.so-input-group>div:first-child>div:last-child {
			flex-wrap: wrap;
			align-items: stretch !important;
		}

		.so-search-wrapper {
			width: 100%;
			flex: 1 1 100% !important;
		}

		.btn-so-outline,
		.btn-so-secondary,
		.btn-filter-submit,
		.btn-filter-reset {
			width: 100%;
			min-height: 44px;
			justify-content: center;
			text-align: center;
		}

		.so-modal-footer {
			flex-direction: column;
		}

		.so-form-pills {
			flex-wrap: wrap;
		}

		.filter-pill {
			flex: 1 1 100%;
			min-height: 44px;
		}

		.w3-modal-content {
			width: calc(100vw - 20px) !important;
			margin: 24px auto !important;
		}

		.w3-modal-content>.w3-container {
			padding: 20px !important;
		}

		.so-table {
			min-width: 980px;
			font-size: 13px;
		}

		.so-table th {
			font-size: 13px;
			padding: 14px 10px;
			white-space: nowrap;
		}

		.so-table td {
			padding: 12px 10px;
		}

		.so-table th:first-child,
		.so-table td:first-child {
			padding-left: 12px;
		}

		.so-table th:last-child,
		.so-table td:last-child {
			padding-right: 12px;
		}

		.expanded-container {
			padding: 14px 12px;
			gap: 12px;
		}

		.sub-table {
			min-width: 680px;
		}

		.sub-table th,
		.sub-table td {
			font-size: 12px;
			padding: 8px 8px !important;
		}

		.pagination-wrapper,
		.pagination-links {
			justify-content: center;
			width: 100%;
		}

		.pagination-wrapper>div:first-child {
			width: 100%;
			text-align: center;
		}

		.pagination-btn {
			min-width: 44px;
			height: 44px;
		}

		.so-dropdown-trigger {
			min-width: 44px;
			min-height: 44px;
		}
	}

	@media (max-width: 420px) {
		.status-so-page {
			padding-left: 8px;
			padding-right: 8px;
		}

		.so-input {
			font-size: 13px;
		}

		.badge-status {
			padding: 4px 8px;
			font-size: 11px;
		}

		.so-dropdown-menu {
			right: -8px;
			width: min(186px, calc(100vw - 32px));
		}
	}
</style>
<?php
}
