<?php
	$count=$_POST["count"];
	echo $count;
	for ($i=1; $i<=$count; $i++){
		$amount = $_POST["amount$i"];
		$amountA = str_replace(",","","$amount");
		if($_POST['pid$i']=='' && $_POST['product_id']!=''){
			$pd = "insert into hos__subso (id,ref_id,no,product_id,unit,count,price,discount,amount,warranty,cal,pm,sn,sale_remark,stock_remark,admin_remark) 
				values ('',
				'$ref_id',
				'".$_POST["no$i"]."',
				'".$_POST["product_id$i"]."',
				'".$_POST["unit$i"]."',
				'".$_POST["count$i"]."',
				'".$_POST["sol_price$i"]."',
				'".$_POST["discount$i"]."',
				'$amountA',
				'".$_POST["warranty$i"]."',
				'".$_POST["cal$i"]."',
				'".$_POST["pm$i"]."',
				'".$_POST["sn$i"]."',
				'".$_POST["sale_remark$i"]."',
				'',
				'')";
				$qpd = mysqli_query($conn,$pd);
				if (!$qpd)   {
				echo("Error description: " . mysqli_error($conn)); //เน€เธโฌเน€เธยเน€เธเธ•เน€เธเธเน€เธยเน€เธโ€เน€เธเธ‘เน€เธยเน€เธเธเน€เธยเน€เธเธ’เน€เธเธเน€เธเธ• error เน€เธโ€”เน€เธเธ•เน€เธยเน€เธโฌเน€เธยเน€เธเธ”เน€เธโ€
				}
		}
		if($_POST['pid$i']!='' && $_POST['product_id']!=''){
				$up = "update hos__subso set
				ref_id='$ref_id',
				no='".$_POST["no$i"]."',
				product_id='".$_POST["product_id$i"]."',
				unit='".$_POST["unit$i"]."',
				count='".$_POST["count$i"]."',
				price='".$_POST["sol_price$i"]."',
				discount='".$_POST["discount$i"]."',
				amount='$amountA',
				warranty='".$_POST["warranty$i"]."',
				cal='".$_POST["cal$i"]."',
				pm='".$_POST["pm$i"]."',
				sn='".$_POST["sn$i"]."',
				sale_remark='".$_POST["sale_remark$i"]."',
				stock_remark='',
				admin_remark='".$_POST["admin_remark$i"]."',
				where id='".$_POST["pid$i"]."'";

				$qup = mysqli_query($conn,$up);
				if (!$qup)   {
				echo("Error description: " . mysqli_error($conn)); //เน€เธโฌเน€เธยเน€เธเธ•เน€เธเธเน€เธยเน€เธโ€เน€เธเธ‘เน€เธยเน€เธเธเน€เธยเน€เธเธ’เน€เธเธเน€เธเธ• error เน€เธโ€”เน€เธเธ•เน€เธยเน€เธโฌเน€เธยเน€เธเธ”เน€เธโ€
				}
				else { echo "Task Complete!"; }
				}
			}
?>