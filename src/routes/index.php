<?php

// Load twig templating engine
Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('../views');
$twig = new Twig_Environment($loader);
$template_path = 'layouts/404';

session_start();

$user = new \SocialHelper\User\User($config, $db);
$twitter = new \SocialHelper\Twitter\Twitter($config, $db);

$request = $_GET['url'];
$request = explode('/', $request);

$vars = array('config' => $config);

if (isset($request[0]) && '' != $request[0]) {
    switch ($request[0]) {
        case 'twitter-callback':
            require_once('src/routes/twitter-callback.php');
            break;
        case 'action':
            require_once('src/routes/action/index.php');
            break;
        default:
            require_once('src/routes/404.php');
            break;
    }
} else {
    require_once('src/routes/home.php');
}

ob_start("ob_gzhandler");

if (isset($json)) {
    $json = json_encode($json);

    if ($json) {
        header('Content-Type: application/json');
        echo $json;
        exit;
    } else {

        exit;
    }
} else {
    $template = $twig->loadTemplate($template_path . '.twig');
    $content = $template->render(array('vars' => $vars));
    echo $content;
    exit;
}
