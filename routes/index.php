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

if(isset($request[0])) {
    switch($request[0]) {
        case 'twitter':
            require_once('twitter/index.php');
            break;
        default:
            require_once('home.php');
    }
} else {
    require_once('home.php');
}

ob_start("ob_gzhandler");

$vars = array(
    'tags' => array(
        array('tag' => 'iot', 'id' => 234),
        array('tag' => 'internetofthings', 'id' => 152),
        array('tag' => 'entrepreneurship', 'id' => 456),
        array('tag' => 'startup', 'id' => 223),
        array('tag' => 'improv', 'id' => 789),
    ),
    'links' => array(
        array(
            'url' => 'http://apple.com',
            'id' => 3890,
            'tweets' => array(
                array(
                    'tweet' => 'I&#39;ve had pizza and red wine for every dinner so far this week. How am I going to cope this evening?! 🍷🍕',
                    'user' => 'Viki Bell',
                    'username' => 'Vikiibell',
                    'url' => 'https://twitter.com/Vikiibell/status/732988506092507137',
                    'date' => 'May 18, 2016',
                    'id' => 49863,
                ),
                array(
                    'tweet' => 'I&#39;ve had pizza and red wine for every dinner so far this week. How am I going to cope this evening?! 🍷🍕',
                    'user' => 'Viki Bell',
                    'username' => 'Vikiibell',
                    'url' => 'https://twitter.com/Vikiibell/status/732988506092507137',
                    'date' => 'May 18, 2016',
                    'id' => 49863,
                ),
            ),
        ),
        array(
            'url' => 'http://apple.com',
            'id' => 4521,
            'tweets' => array(
                array(
                    'tweet' => 'I&#39;ve had pizza and red wine for every dinner so far this week. How am I going to cope this evening?! 🍷🍕',
                    'user' => 'Viki Bell',
                    'username' => 'Vikiibell',
                    'url' => 'https://twitter.com/Vikiibell/status/732988506092507137',
                    'date' => 'May 18, 2016',
                    'id' => 49863,
                ),
                array(
                    'tweet' => 'I&#39;ve had pizza and red wine for every dinner so far this week. How am I going to cope this evening?! 🍷🍕',
                    'user' => 'Viki Bell',
                    'username' => 'Vikiibell',
                    'url' => 'https://twitter.com/Vikiibell/status/732988506092507137',
                    'date' => 'May 18, 2016',
                    'id' => 49863,
                ),
            ),
        ),
    ),
);

$template = $twig->loadTemplate($template_path . '.twig');
$content = $template->render(array('vars' => $vars));
echo $content;