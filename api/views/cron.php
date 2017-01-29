<?php

define('CRON', true);

require_once(dirname(__FILE__) . '/../helpers/common.php');
require_once(dirname(__FILE__) . '/../controllers/accounts.php');

logger(false, false, 'Run cron.php');

$accounts = new Accounts_Controller;
$accounts->tweet_from_accounts();
