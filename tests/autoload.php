<?php

set_include_path(__DIR__ . '/..');
error_reporting(E_ALL | E_STRICT);

require_once 'src/helpers/define-environment.php';
define_environment('tdd');

require_once 'src/helpers/error.php';
require_once 'vendor/autoload.php';
require_once 'src/models/config.php';
require_once 'src/models/database.php';
require_once 'src/models/user.php';
require_once 'src/models/twitter.php';
require_once 'src/models/tags.php';
