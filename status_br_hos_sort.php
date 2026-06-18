<?php include("head.php");
	$perpage = 10;
	if (isset($_GET['page'])) {
		$page = $_GET['page'];
	} else {
		$page = 1;
	}
	$start = ($page - 1) * $perpage;

	$sol = "select * from hos__br order by id asc limit {$start} , {$perpage}";
	$query = mysqli_query($conn,$sol);
?>
<body>
<div class="w3-container">
	<div class="w3-panel w3-light-grey"><h2>สถานะใบสั่งพิมพ์ใบเบิกจ่ายสินค้า (BR)</h2></div>
	<div style="overflow-x:auto;"><table id="myTable" class="w3-table w3-striped w3-bordered" border=1>
		<thead>
			<th style="width:5%" onclick="sortTable(0)">เลขที่อ้างอิง</th>
			<th style="width:20%" onclick="sortTable(1)">วันที่ลงทะเบียน</th>
			<th style="width:30%" onclick="sortTable(2)">ชื่อลูกค้า</th>
			<th style="width:40%" onclick="sortTable(3)">รหัส / ชื่อสินค้า</th>
			<th style="width:5%" onclick="sortTable(5)">สถานะ</th>
		</thead>
		<tbody>
			<?php while ($result = mysqli_fetch_assoc($query)) { ?>
				<tr>
					 <td><?php echo $result['ref_id']; ?></td>
					 <td><?php echo datethai($result['date']); ?></td>
					 <td style="text-align:left;"><?php echo $result['customer']; ?></td>
					 <td style="text-align:left;"><?php $id=$result['ref_id'];
							   $pd=mysqli_query($conn,"select * from hos__subbr left join tb_product on (hos__subbr.product_id=tb_product.product_ID) where ref_id='$id'");
							   while($fpd=mysqli_fetch_array($pd)){
								   echo "<b>".$fpd["access_code"]."</b> / ".$fpd["access_name"]."<br>";
							   }?>
					 </td>
					 <?php if($result['status']==0) { ?><td class="w3-pale-green">Request</td><?php } ?>
					 <?php if($result['status']==1) { ?><td class="w3-pale-yellow">Approved</td><?php } ?>
					 <?php if($result['status']==2) { ?><td class="w3-pale-red">Rejected</td><?php } ?>
					 <?php if($result['status']==3) { ?><td class="w3-pale-blue">Complete</td><?php } ?>
				</tr>
			<?php } ?>
		</tbody>
	</table></div>
<?php
 $sql2 = "select * from hos__so ";
 $query2 = mysqli_query($conn, $sql2);
 $total_record = mysqli_num_rows($query2);
 $total_page = ceil($total_record / $perpage);
?>

<div class="w3-bar w3-margin-top">
  <a href="status_hos_sort.php?page=1" class="w3-button w3-light-grey">&laquo;</a>
  <?php for($i=1;$i<=$total_page;$i++){ ?>
  <a href="status_hos_sort.php?page=<?php echo $i; ?>" class="w3-button w3-light-grey"><?php echo $i; ?></a>
  <?php } ?>
  <a href="status_hos_sort.php?page=<?php echo $total_page;?>" class="w3-button w3-light-grey" aria-label="Next">
 <span aria-hidden="true">&raquo;</span>
 </a>
</div>
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