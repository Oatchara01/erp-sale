<script src="js/jquery-3.4.1.min.js" type="text/javascript"></script>
<script src="js/jquery-3.4.1.js" type="text/javascript"></script>
<link rel="stylesheet" href="css/w3.css">
<body>
<?php 
$sql = "SELECT * FROM (so__submain LEFT JOIN tb_product ON so__submain.product_ID=tb_product.product_id) WHERE ref_idd = '".$_GET["ref_id"]."' ";
$query = mysqli_query($conn,$sql) or die ("Error Query [".$sql."]");
?>
<table name="stock" id="stock" class="w3-table" border="0">
  <thead>
    <th>รหัสสินค้า</th>
    <th><font color="red">รหัสจัดสินค้า</font></th>
    <th>รายการสินค้า</th>
    <th>หน่วย</th>
    <th>จำนวน</th>
    <th><font color="red">จำนวน</font></th>
    <!--th>ราคาต่อหน่วย</th>
      <th>ส่วนลด</th>
    <th>ยอดรวม</th-->
    <th><font color="red">คลังสินค้า</font></th>
    <th>หมายเหตุ Sale</th>
    <th><font color="red">Lot No.</font></th>
    <th><font color="red">หมายเหตุ Stock</font></th>
    <th><font color="red">หมายเลขเครื่อง</font></th>
    <!--th>รายการปรับปรุงสินค้า</th>
      <th>เคลียร์ยืม</th-->
  </thead>
  <tbody>
    <?php
    $i=1;
    while ($fetch=mysqli_fetch_array($query,MYSQLI_ASSOC)) { 
      if($fetch["ckk_st"]=='0'){
    ?>
    <tr>
      <td style="width:10%;">   
        <input type="hidden" name="id[<?php echo $i?>]" class="w3-input w3-center" size="1%" value="<?php echo $fetch['id']; ?>">
        <input type="hidden" name="product_id[<?php echo $i?>]" id="product_id[<?php echo $i?>]" class="w3-input" size="8%" value="<?php echo $fetch['product_code'];?>">
        <input type="hidden" name="sol_code[<?php echo $i?>]" id="sol_code[<?php echo $i?>]" class="w3-input" size="8%" value="<?php echo $fetch['sol_code'];?>">
        <input type="text" name="product_code<?php echo $i?>" id="product_code<?php echo $i; ?>" class="w3-input" size="8%" value="<?php echo $fetch['sol_code'];?>" onpaste="return false" autocomplete=off >
      </td>
      <td style="width:10%;">
        <input name="product_code_same[<?php echo $i?>]" value="<?php echo $fetch['code_same'];?>" id="product_code_same<?php echo $i?>" type="text" class="w3-input" size="8%" onblur="JavaScript:fncAlert(<?php echo $i?>);" onkeypress="JavaScript:checkEnter(event, <?php echo $i?>);" onpaste="return false" autocomplete=off required>
        <input name="c2" id="c2" value="<?php echo $i; ?>" type="hidden">
      </td>
      <td style="width:20%;">
        <textarea name="product_name[<?php echo $fetch['id'];?>]" rows="3" id="product_name[<?php echo $fetch['id'];?>]" class="w3-input" readonly><?php echo $fetch['sol_name'];?></textarea>
        <input type="hidden" name="warranty[<?php echo $i?>]" class="w3-input" size="23%" value="<?php echo $fetch['warranty']; ?>" readonly>
        <input type="hidden" name="pm[<?php echo $i?>]" class="w3-input" size="23%" value="<?php echo $fetch['pm']; ?>" readonly>
        <input type="hidden" name="cal[<?php echo $i?>]" class="w3-input" size="23%" value="<?php echo $fetch['cal']; ?>" readonly>
      </td>
      <td><input type="text" name="unit_name[<?php echo $i?>]" class="w3-input w3-center" size="3%" value="<?php echo $fetch['unit_name']; ?>" readonly></td>
      <td><input type="text" name="sale_count<?php echo $i?>" id="sale_count<?php echo $i?>" class="w3-input w3-center" size="2%" value="<?php echo $fetch['sale_count']; ?>" readonly>
        <input type="hidden" name="count[<?php echo $i?>]" id="count[<?php echo $i?>]" class="w3-input w3-center" size="2%" value="<?php echo $fetch['sale_count']; ?>" readonly>
      </td>
      <td style="width:8%;">
        <input name="sale_count_same[<?php echo $i?>]" value="<?php echo $fetch['count_same'] == '0' ? '' : $fetch['count_same'];?>" id="sale_count_same<?php echo $i?>" type="text" class="w3-input" size="8%" onblur="JavaScript:fnc(<?php echo $i?>);" onkeypress="JavaScript:checkEnterCount(event, <?php echo $i?>);" onpaste="return false" autocomplete=off required>
        <input name="c3" id="c3" value="<?php echo $i; ?>" type="hidden">
      </td>
      <td style="width:8%;">
        <select name="store_name[<?php echo $i?>]" id="store_name[<?php echo $i?>]" class="w3-select">
          <option value="">**คลังสินค้า**</option>
          <?php
          $sql1 = "select * from tb_store where cancel ='0' order by store_id";
          $query1 = mysqli_query($stock,$sql1);
          while ($fetch1 = mysqli_fetch_array($query1,MYSQLI_ASSOC)) { 
            $sel = $fetch["store_name"] == $fetch1["store_id"] ? "selected" : "";
          ?>
          <option class="w3-bar-item w3-button" value="<?php echo $fetch1['store_id']; ?>" <?php echo $sel;?>><?php echo $fetch1['store_name']; ?></option>
          <?php } ?>
        </select>
      </td>
      <td style="width:10%;"><textarea name="sale_remarkk[<?php echo $i?>]" id="sale_remarkk[<?php echo $i?>]" class="w3-input" rows="3" onpaste="return false" autocomplete=off readonly><?php echo $fetch['sale_remark']; ?></textarea></td>
      <td style="width:8%;">
        <select name="lot_no[<?php echo $i?>]" id="lot_no[<?php echo $i?>]" class="w3-select">
          <?php
          $sql1 = "select * from st__lotno where close_ckk='0' and product_id='".$fetch['product_code']."' order by receive_date ASC";
          $query1 = mysqli_query($stock,$sql1);
          while ($fetch1 = mysqli_fetch_array($query1,MYSQLI_ASSOC)) { 
            $sel = $fetch["lot_no"] == $fetch1["lot_no"] ? "selected" : "";
          ?>
          <option class="w3-bar-item w3-button" value="<?php echo $fetch1['lot_no']; ?>" <?php echo $sel;?>><?php echo $fetch1['lot_no']; ?> (Exp.<?php echo Datethai($fetch1['date_expir']); ?>)</option>
          <?php } ?>
        </select>
        <input name="c4" id="c4" value="<?php echo $i; ?>" type="hidden">
      </td>
      <td><textarea name="stock_remark[<?php echo $i?>]" class="w3-input" rows="1"><?php echo $fetch['stock_remark']; ?></textarea></td>
      <td><textarea name="sn_number[<?php echo $i?>]" class="w3-input" rows="1" id="sn_number<?php echo $i?>" onpaste="return false" autocomplete=off><?php echo $fetch['sn_number']; ?></textarea>
        <input type='hidden' name="sn_ckk[<?php echo $i?>]" id="sn_ckk[<?php echo $i?>]" value="<?php echo $fetch["sn_ckk"];?>" class="w3-input">
      </td>
    </tr>
    <?php
      $i++;
      }
    }
    ?>
    <input name="hdnCount2" id="hdnCount2" value="<?php echo $i; ?>" type="hidden"> 
    <input name="hdnCount3" id="hdnCount3" value="<?php echo $i; ?>" type="hidden"> 
    <input name="hdnCount4" id="hdnCount4" value="<?php echo $i; ?>" type="hidden"> 
  </tbody>
