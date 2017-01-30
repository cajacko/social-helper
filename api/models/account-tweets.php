<?php

require_once('db.php');
require_once('twitter.php');

class Account_Tweets_Model {
  public function delete_floating_rows() {
    $query = '
      DELETE account_tweets
      FROM account_tweets
      LEFT JOIN accounts
      ON account_tweets.account_id = accounts.id
      WHERE accounts.id IS NULL OR account_tweets.id IS NULL
    ';

    return Db::query($query, false);
  }

  public static function get_last_account_tweet($account_id) {
    $query = '
      SELECT *
      FROM account_tweets
      WHERE account_id = ? AND error = 0
      ORDER BY date_tweeted DESC
      LIMIT 0, 1
    ';

    $params = array(
      array('i', $account_id)
    );

    return Db::get_only_row($query, $params);
  }

  public static function get_query_ids_by_lowest_tweet_count($account_id, $count, $earliest_date = false) {
    $query = '
      SELECT count(*) as count, t.query_id
      FROM (
        SELECT *
        FROM account_tweets
        WHERE account_id = ? AND error = 0
        ORDER BY date_tweeted DESC
        LIMIT 0, ?
      ) t
      GROUP BY t.query_id
      ORDER BY count ASC
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

  public static function does_account_tweet_exist($tweet_id, $account_id) {
    $query = '
      SELECT *
      FROM account_tweets
      WHERE account_id = ? AND tweet_id = ?
    ';

    $params = array(
      array('i', $account_id),
      array('i', $tweet_id)
    );

    return Db::row_exists($query, $params);
  }
}
