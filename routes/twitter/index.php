<?php

if(isset($request[1])) {
    require_once('../models/twitter.php');
    $twitter = new Twitter($config->config);

    switch($request[1]) {
        case 'login':
            require_once('login.php');
            break;
        case 'callback':
            require_once('callback.php');
            break;
        default:
    }
} else {

}
