<?php
include("fns.php");

date_default_timezone_set('UTC');


$conn=db_connect();
$time=time();
$timedate=date('Y-m-d H:s:i',$time);

if($_GET[action]=='list')
{

$title="Gateway list";

include "header.php";
?>
<a href="gateways.php?action=add" class="btn btn-primary" role="button">Create new gateway</a>
	<div class="row">
		<div class="col-sm-12">
			<h2>List of gateways</h2>
			<div>
			<table class="table table-hover">
				<thead>
					<tr>
						<th>ID</th>
						<th>Name</th>
						<th>Location</th>
						<th>Access token</th>
						<th>Status</th>
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				<tr>
				<?php

						if($_SESSION[role]=='admin')
						{
							$sql="select * from gateways order by gatewayid desc";

							$result=mysqli_query($conn,$sql);
							while($gateway=mysqli_fetch_array($result,MYSQLI_ASSOC)){
								echo '<tr>';
								echo '<td>#'.$gateway[gatewayid].'</td>';
								echo '<td>'.$gateway[name].'</td>';
								echo '<td>'.$gateway[location].'</td>';
								echo '<td>'.$gateway[accesstoken].'</td>';
								echo '<td>'.$gateway[status].'</td>';
								echo '<td><a class="btn btn-md btn-info" href="gateways.php?action=monitor&gatewayid='.$gateway[gatewayid].'">Monitor</a> <a class="btn btn-md btn-success" href="gateways.php?action=add&gatewayid='.$gateway[gatewayid].'">Edit</a> <a class="btn btn-md btn-danger" href="gateway.php?action=add&gatewayid='.$gateway[gatewayid].'">Delete</a></td>';
								echo '<td></td>';
								echo '</tr>';
							}
						}



				?>
					</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<?php
}
else if($_GET[action]=='monitor'&&$_SESSION[role]=='admin')
{

$title="Gateway monitoring";

include "header.php";
	$sql="SELECT  DATE_FORMAT( date, '%Y-%m-%d at %H:%i' ) sat, value
	FROM sensordata
	where gatewayid='1'
	and name='temperature'
	ORDER BY date DESC limit 60";
	$result=mysqli_query($conn,$sql);

	while($podaci=mysqli_fetch_array($result,MYSQLI_ASSOC))
	{
			$datumi[]=$podaci[sat];
			if($podaci[value]!='Not measured for this date')
				$prvi[]=$podaci[value];
			else
				$prvi[]=0;
	}
	?>
	<div class="row">
		<div class="col-lg-6">
        <canvas id="canvas"></canvas>
		</div>
		<div class="col-lg-6">
        <canvas id="canvas1"></canvas>
		</div>
		<div class="col-lg-6">
        <canvas id="canvas2"></canvas>
		</div>
		<div class="col-lg-6">
        <canvas id="canvas3"></canvas>
		</div>
	</div>
	<script>

		var config = {
            type: 'line',
            data: {
								<?php
								$sati = implode('","', $datumi);
								echo 'labels:["'.$sati.'"],';
								?>
                datasets: [{
                    label: "Temperature",
                    <?php
										$prvi = implode(",", $prvi);
										echo 'data:['.$prvi.'],';
										?>
                    fill: false,
										borderColor: "rgba(179,181,198,1)",
                }],

								max: 30,
								min: 20
						},
            options: {
                responsive: true,

                title:{
                    display:true,
                    text:'aaR* Framework'
                },
                tooltips: {
                    mode: 'label',
                    callbacks: {
                    }
                },
                hover: {
                    mode: 'dataset'
                },
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Date and time'
                        }
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Degrees Celsius'
                        },
                        ticks: {
                            suggestedMin: 0,
                            suggestedMax: 60,
                        }
                    }]
                }
            }
        };
	<?php
	unset($datumi);
	unset($prvi);
	$sql="SELECT  DATE_FORMAT( date, '%Y-%m-%d at %H:%i' ) sat, value
	FROM sensordata
	where gatewayid='1'
	and name='humidity'
	ORDER BY date DESC limit 60";
	$result=mysqli_query($conn,$sql);

	while($podaci=mysqli_fetch_array($result,MYSQLI_ASSOC))
	{
			$datumi[]=$podaci[sat];
			if($podaci[value]!='Not measured for this date')
				$prvi[]=$podaci[value];
			else
				$prvi[]=0;
	}
		?>
		var config1 = {
            type: 'line',
            data: {
								<?php
								$sati = implode('","', $datumi);
								echo 'labels:["'.$sati.'"],';
								?>
                datasets: [{
                    label: "Humidity",
                    <?php
										$prvi = implode(",", $prvi);
										echo 'data:['.$prvi.'],';
										?>
                    fill: false,
										borderColor: "rgba(179,181,198,1)",
                }
            ]},
            options: {
                responsive: true,

                title:{
                    display:true,
                    text:'aaR* Framework'
                },
                tooltips: {
                    mode: 'label',
                    callbacks: {
                    }
                },
                hover: {
                    mode: 'dataset'
                },
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Date and time'
                        }
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Percent'
                        },
                        ticks: {
                            suggestedMin: 0,
                            suggestedMax: 100,
                        }
                    }]
                }
            }
        };
		<?php
	unset($datumi);
	unset($prvi);
	$sql="SELECT  DATE_FORMAT( date, '%Y-%m-%d at %H:%i' ) sat, value
	FROM sensordata
	where gatewayid='1'
	and name='bodytemperature'
	ORDER BY date DESC limit 60";
	$result=mysqli_query($conn,$sql);

	while($podaci=mysqli_fetch_array($result,MYSQLI_ASSOC))
	{
			$datumi[]=$podaci[sat];
			if($podaci[value]!='Not measured for this date')
				$prvi[]=$podaci[value];
			else
				$prvi[]=0;
	}
		?>
		var config2 = {
            type: 'line',
            data: {
								<?php
								$sati = implode('","', $datumi);
								echo 'labels:["'.$sati.'"],';
								?>
                datasets: [{
                    label: "Body temperature",
                    <?php
										$prvi = implode(",", $prvi);
										echo 'data:['.$prvi.'],';
										?>
                    fill: false,
										borderColor: "rgba(179,181,198,1)",
                }
            ]},
            options: {
                responsive: true,

                title:{
                    display:true,
                    text:'aaR* Framework'
                },
                tooltips: {
                    mode: 'label',
                    callbacks: {
                    }
                },
                hover: {
                    mode: 'dataset'
                },
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Date and time'
                        },
												gridLines: {
														zeroLineColor: "rgba(0,255,0,1)"
												}
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Degrees Celsius'
                        },
                        ticks: {
                            suggestedMin: 30,
                            suggestedMax: 50,
                        }
                    }]
                }
            }
        };
		<?php
	unset($datumi);
	unset($prvi);
	$sql="SELECT  DATE_FORMAT( date, '%Y-%m-%d at %H:%i' ) sat, value
	FROM sensordata
	where gatewayid='1'
	and name='heartbeat'
	ORDER BY date DESC limit 60";
	$result=mysqli_query($conn,$sql);

	while($podaci=mysqli_fetch_array($result,MYSQLI_ASSOC))
	{
			$datumi[]=$podaci[sat];
			if($podaci[value]!='Not measured for this date')
				$prvi[]=$podaci[value];
			else
				$prvi[]=0;
	}
		?>
		var config3 = {
            type: 'line',
            data: {
								<?php
								$sati = implode('","', $datumi);
								echo 'labels:["'.$sati.'"],';
								?>
                datasets: [{
                    label: "Heart beat",
                    <?php
										$prvi = implode(",", $prvi);
										echo 'data:['.$prvi.'],';
										?>
                    fill: false,
										borderColor: "rgba(179,181,198,1)",
                }
            ]},
            options: {
                responsive: true,

                title:{
                    display:true,
                    text:'aaR* Framework'
                },
                tooltips: {
                    mode: 'label',
                    callbacks: {
                    }
                },
                hover: {
                    mode: 'dataset'
                },
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Date and time'
                        }
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Number of heart beats in one minute'
                        },
                        ticks: {
                            suggestedMin: 30,
                            suggestedMax: 150,
                        }
                    }]
                }
            }
        };
		window.onload = function() {
			var originalLineDraw = Chart.controllers.line.prototype.draw;
Chart.helpers.extend(Chart.controllers.line.prototype, {
  draw: function() {
    originalLineDraw.apply(this, arguments);

    var chart = this.chart;
    var ctx = chart.chart.ctx;

    var xaxis = chart.scales['x-axis-0'];
    var yaxis = chart.scales['y-axis-0'];

    var limits = new Array();

    var max = new Array();
    max["value"] = chart.config.data.max;
    max["label"] = "Max.";
    max["color"] = "#FF0000";
    limits.push(max);

    var min = new Array();
    min["value"] = chart.config.data.min;
    min["label"] = "Min.";
    min["color"] = "#FF0000";
    limits.push(min);


    for (var i = 0; i < limits.length; i++) {

      //Refactor the value
      limits[i].value = yaxis.getPixelForValue(limits[i].value, undefined);
      ctx.fillStyle = 'black';
      ctx.fillText(limits[i].label, 5, limits[i].value - 5);

      ctx.save();
      ctx.beginPath();
      ctx.moveTo(xaxis.left, limits[i].value);
      ctx.strokeStyle = limits[i].color;
      ctx.lineTo(xaxis.right, limits[i].value);
      ctx.stroke();
      ctx.restore();
    }
  }
});
            var ctxa = document.getElementById("canvas").getContext("2d");
            window.myLine = new Chart(ctxa, config);
            var ctx1 = document.getElementById("canvas1").getContext("2d");
            window.myLine = new Chart(ctx1, config1);
            var ctx2 = document.getElementById("canvas2").getContext("2d");
            window.myLine = new Chart(ctx2, config2);
            var ctx3 = document.getElementById("canvas3").getContext("2d");
            window.myLine = new Chart(ctx3, config3);
        };
		</script>




		<?php
}
else if($_GET[action]=='add'&&$_SESSION[role]=='admin')
{

$title="Gateway add";

include "header.php";
	if($_GET[gatewayid]!=''||!empty($_GET[gatewayid]))
	{
		$gatewayid=$_GET[gatewayid];
		$sql="select * from gateways where gatewayid='$gatewayid'";
		$result=mysqli_query($conn,$sql);
		$gateway=mysqli_fetch_array($result,MYSQLI_ASSOC);
	}

	?>
	<div class="row">
			<div class="col-sm-12">
				<h2>Gateways</h2>
				 <form action="gateways.php?action=submit" method="post">
				 <input type="hidden" name="gatewayid" value="<?php echo $gateway[gatewayid];?>">
					<div class="form-group">
						<label for="name">Name:</label>
						<input type="text" class="form-control" name="name" id="name" value="<?php echo $gateway[name];?>">
					</div>
					<div class="form-group">
						<label for="location">Location:</label>
						<input type="text" class="form-control" name="location" id="location" value="<?php echo $gateway[location];?>">
					</div>
					<div class="form-group">
						<label for="accesstoken">Access token:</label>
						<input type="text" class="form-control" name="accesstoken" id="accesstoken" value="<?php echo $gateway[accesstoken];?>">
					</div>
					<div class="form-group">
						<label for="status">Status:</label>
						<select class="form-control" name="status" id="status">
							<option value="Active" <?php if($gateway[status]=='Active') echo 'selected';?>>Active</option>
							<option value="Blocked" <?php if($gateway[status]=='Blocked') echo 'selected';?>>Blocked</option>
						</select>
					</div>
					<button type="submit" class="btn btn-default">Submit</button>
				</form>
			</div>
	</div>
			<?php
}
else if($_GET[action]=='submit'&&$_SESSION[role]=='admin')
{

$title="Gateway submit";

include "header.php";
	$accesstoken=$_POST[accesstoken];
	$name=$_POST[name];
	$status=$_POST[status];
	$location=$_POST[location];
	$date=date('Y-m-d H:s:i',time());


	if($_POST[gatewayid]!=''||!empty($_POST[gatewayid]))
	{

		$gatewayid=$_POST[gatewayid];

		$sql="update gateways
		set name='".$name."',
				accesstoken='".$accesstoken."',
				location='".$location."',
				status='".$status."'
				where gatewayid='".$gatewayid."'";

		$result=mysqli_query($conn,$sql);

		if($result)
		{
			$_SESSION["messagetype"] = "success";
			$_SESSION["message"] = "Gateway is changed";
			echo "Gateway is changed!";

		}
		else
		{
			$_SESSION["messagetype"] = "danger";
			$_SESSION["message"] = "Gateway is not changed";
			echo "Gateway is not changed!";
		}
	}
	else
	{
		$sql="insert into gateways (name, accesstoken, location, status) values ('".$name."','".$accesstoken."','".$location."','".$status."')";
		$result=mysqli_query($conn,$sql);

		if($result)
		{
			$_SESSION["messagetype"] = "success";
			$_SESSION["message"] = "Gateway is added";
			echo "Gateway is added!";

		}
		else
		{
			$_SESSION["messagetype"] = "danger";
			$_SESSION["message"] = "Gateway is not added";
			echo "Gateway is not added!";
		}
	}

	redirect("gateways.php?action=list");
}





include "footer.php";
?>
