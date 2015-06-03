<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
#$Distributions=array("HEAD","1101","20100701");
$Distributions=array("HEAD","20100701");
$NewDistributions=array("HEAD","20111001", "20120701");
$Apps=array("bugscope","covscope", "verifier");
$Bits=array("","-32", "-64");
$startdate=mktime("3","0","0","11","23","2009");
$from = "norepy@atrenta.com";
$to = "heng@atrenta.com";
$URL_Suffix="http://portland.cn.atrenta.com/ds/";



function getURL($linkfile) {
   global $URL_Suffix;

   if (strpos($linkfile, "/var/www/ds/") === 0 )
	return $URL_Suffix."/".substr($linkfile, 11); 
   else
   	return $URL_Suffix."/".$linkfile; 

}

function getURLWithDate($linkfile, $date) {
   global $URL_Suffix;

   return $URL_Suffix."/".$linkfile."?date=$date"; 
}

function getRecentDate($curdate, $tag){
    $dd1=strtotime("$curdate");
    return date("Ymd",strtotime("$tag",$dd1));
}

function getDateList($datetag,$intervaldays)
{
   for($daterange = 0; $daterange > -$intervaldays; $daterange--){
       //echo $daterange;
       $thatday=getRecentDate($datetag, "$daterange day");
       $rlist[] =  "$thatday";
   }
   return $rlist;
}

function showReleaseInfo($dir1, $datetag, $bits,$appname){
    if (strcmp($bits, "") == 0) {
        $bit="";
        $bit2="";
    }else{
        $bit=".$bits";
        $bit2="-$bits";
    }

    $config="$dir1/log/config.$datetag$bit-flexlm.txt";
    $build="$dir1/log/build.$datetag$bit-flexlm.txt";
   
    $releasename="$appname-release-$datetag$bit2-flexlm.tar.gz";
    if (strcmp($appname, "bugscope") == 0 ) {
        $releasename="hima-release-$datetag$bit2-flexlm.tar.gz";
        if (!file_exists("$dir1/$releasename")){
        $releasename="$appname-release-$datetag$bit2-flexlm.tar.gz";
        }
    }
    

    $result=true;
    if (file_exists("$dir1/$releasename")){
        $detail0="<a href=\"$dir1/$releasename\"><font
        color=#006633>".substr($releasename, -42, -7)."</font></a>(".strval(sprintf("%.2f", filesize("$dir1/$releasename")/1000000))."M";
    }else{
        #echo "$dir1/$releasename<p>";
        if (file_exists($config) && file_exists($build)){
            $detail0="<font color=#FF0000>".substr($releasename, -42, -7)."</font>(0.00M";
            $result=false;
        }else{
            $detail0="------";
            $result=true;
            return;
        }
    }

        if (file_exists("$config")){
            $detail1=",<a href=\"$config\">config</a>, <a href=\"$build\">log</a>";
        }else
       {
           $detail1="";
           $result=false;
       }

       $config="$dir1/log/fixrelease.$datetag$bit-flexlm.txt";
        if (file_exists("$config")){
            $detail2=",<a href=\"$config\">merge</a>";
        }else
       {
           $detail2="";
           $result=false;
       }

       $config="$dir1/log/smoken.$datetag$bit-flexlm.txt";
       if (file_exists("$config")){
            $handle=fopen($config,"r");
            $fileContent=fread($handle,fileSize($config));
            fclose($handle);

            if(strpos($fileContent,"Hooray, no error!") !== false) { 
                $fgcolor="#00FF00";
            }else {
                $fgcolor="#FF0000";
            }

            $detail3=", <a href=\"$config\"><font color=$fgcolor>Smoken</font></a>)<br>";
        }else
       {
           $detail3=")<br>";
           $result=false;
       }
    
    return "$detail0$detail1$detail2$detail3";
}


