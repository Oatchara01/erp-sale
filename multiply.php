<script>
$(document).ready(function(){
 
  $("#answer").click(function(){
    $("#txt3").val()=$("#txt2").val() * $("#txt1").val();
  });
   $("#clear").click(function(){
    $("#txt3").val()=0;
  });
 
  
});
</script>
</head>

<body>

<div id="two">

</div>
<input  size="10" id="txt1" /> X 
<input size="10" id="txt2" />=
<input size="10" id="txt3" />
<button  id="answer">answer</button>
<button id="clear">Clear</button>

</body>
</html>