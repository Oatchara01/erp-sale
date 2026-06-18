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
  Setting &nbsp; 
      <i class="fa fa-caret-down"></i>
   
    <div class="dropdown-content w3-right">
     <a href="add_user.php">User</a>
		<a href="add_customer_rgister.php">บัตรสมาชิก</a>
      <a href="add_employee.php">พนักงาน</a>
     <?php  /*<a href="add_product.php">สินค้า</a>
	   <a href="add_bom_lzdhm.php">สินค้า BOM LAZADA HEALTH MART</a>
      <a href="add_bom_lzdmd.php">สินค้า BOM LAZADA MED SHOP</a>
	   <a href="add_bom_shopee.php">สินค้า BOM SHOPEE</a>
		 <a href="add_bom_producthos.php">สินค้า BOM Hospital</a>*/ ?>
      <a href="add_customer.php">ลูกค้า</a>
		<?php if($_SESSION['name']=='ปิยะ' or $_SESSION['name']=='อัจฉรา'){ ?>
	<a href="status_customerapp.php">อนุมัติลูกค้า</a>
	<a href="status_online_cls.php">รายการสินค้ายอดนิยมออนไลน์</a>	
		<?php } ?>
		<a href="add_customer_rgister.php">บัตรสมาชิก</a>
	   <a href="add_vendor.php">ผู้ขาย</a>
	  <a href="add_payment.php">การชำระเงิน</a>
      <a href="add_salechannel.php">ช่องทางการขาย</a>
	  <a href="add_delivery.php">การจัดส่ง</a>
	  <a href="add_document.php">เอกสารประกอบการออกบิล</a>
	  <a href="add_leaflet.php">ใบตรวจทาน</a>
	  <a href="status_warproduct.php">ข้อมูลรายการรับประกันสินค้า</a>
	<?php if($_SESSION['name']=='อัจฉรา' or $_SESSION['name']=='พัชร์ชนัญ'){  ?>	
	<a href="add_prochang.php">สินค้าแลกเครื่องวัดน้ำตาล</a>
	<a href="status_app_credit.php">ข้อมูลวงเงินลูกค้า (รออนุมัติ)</a>		
	<?php } ?>	
    </div>
  </li>

<?php if ($_SESSION['name']=='ชลชินี' or $_SESSION['name']=='สมบัติ') {  }else{ ?> 
<li class="manu_item1_2 w3-right">
  Export ข้อมูล  &nbsp; 
      <i class="fa fa-caret-down"></i>
   
    <div class="dropdown-content w3-right">

		<a href="search_cusexpress_sol.php">ดึงรายชื่อลูกค้าออนไลน์</a>
		<a href="search_orderexpress_sol.php">ดึงรายการ Order ออนไลน์ (ใบสั่งขาย)</a>
		<a href="search_cusexpress_hos.php">ดึงรายชื่อลูกค้า รพ.</a>
		<a href="search_orderexpress_hos.php">ดึงรายการ Order รพ.</a>
		<a href="upload_crm.php">Upload ข้อมูลลูกค้าจาก CRM</a>
		<a href="search_orderexpress_ecom.php">ดึงข้อมูล Order E-Commerce ลง Express (เคลียร์ยืม)</a>

    </div>
  </li>	
<?php } ?>

	
<li class="manu_item1_2 dropbtn w3-right">Report &nbsp;<i class="fa fa-caret-down"></i>
<div class="dropdown-content">

