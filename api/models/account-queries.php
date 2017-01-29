<?php

require_once('db.php');

class Account_Queries_Model {
  public function delete_floating_rows() {
    $query = '
      DELETE account_queries
      FROM account_queries
      LEFT JOIN accounts
      ON account_queries.account_id = accounts.id
      WHERE accounts.id IS NULL OR account_queries.id IS NULL
    ';

    return Db::query($query, false);
  }

  public static function delete($account_id, $query_id) {
    $query = '
      DELETE FROM account_queries
      WHERE account_id = ? AND query_id = ?
    ';

    $params = array(
      array('i', $account_id),
      array('i', $query_id)
    );

    return Db::query($query, $params);
  }

  public static function account_query_exists($account_id, $query_id) {
    $query = '
      SELECT *
      FROM account_queries
      WHERE account_id = ? AND query_id = ?
    ';

    $params = array(
      array('i', $account_id),
      array('i', $query_id)
    );

    return Db::row_exists($query, $params);
  }

  public static function create_account_query($account_id, $query_id) {
    $query = '
      INSERT INTO account_queries (account_id, query_id)
      VALUES (?, ?)
    ';

    $params = array(
      array('i', $account_id),
      array('i', $query_id)
    );

    return Db::query($query, $params);
  }

  public function get_account_queries($account_id) {
    $query = '
      SELECT *
      FROM account_queries
      INNER JOIN queries
      ON account_queries.query_id = queries.id
      WHERE account_queries.account_id = ?
    ';

    $params = array(
      array('i', $account_id)
    );

    return Db::get_rows($query, $params);
  }
}
