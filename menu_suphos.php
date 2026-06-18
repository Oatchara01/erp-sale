
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
  <a href="main_suphos.php" class="active"><img width="150" height="33" src="img/allwellsale_logo.png"></a>
  
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
	
	<?php if  ($_SESSION['user_type']=="Engineer"){ ?>
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
	

	
	<div class="dropdown w3-right">
    <button class="dropbtn">ตารางรถใหญ่ 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
   
    <a href="veiw_bussend.php" >ตารางรถใหญ่</a>
      </div>
  </div>
	
 
	
  <div class="dropdown w3-right">
    <button class="dropbtn">การอนุมัติ 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
   
    <a href="status_approvesup.php" >อนุมัติใบสั่งขาย</a>
   <a href="status_approvebrsup.php" >อนุมัติใบยืม</a>

			<?php if  ($_SESSION['name']=="บรรเทิง"){ ?>
   <a href="status_approvebrsup_breq.php" >อนุมัติใบยืม BREQ</a>
		<?php } ?>
		<a href="status_approvebrsc.php" >อนุมัติใบยืมฝากขาย</a>
   <a href="status_credit_approve.php" >อนุมัติใบสั่งลดหนี้</a>
    <a href="status_sample_approve.php" >อนุมัติใบเบิกสินค้า</a>
		<a href="status_supjongapp.php" >อนุมัติใบจอง</a>
		<a href="status_supchangeapp.php" >อนุมัติการแลกเปลี่ยนสินค้า</a>
		<?php if  ($_SESSION['name']=="บรรเทิง"){ ?>
		<a href="status_approvespr.php" >อนุมัติใบเบิกเครื่องและอะไหล่</a>
		<a href="status_supbreg_app.php" >อนุมัติใบขอเบิกอะไหล่สินค้าขาย (BREG)</a>	
		<?php } ?>
		<?php if  ($_SESSION['name']=="บรรเทิง"){ ?>
		<a href="status_appspr_cm.php" >อนุมัติใบเบิกเครื่องและอะไหล่ ผู้บริหาร</a>
		<?php } ?>
		<a href="status_appckkst.php" >อนุมัติรายการตรวจเช็คใบยืม</a>
		<a href="status_apprental.php" >อนุมัติใบสั่งเช่า</a>	
    </div>
  </div>
	
	<div class="dropdown w3-right">
    <button class="dropbtn">ใบเบิกสินค้า 
      <i class="fa fa-caret-down"></i>
    </button>
	   <div class="dropdown-content">
   	 <a href="main_suphos_smp.php" >สร้างใบเบิกสินค้า (สนับสนุนการขาย)</a>
	 <a href="status_samplesup.php" >รายการใบเบิกสินค้า (สนับสนุนการขาย)</a>


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
	
	<?php if  ($_SESSION['name']=="บรรเทิง"){ ?>
	
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
    <button class="dropbtn">ใบเบิกเครื่องและอะไหล่
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
	<a href="main_eng_spr.php" >สร้างใบเบิกเครื่องและอะไหล่</a>
	<a href="status_spr.php" >รายการใบเบิกเครื่องและอะไหล่ (ออลล์เวล ไลฟ์)</a>
		<a href="status_spr_no.php" >รายการใบเบิกเครื่องและอะไหล่ (โนเบิล เมด)</a>
	 
	 
    </div>
  </div>
	
	<?php } ?>
		
	<div class="dropdown w3-right">
    <button class="dropbtn">ใบสั่งลดหนี้
      <i class="fa fa-caret-down"></i>
    </button>
	   <div class="dropdown-content">
   	 <a href="register_credit_sup.php" >สร้างใบสั่งลดหนี้</a>
	 <a href="status_credit_sup.php" >รายการใบสั่งลดหนี้</a>
	    </div>
  </div>
	
	<div class="dropdown w3-right">
    <button class="dropbtn">แลกเปลี่ยนสินค้า 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
   
   <a href="main_suphos_change.php" >สร้างใบแลกเปลี่ยนสินค้า</a> 
 <a href="status_supchange.php" >รายการใบแลกเปลี่ยนสินค้า</a>
		
		 
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
    </div>
  </div>
	
  <div class="dropdown w3-right">
    <button class="dropbtn">ใบสั่งขาย 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
   
    <a href="main_suphos_so.php" >Sale Order (SO)</a>
   <a href="status_suphos.php" >Status (SO)</a>
	<a href="status_supic.php" >Status (IC) ใบฝากขาย</a>
	<a href="status_supkang.php" >Status (SO) ใบฝาก</a>
	<a href="status_supkang_send.php" >Status (SO) ค้างส่ง</a>
	<a href="status_supcom.php" >Status หมายเหตุแจ้งแต่ละฝ่าย</a>		
	<?php if($_SESSION['name']=='พรรณิภา' or $_SESSION['name']=='นรินทิพย์' or $_SESSION['name']=="บรรเทิง" or $_SESSION['name']=="ศิรวิทย์"){ ?>
<a href="status_mkchange_glu.php" >รายการออเดอร์แลกเครื่อง G-426</a>
<a href="status_mkchange_glucos.php" >รายการออเดอร์แลกเครื่อง GLUCOSURE</a>	
<!--a href="register_chother_blood.php" >ลงทะเบียนลูกค้าแลกเครื่องวัดน้ำตาล</a>   
<a href="status_bloodch.php" >รายการลูกค้าแลกเครื่องวัดน้ำตาลยี้ห้ออื่น</a-->  		
<?php } ?>
	<?php if  ($_SESSION['name']=="บรรเทิง"){ ?>	
	<a href="status_adminhos.php" >Status ใบสั่งขาย รพ. (ทั้งหมด)</a>
	<a href="status_admin.php" >Status ใบสั่งขาย ออนไลน์ (ทั้งหมด)</a>	
		<?php } ?>
    </div>
  </div>
	
	  <div class="dropdown w3-right">
    <button class="dropbtn">ใบยืม 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
   <?php if  ($_SESSION['user_type']=="Engineer"){ ?>
    <a href="main_supeng_br.php" >Borrow (BR)</a>
    <a href="main_eng_breg.php" >ใบขอเบิกอะไหล่สินค้าขาย (BREG)</a>
    <a href="main_eng_br.php?key=breq" >ใบยืมสินค้าตรวจเช็ค (BREQ).</a>
    <a href="status_brhos_breq.php" >Status (BREQ).</a>
		<?php }else{ ?>
	<a href="main_suphos_br.php" >Borrow (BR)</a>	
		<?php } ?>
 	<a href="status_supbrhos.php" >Status (BR)</a>
		<?php if  ($_SESSION['user_type']=="Engineer"){ ?>
		<a href="status_engbreg.php" >Status ใบขอเบิกอะไหล่สินค้าขาย (BREG)</a>
		<a href="status_engbregkang.php" >Status ใบขอเบิกอะไหล่สินค้าขาย (BREG) ค้าง</a>
		<?php } ?>
		<?php /* <a href="status_receive_sup.php" >Status บันทึกรับคืนสินค้า</a>*/ ?>
	<a href="status_clearbr_sup.php" >Status ใบยืมค้างเคลียร์</a>
  <a href="status_clearbr__breq.php" >Status ใบยืมค้างเคลียร์ (BREQ)</a>
	<a href="main_soanysup.php" >Status เคลียร์ใบยืมหลายเอกสาร</a>
	<a href="report_brkangbysup.php" >ตรวจเช็คใบยืมค้างเคลียร์ (stock)</a>
	<a href="status_brsuparea.php" >รายการตรวจเช็คใบยืม (ทั้งหมด)</a>
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
		 
    </div>
  </div>
	
	<div class="dropdown w3-right">
    <button class="dropbtn">รายการรับเรื่องจากลูกค้า      
	<i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
   
   
	 
		<?php if  ($_SESSION['name']=="บรรเทิง"){ ?>
		<a href="status_kangcs.php" >รายการรับเรื่องจากลูกค้าในส่วนของจัดส่ง (ค้าง)</a>
		<a href="status_kangcsall.php" >รายการรับเรื่องจากลูกค้า (ปิดงานแล้ว)</a>
		<?php }else{ ?> 
		<a href="status_storykangsup.php" >รายการรับเรื่องจากลูกค้า (ค้าง)</a>
	   <a href="status_storysupall.php" >รายการรับเรื่องจากลูกค้า (ปิดงานแล้ว)</a>
		<a href="report_storysaleall.php" >รายงานรายการรับเรื่องจากลูกค้า</a>
		<?php } ?>
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
	<?php if  ($_SESSION['code']!="SS5"){ ?>
	<div class="dropdown w3-right">
    <button class="dropbtn">แบบสอบถาม
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
	<a href="status_supresearch.php" >ทำแบบสอบถาม</a>
	<a href="status_supchangeall.php" >Status แบบสอบถามทั้งหมด</a>
	 <a href="status_supdemo.php" >ทำแบบสอบถามสินค้าสาธิต</a>
	<a href="status_supdemoall.php" >แบบสอบถามสินค้าสาธิตทั้งหมด</a> 
	<a href="status_reserch_receive.php" >แบบประเมินความพึงพอใจในการจัดสินค้า</a>
    </div>
  </div>
	<?php } ?>
	
	<?php /*if  ($_SESSION['user_type']=="Engineer"){ ?>
	<div class="dropdown w3-right">
    <button class="dropbtn">ใบรับคืนสินค้า 
      <i class="fa fa-caret-down"></i>
    </button>
    		<div class="dropdown-content">
       <a href="status_receive_suppro1.php" >Status ใบรับคืนสินค้า</a>
     </div>
  </div>
	<?php }else{*/ ?>
	
<?php
	
$emid = $_SESSION['code'];
	
if($emid=='SS1'){
$sddd = "and  sale_code !='S11'  and sale_code !='S12' and sale_code !='S13'  and sale_code !='S17'  and sale_code !='S23'  and sale_code !='S24'  and sale_code !='S31' and sale_code !='SM1' and sale_code !='MM1' and sale_code !='MM2' and sale_code !='S32'  and sale_code NOT LIKE '%EN%' and sale_code NOT LIKE '%SOL%' and sale_code NOT LIKE '%-%' and sale_code NOT LIKE '%H%' and sale_code NOT LIKE '%I%'  and sale_code NOT LIKE '%M%' and sale_code !=''";
	
}else if($emid=='SS2'){
$sddd = "and  sale_code !='S14'  and sale_code !='S15' and sale_code !='S16'  and sale_code !='S21'  and sale_code !='S22' and sale_code !='S31' and sale_code !='SM1' and sale_code !='MM1'  and sale_code !='MM2' and sale_code !='S32' and sale_code NOT LIKE '%EN%' and sale_code NOT LIKE '%SOL%'  and sale_code NOT LIKE '%H%' and sale_code NOT LIKE '%I%' and sale_code NOT LIKE '%M%' and sale_code !='' and sale_code NOT LIKE '%-%'";	
}else if($emid=='SS3'){
$sddd = "and  sale_code !='S11'  and sale_code !='S12' and sale_code !='S13'  and sale_code !='S17'  and sale_code !='S23'  and sale_code !='S24' and sale_code !='S14'  and sale_code !='S15' and sale_code !='S16'  and sale_code !='S21' and sale_code !='S22' and sale_code NOT LIKE '%EN%' and sale_code !='' and sale_code NOT LIKE '%-%'";	
}else if($emid=='SUP_MK'){
$sddd = "and sale_code LIKE '%SOL9%' and sale_code NOT LIKE '%-%'";	
}else if($emid=='SM1'){
$sddd = "and sale_code LIKE '%SOL%' and sale_code NOT LIKE '%SOL9%' and sale_code NOT LIKE '%-%'";	
}else if($emid=='SUP_EN'){
$sddd = "and sale_code LIKE '%EN%' and sale_code NOT LIKE '%-%'";	
}else{
$sddd = "";			
}	

	

$strSQL4 = "SELECT *  FROM hos__receive  where  report_ckk ='0' $sddd";	
$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
$Num_Rows4 = mysqli_num_rows($objQuery4);
	
?>	
	
	
	
	<div class="dropdown w3-right">
    <button class="dropbtn">ใบรับคืนสินค้า <?php if($Num_Rows4 > 0 ){ ?><font color="red">(<?php echo $Num_Rows4; ?>)</font><?php } ?>
      <i class="fa fa-caret-down"></i>
    </button>
    		<div class="dropdown-content">
		<a href="status_receive_supprokang.php" >Status ใบรับคืนสินค้า (รอคลังรับ) <?php if($Num_Rows4 > 0 ){ ?><font color="red">(<?php echo $Num_Rows4; ?>)</font><?php } ?></a>		
       <a href="status_receive_suppro.php" >Status ใบรับคืนสินค้า</a>
     </div>
  </div>
	
	<?php //} ?>
	
	
	<div class="dropdown w3-right">
    <button class="dropbtn">แบบฟอร์ม Feedback 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
   
   	<a href="https://feedback.allwellcenter.com/check_login_out.php?token=<?php echo  $token; ?>"  target="_blank" >แบบฟอร์ม Feedback </a>
	
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
		
		<a href="https://stock.allwellcenter.com/report_hotpro1.php" target="_blank">รายงานสินค้าคงเหลือ ยอดนิยม เตียงและสินค้าประกอบ</a>
		<a href="https://stock.allwellcenter.com/report_hotpro2.php" target="_blank">รายงานสินค้าคงเหลือ ยอดนิยม สินค้า Online</a>
		<a href="https://stock.allwellcenter.com/report_hotpro3.php" target="_blank">รายงานสินค้าคงเหลือ ยอดนิยม สินค้าทั่วไป</a>
		<a href="https://stock.allwellcenter.com/report_hotpro4.php" target="_blank">รายงานสินค้าคงเหลือ ยอดนิยมสินค้า Allied</a>
		<a href="search_productall.php">รายงานสินค้าคงเหลือแบบเลือกรายการ</a>
		
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
    <button class="dropbtn">ใบขอสั่งซื้อ
      <i class="fa fa-caret-down"></i>
    </button>
    		<div class="dropdown-content">
       <a href="https://inter.allwellcenter.com/index.php" >เข้าสู่ ใบขอสั่งซื้อ</a>
     </div>
  </div> -->
	
	
		<div class="dropdown w3-right">
    <button class="dropbtn">Report 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
   <?php if  ($_SESSION['name']=="นรินทิพย์" or $_SESSION['name']=="พรรณิภา"){ ?>
		
  		<a href="search_sup_record.php" >Sale Record สินค้า</a>
  		<a href="search_sup_record1.php" >Sale Record เลขที่เอกสาร</a>
		<a href="report_hosgraph.php">รายงานยอดขายแบบกราฟ แผนกโรงพยาบาล(เดือน)</a>
		<a href="report_yearhos.php">รายงานยอดขายแบบกราฟ แผนกโรงพยาบาล(ปี)</a>
		<a href="search_supgraph.php" >รายงานรวมยอดขายแบบกราฟแยกเขต</a>
		<a href="search_grapsum.php" >รายงานรวมยอดขายแบบกราฟทั้งหมด</a>
		<a href="report_supkangbr.php" >รายงานใบยืมคงค้างตาม รพ</a>
		 <a href="report_supkangbrsc.php" >รายการใบยืมฝากขายคงค้าง แยกตามลูกค้า</a>
		<a href="search_report_customersup.php" >รายงานยอดขายแยกตามลูกค้า</a>
		<a href="search_report_allbyproductsup.php" >รายงานยอดขายแยกตามสินค้า</a>
		<a href="report_sumpro_bysup.php" >รายงานยอดขายตามสินค้า</a>
		<a href="report_sumbyglugopro.php" >รายงานยอดขาย Gluco All-Pro</a>
		<?php } //report_sumpro_bysup.php ?>
		<?php if ($_SESSION['name']=='วารุณี') { ?>
		<a href="report_year31hc.php">รายงานยอดขายแบบกราฟ ร้านขายยา(ปี)</a>
		<a href="search_reccord_supall.php">ดึงข้อมูล Monthly Sales Record (ตามสินค้า)</a>
		<a href="search_reccord_supall1.php">ดึงข้อมูล Monthly Sales Record (ตามเลขที่เอกสาร)</a>
		<a href="search_report_customersup.php">รายงานประวัติการขายแยกตามลูกค้า</a>
		<a href="search_report_allbyproductsup.php">รายงานประวัติการขาย แยกตามสินค้า</a>
        <?php } ?>
		<?php if  ($_SESSION['user_type']=="Engineer"){ ?>
		<a href="search_enivall.php" >รายงานเลขที่เอกสารออกบิลทั้งหมด</a>
		<a href="report_supkangbr.php" >รายงานใบยืมคงค้างตาม รพ</a>
		<a href="report_endemo.php" >รายงานสรุปแบบสอบถามความพึงพอใจสินค้าสาธิต</a>
		<a href="report_endemobypro.php" >รายงานแบบสอบถามความพึงพอใจสินค้าสาธิตตามสินค้า</a>
		<?php if($_SESSION['name']=='บรรเทิง') { ?>
		<a href="search_buyagain.php">รายงานลูกค้าซื้อซ้ำกลุ่มสินค้า</a>
		<?php } ?>
		
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