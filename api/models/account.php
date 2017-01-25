<?php

require_once('db.php');
require_once('../helpers/error-response.php');

class Account_Model {
  public static function get_user_accounts($user_id) {
    $query = '
      SELECT *
      FROM user_accounts
      WHERE user_id = ?
    ';

    $params = array(
      array('i', $user_id)
    );

    return Db::get_rows($query, $params);
  }

  public static function does_user_account_exist($user_id, $account_username) {
    $query = '
      SELECT *
      FROM accounts
      INNER JOIN ON user_accounts
      WHERE user_accounts.account_id = accounts.id
        AND user_accounts.user_id = ?
        AND accounts.username = ?
    ';

    $params = array(
      array('i', $user_id),
      array('s', $account_username)
    );

    return Db::row_exists($query, $params);
  }

  public static function create_user_account($user_id, $token, $secret, $username) {
    return false;
  }

  public static function update_user_account($user_id, $token, $secret, $username) {
    return false;
  }
}