<?php if ($_SESSION['name']=='สมบัติ' or $_SESSION['name']=='ชลชินี'  or $_SESSION['name']=='อัจฉรา' or $_SESSION['name']=='พัชร์ชนัญ') {  ?>

<button type="button" class="collapsible">&nbsp;<i class="fa fa-caret-down"></i> &nbsp;<font class="font_nav_manu_main">Report พี่เปิ้ล</font></button>

<div class="content_nav">
<button type="button" class="collapsible">&nbsp;&nbsp; <i class="bi bi-plus"></i> &nbsp;<font class="font_nav_manu_main">รายงานยอดขายเทียบเป้าหมาย</font></button>
                    
<div class="content_nav">
<a href="report_solgraph1.php">&nbsp;&nbsp;&nbsp; รวม</a>
<a href="report_solgraph.php">&nbsp;&nbsp;&nbsp; แผนก Home Care</a>
<a href="report_hosgraph.php">&nbsp;&nbsp;&nbsp; แผนกโรงพยาบาล</a>

</div>

<button type="button" class="collapsible">&nbsp;&nbsp; <i class="bi bi-plus"></i> &nbsp;<font class="font_nav_manu_main">รายงานยอดขายเปรียบเทียบปี</font></button>
                    
<div class="content_nav">
<a href="report_yearcom.php">&nbsp;&nbsp;&nbsp;รวม</a>
<a href="report_yearhc.php">&nbsp;&nbsp;&nbsp;แผนก Home Care</a>
<a href="report_yearhos.php">&nbsp;&nbsp;&nbsp;แผนก Hospital</a>
<a href="report_year31hc.php">&nbsp;&nbsp;&nbsp;แยกตามลูกค้า</a>

<button type="button" class="collapsible">&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&#8794;&nbsp; <font class="font_nav_manu_main">แยกตามช่องทาง E-Com กลุ่มสินค้า</font></button>
                    
<div class="content_nav">
<a href="report_yearecom.php">&nbsp;&nbsp;&nbsp;&nbsp;มูลค่า</a>
<a href="report_countecom.php">&nbsp;&nbsp;&nbsp;&nbsp;จำนวน</a>
</div>
</div>
								
<a href="report_sumbyproduct.php">รายงานยอดขายเรียงตามสินค้า/แผนก</a>
								
<button type="button" class="collapsible">&nbsp;&nbsp; <i class="bi bi-plus"></i> &nbsp;<font class="font_nav_manu_main">รายงานลูกค้าซื้อซ้ำ</font></button>
                    
<div class="content_nav">
<a href="search_buyckk.php">&nbsp;&nbsp;&nbsp;ตามกลุ่มสินค้า</a>
<a href="search_cusbuyagain.php" >&nbsp;&nbsp;&nbsp;ตามรหัสสมาชิก</a>

</div>


<button type="button" class="collapsible">&nbsp;&nbsp; <i class="bi bi-plus"></i> &nbsp;<font class="font_nav_manu_main">รายงานยอดขายตามกลุ่มสินค้า</font></button>
                    
<div class="content_nav">
<a href="report_sumbygrouppro.php" >&nbsp;&nbsp;&nbsp; เปรียบเทียบตามระยะเวลา /กลุ่มสินค้า</a>
<a href="report_sumbyglugopro.php" >&nbsp;&nbsp;&nbsp; รายงานยอดขาย Gluco All-Pro</a>	
<a href="search_buyprodaycom.php" >&nbsp;&nbsp;&nbsp; ตามบริษัท</a>
<a href="search_buyproday.php" > &nbsp;&nbsp;&nbsp; ตามเขตการขาย</a>
</div>

<a href="report_ecomercevip1.php" >รายงานยอดสั่งซื้อ E-Commerce</a>	
<a href="report_ecomercevip.php" >รายงานเปิดออเดอร์ E-Commerce</a>
<a href="report_showroomvip.php" >รายงานเปิดออเดอร์ Homecare</a>	
<a href="report_allwellecom.php">รายงานสรุปจำนวนลูกค้าสมาชิก Allwell member</a>

<button type="button" class="collapsible">&nbsp;&nbsp; <i class="bi bi-plus"></i> &nbsp;<font class="font_nav_manu_main">รายงานแบบสอบถาม</font></button>
                    
<div class="content_nav">
<a href="report_endemo.php" > &nbsp;&nbsp;&nbsp; ความพึงพอใจสินค้าสาธิต</a>
<a href="report_endemobypro.php" > &nbsp;&nbsp;&nbsp; ความพึงพอใจสินค้าสาธิตตามสินค้า</a>
</div>
<a href="report_sumchon.php" >รายงานยอดขายตาม IV</a>
<a href="report_orderprice.php">รายงานการอนุมัติสินค้าราคาต่ำกว่ากำหนด</a>
<a href="status_ickangmd.php">รายงานเอกสาร IC & BRSC คงค้าง</a>	
<a href="report_smpsumall.php">รายงานใบเบิกสินค้า SMP (ทั้งหมด)</a>
<a href="report_smpglu.php">รายงานใบเบิกสินค้า SMP (GLUCOALL-1B)</a>
<a href="report_newsmp.php">รายงานแลกเปลี่ยนสินค้า (GLUCOALL-1B)</a>	
<a href="report_mdkangbr.php">รายงานใบยืมค้างเคลียร์ตามเขตการขาย</a>
<a href="report_stockedit.php">รายงานขอปรับปรุงยอดสต็อก (ทั้งหมด)</a>	
<?php if ($_SESSION['name']=='อัจฉรา' or $_SESSION['name']=='พัชร์ชนัญ'){  ?>	
<a href="report_itkangbr.php">รายงานใบยืมค้างเคลียร์ตามเขตการขาย (ยอดค้างสต็อก)</a>	
<?php } ?>	
<a href="report_clearstsa.php">รายงานการเคลียร์ใบยืม New</a>
<a href="status_almostpro.php">รายการสินค้ายอดนิยมออนไลน์สินค้าคงเหลือต่ำกว่ากำหนด</a>
            <!-- </a> -->
<?php if ($_SESSION['name']=='อัจฉรา'){  ?>

<button type="button" class="collapsible">&nbsp;&nbsp; <i class="bi bi-plus"></i> &nbsp;<font class="font_nav_manu_main">รายงานเจน</font></button>
                    
<div class="content_nav">
<a href="search_buyproday1.php" >ดึงข้อมูลยอดขายตามกลุ่มสินค้า (jane)</a>
<a href="search_buyproday2.php" >ดึงข้อมูลยอดขาย E-Commerce (jane)</a>
<a href="search_buyprodaybuy.php">ดึงข้อมูลยอดขายซื้อซ้ำ (jane)</a>	
<a href="search_buyagain.php" >รายงานลูกค้าซื้อซ้ำ AA</a>

</div>

<?php } 	?>

</div>
<?php } ?>
<button type="button" class="collapsible">&nbsp;<i class="fa fa-caret-down"></i> &nbsp;<font class="font_nav_manu_main">Report SOL</font></button>

<div class="content_nav">
<button type="button" class="collapsible">&nbsp;&nbsp; <i class="bi bi-plus"></i> &nbsp;<font class="font_nav_manu_main">รายงานสรุปตามวันที่</font></button>
                    
<div class="content_nav">
<a href="search_report_twodate.php"> &nbsp;&nbsp;&nbsp; แบบเลือกวัน</a>
<a href="search_report_bydate.php"> &nbsp;&nbsp;&nbsp; แบบช่วงเวลา</a>

</div>


<button type="button" class="collapsible">&nbsp;&nbsp; <i class="bi bi-plus"></i> &nbsp;<font class="font_nav_manu_main">รายงานสรุปตามสินค้า</font></button>
                    
