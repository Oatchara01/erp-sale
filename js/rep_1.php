
<!DOCTYPE html>
<html lang="en"><head>
    <title>:: Report</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="js/bootstrap.css" rel="stylesheet">
    <script type="text/javascript" src="js/jquery.min.js"></script>

     <link rel="stylesheet" href="js/jquery-ui.css" />
 <script src="js/jquery-1.9.1.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script type="text/javascript" src="scripts/jquery-1.4.3.min.js"></script>
  <script type="text/javascript" src="fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
	<script type="text/javascript" src="fancybox/jquery.fancybox-1.3.4.pack.js"></script>
	<link rel="stylesheet" type="text/css" href="fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<script src="js/jquery-1.10.2.js"></script>

    <script type="text/javascript">
		$(document).ready(function() {
	

			$('a[id^="add"]').fancybox({
				'width'				: '90%',
				'height'			: '90%',
				'autoScale'     	: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe',
				onClosed	:	function() {
					parent.location.reload(true); 
				}
			});
$('a[id^="edit"]').fancybox({
				'width'				: '90%',
				'height'			: '90%',
				'autoScale'     	: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe',
				onClosed	:	function() {
					parent.location.reload(true); 
				}
			});
			/*
				onStart		:	function() {
					return window.confirm('Continue?');
				},
				onCancel	:	function() {
					alert('Canceled!');
				},
				onComplete	:	function() {
					alert('Completed!');
				},
				onCleanup	:	function() {
					return window.confirm('Close?');
				},
				onClosed	:	function() {
					alert('Closed!');
				}
				*/

		});
	</script>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <link href="assets/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->

    <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="vv.png">
<script>
    $(function(){
         // Find any date inputs and override their functionality
         $('input[type="date"]').datepicker({ dateFormat: 'yy-mm-dd' });
    });
</script>
<style>
        .divScroll {
            overflow:scroll;
            height:700px;
            
        }
    </style>

<body >
<!-- Part 1: Wrap all page content here -->
<div id="wrap">

<!-- Fixed navbar -->
<div class="navbar navbar-fixed-top">
      <div class="navbar-inner" >
    <div class="nav-header">
      <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                   <a class="brand" href="#"><img src="vv.png">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size="+3">รายงานใบแจ้งงาน</font></a>
                     <a class="brand2" href="logout.php"><img src="logout.png" title="ออกจากระบบ" width="20" height="20" /></a>
                    <a class="brand2" href="sub_main.php"><img src="home-icon-4.png" width="20" title="กลับหน้าหลัก" height="20" /></a>
                   
  
</div>
  </div>
    </div>
<br>
<br>
<br>
<br>
<br>
<br>

<?php
class Paginator{
	var $items_per_page;
	var $items_total;
	var $current_page;
	var $num_pages;
	var $mid_range;
	var $low;
	var $high;
	var $limit;
	var $return;
	var $default_ipp;
	var $querystring;
	var $url_next;

