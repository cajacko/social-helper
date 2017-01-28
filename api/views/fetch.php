<?php

define('CRON', true);

require_once('../helpers/common.php');
require_once('../controllers/queries.php');

$queries = new Queries_Controller;
$queries->save_new_tweets();