<div class="content_nav">
<a href="search_report_byproduct.php"> &nbsp;&nbsp;&nbsp; แบบเลือกวัน</a>
		<a href="search_report_producttwo.php"> &nbsp;&nbsp;&nbsp; แบบช่วงเวลา</a>
		<a href="search_summary_product.php"> &nbsp;&nbsp;&nbsp; แบบเลือกวัน (สรุป)</a>
		<a href="search_summary_productdate.php"> &nbsp;&nbsp;&nbsp; แบบช่วงเวลา (สรุป)</a>
		<a href="search_report_datemar.php"> &nbsp;&nbsp;&nbsp; สรุปรายการสินค้า</a>
		<a href="search_product_tran.php"> &nbsp;&nbsp;&nbsp; การเคลื่อนไหวสินค้า</a>
</div>


<button type="button" class="collapsible">&nbsp;&nbsp; <i class="bi bi-plus"></i> &nbsp;<font class="font_nav_manu_main">รายงานสรุปตามลูกค้า</font></button>
                    
<div class="content_nav">
		<a href="search_bycustomer.php"> &nbsp;&nbsp;&nbsp; จำนวนลูกค้า (เลือกวัน)</a>
		<a href="search_bycustomer_date.php"> &nbsp;&nbsp;&nbsp; จำนวนลูกค้า (ช่วงเวลา)</a>
		<a href="search_summary_channel.php"> &nbsp;&nbsp;&nbsp; จำนวนลูกค้าตามช่องทางการขาย</a>
		<a href="search_member.php"> &nbsp;&nbsp;&nbsp; บัตรสมาชิก</a>
		<a href="search_upcus.php"> &nbsp;&nbsp;&nbsp; การอัพเดทสถานะบัตรสมาชิก</a>
</div>


<button type="button" class="collapsible">&nbsp;&nbsp; <i class="bi bi-plus"></i> &nbsp;<font class="font_nav_manu_main">รายงานการเคลียร์ยืม</font></button>
                    
<div class="content_nav">
		<a href="search_kangclear.php"> &nbsp;&nbsp;&nbsp; ออเดอร์ค้างเคลียร์ยืม</a>
		<a href="search_cleariv.php"> &nbsp;&nbsp;&nbsp; ออเดอร์เคลียร์ยืม</a>
		<a href="search_solno.php"> &nbsp;&nbsp;&nbsp; สรุปแยก SOL และ IV ที่ออกบิลแล้ว</a>
	
</div>

<button type="button" class="collapsible">&nbsp;&nbsp; <i class="bi bi-plus"></i> &nbsp;<font class="font_nav_manu_main">รายงานประวัติการขาย</font></button>
                    
<div class="content_nav">
		<a href="search_reportacc.php"> &nbsp;&nbsp;&nbsp; ยอดขายประจำวัน</a>
		<a href="search_report_customer.php"> &nbsp;&nbsp;&nbsp; ประวัติการขาย แยกตามลูกค้า</a>
		<a href="search_report_allbyproduct.php"> &nbsp;&nbsp;&nbsp; ประวัติการขาย แยกตามสินค้า</a>
</div>
<a href="search_cusmember.php"> &nbsp;&nbsp;&nbsp; ข้อมูลการขายของสมาชิก Allwell</a>

 </div>


<button type="button" class="collapsible">&nbsp;<i class="fa fa-caret-down"></i> &nbsp;<font class="font_nav_manu_main">Report Hospital</font></button>

<div class="content_nav">
<button type="button" class="collapsible">&nbsp;&nbsp; <i class="bi bi-plus"></i> &nbsp;<font class="font_nav_manu_main">รายงาน Sale Record</font></button>
                    
<div class="content_nav">
<a href="search_sale_record.php"> &nbsp;&nbsp;&nbsp; สินค้า (ทั้งหมด)</a>
<a href="search_hosrecpro.php"> &nbsp;&nbsp;&nbsp; สินค้า (โรงพยาบาล)</a>
<a href="search_solrecpro.php"> &nbsp;&nbsp;&nbsp;  สินค้า (ออนไลน์)</a>
<a href="search_sale_record1.php"> &nbsp;&nbsp;&nbsp; เลขที่เอกสาร (ทั้งหมด)</a>
<a href="search_hosrec.php"> &nbsp;&nbsp;&nbsp; เลขที่เอกสาร (โรงพยาบาล)</a>
<a href="search_solrec.php"> &nbsp;&nbsp;&nbsp; เลขที่เอกสาร (ออนไลน์)</a>
<a href="search_sumallevery.php"> &nbsp;&nbsp;&nbsp;  ยอดรวม</a>

</div>

<button type="button" class="collapsible">&nbsp;&nbsp; <i class="bi bi-plus"></i> &nbsp;<font class="font_nav_manu_main">รายงานเคลียร์ยืม</font></button>
                    
<div class="content_nav">
<a href="search_clearbr.php"> &nbsp;&nbsp;&nbsp; สินค้าที่ถูกเคลียร์ยืมแล้ว</a>
<a href="report_clearnobr.php"> &nbsp;&nbsp;&nbsp; สินค้าค้างเคลียร์ยืม</a>
<a href="search_clearnobr.php"> &nbsp;&nbsp;&nbsp; การสรุปการยืมสินค้า</a>
<a href="report_kangbrsc_dm.php" > &nbsp;&nbsp;&nbsp;รายการใบยืมฝากขายคงค้าง แยกตามลูกค้า</a>
</div>

