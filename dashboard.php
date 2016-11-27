<?php
include("fns.php");

//date_default_timezone_set('UTC');

$title="Dashboard";
include "header.php";

$conn=db_connect();
$time=time();
$timedate=date('Y-m-d H:s:i',$time);

?>
	<div class="row">
		<div class="col-sm-3">
			<h2>Heart rate</h2>
			<div style="overflow:scroll;height:180px">
			<table class="table table-hover">
				<thead>
					<tr>
						<th>Gateway</th>
						<th>Date time</th>
						<th>Value</th>
					</tr>
				</thead>
				<tbody>
				<tr>
				<?php
$sql="select sensordata.value, sensordata.data, gateways.name as gateway
from sensordata, gateways
where name='heartbeat'
order by dataid desc limit 50";
$result=mysqli_query($conn,$sql);
while($sensor=mysqli_fetch_array($result,MYSQLI_ASSOC))
{
	echo '<tr>';
	echo '<td>'.$sensor[gateway],'</td>';
	echo '<td>'.$sensor[data].'</td>';
	echo '<td>'.$sensor[value].'°C</td>';
	echo '</tr>';
}
					?>
					</tr>
					</tbody>
				</table>
			</div>
		</div>
		<div class="col-sm-3">
			<h2>Body temperature</h2>
			<div style="overflow:scroll;height:180px">
			<table class="table table-hover">
				<thead>
					<tr>
						<th>Gateway</th>
						<th>Date time</th>
						<th>Value</th>
					</tr>
				</thead>
				<tbody>
				<tr>
				<?php
$sql="select sensordata.value, sensordata.data, gateways.name as gateway
from sensordata, gateways
where name='bodytemperature'
order by dataid desc limit 50";
$result=mysqli_query($conn,$sql);
while($sensor=mysqli_fetch_array($result,MYSQLI_ASSOC))
{
	echo '<tr>';
	echo '<td>'.$sensor[gateway],'</td>';
	echo '<td>'.$sensor[data].'</td>';
	echo '<td>'.$sensor[value].'°C</td>';
	echo '</tr>';
}
					?>
					</tr>
					</tbody>
				</table>
			</div>
		</div>
		<div class="col-sm-3">
			<h2>Humidity</h2>
			<div style="overflow:scroll;height:180px">
			<table class="table table-hover">
				<thead>
					<tr>
						<th>Gateway</th>
						<th>Date time</th>
						<th>Value</th>
					</tr>
				</thead>
				<tbody>
				<tr>
				<?php
$sql="select sensordata.value, sensordata.data, gateways.name as gateway
from sensordata, gateways
where name='humidity'
order by dataid desc limit 50";
$result=mysqli_query($conn,$sql);
while($sensor=mysqli_fetch_array($result,MYSQLI_ASSOC))
{
	echo '<tr>';
	echo '<td>'.$sensor[gateway],'</td>';
	echo '<td>'.$sensor[data].'</td>';
	echo '<td>'.$sensor[value].'°C</td>';
	echo '</tr>';
}
					?>
					</tr>
					</tbody>
				</table>
			</div>
		</div>
		<div class="col-sm-3">
			<h2>Temperature</h2>
			<div style="overflow:scroll;height:180px">
			<table class="table table-hover">
				<thead>
					<tr>
						<th>Gateway</th>
						<th>Date time</th>
						<th>Value</th>
					</tr>
				</thead>
				<tbody>
				<tr>
				<?php
$sql="select sensordata.value, sensordata.data, gateways.name as gateway
from sensordata, gateways
where name='temperature'
order by dataid desc limit 50";
$result=mysqli_query($conn,$sql);
while($sensor=mysqli_fetch_array($result,MYSQLI_ASSOC))
{
	echo '<tr>';
	echo '<td>'.$sensor[gateway],'</td>';
	echo '<td>'.$sensor[data].'</td>';
	echo '<td>'.$sensor[value].'°C</td>';
	echo '</tr>';
}
					?>
					</tr>
					</tbody>
				</table>
			</div>
		</div>
		<div class="col-sm-6">
			<h2>Notifications</h2>
			<div style="overflow:scroll;height:250px">
			<table class="table table-hover">
				<thead>
					<tr>
						<th>Date time</th>
						<th>Description</th>
					</tr>
				</thead>
				<tbody>
				<?php
				$sql="select * from changesambient";
				$result=mysqli_query($conn,$sql);
				while($ambient=mysqli_fetch_array($result,MYSQLI_ASSOC))
				{
						echo '<tr>';
						echo '<td>'.$ambient[date].'</td>';
					if($ambient[parameter]=='temperature')
						echo '<td>'.$ambient[description].' from '.$ambient[fromvalue].' to '.$ambient[tovalue].'</td>';
					if($ambient[parameter]=='heartbeat')
						echo '<td>'.$ambient[description].' nurse alerted</td>';

						echo '</tr>';
				}

				?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="col-sm-6">


	<div class="row">
		<div class="col-sm-12">
			<h2>List of patients report</h2>
			<div>
			<table class="table table-hover">
				<thead>
					<tr>
						<th>ID</th>
						<th>Gateway</th>
						<th>Title</th>
						<th>Description</th>
						<th>Employee</th>
						<th>Date of creation</th>
						<th>Date of change</th>
					</tr>
				</thead>
				<tbody>
				<tr>
				<?php
	$sql="select report.title,report.reportid, report.description, gateways.name as gateway, report.creationdate, report.changedate, report.status, users.username from report, users, gateways
	where users.userid=report.userid
	and report.status='Finished'
	and gateways.gatewayid=report.gatewayid
	order by report.reportid desc";

	$result=mysqli_query($conn,$sql);
	while($report=mysqli_fetch_array($result,MYSQLI_ASSOC)){
		echo '<tr>';
		echo '<td>#'.$report[reportid].'</td>';
		echo '<td>'.$report[gateway].'</td>';
		echo '<td>'.$report[title].'</td>';
		echo '<td>'.$report[description].'</td>';
		echo '<td>'.$report[username].'</td>';
		echo '<td>'.$report[creationdate].'</td>';
		echo '<td>'.$report[changedate].'</td>';

		echo '</tr>';
	}
				?>
					</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>

		</div>
	</div>
	<?php






include "footer.php";
?>
