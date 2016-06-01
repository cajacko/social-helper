<?php

// Load twig templating engine
Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('../views');
$twig = new Twig_Environment($loader);
$template_path = 'layouts/';

session_start();

$user = new \SocialHelper\User\User($config, $db);
$twitter = new \SocialHelper\Twitter\Twitter($config, $db);

$request = $_GET['url'];
$request = explode('/', $request);

$vars = array('config' => $config);

if (isset($request[0], $request[1]) && 'twitter' == $request[0] && 'callback' == $request[1]) {
    require_once('src/routes/twitter-callback.php');
} else {
    require_once('src/routes/home.php');
}

ob_start("ob_gzhandler");

$template = $twig->loadTemplate($template_path . '.twig');
$content = $template->render(array('vars' => $vars));
echo $content;
