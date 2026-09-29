<?php
/**
 * Reusable "ข้อมูลการจัดส่ง / ค่าจัดส่ง" tab card, shared by register_suphos.php
 * and register_supbrhos.php. Driven by $deliveryTab config.
 *
 * Expected shape:
 * $deliveryTab = [
 *     'open_fn'  => 'openDelTab',      // JS tab-switch function already defined by the caller page
 *     'grid_fields' => [               // rendered inside a 6-column grid, 'span' out of 6
 *         ['type' => 'select', 'span' => 2, 'name' => 'delivery_type', 'label' => '...', 'required' => true, 'options' => ['1' => 'Sale รับเอง', ...]],
 *         ['type' => 'date',   'span' => 2, 'name' => 'start_date', 'label' => '...', 'required' => true],
 *         ['type' => 'select', 'span' => 1, 'name' => 'time_range', 'label' => '...', 'options' => [...]],
 *         ['type' => 'time',   'span' => 1, 'name' => 'start_time', 'label' => '...', 'required' => true, 'value' => $v],
 *         ['type' => 'time_pair', 'span' => 2, 'name' => 'start_time', 'end_name' => 'end_time', 'label' => '...', 'required' => true],
 *         ['type' => 'text',   'span' => 4, 'name' => 'between_date', 'label' => '...', 'clearable' => true],
 *     ],
 *     'toggle_buttons' => [
 *         ['name' => 'call_customer', 'id' => 'call_customer', 'label' => 'ต้องการให้โทรแจ้ง', 'checked' => false],
 *     ],
 *     'cost_fields' => [
 *         ['name' => 'shipping_date', 'label' => '...', 'type' => 'date'],
 *         ['name' => 'shipping_ref1', 'label' => '...', 'type' => 'text'],
 *     ],
 * ];
 * include __DIR__ . '/partials/delivery_info_tab.php';
 *
 * Values are expected to already be escaped by the caller (e.g. via so_saved_h()).
 * This partial does not escape 'value' to avoid double-escaping.
 */

$deliveryOpenFn = $deliveryTab['open_fn'] ?? 'openDelTab';
// Hardcoded (not config-driven): css/register-suphos.css scopes the so-grid-6-col
// grid template and the toggle-button :has() styling to the literal #del_info id.
// Both caller pages render this partial on their own page, so reusing the same
// id across pages is safe and lets both pick up that CSS without duplicating it.
$deliveryInfoId = 'del_info';
$deliveryCostId = 'del_cost';
$deliveryGridFields = $deliveryTab['grid_fields'] ?? [];
$deliveryToggleButtons = $deliveryTab['toggle_buttons'] ?? [];
$deliveryCostFields = $deliveryTab['cost_fields'] ?? [];
?>
<div class="so-tabs-container" style="margin-top: 24px;">
	<button type="button" class="so-tab-btn active" onclick="<?php echo $deliveryOpenFn; ?>('<?php echo $deliveryInfoId; ?>', this)">ข้อมูลการจัดส่ง</button>
	<?php // ซ่อนแค่ปุ่มแท็บ ไม่ลบ div#del_cost ด้านล่าง: ช่องค่าจัดส่งยังต้องถูก submit พร้อมฟอร์ม
	// ไม่งั้นตอนคนที่ไม่ใช่ Admin กดบันทึก ค่าจัดส่งที่ Admin คีย์ไว้จะถูกเขียนทับเป็นค่าว่าง
	if (($_SESSION['type_login'] ?? '') === 'Admin') { ?>
		<button type="button" class="so-tab-btn" onclick="<?php echo $deliveryOpenFn; ?>('<?php echo $deliveryCostId; ?>', this)">ค่าจัดส่ง</button>
	<?php } ?>
</div>
<!-- padding เป็น clamp ไม่ใช่ 24px ตายตัว: inline style ไม่มี media query ไหนแก้ได้
     ค่าบนสุดยังเป็น 24px เท่าเดิมบน desktop แต่ยุบเหลือ 16px บนจอแคบเหมือน .so-card ใบอื่น -->
