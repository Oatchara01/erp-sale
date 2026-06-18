<?php 
include('head.php');
include "dbconnect.php";
include "dbconnect_sale.php";

date_default_timezone_set("Asia/Bangkok");

$Keyword    = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';
$sale_code  = isset($_GET['sale_code']) ? $_GET['sale_code'] : '';
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$end_date   = isset($_GET['end_date']) ? $_GET['end_date'] : '';

$Per_Page = 20;
$Page = isset($_GET['Page']) ? (int)$_GET['Page'] : 1;
if ($Page < 1) {
    $Page = 1;
}
$Page_Start = ($Page - 1) * $Per_Page;

$emid = $_SESSION['code'];

if ($emid == 'SS1') {
    $sddd = " AND sale_code IN ('S15','S16','S21','S22','S14')";
} else if ($emid == 'SS2') {
    $sddd = " AND sale_code IN ('S11','S12','S17','S24')";
} else if ($emid == 'SS3') {
    $sddd = " AND sale_code IN ('MM1','SM1','S33','S31','S32')";
} else if ($emid == 'SUP_EN') {
    $sddd = " AND sale_code LIKE '%EN%'";
} else {
    $sddd = "";
}

$whereSQL = " WHERE research_demo = '2' $sddd";

if ($start_date != "") { 
    $whereSQL .= " AND iv_date >= '".$start_date."'";
}

if ($end_date != "") { 
    $whereSQL .= " AND iv_date <= '".$end_date."'";
}

if ($Keyword != "") {
    $whereSQL .= " AND iv_no LIKE '%".$Keyword."%'";
}

if ($sale_code != "") {
    $whereSQL .= " AND sale_code = '".$sale_code."'";
}

$countSQL = "SELECT COUNT(*) AS total FROM hos__br ".$whereSQL;
$countQuery = mysqli_query($conn, $countSQL) or die ("Error Query [".$countSQL."]");
$countResult = mysqli_fetch_array($countQuery);
$Num_Rows = $countResult['total'];

$Num_Pages = ceil($Num_Rows / $Per_Page);

$strSQL = "SELECT * FROM hos__br ".$whereSQL." ORDER BY iv_date DESC LIMIT ".$Page_Start.", ".$Per_Page;
$objQuery = mysqli_query($conn, $strSQL) or die ("Error Query [".$strSQL."]");
?>

<body>
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
<div class="w3-white">
<div class="w3-container w3-padding-large">
    <div class="w3-panel w3-light-grey">
        <h3>แบบสอบถามสินค้าสาธิต ทำแล้ว (ทั้งหมด)</h3>
    </div>

    <div class="w3-bar w3-quarter">
        วันที่ :
        <input name="start_date" class="w3-input" style="width:90%;" type="date" id="start_date" value="<?php echo $start_date; ?>">
    </div>

    <div class="w3-bar w3-quarter">
        ถึง :
        <input name="end_date" class="w3-input" style="width:90%;" type="date" id="end_date" value="<?php echo $end_date; ?>">
    </div>

    <div class="w3-bar w3-quarter">
        เลขที่เอกสาร :
        <input name="Keyword" class="w3-input" style="width:90%;" type="text" id="Keyword" value="<?php echo $Keyword; ?>">
    </div>

    <div class="w3-bar w3-quarter">
        Sale :
        <?php 
        if ($_SESSION['code'] == 'SS1') {
            $teamSQL = "SELECT * FROM tb_team_ss1 ORDER BY sale_code ASC";
        } else if ($_SESSION['code'] == 'SS2') {
            $teamSQL = "SELECT * FROM tb_team_ss2 ORDER BY sale_code ASC";
        } else if ($_SESSION['code'] == 'SS3') {
            $teamSQL = "SELECT * FROM tb_team_ss3 WHERE ckk_1='0' ORDER BY sale_code ASC";
        } else if ($_SESSION['code'] == 'MK2') {
            $teamSQL = "SELECT * FROM tb_team_sm1 ORDER BY sale_code ASC";
        } else if ($_SESSION['code'] == 'SUP_EN') {
            $teamSQL = "SELECT * FROM tb_team_en ORDER BY sale_code ASC";
        } else {
            $teamSQL = "SELECT * FROM tb_team_all ORDER BY sale_code ASC";
        }
        ?>

        <select name="sale_code" id="sale_code" style="width:90%" class="w3-input">
            <option value="">**Please Select**</option>
            <?php
            $teamQuery = mysqli_query($com, $teamSQL);
            while ($teamResult = mysqli_fetch_array($teamQuery)) {
                $sel = ($sale_code == $teamResult["sale_code"]) ? "selected" : "";
            ?>
                <option value="<?php echo $teamResult["sale_code"]; ?>" <?php echo $sel; ?>>
                    <?php echo $teamResult["sale_code"]; ?> - <?php echo $teamResult["sale_name"]; ?>
                </option>
            <?php } ?>
        </select>
    </div>

    <div class="w3-bar w3-quarter w3-padding-xsmall">
        <input type="submit" class="w3-button w3-teal" value="Search">
    </div>