<button type="button" class="collapsible">&nbsp;&nbsp; <i class="bi bi-plus"></i> &nbsp;<font class="font_nav_manu_main">รายงานยอดขายแบบกราฟ</font></button>
                    
<div class="content_nav">

<a href="search_supgraph.php" > &nbsp;&nbsp;&nbsp; แยกเขต</a>
<a href="search_grapsum.php" > &nbsp;&nbsp;&nbsp; ทั้งหมด</a>
</div>
<a href="search_jong_order.php">&nbsp;&nbsp; รายงานสินค้ารอออก ORDER</a>
<?php  if ($_SESSION['name']=='พัชร์ชนัญ') { ?>
		<a href="search_report_umim.php">&nbsp;&nbsp; รายการพี่อิ๋ม</a>
		<?php } ?>


</div>


<button type="button" class="collapsible">&nbsp;<i class="fa fa-caret-down"></i> &nbsp;<font class="font_nav_manu_main">Report Stock</font></button>

<div class="content_nav">
<a href="search_product_tran.php"> &nbsp;&nbsp; รายงานการเคลื่อนไหวสินค้า</a>
<a href="search_jong_order.php"> &nbsp;&nbsp; รายงานสินค้ารอออก ORDER</a>
<?php if ($_SESSION['name']=='ชลชินี' or $_SESSION['name']=='อัจฉรา') { ?>
<a href="search_logall.php"> &nbsp;&nbsp; รายการตรวจสอบการแก้ไขสินค้า</a>
<?php } ?>	
</div>

	
<button type="button" class="collapsible">&nbsp;<i class="fa fa-caret-down"></i> &nbsp;<font class="font_nav_manu_main">Report Etax Invoice</font></button>

<div class="content_nav">
<button type="button" class="collapsible">&nbsp;&nbsp; <i class="bi bi-plus"></i> &nbsp;<font class="font_nav_manu_main">ดึงข้อมูล ใบกำกับภาษี/ใบเสร็จ</font></button>
                    
<div class="content_nav">
<a href="search_taxinvoice.php"> &nbsp;&nbsp;&nbsp; ดึงข้อมูล ไฟล์ .txt (Home Care)</a>
<a href="search_etax_ecomer.php"> &nbsp;&nbsp;&nbsp; ดึงข้อมูล ไฟล์ .pdf (Home Care)</a>
	
<a href="search_taxinvoice1.php"> &nbsp;&nbsp;&nbsp; ดึงข้อมูล ไฟล์ .txt (Hospital)</a>
<a href="search_etax_hos.php"> &nbsp;&nbsp;&nbsp; ดึงข้อมูล ไฟล์ .pdf (Hospital)</a>

<a href="search_taxinvoice_txt.php"> &nbsp;&nbsp;&nbsp; ดึงข้อมูล ไฟล์ .txt (Home Care) ทดแทน</a>
<a href="search_etax_ecomer1.php"> &nbsp;&nbsp;&nbsp; ดึงข้อมูล ไฟล์ .pdf (Home Care)ทดแทน</a>
	
<a href="search_taxinvoice_txt1.php"> &nbsp;&nbsp;&nbsp; ดึงข้อมูล ไฟล์ .txt (Hospital) ทดแทน</a>
<a href="search_etax_hos1.php"> &nbsp;&nbsp;&nbsp; ดึงข้อมูล ไฟล์ .pdf (Hospital) ทดแทน</a>
	
</div>

<button type="button" class="collapsible">&nbsp;&nbsp; <i class="bi bi-plus"></i> &nbsp;<font class="font_nav_manu_main">ดึงข้อมูล ใบรับคืนสินค้า/ใบลดหนี้</font></button>
                    
<div class="content_nav">
<a href="search_creditnote.php"> &nbsp;&nbsp;&nbsp; ดึงข้อมูล ไฟล์ .txt</a>
<a href="search_creditfrom.php"> &nbsp;&nbsp;&nbsp; ดึงข้อมูล ไฟล์ .pdf</a>
	
<a href="search_creditnote1.php"> &nbsp;&nbsp;&nbsp; ดึงข้อมูล ไฟล์ .txt ทดแทน</a>
<a href="search_creditfrom1.php"> &nbsp;&nbsp;&nbsp; ดึงข้อมูล ไฟล์ .pdf ทดแทน</a>
	
</div>
	
</div>

	
<button type="button" class="collapsible">&nbsp;<i class="fa fa-caret-down"></i> &nbsp;<font class="font_nav_manu_main">Report แบบสอบถาม</font></button>

<div class="content_nav">
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
	
	
<a href="veiw_bussend.php" > &nbsp;&nbsp;&nbsp;ตารางรถใหญ่</a>	
	
<?php if($_SESSION['name']=='ปิยะ') { ?>
		<a href="status_almostpro.php">รายการสินค้ายอดนิยมออนไลน์สินค้าคงเหลือต่ำกว่ากำหนด</a>
		<?php } ?>
