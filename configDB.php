<script type="text/javascript" src="//laz-g-cdn.alicdn.com/sj/securesdk/0.0.3/securesdk_lzd_v1.js" id="J_secure_sdk_v2" data-appkey="124441"></script>
<?php
function OpenCon()
{
    $servername = "localhost"; //for docker use replace localhost with db
    //$username = "allwell_sol";
	$username = "allwell_itadmin";
    //$password = "ptl@1234";
	$password = "Pass@2020";
    $dbname = "allwell_sol";
    $conn = new mysqli($servername, $username, $password, $dbname) or die("Connect failed: %s\n". $conn -> error);
	//$conn = mysqli_connect("localhost","allwell_itadmin","Pass@2020","allwell_sol");
	
    $conn -> set_charset("utf8");
    return $conn;
}

function CloseCon($conn)
{
    $conn -> close();
}
