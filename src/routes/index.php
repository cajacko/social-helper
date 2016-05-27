<?php

$user = new \SocialHelper\User\User;
$twitter = new \SocialHelper\Twitter\Twitter($config, $db);

if (!$user->isLoggedIn()) {
    if ($redirect = $twitter->getLoginUrl()) {
        header('Location: ' . $redirect);
        exit;
    } else {
        new \SocialHelper\Error\Error(1); // Bad redirect url, display error page
        exit;
    }
} else {
    echo 'Logged in';
}
