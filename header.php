<?php
//$filename=basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
$filename=basename($_SERVER['PHP_SELF']);
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

    <title><?php echo $title;?></title>

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
          <a class="navbar-brand" href="#">aaR* Framework</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
          	<?php
           	if($_SESSION[role]=='admin')
						{
							?>
							<li <?php if($filename=='users.php') echo ' class="active"';?>><a href="users.php?action=list"><i class="fa fa-user"></i> Users</a></li>
							<li <?php if($filename=='access-token.php') echo ' class="active"';?>><a href="access-token.php?action=list"><i class="fa fa-cog"></i> User access token</a></li>
							<li <?php if($filename=='gateways.php') echo ' class="active"';?>><a href="gateways.php?action=list"><i class="fa fa-cog"></i> Gateways</a></li>
							<?php
						}
						else if($_SESSION[role]=='doctor')
						{
							?>
							<li <?php if($filename=='dashboard.php') echo ' class="active"';?>><a href="dashboard.php"><i class="fa fa-tachometer"></i> Dashboard</a></li>
							<li <?php if($filename=='access-token.php') echo ' class="active"';?>><a href="access-token.php?action=list"><i class="fa fa-cloud"></i> Access token</a></li>
							<li <?php if($filename=='patient.php') echo ' class="active"';?>><a href="report.php?action=list"><i class="fa fa-book"></i> Report</a></li>
							<?php

						}
						else if($_SESSION[role]=='nurse')
						{
							?>

							<li <?php if($filename=='dashboard.php') echo ' class="active"';?>><a href="dashboard.php"><i class="fa fa-tachometer"></i> Dashboard</a></li>
							<li <?php if($filename=='patient.php') echo ' class="active"';?>><a href="report.php?action=list"><i class="fa fa-book"></i> Report</a></li>
							<?php

						}
						?>
            <li><a href="#">Home</a></li>
            <li><a href="logout.php">Logout</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-12 main">

<h1 class="page-header"><?php echo $title;?></h1>
        <?php
				//echo '<pre>';
				//print_r($_SESSION);
				//echo '</pre>';
			 if ($ERROR_MSG <> "")
		{
		?>

				<div class="fadeInUp animated nicescroll alert alert-dismissable alert-<?php echo $ERROR_TYPE ?>">
					<button data-dismiss="alert" class="close" type="button">x</button>
					<p><?php echo $ERROR_MSG; ?></p>
				</div>

		<?php
		}
		?>
