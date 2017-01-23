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
}
