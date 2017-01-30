<?php

define('CRON', true);

require_once(dirname(__FILE__) . '/../helpers/common.php');
require_once(dirname(__FILE__) . '/../controllers/queries.php');

$queries = new Queries_Controller;
$queries->save_new_tweets();
