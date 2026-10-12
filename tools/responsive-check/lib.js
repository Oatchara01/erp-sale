// ตัวช่วยร่วมของ check-modals.js และ check-scroll-lock.js
const puppeteer = require('puppeteer-core');
const fs = require('fs');
const path = require('path');
const { execFileSync } = require('child_process');

const CHROME = process.env.CHROME_PATH || 'C:/Program Files/Google/Chrome/Application/chrome.exe';
const PHP = process.env.PHP_PATH || 'C:/laragon/bin/php/php-8.3.30-Win32-vs16-x64/php.exe';
const BASE_URL = process.env.BASE_URL || 'http://localhost/erpsale/';
const OUT = path.join(__dirname, 'out');
const TEST_URL = BASE_URL + '__t.html';

// ขนาด iPad (CSS px) ที่ใช้ทดสอบ: ชื่อ, กว้าง, สูง
const VIEWPORTS = [
  { id: 'mini-p', name: 'iPad mini แนวตั้ง', w: 744, h: 1133 },
  { id: 'ipad9-p', name: 'iPad 9.7" แนวตั้ง (ขอบ 768)', w: 768, h: 1024 },
  { id: 'ipad-p', name: 'iPad 10.2" แนวตั้ง', w: 810, h: 1080 },
  { id: 'air-p', name: 'iPad Air แนวตั้ง', w: 820, h: 1180 },
  { id: 'pro11-p', name: 'iPad Pro 11" แนวตั้ง', w: 834, h: 1194 },
  { id: 'pro13-p', name: 'iPad Pro 12.9" แนวตั้ง', w: 1024, h: 1366 },
  { id: 'ipad-l', name: 'iPad 10.2" แนวนอน', w: 1080, h: 810 },
  { id: 'air-l', name: 'iPad Air แนวนอน', w: 1180, h: 820 },
  { id: 'pro13-l', name: 'iPad Pro 12.9" แนวนอน', w: 1366, h: 1024 },
];

const sleep = (ms) => new Promise((r) => setTimeout(r, ms));

