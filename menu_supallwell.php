
<style>
.topnav {
  overflow: hidden;
  background-color: white;
  margin: 2.5% 0% 2.5% 0%;
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
  background-color: #ffffff;
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
</style>

<?php	
function encryptData($data, $secretKey = 'mySecretKey123456789') {
    // ให้ key เป็นไบต์ 32 bytes (SHA-256)
    $key = hash('sha256', $secretKey, true);      // 32 bytes
    $iv  = substr($key, 0, 16);                   // 16 bytes IV

    // คืน raw binary (OPENSSL_RAW_DATA) แล้ว base64_encode เพื่อให้ส่งใน URL ได้
    $cipher_raw = openssl_encrypt($data, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
    return rawurlencode(base64_encode($cipher_raw)); // rawurlencode เพื่อความปลอดภัยใน URL
}

// ตัวอย่างใช้งาน
$em_id = $_SESSION['emid'];
$token = encryptData($em_id, 'mySecretKey123456789');
	
	?>

<div class="topnav" id="myTopnav">
  <a href="main_supallwell.php" class="active"><img width="150" height="33" src="img/allwellsale_logo.png"></a>
  
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
	
	<?php if ($_SESSION['name']=='รุจิรา') { ?>
	
	<div class="dropdown w3-right">
    <button class="dropbtn">แบบสอบถาม
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
	<a href="status_research.php" >ทำแบบสอบถาม</a>
	<a href="status_changeall.php" >Status แบบสอบถามทั้งหมด</a>
	<a href="status_reserch_receive.php" >แบบประเมินความพึงพอใจในการจัดสินค้า</a>
    </div>
  </div>
	
	<?php }else{ ?>
	
	
	
	
		  
		<div class="dropdown w3-right">
    <button class="dropbtn">แบบสอบถาม
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
    <a href="research_showroom.php">แบบสอบถามลูกค้า Showroom</a>
	<a href="status_showroom.php">รายการแบบสอบถาม</a>
	<a href="report_rsshowroom.php">รายงานแบบสอบถาม</a>	
	<a href="status_supresearch.php" >ทำแบบสอบถามหลังการขาย  (โรงพยาบาล)</a>
	<a href="status_supchangeall.php" >Status แบบสอบถามหลังการขายทั้งหมด  (โรงพยาบาล)</a>
	<a href="status_soldemo.php" >ทำแบบสอบถามสินค้าสาธิต (โชว์รูม)</a>
	<a href="status_soldemoall.php" >แบบสอบถามสินค้าสาธิตทั้งหมด (โชว์รูม)</a>   	
	 <a href="status_supdemo.php" >ทำแบบสอบถามสินค้าสาธิต (โรงพยาบาล)</a>
	<a href="status_supdemoall.php" >แบบสอบถามสินค้าสาธิตทั้งหมด (โรงพยาบาล)</a> 	
	<a href="status_reserch_receive.php" >แบบประเมินความพึงพอใจในการจัดสินค้า</a>
	 
    </div>
  </div>
	  <?php } ?>
	 <div class="dropdown w3-right">
    <button class="dropbtn">ใบเบิกสินค้า 
      <i class="fa fa-caret-down"></i>
    </button>
	   <div class="dropdown-content">
   	 <a href="main_suphos_smp.php" >สร้างใบเบิกสินค้า (สนับสนุนการขาย)</a>
	 <a href="status_samplesup.php" >รายการใบเบิกสินค้า (สนับสนุนการขาย)</a>
	 <a href="status_sample_approve.php" >อนุมัติใบเบิกสินค้า</a>
	 
	    </div>
  </div>
	<div class="dropdown w3-right">
    <button class="dropbtn">ใบ PO
      <i class="fa fa-caret-down"></i>
    </button>
	   <div class="dropdown-content">
   	  <a href="status_po_sup.php" >รายการใบ PO ค้างเปิดใบสั่งขาย</a>
	  <a href="status_po_supall.php" >รายการใบ PO ทั้งหมด</a>
    </div>
  </div>
	
	<div class="dropdown w3-right">
    <button class="dropbtn">ใบเสนอราคา
      <i class="fa fa-caret-down"></i>
    </button>
	   <div class="dropdown-content">
   	 <a href="main_sup_qou.php" >สร้างใบเสนอราคา</a>
	 <a href="status_supqou.php" >รายการใบเสนอราคา</a>
	 <a href="status_appqou.php" >อนุมัติใบเสนอราคา</a>
	 
	    </div>
  </div>
	
	<div class="dropdown w3-right">
    <button class="dropbtn">แบบฟอร์ม Feedback 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
   
   	<a href="https://feedback.allwellcenter.com/check_login_out.php?token=<?php echo  $token; ?>"  target="_blank" >แบบฟอร์ม Feedback</a>
	
	    </div>
  </div>
	<div class="dropdown w3-right">
    <button class="dropbtn">ใบสั่งลดหนี้
      <i class="fa fa-caret-down"></i>
    </button>
	   <div class="dropdown-content">
   	 <a href="register_credit_sup.php" >สร้างใบสั่งลดหนี้</a>
	 <a href="status_credit_sup.php" >รายการใบสั่งลดหนี้</a>
	<a href="status_credit_approve.php" >อนุมัติใบสั่งลดหนี้</a>
    </div>
  </div>
	
	<div class="dropdown w3-right">
    <button class="dropbtn">แลกเปลี่ยนสินค้า 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
   
   <a href="main_suphos_change.php" >สร้างใบแลกเปลี่ยนสินค้า</a> 
 <a href="status_supchange.php" >รายการใบแลกเปลี่ยนสินค้า</a>
	<a href="status_supchangeapp.php" >อนุมัติการแลกเปลี่ยนสินค้า</a>	
		 
    </div>
  </div>
	
	<div class="dropdown w3-right">
    <button class="dropbtn">AllWell 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
		<a href="main_allwell_so.php" >Create ใบสั่งขาย</a>
	   <a href="main_allwell_br.php" >Create ใบยืม</a>
		<a href="status_allwell.php" >Status</a>
		<a href="status_allwell_br.php" >Status ใบยืม</a>
		<a href="status_ecomsmp.php" >Status Ecommerce</a>
		<?php //if($_SESSION['name']=='รุจิรา'){ ?>
		<a href="status_mkchange_glu.php" >รายการออเดอร์เครื่อง G-426</a>
		<a href="status_mkchange_glucos.php" >รายการออเดอร์เครื่อง GLUCOSURE</a>
		<a href="register_chother_blood.php" >ลงทะเบียนลูกค้าแลกเครื่องวัดน้ำตาล</a>   
<a href="status_bloodch.php" >รายการลูกค้าแลกเครื่องวัดน้ำตาลยี้ห้ออื่น</a>  
		<?php //} ?>
		<a href="status_brclear_allwell.php" >Status ใบยืมค้างเคลียร์</a>
		<a href="status_searchproduct.php" >Status Search Product</a>
		<a href="status_allwell_fak.php" >Status ใบฝาก</a>
	  	   <a href="status_approve_sol.php" >อนุมัติ</a>
		<?php if ($_SESSION['name']=='รุจิรา'){ ?>
		  <a href="status_adminprice.php" >อนุมัติออเดอร์สินค้าราคาต่ำกว่ากำหนด</a>
		<?php } ?>
		
  		<a href="search_brkangclear.php">รายงานใบยืมค้างเคลียร์ Showroom</a>
		<a href="report_brkangbysup.php" >ตรวจเช็คใบยืมค้างเคลียร์ (stock)</a>
	<a href="status_brsuparea.php" >รายการตรวจเช็คใบยืม (ทั้งหมด)</a>
		<a href="status_etaxcustomer.php" >ข้อมูลลูกค้าขอใบกำกับภาษี</a>
		<a href="status_appckkst.php" >อนุมัติรายการตรวจเช็คใบยืม</a>
		 </div>
  </div>
	
	 <?php if ($_SESSION['name']=='ทิพย์ภาพัน' or $_SESSION['name']=='ลักษณาวรรณ' or $_SESSION['name']=='รุจิรา' or $_SESSION['name']=='มาลินี') {?>
	

  <div class="dropdown w3-right">
    <button class="dropbtn">ใบสั่งขาย Hospital
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
		
<?php if ($_SESSION['name']=='รุจิรา'){ ?>
   <a href="main_suphos_so.php" >Sale Order (SO)</a>
	<a href="status_supic.php" >Status (IC) ใบฝากขาย</a>
	<a href="status_approvesup.php" >อนุมัติ (SO)</a>	
	<?php }else{ ?>
    <a href="main_suphos_so.php" >Sale Order (SO)</a>
   <a href="status_suphos.php" >Status (SO)</a>
	<a href="status_supic.php" >Status (IC) ใบฝากขาย</a>	
		<a href="status_supkang.php" >Status (SO) ใบฝาก</a>
	<a href="status_supkang_send.php" >Status (SO) ค้างส่ง</a>
  <a href="status_approvesup.php" >อนุมัติ (SO)</a>
		
	<?php } ?>	
<?php if ($_SESSION['name']=='ทิพย์ภาพัน') { ?>
	<a href="status_glucosemkhos.php" >รายงานรอส่ง SN Gluco All-Pro</a>	
		
		<?php } ?>
		
		
    </div>
  </div>
	
	<div class="dropdown w3-right">
    <button class="dropbtn">ใบยืม Hospital
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
   
    <a href="main_suphos_br.php" >Borrow (BR)</a>
	<a href="status_supbrhos.php" >Status (BR)</a>
	<a href="status_clearbr_sup.php" >Status ใบยืมค้างเคลียร์</a>
	<a href="main_soanysup.php" >Status เคลียร์ใบยืมหลายเอกสาร</a>
	<a href="status_approvebrsup.php" >อนุมัติ (BR)</a>
	<a href="report_brkangbysup.php" >ตรวจเช็คใบยืมค้างเคลียร์ (stock)</a>
	<a href="status_brsuparea.php" >รายการตรวจเช็คใบยืม (ทั้งหมด)</a>
    </div>
  </div>
	
		<div class="dropdown w3-right">
    <button class="dropbtn">ใบยืมฝากขาย 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
   
    <a href="main_sup_brsc.php" >สร้างใบฝากขาย </a>
 	<a href="status_supbrsc.php" >Status ใบฝากขาย </a>
	<a href="status_clearbrsc_sup.php" >Status ใบฝากขายค้างเคลียร์</a>
	<a href="main_soanysup_brsc.php" >Status เคลียร์ใบยืมฝากขายหลายเอกสาร</a>		
	<a href="status_approvebrsc.php" >อนุมัติใบยืมฝากขาย</a>	 
    </div>
  </div>

	
	<div class="dropdown w3-right">
    <button class="dropbtn">ใบสั่งเช่า
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
	<a href="main_sup_rental.php" >ใบสั่งเช่า</a>
	<a href="status_suprental.php" >Status ใบสั่งเช่า</a>
	<a href="status_kangivsup.php" >Status ใบสั่งเช่ารอเปิดใบสั่งขาย</a>	
	<a href="status_apprental.php" >อนุมัติใบสั่งเช่า</a>	
	</div>
  </div>
	
	<?php } ?>
	
	 <div class="dropdown w3-right">
    <button class="dropbtn">ใบมัดจำ 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
		<a href="status_deposit.php">รายการใบรับเงินมัดจำ</a>
		<a href="register_deposit.php">ใบรับเงินมัดจำ</a>
		
		 </div>
  </div>
	
	<div class="dropdown w3-right">
    <button class="dropbtn">ใบจอง 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
   
    <a href="main_suphos_jong.php" >สร้างใบจอง</a>
 <a href="status_supjong.php" >Status ใบจอง</a>
		<a href="status_supjong_clear.php" >Status ใบจองค้างเคลียร์</a>	
	<a href="status_supjongapp.php" >อนุมัติใบจอง</a>	
		 
    </div>
  </div>
	
	<div class="dropdown w3-right">
    <button class="dropbtn">รายการรับเรื่องจากลูกค้า      
	<i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
     <a href="register_story.php" >การรับเรื่องจากลูกค้า</a>
	<a href="status_storycreate.php" >รายการรับเรื่องจากลูกค้าเอง</a>
	<a href="status_storykangsup.php" >รายการรับเรื่องจากลูกค้า (ค้าง)</a>
	<a href="status_storysupall.php" >รายการรับเรื่องจากลูกค้า (ปิดงานแล้ว)</a>
	<a href="status_storyall.php" >รายการรับเรื่องจากลูกค้า (ปิดงานแล้วทั้งหมด)</a>
	<a href="register_cuseng.php" >การรับเรื่องลูกค้าของช่าง</a>
	<a href="status_cusopen.php" >รายการรับเรื่องลูกค้าช่าง</a>	
	<a href="status_engall_close.php" >รายการรับเรื่องลูกค้าช่าง (ทั้งหมด)</a>
      </div>
  </div>
	
	
	
	
		<div class="dropdown w3-right">
    <button class="dropbtn">ยอดสินค้า
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
       <a href="https://stock.allwellcenter.com/report_hotpro1.php?name=<?php echo $_SESSION['name']; ?>" target="_blank">รายงานสินค้าคงเหลือ ยอดนิยม เตียงและสินค้าประกอบ</a>
		<a href="https://stock.allwellcenter.com/report_hotpro2.php?name=<?php echo $_SESSION['name']; ?>" target="_blank">รายงานสินค้าคงเหลือ ยอดนิยม สินค้า Online</a>
		<a href="https://stock.allwellcenter.com/report_hotpro3.php?name=<?php echo $_SESSION['name']; ?>" target="_blank">รายงานสินค้าคงเหลือ ยอดนิยม สินค้าทั่วไป</a>
		<a href="https://stock.allwellcenter.com/report_hotpro4.php?name=<?php echo $_SESSION['name']; ?>" target="_blank">รายงานสินค้าคงเหลือ ยอดนิยมสินค้า Allied</a>
		<a href="search_productall.php">รายงานสินค้าคงเหลือแบบเลือกรายการ</a>
		<?php if ($_SESSION['name']=='รุจิรา') {?>
		<a href="https://stock.allwellcenter.com/report_prduct_online.php?name=<?php echo $_SESSION['name']; ?>" target="_blank">รายงานสินค้าคงเหลือน้อยกว่าจุดสั่งซื้อ (ออนไลน์)</a>
		<a href="https://stock.allwellcenter.com/report_prduct_bed.php?name=<?php echo $_SESSION['name']; ?>" target="_blank">รายงานสินค้าคงเหลือน้อยกว่าจุดสั่งซื้อ (เตียงไฟฟ้า)</a>
		<a href="https://stock.allwellcenter.com/report_prduct_mount.php?name=<?php echo $_SESSION['name']; ?>" target="_blank">รายงานสินค้าคงเหลือน้อยกว่าจุดสั่งซื้อ (สินค้าเคลื่อนไหว)</a>
		<?php } ?>
		
    </div>
  </div>
	<?php if ($_SESSION['name']=='ทิพย์ภาพัน' or $_SESSION['name']=='ลักษณาวรรณ' or $_SESSION['name']=='มาลินี' or $_SESSION['name']=='รุจิรา') {?>
	
	<div class="dropdown w3-right">
    <button class="dropbtn">Report ยอดขาย
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
		<?php if ($_SESSION['name']=='ทิพย์ภาพัน' or $_SESSION['name']=='ลักษณาวรรณ') {?>
		<a href="report_solgraph.php">รายงานยอดขายแบบกราฟ แผนก Home Care</a>
		<a href="report_hosgraph.php">รายงานยอดขายแบบกราฟ แผนกโรงพยาบาล</a>
		<a href="report_solgraph1.php">รายงานยอดขายแบบกราฟรวม(เดือน)</a>
		<a href="report_yearcom.php">รายงานยอดขายแบบกราฟรวม(ปี)</a>
		<a href="report_yearhc.php">รายงานยอดขายแบบกราฟ Home Care(ปี)</a>
		<a href="report_yearhos.php">รายงานยอดขายแบบกราฟ Hospital(ปี)</a>
		<a href="report_year31hc.php">รายงานยอดขายแบบกราฟ ร้านขายยา(ปี)</a>
		<a href="report_yearecom.php">รายงานยอดขายแบบกราฟ E-Commerce(ปี)</a>
		<a href="report_countecom.php">รายงานจำนวนขายแบบกราฟ E-Commerce(ปี)</a>
		<a href="report_sumbyproduct.php">รายงานยอดขายเรียงตามสินค้า</a>
		<a href="report_ecomercevip1.php" >รายงานยอดสั่งซื้อ E-Commerce</a>
	    <a href="report_ecomercevip.php" >รายงานเปิดออเดอร์ E-Commerce</a>
		<a href="report_showroomvip.php" >รายงานเปิดออเดอร์ Homecare</a>
	<?php if ($_SESSION['name']=='ทิพย์ภาพัน') {?>	
		<a href="report_sumbyglugopro.php" >รายงานยอดขาย Gluco All-Pro</a>	
		<?php } ?>
		<?php } ?>
		
		<?php if ($_SESSION['name']=='มาลินี' or $_SESSION['name']=='รุจิรา') {?>
		<a href="report_solgraph.php">รายงานยอดขายแบบกราฟ แผนก Home Care</a>
		<a href="report_yearhc.php">รายงานยอดขายแบบกราฟ แผนก Home Care (ปี)</a>
		<a href="report_countecom.php">รายงานจำนวนขายแบบกราฟ E-Commerce(ปี)</a>
		<?php if ($_SESSION['name']=='มาลินี') {?>
		<a href="report_year31hc.php">รายงานยอดขายแบบกราฟ ร้านขายยา(ปี)</a>
		<a href="report_sumpro_bysup.php" >รายงานยอดขายเรียงตามสินค้า</a>
		<a href="report_sumshoeroom.php">รายงานยอดขายแบบกราฟ เขตการขาย SOL</a>
		
		<?php 
}
		?>
		<?php if ($_SESSION['name']=='รุจิรา'){ ?>
	<a href="report_yearecom.php">รายงานยอดขายแบบกราฟ E-Commerce(ปี)</a>	
	<a href="report_dadecom.php">ยอดขายของช่องทาง E-commerce (Dashboard)</a>	
	<a href="report_sumbyproduct.php">รายงานยอดขายเรียงตามสินค้า</a>
	<a href="report_ecomercevip1.php" >รายงานยอดสั่งซื้อ E-Commerce</a>
	<a href="report_ecomercevip.php" >รายงานเปิดออเดอร์ E-Commerce</a>	
		<?php
}
} 
		?>
    </div>
  </div>
	
	<?php } ?>

	 <div class="dropdown w3-right">
    <button class="dropbtn">Report 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
	<a href="search_allwell99.php">Sale Record All</a>
			<a href="search_reccord_supall.php">Sale Record สินค้า</a>
		<a href="search_reccord_supall1.php">Sale Record เลขที่เอกสาร</a>
		<?php if ($_SESSION['name']=='รุจิรา'){ ?>
		<a href="report_smpsumecom.php">รายงานใบเบิกสินค้า SMP (E-Comerce)</a>
		<?php } ?>
		<a href="search_member.php">สรุปตามบัตรสมาชิก</a>
		<a href="search_report_twodate.php">สรุปตามวันที่ (เลือกวัน)</a>
		<a href="search_report_bydate.php">สรุปตามวันที่ (ช่วงเวลา)</a>
		<a href="search_report_byproduct.php">สรุปตามสินค้า (เลือกวัน)</a>
		<a href="search_report_producttwo.php">สรุปตามสินค้า (ช่วงเวลา)</a>
		<a href="search_summary_product.php">สรุปตามสินค้า (เลือกวัน แบบสรุป)</a>
		<a href="search_summary_productdate.php">สรุปตามสินค้า (ช่วงเวลา แบบสรุป)</a>
		<a href="search_bycustomer.php">สรุปจำนวนลูกค้า (เลือกวัน)</a>
		<a href="search_bycustomer_date.php">สรุปจำนวนลูกค้า (ช่วงเวลา)</a>
		<a href="search_summary_channel.php">สรุปจำนวนลูกค้า (ช่วงเวลา)</a>
		 <?php if ($_SESSION['name']=='ทิพย์ภาพัน' or $_SESSION['name']=='ลักษณาวรรณ' or $_SESSION['name']=='มาลินี') {?>
		<a href="search_report_mk.php">สรุปรายการขายแยกตามสินค้า</a>
		<a href="report_supkangbr.php" >รายงานใบยืมคงค้างตาม รพ</a>
		 <a href="report_supkangbrsc.php" >รายการใบยืมฝากขายคงค้าง แยกตามลูกค้า</a>
		<a href="search_supgraph.php" >รายงานรวมยอดขายแบบกราฟแยกเขต</a>
		<a href="search_grapsum.php" >รายงานรวมยอดขายแบบกราฟทั้งหมด</a>
		<?php } ?>
		<a href="search_reportacc.php">รายงานยอดขายประจำวัน</a>
		<a href="search_buyckk.php">รายงานลูกค้าซื้อซ้ำ</a>
		
		<a href="search_sumresearch_sale.php">รายงานสรุปความพึงพอใจลูกค้าหลังการขาย (รายเดือน)</a>
		<a href="search_sumsearch_sale.php">รายงานสรุปความพึงพอใจลูกค้าหลังการขาย (รายปี)</a>
		<a href="search_report_datemar.php">รายงานสรุปรายการสินค้า</a>
		<a href="search_report_customersup.php" >รายงานยอดขายแยกตามลูกค้า</a>
		<a href="search_report_allbyproductsup.php" >รายงานยอดขายแยกตามสินค้า</a>
			<?php if ($_SESSION['name']=='ทิพย์ภาพัน' or $_SESSION['name']=='ลักษณาวรรณ') {?>
		<a href="report_allwellecom.php">รายงานสรุปจำนวนลูกค้าสมาชิก Allwell member</a>
		
		<?php
}												
	if ($_SESSION['name']=='รุจิรา') {?>
		<a href="search_report_customer.php">รายงานประวัติการขาย แยกตามลูกค้า</a>
		<a href="search_report_allbyproduct.php" >รายงานประวัติการขาย แยกตามสินค้า</a>
		<a href="search_cusbuyagain.php" >รายงานลูกค้าซื้อซ้ำของสมาชิก Allwell</a>
		<a href="search_gugosure.php" >รายงานการซื้อเครื่อง และแผ่น GLUCOSURE</a>
		<a href="search_cusmember.php">ข้อมูลการขายของสมาชิก Allwell</a>
		<a href="search_upcus.php">รายการสมาชิกที่มีการอัพเดทสถานะ</a>
		<a href="report_allwellecom.php">รายงานสรุปจำนวนลูกค้าสมาชิก Allwell member</a>
		<a href="status_almostpro.php">รายการสินค้ายอดนิยมออนไลน์สินค้าคงเหลือต่ำกว่ากำหนด</a>
		<?php } ?>
    </div>
  </div>
	
		
	 <div class="dropdown w3-right">
    <button class="dropbtn">Setting 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <a href="add_customer.php">ลูกค้า</a>
		<a href="add_customer_rgister.php">บัตรสมาชิก</a>
	   <a href="add_vendor.php">ผู้ขาย</a>
      <a href="add_salechannel.php">ช่องทางการขาย</a>
	  <a href="add_delivery.php">การจัดส่ง</a>
	  <a href="add_leaflet.php">ใบตรวจทาน</a>
		<?php if ($_SESSION['name']=='รุจิรา') {?>
	<a href="status_warproduct.php">ข้อมูลรายการรับประกันสินค้า</a>	
	 <a href="run_customer.php">รันลูกค้า</a>
	 <a href="status_online_cls.php">สินค้ายอดนิยมออนไลน์</a>	
	<?php } ?>
    </div>
  </div>
	
	
		<div class="dropdown w3-right">
    <button class="dropbtn">คู่มือการใช้งาน
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
  <a href="manual/Story_Sup.pdf">คู่มือรายการรับเรื่องลูกค้า</a>
		<a href="manual/Jong_Sup.pdf">คู่มือ ใบจอง</a>
		<a href="manual/BR_Sup.pdf">คู่มือ ใบยืม</a>
		<a href="manual/ClearBr_Sup.pdf">คู่มือ การเคลียร์ใบยืม</a>
		<a href="manual/SaleOrder_Sup.pdf">คู่มือ ใบสั่งขาย</a>
		<a href="manual/SO_IC.pdf">คู่มือ ใบสั่งขาย IC</a>
		<a href="manual/Order_Sup.pdf">คู่มือ ใบฝาก</a>
		<a href="manual/Credit_Sup.pdf">คู่มือ ใบลดหนี้</a>
		<a href="manual/Change_Sup.pdf">คู่มือ ใบแลกเปลี่ยน</a>
		<a href="manual/Sample_Sup.pdf">คู่มือ ใบเบิกเพื่อสนับสนุนการขาย</a>
		<a href="manual/Research_Sup.pdf">คู่มือ แบบประเมินความพึงพอใจ</a>
    </div>
  </div>
  
  <div class="dropdown w3-right">
    <button class="dropbtn">ใบขอสั่งซื้อ
      <i class="fa fa-caret-down"></i>
    </button>
    		<div class="dropdown-content">
       <a href="https://inter.allwellcenter.com/index.php" >เข้าสู่ ใบขอสั่งซื้อ</a>
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