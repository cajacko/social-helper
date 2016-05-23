<?php

set_include_path(__DIR__ . '/..');

require_once('models/config.php');
$config = new Config;
require_once('models/database.php');
require_once('models/links.php');

$links = new Links($db, $config->config);
$links->process_links();

?>