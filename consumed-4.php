<?php
include("fns.php");

$input=array("35.5", "35.8","36.5", "36.8","36.2","36.2","36.1","36.5", "36.9","36.7", "36.6", "36.8","35.9", "36.9","36.7", "36.6","37","38","38","39","40","41","42");
function array_random($arr, $num = 1) {
    shuffle($arr);

    $r = array();
    for ($i = 0; $i < $num; $i++) {
        $r[] = $arr[$i];
    }
    return $num == 1 ? $r[0] : $r;
}
$nova=array_random($input);
echo '<h1>Body temperature</h1>';
echo 'Current body temperature is: '.$nova;
$time=time();
if($_GET[date]!='')
{
	$date=$_GET[date];
}
else
{
	$date=date('YmdH',$time);
}
$myfile = fopen("repository/bodytemperature-".$date.".txt", "w") or die("Unable to open file!");
fwrite($myfile, $nova);
fclose($myfile);

?>
