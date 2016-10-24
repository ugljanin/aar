<?php
include("fns.php");

//date_default_timezone_set('UTC');

$title="ICU temperature and humidity monitoring and control";
include "header.php";

$conn=db_connect();
$time=time();
$timedate=date('Y-m-d H:s:i',$time);

?>
	<div class="row">
		<div class="col-sm-6">
			<h2>Patient sensors</h2>
			<div style="overflow:scroll;height:180px">
			<table class="table table-hover">
				<thead>
					<tr>
						<th>Date time</th>
						<th>Body temperature</th>
						<th>Heartbeat</th>
					</tr>
				</thead>
				<tbody>
				<tr>
				<?php
$today=date('Y-m-d H:s:i',time());
$begin = new DateTime( "2016-08-18 20:00:00" );
$end   = new DateTime($today );
for($i = $end; $end >= $begin; $i->modify('-1 hour')){

		$currdate=$i->format("YmdH");
		$file="repository/bodytemperature-".$currdate.".txt";
		$file2="repository/heartbeat-".$currdate.".txt";
		if(file_exists($file))
		{
			echo '<tr>';
			echo '<td>'.$i->format("Y-m-d H").':00:00</td>';
			$myfile = fopen($file, "r");
			echo '<td><a href="repository/bodytemperature-'.$currdate.'.txt">'.fread($myfile,filesize($file)).'°C</a></td>';
			fclose($myfile);

			$myfile = fopen($file2, "r");
			echo '<td><a href="repository/heartbeat-'.$currdate.'.txt">'.fread($myfile,filesize($file2)).'</a></td>';
			fclose($myfile);
			echo '</tr>';
		}
	}
				?>
					</tr>
					</tbody>
				</table>
			</div>
		</div>
		<div class="col-sm-6">
			<h2>Ambient sensors</h2>
			<div style="overflow:scroll;height:180px">
			<table class="table table-hover">
				<thead>
					<tr>
						<th>Date time</th>
						<th>Temperature</th>
						<th>Humidity</th>
					</tr>
				</thead>
				<tbody>
				<tr>
				<?php

$begin = new DateTime( "2016-08-18 20:00:00" );
$end   = new DateTime($today );
for($i = $end; $end >= $begin; $i->modify('-1 hour')){
		echo '<tr>';
    echo '<td>'.$i->format("Y-m-d H").':00:00</td>';
		$currdate=$i->format("YmdH");
		$file="repository/temperature-".$currdate.".txt";
		$file2="repository/temperature-changed-".$currdate.".txt";
		if(file_exists($file)&&file_exists($file2))
		{
			$myfile = fopen($file, "r");
			$myfile2 = fopen($file2, "r");
			echo '<td>';
			echo '<a href="repository/temperature-'.$currdate.'.txt">From:'.fread($myfile,filesize($file)).'°C</a><br>';
			echo '<a href="repository/temperature-changed-'.$currdate.'.txt">To:'.fread($myfile2,filesize($file2)).'°C</a>';
			echo '</td>';
			fclose($myfile);
			fclose($myfile2);
		}
		else if(file_exists($file))
		{
			$myfile = fopen($file, "r");
			echo '<td><a href="repository/temperature-'.$currdate.'.txt">'.fread($myfile,filesize($file)).'°C</a></td>';
			fclose($myfile);
		}

		$file="repository/humidity-".$currdate.".txt";
		if(file_exists($file))
		{
			$myfile = fopen($file, "r");

			echo '<td><a href="repository/humidity-'.$currdate.'.txt">'.fread($myfile,filesize($file)).'%</a></td>';
			fclose($myfile);
		}
		echo '</tr>';
	}
				?>
					</tr>
					</tbody>
				</table>
			</div>
		</div>
		<div class="col-sm-6">
			<h2>Changes in ambient</h2>
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
						echo '<td>'.$ambient[description].' from '.$ambient[from].' to '.$ambient[to].'</td>';
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
			<h2>Notes</h2>
				<p>Normal body temperature is between 36.5–37.5 °C</p>
				<p>Normal heart rate is between 61-76</p>
		</div>
	</div>
	<?php






include "footer.php";
?>
