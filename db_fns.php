<?php
function db_connect()
{
	$dsn=getenv('MYSQL_DSN');
	$user=getenv('MYSQL_USER');
	$password=getenv('MYSQL_PASSWORD');

	//$result=new mysqli('localhost','root','zakaria','baza','3306','/cloudsql/datahouse');
	$result=new mysqli(null,'root','zakaria','baza',null,'/cloudsql/aar-framework:europe-west1:datahouse');

	if(!$result)
		return false;
	else
	{
		$result->set_charset("utf8");
		$result->query("SET timezone = 'GMT'");
		return $result;
	}
}

function db_result_to_array($result) //pravi niz
{
   $res_array = array();

   for ($count=0; $row = @mysqli_fetch_array($result,MYSQLI_ASSOC); $count++)
     $res_array[$count] = $row;

   return $res_array;
}
$conn=db_connect();
if (mysqli_connect_errno())
{
	echo "Database connection error";
	exit;
}

?>
