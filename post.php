<?php

include("fns.php");

date_default_timezone_set('UTC');
$sql="select * from configuration where configurationid=1";
$result=mysqli_query($conn,$sql);

$podesavanje=mysqli_fetch_array($result,MYSQLI_ASSOC);

if($_POST[accesstoken]==$podesavanja[accesstoken])
{
	$results = print_r($_POST, true);
	$myfile = fopen("post.txt", "w") or die("Unable to open file!");
	fwrite($myfile, $results);
	fclose($myfile);
}
else
{
	$results = print_r($_POST, true);
	$myfile = fopen("error.txt", "w") or die("Unable to open file!");
	fwrite($myfile, $results);
	fclose($myfile);
}


?>
