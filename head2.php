<?php
	session_start();
	if($_SESSION['UserID'] == "")
	{
		echo "Please Login!";
		header("location:index.php");
		exit();
	}
?>
<!DOCTYPE html>
<html>
<title>SOL :: ITEAMDEV</title>
<meta name="viewport" content="width=device-width, initial-scale=1" charset="utf8">
<link rel="stylesheet" href="css/w3.css">
<link rel="stylesheet" href="css/tab.css">
<link rel="stylesheet" href="awesome/css/all.css">
<script type="text/javascript" src="js/w3open.js"></script>
<script type="text/javascript" src="js/tab.js"></script>
<script type="text/javascript" src="js/ready.js"></script>
<script type="text/javascript" src="js/table.js"></script>
<script src="js/jquery-3.4.1.min.js" type="text/javascript"></script>
<script type="text/javascript" src="dist/jautocalc.js"></script>
<script> //tab
function showUser(str) {
    if (str == "") {
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else { 
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("txtHint").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","getuser.php?q="+str,true);
        xmlhttp.send();
    }
}

function showUser2(str) {
    if (str2 == "") {
        document.getElementById("txtHint2").innerHTML = "";
        return;
    } 
	if (str3 == "") {
		document.getElementById("txtHint3").innerHTML = "";
        return;
	}
	else { 
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState2 == 4 && this.status == 200) {
                document.getElementById("txtHint2").innerHTML = this.responseText;
            }
			if (this.readyState3 == 4 && this.status == 200) {
                document.getElementById("txtHint3").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","getuser2.php?q="+str2"&u="+str3,true);
        xmlhttp.send();
    }
}

function getText3(){
      var in1=document.getElementById('in1').value;
      var in2=document.getElementById('in2').value;
      var in3=in1+in2;
      document.getElementById('in3').value=in3;
   }

function openCity(cityName) {
  var i;
  var x = document.getElementsByClassName("city");
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";  
  }
  document.getElementById(cityName).style.display = "block";  
}
</script>
<script>
function openCity1(cityName) {
  var i;
  var x = document.getElementsByClassName("city1");
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";  
  }
  document.getElementById(cityName).style.display = "block";  
}
</script>
<style>
#inner {
  display: table;
  margin: 0 auto;
  border: 0px solid black;
}

#outer {
  border: 0px solid red;
  width:100%
}

a:link {
  text-decoration: none;
}

a:visited {
  text-decoration: none;
}

a:hover {
  text-decoration: none;
}

a:active {
  text-decoration: none;
}
</style>
<?php
function DateThai($strDate)
	{
		$strYear = date("Y",strtotime($strDate))+543;
		$strMonth= date("n",strtotime($strDate));
		$strDay= date("j",strtotime($strDate));
		$strHour= date("H",strtotime($strDate));
		$strMinute= date("i",strtotime($strDate));
		$strSeconds= date("s",strtotime($strDate));
		$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		$strMonthThai=$strMonthCut[$strMonth];
		return "$strDay $strMonthThai $strYear";
	}
