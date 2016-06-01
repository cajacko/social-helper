<?php

if (!$user->isLoggedIn()) {
    if ($redirect = $twitter->getLoginUrl()) {
        header('Location: ' . $redirect);
        exit;
    } else {
        $error = new \SocialHelper\Error\Error(1); // Bad redirect url, display error page
        $error = $error->getError();
        require_once('src/routes/error.php');
    }
} else {
    $template_path = 'layouts/home';

    $vars['trackingTags'] = array(array('id' => 0, 'tag' => '', 'template' => true));

    require_once('src/models/tags.php');
    $tag = new \SocialHelper\Tags\Tag($config, $db);
    $tags = $tag->getUserTags($user->getUserId());

    if ($tags) {
        foreach ($tags as $array) {
            $vars['trackingTags'][] = $array;
        }
    }
}
