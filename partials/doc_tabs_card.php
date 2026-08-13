<?php

/**
 * Reusable "เอกสารเพิ่มเติม / ข้อความแจ้งแผนก / แนบไฟล์ / เอกสารที่เกี่ยวข้อง" tabs
 * card, shared by register_suphos.php and register_supbrhos.php.
 * Driven by $docTabsCard config.
 *
 * Expected shape:
 * $docTabsCard = [
 *     'open_fn' => 'open3Tab',   // JS tab-switch function already defined by the caller page
 *     'doc_extra' => [
 *         'enabled' => true,
 *         'pills' => [           // rendered inside a 4-column grid, 'span' out of 4
 *             ['name' => 'ref_3', 'label' => 'ใบ อย.', 'checked' => false, 'span' => 1],
 *         ],
 *         // Either 'other_field' (suphos style: single free-text field auto-checks a
 *         // hidden checkbox) or 'text_pairs' (supbrhos style: checkbox + adjacent
 *         // text input, one or more) — a page can use either, both, or neither.
 *         'other_field' => [
 *             'text_name' => 'ref_des', 'text_value' => '...',
 *             'checkbox_name' => 'ref_10', 'checkbox_id' => 'ref_10_hidden', 'checkbox_checked' => false,
 *         ],
 *         'text_pairs' => [
 *             ['checkbox_name' => 'ref_11', 'checkbox_id' => 'ref_11', 'checkbox_checked' => false, 'checkbox_label' => 'ใบประเมินสินค้า จำนวน', 'text_name' => 'ref_11des', 'text_id' => 'ref_11des', 'text_value' => ''],
 *         ],
 *         'hidden_compat' => [   // extra hidden checkboxes kept for backward compatibility
 *             ['name' => 'ref_13', 'checked' => false],
 *         ],
 *     ],
 *     // Each of the following may be ['enabled' => true, ...fields the full block needs]
 *     // or ['enabled' => false] to render the page's existing static placeholder instead.
 *     'dept_comment' => ['enabled' => false, 'placeholder' => 'ยังไม่มีข้อความแจ้งแผนก'],
 *     'attach_file'  => ['enabled' => false],
 *     'related_docs' => ['enabled' => false, 'placeholder' => 'ยังไม่มีเอกสารที่เกี่ยวข้อง'],
 * ];
 * include __DIR__ . '/partials/doc_tabs_card.php';
 *
 * Values are expected to already be escaped by the caller (e.g. via so_saved_h()).
 * This partial does not escape 'checkbox_label'/'text_value'/free text to avoid
 * double-escaping, except for plain pill 'label' which it escapes itself.
 */

$docOpenFn = $docTabsCard['open_fn'] ?? 'open3Tab';

$docExtra = $docTabsCard['doc_extra'] ?? null;
$docExtraPills = $docExtra['pills'] ?? [];
$docExtraOtherField = $docExtra['other_field'] ?? null;
$docExtraTextPairs = $docExtra['text_pairs'] ?? [];
$docExtraHiddenCompat = $docExtra['hidden_compat'] ?? [];

$deptComment = $docTabsCard['dept_comment'] ?? null;
$attachFile = $docTabsCard['attach_file'] ?? null;
$relatedDocs = $docTabsCard['related_docs'] ?? null;

$showDocExtra = $docExtra !== null && ($docExtra['enabled'] ?? true);
$showDeptComment = $deptComment !== null && ($deptComment['enabled'] ?? true || isset($deptComment['placeholder']));
$showAttachFile = $attachFile !== null && ($attachFile['enabled'] ?? true || isset($attachFile['placeholder']));
$showRelatedDocs = $relatedDocs !== null && ($relatedDocs['enabled'] ?? true || isset($relatedDocs['placeholder']));

$activeTabId = null;
if ($showDocExtra && $activeTabId === null) $activeTabId = 'tab_doc_extra';
if ($showDeptComment && $activeTabId === null) $activeTabId = 'tab_dept_comment';
if ($showAttachFile && $activeTabId === null) $activeTabId = 'tab_attach_file';
if ($showRelatedDocs && $activeTabId === null) $activeTabId = 'tab_related_docs';
?>
<div class="so-tabs-container" style="margin-top: 24px;">
	<?php if ($showDocExtra) { ?>
		<button type="button" class="so-tab-btn <?php echo ($activeTabId === 'tab_doc_extra') ? 'active' : ''; ?>" onclick="<?php echo $docOpenFn; ?>('tab_doc_extra', this)"><span style="color: #E81A70; margin-right: 6px;">●</span>เอกสารเพิ่มเติม</button>
	<?php } ?>
	<?php if ($showDeptComment) { ?>
		<button type="button" class="so-tab-btn <?php echo ($activeTabId === 'tab_dept_comment') ? 'active' : ''; ?>" onclick="<?php echo $docOpenFn; ?>('tab_dept_comment', this)">ข้อความแจ้งแผนก</button>
	<?php } ?>
	<?php if ($showAttachFile) { ?>
		<button type="button" class="so-tab-btn <?php echo ($activeTabId === 'tab_attach_file') ? 'active' : ''; ?>" onclick="<?php echo $docOpenFn; ?>('tab_attach_file', this)">แนบไฟล์</button>
	<?php } ?>
	<?php if ($showRelatedDocs) { ?>
		<button type="button" class="so-tab-btn <?php echo ($activeTabId === 'tab_related_docs') ? 'active' : ''; ?>" onclick="<?php echo $docOpenFn; ?>('tab_related_docs', this)">เอกสารที่เกี่ยวข้อง</button>
	<?php } ?>
