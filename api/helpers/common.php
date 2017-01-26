<?php

date_default_timezone_set('Europe/London');

require '../vendor/autoload.php';

$dotenv = new Dotenv\Dotenv(__DIR__ . '/../../');
$dotenv->load();

define('APP_AUTH', getenv('APP_AUTH'));
define('MYSQL_DATABASE', getenv('MYSQL_DATABASE'));
define('MYSQL_USER', getenv('MYSQL_USER'));
define('MYSQL_PASSWORD', getenv('MYSQL_PASSWORD'));

define('CONSUMER_KEY', getenv('CONSUMER_KEY'));
define('CONSUMER_SECRET', getenv('CONSUMER_SECRET'));
