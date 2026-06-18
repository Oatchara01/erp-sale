<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Rubik+Iso&display=swap" rel="stylesheet">

<link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>

<style>
    body{
        
        background-image: linear-gradient(to right top, #d16ba5, #b865a8, #9d60a8, #805ca5, #6058a0, #5e59a6, #5c5bad, #595cb3, #7e61c7, #a664d7, #d063e2, #fb5fe7);
        margin: 0;
        padding: 0;
        background-repeat: no-repeat;
        background-size: 100% auto;
        background-position: right top;
        background-attachment: fixed;
    }
    .black_page{
        background-color: #ffffff;
        margin: 5% 15% 0% 15% ;
        width: 70%;
        border-radius: 10px;
        padding: 10px;
    }
    .radio_box1{
        text-align: center;
    }
    .radio_box4{
        text-align: center;
        background-color: #e0e0e0;
    }
    .radio_item1{
        font: inherit;
		width: 3.5vw;
        height: 2.5vw;
    }
    .radio_item2{
        font: inherit;
		width: 3.5vw;
        height: 2.5vw;
        border-style:hidden;
        text-align: center;
        margin-right: 4px;
        font-family: 'Rubik Iso', cursive; color:#37376f;
    }
    .button_sunmit1{
        font-family: 'Rubik Iso', cursive; 
        border: 4px solid #8080c0;
        border-radius: 15px;
        padding: 1vw;
        background-color: #9feaa9;
        color: #181716;
        transition-duration: 1s;
    }
    .button_sunmit1:hover{
        font-family: 'Rubik Iso', cursive; 
        border: 4px solid #8080c0;
        border-radius: 15px;
        padding: 1vw;
        background-color: #5bdb6b;
        box-shadow: 0px 0px 5px black;
        color: #804000;
    }
</style>
<body>
	
<?php include "dbconnect.php"; 
$strSQL = "SELECT *  FROM st__signature  where ref_id ='".$_GET["ref_id"]."' ";
$objQuery = mysqli_query($new,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);
$objResult = mysqli_fetch_array($objQuery);	
$ref_no = substr($objResult["ref_id"],0,2); 
	

if($objResult["score_ckk"]!='0'){
	
echo "<script language=\"JavaScript\">";
echo "alert('ท่านได้ทำการประเมินไปแล้วค่ะ');window.location='status_reserch_receive.php';";
echo "</script>";	
	
}
	
	?>	
	
	<?php echo "<script>alert('เพื่อความพึ่งพอใจในการให้บริการสูงสุด กรุณาเลือกระดับความพึงพอใจในการรับบริการในครั้งนี้');</script>";   ?>
    <div class="black_page">
        <div>
        <center>
            <h1><strong style="font-family: 'Rubik Iso', cursive; color:#37376f; ">ประเมินความพึงพอใจในการจัดสินค้า</strong></h1>
        </center>   
        <br> 
เลขที่เอกสาร : <font color="blue"><?php echo $objResult["iv_no"]; ?></font><br> 
ชื่อลูกค้า : <font color="blue"><?php 	if($ref_no=='SO'){ 
	
$strSQL3 = "SELECT bill_name FROM hos__so WHERE ref_id = '".$objResult["ref_id"]."' ";
$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);
	echo $objResult3["bill_name"];	
	?>
	
	<?php 	}else if($ref_no=='BR'){ 
$strSQL3 = "SELECT customer FROM hos__br WHERE ref_id_br = '".$objResult["ref_id"]."' ";
$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);
	echo $objResult3["customer"];	
	?>
	
	<?php 	}else if($ref_no=='CH'){ 
	
	$strSQL3 = "SELECT customer FROM hos__change WHERE ref_id = '".$objResult["ref_id"]."' ";
$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);
	echo $objResult3["customer"];	
	?>
	
	<?php 	}else if($ref_no=='SP'){ 
$strSQL3 = "SELECT customer FROM hos__spr WHERE ref_id = '".$objResult["ref_id"]."' ";
$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);
	echo $objResult3["customer"];	
	
	?>
	
	<?php 	}else if($ref_no=='SM'){ 
	$strSQL3 = "SELECT customer_name FROM hos__smp WHERE ref_idsmp = '".$objResult["ref_id"]."' ";
$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);
	echo $objResult3["customer_name"];	
	
	?>
	
	<?php 	}else if($ref_no=='RG'){
	
	$strSQL3 = "SELECT customer_name FROM hos__breg WHERE ref_id = '".$objResult["ref_id"]."' ";
$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);
	echo $objResult3["customer_name"];		
	?>
	
	<?php 	}else if($ref_no=='RT'){
	
	$strSQL3 = "SELECT rental_name FROM hos__rental WHERE ref_id = '".$objResult["ref_id"]."' ";
$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);
	echo $objResult3["rental_name"];		
	?>
	
	<?php 	}else{ 
$strSQL3 = "SELECT billing_name FROM so__main WHERE ref_id = '".$objResult["ref_id"]."' ";
$objQuery3 = mysqli_query($conn,$strSQL3) or die ("Error Query [".$strSQL3."]");
$objResult3 = mysqli_fetch_array($objQuery3);
	echo $objResult3["billing_name"];	
	
	?>
	<?php } ?></font><br>			
			
