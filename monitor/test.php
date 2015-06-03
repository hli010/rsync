<?php
$ff ="HEAD/20120110/build.20120110.32-flexlm.txt";

if (file_exists($ff)) {
    $content=file($ff);
    $len = count($content);
    echo $content[$len-1]; 
}else {
    echo "NNNNNNNN";
}
?>
