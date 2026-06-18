<?php
	include('dbconnect.php');
	if ($_POST['submit']=='save') {
		$id=$_POST['id'];
		$main_id=$_POST['main_id'];
		$ref_id=$_POST['ref_id'];
		$company=$_POST['company'];
		$suggest=$_POST['suggest'];
		$date=$_POST['date'];
		$ref_no=$_POST['ref_no'];
		$job_no=$_POST['job_no'];
		$dep_no=$_POST['dep_no'];
		$sale_channel=$_POST['sale_channel'];
		$bill_name=$_POST['bill_name'];
		$bill_address=$_POST['bill_address'];
		$bill_tel=$_POST['bill_tel'];
		$payment=$_POST['payment'];
		$delivery_place=$_POST['delivery_place'];
		$delivery_contact=$_POST['delivery_contact'];
		$po_no=$_POST['po_no'];
		$delivery_contract=$_POST['delivery_contract'];
		$book_clear=$_POST['book_clear'];
		$book_no=$_POST['book_no'];
		$brn_clear=$_POST['brn_clear'];
		$brn_no=$_POST['brn_no'];
		$brnp_clear=$_POST['brnp_clear'];
		$brnp_no=$_POST['brnp_no'];
		$installed=$_POST['installed'];
		$bq=$_POST['bq'];
		$ot=$_POST['ot'];
		$with_pr=$_POST['with_pr'];
		$full_bill=$_POST['full_bill'];
		$slip=$_FILES['slip']['name'];
		$type_type=$_POST['type_type'];
		$type_detail=$_POST['type_detail'];
		$delivery_choice=$_POST['delivery_choice'];
		$delivery_date=$_POST['delivery_date'];
		$delivery_time=$_POST['delivery_time'];
		$big_car=$_POST['big_car'];
		$map=$_POST['map'];
		$mapfile=$_POST['mapfile'];
		$call_before=$_POST['call_before'];
		$assign=$_POST['assign'];
		$sale_comment=$_POST['sale_comment'];
		$sale=$_POST['sale'];
		$sale_date=$_POST['sale_date'];
		$approve=$_POST['approve'];
		$approve_date=$_POST['approve_date'];
		$admin=$_POST['admin'];
		$admin_date=$_POST['admin_date'];
		$status=$_POST['status'];

		move_uploaded_file($_FILES['slip']['tmp_name'],"slip/".iconv("UTF-8", "TIS-620",$_FILES['slip']['name']));
		//move_uploaded_file($_FILES['mapfile']['tmp_name'],"map/".iconv("UTF-8", "TIS-620",$_FILES['mapfile']['name']));

		$save = "update hos__so set 
		main_id='$main_id',ref_id='$ref_id',company='$company',suggest='$suggest',date='$date',ref_no='$ref_no',job_no='$job_no',dep_no='$dep_no',sale_channel='$sale_channel',bill_name='$bill_name',bill_address='$bill_address',bill_tel='$bill_tel',payment='$payment',delivery_place='$delivery_place',delivery_contact='$delivery_contact',po_no='$po_no',delivery_contract='$delivery_contract',book_clear='$book_clear',book_no='$book_no',brn_clear='$brn_clear',brn_no='$brn_no',brnp_clear='$brnp_clear',brnp_no='$brnp_no',installed='$installed',bq='$bq',ot='$ot',with_pr='$with_pr',full_bill='$full_bill',slip='$slip',type_type='$type_type',type_detail='$type_detail',delivery_choice='$delivery_choice',	delivery_date='$delivery_date',delivery_time='$delivery_time',big_car='$big_car',map='$map',mapfile='$mapfile',call_before='$call_before',assign='$assign',sale_comment='$sale_comment',sale='$sale',sale_date='$sale_date',approve='$approve',approve_date='$approve_date',admin='$admin',admin_date='$admin_date',status='$status'	where id='$id'";

		$qsave = mysqli_query($conn,$save);
		if (!$qsave){
			echo "Error : ".mysqli_error($conn);
		}
		else {
			$count=$_POST["count"];
			for ($i=1; $i<=$count; $i++){
				$amount = $_POST["amount$i"];
				$amountA = str_replace(",","","$amount");
				if($_POST["pid$i"]=='' && $_POST["product_id$i"]!=''){ 
					$pd = "insert into hos__subso (id,ref_id,no,product_id,unit,count,price,discount,amount,warranty,cal,pm,sn,sale_remark,stock_remark,admin_remark)				values ('',
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
				}
			}
			for ($i=1; $i<=$count; $i++){
				$amount = $_POST["amount$i"];
				$amountA = str_replace(",","","$amount");
				if($_POST["pid$i"]!=''){
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