</div>



   <li class="manu_item1_2 w3-right">
  ยอดสินค้า  &nbsp;
      <i class="fa fa-caret-down"></i>
   
    <div class="dropdown-content w3-right">
		<a href="https://stock.allwellcenter.com/report_herohomecare.php?name=<?php echo $_SESSION['name']; ?>" target="_blank">รายงาน Hero Product For Home Care</a>
		<a href="https://stock.allwellcenter.com/report_herohos.php?name=<?php echo $_SESSION['name']; ?>" target="_blank">รายงาน Hero Product For Hospital</a>
        <a href="https://stock.allwellcenter.com/report_hotpro1.php?name=<?php echo $_SESSION['name']; ?>">รายงานสินค้าคงเหลือ ยอดนิยม เตียงและสินค้าประกอบ</a>
		<a href="https://stock.allwellcenter.com/report_hotpro2.php?name=<?php echo $_SESSION['name']; ?>">รายงานสินค้าคงเหลือ ยอดนิยม สินค้า Online</a>
		<a href="https://stock.allwellcenter.com/report_hotpro3.php?name=<?php echo $_SESSION['name']; ?>">รายงานสินค้าคงเหลือ ยอดนิยม สินค้าทั่วไป</a>
		<a href="https://stock.allwellcenter.com/report_hotphhr.php?name=<?php echo $_SESSION['name']; ?>">รายงานสินค้าคงเหลือ หีบห่อ</a>
		<!--a href="https://stock.allwellcenter.com/report_hotpro4.php?name=<?php echo $_SESSION['name']; ?>">รายงานสินค้าคงเหลือ ยอดนิยมสินค้า Allied</a-->
		<a href="search_productall.php">รายงานสินค้าคงเหลือแบบเลือกรายการ</a>
		<a href="https://stock.allwellcenter.com/report_prduct_online.php?name=<?php echo $_SESSION['name']; ?>" target="_blank">รายงานสินค้าใกล้หมด (ออนไลน์)</a>
		<a href="https://stock.allwellcenter.com/report_prduct_bed.php?name=<?php echo $_SESSION['name']; ?>" target="_blank">รายงานสินค้าใกล้หมด (เตียงไฟฟ้า)</a>
		<a href="https://stock.allwellcenter.com/report_prduct_online1.php?name=<?php echo $_SESSION['name']; ?>" target="_blank">รายงานสินค้าคงเหลือน้อยกว่าจุดสั่งซื้อ (ออนไลน์)</a>
		<a href="https://stock.allwellcenter.com/report_prduct_bed1.php?name=<?php echo $_SESSION['name']; ?>" target="_blank">รายงานสินค้าคงเหลือน้อยกว่าจุดสั่งซื้อ (เตียงไฟฟ้า)</a>
    </div>
  </li>

<?php if ($_SESSION['name']=='ชลชินี' or $_SESSION['name']=='อัจฉรา'  or $_SESSION['name']=='สมบัติ') { ?>
<li class="manu_item1_2 w3-right">
  อนุมัติเอกสาร  &nbsp; 
      <i class="fa fa-caret-down"></i>
   
    <div class="dropdown-content w3-right">
		<a href="status_adminprice.php">อนุมัติออเดอร์สินค้าราคาต่ำกว่ากำหนด</a>
		<a href="status_approvecm.php" >อนุมัติใบสั่งขายฝากขาย</a>
        <a href="status_approvebrsup.php" >อนุมัติใบยืม (BRNP)</a>
		<a href="status_appbrbooth.php" >อนุมัติใบยืมออกบูธ (BRNP)</a>
		<a href="status_appcmbrsc.php" >อนุมัติใบยืมฝากขาย</a>
		<a href="status_smpapprove.php" >อนุมัติใบเบิกสินค้า (SMP)</a>
		<?php if ($_SESSION['name']=='ชลชินี' or $_SESSION['name']=='อัจฉรา'){ ?>
		<a href="status_sample_approve.php" >อนุมัติใบเบิกสินค้า (SMP) [สิทธิ์พี่จืด]</a>
		<?php } ?>
		<a href="status_appspr_cm.php" >อนุมัติใบเบิกเครื่องและอะไหล่ (SPR)</a>
		<a href="status_dmbreg_app.php" >อนุมัติใบขอเบิกอะไหล่สินค้าขาย (BREG)</a>
		<a href="status_apprental.php" >อนุมัติใบสั่งเช่า</a>	
		<a href="status_credit_cmapprove.php" >อนุมัติใบสั่งลดหนี้</a>
		<a href="status_app_credit.php" >ข้อมูลวงเงินลูกค้า (รออนุมัติ)</a>
		<a href="status_approve_sol.php" >อนุมัติเอกสารโชว์รูม</a>
		<a href="status_cmvat.php" >อนุมัติใบกำกับภาษี</a>
		<a href="status_appckkst.php" >อนุมัติรายการตรวจเช็คใบยืม</a>
		<a href="status_appexpro.php" >อนุมัติใบเบิกเป็นสินค้าสาธิต</a>
		<a href="status_apprefst.php" >อนุมัติขอปรับปรุงยอดสต็อก</a>
    </div>
  </li>
<?php }else if ($_SESSION['name']=='ปิยะ') { ?> 
<li class="manu_item1_2 w3-right">
  อนุมัติเอกสาร  &nbsp; 
      <i class="fa fa-caret-down"></i>
   
    <div class="dropdown-content w3-right">
     <a href="status_approvebrsup.php" >อนุมัติใบยืม (BRNP)</a>
	 <a href="status_supvat.php" >อนุมัติใบกำกับภาษี</a>
	<a href="status_approve_no.php" >อนุมัติใบแจ้งสินค้าไม่สมบูรณ์</a>	
    </div>
  </li>
<?php }else if ($_SESSION['name']=='พัชร์ชนัญ') { ?> 
<li class="manu_item1_2 w3-right">
  อนุมัติเอกสาร  &nbsp; 
      <i class="fa fa-caret-down"></i>
   
    <div class="dropdown-content w3-right">
    <a href="status_apprefst.php" >อนุมัติขอปรับปรุงยอดสต็อก</a>
    </div>
  </li>	
<?php } ?>

