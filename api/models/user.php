<?php

require_once('db.php');
require_once('../helpers/error-response.php');

class User_Model {
  public static function get_user_id_by_email($email) {
    $query = '
      SELECT id
      FROM users
      WHERE email = ?
    ';

    $params = array(
      array('s', $email)
    );

    $row = Db::get_only_row($query, $params);

    if ($row && $row['id']) {
      return $row['id'];
    }

    return false;
  }

  public static function get_password_by_user_id($id) {
    $query = '
      SELECT password
      FROM users
      WHERE id = ?
    ';

    $params = array(
      array('i', $id)
    );

    $row = Db::get_only_row($query, $params);

    if ($row && $row['password']) {
      return $row['password'];
    }

    return false;
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

    return Db::get_only_row($query, $params);
  }

  public static function set_user($email, $password, $cron) {
    $query = '
      INSERT INTO users (email, password, cron)
      VALUES (?, ?, ?)
    ';

    $params = array(
      array('s', $email),
      array('s', $password),
      array('s', $cron)
    );

    if (Db::query($query, $params)) {
      return true;
    }

    return error_response(35);
  }
}