// เรนเดอร์ด้วย PHP CLI (ข้ามถ้ามีไฟล์แล้วและไม่สั่ง RERENDER=1) แล้วคืนเนื้อ HTML
function renderPage(name, role) {
  const file = path.join(OUT, 'pg_' + name.replace(/\.php$/, '').replace(/\//g, '_') + '.html');
  if (!fs.existsSync(file) || process.env.RERENDER === '1') {
    execFileSync(PHP, [path.join(__dirname, 'render-page.php'), name.endsWith('.php') ? name : name + '.php', role || 'admin'], { stdio: ['ignore', 'pipe', 'pipe'] });
  }
  return fs.readFileSync(file, 'utf8');
}

// classicScrollbars: true เพื่อให้ได้ scrollbar แบบ Windows (puppeteer ซ่อนไว้โดยปริยาย)
async function launch(classicScrollbars) {
  return puppeteer.launch({
    executablePath: CHROME,
    headless: 'new',
    args: ['--no-sandbox'],
    ignoreDefaultArgs: classicScrollbars ? ['--hide-scrollbars'] : [],
  });
}

// เปิดหน้าที่เรนเดอร์แล้วที่ http://localhost/.../__t.html (same-origin ให้ CSS/JS โหลด) และตอบ .php/ajax ด้วย [] เพื่อไม่ให้ยิง DB
async function openPage(browser, html, vp, mobile) {
  const page = await browser.newPage();
  await page.setViewport({ width: vp.w, height: vp.h, isMobile: mobile !== false, hasTouch: mobile !== false, deviceScaleFactor: 1 });
  await page.setRequestInterception(true);
  page.on('request', (r) => {
    const u = r.url();
    if (u === TEST_URL) r.respond({ status: 200, contentType: 'text/html; charset=utf-8', body: html });
    else if (/\.php(\?|$)/.test(u) && u.startsWith(BASE_URL)) r.respond({ status: 200, contentType: 'application/json', body: '[]' });
    else r.continue();
  });
  page.on('pageerror', () => {});
  await page.goto(TEST_URL, { waitUntil: 'load', timeout: 60000 }).catch(() => {});
  await sleep(500);
  return page;
}

// แถวตัวอย่าง (ชื่อไทยยาว ที่อยู่ยาว) ใช้แทนข้อมูลจาก ajax
const CUSTOMERS = [
  { n: 'บริษัท อัลเวลล์ เมดิคอล ซัพพลาย จำกัด (สำนักงานใหญ่)', t: '081-234-5678', a: '99/9 หมู่ 4 ถนนบางนา-ตราด แขวงบางนาเหนือ เขตบางนา กรุงเทพมหานคร 10260' },
  { n: 'โรงพยาบาลสมุทรปราการ', t: '02-123-4567', a: '123 ถนนสุขุมวิท ตำบลปากน้ำ อำเภอเมืองสมุทรปราการ จังหวัดสมุทรปราการ 10270' },
  { n: 'คลินิกหมอสมชาย', t: '089-999-0000', a: '-' },
  { n: 'ห้างหุ้นส่วนจำกัด ศรีสุขเวชภัณฑ์', t: '02-555-0101 ต่อ 123', a: '45/6 ซอยลาดพร้าว 71 แขวงสามเสนนอก เขตห้วยขวาง กรุงเทพมหานคร 10310' },
  { n: 'Siam Healthcare Co., Ltd.', t: '090-111-2222', a: '88 Rama IV Rd., Silom, Bangrak, Bangkok 10500' },
];
const esc = (s) => String(s).replace(/&/g, '&amp;').replace(/</g, '&lt;');
const EDIT = '<img src="img/icons/edit.png" alt="แก้ไข" style="width:18px;height:18px;object-fit:contain;">';

const MOCK = {
  customerPopupRows: () => CUSTOMERS.concat(CUSTOMERS).map((c, i) => `<tr data-index="${i}"><td><button type="button" class="customer-popup-name">${esc(c.n)}</button></td><td>${esc(c.t)}</td><td>${esc(c.a)}</td><td><button type="button" class="customer-popup-name">${EDIT}</button></td></tr>`).join(''),
  fullBillPopupRows: () => CUSTOMERS.concat(CUSTOMERS).map((c, i) => `<tr data-index="${i}"><td><button type="button" class="customer-popup-name">${esc(c.n)}</button></td><td>${esc(c.t)}</td><td>${esc(c.n + ' ' + c.a)}</td><td>0105551234567</td><td><button type="button" class="customer-popup-name">${EDIT}</button></td></tr>`).join(''),
  // แถวเครดิตเทอม: 4 รายการ แถวแรกขยาย (มีช่องกรอกการติดตามและปุ่มบันทึก) ตรงกับ markup ของ js/credit-term-modal.js
  creditTermTableBody: () => {
    const prods = 'เครื่องวัดความดันโลหิตดิจิตอล รุ่น BP-200, หน้ากากอนามัยทางการแพทย์ 3 ชั้น (50 ชิ้น/กล่อง)';
    let h = '';
    for (let i = 0; i < 4; i++) {
      const ex = i === 0;
      h += `<tr><td><button type="button" class="credit-term-row-btn ${ex ? 'is-expanded' : ''}"><span class="credit-term-caret"></span></button></td><td>SO2610-00${i + 1}<br><span class="credit-term-track-count">ยังไม่มี</span></td><td>${prods}</td><td>125,400.00</td><td>25,000.00</td><td>100,400.00</td></tr>`;
      if (ex) {
        h += `<tr class="credit-term-subrow"><td colspan="6"><div class="credit-term-inline-panel"><div class="credit-term-inline-summary-row"><div class="credit-term-inline-summary-caret"><span class="credit-term-caret"></span></div><div class="credit-term-inline-summary-cell">SO2610-001</div><div class="credit-term-inline-summary-cell">${prods}</div><div class="credit-term-inline-summary-cell is-number">125,400.00</div><div class="credit-term-inline-summary-cell is-number">25,000.00</div><div class="credit-term-inline-summary-cell is-number">100,400.00</div></div><div class="credit-term-inline-detail"><div class="credit-term-inline-label-row"><p class="credit-term-inline-title">วันที่ติดตาม</p><p class="credit-term-inline-title">การติดตาม</p><p class="credit-term-inline-title">ชื่อผู้ติดตาม</p></div><div class="credit-term-inline-rows"><div class="credit-term-inline-data-row"><div class="credit-term-inline-row-text">10/10/2569</div><div class="credit-term-inline-row-text">โทรตามแล้ว ลูกค้าแจ้งว่าจะโอนภายในสัปดาห์หน้า</div><div class="credit-term-inline-row-text">สมหญิง</div></div></div><div class="credit-term-inline-compose-row"><div></div><div class="credit-term-inline-compose-field"><div class="credit-term-inline-input-shell"><input type="text" class="credit-term-textarea credit-term-inline-input" placeholder="กรอกข้อมูลการติดตาม"></div></div><div class="credit-term-actions"><button type="button" class="credit-term-save-btn">บันทึก</button></div></div></div></div></td></tr>`;
      }
    }
    return h;
  },
};

module.exports = { VIEWPORTS, OUT, BASE_URL, MOCK, launch, openPage, renderPage, sleep };
