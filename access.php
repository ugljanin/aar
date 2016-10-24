<?php
include("db_fns.php");
$conn=db_connect();

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Maintain Restrictions over Social Actions</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
		<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600&subset=latin,latin-ext' rel='stylesheet' type='text/css'>

    <!-- Custom styles for this template -->
    <link href="css/dashboard.css" rel="stylesheet">
    <link href="css/bootstrap-datetimepicker.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="js/ie8-responsive-file-warning.js"></script><![endif]-->
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Controling system</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#">Home</a></li>
            <li><a href="#">Login</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
			<li><a href="http://social.connect.rs/"><i class="fa fa-user"></i> Maintain Restriction</a></li>
			<li class="active"><a href="http://social.connect.rs/access.php?action=list"><i class="fa fa-users"></i> Access logs</a></li>
			<li><a href="http://social.connect.rs/messages.php?action=list"><i class="fa fa-weixin"></i> Messages logs</a></li>
<?php/*
			<li><a href="#"><i class="fa fa-calendar"></i> Schedule events</a></li>
            <li><a href="#"><i class="fa fa-area-chart"></i> Analytics</a></li>
            <li><a href="#"><i class="fa fa-envelope"></i> Subscribe</a></li>
            <li><a href="#"><i class="fa fa-exclamation-triangle"></i> Warning</a></li>
			*/
			?>
          </ul>

        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

			<?php
			if($_GET[action]=='list')
			{
				?>
			<h1 class="page-header">Hangout session access logs</h1>
			<table id="restrictionaction" class="table">
			<tbody>
			<?php
				$sqlj="SELECT *  FROM log GROUP BY hangoutid order by logid desc";
				$resultj=mysqli_query($conn,$sqlj);
				$ukupno=mysqli_num_rows($resultj);
				$idd=0;
				while($restrictiona=mysqli_fetch_array($resultj,MYSQLI_ASSOC))
				{
					echo '<tr id="ord'.$idd.'" class="timeframe">';
					echo '<td><a href="access.php?action=show&hangoutid='.$restrictiona[hangoutid].'">Initiated by <strong>'.$restrictiona[user].':</strong> ';

					echo 'Hangoutid: '.$restrictiona[hangoutid].', ';
					echo $restrictiona[date];
					echo '</a><td>';
					echo '<tr>';
				}
			}
			else if($_GET[action]=='show')
			{
				?>
			<h1 class="page-header">Access logs</h1>
			<table id="restrictionaction" class="table">
			<tbody>
			<?php
				$hangoutid=$_GET[hangoutid];
				$sqlj="select * from log where hangoutid='$hangoutid' order by logid asc";
				$resultj=mysqli_query($conn,$sqlj);
				$ukupno=mysqli_num_rows($resultj);
				$idd=0;
				while($restrictiona=mysqli_fetch_array($resultj,MYSQLI_ASSOC))
				{
					echo '<tr id="ord'.$idd.'" class="timeframe">';
					echo '<td><strong>'.$restrictiona[user].':</strong> ';
					echo $restrictiona[action].', ';
					echo $restrictiona[date];
					echo '<td>';
					echo '<tr>';
				}
			}

			?>

				</tbody>
			  </table>


        </div>
      </div>
    </div>
	<style>
	.form-horizontal .form-group {
    margin-right: 0px;
    margin-left: 0px;
}
	</style>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <script src="js/moment.min.js"></script>
    <script src="js/bootstrap-datetimepicker.js"></script>
	<script>


	$(function () {
		var srednjatemplate = $("#restrictionaction .timeframe:first").clone();
		var srednjaCount = <?php echo $ukupno;?>;


		$(".action").on( "change", function(e)
		{
			if($(this).val()=='allday')
			{
				$(this).parent().next().next().next().find( ".timefrom" ).val("00:00") ;
				$(this).parent().next().next().next().next().find( ".timeto" ).val("23:59") ;
			}
		})

		$('body').on('change',".action", function(){
			if($(this).val()=='allday')
			{
				$(this).parent().next().next().next().find( ".timefrom" ).val("00:00") ;
				$(this).parent().next().next().next().next().find( ".timeto" ).val("23:59") ;
			}
		})

		$(".remove").on( "click", function(e)
		{
			e.preventDefault();
			$(this).closest("tr").remove();
		})

		$(".addtime").on( "click", function(event) {

			srednjaCount++;
			var order = srednjatemplate.clone().find("*").each(function(){
				var newId = this.id.substring(0, this.id.length-1) + srednjaCount;

				if(this.name!=undefined)
				{
					var ime="restrictionaction["+srednjaCount+this.name.substring(19,this.name.length);
					this.name = ime;
					this.value = '';
				}
				if($(this).attr("id"))
				{
					this.id = newId; // update id
				}
				if($(this).parent().prev().attr("for"))
				{
					$(this).parent().prev().attr("for", newId); // update label for
				}

			}).end()
			.attr("id", "ord" + srednjaCount)
			.appendTo("#restrictionaction");
			return false;
		});

		$('body').on('mouseover',".datetimepicker6", function(){
			$(this).datetimepicker({
					format:'YYYY-MM-DD'
				});
		})
		$('body').on('mouseover',".datetimepicker7", function(){
			$(this).datetimepicker({
					format:'YYYY-MM-DD'
				});
		})
		$('body').on('mouseover',".datetimepicker3", function(){
			$(this).datetimepicker({
					format:'HH:ss'
				});
		})
		$('body').on('mouseover',".datetimepicker4", function(){
			$(this).datetimepicker({
					format:'HH:ss'
				});
		})
		$('body').on('click',".remove", function(){

			$(this).closest("tr").remove();
			return false;

		})

				$('.datetimepicker6').datetimepicker(
				{
					format:'YYYY-MM-DD'
				});
				$('.datetimepicker7').datetimepicker({
					format:'YYYY-MM-DD',
					useCurrent: false //Important! See issue #1075
				});

				$('.datetimepicker3').datetimepicker(
				{
					format:'HH:ss'
				});
				$('.datetimepicker4').datetimepicker({
					format:'HH:ss',
					useCurrent: false //Important! See issue #1075
				});


            });
	</script>
  </body>
</html>
