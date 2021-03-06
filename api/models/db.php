<?php

// mysqli_report(MYSQLI_REPORT_ALL);

require_once(dirname(__FILE__) . '/../helpers/error-response.php');

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

  public static function query($query = false, $params = false) {
    if (!$query) {
      return error_response(31);
    }

    $stmt = self::$connection->prepare($query);

    if (!$stmt) {
      return error_response(32, array(
        self::$connection->error,
        $query,
        $params
      ));
    }

    if ($params && count($params)) {
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
      return error_response(34, array(
        'query' => $query,
        'params' => $params,
        'stmt' => $stmt
      ));
    }

    return $stmt;
  }

  public static function row_exists($query = false, $params = false) {
    $res = self::query($query, $params)->get_result();

    if (!$res->num_rows) {
      return false;
    }

    return true;
  }

  public static function get_only_row($query = false, $params = false) {
    $res = self::query($query, $params)->get_result();

    if (!$res->num_rows) {
      return false;
    }

    if ($res->num_rows > 1) {
      return error_response(36);
    }

    return $res->fetch_assoc();
  }

  public static function get_rows($query = false, $params = false) {
    $res = self::query($query, $params)->get_result();
    $rows = array();

    while($row = $res->fetch_assoc()) {
      $rows[] = $row;
    }

    return $rows;
  }

  public static function insert_return_id($query = false, $params = false) {
    if(!self::query($query, $params)->get_result()) {
      return error_response(46);
    }

    return self::$connection->lastInsertId();
  }

  public static function insert_return_row($query = false, $params = false, $table) {
    $stmt = self::query($query, $params);

    if(!$stmt) {
      return error_response(55);
    }

    $insert_id = $stmt->insert_id;

    if(!$insert_id) {
      return error_response(68);
    }

    $query = '
      SELECT *
      FROM ' . $table . '
      WHERE id = ?
    ';

    $params = array(
      array('i', $insert_id)
    );

    return self::get_only_row($query, $params);
  }
}

Db::open_connection();
