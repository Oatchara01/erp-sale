<link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Mitr:wght@300;400;500&display=swap" rel="stylesheet">

<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<script src="https://cdn.lordicon.com/xdjxvujz.js"></script>

<link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css"
>


<?php

function encryptData($data, $secretKey = 'mySecretKey123456789')
{
    $key = hash(
        'sha256',
        $secretKey,
        true
    );

    $iv = substr(
        $key,
        0,
        16
    );

    $cipher_raw = openssl_encrypt(
        $data,
        'AES-256-CBC',
        $key,
        OPENSSL_RAW_DATA,
        $iv
    );

    return rawurlencode(
        base64_encode($cipher_raw)
    );
}


$em_id = isset($_SESSION['emid'])
    ? $_SESSION['emid']
    : '';

$token = encryptData(
    $em_id,
    'mySecretKey123456789'
);

?>


<div id="sidebar">


    <!-- ==================================================
         MOBILE TOGGLE
    =================================================== -->

    <button
        type="button"
        class="sidebar-mobile-toggle"
    >
        &#9776;
    </button>



    <!-- ==================================================
         HEADER
    =================================================== -->

    <div class="sidebar-header">

        <a
            href="dashboard_allwell.php"
            class="sidebar-logo"
        >

            <img
                width="90"
                height="24"
                src="img/allwellsale_logo.png"
                alt="logo"
            >

            <span>ERP IT</span>

        </a>


        <button
            type="button"
            class="sidebar-toggle-btn"
        >
            <i class="fa fa-angle-left"></i>
        </button>

    </div>



    <!-- ==================================================
         NAVIGATION
    =================================================== -->

    <nav class="sidebar-nav">


        <!-- ==================================================
             HOME
        =================================================== -->

        <a
            href="dashboard_allwell.php"
            class="sidebar-group-btn sidebar-home-link"
        >

            <span class="sidebar-icon">

                <img
                    src="img/icons/menu_home.svg"
                    alt="หน้าหลัก"
                    class="sidebar-menu-icon"
                >

            </span>


            <span class="sidebar-label">
                หน้าหลัก
            </span>

        </a>



        <!-- ==================================================
             เอกสารขาย
        =================================================== -->

        <div class="sidebar-group">


            <button
                type="button"
                class="sidebar-group-btn"
                onclick="toggleSidebarMain(this);"
            >

                <span class="sidebar-icon">

                    <img
                        src="img/icons/menu_doc.svg"
                        alt="เอกสารขาย"
                        class="sidebar-menu-icon"
                    >

                </span>


                <span class="sidebar-label">
                    เอกสารขาย
                </span>


                <span class="sidebar-caret" aria-hidden="true">
                    <img src="img/icons/menu_arrow_down.svg?v=20261002b" alt="" class="sidebar-arrow-down">
                    <img src="img/icons/menu_arrow_up.svg?v=20261002b" alt="" class="sidebar-arrow-up">
                </span>

            </button>



            <div class="sidebar-submenu">


                <?php
                if (
                    in_array(
                        $_SESSION['type_login'],
                        ['sol', 'It', 'owner']
                    )
                    ||
                    $_SESSION['code'] == 'SS3'
                ) {
                ?>

                    <a href="status_qou.php">
                        ใบเสนอราคา
                    </a>

                    <a href="status_deposit.php">
                        ใบรับเงินมัดจำ
                    </a>

                <?php
                }
                ?>


                <a href="status_supjong.php">
                    ใบจองสินค้า
                </a>



                <!-- ==========================================
                     ใบสั่งขาย
                =========================================== -->

                <div class="sidebar-subgroup">


                    <button
                        type="button"
                        class="sidebar-subgroup-btn"
                        onclick="toggleSidebarSub(this, event);"
                    >

                        <span class="sidebar-label">
                            ใบสั่งขาย
                        </span>

                        <span class="sidebar-caret" aria-hidden="true">
                    <img src="img/icons/menu_arrow_down.svg?v=20261002b" alt="" class="sidebar-arrow-down">
                    <img src="img/icons/menu_arrow_up.svg?v=20261002b" alt="" class="sidebar-arrow-up">
                </span>

                    </button>



                    <div class="sidebar-submenu">


                        <?php
                        if (
                            in_array(
                                $_SESSION['type_login'],
                                [
                                    'mk2',
                                    'It',
                                    'owner',
                                    'sup_mk2',
                                    'Admin'
                                ]
                            )
                        ) {
                        ?>


                            <!-- =================================
                                 E-COMMERCE
                            ================================== -->

                            <div class="sidebar-subgroup">


                                <button
                                    type="button"
                                    class="sidebar-subgroup-btn"
                                    onclick="toggleSidebarSub(this, event);"
                                >

                                    <span class="sidebar-label">
                                        E-Commerce
                                    </span>

                                    <span class="sidebar-caret" aria-hidden="true">
                    <img src="img/icons/menu_arrow_down.svg?v=20261002b" alt="" class="sidebar-arrow-down">
                    <img src="img/icons/menu_arrow_up.svg?v=20261002b" alt="" class="sidebar-arrow-up">
                </span>

                                </button>



                                <div class="sidebar-submenu">


                                    <a href="status_admin.php">
                                        รายการออเดอร์
                                    </a>


                                    <?php
                                    if (
                                        in_array(
                                            $_SESSION['type_login'],
                                            [
                                                'It',
                                                'owner',
                                                'Admin'
                                            ]
                                        )
                                    ) {
                                    ?>

                                        <a href="status_allprice.php">
                                            รายการออเดอร์สินค้าราคาต่ำกว่ากำหนด
                                        </a>


                                        <a href="status_cancel_ecom.php">
                                            รายการออเดอร์ (รอยกเลิก)
                                        </a>

                                    <?php
                                    }
                                    ?>


                                </div>

                            </div>

                        <?php
                        }
                        ?>


                        <a href="status_adminhos.php">
                            รายการใบสั่งขาย
                        </a>


                    </div>

                </div>



                <!-- ==========================================
                     ใบยืม
                =========================================== -->

                <div class="sidebar-subgroup">


                    <button
                        type="button"
                        class="sidebar-subgroup-btn"
                        onclick="toggleSidebarSub(this, event);"
                    >

                        <span class="sidebar-label">
                            ใบยืม
                        </span>

                        <span class="sidebar-caret" aria-hidden="true">
                    <img src="img/icons/menu_arrow_down.svg?v=20261002b" alt="" class="sidebar-arrow-down">
                    <img src="img/icons/menu_arrow_up.svg?v=20261002b" alt="" class="sidebar-arrow-up">
                </span>

                    </button>



                    <div class="sidebar-submenu">


                        <a href="status_supbrhos.php">
                            รายการใบยืมสินค้า
                        </a>


                        <a href="status_adminbrsc.php">
                            รายการใบยืมฝากขาย
                        </a>


                        <?php
                        if (
                            in_array(
                                $_SESSION['type_login'],
                                [
                                    'Engineer',
                                    'It',
                                    'owner',
                                    'Sup_en'
                                ]
                            )
                        ) {
                        ?>


                            <a href="status_brhos_breq.php">
                                ใบยืมตรวจเช็คสินค้า (BREQ)
                            </a>


                            <a href="status_engbreg.php">
                                รายการใบขอเบิกอะไหล่จากสินค้าขาย
                            </a>


                        <?php
                        }
                        ?>


                    </div>

                </div>



                <a href="status_suprental.php">
                    ใบสั่งเช่า
                </a>


                <a href="status_samplesup.php">
                    ใบเบิกสินค้า SMP
                </a>


                <?php
                if (
                    in_array(
                        $_SESSION['type_login'],
                        [
                            'Engineer',
                            'It',
                            'owner',
                            'Sup_en'
                        ]
                    )
                ) {
                ?>

                    <a href="status_spr.php">
                        ใบเบิกสินค้า SPR
                    </a>

                <?php
                }
                ?>


                <a href="status_adminchange.php">
                    ใบแลกเปลี่ยนสินค้า
                </a>


                <a href="status_credit_admall.php">
                    ใบลดหนี้
                </a>


                <?php
                if (
                    in_array(
                        $_SESSION['type_login'],
                        [
                            'It',
                            'owner',
                            'Admin'
                        ]
                    )
                ) {
                ?>

                    <a href="status_receivepro_adm.php">
                        ใบส่งสินค้า
                    </a>

                <?php
                }
                ?>


                <a href="status_adminpo.php">
                    ใบสั่งซื้อ (PO)
                </a>

                <a href="status_receive_suppro.php">
                    ใบคืนสินค้า
                </a>


            </div>

        </div>



        <!-- ==================================================
             อนุมัติเอกสาร
        =================================================== -->

		 <?php
                        if (
                            in_array(
                                $_SESSION['type_login'],
                                [
                                    'Sup_Sale',
                                    'It',
                                    'owner',
                                    'sup_mk2',
                                    'Sup_en'
                                ]
                            )
                        ) {
                        ?>
		
        <div class="sidebar-group">


            <button
                type="button"
                class="sidebar-group-btn"
                onclick="toggleSidebarMain(this);"
            >

                <span class="sidebar-icon">

                    <img
                        src="img/icons/menu_app.svg"
                        alt="อนุมัติเอกสาร"
                        class="sidebar-menu-icon"
                    >

                </span>


                <span class="sidebar-label">
                    อนุมัติเอกสาร
                </span>


                <span class="sidebar-caret" aria-hidden="true">
                    <img src="img/icons/menu_arrow_down.svg?v=20261002b" alt="" class="sidebar-arrow-down">
                    <img src="img/icons/menu_arrow_up.svg?v=20261002b" alt="" class="sidebar-arrow-up">
                </span>

            </button>



            <div class="sidebar-submenu">


                <?php
                if (
                    in_array(
                        $_SESSION['type_login'],
                        [
                            'It',
                            'owner'
                        ]
                    )
                    ||
                    $_SESSION['code'] == 'SS3'
                ) {
                ?>

                    <a href="status_appqou.php">
                        ใบเสนอราคา
                    </a>

                <?php
                }
                ?>


                <a href="status_supjongapp.php">
                    ใบจองสินค้า
                </a>



                <!-- ==========================================
                     ใบสั่งขาย
                =========================================== -->

                <div class="sidebar-subgroup">


                    <button
                        type="button"
                        class="sidebar-subgroup-btn"
                        onclick="toggleSidebarSub(this, event);"
                    >

                        <span class="sidebar-label">
                            ใบสั่งขาย
                        </span>

                        <span class="sidebar-caret" aria-hidden="true">
                    <img src="img/icons/menu_arrow_down.svg?v=20261002b" alt="" class="sidebar-arrow-down">
                    <img src="img/icons/menu_arrow_up.svg?v=20261002b" alt="" class="sidebar-arrow-up">
                </span>

                    </button>



                    <div class="sidebar-submenu">


                        <?php
                        if (
                            in_array(
                                $_SESSION['type_login'],
                                [
                                    'It',
                                    'owner',
                                    'sup_mk2',
                                    'Admin'
                                ]
                            )
                        ) {
                        ?>

                            <a href="status_allprice.php">
                                ออเดอร์สินค้าราคาต่ำกว่ากำหนด
                            </a>

                        <?php
                        }
                        ?>


                        <a href="status_approvesup.php">
                            ใบสั่งขาย
                        </a>


                        <?php
                        if (
                            in_array(
                                $_SESSION['type_login'],
                                [
                                    'It',
                                    'owner'
                                ]
                            )
                        ) {
                        ?>

                            <a href="status_approvecm.php">
                                ใบสั่งขายฝากขาย
                            </a>

                        <?php
                        }
                        ?>


                    </div>

                </div>



                <!-- ==========================================
                     ใบยืม
                =========================================== -->

                <div class="sidebar-subgroup">


                    <button
                        type="button"
                        class="sidebar-subgroup-btn"
                        onclick="toggleSidebarSub(this, event);"
                    >

                        <span class="sidebar-label">
                            ใบยืม
                        </span>

                        <span class="sidebar-caret" aria-hidden="true">
                    <img src="img/icons/menu_arrow_down.svg?v=20261002b" alt="" class="sidebar-arrow-down">
                    <img src="img/icons/menu_arrow_up.svg?v=20261002b" alt="" class="sidebar-arrow-up">
                </span>

                    </button>



                    <div class="sidebar-submenu">


                        <a href="status_approvebrsup.php">
                            ใบยืมสินค้า
                        </a>
						
<?php
                        if (
                            in_array(
                                $_SESSION['type_login'],
                                [
                                    'It',
                                    'owner'
                                ]
                            )
                        ) {
                        ?>

                            <a href="status_appbrbooth.php">
                                ใบยืมออกบูธ
                            </a>

                        <?php
                        }else{
                        ?>
						<a href="status_approvebrsc.php">
                            ใบยืมสินค้าฝากขาย
                        </a>
<?php } ?>
						
                        <?php
                        if (
                            in_array(
                                $_SESSION['type_login'],
                                [
                                    'It',
                                    'owner',
                                    'Sup_en'
                                ]
                            )
                        ) {
                        ?>

                            <a href="status_brhos_breq.php">
                                ใบยืมตรวจเช็คสินค้า BREQ
                            </a>
                             <a href="status_dmbreg_app.php">
                                ใบขอเบิกอะไหล่จากสินค้าขาย BREG
                            </a>

                        <?php
                        }
                        ?>


                    </div>

                </div>



                <a href="status_apprental.php">
                    ใบสั่งเช่า
                </a>


                <a href="status_smpapprove.php">
                    ใบเบิกสินค้า SMP
                </a>


                <?php
                if (
                    in_array(
                        $_SESSION['type_login'],
                        [
                            'Engineer',
                            'It',
                            'owner',
                            'Sup_en'
                        ]
                    )
                ) {
                ?>

                    <a href="status_appspr.php">
                        ใบเบิกสินค้า SPR
                    </a>

                <?php
                }
                ?>


                <a href="status_supchangeapp.php">
                    ใบแลกเปลี่ยนสินค้า
                </a>


                <a href="status_credit_approve.php">
                    ใบลดหนี้
                </a>


                <?php
                if (
                    in_array(
                        $_SESSION['type_login'],
                        [
                            'It',
                            'owner'
                        ]
                    )
                ) {
                ?>

                    <a href="status_app_credit.php">
                        ข้อมูลวงเงิน
                    </a>

                <?php
                }
                ?>


            </div>

        </div>
		
		<?php } ?>
		
		
	  <!-- ==================================================
             รายการรับเรื่อง
        =================================================== -->

        <div class="sidebar-group">


            <button
                type="button"
                class="sidebar-group-btn"
                onclick="toggleSidebarMain(this);"
            >

                <span class="sidebar-icon">

                    <img
                        src="img/icons/menu_regis.svg"
                        alt="รายการรับเรื่อง"
                        class="sidebar-menu-icon"
                    >

                </span>


                <span class="sidebar-label">
                    รายการรับเรื่อง
                </span>


                <span class="sidebar-caret" aria-hidden="true">
                    <img src="img/icons/menu_arrow_down.svg?v=20261002b" alt="" class="sidebar-arrow-down">
                    <img src="img/icons/menu_arrow_up.svg?v=20261002b" alt="" class="sidebar-arrow-up">
                </span>

            </button>



            <div class="sidebar-submenu">


              

                <!-- ==========================================
                     รายการรับเรื่อง
                =========================================== -->

                <a href="status_storyall.php">
                            รายการรับเรื่องลูกค้า
                        </a>
                <a href="status_cusopen.php">
                            รายการรับเรื่องลูกค้าช่าง
                        </a>

             </div>	
		</div>	

 
	
        <!-- ==================================================
             Report
        =================================================== -->

		
        <div class="sidebar-group">


            <button
                type="button"
                class="sidebar-group-btn"
                onclick="toggleSidebarMain(this);"
            >

                <span class="sidebar-icon">

                    <img
                        src="img/icons/menu_report.svg"
                        alt="Report"
                        class="sidebar-menu-icon"
                    >

                </span>


                <span class="sidebar-label">
                    Report
                </span>


                <span class="sidebar-caret" aria-hidden="true">
                    <img src="img/icons/menu_arrow_down.svg?v=20261002b" alt="" class="sidebar-arrow-down">
                    <img src="img/icons/menu_arrow_up.svg?v=20261002b" alt="" class="sidebar-arrow-up">
                </span>

            </button>



            <div class="sidebar-submenu">

                <!-- ==========================================
                     ยอดสินค้า
                =========================================== -->

                <div class="sidebar-subgroup">


                    <button
                        type="button"
                        class="sidebar-subgroup-btn"
                        onclick="toggleSidebarSub(this, event);"
                    >

                        <span class="sidebar-label">
                            ยอดสินค้า
                        </span>

                        <span class="sidebar-caret" aria-hidden="true">
                    <img src="img/icons/menu_arrow_down.svg?v=20261002b" alt="" class="sidebar-arrow-down">
                    <img src="img/icons/menu_arrow_up.svg?v=20261002b" alt="" class="sidebar-arrow-up">
                </span>

                    </button>



                    <div class="sidebar-submenu">

