<?php 


include('head.php');

 
 
 ?>


<style type="text/css">
<!--
.style15 {
	font-size: 18px; color: #000000;
}
.style30 {font-size: 12; }
.style32 {font-size: 11px}
.style33 {font-size: 12px; }
.style34 {color: #FF0000}
.style35 {font-size: 14px; color: #f2f2f2; }
.style37 {color: #FF0000; font-size: 14px; }
.style38 {color: #f2f2f2}
.style39 {font-size: 14px; color: #000000;}
.style40 {font-size: 14px; color: #FF0000; }
-->

.button {
    background-color: #339900;
    border: none;
    color: white;
    padding: 14px 16px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
}

.button1 {border-radius: 2px;}
.button2 {border-radius: 4px;}
.button3 {border-radius: 8px;}
.button4 {border-radius: 12px;}
.button5 {border-radius: 50%;}
</style>


<body>
	<?php 
	$strSQL = "SELECT * FROM tb_doc_ptl   where id_doc = '".$_GET["ref_id"]."'";
	//echo $strSQL;
	$objQuery  = mysqli_query($conn,$strSQL);
$objResult = mysqli_fetch_array($objQuery);

	?>
<form   method="GET" name="frmMain" enctype="multipart/form-data" >
<div class="w3-white">
<div class="w3-container w3-padding-large">

<div class="w3-panel w3-light-gray"><h4>EDIT : เลขที่เอกสาร</h4></div>


<div class=" w3-container w3-half">

หมายเหตุ
<input type = 'text' name="description" class="w3-input" value="<?php  echo $objResult["description"]; ?>" style="width:80%;">
	<input type = 'hidden' name="id_doc" class="w3-input" value="<?php  echo $objResult["id_doc"]; ?>" style="width:80%;">

</div>

</p>
<center>
		  <input type="button" name ="Submit" value="บันทึก" class = "button button4" onClick="this.form.action='edit_docnoptl1.php'; submit()">
</center>

<br>



</div></div>
<div id="cr_bar"> <?php include "foot.php"; ?></div>	


</form>

</body>
</html>