สินค้า : <br><font color="blue"><?php
  
	if($ref_no=='SO'){			
 $strSQL1 = "SELECT sol_name,sale_remark,count,unit_name FROM (hos__subso LEFT JOIN tb_product ON hos__subso.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."'  and cs_ckk='1'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
$Num_Rows1 = mysqli_num_rows($objQuery1);
while($objResult1 = mysqli_fetch_array($objQuery1)) { 
	echo $objResult1["sol_name"]; 
	?> <?php echo $objResult1["sale_remark"]; ?> <?php echo $objResult1["count"]; ?> <?php echo $objResult1["unit_name"]; ?><br><?php }  ?>
	<?php }else if($ref_no=='BR'){ ?>
	
	<?php
$strSQL1 = "SELECT sol_name,sale_remark,count,unit_name FROM (hos__subbr LEFT JOIN tb_product ON hos__subbr.product_ID=tb_product.product_id) WHERE ref_idd_br = '".$objResult["ref_id"]."'  and cs_ckk='1'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
while($objResult1 = mysqli_fetch_array($objQuery1)) { 
echo $objResult1["sol_name"]; ?> <?php echo $objResult1["sale_remark"]; ?> <?php echo $objResult1["count"]; ?> <?php echo $objResult1["unit_name"]; ?><br>
						<?php } ?>
	
	<?php }else if($ref_no=='SM'){ ?>
	
	<?php
$strSQL2 = "SELECT sol_name,sale_remark,sale_count,unit_name FROM (hos__subsmp LEFT JOIN tb_product ON hos__subsmp.product_ID=tb_product.product_id) WHERE reff_idsmp = '".$objResult["ref_id"]."'  and cs_ckk='1'";
$objQuery2 = mysqli_query($conn,$strSQL2) or die ("Error Query [".$strSQL2."]");
while($objResult2 = mysqli_fetch_array($objQuery2)) {
echo $objResult2["sol_name"]; ?> <?php echo $objResult2["sale_remark"]; ?> <?php echo $objResult2["sale_count"]; ?> <?php echo $objResult2["unit_name"]; ?><br>
<?php } ?>
	
<?php }else if($ref_no=='SP'){ ?>
	<?php
$strSQL1 = "SELECT sol_name,sale_remark,sale_count,unit_name FROM (hos__subspr LEFT JOIN tb_product ON hos__subspr.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."'  and cs_ckk='1'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
while($objResult1 = mysqli_fetch_array($objQuery1)) { 
	echo $objResult1["sol_name"]; ?> <?php echo $objResult1["sale_remark"]; ?> <?php echo $objResult1["sale_count"]; ?> <?php echo $objResult1["unit_name"]; ?><br>
<?php } ?>
	<?php }else if($ref_no=='CH'){ ?>
	
	<?php
$strSQL1 = "SELECT sol_name,sale_remark,count_sale,unit_name FROM (hos__subchange LEFT JOIN tb_product ON hos__subchange.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."' and cs_ckk='1'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
while($objResult1 = mysqli_fetch_array($objQuery1)) { 
echo $objResult1["sol_name"]; ?> <?php echo $objResult1["sale_remark"]; ?> <?php echo $objResult1["count_sale"]; ?> <?php echo $objResult1["unit_name"]; ?><br>
						<?php } ?>
	
	<?php }else if($ref_no=='RG'){ ?>
	<?php
$strSQL1 = "SELECT sol_name,remark_eng2,count2,unit_name FROM (hos__subbreg2 LEFT JOIN tb_product ON hos__subbreg2.product_id2=tb_product.product_ID) WHERE ref_id2 = '".$objResult["ref_id"]."'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
while($objResult1 = mysqli_fetch_array($objQuery1)) { 
echo $objResult1["sol_name"]; ?> <?php echo $objResult1["remark_eng2"]; ?> <?php echo $objResult1["count2"]; ?> <?php echo $objResult1["unit_name"]; ?><br>
						<?php } ?>
<?php }else if($ref_no=='RT'){ ?>
	<?php
$strSQL1 = "SELECT sol_name,remark_sale,count,unit_name FROM (hos__subrental LEFT JOIN tb_product ON hos__subrental.product_id=tb_product.product_ID) WHERE ref_idd = '".$objResult["ref_id"]."' ";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
while($objResult1 = mysqli_fetch_array($objQuery1)) { 
echo $objResult1["sol_name"]; ?> <?php echo $objResult1["remark_sale"]; ?> <?php echo $objResult1["count"]; ?> <?php echo $objResult1["unit_name"]; ?><br>
						<?php } ?>	
	
	<?php }else{ ?>
<?php
$strSQL1 = "SELECT sol_name,sale_remark,sale_count,unit_name FROM (so__submain LEFT JOIN tb_product ON so__submain.product_ID=tb_product.product_id) WHERE ref_idd = '".$objResult["ref_id"]."'";
$objQuery1 = mysqli_query($conn,$strSQL1) or die ("Error Query [".$strSQL1."]");
while($objResult1 = mysqli_fetch_array($objQuery1))
{  	echo $objResult1["sol_name"]; ?> <?php echo $objResult1["sale_remark"]; ?> <?php echo $objResult1["sale_count"]; ?> <?php echo $objResult1["unit_name"]; ?><br>
<?php
}
?>
	
	<?php } ?></font><br>
