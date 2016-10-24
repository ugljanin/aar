<?php
include("fns.php");

$time=time();
if($_GET[date]!='')
{
	$date=$_GET[date];
}
else
{
	$date=date('YmdH',$time);
}
$datechanged=date('Y-m-d H:s:i',$time);
$myfile = fopen("repository/bodytemperature-".$date.".txt", "r") or die("Unable to open file!");
$bodytemperature=fread($myfile,filesize("repository/bodytemperature-".$date.".txt"));
fclose($myfile);

$myfile = fopen("repository/temperature-".$date.".txt", "r") or die("Unable to open file!");
$temperature=fread($myfile,filesize("repository/temperature-".$date.".txt"));
fclose($myfile);

$myfile = fopen("repository/heartbeat-".$date.".txt", "r") or die("Unable to open file!");
$heartbeat=fread($myfile,filesize("repository/heartbeat-".$date.".txt"));
fclose($myfile);

echo $temperature.' - '.$bodytemperature;

if($bodytemperature<'36.5'||$bodytemperature>'37.5')
{
	$newtemperature=25;
	$conn=db_connect();
	$sql="insert into changesambient (description,fromvalue,tovalue,parameter,date) values ('Temperature is optimised','".$temperature."','".$newtemperature."','temperature','".$datechanged."')";

	$result=mysqli_query($conn,$sql);
	if($result)
	{
		$myfile = fopen("repository/temperature-changed-".$date.".txt", "w") or die("Unable to open file!");
		$txt = $newtemperature;
		fwrite($myfile, $txt);
		fclose($myfile);
	}
}
if($heartbeat>'80')
{
	$conn=db_connect();
	$sql="insert into changesambient (description,fromvalue,tovalue,parameter,date) values ('Heart beat is too high','".$heartbeat."','".$heartbeat."','heartbeat','".$datechanged."')";

	$result=mysqli_query($conn,$sql);

}
else if($heartbeat<'60')
{
	$conn=db_connect();
	$sql="insert into changesambient (description,fromvalue,tovalue,parameter,date) values ('Heart beat is too low','".$heartbeat."','".$heartbeat."','heartbeat','".$datechanged."')";

	$result=mysqli_query($conn,$sql);

}


?>
