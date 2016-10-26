<?php
include("fns.php");

date_default_timezone_set('UTC');

$conn=db_connect();
$time=time();
$timedate=date('Y-m-d H:s:i',$time);


$sql="select * from gateways where accesstoken='$_POST['accesstoken']' and status='Active'";
$result=mysqli_query($conn,$sql);
if(mysqli_num_rows($result)=='1')
{

	$gateway=mysqli_fetch_array($result,MYSQLI_ASSOC);

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
			$sql="insert into sensordata (name, value, date,gatewayid) values ('".$data[name]."','".$data[value]."','".$currdate."','".$gateway[gatewayid]."')";
			$result=mysqli_query($conn,$sql);
	}

}
else
{
		$myfile = fopen("gs://aar-framework.appspot.com/post.txt", 'w');
	//$myfile = fopen("post.txt", "w") or die("Unable to open file!");
	fwrite($myfile, "Nije proslo");
	fclose($myfile);
}
?>
