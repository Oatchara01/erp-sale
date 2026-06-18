<?php  
include "checksession.php"; 
$user_name=$_SESSION[name_show];    
?>  
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <link rel="stylesheet" href="js/jquery-ui.css" />
 <script src="js/jquery-1.9.1.js"></script>
  <script src="js/jquery-ui.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Phartrilion</title>

    <meta charset="UTF-8">
    <title></title>
     <link href="js/bootstrap.css" rel="stylesheet">
        <link rel="stylesheet" href="css/bootstrap.min.css">
          <link rel="shortcut icon" href="vv.png">
<!--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">-->
    <style type="text/css">
        .form-group{ margin-bottom:0px !important;}
        .form-control-feedback{top:0px !important;}
    </style>
    <style type="text/css">
    body {
        background: url(images/body.jpg) no-repeat center center fixed;
        background-size: cover;
    }
	

.body-wrap {
  min-height: 700px;
}

.body-wrap {
  position: relative;
  z-index: 0;
}

.body-wrap:before,
.body-wrap:after {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  z-index: -1;
  height: 260px;
  background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, rgba(26, 49, 95, 1)), color-stop(100%, rgba(26, 49, 95, 0)));
  background: linear-gradient(to bottom, rgba(26, 49, 95, 1) 0%, rgba(26, 49, 95, 0) 100%);
  filter: progid: DXImageTransform.Microsoft.gradient( startColorstr='#1a315f', endColorstr='#001a315f', GradientType=0);
}
.body-wrap:after {
  top: auto;
  bottom: 0;
  background: linear-gradient(to bottom, rgba(26, 49, 95, 0) 0%, rgba(26, 49, 95, 1) 100%);
  filter: progid: DXImageTransform.Microsoft.gradient( startColorstr='#001a315f', endColorstr='#1a315f', GradientType=0);
}

nav {
  margin-top: 60px;
  box-shadow: 5px 4px 5px #000;
}
</style>
<style>
.caret.caret-up {
    border-top-width: 0;
    border-bottom: 4px solid #fff;
}
</style>

<script>
$(document).ready(function(){
  $(".dropdown").on("hide.bs.dropdown", function(){
    $(".btn").html('Dropdown <span class="caret"></span>');
  });
  $(".dropdown").on("show.bs.dropdown", function(){
    $(".btn").html('Dropdown <span class="caret caret-up"></span>');
  });
});
</script>
</head>
<body>
    
    <script>
	$('ul.nav li.dropdown').hover(function() {
  $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(500);
}, function() {
  $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(500);
});
</script>

 <br> 

<div style="margin:auto;width:50%;">  
<? include("dbconnect.php");?>
<?
	if($_POST["Submit"] == "Submit") {
$Curmonth = date('ymd');
$strSQLC = "SELECT max(id_postit) as co FROM postit";
$objQueryC = mysql_query($strSQLC) or die ("Error Query [".$strSQLC."]");
$objResultC = mysql_fetch_array($objQueryC);
$ID_C=$objResultC["co"];
            $year1 = substr($objResultC["co"],0,6);
           $number1 = substr($ID_C,-2)+1;
             
            // check ครั้งแรกถ้าเป็นค่าว่าง
            if($ID_C == NULL) {
                $ID = (sprintf($Curmonth."%02d", 1));
            } else {
                 
                // check ว่าปีเดียวกัน
                if($year1 == $Curmonth) {
                    $ID = (sprintf($year1."%02d", $number1));
                } else {
                    $ID = (sprintf($Curmonth."%02d",1)); // คนละปี เริ่มการนับใหม่
                }
            }
			
			//INSERT table postit
			if($_POST["type"] == "Sales") {$pdf="sales.pdf";} else if($_POST["type"] == "Quotation"){$pdf="Quotation.pdf";}
				$strSQL = "INSERT INTO postit ";
	$strSQL .="(id_postit, name_customer, name_contact, tel_contact, department, item, type, people, status_job, date, user_create)";
	$strSQL .="VALUES ";
	$strSQL .="('$ID','".$_POST["name_cus"]."','".$_POST["name_contact"]."' ";
	$strSQL .=",'".$_POST["tel"]."' ";
	$strSQL .=",'".$_POST["part"]."','".$_POST["item"]."','".$_POST["type"]."','".$_POST["people"]."','".$_POST["status"]."','".$_POST["date"]."','$user_name')";
	//echo $strSQL;
	$objQuery = mysql_query($strSQL);
	if($objQuery) {
		echo "<script language=\"JavaScript\">"; 
echo "alert('บันทึกใบรับงานเลขที่ $ID สำเร็จแล้ว');window.location='$pdf?type=".$_POST['type']."';"; 
echo "</script>";
	}
			
	}
?>
<form class="form" id="frmMain" name="frmMain" method="post" action="<?=$_SERVER["PHP_SELF"]?>" enctype="multipart/form-data">
  <table class="table table-bordered">
    <tr bgcolor="#FFFFFF">
      <td height="65" colspan="2" align="left">

   
    <div class="container">
   
                   <a class="brand" href="#"><img src="vv.png"></a>
                   <div class="brand2" align="right"><a href="rep_1.php"><img src="check.png" width="20" height="20" title="Update สถานะใบรับงาน" /></a>&nbsp;&nbsp;<a href="rep.php"><img src="view.png" width="20" height="20" title="ดูรายงานงานค้าง" /></a>&nbsp;&nbsp;<a href="sub_main.php"><img src="home-icon-4.png" width="20" height="20" /></a>&nbsp;&nbsp;<a href="logout.php"><img src="logout.png" title="ออกจากระบบ" width="20" height="20" /></a></div>
                  
    </div>
                   <!--/.nav-collapse --> 
        
  </td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td width="25%" align="right"><strong>Type</strong></td>
      <td align="left">
      <? $date = date("Y-m-d");?>
