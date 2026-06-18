<html>
<head>
<link rel="stylesheet" href="css/autocomplete.css"  type="text/css"/>
<script type="text/javascript" src="js/autocomplete.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>


</head>

<script type="text/javascript">
function ck_frm(){
var ck = document.getElementById('ckk');
if(ck.checked == true){
document.getElementById('frm_txt').style.display = "";
}else{
document.getElementById('frm_txt').style.display = "none";
}

}


function ck_frm1(){
var ck = document.getElementById('ckk1');
if(ck.checked == true){
document.getElementById('frm_txt1').style.display = "";
}else{
document.getElementById('frm_txt1').style.display = "none";
}

}

function ck_frm2(){
var ck = document.getElementById('ckk2');
if(ck.checked == true){
document.getElementById('frm_txt2').style.display = "";
}else{
document.getElementById('frm_txt2').style.display = "none";
}

}

function ck_frm3(){
var ck = document.getElementById('ckk3');
if(ck.checked == true){
document.getElementById('frm_txt3').style.display = "";
}else{
document.getElementById('frm_txt3').style.display = "none";
}

}

function ck_frm4(){
var ck = document.getElementById('ckk4');
if(ck.checked == true){
document.getElementById('frm_txt4').style.display = "";
}else{
document.getElementById('frm_txt4').style.display = "none";
}

}




</script>



<script language="JavaScript">
var HttPRequest = false;
function doCallAjax(product_code,product_id,product_name,unit_name,product_price,discount_unit,waranty) {
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
var pmeters = "product_code=" + encodeURI( document.getElementById(product_code).value);
HttPRequest.open('POST',url,true);

HttPRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
HttPRequest.setRequestHeader("Content-length", pmeters.length);
HttPRequest.setRequestHeader("Connection", "close");
HttPRequest.send(pmeters);

HttPRequest.onreadystatechange = function()
{
if(HttPRequest.readyState == 4) // Return Request
{
var myProduct = HttPRequest.responseText;

if(myProduct != "")
{

var myArr = myProduct.split("|");

document.getElementById(product_id).value = myArr[0];
document.getElementById(product_name).value = myArr[1];
document.getElementById(unit_name).value = myArr[2];
document.getElementById(product_price).value = myArr[3];
document.getElementById(discount_unit).value = myArr[4];
document.getElementById(waranty).value = myArr[5];
	
}
}
}
}


function chkNumber(ele)

{

var vchar = String.fromCharCode(event.keyCode);
if ((vchar<'0' || vchar>'9') && (vchar != '.')) return false;
ele.onKeyPress=vchar;
}


</script>

<script src="dist/jautocalc.js"></script></head>
<body>

<style>
/* New styles for the modern product list */
.so-product-header-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
}
.so-product-title-text {
    font-size: 18px;
    font-weight: 600;
    color: #3B3B3B;
}
.so-product-count {
    font-size: 14px;
    color: #8E8B94;
}

.so-product-summary {
    display: flex;
    justify-content: space-between;
    background-color: #F4F3F7;
    border-radius: 12px;
    padding: 16px 24px;
    margin-bottom: 24px;
    text-align: center;
}
.so-product-summary-col {
    flex: 1;
    border-right: 1px solid #D9D9D9;
}
.so-product-summary-col:last-child {
    border-right: none;
}
.so-summary-label {
    font-size: 13px;
    color: #8E8B94;
    margin-bottom: 8px;
}
.so-summary-value {
    font-size: 20px;
    font-weight: 600;
    color: #333333;
}
.so-summary-value-net {
    font-size: 24px;
    color: #612989;
}

.so-product-search-bar {
    display: flex;
    align-items: center;
    background-color: #F4F3F7;
    border-radius: 8px;
    padding: 8px 16px;
    margin-bottom: 16px;
    width: 60%;
    max-width: 100%;
}
.so-product-search-bar input {
    border: none;
    background: transparent;
    width: 100%;
    outline: none;
    margin-left: 8px;
    font-size: 14px;
    font-family: 'Prompt', sans-serif;
}

.so-product-table {
    width: 100%;
    border-collapse: collapse;
}
.so-product-table th {
    color: #612989;
    font-weight: 600;
    font-size: 14px;
    text-align: left;
    padding: 12px 8px;
    border-top: 1px solid #612989;
    border-bottom: 1px solid #612989;
}
.so-product-table td {
    padding: 8px 4px;
    border-bottom: 1px solid #F0F0F0;
    vertical-align: middle;
}
.so-product-row {
    background-color: #FFFFFF;
}
.so-product-row.checked-row {
    background-color: #F4EFFF;
}
.so-pill-input {
    background-color: #F4F3F7;
    border: 1px solid transparent;
    border-radius: 8px;
    padding: 8px 12px;
    font-size: 13px;
    color: #333333;
    width: 100%;
    box-sizing: border-box;
    font-family: 'Prompt', sans-serif;
    outline: none;
}

