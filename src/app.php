<?php

require 'vendor/autoload.php';
require 'src/models/config.php';
$config = new SocialHelper\Config\Config;
$config = $config->getConfig();
require 'src/models/database.php';
require 'src/models/user.php';
require 'src/models/twitter.php';