	function Paginator()
	{
		$this->current_page = 1;
		$this->mid_range = 7;
		$this->items_per_page = $this->default_ipp;
		$this->url_next = $this->url_next;
	}
	function paginate()
	{

		if(!is_numeric($this->items_per_page) OR $this->items_per_page <= 0) $this->items_per_page = $this->default_ipp;
		$this->num_pages = ceil($this->items_total/$this->items_per_page);

		if($this->current_page < 1 Or !is_numeric($this->current_page)) $this->current_page = 1;
		if($this->current_page > $this->num_pages) $this->current_page = $this->num_pages;
		$prev_page = $this->current_page-1;
		$next_page = $this->current_page+1;


		if($this->num_pages > 10)
		{
			$this->return = ($this->current_page != 1 And $this->items_total >= 10) ? "<a class=\"paginate\" href=\"".$this->url_next.$this->$prev_page."\">&laquo; Previous</a> ":"<span class=\"inactive\" href=\"#\">&laquo; Previous</span> ";

			$this->start_range = $this->current_page - floor($this->mid_range/2);
			$this->end_range = $this->current_page + floor($this->mid_range/2);

			if($this->start_range <= 0)
			{
				$this->end_range += abs($this->start_range)+1;
				$this->start_range = 1;
			}
			if($this->end_range > $this->num_pages)
			{
				$this->start_range -= $this->end_range-$this->num_pages;
				$this->end_range = $this->num_pages;
			}
			$this->range = range($this->start_range,$this->end_range);

			for($i=1;$i<=$this->num_pages;$i++)
			{
				if($this->range[0] > 2 And $i == $this->range[0]) $this->return .= " ... ";
				if($i==1 Or $i==$this->num_pages Or in_array($i,$this->range))
				{
					$this->return .= ($i == $this->current_page And $_GET['Page'] != 'All') ? "<a title=\"Go to page $i of $this->num_pages\" class=\"current\" href=\"#\">$i</a> ":"<a class=\"paginate\" title=\"Go to page $i of $this->num_pages\" href=\"".$this->url_next.$i."\">$i</a> ";
				}
				if($this->range[$this->mid_range-1] < $this->num_pages-1 And $i == $this->range[$this->mid_range-1]) $this->return .= " ... ";
			}
			$this->return .= (($this->current_page != $this->num_pages And $this->items_total >= 10) And ($_GET['Page'] != 'All')) ? "<a class=\"paginate\" href=\"".$this->url_next.$next_page."\">Next &raquo;</a>\n":"<span class=\"inactive\" href=\"#\">&raquo; Next</span>\n";
		}
		else
		{
			for($i=1;$i<=$this->num_pages;$i++)
			{
				$this->return .= ($i == $this->current_page) ? "<a class=\"current\" href=\"#\">$i</a> ":"<a class=\"paginate\" href=\"".$this->url_next.$i."\">$i</a> ";
			}
		}
		$this->low = ($this->current_page-1) * $this->items_per_page;
		$this->high = ($_GET['ipp'] == 'All') ? $this->items_total:($this->current_page * $this->items_per_page)-1;
		$this->limit = ($_GET['ipp'] == 'All') ? "":" LIMIT $this->low,$this->items_per_page";
	}

	function display_pages()
	{
		return $this->return;
	}
}
?>

<style type="text/css"> 
<!--
	.paginate {
	font-family: Arial, Helvetica, sans-serif;
	font-size: .7em;
	}
	a.paginate {
	border: 1px solid #000080;
	padding: 2px 6px 2px 6px;
	text-decoration: none;
	color: #000080;
	}
	h2 {
		font-size: 12pt;
		color: #003366;
		}
		
		 h2 {
		line-height: 1.2em;
		letter-spacing:-1px;
		margin: 0;
		padding: 0;
		text-align: left;
		}
	a.paginate:hover {
	background-color: #000080;
	color: #FFF;
	text-decoration: underline;
	}
	a.current {
	border: 1px solid #000080;
	font: bold .7em Arial,Helvetica,sans-serif;
	padding: 2px 6px 2px 6px;
	cursor: default;
	background:#000080;
	color: #FFF;
	text-decoration: none;
	}
	span.inactive {
	border: 1px solid #999;
	font-family: Arial, Helvetica, sans-serif;
	font-size: .7em;
	padding: 2px 6px 2px 6px;
	color: #999;
	cursor: default;
	}
-->
</style>

<?php

include "dbconnect.php";
	if ($_POST["Approve"] == "Approve") {
			// $num_valued = count($_POST["ch"]);
	// echo $num_valued;
foreach($_POST["status"] as $key=>$val)
{
if ($_POST["status"][$key] != "") {
	//echo $i;
	$strSQL = "UPDATE postit SET ";
	$strSQL .="status_job= 'Y' ";
	$strSQL .=",detail= '".$_POST["detail"][$key]."' ";
	$strSQL .="WHERE id_postit = '".$_POST["status"][$key]."' ";
	//echo $strSQL;
	$objQuery = mysql_query($strSQL);
	$strSQL = "UPDATE tb_service_order SET ";
	$strSQL .="status= '1' ";
	$strSQL .="WHERE id_postit = '".$_POST["status"][$key]."' ";
	//echo $strSQL;
	$objQuery = mysql_query($strSQL);
	if($objQuery) {
		echo "<script language=\"JavaScript\">"; 
echo "alert('บันทึกสถานะใบรับงาน สำเร็จแล้ว!!');window.location='rep_1.php';"; 
echo "</script>";
	}
	}
}
	}
	if($_POST['s'] == "N" or $_GET['s'] == "N"){
	$status_j = "";	
	}else if($_POST['s'] == "Y" or $_GET['s'] == "Y") {
		$status_j = "Y";
	}
	 if($_POST["type_job"] == ""){
		$strSQL = "SELECT * from postit";
	}else if($_POST["type_job"] != "ALL" or $_GET["type_job"] != "ALL") {
$strSQL = "SELECT * from postit where type='".$_GET['type_job']."".$_POST['type_job']."' and date between '".$_POST['date1']."".$_GET['date1']."' and '".$_GET['date2']."".$_POST['date2']."' and status_job='$status_j'";	
	}else {
$strSQL = "SELECT * from postit where type='".$_GET['type_job']."".$_POST['type_job']."' and status_job='$status_j' and date between '".$_GET['date1']."".$_POST['date1']."' and '".$_GET['date2']."".$_POST['date2']."'";
	}
