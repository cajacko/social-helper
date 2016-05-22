<?php

require_once('../models/user.php');
require_once('../models/database.php');
require_once('../models/twitter.php');

$twitter = new Twitter($db, $config->config);
$user = new User($db, $twitter);

if($user->is_user_logged_in()) {
    $template_path .= 'home';
    require_once('../models/tags.php');

    $tags = new Tags($db);
    $tags = $tags->get_user_tags();

    if($tags) {
        $vars['tags'] = $tags;
    }

    require_once('../models/links.php');

    $links = new Links($db, $config->config);
    $links = $links->get_top_links($_SESSION['id']);

    if($links) {
        $vars['links'] = $links;
    }
} else {
    header('Location: /twitter/login');
    exit;
}
