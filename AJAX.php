<?php
ini_set('display_errors', '1');
error_reporting(-1);

date_default_timezone_set('UTC');

$sl = mt_rand(0, 1000000);
usleep($sl);

echo $sl;

$output = "";
$output.= str_repeat($sl, mt_rand(1, 10));
$output.= str_repeat(md5($sl), mt_rand(10, 100));
$output.= str_repeat($output, mt_rand(1, 25));

echo $output;
?>