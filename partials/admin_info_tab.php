<?php

/**
 * Reusable "Admin" tab renderer, driven by $adminInfoTab config.
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
			grid-template-columns: repeat(3, 1fr);
			gap: 24px;
			margin-bottom: 24px;
		}

		.admin-ui-grid:last-child {
			margin-bottom: 0;
		}

		@media (max-width: 992px) {
			.admin-ui-grid {
				grid-template-columns: repeat(2, 1fr);
			}

			.admin-ui-field.span-2,
			.admin-ui-field.span-3 {
				grid-column: span 2;
			}
		}

		@media (max-width: 768px) {
			.admin-ui-grid {
				grid-template-columns: 1fr;
			}

			.admin-ui-field.span-2,
			.admin-ui-field.span-3 {
				grid-column: span 1;
			}

			.admin-ui-sub-grid {
				grid-template-columns: 1fr !important;
			}

			.admin-ui-inline-group {
				flex-direction: column;
				align-items: stretch !important;
			}
		}

		.admin-ui-field {
			display: flex;
			flex-direction: column;
			gap: 8px;
		}

		.admin-ui-field.span-2 {
			grid-column: span 2;
		}

		.admin-ui-field.span-3 {
			grid-column: span 3;
		}

		.admin-ui-sub-grid {
			display: grid;
			grid-template-columns: 1fr 1fr;
			gap: 12px;
			width: 100%;
		}

		.admin-ui-inline-group {
			display: flex;
			gap: 12px;
			align-items: flex-end;
			width: 100%;
		}

		.admin-ui-inline-group .admin-ui-field-item {
			display: flex;
			flex-direction: column;
			gap: 8px;
		}

		.admin-ui-inline-group .admin-ui-field-item.flex-fill {
			flex: 1;
			min-width: 0;
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
			background-color: #F5F6F8;
			border: 1px solid transparent;
			border-radius: 10px;
			padding: 0 16px;
			font-size: 16px;
			font-weight: 400;
			color: #612989;
			font-family: 'Prompt', sans-serif;
			outline: none;
			height: 42px;
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
			border-radius: 21px;
			height: 42px;
			padding: 0 24px;
			font-size: 16px;
			font-weight: 500;
			cursor: pointer;
			display: flex;
			align-items: center;
			justify-content: center;
			gap: 8px;
			font-family: 'Prompt', sans-serif;
			box-sizing: border-box;
			transition: all 0.2s ease;
		}

		.admin-ui-btn:hover {
			background-color: #E4C8FF;
		}

		.admin-ui-btn.variant-danger {
			background-color: #FFEBEE;
			color: #D32F2F;
			border: 1px solid #FFCDD2;
		}

		.admin-ui-btn.variant-danger:hover {
			background-color: #FFCDD2;
		}

		.admin-ui-btn.active {
			background-color: #D32F2F;
			color: #FFFFFF;
			border-color: #B71C1C;
			box-shadow: 0 0 0 2px rgba(211, 47, 47, 0.2);
		}

		.admin-ui-input:disabled {
			background-color: #EFEFEF;
			color: #9E9E9E;
			cursor: not-allowed;
			border-color: #E0E0E0;
		}

		.admin-ui-btn:disabled,
		.admin-ui-btn[disabled] {
			opacity: 0.5;
			cursor: not-allowed;
			pointer-events: none;
		}
	</style>
<?php
}

if (!function_exists('renderAdminUiInputItem')) {
	function renderAdminUiInputItem($field) {
		$fieldType = $field['type'] ?? 'text';
		$fieldValue = $field['value'] ?? '';
		$htmlInputType = 'text';

		if ($fieldType === 'date_th' || $fieldType === 'date') {
			$htmlInputType = 'date';
		}

		$fieldIcon = $field['icon'] ?? '';
		if ($htmlInputType === 'date') {
			$fieldIcon = '';
		}

		$fieldDisabled = !empty($field['disabled']);
		$fieldClearable = ($field['clearable'] ?? false) && !$fieldDisabled;
		$fieldIconOnclick = $fieldDisabled ? '' : ($field['icon_onclick'] ?? '');
		$fieldIconId = $field['icon_id'] ?? '';
		$fieldIdAttr = isset($field['id']) ? ' id="' . so_saved_h($field['id']) . '"' : '';
		$hasIconClass = $fieldIcon !== '' ? ' has-icon' : '';
		$disabledAttr = $fieldDisabled ? ' disabled' : '';
?>
		<div class="admin-ui-input-wrapper">
			<input type="<?php echo $htmlInputType; ?>" name="<?php echo so_saved_h($field['name'] ?? ''); ?>"<?php echo $fieldIdAttr; ?> class="admin-ui-input<?php echo $hasIconClass; ?>" value="<?php echo so_saved_h($fieldValue); ?>" <?php echo isset($field['placeholder']) ? ' placeholder="' . so_saved_h($field['placeholder']) . '"' : ''; ?><?php echo ($htmlInputType === 'date' && !$fieldDisabled) ? ' onclick="if(typeof this.showPicker === \'function\') this.showPicker();"' : ''; ?><?php echo $disabledAttr; ?>>
			<?php if ($fieldIcon !== '') {
				$isImgIcon = (strpos($fieldIcon, '/') !== false || strpos($fieldIcon, '.') !== false);
				$iconClickable = (($fieldIconOnclick !== '') || $fieldClearable) && !$fieldDisabled;
				$iconClass = $iconClickable ? 'admin-ui-icon-clickable' : 'admin-ui-icon';
				if ($fieldIconOnclick !== '') {
					$iconOnclickAttr = ' onclick="' . so_saved_h($fieldIconOnclick) . '"';
				} elseif ($fieldClearable) {
					$iconOnclickAttr = ' onclick="this.previousElementSibling.value=\'\'"';
				} else {
					$iconOnclickAttr = '';
				}
				$iconIdAttr = $fieldIconId !== '' ? ' id="' . so_saved_h($fieldIconId) . '"' : '';
				if ($isImgIcon) { ?>
					<img src="<?php echo so_saved_h($fieldIcon); ?>" alt="icon" class="<?php echo $iconClass; ?>" style="width: 18px; height: 18px; object-fit: contain;"<?php echo $iconIdAttr . $iconOnclickAttr; ?>>
				<?php } else { ?>
					<i class="<?php echo so_saved_h($fieldIcon); ?> <?php echo $iconClass; ?>"<?php echo $iconIdAttr . $iconOnclickAttr; ?>></i>
				<?php }
			} ?>
		</div>
<?php
	}
}

if (!function_exists('renderAdminUiButtonItem')) {
	function renderAdminUiButtonItem($btn) {
		$variant = $btn['variant'] ?? 'purple';
		$variantClass = ($variant === 'danger') ? ' variant-danger' : '';
		$activeClass = !empty($btn['active']) ? ' active' : '';
		$btnDisabled = !empty($btn['disabled']);
		$disabledAttr = $btnDisabled ? ' disabled' : '';
		$onclickAttr = (isset($btn['onclick']) && !$btnDisabled) ? ' onclick="' . so_saved_h($btn['onclick']) . '"' : '';
?>
		<button type="button" class="admin-ui-btn<?php echo $variantClass . $activeClass; ?>"<?php echo isset($btn['id']) ? ' id="' . so_saved_h($btn['id']) . '"' : ''; ?><?php echo $onclickAttr; ?><?php echo $disabledAttr; ?>>
			<?php if (!empty($btn['icon'])) {
				$isImgIcon = (strpos($btn['icon'], '/') !== false || strpos($btn['icon'], '.') !== false);
				if ($isImgIcon) { ?>
					<img src="<?php echo so_saved_h($btn['icon']); ?>" alt="icon" style="width: 16px; height: 16px; object-fit: contain;">
				<?php } else { ?>
					<i class="<?php echo so_saved_h($btn['icon']); ?>" style="font-size: 16px;"></i>
				<?php }
			} ?>
			<?php echo so_saved_h($btn['label'] ?? ''); ?>
		</button>
<?php
	}
}

$adminTabId = so_saved_h($adminInfoTab['tab_id'] ?? '');
$adminTabTitle = so_saved_h($adminInfoTab['title'] ?? '');
$adminTabRows = $adminInfoTab['rows'] ?? [];
?>
<div id="<?php echo $adminTabId; ?>" class="so-tab-content">
	<div class="so-card">
		<h2 class="admin-ui-title"><?php echo $adminTabTitle; ?></h2>

		<?php foreach ($adminTabRows as $adminTabRow) { ?>
			<div class="admin-ui-grid">
				<?php foreach ($adminTabRow as $adminTabField) {
					$fieldType = $adminTabField['type'] ?? 'text';
					$spanVal = $adminTabField['span'] ?? 1;
					$fieldSpanClass = ($spanVal > 1) ? ' span-' . $spanVal : '';
				?>
					<div class="admin-ui-field<?php echo $fieldSpanClass; ?>">
						<?php if ($fieldType === 'inline_group') {
							$groupLabel = $adminTabField['label'] ?? '';
							$groupFields = $adminTabField['fields'] ?? [];
						?>
							<?php if ($groupLabel !== '') { ?>
								<label class="admin-ui-label"><?php echo so_saved_h($groupLabel); ?></label>
							<?php } ?>
							<div class="admin-ui-inline-group">
								<?php foreach ($groupFields as $gField) {
									$gType = $gField['type'] ?? 'text';
									if ($gType === 'button') {
										renderAdminUiButtonItem($gField);
									} else { ?>
										<div class="admin-ui-field-item flex-fill">
											<?php if (isset($gField['label']) && $groupLabel === '') { ?>
												<label class="admin-ui-label"><?php echo so_saved_h($gField['label']); ?></label>
											<?php } ?>
											<?php renderAdminUiInputItem($gField); ?>
										</div>
									<?php }
								} ?>
							</div>
						<?php } elseif ($fieldType === 'sub_grid') {
							$subFields = $adminTabField['fields'] ?? [];
						?>
							<div class="admin-ui-sub-grid">
								<?php foreach ($subFields as $sField) { ?>
									<div class="admin-ui-field">
										<?php if (isset($sField['label'])) { ?>
											<label class="admin-ui-label"><?php echo so_saved_h($sField['label']); ?></label>
										<?php } ?>
										<?php renderAdminUiInputItem($sField); ?>
									</div>
								<?php } ?>
							</div>
						<?php } elseif ($fieldType === 'button_field' || $fieldType === 'button') {
							$btnData = ($fieldType === 'button_field') ? ($adminTabField['button'] ?? $adminTabField) : $adminTabField;
							$hasLabel = !empty($adminTabField['label']);
						?>
							<?php if ($hasLabel) { ?>
								<label class="admin-ui-label"><?php echo so_saved_h($adminTabField['label']); ?></label>
							<?php } else { ?>
								<div style="height: 29px;"></div>
							<?php } ?>
							<?php renderAdminUiButtonItem($btnData); ?>
						<?php } else { ?>
							<?php if (isset($adminTabField['label'])) { ?>
								<label class="admin-ui-label"><?php echo so_saved_h($adminTabField['label']); ?></label>
							<?php } ?>
							<?php renderAdminUiInputItem($adminTabField); ?>
						<?php } ?>
					</div>
				<?php } ?>
			</div>
		<?php } ?>
	</div>
</div>
<?php
unset($adminTabId, $adminTabTitle, $adminTabRows, $adminTabRow, $adminTabField, $fieldType, $spanVal, $fieldSpanClass);
