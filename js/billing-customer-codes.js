/*
 * รหัสลูกค้า AWL/NBM ของการ์ดออกบิล ใช้ร่วมกัน billing_info_add.php (การ์ดเดียว) และ customer_add.php (หลายการ์ด)
 * กติกาเดียวกับ customer_code_lib.php (customer_code_plan_billing_cards):
 *   - tax 13 หลักที่ไม่ใช่ศูนย์ 13 ตัว: ลูกค้าเดิมค้นคู่รหัสเดิมด้วย customer_id + tax (ajax_customer_billing_codes.php)
 *     ลูกค้าใหม่ไม่ค้นในฐาน การ์ดที่ tax เดียวกันในฟอร์มใช้รหัสชุดเดียวกัน
 *   - ศูนย์ 13 ตัว/ไม่ครบ: แต่ละการ์ด Run ของตัวเองตามเดิม
 *   - รหัส preview จาก Run ยังไม่จองเลขจริง ตัวบันทึก resolve ใหม่อีกครั้งภายใต้ lock
 * DOM ของการ์ด: [data-client-key] [data-record-id] [data-code-view] (JSON จาก customer_code_card_view),
 *   .js-code-row[data-code-type] > .js-code-display / .js-code-value / .js-code-run,
 *   .js-code-source, .js-code-client-key, .js-code-record-id (hidden), .js-code-status
 */
