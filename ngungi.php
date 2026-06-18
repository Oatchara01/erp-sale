<html>
<script>
function toggleField(hideObj,showObj){
  hideObj.disabled=true;        
  hideObj.style.display='none';
  showObj.disabled=false;   
  showObj.style.display='inline';
  showObj.focus();
}
</script>
<body>
<form name="BrowserSurvey" action="#">
Browser: <select name="browser" 
          onchange="if(this.options[this.selectedIndex].value=='customOption'){
              toggleField(this,this.nextSibling);
              this.selectedIndex='0';
          }">
            <option></option>
            
            <option>Chrome</option>
            <option>Firefox</option>
            <option>Internet Explorer</option>
            <option>Opera</option>
            <option>Safari</option>
			<option value="customOption">[อื่น ๆ (พิมพ์)]</option>
        </select><input name="browser" style="display:none;" disabled="disabled" 
            onblur="if(this.value==''){toggleField(this,this.previousSibling);}">
<input type="submit" value="Submit">
</form>
</body>
</html>