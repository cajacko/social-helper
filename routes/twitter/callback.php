<?php

require_once('models/database.php');
require_once('models/user.php');

$user = new User($db, $twitter);
$tokens = $twitter->get_tokens();

if(isset($tokens['oauth_token'], $tokens['oauth_token_secret'], $tokens['user_id'])) {
    if($user_id = $user->does_user_exist($tokens['user_id'])) {
        $user->update_tokens($user_id, $tokens['oauth_token'], $tokens['oauth_token_secret']);
    } else {
        $user_id = $user->register($tokens['user_id'], $tokens['oauth_token'], $tokens['oauth_token_secret']);
    }

    $user->login($user_id, $tokens['oauth_token'], $tokens['oauth_token_secret']);
    header('Location: /');
    exit;
} else {
    echo 'tokens not set';
    exit;
}