<head>
<?php
	//header("Content-type: application/vnd.ms-word");
	//header("Content-Disposition: attachment; filename=testing.doc");
	include "src/BarcodeGenerator.php";
	include "src/BarcodeGeneratorHTML.php";
	include "src/BarcodeGeneratorPNG.php";
	function barcode($code){
		$generator = new Picqer\Barcode\BarcodeGeneratorHTML();
		$border = 1.0;//กำหนดความหน้าของเส้น Barcode
		$height = 20;//กำหนดความสูงของ Barcode
		
		return $generator->getBarcode($code , $generator::TYPE_CODE_128,$border,$height);
	}

	date_default_timezone_set("Asia/Bangkok");
	function DateThai($strDate)	{
		$strYear = date("Y",strtotime($strDate))+543;
		$strMonth= date("n",strtotime($strDate));
		$strDay= date("j",strtotime($strDate));
		$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		$strMonthThai=$strMonthCut[$strMonth];
		return "$strDay $strMonthThai $strYear";
	}
?>
<link rel="stylesheet" href="css/w3.css">
</head>
<!-- PHP -->
<?php
	include('dbconnect.php');
	if($_GET['ref_id']) {
		$ref_id = $_GET['ref_id'];
		$view = "select * from hos__so where ref_id='$ref_id'";
		$qview = mysqli_query($conn,$view);
		$fview = mysqli_fetch_array($qview,MYSQLI_ASSOC);
	}
?>
<!-- PHP -->
<body class="w3-container">
	<div class="w3-bar">
		<div class="w3-third 1">
			<img src="img/unc16.png"> <span>ก</span>
			<img src="img/unc16.png"> <span>C</span>
		</div>
		<div class="w3-twothird 2">
			<h3>ใบสั่งขาย</h3>(SALES ORDER)
		</div>
	</div>
	<div class="w3-bar">
		<div class="w3-half">
			<div class="w3">
		</div>
		<div class="w3-half">
			<span class="w3-right">ฝากสินค้าเลขที่</span><br>
			<span class="w3-right">วันที่ <u><?php echo datethai($fview['date']); ?></u></span>
		</div>
	</div>
</body>