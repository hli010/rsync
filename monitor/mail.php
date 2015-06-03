#!/usr/bin/php -q

<?php 


$headcontent='<html> <head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" >
<link rel="stylesheet" type="text/css" href="./main.css" media="all"> 
<script type="text/javascript" src="./main.js"></script>
<script type="text/javascript" src="./jquery.js"></script>
<script type="text/javascript" src="./table.js"></script>
<link rel="stylesheet" type="text/css" href="./table.css" media="all">
';

require_once(dirname(__FILE__).'/lib.php');

$datetag = $_GET['date'];
$sync_succ = true;
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



$title = "Nextop-Atrenta Data Sync Monitor - $datetag";
$headcontent .= "<title>$title</title> </head> <body>"; 

$content="";

$count = 0; 
$dir = dirname(__FILE__).'/data/'.$datetag;
$log="$dir/summary.washington.txt";


if (file_exists($log)) {
	$filecontent = file($log);
	$len = count($filecontent); 

	$timestr=getFileContent($filecontent,"TIME CONSUME");
	$str = explode(":", $timestr); 
	$time = $str[1]; 

	$timestr=getFileContent2($filecontent,"START");
	$str = explode(" ", $timestr); 
	$start=$str[2]." ".$str[3]; 
	$machine = $str[5]; 

	$timestr=getFileContent2($filecontent,"END   AT:");
	$str = explode(" ", $timestr); 
	$end=$str[4]." ".$str[5]; 
	$content .= "<p></p><p align=\"center\">  START AT: <font color=blue>$start</font>
		END AT:<font color=blue> $end </font>
		TIME: <font color=blue> $time </font> 	
		MACHINE: <font color=blue> $machine </font> </p> 
		<p> </p>
		";	

	$content .= "
		<table class=\"example table-autosort table-autofilter table-autopage:1300 table-stripeclass:alternate table-page-number:t1page table-page-count:t1pages table-filtered-rowcount:t1filtercount table-rowcount:t1allcount\" style=\"margin:0 auto\"><thead> <tr>  
		<th class=\"table-sortable:numeric table-sortable table-sorted-asc\" > No </th>
		<th title=\"source directory\"  class=\"table-sortable:default table-sortable\">  source directory  </th> 
		<th title=\"dest directory\" class=\"table-sortable:default table-sortable\"> target directory </th>
		<th title=\"size\" class=\"table-sortable:default table-sortable\"> Size   </th>
		<th title=\"time\" class=\"table-sortable:default table-sortable\"> Time </th>
		<th title=\"sync log\" class=\"table-sortable:default table-sortable\"> Sync Statu </th>
		<th title=\"sync details\" class=\"table-sortable:default table-sortable\"> Log Size </th>
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
			$logname="$dir/".$destname.".".$srcname.".portland.txt";

			$content .= "<tr class=\"\">";
			$content .= "<td>  ".rtrim($str[0],":")."  </td> ";
			$content .= "<td> <a href=".getURL($log).">  $srcdir </a>  </td> ";
			$content .= "<td> <a href=".getURL($log).">  $destdir</a>  </td> ";
			$content .= "<td>  $str[5]  </td> ";
			$content .= "<td>  $str[7]  </td> ";

			if (file_exists($logname)) {
                                $fz = getFomateFileSize(filesize($logname)); 
                                $fl = escapeshellarg($logname);
                                $line=`tail -n 2 $fl`;
                                if (strpos($line, "total size is ")) {
					$content .= "<td>  <a href=".getURL($logname)."> <font color=green> PASS </font>  </a> </td> ";
                                } else {
					$content .= "<td>  <a href=".getURL($logname)."> <font color=red> FAIL </font>  </a> </td> ";
                                        $sync_succ = false; 
				}
				$content .=  "<td>  <a href=".getURL($logname)."> $fz </a> </td> ";

			} else {
				$content .=  "<td>  ---  </td> ";
				$content .= "<td>  ---  </td> ";
			}

			$content .=  "</tr>";
		}
	}
	fclose($f);

} else {
	$sync_succ = false; 
	$content .=  "<p align=center>   <font size=5 color=red> No data found on $datetag!</font>  </p>";	
}


$content .= "</table>";

#$access = "<p align=\"center\"><a href=".getURLWithDate("index.php", $datetag).">please access ".getURLWithDate("index.php", $datetag)." for detail.</a>  </p> " 

#$content .= $access; 


#add mantis check
$mantis_backup_log=$dir."/mantis.backup.txt";
$mantis_restore_log=$dir."/mantis.restore.txt";
$mantis_backup_url="http://portland.cn.atrenta.com/mantis/";
$mantis_restore_url="http://washington.cn.atrenta.com/mantis_backup/";

$content .= "<h1 align=center> Mantis Daily Standby Monitor</h1>"; 

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
	$sync_succ = false; 
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
	$sync_succ = false; 
	$content .=  "<p align=center>   <font size=5 color=red> No data found for Mediawiki's backup and restore!</font>  </p>";	
}


$content .= "<p> </p> <hr>
<div class=\"legal1\" align=\"CENTER\">Copyright (C) 2006-".date("Y")."<a href=\"http://www.atrenta.com/\">Atrenta Inc.</a>  All rights reserved. </div>
</body>
</html>"; 


if ($sync_succ) {
    $syncstatu = "PASSED";	
    $showstatu = "<font color=green>$syncstatu</font>";
} else {
    $syncstatu = "FAILED";	
    $showstatu = "<font color=red>$syncstatu</font>";
}

$title = "<h1 align=\"center\"> <a href=".getURL("index.php?date=$datetag")."> Data Sync $showstatu on $datetag. </a> </h1>"; 
$content=$headcontent.$title.$content; 
echo $content; 


$subject = "[DataSync]Data sync $syncstatu on $datetag!";

//echo $subject;
mail($to, $subject, $content, "From: $from\nMIME-Version: 1.0\nContent-Type: text/html\nContent-Disposition: inline\n");

?> 
