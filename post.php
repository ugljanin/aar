<?php
include("fns.php");

date_default_timezone_set('UTC');

$conn=db_connect();
$time=time();
$timedate=date('Y-m-d H:s:i',$time);

/*
$sql="select * from configuration where configurationid=1";
$result=mysqli_query($conn,$sql);

$podesavanje=mysqli_fetch_array($result,MYSQLI_ASSOC);

if($_POST[accesstoken]==$podesavanja[accesstoken])
{
	$results = print_r($_POST, true);
	$myfile = fopen("post.txt", "w") or die("Unable to open file!");
	fwrite($myfile, $_POST['json']);
	fclose($myfile);
}
else
{
	$results = print_r($_POST, true);
	$myfile = fopen("error.txt", "w") or die("Unable to open file!");
	fwrite($myfile, $_POST['json']);
	fclose($myfile);
}
*/
$myfile = fopen("gs://aar-framework.appspot.com/post.txt", 'w');

	//$myfile = fopen("post.txt", "w") or die("Unable to open file!");
	fwrite($myfile, $_POST['json']);
	fclose($myfile);

$json_a = json_decode($_POST['json'], true);

foreach($json_a['Details'] as $date)
{
	 $currdate=$date['date'];
}

foreach($json_a['SensorData'] as $data)
{
		$sql="insert into sensordata (name, value, date) values ('".$data[name]."','".$data[value]."','".$currdate."')";
		$result=mysqli_query($conn,$sql);
}

?>