<div class="so-card" style="padding: clamp(16px, 3vw, 24px);">

	<!-- TAB 1: ข้อมูลการจัดส่ง -->
	<div id="<?php echo $deliveryInfoId; ?>" class="so-del-tab-content">

		<div class="so-section-title-container">
			<h3 class="so-section-title">ข้อมูลการจัดส่ง</h3>
			<hr class="so-divider">
		</div>

		<div class="so-grid-6-col">
			<?php foreach ($deliveryGridFields as $field) {
				$fType = $field['type'] ?? 'text';
				$fSpan = $field['span'] ?? 1;
				$fName = so_saved_h($field['name'] ?? '');
				$fLabel = so_saved_h($field['label'] ?? '');
				$fRequired = !empty($field['required']);
				$fClearable = !empty($field['clearable']);
				?>
				<div class="so-field-group" style="grid-column: span <?php echo (int)$fSpan; ?>;">
					<?php if ($fType === 'time_pair') {
						$fEndName = so_saved_h($field['end_name'] ?? 'end_time');
						?>
						<label class="so-label"><?php echo $fLabel; ?><?php if ($fRequired) { ?><span style="color:red">*</span><?php } ?></label>
						<div class="so-toggle-group">
							<input id="<?php echo $fName; ?>" name="<?php echo $fName; ?>" class="so-input" type="text" placeholder="เวลาส่ง" value="<?php echo $field['value'] ?? ''; ?>">
							<span>ถึง</span>
							<input id="<?php echo $fEndName; ?>" name="<?php echo $fEndName; ?>" class="so-input" type="text" placeholder="เวลาสิ้นสุด" value="<?php echo $field['end_value'] ?? ''; ?>">
						</div>
					<?php } else { ?>
						<label class="so-label" for="<?php echo $fName; ?>"><?php echo $fLabel; ?><?php if ($fRequired) { ?><span style="color:red">*</span><?php } ?></label>
						<?php if ($fType === 'select') {
							$fOptions = $field['options'] ?? [];
							?>
							<div class="so-select-wrapper">
								<select name="<?php echo $fName; ?>" id="<?php echo $fName; ?>" class="so-select">
									<?php foreach ($fOptions as $optValue => $optLabel) { ?>
										<option value="<?php echo so_saved_h($optValue); ?>"><?php echo so_saved_h($optLabel); ?></option>
									<?php } ?>
								</select>
							</div>
						<?php } elseif ($fType === 'date') { ?>
							<div class="calendar-wrapper" style="width: 100%; display: flex;">
								<input name="<?php echo $fName; ?>" type="date" id="<?php echo $fName; ?>" class="so-input" style="padding-right: 40px;">
							</div>
						<?php } elseif ($fType === 'time') { ?>
							<div class="time-wrapper">
								<input id="<?php echo $fName; ?>" name="<?php echo $fName; ?>" class="so-input" type="time" value="<?php echo $field['value'] ?? ''; ?>" style="padding-right: 40px;">
							</div>
						<?php } else { ?>
							<div style="position: relative; display: flex; align-items: center; width: 100%;">
								<input name="<?php echo $fName; ?>" class="so-input" type="text" id="<?php echo $fName; ?>" value="<?php echo $field['value'] ?? ''; ?>" placeholder="<?php echo $fLabel; ?>" style="padding-right: 36px !important;">
								<?php if ($fClearable) { ?>
									<i class="fas fa-times" style="position: absolute; right: 12px; cursor: pointer; color: #8E8B94;" onclick="document.getElementById('<?php echo $fName; ?>').value=''"></i>
								<?php } ?>
							</div>
						<?php } ?>
					<?php } ?>
				</div>
			<?php } ?>
		</div>

		<?php if ($deliveryToggleButtons) { ?>
			<div class="so-delivery-toggle-row" style="display: flex; gap: 16px; margin-top: 24px; flex-wrap: wrap;">
				<?php foreach ($deliveryToggleButtons as $toggle) {
					$tName = so_saved_h($toggle['name'] ?? '');
					$tId = so_saved_h($toggle['id'] ?? $tName);
					$tLabel = so_saved_h($toggle['label'] ?? '');
					$tChecked = !empty($toggle['checked']);
					?>
					<label class="so-toggle-btn">
						<input type="checkbox" id="<?php echo $tId; ?>" name="<?php echo $tName; ?>" value="1" style="display:none;"<?php echo $tChecked ? ' checked' : ''; ?> onchange="this.parentElement.style.backgroundColor = this.checked ? '#612989' : '#F4F3F7'; this.nextElementSibling.style.color = this.checked ? '#FFFFFF' : '#6e6e6eff';">
						<span style="color: #6e6e6eff; font-size: 14px; font-weight: 500; font-family: 'Prompt', sans-serif;"><?php echo $tLabel; ?></span>
					</label>
				<?php } ?>
			</div>
		<?php } ?>
	</div>

	<!-- TAB 2: ค่าจัดส่ง -->
	<div id="<?php echo $deliveryCostId; ?>" class="so-del-tab-content" style="display:none;">
		<div class="so-section-title-container">
			<h3 class="so-section-title">ค่าจัดส่ง</h3>
			<hr class="so-divider">
		</div>

		<div class="so-grid-3">
			<?php foreach ($deliveryCostFields as $field) {
				$fName = so_saved_h($field['name'] ?? '');
				$fLabel = so_saved_h($field['label'] ?? '');
				$fType = $field['type'] ?? 'text';
				$fValue = $field['value'] ?? '';
				?>
				<div class="so-field-group">
					<label class="so-label" for="<?php echo $fName; ?>"><?php echo $fLabel; ?></label>
					<?php if ($fType === 'date') { ?>
						<div class="calendar-wrapper">
							<input name="<?php echo $fName; ?>" type="date" id="<?php echo $fName; ?>" class="so-input" value="<?php echo $fValue; ?>">
						</div>
					<?php } else { ?>
						<input name="<?php echo $fName; ?>" type="text" id="<?php echo $fName; ?>" class="so-input" value="<?php echo $fValue; ?>">
					<?php } ?>
				</div>
			<?php } ?>
		</div>
	</div>
</div>
<?php
unset($deliveryOpenFn, $deliveryInfoId, $deliveryCostId, $deliveryGridFields, $deliveryToggleButtons, $deliveryCostFields, $field, $fType, $fSpan, $fName, $fLabel, $fRequired, $fClearable, $fEndName, $fOptions, $optValue, $optLabel, $fValue, $toggle, $tName, $tId, $tLabel, $tChecked);
