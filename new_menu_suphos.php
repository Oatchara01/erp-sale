<?php  
session_start();
?>

<!--link rel="stylesheet" href="css/style.css"-->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Prompt:wght@500&display=swap" rel="stylesheet">	

<style>
  .font_menu_nav{
  font-family: 'Prompt', sans-serif;

}

*{
    padding: 0;
    margin: 0;
}

.topnav {
     overflow: hidden;
    background-color: #ffffff;
    width: 85%;
    margin: 80px 7.5% 0px 7.5%;
    border-radius: 20px;
}


.container{
    width: 95%;
    margin: 8px 2.5% 0px 2.5%;
    /* background-color: #292929; */
    /* z-index: 777; */

}
.font_nav_manu_main{
    font-family: 'Prompt', sans-serif;
    font-size: 15px;
}
/* โดยรวม full */
.manu_item1{
    background-color: #ffffff;
    margin-top: 10px;
    border-radius: 25px;
    padding: 14px;
    /* border: 1px solid black; */
    position: static;
}
.manu_item1_2:hover{
    background-color: #5c1b70;
    border-radius: 25px;
    color: #f1f1f1;
    padding: 5px 0px;
}
.manu_item1_3:hover{
    background-color: #5c1b70;
    border-radius: 25px;
    color: #f1f1f1;
}




/*  */
 

