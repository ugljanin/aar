<?php
include("fns.php");

//date_default_timezone_set('UTC');

$title="Reports";
include "header.php";

$conn=db_connect();
$time=time();
$timedate=date('Y-m-d H:s:i',$time);

if($_GET[action]=='list')
{

?>
<a href="report.php?action=add" class="btn btn-primary" role="button">Create new report</a>
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
						<th>Status</th>
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				<tr>
				<?php

						if($_SESSION[role]=='doctor')
						{
							$sql="select report.title,report.reportid,gateways.name as gateway, report.description, report.creationdate, report.changedate, report.status, users.username
							from report, users, gateways
							where users.userid=report.userid
							and report.gatewayid=gateways.gatewayid
							and users.userid='$_SESSION[user_id]' order by report.reportid desc";

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
								echo '<td>'.$report[status].'</td>';
								if($report[status]=='Draft')
								echo '<td><a href="report.php?action=add&reportid='.$report[reportid].'">Edit</a> | <a href="report.php?action=add&reportid='.$report[reportid].'">Delete</a></td>';
								else
									echo '<td></td>';
								echo '</tr>';
							}
						}
	else if($_SESSION[role]=='nurse')
	{
						$sql="select report.title,report.reportid, gateways.name as gateway, report.description, report.creationdate, report.changedate, report.status, users.username from report, users, gateways
							where users.userid=report.userid
							and report.gatewayid=gateways.gatewayid
							and report.status='Finished' order by report.reportid desc";

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
								echo '<td>'.$report[status].'</td>';
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
else if($_GET[action]=='add'&&$_SESSION[role]=='doctor')
{
	if($_GET[reportid]!=''||!empty($_GET[reportid]))
	{
		$reportid=$_GET[reportid];
		$sql="select report.title,report.reportid, report.description, report.creationdate, report.changedate, report.status, users.username from report, users
		where users.userid=report.userid
		and report.userid='$_SESSION[user_id]'
		and report.reportid='$reportid'";
		$result=mysqli_query($conn,$sql);
		$report=mysqli_fetch_array($result,MYSQLI_ASSOC);
	}

	?>
	<div class="row">
			<div class="col-sm-12">
				<h2>Patients report</h2>
				 <form action="report.php?action=submit" method="post">
				 <input type="hidden" name="reportid" value="<?php echo $report[reportid];?>">
					<div class="form-group">
						<label for="title">Title:</label>
						<input type="text" class="form-control" name="title" id="title" value="<?php echo $report[title];?>">
					</div>
					<div class="form-group">
						<label for="description">Description:</label>
						<textarea class="form-control" name="description" id="description"><?php echo $report[description];?></textarea>
					</div>
					<div class="form-group">
						<label for="gatewayid">Patient:</label>
						<select class="form-control" name="gatewayid" id="gatewayid">
						<?php
						$sqlg="select * from gateways";
						$resultg=mysqli_query($conn,$sqlg);
						while($gateway=mysqli_fetch_array($resultg,MYSQLI_ASSOC))
						{
							echo '<option value="'.$gateway[gatewayid].'"';
							if($report[gatewayid]==$gateway[gatewayid])
								echo ' selected';
							echo '>';
							echo $gateway[name];
							echo '</option>';
						}
						?>
						</select>
					</div>
					<div class="form-group">
						<label for="status">Status:</label>
						<select class="form-control" name="status" id="status">
							<option value="Draft" <?php if($report[status]=='Draft') echo 'selected';?>>Draft</option>
							<option value="Finished" <?php if($report[status]=='Finished') echo 'selected';?>>Finished</option>
						</select>
					</div>
					<button type="submit" class="btn btn-default">Submit</button>
				</form>
			</div>
	</div>
			<?php
}
else if($_GET[action]=='submit'&&$_SESSION[role]=='doctor')
{
	$description=$_POST[description];
	$gatewayid=$_POST[gatewayid];
	$title=$_POST[title];
	$status=$_POST[status];
	$userid=$_SESSION[user_id];
	$date=date('Y-m-d H:s:i',time());


	if($_POST[reportid]!=''||!empty($_POST[reportid]))
	{

		$reportid=$_POST[reportid];

		$sql="update report
		set title='".$title."',
				description='".$description."',
				gatewayid='".$gatewayid."',
				changedate='".$date."',
				status='".$status."'
				where reportid='".$reportid."'";
		$result=mysqli_query($conn,$sql);

		if($result)
		{
			$_SESSION["messagetype"] = "success";
			$_SESSION["message"] = "Report is changed";
			echo "Report is changed!";

		}
		else
		{
			$_SESSION["messagetype"] = "danger";
			$_SESSION["message"] = "Report is not changed";
			echo "Report is not changed!";
		}
	}
	else
	{
		$sql="insert into report (title, description, creationdate, changedate, userid, status,gatewayid) values ('".$title."','".$description."','".$date."','".$date."','".$userid."','".$status."','".$gatewayid."')";
		$result=mysqli_query($conn,$sql);

		if($result)
		{
			$_SESSION["messagetype"] = "success";
			$_SESSION["message"] = "Report is added";
			echo "Report is added!";

		}
		else
		{
			$_SESSION["messagetype"] = "danger";
			$_SESSION["message"] = "Report is not added";
			echo "Report is not added!";
		}
	}

	redirect("report.php?action=list");
}





include "footer.php";
?>
