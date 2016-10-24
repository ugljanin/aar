<?php
include("fns.php");
for($i=40;$i<=120;$i++)
{
	$input[]=$i;
}
function array_random($arr, $num = 1) {
    shuffle($arr);

    $r = array();
    for ($i = 0; $i < $num; $i++) {
        $r[] = $arr[$i];
    }
    return $num == 1 ? $r[0] : $r;
}

echo '<h1>Heart beat</h1>';
echo 'Current heart beat is: '.array_random($input);
$time=time();
if($_GET[date]!='')
{
	$date=$_GET[date];
}
else
{
	$date=date('YmdH',$time);
}
$myfile = fopen("repository/heartbeat-".$date.".txt", "w") or die("Unable to open file!");
$txt = array_random($input);
fwrite($myfile, $txt);
fclose($myfile);

?>
