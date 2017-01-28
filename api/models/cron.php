<?php

require_once('db.php');

class Cron_Model {
  public static function set_account_cron($account_id, $cron) {
    $query = '
      UPDATE accounts
      SET cron = ?
      WHERE id = ?
    ';

    $params = array(
      array('s', $cron),
      array('i', $account_id)
    );

    return Db::query($query, $params);
  }
}
