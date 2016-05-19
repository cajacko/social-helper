<?php

require_once('../models/database.php');
require_once('../models/user.php');

$user = new User($db, $twitter);

if($user = $user->login_user()) {
    print_r($user);
} elseif($user = $user->register_user()) {
    print_r($user);
} else {
    echo 'error doing anything';
}
