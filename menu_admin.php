
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
  .topnav.responsive .dropdown .dropbtn {F
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
  <?php if ($_SESSION['name']==''){ ?>
  <div class="dropdown w3-right">
    <button class="dropbtn"><img src="img/logo_acc.png" width="25" align="left" height="20" ><?php echo $_SESSION['name']; ?>
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content w3-right">
      <a href="change_pass.php">Change Password</a>
		<?php /*<a href="https://allwellcenter.com/itsupport/" target="_blank">แจ้งปัญหาการใช้งาน</a>*/ ?>
        <a href="logout.php">Logout</a>
    </div>
  </div>
	
	
		
	
	
	 <div class="dropdown w3-right">
	<button class="dropbtn">Report HOSPITAL
		<i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
		<a href="search_sale_record.php">Sale Record สินค้า</a>
		<a href="search_hosrecpro.php">Sale Record สินค้า (โรงพยาบาล)</a>
		<a href="search_solrecpro.php">Sale Record สินค้า (ออนไลน์)</a>
		<a href="search_sale_record1.php">Sale Record เลขที่เอกสาร</a>
		<a href="search_hosrec.php">Sale Record เลขที่เอกสาร (โรงพยาบาล)</a>
		<a href="search_solrec.php">Sale Record เลขที่เอกสาร (ออนไลน์)</a>
		<a href="search_sumallevery.php">Sale Record ยอดรวม</a>
		
    </div>
</div>
<div class="dropdown w3-right">
	<button class="dropbtn">Report SOL
		<i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
		<a href="search_report_twodate.php">สรุปตามวันที่ (เลือกวัน)</a>
		<a href="search_report_bydate.php">สรุปตามวันที่ (ช่วงเวลา)</a>
		<a href="search_report_byproduct.php">สรุปตามสินค้า (เลือกวัน)</a>
		<a href="search_report_producttwo.php">สรุปตามสินค้า (ช่วงเวลา)</a>
		<a href="search_summary_product.php">สรุปตามสินค้า (เลือกวัน แบบสรุป)</a>
			
		
    </div>
</div>
	
	
	 <div class="dropdown w3-right">
    <button class="dropbtn">ใบสั่งขาย Hospital
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
   
    
		<a href="status_adminhos1.php" >Status (SO)ค้างเลขที่ IV</a>
		<a href="status_adminhos.php" >Status (SO)</a>
		<a href="status_admin_jong.php" >Status (SO) ใบฝาก</a>
		    </div>
  </div>
	
	
	
	
	
	  <div class="dropdown w3-right">
    <button class="dropbtn">Admin Online
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
	  <a href="status_admin.php">Status</a>
		</div>
  </div>

	
	
	 <div class="dropdown w3-right">
    <button class="dropbtn">E-Commerce 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
    <a href="search_apilazada.php">ดึงข้อมูล Lazada</a>
    </div>
  </div> 
	
<?php /*	<div class="dropdown w3-right">
    <button class="dropbtn">คู่มือการใช้งาน
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
  <a href="manual/Story_Sup.pdf">คู่มือรายการรับเรื่องลูกค้า</a>
		<a href="manual/Jong_Sup.pdf">คู่มือ ใบจอง</a>
		<a href="manual/BR_Sup.pdf">คู่มือ ใบยืม</a>
		<a href="manual/ClearBr_Sup.pdf">คู่มือ การเคลียร์ใบยืม</a>
		<a href="manual/SaleOrder_Sup.pdf">คู่มือ ใบสั่งขาย</a>
		<a href="manual/Order_Sup.pdf">คู่มือ ใบฝาก</a>
		<a href="manual/Credit_Sup.pdf">คู่มือ ใบลดหนี้</a>
		<a href="manual/Change_Sup.pdf">คู่มือ ใบแลกเปลี่ยน</a>
		<a href="manual/Sample_Sup.pdf">คู่มือ ใบเบิกเพื่อสนับสนุนการขาย</a>
		<a href="manual/Research_Sup.pdf">คู่มือ แบบประเมินความพึงพอใจ</a>
    </div>
  </div>*/ ?>
	
	<?php } else if ($_SESSION['name']=='วรรณชนก'){ ?>
	
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
    <button class="dropbtn">Report
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content w3-right">
      <a href="search_report_customer.php">รายงานประวัติการขาย แยกตามลูกค้า</a>
		<a href="search_report_allbyproduct.php"> รายงานประวัติการขาย แยกตามสินค้า</a>
    </div>
  </div>
	

	
	
	
	
	<?php } else if ($_SESSION['code']=='ACC' or $_SESSION['code']=='ST'){ ?>
	
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
    <button class="dropbtn">Setting 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <a href="close_opendoc.php">ปิด - เปิด เอกสาร</a>
	  <a href="add_document.php">เอกสารประกอบการออกบิล</a>
	 <a href="add_payment.php">การชำระเงิน</a>
	 <a href="add_customer.php">ข้อมูลลูกค้า</a>
	<a href="status_app_credit.php">ข้อมูลวงเงินลูกค้า (รออนุมัติ)</a>	
    </div>
  </div>
	<div class="dropdown w3-right">
	<button class="dropbtn">Export Express
		<i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
		<a href="search_cusexpress_sol.php">ดึงรายชื่อลูกค้าออนไลน์</a>
		<a href="search_orderexpress_sol.php">ดึงรายการ Order ออนไลน์</a>
		<a href="search_cusexpress_hos.php">ดึงรายชื่อลูกค้า รพ.</a>
		<a href="search_orderexpress_hos.php">ดึงรายการ Order รพ.</a>
		<a href="search_orderexpress_ecom.php">ดึงข้อมูล Order E-Commerce ลง Express (เคลียร์ยืม)</a>
		</div>
</div>
	
	<div class="dropdown w3-right">
	<button class="dropbtn">Export Etax Invoice
		<i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
<a href="search_taxinvoice.php"> &nbsp;&nbsp;&nbsp; ดึงข้อมูล Invoice ไฟล์ .txt (Home Care)</a>
<a href="search_etax_ecomer.php"> &nbsp;&nbsp;&nbsp; ดึงข้อมูล Invoice ไฟล์ .pdf (Home Care)</a>
		
<a href="search_taxinvoice1.php"> &nbsp;&nbsp;&nbsp; ดึงข้อมูล Invoice ไฟล์ .txt (Hospital)</a>
<a href="search_etax_hos.php"> &nbsp;&nbsp;&nbsp; ดึงข้อมูล Invoice ไฟล์ .pdf (Hospital)</a>
		
<a href="search_creditnote.php"> &nbsp;&nbsp;&nbsp; ดึงข้อมูล Credit Note ไฟล์ .txt</a>
<a href="search_creditfrom.php"> &nbsp;&nbsp;&nbsp; ดึงข้อมูล Credit Note ไฟล์ .pdf</a>
		
<a href="search_taxinvoice_txt.php"> &nbsp;&nbsp;&nbsp; ดึงข้อมูล ไฟล์ .txt (Home Care) ทดแทน</a>
<a href="search_etax_ecomer1.php"> &nbsp;&nbsp;&nbsp; ดึงข้อมูล ไฟล์ .pdf (Home Care)ทดแทน</a>
		
<a href="search_taxinvoice_txt1.php"> &nbsp;&nbsp;&nbsp; ดึงข้อมูล ไฟล์ .txt (Hospital) ทดแทน</a>
<a href="search_etax_hos1.php"> &nbsp;&nbsp;&nbsp; ดึงข้อมูล ไฟล์ .pdf (Hospital) ทดแทน</a>
	
<a href="search_creditnote1.php"> &nbsp;&nbsp;&nbsp; ดึงข้อมูล Credit Note ไฟล์ .txt ทดแทน</a>
<a href="search_creditfrom1.php"> &nbsp;&nbsp;&nbsp; ดึงข้อมูล Credit Note ไฟล์ .pdf ทดแทน</a>
		
		</div>
</div>
	
	<div class="dropdown w3-right">
	<button class="dropbtn">Report
		<i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
		<a href="search_reportacc.php">รายงานยอดขายประจำวัน</a>
		<a href="search_kangclear.php">รายงานออเดอร์ค้างเคลียร์ยืม Online</a>
		<a href="report_clearnobr.php">รายงานสินค้าค้างเคลียร์ยืม รพ</a>
		<a href="search_cleariv.php">รายงานออเดอร์เคลียร์ยืม</a>
		<a href="search_solno.php">รายงานสรุปแยก SOL และ IV ที่ออกบิลแล้ว</a>
		<a href="search_reportvat.php">รายงานใบกำกับภาษี</a>
		<a href="search_buyckk.php">รายงานลูกค้าซื้อซ้ำ</a>
		<a href="search_creditnot.php">รายงานใบลดหนี้</a>
		<a href="search_deloth.php">รายการสรุปเบิกเงินสำรองจ่าย</a>
		<?php //if($_SESSION['name']=='ประภาสิริ'){ ?>
		<a href="reportorder_99.php">รายการออเดอร์ 99</a>
		<a href="reportorder_gar.php">รายการออเดอร์ German Bed</a>
		<a href="reportorderso_hos.php">รายการออเดอร์ รพ.</a>
		<a href="search_IE.php">รายงานใบกำกับภาษี</a>
		
		<?php //} ?>
	</div>
</div>
	
	<div class="dropdown w3-right">
    <button class="dropbtn">รายการรับเรื่องจากลูกค้า      
	<i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
    <a href="status_storykangsale.php" >รายการรับเรื่องจากลูกค้า (ค้าง)</a>
	   <a href="status_storysaleall.php" >รายการรับเรื่องจากลูกค้า (ปิดงานแล้ว)</a>
				 <a href="register_cuseng.php" >การรับเรื่องลูกค้าของช่าง</a>
	<a href="status_cusopen.php" >รายการรับเรื่องลูกค้าช่าง</a>	
      </div>
  </div>
	
	 <div class="dropdown w3-right">
    <button class="dropbtn">Admin Online
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
	 <a href="status_deposit.php" >รายการใบรับเงินมัดจำ</a>
       <a href="status_admin.php">Status</a>
		<a href="status_admin_bed.php">Status เตียง</a>
		<a href="status_admin_99.php">Status 99</a>
		<a href="status_clear_admin.php">Status ใบยืมค้างเคลียร์</a>
	</div>
  </div>
	
	<div class="dropdown w3-right">
    <button class="dropbtn">Sale Hos 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
   
    <a href="main_suphos_br.php" >ใบยืม (BR)</a>
 	 <a href="main_suphos_so.php" >ใบสั่งขาย (SO)</a>
		<a href="main_suphos_change.php" >ใบแลกเปลี่ยน</a>	
   <a href="status_supbrhos1.php" >Status ใบยืม (BR)</a>
		<a href="status_suphos1.php" >Status ใบสั่งขาย (SO)</a>
		<a href="status_supchange1.php" >Status ใบแลกเปลี่ยน</a>
		
    </div>
  </div>
	
	<div class="dropdown w3-right">
    <button class="dropbtn">ใบสั่งเช่า
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
   
    
		<a href="status_kangrental.php" >Status ใบสั่งเช่ารอเปิดใบสั่งขาย</a>
		<a href="status_adminrental.php" >Status ใบสั่งเช่าทั้งหมด</a>
		
		    </div>
  </div>
	
	<div class="dropdown w3-right">
    <button class="dropbtn">คีย์ค่าขนส่ง     
	<i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
	 <a href="register_deloth.php" >คีย์ค่าขนส่ง</a>
		<a href="status_deloth.php" >รายการค่าขนส่ง</a>
		<a href="status_delothall.php" >รายการค่าขนส่ง ทั้งหมด</a>
		<a href="status_sumdelall.php" >รายการค่าขนส่ง ทุกช่องทาง</a>
		
      </div>
  </div>
	
	<div class="dropdown w3-right">
    <button class="dropbtn">ใบเบิกสินค้า      
	<i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
	 <a href="status_adminmp.php" >รายการเบิกสินค้าทั้งหมด</a>
      </div>
  </div>
	<div class="dropdown w3-right">
    <button class="dropbtn">ใบแจ้ง PO
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
   <a href="status_adminpo.php" >Status (PO)</a>
	    </div>
  </div>
	
	<div class="dropdown w3-right">
    <button class="dropbtn">ใบยืม Hospital
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
   
    <a href="status_adminbrhos.php" >Status (BR)</a>
		<a href="status_clearbr_adm.php" >Status ใบยืมค้างเคลียร์</a>
    </div>
  </div>
	


  <div class="dropdown w3-right">
    <button class="dropbtn">ใบสั่งขาย Hospital
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
   		<a href="status_adminhos.php" >Status (SO)</a>
		<a href="status_admin_jong.php" >Status (SO) ใบฝาก</a>
		</div>
  </div>
	
	<div class="dropdown w3-right">
    <button class="dropbtn">ใบสั่งลดหนี้
      <i class="fa fa-caret-down"></i>
    </button>
	   <div class="dropdown-content">
   	 <a href="register_credinot_create.php" >สร้างใบสั่งลดหนี้</a>
	 <a href="status_credit_adm.php" >รายการใบสั่งลดหนี้</a>
     <a href="status_credit_admall.php">รายการใบสั่งลดหนี้ทั้งหมด</a>
	<a href="status_credit_statall.php">รายการสถานะใบสั่งลดหนี้</a>
		   
    </div>
	</div>
	
	<?php }else{ ?>
	
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
	
<?php
$strSQLem = "SELECT *  FROM tb_customer_pre  where send_ad ='1' and status_cus = 'Request'";
$objQueryem = mysqli_query($conn,$strSQLem) or die ("Error Query [".$strSQLem."]");
$Num_Rowsem = mysqli_num_rows($objQueryem);
?>	
	
  <div class="dropdown w3-right">
    <button class="dropbtn">Setting <?php if($Num_Rowsem > 0 ){ ?><font color="red">(<?php echo $Num_Rowsem; ?>)</font><?php } ?>
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <a href="add_customer.php">ลูกค้า</a>
		<?php if($_SESSION['name']=='บรรจบพร' or $_SESSION['name']=='ขนิษฐา' or $_SESSION['name']=='ปิยะ' or $_SESSION['name']=='สุภัสสร'){ ?>
	<a href="status_customerapp.php">อนุมัติลูกค้า<?php if($Num_Rowsem > 0 ){ ?><font color="red">(<?php echo $Num_Rowsem; ?>)</font><?php } ?></a>
		<?php } ?>
	 <a href="add_modecus.php">กลุ่มลูกค้า</a>
	   <a href="add_vendor.php">ผู้ขาย</a>
      <a href="add_salechannel.php">ช่องทางการขาย</a>
	  <a href="add_delivery.php">การจัดส่ง</a>
	  <a href="add_document.php">เอกสารประกอบการออกบิล</a>
	   <a href="add_payment.php">การชำระเงิน</a>
      <a href="add_salechannel.php">ช่องทางการขาย</a>
		<a href="add_docno.php">เลขที่เอกสาร NBM</a>
       <a href="add_docnoptl.php">เลขที่เอกสาร AWL</a>
		<a href="add_etnbm.php">เลขที่เอกสาร ET NBM</a>
       <a href="add_etawl.php">เลขที่เอกสาร ET AWL (1-600)</a>
		<a href="add_etawl_1.php">เลขที่เอกสาร ET AWL (601-1200)</a>
		<a href="add_etawl_2.php">เลขที่เอกสาร ET AWL (1301-1900)</a>
		<a href="add_etawl_3.php">เลขที่เอกสาร ET AWL (1901-2400)</a>
		<a href="add_solnbm.php">เลขที่ SOL NBM</a>
       <a href="add_solptl.php">เลขที่ SOL AWL</a>

    </div>
  </div>
	
	<div class="dropdown w3-right">
	<button class="dropbtn">Export Express
		<i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
		<a href="search_cusexpress_sol.php">ดึงรายชื่อลูกค้าออนไลน์</a>
		<a href="search_orderexpress_sol.php">ดึงรายการ Order ออนไลน์</a>
		<a href="search_cusexpress_hos.php">ดึงรายชื่อลูกค้า รพ.</a>
		<a href="search_orderexpress_hos.php">ดึงรายการ Order รพ.</a>
		<a href="search_orderexpress_ecom.php">ดึงข้อมูล Order E-Commerce ลง Express (เคลียร์ยืม)</a>
		</div>
</div>
	
		<div class="dropdown w3-right">
	<button class="dropbtn">Export Etax Invoice
		<i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
<a href="search_taxinvoice.php"> &nbsp;&nbsp;&nbsp; ดึงข้อมูล Invoice ไฟล์ .txt (Home Care)</a>
<a href="search_etax_ecomer.php"> &nbsp;&nbsp;&nbsp; ดึงข้อมูล Invoice ไฟล์ .pdf (Home Care)</a>
		
<a href="search_taxinvoice1.php"> &nbsp;&nbsp;&nbsp; ดึงข้อมูล Invoice ไฟล์ .txt (Hospital)</a>
<a href="search_etax_hos.php"> &nbsp;&nbsp;&nbsp; ดึงข้อมูล Invoice ไฟล์ .pdf (Hospital)</a>
		
<a href="search_creditnote.php"> &nbsp;&nbsp;&nbsp; ดึงข้อมูล Credit Note ไฟล์ .txt</a>
<a href="search_creditfrom.php"> &nbsp;&nbsp;&nbsp; ดึงข้อมูล Credit Note ไฟล์ .pdf</a>
		
<a href="search_taxinvoice_txt.php"> &nbsp;&nbsp;&nbsp; ดึงข้อมูล ไฟล์ .txt (Home Care) ทดแทน</a>
<a href="search_etax_ecomer1.php"> &nbsp;&nbsp;&nbsp; ดึงข้อมูล ไฟล์ .pdf (Home Care)ทดแทน</a>
		
<a href="search_taxinvoice_txt1.php"> &nbsp;&nbsp;&nbsp; ดึงข้อมูล ไฟล์ .txt (Hospital) ทดแทน</a>
<a href="search_etax_hos1.php"> &nbsp;&nbsp;&nbsp; ดึงข้อมูล ไฟล์ .pdf (Hospital) ทดแทน</a>
	
<a href="search_creditnote1.php"> &nbsp;&nbsp;&nbsp; ดึงข้อมูล Credit Note ไฟล์ .txt ทดแทน</a>
<a href="search_creditfrom1.php"> &nbsp;&nbsp;&nbsp; ดึงข้อมูล Credit Note ไฟล์ .pdf ทดแทน</a>	
		
<a href="status_etaxcustomer.php" > &nbsp;&nbsp;&nbsp; ข้อมูลลูกค้าขอใบกำกับภาษี</a>
<a href="status_etax_import.php" > &nbsp;&nbsp;&nbsp; UPDATE ข้อมูลลูกค้าขอใบกำกับภาษี</a>		
<a href="status_etaxcustomeryes.php" > &nbsp;&nbsp;&nbsp; ข้อมูลลูกค้าขอใบกำกับภาษี (รัน ET)</a>
<a href="status_etaxcustomerno.php" > &nbsp;&nbsp;&nbsp; ข้อมูลลูกค้าขอใบกำกับภาษี (Update ไม่สำเร็จ)</a>	
		
		</div>
</div>
	
<?php if ($_SESSION['name']=='บรรจบพร' or $_SESSION['name']=='พิมลพร') {?>	
	  <div class="dropdown w3-right">
	<button class="dropbtn">Report แบบสอบถาม
		<i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
	  <a href="status_researchk_admin.php">รายการทำแบบสอบถาม</a>	
      <a href="search_sumresearch_mk.php">รายงานสรุปแบบสอบถามความพึงพอใจลูกค้าหลังการขายที่ต้องทำ</a>
      <a href="search_sumresearch_sale.php">รายงานสรุปความพึงพอใจลูกค้าหลังการขาย (รายเดือน)</a>
      <a href="search_sumresearch_sale1.php">รายงานสรุปความพึงพอใจลูกค้าหลังการขายแบบใหม่ (รายเดือน)</a>
      <a href="search_sumsearch_sale.php">รายงานสรุปความพึงพอใจลูกค้าหลังการขาย (รายปี)</a>
      <a href="search_sumsearch_salenew.php">รายงานสรุปความพึงพอใจลูกค้าหลังการขายแบบใหม่ (รายปี)</a>
      <a href="search_research_cs.php">รายงานความพึงพอใจของการจัดส่งและการประกอบติดตั้ง</a>
      <a href="search_research_cs1.php">รายงานความพึงพอใจของการจัดส่งและการประกอบติดตั้งแบบใหม่</a>
      <a href="https://service-engineer.allwellcenter.com/main_admin.php">แบบประเมินความพึงพอใจของลูกค้าที่มีต่อบริการหลังการขายช่าง ( รายเดือน )</a>
	  <a href="search_sumresearch_company.php">รายงานสรุปความพึงพอใจลูกค้าหลังการขาย (รายเดือน) New</a>	
    </div>
</div>
	
	<?php } ?>

  <div class="dropdown w3-right">
	<button class="dropbtn">Report HOSPITAL
		<i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
		<a href="search_sale_record.php">Sale Record สินค้า</a>
		<a href="search_hosrecpro.php">Sale Record สินค้า (โรงพยาบาล)</a>
		<a href="search_solrecpro.php">Sale Record สินค้า (ออนไลน์)</a>
		<a href="search_sale_record1.php">Sale Record เลขที่เอกสาร</a>
		<a href="search_hosrec.php">Sale Record เลขที่เอกสาร (โรงพยาบาล)</a>
		<a href="search_solrec.php">Sale Record เลขที่เอกสาร (ออนไลน์)</a>
		<a href="search_sumallevery.php">Sale Record ยอดรวม</a>
		<a href="search_jong_order.php">รายงานสินค้ารอออก ORDER</a>
		<a href="search_clearbr.php">รายงานใบยืมที่ถูกเคลียร์ยืมแล้ว</a>
		<a href="report_clearnobr.php">รายงานสินค้าค้างเคลียร์ยืม</a>
		<a href="search_reportacc1.php">รายงานยอดขายประจำวัน</a>
				<?php if ($_SESSION['name']=='สุภาวดี' or $_SESSION['name']=='บรรจบพร'  or $_SESSION['name']=='สุภัสสร') {?>
		<a href="status_ickangmd.php">รายงานเอกสาร IC & BRSC คงค้าง</a>	
		<a href="search_actual.php">รายงานสรุปยอดขาย</a>
		<a href="search_report_mk.php">สรุปรายการขายแยกตามสินค้า</a>
		<a href="search_report_customer.php">รายงานประวัติการขาย แยกตามลูกค้า</a>
		<a href="search_report_allbyproduct.php"> รายงานประวัติการขาย แยกตามสินค้า</a>
		<?php } ?>
		<a href="search_review.php">รายงานใบตรวจทานสินค้า</a>
		<a href="report_mdkangbr.php" target="_blank">รายงานสรุปค้างยืมสินค้า(ตามเขตการขาย)</a>
		<a href="report_clearstsa.php" target="_blank">รายงานสรุปใบยืมสินค้า(ตามเลขที่ใบยืม)</a>
    <a href="search_clearnobr.php">รายงานรายการสรุปการยืมสินค้า</a>
		<a href="search_traninter.php">รายงานรายการสรุปขนส่ง Inter</a>
    </div>
</div>
<div class="dropdown w3-right">
	<button class="dropbtn">Report SOL
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
		<a href="search_kangclear.php">รายงานออเดอร์ค้างเคลียร์ยืม</a>
		<a href="search_cleariv.php">รายงานออเดอร์เคลียร์ยืม</a>
		<a href="search_solno.php">รายงานสรุปแยก SOL และ IV ที่ออกบิลแล้ว</a>
		<a href="search_soltype.php">รายงานสรุปแยก SOL</a>
		<a href="search_reportacc.php">รายงานยอดขายประจำวัน</a>
		<a href="search_sumweek.php">รายงานสรุปรายการในเลขที่เอกสาร</a>
		<a href="search_report_datemar.php">รายงานสรุปรายการสินค้า</a>
		<a href="report_clearnobrsol.php">รายงานสินค้าค้างเคลียร์ยืม</a>
		<a href="search_sendbill.php">ดึงข้อมูลส่งบิลลูกค้า</a>
		<a href="search_kerry.php" >รายงาน Kerry</a>
		<a href="search_spx.php" >รายงาน SPX EXPRESS</a>
		<a href="report_kerrysol.php" >รายการ Kerry รับเอง</a>
		<a href="report_kerryhos.php" >รายการ Kerry จัดส่งรับของ</a>
		<a href="search_IVcearsol.php" >รายงานสรุป IV ที่ออกบิลแล้ว</a>
		<a href="report_kerrymonth.php" >รายงานข้อมูลการจัดส่งสินค้า</a>
		<a href="report_tracksum.php" >รายงานข้อมูลขนส่งประจำวัน</a>
		<a href="report_today_spxkerry.php" >ตารางแจ้งการจัดส่ง SPX&Kerry</a>
		<a href="report_smptiktok.php" >รายงานใบเบิกสินค้า SMP TIKTOK (ทั้งหมด)</a>
		<a href="search_IE.php">รายงานใบกำกับภาษี</a>
		<?php if($_SESSION['name']=='พิมลพร') { ?>
		<a href="search_buyagain.php">รายงานลูกค้าซื้อซ้ำกลุ่มสินค้า</a>
		<?php } ?>
		<?php if($_SESSION['name']=='ปิยะ') { ?>
		<a href="status_almostpro.php">รายการสินค้ายอดนิยมออนไลน์สินค้าคงเหลือต่ำกว่ากำหนด</a>
		<?php } ?>
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
	
	
	
	<?php /*<div class="dropdown w3-right">
    <button class="dropbtn">API E-Commerce
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
		<a href="https://auth.lazada.com/oauth/authorize?response_type=code&force_auth=true&redirect_uri=https://allwellcenter.com/php/LazadaShopVerify.php&client_id=124441" >Lazada Healthmarth</a>
	 
    </div>
  </div>*/ ?>
	
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

/*$strSQL = "SELECT price_ckk FROM so__main  where price_ckk='1' and approve_complete='Request'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);

$strSQL1 = "SELECT price_ckk FROM so__main  where bill_id='' and approve_complete ='Approve' and cancel_ckk='0' and doc_no NOT LIKE '%B%'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

$strSQL2 = "SELECT ref_id FROM (so__main LEFT JOIN tb_customer ON so__main.bill_id=tb_customer.customer_id)  where approve_complete ='Approve' and cancel_ckk='0'  and customer_code ='' and select_type_doc='3'";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$Num_Rows2 = mysqli_num_rows($objQuery2);
				
$strSQL3 = "SELECT ref_id FROM (so__main LEFT JOIN tb_customer ON so__main.bill_id=tb_customer.customer_id)  where approve_complete ='Approve' and cancel_ckk='0'  and customer_coden ='' and select_type_doc='4'";
$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$Num_Rows3 = mysqli_num_rows($objQuery3);*/
				
$strSQL4 = "SELECT price_ckk FROM so__main  where allwell_ckk ='1' and sale_channel = '4' and doc_release_date = '0000-00-00' and approve_complete !='Rejected' and have_order = '0' and cancel_ckk='0'";
$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
$Num_Rows4 = mysqli_num_rows($objQuery4);
				
$strSQL5 = "SELECT price_ckk FROM so__main  where (sale_channel = '3' or sale_channel = '45' or sale_channel = '46')  and ckk_h='0' and cancel_ckk='0' and approve_complete ='Approve' and doc_release_date='0000-00-00'";
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$Num_Rows5 = mysqli_num_rows($objQuery5);

$strSQL6 = "SELECT ref_id FROM (so__main LEFT JOIN tb_customer ON so__main.bill_id=tb_customer.customer_id)  where allwell_ckk ='1'   and cancel_ckk='0'  and doc_no ='BRNP' and approve_complete ='Approve'";
$objQuery6 = mysqli_query($conn,$strSQL6) or die ("Error Query [".$strSQL6."]");
$Num_Rows6 = mysqli_num_rows($objQuery6);	
				
$strSQL2s = "SELECT ref_id FROM so__main where doc_release_date ='0000-00-00' and (sale_channel = '1' or sale_channel ='12') and cancel_ckk ='0' and approve_complete ='Approve'";
$objQuery2s = mysqli_query($conn,$strSQL2s) or die ("Error Query [".$strSQL2s."]");
$Num_Rows2s = mysqli_num_rows($objQuery2s);				
				
$strSQL3s = "SELECT ref_id FROM so__main where order_refer_code ='' and  sale_channel ='12' and cancel_ckk ='0' and approve_complete ='Approve' and employee_name ='SOL92' and doc_no NOT LIKE '%BRN%' and order_id !='' and sr_no =''";
$objQuery3s = mysqli_query($conn,$strSQL3s) or die ("Error Query [".$strSQL3s."]");
$Num_Rows3s = mysqli_num_rows($objQuery3s);				
		
$strSQL3cs = "SELECT ref_id FROM so__main where cancel_ckk ='2' and approve_complete ='Approve'";
$objQuery3cs = mysqli_query($conn,$strSQL3cs) or die ("Error Query [".$strSQL3cs."]");
$Num_Rows3cs = mysqli_num_rows($objQuery3cs);				

$strSQL5cs = "SELECT ref_id FROM so__main where cancel_ckk ='1' and doc_no LIKE '%ET%' and approve_complete ='Approve'";
$objQuery5cs = mysqli_query($conn,$strSQL5cs) or die ("Error Query [".$strSQL5cs."]");
$Num_Rows5cs = mysqli_num_rows($objQuery5cs);				

	
				
$strSQLo2s = "SELECT ref_id,select_type_doc,register_date,doc_no,doc_release_date,delivery_contact,approve_complete,ckk_h,bill_vat,select_type_doc,status_vat,print_vat,print_doc,sale_channel,close_mount,billing_name,order_id  FROM so__main  where doc_no ='' and (sale_channel = '1' or sale_channel ='12') and cancel_ckk ='0' and approve_complete ='Approve' and pre_ckk='1' ";
$objQueryo2s = mysqli_query($conn,$strSQLo2s) or die ("Error Query [".$strSQLo2s."]");
$Num_Rowo2s = mysqli_num_rows($objQueryo2s);				
				
				
	?>				
	
  <div class="dropdown w3-right">
    <button class="dropbtn">Admin Online <?php if($Num_Rows4 > 0 or $Num_Rows5 > 0 or $Num_Rows6 > 0 or $Num_Rows2s > 0 or $Num_Rows3s > 0 or $Num_Rowo2s > 0 or $Num_Rows3cs > 0){ ?><font color="red">(<?php echo $Num_Rows5+$Num_Rows4+$Num_Rows6+$Num_Rows2s+$Num_Rows3s+$Num_Rowo2s+$Num_Rows3cs; ?>)</font><?php } ?>

      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
	 <a href="status_deposit.php" >รายการใบรับเงินมัดจำ</a>
		<?php /* <a href="status_deposit_bill_send.php" >รายการใบรับเงินมัดจำ เปิดบิลแล้วรอส่งของ</a> 
      <a href="register_admin.php">Register</a>*/ ?>
		<a href="main_allwell_so.php" >Create ใบสั่งขาย</a>
	   <a href="main_allwell_br.php" >Create ใบยืม</a>
      <a href="status_admin.php">Status</a>
<a href="status_adminprice.php">Status ออเดอร์สินค้าราคาต่ำกว่ากำหนด <?php /*if($Num_Rows > 0 ){ ?><font color="red">(<?php echo $Num_Rows; ?>)</font><?php }*/ ?></a>
		<a href="status_kangbillvat.php">Status ค้างส่งอนุมัติใบกำกับภาษี</a>
		<a href="status_solkang_idcus.php">Status ค้าง ID ลูกค้า <?php /*if($Num_Rows1 > 0 ){ ?><font color="red">(<?php echo $Num_Rows1; ?>)</font><?php }*/ ?></a>
		<a href="status_solkang_excus.php">Status ค้างรหัสลูกค้า Express AWL <?php /*if($Num_Rows2 > 0 ){ ?><font color="red">(<?php echo $Num_Rows2; ?>)</font><?php }*/ ?></a>
		<a href="status_solkang_excusnb.php">Status ค้างรหัสลูกค้า Express NBM <?php /*if($Num_Rows3 > 0 ){ ?><font color="red">(<?php echo $Num_Rows3; ?>)</font><?php }*/ ?></a>
		<a href="status_twocompany.php">Status ออเดอร์ 2 บริษัท <?php if($Num_Rows2s > 0 ){ ?><font color="red">(<?php echo $Num_Rows2s; ?>)</font><?php } ?></a>
		<a href="status_preorder.php">Status PreOrder <?php if($Num_Rowo2s > 0 ){ ?><font color="red">(<?php echo $Num_Rowo2s; ?>)</font><?php } ?></a>
		<a href="status_notrackecom.php">Status Order Shopee ไม่มีเลขขนส่ง <?php if($Num_Rows3s > 0 ){ ?><font color="red">(<?php echo $Num_Rows3s; ?>)</font><?php } ?></a>
		<a href="status_cancel_ecom.php">Status Order Shopee ยกเลิก <?php if($Num_Rows3cs > 0 ){ ?><font color="red">(<?php echo $Num_Rows3cs; ?>)</font><?php } ?></a>
		<a href="status_cancel_etecom.php">Status Order Shopee ET ยกเลิก <?php if($Num_Rows5cs > 0 ){ ?><font color="red">(<?php echo $Num_Rows5cs; ?>)</font><?php } ?></a>
		<a href="status_admin_bedkang.php">Status เตียง ค้าง IV <?php if($Num_Rows4 > 0 ){ ?><font color="red">(<?php echo $Num_Rows4; ?>)</font><?php } ?></a>
		<a href="status_kang99.php">Status 99 ค้าง IV <?php if($Num_Rows5 > 0 ){ ?><font color="red">(<?php echo $Num_Rows5; ?>)</font><?php } ?></a>
		<a href="status_allwell_kangbr.php">Status ใบยืม ค้าง IV <?php if($Num_Rows6 > 0 ){ ?><font color="red">(<?php echo $Num_Rows6; ?>)</font><?php } ?></a>
		<a href="status_admin_kangallorder.php">Status รวมค้าง IV</a>
		<a href="status_admin_bed.php">Status เตียง</a>
		<a href="status_onlinekangsend.php">Status ค้างส่งสินค้า</a>
		<a href="status_admin_99.php">Status 99</a>
		<a href="status_adm_deloth.php">Status คีย์ค่าขนส่ง</a>
		<a href="status_allwell_adminfak.php">Status ใบฝาก</a>
		<a href="status_solquebr.php">Status ใบยืมด่วน</a>
		<a href="status_solque.php">Status ใบสั่งขายด่วน</a>
		<a href="status_admin_sendbill.php">Status เปิดบิลแล้วรอส่งของ</a>
		<a href="status_clear_admin.php">Status ใบยืมค้างเคลียร์</a>
		<a href="status_clearbr_ecomerce.php">Status ใบยืมค้างเคลียร์ E - Commerce</a>
		
		<?php if ($_SESSION['name']=='สุภาวดี' or $_SESSION['name']=='บรรจบพร'  or $_SESSION['name']=='สุภัสสร') {?>
		<a href="status_supadmvat.php">อนุมัติใบกำกับภาษี</a>
		<?php } ?>
		<a href="status_clearbrmm.php" >Status โชว์เคลียร์ยิม</a>
		<a href="status_customer_receive.php" >Status ลูกค้ารับเอง</a>
		<a href="search_brkangclear.php">รายงานใบยืมค้างเคลียร์ Showroom</a>
    </div>
  </div>
<?php

$strSQL5 = "SELECT credit_no FROM tb_credit_note  where credit_no=''  and status_doc ='Approve'";
$objQuery5 = mysqli_query($conn,$strSQL5) or die ("Error Query [".$strSQL5."]");
$Num_Rows5 = mysqli_num_rows($objQuery5);
?>
	
	 <div class="dropdown w3-right">
    <button class="dropbtn">ใบสั่งลดหนี้ <?php if($Num_Rows5 > 0 ){ ?><font color="red">(<?php echo $Num_Rows5; ?>)</font><?php } ?>
      <i class="fa fa-caret-down"></i>
    </button>
	   <div class="dropdown-content">
   	 <a href="mainad_credinot.php" >สร้างใบสั่งลดหนี้</a>
	 <a href="status_credit_adm.php" >รายการใบสั่งลดหนี้  <?php if($Num_Rows5 > 0 ){ ?><font color="red">(<?php echo $Num_Rows5; ?>)</font><?php } ?></a>
     <a href="status_credit_admall.php">รายการใบสั่งลดหนี้ทั้งหมด</a>
	<a href="status_credit_admcan.php">รายการใบสั่งลดหนี้(ยกเลิก)</a>
	<a href="status_credit_statall.php">รายการสถานะใบสั่งลดหนี้</a>
		   
    </div>
	</div>
	
  <div class="dropdown w3-right">
    <button class="dropbtn">E-Commerce 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
     <a href="search_apilazada.php">ดึงข้อมูล Lazada</a> 
	<?php /*<a href="upload_healthmart.php">Lazada Healthmart Online</a>
      <a href="upload_medshop.php">Lazada MedShop</a>*/ ?>
      <a href="upload_shopee.php">Shopee ส่งปกติ</a>
	  <a href="upload_shopee1.php">Shopee ส่งด่วน</a>	
	  <!--a href="upload_jdcental.php">JD central</a-->
	  <a href="upload_ctonline.php">Central Online</a>
	  <a href="upload_officemate.php">Officemate</a>
	  <a href="upload_nocnoc.php">Noc Noc</a>
	  <!--a href="upload_homepro.php">Homepro1</a-->
	  <a href="upload_homepro1.php">Homepro</a>
	  <a href="upload_tiktok.php">Tiktok</a>
	  <a href="upload_thisshop.php">Thisshop</a>
	  <a href="upload_ktc.php">KTC Ushop Web</a>
	  <a href="upload_ktcnew.php">KTC Ushop Line & Facebook</a>
	  <a href="upload_ktcmobile.php">KTC Ushop App</a>	
	  <a href="upload_bd.php">BeDee</a>
	  <a href="upload_amaze.php">Amaze</a>	
	  <!--a href="upload_ktcnew1.php">KTC Ushop Facebook</a-->
	  <a href="Upload_cleariv.php">รายการเคลียร์ใบยืม</a>
	  <a href="up_cleariv_no.php">รายการเคลียร์ใบยืมตามรายการสินค้า</a>
	  <a href="upload_discount.php">รายการส่วนลด</a>
	  <a href="upload_99.php" >Upload ข้อมูลร้าน 99</a>
	  <a href="upload_tran.php" >Upload ค่าจัดส่ง ร้าน 99</a>
	  <a href="upload_solnb.php">Upload SOL NBM</a>
	<?php /*<a href="upload_freepro.php">Update รายการสินค้าของแถมโปรโมชั่น</a>*/ ?>
	
	  <a href="search_productpomo.php">รายการสินค้าของแถมโปรโมชั่น</a>
	  <a href="upload_tranpro.php">Update ค่าส่วนต่างสินค้า</a>
		
    </div>
  </div> 

	<div class="dropdown w3-right">
    <button class="dropbtn">ใบแจ้ง PO
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
   
   	<a href="main_admin_po.php" >สร้างใบแจ้ง PO</a>
	<a href="status_adminkangpo.php" >Status (PO)ค้างออกใบสั่งขาย</a>
 	<a href="status_adminpo.php" >Status (PO)</a>
	    </div>
  </div>
	
<?php
$strSQLp5 = "SELECT *  FROM fb__maim  where  status_doc ='3' and department_id LIKE '%OF%'";
$objQueryp5 = mysqli_query($user,$strSQLp5) or die ("Error Query [".$strSQL5."]");
$Num_Rowsp5 = mysqli_num_rows($objQueryp5);		

/*if($_SESSION['name']=='บรรจบพร'){				
$strSQLpt5 = "SELECT *  FROM no__complete  where  status_doc ='' and send_doc ='1' and send_sup ='0' and type_doc ='9'";
$objQuerypt5 = mysqli_query($conn,$strSQLpt5) or die ("Error Query [".$strSQLt5."]");
$Num_Rowspt5 = mysqli_num_rows($objQuerypt5);			
	
}*/	
?>				
	
<div class="dropdown w3-right">
    <button class="dropbtn">แบบฟอร์ม Feedback  <?php if(($Num_Rowsp5+$Num_Rowspt5) > 0 ){ ?><font color="red">(<?php echo $Num_Rowsp5+$Num_Rowspt5; ?>)</font><?php } ?>
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
   
   	<a href="https://feedback.allwellcenter.com/check_login_out.php?token=<?php echo  $token; ?>"  target="_blank" >แบบฟอร์ม Feedback <?php if(($Num_Rowsp5+$Num_Rowspt5) > 0 ){ ?><font color="red">(<?php echo ($Num_Rowsp5+$Num_Rowspt5); ?>)</font><?php } ?></a>
	
	    </div>
  </div>
	

<?php
$strSQL2 = "SELECT status_doc  FROM hos__br  where status_doc ='Approve' and iv_date ='0000-00-00'";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
$Num_Rows2 = mysqli_num_rows($objQuery2);
?>				

<div class="dropdown w3-right">
    <button class="dropbtn">ใบยืม Hospital <?php if($Num_Rows2 > 0 ){ ?><font color="red">(<?php echo $Num_Rows2; ?>)</font><?php } ?>
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
   
   <?php  /*<a href="register_adminbrhos.php" >Borrow (BR)</a>*/ ?>
	<a href="status_brkang_br.php" >Status (BR) ค้างเลขที่ใบยืม <?php if($Num_Rows2 > 0 ){ ?><font color="red">(<?php echo $Num_Rows2; ?>)</font><?php } ?></a>
 	<a href="status_adminbrhos.php" >Status (BR)</a>
		<a href="status_adminbr_que.php" >Status (BR) ด่วน</a>
		<a href="status_hosbrdoc.php" >Status BR (เตรียมเอกสาร)</a>
	<a href="status_clearbr_adm.php" >Status ใบยืมค้างเคลียร์</a>
		<a href="status_adminbr_kangcus.php" >Status ใบยืมค้าง ID ลูกค้า</a>
		<?php if($_SESSION['name']=='สุภัสสร' or $_SESSION['name']=='บรรจบพร'){ ?> 
		<a href="report_brkangbyad.php" >ตรวจเช็คใบยืมค้างเคลียร์ (stock)</a>
	    <a href="status_brareaad.php" >รายการตรวจเช็คใบยืม (ทั้งหมด)</a>
		<?php } ?>
    <?php if($_SESSION['name']=='บรรจบพร'){ ?> 
		<a href="main_soanysup.php" >Status เคลียร์ใบยืมหลายเอกสาร</a>
		<?php } ?>
    </div>
  </div>

<?php
$strSQL4 = "SELECT send_admin  FROM hos__change  where send_admin='1' and status_doc ='Approve' and iv_no=''";
$objQuery4 = mysqli_query($conn,$strSQL4) or die ("Error Query [".$strSQL4."]");
$Num_Rows4 = mysqli_num_rows($objQuery4);
?>				
	
	
	<div class="dropdown w3-right">
    <button class="dropbtn">ใบแลกเปลี่ยน <?php if($Num_Rows4 > 0 ){ ?><font color="red">(<?php echo $Num_Rows4; ?>)</font><?php } ?>
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
    <a href="main_suphos_change.php" >สร้างใบแลกเปลี่ยนสินค้า</a>
	<a href="status_adminchange1.php" >รายการแลกเปลี่ยน รอใส่เลขที่เอกสาร <?php if($Num_Rows4 > 0 ){ ?><font color="red">(<?php echo $Num_Rows4; ?>)</font><?php } ?></a>	
    <a href="status_adminchange.php" >รายการแลกเปลี่ยน</a>
		    </div>
  </div>
	
<?php
$strSQL3 = "SELECT send_admin  FROM hos__consig  where send_admin='1' and status_doc ='Approve' and iv_no=''";
$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$Num_Rows3 = mysqli_num_rows($objQuery3);
?>				
	
	<div class="dropdown w3-right">
    <button class="dropbtn">ใบยืมฝากขาย <?php if($Num_Rows3 > 0 ){ ?><font color="red">(<?php echo $Num_Rows3; ?>)</font><?php } ?>
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
    <a href="status_adminbrsc_kang.php" >Status ใบยืมฝากขาย (ค้างเลขที่เอกสาร) <?php if($Num_Rows3 > 0 ){ ?><font color="red">(<?php echo $Num_Rows3; ?>)</font><?php } ?></a>
    <a href="status_adminbrsc.php" >Status ใบยืมฝากขาย</a>
		<a href="status_clearbrsc_admin.php" >Status ใบยืมฝากขายค้างเคลียร์</a>
		
		<?php if($_SESSION['name']=='บรรจบพร'){ ?> 
		<a href="main_soanysup_brsc.php" >Status เคลียร์ใบยืมฝากขายหลายเอกสาร</a>
		<?php } ?>
		
		    </div>
  </div>
<?php

$strSQL7 = "SELECT send_admin  FROM hos__rental  where send_admin='1' and promis_no =''";
$objQuery7 = mysqli_query($conn,$strSQL7) or die ("Error Query [".$strSQL7."]");
$Num_Rows7 = mysqli_num_rows($objQuery7);

?>
	
	<div class="dropdown w3-right">
    <button class="dropbtn">ใบสั่งเช่า <?php if($Num_Rows7 > 0 ){ ?><font color="red">(<?php echo $Num_Rows7; ?>)</font><?php } ?>

      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
	<a href="status_adminrental1.php" >Status ใบสั่งเช่าค้างเลขที่สัญญา <?php if($Num_Rows7 > 0 ){ ?><font color="red">(<?php echo $Num_Rows7; ?>)</font><?php } ?></a>		
	<a href="status_adminrental.php" >Status ใบสั่งเช่า </a>	
	<a href="status_adminrental_kang.php" >Status ใบสั่งเช่ารอออกใบสั่งขาย</a>
	</div>
  </div>
	
<?php
$strSQL = "SELECT ref_id FROM hos__so  where status_doc ='Approve' and send_sup ='1' and iv_date ='0000-00-00' and have_order = '0' and ic_ckk='0'";
$objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
				
$strSQL1 = "SELECT ref_id FROM hos__so  where status_doc ='Approve'  and send_sup ='1' and iv_date ='0000-00-00' and have_order='1' and have_product = '2' and ic_ckk='0'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);

/*$strSQLj1 = "SELECT tb_comment_so.ref_id FROM  (tb_comment_so LEFT JOIN hos__so ON  tb_comment_so.ref_id = hos__so.ref_id)  where comment_ad!='' and complete_adckk='0' and status_doc = 'Approve'";
$objQueryj1 = mysqli_query($conn,$strSQLj1) or die ("Error Query [".$strSQLj1."]");
$Num_Rowsj1 = mysqli_num_rows($objQueryj1);*/
				
$strSQLic = "SELECT ref_id FROM hos__so  where status_doc ='Approve' and send_sup ='1' and iv_date ='0000-00-00' and ic_ckk='1'";
$objQueryic = mysqli_query($conn,$strSQLic) or die ("Error Query [".$strSQLic."]");
$Num_Rowsic = mysqli_num_rows($objQueryic);				
	?>
	
 <?php
$i=1;	
$strSQL3 = "SELECT ref_id FROM tb_comment_so  WHERE comment_ad != '' AND complete_adckk = '0'";
$objQuery3 = mysqli_query($conn, $strSQL3) or die("Error Query [" . mysqli_error($sol) . "]");
$Num_Rows3 = mysqli_num_rows($objQuery3);
$i = 0;
while($objResult3 = mysqli_fetch_array($objQuery3))
{
$ref_iv = substr($objResult3["ref_id"],0,2);	
	
if($ref_iv=='SO'){ 
$strSQL15 = "SELECT status_doc FROM hos__so WHERE ref_id = '".$objResult3["ref_id"]."' ";
$objQuery15 = mysqli_query($conn, $strSQL15) or die("Query Error: " . mysqli_error($conn));
$objResult15 = mysqli_fetch_array($objQuery15);
$status_doc = $objResult15["status_doc"];	
}else{
$strSQL15 = "SELECT approve_complete FROM so__main WHERE ref_id = '".$objResult3["ref_id"]."' ";
$objQuery15 = mysqli_query($conn,$strSQL15);
$objResult15= mysqli_fetch_array($objQuery15);
$status_doc = $objResult15["approve_complete"];	



}	
if($status_doc=='Approve'){	
$i++;		
}
}



?>
	
  <div class="dropdown w3-right">
    <button class="dropbtn">ใบสั่งขาย Hospital <?php if($Num_Rows > 0 or $Num_Rows1 > 0 or $i > 0 or $Num_Rowsic > 0){ ?><font color="red">(<?php echo $Num_Rows+$Num_Rows1+$i+$Num_Rowsic; ?>)</font><?php } ?>
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
   
    <?php /*<a href="register_adminhos.php" >Sale Order (SO)</a>*/ ?>
		<a href="status_adminhos1.php" >Status (SO)ค้างเลขที่ IV <?php if($Num_Rows > 0){ ?><font color="red">(<?php echo $Num_Rows+$Num_Rows1; ?>)</font><?php } ?></a>
		<a href="status_adminhosic1.php" >Status (ฝากขาย) ค้าง (IC) <?php if($Num_Rowsic > 0){ ?><font color="red">(<?php echo $Num_Rowsic; ?>)</font><?php } ?></a>
		<a href="status_admkangcom.php" >Status หมายเหตุแจ้ง Admin <?php if($i > 0){ ?><font color="red">(<?php echo $i; ?>)</font><?php } ?></a>
		<a href="status_admallcom.php" >Status หมายเหตุแจ้ง Admin (ทั้งหมด)</a>
		<a href="status_hoskang_exawl.php">Status ค้างรหัสลูกค้า Express AWL</a>
		<a href="status_hoskang_exnbm.php">Status ค้างรหัสลูกค้า Express NBM</a>
		<a href="status_adminhos.php" >Status (SO)</a>
		<a href="status_adminhosic.php" >Status (ฝากขาย IC) ทั้งหมด</a>
		<a href="status_admin_jong.php" >Status (SO) ใบฝาก</a>
		<a href="status_adminhos_que.php" >Status (SO) ด่วน</a>
		<a href="status_hossodoc.php" >Status SO (เตรียมเอกสาร)</a>
		<a href="status_hos_sendbill.php" >Status (SO) เปิดบิลแล้วรอส่งของ</a>
		<a href="status_admin_customer.php" >Status (SO) รอรหัสลูกค้า</a>
      <a href="status_stockhos_all.php" >Status (SO) ค้างส่ง</a>
		<a href="status_salereport.php" >Status (สรุปขายสมบูรณ์) Sale Report</a>
    </div>
  </div>
	
	
		<div class="dropdown w3-right">
    <button class="dropbtn">ใบรับคืน   
	<i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
	
 <a href="status_receive_ecom.php">Status ใบรับคืน E - Commerce</a>
		<a href="status_receive_showroom.php">Status ใบรับคืน Showroom</a>
		<a href="status_receive_admin.php">Status ใบบันทึกรับคืนสินค้า</a>
      </div>
  </div>
	
	
	
	
	<?php if($_SESSION['name']=='สุภาวดี' or $_SESSION['name']=='พิมลพร'){ ?> 
	
	<div class="dropdown w3-right">
    <button class="dropbtn">แบบสอบถาม     
	<i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
	
    <a href="status_researchmer.php" >แบบสอบถามที่นอนโฟม ขนส่งนอก</a>
<a href="status_reserch_receive.php" >แบบประเมินความพึงพอใจในการจัดสินค้า</a>
      </div>
  </div>
	<?php }else{ ?>
	<!--div class="dropdown w3-right">
    <button class="dropbtn">แบบสอบถาม     
	<i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
<a href="status_reserch_receive.php" >แบบประเมินความพึงพอใจในการจัดสินค้า</a>
      </div>
  </div-->
	
	<?php } ?>
	
	<div class="dropdown w3-right">
    <button class="dropbtn">ใบเบิกสินค้า      
	<i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
		<?php if($_SESSION['name']=='สุภาวดี' or $_SESSION['name']=='บรรจบพร'  or $_SESSION['name']=='สุภัสสร' or $_SESSION['name']=='ขนิษฐา'){ ?>
    <a href="main_admin_smp.php" >สร้างเบิกสินค้า</a>
		 <a href="status_adminsmp1.php" >รายการเบิกสินค้า(Admin สร้าง)</a>
		
		<?php } ?>
		
		 <a href="status_adminmp_kangiv.php" >รายการเบิกสินค้าค้างเลขที่</a>
    <a href="status_adminmp.php" >รายการเบิกสินค้าทั้งหมด</a>
		<a href="upload_smptiktok.php">Update เลขขนส่ง SMP</a>
      </div>
  </div>
	
	<div class="dropdown w3-right">
    <button class="dropbtn">ใบรับสินค้า      
	<i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
	<a href="main_receivepro_adm.php" >สร้างใบรับสินค้า</a>			
    <a href="status_receivepro_adm.php" >รายการใบรับสินค้า</a>
      </div>
  </div>
	
	<div class="dropdown w3-right">
    <button class="dropbtn">รายการรับจ่ายใบยืม      
	<i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
   
    <a href="register_recevebr.php" >สร้างรายการรับจ่าย</a>
		 <a href="status_recevebr.php" >รายการรับจ่ายใบยืม ค้างคืน</a>
		<a href="status_recevebr2.php" >รายการรับจ่ายใบยืม รอบ2 ค้างคืน</a>
		<a href="status_recevebrall.php" >รายการรับจ่ายใบยืม All</a>
      </div>
  </div>
	
	<div class="dropdown w3-right">
    <button class="dropbtn">รายการรับเรื่องจากลูกค้า      
	<i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
   
    <a href="register_story.php" >การรับเรื่องจากลูกค้า</a>
		<a href="status_storykangsm.php" >รายการรับเรื่องจากลูกค้า (รอใส่เขตการขาย)</a>
		 <a href="status_storyadmkang.php" >รายการรับเรื่องจากลูกค้า Admin(ค้าง)</a>
	  <a href="status_storykang.php" >รายการรับเรื่องจากลูกค้า (ค้าง)</a>
	   <a href="status_storyall.php" >รายการรับเรื่องจากลูกค้า (ปิดงานแล้ว)</a>
			 <a href="register_cuseng.php" >การรับเรื่องลูกค้าของช่าง</a>
	<a href="status_cusopen.php" >รายการรับเรื่องลูกค้าช่าง</a>	
		
      </div>
  </div>
	
<?php if($_SESSION['name']=='สุภาวดี' or $_SESSION['name']=='บรรจบพร'  or $_SESSION['name']=='สุภัสสร' or $_SESSION['name']=="ขนิษฐา" or $_SESSION['name']=="พิมลพร"){ 
	
$strSQL74 = "SELECT *  FROM hos__so  where  status_doc ='Request' and send_sup ='1' and send_cm ='0' and adm_ckk='1' ";
$objQuery74 = mysqli_query($conn,$strSQL74) or die ("Error Query [".$strSQL74."]");
$Num_Rows74 = mysqli_num_rows($objQuery74);

$strSQL75 = "SELECT *  FROM hos__change  where  status_doc ='Request' and send_sup ='1' and adm_ckk='1' ";
$objQuery75 = mysqli_query($conn,$strSQL75) or die ("Error Query [".$strSQL75."]");
$Num_Rows75 = mysqli_num_rows($objQuery75);
		
$strSQL76 = "SELECT *  FROM hos__br  where  status_doc ='Request' and send_sup ='1' and adm_ckk ='1' ";
$objQuery76 = mysqli_query($conn,$strSQL76) or die ("Error Query [".$strSQL76."]");
$Num_Rows76 = mysqli_num_rows($objQuery76);

$fff = $Num_Rows74+$Num_Rows75+$Num_Rows76;		
	?>
	 <div class="dropdown w3-right">
    <button class="dropbtn">Sale Hos <?php if($fff > 0 ){ ?><font color="red">(<?php echo $fff; ?>)</font><?php } ?> 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
   
     <a href="main_suphos_br.php" >ใบยืม (BR)</a>
 	 <a href="main_suphos_so.php" >ใบสั่งขาย (SO)</a>
		<a href="main_suphos_change.php" >ใบแลกเปลี่ยน</a>
	<a href="main_sup_brsc.php" >ใบยืมฝากขาย </a>	
   <a href="status_supbrhos1.php" >Status ใบยืม (BR)</a>
		<a href="status_suphos1.php" >Status ใบสั่งขาย (SO)</a>
		<a href="status_supchange1.php" >Status ใบแลกเปลี่ยน</a>
	<a href="status_supbrsc1.php" >Status ใบฝากขาย </a>	
		
		<a href="status_approveadm.php" >Approve เอกสาร <?php if($fff > 0 ){ ?><font color="red">(<?php echo $fff; ?>)</font><?php } ?></a>
    </div>
  </div>
	
	 <div class="dropdown w3-right">
    <button class="dropbtn">ใบจอง 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
   
    <a href="status_admin_jongclear.php" >Status ใบจองค้างเคลียร์</a>
 	
    </div>
  </div>
	
	<?php /*
	<div class="dropdown w3-right">
	<button class="dropbtn">Export Express 
		<i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <a href="report_express.php">ดึงข้อมูลการขอบิล</a>
		 <a href="report_sumexpress.php">ดึงข้อมูลการขอบิล (รวมบิล)</a>
	  
    </div>
</div>	*/ ?>
	
<?php } ?>
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