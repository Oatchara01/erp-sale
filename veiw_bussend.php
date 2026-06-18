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


 <div class="w3-container w3-white"><br>
<center>
<h2><span class="style15">สมุดลงงานรถใหญ่</span></h2>
<?php 
$start_date = date("Y-m-d");

$date_arr = explode('-' , $start_date );
$mm = $date_arr[1];
$yy = $date_arr[0];
$_month_name = array("01"=>"มกราคม",  "02"=>"กุมภาพันธ์",  "03"=>"มีนาคม", "04"=>"เมษายน",  "05"=>"พฤษภาคม",  "06"=>"มิถุนายน","07"=>"กรกฎาคม",  "08"=>"สิงหาคม",  "09"=>"กันยายน",
"10"=>"ตุลาคม", "11"=>"พฤศจิกายน",  "12"=>"ธันวาคม");

$thai= $_month_name[$mm];
$year =$yy+543;

?>

<h2><span class="style15"><?php echo $thai; ?> &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $year; ?></span></h2>          
		  
   </center>


<form name="frmSearch" method="GET" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">


<?php		  

include "dbconnect_cs.php";

$date_now = date("Y-m");


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
<td width="5%" align="right"  class="style35"></td>
<td width="15%" align="right"  class="style35"><?php echo $day1 ; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1</td>
<td width="15%" align="right"  class="style35"><?php echo $day2 ; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2</td>
<td width="15%" align="right"  class="style35"><?php echo $day3 ; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 3</td>
<td width="15%" align="right"  class="style35"><?php echo $day4 ; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 4</td>
<td width="15%" align="right"  class="style35"><?php echo $day5 ; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 5</td>
<td width="15%" align="right"  class="style35"><?php echo $day6 ; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 6</td>
<td width="15%" align="right"  class="style35"><?php echo $day7 ; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 7</td>

</tr>

<tr>

<td align="center" bgcolor="CC99CC" class="style35"> <?php echo "คันที่ 1 8952"; ?>
		</td>


		<td align="left" bgcolor="CC99CC" class="style35">
<?php 

$strSQL = "SELECT *  FROM tb_register_data where start_date ='".$date_1."' and code_bus='1'";

$objQuery = mysqli_query($com1,$strSQL) or die ("Error Query [".$strSQL."]");
$Num_Rows = mysqli_num_rows($objQuery);

