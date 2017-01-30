<?php

define('CRON', true);

require_once(dirname(__FILE__) . '/../helpers/common.php');
require_once(dirname(__FILE__) . '/../controllers/tweets.php');
require_once(dirname(__FILE__) . '/../controllers/user-tokens.php');

$tweets = new Tweets_Controller;
$tweets->delete_old_tweets();

$user_tokens = new User_Tokens_Controller;
$user_tokens->delete_expired_tokens();
