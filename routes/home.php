<?php

require_once('../models/user.php');
require_once('../models/database.php');
require_once('../models/twitter.php');

$twitter = new Twitter($config->config);
$user = new User($db, $twitter);

// if($user->is_user_logged_in()) {
    $template_path .= 'home';
    // print_r($_SESSION);
    // session_destroy();

    $vars['tags'] = array(
        array('tag' => 'iot', 'id' => 234),
        array('tag' => 'internetofthings', 'id' => 152),
        array('tag' => 'entrepreneurship', 'id' => 456),
        array('tag' => 'startup', 'id' => 223),
        array('tag' => 'improv', 'id' => 789),
    );

    $vars['links'] = array(
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
    );
/*} else {
    header('Location: /twitter/login');
    exit;
}*/
