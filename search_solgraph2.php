
<!DOCTYPE html>
<html>
<title>กราฟยอดขาย</title>
<meta name="viewport" content="width=device-width, initial-scale=-1" charset="utf8">
<link rel="stylesheet" href="css/w3.css">
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


include "dbconnect.php";
?>

<form name="frmSearch" target="_blank" method="POST" action="report_solgraph2.php">
<div class="w3-panel w3-light-gray"><h4>รายงานยอดขายรวม</h4></div>

<div class="w3-container w3-padding-large">

<div class="w3-half">

<div class="w3-container w3-third">

เดือน
<select name="mount" id="mount" class="w3-select" >
<option  value="">**เลือกเดือน**</option>
<?php
$sql = "select * from tb_month   order by month_id";
$query = mysqli_query($conn,$sql);
while ($fetch = mysqli_fetch_array($query,MYSQLI_ASSOC)) { ?>
<option class="w3-bar-item w3-button" value="<?php echo $fetch['month_code']; ?>"><?php echo $fetch['month_name']; ?></option>
<?php } ?>
</select>

</div>
	
<div class="w3-container w3-third">

ปี
<select name="year" id="year" class="w3-select" >
<option  value="">**เลือกปี**</option>
<?php
$sql = "select * from tb_year where y_ckk ='1' order by id_year  DESC";
$query = mysqli_query($conn,$sql);
while ($fetch = mysqli_fetch_array($query,MYSQLI_ASSOC)) { ?>
<option class="w3-bar-item w3-button" value="<?php echo $fetch['year_no']; ?>"><?php echo $fetch['year_name']; ?></option>
<?php } ?>
</select>

</div>	

<div class="w3-container w3-third">
  <input type="submit" value="Search" class="w3-button w3-teal">
 </div>
</div>
</div>

</form>