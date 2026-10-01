<?php

$docOpenFn = $docTabsCard['open_fn'] ?? 'open3Tab';

$docExtra = $docTabsCard['doc_extra'] ?? null;
$docExtraPills = $docExtra['pills'] ?? [];
$docExtraOtherField = $docExtra['other_field'] ?? null;
$docExtraTextPairs = $docExtra['text_pairs'] ?? [];
$docExtraHiddenCompat = $docExtra['hidden_compat'] ?? [];

$deptComment = $docTabsCard['dept_comment'] ?? null;
$attachFile = $docTabsCard['attach_file'] ?? null;
$relatedDocs = $docTabsCard['related_docs'] ?? null;
$productChecklists = $docTabsCard['product_checklists'] ?? null;
$productChecklistRows = $productChecklists['rows'] ?? [];
$documentReturnLog = $docTabsCard['document_return_log'] ?? null;
$documentReturnLogRows = $documentReturnLog['rows'] ?? [];

$showDocExtra = $docExtra !== null && ($docExtra['enabled'] ?? true);
$showDeptComment = $deptComment !== null && ($deptComment['enabled'] ?? true || isset($deptComment['placeholder']));
$showAttachFile = $attachFile !== null && ($attachFile['enabled'] ?? true || isset($attachFile['placeholder']));
$showRelatedDocs = $relatedDocs !== null && ($relatedDocs['enabled'] ?? true || isset($relatedDocs['placeholder']));
$showProductChecklists = $productChecklists !== null && ($productChecklists['enabled'] ?? true || isset($productChecklists['placeholder']));
$showDocumentReturnLog = $documentReturnLog !== null && ($documentReturnLog['enabled'] ?? true || isset($documentReturnLog['placeholder']));

$activeTabId = null;
if ($showDocExtra && $activeTabId === null) $activeTabId = 'tab_doc_extra';
if ($showDeptComment && $activeTabId === null) $activeTabId = 'tab_dept_comment';
if ($showAttachFile && $activeTabId === null) $activeTabId = 'tab_attach_file';
if ($showRelatedDocs && $activeTabId === null) $activeTabId = 'tab_related_docs';
if ($showProductChecklists && $activeTabId === null) $activeTabId = 'tab_product_checklists';
if ($showDocumentReturnLog && $activeTabId === null) $activeTabId = 'tab_document_return_log';

