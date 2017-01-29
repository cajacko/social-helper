<?php

require_once('db.php');

class Query_Model {
  public static function set_last_started_cron($date, $query_id) {
    $query = '
      UPDATE queries
      SET last_started_cron = ?
      WHERE id = ?
    ';

    $params = array(
      array('s', $date),
      array('s', $query_id)
    );

    return Db::query($query, $params);
  }

  public static function set_last_ran_cron($date, $query_id) {
    $query = '
      UPDATE queries
      SET last_ran_cron = ?
      WHERE id = ?
    ';

    $params = array(
      array('s', $date),
      array('s', $query_id)
    );

    return Db::query($query, $params);
  }

  public static function get_query_by_value($query_string) {
    $query = '
      SELECT *
      FROM queries
      WHERE query = ?
    ';

    $params = array(
      array('s', $query_string)
    );

    return Db::get_only_row($query, $params);
  }

  public static function create_query($query_string) {
    $query = '
      INSERT INTO queries (query)
      VALUES (?)
    ';

    $params = array(
      array('s', $query_string)
    );

    return Db::insert_return_row($query, $params, 'queries');
  }
}
