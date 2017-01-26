<?php

require_once('db.php');

class Queries_Model {
  public static function get_queries() {
    $query = '
      SELECT *
      FROM queries
    ';

    return Db::get_rows($query);
  }
}
