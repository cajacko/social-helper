<?php

require_once('db.php');
require_once('../helpers/error-response.php');

class Account_Model {
  // delete_user_account
  // get_account_by_username
  // create_user_account
  // get_user_account
  //

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

  public static function get_account_id($user_id, $account_username) {
    $query = '
      SELECT accounts.id
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

    $row = Db::get_only_row($query, $params);

    if (!$row) {
      return false;
    }

    return $row['id']
  }

  public static function create_user_account($user_id, $token, $secret, $username) {
    $query = '
      INSERT INTO accounts (token, username, secret)
      VALUES (?, ?, ?)
    ';

    $params = array(
      array('s', $token),
      array('s', $username),
      array('s', $secret)
    );

    $account_id = Db::insert_return_id($query, $params);

    if (!$account_id) {
      return error_response(47);
    }

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

  public static function update_user_account($user_id, $token, $secret, $username) {
    $query = '
      UPDATE *
      FROM accounts
    ';

    $params = array(
      array('i', $user_id),
      array('i', $account_id)
    );

    return Db::query($query, $params);
  }

  public static function delete($account_id) {
    // TODO: ON DELETE CASCADE EVEERYWHERE
    $query = '
      DELETE *
      FROM accounts
      WHERE accounts.id = ?
    ';

    $params = array(
      array('i', $account_id)
    );

    return Db::query($query, $params));
  }
}
