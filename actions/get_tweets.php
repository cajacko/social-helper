<?php

require_once('../models/config.php');
$config = new Config;
require_once('../models/database.php');
require_once('../models/twitter.php');

$twitter = new Twitter($db, $config->config);
$twitter->save_new_tweets();

?>