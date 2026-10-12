// ตรวจการล็อก scroll หลัง modal: ล้อเมาส์เหนือส่วนหัว/ปุ่มท้าย/พื้นหลัง/ตาราง หน้าหลังต้องไม่ขยับ, หน้าไม่ขยับตอนเปิด-ปิด (ชดเชย scrollbar),
// เปิดซ้อนหลาย modal, SweetAlert ทับ modal
// ใช้: node check-scroll-lock.js register_suphos [modalId]   (modalId ค่าเริ่มต้น = modal แรกที่เจอ)
// exit code 1 ถ้าพบ ISSUE
const { launch, openPage, renderPage, sleep } = require('./lib');

const name = process.argv[2];
const modalId = process.argv[3] || '';
if (!name) {
  console.error('usage: node check-scroll-lock.js <page> [modalId]');
  process.exit(2);
}
let issues = 0;
const check = (ok, msg) => { if (!ok) issues++; console.log(`${ok ? 'ok   ' : 'ISSUE'} ${msg}`); };

// เติมแถวยาว ๆ ให้ตารางมีที่เลื่อน
const FILL = Array.from({ length: 30 }, (_, i) => `<tr><td>ลูกค้า ${i}</td><td>081-000-00${i}</td><td>ที่อยู่ ${i}</td><td></td></tr>`).join('');

async function wheelTest(page, label, point, dy) {
  await page.mouse.move(point[0], point[1]);
  const before = await page.evaluate(() => Math.round(scrollY));
  await page.mouse.wheel({ deltaY: dy });
  await sleep(300);
  const after = await page.evaluate(() => Math.round(scrollY));
  check(before === after, `ล้อเมาส์ ${label}: หน้าหลัง ${before} -> ${after}`);
}

(async () => {
  const html = renderPage(name, process.env.ROLE);

  // ส่วนที่ 1: ล้อเมาส์ + modal ซ้อน + SweetAlert (เดสก์ท็อป 1180x820)
  let browser = await launch(false);
  let page = await openPage(browser, html, { w: 1180, h: 820 }, false);
  const sel = await page.evaluate((id) => {
    const m = id ? document.getElementById(id) : document.querySelector('.customer-popup-modal, [data-so-modal-lock]');
    if (!m) return null;
    m.style.display = 'flex';
    scrollTo(0, 300);
    return m.id;
  }, modalId);
  if (!sel) { console.log('ไม่พบ modal ที่จะทดสอบ'); process.exit(2); }
  console.log('modal ที่ทดสอบ:', sel, '| ระบบจะเติมแถวตัวอย่างลงตาราง');
  await page.evaluate((id, fill) => { const m = document.getElementById(id); const tb = m.querySelector('tbody'); if (tb) tb.innerHTML = fill; }, sel, FILL);
  await sleep(300);
  check(await page.evaluate(() => document.documentElement.classList.contains('so-modal-open')), 'เปิด modal แล้ว <html> มีคลาส so-modal-open');
  for (const t of [
    { label: 'บนตาราง', q: '.customer-popup-table-wrap, .credit-term-table-wrap, table', dy: 200 },
    { label: 'ส่วนหัว', q: '.clear-loan-header, .customer-popup-header, h2', dy: -200 },
    { label: 'ปุ่มท้าย', q: '.customer-popup-actions', dy: 300 },
  ]) {
    const p = await page.evaluate((q, id) => { const e = document.getElementById(id).querySelector(q); if (!e) return null; const r = e.getBoundingClientRect(); return [r.left + r.width / 2, r.top + r.height / 2]; }, t.q, sel);
    if (p) await wheelTest(page, t.label, p, t.dy); else console.log(`ข้าม ${t.label}: modal นี้ไม่มี ${t.q}`);
  }
  await wheelTest(page, 'พื้นหลังสีเทา', [4, 400], 300);

  // ซ้อน: เปิดอีกตัวแล้วปิดตัวแรก ต้องยังล็อกอยู่
  const second = await page.evaluate((id) => {
    const o = [...document.querySelectorAll('.customer-popup-modal, [data-so-modal-lock]')].find((e) => e.id && e.id !== id);
    if (!o) return null; o.style.display = 'flex'; document.getElementById(id).style.display = 'none'; return o.id;
  }, sel);
  if (second) {
    await sleep(200);
    check(await page.evaluate(() => document.documentElement.classList.contains('so-modal-open')), `ซ้อน: ปิด ${sel} แต่ ${second} ยังเปิด -> ยังล็อก`);
    const sw = await page.evaluate(async () => {
      if (typeof Swal === 'undefined') return null;
      Swal.fire('t', 'x'); await new Promise((r) => setTimeout(r, 400)); Swal.close(); await new Promise((r) => setTimeout(r, 500));
      return document.documentElement.classList.contains('so-modal-open');
    });
    if (sw !== null) check(sw === true, 'SweetAlert เด้งทับ modal แล้วปิด ไม่ทำให้ล็อกหลุด');
    await page.evaluate((id) => { document.getElementById(id).style.display = 'none'; }, second);
  } else {
    await page.evaluate((id) => { document.getElementById(id).style.display = 'none'; }, sel);
  }
  await sleep(200);
  check(await page.evaluate(() => !document.documentElement.classList.contains('so-modal-open')), 'ปิด modal หมดแล้วปลดล็อก (ไม่มีคลาส so-modal-open)');
  await page.mouse.move(400, 400);
  const b = await page.evaluate(() => Math.round(scrollY));
  await page.mouse.wheel({ deltaY: 300 }); await sleep(300);
  check(b !== await page.evaluate(() => Math.round(scrollY)), 'หลังปิด modal หน้าเลื่อนได้ตามปกติ');
  await browser.close();

  // ส่วนที่ 2: scrollbar แบบ Windows ต้องไม่ทำให้หน้าขยับตอนเปิด modal
  browser = await launch(true);
  page = await openPage(browser, html, { w: 1280, h: 800 }, false);
  const geo = () => page.evaluate(() => {
    const r = (s) => { const e = document.querySelector(s); if (!e) return null; const b = e.getBoundingClientRect(); return Math.round(b.left * 10) / 10 + '..' + Math.round(b.right * 10) / 10; };
    return { scrollbar: innerWidth - document.documentElement.clientWidth, content: r('form .so-card') || r('main') || r('form'), navbar: r('#top-navbar'), navUser: r('#top-navbar .navbar-user-btn') };
  });
  await page.evaluate(() => scrollTo(0, 300));
  const closed = await geo();
  await page.evaluate((id) => { document.getElementById(id).style.display = 'flex'; }, sel);
  await sleep(250);
  const open = await geo();
  console.log(`scrollbar ปิด=${closed.scrollbar}px เปิด=${open.scrollbar}px`);
  if (closed.scrollbar === 0) console.log('warn  เบราว์เซอร์นี้ไม่มี scrollbar แบบกินที่ ข้ามการตรวจชดเชย');
  else {
    check(closed.content === open.content, `เนื้อหาไม่ขยับตอนเปิด modal (${closed.content} / ${open.content})`);
    check(closed.navbar === open.navbar && closed.navUser === open.navUser, `navbar ไม่ขยับตอนเปิด modal (${closed.navUser} / ${open.navUser})`);
  }
  await browser.close();
  console.log(issues ? `\nพบ ISSUE ${issues} จุด` : '\nผ่านทั้งหมด');
  process.exit(issues ? 1 : 0);
})();
