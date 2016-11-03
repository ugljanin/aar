<?php
require_once("fns.php");
$conn=db_connect();
?>
    <script src="<?php echo ROOT;?>js/ChartNew.js"></script>
	<script>



	</script>
<h1>Merenja po stanicama i indeksi</h1>
<?php

	$sql="SELECT  DATE_FORMAT( datumdo, '%d/%m/%Y u %H sati' ) sat, MAX(
	CASE WHEN stanicaid = '1'
	AND komponentaid = '1'
	THEN vrednost
	END ) prva, MAX(
	CASE WHEN stanicaid = '2'
	AND komponentaid = '1'
	THEN vrednost
	END ) druga, MAX(
	CASE WHEN stanicaid = '3'
	AND komponentaid = '1'
	THEN vrednost
	END ) treca
	FROM vrednosti
	GROUP BY datumdo
	ORDER BY datumdo DESC limit 23";
	$result=mysqli_query($conn,$sql);

	while($podaci=mysqli_fetch_array($result,MYSQLI_ASSOC))
	{
			$datumi[]=$podaci[sat];
			$prvi[]=$podaci[prva];
			$drugi[]=$podaci[druga];
			if($podaci[treca]!='-999')
				$treci[]=$podaci[treca];
			else
				$treci[]=0;
	}
	?>
	<h2>SO2 merenja za poslednja 24 sata na tri merne stanice</h2>
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
					label: "Nis - Osnovna skola Sveti Sava",
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
				},
				{
					label: "Kamenicki vis",
					fillColor : "rgba(0,255,0,0.0)",
					strokeColor : "rgba(0,255,0,1)",
					pointColor : "rgba(0,255,0,1)",
					pointStrokeColor : "#fff",
					pointHighlightFill : "#fff",
					pointHighlightStroke : "rgba(0,255,0,1)",
					<?php
					$drugi = implode(",", $drugi);
					echo 'data:['.$drugi.']';
					?>
				},
				{
					label: "Nis - Institut za javno zdravlje",
					fillColor : "rgba(0,0,255,0.0)",
					strokeColor : "rgba(0,0,255,1)",
					pointColor : "rgba(0,0,255,1)",
					pointStrokeColor : "#fff",
					pointHighlightFill : "#fff",
					pointHighlightStroke : "rgba(0,0,255,1)",
					<?php
					$trecii = implode(",", $treci);
					echo 'data:['.$trecii.']';
					?>
				}
			]

		}
		</script>
		<?php
	$sql="SELECT DATE_FORMAT( datumdo, '%d/%m/%Y u %H sati' ) sat, MAX(
	CASE WHEN stanicaid = '1'
	AND komponentaid = '2'
	THEN vrednost
	END ) prva, MAX(
	CASE WHEN stanicaid = '2'
	AND komponentaid = '2'
	THEN vrednost
	END ) druga, MAX(
	CASE WHEN stanicaid = '3'
	AND komponentaid = '2'
	THEN vrednost
	END ) treca
	FROM vrednosti
	GROUP BY datumdo
	ORDER BY datumdo DESC limit 23";
	$result=mysqli_query($conn,$sql);
	while($podaci=mysqli_fetch_array($result,MYSQLI_ASSOC))
	{
			$datumi2[]=$podaci[sat];
			if($podaci[prva]!='-999')
				$prvi2[]=$podaci[prva];
			else
				$prvi2[]=0;

			if($podaci[druga]!='-999')
				$drugi2[]=$podaci[druga];
			else
				$drugi2[]=0;

			if($podaci[treca]!='-999')
				$treci2[]=$podaci[treca];
			else
				$treci2[]=0;
	}
	?>
	<h2>NO2 merenja za poslednjih 7 dana na tri merne stanice</h2>

	<script>
	      document.write("<canvas id=\"grafikon2\" height=\""+defCanvasHeight+"\" width=\""+defCanvasWidth+"\"></canvas>");

		var lineChartData2 = {
			<?php
			$sati2 = implode('","', $datumi2);
			echo 'labels:["'.$sati2.'"],';
			?>
			datasets : [
				{
					label: "Nis - Osnovna skola Sveti Sava",
					fillColor : "rgba(255,0,0,0.0)",
					strokeColor : "rgba(255,0,0,1)",
					pointColor : "rgba(255,0,0,1)",
					pointStrokeColor : "#fff",
					pointHighlightFill : "#fff",
					pointHighlightStroke : "rgba(255,0,0,1)",
					<?php
					$prvi2 = implode(",", $prvi2);
					echo 'data:['.$prvi2.']';
					?>
				},
				{
					label: "Kamenicki vis",
					fillColor : "rgba(0,255,0,0.0)",
					strokeColor : "rgba(0,255,0,1)",
					pointColor : "rgba(0,255,0,1)",
					pointStrokeColor : "#fff",
					pointHighlightFill : "#fff",
					pointHighlightStroke : "rgba(0,255,0,1)",
					<?php
					$drugi2 = implode(",", $drugi2);
					echo 'data:['.$drugi2.']';
					?>
				},
				{
					label: "Nis - Institut za javno zdravlje",
					fillColor : "rgba(0,0,255,0.0)",
					strokeColor : "rgba(0,0,255,1)",
					pointColor : "rgba(0,0,255,1)",
					pointStrokeColor : "#fff",
					pointHighlightFill : "#fff",
					pointHighlightStroke : "rgba(0,0,255,1)",
					<?php
					$treci2 = implode(",", $treci2);
					echo 'data:['.$treci2.']';
					?>
				}
			]

		}
		</script>

		<?php
	$sql="SELECT  DATE_FORMAT( datumdo, '%d/%m/%Y u %H sati' ) sat, MAX(
	CASE WHEN stanicaid = '1'
	AND komponentaid = '3'
	THEN vrednost
	END ) prva, MAX(
	CASE WHEN stanicaid = '2'
	AND komponentaid = '3'
	THEN vrednost
	END ) druga, MAX(
	CASE WHEN stanicaid = '3'
	AND komponentaid = '3'
	THEN vrednost
	END ) treca
	FROM vrednosti
	GROUP BY datumdo
	ORDER BY datumdo DESC limit 23";
	$result=mysqli_query($conn,$sql);

	while($podaci=mysqli_fetch_array($result,MYSQLI_ASSOC))
	{
			$datumi3[]=$podaci[sat];

			if($podaci[prva]!='-999')
				$prvi3[]=$podaci[prva]*1000;
			else
				$prvi3[]=0;

			if($podaci[druga]!='-999')
				$drugi3[]=$podaci[druga]*1000;
			else
				$drugi3[]=0;

			if($podaci[treca]!='-999')
				$treci3[]=$podaci[treca]*1000;
			else
				$treci3[]=0;
	}
	?>
	<h2>CO merenja za poslednja 24 sata na tri merne stanice</h2>

	<script>
	      document.write("<canvas id=\"grafikon3\" height=\""+defCanvasHeight+"\" width=\""+defCanvasWidth+"\"></canvas>");

		var lineChartData3 = {
			<?php
			$sati3 = implode('","', $datumi3);
			echo 'labels:["'.$sati3.'"],';
			?>
			datasets : [
				{
					label: "Nis - Osnovna skola Sveti Sava",
					fillColor : "rgba(255,0,0,0.0)",
					strokeColor : "rgba(255,0,0,1)",
					pointColor : "rgba(255,0,0,1)",
					pointStrokeColor : "#fff",
					pointHighlightFill : "#fff",
					pointHighlightStroke : "rgba(255,0,0,1)",
					<?php
					$prvi3 = implode(",", $prvi3);
					echo 'data:['.$prvi3.']';
					?>
				},
				{
					label: "Kamenicki vis",
					fillColor : "rgba(0,255,0,0.0)",
					strokeColor : "rgba(0,255,0,1)",
					pointColor : "rgba(0,255,0,1)",
					pointStrokeColor : "#fff",
					pointHighlightFill : "#fff",
					pointHighlightStroke : "rgba(0,255,0,1)",
					<?php
					$drugi3 = implode(",", $drugi3);
					echo 'data:['.$drugi3.']';
					?>
				},
				{
					label: "Nis - Institut za javno zdravlje",
					fillColor : "rgba(0,0,255,0.0)",
					strokeColor : "rgba(0,0,255,1)",
					pointColor : "rgba(0,0,255,1)",
					pointStrokeColor : "#fff",
					pointHighlightFill : "#fff",
					pointHighlightStroke : "rgba(0,0,255,1)",
					<?php
					$treci3 = implode(",", $treci3);
					echo 'data:['.$treci3.']';
					?>
				}
			]

		}
		</script>


		<?php
	$sql="SELECT  DATE_FORMAT( datumdo, '%d/%m/%Y u %H sati' ) sat, MAX(
	CASE WHEN stanicaid = '1'
	AND komponentaid = '4'
	THEN vrednost
	END ) prva, MAX(
	CASE WHEN stanicaid = '2'
	AND komponentaid = '4'
	THEN vrednost
	END ) druga, MAX(
	CASE WHEN stanicaid = '3'
	AND komponentaid = '4'
	THEN vrednost
	END ) treca
	FROM vrednosti
	GROUP BY datumdo
	ORDER BY datumdo DESC limit 23";
	$result=mysqli_query($conn,$sql);

	while($podaci=mysqli_fetch_array($result,MYSQLI_ASSOC))
	{
			$datumi4[]=$podaci[sat];
			if($podaci[prva]!='-999')
				$prvi4[]=$podaci[prva];
			else
				$prvi4[]=0;

			if($podaci[druga]!='-999')
				$drugi4[]=$podaci[druga];
			else
				$drugi4[]=0;

			if($podaci[treca]!='-999')
				$treci4[]=$podaci[treca];
			else
				$treci4[]=0;
	}
	?>
	<h2>O3 merenja za poslednja 24 sata na tri merne stanice</h2>

	<script>
	      document.write("<canvas id=\"grafikon4\" height=\""+defCanvasHeight+"\" width=\""+defCanvasWidth+"\"></canvas>");

		var lineChartData4 = {
			<?php
			$sati4 = implode('","', $datumi4);
			echo 'labels:["'.$sati4.'"],';
			?>
			datasets : [
				{
					label: "Nis - Osnovna skola Sveti Sava",
					fillColor : "rgba(255,0,0,0.0)",
					strokeColor : "rgba(255,0,0,1)",
					pointColor : "rgba(255,0,0,1)",
					pointStrokeColor : "#fff",
					pointHighlightFill : "#fff",
					pointHighlightStroke : "rgba(255,0,0,1)",
					<?php
					$prvi4tekst = implode(",", $prvi4);
					echo 'data:['.$prvi4tekst.']';
					?>
				},
				{
					label: "Kamenicki vis",
					fillColor : "rgba(0,255,0,0.0)",
					strokeColor : "rgba(0,255,0,1)",
					pointColor : "rgba(0,255,0,1)",
					pointStrokeColor : "#fff",
					pointHighlightFill : "#fff",
					pointHighlightStroke : "rgba(0,255,0,1)",
					<?php
					$drugi4tekst = implode(",", $drugi4);
					echo 'data:['.$drugi4tekst.']';
					?>
				},
				{
					label: "Nis - Institut za javno zdravlje",
					fillColor : "rgba(0,0,255,0.0)",
					strokeColor : "rgba(0,0,255,1)",
					pointColor : "rgba(0,0,255,1)",
					pointStrokeColor : "#fff",
					pointHighlightFill : "#fff",
					pointHighlightStroke : "rgba(0,0,255,1)",
					<?php
					$treci4tekst = implode(",", $treci4);
					echo 'data:['.$treci4tekst.']';
					?>
				}
			]

		}
		</script>

		<?php
	$sql="SELECT  DATE_FORMAT( datumdo, '%d/%m/%Y u %H sati' ) sat, MAX(
	CASE WHEN stanicaid = '1'
	AND komponentaid = '5'
	THEN vrednost
	END ) prva, MAX(
	CASE WHEN stanicaid = '2'
	AND komponentaid = '5'
	THEN vrednost
	END ) druga, MAX(
	CASE WHEN stanicaid = '3'
	AND komponentaid = '5'
	THEN vrednost
	END ) treca
	FROM vrednosti
	GROUP BY datumdo
	ORDER BY datumdo DESC limit 23";
	$result=mysqli_query($conn,$sql);
	while($podaci=mysqli_fetch_array($result,MYSQLI_ASSOC))
	{
			$datumi5[]=$podaci[sat];
			if($podaci[druga]!='-999')
				$prvi5[]=$podaci[druga];
			else
				$prvi5[]=0;
		if($podaci[druga]!='-999')
				$drugi5[]=$podaci[druga];
			else
				$drugi5[]=0;
			if($podaci[treca]!='-999')
				$treci5[]=$podaci[treca];
			else
				$treci5[]=0;
	}
	?>
	<h2>PM10 merenja za poslednja 23 sata na tri merne stanice</h2>

	<script>
	      document.write("<canvas id=\"grafikon5\" height=\""+defCanvasHeight+"\" width=\""+defCanvasWidth+"\"></canvas>");

		var lineChartData5 = {
			<?php
			$sati5 = implode('","', $datumi5);
			echo 'labels:["'.$sati5.'"],';
			?>
			datasets : [
				{
					label: "Nis - Osnovna skola Sveti Sava",
					fillColor : "rgba(255,0,0,0.0)",
					strokeColor : "rgba(255,0,0,1)",
					pointColor : "rgba(255,0,0,1)",
					pointStrokeColor : "#fff",
					pointHighlightFill : "#fff",
					pointHighlightStroke : "rgba(255,0,0,1)",
					<?php
					$prvi5 = implode(",", $prvi5);
					echo 'data:['.$prvi5.']';
					?>
				},
				{
					label: "Kamenicki vis",
					fillColor : "rgba(0,255,0,0.0)",
					strokeColor : "rgba(0,255,0,1)",
					pointColor : "rgba(0,255,0,1)",
					pointStrokeColor : "#fff",
					pointHighlightFill : "#fff",
					pointHighlightStroke : "rgba(0,255,0,1)",
					<?php
					$drugi5 = implode(",", $drugi5);
					echo 'data:['.$drugi5.']';
					?>
				},
				{
					label: "Nis - Institut za javno zdravlje",
					fillColor : "rgba(0,0,255,0.0)",
					strokeColor : "rgba(0,0,255,1)",
					pointColor : "rgba(0,0,255,1)",
					pointStrokeColor : "#fff",
					pointHighlightFill : "#fff",
					pointHighlightStroke : "rgba(0,0,255,1)",
					<?php
					$treci5 = implode(",", $treci5);
					echo 'data:['.$treci5.']';
					?>
				}
			]

		}
		</script>

		<?php
	$sql="SELECT  DATE_FORMAT( datumdo, '%d/%m/%Y u %H sati' ) sat, MAX(
	CASE WHEN stanicaid = '1'
	AND komponentaid = '6'
	THEN vrednost
	END ) prva, MAX(
	CASE WHEN stanicaid = '2'
	AND komponentaid = '6'
	THEN vrednost
	END ) druga, MAX(
	CASE WHEN stanicaid = '3'
	AND komponentaid = '6'
	THEN vrednost
	END ) treca
	FROM vrednosti
	GROUP BY datumdo
	ORDER BY datumdo DESC limit 23";
	$result=mysqli_query($conn,$sql);
	while($podaci=mysqli_fetch_array($result,MYSQLI_ASSOC))
	{
			$datumi6[]=$podaci[sat];
			if($podaci[druga]!='-999')
				$prvi6[]=$podaci[druga];
			else
				$prvi6[]=0;
			if($podaci[druga]!='-999')
				$drugi6[]=$podaci[druga];
			else
				$drugi6[]=0;
			if($podaci[treca]!='-999')
				$treci6[]=$podaci[treca];
			else
				$treci6[]=0;
	}
	?>
	<h2>PM2.5 merenja za poslednja 23 sata na tri merne stanice</h2>

	<script>
	      document.write("<canvas id=\"grafikon6\" height=\""+defCanvasHeight+"\" width=\""+defCanvasWidth+"\"></canvas>");

		var lineChartData6 = {
			<?php
			$sati6 = implode('","', $datumi6);
			echo 'labels:["'.$sati6.'"],';
			?>
			datasets : [
				{
					label: "Nis - Osnovna skola Sveti Sava",
					fillColor : "rgba(255,0,0,0.0)",
					strokeColor : "rgba(255,0,0,1)",
					pointColor : "rgba(255,0,0,1)",
					pointStrokeColor : "#fff",
					pointHighlightFill : "#fff",
					pointHighlightStroke : "rgba(255,0,0,1)",
					<?php
					$prvi6 = implode(",", $prvi6);
					echo 'data:['.$prvi5.']';
					?>
				},
				{
					label: "Kamenicki vis",
					fillColor : "rgba(0,255,0,0.0)",
					strokeColor : "rgba(0,255,0,1)",
					pointColor : "rgba(0,255,0,1)",
					pointStrokeColor : "#fff",
					pointHighlightFill : "#fff",
					pointHighlightStroke : "rgba(0,255,0,1)",
					<?php
					$drugi6 = implode(",", $drugi6);
					echo 'data:['.$drugi6.']';
					?>
				},
				{
					label: "Nis - Institut za javno zdravlje",
					fillColor : "rgba(0,0,255,0.0)",
					strokeColor : "rgba(0,0,255,1)",
					pointColor : "rgba(0,0,255,1)",
					pointStrokeColor : "#fff",
					pointHighlightFill : "#fff",
					pointHighlightStroke : "rgba(0,0,255,1)",
					<?php
					$treci6 = implode(",", $treci6);
					echo 'data:['.$treci6.']';
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

		var ctx2 = document.getElementById("grafikon2").getContext("2d");
		window.myLine = new Chart(ctx2).Line(lineChartData2, no2);

		var ctx3 = document.getElementById("grafikon3").getContext("2d");
		window.myLine = new Chart(ctx3).Line(lineChartData3, co);

		var ctx4 = document.getElementById("grafikon4").getContext("2d");
		window.myLine = new Chart(ctx4).Line(lineChartData4, o3);

		var ctx5 = document.getElementById("grafikon5").getContext("2d");
		window.myLine = new Chart(ctx5).Line(lineChartData5,  pm10);

		var ctx6 = document.getElementById("grafikon6").getContext("2d");
		window.myLine = new Chart(ctx6).Line(lineChartData6,  pm25);


	}
	</script>
	<?php
?>
