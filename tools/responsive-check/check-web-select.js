// Run: node tools/responsive-check/check-web-select.js
// No login, database or submissions; exercise production JS/CSS and objective handlers.
const assert = require('node:assert/strict');
const fs = require('fs');
const path = require('path');
const puppeteer = require('puppeteer-core');
const root = path.resolve(__dirname, '../..');
const read = file => fs.readFileSync(path.join(root, file), 'utf8');
const source = read('register_supbrhos.php');
const handlers = source.slice(source.indexOf('function brRestoreObjectiveDesShared()'), source.indexOf('function brOpenDelTab('));
const selectTag = source.match(/<select name="objective"[^>]*>/)[0];
const css = ['css/w3.css', 'css/style.css', 'css/so-core.css', 'css/register-suphos.css', 'css/register-supbrhos.css', 'css/so-web-select.css'].map(file => '<style>' + read(file).replace(/@import\s+url\([^)]*\)\s*;/g, '') + '</style>').join('\n');
const html = `<!doctype html><meta name="viewport" content="width=device-width, initial-scale=1">${css}
<form data-so-web-selects novalidate><div class="so-card"><div class="so-field-group">
<label class="so-label" for="objective">วัตถุประสงค์ในการยืม <span>*</span></label>
<div class="so-select-wrapper">${selectTag}
<option value="">เลือกวัตถุประสงค์</option><option value="1">เป็นสินค้าสำรอง</option>
<option value="2">สำหรับลูกค้าทดลองใช้</option><option value="4" data-need-des="1" data-label="รายละเอียด">ส่งสินค้าล่วงหน้าเพื่อรอใบสั่งซื้อ</option>
<option value="5" disabled>สินค้าออกบูธ</option><option value="6">อื่น ๆ</option></select></div></div>
<div id="objective_des_group" style="display:none"><label id="objective_des_label"></label><input id="objective_des_shared"></div>
<div id="br_borrow_days_group" style="display:none"><input id="br_borrow_days"></div>
<input id="objective_des1" type="hidden"><input id="objective_des2" type="hidden"><input id="objective_des4" type="hidden"><input id="objective_des5" type="hidden">
<div id="addresses"><div class="address-row"><div class="so-select-wrapper"><select name="province_name" class="so-select"><option value="">เลือกจังหวัด</option><option>กรุงเทพมหานคร</option><option>เชียงใหม่</option></select></div></div></div>
</div></form><button id="outside" type="button" style="position:fixed;right:10px;bottom:10px">Outside</button>`;

