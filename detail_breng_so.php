<html>
<head>
<script type="text/javascript" src="js/jquery.min.js"></script>
</head>

<script type="text/javascript">
	function ck_frm() {
		var ck = document.getElementById('ckk');
		if (ck.checked == true) {
			document.getElementById('frm_txt').style.display = "";
		} else {
			document.getElementById('frm_txt').style.display = "none";
		}
	}
</script>

<script language="JavaScript">
	var HttPRequest = false;
	function doCallAjax(product_code, product_id, product_name, unit_name, product_price) {
		HttPRequest = false;
		if (window.XMLHttpRequest) { // Mozilla, Safari,...
			HttPRequest = new XMLHttpRequest();
			if (HttPRequest.overrideMimeType) {
				HttPRequest.overrideMimeType('text/html');
			}
		} else if (window.ActiveXObject) { // IE
			try {
				HttPRequest = new ActiveXObject("Msxml2.XMLHTTP");
			} catch (e) {
				try {
					HttPRequest = new ActiveXObject("Microsoft.XMLHTTP");
				} catch (e) {}
			}
		}

		if (!HttPRequest) {
			alert('Cannot create XMLHTTP instance');
			return false;
		}
		var url = 'data_product_hos1.php';
		var pmeters = "product_code=" + encodeURI(document.getElementById(product_code).value);
		HttPRequest.open('POST', url, true);

		HttPRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		HttPRequest.setRequestHeader("Content-length", pmeters.length);
		HttPRequest.setRequestHeader("Connection", "close");
		HttPRequest.send(pmeters);

		HttPRequest.onreadystatechange = function() {
			if (HttPRequest.readyState == 4) { // Return Request
				var myProduct = HttPRequest.responseText;
				if (myProduct != "") {
					var myArr = myProduct.split("|");
					document.getElementById(product_id).value = myArr[0];
					document.getElementById(product_name).value = myArr[1];
					document.getElementById(unit_name).value = myArr[2];
					document.getElementById(product_price).value = myArr[3];
				}
			}
		}
	}

	function chkNumber(ele) {
		var vchar = String.fromCharCode(event.keyCode);
		if ((vchar < '0' || vchar > '9') && (vchar != '.')) return false;
		ele.onKeyPress = vchar;
	}

	var BR_ROW_COUNT = 10;
	var brRowFields = ['product_codet', 'product_c', 'product_id', 'unit_name', 'product_name', 'product_code', 'sale_count', 'product_price', 'sum_amount', 'sale_remarkk'];

	function brSetRowData(i, data) {
		brRowFields.forEach(function(f) {
			var el = document.getElementById(f + i);
			if (el && data[f] !== undefined) el.value = data[f];
		});
	}

	var brProductSearchDept = <?php echo ($_SESSION['department'] ?? '') === 'วิศวกรรม' ? "'eng'" : "'sale'"; ?>;
	var brProductSearchTimer = null;

	function brProductSearchInput(i) {
		var input = document.getElementById('product_code' + i);
		var dropdown = document.getElementById('product_search_dd' + i);
		var q = input.value.trim();

		clearTimeout(brProductSearchTimer);

		if (q.length < 1) {
			dropdown.style.display = 'none';
			dropdown.innerHTML = '';
			return;
		}

		brProductSearchTimer = setTimeout(function() {
			fetch('ajax_product_search_br.php?dept=' + brProductSearchDept + '&q=' + encodeURIComponent(q))
				.then(function(res) { return res.json(); })
				.then(function(data) {
					dropdown.innerHTML = '';
					if (!data.success || !data.products || data.products.length === 0) {
						dropdown.innerHTML = '<div class="br-product-search-empty">ไม่พบสินค้า</div>';
						dropdown.style.display = 'block';
						return;
					}
					data.products.forEach(function(p) {
						var item = document.createElement('div');
						item.className = 'br-product-search-item';
						item.innerHTML = '<b>' + p.product_code + '</b> - ' + p.product_name;
						item.onclick = function() {
							input.value = p.product_code;
							dropdown.style.display = 'none';
							dropdown.innerHTML = '';
							doCallAjax('product_code' + i, 'product_id' + i, 'product_name' + i, 'unit_name' + i, 'product_price' + i);
						};
						dropdown.appendChild(item);
					});
					dropdown.style.display = 'block';
				});
		}, 250);
	}

	document.addEventListener('click', function(evt) {
		if (!evt.target.closest('.br-product-search-wrap')) {
			document.querySelectorAll('.br-product-search-dropdown').forEach(function(dd) {
				dd.style.display = 'none';
			});
		}
	});
</script>

<script src="dist/jautocalc.js"></script>

<body>

