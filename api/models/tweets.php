<?php

// require_once('db.php');
require_once('twitter.php');

class Tweets_Model {
  private $tweets = false;

  public static function get_tweets_by_query($query) {
    $twitter = new Twitter_Model;
    $twitter->initialise_app();
    return $twitter->get_tweets_by_query($query);
  }
}
