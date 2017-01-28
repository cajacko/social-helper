<?php

require_once('db.php');
require_once('twitter.php');

class Account_Tweets_Model {
  public static function get_query_ids_by_lowest_tweet_count($account_id, $count, $earliest_date = false) {
    $query = '
      SELECT *
      FROM account_tweets
      WHERE account_id = ?
      LIMIT 0, ?
    ';

    $params = array(
      array('i', $account_id),
      array('i', $count)
    );

    return Db::get_rows($query, $params);
  }

  public static function retweet($tweet_id, $user_token, $user_secret) {
    $twitter = new Twitter_Model;
    $twitter->initialise_user($user_token, $user_secret);
    return $twitter->retweet($tweet_id);
  }

  public static function set_account_tweet($account_id, $tweet_id, $query_id, $date, $error = 0) {
    $query = '
      INSERT INTO account_tweets (account_id, tweet_id, query_id, date_tweeted, error)
      VALUES (?, ?, ?, ?, ?)
    ';

    $params = array(
      array('i', $account_id),
      array('i', $tweet_id),
      array('i', $query_id),
      array('s', $date),
      array('i', $error)
    );

    return Db::query($query, $params, 'accounts');
  }
}
