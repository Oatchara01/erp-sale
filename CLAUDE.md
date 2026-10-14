# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this is

ERPSALE is a native procedural PHP ERP for a medical-product distributor (two companies: AWL = AllWell, NBM). It handles sales documents (sale order, PO, borrow, sample, rental, return, credit note), their approval routing, printable forms, and marketplace integrations (Lazada, Shopee, TikTok, Line Notify). UI text, SweetAlert2 messages and most business-rule comments are in Thai and must stay in Thai.

There is no framework, router, build step, linter or test suite. Every root `.php` file is a page or endpoint hit directly by URL. The root holds ~2,400 PHP files; many are dead legacy copies (`*_old.php`, `*_bk.php`, `*1_13.php`, numbered variants).

## Commands

PHP is not on PATH. Use the Laragon binary: `/c/laragon/bin/php/php-8.3.30-Win32-vs16-x64/php.exe` (written `php` below). The app is served by Laragon at `http://localhost/erpsale/`.

```bash
php -l register_suphos.php                 # syntax check — the only static check available
php migrate.php status|dry-run|up|down     # schema migrations (prints the target DB name first)

# Render a page to HTML without a browser login (fake session, GET only)
php tools/responsive-check/render-page.php register_supbook.php [type_login] [query-string]
#   -> tools/responsive-check/out/pg_<page>.html

# iPad modal layout checks (headless Chrome via puppeteer-core)
cd tools/responsive-check && npm run check    # check-modals.js
cd tools/responsive-check && npm run lock     # check-scroll-lock.js
```

Verification is otherwise manual in the browser. Say so when a change has only been syntax-checked or CLI-rendered.

## Databases — do not cross connections

Connection files are gitignored (`dbconnect*.php`, `configDB*.php`; copy from `*.example`). Each one defines a differently named global, and several databases contain tables with the same name but different columns.

| Include | Variable | Database |
|---|---|---|
| `dbconnect.php` | `$conn` (also `$new` = stock DB) | main sales DB `allwell_sol_test` |
| `dbconnect_sale.php` | `$com` | `sale` |
| `dbconnect_cs.php` | `$com1` | CS job book (`allwell_cs` local, `allwell_cs_test` prod) |
| `dbconnect_acc.php` | `$code` | accounting `invoice_receipt` |
| `dbconnect_inter.php` | `$inter` | inter DB |
| `dbconnect_service.php` | `$conn` | service-engineer DB — **overwrites `$conn`** |
| `configDB.php` / `configDBsp.php` | `OpenCon()` | `allwell_sol` |

- The local and production main DBs are **both named `allwell_sol_test`**. Check the host in the connection file, never the DB name, before running anything that writes.
- `tb_register_data` / `tb_transaction` exist in both the sales DB (delivery info keyed by `ref_id`) and the CS DB (the job tickets CS staff actually see, keyed by `running`). Job tickets must be written through `$com1`.
- `docs/DATABASE_RULES.md` has an older, partly wrong mapping for `dbconnect_cs.php`; the table above reflects the real files.
- Table prefixes: `hos__*` (double underscore) for documents — header `hos__so` + lines `hos__subso`, same pairing for `po`, `br`, `smp`, `rental`, `consig`, `change`, `receive`, `proreceive`, `jongproduct`; `in__br` for engineer borrow; `tb_*` for master/general data.

### Schema changes

- New changes go in `sql/migrations/YYYYMMDDHHMM_name.up.sql` + matching `.down.sql`, run by `migrate.php` (CLI or browser), tracked in `schema_migrations`. `up` must be re-runnable (check `information_schema` first); no `DELIMITER`. A `-- @connection: acc` or `-- @connection: cs` line targets the accounting/CS DB instead. Rules: `sql/migrations/README.md`.
- Older loose `sql/*.sql` files are run by hand in phpMyAdmin. Production SQL is run by the user, never by an agent.

## Request flow and auth

