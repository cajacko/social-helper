<?php

require_once('db.php');

class User_Accounts_Model {
  public static function get_accounts_by_user_id($user_id) {
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
}
