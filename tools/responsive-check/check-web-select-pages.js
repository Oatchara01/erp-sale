// Run: node tools/responsive-check/check-web-select-pages.js
// Inspect real cached document markup with current CSS, without executing application
// scripts, making network requests, or submitting forms. Fall back to PHP tokens
// (not PHP execution) when a page has no cached snapshot.
const assert = require('node:assert/strict');
const fs = require('fs');
const path = require('path');
const { execFileSync } = require('node:child_process');
const puppeteer = require('puppeteer-core');
const root = path.resolve(__dirname, '../..');
const read = file => fs.readFileSync(path.join(root, file), 'utf8');
const php = process.env.PHP_PATH || 'C:/laragon/bin/php/php-8.3.30-Win32-vs16-x64/php.exe';
const pages = fs.readdirSync(root).filter(file => /^register_.*\.php$/.test(file) && /class=["'][^"']*\bso-select\b/.test(read(file)));

function staticMarkup(file) {
	return execFileSync(php, ['-r', '$tokens=token_get_all(file_get_contents($argv[1])); foreach($tokens as $token) { if(is_array($token) && $token[0]===T_INLINE_HTML) echo $token[1]; }', path.join(root, file)], { encoding: 'utf8', maxBuffer: 8 * 1024 * 1024 });
}

function markup(file) {
	const snapshot = path.join(__dirname, 'out', 'pg_' + file.replace('.php', '.html'));
	let html = fs.existsSync(snapshot) ? fs.readFileSync(snapshot, 'utf8') : staticMarkup(file);
	html = html.replace(/<script\b[^>]*>[\s\S]*?<\/script>/gi, '');
	html = html.replace(/<link\b[^>]*>/gi, tag => {
		const href = /href=["']([^"']+)["']/i.exec(tag);
		if (!href || !/rel=["']stylesheet["']/i.test(tag)) return '';
		const filePath = path.resolve(root, href[1].split('?')[0]);
		if (!filePath.startsWith(root + path.sep) || !fs.existsSync(filePath)) return '';
		return '<style>' + fs.readFileSync(filePath, 'utf8').replace(/@import\s+url\([^)]*\)\s*;/g, '') + '</style>';
	});
	// Current inline page CSS can differ from the cached snapshot.
	const inlineStyles = (staticMarkup(file).match(/<style\b[^>]*>[\s\S]*?<\/style>/gi) || []).join('\n');
	return html + inlineStyles + '<style>' + read('css/so-web-select.css') + '</style><script type="application/json" data-so-web-selects></script>';
}

(async () => {
	assert.equal(pages.length, 15, 'Review the document inventory when modern pages are added');
	const browser = await puppeteer.launch({ executablePath: process.env.CHROME_PATH || 'C:/Program Files/Google/Chrome/Application/chrome.exe', headless: true });
	let tested = 0;
	try {
		const page = await browser.newPage();
		const errors = [];
		page.on('pageerror', error => errors.push(error.message));
		await page.setRequestInterception(true);
		page.on('request', request => request.abort());
		for (const file of pages) {
			const source = read(file);
			assert(source.includes('defer data-so-web-selects src="js/so-web-select.js?'), file + ': missing opt-in script');
			assert(source.includes('href="css/so-web-select.css?'), file + ': missing CSS');
			const html = markup(file);
			let count = 0;
			for (const width of [744, 820, 1440]) {
				await page.setViewport({ width, height: 1180, isMobile: width < 1440, hasTouch: width < 1440 });
				await page.setContent(html, { waitUntil: 'domcontentloaded' });
				// Application handlers require DB data and their own scripts. Exercise
				// dropdown event delivery and payload separately, without running them.
				await page.evaluate(() => document.querySelectorAll('*').forEach(element => Array.from(element.attributes).filter(attribute => /^on/i.test(attribute.name)).forEach(attribute => element.removeAttribute(attribute.name))));
				await page.addScriptTag({ content: read('js/so-web-select.js') });
				const selects = await page.$$('select.so-select');
				count = selects.length;
				assert(count > 0, file + ': empty markup');
				for (let index = 0; index < count; index++) {
					const select = selects[index];
					const context = file + ' ' + width + 'px control #' + index;
					await select.evaluate(select => {
						for (let ancestor = select.parentElement; ancestor && ancestor !== document.body; ancestor = ancestor.parentElement) {
							if (getComputedStyle(ancestor).display === 'none') ancestor.style.setProperty('display', ancestor.classList.contains('customer-popup-modal') ? 'flex' : 'block', 'important');
						}
						select.scrollIntoView({ block: 'center' });
					});
					const button = await select.evaluateHandle(select => select.nextElementSibling);
					assert(await button.evaluate(button => button.classList.contains('so-web-select-button')), context + ': no web picker');
					const locked = await select.evaluate(select => select.matches(':disabled'));
					assert.equal(await button.evaluate(button => button.disabled), locked, context + ': lock mismatch');
					if (locked) continue;
					if (await button.evaluate(button => button.hidden)) continue;
					await button.click();
					const menu = await page.$('.so-web-select-list');
					assert(menu, context + ': did not open');
					const metrics = await menu.evaluate(menu => {
						const rect = menu.getBoundingClientRect();
						const top = visualViewport ? visualViewport.offsetTop : 0;
						const height = visualViewport ? visualViewport.height : innerHeight;
						const row = menu.querySelector('[role="option"]');
						return { fits: rect.left >= -1 && rect.right <= innerWidth + 1 && rect.top >= top - 1 && rect.bottom <= top + height + 1, family: row ? getComputedStyle(row).fontFamily : 'Prompt', hit: menu.contains(document.elementFromPoint(rect.left + 12, rect.top + 12)) };
					});
					assert(metrics.fits, context + ': menu outside viewport');
					assert(metrics.family.includes('Prompt'), context + ': font mismatch');
					assert(metrics.hit, context + ': menu covered by another layer');
					const target = await select.evaluate(select => Array.from(select.options).findIndex((option, index) => index !== select.selectedIndex && !option.disabled && !option.hidden && !(option.parentElement.tagName === 'OPTGROUP' && (option.parentElement.hidden || option.parentElement.disabled))));
					if (target >= 0) {
						await select.evaluate(select => {
							select.dataset.inputEvents = '0'; select.dataset.changeEvents = '0';
							select.addEventListener('input', () => select.dataset.inputEvents = String(Number(select.dataset.inputEvents) + 1), { once: true });
							select.addEventListener('change', () => select.dataset.changeEvents = String(Number(select.dataset.changeEvents) + 1), { once: true });
						});
						await page.click('.so-web-select-list [data-index="' + target + '"]');
						const result = await select.evaluate(select => ({ index: select.selectedIndex, input: select.dataset.inputEvents, change: select.dataset.changeEvents, displayed: select.nextElementSibling.textContent === select.options[select.selectedIndex].text, payload: !select.name || !select.form || new FormData(select.form).getAll(select.name).includes(select.value) }));
						assert.deepEqual(result, { index: target, input: '1', change: '1', displayed: true, payload: true }, context + ': selection/payload mismatch');
					} else await page.keyboard.press('Escape');
					await button.dispose();
					tested++;
				}
				assert.deepEqual(errors, [], file + ': browser error');
				await page.keyboard.press('Escape');
			}
			console.log('PASS ' + file + ': ' + count + ' controls, 744/820/1440px');
		}
		console.log('PASS ' + pages.length + ' document pages; ' + tested + ' picker interactions; no network or submissions');
	} finally { await browser.close(); }
})().catch(error => { console.error(error); process.exitCode = 1; });
