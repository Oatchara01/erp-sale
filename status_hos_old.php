<?php include('head.php'); ?>
<!DOCTYPE html>
<html>
 <head>
 <link rel="stylesheet" href="css/bootstrap.min.css">
 <link rel="stylesheet" href="css/bootstrap-theme.min.css">
 <link rel="stylesheet" href="css/w3.css">
 </head>
 <body style="margin-top: 10px;">
 <div class="w3-container w3-margin-top w3-margin-bottom">
	<div class="w3-bar w3-third">
		<span>วันที่</span>
		<input type="date" name="start_date" class="w3-input w3-third" value="<?php echo isset($start_date); ?>">
	</div>
	<div class="w3-third w3-bar">
		<span>ถึงวันที่</span>
		<input type="date" name="end_date" class="w3-input w3-third" value="<?php echo isset($end_date); ?>">
	</div>
	<div class="w3-third w3-container">
		<span>ค้นหา</span>
		<input type="text" name="keyword" class="w3-input w3-third" value="<?php echo isset($keyword); ?>">
	</div>
	<div class="w3-margin-bottom"></div>
 <?php
 include("dbconnect.php");
 $perpage = 10;
 if (isset($_GET['page'])) {
 $page = $_GET['page'];
 } else {
 $page = 1;
 }

 $start = ($page - 1) * $perpage;

 $sql = "select * from hos__so limit {$start} , {$perpage} ";
 $query = mysqli_query($conn, $sql);
 ?>
 <div class="container">
 <div class="row">
 <div class="col-lg-12">
 <table class="table table-bordered table-hover">
 <thead>
 <tr>
 <th>#</th>
 <th>Ref. ID</th>
 <th>Date</th>
 <th>Prodoct Code ||| Detail</th>
 </tr> 
 </thead>
 <tbody>
 <?php while ($result = mysqli_fetch_assoc($query)) { ?>
 <tr>
 <td><?php echo $result['main_id']; ?></td>
 <td><a href="admin_sale_hos.php?ref_id=<?php echo $result['ref_id']; ?>"><?php echo $result['ref_id']; ?></a></td>
 <td><?php echo $result['date']; ?></td>
 <td><?php $id=$result['ref_id'];
		   $pd=mysqli_query($conn,"select * from hos__subso left join tb_product on (hos__subso.product_id=tb_product.product_ID) where ref_id='$id'");
		   while($fpd=mysqli_fetch_array($pd)){
			   echo "<b>".$fpd["access_code"]."</b> ||| ".$fpd["access_name"]."<br>";
		   }
	 ?>
 </td>
 </tr>
 <?php } ?>
 </tbody>
 </table>
 <?php
 $sql2 = "select * from hos__so ";
 $query2 = mysqli_query($conn, $sql2);
 $total_record = mysqli_num_rows($query2);
 $total_page = ceil($total_record / $perpage);
 ?>

 <nav>
 <ul class="pagination">
 <li>
 <a href="index.php?page=1" aria-label="Previous">
 <span aria-hidden="true">&laquo;</span>
 </a>
 </li>
 <?php for($i=1;$i<=$total_page;$i++){ ?>
 <li><a href="index.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
 <?php } ?>
 <li>
 <a href="index.php?page=<?php echo $total_page;?>" aria-label="Next">
 <span aria-hidden="true">&raquo;</span>
 </a>
 </li>
 </ul>
 </nav>
 </div>
 </div>
 </div> <!-- /container -->
 <script src="js/bootstrap.min.js"></script>
 </body>
</html>
<?php include('foot.php'); ?>
</body>
</html>