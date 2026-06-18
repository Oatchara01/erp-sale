<?php include("head.php"); ?>
<body>
<div class="w3-container">
	<div class="w3-panel w3-light-grey"><h2>สถานะใบสั่งขาย (SO)</h2></div>
	<?php
	ini_set('display_errors', 1);

	$keyword = null;
	$start_date = null;
	$end_date = null;

	if(isset($_POST["keyword"]))
	{
		$keyword = $_POST["keyword"];
	}
	if(isset($_GET["keyword"]))
	{
		$keyword = $_GET["keyword"];
	}
	if(isset($_POST["start_date"]))
	{
		$start_date = $_POST["start_date"];
	}
	if(isset($_GET["start_date"]))
	{
		$start_date = $_GET["start_date"];
	}
		if(isset($_POST["end_date"]))
	{
		$end_date = $_POST["end_date"];
	}
	if(isset($_GET["end_date"]))
	{
		$end_date = $_GET["end_date"];
	}
	?>
	<form name="frmSearch" method="post" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
		<div class="w3-bar w3-margin-top w3-margin-bottom">
			<div class="w3-quarter">
				<span class="w3-bold">วันที่</span>
				<input type="date" name="start_date" class="w3-input" style="width:90%;" value="<?php echo $start_date; ?>">
			</div>
			<div class="w3-quarter">
				<span class="w3-bold">ถึงวันที่</span>
				<input type="date" name="end_date" class="w3-input" style="width:90%;" value="<?php echo $end_date; ?>">
			</div>
			<div class="w3-quarter">
				<span class="w3-bold">คำที่ค้นหา</span>
				<input type="text" name="keyword" class="w3-input" style="width:90%;" value="<?php echo $keyword; ?>">
			</div>
			<div class="w3-quarter">
				<input type="submit" name="Search" class="w3-button w3-pale-red">
			</div>
		</div>
	</form>
	<table id="myTable" class="w3-table w3-striped w3-bordered" border=1>
		<thead>
			<th style="width:5%" onclick="sortTable(0)">เลขที่ IV</th>
			<th style="width:5%" onclick="sortTable(1)">เลขที่อ้างอิง</th>
			<th style="width:10%" onclick="sortTable(2)">วันที่ลงทะเบียน</th>
			<th style="width:30%" onclick="sortTable(3)">ชื่อที่ออกบิล</th>
			<th style="width:30%" onclick="sortTable(4)">รหัส / ชื่อสินค้า</th>
			<th style="width:20%" onclick="sortTable(5)">เขตการขาย</th>
			<th style="width:5%" onclick="sortTable(6)">สถานะ</th>
			<th style="width:5%"></th>
		</thead>
		<tbody>
			<?php
				$perpage = 10;
				if (isset($_GET['page'])) {
					$page = $_GET['page'];
				} else {
					$page = 1;
				}
				$start = ($page - 1) * $perpage;

				$sol = "select * from hos__so where status='0' or status='1' or status='2' or status='3' or status='4' or status='5'";
				if($start_date&&$end_date!="0000-00-00"){
				$sol .= "and date between '".$start_date."' and '".$end_date."'";
				}
				if($keyword!=""){
				$sol .= "and bill_name like '%".$keyword."%'";
				}				
				$sol .= "order by id desc limit {$start},{$perpage}";
				$query = mysqli_query($conn,$sol);
				while ($result = mysqli_fetch_array($query)) { ?>
				<tr>
					 <td><?php echo $result['iv_no']; ?></td>
					 <td><?php echo $result['ref_id']; ?></td>
					 <td><?php echo datethai($result['date']); ?></td>
					 <td style="text-align:left;"><?php echo $result['bill_name']; ?></td>
					 <td style="text-align:left;"><?php $id=$result['ref_id'];
							   $pd=mysqli_query($conn,"select * from hos__subso left join tb_product on (hos__subso.product_id=tb_product.product_ID) where ref_id='$id'");
							   while($fpd=mysqli_fetch_array($pd)){
								   echo "<b>".$fpd["access_code"]."</b> / ".$fpd["access_name"]."<br>";
							   }?>
					 </td>
					 <td><?php echo $result['sale']; ?></td>
					 <?php if($result['status']==0) { ?><td class="w3-pale-green">Request</td><?php } ?>
					 <?php if($result['status']==1) { ?><td class="w3-pale-yellow">Approved</td><?php } ?>
					 <?php if($result['status']==2) { ?><td class="w3-pale-red">Rejected</td><?php } ?>
					 <?php if($result['status']==3) { ?><td class="w3-pale-blue">Complete</td><?php } ?>
					 <td><a href="hos_so_view.php?id=<?php echo $result["id"]; ?>">View</a> <a href="hos_so_edit.php?id=<?php echo $result["id"]; ?>">Edit</a></td>
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

<div class="w3-bar w3-margin-top">
  <a href="status_hos_admin.php?page=1" class="w3-button w3-light-grey">&laquo;</a>
  <?php for($i=1;$i<=$total_page;$i++){ ?>
  <a href="status_hos_admin.php?page=<?php echo $i; ?>" class="w3-button w3-light-grey"><?php echo $i; ?></a>
  <?php } ?>
  <a href="status_hos_admin.php?page=<?php echo $total_page;?>" class="w3-button w3-light-grey" aria-label="Next">
 <span aria-hidden="true">&raquo;</span>
 </a>
</div>
<?php include("foot.php"); ?>
<script>
function sortTable(n) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("myTable");
  switching = true;
  //Set the sorting direction to ascending:
  dir = "asc"; 
  /*Make a loop that will continue until
  no switching has been done:*/
  while (switching) {
    //start by saying: no switching is done:
    switching = false;
    rows = table.rows;
    /*Loop through all table rows (except the
    first, which contains table headers):*/
    for (i = 1; i < (rows.length - 1); i++) {
      //start by saying there should be no switching:
      shouldSwitch = false;
      /*Get the two elements you want to compare,
      one from current row and one from the next:*/
      x = rows[i].getElementsByTagName("TD")[n];
      y = rows[i + 1].getElementsByTagName("TD")[n];
      /*check if the two rows should switch place,
      based on the direction, asc or desc:*/
      if (dir == "asc") {
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
          //if so, mark as a switch and break the loop:
          shouldSwitch= true;
          break;
        }
      } else if (dir == "desc") {
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
          //if so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
        }
      }
    }
    if (shouldSwitch) {
      /*If a switch has been marked, make the switch
      and mark that a switch has been done:*/
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      //Each time a switch is done, increase this count by 1:
      switchcount ++;      
    } else {
      /*If no switching has been done AND the direction is "asc",
      set the direction to "desc" and run the while loop again.*/
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
}
</script>
</body>
</html>