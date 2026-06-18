<?php

//ini_set('session.gc_maxlifetime', 1800); // 30 นาที
//ini_set('session.cookie_lifetime', 1800); // 30 นาที

session_start();
//ob_start();
//include('check_login.php');
//echo $_SESSION['code'];
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(~E_NOTICE);

	
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
<link rel="shortcut icon" href="allwell.png" />
<!--meta name="viewport" content="width=device-width, initial-scale=-1" charset="utf8"-->
<link rel="stylesheet" href="css/w3.css">
<link rel="stylesheet" href="css/style.css?v=<?php echo time(); ?>">
<link rel="stylesheet" href="css/tab.css">
<link rel="stylesheet" href="awesome/css/all.css">
<link rel="stylesheet" href="css/autocomplete.css"  type="text/css"/>
<script type="text/javascript" src="js/autocomplete.js"></script>
<script type="text/javascript" src="js/w3open.js"></script>
<script type="text/javascript" src="js/tab.js"></script>
<script type="text/javascript" src="js/ready.js"></script>
<script type="text/javascript" src="js/table.js"></script>
<script src="js/jquery-3.4.1.min.js" type="text/javascript"></script>
<script src="js/jquery-3.4.1.js" type="text/javascript"></script>


	<script> //tab
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

function sortTable(n) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("myTable");
  switching = true;
  //Set the sorting direction to ascending:
  dir = "asc"; 
  /*Make a loop that will continue until
  no switching has been done:*/
  while (switching) {
    //start by saying: no switching is done:
    switching = false;
    rows = table.rows;
    /*Loop through all table rows (except the
    first, which contains table headers):*/
    for (i = 1; i < (rows.length - 1); i++) {
      //start by saying there should be no switching:
      shouldSwitch = false;
      /*Get the two elements you want to compare,
      one from current row and one from the next:*/
      x = rows[i].getElementsByTagName("TD")[n];
      y = rows[i + 1].getElementsByTagName("TD")[n];
      /*check if the two rows should switch place,
      based on the direction, asc or desc:*/
      if (dir == "asc") {
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
          //if so, mark as a switch and break the loop:
          shouldSwitch= true;
          break;
        }
      } else if (dir == "desc") {
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
          //if so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
        }
      }
    }
    if (shouldSwitch) {
      /*If a switch has been marked, make the switch
      and mark that a switch has been done:*/
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      //Each time a switch is done, increase this count by 1:
      switchcount ++;      
    } else {
      /*If no switching has been done AND the direction is "asc",
      set the direction to "desc" and run the while loop again.*/
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
}

function myFunction() {
  var x = document.getElementById("Demo");
  if (x.className.indexOf("w3-show") == -1) {  
    x.className += " w3-show";
  } else { 
    x.className = x.className.replace(" w3-show", "");
  }
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
<?php include('dbconnect.php');
	 include('dbconnect_acc.php');
	include('dbconnect_sale.php');
	include('dbconnect_cs.php');
	?>



<!-- Navbar (sit on top) -->
<?php if ($_SESSION['type_login']=='It') {   require('menu_it.php'); } //require('new_menu_salehos.php'); } ?>

<?php if ($_SESSION['type_login']=='AllWell') { require('menu_allwell.php'); } ?>

<?php if ($_SESSION['type_login']=='Sale') { require('menu_salehos.php'); } //new_menu_salehos ?>

<?php if ($_SESSION['type_login']=='Sup_Sale') { require('menu_suphos.php'); }   //new_menu_suphos ?>

<?php if ($_SESSION['type_login']=='Stock') { require('menu_stock.php'); } ?>

<?php if ($_SESSION['type_login']=='Admin') { require('menu_admin.php'); } ?>

<?php if ($_SESSION['type_login']=='Sup_AllWell') { require('menu_supallwell.php'); } ?>
	
<?php if ($_SESSION['type_login']=='Test') { require('menu_test.php'); } ?>	
	
<?php if ($_SESSION['type_login']=='Engineer') { require('menu_engineer.php'); } ?>
	
<?php if ($_SESSION['type_login']=='RPA') { require('menu_rpa.php'); } ?>	
	
	