<?php
$ff ="20141214/tool.local.log.local.detail";

function tail($fp,$n,$base=5){
    assert($n>0);
    $pos = $n+1;

    $lines = array();
    while (count($lines) <= $n){
        /*try {
	    fseek($fp, -$pos, SEEK_END);
        } catch (Exception $e) {
            fseek(0);
            break;
        };*/
       
	fseek($fp, -$pos, SEEK_END);
        //$pos *= $base;
        while(!feof($fp)){
            array_unshift($lines,fgets($fp));
        }
    } 

    return array_slice($lines,0,$n);
}


echo date('y-m-d h:i:s',time());
echo "<p>";
$speed=0;
$size=0;
$fl = fopen($ff, 'r');

#foreach (tail($fl, 2) as $line)
#{
#	echo "$line.<p>";
#}
#var_dump(tail($fl, 2));

echo $speed; 
echo "<p>";

echo $size;
echo "<p>";

echo "<p>";
fclose($fl);

$fl = escapeshellarg($ff);
$line=`tail -n 2 $fl`;
$arr = explode(" ", $line);
print_r($arr);
echo $arr[1];
echo $arr[5];
echo $arr[8];
echo $arr[12];

echo "<p>";
echo date('y-m-d h:i:s',time());

?>