<?php
function br_product_row_eng($i) {
?>
	<tr>
		<td>
			<div class="br-product-search-wrap">
				<input type='text' name="product_code<?php echo $i; ?>" id="product_code<?php echo $i; ?>" class="so-input" placeholder="ค้นหาด้วยรหัสสินค้า/ชื่อสินค้า..." autocomplete="off" oninput="brProductSearchInput(<?php echo $i; ?>);" OnChange="JavaScript:doCallAjax('product_code<?php echo $i; ?>','product_id<?php echo $i; ?>','product_name<?php echo $i; ?>','unit_name<?php echo $i; ?>','product_price<?php echo $i; ?>');" />
				<div class="br-product-search-dropdown" id="product_search_dd<?php echo $i; ?>"></div>
				<input type='hidden' name="product_codet<?php echo $i; ?>" id="product_codet<?php echo $i; ?>" value="">
				<input type='hidden' name="product_c<?php echo $i; ?>" id="product_c<?php echo $i; ?>" value="">
				<input type='hidden' name="product_id<?php echo $i; ?>" id="product_id<?php echo $i; ?>">
			</div>
		</td>
		<td><textarea name="product_name<?php echo $i; ?>" id="product_name<?php echo $i; ?>" rows="2" class="so-input" readonly></textarea></td>
		<td><input type='text' name="unit_name<?php echo $i; ?>" id="unit_name<?php echo $i; ?>" class="so-input" /></td>
		<td><input type='text' name="sale_count<?php echo $i; ?>" id="sale_count<?php echo $i; ?>" class="so-input" style="text-align:center" /></td>
		<td><input type='text' name="product_price<?php echo $i; ?>" id="product_price<?php echo $i; ?>" class="so-input" style="text-align:right" /></td>
		<td><input type='text' name="sum_amount<?php echo $i; ?>" id="sum_amount<?php echo $i; ?>" class="so-input" style="text-align:right" value="" jAutoCalc='{sale_count<?php echo $i; ?>} * {product_price<?php echo $i; ?>}' readonly /></td>
		<td><textarea name="sale_remarkk<?php echo $i; ?>" id="sale_remarkk<?php echo $i; ?>" class="so-input"></textarea></td>
		<td class="so-product-remove-cell">
			<button type="button" class="so-product-remove-btn" onclick="document.getElementById('product_code<?php echo $i; ?>').value='';document.getElementById('product_codet<?php echo $i; ?>').value='';document.getElementById('product_c<?php echo $i; ?>').value='';document.getElementById('product_name<?php echo $i; ?>').value='';document.getElementById('unit_name<?php echo $i; ?>').value='';document.getElementById('product_price<?php echo $i; ?>').value='';document.getElementById('sale_count<?php echo $i; ?>').value='';document.getElementById('sum_amount<?php echo $i; ?>').value='';document.getElementById('product_id<?php echo $i; ?>').value='';">
				<img src="img/false.png" width="16" height="16" alt="ลบ" />
			</button>
		</td>
	</tr>
<?php
}
?>

<div class="so-product-summary-bar">
	<div class="so-product-summary-col">
		<span class="so-product-summary-label">จำนวนรวม(ชิ้น)</span>
		<span class="so-product-summary-value" id="br_summary_qty">0</span>
	</div>
	<div class="so-product-summary-col">
		<span class="so-product-summary-label">ยอดรวม</span>
		<span class="so-product-summary-value" id="br_summary_amount">0.00</span>
	</div>
</div>

<div class="so-product-table-wrap">
	<table class="so-product-table">
		<thead>
			<tr>
				<th>รหัสสินค้า</th>
				<th>ชื่อสินค้า</th>
				<th>หน่วย</th>
				<th>จำนวน</th>
				<th>ราคาต่อหน่วย</th>
				<th>ยอดรวม</th>
				<th>หมายเหตุ</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php for ($i = 1; $i <= 5; $i++) br_product_row_eng($i); ?>
		</tbody>
	</table>
</div>

<label class="so-product-more-toggle">
	<input type="checkbox" name="ckk" id="ckk" onClick="ck_frm();" value="1" /> เพิ่มเติม
</label>
<div id="frm_txt" style="display:none;">
	<div class="so-product-table-wrap">
		<table class="so-product-table">
			<tbody>
				<?php for ($i = 6; $i <= 10; $i++) br_product_row_eng($i); ?>
			</tbody>
		</table>
	</div>
</div>

</body>
</html>

<script>
	$('form').jAutoCalc({
		attribute: 'jAutoCalc',
		thousandOpts: [',', '.', ' '],
		decimalOpts: ['.', ','],
		decimalPlaces: -1,
		initFire: true,
		chainFire: true,
		keyEventsFire: false,
		readOnlyResults: true,
		showParseError: true,
		emptyAsZero: false,
		smartIntegers: false,
		onShowResult: null,
		funcs: {},
		vars: {}
	});
</script>

<script type="text/javascript">
	function brUpdateProductSummary() {
		var qty = 0;
		var amount = 0;
		for (var i = 1; i <= 10; i++) {
			var qtyEl = document.getElementById('sale_count' + i);
			var amtEl = document.getElementById('sum_amount' + i);
			if (qtyEl && qtyEl.value) {
				var q = parseFloat(qtyEl.value.toString().replace(/,/g, ''));
				if (!isNaN(q)) qty += q;
			}
			if (amtEl && amtEl.value) {
				var a = parseFloat(amtEl.value.toString().replace(/,/g, ''));
				if (!isNaN(a)) amount += a;
			}
		}
		document.getElementById('br_summary_qty').textContent = qty.toLocaleString();
		document.getElementById('br_summary_amount').textContent = amount.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
	}

	(function() {
		for (var i = 1; i <= 10; i++) {
			var qtyEl = document.getElementById('sale_count' + i);
			var amtEl = document.getElementById('sum_amount' + i);
			if (qtyEl) qtyEl.addEventListener('input', brUpdateProductSummary);
			if (amtEl) amtEl.addEventListener('input', brUpdateProductSummary);
		}
		setInterval(brUpdateProductSummary, 800);
	})();
</script>
