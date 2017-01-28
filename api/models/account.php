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

  public static function get_account_by_twitter_id($twitter_id) {
    $query = '
      SELECT *
      FROM accounts
      WHERE twitter_id = ?
    ';

    $params = array(
      array('s', $twitter_id)
    );

    return Db::get_only_row($query, $params);
  }

  public static function get_account_by_id($account_id) {
    $query = '
      SELECT *
      FROM accounts
      WHERE id = ?
    ';

    $params = array(
      array('i', $account_id)
    );

    return Db::get_only_row($query, $params);
  }

  public static function update_account($id, $token, $secret, $username) {
    $query = '
      UPDATE accounts
      SET token = ?, secret = ?, username = ?
      WHERE id = ?
    ';

    $params = array(
      array('s', $token),
      array('s', $secret),
      array('s', $username),
      array('i', $id)
    );

    if (!Db::query($query, $params)) {
      return false;
    }

    $query = '
      SELECT *
      FROM accounts
      WHERE id = ?
    ';

    $params = array(
      array('i', $id)
    );

    return Db::get_only_row($query, $params);
  }

  public static function create_account(
    $token,
    $secret,
    $username,
    $twitter_id,
    $cron
  ) {
    $query = '
      INSERT INTO accounts (token, username, secret, twitter_id, cron)
      VALUES (?, ?, ?, ?, ?)
    ';

    $params = array(
      array('s', $token),
      array('s', $username),
      array('s', $secret),
      array('s', $twitter_id),
      array('s', $cron)
    );

    return Db::insert_return_row($query, $params, 'accounts');
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
      DELETE FROM accounts
      WHERE id = ?
    ';

    $params = array(
      array('i', $account_id)
    );

    return Db::query($query, $params);
  }
}
