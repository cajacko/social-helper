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
    $template_path .= 'home';
}
