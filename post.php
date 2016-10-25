<?php

$results = print_r($_POST, true);
$myfile = fopen("post.txt", "w") or die("Unable to open file!");
fwrite($myfile, $results);
fclose($myfile);
?>
