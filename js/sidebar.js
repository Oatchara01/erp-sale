// ===== Shared Sidebar behaviour (all roles) =====
(function () {
	"use strict";

	function ready(fn) {
		if (document.readyState !== "loading") fn();
		else document.addEventListener("DOMContentLoaded", fn);
	}

	ready(function () {
		var sidebar = document.getElementById("sidebar");
		if (!sidebar) return;

		var body = document.body;
		body.classList.add("has-sidebar");

		var COLLAPSE_KEY = "sidebar_collapsed";
		// Must match the drawer breakpoint in css/sidebar.css (@media max-width: 1024px):
		// below it the sidebar is off-canvas, so the hamburger has to open the drawer, not collapse it.
		var DRAWER_MAX_WIDTH = 1024;

		// ---- navbar hamburger toggle (collapses on desktop, opens drawer on mobile) ----
		var navbarHamburger = document.getElementById("navbar-hamburger");

		// The collapsed (72px icon rail) state only exists on desktop. In drawer mode the saved
		// preference must not apply, otherwise the drawer opens as an unusable 72px strip.
		var drawerQuery = window.matchMedia("(max-width: " + DRAWER_MAX_WIDTH + "px)");

		// Dim layer behind the open drawer (styled in css/sidebar.css, only visible in drawer mode)
		var backdrop = document.createElement("div");
		backdrop.className = "sidebar-backdrop";
		body.appendChild(backdrop);

		function syncHamburger() {
			if (!navbarHamburger) return;
			var expanded = drawerQuery.matches
				? sidebar.classList.contains("sidebar-mobile-open")
				: !sidebar.classList.contains("sidebar-collapsed");
			navbarHamburger.setAttribute("aria-expanded", expanded ? "true" : "false");
		}
		function setCollapsed(on) {
			sidebar.classList.toggle("sidebar-collapsed", on);
			body.classList.toggle("sidebar-collapsed", on);
			syncHamburger();
		}
		function setDrawer(open) {
			sidebar.classList.toggle("sidebar-mobile-open", open);
			body.classList.toggle("sidebar-drawer-open", open);
			syncHamburger();
			// scroll the menu so the current page's link is visible (defined in menu_all.php)
			if (open && window.sidebarScrollToActive) window.sidebarScrollToActive();
		}
		function applyMode() {
			setCollapsed(!drawerQuery.matches && localStorage.getItem(COLLAPSE_KEY) === "1");
			// crossing the breakpoint (resize, tablet rotation) must not leave a drawer open
			setDrawer(false);
		}
		applyMode();
		if (drawerQuery.addEventListener) {
			drawerQuery.addEventListener("change", applyMode);
		} else if (drawerQuery.addListener) {
			drawerQuery.addListener(applyMode);
		}

		// Icon rail: a group cannot show its submenu in 72px, so clicking a group expands
		// the sidebar and opens that group instead of toggling it invisibly.
		sidebar.addEventListener("click", function (e) {
			if (!sidebar.classList.contains("sidebar-collapsed")) return;
			var btn = e.target.closest(".sidebar-group-btn");
			if (!btn || !sidebar.contains(btn) || !btn.querySelector(".sidebar-caret")) return;
			e.preventDefault();
			e.stopPropagation();
			setCollapsed(false);
			localStorage.setItem(COLLAPSE_KEY, "0");
			if (btn.parentElement) btn.parentElement.classList.add("sidebar-open");
		}, true);

		// Desktop: clicking a menu link collapses the sidebar. Pages are full reloads, so the state is
		// saved the same way as the hamburger (COLLAPSE_KEY) and the next page loads already collapsed.
		// Links that do not replace this page (new tab, Ctrl/Cmd/Shift click, download, other origin,
		// "#" or javascript:) keep the sidebar as it is. Group buttons are <button>s, not links.
		sidebar.addEventListener("click", function (e) {
			if (e.defaultPrevented || drawerQuery.matches) return;
			var link = e.target.closest("a[href]");
			if (!link || !sidebar.contains(link)) return;
			if (e.button !== 0 || e.ctrlKey || e.metaKey || e.shiftKey || e.altKey) return;
			if (link.hasAttribute("download")) return;
			if (link.target && link.target !== "_self") return;
			var href = link.getAttribute("href");
			if (!href || href.charAt(0) === "#" || /^javascript:/i.test(href)) return;
			if (link.origin !== window.location.origin) return;
			setCollapsed(true);
			localStorage.setItem(COLLAPSE_KEY, "1");
		});

		// The rail shows icons only, so give each top-level button its name as a tooltip.
		sidebar.querySelectorAll(".sidebar-group-btn").forEach(function (btn) {
			var label = btn.querySelector(".sidebar-label");
			if (label && !btn.getAttribute("title")) {
				btn.setAttribute("title", label.textContent.replace(/\s+/g, " ").trim());
			}
		});

		if (navbarHamburger) {
			navbarHamburger.addEventListener("click", function (e) {
				e.stopPropagation();
				if (drawerQuery.matches) {
					setDrawer(!sidebar.classList.contains("sidebar-mobile-open"));
				} else {
					var isCollapsed = !sidebar.classList.contains("sidebar-collapsed");
					setCollapsed(isCollapsed);
					localStorage.setItem(COLLAPSE_KEY, isCollapsed ? "1" : "0");
				}
			});
		}

		document.addEventListener("click", function (e) {
			if (!drawerQuery.matches) return;
			if (!sidebar.classList.contains("sidebar-mobile-open")) return;
			if (sidebar.contains(e.target) || (navbarHamburger && navbarHamburger.contains(e.target))) return;
			setDrawer(false);
		});

		// Esc closes the drawer and returns focus to the hamburger
		document.addEventListener("keydown", function (e) {
			if (e.key !== "Escape" || !drawerQuery.matches) return;
			if (!sidebar.classList.contains("sidebar-mobile-open")) return;
			setDrawer(false);
			if (navbarHamburger) navbarHamburger.focus();
		});

		// Group open/close state (.sidebar-open) and the current-page highlight (.sidebar-active)
		// are handled in menu_all.php. This file only owns collapse, drawer and the user dropdown.

		// ---- user menu dropdown (top navbar) ----
		var navbarUserTrigger = document.getElementById("navbar-user-trigger");
		var navbarUserDropdown = document.getElementById("navbar-user-dropdown");
		if (navbarUserTrigger && navbarUserDropdown) {
			navbarUserTrigger.addEventListener("click", function (e) {
				e.stopPropagation();
				var isOpen = navbarUserDropdown.classList.toggle("open");
				var caret = navbarUserTrigger.querySelector(".navbar-caret");
				if (caret) {
					caret.classList.toggle("open", isOpen);
				}
			});
			document.addEventListener("click", function (e) {
				if (!navbarUserTrigger.contains(e.target) && !navbarUserDropdown.contains(e.target)) {
					navbarUserDropdown.classList.remove("open");
					var caret = navbarUserTrigger.querySelector(".navbar-caret");
					if (caret) {
						caret.classList.remove("open");
					}
				}
			});
		}
	});
})();
