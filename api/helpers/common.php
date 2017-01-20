<?php

require '../vendor/autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;

$dotenv = new Dotenv\Dotenv(__DIR__ . '/../../');
$dotenv->load();

define('APP_AUTH', getenv('APP_AUTH'));
