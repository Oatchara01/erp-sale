
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
	<?php if($_SESSION['user_type']=="Inter" or $_SESSION['user_type']=="HR"){ ?>
 <a href="main_admin.php" class="active"><img width="150" height="33" src="img/allwellsale_logo.png"></a>	
	<?php }else{ ?>
  <a href="main_salehos.php" class="active"><img width="150" height="33" src="img/allwellsale_logo.png"></a>
  <?php } ?>
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
	
	<?php if($_SESSION['user_type']=="Inter"){ ?>
	
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
		 <a href="status_receive_sale.php" >Status บันทึกรับคืนสินค้า</a> 
    </div>
  </div>
	
	
	<div class="dropdown w3-right">
    <button class="dropbtn">ใบเบิกสินค้า 
      <i class="fa fa-caret-down"></i>
    </button>
	   <div class="dropdown-content">
   	 <a href="main_suphos_smp.php" >สร้างใบเบิกสินค้า (สนับสนุนการขาย)</a>
	 <a href="status_samplehr.php" >รายการใบเบิกสินค้า (สนับสนุนการขาย)</a>


	    </div>
  </div>
	
	
	<div class="dropdown w3-right">
    <button class="dropbtn">รายการรับเรื่อง    
	<i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
	<a href="register_cuseng.php" >การรับเรื่องลูกค้าของช่าง</a>
	<a href="status_cusopen.php" >รายการรับเรื่องลูกค้าช่าง</a>	
		
	     </div>
  </div>	
	
	
	
	<?php }else if($_SESSION['user_type']=="HR"){ ?>
	
	<div class="dropdown w3-right">
    <button class="dropbtn">ใบเบิกสินค้า 
      <i class="fa fa-caret-down"></i>
    </button>
	   <div class="dropdown-content">
   	 <a href="main_suphos_smp.php" >สร้างใบเบิกสินค้า (สนับสนุนการขาย)</a>
	 <a href="status_samplehr.php" >รายการใบเบิกสินค้า (สนับสนุนการขาย)</a>


	    </div>
  </div>
	
	<div class="dropdown w3-right">
    <button class="dropbtn">รายการรับเรื่อง    
	<i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
	<a href="register_cuseng.php" >การรับเรื่องลูกค้าของช่าง</a>
	<a href="status_cusopen.php" >รายการรับเรื่องลูกค้าช่าง</a>	
		
	     </div>
  </div>	
	
	<div class="dropdown w3-right">
    <button class="dropbtn">คีย์ค่าขนส่ง     
	<i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
	 <a href="register_deloth.php" >คีย์ค่าขนส่ง</a>
		<a href="status_deloth.php" >รายการค่าขนส่ง</a>	
      </div>
  </div>
	
	
	<?php
	}else{
	
	
	if($_SESSION['user_type']=="Engineer"){ ?>
<div class="dropdown w3-right">
    <button class="dropbtn">Setting 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      	  <a href="add_leaflet.php">รายการใบตรวจทาน</a>
		<a href="add_customer.php">ลูกค้า</a>
		    </div>
  </div>	
	 <?php } ?>	
	
	
	<?php if  ($_SESSION['code']=="SM1"){  }else{?>
	<div class="dropdown w3-right">
    <button class="dropbtn">แบบสอบถาม
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
	<a href="status_saleresearch.php" >ทำแบบสอบถามหลังการขาย</a>
	<a href="status_salechangeall.php" >Status แบบสอบถามหลังการขายทั้งหมด</a>
	 <a href="status_saledemo.php" >ทำแบบสอบถามสินค้าสาธิต</a>
	<a href="status_saledemoall.php" >แบบสอบถามสินค้าสาธิตทั้งหมด</a>
	<a href="status_reserch_receive.php" >แบบประเมินความพึงพอใจในการจัดสินค้า</a>
	 
    </div>
  </div>
	
	<?php } ?>
	
	<div class="dropdown w3-right">
    <button class="dropbtn">ตารางรถใหญ่ 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
   
    <a href="veiw_bussend.php" >ตารางรถใหญ่</a>
      </div>
  </div>
	
	<div class="dropdown w3-right">
    <button class="dropbtn">ใบเบิกสินค้า
      <i class="fa fa-caret-down"></i>
    </button>
	   <div class="dropdown-content">
   	 <a href="main_salehos_smp.php" >สร้างใบเบิกสินค้า</a>
	 <a href="status_samplesale.php" >รายการใบเบิกสินค้า</a>
    </div>
  </div>
	
	<div class="dropdown w3-right">
    <button class="dropbtn">ใบสั่งลดหนี้
      <i class="fa fa-caret-down"></i>
    </button>
	   <div class="dropdown-content">
   	 <a href="register_credit_sale.php" >สร้างใบสั่งลดหนี้</a>
	 <a href="status_credit_sale.php" >รายการใบสั่งลดหนี้</a>
    </div>
  </div>
	
	<div class="dropdown w3-right">
    <button class="dropbtn">ใบ PO
      <i class="fa fa-caret-down"></i>
    </button>
	   <div class="dropdown-content">
   	  <a href="status_po_sale.php" >รายการใบ PO ค้างเปิดใบสั่งขาย</a>
	  <a href="status_po_saleall.php" >รายการใบ PO ทั้งหมด</a>
    </div>
  </div>
	
	
  <div class="dropdown w3-right">
    <button class="dropbtn">ใบแลกเปลี่ยนสินค้า
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
	<a href="main_salehos_change.php" >สร้างใบแลกเปลี่ยนสินค้า</a>
		<a href="status_salechange.php" >รายการใบแลกเปลี่ยนสินค้า</a>
	 
    </div>
  </div>
	
 <?php if  ($_SESSION['user_type']=="Engineer"){ ?>
	
	
	 <div class="dropdown w3-right">
    <button class="dropbtn">ใบรายการตรวจทานสินค้า
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
	<a href="status_checkliengo.php" >รายการใบตรวจทาน (ขาไป)</a>
	<a href="status_checklienbk.php" >รายการใบตรวจทาน (ขากลับ)</a>
	<a href="status_checklienall.php" >รายการใบตรวจทาน (ทั้งหมด)</a>
	 
    </div>
  </div>
	
		 <div class="dropdown w3-right">
    <button class="dropbtn">การจัดส่งสินค้า
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
	<a href="search_sale_cs.php" >รายละเอียดการจัดส่งสินค้า</a>
	</div>
  </div>
	
	
	  <div class="dropdown w3-right">
    <button class="dropbtn">ใบเบิกเครื่องและอะไหล่
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
	<a href="main_eng_spr.php" >สร้างใบเบิกเครื่องและอะไหล่</a>
	<a href="status_spr.php" >รายการใบเบิกเครื่องและอะไหล่ (ออลล์เวล ไลฟ์)</a>
		<a href="status_spr_no.php" >รายการใบเบิกเครื่องและอะไหล่ (โนเบิล เมด)</a>
	 
    </div>
  </div>
	
	<div class="dropdown w3-right">
    <button class="dropbtn">คีย์ค่าขนส่ง     
	<i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
	 <a href="register_deloth.php" >คีย์ค่าขนส่ง</a>
		<a href="status_deloth.php" >รายการค่าขนส่ง</a>
		
      </div>
  </div>	

	 <div class="dropdown w3-right">
    <button class="dropbtn">Export ข้อมูลติดตั้ง 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
   
  	 <a href="search_service_engineer.php" >Sale Online</a>
	 <a href="search_service_hosso.php" >Sale Hospital</a>
	 <a href="search_service_smp.php" >Sale Sample</a>
	 <a href="search_service_rental.php" >ใบสั่งเช่า</a>
	 <a href="search_service_waranty.php" >ลงทะเบียนออนไลน์</a>
	<a href="status_snproprem.php" >รายการ SN มีปัญหาติดตั้ง</a>	
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
    <button class="dropbtn">ค้นหารายการจากเลขเอกสาร
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
<a href="status_stockbrhos_all.php" >Status Hospital All(ใบยืม)</a>
    <a href="status_enhos_all.php" >Status Hospital All(ใบสั่งขาย)</a>
<a href="status_stock_all.php" >Status Online All</a>
		<a href="status_stocksmpall.php" >รายการใบเบิกสินค้า All</a>
	</div>
  </div>
	
	<?php } ?>
	
	 <div class="dropdown w3-right">
    <button class="dropbtn">ใบสั่งเช่า
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
	<a href="main_sale_rental.php" >ใบสั่งเช่า</a>
	<a href="status_salerental.php" >Status ใบสั่งเช่า</a>
	<a href="status_kangiv.php" >Status ใบสั่งเช่ารอเปิดใบสั่งขาย</a>
    </div>
  </div>
	
	
  <div class="dropdown w3-right">
    <button class="dropbtn">ใบสั่งขาย 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
   
	  <a href="main_salehos_so.php" >Sale Order (SO)</a>
    <a href="status_salehos.php" >Status (SO)</a>
	<a href="status_salekang.php" >Status (SO) ใบฝาก</a>
	<a href="status_saleic.php" >Status (IC) ฝากขาย</a>
	<a href="status_salekang_send.php" >Status (SO) ค้างส่ง</a>	
	<a href="status_salecom.php" >Status หมายเหตุแจ้งแต่ละฝ่าย</a>	
	<a href="status_mkchange_glu.php" >รายการออเดอร์แลกเครื่องวัดน้ำตาล G-426</a>
	<a href="status_mkchange_glucos.php" >รายการออเดอร์แลกเครื่องวัดน้ำตาล GLUCOSURE</a>
	<?php if($_SESSION['code']=="S31" or $_SESSION['code']=="S32"){ ?>	
	<a href="register_chother_blood.php" >ลงทะเบียนลูกค้าแลกเครื่องวัดน้ำตาล</a>   
	<a href="status_bloodch.php" >รายการลูกค้าแลกเครื่องวัดน้ำตาลยี้ห้ออื่น</a>  
	<?php } ?>	
	<?php if  ($_SESSION['name']=="บรรเทิง"){ ?>
	<a href="status_adminhos.php" >Status ใบสั่งขาย รพ. (ทั้งหมด)</a>	
	<a href="status_admin.php" >Status ใบสั่งขาย ออนไลน์ (ทั้งหมด)</a>	
		<?php } ?>
		
		    </div>
  </div>
	
<?php
$strSQLp5 = "SELECT *  FROM no__complete  where  status_doc ='' and send_doc ='1' and send_sup ='0' and type_doc ='5' and sale_code ='". $_SESSION['code']."'";
$objQueryp5 = mysqli_query($conn,$strSQLp5) or die ("Error Query [".$strSQL5."]");
$Num_Rowsp5 = mysqli_num_rows($objQueryp5);				
?>				
	
<div class="dropdown w3-right">
    <button class="dropbtn">แบบฟอร์ม Feedback <?php if($Num_Rowsp5 > 0 ){ ?><font color="red">(<?php echo $Num_Rowsp5; ?>)</font><?php } ?>
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
   
   	<a href="https://feedback.allwellcenter.com/check_login_out.php?token=<?php echo  $token; ?>"  target="_blank" >แบบฟอร์ม Feedback<?php if($Num_Rowsp5 > 0 ){ ?><font color="red">(<?php echo $Num_Rowsp5; ?>)</font><?php } ?></a>
	
	    </div>
  </div>
	
		<div class="dropdown w3-right">
    <button class="dropbtn">ใบยืมฝากขาย 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
   
    <a href="main_sale_brsc.php" >สร้างใบฝากขาย </a>
 	<a href="status_salebrsc.php" >Status ใบฝากขาย </a>
	<a href="status_salebrsc_clear.php" >Status ใบฝากขายค้างเคลียร์</a>
    <a href="main_brscanysale.php" >Status เคลียร์ใบฝากขายหลายเอกสาร</a>
		 
    </div>
  </div>
	
	   <div class="dropdown w3-right">
    <button class="dropbtn">ใบยืม 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
   <?php if  ($_SESSION['user_type']=="Engineer"){ ?>
    <a href="main_eng_br.php" >Borrow (BR)</a>
    <a href="main_eng_breg.php" >ใบขอเบิกอะไหล่สินค้าขาย (BREG)</a>	
    <a href="main_eng_br.php?key=breq" >ใบยืมสินค้าตรวจเช็ค (BREQ).</a>
    <a href="status_brhos_breq.php" >Status (BREQ).</a>
		<?php }else{ ?>
	<a href="main_salehos_br.php" >Borrow (BR)</a>	
		<?php } ?>
 <a href="status_brhos.php" >Status (BR)</a>
		<?php if  ($_SESSION['user_type']=="Engineer"){ ?>
 <a href="status_engbreg.php" >Status ใบขอเบิกอะไหล่สินค้าขาย (BREG)</a>	
    <a href="status_engpro.php" >Status (BR) ค้นหาสินค้า</a>
  <a href="status_receive_sale.php" >Status บันทึกรับคืนสินค้า</a> 
		<?php } ?>
		<?php /* */ ?>
		 <a href="status_clearbr.php" >Status ใบยืมค้างเคลียร์</a>
		 <a href="status_clearbr__breq.php" >Status ใบยืมค้างเคลียร์ (BREQ)</a>
		<a href="main_soanysale.php" >Status เคลียร์ใบยืมหลายเอกสาร</a>
		<?php if  ($_SESSION['user_type']=="Engineer"){ ?>
		<a href="status_engbregkang.php" >Status ใบขอเบิกอะไหล่สินค้าขาย (BREG) ค้าง</a>	
		<?php } ?>
		<a href="report_brkangbyarea.php" >ตรวจเช็คใบยืมค้างเคลียร์ (stock)</a>
		<a href="status_brsalearea.php" >รายการตรวจเช็คใบยืม (ทั้งหมด)</a>

    </div>
  </div>
	 
	
	<div class="dropdown w3-right">
    <button class="dropbtn">ใบจอง 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
   
    <a href="main_salehos_jong.php" >สร้างใบจอง</a>
 <a href="status_salejong.php" >Status ใบจอง</a>
		<a href="status_salejong_clear.php" >Status ใบจองค้างเคลียร์</a>
		 
    </div>
  </div>
	
	<div class="dropdown w3-right">
    <button class="dropbtn">รายการรับเรื่องจากลูกค้า      
	<i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
    <?php if  ($_SESSION['user_type']=="Engineer"){ ?>
    <a href="register_story.php" >สร้างรายการรับเรื่องจากลูกค้า</a>
   <?php } ?>
	  <a href="status_storykangsale.php" >รายการรับเรื่องจากลูกค้า (ค้าง)</a>
	   <a href="status_storysaleall.php" >รายการรับเรื่องจากลูกค้า (ปิดงานแล้ว)</a>
		
	<a href="register_cuseng.php" >การรับเรื่องลูกค้าของช่าง</a>
	<a href="status_cusopen.php" >รายการรับเรื่องลูกค้าช่าง</a>	
	
	 <?php if  ($_SESSION['user_type']=="Engineer"){ ?>
    <a href="status_engkang.php" >รายการรับเรื่องลูกค้าช่าง (ค้าง)</a>	
	<a href="status_engpend.php" >รายการรับเรื่องลูกค้าช่าง (กำลังดำเนินการ)</a>	
	<a href="status_engclose.php" >รายการรับเรื่องลูกค้าช่าง (ปิดงาน)</a>
	<a href="update_doceng.php" >Import เลขที่เอกสาร</a>
		
   <?php } ?>	
		
      </div>
  </div>
	
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
		
    </div>
  </div>
	
		<div class="dropdown w3-right">
    <button class="dropbtn">Report 
      <i class="fa fa-caret-down"></i>
    </button>
    		<div class="dropdown-content">
       <a href="search_sale.php" >Sale Record สินค้า</a>
  <a href="search_sale1.php" >Sale Record เลขที่เอกสาร</a>
  <a href="search_salegraph.php" >รายงานยอดขาย แบบกราฟ</a>
		<?php if  ($_SESSION['code']=="S31" or $_SESSION['code']=="S32"){ ?>		
	<a href="report_year31hc.php">รายงานยอดขายแบบกราฟ ร้านขายยา(ปี)</a>
				<?php } ?>
	<?php if  ($_SESSION['user_type']=="Engineer"){ ?>
	<a href="report_supkangbr1.php" >รายงานใบยืมค้างคืนแยกตาม รพ.</a>
				<?php }else{ ?>
	<a href="report_kangbrhos.php" >รายงานใบยืมค้างคืนแยกตาม รพ.</a>
	<a href="report_kangbrsc.php" >รายงานใบยืมฝากขายค้างคืนแยกตามลูกค้า</a>
				<?php } ?>
	<a href="search_report_customersale.php" >รายงานประวัติการขายแยกตามลูกค้า</a>
	<a href="search_report_allbyproductsale.php" >รายงานประวัติการขายแยกตามสินค้า</a>
	<a href="report_sumpro_bysale.php" >รายงานยอดขายเรียงตามสินค้า</a>
				
				
	<?php if  ($_SESSION['user_type']=="Engineer"){ ?>			
	<a href="report_endemo.php" >รายงานสรุปแบบสอบถามความพึงพอใจสินค้าสาธิต</a>
		<?php } ?>		
	<?php if  ($_SESSION['user_type']=="Engineer" and $_SESSION['name']=="ภานุวัฒน์"){ ?>
	 
    <a href="search_enivall.php" >สร้างรายการรับเรื่องจากลูกค้า</a>
   <?php } ?>			
				
    </div>
  </div>
	
<?php
	
$sale_code = $_SESSION['code'];
$user_type = $_SESSION['user_type'];
	
if($user_type=='Engineer'){
$strSQL4 = "SELECT *  FROM hos__receive  where  sale_code LIKE'%EN%' and report_ckk ='0'";
}else{
$strSQL4 = "SELECT *  FROM hos__receive  where  sale_code ='".$sale_code."' and report_ckk ='0' ";	
}
$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
$Num_Rows4 = mysqli_num_rows($objQuery4);
	
?>
	
		<div class="dropdown w3-right">
    <button class="dropbtn">ใบรับคืนสินค้า <?php if($Num_Rows4 > 0 ){ ?><font color="red">(<?php echo $Num_Rows4; ?>)</font><?php } ?>
      <i class="fa fa-caret-down"></i>
    </button>
    		<div class="dropdown-content">
	    <a href="status_receive_prokang.php" >ใบรับคืนสินค้า (รอคลัง) <?php if($Num_Rows4 > 0 ){ ?><font color="red">(<?php echo $Num_Rows4; ?>)</font><?php } ?></a>			
       <a href="status_receive_pro.php" >Status ใบรับคืนสินค้า</a>
     </div>
  </div>
	
	
<div class="dropdown w3-right">
    <button class="dropbtn">เข้าสู่ระบบอื่นๆ<i class="fa fa-caret-down"></i></button>
    <div class="dropdown-content">
      <a href="https://quotation.allwellcenter.com/" target="_blank">ใบเสนอราคา</a>
      <a href="https://inter.allwellcenter.com/" target="_blank">ใบขอซื้อ Inter</a>
      <a href="https://pr-wr.allwellcenter.com/" target="_blank">ใบขอซื้อ & ใบขออนุมัติ คชจ.</a>
    </div>
</div>

<!-- <div class="dropdown w3-right">
    <button class="dropbtn">ใบเสนอราคา<i class="fa fa-caret-down"></i></button>
    <div class="dropdown-content"><a href="https://quotation.allwellcenter.com/" >เข้าสู่ ใบเสนอราคา</a></div>
</div>
	
<div class="dropdown w3-right">
    <button class="dropbtn">ใบขอสั่งซื้อ<i class="fa fa-caret-down"></i></button>
    <div class="dropdown-content"><a href="https://inter.allwellcenter.com/index.php" >เข้าสู่ ใบขอสั่งซื้อ</a></div>
</div> -->
	
<div class="dropdown w3-right">
    <button class="dropbtn">คู่มือการใช้งาน
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
  		<a href="manual/Story_Sale.pdf">คู่มือรายการรับเรื่องลูกค้า</a>
		<a href="manual/Jong_Sale.pdf">คู่มือ ใบจอง</a>
		<a href="manual/BR_Sale.pdf">คู่มือ ใบยืม</a>
		<a href="manual/ClearBr_Sale.pdf">คู่มือ การเคลียร์ใบยืม</a>
		<a href="manual/SaleOrder_Sale.pdf">คู่มือ ใบสั่งขาย</a>
		<a href="manual/SO_IC.pdf">คู่มือ ใบสั่งขาย IC</a>
		<a href="manual/Order_Sale.pdf">คู่มือ ใบฝาก</a>
		<a href="manual/Credit_Sale.pdf">คู่มือ ใบลดหนี้</a>
		<a href="manual/Change_Sale.pdf">คู่มือ ใบแลกเปลี่ยน</a>
		<a href="manual/Sample_Sale.pdf">คู่มือ ใบเบิกเพื่อสนับสนุนการขาย</a>
		<a href="manual/Research_Sale.pdf">คู่มือ แบบประเมินความพึงพอใจ</a>
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