<a href="https://stock.allwellcenter.com/report_hotpro1.php" target="_blank">สินค้ายอดนิยม เตียงและสินค้าประกอบ</a>
		<a href="https://stock.allwellcenter.com/report_hotpro2.php" target="_blank">สินค้ายอดนิยม Online</a>
		<a href="https://stock.allwellcenter.com/report_hotpro3.php" target="_blank">สินค้ายอดนิยมทั่วไป</a>
		<a href="https://stock.allwellcenter.com/report_hotpro4.php" target="_blank">สินค้ายอดนิยม Allied</a>
		<a href="search_productall.php">สินค้าคงเหลือแบบเลือกรายการ</a>
		<a href="https://stock.allwellcenter.com/report_herohomecare.php?name=<?php echo $_SESSION['name']; ?>" target="_blank">Hero Product For Home Care</a>
		<a href="https://stock.allwellcenter.com/report_herohos.php?name=<?php echo $_SESSION['name']; ?>" target="_blank">Hero Product For Hospital</a>
		<a href="https://stock.allwellcenter.com/report_heroecom.php?name=<?php echo $_SESSION['name']; ?>" target="_blank">Hero Product For E-Commerce</a>

                    </div>

                </div>





            </div>

        </div>
		
		
		<?php
                        if (
                            in_array(
                                $_SESSION['type_login'],
                                [
                                    'It',
                                    'owner',
                                   
                                    'Admin'
                                ]
                            )
                        ) {
                        ?>	
		
	 <!-- ==================================================
             Export
        =================================================== -->

		
        <div class="sidebar-group">


            <button
                type="button"
                class="sidebar-group-btn"
                onclick="toggleSidebarMain(this);"
            >

                <span class="sidebar-icon">

                    <img
                        src="img/icons/menu_export.svg"
                        alt="Report"
                        class="sidebar-menu-icon"
                    >

                </span>


                <span class="sidebar-label">
                    Export ข้อมูล
                </span>


                <span class="sidebar-caret" aria-hidden="true">
                    <img src="img/icons/menu_arrow_down.svg?v=20261002b" alt="" class="sidebar-arrow-down">
                    <img src="img/icons/menu_arrow_up.svg?v=20261002b" alt="" class="sidebar-arrow-up">
                </span>

            </button>



            <div class="sidebar-submenu">

                <!-- ==========================================
                     E-taxt
                =========================================== -->

                <div class="sidebar-subgroup">


                    <button
                        type="button"
                        class="sidebar-subgroup-btn"
                        onclick="toggleSidebarSub(this, event);"
                    >

                        <span class="sidebar-label">
                            E-taxt Invoice
                        </span>

                        <span class="sidebar-caret" aria-hidden="true">
                    <img src="img/icons/menu_arrow_down.svg?v=20261002b" alt="" class="sidebar-arrow-down">
                    <img src="img/icons/menu_arrow_up.svg?v=20261002b" alt="" class="sidebar-arrow-up">
                </span>

                    </button>



                    <div class="sidebar-submenu">


                <!-- ==========================================
                     E-taxt ใบกำกับ
                =========================================== -->

                <div class="sidebar-subgroup">


                    <button
                        type="button"
                        class="sidebar-subgroup-btn"
                        onclick="toggleSidebarSub(this, event);"
                    >

                        <span class="sidebar-label">
                            E-taxt ใบกำกับภาษี/ใบเสร็จ
                        </span>

                        <span class="sidebar-caret" aria-hidden="true">
                    <img src="img/icons/menu_arrow_down.svg?v=20261002b" alt="" class="sidebar-arrow-down">
                    <img src="img/icons/menu_arrow_up.svg?v=20261002b" alt="" class="sidebar-arrow-up">
                </span>

                    </button>



                    <div class="sidebar-submenu">

<a href="search_taxinvoice.php"> ดึงข้อมูล ไฟล์ .txt (Home Care)</a>
<a href="search_etax_ecomer.php"> ดึงข้อมูล ไฟล์ .pdf (Home Care)</a>
	
<a href="search_taxinvoice1.php"> ดึงข้อมูล ไฟล์ .txt (Hospital)</a>
<a href="search_etax_hos.php"> ดึงข้อมูล ไฟล์ .pdf (Hospital)</a>

<a href="search_taxinvoice_txt.php">  ดึงข้อมูล ไฟล์ .txt (Home Care) ทดแทน</a>
<a href="search_etax_ecomer1.php">  ดึงข้อมูล ไฟล์ .pdf (Home Care)ทดแทน</a>
	
<a href="search_taxinvoice_txt1.php">  ดึงข้อมูล ไฟล์ .txt (Hospital) ทดแทน</a>
<a href="search_etax_hos1.php">  ดึงข้อมูล ไฟล์ .pdf (Hospital) ทดแทน</a>
                    </div>

                </div>

  <!-- ==========================================
                     E-taxt ใบลดหนี้
                =========================================== -->

                <div class="sidebar-subgroup">


                    <button
                        type="button"
                        class="sidebar-subgroup-btn"
                        onclick="toggleSidebarSub(this, event);"
                    >

                        <span class="sidebar-label">
                            E-taxt ใบลดหนี้
                        </span>

                        <span class="sidebar-caret" aria-hidden="true">
                    <img src="img/icons/menu_arrow_down.svg?v=20261002b" alt="" class="sidebar-arrow-down">
                    <img src="img/icons/menu_arrow_up.svg?v=20261002b" alt="" class="sidebar-arrow-up">
                </span>

                    </button>



                    <div class="sidebar-submenu">

<a href="search_creditnote.php">ดึงข้อมูล ไฟล์ .txt</a>
<a href="search_creditfrom.php">ดึงข้อมูล ไฟล์ .pdf</a>
	
<a href="search_creditnote1.php">ดึงข้อมูล ไฟล์ .txt ทดแทน</a>
<a href="search_creditfrom1.php">ดึงข้อมูล ไฟล์ .pdf ทดแทน</a>
                    </div>

                </div>
                           
                    </div>

                </div>





            </div>

        </div>
		<?php } ?>	
		
		
		
		
    </nav>

