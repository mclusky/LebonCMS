<?php ob_start();?>
<?php

$db['db_host'] = 'localhost';
$db['db_user'] = 'root';
$db['db_pass'] = '@dmin_php2018$';
$db['db_name'] = 'cms';

foreach ($db as $key => $val) {
	define(strtoupper($key), $val);
}

$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if (mysqli_connect_errno()) {
	die('Connection failed' . mysqli_connect_errno());
}

?>