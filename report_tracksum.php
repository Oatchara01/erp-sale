<?php
include "head.php";
?>
<div class="w3-white">
    <div class="w3-container w3-padding-large">
        <div class="w3-container w3-bar w3-light-gray w3-margin-bottom">
            <h4>รายงานข้อมูลขนส่งประจำวัน</h4>
        </div>

        <form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
            <div class="w3-half">    
                <div class="w3-bar w3-quarter w3-third">
                    วันที่ :
                    <input name="start_date" class="w3-input" style="width:90%;" type="date" id="start_date" value="<?php echo $_GET["start_date"];?>" required>
                </div>
                <div class="w3-bar w3-quarter w3-third">
                    ช่องทางการขาย
                    <select name="sale_channel" id="sale_channel" class="w3-select" style="width:90%;" required>
                        <option value="">**โปรดเลือกช่องทางการขาย**</option>
                        <?php
                        $sqlchannel = "SELECT * FROM tb_salechannel ORDER BY salechannel_ID";
                        $querychannel = mysqli_query($conn, $sqlchannel);
                        while ($fetchchannel = mysqli_fetch_array($querychannel, MYSQLI_ASSOC)) {
                            $sel = ($_GET["sale_channel"] == $fetchchannel["salechannel_ID"]) ? "selected" : "";
                            echo "<option class='w3-bar-item w3-button' value='{$fetchchannel['salechannel_ID']}' $sel>{$fetchchannel['salechannel_nameshort']}</option>";
                        }
                        ?>
                    </select>    
                </div>    
                <div class="w3-margin-bottom w3-third">
                    <input type="submit" value="Search" class="w3-button w3-pale-red">
                </div>
            </div>
        </form>

        <br>
        <?php
        $start_date = $_GET["start_date"];
        $sale_channel = $_GET["sale_channel"];

        if ($start_date != '' && $sale_channel != '') {

            $sql12 = "SELECT salechannel_nameshort FROM tb_salechannel WHERE salechannel_ID = '$sale_channel'";
            $qry12 = mysqli_query($conn, $sql12) or die(mysqli_error());
            $rs12 = mysqli_fetch_assoc($qry12);    
        ?>

        <center><div class="w3-container"><h5>วันที่ : <?php echo Datethai($start_date); ?></h5></div>
        <div class="w3-container"><h5>ช่องทางการขาย : <?php echo $rs12["salechannel_nameshort"]; ?></h5></div></center>

        <?php if ($sale_channel == '1') { ?>

        <table border="1" width="100%" class="w3-table">
            <thead class="w3-gray">
                <th width="5%">เวลา</th>
                <th width="8%">ขนส่ง LEX TH</th>
                <th width="8%">ขนส่ง Flash Express</th> 
				<th width="8%">รวม</th> 
            </thead>

            <?php
            $strSQL = "SELECT DISTINCT DATE_FORMAT(register_time, '%H:%i') AS register_time FROM so__main WHERE sale_channel = '$sale_channel' AND cancel_ckk = '0' AND approve_complete = 'Approve'";

            if ($start_date != "") { 
                $strSQL .= " AND register_date = '$start_date'"; 
            }

            $strSQL .= " ORDER BY register_time ASC";    
	
            $objQuery = mysqli_query($conn, $strSQL) or die ("Error Query [".$strSQL."]");
            $sum1 = 0;
            $sum2 = 0;

            while ($objResult = mysqli_fetch_array($objQuery)) {
                $register_time = $objResult['register_time'];

                $strSQL1 = "SELECT DISTINCT order_id FROM so__main WHERE sale_channel = '$sale_channel' AND cancel_ckk = '0' AND approve_complete = 'Approve' AND register_time LIKE '$register_time%' and order_refer_code LIKE '%LEX%'";
                if ($start_date != "") { 
                    $strSQL1 .= " AND register_date = '$start_date'"; 
                }
				$objQuery1 = mysqli_query($conn, $strSQL1) or die(mysqli_error());
                $Num_Rows1 = mysqli_num_rows($objQuery1);

                $strSQL2 = "SELECT DISTINCT order_id FROM so__main WHERE sale_channel = '$sale_channel' AND cancel_ckk = '0' AND approve_complete = 'Approve' AND register_time LIKE '$register_time%'  and order_refer_code NOT LIKE '%LEX%'";
                if ($start_date != "") { 
                    $strSQL2 .= " AND register_date = '$start_date'"; 
                }
                $objQuery2 = mysqli_query($conn, $strSQL2) or die(mysqli_error());
                $Num_Rows2 = mysqli_num_rows($objQuery2);

                $sum1 += $Num_Rows1;
                $sum2 += $Num_Rows2;
            ?>
            <tr>
                <td><?php echo $register_time; ?></td>
                <td><?php echo $Num_Rows1; ?></td>
                <td><?php echo $Num_Rows2; ?></td>
				<td><?php echo $Num_Rows1+$Num_Rows2; ?></td>
            </tr>
            <?php } ?>

            <tr>
                <td bgcolor='yellow'>ยอดรวม</td>
                <td bgcolor='yellow' align="right"><?php echo $sum1; ?></td>    
                <td bgcolor='yellow' align="right"><?php echo $sum2; ?></td>    
				<td bgcolor='yellow' align="right"><?php echo $sum1+$sum2; ?></td>    
            </tr>    

        </table>
		
		     <?php }else if ($sale_channel == '34') { ?>

        <table border="1" width="100%" class="w3-table">
            <thead class="w3-gray">
                <th width="5%">เวลา</th>
                <th width="8%">ขนส่ง J.T Express</th>
                <th width="8%">ขนส่ง Flash Express</th>
				<th width="8%">ขนส่งปณ.ไทย</th>
				<th width="8%">รวม</th> 
            </thead>

            <?php
            $strSQL = "SELECT DISTINCT DATE_FORMAT(register_time, '%H:%i') AS register_time FROM so__main WHERE sale_channel = '$sale_channel' AND cancel_ckk = '0' AND approve_complete = 'Approve'";

            if ($start_date != "") { 
                $strSQL .= " AND register_date = '$start_date'"; 
            }

            $strSQL .= " ORDER BY register_time ASC";    
            $objQuery = mysqli_query($conn, $strSQL) or die ("Error Query [".$strSQL."]");
            $sum1 = 0;
            $sum2 = 0;
 			$sum3 = 0;
            while ($objResult = mysqli_fetch_array($objQuery)) {
                $register_time = $objResult['register_time'];
//and order_refer_code NOT LIKE '%THT%'  and order_refer_code NOT LIKE '%JA%'
                $strSQL1 = "SELECT DISTINCT order_id FROM so__main WHERE sale_channel = '$sale_channel' AND cancel_ckk = '0' AND approve_complete = 'Approve' AND register_time LIKE '$register_time%' and cs_remark LIKE '%J&T Express%'";
			
                if ($start_date != "") { 
                    $strSQL1 .= " AND register_date = '$start_date'"; 
                }
				
				$objQuery1 = mysqli_query($conn, $strSQL1) or die(mysqli_error());
                $Num_Rows1 = mysqli_num_rows($objQuery1);

                $strSQL2 = "SELECT DISTINCT order_id FROM so__main WHERE sale_channel = '$sale_channel' AND cancel_ckk = '0' AND approve_complete = 'Approve' AND register_time LIKE '$register_time%'  and cs_remark LIKE '%Flash Express Thailand%'";
                if ($start_date != "") { 
                    $strSQL2 .= " AND register_date = '$start_date'"; 
                }
				
                $objQuery2 = mysqli_query($conn, $strSQL2) or die(mysqli_error());
                $Num_Rows2 = mysqli_num_rows($objQuery2);
				
				$strSQL3 = "SELECT DISTINCT order_id FROM so__main WHERE sale_channel = '$sale_channel' AND cancel_ckk = '0' AND approve_complete = 'Approve' AND register_time LIKE '$register_time%'  and order_refer_code LIKE '%JA%'";
                if ($start_date != "") { 
                    $strSQL3 .= " AND register_date = '$start_date'"; 
                }
				
                $objQuery3 = mysqli_query($conn, $strSQL3) or die(mysqli_error());
                $Num_Rows3 = mysqli_num_rows($objQuery3);

                $sum1 += $Num_Rows1;
                $sum2 += $Num_Rows2;
				$sum3 += $Num_Rows3;
            ?>
            <tr>
                <td><?php echo $register_time; ?></td>
                <td><?php echo $Num_Rows1; ?></td>
                <td><?php echo $Num_Rows2; ?></td>
				<td><?php echo $Num_Rows3; ?></td>
				<td><?php echo $Num_Rows1+$Num_Rows2+$Num_Rows3; ?></td>
            </tr>
            <?php } ?>

            <tr>
                <td bgcolor='yellow'>ยอดรวม</td>
                <td bgcolor='yellow' align="right"><?php echo $sum1; ?></td>    
                <td bgcolor='yellow' align="right"><?php echo $sum2; ?></td>    
				<td bgcolor='yellow' align="right"><?php echo $sum3; ?></td>    
				<td bgcolor='yellow' align="right"><?php echo $sum1+$sum2+$sum3; ?></td>    
            </tr>    

        </table>
		
		     <?php }else if ($sale_channel == '12') { ?>

 <table border="1" width="100%" class="w3-table">
            <thead class="w3-gray">
                <th width="5%">เวลา</th>
                <th width="8%">ขนส่ง SPX Express</th>
				<th width="8%">ขนส่ง Flash Express</th>
				<th width="8%">ขนส่ง Express Delivery-ขนส่งดวน</th>
				<th width="8%">รวม</th> 
            </thead>

<?php
$strSQL = "SELECT DISTINCT DATE_FORMAT(register_time, '%H:%i') AS register_time FROM so__main WHERE sale_channel = '$sale_channel' AND cancel_ckk = '0' AND approve_complete = 'Approve'";

if ($start_date != "") { 
$strSQL .= " AND register_date = '$start_date'"; 
}
$strSQL .= " ORDER BY register_time ASC";    
$objQuery = mysqli_query($conn, $strSQL) or die ("Error Query [".$strSQL."]");
$sum1 = 0;
$sum2 = 0;
$sum3 = 0;
while ($objResult = mysqli_fetch_array($objQuery)) {
	
$register_time = $objResult['register_time'];

//Kerry Express
$strSQL1 = "SELECT DISTINCT order_id FROM so__main WHERE sale_channel = '$sale_channel' AND cancel_ckk = '0' AND approve_complete = 'Approve' AND register_time LIKE '$register_time%' and cs_remark LIKE '%SPX Express%'";
if ($start_date != "") { 
$strSQL1 .= " AND register_date = '$start_date'"; 
}
$objQuery1 = mysqli_query($conn, $strSQL1) or die(mysqli_error());
$Num_Rows1 = mysqli_num_rows($objQuery1);

$strSQL2 = "SELECT DISTINCT order_id FROM so__main WHERE sale_channel = '$sale_channel' AND cancel_ckk = '0' AND approve_complete = 'Approve' AND register_time LIKE '$register_time%' and cs_remark LIKE '%Flash Express%'";
if ($start_date != "") { 
$strSQL2 .= " AND register_date = '$start_date'"; 
}
$objQuery2 = mysqli_query($conn, $strSQL2) or die(mysqli_error());
$Num_Rows2 = mysqli_num_rows($objQuery2);
				
	
$strSQL3 = "SELECT DISTINCT order_id FROM so__main WHERE sale_channel = '$sale_channel' AND cancel_ckk = '0' AND approve_complete = 'Approve' AND register_time LIKE '$register_time%'  and cs_remark LIKE '%Express Delivery%' and register_time NOT LIKE '%15:0%'";
if ($start_date != "") { 
$strSQL3 .= " AND register_date = '$start_date'"; 
}

$objQuery3 = mysqli_query($conn, $strSQL3) or die(mysqli_error());
$Num_Rows3 = mysqli_num_rows($objQuery3);
	
$yesterday = date('Y-m-d', strtotime('-1 day', strtotime($start_date)));
	

$strSQL4 = "SELECT DISTINCT order_id FROM so__main WHERE sale_channel = '$sale_channel' AND cancel_ckk = '0' AND approve_complete = 'Approve' AND register_time LIKE '$register_time%'  and cs_remark LIKE '%Express Delivery%' and register_time LIKE '%15:%'";
if ($yesterday != "") { 
$strSQL4 .= " AND register_date = '$yesterday'"; 
}
$objQuery4 = mysqli_query($conn, $strSQL4) or die(mysqli_error());
$Num_Rows4 = mysqli_num_rows($objQuery4);

	
	
$sum1 += $Num_Rows1;
$sum2 += $Num_Rows2;
$sum3 += $Num_Rows3+$Num_Rows4;
	
?>
            <tr>
                <td><?php echo $register_time; ?></td>
                <td><?php echo $Num_Rows1; ?></td>
                <td><?php echo $Num_Rows2; ?></td>
				<td><?php echo $Num_Rows3+$Num_Rows4; ?></td>
				<td><?php echo $Num_Rows1+$Num_Rows2+$Num_Rows3; ?></td>
            </tr>
            <?php } ?>

            <tr>
                <td bgcolor='yellow'>ยอดรวม</td>
                <td bgcolor='yellow' align="right"><?php echo $sum1; ?></td>    
                <td bgcolor='yellow' align="right"><?php echo $sum2; ?></td>    
				<td bgcolor='yellow' align="right"><?php echo $sum3; ?></td> 
				
				<td bgcolor='yellow' align="right"><?php echo $sum1+$sum2+$sum3; ?></td>    
            </tr>    

        </table>
				

        <?php }    
        }    
        ?>

    </div>
</div>
<div id="cr_bar"><?php include "foot.php"; ?></div>
