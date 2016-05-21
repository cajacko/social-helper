<?php

require_once('../vendor/autoload.php');

// Load twig templating engine
Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('../views');
$twig = new Twig_Environment($loader);

$template_path = 'templates/';

session_start();

$request = $_GET['url'];
$request = explode('/', $request);
$vars = array();

if(isset($request[0])) {
    switch($request[0]) {
        case 'twitter':
            require_once('twitter/index.php');
            break;
        case 'action':
            require_once('action.php');
            break;
        default:
            require_once('home.php');
    }
} else {
    require_once('home.php');
}

ob_start("ob_gzhandler");

$template = $twig->loadTemplate($template_path . '.twig');
$content = $template->render(array('vars' => $vars));
echo $content;