function showReleaseDetail($dir1, $datetag, $bit, $appname)
{
            $releasename="$appname-release-$datetag-$bit-flexlm.tar.gz";
            echo "<h2 align=\"center\"><b>$appname</b>-$dir1($bit bit)</h2>";
            echo "<table border=0 cellpadding=5 cellspacing=1 bgcolor=#000000 align=center><tbody>";
            echo "<tr bgcolor=#C8C8FF><th> No </th> <th> Items </th> <th>Detail</th></tr>";

            if (strcmp($appname, "bugscope") ==0 ) {
                $releasename="hima-release-$datetag-$bit-flexlm.tar.gz";
                if (!file_exists("$dir1/$releasename")){
                    $releasename="bugscope-release-$datetag-$bit-flexlm.tar.gz";
                 }
            }

            if (file_exists("$dir1/$releasename")){
                echo "<tr bgcolor=#FFEEAA><td> 0 </td><td> ReleaseName </td><td> <font color=#006633>$releasename</font></td></tr>";
                echo "<tr bgcolor=#FFEEAA><td> 1 </td><td> Download </td><td><a href=$dir1/$releasename>download</a></td></tr>";
                echo "<tr bgcolor=#FFEEAA><td> 2 </td><td> Bit </td><td>$bit</td></tr>";
                echo "<tr bgcolor=#FFEEAA><td> 3 </td><td> Size </td><td>".strval(filesize("$dir1/$releasename")/1000)."K </td></tr>";
                echo "<tr bgcolor=#FFEEAA><td> 4 </td><td> Date </td><td>".strftime("%Y-%m-%d %H:%M:%S %A",filectime("$dir1/$releasename"))."</td></tr>";
            }else{
                echo "<tr bgcolor=#FFEEAA><td colspan=\"3\"> Build <font color=#FF0000> $releasename</font> ERROR! </td></tr>";
            }
            
              $config="$dir1/log/config.$datetag.$bit-flexlm.txt";
                if (file_exists($config)){
                    $configdetail="<a href=$config>config</a>";
                }else{
                    $configdetail="-";
                }

                echo "<tr bgcolor=#FFEEAA><td> 5 </td><td> Build Config </td><td>$configdetail</td></tr>";

                $config="$dir1/log/build.$datetag.$bit-flexlm.txt";
                if (file_exists($config)){
                    $configdetail="<a href=$config>Log</a>";
                }else{
                    $configdetail="-";
                }

                echo "<tr bgcolor=#FFEEAA><td> 6 </td><td> Build Log </td><td>$configdetail</td></tr>";

                $config="$dir1/log/smoken.$datetag.$bit-flexlm.txt";
                if (file_exists($config)){
                    $configdetail="<a href=$config>Smoken Log</a>";
                }else{
                    $configdetail="-";
                }


                echo "<tr bgcolor=#FFEEAA><td> 7 </td><td> Smoken Test </td><td>$configdetail</td></tr>";

            
            echo "</tbody> </table>";

}


function findfile($basedir, $str) {
    $handle=opendir($basedir);
    for(;$files   =   strtolower(readdir($handle));) {
        if ( strpos($files, ".tar.gz") ) {
            $rlist[] =  $files;
        }
    }

    return $rlist;
}

function findfile2($basedir, $str) {
    $handle=opendir($basedir);
    for(;$files   =   strtolower(readdir($handle));) {
        if ( strpos($files, $str) ) {
            $rlist[] =  $files;
        }
    }

    return $rlist;
}   

function getFomateFileSize($size){
    if ($size > 1024*1024*1024) {
	$num = sprintf("%.2f",$size/(1024*1024*1024));
        return "$num M";
    } 
    if ($size > 1024*1024) {
	$num = sprintf("%.2f",$size/(1024*1024));
        return "$num M";
    } 
    if ($size > 1024) {
	$num = sprintf("%.2f",$size/(1024));
        return "$num K";
    } 

    return "$size";
}

