<?php 
include('head.php'); 
require_once __DIR__ . "/Methos_User.php";

$ref_id = $_GET['ref_id'];

$rental = "SELECT * FROM tb__rental WHERE ref_id = '".$ref_id."' ";
$qrental = mysqli_query($stock,$rental);
$vrental = mysqli_fetch_array($qrental);

?>
<!-- ลำดับขั้นตอนที่ 5 -->
<!DOCTYPE html>
<html lang="en">
<style>
    td:nth-child(1) {
        text-align: center;
        vertical-align:middle;
    }
</style>
<body>
    
<div class="w3-container w3-padding-large" style="background-color: white;">
    <div class="w3-light-grey" style="display: flex; justify-content: space-between; ">
            <span><h3>อนุมัติใบเบิกเป็นสินค้าเช่า</h3></span> 
            <?php if($vrental['status_key'] == '2') { ?>
            <span>
                <a href="rental_200_app.php?status_key=4&ref_id=<?php echo $ref_id;?>" class="w3-button w3-red" >ไม่อนุมัติ</a>
                <button onclick="document.getElementById('id01').style.display='block'" class="w3-button w3-yellow">ส่งกลับ</button>
                <a href="rental_200_app.php?status_key=3&ref_id=<?php echo $ref_id;?>" class="w3-button w3-teal" >อนุมัติ</a>
            </span>
            <?php } ?>
    </div>
    <form action="rental_200_edit1.php" method="post">
    <div class="w3-container ">
        <div class="row">
            <div class="w3-col" style="width:48%; padding: 0px 0px 58px 0px;">
                        เลขที่อ้างอิง
                        <input type="text" class="w3-input w3-border w3-center" style="color: #ff8080;" name="ref_id" id="ref_id" value="<?php echo $ref_id;?>" readonly>
                <div class="row">
                    <div class="w3-col" style="width:48%; " >
                        ผู้ออกเอกสาร
                        <input type="text" class="w3-input w3-border w3-center"  name="add_by" id="add_by" value="<?php echo username($stock,$vrental['add_by']);?>" disabled>
                    </div>
                    <div class="w3-col" style="width:48%; margin-left:4%;" >
                        ผู้ออกเอกสารวันที่
                        <input type="text" class="w3-input w3-border w3-center" name="add_date" id="add_date" value="<?php echo Date_thai_time($vrental['add_date']);?>" disabled>
                    </div>
                </div>
                
                
            </div>
            <div class="w3-col" style="width:48%; margin-left:4%;">
                หมายเหตุ
                <textarea class="w3-input w3-border" name="remark_stock" id="remark_stock" rows="4" placeholder="ระบุข้อมูล . . ."><?php echo $vrental['remark_stock'];?></textarea>
                



            </div>
        </div>
        <!--  -->
        <br><br>
            <table width='100%' border='1' class='w3-table w3-bordered' id="myTable">
            <tr class='w3-light-grey'>
                <th style="width:20%; text-align:center;">รหัสสินค้า</th>
                <th style="width:40%; text-align:center;">ชื่อรายการ</th>
                <th style="width:10%; text-align:center;">จำนวน</th>
                <th style="width:30%; text-align:center;">หมายเหตุ</th>
            </tr>
            <?php 
                $query = "
                    SELECT p.sol_name,p.access_code,r.wr_count,r.remark,r.product_ID
                    FROM tb__rental_item r
                    INNER JOIN tb_product p ON r.product_ID = p.product_ID
                    WHERE r.ref_id = '".$ref_id."'
                ";
                $result = mysqli_query($stock, $query);
                
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                       <td><?php echo  $row['access_code'];?></td>
                       <td style="text-align: left;"><?php echo  $row['sol_name'];?></td>
                       <td><?php echo  $row['wr_count'];?></td>
                       <td style="text-align: left;"><?php echo  $row['remark'];?></td>
                    </tr>
                <?php } ?>
            <tr></tr>
        </table>
        <br><br><br><br><br><br><br><br>
        
    </div>
    </form>
    
    
</div>
    <?php include('foot.php'); ?>
</body>
</html>

<!-- Modal HTML -->
<div id="id01" class="w3-modal">
    <div class="w3-modal-content w3-card-4">
      <header class="w3-container"> 
        <span onclick="document.getElementById('id01').style.display='none'" 
        class="w3-button w3-red w3-display-topright" style="font-size: 42px;">&times;</span>
        <h4>รายละเอียดส่งกลับแก้ไข</h4>
      </header>
      <form action="rental_200_app.php" method="get">
        <div class="w3-container w3-padding-16">
            
                <input type="hidden" name="status_key" value="1">
                <input type="hidden" name="ref_id" value="<?php echo $ref_id;?>">
                <textarea class="w3-input" name="undo_remark" id="undo_remark" rows="10" placeholder="กรุณาระบุข้อมูล. . ."></textarea>
        </div>
        <footer class="w3-center w3-padding-16">
            <button type="submit" class="w3-button w3-yellow">ส่งกลับ</button>
        </footer>
      </form>
    </div>
</div>

<script>
// Get the modal
var modal = document.getElementById('id01');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}

function showCustomer(str, targetId, key) {
  if (str == "") {
    document.getElementById(targetId).innerHTML = "";
    return;
  }
  const xhttp = new XMLHttpRequest();
  xhttp.onload = function() {
    document.getElementById(targetId).innerHTML = this.responseText;
  }
  xhttp.open("GET", "rental_200_create_ajax.php?q=" + str +"&key="+ key);
  xhttp.send();
}
</script>