//echo $strSQL;
$objQuery = mysql_query($strSQL) or die ("Error Query [".$strSQL."]"); 
$Num_Rows = mysql_num_rows($objQuery);
$i=1;
$Per_Page = 10;   // Per Page

$Page = $_GET["Page"];
if(!$_GET["Page"])
{
	$Page=1;
}

$Prev_Page = $Page-1;
$Next_Page = $Page+1;

$Page_Start = (($Per_Page*$Page)-$Per_Page);
if($Num_Rows<=$Per_Page)
{
	$Num_Pages =1;
}
else if(($Num_Rows % $Per_Page)==0)
{
	$Num_Pages =($Num_Rows/$Per_Page) ;
}
else
{
	$Num_Pages =($Num_Rows/$Per_Page)+1;
	$Num_Pages = (int)$Num_Pages;
}

$strSQL .=" order by id_postit ASC LIMIT $Page_Start , $Per_Page";
$objQuery  = mysql_query($strSQL);
?>
<form name="frmMain" id="frmMain" action="<?=$_SERVER["PHP_SELF"]?>" method="post" > 
<table width="95%" border="1" align="center" class="table table-bordered">
  <tr>
    <th height="37" colspan="10" align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;เลือกประเภทใบงาน : 
      <select name="type_job" id="type_job" style="width:100px;">
        <option value=""<? if($_POST["type_job"] == "" or $_GET["type_job"] == ""){echo"selected";}?>>เลือกใบงาน</option>
         <option value="ALL"<? if($_POST["type_job"] == "ALL" or $_GET["type_job"] == "ALL"){echo"selected";}?>>ALL</option>
        <option value="CM"<? if($_POST["type_job"] == "CM" or $_GET["type_job"] == "CM"){echo"selected";}?>>CM</option>
        <option value="PM"<? if($_POST["type_job"] == "PM" or $_GET["type_job"] == "PM"){echo"selected";}?>>PM</option>
        <option value="CAL"<? if($_POST["type_job"] == "CAL" or $_GET["type_job"] == "CAL"){echo"selected";}?>>CAL</option>
        <option value="Sales"<? if($_POST["type_job"] == "Sales" or $_GET["type_job"] == "Sales"){echo"selected";}?>>SO</option>
        <option value="Quotation"<? if($_POST["type_job"] == "Quotation" or $_GET["type_job"] == "Quotation"){echo"selected";}?>>QU</option>
        <option value="Other"<? if($_POST["type_job"] == "Other" or $_GET["type_job"] == "Other"){echo"selected";}?>>OTH</option>
      </select>&nbsp;&nbsp;เลือกวันที่ : <input name="date1" id="date1" type="date" style="width:100px;" value="<?=$_GET["date1"]?><?=$_POST["date1"]?>" /> ถึงวันที่ <input name="date2" id="date2" type="date" style="width:100px;"  value="<?=$_POST["date2"]?><?=$_GET["date2"]?>"/>&nbsp;&nbsp;เลือก สถานะ : <select name="s" id="s">
        <option value=""<? if($_POST["s"] == "" or $_GET["s"] == ""){echo"selected";}?>>ทั้งหมด</option>
            <option value="N"<? if($_POST["s"] == "N" or $_GET["s"] == "N"){echo"selected";}?>>ไม่สมบูรณ์</option>
        <option value="Y"<? if($_POST["s"] == "Y" or $_GET["s"] == "Y"){echo"selected";}?>>สมบูรณ์</option>
      </select> <input name="search" id="search" value="search" type="submit"> 
      </th>

  </tr>
  <tr>
    <th width="156"> <div align="center">เลขที่ใบแจ้งงาน</div></th>
    <th width="82"><div align="center">วันที่</div></th>
    <th width="259"> <div align="center">ชื่อโรงพยาบาล</div></th>
    <th width="196"> <div align="center">ชื่อผู้ติต่อ</div></th>
    <th width="130"> <div align="center">TEL </div></th>
    <th width="84"> <div align="center">ชนิดงาน</div></th>
    <th width="241"> <div align="center">ITEM</div></th>
    <th width="158"> <div align="center">ผู้รับผิดชอบ</div></th>
    <th width="215"><div align="center">รายละเอียดการดำเนินงาน</div></th>
    <th width="85"> <div align="center">สมบูรณ์</div></th>
  </tr>
