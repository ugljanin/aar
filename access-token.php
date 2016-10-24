<?php
include("fns.php");
date_default_timezone_set('UTC');

$title="Access token";
include "header.php";
if($_GET[action]=='list'&&$_SESSION[role]=='doctor')
{
	?>
	<div class="container">
		 <a href="access-token.php?action=create" class="btn btn-primary" role="button">Create new access token</a>
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Access token</th>
					<th>Session id</th>
					<th>Created</th>
					<th>Expiring</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$sql="select * from accesstokens where userid='$_SESSION[user_id]'";
				$result=mysqli_query($conn,$sql);
				$num=mysqli_num_rows($result);
				if($num=='0')
				{
					echo '<tr><td colspan="4">There is no history of created access tokens for you</td></tr>';
				}
				else
				{
					while($users=mysqli_fetch_array($result,MYSQLI_ASSOC))
					{
						echo '<tr>';
						echo '<td>'.$users[accesstoken].'</td>';
						echo '<td>'.$users[sesid].'</td>';
						echo '<td>'.$users[created].'</td>';
						echo '<td>'.$users[expiring].'</td>';
						echo '</tr>';
					}
				}
				?>
			</tbody>
		</table>
	</div>
	<?php
}
else if($_GET[action]=='list'&&$_SESSION[role]=='admin')
{
	?>
	<div class="container">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>User</th>
					<th>Access token</th>
					<th>Session id</th>
					<th>Created</th>
					<th>Expiring</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$sql="select accesstokens.created, accesstokens.expiring, accesstokens.sesid, accesstokens.accesstoken, users.username
				from accesstokens, users
				where accesstokens.userid=users.userid";
				$result=mysqli_query($conn,$sql);
				$num=mysqli_num_rows($result);
				if($num=='0')
				{
					echo '<tr><td colspan="4">There is no history of created access tokens</td></tr>';
				}
				else
				{
					while($users=mysqli_fetch_array($result,MYSQLI_ASSOC))
					{
						echo '<tr>';
						echo '<td>'.$users[username].'</td>';
						echo '<td>'.$users[accesstoken].'</td>';
						echo '<td>'.$users[sesid].'</td>';
						echo '<td>'.$users[created].'</td>';
						echo '<td>'.$users[expiring].'</td>';
						//echo '<td><a href="access-token.php?action=create" class="btn btn-lg btn-primary">Renew</a></td>';
						echo '</tr>';
					}
				}
				?>
			</tbody>
		</table>
	</div>
	<?php
}
else if($_GET[action]=='create'&&$_SESSION[role]=='doctor')
{
	$sesid=session_id();
	$accesstoken=uniqid();
	$time=time();
	$exptime=$time+86400*30;
	$created=date('Y-m-d H:i:s',$time);
	$expiring=date('Y-m-d H:i:s',$exptime);

	$sqls="select * from accesstokens where userid='".$_SESSION[user_id]."' and expiring>'$created'";

	$results=mysqli_query($conn,$sqls);
	if(mysqli_num_rows($results)==0)
	{
		$sql="insert into accesstokens (userid,sesid,accesstoken,created,expiring) values ('".$_SESSION[user_id]."','".$sesid."','".$accesstoken."','".$created."','".$expiring."')";
		$result=mysqli_query($conn,$sql);
		if($result)
		{
			echo 'Success';

			$_SESSION["messagetype"] = "success";
			$_SESSION["message"] = "Success";
			redirect('access-token.php?action=list');
		}
		else
		{
			echo 'Error';

			$_SESSION["messagetype"] = "danger";
			$_SESSION["message"] = "Error";
			redirect('access-token.php?action=list');
		}
	}
	else
	{
		echo 'There is one valid access token which you should use';

		$_SESSION["messagetype"] = "danger";
		$_SESSION["message"] = "There is one valid access token which you should use";
		redirect('access-token.php?action=list');
	}


}
include "footer.php";
?>