(async () => {
	assert(source.includes('src="js/so-web-select.js?'), 'Page must load the enhancement');
	assert(source.includes('<form data-so-web-selects'), 'Page must opt in');
	const browser = await puppeteer.launch({ executablePath: process.env.CHROME_PATH || 'C:/Program Files/Google/Chrome/Application/chrome.exe', headless: true });
	try {
		const page = await browser.newPage();
		const errors = [];
		page.on('pageerror', error => errors.push(error.message));
		await page.setRequestInterception(true);
		page.on('request', request => request.abort());
		for (const width of [744, 820, 1180, 1440]) {
			await page.setViewport({ width, height: 1024, isMobile: width < 1440, hasTouch: width < 1440 });
			await page.setContent(html, { waitUntil: 'domcontentloaded' });
			await page.addScriptTag({ content: handlers });
			await page.addScriptTag({ content: read('js/so-required-fields.js') });
			if (!process.env.BASELINE) await page.addScriptTag({ content: read('js/so-web-select.js') });
			assert.equal(await page.$eval('[data-so-web-selects]', form => form.querySelectorAll('.so-web-select-button').length), 2, 'Selects must use web pickers rather than the iPad system menu');
			const button = '#objective + .so-web-select-button';
			assert.equal(await page.$eval(button, button => getComputedStyle(button).borderRadius), '10px');
			assert.equal(await page.$eval(button, button => getComputedStyle(button).backgroundColor), 'rgb(245, 246, 248)');
			if (width < 1440) await page.tap(button); else await page.click(button);
			const metrics = await page.$eval('.so-web-select-list', list => {
				const rect = list.getBoundingClientRect();
				const style = getComputedStyle(list.firstElementChild);
				return { family: style.fontFamily, size: style.fontSize, height: list.firstElementChild.getBoundingClientRect().height, fits: rect.left >= 0 && rect.right <= innerWidth && rect.top >= 0 && rect.bottom <= innerHeight };
			});
			assert(metrics.family.includes('Prompt'));
			assert.equal(metrics.size, '14px');
			assert(metrics.height >= 44 && metrics.fits);
			if (width === 820) {
				const out = path.join(__dirname, 'out');
				fs.mkdirSync(out, { recursive: true });
				await page.screenshot({ path: path.join(out, 'web-select-ipad.png') });
			}
			if (width < 1440) await page.tap('.so-web-select-list [data-index="2"]'); else await page.click('.so-web-select-list [data-index="2"]');
			assert.equal(await page.$eval('#objective', select => select.value), '2');
			assert.equal(await page.$eval('#br_borrow_days_group', group => group.style.display), '');
			assert.equal(await page.$eval('form', form => new FormData(form).get('objective')), '2');
			await page.click(button);
			await page.click('.so-web-select-list [data-index="4"]');
			assert.equal(await page.$eval('#objective', select => select.value), '2', 'Disabled options cannot be chosen');
			await page.keyboard.press('End');
			await page.keyboard.press('Enter');
			assert.equal(await page.$eval('#objective', select => select.value), '6');
			await page.click(button);
			await page.click('.so-web-select-list [data-index="3"]');
			assert.equal(await page.$eval('#objective_des_group', group => group.style.display), '');
			assert.equal(await page.$eval('#objective_des_label', label => label.textContent), 'รายละเอียด');
			await page.evaluate(() => { document.getElementById('objective').value = '1'; });
			await page.waitForFunction(() => document.querySelector('#objective + button').textContent === 'เป็นสินค้าสำรอง');
			await page.click(button);
			await page.evaluate(() => {
				const select = document.getElementById('objective');
				select.add(new Option('ตัวเลือกเพิ่มเติม', '7'));
			});
			await page.waitForSelector('.so-web-select-list [data-index="6"]');
			await page.evaluate(() => { document.getElementById('objective').value = '7'; });
			await page.waitForFunction(() => document.querySelector('.so-web-select-list [data-index="6"]').getAttribute('aria-selected') === 'true');
			await page.keyboard.press('Escape');
			await page.evaluate(() => {
				const select = document.getElementById('objective');
				select.addEventListener('change', () => { select.value = '1'; }, { once: true });
			});
			await page.click(button);
			await page.click('.so-web-select-list [data-index="5"]');
			assert.equal(await page.$eval(button, button => button.textContent), 'เป็นสินค้าสำรอง', 'Display must follow a change handler that reverts the selection');
			await page.evaluate(() => {
				const row = document.querySelector('.address-row').cloneNode(true);
				row.querySelector('select').selectedIndex = 0;
				document.getElementById('addresses').appendChild(row);
			});
			await page.waitForFunction(() => document.querySelectorAll('.so-web-select-button').length === 3);
			await page.click('.address-row:last-child .so-web-select-button');
			await page.click('.so-web-select-list [data-index="2"]');
			assert.equal(await page.$eval('.address-row:last-child select', select => select.value), 'เชียงใหม่');
			assert.equal(await page.$eval('.address-row:first-child select', select => select.value), '');
			await page.evaluate(() => { document.getElementById('objective').disabled = true; });
			await page.waitForFunction(() => document.querySelector('#objective + button').disabled);
			await page.evaluate(() => { document.getElementById('objective').disabled = false; document.querySelector('form').reset(); });
			await page.waitForFunction(() => document.querySelector('#objective + button').textContent === 'เลือกวัตถุประสงค์');
			assert.equal(await page.evaluate(() => soValidateRequired(document.querySelector('form'))), false);
			await page.waitForFunction(() => document.querySelector('#objective + button').getAttribute('aria-invalid') === 'true');
			assert.equal(await page.evaluate(() => document.activeElement.className), 'so-web-select-button');
			await page.click(button);
			await page.keyboard.press('Escape');
			assert.equal(await page.$('.so-web-select-list'), null);
			await page.click(button);
			await page.click('#outside');
			assert.equal(await page.$('.so-web-select-list'), null);
			console.log(`PASS ${width}px: web font, touch/keyboard, original onchange, form data, prefill, cloned rows, validation, disabled/reset, dismissal`);
		}
		assert.deepEqual(errors, []);
		// Page opt-in must also cover popup filters outside the main form and unwrapped selects.
		await page.setContent(html + `<script type="application/json" data-so-web-selects></script>
		<div role="dialog" style="position:fixed;inset:100px 30px auto;z-index:100000;background:white;padding:20px">
		<label for="popup-filter">ประเภทเอกสาร</label><select id="popup-filter" class="so-select"><option value="a">ใบขาย</option><option value="b">ใบยืม</option></select></div>
		<fieldset id="locked" disabled><div class="so-select-wrapper"><select id="locked-select" class="so-select"><option>AWL</option><option>NBM</option></select></div></fieldset>
		<select id="legacy-select" class="w3-select"><option>เดิม</option></select>`, { waitUntil: 'domcontentloaded' });
		await page.addScriptTag({ content: read('js/so-web-select.js') });
		assert.equal(await page.$eval('#popup-filter', select => select.parentElement.className), 'so-select-wrapper');
		assert.equal(await page.$eval('#locked-select + button', button => button.disabled), true);
		assert.equal(await page.$eval('#legacy-select', select => select.classList.contains('so-web-select-native')), false);
		await page.click('#popup-filter + button');
		assert.equal(await page.$eval('.so-web-select-list', list => !!list.closest('[role="dialog"]')), true);
		assert(await page.$eval('.so-web-select-list', list => Number(getComputedStyle(list).zIndex) > 100000));
		await page.click('.so-web-select-list [data-index="1"]');
		assert.equal(await page.$eval('#popup-filter', select => select.value), 'b');
		await page.evaluate(() => { document.getElementById('locked').disabled = false; });
		await page.waitForFunction(() => !document.querySelector('#locked-select + button').disabled);
		await page.evaluate(() => { document.getElementById('popup-filter').style.display = 'none'; });
		await page.waitForFunction(() => document.querySelector('#popup-filter + button').hidden);
		console.log('PASS page opt-in: outside-form popup, unwrapped control, modal stacking, disabled fieldset, hidden control, legacy exclusion');
		assert.deepEqual(errors, []);
	} finally { await browser.close(); }
})().catch(error => { console.error(error); process.exitCode = 1; });
