<?php

// require_once('db.php');
require_once('twitter.php');

class Tweets_Model {
  public static function get_tweets_by_query($query) {
    $twitter = new Twitter_Model;
    $twitter->initialise_app();
    return $twitter->get_tweets_by_query($query);
  }

  public static function delete_tweets_older_than($date) {
    $query = '
      DELETE tweets FROM tweets
      LEFT JOIN account_tweets
      ON tweets.id = account_tweets.tweet_id
      WHERE account_tweets.account_id IS NULL AND tweets.added_to_database < ?
    ';

    $params = array(
      array('s', $date)
    );

    return Db::query($query, $params);
  }
}
