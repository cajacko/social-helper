<?php

$fp = fopen("get_tweets.txt", "w+");

if (flock($fp, LOCK_EX | LOCK_NB)) { // do an exclusive lock
    set_include_path(__DIR__ . '/..');

    require_once('models/config.php');
    $config = new Config;
    require_once('models/database.php');
    require_once('models/twitter.php');

    $twitter = new Twitter($db, $config->config);
    $twitter->save_new_tweets();

    flock($fp, LOCK_UN); // release the lock
} else {
    echo "Couldn't get the lock!";
}

fclose($fp);

?>