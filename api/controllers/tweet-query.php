<?php

require_once('../models/tweet-query.php');

class Tweet_Query {
  private $tweet = false;
  private $query = false;

  public function exists() {
    return Tweet_Query_Model::exists(
      $this->tweet->get_id(),
      $this->query->get_id()
    );
  }

  public function create() {
    return Tweet_Query_Model::create(
      $this->tweet->get_id(),
      $this->query->get_id()
    );
  }

  public function set_query($query) {
    $this->query = $query;
  }

  public function set_tweet($tweet) {
    $this->tweet = $tweet;
  }
}
