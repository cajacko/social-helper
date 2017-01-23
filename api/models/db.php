<?php

// mysqli_report(MYSQLI_REPORT_ALL);

require_once('../helpers/error-response.php');

class Db {
  private static $connection;

  public static function open_connection(){
    self::$connection = new mysqli(
      'social-helper-db:3306',
      MYSQL_USER,
      MYSQL_PASSWORD,
      MYSQL_DATABASE
    );

    if (self::$connection->connect_error) {
      return error_response(30);
    }
  }

  public static function query($query = false, $params = array()) {
    if (!$query) {
      return error_response(31);
    }

    $stmt = self::$connection->prepare($query);

    if (!$stmt) {
      return error_response(32);
    }

    if (count($params)) {
      $types = '';
      $bind_params = array();

      foreach($params as $param) {
        $types .= $param[0];
        $bind_params[] = & $param[1];
      }

      array_unshift($bind_params, $types);
      call_user_func_array(array($stmt, 'bind_param'), $bind_params);
    }

    if (!$stmt->execute()) {
      return error_response(34);
    }

    return $stmt;
  }

  public static function row_exists($query = false, $params) {
    $res = self::query($query, $params)->get_result();

    if (!$res->num_rows) {
      return false;
    }

    return true;
  }

  public static function get_only_row($query = false, $params) {
    $res = self::query($query, $params)->get_result();

    if (!$res->num_rows) {
      return false;
    }

    if ($res->num_rows > 1) {
      return error_response(36);
    }

    return $res->fetch_assoc();
  }

  public static function get_rows($query = false, $params) {
    $res = self::query($query, $params)->get_result();
    $rows = array();

    while($row = $res->fetch_assoc()) {
      $rows[] = $row;
    }

    return $rows;
  }
}

Db::open_connection();
