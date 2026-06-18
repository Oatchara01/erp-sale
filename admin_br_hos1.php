<?php
	include('dbconnect.php');
	if ($_POST['submit']) {
		$id = $_POST["id"];
		$main_id = $_POST['main_id'];
		$ref_id = $_POST['ref_id'];
		$company = $_POST['company'];
		$customer = $_POST['customer'];
		$address = $_POST['address'];
		$delivery_place = $_POST['delivery_place'];
		$delivery_contact = $_POST['delivery_contact'];
		$date = $_POST['date'];
		$brnp_no = $_POST['brnp_no'];
		$objective = $_POST['objective'];
		$objective_des1 = $_POST['objective_des1'];
		$objective_des2 = $_POST['objective_des2'];
		$objective_des4 = $_POST['objective_des4'];
		$objective_des5 = $_POST['objective_des5'];
		$bq = $_POST['bq'];
		$ot = $_POST['ot'];
		$delivery_choice = $_POST['delivery_choice'];
		$map = $_POST['map'];
		$mapfile = $_POST['mapfile'];
		$call_before = $_POST['call_before'];
		$assign = $_POST['assign'];
		$delivery_date = $_POST['delivery_date'];
		$delivery_time = $_POST['delivery_time'];		
		$sale_comment = $_POST['sale_comment'];
		$returns = $_POST['returns'];
		$returns_date = $_POST['returns_date'];
		$returns_address = $_POST['returns_address'];
		$returns_contact = $_POST['returns_contact'];
		$sale = $_POST['sale'];
		$sale_date = $_POST['sale_date'];
		$approve = $_POST['approve'];
		$approve_date = $_POST['approve_date'];
		$admin = $_POST['admin'];
		$admin_date = $_POST['admin_date'];
		$status = "2";

		move_uploaded_file($_FILES['mapfile']['tmp_name'],"map/".iconv("UTF-8", "TIS-620",$_FILES['mapfile']['name']));

		$brs = "update hos__br set main_id='$main_id',
		ref_id='$ref_id',
		company='$company',
		customer='$customer',
		address='$address',
		delivery_place='$delivery_place',
		delivery_contact='$delivery_contact',
		date='$date',
		brnp_no='$brnp_no',
		objective='$objective',
		objective_des1='$objective_des1',
		objective_des2='$objective_des2',
		objective_des4='$objective_des4',
		objective_des5='$objective_des5',
		bq='$bq',
		ot='$ot',
		delivery_choice='$delivery_choice',
		map='$map',
		mapfile='".$_FILES['mapfile']['name']."',
		call_before='$call_before',
		assign='$assign',
		delivery_date='$delivery_date',
		delivery_time='$delivery_time',
		sale_comment='$sale_comment',
		returns='$returns',
		returns_date='$returns_date',
		returns_address='$returns_address',
		returns_contact='$returns_contact',
		sale='$sale',
		sale_date='$sale_date',
		approve='$approve',
		approve_date='$approve_date',
		status='$status'
		where id='$id'";
		$qbrs = mysqli_query($conn,$brs);

		if (!$qbrs) {
			echo "Error to save data".mysqli_error($conn);
			//echo header('refresh:3;'. $_SERVER['HTTP_REFERER']);
		}
		else {
			$count=$_POST["count"];
			for ($i=1; $i<=$count; $i++){
				$amount = $_POST["amount$i"];
				$amountA = str_replace(",","","$amount");
				if($_POST["pid$i"]=='' && $_POST["product_id$i"]!=''){ 
					$pd = "insert into hos__subbr (id,ref_id,no,product_id,unit,count,price,amount,sn,lot,sale_remark,stock_remark,admin_remark) values ('',
					'$ref_id',
					'".$_POST["no$i"]."',
					'".$_POST["product_id$i"]."',
					'".$_POST["unit$i"]."',
					'".$_POST["count$i"]."',
					'".$_POST["sol_price$i"]."',
					'$amountA',
					'".$_POST["sn$i"]."',
					'".$_POST["lot$i"]."',
					'".$_POST["sale_remark$i"]."',
					'',
					'".$_POST["admin_remark$i"]."')";
					$qpd = mysqli_query($conn,$pd);
					if (!$qpd) {
						echo("Error description: " . mysqli_error($conn));
					}
				}
			}
			for ($i=1; $i<=$count; $i++){
				$amount = $_POST["amount$i"];
				$amountA = str_replace(",","","$amount");
				if($_POST["pid$i"]!=''){
					$up = "update hos__subbr set
					ref_id='$ref_id',
					no='".$_POST["no$i"]."',
					product_id='".$_POST["product_id$i"]."',
					unit='".$_POST["unit$i"]."',
					count='".$_POST["count$i"]."',
					price='".$_POST["sol_price$i"]."',
					amount='$amountA',
					sn='".$_POST["sn$i"]."',
					lot='".$_POST["lot$i"]."',
					sale_remark='".$_POST["sale_remark$i"]."',
					stock_remark='',
					admin_remark='".$_POST["admin_remark$i"]."'
					where id='".$_POST["pid$i"]."'";

					$qup = mysqli_query($conn,$up) or die (mysqli_error($conn));
					if (!$qup) {
						echo("Error description: " . mysqli_error($conn));
					}
					else { 
						echo "...";
						echo header('refresh:3;'. $_SERVER['HTTP_REFERER']);
					}
				}
			}
		}
	}
	else {
		echo("No Data!");
	}
mysqli_close($conn);
?>