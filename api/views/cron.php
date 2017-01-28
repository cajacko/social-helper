<?php

define('CRON', true);

require_once('../helpers/common.php');
require_once('../controllers/accounts.php');

$accounts = new Accounts_Controller;
$accounts->tweet_from_accounts();
