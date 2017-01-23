<?php

require_once('db.php');
require_once('../helpers/error-response.php');

class Cron_Model {
  public static function get_user_cron($user_id) {
    $query = '
      SELECT cron
      FROM users
      WHERE id = ?
    ';

    $params = array(
      array('i', $user_id)
    );

    return Db::get_only_row($query, $params);
  }

  public static function set_user_cron($user_id, $cron) {
    $query = '
      UPDATE users
      SET cron = ?
      WHERE id = ?
    ';

    $params = array(
      array('s', $cron),
      array('i', $user_id)
    );

    return Db::query($query, $params);
  }
}