- `index.php` → `check_login.php` sets `$_SESSION` (`UserID`, `name`, `code`, `type_login`, `department`, …) and redirects by `type_login` to a `main_*.php` landing page (`Admin`, `It`, `Sale`, `Sup_Sale`, `AllWell`, `Sup_AllWell`, `Engineer`, `Admin_hos`, `Stock`, `RPA`, …). `menu_*.php` are the per-role sidebars.
- `head.php` is both the shared `<head>`/assets **and** the login gate. Every page includes it first. JSON endpoints instead do `session_start()` + a `$_SESSION['UserID']` check themselves.
- Permission checks are inline comparisons on `$_SESSION['type_login']` / `$_SESSION['code']`, sometimes on a specific approver's name.

## File families (name prefix = role)

| Pattern | Role |
|---|---|
| `register_<mod>.php` | Form page (create + edit via `?ref_id=`) |
| `register_<mod>1.php` / `_edit1.php` | POST handlers for create / update |
| `register_<mod>_draft1.php` | Draft save, JSON response, no validation |
| `status_<mod>*.php` | List / approval-queue pages |
| `main_*.php`, `menu_*.php` | Landing pages and sidebars per role |
| `<mod>_approve.php`, `<mod>_rejected.php`, `send_*.php` | Single-purpose state transitions |
| `data_*.php` | Legacy AJAX: pipe-delimited positional string, read via raw XHR |
| `ajax_*.php` | Newer AJAX: JSON, session check, prepared statements |
| `report_*.php` | Printable forms (TCPDF/HTML); `_preview_helper.php` renders from POST without saving |

`data_*` responses are positional: append new fields at the end and comment the index. Never convert an endpoint between pipe and JSON formats.

## Two generations of code

Most document modules exist twice. Before editing, confirm which one the list page links to.

- **Redesigned pages** (the ones under active work): one `register_<mod>.php` serves create and edit, styled with `.so-*` classes, built from `partials/` and backed by an `includes/*_repo.php` persistence layer written with prepared statements, transactions and named locks.
- **Legacy pages** (`register_admin*`, `register_allwell*`, `*_edit.php`, `*_createnew.php`, `status_admin*`): string-concatenated SQL, still live and still reading the same tables. Leave them alone unless asked, but keep the columns and status values they depend on intact.

Current redesigned entry points:

| Document | Form page | Tables | Persistence |
|---|---|---|---|
| Sale order (SO) | `register_suphos.php` | `hos__so` / `hos__subso` | inline in `register_suphos1.php`, `_edit1.php`, `_draft1.php` |
| Purchase order (PO) | `register_poawl.php` | `hos__po` / `hos__subpo` | `includes/po_repo.php` via `register_posave1.php` |
| Borrow (BR) | `register_supbrhos.php` | `hos__br` / `hos__subbr` | inline in `register_supbrhos1.php`, `_edit1.php`, `_draft1.php` |
| Consignment borrow (BRCS) | `register_supbrcshos.php` | `hos__consig` / `hos__subconsig` | inline handlers |
| Sample / sales support (SMP) | `register_supsmp.php` | `hos__smp` / `hos__subsmp` | `includes/smp_repo.php` |
| Rental | `register_suprental.php` | `hos__rental` / `hos__subrental` | inline handlers + `includes/rental_so_sync.php` |
| Product exchange | `register_supchange.php` | `hos__change` / `hos__subchange` | inline handlers |
| Reservation (ใบจอง) | `register_supbook.php` | `hos__jongproduct` / `hos__subjongpro` | inline + `includes/jong_repo.php` (balance, close/reopen) |
| Return (ใบคืน) | `register_receive.php` | `hos__receive` / `hos__subreceive` | `includes/receive_repo.php` |
| Delivery note (ใบส่งสินค้า) | `register_receivepro.php` | `hos__proreceive` / `hos__subproreceive` | `includes/receivepro_repo.php` |
| Engineer borrow (BREQ) | `register_breng_brgq.php` | `in__br` / `in__subbr` (`type_breng = 2`) | `includes/breq_repo.php` |
| Spare-part request (BREG) | `register_bregawl.php` | `hos__breg` / `hos__subbreg` | `includes/breg_repo.php` |
| Machine/parts issue (SPR) | `register_engspr.php` | `hos__spr` / `hos__subspr` | `includes/spr_repo.php` |
| Credit note | `register_credinot.php` | `tb_credit_note` | inline handlers |

Documents chain into each other (PO → SO via `ref_po`; reservation, borrow and rental → SO; eight source types → return), so a change to one document's columns or statuses usually has readers elsewhere. Grep the table name before changing what a column means.

