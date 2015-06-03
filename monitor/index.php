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
echo quick_link($datetag, "index.php");

?>

<?php


$count = 0; 
$dir = 'data/'.$datetag;
$log="$dir/summary.washington.txt";

if (file_exists($log)) {
	$content = file($log);
	$len = count($content); 

	$timestr=getFileContent($content,"TIME CONSUME");
	$str = explode(":", $timestr); 
	$time = $str[1]; 

	$timestr=getFileContent2($content,"START");
	$str = explode(" ", $timestr); 
	$start=$str[2]." ".$str[3]; 
	$machine = $str[5]; 

	$timestr=getFileContent2($content,"END   AT:");
	$str = explode(" ", $timestr); 
	$end=$str[4]." ".$str[5]; 
	echo "<p></p><p align=\"center\">  START AT: <font color=blue>$start</font>
		END AT:<font color=blue> $end </font>
		TIME: <font color=blue> $time </font> 	
		MACHINE: <font color=blue> $machine </font> </p> 
		<p> </p>
		";	

	echo "
		<table class=\"example table-autosort table-autofilter table-autopage:1300 table-stripeclass:alternate table-page-number:t1page table-page-count:t1pages table-filtered-rowcount:t1filtercount table-rowcount:t1allcount\" style=\"margin:0 auto\"><thead> <tr>  
		<th class=\"table-sortable:numeric table-sortable table-sorted-asc\" > No </th>
		<th title=\"source directory\"  class=\"table-sortable:default table-sortable\">  source directory  </th> 
		<th title=\"dest directory\" class=\"table-sortable:default table-sortable\"> target directory </th>
		<th title=\"size\" class=\"table-sortable:default table-sortable\"> Size   </th>
		<th title=\"time\" class=\"table-sortable:default table-sortable\"> Time </th>
		<th title=\"sync log\" class=\"table-sortable:default table-sortable\"> Log </th>
		<th title=\"sync details\" class=\"table-sortable:default table-sortable\"> Details </th>
		</tr>

		</thead> <tbody>
	"; 




	$f = fopen($log,"r");
	while (!feof($f)) 
	{
		$line=fgets($f);
		$str = explode(" ", $line);
		if (strcmp($str[2], "===>") == 0) {
			//sync line
			$srcdir=ltrim(rtrim($str[1], "]"),"[");
			$destdir=ltrim(rtrim($str[3], "]"),"[");
			$srcexp = explode("/", $srcdir);
			$arrcount = count($srcexp); 
			$srcname=$srcexp[$arrcount-1]; 
			$destexp=explode(":",$destdir); 
			$destname=$destexp[0];
			$logname="data/$datetag/".$destname.".".$srcname.".portland.txt";

			echo "<tr class=\"\">";
			echo "<td>  ".rtrim($str[0],":")."  </td> ";
			echo "<td> <a href=$log>  $srcdir </a>  </td> ";
			echo "<td> <a href=$log>  $destdir</a>  </td> ";
			//echo "<td>  $str[3]  </td> ";
			echo "<td>  $str[5]  </td> ";
			echo "<td>  $str[7]  </td> ";

			if (file_exists($logname)) {
                                $fz = getFomateFileSize(filesize($logname)); 
				echo "<td>  <a href=$logname> rsync log($fz) </a> </td> ";
                                $fl = escapeshellarg($logname);
                                $line=`tail -n 2 $fl`;
                                if (strpos($line, "rsync error")) {
					echo "<td>  <a href=$logname> <font color=red> rsync error</font>  </a> </td> ";
                                } else {
					echo "<td>  <a href=\"detail.php?date=$datetag\"> rsync details </a> </td> ";
				}

			} else {
				echo "<td>  ---  </td> ";
				echo "<td>  ---  </td> ";
			}

			echo "</tr>";
		}
	}
	fclose($f);

} else {
	echo "<p align=center>   <font size=5 color=red> No data found on $datetag!</font>  </p>";	
	echo "";
}





?>

</table>

<?php