.so-transparent-input {
    background-color: transparent !important;
    border: none !important;
    font-size: 13px;
    color: #8E8B94;
    width: 100%;
    outline: none;
    font-family: 'Prompt', sans-serif;
}
.so-transparent-input.product-code-input {
    color: #612989;
}
.so-transparent-input.calc-total {
    color: #333333;
    font-weight: 600;
}

.so-pill-input[readonly] {
    background-color: transparent;
}
.so-row-checkbox {
    appearance: none;
    -webkit-appearance: none;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background-color: #F4F3F7;
    outline: none;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin: 0;
}
.so-row-checkbox:checked {
    background-color: #612989;
}
.so-row-checkbox:checked::after {
    content: "\f00c";
    font-family: "Font Awesome 5 Free";
    font-weight: 900;
    color: white;
    font-size: 10px;
}
.drag-handle {
    cursor: grab;
    color: #8E8B94;
    margin-right: 8px;
}
.action-icon {
    cursor: pointer;
    color: #8E8B94;
    font-size: 16px;
    margin-left: 8px;
}
.action-icon:hover {
    color: #612989;
}

/* Modal Styling */
.so-modal-overlay {
    position: fixed;
    top: 0; left: 0; width: 100%; height: 100%;
    background: rgba(0,0,0,0.5);
    z-index: 9999;
    display: none;
    align-items: center;
    justify-content: center;
}
.so-modal-content {
    background: #FFF;
    border-radius: 12px;
    padding: 24px;
    width: 600px;
    max-width: 90%;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}
.so-modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
}
.so-modal-title {
    font-size: 18px;
    font-weight: 600;
    color: #612989;
    margin: 0;
}
.so-modal-close {
    background: none;
    border: none;
    font-size: 24px;
    cursor: pointer;
    color: #8E8B94;
}

