<?php

set_include_path(__DIR__ . '/../../');

require_once 'src/helpers/define-environment.php';
define_environment('web');

require_once('src/app.php');
