<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Signature Pad</title>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> 
<link type="text/css" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css" rel="stylesheet"> 
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/jquery.ui.touch-punch.js"></script>
<link type="text/css" href="css/jquery.signature.css" rel="stylesheet"> 
<script type="text/javascript" src="js/jquery.signature.js"></script>
  <link type="text/css" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css" rel="stylesheet"> 
  <link type="text/css" href="css/jquery.signature.css" rel="stylesheet"> 
  <style>
    .signature-pad {
      width: 400px;
      height: 200px;
      border: 1px solid #000;
    }
  </style>
</head>
<body>
	
<script type="text/javascript">
$(document).ready(function(){
    $('#captureSignature').signature({syncField: '#signatureJSON'}); 
    
    $('#clear2Button').click(function() { 
        $('#captureSignature').signature('clear'); 
    }); 
    
    $('input[name="syncFormat"]').change(function() { 
        var syncFormat = $('input[name="syncFormat"]:checked').val(); 
        $('#captureSignature').signature('option', 'syncFormat', syncFormat); 
    }); 
    
    $('#svgStyles').change(function() { 
        $('#captureSignature').signature('option', 'svgStyles', $(this).is(':checked')); 
    });
});
</script>	

<div class="signature-pad">
  <canvas id="captureSignature" width="400" height="200"></canvas>
</div>
<button id="captureSignature">Clear Signature</button>
<button id="saveSignature">Save Signature</button>

<!-- Include jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- Include jQuery UI -->
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<!-- Include jQuery Signature Plugin -->
<script src="js/jquery.signature.js"></script>

<script>
$(document).ready(function() {
  // Initialize signature pad
  var signaturePad = $('#signatureCanvas').signature();

  // Clear signature button click event
  $('#clearSignature').click(function() {
    signaturePad.signature('clear');
  });

  // Save signature button click event
  $('#saveSignature').click(function() {
    // Get signature data in JSON format
    var signatureData = signaturePad.signature('toJSON');
    // You can now send this data to your server using AJAX for further processing
    console.log(signatureData);
    alert("Signature saved!");
  });
});
</script>

</body>
</html>