/* Flex Grid for Modal */
.so-modal-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px; }
.so-modal-grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; margin-bottom: 16px; }
.so-modal-field label { display: block; font-size: 13px; color: #4A4A4A; margin-bottom: 4px; font-weight: 500; }
.so-modal-field input[type="text"], .so-modal-field textarea {
    width: 100%; padding: 8px 12px; border-radius: 8px; border: 1px solid #D9D9D9; background: #FFF;
    font-size: 13px; font-family: 'Prompt', sans-serif; outline: none; box-sizing: border-box;
}

.so-btn-primary { background: #612989; color: #FFF; border: none; padding: 8px 16px; border-radius: 8px; cursor: pointer; font-size: 14px; font-weight: 500; font-family: 'Prompt'; }
.so-btn-outline { background: #FFF; color: #612989; border: 1px solid #612989; padding: 8px 16px; border-radius: 8px; cursor: pointer; font-size: 14px; font-weight: 500; font-family: 'Prompt'; }
.so-btn-add-row { background: #F4F3F7; color: #612989; border: 1px dashed #612989; padding: 12px; border-radius: 8px; cursor: pointer; font-size: 14px; font-weight: 600; font-family: 'Prompt'; width: 100%; margin-top: 16px; display: flex; justify-content: center; align-items: center; gap: 8px; }

</style>

<div class="so-product-header-row">
    <div class="so-product-title-text">รายการสินค้า</div>
    <div class="so-product-count"><span id="total_items_count">0</span> รายการ</div>
</div>

<div class="so-product-summary">
    <div class="so-product-summary-col">
        <div class="so-summary-label">จำนวนรวม(ชิ้น)</div>
        <div class="so-summary-value" id="summary_total_qty">0</div>
    </div>
    <div class="so-product-summary-col">
        <div class="so-summary-label">ยอดรวม</div>
        <div class="so-summary-value" id="summary_total_amount">0.00</div>
    </div>
    <div class="so-product-summary-col">
        <div class="so-summary-label">ส่วนลดทั้งหมด</div>
        <div class="so-summary-value" id="summary_total_discount">0.00</div>
    </div>
    <div class="so-product-summary-col">
        <div class="so-summary-label">ยอดรวมสุทธิ</div>
        <div class="so-summary-value-net" id="summary_net_total">0.00</div>
    </div>
</div>

<div class="so-summary-label" style="color: #612989; margin-bottom: 4px; font-size: 12px; font-weight: 500;">ค้นหารายการสินค้า</div>
<div class="so-product-search-bar">
    <i class="fas fa-search" style="color: #333;"></i>
    <input type="text" id="global_product_search" placeholder="ค้นหาด้วยรหัสสินค้า / ชื่อสินค้า">
</div>

<table class="so-product-table" id="product_table">
    <thead>
        <tr>
            <th style="width: 50px;"></th>
            <th style="width: 15%; text-align: left;">รหัสสินค้า</th>
            <th style="width: 25%; text-align: left;">รายการสินค้า</th>
            <th style="width: 8%; text-align: center;">จำนวน</th>
            <th style="width: 15%; text-align: center;">ราคา/หน่วย</th>
            <th style="width: 12%; text-align: center;">ส่วนลด/หน่วย</th>
            <th style="width: 15%; text-align: center;">ยอดรวม</th>
            <th style="width: 10%;"></th>
        </tr>
    </thead>
    <tbody>

<?php for($i=1; $i<=30; $i++): ?>
    <tr class="so-product-row" id="product_row_<?php echo $i; ?>" <?php if($i>3) echo 'style="display:none;"'; ?>>
        <td style="text-align: center;">
            <i class="fas fa-grip-vertical drag-handle"></i>
            <input type="checkbox" class="so-row-checkbox" onchange="toggleRowHighlight(this, <?php echo $i; ?>)">
            
            <!-- Hidden inputs for backward compatibility -->
            <input type="hidden" name="h_product_codet<?php echo $i; ?>" id="h_product_codet<?php echo $i; ?>">
            <input type="hidden" name="h_product_code<?php echo $i; ?>" id="h_product_code<?php echo $i; ?>">
            <input type="hidden" name="h_product_c<?php echo $i; ?>" id="h_product_c<?php echo $i; ?>">
            <input type="hidden" name="product_id<?php echo $i; ?>" id="product_id<?php echo $i; ?>">
            <input type="hidden" name="unit_name<?php echo $i; ?>" id="unit_name<?php echo $i; ?>">
            
            <!-- Hidden fields for the modal -->
            <input type="hidden" name="warranty<?php echo $i; ?>" id="warranty<?php echo $i; ?>">
            <input type="hidden" name="cal<?php echo $i; ?>" id="cal<?php echo $i; ?>">
            <input type="hidden" name="pm<?php echo $i; ?>" id="pm<?php echo $i; ?>">
            <input type="hidden" name="sale_remarkk<?php echo $i; ?>" id="sale_remarkk<?php echo $i; ?>">
            <input type="hidden" name="clear_br<?php echo $i; ?>" id="clear_br<?php echo $i; ?>" value="1">
            <input type="hidden" name="clear_ivno<?php echo $i; ?>" id="clear_ivno<?php echo $i; ?>">
            <input type="hidden" name="jong_ckk<?php echo $i; ?>" id="jong_ckk<?php echo $i; ?>" value="1">
            <input type="hidden" name="jong_no<?php echo $i; ?>" id="jong_no<?php echo $i; ?>">
        </td>
        <td>
            <input type='text' name="product_codet<?php echo $i; ?>" id="product_codet<?php echo $i; ?>" class="so-transparent-input product-code-input" placeholder="" OnChange="JavaScript:doCallAjax('product_codet<?php echo $i; ?>','product_id<?php echo $i; ?>','product_name<?php echo $i; ?>','unit_name<?php echo $i; ?>','product_price<?php echo $i; ?>','discount_unit<?php echo $i; ?>','warranty<?php echo $i; ?>'); calculateSummary();"/> 
        </td>
        <td>
            <textarea name="product_name<?php echo $i; ?>" id="product_name<?php echo $i; ?>" class="so-transparent-input" rows="1" readonly style="resize:none; padding-top:10px;"></textarea>
        </td>
        <td>
            <input type='text' name="sale_count<?php echo $i; ?>" id="sale_count<?php echo $i; ?>" class="so-pill-input calc-qty" style="text-align:center" onkeyup="calculateSummary();" />
        </td>
        <td>
            <input type='text' name="product_price<?php echo $i; ?>" id="product_price<?php echo $i; ?>" class="so-pill-input calc-price" style="text-align:right" onkeyup="calculateSummary();" />
        </td>
        <td>
            <input type='text' name="discount_unit<?php echo $i; ?>" id="discount_unit<?php echo $i; ?>" class="so-pill-input calc-discount" style="text-align:right" onkeyup="calculateSummary();" />
        </td>
        <td>
            <input type='text' name="sum_amount<?php echo $i; ?>" id="sum_amount<?php echo $i; ?>" class="so-transparent-input calc-total" style="text-align:right;" readonly jAutoCalc="{sale_count<?php echo $i; ?>} * {product_price<?php echo $i; ?>} - {discount_unit<?php echo $i; ?>} * {sale_count<?php echo $i; ?>}" />
        </td>
        <td style="text-align: right; padding-right: 16px;">
            <i class="far fa-edit action-icon" onclick="openEditModal(<?php echo $i; ?>)"></i>
            <i class="far fa-trash-alt action-icon" onclick="clearRow(<?php echo $i; ?>)"></i>
        </td>
    </tr>
<?php endfor; ?>

    </tbody>
</table>

<button type="button" class="so-btn-add-row" onclick="addNewRow()"><i class="fas fa-plus"></i> เพิ่มรายการ</button>

<!-- Edit Modal -->
<div class="so-modal-overlay" id="productEditModal">
    <div class="so-modal-content">
        <div class="so-modal-header">
            <h3 class="so-modal-title">ข้อมูลเพิ่มเติม (แถวที่ <span id="modal_row_number"></span>)</h3>
            <button type="button" class="so-modal-close" onclick="closeEditModal()">&times;</button>
        </div>
        
        <input type="hidden" id="current_editing_row">
        
        <div class="so-modal-grid-3">
            <div class="so-modal-field">
                <label>รับประกัน (ปี)</label>
                <input type="text" id="m_warranty">
            </div>
            <div class="so-modal-field">
                <label>Cal(ครั้ง/ปี)</label>
                <input type="text" id="m_cal" onkeypress="return chkNumber(this)">
            </div>
            <div class="so-modal-field">
                <label>PM (ครั้ง/ปี)</label>
                <input type="text" id="m_pm" onkeypress="return chkNumber(this)">
            </div>
        </div>
        
        <div class="so-modal-field" style="margin-bottom:16px;">
            <label>หมายเหตุ</label>
            <textarea id="m_sale_remarkk" rows="2"></textarea>
        </div>
        
        <div class="so-modal-grid-2">
            <div class="so-modal-field">
                <label>เคลียร์ยืม (ใบแจ้ง/รหัส)</label>
                <input type="text" id="m_clear_ivno">
            </div>
            <div class="so-modal-field">
                <label>เคลียร์จอง (ใบจอง/รหัส)</label>
                <input type="text" id="m_jong_no">
            </div>
        </div>
        
        <div style="text-align: right; margin-top: 24px;">
            <button type="button" class="so-btn-outline" onclick="closeEditModal()">ยกเลิก</button>
            <button type="button" class="so-btn-primary" onclick="saveEditModal()" style="margin-left: 8px;">บันทึกข้อมูล</button>
        </div>
    </div>
</div>

<script>
function toggleRowHighlight(checkbox, rowIndex) {
    var row = document.getElementById('product_row_' + rowIndex);
    if (checkbox.checked) {
        row.classList.add('checked-row');
    } else {
        row.classList.remove('checked-row');
    }
}

function clearRow(rowIndex) {
    document.getElementById('product_codet' + rowIndex).value = '';
    document.getElementById('product_name' + rowIndex).value = '';
    document.getElementById('unit_name' + rowIndex).value = '';
    document.getElementById('product_price' + rowIndex).value = '';
    document.getElementById('sale_count' + rowIndex).value = '';
    document.getElementById('sum_amount' + rowIndex).value = '';
    document.getElementById('discount_unit' + rowIndex).value = '';
    document.getElementById('product_id' + rowIndex).value = '';
    document.getElementById('product_row_' + rowIndex).style.display = 'none';
    calculateSummary();
}

function addNewRow() {
    for (let i = 1; i <= 30; i++) {
        let row = document.getElementById('product_row_' + i);
        if (row.style.display === 'none') {
            row.style.display = '';
            break;
        }
    }
}

function openEditModal(rowIndex) {
    document.getElementById('current_editing_row').value = rowIndex;
    document.getElementById('modal_row_number').innerText = rowIndex;
    
    // Load data from hidden inputs
    document.getElementById('m_warranty').value = document.getElementById('warranty' + rowIndex).value;
    document.getElementById('m_cal').value = document.getElementById('cal' + rowIndex).value;
    document.getElementById('m_pm').value = document.getElementById('pm' + rowIndex).value;
    document.getElementById('m_sale_remarkk').value = document.getElementById('sale_remarkk' + rowIndex).value;
    document.getElementById('m_clear_ivno').value = document.getElementById('clear_ivno' + rowIndex).value;
    document.getElementById('m_jong_no').value = document.getElementById('jong_no' + rowIndex).value;
    
    document.getElementById('productEditModal').style.display = 'flex';
}

function closeEditModal() {
    document.getElementById('productEditModal').style.display = 'none';
}

function saveEditModal() {
    var rowIndex = document.getElementById('current_editing_row').value;
    
    // Save data back to hidden inputs
    document.getElementById('warranty' + rowIndex).value = document.getElementById('m_warranty').value;
    document.getElementById('cal' + rowIndex).value = document.getElementById('m_cal').value;
    document.getElementById('pm' + rowIndex).value = document.getElementById('m_pm').value;
    document.getElementById('sale_remarkk' + rowIndex).value = document.getElementById('m_sale_remarkk').value;
    document.getElementById('clear_ivno' + rowIndex).value = document.getElementById('m_clear_ivno').value;
    document.getElementById('jong_no' + rowIndex).value = document.getElementById('m_jong_no').value;
    
    closeEditModal();
}

function calculateSummary() {
    setTimeout(function() {
        let totalQty = 0;
        let totalAmount = 0;
        let totalDiscount = 0;
        let itemsCount = 0;
        
        for (let i = 1; i <= 30; i++) {
            let row = document.getElementById('product_row_' + i);
            if (row.style.display !== 'none') {
                let code = document.getElementById('product_codet' + i).value;
                if (code && code.trim() !== '') itemsCount++;
            }
            
            let qtyStr = document.getElementById('sale_count' + i).value;
            let priceStr = document.getElementById('product_price' + i).value;
            let discStr = document.getElementById('discount_unit' + i).value;
            
            let qty = parseFloat(qtyStr.replace(/,/g, '')) || 0;
            let price = parseFloat(priceStr.replace(/,/g, '')) || 0;
            let disc = parseFloat(discStr.replace(/,/g, '')) || 0;
            
            totalQty += qty;
            totalAmount += (qty * price);
            totalDiscount += (disc * qty);
        }
        
        let netTotal = totalAmount - totalDiscount;
        
        document.getElementById('total_items_count').innerText = itemsCount;
        document.getElementById('summary_total_qty').innerText = totalQty.toLocaleString(undefined, {minimumFractionDigits: 0});
        document.getElementById('summary_total_amount').innerText = totalAmount.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
        document.getElementById('summary_total_discount').innerText = totalDiscount.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
        document.getElementById('summary_net_total').innerText = netTotal.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
    }, 200); // Slight delay to let jAutoCalc run first
}

// Global search simple filter
document.getElementById('global_product_search').addEventListener('keyup', function() {
    let filter = this.value.toUpperCase();
    for (let i = 1; i <= 30; i++) {
        let row = document.getElementById('product_row_' + i);
        if (row.style.display !== 'none') {
            let codeInput = document.getElementById('product_codet' + i);
            let nameInput = document.getElementById('product_name' + i);
            let code = codeInput ? codeInput.value.toUpperCase() : "";
            let name = nameInput ? nameInput.value.toUpperCase() : "";
            
            if (code.indexOf(filter) > -1 || name.indexOf(filter) > -1) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }
    }
    if (filter === '') {
        // Restore visibility logic (e.g. show first 3, hide rest unless filled)
        for (let i = 1; i <= 30; i++) {
            let row = document.getElementById('product_row_' + i);
            let codeInput = document.getElementById('product_codet' + i);
            if (i <= 3 || (codeInput && codeInput.value.trim() !== '')) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }
    }
});

// Run initial calc
window.onload = function() {
    calculateSummary();
};
</script>

<?php for($i=1; $i<=30; $i++): ?>
<script type="text/javascript">
function make_autocom_<?php echo $i; ?>(autoObj,showObj){
	var mkAutoObj=autoObj; 
	var mkSerValObj=showObj; 
	new Autocomplete(mkAutoObj, function() {
		this.setValue = function(id) {		
			document.getElementById(mkSerValObj).value = id;
		}
		if ( this.isModified )
			this.setValue("");
		if ( this.value.length < 1 && this.isNotClick ) 
			return ;	
		return "data_pro_notdemoth.php?product_code_search=" +encodeURIComponent(this.value);
    });	
}	
if(document.getElementById("product_codet<?php echo $i; ?>")) { make_autocom_<?php echo $i; ?>("product_codet<?php echo $i; ?>","h_product_codet<?php echo $i; ?>"); }
if(document.getElementById("product_c<?php echo $i; ?>")) { make_autocom_<?php echo $i; ?>("product_c<?php echo $i; ?>","h_product_c<?php echo $i; ?>"); }
</script>
<?php endfor; ?>

</body>
</html>