<li class="manu_item1_2 w3-right">
  รายการเอกสาร  &nbsp; 
      <i class="fa fa-caret-down"></i>
   
    <div class="dropdown-content w3-right">

	<a href="status_deposit.php" >ใบรับเงินมัดจำ</a>
	<a href="status_mkchange_glu.php" >รายการออเดอร์เครื่อง G-426</a>
	<a href="status_mkchange_glucos.php" >รายการออเดอร์เครื่อง GLUCOSURE</a>	
	<a href="register_chother_blood.php" >ลงทะเบียนลูกค้าแลกเครื่องวัดน้ำตาล</a>   
<a href="status_bloodch.php" >รายการลูกค้าแลกเครื่องวัดน้ำตาลยี้ห้ออื่น</a>  
	

<button type="button" class="collapsible">&nbsp;<i class="fa fa-caret-down"></i> &nbsp;<font class="font_nav_manu_main">ใบสั่งขาย</font></button>
                   
<div class="content_nav">
<button type="button" class="collapsible">&nbsp;&nbsp; <i class="bi bi-plus"></i> &nbsp;<font class="font_nav_manu_main">Online</font></button>
                    
<div class="content_nav">
<a href="status_allwell.php"> &nbsp;&nbsp;&nbsp; Status</a> 
 <a href="status_admin.php"> &nbsp;&nbsp;&nbsp; Status Adm</a>
<a href="status_admin_bed.php"> &nbsp;&nbsp;&nbsp; Status เตียง</a>	 
<a href="status_allprice.php">Status ออเดอร์สินค้าราคาต่ำกว่ากำหนด</a>
<a href="status_cancel_ecom.php">Status Order Shopee ยกเลิก</a>	
</div>
	  
<button type="button" class="collapsible">&nbsp;&nbsp; <i class="bi bi-plus"></i> &nbsp;<font class="font_nav_manu_main">Hospital</font></button>
                    
<div class="content_nav">
<a href="status_suphos1.php" > &nbsp;&nbsp;&nbsp; Status ใบสั่งขาย (SO)</a>
<a href="status_adminhos1.php" > &nbsp;&nbsp;&nbsp; Status (SO)ค้างเลขที่ IV</a>
<a href="status_adminhos.php"> &nbsp;&nbsp;&nbsp; สถานะ (SO)</a>
<a href="status_admin_jong.php" > &nbsp;&nbsp;&nbsp; Status (SO) ใบฝาก</a>
</div></div>


<button type="button" class="collapsible">&nbsp;<i class="fa fa-caret-down"></i> &nbsp;<font class="font_nav_manu_main">ใบยืม</font></button>
                   
<div class="content_nav">
<button type="button" class="collapsible">&nbsp;&nbsp; <i class="bi bi-plus"></i> &nbsp;<font class="font_nav_manu_main">Online</font></button>
                    
<div class="content_nav">
<a href="status_allwell.php"> &nbsp;&nbsp;&nbsp; Status</a> 
<a href="search_brkangclear.php"> &nbsp;&nbsp;&nbsp; รายงานใบยืมค้างเคลียร์ Showroom</a>
<a href="status_clearst_allwell.php"> &nbsp;&nbsp;&nbsp; รายการใบยืมค้างเคลียร์โชว์รูม Stock</a>
<a href="status_clear_admin.php"> &nbsp;&nbsp;&nbsp; Status ใบยืมค้างเคลียร์ Adm</a>
	 
</div>
	  
<button type="button" class="collapsible">&nbsp;&nbsp; <i class="bi bi-plus"></i> &nbsp;<font class="font_nav_manu_main">Hospital</font></button>
                    
<div class="content_nav">
	<a href="status_supbrhos1.php" > &nbsp;&nbsp;&nbsp; ใบยืม (BR)</a>
	<a href="report_brkangbysup.php" > &nbsp;&nbsp;&nbsp; ตรวจเช็คใบยืมค้างเคลียร์ (stock)</a>
	<a href="status_brsuparea.php" > &nbsp;&nbsp;&nbsp; รายการตรวจเช็คใบยืม (ทั้งหมด)</a>
	<a href="status_adminbrhos.php"> &nbsp;&nbsp;&nbsp;สถานะ (BR)</a>
	<a href="status_clearbr_st.php" > &nbsp;&nbsp;&nbsp;Status ใบยืมค้างเคลียร์ Stock</a>
	<a href="status_clearbr_adm.php" > &nbsp;&nbsp;&nbsp;Status ใบยืมค้างเคลียร์ Adm</a>
	
</div></div>


<button type="button" class="collapsible">&nbsp;<i class="fa fa-caret-down"></i> &nbsp;<font class="font_nav_manu_main">ใบเบิกสินค้า</font></button>
                    
<div class="content_nav">
<?php if ($_SESSION['name']=='สมบัติ') { ?> 
		
	<a href="status_samplepm.php" > &nbsp;&nbsp;&nbsp; รายการใบเบิกสินค้า (สนับสนุนการขาย)</a>
	<a href="status_adminmp.php" > &nbsp;&nbsp;&nbsp; รายการเบิกสินค้าทั้งหมด</a>
		
		<?php }else if ($_SESSION['name']=='ชลชินี') { ?> 	
		
	<a href="status_samplecm.php" > &nbsp;&nbsp;&nbsp; รายการใบเบิกสินค้า (สนับสนุนการขาย)</a>
	<a href="status_adminmp.php" > &nbsp;&nbsp;&nbsp; รายการเบิกสินค้าทั้งหมด</a>
		<!--a href="status_smpapprove.php" >อนุมัติใบเบิกสินค้า ในส่วนของผู้บริหาร</a-->
		<?php }else{ ?>
		<a href="status_adminmp.php" > &nbsp;&nbsp;&nbsp;  รายการเบิกสินค้า Admin</a>
		<?php } ?>
