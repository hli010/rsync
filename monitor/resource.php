<html>
<head>
    <?php
        $pagename = 'Nextop Software Computer Resource Static';
        $countno = 0;
    ?>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" >
    <title><?php echo $pagename; ?></title>
</head>
<style>

body, table{
    font-family: Verdana;
    font-size: 12.5px;
}

/* h1 only used in header */
h1, h2,h3,h4,h5,h6 {
    padding:        2px 10px 2px 10px;
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
<h1><?php echo $pagename; ?></h1>
<h2>Current Issues</h2>
<ul>
	<li><a href="#Introduction">The Regression/Release task is easily doubled</a>:
            <pre>1. We're ealier double the regression/nightly task by：
   1. new version: pli3, top3, 
   2. new branch: 0926 branch
   3. even some option: cacheflow, -sv(alpha release)
   4. new platform: ubuntu6.06, amd64.

2. I think We can:
   1. clean up the old version faster
   2. clean the regression, make the regression more effiency
   3. add new regression task more carefully.

            </pre>
        </li>

        <li><a href="#CurrentStatus">Regression/Regression Resource Issue</a>
            <pre>


1. Regression:
      1) machine : suzhou, zhujiang, yellow(RandomTest)
      2) the Random have 9 nightly flows: the yellow.nextop have been full.
      3) The benchmark test often have some problem:
         1) it takes a long time but we can't got a clean machine to run
         2) some customer testcases can't add to the regression as it's too long.
   I think we need another 1 machine to run Random/Benchmark test.

2. Releaes machine:
      *) machine: hanjiang, huangpu, taishan, zhijiang
          1) they are all low performance machine except zhijiang.nextop.
          2) hanjiang, huangpu have virtual box on it.

   I think we need another 2-3 machines for release use, for the normal times, it can used for sge.

3. Ubuntu6.06 and AMD64 Issues
    *) machine: minjiang, yuan, sgemaster, amd
    *) not enough diskspace.
    *) the yuan.nextop and sgemaster is useless.

   I think:
     1) the yuan.nextop can upgrade to ubuntu8.04.
     2) we need a big harddisk for yuan.nextop, as it have 10G space available out of 40G.
     3) clean up the nightly build jobs on ubuntu6.06 and amd64(bug2310).

4. VMS: multi-platforms

   It because more important as the release-hima and dev-hima are not on same platform.

    *) Multi-Platforms: RH3,4,5-32, 4-64, d-1,d-4 : on hanjiang, huangpu, yangzi, minjiang.
    *) they were often shut down because of resouce issue.
    *) we don't have free resource to setup new platform: eg gentoo in Q3.

   Current the vms are on the multi regression/release machines, it takes up normal resource and hard to manage.
   I think we'd better got a server machine to hold the vms, then the jobs run on them can be automatics.



SUMMARY:

  1) I think we need another 4 machines and 1 big harddisk:
     1) 1 for RandomTest
     2) 2 for release test
     3) 1 for VMS

   Then the usage:
     1) suzhou, zhujiang for regression
        yellow, new1 for RandomTest
     2) zhijiang for benchmark test and customer designs test
     3) hanjiang, huangpu, taishan, new2, new 3, yuan, for release test
     4) new4 for vms.
        the hanjiang, huangpu, taishan, yuan, new2, new3, new4 can be used on grid.

   It can satisfy us for at least 1-2 quarters.
      </pre>
        </li>
        
<a name="Introduction"></a>
<h2>Regression/Release Test List </h2>
<table border=0 cellpadding=5 cellspacing=1 bgcolor=#000000 align=center><tbody>
<tr bgcolor=#C8C8FF><th> No </th> <th> Regression Name </th> <th>Time</th><th> Space </th><th> Regression Task </th><th> Machine </th><th> Comment </th></tr>



<tr bgcolor=#FFEEAA>
<td> <?php echo ++$countno; ?> </td>
<td title="Regression Name"> Build </td>
<td title="time">1.5h</td>
<td title="space">20G</td>
<td title="Regression Task">8 nightly task:<br>
u804: hima, 0926 * 2<br>
u606: hima, 0926<br>
AMD64: hima, 0926<br>
</td>
<td title="Machine"><br>yellow<br>
minjiang<br>
amd64</td>
<td title="Comment"> </td>
</tr>

<!-- Modules List -->
<tr bgcolor=#FFEEAA>
<td> <?php echo ++$countno; ?> </td>
<td title="Regression Name"> RandomTest </td>
<td title="time">24h<br>
*4core(regression)<br>
*16core(release)</td>
<td title="space">780M(after cleanup)<br>
20-30G</td>
<td title="Regression Task">9 nightly task: <br>
    reg, top2, pli3 <br>
    reg, top2, pli <br>
    reg, top3, pli3 <br>
    reg, 0926_top,pli <br>
    MAcloseloop, top2 <br>
    kunlun(stop) <br>
    HimaOrderFlow <br>
    top-beta <br>
    reg-vcs <br>
    top-vcs <br>
</td>
<td title="Machine"><br>yellow<br></td>

<td title="Comment"> </td>
</tr>

<tr bgcolor=#FFEEAA>
<td> <?php echo ++$countno; ?> </td>
<td title="Regression Name"> Regression </td>
<td title="time">3.5h</td>
<td title="space">-</td>
<td title="Regression Task">2*31 modules/applications</td>
<td title="Machine">zhujiang<br></td>
<td title="Comment"> </td>
</tr>

