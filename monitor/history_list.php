<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" >
    <link rel="stylesheet" type="text/css" href="./main.css" media="all"> 
    <script type="text/javascript" src="./main.js"></script>
    <script type="text/javascript" src="./jquery.js"></script>
    <script type="text/javascript" src="./table.js"></script>
    <link rel="stylesheet" type="text/css" href="./table.css" media="all">

<?php
        require_once('lib.php');

        $datetag = $_GET['date'];
        $currentdate = date("Ymd");
        if (strcmp($datetag, '') == 0) {
             $datetag = $currentdate;
        }

function getFileContent($arr, $name) {
   foreach ($arr as $value) {
	if (strpos("$value", "$name")) {
	   return "$value";
	}
   }
   return "";
}

function getFileContent2($arr, $name) {
   foreach ($arr as $value) {
	if (strstr("$value", "$name") != False) {
	   return "$value";
	}
   }
   return "";
}

function readFiles($filename) {
	if (file_exists($filename)) {
	return readfile($filename);
	} else {
	 return "";
	}
}

$title = "Nextop-Atrenta Data Sync Monitor - $datetag";

?>


        <title><?php echo $title; ?></title>
    </head>
    <body>
        <h1 align="center"><a href="index.php"><?php echo $title; ?></a></h1>
<?php
      echo quick_link($datetag, "history_list.php");

?>


<table class="example table-autosort table-autofilter table-autopage:1300 table-stripeclass:alternate table-page-number:t1page table-page-count:t1pages table-filtered-rowcount:t1filtercount table-rowcount:t1allcount" style="margin:0 auto"><thead> <tr>  
<th class="table-sortable:numeric table-sortable table-sorted-asc" > No </th>
<th title="device ID" class="table-sortable:default table-sortable">  Date  </th> 
<!--
<th title="status" class="table-sortable:default table-sortable"> Summary <br>
<select onchange="Table.filter(this,this)" onclick="Table.cancelBubble(event)" class="table-autofilter">
<option selected="selected" value="">Filter: All</option>
<option value="OK">OK</option>
<option value="FAILED">FAIL</option>
</select></th>
-->

<th title="error code" class="table-sortable:default table-sortable"> Time consume </th>
<th title="error code" class="table-sortable:default table-sortable"> Start Time   </th>
<th title="error code" class="table-sortable:default table-sortable"> End Time </th>
<th title="error code" class="table-sortable:default table-sortable"> Detail </th>
</tr>

</thead> <tbody>

<?php
   
$count = 0; 
for($daterange = 0; $daterange > -30; $daterange--) {
        $thatday=getRecentDate($datetag, "$daterange day");
      	$dir = 'data/'.$thatday;
        echo "<tr class=\"\"><td> $count </td> <td> <a href=index.php?date=$thatday>$thatday </a> </td> ";

      if (file_exists($dir)) {
	$log="$dir/summary.washington.txt";
	$content = file($log);
        $len = count($content); 

        $timestr=getFileContent($content,"TIME CONSUME");
        $str = explode(":", $timestr); 
	echo "<td> <a href=$log>".$str[1]."</a>  </td> ";	
        
        $timestr=getFileContent2($content,"START");
        //echo "<p>$timestr<p>";
        $str = explode(" ", $timestr); 
	echo "<td> <a href=$log>".$str[2]." ".$str[3]."</a></td>";	

        $timestr=getFileContent2($content,"END   AT:");
        //echo "<p>$timestr<p>";
        $str = explode(" ", $timestr); 
	echo "<td> <a href=$log>".$str[4]." ".$str[5]."</a></td>";	
	echo "<td> <a href=detail.php?date=$thatday> <b> detail </b>  </a>  </td> ";	
      } else {
	echo "<td colspan=5>No data found!</td>";	
        echo "";
      }
      echo "</tr>";
      $count++;
   }
      


        ?>

</table>

 <hr>
 <div class="legal1" align="CENTER">Copyright © 2006-<?php echo date("Y"); ?> <a href="http://www.atrenta.com/">Atrenta Inc.</a>  All rights reserved. </div>

    </body>
</html>

