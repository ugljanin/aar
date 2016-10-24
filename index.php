<?php
session_start();
require_once("fns.php");


if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
	$ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
	$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
	$ip = $_SERVER['REMOTE_ADDR'];
}

$user=$_SESSION[user];


$datum=date('Y-m-d H:i:s',time());
$time=time();
$expired=$time-1800;

$_SESSION['expire'] = $time + 28800;

if (isset($_SESSION["user_id"]) && $_SESSION["user_id"] != "") {
    // if logged in send to dashboard page
    if($_SESSION['ulogakod']=='USER')
		redirect("dashboard.php");
	else
		redirect("dashboard.php");
}

$title = "Login";
$action = $_REQUEST["action"];

if ($action == "login"&&!empty($_POST['user'])&&!empty($_POST['passwd'])) {

    $pass = trim(mysqli_real_escape_string($conn,$_POST['passwd']));

	if(preg_match("/^[a-z]+$/", strtolower($_POST['user'])) == 1) {
        $user = trim(mysqli_real_escape_string($conn,$_POST['user']));
	}
	else
	{
			$_SESSION["messagetype"] = "danger";
			$_SESSION["message"] = "Uneli ste nedozvoljene karaktere";

			redirect("index.php");
			exit();
	}

    if ($user == "" || $pass == "") {

        $_SESSION["messagetype"] = "danger";
        $_SESSION["message"] = "Niste popunili sva polja";
    }
	else {
		$sqllog1="select * from log where sesid='".session_id()."' and ip='".$ip."' and status=0 and time>".$expired."";
		$resullog1=mysqli_query($conn,$sqllog1);
		$num=mysqli_num_rows($resullog1);


		$sql="select * from users where username='$user'";

		$result=mysqli_query($conn,$sql);

		$korisnik=mysqli_fetch_array($result,MYSQLI_ASSOC);

		if($korisnik[status]=='Blokiran')
		{
			include "header-login.php";
			$_SESSION["messagetype"] = "danger";
			$_SESSION["message"] = "Nemate pravo da pristupite sistemu, obratite se administratoru.";
			redirect("index.php");
			exit();
		}


			$num=mysqli_num_rows($result);

			if($num=='0')//ako nema tog korisnika
			{
				$sqllog="insert into log (datum,user,ip,time,status,sesid,description) values ('".$datum."','".$korisnik[user]."','".$ip."','".$time."',0,'".session_id()."','Greska pri logovanju, korisnik ".$korisnik[user]." ne postoji')";
				$resultlog=mysqli_query($conn,$sqllog);

				$_SESSION["messagetype"] = "danger";
				$_SESSION["message"] = "Username is not correct";
			}
			else//ako ima korisnika proveri sifru
			{
				//ako je blokiran korisnik
				if($korisnik[status]=='Blocked')//ako nema tog korisnika
				{
					echo 'You are blocked, please contact administrator';
				}

					$sql1="select * from users where username='$user' and passwd='$pass' and status='Active'";



					$result1=mysqli_query($conn,$sql1);
					$num=mysqli_num_rows($result1);
					if($num!='0')//ako je ispravna sifra
					{
						session_regenerate_id();

						$sqllog="insert into log (datum,user,ip,time,status,sesid,description) values ('".$datum."','".$korisnik[user]."','".$ip."','".$time."',1,'".session_id()."','Uspesno logovanje')";
						$resultlog=mysqli_query($conn,$sqllog);

						$_SESSION["messagetype"] = "success";
						$_SESSION["message"] = "You are logged in!";
						include "header-login.php";
						echo "<h1>You are logged in!</h1>";

						//kreiraj novu sesiju

						$_SESSION["user_id"] = $korisnik["userid"];
						$_SESSION["role"] = $korisnik["role"];
						$_SESSION["user"] = $korisnik["username"];

						//pocinje deo za logovanje
						if (!isset($_SESSION["user_id"]) || $_SESSION["user_id"] == "") {
							// not logged in send to login page
							redirect("index.php");
						}

						//zavrsava se deo za logovanje
						if($_SESSION['ulogakod']=='USER')
							redirect("dashboard.php");
						else
							redirect("dashboard.php");

					}
					else//ako nije ispravna sifra
					{

						$_SESSION["messagetype"] = "danger";
						$_SESSION["message"] = "Username or password is not correct";
						echo "Username or password is not correct!";
					}
				}
			}
			redirect("index.php");

    }

	include "header-login.php";
?>
        <form class="form-horizontal" method="post" action="">
            <input type="hidden" name="action" value="login" >

				<div class="form-group">
					<div class="col-lg-12">
						<input type="text" value="" placeholder="Enter username" id="user" class="form-control" name="user" required="" >
					</div>

				</div>

                <div class="form-group">
						<div class="col-lg-12">
							<input type="password" value="" placeholder="Enter password" id="passwd" class="form-control" name="passwd" required="" >
						</div>
                </div>


                <div class="form-group">
                    <div class="col-lg-12">
                        <button class="btn btn-primary" type="submit">Log in</button>
                    </div>
                </div>
        </form>

<?php include 'footer-login.php'; ?>
