<?php

if (isset($request[1])) {
    switch ($request[1]) {
        case 'add-tracking-tag':
            require_once('src/models/tags.php');

            $tag = new \SocialHelper\Tags\Tag($config, $db);
            $json = $tag->addTag($user);
            break;
        default:
            require_once('src/routes/404.php');
            break;
    }
} else {
    require_once('src/routes/404.php');
}
