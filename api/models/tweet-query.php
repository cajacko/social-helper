<?php

require_once('db.php');

class Tweet_Query_Model {
  public static function delete_floating_rows() {
    $query = '
      DELETE tweet_queries
      FROM tweet_queries
      LEFT JOIN tweets
      ON tweet_queries.tweet_id = tweets.id
      WHERE tweets.id IS NULL OR tweet_queries.id IS NULL
    ';

    return Db::query($query, false);
  }

  public static function create($tweet_id, $query_id) {
    $query = '
      INSERT INTO tweet_queries (tweet_id, query_id)
      VALUES (?, ?)
    ';

    $params = array(
      array('i', $tweet_id),
      array('i', $query_id)
    );

    return Db::query($query, $params);
  }

  public static function exists($tweet_id, $query_id) {
    $query = '
      SELECT *
      FROM tweet_queries
      WHERE tweet_id = ? AND query_id = ?
    ';

    $params = array(
      array('i', $tweet_id),
      array('i', $query_id)
    );

    return Db::row_exists($query, $params);
  }

  public static function get_tweets($account_id, $query_id, $offset = 0) {
    $query = '
      SELECT tweets.*
      FROM tweet_queries
      INNER JOIN tweets
      ON tweets.id = tweet_queries.tweet_id
      LEFT JOIN account_tweets
      ON account_tweets.tweet_id = tweets.id
      WHERE
        tweet_queries.query_id = ?
        AND (
          account_tweets.account_id != ?
          OR account_tweets.account_id IS NULL
        )
      ORDER BY retweets DESC, tweets.id DESC
      LIMIT ?, 25
    ';

    $params = array(
      array('i', $query_id),
      array('i', $account_id),
      array('i', $offset)
    );

    return Db::get_rows($query, $params);
  }
}