</div>

 <a href="status_adminbrsc.php" >Status ใบฝากขาย</a>
<a href="status_adminchange.php" >Status ใบแลกเปลี่ยน</a>
<?php if ($_SESSION['name']=='ชลชินี' or $_SESSION['name']=='สมบัติ') { ?> 
<a href="status_spr.php" >รายการใบเบิกเครื่องและอะไหล่</a>
<?php } ?>

<button type="button" class="collapsible">&nbsp;<i class="fa fa-caret-down"></i> &nbsp;<font class="font_nav_manu_main">ใบสั่งเช่า</font></button>


<div class="content_nav">
	<a href="status_suprental.php" >Status ใบสั่งเช่า(Sup)</a>
	<a href="status_adminrental.php" >Status ใบสั่งเช่า(Admin)</a>	
	<a href="status_kangrental.php" >Status ใบสั่งเช่ารอเปิดใบสั่งขาย</a>
  <?php if ($_SESSION['name']=='เฉลิมศักดิ์' ) { ?> 
  <a href="rental_200_main.php" >Status ใบสั่งเช่า(Md)</a>	
  <?php } ?>
  <a href="status_adminrental_iv.php" >Status ใบสั่งเช่าออกใบสั่งขาย</a>
</div>		
		
	<button type="button" class="collapsible">&nbsp;<i class="fa fa-caret-down"></i> &nbsp;<font class="font_nav_manu_main">ใบลดหนี้</font></button>
                    
<div class="content_nav">
<a href="status_credit_adm.php" > &nbsp;&nbsp;&nbsp; รายการใบสั่งลดหนี้</a>
<a href="status_credit_admall.php"> &nbsp;&nbsp;&nbsp; รายการใบสั่งลดหนี้ทั้งหมด</a>
</div>

	<button type="button" class="collapsible">&nbsp;<i class="fa fa-caret-down"></i> &nbsp;<font class="font_nav_manu_main">ค้นหาสินค้าผ่าน SN</font></button>
                    
<div class="content_nav">
<a href="search_snonline.php" > &nbsp;&nbsp;&nbsp;รายการ Sale Online</a>
<a href="search_snsalehos.php" > &nbsp;&nbsp;&nbsp;รายการใบสั่งขาย</a>
<a href="search_snsalehosbr.php" > &nbsp;&nbsp;&nbsp;รายการใบยืม</a>
<a href="search_snsmp.php" > &nbsp;&nbsp;&nbsp;รายการใบเบิก SMP</a>
</div>

<a href="status_etaxcustomer.php" >ข้อมูลลูกค้าขอใบกำกับภาษี</a>	

    </div>
  </li>


<li class="manu_item1_2 w3-right">  ออกเอกสาร  &nbsp;       <i class="fa fa-caret-down"></i> 
<div class="dropdown-content w3-right">
<a href="register_deposit.php"> &nbsp; ใบรับเงินมัดจำ</a>

<button type="button" class="collapsible">&nbsp;<i class="fa fa-caret-down"></i> &nbsp;<font class="font_nav_manu_main">ใบสั่งขาย</font></button>
                   
<div class="content_nav">
<a href="main_allwell_so.php"> &nbsp;&nbsp;&nbsp; Online</a>
<a href="main_suphos_so.php" > &nbsp;&nbsp;&nbsp; Hospital</a>

</div>

<button type="button" class="collapsible">&nbsp;<i class="fa fa-caret-down"></i> &nbsp;<font class="font_nav_manu_main">ใบยืม</font></button>
                   
<div class="content_nav">
 <a href="main_allwell_br.php"> &nbsp;&nbsp;&nbsp; Online</a>
 <a href="main_suphos_br.php" > &nbsp;&nbsp;&nbsp; Hospital</a>

</div>
	
<button type="button" class="collapsible">&nbsp;<i class="fa fa-caret-down"></i> &nbsp;<font class="font_nav_manu_main">ใบเบิกสินค้า</font></button>
                   
<div class="content_nav">
<?php if ($_SESSION['name']=='สมบัติ') { ?> 
<a href="main_cm_smp.php" >- ใบเบิกสินค้า (สนับสนุนการขาย)</a>
<?php }else if ($_SESSION['name']=='ชลชินี') { ?> 	
<a href="main_cm_smp.php" >- ใบเบิกสินค้า (สนับสนุนการขาย)</a>
		<?php }else{ ?>
<a href="main_admin_smp.php" >- ใบเบิกสินค้า (สนับสนุนการขาย)</a>
			 <?php } ?>
<a href="status_ecomsmp.php" >- Status Ecommerce</a>	
</div>	

	
	
	
<a href="main_sup_brsc.php" >ใบยืมฝากขาย</a>	
<a href="main_suphos_change.php" >ใบแลกเปลี่ยนสินค้า</a>
<a href="main_receivepro.php" >ใบรับสินค้า</a>
<a href="register_creditnot_create.php" >ใบสั่งลดหนี้</a>
<a href="main_sup_rental.php" >ใบสั่งเช่า</a>	
<?php if ($_SESSION['name']=='อัจฉรา') { ?> 

<button type="button" class="collapsible">&nbsp;<i class="fa fa-caret-down"></i> &nbsp;<font class="font_nav_manu_main">ใบสั่งเช่า</font></button>
                   
<div class="content_nav">
<a href="main_sale_rental.php" >ใบสั่งเช่า (sale)</a>
	<a href="status_salerental.php" >Status ใบสั่งเช่า(sale)</a>
	<a href="main_allwell_rental.php" >ใบสั่งเช่า (โชว์รูม)</a>
	<a href="status_allwellrental.php" >Status ใบสั่งเช่า(โชว์รูม)</a>
	<a href="main_sup_rental.php" >ใบสั่งเช่า (Sup)</a>
	<a href="status_suprental.php" >Status ใบสั่งเช่า(Sup)</a>
	<a href="status_apprental.php" >Status ใบสั่งเช่า(อนุมัติ)</a>	
	<a href="status_adminrental.php" >Status ใบสั่งเช่า(Admin)</a>	 
</div>

<?php } ?>

