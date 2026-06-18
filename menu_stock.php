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
    <button class="dropbtn">Setting 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <a href="add_product.php">สินค้า</a>
	   <a href="add_bom_lzdhm.php">สินค้า BOM LAZADA HEALTH MART</a>
      <a href="add_bom_lzdmd.php">สินค้า BOM LAZADA MED SHOP</a>
	   <a href="add_bom_shopee.php">สินค้า BOM SHOPEE</a>
       <a href="add_bom_producthos.php">สินค้า BOM Hospital</a>


    </div>
  </div>

  <div class="dropdown w3-right">
    <button class="dropbtn">Report 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
		<a href="search_product_tran.php">รายงานการเคลื่อนไหวสินค้า</a>
		<a href="search_jong_order.php">รายงานสินค้ารอออก ORDER</a>
		<a href="search_accessst.php">รายงานดึงข้อมูลลงทะเบียน Access Online</a>
		<a href="search_accesshos.php">รายงานดึงข้อมูลลงทะเบียน Access Hospital</a>
		<a href="search_inter.php">รายการขนส่งอินเตอร์</a>
    </div>
  </div>
 
<div class="dropdown w3-right">
    <button class="dropbtn">รายการ Sale Online 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
	<a href="status_stock.php" >Status Online </a>
		<a href="status_stock_sendbill.php" >Status เปิดบิลแล้วรอส่งของ</a>
			<a href="status_stock_bed.php" >Status Online เตียง</a>
		 <a href="status_stock_fak.php" >Status Online ใบฝาก</a>
    <a href="status_stock_all.php" >Status Online All</a>
		 <a href="status_clearst_allwell.php" >รายการใบยืมค้างเคลียร์โชว์รูม</a>
	<?php  if($_SESSION['name']=="พิทักษ์ชัย" or $_SESSION['name']=="สิลปชัย"){ 
	 
		 ?>	
	<a href="status_admin_bed.php">Status Edit Product</a>
		<?php } ?>
		
	</div>
  </div>

<div class="dropdown w3-right">
    <button class="dropbtn">รายการ Sale Hospita 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
		 <a href="status_stockbrhoskang.php" >Status Hospital (ใบยืม) รออนุมัติ</a>
   <a href="status_stockbrhos.php" >Status Hospital (ใบยืม)</a>
		<a href="status_stockhoskang.php" >Status Hospital (ใบสั่งขาย) รออนุมัติ</a>
    <a href="status_stockhos.php" >Status Hospital (ใบสั่งขาย)</a>
		<a href="status_stockhos_sendbill.php" >Status (SO) เปิดบิลแล้วรอส่งของ</a>
	<a href="status_stockhos_Accept.php" >Status Hospital (ใบสั่งขาย[ใบฝาก])</a>
<a href="status_stockbrhos_all.php" >Status Hospital All(ใบยืม)</a>
    <a href="status_stockhos_all.php" >Status Hospital All(ใบสั่งขาย)</a>
			<a href="status_clearbr_st.php" >Status ใบยืมค้างเคลียร์</a>

	</div>
  </div>
	
	
	 <div class="dropdown w3-right">
    <button class="dropbtn">ใบสั่งลดหนี้
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
	 <a href="status_credit_st.php" >รายการใบสั่งลดหนี้</a>
     <a href="status_credit_stall.php">รายการใบสั่งลดหนี้ทั้งหมด</a>
    </div>
  </div>
	
	   <div class="dropdown w3-right">
    <button class="dropbtn">ใบเบิกสินค้า
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
	<a href="status_stocksmp.php" >รายการใบเบิกสินค้า</a>
		<a href="status_stocksmpall.php" >รายการใบเบิกสินค้า All</a>
	 
    </div>
  </div>
	
	 <div class="dropdown w3-right">
    <button class="dropbtn">การรับคืนสินค้า
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
	 <a href="status_receive_pro.php" >รายการการคืนสินค้า</a>
  
    </div>
  </div>
	
	<div class="dropdown w3-right">
    <button class="dropbtn">ใบจอง
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
		<a href="status_stjong.php" >Status ใบจอง</a>
		<a href="status_stjongall.php" >Status ใบจองทั้งหมด</a>
	<a href="calendar_stjong.php" >ปฏิทินใบจอง</a>
  
    </div>
  </div>
	
		<div class="dropdown w3-right">
    <button class="dropbtn">ใบแลกเปลี่ยนสินค้า
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
		<a href="status_stockchanghos.php" >Status ใบแลกเปลี่ยนสินค้า</a>
		<a href="status_stockchanghosall.php" >Status ใบแลกเปลี่ยนสินค้า All</a>
	
  
    </div>
  </div>
	
	
		 <div class="dropdown w3-right">
    <button class="dropbtn">รายการค้นหาสินค้าผ่าน SN
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
		<a href="search_snonline.php" >รายการ Sale Online</a>
	 <a href="search_snsalehos.php" >รายการใบสั่งขาย</a>
		<a href="search_snsalehosbr.php" >รายการใบยืม</a>
		<a href="search_snsmp.php" >รายการใบเบิก SMP</a>
    </div>
  </div>

	 <div class="dropdown w3-right">
    <button class="dropbtn">รายการค้นหาสินค้าผ่าน SN
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
		<a href="search_snonline.php" >รายการ Sale Online</a>
	 <a href="search_snsalehos.php" >รายการใบสั่งขาย</a>
		<a href="search_snsalehosbr.php" >รายการใบยืม</a>
		<a href="search_snsmp.php" >รายการใบเบิก SMP</a>
    </div>
  </div>
	
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