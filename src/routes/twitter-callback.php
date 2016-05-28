<?php

$tokens = $twitter->twitterLogin();

if (isset($tokens['error'])) {
    $error = $tokens;
    require_once('src/routes/error.php');
} elseif (isset($tokens)) {
    $twitter_id = $tokens['user_id'];

    if (!$user->isRegistered($twitter_id)) {
        $user->register($tokens);
    } else {
        $user->updateDetails($tokens);
    }

    $user->login();

    if ($config->dev && isset($request[2]) && 'tdd' == $request[2]) {
        echo json_encode($_SESSION);
    } else {
        header('Location: /');
        exit;
    }   
} else {
    $error = new \SocialHelper\Error\Error();
    $error = $error->getError(5);
    require_once('src/routes/error.php');
}
