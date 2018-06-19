<?php ob_start();?>
<?php

$db['db_host'] = 'ams10.siteground.eu';
$db['db_user'] = 'chrisleb_Chris';
$db['db_pass'] = '@php_Learning';
$db['db_name'] = 'chrisleb_demo_cms_db';

foreach ($db as $key => $val) {
	define(strtoupper($key), $val);
}

$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if (mysqli_connect_errno()) {
	die('Connection failed' . mysqli_connect_errno());
}

$query = "SET NAMES utf8";
mysqli_query($connection, $query);

?>
