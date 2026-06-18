<link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'> <!-- icon -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Mitr:wght@300&display=swap" rel="stylesheet">

<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="https://cdn.lordicon.com/xdjxvujz.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
<!--link rel="stylesheet" href="css/content_size_C.css"-->
<!--link rel="stylesheet" href="css/nav_C.css"-->

<style>
.topnav {
  overflow: hidden;
  background-color: white;
  margin: 2.5% 0% 0.5% 0%;
	padding-top:15px;
 height : 80px;
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
  background-color: white;
  color: black;
	
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
  background-color: #ffffff;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;

}

.dropdown-content a {
  float: none;
  color: black;
  display: none;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
  text-align: left;
  overflow: hidden;
  background-color: #ffffff;
  color: rgb(0, 0, 0);
   

}

.topnav a:hover {
  background-color: white;
  color: white;
}

 .dropdown:hover .dropbtn {
  background-color: #5c1b70;
  color: white;
}


.dropdown-content a:hover {
  background-color: #ebe4ed;
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
	
	
/*-----------------------*/	
	
 .manu_item1_2:hover{
    background-color: #5c1b70;
    border-radius: 25px;
    color: #f1f1f1;
    padding: 5px 0px;
    transition-duration: 0.25s;

}

.manu_item1_2 .dropbtn {
  font-size: 14px;    
  border: none;
  outline: none;
  color: #303030;
  padding: 12px 14px;
  background-color: inherit;
  font-family: inherit;
  margin: 0;
}
.manu_item1_2{
    transition-duration: 0.25s;

}
	
  .manu_item1{
        /* background-color: #ffffff; */
        position: fixed;
        min-width: 90%;
        box-shadow: 0em 1px 0px olive;
        z-index: 10;
        padding: 7px;
        transition-timing-function: linear;
    }
    .manu_item1_1_img{
        width: 130px;
    }
    .manu_item1_1{
        /* background-color: #947575; */
        font-family: 'Mitr', sans-serif;
        text-align: center;
        display: inline-block;
        /*font-size: 14px;*/
        width: 17%;
        float: left;
    }

    .manu_item1_2{
        /* background-color: #944040; */
        font-family: 'Mitr', sans-serif;
        text-align: center;
        display: inline-block;
        /*font-size: 14px;*/
        min-width: 10%;
        float: left;
        margin: 7px 0px 0px 0px;
    }
    .manu_item1_3{
        display: none;
    }
    .dropdown-content {
        text-align: left;
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        margin-left: 5px;
        margin-top: 5px;
        width: 300px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
        /*font-size: 10px;*/
    }
    .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
		display: block;
        /*font-size: 12px;*/
    }
    .dropdown-content a:hover {background-color: #E6E6FA}

    .manu_item1_2:hover .dropdown-content {
        display: block;
    }
	
.collapsible {
    background-color: #ffffff;
    color: rgb(41, 41, 41);
    cursor: pointer;
    padding:5px 5px 10px 0px;
    width: 100%;
    border: none;
    text-align: left;
    outline: none;
    /*font-size: 13px;*/
  }
  .collapsible1 {
    /* background-color: #f1f1f1; */
    color: white;
    cursor: pointer;
    padding:5px 5px 10px 0px;
    width: 100%;
    border: none;
    text-align: left;
    outline: none;
    /*font-size: 13px;*/
  }
  
  /*.active, .collapsible:hover {
    background-color: #ebe4ed;
  }*/
  
  .content_nav {
    padding: 0px 0px 0px 0px;
    display: none;
    overflow: hidden;
    background-color: #ffffff;
    color: rgb(0, 0, 0);
    /*font-size: 15px;*/
    z-index: 99px;
  }
  .content_nav:hover {
    padding: 0px 0px 0px 0px;
    display: none;
    overflow: hidden;
    background-color: #ebe4ed;
    color: #555;
    /* font-size: 15px; */
  }
	
	
</style>

<div class="topnav" id="myTopnav">
  <a href="main_admin.php" class="active"><img width="90" height="24" src="img/allwellsale_logo.png"></a>
  
  <li class="manu_item1_2 w3-right">
    คุณ<?php echo $_SESSION['name']; ?>&nbsp;<?php echo $_SESSION['surname']; ?> 
      <i class="fa fa-caret-down"></i>
   
    <div class="dropdown-content w3-right">
      <a href="change_pass.php">Change Password</a>
		<a href="https://allwellcenter.com/itsupport/" target="_blank">แจ้งปัญหาการใช้งาน</a>
        <a href="logout.php">Logout</a>
    </div>
  </li>

<li class="manu_item1_2 w3-right">
    Report
      <i class="fa fa-caret-down"></i>
   
    <div class="dropdown-content w3-right">
      <a href="search_sumallevery_rpa.php"> &nbsp;&nbsp;&nbsp;  ยอดรวม</a>
    </div>
  </li>




 </div><!-- dropdown-content -->
  </li>
	
 

	
	




	
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




<script>
var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var panel = this.nextElementSibling;
    if (panel.style.display === "block") {
      panel.style.display = "none";
    } else {
      panel.style.display = "block";
    }
  });
}
</script>


<script>
AOS.init();
</script>
<script>
var coll = document.getElementsByClassName("collapsible");
var i;

for (i = 0; i < coll.length; i++) {
coll[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var content = this.nextElementSibling;
    if (content.style.display === "block") {
    content.style.display = "none";
    } else {
    content.style.display = "block";
    }
});
}
</script>