?>
<?php include('dbconnect.php'); ?>
<body>
<?php /*if ($_SESSION['type_login']=='Office') { ?>
<!-- Sidebar -->
<div class="w3-sidebar w3-bar-block w3-border-right" style="display:none" id="mySidebar">
  <button onclick="w3_close()" class="w3-bar-item w3-large">Close &times;</button>
  <a href="register_office.php" class="w3-bar-item w3-button">ลงทะเบียน Office</a>
  <a href="status_office.php" class="w3-bar-item w3-button">Status</a>
  <a href="main_report.php" class="w3-bar-item w3-button">รายงาน</a>
  <a href="change_pass.php" class="w3-bar-item w3-button">เปบี่ยน Password</a>
  <a href="logout.php" class="w3-bar-item w3-button">ออกจากระบบ<br />(คุณ<?php echo $_SESSION['name']; ?>&nbsp;<?php echo $_SESSION['surname']; ?>)</a>
</div>

<!-- Page Content -->
<div class="w3-deep-purple w3-bar w3-small">
  <button class="w3-button w3-deep-purple w3-medium" onclick="w3_open()">☰</button>
  <div class="w3-center">
    <h1>Sale Online</h1>
  </div>
</div>
<?php } ?>

<?php if ($_SESSION['type_login'] == 'Admin') { ?>
<!-- Sidebar -->
<div class="w3-sidebar w3-bar-block w3-border-right" style="display:none" id="mySidebar">
  <button onclick="w3_close()" class="w3-bar-item w3-large">Close &times;</button>
  <a href="register_admin.php" class="w3-bar-item w3-button">ลงทะเบียน Admin</a>
  <a href="status_admin.php" class="w3-bar-item w3-button">Status All</a>
  <a href="main_report.php" class="w3-bar-item w3-button">รายงาน</a>
  <a href="change_pass.php" class="w3-bar-item w3-button">เปบี่ยน Password</a>
  <a href="logout.php" class="w3-bar-item w3-button">ออกจากระบบ<br />(คุณ<?php echo $_SESSION['name']; ?>&nbsp;<?php echo $_SESSION['surname']; ?>)</a>
</div>

<!-- Page Content -->
<div class="w3-deep-purple w3-bar w3-small">
  <button class="w3-button w3-deep-purple w3-medium" onclick="w3_open()">☰</button>
  <div class="w3-center">
    <h1>Sale Online</h1>
  </div>
</div>
<?php } ?>

<?php if ($_SESSION['type_login'] == 'Stock') { ?>
<!-- Sidebar -->
<div class="w3-sidebar w3-bar-block w3-border-right" style="display:none" id="mySidebar">
  <button onclick="w3_close()" class="w3-bar-item w3-large">Close &times;</button>
  <a href="register_stock.php" class="w3-bar-item w3-button">ลงทะเบียน Stock</a>
  <a href="status_stock.php" class="w3-bar-item w3-button">Status</a>
  <a href="main_report.php" class="w3-bar-item w3-button">รายงาน</a>
  <a href="change_pass.php" class="w3-bar-item w3-button">เปบี่ยน Password</a>
  <a href="logout.php" class="w3-bar-item w3-button">ออกจากระบบ<br />(คุณ<?php echo $_SESSION['name']; ?>&nbsp;<?php echo $_SESSION['surname']; ?>)</a>
</div>

<!-- Page Content -->
<div class="w3-deep-purple w3-bar w3-small">
  <button class="w3-button w3-deep-purple w3-medium" onclick="w3_open()">☰</button>
  <div class="w3-center">
    <h1>Sale Online</h1>
  </div>
</div>
<?php } ?>

<?php if ($_SESSION['type_login'] == 'Account') { ?>
<!-- Sidebar -->
<div class="w3-sidebar w3-bar-block w3-border-right" style="display:none" id="mySidebar">
  <button onclick="w3_close()" class="w3-bar-item w3-large">Close &times;</button>
  <a href="#" class="w3-bar-item w3-button">Link 1</a>
  <a href="#" class="w3-bar-item w3-button">Link 2</a>
  <a href="#" class="w3-bar-item w3-button">Link 3</a>
</div>

<!-- Page Content -->
<div class="w3-deep-purple w3-bar w3-small">
  <button class="w3-button w3-deep-purple w3-medium" onclick="w3_open()">☰</button>
  <div class="w3-center">
    <h1>Sale Online</h1>
  </div>
</div>
<?php } ?>

<?php if ($_SESSION['type_login'] == 'It') { ?>
<!-- Sidebar -->
<div class="w3-sidebar w3-bar-block w3-border-right" style="display:none" id="mySidebar">
  <button onclick="w3_close()" class="w3-bar-item w3-large">Close &times;</button>
  <a href="register_office.php" class="w3-bar-item w3-button">ลงทะเบียน Office</a>
  <a href="register_admin.php" class="w3-bar-item w3-button">ลงทะเบียน Admin</a>
  <a href="register_stock.php" class="w3-bar-item w3-button">ลงทะเบียน Stock</a>
  <a href="status_admin.php" class="w3-bar-item w3-button">Status All</a>
  <a href="main_report.php" class="w3-bar-item w3-button">รายงาน</a>
  <a href="change_pass.php" class="w3-bar-item w3-button">เปบี่ยน Password</a>
  <a href="logout.php" class="w3-bar-item w3-button">ออกจากระบบ<br />(คุณ<?php echo $_SESSION['name']; ?>&nbsp;<?php echo $_SESSION['surname']; ?>)</a>
</div>

<!-- Page Content -->
<div class="w3-deep-purple w3-bar w3-small">
  <button class="w3-button w3-deep-purple w3-medium" onclick="w3_open()">☰</button>
  <div class="w3-center">
    <h1>Sale Online</h1>
  </div>
</div>
<?php } ?>

<?php if ($_SESSION['type_login'] == '') { ?>
<!-- Sidebar -->
<!-- Page Content -->
<div class="w3-deep-purple w3-bar w3-small">
  <button class="w3-button w3-deep-purple w3-medium" onclick="w3_open()">☰</button>
  <div class="w3-center">
    <h1>Sale Online</h1>
  </div>
</div>
<?php }*/ ?>