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
								if($gateway[status]=='Active')
								echo '<td><a href="gateways.php?action=add&gatewayid='.$gateway[gatewayid].'">Edit</a> | <a href="gateway.php?action=add&gatewayid='.$gateway[gatewayid].'">Delete</a></td>';
								else
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
	$location=$_SESSION[location];
	$date=date('Y-m-d H:s:i',time());


	if($_POST[gatewayid]!=''||!empty($_POST[gatewayid]))
	{

		$gatewayid=$_POST[gatewayid];

		$sql="update gateway
		set name='".$name."',
				accesstoken='".$accesstoken."',
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
		$sql="insert into gateway (name, accesstoken, location, status) values ('".$name."','".$accesstoken."','".$location."','".$status."')";
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