<?php
                        if (
                            in_array(
                                $_SESSION['type_login'],
                                [
                                    'It',
                                    'owner',
                                    'Admin'
                                ]
                            )
                        ) {
                        ?>	

    <!-- ==================================================
         SETTING
    =================================================== -->

    <div class="sidebar-group sidebar-setting-group">


        <button
            type="button"
            class="sidebar-group-btn"
            onclick="toggleSidebarMain(this);"
        >

            <img
                        src="img/icons/menu_setting.svg"
                        alt="Setting"
                        class="sidebar-menu-icon"
                    >



            <span class="sidebar-label">
                Setting
            </span>


            <span class="sidebar-caret" aria-hidden="true">
                    <img src="img/icons/menu_arrow_down.svg?v=20261002b" alt="" class="sidebar-arrow-down">
                    <img src="img/icons/menu_arrow_up.svg?v=20261002b" alt="" class="sidebar-arrow-up">
                </span>

        </button>



        <div class="sidebar-submenu">


            <a href="add_user.php">
                User
            </a>


            <a href="add_customer_rgister.php">
                บัตรสมาชิก
            </a>


            <a href="add_employee.php">
                พนักงาน
            </a>


            <a href="add_customer.php">
                ลูกค้า
            </a>


            <?php
            if (
                $_SESSION['name'] == 'ปิยะ'
                ||
                $_SESSION['name'] == 'อัจฉรา'
            ) {
            ?>


                <a href="status_customerapp.php">
                    อนุมัติลูกค้า
                </a>


                <a href="status_online_cls.php">
                    รายการสินค้ายอดนิยมออนไลน์
                </a>


            <?php
            }
            ?>


            <a href="add_customer_rgister.php">
                บัตรสมาชิก
            </a>


            <a href="add_vendor.php">
                ผู้ขาย
            </a>


            <a href="add_payment.php">
                การชำระเงิน
            </a>


            <a href="add_salechannel.php">
                ช่องทางการขาย
            </a>


            <a href="add_delivery.php">
                การจัดส่ง
            </a>


            <a href="add_document.php">
                เอกสารประกอบการออกบิล
            </a>


            <a href="add_leaflet.php">
                ใบตรวจทาน
            </a>


            <a href="status_warproduct.php">
                ข้อมูลรายการรับประกันสินค้า
            </a>


            <?php
            if (
                $_SESSION['name'] == 'อัจฉรา'
                ||
                $_SESSION['name'] == 'พัชร์ชนัญ'
            ) {
            ?>


                <a href="add_prochang.php">
                    สินค้าแลกเครื่องวัดน้ำตาล
                </a>


                <a href="status_app_credit.php">
                    ข้อมูลวงเงินลูกค้า (รออนุมัติ)
                </a>


            <?php
            }
            ?>


        </div>

    </div>

<?php } ?>

    <!-- ==================================================
         USER FOOTER
    =================================================== -->

    <div class="sidebar-footer">


        <div class="sidebar-group">


            <button
                type="button"
                class="sidebar-group-btn"
                onclick="toggleSidebarMain(this);"
            >

                <span class="sidebar-icon">
                    <i class="fa fa-user"></i>
                </span>


                <span class="sidebar-label">

                    Setting
                    (<?php echo htmlspecialchars($_SESSION['name'], ENT_QUOTES, 'UTF-8'); ?>)

                </span>


                <span class="sidebar-caret" aria-hidden="true">
                    <img src="img/icons/menu_arrow_down.svg?v=20261002b" alt="" class="sidebar-arrow-down">
                    <img src="img/icons/menu_arrow_up.svg?v=20261002b" alt="" class="sidebar-arrow-up">
                </span>

            </button>



            <div class="sidebar-submenu">


                <a href="change_pass.php">
                    Change Password
                </a>


                <a
                    href="https://allwellcenter.com/itsupport/"
                    target="_blank"
                >
                    แจ้งปัญหาการใช้งาน
                </a>


                <a href="logout.php">
                    Logout
                </a>


            </div>

        </div>

    </div>