<div class="form-group has-feedback" style="width:550px;">
 <input class="form-control css-require" style="width:100px;" name="type" type="text" id="type" value="<?=$_GET["type"]?>"  readonly/>

 &nbsp;&nbsp;<strong> Date :</strong>
 <input class="form-control css-require" style="width:100px;" name="date" type="text" id="date" value="<?=$date?>"  readonly/>
      <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
</div>  
     
      </td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td align="right"><strong>ชื่อโรงพยาบาล</strong></td>
      <td align="left"><div class="form-group  has-feedback" style="width:550px;">
        <textarea class="form-control-feedback" name="name_cus" style="width:350px;" rows="6" id="name_cus"></textarea>
        <span class="glyphicon form-control-feedback" aria-hidden="true"></span> </div></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td align="right" ><strong>ชื่อผู้ติดต่อ</strong></td>
      <td align="left"><div class="form-group has-feedback" style="width:250px;">
        <input  class="form-control css-require" name="name_contact" type="text" id="name_contact"  />
        <span class="glyphicon form-control-feedback" aria-hidden="true"></span></div></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td align="right" ><strong>เบอร์ที่ติดต่อ</strong></td>
      <td align="left"><div class="form-group has-feedback" style="width:250px;">
        <input class="form-control css-require" name="tel" type="text" id="tel"  />
        <span class="glyphicon form-control-feedback" aria-hidden="true"></span> </div></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td align="right"><strong>แผนก/ฝ่าย</strong></td>
      <td align="left"><div class="form-group has-feedback" style="width:250px;">
        <input class="form-control css-require" name="part" type="text" id="part"  />
        <span class="glyphicon form-control-feedback" aria-hidden="true"></span></div></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td align="right"><strong>Item</strong></td>
      <td align="left"><div class="form-group  has-feedback" style="width:350px;"><span class="form-group  has-feedback" style="width:350px;">
        <textarea class="form-control css-require" name="item" style="width:350px;" rows="6" id="item"></textarea>
      </span><span class="glyphicon form-control-feedback" aria-hidden="true"></span> </div></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td align="right"><strong>ผู้รับผิดชอบ</strong></td>
      <td align="left">
        
        <div class="form-group has-feedback" style="width:250px;">      
          <select class="form-control css-require" name="people" id="people" >
            <option value="">--- กรุณาเลือกผู้รับผิดชอบ ---</option>
            <?
				include("dbconnect.php");
		$rstTemp=mysql_query('select * from employees');
		while($arr_22=mysql_fetch_array($rstTemp)){
		?>
            <option value="<?=$arr_22['em_id']?>">
              <?=$arr_22['name']?> <?=$arr_22['surname']?>
              </option>
            <? }?>
            </select>
          </div>                           
        
        </td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td align="right">Status</td>
      <td align="left"><input type="radio" name="status" id="status" value="Y"/>
        ดำเนินการแล้ว
        &nbsp;
        <input type="radio" name="status" id="status" value="N" />
        ยังไม่ดำเนินการ </td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td align="right"> </td>
      <td align="left"><input type="submit" class="btn btn-primary" name="Submit" value="Submit" /></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="33" colspan="2" align="left"><img src="Copyrights-1.png" width="18" height="18" /><font color="#999999">By Programmernan:2016</font> </td>
    </tr>
  </table>
</form>
   
    </div>
    
    
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>      
 <script type="text/javascript">
 $(function(){
     
     var obj_check=$(".css-require");
     $("#myform1").on("submit",function(){
         obj_check.each(function(i,k){
             var status_check=0;
             if(obj_check.eq(i).find(":radio").length>0 || obj_check.eq(i).find(":checkbox").length>0){
                 status_check=(obj_check.eq(i).find(":checked").length==0)?0:1;    
             }else{
                 status_check=($.trim(obj_check.eq(i).val())=="")?0:1;
             }
             formCheckStatus($(this),status_check);      
         });
         if($(this).find(".has-error").length>0){
              return false;
         }
     });
     
     obj_check.on("change",function(){
         var status_check=0;
         if($(this).find(":radio").length>0 || $(this).find(":checkbox").length>0){
             status_check=($(this).find(":checked").length==0)?0:1;    
         }else{
             status_check=($.trim($(this).val())=="")?0:1;
         }
         formCheckStatus($(this),status_check);       
     });
     
     var formCheckStatus = function(obj,status){
         if(status==1){
             obj.parent(".form-group").removeClass("has-error").addClass("has-success");
             obj.next(".glyphicon").removeClass("glyphicon-warning-sign").addClass("glyphicon-ok");    
         }else{
             obj.parent(".form-group").removeClass("has-success").addClass("has-error");
             obj.next(".glyphicon").removeClass("glyphicon-ok").addClass("glyphicon-warning-sign");      
         }
     }

 });
</script>   


</body>
</html>
