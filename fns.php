<?php
session_start(); // ready to go!
$now = time();
if (isset($_SESSION['expire']) && $now > $_SESSION['expire']) {
    // this session has worn out its welcome; kill it and start a brand new one
    session_unset();
    session_destroy();
    session_start();
}
if ($_SESSION["messagetype"] != "" && $_SESSION["message"] != "" ) {
    $ERROR_TYPE = $_SESSION["messagetype"];
    $ERROR_MSG = $_SESSION["message"];
    $_SESSION["messagetype"] = "";
    $_SESSION["message"] = "";
}
define("Functions", true);
require_once("db_fns.php");
require_once("functions.php");


?>
