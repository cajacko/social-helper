<?php

require_once(dirname(__FILE__) . '/../models/tweet-query.php');

class Tweet_Query_Controller {
  private $tweet = false;
  private $query = false;

  public function delete_floating_rows() {
    return Tweet_Query_Model::delete_floating_rows();
  }

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

  public function get_query_tweets($account_id, $offset = 0) {
    $tweets = Tweet_Query_Model::get_tweets(
      $account_id,
      $this->query->get_id(),
      $offset
    );

    if (!$tweets) {
      return false;
    }

    $tweet_array = array();

    foreach($tweets as $tweet_data) {
      $tweet = new Tweet_Controller;
      $tweet->initialise_from_db($tweet_data);
      $tweet_array[] = $tweet;
    }

    return $tweet_array;
  }

  public function set_query($query) {
    $this->query = $query;
  }

  public function set_tweet($tweet) {
    $this->tweet = $tweet;
  }
}
