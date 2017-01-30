<?php

require_once(dirname(__FILE__) . '/../models/tweets.php');
require_once(dirname(__FILE__) . '/../controllers/tweet.php');
require_once(dirname(__FILE__) . '/../controllers/tweet-query.php');

class Tweets_Controller {
  private $tweets = array();
  private $query = false;

  public function delete_old_tweets() {
    $date = date('Y-m-d H:i:s', strtotime('1 week ago'));

    if (Tweets_Model::delete_tweets_older_than($date)) {
      $tweet_queries = new Tweet_Query_Controller;
      $tweet_queries->delete_floating_rows();
    }
  }

  public function get_tweets($query = false) {
    if ($query) {
      $this->query = $query;
      $query_string = $this->query->get_query();

      $tweets = Tweets_Model::get_tweets_by_query($query_string);

      foreach($tweets as $tweet_data) {
        $tweet = new Tweet_Controller;
        $tweet->initialise($tweet_data, $query);
        $this->tweets[] = $tweet;
      }
    }

    return $this->tweets;
  }

  public function save_tweets() {
    foreach ($this->tweets as $tweet) {
      if ($tweet->exists()) {
        $tweet->update();

        if (!$tweet->query->exists()) {
          $tweet->query->create();
        }
      } else {
        $tweet->create();
        $tweet->query->create();
      }
    }
  }
}
