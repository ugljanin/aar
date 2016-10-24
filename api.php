<?php
include("fns.php");
//CORS
header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Headers: X-Requested-With');

header('Content-Type: application/json');
//header('HTTP/1.0 500 Server Error');

class Info {
		public $UserDetails = "";
		public $ConsumedResources  = "";
	}

	$Info = new Info();

date_default_timezone_set('UTC');
$conn=db_connect();
$time=time();
$timedate=date('Y-m-d H:s:i',$time);

$ConsumedResources = [];
$UserDetails = [];
$accesstoken=$_GET[accesstoken];
$sql="select accesstokens.created, accesstokens.expiring, accesstokens.sesid, accesstokens.accesstoken, users.username
				from accesstokens, users
				where accesstokens.userid=users.userid and accesstokens.accesstoken='".$accesstoken."'";

$result=mysqli_query($conn,$sql);
$accesst=mysqli_fetch_array($result,MYSQLI_ASSOC);
if(mysqli_num_rows($result)!=0)
{
	if($accesst[expiring]>$timedate)
	{

		$consumed=$_GET[consumed];
		$date=$_GET[date];
		if($consumed=='temperature')
		{
			$file="repository/temperature-".$date.".txt";
			if(file_exists($file))
			{
				$myfile = fopen($file, "r");
				array_push($ConsumedResources, [
					'temperature'   => fread($myfile,filesize($file))
				]);
				fclose($myfile);
			}
			else
			{
				array_push($ConsumedResources, [
					'temperature'   => 'Not measured for this date'
				]);
			}
		}
		else if($consumed=='humidity')
		{
			$file="repository/humidity-".$date.".txt";
			if(file_exists($file))
			{
				$myfile = fopen($file, "r");
				array_push($ConsumedResources, [
					'humidity'   => fread($myfile,filesize($file))
				]);
				fclose($myfile);
			}
			else
			{
				array_push($ConsumedResources, [
					'humidity'   => 'Not measured for this date'
				]);
			}
		}
		else if($consumed=='weather')
		{
			$file="repository/humidity-".$date.".txt";
			$file1="repository/temperature-".$date.".txt";
			if(file_exists($file))
			{
				$myfile = fopen($file, "r");
				$humidity=fread($myfile,filesize($file));
				$myfile1 = fopen($file1, "r");
				$temperature=fread($myfile1,filesize($file1));
				array_push($ConsumedResources, [
					'humidity'   => $humidity,
					'temperature'   => $temperature
				]);
				fclose($myfile);
				fclose($myfile1);
			}
			else
			{
				array_push($ConsumedResources, [
					'humidity'   => 'Not measured for this date',
					'temperature'   => 'Not measured for this date'
				]);
			}
		}

		$created=$row[created];
		$expiring=$row[expiring];

		array_push($UserDetails, [
			'user'   => $accesst[username],
			'accesstoken'   => $accesst[accesstoken],
			'created'   => $accesst[created],
			'expiring' => $accesst[expiring]
		]);

	}
	else
	{
		array_push($UserDetails, [
			'error'   => 'Access token expired'
		]);
	}
}
else
{
		array_push($UserDetails, [
			'error'   => 'Access token not valid'
		]);
}

	$Info->UserDetails=$UserDetails;
	$Info->ConsumedResources=$ConsumedResources;

	print_r(json_encode($Info,JSON_PRETTY_PRINT));


?>
