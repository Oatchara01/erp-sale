<?php  
session_start();
?>

<link rel="stylesheet" href="css/style.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Prompt:wght@500&display=swap" rel="stylesheet">	
<style>
	
*{
		 font-family: 'Prompt', sans-serif;
	}	
	
.topnav {
  overflow: hidden;
  background-color: #ffffff; 
  width: 95%;
  margin: 8px 2.5% 0px 2.5%;
  border-radius: 20px;
}

.topnav a {
  float: left;
  display: block;
  color: #ffffff;
  text-align: center;
  padding: 22px 14px;
  text-decoration: none;
  font-size: 14px;
  
}

.active {
  background-color: #ffffff;
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
  color: #5c1b70;
  padding: 22px 14px;
  background-color: inherit;
  font-family: inherit;
  margin: 0;
  border-radius: 20px;
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

.topnav a:hover {
  background-color: #ffffff;
  color: white;
}


.dropdown:hover .dropbtn {
  background-color: #5c1b70;
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

<div class="topnav" id="myTopnav" >
  <a href="main_salehos.php" style = "padding: 18px 0px 0px 8px;" class="active"><img width="120" height="28" src="img/allwellsale_logo.png"></a>
	
	
	
	  <div class="dropdown w3-right">
    <button class="dropbtn"><img src="img/logo_acc.png" width="25" align="left" height="20" ><?php echo $_SESSION['name']; ?>
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content w3-right">
      <a href="change_pass.php">Change Password</a>
		<a href="https://allwellcenter.com/itsupport/" target="_blank">แจ้งปัญหาการใช้งาน</a>
        <a href="logout.php">Logout</a>
    </div>
  </div>

  	<div class="dropdown w3-right">
    <button class="dropbtn">การจัดส่ง
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content w3-right">
     <a href="veiw_bussend.php" >ตารางรถใหญ่</a>
	  <a href="https://cs.allwellcenter.com/status_alldelivery.php" >ตรวจสอบรายละเอียดการจัดส่ง</a>
		
    </div>
  </div>
	
  
		<div class="dropdown w3-right">
    <button class="dropbtn">รายงาน
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content w3-right">
      <a href="">Add</a>
		
    </div>
  </div>
	
		
		<div class="dropdown w3-right">
    <button class="dropbtn">ยอดสินค้า
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content w3-right">
      <a href="">Add</a>
		
    </div>
  </div>
	
	
	<div class="dropdown w3-right">
    <button class="dropbtn">แบบสอบถาม
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content w3-right">
      <a href="">Add</a>
		
    </div>
  </div>
	
	
	<div class="dropdown w3-right">
    <button class="dropbtn">รายการรับเรื่อง
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content w3-right">
      <a href="">Add</a>
		
    </div>
  </div>
	

	
	<div class="dropdown w3-right">
    <button class="dropbtn">งานเอกสาร
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content w3-right">
     <a href="main_salehos_so.php" >Sale Order (SO)</a>
    <a href="status_salehos.php" >Status (SO)</a>
	<a href="status_salekang.php" >Status (SO) ใบฝาก</a>
	<a href="status_salekang_send.php" >Status (SO) ค้างส่ง</a>	


		
    </div>
  </div>





	
		

	  </div>
	