<?
while($objResult = mysql_fetch_array($objQuery))
{
	$strSQL111 = "SELECT * FROM tb_service_order where id_postit='".$objResult["id_postit"]."'";
$objQuery111 = mysql_query($strSQL111);
$objResult111 = mysql_fetch_array($objQuery111);  
if($objResult["type"] == "CM") {
	$typ=$objResult111["service_refer_no"];
}else if($objResult["type"] == "PM"){
	$typ=$objResult111["service_refer_no"];
}else if($objResult["type"] == "CAL"){
	$typ=$objResult111["service_refer_no"];
}else if($objResult["type"] == "Quotation"){
	$typ=$objResult["type"];
}else if($objResult["type"] == "Other"){
$typ=$objResult["type"];	
}else if($objResult["type"] == "Sales"){
	$typ=$objResult["type"];
}

?>
  <tr>
    <td><div align="center"><a id="add1" class="various iframe" href="add_status.php?id=<?=$objResult["id_postit"]?>"><?php echo $objResult["id_postit"];?></a></div></td>
    <td><? echo date( "d-m-Y",strtotime($objResult["date"]));?></td>
    <td><?php echo $objResult["name_customer"];?></td>
    <td><?php echo $objResult["name_contact"];?></td>
    <td><div align="center"><?php echo $objResult["tel_contact"];?></div></td>
    <td align="left"><?php echo $typ;?></td>
    <td align="left"><?php echo $objResult["item"];?></td>
    <td align="left"><?php echo $objResult["people"];?></td>
    <td align="left"><div class="form-group  has-feedback" style="width:120px;"><span class="form-group  has-feedback" style="width:120px;">
        <textarea class="form-control css-require" name="detail[<?php echo $objResult["id_postit"];?>]" style="width:120px;" rows="2" id="detail"><?php echo $objResult["detail"];?></textarea>
      </span><span class="glyphicon form-control-feedback" aria-hidden="true"></span> </div></td>
    <td align="center"><div align="center">
      <input type="checkbox" name="status[<?php echo $objResult["id_postit"];?>]" id="status<?=$i?>" value="<?php echo $objResult["id_postit"];?>"<? if($objResult["status_job"] == "Y"){echo "checked disabled='disabled'";} else {echo"";}?>/>
     </div> </td>
  </tr>
  <?php
$i++;
}
?>
  <tr>
    <td align="center" colspan="11">&nbsp;<input type="submit" class="btn btn-primary" name="Approve" value="Approve" />  </td>
   
  </tr>

</table>
</form>
<br>
Total <?php echo $Num_Rows;?> Record 

<?php

$pages = new Paginator;
$pages->items_total = $Num_Rows;
$pages->mid_range = 10;
$pages->current_page = $Page;
$pages->default_ipp = $Per_Page;
$pages->url_next = $_SERVER["PHP_SELF"]."?type_job=".$_GET["type_job"]."".$_POST["type_job"]."&date1=".$_GET["date1"]."".$_POST["date1"]."&date2=".$_GET["date2"]."".$_POST["date2"]."&s=".$_GET["s"]."".$_POST["s"]."&QueryString=value&Page=";

$pages->paginate();

echo $pages->display_pages()
?>		

</body>
</html>

