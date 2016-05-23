<?php

$fp = fopen("process_links.txt", "w+");

if (flock($fp, LOCK_EX | LOCK_NB)) { // do an exclusive lock
    set_include_path(__DIR__ . '/..');

    require_once('models/config.php');
    $config = new Config;
    require_once('models/database.php');
    require_once('models/links.php');

    $links = new Links($db, $config->config);
    $links->process_links();

    flock($fp, LOCK_UN); // release the lock
} else {
    echo "Couldn't get the lock!";
}

fclose($fp);

?>