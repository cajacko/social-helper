<?php

require_once('db.php');

class Tweet_Query_Model {
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
}