// จุด ● บนแท็บ = แท็บนั้นมีข้อมูลที่ผู้ใช้กรอก — ค่าเริ่มต้นของ "เอกสารเพิ่มเติม" คิดจาก PHP กันกะพริบ
// ส่วน "ข้อความแจ้งแผนก"/"แนบไฟล์" วาดด้วย JS จึงให้ js/doc-tabs-dots.js ตัดสินและอัปเดตทุกแท็บขณะกรอก
// ไม่นับ checkbox ซ่อน (hidden_compat, checkbox ของ other_field) เพราะผู้ใช้มองไม่เห็น
$docExtraHasData = trim((string)($docExtraOtherField['text_value'] ?? '')) !== '';
foreach ($docExtraPills as $pill) {
	if (!empty($pill['checked'])) $docExtraHasData = true;
}
foreach ($docExtraTextPairs as $pair) {
	if (!empty($pair['checkbox_checked']) || trim((string)($pair['text_value'] ?? '')) !== '') $docExtraHasData = true;
}
$docTabDotStyle = 'color: #E81A70; margin-right: 6px;';
?>
<div class="so-tabs-container" style="margin-top: 24px;">
	<?php if ($showDocExtra) { ?>
		<button type="button" class="so-tab-btn <?php echo ($activeTabId === 'tab_doc_extra') ? 'active' : ''; ?>" onclick="<?php echo $docOpenFn; ?>('tab_doc_extra', this)"><span class="so-tab-dot" data-tab-dot="tab_doc_extra" aria-hidden="true" style="<?php echo $docTabDotStyle; ?><?php echo $docExtraHasData ? '' : ' display: none;'; ?>">●</span>เอกสารเพิ่มเติม</button>
	<?php } ?>
	<?php if ($showDeptComment) { ?>
		<button type="button" class="so-tab-btn <?php echo ($activeTabId === 'tab_dept_comment') ? 'active' : ''; ?>" onclick="<?php echo $docOpenFn; ?>('tab_dept_comment', this)"><span class="so-tab-dot" data-tab-dot="tab_dept_comment" aria-hidden="true" style="<?php echo $docTabDotStyle; ?> display: none;">●</span>ข้อความแจ้งแผนก</button>
	<?php } ?>
	<?php if ($showAttachFile) { ?>
		<button type="button" class="so-tab-btn <?php echo ($activeTabId === 'tab_attach_file') ? 'active' : ''; ?>" onclick="<?php echo $docOpenFn; ?>('tab_attach_file', this)"><span class="so-tab-dot" data-tab-dot="tab_attach_file" aria-hidden="true" style="<?php echo $docTabDotStyle; ?> display: none;">●</span>แนบไฟล์</button>
	<?php } ?>
	<?php if ($showRelatedDocs) { ?>
		<button type="button" class="so-tab-btn <?php echo ($activeTabId === 'tab_related_docs') ? 'active' : ''; ?>" onclick="<?php echo $docOpenFn; ?>('tab_related_docs', this)">เอกสารที่เกี่ยวข้อง</button>
	<?php } ?>
	<?php if ($showProductChecklists) { ?>
		<button type="button" class="so-tab-btn <?php echo ($activeTabId === 'tab_product_checklists') ? 'active' : ''; ?>" onclick="<?php echo $docOpenFn; ?>('tab_product_checklists', this)">ใบตรวจทานสินค้า</button>
	<?php } ?>
	<?php if ($showDocumentReturnLog) { ?>
		<?php // จุดแดง (.so-document-return-tab-btn::before ใน css/so-core.css) แสดงเฉพาะเมื่อมีรายการส่งกลับ ?>
		<button type="button" class="so-tab-btn <?php echo !empty($documentReturnLogRows) ? 'so-document-return-tab-btn ' : ''; ?><?php echo ($activeTabId === 'tab_document_return_log') ? 'active' : ''; ?>" onclick="<?php echo $docOpenFn; ?>('tab_document_return_log', this)">การส่งกลับเอกสาร</button>
	<?php } ?>
