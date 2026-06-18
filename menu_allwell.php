
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
  <a href="main_admin.php" class="active"><img width="150" height="33" src="img/allwellsale_logo.png"></a>
  	<?php if ($_SESSION['name']=='ชนิกานต์' or $_SESSION['name']=='ชนาภา' or $_SESSION['name']=='ปาลิตา' or $_SESSION['name']=='ศุภลักษณ์'  or $_SESSION['name']=='ปวัน​รัตน์​' or $_SESSION['name']=='กัญญารัตน์' or $_SESSION['name']=='ธัญนุช' or $_SESSION['name']=='มิณฑิตา') { ?> 
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
	
<?php if ($_SESSION['name']=='ปาลิตา'   or $_SESSION['name']=='กัญญารัตน์') { ?> 	
<div class="dropdown w3-right">
    <button class="dropbtn">Setting 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <a href="status_customerallwell.php">ลูกค้า</a>
		<a href="add_customer_rgister.php">บัตรสมาชิก</a>
	   </div>
  </div>	
	<?php } ?>
		
	<div class="dropdown w3-right">
    <button class="dropbtn">ยอดสินค้า
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
         <?php /*<a href="report_hotpro1.php">รายงานสินค้าคงเหลือ ยอดนิยม เตียงและสินค้าประกอบ</a>
		<a href="report_hotpro2.php">รายงานสินค้าคงเหลือ ยอดนิยม สินค้า Online</a>
		<a href="report_hotpro3.php">รายงานสินค้าคงเหลือ ยอดนิยม สินค้าทั่วไป</a>
		<a href="report_hotpro4.php">รายงานสินค้าคงเหลือ ยอดนิยมสินค้า Allied</a>*/ ?>
		
		 <a href="https://stock.allwellcenter.com/report_hotpro1.php?sale=<?php echo $_SESSION["type_login"]; ?>" target="_blank">รายงานสินค้าคงเหลือ ยอดนิยม เตียงและสินค้าประกอบ</a>
		<a href="https://stock.allwellcenter.com/report_hotpro2.php?sale=<?php echo $_SESSION["type_login"]; ?>" target="_blank">รายงานสินค้าคงเหลือ ยอดนิยม สินค้า Online</a>
		<a href="https://stock.allwellcenter.com/report_hotpro3.php?sale=<?php echo $_SESSION["type_login"]; ?>" target="_blank">รายงานสินค้าคงเหลือ ยอดนิยม สินค้าทั่วไป</a>
		<a href="https://stock.allwellcenter.com/report_hotpro4.php?sale=<?php echo $_SESSION["type_login"]; ?>" target="_blank">รายงานสินค้าคงเหลือ ยอดนิยมสินค้า Allied</a>
		<a href="search_productall.php">รายงานสินค้าคงเหลือแบบเลือกรายการ</a>
		<?php if($_SESSION['name']=='ชนิกานต์'    or $_SESSION['name']=='กัญญารัตน์' or $_SESSION['name']=='ปาลิตา' or $_SESSION['name']=='ปวัน​รัตน์​'){?>
		<a href="https://stock.allwellcenter.com/report_prduct_online.php" target="_blank">รายงานสินค้าคงเหลือน้อยกว่าจุดสั่งซื้อ (ออนไลน์)</a>
		<a href="https://stock.allwellcenter.com/report_prduct_bed.php" target="_blank">รายงานสินค้าคงเหลือน้อยกว่าจุดสั่งซื้อ (เตียงไฟฟ้า)</a>
		<?php } ?>
    </div>
  </div>
	
	
	 <div class="dropdown w3-right">
    <button class="dropbtn">Report ยอดขาย
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
	
	<a href="search_reccord_supall.php">Sale Record สินค้า</a>
	<a href="search_reccord_supall1.php">Sale Record เลขที่เอกสาร</a>
		<?php if($_SESSION['name']=='ชนิกานต์' or $_SESSION['name']=='ปาลิตา'   or $_SESSION['name']=='กัญญารัตน์' or $_SESSION['name']=='ปวัน​รัตน์​' or $_SESSION['name']=='ชนาภา' or $_SESSION['name']=='ธัญนุช' or $_SESSION['name']=='มิณฑิตา'){ ?>
		<a href="report_dadecom.php">ยอดขายของช่องทาง E-commerce (Dashboard)</a>
		<?php if($_SESSION['name']=='ชนิกานต์' or $_SESSION['name']=='ปาลิตา'  or $_SESSION['name']=='กัญญารัตน์' or $_SESSION['name']=='ชนาภา'){ ?>
		<a href="report_ecomercevip.php" >รายงานเปิดออเดอร์ E-Commerce</a>
		<a href="report_ecomercevip1.php" >รายงานยอดสั่งซื้อ E-Commerce</a>
		<?php }
				} 
		?>
	</div>
  </div>
	<?php if( $_SESSION['name']=='ปาลิตา'   or $_SESSION['name']=='กัญญารัตน์'){ ?>
	
	<div class="dropdown w3-right">
    <button class="dropbtn">ใบสั่งลดหนี้
      <i class="fa fa-caret-down"></i>
    </button>
	   <div class="dropdown-content">
   	 <a href="register_credit_allwell.php" >สร้างใบสั่งลดหนี้</a>
	 <a href="status_credit_mk.php" >รายการใบสั่งลดหนี้</a>
    </div>
  </div>
	<?php } ?>
	
	<?php if ($_SESSION['name']=='ชนาภา') { ?> 
<div class="dropdown w3-right">
    <button class="dropbtn">รับคืนสินค้า
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
	<a href="status_receive_allwell.php" >Status บันทึกรับคืนสินค้า</a>
	 
    </div>
  </div>
	<?php } ?>
		<div class="dropdown w3-right">
    <button class="dropbtn">Allwell
      <i class="fa fa-caret-down"></i>
    </button>
	   <div class="dropdown-content">
   	 <a href="main_allwell_br.php" >Create ใบยืม</a>
	<a href="main_allwell_so.php" >Create ใบสั่งขาย</a>
	 <a href="status_allwell.php" >Status เอกสาร</a>
    <a href="status_ecomsmp.php" >Status Ecommerce</a>
	<a href="status_adminprice.php">Status ออเดอร์สินค้าราคาต่ำกว่ากำหนด</a>
	 <?php if(  $_SESSION['name']=='กัญญารัตน์' or $_SESSION['name']=='ปาลิตา'){ ?>
		
		<a href="status_mkchange_glu.php" >รายการออเดอร์เครื่อง G-426</a>
		<a href="status_mkchange_glucos.php" >รายการออเดอร์เครื่อง GLUCOSURE</a>
		<a href="register_chother_blood.php" >ลงทะเบียนลูกค้าแลกเครื่องวัดน้ำตาล</a>   
		<a href="status_bloodch.php" >รายการลูกค้าแลกเครื่องวัดน้ำตาลยี้ห้ออื่น</a>      
		  <?php } ?>
	<a href="status_brclear_allwell.php" >ใบยืมค้างเคลียร์</a>
		<a href="status_clearbrmm.php" >Status โชว์เคลียร์ยิม</a>
		<a href="search_brkangclear.php">รายงานใบยืมค้างเคลียร์ Showroom</a>
	<a href="status_etaxcustomer.php" >ข้อมูลลูกค้าขอใบกำกับภาษี</a>	   
    </div>
  </div>
	
	<!--div class="dropdown w3-right">
    <button class="dropbtn">AllWell 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
		<a href="main_allwell_so.php" >Create ใบสั่งขาย</a>
	   <a href="main_allwell_br.php" >Create ใบยืม</a>
		<a href="status_allwell.php" >Status</a>
	
		 </div>
  </div-->
	<?php if ($_SESSION['name']=='ปาลิตา') { ?> 	
	
	<div class="dropdown w3-right">
    <button class="dropbtn">ใบสั่งขาย IC 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
   
	<a href="main_salehos_so.php" >Sale Order (SO)</a>
    <a href="status_saleic.php" >Status (IC) ฝากขาย</a>
	
		    </div>
  </div>
	
	
	<?php } ?>
	
	<div class="dropdown w3-right">
    <button class="dropbtn">ใบเบิกสินค้า
      <i class="fa fa-caret-down"></i>
    </button>
	   <div class="dropdown-content">
   	 <a href="main_allwell_smp.php" >สร้างใบเบิกสินค้า</a>
	 <a href="status_sampleallwell.php" >รายการใบเบิกสินค้า</a>
	<a href="status_samplemm.php" >รายการใบเบิกสินค้า MM2</a>
	    </div>
  </div>
	
	<?php if($_SESSION['name']=='ปวัน​รัตน์​' or $_SESSION['name']=='ธัญนุช' or $_SESSION['name']=='มิณฑิตา'){ ?>
	  <div class="dropdown w3-right">
    <button class="dropbtn">ใบยืม 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
   	<a href="main_salehos_br.php" >Borrow (BR)</a>	
	<a href="status_brhos.php" >Status (BR)</a>
	<a href="status_clearbr.php" >Status ใบยืมค้างเคลียร์</a>
	<a href="report_brkangbyarea.php" >ตรวจเช็คใบยืมค้างเคลียร์ (stock)</a>
	<a href="status_brsalearea.php" >รายการตรวจเช็คใบยืม (ทั้งหมด)</a>
    </div>
  </div>
	
	
	<div class="dropdown w3-right">
    <button class="dropbtn">ใบสั่งขาย 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
   
	<a href="main_suphos_so.php" >Sale Order (SO)</a>
    <a href="status_mkhos.php" >Status (SO)</a>
	<a href="status_glucosemkhos.php" >รายงานรอส่ง SN Gluco All-Pro</a>	
	</div>
  </div>
	
	
	 <?php } ?>
	
	
	
	 <div class="dropdown w3-right">
    <button class="dropbtn">Report 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
			<a href="search_report_mk1.php">สรุปรายการขายแยกตามสินค้า</a>
	<!--a href="search_allwell99.php" >Sale Record All</a>
		<a href="search_allwell.php" >Sale Record สินค้า</a>
      <a href="search_allwell1.php" >Sale Record เลขที่เอกสาร</a> ?>
		
		<a href="search_sale_record.php">Sale Record สินค้า</a>
		<a href="search_sale_record1.php">Sale Record เลขที่เอกสาร</a-->
		<a href="search_report_twodate.php">สรุปตามวันที่ (เลือกวัน)</a>
		<a href="search_report_bydate.php">สรุปตามวันที่ (ช่วงเวลา)</a>
		<a href="search_report_byproduct.php">สรุปตามสินค้า (เลือกวัน)</a>
		<a href="search_report_producttwo.php">สรุปตามสินค้า (ช่วงเวลา)</a>
		<a href="search_summary_product.php">สรุปตามสินค้า (เลือกวัน แบบสรุป)</a>
		<a href="search_summary_productdate.php">สรุปตามสินค้า (ช่วงเวลา แบบสรุป)</a>
		<a href="search_reportacc.php">รายงานยอดขายประจำวัน</a>
		<a href="search_bycustomer.php">สรุปจำนวนลูกค้า (เลือกวัน)</a>
		<a href="search_bycustomer_date.php">สรุปจำนวนลูกค้า (ช่วงเวลา)</a>
		<a href="search_summary_channel.php">สรุปจำนวนลูกค้า (ช่วงเวลา)</a>
		<a href="search_buyckk.php">รายงานลูกค้าซื้อซ้ำ</a>
		<a href="search_report_datemar.php">รายงานสรุปรายการสินค้า</a>
		<a href="search_sumresearch_mk.php">รายงานสรุปแบบสอบถามความพึงพอใจลูกค้าหลังการขายที่ต้องทำ</a>
		<a href="search_sumresearch_sale.php">รายงานสรุปความพึงพอใจลูกค้าหลังการขาย (รายเดือน)</a>
		<a href="search_sumresearch_sale1.php">รายงานสรุปความพึงพอใจลูกค้าหลังการขายแบบใหม่ (รายเดือน)</a>
		<a href="search_sumsearch_sale.php">รายงานสรุปความพึงพอใจลูกค้าหลังการขาย (รายปี)</a>
		<a href="search_sumsearch_salenew.php">รายงานสรุปความพึงพอใจลูกค้าหลังการขายแบบใหม่ (รายปี)</a>
		<a href="search_research_cs.php">รายงานความพึงพอใจของการจัดส่งและการประกอบติดตั้ง</a>
		<a href="search_research_cs1.php">รายงานความพึงพอใจของการจัดส่งและการประกอบติดตั้งแบบใหม่</a>
		<a href="search_report_mk.php">ประวัติการขาย / แยกตามสินค้า</a>
		
		<?php if ($_SESSION['name']=='ชนิกานต์' or $_SESSION['name']=='ปาลิตา'   or $_SESSION['name']=='กัญญารัตน์' or $_SESSION['name']=='ปวัน​รัตน์​' or $_SESSION['name']=='ธัญนุช' or $_SESSION['name']=='มิณฑิตา') {?>
		<a href="search_report_customer.php">รายงานประวัติการขาย แยกตามลูกค้า</a>
		<a href="search_report_allbyproduct.php" >รายงานประวัติการขาย แยกตามสินค้า</a>
		<a href="search_cusbuyagain.php" >รายงานลูกค้าซื้อซ้ำของสมาชิก Allwell</a>
		<a href="search_gugosure.php" >รายงานการซื้อเครื่อง และแผ่น GLUCOSURE</a>
		<a href="search_cusmember.php">ข้อมูลการขายของสมาชิก Allwell</a>
		<a href="search_upcus.php">รายการสมาชิกที่มีการอัพเดทสถานะ</a>
		<?php if ($_SESSION['name']=='ชนิกานต์') {?>
		<a href="report_allwellecom.php">รายงานสรุปจำนวนลูกค้าสมาชิก Allwell member</a>
		<?php 
		} 
		}
		?>
<?php if ($_SESSION['name']=='ปาลิตา'    or $_SESSION['name']=='กัญญารัตน์') { ?> 	
<a href="status_almostpro.php">รายการสินค้ายอดนิยมออนไลน์สินค้าคงเหลือต่ำกว่ากำหนด</a>	
<?php } ?>
		
    </div>
  </div>
	
	
	
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
    <button class="dropbtn">คุณ<?php echo $_SESSION['name']; ?>&nbsp;<?php echo $_SESSION['surname']; ?>
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content w3-right">
      <a href="change_pass.php">Change Password</a>
		<a href="https://allwellcenter.com/itsupport/" target="_blank">แจ้งปัญหาการใช้งาน</a>
        <a href="logout.php">Logout</a>
    </div>
  </div>
	
	<div class="dropdown w3-right">
    <button class="dropbtn">Setting 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <a href="status_customerallwell.php">ลูกค้า</a>
		<a href="add_customer_rgister.php">บัตรสมาชิก</a>
	   <a href="add_vendor.php">ผู้ขาย</a>
      <a href="add_salechannel.php">ช่องทางการขาย</a>
	  <a href="add_delivery.php">การจัดส่ง</a>
	  <!--a href="add_leaflet.php">ใบตรวจทาน</a-->
     <a href="run_customer.php">รันลูกค้า</a>

    </div>
  </div>
	
	<div class="dropdown w3-right">
    <button class="dropbtn">แบบสอบถาม
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
    <a href="research_showroom.php">แบบสอบถามลูกค้า Showroom</a>
	<a href="status_showroom.php">รายการแบบสอบถาม</a>
	<a href="report_rsshowroom.php">รายงานแบบสอบถาม</a>	
	 <a href="status_soldemo.php" >ทำแบบสอบถามสินค้าสาธิต</a>
	<a href="status_soldemoall.php" >แบบสอบถามสินค้าสาธิตทั้งหมด</a>   
	<a href="status_reserch_receive.php" >แบบประเมินความพึงพอใจในการจัดสินค้า</a>
    </div>
  </div>
	
		<div class="dropdown w3-right">
    <button class="dropbtn">ยอดสินค้า
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
        <?php /* <a href="report_hotpro1.php">รายงานสินค้าคงเหลือ ยอดนิยม เตียงและสินค้าประกอบ</a>
		<a href="report_hotpro2.php">รายงานสินค้าคงเหลือ ยอดนิยม สินค้า Online</a>
		<a href="report_hotpro3.php">รายงานสินค้าคงเหลือ ยอดนิยม สินค้าทั่วไป</a>
		<a href="report_hotpro4.php">รายงานสินค้าคงเหลือ ยอดนิยมสินค้า Allied</a>*/ ?>
		
		 <a href="https://stock.allwellcenter.com/report_hotpro1.php?sale=<?php echo $_SESSION["type_login"]; ?>" target="_blank">รายงานสินค้าคงเหลือ ยอดนิยม เตียงและสินค้าประกอบ</a>
		<a href="https://stock.allwellcenter.com/report_hotpro2.php?sale=<?php echo $_SESSION["type_login"]; ?>" target="_blank">รายงานสินค้าคงเหลือ ยอดนิยม สินค้า Online</a>
		<a href="https://stock.allwellcenter.com/report_hotpro3.php?sale=<?php echo $_SESSION["type_login"]; ?>" target="_blank">รายงานสินค้าคงเหลือ ยอดนิยม สินค้าทั่วไป</a>
		<a href="https://stock.allwellcenter.com/report_hotpro4.php?sale=<?php echo $_SESSION["type_login"]; ?>" target="_blank">รายงานสินค้าคงเหลือ ยอดนิยมสินค้า Allied</a>
		<a href="search_productall.php">รายงานสินค้าคงเหลือแบบเลือกรายการ</a>
		
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
    <button class="dropbtn">Report 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
		<a href="search_allwell99.php" >Sale Record All</a>
		<a href="search_allwell.php" >Sale Record สินค้า</a>
      <a href="search_allwell1.php" >Sale Record เลขที่เอกสาร</a>
	  <a href="search_clearbr.php">รายงานใบยืมที่ถูกเคลียร์ยืมแล้ว</a>
	  <?php /* 
		<a href="search_solrecpro.php">Sale Record สินค้า (ออนไลน์)</a>
		<a href="search_solrec.php">Sale Record เลขที่เอกสาร (ออนไลน์)</a>
	  */ ?>
		<a href="search_sumresearch_mk.php">รายงานสรุปแบบสอบถามความพึงพอใจลูกค้าหลังการขายที่ต้องทำ</a>
		<a href="search_member.php">สรุปตามบัตรสมาชิก</a>
		<a href="search_upcus.php">รายการสมาชิกที่มีการอัพเดทสถานะ</a>
		<a href="search_report_twodate.php">สรุปตามวันที่ (เลือกวัน)</a>
		<a href="search_report_bydate.php">สรุปตามวันที่ (ช่วงเวลา)</a>
		<a href="search_report_byproduct.php">สรุปตามสินค้า (เลือกวัน)</a>
		<a href="search_report_producttwo.php">สรุปตามสินค้า (ช่วงเวลา)</a>
		<a href="search_summary_product.php">สรุปตามสินค้า (เลือกวัน แบบสรุป)</a>
		<a href="search_summary_productdate.php">สรุปตามสินค้า (ช่วงเวลา แบบสรุป)</a>
		<a href="search_bycustomer.php">สรุปจำนวนลูกค้า (เลือกวัน)</a>
		<a href="search_bycustomer_date.php">สรุปจำนวนลูกค้า (ช่วงเวลา)</a>
		<a href="search_summary_channel.php">สรุปจำนวนลูกค้า (ช่วงเวลา)</a>
		<a href="search_reportacc.php">รายงานยอดขายประจำวัน</a>
		<a href="search_buyckk.php">รายงานลูกค้าซื้อซ้ำ</a>
		<a href="search_report_mk.php">สรุปรายการขายแยกตามสินค้า</a>
        <a href="search_report_customer.php">รายงานประวัติการขาย แยกตามลูกค้า</a>
		<a href="search_sumresearch_sale.php">รายงานสรุปความพึงพอใจลูกค้าหลังการขาย</a>
    </div>
  </div>
	
	

				<?php
	if ($_SESSION['name']!='รุจิรา') { ?>
	
	<div class="dropdown w3-right">
    <button class="dropbtn">ใบเบิกสินค้า
      <i class="fa fa-caret-down"></i>
    </button>
	   <div class="dropdown-content">
   	 <a href="main_allwell_smp.php" >สร้างใบเบิกสินค้า</a>
	 <a href="status_sampleallwell.php" >รายการใบเบิกสินค้า</a>
    </div>
  </div>
	
	<div class="dropdown w3-right">
    <button class="dropbtn">ใบสั่งลดหนี้
      <i class="fa fa-caret-down"></i>
    </button>
	   <div class="dropdown-content">
   	 <a href="register_credit_allwell.php" >สร้างใบสั่งลดหนี้</a>
	 <a href="status_credit_allwell.php" >รายการใบสั่งลดหนี้</a>
    </div>
  </div>
	
      <?php } ?>	
	
	
	
	 <div class="dropdown w3-right">
    <button class="dropbtn">ใบแลกเปลี่ยนสินค้า
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
	<a href="main_allwell_change.php" >สร้างใบแลกเปลี่ยนสินค้า</a>
		<a href="status_allwellchange.php" >รายการใบแลกเปลี่ยนสินค้า</a>
	 
    </div>
  </div>
	
	<div class="dropdown w3-right">
    <button class="dropbtn">รับคืนสินค้า
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
	<a href="status_receive_allwell.php" >Status บันทึกรับคืนสินค้า</a>
	 
    </div>
  </div>
	
	<div class="dropdown w3-right">
    <button class="dropbtn">Import
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
	<a href="upload_99.php" >Upload ข้อมูลร้าน 99</a>
	 <a href="upload_tran.php" >Upload ค่าจัดส่ง</a>
    </div>
  </div>
	
	<div class="dropdown w3-right">
    <button class="dropbtn">ใบสั่งเช่า
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
	<a href="main_allwell_rental.php" >ใบสั่งเช่า</a>
	<a href="status_allwellrental.php" >Status ใบสั่งเช่า</a>
	<a href="status_allwellrental_kang.php" >Status ใบสั่งเช่ารอออกใบสั่งขาย</a>
		
	</div>
  </div>
	
	
	<div class="dropdown w3-right">
    <button class="dropbtn">AllWell 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
		<a href="main_allwell_so.php" >Create ใบสั่งขาย</a>
	   <a href="main_allwell_br.php" >Create ใบยืม</a>
		<!--a href="upload_99hmset1.php" >Upload รายการน้ำท่วม ลูกค้ารับสินค้า</a>
		<a href="upload_99hmset2.php" >Upload รายการน้ำท่วม ลูกค้าไม่รับสินค้า</a-->
		<a href="status_allwell.php" >Status</a>
		<a href="status_allwell_fak.php" >Status ใบฝาก</a>
		<a href="status_onlinekangsend.php">Status เตียงค้างส่ง</a>
		<a href="status_admin_bedkang.php">Status เตียง ค้าง IV</a>
		<a href="status_allwell_adminfak.php">Status ใบฝาก</a>
		<a href="status_researchk_sol.php">Status ค้างทำแบบสอบถาม</a>
		<a href="status_searchproduct.php" >Status Search Product</a>
		<?php if($_SESSION['name']=='รัชดาภรณ์' or $_SESSION['name']=='ธนบัตร' or $_SESSION['name']=='นิรชา' or $_SESSION['name']=='กนกพร'){ ?>
		<a href="status_mkchange_glu.php" >รายการออเดอร์เครื่อง G-426</a>
		<a href="status_mkchange_glucos.php" >รายการออเดอร์เครื่อง GLUCOSURE</a>
		<a href="register_chother_blood.php" >ลงทะเบียนลูกค้าแลกเครื่องวัดน้ำตาล</a>   
		<a href="status_bloodch.php" >รายการลูกค้าแลกเครื่องวัดน้ำตาลยี้ห้ออื่น</a>  
		<?php } ?>
		<a href="status_brclear_allwell.php" >ใบยืมค้างเคลียร์</a>
		<a href="status_clearbrmm.php" >Status โชว์เคลียร์ยิม</a>
		<a href="report_itkangbr_all.php" >รายงานใบยืมค้างเคลียร์ ตามเขตการขาย</a>
		<a href="search_brkangclear.php">รายงานใบยืมค้างเคลียร์ Showroom</a>
		<a href="report_brkangbyaw.php" >ตรวจเช็คใบยืมค้างเคลียร์ (stock)</a>
	    <a href="status_brareaaw.php" >รายการตรวจเช็คใบยืม (ทั้งหมด)</a>
		<a href="report_waitcod.php" >รายการเก็บเงินปลายทาง</a>
		
	<?php if ($_SESSION['type_login']=='Sup_AllWell') { ?>   	   <a href="status_approve_sol.php" >อนุมัติ</a>
   <?php } ?>
		
		 </div>
  </div>
	<?php if ($_SESSION['type_login']=='Sup_AllWell') { ?>
	
	<?php if ($_SESSION['name']!='รุจิรา') { ?> 
	<div class="dropdown w3-right">
    <button class="dropbtn">Hospital 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
		
	 <a href="status_br_hos.php" >Status (BR)</a>
  <a href="status_hos.php" >Status (SO)</a>
  <a href="register_br_hos.php" >Borrow (BR)</a>
  <a href="register_sale_hos.php" >Sale Order (SO)</a>
		
		 </div>
  </div>
	
	<?php } } 
			   }
	?>
	<?php
	if ($_SESSION['name']!='รุจิรา') { ?> 
		
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
   
 <a href="main_homecare_jong.php" >สร้างใบจอง</a>
 <a href="status_homecare.php" >Status ใบจอง</a>
 <a href="status_homecare_clear.php" >Status ใบจองค้างเคลียร์</a>
		 
    </div>
  </div>
	
	
	<div class="dropdown w3-right">
    <button class="dropbtn">ใบเสนอราคา
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
		<a href="main_qou.php">สร้างใบเสนอราคา</a>
		<a href="status_qou.php">รายการใบเสนอราคา</a>
		
		 </div>
  </div>
	
	<?php } ?>
	
	<div class="dropdown w3-right">
    <button class="dropbtn">รายการรับเรื่องจากลูกค้า      
	<i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
   <a href="register_story.php" >การรับเรื่องจากลูกค้า</a>
	<a href="status_storycreate.php" >รายการรับเรื่องจากลูกค้าเอง</a>
   <a href="status_storykangall.php" >รายการรับเรื่องจากลูกค้า (ค้าง)</a>
   <a href="status_storyallwellall.php" >รายการรับเรื่องจากลูกค้า (ปิดงานแล้ว)</a>
		
	 <a href="register_cuseng.php" >การรับเรื่องลูกค้าของช่าง</a>
	<a href="status_cusopen.php" >รายการรับเรื่องลูกค้าช่าง</a>	
		
      </div>
  </div>
	
 
	
	<div class="dropdown w3-right">
    <button class="dropbtn">คู่มือการใช้งาน
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
  <a href="manual/Story_Allwell.pdf">คู่มือรายการรับเรื่องลูกค้า</a>
		<a href="manual/Jong_Allwell.pdf">คู่มือ ใบจอง</a>
		<a href="manual/BR_Allwell.pdf">คู่มือ ใบยืม</a>
		<a href="manual/ClearBr_Allwell.pdf">คู่มือ การเคลียร์ใบยืม</a>
		<a href="manual/SaleOrder_Allwell.pdf">คู่มือ ใบสั่งขาย</a>
		<a href="manual/Order_Allwell.pdf">คู่มือ ใบฝาก</a>
		<a href="manual/Credit_Allwell.pdf">คู่มือ ใบลดหนี้</a>
		<a href="manual/Change_Allwell.pdf">คู่มือ ใบแลกเปลี่ยน</a>
		<a href="manual/Sample_Allwell.pdf">คู่มือ ใบเบิกเพื่อสนับสนุนการขาย</a>
		<a href="manual/Research_Allwell.pdf">คู่มือ แบบประเมินความพึงพอใจ</a>
    </div>
  </div>
	
		
	
