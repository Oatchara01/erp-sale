<style>
body {
  font-family: arial;
}
.hide {
  display: none;
}
p {
  font-weight: bold;
}
</style>
<script>
function option1(){
  document.getElementById('div1').style.display ='none';
}
function option2(){
  document.getElementById('div1').style.display = 'block';
}
function option3(){
  document.getElementById('div1').style.display = 'none';
}
function option4(){
  document.getElementById('div1').style.display = 'block';
}
function option5(){
  document.getElementById('div1').style.display = 'block';
}
</script>
<p>How many check boxes do you want when clicked on a radio button?</p>
<input type="radio" name="tab" value="1" onclick="option1();" />
เป็นสินค้าสำรอง
<input type="radio" name="tab" value="2" onclick="option2();" />
สำหรับลูกค้าทดลองใช้
<div id="div1" style="display:none">
<input type="text" name="withdraw_description" class="w3-input" placeholder="ใส่จำนวนวันที่ต้องการยืม">
</div>
<input type="radio" name="tab" value="3" onclick="option3();" />
จัดส่งสินค้าล่วงหน้าเพื่อรอใบสั่งซื้อ
<input type="radio" name="tab" value="4" onclick="option4();" />
แลกเปลี่ยนสินค้าตามใบงานบริการเลขที่
<div id="div1" style="display:none">
<input type="text" name="withdraw_description" class="w3-input" placeholder="ใส่เลขที่ใบงานบริการ">
</div>
