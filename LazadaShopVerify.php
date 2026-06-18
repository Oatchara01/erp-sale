<script type="text/javascript" src="//laz-g-cdn.alicdn.com/sj/securesdk/0.0.3/securesdk_lzd_v1.js" id="J_secure_sdk_v2" data-appkey="124441"></script>
<?php
include "databaseHelper.php";
include "LazadaAPI.php";
?>

<style type="text/css">
<!--
.style15 {
	font-size: 18px; color: #000000;
}
.style30 {font-size: 12; }
.style32 {font-size: 11px}
.style33 {font-size: 12px; }
.style34 {color: #FF0000}
.style35 {font-size: 14px; color: #f2f2f2; }
.style37 {color: #FF0000; font-size: 14px; }
.style38 {color: #f2f2f2}
.style39 {font-size: 14px; color: #000000;}
.style40 {font-size: 14px; color: #FF0000; }
-->

.button {
    background-color: #339900;
    border: none;
    color: white;
    padding: 14px 16px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
}

.button1 {border-radius: 2px;}
.button2 {border-radius: 4px;}
.button3 {border-radius: 8px;}
.button4 {border-radius: 12px;}
.button5 {border-radius: 50%;}
</style>



<form name="frmSearch" method="GET" action="getOrders.php">

<?php
	//<form action = "getOrders.php?running=4"  method="GET" name="frmMain" enctype="multipart/form-data" >
$code = $_GET["code"]; //authen code from Lazada when shop login
	

$obj = getAccessToken($code);
	//echo $obj = getAccessToken($code);
	
?>
<center>
<?php
	if (saveShopToken($obj)) {
    echo "New record created successfully";
		//exit();
	?>

	วันที่ :
<input name="start_date" type="date" id="start_date" class="button4" >

	<input name="time_start" type="time" id="time_start" class="button4" >
	<input type="hidden"   name='running'  value="1" class = "button button4">
		 <input type="submit" value="Search" class="button button4">


<?php
} else {
    echo "Save error";
}
	?>
	</center>
</form>
