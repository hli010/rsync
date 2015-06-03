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

function echoQuickLink($datetag) {
    $currentdate=date("Ymd");

    echo "<p align=\"center\"><font size=1>";
    for($daterange = -5; $daterange < 5; $daterange++) {
        $thatday=getRecentDate($datetag, "$daterange day");

        if(date("Y-m-d",strtotime($thatday)) > date("Y-m-d",strtotime($currentdate))) {
            continue;
        } else {
            echo "<!-- $thatday:$currentdate -->";
        }

        $datelink = str_replace("-", "_", $thatday);
        echo "<a href=ping.php?date=$datelink>$thatday</a>&nbsp; ";
    }   

    echo "</font></p>";
}

function readFiles($filename) {
	if (file_exists($filename)) {
	return readfile($filename);
	} else {
	 return "";
	}
}

function getFileStatus($filename) {
   /*$content = file_get_contents($filename);
   $array = explode("\n", $content); 
   $len = count($array);

   #print_r($array);
   return $array[$len-4]; 
*/

   $data = file($filename);
   foreach ($data as $line) {
	if (strpos($line, "packets transmitted") > -1){
	 if (strpos($line, ", 0% packet loss") > -1) {
	 	return "<font color=\"#008900\">$line </font>";
	 } else {
	 	return "<font color=\"#890000\">$line </font>";
	 }
	}
   }  

}

$title = "Nextop Machines Status Monitor - $datetag";

        ?>


        <title><?php echo $title; ?></title>
    </head>
    <body>
        <h1 align="center"><a href="index.php"><?php echo $title; ?></a></h1>
        <?php
      echoQuickLink($datetag);

?>


<table class="example table-autosort table-autofilter table-autopage:1300 table-stripeclass:alternate table-page-number:t1page table-page-count:t1pages table-filtered-rowcount:t1filtercount table-rowcount:t1allcount" style="margin:0 auto"><thead> <tr>  
<th class="table-sortable:numeric table-sortable table-sorted-asc" > No </th>
<!--
<select onchange="Table.filter(this,this)" onclick="Table.cancelBubble(event)" class="table-autofilter">
<option selected="selected" value="">Filter: All</option>
<option value="ROUTE">ROUTE</option>
<option value="SWITCHER">SWITCHER</option>
<option value="COMPUTER">COMPUTER</option>
<option value="FIREWALL">FIREWALL</option>
</select>
-->
<th title="device ID" class="table-sortable:default table-sortable">  Date  </th> 
<!--
<th title="status" class="table-sortable:default table-sortable"> Status <br>
<select onchange="Table.filter(this,this)" onclick="Table.cancelBubble(event)" class="table-autofilter">
<option selected="selected" value="">Filter: All</option>
<option value="OK">OK</option>
<option value="FAILED">FAIL</option>
</select></th>
-->
<th title="error code" class="table-sortable:default table-sortable"> failed machine </th>
</tr>

</thead> <tbody>

<?php
   
$count = 0; 
//for($daterange = 0; $daterange > -30; $daterange--) {
//        $thatday=getRecentDate($datetag, "$daterange day");
      	$dir = $datetag;

	if (file_exists($dir)) {
        $machinelist=glob("$dir/*.nextop");
        //print_r($machinelist);
        foreach ($machinelist as $machine) {
            echo "<tr class=\"\"><td> $count </td> <td> $machine </td> ";
	    // $sshlog="$dir/ssh.txt";
	    // $difflog="$dir/ssh_diff.txt";
	    $faillog="$machine/ping.txt";
            /*
            $name="ssh log";
            
            $failed = file("$faillog");
            if (count($failed) == 0 ) {
	    	echo "<td> <font color=#\'00FF00\">OK</font> </td> ";	
            } else {
	    	echo "<td> <font color=\"#FF0000\">FAIL</font></td> ";	
            }
	    */

            // print_r($failed);
	    echo "<td> <a href=$faillog> ";
      	    echo getFileStatus($faillog);
            echo " </a></td> ";	
      	    echo "</tr>";
      	    $count++;
	}
     } else {
	echo "<tr> <td colspan=3>No data found!</td> </tr>";	
      }

        ?>

</table>

 <hr>
 <div class="legal1" align="CENTER">Copyright © 2006-<?php echo date("Y"); ?> <a href="http://www.nextopsoftware.com/">NextOp Software. Inc.</a>  All rights reserved. </div>

    </body>
</html>

