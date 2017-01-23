<?php

require_once('db.php');
require_once('../helpers/error-response.php');

class Token_Model {
  public static function set_user_token($user_id, $token, $expires) {
    $query = '
      INSERT INTO auth_tokens (user_id, token, expires)
      VALUES (?, ?, ?)
    ';

    $params = array(
      array('i', $user_id),
      array('s', $token),
      array('s', $expires)
    );

    return Db::query($query, $params);
  }

  public static function get_token($token) {
    $query = '
      SELECT user_id, expires
      FROM auth_tokens
      WHERE token = ?
    ';

    $params = array(
      array('s', $token)
    );

    return Db::get_only_row($query, $params);
  }
}
