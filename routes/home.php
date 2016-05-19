<?php

require_once('../models/user.php');
require_once('../models/database.php');
require_once('../models/twitter.php');

$twitter = new Twitter($config->config);
$user = new User($db, $twitter);

// if($user->is_user_logged_in()) {
    $template_path .= 'home';
    // print_r($_SESSION);
    // session_destroy();
/*} else {
    header('Location: /twitter/login');
    exit;
}*/