(function(window, document) {
    "use strict";

    var TYPES = ["awl", "nbm"];
    var LABELS = {
        awl: "รหัสลูกค้า AWL",
        nbm: "รหัสลูกค้า NBM"
    };
    var KEY_PATTERN = /^[A-Za-z0-9_-]{1,64}$/;

    function normalizeTax(value) {
        return String(value || "").replace(/\D+/g, "");
    }

    function isReusable(tax) {
        return tax.length === 13 && tax !== "0000000000000";
    }

    function pair(awl, nbm) {
        return {
            awl: String(awl || "").trim(),
            nbm: String(nbm || "").trim()
        };
    }

    function copyPair(source) {
        return source ? pair(source.awl, source.nbm) : pair();
    }

    function isFull(codes) {
        return codes.awl !== "" && codes.nbm !== "";
    }

    function isEmpty(codes) {
        return codes.awl === "" && codes.nbm === "";
    }

    function escapeHtml(value) {
        return String(value === null || value === undefined ? "" : value).replace(/[&<>"']/g, function(char) {
            return {
                "&": "&amp;",
                "<": "&lt;",
                ">": "&gt;",
                "\"": "&quot;",
                "'": "&#039;"
            }[char];
        });
    }

    function notify(options) {
        if (window.Swal) {
            return window.Swal.fire(options);
        }
        window.alert((options.title ? options.title + "\n" : "") + (options.text || ""));
        return Promise.resolve({
            isConfirmed: true
        });
    }

    function Controller(options) {
        this.options = options;
        this.root = options.root;
        this.multi = !!options.multi;
        this.customerId = parseInt(options.customerId, 10) || 0;
        // ลูกค้าใหม่ยังไม่มี customer_id: ห้ามค้นทั้งฐาน ใช้รหัสร่วมกันเฉพาะการ์ดในฟอร์ม
        this.lookupEnabled = this.customerId > 0;
        this.lookupUrl = options.lookupUrl || "ajax_customer_billing_codes.php";
        this.runUrl = options.runUrl || "ajax_customer_run_code.php";
        this.cards = {};
        this.order = 0;
        this.keySeq = 0;
        this.subPreview = {};
        this.inFlight = {};
        this.waiters = [];
        this.busy = false;
        this.blocked = null;
        this.bindEvents();
        this.reconcile();
    }

    Controller.prototype.cardElements = function() {
        return Array.prototype.slice.call(this.root.querySelectorAll(this.options.cardSelector));
    };

    Controller.prototype.cardList = function() {
        var self = this;
        return this.cardElements().map(function(el) {
            return self.cards[el.getAttribute("data-client-key")];
        }).filter(function(st) {
            return st && !st.removed;
        });
    };

    Controller.prototype.stateFor = function(el) {
        var card = el ? el.closest(this.options.cardSelector) : null;
        if (!card) return null;
        var st = this.cards[card.getAttribute("data-client-key")];
        return st && st.el === card ? st : null;
    };

    Controller.prototype.taxInput = function(st) {
        return st.el.querySelector(this.options.taxSelector);
    };

    Controller.prototype.createState = function(el) {
        var view = null;
        try {
            view = el.getAttribute("data-code-view") ? JSON.parse(el.getAttribute("data-code-view")) : null;
        } catch (error) {
            view = null;
        }
        var key = el.getAttribute("data-client-key") || "";
        if (!KEY_PATTERN.test(key) || this.cards[key]) {
            key = "n" + Date.now().toString(36) + (++this.keySeq);
        }
        el.setAttribute("data-client-key", key);
        el.removeAttribute("data-code-view");

        var st = {
            key: key,
            el: el,
            seq: ++this.order,
            recordId: parseInt(el.getAttribute("data-record-id") || "0", 10) || 0,
            savedTax: view && view.saved_tax !== null && view.saved_tax !== undefined ? String(view.saved_tax) : null,
            saved: copyPair(view ? view.saved : null),
            savedSource: view && view.saved_source ? String(view.saved_source) : "",
            tax: view ? String(view.tax || "") : "",
            taxVersion: 0,
            own: pair(),
            selected: "",
            db: {
                status: "excluded",
                codes: null,
                candidates: []
            },
            lookupSeq: 0,
            lookupTimer: null,
            lookupAbort: null,
            prompted: false,
            removed: false
        };
        st.base = this.baseFor(st);

        if (view && view.db) {
            st.db = {
                status: String(view.db.status || "excluded"),
                codes: view.db.codes ? copyPair(view.db.codes) : null,
                candidates: view.db.candidates || [],
                message: ""
            };
            st.selected = view.source_key || "";
            var previews = copyPair(view.previews);
            if (isReusable(st.tax)) {
                var sub = this.subOf(st);
                var shared = this.subPreview[sub] || (this.subPreview[sub] = pair());
                TYPES.forEach(function(type) {
                    if (!shared[type] && previews[type]) shared[type] = previews[type];
                });
            } else {
                st.own = previews;
            }
        }
        return st;
    };

    Controller.prototype.baseFor = function(st) {
        return st.savedTax !== null && st.tax === st.savedTax ? copyPair(st.saved) : pair();
    };

    Controller.prototype.findCandidate = function(st, sourceKey) {
        if (!sourceKey) return null;
        var found = null;
        (st.db.candidates || []).forEach(function(candidate) {
            if (!found && candidate.source_key === sourceKey) found = candidate;
        });
        return found;
    };

    // คู่รหัสเดิมที่การ์ดใช้: รหัสที่ถืออยู่ (tax เดิม) > แหล่งที่เลือก > คู่เดียวที่พบ
    Controller.prototype.pairOf = function(st) {
        if (isFull(st.base)) return copyPair(st.base);
        var chosen = this.findCandidate(st, st.selected);
        if (chosen) return pair(chosen.awl, chosen.nbm);
        if (st.db.status === "matched" && st.db.codes) return copyPair(st.db.codes);
        return copyPair(st.base);
    };

    Controller.prototype.subOf = function(st) {
        if (!isReusable(st.tax)) return "card:" + st.key;
        var codes = this.pairOf(st);
        return isEmpty(codes) ? "pv:" + st.tax : "db:" + st.tax + ":" + codes.awl + "|" + codes.nbm;
    };

    // กลุ่มของการ์ดทั้งหมด ตัวควบคุม = การ์ดที่สร้างก่อนสุดที่ยังอยู่ในกลุ่ม
    Controller.prototype.groups = function() {
        var self = this;
        var groups = {};
        Object.keys(this.cards).forEach(function(key) {
            var st = self.cards[key];
            var sub = self.subOf(st);
            var group = groups[sub] || (groups[sub] = {
                members: [],
                controller: null
            });
            group.members.push(st);
            if (!group.controller || st.seq < group.controller.seq) group.controller = st;
        });
        return groups;
    };

    Controller.prototype.view = function(st, groups) {
        var self = this;
        var reusable = isReusable(st.tax);
        var sub = this.subOf(st);
        var group = groups[sub];
        var codes = pair();
        var states = {};
        var run = {};
        var fixed = reusable ? this.pairOf(st) : pair();
        var shared = reusable ? (this.subPreview[sub] || pair()) : st.own;
        var pending = reusable && !isFull(st.base) && st.db.status === "pending";
        var error = reusable && !isFull(st.base) && st.db.status === "error";
        var conflict = reusable && !isFull(st.base) && st.db.status === "conflict" && !this.findCandidate(st, st.selected);

        TYPES.forEach(function(type) {
            if (reusable) {
                codes[type] = fixed[type] || shared[type] || "";
                states[type] = st.base[type] ? "saved" : (fixed[type] ? "reused" : (codes[type] ? "preview" : "empty"));
            } else {
                codes[type] = st.own[type] || st.base[type] || "";
                states[type] = st.own[type] ? "preview" : (st.base[type] ? "saved" : "empty");
            }

            if (pending || error || conflict || self.inFlight[sub + "|" + type]) {
                run[type] = "disabled";
            } else if (!reusable) {
                run[type] = "visible";
            } else if (states[type] === "saved" || states[type] === "reused") {
                run[type] = "hidden";
            } else if (states[type] === "preview") {
                // เปลี่ยน preview ของกลุ่มได้จากตัวควบคุมเท่านั้น ช่องที่ว่างกด Run จากการ์ดใดก็ได้
                run[type] = group && group.controller === st ? "visible" : "hidden";
            } else {
                run[type] = "visible";
            }
        });

        var source = "";
        if (st.savedSource && st.tax === st.savedTax) {
            source = st.savedSource;
        } else if (reusable && !isFull(st.base)) {
            var chosen = this.findCandidate(st, st.selected);
            if (chosen) {
                source = chosen.source_key;
            } else if (st.db.status === "matched" && st.db.candidates && st.db.candidates[0]) {
                source = st.db.candidates[0].source_key;
            } else if (this.multi && sub.indexOf("pv:") === 0 && group && group.controller !== st) {
                source = "form:" + group.controller.key;
            }
        }

        return {
            sub: sub,
            codes: codes,
            states: states,
            run: run,
            source: source,
            pending: pending,
            error: error,
            conflict: conflict,
            chosen: reusable && !isFull(st.base) && st.db.status === "conflict" ? this.findCandidate(st, st.selected) : null
        };
    };

    Controller.prototype.render = function(st, v) {
        TYPES.forEach(function(type) {
            var row = st.el.querySelector('.js-code-row[data-code-type="' + type + '"]');
            if (!row) return;
            var value = row.querySelector(".js-code-value");
            var display = row.querySelector(".js-code-display");
            var button = row.querySelector(".js-code-run");
            if (value) value.value = v.codes[type];
            if (display) display.value = v.codes[type] !== "" ? v.codes[type] : "Auto";
            row.setAttribute("data-code-state", v.states[type]);
            if (button) {
                button.hidden = v.run[type] === "hidden";
                button.disabled = v.run[type] !== "visible";
            }
        });

        var source = st.el.querySelector(".js-code-source");
        if (source) source.value = v.source;
        var clientKey = st.el.querySelector(".js-code-client-key");
        if (clientKey) clientKey.value = st.key;
        var recordId = st.el.querySelector(".js-code-record-id");
        if (recordId) recordId.value = String(st.recordId);
        this.renderStatus(st, v);
    };

    Controller.prototype.renderStatus = function(st, v) {
        var box = st.el.querySelector(".js-code-status");
        if (!box) return;
        var text = "";
        var action = "";
        var actionText = "";
        var tone = "info";
        if (v.pending) {
            text = "กำลังตรวจสอบรหัสลูกค้าของเลขผู้เสียภาษีนี้...";
        } else if (v.error) {
            text = st.db.message || "ตรวจสอบรหัสลูกค้าไม่สำเร็จ";
            action = "retry";
            actionText = "ลองใหม่";
            tone = "error";
        } else if (v.conflict) {
            text = "พบรหัสลูกค้าหลายชุดของเลขผู้เสียภาษีนี้ กรุณาเลือกหนึ่งชุดก่อนบันทึก";
            action = "choose";
            actionText = "เลือกรหัสลูกค้า";
            tone = "error";
        } else if (v.chosen) {
            text = "ใช้รหัสลูกค้าจาก " + (v.chosen.billing_name || "บิลเดิม");
            action = "choose";
            actionText = "เปลี่ยน";
        }

        box.textContent = "";
        box.hidden = text === "";
        box.setAttribute("data-tone", tone);
        if (text === "") return;
        var label = document.createElement("span");
        label.textContent = text;
        box.appendChild(label);
        if (action) {
            var button = document.createElement("button");
            button.type = "button";
            button.className = "code-status-action js-code-" + action;
            button.textContent = actionText;
            box.appendChild(button);
        }
    };

    Controller.prototype.renderAll = function() {
        var self = this;
        var groups = this.groups();
        var busy = Object.keys(this.inFlight).length > 0;
        var blocked = busy;
        Object.keys(this.cards).forEach(function(key) {
            var st = self.cards[key];
            var v = self.view(st, groups);
            self.render(st, v);
            if (v.pending || st.lookupTimer) busy = true;
            if (v.pending || v.error || v.conflict || st.lookupTimer) blocked = true;
        });
        // preview ของกลุ่มที่ไม่เหลือการ์ดแล้วไม่ติดไปกับกลุ่มใหม่
        Object.keys(this.subPreview).forEach(function(sub) {
            if (!groups[sub]) delete self.subPreview[sub];
        });

        this.busy = busy;
        if (!busy && this.waiters.length) {
            var waiters = this.waiters;
            this.waiters = [];
            waiters.forEach(function(resolve) {
                resolve();
            });
        }
        if (this.blocked !== blocked) {
            this.blocked = blocked;
            if (this.options.onBlockedChange) this.options.onBlockedChange(blocked);
        }
        if (this.options.onChange) this.options.onChange();
    };

    Controller.prototype.cancelLookup = function(st) {
        if (st.lookupTimer) {
            clearTimeout(st.lookupTimer);
            st.lookupTimer = null;
        }
        if (st.lookupAbort) {
            st.lookupAbort.abort();
            st.lookupAbort = null;
        }
        st.lookupSeq++;
    };

    // เปลี่ยน tax: ล้างรหัส/แหล่งของ tax เดิม (กลับ tax ที่บันทึกไว้ = คืนรหัสเดิมของบิลนี้) แล้วค้นของ tax ใหม่
    Controller.prototype.setTax = function(st, tax, immediate, interactive) {
        var self = this;
        st.tax = tax;
        st.taxVersion++;
        st.own = pair();
        st.selected = "";
        st.prompted = false;
        this.cancelLookup(st);
        st.base = this.baseFor(st);

        if (isReusable(tax) && !isFull(st.base)) {
            if (this.lookupEnabled) {
                st.db = {
                    status: "pending",
                    codes: null,
                    candidates: []
                };
                if (immediate) {
                    this.lookup(st, interactive);
                    return;
                }
                st.lookupTimer = setTimeout(function() {
                    st.lookupTimer = null;
                    self.lookup(st, true);
                }, 300);
            } else {
                st.db = {
                    status: "not_found",
                    codes: null,
                    candidates: []
                };
            }
        } else {
            st.db = {
                status: isReusable(tax) ? "skip" : "excluded",
                codes: null,
                candidates: []
            };
        }
        this.renderAll();
    };

    Controller.prototype.lookup = function(st, interactive) {
        var self = this;
        if (st.lookupTimer) {
            clearTimeout(st.lookupTimer);
            st.lookupTimer = null;
        }
        if (st.lookupAbort) st.lookupAbort.abort();
        var seq = ++st.lookupSeq;
        var tax = st.tax;
        var abort = window.AbortController ? new window.AbortController() : null;
        st.lookupAbort = abort;
        st.db = {
            status: "pending",
            codes: null,
            candidates: []
        };
        this.renderAll();

        var body = new URLSearchParams();
        body.append("customer_id", String(this.customerId));
        body.append("tax_id", tax);
        body.append("billing_id", String(st.recordId));

        fetch(this.lookupUrl, {
                method: "POST",
                body: body,
                credentials: "same-origin",
                signal: abort ? abort.signal : undefined
            })
            .then(function(response) {
                return response.text().then(function(text) {
                    var data = null;
                    try {
                        data = JSON.parse(text);
                    } catch (error) {
                        data = null;
                    }
                    return {
                        status: response.status,
                        data: data
                    };
                });
            })
            .then(function(result) {
                if (seq !== st.lookupSeq || st.removed || st.tax !== tax) return;
                st.lookupAbort = null;
                var data = result.data;
                if (!data || !data.success) {
                    st.db = {
                        status: "error",
                        codes: null,
                        candidates: [],
                        message: data && data.message ? data.message : (result.status === 401 ? "กรุณาเข้าสู่ระบบใหม่" : "ตรวจสอบรหัสลูกค้าไม่สำเร็จ")
                    };
                } else {
                    st.db = {
                        status: data.status,
                        codes: data.codes ? copyPair(data.codes) : null,
                        candidates: data.candidates || []
                    };
                    if (st.selected && !self.findCandidate(st, st.selected)) st.selected = "";
                }
                self.renderAll();
                if (st.db.status === "conflict" && interactive && !st.selected && !st.prompted && !(window.Swal && window.Swal.isVisible())) {
                    st.prompted = true;
                    self.choose(st);
                }
            })
            .catch(function(error) {
                if (error && error.name === "AbortError") return;
                if (seq !== st.lookupSeq || st.removed) return;
                st.lookupAbort = null;
                st.db = {
                    status: "error",
                    codes: null,
                    candidates: [],
                    message: "ตรวจสอบรหัสลูกค้าไม่สำเร็จ กรุณาลองใหม่"
                };
                self.renderAll();
            });
    };

    // เลือกคู่รหัสหนึ่งแหล่งเมื่อพบหลายคู่ ไม่เลือกคู่แรก/ล่าสุดให้เอง ข้อมูลจากฐาน escape ก่อนแสดง
    Controller.prototype.choose = function(st) {
        var self = this;
        var candidates = st.db.candidates || [];
        if (!candidates.length) return Promise.resolve(false);
        if (!window.Swal) {
            notify({
                title: "พบรหัสลูกค้าหลายชุด",
                text: "ไม่สามารถแสดงรายการให้เลือกได้ กรุณาโหลดหน้าใหม่"
            });
            return Promise.resolve(false);
        }
        var version = st.taxVersion;
        var items = candidates.map(function(candidate, index) {
            var branch = candidate.branch_no ? " (สาขา " + escapeHtml(candidate.branch_no) + ")" : "";
            return '<label class="billing-code-candidate" style="display:flex;gap:10px;align-items:flex-start;padding:10px 12px;border:1px solid #ede9f0;border-radius:10px;cursor:pointer;text-align:left">' +
                '<input type="radio" name="billing_code_candidate" value="' + index + '"' + (candidate.source_key === st.selected ? " checked" : "") + ' style="margin-top:5px">' +
                '<span><strong style="color:#612989">AWL: ' + escapeHtml(candidate.awl || "-") + " / NBM: " + escapeHtml(candidate.nbm || "-") + "</strong><br>" +
                escapeHtml(candidate.billing_name || "-") + branch + "<br>" +
                '<small style="color:#696969">' + escapeHtml(candidate.address || "") + "</small></span></label>";
        }).join("");

        return window.Swal.fire({
            title: "เลือกรหัสลูกค้า",
            html: '<p style="margin:0 0 12px">เลขผู้เสียภาษีนี้มีรหัสลูกค้าหลายชุดภายใต้ลูกค้ารายนี้ กรุณาเลือกหนึ่งชุด</p>' +
                '<div style="display:grid;gap:8px;max-height:50vh;overflow:auto">' + items + "</div>",
            showCancelButton: true,
            confirmButtonText: "ใช้รหัสนี้",
            cancelButtonText: "ยกเลิก",
            confirmButtonColor: "#612989",
            focusConfirm: false,
            preConfirm: function() {
                var checked = window.Swal.getPopup().querySelector('input[name="billing_code_candidate"]:checked');
                if (!checked) {
                    window.Swal.showValidationMessage("กรุณาเลือกรหัสลูกค้า");
                    return false;
                }
                return parseInt(checked.value, 10);
            }
        }).then(function(result) {
            if (!result.isConfirmed || st.removed || st.taxVersion !== version) return false;
            var candidate = (st.db.candidates || [])[result.value];
            if (!candidate) return false;
            st.selected = candidate.source_key;
            self.renderAll();
            return true;
        });
    };

    Controller.prototype.run = function(st, type) {
        var self = this;
        var groups = this.groups();
        var v = this.view(st, groups);
        if (v.run[type] !== "visible") return;

        function start() {
            var current = self.view(st, self.groups());
            if (current.sub !== v.sub || current.run[type] !== "visible") return;
            var sub = current.sub;
            var flight = sub + "|" + type;
            var version = st.taxVersion;
            var body = new URLSearchParams();
            var exclude = {};
            var latestGroups = self.groups();
            body.append("type", type);
            // รหัสของกลุ่มอื่นในฟอร์มที่ยังไม่ลงฐาน ไม่นับกลุ่มตัวเอง
            Object.keys(self.cards).forEach(function(key) {
                var other = self.view(self.cards[key], latestGroups);
                if (other.sub !== sub && other.codes[type]) exclude[other.codes[type]] = true;
            });
            Object.keys(exclude).forEach(function(code) {
                body.append("exclude[]", code);
            });

            self.inFlight[flight] = true;
            self.renderAll();
            fetch(self.runUrl, {
                    method: "POST",
                    body: body,
                    credentials: "same-origin"
                })
                .then(function(response) {
                    return response.json();
                })
                .then(function(result) {
                    if (!result || !result.success) {
                        throw new Error(result && result.message ? result.message : "รันรหัสลูกค้าไม่สำเร็จ");
                    }
                    // การ์ดถูกลบ/เปลี่ยน tax/ย้ายกลุ่มระหว่างรอ: ทิ้งผล ไม่ให้เลขของกลุ่มเก่าทับกลุ่มใหม่
                    if (st.removed || st.taxVersion !== version || self.subOf(st) !== sub) return;
                    if (sub.indexOf("card:") === 0) {
                        st.own[type] = result.code;
                    } else {
                        (self.subPreview[sub] || (self.subPreview[sub] = pair()))[type] = result.code;
                    }
                    notify({
                        icon: "success",
                        title: "รันรหัสลูกค้าแล้ว",
                        text: LABELS[type] + ": " + result.code + " (บันทึกจริงตอนกดบันทึก หากเลขนี้ถูกใช้ไปก่อน ระบบจะรันเลขใหม่ให้อัตโนมัติ)"
                    });
                })
                .catch(function(error) {
                    notify({
                        icon: "error",
                        title: "เกิดข้อผิดพลาด",
                        text: error && error.message ? error.message : "รันรหัสลูกค้าไม่สำเร็จ"
                    });
                })
                .then(function() {
                    delete self.inFlight[flight];
                    self.renderAll();
                });
        }

        // tax ที่ไม่ใช้ร่วมกัน (ศูนย์ 13 ตัว/ไม่ครบ) Run ทับรหัสที่บันทึกแล้วได้ตามเดิม แต่ถามก่อน
        if (v.states[type] === "saved" && window.Swal) {
            window.Swal.fire({
                icon: "warning",
                title: "รัน" + LABELS[type] + "ใหม่?",
                html: "รหัสเดิม <b>" + escapeHtml(v.codes[type]) + "</b> จะถูกแทนที่เมื่อกดบันทึก<br>เอกสารเดิมที่อ้างรหัสนี้จะไม่ถูกแก้ไข",
                showCancelButton: true,
                confirmButtonText: "รันรหัสใหม่",
                cancelButtonText: "ยกเลิก",
                confirmButtonColor: "#612989"
            }).then(function(choice) {
                if (choice.isConfirmed) start();
            });
            return;
        }
        start();
    };

    // ทุกทางที่แก้การ์ดด้วย JS (เพิ่ม/ลบ/copy/ล้าง/ย้ายใบหลัก) ต้องเรียก reconcile ไม่พึ่ง input event
    Controller.prototype.reconcile = function() {
        var self = this;
        var seen = {};
        this.cardElements().forEach(function(el) {
            var st = self.cards[el.getAttribute("data-client-key")];
            if (!st || st.el !== el) {
                st = self.createState(el);
                self.cards[st.key] = st;
            }
            seen[st.key] = true;
            var input = self.taxInput(st);
            var tax = normalizeTax(input ? input.value : "");
            if (tax !== st.tax) self.setTax(st, tax, true, false);
        });
        Object.keys(this.cards).forEach(function(key) {
            if (seen[key]) return;
            var st = self.cards[key];
            st.removed = true;
            self.cancelLookup(st);
            delete self.cards[key];
        });
        this.renderAll();
    };

    Controller.prototype.whenIdle = function() {
        var self = this;
        Object.keys(this.cards).forEach(function(key) {
            var st = self.cards[key];
            if (st.lookupTimer) self.lookup(st, false);
        });
        this.renderAll();
        if (!this.busy) return Promise.resolve();
        return new Promise(function(resolve) {
            self.waiters.push(resolve);
        });
    };

    // เรียกก่อนบันทึก: รอการตรวจที่ค้าง แล้วไม่ให้ผ่านถ้าตรวจไม่สำเร็จหรือยังไม่ได้เลือกรหัส คืน Promise<boolean>
    Controller.prototype.prepareSubmit = function() {
        var self = this;
        this.reconcile();
        return this.whenIdle().then(function() {
            var groups = self.groups();
            var cards = self.cardList();
            for (var i = 0; i < cards.length; i++) {
                var st = cards[i];
                var v = self.view(st, groups);
                var prefix = self.multi ? "ที่อยู่ออกบิล " + (i + 1) + ": " : "";
                if (v.error) {
                    notify({
                        icon: "error",
                        title: "ตรวจสอบรหัสลูกค้าไม่สำเร็จ",
                        text: prefix + (st.db.message || "กรุณากดลองใหม่ก่อนบันทึก")
                    });
                    return false;
                }
                if (v.conflict) {
                    return self.choose(st).then(function() {
                        return false;
                    });
                }
            }
            self.renderAll();
            return true;
        });
    };

    Controller.prototype.bindEvents = function() {
        var self = this;
        var selector = this.options.taxSelector;

        this.root.addEventListener("input", function(event) {
            if (!event.target.matches || !event.target.matches(selector)) return;
            var st = self.stateFor(event.target);
            if (!st) return self.reconcile();
            var tax = normalizeTax(event.target.value);
            if (tax !== st.tax) self.setTax(st, tax, false, true);
        });

        function flush(event) {
            if (!event.target.matches || !event.target.matches(selector)) return;
            var st = self.stateFor(event.target);
            if (!st) return self.reconcile();
            var tax = normalizeTax(event.target.value);
            if (tax !== st.tax) {
                self.setTax(st, tax, true, true);
            } else if (st.lookupTimer) {
                self.lookup(st, true);
            }
        }
        this.root.addEventListener("change", flush);
        this.root.addEventListener("focusout", flush);

        this.root.addEventListener("click", function(event) {
            var target = event.target.closest ? event.target : null;
            if (!target) return;
            var st = self.stateFor(target);
            if (!st) return;
            var runButton = target.closest(".js-code-run");
            if (runButton) {
                var row = runButton.closest(".js-code-row");
                if (row) self.run(st, row.getAttribute("data-code-type"));
                return;
            }
            if (target.closest(".js-code-retry")) {
                self.lookup(st, true);
                return;
            }
            if (target.closest(".js-code-choose")) {
                self.choose(st);
            }
        });

        window.addEventListener("pageshow", function(event) {
            if (event.persisted) self.reconcile();
        });
    };

    window.BillingCustomerCodes = {
        create: function(options) {
            return new Controller(options);
        },
        normalizeTax: normalizeTax,
        isReusable: isReusable
    };
})(window, document);