</table>
</body>

<script language="javascript">
  function fncAlert(test) {
    var val1 = $('#product_code' + test).val();
    var val2 = $('#product_code_same' + test).val();
    if (val1 != val2) {
      alert("รหัสบาร์โค้ดไม่ตรงค่ะ!");
      $('#product_code_same' + test).val('');
      $('#product_code_same' + test).focus();
    } else {
      $('#sale_count_same' + test).focus();
    }
  }

  function fnc(test1) {
    var val3 = $('#sale_count' + test1).val();
    var val4 = $('#sale_count_same' + test1).val();
    if (val3 != val4) {
      alert("จำนวนไม่ตรงค่ะ!");
      $('#sale_count_same' + test1).val('');
      $('#sale_count_same' + test1).focus();
    }
  }

  function fncc(test2) {
    var val5 = $('#lot_lot' + test2).val();
    var val6 = $('#lot_no' + test2).val();
    if (val5 != val6) {
      alert("ข้อมูลLotสินค้าไม่ตรงค่ะ!");
      $('#lot_no' + test2).val('');
      $('#lot_no' + test2).focus();
    }
  }

  function checkEnter(event, test) {
    if (event.keyCode === 13) {
      event.preventDefault();
      fncAlert(test);
    }
  }

  function checkEnterCount(event, test) {
    if (event.keyCode === 13) {
      event.preventDefault();
      $('#sn_number' + test).focus();
    }
  }
</script>
