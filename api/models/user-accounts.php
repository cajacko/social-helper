<?php

require_once('db.php');

class User_Accounts_Model {
  public static function get_accounts_by_user_id($user_id) {
    $query = '
      SELECT accounts.*
      FROM user_accounts
      INNER JOIN accounts
      ON accounts.id = user_accounts.account_id
      WHERE user_id = ?
    ';

    $params = array(
      array('i', $user_id)
    );

    return Db::get_rows($query, $params);
  }

  public static function user_account_exists($user_id, $account_id) {
    $query = '
      SELECT *
      FROM user_accounts
      WHERE user_id = ? AND account_id = ?
    ';

    $params = array(
      array('i', $user_id),
      array('i', $account_id)
    );

    return Db::row_exists($query, $params);
  }

  public static function create_user_account($user_id, $account_id) {
    $query = '
      INSERT INTO user_accounts (user_id, account_id)
      VALUES (?, ?)
    ';

    $params = array(
      array('i', $user_id),
      array('i', $account_id)
    );

    return Db::query($query, $params);
  }
}
