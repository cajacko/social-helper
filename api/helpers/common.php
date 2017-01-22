<?php

require '../vendor/autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;

$dotenv = new Dotenv\Dotenv(__DIR__ . '/../../');
$dotenv->load();

define('APP_AUTH', getenv('APP_AUTH'));
define('MYSQL_DATABASE', getenv('MYSQL_DATABASE'));
define('MYSQL_USER', getenv('MYSQL_USER'));
define('MYSQL_PASSWORD', getenv('MYSQL_PASSWORD'));

var_dump(MYSQL_DATABASE);
var_dump(MYSQL_USER);
var_dump(MYSQL_PASSWORD);