while($objResult = mysqli_fetch_array($objQuery))
{
	?><span class="style39"><?php echo $objResult["employee_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult["address_name"];?>
<br>
<span class="style40"><?php echo $objResult["start_time"];?><?php echo '-';?><?php echo $objResult["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL60 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_1."' and bus_code = '1' and status = 'ใช้งาน'";

$objQuery60 = mysqli_query($com1,$strSQL60) or die ("Error Query [".$strSQL60."]");
$Num_Rows60 = mysqli_num_rows($objQuery60);

while($objResult60 = mysqli_fetch_array($objQuery60))
{
	?><span class="style39"><?php echo $objResult60["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult60["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult60["description"];?>
<br>


<?php }
?>



		</td>

		<td align="left" bgcolor="CC99CC" class="style35">

<?php 

$strSQL2 = "SELECT *  FROM tb_register_data where start_date ='".$date_2."' and code_bus='1'";

$objQuery2 = mysqli_query($com1,$strSQL2) or die ("Error Query [".$strSQL2."]");
$Num_Rows2 = mysqli_num_rows($objQuery2);

while($objResult2 = mysqli_fetch_array($objQuery2))
{
	?>
			<span class="style39"><?php echo $objResult2["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult2["address_name"];?>
<br>
<span class="style40"><?php echo $objResult2["start_time"];?><?php echo '-';?><?php echo $objResult2["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL61 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_2."' and bus_code = '1' and status = 'ใช้งาน'";

$objQuery61 = mysqli_query($com1,$strSQL61) or die ("Error Query [".$strSQL61."]");
$Num_Rows61 = mysqli_num_rows($objQuery61);

while($objResult61 = mysqli_fetch_array($objQuery61))
{
	?><span class="style39"><?php echo $objResult61["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult61["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult61["description"];?>
<br>


<?php }
?>




		</td>
	
	<td align="left" bgcolor="CC99CC" class="style35">

<?php 

$strSQL3 = "SELECT *  FROM tb_register_data where start_date ='".$date_3."' and code_bus='1'";

$objQuery3 = mysqli_query($com1,$strSQL3) or die ("Error Query [".$strSQL3."]");
$Num_Rows3 = mysqli_num_rows($objQuery3);

while($objResult3 = mysqli_fetch_array($objQuery3))
{
	?>
			<span class="style39"><?php echo $objResult3["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult3["address_name"];?>
<br>
<span class="style40"><?php echo $objResult3["start_time"];?><?php echo '-';?><?php echo $objResult3["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL62 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_3."' and bus_code = '1' and status = 'ใช้งาน'";

$objQuery62 = mysqli_query($com1,$strSQL62) or die ("Error Query [".$strSQL62."]");
$Num_Rows62 = mysqli_num_rows($objQuery62);

while($objResult62 = mysqli_fetch_array($objQuery62))
{
	?><span class="style39"><?php echo $objResult62["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult62["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult62["description"];?>
<br>


<?php }
?>

		</td>

	<td align="left" bgcolor="CC99CC" class="style35">

	
<?php 

$strSQL4 = "SELECT *  FROM tb_register_data where start_date ='".$date_4."' and code_bus='1'";

$objQuery4 = mysqli_query($com1,$strSQL4) or die ("Error Query [".$strSQL4."]");
$Num_Rows4 = mysqli_num_rows($objQuery4);




while($objResult4 = mysqli_fetch_array($objQuery4))
{
	?>
	<span class="style39"><?php echo $objResult4["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult4["address_name"];?>
<br>
<span class="style40"><?php echo $objResult4["start_time"];?><?php echo '-';?><?php echo $objResult4["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL63 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_4."' and bus_code = '1' and status = 'ใช้งาน'";

$objQuery63 = mysqli_query($com1,$strSQL63) or die ("Error Query [".$strSQL63."]");
$Num_Rows63 = mysqli_num_rows($objQuery63);

while($objResult63 = mysqli_fetch_array($objQuery63))
{
	?><span class="style39"><?php echo $objResult63["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult63["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult63["description"];?>
<br>


<?php }
?>

		</td>

	<td align="left" bgcolor="CC99CC" class="style35">
	<?php 

$strSQL5 = "SELECT *  FROM tb_register_data where start_date ='".$date_5."' and code_bus='1'";

$objQuery5 = mysqli_query($com1,$strSQL5) or die ("Error Query [".$strSQL5."]");
$Num_Rows5 = mysqli_num_rows($objQuery5);

while($objResult5 = mysqli_fetch_array($objQuery5))
{
	?>
		<span class="style39"><?php echo $objResult5["employee_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult5["address_name"];?>
<br>
<span class="style40"><?php echo $objResult5["start_time"];?><?php echo '-';?><?php echo $objResult5["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL64 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_5."' and bus_code = '1'  and status = 'ใช้งาน'";

$objQuery64 = mysqli_query($com1,$strSQL64) or die ("Error Query [".$strSQL64."]");
$Num_Rows64 = mysqli_num_rows($objQuery64);

while($objResult64 = mysqli_fetch_array($objQuery64))
{
	?><span class="style39"><?php echo $objResult64["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult64["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult64["description"];?>
<br>


<?php }
?>

		</td>

	
	<td align="left" bgcolor="CC99CC" class="style35">

	<?php 

$strSQL6 = "SELECT *  FROM tb_register_data where start_date ='".$date_6."' and code_bus='1'";

$objQuery6 = mysqli_query($com1,$strSQL6) or die ("Error Query [".$strSQL6."]");
$Num_Rows6 = mysqli_num_rows($objQuery6);
while($objResult6 = mysqli_fetch_array($objQuery6))
{
	?>
		<span class="style39"><?php echo $objResult6["employee_send"];?></span>
<br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult6["address_name"];?>
<br>
<span class="style40"><?php echo $objResult6["start_time"];?><?php echo '-';?><?php echo $objResult6["end_time"];?></span>
<br>


<?php }
?>
		

<?php 

$strSQL65 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_6."' and bus_code = '1'  and status = 'ใช้งาน'";

$objQuery65 = mysqli_query($com1,$strSQL65) or die ("Error Query [".$strSQL65."]");
$Num_Rows65 = mysqli_num_rows($objQuery65);

while($objResult65 = mysqli_fetch_array($objQuery65))
{
	?><span class="style39"><?php echo $objResult65["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult65["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult65["description"];?>
<br>


<?php }
?>

		</td>

	<td align="left" bgcolor="CC99CC" class="style35">

	<?php 

$strSQL7 = "SELECT *  FROM tb_register_data where start_date ='".$date_7."' and code_bus='1'";

$objQuery7 = mysqli_query($com1,$strSQL7) or die ("Error Query [".$strSQL7."]");
$Num_Rows7 = mysqli_num_rows($objQuery7);



while($objResult7 = mysqli_fetch_array($objQuery7))
{
	?>
		<span class="style39"><?php echo $objResult7["employee_send"];?></span>
<br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult7["address_name"];?>
<br>
<span class="style40"><?php echo $objResult7["start_time"];?><?php echo '-';?><?php echo $objResult7["end_time"];?></span>
<br>


<?php }
?>

		<?php 

$strSQL66 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_7."' and bus_code = '1'  and status = 'ใช้งาน'";

$objQuery66 = mysqli_query($com1,$strSQL66) or die ("Error Query [".$strSQL66."]");
$Num_Rows66 = mysqli_num_rows($objQuery66);

while($objResult66 = mysqli_fetch_array($objQuery66))
{
	?><span class="style39"><?php echo $objResult66["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult66["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult66["description"];?>
<br>


<?php }
?>

		</td>
	
	






		</tr>
	
		







<tr>

<td align="left" bgcolor="#CCFF99" class="style35"><?php echo "คันที่ 2 9322"; ?>
</td>

<td align="left" bgcolor="#CCFF99" class="style35">
<?php 

$strSQL8 = "SELECT *  FROM tb_register_data where start_date ='".$date_1."' and code_bus='2'";

$objQuery8 = mysqli_query($com1,$strSQL8) or die ("Error Query [".$strSQL8."]");
$Num_Rows8 = mysqli_num_rows($objQuery8);

while($objResult8 = mysqli_fetch_array($objQuery8))
{
	?><span class="style39"><?php echo $objResult8["employee_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult8["address_name"];?>
<br>
<span class="style40"><?php echo $objResult8["start_time"];?><?php echo '-';?><?php echo $objResult8["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL67 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_1."' and bus_code = '2'  and status = 'ใช้งาน'";

$objQuery67 = mysqli_query($com1,$strSQL67) or die ("Error Query [".$strSQL67."]");
$Num_Rows67 = mysqli_num_rows($objQuery67);

while($objResult67 = mysqli_fetch_array($objQuery67))
{
	?><span class="style39"><?php echo $objResult67["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult67["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult67["description"];?>
<br>


<?php }
?>



		</td>

		<td align="left" bgcolor="#CCFF99" class="style35">

<?php 

$strSQL9 = "SELECT *  FROM tb_register_data where start_date ='".$date_2."' and code_bus='2'";

$objQuery9 = mysqli_query($com1,$strSQL9) or die ("Error Query [".$strSQL9."]");
$Num_Rows9 = mysqli_num_rows($objQuery9);

while($objResult9 = mysqli_fetch_array($objQuery9))
{
	?>
			<span class="style39"><?php echo $objResult9["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult2["address_name"];?>
<br>
<span class="style40"><?php echo $objResult9["start_time"];?><?php echo '-';?><?php echo $objResult9["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL68 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_2."' and bus_code = '2'  and status = 'ใช้งาน'";

$objQuery68 = mysqli_query($com1,$strSQL68) or die ("Error Query [".$strSQL68."]");
$Num_Rows68 = mysqli_num_rows($objQuery68);

while($objResult68 = mysqli_fetch_array($objQuery68))
{
	?><span class="style39"><?php echo $objResult68["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult68["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult68["description"];?>
<br>


<?php }
?>



		</td>
	
	<td align="left" bgcolor="#CCFF99" class="style35">

<?php 

$strSQL10 = "SELECT *  FROM tb_register_data where start_date ='".$date_3."' and code_bus='2'";

$objQuery10 = mysqli_query($com1,$strSQL10) or die ("Error Query [".$strSQL10."]");
$Num_Rows10 = mysqli_num_rows($objQuery10);

while($objResult10 = mysqli_fetch_array($objQuery10))
{
	?>
			<span class="style39"><?php echo $objResult10["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult10["address_name"];?>
<br>
<span class="style40"><?php echo $objResult10["start_time"];?><?php echo '-';?><?php echo $objResult10["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL69 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_3."' and bus_code = '2'  and status = 'ใช้งาน'";

$objQuery69 = mysqli_query($com1,$strSQL69) or die ("Error Query [".$strSQL69."]");
$Num_Rows69 = mysqli_num_rows($objQuery69);

while($objResult68 = mysqli_fetch_array($objQuery69))
{
	?><span class="style39"><?php echo $objResult69["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult69["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult69["description"];?>
<br>


<?php }
?>


		</td>

	<td align="left" bgcolor="#CCFF99" class="style35">

	
<?php 

$strSQL11 = "SELECT *  FROM tb_register_data where start_date ='".$date_4."' and code_bus='2'";

$objQuery11 = mysqli_query($com1,$strSQL11) or die ("Error Query [".$strSQL11."]");
$Num_Rows11 = mysqli_num_rows($objQuery11);




while($objResult11 = mysqli_fetch_array($objQuery11))
{
	?>
	<span class="style39"><?php echo $objResult11["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult11["address_name"];?>
<br>
<span class="style40"><?php echo $objResult11["start_time"];?><?php echo '-';?><?php echo $objResult11["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL70 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_4."' and bus_code = '2'  and status = 'ใช้งาน'";

$objQuery70 = mysqli_query($com1,$strSQL70) or die ("Error Query [".$strSQL70."]");
$Num_Rows70 = mysqli_num_rows($objQuery70);

while($objResult70 = mysqli_fetch_array($objQuery70))
{
	?><span class="style39"><?php echo $objResult70["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult70["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult70["description"];?>
<br>


<?php }
?>

		</td>

	<td align="left" bgcolor="#CCFF99" class="style35">
	<?php 

$strSQL12 = "SELECT *  FROM tb_register_data where start_date ='".$date_5."' and code_bus='2'";

$objQuery12 = mysqli_query($com1,$strSQL12) or die ("Error Query [".$strSQL12."]");
$Num_Rows12 = mysqli_num_rows($objQuery12);

while($objResult12 = mysqli_fetch_array($objQuery12))
{
	?>
		<span class="style39"><?php echo $objResult12["employee_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult12["address_name"];?>
<br>
<span class="style40"><?php echo $objResult12["start_time"];?><?php echo '-';?><?php echo $objResult12["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL71 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_5."' and bus_code = '2'  and status = 'ใช้งาน'";

$objQuery71 = mysqli_query($com1,$strSQL71) or die ("Error Query [".$strSQL71."]");
$Num_Rows71 = mysqli_num_rows($objQuery71);

while($objResult71 = mysqli_fetch_array($objQuery71))
{
	?><span class="style39"><?php echo $objResult71["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult71["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult71["description"];?>
<br>


<?php }
?>

		</td>

	
	<td align="left" bgcolor="#CCFF99" class="style35">

	<?php 

$strSQL13 = "SELECT *  FROM tb_register_data where start_date ='".$date_6."' and code_bus='2'";

$objQuery13 = mysqli_query($com1,$strSQL13) or die ("Error Query [".$strSQL13."]");
$Num_Rows13 = mysqli_num_rows($objQuery13);
while($objResult13 = mysqli_fetch_array($objQuery13))
{
	?>
		<span class="style39"><?php echo $objResult13["employee_send"];?></span>
<br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult13["address_name"];?>
<br>
<span class="style40"><?php echo $objResult13["start_time"];?><?php echo '-';?><?php echo $objResult13["end_time"];?></span>
<br>


<?php }
?>
		
<?php 

$strSQL72 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_6."' and bus_code = '2'  and status = 'ใช้งาน'";

$objQuery72 = mysqli_query($com1,$strSQL72) or die ("Error Query [".$strSQL72."]");
$Num_Rows72 = mysqli_num_rows($objQuery72);

while($objResult72 = mysqli_fetch_array($objQuery72))
{
	?><span class="style39"><?php echo $objResult72["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult72["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult72["description"];?>
<br>


<?php }
?>

		</td>

	<td align="left" bgcolor="#CCFF99" class="style35">

	<?php 

$strSQL14 = "SELECT *  FROM tb_register_data where start_date ='".$date_7."' and code_bus='2'";

$objQuery14 = mysqli_query($com1,$strSQL14) or die ("Error Query [".$strSQL14."]");
$Num_Rows14 = mysqli_num_rows($objQuery14);



while($objResult14 = mysqli_fetch_array($objQuery14))
{
	?>
		<span class="style39"><?php echo $objResult14["employee_send"];?></span>
<br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult14["address_name"];?>
<br>
<span class="style40"><?php echo $objResult14["start_time"];?><?php echo '-';?><?php echo $objResult14["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL73 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_7."' and bus_code = '2'  and status = 'ใช้งาน'";

$objQuery73 = mysqli_query($com1,$strSQL73) or die ("Error Query [".$strSQL73."]");
$Num_Rows73 = mysqli_num_rows($objQuery73);

while($objResult73 = mysqli_fetch_array($objQuery73))
{
	?><span class="style39"><?php echo $objResult73["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult73["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult73["description"];?>
<br>


<?php }
?>

		</td>
	
		</tr>
		

<tr>

<td align="left" bgcolor="#00CCCC" class="style35"><?php echo "คันที่ 3 5644"; ?>
</td>

<td align="left" bgcolor="#00CCCC" class="style35">
<?php 

$strSQL15 = "SELECT *  FROM tb_register_data where start_date ='".$date_1."' and code_bus='3'";

$objQuery15 = mysqli_query($com1,$strSQL15) or die ("Error Query [".$strSQL15."]");
$Num_Rows15 = mysqli_num_rows($objQuery15);

while($objResult15 = mysqli_fetch_array($objQuery15))
{
	?><span class="style39"><?php echo $objResult15["employee_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult15["address_name"];?>
<br>
<span class="style40"><?php echo $objResult15["start_time"];?><?php echo '-';?><?php echo $objResult15["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL74 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_1."' and bus_code = '3'  and status = 'ใช้งาน'";

$objQuery74 = mysqli_query($com1,$strSQL74) or die ("Error Query [".$strSQL74."]");
$Num_Rows74 = mysqli_num_rows($objQuery74);

while($objResult73 = mysqli_fetch_array($objQuery74))
{
	?><span class="style39"><?php echo $objResult74["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult74["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult74["description"];?>
<br>


<?php }
?>



		</td>

		<td align="left" bgcolor="#00CCCC" class="style35">

<?php 

$strSQL16 = "SELECT *  FROM tb_register_data where start_date ='".$date_2."' and code_bus='3'";

$objQuery16 = mysqli_query($com1,$strSQL16) or die ("Error Query [".$strSQL16."]");
$Num_Rows16 = mysqli_num_rows($objQuery16);

while($objResult16 = mysqli_fetch_array($objQuery16))
{
	?>
			<span class="style39"><?php echo $objResult16["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult16["address_name"];?>
<br>
<span class="style40"><?php echo $objResult16["start_time"];?><?php echo '-';?><?php echo $objResult16["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL75 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_2."' and bus_code = '3'  and status = 'ใช้งาน'";

$objQuery75 = mysqli_query($com1,$strSQL75) or die ("Error Query [".$strSQL75."]");
$Num_Rows75 = mysqli_num_rows($objQuery75);

while($objResult75 = mysqli_fetch_array($objQuery75))
{
	?><span class="style39"><?php echo $objResult75["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult75["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult75["description"];?>
<br>


<?php }
?>



		</td>
	
	<td align="left" bgcolor="#00CCCC" class="style35">

<?php 

$strSQL17 = "SELECT *  FROM tb_register_data where start_date ='".$date_3."' and code_bus='3'";

$objQuery17 = mysqli_query($com1,$strSQL17) or die ("Error Query [".$strSQL17."]");
$Num_Rows17 = mysqli_num_rows($objQuery17);

while($objResult17 = mysqli_fetch_array($objQuery17))
{
	?>
			<span class="style39"><?php echo $objResult17["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult17["address_name"];?>
<br>
<span class="style40"><?php echo $objResult17["start_time"];?><?php echo '-';?><?php echo $objResult17["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL76 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_3."' and bus_code = '3'  and status = 'ใช้งาน'";

$objQuery76 = mysqli_query($com1,$strSQL76) or die ("Error Query [".$strSQL76."]");
$Num_Rows76 = mysqli_num_rows($objQuery76);

while($objResult76 = mysqli_fetch_array($objQuery76))
{
	?><span class="style39"><?php echo $objResult76["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult76["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult76["description"];?>
<br>


<?php }
?>

		</td>

	<td align="left" bgcolor="#00CCCC" class="style35">

	
<?php 

$strSQL18 = "SELECT *  FROM tb_register_data where start_date ='".$date_4."' and code_bus='3'";

$objQuery18 = mysqli_query($com1,$strSQL18) or die ("Error Query [".$strSQL18."]");
$Num_Rows18 = mysqli_num_rows($objQuery18);




while($objResult18 = mysqli_fetch_array($objQuery18))
{
	?>
	<span class="style39"><?php echo $objResult18["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult18["address_name"];?>
<br>
<span class="style40"><?php echo $objResult18["start_time"];?><?php echo '-';?><?php echo $objResult18["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL77 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_4."' and bus_code = '3'  and status = 'ใช้งาน'";

$objQuery77 = mysqli_query($com1,$strSQL77) or die ("Error Query [".$strSQL77."]");
$Num_Rows77 = mysqli_num_rows($objQuery77);

while($objResult77 = mysqli_fetch_array($objQuery77))
{
	?><span class="style39"><?php echo $objResult77["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult77["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult77["description"];?>
<br>


<?php }
?>

		</td>

	<td align="left" bgcolor="#00CCCC" class="style35">
	<?php 

$strSQL19 = "SELECT *  FROM tb_register_data where start_date ='".$date_5."' and code_bus='3'";

$objQuery19 = mysqli_query($com1,$strSQL19) or die ("Error Query [".$strSQL19."]");
$Num_Rows19 = mysqli_num_rows($objQuery19);

while($objResult19 = mysqli_fetch_array($objQuery19))
{
	?>
		<span class="style39"><?php echo $objResult19["employee_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult19["address_name"];?>
<br>
<span class="style40"><?php echo $objResult19["start_time"];?><?php echo '-';?><?php echo $objResult19["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL78 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_5."' and bus_code = '3'  and status = 'ใช้งาน'";

$objQuery78 = mysqli_query($com1,$strSQL78) or die ("Error Query [".$strSQL78."]");
$Num_Rows78 = mysqli_num_rows($objQuery78);

while($objResult78 = mysqli_fetch_array($objQuery78))
{
	?><span class="style39"><?php echo $objResult78["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult78["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult78["description"];?>
<br>


<?php }
?>

		</td>

	
	<td align="left" bgcolor="#00CCCC" class="style35">

	<?php 

$strSQL20 = "SELECT *  FROM tb_register_data where start_date ='".$date_6."' and code_bus='3'";

$objQuery20 = mysqli_query($com1,$strSQL20) or die ("Error Query [".$strSQL20."]");
$Num_Rows20 = mysqli_num_rows($objQuery20);
while($objResult20 = mysqli_fetch_array($objQuery20))
{
	?>
		<span class="style39"><?php echo $objResult20["employee_send"];?></span>
<br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult20["address_name"];?>
<br>
<span class="style40"><?php echo $objResult20["start_time"];?><?php echo '-';?><?php echo $objResult20["end_time"];?></span>
<br>


<?php }
?>
		
<?php 

$strSQL79 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_6."' and bus_code = '3'  and status = 'ใช้งาน'";

$objQuery79 = mysqli_query($com1,$strSQL79) or die ("Error Query [".$strSQL79."]");
$Num_Rows79 = mysqli_num_rows($objQuery79);

while($objResult79 = mysqli_fetch_array($objQuery79))
{
	?><span class="style39"><?php echo $objResult79["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult79["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult79["description"];?>
<br>


<?php }
?>

		</td>

	<td align="left" bgcolor="#00CCCC" class="style35">

	<?php 

$strSQL21 = "SELECT *  FROM tb_register_data where start_date ='".$date_7."' and code_bus='3'";

$objQuery21 = mysqli_query($com1,$strSQL21) or die ("Error Query [".$strSQL21."]");
$Num_Rows21 = mysqli_num_rows($objQuery21);



while($objResult21 = mysqli_fetch_array($objQuery21))
{
	?>
		<span class="style39"><?php echo $objResult21["employee_send"];?></span>
<br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult21["address_name"];?>
<br>
<span class="style40"><?php echo $objResult21["start_time"];?><?php echo '-';?><?php echo $objResult21["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL80 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_7."' and bus_code = '3'  and status = 'ใช้งาน'";

$objQuery80 = mysqli_query($com1,$strSQL80) or die ("Error Query [".$strSQL80."]");
$Num_Rows80 = mysqli_num_rows($objQuery80);

while($objResult80 = mysqli_fetch_array($objQuery80))
{
	?><span class="style39"><?php echo $objResult80["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult80["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult80["description"];?>
<br>


<?php }
?>

		</td>
	
		</tr>
		
<tr>
<td align="left" bgcolor="#FFCC99" class="style35"><?php echo "คันที่ 4 1112"; ?>

</td>

<td align="left" bgcolor="#FFCC99" class="style35">
<?php 

$strSQL22 = "SELECT *  FROM tb_register_data where start_date ='".$date_1."' and code_bus='4'";

$objQuery22 = mysqli_query($com1,$strSQL22) or die ("Error Query [".$strSQL22."]");
$Num_Rows22 = mysqli_num_rows($objQuery22);

while($objResult22 = mysqli_fetch_array($objQuery22))
{
	?><span class="style39"><?php echo $objResult22["employee_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult22["address_name"];?>
<br>
<span class="style40"><?php echo $objResult22["start_time"];?><?php echo '-';?><?php echo $objResult22["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL81 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_1."' and bus_code = '4'  and status = 'ใช้งาน'";

$objQuery81 = mysqli_query($com1,$strSQL81) or die ("Error Query [".$strSQL81."]");
$Num_Rows81 = mysqli_num_rows($objQuery81);

while($objResult81 = mysqli_fetch_array($objQuery81))
{
	?><span class="style39"><?php echo $objResult81["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult81["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult81["description"];?>
<br>


<?php }
?>



		</td>

		<td align="left" bgcolor="#FFCC99" class="style35">

<?php 

$strSQL23 = "SELECT *  FROM tb_register_data where start_date ='".$date_2."' and code_bus='4'";

$objQuery23 = mysqli_query($com1,$strSQL23) or die ("Error Query [".$strSQL23."]");
$Num_Rows23 = mysqli_num_rows($objQuery23);

while($objResult23 = mysqli_fetch_array($objQuery23))
{
	?>
			<span class="style39"><?php echo $objResult23["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult23["address_name"];?>
<br>
<span class="style40"><?php echo $objResult23["start_time"];?><?php echo '-';?><?php echo $objResult23["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL82 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_2."' and bus_code = '4'  and status = 'ใช้งาน'";

$objQuery82 = mysqli_query($com1,$strSQL82) or die ("Error Query [".$strSQL82."]");
$Num_Rows82 = mysqli_num_rows($objQuery82);

while($objResult82 = mysqli_fetch_array($objQuery82))
{
	?><span class="style39"><?php echo $objResult82["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult82["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult82["description"];?>
<br>


<?php }
?>



		</td>
	
	<td align="left" bgcolor="#FFCC99" class="style35">

<?php 

$strSQL24 = "SELECT *  FROM tb_register_data where start_date ='".$date_3."' and code_bus='4'";

$objQuery24 = mysqli_query($com1,$strSQL24) or die ("Error Query [".$strSQL24."]");
$Num_Rows24 = mysqli_num_rows($objQuery24);

while($objResult24 = mysqli_fetch_array($objQuery24))
{
	?>
			<span class="style39"><?php echo $objResult24["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult24["address_name"];?>
<br>
<span class="style40"><?php echo $objResult24["start_time"];?><?php echo '-';?><?php echo $objResult24["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL83 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_3."' and bus_code = '4'  and status = 'ใช้งาน'";

$objQuery83 = mysqli_query($com1,$strSQL83) or die ("Error Query [".$strSQL83."]");
$Num_Rows83 = mysqli_num_rows($objQuery83);

while($objResult83 = mysqli_fetch_array($objQuery83))
{
	?><span class="style39"><?php echo $objResult83["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult83["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult83["description"];?>
<br>


<?php }
?>


		</td>

	<td align="left" bgcolor="#FFCC99" class="style35">

	
<?php 

$strSQL25 = "SELECT *  FROM tb_register_data where start_date ='".$date_4."' and code_bus='4'";

$objQuery25 = mysqli_query($com1,$strSQL25) or die ("Error Query [".$strSQL25."]");
$Num_Rows25 = mysqli_num_rows($objQuery25);




while($objResult25 = mysqli_fetch_array($objQuery25))
{
	?>
	<span class="style39"><?php echo $objResult25["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult25["address_name"];?>
<br>
 <span class="style40"><?php echo $objResult25["start_time"];?><?php echo '-';?><?php echo $objResult25["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL84 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_4."' and bus_code = '4'  and status = 'ใช้งาน'";

$objQuery84 = mysqli_query($com1,$strSQL84) or die ("Error Query [".$strSQL84."]");
$Num_Rows84 = mysqli_num_rows($objQuery84);

while($objResult84 = mysqli_fetch_array($objQuery84))
{
	?><span class="style39"><?php echo $objResult84["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult84["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult84["description"];?>
<br>


<?php }
?>

		</td>

	<td align="left" bgcolor="#FFCC99" class="style35">
	<?php 

$strSQL26 = "SELECT *  FROM tb_register_data where start_date ='".$date_5."' and code_bus='4'";

$objQuery26 = mysqli_query($com1,$strSQL26) or die ("Error Query [".$strSQL26."]");
$Num_Rows26 = mysqli_num_rows($objQuery26);

while($objResult26 = mysqli_fetch_array($objQuery26))
{
	?>
		<span class="style39"><?php echo $objResult26["employee_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult26["address_name"];?>
<br>
 <span class="style40"><?php echo $objResult26["start_time"];?><?php echo '-';?><?php echo $objResult26["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL85 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_5."' and bus_code = '4'  and status = 'ใช้งาน'";

$objQuery85 = mysqli_query($com1,$strSQL85) or die ("Error Query [".$strSQL85."]");
$Num_Rows85 = mysqli_num_rows($objQuery85);

while($objResult85 = mysqli_fetch_array($objQuery85))
{
	?><span class="style39"><?php echo $objResult85["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult85["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult85["description"];?>
<br>


<?php }
?>

		</td>

	
	<td align="left" bgcolor="#FFCC99" class="style35">

	<?php 

$strSQL27 = "SELECT *  FROM tb_register_data where start_date ='".$date_6."' and code_bus='4'";

$objQuery27 = mysqli_query($com1,$strSQL27) or die ("Error Query [".$strSQL27."]");
$Num_Rows27 = mysqli_num_rows($objQuery27);
while($objResult27 = mysqli_fetch_array($objQuery27))
{
	?>
		<span class="style39"><?php echo $objResult27["employee_send"];?></span>
<br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult27["address_name"];?>
<br>
<span class="style40"><?php echo $objResult27["start_time"];?><?php echo '-';?><?php echo $objResult27["end_time"];?></span>
<br>


<?php }
?>
		
	<?php 

$strSQL86 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_6."' and bus_code = '4'  and status = 'ใช้งาน'";

$objQuery86 = mysqli_query($com1,$strSQL86) or die ("Error Query [".$strSQL86."]");
$Num_Rows86 = mysqli_num_rows($objQuery86);

while($objResult86 = mysqli_fetch_array($objQuery86))
{
	?><span class="style39"><?php echo $objResult86["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult86["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult86["description"];?>
<br>


<?php }
?>

		</td>

	<td align="left" bgcolor="#FFCC99" class="style35">

	<?php 

$strSQL28 = "SELECT *  FROM tb_register_data where start_date ='".$date_7."' and code_bus='4'";

$objQuery28 = mysqli_query($com1,$strSQL28) or die ("Error Query [".$strSQL28."]");
$Num_Rows28 = mysqli_num_rows($objQuery28);



while($objResult28 = mysqli_fetch_array($objQuery28))
{
	?>
		<span class="style39"><?php echo $objResult28["employee_send"];?></span>
<br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult28["address_name"];?>
<br>
 <span class="style40"><?php echo $objResult28["start_time"];?><?php echo '-';?><?php echo $objResult28["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL87 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_7."' and bus_code = '4'  and status = 'ใช้งาน'";

$objQuery87 = mysqli_query($com1,$strSQL87) or die ("Error Query [".$strSQL87."]");
$Num_Rows87 = mysqli_num_rows($objQuery87);

while($objResult87 = mysqli_fetch_array($objQuery87))
{
	?><span class="style39"><?php echo $objResult87["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult87["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult87["description"];?>
<br>


<?php }
?>
		

		</td>

	
		</tr>
			

<tr>

<td align="left" bgcolor="#FFCCFF" class="style35"><?php echo "คันที่5 6867"; ?>
</td>

<td align="left" bgcolor="#FFCCFF" class="style35">
<?php 

$strSQL8 = "SELECT *  FROM tb_register_data where start_date ='".$date_1."' and code_bus='8'";

$objQuery8 = mysqli_query($com1,$strSQL8) or die ("Error Query [".$strSQL8."]");
$Num_Rows8 = mysqli_num_rows($objQuery8);

while($objResult8 = mysqli_fetch_array($objQuery8))
{
	?><span class="style39"><?php echo $objResult8["employee_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult8["address_name"];?>
<br>
<span class="style40"><?php echo $objResult8["start_time"];?><?php echo '-';?><?php echo $objResult8["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL67 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_1."' and bus_code = '8'  and status = 'ใช้งาน'";

$objQuery67 = mysqli_query($com1,$strSQL67) or die ("Error Query [".$strSQL67."]");
$Num_Rows67 = mysqli_num_rows($objQuery67);

while($objResult67 = mysqli_fetch_array($objQuery67))
{
	?><span class="style39"><?php echo $objResult67["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult67["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult67["description"];?>
<br>


<?php }
?>



		</td>

		<td align="left" bgcolor="#FFCCFF" class="style35">

<?php 

$strSQL9 = "SELECT *  FROM tb_register_data where start_date ='".$date_2."' and code_bus='8'";

$objQuery9 = mysqli_query($com1,$strSQL9) or die ("Error Query [".$strSQL9."]");
$Num_Rows9 = mysqli_num_rows($objQuery9);

while($objResult9 = mysqli_fetch_array($objQuery9))
{
	?>
			<span class="style39"><?php echo $objResult9["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult2["address_name"];?>
<br>
<span class="style40"><?php echo $objResult9["start_time"];?><?php echo '-';?><?php echo $objResult9["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL68 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_2."' and bus_code = '8'  and status = 'ใช้งาน'";

$objQuery68 = mysqli_query($com1,$strSQL68) or die ("Error Query [".$strSQL68."]");
$Num_Rows68 = mysqli_num_rows($objQuery68);

while($objResult68 = mysqli_fetch_array($objQuery68))
{
	?><span class="style39"><?php echo $objResult68["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult68["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult68["description"];?>
<br>


<?php }
?>



		</td>
	
	<td align="left" bgcolor="#FFCCFF" class="style35">

<?php 

$strSQL10 = "SELECT *  FROM tb_register_data where start_date ='".$date_3."' and code_bus='8'";

$objQuery10 = mysqli_query($com1,$strSQL10) or die ("Error Query [".$strSQL10."]");
$Num_Rows10 = mysqli_num_rows($objQuery10);

while($objResult10 = mysqli_fetch_array($objQuery10))
{
	?>
			<span class="style39"><?php echo $objResult10["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult10["address_name"];?>
<br>
<span class="style40"><?php echo $objResult10["start_time"];?><?php echo '-';?><?php echo $objResult10["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL69 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_3."' and bus_code = '8'  and status = 'ใช้งาน'";

$objQuery69 = mysqli_query($com1,$strSQL69) or die ("Error Query [".$strSQL69."]");
$Num_Rows69 = mysqli_num_rows($objQuery69);

while($objResult68 = mysqli_fetch_array($objQuery69))
{
	?><span class="style39"><?php echo $objResult69["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult69["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult69["description"];?>
<br>


<?php }
?>


		</td>

	<td align="left" bgcolor="#FFCCFF" class="style35">

	
<?php 

$strSQL11 = "SELECT *  FROM tb_register_data where start_date ='".$date_4."' and code_bus='8'";

$objQuery11 = mysqli_query($com1,$strSQL11) or die ("Error Query [".$strSQL11."]");
$Num_Rows11 = mysqli_num_rows($objQuery11);




while($objResult11 = mysqli_fetch_array($objQuery11))
{
	?>
	<span class="style39"><?php echo $objResult11["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult11["address_name"];?>
<br>
<span class="style40"><?php echo $objResult11["start_time"];?><?php echo '-';?><?php echo $objResult11["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL70 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_4."' and bus_code = '8'  and status = 'ใช้งาน'";

$objQuery70 = mysqli_query($com1,$strSQL70) or die ("Error Query [".$strSQL70."]");
$Num_Rows70 = mysqli_num_rows($objQuery70);

while($objResult70 = mysqli_fetch_array($objQuery70))
{
	?><span class="style39"><?php echo $objResult70["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult70["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult70["description"];?>
<br>


<?php }
?>

		</td>

	<td align="left" bgcolor="#FFCCFF" class="style35">
	<?php 

$strSQL12 = "SELECT *  FROM tb_register_data where start_date ='".$date_5."' and code_bus='8'";

$objQuery12 = mysqli_query($com1,$strSQL12) or die ("Error Query [".$strSQL12."]");
$Num_Rows12 = mysqli_num_rows($objQuery12);

while($objResult12 = mysqli_fetch_array($objQuery12))
{
	?>
		<span class="style39"><?php echo $objResult12["employee_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult12["address_name"];?>
<br>
<span class="style40"><?php echo $objResult12["start_time"];?><?php echo '-';?><?php echo $objResult12["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL71 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_5."' and bus_code = '8'  and status = 'ใช้งาน'";

$objQuery71 = mysqli_query($com1,$strSQL71) or die ("Error Query [".$strSQL71."]");
$Num_Rows71 = mysqli_num_rows($objQuery71);

while($objResult71 = mysqli_fetch_array($objQuery71))
{
	?><span class="style39"><?php echo $objResult71["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult71["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult71["description"];?>
<br>


<?php }
?>

		</td>

	
	<td align="left" bgcolor="#FFCCFF" class="style35">

	<?php 

$strSQL13 = "SELECT *  FROM tb_register_data where start_date ='".$date_6."' and code_bus='8'";

$objQuery13 = mysqli_query($com1,$strSQL13) or die ("Error Query [".$strSQL13."]");
$Num_Rows13 = mysqli_num_rows($objQuery13);
while($objResult13 = mysqli_fetch_array($objQuery13))
{
	?>
		<span class="style39"><?php echo $objResult13["employee_send"];?></span>
<br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult13["address_name"];?>
<br>
<span class="style40"><?php echo $objResult13["start_time"];?><?php echo '-';?><?php echo $objResult13["end_time"];?></span>
<br>


<?php }
?>
		
<?php 

$strSQL72 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_6."' and bus_code = '8'  and status = 'ใช้งาน'";

$objQuery72 = mysqli_query($com1,$strSQL72) or die ("Error Query [".$strSQL72."]");
$Num_Rows72 = mysqli_num_rows($objQuery72);

while($objResult72 = mysqli_fetch_array($objQuery72))
{
	?><span class="style39"><?php echo $objResult72["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult72["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult72["description"];?>
<br>


<?php }
?>

		</td>

	<td align="left" bgcolor="#FFCCFF" class="style35">

	<?php 

$strSQL14 = "SELECT *  FROM tb_register_data where start_date ='".$date_7."' and code_bus='8'";

$objQuery14 = mysqli_query($com1,$strSQL14) or die ("Error Query [".$strSQL14."]");
$Num_Rows14 = mysqli_num_rows($objQuery14);



while($objResult14 = mysqli_fetch_array($objQuery14))
{
	?>
		<span class="style39"><?php echo $objResult14["employee_send"];?></span>
<br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult14["address_name"];?>
<br>
<span class="style40"><?php echo $objResult14["start_time"];?><?php echo '-';?><?php echo $objResult14["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL73 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_7."' and bus_code = '8'  and status = 'ใช้งาน'";

$objQuery73 = mysqli_query($com1,$strSQL73) or die ("Error Query [".$strSQL73."]");
$Num_Rows73 = mysqli_num_rows($objQuery73);

while($objResult73 = mysqli_fetch_array($objQuery73))
{
	?><span class="style39"><?php echo $objResult73["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult73["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult73["description"];?>
<br>


<?php }
?>

		</td>
	
		</tr>


<tr>

<td align="left" bgcolor="#99CCFF" class="style35"><?php echo "ขนส่งนอก"; ?>
</td>

<td align="left" bgcolor="#99CCFF" class="style35">
<?php 

$strSQL8 = "SELECT *  FROM tb_register_data where start_date ='".$date_1."' and code_bus='9'";

$objQuery8 = mysqli_query($com1,$strSQL8) or die ("Error Query [".$strSQL8."]");
$Num_Rows8 = mysqli_num_rows($objQuery8);

while($objResult8 = mysqli_fetch_array($objQuery8))
{
	?><span class="style39"><?php echo $objResult8["employee_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult8["address_name"];?>
<br>
<span class="style40"><?php echo $objResult8["start_time"];?><?php echo '-';?><?php echo $objResult8["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL67 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_1."' and bus_code = '9'  and status = 'ใช้งาน'";

$objQuery67 = mysqli_query($com1,$strSQL67) or die ("Error Query [".$strSQL67."]");
$Num_Rows67 = mysqli_num_rows($objQuery67);

while($objResult67 = mysqli_fetch_array($objQuery67))
{
	?><span class="style39"><?php echo $objResult67["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult67["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult67["description"];?>
<br>


<?php }
?>



		</td>

		<td align="left" bgcolor="#99CCFF" class="style35">

<?php 

$strSQL9 = "SELECT *  FROM tb_register_data where start_date ='".$date_2."' and code_bus='9'";

$objQuery9 = mysqli_query($com1,$strSQL9) or die ("Error Query [".$strSQL9."]");
$Num_Rows9 = mysqli_num_rows($objQuery9);

while($objResult9 = mysqli_fetch_array($objQuery9))
{
	?>
			<span class="style39"><?php echo $objResult9["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult2["address_name"];?>
<br>
<span class="style40"><?php echo $objResult9["start_time"];?><?php echo '-';?><?php echo $objResult9["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL68 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_2."' and bus_code = '9'  and status = 'ใช้งาน'";

$objQuery68 = mysqli_query($com1,$strSQL68) or die ("Error Query [".$strSQL68."]");
$Num_Rows68 = mysqli_num_rows($objQuery68);

while($objResult68 = mysqli_fetch_array($objQuery68))
{
	?><span class="style39"><?php echo $objResult68["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult68["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult68["description"];?>
<br>


<?php }
?>



		</td>
	
	<td align="left" bgcolor="#99CCFF" class="style35">

<?php 

$strSQL10 = "SELECT *  FROM tb_register_data where start_date ='".$date_3."' and code_bus='9'";

$objQuery10 = mysqli_query($com1,$strSQL10) or die ("Error Query [".$strSQL10."]");
$Num_Rows10 = mysqli_num_rows($objQuery10);

while($objResult10 = mysqli_fetch_array($objQuery10))
{
	?>
			<span class="style39"><?php echo $objResult10["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult10["address_name"];?>
<br>
<span class="style40"><?php echo $objResult10["start_time"];?><?php echo '-';?><?php echo $objResult10["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL69 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_3."' and bus_code = '9'  and status = 'ใช้งาน'";

$objQuery69 = mysqli_query($com1,$strSQL69) or die ("Error Query [".$strSQL69."]");
$Num_Rows69 = mysqli_num_rows($objQuery69);

while($objResult68 = mysqli_fetch_array($objQuery69))
{
	?><span class="style39"><?php echo $objResult69["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult69["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult69["description"];?>
<br>


<?php }
?>


		</td>

	<td align="left" bgcolor="#99CCFF" class="style35">

	
<?php 

$strSQL11 = "SELECT *  FROM tb_register_data where start_date ='".$date_4."' and code_bus='9'";

$objQuery11 = mysqli_query($com1,$strSQL11) or die ("Error Query [".$strSQL11."]");
$Num_Rows11 = mysqli_num_rows($objQuery11);




while($objResult11 = mysqli_fetch_array($objQuery11))
{
	?>
	<span class="style39"><?php echo $objResult11["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult11["address_name"];?>
<br>
<span class="style40"><?php echo $objResult11["start_time"];?><?php echo '-';?><?php echo $objResult11["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL70 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_4."' and bus_code = '9'  and status = 'ใช้งาน'";

$objQuery70 = mysqli_query($com1,$strSQL70) or die ("Error Query [".$strSQL70."]");
$Num_Rows70 = mysqli_num_rows($objQuery70);

while($objResult70 = mysqli_fetch_array($objQuery70))
{
	?><span class="style39"><?php echo $objResult70["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult70["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult70["description"];?>
<br>


<?php }
?>

		</td>

	<td align="left" bgcolor="#99CCFF" class="style35">
	<?php 

$strSQL12 = "SELECT *  FROM tb_register_data where start_date ='".$date_5."' and code_bus='9'";

$objQuery12 = mysqli_query($com1,$strSQL12) or die ("Error Query [".$strSQL12."]");
$Num_Rows12 = mysqli_num_rows($objQuery12);

while($objResult12 = mysqli_fetch_array($objQuery12))
{
	?>
		<span class="style39"><?php echo $objResult12["employee_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult12["address_name"];?>
<br>
<span class="style40"><?php echo $objResult12["start_time"];?><?php echo '-';?><?php echo $objResult12["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL71 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_5."' and bus_code = '9'  and status = 'ใช้งาน'";

$objQuery71 = mysqli_query($com1,$strSQL71) or die ("Error Query [".$strSQL71."]");
$Num_Rows71 = mysqli_num_rows($objQuery71);

while($objResult71 = mysqli_fetch_array($objQuery71))
{
	?><span class="style39"><?php echo $objResult71["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult71["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult71["description"];?>
<br>


<?php }
?>

		</td>

	
	<td align="left" bgcolor="#99CCFF" class="style35">

	<?php 

$strSQL13 = "SELECT *  FROM tb_register_data where start_date ='".$date_6."' and code_bus='9'";

$objQuery13 = mysqli_query($com1,$strSQL13) or die ("Error Query [".$strSQL13."]");
$Num_Rows13 = mysqli_num_rows($objQuery13);
while($objResult13 = mysqli_fetch_array($objQuery13))
{
	?>
		<span class="style39"><?php echo $objResult13["employee_send"];?></span>
<br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult13["address_name"];?>
<br>
<span class="style40"><?php echo $objResult13["start_time"];?><?php echo '-';?><?php echo $objResult13["end_time"];?></span>
<br>


<?php }
?>
		
<?php 

$strSQL72 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_6."' and bus_code = '9'  and status = 'ใช้งาน'";

$objQuery72 = mysqli_query($com1,$strSQL72) or die ("Error Query [".$strSQL72."]");
$Num_Rows72 = mysqli_num_rows($objQuery72);

while($objResult72 = mysqli_fetch_array($objQuery72))
{
	?><span class="style39"><?php echo $objResult72["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult72["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult72["description"];?>
<br>


<?php }
?>

		</td>

	<td align="left" bgcolor="#99CCFF" class="style35">

	<?php 

$strSQL14 = "SELECT *  FROM tb_register_data where start_date ='".$date_7."' and code_bus='9'";

$objQuery14 = mysqli_query($com1,$strSQL14) or die ("Error Query [".$strSQL14."]");
$Num_Rows14 = mysqli_num_rows($objQuery14);



while($objResult14 = mysqli_fetch_array($objQuery14))
{
	?>
		<span class="style39"><?php echo $objResult14["employee_send"];?></span>
<br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult14["address_name"];?>
<br>
<span class="style40"><?php echo $objResult14["start_time"];?><?php echo '-';?><?php echo $objResult14["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL73 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_7."' and bus_code = '9'  and status = 'ใช้งาน'";

$objQuery73 = mysqli_query($com1,$strSQL73) or die ("Error Query [".$strSQL73."]");
$Num_Rows73 = mysqli_num_rows($objQuery73);

while($objResult73 = mysqli_fetch_array($objQuery73))
{
	?><span class="style39"><?php echo $objResult73["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult73["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult73["description"];?>
<br>


<?php }
?>

		</td>
	
		</tr>

<tr>
<td width="5%" align="right"  class="style35"></td>
<td width="15%" align="right"  class="style35"><?php echo $day8 ; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 8</td>
<td width="15%" align="right"  class="style35"><?php echo $day9 ; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 9</td>
<td width="15%" align="right"  class="style35"><?php echo $day10 ; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 10</td>
<td width="15%" align="right"  class="style35"><?php echo $day11 ; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 11</td>
<td width="15%" align="right"  class="style35"><?php echo $day12 ; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 12</td>
<td width="15%" align="right"  class="style35"><?php echo $day13 ; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 13</td>
<td width="15%" align="right"  class="style35"><?php echo $day14 ; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 14</td>

</tr>


<tr>

<td align="center" bgcolor="CC99CC" class="style35"> <?php echo "คันที่ 1 8952"; ?>
		</td>


		<td align="left" bgcolor="CC99CC" class="style35">
<?php 

$strSQL29 = "SELECT *  FROM tb_register_data where start_date ='".$date_8."' and code_bus='1'";

$objQuery29 = mysqli_query($com1,$strSQL29) or die ("Error Query [".$strSQL29."]");
$Num_Rows29 = mysqli_num_rows($objQuery29);

while($objResult29 = mysqli_fetch_array($objQuery29))
{
	?><span class="style39"><?php echo $objResult29["employee_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult29["address_name"];?>
<br>
 <span class="style40"><?php echo $objResult29["start_time"];?><?php echo '-';?><?php echo $objResult29["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL88 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_8."' and bus_code = '1'  and status = 'ใช้งาน'";

$objQuery88 = mysqli_query($com1,$strSQL88) or die ("Error Query [".$strSQL88."]");
$Num_Rows88 = mysqli_num_rows($objQuery88);

while($objResult88 = mysqli_fetch_array($objQuery88))
{
	?><span class="style39"><?php echo $objResult88["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult88["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult88["description"];?>
<br>


<?php }
?>



		</td>

		<td align="left" bgcolor="CC99CC" class="style35">

<?php 

$strSQL30 = "SELECT *  FROM tb_register_data where start_date ='".$date_9."' and code_bus='1'";

$objQuery30 = mysqli_query($com1,$strSQL30) or die ("Error Query [".$strSQL30."]");
$Num_Rows30 = mysqli_num_rows($objQuery30);

while($objResult30 = mysqli_fetch_array($objQuery30))
{
	?>
			<span class="style39"><?php echo $objResult30["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult30["address_name"];?>
<br>
<span class="style40"><?php echo $objResult30["start_time"];?><?php echo '-';?><?php echo $objResult30["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL89 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_9."' and bus_code = '1'  and status = 'ใช้งาน'";

$objQuery89 = mysqli_query($com1,$strSQL89) or die ("Error Query [".$strSQL89."]");
$Num_Rows89 = mysqli_num_rows($objQuery89);

while($objResult89 = mysqli_fetch_array($objQuery89))
{
	?><span class="style39"><?php echo $objResult89["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult89["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult89["description"];?>
<br>


<?php }
?>



		</td>
	
	<td align="left" bgcolor="CC99CC" class="style35">

<?php 

$strSQL31 = "SELECT *  FROM tb_register_data where start_date ='".$date_10."' and code_bus='1'";

$objQuery31 = mysqli_query($com1,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);

while($objResult31 = mysqli_fetch_array($objQuery31))
{
	?>
			<span class="style39"><?php echo $objResult31["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult31["address_name"];?>
<br>
<span class="style40"><?php echo $objResult31["start_time"];?><?php echo '-';?><?php echo $objResult31["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL90 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_10."' and bus_code = '1'  and status = 'ใช้งาน'";

$objQuery90 = mysqli_query($com1,$strSQL90) or die ("Error Query [".$strSQL90."]");
$Num_Rows90 = mysqli_num_rows($objQuery90);

while($objResult90 = mysqli_fetch_array($objQuery90))
{
	?><span class="style39"><?php echo $objResult90["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult90["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult90["description"];?>
<br>


<?php }
?>

		</td>

	<td align="left" bgcolor="CC99CC" class="style35">

	
<?php 

$strSQL32 = "SELECT *  FROM tb_register_data where start_date ='".$date_11."' and code_bus='1'";

$objQuery32 = mysqli_query($com1,$strSQL32) or die ("Error Query [".$strSQL32."]");
$Num_Rows32 = mysqli_num_rows($objQuery32);
while($objResult32 = mysqli_fetch_array($objQuery32))
{
	?>
	<span class="style39"><?php echo $objResult32["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult32["address_name"];?>
<br>
<span class="style40"><?php echo $objResult32["start_time"];?><?php echo '-';?><?php echo $objResult32["end_time"];?></span>
<br>


<?php }
?>

	<?php 

$strSQL91 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_11."' and bus_code = '1'  and status = 'ใช้งาน'";

$objQuery91 = mysqli_query($com1,$strSQL91) or die ("Error Query [".$strSQL91."]");
$Num_Rows91 = mysqli_num_rows($objQuery91);

while($objResult91 = mysqli_fetch_array($objQuery91))
{
	?><span class="style39"><?php echo $objResult91["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult91["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult91["description"];?>
<br>


<?php }
?>

		</td>

	<td align="left" bgcolor="CC99CC" class="style35">
	<?php 

$strSQL33 = "SELECT *  FROM tb_register_data where start_date ='".$date_12."' and code_bus='1'";

$objQuery33 = mysqli_query($com1,$strSQL33) or die ("Error Query [".$strSQL33."]");
$Num_Rows33 = mysqli_num_rows($objQuery33);

while($objResult33 = mysqli_fetch_array($objQuery33))
{
	?>
		<span class="style39"><?php echo $objResult33["employee_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult33["address_name"];?>
<br>
 <span class="style40"><?php echo $objResult33["start_time"];?><?php echo '-';?><?php echo $objResult33["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL92 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_12."' and bus_code = '1'  and status = 'ใช้งาน'";

$objQuery92 = mysqli_query($com1,$strSQL92) or die ("Error Query [".$strSQL92."]");
$Num_Rows92 = mysqli_num_rows($objQuery92);

while($objResult92 = mysqli_fetch_array($objQuery92))
{
	?><span class="style39"><?php echo $objResult92["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult92["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult92["description"];?>
<br>


<?php }
?>

		</td>

	
	<td align="left" bgcolor="CC99CC" class="style35">

	<?php 

$strSQL34 = "SELECT *  FROM tb_register_data where start_date ='".$date_13."' and code_bus='1'";

$objQuery34 = mysqli_query($com1,$strSQL34) or die ("Error Query [".$strSQL34."]");
$Num_Rows34 = mysqli_num_rows($objQuery34);
while($objResult34 = mysqli_fetch_array($objQuery34))
{
	?>
		<span class="style39"><?php echo $objResult34["employee_send"];?></span>
<br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult34["address_name"];?>
<br>
 <span class="style40"><?php echo $objResult34["start_time"];?><?php echo '-';?><?php echo $objResult34["end_time"];?></span>
<br>


<?php }
?>
		
	<?php 

$strSQL93 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_13."' and bus_code = '1'  and status = 'ใช้งาน'";

$objQuery93 = mysqli_query($com1,$strSQL93) or die ("Error Query [".$strSQL93."]");
$Num_Rows93 = mysqli_num_rows($objQuery93);

while($objResult93 = mysqli_fetch_array($objQuery93))
{
	?><span class="style39"><?php echo $objResult93["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult93["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult93["description"];?>
<br>


<?php }
?>

		</td>

	<td align="left" bgcolor="CC99CC" class="style35">

	<?php 

$strSQL35 = "SELECT *  FROM tb_register_data where start_date ='".$date_14."' and code_bus='1'";

$objQuery35 = mysqli_query($com1,$strSQL35) or die ("Error Query [".$strSQL35."]");
$Num_Rows35 = mysqli_num_rows($objQuery35);
while($objResult35 = mysqli_fetch_array($objQuery35))
{
	?>
		<span class="style39"><?php echo $objResult35["employee_send"];?></span>
<br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult35["address_name"];?>
<br>
 <span class="style40"><?php echo $objResult35["start_time"];?><?php echo '-';?><?php echo $objResult35["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL94 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_14."' and bus_code = '1'  and status = 'ใช้งาน'";

$objQuery94 = mysqli_query($com1,$strSQL94) or die ("Error Query [".$strSQL94."]");
$Num_Rows94 = mysqli_num_rows($objQuery94);

while($objResult94 = mysqli_fetch_array($objQuery94))
{
	?><span class="style39"><?php echo $objResult94["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult94["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult94["description"];?>
<br>


<?php }
?>

		</td>
	
	






		</tr>
	
		







<tr>

<td align="left" bgcolor="#CCFF99" class="style35"><?php echo "คันที่ 2 9322"; ?>
</td>

<td align="left" bgcolor="#CCFF99" class="style35">
<?php 

$strSQL36 = "SELECT *  FROM tb_register_data where start_date ='".$date_8."' and code_bus='2'";
$objQuery36 = mysqli_query($com1,$strSQL36) or die ("Error Query [".$strSQL36."]");
$Num_Rows36 = mysqli_num_rows($objQuery36);

while($objResult36 = mysqli_fetch_array($objQuery36))
{
	?><span class="style39"><?php echo $objResult36["employee_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult36["address_name"];?>
<br>
<span class="style40"><?php echo $objResult36["start_time"];?><?php echo '-';?><?php echo $objResult36["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL95 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_8."' and bus_code = '2'  and status = 'ใช้งาน'";

$objQuery95 = mysqli_query($com1,$strSQL95) or die ("Error Query [".$strSQL95."]");
$Num_Rows95 = mysqli_num_rows($objQuery95);

while($objResult95 = mysqli_fetch_array($objQuery95))
{
	?><span class="style39"><?php echo $objResult95["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult95["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult95["description"];?>
<br>


<?php }
?>



		</td>

		<td align="left" bgcolor="#CCFF99" class="style35">

<?php 

$strSQL37 = "SELECT *  FROM tb_register_data where start_date ='".$date_9."' and code_bus='2'";

$objQuery37 = mysqli_query($com1,$strSQL37) or die ("Error Query [".$strSQL37."]");
$Num_Rows37 = mysqli_num_rows($objQuery37);

while($objResult37 = mysqli_fetch_array($objQuery37))
{
	?>
			<span class="style39"><?php echo $objResult37["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult37["address_name"];?>
<br>
<span class="style40"><?php echo $objResult37["start_time"];?><?php echo '-';?><?php echo $objResult37["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL96 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_9."' and bus_code = '2'  and status = 'ใช้งาน'";

$objQuery96 = mysqli_query($com1,$strSQL96) or die ("Error Query [".$strSQL96."]");
$Num_Rows96 = mysqli_num_rows($objQuery96);

while($objResult96 = mysqli_fetch_array($objQuery96))
{
	?><span class="style39"><?php echo $objResult96["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult96["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult96["description"];?>
<br>


<?php }
?>



		</td>
	
	<td align="left" bgcolor="#CCFF99" class="style35">

<?php 

$strSQL38 = "SELECT *  FROM tb_register_data where start_date ='".$date_10."' and code_bus='2'";

$objQuery38 = mysqli_query($com1,$strSQL38) or die ("Error Query [".$strSQL38."]");
$Num_Rows38 = mysqli_num_rows($objQuery38);

while($objResult38 = mysqli_fetch_array($objQuery38))
{
	?>
			<span class="style39"><?php echo $objResult38["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult38["address_name"];?>
<br>
<span class="style40"><?php echo $objResult38["start_time"];?><?php echo '-';?><?php echo $objResult38["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL97 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_10."' and bus_code = '2'  and status = 'ใช้งาน'";

$objQuery97 = mysqli_query($com1,$strSQL97) or die ("Error Query [".$strSQL97."]");
$Num_Rows97 = mysqli_num_rows($objQuery97);

while($objResult97 = mysqli_fetch_array($objQuery97))
{
	?><span class="style39"><?php echo $objResult97["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult97["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult97["description"];?>
<br>


<?php }
?>


		</td>

	<td align="left" bgcolor="#CCFF99" class="style35">

	
<?php 

$strSQL39 = "SELECT *  FROM tb_register_data where start_date ='".$date_11."' and code_bus='2'";

$objQuery39 = mysqli_query($com1,$strSQL39) or die ("Error Query [".$strSQL39."]");
$Num_Rows39 = mysqli_num_rows($objQuery39);
while($objResult39 = mysqli_fetch_array($objQuery39))
{
	?>
	<span class="style39"><?php echo $objResult39["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult39["address_name"];?>
<span class="style40"><?php echo $objResult39["start_time"];?><?php echo '-';?><?php echo $objResult39["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL98 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_11."' and bus_code = '2'  and status = 'ใช้งาน'";

$objQuery98 = mysqli_query($com1,$strSQL98) or die ("Error Query [".$strSQL98."]");
$Num_Rows98 = mysqli_num_rows($objQuery98);

while($objResult98 = mysqli_fetch_array($objQuery98))
{
	?><span class="style39"><?php echo $objResult98["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult98["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult98["description"];?>
<br>


<?php }
?>

		</td>

	<td align="left" bgcolor="#CCFF99" class="style35">
	<?php 

$strSQL40 = "SELECT *  FROM tb_register_data where start_date ='".$date_12."' and code_bus='2'";

$objQuery40 = mysqli_query($com1,$strSQL40) or die ("Error Query [".$strSQL40."]");
$Num_Rows40 = mysqli_num_rows($objQuery40);

while($objResult40 = mysqli_fetch_array($objQuery40))
{
	?>
		<span class="style39"><?php echo $objResult40["employee_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult40["address_name"];?>
<br>
<span class="style40"><?php echo $objResult40["start_time"];?><?php echo '-';?><?php echo $objResult40["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL99 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_12."' and bus_code = '2'  and status = 'ใช้งาน'";

$objQuery99 = mysqli_query($com1,$strSQL99) or die ("Error Query [".$strSQL99."]");
$Num_Rows99 = mysqli_num_rows($objQuery99);

while($objResult99 = mysqli_fetch_array($objQuery99))
{
	?><span class="style39"><?php echo $objResult99["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult99["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult99["description"];?>
<br>


<?php }
?>

		</td>

	
	<td align="left" bgcolor="#CCFF99" class="style35">

	<?php 

$strSQL41 = "SELECT *  FROM tb_register_data where start_date ='".$date_13."' and code_bus='2'";

$objQuery41 = mysqli_query($com1,$strSQL41) or die ("Error Query [".$strSQL41."]");
$Num_Rows41 = mysqli_num_rows($objQuery41);
while($objResult41 = mysqli_fetch_array($objQuery41))
{
	?>
		<span class="style39"><?php echo $objResult41["employee_send"];?></span>
<br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult41["address_name"];?>
<br>
<span class="style40"><?php echo $objResult41["start_time"];?><?php echo '-';?><?php echo $objResult41["end_time"];?></span>
<br>


<?php }
?>
		
<?php 

$strSQL100 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_13."' and bus_code = '2'  and status = 'ใช้งาน'";

$objQuery100 = mysqli_query($com1,$strSQL100) or die ("Error Query [".$strSQL100."]");
$Num_Rows100 = mysqli_num_rows($objQuery100);

while($objResult100 = mysqli_fetch_array($objQuery100))
{
	?><span class="style39"><?php echo $objResult100["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult100["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult100["description"];?>
<br>


<?php }
?>

		</td>

	<td align="left" bgcolor="#CCFF99" class="style35">

	<?php 

$strSQL42 = "SELECT *  FROM tb_register_data where start_date ='".$date_14."' and code_bus='2'";

$objQuery42 = mysqli_query($com1,$strSQL42) or die ("Error Query [".$strSQL42."]");
$Num_Rows42 = mysqli_num_rows($objQuery42);



while($objResult42 = mysqli_fetch_array($objQuery42))
{
	?>
		<span class="style39"><?php echo $objResult42["employee_send"];?></span>
<br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult42["address_name"];?>
<br>
<span class="style40"><?php echo $objResult42["start_time"];?><?php echo '-';?><?php echo $objResult42["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL101 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_14."' and bus_code = '2'  and status = 'ใช้งาน'";

$objQuery101 = mysqli_query($com1,$strSQL101) or die ("Error Query [".$strSQL101."]");
$Num_Rows101 = mysqli_num_rows($objQuery101);

while($objResult101 = mysqli_fetch_array($objQuery101))
{
	?><span class="style39"><?php echo $objResult101["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult101["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult101["description"];?>
<br>


<?php }
?>

		</td>
	
		</tr>
		

<tr>

<td align="left" bgcolor="#00CCCC" class="style35"><?php echo "คันที่ 3 5644"; ?>
</td>

<td align="left" bgcolor="#00CCCC" class="style35">
<?php 

$strSQL43 = "SELECT *  FROM tb_register_data where start_date ='".$date_8."' and code_bus='3'";

$objQuery43 = mysqli_query($com1,$strSQL43) or die ("Error Query [".$strSQL43."]");
$Num_Rows43 = mysqli_num_rows($objQuery43);

while($objResult43 = mysqli_fetch_array($objQuery43))
{
	?><span class="style39"><?php echo $objResult43["employee_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult43["address_name"];?>
<br>
<span class="style40"><?php echo $objResult43["start_time"];?><?php echo '-';?><?php echo $objResult43["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL102 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_8."' and bus_code = '3'  and status = 'ใช้งาน'";

$objQuery102 = mysqli_query($com1,$strSQL102) or die ("Error Query [".$strSQL102."]");
$Num_Rows102 = mysqli_num_rows($objQuery102);

while($objResult102 = mysqli_fetch_array($objQuery102))
{
	?><span class="style39"><?php echo $objResult102["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult102["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult102["description"];?>
<br>


<?php }
?>



		</td>

		<td align="left" bgcolor="#00CCCC" class="style35">

<?php 

$strSQL44 = "SELECT *  FROM tb_register_data where start_date ='".$date_9."' and code_bus='3'";

$objQuery44 = mysqli_query($com1,$strSQL44) or die ("Error Query [".$strSQL44."]");
$Num_Rows44 = mysqli_num_rows($objQuery44);

while($objResult44 = mysqli_fetch_array($objQuery44))
{
	?>
			<span class="style39"><?php echo $objResult44["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult44["address_name"];?>
<br>
<span class="style40"><?php echo $objResult44["start_time"];?><?php echo '-';?><?php echo $objResult44["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL103 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_9."' and bus_code = '3'  and status = 'ใช้งาน'";

$objQuery103 = mysqli_query($com1,$strSQL103) or die ("Error Query [".$strSQL103."]");
$Num_Rows103 = mysqli_num_rows($objQuery103);

while($objResult103 = mysqli_fetch_array($objQuery103))
{
	?><span class="style39"><?php echo $objResult103["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult103["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult103["description"];?>
<br>


<?php }
?>



		</td>
	
	<td align="left" bgcolor="#00CCCC" class="style35">

<?php 

$strSQL45 = "SELECT *  FROM tb_register_data where start_date ='".$date_10."' and code_bus='3'";

$objQuery45 = mysqli_query($com1,$strSQL45) or die ("Error Query [".$strSQL45."]");
$Num_Rows45 = mysqli_num_rows($objQuery45);

while($objResult45 = mysqli_fetch_array($objQuery45))
{
	?>
			<span class="style39"><?php echo $objResult45["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult45["address_name"];?>
<br>
<span class="style40"><?php echo $objResult45["start_time"];?><?php echo '-';?><?php echo $objResult45["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL104 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_10."' and bus_code = '3'  and status = 'ใช้งาน'";

$objQuery104 = mysqli_query($com1,$strSQL104) or die ("Error Query [".$strSQL104."]");
$Num_Rows104 = mysqli_num_rows($objQuery104);

while($objResult104 = mysqli_fetch_array($objQuery104))
{
	?><span class="style39"><?php echo $objResult104["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult104["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult104["description"];?>
<br>


<?php }
?>

		</td>

	<td align="left" bgcolor="#00CCCC" class="style35">

	
<?php 

$strSQL46 = "SELECT *  FROM tb_register_data where start_date ='".$date_11."' and code_bus='3'";

$objQuery46 = mysqli_query($com1,$strSQL46) or die ("Error Query [".$strSQL46."]");
$Num_Rows46 = mysqli_num_rows($objQuery46);




while($objResult46 = mysqli_fetch_array($objQuery46))
{
	?>
	<span class="style39"><?php echo $objResult46["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult46["address_name"];?>
<br>
<span class="style40"><?php echo $objResult46["start_time"];?><?php echo '-';?><?php echo $objResult46["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL105 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_11."' and bus_code = '3'  and status = 'ใช้งาน'";

$objQuery105 = mysqli_query($com1,$strSQL105) or die ("Error Query [".$strSQL105."]");
$Num_Rows105 = mysqli_num_rows($objQuery105);

while($objResult105 = mysqli_fetch_array($objQuery105))
{
	?><span class="style39"><?php echo $objResult105["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult105["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult105["description"];?>
<br>


<?php }
?>

		</td>

	<td align="left" bgcolor="#00CCCC" class="style35">
	<?php 

$strSQL47 = "SELECT *  FROM tb_register_data where start_date ='".$date_12."' and code_bus='3'";

$objQuery47 = mysqli_query($com1,$strSQL47) or die ("Error Query [".$strSQL47."]");
$Num_Rows47 = mysqli_num_rows($objQuery47);

while($objResult47 = mysqli_fetch_array($objQuery47))
{
	?>
		<span class="style39"><?php echo $objResult47["employee_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult47["address_name"];?>
<br>
<span class="style40"><?php echo $objResult47["start_time"];?><?php echo '-';?><?php echo $objResult47["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL106 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_12."' and bus_code = '3'  and status = 'ใช้งาน'";

$objQuery106 = mysqli_query($com1,$strSQL106) or die ("Error Query [".$strSQL106."]");
$Num_Rows106 = mysqli_num_rows($objQuery106);

while($objResult106 = mysqli_fetch_array($objQuery106))
{
	?><span class="style39"><?php echo $objResult106["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult106["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult106["description"];?>
<br>


<?php }
?>

		</td>

	
	<td align="left" bgcolor="#00CCCC" class="style35">

	<?php 

$strSQL48 = "SELECT *  FROM tb_register_data where start_date ='".$date_13."' and code_bus='3'";

$objQuery48 = mysqli_query($com1,$strSQL48) or die ("Error Query [".$strSQL48."]");
$Num_Rows48 = mysqli_num_rows($objQuery48);
while($objResult48 = mysqli_fetch_array($objQuery48))
{
	?>
		<span class="style39"><?php echo $objResult48["employee_send"];?></span>
<br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult48["address_name"];?>
<br>
<span class="style40"><?php echo $objResult48["start_time"];?><?php echo '-';?><?php echo $objResult48["end_time"];?></span>
<br>


<?php }
?>
		
<?php 

$strSQL107 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_13."' and bus_code = '3'  and status = 'ใช้งาน'";

$objQuery107 = mysqli_query($com1,$strSQL107) or die ("Error Query [".$strSQL107."]");
$Num_Rows107 = mysqli_num_rows($objQuery107);

while($objResult107 = mysqli_fetch_array($objQuery107))
{
	?><span class="style39"><?php echo $objResult107["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult107["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult107["description"];?>
<br>


<?php }
?>


		</td>

	<td align="left" bgcolor="#00CCCC" class="style35">

	<?php 

$strSQL49 = "SELECT *  FROM tb_register_data where start_date ='".$date_14."' and code_bus='3'";

$objQuery49 = mysqli_query($com1,$strSQL49) or die ("Error Query [".$strSQL49."]");
$Num_Rows49 = mysqli_num_rows($objQuery49);



while($objResult49 = mysqli_fetch_array($objQuery49))
{
	?>
		<span class="style39"><?php echo $objResult49["employee_send"];?></span>
<br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult49["address_name"];?>
<br>
<span class="style40"><?php echo $objResult49["start_time"];?><?php echo '-';?><?php echo $objResult49["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL108 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_14."' and bus_code = '3'  and status = 'ใช้งาน'";

$objQuery108 = mysqli_query($com1,$strSQL108) or die ("Error Query [".$strSQL108."]");
$Num_Rows108 = mysqli_num_rows($objQuery108);

while($objResult108 = mysqli_fetch_array($objQuery108))
{
	?><span class="style39"><?php echo $objResult108["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult108["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult108["description"];?>
<br>


<?php }
?>

		</td>
	
		</tr>
		
<tr>
<td align="left" bgcolor="#FFCC99" class="style35"><?php echo "คันที่ 4 1112"; ?>

</td>

<td align="left" bgcolor="#FFCC99" class="style35">
<?php 

$strSQL50 = "SELECT *  FROM tb_register_data where start_date ='".$date_8."' and code_bus='4'";

$objQuery50 = mysqli_query($com1,$strSQL50) or die ("Error Query [".$strSQL50."]");
$Num_Rows50 = mysqli_num_rows($objQuery50);

while($objResult50 = mysqli_fetch_array($objQuery50))
{
	?><span class="style39"><?php echo $objResult50["employee_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult50["address_name"];?>
<br>
<span class="style40"><?php echo $objResult50["start_time"];?><?php echo '-';?><?php echo $objResult50["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL109 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_8."' and bus_code = '4'  and status = 'ใช้งาน'";

$objQuery109 = mysqli_query($com1,$strSQL109) or die ("Error Query [".$strSQL109."]");
$Num_Rows109 = mysqli_num_rows($objQuery109);

while($objResult109 = mysqli_fetch_array($objQuery109))
{
	?><span class="style39"><?php echo $objResult109["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult109["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult109["description"];?>
<br>


<?php }
?>



		</td>

		<td align="left" bgcolor="#FFCC99" class="style35">

<?php 

$strSQL51 = "SELECT *  FROM tb_register_data where start_date ='".$date_9."' and code_bus='4'";

$objQuery51 = mysqli_query($com1,$strSQL51) or die ("Error Query [".$strSQL51."]");
$Num_Rows51 = mysqli_num_rows($objQuery51);

while($objResult51 = mysqli_fetch_array($objQuery51))
{
	?>
			<span class="style39"><?php echo $objResult51["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult51["address_name"];?>
<br>
<span class="style40"><?php echo $objResult51["start_time"];?><?php echo '-';?><?php echo $objResult51["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL110 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_9."' and bus_code = '4'  and status = 'ใช้งาน'";

$objQuery110 = mysqli_query($com1,$strSQL110) or die ("Error Query [".$strSQL110."]");
$Num_Rows110 = mysqli_num_rows($objQuery110);

while($objResult110 = mysqli_fetch_array($objQuery110))
{
	?><span class="style39"><?php echo $objResult110["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult110["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult110["description"];?>
<br>


<?php }
?>



		</td>
	
	<td align="left" bgcolor="#FFCC99" class="style35">

<?php 

$strSQL52 = "SELECT *  FROM tb_register_data where start_date ='".$date_10."' and code_bus='4'";

$objQuery52 = mysqli_query($com1,$strSQL52) or die ("Error Query [".$strSQL52."]");
$Num_Rows52 = mysqli_num_rows($objQuery52);

while($objResult52 = mysqli_fetch_array($objQuery52))
{
	?>
			<span class="style39"><?php echo $objResult52["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult52["address_name"];?>
<br>
<span class="style40"><?php echo $objResult52["start_time"];?><?php echo '-';?><?php echo $objResult52["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL111 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_10."' and bus_code = '4'  and status = 'ใช้งาน'";

$objQuery111 = mysqli_query($com1,$strSQL111) or die ("Error Query [".$strSQL111."]");
$Num_Rows111 = mysqli_num_rows($objQuery111);

while($objResult111 = mysqli_fetch_array($objQuery111))
{
	?><span class="style39"><?php echo $objResult111["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult111["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult111["description"];?>
<br>


<?php }
?>


		</td>

	<td align="left" bgcolor="#FFCC99" class="style35">

	
<?php 

$strSQL53 = "SELECT *  FROM tb_register_data where start_date ='".$date_11."' and code_bus='4'";

$objQuery53 = mysqli_query($com1,$strSQL53) or die ("Error Query [".$strSQL53."]");
$Num_Rows53 = mysqli_num_rows($objQuery53);

while($objResult53 = mysqli_fetch_array($objQuery53))
{
	?>
	<span class="style39"><?php echo $objResult53["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult53["address_name"];?>
<br>
<span class="style40"><?php echo $objResult53["start_time"];?><?php echo '-';?><?php echo $objResult53["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL112 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_11."' and bus_code = '4'  and status = 'ใช้งาน'";

$objQuery112 = mysqli_query($com1,$strSQL112) or die ("Error Query [".$strSQL112."]");
$Num_Rows112 = mysqli_num_rows($objQuery112);

while($objResult112 = mysqli_fetch_array($objQuery112))
{
	?><span class="style39"><?php echo $objResult112["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult112["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult112["description"];?>
<br>


<?php }
?>

		</td>

	<td align="left" bgcolor="#FFCC99" class="style35">
	<?php 

$strSQL54 = "SELECT *  FROM tb_register_data where start_date ='".$date_12."' and code_bus='4'";

$objQuery54 = mysqli_query($com1,$strSQL54) or die ("Error Query [".$strSQL54."]");
$Num_Rows54 = mysqli_num_rows($objQuery54);

while($objResult54 = mysqli_fetch_array($objQuery54))
{
	?>
		<span class="style39"><?php echo $objResult54["employee_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult54["address_name"];?>
<br>
<span class="style40"><?php echo $objResult54["start_time"];?><?php echo '-';?><?php echo $objResult54["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL113 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_12."' and bus_code = '4'  and status = 'ใช้งาน'";

$objQuery113 = mysqli_query($com1,$strSQL113) or die ("Error Query [".$strSQL113."]");
$Num_Rows113 = mysqli_num_rows($objQuery113);

while($objResult113 = mysqli_fetch_array($objQuery113))
{
	?><span class="style39"><?php echo $objResult113["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult113["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult113["description"];?>
<br>


<?php }
?>

		</td>

	
	<td align="left" bgcolor="#FFCC99" class="style35">

	<?php 

$strSQL55 = "SELECT *  FROM tb_register_data where start_date ='".$date_13."' and code_bus='4'";

$objQuery55 = mysqli_query($com1,$strSQL55) or die ("Error Query [".$strSQL55."]");
$Num_Rows55 = mysqli_num_rows($objQuery55);
while($objResult55 = mysqli_fetch_array($objQuery55))
{
	?>
		<span class="style39"><?php echo $objResult55["employee_send"];?></span>
<br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult55["address_name"];?>
<br>
<span class="style40"><?php echo $objResult55["start_time"];?><?php echo '-';?><?php echo $objResult55["end_time"];?></span>
<br>


<?php }
?>
		
<?php 

$strSQL114 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_13."' and bus_code = '4'  and status = 'ใช้งาน'";

$objQuery114 = mysqli_query($com1,$strSQL114) or die ("Error Query [".$strSQL114."]");
$Num_Rows114 = mysqli_num_rows($objQuery114);

while($objResult114 = mysqli_fetch_array($objQuery114))
{
	?><span class="style39"><?php echo $objResult114["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult114["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult114["description"];?>
<br>


<?php }
?>

		</td>

	<td align="left" bgcolor="#FFCC99" class="style35">

	<?php 

$strSQL56 = "SELECT *  FROM tb_register_data where start_date ='".$date_14."' and code_bus='4'";

$objQuery56 = mysqli_query($com1,$strSQL56) or die ("Error Query [".$strSQL56."]");
$Num_Rows56 = mysqli_num_rows($objQuery56);

while($objResult56 = mysqli_fetch_array($objQuery56))
{
	?>
		<span class="style39"><?php echo $objResult56["employee_send"];?></span>
<br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult56["address_name"];?>
<br>
<span class="style40"><?php echo $objResult56["start_time"];?><?php echo '-';?><?php echo $objResult56["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL115 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_14."' and bus_code = '4'  and status = 'ใช้งาน'";

$objQuery115 = mysqli_query($com1,$strSQL115) or die ("Error Query [".$strSQL115."]");
$Num_Rows115 = mysqli_num_rows($objQuery115);

while($objResult115 = mysqli_fetch_array($objQuery115))
{
	?><span class="style39"><?php echo $objResult115["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult115["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult115["description"];?>
<br>


<?php }
?>

		</td>

	
		</tr>


<tr>

<td align="left" bgcolor="#FFCCFF" class="style35"><?php echo "คันที่5 6867"; ?>
</td>

<td align="left" bgcolor="#FFCCFF" class="style35">
<?php 

$strSQL36 = "SELECT *  FROM tb_register_data where start_date ='".$date_8."' and code_bus='8'";
$objQuery36 = mysqli_query($com1,$strSQL36) or die ("Error Query [".$strSQL36."]");
$Num_Rows36 = mysqli_num_rows($objQuery36);

while($objResult36 = mysqli_fetch_array($objQuery36))
{
	?><span class="style39"><?php echo $objResult36["employee_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult36["address_name"];?>
<br>
<span class="style40"><?php echo $objResult36["start_time"];?><?php echo '-';?><?php echo $objResult36["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL95 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_8."' and bus_code = '8'  and status = 'ใช้งาน'";

$objQuery95 = mysqli_query($com1,$strSQL95) or die ("Error Query [".$strSQL95."]");
$Num_Rows95 = mysqli_num_rows($objQuery95);

while($objResult95 = mysqli_fetch_array($objQuery95))
{
	?><span class="style39"><?php echo $objResult95["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult95["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult95["description"];?>
<br>


<?php }
?>



		</td>

		<td align="left" bgcolor="#FFCCFF" class="style35">

<?php 

$strSQL37 = "SELECT *  FROM tb_register_data where start_date ='".$date_9."' and code_bus='8'";

$objQuery37 = mysqli_query($com1,$strSQL37) or die ("Error Query [".$strSQL37."]");
$Num_Rows37 = mysqli_num_rows($objQuery37);

while($objResult37 = mysqli_fetch_array($objQuery37))
{
	?>
			<span class="style39"><?php echo $objResult37["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult37["address_name"];?>
<br>
<span class="style40"><?php echo $objResult37["start_time"];?><?php echo '-';?><?php echo $objResult37["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL96 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_9."' and bus_code = '8'  and status = 'ใช้งาน'";

$objQuery96 = mysqli_query($com1,$strSQL96) or die ("Error Query [".$strSQL96."]");
$Num_Rows96 = mysqli_num_rows($objQuery96);

while($objResult96 = mysqli_fetch_array($objQuery96))
{
	?><span class="style39"><?php echo $objResult96["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult96["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult96["description"];?>
<br>


<?php }
?>



		</td>
	
	<td align="left" bgcolor="#FFCCFF" class="style35">

<?php 

$strSQL38 = "SELECT *  FROM tb_register_data where start_date ='".$date_10."' and code_bus='8'";

$objQuery38 = mysqli_query($com1,$strSQL38) or die ("Error Query [".$strSQL38."]");
$Num_Rows38 = mysqli_num_rows($objQuery38);

while($objResult38 = mysqli_fetch_array($objQuery38))
{
	?>
			<span class="style39"><?php echo $objResult38["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult38["address_name"];?>
<br>
<span class="style40"><?php echo $objResult38["start_time"];?><?php echo '-';?><?php echo $objResult38["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL97 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_10."' and bus_code = '8'  and status = 'ใช้งาน'";

$objQuery97 = mysqli_query($com1,$strSQL97) or die ("Error Query [".$strSQL97."]");
$Num_Rows97 = mysqli_num_rows($objQuery97);

while($objResult97 = mysqli_fetch_array($objQuery97))
{
	?><span class="style39"><?php echo $objResult97["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult97["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult97["description"];?>
<br>


<?php }
?>


		</td>

	<td align="left" bgcolor="#FFCCFF" class="style35">

	
<?php 

$strSQL39 = "SELECT *  FROM tb_register_data where start_date ='".$date_11."' and code_bus='8'";

$objQuery39 = mysqli_query($com1,$strSQL39) or die ("Error Query [".$strSQL39."]");
$Num_Rows39 = mysqli_num_rows($objQuery39);
while($objResult39 = mysqli_fetch_array($objQuery39))
{
	?>
	<span class="style39"><?php echo $objResult39["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult39["address_name"];?>
<span class="style40"><?php echo $objResult39["start_time"];?><?php echo '-';?><?php echo $objResult39["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL98 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_11."' and bus_code = '8'  and status = 'ใช้งาน'";

$objQuery98 = mysqli_query($com1,$strSQL98) or die ("Error Query [".$strSQL98."]");
$Num_Rows98 = mysqli_num_rows($objQuery98);

while($objResult98 = mysqli_fetch_array($objQuery98))
{
	?><span class="style39"><?php echo $objResult98["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult98["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult98["description"];?>
<br>


<?php }
?>

		</td>

	<td align="left" bgcolor="#FFCCFF" class="style35">
	<?php 

$strSQL40 = "SELECT *  FROM tb_register_data where start_date ='".$date_12."' and code_bus='8'";

$objQuery40 = mysqli_query($com1,$strSQL40) or die ("Error Query [".$strSQL40."]");
$Num_Rows40 = mysqli_num_rows($objQuery40);

while($objResult40 = mysqli_fetch_array($objQuery40))
{
	?>
		<span class="style39"><?php echo $objResult40["employee_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult40["address_name"];?>
<br>
<span class="style40"><?php echo $objResult40["start_time"];?><?php echo '-';?><?php echo $objResult40["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL99 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_12."' and bus_code = '8'  and status = 'ใช้งาน'";

$objQuery99 = mysqli_query($com1,$strSQL99) or die ("Error Query [".$strSQL99."]");
$Num_Rows99 = mysqli_num_rows($objQuery99);

while($objResult99 = mysqli_fetch_array($objQuery99))
{
	?><span class="style39"><?php echo $objResult99["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult99["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult99["description"];?>
<br>


<?php }
?>

		</td>

	
	<td align="left" bgcolor="#FFCCFF" class="style35">

	<?php 

$strSQL41 = "SELECT *  FROM tb_register_data where start_date ='".$date_13."' and code_bus='8'";

$objQuery41 = mysqli_query($com1,$strSQL41) or die ("Error Query [".$strSQL41."]");
$Num_Rows41 = mysqli_num_rows($objQuery41);
while($objResult41 = mysqli_fetch_array($objQuery41))
{
	?>
		<span class="style39"><?php echo $objResult41["employee_send"];?></span>
<br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult41["address_name"];?>
<br>
<span class="style40"><?php echo $objResult41["start_time"];?><?php echo '-';?><?php echo $objResult41["end_time"];?></span>
<br>


<?php }
?>
		
<?php 

$strSQL100 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_13."' and bus_code = '8'  and status = 'ใช้งาน'";

$objQuery100 = mysqli_query($com1,$strSQL100) or die ("Error Query [".$strSQL100."]");
$Num_Rows100 = mysqli_num_rows($objQuery100);

while($objResult100 = mysqli_fetch_array($objQuery100))
{
	?><span class="style39"><?php echo $objResult100["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult100["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult100["description"];?>
<br>


<?php }
?>

		</td>

	<td align="left" bgcolor="#FFCCFF" class="style35">

	<?php 

$strSQL42 = "SELECT *  FROM tb_register_data where start_date ='".$date_14."' and code_bus='8'";

$objQuery42 = mysqli_query($com1,$strSQL42) or die ("Error Query [".$strSQL42."]");
$Num_Rows42 = mysqli_num_rows($objQuery42);



while($objResult42 = mysqli_fetch_array($objQuery42))
{
	?>
		<span class="style39"><?php echo $objResult42["employee_send"];?></span>
<br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult42["address_name"];?>
<br>
<span class="style40"><?php echo $objResult42["start_time"];?><?php echo '-';?><?php echo $objResult42["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL101 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_14."' and bus_code = '8'  and status = 'ใช้งาน'";

$objQuery101 = mysqli_query($com1,$strSQL101) or die ("Error Query [".$strSQL101."]");
$Num_Rows101 = mysqli_num_rows($objQuery101);

while($objResult101 = mysqli_fetch_array($objQuery101))
{
	?><span class="style39"><?php echo $objResult101["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult101["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult101["description"];?>
<br>


<?php }
?>

		</td>
	
		</tr>
		
<tr>

<td align="left" bgcolor="#99CCFF" class="style35"><?php echo "ขนส่งนอก"; ?>
</td>

<td align="left" bgcolor="#99CCFF" class="style35">
<?php 

$strSQL36 = "SELECT *  FROM tb_register_data where start_date ='".$date_8."' and code_bus='9'";
$objQuery36 = mysqli_query($com1,$strSQL36) or die ("Error Query [".$strSQL36."]");
$Num_Rows36 = mysqli_num_rows($objQuery36);

while($objResult36 = mysqli_fetch_array($objQuery36))
{
	?><span class="style39"><?php echo $objResult36["employee_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult36["address_name"];?>
<br>
<span class="style40"><?php echo $objResult36["start_time"];?><?php echo '-';?><?php echo $objResult36["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL95 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_8."' and bus_code = '9'  and status = 'ใช้งาน'";

$objQuery95 = mysqli_query($com1,$strSQL95) or die ("Error Query [".$strSQL95."]");
$Num_Rows95 = mysqli_num_rows($objQuery95);

while($objResult95 = mysqli_fetch_array($objQuery95))
{
	?><span class="style39"><?php echo $objResult95["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult95["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult95["description"];?>
<br>


<?php }
?>



		</td>

		<td align="left" bgcolor="#99CCFF" class="style35">

<?php 

$strSQL37 = "SELECT *  FROM tb_register_data where start_date ='".$date_9."' and code_bus='9'";

$objQuery37 = mysqli_query($com1,$strSQL37) or die ("Error Query [".$strSQL37."]");
$Num_Rows37 = mysqli_num_rows($objQuery37);

while($objResult37 = mysqli_fetch_array($objQuery37))
{
	?>
			<span class="style39"><?php echo $objResult37["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult37["address_name"];?>
<br>
<span class="style40"><?php echo $objResult37["start_time"];?><?php echo '-';?><?php echo $objResult37["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL96 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_9."' and bus_code = '9'  and status = 'ใช้งาน'";

$objQuery96 = mysqli_query($com1,$strSQL96) or die ("Error Query [".$strSQL96."]");
$Num_Rows96 = mysqli_num_rows($objQuery96);

while($objResult96 = mysqli_fetch_array($objQuery96))
{
	?><span class="style39"><?php echo $objResult96["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult96["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult96["description"];?>
<br>


<?php }
?>



		</td>
	
	<td align="left" bgcolor="#99CCFF" class="style35">

<?php 

$strSQL38 = "SELECT *  FROM tb_register_data where start_date ='".$date_10."' and code_bus='9'";

$objQuery38 = mysqli_query($com1,$strSQL38) or die ("Error Query [".$strSQL38."]");
$Num_Rows38 = mysqli_num_rows($objQuery38);

while($objResult38 = mysqli_fetch_array($objQuery38))
{
	?>
			<span class="style39"><?php echo $objResult38["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult38["address_name"];?>
<br>
<span class="style40"><?php echo $objResult38["start_time"];?><?php echo '-';?><?php echo $objResult38["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL97 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_10."' and bus_code = '9'  and status = 'ใช้งาน'";

$objQuery97 = mysqli_query($com1,$strSQL97) or die ("Error Query [".$strSQL97."]");
$Num_Rows97 = mysqli_num_rows($objQuery97);

while($objResult97 = mysqli_fetch_array($objQuery97))
{
	?><span class="style39"><?php echo $objResult97["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult97["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult97["description"];?>
<br>


<?php }
?>


		</td>

	<td align="left" bgcolor="#99CCFF" class="style35">

	
<?php 

$strSQL39 = "SELECT *  FROM tb_register_data where start_date ='".$date_11."' and code_bus='9'";

$objQuery39 = mysqli_query($com1,$strSQL39) or die ("Error Query [".$strSQL39."]");
$Num_Rows39 = mysqli_num_rows($objQuery39);
while($objResult39 = mysqli_fetch_array($objQuery39))
{
	?>
	<span class="style39"><?php echo $objResult39["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult39["address_name"];?>
<span class="style40"><?php echo $objResult39["start_time"];?><?php echo '-';?><?php echo $objResult39["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL98 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_11."' and bus_code = '9'  and status = 'ใช้งาน'";

$objQuery98 = mysqli_query($com1,$strSQL98) or die ("Error Query [".$strSQL98."]");
$Num_Rows98 = mysqli_num_rows($objQuery98);

while($objResult98 = mysqli_fetch_array($objQuery98))
{
	?><span class="style39"><?php echo $objResult98["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult98["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult98["description"];?>
<br>


<?php }
?>

		</td>

	<td align="left" bgcolor="#99CCFF" class="style35">
	<?php 

$strSQL40 = "SELECT *  FROM tb_register_data where start_date ='".$date_12."' and code_bus='9'";

$objQuery40 = mysqli_query($com1,$strSQL40) or die ("Error Query [".$strSQL40."]");
$Num_Rows40 = mysqli_num_rows($objQuery40);

while($objResult40 = mysqli_fetch_array($objQuery40))
{
	?>
		<span class="style39"><?php echo $objResult40["employee_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult40["address_name"];?>
<br>
<span class="style40"><?php echo $objResult40["start_time"];?><?php echo '-';?><?php echo $objResult40["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL99 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_12."' and bus_code = '9'  and status = 'ใช้งาน'";

$objQuery99 = mysqli_query($com1,$strSQL99) or die ("Error Query [".$strSQL99."]");
$Num_Rows99 = mysqli_num_rows($objQuery99);

while($objResult99 = mysqli_fetch_array($objQuery99))
{
	?><span class="style39"><?php echo $objResult99["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult99["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult99["description"];?>
<br>


<?php }
?>

		</td>

	
	<td align="left" bgcolor="#99CCFF" class="style35">

	<?php 

$strSQL41 = "SELECT *  FROM tb_register_data where start_date ='".$date_13."' and code_bus='9'";

$objQuery41 = mysqli_query($com1,$strSQL41) or die ("Error Query [".$strSQL41."]");
$Num_Rows41 = mysqli_num_rows($objQuery41);
while($objResult41 = mysqli_fetch_array($objQuery41))
{
	?>
		<span class="style39"><?php echo $objResult41["employee_send"];?></span>
<br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult41["address_name"];?>
<br>
<span class="style40"><?php echo $objResult41["start_time"];?><?php echo '-';?><?php echo $objResult41["end_time"];?></span>
<br>


<?php }
?>
		
<?php 

$strSQL100 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_13."' and bus_code = '9'  and status = 'ใช้งาน'";

$objQuery100 = mysqli_query($com1,$strSQL100) or die ("Error Query [".$strSQL100."]");
$Num_Rows100 = mysqli_num_rows($objQuery100);

while($objResult100 = mysqli_fetch_array($objQuery100))
{
	?><span class="style39"><?php echo $objResult100["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult100["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult100["description"];?>
<br>


<?php }
?>

		</td>

	<td align="left" bgcolor="#99CCFF" class="style35">

	<?php 

$strSQL42 = "SELECT *  FROM tb_register_data where start_date ='".$date_14."' and code_bus='9'";

$objQuery42 = mysqli_query($com1,$strSQL42) or die ("Error Query [".$strSQL42."]");
$Num_Rows42 = mysqli_num_rows($objQuery42);



while($objResult42 = mysqli_fetch_array($objQuery42))
{
	?>
		<span class="style39"><?php echo $objResult42["employee_send"];?></span>
<br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult42["address_name"];?>
<br>
<span class="style40"><?php echo $objResult42["start_time"];?><?php echo '-';?><?php echo $objResult42["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL101 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_14."' and bus_code = '9'  and status = 'ใช้งาน'";

$objQuery101 = mysqli_query($com1,$strSQL101) or die ("Error Query [".$strSQL101."]");
$Num_Rows101 = mysqli_num_rows($objQuery101);

while($objResult101 = mysqli_fetch_array($objQuery101))
{
	?><span class="style39"><?php echo $objResult101["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult101["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult101["description"];?>
<br>


<?php }
?>

		</td>
	
		</tr>
		

<tr>
<td width="5%" align="right"  class="style35"></td>
<td width="15%" align="right"  class="style35"><?php echo $day15 ; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 15</td>
<td width="15%" align="right"  class="style35"><?php echo $day16 ; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 16</td>
<td width="15%" align="right"  class="style35"><?php echo $day17 ; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 17</td>
<td width="15%" align="right"  class="style35"><?php echo $day18 ; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 18</td>
<td width="15%" align="right"  class="style35"><?php echo $day19 ; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 19</td>
<td width="15%" align="right"  class="style35"><?php echo $day20 ; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 20</td>
<td width="15%" align="right"  class="style35"><?php echo $day21 ; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 21</td>

</tr>


<tr>

<td align="center" bgcolor="CC99CC" class="style35"> <?php echo "คันที่ 1 8952"; ?>
		</td>


		<td align="left" bgcolor="CC99CC" class="style35">
<?php 

$strSQL29 = "SELECT *  FROM tb_register_data where start_date ='".$date_15."' and code_bus='1'";

$objQuery29 = mysqli_query($com1,$strSQL29) or die ("Error Query [".$strSQL29."]");
$Num_Rows29 = mysqli_num_rows($objQuery29);

while($objResult29 = mysqli_fetch_array($objQuery29))
{
	?><span class="style39"><?php echo $objResult29["employee_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult29["address_name"];?>
<br>
 <span class="style40"><?php echo $objResult29["start_time"];?><?php echo '-';?><?php echo $objResult29["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL116 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_15."' and bus_code = '1'  and status = 'ใช้งาน'";

$objQuery116 = mysqli_query($com1,$strSQL116) or die ("Error Query [".$strSQL116."]");
$Num_Rows116 = mysqli_num_rows($objQuery116);

while($objResult116 = mysqli_fetch_array($objQuery116))
{
	?><span class="style39"><?php echo $objResult116["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult116["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult116["description"];?>
<br>


<?php }
?>



		</td>

		<td align="left" bgcolor="CC99CC" class="style35">

<?php 

$strSQL30 = "SELECT *  FROM tb_register_data where start_date ='".$date_16."' and code_bus='1'";

$objQuery30 = mysqli_query($com1,$strSQL30) or die ("Error Query [".$strSQL30."]");
$Num_Rows30 = mysqli_num_rows($objQuery30);

while($objResult30 = mysqli_fetch_array($objQuery30))
{
	?>
			<span class="style39"><?php echo $objResult30["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult30["address_name"];?>
<br>
<span class="style40"><?php echo $objResult30["start_time"];?><?php echo '-';?><?php echo $objResult30["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL117 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_16."' and bus_code = '1'  and status = 'ใช้งาน'";

$objQuery117 = mysqli_query($com1,$strSQL117) or die ("Error Query [".$strSQL117."]");
$Num_Rows117 = mysqli_num_rows($objQuery117);

while($objResult117 = mysqli_fetch_array($objQuery117))
{
	?><span class="style39"><?php echo $objResult117["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult117["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult117["description"];?>
<br>


<?php }
?>



		</td>
	
	<td align="left" bgcolor="CC99CC" class="style35">

<?php 

$strSQL31 = "SELECT *  FROM tb_register_data where start_date ='".$date_17."' and code_bus='1'";

$objQuery31 = mysqli_query($com1,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);

while($objResult31 = mysqli_fetch_array($objQuery31))
{
	?>
			<span class="style39"><?php echo $objResult31["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult31["address_name"];?>
<br>
<span class="style40"><?php echo $objResult31["start_time"];?><?php echo '-';?><?php echo $objResult31["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL118 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_17."' and bus_code = '1'  and status = 'ใช้งาน'";

$objQuery118 = mysqli_query($com1,$strSQL118) or die ("Error Query [".$strSQL118."]");
$Num_Rows118 = mysqli_num_rows($objQuery118);

while($objResult118 = mysqli_fetch_array($objQuery118))
{
	?><span class="style39"><?php echo $objResult118["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult118["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult118["description"];?>
<br>


<?php }
?>


		</td>

	<td align="left" bgcolor="CC99CC" class="style35">

	
<?php 

$strSQL32 = "SELECT *  FROM tb_register_data where start_date ='".$date_18."' and code_bus='1'";

$objQuery32 = mysqli_query($com1,$strSQL32) or die ("Error Query [".$strSQL32."]");
$Num_Rows32 = mysqli_num_rows($objQuery32);
while($objResult32 = mysqli_fetch_array($objQuery32))
{
	?>
	<span class="style39"><?php echo $objResult32["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult32["address_name"];?>
<br>
<span class="style40"><?php echo $objResult32["start_time"];?><?php echo '-';?><?php echo $objResult32["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL119 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_18."' and bus_code = '1'  and status = 'ใช้งาน'";

$objQuery119 = mysqli_query($com1,$strSQL119) or die ("Error Query [".$strSQL119."]");
$Num_Rows119 = mysqli_num_rows($objQuery119);

while($objResult119 = mysqli_fetch_array($objQuery119))
{
	?><span class="style39"><?php echo $objResult119["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult119["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult119["description"];?>
<br>


<?php }
?>

		</td>

	<td align="left" bgcolor="CC99CC" class="style35">
	<?php 

$strSQL33 = "SELECT *  FROM tb_register_data where start_date ='".$date_19."' and code_bus='1'";

$objQuery33 = mysqli_query($com1,$strSQL33) or die ("Error Query [".$strSQL33."]");
$Num_Rows33 = mysqli_num_rows($objQuery33);

while($objResult33 = mysqli_fetch_array($objQuery33))
{
	?>
		<span class="style39"><?php echo $objResult33["employee_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult33["address_name"];?>
<br>
 <span class="style40"><?php echo $objResult33["start_time"];?><?php echo '-';?><?php echo $objResult33["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL120 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_19."' and bus_code = '1'  and status = 'ใช้งาน'";

$objQuery120 = mysqli_query($com1,$strSQL120) or die ("Error Query [".$strSQL120."]");
$Num_Rows120 = mysqli_num_rows($objQuery120);

while($objResult120 = mysqli_fetch_array($objQuery120))
{
	?><span class="style39"><?php echo $objResult120["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult120["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult120["description"];?>
<br>


<?php }
?>

		
		</td>

	
	<td align="left" bgcolor="CC99CC" class="style35">

	<?php 

$strSQL34 = "SELECT *  FROM tb_register_data where start_date ='".$date_20."' and code_bus='1'";

$objQuery34 = mysqli_query($com1,$strSQL34) or die ("Error Query [".$strSQL34."]");
$Num_Rows34 = mysqli_num_rows($objQuery34);
while($objResult34 = mysqli_fetch_array($objQuery34))
{
	?>
		<span class="style39"><?php echo $objResult34["employee_send"];?></span>
<br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult34["address_name"];?>
<br>
 <span class="style40"><?php echo $objResult34["start_time"];?><?php echo '-';?><?php echo $objResult34["end_time"];?></span>
<br>


<?php }
?>
		
<?php 

$strSQL121 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_20."' and bus_code = '1'  and status = 'ใช้งาน'";

$objQuery121 = mysqli_query($com1,$strSQL121) or die ("Error Query [".$strSQL121."]");
$Num_Rows121 = mysqli_num_rows($objQuery121);

while($objResult121 = mysqli_fetch_array($objQuery121))
{
	?><span class="style39"><?php echo $objResult121["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult121["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult121["description"];?>
<br>


<?php }
?>

		</td>

	<td align="left" bgcolor="CC99CC" class="style35">

	<?php 

$strSQL35 = "SELECT *  FROM tb_register_data where start_date ='".$date_21."' and code_bus='1'";

$objQuery35 = mysqli_query($com1,$strSQL35) or die ("Error Query [".$strSQL35."]");
$Num_Rows35 = mysqli_num_rows($objQuery35);
while($objResult35 = mysqli_fetch_array($objQuery35))
{
	?>
		<span class="style39"><?php echo $objResult35["employee_send"];?></span>
<br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult35["address_name"];?>
<br>
 <span class="style40"><?php echo $objResult35["start_time"];?><?php echo '-';?><?php echo $objResult35["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL122 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_21."' and bus_code = '1'  and status = 'ใช้งาน'";

$objQuery122 = mysqli_query($com1,$strSQL122) or die ("Error Query [".$strSQL122."]");
$Num_Rows122 = mysqli_num_rows($objQuery122);

while($objResult122 = mysqli_fetch_array($objQuery122))
{
	?><span class="style39"><?php echo $objResult122["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult122["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult122["description"];?>
<br>


<?php }
?>

		</td>
	
	






		</tr>
	
		







<tr>

<td align="left" bgcolor="#CCFF99" class="style35"><?php echo "คันที่ 2 9322"; ?>
</td>

<td align="left" bgcolor="#CCFF99" class="style35">
<?php 

$strSQL36 = "SELECT *  FROM tb_register_data where start_date ='".$date_15."' and code_bus='2'";
$objQuery36 = mysqli_query($com1,$strSQL36) or die ("Error Query [".$strSQL36."]");
$Num_Rows36 = mysqli_num_rows($objQuery36);

while($objResult36 = mysqli_fetch_array($objQuery36))
{
	?><span class="style39"><?php echo $objResult36["employee_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult36["address_name"];?>
<br>
<span class="style40"><?php echo $objResult36["start_time"];?><?php echo '-';?><?php echo $objResult36["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL123 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_15."' and bus_code = '2'  and status = 'ใช้งาน'";

$objQuery123 = mysqli_query($com1,$strSQL123) or die ("Error Query [".$strSQL123."]");
$Num_Rows123 = mysqli_num_rows($objQuery123);

while($objResult123 = mysqli_fetch_array($objQuery123))
{
	?><span class="style39"><?php echo $objResult123["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult123["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult123["description"];?>
<br>


<?php }
?>




		</td>

		<td align="left" bgcolor="#CCFF99" class="style35">

<?php 

$strSQL37 = "SELECT *  FROM tb_register_data where start_date ='".$date_16."' and code_bus='2'";

$objQuery37 = mysqli_query($com1,$strSQL37) or die ("Error Query [".$strSQL37."]");
$Num_Rows37 = mysqli_num_rows($objQuery37);

while($objResult37 = mysqli_fetch_array($objQuery37))
{
	?>
			<span class="style39"><?php echo $objResult37["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult37["address_name"];?>
<br>
<span class="style40"><?php echo $objResult37["start_time"];?><?php echo '-';?><?php echo $objResult37["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL124 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_16."' and bus_code = '2'  and status = 'ใช้งาน'";

$objQuery124 = mysqli_query($com1,$strSQL124) or die ("Error Query [".$strSQL124."]");
$Num_Rows124 = mysqli_num_rows($objQuery124);

while($objResult124 = mysqli_fetch_array($objQuery124))
{
	?><span class="style39"><?php echo $objResult124["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult124["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult124["description"];?>
<br>


<?php }
?>



		</td>
	
	<td align="left" bgcolor="#CCFF99" class="style35">

<?php 

$strSQL38 = "SELECT *  FROM tb_register_data where start_date ='".$date_17."' and code_bus='2'";

$objQuery38 = mysqli_query($com1,$strSQL38) or die ("Error Query [".$strSQL38."]");
$Num_Rows38 = mysqli_num_rows($objQuery38);

while($objResult38 = mysqli_fetch_array($objQuery38))
{
	?>
			<span class="style39"><?php echo $objResult38["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult38["address_name"];?>
<br>
<span class="style40"><?php echo $objResult38["start_time"];?><?php echo '-';?><?php echo $objResult38["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL125 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_17."' and bus_code = '2'  and status = 'ใช้งาน'";

$objQuery125 = mysqli_query($com1,$strSQL125) or die ("Error Query [".$strSQL125."]");
$Num_Rows125 = mysqli_num_rows($objQuery125);

while($objResult125 = mysqli_fetch_array($objQuery125))
{
	?><span class="style39"><?php echo $objResult125["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult125["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult125["description"];?>
<br>


<?php }
?>


		</td>

	<td align="left" bgcolor="#CCFF99" class="style35">

	
<?php 

$strSQL39 = "SELECT *  FROM tb_register_data where start_date ='".$date_18."' and code_bus='2'";

$objQuery39 = mysqli_query($com1,$strSQL39) or die ("Error Query [".$strSQL39."]");
$Num_Rows39 = mysqli_num_rows($objQuery39);
while($objResult39 = mysqli_fetch_array($objQuery39))
{
	?>
	<span class="style39"><?php echo $objResult39["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult39["address_name"];?>
<br>
<span class="style40"><?php echo $objResult39["start_time"];?><?php echo '-';?><?php echo $objResult39["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL126 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_18."' and bus_code = '2'  and status = 'ใช้งาน'";

$objQuery126 = mysqli_query($com1,$strSQL126) or die ("Error Query [".$strSQL126."]");
$Num_Rows126 = mysqli_num_rows($objQuery126);

while($objResult126 = mysqli_fetch_array($objQuery126))
{
	?><span class="style39"><?php echo $objResult126["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult126["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult126["description"];?>
<br>


<?php }
?>

		</td>

	<td align="left" bgcolor="#CCFF99" class="style35">
	<?php 

$strSQL40 = "SELECT *  FROM tb_register_data where start_date ='".$date_19."' and code_bus='2'";

$objQuery40 = mysqli_query($com1,$strSQL40) or die ("Error Query [".$strSQL40."]");
$Num_Rows40 = mysqli_num_rows($objQuery40);

while($objResult40 = mysqli_fetch_array($objQuery40))
{
	?>
		<span class="style39"><?php echo $objResult40["employee_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult40["address_name"];?>
<br>
<span class="style40"><?php echo $objResult40["start_time"];?><?php echo '-';?><?php echo $objResult40["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL127 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_19."' and bus_code = '2'  and status = 'ใช้งาน'";

$objQuery127 = mysqli_query($com1,$strSQL127) or die ("Error Query [".$strSQL127."]");
$Num_Rows127 = mysqli_num_rows($objQuery127);

while($objResult127 = mysqli_fetch_array($objQuery127))
{
	?><span class="style39"><?php echo $objResult127["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult127["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult127["description"];?>
<br>


<?php }
?>


		</td>

	
	<td align="left" bgcolor="#CCFF99" class="style35">

	<?php 

$strSQL41 = "SELECT *  FROM tb_register_data where start_date ='".$date_20."' and code_bus='2'";

$objQuery41 = mysqli_query($com1,$strSQL41) or die ("Error Query [".$strSQL41."]");
$Num_Rows41 = mysqli_num_rows($objQuery41);
while($objResult41 = mysqli_fetch_array($objQuery41))
{
	?>
		<span class="style39"><?php echo $objResult41["employee_send"];?></span>
<br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult41["address_name"];?>
<br>
<span class="style40"><?php echo $objResult41["start_time"];?><?php echo '-';?><?php echo $objResult41["end_time"];?></span>
<br>


<?php }
?>
	
<?php 

$strSQL128 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_20."' and bus_code = '2'  and status = 'ใช้งาน'";

$objQuery128 = mysqli_query($com1,$strSQL128) or die ("Error Query [".$strSQL128."]");
$Num_Rows128 = mysqli_num_rows($objQuery128);

while($objResult128 = mysqli_fetch_array($objQuery128))
{
	?><span class="style39"><?php echo $objResult128["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult128["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult128["description"];?>
<br>


<?php }
?>
	
</td>

	<td align="left" bgcolor="#CCFF99" class="style35">

	<?php 

$strSQL42 = "SELECT *  FROM tb_register_data where start_date ='".$date_21."' and code_bus='2'";

$objQuery42 = mysqli_query($com1,$strSQL42) or die ("Error Query [".$strSQL42."]");
$Num_Rows42 = mysqli_num_rows($objQuery42);



while($objResult42 = mysqli_fetch_array($objQuery42))
{
	?>
		<span class="style39"><?php echo $objResult42["employee_send"];?></span>
<br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult42["address_name"];?>
<br>
<span class="style40"><?php echo $objResult42["start_time"];?><?php echo '-';?><?php echo $objResult42["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL129 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_21."' and bus_code = '2'  and status = 'ใช้งาน'";

$objQuery129 = mysqli_query($com1,$strSQL129) or die ("Error Query [".$strSQL129."]");
$Num_Rows129 = mysqli_num_rows($objQuery129);

while($objResult129 = mysqli_fetch_array($objQuery129))
{
	?><span class="style39"><?php echo $objResult129["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult129["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult129["description"];?>
<br>


<?php }
?>

		</td>
	
		</tr>
		

<tr>

<td align="left" bgcolor="#00CCCC" class="style35"><?php echo "คันที่ 3 5644"; ?>
</td>

<td align="left" bgcolor="#00CCCC" class="style35">
<?php 

$strSQL43 = "SELECT *  FROM tb_register_data where start_date ='".$date_15."' and code_bus='3'";

$objQuery43 = mysqli_query($com1,$strSQL43) or die ("Error Query [".$strSQL43."]");
$Num_Rows43 = mysqli_num_rows($objQuery43);

while($objResult43 = mysqli_fetch_array($objQuery43))
{
	?><span class="style39"><?php echo $objResult43["employee_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult43["address_name"];?>
<br>
<span class="style40"><?php echo $objResult43["start_time"];?><?php echo '-';?><?php echo $objResult43["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL130 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_15."' and bus_code = '3'  and status = 'ใช้งาน'";

$objQuery130 = mysqli_query($com1,$strSQL130) or die ("Error Query [".$strSQL130."]");
$Num_Rows130 = mysqli_num_rows($objQuery130);

while($objResult130 = mysqli_fetch_array($objQuery130))
{
	?><span class="style39"><?php echo $objResult130["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult130["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult130["description"];?>
<br>


<?php }
?>



		</td>

		<td align="left" bgcolor="#00CCCC" class="style35">

<?php 

$strSQL44 = "SELECT *  FROM tb_register_data where start_date ='".$date_16."' and code_bus='3'";

$objQuery44 = mysqli_query($com1,$strSQL44) or die ("Error Query [".$strSQL44."]");
$Num_Rows44 = mysqli_num_rows($objQuery44);

while($objResult44 = mysqli_fetch_array($objQuery44))
{
	?>
			<span class="style39"><?php echo $objResult44["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult44["address_name"];?>
<br>
<span class="style40"><?php echo $objResult44["start_time"];?><?php echo '-';?><?php echo $objResult44["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL131 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_16."' and bus_code = '3' and status = 'ใช้งาน'";

$objQuery131 = mysqli_query($com1,$strSQL131) or die ("Error Query [".$strSQL131."]");
$Num_Rows131 = mysqli_num_rows($objQuery131);

while($objResult131 = mysqli_fetch_array($objQuery131))
{
	?><span class="style39"><?php echo $objResult131["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult131["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult131["description"];?>
<br>


<?php }
?>



		</td>
	
	<td align="left" bgcolor="#00CCCC" class="style35">

<?php 

$strSQL45 = "SELECT *  FROM tb_register_data where start_date ='".$date_17."' and code_bus='3'";

$objQuery45 = mysqli_query($com1,$strSQL45) or die ("Error Query [".$strSQL45."]");
$Num_Rows45 = mysqli_num_rows($objQuery45);

while($objResult45 = mysqli_fetch_array($objQuery45))
{
	?>
			<span class="style39"><?php echo $objResult45["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult45["address_name"];?>
<br>
<span class="style40"><?php echo $objResult45["start_time"];?><?php echo '-';?><?php echo $objResult45["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL132 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_17."' and bus_code = '3' and status = 'ใช้งาน'";

$objQuery132 = mysqli_query($com1,$strSQL132) or die ("Error Query [".$strSQL132."]");
$Num_Rows132 = mysqli_num_rows($objQuery132);

while($objResult132 = mysqli_fetch_array($objQuery132))
{
	?><span class="style39"><?php echo $objResult132["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult132["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult132["description"];?>
<br>


<?php }
?>


		</td>

	<td align="left" bgcolor="#00CCCC" class="style35">

	
<?php 

$strSQL46 = "SELECT *  FROM tb_register_data where start_date ='".$date_18."' and code_bus='3'";

$objQuery46 = mysqli_query($com1,$strSQL46) or die ("Error Query [".$strSQL46."]");
$Num_Rows46 = mysqli_num_rows($objQuery46);




while($objResult46 = mysqli_fetch_array($objQuery46))
{
	?>
	<span class="style39"><?php echo $objResult46["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult46["address_name"];?>
<br>
<span class="style40"><?php echo $objResult46["start_time"];?><?php echo '-';?><?php echo $objResult46["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL133 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_18."' and bus_code = '3' and status = 'ใช้งาน'";

$objQuery133 = mysqli_query($com1,$strSQL133) or die ("Error Query [".$strSQL133."]");
$Num_Rows133 = mysqli_num_rows($objQuery133);

while($objResult133 = mysqli_fetch_array($objQuery133))
{
	?><span class="style39"><?php echo $objResult133["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult133["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult133["description"];?>
<br>


<?php }
?>

		</td>

	<td align="left" bgcolor="#00CCCC" class="style35">
	<?php 

$strSQL47 = "SELECT *  FROM tb_register_data where start_date ='".$date_19."' and code_bus='3'";

$objQuery47 = mysqli_query($com1,$strSQL47) or die ("Error Query [".$strSQL47."]");
$Num_Rows47 = mysqli_num_rows($objQuery47);

while($objResult47 = mysqli_fetch_array($objQuery47))
{
	?>
		<span class="style39"><?php echo $objResult47["employee_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult47["address_name"];?>
<br>
<span class="style40"><?php echo $objResult47["start_time"];?><?php echo '-';?><?php echo $objResult47["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL134 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_19."' and bus_code = '3' and status = 'ใช้งาน'";

$objQuery134 = mysqli_query($com1,$strSQL134) or die ("Error Query [".$strSQL134."]");
$Num_Rows134 = mysqli_num_rows($objQuery134);

while($objResult134 = mysqli_fetch_array($objQuery134))
{
	?><span class="style39"><?php echo $objResult134["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult134["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult134["description"];?>
<br>


<?php }
?>

		</td>

	
	<td align="left" bgcolor="#00CCCC" class="style35">

	<?php 

$strSQL48 = "SELECT *  FROM tb_register_data where start_date ='".$date_20."' and code_bus='3'";

$objQuery48 = mysqli_query($com1,$strSQL48) or die ("Error Query [".$strSQL48."]");
$Num_Rows48 = mysqli_num_rows($objQuery48);
while($objResult48 = mysqli_fetch_array($objQuery48))
{
	?>
		<span class="style39"><?php echo $objResult48["employee_send"];?></span>
<br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult48["address_name"];?>
<br>
<span class="style40"><?php echo $objResult48["start_time"];?><?php echo '-';?><?php echo $objResult48["end_time"];?></span>
<br>


<?php }
?>
		
<?php 

$strSQL135 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_20."' and bus_code = '3' and status = 'ใช้งาน'";

$objQuery135 = mysqli_query($com1,$strSQL135) or die ("Error Query [".$strSQL135."]");
$Num_Rows135 = mysqli_num_rows($objQuery135);

while($objResult135 = mysqli_fetch_array($objQuery135))
{
	?><span class="style39"><?php echo $objResult135["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult135["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult135["description"];?>
<br>


<?php }
?>

		</td>

	<td align="left" bgcolor="#00CCCC" class="style35">

	<?php 

$strSQL49 = "SELECT *  FROM tb_register_data where start_date ='".$date_21."' and code_bus='3'";

$objQuery49 = mysqli_query($com1,$strSQL49) or die ("Error Query [".$strSQL49."]");
$Num_Rows49 = mysqli_num_rows($objQuery49);



while($objResult49 = mysqli_fetch_array($objQuery49))
{
	?>
		<span class="style39"><?php echo $objResult49["employee_send"];?></span>
<br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult49["address_name"];?>
<br>
<span class="style40"><?php echo $objResult49["start_time"];?><?php echo '-';?><?php echo $objResult49["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL136 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_21."' and bus_code = '3' and status = 'ใช้งาน'";

$objQuery136 = mysqli_query($com1,$strSQL136) or die ("Error Query [".$strSQL136."]");
$Num_Rows136 = mysqli_num_rows($objQuery136);

while($objResult136 = mysqli_fetch_array($objQuery136))
{
	?><span class="style39"><?php echo $objResult136["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult136["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult136["description"];?>
<br>


<?php }
?>

		</td>
	
		</tr>
		
<tr>
<td align="left" bgcolor="#FFCC99" class="style35"><?php echo "คันที่ 4 1112"; ?>

</td>

<td align="left" bgcolor="#FFCC99" class="style35">
<?php 

$strSQL50 = "SELECT *  FROM tb_register_data where start_date ='".$date_15."' and code_bus='4'";

$objQuery50 = mysqli_query($com1,$strSQL50) or die ("Error Query [".$strSQL50."]");
$Num_Rows50 = mysqli_num_rows($objQuery50);

while($objResult50 = mysqli_fetch_array($objQuery50))
{
	?><span class="style39"><?php echo $objResult50["employee_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult50["address_name"];?>
<br>
<span class="style40"><?php echo $objResult50["start_time"];?><?php echo '-';?><?php echo $objResult50["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL137 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_15."' and bus_code = '4' and status = 'ใช้งาน'";

$objQuery137 = mysqli_query($com1,$strSQL137) or die ("Error Query [".$strSQL137."]");
$Num_Rows137 = mysqli_num_rows($objQuery137);

while($objResult137 = mysqli_fetch_array($objQuery137))
{
	?><span class="style39"><?php echo $objResult137["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult137["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult137["description"];?>
<br>


<?php }
?>



		</td>

		<td align="left" bgcolor="#FFCC99" class="style35">

<?php 

$strSQL51 = "SELECT *  FROM tb_register_data where start_date ='".$date_16."' and code_bus='4'";

$objQuery51 = mysqli_query($com1,$strSQL51) or die ("Error Query [".$strSQL51."]");
$Num_Rows51 = mysqli_num_rows($objQuery51);

while($objResult51 = mysqli_fetch_array($objQuery51))
{
	?>
			<span class="style39"><?php echo $objResult51["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult51["address_name"];?>
<br>
<span class="style40"><?php echo $objResult51["start_time"];?><?php echo '-';?><?php echo $objResult51["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL138 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_16."' and bus_code = '4' and status = 'ใช้งาน'";

$objQuery138 = mysqli_query($com1,$strSQL138) or die ("Error Query [".$strSQL138."]");
$Num_Rows138 = mysqli_num_rows($objQuery138);

while($objResult138 = mysqli_fetch_array($objQuery138))
{
	?><span class="style39"><?php echo $objResult138["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult138["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult138["description"];?>
<br>


<?php }
?>



		</td>
	
	<td align="left" bgcolor="#FFCC99" class="style35">

<?php 

$strSQL52 = "SELECT *  FROM tb_register_data where start_date ='".$date_17."' and code_bus='4'";

$objQuery52 = mysqli_query($com1,$strSQL52) or die ("Error Query [".$strSQL52."]");
$Num_Rows52 = mysqli_num_rows($objQuery52);

while($objResult52 = mysqli_fetch_array($objQuery52))
{
	?>
			<span class="style39"><?php echo $objResult52["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult52["address_name"];?>
<br>
<span class="style40"><?php echo $objResult52["start_time"];?><?php echo '-';?><?php echo $objResult52["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL139 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_17."' and bus_code = '4' and status = 'ใช้งาน'";

$objQuery139 = mysqli_query($com1,$strSQL139) or die ("Error Query [".$strSQL139."]");
$Num_Rows139 = mysqli_num_rows($objQuery139);

while($objResult139 = mysqli_fetch_array($objQuery139))
{
	?><span class="style39"><?php echo $objResult139["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult139["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult139["description"];?>
<br>


<?php }
?>

		</td>

	<td align="left" bgcolor="#FFCC99" class="style35">

	
<?php 

$strSQL53 = "SELECT *  FROM tb_register_data where start_date ='".$date_18."' and code_bus='4'";

$objQuery53 = mysqli_query($com1,$strSQL53) or die ("Error Query [".$strSQL53."]");
$Num_Rows53 = mysqli_num_rows($objQuery53);

while($objResult53 = mysqli_fetch_array($objQuery53))
{
	?>
	<span class="style39"><?php echo $objResult53["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult53["address_name"];?>
<br>
<span class="style40"><?php echo $objResult53["start_time"];?><?php echo '-';?><?php echo $objResult53["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL140 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_18."' and bus_code = '4' and status = 'ใช้งาน'";

$objQuery140 = mysqli_query($com1,$strSQL140) or die ("Error Query [".$strSQL140."]");
$Num_Rows140 = mysqli_num_rows($objQuery140);

while($objResult140 = mysqli_fetch_array($objQuery140))
{
	?><span class="style39"><?php echo $objResult140["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult140["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult140["description"];?>
<br>


<?php }
?>

		</td>

	<td align="left" bgcolor="#FFCC99" class="style35">
	<?php 

$strSQL54 = "SELECT *  FROM tb_register_data where start_date ='".$date_19."' and code_bus='4'";

$objQuery54 = mysqli_query($com1,$strSQL54) or die ("Error Query [".$strSQL54."]");
$Num_Rows54 = mysqli_num_rows($objQuery54);

while($objResult54 = mysqli_fetch_array($objQuery54))
{
	?>
		<span class="style39"><?php echo $objResult54["employee_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult54["address_name"];?>
<br>
<span class="style40"><?php echo $objResult54["start_time"];?><?php echo '-';?><?php echo $objResult54["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL141 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_19."' and bus_code = '4' and status = 'ใช้งาน'";

$objQuery141 = mysqli_query($com1,$strSQL141) or die ("Error Query [".$strSQL141."]");
$Num_Rows141 = mysqli_num_rows($objQuery141);

while($objResult141 = mysqli_fetch_array($objQuery141))
{
	?><span class="style39"><?php echo $objResult141["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult141["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult141["description"];?>
<br>


<?php }
?>

		</td>

	
	<td align="left" bgcolor="#FFCC99" class="style35">

	<?php 

$strSQL55 = "SELECT *  FROM tb_register_data where start_date ='".$date_20."' and code_bus='4'";

$objQuery55 = mysqli_query($com1,$strSQL55) or die ("Error Query [".$strSQL55."]");
$Num_Rows55 = mysqli_num_rows($objQuery55);
while($objResult55 = mysqli_fetch_array($objQuery55))
{
	?>
		<span class="style39"><?php echo $objResult55["employee_send"];?></span>
<br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult55["address_name"];?>
<br>
<span class="style40"><?php echo $objResult55["start_time"];?><?php echo '-';?><?php echo $objResult55["end_time"];?></span>
<br>


<?php }
?>
		
<?php 

$strSQL142 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_20."' and bus_code = '4' and status = 'ใช้งาน'";

$objQuery142 = mysqli_query($com1,$strSQL142) or die ("Error Query [".$strSQL142."]");
$Num_Rows142 = mysqli_num_rows($objQuery142);

while($objResult142 = mysqli_fetch_array($objQuery142))
{
	?><span class="style39"><?php echo $objResult142["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult142["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult142["description"];?>
<br>


<?php }
?>

		</td>

	<td align="left" bgcolor="#FFCC99" class="style35">

	<?php 

$strSQL56 = "SELECT *  FROM tb_register_data where start_date ='".$date_21."' and code_bus='4'";

$objQuery56 = mysqli_query($com1,$strSQL56) or die ("Error Query [".$strSQL56."]");
$Num_Rows56 = mysqli_num_rows($objQuery56);

while($objResult56 = mysqli_fetch_array($objQuery56))
{
	?>
		<span class="style39"><?php echo $objResult56["employee_send"];?></span>
<br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult56["address_name"];?>
<br>
<span class="style40"><?php echo $objResult56["start_time"];?><?php echo '-';?><?php echo $objResult56["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL143 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_21."' and bus_code = '4' and status = 'ใช้งาน'";

$objQuery143 = mysqli_query($com1,$strSQL143) or die ("Error Query [".$strSQL143."]");
$Num_Rows143 = mysqli_num_rows($objQuery143);

while($objResult143 = mysqli_fetch_array($objQuery143))
{
	?><span class="style39"><?php echo $objResult143["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult143["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult143["description"];?>
<br>


<?php }
?>

		</td>

	
		</tr>


<tr>

<td align="left" bgcolor="#FFCCFF" class="style35"><?php echo "คันที่5 6867"; ?>
</td>

<td align="left" bgcolor="#FFCCFF" class="style35">
<?php 

$strSQL36 = "SELECT *  FROM tb_register_data where start_date ='".$date_15."' and code_bus='8'";
$objQuery36 = mysqli_query($com1,$strSQL36) or die ("Error Query [".$strSQL36."]");
$Num_Rows36 = mysqli_num_rows($objQuery36);

while($objResult36 = mysqli_fetch_array($objQuery36))
{
	?><span class="style39"><?php echo $objResult36["employee_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult36["address_name"];?>
<br>
<span class="style40"><?php echo $objResult36["start_time"];?><?php echo '-';?><?php echo $objResult36["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL123 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_15."' and bus_code = '8'  and status = 'ใช้งาน'";

$objQuery123 = mysqli_query($com1,$strSQL123) or die ("Error Query [".$strSQL123."]");
$Num_Rows123 = mysqli_num_rows($objQuery123);

while($objResult123 = mysqli_fetch_array($objQuery123))
{
	?><span class="style39"><?php echo $objResult123["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult123["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult123["description"];?>
<br>


<?php }
?>




		</td>

		<td align="left" bgcolor="#FFCCFF" class="style35">

<?php 

$strSQL37 = "SELECT *  FROM tb_register_data where start_date ='".$date_16."' and code_bus='8'";

$objQuery37 = mysqli_query($com1,$strSQL37) or die ("Error Query [".$strSQL37."]");
$Num_Rows37 = mysqli_num_rows($objQuery37);

while($objResult37 = mysqli_fetch_array($objQuery37))
{
	?>
			<span class="style39"><?php echo $objResult37["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult37["address_name"];?>
<br>
<span class="style40"><?php echo $objResult37["start_time"];?><?php echo '-';?><?php echo $objResult37["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL124 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_16."' and bus_code = '8'  and status = 'ใช้งาน'";

$objQuery124 = mysqli_query($com1,$strSQL124) or die ("Error Query [".$strSQL124."]");
$Num_Rows124 = mysqli_num_rows($objQuery124);

while($objResult124 = mysqli_fetch_array($objQuery124))
{
	?><span class="style39"><?php echo $objResult124["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult124["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult124["description"];?>
<br>


<?php }
?>



		</td>
	
	<td align="left" bgcolor="#FFCCFF" class="style35">

<?php 

$strSQL38 = "SELECT *  FROM tb_register_data where start_date ='".$date_17."' and code_bus='8'";

$objQuery38 = mysqli_query($com1,$strSQL38) or die ("Error Query [".$strSQL38."]");
$Num_Rows38 = mysqli_num_rows($objQuery38);

while($objResult38 = mysqli_fetch_array($objQuery38))
{
	?>
			<span class="style39"><?php echo $objResult38["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult38["address_name"];?>
<br>
<span class="style40"><?php echo $objResult38["start_time"];?><?php echo '-';?><?php echo $objResult38["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL125 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_17."' and bus_code = '8'  and status = 'ใช้งาน'";

$objQuery125 = mysqli_query($com1,$strSQL125) or die ("Error Query [".$strSQL125."]");
$Num_Rows125 = mysqli_num_rows($objQuery125);

while($objResult125 = mysqli_fetch_array($objQuery125))
{
	?><span class="style39"><?php echo $objResult125["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult125["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult125["description"];?>
<br>


<?php }
?>


		</td>

	<td align="left" bgcolor="#FFCCFF" class="style35">

	
<?php 

$strSQL39 = "SELECT *  FROM tb_register_data where start_date ='".$date_18."' and code_bus='8'";

$objQuery39 = mysqli_query($com1,$strSQL39) or die ("Error Query [".$strSQL39."]");
$Num_Rows39 = mysqli_num_rows($objQuery39);
while($objResult39 = mysqli_fetch_array($objQuery39))
{
	?>
	<span class="style39"><?php echo $objResult39["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult39["address_name"];?>
<br>
<span class="style40"><?php echo $objResult39["start_time"];?><?php echo '-';?><?php echo $objResult39["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL126 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_18."' and bus_code = '8'  and status = 'ใช้งาน'";

$objQuery126 = mysqli_query($com1,$strSQL126) or die ("Error Query [".$strSQL126."]");
$Num_Rows126 = mysqli_num_rows($objQuery126);

while($objResult126 = mysqli_fetch_array($objQuery126))
{
	?><span class="style39"><?php echo $objResult126["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult126["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult126["description"];?>
<br>


<?php }
?>

		</td>

	<td align="left" bgcolor="#FFCCFF" class="style35">
	<?php 

$strSQL40 = "SELECT *  FROM tb_register_data where start_date ='".$date_19."' and code_bus='8'";

$objQuery40 = mysqli_query($com1,$strSQL40) or die ("Error Query [".$strSQL40."]");
$Num_Rows40 = mysqli_num_rows($objQuery40);

while($objResult40 = mysqli_fetch_array($objQuery40))
{
	?>
		<span class="style39"><?php echo $objResult40["employee_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult40["address_name"];?>
<br>
<span class="style40"><?php echo $objResult40["start_time"];?><?php echo '-';?><?php echo $objResult40["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL127 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_19."' and bus_code = '8'  and status = 'ใช้งาน'";

$objQuery127 = mysqli_query($com1,$strSQL127) or die ("Error Query [".$strSQL127."]");
$Num_Rows127 = mysqli_num_rows($objQuery127);

while($objResult127 = mysqli_fetch_array($objQuery127))
{
	?><span class="style39"><?php echo $objResult127["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult127["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult127["description"];?>
<br>


<?php }
?>


		</td>

	
	<td align="left" bgcolor="#FFCCFF" class="style35">

	<?php 

$strSQL41 = "SELECT *  FROM tb_register_data where start_date ='".$date_20."' and code_bus='8'";

$objQuery41 = mysqli_query($com1,$strSQL41) or die ("Error Query [".$strSQL41."]");
$Num_Rows41 = mysqli_num_rows($objQuery41);
while($objResult41 = mysqli_fetch_array($objQuery41))
{
	?>
		<span class="style39"><?php echo $objResult41["employee_send"];?></span>
<br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult41["address_name"];?>
<br>
<span class="style40"><?php echo $objResult41["start_time"];?><?php echo '-';?><?php echo $objResult41["end_time"];?></span>
<br>


<?php }
?>
	
<?php 

$strSQL128 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_20."' and bus_code = '8'  and status = 'ใช้งาน'";

$objQuery128 = mysqli_query($com1,$strSQL128) or die ("Error Query [".$strSQL128."]");
$Num_Rows128 = mysqli_num_rows($objQuery128);

while($objResult128 = mysqli_fetch_array($objQuery128))
{
	?><span class="style39"><?php echo $objResult128["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult128["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult128["description"];?>
<br>


<?php }
?>
	
</td>

	<td align="left" bgcolor="#FFCCFF" class="style35">

	<?php 

$strSQL42 = "SELECT *  FROM tb_register_data where start_date ='".$date_21."' and code_bus='8'";

$objQuery42 = mysqli_query($com1,$strSQL42) or die ("Error Query [".$strSQL42."]");
$Num_Rows42 = mysqli_num_rows($objQuery42);



while($objResult42 = mysqli_fetch_array($objQuery42))
{
	?>
		<span class="style39"><?php echo $objResult42["employee_send"];?></span>
<br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult42["address_name"];?>
<br>
<span class="style40"><?php echo $objResult42["start_time"];?><?php echo '-';?><?php echo $objResult42["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL129 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_21."' and bus_code = '8'  and status = 'ใช้งาน'";

$objQuery129 = mysqli_query($com1,$strSQL129) or die ("Error Query [".$strSQL129."]");
$Num_Rows129 = mysqli_num_rows($objQuery129);

while($objResult129 = mysqli_fetch_array($objQuery129))
{
	?><span class="style39"><?php echo $objResult129["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult129["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult129["description"];?>
<br>


<?php }
?>

		</td>
	
		</tr>
		

<tr>

<td align="left" bgcolor="#99CCFF" class="style35"><?php echo "ขนส่งนอก"; ?>
</td>

<td align="left" bgcolor="#99CCFF" class="style35">
<?php 

$strSQL36 = "SELECT *  FROM tb_register_data where start_date ='".$date_15."' and code_bus='9'";
$objQuery36 = mysqli_query($com1,$strSQL36) or die ("Error Query [".$strSQL36."]");
$Num_Rows36 = mysqli_num_rows($objQuery36);

while($objResult36 = mysqli_fetch_array($objQuery36))
{
	?><span class="style39"><?php echo $objResult36["employee_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult36["address_name"];?>
<br>
<span class="style40"><?php echo $objResult36["start_time"];?><?php echo '-';?><?php echo $objResult36["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL123 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_15."' and bus_code = '9'  and status = 'ใช้งาน'";

$objQuery123 = mysqli_query($com1,$strSQL123) or die ("Error Query [".$strSQL123."]");
$Num_Rows123 = mysqli_num_rows($objQuery123);

while($objResult123 = mysqli_fetch_array($objQuery123))
{
	?><span class="style39"><?php echo $objResult123["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult123["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult123["description"];?>
<br>


<?php }
?>




		</td>

		<td align="left" bgcolor="#99CCFF" class="style35">

<?php 

$strSQL37 = "SELECT *  FROM tb_register_data where start_date ='".$date_16."' and code_bus='9'";

$objQuery37 = mysqli_query($com1,$strSQL37) or die ("Error Query [".$strSQL37."]");
$Num_Rows37 = mysqli_num_rows($objQuery37);

while($objResult37 = mysqli_fetch_array($objQuery37))
{
	?>
			<span class="style39"><?php echo $objResult37["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult37["address_name"];?>
<br>
<span class="style40"><?php echo $objResult37["start_time"];?><?php echo '-';?><?php echo $objResult37["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL124 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_16."' and bus_code = '9'  and status = 'ใช้งาน'";

$objQuery124 = mysqli_query($com1,$strSQL124) or die ("Error Query [".$strSQL124."]");
$Num_Rows124 = mysqli_num_rows($objQuery124);

while($objResult124 = mysqli_fetch_array($objQuery124))
{
	?><span class="style39"><?php echo $objResult124["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult124["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult124["description"];?>
<br>


<?php }
?>



		</td>
	
	<td align="left" bgcolor="#99CCFF" class="style35">

<?php 

$strSQL38 = "SELECT *  FROM tb_register_data where start_date ='".$date_17."' and code_bus='9'";

$objQuery38 = mysqli_query($com1,$strSQL38) or die ("Error Query [".$strSQL38."]");
$Num_Rows38 = mysqli_num_rows($objQuery38);

while($objResult38 = mysqli_fetch_array($objQuery38))
{
	?>
			<span class="style39"><?php echo $objResult38["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult38["address_name"];?>
<br>
<span class="style40"><?php echo $objResult38["start_time"];?><?php echo '-';?><?php echo $objResult38["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL125 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_17."' and bus_code = '9'  and status = 'ใช้งาน'";

$objQuery125 = mysqli_query($com1,$strSQL125) or die ("Error Query [".$strSQL125."]");
$Num_Rows125 = mysqli_num_rows($objQuery125);

while($objResult125 = mysqli_fetch_array($objQuery125))
{
	?><span class="style39"><?php echo $objResult125["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult125["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult125["description"];?>
<br>


<?php }
?>


		</td>

	<td align="left" bgcolor="#99CCFF" class="style35">

	
<?php 

$strSQL39 = "SELECT *  FROM tb_register_data where start_date ='".$date_18."' and code_bus='9'";

$objQuery39 = mysqli_query($com1,$strSQL39) or die ("Error Query [".$strSQL39."]");
$Num_Rows39 = mysqli_num_rows($objQuery39);
while($objResult39 = mysqli_fetch_array($objQuery39))
{
	?>
	<span class="style39"><?php echo $objResult39["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult39["address_name"];?>
<br>
<span class="style40"><?php echo $objResult39["start_time"];?><?php echo '-';?><?php echo $objResult39["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL126 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_18."' and bus_code = '9'  and status = 'ใช้งาน'";

$objQuery126 = mysqli_query($com1,$strSQL126) or die ("Error Query [".$strSQL126."]");
$Num_Rows126 = mysqli_num_rows($objQuery126);

while($objResult126 = mysqli_fetch_array($objQuery126))
{
	?><span class="style39"><?php echo $objResult126["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult126["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult126["description"];?>
<br>


<?php }
?>

		</td>

	<td align="left" bgcolor="#99CCFF" class="style35">
	<?php 

$strSQL40 = "SELECT *  FROM tb_register_data where start_date ='".$date_19."' and code_bus='9'";

$objQuery40 = mysqli_query($com1,$strSQL40) or die ("Error Query [".$strSQL40."]");
$Num_Rows40 = mysqli_num_rows($objQuery40);

while($objResult40 = mysqli_fetch_array($objQuery40))
{
	?>
		<span class="style39"><?php echo $objResult40["employee_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult40["address_name"];?>
<br>
<span class="style40"><?php echo $objResult40["start_time"];?><?php echo '-';?><?php echo $objResult40["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL127 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_19."' and bus_code = '9'  and status = 'ใช้งาน'";

$objQuery127 = mysqli_query($com1,$strSQL127) or die ("Error Query [".$strSQL127."]");
$Num_Rows127 = mysqli_num_rows($objQuery127);

while($objResult127 = mysqli_fetch_array($objQuery127))
{
	?><span class="style39"><?php echo $objResult127["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult127["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult127["description"];?>
<br>


<?php }
?>


		</td>

	
	<td align="left" bgcolor="#99CCFF" class="style35">

	<?php 

$strSQL41 = "SELECT *  FROM tb_register_data where start_date ='".$date_20."' and code_bus='9'";

$objQuery41 = mysqli_query($com1,$strSQL41) or die ("Error Query [".$strSQL41."]");
$Num_Rows41 = mysqli_num_rows($objQuery41);
while($objResult41 = mysqli_fetch_array($objQuery41))
{
	?>
		<span class="style39"><?php echo $objResult41["employee_send"];?></span>
<br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult41["address_name"];?>
<br>
<span class="style40"><?php echo $objResult41["start_time"];?><?php echo '-';?><?php echo $objResult41["end_time"];?></span>
<br>


<?php }
?>
	
<?php 

$strSQL128 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_20."' and bus_code = '9'  and status = 'ใช้งาน'";

$objQuery128 = mysqli_query($com1,$strSQL128) or die ("Error Query [".$strSQL128."]");
$Num_Rows128 = mysqli_num_rows($objQuery128);

while($objResult128 = mysqli_fetch_array($objQuery128))
{
	?><span class="style39"><?php echo $objResult128["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult128["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult128["description"];?>
<br>


<?php }
?>
	
</td>

	<td align="left" bgcolor="#99CCFF" class="style35">

	<?php 

$strSQL42 = "SELECT *  FROM tb_register_data where start_date ='".$date_21."' and code_bus='9'";

$objQuery42 = mysqli_query($com1,$strSQL42) or die ("Error Query [".$strSQL42."]");
$Num_Rows42 = mysqli_num_rows($objQuery42);



while($objResult42 = mysqli_fetch_array($objQuery42))
{
	?>
		<span class="style39"><?php echo $objResult42["employee_send"];?></span>
<br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult42["address_name"];?>
<br>
<span class="style40"><?php echo $objResult42["start_time"];?><?php echo '-';?><?php echo $objResult42["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL129 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_21."' and bus_code = '9'  and status = 'ใช้งาน'";

$objQuery129 = mysqli_query($com1,$strSQL129) or die ("Error Query [".$strSQL129."]");
$Num_Rows129 = mysqli_num_rows($objQuery129);

while($objResult129 = mysqli_fetch_array($objQuery129))
{
	?><span class="style39"><?php echo $objResult129["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult129["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult129["description"];?>
<br>


<?php }
?>

		</td>
	
		</tr>
		

<tr>
<td width="5%" align="right"  class="style35"></td>
<td width="15%" align="right"  class="style35"><?php echo $day22 ; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 22</td>
<td width="15%" align="right"  class="style35"><?php echo $day23 ; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 23</td>
<td width="15%" align="right"  class="style35"><?php echo $day24 ; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 24</td>
<td width="15%" align="right"  class="style35"><?php echo $day25 ; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 25</td>
<td width="15%" align="right"  class="style35"><?php echo $day26 ; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 26</td>
<td width="15%" align="right"  class="style35"><?php echo $day27 ; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 27</td>
<td width="15%" align="right"  class="style35"><?php echo $day28 ; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 28</td>

</tr>

<tr>

<td align="center" bgcolor="CC99CC" class="style35"> <?php echo "คันที่ 1 8952"; ?>
		</td>


		<td align="left" bgcolor="CC99CC" class="style35">
<?php 

$strSQL29 = "SELECT *  FROM tb_register_data where start_date ='".$date_22."' and code_bus='1'";

$objQuery29 = mysqli_query($com1,$strSQL29) or die ("Error Query [".$strSQL29."]");
$Num_Rows29 = mysqli_num_rows($objQuery29);

while($objResult29 = mysqli_fetch_array($objQuery29))
{
	?><span class="style39"><?php echo $objResult29["employee_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult29["address_name"];?>
<br>
 <span class="style40"><?php echo $objResult29["start_time"];?><?php echo '-';?><?php echo $objResult29["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL144 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_22."' and bus_code = '1' and status = 'ใช้งาน'";

$objQuery144 = mysqli_query($com1,$strSQL144) or die ("Error Query [".$strSQL144."]");
$Num_Rows144 = mysqli_num_rows($objQuery144);

while($objResult144 = mysqli_fetch_array($objQuery144))
{
	?><span class="style39"><?php echo $objResult144["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult144["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult144["description"];?>
<br>


<?php }
?>



		</td>

		<td align="left" bgcolor="CC99CC" class="style35">

<?php 

$strSQL30 = "SELECT *  FROM tb_register_data where start_date ='".$date_23."' and code_bus='1'";

$objQuery30 = mysqli_query($com1,$strSQL30) or die ("Error Query [".$strSQL30."]");
$Num_Rows30 = mysqli_num_rows($objQuery30);

while($objResult30 = mysqli_fetch_array($objQuery30))
{
	?>
			<span class="style39"><?php echo $objResult30["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult30["address_name"];?>
<br>
<span class="style40"><?php echo $objResult30["start_time"];?><?php echo '-';?><?php echo $objResult30["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL145 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_23."' and bus_code = '1' and status = 'ใช้งาน'";

$objQuery145 = mysqli_query($com1,$strSQL145) or die ("Error Query [".$strSQL145."]");
$Num_Rows145 = mysqli_num_rows($objQuery145);

while($objResult145 = mysqli_fetch_array($objQuery145))
{
	?><span class="style39"><?php echo $objResult145["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult145["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult145["description"];?>
<br>


<?php }
?>



		</td>
	
	<td align="left" bgcolor="CC99CC" class="style35">

<?php 

$strSQL31 = "SELECT *  FROM tb_register_data where start_date ='".$date_24."' and code_bus='1'";

$objQuery31 = mysqli_query($com1,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);

while($objResult31 = mysqli_fetch_array($objQuery31))
{
	?>
			<span class="style39"><?php echo $objResult31["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult31["address_name"];?>
<br>
<span class="style40"><?php echo $objResult31["start_time"];?><?php echo '-';?><?php echo $objResult31["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL146 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_24."' and bus_code = '1' and status = 'ใช้งาน'";

$objQuery146 = mysqli_query($com1,$strSQL146) or die ("Error Query [".$strSQL146."]");
$Num_Rows146 = mysqli_num_rows($objQuery146);

while($objResult146 = mysqli_fetch_array($objQuery146))
{
	?><span class="style39"><?php echo $objResult146["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult146["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult146["description"];?>
<br>


<?php }
?>


		</td>

	<td align="left" bgcolor="CC99CC" class="style35">

	
<?php 

$strSQL32 = "SELECT *  FROM tb_register_data where start_date ='".$date_25."' and code_bus='1'";

$objQuery32 = mysqli_query($com1,$strSQL32) or die ("Error Query [".$strSQL32."]");
$Num_Rows32 = mysqli_num_rows($objQuery32);
while($objResult32 = mysqli_fetch_array($objQuery32))
{
	?>
	<span class="style39"><?php echo $objResult32["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult32["address_name"];?>
<br>
<span class="style40"><?php echo $objResult32["start_time"];?><?php echo '-';?><?php echo $objResult32["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL147 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_25."' and bus_code = '1' and status = 'ใช้งาน'";

$objQuery147 = mysqli_query($com1,$strSQL147) or die ("Error Query [".$strSQL147."]");
$Num_Rows147 = mysqli_num_rows($objQuery147);

while($objResult147 = mysqli_fetch_array($objQuery147))
{
	?><span class="style39"><?php echo $objResult147["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult147["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult147["description"];?>
<br>


<?php }
?>

		</td>

	<td align="left" bgcolor="CC99CC" class="style35">
	<?php 

$strSQL33 = "SELECT *  FROM tb_register_data where start_date ='".$date_26."' and code_bus='1'";

$objQuery33 = mysqli_query($com1,$strSQL33) or die ("Error Query [".$strSQL33."]");
$Num_Rows33 = mysqli_num_rows($objQuery33);

while($objResult33 = mysqli_fetch_array($objQuery33))
{
	?>
		<span class="style39"><?php echo $objResult33["employee_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult33["address_name"];?>
<br>
 <span class="style40"><?php echo $objResult33["start_time"];?><?php echo '-';?><?php echo $objResult33["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL148 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_26."' and bus_code = '1' and status = 'ใช้งาน'";

$objQuery148 = mysqli_query($com1,$strSQL148) or die ("Error Query [".$strSQL148."]");
$Num_Rows148 = mysqli_num_rows($objQuery148);

while($objResult148 = mysqli_fetch_array($objQuery148))
{
	?><span class="style39"><?php echo $objResult148["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult148["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult148["description"];?>
<br>


<?php }
?>

		</td>

	
	<td align="left" bgcolor="CC99CC" class="style35">

	<?php 

$strSQL34 = "SELECT *  FROM tb_register_data where start_date ='".$date_27."' and code_bus='1'";

$objQuery34 = mysqli_query($com1,$strSQL34) or die ("Error Query [".$strSQL34."]");
$Num_Rows34 = mysqli_num_rows($objQuery34);
while($objResult34 = mysqli_fetch_array($objQuery34))
{
	?>
		<span class="style39"><?php echo $objResult34["employee_send"];?></span>
<br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult34["address_name"];?>
<br>
 <span class="style40"><?php echo $objResult34["start_time"];?><?php echo '-';?><?php echo $objResult34["end_time"];?></span>
<br>


<?php }
?>
		
		
<?php 

$strSQL149 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_27."' and bus_code = '1' and status = 'ใช้งาน'";

$objQuery149 = mysqli_query($com1,$strSQL149) or die ("Error Query [".$strSQL149."]");
$Num_Rows149 = mysqli_num_rows($objQuery149);

while($objResult149 = mysqli_fetch_array($objQuery149))
{
	?><span class="style39"><?php echo $objResult149["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult149["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult149["description"];?>
<br>


<?php }
?>

		</td>

	<td align="left" bgcolor="CC99CC" class="style35">

	<?php 

$strSQL35 = "SELECT *  FROM tb_register_data where start_date ='".$date_28."' and code_bus='1'";

$objQuery35 = mysqli_query($com1,$strSQL35) or die ("Error Query [".$strSQL35."]");
$Num_Rows35 = mysqli_num_rows($objQuery35);
while($objResult35 = mysqli_fetch_array($objQuery35))
{
	?>
		<span class="style39"><?php echo $objResult35["employee_send"];?></span>
<br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult35["address_name"];?>
<br>
 <span class="style40"><?php echo $objResult35["start_time"];?><?php echo '-';?><?php echo $objResult35["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL150 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_28."' and bus_code = '1' and status = 'ใช้งาน'";

$objQuery150 = mysqli_query($com1,$strSQL150) or die ("Error Query [".$strSQL150."]");
$Num_Rows150 = mysqli_num_rows($objQuery150);

while($objResult150 = mysqli_fetch_array($objQuery150))
{
	?><span class="style39"><?php echo $objResult150["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult150["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult150["description"];?>
<br>


<?php }
?>

		</td>
	
	






		</tr>
	
		







<tr>

<td align="left" bgcolor="#CCFF99" class="style35"><?php echo "คันที่ 2 9322"; ?>
</td>

<td align="left" bgcolor="#CCFF99" class="style35">
<?php 

$strSQL36 = "SELECT *  FROM tb_register_data where start_date ='".$date_22."' and code_bus='2'";
$objQuery36 = mysqli_query($com1,$strSQL36) or die ("Error Query [".$strSQL36."]");
$Num_Rows36 = mysqli_num_rows($objQuery36);

while($objResult36 = mysqli_fetch_array($objQuery36))
{
	?><span class="style39"><?php echo $objResult36["employee_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult36["address_name"];?>
<br>
<span class="style40"><?php echo $objResult36["start_time"];?><?php echo '-';?><?php echo $objResult36["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL151 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_22."' and bus_code = '2' and status = 'ใช้งาน'";

$objQuery151 = mysqli_query($com1,$strSQL151) or die ("Error Query [".$strSQL151."]");
$Num_Rows151 = mysqli_num_rows($objQuery151);

while($objResult151 = mysqli_fetch_array($objQuery151))
{
	?><span class="style39"><?php echo $objResult151["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult151["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult151["description"];?>
<br>


<?php }
?>



		</td>

		<td align="left" bgcolor="#CCFF99" class="style35">

<?php 

$strSQL37 = "SELECT *  FROM tb_register_data where start_date ='".$date_23."' and code_bus='2'";

$objQuery37 = mysqli_query($com1,$strSQL37) or die ("Error Query [".$strSQL37."]");
$Num_Rows37 = mysqli_num_rows($objQuery37);

while($objResult37 = mysqli_fetch_array($objQuery37))
{
	?>
			<span class="style39"><?php echo $objResult37["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult37["address_name"];?>
<br>
<span class="style40"><?php echo $objResult37["start_time"];?><?php echo '-';?><?php echo $objResult37["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL152 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_23."' and bus_code = '2' and status = 'ใช้งาน'";

$objQuery152 = mysqli_query($com1,$strSQL152) or die ("Error Query [".$strSQL152."]");
$Num_Rows152 = mysqli_num_rows($objQuery152);

while($objResult152 = mysqli_fetch_array($objQuery152))
{
	?><span class="style39"><?php echo $objResult152["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult152["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult152["description"];?>
<br>


<?php }
?>



		</td>
	
	<td align="left" bgcolor="#CCFF99" class="style35">

<?php 

$strSQL38 = "SELECT *  FROM tb_register_data where start_date ='".$date_24."' and code_bus='2'";

$objQuery38 = mysqli_query($com1,$strSQL38) or die ("Error Query [".$strSQL38."]");
$Num_Rows38 = mysqli_num_rows($objQuery38);

while($objResult38 = mysqli_fetch_array($objQuery38))
{
	?>
			<span class="style39"><?php echo $objResult38["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult38["address_name"];?>
<br>
<span class="style40"><?php echo $objResult38["start_time"];?><?php echo '-';?><?php echo $objResult38["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL153 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_24."' and bus_code = '2' and status = 'ใช้งาน'";

$objQuery153 = mysqli_query($com1,$strSQL153) or die ("Error Query [".$strSQL153."]");
$Num_Rows153 = mysqli_num_rows($objQuery153);

while($objResult153 = mysqli_fetch_array($objQuery153))
{
	?><span class="style39"><?php echo $objResult153["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult153["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult153["description"];?>
<br>


<?php }
?>


		</td>

	<td align="left" bgcolor="#CCFF99" class="style35">

	
<?php 

$strSQL39 = "SELECT *  FROM tb_register_data where start_date ='".$date_25."' and code_bus='2'";

$objQuery39 = mysqli_query($com1,$strSQL39) or die ("Error Query [".$strSQL39."]");
$Num_Rows39 = mysqli_num_rows($objQuery39);
while($objResult39 = mysqli_fetch_array($objQuery39))
{
	?>
	<span class="style39"><?php echo $objResult39["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult39["address_name"];?>
<br>
<span class="style40"><?php echo $objResult39["start_time"];?><?php echo '-';?><?php echo $objResult39["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL154 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_25."' and bus_code = '2' and status = 'ใช้งาน'";

$objQuery154 = mysqli_query($com1,$strSQL154) or die ("Error Query [".$strSQL154."]");
$Num_Rows154 = mysqli_num_rows($objQuery154);

while($objResult154 = mysqli_fetch_array($objQuery154))
{
	?><span class="style39"><?php echo $objResult154["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult154["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult154["description"];?>
<br>


<?php }
?>

		</td>

	<td align="left" bgcolor="#CCFF99" class="style35">
	<?php 

$strSQL40 = "SELECT *  FROM tb_register_data where start_date ='".$date_26."' and code_bus='2'";

$objQuery40 = mysqli_query($com1,$strSQL40) or die ("Error Query [".$strSQL40."]");
$Num_Rows40 = mysqli_num_rows($objQuery40);

while($objResult40 = mysqli_fetch_array($objQuery40))
{
	?>
		<span class="style39"><?php echo $objResult40["employee_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult40["address_name"];?>
<br>
<span class="style40"><?php echo $objResult40["start_time"];?><?php echo '-';?><?php echo $objResult40["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL155 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_26."' and bus_code = '2' and status = 'ใช้งาน'";

$objQuery155 = mysqli_query($com1,$strSQL155) or die ("Error Query [".$strSQL155."]");
$Num_Rows155 = mysqli_num_rows($objQuery155);

while($objResult155 = mysqli_fetch_array($objQuery155))
{
	?><span class="style39"><?php echo $objResult155["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult155["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult155["description"];?>
<br>


<?php }
?>

		</td>

	
	<td align="left" bgcolor="#CCFF99" class="style35">

	<?php 

$strSQL41 = "SELECT *  FROM tb_register_data where start_date ='".$date_27."' and code_bus='2'";

$objQuery41 = mysqli_query($com1,$strSQL41) or die ("Error Query [".$strSQL41."]");
$Num_Rows41 = mysqli_num_rows($objQuery41);
while($objResult41 = mysqli_fetch_array($objQuery41))
{
	?>
		<span class="style39"><?php echo $objResult41["employee_send"];?></span>
<br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult41["address_name"];?>
<br>
<span class="style40"><?php echo $objResult41["start_time"];?><?php echo '-';?><?php echo $objResult41["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL156 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_27."' and bus_code = '2' and status = 'ใช้งาน'";

$objQuery156 = mysqli_query($com1,$strSQL156) or die ("Error Query [".$strSQL156."]");
$Num_Rows156 = mysqli_num_rows($objQuery156);

while($objResult156 = mysqli_fetch_array($objQuery156))
{
	?><span class="style39"><?php echo $objResult156["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult156["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult156["description"];?>
<br>


<?php }
?>

		
		</td>

	<td align="left" bgcolor="#CCFF99" class="style35">

	<?php 

$strSQL42 = "SELECT *  FROM tb_register_data where start_date ='".$date_28."' and code_bus='2'";

$objQuery42 = mysqli_query($com1,$strSQL42) or die ("Error Query [".$strSQL42."]");
$Num_Rows42 = mysqli_num_rows($objQuery42);



while($objResult42 = mysqli_fetch_array($objQuery42))
{
	?>
		<span class="style39"><?php echo $objResult42["employee_send"];?></span>
<br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult42["address_name"];?>
<br>
<span class="style40"><?php echo $objResult42["start_time"];?><?php echo '-';?><?php echo $objResult42["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL157 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_28."' and bus_code = '2' and status = 'ใช้งาน'";

$objQuery157 = mysqli_query($com1,$strSQL157) or die ("Error Query [".$strSQL157."]");
$Num_Rows157 = mysqli_num_rows($objQuery157);

while($objResult157 = mysqli_fetch_array($objQuery157))
{
	?><span class="style39"><?php echo $objResult157["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult157["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult157["description"];?>
<br>


<?php }
?>

		</td>
	
		</tr>
		

<tr>

<td align="left" bgcolor="#00CCCC" class="style35"><?php echo "คันที่ 3 5644"; ?>
</td>

<td align="left" bgcolor="#00CCCC" class="style35">
<?php 

$strSQL43 = "SELECT *  FROM tb_register_data where start_date ='".$date_22."' and code_bus='3'";

$objQuery43 = mysqli_query($com1,$strSQL43) or die ("Error Query [".$strSQL43."]");
$Num_Rows43 = mysqli_num_rows($objQuery43);

while($objResult43 = mysqli_fetch_array($objQuery43))
{
	?><span class="style39"><?php echo $objResult43["employee_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult43["address_name"];?>
<br>
<span class="style40"><?php echo $objResult43["start_time"];?><?php echo '-';?><?php echo $objResult43["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL158 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_22."' and bus_code = '3' and status = 'ใช้งาน'";

$objQuery158 = mysqli_query($com1,$strSQL158) or die ("Error Query [".$strSQL158."]");
$Num_Rows158 = mysqli_num_rows($objQuery158);

while($objResult158 = mysqli_fetch_array($objQuery158))
{
	?><span class="style39"><?php echo $objResult158["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult158["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult158["description"];?>
<br>


<?php }
?>



		</td>

		<td align="left" bgcolor="#00CCCC" class="style35">

<?php 

$strSQL44 = "SELECT *  FROM tb_register_data where start_date ='".$date_23."' and code_bus='3'";

$objQuery44 = mysqli_query($com1,$strSQL44) or die ("Error Query [".$strSQL44."]");
$Num_Rows44 = mysqli_num_rows($objQuery44);

while($objResult44 = mysqli_fetch_array($objQuery44))
{
	?>
			<span class="style39"><?php echo $objResult44["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult44["address_name"];?>
<br>
<span class="style40"><?php echo $objResult44["start_time"];?><?php echo '-';?><?php echo $objResult44["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL159 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_23."' and bus_code = '3' and status = 'ใช้งาน'";

$objQuery159 = mysqli_query($com1,$strSQL159) or die ("Error Query [".$strSQL159."]");
$Num_Rows159 = mysqli_num_rows($objQuery159);

while($objResult159 = mysqli_fetch_array($objQuery159))
{
	?><span class="style39"><?php echo $objResult159["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult159["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult159["description"];?>
<br>


<?php }
?>



		</td>
	
	<td align="left" bgcolor="#00CCCC" class="style35">

<?php 

$strSQL45 = "SELECT *  FROM tb_register_data where start_date ='".$date_24."' and code_bus='3'";

$objQuery45 = mysqli_query($com1,$strSQL45) or die ("Error Query [".$strSQL45."]");
$Num_Rows45 = mysqli_num_rows($objQuery45);

while($objResult45 = mysqli_fetch_array($objQuery45))
{
	?>
			<span class="style39"><?php echo $objResult45["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult45["address_name"];?>
<br>
<span class="style40"><?php echo $objResult45["start_time"];?><?php echo '-';?><?php echo $objResult45["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL160 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_24."' and bus_code = '3' and status = 'ใช้งาน'";

$objQuery160 = mysqli_query($com1,$strSQL160) or die ("Error Query [".$strSQL160."]");
$Num_Rows160 = mysqli_num_rows($objQuery160);

while($objResult160 = mysqli_fetch_array($objQuery160))
{
	?><span class="style39"><?php echo $objResult160["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult160["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult160["description"];?>
<br>


<?php }
?>

		</td>

	<td align="left" bgcolor="#00CCCC" class="style35">

	
<?php 

$strSQL46 = "SELECT *  FROM tb_register_data where start_date ='".$date_25."' and code_bus='3'";

$objQuery46 = mysqli_query($com1,$strSQL46) or die ("Error Query [".$strSQL46."]");
$Num_Rows46 = mysqli_num_rows($objQuery46);




while($objResult46 = mysqli_fetch_array($objQuery46))
{
	?>
	<span class="style39"><?php echo $objResult46["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult46["address_name"];?>
<br>
<span class="style40"><?php echo $objResult46["start_time"];?><?php echo '-';?><?php echo $objResult46["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL161 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_25."' and bus_code = '3' and status = 'ใช้งาน'";

$objQuery161 = mysqli_query($com1,$strSQL161) or die ("Error Query [".$strSQL161."]");
$Num_Rows161 = mysqli_num_rows($objQuery161);

while($objResult161 = mysqli_fetch_array($objQuery161))
{
	?><span class="style39"><?php echo $objResult161["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult161["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult161["description"];?>
<br>


<?php }
?>

		</td>

	<td align="left" bgcolor="#00CCCC" class="style35">
	<?php 

$strSQL47 = "SELECT *  FROM tb_register_data where start_date ='".$date_26."' and code_bus='3'";

$objQuery47 = mysqli_query($com1,$strSQL47) or die ("Error Query [".$strSQL47."]");
$Num_Rows47 = mysqli_num_rows($objQuery47);

while($objResult47 = mysqli_fetch_array($objQuery47))
{
	?>
		<span class="style39"><?php echo $objResult47["employee_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult47["address_name"];?>
<br>
<span class="style40"><?php echo $objResult47["start_time"];?><?php echo '-';?><?php echo $objResult47["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL162 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_26."' and bus_code = '3' and status = 'ใช้งาน'";

$objQuery162 = mysqli_query($com1,$strSQL162) or die ("Error Query [".$strSQL162."]");
$Num_Rows162 = mysqli_num_rows($objQuery162);

while($objResult162 = mysqli_fetch_array($objQuery162))
{
	?><span class="style39"><?php echo $objResult162["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult162["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult162["description"];?>
<br>


<?php }
?>

		</td>

	
	<td align="left" bgcolor="#00CCCC" class="style35">

	<?php 

$strSQL48 = "SELECT *  FROM tb_register_data where start_date ='".$date_27."' and code_bus='3'";

$objQuery48 = mysqli_query($com1,$strSQL48) or die ("Error Query [".$strSQL48."]");
$Num_Rows48 = mysqli_num_rows($objQuery48);
while($objResult48 = mysqli_fetch_array($objQuery48))
{
	?>
		<span class="style39"><?php echo $objResult48["employee_send"];?></span>
<br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult48["address_name"];?>
<br>
<span class="style40"><?php echo $objResult48["start_time"];?><?php echo '-';?><?php echo $objResult48["end_time"];?></span>
<br>


<?php }
?>
		
<?php 

$strSQL163 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_27."' and bus_code = '3' and status = 'ใช้งาน'";

$objQuery163 = mysqli_query($com1,$strSQL163) or die ("Error Query [".$strSQL163."]");
$Num_Rows163 = mysqli_num_rows($objQuery163);

while($objResult163 = mysqli_fetch_array($objQuery163))
{
	?><span class="style39"><?php echo $objResult163["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult163["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult163["description"];?>
<br>


<?php }
?>

		</td>

	<td align="left" bgcolor="#00CCCC" class="style35">

	<?php 

$strSQL49 = "SELECT *  FROM tb_register_data where start_date ='".$date_28."' and code_bus='3'";

$objQuery49 = mysqli_query($com1,$strSQL49) or die ("Error Query [".$strSQL49."]");
$Num_Rows49 = mysqli_num_rows($objQuery49);



while($objResult49 = mysqli_fetch_array($objQuery49))
{
	?>
		<span class="style39"><?php echo $objResult49["employee_send"];?></span>
<br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult49["address_name"];?>
<br>
<span class="style40"><?php echo $objResult49["start_time"];?><?php echo '-';?><?php echo $objResult49["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL164 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_28."' and bus_code = '3' and status = 'ใช้งาน'";

$objQuery164 = mysqli_query($com1,$strSQL164) or die ("Error Query [".$strSQL164."]");
$Num_Rows164 = mysqli_num_rows($objQuery164);

while($objResult164 = mysqli_fetch_array($objQuery164))
{
	?><span class="style39"><?php echo $objResult164["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult164["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult164["description"];?>
<br>


<?php }
?>

		</td>
	
		</tr>
		
<tr>
<td align="left" bgcolor="#FFCC99" class="style35"><?php echo "คันที่ 4 1112"; ?>

</td>

<td align="left" bgcolor="#FFCC99" class="style35">
<?php 

$strSQL50 = "SELECT *  FROM tb_register_data where start_date ='".$date_22."' and code_bus='4'";

$objQuery50 = mysqli_query($com1,$strSQL50) or die ("Error Query [".$strSQL50."]");
$Num_Rows50 = mysqli_num_rows($objQuery50);

while($objResult50 = mysqli_fetch_array($objQuery50))
{
	?><span class="style39"><?php echo $objResult50["employee_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult50["address_name"];?>
<br>
<span class="style40"><?php echo $objResult50["start_time"];?><?php echo '-';?><?php echo $objResult50["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL165 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_22."' and bus_code = '4' and status = 'ใช้งาน'";

$objQuery165 = mysqli_query($com1,$strSQL165) or die ("Error Query [".$strSQL165."]");
$Num_Rows165 = mysqli_num_rows($objQuery165);

while($objResult165 = mysqli_fetch_array($objQuery165))
{
	?><span class="style39"><?php echo $objResult165["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult165["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult165["description"];?>
<br>


<?php }
?>



		</td>

		<td align="left" bgcolor="#FFCC99" class="style35">

<?php 

$strSQL51 = "SELECT *  FROM tb_register_data where start_date ='".$date_23."' and code_bus='4'";

$objQuery51 = mysqli_query($com1,$strSQL51) or die ("Error Query [".$strSQL51."]");
$Num_Rows51 = mysqli_num_rows($objQuery51);

while($objResult51 = mysqli_fetch_array($objQuery51))
{
	?>
			<span class="style39"><?php echo $objResult51["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult51["address_name"];?>
<br>
<span class="style40"><?php echo $objResult51["start_time"];?><?php echo '-';?><?php echo $objResult51["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL166 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_23."' and bus_code = '4' and status = 'ใช้งาน'";

$objQuery166 = mysqli_query($com1,$strSQL166) or die ("Error Query [".$strSQL166."]");
$Num_Rows166 = mysqli_num_rows($objQuery166);

while($objResult166 = mysqli_fetch_array($objQuery166))
{
	?><span class="style39"><?php echo $objResult166["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult166["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult166["description"];?>
<br>


<?php }
?>



		</td>
	
	<td align="left" bgcolor="#FFCC99" class="style35">

<?php 

$strSQL52 = "SELECT *  FROM tb_register_data where start_date ='".$date_24."' and code_bus='4'";

$objQuery52 = mysqli_query($com1,$strSQL52) or die ("Error Query [".$strSQL52."]");
$Num_Rows52 = mysqli_num_rows($objQuery52);

while($objResult52 = mysqli_fetch_array($objQuery52))
{
	?>
			<span class="style39"><?php echo $objResult52["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult52["address_name"];?>
<br>
<span class="style40"><?php echo $objResult52["start_time"];?><?php echo '-';?><?php echo $objResult52["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL167 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_24."' and bus_code = '4' and status = 'ใช้งาน'";

$objQuery167 = mysqli_query($com1,$strSQL167) or die ("Error Query [".$strSQL167."]");
$Num_Rows167 = mysqli_num_rows($objQuery167);

while($objResult167 = mysqli_fetch_array($objQuery167))
{
	?><span class="style39"><?php echo $objResult167["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult167["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult167["description"];?>
<br>


<?php }
?>

		</td>

	<td align="left" bgcolor="#FFCC99" class="style35">

	
<?php 

$strSQL53 = "SELECT *  FROM tb_register_data where start_date ='".$date_25."' and code_bus='4'";

$objQuery53 = mysqli_query($com1,$strSQL53) or die ("Error Query [".$strSQL53."]");
$Num_Rows53 = mysqli_num_rows($objQuery53);

while($objResult53 = mysqli_fetch_array($objQuery53))
{
	?>
	<span class="style39"><?php echo $objResult53["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult53["address_name"];?>
<br>
<span class="style40"><?php echo $objResult53["start_time"];?><?php echo '-';?><?php echo $objResult53["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL168 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_25."' and bus_code = '4' and status = 'ใช้งาน'";

$objQuery168 = mysqli_query($com1,$strSQL168) or die ("Error Query [".$strSQL168."]");
$Num_Rows168 = mysqli_num_rows($objQuery168);

while($objResult168 = mysqli_fetch_array($objQuery168))
{
	?><span class="style39"><?php echo $objResult168["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult168["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult168["description"];?>
<br>


<?php }
?>

		</td>

	<td align="left" bgcolor="#FFCC99" class="style35">
	<?php 

$strSQL54 = "SELECT *  FROM tb_register_data where start_date ='".$date_26."' and code_bus='4'";

$objQuery54 = mysqli_query($com1,$strSQL54) or die ("Error Query [".$strSQL54."]");
$Num_Rows54 = mysqli_num_rows($objQuery54);

while($objResult54 = mysqli_fetch_array($objQuery54))
{
	?>
		<span class="style39"><?php echo $objResult54["employee_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult54["address_name"];?>
<br>
<span class="style40"><?php echo $objResult54["start_time"];?><?php echo '-';?><?php echo $objResult54["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL169 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_26."' and bus_code = '4' and status = 'ใช้งาน'";

$objQuery169 = mysqli_query($com1,$strSQL169) or die ("Error Query [".$strSQL169."]");
$Num_Rows169 = mysqli_num_rows($objQuery169);

while($objResult169 = mysqli_fetch_array($objQuery169))
{
	?><span class="style39"><?php echo $objResult169["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult169["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult169["description"];?>
<br>


<?php }
?>

		</td>

	
	<td align="left" bgcolor="#FFCC99" class="style35">

	<?php 

$strSQL55 = "SELECT *  FROM tb_register_data where start_date ='".$date_27."' and code_bus='4'";

$objQuery55 = mysqli_query($com1,$strSQL55) or die ("Error Query [".$strSQL55."]");
$Num_Rows55 = mysqli_num_rows($objQuery55);
while($objResult55 = mysqli_fetch_array($objQuery55))
{
	?>
		<span class="style39"><?php echo $objResult55["employee_send"];?></span>
<br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult55["address_name"];?>
<br>
<span class="style40"><?php echo $objResult55["start_time"];?><?php echo '-';?><?php echo $objResult55["end_time"];?></span>
<br>


<?php }
?>
	<?php 

$strSQL170 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_27."' and bus_code = '4' and status = 'ใช้งาน'";

$objQuery170 = mysqli_query($com1,$strSQL170) or die ("Error Query [".$strSQL170."]");
$Num_Rows170 = mysqli_num_rows($objQuery170);

while($objResult170 = mysqli_fetch_array($objQuery170))
{
	?><span class="style39"><?php echo $objResult170["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult170["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult170["description"];?>
<br>


<?php }
?>

	</td>

	<td align="left" bgcolor="#FFCC99" class="style35">

	<?php 

$strSQL56 = "SELECT *  FROM tb_register_data where start_date ='".$date_28."' and code_bus='4'";

$objQuery56 = mysqli_query($com1,$strSQL56) or die ("Error Query [".$strSQL56."]");
$Num_Rows56 = mysqli_num_rows($objQuery56);

while($objResult56 = mysqli_fetch_array($objQuery56))
{
	?>
		<span class="style39"><?php echo $objResult56["employee_send"];?></span>
<br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult56["address_name"];?>
<br>
<span class="style40"><?php echo $objResult56["start_time"];?><?php echo '-';?><?php echo $objResult56["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL171 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_28."' and bus_code = '4' and status = 'ใช้งาน'";

$objQuery171 = mysqli_query($com1,$strSQL171) or die ("Error Query [".$strSQL171."]");
$Num_Rows171 = mysqli_num_rows($objQuery171);

while($objResult171 = mysqli_fetch_array($objQuery171))
{
	?><span class="style39"><?php echo $objResult171["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult171["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult171["description"];?>
<br>


<?php }
?>

		</td>

	
		</tr>
	
<tr>

<td align="center" bgcolor="#FFCCFF" class="style35"> <?php echo "คันที่5 6867"; ?>
		</td>


		<td align="left" bgcolor="#FFCCFF" class="style35">
<?php 

$strSQL29 = "SELECT *  FROM tb_register_data where start_date ='".$date_22."' and code_bus='8'";

$objQuery29 = mysqli_query($com1,$strSQL29) or die ("Error Query [".$strSQL29."]");
$Num_Rows29 = mysqli_num_rows($objQuery29);

while($objResult29 = mysqli_fetch_array($objQuery29))
{
	?><span class="style39"><?php echo $objResult29["employee_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult29["address_name"];?>
<br>
 <span class="style40"><?php echo $objResult29["start_time"];?><?php echo '-';?><?php echo $objResult29["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL144 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_22."' and bus_code = '8' and status = 'ใช้งาน'";

$objQuery144 = mysqli_query($com1,$strSQL144) or die ("Error Query [".$strSQL144."]");
$Num_Rows144 = mysqli_num_rows($objQuery144);

while($objResult144 = mysqli_fetch_array($objQuery144))
{
	?><span class="style39"><?php echo $objResult144["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult144["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult144["description"];?>
<br>


<?php }
?>



		</td>

		<td align="left" bgcolor="#FFCCFF" class="style35">

<?php 

$strSQL30 = "SELECT *  FROM tb_register_data where start_date ='".$date_23."' and code_bus='8'";

$objQuery30 = mysqli_query($com1,$strSQL30) or die ("Error Query [".$strSQL30."]");
$Num_Rows30 = mysqli_num_rows($objQuery30);

while($objResult30 = mysqli_fetch_array($objQuery30))
{
	?>
			<span class="style39"><?php echo $objResult30["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult30["address_name"];?>
<br>
<span class="style40"><?php echo $objResult30["start_time"];?><?php echo '-';?><?php echo $objResult30["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL145 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_23."' and bus_code = '8' and status = 'ใช้งาน'";

$objQuery145 = mysqli_query($com1,$strSQL145) or die ("Error Query [".$strSQL145."]");
$Num_Rows145 = mysqli_num_rows($objQuery145);

while($objResult145 = mysqli_fetch_array($objQuery145))
{
	?><span class="style39"><?php echo $objResult145["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult145["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult145["description"];?>
<br>


<?php }
?>



		</td>
	
	<td align="left" bgcolor="#FFCCFF" class="style35">

<?php 

$strSQL31 = "SELECT *  FROM tb_register_data where start_date ='".$date_24."' and code_bus='8'";

$objQuery31 = mysqli_query($com1,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);

while($objResult31 = mysqli_fetch_array($objQuery31))
{
	?>
			<span class="style39"><?php echo $objResult31["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult31["address_name"];?>
<br>
<span class="style40"><?php echo $objResult31["start_time"];?><?php echo '-';?><?php echo $objResult31["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL146 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_24."' and bus_code = '8' and status = 'ใช้งาน'";

$objQuery146 = mysqli_query($com1,$strSQL146) or die ("Error Query [".$strSQL146."]");
$Num_Rows146 = mysqli_num_rows($objQuery146);

while($objResult146 = mysqli_fetch_array($objQuery146))
{
	?><span class="style39"><?php echo $objResult146["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult146["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult146["description"];?>
<br>


<?php }
?>


		</td>

	<td align="left" bgcolor="#FFCCFF" class="style35">

	
<?php 

$strSQL32 = "SELECT *  FROM tb_register_data where start_date ='".$date_25."' and code_bus='8'";

$objQuery32 = mysqli_query($com1,$strSQL32) or die ("Error Query [".$strSQL32."]");
$Num_Rows32 = mysqli_num_rows($objQuery32);
while($objResult32 = mysqli_fetch_array($objQuery32))
{
	?>
	<span class="style39"><?php echo $objResult32["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult32["address_name"];?>
<br>
<span class="style40"><?php echo $objResult32["start_time"];?><?php echo '-';?><?php echo $objResult32["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL147 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_25."' and bus_code = '8' and status = 'ใช้งาน'";

$objQuery147 = mysqli_query($com1,$strSQL147) or die ("Error Query [".$strSQL147."]");
$Num_Rows147 = mysqli_num_rows($objQuery147);

while($objResult147 = mysqli_fetch_array($objQuery147))
{
	?><span class="style39"><?php echo $objResult147["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult147["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult147["description"];?>
<br>


<?php }
?>

		</td>

	<td align="left" bgcolor="#FFCCFF" class="style35">
	<?php 

$strSQL33 = "SELECT *  FROM tb_register_data where start_date ='".$date_26."' and code_bus='8'";

$objQuery33 = mysqli_query($com1,$strSQL33) or die ("Error Query [".$strSQL33."]");
$Num_Rows33 = mysqli_num_rows($objQuery33);

while($objResult33 = mysqli_fetch_array($objQuery33))
{
	?>
		<span class="style39"><?php echo $objResult33["employee_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult33["address_name"];?>
<br>
 <span class="style40"><?php echo $objResult33["start_time"];?><?php echo '-';?><?php echo $objResult33["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL148 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_26."' and bus_code = '8' and status = 'ใช้งาน'";

$objQuery148 = mysqli_query($com1,$strSQL148) or die ("Error Query [".$strSQL148."]");
$Num_Rows148 = mysqli_num_rows($objQuery148);

while($objResult148 = mysqli_fetch_array($objQuery148))
{
	?><span class="style39"><?php echo $objResult148["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult148["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult148["description"];?>
<br>


<?php }
?>

		</td>

	
	<td align="left" bgcolor="#FFCCFF" class="style35">

	<?php 

$strSQL34 = "SELECT *  FROM tb_register_data where start_date ='".$date_27."' and code_bus='8'";

$objQuery34 = mysqli_query($com1,$strSQL34) or die ("Error Query [".$strSQL34."]");
$Num_Rows34 = mysqli_num_rows($objQuery34);
while($objResult34 = mysqli_fetch_array($objQuery34))
{
	?>
		<span class="style39"><?php echo $objResult34["employee_send"];?></span>
<br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult34["address_name"];?>
<br>
 <span class="style40"><?php echo $objResult34["start_time"];?><?php echo '-';?><?php echo $objResult34["end_time"];?></span>
<br>


<?php }
?>
		
		
<?php 

$strSQL149 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_27."' and bus_code = '8' and status = 'ใช้งาน'";

$objQuery149 = mysqli_query($com1,$strSQL149) or die ("Error Query [".$strSQL149."]");
$Num_Rows149 = mysqli_num_rows($objQuery149);

while($objResult149 = mysqli_fetch_array($objQuery149))
{
	?><span class="style39"><?php echo $objResult149["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult149["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult149["description"];?>
<br>


<?php }
?>

		</td>

	<td align="left" bgcolor="#FFCCFF" class="style35">

	<?php 

$strSQL35 = "SELECT *  FROM tb_register_data where start_date ='".$date_28."' and code_bus='8'";

$objQuery35 = mysqli_query($com1,$strSQL35) or die ("Error Query [".$strSQL35."]");
$Num_Rows35 = mysqli_num_rows($objQuery35);
while($objResult35 = mysqli_fetch_array($objQuery35))
{
	?>
		<span class="style39"><?php echo $objResult35["employee_send"];?></span>
<br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult35["address_name"];?>
<br>
 <span class="style40"><?php echo $objResult35["start_time"];?><?php echo '-';?><?php echo $objResult35["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL150 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_28."' and bus_code = '8' and status = 'ใช้งาน'";

$objQuery150 = mysqli_query($com1,$strSQL150) or die ("Error Query [".$strSQL150."]");
$Num_Rows150 = mysqli_num_rows($objQuery150);

while($objResult150 = mysqli_fetch_array($objQuery150))
{
	?><span class="style39"><?php echo $objResult150["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult150["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult150["description"];?>
<br>


<?php }
?>

		</td>
	
		</tr>
		
<tr>

<td align="center" bgcolor="#99CCFF" class="style35"> <?php echo "ขนส่งนอก"; ?>
		</td>


		<td align="left" bgcolor="#99CCFF" class="style35">
<?php 

$strSQL29 = "SELECT *  FROM tb_register_data where start_date ='".$date_22."' and code_bus='9'";

$objQuery29 = mysqli_query($com1,$strSQL29) or die ("Error Query [".$strSQL29."]");
$Num_Rows29 = mysqli_num_rows($objQuery29);

while($objResult29 = mysqli_fetch_array($objQuery29))
{
	?><span class="style39"><?php echo $objResult29["employee_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult29["address_name"];?>
<br>
 <span class="style40"><?php echo $objResult29["start_time"];?><?php echo '-';?><?php echo $objResult29["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL144 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_22."' and bus_code = '9' and status = 'ใช้งาน'";

$objQuery144 = mysqli_query($com1,$strSQL144) or die ("Error Query [".$strSQL144."]");
$Num_Rows144 = mysqli_num_rows($objQuery144);

while($objResult144 = mysqli_fetch_array($objQuery144))
{
	?><span class="style39"><?php echo $objResult144["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult144["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult144["description"];?>
<br>


<?php }
?>



		</td>

		<td align="left" bgcolor="#99CCFF" class="style35">

<?php 

$strSQL30 = "SELECT *  FROM tb_register_data where start_date ='".$date_23."' and code_bus='9'";

$objQuery30 = mysqli_query($com1,$strSQL30) or die ("Error Query [".$strSQL30."]");
$Num_Rows30 = mysqli_num_rows($objQuery30);

while($objResult30 = mysqli_fetch_array($objQuery30))
{
	?>
			<span class="style39"><?php echo $objResult30["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult30["address_name"];?>
<br>
<span class="style40"><?php echo $objResult30["start_time"];?><?php echo '-';?><?php echo $objResult30["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL145 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_23."' and bus_code = '9' and status = 'ใช้งาน'";

$objQuery145 = mysqli_query($com1,$strSQL145) or die ("Error Query [".$strSQL145."]");
$Num_Rows145 = mysqli_num_rows($objQuery145);

while($objResult145 = mysqli_fetch_array($objQuery145))
{
	?><span class="style39"><?php echo $objResult145["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult145["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult145["description"];?>
<br>


<?php }
?>



		</td>
	
	<td align="left" bgcolor="#99CCFF" class="style35">

<?php 

$strSQL31 = "SELECT *  FROM tb_register_data where start_date ='".$date_24."' and code_bus='9'";

$objQuery31 = mysqli_query($com1,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);

while($objResult31 = mysqli_fetch_array($objQuery31))
{
	?>
			<span class="style39"><?php echo $objResult31["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult31["address_name"];?>
<br>
<span class="style40"><?php echo $objResult31["start_time"];?><?php echo '-';?><?php echo $objResult31["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL146 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_24."' and bus_code = '9' and status = 'ใช้งาน'";

$objQuery146 = mysqli_query($com1,$strSQL146) or die ("Error Query [".$strSQL146."]");
$Num_Rows146 = mysqli_num_rows($objQuery146);

while($objResult146 = mysqli_fetch_array($objQuery146))
{
	?><span class="style39"><?php echo $objResult146["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult146["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult146["description"];?>
<br>


<?php }
?>


		</td>

	<td align="left" bgcolor="#99CCFF" class="style35">

	
<?php 

$strSQL32 = "SELECT *  FROM tb_register_data where start_date ='".$date_25."' and code_bus='9'";

$objQuery32 = mysqli_query($com1,$strSQL32) or die ("Error Query [".$strSQL32."]");
$Num_Rows32 = mysqli_num_rows($objQuery32);
while($objResult32 = mysqli_fetch_array($objQuery32))
{
	?>
	<span class="style39"><?php echo $objResult32["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult32["address_name"];?>
<br>
<span class="style40"><?php echo $objResult32["start_time"];?><?php echo '-';?><?php echo $objResult32["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL147 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_25."' and bus_code = '9' and status = 'ใช้งาน'";

$objQuery147 = mysqli_query($com1,$strSQL147) or die ("Error Query [".$strSQL147."]");
$Num_Rows147 = mysqli_num_rows($objQuery147);

while($objResult147 = mysqli_fetch_array($objQuery147))
{
	?><span class="style39"><?php echo $objResult147["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult147["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult147["description"];?>
<br>


<?php }
?>

		</td>

	<td align="left" bgcolor="#99CCFF" class="style35">
	<?php 

$strSQL33 = "SELECT *  FROM tb_register_data where start_date ='".$date_26."' and code_bus='9'";

$objQuery33 = mysqli_query($com1,$strSQL33) or die ("Error Query [".$strSQL33."]");
$Num_Rows33 = mysqli_num_rows($objQuery33);

while($objResult33 = mysqli_fetch_array($objQuery33))
{
	?>
		<span class="style39"><?php echo $objResult33["employee_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult33["address_name"];?>
<br>
 <span class="style40"><?php echo $objResult33["start_time"];?><?php echo '-';?><?php echo $objResult33["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL148 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_26."' and bus_code = '9' and status = 'ใช้งาน'";

$objQuery148 = mysqli_query($com1,$strSQL148) or die ("Error Query [".$strSQL148."]");
$Num_Rows148 = mysqli_num_rows($objQuery148);

while($objResult148 = mysqli_fetch_array($objQuery148))
{
	?><span class="style39"><?php echo $objResult148["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult148["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult148["description"];?>
<br>


<?php }
?>

		</td>

	
	<td align="left" bgcolor="#99CCFF" class="style35">

	<?php 

$strSQL34 = "SELECT *  FROM tb_register_data where start_date ='".$date_27."' and code_bus='9'";

$objQuery34 = mysqli_query($com1,$strSQL34) or die ("Error Query [".$strSQL34."]");
$Num_Rows34 = mysqli_num_rows($objQuery34);
while($objResult34 = mysqli_fetch_array($objQuery34))
{
	?>
		<span class="style39"><?php echo $objResult34["employee_send"];?></span>
<br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult34["address_name"];?>
<br>
 <span class="style40"><?php echo $objResult34["start_time"];?><?php echo '-';?><?php echo $objResult34["end_time"];?></span>
<br>


<?php }
?>
		
		
<?php 

$strSQL149 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_27."' and bus_code = '9' and status = 'ใช้งาน'";

$objQuery149 = mysqli_query($com1,$strSQL149) or die ("Error Query [".$strSQL149."]");
$Num_Rows149 = mysqli_num_rows($objQuery149);

while($objResult149 = mysqli_fetch_array($objQuery149))
{
	?><span class="style39"><?php echo $objResult149["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult149["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult149["description"];?>
<br>


<?php }
?>

		</td>

	<td align="left" bgcolor="#99CCFF" class="style35">

	<?php 

$strSQL35 = "SELECT *  FROM tb_register_data where start_date ='".$date_28."' and code_bus='9'";

$objQuery35 = mysqli_query($com1,$strSQL35) or die ("Error Query [".$strSQL35."]");
$Num_Rows35 = mysqli_num_rows($objQuery35);
while($objResult35 = mysqli_fetch_array($objQuery35))
{
	?>
		<span class="style39"><?php echo $objResult35["employee_send"];?></span>
<br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult35["address_name"];?>
<br>
 <span class="style40"><?php echo $objResult35["start_time"];?><?php echo '-';?><?php echo $objResult35["end_time"];?></span>
<br>


<?php }
?>
<?php 

$strSQL150 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_28."' and bus_code = '9' and status = 'ใช้งาน'";

$objQuery150 = mysqli_query($com1,$strSQL150) or die ("Error Query [".$strSQL150."]");
$Num_Rows150 = mysqli_num_rows($objQuery150);

while($objResult150 = mysqli_fetch_array($objQuery150))
{
	?><span class="style39"><?php echo $objResult150["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult150["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult150["description"];?>
<br>


<?php }
?>

		</td>
	
	






		</tr>
		
	

<tr>
<td width="5%" align="right"  class="style35"></td>
<td width="15%" align="right"  class="style35"><?php echo $day29 ; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 29</td>
<td width="15%" align="right"  class="style35"><?php echo $day30 ; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 30</td>
<td width="15%" align="right"  class="style35"><?php echo $day31 ; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 31</td>

</tr>



<tr>

<td align="center" bgcolor="CC99CC" class="style35"> <?php echo "คันที่ 1 8952"; ?>
		</td>


		<td align="left" bgcolor="CC99CC" class="style35">
<?php 

$strSQL29 = "SELECT *  FROM tb_register_data where start_date ='".$date_29."' and code_bus='1'";

$objQuery29 = mysqli_query($com1,$strSQL29) or die ("Error Query [".$strSQL29."]");
$Num_Rows29 = mysqli_num_rows($objQuery29);

while($objResult29 = mysqli_fetch_array($objQuery29))
{
	?><span class="style39"><?php echo $objResult29["employee_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult29["address_name"];?>
<br>
 <span class="style40"><?php echo $objResult29["start_time"];?><?php echo '-';?><?php echo $objResult29["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL172 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_29."' and bus_code = '1' and status = 'ใช้งาน'";

$objQuery172 = mysqli_query($com1,$strSQL172) or die ("Error Query [".$strSQL172."]");
$Num_Rows172 = mysqli_num_rows($objQuery172);

while($objResult172 = mysqli_fetch_array($objQuery172))
{
	?><span class="style39"><?php echo $objResult172["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult172["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult172["description"];?>
<br>


<?php }
?>



		</td>

		<td align="left" bgcolor="CC99CC" class="style35">

<?php 

$strSQL30 = "SELECT *  FROM tb_register_data where start_date ='".$date_30."' and code_bus='1'";

$objQuery30 = mysqli_query($com1,$strSQL30) or die ("Error Query [".$strSQL30."]");
$Num_Rows30 = mysqli_num_rows($objQuery30);

while($objResult30 = mysqli_fetch_array($objQuery30))
{
	?>
			<span class="style39"><?php echo $objResult30["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult30["address_name"];?>
<br>
<span class="style40"><?php echo $objResult30["start_time"];?><?php echo '-';?><?php echo $objResult30["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL173 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_30."' and bus_code = '1' and status = 'ใช้งาน'";

$objQuery173 = mysqli_query($com1,$strSQL173) or die ("Error Query [".$strSQL173."]");
$Num_Rows173 = mysqli_num_rows($objQuery173);

while($objResult173 = mysqli_fetch_array($objQuery173))
{
	?><span class="style39"><?php echo $objResult173["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult173["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult173["description"];?>
<br>


<?php }
?>



		</td>
	
	<td align="left" bgcolor="CC99CC" class="style35">

<?php 

$strSQL31 = "SELECT *  FROM tb_register_data where start_date ='".$date_31."' and code_bus='1'";

$objQuery31 = mysqli_query($com1,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);

while($objResult31 = mysqli_fetch_array($objQuery31))
{
	?>
			<span class="style39"><?php echo $objResult31["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult31["address_name"];?>
<br>
<span class="style40"><?php echo $objResult31["start_time"];?><?php echo '-';?><?php echo $objResult31["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL174 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_31."' and bus_code = '1' and status = 'ใช้งาน'";

$objQuery174 = mysqli_query($com1,$strSQL174) or die ("Error Query [".$strSQL174."]");
$Num_Rows174 = mysqli_num_rows($objQuery174);

while($objResult174 = mysqli_fetch_array($objQuery174))
{
	?><span class="style39"><?php echo $objResult174["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult174["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult174["description"];?>
<br>


<?php }
?>

		</td>

	




		</tr>
	
		







<tr>

<td align="left" bgcolor="#CCFF99" class="style35"><?php echo "คันที่ 2 9322"; ?>
</td>

<td align="left" bgcolor="#CCFF99" class="style35">
<?php 

$strSQL36 = "SELECT *  FROM tb_register_data where start_date ='".$date_29."' and code_bus='2'";
$objQuery36 = mysqli_query($com1,$strSQL36) or die ("Error Query [".$strSQL36."]");
$Num_Rows36 = mysqli_num_rows($objQuery36);

while($objResult36 = mysqli_fetch_array($objQuery36))
{
	?><span class="style39"><?php echo $objResult36["employee_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult36["address_name"];?>
<br>
<span class="style40"><?php echo $objResult36["start_time"];?><?php echo '-';?><?php echo $objResult36["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL175 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_29."' and bus_code = '2' and status = 'ใช้งาน'";

$objQuery175 = mysqli_query($com1,$strSQL175) or die ("Error Query [".$strSQL175."]");
$Num_Rows175 = mysqli_num_rows($objQuery175);

while($objResult175 = mysqli_fetch_array($objQuery175))
{
	?><span class="style39"><?php echo $objResult175["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult175["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult175["description"];?>
<br>


<?php }
?>



		</td>

		<td align="left" bgcolor="#CCFF99" class="style35">

<?php 

$strSQL37 = "SELECT *  FROM tb_register_data where start_date ='".$date_30."' and code_bus='2'";

$objQuery37 = mysqli_query($com1,$strSQL37) or die ("Error Query [".$strSQL37."]");
$Num_Rows37 = mysqli_num_rows($objQuery37);

while($objResult37 = mysqli_fetch_array($objQuery37))
{
	?>
			<span class="style39"><?php echo $objResult37["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult37["address_name"];?>
<br>
<span class="style40"><?php echo $objResult37["start_time"];?><?php echo '-';?><?php echo $objResult37["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL176 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_30."' and bus_code = '2' and status = 'ใช้งาน'";

$objQuery176 = mysqli_query($com1,$strSQL176) or die ("Error Query [".$strSQL176."]");
$Num_Rows176 = mysqli_num_rows($objQuery176);

while($objResult176 = mysqli_fetch_array($objQuery176))
{
	?><span class="style39"><?php echo $objResult176["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult176["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult176["description"];?>
<br>


<?php }
?>



		</td>
	
	<td align="left" bgcolor="#CCFF99" class="style35">

<?php 

$strSQL38 = "SELECT *  FROM tb_register_data where start_date ='".$date_31."' and code_bus='2'";

$objQuery38 = mysqli_query($com1,$strSQL38) or die ("Error Query [".$strSQL38."]");
$Num_Rows38 = mysqli_num_rows($objQuery38);

while($objResult38 = mysqli_fetch_array($objQuery38))
{
	?>
			<span class="style39"><?php echo $objResult38["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult38["address_name"];?>
<br>
<span class="style40"><?php echo $objResult38["start_time"];?><?php echo '-';?><?php echo $objResult38["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL177 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_31."' and bus_code = '2' and status = 'ใช้งาน'";

$objQuery177 = mysqli_query($com1,$strSQL177) or die ("Error Query [".$strSQL177."]");
$Num_Rows177 = mysqli_num_rows($objQuery177);

while($objResult177 = mysqli_fetch_array($objQuery177))
{
	?><span class="style39"><?php echo $objResult177["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult177["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult177["description"];?>
<br>


<?php }
?>

		</td>

	
	
		</tr>
		

<tr>

<td align="left" bgcolor="#00CCCC" class="style35"><?php echo "คันที่ 3 5644"; ?>
</td>

<td align="left" bgcolor="#00CCCC" class="style35">
<?php 

$strSQL43 = "SELECT *  FROM tb_register_data where start_date ='".$date_29."' and code_bus='3'";

$objQuery43 = mysqli_query($com1,$strSQL43) or die ("Error Query [".$strSQL43."]");
$Num_Rows43 = mysqli_num_rows($objQuery43);

while($objResult43 = mysqli_fetch_array($objQuery43))
{
	?><span class="style39"><?php echo $objResult43["employee_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult43["address_name"];?>
<br>
<span class="style40"><?php echo $objResult43["start_time"];?><?php echo '-';?><?php echo $objResult43["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL178 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_29."' and bus_code = '3' and status = 'ใช้งาน'";

$objQuery178 = mysqli_query($com1,$strSQL178) or die ("Error Query [".$strSQL178."]");
$Num_Rows178 = mysqli_num_rows($objQuery178);

while($objResult178 = mysqli_fetch_array($objQuery178))
{
	?><span class="style39"><?php echo $objResult178["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult178["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult178["description"];?>
<br>


<?php }
?>



		</td>

		<td align="left" bgcolor="#00CCCC" class="style35">

<?php 

$strSQL44 = "SELECT *  FROM tb_register_data where start_date ='".$date_30."' and code_bus='3'";

$objQuery44 = mysqli_query($com1,$strSQL44) or die ("Error Query [".$strSQL44."]");
$Num_Rows44 = mysqli_num_rows($objQuery44);

while($objResult44 = mysqli_fetch_array($objQuery44))
{
	?>
			<span class="style39"><?php echo $objResult44["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult44["address_name"];?>
<br>
<span class="style40"><?php echo $objResult44["start_time"];?><?php echo '-';?><?php echo $objResult44["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL179 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_30."' and bus_code = '3' and status = 'ใช้งาน'";

$objQuery179 = mysqli_query($com1,$strSQL179) or die ("Error Query [".$strSQL179."]");
$Num_Rows179 = mysqli_num_rows($objQuery179);

while($objResult179 = mysqli_fetch_array($objQuery179))
{
	?><span class="style39"><?php echo $objResult179["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult179["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult179["description"];?>
<br>


<?php }
?>



		</td>
	
	<td align="left" bgcolor="#00CCCC" class="style35">

<?php 

$strSQL45 = "SELECT *  FROM tb_register_data where start_date ='".$date_31."' and code_bus='3'";

$objQuery45 = mysqli_query($com1,$strSQL45) or die ("Error Query [".$strSQL45."]");
$Num_Rows45 = mysqli_num_rows($objQuery45);

while($objResult45 = mysqli_fetch_array($objQuery45))
{
	?>
			<span class="style39"><?php echo $objResult45["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult45["address_name"];?>
<br>
<span class="style40"><?php echo $objResult45["start_time"];?><?php echo '-';?><?php echo $objResult45["end_time"];?></span>
<br>


<?php }
?>
 <?php 

$strSQL180 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_31."' and bus_code = '3' and status = 'ใช้งาน'";

$objQuery180 = mysqli_query($com1,$strSQL180) or die ("Error Query [".$strSQL180."]");
$Num_Rows180 = mysqli_num_rows($objQuery180);

while($objResult180 = mysqli_fetch_array($objQuery180))
{
	?><span class="style39"><?php echo $objResult180["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult180["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult180["description"];?>
<br>


<?php }
?>


		</td>

	
		</tr>
		
<tr>
<td align="left" bgcolor="#FFCC99" class="style35"><?php echo "คันที่ 4 1112"; ?>

</td>

<td align="left" bgcolor="#FFCC99" class="style35">
<?php 

$strSQL50 = "SELECT *  FROM tb_register_data where start_date ='".$date_29."' and code_bus='4'";

$objQuery50 = mysqli_query($com1,$strSQL50) or die ("Error Query [".$strSQL50."]");
$Num_Rows50 = mysqli_num_rows($objQuery50);

while($objResult50 = mysqli_fetch_array($objQuery50))
{
	?><span class="style39"><?php echo $objResult50["employee_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult50["address_name"];?>
<br>
<span class="style40"><?php echo $objResult50["start_time"];?><?php echo '-';?><?php echo $objResult50["end_time"];?></span>
<br>


<?php }
?>

 <?php 

$strSQL181 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_29."' and bus_code = '4' and status = 'ใช้งาน'";

$objQuery181 = mysqli_query($com1,$strSQL181) or die ("Error Query [".$strSQL181."]");
$Num_Rows181 = mysqli_num_rows($objQuery181);

while($objResult181 = mysqli_fetch_array($objQuery181))
{
	?><span class="style39"><?php echo $objResult181["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult181["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult181["description"];?>
<br>


<?php }
?>



		</td>

		<td align="left" bgcolor="#FFCC99" class="style35">

<?php 

$strSQL51 = "SELECT *  FROM tb_register_data where start_date ='".$date_30."' and code_bus='4'";

$objQuery51 = mysqli_query($com1,$strSQL51) or die ("Error Query [".$strSQL51."]");
$Num_Rows51 = mysqli_num_rows($objQuery51);

while($objResult51 = mysqli_fetch_array($objQuery51))
{
	?>
			<span class="style39"><?php echo $objResult51["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult51["address_name"];?>
<br>
<span class="style40"><?php echo $objResult51["start_time"];?><?php echo '-';?><?php echo $objResult51["end_time"];?></span>
<br>


<?php }
?>

 <?php 

$strSQL182 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_30."' and bus_code = '4' and status = 'ใช้งาน'";

$objQuery182 = mysqli_query($com1,$strSQL182) or die ("Error Query [".$strSQL182."]");
$Num_Rows182 = mysqli_num_rows($objQuery182);

while($objResult182 = mysqli_fetch_array($objQuery182))
{
	?><span class="style39"><?php echo $objResult182["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult182["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult182["description"];?>
<br>


<?php }
?>



		</td>
	
	<td align="left" bgcolor="#FFCC99" class="style35">

<?php 

$strSQL52 = "SELECT *  FROM tb_register_data where start_date ='".$date_31."' and code_bus='4'";

$objQuery52 = mysqli_query($com1,$strSQL52) or die ("Error Query [".$strSQL52."]");
$Num_Rows52 = mysqli_num_rows($objQuery52);

while($objResult52 = mysqli_fetch_array($objQuery52))
{
	?>
			<span class="style39"><?php echo $objResult52["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult52["address_name"];?>
<br>
<span class="style40"><?php echo $objResult52["start_time"];?><?php echo '-';?><?php echo $objResult52["end_time"];?></span>
<br>


<?php }
?>
 <?php 

$strSQL183 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_31."' and bus_code = '4' and status = 'ใช้งาน'";

$objQuery183 = mysqli_query($com1,$strSQL183) or die ("Error Query [".$strSQL183."]");
$Num_Rows183 = mysqli_num_rows($objQuery183);

while($objResult183 = mysqli_fetch_array($objQuery183))
{
	?><span class="style39"><?php echo $objResult183["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult183["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult183["description"];?>
<br>


<?php }
?>


		</td>

	
	
		</tr>


<tr>

<td align="center" bgcolor="#FFCCFF" class="style35"> <?php echo "คันที่5 6867"; ?>
		</td>


		<td align="left" bgcolor="#FFCCFF" class="style35">
<?php 

$strSQL29 = "SELECT *  FROM tb_register_data where start_date ='".$date_29."' and code_bus='8'";

$objQuery29 = mysqli_query($com1,$strSQL29) or die ("Error Query [".$strSQL29."]");
$Num_Rows29 = mysqli_num_rows($objQuery29);

while($objResult29 = mysqli_fetch_array($objQuery29))
{
	?><span class="style39"><?php echo $objResult29["employee_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult29["address_name"];?>
<br>
 <span class="style40"><?php echo $objResult29["start_time"];?><?php echo '-';?><?php echo $objResult29["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL172 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_29."' and bus_code = '8' and status = 'ใช้งาน'";

$objQuery172 = mysqli_query($com1,$strSQL172) or die ("Error Query [".$strSQL172."]");
$Num_Rows172 = mysqli_num_rows($objQuery172);

while($objResult172 = mysqli_fetch_array($objQuery172))
{
	?><span class="style39"><?php echo $objResult172["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult172["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult172["description"];?>
<br>


<?php }
?>



		</td>

		<td align="left" bgcolor="#FFCCFF" class="style35">

<?php 

$strSQL30 = "SELECT *  FROM tb_register_data where start_date ='".$date_30."' and code_bus='8'";

$objQuery30 = mysqli_query($com1,$strSQL30) or die ("Error Query [".$strSQL30."]");
$Num_Rows30 = mysqli_num_rows($objQuery30);

while($objResult30 = mysqli_fetch_array($objQuery30))
{
	?>
			<span class="style39"><?php echo $objResult30["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult30["address_name"];?>
<br>
<span class="style40"><?php echo $objResult30["start_time"];?><?php echo '-';?><?php echo $objResult30["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL173 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_30."' and bus_code = '8' and status = 'ใช้งาน'";

$objQuery173 = mysqli_query($com1,$strSQL173) or die ("Error Query [".$strSQL173."]");
$Num_Rows173 = mysqli_num_rows($objQuery173);

while($objResult173 = mysqli_fetch_array($objQuery173))
{
	?><span class="style39"><?php echo $objResult173["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult173["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult173["description"];?>
<br>


<?php }
?>



		</td>
	
	<td align="left" bgcolor="#FFCCFF" class="style35">

<?php 

$strSQL31 = "SELECT *  FROM tb_register_data where start_date ='".$date_31."' and code_bus='8'";

$objQuery31 = mysqli_query($com1,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);

while($objResult31 = mysqli_fetch_array($objQuery31))
{
	?>
			<span class="style39"><?php echo $objResult31["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult31["address_name"];?>
<br>
<span class="style40"><?php echo $objResult31["start_time"];?><?php echo '-';?><?php echo $objResult31["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL174 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_31."' and bus_code = '8' and status = 'ใช้งาน'";

$objQuery174 = mysqli_query($com1,$strSQL174) or die ("Error Query [".$strSQL174."]");
$Num_Rows174 = mysqli_num_rows($objQuery174);

while($objResult174 = mysqli_fetch_array($objQuery174))
{
	?><span class="style39"><?php echo $objResult174["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult174["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult174["description"];?>
<br>


<?php }
?>

		</td>
		</tr>


<tr>

<td align="center" bgcolor="#99CCFF" class="style35"> <?php echo "ขนส่งนอก"; ?>
		</td>


		<td align="left" bgcolor="#99CCFF" class="style35">
<?php 

$strSQL29 = "SELECT *  FROM tb_register_data where start_date ='".$date_29."' and code_bus='9'";

$objQuery29 = mysqli_query($com1,$strSQL29) or die ("Error Query [".$strSQL29."]");
$Num_Rows29 = mysqli_num_rows($objQuery29);

while($objResult29 = mysqli_fetch_array($objQuery29))
{
	?><span class="style39"><?php echo $objResult29["employee_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult29["address_name"];?>
<br>
 <span class="style40"><?php echo $objResult29["start_time"];?><?php echo '-';?><?php echo $objResult29["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL172 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_29."' and bus_code = '9' and status = 'ใช้งาน'";

$objQuery172 = mysqli_query($com1,$strSQL172) or die ("Error Query [".$strSQL172."]");
$Num_Rows172 = mysqli_num_rows($objQuery172);

while($objResult172 = mysqli_fetch_array($objQuery172))
{
	?><span class="style39"><?php echo $objResult172["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult172["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult172["description"];?>
<br>


<?php }
?>



		</td>

		<td align="left" bgcolor="#99CCFF" class="style35">

<?php 

$strSQL30 = "SELECT *  FROM tb_register_data where start_date ='".$date_30."' and code_bus='9'";

$objQuery30 = mysqli_query($com1,$strSQL30) or die ("Error Query [".$strSQL30."]");
$Num_Rows30 = mysqli_num_rows($objQuery30);

while($objResult30 = mysqli_fetch_array($objQuery30))
{
	?>
			<span class="style39"><?php echo $objResult30["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult30["address_name"];?>
<br>
<span class="style40"><?php echo $objResult30["start_time"];?><?php echo '-';?><?php echo $objResult30["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL173 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_30."' and bus_code = '9' and status = 'ใช้งาน'";

$objQuery173 = mysqli_query($com1,$strSQL173) or die ("Error Query [".$strSQL173."]");
$Num_Rows173 = mysqli_num_rows($objQuery173);

while($objResult173 = mysqli_fetch_array($objQuery173))
{
	?><span class="style39"><?php echo $objResult173["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult173["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult173["description"];?>
<br>


<?php }
?>



		</td>
	
	<td align="left" bgcolor="#99CCFF" class="style35">

<?php 

$strSQL31 = "SELECT *  FROM tb_register_data where start_date ='".$date_31."' and code_bus='9'";

$objQuery31 = mysqli_query($com1,$strSQL31) or die ("Error Query [".$strSQL31."]");
$Num_Rows31 = mysqli_num_rows($objQuery31);

while($objResult31 = mysqli_fetch_array($objQuery31))
{
	?>
			<span class="style39"><?php echo $objResult31["employee_send"];?></span><br>

	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult31["address_name"];?>
<br>
<span class="style40"><?php echo $objResult31["start_time"];?><?php echo '-';?><?php echo $objResult31["end_time"];?></span>
<br>


<?php }
?>

<?php 

$strSQL174 = "SELECT *  FROM tb_manual_cb where date_send ='".$date_31."' and bus_code = '9' and status = 'ใช้งาน'";

$objQuery174 = mysqli_query($com1,$strSQL174) or die ("Error Query [".$strSQL174."]");
$Num_Rows174 = mysqli_num_rows($objQuery174);

while($objResult174 = mysqli_fetch_array($objQuery174))
{
	?><span class="style39"><?php echo $objResult174["employee"];?></span>
	<br>
	<span class="style40"><?php echo $objResult174["time_send"];?></span>
<br>
	<span class="style40"><?php echo '**';?></span> <?php  echo $objResult174["description"];?>
<br>


<?php }
?>

		</td>
		</tr>	
	
	
</table>

<br><br>
    
</div>
     </form>
<div id="cr_bar"> <?php include "foot.php"; ?></div>		
	          

</body>
</html>