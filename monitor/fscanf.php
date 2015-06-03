<?php
$handle = fopen("bug2127/configuration","r");
while ($userinfo = fscanf($handle, "%s=%s\n")) {
    list ($name, $profession) = $userinfo;
    print $userinfo[0]."    |".$userinfo[1].'|<p>';
}
fclose($handle);
?> 