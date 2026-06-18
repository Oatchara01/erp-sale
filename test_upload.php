<form action="testupmap.php" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="mapfile" id="mapfile">
    <input type="submit" value="Upload Image" name="submit">
</form>

<?php
	include('dbconnect.php');
	$map = "select * from map";
	$qmap = mysqli_query($conn,$map);
?>
<table name="test">
	<tr>
		<td>Map File</td>
	</tr>
	<?php while ($fmap = mysqli_fetch_array($qmap,MYSQLI_ASSOC)) { ?>
	<tr>
		<td><?php echo $fmap['mapfile']; ?></td>
	<?php } ?>
	</tr>
</table>