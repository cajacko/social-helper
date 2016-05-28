<?php

date_default_timezone_set('Europe/London');

require_once 'src/helpers/error.php';
require_once 'vendor/autoload.php';

require_once 'src/models/config.php';
$config = new SocialHelper\Config\Config;
$config = $config->getConfig();

require_once 'src/models/database.php';
$db = new SocialHelper\DB\Database($config);
$db = $db->connect();

require_once 'src/models/user.php';
require_once 'src/models/twitter.php';

require_once 'routes/index.php';
