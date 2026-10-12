// ตรวจ modal ของหน้าที่ระบุบน iPad หลายขนาด: โดนบัง, ติดใน sticky bar/stacking context, ตารางล้น, ปุ่มบันทึกเครดิตเทอมหลุดขอบ, ปุ่มเล็กกว่า 44px
// ใช้: node check-modals.js register_supbook register_supchange   (ชื่อหน้าไม่ต้องมี .php)
//   ตัวเลือก: ROLE=admin  RERENDER=1 (เรนเดอร์ใหม่)  VPS=air-p,air-l (จำกัดขนาด)  JSON=1 (พิมพ์ JSON)
// exit code 1 ถ้าพบ ISSUE (WARN ไม่นับ)
const fs = require('fs');
const path = require('path');
const { VIEWPORTS, OUT, MOCK, launch, openPage, renderPage, sleep } = require('./lib');

const pages = process.argv.slice(2);
if (!pages.length) {
  console.error('usage: node check-modals.js <page> [page...]');
  process.exit(2);
}
const only = (process.env.VPS || '').split(',').filter(Boolean);
const vps = VIEWPORTS.filter((v) => !only.length || only.includes(v.id));

// ทำงานในหน้า: เปิด modal ทีละตัวแล้ววัด (ส่งเข้า page.evaluate)
function inPage(mock) {
  const vw = innerWidth, vh = innerHeight;
  const bars = [...document.querySelectorAll('.so-sticky-actions')];
  const cands = [...document.querySelectorAll('.customer-popup-modal, [data-so-modal-lock], [id$="modal" i], [id$="popup" i]')]
    .filter((e) => getComputedStyle(e).position === 'fixed');
  for (const id of Object.keys(mock)) { const tb = document.getElementById(id); if (tb) tb.innerHTML = mock[id]; }
  const out = [];
  for (const m of new Set(cands)) {
    m.style.display = 'flex';
    const box = m.querySelector('[role=dialog]') || m.firstElementChild;
    const r = box.getBoundingClientRect();
    const hit = (x, y) => { const e = document.elementFromPoint(Math.max(0, Math.min(vw - 1, x)), Math.max(0, Math.min(vh - 1, y))); return !!(e && m.contains(e)); };
    const close = m.querySelector('.customer-popup-close, .closeX, .cshos-popup-close, [aria-label=Close], button[class*=close]');
    const cr = close ? close.getBoundingClientRect() : null;
    let trap = null;
    for (let e = m.parentElement; e && e !== document.documentElement; e = e.parentElement) {
      const cs = getComputedStyle(e);
      if ((cs.position !== 'static' && cs.zIndex !== 'auto') || cs.transform !== 'none' || cs.filter !== 'none' || (cs.contain && cs.contain !== 'none')) { trap = e.tagName + '.' + String(e.className).split(' ')[0] + ' z=' + cs.zIndex; break; }
    }
    const tables = [...m.querySelectorAll('table')].map((t) => {
      let sc = t.parentElement;
      while (sc && sc !== m && !/(auto|scroll)/.test(getComputedStyle(sc).overflowX)) sc = sc.parentElement;
      sc = sc && sc !== m ? sc : t.parentElement;
      return { cls: String(t.className).split(' ')[0] || 'table', minW: getComputedStyle(t).minWidth, over: Math.max(0, sc.scrollWidth - sc.clientWidth), rows: t.querySelectorAll('tbody tr').length };
    }).filter((t) => t.rows > 0);
    const sv = m.querySelector('.credit-term-save-btn');
    const wrap = m.querySelector('.credit-term-table-wrap');
    const svr = sv ? sv.getBoundingClientRect() : null, wr = wrap ? wrap.getBoundingClientRect() : null;
    const tiny = [];
    m.querySelectorAll('button').forEach((b) => {
      const br = b.getBoundingClientRect();
      if (!br.width || (b.classList.contains('customer-popup-name') && !b.querySelector('img'))) return;
      if (br.width < 43.5 || br.height < 43.5) tiny.push((String(b.className).split(' ')[0] || 'button') + ' ' + Math.round(br.width) + 'x' + Math.round(br.height));
    });
    out.push({
      id: m.id || String(m.className).split(' ')[0],
      inSticky: bars.some((b) => b.contains(m)),
      trap,
      covered: !(hit(r.left + r.width / 2, r.top + 4) && hit(r.left + 30, r.top + r.height / 2)),
      closeCovered: cr ? !hit(cr.left + cr.width / 2, cr.top + cr.height / 2) : null,
      boxFits: r.left >= 0 && r.right <= vw + 0.5 && r.top >= 0 && r.bottom <= vh + 0.5,
      tables,
      saveHiddenX: svr && wr ? Math.max(0, Math.round(svr.right - wr.right)) : null,
      saveBelowWrap: svr && wr ? Math.round(svr.bottom - wr.bottom) : null,
      tiny: [...new Set(tiny)].slice(0, 6),
    });
    m.style.display = 'none';
  }
  return out;
}