</div>



<script>

/* =========================================================
   เปิด / ปิด MAIN MENU
========================================================= */

function toggleSidebarMain(button)
{
    if (!button) {
        return;
    }

    var currentGroup = button.parentElement;

    if (!currentGroup) {
        return;
    }

    /* เปิด/ปิดเฉพาะเมนูที่กด ไม่ปิดเมนูอื่นอัตโนมัติ */
    currentGroup.classList.toggle('sidebar-open');
}



/* =========================================================
   เปิด / ปิด SUB MENU
========================================================= */

function toggleSidebarSub(button, event)
{
    if (event) {
        event.preventDefault();
        event.stopPropagation();
    }

    if (!button) {
        return;
    }

    var currentGroup = button.parentElement;

    if (!currentGroup) {
        return;
    }

    /* เปิด/ปิดเฉพาะ submenu ที่กด */
    currentGroup.classList.toggle('sidebar-open');
}



/* =========================================================
   ACTIVE MENU
========================================================= */

document.addEventListener(
    'DOMContentLoaded',
    function()
    {

        var sidebar = document.getElementById(
            'sidebar'
        );


        if (!sidebar) {
            return;
        }


        /*
         URL ของหน้าปัจจุบัน
        */
        var currentPath = window.location.pathname;

        var currentPage = currentPath.substring(
            currentPath.lastIndexOf('/') + 1
        );


        if (
            currentPage === ''
            ||
            currentPage === '/'
        ) {

            currentPage = 'dashboard_allwell.php';

        }



        /*
         หา link ทั้งหมด
        */
        var links = sidebar.querySelectorAll(
            'a[href]'
        );


        var activeFound = false;


        links.forEach(function(link)
        {

            /*
             ป้องกัน duplicate URL เปิดสองเมนูพร้อมกัน
             เลือกตัวแรกที่ match
            */
            if (activeFound) {
                return;
            }


            var href = link.getAttribute(
                'href'
            );


            if (!href) {
                return;
            }


            /*
             ไม่ตรวจ external
            */
            if (
                href.indexOf('http://') === 0
                ||
                href.indexOf('https://') === 0
                ||
                href.indexOf('#') === 0
                ||
                href.indexOf('javascript:') === 0
            ) {

                return;

            }


            /*
             ตัด query string
            */
            var cleanHref = href.split('?')[0];


            var linkPage = cleanHref.substring(
                cleanHref.lastIndexOf('/') + 1
            );


            if (
                linkPage === currentPage
            ) {

                activeFound = true;


                link.classList.add(
                    'sidebar-active'
                );


                /*
                 เปิด parent ทุกระดับ
                */
                var parent = link.parentElement;


                while (
                    parent
                    &&
                    parent !== sidebar
                ) {

                    if (
                        parent.classList
                        &&
                        (
                            parent.classList.contains(
                                'sidebar-group'
                            )
                            ||
                            parent.classList.contains(
                                'sidebar-subgroup'
                            )
                        )
                    ) {

                        parent.classList.add(
                            'sidebar-open'
                        );

                    }


                    parent = parent.parentElement;

                }

            }

        });

    }
);

</script>