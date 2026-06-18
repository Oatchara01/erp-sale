<?php function convert(){
		$a=date("Y")+543;
		$b=substr($a,2,3);
		}
		include('dbconnect.php');
		$qget=mysqli_query($conn,"select main_id from hos__so");
		$no=mysqli_fetch_array($qget);
		$ref_id_now="SO".substr(date("Y")+543,2,3).date("m").str_pad( $no["main_id"]+1, 3, '0', STR_PAD_LEFT);
		echo $ref_id_now;
		?>

		<?php $ref_id=$_GET['ref_id']; $row=mysqli_query($conn,"select max(id) as maxid from hos__subso where ref_id='$ref_id'");$frow=mysqli_fetch_array($row); ?>
	<?php echo $frow['maxid']; ?>