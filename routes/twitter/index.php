<?php

if(isset($request[1])) {
    require_once('models/database.php');
    require_once('models/twitter.php');
    $twitter = new Twitter($db, $config->config);

    switch($request[1]) {
        case 'login':
            require_once('routes/twitter/login.php');
            break;
        case 'callback':
            require_once('routes/twitter/callback.php');
            break;
        default:
    }
} else {

}
