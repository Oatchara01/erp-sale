<script>
////////////////คำนวนราคา////////////////////////////////////////////////////////
function chk(){

var cal_qty_1=parseFloat(document.frsparepart_add.qty_1.value);
var cal_unit_price_1=parseFloat(document.frsparepart_add.unit_price_1.value);
document.frsparepart_add.amount_1.value=cal_qty_1*cal_unit_price_1;

var cal_qty_2=parseFloat(document.frsparepart_add.qty_2.value);
var cal_unit_price_2=parseFloat(document.frsparepart_add.unit_price_2.value);
document.frsparepart_add.amount_2.value=cal_qty_2*cal_unit_price_2;

var cal_qty_3=parseFloat(document.frsparepart_add.qty_3.value);
var cal_unit_price_3=parseFloat(document.frsparepart_add.unit_price_3.value);
document.frsparepart_add.amount_3.value=cal_qty_3*cal_unit_price_3;

var cal_qty_4=parseFloat(document.frsparepart_add.qty_4.value);
var cal_unit_price_4=parseFloat(document.frsparepart_add.unit_price_4.value);
document.frsparepart_add.amount_4.value=cal_qty_4*cal_unit_price_4;

var cal_qty_5=parseFloat(document.frsparepart_add.qty_5.value);
var cal_unit_price_5=parseFloat(document.frsparepart_add.unit_price_5.value);
document.frsparepart_add.amount_5.value=cal_qty_5*cal_unit_price_5;

var cal_qty_6=parseFloat(document.frsparepart_add.qty_6.value);
var cal_unit_price_6=parseFloat(document.frsparepart_add.unit_price_6.value);
document.frsparepart_add.amount_6.value=cal_qty_6*cal_unit_price_6;

var cal_qty_7=parseFloat(document.frsparepart_add.qty_7.value);
var cal_unit_price_7=parseFloat(document.frsparepart_add.unit_price_7.value);
document.frsparepart_add.amount_7.value=cal_qty_7*cal_unit_price_7;

document.frsparepart_add.total.value=(cal_qty_1*cal_unit_price_1)+(cal_qty_2*cal_unit_price_2)+(cal_qty_3*cal_unit_price_3)+(cal_qty_4*cal_unit_price_4)+(cal_qty_5*cal_unit_price_5)+(cal_qty_6*cal_unit_price_6)+(cal_qty_7*cal_unit_price_7)
}

</script>