จัดของโดย :<font color="blue"> <?php echo $objResult["st_name"]; ?></font><br> 
วันที่จัดสินค้า : <font color="blue"><?php echo $objResult["stock_dt"]; ?></font><br> 
        <br> 
        <div class="radio_box1">

        <i style="font-size: 3vw; margin-right: 8px; color:#FF0000;" class='bx bxs-angry bx-tada radio_item1'></i>
        <i style="font-size: 3vw; margin-right: 8px; color:#FD7D7D;" class='bx bxs-meh-alt bx-tada radio_item1'></i>
        <i style="font-size: 3vw; margin-right: 8px; color:#FE6400;" class='bx bxs-confused bx-tada radio_item1'></i>
        <i style="font-size: 3vw; margin-right: 8px; color:#F9A56F;" class='bx bxs-dizzy bx-tada radio_item1'></i>
        <i style="font-size: 3vw; margin-right: 8px; color:#BCD11E;" class='bx bxs-meh-blank bx-tada bx-tada radio_item1'></i>
        <i style="font-size: 3vw; margin-right: 8px; color:#DBE87F;" class='bx bxs-tired bx-tada radio_item1'></i>
        <i style="font-size: 3vw; margin-right: 8px; color:#97F28C;" class='bx bxs-shocked bx-tada radio_item1'></i>
        <i style="font-size: 3vw; margin-right: 8px; color:#1BFF00;" class='bx bxs-happy-beaming bx-tada radio_item1'></i>
        <i style="font-size: 3vw; margin-right: 8px; color:#5C8C64;" class='bx bxs-happy-alt bx-tada radio_item1'></i>
        <i style="font-size: 3vw; margin-right: 8px; color:#2E833B;" class='bx bxs-happy-heart-eyes bx-tada radio_item1'></i>

        </div>


        <br>
        <form action="register_reseach_stock1.php" method="POST" enctype="multipart/form-data">

        <div class="radio_box1">
            <input class="radio_item1" type="radio" name="score_ckk"  id="myCheck1" value="1"  onclick="myFunction1()">
            <input class="radio_item1" type="radio" name="score_ckk"  id="myCheck1" value="2"  onclick="myFunction1()">
            <input class="radio_item1" type="radio" name="score_ckk"  id="myCheck1" value="3"  onclick="myFunction1()">
            <input class="radio_item1" type="radio" name="score_ckk"  id="myCheck1" value="4"  onclick="myFunction1()">
            <input class="radio_item1" type="radio" name="score_ckk"  id="myCheck1" value="5"  onclick="myFunction1()">
            <input class="radio_item1" type="radio" name="score_ckk"  id="myCheck1" value="6"  onclick="myFunction1()">
            <input class="radio_item1" type="radio" name="score_ckk"  id="myCheck1" value="7" >
            <input class="radio_item1" type="radio" name="score_ckk"  id="myCheck1" value="8" >
            <input class="radio_item1" type="radio" name="score_ckk"  id="myCheck1" value="9" >
            <input class="radio_item1" type="radio" name="score_ckk"  id="myCheck1" value="10" >
        </div>




        <div class="radio_box1">
            &nbsp;<input class="radio_item2" type="text" value="1" readonly>
            <input class="radio_item2" type="text" value="2" readonly>
            <input class="radio_item2" type="text" value="3" readonly>
            <input class="radio_item2" type="text" value="4" readonly>
            <input class="radio_item2" type="text" value="5" readonly>
            <input class="radio_item2" type="text" value="6" readonly>
            <input class="radio_item2" type="text" value="7" readonly>
            <input class="radio_item2" type="text" value="8" readonly>
            <input class="radio_item2" type="text" value="9" readonly>
            <input class="radio_item2" type="text" value="10" readonly>
        </div>