<?php if ($_SESSION['name']=='นิรชา' or $_SESSION['name']=='รัชดาภรณ์' or $_SESSION['name']=='ธนบัตร' or $_SESSION['name']=='กนกพร') { ?> 
	
	
	<?php
$strSQLp5 = "SELECT *  FROM fb__maim  where  status_doc ='3' and department_id LIKE '%SO%'";
$objQueryp5 = mysqli_query($user,$strSQLp5) or die ("Error Query [".$strSQL5."]");
$Num_Rowsp5 = mysqli_num_rows($objQueryp5);				
?>				
	
<div class="dropdown w3-right">
    <button class="dropbtn">แบบฟอร์ม Feedback <?php if($Num_Rowsp5 > 0 ){ ?><font color="red">(<?php echo $Num_Rowsp5; ?>)</font><?php } ?>
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
   
   	<a href="https://feedback.allwellcenter.com/check_login_out.php?token=<?php echo  $token; ?>"  target="_blank" >แบบฟอร์ม Feedback <?php if($Num_Rowsp5 > 0 ){ ?><font color="red">(<?php echo $Num_Rowsp5; ?>)</font><?php } ?></a>
	
	    </div>
  </div>
	
	
	
	 <div class="dropdown w3-right">
    <button class="dropbtn">Report ยอดขาย
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
	
	<a href="search_reccord_supall.php">Sale Record สินค้า</a>
		<a href="search_reccord_supall1.php">Sale Record เลขที่เอกสาร</a>
	</div>
  </div>

	
	<div class="dropdown w3-right">
    <button class="dropbtn">รายงานใบยืมสินค้าคงเหลือ
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
	<a href="search_sumbrpdk.php"  target="_blank">รายงานใบยืมสินค้าคงเหลือตามสินค้า</a>
		<a href="report_sumbrpdk_all.php"  target="_blank">รายงานใบยืมสินค้าคงเหลือทั้งหมด</a>
	</div>
  </div>
	
	
	<?php

} if($_SESSION['name']=='ปวัน​รัตน์​'){		?>
	
	 <div class="dropdown w3-right">
    <button class="dropbtn">Report ยอดขาย
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
	
	<a href="search_reccord_supall.php">Sale Record สินค้า</a>
	<a href="search_reccord_supall1.php">Sale Record เลขที่เอกสาร</a>
	<a href="report_dadecom.php">ยอดขายของช่องทาง E-commerce (Dashboard)</a>	
	
	</div>
  </div>
	
	
	<?php } ?>
	
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