<?php

require_once('db.php');
require_once('../helpers/error-response.php');

class User_Model {
  public static function get_user_id_by_email($email) {
    return false;
    // return '3987tyf98uy498';
  }

  public static function get_password_by_user_id($id) {
    return 'password';
  }

  public static function get_user_by_email($email) {
    $query = '
      SELECT *
      FROM users
      WHERE email = ?
    ';

    $params = array(
      array('s', $email)
    );

    return Db::row_exists($query, $params);
  }

  public static function set_user($email, $password) {
    $query = '
      INSERT INTO users (email, password)
      VALUES (?, ?)
    ';

    $params = array(
      array('s', $email),
      array('s', $password)
    );

    if (Db::query($query, $params)) {
      return true;
    }

    return error_response(35);
  }
}
