<?php include "head.php"; ?>


<style type="text/css">
<!--
.style15 {
	font-size: 18px; color: #000000;
}
.style30 {font-size: 12; }
.style32 {font-size: 11px}
.style33 {font-size: 12px; }
.style34 {color: #FF0000}
.style35 {font-size: 12px; color: #000000; }
.style37 {color: #FF0000; font-size: 14px; }
.style38 {color: #f2f2f2}
.style39 {font-size: 14px; color: #000099;}
.style40 {font-size: 14px; color: #FF0000; }
-->

</style>
</head>
<body>


 
<center>
<h2><span class="style15">ตารางใบจอง</span></h2>  </center>

		  
 

<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">

เดือน :
	<select name="mount" id="mount" style="width:160px" class="button4" >
<option  value="">**Please Select**</option>
<option  value="01">มกราคม</option>
<option  value="02">กุมภาพันธ์</option>
<option  value="03">มีนาคม</option>
<option  value="04">เมษายน</option>
<option  value="05">พฤษภาคม</option>
<option  value="06">มิถุนายน</option>
<option  value="07">กรกฎาคม</option>
<option  value="08">สิงหาคม</option>
<option  value="09">กันยายน</option>
<option  value="10">ตุลาคม</option>
<option  value="11">พฤศจิกายน</option>
<option  value="12">ธันวาคม</option>


</select>
	
	<input type="submit" value="Search" class="button button4">

<?php 

if($_GET["mount"] !=''){
		$mount = $_GET["mount"];	
$date_now1 = date("Y");
	/*$date_arr1 = explode('-' , $date_now1 );
$date_now2 = $date_arr1[0];*/
$date_now =	"$date_now1-$mount";		
	}else{
$date_now = date("Y-m");
	}


$date_arr = explode('-' , $date_now );
$mm = $date_arr[1];
$yy = $date_arr[0];
$_month_name = array("01"=>"มกราคม",  "02"=>"กุมภาพันธ์",  "03"=>"มีนาคม", "04"=>"เมษายน",  "05"=>"พฤษภาคม",  "06"=>"มิถุนายน","07"=>"กรกฎาคม",  "08"=>"สิงหาคม",  "09"=>"กันยายน",
"10"=>"ตุลาคม", "11"=>"พฤศจิกายน",  "12"=>"ธันวาคม");

$thai= $_month_name[$mm];
$year =$yy+543;

?>
<center>
<h2><span class="style15"><?php echo $thai; ?> &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $year; ?></span></h2> </center>         

<?php		  

include "dbconnect_sale.php";


//วีนที่ 1
$date_1 =  "$date_now-01";
$date_day1 = date('w', strtotime($date_1));

if($date_day1 == '0'){
$day1 = "วันอาทิตย์";
}else if($date_day1 == '1'){
$day1 = "วันจันทร์";

}else if($date_day1 == '2'){
$day1 = "วันอังคาร";

}else if($date_day1 == '3'){
$day1 = "วันพุธ";

}else if($date_day1 == '4'){
$day1 = "วันพฤหัสบดี";

}else if($date_day1 == '5'){
$day1 = "วันศุกร์";

}else if($date_day1 == '6'){
$day1 = "วันเสาร์";
}


//วีนที่ 2
$date_2 =  "$date_now-02";
$date_day2 = date('w', strtotime($date_2));

if($date_day2 == '0'){
$day2 = "วันอาทิตย์";
}else if($date_day2 == '1'){
$day2 = "วันจันทร์";

}else if($date_day2 == '2'){
$day2 = "วันอังคาร";

}else if($date_day2 == '3'){
$day2 = "วันพุธ";

}else if($date_day2 == '4'){
$day2 = "วันพฤหัสบดี";

}else if($date_day2 == '5'){
$day2 = "วันศุกร์";

}else if($date_day2 == '6'){
$day2 = "วันเสาร์";
}


//วีนที่ 3
$date_3 =  "$date_now-03";
$date_day3 = date('w', strtotime($date_3));

if($date_day3 == '0'){
$day3 = "วันอาทิตย์";
}else if($date_day3 == '1'){
$day3 = "วันจันทร์";

}else if($date_day3 == '2'){
$day3 = "วันอังคาร";

}else if($date_day3 == '3'){
$day3 = "วันพุธ";

}else if($date_day3 == '4'){
$day3 = "วันพฤหัสบดี";

}else if($date_day3 == '5'){
$day3 = "วันศุกร์";

}else if($date_day3 == '6'){
$day3 = "วันเสาร์";
}

//วีนที่ 4
$date_4 =  "$date_now-04";
$date_day4 = date('w', strtotime($date_4));

if($date_day4 == '0'){
$day4 = "วันอาทิตย์";
}else if($date_day4 == '1'){
$day4 = "วันจันทร์";

}else if($date_day4 == '2'){
$day4 = "วันอังคาร";

}else if($date_day4 == '3'){
$day4 = "วันพุธ";

}else if($date_day4 == '4'){
$day4 = "วันพฤหัสบดี";

}else if($date_day4 == '5'){
$day4 = "วันศุกร์";

}else if($date_day4 == '6'){
$day4 = "วันเสาร์";
}


//วีนที่ 5
$date_5 =  "$date_now-05";
$date_day5 = date('w', strtotime($date_5));

if($date_day5 == '0'){
$day5 = "วันอาทิตย์";
}else if($date_day5 == '1'){
$day5 = "วันจันทร์";

}else if($date_day5 == '2'){
$day5 = "วันอังคาร";

}else if($date_day5 == '3'){
$day5 = "วันพุธ";

}else if($date_day5 == '4'){
$day5 = "วันพฤหัสบดี";

}else if($date_day5 == '5'){
$day5 = "วันศุกร์";

}else if($date_day5 == '6'){
$day5 = "วันเสาร์";
}

//วีนที่ 6
$date_6 =  "$date_now-06";
$date_day6 = date('w', strtotime($date_6));

if($date_day6 == '0'){
$day6 = "วันอาทิตย์";
}else if($date_day6 == '1'){
$day6 = "วันจันทร์";

}else if($date_day6 == '2'){
$day6 = "วันอังคาร";

}else if($date_day6 == '3'){
$day6 = "วันพุธ";

}else if($date_day6 == '4'){
$day6 = "วันพฤหัสบดี";

}else if($date_day6 == '5'){
$day6 = "วันศุกร์";

}else if($date_day6 == '6'){
$day6 = "วันเสาร์";
}

//วีนที่ 7
$date_7 =  "$date_now-07";
$date_day7 = date('w', strtotime($date_7));

if($date_day7 == '0'){
$day7 = "วันอาทิตย์";
}else if($date_day7 == '1'){
$day7 = "วันจันทร์";

}else if($date_day7 == '2'){
$day7 = "วันอังคาร";

}else if($date_day7 == '3'){
$day7 = "วันพุธ";

}else if($date_day7 == '4'){
$day7 = "วันพฤหัสบดี";

}else if($date_day7 == '5'){
$day7 = "วันศุกร์";

}else if($date_day7 == '6'){
$day7 = "วันเสาร์";
}

//วีนที่ 8
$date_8 =  "$date_now-08";
$date_day8 = date('w', strtotime($date_8));

if($date_day8 == '0'){
$day8 = "วันอาทิตย์";
}else if($date_day8 == '1'){
$day8 = "วันจันทร์";

}else if($date_day8 == '2'){
$day8 = "วันอังคาร";

}else if($date_day8 == '3'){
$day8 = "วันพุธ";

}else if($date_day8 == '4'){
$day8 = "วันพฤหัสบดี";

}else if($date_day8 == '5'){
$day8 = "วันศุกร์";

}else if($date_day8 == '6'){
$day8 = "วันเสาร์";
}

//วีนที่ 9
$date_9 =  "$date_now-09";
$date_day9 = date('w', strtotime($date_9));

if($date_day9 == '0'){
$day9 = "วันอาทิตย์";
}else if($date_day9 == '1'){
$day2 = "วันจันทร์";

}else if($date_day9 == '2'){
$day9 = "วันอังคาร";

}else if($date_day9 == '3'){
$day9 = "วันพุธ";

}else if($date_day9 == '4'){
$day9 = "วันพฤหัสบดี";

}else if($date_day9 == '5'){
$day9 = "วันศุกร์";

}else if($date_day9 == '6'){
$day9 = "วันเสาร์";
}

//วีนที่ 10
$date_10 =  "$date_now-10";
$date_day10 = date('w', strtotime($date_10));

if($date_day10 == '0'){
$day10 = "วันอาทิตย์";
}else if($date_day10 == '1'){
$day10 = "วันจันทร์";

}else if($date_day10 == '2'){
$day10 = "วันอังคาร";

}else if($date_day10 == '3'){
$day10 = "วันพุธ";

}else if($date_day10 == '4'){
$day10 = "วันพฤหัสบดี";

}else if($date_day10 == '5'){
$day10 = "วันศุกร์";

}else if($date_day10 == '6'){
$day10 = "วันเสาร์";
}

//วีนที่ 11
$date_11 =  "$date_now-11";
$date_day11 = date('w', strtotime($date_11));

if($date_day11 == '0'){
$day11 = "วันอาทิตย์";
}else if($date_day11 == '1'){
$day11 = "วันจันทร์";

}else if($date_day11 == '2'){
$day11 = "วันอังคาร";

}else if($date_day11 == '3'){
$day11 = "วันพุธ";

}else if($date_day11 == '4'){
$day11 = "วันพฤหัสบดี";

}else if($date_day11 == '5'){
$day11 = "วันศุกร์";

}else if($date_day11 == '6'){
$day11 = "วันเสาร์";
}

//วีนที่ 12
$date_12 =  "$date_now-12";
$date_day12 = date('w', strtotime($date_12));

if($date_day12 == '0'){
$day12 = "วันอาทิตย์";
}else if($date_day12 == '1'){
$day12 = "วันจันทร์";

}else if($date_day12 == '2'){
$day12 = "วันอังคาร";

}else if($date_day12 == '3'){
$day12 = "วันพุธ";

}else if($date_day12 == '4'){
$day12 = "วันพฤหัสบดี";

}else if($date_day12 == '5'){
$day12 = "วันศุกร์";

}else if($date_day12 == '6'){
$day12 = "วันเสาร์";
}

//วีนที่ 13
$date_13 =  "$date_now-13";
$date_day13 = date('w', strtotime($date_13));

if($date_day13 == '0'){
$day13 = "วันอาทิตย์";
}else if($date_day13 == '1'){
$day13 = "วันจันทร์";

}else if($date_day13 == '2'){
$day13 = "วันอังคาร";

}else if($date_day13 == '3'){
$day13 = "วันพุธ";

}else if($date_day13 == '4'){
$day13 = "วันพฤหัสบดี";

}else if($date_day13 == '5'){
$day13 = "วันศุกร์";

}else if($date_day13 == '6'){
$day13 = "วันเสาร์";
}

//วีนที่ 14
$date_14 =  "$date_now-14";
$date_day14 = date('w', strtotime($date_14));

if($date_day14 == '0'){
$day14 = "วันอาทิตย์";
}else if($date_day14 == '1'){
$day14 = "วันจันทร์";

}else if($date_day14 == '2'){
$day14 = "วันอังคาร";

}else if($date_day14 == '3'){
$day14 = "วันพุธ";

}else if($date_day14 == '4'){
$day14 = "วันพฤหัสบดี";

}else if($date_day14 == '5'){
$day14 = "วันศุกร์";

}else if($date_day14 == '6'){
$day14 = "วันเสาร์";
}

//วีนที่ 15
$date_15 =  "$date_now-15";
$date_day15 = date('w', strtotime($date_15));

if($date_day15 == '0'){
$day15 = "วันอาทิตย์";
}else if($date_day15 == '1'){
$day2 = "วันจันทร์";

}else if($date_day15 == '2'){
$day15 = "วันอังคาร";

}else if($date_day15 == '3'){
$day15 = "วันพุธ";

}else if($date_day15 == '4'){
$day2 = "วันพฤหัสบดี";

}else if($date_day15 == '5'){
$day15 = "วันศุกร์";

}else if($date_day15 == '6'){
$day15 = "วันเสาร์";
}

//วีนที่ 16
$date_16 =  "$date_now-16";
$date_day16 = date('w', strtotime($date_16));

if($date_day16 == '0'){
$day16 = "วันอาทิตย์";
}else if($date_day16 == '1'){
$day16 = "วันจันทร์";

}else if($date_day16 == '2'){
$day16 = "วันอังคาร";

}else if($date_day16 == '3'){
$day16 = "วันพุธ";

}else if($date_day16 == '4'){
$day16 = "วันพฤหัสบดี";

}else if($date_day16 == '5'){
$day2 = "วันศุกร์";

}else if($date_day16 == '6'){
$day16 = "วันเสาร์";
}

//วีนที่ 17
$date_17 =  "$date_now-17";
$date_day17 = date('w', strtotime($date_17));

if($date_day17 == '0'){
$day17 = "วันอาทิตย์";
}else if($date_day17 == '1'){
$day17 = "วันจันทร์";

}else if($date_day17 == '2'){
$day17 = "วันอังคาร";

}else if($date_day17 == '3'){
$day17 = "วันพุธ";

}else if($date_day17 == '4'){
$day17 = "วันพฤหัสบดี";

}else if($date_day17 == '5'){
$day17 = "วันศุกร์";

}else if($date_day17 == '6'){
$day17 = "วันเสาร์";
}

//วีนที่ 18
$date_18 =  "$date_now-18";
$date_day18 = date('w', strtotime($date_18));

if($date_day18 == '0'){
$day18 = "วันอาทิตย์";
}else if($date_day18 == '1'){
$day18 = "วันจันทร์";

}else if($date_day18 == '2'){
$day18 = "วันอังคาร";

}else if($date_day18 == '3'){
$day18 = "วันพุธ";

}else if($date_day18 == '4'){
$day18 = "วันพฤหัสบดี";

}else if($date_day18 == '5'){
$day18 = "วันศุกร์";

}else if($date_day18 == '6'){
$day18 = "วันเสาร์";
}

//วีนที่ 19
$date_19 =  "$date_now-19";
$date_day19 = date('w', strtotime($date_19));

if($date_day19 == '0'){
$day19 = "วันอาทิตย์";
}else if($date_day19 == '1'){
$day19 = "วันจันทร์";

}else if($date_day19 == '2'){
$day19 = "วันอังคาร";

}else if($date_day19 == '3'){
$day19 = "วันพุธ";

}else if($date_day19 == '4'){
$day19 = "วันพฤหัสบดี";

}else if($date_day19 == '5'){
$day19 = "วันศุกร์";

}else if($date_day19 == '6'){
$day19 = "วันเสาร์";
}

//วีนที่ 20
$date_20 =  "$date_now-20";
$date_day20 = date('w', strtotime($date_20));

if($date_day20 == '0'){
$day20 = "วันอาทิตย์";
}else if($date_day20 == '1'){
$day20 = "วันจันทร์";

}else if($date_day20 == '2'){
$day20 = "วันอังคาร";

}else if($date_day20 == '3'){
$day20 = "วันพุธ";

}else if($date_day20 == '4'){
$day20 = "วันพฤหัสบดี";

}else if($date_day20 == '5'){
$day20 = "วันศุกร์";

}else if($date_day20 == '6'){
$day20 = "วันเสาร์";
}

//วีนที่ 21
$date_21 =  "$date_now-21";
$date_day21 = date('w', strtotime($date_21));

if($date_day21 == '0'){
$day21 = "วันอาทิตย์";
}else if($date_day21 == '1'){
$day21 = "วันจันทร์";

}else if($date_day21 == '2'){
$day21 = "วันอังคาร";

}else if($date_day21 == '3'){
$day21 = "วันพุธ";

}else if($date_day21 == '4'){
$day21 = "วันพฤหัสบดี";

}else if($date_day21 == '5'){
$day21 = "วันศุกร์";

}else if($date_day21 == '6'){
$day21 = "วันเสาร์";
}


//วีนที่ 22
$date_22 =  "$date_now-22";
$date_day22 = date('w', strtotime($date_22));

if($date_day22 == '0'){
$day22 = "วันอาทิตย์";
}else if($date_day22 == '1'){
$day22 = "วันจันทร์";

}else if($date_day22 == '2'){
$day22 = "วันอังคาร";

}else if($date_day22 == '3'){
$day22 = "วันพุธ";

}else if($date_day22 == '4'){
$day22 = "วันพฤหัสบดี";

}else if($date_day22 == '5'){
$day22 = "วันศุกร์";

}else if($date_day22 == '6'){
$day22 = "วันเสาร์";
}

//วีนที่ 23
$date_23 =  "$date_now-23";
$date_day23 = date('w', strtotime($date_23));

if($date_day23 == '0'){
$day23 = "วันอาทิตย์";
}else if($date_day23 == '1'){
$day23 = "วันจันทร์";

}else if($date_day23 == '2'){
$day23 = "วันอังคาร";

}else if($date_day23 == '3'){
$day23 = "วันพุธ";

}else if($date_day23 == '4'){
$day23 = "วันพฤหัสบดี";

}else if($date_day23 == '5'){
$day23 = "วันศุกร์";

}else if($date_day23 == '6'){
$day23 = "วันเสาร์";
}

//วีนที่ 24
$date_24 =  "$date_now-24";
$date_day24 = date('w', strtotime($date_24));

if($date_day24 == '0'){
$day24 = "วันอาทิตย์";
}else if($date_day24 == '1'){
$day24 = "วันจันทร์";

}else if($date_day24 == '2'){
$day24 = "วันอังคาร";

}else if($date_day24 == '3'){
$day24 = "วันพุธ";

}else if($date_day24 == '4'){
$day24 = "วันพฤหัสบดี";

}else if($date_day24 == '5'){
$day24 = "วันศุกร์";

}else if($date_day24 == '6'){
$day24 = "วันเสาร์";
}

//วีนที่ 2
$date_25 =  "$date_now-25";
$date_day25 = date('w', strtotime($date_25));

if($date_day25 == '0'){
$day25 = "วันอาทิตย์";
}else if($date_day25 == '1'){
$day25 = "วันจันทร์";

}else if($date_day25 == '2'){
$day25 = "วันอังคาร";

}else if($date_day25 == '3'){
$day25 = "วันพุธ";

}else if($date_day25 == '4'){
$day25 = "วันพฤหัสบดี";

}else if($date_day25 == '5'){
$day25 = "วันศุกร์";

}else if($date_day25 == '6'){
$day25 = "วันเสาร์";
}

//วีนที่ 26
$date_26 =  "$date_now-26";
$date_day26 = date('w', strtotime($date_26));

if($date_day26 == '0'){
$day26 = "วันอาทิตย์";
}else if($date_day26 == '1'){
$day26 = "วันจันทร์";

}else if($date_day26 == '2'){
$day26 = "วันอังคาร";

}else if($date_day26 == '3'){
$day26 = "วันพุธ";

}else if($date_day26 == '4'){
$day26 = "วันพฤหัสบดี";

}else if($date_day26 == '5'){
$day26 = "วันศุกร์";

}else if($date_day26 == '6'){
$day26 = "วันเสาร์";
}

//วีนที่ 27
$date_27 =  "$date_now-27";
$date_day27 = date('w', strtotime($date_27));

if($date_day27 == '0'){
$day27 = "วันอาทิตย์";
}else if($date_day27 == '1'){
$day27 = "วันจันทร์";

}else if($date_day27 == '2'){
$day27 = "วันอังคาร";

}else if($date_day27 == '3'){
$day27 = "วันพุธ";

}else if($date_day27 == '4'){
$day27 = "วันพฤหัสบดี";

}else if($date_day27 == '5'){
$day27 = "วันศุกร์";

}else if($date_day27 == '6'){
$day27 = "วันเสาร์";
}

//วีนที่ 28
$date_28 =  "$date_now-28";
$date_day28 = date('w', strtotime($date_28));

if($date_day28 == '0'){
$day28 = "วันอาทิตย์";
}else if($date_day28 == '1'){
$day28 = "วันจันทร์";

}else if($date_day28 == '2'){
$day28 = "วันอังคาร";

}else if($date_day28 == '3'){
$day28 = "วันพุธ";

}else if($date_day28 == '4'){
$day28 = "วันพฤหัสบดี";

}else if($date_day28 == '5'){
$day28 = "วันศุกร์";

}else if($date_day28 == '6'){
$day28 = "วันเสาร์";
}

//วีนที่ 29
$date_29 =  "$date_now-29";
$date_day29 = date('w', strtotime($date_29));

if($date_day29 == '0'){
$day29 = "วันอาทิตย์";
}else if($date_day29 == '1'){
$day29 = "วันจันทร์";

}else if($date_day29 == '2'){
$day29 = "วันอังคาร";

}else if($date_day29 == '3'){
$day29 = "วันพุธ";

}else if($date_day29 == '4'){
$day29 = "วันพฤหัสบดี";

}else if($date_day29 == '5'){
$day29 = "วันศุกร์";

}else if($date_day29 == '6'){
$day29 = "วันเสาร์";
}

//วีนที่ 30
$date_30 =  "$date_now-30";
$date_day30 = date('w', strtotime($date_30));

if($date_day30 == '0'){
$day30 = "วันอาทิตย์";
}else if($date_day30 == '1'){
$day30 = "วันจันทร์";

}else if($date_day30 == '2'){
$day30 = "วันอังคาร";

}else if($date_day30 == '3'){
$day30 = "วันพุธ";

}else if($date_day30 == '4'){
$day30 = "วันพฤหัสบดี";

}else if($date_day30 == '5'){
$day30 = "วันศุกร์";

}else if($date_day30 == '6'){
$day30 = "วันเสาร์";
}

//วีนที่ 31
$date_31 =  "$date_now-31";
$date_day31 = date('w', strtotime($date_31));

if($date_day31 == '0'){
$day31 = "วันอาทิตย์";
}else if($date_day31 == '1'){
$day31 = "วันจันทร์";

}else if($date_day31 == '2'){
$day31 = "วันอังคาร";

}else if($date_day31 == '3'){
$day31 = "วันพุธ";

}else if($date_day31 == '4'){
$day31 = "วันพฤหัสบดี";

}else if($date_day31 == '5'){
$day31 = "วันศุกร์";

}else if($date_day31 == '6'){
$day31 = "วันเสาร์";
}






?>

<table border="1" width="100%" class="w3-table">
<tr>
<?php 

$strSQL = "SELECT distinct sale_area,sale_name  FROM tb_register_data where date_plan ='".$date_1."' and status_reser ='Approve'";

$objQuery = mysqli_query($com,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);

if($Num_Rows > 0){
?>
	<td width="14%" align="right" bgcolor="#FFFF99" class="style35">
<?php }else{
?>

<td width="14%" align="right"  class="style35">
<?php } ?>



<?php echo $day1 ; ?>&nbsp; 1  <br>

<?php
while($objResult = mysqli_fetch_array($objQuery))
{
	?>
	
	<a href='status_baijong.php?sale_area=<?php echo $objResult["sale_area"];?>&date_plan=<?php echo  $date_1;?>'><span class="style39"><?php echo $objResult["sale_area"];?> - <?php echo $objResult["sale_name"];?></a>
	
	
<br>
	
<?php }
?>



</td>

<?php 

$strSQL = "SELECT distinct sale_area,sale_name  FROM tb_register_data where date_plan ='".$date_2."' and status_reser ='Approve'";

$objQuery = mysqli_query($com,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);

if($Num_Rows > 0){
?>
	<td width="14%" align="right" bgcolor="#FFFF99" class="style35">
<?php }else{
?>

<td width="14%" align="right"  class="style35">
<?php } ?>

<?php echo $day2 ; ?>&nbsp; 2<br>

<?php

while($objResult = mysqli_fetch_array($objQuery))
{
	?>
	<a href='status_baijong.php?sale_area=<?php echo $objResult["sale_area"];?>&date_plan=<?php echo  $date_2;?>'><span class="style39"><?php echo $objResult["sale_area"];?> - <?php echo $objResult["sale_name"];?></a>
<br>
	
<?php }
?>


</td>

<?php


$strSQL = "SELECT distinct sale_area,sale_name  FROM tb_register_data where date_plan ='".$date_3."' and status_reser ='Approve'";

$objQuery = mysqli_query($com,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);

if($Num_Rows > 0){
?>
	<td width="14%" align="right" bgcolor="#FFFF99" class="style35">
<?php }else{
?>

<td width="14%" align="right"  class="style35">
<?php } ?>


<?php echo $day3 ; ?>&nbsp; 3

<br>

<?php 

while($objResult = mysqli_fetch_array($objQuery))
{
	?>
	<a href='status_baijong.php?sale_area=<?php echo $objResult["sale_area"];?>&date_plan=<?php echo  $date_3;?>'><span class="style39"><?php echo $objResult["sale_area"];?> - <?php echo $objResult["sale_name"];?></a>	
<br>
	
<?php }
?>

</td>

<?php


$strSQL = "SELECT distinct sale_area,sale_name  FROM tb_register_data where date_plan ='".$date_4."' and status_reser ='Approve'";

$objQuery = mysqli_query($com,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);

if($Num_Rows > 0){
?>
	<td width="14%" align="right" bgcolor="#FFFF99" class="style35">
<?php }else{
?>

<td width="14%" align="right"  class="style35">
<?php } ?>




<?php echo $day4 ; ?>&nbsp; 4

 <br>

<?php 


while($objResult = mysqli_fetch_array($objQuery))
{
	?>
<a href='status_baijong.php?sale_area=<?php echo $objResult["sale_area"];?>&date_plan=<?php echo  $date_4;?>'><span class="style39"><?php echo $objResult["sale_area"];?> - <?php echo $objResult["sale_name"];?></a>
<br>
	
<?php }
?>

</td>

<?php


$strSQL = "SELECT distinct sale_area,sale_name  FROM tb_register_data where date_plan ='".$date_5."' and status_reser ='Approve'";

$objQuery = mysqli_query($com,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);

if($Num_Rows > 0){
?>
	<td width="14%" align="right" bgcolor="#FFFF99" class="style35">
<?php }else{
?>

<td width="14%" align="right"  class="style35">
<?php } ?>



<?php echo $day5 ; ?>&nbsp; 5

<br>

<?php 


while($objResult = mysqli_fetch_array($objQuery))
{
	?>
	<a href='status_baijong.php?sale_area=<?php echo $objResult["sale_area"];?>&date_plan=<?php echo  $date_5;?>'><span class="style39"><?php echo $objResult["sale_area"];?> - <?php echo $objResult["sale_name"];?></a>
<br>
	
<?php }
?>

</td>

<?php


$strSQL = "SELECT distinct sale_area,sale_name  FROM tb_register_data where date_plan ='".$date_6."' and status_reser ='Approve'";

$objQuery = mysqli_query($com,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);

if($Num_Rows > 0){
?>
	<td width="14%" align="right" bgcolor="#FFFF99" class="style35">
<?php }else{
?>

<td width="14%" align="right"  class="style35">
<?php } ?>



<?php echo $day6 ; ?>&nbsp; 6<br>


<?php 


while($objResult = mysqli_fetch_array($objQuery))
{
	?>
<a href='status_baijong.php?sale_area=<?php echo $objResult["sale_area"];?>&date_plan=<?php echo  $date_6;?>'><span class="style39"><?php echo $objResult["sale_area"];?> - <?php echo $objResult["sale_name"];?></a>
<br>
	
<?php }
?>

</td>
<?php


$strSQL = "SELECT distinct sale_area,sale_name  FROM tb_register_data where date_plan ='".$date_7."' and status_reser ='Approve'";

$objQuery = mysqli_query($com,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);

if($Num_Rows > 0){
?>
	<td width="14%" align="right" bgcolor="#FFFF99" class="style35">
<?php }else{
?>

<td width="14%" align="right"  class="style35">
<?php } ?>

<?php echo $day7 ; ?>&nbsp; 7<br>

<?php 

while($objResult = mysqli_fetch_array($objQuery))
{
	?>
<a href='status_baijong.php?sale_area=<?php echo $objResult["sale_area"];?>&date_plan=<?php echo  $date_7;?>'><span class="style39"><?php echo $objResult["sale_area"];?> - <?php echo $objResult["sale_name"];?></a>
<br>
	
<?php }
?>


</td>

</tr>


		
			






<tr>
<?php


$strSQL = "SELECT distinct sale_area,sale_name  FROM tb_register_data where date_plan ='".$date_8."' and status_reser ='Approve'";

$objQuery = mysqli_query($com,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);

if($Num_Rows > 0){
?>
	<td width="14%" align="right" bgcolor="#FFFF99" class="style35">
<?php }else{
?>

<td width="14%" align="right"  class="style35">
<?php } ?>

<?php echo $day8 ; ?>&nbsp; 8<br>

<?php 

while($objResult = mysqli_fetch_array($objQuery))
{
	?>
	<a href='status_baijong.php?sale_area=<?php echo $objResult["sale_area"];?>&date_plan=<?php echo  $date_8;?>'><span class="style39"><?php echo $objResult["sale_area"];?> - <?php echo $objResult["sale_name"];?></a>
<br>
	
<?php }
?>


</td>
<?php


$strSQL = "SELECT distinct sale_area,sale_name  FROM tb_register_data where date_plan ='".$date_9."' and status_reser ='Approve'";

$objQuery = mysqli_query($com,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);

if($Num_Rows > 0){
?>
	<td width="14%" align="right" bgcolor="#FFFF99" class="style35">
<?php }else{
?>

<td width="14%" align="right"  class="style35">
<?php } ?>

<?php echo $day9 ; ?>&nbsp; 9<br>

<?php 


while($objResult = mysqli_fetch_array($objQuery))
{
	?>
	<a href='status_baijong.php?sale_area=<?php echo $objResult["sale_area"];?>&date_plan=<?php echo  $date_9;?>'><span class="style39"><?php echo $objResult["sale_area"];?> - <?php echo $objResult["sale_name"];?></a>
<br>
	
<?php }
?>

</td>
<?php


$strSQL = "SELECT distinct sale_area,sale_name  FROM tb_register_data where date_plan ='".$date_10."' and status_reser ='Approve'";

$objQuery = mysqli_query($com,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);

if($Num_Rows > 0){
?>
	<td width="14%" align="right" bgcolor="#FFFF99" class="style35">
<?php }else{
?>

<td width="14%" align="right"  class="style35">
<?php } ?>


<?php echo $day10 ; ?>&nbsp; 10<br>

<?php 

while($objResult = mysqli_fetch_array($objQuery))
{
	?>	<a href='status_baijong.php?sale_area=<?php echo $objResult["sale_area"];?>&date_plan=<?php echo  $date_10;?>'><span class="style39"><?php echo $objResult["sale_area"];?> - <?php echo $objResult["sale_name"];?></a>
<br>
	
<?php }
?>


</td>
<?php


$strSQL = "SELECT distinct sale_area,sale_name  FROM tb_register_data where date_plan ='".$date_11."' and status_reser ='Approve'";

$objQuery = mysqli_query($com,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);

if($Num_Rows > 0){
?>
	<td width="14%" align="right" bgcolor="#FFFF99" class="style35">
<?php }else{
?>

<td width="14%" align="right"  class="style35">
<?php } ?>

<?php echo $day11 ; ?>&nbsp; 11<br>

<?php 

while($objResult = mysqli_fetch_array($objQuery))
{
	?>	<a href='status_baijong.php?sale_area=<?php echo $objResult["sale_area"];?>&date_plan=<?php echo  $date_11;?>'><span class="style39"><?php echo $objResult["sale_area"];?> - <?php echo $objResult["sale_name"];?></a>
<br>
	
<?php }
?>

</td>
<?php


$strSQL = "SELECT distinct sale_area,sale_name  FROM tb_register_data where date_plan ='".$date_12."' and status_reser ='Approve'";

$objQuery = mysqli_query($com,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);

if($Num_Rows > 0){
?>
	<td width="14%" align="right" bgcolor="#FFFF99" class="style35">
<?php }else{
?>

<td width="14%" align="right"  class="style35">
<?php } ?>

<?php echo $day12 ; ?>&nbsp; 12<br>

<?php 

while($objResult = mysqli_fetch_array($objQuery))
{
	?>
	<a href='status_baijong.php?sale_area=<?php echo $objResult["sale_area"];?>&date_plan=<?php echo  $date_12;?>'><span class="style39"><?php echo $objResult["sale_area"];?> - <?php echo $objResult["sale_name"];?></a>
	
<br>
	
<?php }
?>

</td>
<?php


$strSQL = "SELECT distinct sale_area,sale_name  FROM tb_register_data where date_plan ='".$date_13."' and status_reser ='Approve'";

$objQuery = mysqli_query($com,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);

if($Num_Rows > 0){
?>
	<td width="14%" align="right" bgcolor="#FFFF99" class="style35">
<?php }else{
?>

<td width="14%" align="right"  class="style35">
<?php } ?>

<?php echo $day13 ; ?>&nbsp; 13<br>

<?php 

while($objResult = mysqli_fetch_array($objQuery))
{
	?>
	<a href='status_baijong.php?sale_area=<?php echo $objResult["sale_area"];?>&date_plan=<?php echo  $date_13;?>'><span class="style39"><?php echo $objResult["sale_area"];?> - <?php echo $objResult["sale_name"];?></a>
<br>
	
<?php }
?>

</td>
<?php


$strSQL = "SELECT distinct sale_area,sale_name  FROM tb_register_data where date_plan ='".$date_14."' and status_reser ='Approve'";

$objQuery = mysqli_query($com,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);

if($Num_Rows > 0){
?>
	<td width="14%" align="right" bgcolor="#FFFF99" class="style35">
<?php }else{
?>

<td width="14%" align="right"  class="style35">
<?php } ?>

<?php echo $day14 ; ?>&nbsp; 14<br>

<?php 


while($objResult = mysqli_fetch_array($objQuery))
{
	?>
	<a href='status_baijong.php?sale_area=<?php echo $objResult["sale_area"];?>&date_plan=<?php echo  $date_14;?>'><span class="style39"><?php echo $objResult["sale_area"];?> - <?php echo $objResult["sale_name"];?></a>
<br>
	
<?php }
?>

</td>

</tr>


<tr>
<?php


$strSQL = "SELECT distinct sale_area,sale_name  FROM tb_register_data where date_plan ='".$date_15."' and status_reser ='Approve'";

$objQuery = mysqli_query($com,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);

if($Num_Rows > 0){
?>
	<td width="14%" align="right" bgcolor="#FFFF99" class="style35">
<?php }else{
?>

<td width="14%" align="right"  class="style35">
<?php } ?>
<?php echo $day8 ; ?>&nbsp; 15<br>
<?php 

while($objResult = mysqli_fetch_array($objQuery))
{
	?>
	<a href='status_baijong.php?sale_area=<?php echo $objResult["sale_area"];?>&date_plan=<?php echo  $date_15;?>'><span class="style39"><?php echo $objResult["sale_area"];?> - <?php echo $objResult["sale_name"];?></a>
<br>
	
<?php }
?>

</td>
<?php


$strSQL = "SELECT distinct sale_area,sale_name  FROM tb_register_data where date_plan ='".$date_16."' and status_reser ='Approve'";

$objQuery = mysqli_query($com,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);

if($Num_Rows > 0){
?>
	<td width="14%" align="right" bgcolor="#FFFF99" class="style35">
<?php }else{
?>

<td width="14%" align="right"  class="style35">
<?php } ?>

<?php echo $day9 ; ?>&nbsp; 16<br>

<?php 

while($objResult = mysqli_fetch_array($objQuery))
{
	?>
	<a href='status_baijong.php?sale_area=<?php echo $objResult["sale_area"];?>&date_plan=<?php echo  $date_16;?>'><span class="style39"><?php echo $objResult["sale_area"];?> - <?php echo $objResult["sale_name"];?></a>
<br>
	
<?php }
?>

</td>
<?php


$strSQL = "SELECT distinct sale_area,sale_name  FROM tb_register_data where date_plan ='".$date_17."' and status_reser ='Approve'";

$objQuery = mysqli_query($com,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);

if($Num_Rows > 0){
?>
	<td width="14%" align="right" bgcolor="#FFFF99" class="style35">
<?php }else{
?>

<td width="14%" align="right"  class="style35">
<?php } ?>
<?php echo $day10 ; ?>&nbsp; 17<br>
<?php 

while($objResult = mysqli_fetch_array($objQuery))
{
	?>
	<a href='status_baijong.php?sale_area=<?php echo $objResult["sale_area"];?>&date_plan=<?php echo  $date_17;?>'><span class="style39"><?php echo $objResult["sale_area"];?> - <?php echo $objResult["sale_name"];?></a>
<br>
	
<?php }
?>

</td>
<?php


$strSQL = "SELECT distinct sale_area,sale_name  FROM tb_register_data where date_plan ='".$date_18."' and status_reser ='Approve'";

$objQuery = mysqli_query($com,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);

if($Num_Rows > 0){
?>
	<td width="14%" align="right" bgcolor="#FFFF99" class="style35">
<?php }else{
?>

<td width="14%" align="right"  class="style35">
<?php } ?>
<?php echo $day18 ; ?>&nbsp; 18<br>

<?php 

while($objResult = mysqli_fetch_array($objQuery))
{
	?>
	<a href='status_baijong.php?sale_area=<?php echo $objResult["sale_area"];?>&date_plan=<?php echo  $date_18;?>'><span class="style39"><?php echo $objResult["sale_area"];?> - <?php echo $objResult["sale_name"];?></a>
<br>
	
<?php }
?>

</td>
<?php


$strSQL = "SELECT distinct sale_area,sale_name  FROM tb_register_data where date_plan ='".$date_19."' and status_reser ='Approve'";

$objQuery = mysqli_query($com,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);

if($Num_Rows > 0){
?>
	<td width="14%" align="right" bgcolor="#FFFF99" class="style35">
<?php }else{
?>

<td width="14%" align="right"  class="style35">
<?php } ?>
<?php echo $day19 ; ?>&nbsp; 19<br>

<?php 

while($objResult = mysqli_fetch_array($objQuery))
{
	?>
		<a href='status_baijong.php?sale_area=<?php echo $objResult["sale_area"];?>&date_plan=<?php echo  $date_19;?>'><span class="style39"><?php echo $objResult["sale_area"];?> - <?php echo $objResult["sale_name"];?></a>
<br>
	
<?php }
?>

</td>
<?php


$strSQL = "SELECT distinct sale_area,sale_name  FROM tb_register_data where date_plan ='".$date_20."' and status_reser ='Approve'";

$objQuery = mysqli_query($com,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);

if($Num_Rows > 0){
?>
	<td width="14%" align="right" bgcolor="#FFFF99" class="style35">
<?php }else{
?>

<td width="14%" align="right"  class="style35">
<?php } ?>
<?php echo $day20 ; ?>&nbsp; 20<br>

<?php 


while($objResult = mysqli_fetch_array($objQuery))
{
	?>
	
		<a href='status_baijong.php?sale_area=<?php echo $objResult["sale_area"];?>&date_plan=<?php echo  $date_20;?>'><span class="style39"><?php echo $objResult["sale_area"];?> - <?php echo $objResult["sale_name"];?></a>
<br>
	
<?php }
?>

</td>
<?php


$strSQL = "SELECT distinct sale_area,sale_name  FROM tb_register_data where date_plan ='".$date_21."' and status_reser ='Approve'";

$objQuery = mysqli_query($com,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);

if($Num_Rows > 0){
?>
	<td width="14%" align="right" bgcolor="#FFFF99" class="style35">
<?php }else{
?>

<td width="14%" align="right"  class="style35">
<?php } ?>
<?php echo $day21 ; ?>&nbsp; 21<br>

<?php 

while($objResult = mysqli_fetch_array($objQuery))
{
	?>
	<a href='status_baijong.php?sale_area=<?php echo $objResult["sale_area"];?>&date_plan=<?php echo  $date_21;?>'><span class="style39"><?php echo $objResult["sale_area"];?> - <?php echo $objResult["sale_name"];?></a>
<br>
	
<?php }
?>

</td>

</tr>




<tr>
<?php


$strSQL = "SELECT distinct sale_area,sale_name  FROM tb_register_data where date_plan ='".$date_22."' and status_reser ='Approve'";

$objQuery = mysqli_query($com,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);

if($Num_Rows > 0){
?>
	<td width="14%" align="right" bgcolor="#FFFF99" class="style35">
<?php }else{
?>

<td width="14%" align="right"  class="style35">
<?php } ?>
<?php echo $day22 ; ?>&nbsp; 22<br>
<?php 

while($objResult = mysqli_fetch_array($objQuery))
{
	?>
	<a href='status_baijong.php?sale_area=<?php echo $objResult["sale_area"];?>&date_plan=<?php echo  $date_22;?>'><span class="style39"><?php echo $objResult["sale_area"];?> - <?php echo $objResult["sale_name"];?></a>
<br>
	
<?php }
?>

</td>
<<?php


$strSQL = "SELECT distinct sale_area,sale_name  FROM tb_register_data where date_plan ='".$date_23."' and status_reser ='Approve'";

$objQuery = mysqli_query($com,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);

if($Num_Rows > 0){
?>
	<td width="14%" align="right" bgcolor="#FFFF99" class="style35">
<?php }else{
?>

<td width="14%" align="right"  class="style35">
<?php } ?>
<?php echo $day23 ; ?>&nbsp; 23<br>
<?php 

while($objResult = mysqli_fetch_array($objQuery))
{
	?><a href='status_baijong.php?sale_area=<?php echo $objResult["sale_area"];?>&date_plan=<?php echo  $date_23;?>'><span class="style39"><?php echo $objResult["sale_area"];?> - <?php echo $objResult["sale_name"];?></a>
<br>
	
<?php }
?>

</td>
<?php


$strSQL = "SELECT distinct sale_area,sale_name  FROM tb_register_data where date_plan ='".$date_24."' and status_reser ='Approve'";

$objQuery = mysqli_query($com,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);

if($Num_Rows > 0){
?>
	<td width="14%" align="right" bgcolor="#FFFF99" class="style35">
<?php }else{
?>

<td width="14%" align="right"  class="style35">
<?php } ?>
<?php echo $day24 ; ?>&nbsp; 24<br>
<?php 

while($objResult = mysqli_fetch_array($objQuery))
{
	?>
	<a href='status_baijong.php?sale_area=<?php echo $objResult["sale_area"];?>&date_plan=<?php echo  $date_24;?>'><span class="style39"><?php echo $objResult["sale_area"];?> - <?php echo $objResult["sale_name"];?></a>
<br>
	
<?php }
?>

</td>
<?php


$strSQL = "SELECT distinct sale_area,sale_name  FROM tb_register_data where date_plan ='".$date_25."' and status_reser ='Approve'";

$objQuery = mysqli_query($com,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);

if($Num_Rows > 0){
?>
	<td width="14%" align="right" bgcolor="#FFFF99" class="style35">
<?php }else{
?>

<td width="14%" align="right"  class="style35">
<?php } ?>
<?php echo $day25 ; ?>&nbsp; 25<br>
<?php 

while($objResult = mysqli_fetch_array($objQuery))
{
	?>
	<a href='status_baijong.php?sale_area=<?php echo $objResult["sale_area"];?>&date_plan=<?php echo  $date_25;?>'><span class="style39"><?php echo $objResult["sale_area"];?> - <?php echo $objResult["sale_name"];?></a>
<br>
	
<?php }
?>

</td>
<?php


$strSQL = "SELECT distinct sale_area,sale_name  FROM tb_register_data where date_plan ='".$date_26."' and status_reser ='Approve'";

$objQuery = mysqli_query($com,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);

if($Num_Rows > 0){
?>
	<td width="14%" align="right" bgcolor="#FFFF99" class="style35">
<?php }else{
?>

<td width="14%" align="right"  class="style35">
<?php } ?>
<?php echo $day26 ; ?>&nbsp; 26<br>
<?php 

while($objResult = mysqli_fetch_array($objQuery))
{
	?>
	<a href='status_baijong.php?sale_area=<?php echo $objResult["sale_area"];?>&date_plan=<?php echo  $date_26;?>'><span class="style39"><?php echo $objResult["sale_area"];?> - <?php echo $objResult["sale_name"];?></a>
<br>
	
<?php }
?>

</td>
<?php


$strSQL = "SELECT distinct sale_area,sale_name  FROM tb_register_data where date_plan ='".$date_27."' and status_reser ='Approve'";

$objQuery = mysqli_query($com,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);

if($Num_Rows > 0){
?>
	<td width="14%" align="right" bgcolor="#FFFF99" class="style35">
<?php }else{
?>

<td width="14%" align="right"  class="style35">
<?php } ?>
<?php echo $day27 ; ?>&nbsp; 27<br>
<?php 

while($objResult = mysqli_fetch_array($objQuery))
{
	?>
	<a href='status_baijong.php?sale_area=<?php echo $objResult["sale_area"];?>&date_plan=<?php echo  $date_27;?>'><span class="style39"><?php echo $objResult["sale_area"];?> - <?php echo $objResult["sale_name"];?></a>
<br>
	
<?php }
?>

</td>
<?php


$strSQL = "SELECT distinct sale_area,sale_name  FROM tb_register_data where date_plan ='".$date_28."' and status_reser ='Approve'";

$objQuery = mysqli_query($com,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);

if($Num_Rows > 0){
?>
	<td width="14%" align="right" bgcolor="#FFFF99" class="style35">
<?php }else{
?>

<td width="14%" align="right"  class="style35">
<?php } ?>
<?php echo $day28 ; ?>&nbsp; 28<br>

<?php 

while($objResult = mysqli_fetch_array($objQuery))
{
	?><a href='status_baijong.php?sale_area=<?php echo $objResult["sale_area"];?>&date_plan=<?php echo  $date_28;?>'><span class="style39"><?php echo $objResult["sale_area"];?> - <?php echo $objResult["sale_name"];?></a>
<br>
	
<?php }
?>

</td>

</tr>


<tr>
<?php


$strSQL = "SELECT distinct sale_area,sale_name  FROM tb_register_data where date_plan ='".$date_29."' and status_reser ='Approve'";

$objQuery = mysqli_query($com,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);

if($Num_Rows > 0){
?>
	<td width="14%" align="right" bgcolor="#FFFF99" class="style35">
<?php }else{
?>

<td width="14%" align="right"  class="style35">
<?php } ?>
<?php echo $day29 ; ?>&nbsp; 29<br>

<?php 

while($objResult = mysqli_fetch_array($objQuery))
{
	?><a href='status_baijong.php?sale_area=<?php echo $objResult["sale_area"];?>&date_plan=<?php echo  $date_29;?>'><span class="style39"><?php echo $objResult["sale_area"];?> - <?php echo $objResult["sale_name"];?></a>
<br>
	
<?php }
?>

</td>
<?php


$strSQL = "SELECT distinct sale_area,sale_name  FROM tb_register_data where date_plan ='".$date_30."' and status_reser ='Approve'";

$objQuery = mysqli_query($com,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);

if($Num_Rows > 0){
?>
	<td width="14%" align="right" bgcolor="#FFFF99" class="style35">
<?php }else{
?>

<td width="14%" align="right"  class="style35">
<?php } ?>
<?php echo $day30 ; ?>&nbsp; 30<br>

<?php 

while($objResult = mysqli_fetch_array($objQuery))
{
	?>
	<a href='status_baijong.php?sale_area=<?php echo $objResult["sale_area"];?>&date_plan=<?php echo  $date_30;?>'><span class="style39"><?php echo $objResult["sale_area"];?> - <?php echo $objResult["sale_name"];?></a>
<br>
	
<?php }
?>

</td>
<?php


$strSQL = "SELECT distinct sale_area,sale_name  FROM tb_register_data where date_plan ='".$date_31."' and status_reser ='Approve'";

$objQuery = mysqli_query($com,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);

if($Num_Rows > 0){
?>
	<td width="14%" align="right" bgcolor="#FFFF99" class="style35">
<?php }else{
?>

<td width="14%" align="right"  class="style35">
<?php } ?>
<?php echo $day31 ; ?>&nbsp; 31 <br>

<?php 

while($objResult = mysqli_fetch_array($objQuery))
{
	?>
	<a href='status_baijong.php?sale_area=<?php echo $objResult["sale_area"];?>&date_plan=<?php echo  $date_31;?>'><span class="style39"><?php echo $objResult["sale_area"];?> - <?php echo $objResult["sale_name"];?></a>
<br>
	
<?php }
?>

</td>

</tr>



</table>

<p><br />
    

     </form>
	          

</body>
</html>