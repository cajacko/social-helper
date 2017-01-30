<?php

require_once('db.php');

class Queries_Model {
  public static function get_queries() {
    $query = '
      SELECT *
      FROM queries
      ORDER BY last_started_cron ASC
    ';

    return Db::get_rows($query);
  }
}
