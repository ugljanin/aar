<?php
include("fns.php");
for($i=20;$i<=40;$i++)
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

echo '<h1>Temperature sensor</h1>';
echo 'Current temperature is: '.array_random($input);
$time=time();
if($_GET[date]!='')
{
	$date=$_GET[date];
}
else
{
	$date=date('YmdH',$time);
}
$myfile = fopen("repository/temperature-".$date.".txt", "w") or die("Unable to open file!");
$txt = array_random($input);
fwrite($myfile, $txt);
fclose($myfile);

?>
