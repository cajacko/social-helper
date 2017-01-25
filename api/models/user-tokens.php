<?php

require_once('db.php');

class User_Tokens_Model {
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

  public static function get_user_by_token($token) {
    $query = '
      SELECT users.*
      FROM auth_tokens
      INNER JOIN users
      ON users.id = auth_tokens.user_id
      WHERE auth_tokens.token = ?
    ';

    $params = array(
      array('s', $token)
    );

    return Db::get_only_row($query, $params);
  }
}
