<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html><head>    <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
<link rel="stylesheet" type="text/css" href="./main.css" media="all"> 
<script type="text/javascript" src="./main.js"></script>
<script type="text/javascript" src="./jquery.js"></script>
<script type="text/javascript" src="./table.js"></script>
<link rel="stylesheet" type="text/css" href="./table.css" media="all"> 
<?php

require_once("lib.php");

$title = "Atrenta-NextOp Machine Status";
?>
    </head><body>
    <?php

    echo "<h1> $title </h1>";

    ?>
<table align="center">

<!--
<p align=center>nc : <a href=nc.FAILED.txt>413/665</a> vcs : <a href=vcs.FAILED.txt>158/665</a> msim : <a href=msim.FAILED.txt>608/665</a>  Common : <a href=common.FAILED.txt>640/665</a><br>
-->
<br>

<tr align="center"><td align=right> <b> Update Time</b> :</td><td align=left> <u>
<?php 


#$devices = array("ROUTE", "FIREWALL", "SWITCHER", "COMPUTER");
$reasons = array("OK", "FAILED", "OFFLINE");
echo date("Y-m-d H:i:s",time());;

function numfilesindir ($thedir) {
    // echo "thedir=$thedir";
    if (is_dir ($thedir)) {
        $dh  = opendir($thedir);
        while (false !== ($filename = readdir($dh))) {
                $dname="$thedir/$filename";
                // echo $filename."<p>";
            if (is_dir($dname)) {
                if (strcmp("$filename","..") != 0){
                    // echo $filename."<p>";
                    $files[] = $filename;
                }
              }
            }
    } else {
            echo "Sorry, this directory does not exist.";
    }
    
    return $files;
}

function getTxtfileofDir ($dir) {
    return glob("$dir/*.txt");
}


function getValueInfo($filename, $name) {
    exec("/bin/grep $name $filename", $results, $errorCode);

    return remove_quote(substr($results[0],strlen($name)));
}

function removeLastSpace($str) {
    if (strpos($str," \\n \\l")) {
        $res=substr($str, 0, strlen($str)-6);
    } else {
        $res = $str;
    }

    if (strpos($res, "8.04")) {
        return "<font color=#FF0000>$res</font>";
    }
    
    if (strpos($res, "12.04")) {
        return "<font color=#00FF00>$res</font>";
    }

    return $res;
}

function getColorFromStatus($statu) 
{
    switch ($statu)
    {
        case OK:
            $res="#00FF00";
            break;  
        case FAILED:
            $res="#FF0000";
            break;
        case OFFLINE:
            $res="#696969";
            break;
        default:
            $res="#0000FF";
    }

    return $res;
}

function remove_quote($str) {
        if (preg_match("/^\"/",$str)){
            $str = substr($str, 1, strlen($str) - 1);
        }
        
        if (preg_match("/\"$/",$str)){
            $str = substr($str, 0, strlen($str) - 1);;
        }

        return $str;
}


?>
</u> </td></tr>
</table><br>


<!--
<table class="example table-autosort table-autofilter table-autopage:1300 table-stripeclass:alternate table-page-number:t1page table-page-count:t1pages table-filtered-rowcount:t1filtercount table-rowcount:t1allcount" style="margin:0 auto"><thead> <tr>  
<th class="table-sortable:numeric table-sortable table-sorted-asc" > No </th>
<th title="language" class="table-sortable:default table-sortable"> Hostname <br>
<select onchange="Table.filter(this,this)" onclick="Table.cancelBubble(event)" class="table-autofilter">
<option selected="selected" value="">Filter: All</option>
<option value="ROUTE">ROUTE</option>
<option value="SWITCHER">SWITCHER</option>
<option value="COMPUTER">COMPUTER</option>
<option value="FIREWALL">FIREWALL</option>
</select>
</th> 
<th title="ip" class="table-sortable:default table-sortable">  IP  </th> 
<th title="cpu" class="table-sortable:default table-sortable"> CPU  <br>
<select onchange="Table.filter(this,this)" onclick="Table.cancelBubble(event)" class="table-autofilter">
<option selected="selected" value=""> IP </option>
<option value="OK">OK</option>
<option value="FAILED">FAILED</option>
<option value="OFFLINE">OFFLINE</option>
</select>
</th>
<th title="operate systems" class="table-sortable:default table-sortable"> OS  </th>
<th title="Bit" class="table-sortable:default table-sortable"> Bit  </th>
<th title="harddisk size" class="table-sortable:default table-sortable"> HDD </th>
<th title="memory" class="table-sortable:default table-sortable"> Memory </th>
</tr>
-->


|| No || Hostname || CPU || OS || Usage ||<br>


<?php 
    $abso_path=dirname(realpath("index.php"));
    $no=0;
        $curdir="machine/";
        $dirarray = numfilesindir("$curdir");
        //print_r($dirarray);
        foreach ($dirarray as $key=>$dd) {
            //echo "$key, $dd.<p>";
            $logfile="machine/$dd/$dd.txt";
            if (file_exists($logfile)) {
                #echo $logfile;
                $arr=parse_ini_file($logfile, true);

                if ($no%2 == 0) {
                    $tag="";
                } else {
                    $tag="alternate";
                }

                $os=removeLastSpace($arr[OperatingSystem]);
                $memory=($arr[Memory]/1000);
                echo "|| $no || 
                 $dd ||
                 $arr[CPU] ||
                 $os  ||
                   ||<br>";
                $no++;
           }
        } 

?>

</tbody>
</table>

<br>
<br>

</body></html>
