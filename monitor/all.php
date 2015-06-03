<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html><head>    <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
    <link rel="stylesheet" type="text/css" href="./main.css" media="all"> 
    <script type="text/javascript" src="./main.js"></script>
    <script type="text/javascript" src="./jquery.js"></script>
    <script type="text/javascript" src="./table.js"></script>
    <link rel="stylesheet" type="text/css" href="./table.css" media="all"> 
<?php
    require_once("lib.php");
    echo "<title> $title </title>";
    
?>
    </head><body>
    <?php

    echo "<h1> $title </h1>";

    ?>
<table align="center">

<tr align="center"><td align=right> <b> Update Time</b> :</td><td align=left> <a href=RUNTEST.txt><u>
<?php 

$devices = array("ROUTE", "FIREWALL", "SWITCHER", "COMPUTER");
$reasons = array("OK", "FAILED", "OFFLINE");
$device="ROUTE";
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
</u></a> </td></tr>
</table><p>


<table class="example table-autosort table-autofilter table-autopage:1300 table-stripeclass:alternate table-page-number:t1page table-page-count:t1pages table-filtered-rowcount:t1filtercount table-rowcount:t1allcount" style="margin:0 auto"><thead> <tr>  
<th class="table-sortable:numeric table-sortable table-sorted-asc" > No </th>
<th title="language" class="table-sortable:default table-sortable"> device <br><select onchange="Table.filter(this,this)" onclick="Table.cancelBubble(event)" class="table-autofilter">
<option selected="selected" value="">Filter: All</option>
<option value="ROUTE">ROUTE</option>
<option value="SWITCHER">SWITCHER</option>
<option value="COMPUTER">COMPUTER</option>
<option value="FIREWALL">FIREWALL</option>
</select></th> 
<th title="device ID" class="table-sortable:default table-sortable">  ID  </th> 
<th title="status" class="table-sortable:default table-sortable"> Status <br>
<select onchange="Table.filter(this,this)" onclick="Table.cancelBubble(event)" class="table-autofilter">
<option selected="selected" value="">Filter: All</option>
<option value="OK">OK</option>
<option value="FAILED">FAILED</option>
<option value="OFFLINE">OFFLINE</option>
</select></th>
<th title="error code" class="table-sortable:default table-sortable"> Return Code </th>
<th title="update time" class="table-sortable:default table-sortable"> Last Update</th>
</tr>

</thead> <tbody>

<?php 
    $abso_path=dirname(realpath("index.php"));
    $no=0;
    foreach ($devices as $device) {
        $curdir="device/$device";
        $dirarray = numfilesindir("$curdir");
        //print_r($dirarray);
        foreach ($dirarray as $key=>$dd) {
            //echo "$key, $dd.<p>";
            $txt=getTxtfileofDir("$curdir/$dd");
            $log=$txt[0];

            if ( file_exists($log) ){ 
                $statu = getValueInfo($log, "STATUS:");
                $code = getValueInfo($log, "ERROR_CODE:");
                $bgcolor=getColorFromStatus($statu);
                $updatetime=getValueInfo($log, "UPDATE_TIME:");
                if ($no%2 == 0) {
                    $tag="";
                } else {
                    $tag="alternate";
                }

                echo "<tr class=\"$tag\"><td> $no </td> 
                <td>$device</td> 
                <td> $dd     </td>
                <td bgcolor=$bgcolor><a href=\"$log\">$statu</a></td> 
                <td align=left><a href=\"$log\">$code</a></td> 
                <td align=left>$updatetime </td> 
                </tr>
                ";
                $no++;
            }
        } 
    }

?>

</tbody>
</table>

</body></html>
