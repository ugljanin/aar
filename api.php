<?php
include("fns.php");
//CORS
header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Headers: X-Requested-With');

header('Content-Type: application/json');
//header('HTTP/1.0 500 Server Error');

class Info {
		public $UserDetails = "";
		public $PatientsDetails  = "";
	}

	$Info = new Info();

date_default_timezone_set('UTC');
$conn=db_connect();
$time=time();
$timedate=date('Y-m-d H:s:i',$time);

$PatientsDetails = [];
$UserDetails = [];
$accesstoken=$_GET[accesstoken];
$Y=$_GET[Y];
$m=$_GET[m];
$d=$_GET[d];
$H=$_GET[H];
$i=$_GET[i];
$s=$_GET[s];
$datum=date('Y-m-d H:i:s',strtotime($Y."-".$m."-".$d." ".$H.":".$i));
$sql="select accesstokens.created, accesstokens.expiring, accesstokens.sesid, accesstokens.accesstoken, users.username
				from accesstokens, users
				where accesstokens.userid=users.userid and accesstokens.accesstoken='".$accesstoken."'";

$result=mysqli_query($conn,$sql);
$accesst=mysqli_fetch_array($result,MYSQLI_ASSOC);
if(mysqli_num_rows($result)!=0)
{
	if($accesst[expiring]>$timedate)
	{
		$sqls="select * from sensordata where date like '%".$Y."-".$m."-".$d." ".$H.":".$i."%'";

		$results=mysqli_query($conn,$sqls);

			if(mysqli_num_rows($results)!='0')
			{

				while($sensor=mysqli_fetch_array($results,MYSQLI_ASSOC))
				{
					if($sensor[name]=='humidity')
						$humidity=$sensor[value];
					if($sensor[name]=='temperature')
						$temperature=$sensor[value];
					if($sensor[name]=='heartbeat')
						$heartbeat=$sensor[value];
					if($sensor[name]=='bodytemperature')
						$bodytemperature=$sensor[value];
				}


				array_push($PatientsDetails, [
					'date'   => $datum,
					'humidity'   => $humidity,
					'temperature'   => $temperature,
					'heartbeat'   => $heartbeat,
					'bodytemperature'   => $bodytemperature
				]);
			}
			else
			{
				array_push($PatientsDetails, [
					'date'   => $datum,
					'humidity'   => 'Not measured for this date',
					'temperature'   => 'Not measured for this date',
					'heartbeat'   => 'Not measured for this date',
					'bodytemperature'   => 'Not measured for this date'
				]);
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
	$Info->PatientsDetails=$PatientsDetails;

	print_r(json_encode($Info,JSON_PRETTY_PRINT));


?>
