<style>
.topnav {
  overflow: hidden;
  background-color: #F0F0F0;
}

.topnav a {
  float: left;
  display: block;
  color: #303030;
  text-align: center;
  padding: 12px 14px;
  text-decoration: none;
  font-size: 14px;
}

.active {
  background-color: #8600b3;
  color: white;
}

.topnav .icon {
  display: none;
}

.dropdown {
  float: left;
  overflow: hidden;
}

.dropdown .dropbtn {
  font-size: 14px;    
  border: none;
  outline: none;
  color: #303030;
  padding: 12px 14px;
  background-color: inherit;
  font-family: inherit;
  margin: 0;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f2f2f2;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  float: none;
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
  text-align: left;
}

.topnav a:hover, .dropdown:hover .dropbtn {
  background-color: #555;
  color: white;
}

.dropdown-content a:hover {
  background-color: #ddd;
  color: black;
}

.dropdown:hover .dropdown-content {
  display: block;
}

@media screen and (max-width: 600px) {
  .topnav a:not(:first-child), .dropdown .dropbtn {
    display: none;
  }
  .topnav a.icon {
    float: right;
    display: block;
  }
}

@media screen and (max-width: 600px) {
  .topnav.responsive {position: relative;}
  .topnav.responsive .icon {
    position: absolute;
    right: 0;
    top: 0;
  }
  .topnav.responsive a {
    float: none;
    display: block;
    text-align: left;
  }
  .topnav.responsive .dropdown {float: none;}
  .topnav.responsive .dropdown-content {position: relative;}
  .topnav.responsive .dropdown .dropbtn {
    display: block;
    width: 100%;
    text-align: left;
  }
}
</style>
<div class="topnav" id="myTopnav">
  <a href="main_stock.php" class="active"><font color="#e6e6e6"><b>ERP System</b></font></a>
  
  <div class="dropdown w3-right">
    <button class="dropbtn">คุณ<?php echo $_SESSION['name']; ?>&nbsp;<?php echo $_SESSION['surname']; ?>
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content w3-right">
      <a href="change_pass.php">Change Password</a>
        <a href="logout.php">Logout</a>
    </div>
  </div>



  <div class="dropdown w3-right">
    <button class="dropbtn">Report 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
		<a href="search_report_twodate.php">สรุปตามวันที่ (เลือกวัน)</a>
		<a href="search_report_bydate.php">สรุปตามวันที่ (ช่วงเวลา)</a>
		<a href="search_report_byproduct.php">สรุปตามสินค้า (เลือกวัน)</a>
		<a href="search_report_producttwo.php">สรุปตามสินค้า (ช่วงเวลา)</a>
		<a href="search_summary_product.php">สรุปตามสินค้า (เลือกวัน แบบสรุป)</a>
		<a href="search_summary_productdate.php">สรุปตามสินค้า (ช่วงเวลา แบบสรุป)</a>
		<a href="search_bycustomer.php">สรุปจำนวนลูกค้า (เลือกวัน)</a>
		<a href="search_bycustomer_date.php">สรุปจำนวนลูกค้า (ช่วงเวลา)</a>
		<a href="search_summary_channel.php">สรุปจำนวนลูกค้า (ช่วงเวลา)</a>
    </div>
  </div>
  <a href="search_service_engineer.php" class="w3-right">Export ข้อมูลติดตั้ง</a>
  <a href="javascript:void(0);" style="font-size:14px;" class="icon" onclick="myFunction()">&#9776;</a>
</div>

<script type="text/javascript">
function myFunction() {
  var x = document.getElementById("myTopnav");
  if (x.className === "topnav") {
    x.className += " responsive";
  } else {
    x.className = "topnav";
  }
}
</script>