</div>
</div>
</form>

<div class="w3-container w3-white">
<table border="1" width="100%" class="w3-table">
    <thead class="w3-gray">
        <th width="5%">เลขที่อ้างอิง</th>
        <th width="10%">วันที่ลงทะเบียน</th>
        <th width="10%">เลขที่เอกสาร</th> 
        <th width="10%">วันที่ออกเอกสาร</th>
        <th width="23%">รายการสินค้า</th>
        <th width="22%">ชื่อลูกค้า</th>
        <th width="10%">เขตการขาย</th>
        <th width="10%">สถานะ</th>
        <th width="5%">แบบสอบถาม</th>
    </thead>
    <tbody>
    <?php
    while ($objResult = mysqli_fetch_array($objQuery)) {
    ?>
        <tr>
            <td><?php echo $objResult["ref_id_br"]; ?></td>

            <td><?php echo DateThai($objResult["date_br"]); ?></td>

            <td><?php echo $objResult["iv_no"]; ?></td>

            <td>
                <?php 
                if ($objResult["iv_date"] == "0000-00-00") {
                    echo "-"; 
                } else {
                    echo DateThai($objResult["iv_date"]);
                }
                ?> 
            </td>

            <td>
                <div align="left">
                <?php
                $strSQL1 = "SELECT * FROM 
                            (hos__subbr LEFT JOIN tb_product 
                            ON hos__subbr.product_ID = tb_product.product_id) 
                            WHERE ref_idd_br = '".$objResult["ref_id_br"]."' ";

                $objQuery1 = mysqli_query($conn, $strSQL1) or die ("Error Query [".$strSQL1."]");

                while ($objResult1 = mysqli_fetch_array($objQuery1)) {
                    echo $objResult1["sol_name"]." ".$objResult1["sale_remark"]."<br />";
                }
                ?>
                </div>
            </td>

            <td>
                <div align="left"><?php echo $objResult["customer"]; ?></div>
            </td>

            <td>
                <div align="left">
                    <?php echo $objResult["sale_code"]; ?> - <?php echo $objResult["sale"]; ?>
                </div>
            </td>

            <?php if ($objResult["status_doc"] == 'Rejected') { ?>
                <td bgcolor="#FF3030"><?php echo $objResult["status_doc"]; ?></td>
            <?php } else if ($objResult["status_doc"] == 'Approve') { ?>
                <td bgcolor="#00FF00"><?php echo $objResult["status_doc"]; ?></td>
            <?php } else { ?>
                <td><?php echo $objResult["status_doc"]; ?></td>
            <?php } ?>

            <?php
            $strSQL2 = "SELECT ref_id FROM tb_research_demo WHERE ref_id = '".$objResult["ref_id_br"]."' ";
            $objQuery2 = mysqli_query($conn, $strSQL2) or die(mysqli_error($conn));
            $Num_Rows2 = mysqli_num_rows($objQuery2);

            if ($Num_Rows2 > 0) {
            ?>
                <td>
                    <a href="viewreserch_demo.php?ref_id_br=<?php echo $objResult["ref_id_br"]; ?>">
                        <img src="img/create.png" width="23" height="23" border="0" />
                    </a>
                </td>
            <?php } else { ?>
                <td bgcolor="#FF0000">ไม่ได้ทำแบบสอบถาม</td>
            <?php } ?>
        </tr>
    <?php } ?>
    </tbody>
</table>

<?php
$queryString = "Keyword=".urlencode($Keyword)
             ."&start_date=".urlencode($start_date)
             ."&end_date=".urlencode($end_date)
             ."&sale_code=".urlencode($sale_code);
?>

<div class="w3-panel">
    <strong>พบทั้งหมด</strong>
    <?php echo $Num_Rows; ?>
    <strong>รายการ :</strong>
    <strong>จำนวน</strong>
    <?php echo $Num_Pages; ?>
    <strong>หน้า :</strong>

    <?php
    $Prev_Page = $Page - 1;
    $Next_Page = $Page + 1;

    if ($Page > 1) {
        echo " <a href='".$_SERVER['SCRIPT_NAME']."?Page=".$Prev_Page."&".$queryString."'>
        <font color='black'>&lt;&lt; Back</font></a> ";
    }

    for ($i = 1; $i <= $Num_Pages; $i++) {
        if ($i != $Page) {
            echo "[ <a href='".$_SERVER['SCRIPT_NAME']."?Page=".$i."&".$queryString."'>
            <font color='black'>".$i."</font></a> ]";
        } else {
            echo "<b> ".$i." </b>";
        }
    }

    if ($Page < $Num_Pages) {
        echo " <a href='".$_SERVER['SCRIPT_NAME']."?Page=".$Next_Page."&".$queryString."'>
        <font color='black'>Next&gt;&gt;</font></a> ";
    }
    ?>
    <br>
</div>
</div>

<div id="cr_bar">
    <?php include "foot.php"; ?>
</div>

</body>
</html>