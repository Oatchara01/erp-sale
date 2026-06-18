// myjs.js
Number.prototype.comma=function(digit=0){
	var p = this.toString().split("."), pat = new RegExp("/\B(?=(\d{3})+(?!\d))/g");
	var d = p[0].replace( pat , ",");
	if(p.length>1){if(digit>0){ d+='.'+(p[1]+'0'.repeat(digit)).substr(0,digit);}}
	else if(digit>0){ var a='.'+('0'.repeat(digit));d+=a;}
	return d;
};
$(document).delegate('.calc','change',function(){
	var pat = /[^\d\.]/, inp = $(this).parents('tr').find('input'), old = $(this).data('old')*1;
	if( pat.test(inp[1]) || pat.test(inp[2]) ){alert('กรุณากรอกเฉพาะจำนวนตัวเลข และจุดทศนิยม'); this.value = old; return;}
	if(inp[1].value.length<1 || inp[2].value.length<1 ){ alert('กรุณากรอกข้อมูล'); this.value = old; return;}
	var q = inp[1].value * 1, a = inp[2].value * 1, value = q * a;	
	var ttl = $('#sum_ttl').data('val') * 1 + value;
	if($(this).data('t')=='q'){
			ttl -= (a * old); $(this).data('old', q);
	}else{	ttl -= (q * old); $(this).data('old', a);}
	inp[3].value = value.comma(2);
	$('#sum_ttl').data('val',ttl).html(ttl.comma(2));
	
}).delegate('.calc','focusin',function(){
	$(this).data('old', $(this).val());
}).delegate('.del','click',function(){
	if(confirm('ต้องการลบรายการ')){
		var tr = $(this).parents('tr');
		var value = $(tr).find('input:last').val()*1;
		$(tr).remove(); 
		var ttl = $('#sum_ttl').data('val') * 1 - value;
		$('#sum_ttl').data('val',ttl).html(ttl.comma(2));		
	}
}).ready(()=>{
	$('#add').click(()=>{
		$('tbody').append('<tr class="row">'+$('#template').html().replace(/pf_/g,'')+'</tr>');
	}).click();	
});