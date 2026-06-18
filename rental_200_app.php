<link rel="stylesheet"type="text/css"href="sweetalert2/dist/sweetalert2.min.css"/>
<script src="sweetalert2/dist/sweetalert2.min.js"></script>
<?php
include 'dbconnect.php';
@session_start();


$ref_id = $_GET['ref_id'];
$status_key = $_GET['status_key'];
$undo_remark = $_GET['undo_remark'];
$add_md = $_SESSION['emid'];
$date_md = date('Y-m-d H:i:s');

    if($ref_id != '' && $undo_remark == '' && $status_key == '3' ){

        $yearMonth = substr(date("Y")+543, -2).date("m");
        $sql = "SELECT MAX(ren_id) AS MAXID FROM tb__rental";
        $qry = mysqli_query($new,$sql) or die(mysqli_error());
        $rs = mysqli_fetch_assoc($qry);
        $maxId = substr($rs['MAXID'], -3);
        $maxId3 = substr($rs['MAXID'],-7);//ตัดตัวหน้า 7 ตัว
        $maxId1 = substr($maxId3,0,-3);
        if($maxId1 == $yearMonth)
        {
        $maxId1 = ($maxId + 1);
        $maxId2 = substr("0000".$maxId1, -3);//ตัดตัวหลัง 3 ตัว
        $nextId = $yearMonth.$maxId2;
        }
        else 
        {
        $maxId1 = "001"; 
        $nextId = $yearMonth.$maxId1;
        }
        $ren_number = 'REN'.$nextId; 

        $in_main = " UPDATE tb__rental SET ren_id = '".$ren_number."' , status_key = '".$status_key."' , add_md = '".$add_md."' , date_md = '".$date_md."' WHERE ref_id = '".$ref_id."'  ";
        $qin_main = mysqli_query($new,$in_main);
    } else {
        $in_main = " UPDATE tb__rental SET status_key = '".$status_key."' , add_md = '".$add_md."' , date_md = '".$date_md."' WHERE ref_id = '".$ref_id."'  ";
        $qin_main = mysqli_query($new,$in_main);
    } 

    if($undo_remark != ''){
        $in_main = " UPDATE tb__rental SET  undo_remark = '".$undo_remark."' WHERE ref_id = '".$ref_id."'  ";
        $qin_main = mysqli_query($new,$in_main);
    }
    echo '<br>';
?>

<script>
let timerInterval;
Swal.fire({
  title: "ดำเนินการเสร็จสิ้น",
  timer: 1000,
  timerProgressBar: true,
  didOpen: () => {
    Swal.showLoading();
    const timer = Swal.getPopup().querySelector("b");
    timerInterval = setInterval(() => {
      timer.textContent = `${Swal.getTimerLeft()}`;
    }, 100);
  },
  willClose: () => {
    clearInterval(timerInterval);
  }
}).then((result) => {
  // ทำการเปลี่ยนหน้าไม่ว่าจะคลิกหรือเวลาหมด
  if (result.dismiss === Swal.DismissReason.timer || result.isDismissed) {
    console.log("Redirecting...");
    // window.history.back();
    window.location.href='rental_200_main.php';
  }
});
</script>