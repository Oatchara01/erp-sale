
<html>
<head>
<title>SOL : ITEAMDEV</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="dist/jautocalc.js"></script></head>
<body>
 <center>
 <form action="save.php" id="frmMain" name="frmMain" method="post">



<input type="text" name="qty" value="">

<input type="text" name="price" value="">

<input type="text" name="item_total" value="" jAutoCalc="{qty} * {price}">

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
</body>
<script src="myjs.js"></script>
</html>