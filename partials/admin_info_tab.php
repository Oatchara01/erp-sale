<?php

/**
 * Reusable "Admin" tab renderer, driven by $adminInfoTab config.
 *
 * Expected shape:
 * $adminInfoTab = [
 *     'tab_id' => 'tab-admin-info',
 *     'title'  => 'ข้อมูลเพิ่มเติม (Admin)',
 *     'rows'   => [
 *         [
 *             ['type' => 'text', 'name' => 'admin_doc_no', 'label' => '...', 'value' => $v, 'placeholder' => 'No.'],
 *             ['type' => 'button', 'icon' => 'img/icons/doc.png', 'label' => 'Run เอกสาร', 'id' => 'btn_run_doc_no', 'onclick' => 'runDocumentNo();'],
 *             ['type' => 'text', 'name' => 'admin_work_no', 'label' => '...', 'value' => $v, 'icon' => 'fas fa-search'],
 *             ['type' => 'text', 'name' => 'admin_edit_reason', 'label' => '...', 'value' => $v, 'icon' => 'fas fa-times', 'clearable' => true, 'span' => 3],
 *             ['type' => 'date_th', 'name' => 'admin_doc_date', 'label' => '...', 'value' => $v],
 *         ],
 *         // ...more rows
 *     ],
 * ];
 * include __DIR__ . '/partials/admin_info_tab.php';
 *
 * Values are expected to already be escaped by the caller (e.g. via so_saved_h()).
 * This partial does not escape 'value' to avoid double-escaping.
 */

if (!defined('ADMIN_INFO_TAB_STYLE_PRINTED')) {
	define('ADMIN_INFO_TAB_STYLE_PRINTED', true);
?>
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
<?php
}

$adminTabId = so_saved_h($adminInfoTab['tab_id'] ?? '');
$adminTabTitle = so_saved_h($adminInfoTab['title'] ?? '');
$adminTabRows = $adminInfoTab['rows'] ?? [];
?>
<div id="<?php echo $adminTabId; ?>" class="so-tab-content">
	<div class="so-card">
		<h2 class="admin-ui-title"><?php echo $adminTabTitle; ?></h2>

		<?php foreach ($adminTabRows as $adminTabRow) { ?>
			<div class="admin-ui-grid" style="margin-bottom: 24px;">
				<?php foreach ($adminTabRow as $adminTabField) {
					$fieldType = $adminTabField['type'] ?? 'text';
					$fieldSpanClass = (($adminTabField['span'] ?? 1) === 3) ? ' span-3' : '';
				?>
					<div class="admin-ui-field<?php echo $fieldSpanClass; ?>">
						<?php if ($fieldType === 'button') { ?>
							<button type="button" class="admin-ui-btn"<?php echo isset($adminTabField['id']) ? ' id="' . so_saved_h($adminTabField['id']) . '"' : ''; ?><?php echo isset($adminTabField['onclick']) ? ' onclick="' . so_saved_h($adminTabField['onclick']) . '"' : ''; ?>>
								<img src="<?php echo so_saved_h($adminTabField['icon'] ?? ''); ?>" alt="icon" style="width: 16px; height: 16px;"> <?php echo so_saved_h($adminTabField['label'] ?? ''); ?>
							</button>
						<?php } else {
							$fieldValue = $adminTabField['value'] ?? '';
							$htmlInputType = 'text';

							if ($fieldType === 'date_th' || $fieldType === 'date') {
								// Use native HTML5 date input. 
								// Value must remain in YYYY-MM-DD format, so we do NOT convert to Buddhist date.
								$htmlInputType = 'date';
							}

							$fieldIcon = $adminTabField['icon'] ?? '';
							if ($htmlInputType === 'date') {
								$fieldIcon = ''; // ไม่แสดงไอคอน custom หากเป็น native date picker เพราะมีไอคอนปฏิทินของบราวเซอร์อยู่แล้ว
							}
							$fieldClearable = $adminTabField['clearable'] ?? false;
							$hasIconClass = $fieldIcon !== '' ? ' has-icon' : '';
						?>
							<label class="admin-ui-label"><?php echo so_saved_h($adminTabField['label'] ?? ''); ?></label>
							<div class="admin-ui-input-wrapper">
								<input type="<?php echo $htmlInputType; ?>" name="<?php echo so_saved_h($adminTabField['name'] ?? ''); ?>" class="admin-ui-input<?php echo $hasIconClass; ?>" value="<?php echo so_saved_h($fieldValue); ?>" <?php echo isset($adminTabField['placeholder']) ? ' placeholder="' . so_saved_h($adminTabField['placeholder']) . '"' : ''; ?><?php echo $htmlInputType === 'date' ? ' onclick="if(typeof this.showPicker === \'function\') this.showPicker();"' : ''; ?>>
								<?php if ($fieldIcon !== '') {
									if ($fieldClearable) { ?>
										<i class="<?php echo so_saved_h($fieldIcon); ?> admin-ui-icon-clickable" onclick="this.previousElementSibling.value=''"></i>
									<?php } else { ?>
										<i class="<?php echo so_saved_h($fieldIcon); ?> admin-ui-icon"></i>
								<?php }
								} ?>
							</div>
						<?php } ?>
					</div>
				<?php } ?>
			</div>
		<?php } ?>
	</div>
</div>
<?php
unset($adminTabId, $adminTabTitle, $adminTabRows, $adminTabRow, $adminTabField, $fieldType, $fieldSpanClass, $fieldValue, $fieldIcon, $fieldClearable, $hasIconClass);
