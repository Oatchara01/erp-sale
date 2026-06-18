<link rel="stylesheet"type="text/css"href="sweetalert2/dist/sweetalert2.min.css"/>
<script src="sweetalert2/dist/sweetalert2.min.js"></script>
<?php
include 'dbconnect.php';
@session_start();


$ref_id = $_POST['ref_id'];
$remark_stock = $_POST['remark_stock'];
$product_IDs = $_POST['product_ID'];
$wr_counts = $_POST['wr_count'];
$remarks = $_POST['remark'];
$row_nums = $_POST['row_num'];
    if($ref_id != ''){
        $in_main = " UPDATE tb__rental SET  remark_stock = '".$remark_stock."' WHERE ref_id = '".$ref_id."'  ";
        $qin_main = mysqli_query($stock,$in_main);
    }
foreach ($row_nums as $key => $value) {
    $product_ID = $product_IDs[$key];
    $wr_count = $wr_counts[$key];
    $remark = $remarks[$key];

    if($ref_id != ''){
        $in_item = "INSERT INTO tb__rental_item(ref_id,product_ID,wr_count,add_by,add_date,remark) VALUES('".$ref_id."','".$product_ID."','".$wr_count."','".$add_by."','".$add_date."','".$remark."')";
        $qin_item = mysqli_query($stock,$in_item);
    }
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
    window.location.href="rental_200_edit.php?ref_id=<?php echo $ref_id;?>";
  }
});
</script>