#add mantis check
$dir = dirname(__FILE__).'/data/'.$datetag;
$mantis_backup_log=$dir."/mantis.backup.txt";
$mantis_restore_log=$dir."/mantis.restore.txt";
$mantis_backup_url="http://portland.cn.atrenta.com/mantis/";
$mantis_restore_url="http://washington.cn.atrenta.com/mantis_backup/";

$content = "<h1 align=center> Mantis Daily Standby Monitor</h1>";

if (file_exists($mantis_restore_log) && file_exists($mantis_backup_log)) {
        $content .= "
                <table class=\"example table-autosort table-autofilter table-autopage:1300 table-stripeclass:alternate table-page-number:t1page table-page-count:t1pages table-filtered-rowcount:t1filtercount table-rowcount:t1allcount\" style=\"margin:0 auto\"><thead> <tr>  
                <th class=\"table-sortable:numeric table-sortable table-sorted-asc\" > No </th>
                <th title=\"source directory\"  class=\"table-sortable:default table-sortable\">  source directory  </th> 
                <th title=\"dest directory\" class=\"table-sortable:default table-sortable\"> target directory </th>
                </tr>
                </thead> <tbody>
        ";

        $content .= "<tr class=\"\"> <td> 0 </td> 
        <td> <a href=$mantis_backup_url> $mantis_backup_url</a> </td>
        <td> <a href=$mantis_restore_url> $mantis_restore_url</a> </td>
        </tr>
        ";
        $content .= "<tr class=\"\"> <td> 1 </td> 
        <td> <a href=".getURL($mantis_backup_log)."> backup log </a> </td>
        <td> <a href=".getURL($mantis_restore_log)."> restore log </a> </td>
        </tr>
        ";
        $content .= "</table>";
} else  {
        $content .=  "<p align=center>   <font size=5 color=red> No data found for Mantis's backup and restore!</font>  </p>";
}



#add mediawiki check
$mediawiki_backup_log=$dir."/mediawiki.backup.txt";
$mediawiki_restore_log=$dir."/mediawiki.restore.txt";
$mediawiki_backup_url="http://portland.cn.atrenta.com/wiki/";
$mediawiki_restore_url="http://washington.cn.atrenta.com/wiki_backup/";

$content .= "<h1 align=center> MediaWiki Daily Standby Monitor</h1>";
if (file_exists($mediawiki_restore_log) && file_exists($mediawiki_backup_log)) {
        $content .= "
                <table class=\"example table-autosort table-autofilter table-autopage:1300 table-stripeclass:alternate table-page-number:t1page table-page-count:t1pages table-filtered-rowcount:t1filtercount table-rowcount:t1allcount\" style=\"margin:0 auto\"><thead> <tr>  
                <th class=\"table-sortable:numeric table-sortable table-sorted-asc\" > No </th>
                <th title=\"source directory\"  class=\"table-sortable:default table-sortable\">  source directory  </th> 
                <th title=\"dest directory\" class=\"table-sortable:default table-sortable\"> target directory </th>
                </tr>
                </thead> <tbody>
        ";

        $content .= "<tr class=\"\"> <td> 0 </td> 
        <td> <a href=$mediawiki_backup_url> $mediawiki_backup_url</a> </td>
        <td> <a href=$mediawiki_restore_url> $mediawiki_restore_url</a> </td>
        </tr>
        ";
        $content .= "<tr class=\"\"> <td> 1 </td> 
        <td> <a href=".getURL($mediawiki_backup_log)."> backup log </a> </td>
        <td> <a href=".getURL($mediawiki_restore_log)."> restore log </a> </td>
        </tr>
        ";
        $content .= "</table>";
} else  {
        $content .=  "<p align=center>   <font size=5 color=red> No data found for Mediawiki's backup and restore!</font>  </p>";     
}


echo $content;

   echo "<p align=\"center\"><a href=history_list.php?date=$datetag>view all days sync logs</a>  </p> " 

?> 

<p> </p>
<p> </p>
<p> </p>
<p> </p>

<hr>
<div class="legal1" align="CENTER">Copyright © 2006-<?php echo date("Y"); ?> <a href="http://www.atrenta.com/">Atrenta Inc.</a>  All rights reserved. </div>

</body>
</html>

