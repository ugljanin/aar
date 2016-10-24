<?php
include("fns.php");
date_default_timezone_set('UTC');

$title="Users";
include "header.php";
if($_GET[action]=='list'&&$_SESSION[role]=='admin')
{
	?>
<a href="users.php?action=create" class="btn btn-primary" role="button">Create new user</a>
<div class="container">
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Username</th>
        <th>Password</th>
        <th>Status</th>
        <th>Role</th>
      </tr>
    </thead>
    <tbody>


<?php
$sql="select * from users";
$result=mysqli_query($conn,$sql);
while($users=mysqli_fetch_array($result,MYSQLI_ASSOC))
{
	echo '<tr>';
	echo '<td>'.$users[username].'</td>';
	echo '<td>'.$users[passwd].'</td>';
	echo '<td>'.$users[status].'</td>';
	echo '<td>'.$users[role].'</td>';
	echo '<td><a href="#">Edit</a></td>';
	echo '</tr>';
}
			?>
		</tbody>
  </table>
</div>
			<?php
}
else if($_GET[action]=='create'&&$_SESSION[role]=='admin')
{
	?>
 <form class="form-horizontal" role="form" action="users.php?action=created" method="post">
  <div class="form-group">
    <label class="control-label col-sm-2" for="username">Username:</label>
    <div class="col-sm-10">
      <input type="username" class="form-control" name="username" id="username" placeholder="Enter username">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="pwd">Password:</label>
    <div class="col-sm-10">
      <input type="password" name="password" class="form-control" id="pwd" placeholder="Enter password">
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
			<label class="radio-inline"><input type="radio" name="status" value="Active" checked>Active</label>
			<label class="radio-inline"><input type="radio" name="status" value="Blocked">Blocked</label>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
			<label class="radio-inline"><input type="radio" name="role" value="admin">Admin</label>
			<label class="radio-inline"><input type="radio" name="role" value="doctor" checked>Doctor</label>
			<label class="radio-inline"><input type="radio" name="role" value="nurse" checked>Nurse</label>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default">Submit</button>
    </div>
  </div>
</form>
			<?php
}
else if($_GET[action]=='created'&&$_SESSION[role]=='admin')
{
	$username=$_POST[username];
	$status=$_POST[status];
	$role=$_POST[role];
	$password=$_POST[password];
	$sql="insert into users (username,passwd,status,role) values ('".$username."','".$password."','".$status."','".$role."')";
	$result=mysqli_query($conn,$sql);


	if($result)
	{
		echo 'User is created';

			$_SESSION["messagetype"] = "success";
			$_SESSION["message"] = "User is created";
			redirect('users.php?action=list');
	}
	else
	{
		echo 'User is not created';

			$_SESSION["messagetype"] = "danger";
			$_SESSION["message"] = "User is not created";
			redirect('users.php?action=list');
	}
}
include "footer.php";
?>
