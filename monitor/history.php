<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" >
<title>Hima Nightly Release</title>
</head>
<style>

body, table{
    font-family: Verdana;
    font-size: 12.5px;
}

/* h1 only used in header */
h1, h2,h3,h4,h5,h6 {
padding:           2px 10px 2px 10px;
background:        rgb(234,242,255);
border:            1px solid rgb(120,172,255);
}

h1,h2 {
    font-weight:    normal;
}

h3,h4,h5,h6 {
    font-weight:    bold;
}

h1 {
    font-size:        30px;
}

h2 {
    font-size:        20px;
    margin-right:    10px;
}

h3 {
    font-size:        13px;
    margin-right:    10px;
}

a {
    text-decoration: none;
    border-bottom: 1px dotted #FF9900;
    /*    padding-left: 2px;
          padding-right: 2px;*/
color:            rgb(0,66,174);
}

a:hover {/*rgb(0,66,174)*/
color:            rgb(120,172,255);
  }

a:visited {
color:            rgb(0,66,174);
  }

a:visited:hover {
color:            rgb(120,172,255);
  }

span.shortcut{
    background-color:        #EEEEEE;
border:            1px solid #BBBBBB;
padding:        2px 2px 0px 0px;
}

span.commandProto {
border: 1px solid #BBBBBB;
background : #F0F0F0;
padding : 2px 2px 2px 2px;
margin : 2px 2px 2px 2px;
}

span.commandProtoParameter{
    font-weight : bold;
}

img {
margin: 1px 1px 1px 1px;
}

img.alLeft {
float: left;
}


img.alCenter {
float: none;
}


img.alRight {
float: right;
}

pre, pre.example, pre.ChangeLog {
    padding-right:    2px;
    padding-left:    2px;
    background-color:        #F9F9F9;
border:            1px solid #BBBBBB;

}

span.redMark {
    background-color:        #FFBBBB;
border:            1px solid #FF9999;
}

thead td {
    padding-right:    2px;
    padding-left:    2px;
    background-color:        #EEEEEE;
border:            1px solid #BBBBBB;
}
</style>
<body>
<h1 align="center">Hima Nightly Release(History - Since 20120101 )</h1>
<p align=center>Release Dir : 
<a href="./index.php">/nextop/machine/hengshan/heng/Applications/nightly_release</a>&nbsp; &nbsp; 
<a href="./CustomerRelease.php">Custome Release</a>&nbsp; &nbsp;
<a href="<?php echo $_Server["DOCUMENT_ROOT"]; ?>/reg/release/releasenotes/index.php">Release Notes</a> 
<a href="./oldindex.php">History Result Before 2012</a><br><br> 

<table border=0 cellpadding=5 cellspacing=1 bgcolor=#000000 align=center><tbody>
<tr bgcolor=#C8C8FF><th> No </th> <th> Date </th>
<?php
require_once('lib.php');
$startdate=mktime("3","0","0","01","01","2012");

$datetag = date("Ymd");
$enddate=time();
$intervaldays=round(($enddate-$startdate)/3600/24);
$count=0;
$datelist=getDateList($datetag,$intervaldays);
$Bits2=array("32","64");

foreach($NewDistributions AS $Key => $Info){
    echo " <th title=\"$Info\">$Info</th>";
}
echo "</tr>";


$totalcount = 0;
foreach($datelist AS $Key => $datetag){
    echo "<tr bgcolor=#FFEEAA><td> $totalcount </td><td> <a href=\"index.php?date=$datetag\">$datetag </a></td>";
    foreach($NewDistributions AS $Key => $Info){    
        generateReleaseDate($Info, $datetag);

    }
    echo "</tr>";
    $totalcount++;
}




?>


</tbody> </table>



<!-- Verific -->
<BR>
<hr>
<div class="legal1" align="CENTER">Copyright © 2006-2009 <a href="http://www.nextopsoftware.com/">NextOp Software. Inc.</a>  All rights reserved. </div>

</body>
</html>
