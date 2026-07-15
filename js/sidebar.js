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

		// Move top-level "Setting" group to the bottom of the sidebar navigation list
		var nav = sidebar.querySelector(".sidebar-nav");
		if (nav) {
			var settingGroup = null;
			var children = nav.children;
			for (var i = 0; i < children.length; i++) {
				var label = children[i].querySelector(".sidebar-label");
				if (label && label.textContent.trim() === "Setting") {
					settingGroup = children[i];
					break;
				}
			}
			if (settingGroup) {
				nav.appendChild(settingGroup);
			}
		}

		var COLLAPSE_KEY = "sidebar_collapsed";
		var OPEN_GROUPS_KEY = "sidebar_open_groups";

		// ---- navbar hamburger toggle (collapses on desktop, opens drawer on mobile) ----
		var navbarHamburger = document.getElementById("navbar-hamburger");
		var collapsed = localStorage.getItem(COLLAPSE_KEY) === "1";
		if (collapsed) {
			sidebar.classList.add("sidebar-collapsed");
			body.classList.add("sidebar-collapsed");
		}
		if (navbarHamburger) {
			navbarHamburger.addEventListener("click", function (e) {
				e.stopPropagation();
				if (window.innerWidth <= 768) {
					sidebar.classList.toggle("sidebar-mobile-open");
				} else {
					var isCollapsed = sidebar.classList.toggle("sidebar-collapsed");
					body.classList.toggle("sidebar-collapsed", isCollapsed);
					localStorage.setItem(COLLAPSE_KEY, isCollapsed ? "1" : "0");
				}
			});
		}

		document.addEventListener("click", function (e) {
			if (window.innerWidth > 768) return;
			if (!sidebar.classList.contains("sidebar-mobile-open")) return;
			if (sidebar.contains(e.target) || (navbarHamburger && navbarHamburger.contains(e.target))) return;
			sidebar.classList.remove("sidebar-mobile-open");
		});

		// ---- accordion groups (top-level + nested subgroups) ----
		var openGroups = [];
		try {
			openGroups = JSON.parse(localStorage.getItem(OPEN_GROUPS_KEY) || "[]");
		} catch (e) {
			openGroups = [];
		}

		function persistOpenGroups() {
			var ids = [];
			sidebar.querySelectorAll(".sidebar-group.open, .sidebar-subgroup.open").forEach(function (el) {
				if (el.dataset.groupId) ids.push(el.dataset.groupId);
			});
			localStorage.setItem(OPEN_GROUPS_KEY, JSON.stringify(ids));
		}

		function bindGroup(selectorBtn, itemSelector) {
			sidebar.querySelectorAll(itemSelector).forEach(function (group, idx) {
				if (!group.dataset.groupId) {
					group.dataset.groupId = itemSelector + "-" + idx;
				}
				var btn = group.querySelector(":scope > " + selectorBtn);
				if (!btn) return;
				if (openGroups.indexOf(group.dataset.groupId) !== -1) {
					group.classList.add("open");
				}
				btn.addEventListener("click", function (e) {
					e.preventDefault();
					group.classList.toggle("open");
					persistOpenGroups();
				});
			});
		}

		bindGroup(".sidebar-group-btn", ".sidebar-group");
		bindGroup(".sidebar-subgroup-btn", ".sidebar-subgroup");

		// ---- user menu dropdown (top navbar) ----
		var navbarUserTrigger = document.getElementById("navbar-user-trigger");
		var navbarUserDropdown = document.getElementById("navbar-user-dropdown");
		if (navbarUserTrigger && navbarUserDropdown) {
			navbarUserTrigger.addEventListener("click", function (e) {
				e.stopPropagation();
				navbarUserDropdown.classList.toggle("open");
				var caret = navbarUserTrigger.querySelector(".navbar-caret");
				if (caret) {
					caret.classList.toggle("fa-angle-up");
					caret.classList.toggle("fa-angle-down");
				}
			});
			document.addEventListener("click", function (e) {
				if (!navbarUserTrigger.contains(e.target) && !navbarUserDropdown.contains(e.target)) {
					navbarUserDropdown.classList.remove("open");
					var caret = navbarUserTrigger.querySelector(".navbar-caret");
					if (caret) {
						caret.classList.remove("fa-angle-up");
						caret.classList.add("fa-angle-down");
					}
				}
			});
		}

		// ---- active link + auto-expand ancestors ----
		var currentPath = location.pathname.split("/").pop();
		if (currentPath) {
			var links = sidebar.querySelectorAll("a[href]");
			links.forEach(function (a) {
				var href = a.getAttribute("href");
				if (!href) return;
				var hrefFile = href.split("?")[0].split("/").pop();
				if (hrefFile && hrefFile === currentPath) {
					a.classList.add("active");
					var parentGroup = a.closest(".sidebar-group, .sidebar-subgroup");
					while (parentGroup) {
						parentGroup.classList.add("open");
						parentGroup = parentGroup.parentElement
							? parentGroup.parentElement.closest(".sidebar-group, .sidebar-subgroup")
							: null;
					}
				}
			});
		}
	});
})();