<br>
<center>
	<b>ข้อเสนอแนะ :</b> <br>
   	<textarea type="text" name="comment_ckk2" id="comment_ckk2" rows="3" cols="30" ></textarea>
</center>
    
	<input type="hidden" name="ref_id" id="ref_id" value="<?php echo $no=$_GET["ref_id"]; ?>">
<br>
            <hr>
            <br>
            
            <center><button class="button_sunmit1" type="submit"><b>SUBMIT</b></button></center>

            <br>
			(คะแนน มากที่สุด = 10 น้อยที่สุด = 1)
			<br>
        </div>
    </div>
    </form>
</body>
</html>

<script>
    function myFunction1() {
        var comment_ckk = prompt(' \n \n  \n  \n  \n กรุณาให้เหตุผลในการให้คะแนนครั้งนี้ เพื่อพัฒนาการให้บริการของพวกเราต่อไป ');
        //var text1 = document.getElementById("comment_ckk1").innerHTML =  'ข้อเสนอแนะ : '+comment_ckk;
        var text2 = document.getElementById("comment_ckk2").value = comment_ckk;

        while (text2 == '') {
            var comment_ckk = prompt(' \n \n  \n  \n  \n กรุณาให้เหตุผลในการให้คะแนนครั้งนี้ เพื่อพัฒนาการให้บริการของพวกเราต่อไป');
            //var text1 = document.getElementById("comment_ckk1").innerHTML = comment_ckk;
            var text2 = document.getElementById("comment_ckk2").value = comment_ckk;
        }
        

        
    }
</script>