<?php

require_once('../models/tweet-query.php');

class Tweet_Query_Controller {
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

  public function get_query_tweets($before_id = false) {
    if ($before_id) {
      $tweets = Tweet_Query_Model::get_tweets_before_id(
        $this->query->get_id(),
        $before_id
      );
    } else {
      $tweets = Tweet_Query_Model::get_tweets($this->query->get_id());
    }

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
