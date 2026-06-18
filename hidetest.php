<style>
.none {
    display:none;
}
</style>
<script>
	function object() {
		if (document.getElementById('object1').checked) {
			document.getElementById('dt1').style.display = 'block';
			document.getElementById('dt2').style.display = 'none';
			document.getElementById('dt4').style.display = 'none';
			document.getElementById('dt5').style.display = 'none';
		}
		else if (document.getElementById('object2').checked) {
			document.getElementById('dt1').style.display = 'none';
			document.getElementById('dt2').style.display = 'block';
			document.getElementById('dt4').style.display = 'none';
			document.getElementById('dt5').style.display = 'none';
		}
		else if (document.getElementById('object4').checked) {
			document.getElementById('dt1').style.display = 'none';
			document.getElementById('dt2').style.display = 'none';
			document.getElementById('dt4').style.display = 'block';
			document.getElementById('dt5').style.display = 'none';
		}
		else if (document.getElementById('object5').checked) {
			document.getElementById('dt1').style.display = 'none';
			document.getElementById('dt2').style.display = 'none';
			document.getElementById('dt4').style.display = 'none';
			document.getElementById('dt5').style.display = 'block';
		}
	}
</script>
<input type="radio" onclick="javascript:object();" name="yesno" value="1" id="object1"> เป็นสินค้าสำรอง<br>
    <div id="dt1" style="display:none">
        <input type="text" name="withdraw_description" class="w3-input" placeholder="ใส่รายละเอียด">
    </div>
<input type="radio" onclick="javascript:object();" name="yesno" value="2" id="object2"> สำหรับลูกค้าทดลองใช้<br>
    <div id="dt2" style="display:none">
        <input type="text" name="withdraw_description" class="w3-input" placeholder="ใส่จำนวนวัน">
    </div>
<input type="radio" onclick="javascript:object();" name="yesno" value="3" id="object3"> ส่งสินค้าล่วงหน้าเพื่อรอใบสั่งซื้อ<br>
<input type="radio" onclick="javascript:object();" name="yesno" value="3" id="object4"> แลกเปลี่ยนสินค้าตามใบงานบริการเลขที่<br>
    <div id="dt4" style="display:none">
        <input type="text" name="withdraw_description" class="w3-input" placeholder="ใส่เลขที่ใบงานบริการ">
    </div>
<input type="radio" onclick="javascript:object();" name="yesno" value="3" id="object5"> อื่น ๆ
    <div id="dt5" style="display:none">
        <input type="text" name="withdraw_description" class="w3-input" placeholder="ใส่รายละเอียดเพิ่มเติม">
    </div>