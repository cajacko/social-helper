<?php

require_once('db.php');

class Account_Blacklist_Model {
  public static function delete($id) {
    $query = '
      DELETE FROM account_blacklist
      WHERE id = ?
    ';

    $params = array(
      array('i', $id)
    );

    return Db::query($query, $params);
  }

  public function get_blacklist_queries($account_id) {
    $query = '
      SELECT *
      FROM account_blacklist
      WHERE account_id = ?
    ';

    $params = array(
      array('i', $account_id)
    );

    return Db::get_rows($query, $params);
  }

  public static function create($account_id, $query_string) {
    $query = '
      INSERT INTO account_blacklist (account_id, query)
      VALUES (?, ?)
    ';

    $params = array(
      array('i', $account_id),
      array('s', $query_string)
    );

    return Db::query($query, $params);
  }
}
