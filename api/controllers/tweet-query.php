<?php

// require_once('../models/tweet-query.php');

class Tweet_Query {
  private $tweet = false;
  private $query = false;

  public function exists() {
    echo "\n tweet query exists \n";
    return false;
  }

  public function create() {
    echo "\n tweet query create \n";
    return false;
  }

  public function set_query($query) {
    $this->query = $query;
  }

  public function set_tweet($tweet) {
    $this->tweet = $tweet;
  }
}
