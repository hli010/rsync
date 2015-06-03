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
	if (strpos("$value", "$name") != False) {
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
      
echo quick_link($datetag, "detail.php");


$machine="wushi.atrenta.com";
echo "<h3> Backup Process to <font color=#0000FF> $machine </font> </h3>";
?>


<table class="example table-autosort table-autofilter table-autopage:1300 table-stripeclass:alternate table-page-number:t1page table-page-count:t1pages table-filtered-rowcount:t1filtercount table-rowcount:t1allcount" style="margin:0 auto"><thead> <tr>  
<th class="table-sortable:numeric table-sortable table-sorted-asc" > No </th>
<th title="device ID" class="table-sortable:default table-sortable">  Content  </th> 
<th title="error code" class="table-sortable:default table-sortable"> sent </th>
<th title="error code" class="table-sortable:default table-sortable"> received </th>
<th title="error code" class="table-sortable:default table-sortable"> Speed </th>
<th title="error code" class="table-sortable:default table-sortable"> Total Size </th>
<th title="error code" class="table-sortable:default table-sortable"> <i> File Size </i> </th>
</tr>

</thead> <tbody>

<?php
   

$dir = 'data/'.$datetag;
$filelist=glob("$dir/heng@$machine.*.portland.txt");
$count = 0; 
// print_r($filelist);

if (file_exists($dir)) {
   foreach ($filelist as $file) {
        $len=strlen($file);
        
        $name=substr($file, 37, -13);
	echo "<tr class=\"\"><td> $count </td>";
        echo " <td align=left> $name </td> ";
	
   	$log="$file";
        $fl = escapeshellarg($log);
        $line=`tail -n 2 $fl`;
	$arr = explode(" ", $line);

        if (strpos($line, "rsync error")) {
	   	echo "<td> <a href=$log> <font color=#FF0000> $arr[9] </font> </a></td>";	
   		echo "<td> <a href=$log> <font color=#FF0000> $arr[10] </font> </a></td>";	
	   	echo "<td> <a href=$log> <font color=#FF0000> $arr[11] </font> </a></td>";	
   		echo "<td> <a href=$log> <font color=#FF0000> $arr[12] </font> </a></td>";	
	   	echo "<td> <a href=$log> ".filesize($log)." </a></td>";	
	} else {
   		echo "<td> <a href=$log> $arr[1] </a></td>";	
   		echo "<td> <a href=$log> $arr[5] </a></td>";	
   		echo "<td> <a href=$log> $arr[8] </a></td>";	
   		echo "<td> <a href=$log> $arr[12] </a></td>";	
   		echo "<td> <a href=$log> ".filesize($log)." </a></td>";	
        }
	$count++;
   }
   echo "</tr>";
} else {
	echo "<td colspan=5>No data found!</td>";	
}

echo "</table>";

echo "<p>";
echo "<p>";

//echo "<h3> Backup Process to <font color=#0000FF> washington.cn.atrenta.com </font> </h3>";
$machine="washington.cn.atrenta.com";
echo "<h3> Backup Process to <font color=#0000FF> $machine </font> </h3>";
?>

<table class="example table-autosort table-autofilter table-autopage:1300 table-stripeclass:alternate table-page-number:t1page table-page-count:t1pages table-filtered-rowcount:t1filtercount table-rowcount:t1allcount" style="margin:0 auto"><thead> <tr>  
<th class="table-sortable:numeric table-sortable table-sorted-asc" > No </th>
<th title="device ID" class="table-sortable:default table-sortable">  Content  </th> 
<th title="error code" class="table-sortable:default table-sortable"> sent </th>
<th title="error code" class="table-sortable:default table-sortable"> received </th>
<th title="error code" class="table-sortable:default table-sortable"> Speed </th>
<th title="error code" class="table-sortable:default table-sortable"> Total Size </th>
<th title="error code" class="table-sortable:default table-sortable"> <i> File Size </i> </th>
</tr>

</thead> <tbody>

<?php


$count = 0; 
$dir = 'data/'.$datetag;
$filelist=glob("$dir/root@$machine.*.portland.txt");

if (file_exists($dir)) {
   foreach ($filelist as $file) {
        $len=strlen($file);
        $name=substr($file, 45, -13);
	echo "<tr class=\"\"><td> $count </td>";
        echo " <td align=left> $name </td> ";
	
   	$log="$file";
        $fl = escapeshellarg($log);
        $line=`tail -n 2 $fl`;
        if (strpos($line, "rsync error")) {
	   	echo "<td> <a href=$log> <font color=#FF0000> $arr[9] </font> </a></td>";	
   		echo "<td> <a href=$log> <font color=#FF0000> $arr[10] </font> </a></td>";	
	   	echo "<td> <a href=$log> <font color=#FF0000> $arr[11] </font> </a></td>";	
   		echo "<td> <a href=$log> <font color=#FF0000> $arr[12] </font> </a></td>";	
	   	echo "<td> <a href=$log> ".filesize($log)." </a></td>";	
	} else {
		$arr = explode(" ", $line);
	   	echo "<td> <a href=$log> $arr[1] </a></td>";	
   		echo "<td> <a href=$log> $arr[5] </a></td>";	
	   	echo "<td> <a href=$log> $arr[8] </a></td>";	
   		echo "<td> <a href=$log> $arr[12] </a></td>";	
	   	echo "<td> <a href=$log> ".filesize($log)." </a></td>";	
	}
        $count++;
   }
   echo "</tr>";
} else {
	echo "<td colspan=5>No data found!</td>";	
}

      

?>

</table>

 <hr>
 <div class="legal1" align="CENTER">Copyright © 2006-<?php echo date("Y"); ?> <a href="http://www.atrenta.com/">Atrenta Inc.</a>  All rights reserved. </div>

    </body>
</html>