/*  */
/* โทรศัพท์ */
@media only screen and (max-width: 600px) {
    .manu_item1{
        position: fixed;
        width: 90%;
        box-shadow: 0em 1px 0px olive;
        z-index: 10;
        transition-timing-function: linear;
        left: 5%;
        height: 5%;
        padding: 0px;
    }

    .manu_item1_1_img{
        width: 100px;
        margin-bottom: 15px;
        left: 0px;
    }
    .manu_item1_1{
        text-align: left;
        font-family: 'Prompt', sans-serif;
        display: inline-block;
        width: 80%;
        float: left;
        margin-top: 1px;
        padding-left: 5%;
    }

    .manu_item1_2{
        font-family: 'Prompt', sans-serif;
        display:none;
    }
    .manu_item1_3{
        display: inline-block;
        list-style: none;
        text-align: center;
        min-width: 10%;
        margin-top: 2px;
        padding: 2px;
        float: left;
    }
    .dropdown-content {
        text-align: center;
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        margin-left: -100px;
        margin-top: 0px;
        min-width: 30%;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
        transition-timing-function: linear;
    }
    .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }
    .dropdown-content a:hover {
        background-color: #f1f1f1;
        transition-timing-function: linear;
    }

    .manu_item1_3:hover .dropdown-content {
        display: block;
    }

    .accordion {
        background-color: #eee;
        color: #444;
        cursor: pointer;
        padding: 18px;
        width: 100%;
        border: none;
        text-align: center;
        outline: none;
        font-size: 15px;
        transition: 0.4s;
    }

    .active, .accordion:hover {
        background-color: #ccc; 
    }

    .panel {
        text-align: left;
        /* padding: 0 18px; */
        display: none;
        background-color: white;
        overflow: hidden;
    }

}
/* ไอแพด */
@media only screen and (max-width: 1024px){
    .manu_item1{
        /* background-color: #ffffff; */
        position: fixed;
        min-width: 90%;
        box-shadow: 0em 1px 0px olive;
        z-index: 10;
        left: 5%;
        right: 5%;
        padding: 5px;
        transition-timing-function: linear;
    }

.manu_item1_1_img{
    width: 130px;
}

    .manu_item1_1{
        font-family: 'Prompt', sans-serif;
        text-align: center;
        display: inline-block;
        font-size: 10px;
        width: 8%;
        /* background-color: #947575; */
        float: left;
        margin-right: 70px;
    }

    .manu_item1_2{
        margin-left: 5px;
        margin-top: 8px;
        float: left;
        /* background-color: #812b2b; */
        font-family: 'Prompt', sans-serif;
        text-align: center;
        display: inline-block;
        font-size: 14px;
        min-width: 5%;
    }
    .manu_item1_3{
        display: none;
        
    }
    .dropdown-content {
        text-align: left;
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        margin-left: 0px;
        margin-top: 5px;
        width: 300px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
    }
    .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }
    .dropdown-content a:hover {background-color: #f1f1f1}

    .manu_item1_2:hover .dropdown-content {
        display: block;
    }
}
/* คอมปกติ */
@media only screen and (min-width: 769px) and (max-width: 1199px) {
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
        font-family: 'Prompt', sans-serif;
        text-align: center;
        display: inline-block;
        font-size: 14px;
        width: 17%;
        float: left;
    }

    .manu_item1_2{
        /* background-color: #944040; */
        font-family: 'Prompt', sans-serif;
        text-align: center;
        display: inline-block;
        font-size: 14px;
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
        font-size: 10px;
    }
    .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
        font-size: 12px;
    }
    .dropdown-content a:hover {background-color: #f1f1f1}

    .manu_item1_2:hover .dropdown-content {
        display: block;
    }
}
/* คอมจอใหญ่ */
@media only screen and (min-width: 1200px) {
    .manu_item1{
        /* background-color: olive; */
        position: fixed;
        width: 90%;
        box-shadow: 0em 1px 0px olive;
        left: 5%;
        right: 5%;
        z-index: 10;
        transition-timing-function: linear;
        position: absolute;
    }

    .manu_item1_1_img{
        width: 200px;
    }
    .manu_item1_1{
        padding: 0px 10px;
        font-family: 'Prompt', cursive;
        text-align: center;
        display: inline-block;
        font-size: 16px;
        width: 15.5%;
        transition: width 2s, height 4s;
        float: left;
        margin-right: 50px;
    }
    .manu_item1_2{
        float: left;
        margin-top: 13px;
        padding: 0px 0px 0px 0px;
        text-align: center;
        display: inline-block;
        font-size: 16px;
        min-width: 10%;
        font-family: 'Prompt', sans-serif;
    }
    .manu_item1_3{
        display: none;
    }
    .dropdown-content {
        text-align: left;
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        margin-left: 0px;
        margin-top: 5px;
        width: 300px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
    }
    .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }
    .dropdown-content a:hover {background-color: #f1f1f1}

    .manu_item1_2:hover .dropdown-content {
        display: block;
        
    }

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
    font-size: 13px;
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
    font-size: 13px;
  }
  
  .active, .collapsible:hover {
    background-color: #ebe4ed;
  }
  
  .content_nav {
    padding: 0px 0px 0px 0px;
    display: none;
    overflow: hidden;
    background-color: #ffffff;
    color: rgb(0, 0, 0);
    font-size: 15px;
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
</head>
<body>
    <div class="container">
        <div class="grid">
            <div class="manu">
                <nav class="manu_item1">
                    <ul>
                        <li class="manu_item1_1"><a href="main_suphos.php" ><img class="manu_item1_1_img" style="margin-top: 1px;" src="img/allwellsale_logo.png" alt="" ></a></li>
                        
                        <li class="manu_item1_2">งานเอกสาร
                            <div class="dropdown-content">

    <button type="button" class="collapsible">&nbsp;&nbsp;&nbsp; <i class="bi bi-plus"></i></i>&nbsp;&nbsp;&nbsp; <font class="font_nav_manu_main">+ ใบสั่งขาย</font></button>
                <div class="content_nav">

	<a href="main_suphos_so.php" >Sale Order (SO)</a>
    <a href="status_suphos.php" >Status (SO)</a>
	<a href="status_supkang.php" >Status (SO) ใบฝาก</a>
	<a href="status_supkang_send.php" >Status (SO) ค้างส่ง</a>

                </div>

      <button type="button" class="collapsible">&nbsp;&nbsp;&nbsp; <i class="bi bi-plus"></i></i>&nbsp;&nbsp;&nbsp; <font class="font_nav_manu_main">+ ใบลดหนี้</font></button>
                <div class="content_nav">

	 <a href="register_credit_sup.php" >สร้างใบสั่งลดหนี้</a>
	 <a href="status_credit_sup.php" >รายการใบสั่งลดหนี้</a>

                </div>
     

     <button type="button" class="collapsible">&nbsp;&nbsp;&nbsp; <i class="bi bi-plus"></i></i>&nbsp;&nbsp;&nbsp; <font class="font_nav_manu_main">+ ใบเบิกจ่ายสินค้า (ยืม)</font></button>
                <div class="content_nav">

	<a href="main_suphos_br.php" >Borrow (BR)</a>
	<a href="status_supbrhos.php" >Status (BR)</a>
	<a href="status_clearbr_sup.php" >Status ใบยืมค้างเคลียร์</a>

                </div>

    
	 <button type="button" class="collapsible">&nbsp;&nbsp;&nbsp; <i class="bi bi-plus"></i></i>&nbsp;&nbsp;&nbsp; <font class="font_nav_manu_main">+ ใบเบิกตัวอย่าง (SMP)</font></button>
                <div class="content_nav">

	 <a href="main_suphos_smp.php" >สร้างใบเบิกสินค้า (สนับสนุนการขาย)</a>
	 <a href="status_samplesup.php" >รายการใบเบิกสินค้า (สนับสนุนการขาย)</a>

                </div>


	 <button type="button" class="collapsible">&nbsp;&nbsp;&nbsp; <i class="bi bi-plus"></i></i>&nbsp;&nbsp;&nbsp; <font class="font_nav_manu_main">+ ใบแลกเปลี่ยนสินค้า</font></button>
                <div class="content_nav">

	<a href="main_suphos_change.php" >สร้างใบแลกเปลี่ยนสินค้า</a> 
	<a href="status_supchange.php" >รายการใบแลกเปลี่ยนสินค้า</a>


                </div>

     <button type="button" class="collapsible">&nbsp;&nbsp;&nbsp; <i class="bi bi-plus"></i></i>&nbsp;&nbsp;&nbsp; <font class="font_nav_manu_main">+ ใบจองสินค้า</font></button>
                <div class="content_nav">

	<a href="main_suphos_jong.php" >สร้างใบจอง</a>
    <a href="status_supjong.php" >Status ใบจอง</a>
	<a href="status_supjong_clear.php" >Status ใบจองค้างเคลียร์</a>

                </div>


<?php if  ($_SESSION['user_type']=="Engineer"){ ?>

      <button type="button" class="collapsible">&nbsp;&nbsp;&nbsp; <i class="bi bi-plus"></i></i>&nbsp;&nbsp;&nbsp; <font class="font_nav_manu_main">+ ใบเบิกเครื่องและอะไหล (SPR)</font></button>
                <div class="content_nav">

	 <div class="dropdown-content">
	<a href="main_eng_spr.php" >สร้างใบเบิกเครื่องและอะไหล่</a>
	<a href="status_spr.php" >รายการใบเบิกเครื่องและอะไหล่ (ฟาร์ทริลเลียน)</a>
		<a href="status_spr_no.php" >รายการใบเบิกเครื่องและอะไหล่ (โนเบิล เมด)</a>

                </div>


     <button type="button" class="collapsible">&nbsp;&nbsp;&nbsp; <i class="bi bi-plus"></i></i>&nbsp;&nbsp;&nbsp; <font class="font_nav_manu_main">+ ใบรายการตรวจทานสินค้า</font></button>
                <div class="content_nav">

	 <div class="dropdown-content">
	<a href="status_checkliengo.php" >รายการใบตรวจทาน (ขาไป)</a>
	<a href="status_checklienbk.php" >รายการใบตรวจทาน (ขากลับ)</a>
	<a href="status_checklienall.php" >รายการใบตรวจทาน (ทั้งหมด)</a>

                </div>

	<?php } ?>

    <!-- <a href="#">  -->
    <button style="background-color: #c7c7e2;" type="button" class="collapsible">&nbsp;&nbsp;&nbsp; <i class="bi bi-plus"></i>&nbsp;&nbsp;&nbsp; <font class="font_nav_manu_main">+ อนุมัติเอกสาร</font></button>
                <div class="content_nav">
    <!-- <a href="#">  -->
		<a href="status_approvesup.php" >อนุมัติใบสั่งขาย</a>
		<a href="status_approvebrsup.php" >อนุมัติใบยืม</a>
		<a href="status_credit_approve.php" >อนุมัติใบสั่งลดหนี้</a>
		<a href="status_sample_approve.php" >อนุมัติใบเบิกสินค้า</a>
		<a href="status_supjongapp.php" >อนุมัติใบจอง</a>
		<a href="status_supchangeapp.php" >อนุมัติการแลกเปลี่ยนสินค้า</a>
		<?php if  ($_SESSION['user_type']=="Engineer"){ ?>
		<a href="status_approvespr.php" >อนุมัติใบเบิกเครื่องและอะไหล่</a>
		<?php } ?>
		<?php if  ($_SESSION['name']=="บรรเทิง"){ ?>
		<a href="status_appspr_cm.php" >อนุมัติใบเบิกเครื่องและอะไหล่ ผู้บริหาร</a>
		<?php } ?>
            </div>
    
                                <!-- <a href="#"><h5><i class='bx bx-minus'></i>&nbsp;&nbsp;&nbsp; ตรวจเช็คสินค้าประเภท B</h5> </a> -->
                            </div><!-- dropdown-content -->
                        </li>
                        <li class="manu_item1_2">รายการรับเรื่อง
                            <div class="dropdown-content">
<!-- <a href="#">  -->
    <button type="button" class="collapsible">&nbsp;&nbsp;&nbsp; <i class="bi bi-plus"></i></i>&nbsp;&nbsp;&nbsp; <font class="font_nav_manu_main">+ รายการรับเรื่องจากลูกค้า</font></button>
<div class="content_nav">

        <?php if  ($_SESSION['name']=="บรรเทิง"){ ?>
		<a href="status_kangcs.php" >รายการรับเรื่องจากลูกค้าในส่วนของจัดส่ง (ค้าง)</a>
		<a href="status_kangcsall.php" >รายการรับเรื่องจากลูกค้า (ปิดงานแล้ว)</a>
		<?php }else{ ?> 
		<a href="status_storykangsup.php" >รายการรับเรื่องจากลูกค้า (ค้าง)</a>
		<a href="status_storysupall.php" >รายการรับเรื่องจากลูกค้า (ปิดงานแล้ว)</a>
		<?php } ?>
		 
   
</div>

 <button type="button" class="collapsible">&nbsp;&nbsp;&nbsp; <i class="bi bi-plus"></i></i>&nbsp;&nbsp;&nbsp; <font class="font_nav_manu_main">+ รายการรับเรื่องลูกค้าของช่าง</font></button>
<div class="content_nav">

     
		 <a href="register_cuseng.php" >การรับเรื่องลูกค้าของช่าง</a>
		<a href="status_cusopen.php" >รายการรับเรื่องลูกค้าช่าง</a>	
		 <?php if  ($_SESSION['user_type']=="Engineer"){ ?>
		<a href="status_engkang.php" >รายการรับเรื่องลูกค้าช่าง (ค้าง)</a>	
		<a href="status_engpend.php" >รายการรับเรื่องลูกค้าช่าง (กำลังดำเนินการ)</a>	
		<a href="status_engclose.php" >รายการรับเรื่องลูกค้าช่าง (ปิดงาน)</a>
		<a href="update_doceng.php" >Import เลขที่เอกสาร</a>
   <?php } ?>
   
</div>


<button type="button" class="collapsible">&nbsp;&nbsp;&nbsp; <i class="bi bi-plus"></i></i>&nbsp;&nbsp;&nbsp; <font class="font_nav_manu_main">+ รายการรับเรื่อง PO</font></button>
<div class="content_nav">

     
		<a href="status_po_sup.php" >รายการใบ PO ค้างเปิดใบสั่งขาย</a>
	  <a href="status_po_supall.php" >รายการใบ PO ทั้งหมด</a>
   
</div>


        <!-- </a> -->
                            </div><!-- dropdown-content -->
                        </li>
                        <li class="manu_item1_2">แบบสอบถาม
                            <div class="dropdown-content">

    	<a href="status_supresearch.php" >ทำแบบสอบถาม</a>
	<a href="status_supchangeall.php" >Status แบบสอบถามทั้งหมด</a>

                            </div><!-- dropdown-content -->
                        </li>



						<li class="manu_item1_2">รายงาน
                            <div class="dropdown-content">
 <?php if  ($_SESSION['name']=="นรินทิพย์" or $_SESSION['name']=="พรรณิภา"){ ?>
		
  		<a href="search_sup_record.php" >Sale Record สินค้า</a>
  		<a href="search_sup_record1.php" >Sale Record เลขที่เอกสาร</a>
		<a href="report_hosgraph.php">รายงานยอดขายแบบกราฟ แผนกโรงพยาบาล</a>
		<a href="search_supgraph.php" >รายงานรวมยอดขายแบบกราฟแยกเขต</a>
		<a href="search_grapsum.php" >รายงานรวมยอดขายแบบกราฟทั้งหมด</a>
		<a href="report_supkangbr.php" >รายงานใบยืมคงค้างตาม รพ</a>
		<a href="search_report_customersup.php" >รายงานยอดขายแยกตามลูกค้า</a>
		<a href="search_report_allbyproductsup.php" >รายงานยอดขายแยกตามสินค้า</a>
		
		<?php } ?>
		<?php if  ($_SESSION['user_type']=="Engineer"){ ?>
		<a href="search_enivall.php" >รายงานเลขที่เอกสารออกบิลทั้งหมด</a>
		<a href="report_supkangbr.php" >รายงานใบยืมคงค้างตาม รพ</a>
		<?php } ?>
		
                            </div><!-- dropdown-content -->
                        </li>



	<li class="manu_item1_2">ยอดสินค้า
                            <div class="dropdown-content">
        <a href="https://stock.allwellcenter.com/report_hotpro1.php" target="_blank">รายงานสินค้าคงเหลือ ยอดนิยม เตียงและสินค้าประกอบ</a>
		<a href="https://stock.allwellcenter.com/report_hotpro2.php" target="_blank">รายงานสินค้าคงเหลือ ยอดนิยม สินค้า Online</a>
		<a href="https://stock.allwellcenter.com/report_hotpro3.php" target="_blank">รายงานสินค้าคงเหลือ ยอดนิยม สินค้าทั่วไป</a>
		<a href="https://stock.allwellcenter.com/report_hotpro4.php" target="_blank">รายงานสินค้าคงเหลือ ยอดนิยมสินค้า Allied</a>
		<a href="search_productall.php">รายงานสินค้าคงเหลือแบบเลือกรายการ</a>
                            </div><!-- dropdown-content -->
                        </li>


<li class="manu_item1_2">การจัดส่ง
                            <div class="dropdown-content">
<a href="veiw_bussend.php" >ตารางรถใหญ่</a>
<a href="https://cs.allwellcenter.com/status_alldelivery.php">ตรวจสอบรายละเอียดการจัดส่ง</a>
                            </div><!-- dropdown-content -->
                        </li>

                      
<?php 
$name=$_SESSION['name'];
$surname=$_SESSION['surname'];
?>
                        <li  class="manu_item1_2"><i class="bi bi-person-circle"></i> <?php echo $name;?></font>
                            <div class="dropdown-content">
<a href="change_pass.php">Change Password</a>
		<a href="https://allwellcenter.com/itsupport/" target="_blank">แจ้งปัญหาการใช้งาน</a>
        <a href="logout.php">Logout</a>
                            </div><!-- dropdown-content -->
                        </li>

                        
                </nav> <!-- manu_item1 -->
<br>
                <div class="content">

                </div><!-- content -->
            </div> <!-- manu -->
        </div> <!-- grid -->
    </div> <!-- container -->
	</div>
</body>
</html>

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