<tr bgcolor=#FFEEAA>
<td> <?php echo ++$countno; ?> </td>
<td title="Regression Name"> CloseloopTest </td>
<td title="time">2.5h</td>
<td title="space">-</td>
<td title="Regression Task">1  module * 3 simulator</td>
<td title="Machine">zhujiang<br></td>
<td title="Comment"> </td>
</tr>


<tr bgcolor=#FFEEAA>
<td> <?php echo ++$countno; ?> </td>
<td title="Regression Name"> TOPPliTest </td>
<td title="time">2.5h</td>
<td title="space">-</td>
<td title="Regression Task">1  module * 3 simulator</td>
<td title="Machine">zhujiang<br></td>
<td title="Comment"> </td>
</tr>

<tr bgcolor=#FFEEAA>
<td> <?php echo ++$countno; ?> </td>
<td title="Regression Name"> CoverageTest </td>
<td title="time">2.5h</td>
<td title="space">-</td>
<td title="Regression Task">1*31 modules/applications</td>
<td title="Machine">suzhou<br></td>
<td title="Comment"> </td>
</tr>

<tr bgcolor=#FFEEAA>
<td> <?php echo ++$countno; ?> </td>
<td title="Regression Name"> Valgrind  </td>
<td title="time">about 5 day</td>
<td title="space">-</td>
<td title="Regression Task">1*31 modules/applications</td>
<td title="Machine">suzhou, biweeks<br></td>
<td title="Comment"> </td>
</tr>

<tr bgcolor=#FFEEAA>
<td> <?php echo ++$countno; ?> </td>
<td title="Regression Name"> Benchmark  </td>
<td title="time">19h</td>
<td title="space">1.5G</td>
<td title="Regression Task">46 cases</td>
<td title="Machine">suzhou, weeks<br></td>
<td title="Comment"> </td>
</tr>

<tr bgcolor=#FFEEAA>
<td> <?php echo ++$countno; ?> </td>
<td title="Regression Name"> PLI Benchmark  </td>
<td title="time">1h</td>
<td title="space">-</td>
<td title="Regression Task">53 cases</td>
<td title="Machine">suzhou, weeks<br></td>
<td title="Comment"> </td>
</tr>


<tr bgcolor=#FFEEAA>
<td> <?php echo ++$countno; ?> </td>
<td title="Regression Name"> Flatten Test  </td>
<td title="time">20hours</td>
<td title="space">-</td>
<td title="Regression Task">596 cases</td>
<td title="Machine">release<br></td>
<td title="Comment"> </td>
</tr>

<tr bgcolor=#FFEEAA>
<td> <?php echo ++$countno; ?> </td>
<td title="Regression Name"> Hima Crash History  </td>
<td title="time">10hours</td>
<td title="space">-</td>
<td title="Regression Task">1268 cases</td>
<td title="Machine">release<br></td>
<td title="Comment"> </td>
</tr>

<tr bgcolor=#FFEEAA>
<td> <?php echo ++$countno; ?> </td>
<td title="Regression Name"> Option Test  </td>
<td title="time">10hours</td>
<td title="space">-</td>
<td title="Regression Task">> 40976 cases</td>
<td title="Machine">release<br></td>
<td title="Comment"> </td>
</tr>

<tr bgcolor=#FFEEAA>
<td> <?php echo ++$countno; ?> </td>
<td title="Regression Name"> Hima Release Comparision Test  </td>
<td title="time">1hours</td>
<td title="space">-</td>
<td title="Regression Task">152 cases</td>
<td title="Machine">release<br></td>
<td title="Comment"> </td>
</tr>

<tr bgcolor=#FFEEAA>
<td> <?php echo ++$countno; ?> </td>
<td title="Regression Name"> Customer Designs Test  </td>
<td title="time">3hours(takes several days run complete.)</td>
<td title="space">10G</td>
<td title="Regression Task">6 cases</td>
<td title="Machine">release<br></td>
<td title="Comment"> </td>
</tr>

<tr bgcolor=#FFEEAA>
<td> <?php echo ++$countno; ?> </td>
<td title="Regression Name"> Multi platform Test  </td>
<td title="time">-(the time is to restart vms)</td>
<td title="space">-</td>
<td title="Regression Task">3 cases</td>
<td title="Machine">release<br></td>
<td title="Comment"> </td>
</tr>


<tr bgcolor=#FFEEAA>
<td> <?php echo ++$countno; ?> </td>
<td title="Regression Name"> DoxygenDocument  </td>
<td title="time">-</td>
<td title="space">-</td>
<td title="Regression Task">25 modules</td>
<td title="Machine">suzhou<br></td>
<td title="Comment"> </td>
</tr>

<tr bgcolor=#FFEEAA>
<td> <?php echo ++$countno; ?> </td>
<td title="Regression Name"> HBTConvertionTest  </td>
<td title="time">-</td>
<td title="space">-</td>
<td title="Regression Task">28 cases</td>
<td title="Machine">suzhou<br></td>
<td title="Comment"> </td>
</tr>

<tr bgcolor=#FFEEAA>
<td> <?php echo ++$countno; ?> </td>
<td title="Regression Name"> AssertionChecker  </td>
<td title="time">-</td>
<td title="space">-</td>
<td title="Regression Task">25 modules</td>
<td title="Machine">suzhou<br></td>
<td title="Comment"> </td>
</tr>


<tr bgcolor=#FFEEAA>
<td><?php echo ++$countno; ?> </td>
<td title="Regression Name"> CVSCheckRecords  </td>
<td title="time">-</td>
<td title="space">-</td>
<td title="Regression Task">-</td>
<td title="Machine">regression,suzhou<br></td>
<td title="Comment"> </td>
</tr>
</tbody> </table>
</body>
</html>
