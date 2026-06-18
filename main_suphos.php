<?php
include('head.php');
include("dbconnect.php");
include "dbconnect_sale.php";
?>
<body>
<div class="w3-container"></div>
</body>

<?php
$add_date = date('Y-m-d');

if($_SESSION["department"]=='วิศวกรรม'){
    include ('grddd_all.php');
}else{
?>

<div class="w3-white">
<div class="w3-container w3-padding-large">
<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
    <br>

    <?php 
    if($_SESSION["code"]=='SS5'){
		
	include("notify_supss5.php");
        // ไม่แสดง notify
    }else{
        include("notify_supsale.php");
    }
    ?>
    <br>

    <div class="w3-quarter">
        เดือน :
        <select name="mount" id="mount" style="width:90%" class="w3-input">
            <option value="">**Please Select**</option>
            <option value="01" <?php echo (!empty($_GET["mount"]) && $_GET["mount"]=="01") ? 'selected' : ''; ?>>มกราคม</option>
            <option value="02" <?php echo (!empty($_GET["mount"]) && $_GET["mount"]=="02") ? 'selected' : ''; ?>>กุมภาพันธ์</option>
            <option value="03" <?php echo (!empty($_GET["mount"]) && $_GET["mount"]=="03") ? 'selected' : ''; ?>>มีนาคม</option>
            <option value="04" <?php echo (!empty($_GET["mount"]) && $_GET["mount"]=="04") ? 'selected' : ''; ?>>เมษายน</option>
            <option value="05" <?php echo (!empty($_GET["mount"]) && $_GET["mount"]=="05") ? 'selected' : ''; ?>>พฤษภาคม</option>
            <option value="06" <?php echo (!empty($_GET["mount"]) && $_GET["mount"]=="06") ? 'selected' : ''; ?>>มิถุนายน</option>
            <option value="07" <?php echo (!empty($_GET["mount"]) && $_GET["mount"]=="07") ? 'selected' : ''; ?>>กรกฎาคม</option>
            <option value="08" <?php echo (!empty($_GET["mount"]) && $_GET["mount"]=="08") ? 'selected' : ''; ?>>สิงหาคม</option>
            <option value="09" <?php echo (!empty($_GET["mount"]) && $_GET["mount"]=="09") ? 'selected' : ''; ?>>กันยายน</option>
            <option value="10" <?php echo (!empty($_GET["mount"]) && $_GET["mount"]=="10") ? 'selected' : ''; ?>>ตุลาคม</option>
            <option value="11" <?php echo (!empty($_GET["mount"]) && $_GET["mount"]=="11") ? 'selected' : ''; ?>>พฤศจิกายน</option>
            <option value="12" <?php echo (!empty($_GET["mount"]) && $_GET["mount"]=="12") ? 'selected' : ''; ?>>ธันวาคม</option>
        </select>
    </div>

    <div class="w3-quarter">
        ปี :
        <select name="year" id="year" style="width:90%" class="w3-input">
            <option value="">**Please Select**</option>
            <option value="2021" <?php echo (!empty($_GET["year"]) && $_GET["year"]=="2021") ? 'selected' : ''; ?>>2564</option>
            <option value="2022" <?php echo (!empty($_GET["year"]) && $_GET["year"]=="2022") ? 'selected' : ''; ?>>2565</option>
            <option value="2023" <?php echo (!empty($_GET["year"]) && $_GET["year"]=="2023") ? 'selected' : ''; ?>>2566</option>
            <option value="2024" <?php echo (!empty($_GET["year"]) && $_GET["year"]=="2024") ? 'selected' : ''; ?>>2567</option>
            <option value="2025" <?php echo (!empty($_GET["year"]) && $_GET["year"]=="2025") ? 'selected' : ''; ?>>2568</option>
            <option value="2026" <?php echo (!empty($_GET["year"]) && $_GET["year"]=="2026") ? 'selected' : ''; ?>>2569</option>
            <option value="2027" <?php echo (!empty($_GET["year"]) && $_GET["year"]=="2027") ? 'selected' : ''; ?>>2570</option>
            <option value="2028" <?php echo (!empty($_GET["year"]) && $_GET["year"]=="2028") ? 'selected' : ''; ?>>2571</option>
            <option value="2029" <?php echo (!empty($_GET["year"]) && $_GET["year"]=="2029") ? 'selected' : ''; ?>>2572</option>
            <option value="2030" <?php echo (!empty($_GET["year"]) && $_GET["year"]=="2030") ? 'selected' : ''; ?>>2573</option>
        </select>
    </div>

    <div class="w3-margin-bottom">
        <input type="submit" value="Search" class="w3-button w3-pale-red">
    </div>

    <br>

<?php
if(!empty($_GET["mount"]) && !empty($_GET["year"])){
    $mm = $_GET["mount"];
    $yy = $_GET["year"];
}else{
    $mm = date('m');
    $yy = date('Y');
}

$_month_name = array(
    "01"=>"มกราคม","02"=>"กุมภาพันธ์","03"=>"มีนาคม","04"=>"เมษายน",
    "05"=>"พฤษภาคม","06"=>"มิถุนายน","07"=>"กรกฎาคม","08"=>"สิงหาคม",
    "09"=>"กันยายน","10"=>"ตุลาคม","11"=>"พฤศจิกายน","12"=>"ธันวาคม"
);

$thai = isset($_month_name[$mm]) ? $_month_name[$mm] : '';
$year = $yy + 543;
$start_date = $yy . "-" . $mm;
$ytd_1 = $yy . "-01";

function safe_num($val){
    return is_numeric($val) ? (float)$val : 0;
}

function safe_percent($sum, $target){
    $sum = safe_num($sum);
    $target = safe_num($target);
    return ($target > 0) ? (($sum / $target) * 100) : 0;
}

function get_sale_data($conn, $sale_code, $start_date){
    $data = array(
        'sum_awl' => 0,
        'sum_nbm' => 0,
        'sum_all' => 0,
        'target'  => 0,
        'percent' => 0
    );

    $strSQL = "SELECT sum_awl, sum_nbm 
               FROM tb_sumall 
               WHERE sale_cose='$sale_code' AND month_sum='$start_date'";
    $objQuery = mysqli_query($conn, $strSQL) or die("Error Query [$strSQL]");
    $objResult = mysqli_fetch_array($objQuery);

    $sum_awl = safe_num(isset($objResult['sum_awl']) ? $objResult['sum_awl'] : 0);
    $sum_nbm = safe_num(isset($objResult['sum_nbm']) ? $objResult['sum_nbm'] : 0);
    $sum_all = $sum_awl + $sum_nbm;

    $strSQL1 = "SELECT SUM(target) AS target 
                FROM tb_target 
                WHERE zone_code='$sale_code' AND month_no='$start_date'";
    $objQuery1 = mysqli_query($conn, $strSQL1) or die("Error Query [$strSQL1]");
    $objResult1 = mysqli_fetch_array($objQuery1);

    $target = safe_num(isset($objResult1['target']) ? $objResult1['target'] : 0);
    $percent = safe_percent($sum_all, $target);

    $data['sum_awl'] = $sum_awl;
    $data['sum_nbm'] = $sum_nbm;
    $data['sum_all'] = $sum_all;
    $data['target'] = $target;
    $data['percent'] = $percent;

    return $data;
}

function get_sum_target_by_type($conn, $type_arae, $start_date){
    $data = array(
        'sum_awl' => 0,
        'sum_nbm' => 0,
        'sum_all' => 0,
        'target'  => 0,
        'percent' => 0
    );

    $strSQL = "SELECT SUM(sum_awl) AS sum_awl, SUM(sum_nbm) AS sum_nbm
               FROM tb_sumall
               WHERE type_arae='$type_arae' AND month_sum='$start_date'";
    $objQuery = mysqli_query($conn, $strSQL) or die("Error Query [$strSQL]");
    $objResult = mysqli_fetch_array($objQuery);

    $sum_awl = safe_num(isset($objResult['sum_awl']) ? $objResult['sum_awl'] : 0);
    $sum_nbm = safe_num(isset($objResult['sum_nbm']) ? $objResult['sum_nbm'] : 0);
    $sum_all = $sum_awl + $sum_nbm;

    $strSQL1 = "SELECT SUM(target) AS target
                FROM tb_target
                WHERE ckk_type='$type_arae' AND month_no='$start_date'";
    $objQuery1 = mysqli_query($conn, $strSQL1) or die("Error Query [$strSQL1]");
    $objResult1 = mysqli_fetch_array($objQuery1);

    $target = safe_num(isset($objResult1['target']) ? $objResult1['target'] : 0);
    $percent = safe_percent($sum_all, $target);

    $data['sum_awl'] = $sum_awl;
    $data['sum_nbm'] = $sum_nbm;
    $data['sum_all'] = $sum_all;
    $data['target'] = $target;
    $data['percent'] = $percent;

    return $data;
}

function get_ytd_sum_target_by_type($conn, $type_arae, $ytd_1, $start_date){
    $data = array(
        'sum_awl' => 0,
        'sum_nbm' => 0,
        'sum_all' => 0,
        'target'  => 0,
        'percent' => 0
    );

    $strSQL = "SELECT SUM(sum_awl) AS sum_awl, SUM(sum_nbm) AS sum_nbm
               FROM tb_sumall
               WHERE type_arae='$type_arae'
               AND month_sum >= '$ytd_1'
               AND month_sum <= '$start_date'";
    $objQuery = mysqli_query($conn, $strSQL) or die("Error Query [$strSQL]");
    $objResult = mysqli_fetch_array($objQuery);

    $sum_awl = safe_num(isset($objResult['sum_awl']) ? $objResult['sum_awl'] : 0);
    $sum_nbm = safe_num(isset($objResult['sum_nbm']) ? $objResult['sum_nbm'] : 0);
    $sum_all = $sum_awl + $sum_nbm;

    $strSQL1 = "SELECT SUM(target) AS target
                FROM tb_target
                WHERE ckk_type='$type_arae'
                AND month_no >= '$ytd_1'
                AND month_no <= '$start_date'";
    $objQuery1 = mysqli_query($conn, $strSQL1) or die("Error Query [$strSQL1]");
    $objResult1 = mysqli_fetch_array($objQuery1);

    $target = safe_num(isset($objResult1['target']) ? $objResult1['target'] : 0);
    $percent = safe_percent($sum_all, $target);

    $data['sum_awl'] = $sum_awl;
    $data['sum_nbm'] = $sum_nbm;
    $data['sum_all'] = $sum_all;
    $data['target'] = $target;
    $data['percent'] = $percent;

    return $data;
}

function get_sum_target_by_zones($conn, $zones, $start_date){
    $data = array(
        'sum_awl' => 0,
        'sum_nbm' => 0,
        'sum_all' => 0,
        'target'  => 0,
        'percent' => 0
    );

    $zone_list = "'" . implode("','", $zones) . "'";

    $strSQL = "SELECT SUM(sum_awl) AS sum_awl, SUM(sum_nbm) AS sum_nbm
               FROM tb_sumall
               WHERE sale_cose IN ($zone_list) AND month_sum='$start_date'";
    $objQuery = mysqli_query($conn, $strSQL) or die("Error Query [$strSQL]");
    $objResult = mysqli_fetch_array($objQuery);

    $sum_awl = safe_num(isset($objResult['sum_awl']) ? $objResult['sum_awl'] : 0);
    $sum_nbm = safe_num(isset($objResult['sum_nbm']) ? $objResult['sum_nbm'] : 0);
    $sum_all = $sum_awl + $sum_nbm;

    $strSQL1 = "SELECT SUM(target) AS target
                FROM tb_target
                WHERE zone_code IN ($zone_list) AND month_no='$start_date'";
    $objQuery1 = mysqli_query($conn, $strSQL1) or die("Error Query [$strSQL1]");
    $objResult1 = mysqli_fetch_array($objQuery1);

    $target = safe_num(isset($objResult1['target']) ? $objResult1['target'] : 0);
    $percent = safe_percent($sum_all, $target);

    $data['sum_awl'] = $sum_awl;
    $data['sum_nbm'] = $sum_nbm;
    $data['sum_all'] = $sum_all;
    $data['target'] = $target;
    $data['percent'] = $percent;

    return $data;
}

function get_ytd_sum_target_by_zones($conn, $zones, $ytd_1, $start_date){
    $data = array(
        'sum_awl' => 0,
        'sum_nbm' => 0,
        'sum_all' => 0,
        'target'  => 0,
        'percent' => 0
    );

    $zone_list = "'" . implode("','", $zones) . "'";

    $strSQL = "SELECT SUM(sum_awl) AS sum_awl, SUM(sum_nbm) AS sum_nbm
               FROM tb_sumall
               WHERE sale_cose IN ($zone_list)
               AND month_sum >= '$ytd_1'
               AND month_sum <= '$start_date'";
    $objQuery = mysqli_query($conn, $strSQL) or die("Error Query [$strSQL]");
    $objResult = mysqli_fetch_array($objQuery);

    $sum_awl = safe_num(isset($objResult['sum_awl']) ? $objResult['sum_awl'] : 0);
    $sum_nbm = safe_num(isset($objResult['sum_nbm']) ? $objResult['sum_nbm'] : 0);
    $sum_all = $sum_awl + $sum_nbm;

    $strSQL1 = "SELECT SUM(target) AS target
                FROM tb_target
                WHERE zone_code IN ($zone_list)
                AND month_no >= '$ytd_1'
                AND month_no <= '$start_date'";
    $objQuery1 = mysqli_query($conn, $strSQL1) or die("Error Query [$strSQL1]");
    $objResult1 = mysqli_fetch_array($objQuery1);

    $target = safe_num(isset($objResult1['target']) ? $objResult1['target'] : 0);
    $percent = safe_percent($sum_all, $target);

    $data['sum_awl'] = $sum_awl;
    $data['sum_nbm'] = $sum_nbm;
    $data['sum_all'] = $sum_all;
    $data['target'] = $target;
    $data['percent'] = $percent;

    return $data;
}

$dataPoints = array();

if($_SESSION["code"]=='SS5'){

    $s31 = get_sale_data($conn, 'S31', $start_date);
    $s32 = get_sale_data($conn, 'S32', $start_date);

    $sumawl_s31 = $s31['sum_awl'];
    $sumnbm_s31 = $s31['sum_nbm'];
    $sumary_s31 = $s31['sum_all'];
    $target_s31 = $s31['target'];
    $percen_s31 = $s31['percent'];

    $sumawl_s32 = $s32['sum_awl'];
    $sumnbm_s32 = $s32['sum_nbm'];
    $sumary_s32 = $s32['sum_all'];
    $target_s32 = $s32['target'];
    $percen_s32 = $s32['percent'];

    $monthTotal = get_sum_target_by_zones($conn, array('S31','S32'), $start_date);
    $ytdTotal   = get_ytd_sum_target_by_zones($conn, array('S31','S32'), $ytd_1, $start_date);

    $sum_awl = $monthTotal['sum_awl'];
    $sum_nbm = $monthTotal['sum_nbm'];
    $sum_all = $monthTotal['sum_all'];
    $target = $monthTotal['target'];
    $percen = $monthTotal['percent'];

    $sum_allh = $ytdTotal['sum_all'];
    $target_allh = $ytdTotal['target'];
    $percen_allh = $ytdTotal['percent'];
?>
    <center>
        <h3 align="center">รายงานยอดขายแบบกราฟ</h3>
        <h3 align="center"><?php echo $thai; ?>&nbsp;&nbsp;<?php echo $year; ?></h3>
    </center>
    <br><br>

    <div class="w3-half 1">

        <table width="90%" border="1" cellpadding="0" cellspacing="0" align="center">
            <thead>
                <tr>
                    <th width="10%"></th>
                    <th width="15%">เดือน <?php echo $thai; ?>&nbsp;&nbsp;<?php echo $year; ?></th>
                    <th width="15%">YTD</th>
                </tr>
            </thead>
            <tr>
                <td align="center"><b>Target (เป้าหมาย)</b></td>
                <td align="right"><b><?php echo number_format($target,2);?></b></td>
                <td align="right"><b><?php echo number_format($target_allh,2);?></b></td>
            </tr>
            <tr>
                <td align="center"><b>Achieve (ยอดขาย)</b></td>
                <td align="right"><b><?php echo number_format($sum_all,2);?></b></td>
                <td align="right"><b><?php echo number_format($sum_allh,2);?></b></td>
            </tr>
            <tr>
                <td align="center"><b>% Achieve</b></td>
                <td align="right"><h4><b><font color='#FF4500'><?php echo number_format($percen,2);?> %</font></b></h4></td>
                <td align="right"><h4><b><font color='#FF4500'><?php echo number_format($percen_allh,2);?> %</font></b></h4></td>
            </tr>
        </table>

        <br><br>

        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
        google.charts.load('current', {'packages':['bar']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var el = document.getElementById('barchart_material');
            if (!el) return;

            var data = google.visualization.arrayToDataTable([
                ['ยอดการขาย', 'Target', 'Achieve'],
                ['Target & Achieve', <?php echo (float)$target_allh; ?>, <?php echo (float)$sum_allh; ?>]
            ]);

            var options = {
                chart: {
                    title: 'Target & Achieve',
                    subtitle: ''
                },
                bars: 'horizontal'
            };

            var chart = new google.charts.Bar(el);
            chart.draw(data, google.charts.Bar.convertOptions(options));
        }
        </script>

        <div id="barchart_material" style="width: 80%; height: 400px;"></div>
    </div>

    <div class="w3-half 1">
        <table width="60%" border="1" cellpadding="0" cellspacing="0" align="center">
            <thead>
                <tr>
                    <th width="10%">เขตการขาย</th>
                    <th width="10%">ยอดขาย AWL</th>
                    <th width="10%">ยอดขาย NBM</th>
                    <th width="10%">ยอดขายทั้งหมด</th>
                    <th width="10%">เป้าหมาย</th>
                    <th width="10%">% Achieve</th>
                </tr>
            </thead>
            <tr>
                <td align="center">S31</td>
                <td align="right"><?php echo number_format($sumawl_s31,2);?></td>
                <td align="right"><?php echo number_format($sumnbm_s31,2);?></td>
                <td align="right"><a href="report_hossummonth.php?sale_code=<?php echo "S31";?>&start_date=<?php echo $start_date; ?>"  target="_blank"><?php echo number_format($sumary_s31,2);?></a></td>
                <td align="right"><?php echo number_format($target_s31,2);?></td>
                <td align="right"><?php echo number_format($percen_s31,2);?> %</td>
            </tr>
            <tr>
                <td align="center">S32</td>
                <td align="right"><?php echo number_format($sumawl_s32,2);?></td>
                <td align="right"><?php echo number_format($sumnbm_s32,2);?></td>
                <td align="right"><a href="report_hossummonth.php?sale_code=<?php echo "S32";?>&start_date=<?php echo $start_date; ?>"  target="_blank"><?php echo number_format($sumary_s32,2);?></a></td>
                <td align="right"><?php echo number_format($target_s32,2);?></td>
                <td align="right"><?php echo number_format($percen_s32,2);?> %</td>
            </tr>
            <tr>
                <td align="center"><b><font color='#FF0000'>ยอดขายรวมทั้งหมด</font></b></td>
                <td align="right"><b><font color='#CC00FF'><?php echo number_format($sum_awl,2);?></font></b></td>
                <td align="right"><b><font color='#FF3399'><?php echo number_format($sum_nbm,2);?></font></b></td>
                <td align="right"><b><font color='#660099'><?php echo number_format($sum_all,2);?></font></b></td>
                <td align="right"><b><font color='#FF6600'><?php echo number_format($target,2);?></font></b></td>
                <td align="right"><b><font color='#339900'><?php echo number_format($percen,2);?> %</font></b></td>
            </tr>
        </table>

        <br><br>

        <style>
        .button1 {border-radius: 2px; background-color:#FF9999; padding:0.1px 0.1px; margin:0.5px 0.5px;}
        .button2 {border-radius: 2px; background-color:#FFFFFF; padding:0px 0px; margin:0px 0px;}
        .button3 {border-radius: 2px; background-color:#330066; padding:0.1px 0.1px; margin:0.5px 0.5px;}
        </style>

        <input class="button3" style="width:40px;height:20px"> : เปอร์เซ็นต์ยอดขาย
        <br><br>

<?php
    $dataPoints = array(
        array("y" => $percen_s31, "color" => "#330066", "label" => "S31"),
        array("y" => $percen_s32, "color" => "#330066", "label" => "S32")
    );
?>

        <div id="chartContainer" style="height: 370px; width: 100%;"></div>
    </div>

<?php
}else{

    $zones = array('S11','S12','S13','S14','S15','S16','S17','S21','S22','S23','S24');
    $zoneData = array();

    foreach($zones as $zone){
        $zoneData[$zone] = get_sale_data($conn, $zone, $start_date);
    }

    $sumawl_s11 = $zoneData['S11']['sum_awl'];
    $sumnbm_s11 = $zoneData['S11']['sum_nbm'];
    $sumary_s11 = $zoneData['S11']['sum_all'];
    $target_s11 = $zoneData['S11']['target'];
    $percen_s11 = $zoneData['S11']['percent'];

    $sumawl_s12 = $zoneData['S12']['sum_awl'];
    $sumnbm_s12 = $zoneData['S12']['sum_nbm'];
    $sumary_s12 = $zoneData['S12']['sum_all'];
    $target_s12 = $zoneData['S12']['target'];
    $percen_s12 = $zoneData['S12']['percent'];

    $sumawl_s13 = $zoneData['S13']['sum_awl'];
    $sumnbm_s13 = $zoneData['S13']['sum_nbm'];
    $sumary_s13 = $zoneData['S13']['sum_all'];
    $target_s13 = $zoneData['S13']['target'];
    $percen_s13 = $zoneData['S13']['percent'];

    $sumawl_s14 = $zoneData['S14']['sum_awl'];
    $sumnbm_s14 = $zoneData['S14']['sum_nbm'];
    $sumary_s14 = $zoneData['S14']['sum_all'];
    $target_s14 = $zoneData['S14']['target'];
    $percen_s14 = $zoneData['S14']['percent'];

    $sumawl_s15 = $zoneData['S15']['sum_awl'];
    $sumnbm_s15 = $zoneData['S15']['sum_nbm'];
    $sumary_s15 = $zoneData['S15']['sum_all'];
    $target_s15 = $zoneData['S15']['target'];
    $percen_s15 = $zoneData['S15']['percent'];

    $sumawl_s16 = $zoneData['S16']['sum_awl'];
    $sumnbm_s16 = $zoneData['S16']['sum_nbm'];
    $sumary_s16 = $zoneData['S16']['sum_all'];
    $target_s16 = $zoneData['S16']['target'];
    $percen_s16 = $zoneData['S16']['percent'];

    $sumawl_s17 = $zoneData['S17']['sum_awl'];
    $sumnbm_s17 = $zoneData['S17']['sum_nbm'];
    $sumary_s17 = $zoneData['S17']['sum_all'];
    $target_s17 = $zoneData['S17']['target'];
    $percen_s17 = $zoneData['S17']['percent'];

    $sumawl_s21 = $zoneData['S21']['sum_awl'];
    $sumnbm_s21 = $zoneData['S21']['sum_nbm'];
    $sumary_s21 = $zoneData['S21']['sum_all'];
    $target_s21 = $zoneData['S21']['target'];
    $percen_s21 = $zoneData['S21']['percent'];

    $sumawl_s22 = $zoneData['S22']['sum_awl'];
    $sumnbm_s22 = $zoneData['S22']['sum_nbm'];
    $sumary_s22 = $zoneData['S22']['sum_all'];
    $target_s22 = $zoneData['S22']['target'];
    $percen_s22 = $zoneData['S22']['percent'];

    $sumawl_s23 = $zoneData['S23']['sum_awl'];
    $sumnbm_s23 = $zoneData['S23']['sum_nbm'];
    $sumary_s23 = $zoneData['S23']['sum_all'];
    $target_s23 = $zoneData['S23']['target'];
    $percen_s23 = $zoneData['S23']['percent'];

    $sumawl_s24 = $zoneData['S24']['sum_awl'];
    $sumnbm_s24 = $zoneData['S24']['sum_nbm'];
    $sumary_s24 = $zoneData['S24']['sum_all'];
    $target_s24 = $zoneData['S24']['target'];
    $percen_s24 = $zoneData['S24']['percent'];

    $monthTotal = get_sum_target_by_type($conn, '1', $start_date);
    $ytdTotal   = get_ytd_sum_target_by_type($conn, '1', $ytd_1, $start_date);

    $sum_awl = $monthTotal['sum_awl'];
    $sum_nbm = $monthTotal['sum_nbm'];
    $sum_all = $monthTotal['sum_all'];
    $target = $monthTotal['target'];
    $percen = $monthTotal['percent'];

    $sum_allh = $ytdTotal['sum_all'];
    $target_allh = $ytdTotal['target'];
    $percen_allh = $ytdTotal['percent'];
?>
    <center>
        <h3 align="center">รายงานยอดขายแบบกราฟ แผนกโรงพยาบาล</h3>
        <h3 align="center"><?php echo $thai; ?>&nbsp;&nbsp;<?php echo $year; ?></h3>
    </center>
    <br><br>

    <div class="w3-half 1">
        <table width="90%" border="1" cellpadding="0" cellspacing="0" align="center">
            <thead>
                <tr>
                    <th width="10%"></th>
                    <th width="15%">เดือน <?php echo $thai; ?>&nbsp;&nbsp;<?php echo $year; ?></th>
                    <th width="15%">YTD</th>
                </tr>
            </thead>
            <tr>
                <td align="center"><b>Target (เป้าหมาย)</b></td>
                <td align="right"><b><?php echo number_format($target,2);?></b></td>
                <td align="right"><b><?php echo number_format($target_allh,2);?></b></td>
            </tr>
            <tr>
                <td align="center"><b>Achieve (ยอดขาย)</b></td>
                <td align="right"><b><?php echo number_format($sum_all,2);?></b></td>
                <td align="right"><b><?php echo number_format($sum_allh,2);?></b></td>
            </tr>
            <tr>
                <td align="center"><b>% Achieve</b></td>
                <td align="right"><h4><b><font color='#FF4500'><?php echo number_format($percen,2);?> %</font></b></h4></td>
                <td align="right"><h4><b><font color='#FF4500'><?php echo number_format($percen_allh,2);?> %</font></b></h4></td>
            </tr>
        </table>

        <br><br>

        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
        google.charts.load('current', {'packages':['bar']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var el = document.getElementById('barchart_material');
            if (!el) return;

            var data = google.visualization.arrayToDataTable([
                ['ยอดการขาย', 'Target', 'Achieve'],
                ['Target & Achieve', <?php echo (float)$target_allh; ?>, <?php echo (float)$sum_allh; ?>]
            ]);

            var options = {
                chart: {
                    title: 'Target & Achieve',
                    subtitle: ''
                },
                bars: 'horizontal'
            };

            var chart = new google.charts.Bar(el);
            chart.draw(data, google.charts.Bar.convertOptions(options));
        }
        </script>

        <div id="barchart_material" style="width: 80%; height: 400px;"></div>
    </div>

    <div class="w3-half 1">
        <table width="60%" border="1" cellpadding="0" cellspacing="0" align="center">
            <thead>
                <tr>
                    <th width="10%">เขตการขาย</th>
                    <th width="10%">ยอดขาย AWL</th>
                    <th width="10%">ยอดขาย NBM</th>
                    <th width="10%">ยอดขายทั้งหมด</th>
                    <th width="10%">เป้าหมาย</th>
                    <th width="10%">% Achieve</th>
                </tr>
            </thead>

            <tr>
				<td align="center">S11</td>
				<td align="right"><?php echo number_format($sumawl_s11,2);?></td>
				<td align="right"><?php echo number_format($sumnbm_s11,2);?></td>
				<td align="right"><?php echo number_format($sumary_s11,2);?></td>
				<td align="right"><?php echo number_format($target_s11,2);?></td>
				<td align="right"><?php echo number_format($percen_s11,2);?> %</td>
			</tr>
            <tr>
				<td align="center">S12</td>
				<td align="right"><?php echo number_format($sumawl_s12,2);?></td>
				<td align="right"><?php echo number_format($sumnbm_s12,2);?></td>
				<td align="right"><?php echo number_format($sumary_s12,2);?></td>
				<td align="right"><?php echo number_format($target_s12,2);?></td>
				<td align="right"><?php echo number_format($percen_s12,2);?> %</td>
			</tr>
            <tr>
				<td align="center">S13</td>
				<td align="right"><?php echo number_format($sumawl_s13,2);?></td>
				<td align="right"><?php echo number_format($sumnbm_s13,2);?></td>
				<td align="right"><?php echo number_format($sumary_s13,2);?></td>
				<td align="right"><?php echo number_format($target_s13,2);?></td>
				<td align="right"><?php echo number_format($percen_s13,2);?> %</td>
			</tr>
            <tr>
				<td align="center">S14</td>
				<td align="right"><?php echo number_format($sumawl_s14,2);?></td>
				<td align="right"><?php echo number_format($sumnbm_s14,2);?></td>
				<td align="right"><?php echo number_format($sumary_s14,2);?></td>
				<td align="right"><?php echo number_format($target_s14,2);?></td>
				<td align="right"><?php echo number_format($percen_s14,2);?> %</td>
			</tr>
            <tr>
				<td align="center">S15</td>
				<td align="right"><?php echo number_format($sumawl_s15,2);?></td>
				<td align="right"><?php echo number_format($sumnbm_s15,2);?></td>
				<td align="right"><?php echo number_format($sumary_s15,2);?></td>
				<td align="right"><?php echo number_format($target_s15,2);?></td>
				<td align="right"><?php echo number_format($percen_s15,2);?> %</td>
			</tr>
            <tr>
				<td align="center">S16</td>
				<td align="right"><?php echo number_format($sumawl_s16,2);?></td>
				<td align="right"><?php echo number_format($sumnbm_s16,2);?></td>
				<td align="right"><?php echo number_format($sumary_s16,2);?></td>
				<td align="right"><?php echo number_format($target_s16,2);?></td>
				<td align="right"><?php echo number_format($percen_s16,2);?> %</td>
			</tr>
            <tr>
				<td align="center">S17</td>
				<td align="right"><?php echo number_format($sumawl_s17,2);?></td>
				<td align="right"><?php echo number_format($sumnbm_s17,2);?></td>
				<td align="right"><?php echo number_format($sumary_s17,2);?></td>
				<td align="right"><?php echo number_format($target_s17,2);?></td>
				<td align="right"><?php echo number_format($percen_s17,2);?> %</td>
			</tr>
            <tr>
				<td align="center">S21</td>
				<td align="right"><?php echo number_format($sumawl_s21,2);?></td>
				<td align="right"><?php echo number_format($sumnbm_s21,2);?></td>
				<td align="right"><?php echo number_format($sumary_s21,2);?></td>
				<td align="right"><?php echo number_format($target_s21,2);?></td>
				<td align="right"><?php echo number_format($percen_s21,2);?> %</td>
			</tr>
            <tr>
				<td align="center">S22</td>
				<td align="right"><?php echo number_format($sumawl_s22,2);?></td>
				<td align="right"><?php echo number_format($sumnbm_s22,2);?></td>
				<td align="right"><?php echo number_format($sumary_s22,2);?></td>
				<td align="right"><?php echo number_format($target_s22,2);?></td>
				<td align="right"><?php echo number_format($percen_s22,2);?> %</td>
			</tr>
            <tr>
				<td align="center">S23</td>
				<td align="right"><?php echo number_format($sumawl_s23,2);?></td>
				<td align="right"><?php echo number_format($sumnbm_s23,2);?></td>
				<td align="right"><?php echo number_format($sumary_s23,2);?></td>
				<td align="right"><?php echo number_format($target_s23,2);?></td>
				<td align="right"><?php echo number_format($percen_s23,2);?> %</td>
			</tr>
            <tr><td align="center">S24</td>
				<td align="right"><?php echo number_format($sumawl_s24,2);?></td>
				<td align="right"><?php echo number_format($sumnbm_s24,2);?></td>
				<td align="right"><?php echo number_format($sumary_s24,2);?></td>
				<td align="right"><?php echo number_format($target_s24,2);?></td>
				<td align="right"><?php echo number_format($percen_s24,2);?> %</td>
			</tr>

            <tr>
                <td align="center"><b><font color='#FF0000'>ยอดขายรวมทั้งหมด</font></b></td>
                <td align="right"><b><font color='#CC00FF'><?php echo number_format($sum_awl,2);?></font></b></td>
                <td align="right"><b><font color='#FF3399'><?php echo number_format($sum_nbm,2);?></font></b></td>
                <td align="right"><b><font color='#660099'><?php echo number_format($sum_all,2);?></font></b></td>
                <td align="right"><b><font color='#FF6600'><?php echo number_format($target,2);?></font></b></td>
                <td align="right"><b><font color='#339900'><?php echo number_format($percen,2);?> %</font></b></td>
            </tr>
        </table>

        <br><br>

        <style>
        .button1 {border-radius: 2px; background-color:#FF9999; padding:0.1px 0.1px; margin:0.5px 0.5px;}
        .button2 {border-radius: 2px; background-color:#FFFFFF; padding:0px 0px; margin:0px 0px;}
        .button3 {border-radius: 2px; background-color:#330066; padding:0.1px 0.1px; margin:0.5px 0.5px;}
        </style>

        <input class="button3" style="width:40px;height:20px"> : เปอร์เซ็นต์ยอดขาย
        <br><br>

<?php
    $dataPoints = array(
        array("y"=>$percen_s11, "color"=>"#330066", "label"=>"S11"),
        array("y"=>$percen_s12, "color"=>"#330066", "label"=>"S12"),
        array("y"=>$percen_s13, "color"=>"#330066", "label"=>"S13"),
        array("y"=>$percen_s14, "color"=>"#330066", "label"=>"S14"),
        array("y"=>$percen_s15, "color"=>"#330066", "label"=>"S15"),
        array("y"=>$percen_s16, "color"=>"#330066", "label"=>"S16"),
        array("y"=>$percen_s17, "color"=>"#330066", "label"=>"S17"),
        array("y"=>$percen_s21, "color"=>"#330066", "label"=>"S21"),
        array("y"=>$percen_s22, "color"=>"#330066", "label"=>"S22"),
        array("y"=>$percen_s23, "color"=>"#330066", "label"=>"S23"),
        array("y"=>$percen_s24, "color"=>"#330066", "label"=>"S24")
    );
?>

        <div id="chartContainer" style="height: 370px; width: 100%;"></div>
    </div>

<?php
}
?>

<script src="js/canvasjs.min.js"></script>
<script>
window.onload = function () {
    var el = document.getElementById('chartContainer');
    if (!el || typeof CanvasJS === 'undefined') return;

    var chart = new CanvasJS.Chart("chartContainer", {
        animationEnabled: true,
        theme: "light2",
        title: {
            text: "เปอร์เซ็นต์ยอดขาย"
        },
        axisY: {
            title: "เปอร์เซ็นต์"
        },
        data: [{
            type: "column",
            yValueFormatString: "#,##0.##",
            dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
        }]
    });
    chart.render();
};
</script>

</form>
</div>
</div>

<br>
<div id="cr_bar"><?php include "foot.php"; ?></div>

<?php
}
?>