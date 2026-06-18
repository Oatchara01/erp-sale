<?php include ("head.php"); ?>


<?php
include("dbconnect.php");
include ("error_page.php"); 

date_default_timezone_set("Asia/Bangkok");
if ($_POST["submit"] = "submit") {

			$type_company = $_POST["type_company"];
			$date_receive = $_POST["date_receive"];
			$customer_name = $_POST["customer_name"];
			$customer_address = $_POST["customer_address"];
			$iv_no = $_POST["iv_no"];
			$remark_st = $_POST["remark_st"];
			$sale_code = $_POST["sale_code"];
			$sale_name = $_POST["sale_name"];
			$receive_ckk = $_POST["receive_ckk"];
			$receive_name = $_POST["receive_name"];
			$receive_between = $_POST["receive_between"];
			$time_between = $_POST["time_between"];
			$ref_id_br = $_POST["ref_id_br"];	
			$add_date = date('Y-m-d H:i:s');
			$name =  $_SESSION['name'];
			$surname =	$_SESSION['surname'];
			$add_by = "$name $surname";
			$id = $_POST["id"];
			$sale_count = $_POST["sale_count"];
			$return_product = $_POST["return_product"];
			$sale_remarkk = $_POST["sale_remarkk"];
			$sn = $_POST["sn"];
			$product_id = $_POST["product_id"];
			$clear_br = $_POST["clear_br"];

			$sql1 = "select * from hos__receive order by id_auto desc limit 1";
			$query1 = mysqli_query($conn,$sql1);
			$fetch1 = mysqli_fetch_array($query1,MYSQLI_ASSOC); 
			$ref_id =$fetch1['ref_id']+1;
	
	
	
	foreach($id as $key =>$value){
			$id_new=$id[$key];
			$sale_count_new=$sale_count[$key];
			$return_product_new=$return_product[$key];
			$sn_new  = $sn[$key];
			$sale_remarkk_new=$sale_remarkk[$key];
			$product_id_new =$product_id[$key];
			$clear_br_new =$clear_br[$key];

			$count001 = $return_product_new + $sale_count_new;
		
		if($clear_br_new =='1'){
			$ureturn_pro = "UPDATE in__subbr SET return_product = '".$count001."' WHERE id = '".$id_new."' ";
			$qreturn_pro = mysqli_query($conn,$ureturn_pro);
			// echo $ureturn_pro.'<hr>';

			$sql1 = "SELECT ref_id_br   FROM   in__br   where  iv_no = '".$iv_no."' and status_doc = 'Approve'";
			$qry1 = mysqli_query($conn,$sql1) or die(mysqli_error());
			$rs1 = mysqli_fetch_assoc($qry1);

				
			$sql2 = "SELECT sum(count) as sale_count   FROM   in__subbr   where  ref_idd_br = '".$rs1['ref_id_br']."' and product_id = '".$product_id_new."'";
			$qry2 = mysqli_query($conn,$sql2) or die(mysqli_error());
			$rs2 = mysqli_fetch_array($qry2);
				

			$sql3 = "SELECT sum(sale_count) as count3   FROM  hos__subspr  where  product_id = '".$product_id_new."' and clear_br = '1' and clear_ivno ='".$iv_no."' and status_spr ='Approve'";
			$qry3 = mysqli_query($conn,$sql3) or die(mysqli_error());
			$rs3 = mysqli_fetch_array($qry3);
					
			$sql13 = "SELECT sum(count) as count3   FROM  hos__subso   where  product_id = '".$product_id_new."' and clear_br = '1' and clear_ivno ='".$iv_no."' and status_so ='Approve'";
			$qry13 = mysqli_query($conn,$sql13) or die(mysqli_error());
			$rs13 = mysqli_fetch_array($qry13);
				
			$sql41 = "SELECT ref_id   FROM  hos__receive  where iv_no = '".$iv_no."' ";
			$qry41 = mysqli_query($conn,$sql41) or die(mysqli_error());
			$rs41 = mysqli_fetch_array($qry41);

			$sql4 = "SELECT sum(count) as count4   FROM  hos__subreceive  where ref_idd = '".$rs41['ref_id']."' and product_id = '".$product_id_new."'";
			$qry4 = mysqli_query($conn,$sql4) or die(mysqli_error());
			$rs4 = mysqli_fetch_array($qry4);

			$sql12 = "SELECT sum(sale_count) as count3   FROM hos__subsmp where  product_id = '".$product_id_new."' and clear_br = '1' and br_no ='".$iv_no."' and status_smp ='Approve'";
			$qry12 = mysqli_query($conn,$sql12) or die(mysqli_error());
			$rs12 = mysqli_fetch_array($qry12);

			$count3 =  $rs3["count3"]; 
			$count13 =  $rs13["count3"]; 
			$count4 =  $rs4["count4"]; 
			$count5 =  $rs12["count3"];		
			$count2 = ($rs2['sale_count'] - ($count3+$count4+$count5+$count13))-$sale_count_new;


		
			if($count2 =='0'){
				$save6="Update  in__subbr set  clear_ckk = '1'    where ref_idd_br = '".$rs1['ref_id_br']."' and product_id = '".$product_id_new."'";
				$qsave6=mysqli_query($conn,$save6);
				// echo $save6.'<hr>';
			}
			if($count2 < '0'){
				echo "<script language=\"JavaScript\">";
				echo "alert('สินค้าในใบยืมนี้มีไม่พอในการเคลียร์ยืมครั้งนี้ค่ะ');window.location='rister_clearbrpn_st.php?ref_id_br=$ref_id_br';";
				echo "</script>";
				exit();
			}		
		}
	}
	
			$save="insert into hos__receive
			(type_company,date_receive,customer_name,customer_address,iv_no,remark_st,sale_code,sale_name,add_date,add_by,ref_id,receive_name,receive_ckk,receive_between,time_between)
			values
			('".$type_company."','".$date_receive."','".$customer_name."','".$customer_address."','".$iv_no."','".$remark_st."','".$sale_code."','".$sale_name."','".$add_date."','".$add_by."','".$ref_id."','".$receive_name."','".$receive_ckk."','".$receive_between."','".$time_between."')";
			$qsave=mysqli_query($conn,$save);
			// echo $save.'<hr>';

	foreach($id as $key =>$value) {
			$id_new=$id[$key];
			$sale_count_new=$sale_count[$key];
			$sn_new  = $sn[$key];
			$sale_remarkk_new=$sale_remarkk[$key];
			$product_id_new =$product_id[$key];
			$clear_br_new =$clear_br[$key];
			if($clear_br_new=='1'){
				$strSQL = "insert into hos__subreceive
				(ref_idd,count,stock_remark,product_id,product_code,sn)
				values ('".$ref_id."','".$sale_count_new."','".$sale_remarkk_new."','".$product_id_new."','".$product_id_new."','".$sn_new."')";
				$objQuery = mysqli_query($conn,$strSQL);
				// echo $strSQL.'<hr>';
				$sql = "SELECT have_sn   FROM tb_product where product_ID ='".$product_id_new."' ";
				$qry = mysqli_query($conn,$sql) or die(mysqli_error());
				$rs = mysqli_fetch_assoc($qry);
						
				if($rs["have_sn"]=='1'){
				$strSQL11 = "Update   tb_product set demo_ckk = '1'   Where product_ID = '".$product_id_new."' ";
				$objQuery11 = mysqli_query($conn,$strSQL11);
				// echo $strSQL11.'<hr>';
				}
			}
	}

	if($qsave){ if($_SESSION["type_login"]=='Sale'){ echo "<script language=\"JavaScript\">";echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='rister_clearbrpn_stedit.php?ref_id=$ref_id&breq=1';";echo "</script>"; } else { echo "<script language=\"JavaScript\">";echo "alert('บันทึกข้อมูลของท่านเรียบร้อยแล้ว');window.location='rister_clearbrpn_stedit.php?ref_id=$ref_id';";echo "</script>"; }
	} else { echo "Cannot"; }
}
?>