</div>
<div class="so-card" data-doc-tabs-card style="padding: 24px;">

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
						<label style="color: #612989; font-weight: 500; font-size: 14px; margin-bottom: 8px; display: block; font-family: 'Prompt', sans-serif;">อื่นๆ</label>
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
			<?php if (!empty($attachFile['enabled'])) {
				// Optional overrides (defaults = slip1-slip5 / slots 2-5 / upload/): see js/doc-tabs-attach.js attachConfig().
				$attachPrefix = $attachFile['file_prefix'] ?? 'slip';
				$attachSlots = max(1, (int)($attachFile['slots'] ?? 5));
				$attachFirstSlot = max(1, (int)($attachFile['first_slot'] ?? 2));
				$attachBaseUrl = $attachFile['base_url'] ?? 'upload/';
				$attachMaxBytes = (int)($attachFile['max_bytes'] ?? 1100000);
				$attachAllowedExt = $attachFile['allowed_ext'] ?? '';
				$attachAccept = $attachFile['accept'] ?? '';
				$attachHint = $attachFile['hint'] ?? '';
			?>
				<h3 style="font-size: 18px; color: #3B3B3B; margin-bottom: 24px;">แนบไฟล์เพิ่มเติม</h3>
				<hr style="border: 0; border-top: 1px solid #EBEBEB; margin-bottom: 24px;">

				<button type="button" onclick="triggerAttachFile()" style="background-color: #EFEBFF; color: #612989; border: none; border-radius: 24px; padding: 10px 24px; font-family: 'Prompt', sans-serif; font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 8px; margin-bottom: <?php echo $attachHint !== '' ? '12' : '24'; ?>px;">
					<img src="img/icons/import_file.png" alt="import_file" style="width: 16px; height: 16px;"> เพิ่มไฟล์
				</button>
				<?php if ($attachHint !== '') { ?>
					<p style="margin: 0 0 24px; font-size: 13px; color: #7A767D;"><?php echo so_saved_h($attachHint); ?></p>
				<?php } ?>

				<div id="attach_file_list" style="display: flex; flex-wrap: wrap; gap: 16px;"
					data-first-slot="<?php echo $attachFirstSlot; ?>"
					data-last-slot="<?php echo $attachSlots; ?>"
					data-base-url="<?php echo so_saved_h($attachBaseUrl); ?>"
					data-max-bytes="<?php echo $attachMaxBytes; ?>"
					data-allowed-ext="<?php echo so_saved_h($attachAllowedExt); ?>">
					<!-- Dynamic files will go here -->
				</div>

				<!-- Default: slip1 is reserved for payment proof; additional files use slip2-slip5. -->
				<?php for ($attachSlot = 1; $attachSlot <= $attachSlots; $attachSlot++) { ?>
					<input type="file" name="<?php echo so_saved_h($attachPrefix . $attachSlot); ?>" id="hidden_slip<?php echo $attachSlot; ?>" style="display:none;"<?php echo $attachAccept !== '' ? ' accept="' . so_saved_h($attachAccept) . '"' : ''; ?> onchange="handleFileSelect(this, <?php echo $attachSlot; ?>)">
				<?php } ?>
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

	<?php if ($showProductChecklists) { ?>
		<!-- TAB: ใบตรวจทานสินค้า -->
		<div id="tab_product_checklists" class="so-3tab-content" style="display:<?php echo ($activeTabId === 'tab_product_checklists') ? 'block' : 'none'; ?>;">
			<?php if (!empty($productChecklists['enabled'])) { ?>
				<div class="so-related-doc-table">
					<div class="so-related-doc-header">
						<div>ชื่อสินค้า</div>
						<div>เลขที่เอกสาร</div>
						<div></div>
					</div>
					<div id="product_checklist_rows">
						<?php if (!empty($productChecklistRows)) { ?>
							<?php foreach ($productChecklistRows as $productChecklistRow) { ?>
								<div class="so-related-doc-row">
									<div><?php echo so_saved_h($productChecklistRow['product_name'] ?? ''); ?></div>
									<div><?php echo so_saved_h($productChecklistRow['ref_pc'] ?? ''); ?></div>
									<div>
										<a href="report_checklist.php?product_code=<?php echo urlencode($productChecklistRow['product_code'] ?? ''); ?>&ref_id_br=<?php echo urlencode($productChecklistRow['ref_id_br'] ?? ''); ?>&doc_no=<?php echo urlencode($productChecklistRow['doc_no'] ?? ''); ?>&year_no=<?php echo urlencode($productChecklistRow['year_no'] ?? ''); ?>" target="_blank" class="so-related-doc-action" title="พิมพ์ใบตรวจทานสินค้า" aria-label="พิมพ์ใบตรวจทานสินค้า">
											<i class="fas fa-print"></i>
										</a>
									</div>
								</div>
							<?php } ?>
						<?php } else { ?>
							<div class="so-related-doc-empty">ยังไม่มีใบตรวจทานสินค้า</div>
						<?php } ?>
					</div>
				</div>
			<?php } else { ?>
				<div class="so-section-title-container">
					<h3 class="so-section-title">ใบตรวจทานสินค้า</h3>
					<hr class="so-divider">
				</div>
				<p style="color: var(--so-muted); font-size: 14px;"><?php echo so_saved_h($productChecklists['placeholder'] ?? 'ยังไม่มีใบตรวจทานสินค้า'); ?></p>
			<?php } ?>
		</div>
	<?php } ?>

	<?php if ($showDocumentReturnLog) { ?>
		<!-- TAB 5: การส่งกลับเอกสาร -->
		<div id="tab_document_return_log" class="so-3tab-content" style="display:<?php echo ($activeTabId === 'tab_document_return_log') ? 'block' : 'none'; ?>;">
			<?php if (!empty($documentReturnLog['enabled'])) { ?>
				<div style="overflow-x:auto;">
					<table class="so-document-status-table">
						<thead>
							<tr>
								<th>สถานะ</th>
								<th>เหตุผลการส่งกลับ</th>
								<th>ผู้ส่งกลับ</th>
							</tr>
						</thead>
						<tbody>
							<?php if (!empty($documentReturnLogRows)) { ?>
								<?php foreach ($documentReturnLogRows as $documentReturnLogRow) { ?>
									<tr>
										<td class="so-document-log-status-cell">
											<span class="so-document-status-pill <?php echo so_saved_h($documentReturnLogRow['status_class'] ?? 'is-cancelled'); ?>">
												<?php echo so_saved_h($documentReturnLogRow['status_label'] ?? ''); ?>
											</span>
										</td>
										<td class="so-document-log-reason-cell"><?php echo so_saved_h($documentReturnLogRow['reason'] ?? ''); ?></td>
										<td class="so-document-log-user-cell">
											<div><?php echo so_saved_h(($documentReturnLogRow['user_name'] ?? '') !== '' ? $documentReturnLogRow['user_name'] : '-'); ?></div>
											<?php if (!empty($documentReturnLogRow['created_at'])) { ?>
												<div class="so-document-log-time"><?php echo so_saved_h($documentReturnLogRow['created_at']); ?></div>
											<?php } ?>
										</td>
									</tr>
								<?php } ?>
							<?php } else { ?>
								<tr class="so-document-status-empty">
									<td colspan="3"><?php echo so_saved_h($documentReturnLog['empty_text'] ?? 'ยังไม่มีรายการส่งกลับเอกสาร'); ?></td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			<?php } else { ?>
				<div class="so-section-title-container">
					<h3 class="so-section-title">การส่งกลับเอกสาร</h3>
					<hr class="so-divider">
				</div>
				<p style="color: var(--so-muted); font-size: 14px;"><?php echo so_saved_h($documentReturnLog['placeholder'] ?? 'ยังไม่มีรายการส่งกลับเอกสาร'); ?></p>
			<?php } ?>
		</div>
	<?php } ?>
</div>
<script src="js/doc-tabs-dots.js?v=<?php echo filemtime(__DIR__ . '/../js/doc-tabs-dots.js'); ?>"></script>
<?php
unset($docExtraHasData, $docTabDotStyle, $docOpenFn, $docExtra, $docExtraPills, $docExtraOtherField, $docExtraTextPairs, $docExtraHiddenCompat, $deptComment, $attachFile, $relatedDocs, $productChecklists, $productChecklistRows, $documentReturnLog, $documentReturnLogRows, $showDocExtra, $showDeptComment, $showAttachFile, $showRelatedDocs, $showProductChecklists, $showDocumentReturnLog, $activeTabId, $pill, $pName, $pLabel, $pChecked, $pSpan, $pStyle, $ofTextName, $ofTextValue, $ofCbName, $ofCbId, $ofCbChecked, $hidden, $hName, $hChecked, $pair, $prCbName, $prCbId, $prCbChecked, $prCbLabel, $prTextName, $prTextId, $prTextValue, $dcTechChecked, $productChecklistRow, $documentReturnLogRow, $attachPrefix, $attachSlots, $attachFirstSlot, $attachBaseUrl, $attachMaxBytes, $attachAllowedExt, $attachAccept, $attachHint, $attachSlot);
