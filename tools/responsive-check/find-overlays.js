// หา overlay position:fixed ขนาดเต็มจอในหน้าที่ระบุ และบอกว่าล็อก scroll (js/so-modal-scroll-lock.js) จับอัตโนมัติหรือต้องใส่ data-so-modal-lock
// ใช้: node find-overlays.js register_supbook status_admin   (RERENDER=1 เรนเดอร์ใหม่)
const lib = require('./lib');
const fs = require('fs');
const pages = process.argv.slice(2);
(async () => {
  const browser = await lib.launch(false);
  const out = [];
  for (const name of pages) {
    let html;
    try { html = lib.renderPage(name, 'admin'); } catch (e) { out.push({ page: name, error: 'render fail' }); continue; }
    const page = await lib.openPage(browser, html, { w: 820, h: 1180 }, true);
    const res = await page.evaluate(() => {
      const vw = innerWidth, vh = innerHeight;
      const skip = /^(top-navbar|sidebar|sidebar-backdrop)$/;
      const found = [];
      const hasLock = !!window.soSyncModalScrollLock;
      for (const e of document.querySelectorAll('body *')) {
        if (e.closest('.swal2-container')) continue;
        const cs = getComputedStyle(e);
        if (cs.position !== 'fixed') continue;
        if (skip.test(e.id) || /sidebar|navbar|swal2/.test(String(e.className))) continue;
        const wasNone = cs.display === 'none';
        const inlineNone = e.style.display === 'none';
        let r;
        if (wasNone) { const prev = e.getAttribute('style'); e.style.setProperty('display', 'flex', 'important'); r = e.getBoundingClientRect(); if (prev === null) e.removeAttribute('style'); else e.setAttribute('style', prev); }
        else r = e.getBoundingClientRect();
        if (!(r.width >= vw * 0.85 && r.height >= vh * 0.85)) continue;
        found.push({ auto: e.matches('.customer-popup-modal, #overLimitModal, [data-so-modal-lock]'), id: e.id || '', cls: String(e.className).split(' ').slice(0, 2).join('.'), hiddenBy: wasNone ? (inlineNone ? 'style' : 'class/css') : 'visible-at-load(' + cs.visibility + '/op' + cs.opacity + ')', inSticky: !!e.closest('.so-sticky-actions') });
      }
      const hasIpadCss = [...document.querySelectorAll('link[rel=stylesheet]')].some((l) => /so-modal-ipad/.test(l.href));
      return { found, hasLockJs: hasLock, hasIpadCss, bodyScrollable: document.documentElement.scrollHeight > vh };
    });
    await page.close();
    out.push({ page: name, ...res });
  }
  await browser.close();
  for (const o of out) {
    if (o.error) { console.log(o.page.padEnd(32), 'ERR', o.error); continue; }
    const open = o.found.filter((f) => !f.auto);
    const status = !o.found.length ? 'NO-MODAL' : (o.hasLockJs && o.hasIpadCss && !open.length) ? 'DONE' : 'TODO';
    if (process.env.SUMMARY === '1') {
      console.log(status.padEnd(9), o.page.padEnd(32), `modals=${o.found.length} js=${o.hasLockJs ? 'y' : 'n'} css=${o.hasIpadCss ? 'y' : 'n'}`, open.length ? 'ต้องใส่ attr: ' + open.map((f) => f.id || f.cls).join(', ') : '');
      continue;
    }
    console.log(o.page.padEnd(32), 'overlays=' + o.found.length, 'lockJs=' + o.hasLockJs, 'ipadCss=' + o.hasIpadCss, status);
    for (const f of o.found) console.log('    ', (f.id || f.cls).padEnd(30), f.auto ? 'AUTO ' : 'NEEDS-ATTR', 'hiddenBy:', f.hiddenBy, f.inSticky ? 'IN-STICKY' : '');
  }
})();