<button type="button" class="collapsible">&nbsp;<i class="fa fa-caret-down"></i> &nbsp;<font class="font_nav_manu_main">E-Commerc</font></button>
                   
<div class="content_nav">
<button type="button" class="collapsible">&nbsp;&nbsp; <i class="bi bi-plus"></i> &nbsp;<font class="font_nav_manu_main">ดึงข้อมูล</font></button>
                    
<div class="content_nav">
<a href="search_apilazada.php"> &nbsp;&nbsp;&nbsp; Lazada</a> 
	  <a href="upload_shopee.php"> &nbsp;&nbsp;&nbsp; Shopee1</a>
	  <a href="upload_shopee1.php"> &nbsp;&nbsp;&nbsp; Shopee2</a>
	  <a href="upload_jdcental.php"> &nbsp;&nbsp;&nbsp; JD central</a>
	  <a href="upload_ctonline.php"> &nbsp;&nbsp;&nbsp; Central Online</a>
	  <a href="upload_officemate.php"> &nbsp;&nbsp;&nbsp; Officemate</a>
	  <a href="upload_nocnoc.php"> &nbsp;&nbsp;&nbsp; Noc Noc</a>
	  <a href="upload_homepro.php"> &nbsp;&nbsp;&nbsp; Homepro</a>
	<a href="upload_homepro1.php"> &nbsp;&nbsp;&nbsp; Homepro1</a>
	  <a href="upload_tiktok.php"> &nbsp;&nbsp;&nbsp; Tiktok</a>
	  <a href="upload_ktc.php"> &nbsp;&nbsp;&nbsp; KTC Ushop Web</a>
	  <a href="upload_ktcnew.php"> &nbsp;&nbsp;&nbsp; KTC Ushop Line & Face</a>
	  <a href="upload_ktcmobile.php">KTC Ushop App</a>
	<a href="upload_bd.php">BeDee</a>
	 <a href="upload_amaze.php">Amaze</a>	
</div>
	  
<button type="button" class="collapsible">&nbsp;&nbsp; <i class="bi bi-plus"></i> &nbsp;<font class="font_nav_manu_main">Upload ข้อมุล</font></button>
                    
<div class="content_nav">
<a href="upload_discount.php"> &nbsp;&nbsp;&nbsp; รายการส่วนลด</a>
<a href="upload_tran.php" > &nbsp;&nbsp;&nbsp; Upload ค่าจัดส่ง ร้าน 99</a>
<a href="search_productpomo.php"> &nbsp;&nbsp;&nbsp; รายการสินค้าของแถมโปรโมชั่น</a>
<a href="upload_tranpro.php"> &nbsp;&nbsp;&nbsp; Update ค่าส่วนต่างสินค้า</a>
<a href="upload_99.php" > &nbsp;&nbsp;&nbsp; Upload ข้อมูลร้าน 99</a>
<a href="upload_solnb.php"> &nbsp;&nbsp;&nbsp; Upload SOL NBM</a>
<a href="Upload_cleariv.php"> &nbsp;&nbsp;&nbsp; รายการเคลียร์ใบยืม</a>
<a href="up_cleariv_no.php"> &nbsp;&nbsp;&nbsp; รายการเคลียร์ใบยืมตามรายการสินค้า</a>
	
<a href="upload_smptiktok.php"> &nbsp;&nbsp;&nbsp; Update เลขขนส่ง SMP</a>	
</div>

	  
	  
	  
	  

</div>



     
    </div>
  </li>


<li class="manu_item1_2">  รายการรับเรื่อง  &nbsp;<i class="fa fa-caret-down"></i>
<div class="dropdown-content">

<button type="button" class="collapsible">&nbsp;<i class="fa fa-caret-down"></i> &nbsp;<font class="font_nav_manu_main">ในส่วนของเซลล์</font></button>
                   
<div class="content_nav">
<a href="register_story.php" > &nbsp;&nbsp;&nbsp; การรับเรื่องจากลูกค้า</a>
<a href="status_storykang.php" > &nbsp;&nbsp;&nbsp; รายการรับเรื่องจากลูกค้า (ค้าง)</a>
<a href="status_storyall.php" > &nbsp;&nbsp;&nbsp; รายการรับเรื่องจากลูกค้า (ปิดงานแล้ว)</a>

</div>

<button type="button" class="collapsible">&nbsp;<i class="fa fa-caret-down"></i> &nbsp;<font class="font_nav_manu_main">ในส่วนของช่าง</font></button>
                   
<div class="content_nav">
<a href="register_cuseng.php" > &nbsp;&nbsp;&nbsp;การรับเรื่องลูกค้าของช่าง</a>
<a href="status_cusopen.php" > &nbsp;&nbsp;&nbsp;รายการรับเรื่องลูกค้าช่าง</a>	

</div>

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