(async () => {
  const browser = await launch(false);
  const report = [];
  let issues = 0;
  for (const name of pages) {
    let html;
    try { html = renderPage(name, process.env.ROLE); } catch (e) { console.log(`\n${name}: render ล้มเหลว (${String(e.message).split('\n')[0]})`); report.push({ page: name, error: 'render' }); issues++; continue; }
    if (!/modal/i.test(html)) { console.log(`\n${name}: ไม่มี modal ในผลเรนเดอร์ (${html.length} bytes) อาจถูกปฏิเสธสิทธิ์หรือต้องมี query string`); report.push({ page: name, error: 'no modal' }); continue; }
    console.log('\n' + name);
    for (const vp of vps) {
      const page = await openPage(browser, html, vp, true);
      const res = await page.evaluate(inPage, Object.fromEntries(Object.entries(MOCK).map(([k, f]) => [k, f()])));
      await page.close();
      for (const m of res) {
        const bad = [], warn = [];
        if (m.inSticky) bad.push('modal อยู่ใน .so-sticky-actions (div ไม่ปิด?)');
        if (m.trap) warn.push('อยู่ใต้ stacking context ' + m.trap);
        if (m.covered) bad.push('ถูก navbar/sidebar บัง');
        if (m.closeCovered) bad.push('ปุ่ม × ถูกบัง');
        if (!m.boxFits) bad.push('กล่องล้นจอ');
        for (const t of m.tables) if (t.over > 0) bad.push(`ตาราง ${t.cls} ล้น ${t.over}px (min-width ${t.minW})`);
        if (m.saveHiddenX) bad.push(`ปุ่มบันทึกเครดิตเทอมล้นขอบ ${m.saveHiddenX}px`);
        if (m.saveBelowWrap > 0) warn.push(`ปุ่มบันทึกอยู่ใต้กรอบเลื่อน ${m.saveBelowWrap}px (ต้องเลื่อนในกรอบ)`);
        if (m.tiny.length) warn.push('ปุ่มเล็กกว่า 44px: ' + m.tiny.join(', '));
        issues += bad.length;
        report.push({ page: name, vp: vp.id, modal: m.id, bad, warn });
        if (bad.length || warn.length) console.log(`  ${vp.id.padEnd(8)} ${m.id.padEnd(26)} ${bad.map((x) => 'ISSUE ' + x).concat(warn.map((x) => 'warn  ' + x)).join(' | ')}`);
      }
    }
  }
  await browser.close();
  fs.mkdirSync(OUT, { recursive: true });
  fs.writeFileSync(path.join(OUT, 'report.json'), JSON.stringify(report, null, 1));
  console.log(`\nรวม ISSUE ${issues} จุด (รายละเอียดเต็มที่ out/report.json)`);
  process.exit(issues ? 1 : 0);
})();
