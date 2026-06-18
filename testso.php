<?php
	function convert() {
		$a=date("Y")+543;
		$b=substr($a,2,3);
		echo "SO".$b;
	}
	include("dbconnect.php");
	include("head.php");
	$get="select LPAD(MAX(ref_id)+1,3,'0') as mref_id from hos__so";
	$qget=mysqli_query($conn,"select LPAD(MAX(ref_id)+1,3,'0') as mref_id from hos__so");$no=mysqli_fetch_array($qget);
	
	$ref_id=convert().date("m").$no["mref_id"];
	echo $ref_id;
	//$no=mysqli_fetch_array($qget); ?>