function getTestFileStatus($file, $name) {
    //$my_file = file_get_contents("$file");
    if (strpos($file, "smoken")) {
    	$content=file($file);
    	$len = count($content);
    	$my_file = trim($content[$len-1]);
        //$my_file = file_get_contents("$file");
        //echo $file.":\"".$my_file."\"<p>";
        if (strcmp($my_file, "SMOKEN_TEST: OK") == 0) {
            //echo " my_file=$my_file";
            return "<font color=#00aa00><b> $name OK </b> </font>";
        } else {
            return "<font color=#aa0000><b> $name ERROR</b> </font>";
        } 
    }

    if (strpos($file, "build")) {
    	$content=file($file);
    	$len = count($content);
    	$my_file = $content[$len-1];
        if (strpos($my_file, "=== [mkrelease] === DONE")) {
            return "<font color=#00aa00><b> $name OK </b> </font>";
        } else {
            return "<font color=#aa0000><b> $name ERROR</b> </font>";
        } 
    }
    
    return "$name";
}

function showFileInfo($link, $name, $rowspan) {
    if (file_exists($link)) {
        return "<td rowspan=$rowspan bgcolor=#66CC66> <font color=#00aa00><a
        href=$link>".getTestFileStatus($link,$name)."</a></font></td>";
    } else {
        return "<td rowspan=$rowspan bgcolor=#FF9966> <font color=#aa0000>-</font></td>";
    }
}


function generateReleaseDate($Info,$datetag) {
    global $Apps;
    $releasedir="$Info/$datetag/";
    echo "<td title=\"$Info\">";
    if (file_exists($releasedir)) {
        echo "<table border=0 cellpadding=5 cellspacing=1 bgcolor=#000000 align=center><tbody>";
        $count = 1;
        foreach ($Apps AS $app => $name) {
            $rname="${name}-release-${datetag}-flexlm.tar.gz";
            echo "<tr bgcolor=#ffffee><th rowspan=2 bgcolor=#ffffee> $count </th>";
            echo showFileInfo("$releasedir/$rname","$rname",2);

            $bit="-32";
            $rname="${name}-release-${datetag}${bit}-flexlm.tar.gz";
            $bitnum=".32";

            $buildfile="$releasedir/build.${datetag}${bitnum}-flexlm.txt";
            $configfile="$releasedir/config.${datetag}${bitnum}-flexlm.txt";
            $fixfile="$releasedir/fixrelease.${datetag}-flexlm.txt";
            $smokenfile="$releasedir/smoken.${datetag}${bitnum}-flexlm.txt";

            echo showFileInfo("$releasedir/$rname","$rname",1);
            echo showFileInfo("$configfile","config",1);
            echo showFileInfo("$buildfile","build",1);
            echo showFileInfo("$fixfile","fix",2);
            echo showFileInfo("$smokenfile","smoken",1);                
            echo "</tr>";

            $rname="${name}-release-${datetag}-flexlm.tar.gz";

            echo "<tr>";
            $bit="-64";
            $rname="${name}-release-${datetag}${bit}-flexlm.tar.gz";
            $bitnum=".64";

            $buildfile="$releasedir/build.${datetag}${bitnum}-flexlm.txt";
            $configfile="$releasedir/config.${datetag}${bitnum}-flexlm.txt";
            $smokenfile="$releasedir/smoken.${datetag}${bitnum}-flexlm.txt";

            echo showFileInfo("$releasedir/$rname","$rname",1);
            echo showFileInfo("$configfile","config",1);
            echo showFileInfo("$buildfile","build",1);
            echo showFileInfo("$smokenfile","smoken",1);                
            echo "</tr>";
            $count++;

        }

        echo "</tbody> </table>";
    } else {
        echo "There were no nightly release data here!";
    }
    echo "</td>";
}


function quick_link($datetag, $index) {
    $currentdate=date("Ymd");

    $content = "<p align=\"center\"><font size=1>";
    for($daterange = -5; $daterange < 5; $daterange++) {
        $thatday=getRecentDate($datetag, "$daterange day");

        if(date("Y-m-d",strtotime($thatday)) > date("Y-m-d",strtotime($currentdate))) {
            continue;
        } else {
            $content.= "<!-- $thatday:$currentdate -->";
        }

        $datelink = str_replace("-", "_", $thatday);
        if (strcmp($thatday, $datetag) == 0) {
             $content .= "$thatday &nbsp; ";
        } else {
             $content .= "<a href=$index?date=$datelink>$thatday</a>&nbsp; ";
        }

    }

    $content .= "</font></p>";
    return $content; 

}

?>
