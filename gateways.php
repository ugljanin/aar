<?php
include("fns.php");

date_default_timezone_set('UTC');

$title="Configure gateway";
include "header.php";

$conn=db_connect();
$time=time();
$timedate=date('Y-m-d H:s:i',$time);

if($_GET[action]=='list')
{

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
								echo '<td><a class="btn btn-md btn-info" href="gateways.php?action=dashboard&gatewayid='.$gateway[gatewayid].'">Dashboard</a> <a class="btn btn-md btn-success" href="gateways.php?action=add&gatewayid='.$gateway[gatewayid].'">Edit</a> <a class="btn btn-md btn-danger" href="gateway.php?action=add&gatewayid='.$gateway[gatewayid].'">Delete</a></td>';
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
else if($_GET[action]=='dashboard'&&$_SESSION[role]=='admin')
{
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
	<h2>Temperature sensor</h2>
	<script>
	defCanvasWidth=1200;
defCanvasHeight=600;
      document.write("<canvas id=\"grafikon1\" height=\""+defCanvasHeight+"\" width=\""+defCanvasWidth+"\"></canvas>");


		var lineChartData1 = {
			<?php
			$sati = implode('","', $datumi);
			echo 'labels:["'.$sati.'"],';
			?>
			datasets : [
				{
					label: "Temperature",
					fillColor : "rgba(255,0,0,0.0)",
					strokeColor : "rgba(255,0,0,1)",
					pointColor : "rgba(255,0,0,1)",
					pointStrokeColor : "#fff",
					pointHighlightFill : "#fff",
					pointHighlightStroke : "rgba(255,0,0,1)",
					<?php
					$prvi = implode(",", $prvi);
					echo 'data:['.$prvi.']';
					?>
				}
			]

		}
		</script>




  <!div id="divCursor" style="position:absolute"> <!/div>

  <center>
    <script>





  var allopts = {
	//Boolean - If we show the scale above the chart data	  -> Default value Changed
  scaleOverlay : true,
	//Boolean - If we want to override with a hard coded scale
	scaleOverride : false,
	//** Required if scaleOverride is true **
	//Number - The number of steps in a hard coded scale
	scaleSteps : null,
	//Number - The value jump in the hard coded scale
	scaleStepWidth : null,
	//Number - The scale starting value
	scaleStartValue : null,
	//String - Colour of the scale line
	scaleLineColor : "rgba(0,0,0,.1)",
	//Number - Pixel width of the scale line
	scaleLineWidth : 1,
	//Boolean - Whether to show labels on the scale
	scaleShowLabels : true,
	//Interpolated JS string - can access value
	scaleLabel : "<%=value%>",
	//String - Scale label font declaration for the scale label
	scaleFontFamily : "'Arial'",
	//Number - Scale label font size in pixels
	scaleFontSize : 12,
	//String - Scale label font weight style
	scaleFontStyle : "normal",
	//String - Scale label font colour
	scaleFontColor : "#666",
	///Boolean - Whether grid lines are shown across the chart
	scaleShowGridLines : true,
	//String - Colour of the grid lines
	scaleGridLineColor : "rgba(0,0,0,.05)",
	//Number - Width of the grid lines
	scaleGridLineWidth : 1,
	//Boolean - Whether the line is curved between points -> Default value Changed
	bezierCurve : false,
	//Boolean - Whether to show a dot for each point -> Default value Changed
	pointDot : false,
	//Number - Radius of each point dot in pixels
	pointDotRadius : 3,
	//Number - Pixel width of point dot stroke
	pointDotStrokeWidth : 1,
	//Boolean - Whether to show a stroke for datasets
	datasetStroke : true,
	//Number - Pixel width of dataset stroke
	datasetStrokeWidth : 2,
	//Boolean - Whether to fill the dataset with a colour
	datasetFill : true,
	//Boolean - Whether to animate the chart             -> Default value changed
	animation : false,
	//Number - Number of animation steps
	animationSteps : 60,
	//String - Animation easing effect
	animationEasing : "easeOutQuart",
	//Function - Fires when the animation is complete
	onAnimationComplete : null,
  canvasBorders : true,
  canvasBordersWidth : 30,
  canvasBordersColor : "black",
  yAxisLeft : true,
  yAxisRight : true,
  yAxisLabel : "Y axis",
  yAxisFontFamily : "'Arial'",
	yAxisFontSize : 50,
	yAxisFontStyle : "normal",
	yAxisFontColor : "#666",
  xAxisLabel : "",
	xAxisFontFamily : "'Arial'",
	xAxisFontSize : 16,
	xAxisFontStyle : "normal",
	xAxisFontColor : "#666",
  yAxisUnit : "UNIT",
	yAxisUnitFontFamily : "'Arial'",
	yAxisUnitFontSize : 12,
	yAxisUnitFontStyle : "normal",
	yAxisUnitFontColor : "#666",
  graphTitle : "",
	graphTitleFontFamily : "'Arial'",
	graphTitleFontSize : 24,
	graphTitleFontStyle : "bold",
	graphTitleFontColor : "#666",
  graphSubTitle : "",
	graphSubTitleFontFamily : "'Arial'",
	graphSubTitleFontSize : 18,
	graphSubTitleFontStyle : "normal",
	graphSubTitleFontColor : "#666",
  footNote : "Footnote",
	footNoteFontFamily : "'Arial'",
	footNoteFontSize : 50,
	footNoteFontStyle : "bold",
	footNoteFontColor : "#666",
  legend : true,
	legendFontFamily : "'Arial'",
	legendFontSize : 18,
	legendFontStyle : "normal",
	legendFontColor : "#666",
  legendBlockSize : 30,
  legendBorders : true,
  legendBordersWidth : 30,
  legendBordersColor : "#666",
  //  ADDED PARAMETERS
  graphMin : "DEFAULT",
  graphMax : "DEFAULT"

  }

    var noopts = {
  nooptions : "",
  yAxisRight : true,
  scaleTickSizeLeft : 0,
  scaleTickSizeRight : 0,
  scaleTickSizeBottom : 0,
  scaleTickSizeTop : 1


  }

    var onlyborderopts = {
  canvasBorders : true,
  canvasBordersWidth : 3,
  canvasBordersColor : "black"

  }

var newopts = {
      inGraphDataShow : false,
      datasetFill : true,
      scaleLabel: "<%=value%>",
      scaleTickSizeRight : 5,
      scaleTickSizeLeft : 5,
      scaleTickSizeBottom : 5,
      scaleTickSizeTop : 5,
      scaleFontSize : 16,
      canvasBorders : true,
      canvasBordersWidth : 3,
      canvasBordersColor : "black",
			graphTitleFontFamily : "'Arial'",
			graphTitleFontSize : 24,
			graphTitleFontStyle : "bold",
			graphTitleFontColor : "#666",
			graphSubTitleFontFamily : "'Arial'",
			graphSubTitleFontSize : 18,
			graphSubTitleFontStyle : "normal",
			graphSubTitleFontColor : "#666",
			footNoteFontFamily : "'Arial'",
			footNoteFontSize : 8,
			footNoteFontStyle : "bold",
			footNoteFontColor : "#666",
      legend : true,
	    legendFontFamily : "'Arial'",
	    legendFontSize : 12,
	    legendFontStyle : "normal",
	    legendFontColor : "#666",
      legendBlockSize : 15,
      legendBorders : true,
      legendBordersWidth : 1,
      legendBordersColors : "#666",
      yAxisLeft : true,
      yAxisRight : false,
      xAxisBottom : true,
      xAxisTop : false,
			yAxisFontFamily : "'Arial'",
			yAxisFontSize : 16,
			yAxisFontStyle : "normal",
			yAxisFontColor : "#666",
	 	  xAxisFontFamily : "'Arial'",
			xAxisFontSize : 16,
			xAxisFontStyle : "normal",
			xAxisFontColor : "#666",
			yAxisUnitFontFamily : "'Arial'",
			yAxisUnitFontSize : 8,
			yAxisUnitFontStyle : "normal",
			yAxisUnitFontColor : "#666",
      annotateDisplay : true,
      spaceTop : 0,
      spaceBottom : 0,
      spaceLeft : 0,
      spaceRight : 0,
      logarithmic: false,
//      showYAxisMin : false,
      rotateLabels : "smart",
      xAxisSpaceOver : 0,
      xAxisSpaceUnder : 0,
      xAxisLabelSpaceAfter : 0,
      xAxisLabelSpaceBefore : 0,
      legendBordersSpaceBefore : 0,
      legendBordersSpaceAfter : 0,
      footNoteSpaceBefore : 0,
      footNoteSpaceAfter : 0,
      startAngle : 0,
      dynamicDisplay : true
}



var so2 = {
      graphTitle : "SO2 Merenja",
      graphSubTitle : "SWAP-APM",
      footNote : "Footnote for the graph",
      yAxisLabel : "SO2 vrednosti",
      xAxisLabel : "Vreme merenja u satima",
      yAxisUnit : "µg/m3",
 inGraphDataShow : false,
      datasetFill : true,
      scaleLabel: "<%=value%>",
      scaleTickSizeRight : 5,
      scaleTickSizeLeft : 5,
      scaleTickSizeBottom : 5,
      scaleTickSizeTop : 5,
      scaleFontSize : 16,
      canvasBorders : true,
      canvasBordersWidth : 3,
      canvasBordersColor : "black",
			graphTitleFontFamily : "'Arial'",
			graphTitleFontSize : 24,
			graphTitleFontStyle : "bold",
			graphTitleFontColor : "#666",
			graphSubTitleFontFamily : "'Arial'",
			graphSubTitleFontSize : 18,
			graphSubTitleFontStyle : "normal",
			graphSubTitleFontColor : "#666",
			footNoteFontFamily : "'Arial'",
			footNoteFontSize : 8,
			footNoteFontStyle : "bold",
			footNoteFontColor : "#666",
      legend : true,
	    legendFontFamily : "'Arial'",
	    legendFontSize : 12,
	    legendFontStyle : "normal",
	    legendFontColor : "#666",
      legendBlockSize : 15,
      legendBorders : true,
      legendBordersWidth : 1,
      legendBordersColors : "#666",
      yAxisLeft : true,
      yAxisRight : false,
      xAxisBottom : true,
      xAxisTop : false,
			yAxisFontFamily : "'Arial'",
			yAxisFontSize : 16,
			yAxisFontStyle : "normal",
			yAxisFontColor : "#666",
	 	  xAxisFontFamily : "'Arial'",
			xAxisFontSize : 16,
			xAxisFontStyle : "normal",
			xAxisFontColor : "#666",
			yAxisUnitFontFamily : "'Arial'",
			yAxisUnitFontSize : 8,
			yAxisUnitFontStyle : "normal",
			yAxisUnitFontColor : "#666",
      annotateDisplay : true,
      spaceTop : 0,
      spaceBottom : 0,
      spaceLeft : 0,
      spaceRight : 0,
      logarithmic: false,
//      showYAxisMin : false,
      rotateLabels : "smart",
      xAxisSpaceOver : 0,
      xAxisSpaceUnder : 0,
      xAxisLabelSpaceAfter : 0,
      xAxisLabelSpaceBefore : 0,
      legendBordersSpaceBefore : 0,
      legendBordersSpaceAfter : 0,
      footNoteSpaceBefore : 0,
      footNoteSpaceAfter : 0,
      startAngle : 0,
      dynamicDisplay : true
}

var no2 = {
      graphTitle : "NO2 Merenja",
      graphSubTitle : "SWAP-APM",
      footNote : "Footnote for the graph",
      yAxisLabel : "NO2 vrednosti",
      xAxisLabel : "Vreme merenja u satima",
      yAxisUnit : "µg/m3",
inGraphDataShow : false,
      datasetFill : true,
      scaleLabel: "<%=value%>",
      scaleTickSizeRight : 5,
      scaleTickSizeLeft : 5,
      scaleTickSizeBottom : 5,
      scaleTickSizeTop : 5,
      scaleFontSize : 16,
      canvasBorders : true,
      canvasBordersWidth : 3,
      canvasBordersColor : "black",
			graphTitleFontFamily : "'Arial'",
			graphTitleFontSize : 24,
			graphTitleFontStyle : "bold",
			graphTitleFontColor : "#666",
			graphSubTitleFontFamily : "'Arial'",
			graphSubTitleFontSize : 18,
			graphSubTitleFontStyle : "normal",
			graphSubTitleFontColor : "#666",
			footNoteFontFamily : "'Arial'",
			footNoteFontSize : 8,
			footNoteFontStyle : "bold",
			footNoteFontColor : "#666",
      legend : true,
	    legendFontFamily : "'Arial'",
	    legendFontSize : 12,
	    legendFontStyle : "normal",
	    legendFontColor : "#666",
      legendBlockSize : 15,
      legendBorders : true,
      legendBordersWidth : 1,
      legendBordersColors : "#666",
      yAxisLeft : true,
      yAxisRight : false,
      xAxisBottom : true,
      xAxisTop : false,
			yAxisFontFamily : "'Arial'",
			yAxisFontSize : 16,
			yAxisFontStyle : "normal",
			yAxisFontColor : "#666",
	 	  xAxisFontFamily : "'Arial'",
			xAxisFontSize : 16,
			xAxisFontStyle : "normal",
			xAxisFontColor : "#666",
			yAxisUnitFontFamily : "'Arial'",
			yAxisUnitFontSize : 8,
			yAxisUnitFontStyle : "normal",
			yAxisUnitFontColor : "#666",
      annotateDisplay : true,
      spaceTop : 0,
      spaceBottom : 0,
      spaceLeft : 0,
      spaceRight : 0,
      logarithmic: false,
//      showYAxisMin : false,
      rotateLabels : "smart",
      xAxisSpaceOver : 0,
      xAxisSpaceUnder : 0,
      xAxisLabelSpaceAfter : 0,
      xAxisLabelSpaceBefore : 0,
      legendBordersSpaceBefore : 0,
      legendBordersSpaceAfter : 0,
      footNoteSpaceBefore : 0,
      footNoteSpaceAfter : 0,
      startAngle : 0,
      dynamicDisplay : true
}
var co = {
      graphTitle : "CO Merenja",
      graphSubTitle : "SWAP-APM",
      footNote : "Footnote for the graph",
      yAxisLabel : "CO vrednosti",
      xAxisLabel : "Vreme merenja u satima",
      yAxisUnit : "mg/m3",
inGraphDataShow : false,
      datasetFill : true,
      scaleLabel: "<%=value%>",
      scaleTickSizeRight : 5,
      scaleTickSizeLeft : 5,
      scaleTickSizeBottom : 5,
      scaleTickSizeTop : 5,
      scaleFontSize : 16,
      canvasBorders : true,
      canvasBordersWidth : 3,
      canvasBordersColor : "black",
			graphTitleFontFamily : "'Arial'",
			graphTitleFontSize : 24,
			graphTitleFontStyle : "bold",
			graphTitleFontColor : "#666",
			graphSubTitleFontFamily : "'Arial'",
			graphSubTitleFontSize : 18,
			graphSubTitleFontStyle : "normal",
			graphSubTitleFontColor : "#666",
			footNoteFontFamily : "'Arial'",
			footNoteFontSize : 8,
			footNoteFontStyle : "bold",
			footNoteFontColor : "#666",
      legend : true,
	    legendFontFamily : "'Arial'",
	    legendFontSize : 12,
	    legendFontStyle : "normal",
	    legendFontColor : "#666",
      legendBlockSize : 15,
      legendBorders : true,
      legendBordersWidth : 1,
      legendBordersColors : "#666",
      yAxisLeft : true,
      yAxisRight : false,
      xAxisBottom : true,
      xAxisTop : false,
			yAxisFontFamily : "'Arial'",
			yAxisFontSize : 16,
			yAxisFontStyle : "normal",
			yAxisFontColor : "#666",
	 	  xAxisFontFamily : "'Arial'",
			xAxisFontSize : 16,
			xAxisFontStyle : "normal",
			xAxisFontColor : "#666",
			yAxisUnitFontFamily : "'Arial'",
			yAxisUnitFontSize : 8,
			yAxisUnitFontStyle : "normal",
			yAxisUnitFontColor : "#666",
      annotateDisplay : true,
      spaceTop : 0,
      spaceBottom : 0,
      spaceLeft : 0,
      spaceRight : 0,
      logarithmic: false,
//      showYAxisMin : false,
      rotateLabels : "smart",
      xAxisSpaceOver : 0,
      xAxisSpaceUnder : 0,
      xAxisLabelSpaceAfter : 0,
      xAxisLabelSpaceBefore : 0,
      legendBordersSpaceBefore : 0,
      legendBordersSpaceAfter : 0,
      footNoteSpaceBefore : 0,
      footNoteSpaceAfter : 0,
      startAngle : 0,
      dynamicDisplay : true
}
var o3 = {
      graphTitle : "O3 Merenja",
      graphSubTitle : "SWAP-APM",
      footNote : "Footnote for the graph",
      yAxisLabel : "O3 vrednosti",
      xAxisLabel : "Vreme merenja u satima",
      yAxisUnit : "µg/m3",
inGraphDataShow : false,
      datasetFill : true,
      scaleLabel: "<%=value%>",
      scaleTickSizeRight : 5,
      scaleTickSizeLeft : 5,
      scaleTickSizeBottom : 5,
      scaleTickSizeTop : 5,
      scaleFontSize : 16,
      canvasBorders : true,
      canvasBordersWidth : 3,
      canvasBordersColor : "black",
			graphTitleFontFamily : "'Arial'",
			graphTitleFontSize : 24,
			graphTitleFontStyle : "bold",
			graphTitleFontColor : "#666",
			graphSubTitleFontFamily : "'Arial'",
			graphSubTitleFontSize : 18,
			graphSubTitleFontStyle : "normal",
			graphSubTitleFontColor : "#666",
			footNoteFontFamily : "'Arial'",
			footNoteFontSize : 8,
			footNoteFontStyle : "bold",
			footNoteFontColor : "#666",
      legend : true,
	    legendFontFamily : "'Arial'",
	    legendFontSize : 12,
	    legendFontStyle : "normal",
	    legendFontColor : "#666",
      legendBlockSize : 15,
      legendBorders : true,
      legendBordersWidth : 1,
      legendBordersColors : "#666",
      yAxisLeft : true,
      yAxisRight : false,
      xAxisBottom : true,
      xAxisTop : false,
			yAxisFontFamily : "'Arial'",
			yAxisFontSize : 16,
			yAxisFontStyle : "normal",
			yAxisFontColor : "#666",
	 	  xAxisFontFamily : "'Arial'",
			xAxisFontSize : 16,
			xAxisFontStyle : "normal",
			xAxisFontColor : "#666",
			yAxisUnitFontFamily : "'Arial'",
			yAxisUnitFontSize : 8,
			yAxisUnitFontStyle : "normal",
			yAxisUnitFontColor : "#666",
      annotateDisplay : true,
      spaceTop : 0,
      spaceBottom : 0,
      spaceLeft : 0,
      spaceRight : 0,
      logarithmic: false,
//      showYAxisMin : false,
      rotateLabels : "smart",
      xAxisSpaceOver : 0,
      xAxisSpaceUnder : 0,
      xAxisLabelSpaceAfter : 0,
      xAxisLabelSpaceBefore : 0,
      legendBordersSpaceBefore : 0,
      legendBordersSpaceAfter : 0,
      footNoteSpaceBefore : 0,
      footNoteSpaceAfter : 0,
      startAngle : 0,
      dynamicDisplay : true
}
var pm10 = {
      graphTitle : "PM10 Merenja",
      graphSubTitle : "SWAP-APM",
      footNote : "Footnote for the graph",
      yAxisLabel : "PM10 vrednosti",
      xAxisLabel : "Vreme merenja u satima",
      yAxisUnit : "µg/m3",
inGraphDataShow : false,
      datasetFill : true,
      scaleLabel: "<%=value%>",
      scaleTickSizeRight : 5,
      scaleTickSizeLeft : 5,
      scaleTickSizeBottom : 5,
      scaleTickSizeTop : 5,
      scaleFontSize : 16,
      canvasBorders : true,
      canvasBordersWidth : 3,
      canvasBordersColor : "black",
			graphTitleFontFamily : "'Arial'",
			graphTitleFontSize : 24,
			graphTitleFontStyle : "bold",
			graphTitleFontColor : "#666",
			graphSubTitleFontFamily : "'Arial'",
			graphSubTitleFontSize : 18,
			graphSubTitleFontStyle : "normal",
			graphSubTitleFontColor : "#666",
			footNoteFontFamily : "'Arial'",
			footNoteFontSize : 8,
			footNoteFontStyle : "bold",
			footNoteFontColor : "#666",
      legend : true,
	    legendFontFamily : "'Arial'",
	    legendFontSize : 12,
	    legendFontStyle : "normal",
	    legendFontColor : "#666",
      legendBlockSize : 15,
      legendBorders : true,
      legendBordersWidth : 1,
      legendBordersColors : "#666",
      yAxisLeft : true,
      yAxisRight : false,
      xAxisBottom : true,
      xAxisTop : false,
			yAxisFontFamily : "'Arial'",
			yAxisFontSize : 16,
			yAxisFontStyle : "normal",
			yAxisFontColor : "#666",
	 	  xAxisFontFamily : "'Arial'",
			xAxisFontSize : 16,
			xAxisFontStyle : "normal",
			xAxisFontColor : "#666",
			yAxisUnitFontFamily : "'Arial'",
			yAxisUnitFontSize : 8,
			yAxisUnitFontStyle : "normal",
			yAxisUnitFontColor : "#666",
      annotateDisplay : true,
      spaceTop : 0,
      spaceBottom : 0,
      spaceLeft : 0,
      spaceRight : 0,
      logarithmic: false,
//      showYAxisMin : false,
      rotateLabels : "smart",
      xAxisSpaceOver : 0,
      xAxisSpaceUnder : 0,
      xAxisLabelSpaceAfter : 0,
      xAxisLabelSpaceBefore : 0,
      legendBordersSpaceBefore : 0,
      legendBordersSpaceAfter : 0,
      footNoteSpaceBefore : 0,
      footNoteSpaceAfter : 0,
      startAngle : 0,
      dynamicDisplay : true
}
var pm25 = {
      graphTitle : "PM2.5 Merenja",
      graphSubTitle : "SWAP-APM",
      footNote : "Footnote for the graph",
      yAxisLabel : "PM2.5 vrednosti",
      xAxisLabel : "Vreme merenja u satima",
      yAxisUnit : "µg/m3",
inGraphDataShow : false,
      datasetFill : true,
      scaleLabel: "<%=value%>",
      scaleTickSizeRight : 5,
      scaleTickSizeLeft : 5,
      scaleTickSizeBottom : 5,
      scaleTickSizeTop : 5,
      scaleFontSize : 16,
      canvasBorders : true,
      canvasBordersWidth : 3,
      canvasBordersColor : "black",
			graphTitleFontFamily : "'Arial'",
			graphTitleFontSize : 24,
			graphTitleFontStyle : "bold",
			graphTitleFontColor : "#666",
			graphSubTitleFontFamily : "'Arial'",
			graphSubTitleFontSize : 18,
			graphSubTitleFontStyle : "normal",
			graphSubTitleFontColor : "#666",
			footNoteFontFamily : "'Arial'",
			footNoteFontSize : 8,
			footNoteFontStyle : "bold",
			footNoteFontColor : "#666",
      legend : true,
	    legendFontFamily : "'Arial'",
	    legendFontSize : 12,
	    legendFontStyle : "normal",
	    legendFontColor : "#666",
      legendBlockSize : 15,
      legendBorders : true,
      legendBordersWidth : 1,
      legendBordersColors : "#666",
      yAxisLeft : true,
      yAxisRight : false,
      xAxisBottom : true,
      xAxisTop : false,
			yAxisFontFamily : "'Arial'",
			yAxisFontSize : 16,
			yAxisFontStyle : "normal",
			yAxisFontColor : "#666",
	 	  xAxisFontFamily : "'Arial'",
			xAxisFontSize : 16,
			xAxisFontStyle : "normal",
			xAxisFontColor : "#666",
			yAxisUnitFontFamily : "'Arial'",
			yAxisUnitFontSize : 8,
			yAxisUnitFontStyle : "normal",
			yAxisUnitFontColor : "#666",
      annotateDisplay : true,
      spaceTop : 0,
      spaceBottom : 0,
      spaceLeft : 0,
      spaceRight : 0,
      logarithmic: false,
//      showYAxisMin : false,
      rotateLabels : "smart",
      xAxisSpaceOver : 0,
      xAxisSpaceUnder : 0,
      xAxisLabelSpaceAfter : 0,
      xAxisLabelSpaceBefore : 0,
      legendBordersSpaceBefore : 0,
      legendBordersSpaceAfter : 0,
      footNoteSpaceBefore : 0,
      footNoteSpaceAfter : 0,
      startAngle : 0,
      dynamicDisplay : true
}




	window.onload = function(){
		var ctx1 = document.getElementById("grafikon1").getContext("2d");
		window.myLine = new Chart(ctx1).Line(lineChartData1, so2);
	}
	</script>
		<?php
}
else if($_GET[action]=='add'&&$_SESSION[role]=='admin')
{
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
