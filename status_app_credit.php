<?php 

include('head.php');
include('dbconnect_sale.php');
include('dbconnect_acc.php');

?>

<style type="text/css">
<!--
.style15 {
	font-size: 18px; color: #000000;
}
.style30 {font-size: 12; }
.style32 {font-size: 11px}
.style33 {font-size: 12px; }
.style34 {color: #FF0000}
.style35 {font-size: 14px; color: #f2f2f2; }
.style37 {color: #FF0000; font-size: 14px; }
.style38 {color: #f2f2f2}
.style39 {font-size: 14px; color: #000000;}
.style40 {font-size: 14px; color: #FF0000; }
-->

.button {
    background-color: #339900;
    border: none;
    color: white;
    padding: 14px 16px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
}

.button1 {border-radius: 2px;}
.button2 {border-radius: 4px;}
.button3 {border-radius: 8px;}
.button4 {border-radius: 12px;}
.button5 {border-radius: 50%;}
</style>

<body>
<form method="GET" name="frmMain" enctype="multipart/form-data">
<div class="w3-white">
    <div class="w3-container w3-padding-large">
        <div class="w3-panel w3-light-gray">
            <div class="w3-half"><h4>ข้อมูลวงเงินลูกค้า (รออนุมัติ)</h4></div>
            <div class="w3-half"></div>
        </div>

<?php
include "dbconnect.php";
?>

<div class="w3-container">
    <table border="1" width="100%" class="w3-table">
        <thead class="w3-gray">
            <th width="5%">ID ลูกค้า</th>
            <th width="5%">รหัสลูกค้า AWL</th>
            <th width="5%">รหัสลูกค้า NBM</th>
            <th width="8%">ประเภทลูกค้า</th>
            <th width="10%">ชื่อลูกค้า</th>
            <th width="10%">ชื่อออกบิล</th>
            <th width="5%">VIP</th>
            <th width="8%">การชำระเงิน</th>
            <th width="10%">วงเงิน (เดิม)</th>
			  <th width="10%"><font color="red">วงเงิน (ใหม่)</font></th>
            <th width="10%"><font color="red">ข้อมูลการแก้ไข</font></th>
            <th width="5%">ไฟล์แนบ</th>
            <?php if ($_SESSION['name']=='ชลชินี' or $_SESSION['name']=='อัจฉรา') { ?>
            <th width="5%">การอนุมัติ</th>
            <?php } ?>
        </thead>

<?php
$strSQL = "SELECT * FROM tb_customer_credit WHERE status_credit = 'Request'";
$objQuery = mysqli_query($conn, $strSQL) or die("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);

$Per_Page = 20;
$Page = isset($_GET['Page']) ? (int)$_GET['Page'] : 1;
if ($Page <= 0) {
    $Page = 1;
}

$Prev_Page = $Page - 1;
$Next_Page = $Page + 1;

$Page_Start = (($Per_Page * $Page) - $Per_Page);

if ($Num_Rows <= $Per_Page) {
    $Num_Pages = 1;
} else if (($Num_Rows % $Per_Page) == 0) {
    $Num_Pages = ($Num_Rows / $Per_Page);
} else {
    $Num_Pages = ($Num_Rows / $Per_Page) + 1;
    $Num_Pages = (int)$Num_Pages;
}

$strSQL .= " ORDER BY customer_id DESC LIMIT $Page_Start, $Per_Page";
$objQuery  = mysqli_query($conn, $strSQL);

while($objResult = mysqli_fetch_array($objQuery))
{
    $sql21 = "SELECT * FROM tb_customer WHERE customer_id = '".$objResult["customer_id"]."'";
    $qry21 = mysqli_query($conn, $sql21) or die(mysqli_error($conn));
    $rs21 = mysqli_fetch_assoc($qry21);
    
    $sql23 = "SELECT * FROM tb_typecustomer WHERE type_id = '".$rs21["type_customer"]."'";
    $qry23 = mysqli_query($conn, $sql23) or die(mysqli_error($conn));
    $rs23 = mysqli_fetch_assoc($qry23);    

    $sql24 = "SELECT pay_in FROM tb_bank WHERE id = '".$objResult["credit_ckk"]."'";
    $qry24 = mysqli_query($code, $sql24) or die(mysqli_error($code));
    $rs24 = mysqli_fetch_assoc($qry24);
	
	$sql20 = "SELECT * FROM tb_cuscredit_upfile WHERE cus_id = '".$objResult["customer_id"]."'";
    $qry20 = mysqli_query($conn, $sql20) or die(mysqli_error($conn));
    $rs20 = mysqli_fetch_assoc($qry20);
?>
        <tbody>
            <tr>
                <?php if($objResult["close_ckk"]=='1'){ ?>
                    <td bgcolor="#FF0000">
                <?php } else { ?>
                    <td>
                <?php } ?>
                    <?php echo $objResult["customer_id"];?>
                </td>

                <td><?php echo $rs21["customer_code"];?></td>
                <td><?php echo $rs21["customer_coden"];?></td>
                <td><?php echo $rs23["type_name"];?></td>
                <td><?php echo $objResult["customer_name"];?></td>
                <td><?php echo $rs21["bill_name"];?></td>

                <?php if($rs21["vip_ckk"]=='1'){ ?>
                    <td bgcolor="#00FF00">VIP</td>
                <?php } else { ?>
                    <td></td>
                <?php } ?>

                <td><?php echo $rs24["pay_in"]; ?></td>
                <td><?php echo number_format($rs21["credit_thb"], 2); ?></td>
				<td><?php echo number_format($objResult["credit_thb"], 2); ?></td>
                <td><?php echo $objResult["remark_edit"]; ?></td>
                <td>
                    <?php if($rs20['img_up1']!=''){ ?>
                        <a href="up_cuscredit/<?php echo $rs20['img_up1']; ?>" target="_blank">
                            <img src="img/create.png" width="23" height="23" border="0" />
                        </a><br>
                    <?php } ?><br>

                    <?php if($rs20['img_up2']!=''){ ?>
                        <a href="up_cuscredit/<?php echo $rs20['img_up2']; ?>" target="_blank">
                            <img src="img/create.png" width="23" height="23" border="0" />
                        </a><br>
                    <?php } ?><br>

                    <?php if($rs20['img_up3']!=''){ ?>
                        <a href="up_cuscredit/<?php echo $rs20['img_up3']; ?>" target="_blank">
                            <img src="img/create.png" width="23" height="23" border="0" />
                        </a>
                    <?php } ?>
                </td>    

                <?php if ($_SESSION['name']=='ชลชินี' or $_SESSION['name']=='อัจฉรา') { ?>                
                <td>
                    <a href="javascript:void(0)"
                       onclick="openApproveModal(<?php echo (int)$objResult['id_cus']; ?>, '<?php echo number_format((float)$objResult['credit_thb'], 2, '.', ''); ?>')"
                       class="w3-button w3-green w3-center">
                       <font color="white">Approve</font>
                    </a>    

                    <br><br>

                    <a href="javascript:void(0)"
                       onclick="openRejectModal(<?php echo (int)$objResult['id_cus']; ?>)"
                       class="w3-button w3-red w3-center">
                       <font color="white">Reject</font>
                    </a>
                </td>
                <?php } ?>
            </tr>
        </tbody>
<?php
}
?>
    </table>

    <div class="w3-panel">
        <strong>พบทั้งหมด</strong> <?= $Num_Rows;?>
        <strong>รายการ<span class="style14"> :</span>จำนวน</strong>
        <?= $Num_Pages;?>
        <strong>หน้า<span class="style14"> :</span></strong>
        <?php
        $Keyword  = isset($Keyword) ? $Keyword : '';
        $Keyword1 = isset($Keyword1) ? $Keyword1 : '';
        $Keyword2 = isset($Keyword2) ? $Keyword2 : '';
        $Keyword3 = isset($Keyword3) ? $Keyword3 : '';
        $Keyword4 = isset($Keyword4) ? $Keyword4 : '';
        $Keyword5 = isset($Keyword5) ? $Keyword5 : '';
        $Keyword6 = isset($Keyword6) ? $Keyword6 : '';
        $bill_name = isset($bill_name) ? $bill_name : '';

        if($Prev_Page)
        {
            echo " <a href='".$_SERVER['SCRIPT_NAME']."?Page=".$Prev_Page."&Keyword=".$Keyword."&Keyword1=".$Keyword1."&Keyword2=".$Keyword2."&Keyword3=".$Keyword3."&Keyword4=".$Keyword4."&Keyword5=".$Keyword5."&bill_name=".$bill_name."&Keyword6=".$Keyword6."'><span class='style40'><< Back</span></a> ";
        }

        for($i=1; $i<=$Num_Pages; $i++){
            if($i != $Page)
            {
                echo "[ <a href='".$_SERVER['SCRIPT_NAME']."?Page=".$i."&Keyword=".$Keyword."&Keyword1=".$Keyword1."&Keyword2=".$Keyword2."&Keyword3=".$Keyword3."&Keyword4=".$Keyword4."&bill_name=".$bill_name."&Keyword5=".$Keyword5."&Keyword6=".$Keyword6."'><span class='style40'>".$i."</span></a> ]";
            }
            else
            {
                echo "<b> ".$i." </b>";
            }
        }

        if($Page != $Num_Pages)
        {
            echo " <a href='".$_SERVER['SCRIPT_NAME']."?Page=".$Next_Page."&Keyword=".$Keyword."&Keyword1=".$Keyword1."&Keyword2=".$Keyword2."&Keyword3=".$Keyword3."&Keyword4=".$Keyword4."&bill_name=".$bill_name."&Keyword5=".$Keyword5."&Keyword6=".$Keyword6."'><span class='style40'>Next>></span></a> ";
        }
        ?>
    </div>
</div>
</div>
</div>

<div id="cr_bar"><?php include "foot.php"; ?></div>
</form>

<div id="rejectModal" class="w3-modal">
  <div class="w3-modal-content w3-animate-top w3-card-4" style="max-width:600px;">
    <header class="w3-container w3-red">
      <span onclick="closeRejectModal()" class="w3-button w3-display-topright">&times;</span>
      <h3>Reject Credit</h3>
    </header>

    <div class="w3-container" style="padding-top:16px;">
      <p><b>กรอกหมายเหตุสำหรับการ Reject</b></p>
      <textarea id="rejectNote" class="w3-input w3-border" rows="6" placeholder="พิมพ์หมายเหตุ..."></textarea>
      <p id="rejectErr" class="w3-text-red" style="display:none; margin-top:8px;">
        กรุณากรอกหมายเหตุ
      </p>
    </div>

    <footer class="w3-container" style="padding:16px;">
      <button type="button" class="w3-button w3-grey" onclick="closeRejectModal()">ยกเลิก</button>
      <button type="button" class="w3-button w3-red w3-right" onclick="confirmReject()">ตกลง</button>
    </footer>
  </div>
</div>

<div id="approveModal" class="w3-modal">
  <div class="w3-modal-content w3-animate-top w3-card-4" style="max-width:600px;">
    <header class="w3-container w3-green">
      <span onclick="closeApproveModal()" class="w3-button w3-display-topright">&times;</span>
      <h3>Approve Credit</h3>
    </header>

    <div class="w3-container" style="padding-top:16px;">
      <p><b>จำนวนเงินที่อนุมัติ</b></p>
      <input type="text" id="approveAmount" class="w3-input w3-border"
             placeholder="กรอกจำนวนเงิน" style="text-align:right;"
             onkeyup="formatNumber(this)"
             onblur="formatNumber(this)">
      <p id="approveErr" class="w3-text-red" style="display:none; margin-top:8px;">
        กรุณากรอกจำนวนเงินให้ถูกต้อง
      </p>
    </div>

    <footer class="w3-container" style="padding:16px;">
      <button type="button" class="w3-button w3-grey" onclick="closeApproveModal()">ยกเลิก</button>
      <button type="button" class="w3-button w3-green w3-right" onclick="confirmApprove()">ยืนยัน</button>
    </footer>
  </div>
</div>

<script>
  let rejectIdCus = null;
  let approveIdCus = null;

  function openRejectModal(id_cus){
    rejectIdCus = id_cus;
    document.getElementById('rejectNote').value = '';
    document.getElementById('rejectErr').style.display = 'none';
    document.getElementById('rejectModal').style.display = 'block';
    setTimeout(function() {
      document.getElementById('rejectNote').focus();
    }, 50);
  }

  function closeRejectModal(){
    document.getElementById('rejectModal').style.display = 'none';
    rejectIdCus = null;
  }

  function confirmReject(){
    const noteEl = document.getElementById('rejectNote');
    const errEl  = document.getElementById('rejectErr');
    const note   = noteEl.value.trim();

    if(!note){
      errEl.style.display = 'block';
      noteEl.focus();
      return;
    }

    errEl.style.display = 'none';

    const url = "reject_credit.php?id_cus=" + encodeURIComponent(rejectIdCus)
              + "&note=" + encodeURIComponent(note);

    window.open(url, "_blank");
    closeRejectModal();
  }

  function openApproveModal(id_cus, creditAmount){
    approveIdCus = id_cus;

    let value = String(creditAmount || '').replace(/,/g, '').trim();
    if(value !== '' && !isNaN(value)){
      value = Number(value).toLocaleString('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
      });
    }

    document.getElementById('approveAmount').value = value;
    document.getElementById('approveErr').style.display = 'none';
    document.getElementById('approveModal').style.display = 'block';

    setTimeout(function() {
      document.getElementById('approveAmount').focus();
    }, 50);
  }

  function closeApproveModal(){
    document.getElementById('approveModal').style.display = 'none';
    approveIdCus = null;
  }

  function formatNumber(input) {
    let value = input.value.replace(/,/g, '').trim();

    if (value === '') {
      input.value = '';
      return;
    }

    if (!isNaN(value)) {
      input.value = Number(value).toLocaleString('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
      });
    }
  }

  function confirmApprove(){
    const amountEl = document.getElementById('approveAmount');
    const errEl = document.getElementById('approveErr');

    let amount = amountEl.value.replace(/,/g,'').trim();

    if(!amount || isNaN(amount) || parseFloat(amount) < 0){
      errEl.style.display = 'block';
      amountEl.focus();
      return;
    }

    errEl.style.display = 'none';

    const url = "app_credit.php?id_cus=" + encodeURIComponent(approveIdCus)
              + "&credit_amount=" + encodeURIComponent(amount);

    window.open(url, "_blank");
    closeApproveModal();
  }

  window.addEventListener('click', function(e){
    const rejectModal = document.getElementById('rejectModal');
    const approveModal = document.getElementById('approveModal');

    if(e.target === rejectModal) closeRejectModal();
    if(e.target === approveModal) closeApproveModal();
  });

  window.addEventListener('keydown', function(e){
    if(e.key === "Escape"){
      const rejectModal = document.getElementById('rejectModal');
      const approveModal = document.getElementById('approveModal');

      if(rejectModal.style.display === 'block') closeRejectModal();
      if(approveModal.style.display === 'block') closeApproveModal();
    }
  });
</script>

</body>
</html>