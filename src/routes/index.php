<?php

session_start();

$user = new \SocialHelper\User\User($config, $db);
$twitter = new \SocialHelper\Twitter\Twitter($config, $db);

$request = $_GET['url'];
$request = explode('/', $request);

if (isset($request[0], $request[1]) && 'twitter' == $request[0] && 'callback' == $request[1]) {
    require_once('src/routes/twitter-callback.php');
} else {
    require_once('src/routes/home.php');
}
