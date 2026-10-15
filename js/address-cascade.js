// address cascade: จังหวัด → เขต/อำเภอ → แขวง/ตำบล → รหัสไปรษณีย์ (คู่กับ includes/address_cascade.php)
// แต่ละชุดอยู่ใน [data-address-scope] และระบุชั้นด้วย data-address-level บน <select>
// เปลี่ยนชั้นบนล้างชั้นล่าง รหัสไปรษณีย์มาจากตำบลที่เลือกเท่านั้น
(function() {
    var levels = ["province", "district", "sub_district", "postcode"];

    function levelSelect(scope, level) {
        return scope.querySelector('select[data-address-level="' + level + '"]');
    }

    function resetSelect(select) {
        if (!select) return;
        select.innerHTML = '<option value="">Select</option>';
        select.value = "";
    }

    function resetBelow(scope, level) {
        levels.slice(levels.indexOf(level) + 1).forEach(function(lower) {
            resetSelect(levelSelect(scope, lower));
        });
    }

    // ตัวนับต่อชุด: ผลโหลดที่กลับมาช้ากว่าการเปลี่ยนครั้งล่าสุดถูกทิ้ง
    function nextSeq(scope) {
        scope.dataset.addressSeq = String((parseInt(scope.dataset.addressSeq || "0", 10) || 0) + 1);
        return scope.dataset.addressSeq;
    }

    function appendOption(select, value, dataset) {
        var option = document.createElement("option");
        option.value = value;
        option.textContent = value;
        Object.keys(dataset || {}).forEach(function(key) {
            option.dataset[key] = dataset[key];
        });
        select.appendChild(option);
    }

    function loadOptions(params) {
        return fetch("ajax_address_options.php?" + new URLSearchParams(params).toString(), {
                credentials: "same-origin"
            })
            .then(function(response) {
                return response.json();
            })
            .then(function(result) {
                if (!result.success) {
                    throw new Error(result.message || "โหลดข้อมูลที่อยู่ไม่สำเร็จ");
                }
                return result.items || [];
            });
    }

    function showLoadError(error) {
        var text = error.message || "โหลดข้อมูลที่อยู่ไม่สำเร็จ";
        if (window.Swal) {
            Swal.fire({
                icon: "error",
                title: "เกิดข้อผิดพลาด",
                text: text
            });
        } else {
            window.alert(text);
        }
    }

    function onProvinceChange(scope, select) {
        var seq = nextSeq(scope);
        resetBelow(scope, "province");
        if (select.value === "") return;

        loadOptions({
            level: "district",
            province: select.value
        }).then(function(items) {
            if (seq !== scope.dataset.addressSeq) return;
            var districtSelect = levelSelect(scope, "district");
            items.forEach(function(item) {
                appendOption(districtSelect, item.name_th, {
                    id: item.id
                });
            });
        }).catch(showLoadError);
    }

    function onDistrictChange(scope, select) {
        var seq = nextSeq(scope);
        var selected = select.options[select.selectedIndex];
        var districtId = selected ? selected.dataset.id : "";
        resetBelow(scope, "district");
        if (!districtId) return;

        loadOptions({
            level: "sub_district",
            district_id: districtId
        }).then(function(items) {
            if (seq !== scope.dataset.addressSeq) return;
            var subDistrictSelect = levelSelect(scope, "sub_district");
            items.forEach(function(item) {
                appendOption(subDistrictSelect, item.name_th, {
                    zip: String(item.zip_code)
                });
            });
        }).catch(showLoadError);
    }

    // รหัสไปรษณีย์แสดงหลังเลือกตำบลเท่านั้น มีตัวเลือกเดียวคือรหัสของตำบลนั้น (ค่าเก่า "(ไม่พบในรายการ)" หายไปด้วย)
    function onSubDistrictChange(scope, select) {
        var selected = select.options[select.selectedIndex];
        var zip = selected ? (selected.dataset.zip || "") : "";
        var postcodeSelect = levelSelect(scope, "postcode");
        resetSelect(postcodeSelect);
        if (zip === "" || !postcodeSelect) return;
        appendOption(postcodeSelect, zip);
        postcodeSelect.value = zip;
    }

    document.addEventListener("change", function(event) {
        var select = event.target;
        var level = select.dataset ? select.dataset.addressLevel : "";
        if (!level) return;
        var scope = select.closest("[data-address-scope]");
        if (!scope) return;

        if (level === "province") onProvinceChange(scope, select);
        if (level === "district") onDistrictChange(scope, select);
        if (level === "sub_district") onSubDistrictChange(scope, select);
    });
})();