</div>
<div class="so-card" style="padding: 24px;">

	<?php if ($showDocExtra) { ?>
	<!-- TAB 1: เอกสารเพิ่มเติม -->
	<div id="tab_doc_extra" class="so-3tab-content" style="display:<?php echo ($activeTabId === 'tab_doc_extra') ? 'block' : 'none'; ?>;">
		<div class="so-section-title-container">
			<h3 class="so-section-title">เอกสารเพิ่มเติม</h3>
			<hr class="so-divider">
		</div>

		<div class="so-doc-grid">
			<?php foreach ($docExtraPills as $pill) {
				$pName = so_saved_h($pill['name'] ?? '');
				$pLabel = so_saved_h($pill['label'] ?? '');
				$pChecked = !empty($pill['checked']);
				$pSpan = $pill['span'] ?? null;
				$pStyle = $pSpan ? ' style="grid-column: span ' . (int)$pSpan . ';"' : '';
			?>
				<label class="so-doc-pill" <?php echo $pStyle; ?>>
					<input type="checkbox" name="<?php echo $pName; ?>" value="1" <?php echo $pChecked ? ' checked' : ''; ?>>
					<span><?php echo $pLabel; ?></span>
				</label>
			<?php } ?>

			<?php if ($docExtraOtherField) {
				$ofTextName = so_saved_h($docExtraOtherField['text_name'] ?? 'ref_des');
				$ofTextValue = $docExtraOtherField['text_value'] ?? '';
				$ofCbName = so_saved_h($docExtraOtherField['checkbox_name'] ?? 'ref_10');
				$ofCbId = so_saved_h($docExtraOtherField['checkbox_id'] ?? ($ofCbName . '_hidden'));
				$ofCbChecked = !empty($docExtraOtherField['checkbox_checked']);
			?>
				<div class="so-doc-other-wrapper" style="grid-column: span 4; display: flex; flex-direction: column; justify-content: flex-end;">
					<label style="color: #612989; font-weight: 400; font-size: 14px; margin-bottom: 8px; display: block; font-family: 'Prompt', sans-serif;">อื่นๆ</label>
					<input type="text" name="<?php echo $ofTextName; ?>" class="so-input" value="<?php echo $ofTextValue; ?>" placeholder="ระบุรายละเอียดอื่นๆ..." style="width: 100%;" oninput="document.getElementById('<?php echo $ofCbId; ?>').checked = (this.value.trim() !== '');">
					<input type="checkbox" name="<?php echo $ofCbName; ?>" id="<?php echo $ofCbId; ?>" value="1" style="display:none;" <?php echo $ofCbChecked ? ' checked' : ''; ?>>
				</div>
			<?php }
			foreach ($docExtraHiddenCompat as $hidden) {
				$hName = so_saved_h($hidden['name'] ?? '');
				$hChecked = !empty($hidden['checked']);
			?>
				<input type="checkbox" name="<?php echo $hName; ?>" value="1" style="display:none;" <?php echo $hChecked ? ' checked' : ''; ?>>
			<?php } ?>
		</div>

		<?php if ($docExtraTextPairs) { ?>
			<div class="so-grid-2">
				<?php foreach ($docExtraTextPairs as $pair) {
					$prCbName = so_saved_h($pair['checkbox_name'] ?? '');
					$prCbId = so_saved_h($pair['checkbox_id'] ?? $prCbName);
					$prCbChecked = !empty($pair['checkbox_checked']);
					$prCbLabel = so_saved_h($pair['checkbox_label'] ?? '');
					$prTextName = so_saved_h($pair['text_name'] ?? '');
					$prTextId = so_saved_h($pair['text_id'] ?? $prTextName);
					$prTextValue = $pair['text_value'] ?? '';
				?>
					<div class="so-input-with-checkbox">
						<label class="so-checkbox-label"><input type="checkbox" name="<?php echo $prCbName; ?>" id="<?php echo $prCbId; ?>" value="1" <?php echo $prCbChecked ? ' checked' : ''; ?>> <?php echo $prCbLabel; ?></label>
						<input name="<?php echo $prTextName; ?>" id="<?php echo $prTextId; ?>" class="so-input" value="<?php echo $prTextValue; ?>">
					</div>
				<?php } ?>
			</div>
		<?php } ?>
	</div>
	<?php } ?>

	<?php if ($showDeptComment) { ?>
	<!-- TAB 2: ข้อความแจ้งแผนก -->
	<div id="tab_dept_comment" class="so-3tab-content" style="display:<?php echo ($activeTabId === 'tab_dept_comment') ? 'block' : 'none'; ?>;">
		<?php if (!empty($deptComment['enabled'])) {
			$dcTechChecked = !empty($deptComment['technician_required_checked']);
		?>
			<h3 style="font-size: 18px; color: #3B3B3B; margin-bottom: 24px;">ข้อความแจ้งแผนกที่เกี่ยวข้อง</h3>
			<hr style="border: 0; border-top: 1px solid #EBEBEB; margin-bottom: 24px;">

			<div style="display: flex; flex-wrap: wrap; gap: 16px; align-items: center; margin-bottom: 24px;">
				<button type="button" onclick="addDeptComment()" style="background-color: #EFEBFF; color: #612989; border: none; border-radius: 24px; padding: 10px 24px; font-family: 'Prompt', sans-serif; font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 8px;">
					<img src="img/icons/add_message.png" alt="add_message" style="width: 16px; height: 16px;"> เพิ่มข้อความ
				</button>
				<button type="button" id="technician_required_btn" class="btn-technician-required <?php echo $dcTechChecked ? 'btn-dept-active' : ''; ?>" onclick="toggleTechnicianRequired(this);">
					ต้องการช่างไปตรวจรับ
				</button>
				<input type="hidden" name="technician_required" id="hidden_technician_required" value="<?php echo $dcTechChecked ? '1' : '0'; ?>">
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
		<?php } else { ?>
			<div class="so-section-title-container">
				<h3 class="so-section-title">ข้อความแจ้งแผนก</h3>
				<hr class="so-divider">
			</div>
			<p style="color: var(--so-muted); font-size: 14px;"><?php echo so_saved_h($deptComment['placeholder'] ?? 'ยังไม่มีข้อความแจ้งแผนก'); ?></p>
		<?php } ?>
	</div>
	<?php } ?>

	<?php if ($showAttachFile) { ?>
	<!-- TAB 3: แนบไฟล์ -->
	<div id="tab_attach_file" class="so-3tab-content" style="display:<?php echo ($activeTabId === 'tab_attach_file') ? 'block' : 'none'; ?>;">
		<?php if (!empty($attachFile['enabled'])) { ?>
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
		<?php } else { ?>
			<div class="so-section-title-container">
				<h3 class="so-section-title">แนบไฟล์</h3>
				<hr class="so-divider">
			</div>
			<div class="so-file-uploads">
				<div class="so-file-input-wrapper"><input name="slip1" type="file" class="so-file-input"></div>
				<div class="so-file-input-wrapper"><input name="slip2" type="file" class="so-file-input"></div>
				<div class="so-file-input-wrapper"><input name="slip3" type="file" class="so-file-input"></div>
				<div class="so-file-input-wrapper"><input name="slip4" type="file" class="so-file-input"></div>
				<div class="so-file-input-wrapper"><input name="slip5" type="file" class="so-file-input"></div>
			</div>
		<?php } ?>
	</div>
	<?php } ?>

	<?php if ($showRelatedDocs) { ?>
	<!-- TAB 4: เอกสารที่เกี่ยวข้อง -->
	<div id="tab_related_docs" class="so-3tab-content" style="display:<?php echo ($activeTabId === 'tab_related_docs') ? 'block' : 'none'; ?>;">
		<?php if (!empty($relatedDocs['enabled'])) { ?>
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
		<?php } else { ?>
			<div class="so-section-title-container">
				<h3 class="so-section-title">เอกสารที่เกี่ยวข้อง</h3>
				<hr class="so-divider">
			</div>
			<p style="color: var(--so-muted); font-size: 14px;"><?php echo so_saved_h($relatedDocs['placeholder'] ?? 'ยังไม่มีเอกสารที่เกี่ยวข้อง'); ?></p>
		<?php } ?>
	</div>
	<?php } ?>
</div>
<?php
unset($docOpenFn, $docExtra, $docExtraPills, $docExtraOtherField, $docExtraTextPairs, $docExtraHiddenCompat, $deptComment, $attachFile, $relatedDocs, $showDocExtra, $showDeptComment, $showAttachFile, $showRelatedDocs, $activeTabId, $pill, $pName, $pLabel, $pChecked, $pSpan, $pStyle, $ofTextName, $ofTextValue, $ofCbName, $ofCbId, $ofCbChecked, $hidden, $hName, $hChecked, $pair, $prCbName, $prCbId, $prCbChecked, $prCbLabel, $prTextName, $prTextId, $prTextValue, $dcTechChecked);
