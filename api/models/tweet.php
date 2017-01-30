<?php

require_once('db.php');
require_once('twitter.php');

class Tweet_Model {
  private $tweets = false;

  public static function get_tweets_by_query($query) {
    $twitter = new Twitter_Model;
    $twitter->initialise_app();
    return $twitter->get_tweets_by_query($query);
  }

  public function tweet_exists($tweet_id) {
    $query = '
      SELECT *
      FROM tweets
      WHERE tweet_id = ?
    ';

    $params = array(
      array('s', $tweet_id)
    );

    return Db::get_only_row($query, $params);
  }

  public function create($tweet_id, $created, $retweets, $favourites, $user_id, $json) {
    $query = '
      INSERT INTO tweets (tweet_id, created, retweets, favourites, user_id, tweet)
      VALUES (?, ?, ?, ?, ?, ?)
    ';

    $params = array(
      array('s', $tweet_id),
      array('s', $created),
      array('i', $retweets),
      array('i', $favourites),
      array('s', $user_id),
      array('s', $json)
    );

    return Db::insert_return_row($query, $params, 'tweets');
  }

  public function update($tweet_id, $created, $retweets, $favourites, $user_id, $json) {
    $query = '
      UPDATE tweets
      SET created = ?, retweets = ?, favourites = ?, user_id = ?, tweet = ?
      WHERE tweet_id = ?
    ';

    $params = array(
      array('s', $created),
      array('i', $retweets),
      array('i', $favourites),
      array('s', $user_id),
      array('s', $json),
      array('s', $tweet_id)
    );

    return Db::query($query, $params);
  }
}
