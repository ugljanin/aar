<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Login</title>

                <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/bootstrap-reset.css" rel="stylesheet">

        <link href="css/font-awesome.css" rel="stylesheet">
        <!--Animation css-->
        <link href="css/animate.css" rel="stylesheet">


        <!-- Custom styles for this template -->
        <link href="css/style.css" rel="stylesheet">

<script type="text/javascript" src="js/jquery-1.10.1.js"></script>


    </head>
    <body>

        <div class="wrapper-page animated fadeInDown">

            <div class="panel panel-color panel-primary">
                <div class="panel-heading">
                   <h3 class="text-center m-t-10"> Resources <strong>project</strong> </h3>
                </div>
<?php if ($ERROR_MSG <> "")
		{
		?>

				<div class="fadeInUp animated nicescroll alert alert-dismissable alert-<?php echo $ERROR_TYPE ?>">
					<button data-dismiss="alert" class="close" type="button">x</button>
					<p><?php echo $ERROR_MSG; ?></p>
				</div>

		<?php
		}
		?>