### Shared building blocks

- `includes/so_saved_helpers.php` — `so_saved_*` helpers for redisplaying saved values; used by every redesigned form.
- `partials/doc_tabs_card.php`, `delivery_info_tab.php`, `admin_info_tab.php` — tab card, delivery tab and admin tab shared across SO/BR/BRCS/rental/exchange/SMP forms.
- `includes/cs_job_send.php` — core of the "ส่งข้อมูลลงระบบ CS" toggle (connect to CS DB, lock, issue job number, write ticket). Per-document wrappers: `so_cs_send.php`, `rental_cs_send.php`, `brcs_cs_send.php`; SMP calls it from `smp_repo.php`. `send_cs`: `0` not sent, `2` sent and locked; `1` must never be stored.
- `includes/po_repo.php` also exports generic helpers (`po_stmt_exec`, named lock, `po_column_exists`, `tb_document_status_log` writer) that `receive_repo.php` and `receivepro_repo.php` reuse.
- `includes/invoice_receipt_sync.php` — the single place that syncs an approved SO into the accounting DB.
- `css/so-core.css`, `so-status-ui.css`, `so-modal-ipad.css`, `so-web-select.css` and `js/doc-tabs-*.js`, `delivery-transport.js`, `customer-popup.js`, `credit-term-modal.js` — shared styling and behaviour of the redesigned pages.

## Document status model

There is no single state machine; each header table carries a status string plus routing flags, and list pages filter on combinations of them.

- Status column: usually `status_doc` (`hos__smp` uses `status_sup`). Values in use: `Draft`, `Request`, `Approve`, `Rejected`, `Returned`, and the Thai literals `ยกเลิก` (cancelled) and `ส่งกลับ` (BR sent back). PO uses `Draft` / `Submitted` / `Returned`. Return and delivery note use numeric `send_stock` / `send_receive` instead of a status string.
- Routing flags (`'0'`/`'1'`) say whose queue the document is in: `send_sup` (supervisor), `send_dm` (department manager), `send_cm` (credit/management), `send_admin`, `send_stock`.
- Line tables carry their own status (`status_so`, `status_smp`, `status_spr`, …) set to `Approve` together with the header.
- Typical path: Draft → submit (`Request`, `send_sup='1'`) → supervisor → optional DM/CM stage depending on amount, payment type or document type → `Approve` with `send_admin='1'` (and `send_stock='1'` where stock must act). Reject → `Rejected`; send back → `Returned`/`ส่งกลับ` with the flags reset to `'0'`.
- A draft and the final document share one row, so transitions must be guarded, e.g. `UPDATE … SET status_doc='Request' WHERE ref_id=? AND status_doc='Draft'`.

Each form has three separate backend targets that must not be merged: final submit (validates, routes, notifies), draft save (no validation by design), and print preview (posts the live form to a `report_*` page with `_report_preview=1` and writes nothing).

## Conventions that are easy to break

- Find the nearest file in the same prefix family and copy its include order, auth pattern and connection variable.
- Reuse `.so-*` classes and W3.CSS; purple `#612989`, `Prompt` font, light mode only. No new component system, no frontend or backend framework.
- `mysqli` only. New code escapes input or uses prepared statements; do not blanket-convert unrelated legacy queries.
- Client-side hidden-field sync functions (`syncFormCompatibilityFields()`, `syncDeptComments()`, `syncDeliveryTimeRange()`) feed the draft-save and preview paths — any new save path must call them, and they must not be removed.
- `SET SESSION sql_mode` relaxation exists only in specific handlers that need it (tables with `NOT NULL` columns and no defaults); keep it scoped there.
- Use SweetAlert2 for dialogs, not `alert()`/`confirm()`.

## Further reading

`docs/` is gitignored and exists only on dev machines; read it when present. Start with `docs/DEVELOPMENT_STANDARD.md`, which indexes the form, API, database, validation and UI rules. Task playbooks: `docs/cs-send-pattern.md` (CS toggle rollout), `docs/so-status-ui.md` (list-page UI kit), `docs/ipad-modal-responsive-pattern.md`, `docs/so-display-text-pattern.md`. Those docs link to `.agents/skills/…`, which may be absent locally.
